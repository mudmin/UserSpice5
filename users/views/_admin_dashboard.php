<?php
if(file_exists($abs_us_root . $us_url_root . "usersc/modules/widgets.php")){
  require_once $abs_us_root . $us_url_root . "usersc/modules/widgets.php";
}else{
  require_once $abs_us_root . $us_url_root . "users/modules/widgets.php";
}
