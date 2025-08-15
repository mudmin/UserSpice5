<?php

//Release Version 5.2.2

$countE = 0;

$db->query("ALTER TABLE users ADD COLUMN active tinyint(1) DEFAULT 1");
    logger(1, 'System Updates', 'Added active to users table');

if ($countE == 0) {
    $db->insert('updates', ['migration' => $update]);
    if (!$db->error()) {
        if ($db->count() > 0) {
            logger(1, 'System Updates', "Update $update successfully deployed.");
            $successes[] = "Update $update successfully deployed.";
        } else {
            logger(1, 'System Updates', "Update $update unable to be marked complete, query was successful but no database entry was made.");
            $errors[] = 'Update '.$update.' unable to be marked complete, query was successful but no database entry was made.';
        }
    } else {
        $error = $db->errorString();
        logger(1, 'System Updates', "Update $update unable to be marked complete, Error: ".$error);
        $errors[] = "Update $update unable to be marked complete, Error: ".$error;
    }
} else {
    logger(1, 'System Updates', "Update $update unable to be marked complete");
    $errors[] = "Update $update unable to be marked complete";
}
