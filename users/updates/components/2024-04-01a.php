<?php
$countE = 0;

$db->query("ALTER TABLE us_password_strength ADD COLUMN uppercase_score INT(11) NOT NULL DEFAULT '6'");
$db->query("ALTER TABLE us_password_strength ADD COLUMN lowercase_score INT(11) NOT NULL DEFAULT '6'");
$db->query("ALTER TABLE us_password_strength ADD COLUMN number_score INT(11) NOT NULL DEFAULT '6'");
$db->query("ALTER TABLE us_password_strength ADD COLUMN symbol_score INT(11) NOT NULL DEFAULT '11'");
$db->query("ALTER TABLE us_password_strength ADD COLUMN greater_eight INT(11) NOT NULL DEFAULT '15'");
$db->query("ALTER TABLE us_password_strength ADD COLUMN greater_twelve INT(11) NOT NULL DEFAULT '28'");
$db->query("ALTER TABLE us_password_strength ADD COLUMN greater_sixteen INT(11) NOT NULL DEFAULT '40'");

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
