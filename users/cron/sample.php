<?php
require_once '../init.php';
$filename = currentPage();
$db = DB::getInstance();
$ip = ipCheck();
logger("","CronRequest","Cron request from $ip.");

if($settings->cron_ip != ''){
if($ip != $settings->cron_ip && $ip != '127.0.0.1'){
	logger("","CronRequest","Cron request DENIED from $ip.");
	die;
	}
}
$errors = $successes = [];

//your code goes here...
//do whatever you want to do and it will be run automatically when the cron job is triggered.
$user_id = 1; //just for testing purposes. Most cron jobs won't have a logged in user.
die("This is just a sample"); //you can delete this.




//your code ends here.

$from = Input::get('from');
if($from != NULL && $currentPage == $filename) {
	$query = $db->query("SELECT id,name FROM crons WHERE file = ?",array($filename));
	$results = $query->first();
		$cronfields = array(
		'cron_id' => $results->id,
		'datetime' => date("Y-m-d H:i:s"),
		'user_id' => $user_id);
		$db->insert('crons_logs',$cronfields);
	Redirect::to('/'. $from);
}
?>
