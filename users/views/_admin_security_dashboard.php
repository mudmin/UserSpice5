<?php
// Load Rate Limits
require_once $abs_us_root . $us_url_root . 'users/includes/rate_limits.php';
if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/totp_requirements.php')) {
    include $abs_us_root . $us_url_root . 'usersc/includes/totp_requirements.php';
} else {
    include $abs_us_root . $us_url_root . 'users/includes/totp_requirements.php';
}

$secondWrite = Input::get('secondWrite');
if($secondWrite == "true"){
    Redirect::to($us_url_root . "users/admin.php?view=security");
}

// Check for default rate limits
$using_default_rate_limits = false;
if (isset($rateLimits['login_attempt']['ip_max']) && $rateLimits['login_attempt']['ip_max'] >= 10000) {
    $using_default_rate_limits = true;
}

// Get current versions and track info
$versionsQ = $db->query("SELECT * FROM us_versions WHERE id = 1");
$versions = $versionsQ->first();

$current_track = $settings->bleeding_edge;
$track_names = [0 => 'Stable', 1 => 'Bleeding Edge', 2 => 'Experimental'];
$track_colors = [0 => 'success', 1 => 'warning', 2 => 'danger'];

// Get PHP version info
$phpver = phpversion();
$parts = explode('.', $phpver);
$major_minor_version = $parts[0] . '.' . $parts[1];

//check if PHP version is known to have issues
$is_bad_php = ($db->query("SELECT version FROM us_php_known_bad WHERE `version` = ?", [$phpver])->count() > 0) ? true : false;

$eol_checkQ = $db->query("SELECT eol_date FROM us_php_eol WHERE release_version = ?", [$major_minor_version]);
$eol_checkC = $eol_checkQ->count();

$php_status = 'success';
$php_badge = '';
if ($eol_checkC > 0) {
    $eol_check = $eol_checkQ->first();
    $eol_date = strtotime($eol_check->eol_date);
    $today = strtotime(date("Y-m-d"));

    if ($today > $eol_date) {
        $php_status = 'danger';
        $php_badge = '<span class="badge bg-danger ms-2">EOL</span>';
    } elseif ($today > strtotime("-3 months", $eol_date)) {
        $php_status = 'warning';
        $php_badge = '<span class="badge bg-warning ms-2">EOL&nbsp;Soon</span>';
    }
}

// Passkey RP ID evaluation
$expected_rpid = fetchExpectedRPID();
$defined_rpid  = defined('PASSKEY_RP_ID') ? constant('PASSKEY_RP_ID') : null;
$rpid_status   = 'success';
$rpid_badge    = '<span class="badge bg-success">OK</span>';
$rpid_message  = '';
$show_write_button = false;

if ($defined_rpid === null) {
    $rpid_status  = 'danger';
    $rpid_badge   = '<span class="badge bg-danger ms-2">Not&nbsp;Defined</span>';
    $rpid_message = 'Passkeys cannot function until you define PASSKEY_RP_ID.';
    $show_write_button = true;
} elseif (is_array($defined_rpid)) {
    if (!in_array($expected_rpid, $defined_rpid, true)) {
        $rpid_status  = 'danger';
        $rpid_badge   = '<span class="badge bg-danger ms-2">Mismatch</span>';
        $rpid_message = 'Current host ' . $expected_rpid . ' is not present in your RP ID array.';
        $show_write_button = true;
    } elseif (count($defined_rpid) > 1) {
        $rpid_status  = 'warning';
        $rpid_badge   = '<span class="badge bg-warning ms-2">Multiple</span>';
        $rpid_message = 'Your RP ID array contains multiple domains. Ensure each entry is required.';
    }
} else {
    if ($defined_rpid !== $expected_rpid) {
        $rpid_status  = 'danger';
        $rpid_badge   = '<span class="badge bg-danger ms-2">Mismatch</span>';
        $rpid_message = 'Defined RP ID (' . $defined_rpid . ') does not match current host (' . $expected_rpid . ').';
        $show_write_button = true;
    }
}

// Check OAuth providers
$oauthProviders = 0;
$oauthFiles = ['facebook.php', 'google.php', 'github.php', 'twitter.php', 'linkedin.php'];
foreach ($oauthFiles as $file) {
    if (file_exists($abs_us_root . $us_url_root . 'users/classes/oauth/' . $file)) {
        $oauthProviders++;
    }
}

// Check email configuration
$email_configured = false;
$emailQ = $db->query("SELECT * FROM email WHERE id = 1");
if ($emailQ->count() > 0) {
    $email = $emailQ->first();
    $email_configured = (!empty($email->smtp_server) || !empty($email->email_login));
}

// Check security headers
function check_security_headers()
{
    // Dynamically verify that the outgoing response actually contains the headers

    $expected = [
        'x-frame-options'           => false,
        'x-content-type-options'    => false,
        'x-xss-protection'          => false,
        'strict-transport-security' => false,
        'referrer-policy'           => false,
    ];

    // headers_list() returns headers queued to be sent for this request
    foreach (headers_list() as $headerLine) {
        [$name, $value] = array_pad(explode(':', $headerLine, 2), 2, null);
        $name = strtolower(trim($name));
        if (isset($expected[$name])) {
            $expected[$name] = true;
        }
    }

    return $expected;
}

/**
 * Returns the site’s Content-Security-Policy status.
 *
 * @return array [
 * 'enforced'    => string|null, // the CSP header value if present
 * 'report_only' => string|null  // the CSP-RO header value if present
 * ]
 */
function detectCSP(): array
{
    $enforced    = null;
    $reportOnly  = null;

    foreach (headers_list() as $h) {
        if (stripos($h, 'Content-Security-Policy:') === 0) {
            $enforced = trim(substr($h, 24));              // 24 = strlen('Content-Security-Policy:')
        } elseif (stripos($h, 'Content-Security-Policy-Report-Only:') === 0) {
            $reportOnly = trim(substr($h, 34));            // 34 = strlen('Content-Security-Policy-Report-Only:')
        }
    }

    return ['enforced' => $enforced ?: null, 'report_only' => $reportOnly ?: null];
}
$cspInfo      = detectCSP();
$cspConfigured = !empty($cspInfo['enforced']) || !empty($cspInfo['report_only']);
$security_headers = check_security_headers();
$headers_configured = count(array_filter($security_headers));

