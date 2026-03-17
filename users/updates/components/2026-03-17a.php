<?php
// Migration: Add indexes for frequently queried columns

$countE = $count = 0;

// Index on user_id for permission lookups
$db->query("ALTER TABLE user_permission_matches ADD INDEX idx_user_id (user_id)");

// Index on ip for ban checks
$db->query("ALTER TABLE us_ip_blacklist ADD INDEX idx_ip (ip)");

// Index on page for page path lookups
$db->query("ALTER TABLE pages ADD INDEX idx_page (page)");

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
