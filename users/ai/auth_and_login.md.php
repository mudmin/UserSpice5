<?php /* UserSpice AI Prompt — protected from HTTP access. Markdown content below. */ __halt_compiler(); ?>

# UserSpice — Authentication and Login Methods

Load this when the task touches how users sign in: a new login method or SSO plugin, where users land after login, checking a password without logging in, TOTP, passkeys, passwordless, auth rate limits, or step-up re-authentication.

---

## How every login finishes

Each core login exit (the password form in `users/login.php`, passkeys via `users/passkeys.php?passkeySuccess=true`, `socialLogin()`, passwordless in `users/passwordless.php`, email verify-login in `users/verify.php`, the auto-login in `users/views/_verify_success.php`, and the built-in OAuth client in `users/auth/parsers/oauth_response.php`) ends the same way once the user is logged in:

```php
$dest = consumeLoginDest();   // the page captured before login, or ''
if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php')) {
    require_once $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
}
if ($dest !== '') {
    Redirect::sanitized($dest);
}
Redirect::to($us_url_root . $settings->redirect_uri_after_login);
```

- **Where the user lands comes from the session only.** `securePage()` calls `safelyCaptureDest()` when a logged-out user opens a private page (top-level GET page loads only; POSTs and background fetch/XHR calls are ignored). `consumeLoginDest()` returns that page and clears it. **Never** take a destination from a request parameter such as `dest` or `redirect`: any link could choose where a user lands. `sanitizedDest()` is deprecated for this reason.
- **`Redirect::sanitized()`** keeps the target on this site: absolute URLs to other hosts are cut down to their path, and `//host` targets go to `/`.
- To send a logged-out user to log in from your own check (outside `securePage()`), call `safelyCaptureDest()` and then `Redirect::to($us_url_root . 'users/login.php')`.

### `usersc/scripts/custom_login_script.php`

Runs at every exit, after the user is logged in and before the redirect. The stock script sends `$dest` if set, admins to `users/admin.php`, everyone else to `redirect_uri_after_login`.

- `$dest` is always defined (the captured page or `''`).
- Some exits include it **inside a function**. Only `$user`, `$dest`, `$db`, `$settings`, `$abs_us_root` and `$us_url_root` (plus `$us_session_var` for social and OAuth logins) are certain to be in scope. Add a `global` line for anything else.
- It usually redirects, so do logging and bookkeeping before including it.

### `loginSuccess` hooks

Plugins register `$hooks['loginSuccess']['body']`. They run on every core login exit: the password form, passkeys (once, on the `users/passkeys.php` finisher after the passkey login), passwordless, email verify-login, the verify-success auto-login, `socialLogin()` and the built-in OAuth client. A login method you add should run them too, before `custom_login_script.php`.

---

## Checking credentials vs. logging in

| Call | What it does |
|---|---|
| `verifyLoginCredentials($username, $rawPassword)` | Checks a username or email and password **the way `users/login.php` does, without logging in**: the `login_attempt` rate limit, the password, the banned flag, and whether TOTP is required. Returns `['ok', 'user_id', 'rate_limited', 'totp_required']`. |
| `User::checkCredentials($username, $password, $rawpassword)` | Password check only. Returns the user ID or `false`. No session, no rate limit, no banned or TOTP check. |
| `User::login($username, $password)` | A **full login**: password check, new session, remember-me cookie, login log row. **No rate limit, no TOTP, no banned check.** Never use it as a credential check; that creates a second way in that skips 2FA. |
| `User::login()` with no arguments | Starts a session for a user already loaded by ID (the `User` constructor with an ID). This is how a login method finishes once it has proven who the user is. |

```php
// e.g. confirming a password before an API key is issued
$check = verifyLoginCredentials(Input::get('username'), $_POST['password'] ?? '');
if ($check['rate_limited']) {
    usError(getRateLimitErrorMessage('login_attempt'));
} elseif (!$check['ok']) {
    usError('Invalid username or password');
} elseif ($check['totp_required']) {
    // Ask for a TOTP code too, rate-limited under 'totp_verify'
}
```

