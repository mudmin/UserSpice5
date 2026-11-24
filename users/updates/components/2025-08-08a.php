<?php
$countE = $count = 0;

$db->query("CREATE TABLE IF NOT EXISTS us_rate_limit_proxy_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proxy_ip VARCHAR(45) NOT NULL, 
    header_name VARCHAR(100) NOT NULL, 
    priority INT DEFAULT 0,
    enabled TINYINT(1) DEFAULT 1, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_proxy_ip (proxy_ip),
    INDEX idx_header_name (header_name),
    INDEX idx_enabled_priority (enabled, priority)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

// Fresh installs create settings.behind_reverse_proxy in sql.sql, so add columns only when missing.
$columnExists = function ($table, $column) use ($db) {
    return $db->query(
        "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?",
        [$table, $column]
    )->count() > 0;
};
if (!$columnExists('settings', 'behind_reverse_proxy')) {
    $db->query("ALTER TABLE settings ADD COLUMN behind_reverse_proxy tinyint(1) default 0");
}
if (!$columnExists('us_rate_limit_proxy_settings', 'header')) {
    $db->query("ALTER TABLE us_rate_limit_proxy_settings ADD COLUMN header varchar(255) DEFAULT NULL AFTER header_name");
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
