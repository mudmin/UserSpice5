<?php /* UserSpice AI Prompt — protected from HTTP access. Markdown content below. */ __halt_compiler(); ?>

# UserSpice — OAuth Server and Client

Load this when another app should sign users in through this site (UserSpice as the OAuth server), when this site should sign users in through another UserSpice site (the built-in OAuth client), or when writing a client app for a UserSpice server.

---

## The OAuth server

UserSpice can act as an OAuth 2.0 authorization-code server. Turn it on and register clients at **Admin → OAuth Server** (`users/admin.php?view=oauth`; `settings.oauth_server`). While it's off, the endpoints return 404.

Code: `users/auth/index.php` (authorize and token), `users/auth/userinfo.php`, `users/auth/userspice_oauth_provider.php` (the `UserSpiceOAuthProvider` class), and `users/includes/oauth_enforcement.php` (finishes the flow after login). Tables: `us_oauth_server_clients`, `us_oauth_server_codes`, `us_oauth_server_tokens`.

### Endpoints

| Step | Request |
|---|---|
| Authorize | `GET users/auth/?response_type=code&client_id=…&redirect_uri=…&state=…&code_challenge=…&code_challenge_method=S256` |
| Token | `POST users/auth/` with `grant_type=authorization_code`, `client_id`, `client_secret` (not for public clients), `code`, `redirect_uri`, `code_verifier` |
| Userinfo | `GET` or `POST users/auth/userinfo.php` with `Authorization: Bearer <access token>` |
| Preflight | `OPTIONS` on either returns 204 |

1. The app sends the user to the authorize URL. `redirect_uri` must equal the registered one exactly (if omitted, the registered one is used).
2. The user signs in on this site's normal login page with any method (password, passkey, social, passwordless) or is already signed in. **TOTP is completed before a code is issued**: if this session still owes TOTP, the flow waits (`isOAuthTotpPending()`).
3. The user is redirected to `redirect_uri?code=…&response=…&state=…` (plus `signature` when the client has a Response Secret).
4. The app's server posts the code to the token endpoint and gets JSON: `access_token`, `token_type` (`Bearer`), `expires_in` (3600) and `email`.
5. The app calls userinfo and gets OpenID Connect claims: `sub` (the user ID, as a string), `name`, `given_name`, `family_name`, `email`, `email_verified`. Sent with `Cache-Control: no-store`.

```bash
curl -s https://example.com/users/auth/ \
  -d grant_type=authorization_code -d client_id=CLIENT_ID -d client_secret=SECRET \
  -d code=CODE -d redirect_uri=https://app.example.com/callback -d code_verifier=VERIFIER

curl -s https://example.com/users/auth/userinfo.php -H "Authorization: Bearer ACCESS_TOKEN"
```

Under Apache with PHP-FPM, the `Authorization` header may not reach PHP. Add `SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1` to the site config or `.htaccess`.

### Client versions (`client_ver`)

| | Version 0 (original) | Version 1 |
|---|---|---|
| PKCE | not enforced | `code_challenge` with `code_challenge_method=S256` required at authorize, `code_verifier` required at token. `plain` is refused. |
| `redirect_uri` at the token step | not checked | required, and must equal the one the code was issued for |
| Client secret | required | required unless the client is public |
| Public client | not available | optional |

- Clients created on the admin page start at version 1. Existing clients, and rows inserted by scripts or SQL, are version 0. A missing column (before the updater runs) reads as 0.
- **v1 readiness:** for a v0 client, every "Token issued successfully" log line ends with `(v0; v1-ready)` or `(v0; not v1-ready: no PKCE, no redirect_uri)` (whichever parts are missing). Search Admin → Logs for the client before switching it to v1. The switch is logged, and switching back to 0 is the escape hatch.

### Public clients

For mobile, desktop and single-page apps, which can't keep a secret. Version 1 only. No secret is checked; PKCE and the exact `redirect_uri` carry the proof. IP restriction isn't offered for public clients.

**Allowed Browser Origins** (`cors_origins`, public clients only) lets a single-page app call the token and userinfo endpoints from the browser:

