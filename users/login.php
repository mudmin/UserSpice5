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
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/
if (!defined('USERSPICE_LOGIN_CALLED')) {
   define('USERSPICE_LOGIN_CALLED', true);
   require_once '../users/init.php';
}
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

// Ensure session is started for TOTP intermediate storage
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//if totp active and php >= 8.2.0
if($settings->totp > 0 && version_compare(PHP_VERSION, '8.2.0', '>=')) {
    require_once $abs_us_root . $us_url_root . 'users/auth/TOTPHandler.php';
}else{
    $settings->totp = 0; // Disable TOTP if not supported
    $currentSessionName = $config['session']['session_name'];
}

$hooks = getMyHooks();
if(isset($oauthHooks) && is_array($oauthHooks)) {
    $hooks = array_merge($hooks, $oauthHooks);
} 

includeHook($hooks, 'pre');
$emailSet = $db->query("SELECT * FROM email")->first();
if (!isset($settings->no_passwords)) {
    $settings->no_passwords = 0;
}

$allowPasswords = passwordsAllowed($settings->no_passwords);

if ($emailSet->email_login == "yourEmail@gmail.com" || $emailSet->email_login == "" || $emailSet->email_pass == "1234" || !$allowPasswords) {
    $showForgot = false;
} else {
    $showForgot = true;
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

// Initialize TOTP handler
$totpHandler = null;
$totpEnabled = false;
if (isset($settings->totp) && ($settings->totp > 1)) {
  
        $siteName = isset($settings->site_name) ? $settings->site_name : 'UserSpice';
        $totpHandler = new TOTPHandler($db, $siteName);
        $totpEnabled = true;

}

// Check for pending TOTP verification state
$awaitingTOTP = false;
$tempUserId = null;
if (isset($_SESSION[$currentSessionName . '_totp_user_id_to_verify']) && !empty($_SESSION[$currentSessionName . '_totp_user_id_to_verify'])) {
    $awaitingTOTP = true;
    $tempUserId = $_SESSION[$currentSessionName . '_totp_user_id_to_verify'];
}

// Check if user is already fully logged in
if ($user->isLoggedIn() && !$awaitingTOTP) {

    Redirect::to($us_url_root . $settings->redirect_uri_after_login);
}


// Handle form submission
if (!empty($_POST)) {
    $token = Input::get('csrf');

    if (Token::check($token)) {
        $_SESSION[$currentSessionName . '_totp_verified'] = false;

        // Check if this is a TOTP verification step
        if ($awaitingTOTP && !empty($_POST['totp_code'])) {
            // Check rate limit for TOTP verification
            if (!checkRateLimit('totp_verify', $tempUserId)) {
                
                $errors[] = getRateLimitErrorMessage('totp_verify');
            } else {
                $totpCode = Input::get('totp_code');
                $useBackup = !empty($_POST['use_backup_code']);

                if ($totpHandler) {
                    $verified = false;

                    if ($useBackup) {
                        if ($totpHandler->verifyBackupCode($tempUserId, $totpCode)) {
                            if ($totpHandler->invalidateBackupCode($tempUserId, $totpCode)) {
                                $verified = true;
                                // logger($tempUserId, "Login", "TOTP login successful using backup code.");
                            } else {
                                $errors[] = lang("2FA_ERR_BACKUP_INVALIDATE_FAIL");
                            }
                        } else {
                            $errors[] = lang("2FA_ERR_INVALID_BACKUP");
                        }
                    } else {
                        $userSecret = $totpHandler->getUserSecret($tempUserId);
                        if ($userSecret && $totpHandler->verifyCode($userSecret, $totpCode)) {
                            $verified = true;
                            // logger($tempUserId, "Login", "TOTP login successful using authenticator app.");
                        } else {
                            $errors[] = lang("2FA_ERR_INVALID_CODE");
                        }
                    }

                    if ($verified) {
                        // Record successful TOTP verification and clear failed attempts
                        handleAuthSuccess('totp_verify', $tempUserId, null, [], [
                            'method' => $useBackup ? 'backup_code' : 'authenticator_app',
                            'user_agent' => Server::get('HTTP_USER_AGENT')
                        ]);
                        
                        // Complete the login process
                        $userData = $db->query("SELECT * FROM users WHERE id = ?", [$tempUserId])->first();
                        if ($userData) {
                            // Set session variables for login
                            $_SESSION[$currentSessionName] = $tempUserId;
                            $_SESSION[$currentSessionName . '_user'] = $tempUserId;
                            $_SESSION[$currentSessionName . '_user_last_login'] = date("Y-m-d H:i:s");
                            $_SESSION[$currentSessionName . '_last_confirm'] = date("Y-m-d H:i:s");
                            $_SESSION[$currentSessionName . '_totp_verified'] = true;

                            // Update last login in database
                            $db->update('users', $tempUserId, [
                                'last_login' => date("Y-m-d H:i:s"),
                                'logins' => $userData->logins + 1
                            ]);

                            // Execute login success hooks
                            $hooks = getMyHooks(['page' => 'loginSuccess']);
                            includeHook($hooks, 'body');

                            // Get stored redirect info
                            $finalDest = $_SESSION[$currentSessionName . '_totp_final_dest'] ?? null;
                            $inputRedirect = $_SESSION[$currentSessionName . '_totp_input_redirect'] ?? null;

                            // Clear TOTP session variables
                            unset($_SESSION[$currentSessionName . '_totp_user_id_to_verify']);
                            unset($_SESSION[$currentSessionName . '_totp_remember_me']);
                            unset($_SESSION[$currentSessionName . '_totp_final_dest']);
                            unset($_SESSION[$currentSessionName . '_totp_input_redirect']);
                            // logger(1,"cls","case 1");
                            if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php')) {
                                require_once $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
                            }
                            // Redirect to destination
                            if (!empty($inputRedirect)) {
                                Redirect::to(html_entity_decode($inputRedirect));
                            } elseif (!empty($finalDest)) {
                                Redirect::to($finalDest);
                            } else {
                                $default_dest = Config::get('homepage') ?: 'account.php';
                                Redirect::to($us_url_root . $default_dest);
                            }
                        } else {
                            $errors[] = "Login verification failed. Please try again.";
                            // Clear session related to TOTP pending state to reset the flow
                            unset($_SESSION[$currentSessionName . '_totp_user_id_to_verify']);
                            unset($_SESSION[$currentSessionName . '_totp_remember_me']);
                            unset($_SESSION[$currentSessionName . '_totp_final_dest']);
                            unset($_SESSION[$currentSessionName . '_totp_input_redirect']);
                            $awaitingTOTP = false; // Reset to show regular login form
                        }
                    } else {
                        // TOTP verification failed
                        handleAuthFailure('totp_verify', $tempUserId, null, [], [
                            'method' => $useBackup ? 'backup_code' : 'authenticator_app',
                            'user_agent' => Server::get('HTTP_USER_AGENT')
                        ]);
                        // logger($tempUserId, "VerifyTOTP", "TOTP verification failed for user ID: $tempUserId");
                        // Keep the TOTP form displayed for retry
                    }
                }
            }
        } else {
            // Regular username/password login
            $validate = new Validate();
            $validation = $validate->check(
                $_POST,
                array(
                    'username' => array('display' => lang('GEN_UNAME'), 'required' => true),
                    'password' => array('display' => lang('GEN_PASS'), 'required' => true)
                )
            );
            $validated = $validation->passed();

            $username = Input::get('username');
            $password = trim(Input::get('password'));
            $remember = false;
            $totpCode = Input::get('totp_code');

            includeHook($hooks, 'post');

            if ($validated) {
                // Check rate limit for login attempts
                $userRecord = $db->query("SELECT id FROM users WHERE username = ? OR email = ?", [$username, $username])->first();
                $userId = $userRecord ? $userRecord->id : null;
                
                if (!checkRateLimit('login_attempt', $userId, $username)) {
                    
                    $errors[] = getRateLimitErrorMessage('login_attempt');
                } else {
                    // Attempt to login with credentials
                    $tempUser = new User();
                    $rawpassword = $_POST['password'];
                    $login = $tempUser->loginEmail($username, $password, $remember, $rawpassword);

                    if ($login) {
                        // Credentials are valid - now check if TOTP is required
                        $requireTOTP = false;
                        $userHasTOTP = false;

                        if ($totpHandler) {
                            $userHasTOTP = $totpHandler->isTOTPEnabled($tempUser->data()->id);
                            if ($userHasTOTP) {
                                $requireTOTP = true;
                            }
                        }

                        if ($requireTOTP) {
                            // Check if TOTP code was provided in the same form
                            if (!empty($totpCode)) {
                                $userSecret = $totpHandler->getUserSecret($tempUser->data()->id);
                                if ($userSecret && $totpHandler->verifyCode($userSecret, $totpCode)) {
                                    // Record successful login with TOTP
                                    handleAuthSuccess('login_attempt', $tempUser->data()->id, $username, [], [
                                        'method' => 'inline_totp',
                                        'user_agent' => Server::get('HTTP_USER_AGENT')
                                    ]);

                                    $user = $tempUser; // Set user object for further processing
                                    
                                    // TOTP verified, complete login immediately
                                    $hooks = getMyHooks(['page' => 'loginSuccess']);
                                    includeHook($hooks, 'body');
                                    $dest = sanitizedDest('dest');
                                    $_SESSION[$currentSessionName . '_last_confirm'] = date("Y-m-d H:i:s");
                                    $_SESSION[$currentSessionName . '_totp_verified'] = true;
                                    // logger($tempUser->data()->id, "Login", "Successful login with inline TOTP verification.");
                                   
                                    // logger(1,"cls","case 2");
                                    if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php')) {
                                        require_once $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
                                    }
                                    if (!empty($dest)) {
                                        $redirect = Input::get('redirect');
                                        if (!empty($redirect) || $redirect !== '') Redirect::to(html_entity_decode($redirect));
                                        else Redirect::to($dest);
                                    } else {
                                        if (($default_dest = Config::get('homepage')) || ($default_dest = 'account.php')) {
                                            Redirect::to($us_url_root . $default_dest);
                                        }
                                    }
                                } else {
                                    // Invalid TOTP code
                                    handleAuthFailure('totp_verify', $tempUser->data()->id, null, [], [
                                        'method' => 'inline_totp',
                                        'user_agent' => Server::get('HTTP_USER_AGENT')
                                    ]);
                                    unset($_SESSION[$currentSessionName]);
                                    $errors[] = lang("2FA_ERR_INVALID_CODE");
                                    unset($_SESSION[$currentSessionName . '_totp_user_id_to_verify']);
                                    unset($_SESSION[$currentSessionName . '_totp_remember_me']);
                                    unset($_SESSION[$currentSessionName . '_totp_final_dest']);
                                    unset($_SESSION[$currentSessionName . '_totp_input_redirect']);
                                    $awaitingTOTP = false;
                                }
                            } else {
                                // TOTP required but not provided - set up for next step
                                unset($_SESSION[$currentSessionName]);
                                $_SESSION[$currentSessionName . '_totp_user_id_to_verify'] = $tempUser->data()->id;
                                $_SESSION[$currentSessionName . '_totp_remember_me'] = $remember;

                                $dest = sanitizedDest('dest');
                                $_SESSION[$currentSessionName . '_totp_final_dest'] = $dest;
                                $_SESSION[$currentSessionName . '_totp_input_redirect'] = Input::get('redirect');

                                // logger($tempUser->data()->id, "Login", "Valid credentials provided. Awaiting TOTP verification.");

                                // Set state for current page to show TOTP form
                                $awaitingTOTP = true;
                                $tempUserId = $tempUser->data()->id;

                                $successes[] = "Credentials verified. Please enter your authentication code.";
                            }
                        } else {
                            // Record successful login
                            handleAuthSuccess('login_attempt', $tempUser->data()->id, $username, [], [
                                'method' => 'standard_login',
                                'user_agent' => Server::get('HTTP_USER_AGENT')
                            ]);
                            $user = $tempUser; // Set user object for further processing

                            // No TOTP required - complete normal login
                            $hooks = getMyHooks(['page' => 'loginSuccess']);
                           
                            includeHook($hooks, 'body');
                            $dest = sanitizedDest('dest');
                            $_SESSION[$currentSessionName . '_last_confirm'] = date("Y-m-d H:i:s");
                            // logger(1,"cls","case 3");
                   
                            if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php')) {
                                require_once $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
                            }
                            if (!empty($dest)) {
                                $redirect = Input::get('redirect');
                                if (!empty($redirect) || $redirect !== '') Redirect::to(html_entity_decode($redirect));
                                else Redirect::to($dest);
                            } else {
                                if (($default_dest = Config::get('homepage')) || ($default_dest = 'account.php')) {
                                    Redirect::to($us_url_root . $default_dest);
                                }
                            }
                        }
                    } else {
                        // Record failed login attempt
                        handleAuthFailure('login_attempt', $userId, $username, [], [
                            'username_attempted' => $username,
                            'user_agent' => Server::get('HTTP_USER_AGENT')
                        ]);
                        
                        $eventhooks = getMyHooks(['page' => 'loginFail']);
                        includeHook($eventhooks, 'body');
                        // logger("0", "Login Fail", "A failed login on login.php");
                        $msg = lang("SIGNIN_FAIL");
                        $msg2 = lang("SIGNIN_PLEASE_CHK");
                        $errors[] = '<strong>' . $msg . '</strong>' . $msg2;
                    }
                }
            } else {
                $errors = $validation->errors();
            }
        }
    } else {
        // CSRF token is invalid, add error.
        $errors[] = "<strong>CSRF Error:</strong> Security token missing or invalid. Please try again.";
    }

    // Always call sessionValMessages to display errors/successes
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

    .totp-section {
        border-top: 1px solid #dee2e6;
        padding-top: 1rem;
        margin-top: 1rem;
    }

    .backup-code-section {
        border-top: 1px solid #dee2e6;
        padding-top: 1rem;
        margin-top: 1rem;
    }
