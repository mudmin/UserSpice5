<?php
$countE = 0;

$file = $abs_us_root . $us_url_root . ".gitignore";

if (file_exists($file)) {
    $line = "\nusers/logs/*.log.php";
    //add line to end of gitignore
    $lines = file($file);
    $lines[] = $line;
    file_put_contents($file, $lines);
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
