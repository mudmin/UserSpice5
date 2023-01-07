<?php
$hooks = getMyHooks(['page' => 'admin.php?view=user']);
includeHook($hooks, 'pre');
$validation = new Validate();
//PHP Goes Here!
$email = $db->query('SELECT email_act FROM email')->first();
$act = $email->email_act;
$errors = [];
$successes = [];
$userId = (int) Input::get('id');

//Check if selected user exists
if (!userIdExists($userId)) {
  usError("That user does not exist");
  Redirect::to($us_url_root . 'users/admin.php?view=users');
  die();
}

$userdetails = fetchUserDetails(null, null, $userId); //Fetch user details

//Forms posted
if (!empty($_POST)) {

  $token = $_POST['csrf'];
  if (!Token::check($token)) {
    include $abs_us_root . $us_url_root . 'usersc/scripts/token_error.php';
  } else {
    includeHook($hooks, 'post');


    if (!empty($_POST['delete'])) {
      if ($userdetails->id == $user->data()->id || in_array($userdetails->id, $master_account)) {
        usError("You cannot delete this user");
        Redirect::to("admin.php?view=user&id=" . $userdetails->id);
      }
      if ($deletion_count = deleteUsers($userdetails->id)) {
        logger($user->data()->id, 'User Manager', "Deleted user named $userdetails->fname.");
        $msg = lang('ACCOUNT_DELETIONS_SUCCESSFUL', [$deletion_count]);
        usSuccess($msg);
        Redirect::to($us_url_root . 'users/admin.php?view=users');
      } else {
        usError(lang('SQL_ERROR'));
        Redirect::to("admin.php?view=user&id=" . $userdetails->id);
      }
    }

    if (!empty($_POST['blocking'])) {
      if ($userdetails->id == $user->data()->id || in_array($userdetails->id, $master_account)) {
        usError("You cannot adjust the active state of this user");
        Redirect::to("admin.php?view=user&id=" . $userdetails->id);
      }
      $active = Input::get('active');
      if ($active == 1 || $active == 0) {
        $db->update("users", $userdetails->id, ['active' => $active, 'permissions' => $active]);
        usSuccess("Active status changed");
      }
      Redirect::to("admin.php?view=user&id=" . $userdetails->id);
    }

    //Force PW User
    $force_pr = Input::get('force_pr');
    if ($force_pr == 1) {
      $fields = ['force_pr' => $force_pr];
      $db->update('users', $userId, $fields);
      $successes[] = "Forcing password reset on next login.";
      logger($user->data()->id, 'User Manager', "Updated force_pr for $userdetails->fname from $userdetails->force_pr to $force_pr.");
      Redirect::to("admin.php?view=user&id=" . $userdetails->id);
    }

    if (!empty($_POST['cloak'])) {
      if ($user->data()->cloak_allowed != 1 && !in_array($user->data()->id, $master_account) && !isset($_SESSION['cloak_to'])) {
        logger($user->data()->id, 'Cloaking', 'User attempted to cloak User ID #' . $userId);
        usError("You do not have permission to cloak");
        Redirect::to($us_url_root . 'users/admin.php?view=users');
      } else {
        if (in_array($userId, $master_account) && !in_array($user->data()->id, $master_account)) {
          logger($user->data()->id, 'Cloaking', "User attempted to cloak User ID #$userId who belongs to the Master Account Array.");
          usError("You cannot cloak into a master account");
          Redirect::to($us_url_root . 'users/admin.php?view=users');
        } elseif ($userId == $user->data()->id) {
          logger($user->data()->id, 'Cloaking', 'User attempted to cloak themself.');
          usError("Cloaking into yourself would open up a black hole");
          Redirect::to($us_url_root . 'users/admin.php?view=users');
        } else {
          $check = $db->query('SELECT id FROM users WHERE id = ?', [$userId]);
          $count = $check->count();
          if ($count < 1) {
            usError("You broke it! User not found");
            Redirect::to($us_url_root . 'users/admin.php?view=users');
          } else {
            $_SESSION['cloak_from'] = $user->data()->id;
            $_SESSION['cloak_to'] = $userId;
            logger($user->data()->id, 'Cloaking', 'Cloaked into ' . $userId);
            $cloakHook =  getMyHooks(['page' => 'cloakBegin']);
            includeHook($cloakHook, 'body');
            usSuccess("You are now cloaked!");
            Redirect::to('account.php');
          }
        }
      }
    }

    //Update display name
    $displayname = Input::get('unx');
    if ($userdetails->username != $displayname) {
      $fields = ['username' => $displayname];
      $validation->check($_POST, [
        'unx' => [
          'display' => 'Username',
          'required' => true,
          'unique_update' => 'users,' . $userId,
          'min' => $settings->min_un,
          'max' => $settings->max_un,
        ],
      ]);
      if ($validation->passed()) {
        $db->update('users', $userId, $fields);
        $successes[] = 'Username Updated';
        logger($user->data()->id, 'User Manager', "Updated username for $userdetails->fname from $userdetails->username to $displayname.");
      } else {
      }
    }

    //Update first name
    $fname = ucfirst(Input::get('fnx'));
    if ($userdetails->fname != $fname) {
      $fields = ['fname' => $fname];
      $validation->check($_POST, [
        'fnx' => [
          'display' => 'First Name',
          'required' => true,
          'min' => 1,
          'max' => 25,
        ],
      ]);
      if ($validation->passed()) {
        $db->update('users', $userId, $fields);
        $successes[] = 'First Name Updated';
        logger($user->data()->id, 'User Manager', "Updated first name for $userdetails->fname from $userdetails->fname to $fname.");
      } else {
?><?php if (!$validation->errors() == '') {
                        display_errors($validation->errors());
                      } ?>
<?php
      }
    }

    //Update last name
    $lname = ucfirst(Input::get('lnx'));
    if ($userdetails->lname != $lname) {
      $fields = ['lname' => $lname];
      $validation->check($_POST, [
        'lnx' => [
          'display' => 'Last Name',
          'required' => true,
          'min' => 1,
          'max' => 25,
        ],
      ]);
      if ($validation->passed()) {
        $db->update('users', $userId, $fields);
        $successes[] = 'Last Name Updated';
        logger($user->data()->id, 'User Manager', "Updated last name for $userdetails->fname from $userdetails->lname to $lname.");
      } else {
?>
  <?php if (!$validation->errors() == '') {
          display_errors($validation->errors());
        } ?>
<?php
      }
    }

    if (!empty($_POST['pwx'])) {
      $validation->check($_POST, [
        'pwx' => [
          'display' => 'New Password',
          'required' => true,
          'min' => $settings->min_pw,
          'max' => $settings->max_pw,
        ],
        'confirm' => [
          'display' => 'Confirm New Password',
          'required' => true,
          'matches' => 'confirm',
        ],
      ]);

      if (!$validation->errors()) {
        //process
        $new_password_hash = password_hash(Input::get('pwx', true), PASSWORD_BCRYPT, ['cost' => 12]);
        $user->update(['password' => $new_password_hash], $userId);
        $successes[] = 'Password updated.';
        logger($user->data()->id, 'User Manager', "Updated password for $userdetails->fname.");
        if ($settings->session_manager == 1) {
          if ($userId == $user->data()->id) {
            $passwordResetKillSessions = passwordResetKillSessions();
          } else {
            $passwordResetKillSessions = passwordResetKillSessions($userId);
          }
          if (is_numeric($passwordResetKillSessions)) {
            if ($passwordResetKillSessions == 1) {
              $successes[] = 'Successfully Killed 1 Session';
            }
            if ($passwordResetKillSessions > 1) {
              $successes[] = "Successfully Killed $passwordResetKillSessions Session";
            }
          } else {
            $errors[] = 'Failed to kill active sessions, Error: ' . $passwordResetKillSessions;
          }
        }
      } else {
        usError("Password validation failed");
        Redirect::to("admin.php?view=user&id=" . $userId);
      }
    }
    $vericode_expiry = date('Y-m-d H:i:s', strtotime("+$settings->reset_vericode_expiry minutes", strtotime(date('Y-m-d H:i:s'))));
    $vericode = randomstring(15);
    $db->update('users', $userdetails->id, ['vericode' => $vericode, 'vericode_expiry' => $vericode_expiry]);
    if (isset($_POST['sendPwReset'])) {
      $params = [
        'username' => $userdetails->username,
        'sitename' => $settings->site_name,
        'fname' => $userdetails->fname,
        'email' => rawurlencode($userdetails->email),
        'vericode' => $vericode,
        'reset_vericode_expiry' => $settings->reset_vericode_expiry,
      ];
      $to = rawurlencode($userdetails->email);
      $subject = lang('PW_RESET');
      $body = email_body('_email_adminPwReset.php', $params);
      email($to, $subject, $body);
      $successes[] = 'Password reset sent.';
      logger($user->data()->id, 'User Manager', "Sent password reset email to $userdetails->fname, Vericode expires at $vericode_expiry.");
    }

    //Update email
    $email = Input::get('emx');
    if ($userdetails->email != $email) {
      $fields = ['email' => $email];
      $validation->check($_POST, [
        'emx' => [
          'display' => 'Email',
          'required' => true,
          'valid_email' => true,
          'unique_update' => 'users,' . $userId,
          'min' => 3,
          'max' => 75,
        ],
      ]);
      if ($validation->passed()) {
        $db->update('users', $userId, $fields);
        $successes[] = 'Email Updated';
        logger($user->data()->id, 'User Manager', "Updated email for $userdetails->fname from $userdetails->email to $email.");
      } else {
?>
  <?php if (!$validation->errors() == '') {
          display_errors($validation->errors());
        } ?>
<?php
      }
    }

    //Update validation
    // if ($act == 1) {
    //     $email_verified = Input::get('email_verified');
    //     if (isset($email_verified) and $email_verified == '1') {
    //         if ($userdetails->email_verified == 0) {
    //             if (updateUser('email_verified', $userId, 1)) {
    //                 $successes[] = 'Verification Updated';
    //                 logger($user->data()->id, 'User Manager', "Updated email_verified for $userdetails->fname to $email_verified..");
    //             } else {
    //                 $errors[] = lang('SQL_ERROR');
    //             }
    //         }
    //     } elseif ($userdetails->email_verified == 1) {
    //         if (updateUser('email_verified', $userId, 0)) {
    //             $successes[] = 'Verification Updated';
    //             logger($user->data()->id, 'User Manager', "Updated email_verified for $userdetails->fname to $email_verified..");
    //         } else {
    //             $errors[] = lang('SQL_ERROR');
    //         }
    //     }
    // }

    //Toggle protected setting
    if (in_array($user->data()->id, $master_account)) {
      $protected = Input::get('protected');
      if (isset($protected) and $protected == '1') {
        if ($userdetails->protected == 0) {
          if (updateUser('protected', $userId, 1)) {
            $successes[] = lang('USER_PROTECTION', ['now']);
            logger($user->data()->id, 'User Manager', "Updated protection for $userdetails->fname from 0 to 1.");
          } else {
            $errors[] = lang('SQL_ERROR');
          }
        }
      } elseif ($userdetails->protected == 1) {
        if (updateUser('protected', $userId, 0)) {
          $successes[] = lang('USER_PROTECTION', ['no longer']);
          logger($user->data()->id, 'User Manager', "Updated protection for $userdetails->fname from 1 to 0.");
        } else {
          $errors[] = lang('SQL_ERROR');
        }
      }
    }

    //Toggle dev_user setting
    $dev_user = Input::get('dev_user');
    if (isset($dev_user) and $dev_user == '1') {
      if ($userdetails->dev_user == 0) {
        if (updateUser('dev_user', $userId, 1)) {
          $successes[] = lang('USER_DEV_OPTION', ['now']);
          logger($user->data()->id, 'User Manager', "Updated dev_user for $userdetails->fname from 0 to 1.");
        } else {
          $errors[] = lang('SQL_ERROR');
        }
      }
    } elseif ($userdetails->dev_user == 1) {
      if (updateUser('dev_user', $userId, 0)) {
        $successes[] = lang('USER_DEV_OPTION', ['no longer']);
        logger($user->data()->id, 'User Manager', "Updated dev_user for $userdetails->fname from 1 to 0.");
      } else {
        $errors[] = lang('SQL_ERROR');
      }
    }

    $cloak_allowed = Input::get('cloak_allowed');
    if ($userdetails->cloak_allowed != $cloak_allowed) {
      $fields = ['cloak_allowed' => $cloak_allowed];
      $db->update('users', $userId, $fields);
      $successes[] = "Set user cloaking to $cloak_allowed.";
      logger($user->data()->id, 'User Manager', "Updated cloak_allowed for $userdetails->fname from $userdetails->cloak_allowed to $cloak_allowed.");
    }

    //Remove permission level
    if (!empty($_POST['removePermission'])) {
      $remove = Input::get('removePermission');
      if ($deletion_count = removePermission($remove, $userId)) {
        $successes[] = lang('ACCOUNT_PERMISSION_REMOVED', [$deletion_count]);
        logger($user->data()->id, 'User Manager', "Deleted $deletion_count permission(s) from $userdetails->fname $userdetails->lname.");
      } else {
        $errors[] = lang('SQL_ERROR');
      }
    }

    if (!empty($_POST['addPermission'])) {
      $add = Input::get('addPermission');
      if ($addition_count = addPermission($add, $userId, 'user')) {
        $successes[] = lang('ACCOUNT_PERMISSION_ADDED', [$addition_count]);
        logger($user->data()->id, 'User Manager', "Added $addition_count permission(s) to $userdetails->fname $userdetails->lname.");
      } else {
        $errors[] = lang('SQL_ERROR');
      }
    }

    if (!empty($_POST['resetPin']) && Input::get('resetPin') == 1) {
      $user->update(['pin' => null], $userId);
      logger($user->data()->id, 'User Manager', "Reset PIN for $userdetails->fname $userdetails->lname");
      $successes[] = 'Reset PIN';
      $successes[] = 'User can set a new PIN the next time they require verification';
    }

    if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/admin_user_system_settings_post.php')) {
      require_once $abs_us_root . $us_url_root . 'usersc/includes/admin_user_system_settings_post.php';
    }

    $userdetails = fetchUserDetails(null, null, $userId);
  }

  if ($errors == [] && Input::get('return') != '') {
    usSuccess("Saved");
    Redirect::to('admin.php?view=users');
  } elseif ($errors == []) {
    usSuccess("Saved");
    Redirect::to('admin.php?view=user&id=' . $userId);
  }
}