// Handle write_rpid request
if (!empty($_POST) && isset($_POST['write_rpid'])) {
    if (!Token::check($_POST['csrf'])) {
        usError("Token failed");
        Redirect::to($us_url_root . "users/admin.php?view=security");
    }
    $result = writeRpidToInit($expected_rpid);
    if ($result) {
        logger($user->data()->id, 'Security', 'Updated PASSKEY_RP_ID to ' . $expected_rpid);
        usSuccess('PASSKEY_RP_ID written to users/init.php');
    } else {
        usError('Could not write PASSKEY_RP_ID automatically. Please edit users/init.php manually.');
    }
    Redirect::to($us_url_root . "users/admin.php?view=security&secondWrite=true");
}

// Function to write or update RP ID in users/init.php
function writeRpidToInit(string $rpid): bool
{
    global $abs_us_root, $us_url_root;
    $initFile = $abs_us_root . $us_url_root . 'users/init.php';

    if (!is_writable($initFile)) {
        return false;
    }

    $contents = file_get_contents($initFile);
    if ($contents === false) {
        return false;
    }

    $defineStatement = "define('PASSKEY_RP_ID', '" . addslashes($rpid) . "');";

    if (preg_match('/define\s*\(\s*["\']PASSKEY_RP_ID["\']\s*,/i', $contents)) {
        // Replace existing definition (first occurrence only)
        $newContents = preg_replace(
            '/define\s*\(\s*["\']PASSKEY_RP_ID["\']\s*,\s*[^;]*;?/i',
            $defineStatement,
            $contents,
            1
        );
    } else {
        // Insert after autoloader require
        $pattern = '/require_once\s*["\']classes\/class\.autoloader\.php["\']\s*;/i';
        if (preg_match($pattern, $contents)) {
            $newContents = preg_replace(
                $pattern,
                "$0\n\n// Passkey Relying Party ID\n{$defineStatement}",
                $contents,
                1
            );
        } else {
            // Fallback: append to the end of the file
            $newContents = $contents . "\n\n// Passkey Relying Party ID\n{$defineStatement}\n";
        }
    }

    return file_put_contents($initFile, $newContents) !== false;
}

// TOTP Configuration Checks
if (!function_exists('totp_is_crypto_available')) {
    require_once $abs_us_root . $us_url_root . 'users/includes/encryption.php';
}

$min_totp_php_version = '8.2.0';
$totpKeyFile = $abs_us_root . $us_url_root . 'usersc/includes/totp_key.php';
$totp_status = ['level' => 'success', 'messages' => []];

// 1. Check PHP Version
$phpver_ok = version_compare(phpversion(), $min_totp_php_version, '>=');
if (!$phpver_ok) {
    $totp_status['level'] = 'danger';
    $totp_status['messages'][] = "TOTP requires PHP version {$min_totp_php_version} or higher. Your version is " . phpversion() . ".";
}

// 2. Check for Crypto Backend (Sodium or OpenSSL)
$crypto_ok = totp_is_crypto_available();
if (!$crypto_ok && $phpver_ok) {
    $totp_status['level'] = 'danger';
    $totp_status['messages'][] = "No suitable encryption backend found. The 'sodium' extension or OpenSSL with AES-256-GCM support is required.";
}

// 3. Check Key File and Directory
$key_file_exists = file_exists($totpKeyFile);
$key_dir_writable = is_writable(dirname($totpKeyFile));
$key_valid = false;
$key_engine_info = '';

if ($key_file_exists) {
    try {
        @include $totpKeyFile;
        if (defined('TOTP_ENC_KEY')) {
            $key_valid = true;
            $currentEngine = totp_get_active_crypto_engine();
            $storedEngine = defined('TOTP_CRYPTO_ENGINE') ? TOTP_CRYPTO_ENGINE : 'unknown';
            $key_engine_info = "Key created with '{$storedEngine}'. Current server engine is '{$currentEngine}'.";
            if ($currentEngine !== $storedEngine && $storedEngine !== 'unknown') {
                $totp_status['messages'][] = ['text' => "Your server's crypto engine has changed. Existing TOTP secrets will be automatically re-encrypted on next use.", 'level' => 'info'];
            }
        } else {
            $totp_status['level'] = 'danger';
            $totp_status['messages'][] = "The key file <code>usersc/includes/totp_key.php</code> is invalid because it does not define <code>TOTP_ENC_KEY</code>. Please delete it and generate a new one.";
        }
    } catch (Exception $e) {
        $totp_status['level'] = 'danger';
        $totp_status['messages'][] = "Error loading key file: " . htmlspecialchars($e->getMessage());
    }
} else {
    if ($settings->totp > 0) {
        $totp_status['level'] = 'warning';
        $totp_status['messages'][] = "TOTP is enabled, but the encryption key file is missing.";
    }
}

// Handle TOTP key generation request
if (!empty($_POST) && isset($_POST['generate_totp_key'])) {
    if (!Token::check($_POST['csrf'])) {
        usError("Token failed");
        Redirect::to($us_url_root . "users/admin.php?view=security");
    }
    if (!$key_file_exists && $key_dir_writable) {
        if (totp_init_encryption($totpKeyFile, false)) {
            logger($user->data()->id, 'Security', 'Generated new TOTP encryption key.');
            usSuccess('Successfully generated TOTP encryption key file.');
        } else {
            usError('Could not generate the TOTP key file automatically.');
        }
    } else {
        usError('Cannot generate key file. It may already exist or the directory is not writable.');
    }
    Redirect::to($us_url_root . "users/admin.php?view=security#totp-config-card");
}


// Security toggles handler
if (!empty($_POST) && isset($_POST['toggle_security_setting'])) {
    if (!Token::check(Input::get('csrf'))) {
        usError("Token failed");
        Redirect::to($us_url_root . "users/admin.php?view=security");
    }
    $setting = Input::get('setting');
    $current_val = $settings->$setting;
    $new_val = ($current_val == 1) ? 0 : 1;

    // Some settings have special considerations
    $message = "Setting {$setting} updated.";
    if ($setting == 'no_passwords' && $new_val == 1) {
        $message = "Password logins disabled. Ensure other login methods (OAuth, Passkey, Email) are configured and working.";
    }
    if ($setting == 'force_ssl' && $new_val == 1) {
        $message = "Force HTTPS enabled. Ensure your SSL certificate is valid and properly configured.";
    }

    $db->update('settings', 1, [$setting => $new_val]);
    usSuccess($message);
    logger($user->data()->id, 'Security', "Toggled {$setting} to {$new_val}");
    Redirect::to($us_url_root . 'users/admin.php?view=security');
}

