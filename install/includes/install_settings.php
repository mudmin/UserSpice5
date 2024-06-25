<?php
//Your Application Details
$app_name = "UserSpice";
$app_ver = "4.4"; //Feel free to leave this as an empty string.

//The name of your configuration file
$config_file = "../users/init.php";

$sqlfile = "includes/sql.sql";

//Navigation Settings
$step1 = "Welcome";
$step2 = "Database";
$step3 = "Cleanup";

//System Requirements
$php_ver = "5.6.0";

//Cleanup Files
$files = array (
    "index.php",
    "step2.php",
    "step3.php",
);

//Where do you want to redirect after cleanup?
$redirect = "../index.php";