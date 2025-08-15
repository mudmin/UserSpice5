<?php
$countE = 0;

$cols = [
    'company','oauth_provider','oauth_uid','gpluslink','fb_uid','picture'
];

foreach($cols as $col){
    $db->query("ALTER TABLE users MODIFY COLUMN $col text");
}

$db->query("ALTER TABLE users MODIFY column `language` varchar(15) default 'en-US'");
$db->query("ALTER TABLE settings MODIFY column `language` varchar(15)");

$cols = [
    'gid','gsecret','gredirect','ghome','fbid','fbsecret','fbcallback','graph_ver','finalredir',
    'backup_dest','backup_source','backup_table','recap_public','recap_private'
];

foreach($cols as $col){
    $db->query("ALTER TABLE settings MODIFY COLUMN $col text");
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