- Origins are `scheme://host[:port]` with no path (`https://app.example.com`, `http://localhost:3000`, `capacitor://localhost`). They're normalized on save; `*` and `null` are refused.
- The response echoes the exact origin in `Access-Control-Allow-Origin` (never `*`, never with credentials) plus `Vary: Origin`. A success response needs the origin registered on **that** client. Error responses get the header when the origin is registered on any enabled public client, so the app can read the error.
- Origins set on a confidential client are saved but ignored: a client that needs CORS would be keeping its secret in a browser.

### IP restriction (`ip_restrict`, opt-in)

Tick "Enforce IP restriction" and list addresses or CIDR ranges (commas, spaces or new lines). An invalid or empty list blocks the save.

- Checked at the token endpoint (before the secret) and at userinfo (via the token's client).
- Compared with **`ClientIP::get()`**, the visitor resolved through trusted proxies. It's a second check on top of the client secret, and behind a CDN the raw connection would be the CDN. See `proxies_and_ips.md.php`.
- A refusal returns `invalid_client` or `invalid_token`, counts as a failed attempt, and logs the client and the address seen. That log line is how you diagnose an app whose server changed egress IP.

### What the server guarantees

- Codes live 10 minutes, are single-use (concurrent redemptions: exactly one succeeds; any failure burns the code), and are bound to the client and `redirect_uri`.
- Codes and access tokens are stored as SHA-256 hashes; a stolen stored value can't be replayed. Client secrets are stored with bcrypt. Codes and tokens are never written to `logs`.
- Access tokens last one hour. There are no refresh tokens; the app sends the user through authorize again (it's instant while they're signed in here).
- A disabled client is refused at every step. Banned users get no code and no userinfo.
- The token endpoint is rate-limited per IP under `login_attempt`; bad secrets and bad codes count as failures.
- An unfinished sign-in stays in the session for 30 minutes. A new authorize request replaces it, so the code always carries the newest `state` and PKCE challenge.

### Gotchas

- **The `response` parameter on the callback is not proof of identity** unless the client has a Response Secret and checks `signature` (HMAC-SHA256 of the decoded JSON). Take the identity from the token response's `email` or from userinfo.
- Redirect URIs are stored as plain text and compared exactly, query string included. One saved by an older version HTML-escaped (`&amp;`) still matches its plain form. The `code`, `state` and other parameters are appended with `&` when the URI already has a query string.
- `usersc/oauth_server/login_scripts/<file>` (the client's "Login Script") runs before the redirect and can add fields to `$response`.
- The OAuth login page uses `usersc/login.php` only if that file contains the string `USERSPICE_LOGIN_CALLED`; otherwise it uses `users/login.php`.
- Scope is accepted but not enforced; every token can read the userinfo claims.

### Writing a client app for a UserSpice server

- Always send PKCE (S256) and `redirect_uri` at both steps; that works at v0 and v1.
- Server-side apps: confidential client, secret on the server only.
- Browser apps: public client plus Allowed Browser Origins. Never put a client secret in JavaScript.
- Check `state` on the callback, then identify the user from userinfo `sub` (stable) and `email`.

---

## The built-in OAuth client

Lets this site's users sign in through another UserSpice site's OAuth server. Configure at **Admin → OAuth Client** (`users/admin.php?view=oauth_client`; table `us_oauth_client_login_options`, several servers allowed). `settings.oauth` is on while any client is active, and a button appears on the login page.

- **Start:** `users/auth/oauth_request.php?client_id=<row id>` stores `state` and a PKCE verifier in the session and redirects to the server's authorize URL with an S256 challenge. Servers that don't require PKCE ignore it.
- **Callback:** `users/auth/parsers/oauth_response.php` checks `state`, exchanges the code (sending `code_verifier` and `redirect_uri`), and takes the email from the token response. If the server doesn't return one (older servers), it accepts only a signed `response` and refuses otherwise, so set a Response Secret on both sides for old servers.
- It signs in the user with that email, or creates the account when registration is open, records the login method `oauth` (exempt from TOTP by default; see `auth_and_login.md.php`), and finishes through `consumeLoginDest()` and `custom_login_script.php`. It does not run `loginSuccess` hooks.
- `?reauth=1` (used by `users/reauth.php`) confirms the returned identity matches the signed-in user instead of logging in.
- A per-client script in `usersc/oauth_client/login_scripts/` can run on each login. Tags in a signed response are applied to the user.
- Matching is by email, and the server's email is trusted, so only connect servers whose accounts you trust.
