<?php
$countE = 0;

$db->query("
CREATE TABLE `plg_tags` (
 `id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
 `tag` varchar(255)
);
");

$db->query("
CREATE TABLE `plg_tags_matches` (
 `id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
 `tag_id` int(11) UNSIGNED NOT NULL,
 `tag_name` varchar(255),
 `user_id` int(11) UNSIGNED NOT NULL
);
");

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
