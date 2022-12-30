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

/*
This file was added as of UserSpice 5.2.7 to allow (primarily) security-related
files to be included and functions to be called when not using the front end
templating system.  In other words, it takes these actions out of the template
system and puts them into the core, loaded with init.php so they are loaded
universally. Note that you can add your own loader content
in usersc/includes/loader.php
*/
$us_loader_loaded = true;
define("INSTANCE",Config::get('session/session_name'));
//prevent script tags from being parsed in err and msg messages
//required in 5.3.2 or later
if(isset($_GET['err'])){
	$_GET['err'] = str_ireplace("<script","",$_GET['err']);
}
if(isset($_GET['msg'])){
	$_GET['msg'] = str_ireplace("<script","",$_GET['msg']);
}

$db = DB::getInstance();
$settings = $db->query("SELECT * FROM settings")->first();

require_once $abs_us_root.$us_url_root.'usersc/includes/security_headers.php';

if (ipCheckBan() && currentPage() != "banned.php") {
    Redirect::to($us_url_root.'usersc/scripts/banned.php');
    exit();
}

// Language
if ($settings->allow_language == 0 || !isUserLoggedIn()) {
    if (!isset($_SESSION['us_lang'])) {
        $_SESSION['us_lang'] = $settings->default_language;
    }
} else {
    if (isUserLoggedIn()) {
        $_SESSION['us_lang'] = $user->data()->language;
    } else {
        $_SESSION['us_lang'] = $settings->default_language;
    }
}

include $abs_us_root.$us_url_root.'users/lang/'.$_SESSION['us_lang'].".php";

//check for a custom page
$currentPage = currentPage();
if($settings->debug > 0){
	if($settings->debug == 2 || ($settings->debug == 1 && isUserLoggedIn() && $user->data()->id == 1)){

		$alldata = [];
		foreach($_GET as $k=>$v){
			$alldata['get'][$k] = Input::sanitize($v);
		}

		foreach($_POST as $k=>$v){
			if($k != 'password' && $k != 'password_confirm' && $k != 'confirm'){
				$alldata['post'][$k] = Input::sanitize($v);
			}
		}
		$alldata = json_encode($alldata);
		if(!isUserLoggedIn()){
			$loggingUserId = 0;
		}else{
			$loggingUserId = $user->data()->id;
		}

		if($alldata != "[]"){
			logger($loggingUserId,"Form Data",$currentPage." View Here--->",$alldata);
		}

	}
}

if(isset($_GET['err'])){
	$err = Input::get('err');
}

if(isset($_GET['msg'])){
	$msg = Input::get('msg');
}

if(file_exists($abs_us_root.$us_url_root.'usersc/'.$currentPage)){
	if(currentFolder() == 'users'){
		$url = $us_url_root.'usersc/'.$currentPage;
		if(isset($_GET)){
			$url .= '?'; //add initial ?
			foreach ($_GET as $key=>$value){
				$url .= '&'.$key.'='.$value;
			}
		}
		Redirect::to($url);
	}
}

//dealing with logged in users
if($user->isLoggedIn() && !hasPerm(2)){
	if (($settings->site_offline==1) && (!in_array($user->data()->id, $master_account)) && ($currentPage != 'login.php') && ($currentPage != 'maintenance.php')){
		//:: force logout then redirect to maint.page
		if(!isset($noMaintenanceRedirect) || $noMaintenanceRedirect != true){
		logger($user->data()->id, "Offline", "Landed on Maintenance Page.");
		$user->logout();
		Redirect::to($us_url_root.'users/maintenance.php');
		}
	}
}

//deal with guests
if(!$user->isLoggedIn()){
	if (($settings->site_offline==1) && ($currentPage != 'login.php') && ($currentPage != 'maintenance.php')){
		//:: redirect to maint.page

		if(!isset($noMaintenanceRedirect) || $noMaintenanceRedirect != true){
		logger("","Offline","Guest Landed on Maintenance Page."); //Logger
		Redirect::to($us_url_root.'users/maintenance.php');
		}
	}
}

if ($settings->force_ssl==1){
	$isSecure = false;

	if(
		isset($_SERVER['HTTPS'])
		&& $_SERVER['HTTPS'] == 'on')
		{
		$isSecure = true;
	}elseif (
		!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])
		&& $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
		|| !empty($_SERVER['HTTP_X_FORWARDED_SSL'])
		&& $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
		$isSecure = true;
	}
		if ($isSecure != true) {
		// if request is not secure, redirect to secure url
		$url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		Redirect::to($url);
		exit;
	}

}

// Get html lang attribute, default 'en'
if(isset($_SESSION['us_lang'])){ $html_lang = substr($_SESSION['us_lang'],0,2);}else{$html_lang = 'en';}


if($user->isLoggedIn() && $currentPage != 'user_settings.php' && $user->data()->force_pr == 1){
	$resetMsg = lang("VER_PLEASE");
	usError($resetMsg);
	Redirect::to($us_url_root.'users/user_settings.php');
}

$page=currentFile();
$titleQ = $db->query('SELECT title FROM pages WHERE page = ?', array($page));
if ($titleQ->count() > 0) {
	$pageTitle = $titleQ->first()->title;
}
else $pageTitle = '';


if(file_exists($abs_us_root.$us_url_root."usersc/includes/loader.php")){
	require_once $abs_us_root.$us_url_root."usersc/includes/loader.php";
}
