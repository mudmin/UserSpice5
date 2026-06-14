<?php
// usersc/scripts/cloak_attempt.php
//
// This script runs at the very START of every cloak attempt — BEFORE any
// permission check — whenever an admin tries to cloak ("log in as") another
// user. It is the place to intercept cloaking with your own logic without
// writing a full event-hook plugin. (The cloakAttempt event hook fires here
// too, immediately before this script.)
//
// Variables available to you:
//   $cloak_target_id    (int)    The user id the admin is trying to cloak into.
//   $cloak_resume_url    (string) A one-time URL that resumes and COMPLETES
//                                this exact cloak. Pass it to forceReauth() so
//                                the admin lands back here, cloak intact, after
//                                step-up authentication.
//   $user                        The current (admin) user object.
//
// ---------------------------------------------------------------------------
// Example 1 — require step-up authentication before cloaking is allowed.
// The user re-proves their identity (password / TOTP / passkey / email /
// social, per their account) and is then returned here to finish the cloak.
// Within the reauth grace window (settings.reauth_timeout) they won't be
// asked again.
//
// forceReauth($cloak_resume_url, 'cloak');
//
// ---------------------------------------------------------------------------
// Example 1b — require a SPECIFIC method (or methods) instead of any. Pass
// 'methods' as a single name or an array. If the admin doesn't have that
// method set up, reauth shows e.g. "requires an authenticator app (TOTP),
// which is not set up on your account" rather than offering anything else.
// Valid names: 'password', 'totp', 'passkey', 'email', 'social'.
//
// forceReauth($cloak_resume_url, 'cloak', ['methods' => 'totp']);
// forceReauth($cloak_resume_url, 'cloak', ['methods' => ['totp', 'passkey']]);
//
// ---------------------------------------------------------------------------
// Example 2 — block this cloak attempt outright with your own rule.
//
// if (date('N') >= 6) { // weekends only, say
//   $cloak_attempt_block = true;
//   $cloak_attempt_error = 'Cloaking is disabled on weekends.';
// }
//
// ---------------------------------------------------------------------------
// Leave this file as-is (a no-op) if you don't need to intercept cloaking.
