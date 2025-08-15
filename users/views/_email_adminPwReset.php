<?php
$db = DB::getInstance();
$query = $db->query("SELECT * FROM email");
$results = $query->first();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <p><?=lang("EML_HELLO")?><?=$sitename?>,</p>
  <p><?=lang("EML_AD_HAS")?></p>
  <p><label><?=lang("GEN_UNAME")?>:</label> <?=$username?></p>
  <p><label><?=lang("SIGNIN_PASS")?>:</label> <a href="<?php echo $results->verify_url."users/forgot_password_reset.php?email=".$email."&vericode=$vericode&reset=1"; ?>" class="nounderline"><?=lang("PW_RESET");?></a></p>
  <p><?=lang("EML_REQ");?></p>
  <sup><p><?=lang("EML_EXP")?> <?=$reset_vericode_expiry?> <?=lang("T_MINUTES")?>.</p></sup>
</body>
</html>
