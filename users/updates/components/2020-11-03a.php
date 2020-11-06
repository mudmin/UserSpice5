<?php

//Adds a container setting
//Release Version 5.2.0

$countE = 0;

$db->query("ALTER TABLE settings ADD COLUMN container_open_class varchar(255) NULL DEFAULT 'container-fluid'");
if (!$db->error()) {
    logger(1, 'System Updates', 'Added container_open_class column to settings table');
} else {
    ++$countE;
    logger(1, 'System Updates', 'Failed to add container_open_class column to settings table', json_encode(['ERROR' => $db->errorString()]));
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
