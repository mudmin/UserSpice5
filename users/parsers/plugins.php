<?php
require_once '../init.php';
$db = DB::getInstance();
$settings = $db->query("SELECT * FROM settings")->first();
if(!hasPerm([2],$user->data()->id)){
die("You do not have permission to be here.");
}
$msg = [];
$disable = Input::get('disable');
$activate = Input::get('activate');
$uninstall = Input::get('uninstall');
$install = Input::get('install');
$plugin = Input::get('plugin');
$jump = Input::get('jump');


if($activate != ''){
  $usplugins[$plugin] = 1;
  write_php_ini($usplugins, $abs_us_root.$us_url_root.'usersc/plugins/plugins.ini.php');
  if(file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$plugin.'/activate.php')){
    include $abs_us_root.$us_url_root.'usersc/plugins/'.$plugin.'/activate.php';
  }
  Redirect::to('admin.php?view=plugins&err='.$plugin.' activated'.$jump);
}

if($disable != ''){
  $usplugins[$plugin] = 0;
  write_php_ini($usplugins, $abs_us_root.$us_url_root.'usersc/plugins/plugins.ini.php');
  $db->update('us_plugins',['plugin','=',$plugin],['status'=>'disabled']);
  Redirect::to('admin.php?view=plugins&err='.$plugin.' disabled'.$jump);
}

if($uninstall != ''){
  $usplugins[$plugin] = 2;
  $db->update('us_plugins',['plugin','=',$plugin],['status'=>'uninstalled']);
  write_php_ini($usplugins, $abs_us_root.$us_url_root.'usersc/plugins/plugins.ini.php');
  if(file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$plugin.'/uninstall.php')){
    echo "file exists";
    include $abs_us_root.$us_url_root.'usersc/plugins/'.$plugin.'/uninstall.php';
  }
  Redirect::to('admin.php?view=plugins&err='.$plugin.' uninstalled. You may delete the plugin files if you wish.'.$jump);
}

if($install != ''){
  $usplugins[$plugin] = 0;
  write_php_ini($usplugins, $abs_us_root.$us_url_root.'usersc/plugins/plugins.ini.php');
  if(file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$plugin.'/install.php')){
    include $abs_us_root.$us_url_root.'usersc/plugins/'.$plugin.'/install.php';
  }
  Redirect::to('admin.php?view=plugins&err='.$plugin.' installed but not enabled.'.$jump);
}