Pass the raw password (`$_POST`), not `Input::get()`: `Input::get()` HTML-escapes the value.

---

## Social and SSO logins: `socialLogin()`

For a provider that hands you a verified identity (Google, Discord, a SAML or OIDC IdP):

```php
socialLogin(
    $email,                          // from the provider
    $username,                       // preferred username, or null
    ['google_id' => $providerUserId],// provider ID column(s) on users
    ['fname' => $first, 'lname' => $last, 'picture' => $pic],
    'google',                        // login method (for TOTP rules)
    $emailVerified                   // did the provider verify $email?
);
// never returns: it logs in and redirects
```

- It matches by provider ID first. **Pass `$emailVerified = false` when the provider doesn't say it verified the email** (or can't say). Then it never matches an existing account by email, refuses a login whose email already belongs to another account, and creates new accounts with `email_verified = 0`. Matching by an unverified email lets an attacker sign in to someone else's account.
- ID columns must already exist on `users`; your plugin's installer adds them. Unknown keys are dropped, and protected fields (`permissions`, `password`, `email_verified` and the like) can't be set through `$fields`.
- With registration closed, unknown users go to `users/join.php`.
- It sets the login method, runs `loginSuccess` hooks and `custom_login_script.php`, and redirects to the captured page.

---

## Adding a login method that isn't a social provider

Prove the identity your own way (LDAP bind, signed token, device code), then finish like core:

```php
if (!checkRateLimit('login_attempt', null, $identifier)) {
    usError(getRateLimitErrorMessage('login_attempt'));
    Redirect::to($us_url_root . 'users/login.php');
}
if (!$identityProven) {
    handleAuthFailure('login_attempt', null, $identifier, [], ['method' => 'mymethod']);
    usError('Sign-in failed');
    Redirect::to($us_url_root . 'users/login.php');
}

$user = new User((int)$userId);
if (!$user->exists() || (int)$user->data()->permissions === 0) {
    Redirect::to($us_url_root . 'usersc/scripts/banned.php');
}
handleAuthSuccess('login_attempt', $user->data()->id, $identifier, [], ['method' => 'mymethod']);
$user->login();
setLoginMethod('mymethod');
logger($user->data()->id, 'Login', 'User logged in with mymethod.');

$hooks = getMyHooks(['page' => 'loginSuccess']);
includeHook($hooks, 'body');

$dest = consumeLoginDest();
if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php')) {
    require_once $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
}
if ($dest !== '') {
    Redirect::sanitized($dest);
}
Redirect::to($us_url_root . $settings->redirect_uri_after_login);
```

- Name the variable `$user`: the custom script reads it.
- **Cross-site POST-backs lose the session.** The session cookie is `SameSite=Lax`, so a SAML IdP's POST to your callback arrives without it. Keep your request state (and the captured page) in your own database row keyed by a one-time value such as RelayState, and restore it.
- If you write WebAuthn code yourself, build ceremony checks with `CeremonyStepManagerFactory`. An empty `CeremonyStepManager` performs no checks at all. Prefer the built-in passkey flow.

---

## TOTP (two-factor)

- `settings.totp`: `0` off, `1` optional (enforced only for users who enrolled), `2` required for everyone. Needs PHP 8.2+.
- Enforcement runs in `users/includes/loader.php` on every request from a logged-in user: `handleTotpEnforcement()` redirects to `users/totp_verification.php` (enrolled, not yet verified this session) or `users/totp_management.php` (required, not set up). AJAX requests get a 401 JSON error instead.
- Whether a session needs TOTP depends on its login method (`setLoginMethod()`; none recorded means `password`) and the `login_methods` map in `users/includes/totp_requirements.php`. Defaults: `password` and `email` need TOTP; `cookie` (remember-me), `passkeys`, `google`, `oauth` and the other providers don't. **A method missing from the map requires TOTP.**
- To change the rules, copy that file to `usersc/includes/totp_requirements.php`. The same file holds `safe_pages`, which are never redirected. Only list pages that must work mid-login; a safe page is reachable before TOTP is done.
- `usersc/includes/custom_totp_policy.php` can raise or lower `$settings->totp` per request (for example, required for `hasPerm(2)`).
- `isTotpRequired($settings, $method, loadTotpRequirements($userId), $userId)` answers the question for your own code.
- The password form checks TOTP before the session starts. Every other method logs the user in first and enforcement holds them until TOTP is done. The OAuth server waits for TOTP before issuing a code (`isOAuthTotpPending()`).
- Cloaked sessions are exempt. Defining the constant `TOTP_BYPASS` as `true` before `init.php` turns enforcement off for that request; only use it for endpoints with their own authentication.

