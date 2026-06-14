<?php
// This is a user-facing page
/*
UserSpice
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

// Core ReAuth (step-up authentication). Reached via forceReauth() — the user
// is already logged in and is asked to prove their identity again using
// whatever methods login.php would accept for their account.
require_once '../users/init.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Must already be logged in — there is nothing to "re-auth" otherwise.
if (!isset($user) || !$user->isLoggedIn()) {
    Redirect::to($us_url_root . 'users/login.php');
}

// When an admin is cloaked into another user, the human re-authenticating is
// the admin (cloak_from), NOT the impersonated account (cloak_to). Verify the
// real operator's credentials/methods.
$uid = realUserId();
$rk  = Config::get('session/session_name') . '_reauth';
if (!isset($_SESSION[$rk]) || !is_array($_SESSION[$rk])) {
    $_SESSION[$rk] = [];
}

$dest        = $_SESSION[$rk]['dest'] ?? '';
$purpose     = $_SESSION[$rk]['purpose'] ?? '';
$timeout     = isset($_SESSION[$rk]['timeout']) ? (int) $_SESSION[$rk]['timeout'] : null;
$defaultDest = Config::get('homepage') ?: ($us_url_root . 'users/account.php');

// Clears transient reauth state and returns the user where they were headed.
$reauthFinish = function () use ($rk, $dest, $defaultDest) {
    unset(
        $_SESSION[$rk]['dest'],
        $_SESSION[$rk]['purpose'],
        $_SESSION[$rk]['timeout'],
        $_SESSION[$rk]['methods'],
        $_SESSION[$rk]['email'],
        $_SESSION[$rk]['fails']
    );
    if (!empty($dest)) {
        Redirect::sanitized($dest);
    }
    Redirect::to($defaultDest);
};

// Already inside the grace window — no need to ask again.
if (reauthConfirmed($timeout)) {
    $reauthFinish();
}

// A caller can force reauth to specific method(s) via forceReauth()'s 'methods'
// option (stored in the session). When set, only those are offered — and the
// TOTP gate is relaxed so a forced 'totp' works for any user who has TOTP set
// up. Unknown names are filtered out here and in reauthMethods().
$forced = array_values(array_intersect(
    (array) ($_SESSION[$rk]['methods'] ?? []),
    ['password', 'totp', 'passkey', 'email', 'social']
));
$methods = reauthMethods($uid, $forced);

$forcedUnavailable = '';
if (empty($methods)) {
    if (!empty($forced)) {
        // A specific method was required but isn't set up for this user. Show an
        // explanatory message with only the logout link — do NOT fall back to a
        // full login (that would defeat forcing the method) and do NOT return to
        // $dest (that page would just re-trigger reauth in a loop).
        $methodLabels = [
            'password' => 'your password',
            'totp'     => 'an authenticator app (TOTP)',
            'passkey'  => 'a passkey',
            'email'    => 'email verification',
            'social'   => 'social login',
        ];
        $need = [];
        foreach ($forced as $m) {
            $need[] = $methodLabels[$m] ?? $m;
        }
        $forcedUnavailable = 'This action requires ' . implode(' or ', $need)
            . ', which is not set up on your account. Please contact an administrator.';
    } else {
        // The user is logged in but has no inline verification method available
        // (e.g. passwords disabled and no TOTP/passkey/email/social). The
        // universal fallback is a full fresh login.
        usError(lang('REAUTH_RELOGIN') ?: 'Please log in again to continue.');
        Redirect::to($us_url_root . 'users/logout.php');
    }
}

// TOTP handler is only needed — and only safe to load — when TOTP is offered.
$totpHandler = null;
if (in_array('totp', $methods, true)) {
    require_once $abs_us_root . $us_url_root . 'users/auth/TOTPHandler.php';
    $totpHandler = new TOTPHandler($db, $settings->site_name ?: 'UserSpice');
}

// Active OAuth clients, for the social reauth option. The OAuth round-trip
// (oauth_request.php / oauth_response.php) confirms the returned identity
// matches this logged-in user — see the reauth branch in oauth_response.php.
$oauthClients = [];
if (in_array('social', $methods, true)) {
    $oauthClients = $db->query(
        "SELECT id, client_name, login_title FROM us_oauth_client_login_options
         WHERE oauth = 1 ORDER BY client_name ASC"
    )->results();
}

$errors = $successes = [];
if ($forcedUnavailable !== '') {
    $errors[] = $forcedUnavailable;
}

if (!empty($_POST)) {
    if (!Token::check(Input::get('csrf'))) {
        $errors[] = '<strong>CSRF Error:</strong> Security token missing or invalid. Please try again.';
    } else {
        $action = Input::get('reauth_action');
        $fails  = $_SESSION[$rk]['fails'] ?? 0;

        if ($action === 'password' && in_array('password', $methods, true)) {
            $pw = trim(Input::get('reauth_password'));
            $u  = $db->query("SELECT password FROM users WHERE id = ?", [$uid])->first();
            if ($u && !empty($u->password) && password_verify($pw, $u->password)) {
                recordReauth($uid, 'password', $purpose, 1);
                reauthMarkConfirmed();
                $reauthFinish();
            } else {
                $_SESSION[$rk]['fails'] = ++$fails;
                recordReauth($uid, 'password', $purpose, 0);
                $errors[] = lang('REAUTH_BAD_PASSWORD') ?: 'Incorrect password.';
            }

        } elseif ($action === 'totp' && $totpHandler) {
            $code      = trim(Input::get('reauth_totp'));
            $useBackup = !empty($_POST['use_backup_code']);
            $ok        = false;
            if ($useBackup) {
                if ($totpHandler->verifyBackupCode($uid, $code)
                    && $totpHandler->invalidateBackupCode($uid, $code)) {
                    $ok = true;
                }
            } else {
                $secret = $totpHandler->getUserSecret($uid);
                if ($secret && $totpHandler->verifyCode($secret, $code)) {
                    $ok = true;
                }
            }
            if ($ok) {
                recordReauth($uid, $useBackup ? 'totp_backup' : 'totp', $purpose, 1);
                reauthMarkConfirmed();
                $reauthFinish();
            } else {
                $_SESSION[$rk]['fails'] = ++$fails;
                recordReauth($uid, 'totp', $purpose, 0);
                $errors[] = lang('2FA_ERR_INVALID_CODE') ?: 'Invalid authentication code.';
            }

        } elseif ($action === 'email_send' && in_array('email', $methods, true)) {
            $u = $db->query("SELECT email FROM users WHERE id = ?", [$uid])->first();
            if ($u && !empty($u->email)) {
                $code     = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $siteName = $settings->site_name ?: 'UserSpice';
                $subject  = $siteName . ' - ' . (lang('REAUTH_EMAIL_SUBJECT') ?: 'Verification code');
                $body     = '<p>' . (lang('REAUTH_EMAIL_BODY') ?: 'Your verification code is:') . '</p>'
                    . '<p style="font-size:28px;font-weight:bold;letter-spacing:4px;">' . $code . '</p>'
                    . '<p>' . (lang('REAUTH_EMAIL_EXPIRE')
                        ?: 'This code expires in 10 minutes. If you did not request it, you can ignore this email.')
                    . '</p>';
                if (email($u->email, $subject, $body)) {
                    $_SESSION[$rk]['email'] = [
                        'hash'     => password_hash($code, PASSWORD_DEFAULT),
                        'expires'  => time() + 600,
                        'attempts' => 0,
                    ];
                    $successes[] = lang('REAUTH_EMAIL_SENT') ?: 'We emailed you a 6-digit code.';
                } else {
                    $errors[] = lang('REAUTH_EMAIL_FAIL')
                        ?: 'We could not send the email. Please try another method.';
                }
            }

        } elseif ($action === 'email_verify' && in_array('email', $methods, true)) {
            $pending = $_SESSION[$rk]['email'] ?? null;
            $code    = trim(Input::get('reauth_email_code'));
            if (!$pending) {
                $errors[] = lang('REAUTH_EMAIL_NONE') ?: 'Please request a code first.';
            } elseif (time() > $pending['expires']) {
                unset($_SESSION[$rk]['email']);
                $errors[] = lang('REAUTH_EMAIL_EXPIRED') ?: 'That code has expired. Please request a new one.';
            } elseif ($pending['attempts'] >= 5) {
                unset($_SESSION[$rk]['email']);
                $errors[] = lang('REAUTH_EMAIL_TOOMANY') ?: 'Too many attempts. Please request a new code.';
            } elseif (password_verify($code, $pending['hash'])) {
                recordReauth($uid, 'email', $purpose, 1);
                reauthMarkConfirmed();
                $reauthFinish();
            } else {
                $_SESSION[$rk]['email']['attempts']++;
                $_SESSION[$rk]['fails'] = ++$fails;
                recordReauth($uid, 'email', $purpose, 0);
                $errors[] = lang('REAUTH_EMAIL_BAD') ?: 'Incorrect code.';
            }
        }

        // Hard stop after too many failed attempts in this session.
        if (($_SESSION[$rk]['fails'] ?? 0) >= 10) {
            recordReauth($uid, 'lockout', $purpose, 0);
            usError(lang('REAUTH_LOCKED') ?: 'Too many failed attempts. Please log in again.');
            Redirect::to($us_url_root . 'users/logout.php');
        }
    }
}

$emailPending = !empty($_SESSION[$rk]['email']);

require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-7 col-lg-5">
      <div class="card shadow-sm">
        <div class="card-header text-center">
          <i class="fa fa-shield-alt fa-lg text-primary"></i>
          <strong class="ms-2"><?= safeReturn(lang('REAUTH_TITLE') ?: "Confirm it's you") ?></strong>
        </div>
        <div class="card-body p-4">
          <p class="text-body-secondary text-center">
            <?= safeReturn(lang('REAUTH_INTRO')
                ?: 'For your security, please verify your identity to continue.') ?>
          </p>

          <?= resultBlock($errors, $successes); ?>

          <?php $first = true; ?>

          <?php if (in_array('password', $methods, true)): ?>
            <form method="post" action="" class="mb-3">
              <?= tokenHere(); ?>
              <input type="hidden" name="reauth_action" value="password">
              <label class="form-label" for="reauth_password">
                <?= safeReturn(lang('REAUTH_PASSWORD_LABEL') ?: 'Your password') ?>
              </label>
              <div class="input-group">
                <input type="password" class="form-control" id="reauth_password"
                       name="reauth_password" autocomplete="current-password"
                       <?= /* @phpstan-ignore ternary.alwaysTrue ($first is always true in this first-rendered method block; the ternary is kept identical across every reauth method block so blocks stay copy-paste uniform and reorderable.) */ $first ? 'autofocus' : '' ?> required>
                <button class="btn btn-primary" type="submit">
                  <i class="fa fa-check"></i> <?= safeReturn(lang('REAUTH_VERIFY') ?: 'Verify') ?>
                </button>
              </div>
            </form>
            <?php $first = false; ?>
          <?php endif; ?>

          <?php if (in_array('totp', $methods, true)): ?>
            <?php if (!$first): ?><div class="separator text-body-secondary small my-3 text-center">
              <?= safeReturn(lang('REAUTH_OR') ?: 'or') ?></div><?php endif; ?>
            <form method="post" action="" class="mb-3">
              <?= tokenHere(); ?>
              <input type="hidden" name="reauth_action" value="totp">
              <label class="form-label" for="reauth_totp">
                <?= safeReturn(lang('2FA_CODE_LABEL') ?: 'Authentication code') ?>
              </label>
              <div class="input-group">
                <input type="text" class="form-control" id="reauth_totp" name="reauth_totp"
                       inputmode="numeric" autocomplete="one-time-code" placeholder="000000"
                       <?= $first ? 'autofocus' : '' ?> required>
                <button class="btn btn-primary" type="submit">
                  <i class="fa fa-check"></i> <?= safeReturn(lang('REAUTH_VERIFY') ?: 'Verify') ?>
                </button>
              </div>
              <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" value="1"
                       id="use_backup_code" name="use_backup_code">
                <label class="form-check-label small" for="use_backup_code">
                  <?= safeReturn(lang('REAUTH_TOTP_BACKUP') ?: 'This is a backup code') ?>
                </label>
              </div>
            </form>
            <?php $first = false; ?>
          <?php endif; ?>

          <?php if (in_array('email', $methods, true)): ?>
            <?php if (!$first): ?><div class="separator text-body-secondary small my-3 text-center">
              <?= safeReturn(lang('REAUTH_OR') ?: 'or') ?></div><?php endif; ?>
            <?php if (!$emailPending): ?>
              <form method="post" action="" class="mb-3">
                <?= tokenHere(); ?>
                <input type="hidden" name="reauth_action" value="email_send">
                <button class="btn btn-outline-primary w-100" type="submit">
                  <i class="fa fa-envelope"></i>
                  <?= safeReturn(lang('REAUTH_EMAIL_BTN') ?: 'Email me a 6-digit code') ?>
                </button>
              </form>
            <?php else: ?>
              <form method="post" action="" class="mb-3">
                <?= tokenHere(); ?>
                <input type="hidden" name="reauth_action" value="email_verify">
                <label class="form-label" for="reauth_email_code">
                  <?= safeReturn(lang('REAUTH_EMAIL_CODE_LABEL') ?: 'Enter the 6-digit code') ?>
                </label>
                <div class="input-group">
                  <input type="text" class="form-control" id="reauth_email_code"
                         name="reauth_email_code" inputmode="numeric"
                         autocomplete="one-time-code" placeholder="000000" autofocus required>
                  <button class="btn btn-primary" type="submit">
                    <i class="fa fa-check"></i> <?= safeReturn(lang('REAUTH_VERIFY') ?: 'Verify') ?>
                  </button>
                </div>
              </form>
              <form method="post" action="" class="mb-3">
                <?= tokenHere(); ?>
                <input type="hidden" name="reauth_action" value="email_send">
                <button class="btn btn-link btn-sm p-0" type="submit">
                  <?= safeReturn(lang('REAUTH_EMAIL_RESEND') ?: 'Send a new code') ?>
                </button>
              </form>
            <?php endif; ?>
            <?php $first = false; ?>
          <?php endif; ?>

          <?php if (in_array('passkey', $methods, true)): ?>
            <?php if (!$first): ?><div class="separator text-body-secondary small my-3 text-center">
              <?= safeReturn(lang('REAUTH_OR') ?: 'or') ?></div><?php endif; ?>
            <button type="button" class="btn btn-outline-primary w-100 mb-2"
                    onclick="reauthWithPasskey()">
              <i class="fa fa-fingerprint"></i>
              <?= safeReturn(lang('REAUTH_PASSKEY_BTN') ?: 'Use a passkey') ?>
            </button>
            <div id="passkeyStatus" class="alert" style="display:none;"></div>
            <?php $first = false; ?>
          <?php endif; ?>

          <?php if (in_array('social', $methods, true) && !empty($oauthClients)): ?>
            <?php if (!$first): ?><div class="separator text-body-secondary small my-3 text-center">
              <?= safeReturn(lang('REAUTH_OR') ?: 'or') ?></div><?php endif; ?>
            <div class="d-grid gap-2 mb-2">
              <?php foreach ($oauthClients as $oc):
                  $label = $oc->login_title ?: $oc->client_name; ?>
                <a class="btn btn-outline-primary"
                   href="<?= $us_url_root ?>users/auth/oauth_request.php?client_id=<?= (int) $oc->id ?>&amp;reauth=1">
                  <i class="fa fa-right-to-bracket"></i>
                  <?= safeReturn(lang('REAUTH_SOCIAL_BTN') ?: 'Verify with') ?> <?= safeReturn($label) ?>
                </a>
              <?php endforeach; ?>
            </div>
            <?php $first = false; ?>
          <?php endif; ?>

          <div class="text-center mt-3">
            <a href="<?= $us_url_root ?>users/logout.php" class="text-danger small">
              <?= safeReturn(lang('MENU_LOGOUT') ?: 'Log out') ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if (in_array('passkey', $methods, true)): ?>
