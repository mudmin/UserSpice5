<?php
// Migration: Seed us_menu_items.disabled for join / forgot_password / verify_resend
// based on the current settings.registration, settings.no_passwords, and email.email_act.
// After this one-time pass, the admin settings UIs keep these in sync.

$countE = $count = 0;

$settingsRow = $db->query("SELECT registration, no_passwords FROM settings WHERE id = 1")->first();
$emailRow    = $db->query("SELECT email_act FROM email WHERE id = 1")->first();

$registration = ($settingsRow && $settingsRow->registration == 1) ? 1 : 0;
$noPasswords  = ($settingsRow && $settingsRow->no_passwords > 0) ? 1 : 0;
$emailAct     = ($emailRow    && $emailRow->email_act   == 1) ? 1 : 0;

$joinDisabled        = $registration ? 0 : 1;
$forgotPwDisabled    = $noPasswords  ? 1 : 0;
$verifyResendDisabled = $emailAct    ? 0 : 1;

$db->query(
    "UPDATE us_menu_items SET disabled = ? WHERE link IN ('users/join.php','usersc/join.php')",
    [$joinDisabled]
);
$db->query(
    "UPDATE us_menu_items SET disabled = ? WHERE link IN ('users/forgot_password.php','usersc/forgot_password.php')",
    [$forgotPwDisabled]
);
$db->query(
    "UPDATE us_menu_items SET disabled = ? WHERE link IN ('users/verify_resend.php','usersc/verify_resend.php')",
    [$verifyResendDisabled]
);

$count++;

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
