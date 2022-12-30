<?php
include "../init.php";
$db = DB::getInstance();
$settings = $db->query("SELECT * FROM settings")->first();

if (!isset($user) || (!in_array($user->data()->id, $master_account))) {
  die("Permission denied");
}
$type = Input::get('type');
$url = Input::get('url');
$hash = Input::get('hash');
$diag = Input::get('diag');
$reserved = Input::get('reserved');
$api = "https://api.userspice.com/api/v2/";

$zipFile = "temp.zip";
if(file_exists($abs_us_root.$us_url_root."users/parsers/".$zipFile)){
  unlink($abs_us_root.$us_url_root."users/parsers/".$zipFile);
}

if(!Token::check(Input::get('token'))){
  $msg = [];
  $msg['success'] = false;
  $msg['error'] = "Invalid token";
  echo json_encode($msg);
  die;
}

if ($type == 'plugin') {
  $extractPath = "../../usersc/plugins";
  $reserved = Input::get('reserved');
  if(pluginActive($reserved,true)){
    $return = $us_url_root . "users/admin.php?view=plugins_config&plugin=".$reserved;
  }else{
    $return = $us_url_root . "users/admin.php?view=plugins";
  }

} elseif ($type == 'widget') {
  $extractPath = "../../usersc/widgets";
  $return = $us_url_root . "users/admin.php";
} elseif ($type == 'template') {
  $extractPath = "../../usersc/templates";
  $return = $us_url_root . "users/admin.php?view=templates";
} elseif ($type == 'translation') {
  $extractPath = $abs_us_root . $us_url_root . "users";
  usSuccess("Language(s) installed");
  $return = $us_url_root . "users/admin.php";
} else {
  $data['error'] = "Something is wrong";
  if($diag){logger($user->data()->id, "DIAG", "Invalid request type");}
  echo json_encode($data);
  die();
}
if($diag){logger($user->data()->id, "DIAG", "Attempting to create zip file");}
$zip_resource = fopen($zipFile, "w");
if($diag){
  if(!$zip_resource){
  logger($user->data()->id, "DIAG", "Did not have permission to create zip file");
}
}

if($diag){logger($user->data()->id, "DIAG", "Attempting CURL request to download file contents");}
$ch_start = curl_init();
curl_setopt($ch_start, CURLOPT_URL, $url);
curl_setopt($ch_start, CURLOPT_FAILONERROR, true);
curl_setopt($ch_start, CURLOPT_HEADER, 0);
curl_setopt($ch_start, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch_start, CURLOPT_AUTOREFERER, true);
curl_setopt($ch_start, CURLOPT_BINARYTRANSFER, true);
curl_setopt($ch_start, CURLOPT_TIMEOUT, 10);
curl_setopt($ch_start, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch_start, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch_start, CURLOPT_FILE, $zip_resource);
$page = curl_exec($ch_start);
if (!$page) {
  if($diag){logger($user->data()->id, "DIAG", "CURL Error :- " . curl_error($ch_start));}
  echo "Error :- " . curl_error($ch_start);
}
curl_close($ch_start);

$zip = new ZipArchive;

if ($zip->open($zipFile) != "true") {
  if($diag){logger($user->data()->id, "DIAG", "Error :- Unable to open the Zip File");}
  echo "Error :- Unable to open the Zip File";
}
$newCrc = base64_encode(hash_file("sha256", $zip->filename));

//we are going to recheck the api from inside the parser to confirm that nothing has been edited in the javascript

//create a new cURL resource
$ch = curl_init($api);
$data = array(
  'key' => $settings->spice_api,
  'type' => $type,
  'call' => 'recheck',
  'url' => $url,
);

$payload = json_encode($data);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$result = substr($result, 1, -1);
$result = substr($result, 0, strpos($result, '=='));
$result .= "==";



curl_close($ch);
if ($newCrc == $hash && $newCrc == $result) { //Note that we are checking the hash against the api call and the one supplied by ajax
  if($diag){
    logger($user->data()->id, "DIAG", "The security hash matches...unzipping");
  }
  if ($zip->extractTo($extractPath) === TRUE) {
    $zip->close();

    if(isset($reserved) && pluginActive($reserved,true)){
      if(file_exists($extractPath."/".$reserved."/migrate.php")){
        include $extractPath."/".$reserved."/migrate.php";
      }
    }

    $msg = [];
    $msg['success'] = true;
    $msg['url'] = $return;
  }else{
    $msg = [];
    $msg['success'] = false;
    $msg['error'] = "Unable to open zip.";
    logger($user->data()->id, "DIAG", "Unable to open zip file");
  }

} else {
  if($diag){logger($user->data()->id, "DIAG", "The security hash DOES NOT MATCH newCRC $newCrc hash $hash result $result"); }
  $msg = [];
  $msg['success'] = false;
  $msg['error'] = "The hash does not match.  This means one of 2 things. Either the file on the server has been tampered with or (more likely) the file was
       updated and we forgot to update the hash.  Please fill out a bug report. You can still download this plugin at $url if you wish.";
}
unset($zip_resource);
unlink($zipFile);
echo json_encode($msg);
