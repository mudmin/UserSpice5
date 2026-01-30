<?php
include "../init.php";


if (!isset($user) || (!in_array($user->data()->id, $master_account))) {
  die("Permission denied");
}

$type     = Input::get('type');
$url      = Input::get('url');
$hash     = Input::get('hash');
$diag     = Input::get('diag');
$reserved = Input::get('reserved');
$api      = "https://api.userspice.com/api/v2/";

/**
 * DIAG helper
 */
function usDiag($diag, $uid, $msg)
{
  if ($diag) {
    logger($uid, "DIAG", $msg);
  }
}

/**
 * Very light URL sanity.
 * (Not an allowlist — just blocks empty / non-http(s).)
 */
function usValidateDownloadUrl($url): bool
{
  $url = trim((string)$url);
  if ($url === '') return false;
  if (!preg_match('#^https?://#i', $url)) return false;
  return true;
}

/**
 * Create/open a temp zip file for writing.
 * Prefer system temp dir; if unavailable/unwritable, fall back to users/parsers.
 *
 * Returns: [string|null $zipFile, resource|null $fh]
 */
function usOpenTempZipFile(string $abs_us_root, string $us_url_root, bool $diag, int $uid): array
{
  $tryDirs = [];

  // 1) System temp dir
  $tmpDir = (string)@sys_get_temp_dir();
  if ($tmpDir !== '') {
    $tryDirs[] = rtrim($tmpDir, "/\\");
  }

  // 2) Fallback: parsers dir
  $parsersDir = rtrim($abs_us_root . $us_url_root . "users/parsers", "/\\");
  $tryDirs[] = $parsersDir;

  foreach ($tryDirs as $dir) {
    if (!is_dir($dir) || !is_writable($dir)) {
      if ($diag) {
        logger($uid, "DIAG", "Temp dir not usable: $dir");
      }
      continue;
    }

    // Prefer tempnam() when we can (mostly for sys temp dir)
    if ($dir !== $parsersDir) {
      $base = @tempnam($dir, "userspice_");
      if ($base !== false) {
        // Rename to .zip for clarity; if rename fails, keep original
        $zipFile = $base . ".zip";
        if (!@rename($base, $zipFile)) {
          $zipFile = $base;
        }

        $fh = @fopen($zipFile, "wb");
        if ($fh) {
          if ($diag) {
            logger($uid, "DIAG", "Using temp zip file: $zipFile");
          }
          return [$zipFile, $fh];
        }
        @unlink($zipFile);
      }
    }

    // Fallback (or tempnam failed): create random zip file in this dir
    for ($i = 0; $i < 10; $i++) {
      $zipFile = $dir . DIRECTORY_SEPARATOR . "userspice_" . bin2hex(random_bytes(16)) . ".zip";

      // 'x' mode = create exclusively (fails if exists); 'b' for binary
      $fh = @fopen($zipFile, "xb");
      if ($fh) {
        if ($diag) {
          logger($uid, "DIAG", "Using fallback zip file: $zipFile");
        }
        return [$zipFile, $fh];
      }
    }

    if ($diag) {
      logger($uid, "DIAG", "Unable to create random temp zip in: $dir");
    }
  }

  return [null, null];
}

/**
 * Zip Slip / symlink guardrails.
 * - Blocks absolute paths, Windows drive paths, backslashes, NUL bytes
 * - Blocks any '..' segment
 * - Best-effort blocks symlinks (depends on ZipArchive features / platform)
 * Returns [bool $ok, string $error]
 */
