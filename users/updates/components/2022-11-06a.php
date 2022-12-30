<?php

// Allowing user to specify AuthType for phpmailer
// Release Version 5.4.2

$countE = 0;

$db->query("CREATE TABLE `us_menus` (
  `id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `menu_name` varchar(255) DEFAULT NULL,
  `type` varchar(75) DEFAULT NULL,
  `nav_class` varchar(255) DEFAULT NULL,
  `theme` varchar(25) DEFAULT NULL,
  `z_index` int(11) DEFAULT NULL,
  `brand_html` text,
  `disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$db->query("INSERT INTO `us_menus` (`id`, `menu_name`, `type`, `nav_class`, `theme`, `z_index`, `brand_html`, `disabled`) VALUES
(1, 'Main Menu', 'horizontal', '', 'dark', 50, '&lt;a href=&quot;{{root}}&quot; &gt;
&lt;img src=&quot;{{root}}users/images/logo.png&quot; /&gt;', 0)
");


$db->query("CREATE TABLE `us_menu_items` (
  `id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `menu` int(11) UNSIGNED NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `link` text,
  `icon_class` varchar(255) DEFAULT NULL,
  `li_class` varchar(255) DEFAULT NULL,
  `a_class` varchar(255) DEFAULT NULL,
  `link_target` varchar(50) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$db->query("ALTER TABLE us_menus ADD COLUMN justify varchar(10) default 'right'");
$db->query("ALTER TABLE us_menu_items ADD COLUMN permissions varchar(1000)");

migrateUSMainMenu(true);

if ($countE == 0) {
    $db->insert('updates', ['migration' => $update]);
    if (!$db->error()) {
        if ($db->count() > 0) {
            logger(1, 'System Updates', "Update {$update} successfully deployed.");
            $successes[] = "Update {$update} successfully deployed.";
        } else {
            $error = 'no_db_entry';
            logger(1, 'System Updates', "Update {$update} unable to be marked complete", ['ERROR' => $error]);
            $errors[] = "Update {$update}: {$error}";
        }
    } else {
        $error = $db->errorString();
        logger(1, 'System Updates', "Update {$update} unable to be marked complete", ['ERROR' => $error]);
        $errors[] = "Update {$update}: {$error}";
    }
} else {
    $error = 'preflight_check_failed';
    logger(1, 'System Updates', "Update {$update} unable to be marked complete", ['ERROR' => $error]);
    $errors[] = "Update {$update}: {$error}";
}
