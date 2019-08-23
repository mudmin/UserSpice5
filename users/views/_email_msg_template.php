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
  <p><?=lang("EML_MSG");?> <?=$sendfname;?>!</p>
  <p><a href="<?=$results->verify_url?>users/message.php?id=<?=$msg_thread?>" class="nounderline"><?=lang("EML_REPLY")?></a> </p>
  <hr />
  <?=html_entity_decode($body)?>
</body>
</html>
