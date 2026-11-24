<?php
/*
UserSpice
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * Resolves the client IP address and request scheme for the whole framework.
 *
 * Contracts:
 *   get()      - the resolved client address. May be taken from a forwarded
 *                header, but only a header bound to the configured trusted
 *                proxy that the request actually came from. Use for logging,
 *                audit rows, rate limiting, ban matching, and an IP allowlist
 *                that is a second check on top of a secret.
 *   peer()     - the raw connection address (REMOTE_ADDR). Never header-derived.
 *                Use for an IP allowlist that is the only gate, where a
 *                spoofable value must never be trusted. cron.php picks between
 *                the two with settings.cron_ip_source.
 *   isLocal()  - true only for CLI, or a request whose connection is exactly
 *                127.0.0.1/::1, carries no forwarding headers, isn't from a
 *                configured proxy, and names a localhost Host. Fails closed:
 *                a same-server proxy, tunnel, or TLS terminator never counts.
 *                Extra dev hostnames can be allowed with
 *                define('US_LOCAL_HOSTS', ['us5.test']) in users/init.php.
 *   isHttps()  - proxy-aware scheme; forwarded proto headers are honored only
 *                from a trusted proxy.
 *   requestLooksHttps() - lenient scheme check for cookie flags only; safe to
 *                call from init.php before settings or the DB exist.
 *
 * Proxy configuration comes from usersc/includes/trusted_proxies.php when that
 * file exists, otherwise from the us_rate_limit_proxy_settings table plus the
 * settings.proxy_presets column. The two sources are never merged. With proxy
 * mode off, no database query is made and REMOTE_ADDR is returned untouched.
 *
 * Each trusted proxy is bound to the header(s) it is allowed to supply. A
 * header is read only when the connecting peer matches a binding that names
 * it, so a client cannot inject e.g. CF-Connecting-IP through an internal
 * load balancer that is trusted only for X-Forwarded-For.
 *
 * Forwarded lists are read one hop deep (the rightmost entry, written by the
 * proxy itself). A binding may set 'recursive' => true to keep walking left
 * past hops that are trusted for the same header (multi-proxy chains).
 * Loopback, unspecified, and link-local addresses are never accepted from a
 * header.
 */
class ClientIP
{
    private static $resolved = null;
    private static $proxied = false;
    private static $config = null;
    private static $cloudflare = null;

    /** Header-name prefixes whose presence means the request passed through a proxy. */
    private const FORWARDING_PREFIXES = [
        'HTTP_X_FORWARDED', 'HTTP_FORWARDED', 'HTTP_X_ORIGINAL_', 'HTTP_CF_',
        'HTTP_FASTLY_', 'HTTP_X_ENVOY_', 'HTTP_X_AZURE_', 'HTTP_X_ARR_',
    ];

    /** Exact header names whose presence means the request passed through a proxy. */
    private const FORWARDING_HEADERS = [
        'HTTP_X_REAL_IP', 'HTTP_TRUE_CLIENT_IP', 'HTTP_X_CLIENT_IP', 'HTTP_CLIENT_IP',
        'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_VIA', 'HTTP_CDN_LOOP', 'HTTP_X_PROXYUSER_IP',
    ];

    /** Never accepted from a forwarded header: loopback, unspecified, link-local. */
    private const NON_ROUTABLE = ['127.0.0.0/8', '::1', '0.0.0.0/8', '::', '169.254.0.0/16', 'fe80::/10'];

    /** Known presets. Values are expanded into bindings by expandPreset(). */
    public const PRESETS = [
        'cloudflare' => 'Cloudflare proxy (orange cloud): trust Cloudflare edge ranges for CF-Connecting-IP',
        'cloudflare_tunnel' => 'Cloudflare Tunnel (cloudflared on this server): trust loopback for CF-Connecting-IP',
    ];

    public static function get(): string
    {
        if (self::$resolved !== null) {
            return self::$resolved;
        }

        self::$proxied = false;
        $peer = self::peer();
        $config = self::config();

        if (!$config['enabled'] || empty($config['bindings'])) {
            return self::$resolved = $peer;
        }

        // Match bindings against the real connection address only; peer()'s
        // 127.0.0.1 stand-in for a missing/invalid REMOTE_ADDR must never
        // make a request look like it came from a trusted loopback proxy.
        $headers = self::headersForPeer(self::rawPeer(), $config['bindings']);
        foreach ($headers as $header => $recursive) {
            $hops = $recursive ? self::cidrsForHeader($config['bindings'], $header) : [];
            $candidate = self::walkForwarded(self::headerValue($header), $hops);
            if ($candidate !== null) {
                self::$proxied = true;
                return self::$resolved = $candidate;
            }
        }

        return self::$resolved = $peer;
    }

    public static function peer(): string
    {
        if (PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg') {
            return '127.0.0.1';
        }
        $addr = Server::get('REMOTE_ADDR');
        return ($addr === '' || $addr === null) ? '127.0.0.1' : $addr;
    }

