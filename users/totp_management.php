<?php
require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
//if totp active and php >= 8.2.0
if($settings->totp == 1 && version_compare(PHP_VERSION, '8.2.0', '>=')) {
    require_once $abs_us_root . $us_url_root . 'users/auth/TOTPHandler.php';
}else{
    $currentSessionName = $config['session']['session_name'];
}

if (!isset($user) || !$user->isLoggedIn()) {
    Redirect::to($us_url_root . 'users/login.php');
}

$userId = $user->data()->id;
$userEmail = $user->data()->email; // Get user's email for QR code

// Instantiate TOTPHandler if TOTP is enabled in site settings
$totpHandler = null;
$totpEnabledGlobally = false;
if (isset($settings->totp) && $settings->totp == 1) {
    $totpEnabledGlobally = true;

    $siteName = isset($settings->site_name) ? $settings->site_name : 'UserSpice';
    $totpHandler = new TOTPHandler($db, $siteName);
} else {
    usError(lang("EML_FEATURE_DISABLED"));
    Redirect::to($us_url_root . 'users/account.php');
    exit;
}

$errors = [];
$successes = [];

// TOTP Actions Handling
if ($totpHandler && !empty($_POST['totp_action'])) {
    if (!Token::check($_POST['csrf'])) {
        $_SESSION['totp_error_message'] = lang("CSRF_ERROR");
        Redirect::to('totp_management.php');
        exit;
    } else {
        $totpAction = Input::get('totp_action');
        $redirectUrl = 'totp_management.php#totp_management_section_anchor';

        switch ($totpAction) {
            case 'init_enable':
                $_SESSION['totp_secret'] = $totpHandler->generateSecret();
                $_SESSION['totp_setup_initiated'] = true;
                 // logger($userId, "TOTP_Setup", "Initiated TOTP setup process via totp_management.php.");
                Redirect::to($redirectUrl . '&totp_event=setup_initiated');
                break;

            case 'verify_and_activate':
                if (!validateRateLimit('totp_verify_and_activate', $userId)) {
                    $_SESSION['totp_error_message'] = getRateLimitErrorMessage('totp_verify_and_activate');
                    Redirect::to($redirectUrl);
                    exit;
                }
                
                if (isset($_SESSION['totp_secret']) && !empty(Input::get('totp_code'))) {
                    $secret = $_SESSION['totp_secret'];
                    $code = Input::get('totp_code');
                    if ($totpHandler->verifyCode($secret, $code)) {
                        $backupCodes = $totpHandler->generateBackupCodes();
                        if ($totpHandler->storeUserTOTP($userId, $secret, $backupCodes)) {
                            if ($totpHandler->activateUserTOTP($userId)) {
                                handleAuthSuccess('totp_verify_and_activate', $userId);
                                $_SESSION['totp_backup_codes_to_display'] = $backupCodes;
                                unset($_SESSION['totp_secret']);
                                unset($_SESSION['totp_setup_initiated']);
                                markTotpVerified($userId);                                
                                 // logger($userId, "TOTP_Setup", "TOTP enabled and verified successfully via totp_management.php.");
                                Redirect::to($redirectUrl . '&totp_success=1');
                            } else {
                                $_SESSION['totp_error_message'] = lang("2FA_FAIL");
                                handleAuthFailure('totp_verify_and_activate', $userId);
                                 // logger($userId, "TOTP_Error", "Failed to activate TOTP status for user after verification in totp_management.php.");
                                Redirect::to($redirectUrl . '&totp_error=activation_failed');
                            }
                        } else {
                            $_SESSION['totp_error_message'] = lang("2FA_FAIL");
                            handleAuthFailure('totp_verify_and_activate', $userId);
                             // logger($userId, "TOTP_Error", "Failed to store TOTP secret for user after verification in totp_management.php.");
                            Redirect::to($redirectUrl . '&totp_error=storage_failed');
                        }
                    } else {
                        $_SESSION['totp_error_message'] = lang("2FA_INV");
                        handleAuthFailure('totp_verify_and_activate', $userId);
                        Redirect::to($redirectUrl . '&totp_error=invalid_code&setup_initiated=1');
                    }
                } else {
                    $_SESSION['totp_error_message'] = lang("2FA_FAIL");
                    handleAuthFailure('totp_verify_and_activate', $userId);
                    unset($_SESSION['totp_secret']);
                    unset($_SESSION['totp_setup_initiated']);
                    Redirect::to($redirectUrl . '&totp_error=missing_data');
                }
                break;

            case 'disable':
                // Direct disable without password confirmation
                if ($totpHandler->disableTOTP($userId)) {
                    $_SESSION['totp_success_message'] = lang("REDIR_2FA_DIS");
                     // logger($userId, "TOTP_Setup", "TOTP disabled by user via totp_management.php.");
                    unset($_SESSION['totp_secret'], $_SESSION['totp_setup_initiated'], $_SESSION['totp_backup_codes_to_display']);
                } else {
                    $_SESSION['totp_error_message'] = lang("2FA_ERR_DISABLE_FAILED");
                     // logger($userId, "TOTP_Error", "DB error during TOTP disable for user in totp_management.php.");
                }
                Redirect::to($redirectUrl);
                break;

            case 'regenerate_backup_codes':
                if (!validateRateLimit('totp_regenerate_backup_codes', $userId)) {
                    $_SESSION['totp_error_message'] = getRateLimitErrorMessage('totp_regenerate_backup_codes');
                    Redirect::to($redirectUrl);
                    exit;
                }
                
                // Direct regeneration without password confirmation
                $userTotpRecord = $totpHandler->getUserRecord($userId);
                if ($userTotpRecord && $userTotpRecord->verified == 1) {
                    $newBackupCodes = $totpHandler->generateBackupCodes();
                    
                    // Hash the new backup codes
                    $hashedBackupCodes = [];
                    foreach ($newBackupCodes as $code) {
                        $hashedBackupCodes[] = password_hash($code, PASSWORD_DEFAULT, ['cost' => 10]);
                    }
                    $encodedNewBackupCodes = json_encode($hashedBackupCodes);
                    
                    $updateData = [
                        'backup_codes_h' => $encodedNewBackupCodes,
                        'updated_at' => date("Y-m-d H:i:s")
                    ];
                    
                    if ($db->update('us_totp_secrets', $userTotpRecord->id, $updateData)) {
                        handleAuthSuccess('totp_regenerate_backup_codes', $userId);
                        $_SESSION['totp_backup_codes_to_display'] = $newBackupCodes;
                        $_SESSION['backup_codes_regenerated_message'] = true;
                         // logger($userId, "TOTP_Setup", "Backup codes regenerated by user via totp_management.php.");
                        Redirect::to($redirectUrl . '&backup_regenerated=1');
                    } else {
                        $_SESSION['totp_error_message'] = lang("2FA_FAIL");
                        handleAuthFailure('totp_regenerate_backup_codes', $userId);
                         // logger($userId, "TOTP_Error", "DB error during backup code regeneration in totp_management.php: " . $db->errorString());
                    }
                } else {
                    $_SESSION['totp_error_message'] = lang("2FA_FAIL");
                    handleAuthFailure('totp_regenerate_backup_codes', $userId);
                }
                Redirect::to($redirectUrl);
                break;

            case 'acknowledge_backup_codes':
                unset($_SESSION['totp_backup_codes_to_display']);
                unset($_SESSION['backup_codes_regenerated_message']);
                $_SESSION['totp_success_message'] = lang("2FA_SUCCESS_BACKUP_ACK");
                Redirect::to($redirectUrl);
                break;

            case 'cancel_setup':
                unset($_SESSION['totp_secret']);
                unset($_SESSION['totp_setup_initiated']);
                $_SESSION['totp_success_message'] = lang("2FA_SUCCESS_SETUP_CANCELLED");
                Redirect::to($redirectUrl . '&totp_setup_cancelled=1');
                break;
        }
    }
}