<script nonce="<?= htmlspecialchars($userspice_nonce ?? '') ?>">
    const reauthDest = <?= json_encode(!empty($dest) ? $dest : $defaultDest,
        JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

    function reauthPasskeyStatus(message, type) {
        const el = document.getElementById('passkeyStatus');
        if (!el) return;
        el.textContent = message;
        el.style.display = 'block';
        el.classList.remove('alert-info', 'alert-success', 'alert-danger');
        el.classList.add(type === 'success' ? 'alert-success'
            : (type === 'error' ? 'alert-danger' : 'alert-info'));
    }

    function reauthB64ToBuf(base64url) {
        // Accept base64url (the server sends challenges/credential ids that way):
        // convert to standard base64 and pad before atob().
        const base64 = base64url.replace(/-/g, '+').replace(/_/g, '/');
        const padded = base64.padEnd(base64.length + (4 - base64.length % 4) % 4, '=');
        const binary = atob(padded);
        const bytes = new Uint8Array(binary.length);
        for (let i = 0; i < binary.length; i++) bytes[i] = binary.charCodeAt(i);
        return bytes.buffer;
    }

    function reauthBufToB64(buffer) {
        const bytes = new Uint8Array(buffer);
        let binary = '';
        for (let i = 0; i < bytes.byteLength; i++) binary += String.fromCharCode(bytes[i]);
        // Emit base64url WITHOUT padding — must match the login flow's encoder
        // (passkeys.php base64UrlEncode). The shared passkey parser feeds this to
        // web-auth/webauthn-lib, whose Base64UrlSafe::decodeNoPadding() rejects
        // '=' padding ("decodeNoPadding() doesn't tolerate padding").
        return btoa(binary).replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
    }

    async function reauthWithPasskey() {
        reauthPasskeyStatus('Requesting authentication challenge...', 'info');
        try {
            const challengeResp = await fetch('auth/parsers/passkey_parser.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'auth', csrf: '<?= Token::generate(); ?>' })
            });
            const publicKey = await challengeResp.json();
            if (challengeResp.status !== 200 || publicKey.error) {
                throw new Error(publicKey.error || 'Failed to get challenge');
            }

            const opts = {
                challenge: reauthB64ToBuf(publicKey.challenge),
                rpId: publicKey.rpId,
                userVerification: publicKey.userVerification,
                timeout: publicKey.timeout
            };
            if (publicKey.allowCredentials && publicKey.allowCredentials.length > 0) {
                opts.allowCredentials = publicKey.allowCredentials.map(c => ({
                    ...c, id: reauthB64ToBuf(c.id)
                }));
            }

            reauthPasskeyStatus('Waiting for your passkey...', 'info');
            const credential = await navigator.credentials.get({ publicKey: opts });

            const verifyResp = await fetch('auth/parsers/passkey_parser.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'verify',
                    csrf: '<?= Token::generate(); ?>',
                    credentialId: reauthBufToB64(credential.rawId),
                    authenticatorData: reauthBufToB64(credential.response.authenticatorData),
                    signature: reauthBufToB64(credential.response.signature),
                    clientDataJSON: reauthBufToB64(credential.response.clientDataJSON),
                    userHandle: credential.response.userHandle ? reauthBufToB64(credential.response.userHandle) : null
                })
            });
            const result = await verifyResp.json();

            if (result.success) {
                reauthPasskeyStatus('Verified! Redirecting...', 'success');
                window.location.href = reauthDest;
            } else {
                reauthPasskeyStatus('Verification failed: '
                    + (result.error || 'no matching passkey.'), 'error');
            }
        } catch (error) {
            let msg = 'Error: ' + error.message;
            if (error.name === 'NotAllowedError') msg = 'Passkey prompt was cancelled.';
            reauthPasskeyStatus(msg, 'error');
        }
    }
</script>
<?php endif; ?>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
