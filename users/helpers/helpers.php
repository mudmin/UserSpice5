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
//echo "helpers included";


$lang = [];
if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/custom_functions.php')) {
  require_once $abs_us_root . $us_url_root . 'usersc/includes/custom_functions.php';
}

$usplugins = parse_ini_file($abs_us_root . $us_url_root . 'usersc/plugins/plugins.ini.php', true);
foreach ($usplugins as $k => $v) {
  if ($v == 1) {
    if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $k . '/override.php')) {
      include $abs_us_root . $us_url_root . 'usersc/plugins/' . $k . '/override.php';
    }
  }
}

require_once $abs_us_root . $us_url_root . 'users/helpers/us_helpers.php';
require_once $abs_us_root . $us_url_root . 'users/helpers/encryption.php';
require_once $abs_us_root . $us_url_root . 'users/helpers/rate_limit_helpers.php';
require_once $abs_us_root . $us_url_root . 'users/helpers/class.treeManager.php';
require_once $abs_us_root . $us_url_root . 'users/helpers/menus.php';
require_once $abs_us_root . $us_url_root . 'users/helpers/permissions.php';
require_once $abs_us_root . $us_url_root . 'users/helpers/users.php';
require_once $abs_us_root . $us_url_root . 'users/helpers/dbmenu.php';


//deprecated functions and classes can go here and will autoload until you delete them.
foreach (glob($abs_us_root . $us_url_root . 'usersc/includes/deprecated/*.php') as $filename) {
  require_once $filename;
}

define('ABS_US_ROOT', $abs_us_root);
define('US_URL_ROOT', $us_url_root);

if (file_exists($abs_us_root . $us_url_root . 'usersc/vendor/autoload.php')) {
  require_once $abs_us_root . $us_url_root . 'usersc/vendor/autoload.php';
}

if (file_exists($abs_us_root . $us_url_root . 'users/vendor/autoload.php')) {
  require_once $abs_us_root . $us_url_root . 'users/vendor/autoload.php';
}



require_once $abs_us_root . $us_url_root . 'users/classes/phpmailer/PHPMailerAutoload.php';

use PHPMailer\PHPMailer\PHPMailer;

require_once $abs_us_root . $us_url_root . 'users/includes/user_spice_ver.php';

// Readeable file size
if (!function_exists('size')) {
  function size($path)
  {
    $bytes = sprintf('%u', filesize($path));

    if ($bytes > 0) {
      $unit = intval(log($bytes, 1024));
      $units = ['B', 'KB', 'MB', 'GB'];

      if (array_key_exists($unit, $units) === true) {
        return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
      }
    }

    return $bytes;
  }
}

//Pass through to static method in input class
if (!function_exists('sanitize')) {
  function sanitize($string)
  {
    return Input::sanitize($string);
  }
}

//returns the name of the current page
if (!function_exists('currentPage')) {
  function currentPage()
  {
    $uri = Server::get('PHP_SELF');
    $path = explode('/', $uri);
    $currentPage = end($path);

    return $currentPage;
  }
}

if (!function_exists('currentFolder')) {
  function currentFolder() {
    $uri = Server::get('PHP_SELF') ?? '';
    $parts = explode('/', trim($uri, '/'));
    $count = count($parts);

    if ($count >= 2) {
      return $parts[$count - 2];
    }
    return ''; 
  }
}

if (!function_exists('money')) {
  function money($ugly)
  {
    return '$' . number_format((float)$ugly, 2, '.', ',');
  }
}

//updated in 5.3.0 to now use the built in system messages feature
if (!function_exists('display_errors')) {
  function display_errors($errors = [])
  {
    $display = [];
    foreach ($errors as $k => $v) {
      if (array_key_exists($errors[$k][1], $errors)) {
        unset($errors[$k][1]);
      }
    }

    sessionValMessages($errors);
  }
}

if (!function_exists('display_successes')) {
  function display_successes($successes = [])
  {
    foreach ($successes as $k => $v) {
      if (array_key_exists($successes[$k][1], $successes)) {
        unset($successes[$k][1]);
      }
    }
    sessionValMessages([], $successes);
  }
}

