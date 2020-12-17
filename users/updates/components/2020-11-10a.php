<?php

//Adds a container setting
//Release Version 5.2.0

$countE = 0;




$db->query('ALTER TABLE users ALTER account_owner SET DEFAULT 1');
$zeros = $db->query("UPDATE users SET account_owner = ? WHERE account_owner = ?",[1,0]);

if (!$db->error()) {
    logger(1, 'System Updates', 'Set a default for account owner');
} else {
    ++$countE;
    logger(1, 'System Updates', 'Failed to set default for account owner [ERROR] '.$db->errorString());
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
