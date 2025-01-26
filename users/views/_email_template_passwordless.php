<?php
$db = DB::getInstance();
$eml_set = $db->query("SELECT * FROM email")->first();
$settings = $db->query("SELECT * FROM settings")->first();

if($settings->email_login == 1){
  $EML_PASSWORDLESS_BODY = lang("PASS_EMAIL_ONLY_MSG");
}elseif($settings->email_login == 2){
  $EML_PASSWORDLESS_BODY = lang("PASS_CODE_ONLY_MSG");
}elseif($settings->email_login == 3){
  $EML_PASSWORDLESS_BODY = lang("PASS_BOTH_MSG");
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
    
    <?php if($settings->email_login == 2 || $settings->email_login == 3) { ?>
      <p><?=lang("PASS_YOUR_CODE")?> <strong><?=$verification_code?></strong></p>

    <?php } ?>
    
    <?php if($settings->email_login == 1 || $settings->email_login == 3) { ?>
      <p><a href="<?=$eml_set->verify_url?><?=$url?>" class="nounderline"><?=lang("EML_VER")?></a></p>

    <?php } ?>
    <sup><p><?=lang("EML_VER_EXP")?><?=$passwordless_expiry?> <?=lang("T_MINUTES")?>.</p></sup>
  </body>
</html>
