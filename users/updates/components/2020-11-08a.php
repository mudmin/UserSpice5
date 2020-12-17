<?php

//Adds a container setting
//Release Version 5.2.0

$countE = 0;


if(file_exists($abs_us_root.$us_url_root."usersc/scripts/banned.php")){
$banned = file_get_contents($abs_us_root.$us_url_root."usersc/scripts/banned.php");
if(strlen($banned) == 461){
		$newBanned = fopen($abs_us_root.$us_url_root."usersc/scripts/banned.php", "w");
		$contents = "<?php\n";
		fwrite($newBanned, $contents);
		$contents = "require_once '../../users/init.php';\n";
		fwrite($newBanned, $contents);
		$contents = "require_once \$abs_us_root.\$us_url_root.'users/includes/template/prep.php';\n";
		fwrite($newBanned, $contents);
		$contents = "?>\n";
		fwrite($newBanned, $contents);
		$contents = "<h1><?=lang('MAINT_BAN');?></h1>\n";
		fwrite($newBanned, $contents);
		$contents = "<?php die(); ?>";
		fwrite($newBanned, $contents);
		fclose($newBanned);
		logger(1, 'System Updates', 'Fixed banned.php file');
}
}else{
      ++$countE;
      logger(1, 'System Updates', "banned.php was not stock so was not migrated");
}

// if (!$db->error()) {
//     logger(1, 'System Updates', 'Added container_open_class column to settings table');
// } else {
//     ++$countE;
//     logger(1, 'System Updates', 'Failed to add container_open_class column to settings table', json_encode(['ERROR' => $db->errorString()]));
// }

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
