<?php
$countE = 0;
$db->query("ALTER TABLE us_email_logins ADD COLUMN expires datetime default null");
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
