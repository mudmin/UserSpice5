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
class Redirect
{

  //This method no longer checks to see if a link is valid before redirecting
  //to prevent conflicts with deep folder structures
public static function to($location = null, $args = '')
{
  global $us_url_root, $settings, $user, $usespice_nonce;

  if (!$location) {
    return;
  }

  if ($args) {
    $location .= $args;
  }

  // Normalize/validate once, for BOTH header + echo fallback
  $location = self::normalizeLocation((string)$location);

  if ($settings != "" && $settings->debug > 0) {
    if ($settings->debug == 2 || ($settings->debug == 1 && isset($user) && $user->isLoggedIn() && $user->data()->id == 1)) {

      $backtrace = debug_backtrace();
      $caller = $backtrace[0];

      $realCaller = '';
      if (isset($backtrace[1])) {
        if (isset($backtrace[1]['class'])) {
          $realCaller = $backtrace[1]['class'] . '::' . $backtrace[1]['function'] . '() ';
        } elseif (isset($backtrace[1]['function'])) {
          $realCaller = $backtrace[1]['function'] . '() ';
        }
      }

      $fullPath = $caller['file'] ?? '';
      $line = $caller['line'] ?? 0;

      $loggingUserId = (!isset($user) || !$user->isLoggedIn()) ? 0 : $user->data()->id;

      // Logging only; do not change $location
      $loc = Input::sanitize($location);
      logger($loggingUserId, "Redirect Diag", "From {$realCaller}{$fullPath} on line {$line} to {$loc}");
    }
  }

  if (!headers_sent()) {
    // Throw an explicit status code
    header('Location: ' . $location, true, 302);
    exit();
  }


  $nonce = htmlspecialchars((string)($usespice_nonce ?? ''), ENT_QUOTES, 'UTF-8');

  // Safe for JS string context
  $jsLocation = json_encode(
    $location,
    JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
  );

  // Safe for HTML attribute context
  $htmlLocation = htmlspecialchars($location, ENT_QUOTES, 'UTF-8');

  echo '<script nonce="' . $nonce . '" type="text/javascript">';
  echo 'window.location.href=' . $jsLocation . ';';
  echo '</script>';
  echo '<noscript>';
  echo '<meta http-equiv="refresh" content="0;url=' . $htmlLocation . '" />';
  echo '</noscript>';
  exit();
}

  //This is the old Redirect::to method that attempts to see if a link is valid before redirecting
  public static function safe($location = null, $args = '')
  {
    global $us_url_root, $settings, $user;
    if ($location) {


      if ($settings != "" && $settings->debug > 0) {
        if ($settings->debug == 2 || ($settings->debug == 1 && isset($user) && $user->isLoggedIn() && $user->data()->id == 1)) {
          $cp = currentPage();
          $line = debug_backtrace();
          $line = $line[0]["line"];
          if (!isset($user) || !$user->isLoggedIn()) {
            $loggingUserId = 0;
          } else {
            $loggingUserId = $user->data()->id;
          }
          logger($loggingUserId, "Redirect Diag", "From $cp on line $line to $location");
        }
      }


      if (!preg_match('/^https?:\/\//', $location) && !file_exists($location)) {
        foreach (array($us_url_root, '../', 'users/', substr($us_url_root, 1), '../../', '/', '/users/') as $prefix) {
          if (file_exists($prefix . $location)) {
            $location = $prefix . $location;
            $location = preg_replace('~/{2,}~', '/', $location);
            break;
          }
        }
      }
      if ($args) $location .= $args; // allows 'login.php?err=Error+Message' or the like
      if (!headers_sent()) {
        header('Location: ' . $location);
        exit();
      } else {
        echo '<script nonce="' . htmlspecialchars($usespice_nonce ?? '') . '" type="text/javascript">';
        echo 'window.location.href="' . $location . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
        echo '</noscript>';
        exit;
      }
    }
  }