function usValidateZipEntries(ZipArchive $zip, string $baseExtractPath): array
{
  $baseReal = realpath($baseExtractPath);
  if ($baseReal === false) {
    return [false, "Invalid extract path"];
  }
  $baseReal = rtrim($baseReal, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

  // Guardrail: prevent huge accidental extractions
  $totalUncompressed = 0;
  $maxTotalUncompressed = 250 * 1024 * 1024; // 250MB

  for ($i = 0; $i < $zip->numFiles; $i++) {
    $name = $zip->getNameIndex($i);
    if ($name === false) return [false, "Corrupt zip entry name"];

    // Reject NUL bytes outright
    if (strpos($name, "\0") !== false) return [false, "Unsafe zip entry (NUL byte)"];

    // ZIP paths should use forward slashes; block backslashes
    if (strpos($name, '\\') !== false) return [false, "Unsafe zip entry (backslash path)"];

    // Absolute paths
    if (isset($name[0]) && $name[0] === '/') return [false, "Unsafe zip entry (absolute path)"];

    // Windows drive path like C:/...
    if (preg_match('#^[A-Za-z]:/#', $name)) return [false, "Unsafe zip entry (drive path)"];

    // Reject traversal segments
    $parts = explode('/', $name);
    foreach ($parts as $p) {
      if ($p === '..') return [false, "Unsafe zip entry (path traversal)"];
    }

    // Size guardrail
    $st = $zip->statIndex($i);
    if (is_array($st) && isset($st['size'])) {
      $totalUncompressed += (int)$st['size'];
      if ($totalUncompressed > $maxTotalUncompressed) {
        return [false, "Zip too large to extract safely"];
      }
    }

    // Best-effort symlink detection
    if (method_exists($zip, 'getExternalAttributesIndex')) {
      $opsys = 0;
      $attr  = 0;
      $ok = @$zip->getExternalAttributesIndex($i, $opsys, $attr);
      if ($ok && $attr !== null) {
        // Upper 16 bits often contain Unix mode
        $mode = ($attr >> 16) & 0xFFFF;
        // Symlink: 0120000 (octal) => 0xA000
        if (($mode & 0xF000) === 0xA000) {
          return [false, "Zip contains symlink entries (blocked)"];
        }
      }
    }

    // Final containment check (string-based, since dirs may not exist pre-extract)
    $target = $baseReal . str_replace('/', DIRECTORY_SEPARATOR, $name);
    if (substr($target, 0, strlen($baseReal)) !== $baseReal) {
      return [false, "Unsafe zip entry (escapes extract root)"];
    }
  }

  return [true, ""];
}

// ------------------------------
// Token check
// ------------------------------
if (!Token::check(Input::get('token'))) {
  echo json_encode(['success' => false, 'error' => "Invalid token"]);
  die;
}

// ------------------------------
// Resolve extract path / return url
// ------------------------------
if ($type == 'plugin') {
  $extractPath = "../../usersc/plugins";
  $reserved = Input::get('reserved');
  if (pluginActive($reserved, true)) {
    $return = $us_url_root . "users/admin.php?view=plugins_config&plugin=" . $reserved;
  } else {
    $return = $us_url_root . "users/admin.php?view=plugins";
  }
} elseif ($type == 'widget') {
  $extractPath = "../../usersc/widgets";
  $return = $us_url_root . "users/admin.php";
} elseif ($type == 'template') {
  $extractPath = "../../usersc/templates";
  $return = $us_url_root . "users/admin.php?view=templates";
} elseif ($type == 'translation') {
  $extractPath = $abs_us_root . $us_url_root . "users";
  usSuccess("Language(s) installed");
  $return = $us_url_root . "users/admin.php";
} else {
  if ($diag) {
    logger($user->data()->id, "DIAG", "Invalid request type");
  }
  echo json_encode(['success' => false, 'error' => "Something is wrong"]);
  die();
}

// ------------------------------
// Basic URL sanity
// ------------------------------
if (!usValidateDownloadUrl($url)) {
  usDiag($diag, $user->data()->id, "Invalid download URL");
  echo json_encode(['success' => false, 'error' => 'Invalid URL']);
  die;
}

// ------------------------------
// Create secure temp zip file (prefer sys temp; fallback parsers)
// ------------------------------
usDiag($diag, $user->data()->id, "Attempting to create temp zip file");

[$zipFile, $zip_resource] = usOpenTempZipFile($abs_us_root, $us_url_root, (bool)$diag, (int)$user->data()->id);

if (!$zipFile || !$zip_resource) {
  usDiag($diag, $user->data()->id, "Unable to create temp zip file in sys temp or parsers dir");
  echo json_encode(['success' => false, 'error' => 'Unable to create temp file']);
  die;
}

// ------------------------------
// Download zip contents via curl (respect EXTRA_CURL_SECURITY logic)
// ------------------------------
usDiag($diag, $user->data()->id, "Attempting CURL request to download file contents");

$ch_start = curl_init();
curl_setopt($ch_start, CURLOPT_URL, $url);
curl_setopt($ch_start, CURLOPT_FAILONERROR, true);
curl_setopt($ch_start, CURLOPT_HEADER, 0);
curl_setopt($ch_start, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch_start, CURLOPT_AUTOREFERER, true);
curl_setopt($ch_start, CURLOPT_TIMEOUT, 10);
curl_setopt($ch_start, CURLOPT_FILE, $zip_resource);

// Optional hardening: restrict protocols if supported by this curl build
if (defined('CURLOPT_PROTOCOLS') && defined('CURLPROTO_HTTPS')) {
  @curl_setopt($ch_start, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
}
if (defined('CURLOPT_REDIR_PROTOCOLS') && defined('CURLPROTO_HTTPS')) {
  @curl_setopt($ch_start, CURLOPT_REDIR_PROTOCOLS, CURLPROTO_HTTPS);
}

$ip = ipCheck();
if (($ip == "::1" || $ip == "127.0.0.1") || (!defined('EXTRA_CURL_SECURITY') || EXTRA_CURL_SECURITY !== true)) {
  curl_setopt($ch_start, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch_start, CURLOPT_SSL_VERIFYPEER, 0);
} else {
  curl_setopt($ch_start, CURLOPT_SSL_VERIFYHOST, 2);
  curl_setopt($ch_start, CURLOPT_SSL_VERIFYPEER, 1);
}

$page = curl_exec($ch_start);
if (!$page) {
  $err = curl_error($ch_start);
  usDiag($diag, $user->data()->id, "CURL Error :- " . $err);
  fclose($zip_resource);
  @unlink($zipFile);
  echo json_encode(['success' => false, 'error' => "Error :- " . $err]);
  die;
}

curl_close($ch_start);
fclose($zip_resource);

// ------------------------------
// Open zip
// ------------------------------
$zip = new ZipArchive;
if ($zip->open($zipFile) !== true) {
  usDiag($diag, $user->data()->id, "Error :- Unable to open the Zip File");
  @unlink($zipFile);
  echo json_encode(['success' => false, 'error' => "Error :- Unable to open the Zip File"]);
  die;
}

// Compute hash of downloaded file (existing behavior)
$newCrc = base64_encode(hash_file("sha256", $zip->filename));

// ------------------------------
// Recheck the api from inside the parser
// ------------------------------
$ch = curl_init($api);
$data = array(
  'key'  => $settings->spice_api,
  'type' => $type,
  'call' => 'recheck',
  'url'  => $url,
);

$payload = json_encode($data);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

// Normalize result (existing behavior)
$result = substr((string)$result, 1, -1);
$result = substr($result, 0, strpos($result, '=='));
$result .= "==";

// ------------------------------
// Verify hashes and extract
// ------------------------------
if ($newCrc == $hash && $newCrc == $result) {
  usDiag($diag, $user->data()->id, "The security hash matches...validating zip entries");

  // Zip Slip / symlink validation BEFORE extract
  [$ok, $zipErr] = usValidateZipEntries($zip, $extractPath);
  if (!$ok) {
    usDiag($diag, $user->data()->id, "Zip validation failed: " . $zipErr);
    $zip->close();
    @unlink($zipFile);
    echo json_encode(['success' => false, 'error' => "Unsafe zip: " . $zipErr]);
    die;
  }

  usDiag($diag, $user->data()->id, "Zip validation passed...unzipping");

  if ($zip->extractTo($extractPath) === true) {
    $zip->close();

    // Plugin migrate support (existing behavior)
    if (isset($reserved) && pluginActive($reserved, true)) {
      $mig = $extractPath . "/" . $reserved . "/migrate.php";
      if (file_exists($mig)) {
        include $mig;
      }
    }

    @unlink($zipFile);
    echo json_encode(['success' => true, 'url' => $return]);
    die;
  } else {
    usDiag($diag, $user->data()->id, "Unable to extract zip");
    $zip->close();
    @unlink($zipFile);
    echo json_encode(['success' => false, 'error' => "Unable to open zip."]);
    die;
  }
} else {
  usDiag($diag, $user->data()->id, "The security hash DOES NOT MATCH newCRC $newCrc hash $hash result $result");
  $zip->close();
  @unlink($zipFile);

  echo json_encode([
    'success' => false,
    'error' => "The hash does not match.  This means one of 2 things. Either the file on the server has been tampered with or (more likely) the file was
       updated and we forgot to update the hash.  Please fill out a bug report. You can still download this plugin at $url if you wish."
  ]);
  die;
}
