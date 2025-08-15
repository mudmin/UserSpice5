<?php
$countE = 0;
$plug = "usertags";
deRegisterHooks($plug);
if(isset($usplugins[$plug])){
    $usplugins[$plug] = 2;
    write_php_ini($usplugins, $abs_us_root . $us_url_root . 'usersc/plugins/plugins.ini.php');
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
