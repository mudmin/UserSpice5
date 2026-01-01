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
$noMaintenanceRedirect = true;
require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if ($settings->email_login == 0) {
  usError(lang("EML_FEATURE_DISABLED"));
  Redirect::to($us_url_root . 'users/login.php');
}
if(!function_exists('passwordlessCharset')){
  function passwordlessCharset(){
    return 'abcdefghijklmnopqrstuvwxyz0123456789';
  }
}

if (!empty($_POST)) {
  //check token
  if (!Token::check(Input::get('csrf'))) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }
}
$method = Input::get('method');
if ($method == "") {
  $method = "enter_email";
}

// Handle code verification
if ($method == "verify_code") {
  $email = Input::get('email');
  $code = strtolower(Input::get('code'));
  $user_id = Input::get('user_id');

  // Check rate limit for login attempts
  if (!checkRateLimit('login_attempt', $user_id, $email)) {
    usError(getRateLimitErrorMessage('login_attempt'));
    Redirect::to($us_url_root . 'users/passwordless.php');
    exit;
  }

  if (!empty($code)) {
    $searchQ = $db->query("SELECT * FROM us_email_logins 
      WHERE user_id = ? AND expired = 0 
      ORDER BY id DESC LIMIT 1", [$user_id]);

    if ($searchQ->count() > 0) {
      $login = $searchQ->first();

      // Check if code has expired
      if (strtotime($login->expires) < time()) {
        $db->update('us_email_logins', $login->id, ['expired' => 1]);

        // Record failed login attempt (expired)
        handleAuthFailure('login_attempt', $user_id, $email, [], [
          'method' => 'passwordless_code',
          'failure_reason' => 'expired_code',
          'user_agent' => Server::get('HTTP_USER_AGENT')
        ]);

        usError("Verification code has expired. Please request a new one.");
        Redirect::to($us_url_root . 'users/passwordless.php');
      }

      // Check number of invalid attempts
      $invalid_attempts = $login->invalid_attempts ?? 0;
      if ($invalid_attempts >= 3) {
        $db->update('us_email_logins', $login->id, ['expired' => 1]);

        // Record failed login attempt (too many attempts)
        handleAuthFailure('login_attempt', $user_id, $email, [], [
          'method' => 'passwordless_code',
          'failure_reason' => 'too_many_invalid_attempts',
          'invalid_attempts' => $invalid_attempts,
          'user_agent' => Server::get('HTTP_USER_AGENT')
        ]);

        usError("Too many invalid attempts. Please request a new code.");
        Redirect::to($us_url_root . 'users/passwordless.php');
      }

      // Verify the code
      if ($code === $login->verification_code) {
        // Record successful login
        handleAuthSuccess('login_attempt', $user_id, $email, [], [
          'method' => 'passwordless_code',
          'user_agent' => Server::get('HTTP_USER_AGENT')
        ]);

        $user = new User($user_id);
        $user->login();
        $db->update('us_email_logins', $login->id, ['expired' => 1]);
        if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php')) {
          require_once $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
        }
        $dest = sanitizedDest('dest');
        if (!empty($dest)) {
          $redirect = Input::get('redirect');
          if (!empty($redirect)) Redirect::to(html_entity_decode($redirect));
          else Redirect::to($dest);
        } else {
          Redirect::to($us_url_root . $settings->redirect_uri_after_login);
        }
      } else {
        $invalid_attempts++;
        $db->update('us_email_logins', $login->id, ['invalid_attempts' => $invalid_attempts]);

        // Record failed login attempt (invalid code)
        handleAuthFailure('login_attempt', $user_id, $email, [], [
          'method' => 'passwordless_code',
          'failure_reason' => 'invalid_code',
          'invalid_attempts' => $invalid_attempts,
          'user_agent' => Server::get('HTTP_USER_AGENT')
        ]);

        usError("Invalid code. Attempts remaining: " . (3 - $invalid_attempts));
        Redirect::to($us_url_root . 'users/passwordless.php?method=check_email&email=' . urlencode($email) . '&user_id=' . $user_id);
      }
    } else {
      // Record failed login attempt (no valid login record found)
      handleAuthFailure('login_attempt', $user_id, $email, [], [
        'method' => 'passwordless_code',
        'failure_reason' => 'no_login_record',
        'user_agent' => Server::get('HTTP_USER_AGENT')
      ]);
    }
  }
}

