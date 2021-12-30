<?php

// Forcing html to be encoded before decoding
// Release Version 5.4.0

$countE = 0;

$files = [$abs_us_root.$us_url_root."users/includes/system_messages_footer.php",$abs_us_root.$us_url_root."usersc/includes/system_messages_footer.php"];
foreach($files as $f){
	if(file_exists($f)){
		$file = file_get_contents($f);
		$file = str_replace("echo htmlspecialchars_decode(Input::get('err')","echo htmlspecialchars_decode(htmlspecialchars(Input::get('err'))",$file);
		$file = str_replace("echo htmlspecialchars_decode(Input::get('msg')","echo htmlspecialchars_decode(htmlspecialchars(Input::get('msg'))",$file);
		$file = str_replace('echo htmlspecialchars_decode($usSessionMessages[$key]','echo htmlspecialchars_decode(htmlspecialchars($usSessionMessages[$key])',$file);
		file_put_contents($f,$file);
	}
}

$files = [];
if(file_exists($abs_us_root.$us_url_root."usersc/plugins/alerts/info.xml")){
  $dir = new DirectoryIterator($abs_us_root.$us_url_root."usersc/plugins/alerts/assets/");
    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDir() && !$fileinfo->isDot()) {
            $files[] = $fileinfo->getFilename();
        }
    }
}

foreach($files as $f){
  $fname = $abs_us_root.$us_url_root."usersc/plugins/alerts/assets/".$f."/alerts.php";
	if(file_exists($fname)){
		$file = file_get_contents($fname);
		$file = str_replace("htmlspecialchars_decode(Input::get('err')","htmlspecialchars_decode(htmlspecialchars(Input::get('err'))",$file);
		$file = str_replace("htmlspecialchars_decode(Input::get('msg')","htmlspecialchars_decode(htmlspecialchars(Input::get('msg'))",$file);
		$file = str_replace('htmlspecialchars_decode($usSessionMessages[\'valErr\']','htmlspecialchars_decode(htmlspecialchars($usSessionMessages[\'valErr\'])',$file);
    $file = str_replace('htmlspecialchars_decode($usSessionMessages[\'valSuc\']','htmlspecialchars_decode(htmlspecialchars($usSessionMessages[\'valSuc\'])',$file);
    $file = str_replace('htmlspecialchars_decode($usSessionMessages[\'genMsg\']','htmlspecialchars_decode(htmlspecialchars($usSessionMessages[\'genMsg\'])',$file);
		file_put_contents($fname,$file);
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
