<?php

$countE = 0;
require $abs_us_root . $us_url_root. "usersc/includes/dashboard_overrides.php";

if(!isset($dashboard_sidebar_menu)){
    $file = fopen($abs_us_root . $us_url_root. "usersc/includes/dashboard_overrides.php", "a");
    $txt = "\n//use sidebar menu instead of top menu";
    $txt .= "\n\$dashboard_sidebar_menu = false;";
    $txt .= "\n\n//include the footer from your template on the userspice dashboard";
    $txt .= "\n\$use_template_footer = false; ";
    fwrite($file, $txt);
    fclose($file);
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
