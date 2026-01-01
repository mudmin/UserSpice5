<form class="" action="" name="register" method="post">
  <h2 class="mb-3">Registration & Password Settings</h2>
  <div class="row">
    <div class="col-md-6">


      <div class="card mt-2">
        <div class="card-body">
          Please note that you can install the <a href="admin.php?view=spice&search=userinfo">User Info</a> plugin to alter your registration fields.<br><br>
          <div class="form-group d-flex justify-content-between align-items-center">
            <label for="registration" class="mb-0">Allow New User Registration
              <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Registration Switcher! Also controls OAuth (Social Logins). Default: Enabled.">
                <i class="fa fa-question-circle offset-circle"></i>
              </a>
            </label>
            <span class="offset-switch">
              <label class="switch switch-text switch-success">
                <div class="form-check form-switch">
                  <input id="registration" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Registration System" <?php if ($settings->registration == 1) echo 'checked="true"'; ?>>
                </div>
                <span data-on="Yes" data-off="No" class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
            </span>
          </div>

          <div class="form-group">
            <label for="join_vericode_expiry">Registration Vericode Expiry (in hours)
              <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Length of time in hours for expiration of vericodes to email. Maximum: 999999999 (thats nine 9s!). Default: 24">
                <i class="fa fa-question-circle offset-circle"></i>
              </a>

            </label>
            <div class="input-group">
              <input type="number" step="1" min="1" max="999999999" class="form-control ajxnum" data-desc="Registration Vericode Expiry" name="join_vericode_expiry" id="join_vericode_expiry" value="<?= $settings->join_vericode_expiry ?>">
              <span class="input-group-addon input-group-text">Hours</span>
            </div>
          </div>

          <div class="form-group">
            <label for="change_un">Allow users to change their Usernames
              <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Does as it says. Default: Disabled.">
                <i class="fa fa-question-circle offset-circle"></i>
              </a>
            </label>
            <select id="change_un" class="form-control ajxnum" data-desc="Allow users to change their Usernames" name="change_un">
              <option value="0" <?php if ($settings->change_un == 0) echo 'selected="selected"'; ?>>Disabled</option>
              <option value="1" <?php if ($settings->change_un == 1) echo 'selected="selected"'; ?>>Enabled</option>
              <option value="2" <?php if ($settings->change_un == 2) echo 'selected="selected"'; ?>>Only once</option>
            </select>
          </div>

          <div class="form-group">
            <label for="change_un">Force users to validate their emails after registering</label>
            <br>
            <span class="text-muted">
              This setting is a part of the <a href="admin.php?view=email" style="color:blue;">email settings</a> as it requires your email to be properly configured and testing in order to function.
            </span>
          </div>

          <div class="form-group">
            <label for="reset_vericode_expiry">Password Reset Vericode Expiry (in minutes)
              <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Length of time in minutes for expiration of password reset vericodes to email. Maximum: 999999999 (thats nine 9s!). Default: 15">
                <i class="fa fa-question-circle offset-circle"></i>
              </a>
            </label>
            <div class="input-group">
              <input type="number" step="1" min="1" max="999999999" class="form-control ajxnum" data-desc="Password Reset Vericode Expiry" name="reset_vericode_expiry" id="reset_vericode_expiry" value="<?= $settings->reset_vericode_expiry ?>">
              <span class="input-group-addon input-group-text">Minutes</span>
            </div>
          </div>



          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="min_un">Minimum Username Length</label>
                <div class="input-group">
                  <input type="number" step="1" min="1" max="255" class="form-control ajxnum" data-desc="Minimum Username Length" name="min_un" id="min_un" value="<?= $settings->min_un ?>">
                  <span class="input-group-addon input-group-text">characters</span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="max_un">Maximum Username Length</label>
                <div class="input-group">
                  <input type="number" step="1" min="1" max="255" class="form-control ajxnum" data-desc="Maximum Username Length" name="max_un" id="max_un" value="<?= $settings->max_un ?>">
                  <span class="input-group-addon input-group-text">characters</span>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card mt-2">
        <div class="card-body">
          <?php
          $pw_settings = $db->query("SELECT * FROM us_password_strength")->first();
          if (isset($pw_settings->meter_active)) { ?>
            <p class="mb-2">There are 2 levels of password rules. The first is whether or not you want to display the "meter." The meter can be looked at as more of "password guidance." The user is shown whether their password meets the various rules. The second is "enforce rules." This performs a second check on submit to make sure the user has not manipulated the Javascript. Enforce rules does nothing if the meter is not shown as the user would have no idea why their password is not accepted. The submit button is disabled on the join form until conditions are met. This is not done on other forms because it could have unintended consequences.</p>

            <div class="form-group d-flex justify-content-between align-items-center">
              <label for="meter_active" class="mb-0">Show Password Meter?</label>
              <span class="offset-switch">
                <label class="switch switch-text switch-success">
                  <div class="form-check form-switch">
                    <input id="meter_active" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Show Password Meter" data-table="us_password_strength" <?php if ($pw_settings->meter_active == 1) echo 'checked="true"'; ?>>
                  </div>
                  <span data-on="Yes" data-off="No" class="switch-label"></span>
                  <span class="switch-handle"></span>
                </label>
              </span>
            </div>

            <div class="form-group d-flex justify-content-between align-items-center">
              <label for="enforce_rules" class="mb-0">Enforce Password Rules?</label>
              <span class="offset-switch">
                <label class="switch switch-text switch-success">
                  <div class="form-check form-switch">
                    <input id="enforce_rules" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Enforce Password Rules" data-table="us_password_strength" <?php if ($pw_settings->enforce_rules == 1) echo 'checked="true"'; ?>>
                  </div>
                  <span data-on="Yes" data-off="No" class="switch-label"></span>
                  <span class="switch-handle"></span>
                </label>
              </span>
            </div>

            <div class="form-group d-flex justify-content-between align-items-center">
              <label for="require_numbers" class="mb-0">Require a Number in the Password?</label>
              <span class="offset-switch">
                <label class="switch switch-text switch-success">
                  <div class="form-check form-switch">
                    <input id="require_numbers" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Require a Number" data-table="us_password_strength" <?php if ($pw_settings->require_numbers == 1) echo 'checked="true"'; ?>>
                  </div>
                  <span data-on="Yes" data-off="No" class="switch-label"></span>
                  <span class="switch-handle"></span>
                </label>
              </span>
            </div>
            <div class="form-group d-flex justify-content-between align-items-center">
              <label for="require_uppercase" class="mb-0">Require a Capital Letter in the Password?</label>
              <span class="offset-switch">
                <label class="switch switch-text switch-success">
                  <div class="form-check form-switch">
                    <input id="require_uppercase" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Require a Capital Letter" data-table="us_password_strength" <?php if ($pw_settings->require_uppercase == 1) echo 'checked="true"'; ?>>
                  </div>
                  <span data-on="Yes" data-off="No" class="switch-label"></span>
                  <span class="switch-handle"></span>
                </label>
              </span>
            </div>

            <div class="form-group d-flex justify-content-between align-items-center">
              <label for="require_lowercase" class="mb-0">Require a Lowercase Letter in the Password?</label>
              <span class="offset-switch">
                <label class="switch switch-text switch-success">
                  <div class="form-check form-switch">
                    <input id="require_lowercase" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Require a Lowercase Letter" data-table="us_password_strength" <?php if ($pw_settings->require_lowercase == 1) echo 'checked="true"'; ?>>
                  </div>
                  <span data-on="Yes" data-off="No" class="switch-label"></span>
                  <span class="switch-handle"></span>
                </label>
              </span>
            </div>

            <div class="form-group d-flex justify-content-between align-items-center">
              <label for="require_symbols" class="mb-0">Require a Symbol in the Password?</label>
              <span class="offset-switch">
                <label class="switch switch-text switch-success">
                  <div class="form-check form-switch">
                    <input id="require_symbols" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Require a Symbol" data-table="us_password_strength" <?php if ($pw_settings->require_symbols == 1) echo 'checked="true"'; ?>>
                  </div>
                  <span data-on="Yes" data-off="No" class="switch-label"></span>
                  <span class="switch-handle"></span>
                </label>
              </span>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label for="min_length">Minimum Password Length</label>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <input type="number" step="1" min="4" max="150" class="form-control ajxnum" data-desc="Minimum Password Length" name="min_length" id="min_length" data-table="us_password_strength" value="<?= $pw_settings->min_length ?>">
                  <span class="input-group-addon input-group-text">characters</span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label for="max_length">Maximum Password Length</label>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <input type="number" step="1" min="4" max="150" class="form-control ajxnum" data-desc="Maximum Password Length" name="max_length" id="max_length" data-table="us_password_strength" value="<?= $pw_settings->max_length ?>">
                  <span class="input-group-addon input-group-text">characters</span>
                </div>
              </div>
            </div>

            <p class="mt-3 mb-2">You can assign point values to characters to make a password score. Note that scores > 100 get rounded down to 100. While the scores set by default are generally considered reasonable, you can customize them based on your needs. It is important to note that 75 is an ideal minimum setting for Minimum password score as there are extra conditions in the score calculator that drop the score down to 74 if, for instance, the score is > 75 but it does not have the required Capital Letter or Symbol. This gives you a buffer to ensure that the strength is not met by a password of all numbers. If you want to ignore all this, require a score of 74 or below or override the userSpicePasswordScore function in usersc/includes/custom_functions.php.</p>

            <div class="row">
              <div class="col-md-6">
                <label for="min_score">Minimum Password Score</label>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <input type="number" step="1" min="1" max="100" class="form-control ajxnum" data-desc="Minimum Password Score" name="min_score" id="min_score" data-table="us_password_strength" value="<?= $pw_settings->min_score ?>">
                  <span class="input-group-addon input-group-text">points</span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label for="number_score">Number Score</label>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <input type="number" step="1" min="1" max="100" class="form-control ajxnum" data-desc="Number Score" name="number_score" id="number_score" data-table="us_password_strength" value="<?= $pw_settings->number_score ?>">
                  <span class="input-group-addon input-group-text">points</span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label for="uppercase_score">Uppercase Letter Score</label>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <input type="number" step="1" min="1" max="100" class="form-control ajxnum" data-desc="Uppercase Letter Score" name="uppercase_score" id="uppercase_score" data-table="us_password_strength" value="<?= $pw_settings->uppercase_score ?>">
                  <span class="input-group-addon input-group-text">points</span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label for="lowercase_score">Lowercase Letter Score</label>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <input type="number" step="1" min="1" max="100" class="form-control ajxnum" data-desc="Lowercase Letter Score" name="lowercase_score" id="lowercase_score" data-table="us_password_strength" value="<?= $pw_settings->lowercase_score ?>">
                  <span class="input-group-addon input-group-text">points</span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label for="symbol_score">Symbol Score</label>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <input type="number" step="1" min="1" max="100" class="form-control ajxnum" data-desc="Symbol Score" name="symbol_score" id="symbol_score" data-table="us_password_strength" value="<?= $pw_settings->symbol_score ?>">
                  <span class="input-group-addon input-group-text">points</span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label for="greater_eight">Bonus Score for > 8 chars</label>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <input type="number" step="1" min="1" max="100" class="form-control ajxnum" data-desc="Bonus Score for > 8 chars" name="greater_eight" id="greater_eight" data-table="us_password_strength" value="<?= $pw_settings->greater_eight ?>">
                  <span class="input-group-addon input-group-text">points</span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label for="greater_twelve">Bonus Score for > 12 chars</label>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <input type="number" step="1" min="1" max="100" class="form-control ajxnum" data-desc="Bonus Score for > 12 chars" name="greater_twelve" id="greater_twelve" data-table="us_password_strength" value="<?= $pw_settings->greater_twelve ?>">
                  <span class="input-group-addon input-group-text">points</span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label for="greater_sixteen">Bonus Score for > 16 chars</label>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <input type="number" step="1" min="1" max="100" class="form-control ajxnum" data-desc="Bonus Score for > 16 chars" name="greater_sixteen" id="greater_sixteen" data-table="us_password_strength" value="<?= $pw_settings->greater_sixteen ?>">
                  <span class="input-group-addon input-group-text">points</span>
                </div>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-md-6">
                <label for="">Sample password score tester</label><br>
                <input type="text" id="password" class="form-control" placeholder="Enter a sample password">
                <input type="text" id="confirm" class="form-control mt-2" placeholder="Confirm sample password (optional)">
                <div class="alert alert-warning mt-2" id="meterActiveWarning">Password meter is not active. This is for demonstration purposes only.</div>
              </div>
              <div class="col-md-6">


                <?php
                $original = $pw_settings->meter_active;
                $pw_settings->meter_active = 1;
                if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/password_meter.php')) {
                  include($abs_us_root . $us_url_root . 'usersc/includes/password_meter.php');
                } else {
                  include($abs_us_root . $us_url_root . 'users/includes/password_meter.php');
                }
                ?>
              </div>
              <script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
                $(document).ready(function() {
                  $("#meter_active").on("change", function() {
                    let meterVal = $(this).prop("checked") ? 1 : 0;
                    console.log(meterVal);
                    if (meterVal == 0) {
                      $("#meterActiveWarning").show();
                    } else {
                      $("#meterActiveWarning").hide();
                    }
                  });

                  if ($("#meter_active").prop("checked") == false) {
                    $("#meterActiveWarning").show();
                  } else {
                    $("#meterActiveWarning").hide();
                  }

                });
              </script>

            </div>
        </div>
      <?php } ?>

      </div>
      <input type="hidden" name="csrf" value="<?= Token::generate() ?>" />
</form>