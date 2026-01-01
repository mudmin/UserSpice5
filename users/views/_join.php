<?php
/*
This is a user-facing page
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

Special thanks to John Bovey for the basis of the password strength feature.
*/

?>

<div class="container">
  <div class="row justify-content-md-center alternate-background">
    <main class="col-12 col-md-10 col-lg-8">
      <?php
      includeHook($hooks, 'body');
      ?>

      <h1 class="form-signin-heading mt-4 mb-3 alternate-background"> <?= lang("SIGNUP_TEXT", ""); ?></h1>

      <?php if (isset($settings->social_login_location) && $settings->social_login_location == 0): ?>
        <?php
        if (file_exists($abs_us_root . $us_url_root . "usersc/views/_social_logins.php")) {
          require_once $abs_us_root . $us_url_root . "usersc/views/_social_logins.php";
        } else {
          require_once $abs_us_root . $us_url_root . "users/views/_social_logins.php";
        }
        ?>
      <?php endif; ?>

      <form class="form-signup border p-4 bg-light mb-5" action="" method="POST" id="payment-form">

        <div class="row mb-3">
          <label id="username-label" class="col-form-label col-12 col-md-4 text-md-right text-md-end"><?= lang("GEN_UNAME"); ?> *</label>

          <div class="col-12 col-md-8">
            <span id="usernameCheck" class="small"></span>
            <input type="text" class="form-control" id="username" name="username" placeholder="<?= lang("GEN_UNAME"); ?>" value="<?php if (!$form_valid && !empty($_POST)) {
                                                                                                                                    echo $username;
                                                                                                                                  } ?>" required autofocus autocomplete="username">
          </div>
        </div>

        <div class="row mb-3">
          <label for="fname" id="fname-label" class="col-form-label col-12 col-md-4 text-md-right text-md-end"><?= lang("GEN_FNAME"); ?> *</label>
          <div class="col-12 col-md-8">
            <input type="text" class="form-control" id="fname" name="fname" placeholder="<?= lang("GEN_FNAME"); ?>" value="<?php if (!$form_valid && !empty($_POST)) {
                                                                                                                              echo $fname;
                                                                                                                            } ?>" required autofocus autocomplete="given-name">
          </div>
        </div>

        <div class="row mb-3">
          <label for="lname" id="lname-label" class="col-form-label col-12 col-md-4 text-md-right text-md-end"><?= lang("GEN_LNAME"); ?> *</label>
          <div class="col-12 col-md-8">
            <input type="text" class="form-control" id="lname" name="lname" placeholder="<?= lang("GEN_LNAME"); ?>" value="<?php if (!$form_valid && !empty($_POST)) {
                                                                                                                              echo $lname;
                                                                                                                            } ?>" required autocomplete="family-name">
          </div>
        </div>

        <div class="row mb-3">
          <label for="email" id="email-label" class="col-form-label col-12 col-md-4 text-md-right text-md-end"><?= lang("GEN_EMAIL"); ?> *</label>
          <div class="col-12 col-md-8">
            <input class="form-control" type="text" name="email" id="email" placeholder="<?= lang("GEN_EMAIL"); ?>" value="<?php if (!$form_valid && !empty($_POST)) {
                                                                                                                              echo $email;
                                                                                                                            } ?>" required autocomplete="email">
          </div>
        </div>

        <div class="row mb-3">
          <?php if ($settings->no_passwords == 0) { ?>
            <div class="col-12 col-sm-6 col-lg-5 col-xl-4 password-verification">
            <?php 
              if(file_exists($abs_us_root . $us_url_root . 'usersc/includes/password_meter.php')) {
                include($abs_us_root . $us_url_root . 'usersc/includes/password_meter.php');
              } else {
                include($abs_us_root . $us_url_root . 'users/includes/password_meter.php');
              }
            ?>

            </div>
            <div class="col-12 col-sm-6 col-lg-7 col-xl-8">
              <div class="row mb-3">
                <label for="password" id="password-label" class="form-label col-12"><?= lang("GEN_PASS"); ?>
                  *
                  <a class="password_view_control ms-2" style="cursor: pointer; color:black; font-size:.8rem; text-decoration:none;">
                    <span class="fa fa-eye"></span>
                  </a>
                </label>
                <div class="col-12">
                  <input class="form-control" type="password" name="password" id="password" placeholder="<?= lang("GEN_PASS"); ?>" required autocomplete="new-password" aria-describedby="passwordhelp">

                </div>
              </div>
              <div class="row mb-3">
                <label for="confirm" id="confirm-label" class="form-label col-12"><?= lang("PW_CONF"); ?>
                  *
                  <a class="password_view_control ms-2" style="cursor: pointer; color:black; font-size:.8rem; text-decoration:none;">
                    <span class="fa fa-eye"></span>
                  </a>
                </label>
                <div class="col-12">
                  <input type="password" id="confirm" name="confirm" class="form-control" placeholder="<?= lang("PW_CONF"); ?>" required autocomplete="new-password">
                </div>
              </div>
            </div>
          <?php } //end no passwords 
          ?>
        </div>

        <?php
        includeHook($hooks, 'form');
        include($abs_us_root . $us_url_root . 'usersc/scripts/additional_join_form_fields.php');
        ?>

        <input type="hidden" value="<?= Token::generate(); ?>" name="csrf">

        <div class="row">
          <div class="col-12 col-md-8 offset-md-4">
            <button class="submit btn btn-primary " type="submit" id="next_button">
              <span class="fa fa-user-plus mr-2 me-2"></span> <?= lang("SIGNUP_TEXT"); ?>
            </button>
          </div>
        </div>

      </form>

      <?php if (!isset($settings->social_login_location) || $settings->social_login_location != 0): ?>
        <?php
        if (file_exists($abs_us_root . $us_url_root . "usersc/views/_social_logins.php")) {
          require_once $abs_us_root . $us_url_root . "usersc/views/_social_logins.php";
        } else {
          require_once $abs_us_root . $us_url_root . "users/views/_social_logins.php";
        }
        ?>
      <?php endif; ?>
    </main>
  </div>
</div>
