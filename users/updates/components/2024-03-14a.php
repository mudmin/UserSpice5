<?php
$countE = 0;
$db->query("ALTER TABLE us_announcements MODIFY COLUMN `message` text");
$db->query("ALTER TABLE us_announcements ADD COLUMN dismissed_by int(11) default 0");
$db->query("ALTER TABLE us_announcements ADD update_announcement tinyint(1) default 0");
if(file_exists($abs_us_root . $us_url_root . 'usersc/plugins/usertags/info.xml')){
    $fields = [
        'link'=>'#',
        'title'=>'The User Tags plugin has been moved to the UserSpice Core',
        'message'=>'The User Tags plugin has been moved to the UserSpice Core.  You can now find it in the Permissions section.  We have automatically deactivated the plugin. You can delete the files if you wish.  If you have any questions, please feel free to ask on our Discord.',
        'dismissed_by'=>0,
        'update_announcement'=>1,
        'class'=>'warning'
    ];
    $db->insert('us_announcements',$fields);
}
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
