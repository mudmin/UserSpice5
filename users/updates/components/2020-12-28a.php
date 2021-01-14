<?php

//Release Version 5.2.3

$countE = 0;

$db->query("ALTER TABLE `pages` MODIFY COLUMN `page` VARCHAR (255)");
$db->query("ALTER TABLE `pages` MODIFY COLUMN `title` VARCHAR (255)");

//this is a temporary fix until we get the user class and plugins cleaned up
$db->query("ALTER TABLE `users` ADD COLUMN `gender` VARCHAR (50)");
$db->query("ALTER TABLE `users` ADD COLUMN `locale` VARCHAR (50)");
$db->query("ALTER TABLE `users` ADD COLUMN `created` DATETIME");


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