</style>

<div class="container p-2 h-100 alternate-background">

    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b><?= $awaitingTOTP ? "Two-Factor Authentication" : lang("SIGNIN_TITLE") ?></b>
                    <a href="<?= $us_url_root ?>" aria-label="Close" class="close btn-close" style="top: 1rem!important;"></a>
                </div>
                <div class="modal-body p-3">

                    <div class="usmsgblock">
                        <?php
                        $usmsgs = array(
                            'err',
                            'msg',
                            'valSuc',
                            'valErr',
                            'genMsg',
                        );
                        foreach ($usmsgs as $u) { ?>
                            <div style="" id="<?= $u ?>UserSpiceMessages" class="show d-none">
                                <span id="<?= $u ?>UserSpiceMessage"></span>
                                <button type="button" class="close btn-close" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>
                    </div>

                    <?php includeHook($hooks, 'body'); ?>

                    <?php if (!$awaitingTOTP && isset($settings->social_login_location) && $settings->social_login_location == 0): ?>
                        <?php
                        if (file_exists($abs_us_root . $us_url_root . "usersc/views/_social_logins.php")) {
                            require_once $abs_us_root . $us_url_root . "usersc/views/_social_logins.php";
                        } else {
                            require_once $abs_us_root . $us_url_root . "users/views/_social_logins.php";
                        }
                        ?>
                    <?php endif; ?>

                    <?php if ($awaitingTOTP): ?>
                        <div class="text-center mb-3">
                            <i class="fa fa-shield-alt fa-2x text-primary"></i>
                            <h5 class="mt-2"><?= lang("2FA_VERIFY_TITLE") ?></h5>
                            <p class="text-muted"><?= lang("2FA_VERIFY_INFO") ?></p>
                        </div>

                        <form name="totp-verify" method="post" id="totp-form" action="">
                            <?= tokenHere(); ?>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="totp_code"><?= lang("2FA_CODE_LABEL") ?></label>
                                <input type="text" id="totp_code" name="totp_code" class="form-control form-control-lg text-center"
                                    required autocomplete="off" pattern="\d{6}" maxlength="6" placeholder="000000" autofocus>
                                <div class="form-text"><?= lang("2FA_VERIFY_INFO") ?></div>
                            </div>
                            <button class="btn btn-primary w-100 mb-3" type="submit">
                                <i class="fa fa-check"></i> <?= lang("2FA_VERIFY_BTN") ?>
                            </button>
                        </form>

                        <div class="backup-code-section">
                            <div id="backup-form">
                                <form name="backup-verify" method="post">
                                    <?= tokenHere(); ?>
                                    <div class="form-outline mb-3">
                                        <label class="form-label" for="backup_code"><?= lang("2FA_BACKUP_CODE_LABEL") ?></label>
                                        <input type="text" id="backup_code" name="totp_code" class="form-control"
                                            autocomplete="off" placeholder="XXXXX-XXXXX" maxlength="11" style="text-transform: uppercase;">
                                        <input type="hidden" name="use_backup_code" value="1">
                                        <div class="form-text">Enter your backup code (letters and numbers)</div>
                                    </div>
                                    <button class="btn btn-secondary w-100" type="submit">
                                        <i class="fa fa-key"></i> Use Backup Code
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <a href="<?= $us_url_root ?>users/logout.php" class="text-danger">
                                <small><?=lang("MENU_LOGOUT");?></small>
                            </a>
                        </div>

                    <?php elseif ($allowPasswords): ?>
                        <form name="login" id="login-form" class="form-signin" method="post" action="">
                            <?= tokenHere(); ?>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="username"><?= lang("SIGNIN_UORE") ?></label>
                                <input type="text" id="username" name="username" class="form-control form-control-lg"
                                    value="<?= isset($_POST['username']) ? safeReturn(Input::get('username')) : '' ?>"
                                    required autocomplete="username">
                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label" for="password"><?= lang("SIGNIN_PASS") ?></label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control form-control-lg"
                                        value="" autocomplete="current-password">
                                    <span class="input-group-addon input-group-text see-pw" id="togglePassword">
                                        <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                    </span>
                                </div>
                            </div>

                            <?php if ($totpEnabled): ?>
                                <div class="totp-section">
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="totp_code_inline">
                                            <i class="fa fa-shield-alt"></i> Authentication Code (if enabled)
                                        </label>
                                        <input type="text" id="totp_code_inline" name="totp_code" class="form-control"
                                            autocomplete="off" pattern="\d{6}" maxlength="6" placeholder="000000 (optional)">
                                        <div class="form-text">
                                            <small>If you have two-factor authentication enabled, enter your 6-digit code here. Otherwise, leave blank.</small>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php includeHook($hooks, 'form'); ?>
                            <input type="hidden" name="redirect" value="<?= Input::get('redirect') ?>" />
                            <button class="submit col-12 btn btn-primary rounded submit px-3" id="next_button" type="submit">
                                <i class="fa fa-sign-in"></i> <?= lang("SIGNIN_BUTTONTEXT") ?>
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if (!$awaitingTOTP && (!isset($settings->social_login_location) || $settings->social_login_location != 0)): ?>
                        <?php
                        if (file_exists($abs_us_root . $us_url_root . "usersc/views/_social_logins.php")) {
                            require_once $abs_us_root . $us_url_root . "usersc/views/_social_logins.php";
                        } else {
                            require_once $abs_us_root . $us_url_root . "users/views/_social_logins.php";
                        }
                        includeHook($hooks, 'bottom');
                        ?>
                    <?php endif; ?>

                    <?php if (!$awaitingTOTP && $showBottom) { ?>
                        <div class="row p-3">
                            <?php if ($showForgot) { ?>
                                <div class="<?= $bottomClass ?> <?= $forgotClass ?>">
                                    <a class="" href='<?= $us_url_root ?>users/forgot_password.php' style="text-decoration:none;">
                                        <i class="fa fa-wrench"></i> <?= lang("SIGNIN_FORGOTPASS") ?>
                                    </a>
                                </div>
                            <?php }

                            if ($settings->registration == 1) { ?>
                                <div class="<?= $bottomClass ?> <?= $regClass ?>">
                                    <a class="" href='<?= $us_url_root ?>users/join.php' style="text-decoration:none;">
                                        <i class="fa fa-plus-square"></i> <?= lang("SIGNUP_TEXT") ?>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>

                </div>
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

        <?php if ($awaitingTOTP): ?>
            setTimeout(function() {
                $('#totp_code').focus();
            }, 500);
        <?php else: ?>
            setTimeout(function() {
                $('#username').focus();
            }, 500);
        <?php endif; ?>

        <?php if ($allowPasswords): ?>
            const togglePassword = document.querySelector('#togglePassword');
            const togglePasswordIcon = document.querySelector('#togglePasswordIcon');
            const password = document.querySelector('#password');

            if (togglePassword && password) {
                togglePassword.addEventListener('click', function(e) {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);

                    if (type == "password") {
                        togglePasswordIcon.classList.add('fa-eye');
                        togglePasswordIcon.classList.remove('fa-eye-slash');
                    } else {
                        togglePasswordIcon.classList.add('fa-eye-slash');
                        togglePasswordIcon.classList.remove('fa-eye');
                    }
                });
            }
        <?php endif; ?>

        // Auto-format TOTP code inputs (digits only)
        const totpInputs = document.querySelectorAll('input[name="totp_code"]:not(#backup_code)');
        totpInputs.forEach(function(input) {
            input.addEventListener('input', function(e) {
                this.value = this.value.replace(/\D/g, '');
                if (this.value.length > 6) {
                    this.value = this.value.slice(0, 6);
                }
            });
        });

        // Format backup code input (alphanumeric with dash)
        const backupInput = document.getElementById('backup_code');
        if (backupInput) {
            backupInput.addEventListener('input', function(e) {
                let value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                if (value.length > 5) {
                    value = value.slice(0, 5) + '-' + value.slice(5, 10);
                }
                this.value = value;
            });
        }

        // Auto-submit TOTP form when 6 digits entered
        const mainTotpInput = document.getElementById('totp_code');
        if (mainTotpInput) {
            mainTotpInput.addEventListener('input', function(e) {
                if (this.value.length === 6) {
                    setTimeout(() => {
                        document.getElementById('totp-form').submit();
                    }, 500);
                }
            });
        }
    });

    function toggleBackupForm() {
        // Function kept for compatibility but no longer needed since backup form is always visible
    }
