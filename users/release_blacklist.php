<?php 
require_once '../users/init.php';
// A loopback cron_ip only matches a genuinely local request (behind a
// same-server proxy or tunnel every visitor arrives from 127.0.0.1).
$cronIpLoopback = in_array(strtolower(trim((string)$settings->cron_ip)), ['127.0.0.1', '::1', 'localhost'], true);
if(!ClientIP::isLocal() && ($cronIpLoopback || $settings->cron_ip != ClientIP::peer())){
    logger('','Blacklist clear','Cron request DENIED from '.Input::sanitize(ClientIP::peer()));
    die;
}
$now = date("Y-m-d H:i:s");
$db->query("DELETE FROM us_ip_blacklist WHERE expires IS NOT NULL AND expires < ?", [$now]);
exit();