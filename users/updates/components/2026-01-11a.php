<?php
// Migration: Add HMAC response signature support for OAuth
// Adds response_secret field to both server and client tables for secure response verification

$countE = $count = 0;

// Add response_secret to OAuth server clients table
// This secret is used to sign the response data sent to the client
$db->query("ALTER TABLE us_oauth_server_clients ADD COLUMN response_secret VARCHAR(64) DEFAULT NULL");

// Add response_secret to OAuth client login options table
// This secret is used to verify the signature of response data received from the server
$db->query("ALTER TABLE us_oauth_client_login_options ADD COLUMN response_secret VARCHAR(64) DEFAULT NULL");

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
