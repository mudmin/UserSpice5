<?php

require_once '../users/init.php';
$user = new User();
$eventhooks =  getMyHooks(['page'=>'logout']);
includeHook($eventhooks,'body');
if(file_exists($abs_us_root.$us_url_root.'usersc/scripts/just_before_logout.php')){
	require_once $abs_us_root.$us_url_root.'usersc/scripts/just_before_logout.php';
}else{
	//Feel free to change where the user goes after logout!
}
$user->logout();
if(file_exists($abs_us_root.$us_url_root.'usersc/scripts/just_after_logout.php')){
	require_once $abs_us_root.$us_url_root.'usersc/scripts/just_after_logout.php';
}else{
	Redirect::to($us_url_root.'index.php');
}
?>
