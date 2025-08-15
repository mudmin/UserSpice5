<?php
$countE = 0;

if(file_exists($abs_us_root . $us_url_root . 'usersc/login.php')){
    $fields = [
        'link'=>'#',
        'title'=>'We noticed you are using a custom login.php',
        'message'=>'We have made changes to users/login.php involving how the error and success messages are handled.  As it stands now, your users/login.php will NOT display error or success messages. Please take a look at the new login.php and make the necessary changes to your custom login.php to ensure that error and success messages are displayed properly.',
        'dismissed_by'=>0,
        'update_announcement'=>1,
        'class'=>'danger'
    ];
    $db->insert('us_announcements',$fields);
}
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
