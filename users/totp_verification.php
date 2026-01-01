<?php
/*
UserSpice  - TOTP Verification Page
Standalone TOTP verification for users who have TOTP set up but haven't verified this session
*/
$noMaintenanceRedirect = true; 
require_once 'init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

require_once $abs_us_root . $us_url_root . 'users/includes/totp_enforcement.php';

// Redirect if not logged in
if (!$user->isLoggedIn()) {
    Redirect::to($us_url_root . 'users/login.php');
    exit;
}

$userId = $user->data()->id;

// Check if TOTP is enabled globally
if (!isset($settings->totp) || $settings->totp == 0) {
    Redirect::to($us_url_root . 'users/account.php');
    exit;
}
//if totp active and php >= 8.2.0
if($settings->totp > 0 && version_compare(PHP_VERSION, '8.2.0', '>=')) {
    require_once $abs_us_root . $us_url_root . 'users/auth/TOTPHandler.php';
}else{
    $settings->totp = 0; // Disable TOTP if not supported
    $currentSessionName = $config['session']['session_name'];
}

// Initialize TOTP handler
$siteName = isset($settings->site_name) ? $settings->site_name : 'UserSpice';
$totpHandler = new TOTPHandler($db, $siteName);

// Check if user actually has TOTP set up
if (!$totpHandler->isTOTPEnabled($userId)) {
    // User doesn't have TOTP set up but got here somehow
    // Redirect to setup if required, otherwise to account
    $totp_requirements = loadTotpRequirements($userId);
    $login_method = $_SESSION[INSTANCE . '_login_method'] ?? 'password';
    $totp_required = isTotpRequired($settings, $login_method, $totp_requirements, $userId);
    
    if ($totp_required) {
        Redirect::to($us_url_root . 'users/totp_management.php?setup_required=1');
    } else {
        Redirect::to(getTotpReturnUrl());
    }
    exit;
}

if (!empty($_GET['force_reverify']) && $_GET['force_reverify'] == '1') {
    if(isset($_SESSION[INSTANCE . '_totp_verified'])) {
        unset($_SESSION[INSTANCE . '_totp_verified']);
    }
}

// Check if already verified
if (isset($_SESSION[INSTANCE . '_totp_verified']) && $_SESSION[INSTANCE . '_totp_verified'] === true) {
    Redirect::to(getTotpReturnUrl());
    exit;
}

$errors = [];
$successes = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Token::check($_POST['csrf'])) {
        $errors[] = lang("CSRF_ERROR");
    } elseif (!validateRateLimit('totp_verify', $userId)) {
        $errors[] = getRateLimitErrorMessage('totp_verify');
    } else {
        $totpCode = Input::get('totp_code');
        $useBackup = !empty($_POST['use_backup_code']);
        
        if (empty($totpCode)) {
            $errors[] = "Please enter a verification code.";
            handleAuthFailure('totp_verify', $userId);
        } else {
            $verified = false;
            
            if ($useBackup) {
                // Verify backup code
                if ($totpHandler->verifyBackupCode($userId, $totpCode)) {
                    if ($totpHandler->invalidateBackupCode($userId, $totpCode)) {
                        $verified = true;
                        logger($userId, "TOTP_Verification", "Session verified using backup code");
                    } else {
                        $errors[] = lang("2FA_ERR_BACKUP_INVALIDATE_FAIL");
                        handleAuthFailure('totp_verify', $userId);
                    }
                } else {
                    $errors[] = lang("2FA_ERR_INVALID_BACKUP");
                    handleAuthFailure('totp_verify', $userId);
                }
            } else {
                // Verify TOTP code
                $userSecret = $totpHandler->getUserSecret($userId);
                if ($userSecret && $totpHandler->verifyCode($userSecret, $totpCode)) {
                    $verified = true;
                    logger($userId, "TOTP_Verification", "Session verified using authenticator app");
                } else {
                    $errors[] = lang("2FA_ERR_INVALID_CODE");
                    handleAuthFailure('totp_verify', $userId);
                }
            }
            
if ($verified) {
    handleAuthSuccess('totp_verify', $userId);
    markTotpVerified($userId);
    $successes[] = "Verification successful! Redirecting...";

    $nonce = htmlspecialchars($usespice_nonce ?? '', ENT_QUOTES, 'UTF-8');
    $redirect = htmlspecialchars(getTotpReturnUrl(), ENT_QUOTES, 'UTF-8');

    echo '<script nonce="' . $nonce . '">
        setTimeout(function () {
            window.location.href = "' . $redirect . '";
        }, 1500);
    </script>';
}

        }
    }
}

