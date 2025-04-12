<style media="screen">
.nav-item {
padding-left:2rem;
}

.nohide {
  color: black !important;
}
.btn-block{
  width:85%;
}

</style>

<?php
if ($settings->navigation_type == 0 ){
  $path = $abs_us_root . $us_url_root . "usersc/templates/".$settings->template;
  if(file_exists($path."/file_nav.php")) {
    require_once $path."/file_nav.php";
}else{
    err("You must copy the file ".$path."/file_nav_example.php to ".$path."/file_nav.php and edit it to create your file based navigation.  Otherwise, set your navigation back to database-based");

}

}else{
  if(isset($menu_override) && is_numeric($menu_override)){
    $menu = new Menu($menu_override);
  }else{
    $menu = new Menu(1);
  }

  $menu->display();
}
