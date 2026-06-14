<?php
// 2026-05-25a — Drop the unused denormalized users.totp_enabled and
// users.passkey_enabled flags. TOTP/passkey "enabled" state is read from the
// authoritative tables (us_totp_secrets.verified and us_passkeys), so these
// columns are no longer written or read anywhere.
$countE = 0;

$db->query("ALTER TABLE `users` DROP COLUMN `totp_enabled`;");
$db->query("ALTER TABLE `users` DROP COLUMN `passkey_enabled`;");

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
