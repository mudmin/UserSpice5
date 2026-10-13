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
 * Resolves the client IP address for the whole framework.
 *
 * Two contracts:
 *   get()  - the resolved client address. May be taken from a forwarded header,
 *            but only when the connecting peer is a configured trusted proxy.
 *            Use for logging, audit rows, rate limiting, and ban matching.
 *   peer() - the raw connection address (REMOTE_ADDR). Never header-derived.
 *            Use for authorization decisions such as IP allowlists and cron
 *            gating, where a spoofable value must never be trusted.
 *
 * Proxy configuration comes from usersc/includes/trusted_proxies.php when that
 * file exists, otherwise from the us_rate_limit_proxy_settings table. The two
 * sources are never merged. With proxy mode off, no database query is made and
 * REMOTE_ADDR is returned untouched.
 */
class ClientIP
{
    private static $resolved = null;
    private static $proxied = false;
    private static $config = null;

    public static function get(): string
    {
        if (self::$resolved !== null) {
            return self::$resolved;
        }

        self::$proxied = false;
        $peer = self::peer();
        $config = self::config();

        if (!$config['enabled'] || empty($config['trusted_proxies']) || !self::isTrustedProxy($peer, $config['trusted_proxies'])) {
            return self::$resolved = $peer;
        }

        $headers = $config['trusted_headers'];
        asort($headers);

        foreach (array_keys($headers) as $header) {
            $serverKey = 'HTTP_' . strtoupper(str_replace('-', '_', $header));
            if (empty($_SERVER[$serverKey])) {
                continue;
            }
            // Last entry only: the nearest hop is the only one the trusted
            // proxy wrote itself; earlier entries are client-supplied.
            $entries = explode(',', $_SERVER[$serverKey]);
            $candidate = trim(end($entries));
            if (filter_var($candidate, FILTER_VALIDATE_IP) !== false) {
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

    public static function isProxied(): bool
    {
        self::get();
        return self::$proxied;
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

        global $settings;

        $config = [
            'enabled' => isset($settings->behind_reverse_proxy) && (bool)$settings->behind_reverse_proxy,
            'trusted_proxies' => [],
            'trusted_headers' => [],
            'source' => 'db',
            'enabled_from_file' => false,
        ];

        $file = self::configFile();
        if (is_readable($file)) {
            $fromFile = include $file;
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
                return self::$config = $config;
            }
        }

        if (!$config['enabled']) {
            return self::$config = $config;
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
                    $config['trusted_proxies'][] = trim($row->proxy_ip);
                    $config['trusted_headers'][$row->header_name] = (int)$row->priority;
                }
            }
        } catch (Exception $e) {
            // Table may not exist yet; resolve as a pass-through
        }

        return self::$config = $config;
    }

    public static function configFile(): string
    {
        global $abs_us_root, $us_url_root;
        return $abs_us_root . $us_url_root . 'usersc/includes/trusted_proxies.php';
    }

    public static function writeConfigFile(array $proxies, array $headers, $enabled = null): bool
    {
        if ($enabled === null) {
            $current = self::config();
            if ($current['source'] === 'file' && $current['enabled_from_file']) {
                $enabled = $current['enabled'];
            }
        }

        $content = "<?php\n";
        $content .= "/**\n";
        $content .= " * Trusted proxy configuration\n";
        $content .= " * When this file exists it replaces the database proxy settings.\n";
        $content .= " * Last updated: " . date('Y-m-d H:i:s') . "\n";
        $content .= " */\n";
        $content .= "return [\n";
        if ($enabled !== null) {
            $content .= "    'enabled' => " . var_export((bool)$enabled, true) . ",\n";
        }
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
        $content .= "];\n";

        $file = self::configFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        if (file_put_contents($file, $content) === false) {
            return false;
        }
        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($file, true);
        }
        self::reset();
        return true;
    }

    public static function isTrustedProxy(string $ip, ?array $proxies = null): bool
    {
        if ($proxies === null) {
            $proxies = self::config()['trusted_proxies'];
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

    public static function reset(): void
    {
        self::$resolved = null;
        self::$proxied = false;
        self::$config = null;
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
