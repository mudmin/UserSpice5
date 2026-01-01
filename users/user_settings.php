<?php
// This is a user-facing page
/*
UserSpice
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

if (!securePage(Server::get('PHP_SELF'))) {
  die();
}
$hooks = getMyHooks();
includeHook($hooks, 'pre');

$emailQ = $db->query('SELECT * FROM email');
$emailR = $emailQ->first();
$pw_settings = $db->query("SELECT * FROM us_password_strength")->first();
if ($pw_settings->meter_active == 1) {
  $secondCol = "col-md-9";
} else {
  $secondCol = "col-md-12";
}

//PHP Goes Here!
$errors = [];
$successes = [];
$userId = $user->data()->id;
$grav = fetchProfilePicture($userId);
$validation = new Validate();
$userdetails = $user->data();

$allowPasswords = passwordsAllowed($settings->no_passwords);
//Temporary Success Message
$holdover = Input::get('success');
if ($holdover == 'true') {
  $successes[] = 'Account Updated';
}
if (!empty($_POST)) {
  $token = $_POST['csrf'];
  if (!Token::check($token)) {
    include $abs_us_root . $us_url_root . 'usersc/scripts/token_error.php';
  } else {
    includeHook($hooks, 'post');
    if (!empty($_POST['uncloak'])) {
      logger($user->data()->id, 'Cloaking', 'Attempting Uncloak');
      if (isset($_SESSION['cloak_to'])) {
        $to = $_SESSION['cloak_to'];
        $from = $_SESSION['cloak_from'];
        unset($_SESSION['cloak_to']);
        $_SESSION[Config::get('session/session_name')] = $_SESSION['cloak_from'];
        unset($_SESSION['cloak_from']);
        logger($from, 'Cloaking', 'uncloaked from ' . $to);
        $cloakHook =  getMyHooks(['page' => 'cloakEnd']);
        includeHook($cloakHook, 'body');
        usSuccess("You are now you");
        Redirect::to($us_url_root . 'users/admin.php?view=users');
      } else {
        usError("Something went wrong. Please login again");
        Redirect::to($us_url_root . 'users/logout.php');
      }
    }
    //if you make it this far, we're going to mark your account as modified.  This will allow other plugins to work.  And it's not that serious.
    $db->update('users', $user->data()->id, ['modified' => date("Y-m-d")]);
    $displayname = Input::get('username');
    if ($userdetails->username != $displayname && ($settings->change_un == 1 || (($settings->change_un == 2) && ($user->data()->un_changed == 0)))) {
      $fields = [
        'username' => $displayname,
        'un_changed' => 1,
      ];
      $validation->check($_POST, [
        'username' => [
          'display' => lang('GEN_UNAME'),
          'required' => true,
          'unique_update' => 'users,' . $userId,
          'min' => $settings->min_un,
          'max' => $settings->max_un,
        ],
      ]);
      if ($validation->passed()) {
        if (($settings->change_un == 2) && ($user->data()->un_changed == 1)) {
          $msg = lang("REDIR_UN_ONCE");
          usError($msg);
          Redirect::to($us_url_root . 'users/user_settings.php');
        }
        $db->update('users', $userId, $fields);
        $successes[] = lang('GEN_UNAME') . ' ' . lang('GEN_UPDATED');
        logger($user->data()->id, 'User', "Changed username from $userdetails->username to $displayname.");
      } else {
        //validation did not pass
        foreach ($validation->errors() as $error) {
          $errors[] = $error;
        }
      }
    }
    //Update first name
    $fname = ucfirst(Input::get('fname'));
    if ($userdetails->fname != $fname) {
      $fields = ['fname' => $fname];
      $validation->check($_POST, [
        'fname' => [
          'display' => lang('GEN_FNAME'),
          'required' => true,
          'min' => 1,
          'max' => 60,
        ],
      ]);
      if ($validation->passed()) {
        $db->update('users', $userId, $fields);
        $successes[] = lang('GEN_FNAME') . ' ' . lang('GEN_UPDATED');
        logger($user->data()->id, 'User', "Changed fname from $userdetails->fname to $fname.");
      } else {
        //validation did not pass
        foreach ($validation->errors() as $error) {
          $errors[] = $error;
        }
      }
    }
    //Update last name
    $lname = ucfirst(Input::get('lname'));
    if ($userdetails->lname != $lname) {
      $fields = ['lname' => $lname];
      $validation->check($_POST, [
        'lname' => [
          'display' => lang('GEN_LNAME'),
          'required' => true,
          'min' => 1,
          'max' => 60,
        ],
      ]);
      if ($validation->passed()) {
        $db->update('users', $userId, $fields);
        $successes[] = lang('GEN_LNAME') . ' ' . lang('GEN_UPDATED');
        logger($user->data()->id, 'User', "Changed lname from $userdetails->lname to $lname.");
      } else {
        //validation did not pass
        foreach ($validation->errors() as $error) {
          $errors[] = $error;
        }
      }
    }
    if (!empty($_POST['password']) || $userdetails->email != $_POST['email'] || !empty($_POST['resetPin'])) {
      //Check password for email or pw update

      //Update email
      $email = Input::get('email');
      if ($userdetails->email != $email) {

        $fields = ['email' => $email];
        $validation->check($_POST, [
          'email' => [
            'display' => lang('GEN_EMAIL'),
            'required' => true,
            'valid_email' => true,
            'unique_update' => 'users,' . $userId,
            'min' => 5,
            'max' => 200,
          ],
        ]);
        if ($validation->passed()) {
          if ($emailR->email_act == 0) {
            $db->update('users', $userId, $fields);
            $successes[] = lang('GEN_EMAIL') . ' ' . lang('GEN_UPDATED');
            logger($user->data()->id, 'User', "Changed email from $userdetails->email to $email.");
          }
          if ($emailR->email_act == 1 || !$allowPasswords) {
            $vericode = uniqid() . randomstring(15);
            $vericode_expiry = date('Y-m-d H:i:s', strtotime("+$settings->join_vericode_expiry hours", strtotime(date('Y-m-d H:i:s'))));
            $db->update('users', $userId, ['email_new' => $email, 'vericode' => $vericode, 'vericode_expiry' => $vericode_expiry]);
            //Send the email
            $options = [
              'fname' => $user->data()->fname,
              'email' => rawurlencode($user->data()->email),
              'vericode' => $vericode,
              'join_vericode_expiry' => $settings->join_vericode_expiry,
            ];
            $encoded_email = rawurlencode($email);
            $subject = lang('EML_VER');
            $body = email_body('_email_template_verify_new.php', $options);
            $email_sent = email($email, $subject, $body);
            if (!$email_sent) {
              $errors[] = lang('ERR_EMAIL');
            } else {
              $successes[] = lang('EML_CHK') . ' ' . $settings->join_vericode_expiry . ' ' . lang('T_HOURS');
            }
            if ($emailR->email_act == 1) {
              logger($user->data()->id, 'User', "Requested change email from $userdetails->email to $email. Verification email sent.");
            }
          } else {
            //validation did not pass
            foreach ($validation->errors() as $error) {
              $errors[] = $error;
            }
          }
        }
      }

      if ($allowPasswords && !empty($_POST['password'])) {
        $validation->check($_POST, [
          'password' => [
            'display' => lang('PW_NEW'),
            'required' => true,
            'min' => $settings->min_pw,
            'max' => $settings->max_pw,
          ],
          'confirm' => [
            'display' => lang('PW_CONF'),
            'required' => true,
            'matches' => 'password',
          ],
        ]);
        if ($pw_settings->meter_active == 1 && $pw_settings->enforce_rules == 1) {
          $doubleCheckPassword = userSpicePasswordStrength(Input::get('password'));
          if ($doubleCheckPassword['isValid'] == false) {
            //inject error before processing
            $validation->addError([lang("JOIN_INVALID_PW"), 'password']);
          }
        }
        foreach ($validation->errors() as $error) {
          $errors[] = $error;
        }

        if (empty($errors)) {
          //process

          $new_password_hash = password_hash(Input::get('password'), PASSWORD_BCRYPT, ['cost' => 13]);
          $user->update(['password' => $new_password_hash, 'force_pr' => 0, 'vericode' => randomstring(15)], $user->data()->id);
          $successes[] = lang('PW_UPD');
          logger($user->data()->id, 'User', 'Updated password.');
          if ($settings->session_manager == 1) {
            $passwordResetKillSessions = passwordResetKillSessions();
            if (is_numeric($passwordResetKillSessions)) {
              if ($passwordResetKillSessions == 1) {
                $successes[] = lang('SESS_SUC') . ' 1 ' . lang('GEN_SESSION');
              }
              if ($passwordResetKillSessions > 1) {
                $successes[] = lang('SESS_SUC') . $passwordResetKillSessions . lang('GEN_SESSIONS');
              }
            } else {
              $errors[] = lang('ERR_FAIL_ACT') . $passwordResetKillSessions;
            }
          }
        }
      }
      if (!empty($_POST['resetPin']) && Input::get('resetPin') == 1) {
        $user->update(['pin' => null]);
        logger($user->data()->id, 'User', 'Reset PIN');
        $successes[] = lang('SET_PIN');
        $successes[] = lang('SET_PIN_NEXT');
      }
    }
  }

  sessionValMessages($errors, $successes);
  Redirect::to("user_settings.php");
}

?>
<div class="container my-5">
  <div class="row">
    <aside class="col-sm-12 col-md-2">
      <p><img src="<?= $grav; ?>" class="img-thumbnail profile-replacer" alt="Generic placeholder thumbnail"></p>
    </aside>
    <main class="col-sm-12 col-md-10">
      <h1><?= lang('SET_UPDATE'); ?></h1>
      <?php
      if (!pluginActive('profile_pic', true)) {
        echo "<div class='alert alert-info gravitar-message p-3 mt-3 mb-4'>" . lang('SET_GRAVITAR') . "</div>";
      }
      if ($errors) {
        display_errors($errors);
      }
      if ($successes) {
        display_successes($successes);
      }
      includeHook($hooks, 'body');
      if (isset($_SESSION['cloak_to'])) { ?>
        <p>
        <form action="" method="post">
          <input type="hidden" name="uncloak" value="Uncloak!">
          <button class="btn btn-danger btn-block" type="submit">Uncloak</button>
        </form>
        </p>
      <?php } // End cloak button 
      ?>
      <div class="border bg-light p-4 alternate-background">
        <form name="updateAccount" action="" method="post">
          <!-- Username -->
          <?php
          $readonly_username = ($settings->change_un == 0 || ($settings->change_un == 2 && $userdetails->un_changed == 1));
          $input_class = $readonly_username ? "form-control-plaintext" : "form-control";
          ?>
          <div class="row mb-3" id="username-group">
            <label for="username" class="col-form-label col-12 col-md-3text-end"><?= lang('GEN_UNAME'); ?></label>
            <div class="col-12 <?= $secondCol ?>">
              <input class="<?= $input_class; ?>" type="text" id="username" name="username" value="<?= $userdetails->username; ?>" autocomplete="off" <?= $readonly_username ? 'readonly' : ''; ?>>
              <?php if ($readonly_username) { ?>
                <sup>
                  <span class="input-group-addon" data-toggle="tooltip" title="<?= lang($settings->change_un == 0 ? 'SET_NOCHANGE' : 'SET_ONECHANGE'); ?>"><?= lang('SET_WHY'); ?></span>
                </sup>
              <?php } ?>
            </div>
          </div>
          <!-- First Name -->
          <div class="row mb-3" id="fname-group">
            <label for="fname" class="col-form-label col-12 col-md-3text-end"><?= lang('GEN_FNAME'); ?></label>
            <div class="col-12 <?= $secondCol ?>">
              <input class="form-control" type="text" id="fname" name="fname" value="<?= $userdetails->fname; ?>" autocomplete="off" />
            </div>
          </div>
          <div class="row mb-3" id="lname-group">
            <label for="lname" class="col-form-label col-12 col-md-3text-end"><?= lang('GEN_LNAME'); ?></label>
            <div class="col-12 <?= $secondCol ?>">
              <input class="form-control" type="text" id="lname" name="lname" value="<?= $userdetails->lname; ?>" autocomplete="off" />
            </div>
          </div>

          <!-- Email -->
          <div class="row mb-3" id="email-group">
            <label for="email" class="col-form-label col-12 col-md-3text-end"><?= lang('GEN_EMAIL'); ?></label>
            <div class="col-12 <?= $secondCol ?>">
              <input class="form-control" type="email" id="email" name="email" value="<?= $userdetails->email; ?>" autocomplete="off" />
            </div>
          </div>


          <?php if ($allowPasswords) { ?>
            <div class="row mb-3" id="password-group">
              <label for="password" class="col-form-label col-12 col-md-3text-end"><?= lang('PW_NEW'); ?></label>
              <div class="col-12 <?= $secondCol ?>">
                <div class="input-group">
                  <span class="btn btn-secondary input-group-addon password_view_control"><span class="fa fa-eye"></span></span>
                  <input class="form-control" type="password" name="password" id="password" aria-describedby="passwordhelp" autocomplete="off">
                </div>

                <label for="confirm" class="col-form-label col-12 col-md-3text-end"><?= lang('PW_CONF'); ?></label>

                <div class="input-group">
                  <span class="btn btn-secondary input-group-addon password_view_control"><span class="fa fa-eye"></span></span>
                  <input type="password" id="confirm" name="confirm" class="form-control" autocomplete="new-password">
                  <span class="btn btn-secondary input-group-addon" data-toggle="tooltip" title="<?= lang('SET_PW_MATCH'); ?>">?</span>
                </div>
              </div>
              <?php if ($pw_settings->meter_active == 1) { ?>
                <div class="col-md-3">
                  <?php
                  if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/password_meter.php')) {
                    include($abs_us_root . $us_url_root . 'usersc/includes/password_meter.php');
                  } else {
                    include($abs_us_root . $us_url_root . 'users/includes/password_meter.php');
                  }
                  ?>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
          <?php includeHook($hooks, 'form'); ?>
          <input type="hidden" name="csrf" value="<?= Token::generate(); ?>" />
          <div class="row my-4">
            <div class="col-6 text-end">
              <input class="btn btn-primary" type="submit" value="<?= lang('GEN_UPDATE'); ?>" />
            </div>
            <div class="col-6 text-start">
              <a class="btn btn-secondary" href="<?= $us_url_root ?>users/account.php"><?= lang('GEN_CANCEL'); ?></a>
            </div>
          </div>
        </form>
      </div> <!-- End of form "well" -->
      <?php
      if (isset($user->data()->oauth_provider) && $user->data()->oauth_provider != null) {
        echo lang('ERR_GOOG');
      }
      includeHook($hooks, 'bottom');
      ?>
    </main>
  </div>
</div>

<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
  $(document).ready(function() {
    // $('body').removeClass('is-collapsed');
    // $('.meetingPag').DataTable({searching: false, paging: false, info: false});

    <?php if ($allowPasswords) { ?>
      $('.password_view_control').hover(function() {
        $('#password').attr('type', 'text');
        $('#confirm').attr('type', 'text');
      }, function() {
        $('#password').attr('type', 'password');
        $('#confirm').attr('type', 'password');
      });
    <?php } ?>

    $('[data-toggle="popover"], .pwpopover').popover();
    $('.pwpopover').on('click', function(e) {
      $('.pwpopover').not(this).popover('hide');
    });
    $('.modal').on('hidden.bs.modal', function() {
      $('.pwpopover').popover('hide');
    });
  });
</script>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>