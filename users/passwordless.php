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
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if ($settings->email_login == 0) {
  usError(lang("EML_FEATURE_DISABLED"));
  Redirect::to($us_url_root . 'users/login.php');
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
if ($method == "enter_email") {
  if (!empty($_POST['email'])) {
    $email = Input::get('email');
    $searchQ = $db->query("SELECT * FROM users WHERE email = ?", array($email));
    $searchC = $searchQ->count();
    if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/passwordless_login_overrides.php')) {
      require_once $abs_us_root . $us_url_root . 'usersc/scripts/passwordless_login_overrides.php';
    }
    if ($searchC < 1) {
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
      ];
      $db->insert('us_email_logins', $fields);
      $options = [
        'fname' => $search->fname,
        'email' => rawurlencode($search->email),
        'vericode' => $vericode,
        'passwordless_expiry' => 15,
        'user_id' => $user_id,
        'url' => "users/verify.php?vericode=" . $vericode . "&user_id=" . $user_id,
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
        Redirect::to($us_url_root . 'users/passwordless.php?method=check_email&email=' . $encoded_email);
      } else {
        usError(lang("GENERIC_ERROR"));
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
                <label class="form-label" for="username"><?= lang("GEN_EMAIL") ?></label>
                <input type="email" id="email" name="email" class="form-control form-control-lg" required autocomplete="email" />

              </div>
              <input type="hidden" name="redirect" value="<?= Input::get('redirect') ?>" />
              <button class="submit form-control btn btn-primary rounded submit px-3" id="next_button" type="submit"><i class="fa fa-sign-in"></i> <?= lang("SIGNIN_BUTTONTEXT", ""); ?></button>
            </form>
            <?php

            ?>
          </div>




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


    });
  </script>
<?php
} //end if method == enter_email
if ($method == "check_email") {
  $email = rawurldecode(Input::get('email'));
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
          <span class="fw-bold"><?=lang("EML_VER");?></span>
        </div>
        <div class="card-body p-3">
          <h2 class="text-center">
            <?= $EML_PASSWORDLESS_SENT ?>
          </h2>
        </div>
      </div>

    </div>
  </div>
<?php }


require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>