if (!function_exists('email')) {
  function email($to, $subject, $body, $opts = [], $attachment = null)
  {
    global $db, $abs_us_root, $us_url_root;

    /*
    As of v5.6, $to can now be an array of email addresses
    you can now pass in
    $opts = array(
    'email' => 'from_email@aol.com',
    'name'  => 'Bob Smith',
    'cc'    => 'cc@example.com',
    'bcc'   => 'bcc@example.com',
    'replyTo' => 'reply_to@example.com'
  );
  */
    $results = $db->query('SELECT * FROM email')->first();

    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = $results->debug_level;               // Enable verbose debug output
    $mail->XMailer = null;
    if ($results->isSMTP == 1) {
      $mail->isSMTP();
    }             // Set mailer to use SMTP
    $mail->Host = $results->smtp_server;                    // Specify SMTP server
    $mail->SMTPAuth = $results->useSMTPauth;                // Enable SMTP authentication
    $mail->Username = $results->email_login;                 // SMTP username
    $mail->Password = html_entity_decode($results->email_pass);    // SMTP password
    $mail->SMTPSecure = $results->transport;                 // Enable TLS encryption, `ssl` also accepted
    $mail->Port = $results->smtp_port;
    if ($results->authtype != "") {
      $mail->AuthType = $results->authtype;
    }


    if ($attachment != false) {
      $mail->addAttachment($attachment);
    }

    if (isset($opts['email']) && isset($opts['name'])) {
      $mail->setFrom($opts['email'], $opts['name']);
    } else {
      $mail->setFrom($results->from_email, $results->from_name);
    }

    if (isset($opts['replyTo'])) {
      $mail->addReplyTo($opts['replyTo']);
    }

    if (isset($opts['cc'])) {
      $mail->addCC($opts['cc']);
    }

    if (isset($opts['bcc'])) {
      $mail->addBCC($opts['bcc']);
    }

    if (is_array($to)) {
      foreach ($to as $t) {
        $mail->addAddress(rawurldecode($t));
      }
    } else {
      $mail->addAddress(rawurldecode($to));
    }
    if ($results->isHTML == 'true') {
      $mail->isHTML(true);
    }

    $mail->Subject = $subject;
    $mail->Body    = $body;
    if (!empty($attachment)) $mail->addAttachment($attachment);
    if (file_exists($abs_us_root . $us_url_root . "usersc/scripts/email_function_override.php")) {
      require_once $abs_us_root . $us_url_root . "usersc/scripts/email_function_override.php";
    }
    $result = $mail->send();

    return $result;
  }
}

if (!function_exists('email_body')) {
  function email_body($template, $options = [])
  {
    global $abs_us_root, $us_url_root;
    extract($options);
    ob_start();
    if (file_exists($abs_us_root . $us_url_root . 'usersc/views/' . $template)) {
      require $abs_us_root . $us_url_root . 'usersc/views/' . $template;
    } elseif (file_exists($abs_us_root . $us_url_root . 'users/views/' . $template)) {
      require $abs_us_root . $us_url_root . 'users/views/' . $template;
    }

    return ob_get_clean();
  }
}


//preformatted var_dump function
if (!function_exists('dump')) {
  function dump($var, $adminOnly = false, $localhostOnly = false, $fromdnd = false)
  {
    if (isDebugModeActive() && !$fromdnd) {
      $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);

      echo '<pre>';
      echo "File: <span style=\"font-weight:bold\">" . $trace[0]["file"] . "</span><br>";
      echo "Line: <span style=\"font-weight:bold\">" . $trace[0]["line"] . "</span><br>";
      echo '</pre>';
    }

    if ($adminOnly && isAdmin() && !$localhostOnly) {
      echo '<pre>';
      var_dump($var);
      echo '</pre>';
    }
    if ($localhostOnly && isLocalhost() && !$adminOnly) {
      echo '<pre>';
      var_dump($var);
      echo '</pre>';
    }
    if ($localhostOnly && isLocalhost() && $adminOnly && isAdmin()) {
      echo '<pre>';
      var_dump($var);
      echo '</pre>';
    }
    if (!$localhostOnly && !$adminOnly) {
      echo '<pre>';
      var_dump($var);
      echo '</pre>';
    }
  }
}

