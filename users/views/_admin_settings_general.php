<?php
$hooks = getMyHooks(['page' => 'admin.php?view=general']);
includeHook($hooks, 'pre');
$verify_url = $db->query("SELECT verify_url FROM email")->first()->verify_url;
$no_passwords = "This feature removes the ability for users to login with a username and password in favor of OAuth, Passkey, and Email login options. It is your responsibility to make sure you have these options configured and tested before enabling this option.";

$email_login = "This feature allows users to login with their email address instead of their username and password. It is your responsibility to make sure you have the ability to send emails configured and tested before enabling this option. It requires the user to go into their email and click a magic link to sign in. While it is an extra step for the user, it removes your responsibility of storing passwords and the user's responsibility of remembering them. ";

$phpver = phpversion();
$min_passkey_version = '8.2.0';
$pkDisabledReason = '';
$your_host = fetchExpectedRPID();
$pkDisabled = false;
$totpDisabled = false;


//php version will override
if (version_compare($min_passkey_version, $phpver) == 1) {
  $pkDisabled = true;
  $totpDisabled = true;
  $pkVersionReason = 'phpver';
  $pkDisabledReason = "Requires PHP {$min_passkey_version}+";
  $totpDisabledReason = "Requires PHP {$min_passkey_version}+";
  if ($settings->passkeys > 0) {
    $db->update('settings', 1, ['passkeys' => 0]);
    usError("Passkeys are not supported on PHP versions below {$min_passkey_version}. Please upgrade your PHP version to use this feature. It has been disabled.");
    $settings->passkeys = 0;
  }
  if ($settings->totp > 0) {
    $db->update('settings', 1, ['totp' => 0]);
    usError("TOTP is not supported on PHP versions below {$min_passkey_version}. Please upgrade your PHP version to use this feature. It has been disabled.");
    $settings->totp = 0;
  }
} elseif (!defined('PASSKEY_RP_ID')) {
  $pkDisabled = true;
  $pkVersionReason = 'rpid';
  $pkDisabledReason = "PASSKEY_RP_ID not defined";
  $rpidWarning = "<div class='alert alert-warning'>You have not defined the constant <code>define('PASSKEY_RP_ID', $your_host);</code> in your <code>users/init.php</code> file. This is required for Passkeys to work properly. We have some very important information about this in your <a href='?view=security' target='_blank'>Security Dashboard</a>. We can also help you set this up automatically over there.</div>";
}

// TOTP Encryption Validation
$totpKeyFile = $abs_us_root . $us_url_root . 'usersc/includes/totp_key.php';
$totpEncryptionValid = false;
$totpDisabledReason = '';
$totpKeyWarning = '';

