<?php /* UserSpice AI Prompt — protected from HTTP access. Markdown content below. */ __halt_compiler(); ?>

# UserSpice: Customizing the Core

Load this when the task changes something UserSpice already does: a helper, a system page (login, join, account), a user flow, an admin screen, or "what should happen after a user does X."

> **Never edit `users/`. Work through `usersc/`.**

Core patches replace `users/` (and the shipped `usersc/templates/customizer/`). The rest of `usersc/` belongs to the site. Nearly every behavior has an override point. This prompt tells you which one to use.

---

## Pick the lightest override that works

1. **Event script** in `usersc/scripts/`: your code runs at one moment in a flow.
2. **Include** in `usersc/includes/`: always-loaded files for head tags, footer, the loader, config, and policies.
3. **Helper override** in `usersc/includes/custom_functions.php`: same-name function wins.
4. **Plugin hook**: a plugin injects a file into a core page at a named position (see `plugins_and_updates`).
5. **View or module replacement**: `usersc/views/`, `usersc/includes/admin/`, `usersc/modules/`.
6. **Whole-page replacement**: `usersc/<page>.php`. This is the heaviest, because you maintain the full page forever.

If none fits, run `grep -rn "usersc/" users/`. Every file_exists check on a `usersc/` path in core is an override point, and new ones arrive with releases. If no hook exists, ask for one upstream rather than editing `users/`.

---

## 1. Event scripts (`usersc/scripts/`)

| File | Runs |
|---|---|
| `custom_login_script.php` | After every successful login (password, passkey, social, passwordless, verify-login, OAuth client), before the redirect. `$dest` holds the page captured before login, or `''`. |
| `just_before_logout.php` / `just_after_logout.php` | Around `users/logout.php` |
| `additional_join_form_fields.php` | Extra fields on the join form and on admin Add User |
| `during_user_creation.php` | After a user row is created (join, admin Add User, OAuth): save your extra fields here |
| `after_user_deletion.php` | After a user is deleted: clean up related rows |
| `not_logged_in.php` | A guest hit a private page (before the redirect to login) |
| `did_not_have_permission.php` | A logged-in user hit a page they can't access |
| `banned.php` | Shown to banned users and IPs |
| `token_error.php` | A CSRF check failed. Core pages `include` it, and it dies. |
| `cloak_attempt.php` | An admin tries to cloak (impersonate) a user |
| `passwordless_login_overrides.php` | Passwordless/verify login adjustments |
| `email_function_override.php` | Create it to adjust the PHPMailer object inside `email()` just before send |
| `spice_update_begins.php` / `spice_update_success.php` / `spice_update_fail.php` | Around a core update |

**`custom_login_script.php` rules:**
- Some login methods include it from inside a function. Only `$user`, `$dest`, `$db`, `$settings`, `$abs_us_root`, `$us_url_root` (and `$us_session_var` for social and OAuth logins) are guaranteed in scope. Add a `global` line for anything else.
- Redirect to `$dest` with `Redirect::sanitized($dest)`. Never take a destination from a request parameter.
- If it doesn't redirect, the login method's own default redirect runs next.

```php
// usersc/scripts/custom_login_script.php
if ($dest !== '') {
    Redirect::sanitized($dest);
} elseif (hasPerm([2], $user->data()->id)) {
    Redirect::to($us_url_root . 'users/admin.php');
} else {
    Redirect::to($us_url_root . $settings->redirect_uri_after_login);
}
```

If you write your own login exit (a plugin login method, for example), follow the same order core uses: `$dest = consumeLoginDest()`, the loginSuccess hooks (`getMyHooks(['page' => 'loginSuccess'])` then `includeHook($hooks, 'body')`), then this script, then `Redirect::sanitized($dest)`. See `auth_and_login`.

---

## 2. Includes (`usersc/includes/`)

These are the site's files. Edit them in place.

| File | Purpose |
|---|---|
| `custom_functions.php` | Site-wide functions and helper overrides (see section 3) |
| `loader.php` | Runs at the end of bootstrap on every request, the "every page" hook |
| `head_tags.php` | Extra `<head>` markup (meta, favicon, CSS) |
| `footer.php` | Extra markup and scripts at the end of every templated page |
| `analytics.php` | Tracking snippet |
| `security_headers.php` | CSP, HSTS, and other headers. Always loaded. |
| `rate_limits.php` | Rate-limit overrides. Admin → Rate Limits rewrites it (see `secure_page_pattern`). |
| `trusted_proxies.php` | Written by Admin → Proxy & CDN (see `proxies_and_ips`) |
| `custom_totp_policy.php`, `totp_requirements.php` | Adjust TOTP enforcement |
| `custom_cloak_policy.php` | What a cloaked admin may do on the impersonated user's passkey and TOTP pages |
| `active_logging_custom.php` | File activity log settings (pages and fields to skip, log location) |
| `oauth_success_redirect.php` | Runs inside `socialLogin()` after a social login, before `custom_login_script.php` |
| `user_manager_columns.php` | Columns on Admin → Users |
| `database_navigation_hooks.php`, `database_navigation_hooks_dropdown.php` | Replace `{{placeholders}}` in menu items |
| `dashboard_overrides.php` | Set `$template_override` for the admin dashboard |