// Calculate overall security score
function calculateSecurityScore($settings, $php_status, $rpid_status, $email_configured, $headers_configured, $is_updated, $using_default_rate_limits)
{
    $score = 0;
    $max_score = 100;

    // HTTPS (15 points)
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') $score += 15;

    // PHP Version (10 points)
    if ($php_status === 'success') $score += 10;
    elseif ($php_status === 'warning') $score += 5;

    // UserSpice Up to Date (10 points)
    if ($is_updated) $score += 10;

    // Email configured (10 points)
    if ($email_configured) $score += 10;

    // Rate limiting customized (10 points)
    if (!$using_default_rate_limits) {
        $score += 10;
    }

    // Force SSL setting (10 points)
    if ($settings->force_ssl) $score += 10;

    // Passkey configuration (10 points)
    if ($rpid_status === 'success') $score += 10;
    elseif ($rpid_status === 'warning') $score += 5;

    // TOTP enabled (5 points)
    if ($settings->totp > 0) $score += 5;

    // Passkeys enabled (5 points)
    if ($settings->passkeys) $score += 5;

    // Email login available (5 points)
    if ($settings->email_login > 0) $score += 5;

    // Security headers (10 points)
    $score += ($headers_configured * 2);

    return min($score, $max_score);
}

$is_updated = version_compare($user_spice_ver, $versions->release_version, '>=');
$security_score = calculateSecurityScore($settings, $php_status, $rpid_status, $email_configured, $headers_configured, $is_updated, $using_default_rate_limits);
$score_color = $security_score >= 75 ? 'success' : ($security_score >= 60 ? 'warning' : 'danger');

// Build dynamic recommendations
$recommendations = [];

if (!$is_updated) {
    $recommendations[] = [
        'title' => 'Update UserSpice',
        'text' => "Your UserSpice version ({$user_spice_ver}) is outdated. Update to the latest version ({$versions->release_version}) for the newest features and security patches.",
        'link_text' => 'Go to Updates',
        'link_url' => $us_url_root . 'users/admin.php?view=updates'
    ];
}

if ($php_status !== 'success') {
    $rec_text = $php_status == 'danger'
        ? "Your PHP version ({$phpver}) is past its End-Of-Life and is no longer receiving security updates. This is a critical risk."
        : "Your PHP version ({$phpver}) is approaching its End-Of-Life. Plan to upgrade your server environment soon.";
    $recommendations[] = [
        'title' => 'Upgrade PHP Version',
        'text' => $rec_text,
        'link_text' => 'View PHP Info',
        'link_url' => $us_url_root . 'users/admin.php?view=phpinfo'
    ];
}

if (!$settings->force_ssl) {
    $recommendations[] = [
        'title' => 'Enable Force HTTPS',
        'text' => 'Your site is accessible via insecure HTTP. Forcing all traffic to HTTPS is essential for protecting user data.',
        'link_text' => 'Enable Now',
        'link_url' => '#',
        'modal' => 'confirm-force_ssl'
    ];
}

if (!$email_configured) {
    $recommendations[] = [
        'title' => 'Configure Email Settings',
        'text' => 'Email is not configured, which prevents critical functions like password resets and user notifications from working.',
        'link_text' => 'Configure Email',
        'link_url' => $us_url_root . 'users/admin.php?view=email'
    ];
}

if ($rpid_status !== 'success') {
    $recommendations[] = [
        'title' => 'Correct Passkey Configuration',
        'text' => 'The Passkey Relying Party ID (RP ID) is not configured correctly. This must be resolved for Passkeys to function. ' . $rpid_message,
        'link_text' => 'Review Configuration',
        'link_url' => '#passkey-config-card'
    ];
}

if ($headers_configured < 5) {
    $recommendations[] = [
        'title' => 'Add Missing Security Headers',
        'text' => "Your site is missing " . (5 - $headers_configured) . "/5 recommended security headers, which help protect against common attacks like clickjacking and XSS.",
        'link_text' => 'View Header Status',
        'link_url' => '#security-headers-card'
    ];
}

if ($using_default_rate_limits) {
    $recommendations[] = [
        'title' => 'Customize Your Rate Limits',
        'text' => 'Your site is using the default, insecure rate limits. Customizing these is crucial for protecting your site against brute-force attacks and other automated abuse.',
        'link_text' => 'Review Rate Limits',
        'link_url' => '#rate-limiting-card'
    ];
}

if ($settings->totp == 0) {
    $recommendations[] = [
        'title' => 'Enable Two-Factor Authentication (TOTP)',
        'text' => 'Two-factor authentication adds a critical layer of security to user accounts, requiring a code from an authenticator app to log in.',
        'link_text' => 'Enable TOTP',
        'link_url' => $us_url_root . 'users/admin.php?view=general#totp'
    ];
}

if (!$settings->passkeys) {
    $recommendations[] = [
        'title' => 'Enable Passkeys',
        'text' => 'Passkeys offer a modern, secure, and passwordless login method that is resistant to phishing. Enable this option for your users.',
        'link_text' => 'Enable Passkeys',
        'link_url' => $us_url_root . 'users/admin.php?view=general#passkeys'
    ];
}

if ($settings->debug > 0) {
    $debug_level = $settings->debug == 1 ? 'for Admins' : 'globally';
    $recommendations[] = [
        'title' => 'Disable Debug Mode',
        'text' => "Debug mode is currently active {$debug_level}. While useful for development, it can expose sensitive information and should be disabled on a live site.",
        'link_text' => 'Disable Debug Mode',
        'link_url' => $us_url_root . 'users/admin.php?view=general#debug'
    ];
}

?>