$userPermission = fetchUserPermissions($userId);
// $currentuserPermission = fetchUserPermissions($user->data()->id);
$permissionData = fetchAllPermissions();

$grav = fetchProfilePicture($userId);
$useravatar = '<img src="' . $grav . '" class="img-responsive img-thumbnail" alt="">';
if ((!in_array($user->data()->id, $master_account) && in_array($userId, $master_account) || !in_array($user->data()->id, $master_account) && $userdetails->protected == 1) && $userId != $user->data()->id) {
  $protectedprof = 1;
} else {
  $protectedprof = 0;
}

$rsn = '';
if (isset($_SESSION['cloak_to'])) {
  $rsn = 'You are already cloaked';
}
if (in_array($userId, $master_account)) {
  $rsn = 'Cloaking into this user is disabled because they are a master account.';
}
if ($userId == $user->data()->id) {
  $rsn = 'Cloaking into yourself will break the space-time continuum.';
}
if (in_array($user->data()->id, $master_account) && !in_array($userId, $master_account)) {
  $rsn = '';
}
if ($user->data()->cloak_allowed != 1) {
  $cloakId = $user->data()->id;
  $rsn = "Your account has cloaking disabled. Enable it <a href='?admin.php&view=user&id=$cloakId'>here</a>";
}
?>

