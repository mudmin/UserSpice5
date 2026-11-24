<?php
if (count(get_included_files()) == 1) die(); // Direct Access Not Permitted

/*
 * AI assistant prompts. Core prompts live in users/ai/ (updated by patches);
 * a same-name file in usersc/ai/ overrides one. Each file is <name>.md.php: a
 * __halt_compiler() line that keeps it from serving anything over HTTP, then
 * Markdown. The site's root AGENTS.md / CLAUDE.md get a marked block that
 * points agents at users/ai/00_start_here.md.php.
 */

if (!function_exists('usAiCoreDir')) {
  function usAiCoreDir()
  {
    global $abs_us_root, $us_url_root;
    return $abs_us_root . $us_url_root . 'users/ai/';
  }
}

if (!function_exists('usAiOverrideDir')) {
  function usAiOverrideDir()
  {
    global $abs_us_root, $us_url_root;
    return $abs_us_root . $us_url_root . 'usersc/ai/';
  }
}

if (!function_exists('usAiValidName')) {
  function usAiValidName($name)
  {
    return is_string($name) && preg_match('/^[a-z0-9_]{1,64}$/', $name) === 1;
  }
}

if (!function_exists('usAiPromptMarkdown')) {
  /**
   * Markdown body of a prompt file (everything after the __halt_compiler line).
   */
  function usAiPromptMarkdown($file)
  {
    $raw = @file_get_contents($file);
    if ($raw === false) {
      return '';
    }
    $pos = strpos($raw, '__halt_compiler();');
    if ($pos !== false) {
      $end = strpos($raw, '?>', $pos);
      $raw = $end !== false ? substr($raw, $end + 2) : substr($raw, $pos + strlen('__halt_compiler();'));
    }
    return ltrim($raw, "\r\n");
  }
}

if (!function_exists('usAiPromptList')) {
  /**
   * Every prompt name with where it comes from: 'core', 'override' (a usersc/ai
   * file replacing a core one) or 'site' (only in usersc/ai).
   */
  function usAiPromptList()
  {
    $list = [];
    foreach (['core' => usAiCoreDir(), 'site' => usAiOverrideDir()] as $origin => $dir) {
      foreach (glob($dir . '*.md.php') ?: [] as $file) {
        $name = basename($file, '.md.php');
        if (!usAiValidName($name)) {
          continue;
        }
        if ($origin === 'site' && isset($list[$name])) {
          $list[$name]['source'] = 'override';
          $list[$name]['file'] = $file;
          continue;
        }
        $list[$name] = ['name' => $name, 'source' => $origin, 'file' => $file];
      }
    }
    foreach ($list as $name => $p) {
      $md = usAiPromptMarkdown($p['file']);
      $list[$name]['title'] = preg_match('/^#\s+(.+)$/m', $md, $m) ? trim($m[1]) : $name;
      $list[$name]['bytes'] = strlen($md);
    }
    ksort($list);
    return $list;
  }
}

if (!function_exists('usAiPromptRead')) {
  /**
   * A prompt's Markdown, preferring the usersc/ai override. '' if none.
   */
  function usAiPromptRead($name)
  {
    if (!usAiValidName($name)) {
      return '';
    }
    foreach ([usAiOverrideDir(), usAiCoreDir()] as $dir) {
      if (is_file($dir . $name . '.md.php')) {
        return usAiPromptMarkdown($dir . $name . '.md.php');
      }
    }
    return '';
  }
}

if (!function_exists('usAiPointerBlock')) {
  /**
   * The marked block written into the root AGENTS.md / CLAUDE.md.
   */
  function usAiPointerBlock($file)
  {
    if ($file === 'CLAUDE.md') {
      $body = "UserSpice project. Follow @AGENTS.md (UserSpice conventions and the prompts in users/ai/).";
    } else {
      $body = "## UserSpice\n\n"
        . "This is a UserSpice project. Before changing code, read `users/ai/00_start_here.md.php` "
        . "(the Markdown after its first line); it routes you to the other prompts in `users/ai/`. "
        . "A same-name file in `usersc/ai/` overrides a core prompt.\n\n"
        . "Never edit files in `users/`: core updates replace them. Customize in `usersc/`.";
    }
    return "<!-- userspice:begin (managed by UserSpice; edit outside these markers) -->\n" . $body . "\n<!-- userspice:end -->";
  }
}

