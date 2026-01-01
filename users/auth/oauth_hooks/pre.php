<?php
// OAuth Pre Hook - executed before the login form
// This is where we can inject OAuth-specific styling, metadata, etc.

if (!isset($_SESSION[INSTANCE . '_oauth_flow_active'])) {
    return;
}

$oauthData = $_SESSION[INSTANCE . '_oauth_data'] ?? null;
$oauthClientData = $_SESSION[INSTANCE . '_oauth_client_data'] ?? null;

// Add OAuth-specific meta tags or styling
if ($oauthClientData) {
    ?>
    <style>
        /* OAuth-specific styling can go here */
        .oauth-branding {
            text-align: center;
            margin-bottom: 20px;
        }
        .oauth-client-name {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }
    </style>
    
    <script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
        // OAuth-specific JavaScript
        console.log('OAuth flow active for client: <?= htmlspecialchars($oauthClientData->client_name ?? 'Unknown') ?>');
    </script>
    <?php
}
?>