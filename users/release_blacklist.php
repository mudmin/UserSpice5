<?php 
require_once '../users/init.php';
if($settings->cron_ip != ipCheck()){
    logger('','Blacklist clear','Cron request DENIED from '.Input::sanitize(ipCheck()));
    die;
}
$now = date("Y-m-d H:i:s");
$db->query("DELETE FROM us_ip_blacklist WHERE expires IS NOT NULL AND expires < ?", [$now]);
exit();