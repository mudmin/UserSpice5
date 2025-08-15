<?php
$countE = 0;

//removes constraints on gender and locale columns
$db->query("ALTER TABLE us_email_logins 
ADD COLUMN verification_code VARCHAR(10),
ADD COLUMN invalid_attempts INT DEFAULT 0;");



include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