function safeDump($var): void
{
    ob_start();
    var_dump($var);
    $output = ob_get_clean();

    echo '<pre style="white-space: pre-wrap;">'
       . htmlspecialchars($output, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
       . '</pre>';
}

if (!function_exists("isDebugModeActive")) {
  function isDebugModeActive()
  {
    global $settings, $user;
    if (isset($settings->debug) && $settings->debug > 0) {
      if ($settings->debug == 2 || ($settings->debug == 1 && isUserLoggedIn() && $user->data()->id == 1)) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
}

//preformatted dump and die function
if (!function_exists('dnd')) {
  function dnd($var, $adminOnly = false, $localhostOnly = false)
  {

    if (isDebugModeActive()) {
      $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);

      echo '<pre>';
      echo "File: <span style=\"font-weight:bold\">" . $trace[0]["file"] . "</span><br>";
      echo "Line: <span style=\"font-weight:bold\">" . $trace[0]["line"] . "</span><br>";
      echo '</pre>';
    }
    dump($var, $adminOnly, $localhostOnly, true);
    die();
  }
}

if (!function_exists('bold')) {
  function bold($text)
  {
    echo "<text padding='1em' align='center'><h4><span style='background:white'>";
    echo $text;
    echo '</h4></text>';
  }
}

if (!function_exists('err')) {
  function err($text)
  {
    // echo "<text padding='1em' align='center'><span style='color:red'><h4><span class='errSpan'>";
    // echo $text;
    // echo '</span></h4></span></text>';
  }
}

if (!function_exists('redirect')) {
  function redirect($location)
  {
    header("Location: {$location}");
  }
}

//PLUGIN Stuff
foreach ($usplugins as $k => $v) {
  if ($v == 1) {
    if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $k . '/functions.php')) {
      include $abs_us_root . $us_url_root . 'usersc/plugins/' . $k . '/functions.php';
    }
  }
}

if (!function_exists('write_ini_file')) {
  function write_php_ini($array, $file)
  {
    $res = [];
    foreach ($array as $key => $val) {
      if (is_array($val)) {
        $res[] = "[$key]";
        foreach ($val as $skey => $sval) {
          $res[] = "$skey = " . (is_numeric($sval) ? $sval : '"' . $sval . '"');
        }
      } else {
        $res[] = "$key = " . (is_numeric($val) ? $val : '"' . $val . '"');
      }
    }
    safefilerewrite($file, implode("\r\n", $res));
  }
}

if (!function_exists('safefilerewrite')) {
  function safefilerewrite($fileName, $dataToSave)
  {
    $security = ';<?php die();?>';

    if ($fp = fopen($fileName, 'w')) {
      $startTime = microtime(true);
      do {
        $canWrite = flock($fp, LOCK_EX);
        // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
        if (!$canWrite) {
          usleep(round(rand(0, 100) * 1000));
        }
      } while ((!$canWrite) and ((microtime(true) - $startTime) < 5));

      //file was locked so now we can store information
      if ($canWrite) {
        fwrite($fp, $security . PHP_EOL . $dataToSave);
        flock($fp, LOCK_UN);
      }
      fclose($fp);
    }
  }
}


function getLangFilesStoragePath() {
    global $abs_us_root, $us_url_root;
    return $abs_us_root . $us_url_root . 'usersc/scripts/langFiles.json';
}

function spiceUpdateBegins() {
    global $abs_us_root, $us_url_root, $settings, $user, $db, $config;

    // Include external script if it exists
    $beginsScript = $abs_us_root . $us_url_root . 'usersc/scripts/spice_update_begins.php';
    if (file_exists($beginsScript)) {
        include $beginsScript;
    }
    
    // Proceed only if language purge is not disabled
    if (!isset($no_language_purge) || !$no_language_purge) {
        $langPath = $abs_us_root . $us_url_root . 'users/lang/*.php';
        $langFiles = glob($langPath);
        
        // Define the storage path for language files list
        $storagePath = getLangFilesStoragePath();
        
        // Convert the file paths to a JSON array
        $langFilesJson = json_encode($langFiles, JSON_PRETTY_PRINT);
        
        // Attempt to write the JSON data to the storage file
        if (file_put_contents($storagePath, $langFilesJson) === false) {
            usError("Failed to write language files list to {$storagePath}. Language cleanup will not happen.");
 

        } 
    }
}