## Passkeys

- On when `settings.passkeys = 1`. The relying party ID is `PASSKEY_RP_ID` in `users/init.php` (a domain, or an array of domains) and must match the site's host. HTTPS is required except on `localhost`.
- Use the built-in flow (`users/auth/parsers/passkey_parser.php` and `users/passkeys.php`). It rate-limits as `passkey_verify`, records the method `passkeys`, and finishes on `users/passkeys.php?passkeySuccess=true`.

## Passwordless and password settings

- Emailed sign-in codes: `users/passwordless.php`, on when `settings.email_login` is on. Codes are stored hashed, used once, and rate-limited under `login_attempt`. These sessions record the login method `email`, so the `email` entry in the TOTP `login_methods` map applies to them.
- `settings.no_passwords`: `0` passwords allowed, `1` off, `2` only for genuinely local requests. Check it with `passwordsAllowed($settings->no_passwords)`.

---

## Rate limits for authentication

```php
if (!checkRateLimit('login_attempt', $userId, $email)) { /* refuse */ }
// ... attempt ...
handleAuthFailure('login_attempt', $userId, $email);   // on failure
handleAuthSuccess('login_attempt', $userId, $email);   // on success: records it, clears failures
```

- The client address is added automatically (`ClientIP::get()`), so limits apply per IP, per user and per email.
- Core actions include `login_attempt`, `totp_verify`, `passkey_verify`, `password_reset_request`, `registration_attempt` and `email_verification`. `getRateLimitErrorMessage($action)` gives the translated message.
- An action that isn't configured is never limited. Add your own in `usersc/includes/rate_limits.php` (`$rateLimits['my_action'] = ['ip_max' => 10, 'ip_window' => 900, ...];`).
- Behind a proxy that isn't configured, every visitor shares one address and one counter. See `proxies_and_ips.md.php`.

---

## Sessions and step-up

- The session cookie is HttpOnly, `SameSite=Lax`, strict-mode, and Secure when `ClientIP::requestLooksHttps()` is true (set in `users/init.php`). Logins regenerate the session ID.
- Per-install session keys start with `INSTANCE` (the configured `session/session_name`), e.g. `$_SESSION[INSTANCE . '_login_method']`.
- **Step-up:** `forceReauth($returnTo, $purpose, $opts)` sends the user to `users/reauth.php` unless they authenticated within the grace window (`settings.reauth_timeout`, default 15 minutes). Every login counts as a fresh confirmation. `reauthConfirmed()` tests it without redirecting.
- Logout: `users/logout.php` (runs `usersc/scripts/just_before_logout.php` and `just_after_logout.php`).

---

## Compatibility guards for plugins on older cores

| Feature | Core |
|---|---|
| `ClientIP` | 6.1.6+ |
| `consumeLoginDest()`, `verifyLoginCredentials()`, `User::checkCredentials()`, the `$emailVerified` argument to `socialLogin()` | 6.1.8+ |

Guard each one, for example with `function_exists('consumeLoginDest')`:

```php
$dest = function_exists('consumeLoginDest') ? consumeLoginDest() : '';
$redirect = method_exists('Redirect', 'sanitized') ? 'sanitized' : 'to';
if (function_exists('setLoginMethod')) { setLoginMethod('mymethod'); }
```

Older cores ignore the extra `$emailVerified` argument to `socialLogin()` and still match by email, so on those cores refuse an unverified email yourself.
