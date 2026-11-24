<?php
// OAuth userinfo endpoint: send "Authorization: Bearer <access token>".
require_once '../init.php';
require_once $abs_us_root . $us_url_root . 'users/auth/userspice_oauth_provider.php';

if (!isset($settings->oauth_server) || $settings->oauth_server < 1) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'not_found']);
    exit;
}

$oauthProvider = new UserSpiceOAuthProvider();
if (Server::get('REQUEST_METHOD') === 'OPTIONS') {
    $oauthProvider->handleCorsPreflight();
}
$oauthProvider->handleUserInfoRequest();
