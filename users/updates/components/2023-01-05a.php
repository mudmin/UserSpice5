<?php

$countE = 0;
if(file_exists($abs_us_root . $us_url_root . "usersc/includes/dashboard_overrides.php")){
require $abs_us_root . $us_url_root. "usersc/includes/dashboard_overrides.php";

if(!isset($hide_top_navigation)){
  $file = fopen($abs_us_root . $us_url_root. "usersc/includes/dashboard_overrides.php", "a");
  $txt = "\n\n//hide the top menu on the dashboard";
  $txt .= "\n\$hide_top_navigation = false;";
  fwrite($file, $txt);
  fclose($file);
}
}else{
  //create the file if it doesn't exist
  $file = fopen($abs_us_root . $us_url_root . "usersc/includes/dashboard_overrides.php", "w");
  $txt = "<?php\n\n//hide the top menu on the dashboard\n";
  $txt .= "\$hide_top_navigation = false;\n";
  fwrite($file, $txt);
  fclose($file);  
}
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
