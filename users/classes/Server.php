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

final class Server
{
    /** Map $_SERVER keys to sanitizer “types” and optional params. */
    private const KEY_MAP = [
        // Hosts
        'HTTP_HOST'               => ['type' => 'host', 'params' => [true, true]], // stripPort, allowLocalhost
        'SERVER_NAME'             => ['type' => 'host', 'params' => [true, true]],
        'HTTP_X_FORWARDED_HOST'   => ['type' => 'csv_hosts', 'params' => [true, true]],

        // IP addresses
        'REMOTE_ADDR'             => ['type' => 'ip'],
        'SERVER_ADDR'             => ['type' => 'ip'],
        'HTTP_X_FORWARDED_FOR'    => ['type' => 'csv_ips'], // first valid

        // Ports
        'REMOTE_PORT'             => ['type' => 'port'],
        'SERVER_PORT'             => ['type' => 'port'],

        // Scheme hints
        'HTTPS'                   => ['type' => 'https_flag'],            // "on"/"1"
        'HTTP_X_FORWARDED_PROTO'  => ['type' => 'scheme_token'],        // first token
        'HTTP_FORWARDED'          => ['type' => 'forwarded_header'],    // parsed when needed

        // URIs / paths
        'REQUEST_URI'             => ['type' => 'uri'],
        'SCRIPT_NAME'             => ['type' => 'uri'],
        'PHP_SELF'                => ['type' => 'uri'],

        // Request details
        'REQUEST_METHOD'          => ['type' => 'method'],
        'SERVER_PROTOCOL'         => ['type' => 'token'],       // e.g., HTTP/1.1
        'HTTP_USER_AGENT'         => ['type' => 'user_agent'],

        // Query & referrer
        'QUERY_STRING'            => ['type' => 'query_string'], // strip CTLs/CRLF only
        'HTTP_REFERER'            => ['type' => 'string'],       // don’t trust; just de-CTL

        // Content headers
        'CONTENT_LENGTH'          => ['type' => 'int_range', 'params' => [0, PHP_INT_MAX]],
        'CONTENT_TYPE'            => ['type' => 'string'],       // keep simple
        'HTTP_CONTENT_TYPE'       => ['type' => 'string'],       // alternate content-type header

        // AJAX detection
        'HTTP_X_REQUESTED_WITH'   => ['type' => 'token'],        // e.g., XMLHttpRequest

        // Paths
        'DOCUMENT_ROOT'   => ['type' => 'fs_path', 'params' => [true, true, true]], // mustExist, requireDir, absoluteOnly
        'SCRIPT_FILENAME' => ['type' => 'fs_path', 'params' => [true, false, true]], // file path

        // Misc common
        'HTTP_ACCEPT'             => ['type' => 'string'],
        'HTTP_ACCEPT_LANGUAGE'    => ['type' => 'string'],
        'HTTP_ACCEPT_ENCODING'    => ['type' => 'string'],
        'HTTP_CONNECTION'         => ['type' => 'token'],
        'HTTP_UPGRADE_INSECURE_REQUESTS' => ['type' => 'token'],
        'HTTP_ORIGIN'             => ['type' => 'origin_like'], // scheme://host[:port]
    ];

    /** Simple in-process cache to avoid repeat work per-request. */
    private static array $cache = [];

    /** Public: typed fetch with sanitization and sensible defaults. */
    public static function get(string $key, $default = '')
    {
        if (array_key_exists($key, self::$cache)) {
            return self::$cache[$key];
        }

        $raw = $_SERVER[$key] ?? null;
        if ($raw === null) {
            return $default;
        }

        $cfg    = self::KEY_MAP[$key] ?? ['type' => 'string'];
        $type   = $cfg['type'];
        $params = $cfg['params'] ?? [];

        $val = self::sanitize($raw, $type, ...$params);

        // Only coerce to default if the sanitized value is definitively invalid:
        // - empty string for string-ish types
        // - 0 for ports and int_range
        if ($type === 'port' || $type === 'int_range') {
            $out = ($val === 0) ? $default : $val;
        } else {
            $out = ($val === '') ? $default : $val;
        }

        self::$cache[$key] = $out;
        return $out;
    }

