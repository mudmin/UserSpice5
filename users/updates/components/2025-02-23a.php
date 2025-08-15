<?php
$countE = 0;

$file = $abs_us_root . $us_url_root . "users/init.php";
$content = file_get_contents($file);
if ($content === false) {
    die("Error: Unable to read file");
}

if (strpos($content, 'session.cookie') === false) {
    $search = "session_start();";
    $replace = "ini_set('session.cookie_httponly', 1);\n" . $search;
    $newContent = str_replace($search, $replace, $content);
    
    if (file_put_contents($file, $newContent) === false) {
        usError("Error: Unable to update init.php with httponly cookie");
    }else{
        usSuccess("init.php updated with httponly cookie setting");
    }
    
} 
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
