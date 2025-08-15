<?php
$countE = 0;

$db->query("ALTER TABLE us_ip_blacklist add column `expires` datetime default null");
$db->query("ALTER TABLE us_ip_blacklist add column `descrip` varchar(255) default null");
$db->query("ALTER TABLE us_ip_blacklist add column `added_by` int(11) default null");
$db->query("ALTER TABLE us_ip_blacklist add column `added_on` datetime default null");
$db->query("ALTER TABLE us_ip_whitelist add column `descrip` varchar(255) default null");
$db->query("ALTER TABLE us_ip_whitelist add column `added_by` int(11) default null");
$db->query("ALTER TABLE us_ip_whitelist add column `added_on` datetime default null");
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