**Optional files.** Core uses these if you create them: `pre_footer.php`, `system_messages_header.php`, `system_messages_footer.php` (replaces the core one), `password_meter.php`, `admin_override.php`, `admin_panel_buttons.php`, `admin_panels.php`, `admin_panel_custom_settings.php`, `dashboard.css`.

**Composer.** `usersc/vendor/autoload.php` is loaded automatically when present.

---

## 3. Override a helper (`custom_functions.php`)

`users/helpers/helpers.php` loads `usersc/includes/custom_functions.php` first, then each active plugin's `override.php`, then the core helper files. Most core helpers are wrapped in a function_exists guard, so a same-name function defined earlier wins.

```php
// usersc/includes/custom_functions.php
function contactCount() {                 // a new site-wide helper
    global $db;
    return (int)$db->query("SELECT COUNT(*) AS c FROM contacts")->first()->c;
}
```

**Before you override one, open the core definition:**
- **Check the guard.** If there is no function_exists guard, a same-name function is a fatal "cannot redeclare" error. Unguarded helpers include `safeReturn()`, `safeJsonEncodeForJs()`, `trustedHtml()`, `sanitizePath()`, `isHTTPSConnection()`, `usersc_override_redirect()`, and everything in `users/helpers/rate_limit_helpers.php` (`checkRateLimit()`, `handleAuthFailure()`, and the others).
- **Match the signature exactly**, including defaults.
- **You now own its behavior.** Security fixes to the core version won't reach your copy. Re-read the core function at every update.
- **Load order matters.** Your `custom_functions.php` beats plugin `override.php` files, which beat core.
- **Use `global $db;`** (and any other globals you need) inside the function, the way core helpers do.

---

## 4. Plugin hooks

Core pages call `getMyHooks()` and `includeHook($hooks, 'pre' | 'post' | 'form' | 'body' | 'bottom')`. An active plugin registers files for those positions with `registerHooks()` in its installer, for example `$hooks['account.php']['bottom'] = 'hooks/accountbottom.php';`. Hooks run only while the plugin is active. Plugin code isn't sandboxed, so a fatal error in a hook breaks the page. Writing plugins: see `plugins_and_updates`.

---

## 5. Views, admin screens, and modules

**Form views.** If one of these exists, core includes it instead of its own body: `usersc/views/_join.php`, `_joinDisabled.php`, `_joinThankYou.php`, `_forgot_password.php`, `_forgot_password_sent.php`, `_verify_success.php`, `_verify_error.php`, `_social_logins.php`, `_admin_sidebar.php`, `_admin_sidebar_fallback_menu.php`, `_admin_menu.php`.

**Admin screens.** `users/admin.php?view=X` resolves its view file through `usersc/includes/admin/` first, then `users/views/`. To replace an admin screen, copy `users/views/_admin_<x>.php` to `usersc/includes/admin/` under the same name.

**Dashboard modules.** `users/admin.php` loads each of its modules (`header`, `sidebar`, `views`, `footer`, and the rest) from `usersc/modules/<module>.php` when that file exists, otherwise from `users/modules/`.

A copied view is a fork. Diff it against the core file after each update.

---

## 6. Replace a whole core page

If `usersc/<page>.php` exists for a page in `users/` (`login.php`, `join.php`, `account.php`, and so on), `users/includes/loader.php` redirects there through `usersc_override_redirect()`. That redirect drops the `redirect`, `return`, `url`, `next`, and `dest` parameters and keeps the target same-origin. Use this only when no hook or view override can do the job. You're now maintaining the whole page, and every fix core makes to it passes you by.

---

## Templates and plugins: copy before you customize

`usersc/templates/customizer/` ships with core and is replaced by patches. Updating a plugin through Spice Shaker overwrites its folder. Don't edit either in place. Copy the template to `usersc/templates/<yourname>/` and select it on Admin → Templates. For the customizer, its child themes and custom CSS settings are the intended knobs. For a plugin, copy it to a new folder name.

---

## Language strings

`usersc/lang/<code>.php` is included after the core pack and merges on top of it:

```php
<?php
$lang = array_merge($lang, [
    "MENU_HOME"   => "Homepage",     // change a core string
    "MYAPP_SAVED" => "Contact saved", // add your own key, use lang('MYAPP_SAVED')
]);
```

Don't copy a whole language file. Only define the keys you change or add. `lang()` falls back to en-US for keys a language lacks. (Core development is different: a new core key goes in all 24 `users/lang/*.php` files.)

---

## What does not belong in `usersc/`

`usersc/` holds override points the framework recognizes. App pages go in the project root or in folders you add on Admin → Pages. Classes and libraries go in your own folder (load them from `custom_functions.php` or a Composer autoloader). One-off scripts go somewhere project-specific. If `usersc/` is filling with unrelated files, you've drifted.
