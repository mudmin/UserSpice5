<?php

//Adds US Form Manager tables and data
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-04-07 DH

$countE=0;

if(file_exists($abs_us_root.$us_url_root."/usersc/user_agreement_acknowledge.php")){
  ?>
  <script>
  alert("We see that you are using a custom version of usersc/user_agreement_acknowledge. We recommend that you rename that file and put your custom terms and conditions in usersc/lang now.");
  </script>
  <?php
}

if($countE==0) {
  $db->insert('updates',['migration'=>$update]);
  if(!$db->error()) {
    if($db->count()>0) {
      logger(1,"System Updates","Update $update successfully deployed.");
      $successes[] = "Update $update successfully deployed.";
    } else {
      logger(1,"System Updates","Update $update unable to be marked complete, query was successful but no database entry was made.");
      $errors[] = "Update ".$update." unable to be marked complete, query was successful but no database entry was made.";
    }
  } else {
    $error=$db->errorString();
    logger(1,"System Updates","Update $update unable to be marked complete, Error: ".$error);
    $errors[] = "Update $update unable to be marked complete, Error: ".$error;
  }
} else {
  logger(1,"System Updates","Update $update unable to be marked complete");
  $errors[] = "Update $update unable to be marked complete";
}