</script>

<?php if ($settings->passkeys == 1 && !$awaitingTOTP): ?>
    <script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
        function showPasskeyStatus(message, type = 'info') {
            const status = document.getElementById('passkeyStatus');
            if (!status) return;
            status.textContent = message;
            status.style.display = 'block';

            status.classList.remove('alert-info', 'alert-success', 'alert-danger', 'alert-warning');

            switch (type) {
                case 'success':
                    status.classList.add('alert-success');
                    break;
                case 'error':
                    status.classList.add('alert-danger');
                    break;
                case 'warning':
                    status.classList.add('alert-warning');
                    break;
                default:
                    status.classList.add('alert-info');
            }
        }

        function arrayBufferToBase64(buffer) {
            const bytes = new Uint8Array(buffer);
            let binary = '';
            for (let i = 0; i < bytes.byteLength; i++) {
                binary += String.fromCharCode(bytes[i]);
            }
            return btoa(binary);
        }

        function base64ToArrayBuffer(base64) {
            try {
                const paddedBase64 = base64.padEnd(base64.length + (4 - base64.length % 4) % 4, '=');
                const binary = atob(paddedBase64);
                const bytes = new Uint8Array(binary.length);
                for (let i = 0; i < binary.length; i++) {
                    bytes[i] = binary.charCodeAt(i);
                }
                return bytes.buffer;
            } catch (e) {
                console.error('Base64 decoding failed:', base64, e);
                throw new Error('Base64 decoding failed: ' + e.message);
            }
        }