<?= resultBlock($errors, $successes); ?>
<?php if (!$validation->errors() == '') {
  display_errors($validation->errors());
} ?>
<?php includeHook($hooks, 'body'); ?>

<div class="row">
  <div class="col-2 col-sm-1">
    <?php echo $useravatar; ?>
  </div>
  <div class="col-4 col-sm-5">

    <h3>
      <span id="fname"><?= $userdetails->fname; ?></span>
      <span id="lname"><?= $userdetails->lname; ?></span>
      <span id="slash"> - </span>
      <span id="username"><?= $userdetails->username; ?></span>
    </h3>

    <p><label>User ID: <?= $userdetails->id; ?>
        <?php if ($act == 1) { ?>
          <?php if ($userdetails->email_verified == 1) { ?>
            (Email Verified)</label> <input type="hidden" name="email_verified" value="1" />

    <?php } elseif ($userdetails->email_verified == 0) { ?>
      (Email Unverified)</label>

      <!-- - <label class="normal"><br><input type="checkbox" name="email_verified" value="1" />
                Verify</label> -->

  <?php }
        }
  ?>
    </p>
    <p><label>Joined: </label> <?= $userdetails->join_date; ?></p>

    <p><label>Last Login: </label>
      <?php if ($userdetails->last_login != 0) {
        echo $userdetails->last_login;
      } else {
        echo "<i>Never</i>";
      }
      ?>
  </div>
  <div class="col-6">
    <div class="row">
      <div class="col-12 col-sm-6 col-md-3 mt-2">
        <form class="" action="" method="post" onsubmit="return confirm('Do you really want to do this? It cannot be undone.');">
          <?= tokenHere(); ?>
          <input type="submit" name="delete" id="delete" class="btn btn-danger col-12" value="Delete User">
        </form>
      </div>

      <div class="col-12 col-sm-6 col-md-3 mt-2">
        <?php if ($userdetails->permissions == 1) { ?>
          <form class="" action="" method="post" onsubmit="return confirm('Do you really want to do this? The user will immediately be blocked from the site.');">
            <?= tokenHere(); ?>
            <input type="hidden" name="active" value="0">
            <input type="submit" name="blocking" id="blocking" class="btn btn-warning col-12" value="Block User">
          </form>
        <?php } else { ?>
          <form class="" action="" method="post" onsubmit="return confirm('Do you really want to do this? The user will immediately have their access to the site restored.');">
            <?= tokenHere(); ?>
            <input type="hidden" name="active" value="1">
            <input type="submit" name="blocking" id="blocking" class="btn btn-warning col-12" value="Unblock User">
          </form>
        <?php } ?>
      </div>

      <div class="col-12 col-sm-6 col-md-3 mt-2">
        <?php
        if ($rsn != "") {
          $cloakClass = "btn-outline-secondary";
          $disabled = "disabled";
        } else {
          $cloakClass = "btn-primary";
          $disabled = "";
        }
        ?>
        <form class="" action="" method="post" onsubmit="return confirm('You are about to cloak into another user.  To return to your own account, visit the Account page and hit the uncloak button.');">
          <?= tokenHere(); ?>

          <input type="submit" name="cloak" id="cloak" class="btn <?= $cloakClass ?> col-12" value="Cloak Into User" <?= $disabled ?>>
        </form>
      </div>

      <div class="col-12 col-sm-6 col-md-3 mt-2">
        <form class="" action="" method="post" onsubmit="return confirm('If you continue, the user will be forced to change their password on the next login.');">
          <?= tokenHere(); ?>
          <input type="hidden" name="force_pr" value="1">
          <input type="submit" name="force_the_pr" id="force_the_pr" class="btn btn-secondary col-12" value="Force PW Reset">
        </form>
      </div>
      <div class="col-12">
        <?php if ($rsn != "") {
          echo "<p class='text-center mt-2'><em>" . $rsn . "</em></p>";
        } ?>
      </div>

    </div>
  </div>
