<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
        <li>Manage</li>
        <li><a href="<?=$us_url_root?>users/admin.php?view=users">Users</a></li>
        <li class="active">User</li>
      </ol>
    </div>
  </div>
</div>
</div>
</header>

<?php
$validation = new Validate();
//PHP Goes Here!
$query = $db->query("SELECT * FROM email");
$results = $query->first();
$act = $results->email_act;
$errors = [];
$successes = [];
$userId = Input::get('id');
$email = $db->query("SELECT * FROM email")->first();
//Check if selected user exists
if(!userIdExists($userId)){
  Redirect::to($us_url_root.'users/admin.php?view=users&err=That user does not exist.'); die();
}

$userdetails = fetchUserDetails(NULL, NULL, $userId); //Fetch user details

//Forms posted
if(!empty($_POST)) {
  $token = $_POST['csrf'];
  if(!Token::check($token)){
    include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
  }else {

    if(!empty($_POST['delete'])){
      $deletions = $_POST['delete'];
      if ($deletion_count = deleteUsers($deletions)){
        logger($user->data()->id,"User Manager","Deleted user named $userdetails->fname.");
        Redirect::to($us_url_root.'users/admin.php?view=users&msg='.lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count)));
      }
      else {
        $errors[] = lang("SQL_ERROR");
      }
    }
    else
    {

      if(!empty($_POST['cloak'])){
        if($user->data()->cloak_allowed!=1 && !in_array($user->data()->id,$master_account) && !isset($_SESSION['cloak_to'])) {
          logger($user->data()->id,"Cloaking","User attempted to cloak User ID #".$userId);
          Redirect::to($us_url_root.'users/admin.php?view=users&err=You do not have permission to cloak.');
        }else{
          if(in_array($userId,$master_account) && !in_array($user->data()->id,$master_account)){
            logger($user->data()->id,"Cloaking","User attempted to cloak User ID #$userId who belongs to the Master Account Array.");
            Redirect::to($us_url_root.'users/admin.php?view=users&err=You cannot cloak into a master account.');
          }elseif($userId == $user->data()->id){
            logger($user->data()->id,"Cloaking","User attempted to cloak themself.");
            Redirect::to($us_url_root.'users/admin.php?view=users&err=Cloaking+into+yourself+would+open+up+a+black+hole!');
          }else{
            $check = $db->query("SELECT id FROM users WHERE id = ?",array($userId));
            $count = $check->count();
            if($count < 1){
              Redirect::to($us_url_root.'users/admin.php?view=users&err=You+broke+it!+User+not+found.');
            }else{
              $_SESSION['cloak_from']=$user->data()->id;
              $_SESSION['cloak_to']=$userId;
              logger($user->data()->id,"Cloaking","Cloaked into ".$userId);
              Redirect::to('account.php?err=You+are+now+cloaked!');
            }
          }
        }
      }

      //Update display name
      $displayname = Input::get("username");
      if ($userdetails->username != $displayname) {

        $fields=array('username'=>$displayname);
        $validation->check($_POST,array(
          'username' => array(
            'display' => 'Username',
            'required' => true,
            'unique_update' => 'users,'.$userId,
            'min' => $settings->min_un,
            'max' => $settings->max_un
          )
        ));
        if($validation->passed()){
          $db->update('users',$userId,$fields);
          $successes[] = "Username Updated";
          logger($user->data()->id,"User Manager","Updated username for $userdetails->fname from $userdetails->username to $displayname.");
        }else{

        }
      }

      //Update first name
      $fname = ucfirst(Input::get("fname"));
      if ($userdetails->fname != $fname) {

        $fields=array('fname'=>$fname);
        $validation->check($_POST,array(
          'fname' => array(
            'display' => 'First Name',
            'required' => true,
            'min' => 1,
            'max' => 25
          )
        ));
        if($validation->passed()){
          $db->update('users',$userId,$fields);
          $successes[] = "First Name Updated";
          logger($user->data()->id,"User Manager","Updated first name for $userdetails->fname from $userdetails->fname to $fname.");
        }else{
          ?><?php if(!$validation->errors()=='') {?><div class="alert alert-danger"><?=display_errors($validation->errors());?></div><?php } ?>
          <?php
        }
      }

      //Update last name
      $lname = ucfirst(Input::get("lname"));
      if ($userdetails->lname != $lname){

        $fields=array('lname'=>$lname);
        $validation->check($_POST,array(
          'lname' => array(
            'display' => 'Last Name',
            'required' => true,
            'min' => 1,
            'max' => 25
          )
        ));
        if($validation->passed()){
          $db->update('users',$userId,$fields);
          $successes[] = "Last Name Updated";
          logger($user->data()->id,"User Manager","Updated last name for $userdetails->fname from $userdetails->lname to $lname.");
        }else{
          ?>
          <?php if(!$validation->errors()=='') {?><div class="alert alert-danger"><?=display_errors($validation->errors());?></div><?php } ?>
          <?php
        }
      }

      if(!empty($_POST['password'])) {
        $validation->check($_POST,array(
          'password' => array(
            'display' => 'New Password',
            'required' => true,
            'min' => $settings->min_pw,
            'max' => $settings->max_pw,
          ),
          'confirm' => array(
            'display' => 'Confirm New Password',
            'required' => true,
            'matches' => 'password',
          ),
        ));

        if (empty($errors)) {
          //process
          $new_password_hash = password_hash(Input::get('password', true), PASSWORD_BCRYPT, array('cost' => 12));
          $user->update(array('password' => $new_password_hash,),$userId);
          $successes[]='Password updated.';
          logger($user->data()->id,"User Manager","Updated password for $userdetails->fname.");
          if($settings->session_manager==1) {
            if($userId==$user->data()->id) $passwordResetKillSessions=passwordResetKillSessions();
            else $passwordResetKillSessions=passwordResetKillSessions($userId);
            if(is_numeric($passwordResetKillSessions)) {
              if($passwordResetKillSessions==1) $successes[] = "Successfully Killed 1 Session";
              if($passwordResetKillSessions >1) $successes[] = "Successfully Killed $passwordResetKillSessions Session";
            } else {
              $errors[] = "Failed to kill active sessions, Error: ".$passwordResetKillSessions;
            }
          }
        }
      }
      $vericode_expiry=date("Y-m-d H:i:s",strtotime("+$settings->reset_vericode_expiry minutes",strtotime(date("Y-m-d H:i:s"))));
      $vericode=randomstring(15);
      $db->update('users',$userdetails->id,['vericode' => $vericode,'vericode_expiry' => $vericode_expiry]);
      if(isset($_POST['sendPwReset'])) {
        $params = array(
          'username' => $userdetails->username,
          'sitename' => $settings->site_name,
          'fname' => $userdetails->fname,
          'email' => rawurlencode($userdetails->email),
          'vericode' => $userdetails->vericode,
          'reset_vericode_expiry' => $settings->reset_vericode_expiry
        );
        $to = rawurlencode($userdetails->email);
        $subject = 'Password Reset';
        $body = email_body('_email_adminPwReset.php',$params);
        email($to,$subject,$body);
        $successes[] = "Password reset sent.";
        logger($user->data()->id,"User Manager","Sent password reset email to $userdetails->fname, Vericode expires in $settings->reset_vericode_expiry minutes.");
      }

      //Block User
      $active = Input::get("active");
      if ($userdetails->permissions != $active){
        $fields=array('permissions'=>$active);
        $db->update('users',$userId,$fields);
        $successes[] = "Set user access to $active.";
        logger($user->data()->id,"User Manager","Updated active for $userdetails->fname from $userdetails->active to $active.");
      }

      //Force PW User
      $force_pr = Input::get("force_pr");
      if ($userdetails->force_pr != $force_pr){
        $fields=array('force_pr'=>$force_pr);
        $db->update('users',$userId,$fields);
        $successes[] = "Set force_pr to $force_pr.";
        logger($user->data()->id,"User Manager","Updated force_pr for $userdetails->fname from $userdetails->force_pr to $force_pr.");
      }

      //Update email
      $email = Input::get("email");
      if ($userdetails->email != $email){
        $fields=array('email'=>$email);
        $validation->check($_POST,array(
          'email' => array(
            'display' => 'Email',
            'required' => true,
            'valid_email' => true,
            'unique_update' => 'users,'.$userId,
            'min' => 3,
            'max' => 75
          )
        ));
        if($validation->passed()){
          $db->update('users',$userId,$fields);
          $successes[] = "Email Updated";
          logger($user->data()->id,"User Manager","Updated email for $userdetails->fname from $userdetails->email to $email.");
        }else{
          ?>
          <?php if(!$validation->errors()=='') {?><div class="alert alert-danger"><?=display_errors($validation->errors());?></div><?php } ?>
          <?php
        }

      }

      //Update validation
      if($act==1) {
        $email_verified = Input::get("email_verified");
        if (isset($email_verified) AND $email_verified == '1'){
          if ($userdetails->email_verified == 0){
            if (updateUser('email_verified', $userId, 1)){
              $successes[] = "Verification Updated";
              logger($user->data()->id,"User Manager","Updated email_verified for $userdetails->fname to $email_verified..");
            }else{
              $errors[] = lang("SQL_ERROR");
            }
          }
        }elseif ($userdetails->email_verified == 1){
          if (updateUser('email_verified', $userId, 0)){
            $successes[] = "Verification Updated";
            logger($user->data()->id,"User Manager","Updated email_verified for $userdetails->fname to $email_verified..");
          }else{
            $errors[] = lang("SQL_ERROR");
          }
        }
      }

      //Toggle protected setting
      if(in_array($user->data()->id,$master_account)) {
        $protected = Input::get("protected");
        if (isset($protected) AND $protected == '1'){
          if ($userdetails->protected == 0){
            if (updateUser('protected', $userId, 1)){
              $successes[] = lang("USER_PROTECTION", array("now"));
              logger($user->data()->id,"User Manager","Updated protection for $userdetails->fname from 0 to 1.");
            }else{
              $errors[] = lang("SQL_ERROR");
            }
          }
        }elseif ($userdetails->protected == 1){
          if (updateUser('protected', $userId, 0)){
            $successes[] = lang("USER_PROTECTION", array("no longer"));
            logger($user->data()->id,"User Manager","Updated protection for $userdetails->fname from 1 to 0.");
          }else{
            $errors[] = lang("SQL_ERROR");
          }
        }
      }

      //Toggle msg_exempt setting
      $msg_exempt = Input::get("msg_exempt");
      if (isset($msg_exempt) AND $msg_exempt == '1'){
        if ($userdetails->msg_exempt == 0){
          if (updateUser('msg_exempt', $userId, 1)){
            $successes[] = lang("USER_MESSAGE_EXEMPT", array("now"));
            logger($user->data()->id,"User Manager","Updated msg_exempt for $userdetails->fname from 0 to 1.");
          }else{
            $errors[] = lang("SQL_ERROR");
          }
        }
      }elseif ($userdetails->msg_exempt == 1){
        if (updateUser('msg_exempt', $userId, 0)){
          $successes[] = lang("USER_MESSAGE_EXEMPT", array("no longer"));
          logger($user->data()->id,"User Manager","Updated msg_exempt for $userdetails->fname from 1 to 0.");
        }else{
          $errors[] = lang("SQL_ERROR");
        }
      }

      //Toggle dev_user setting
      $dev_user = Input::get("dev_user");
      if (isset($dev_user) AND $dev_user == '1'){
        if ($userdetails->dev_user == 0){
          if (updateUser('dev_user', $userId, 1)){
            $successes[] = lang("USER_DEV_OPTION", array("now"));
            logger($user->data()->id,"User Manager","Updated dev_user for $userdetails->fname from 0 to 1.");
          }else{
            $errors[] = lang("SQL_ERROR");
          }
        }
      }elseif ($userdetails->dev_user == 1){
        if (updateUser('dev_user', $userId, 0)){
          $successes[] = lang("USER_DEV_OPTION", array("no longer"));
          logger($user->data()->id,"User Manager","Updated dev_user for $userdetails->fname from 1 to 0.");
        }else{
          $errors[] = lang("SQL_ERROR");
        }
      }

      //Two FA disabler
      $twofa = Input::get('twofa');
      if (isset($twofa) AND $twofa == '1' && $settings->twofa==1 && $userdetails->twoEnabled==1){
        $db->query("UPDATE users SET twoKey=null,twoEnabled=0 WHERE id = ?",[$userId]);
        logger($user->data()->id,"Two FA","Disabled Two FA for User ID $userId");
        $successes[] = "Disabled 2FA";
      }

      $cloak_allowed = Input::get("cloak_allowed");
      if ($userdetails->cloak_allowed != $cloak_allowed){
        $fields=array('cloak_allowed'=>$cloak_allowed);
        $db->update('users',$userId,$fields);
        $successes[] = "Set user cloaking to $cloak_allowed.";
        logger($user->data()->id,"User Manager","Updated cloak_allowed for $userdetails->fname from $userdetails->cloak_allowed to $cloak_allowed.");
      }

      //Remove permission level
      if(!empty($_POST['removePermission'])){
        $remove = Input::get('removePermission');
        if ($deletion_count = removePermission($remove, $userId)){
          $successes[] = lang("ACCOUNT_PERMISSION_REMOVED", array ($deletion_count));
          logger($user->data()->id,"User Manager","Deleted $deletion_count permission(s) from $userdetails->fname $userdetails->lname.");
        }
        else {
          $errors[] = lang("SQL_ERROR");
        }
      }

      if(!empty($_POST['addPermission'])){
        $add = Input::get('addPermission');
        if ($addition_count = addPermission($add, $userId,'user')){
          $successes[] = lang("ACCOUNT_PERMISSION_ADDED", array ($addition_count));
          logger($user->data()->id,"User Manager","Added $addition_count permission(s) to $userdetails->fname $userdetails->lname.");
        }
        else {
          $errors[] = lang("SQL_ERROR");
        }
      }

      if(!empty($_POST['resetPin']) && Input::get('resetPin')==1) {
        $user->update(['pin'=>NULL],$userId);
        logger($user->data()->id,"User Manager","Reset PIN for $userdetails->fname $userdetails->lname");
        $successes[]='Reset PIN';
        $successes[]='User can set a new PIN the next time they require verification';
      }

      if(file_exists($abs_us_root.$us_url_root.'usersc/includes/admin_user_system_settings_post.php')){
        require_once $abs_us_root.$us_url_root.'usersc/includes/admin_user_system_settings_post.php';
      }
    }
    $userdetails = fetchUserDetails(NULL, NULL, $userId);
  } }


  $userPermission = fetchUserPermissions($userId);
  // $currentuserPermission = fetchUserPermissions($user->data()->id);
  $permissionData = fetchAllPermissions();

  $grav = get_gravatar(strtolower(trim($userdetails->email)));
  $useravatar = '<img src="'.$grav.'" class="img-responsive img-thumbnail" alt="">';
  if((!in_array($user->data()->id, $master_account) && in_array($userId, $master_account) || !in_array($user->data()->id, $master_account) && $userdetails->protected==1) && $userId != $user->data()->id) $protectedprof = 1;
  else $protectedprof = 0;
  ?>

  <div class="content mt-3">
    <?=resultBlock($errors,$successes);?>
    <?php if(!$validation->errors()=='') {?><div class="alert alert-danger"><?=display_errors($validation->errors());?></div><?php } ?>
    <div class="row">
      <div class="col-sm-12 col-sm-2"><!--left col-->
        <?php echo $useravatar;?>
      </div><!--/col-2-->

      <div class="col-sm-12 col-sm-10">
        <form class="form" id='adminUser' name='adminUser' action='admin.php?view=user&id=<?=$userId?>' method='post'>

          <h3><?=$userdetails->fname?> <?=$userdetails->lname?> - <?=$userdetails->username?></h3>
          <div class="panel panel-default">
            <div class="panel-heading">User ID: <?=$userdetails->id?><?php if($act==1) {?> - <?php if($userdetails->email_verified==1) {?> Email Verified <input type="hidden" name="email_verified" value="1" /><?php } elseif($userdetails->email_verified==0) {?> Email Unverified - <label class="normal"><input type="checkbox" name="email_verified" value="1" /> Verify</label><?php } else {?>Error: No Validation<?php } } ?> <?php if($protectedprof==1) {?><p class="pull-right">PROTECTED PROFILE - EDIT DISABLED</p><?php } ?> <?php if(in_array($user->data()->id, $master_account)) {?><p class="pull-right"><label class="normal"><input type="checkbox" name="protected" value="1" <?php if($userdetails->protected==1){?>checked<?php } ?>/> Protected Account</label></p><?php } ?></div>
              <div class="panel-body">

                <label>Joined: </label> <?=$userdetails->join_date?><br/>

                <label>Last Login: </label> <?php if($userdetails->last_login != 0) { echo $userdetails->last_login; } else {?> <i>Never</i> <?php }?><br/>

                <label>Username:</label>
                <input  class='form-control' type='text' name='username' value='<?=$userdetails->username?>' autocomplete="off" />

                <label>Email:</label>
                <input class='form-control' type='text' name='email' value='<?=$userdetails->email?>' autocomplete="off" />

                <label>First Name:</label>
                <input  class='form-control' type='text' name='fname' value='<?=$userdetails->fname?>' autocomplete="off" />

                <label>Last Name:</label>
                <input  class='form-control' type='text' name='lname' value='<?=$userdetails->lname?>' autocomplete="off" />

              </div>
            </div>


            <div class="panel panel-default">
              <div class="panel-heading">Functions <?php if($protectedprof==1) {?><p class="pull-right">PROTECTED PROFILE - EDIT DISABLED</p><?php } ?></div>
              <div class="panel-body">
                <center>
                  <div class="btn-group"><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#password">Password/PIN Settings</button></div>
                  <?php if(file_exists($abs_us_root.$us_url_root.'usersc/includes/admin_user_system_settings.php')){?>
                    <div class="btn-group"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#systems">System Settings</button></div><?php } ?>
                    <div class="btn-group"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#permissions">Permission Settings</button></div>
                    <div class="btn-group"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#misc">Misc Settings</button></div>
                  </center>
                </div>
              </div>

              <div id="password" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Update Password</h4>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label>New Password (<?=$settings->min_pw?> char min, <?=$settings->max_pw?> max.)</label>
                        <input class='form-control' type='password' autocomplete="off" name='password' <?php if((!in_array($user->data()->id, $master_account) && in_array($userId, $master_account) || !in_array($user->data()->id, $master_account) && $userdetails->protected==1) && $userId != $user->data()->id) {?>disabled<?php } ?>/>
                      </div>

                      <div class="form-group">
                        <label>Confirm Password</label>
                        <input class='form-control' type='password' autocomplete="off" name='confirm' <?php if((!in_array($user->data()->id, $master_account) && in_array($userId, $master_account) || !in_array($user->data()->id, $master_account) && $userdetails->protected==1) && $userId != $user->data()->id) {?>disabled<?php } ?>/>
                      </div>

                      <label><input type="checkbox" name="sendPwReset" id="sendPwReset" /> Send Reset Email?</label><br>
                      <?php if(!is_null($userdetails->pin)) {?>
                        <div class="form-group">
                          <label><input  type="checkbox" id="resetPin" name="resetPin" value="1" /> Reset PIN</label>
                        </div>
                      <?php } ?>
                    </div>
                    <div class="modal-footer">
                      <div class="btn-group"><input class='btn btn-primary' type='submit' value='Update' class='submit' /></div>
                      <div class="btn-group"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                    </div>
                  </div>

                </div>
              </div>

              <div id="systems" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">System Settings</h4>
                    </div>
                    <div class="modal-body">
                      <?php if(file_exists($abs_us_root.$us_url_root.'usersc/includes/admin_user_system_settings.php')){
                        require_once $abs_us_root.$us_url_root.'usersc/includes/admin_user_system_settings.php';
                      } ?>
                    </div>
                    <div class="modal-footer">
                      <div class="btn-group"><input class='btn btn-primary' type='submit' value='Update' class='submit' /></div>
                      <div class="btn-group"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                    </div>
                  </div>

                </div>
              </div>

              <div id="permissions" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Permission Settings</h4>
                    </div>
                    <div class="modal-body">
                      <div class="panel panel-default">
                        <div class="panel-heading">Remove These Permission(s): <?php if($protectedprof==1) {?><p class="pull-right">PROTECTED PROFILE - EDIT DISABLED</p><?php } ?></div>
                        <div class="panel-body">
                          <?php
                          //NEW List of permission levels user is apart of

                          $perm_ids = [];
                          foreach($userPermission as $perm){
                            $perm_ids[] = $perm->permission_id;
                          }

                          foreach ($permissionData as $v1){
                            if(in_array($v1->id,$perm_ids)){ ?>
                              <label class="normal"><input type='checkbox' name='removePermission[]' id='removePermission[]' value='<?=$v1->id;?>' <?php if(!hasPerm([$v1->id],$user->data()->id) && $settings->permission_restriction==1){ ?>disabled<?php } ?> /> <?=$v1->name;?></label>
                              <?php
                            }
                          }
                          ?>

                        </div>
                      </div>

                      <div class="panel panel-default">
                        <div class="panel-heading">Add These Permission(s): <?php if($protectedprof==1) {?><p class="pull-right">PROTECTED PROFILE - EDIT DISABLED</p><?php } ?></div>
                        <div class="panel-body">
                          <?php
                          foreach ($permissionData as $v1){
                            if(!in_array($v1->id,$perm_ids)){ ?>
                              <label class="normal"><input type='checkbox' name='addPermission[]' id='addPermission[]' value='<?=$v1->id;?>' <?php if(!hasPerm([$v1->id],$user->data()->id) && $settings->permission_restriction==1){ ?>disabled<?php } ?>/> <?=$v1->name;?></label>
                              <?php
                            }
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <div class="btn-group"><input class='btn btn-primary' type='submit' value='Update' class='submit' /></div>
                      <div class="btn-group"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                    </div>
                  </div>

                </div>
              </div>

              <div id="misc" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Misc Settings</h4>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">

                        <?php if($settings->twofa==1 && $userdetails->twoEnabled==1) {?>
                          <label>Disable 2FA?
                            <input type="checkbox" name="twofa" value="1" /></label> <br />
                          <?php } ?>

                          <label>Exempt Messages<a class="nounderline" data-toggle="tooltip" title="This prevents a user from being able to receive group or individual messages"><font color="blue">?</font></a>
                            <input type="checkbox" name="msg_exempt" value="1" <?php if($userdetails->msg_exempt==1){?>checked<?php } ?>/></label> <br />

                            <label>Dev User<a class="nounderline" data-toggle="tooltip" title="This is just a flag that you can set for your own purposes.  It will be accessable from $user->data()->dev_user"><font color="blue">?</font></a>
                              <input type="checkbox" name="dev_user" value="1" <?php if($userdetails->dev_user==1){?>checked<?php } ?>/></label><br />

                              <label>Cloak into this user<a class="nounderline" data-toggle="tooltip" title="Automatically logs you in as this user"><font color="blue">?</font></a>
                                <?php
                                $rsn = '';
                                if(isset($_SESSION['cloak_to'])){
                                  $rsn = 'you are already cloaked';
                                }
                                if(in_array($userId,$master_account)){
                                  $rsn = 'cloaking into this user is disabled because they are a master account.';
                                }
                                if($userId==$user->data()->id){
                                  $rsn = 'cloaking into yourself will break the space-time continuum.';
                                }
                                if(in_array($user->data()->id,$master_account) && !in_array($userId,$master_account)){
                                  $rsn = '';
                                }
                                if($user->data()->cloak_allowed!=1){
                                  $rsn = 'your account has cloaking disabled. Enable it in User->Misc Settings->Is Aloowed To Cloak.';
                                }
                                ?>

                                <input type="checkbox" name="cloak" value="1" <?php if($rsn !=''){echo "disabled";}?>></label><br>
                                <?php if($rsn !=''){echo "<font color='blue'>Cloaking disabled because ".$rsn.'</font>';}?>

                                <br><br><label> Is allowed to cloak<a class="nounderline" data-toggle="tooltip" title="Warning: This is an extremely powerful permission and should not be given lightly!!!"><font color="blue">?</font></a></label>
                                <select name="cloak_allowed" class="form-control">
                                  <option value="1" <?php if ($userdetails->cloak_allowed==1){echo "selected='selected'";} else { if(!in_array($user->data()->id,$master_account)){  ?>disabled<?php }} ?>>Yes</option>
                                  <option value="0" <?php if ($userdetails->cloak_allowed==0){echo "selected='selected'";} else { if(!in_array($user->data()->id,$master_account)){  ?>disabled<?php }} ?>>No</option>
                                </select>

                                <label> Block<a class="nounderline" data-toggle="tooltip" title="Drop the banhammer on a troublemaker!"><font color="blue">?</font></a></label>
                                <select name="active" class="form-control">
                                  <option value="1" <?php if ($userdetails->permissions==1){echo "selected='selected'";} else { if(!checkMenu(2,$user->data()->id)){  ?>disabled<?php }} ?>>No</option>
                                  <option value="0" <?php if ($userdetails->permissions==0){echo "selected='selected'";} else { if(!checkMenu(2,$user->data()->id)){  ?>disabled<?php }} ?>>Yes</option>
                                </select>

                                <label> Force Password Reset<a class="nounderline" data-toggle="tooltip" title="The user will be required to create a new password on next login"><font color="blue">?</font></a></label>
                                <select name="force_pr" class="form-control">
                                  <option <?php if ($userdetails->force_pr==0){echo "selected='selected'";} ?> value="0">No</option>
                                  <option <?php if ($userdetails->force_pr==1){echo "selected='selected'";} ?>value="1">Yes</option>
                                </select>

                                <label>Delete this User<a class="nounderline" data-toggle="tooltip" title="Completely delete a user"><font color="blue">?</font></a>
                                  <input type='checkbox' name='delete[<?php echo "$userId"; ?>]' id='delete[<? echo "$userId"; ?>]' value='<?php echo "$userId"; ?>' <?php if (!checkMenu(2,$user->data()->id) || $userId == 1){  ?>disabled<?php } ?>></label>
                                </div>
                                <div class="modal-footer">
                                  <div class="btn-group"><input class='btn btn-primary' type='submit' value='Update' class='submit' /></div>
                                  <div class="btn-group"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>

                        <input type="hidden" name="csrf" value="<?=Token::generate();?>" />
                        <div class="pull-right">
                          <div class="btn-group"><input class='btn btn-primary' type='submit' value='Update' class='submit' /></div>
                          <div class="btn-group"><a class='btn btn-warning' href="<?=$us_url_root?>users/admin.php?view=users">Cancel</a></div><br /><Br />
                        </div>

                      </form>

                    </div><!--/col-9-->
                  </div><!--/row-->

                </div>

                <script src="js/jwerty.js"></script>
                <script>
                jwerty.key('esc', function () {
                  $('.modal').modal('hide');
                });
                </script>

                <?php if($protectedprof==1) {?>
                  <script>$('#adminUser').find('input:enabled, select:enabled, textarea:enabled').attr('disabled', 'disabled');</script>
                <?php } ?>