    /**
     * The connection address exactly as received, or '' when it is missing or
     * not an IP (e.g. a unix socket). Unlike peer(), never substitutes
     * 127.0.0.1, so it is safe for trust decisions.
     */
    private static function rawPeer(): string
    {
        if (PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg') {
            return '';
        }
        $addr = (string)($_SERVER['REMOTE_ADDR'] ?? '');
        return filter_var($addr, FILTER_VALIDATE_IP) !== false ? $addr : '';
    }

    public static function isProxied(): bool
    {
        self::get();
        return self::$proxied;
    }

    /**
     * True when proxy mode is on and the connecting peer matches a binding.
     */
    public static function isTrustedPeer(): bool
    {
        $config = self::config();
        if (!$config['enabled'] || empty($config['bindings'])) {
            return false;
        }
        $raw = self::rawPeer();
        return $raw !== '' && self::isTrustedProxy($raw);
    }

    /**
     * Genuinely local request. Fails closed, because callers use it to grant
     * things (passwordless "localhost login", skipping TLS verification, cron
     * access). True only for CLI, or when all of these hold:
     *  - the connection is exactly 127.0.0.1 or ::1
     *  - no forwarding header of any kind is present
     *  - loopback is not configured as a trusted proxy (e.g. Cloudflare Tunnel)
     *  - the Host is a localhost name. A TLS terminator or TCP forwarder on
     *    this box (stunnel, nginx stream, ssh -R) adds no headers but keeps
     *    the visitor's public Host, so this catches it. Extra dev hostnames:
     *    define('US_LOCAL_HOSTS', ['us5.test']) in users/init.php.
     */
    public static function isLocal(): bool
    {
        if (PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg') {
            return true;
        }
        $addr = self::rawPeer();
        if ($addr === '' || !self::isLoopback($addr)) {
            return false;
        }
        if (self::hasForwardingHeaders()) {
            return false;
        }
        $config = self::config();
        if ($config['enabled'] && self::isTrustedProxy($addr)) {
            return false;
        }
        return self::hostIsLocal();
    }

    /** Exactly 127.0.0.1 or ::1 (including ::ffff:127.0.0.1). */
    public static function isLoopback(string $ip): bool
    {
        return self::inRange($ip, '127.0.0.1') || self::inRange($ip, '::1');
    }

    /** Whether the request carries any header a proxy, CDN, or tunnel adds. */
    public static function hasForwardingHeaders(): bool
    {
        foreach ($_SERVER as $key => $value) {
            if (is_string($key) && self::isForwardingKey($key) && (string)$value !== '') {
                return true;
            }
        }
        return false;
    }

    private static function isForwardingKey(string $key): bool
    {
        if (in_array($key, self::FORWARDING_HEADERS, true)) {
            return true;
        }
        foreach (self::FORWARDING_PREFIXES as $prefix) {
            if (strncmp($key, $prefix, strlen($prefix)) === 0) {
                return true;
            }
        }
        return false;
    }

