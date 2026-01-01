<?php
require_once '../init.php';
$db = DB::getInstance();
$ip = ipCheck();
logger("","CronRequest","Cron request from $ip.");

if($settings->cron_ip != ''){
if($ip != $settings->cron_ip && $ip != '127.0.0.1'){
	logger("","CronRequest","Cron request DENIED from $ip.");
	die;
	}
}
$from = Input::get('from');
$primaryquery = $db->query("SELECT file FROM crons WHERE active = ? ORDER BY sort",array(1));
$querycount = $primaryquery->count();

//Log Prep
if($user->isLoggedIn()) { $user_id = $user->data()->id; } else { $user_id = 1; }
$logtype = "Cron";
//Log Prep End

if($querycount > 0)
{
$cronBaseDir = $abs_us_root . $us_url_root . 'users/cron/';

$query = $db->query("SELECT id,file FROM crons WHERE active = ? ORDER BY sort", array(1));
foreach ($query->results() as $row) {
    $id = $row->id;
    $file = $row->file;

    $safeFullPath = sanitizePath($file, $cronBaseDir);

    if ($safeFullPath) {
        include_once($safeFullPath);
        $cronfields = array(
            'cron_id' => $id,
            'datetime' => date("Y-m-d H:i:s"),
            'user_id' => $user_id
        );
        $db->insert('crons_logs', $cronfields);
    }
}
}
 if($from != NULL) Redirect::to('/'. $from);
?>