<style>
    .quick-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 1rem;
        border: 1px solid #dee2e6;
        border-radius: .375rem;
        height: 100%;
        transition: all 0.2s ease-in-out;
        text-decoration: none;
        color: inherit;
    }

    .quick-action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        color: inherit;
    }

    .quick-action-btn .icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .quick-action-btn .status {
        font-size: 0.8rem;
        font-weight: bold;
    }

    .security-metric {
        text-align: center;
        padding: 1rem;
    }

    .security-metric .metric-value {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 0.25rem;
    }

    .security-metric .metric-label {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .rate-limit-item {
        border-left: 3px solid #007bff;
        padding-left: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .rate-limit-value {
        font-family: 'Courier New', monospace;
        font-weight: bold;
        color: #0d6efd;
    }

    .recommendation-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
    }

    .recommendation-item:last-child {
        border-bottom: none;
    }

    .recommendation-icon {
        font-size: 1.5rem;
        margin-right: 1rem;
        width: 30px;
        text-align: center;
    }
</style>

<div class="row">
    <div class="col-12">
        <h2 class="mb-3">
            <i class="fas fa-shield-alt me-2"></i>Security Dashboard
            <span class="badge bg-<?= $score_color ?> ms-2"><?= $security_score ?>% Recommendations Met</span>
        </h2>
        <p class="mb-4">Monitor and manage your UserSpice security configuration. Use the quick actions below to toggle key features and review detailed information in the cards that follow.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i>Security Overview</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <div class="security-metric">
                            <div class="metric-value text-<?= $score_color ?>"><?= $security_score ?>%</div>
                            <div class="metric-label">Recommendations Met</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="security-metric">
                            <div class="metric-value text-<?= isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'success' : 'danger' ?>">
                                <?= isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'HTTPS' : 'HTTP' ?>
                            </div>
                            <div class="metric-label">Connection</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="security-metric">
                            <div class="metric-value text-<?= $php_status ?>"><?= $major_minor_version ?></div>
                            <div class="metric-label">PHP Version</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="security-metric">
                            <div class="metric-value text-<?= $headers_configured > 2 ? 'success' : ($headers_configured > 0 ? 'warning' : 'danger') ?>"><?= $headers_configured ?>/5</div>
                            <div class="metric-label">Security Headers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <a href="#" class="quick-action-btn" data-bs-toggle="modal" data-bs-target="#confirm-force_ssl">
                            <i class="icon fas fa-lock <?= $settings->force_ssl ? 'text-success' : 'text-danger' ?>"></i>
                            <span>Force HTTPS</span>
                            <span class="status <?= $settings->force_ssl ? 'text-success' : 'text-danger' ?>"><?= $settings->force_ssl ? 'ENABLED' : 'DISABLED' ?></span>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="#" class="quick-action-btn" data-bs-toggle="modal" data-bs-target="#confirm-email_login">
                            <i class="icon fas fa-envelope-open-text <?= $settings->email_login > 0 ? 'text-success' : 'text-danger' ?>"></i>
                            <span>Email Logins</span>
                            <span class="status <?= $settings->email_login > 0 ? 'text-success' : 'text-danger' ?>"><?= $settings->email_login > 0 ? 'ENABLED' : 'DISABLED' ?></span>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="#" class="quick-action-btn" data-bs-toggle="modal" data-bs-target="#confirm-no_passwords">
                            <i class="icon fas fa-key <?= $settings->no_passwords ? 'text-danger' : 'text-success' ?>"></i>
                            <span>Password Logins</span>
                            <span class="status <?= $settings->no_passwords ? 'text-danger' : 'text-success' ?>"><?= $settings->no_passwords ? 'DISABLED' : 'ENABLED' ?></span>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="<?= $us_url_root ?>users/admin.php?view=general#totp" class="quick-action-btn">
                            <i class="icon fas fa-mobile-alt <?= $settings->totp > 0 ? 'text-success' : 'text-warning' ?>"></i>
                            <span>Two-Factor Auth</span>
                            <span class="status <?= $settings->totp > 0 ? 'text-success' : 'text-warning' ?>">
                                <?= $settings->totp == 2 ? 'REQUIRED' : ($settings->totp == 1 ? 'OPTIONAL' : 'DISABLED') ?>
                            </span>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="<?= $us_url_root ?>users/admin.php?view=general#passkeys" class="quick-action-btn">
                            <i class="icon fas fa-fingerprint <?= $settings->passkeys ? 'text-success' : 'text-warning' ?>"></i>
                            <span>Passkeys</span>
                            <span class="status <?= $settings->passkeys ? 'text-success' : 'text-warning' ?>"><?= $settings->passkeys ? 'ENABLED' : 'DISABLED' ?></span>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="<?= $us_url_root ?>users/admin.php?view=updates" class="quick-action-btn">
                            <i class="icon fas fa-sync-alt <?= $is_updated ? 'text-success' : 'text-danger' ?>"></i>
                            <span>Update Status</span>
                            <span class="status <?= $is_updated ? 'text-success' : 'text-danger' ?>"><?= $is_updated ? 'UP TO DATE' : 'UPDATE AVAILABLE' ?></span>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="#" class="quick-action-btn" data-bs-toggle="modal" data-bs-target="#confirm-site_offline">
                            <i class="icon fas fa-tools <?= $settings->site_offline ? 'text-warning' : 'text-success' ?>"></i>
                            <span>Maintenance Mode</span>
                            <span class="status <?= $settings->site_offline ? 'text-warning' : 'text-success' ?>"><?= $settings->site_offline ? 'ACTIVE' : 'INACTIVE' ?></span>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="<?= $us_url_root ?>users/admin.php?view=general#debug" class="quick-action-btn">
                            <i class="icon fas fa-bug <?= $settings->debug > 0 ? 'text-warning' : 'text-success' ?>"></i>
                            <span>Debug Mode</span>
                            <span class="status <?= $settings->debug > 0 ? 'text-warning' : 'text-success' ?>">
                                <?= $settings->debug == 2 ? 'GLOBAL' : ($settings->debug == 1 ? 'ADMIN' : 'OFF') ?>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Actionable Security Recommendations</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($recommendations)) : ?>
                    <div class="text-center text-muted p-4">
                        <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                        <h6 class="text-success">All Recommendations Met!</h6>
                        <p class="mb-0">There are no outstanding security recommendations. Great job!</p>
                    </div>
                <?php else : ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recommendations as $rec) : ?>
                            <div class="list-group-item d-flex flex-column flex-md-row align-items-md-center">
                                <div class="me-3 mb-2 mb-md-0 text-danger"><i class="fas fa-exclamation-circle fa-2x"></i></div>
                                <div class="flex-grow-1">
                                    <strong class="mb-1"><?= $rec['title'] ?></strong>
                                    <p class="mb-0 text-muted small"><?= $rec['text'] ?></p>
                                </div>
                                <div class="mt-2 mt-md-0 ms-md-3">
                                    <a href="<?= $rec['link_url'] ?>" class="btn btn-sm btn-outline-primary" <?= isset($rec['modal']) ? 'data-bs-toggle="modal" data-bs-target="#' . $rec['modal'] . '"' : '' ?>>
                                        <i class="fas fa-arrow-right me-1"></i><?= $rec['link_text'] ?>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6">

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-sign-in-alt me-2"></i>Authentication Methods
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-8"><strong>Username/Password:</strong></div>
                    <div class="col-4 text-end">
                        <span class="badge bg-<?= $settings->no_passwords ? 'danger' : 'success' ?>">
                            <?= $settings->no_passwords ? 'Disabled' : 'Enabled' ?>
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-8"><strong>Email Magic Links/Codes:</strong></div>
                    <div class="col-4 text-end">
                        <span class="badge bg-<?= $settings->email_login > 0 ? 'success' : 'secondary' ?>">
                            <?= $settings->email_login > 0 ? 'Enabled' : 'Disabled' ?>
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-8"><strong>Passkeys (WebAuthn):</strong></div>
                    <div class="col-4 text-end">
                        <span class="badge bg-<?= $settings->passkeys ? 'success' : 'secondary' ?>">
                            <?= $settings->passkeys ? 'Enabled' : 'Disabled' ?>
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-8"><strong>Two-Factor (TOTP):</strong></div>
                    <div class="col-4 text-end">
                        <span class="badge bg-<?= $settings->totp == 2 ? 'danger' : ($settings->totp == 1 ? 'success' : 'secondary') ?>">
                            <?= $settings->totp == 2 ? 'Required' : ($settings->totp == 1 ? 'Optional' : 'Disabled') ?>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8"><strong>OAuth Providers:</strong></div>
                    <div class="col-4 text-end">
                        <span class="badge bg-<?= $oauthProviders > 0 ? 'success' : 'secondary' ?>">
                            <?= $oauthProviders ?> Available
                        </span>
                    </div>
                </div>
                <hr>
                <p class="small mb-0">
                    <strong>Security Recommendation:</strong> Enable multiple authentication methods for redundancy.
                    If disabling password logins, ensure at least one alternative method is properly configured and tested.
                </p>
            </div>
            <div class="card-footer">
                <a href="<?= $us_url_root ?>users/admin.php?view=general" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-cog me-1"></i>Configure Authentication
                </a>
            </div>
        </div>

        <div class="card mb-4 border-<?= $rpid_status ?>" id="passkey-config-card">
            <div class="card-header bg-<?= $rpid_status ?> text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-fingerprint me-2"></i>Passkey Configuration
                </h5>
            </div>
            <div class="card-body">
                <p><strong>Expected RP&nbsp;ID:</strong> <code><?= $expected_rpid ?></code></p>
                <?php if ($defined_rpid === null) : ?>
                    <p><strong>Configured RP&nbsp;ID:</strong> <span class="text-danger">Not defined</span> <?= $rpid_badge ?></p>
                <?php else : ?>
                    <p><strong>Configured RP&nbsp;ID:</strong> <code><?= is_array($defined_rpid) ? implode(', ', $defined_rpid) : $defined_rpid ?></code> <?= $rpid_badge ?></p>
                <?php endif; ?>

                <?php if ($rpid_message) : ?>
                    <div class="alert alert-<?= $rpid_status ?> mb-3 p-2 small"><?= $rpid_message ?></div>
                <?php endif; ?>

                <p class="small text-muted mb-2">The <strong>Relying Party ID (RP ID)</strong> is a critical security component. It must be the exact domain your users use to access the site, as it prevents phishing by tying a passkey to a specific domain.</p>

                <?php if ($show_write_button) : ?>
                    <form method="post" class="my-3">
                        <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                        <input type="hidden" name="write_rpid" value="1">
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-save me-1"></i>Write <code><?= $expected_rpid ?></code> to <code>users/init.php</code>
                        </button>
                    </form>
                <?php endif; ?>

                <h5>Understanding Your RP ID</h5>
                <p><strong>String vs. Array:</strong> For most sites, a single domain string (e.g., <code>'www.example.com'</code>) is all you need. An array can be used for advanced cases, like allowing passkeys to work across subdomains (e.g., <code>['login.example.com', 'app.example.com']</code>).</p>
                <div class="alert alert-warning p-2 small">
                    <i class="fas fa-exclamation-triangle me-2"></i><strong>Changing Domains:</strong> If you change your site's domain, existing passkeys will <strong>stop working</strong>. To migrate domains, you must first update the RP ID to be an array containing both the <strong>old and new</strong> domains. Once users have logged into the new domain, you can later remove the old one.
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= $us_url_root ?>users/admin.php?view=general#passkeys" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-cog me-1"></i>Configure Passkey Settings
                </a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-server me-2"></i>System Security Status
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-6"><strong>UserSpice Version:</strong></div>
                    <div class="col-sm-6 text-end"><span class="badge bg-<?= $is_updated ? 'success' : 'danger' ?>"><?= $user_spice_ver ?></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6"><strong>Update Track:</strong></div>
                    <div class="col-sm-6 text-end"><span class="badge bg-<?= $track_colors[$current_track] ?>"><?= $track_names[$current_track] ?></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6"><strong>Current UserSpice Release:</strong></div>
                    <div class="col-sm-6 text-end"><?= $versions->release_version; ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6"><strong>Current UserSpice Bleeding Edge Version</strong></div>
                    <div class="col-sm-6 text-end"><?= $versions->bleeding_edge; ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6"><strong>Current UserSpice Experimental Version</strong></div>
                    <div class="col-sm-6 text-end"><?= $versions->experimental; ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6"><strong>PHP Version:</strong></div>
                    <div class="col-sm-6 text-end">
                        <span class="text-<?= $php_status ?>"><?= $phpver ?></span>
                        <?= $php_badge ?>
                        <?php if ($is_bad_php) : ?><span class="badge bg-danger ms-2">Known Issues</span><?php endif; ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6"><strong>HTTPS Connection:</strong></div>
                    <div class="col-sm-6 text-end">
                        <?php if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') : ?>
                            <span class="badge bg-success">Active</span>
                        <?php else : ?>
                            <span class="badge bg-danger">Inactive</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6"><strong>Email Configuration:</strong></div>
                    <div class="col-sm-6 text-end">
                        <span class="badge bg-<?= $email_configured ? 'success' : 'warning' ?>">
                            <?= $email_configured ? 'Configured' : 'Not Configured' ?>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6"><strong>Security Headers:</strong></div>
                    <div class="col-sm-6 text-end">
                        <span class="badge bg-<?= $headers_configured > 2 ? 'success' : ($headers_configured > 0 ? 'warning' : 'danger') ?>">
                            <?= $headers_configured ?> of 5
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= $us_url_root ?>users/admin.php?view=updates" class="btn btn-sm btn-outline-primary me-2">
                    <i class="fas fa-sync-alt me-1"></i>Check Updates
                </a>
                <?php if (in_array($user->data()->id, $master_account) && hasPerm(2)) : ?>
                    <a href="<?= $us_url_root ?>users/admin.php?view=phpinfo" class="btn btn-sm btn-outline-info">
                        <i class="fas fa-info-circle me-1"></i>PHP Info
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Security Alerts
                </h5>
            </div>
            <div class="card-body">
                <?php
                $alerts = [];

                // Critical alerts
                if ($php_status == 'danger' || $is_bad_php) {
                    $alerts[] = [
                        'level' => 'danger',
                        'icon' => 'fas fa-exclamation-circle',
                        'title' => 'Critical PHP Issue',
                        'message' => "PHP version {$phpver} is insecure or has known issues. Upgrade immediately."
                    ];
                }

                if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
                    $alerts[] = [
                        'level' => 'danger',
                        'icon' => 'fas fa-lock-open',
                        'title' => 'Insecure Connection',
                        'message' => 'Site is not using HTTPS. This is a major security risk.'
                    ];
                }

                if ($rpid_status === 'danger') {
                    $alerts[] = [
                        'level' => 'danger',
                        'icon' => 'fas fa-fingerprint',
                        'title' => 'Passkey Configuration Error',
                        'message' => $rpid_message
                    ];
                }

                if ($using_default_rate_limits) {
                    $alerts[] = [
                        'level' => 'danger',
                        'icon' => 'fas fa-traffic-light',
                        'title' => 'Insecure Default Rate Limits',
                        'message' => 'Your site is using default rate limits which are too permissive for a production environment. This poses a security risk.'
                    ];
                }

                // Warning alerts
                if (!$is_updated) {
                    $alerts[] = [
                        'level' => 'danger',
                        'icon' => 'fas fa-sync-alt',
                        'title' => 'Update Available',
                        'message' => "Your UserSpice version ($user_spice_ver) is outdated. The latest is " . $versions->release_version . "."
                    ];
                }

                if ($php_status == 'warning') {
                    $alerts[] = [
                        'level' => 'warning',
                        'icon' => 'fas fa-clock',
                        'title' => 'PHP Version Warning',
                        'message' => "PHP version {$phpver} is approaching end-of-life. Plan to upgrade soon."
                    ];
                }

                if (!$email_configured) {
                    $alerts[] = [
                        'level' => 'warning',
                        'icon' => 'fas fa-envelope',
                        'title' => 'Email Not Configured',
                        'message' => 'Email settings are not configured. This affects password resets and notifications.'
                    ];
                }

                if ($settings->no_passwords && $settings->email_login == 0 && !$settings->passkeys && $oauthProviders == 0) {
                    $alerts[] = [
                        'level' => 'danger',
                        'icon' => 'fas fa-key',
                        'title' => 'No Login Methods Available',
                        'message' => 'Password logins are disabled but no alternative authentication methods are configured!'
                    ];
                }

                if ($headers_configured == 0) {
                    $alerts[] = [
                        'level' => 'warning',
                        'icon' => 'fas fa-shield-alt',
                        'title' => 'Missing Security Headers',
                        'message' => 'No security headers detected. Configure them in your web server.'
                    ];
                }

                if ($settings->debug > 1) {
                    $alerts[] = [
                        'level' => 'warning',
                        'icon' => 'fas fa-bug',
                        'title' => 'Debug Mode Active',
                        'message' => 'Debug mode is enabled for all users. This should only be temporary.'
                    ];
                }

                if($user_spice_ver == "5.9.3" || $user_spice_ver == "5.9.4") {
                    $alerts[] = [
                        'level' => 'success',
                        'icon' => 'fas fa-exclamation-triangle',
                        'title' => 'New Rate Limiting Dashboard',
                        'message' => 'Check out the new Rate Limiting Dashboard for better control over your site\'s security. <a href="' . $us_url_root . 'users/admin.php?view=rate_limits">Learn more</a>'
                    ];
                }



                if (empty($alerts)) : ?>
                    <div class="text-center text-muted p-3">
                        <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                        <h6 class="text-success">All Clear!</h6>
                        <p class="mb-0">No outstanding security alerts detected. Your security configuration looks good.</p>
                    </div>
                <?php else : ?>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <?php foreach ($alerts as $alert) : ?>
                            <div class="alert alert-<?= $alert['level'] ?> py-2 mb-2">
                                <i class="<?= $alert['icon'] ?> me-2"></i>
                                <strong><?= $alert['title'] ?>:</strong> <?= $alert['message'] ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($alerts)) : ?>
                <div class="card-footer">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Review and address these alerts to improve your security posture.
                    </small>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-12 col-md-6">

        <div class="card mb-4" id="totp-config-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-mobile-alt me-2"></i>Two-Factor Authentication (TOTP)
                </h5>
            </div>
            <div class="card-body">
                <p class="small mb-3">Time-based One-Time Passwords (TOTP) add a critical layer of security by requiring a second factor of authentication (a code from an app like Google Authenticator) to log in.</p>
                <h6>Configuration Status:</h6>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        PHP Version (<?= $min_totp_php_version ?>+ Required)
                        <?php if ($phpver_ok) : ?>
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Supported</span>
                        <?php else : ?>
                            <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Unsupported</span>
                        <?php endif; ?>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        Encryption Backend
                        <?php if ($crypto_ok) : ?>
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Ready (<?= totp_get_active_crypto_engine() ?>)</span>
                        <?php else : ?>
                            <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Unavailable</span>
                        <?php endif; ?>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        Encryption Key File
                        <?php if ($key_file_exists && $key_valid) : ?>
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Found & Valid</span>
                        <?php elseif ($key_file_exists && !$key_valid) : ?>
                            <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Invalid</span>
                        <?php else : ?>
                            <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-triangle me-1"></i>Missing</span>
                        <?php endif; ?>
                    </li>
                </ul>
                <?php foreach ($totp_status['messages'] as $msg) : ?>
                    <?php if (is_array($msg)) : ?>
                        <div class="alert alert-<?= $msg['level'] ?> p-2 small"><?= $msg['text'] ?></div>
                    <?php else : ?>
                        <div class="alert alert-<?= $totp_status['level'] ?> p-2 small"><?= $msg ?></div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if (!$key_file_exists && $key_dir_writable && $crypto_ok && $phpver_ok) : ?>
                    <div class="alert alert-info p-2 small">
                        The encryption key file is missing. UserSpice can create it for you now.
                    </div>
                    <form method="post" class="my-3">
                        <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                        <button type="submit" name="generate_totp_key" value="1" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-key me-1"></i>Generate TOTP Encryption Key
                        </button>
                    </form>
                <?php elseif (!$key_file_exists && !$key_dir_writable) : ?>
                    <div class="alert alert-danger p-2 small">
                        <strong>Action Required:</strong> The key file is missing and the directory <code>usersc/includes/</code> is <strong>not writable</strong>. Please create an empty, writable file named <code>totp_key.php</code> in this directory and try again, or adjust folder permissions.
                    </div>
                <?php endif; ?>
                <hr>
                <h5>TOTP Enforcement by Login Method</h5>
                <p class="small text-muted">
                    You can control which authentication methods will trigger a TOTP check for users who have it enabled. To customize these settings, copy the file from
                    <code>users/includes/totp_requirements.php</code> to <code>usersc/includes/totp_requirements.php</code> and edit the values to either <code>true</code> (enforce TOTP) or <code>false</code> (skip TOTP).
                </p>
                <div class="alert alert-warning p-2 small">
                    <strong><i class="fas fa-exclamation-triangle me-1"></i>Plugin Requirement:</strong> For OAuth plugins (e.g., Google, Facebook) to be properly controlled by this feature, you must be using the latest version of those plugins. Older versions will default to the behavior set for the 'password' login method.
                </div>
                <h6>Current Enforcement Status:</h6>
                <div class="row">
                    <?php
                    $login_methods = $totp_requirements['login_methods'] ?? [];
                    $half = ceil(count($login_methods) / 2);
                    $i = 0;
                    ?>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <?php foreach ($login_methods as $method => $is_enforced) : ?>
                                <?php if ($i < $half) : ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-1">
                                        <span class="text-capitalize"><?= htmlspecialchars($method) ?></span>
                                        <span class="badge bg-<?= $is_enforced ? 'success' : 'secondary' ?>"><?= $is_enforced ? 'Enforced' : 'Skipped' ?></span>
                                    </li>
                                <?php endif; ?>
                            <?php $i++;
                            endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <?php $i = 0; ?>
                            <?php foreach ($login_methods as $method => $is_enforced) : ?>
                                <?php if ($i >= $half) : ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-1">
                                        <span class="text-capitalize"><?= htmlspecialchars($method) ?></span>
                                        <span class="badge bg-<?= $is_enforced ? 'success' : 'secondary' ?>"><?= $is_enforced ? 'Enforced' : 'Skipped' ?></span>
                                    </li>
                                <?php endif; ?>
                            <?php $i++;
                            endforeach; ?>
                        </ul>
                    </div>
                </div>
                <h5>How TOTP Encryption Works</h5>
                <p class="small text-muted">For enhanced security, UserSpice encrypts all TOTP secrets before storing them in the database. This protection relies on a unique encryption key.</p>
                <div class="alert alert-secondary p-2 small">
                    <p class="mb-1"><strong>The Encryption Key File:</strong> A file is generated at <code>usersc/includes/totp_key.php</code> containing a unique, secret key (<code>TOTP_ENC_KEY</code>). This file is critical for TOTP functionality.</p>
                    <ul class="mb-0">
                        <li><strong>Do not share this file.</strong> Treat it like a password.</li>
                        <li><strong>Exclude it from Git.</strong> Add <code>usersc/includes/totp_key.php</code> to your <code>.gitignore</code> file to prevent it from being committed to a public repository.</li>
                    </ul>
                </div>
                <div class="alert alert-info p-2 small">
                    <p class="mb-1"><strong>Advanced Security (using .env):</strong> For the best security posture, especially in a production environment, you should not store secrets in files within your web root. After generating the key, consider moving the <code>define('TOTP_ENC_KEY', '...');</code> line from <code>totp_key.php</code> into your environment configuration (e.g., a <code>.env</code> file or server environment variables). Once you have confirmed it works, you can safely delete the <code>usersc/includes/totp_key.php</code> file.</p>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= $us_url_root ?>users/admin.php?view=general#totp" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-cog me-1"></i>Configure TOTP Settings
                </a>
            </div>
        </div>

        <div class="card mb-4" id="rate-limiting-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-traffic-light me-2"></i>Rate Limiting & Protection
                </h5>
            </div>
            <div class="card-body">
                <p class="small mb-3">Rate limiting protects against brute-force attacks and abuse. Key limits are shown below:</p>
                <div class="rate-limit-item">
                    <div><strong>Login Attempts (by IP)</strong></div>
                    <div class="small text-muted">Maximum failed login attempts from a single IP address</div>
                    <div class="rate-limit-value"><?= $rateLimits['login_attempt']['ip_max'] ?? 'N/A' ?> attempts / <?= ($rateLimits['login_attempt']['ip_window'] ?? 0) / 60 ?> minutes</div>
                </div>
                <div class="rate-limit-item">
                    <div><strong>Login Attempts (by User)</strong></div>
                    <div class="small text-muted">Maximum failed login attempts for a single account</div>
                    <div class="rate-limit-value"><?= $rateLimits['login_attempt']['user_max'] ?? 'N/A' ?> attempts / <?= ($rateLimits['login_attempt']['user_window'] ?? 0) / 60 ?> minutes</div>
                </div>
                <div class="rate-limit-item">
                    <div><strong>Password Reset Requests</strong></div>
                    <div class="small text-muted">Maximum password reset requests from a single IP</div>
                    <div class="rate-limit-value"><?= $rateLimits['password_reset_request']['ip_max'] ?? 'N/A' ?> requests / <?= ($rateLimits['password_reset_request']['ip_window'] ?? 0) / 60 ?> minutes</div>
                </div>
                <div class="rate-limit-item">
                    <div><strong>Registration Attempts</strong></div>
                    <div class="small text-muted">Maximum registration attempts from a single IP</div>
                    <div class="rate-limit-value"><?= $rateLimits['registration_attempt']['ip_max'] ?? 'N/A' ?> attempts / <?= ($rateLimits['registration_attempt']['ip_window'] ?? 0) / 60 ?> minutes</div>
                </div>
                <hr>
                <?php if ($using_default_rate_limits) : ?>
                    <div class="alert alert-danger p-2">
                        <strong>Warning: Default Rate Limits are Insecure!</strong><br>
                        <p class="mb-1">Your current rate limits are set to the default, extremely permissive values. These are not suitable for a production environment and should be customized immediately to protect against brute-force attacks.</p>
                        <p class="mb-0 small">Please edit <code>usersc/includes/rate_limits.php</code> to lower the values. The comments in the file provide guidance on setting appropriate limits.</p>
                    </div>
                <?php else : ?>
                    <div class="alert alert-success p-2">
                        <strong><i class="fas fa-check-circle me-1"></i>Rate Limits Customized</strong><br>
                        <p class="mb-0">Your rate limits appear to be customized from the insecure defaults. <a href="<?= $us_url_root ?>users/admin.php?view=rate_limits">Review them periodically</a> to ensure they meet your site's specific security needs.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer">
                <a href="<?= $us_url_root ?>users/admin.php?view=rate_limits" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-list me-1"></i>Manage Rate Limits
                </a>
            </div>
        </div>

        <div class="card mb-4" id="security-headers-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-globe me-2"></i>Security Headers
                </h5>
            </div>
            <div class="card-body">
                <p class="small mb-3">
                    Security headers protect against common web vulnerabilities.
                    Configure these in your web-server vhost or <code>.htaccess</code>.
                </p>
                <?php foreach ($security_headers as $header => $enabled) : ?>
                    <div class="row mb-2 align-items-center">
                        <div class="col-8">
                            <strong><?= htmlspecialchars($header) ?></strong>
                            <?php
                            $descriptions = [
                                'x-frame-options'           => 'Prevents clickjacking attacks',
                                'x-content-type-options'    => 'Stops MIME-type sniffing',
                                'x-xss-protection'          => 'Legacy XSS filter (obsolete)',
                                'strict-transport-security' => 'Forces HTTPS (HSTS)',
                                'referrer-policy'           => 'Controls referrer leakage',
                            ];
                            ?>
                            <div class="small text-muted"><?= $descriptions[strtolower($header)] ?? '' ?></div>
                        </div>
                        <div class="col-4 text-end">
                            <span class="badge bg-<?= $enabled ? 'success' : 'danger' ?>">
                                <?= $enabled ? 'Set' : 'Missing' ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="row mb-3 align-items-center">
                    <div class="col-8">
                        <strong>Content Security Policy</strong>
                        <div class="small text-muted">Defines what sources the browser may load.</div>
                    </div>
                    <div class="col-4 text-end">
                        <span class="badge bg-<?= $cspConfigured ? 'success' : 'danger' ?>">
                            <?= $cspConfigured ? 'Enabled' : 'Missing' ?>
                        </span>
                    </div>
                </div>
                <?php if (!$cspConfigured) : ?>
                    <div class="alert alert-warning small">
                        <strong>No CSP detected.</strong> UserSpice cannot safely auto-generate
                        one, because every site loads different scripts, images, and
                        third-party assets.
                        <br>Begin with
                        <code>Content-Security-Policy-Report-Only</code>, review the violations,
                        then enforce the policy once you’re confident nothing breaks.
                    </div>
                <?php else : ?>
                    <p class="small mb-3">
                        <?= $cspInfo['enforced']
                            ? 'Your policy is enforced.'
                            : 'Policy is currently in <code>report-only</code> mode.' ?>
                    </p>
                <?php endif; ?>
                <div class="alert alert-info p-2">
                    <strong>Example <code>.htaccess</code> snippet:</strong>
                    <pre class="mt-2 mb-0" style="font-size: .8rem;"><code>Header always set X-Frame-Options "SAMEORIGIN"
