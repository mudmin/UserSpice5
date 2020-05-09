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

//NOTE: Plugin data is called at the bottom of this file
$lang = [];
if(file_exists($abs_us_root.$us_url_root.'usersc/includes/custom_functions.php')){
require_once $abs_us_root.$us_url_root.'usersc/includes/custom_functions.php';
}

require_once($abs_us_root.$us_url_root."users/helpers/us_helpers.php");
require_once($abs_us_root.$us_url_root."users/helpers/backup_util.php");
require_once($abs_us_root.$us_url_root."users/helpers/class.treeManager.php");
require_once($abs_us_root.$us_url_root."users/helpers/menus.php");
require_once($abs_us_root.$us_url_root."users/helpers/permissions.php");
require_once($abs_us_root.$us_url_root."users/helpers/users.php");
require_once($abs_us_root.$us_url_root."users/helpers/dbmenu.php");

define("ABS_US_ROOT",$abs_us_root);
define("US_URL_ROOT",$us_url_root);

if(file_exists($abs_us_root.$us_url_root."users/vendor/autoload.php")){
  require_once($abs_us_root.$us_url_root."users/vendor/autoload.php");
}

if(file_exists($abs_us_root.$us_url_root.'usersc/vendor/autoload.php')){
  require_once($abs_us_root.$us_url_root."usersc/vendor/autoload.php");
}

require $abs_us_root.$us_url_root.'users/classes/phpmailer/PHPMailerAutoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once $abs_us_root.$us_url_root.'users/includes/user_spice_ver.php';


// Readeable file size
function size($path) {
    $bytes = sprintf('%u', filesize($path));

    if ($bytes > 0) {
        $unit = intval(log($bytes, 1024));
        $units = array('B', 'KB', 'MB', 'GB');

        if (array_key_exists($unit, $units) === true) {
            return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
        }
    }

    return $bytes;
}

