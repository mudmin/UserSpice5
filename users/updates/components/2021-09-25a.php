<?php

// Adjusts Feature Names in Dashboard Access
// Release Version 5.3.6

$countE = 0;

$queries = [];
$queries[] = [
    'Description' => "{$update}: Dashbooard Access Feature Renamed: _admin_nav",
    'Query' => "UPDATE us_management SET feature = 'Navigation [List/Add/Delete]' WHERE page = '_admin_nav.php'",
];

$queries[] = [
    'Description' => "{$update}: Dashbooard Access Feature Renamed: _admin_nav_item",
    'Query' => "UPDATE us_management SET feature = 'Navigation [View/Edit]' WHERE page = '_admin_nav_item.php'",
];

$queries[] = [
    'Description' => "{$update}: Dashbooard Access Feature Renamed: _admin_page",
    'Query' => "UPDATE us_management SET feature = 'Page Management [View/Edit]' WHERE page = '_admin_page.php'",
];

$queries[] = [
    'Description' => "{$update}: Dashbooard Access Feature Renamed: _admin_pages",
    'Query' => "UPDATE us_management SET feature = 'Page Management [List]' WHERE page = '_admin_pages.php'",
];

$queries = json_decode(json_encode($queries));

foreach ($queries as $query) {
    $db->query($query->Query);
    if (!$db->error()) {
        logger(1, 'System Updates', $query->Description);
    } else {
        ++$countE;
        logger(1, 'System Updates', 'Feature Renaming Failed', ['EXPECTED_LOG' => $query->Description, 'ERROR' => $db->errorString()]);
    }
}

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
