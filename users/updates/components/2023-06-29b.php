<?php
$countE = 0;

//somehow if upgading from UserSpice 4.3 to 5.6, you wind up missing a us_plugins table.
$db->query("CREATE TABLE `us_plugins` (
  `id` int(11) NOT NULL,
  `plugin` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `updates` text DEFAULT NULL,
  `last_check` datetime DEFAULT '2020-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

$db->query("ALTER TABLE `us_plugins`
  ADD PRIMARY KEY (`id`)");

$db->query("ALTER TABLE `us_plugins`
  ADD PRIMARY KEY (`id`)");
  
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
