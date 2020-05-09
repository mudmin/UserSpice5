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
<style media="screen">
  form label {font-weight:600}
</style>
<?php
$hooks = getMyHooks(['page' =>'admin.php?view=user']);
includeHook($hooks,'pre');
$validation = new Validate();
//PHP Goes Here!
$email = $db->query("SELECT email_act FROM email")->first();
$act = $email->email_act;
$errors = [];
$successes = [];
$userId = Input::get('id');

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
    includeHook($hooks,'post');
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
      $displayname = Input::get("unx");
      if ($userdetails->username != $displayname) {

        $fields=array('username'=>$displayname);
        $validation->check($_POST,array(
          'unx' => array(
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
      $fname = ucfirst(Input::get("fnx"));
      if ($userdetails->fname != $fname) {

        $fields=array('fname'=>$fname);
        $validation->check($_POST,array(
          'fnx' => array(
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
      $lname = ucfirst(Input::get("lnx"));
      if ($userdetails->lname != $lname){

        $fields=array('lname'=>$lname);
        $validation->check($_POST,array(
          'lnx' => array(
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

      if(!empty($_POST['pwx'])) {
        $validation->check($_POST,array(
          'pwx' => array(
            'display' => 'New Password',
            'required' => true,
            'min' => $settings->min_pw,
            'max' => $settings->max_pw,
          ),
          'confirm' => array(
            'display' => 'Confirm New Password',
            'required' => true,
            'matches' => 'pwx',
          ),
        ));

        if (empty($errors)) {
          //process
          $new_password_hash = password_hash(Input::get('pwx', true), PASSWORD_BCRYPT, array('cost' => 12));
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
          'vericode' => $vericode,
          'reset_vericode_expiry' => $settings->reset_vericode_expiry
        );
        $to = rawurlencode($userdetails->email);
        $subject = 'Password Reset';
        $body = email_body('_email_adminPwReset.php',$params);
        email($to,$subject,$body);
        $successes[] = "Password reset sent.";
        logger($user->data()->id,"User Manager","Sent password reset email to $userdetails->fname, Vericode expires at $vericode_expiry.");
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
      $email = Input::get("emx");
      if ($userdetails->email != $email){
        $fields=array('email'=>$email);
        $validation->check($_POST,array(
          'emx' => array(
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
  }

  if($errors == [] && Input::get("return") != ""){
    Redirect::to('admin.php?view=users&err=Saved');
  }elseif($errors == []){
    Redirect::to('admin.php?view=user&err=Saved&id='.$userId);
  }
}


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
    <?php includeHook($hooks,'body');?>
      <form class="form" id='adminUser' name='adminUser' action='admin.php?view=user&id=<?=$userId?>' method='post'>
        <div class="row">
          <div class="col-8">
            <h3><span id="fname"><?=$userdetails->fname?> </span><span id="lname"><?=$userdetails->lname?> </span><span id="slash">- </span><span id="username"><?=$userdetails->username?></span></h3>
            <label>User ID: </label> <?=$userdetails->id?><?php if($act==1) {?> <br>
              <?php if($userdetails->email_verified==1) {?> Email Verified <input type="hidden" name="email_verified" value="1" />
            <?php } elseif($userdetails->email_verified==0) {?> Email Unverified -
              <label class="normal"><br><input type="checkbox" name="email_verified" value="1" />
                Verify</label><?php } else {?>Error: No Validation<?php } } ?>

                  <br><label>Joined: </label> <?=$userdetails->join_date?>

                  <br><label>Last Login: </label> <?php if($userdetails->last_login != 0) { echo $userdetails->last_login; } else {?> <i>Never</i> <?php }?><br/>
                </div>
                <div class="col-4">

                  <?php echo $useravatar;?>
                </div>
              </div>


                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-group" id="username-group">
                        <label>Username:</label>
                        <input  class='form-control' type='text' name='unx' value='<?=$userdetails->username?>' autocomplete="new-password" />
                      </div>

                      <div class="form-group" id="email-group">
                        <label>Email:</label>
                        <input class='form-control' type='text' name='emx' value='<?=$userdetails->email?>' autocomplete="new-password" />
                      </div>

                      <div class="form-group" id="fname-group">
                        <label>First Name:</label>
                        <input  class='form-control' type='text' name='fnx' value='<?=$userdetails->fname?>' autocomplete="new-password" />
                      </div>

                      <div class="form-group" id="lname-group">
                        <label>Last Name:</label>
                        <input  class='form-control' type='text' name='lnx' value='<?=$userdetails->lname?>' autocomplete="new-password" />
                      </div>

                      <div class="form-group">
                        <label>New Password (<?=$settings->min_pw?> char min, <?=$settings->max_pw?> max.)</label>
                        <input class='form-control' type='password' autocomplete="new-password" name='pwx' <?php if((!in_array($user->data()->id, $master_account) && in_array($userId, $master_account) || !in_array($user->data()->id, $master_account) && $userdetails->protected==1) && $userId != $user->data()->id) {?>disabled<?php } ?>/>
                      </div>

                      <div class="form-group">
                        <label>Confirm Password</label>
                        <input class='form-control' type='password' autocomplete="new-password" name='confirm' <?php if((!in_array($user->data()->id, $master_account) && in_array($userId, $master_account) || !in_array($user->data()->id, $master_account) && $userdetails->protected==1) && $userId != $user->data()->id) {?>disabled<?php } ?>/>
                      </div>


                      <div class="form-group">
                        <label><input type="checkbox" name="sendPwReset" id="sendPwReset" /> Send Reset Email? Will expire in <?=$settings->reset_vericode_expiry?> minutes.</label><br>
                      </div>
                      <?php includeHook($hooks,'form');?>
                      <div class="row">
                        <div class="col-12 col-sm-6">
                          <div class="panel-heading"><strong>Remove These Permission(s)</strong> <?php if($protectedprof==1) {?><p class="pull-right">PROTECTED PROFILE - EDIT DISABLED</p><?php } ?></div>
                          <div class="panel-body">
                            <?php
                            //NEW List of permission levels user is apart of

                            $perm_ids = [];
                            foreach($userPermission as $perm){
                              $perm_ids[] = $perm->permission_id;
                            }

                            foreach ($permissionData as $v1){
                              if(in_array($v1->id,$perm_ids)){ ?>
                                <label class="normal"><input type='checkbox' name='removePermission[]' id='removePermission[]' value='<?=$v1->id;?>' <?php if(!hasPerm([$v1->id],$user->data()->id) && $settings->permission_restriction==1){ ?>disabled<?php } ?> /> <?=$v1->name;?></label><br>
                                <?php
                              }
                            }
                            ?>

                          </div>
                        </div>

                        <div class="col-12 col-sm-6">
                          <div class="panel-heading"><strong>Add These Permission(s)</strong> <?php if($protectedprof==1) {?><p class="pull-right">PROTECTED PROFILE - EDIT DISABLED</p><?php } ?></div>
                          <div class="panel-body">
                            <?php
                            foreach ($permissionData as $v1){
                              if(!in_array($v1->id,$perm_ids)){ ?>
                                <label class="normal"><input type='checkbox' name='addPermission[]' value='<?=$v1->id;?>' <?php if(!hasPerm([$v1->id],$user->data()->id) && $settings->permission_restriction==1){ ?>disabled<?php } ?>/> <?=$v1->name;?></label><br>
                                <?php
                              }
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label> Is allowed to cloak<a class="nounderline" data-toggle="tooltip" title="Warning: This is an extremely powerful permission and should not be given lightly!!!"><font color="blue">?</font></a></label>
                        <select name="cloak_allowed" class="form-control">
                          <option value="1" <?php if ($userdetails->cloak_allowed==1){echo "selected='selected'";} else { if(!in_array($user->data()->id,$master_account)){  ?>disabled<?php }} ?>>Yes</option>
                          <option value="0" <?php if ($userdetails->cloak_allowed==0){echo "selected='selected'";} else { if(!in_array($user->data()->id,$master_account)){  ?>disabled<?php }} ?>>No</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label> Block<a class="nounderline" data-toggle="tooltip" title="Drop the banhammer on a troublemaker!"><font color="blue">?</font></a></label>
                        <select name="active" class="form-control">
                          <option value="1" <?php if ($userdetails->permissions==1){echo "selected='selected'";} else { if(!checkMenu(2,$user->data()->id)){  ?>disabled<?php }} ?>>No</option>
                          <option value="0" <?php if ($userdetails->permissions==0){echo "selected='selected'";} else { if(!checkMenu(2,$user->data()->id)){  ?>disabled<?php }} ?>>Yes</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label> Force Password Reset<a class="nounderline" data-toggle="tooltip" title="The user will be required to create a new password on next login"><font color="blue">?</font></a></label>
                        <select name="force_pr" class="form-control">
                          <option <?php if ($userdetails->force_pr==0){echo "selected='selected'";} ?> value="0">No</option>
                          <option <?php if ($userdetails->force_pr==1){echo "selected='selected'";} ?>value="1">Yes</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <?php if(!is_null($userdetails->pin)) {?>
                          <label><input  type="checkbox" id="resetPin" name="resetPin" value="1" /> Reset PIN</label>
                        <?php } ?>
                      </div>

                      <div class="form-group">
                        <?php if($settings->twofa==1 && $userdetails->twoEnabled==1) {?>
                          <label>Disable 2FA?
                            <input type="checkbox" name="twofa" value="1" /></label> <br />
                          <?php } ?>
                        </div>

                        <div class="form-group">
                          <label>Dev User<a class="nounderline" data-toggle="tooltip" title="This is just a flag that you can set for your own purposes.  It will be accessable from $user->data()->dev_user"><font color="blue">?</font></a></label>
                          <select name="dev_user" class="form-control">
                            <option <?php if ($userdetails->dev_user==0){echo "selected='selected'";} ?> value="0">No</option>
                            <option <?php if ($userdetails->dev_user==1){echo "selected='selected'";} ?>value="1">Yes</option>
                          </select>
                        </div>

                        <div class="form-group">

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
                            $rsn = 'your account has cloaking disabled. Enable it in User->Misc Settings->Is Allowed To Cloak.';
                          }
                          ?>

                          <label>Cloak into this user<a class="nounderline" data-toggle="tooltip" title="Automatically logs you in as this user"><font color="blue">?</font></a>
                          </label>
                          <select name="cloak" class="form-control">
                            <option selected='selected' disabled>--Select--</option>
                            <option value="1" <?php if($rsn !=''){echo "disabled";}?>>Yes</option>
                          </select>
                          <?php if($rsn !=''){echo "<font color='blue'>Cloaking disabled because ".$rsn.'</font>';}?>
                        </div>
                        <div class="form-group">
                          <?php if($protectedprof==1) {?><br>PROTECTED PROFILE - EDIT DISABLED<?php } ?>
                          <?php if(in_array($user->data()->id, $master_account)) {?>
                            <label class="normal">Protected Account</label>
                            <select name="protected" class="form-control">
                              <option <?php if ($userdetails->protected==0){echo "selected='selected'";} ?> value="0">No</option>
                              <option <?php if ($userdetails->protected==1){echo "selected='selected'";} ?>value="1">Yes</option>
                            </select>
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label>Delete this User<a class="nounderline" data-toggle="tooltip" title="Completely delete a user. This cannot be undone."><font color="blue">?</font></a></label>
                          <select name='delete[<?php echo "$userId"; ?>]' id='delete[<? echo "$userId"; ?>]' class="form-control">
                            <option selected='selected' disabled>No</option>
                            <option value="<?=$userId?>"  <?php if (!checkMenu(2,$user->data()->id) && !in_array($user->data()->id,$master_account)){  echo "disabled";} ?>>Yes - Cannot be undone!</option>
                          </select>
                        </div>
                        <input type="hidden" name="csrf" value="<?=Token::generate();?>" />
                        <div class="pull-right">
                          <a class='btn btn-warning' href="<?=$us_url_root?>users/admin.php?view=users">Cancel</a>
                          <input class='btn btn-secondary' name = "return" type='submit' value='Update & Close' class='submit' />
                          <input class='btn btn-primary' type='submit' value='Update' class='submit' />
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
                <?php includeHook($hooks,'bottom');?>



          <?php if($protectedprof==1) {?>
            <script>$('#adminUser').find('input:enabled, select:enabled, textarea:enabled').attr('disabled', 'disabled');</script>
          <?php } ?>