// Clear action pending if user navigates away (no longer needed but keeping for safety)
if (isset($_SESSION['totp_action_pending'])) {
    unset($_SESSION['totp_action_pending'], $_SESSION['totp_form_action_url'], $_SESSION['totp_message_for_confirmation']);
}

// Determine current UI state for TOTP section
$isTOTPActiveForUser = $totpHandler && $totpHandler->isTOTPEnabled($userId);
$isTOTPSetupMode = $totpHandler && isset($_SESSION['totp_setup_initiated']) && $_SESSION['totp_setup_initiated'] === true && isset($_SESSION['totp_secret']);

// If setup was initiated via GET param and page reloaded with error, keep setup mode
if (!$isTOTPSetupMode && isset($_GET['setup_initiated']) && isset($_SESSION['totp_secret'])) {
    $isTOTPSetupMode = true;
    $_SESSION['totp_setup_initiated'] = true;
}

$shouldShowBackupCodes = $totpHandler && isset($_SESSION['totp_backup_codes_to_display']);

?>
<div class="container">
    <div class="row">
        <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
            <h1 class="text-center mt-4"><?= lang("ACCT_2FA") ?></h1>
            <div id="totp_management_section_anchor" class="mt-2 border bg-light p-3 p-md-4">
                <?php
                if (isset($_SESSION['totp_error_message'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['totp_error_message'] . '</div>';
                    unset($_SESSION['totp_error_message']);
                }
                if (isset($_SESSION['totp_success_message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['totp_success_message'] . '</div>';
                    unset($_SESSION['totp_success_message']);
                }
                echo resultBlock($errors, $successes);
                ?>

                <?php if ($shouldShowBackupCodes): ?>
                    <h4><?= isset($_SESSION['backup_codes_regenerated_message']) ? lang("2FA_SUCCESS_BACKUP_REGENERATED") : lang("2FA_SUCCESS_ENABLED_TITLE"); ?></h4>
                    <p><?= lang("2FA_SUCCESS_ENABLED_INFO") ?></p>
                    <div class="alert alert-warning"><strong><?= lang("GEN_IMPORTANT") ?>:</strong> <?= lang("2FA_BACKUP_CODES_WARNING") ?></div>
                    <ul class="list-group mb-3" style="columns: 2; -webkit-columns: 2; -moz-columns: 2;">
                        <?php foreach ($_SESSION['totp_backup_codes_to_display'] as $backupCode) : ?>
                            <li class="list-group-item"><code><?= hed($backupCode); ?></code></li>
                        <?php endforeach; ?>
                    </ul>
                    <form method="POST">
                        <?= tokenHere(); ?>
                        <input type="hidden" name="totp_action" value="acknowledge_backup_codes">
                        <button type="submit" class="btn btn-primary"><?= lang("2FA_DONE_BTN") ?></button>
                    </form>
                    <?php unset($_SESSION['backup_codes_regenerated_message']); ?>

                <?php elseif ($isTOTPSetupMode) :
                    $secret = $_SESSION['totp_secret'];
                    $qrCodeUrl = $totpHandler->getQRCodeImageDataUri($userEmail, $secret); // Using email instead of username
                ?>
                    <h4><?= lang("2FA_SETUP_TITLE") ?></h4>
                    <p><?= lang("2FA_SCAN") ?></p>
                    <div class="text-center mb-3"><img src="<?= $qrCodeUrl; ?>" alt="TOTP QR Code" class="img-fluid"></div>
                    <div class="mb-3">
                        <p><strong><?= lang("2FA_SECRET_KEY_LABEL") ?></strong></p>
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?= hed($secret); ?>" readonly id="totp-secret">
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('totp-secret')">
                                <i class="fa fa-copy"></i> Copy
                            </button>
                        </div>
                        <small class="text-muted"><?= lang("2FA_SK_ALT"); ?></small>
                    </div>
                    <form method="POST" class="totp-setup-form">
                        <?= tokenHere(); ?>
                        <input type="hidden" name="totp_action" value="verify_and_activate">
                        <div class="mb-3">
                            <label for="totp_code" class="form-label"><?= lang("2FA_SETUP_VERIFY_CODE_LABEL") ?></label>
                            <input type="text" class="form-control" id="totp_code" name="totp_code" required autocomplete="off" pattern="\d{6}" title="Enter a 6-digit code" maxlength="6">
                            <div class="form-text"><?= lang("2FA_VERIFY_INFO") ?></div>
                        </div>
                        <button type="submit" class="btn btn-primary"><?= lang("2FA_VERIFY_ACTIVATE_BTN") ?></button>
                        <a class="btn btn-secondary" href="<?=$us_url_root?>users/account.php"><?= lang("2FA_CANCEL_SETUP_BTN") ?></a>
               
                    </form>

                <?php elseif ($isTOTPActiveForUser): ?>
                    <div class="alert alert-success">
                        <i class="fa fa-shield-alt"></i> <strong><?= lang("2FA_IS_ENABLED") ?></strong>
                        <p class="mb-0 mt-2">You'll need your authenticator app or backup codes to sign in.</p>
                    </div>

                    <div class="d-grid gap-2 d-md-block">
                        <form method="POST" style="display:inline-block;">
                            <?= tokenHere(); ?>
                            <input type="hidden" name="totp_action" value="regenerate_backup_codes">
                            <?php 
                            $str = lang("2FA_INVALIDATE_WARNING");
                            ?>
                            <button type="submit" class="btn btn-warning" onclick="return confirm('<?= $str ?>')">
                                <i class="fa fa-refresh"></i> <?= lang("2FA_REGEN_CODES_BTN") ?>
                            </button>
                        </form>
                        <form method="POST" style="display:inline-block;">
                            <?php echo tokenHere(); 
                            $str = lang("2FA_CONF");
                            ?>
                            <input type="hidden" name="totp_action" value="disable">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('<?= $str ?>')">
                                <i class="fa fa-times-circle"></i> <?= lang("2FA_DISABLE_BTN") ?>
                            </button>
                        </form>
                    </div>

                <?php else: ?>
                    <div class="text-center">
                        <i class="fa fa-mobile-alt fa-3x text-muted mb-3"></i>
                        <h4><?= lang("2FA_NOT_ENABLED_INFO") ?></h4>
                        <p class="text-muted"><?= lang("2FA_NOT_ENABLED_EXPLAIN") ?></p>
                 
                    </div>
                    <form method="POST" class="text-center">
                        <?= tokenHere(); ?>
                        <input type="hidden" name="totp_action" value="init_enable">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa fa-shield-alt"></i> <?= lang("2FA_ENABLE_BTN") ?>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
            <?php if (Input::get('setup_required') != 1){ ?>
            <p class="text-center mt-3">
                <a href="<?= $us_url_root ?>users/account.php" class="btn btn-link">
                    <i class="fa fa-arrow-left"></i> <?= lang("GEN_BACK_TO_ACCT") ?>
                </a>
            </p>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(elementId) {
        const element = document.getElementById(elementId);
        element.select();
        element.setSelectionRange(0, 99999); // For mobile devices

        try {
            document.execCommand('copy');
            // Show success feedback
            const button = element.nextElementSibling;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fa fa-check"></i>';
            button.classList.remove('btn-outline-secondary');
            button.classList.add('btn-success');

            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-secondary');
            }, 2000);
        } catch (err) {
            console.error('Failed to copy text: ', err);
        }
    }

    // Auto-clear error and success messages
    document.addEventListener('DOMContentLoaded', function() {
        // Function to auto-hide alerts
        function autoHideAlert(alertElement, delay) {
            if (alertElement) {
                setTimeout(function() {
                    // Fade out effect
                    alertElement.style.transition = 'opacity 0.5s ease-in-out';
                    alertElement.style.opacity = '0';
                    
                    // Remove from DOM after fade
                    setTimeout(function() {
                        if (alertElement.parentNode) {
                            alertElement.parentNode.removeChild(alertElement);
                        }
                    }, 500);
                }, delay);
            }
        }
        
        // Auto-hide error messages after 10 seconds
        const errorAlerts = document.querySelectorAll('.alert-danger');
        errorAlerts.forEach(function(alert) {
            autoHideAlert(alert, 10000); // 10 seconds
        });
        
        // Auto-hide success messages after 5 seconds
        const successAlerts = document.querySelectorAll('.alert-success');
        successAlerts.forEach(function(alert) {
            // Don't auto-hide the "2FA is enabled" status alert
            if (!alert.textContent.includes('<?= lang("2FA_IS_ENABLED") ?>')) {
                autoHideAlert(alert, 5000); // 5 seconds
            }
        });
        
        // Auto-hide warning messages after 8 seconds
        const warningAlerts = document.querySelectorAll('.alert-warning');
        warningAlerts.forEach(function(alert) {
            // Don't auto-hide backup codes warning (important information)
            if (!alert.textContent.includes('<?= lang("2FA_BACKUP_CODES_WARNING") ?>')) {
                autoHideAlert(alert, 8000); // 8 seconds
            }
        });

        // Auto-format TOTP code input
        const totpInput = document.getElementById('totp_code');
        if (totpInput) {
            totpInput.addEventListener('input', function(e) {
                // Remove any non-numeric characters
                this.value = this.value.replace(/\D/g, '');
                // Limit to 6 digits
                if (this.value.length > 6) {
                    this.value = this.value.slice(0, 6);
                }
            });

            // Auto-submit when 6 digits are entered
            totpInput.addEventListener('input', function(e) {
                if (this.value.length === 6) {
                    // Small delay to allow user to see the complete code
                    setTimeout(() => {
                        this.form.submit();
                    }, 500);
                }
            });
        }
    });
</script>

<style>
    .totp-setup-form {
        border: 2px solid #28a745;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(40, 167, 69, 0.3);
        padding: 20px;
        background-color: #f8f9fa;
        animation: subtle-pulse 2s ease-in-out infinite alternate;
    }

    @keyframes subtle-pulse {
        0% {
            box-shadow: 0 0 15px rgba(40, 167, 69, 0.3);
        }

        100% {
            box-shadow: 0 0 20px rgba(40, 167, 69, 0.5);
        }
    }

    .totp-setup-form .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
</style>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>