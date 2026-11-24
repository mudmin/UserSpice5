<?php
// 2026-11-10a — OAuth server columns.
// - client_id on codes and tokens becomes VARCHAR (client ids are 32-character
//   hex strings; INT stored only their leading digits), and codes.redirect_uri
//   becomes VARCHAR so the redirect URI is actually stored.
// - codes gain code_challenge / code_challenge_method for PKCE.
// - clients gain client_ver, public_client and ip_restrict_on, all 0 for
//   existing clients, so they keep their current behavior.
$countE = 0;

$oauthColumn = function ($table, $column) use ($db) {
    return $db->query(
        "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?",
        [$table, $column]
    )->first();
};

$oauthAlter = function ($sql) use ($db, &$countE) {
    $db->query($sql);
    if ($db->error()) {
        $countE++;
        logger(1, 'System Updates', '2026-11-10a: ' . $db->errorString());
    }
};

if ($oauthColumn('us_oauth_server_codes', 'id')) {
    // Outstanding codes live 10 minutes and can't match their client once the
    // type changes. Tokens are kept: they are looked up by token alone.
    $db->query("DELETE FROM us_oauth_server_codes");

    $col = $oauthColumn('us_oauth_server_codes', 'client_id');
    if ($col && $col->DATA_TYPE !== 'varchar') {
        $oauthAlter("ALTER TABLE us_oauth_server_codes MODIFY client_id VARCHAR(80) NOT NULL DEFAULT ''");
    }
    $col = $oauthColumn('us_oauth_server_codes', 'redirect_uri');
    if ($col && $col->DATA_TYPE !== 'varchar') {
        $oauthAlter("ALTER TABLE us_oauth_server_codes MODIFY redirect_uri VARCHAR(200) DEFAULT NULL");
    }
    if (!$oauthColumn('us_oauth_server_codes', 'code_challenge')) {
        $oauthAlter("ALTER TABLE us_oauth_server_codes ADD COLUMN code_challenge VARCHAR(128) DEFAULT NULL");
    }
    if (!$oauthColumn('us_oauth_server_codes', 'code_challenge_method')) {
        $oauthAlter("ALTER TABLE us_oauth_server_codes ADD COLUMN code_challenge_method VARCHAR(10) DEFAULT NULL");
    }
}

$col = $oauthColumn('us_oauth_server_tokens', 'client_id');
if ($col && $col->DATA_TYPE !== 'varchar') {
    $oauthAlter("ALTER TABLE us_oauth_server_tokens MODIFY client_id VARCHAR(80) NOT NULL DEFAULT ''");
}

if ($oauthColumn('us_oauth_server_clients', 'id')) {
    foreach (['client_ver', 'public_client', 'ip_restrict_on'] as $newCol) {
        if (!$oauthColumn('us_oauth_server_clients', $newCol)) {
            $oauthAlter("ALTER TABLE us_oauth_server_clients ADD COLUMN `$newCol` TINYINT(1) NOT NULL DEFAULT 0");
        }
    }
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
