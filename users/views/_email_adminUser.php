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
  <p><?=lang("EML_AC_HAS")?> <?php if($force_pr == 0) {?><a href="<?=$results->verify_url?>users/login.php" class="nounderline"><?=lang("EML_CLICK")?></a><?php } ?></p>
  <p><label><?=lang("GEN_UNAME")?>:</label> <?=$username?></p>
  <p><label><?=lang("SIGNIN_PASS")?>:</label> <?php if($force_pr == 1) {?><a href="<?php echo $results->verify_url."users/forgot_password_reset.php?email=".$email."&vericode=$vericode&reset=1"; ?>" class="nounderline">Set Password</a><?php } else { ?><?=$password?><?php } ?></p>
  <p><?php if($force_pr == 1) {?><p><?=lang("EML_REQ");?></p>
  <?php } else { ?>
    <?=lang("EML_REC");?>
  <?php } ?>
</p>
  <sup><p><?=lang("EML_VER_EXP")?><?=$join_vericode_expiry?> <?=lang("T_HOURS")?>.</p></sup>
</body>
</html>
