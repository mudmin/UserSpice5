<?php
$countE = 0;

$file = $abs_us_root . $us_url_root . "users/init.php";

// check if USERSPICE_ACTIVE_LOGGING is already defined
if(!defined('USERSPICE_ACTIVE_LOGGING')){
   
// Read the current contents of the file
$contents = file_get_contents($file);

if ($contents === false) {
    die("Unable to read file: " . $file);
}

// Split the content into lines
$lines = explode("\n", $contents);

// Insert the new line after the first line
array_splice($lines, 1, 0, "define('USERSPICE_ACTIVE_LOGGING', false);");

// Join the lines back together
$new_contents = implode("\n", $lines);

// Write the modified content back to the file
if (file_put_contents($file, $new_contents) === false) {
    die("Unable to write to file: " . $file);
}

}
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");