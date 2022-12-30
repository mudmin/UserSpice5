<?php
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
