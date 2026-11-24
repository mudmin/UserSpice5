<?php /* UserSpice AI Prompt — protected from HTTP access. Markdown content below. */ __halt_compiler(); ?>

# UserSpice — Debugging and Common Traps

Load this when something doesn't work and the cause isn't obvious: a blank page, a redirect you didn't expect, a form that "does nothing", a token error, a function that is undefined, or data that lands in the wrong place.

---

## Where to look first

1. **The PHP error log.** Production servers hide fatals (`display_errors` off). The `error_log` directive in `php.ini` names the file.
2. **The `logs` table** (Admin → Logs, `users/admin.php?view=logs`). Columns: `user_id`, `logdate`, `logtype`, `lognote`, `ip`, `metadata`, and `cloak_from` for actions taken while cloaked. Core logs logins, rate-limit hits, TOTP enforcement, OAuth, updates, plugin actions and much more here.
3. **The `audit` table** (Admin → Security Logs, `users/admin.php?view=security_logs`). One row per page denial from `securePage()`: `user` (0 = not logged in), `page` (the page ID), `ip`, `timestamp`.
4. **The Security Dashboard** (`users/admin.php?view=security`). Checks HTTPS, cookie flags, proxy setup, rate limits, TOTP and passkey configuration, security headers and more. Check it after deploying, upgrading, or changing proxy or login settings.
5. **"Your database is out of date"** at the top of the dashboard means update components haven't run. Click it (or open `users/updates/`) before chasing missing-column errors.

```sql
SELECT id, user_id, logdate, logtype, lognote, ip FROM logs ORDER BY id DESC LIMIT 50;
SELECT id, user, page, ip, `timestamp` FROM audit ORDER BY id DESC LIMIT 50;
```

### Writing your own log rows

```php
logger($user->data()->id, 'Orders', 'Refund issued', ['order_id' => $orderId]);
logger(0, 'Webhook', 'Bad signature');   // 0 = no user
```

`logger($userId, $logtype, $lognote, $metadata = null)` records the resolved client IP (`ipCheck()`) and returns the new row ID. Arrays in `$lognote` or `$metadata` are JSON-encoded. Pass `''` as the user ID to use the logged-in user. `logtype` holds 25 characters, so longer types are silently cut.

**Never log** passwords, TOTP secrets or codes, session IDs, client secrets, OAuth codes or tokens, API keys, or full request bodies from login and payment forms.

---

## Debug tools

- **Debug mode** (Admin → Settings → General, "Enable Debug Mode"; `settings.debug`): `0` off, `1` only user ID 1, `2` everyone. While on, every request's GET and POST data is written to `logs` as `Form Data` (password fields excluded), every `Redirect::to()` writes a `Redirect Diag` row naming the file and line that redirected (the fastest way to find an unexpected redirect), and `dump()` / `dnd()` print the calling file and line. View with `users/admin.php?view=logs&mode=debug`. Turn it off when done: it records other form fields, and mode 2 logs every visitor.
- **`dump($var, $adminOnly = false, $localhostOnly = false)`** prints a var_dump of the value; **`dnd()`** dumps and dies. With `$adminOnly`, only admins see it. With `$localhostOnly`, only a genuinely local request (`ClientIP::isLocal()`) sees it. Don't leave a bare `dump()` on a public page. `safeDump()` HTML-escapes the output.
- **Database write tracing:** `$db->setLogging(true, ['users'])` (or `$database_logging = true;` before the writes) logs each `$db->insert()` / `$db->update()` call, with a stack trace, as `DATABASE_INSERT` / `DATABASE_UPDATE` rows. Writes made with raw `$db->query()` are not traced. Turn it off afterward.
- **File activity log:** defining `USERSPICE_ACTIVE_LOGGING` as `true` in `users/init.php` makes `userspiceActiveLog()` append one JSON line per request to `users/logs/`. Exclusions and the file name go in `usersc/includes/active_logging_custom.php`; defining `USERSPICE_DO_NOT_LOG` as `true` above `init.php` skips a page.
- **Query errors:**

```php
$rows = $db->query('SELECT * FROM orders WHERE user_id = ?', [$uid])->results();
if ($db->error()) {
    logger(0, 'Orders', 'Query failed', ['error' => $db->errorString()]);
}
```

`DB` sets `sql_mode = ''`, so MySQL truncates or coerces bad values instead of raising errors. A wrong column type shows up as wrong data, not an exception.

---

## Token errors

`tokenHere()` prints `<input type="hidden" name="csrf" value="…">`. The handler checks `Token::check(Input::get('csrf'))`. The token is one per session; it doesn't change per form or per submit.

When the check fails, core pages include `usersc/scripts/token_error.php`. Causes, most likely first:

1. **Field name mismatch:** the form posts `csrf` but the handler reads `csrf_token` (or the reverse), or JavaScript never sends it.
2. **The session was lost** between page load and submit: the user logged out in another tab, the session expired, or the session cookie wasn't sent back. Cookie causes: `session.cookie_secure` on a plain-HTTP request, a cross-site POST (the cookie is `SameSite=Lax`), two installs on one domain sharing a `session_name`, or an unwritable session save path.
3. **A cached page:** a CDN or full-page cache served HTML that holds someone else's token. Never cache logged-in or form pages (Cloudflare "Cache Everything" does this).
4. **Refresh or back-button resubmits** after a logout or login.