// Check if we already disabled TOTP due to PHP version
if (!$totpDisabled) {
  // Check if encryption functions are available
  if (!function_exists('totp_is_crypto_available')) {
    require_once $abs_us_root . $us_url_root . 'users/includes/encryption.php';
  }

  if (!totp_is_crypto_available()) {
    $totpDisabled = true;
    $totpDisabledReason = "No crypto backend available (need sodium or OpenSSL with AES-256-GCM)";

    // Auto-disable if it was somehow enabled
    if ($settings->totp > 0) {
      $db->update('settings', 1, ['totp' => 0]);
      usError("TOTP has been disabled because no suitable encryption backend is available. Please ensure sodium extension or OpenSSL with AES-256-GCM support is installed.");
      $settings->totp = 0;
    }
  } else {
    // Check if key file exists
    if (!file_exists($totpKeyFile)) {
      $totpKeyWarning = "<div class='alert alert-warning'>
                <strong>TOTP Key Missing:</strong> The encryption key file <code>usersc/includes/totp_key.php</code> does not exist. 
                It will be automatically generated when TOTP is first enabled, but you may want to generate it now for testing. 
                Make sure your <code>usersc/includes/</code> directory is writable.
            </div>";
    } else {
      // Key file exists, check if it's valid
      try {
        // Load the key file
        require_once $totpKeyFile;

        if (!defined('TOTP_ENC_KEY')) {
          $totpKeyWarning = "<div class='alert alert-danger'>
                        <strong>Invalid TOTP Key File:</strong> The key file exists but TOTP_ENC_KEY is not defined. 
                        You may need to delete <code>usersc/includes/totp_key.php</code> and let it regenerate.
                    </div>";
        } else {
          // Check if the crypto engine is still valid
          $currentEngine = totp_get_active_crypto_engine();
          $storedEngine = defined('TOTP_CRYPTO_ENGINE') ? TOTP_CRYPTO_ENGINE : 'unknown';

          if (defined('TOTP_FORCE_CRYPTO_ENGINE')) {
            $forcedEngine = TOTP_FORCE_CRYPTO_ENGINE;
            if ($currentEngine !== $forcedEngine) {
              $totpKeyWarning = "<div class='alert alert-warning'>
                                <strong>TOTP Engine Override:</strong> You have forced crypto engine to '<strong>$forcedEngine</strong>' 
                                but the available engine is '<strong>$currentEngine</strong>'. This may cause encryption/decryption failures.
                            </div>";
            }
          } elseif ($currentEngine !== $storedEngine && $storedEngine !== 'unknown') {
            $totpKeyWarning = "<div class='alert alert-info'>
                            <strong>TOTP Engine Changed:</strong> Your key file was created with '<strong>$storedEngine</strong>' 
                            but the current engine is '<strong>$currentEngine</strong>'. Existing secrets will be automatically 
                            re-encrypted when accessed.
                        </div>";
          }

          $totpEncryptionValid = true;
        }
      } catch (Exception $e) {
        $totpKeyWarning = "<div class='alert alert-danger'>
                    <strong>TOTP Key Error:</strong> Error loading key file: " . htmlspecialchars($e->getMessage()) . "
                </div>";
      }
    }

    // Final check - if TOTP is enabled but we don't have valid encryption
    if ($settings->totp > 0 && !$totpEncryptionValid && empty($totpKeyWarning)) {
      $totpDisabled = true;
      $totpDisabledReason = "Encryption validation failed";
    }
  }
}

?>

