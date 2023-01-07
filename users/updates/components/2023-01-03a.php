<?php

$countE = 0;

$files = ["users/classes/Token.future","users/classes/Token.old"];
foreach($files as $f){
  if(file_exists($abs_us_root . $us_url_root . $f)){
    unlink($abs_us_root . $us_url_root . $f);
  }
}

// copy($abs_us_root . $us_url_root. "users/images/logo.png",$abs_us_root . $us_url_root. "usersc/images/logo.png");
// copy($abs_us_root . $us_url_root. "users/images/logo2.png",$abs_us_root . $us_url_root. "usersc/images/logo2.png");
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