//escapes strings and sets character set
function sanitize($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

//returns the name of the current page
function currentPage() {
	$uri = $_SERVER['PHP_SELF'];
	$path = explode('/', $uri);
	$currentPage = end($path);
	return $currentPage;
}


function currentFolder() {
	$uri = $_SERVER['PHP_SELF'];
	$path = explode('/', $uri);
	$currentFolder=$path[count($path)-2];
	return $currentFolder;
}

function format_date($date,$tz){
	//return date("m/d/Y ~ h:iA", strtotime($date));
	$format = 'Y-m-d H:i:s';
	$dt = DateTime::createFromFormat($format,$date);
	// $dt->setTimezone(new DateTimeZone($tz));
	return $dt->format("m/d/y ~ h:iA");
}

function abrev_date($date,$tz){
	$format = 'Y-m-d H:i:s';
	$dt = DateTime::createFromFormat($format,$date);
	// $dt->setTimezone(new DateTimeZone($tz));
	return $dt->format("M d,Y");
}

function money($ugly){
	return '$'.number_format($ugly,2,'.',',');
}

function name_from_id($id){
	$db = DB::getInstance();
	$query = $db->query("SELECT username FROM users WHERE id = ? LIMIT 1",array($id));
	$count=$query->count();
	if ($count > 0) {
		$results=$query->first();
		return ucfirst($results->username);
	} else {
		return "-";
	}
}

function display_errors($errors = array()){
	$html = '<ul class="bg-danger">';
	foreach($errors as $error){
		if(is_array($error)){
			//echo "<br>"; Patch from user SavaageStyle - leaving here in case of rollback
			$html .= '<li>'.$error[0].'</li>';
			$html .= '<script>jQuery("#'.$error[0].'").parent().closest("div").addClass("has-error");</script>';
		}else{
			$html .= '<li>'.$error.'</li>';
		}
	}
	$html .= '</ul>';
	return $html;
}

function display_successes($successes = array()){
	$html = '<ul>';
	foreach($successes as $success){
		if(is_array($success)){
			$html .= '<li>'.$success[0].'</li>';
			$html .= '<script>jQuery("#'.$success[1].'").parent().closest("div").addClass("has-error");</script>';
		}else{
			$html .= '<li>'.$success.'</li>';
		}
	}
	$html .= '</ul>';
	return $html;
}

function email($to,$subject,$body,$opts=[],$attachment=false){
/*you can now pass in
$opts = array(
  'email' => 'from_email@aol.com',
  'name'  => 'Bob Smith'
);
*/
	$db = DB::getInstance();
	$query = $db->query("SELECT * FROM email");
	$results = $query->first();

	$mail = new PHPMailer;

	$mail->SMTPDebug = $results->debug_level;               // Enable verbose debug output
  if($results->isSMTP == 1){$mail->isSMTP();}             // Set mailer to use SMTP
	$mail->Host = $results->smtp_server;  									// Specify SMTP server
	$mail->SMTPAuth = $results->useSMTPauth;                // Enable SMTP authentication
	$mail->Username = $results->email_login;                 // SMTP username
	$mail->Password = htmlspecialchars_decode($results->email_pass);    // SMTP password
	$mail->SMTPSecure = $results->transport;                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = $results->smtp_port;                                  // TCP port to connect to
  $mail->CharSet = 'UTF-8';

	if(isset($opts['email']) && isset($opts['name'])){
    $mail->setFrom($opts['email'], $opts['name']);
  }else{
    $mail->setFrom($results->from_email, $results->from_name);
  }

	$mail->addAddress(rawurldecode($to));                   // Add a recipient, name is optional
  if($results->isHTML == 'true'){$mail->isHTML(true); }                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $body;
  if (!empty($attachment)) $mail->addAttachment($attachment);
	$result = $mail->send();

	return $result;
}

function email_body($template,$options = array()){
	$abs_us_root=$_SERVER['DOCUMENT_ROOT'];

	$self_path=explode("/", $_SERVER['PHP_SELF']);
	$self_path_length=count($self_path);
	$file_found=FALSE;

	for($i = 1; $i < $self_path_length; $i++){
		array_splice($self_path, $self_path_length-$i, $i);
		$us_url_root=implode("/",$self_path)."/";

		if (file_exists($abs_us_root.$us_url_root.'z_us_root.php')){
			$file_found=TRUE;
			break;
		}else{
			$file_found=FALSE;
		}
	}
	extract($options);
	ob_start();
	require $abs_us_root.$us_url_root.'users/views/'.$template;
	return ob_get_clean();
}



//preformatted var_dump function
function dump($var,$adminOnly=false,$localhostOnly=false){
    if($adminOnly && isAdmin() && !$localhostOnly){
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }
    if($localhostOnly && isLocalhost() && !$adminOnly){
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }
    if($localhostOnly && isLocalhost() && $adminOnly && isAdmin()){
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }
    if(!$localhostOnly && !$adminOnly){
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }
}

//preformatted dump and die function
function dnd($var,$adminOnly=false,$localhostOnly=false){
    if($adminOnly && isAdmin() && !$localhostOnly){
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
        die();
    }
    if($localhostOnly && isLocalhost() && !$adminOnly){
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
        die();
    }
    if($localhostOnly && isLocalhost() && $adminOnly && isAdmin()){
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
        die();
    }
    if(!$localhostOnly && !$adminOnly){
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
        die();
    }
}

function bold($text){
	echo "<span><ext padding='1em' align='center'><h4><span style='background:white'>";
	echo $text;
	echo "</h4></span></text>";
}

function err($text){
	echo "<span><text padding='1em' align='center'><font color='red'><h4></span>";
	echo $text;
	echo "</h4></span></font></text>";
}

function redirect($location){
	header("Location: {$location}");
}


//PLUGIN Hooks
$usplugins = parse_ini_file($abs_us_root.$us_url_root."usersc/plugins/plugins.ini.php",true);
foreach($usplugins as $k=>$v){
  if($v == 1){
  if(file_exists($abs_us_root.$us_url_root."usersc/plugins/".$k."/functions.php")){
    include($abs_us_root.$us_url_root."usersc/plugins/".$k."/functions.php");
    }
  }
}

function write_php_ini($array, $file)
{
    $res = array();
    foreach($array as $key => $val)
    {
        if(is_array($val))
        {
            $res[] = "[$key]";
            foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
        }
        else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
    }
    safefilerewrite($file, implode("\r\n", $res));
}

function safefilerewrite($fileName, $dataToSave)
{
$security = ';<?php die();?>';

  if ($fp = fopen($fileName, 'w'))
    {
        $startTime = microtime(TRUE);
        do
        {            $canWrite = flock($fp, LOCK_EX);
           // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
           if(!$canWrite) usleep(round(rand(0, 100)*1000));
        } while ((!$canWrite)and((microtime(TRUE)-$startTime) < 5));

        //file was locked so now we can store information
        if ($canWrite)
        {            fwrite($fp, $security.PHP_EOL.$dataToSave);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }
}
