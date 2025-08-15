<?php
$countE = 0;

//removes constraints on gender and locale columns
$db->query("ALTER TABLE users MODIFY COLUMN `gender` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;");
$db->query("ALTER TABLE users MODIFY COLUMN `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;");

//add a fallback option for social logins for people who previously had the plugin installed before it was integrated into the core.
$db->query("ALTER TABLE plg_social_logins ADD COLUMN `built_in` TINYINT(1) default 0");


include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