    private static function hostIsLocal(): bool
    {
        $host = strtolower(trim((string)Server::get('HTTP_HOST', '')));
        // Drop the port: "localhost:8000" -> "localhost", "[::1]:8080" -> "::1"
        if (preg_match('/^\[([^\]]+)\](?::\d+)?$/', $host, $m)) {
            $host = $m[1];
        } elseif (substr_count($host, ':') === 1) {
            $host = substr($host, 0, strpos($host, ':'));
        }
        if ($host === '') {
            return false;
        }
        if (in_array($host, ['localhost', '127.0.0.1', '::1'], true) || substr($host, -10) === '.localhost') {
            return true;
        }
        if (defined('US_LOCAL_HOSTS')) {
            $extra = constant('US_LOCAL_HOSTS');
            $extra = is_array($extra) ? $extra : explode(',', (string)$extra);
            foreach ($extra as $name) {
                if (strtolower(trim((string)$name)) === $host) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * 'https' or 'http'. Forwarded proto headers count only from a trusted peer.
     */
    public static function scheme(): string
    {
        if (self::directHttps()) {
            return 'https';
        }
        if (self::isTrustedPeer()) {
            $proto = self::forwardedProto();
            if ($proto !== '') {
                return $proto;
            }
        }
        return ((int)Server::get('SERVER_PORT', 0) === 443) ? 'https' : 'http';
    }

    public static function isHttps(): bool
    {
        return self::scheme() === 'https';
    }

    /**
     * Lenient HTTPS check that trusts proto headers from anyone and reads no
     * configuration, so it is safe in init.php before settings exist. Only for
     * decisions where a spoofed "https" harms nobody but the spoofer, such as
     * the session cookie's Secure flag. Never use it to grant anything.
     */
    public static function requestLooksHttps(): bool
    {
        if (self::directHttps()) {
            return true;
        }
        $xfp = strtolower((string)($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''));
        if ($xfp !== '' && in_array('https', array_map('trim', explode(',', $xfp)), true)) {
            return true;
        }
        if (strtolower((string)($_SERVER['HTTP_X_FORWARDED_SSL'] ?? '')) === 'on') {
            return true;
        }
        if (self::cfVisitorScheme() === 'https') {
            return true;
        }
        return (int)Server::get('SERVER_PORT', 0) === 443;
    }

    public static function trustedProxies(): array
    {
        return self::config()['trusted_proxies'];
    }

    public static function config(): array
    {
        if (self::$config !== null) {
            return self::$config;
        }

        global $settings, $abs_us_root;
        // Don't cache a config built before init.php has set up $settings and
        // the install path; a later call in the same request must see them.
        $cacheable = is_object($settings ?? null) && isset($abs_us_root);

        $config = [
            'enabled' => isset($settings->behind_reverse_proxy) && (bool)$settings->behind_reverse_proxy,
            // Legacy view: proxy list and header map as the admin UI edits them.
            'trusted_proxies' => [],
            'trusted_headers' => [],
            // Effective trust: [['cidr' => string, 'headers' => [name => priority]], ...]
            'bindings' => [],
            'presets' => [],
            // Explicit bindings from the file's 'bindings' key, kept so a
            // rewrite of the file preserves them.
            'file_bindings' => [],
            'source' => 'db',
            'enabled_from_file' => false,
            'file_error' => false,
        ];

        $file = self::configFile();
        if (is_readable($file)) {
            $fromFile = self::safeInclude($file);
            if (!is_array($fromFile)) {
                // Present but unreadable or broken: fail closed (no header
                // trust) rather than silently falling back to the database.
                $config['source'] = 'file';
                $config['enabled'] = false;
                $config['file_error'] = true;
                return $cacheable ? self::$config = $config : $config;
            }
            if (is_array($fromFile)) {
                $config['source'] = 'file';
                if (array_key_exists('enabled', $fromFile)) {
                    $config['enabled'] = (bool)$fromFile['enabled'];
                    $config['enabled_from_file'] = true;
                }
                foreach ((array)($fromFile['trusted_proxies'] ?? []) as $proxy) {
                    $proxy = trim((string)$proxy);
                    if ($proxy !== '') {
                        $config['trusted_proxies'][] = $proxy;
                    }
                }
                foreach ((array)($fromFile['trusted_headers'] ?? []) as $header => $priority) {
                    $config['trusted_headers'][(string)$header] = (int)$priority;
                }
                // Legacy format: every listed proxy may supply every listed header
                foreach ($config['trusted_proxies'] as $proxy) {
                    self::addBinding($config['bindings'], $proxy, $config['trusted_headers']);
                }
                foreach ((array)($fromFile['bindings'] ?? []) as $binding) {
                    if (!is_array($binding) || !isset($binding['cidr'])) {
                        continue;
                    }
                    $headers = [];
                    foreach ((array)($binding['headers'] ?? []) as $header => $priority) {
                        $headers[(string)$header] = (int)$priority;
                    }
                    $recursive = !empty($binding['recursive']);
                    $config['file_bindings'][] = ['cidr' => trim((string)$binding['cidr']), 'headers' => $headers, 'recursive' => $recursive];
                    self::addBinding($config['bindings'], (string)$binding['cidr'], $headers, $recursive);
                }
                $config['presets'] = self::normalizePresets($fromFile['presets'] ?? []);
                if ($config['enabled']) {
                    self::applyPresets($config);
                }
                return $cacheable ? self::$config = $config : $config;
            }
        }

        // Stored presets are reported even while proxy mode is off, so the
        // admin page shows (and saving keeps) what is configured.
        $config['presets'] = self::normalizePresets($settings->proxy_presets ?? '');
        if (!$config['enabled']) {
            return $cacheable ? self::$config = $config : $config;
        }

        try {
            $db = DB::getInstance();
            $result = $db->query(
                "SELECT proxy_ip, header_name, priority
                 FROM us_rate_limit_proxy_settings
                 WHERE enabled = 1
                 ORDER BY priority ASC"
            );
            if ($result && !$result->error()) {
                foreach ($result->results() as $row) {
                    $proxy = trim($row->proxy_ip);
                    if (!in_array($proxy, $config['trusted_proxies'], true)) {
                        $config['trusted_proxies'][] = $proxy;
                    }
                    $config['trusted_headers'][$row->header_name] = (int)$row->priority;
                    // Each row trusts its proxy for its own header only
                    self::addBinding($config['bindings'], $proxy, [$row->header_name => (int)$row->priority]);
                }
            }
        } catch (Exception $e) {
            // Table may not exist yet; resolve as a pass-through
        }

        self::applyPresets($config);
        return $cacheable ? self::$config = $config : $config;
    }

    public static function configFile(): string
    {
        global $abs_us_root, $us_url_root;
        return $abs_us_root . $us_url_root . 'usersc/includes/trusted_proxies.php';
    }

    /**
     * Write usersc/includes/trusted_proxies.php. The legacy proxy list and
     * header map are written from the arguments; presets and explicit
     * bindings already in the file are carried over unless passed.
     */
    public static function writeConfigFile(array $proxies, array $headers, $enabled = null, ?array $presets = null, ?array $bindings = null): bool
    {
        $current = self::config();
        $fromFile = $current['source'] === 'file';
        if ($enabled === null && $fromFile && $current['enabled_from_file']) {
            $enabled = $current['enabled'];
        }
        if ($presets === null) {
            $presets = $fromFile ? $current['presets'] : [];
        }
        if ($bindings === null) {
            $bindings = $fromFile ? $current['file_bindings'] : [];
        }

        $content = "<?php\n";
        $content .= "/**\n";
        $content .= " * Trusted proxy configuration\n";
        $content .= " * When this file exists it replaces the database proxy settings.\n";
        $content .= " * trusted_proxies may supply any header in trusted_headers.\n";
        $content .= " * bindings tie one proxy range to specific headers.\n";
        $content .= " * presets: " . implode(', ', array_keys(self::PRESETS)) . "\n";
        $content .= " * Last updated: " . date('Y-m-d H:i:s') . "\n";
        $content .= " */\n";
        $content .= "return [\n";
        if ($enabled !== null) {
            $content .= "    'enabled' => " . var_export((bool)$enabled, true) . ",\n";
        }
        $content .= "    'presets' => [";
        $presetOut = [];
        foreach (self::normalizePresets($presets) as $preset) {
            $presetOut[] = var_export($preset, true);
        }
        $content .= implode(', ', $presetOut) . "],\n";
        $content .= "    'trusted_proxies' => [\n";
        foreach (array_values(array_unique($proxies)) as $proxy) {
            $content .= "        " . var_export((string)$proxy, true) . ",\n";
        }
        $content .= "    ],\n";
        $content .= "    'trusted_headers' => [\n";
        foreach ($headers as $header => $priority) {
            $content .= "        " . var_export((string)$header, true) . " => " . (int)$priority . ",\n";
        }
        $content .= "    ],\n";
        $content .= "    'bindings' => [\n";
        foreach ($bindings as $binding) {
            if (!is_array($binding) || !isset($binding['cidr'])) {
                continue;
            }
            $content .= "        ['cidr' => " . var_export((string)$binding['cidr'], true) . ", 'headers' => [";
            $pairs = [];
            foreach ((array)($binding['headers'] ?? []) as $header => $priority) {
                $pairs[] = var_export((string)$header, true) . " => " . (int)$priority;
            }
            $content .= implode(', ', $pairs) . "]" . (!empty($binding['recursive']) ? ", 'recursive' => true" : '') . "],\n";
        }
        $content .= "    ],\n";
        $content .= "];\n";

        if (!self::writeAtomic(self::configFile(), $content)) {
            return false;
        }
        self::reset();
        return true;
    }

    /**
     * Whether $ip is a trusted proxy. With no list given, checks every
     * effective binding (configured entries and presets).
     */
    public static function isTrustedProxy(string $ip, ?array $proxies = null): bool
    {
        if ($proxies === null) {
            $proxies = self::bindingCidrs(self::config()['bindings']);
        }
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            return false;
        }
        foreach ($proxies as $proxy) {
            if (self::inRange($ip, $proxy)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Resolve a comma-separated forwarded list. Starts at the rightmost entry
     * (written by the proxy itself) and keeps walking left only past entries
     * inside $trustedHops; pass [] for a single hop. Taking the first
     * (leftmost) entry instead would let any client choose its own address -
     * don't. Invalid or non-routable (loopback, unspecified, link-local)
     * entries stop the walk.
     *
     * Returns null when the rightmost entry is missing, invalid, or non-routable.
     */
    public static function walkForwarded(string $value, array $trustedHops): ?string
    {
        if (trim($value) === '') {
            return null;
        }
        $entries = explode(',', $value);
        $fallback = null;
        for ($i = count($entries) - 1; $i >= 0; $i--) {
            $entry = self::stripPort(trim($entries[$i]));
            if (filter_var($entry, FILTER_VALIDATE_IP) === false || self::isNonRoutable($entry)) {
                return $fallback;
            }
            $trusted = false;
            foreach ($trustedHops as $cidr) {
                if (self::inRange($entry, $cidr)) {
                    $trusted = true;
                    break;
                }
            }
            if (!$trusted) {
                return $entry;
            }
            $fallback = $entry;
        }
        return $fallback;
    }

    /**
     * Turn an RFC 7239 Forwarded header into a plain comma list with one entry
     * per element: its for= address, or 'invalid' when the element has none
     * (for=unknown, an obfuscated id, no for= at all), so a walk stops there
     * instead of reaching a client-written element further left.
     */
    public static function forwardedForList(string $forwarded): string
    {
        $out = [];
        foreach (self::splitOutsideQuotes($forwarded, ',') as $element) {
            $value = self::forwardedParam($element, 'for');
            $value = $value === null ? '' : self::stripPort($value);
            $out[] = filter_var($value, FILTER_VALIDATE_IP) !== false ? $value : 'invalid';
        }
        return implode(', ', $out);
    }

    public static function inRange(string $ip, string $cidr): bool
    {
        $ipBin = self::toBinary($ip);
        if ($ipBin === false) {
            return false;
        }

        if (strpos($cidr, '/') === false) {
            $cidrBin = self::toBinary($cidr);
            return $cidrBin !== false && $ipBin === $cidrBin;
        }

        list($subnet, $bits) = explode('/', $cidr, 2);
        $subnetBin = self::toBinary($subnet);
        if ($subnetBin === false || strlen($ipBin) !== strlen($subnetBin)) {
            return false;
        }
        if (!ctype_digit($bits) || (int)$bits > strlen($ipBin) * 8) {
            return false;
        }

        $bits = (int)$bits;
        $fullBytes = intdiv($bits, 8);
        $remainder = $bits % 8;

        if ($fullBytes > 0 && substr($ipBin, 0, $fullBytes) !== substr($subnetBin, 0, $fullBytes)) {
            return false;
        }
        if ($remainder > 0) {
            $mask = (0xFF << (8 - $remainder)) & 0xFF;
            if ((ord($ipBin[$fullBytes]) & $mask) !== (ord($subnetBin[$fullBytes]) & $mask)) {
                return false;
            }
        }
        return true;
    }

    public static function validCidr(string $entry): bool
    {
        if (strpos($entry, '/') === false) {
            return filter_var($entry, FILTER_VALIDATE_IP) !== false;
        }
        list($subnet, $bits) = explode('/', $entry, 2);
        $subnetBin = self::toBinary($subnet);
        if ($subnetBin === false || !ctype_digit($bits)) {
            return false;
        }
        // A /0 mask would trust every address on the internet as a proxy
        return (int)$bits > 0 && (int)$bits <= strlen($subnetBin) * 8;
    }

    /**
     * Stricter check for admin-entered proxy ranges: a valid CIDR no wider
     * than /8 (IPv4) or /32 (IPv6). Wider ranges (e.g. two /1s) would let
     * most of the internet set its own address.
     */
    public static function reasonableProxyRange(string $entry): bool
    {
        if (!self::validCidr($entry)) {
            return false;
        }
        if (strpos($entry, '/') === false) {
            return true;
        }
        list($subnet, $bits) = explode('/', $entry, 2);
        return (int)$bits >= (strlen((string)self::toBinary($subnet)) === 4 ? 8 : 32);
    }

    /**
     * Cloudflare edge ranges: the refreshed cache when it validates, else the
     * bundled list. Returns ['as_of' => string, 'source' => 'cache'|'bundled', 'ranges' => [...]].
     */
    public static function cloudflareRanges(): array
    {
        if (self::$cloudflare !== null) {
            return self::$cloudflare;
        }
        $cache = self::cloudflareCacheFile();
        if (is_readable($cache)) {
            $data = self::safeInclude($cache);
            $ranges = self::validRangeList($data);
            if ($ranges !== null) {
                return self::$cloudflare = ['as_of' => (string)($data['as_of'] ?? ''), 'source' => 'cache', 'ranges' => $ranges];
            }
        }

        $bundled = __DIR__ . '/../includes/cloudflare_ips.php';
        $data = is_readable($bundled) ? self::safeInclude($bundled) : [];
        $ranges = self::validRangeList($data) ?? [];
        return self::$cloudflare = ['as_of' => (string)($data['as_of'] ?? ''), 'source' => 'bundled', 'ranges' => $ranges];
    }

    public static function cloudflareCacheFile(): string
    {
        global $abs_us_root, $us_url_root;
        return $abs_us_root . $us_url_root . 'usersc/includes/cloudflare_ips.cache.php';
    }

    public static function inCloudflare(string $ip): bool
    {
        foreach (self::cloudflareRanges()['ranges'] as $cidr) {
            if (self::inRange($ip, $cidr)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Fetch Cloudflare's published ranges and write the cache file. Refuses to
     * write anything unless both lists download and every line validates, so a
     * failed or partial fetch leaves the previous list in force.
     *
     * @return array ['ok' => bool, 'message' => string, 'count' => int]
     */
    public static function refreshCloudflareRanges(int $timeout = 10): array
    {
        if (!function_exists('curl_init')) {
            return ['ok' => false, 'message' => 'The PHP curl extension is not available.', 'count' => 0];
        }
        $lists = [];
        foreach (['v4' => 'https://www.cloudflare.com/ips-v4', 'v6' => 'https://www.cloudflare.com/ips-v6'] as $family => $url) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_TIMEOUT => $timeout,
                CURLOPT_CONNECTTIMEOUT => $timeout,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
            ]);
            $body = curl_exec($ch);
            $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($body === false || $status !== 200) {
                return ['ok' => false, 'message' => "Could not download $url (HTTP $status).", 'count' => 0];
            }
            $ranges = [];
            foreach (preg_split('/\R/', trim((string)$body)) as $line) {
                $line = trim($line);
                if ($line === '') {
                    continue;
                }
                $isV6 = strpos($line, ':') !== false;
                if (!self::validCidr($line) || strpos($line, '/') === false || $isV6 !== ($family === 'v6')) {
                    return ['ok' => false, 'message' => "Unexpected line in $url; nothing was changed.", 'count' => 0];
                }
                $ranges[] = $line;
            }
            // Sanity floor: Cloudflare publishes 15 IPv4 and 7 IPv6 ranges.
            // A much shorter list means something is wrong upstream.
            if (count($ranges) < ($family === 'v4' ? 8 : 3)) {
                return ['ok' => false, 'message' => "$url returned too few ranges; nothing was changed.", 'count' => 0];
            }
            $lists[$family] = $ranges;
        }

        $content = "<?php\n// Cloudflare edge ranges, refreshed " . date('Y-m-d H:i:s') . ". Generated by ClientIP::refreshCloudflareRanges().\n";
        $content .= "return " . var_export(['as_of' => date('Y-m-d'), 'v4' => $lists['v4'], 'v6' => $lists['v6']], true) . ";\n";

        $file = self::cloudflareCacheFile();
        if (!is_dir(dirname($file)) || !self::writeAtomic($file, $content)) {
            return ['ok' => false, 'message' => 'Could not write usersc/includes/cloudflare_ips.cache.php. Check that the web server can write to usersc/includes.', 'count' => 0];
        }
        self::reset();
        return ['ok' => true, 'message' => 'Cloudflare ranges refreshed.', 'count' => count($lists['v4']) + count($lists['v6'])];
    }

    /**
     * Describe how this request reached PHP, for the admin Proxy & CDN page
     * and the security dashboard. Header values are client-controlled: escape
     * them on output.
     */
    public static function detect(): array
    {
        $config = self::config();
        $peer = (PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg') ? '' : Server::get('REMOTE_ADDR', '');

        $forwarding = [];
        foreach ($_SERVER as $key => $value) {
            if (is_string($key) && self::isForwardingKey($key) && (string)$value !== '' && count($forwarding) < 25) {
                $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
                $forwarding[$name] = substr((string)$value, 0, 200);
            }
        }

        $cfHeader = trim((string)($_SERVER['HTTP_CF_CONNECTING_IP'] ?? ''));
        $cfHeaderValid = filter_var($cfHeader, FILTER_VALIDATE_IP) !== false;
        $cloudflarePeer = $peer !== '' && self::inCloudflare($peer);
        $loopbackPeer = $peer !== '' && self::isLoopback($peer);
        $trustedPeer = self::isTrustedPeer();

        // A web-server module (mod_remoteip, nginx real_ip) already rewrote
        // REMOTE_ADDR when a forwarded value equals the peer itself.
        $upstreamResolved = false;
        foreach (['HTTP_CF_CONNECTING_IP', 'HTTP_X_REAL_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_TRUE_CLIENT_IP'] as $key) {
            if (!empty($_SERVER[$key])) {
                $parts = explode(',', (string)$_SERVER[$key]);
                if (trim(end($parts)) === $peer) {
                    $upstreamResolved = true;
                    break;
                }
            }
        }
        $modRemoteip = function_exists('apache_get_modules') && in_array('mod_remoteip', apache_get_modules(), true);

        $active = $config['enabled'] ? $config['presets'] : [];
        // A forwarded request from a private or loopback peer means a reverse
        // proxy on our side of the network. Forwarding headers from a public
        // peer are usually the visitor's own corporate proxy, not ours.
        $privatePeer = false;
        foreach (['10.0.0.0/8', '172.16.0.0/12', '192.168.0.0/16', '127.0.0.0/8', '::1', 'fc00::/7'] as $cidr) {
            if ($peer !== '' && self::inRange($peer, $cidr)) {
                $privatePeer = true;
                break;
            }
        }

        $suggest = '';
        if (!$upstreamResolved && !$trustedPeer) {
            if ($cloudflarePeer && $cfHeaderValid && !in_array('cloudflare', $active, true)) {
                $suggest = 'cloudflare';
            } elseif ($loopbackPeer && $cfHeaderValid) {
                $suggest = 'cloudflare_tunnel';
            } elseif ($privatePeer && !empty($forwarding)) {
                $suggest = 'custom';
            }
        }

        return [
            'peer' => $peer,
            'resolved' => self::get(),
            'scheme' => self::scheme(),
            'direct_https' => self::directHttps(),
            'trusted_peer' => $trustedPeer,
            'proxied' => self::isProxied(),
            'local' => self::isLocal(),
            'cloudflare_peer' => $cloudflarePeer,
            'cloudflare_header' => $cfHeaderValid ? $cfHeader : '',
            'country' => (self::peerBoundFor('CF-Connecting-IP') && isset($_SERVER['HTTP_CF_IPCOUNTRY']) && preg_match('/^[A-Z0-9]{2}$/', (string)$_SERVER['HTTP_CF_IPCOUNTRY'])) ? (string)$_SERVER['HTTP_CF_IPCOUNTRY'] : '',
            'loopback_peer' => $loopbackPeer,
            'loopback_forwarded' => $loopbackPeer && !empty($forwarding),
            'upstream_resolved' => $upstreamResolved,
            'mod_remoteip' => $modRemoteip,
            'forwarding_headers' => $forwarding,
            'suggest' => $suggest,
        ];
    }

    /**
     * The address get() would return if $preset were switched on, for showing
     * an admin what enabling it changes before they click.
     */
    public static function previewPreset(string $preset): string
    {
        $peer = self::peer();
        $cf = trim((string)($_SERVER['HTTP_CF_CONNECTING_IP'] ?? ''));
        if (filter_var($cf, FILTER_VALIDATE_IP) === false) {
            return $peer;
        }
        if ($preset === 'cloudflare' && self::inCloudflare($peer)) {
            return $cf;
        }
        if ($preset === 'cloudflare_tunnel' && self::isLoopback($peer)) {
            return $cf;
        }
        return $peer;
    }

    public static function reset(): void
    {
        self::$resolved = null;
        self::$proxied = false;
        self::$config = null;
        self::$cloudflare = null;
    }

    // ------------------------------------------------------------------

    private static function addBinding(array &$bindings, string $cidr, array $headers, bool $recursive = false): void
    {
        $cidr = trim($cidr);
        if ($cidr === '' || !self::validCidr($cidr) || empty($headers)) {
            return;
        }
        foreach ($bindings as &$binding) {
            if ($binding['cidr'] === $cidr) {
                foreach ($headers as $header => $priority) {
                    if (!isset($binding['headers'][$header]) || $priority < $binding['headers'][$header]) {
                        $binding['headers'][$header] = $priority;
                    }
                }
                $binding['recursive'] = $binding['recursive'] || $recursive;
                return;
            }
        }
        unset($binding);
        $bindings[] = ['cidr' => $cidr, 'headers' => $headers, 'recursive' => $recursive];
    }

    private static function normalizePresets($presets): array
    {
        if (is_string($presets)) {
            $presets = explode(',', $presets);
        }
        $out = [];
        foreach ((array)$presets as $preset) {
            $preset = strtolower(trim((string)$preset));
            if (isset(self::PRESETS[$preset]) && !in_array($preset, $out, true)) {
                $out[] = $preset;
            }
        }
        return $out;
    }

    private static function applyPresets(array &$config): void
    {
        foreach ($config['presets'] as $preset) {
            if ($preset === 'cloudflare') {
                foreach (self::cloudflareRanges()['ranges'] as $cidr) {
                    self::addBinding($config['bindings'], $cidr, ['CF-Connecting-IP' => 0]);
                }
            } elseif ($preset === 'cloudflare_tunnel') {
                self::addBinding($config['bindings'], '127.0.0.1', ['CF-Connecting-IP' => 0]);
                self::addBinding($config['bindings'], '::1', ['CF-Connecting-IP' => 0]);
            }
        }
    }

    /**
     * Headers the peer is allowed to supply, lowest priority first, as
     * [header => recursive]. Empty when the peer matches no binding.
     */
    private static function headersForPeer(string $peer, array $bindings): array
    {
        if (filter_var($peer, FILTER_VALIDATE_IP) === false) {
            return [];
        }
        $priorities = [];
        $recursive = [];
        foreach ($bindings as $binding) {
            if (!self::inRange($peer, $binding['cidr'])) {
                continue;
            }
            foreach ($binding['headers'] as $header => $priority) {
                if (!isset($priorities[$header]) || $priority < $priorities[$header]) {
                    $priorities[$header] = $priority;
                }
                $recursive[$header] = ($recursive[$header] ?? false) || !empty($binding['recursive']);
            }
        }
        asort($priorities);
        $out = [];
        foreach (array_keys($priorities) as $header) {
            $out[$header] = $recursive[$header];
        }
        return $out;
    }

    /** Ranges trusted to supply $header: the only hops a recursive walk may skip. */
    private static function cidrsForHeader(array $bindings, string $header): array
    {
        $out = [];
        foreach ($bindings as $binding) {
            if (isset($binding['headers'][$header])) {
                $out[] = $binding['cidr'];
            }
        }
        return $out;
    }

    /** Whether proxy mode is on and the connecting peer is trusted for $header. */
    private static function peerBoundFor(string $header): bool
    {
        $config = self::config();
        if (!$config['enabled'] || empty($config['bindings'])) {
            return false;
        }
        return array_key_exists($header, self::headersForPeer(self::rawPeer(), $config['bindings']));
    }

    private static function isNonRoutable(string $ip): bool
    {
        foreach (self::NON_ROUTABLE as $cidr) {
            if (self::inRange($ip, $cidr)) {
                return true;
            }
        }
        return false;
    }

    /** Split on $sep, ignoring separators inside double-quoted strings. */
    private static function splitOutsideQuotes(string $value, string $sep): array
    {
        $parts = [];
        $current = '';
        $quoted = false;
        $len = strlen($value);
        for ($i = 0; $i < $len; $i++) {
            $c = $value[$i];
            if ($quoted && $c === '\\' && $i + 1 < $len) {
                $current .= $c . $value[++$i];
                continue;
            }
            if ($c === '"') {
                $quoted = !$quoted;
            } elseif ($c === $sep && !$quoted) {
                $parts[] = $current;
                $current = '';
                continue;
            }
            $current .= $c;
        }
        $parts[] = $current;
        return $parts;
    }

    /** Value of parameter $name in one Forwarded element, unquoted; null if absent. */
    private static function forwardedParam(string $element, string $name): ?string
    {
        $found = null;
        foreach (self::splitOutsideQuotes($element, ';') as $pair) {
            $eq = strpos($pair, '=');
            if ($eq === false || strtolower(trim(substr($pair, 0, $eq))) !== $name) {
                continue;
            }
            $value = trim(substr($pair, $eq + 1));
            if (strlen($value) >= 2 && $value[0] === '"' && substr($value, -1) === '"') {
                $value = stripslashes(substr($value, 1, -1));
            }
            $found = $value;
        }
        return $found;
    }

    /** include a generated PHP file without letting a broken one take the site down. */
    private static function safeInclude(string $file)
    {
        try {
            return include $file;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /** Write via a temp file and rename, so readers never see a partial file. */
    public static function writeAtomic(string $file, string $content): bool
    {
        $dir = dirname($file);
        if (!is_dir($dir) && !@mkdir($dir, 0755, true)) {
            return false;
        }
        $tmp = $dir . '/.' . basename($file) . '.' . bin2hex(random_bytes(4)) . '.tmp';
        if (@file_put_contents($tmp, $content, LOCK_EX) !== strlen($content)) {
            @unlink($tmp);
            return false;
        }
        if (is_file($file)) {
            @chmod($tmp, fileperms($file) & 0777);
        }
        if (!@rename($tmp, $file)) {
            @unlink($tmp);
            return false;
        }
        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($file, true);
        }
        return true;
    }

    private static function bindingCidrs(array $bindings): array
    {
        return array_map(function ($b) {
            return $b['cidr'];
        }, $bindings);
    }

    private static function headerValue(string $header): string
    {
        $serverKey = 'HTTP_' . strtoupper(str_replace('-', '_', $header));
        $value = isset($_SERVER[$serverKey]) ? (string)$_SERVER[$serverKey] : '';
        if ($value !== '' && strtolower($header) === 'forwarded') {
            return self::forwardedForList($value);
        }
        return $value;
    }

    private static function stripPort(string $entry): string
    {
        // [2001:db8::1]:443 or [2001:db8::1]
        if ($entry !== '' && $entry[0] === '[') {
            $end = strpos($entry, ']');
            return $end === false ? $entry : substr($entry, 1, $end - 1);
        }
        // 203.0.113.9:443 (exactly one colon means IPv4 with a port)
        if (substr_count($entry, ':') === 1) {
            return substr($entry, 0, strpos($entry, ':'));
        }
        return $entry;
    }

    private static function directHttps(): bool
    {
        // IIS sends HTTPS=off on plain HTTP
        $https = strtolower(trim((string)Server::get('HTTPS', '')));
        return $https !== '' && $https !== 'off';
    }

    private static function forwardedProto(): string
    {
        // CF-Visitor is Cloudflare's own header; only believe it from a peer
        // trusted for Cloudflare's client header.
        if (self::peerBoundFor('CF-Connecting-IP')) {
            $visitor = self::cfVisitorScheme();
            if ($visitor !== '') {
                return $visitor;
            }
        }
        $xfp = (string)($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '');
        if ($xfp !== '') {
            $parts = explode(',', $xfp);
            $proto = strtolower(trim(end($parts)));
            if ($proto === 'https' || $proto === 'http') {
                return $proto;
            }
        }
        $fwd = (string)($_SERVER['HTTP_FORWARDED'] ?? '');
        if ($fwd !== '') {
            $elements = self::splitOutsideQuotes($fwd, ',');
            $proto = strtolower((string)self::forwardedParam((string)end($elements), 'proto'));
            if ($proto === 'https' || $proto === 'http') {
                return $proto;
            }
        }
        return '';
    }

    private static function cfVisitorScheme(): string
    {
        $visitor = (string)($_SERVER['HTTP_CF_VISITOR'] ?? '');
        if ($visitor === '') {
            return '';
        }
        $decoded = json_decode($visitor, true);
        $scheme = is_array($decoded) ? strtolower((string)($decoded['scheme'] ?? '')) : '';
        return ($scheme === 'https' || $scheme === 'http') ? $scheme : '';
    }

    /**
     * All-or-nothing validation of a cloudflare_ips-style array: each family
     * holds only its own CIDRs, none wider than /12 (IPv4) or /28 (IPv6), and
     * each list is plausibly complete (Cloudflare publishes 15 + 7).
     */
    private static function validRangeList($data): ?array
    {
        if (!is_array($data)) {
            return null;
        }
        $out = [];
        foreach (['v4' => [4, 12, 8], 'v6' => [16, 28, 3]] as $family => [$bytes, $minBits, $minCount]) {
            $list = $data[$family] ?? null;
            if (!is_array($list) || count($list) < $minCount) {
                return null;
            }
            foreach ($list as $range) {
                if (!is_string($range) || strpos($range, '/') === false || !self::validCidr($range)) {
                    return null;
                }
                list($subnet, $bits) = explode('/', $range, 2);
                $bin = self::toBinary($subnet);
                if ($bin === false || strlen($bin) !== $bytes || (int)$bits < $minBits) {
                    return null;
                }
                $out[] = $range;
            }
        }
        return $out;
    }

    private static function toBinary(string $ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            return false;
        }
        $bin = inet_pton($ip);
        // Normalize IPv4-mapped IPv6 (::ffff:a.b.c.d) to plain IPv4 so a
        // dual-stack peer still matches IPv4 CIDR trust entries
        if (strlen($bin) === 16 && substr($bin, 0, 12) === str_repeat("\x00", 10) . "\xff\xff") {
            return substr($bin, 12);
        }
        return $bin;
    }
}