// Display any session messages
if (isset($_SESSION['totp_error_message'])) {
    $errors[] = $_SESSION['totp_error_message'];
    unset($_SESSION['totp_error_message']);
}

if (isset($_SESSION['totp_success_message'])) {
    $successes[] = $_SESSION['totp_success_message'];
    unset($_SESSION['totp_success_message']);
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="mb-0">
                        <i class="fa fa-shield-alt"></i> Two-Factor Authentication Required
                    </h3>
                </div>
                <div class="card-body">
                    <?php
                    // Display errors and successes
                    if (!empty($errors)) {
                        echo '<div class="alert alert-danger">';
                        foreach ($errors as $error) {
                            echo '<p class="mb-1">' . $error . '</p>';
                        }
                        echo '</div>';
                    }
                    
                    if (!empty($successes)) {
                        echo '<div class="alert alert-success">';
                        foreach ($successes as $success) {
                            echo '<p class="mb-1">' . $success . '</p>';
                        }
                        echo '</div>';
                    }
                    ?>
                    
                    <div class="text-center mb-4">
                        <i class="fa fa-mobile-alt fa-2x text-primary mb-3"></i>
                        <p class="lead">Please verify your identity to continue</p>
                        <p class="text-muted">Enter the 6-digit code from your authenticator app or use a backup code.</p>
                    </div>
                    
                    <!-- Main TOTP Form -->
                    <form method="POST" id="totp-form">
                        <?= tokenHere(); ?>
                        <div class="form-group mb-3">
                            <label for="totp_code" class="form-label">
                                <i class="fa fa-key"></i> Authentication Code
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg text-center" 
                                   id="totp_code" 
                                   name="totp_code" 
                                   required 
                                   autocomplete="off" 
                                   pattern="\d{6}" 
                                   maxlength="6" 
                                   placeholder="000000"
                                   autofocus>
                            <div class="form-text">Enter the 6-digit code from your authenticator app</div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fa fa-check"></i> Verify Code
                        </button>
                    </form>
                    
                    <!-- Backup Code Section -->
                    <div class="border-top pt-3">
                        <h6 class="mb-3">Having trouble with your authenticator?</h6>
                        <button type="button" class="btn btn-outline-secondary w-100 mb-3" onclick="toggleBackupForm()">
                            <i class="fa fa-key"></i> Use Backup Code Instead
                        </button>
                        
                        <div id="backup-form" style="display: none;">
                            <form method="POST">
                                <?= tokenHere(); ?>
                                <div class="form-group mb-3">
                                    <label for="backup_code" class="form-label">Backup Code</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="backup_code" 
                                           name="totp_code" 
                                           autocomplete="off" 
                                           placeholder="XXXXX-XXXXX" 
                                           maxlength="11"
                                           style="text-transform: uppercase;">
                                    <input type="hidden" name="use_backup_code" value="1">
                                    <div class="form-text">Enter one of your saved backup codes</div>
                                </div>
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fa fa-unlock"></i> Use Backup Code
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Help Links -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-muted mb-2">Need help?</p>
                        <a href="<?= $us_url_root ?>users/totp_management.php" class="btn btn-link btn-sm">
                            <i class="fa fa-cog"></i> Manage Two-Factor Authentication
                        </a>
                        <br>
                        <a href="<?= $us_url_root ?>users/logout.php" class="btn btn-link btn-sm text-danger">
                            <i class="fa fa-sign-out-alt"></i> Sign Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
document.addEventListener('DOMContentLoaded', function() {
    // Auto-format TOTP code input (digits only)
    const totpInput = document.getElementById('totp_code');
    if (totpInput) {
        totpInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
            if (this.value.length > 6) {
                this.value = this.value.slice(0, 6);
            }
            
            // Auto-submit when 6 digits entered
            if (this.value.length === 6) {
                setTimeout(() => {
                    document.getElementById('totp-form').submit();
                }, 500);
            }
        });
    }
    
    // Format backup code input
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
});

function toggleBackupForm() {
    const form = document.getElementById('backup-form');
    const isVisible = form.style.display !== 'none';
    form.style.display = isVisible ? 'none' : 'block';
    
    if (!isVisible) {
        setTimeout(() => {
            document.getElementById('backup_code').focus();
        }, 100);
    }
}
</script>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>