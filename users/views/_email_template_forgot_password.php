<?php
$db = DB::getInstance();
$query = $db->query("SELECT * FROM email");
$results = $query->first();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
  <p><?=lang("EML_HI")?> <?=$fname;?>,</p>
  <p><?=lang("EML_WHY")?></p>
  <p><?=lang("EML_HOW")?></p>
  <p><a href="<?php echo $results->verify_url."users/forgot_password_reset.php?email=".$email."&vericode=$vericode&reset=1"; ?>" class="nounderline"><?=lang("PW_RESET");?></a></p>
  <sup><p><?=lang("EML_EXP")?> <?=$reset_vericode_expiry?> <?=lang("T_MINUTES")?>.</p></sup>
</body>
</html>