</div>

<form class="form" id='adminUser' name='adminUser' action='' method='post'>
  <div class="row">
    <div class="col-12 col-sm-6">
      <div class="form-group" id="username-group">
        <label>Username:</label>
        <input class='form-control' type='search' name='unx' value='<?= $userdetails->username; ?>' autocomplete="off" />
      </div>

      <div class="form-group" id="email-group">
        <label>Email:</label>
        <input class='form-control' type='search' name='emx' value='<?= $userdetails->email; ?>' autocomplete="off" />
      </div>

      <div class="form-group" id="fname-group">
        <label>First Name:</label>
        <input class='form-control' type='search' name='fnx' value='<?= $userdetails->fname; ?>' autocomplete="off" />
      </div>

      <div class="form-group" id="lname-group">
        <label>Last Name:</label>
        <input class='form-control' type='search' name='lnx' value='<?= $userdetails->lname; ?>' autocomplete="off" />
      </div>

      <div class="form-group">
        <label><input type="checkbox" name="sendPwReset" id="sendPwReset" /> Send Reset Email? Will expire in <?= $settings->reset_vericode_expiry; ?> minutes.</label><br>
      </div>

      <?php includeHook($hooks, 'form'); ?>
      <div class="row">
        <div class="col-12 col-sm-6">
          <div class="panel-heading"><strong>Remove These Permission(s)</strong> <?php if ($protectedprof == 1) { ?><p class="pull-right">PROTECTED PROFILE - EDIT DISABLED</p><?php } ?></div>
          <div class="panel-body">
            <?php
            //NEW List of permission levels user is apart of

            $perm_ids = [];
            foreach ($userPermission as $perm) {
              $perm_ids[] = $perm->permission_id;
            }

            foreach ($permissionData as $v1) {
              if (in_array($v1->id, $perm_ids)) { ?>
                <label class="normal"><input type='checkbox' name='removePermission[]' id='removePermission[]' value='<?= $v1->id; ?>' <?php if (!hasPerm([$v1->id], $user->data()->id) && $settings->permission_restriction == 1) { ?>disabled<?php } ?> /> <?= $v1->name; ?></label><br>
            <?php
              }
            }
            ?>

          </div>
        </div>

        <div class="col-12 col-sm-6">
          <div class="panel-heading"><strong>Add These Permission(s)</strong> <?php if ($protectedprof == 1) { ?><p class="pull-right">PROTECTED PROFILE - EDIT DISABLED</p><?php } ?></div>
          <div class="panel-body">
            <?php
            foreach ($permissionData as $v1) {
              if (!in_array($v1->id, $perm_ids)) { ?>
                <label class="normal"><input type='checkbox' name='addPermission[]' value='<?= $v1->id; ?>' <?php if (!hasPerm([$v1->id], $user->data()->id) && $settings->permission_restriction == 1) { ?>disabled<?php } ?> /> <?= $v1->name; ?></label><br>
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
        <label>New Password (<?= $settings->min_pw; ?> char min, <?= $settings->max_pw; ?> max.)</label>
        <input class='form-control' type='password' autocomplete="off" name='pwx' <?php if ((!in_array($user->data()->id, $master_account) && in_array($userId, $master_account) || !in_array($user->data()->id, $master_account) && $userdetails->protected == 1) && $userId != $user->data()->id) { ?>disabled<?php } ?> />
      </div>

      <div class="form-group">
        <label>Confirm Password</label>
        <input class='form-control' type='password' autocomplete="off" name='confirm' <?php if ((!in_array($user->data()->id, $master_account) && in_array($userId, $master_account) || !in_array($user->data()->id, $master_account) && $userdetails->protected == 1) && $userId != $user->data()->id) { ?>disabled<?php } ?> />
      </div>

      <div class="form-group">
        <label> Is allowed to cloak<a class="nounderline" data-toggle="tooltip" title="Warning: This is an extremely powerful permission and should not be given lightly!!!"><i class="fa fa-question-circle offset-circle font-info"></i></a></label>
        <select name="cloak_allowed" class="form-control">
          <option value="1" <?php if ($userdetails->cloak_allowed == 1) {
                              echo "selected='selected'";
                            } else {
                              if (!in_array($user->data()->id, $master_account)) {  ?>disabled<?php }
                                                                                            } ?>>Yes</option>
          <option value="0" <?php if ($userdetails->cloak_allowed == 0) {
                              echo "selected='selected'";
                            } else {
                              if (!in_array($user->data()->id, $master_account)) {  ?>disabled<?php }
                                                                                            } ?>>No</option>
        </select>
      </div>

      <div class="form-group">
        <?php if (!is_null($userdetails->pin)) { ?>
          <label><input type="checkbox" id="resetPin" name="resetPin" value="1" /> Reset PIN</label>
        <?php } ?>
      </div>

      <div class="form-group">
        <label>Dev User<a class="nounderline" data-toggle="tooltip" title="This is just a flag that you can set for your own purposes.  It will be accessable from $user->data()->dev_user"><i class="fa fa-question-circle offset-circle font-info"></i></a></label>
        <select name="dev_user" class="form-control">
          <option <?php if ($userdetails->dev_user == 0) {
                    echo "selected='selected'";
                  } ?> value="0">No</option>
          <option <?php if ($userdetails->dev_user == 1) {
                    echo "selected='selected'";
                  } ?>value="1">Yes</option>
        </select>
      </div>


      <div class="form-group">
        <?php if ($protectedprof == 1) { ?><br>PROTECTED PROFILE - EDIT DISABLED<?php } ?>
          <?php if (in_array($user->data()->id, $master_account)) { ?>
            <label class="normal">Protected Account</label>
            <select name="protected" class="form-control">
              <option <?php if ($userdetails->protected == 0) {
                        echo "selected='selected'";
                      } ?> value="0">No</option>
              <option <?php if ($userdetails->protected == 1) {
                        echo "selected='selected'";
                      } ?>value="1">Yes</option>
            </select>
          <?php } ?>
      </div>

      <input type="hidden" name="csrf" value="<?= Token::generate(); ?>" />
      <div class="pull-right mt-3">
        <a class='btn btn-outline-danger' href="<?= $us_url_root; ?>users/admin.php?view=users">Cancel</a>
        <input class='btn btn-outline-secondary' name="return" type='submit' value='Update & Close' class='submit' />
        <input class='btn btn-outline-primary' type='submit' value='Update' class='submit' />
      </div>
    </div>
  </div>
</form>
<?php includeHook($hooks, 'bottom'); ?>



<?php if ($protectedprof == 1) { ?>
  <script>
    $('#adminUser').find('input:enabled, select:enabled, textarea:enabled').attr('disabled', 'disabled');
  </script>
<?php } ?>