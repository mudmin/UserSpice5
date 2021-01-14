<?php

//Release Version 5.2.3

$countE = 0;

$db->query("ALTER TABLE users
ALTER language SET DEFAULT 'en-US'");

$users = $db->query("SELECT id,language FROM users")->results();
foreach($users as $u){
	if(substr($u->language,1,2) =='en'){
	$db->update('users',$u->id,['language'=>'en-US']);
}
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
