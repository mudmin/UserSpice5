<?php
require_once '../init.php';
$db = DB::getInstance();
$errors = $successes = [];
$auto = Input::get('auto');

include($abs_us_root.$us_url_root.'users/includes/migrations.php');

$updates = $db->query("SELECT * FROM updates");
if(!$db->error()) {
  $updates=$db->results();
  $existing_updates=[];
  foreach($updates as $u){
    $existing_updates[] = $u->migration;
  }

  $missing = array_diff($migrations,$existing_updates);

  $update=Input::get('override');
  if(!in_array($update,$existing_updates) && $update!='' && !is_null($update)) {
    $db->insert('updates',['migration'=>$update,'update_skipped'=>1]);
    if(!$db->error()) {
      if($db->count()>0) {
        logger(1,"System Updates","Update $update overridden, no update completed.");
        $successes[] = "Update ".$update." overridden.";
      } else {
        logger(1,"System Updates","Update $update unable to be overridden, query was successful but no database entry was made.");
        $errors[] = "Update ".$update." unable to be overridden, query was successful but no database entry was made.";
      }
    } else {
      $error=$db->errorString();
      logger(1,"System Updates","Update $update unable to be overridden, Error: ".$error);
      $errors[] = "Update ".$update." unable to be overridden, Error: ".$error;
    }
    if (($key = array_search($update, $missing)) !== false) {
      unset($missing[$key]);
    }
  }
  ?>
  <div id="page-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <?php
          foreach($missing as $m) {
            $update = $m;
            if(file_exists($abs_us_root.$us_url_root."users/updates/components/".$m.".php")){
              include($abs_us_root.$us_url_root.'users/updates/components/'.$m.'.php');
            } else {
              $errors[] = "Update ".$m." unable to be applied, missing file.";
            }
          }
          ?>

          <?php
          $count = count($successes);
          $eCount = count($errors);
          if($count == 1){?>
            Finished applying <?=$count?> update (<?=$eCount?> errors).<br>
          <?php }else{ ?>
            Finished applying <?=$count?> updates (<?=$eCount?> errors).<br>
          <?php }
          if($auto == 1){
            usSuccess("Update applied");
            Redirect::to($us_url_root."users/admin.php?view=updates&sysup=1");
          }
          if(isset($user) && $user->isLoggedIn()){ ?>
            <a href="<?=$us_url_root?>users/admin.php">Return to the Admin Dashboard</a>
          <?php }else{ ?>
            <a href="<?=$us_url_root?>users/login.php">Click here to login!</a>
          <?php } ?>
        </div>
      </div>
      <div class="row">
        <br>
        <hr>
        <div class="col col-md-6">
          <?php if($count>0) {?>
              <h1>Success Messages</h1>
              <?php foreach($successes as $s) {?>
                <?=$s?><br>
              <?php } ?>
          <?php }
          if($eCount>0) {?>
              <h1>Error Messages</h1>
              <p>These can often be ignored...especially if they mention duplicate columns.  Feel free to check with us in Discord or on the UserSpice.com forums if you have any questions.</p>
              <?php foreach($errors as $e) {?>
                <?=$e?><br>
              <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <?php
} else {
  $errorMsg=$db->errorString();
  logger(1,"System Updates","Failed to retrieve updates, Error: ".$errorMsg);
   ?>
  Failed to retrieve updates, Error: <?=$errorMsg?>
<?php } ?>