    /** Public: generic sanitizer entry point (direct use if needed). */
    public static function sanitize($value, string $type, ...$params)
    {
        switch (strtolower($type)) {
            case 'host':
                return self::sanitize_host((string)$value, ...($params ?: [true, true]));
            case 'csv_hosts':
                return self::sanitize_csv_hosts((string)$value, ...($params ?: [true, true]));
            case 'ip':
                return self::sanitize_ip((string)$value);
            case 'csv_ips':
                return self::sanitize_csv_ips((string)$value);
            case 'port':
                return self::sanitize_port($value);
            case 'uri':
                return self::sanitize_request_uri((string)$value);
            case 'method':
                return self::sanitize_request_method((string)$value, ...$params);
            case 'user_agent':
                return self::sanitize_user_agent((string)$value, ...($params ?: [512]));
            case 'string':
                return self::sanitize_string((string)$value);
            case 'token':
                return self::sanitize_token((string)$value);
            case 'https_flag':
                return self::sanitize_https_flag((string)$value);
            case 'scheme_token':
                return self::sanitize_scheme_token((string)$value);
            case 'forwarded_header':
                return self::sanitize_forwarded_header((string)$value);
            case 'query_string':
                return self::sanitize_query_string((string)$value);
            case 'origin_like':
                return self::sanitize_origin_like((string)$value);
            case 'int_range':
                return self::sanitize_int_range($value, ...($params ?: [0, PHP_INT_MAX]));
            case 'fs_path': 
                return self::sanitize_fs_path((string)$value, ...($params ?: [true, true, true]));

            default:
                return '';
        }
    }

    // ------------------ HIGHER-LEVEL HELPERS (proxy-aware) ------------------

    /** Determine if REMOTE_ADDR is in any trusted proxy CIDR. */
    public static function clientIsFromTrustedProxy(array $cidrs): bool
    {
        $rip = self::get('REMOTE_ADDR', '');
        if ($rip === '' || !$cidrs) return false;
        foreach ($cidrs as $c) {
            if (self::ip_in_cidr($rip, $c)) return true;
        }
        return false;
    }

    /** Best-effort client IP respecting trusted proxies. */
    public static function getClientIp(array $trustedProxyCidrs = []): string
    {
        if (self::clientIsFromTrustedProxy($trustedProxyCidrs)) {
            // RFC 7239 Forwarded: for=
            $fwd = self::get('HTTP_FORWARDED', '');
            if ($fwd !== '') {
                $ip = self::extract_ip_from_forwarded($fwd);
                if ($ip !== '') return $ip;
            }
            // X-Forwarded-For: first IP
            $xff = self::get('HTTP_X_FORWARDED_FOR', '');
            if ($xff !== '') return $xff; // already sanitized to first valid IP
        }
        return self::get('REMOTE_ADDR', '');
    }

    /** http|https, proxy-aware. */
    public static function getScheme(array $trustedProxyCidrs = []): string
    {
        // Start with direct TLS signal
        $https = self::get('HTTPS', '');
        if ($https !== '') return 'https';

        if (self::clientIsFromTrustedProxy($trustedProxyCidrs)) {
            $proto = self::get('HTTP_X_FORWARDED_PROTO', '');
            if ($proto === 'https' || $proto === 'http') return $proto;

            $fwd = self::get('HTTP_FORWARDED', '');
            if ($fwd !== '') {
                $proto = self::extract_proto_from_forwarded($fwd);
                if ($proto === 'https' || $proto === 'http') return $proto;
            }
        }

        // Last resort: check port=443
        $port = self::get('SERVER_PORT', 0);
        return ($port === 443) ? 'https' : 'http';
    }

