<?php
//This is the upgrade file for version 2025-06-15a


$countE = $count = 0;


$db->query("CREATE TABLE us_rate_limits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    identifier_key VARCHAR(255) NOT NULL,
    action VARCHAR(100) NOT NULL,
    success TINYINT(1) DEFAULT 0,
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    metadata JSON NULL,
    INDEX idx_identifier_action (identifier_key, action),
    INDEX idx_attempt_time (attempt_time),
    INDEX idx_cleanup (attempt_time, success)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");



include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
