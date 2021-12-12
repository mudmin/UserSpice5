<?php
// This is a user-facing page
/*
UserSpice 5
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
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

if (!securePage($_SERVER['PHP_SELF'])) {
    die();
}
$hooks = getMyHooks();
includeHook($hooks, 'pre');

$emailQ = $db->query('SELECT * FROM email');
$emailR = $emailQ->first();

//PHP Goes Here!
$errors = [];
$successes = [];
$userId = $user->data()->id;
$grav = fetchProfilePicture($userId);
$validation = new Validate();
$userdetails = $user->data();
//Temporary Success Message
$holdover = Input::get('success');
if ($holdover == 'true') {
    $successes[] = 'Account Updated';
}
if (!empty($_POST)) {
    $token = $_POST['csrf'];
    if (!Token::check($token)) {
        include $abs_us_root.$us_url_root.'usersc/scripts/token_error.php';
    } else {
        includeHook($hooks, 'post');
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
          'unique_update' => 'users,'.$userId,
          'min' => $settings->min_un,
          'max' => $settings->max_un,
        ],
      ]);
            if ($validation->passed()) {
                if (($settings->change_un == 2) && ($user->data()->un_changed == 1)) {
                    $msg = str_replace("+"," ",lang("REDIR_UN_ONCE"));
                    usError($msg);
                    Redirect::to($us_url_root.'users/user_settings.php');
                }
                $db->update('users', $userId, $fields);
                $successes[] = lang('GEN_UNAME').' '.lang('GEN_UPDATED');
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
                $successes[] = lang('GEN_FNAME').' '.lang('GEN_UPDATED');
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
                $successes[] = lang('GEN_LNAME').' '.lang('GEN_UPDATED');
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
            if (is_null($userdetails->password) || password_verify(Input::get('old'), $user->data()->password)) {
                //Update email
                $email = Input::get('email');
                if ($userdetails->email != $email) {
                    $confemail = Input::get('confemail');
                    $fields = ['email' => $email];
                    $validation->check($_POST, [
            'email' => [
              'display' => lang('GEN_EMAIL'),
              'required' => true,
              'valid_email' => true,
              'unique_update' => 'users,'.$userId,
              'min' => 5,
              'max' => 100,
            ],
          ]);
                    if ($validation->passed()) {
                        if ($confemail == $email) {
                            if ($emailR->email_act == 0) {
                                $db->update('users', $userId, $fields);
                                $successes[] = lang('GEN_EMAIL').' '.lang('GEN_UPDATED');
                                logger($user->data()->id, 'User', "Changed email from $userdetails->email to $email.");
                            }
                            if ($emailR->email_act == 1) {
                                $vericode = randomstring(15);
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
                                    $successes[] = lang('EML_CHK').' '.$settings->join_vericode_expiry.' '.lang('T_HOURS');
                                }
                                if ($emailR->email_act == 1) {
                                    logger($user->data()->id, 'User', "Requested change email from $userdetails->email to $email. Verification email sent.");
                                }
                            }
                        } else {
                            $errors[] = lang('EML_MAT');
                        }
                    } else {
                        //validation did not pass
                        foreach ($validation->errors() as $error) {
                            $errors[] = $error;
                        }
                    }
                }
                if (!empty($_POST['password'])) {
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
                    foreach ($validation->errors() as $error) {
                        $errors[] = $error;
                    }
                    if (empty($errors) && Input::get('old') != Input::get('password')) {
                        //process
                        $new_password_hash = password_hash(Input::get('password'), PASSWORD_BCRYPT, ['cost' => 12]);
                        $user->update(['password' => $new_password_hash, 'force_pr' => 0, 'vericode' => randomstring(15)], $user->data()->id);
                        $successes[] = lang('PW_UPD');
                        logger($user->data()->id, 'User', 'Updated password.');
                        if ($settings->session_manager == 1) {
                            $passwordResetKillSessions = passwordResetKillSessions();
                            if (is_numeric($passwordResetKillSessions)) {
                                if ($passwordResetKillSessions == 1) {
                                    $successes[] = lang('SESS_SUC').' 1 '.lang('GEN_SESSION');
                                }
                                if ($passwordResetKillSessions > 1) {
                                    $successes[] = lang('SESS_SUC').$passwordResetKillSessions.lang('GEN_SESSIONS');
                                }
                            } else {
                                $errors[] = lang('ERR_FAIL_ACT').$passwordResetKillSessions;
                            }
                        }
                    } else {
                        if (Input::get('old') == Input::get('password')) {
                            $errors[] = lang('ERR_PW_SAME');
                        }
                    }
                }
                if (!empty($_POST['resetPin']) && Input::get('resetPin') == 1) {
                    $user->update(['pin' => null]);
                    logger($user->data()->id, 'User', 'Reset PIN');
                    $successes[] = lang('SET_PIN');
                    $successes[] = lang('SET_PIN_NEXT');
                }
            } else {
                $errors[] = lang('ERR_PW_FAIL');
            }
        }
    }

    sessionValMessages($successes,$errors);
    Redirect::to("user_settings.php");
}
?>
<div id="page-wrapper">
  <div class="container">
    <div class="well">
      <div class="row">
        <div class="col-sm-12 col-md-2">
          <p><img src="<?=$grav; ?>" class="img-thumbnail" alt="Generic placeholder thumbnail"></p>
        </div>
        <div class="col-sm-12 col-md-10">
          <h1><?=lang('SET_UPDATE'); ?></h1>
          <?php if (!pluginActive('profile_pic', true)) {
    echo lang('SET_GRAVITAR');
}?><br>
          <?php if (!$errors == '') { display_errors($errors); } ?>
          <?php if (!$successes == '') { display_successes($successes); }
          includeHook($hooks, 'body');
          ?>

          <form name='updateAccount' action='' method='post'>

            <div class="form-group" id="username-group">
              <label id="username-label"><?=lang('GEN_UNAME'); ?></label>
              <input  class='form-control' type='text' id="username" name='username' value='<?=$userdetails->username; ?>' autocomplete="off" <?php if (($settings->change_un == 0) || (($settings->change_un == 2) && ($userdetails->un_changed == 1))) {?>readonly<?php } ?>>
              <?php if (($settings->change_un == 0) || (($settings->change_un == 2) && ($userdetails->un_changed == 1))) {?>
                <sup>
                  <span class="input-group-addon" data-toggle="tooltip" title="<?php if ($settings->change_un == 0) {?><?=lang('SET_NOCHANGE'); ?><?php } if (($settings->change_un == 2) && ($userdetails->un_changed == 1)) {?><?=lang('SET_ONECHANGE'); ?><?php } ?>"><?=lang('SET_WHY'); ?></span>
                </sup>
              <?php } ?>
            </div>

            <div class="form-group" id="fname-group">
              <label id="fname-label"><?=lang('GEN_FNAME'); ?></label>
              <input  class='form-control' type='text' id='fname' name='fname' value='<?=$userdetails->fname; ?>' autocomplete="off" />
            </div>

            <div class="form-group" id="lname-group">
              <label id="lname-label"><?=lang('GEN_LNAME'); ?></label>
              <input  class='form-control' type='text' id="lname-label" name='lname' value='<?=$userdetails->lname; ?>' autocomplete="off" />
            </div>

            <div class="form-group" id="email-group">
              <label id="email-label"><?=lang('GEN_EMAIL'); ?></label>
              <input class='form-control' type='text' id="email" name='email' value='<?=$userdetails->email; ?>' autocomplete="off" />
              <?php if (!is_null($userdetails->email_new)) {?><br /><div class="alert alert-danger">
                <?=lang('SET_NOTE1'); ?> <?=$userdetails->email_new; ?> <?=lang('SET_NOTE2'); ?>
              </div><?php } ?>
            </div>

            <div class="form-group" id="confemail-group">
              <label id="confemail-label"><?=lang('EML_CONF'); ?></label>
              <input class='form-control' type='text' id="confemail" name='confemail' autocomplete="off" />
            </div>

            <div class="form-group" id="password-group">
              <label id="password-label"><?=lang('PW_NEW'); ?> (<?=lang('GEN_MIN'); ?> <?=$settings->min_pw; ?> <?=lang('GEN_AND'); ?> <?=lang('GEN_MAX'); ?> <?=$settings->max_pw; ?> <?=lang('GEN_CHAR'); ?>)</label>
              <div class="input-group" data-container="body">
                <span class="btn btn-secondary input-group-addon password_view_control" id="addon1"><span class="fa fa-eye"></span></span>
                <input  class="form-control" type="password"  name="password" id="password" aria-describedby="passwordhelp" autocomplete="off">
                <span class="btn btn-secondary input-group-addon" id="addon2" data-container="body" data-toggle="tooltip" data-placement="top" title="<?=$settings->min_pw; ?> <?=lang('GEN_CHAR'); ?> <?=lang('GEN_MIN'); ?>, <?=$settings->max_pw; ?> <?=lang('GEN_MAX'); ?>.">?</span>
              </div></div>

              <div class="form-group" id="confirm-group">
                <label id="confirm-label"><?=lang('PW_CONF'); ?></label>
                <div class="input-group" data-container="body">
                  <span class="btn btn-secondary input-group-addon password_view_control" id="addon3"><span class="fa fa-eye"></span></span>
                  <input  type="password" autocomplete="off" id="confirm" name="confirm" class="form-control" autocomplete="off">
                  <span class="btn btn-secondary input-group-addon" id="addon4" data-container="body" data-toggle="tooltip" data-placement="top" title="<?=lang('SET_PW_MATCH'); ?>">?</span>
                </div></div>

                <?php if (!is_null($userdetails->pin)) {?>
                  <div class="form-group" id="resetpin-group">
                    <label id="resetpin-label"><?=lang('SET_PIN'); ?>
                      <input  type="checkbox" id="resetPin" name="resetPin" value="1" /></label>
                    </div>
                  <?php } ?>

                  <div class="form-group" id="old-group">
                    <label id="old-label"><?=lang('PW_OLD'); ?><?php if (!is_null($userdetails->password)) {?>, <?=lang('SET_PW_REQ'); ?><?php } ?></label>
                    <div class="input-group" data-container="body">
                      <span class="btn btn-secondary input-group-addon password_view_control" id="addon6"><span class="fa fa-eye"></span></span>
                      <input class='form-control' type='password' id="old" name='old' <?php if (is_null($userdetails->password)) {?>disabled<?php } ?> autocomplete="off" />
                      <span class="btn btn-secondary input-group-addon" id="addon5" data-container="body" data-toggle="tooltip" data-placement="top" title="<?=lang('SET_PW_REQI'); ?>">?</span>
                    </div>
                  </div>
                  <?php includeHook($hooks, 'form'); ?>
                  <input type="hidden" name="csrf" value="<?=Token::generate(); ?>" />
                  <div class="row">
                    <div class="col-6 text-left">
                      <a class="btn btn-secondary" href="../users/account.php"><?=lang('GEN_CANCEL'); ?></a>
                    </div>
                    <div class="col-6 text-right">
                      <input class='btn btn-primary' type='submit' value='<?=lang('GEN_UPDATE'); ?>' class='submit' />
                    </div>
                  </div>

                </form>
                <?php
                if (isset($user->data()->oauth_provider) && $user->data()->oauth_provider != null) {
                    echo lang('ERR_GOOG');
                }
                includeHook($hooks, 'bottom');
                ?>

              </div>
            </div>
          </div>


        </div> <!-- /container -->

      </div> <!-- /#page-wrapper -->


      <?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
