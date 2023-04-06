<?php

// Allowing user to specify AuthType for phpmailer
// Release Version 5.4.2

$countE = 0;

$db->query("CREATE TABLE us_menus (
    id SERIAL PRIMARY KEY,
    menu_name varchar(255),
    type varchar(75),
    nav_class varchar(255),
    theme varchar(25),
    z_index int,
    brand_html text,
    disabled smallint DEFAULT 0
  )");

$db->query("INSERT INTO us_menus (id, menu_name, type, nav_class, theme, z_index, brand_html, disabled)
            VALUES (1, 'Main Menu', 'horizontal', '', 'dark', 50, '<a href=\"{{root}}\"> <img src=\"{{root}}users/images/logo.png\" /></a>', 0)");


$db->query("CREATE TABLE us_menu_items (
    id SERIAL PRIMARY KEY,
    menu int NOT NULL,
    type varchar(50),
    label varchar(255),
    link text,
    icon_class varchar(255),
    li_class varchar(255),
    a_class varchar(255),
    link_target varchar(50),
    parent int,
    display_order int,
    disabled smallint DEFAULT 0
  )");

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
