<?php
/*
UserSpice 5
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
if (file_exists($abs_us_root.$us_url_root.'usersc/includes/custom_functions.php')) {
  require_once $abs_us_root.$us_url_root.'usersc/includes/custom_functions.php';
}

$usplugins = parse_ini_file($abs_us_root.$us_url_root.'usersc/plugins/plugins.ini.php', true);
foreach ($usplugins as $k => $v) {
  if ($v == 1) {
    if (file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$k.'/override.php')) {
      include $abs_us_root.$us_url_root.'usersc/plugins/'.$k.'/override.php';
    }
  }
}

require_once $abs_us_root.$us_url_root.'users/helpers/us_helpers.php';
require_once $abs_us_root.$us_url_root.'users/helpers/backup_util.php';
require_once $abs_us_root.$us_url_root.'users/helpers/class.treeManager.php';
require_once $abs_us_root.$us_url_root.'users/helpers/menus.php';
require_once $abs_us_root.$us_url_root.'users/helpers/permissions.php';
require_once $abs_us_root.$us_url_root.'users/helpers/users.php';
require_once $abs_us_root.$us_url_root.'users/helpers/dbmenu.php';

define('ABS_US_ROOT', $abs_us_root);
define('US_URL_ROOT', $us_url_root);

if (file_exists($abs_us_root.$us_url_root.'usersc/vendor/autoload.php')) {
  require_once $abs_us_root.$us_url_root.'usersc/vendor/autoload.php';
}

if (file_exists($abs_us_root.$us_url_root.'users/vendor/autoload.php')) {
  require_once $abs_us_root.$us_url_root.'users/vendor/autoload.php';
}



require $abs_us_root.$us_url_root.'users/classes/phpmailer/PHPMailerAutoload.php';
use PHPMailer\PHPMailer\PHPMailer;

require_once $abs_us_root.$us_url_root.'users/includes/user_spice_ver.php';

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
    $uri = $_SERVER['PHP_SELF'];
    $path = explode('/', $uri);
    $currentPage = end($path);

    return $currentPage;
  }
}

if (!function_exists('currentFolder')) {
  function currentFolder()
  {
    $uri = $_SERVER['PHP_SELF'];
    $path = explode('/', $uri);
    $currentFolder = $path[count($path) - 2];

    return $currentFolder;
  }
}

if (!function_exists('money')) {
  function money($ugly)
  {
    return '$'.number_format($ugly, 2, '.', ',');
  }
}

//updated in 5.3.0 to now use the built in system messages feature
if (!function_exists('display_errors')) {
    function display_errors($errors = []){
      foreach($errors as $k=>$v){
        if(array_key_exists($errors[$k][1],$errors)){
          unset($errors[$k][1]);
        }
      } sessionValMessages($errors);
    }
}

if (!function_exists('display_successes')) {
  function display_successes($successes = [])
  {
    foreach($successes as $k=>$v){
      if(array_key_exists($successes[$k][1],$successes)){
        unset($successes[$k][1]);
      }
    }
    sessionValMessages([],$successes);
  }
}

if (!function_exists('email')) {
  function email($to, $subject, $body, $opts = [], $attachment = null)
  {
   global $abs_us_root,$us_url_root;
    /*you can now pass in
    $opts = array(
    'email' => 'from_email@aol.com',
    'name'  => 'Bob Smith',
    'cc'    => 'cc@example.com',
    'bcc'   => 'bcc@example.com'
  );
  */
  $db = DB::getInstance();
  $query = $db->query('SELECT * FROM email');
  $results = $query->first();

  $mail = new PHPMailer();
  $mail->CharSet = 'UTF-8';
  $mail->SMTPDebug = $results->debug_level;               // Enable verbose debug output
  if ($results->isSMTP == 1) {
    $mail->isSMTP();
  }             // Set mailer to use SMTP
  $mail->Host = $results->smtp_server;  									// Specify SMTP server
  $mail->SMTPAuth = $results->useSMTPauth;                // Enable SMTP authentication
  $mail->Username = $results->email_login;                 // SMTP username
  $mail->Password = html_entity_decode($results->email_pass);    // SMTP password
  $mail->SMTPSecure = $results->transport;                 // Enable TLS encryption, `ssl` also accepted
  $mail->Port = $results->smtp_port;                       // TCP port to connect to

  if($attachment != false){
            $mail->addAttachment($attachment);
          }

          if(isset($opts['email']) && isset($opts['name'])){
            $mail->setFrom($opts['email'], $opts['name']);
          }else{
            $mail->setFrom($results->from_email, $results->from_name);
          }

          if(isset($opts['cc'])){
            $mail->addCC($opts['cc']);
          }

          if(isset($opts['bcc'])){
            $mail->addBCC($opts['bcc']);
          }

  	$mail->addAddress(rawurldecode($to));
    if($results->isHTML == 'true'){
      $mail->isHTML(true);
    }

  	$mail->Subject = $subject;
  	$mail->Body    = $body;
    if (!empty($attachment)) $mail->addAttachment($attachment);
    if(file_exists($abs_us_root.$us_url_root."usersc/scripts/email_function_override.php")){
      include $abs_us_root.$us_url_root."usersc/scripts/email_function_override.php";
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
    if (file_exists($abs_us_root.$us_url_root.'usersc/views/'.$template)) {
      require $abs_us_root.$us_url_root.'usersc/views/'.$template;
    } elseif (file_exists($abs_us_root.$us_url_root.'users/views/'.$template)) {
      require $abs_us_root.$us_url_root.'users/views/'.$template;
    }

    return ob_get_clean();
  }
}

//preformatted var_dump function
if (!function_exists('dump')) {
  function dump($var, $adminOnly = false, $localhostOnly = false)
  {
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

//preformatted dump and die function
if (!function_exists('dnd')) {
  function dnd($var, $adminOnly = false, $localhostOnly = false)
  {
    dump($var, $adminOnly, $localhostOnly);
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
    if (file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$k.'/functions.php')) {
      include $abs_us_root.$us_url_root.'usersc/plugins/'.$k.'/functions.php';
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
          $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
        }
      } else {
        $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
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
        fwrite($fp, $security.PHP_EOL.$dataToSave);
        flock($fp, LOCK_UN);
      }
      fclose($fp);
    }
  }
}
