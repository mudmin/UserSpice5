<?php

$countE = 0;

if(file_exists($abs_us_root . $us_url_root . "users/css/dashboard/style.scss")){
rename($abs_us_root . $us_url_root . "users/css/dashboard/style.scss", $abs_us_root . $us_url_root . "users/css/dashboard/style.scss.bak");
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
