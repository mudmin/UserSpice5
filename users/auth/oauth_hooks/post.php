<?php
// OAuth Post Hook - executed in the body of the login form
// This is where we can add OAuth-specific branding, messaging, etc.

if (!isset($_SESSION[INSTANCE . '_oauth_flow_active'])) {
    return;
}

$oauthData = $_SESSION[INSTANCE . '_oauth_data'] ?? null;
$oauthClientData = $_SESSION[INSTANCE . '_oauth_client_data'] ?? null;

if ($oauthClientData) {
    ?>
    <div class="oauth-branding mb-3">
        <?php if ($oauthClientData->login_title): ?>
            <div class="oauth-client-name"><?= htmlspecialchars($oauthClientData->login_title) ?></div>
        <?php endif; ?>
        
        <?php if ($oauthClientData->client_description): ?>
            <small class="text-muted"><?= htmlspecialchars($oauthClientData->client_description) ?></small>
        <?php endif; ?>
    </div>
    
    <!-- Hidden fields for OAuth flow -->
    <input type="hidden" name="oauth_client_id" value="<?= htmlspecialchars($oauthData['client_id'] ?? '') ?>">
    <input type="hidden" name="oauth_state" value="<?= htmlspecialchars($oauthData['state'] ?? '') ?>">
    <input type="hidden" name="oauth_redirect_uri" value="<?= htmlspecialchars($oauthData['redirect_uri'] ?? '') ?>">
    <!-- Server-side CSRF token for OAuth flow protection -->
    <?php
    require_once $abs_us_root . $us_url_root . 'users/includes/oauth_enforcement.php';
    $oauthCsrfToken = getOAuthCsrfToken();
    if ($oauthCsrfToken): ?>
    <input type="hidden" name="oauth_csrf_token" value="<?= htmlspecialchars($oauthCsrfToken) ?>">
    <?php endif; ?>
    <?php
}
?>