if (!function_exists('usAiRootFileStatus')) {
  /**
   * ['exists' => bool, 'has_block' => bool, 'current' => bool, 'writable' => bool] for a root file.
   */
  function usAiRootFileStatus($file)
  {
    global $abs_us_root, $us_url_root;
    $path = $abs_us_root . $us_url_root . $file;
    $exists = is_file($path);
    $content = $exists ? (string)@file_get_contents($path) : '';
    $hasBlock = strpos($content, '<!-- userspice:begin') !== false && strpos($content, '<!-- userspice:end -->') !== false;
    return [
      'exists' => $exists,
      'has_block' => $hasBlock,
      'current' => $hasBlock && strpos($content, usAiPointerBlock($file)) !== false,
      'writable' => $exists ? is_writable($path) : is_writable(dirname($path)),
    ];
  }
}

if (!function_exists('usAiWriteManagedBlock')) {
  /**
   * Insert or refresh a marked block in a root file without touching anything
   * outside the markers. Creates the file if it doesn't exist.
   */
  function usAiWriteManagedBlock($file, $block, $begin = '<!-- userspice:begin', $end = '<!-- userspice:end -->')
  {
    global $abs_us_root, $us_url_root;
    $path = $abs_us_root . $us_url_root . $file;
    $content = is_file($path) ? @file_get_contents($path) : '';
    if ($content === false) {
      return false;
    }
    $start = strpos($content, $begin);
    $stop = $start === false ? false : strpos($content, $end, $start);
    if ($start !== false && $stop !== false) {
      $content = substr($content, 0, $start) . $block . substr($content, $stop + strlen($end));
    } else {
      $content = rtrim($content) === '' ? $block . "\n" : rtrim($content) . "\n\n" . $block . "\n";
    }
    $tmp = $path . '.tmp' . bin2hex(random_bytes(4));
    if (@file_put_contents($tmp, $content) === false) {
      return false;
    }
    if (!@rename($tmp, $path)) {
      @unlink($tmp);
      return false;
    }
    return true;
  }
}

if (!function_exists('usAiHtaccessBlock')) {
  /**
   * Apache rules that keep the root AGENTS.md and CLAUDE.md off the web.
   */
  function usAiHtaccessBlock()
  {
    return "# userspice:ai begin (managed by UserSpice)\n"
      . "<FilesMatch \"^(AGENTS|CLAUDE)\\.md$\">\n"
      . "  <IfModule mod_authz_core.c>\n    Require all denied\n  </IfModule>\n"
      . "  <IfModule !mod_authz_core.c>\n    Order deny,allow\n    Deny from all\n  </IfModule>\n"
      . "</FilesMatch>\n"
      . "# userspice:ai end";
  }
}

