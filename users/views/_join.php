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

Special thanks to John Bovey for the password strength feature.
*/
?>

<div class="container">
  <div class="row justify-content-md-center">
    <main class="col-12 col-md-10 col-lg-8">
      <?php
      includeHook($hooks, 'body');
      ?>

      <h1 class="form-signin-heading mt-4 mb-3"> <?= lang("SIGNUP_TEXT", ""); ?></h1>

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
          <?php
          $character_range = lang("GEN_MIN") . " " . $settings->min_pw . " " . lang("GEN_AND") . " " . $settings->max_pw . " " . lang("GEN_MAX") . " " . lang("GEN_CHAR");
          $character_statement = '<span id="character_range" class="text-muted">' . $character_range . ' </span>';

          if ($settings->req_cap == 1) {
            $num_caps = '1'; //Password must have at least 1 capital
            if ($num_caps != 1) {
              $num_caps_s = 's';
            }
            $num_caps_statement = '<span id="caps" class="text-muted">' . lang("JOIN_HAVE") . $num_caps . lang("JOIN_CAP") . '</span>';
          }

          if ($settings->req_num == 1) {
            $num_numbers = '1'; //Password must have at least 1 number
            if ($num_numbers != 1) {
              $num_numbers_s = 's';
            }

            $num_numbers_statement = '<span id="number" class="text-muted">' . lang("JOIN_HAVE") . $num_numbers . " " . lang("GEN_NUMBER") . '</span>';
          }
          $password_match_statement = '<span id="password_match" class="text-muted">' . lang("JOIN_TWICE") . '</span>';
          ?>

          <div class="col-12 col-sm-6 col-lg-5 col-xl-4">
            <p><strong><?= lang("PW_SHOULD"); ?></strong></p>
            <ul class="list-unstyled">
              <li>
                <span id="character_range_icon" class="fa fa-close text-muted" style="width: 16px;"></span>&nbsp;&nbsp;<?php echo $character_statement; ?>
              </li>

              <?php
              if ($settings->req_cap == 1) { ?>
                <li>
                  <span id="num_caps_icon" class="fa fa-close text-muted" style="width: 16px;"></span>&nbsp;&nbsp;<?php echo $num_caps_statement; ?>
                </li>
              <?php }

              if ($settings->req_num == 1) { ?>
                <li><span id="num_numbers_icon" class="fa fa-close text-muted" style="width: 16px;"></span>&nbsp;&nbsp;<?php echo $num_numbers_statement; ?>
                </li>
              <?php } ?>

              <li><span id="password_match_icon" class="fa fa-close text-muted" style="width: 16px;"></span>&nbsp;&nbsp;<?php echo $password_match_statement; ?></li>

            </ul>

            <p><a class="nounderline" id="password_view_control" style="cursor: pointer;"><span class="fa fa-eye"></span> <?= lang("PW_SHOWS"); ?></a></p>
          </div>
          <div class="col-12 col-sm-6 col-lg-7 col-xl-8">
            <div class="row mb-3">
              <label for="password" id="password-label" class="form-label col-12"><?= lang("GEN_PASS"); ?> *
                <?php /* Commenting this out since it's repeated right beside here. Not deleting it since
          ** I'm not sure if that's always going to be the case.
          (<?=lang("GEN_MIN");?> <?=$settings->min_pw?> <?=lang("GEN_AND");?> <?=lang("GEN_MAX");?> <?=$settings->max_pw?> <?=lang("GEN_CHAR");?>)
            */ ?> </label>
              <div class="col-12">
                <input class="form-control" type="password" name="password" id="password" placeholder="<?= lang("GEN_PASS"); ?>" required autocomplete="new-password" aria-describedby="passwordhelp">
              </div>
            </div>
            <div class="row mb-3">
              <label for="confirm" id="confirm-label" class="form-label col-12"><?= lang("PW_CONF"); ?> *</label>
              <div class="col-12">
                <input type="password" id="confirm" name="confirm" class="form-control" placeholder="<?= lang("PW_CONF"); ?>" required autocomplete="new-password">
              </div>
            </div>
          </div>
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
    </main>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {

    $("#password").keyup(function() {
      var pswd = $("#password").val();

      //validate the length
      if (pswd.length >= <?= $settings->min_pw ?> && pswd.length <= <?= $settings->max_pw ?>) {
        ToggleClasses(true, $("#character_range_icon"), $("#character_range"));
      } else {
        ToggleClasses(false, $("#character_range_icon"), $("#character_range"));
      }

      //validate capital letter
      if (pswd.match(/[A-Z]/)) {
        ToggleClasses(true, $("#num_caps_icon"), $("#caps"));
      } else {
        ToggleClasses(false, $("#num_caps_icon"), $("#caps"));
      }

      //validate number
      if (pswd.match(/\d/)) {
        ToggleClasses(true, $("#num_numbers_icon"), $("#number"));
      } else {
        ToggleClasses(false, $("#num_numbers_icon"), $("#number"));
      }
    });

    $("#confirm").keyup(function() {
      var pswd = $("#password").val();
      var confirm_pswd = $("#confirm").val();

      //validate password_match
      if (pswd == confirm_pswd) {
        ToggleClasses(true, $("#password_match_icon"), $("#password_match"));
      } else {
        ToggleClasses(false, $("#password_match_icon"), $("#password_match"));
      }
    });

    function ToggleClasses(conditionMet, icon, text) {
      if (conditionMet) {
        icon.removeClass("text-muted").removeClass("fa-close").addClass("text-success").addClass("fa-check");
        text.removeClass("text-muted");
      } else {
        icon.removeClass("text-success").removeClass("fa-check").addClass("text-muted").addClass("fa-close");
        text.addClass("text-muted");
      }
    }
  });
</script>