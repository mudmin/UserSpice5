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
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';


$hooks =  getMyHooks();
includeHook($hooks, 'pre');
$emailSet = $db->query("SELECT * FROM email")->first();
if (!isset($settings->no_passwords)) {
  $settings->no_passwords = 0;
}
if ($emailSet->email_login == "yourEmail@gmail.com" || $emailSet->email_login == "" || $emailSet->email_pass == "1234" || $settings->no_passwords == 1) {
  $showForgot = false;
} else {
  $showForgot = true;
}

if ($settings->no_passwords == 1) {
  $topPad = "";
} else {
  // $topPad = " py-2 p-md-5";
  $topPad = "";
}
if ($showForgot == true && $settings->registration == 1) {
  $bottomClass = "col-12 col-lg-6";
  $showBottom = true;
  $forgotClass = "";
  $regClass = "text-end";
} elseif ($showForgot == true || $settings->registration == 1) {
  $showBottom = true;
  $bottomClass = "col-12";
  $forgotClass = "text-center";
  $regClass = "text-end";
} else {
  $showBottom = false;
}

$errors = $successes = [];
if (Input::get('err') != '') {
  $errors[] = Input::get('err');
}

if ($user->isLoggedIn()) {
  Redirect::to($us_url_root . $settings->redirect_uri_after_login);
}

if (!empty($_POST)) {
  $token = Input::get('csrf');
  if (!Token::check($token)) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }

  $validate = new Validate();
  $validation = $validate->check(
    $_POST,
    array(
      'username' => array('display' => lang('GEN_UNAME'), 'required' => true),
      'password' => array('display' => lang('GEN_PASS'), 'required' => true)
    )
  );
  $validated = $validation->passed();
  // Set $validated to False to kill validation, or run additional checks, in your post hook
  $username = Input::get('username');
  $password = trim(Input::get('password'));
  $remember = false;
  includeHook($hooks, 'post');

  if ($validated) {
    //Log user in
    $user = new User();
    $rawpassword = $_POST['password'];
    $login = $user->loginEmail($username, $password, $remember, $rawpassword);
    if ($login) {
      $hooks =  getMyHooks(['page' => 'loginSuccess']);
      includeHook($hooks, 'body');
      $dest = sanitizedDest('dest');
      # if user was attempting to get to a page before login, go there
      $_SESSION['last_confirm'] = date("Y-m-d H:i:s");

      if (!empty($dest)) {
        $redirect = Input::get('redirect');
        if (!empty($redirect) || $redirect !== '') Redirect::to(html_entity_decode($redirect));
        else Redirect::to($dest);
      } elseif (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php')) {

        # if site has custom login script, use it
        # Note that the custom_login_script.php normally contains a Redirect::to() call
        require_once $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
      } else {
        if (($dest = Config::get('homepage')) ||
          ($dest = 'account.php')
        ) {
          Redirect::to($dest);
        }
      }
    } else {
      $eventhooks =  getMyHooks(['page' => 'loginFail']);
      includeHook($eventhooks, 'body');
      logger("0", "Login Fail", "A failed login on login.php");
      $msg = lang("SIGNIN_FAIL");
      $msg2 = lang("SIGNIN_PLEASE_CHK");
      $errors[] = '<strong>' . $msg . '</strong>' . $msg2;
    }
  } else {
    $errors = $validation->errors();
  }
  sessionValMessages($errors, $successes, NULL);
}
if (empty($dest = sanitizedDest('dest'))) {
  $dest = '';
}
?>
<style media="screen">
  .img-responsive {
    width: 100% !important;
  }
</style>

<div class="container p-2 h-100 alternate-background">

  <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <b><?= lang("SIGNIN_TITLE", ""); ?></b>
          <a href="<?= $us_url_root ?>" aria-label="Close" class="close btn-close" style="top: 1rem!important;"></a>

        </div>
        <div class="modal-body p-4 <?= $topPad ?>">

          <div class="usmsgblock">
            <?php
            $usmsgs = array(
              'err',    //url err= messages
              'msg',    //urk msg= messages
              'valSuc', //Validation class success messages
              'valErr', //Validation class error messages
              'genMsg', //misc messages
            );
            foreach ($usmsgs as $u) { ?>
              <div style="" id="<?= $u ?>UserSpiceMessages" class="show d-none">
                <span id="<?= $u ?>UserSpiceMessage"></span>
                <button type="button" class="close btn-close" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php } ?>
          </div>
          <?php
          includeHook($hooks, 'body');
          if ($settings->no_passwords == 0) {

          ?>
            <form name="login" id="login-form" class="form-signin" method="post">
              <?= tokenHere(); ?>
              <div class="form-outline mb-4">
                <label class="form-label" for="username"><?= lang("SIGNIN_UORE") ?></label>
                <input type="text" id="username" name="username" class="form-control form-control-lg" 
                value=""
                required autocomplete="username">

              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="password"><?= lang("SIGNIN_PASS") ?></label>
                <div class="input-group">
                  <input type="password" id="password" name="password" class="form-control form-control-lg" 
                  value=""
                  >
                  <span class="input-group-addon input-group-text see-pw" id="togglePassword">
                    <i class="fa fa-eye" id="togglePasswordIcon"></i>
                  </span>
                </div>


              </div>

              <?php includeHook($hooks, 'form'); ?>
              <input type="hidden" name="redirect" value="<?= Input::get('redirect') ?>" />
              <button class="submit form-control btn btn-primary rounded submit px-3" id="next_button" type="submit"><i class="fa fa-sign-in"></i> <?= lang("SIGNIN_BUTTONTEXT", ""); ?></button>
            </form>
          <?php } //end no password logins 
          ?>



          <?php
          if (file_exists($abs_us_root . $us_url_root . "usersc/views/_social_logins.php")) {
            require_once $abs_us_root . $us_url_root . "usersc/views/_social_logins.php";
          } else {
            require_once $abs_us_root . $us_url_root . "users/views/_social_logins.php";
          }
          includeHook($hooks, 'bottom');

          if ($showBottom) { ?>
            <div class="row p-3">
              <?php if ($showForgot) { ?>
                <div class="<?= $bottomClass ?> <?= $forgotClass ?>">
                  <a class="" href='<?= $us_url_root ?>users/forgot_password.php' style="text-decoration:none;"><i class="fa fa-wrench"></i> <?= lang("SIGNIN_FORGOTPASS", ""); ?></a>
                </div>
              <?php }

              if ($settings->registration == 1) { ?>
                <div class="<?= $bottomClass ?> <?= $regClass ?>">
                  <a class="" href='<?= $us_url_root ?>users/join.php' style="text-decoration:none;"><i class="fa fa-plus-square"></i> <?= lang("SIGNUP_TEXT", ""); ?></a>
                </div>
              <?php }
              ?>

            </div>

          <?php } //end showBottom 
          ?>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#loginModal").modal({
      backdrop: 'static',
      keyboard: false
    })
    $("#loginModal").modal('show');
    setTimeout(function() {
      $('#username').focus();
    }, 500);

    <?php if ($settings->no_passwords == 0) { ?>
      const togglePassword = document.querySelector('#togglePassword');
      const togglePasswordIcon = document.querySelector('#togglePasswordIcon');
      const password = document.querySelector('#password');

      togglePassword.addEventListener('click', function(e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon

        if (type == "password") {
          togglePasswordIcon.classList.add('fa-eye');
          togglePasswordIcon.classList.remove('fa-eye-slash');
        } else {
          togglePasswordIcon.classList.add('fa-eye-slash');
          togglePasswordIcon.classList.remove('fa-eye');
        }

      });
    <?php } ?>
  });
</script>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>