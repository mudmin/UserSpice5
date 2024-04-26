<?php

$db = DB::getInstance();

$query = $db->query("SELECT * FROM email");
$results = $query->first();

if(lang("EML_PASSWORDLESS_BODY") != "{ Missing Text }"){
  $EML_PASSWORDLESS_BODY = lang("EML_PASSWORDLESS_BODY");
}else{
  $EML_PASSWORDLESS_BODY = "Please verify your email address by clicking the link below. You will be automatically logged in.";
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <p><?=lang("EML_HI")?> <?=$fname;?>,</p>
    <p><?=$EML_PASSWORDLESS_BODY?></p>
    <p><a href="<?=$results->verify_url?><?=$url?>" class="nounderline"><?=lang("EML_VER")?></a></p>
      <sup><p><?=lang("EML_VER_EXP")?><?=$passwordless_expiry?> <?=lang("T_MINUTES")?>.</p></sup>
  </body>
</html>