if (!function_exists('usAiWebExposure')) {
  /**
   * Fetch the root AGENTS.md / CLAUDE.md (and a core prompt) over HTTP from this
   * site. Returns [file => 'blocked'|'exposed'|'missing'|'unknown'], where
   * 'exposed' means the content was served. Root files that don't exist aren't
   * requested. Cached in the session for 10 minutes.
   */
  function usAiWebExposure($refresh = false, $rootOnly = false)
  {
    global $abs_us_root, $us_url_root;
    $key = 'us_ai_web_exposure' . ($rootOnly ? '_root' : '');
    if (!$refresh && isset($_SESSION[$key]['at']) && $_SESSION[$key]['at'] > time() - 600) {
      return $_SESSION[$key]['result'];
    }
    // Keep the port (getHost() drops it) so non-standard ports are checked correctly
    $host = (string)Server::get('HTTP_HOST', '');
    if (!preg_match('/^(?:[A-Za-z0-9.-]+|\[[0-9A-Fa-f:.]+\])(?::\d{1,5})?$/', $host)) {
      $host = Server::getHost();
    }
    $base = (ClientIP::isHttps() ? 'https' : 'http') . '://' . $host . $us_url_root;
    $result = [];
    $files = $rootOnly ? ['AGENTS.md', 'CLAUDE.md'] : ['AGENTS.md', 'CLAUDE.md', 'users/ai/00_start_here.md.php'];
    foreach ($files as $file) {
      if (!is_file($abs_us_root . $us_url_root . $file)) {
        $result[$file] = 'missing';
        continue;
      }
      if (!function_exists('curl_init')) {
        $result[$file] = 'unknown';
        continue;
      }
      $ch = curl_init($base . $file);
      $opts = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 4,
        CURLOPT_CONNECTTIMEOUT => 3,
        // Follow redirects (e.g. http -> https) so a redirect isn't mistaken for "blocked"
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_SSL_VERIFYPEER => !ClientIP::isLocal(),
        CURLOPT_SSL_VERIFYHOST => ClientIP::isLocal() ? 0 : 2,
      ];
      if (defined('CURLOPT_REDIR_PROTOCOLS_STR')) {
        $opts[CURLOPT_REDIR_PROTOCOLS_STR] = 'http,https';
      } elseif (defined('CURLOPT_REDIR_PROTOCOLS')) {
        $opts[CURLOPT_REDIR_PROTOCOLS] = CURLPROTO_HTTP | CURLPROTO_HTTPS;
      }
      curl_setopt_array($ch, $opts);
      $body = curl_exec($ch);
      $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
      // Exposed only if the response actually contains the file, so a redirect to a
      // login page or a custom 403/200 error page doesn't count as a leak.
      $needle = substr(trim((string)@file_get_contents($abs_us_root . $us_url_root . $file)), 0, 200);
      if ($body === false || $code === 0) {
        $result[$file] = 'unknown';
      } elseif ($code === 200 && $needle !== '' && strpos((string)$body, $needle) !== false) {
        $result[$file] = 'exposed';
      } elseif ($code === 404) {
        $result[$file] = 'missing';
      } else {
        $result[$file] = 'blocked';
      }
    }
    $_SESSION[$key] = ['at' => time(), 'result' => $result];
    return $result;
  }
}

if (!function_exists('usAiPluginCustomPromptsDir')) {
  /**
   * The old AI Prompts plugin's custom_prompts folder, if it has any prompts.
   */
  function usAiPluginCustomPromptsDir()
  {
    global $abs_us_root, $us_url_root;
    $dir = $abs_us_root . $us_url_root . 'usersc/plugins/ai_prompts/custom_prompts/';
    return glob($dir . '*.md.php') ? $dir : null;
  }
}

if (!function_exists('usAiImportPluginPrompts')) {
  /**
   * Copy the old plugin's custom prompts into usersc/ai/ (never overwrites).
   * Returns the number of files copied.
   */
  function usAiImportPluginPrompts()
  {
    $from = usAiPluginCustomPromptsDir();
    if ($from === null) {
      return 0;
    }
    $to = usAiOverrideDir();
    if (!is_dir($to) && !@mkdir($to, 0755, true)) {
      return 0;
    }
    usAiProtectDir($to);
    $copied = 0;
    foreach (glob($from . '*.md.php') as $file) {
      $name = basename($file);
      if (!usAiValidName(basename($name, '.md.php')) || is_file($to . $name)) {
        continue;
      }
      if (@copy($file, $to . $name)) {
        $copied++;
      }
    }
    return $copied;
  }
}

if (!function_exists('usAiProtectDir')) {
  /**
   * Deny-all .htaccess and a blank index.php for a prompts folder.
   */
  function usAiProtectDir($dir)
  {
    if (!is_file($dir . '.htaccess')) {
      @file_put_contents($dir . '.htaccess', "<IfModule mod_authz_core.c>\n  Require all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\n  Order deny,allow\n  Deny from all\n</IfModule>\n");
    }
    if (!is_file($dir . 'index.php')) {
      @file_put_contents($dir . 'index.php', "<?php // Silence\n");
    }
  }
}