  public static function sanitized($location, $args = null, int $code = 302, array $opts = [])
  {
    // Defaults: same-origin only, path normalize, cap length
    $opts += [
      'same_origin'   => true,       // forbid off-site redirects unless explicitly allowed
      'allowed_hosts' => [],         // if you want to allow some external hosts, list them here
      'base_path'     => (isset($GLOBALS['us_url_root']) ? $GLOBALS['us_url_root'] : '/'),
      'max_len'       => 8192,
    ];

    $url = self::buildSafeRedirectUrl((string)$location, $args, $opts);


    if (!empty($GLOBALS['settings']->redirect_debug)) {
      $locForLog = class_exists('Input') ? Input::sanitize($url) : $url;
      logger((isset($GLOBALS['user']) && $GLOBALS['user']->isLoggedIn()) ? $GLOBALS['user']->data()->id : 0,
        'Redirect Diag',
        "to {$locForLog}"
      );
    }

    if (!headers_sent()) {
      header('Location: ' . $url, true, $code);
      exit;
    }

    // fallbacks
    echo '<script nonce="' . htmlspecialchars($usespice_nonce ?? '') . '">window.location.href=' . json_encode($url) . ';</script>';
    echo '<noscript><meta http-equiv="refresh" content="0;url=' . safeReturn($url) . '"></noscript>';
    exit;
  }

  private static function buildSafeRedirectUrl(string $location, $args, array $opts): string
  {
    // 1) Strip control chars and trim
    $location = preg_replace('/[\x00-\x1F\x7F]/u', '', $location);
    $location = trim($location);

    // 2) If absolute URL, only allow http/https and (by default) same-origin
    if (preg_match('#^[a-z][a-z0-9+.-]*://#i', $location)) {
      $parts = @parse_url($location);
      if (!$parts || empty($parts['scheme']) || empty($parts['host'])) {
        // broken URL -> bail to root
        $location = '/';
      } else {
        $sch = strtolower($parts['scheme']);
        if ($sch !== 'http' && $sch !== 'https') {
          $location = '/';
        } else {
          $host = self::sanitizeHost($parts['host']);
          if ($host === '') {
            $location = '/';
          } else {
            $current = self::sanitizeHost($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '');
            $allowed = array_map('self::sanitizeHost', (array)$opts['allowed_hosts']);
            $allowed = array_values(array_filter($allowed, fn($h) => $h !== ''));

            $same = ($current !== '' && $host === $current);
            $extAllowed = (!$opts['same_origin'] && ($allowed ? in_array($host, $allowed, true) : true));

            if (!$same && !$extAllowed) {
              // force same-origin by demoting to path-only
              $path = ($parts['path'] ?? '/');
              $query = isset($parts['query']) && $parts['query'] !== '' ? '?' . $parts['query'] : '';
              $location = self::normalizePath($path);
              $location .= $query;
            }
          }
        }
      }
    }

    // 3) If schema-relative ("//evil.com/...") or empty, kill it
    if ($location === '' || str_starts_with($location, '//')) {
      $location = '/';
    }

    // 4) Make it an absolute path (not full URL) rooted at us_url_root
    if (!str_starts_with($location, '/')) {
      $base = rtrim((string)$opts['base_path'], '/');
      $path = $base . '/' . ltrim($location, '/');
    } else {
      $path = $location;
    }
    $path = self::normalizePath($path);

    // 5) Merge args safely
    if (is_array($args)) {
      // sanitize keys and values, RFC3986 encode
      $clean = [];
      $sanitizeVal = function ($v) use (&$sanitizeVal) {
        if (is_array($v)) {
          $o = [];
          foreach ($v as $k => $vv) {
            $ks = preg_replace('/[^A-Za-z0-9_-]/', '', (string)$k);
            if ($ks === '') continue;
            $o[$ks] = $sanitizeVal($vv);
          }
          return $o;
        }
        $v = preg_replace('/[\x00-\x1F\x7F]/u', '', (string)$v);
        return (strlen($v) > 2048) ? substr($v, 0, 2048) : $v;
      };
      foreach ($args as $k => $v) {
        $kk = preg_replace('/[^A-Za-z0-9_-]/', '', (string)$k);
        if ($kk === '') continue;
        $clean[$kk] = $sanitizeVal($v);
      }

      $qs = http_build_query($clean, '', '&', PHP_QUERY_RFC3986);
      if ($qs !== '') {
        $path .= (str_contains($path, '?') ? '&' : '?') . $qs;
      }
    } elseif (is_string($args) && $args !== '') {
      // tolerate legacy strings like '?err=foo' or 'err=foo'
      $s = preg_replace('/[\x00-\x1F\x7F]/u', '', $args);
      $s = ltrim($s);
      if ($s !== '') {
        if ($s[0] !== '?' && $s[0] !== '&') {
          $s = (str_contains($path, '?') ? '&' : '?') . $s;
        } else {
          // normalize first char to '&' if there's already a '?'
          if ($s[0] === '?' && str_contains($path, '?')) $s[0] = '&';
        }
        $path .= $s;
      }
    }

    // 6) Cap length to avoid header bloat
    if (strlen($path) > $opts['max_len']) {
      $path = substr($path, 0, $opts['max_len']);
    }

    return $path;
  }

