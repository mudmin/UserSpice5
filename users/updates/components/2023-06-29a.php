<?php
$countE = 0;
//delete a stray file that could be located in usersc
if(file_exists($abs_us_root . $us_url_root . "usersc/includes/user_spice_ver.php")){
  include $abs_us_root . $us_url_root . "usersc/includes/user_spice_ver.php";
  //check to make sure it's the problem file.
  if($user_spice_ver == "5.5.1"){
    unlink($abs_us_root . $us_url_root . "usersc/includes/user_spice_ver.php");
    $user_spice_ver = "5.6.3";
  }
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
