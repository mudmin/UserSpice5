<?php
$do_not_log_files = ["heartbeat.php", "fetchMessages.php", "update_check.php", "fetch_servers.php"];
$do_not_log_fields = ["password", "password_confirm", "confirm"];

// Create logs directory if it doesn't exist
$logDir = $abs_us_root . $us_url_root . 'users/logs';
if (!file_exists($logDir)) {
    mkdir($logDir, 0755, true);
}


//important.  if you want to custmize the filename, do it AFTER the date, otherwise the log viewer will not work
//so it would look something like
// if(isset($user) && $user->isLoggedIn()){
//     $filename = $logDir . '/' . date('Ymd_H') . '_' . $user->data()->customer_id . '.log.php';
// } else {
//     $filename = $logDir . '/' . date('Ymd_H') . '0_.log.php';
// }

// Generate filename based on current date and hour
// $filename = $logDir . '/' . date('Ymd_H') . '.log.php';

if(isset($user) && $user->isLoggedIn()){
    $filename = $logDir . '/' . date('Ymd_H') . '_' . $user->data()->id . '.log.php';
} else {
    $filename = $logDir . '/' . date('Ymd_H') . '0_.log.php';
}

// Create file with PHP security header if it doesn't exist
if (!file_exists($filename)) {
    file_put_contents($filename, ";<?php die(); ?>\n");
}