    /** Host (without port), proxy-aware. */
    public static function getHost(array $trustedProxyCidrs = []): string
    {
        if (self::clientIsFromTrustedProxy($trustedProxyCidrs)) {
            // RFC 7239 Forwarded: host=
            $fwd = self::get('HTTP_FORWARDED', '');
            if ($fwd !== '') {
                $host = self::extract_host_from_forwarded($fwd);
                if ($host !== '') return $host;
            }
            // X-Forwarded-Host: first host
            $xfh = self::get('HTTP_X_FORWARDED_HOST', '');
            if ($xfh !== '') return $xfh; // already sanitized to host
        }

        $h = self::get('HTTP_HOST', '');
        if ($h !== '') return $h;

        // Fallback to SERVER_NAME (sanitized as host)
        return self::get('SERVER_NAME', '');
    }

    /**
     * Get the origin (scheme://host), proxy-aware.
     * @return string The origin (e.g., "https://example.com") or an empty string if the host is invalid.
     */
    public static function getOrigin(array $trustedProxyCidrs = []): string
    {
        $scheme = self::getScheme($trustedProxyCidrs);
        $host   = self::getHost($trustedProxyCidrs);
        if ($host === '') {
            return ''; // Return empty string for consistency, instead of throwing.
        }
        return $scheme . '://' . $host;
    }

    // ------------------ LOW-LEVEL SANITIZERS ------------------

    private static function sanitize_host(string $host, bool $stripPort = true, bool $allowLocalhost = true): string
    {
        // Remove control chars
        $host = preg_replace('/[\x00-\x1F\x7F]/u', '', $host);
        if ($host === '' || $host[0] === '/' || str_starts_with($host, '//')) return '';
        $host = str_replace(['/', '\\', ' '], '', $host);

        // Bracketed IPv6: [::1] or [2001:db8::1]
        if ($host !== '' && $host[0] === '[') {
            $end = strpos($host, ']');
            if ($end === false) return '';
            if ($stripPort && strlen($host) > $end + 1 && $host[$end + 1] === ':') {
                $host = substr($host, 0, $end + 1);
            }
            $inside = substr($host, 1, -1);
            if (!preg_match('/^[0-9a-f:.]+$/i', $inside)) return '';
            return $host; // keep brackets
        }

        // Bare IPv6 like ::1 → normalize to [::1]
        if (preg_match('/^[0-9a-f:.]+$/i', $host) && strpos($host, ':') !== false) {
            return '[' . $host . ']';
        }

        if ($allowLocalhost && strtolower($host) === 'localhost') return 'localhost';

        // Optional port on hostname
        if ($stripPort && ($pos = strpos($host, ':')) !== false && strpos($host, ']') === false) {
            $host = substr($host, 0, $pos);
        }

        $parts = explode('.', $host);
        if (count($parts) < 2 && !$allowLocalhost) return '';

        foreach ($parts as $label) {
            if ($label === '' || strlen($label) > 63) return '';
            if ($label[0] === '-' || substr($label, -1) === '-') return '';
            if (!preg_match('/^[A-Za-z0-9-]+$/', $label)) return '';
        }
        if (strlen($host) > 253) return '';

        return strtolower($host);
    }

    private static function sanitize_csv_hosts(string $value, bool $stripPort = true, bool $allowLocalhost = true): string
    {
        // Take first token; trim; sanitize as host
        $first = trim(explode(',', $value)[0]);
        return self::sanitize_host($first, $stripPort, $allowLocalhost);
    }

