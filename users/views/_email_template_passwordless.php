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
  <!-- Prevent iOS from auto-linking numbers like a 6-digit code -->
<meta name="format-detection" content="telephone=no,date=no,address=no,email=no,url=no">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body style="font-size: 16px;">
    <p><?=lang("EML_HI")?> <?=$fname;?>,</p>
    <p><?=$EML_PASSWORDLESS_BODY?></p>
    
    <?php if($settings->email_login == 2 || $settings->email_login == 3) { ?>
      <?=lang("PASS_YOUR_CODE")?><br>
      <div
        style="
          display:inline-block;
          padding:14px 18px;
          background:#eff6ff;
          color:#111111;
          font-family: SFMono-Regular, Consolas, 'Liberation Mono', Menlo, monospace;
          font-size:32px;
          line-height:1.2;
          font-weight:700;
          letter-spacing:4px;
          white-space:nowrap;
        "
        aria-label="<?=lang('PASS_YOUR_CODE')?>"
        dir="ltr"
      >
        <span style="font-family:inherit;">
          <?=safeReturn($verification_code)?>
        </span>
      </div>
    <?php } ?>
    
    <?php if($settings->email_login == 1 || $settings->email_login == 3) { ?>
      <p><a href="<?=$eml_set->verify_url?><?=$url?>" class="nounderline"><?=lang("EML_VER")?></a></p>
    <?php } ?>
    <p><?=lang("EML_VER_EXP")?><?=$passwordless_expiry?> <?=lang("T_MINUTES")?>.</p>
</html>