function spiceUpdateSuccess() {
    global $abs_us_root, $us_url_root, $settings, $user, $db;
    
    // Include external script if it exists
    $successScript = $abs_us_root . $us_url_root . 'usersc/scripts/spice_update_success.php';
    if (file_exists($successScript)) {
        include $successScript;
    }
    
 
    if (!isset($no_language_purge) || !$no_language_purge) {
    
        $storagePath = getLangFilesStoragePath();
        
        // Check if the storage file exists
        if (file_exists($storagePath)) {
            // Read the JSON data from the storage file
            $storedLangFilesJson = file_get_contents($storagePath);
            if ($storedLangFilesJson === false) {
                usError("Failed to read language files list from {$storagePath}. Skipping language cleanup.");
  
                return;
            }
            
            // Decode the JSON data into an array
            $storedLangFiles = json_decode($storedLangFilesJson, true);
            if (!is_array($storedLangFiles)) {
              usError("Invalid JSON format in {$storagePath}. Skipping language cleanup.");
    
                return;
            }
            
            // Verify that there is at least one PHP file in the stored list
            $hasPhpFiles = false;
            foreach ($storedLangFiles as $file) {
                if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'php') {
                    $hasPhpFiles = true;
                    break;
                }
            }
            
            if ($hasPhpFiles) {
                $currentLangPath = $abs_us_root . $us_url_root . 'users/lang/*.php';
                $currentLangFiles = glob($currentLangPath);
                
                foreach ($currentLangFiles as $file) {
                    // If the current file was not in the stored list, attempt to delete it
                    if (!in_array($file, $storedLangFiles)) {
                        if (unlink($file)) {
                            
                        } 
                        
                    }
                }
            } else {
              usError("No PHP language files found in the stored list. Skipping language cleanup.");
            
            }
            
            // Remove the storage file after processing
            if (!unlink($storagePath)) {
                usError("Failed to delete storage file: {$storagePath}");
          
  
            } 

        } else {
            usError("Storage file {$storagePath} does not exist. Skipping language cleanup.");
   
        }
    }
}

function spiceUpdateFail() {
    global $abs_us_root, $us_url_root, $settings, $user, $db;
    
    // Include external script if it exists
    $failScript = $abs_us_root . $us_url_root . 'usersc/scripts/spice_update_fail.php';
    if (file_exists($failScript)) {
        include $failScript;
    }
    
    // Define the storage path for language files list
    $storagePath = getLangFilesStoragePath();
    
    // Attempt to delete the storage file to clean up
    if (file_exists($storagePath)) {
        if (!unlink($storagePath)) {
            usError("Failed to delete storage file after update failure: {$storagePath}");
        } 
    }
    if(file_exists($abs_us_root . $us_url_root . "usupdate.zip")){
      unlink($abs_us_root . $us_url_root . "usupdate.zip");
    }
}

function fetchExpectedRPID(): string {
    return Server::get('HTTP_HOST'); 
}


function usersc_override_redirect(string $currentPage, ?array $query = null, array $opts = []): bool {
    if (currentFolder() !== 'users') return false;
    global $abs_us_root, $us_url_root;

    $strict      = !empty($opts['strict']);
    $blockedKeys = $opts['blockedKeys'] ?? ['redirect','return','url','next','dest'];

    $bad = function() use ($strict): bool {
        if ($strict) { http_response_code(400); echo 'Bad request'; exit; }
        return false;
    };

    // Validate target page and existence
    $safePage = ltrim($currentPage, '/');
    if ($safePage === '' || strpos($safePage, '..') !== false || !preg_match('#^[A-Za-z0-9/_\.-]+$#', $safePage)) {
        return $bad();
    }
    if (!file_exists($abs_us_root.$us_url_root.'usersc/'.$safePage)) return false;

    // Start from $_GET unless caller supplied one
    $query = $query ?? $_GET;

    // Minimal key-level filter; let Redirect::sanitized handle encoding/sanitizing values
    $args = [];
    foreach ((array)$query as $k => $v) {
        $lk = strtolower((string)$k);
        if (in_array($lk, $blockedKeys, true)) continue;        // drop dangerous meta-params
        $kk = preg_replace('/[^A-Za-z0-9_-]/', '', (string)$k);  // keys only
        if ($kk === '') continue;
        $args[$kk] = $v; // values will be sanitized in Redirect::sanitized()
    }

    // Hand off to the centralized sanitizer (relative path + base_path)
    Redirect::sanitized('usersc/'.$safePage, $args, 302, [
        'base_path'   => $us_url_root,  // ensures it anchors under your app root
        'same_origin' => true,          // default anyway; keeps you on-site even if someone passes absolute junk
    ]);
    return true;
}

