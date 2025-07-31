<?php
//Your Application Details
$app_name = "UserSpice";


//The name of your configuration file
$config_file = "../users/init.php";

$sqlfile = "install/includes/sql.sql";

//Navigation Settings
$step1 = "Welcome";
$step2 = "Setup";
$step3 = "Cleanup";

//System Requirements
$php_min = "7.4.0";
$php_ver = "8.2.0";

//Cleanup Files
$files = array (
"index.php",
"step2.php",
"step3.php",
);

//Where do you want to redirect after cleanup?
$redirect = "../index.php";


 ?>