async function authenticatePasskeyLogin() {
    showPasskeyStatus('Requesting authentication challenge...');
    try {
        const dest = '<?= $dest ?>';
        
        // First request - get challenge using POST
        const challengeData = {
            action: 'auth',
            csrf: '<?= Token::generate(); ?>'
        };
        
        const response = await fetch('auth/parsers/passkey_parser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(challengeData)
        });
        
        if (response.status !== 200) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.error || 'Failed to get auth challenge');
        }
        
        const publicKey = await response.json();
        
        if (!publicKey.success) {
            throw new Error(publicKey.error || 'Failed to get auth challenge');
        }

        const challengeOptions = {
            challenge: base64ToArrayBuffer(publicKey.challenge),
            rpId: publicKey.rpId,
            userVerification: publicKey.userVerification,
            timeout: publicKey.timeout
        };

        if (publicKey.allowCredentials && publicKey.allowCredentials.length > 0) {
            challengeOptions.allowCredentials = publicKey.allowCredentials.map(cred => ({
                ...cred,
                id: base64ToArrayBuffer(cred.id)
            }));
        }

        showPasskeyStatus('Waiting for your passkey...', 'info');

        const credential = await navigator.credentials.get({
            publicKey: challengeOptions
        });

        const authData = {
            action: 'verify',
            csrf: '<?= Token::generate(); ?>',
            credentialId: arrayBufferToBase64(credential.rawId),
            authenticatorData: arrayBufferToBase64(credential.response.authenticatorData),
            signature: arrayBufferToBase64(credential.response.signature),
            clientDataJSON: new TextDecoder().decode(credential.response.clientDataJSON),
            dest: dest
        };

        const verifyResponse = await fetch('auth/parsers/passkey_parser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(authData)
        });
        
        const result = await verifyResponse.json();

        if (result.success) {
            showPasskeyStatus('Login successful! Redirecting...', 'success');
            if (result.redirect) {
                window.location.href = result.redirect;
            } else {
                window.location.href = '<?= $us_url_root . $settings->redirect_uri_after_login ?>';
            }
        } else {
            showPasskeyStatus('Login failed: ' + (result.error || 'No matching passkey found or verification failed.'), 'error');
        }
    } catch (error) {
        console.error('Passkey Auth Error:', error);
        let errorMessage = 'Error: ' + error.message;
        if (error.name === 'NotAllowedError') {
            errorMessage = 'Passkey operation was cancelled or not allowed.';
        } else if (error.message === 'No passkey selected after 15 seconds') {
            errorMessage = 'No passkey was selected.';
        } else if (!navigator.credentials || !navigator.credentials.get) {
            errorMessage = 'Passkey authentication is not supported by your browser or platform.';
        }
        showPasskeyStatus(errorMessage, 'error');
    }
}
    </script>
<?php endif; ?>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>