/* New UserSpice Encryption Functions 
// ============================================
// USAGE EXAMPLES
// ============================================

// You can define your custom ENV_PATH constant in your init.php file, example:
// define('ENV_PATH', '/custom/path/.customFilename.env');

// if you do not have one, this creates an env file below your webroot with
.userspice.<cookie_name>.env 

// and requires your system to be able to read/write it.

// Example 1: Generate encryption key if it doesn't exist
echo "=== Example 1: Generate encryption key (if needed) ===\n";
$keyGenResult = generateSpiceEncryptionKey();
if ($keyGenResult['success']) {
    echo "✓ New encryption key generated and saved!\n";
    echo "Key: " . substr($keyGenResult['key'], 0, 20) . "...\n";
} else {
    echo "ℹ " . $keyGenResult['message'] . "\n";
}
echo "\n";

// Example 2: Basic encryption and decryption
echo "=== Example 2: Basic encryption and decryption ===\n";
$originalString = "Hello, this is a secret message!";

// Encrypt the string
$encrypted = spiceEncrypt($originalString);
if ($encrypted !== false) {
    echo "Original: " . $originalString . "\n";
    echo "Encrypted: " . $encrypted['encrypted'] . "\n";

    // Decrypt the string
    $decrypted = spiceDecrypt($encrypted['encrypted'], $encrypted['iv'], $encrypted['tag']);
    if ($decrypted !== false) {
        echo "Decrypted: " . $decrypted . "\n";
        echo "Match: " . ($originalString === $decrypted ? "YES ✓" : "NO ✗") . "\n";
    } else {
        echo "Decryption failed!\n";
    }
} else {
    echo "Encryption failed!\n";
}

echo "\n";

// Example 3: Encrypting sensitive user data
echo "=== Example 3: Encrypting sensitive user data ===\n";
$userData = json_encode([
    'user_id' => 12345,
    'email' => 'user@example.com',
    'api_key' => 'sk_live_abc123xyz789'
]);

$encryptedData = spiceEncrypt($userData);
if ($encryptedData !== false) {
    // Store $encryptedData['encrypted'] in database
    echo "User data encrypted successfully\n";
    echo "Encrypted data: " . substr($encryptedData['encrypted'], 0, 50) . "...\n";

    // Later, retrieve and decrypt
    $decryptedData = spiceDecrypt($encryptedData['encrypted'], $encryptedData['iv'], $encryptedData['tag']);
    $originalUserData = json_decode($decryptedData, true);
    echo "Decrypted user data:\n";
    print_r($originalUserData);
}

echo "\n";

// Example 4: Encrypting passwords or tokens
echo "=== Example 4: Encrypting passwords or tokens ===\n";
$sensitiveToken = "my-super-secret-token-12345";
$result = spiceEncrypt($sensitiveToken);

if ($result !== false) {
    // Save to database or config
    $storedEncrypted = $result['encrypted'];
    echo "Original token: " . $sensitiveToken . "\n";
    echo "Token encrypted: " . $storedEncrypted . "\n";

    // Retrieve and decrypt when needed
    $retrievedToken = spiceDecrypt($result['encrypted'], $result['iv'], $result['tag']);
    echo "Retrieved token: " . $retrievedToken . "\n";
    echo "Match: " . ($sensitiveToken === $retrievedToken ? "YES ✓" : "NO ✗") . "\n";
}

echo "</pre>";

*/