<!-- Site Settings -->
<form class="" action="" name="settings" method="post">
  <h2 class="mb-3">Site Settings</h2>
  <div class="row">
    <div class="col-md-6">
      <!-- Left -->
      <div class="card mt-4">
        <div class="card-header">
          <h3>General Settings</h3>
        </div>
        <div class="card-body">
          <!-- Site Name -->
          <div class="form-group">
            <label>Free API Key (<a class="text-primary" href="https://userspice.com/developer-api-keys/" target="_blank">Get One Here</a>) <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Get your free API key to use features such as Auto Updates, Bug Reports, and Spice Shaker"><i class="fa fa-question-circle offset-circle"></i></a></label>
            <input type="text" autocomplete="off" class="form-control ajxtxt" data-desc="API Key" name="spice_api" id="spice_api" value="<?= $settings->spice_api; ?>">
            <span id="APIKeyMessage"><?= checkAPIkey($settings->spice_api); ?></span>

          </div>
          <!-- Site Name -->
          <div class="form-group">
            <label>Site Name <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Modify this to change the name of your site, including in the <title> tag, the maintenance page and some system emails."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <input type="text" autocomplete="off" class="form-control ajxtxt" data-desc="Site Name" name="site_name" id="site_name" value="<?= $settings->site_name; ?>">
          </div>

          <!-- Copyright Option -->
          <div class="form-group">
            <label>Copyright Message <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="This message will be at the bottom of every page. The copyright symbol and year are automatically added."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <input type="text" autocomplete="off" class="form-control ajxtxt" data-desc="Copyright Message" name="copyright" id="copyright" value="<?= $settings->copyright; ?>">
          </div>


          <!-- Error Message Timeout Length -->
          <div class="form-group">
            <label>Error Message Timeout (seconds) <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="This hides those red error messages at the top of your page on urls with err= in them."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <div class="input-group">
              <input type="number" step="1" min="0" class="form-control ajxnum" data-desc="Error message timeout time" name="err_tim" id="err_time" value="<?= $settings->err_time; ?>">
              <span class="input-group-addon input-group-text">seconds</span>
            </div>
          </div>

          <div class="form-group">
            <label>Max users before User Manager Search Engine turns on.
            <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="If you have a lot of users, you may see performance issues with the datatables on the user manager.  Setting this number below your current number of users will turn on the search engine."><i class="fa fa-question-circle offset-circle"></i></a>
          <small class="ps-2">Current user count is <span class="text-success"><?= $db->query("SELECT count(*) as counter from users")->first()->counter; ?></span></small>
          </label>

            <input type="number" step="1" min="0" class="form-control ajxnum" data-desc="Max users for datatables" name="max_users_dt" id="max_users_dt" value="<?= $settings->max_users_dt; ?>">
          </div>

          <!-- Social Login Location -->
          <div class="form-group">
            <label>Social Login Location<a role="button" tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Determines if you want your social login / passkey buttons at the top or bottom of your login and registration pages"><i class="fa fa-question-circle offset-circle"></i></a></label>

            <select id="social_login_location" class="form-control ajxnum" data-desc="Social Login Location" name="social_login_location">
              <option <?php if ($settings->social_login_location == 0) {
                        echo "selected='selected'";
                      } ?> value="0">Top of Forms</option>

              <option <?php if ($settings->social_login_location == 1) {
                        echo "selected='selected'";
                      } ?> value="1">Bottom of Forms</option>


            </select>

          </div>

          <!-- Site Offline -->
          <div class="form-group">
            <label>Maintenance Mode (Site Offline) <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Need to go into Maintenance Mode to do an upgrade? Enable this! This will display a 'Maintenance Mode Active' message for those in the default Administrator permission group (ID: 2) and redirect the remaining to the maintenance page. This will occur until the setting is disabled. Default: No."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <span class="float-end offset-switch">
              <label class="switch switch-text switch-success">
                <div class="form-check form-switch">
                  <input id="site_offline" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Site offline" <?php if ($settings->site_offline == 1) {
                                                                                                                                                  echo 'checked="true"';
                                                                                                                                                } ?>>
                </div>
                <span data-on="Yes" data-off="No" class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
            </span>
          </div>

        </div>
      </div>

      <div class="card mt-4">
        <div class="card-header">
          <h3>Templates & Navigation</h3>
        </div>
        <div class="card-body">

          <!-- Navigation Type Option -->
          <div class="form-group">
            <label>Enable Database-Driven Navigation <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="As of U 4.3 navigations can be controlled from the database, switch between the original and database-driven navigaton here. Default: Database Driven."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <span class="float-end">
              <label class="switch switch-text switch-success">
                <div class="form-check form-switch">
                  <input id="navigation_type" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Navigation style" <?php if ($settings->navigation_type == 1) {
                                                                                                                                                        echo 'checked="true"';
                                                                                                                                                      } ?>>
                </div>
                <span data-on="Yes" data-off="No" class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
            </span>
          </div>
          <?php
          if (!isset($og_container_open_class)) {
            $og_container_open_class = $settings->container_open_class;
          }
          ?>
          <div class="form-group">
            <label>Main Div Class <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Traditionally you'll use container or container-fluid in this field. You can add multiple classes by adding spaces. Not every theme will respect this setting. Default: container-fluid"><i class="fa fa-question-circle offset-circle"></i></a></label>
            <input type="text" autocomplete="off" class="form-control ajxtxt" data-desc="Main Div Class" name="container_open_class" id="container_open_class" value="<?= $og_container_open_class; ?>">
          </div>
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-header">
          <h3>Security</h3>
        </div>
        <div class="card-body">

          <!-- Force SSL -->
          <div class="form-group">
            <label>Force HTTPS Connections <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Don't want anyone accessing your site insecurely? Enabled this. This will redirect any users from an HTTP (non-secure) connection to HTTPS. Make sure your SSL Cert is valid before doing this! Default: No."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <span class="float-end offset-switch">
              <label class="switch switch-text switch-success">
                <div class="form-check form-switch">
                  <input id="force_ssl" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Force HTTPS" <?php if ($settings->force_ssl == 1) {
                                                                                                                                              echo 'checked="true"';
                                                                                                                                            } ?>>
                </div>
                <span data-on="Yes" data-off="No" class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
            </span>
          </div>

          <div class="form-group">
            <label>Force Password Reset <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="This will change the force_pr value in your users database for all users to 1, requiring every user including the current one to reset their password. They will not be able to leave the user settings page until this make this change. This will always be no, however when you change it to Yes and save changes, it will perform the above action, and reset back to no. This isn't a setting, but a function."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <span class="float-end">
              <button type="button" name="force_user_pr" id="force_user_pr" class="btn btn-outline-danger input-group-addon">Force PW Reset</button>
              <span>
          </div>

          <div class="form-group">
            <label>Enable User Permission Restrictions <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Use this as a safeguard to only allow users to add/remove permission levels they have access to. You might use this in a format to give certain users access to add/remove users or make site changes, but you don't want them to give other users permissions they don't have, or take those away. Your safeguard for this (in your own case if you have certain permissions not assigned to yourself) is by restricting the page administration to the default Level 2 as you can do anything from these pages currently. This will still show the user the levels on user administration but will have a disabled attribute. Default: Disabled."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <span class="float-end offset-switch">
              <label class="switch switch-text switch-success">
                <div class="form-check form-switch">
                  <input id="permission_restriction" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Password Restriction Setting" <?php if ($settings->permission_restriction == 1) {
                                                                                                                                                                            echo 'checked="true"';
                                                                                                                                                                          } ?>>
                </div>
                <span data-on="Yes" data-off="No" class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
            </span>
          </div>

          <div class="form-group">
            <label>Enable Page Permission Restrictions <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Only allow one permission level per page using this setting. This is particularly good for ensuring no overlap in permission levels. You can have a permission group hierarchy such as this: User, User Manager, Database Manager, Administrator. In this case you want to give all your User Managers access to the user administration section, and yourself of course, but many not to those who manage your database only (maybe you want to give them access to site and email settings only). In any case, it will change the checkboxes on Admin Page section to radio buttons under Add Permission Level and restrict addition from the permission level settings to be added only if no other level has it. Default: Disabled."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <span class="float-end offset-switch">
              <label class="switch switch-text switch-success">
                <div class="form-check form-switch">
                  <input id="page_permission_restriction" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Page Permission Restriction Setting" <?php if ($settings->page_permission_restriction == 1) {
                                                                                                                                                                                        echo 'checked="true"';
                                                                                                                                                                                      } ?>>
                </div>
                <span data-on="Yes" data-off="No" class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
            </span>
          </div>

          <div class="form-group">
            <label>New Pages Default To "Private" <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Does what it says. Default: Enabled."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <span class="float-end offset-switch">
              <div class="form-check form-switch">
                <label class="switch switch-text switch-success">
                  <input id="page_default_private" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="New Pages Private Setting" <?php if ($settings->page_default_private == 1) {
                                                                                                                                                                      echo 'checked="true"';
                                                                                                                                                                    } ?>>
              </div>
              <span data-on="Yes" data-off="No" class="switch-label"></span>
              <span class="switch-handle"></span>
              </label>
            </span>
          </div>

          <!-- Cron Job Security -->
          <a name="cron"></a>
          <div class="form-group">
            <label>Only allow cron jobs from the following IP <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Cron jobs are automated server tasks that can make your life easier.  You may want to make sure, though, that they originate from you and not someone else.  You can whitelist an ip address here."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <input type="text" autocomplete="off" class="form-control ajxtxt" data-desc="Cron Job IP" name="cron_ip" id="cron_ip" value="<?= $settings->cron_ip; ?>" placeholder="<?php if ($settings->cron_ip == '') {
                                                                                                                                                                                    echo 'No security is IP is set';
                                                                                                                                                                                  } ?>">
          </div>
        </div>
      </div>
      <?php includeHook($hooks, 'body'); ?>
    </div>

    <!-- right column -->
    <div class="col-md-6">

      <div class="card mt-4">
        <div class="card-header">
          <h3>User Settings</h3>
        </div>
        <div class="card-body">
          <!-- Passkeys -->

          <div class="form-group">
            <label>Enable Passkeys <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Passkeys are a type of passwordless login which stores the user's identity on their own device."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <span class="float-end offset-switch">
              <?php if ($pkDisabled && isset($pkDisabledReason)) { ?>
                <span class="text-danger fw-bold"><small><?= $pkDisabledReason ?></small></span>
              <?php } else { ?>
                <div class="form-check form-switch">

                  <label class="switch switch-text switch-success">
                    <input id="passkeys" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Passkeys" <?php if ($settings->passkeys == 1) {
                                                                                                                                            echo 'checked="true"';
                                                                                                                                          } ?>>
                </div>
                <span data-on="Yes" data-off="No" class="switch-label"></span>
                <span class="switch-handle"></span>
                </label>
              <?php } ?>
            </span>
            <?php if ($pkDisabled && isset($rpidWarning)) {
              echo $rpidWarning;
            } ?>
          </div>

          <!-- TOTP -->
          <div class="form-group">
            <label>Enable TOTP (Two-Factor Authentication)
              <?php

              if ($totpEncryptionValid) {
                $currentEngine = totp_get_active_crypto_engine();
                echo "<span class='text-success mt-2'><small><i class='fa fa-check-circle'></i> Encryption ready (using: $currentEngine)</small></span>";
              } else {
                echo "<span class='text-danger mt-2'><small><i class='fa fa-exclamation-triangle'></i> Encryption not ready. See <a href='{$us_url_root}users/admin.php?view=security' target='_blank'>security dashboard</a>.</small></span>";
              }
              ?>
              <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Allows users to enable Time-based One-Time Password (TOTP) two-factor authentication for their accounts. This does not force it, but makes the option available on their user settings page."><i class="fa fa-question-circle offset-circle"></i></a>
            </label>

            <?php if ($totpDisabled) { ?>
              <span class="float-end">
                <span class="text-danger fw-bold"><small><?= $totpDisabledReason ?></small></span>
              </span>
            <?php } else { ?>
              <select id="totp" class="form-control ajxnum" data-desc="Enable TOTP" name="totp">
                <option <?php if (!isset($settings->totp) || $settings->totp == 0) {
                          echo "selected='selected'";
                        } ?> value="0">Disabled</option>
                <option <?php if (isset($settings->totp) && $settings->totp == 1) {
                          echo "selected='selected'";
                        } ?> value="1">Optional</option>
                <option <?php if (isset($settings->totp) && $settings->totp == 2) {
                          echo "selected='selected'";
                        } ?> value="2">Required</option>
              </select>
            <?php } ?>

            <?php
            // Show TOTP key/encryption warnings
            if (!empty($totpKeyWarning)) {
              echo $totpKeyWarning;
            }

            // Show site name warning
            if ($settings->site_name == "UserSpice") { ?>
              <div class="text-primary mt-2"><small><b>Note:</b> TOTP uses your Site Name, which is currently set to <span class="fw-bold">UserSpice</span>. You may want to consider changing that to make your site easier to find in the authenticator app.</small></div>
            <?php }


            ?>
          </div>

          <!-- Remove Password Logins -->
          <div class="form-group">
            <label>Password Logins <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="<?= $no_passwords ?>"><i class="fa fa-question-circle offset-circle"></i></a></label>
            <select id="no_passwords" class="form-control ajxnum" data-desc="Password Logins" name="no_passwords">
              <option <?php if ($settings->no_passwords == 0) {
                        echo "selected='selected'";
                      } ?> value="0">Enabled</option>
              <option <?php if ($settings->no_passwords == 1) {
                        echo "selected='selected'";
                      } ?> value="1">Disabled</option>
              <option <?php if ($settings->no_passwords == 2) {
                        echo "selected='selected'";
                      } ?> value="2">Disabled (except localhost)</option>
            </select>
            <small class="text-muted">When set to "Disabled (except localhost)", password logins are only allowed from 127.0.0.1 or ::1</small>
          </div>

          <!-- passwordless code length -->
          <div class="form-group">
            <label>Passwordless Code Length<a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="This is the number of chars the end user will have to enter to login"><i class="fa fa-question-circle offset-circle"></i></a></label>
            <select id="pwl_length" class="form-control ajxnum" data-desc="Passwordless Code Length" name="pwl_length">

              <?php for ($i = 4; $i <= 12; $i++) { ?>
                <option value="<?= $i ?>" <?php if ($settings->pwl_length == $i) {
                                            echo 'selected="selected"';
                                          } ?>><?= $i ?></option>
              <?php } ?>

            </select>
          </div>

          <!-- Enable Email Logins -->
          <div class="form-group">
            <label>Allow Passwordless Logins <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="<?= $email_login ?>"><i class="fa fa-question-circle offset-circle"></i></a></label>

            <select id="email_login" class="form-control ajxnum" data-desc="Email Login" name="email_login">
              <option value="0" <?php if ($settings->email_login == 0) {
                                  echo 'selected="selected"';
                                } ?>>Disabled</option>
              <option value="1" <?php if ($settings->email_login == 1) {
                                  echo 'selected="selected"';
                                } ?>>Through clicking a link in the email</option>
              <option value="2" <?php if ($settings->email_login == 2) {
                                  echo 'selected="selected"';
                                } ?>>Through entering a code they receive in email</option>
              <option value="3" <?php if ($settings->email_login == 3) {
                                  echo 'selected="selected"';
                                } ?>>Email or Code</option>

            </select>
            <br>
            <small>All links will point to <span style="color:red;"><?= $verify_url ?></span>. If that is not correct, change it <a href="<?= $us_url_root ?>users/admin.php?view=email" style="color:blue;"> here</a>.</small><br>
            <small>Need to debug? See options in <code>usersc/scripts/passwordless_login_overrides.php</code></small><br>
            <small>View passwordless debug logs <a href="<?= $us_url_root ?>users/admin.php?view=logs&mode=passwordless" style="color:blue;"> here</a>. The code option is a great way to combat antivirus software that visits links, thus invalidating them before they can be used by the end user.</small>
          </div>


          <!-- Force Password Reset -->
          <div class="form-group">
            <label>Force Password Reset on Manual Creation <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="When a user is created from the admin panel, force their password to be reset upon login, this will also send them a password reset link on manual creation no matter what password you enter on the form. If you enable this, the force_pr value in your users database for this user will be 1 when created. Default: No."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <span class="float-end offset-switch">
              <div class="form-check form-switch">
                <label class="switch switch-text switch-success">
                  <input id="force_pr" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Force Inital Password Reset" <?php if ($settings->force_pr == 1) {
                                                                                                                                                            echo 'checked="true"';
                                                                                                                                                          } ?>>
              </div>
              <span data-on="Yes" data-off="No" class="switch-label"></span>
              <span class="switch-handle"></span>
              </label>
            </span>
          </div>

          <div class="form-group">
            <label>Redirect After Login <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="The folder and file that you wish to redirect the user to after login. Default: users/account.php. Note that admins get redirected to this dashboard by default unless you intercept that call with something in usersc/scripts/custom_login_script.php"><i class="fa fa-question-circle offset-circle"></i></a></label>
            <input type="text" autocomplete="off" class="form-control ajxtxt" data-desc="Redirect After Login" name="redirect_uri_after_login" id="redirect_uri_after_login" value="<?= $settings->redirect_uri_after_login; ?>">
          </div>

          <!-- echouser Option -->
          <div class="form-group">
            <label>echouser Function <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="What do you want to echo when you use the echouser function? You can use this to echo their name in several different formats. Need their username instead? Use echousername. If it cannot find the user, it will echo Deleted. Default: FName LName."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <select id="echouser" class="form-control ajxnum" data-desc="echouser Function" name="echouser">
              <option value="0" <?php if ($settings->echouser == 0) {
                                  echo 'selected="selected"';
                                } ?>>0. FName LName</option>
              <option value="1" <?php if ($settings->echouser == 1) {
                                  echo 'selected="selected"';
                                } ?>>1. Username</option>
              <option value="2" <?php if ($settings->echouser == 2) {
                                  echo 'selected="selected"';
                                } ?>>2. Username (FName LName)</option>
              <option value="3" <?php if ($settings->echouser == 3) {
                                  echo 'selected="selected"';
                                } ?>>3. Username (FName)</option>
              <option value="4" <?php if ($settings->echouser == 4) {
                                  echo 'selected="selected"';
                                } ?>>4. FName First Initial of LName</option>
            </select>
          </div>

          <div class="form-group">
            <label>Enable OAuth Server <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="This UserSpice install can act as a centralized OAuth server for other applications.  These can be UserSpice, WordPress or dozens of other applications and languages. Default: Off."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <span class="float-end offset-switch">
              <div class="form-check form-switch">
                <label class="switch switch-text switch-success">
                  <input id="oauth_server" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="OAuth Server" <?php if ($settings->oauth_server == 1) {
                                                                                                                                                  echo 'checked="true"';
                                                                                                                                                } ?>>
              </div>
              <span data-on="Yes" data-off="No" class="switch-label"></span>
              <span class="switch-handle"></span>
              </label>
            </span>
          </div>
        </div>
      </div>


      <div class="card mt-4">
        <div class="card-header">
          <h3>Debug Mode</h3>
          Track down hard to find problems on your site. This causes MANY more things to be written to your logs and should only be used for short periods of time.<br>
        </div>
        <div class="card-body">

          <div class="form-group">
            <label>Enable Debug Mode <a role="button" tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Track down difficult form, database and redirect errors."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <span class="float-end offset-switch">
              <label class="switch switch-text switch-success"></label>
              <a style="color:blue;" href="admin.php?view=logs&mode=debug" class="">View Debug Logs</a>
            </span>
            <select id="debug" class="form-control ajxnum" data-desc="Debug Mode" name="debug">
              <option <?php if ($settings->debug == 0) {
                        echo "selected='selected'";
                      } ?> value="0">Off (Mode 0)</option>

              <option <?php if ($settings->debug == 1) {
                        echo "selected='selected'";
                      } ?> value="1">On for User ID 1 Only (Mode 1)</option>

              <option <?php if ($settings->debug == 2) {
                        echo "selected='selected'";
                      } ?> value="2">On For Everyone (Mode 2)</option>
            </select>

          </div>
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-header">
          <h3>Language</h3>
          There may be more languages available <a class="text-primary" href="https://userspice.com/translations" target="_blank">here</a>.<br>
        </div>
        <div class="card-body">

          <!-- Set Default Language -->
          <?php $languages = scandir($abs_us_root . $us_url_root . 'users/lang');
          foreach ($languages as $k => $v) {
            if ($v == '.' || $v == '..' || $v == 'flags') {
              unset($languages[$k]);
              continue;
            }
            $languages[$k] = substr($v, 0, -4);
          }
          ?>
          <div class="form-group">

            <label>Default Language <a tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Set the default language for your site"><i class="fa fa-question-circle offset-circle"></i></a></label>
            <select id="default_language" class="form-control ajxtxt" data-desc="Default Language" name="default_language">
              <option value="<?= $settings->default_language; ?>"><?= $settings->default_language; ?></option>
              <?php foreach ($languages as $l) {
                if ($l != false && $l != $settings->default_language) { ?>
                  <option value="<?= $l; ?>"><?= $l; ?></option>
              <?php }
              } ?>
            </select>
          </div>

          <!-- Allow Users To Change Language -->
          <div class="form-group">
            <label>Allow users to change their language <a role="button" tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="With this enabled, logged in users will be able to set their default language and non-logged in users will be able to change their language for this session."><i class="fa fa-question-circle offset-circle"></i></a></label>
            <span class="float-end offset-switch">
              <label class="switch switch-text switch-success">
                <div class="form-check form-switch">
                  <input id="allow_language" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Allow user to change language setting" <?php if ($settings->allow_language == 1) {
                                                                                                                                                                            echo 'checked="true"';
                                                                                                                                                                          } ?>>
                </div>
                <span data-on="Yes" data-off="No" class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
            </span>
          </div>
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-header">
          <h3>Update Track</h3>
          This gives you the opportunity to be part of our early release "Bleeding Edge" program.<br>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label>Update Track <a role="button" tabindex="-1" data-trigger="focus" data-bs-trigger="focus" data-placement="top" class="btn btn-link text-info px-0" title="Choose your update channel. Production is recommended for mission critical applications. Bleeding Edge provides early access to updates. Experimental includes features in development."><i class="fa fa-question-circle offset-circle"></i></a></label>

            <select id="bleeding_edge" class="form-control ajxnum" data-desc="Update Track" name="bleeding_edge">
              <option <?php if ($settings->bleeding_edge == 0) {
                        echo "selected='selected'";
                      } ?> value="0">Production Updates (Stable)</option>
              <option <?php if ($settings->bleeding_edge == 1) {
                        echo "selected='selected'";
                      } ?> value="1">Bleeding Edge (Beta/Early Release)</option>
              <option <?php if ($settings->bleeding_edge == 2) {
                        echo "selected='selected'";
                      } ?> value="2">Experimental (In Development)</option>
            </select>
          </div>
        </div>
      </div>

    </div>
  </div>

  <input type="hidden" name="csrf" value="<?= Token::generate(); ?>" />
</form>
<?php if (in_array($user->data()->id, $master_account)) { ?>
  <script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>" type="text/javascript">
    $(document).ready(function() {

      $('#no_passwords').change(function() {
        if ($(this).val() == '1' || $(this).val() == '2') {
          alert("<?= $no_passwords ?>");
        }
      });



      $('#email_login').change(function() {

        if ($(this).is(':checked')) {
          alert("<?= $email_login ?>");
        }

      });



      $('#recapatcha_public_show').hover(function() {
        $('#recap_public').attr('type', 'text');
      }, function() {
        $('#recap_public').attr('type', 'password');
      });
      $('#recapatcha_private_show').hover(function() {
        $('#recap_private').attr('type', 'text');
      }, function() {
        $('#recap_private').attr('type', 'password');
      });
    });
  </script>
<?php } ?>