  private static function sanitizeHost(string $host): string
  {
    $host = preg_replace('/[\x00-\x1F\x7F\s]/u', '', $host);
    $host = preg_replace('/:\d+$/', '', strtolower($host));
    if ($host === '') return '';
    if ($host[0] === '[' && substr($host, -1) === ']') {
      $inside = substr($host, 1, -1);
      return preg_match('/^[0-9a-f:.]+$/i', $inside) ? $host : '';
    }
    $parts = explode('.', $host);
    foreach ($parts as $label) {
      if ($label === '' || strlen($label) > 63) return '';
      if ($label[0] === '-' || substr($label, -1) === '-') return '';
      if (!preg_match('/^[a-z0-9-]+$/', $label)) return '';
    }
    return $host;
  }

  private static function normalizePath(string $path): string
  {
    // Ensure leading slash, collapse //, resolve . and ..
    $path = preg_replace('#/{2,}#', '/', $path);
    if ($path === '' || $path[0] !== '/') $path = '/' . $path;
    $segments = explode('/', $path);
    $out = [];
    foreach ($segments as $seg) {
      if ($seg === '' || $seg === '.') continue;
      if ($seg === '..') {
        array_pop($out);
        continue;
      }
      $out[] = $seg;
    }
    return '/' . implode('/', $out);
  }

 /**
 * Normalizes and validates redirect targets without breaking common legacy calls:
 * - Allows: /path, login.php, ../bar, ?foo=1, #hash, https://example.com
 * - Blocks: //evil.com (scheme-relative), non-http(s) schemes (javascript:, data:, etc.)
 * - Removes CR/LF to prevent header injection
 */
private static function normalizeLocation(string $location): string
{
    $location = trim($location);
    $location = str_replace(["\r", "\n", "\0"], '', $location);
    
    if ($location === '') {
        return '/';
    }
    
    // Allow query-only or fragment-only redirects (?foo=1, #section)
    if ($location[0] === '?' || $location[0] === '#') {
        return $location;
    }
    
    // Block scheme-relative URLs (//evil.com)
    if (substr($location, 0, 2) === '//') {
        return '/';
    }
    
    // If it looks like it has ANY scheme (something:...), only allow http/https://
    // (This blocks javascript:, data:, file:, etc.)
    if (preg_match('#^[a-z][a-z0-9+.\-]*:#i', $location)) {
        if (!preg_match('#^https?://#i', $location)) {
            return '/';
        }
        return $location;
    }
    
    // Otherwise allow absolute-path and relative-path (login.php, ../bar)
    return $location;
}

}