if (!function_exists('generateSpiceEncryptionKey')) {
  function generateSpiceEncryptionKey()
  {
    global $config, $abs_us_root;

    // Use ENV_PATH constant if defined (set in init.php), otherwise calculate path
    if (defined('ENV_PATH')) {
      $envPath = ENV_PATH;
    } else {
      // Get cookie name for unique env filename
      $cookieName = Config::get('remember/cookie_name');
      $envFilename = '.userspice.' . $cookieName . '.env';

      // Determine the correct path to .env file
      if (isset($config['mysql']['password']) && $config['mysql']['password'] != "password" && $config['mysql']['password'] != "") {
        $envPath = $abs_us_root . '/../' . $envFilename;
      } else {
        $envPath = $abs_us_root . '/' . $envFilename;
      }
    }

    // Check if ENCRYPTION_KEY already exists
    if (file_exists($envPath)) {
      $env = parse_ini_file($envPath);
      if (isset($env['ENCRYPTION_KEY'])) {
        return ['success' => false, 'message' => 'ENCRYPTION_KEY already exists in .env file'];
      }
    }

    // Generate a secure 256-bit (32 bytes) encryption key
    $key = random_bytes(32);
    $hexKey = bin2hex($key);

    // Append to .env file
    $envContent = "\n# Encryption key for spiceEncrypt/spiceDecrypt\nENCRYPTION_KEY=" . $hexKey . "\n";

    if (file_put_contents($envPath, $envContent, FILE_APPEND | LOCK_EX) !== false) {
      // Set secure permissions (0600 = read/write for owner only)
      chmod($envPath, 0600);
      return ['success' => true, 'message' => 'ENCRYPTION_KEY generated and saved to .env file', 'key' => $hexKey];
    } else {
      return ['success' => false, 'message' => 'Failed to write ENCRYPTION_KEY to .env file'];
    }
  }
}

if (!function_exists('spiceEncryptionKey')) {
  function spiceEncryptionKey()
  {
  global $config, $abs_us_root;

  // Use ENV_PATH constant if defined (set in init.php), otherwise calculate path
  if (defined('ENV_PATH')) {
    $envPath = ENV_PATH;
  } else {
    // Get cookie name for unique env filename
    $cookieName = Config::get('remember/cookie_name');
    $envFilename = '.userspice.' . $cookieName . '.env';

    // Determine the correct path to .env file
    $envPath = ($config['mysql']['password'] == "password" || $config['mysql']['password'] == "")
      ? $abs_us_root . '/' . $envFilename
      : $abs_us_root . '/../' . $envFilename;
  }

  // Load and parse the .env file
  $env = parse_ini_file($envPath);
  if (!isset($env['ENCRYPTION_KEY'])) {
    // Try to generate the key automatically
    $result = generateSpiceEncryptionKey();
    if ($result['success']) {
      // Re-parse the .env file to get the new key
      $env = parse_ini_file($envPath);
    } else {
      throw new Exception('ENCRYPTION_KEY not found in .env file and could not be generated');
    }
  }

  return hex2bin($env['ENCRYPTION_KEY']);
  }
}

if (!function_exists('spiceEncrypt')) {
  function spiceEncrypt($string)
  {
  try {
    $key = spiceEncryptionKey();
    $iv = random_bytes(12);
    $tag = "";

    $encrypted = openssl_encrypt(
      $string,
      'aes-256-gcm',
      $key,
      OPENSSL_RAW_DATA,
      $iv,
      $tag
    );

    // Concatenate all components and base64 encode
    $combined = $iv . $encrypted . $tag;
    return [
      'encrypted' => base64_encode($combined),
      'iv' => $iv,
      'tag' => $tag
    ];
  } catch (Exception $e) {
    error_log('Encryption error: ' . $e->getMessage());
    return false;
  }
  }
}

if (!function_exists('spiceDecrypt')) {
  function spiceDecrypt($encrypted, $iv, $tag)
  {
  try {
    $key = spiceEncryptionKey();
    $decoded = base64_decode($encrypted);

    // Extract components
    $actualIv = substr($decoded, 0, 12);
    $actualTag = substr($decoded, -16);
    $actualEncrypted = substr($decoded, 12, -16);

    $decrypted = openssl_decrypt(
      $actualEncrypted,
      'aes-256-gcm',
      $key,
      OPENSSL_RAW_DATA,
      $actualIv,
      $actualTag
    );

    if ($decrypted === false) {
      throw new Exception('Decryption failed: ' . openssl_error_string());
    }

    return $decrypted;
  } catch (Exception $e) {
    error_log('Decryption error: ' . $e->getMessage());
    return false;
  }
  }
}