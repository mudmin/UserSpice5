<?php

//Adds a metadata blob to the logs table
//Release Version 5.1.7

$countE = 0;

$db->query('ALTER TABLE logs ADD COLUMN metadata blob NULL');
if (!$db->error()) {
    logger(1, 'System Updates', 'Added metadata column to logs table');
} else {
    ++$countE;
    logger(1, 'System Updates', 'Failed to add metadata column to logs table [ERROR] '.$db->errorString());
}

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