if ($method == "enter_email") {
  if (!empty($_POST['email'])) {
    $email = Input::get('email');

    // Check rate limit for password reset requests (using email as identifier)
    if (!checkRateLimit('password_reset_request', null, $email)) {
      usError(getRateLimitErrorMessage('password_reset_request'));
      Redirect::to($us_url_root . 'users/passwordless.php');
      exit;
    }

    $searchQ = $db->query("SELECT * FROM users WHERE email = ?", array($email));
    $searchC = $searchQ->count();
    if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/passwordless_login_overrides.php')) {
      require_once $abs_us_root . $us_url_root . 'usersc/scripts/passwordless_login_overrides.php';
    }
    if ($searchC < 1) {
      // Record failed passwordless request (user not found)
      handleAuthFailure('password_reset_request', null, $email, [], [
        'method' => 'passwordless_request',
        'failure_reason' => 'user_not_found',
        'email_attempted' => $email,
        'user_agent' => Server::get('HTTP_USER_AGENT')
      ]);

      if (isset($showEmailNotFound) && $showEmailNotFound == true) {
        usError(lang("ERR_EM_DB"));
        Redirect::to($us_url_root . 'users/passwordless.php');
      }
      sleep(1);
    } else {
      $search = $searchQ->first();
      $user_id = $search->id;
      $vericode = uniqid() . randomstring(15);
      $check = $db->query("UPDATE us_email_logins set expired = 1 WHERE user_id = ?", array($user_id));

      $fields = [
        'user_id' => $user_id,
        'vericode' => $vericode,
        'expires' => date('Y-m-d H:i:s', strtotime('+15 minutes')),
        'invalid_attempts' => 0
      ];

      // Generate verification code for modes 2 and 3
      if ($settings->email_login == 2 || $settings->email_login == 3) {
        $verification_code = substr(str_shuffle(passwordlessCharset()), 0, $settings->pwl_length);
        $fields['verification_code'] = $verification_code;
      }

      $db->insert('us_email_logins', $fields);

      $options = [
        'fname' => $search->fname,
        'email' => rawurlencode($search->email),
        'vericode' => $vericode,
        'passwordless_expiry' => 15,
        'user_id' => $user_id,
        'url' => "users/verify.php?vericode=" . $vericode . "&user_id=" . $user_id,
        'verification_code' => $verification_code ?? null
      ];

      $encoded_email = rawurlencode($email);
      if (lang("EML_PASSWORDLESS_SUBJECT") != "{ Missing Text }") {
        $subject = lang("EML_PASSWORDLESS_SUBJECT");
      } else {
        $subject = "Please verify your email to login.";
      }
      if ($settings->site_name != "UserSpice") {
        $subject = $settings->site_name . ": " . $subject;
      }
      $subject = html_entity_decode($subject, ENT_QUOTES);

      $subject .= " @ " . date("Y-m-d H:i:s");
      $body = email_body('_email_template_passwordless.php', $options);
      $email_sent = email($email, $subject, $body);

      if ($email_sent) {
        // Record successful passwordless request
        handleAuthSuccess('password_reset_request', $user_id, $email, [], [
          'method' => 'passwordless_request',
          'email_sent' => true,
          'user_agent' => Server::get('HTTP_USER_AGENT')
        ]);

        Redirect::to($us_url_root . 'users/passwordless.php?method=check_email&email=' . $encoded_email . '&user_id=' . $user_id);
      } else {
        // Record failed passwordless request (email send failed)
        handleAuthFailure('password_reset_request', $user_id, $email, [], [
          'method' => 'passwordless_request',
          'failure_reason' => 'email_send_failed',
          'user_agent' => Server::get('HTTP_USER_AGENT')
        ]);

        usError(lang("PASS_GENERIC_ERROR"));
      }
    }
  }
?>
  <div class="container p-2 h-100 alternate-background">
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <b><?= lang("SIGNIN_TITLE", ""); ?></b>
            <a href="<?= $us_url_root ?>" aria-label="Close" class="close btn-close" style="top: 1rem!important;"></a>
          </div>
          <div class="modal-body p-4 py-5 p-md-5">
            <form name="login" id="login-form" class="form-signin" action="" method="post">
              <input type="hidden" name="method" value="enter_email">
              <?= tokenHere(); ?>
              <div class="form-outline mb-4">
                <label class="form-label" for="email"><?= lang("GEN_EMAIL") ?></label>
                <input type="email" id="email" name="email" class="form-control form-control-lg" required autocomplete="email" />
              </div>
              <input type="hidden" name="redirect" value="<?= Input::get('redirect') ?>" />
              <button class="submit col-12 btn btn-primary rounded submit px-3" id="next_button" type="submit">
                <i class="fa fa-sign-in"></i> <?= lang("SIGNIN_BUTTONTEXT", ""); ?>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
    $(document).ready(function() {
      $("#loginModal").modal({
        backdrop: 'static',
        keyboard: false
      })
      $("#loginModal").modal('show');
      setTimeout(function() {
        $('#email').focus();
      }, 500);
    });
  </script>
<?php
} //end if method == enter_email

if ($method == "check_email") {
  $email = rawurldecode(Input::get('email'));
  $user_id = Input::get('user_id');
  if (array_key_exists("EML_PASSWORDLESS_SENT", $lang)) {
    $EML_PASSWORDLESS_SENT = lang("EML_PASSWORDLESS_SENT");
  } else {
    $EML_PASSWORDLESS_SENT = "Please check your email for a link to login.";
  }
?>
  <div class="row">
    <div class="col-12 col-sm-8 offeset-sm-1 col-md-6 offset-md-3 mt-4">
      <div class="card">
        <div class="card-header">
          <span class="fw-bold"><?= lang("EML_VER"); ?></span>
        </div>
        <div class="card-body p-3">
          <h2 class="text-center">
            <?= $EML_PASSWORDLESS_SENT ?>
          </h2>

          <?php if ($settings->email_login == 2 || $settings->email_login == 3) { ?>
            <div class="mt-4">
              <form action="" method="post" class="text-center">
                <input type="hidden" name="method" value="verify_code">
                <input type="hidden" name="email" value="<?= sanitize($email) ?>">
                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                <?= tokenHere() ?>
                <div class="form-group">
                  <label for="code" class="h5"><?= lang("PASS_ENTER_CODE"); ?></label>
                  <input type="text" id="code" name="code" class="form-control form-control-lg mx-auto" pattern="[a-z0-9]{5,<?= $settings->pwl_length ?>}" maxlength="<?= $settings->pwl_length ?>" required style="width: <?= ($settings->pwl_length * 2) - 1 ?>ch;">
                </div>
                <button type="submit" class="btn btn-primary btn-lg mt-3"><?= lang("PASS_VER_BUTTON"); ?></button>
              </form>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php
}

require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
?>