<?php
die("Please edit the users/init.php with your database credentials.  You should also update the cookie and session names to something unique.  After that, you can delete the die statement at the top of the file and your site should work as expected.");


define('USERSPICE_ACTIVE_LOGGING', false);
//turns file based active loggin on or off. If set to true, it will log every page a user visits 
//with some exceptions defined in usersc\includes\active_logging_custom.php
$noPHPInfo = false;
require_once 'classes/class.autoloader.php';


ini_set('session.cookie_httponly', 1);
session_start();
// disables the feature that prevents the updater from installing languages you didn't have before the update
// $disable_language_purge = true;

$abs_us_root = Server::get('DOCUMENT_ROOT'); 

$self_path = explode("/", Server::get('PHP_SELF'));

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
'host'         => 'localhost',
'username'     => 'root',
'password'     => '',
'db'           => '5',
),
'remember'        => array(
  'cookie_name'   => 'pmqesoxiw318374csb',
  'cookie_expiry' => 604800  //One week, feel free to make it longer
),
'session' => array(
  'session_name' => 'user',
  'token_name' => 'token',
)
);

// $never_generate_totp_key_file = true; // Set to true to prevent TOTP key file generation
// $dev_announcement_override = true;

//If you changed your UserSpice or UserCake database prefix
//put it here.
$db_table_prefix = "uc_";  //Old database prefix

//adding more ids to this array allows people to access everything, whether offline or not. Use caution.
$master_account = [1];

$currentPage = currentPage();

//Check to see if user has a remember me cookie
if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->query("SELECT * FROM users_session WHERE hash = ? AND uagent = ?",array($hash,Session::uagent_no_version()));

	if ($hashCheck->count()) {
		$user = new User($hashCheck->first()->user_id);
		$inst = Config::get('session/session_name');
        $_SESSION[$inst . '_login_method'] = "cookie";
        $user->login();

	}
}

//Check to see that user is logged in on a temporary password
$user = new User();

//Check to see that user is verified
if($user->isLoggedIn()){
	if($user->data()->email_verified == 0 && $currentPage != 'verify.php' && $currentPage != 'logout.php' && $currentPage != 'verify_thankyou.php'){
		Redirect::to($us_url_root.'users/verify.php');
	}
}
$timezone_string = 'America/New_York';
date_default_timezone_set($timezone_string);


$usespice_nonce = base64_encode(random_bytes(16));
require_once $abs_us_root.$us_url_root."users/includes/loader.php";

