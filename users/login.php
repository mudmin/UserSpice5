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
ini_set("allow_url_fopen", 1);
require_once '../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
$hooks =  getMyHooks();
includeHook($hooks,'pre');
?>
<?php

$errors = $successes = [];
if (Input::get('err') != '') {
    $errors[] = Input::get('err');
}

if ($user->isLoggedIn()) {
    Redirect::to($us_url_root.$settings->redirect_uri_after_login);
}

if (!empty($_POST['login_hook'])) {
  $token = Input::get('csrf');
  if(!Token::check($token)){
    include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
  }

      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        'username' => array('display' => lang('GEN_UNAME'),'required' => true),
        'password' => array('display' => lang('GEN_PASS'), 'required' => true))
      );
      $validated = $validation->passed();
      // Set $validated to False to kill validation, or run additional checks, in your post hook
      $username = Input::get('username');
      $password = trim(Input::get('password'));
      $remember = false;
      includeHook($hooks,'post');

      if ($validated) {
        //Log user in
        $user = new User();
        $login = $user->loginEmail($username, $password, $remember);
        if ($login) {
          $hooks =  getMyHooks(['page'=>'loginSuccess']);
          includeHook($hooks,'body');
          $dest = sanitizedDest('dest');
              # if user was attempting to get to a page before login, go there
              $_SESSION['last_confirm']=date("Y-m-d H:i:s");

              if (!empty($dest)) {
                $redirect=Input::get('redirect');
                if(!empty($redirect) || $redirect!=='') Redirect::to($redirect);
                else Redirect::to($dest);
              } elseif (file_exists($abs_us_root.$us_url_root.'usersc/scripts/custom_login_script.php')) {

                # if site has custom login script, use it
                # Note that the custom_login_script.php normally contains a Redirect::to() call
                require_once $abs_us_root.$us_url_root.'usersc/scripts/custom_login_script.php';
              } else {
                if (($dest = Config::get('homepage')) ||
                ($dest = 'account.php')) {
                  Redirect::to($dest);
                }
              }

          } else {
            $eventhooks =  getMyHooks(['page'=>'loginFail']);
            includeHook($eventhooks,'body');
            logger("0","Login Fail","A failed login on login.php");
            $msg = lang("SIGNIN_FAIL");
            $msg2 = lang("SIGNIN_PLEASE_CHK");
            $errors[] = '<strong>'.$msg.'</strong>'.$msg2;
          }
        }else{
          $errors = $validation->errors();
        }
        sessionValMessages($errors, $successes, NULL);

    }
    if (empty($dest = sanitizedDest('dest'))) {
      $dest = '';
    }
    $token = Token::generate();
    ?>
    <div id="page-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <?php
            includeHook($hooks,'body');
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <form name="login" id="login-form" class="form-signin" action="" method="post">
              <h2 class="form-signin-heading"><?=lang("SIGNIN_TITLE","");?></h2>
              <input type="hidden" name="dest" value="<?= $dest ?>" />

              <div class="form-group">
                <label for="username" id="username-label" ><?=lang("SIGNIN_UORE")?></label>
                <input  class="form-control" type="text" name="username" id="username" placeholder="<?=lang("SIGNIN_UORE")?>" required autofocus autocomplete="username">
              </div>

              <div class="form-group">
                <label for="password" id="password-label"><?=lang("SIGNIN_PASS")?></label>
                <input type="password" class="form-control"  name="password" id="password"  placeholder="<?=lang("SIGNIN_PASS")?>" required autocomplete="current-password">
              </div>
              <?php   includeHook($hooks,'form');?>
                <input type="hidden" name="login_hook" value="1">
                <input type="hidden" name="csrf" value="<?=$token?>">
                <input type="hidden" name="redirect" value="<?=Input::get('redirect')?>" />
                <button class="submit  btn  btn-primary" id="next_button" type="submit"><i class="fa fa-sign-in"></i> <?=lang("SIGNIN_BUTTONTEXT","");?></button>

              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6"><br>
              <a class="float-left"href='../users/forgot_password.php'><i class="fa fa-wrench"></i> <?=lang("SIGNIN_FORGOTPASS","");?></a>
              <br><br>
            </div>
            <?php if($settings->registration==1) {?>
              <div class="col-sm-6"><br>
                <a class="float-right" href='../users/join.php'><i class="fa fa-plus-square"></i> <?=lang("SIGNUP_TEXT","");?></a><br><br>
              </div><?php } ?>
              <?php   includeHook($hooks,'bottom');?>
                <?php languageSwitcher();?>
            </div>
          </div>
        </div>

        <?php require_once $abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/container_close.php'; //custom template container ?>

        <!-- footers -->
        <?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

        <!-- Place any per-page javascript here -->

        <?php require_once $abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/footer.php'; //custom template footer?>
