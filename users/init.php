<?php
define('USERSPICE_ACTIVE_LOGGING', false);
$noPHPInfo = false;
require_once 'classes/class.autoloader.php';

define('PASSKEY_RP_ID', 'localhost');
ini_set('session.cookie_httponly', 1);
session_start();
// disables the feature that prevents the updater from installing languages you didn't have before the update
// $disable_language_purge = true;

$abs_us_root=Server::get('DOCUMENT_ROOT');

$self_path=explode("/", Server::get('PHP_SELF'));

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

require_once $abs_us_root.$us_url_root.'users/helpers/helpers.php';

// Set config
$GLOBALS['config'] = array(
	'mysql'      => array(
	'force_utc_mysql' => false,
	'charset'      => 'utf8mb4',		
