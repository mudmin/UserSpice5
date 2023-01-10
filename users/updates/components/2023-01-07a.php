<?php

$countE = 0;
  $path = $abs_us_root . $us_url_root. "usersc/includes/dashboard_overrides.php";
  $contents = file_get_contents($path);
  if (strpos($contents, "dashboard for convenience") !== false) {
    //do nothing
  }else{

    $file = fopen($path, "a");
    $txt =  "\n\n// The sidebar menu disappears on small screen sizes";
    $txt .= "\n// If you show the sidebar and hide the top menu, a fallback menu will appear on small screens";
    $txt .= "\n// giving you links to your home page and dashboard for convenience. ";
    fwrite($file, $txt);
    fclose($file);
  }



include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