    private static function sanitize_ip(string $ip): string
    {
        $ip = preg_replace('/[\x00-\x1F\x7F\s]/u', '', $ip);
        if ($ip === '') return '';
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6) ? $ip : '';
    }

    private static function sanitize_csv_ips(string $value): string
    {
        // First IP from list; if valid, return it
        $first = trim(explode(',', $value)[0]);
        $ip = self::sanitize_ip($first);
        return $ip; // '' if invalid
    }

    private static function sanitize_port($v): int
    {
        $n = (int)$v;
        return ($n >= 1 && $n <= 65535) ? $n : 0;
    }

    private static function sanitize_request_uri(string $uri): string
    {
        if ($uri === '') return '/';
        $uri = preg_replace('/[\x00-\x1F\x7F]/u', '', $uri);
        if ($uri === '' || $uri[0] !== '/') $uri = '/' . ltrim($uri, '/');
        if (strlen($uri) > 8192) $uri = substr($uri, 0, 8192);
        $uri = str_replace(["\r", "\n", "\0", "\\"], '', $uri);
        return $uri;
    }

    private static function sanitize_request_method(string $m, ?array $allow = null): string
    {
        $m = strtoupper($m);
        $allow = $allow ?? ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'HEAD'];
        return in_array($m, $allow, true) ? $m : '';
    }

    private static function sanitize_user_agent(string $ua, int $maxLen = 512): string
    {
        $ua = preg_replace('/[\x00-\x1F\x7F]/u', '', $ua);
        $ua = preg_replace('/\s+/', ' ', $ua);
        $ua = trim($ua);
        if (strlen($ua) > $maxLen) $ua = substr($ua, 0, $maxLen);
        return $ua;
    }

    private static function sanitize_string(string $s): string
    {
        return trim(preg_replace('/[\x00-\x1F\x7F]/u', '', $s));
    }

    private static function sanitize_token(string $s): string
    {
        // conservative token (letters, digits, slash, dot, dash, underscore)
        $s = preg_replace('/[\x00-\x1F\x7F]/u', '', $s);
        if (!preg_match('#^[A-Za-z0-9._/\-]+$#', $s)) return '';
        return $s;
    }

    private static function sanitize_https_flag(string $v): string
    {
        // common servers set HTTPS to "on" or "1"
        $v = strtolower((string)$v);
        return ($v === 'on' || $v === '1' || $v === 'true') ? 'on' : '';
    }

    private static function sanitize_scheme_token(string $v): string
    {
        $first = strtolower(trim(explode(',', $v)[0]));
        return ($first === 'http' || $first === 'https') ? $first : '';
    }

    private static function sanitize_forwarded_header(string $v): string
    {
        // We keep the raw (de-CTL’d) string; specific parsing happens in extract_* helpers.
        return self::sanitize_string($v);
    }

    private static function sanitize_query_string(string $q): string
    {
        // Strip control chars and CRLF to prevent header injection. Do NOT “validate” contents.
        $q = preg_replace('/[\x00-\x1F\x7F]/u', '', $q);
        $q = str_replace(["\r", "\n"], '', $q);
        return $q;
    }

    private static function sanitize_origin_like(string $v): string
    {
        // Accept only scheme://host[:port] (no path). This is *not* fully validated URL parsing.
        $v = self::sanitize_string($v);
        if ($v === '') return '';
        if (!preg_match('#^(https?)://(.+)$#i', $v, $m)) return '';
        $scheme = strtolower($m[1]);
        $rest   = $m[2];

        // Split off port if present
        $host = $rest;
        if ($rest !== '' && $rest[0] === '[') {
            // [IPv6]:port?
            $end = strpos($rest, ']');
            if ($end === false) return '';
            $hostPart = substr($rest, 0, $end + 1);
            $tail = substr($rest, $end + 1);
            if ($tail !== '' && $tail[0] === ':') {
                $port = self::sanitize_port(substr($tail, 1));
                if ($port === 0) $tail = ''; // drop bad port
            }
            $host = $hostPart; // we don’t return port anyway
        } else {
            // hostname[:port]
            $p = strpos($rest, ':');
            if ($p !== false) {
                $host = substr($rest, 0, $p);
            }
        }

        $host = self::sanitize_host($host, true, true);
        if ($host === '') return '';
        return $scheme . '://' . $host;
    }

    private static function sanitize_int_range($v, int $min, int $max): int
    {
        if (!is_numeric($v)) return 0;
        $n = (int)$v;
        return ($n < $min || $n > $max) ? 0 : $n;
    }

    // ------------------ PARSERS for Forwarded: header ------------------

    private static function extract_ip_from_forwarded(string $forwarded): string
    {
        // Look for for= value per RFC 7239; allow quoted and bracketed IPv6.
        // Example: for=192.0.2.60;proto=https;by=203.0.113.43
        if (preg_match('/\bfor=(?:"?\[?)([0-9a-fA-F:.]+)(?:\]?"?)/', $forwarded, $m)) {
            $ip = self::sanitize_ip($m[1]);
            return $ip;
        }
        return '';
    }

    private static function extract_proto_from_forwarded(string $forwarded): string
    {
        if (preg_match('/\bproto="?([A-Za-z]+)"?/', $forwarded, $m)) {
            $p = strtolower($m[1]);
            return ($p === 'https' || $p === 'http') ? $p : '';
        }
        return '';
    }

    private static function extract_host_from_forwarded(string $forwarded): string
    {
        if (preg_match('/\bhost="?([^";,]+)"?/', $forwarded, $m)) {
            $h = self::sanitize_host($m[1], true, true);
            return $h;
        }
        return '';
    }

    // ------------------ CIDR helpers ------------------

    private static function ip_in_cidr(string $ip, string $cidr): bool
    {
        if (strpos($ip, ':') !== false || strpos($cidr, ':') !== false) {
            [$subnet, $maskBits] = array_pad(explode('/', $cidr, 2), 2, '128');
            $maskBits = (int)$maskBits;
            if ($maskBits < 0 || $maskBits > 128) return false;
            $ipBin  = @inet_pton($ip);
            $netBin = @inet_pton($subnet);
            if ($ipBin === false || $netBin === false) return false;
            $bytes = intdiv($maskBits, 8);
            $bits  = $maskBits % 8;
            if ($bytes && substr($ipBin, 0, $bytes) !== substr($netBin, 0, $bytes)) return false;
            if ($bits === 0) return true;
            $mask = chr((0xFF << (8 - $bits)) & 0xFF);
            return (ord($ipBin[$bytes]) & ord($mask)) === (ord($netBin[$bytes]) & ord($mask));
        }

        [$subnet, $maskBits] = array_pad(explode('/', $cidr, 2), 2, '32');
        $maskBits = (int)$maskBits;
        if ($maskBits < 0 || $maskBits > 32) return false;
        $ipL  = ip2long($ip);
        $netL = ip2long($subnet);
        if ($ipL === false || $netL === false) return false;
        $mask = $maskBits === 0 ? 0 : ((~0 << (32 - $maskBits)) & 0xFFFFFFFF);
        return (($ipL & $mask) === ($netL & $mask));
    }

    private static function sanitize_fs_path(string $path, bool $mustExist = true, bool $requireDir = true, bool $absoluteOnly = true): string
    {
        // strip control/nulls & trim
        $path = preg_replace('/[\x00-\x1F\x7F]/u', '', $path);
        $path = str_replace("\0", '', $path);
        $path = trim($path);
        if ($path === '') return '';

        // normalize separators
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);

        // absolute check
        if ($absoluteOnly) {
            $isAbs = (DIRECTORY_SEPARATOR === '/')
                ? (isset($path[0]) && $path[0] === '/')
                : (bool)preg_match('/^[A-Za-z]:\\\\/', $path); // Windows
            if (!$isAbs) return '';
        }

        if ($mustExist) {
            $real = @realpath($path);
            if ($real === false) return '';
            if ($requireDir && !@is_dir($real)) return '';
            return rtrim($real, DIRECTORY_SEPARATOR);
        }

        // Non-existent allowed: collapse "." and ".." safely
        $parts = [];
        foreach (explode(DIRECTORY_SEPARATOR, $path) as $seg) {
            if ($seg === '' || $seg === '.') continue;
            if ($seg === '..') {
                array_pop($parts);
                continue;
            }
            $parts[] = $seg;
        }
        $normalized = (DIRECTORY_SEPARATOR === '/')
            ? ('/' . implode(DIRECTORY_SEPARATOR, $parts))
            : implode(DIRECTORY_SEPARATOR, $parts);

        return rtrim($normalized, DIRECTORY_SEPARATOR);
    }
}
