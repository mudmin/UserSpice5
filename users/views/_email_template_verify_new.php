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
  <p><?=lang("EML_HI")?> <?=$fname;?>,</p>
  <p><?=lang("EML_EML");?></p>
  <p><a href="<?=$results->verify_url?>users/verify.php?new=1&email=<?=$email;?>&vericode=<?=$vericode;?>" class="nounderline"><?=lang("EML_VER")?></a></p>
  <sup><p><?=lang("EML_VER_EXP")?><?=$join_vericode_expiry?> <?=lang("T_HOURS")?>.</p></sup>
</body>
</html>
