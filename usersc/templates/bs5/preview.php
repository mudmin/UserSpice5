<?php
$template_override = "bs5";
require_once '../../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
if(!hasPerm([2],$user->data()->id)){
  die("no permission to be here");
}
require_once $abs_us_root . $us_url_root . "users/includes/bootstrap5_demo.php";
require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php';