`Token::check()` also rejects anything that isn't 64 hex characters, so a token that was HTML-escaped twice or truncated fails too.

---

## Redirect surprises

| Symptom | Cause |
|---|---|
| "You must go into the Admin Panel and click the Manage Pages button…" | The page isn't in `pages` and the visitor isn't an admin. An admin opens it once. |
| Sent to `users/admin.php?view=page&new=yes…` | An admin opened an unregistered page. Choose its levels and save. |
| Sent to `usersc/scripts/banned.php` | `users.permissions = 0` (checked in `users/includes/loader.php`), or the IP is in `us_ip_blacklist`. Behind an unconfigured proxy every visitor shares the proxy's IP, so banning it bans everyone. |
| Sent to `users/login.php` | Private page, not logged in. |
| Sent to the homepage | Logged in, no matching level. See the `audit` table. |
| Sent to `users/totp_verification.php` or `users/totp_management.php` | TOTP is required for this login method and isn't verified or set up. |
| Every page sends you to an OAuth client's callback | An OAuth sign-in is still pending in the session. It expires after 30 minutes; logging out clears it. |
| Sent to the maintenance page | `settings.site_offline` is on. Only master accounts get through. |
| Stuck on the password-change page | `users.force_pr = 1` for that user. |
| "Too many redirects" | The homepage denies the user, or a custom script redirects to another protected page. |
| Blank page | A fatal before output (check the error log), or `securePage()` returned false and the page didn't stop. |

---

## "Call to undefined function"

1. `users/init.php` wasn't included first, or the relative path is wrong (`require_once 'users/init.php'` from the root, `'../users/init.php'` one level down, `'../../users/init.php'` two levels down).
2. The function belongs to a plugin that isn't enabled. A plugin's `functions.php` loads when its entry in `usersc/plugins/plugins.ini.php` is `1`. `pluginActive()` checks the `us_plugins` table instead; the two normally agree.
3. The file defining it stopped parsing partway (next section).
4. The function was added in a newer core than the site runs. Guard it with a `function_exists` check in code that must run on older versions.

Dumping the result of a `function_exists` check just before the call tells you which.

---

## Parser traps

- **`?>` inside a `//` comment ends PHP mode.** `// wraps <?php exit; ?> around it` drops the rest of the file to the browser as text, and functions below it are never defined. Never put a literal `?>` in a `//` or `#` comment. Find them with `grep -rnE '(//|#).*\?>' path/`.
- **Files that hold data, not code** (like these prompt files) start with a one-line PHP opener that calls `__halt_compiler` and closes the tag. `exit;` stops execution but PHP still parses the rest, and a `<?php` inside the data breaks the parse.
- `php -l file.php` catches syntax errors but not the `?>`-in-comment trap.

---

## Data traps

- **`$db->insert()` and `$db->update()` return `bool`.** Get the new ID from `$db->lastId()` right after a successful insert; `true` used as an ID becomes `1` and attaches child rows to row 1. `$db->count()` after an update gives the rows touched.
- **`Input::get()` returns `''` for a missing field,** never `null` or `false`. It also HTML-escapes the value, so don't wrap it in `safeReturn()` again and don't compare it with raw strings that contain `&`, `<`, `>` or quotes.
- **`Input::exists()` takes `'post'` or `'get'`, not a field name.** It only says whether any data was submitted. Test a single field with `Input::get('x') !== ''`.
- **`'0'` is falsy.** `if (Input::get('qty'))` is false for zero. Compare explicitly.
- **`pluginActive('name')` redirects** to the plugin manager when the plugin is off. Use `pluginActive('name', true)` for a plain true/false.
- **Numeric usernames:** the `User` constructor treats a numeric value as an ID, so `'123'` loads user ID 123, not the username "123".

---

## Behind a proxy or CDN

If logs, bans and rate limits all show the same address (a Cloudflare edge, `127.0.0.1`, or a load balancer), proxy trust isn't configured. Open **Admin → Proxy & CDN** (`users/admin.php?view=proxy`), which shows what PHP sees and offers one-click Cloudflare modes. Until it's fixed:

- one visitor's failed logins can lock out everyone (`ip_max` counts per address);
- an IP ban bans every visitor;
- the session cookie may not be marked Secure.

See `proxies_and_ips.md.php`.

---

## Rate-limit confusion

- The `login_attempt` limit's `total_max` counts **successful** logins too. Many test logins from one address trip it. Clear the test rows in `us_rate_limits` between runs.
- An action that isn't listed in the rate-limit configuration is never limited: `checkRateLimit()` returns true. Add custom actions in `usersc/includes/rate_limits.php`.
- Limits are viewed and tuned at `users/admin.php?view=rate_limits`.

---

## Reference

- `users/helpers/us_helpers.php`: `logger()`, `ipCheck()`, `userspiceActiveLog()`, `pluginActive()`
- `users/helpers/helpers.php`: `dump()`, `dnd()`, `isDebugModeActive()`
- `users/classes/DB.php`: `DB::error()`, `DB::errorString()`, `DB::lastId()`, `DB::setLogging()` (instance methods on `$db`)
- `users/helpers/permissions.php`: `securePage()`, `hasPerm()`
- `permissions.md.php` for the access-control flow, `auth_and_login.md.php` for login problems.