Header always set X-Content-Type-Options "nosniff"
Header always set Strict-Transport-Security "max-age=31536000"
Header always set Referrer-Policy "no-referrer-when-downgrade"</code></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function generate_confirmation_modal($id, $title, $message, $setting_name, $settings)
{
    $current_val = $settings->$setting_name;
    $action_text = $current_val ? "Disable" : "Enable";
    $btn_class = $current_val ? 'danger' : 'success';
?>
    <div class="modal fade" id="confirm-<?= $id ?>" tabindex="-1" aria-labelledby="confirm-<?= $id ?>-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirm-<?= $id ?>-label">Confirm: <?= $action_text ?> <?= $title ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-<?= $btn_class == 'danger' ? 'warning' : 'info' ?>" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?= $message ?>
                    </div>
                    <p><strong>Are you sure you want to <?= strtolower($action_text) ?> this feature?</strong></p>
                    <?php if ($setting_name == 'no_passwords' && !$current_val) : ?>
                        <div class="alert alert-danger">
                            <strong>Warning:</strong> Before disabling password logins, ensure you have tested alternative login methods.
                            If you disable passwords without working alternatives, you may lock yourself out of the system.
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <form action="" method="post">
                        <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                        <input type="hidden" name="setting" value="<?= $setting_name ?>">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="toggle_security_setting" class="btn btn-<?= $btn_class ?>">
                            <i class="fas fa-<?= $current_val ? 'times' : 'check' ?> me-1"></i><?= $action_text ?> Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }

generate_confirmation_modal(
    'force_ssl',
    'Force HTTPS',
    'This will redirect all insecure (HTTP) requests to secure (HTTPS) connections. Ensure your SSL certificate is valid and properly configured before enabling this feature.',
    'force_ssl',
    $settings
);

generate_confirmation_modal(
    'email_login',
    'Email Logins',
    'This allows users to log in without a password by clicking a link or entering a code sent to their email. Your email configuration must be working properly for this feature to function.',
    'email_login',
    $settings
);

generate_confirmation_modal(
    'no_passwords',
    'Password Logins',
    'This will completely disable username/password authentication. Users will only be able to log in via configured alternative methods (OAuth, Passkeys, Email Magic Links).',
    'no_passwords',
    $settings
);

generate_confirmation_modal(
    'site_offline',
    'Maintenance Mode',
    'This will make your site inaccessible to all non-administrative users. They will see a maintenance page instead of your normal site content.',
    'site_offline',
    $settings
);
?>