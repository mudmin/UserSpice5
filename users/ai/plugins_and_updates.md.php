<?php /* UserSpice AI Prompt — protected from HTTP access. Markdown content below. */ __halt_compiler(); ?>

# UserSpice — Plugins, Updates and Compatibility

Load this when writing or changing a plugin, adding a database column or table, writing a core update component, adding language strings, adding inline JavaScript or CSS, or writing code that must run on more than one UserSpice version.

---

## Plugin layout

A plugin is a folder in `usersc/plugins/<name>/`. The folder name is the plugin name (lowercase, letters, digits, `_` or `-`).

| File | Purpose |
|---|---|
| `info.xml` | `name`, `author`, `website`, `version`, `release`, `tested` (last core version tested), `fa_icon`, `description`, `button` (the launch button label). |
| `plugin_info.php` | Sets `$plugin_name` to the folder name. Included by the other files. |
| `install.php` | Adds the `us_plugins` row, creates tables, registers hooks. |
| `activate.php` | Sets `us_plugins.status = 'active'`. |
| `migrate.php` | Schema and data changes between plugin versions. |
| `uninstall.php` | Runs on **deactivate** and before delete. Removes the `us_plugins` row, calls `deRegisterHooks()`. Don't drop user data here. |
| `delete.php` | Runs on delete. Drop tables and data here if the plugin should clean up. |
| `configure.php` | The settings page at `users/admin.php?view=plugins_config&plugin=<name>`. |
| `functions.php` | Loaded on every request while the plugin is enabled. Plugin helpers go here, each wrapped in a `function_exists` check. |
| `override.php` | Optional. Loaded before core helpers so it can replace a core function (core helpers are wrapped in `function_exists` checks). |
| `hooks/` | Files injected into core pages. |
| `assets/`, `files/` | CSS, JS, parsers, files the plugin copies elsewhere. |

### Lifecycle in the plugin manager

**Admin → Plugins** (`users/admin.php?view=plugins`) is for master accounts only.

- **Activate:** sets the plugin to `1` in `usersc/plugins/plugins.ini.php`, then runs `install.php`, `activate.php` and `migrate.php`, **every time**. All three must be safe to run again.
- **Deactivate:** sets it to `2`, marks the row uninstalled, runs `uninstall.php`.
- **Delete:** sets it to `0`, runs `uninstall.php` then `delete.php`, removes the folder.
- `migrate.php` also runs after a plugin is updated through the downloader, and when an admin opens the update checker (`users/admin.php?view=updates`, for active plugins not checked in the last 3 hours).

`functions.php` and hooks load when `plugins.ini.php` says `1`. `pluginActive()` reads `us_plugins.status` instead. **`pluginActive('name')` redirects to the plugin manager when the plugin is off;** pass `true` for a plain check:

```php
if (pluginActive('my_plugin', true)) { /* ... */ }
```

### The master-account wrapper

`install.php`, `activate.php`, `migrate.php`, `uninstall.php`, `delete.php` and `configure.php` can be requested directly. Wrap everything they do:

```php
<?php
include 'plugin_info.php';
if (in_array($user->data()->id, $master_account)) {
    // all actions here
}
```

Plugin parsers and pages check permissions and CSRF like any other endpoint (see `permissions.md.php`).

### Hooks

Register in `install.php`, remove in `uninstall.php`:

```php
$hooks = [];
$hooks['login.php']['body'] = 'hooks/loginbody.php';     // page + position
$hooks['account.php']['bottom'] = 'hooks/accountbottom.php';
$hooks['loginSuccess']['body'] = 'hooks/login_success.php'; // event hook
registerHooks($hooks, $plugin_name);
```

- **Page positions:** `pre`, `post`, `form`, `body`, `bottom`. Core pages call `getMyHooks()` and `includeHook($hooks, 'position')` at those points.
- **Event hooks** use `body`: `loginSuccess`, `loginFail`, `joinAttempt`, `joinFail`, `createAttempt`, `verifySuccess`, `verifyFail`, `passwordResetSuccess`, `passwordResetFail`, `noAccess`, `hitBanned`, `cloakAttempt`, `cloakBegin`, `cloakEnd` and others. Grep `getMyHooks(['page' =>` in `users/` for the full list.
- Hook code isn't sandboxed. It runs in the page's scope, or inside a function for some events (for example `loginSuccess` from `socialLogin()`), so use `global` for anything it needs. A fatal in a hook breaks the page.

### Plugin migrations

`us_plugins.updates` holds a JSON list of applied plugin migration IDs. In `migrate.php`, check each ID, apply it if missing, append it, and save the list. Make each step idempotent anyway, since activation reruns the file.

---

## Core update components

Core schema changes live in `users/updates/components/<id>.php` (IDs like `2026-11-10a`) and are listed, oldest first, in `$migrations` in `users/includes/migrations.php`. The updater (`users/updates/`) runs every listed component not yet recorded in the `updates` table. The dashboard shows "Your database is out of date" until it has.

```php
<?php
// 2026-12-01a — Add settings.widget_mode. '' keeps today's behavior.
$countE = 0;

$exists = $db->query(
    "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'settings' AND COLUMN_NAME = 'widget_mode'"
)->count();

if ($exists == 0) {
    $db->query("ALTER TABLE `settings` ADD COLUMN `widget_mode` VARCHAR(20) NOT NULL DEFAULT ''");
    if ($db->error()) {
        $countE++;
        logger(1, 'System Updates', '2026-12-01a: ' . $db->errorString());
    }
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
```

- **Always set `$countE = 0` at the top** and increment it on any failure. `_complete.php` records the component in `updates` only when `$countE` is 0; otherwise it reports the error and the component runs again next time. Components share one scope, so a missing reset inherits the previous component's count.
- **Every step must be idempotent: check `INFORMATION_SCHEMA` first.** Fresh installs run the updater right after install (`users/updates/index.php?installing=true`) against a schema that may already have your column or table. An unguarded `ALTER TABLE … ADD COLUMN` fails there.
- **Don't change behavior on existing installs.** Pick defaults that keep what sites do today. A new default for new sites belongs in the installer, not in a component.
- `MODIFY COLUMN` and data fixes need the same care: check the current type or value before changing it.

### New code runs before the updater

Patches replace files immediately; components run only when an admin clicks the updater. Between those moments the new code meets the old schema. So:

```php
$mode = $settings->widget_mode ?? '';          // a column that may not exist yet
$ver  = (int)($row->client_ver ?? 0);          // any row from a table you altered
```

- Read new columns with `?? <old behavior>`, never bare.
- Write a new column only once it exists: check that `$settings` has the property, or run one `INFORMATION_SCHEMA` query (cache the answer for the request).
- Hide admin controls for a feature until its column exists, with a "run the updater" note.

---

## Code that runs on older cores

Plugins often support several core versions. Guard anything new:

```php
$dest = function_exists('consumeLoginDest') ? consumeLoginDest() : '';
$ip   = (class_exists('ClientIP') && method_exists('ClientIP', 'get')) ? ClientIP::get() : Server::getClientIp();
$https = (class_exists('ClientIP') && method_exists('ClientIP', 'isHttps')) ? ClientIP::isHttps() : (Server::get('HTTPS') !== '');
```

| Since | Feature |
|---|---|
| 6.1.6 | `ClientIP::get()`, `ClientIP::peer()` |
| 6.1.8 | `ClientIP::isLocal()`, `ClientIP::isHttps()`, proxy presets, `consumeLoginDest()`, `verifyLoginCredentials()`, `User::checkCredentials()`, `cronCallerAllowed()`, the `$emailVerified` argument to `socialLogin()` |

When a guard can't prove something on an old core, fail closed (treat the request as not local, not trusted). Set `<tested>` in `info.xml` to the newest core you actually tested.

---

## Language strings

Core text comes from `lang('KEY')`, with `%m1%`, `%m2%` markers filled from an array: `lang('MENU_EMAIL', [$address])`.

- **A new core key goes into all 24 files in `users/lang/`** (`en-US.php`, `de-DE.php`, …), translated. A key missing from the visitor's language falls back to the English text; one missing from `en-US.php` too shows "Missing Text - KEY".
- Code that may run before a site has the new language files uses a fallback:

```php
$label = isset($GLOBALS['lang']['MY_NEW_KEY']) ? lang('MY_NEW_KEY') : 'Fallback text';
```

- Sites change wording in `usersc/lang/<code>.php` (e.g. `usersc/lang/en-US.php`), which each core language file includes last. Don't edit `users/lang/` on a site.

---

## CSP nonces for inline script and style

`users/init.php` sets `$userspice_nonce` for each request. Core puts it on every inline `<script>` and `<style>` so a site can send a strict Content-Security-Policy (in `usersc/includes/security_headers.php`) with `'nonce-…'`. Plugin and page code must do the same:

```php
<script nonce="<?=htmlspecialchars($userspice_nonce ?? '')?>">
  document.getElementById('save').addEventListener('click', saveForm);
</script>
<style nonce="<?=htmlspecialchars($userspice_nonce ?? '')?>">
  .my-widget { gap: 1rem; }
</style>
```

- No inline event handlers (`onclick="…"`) or `javascript:` URLs: a nonce can't cover them. Attach listeners from a nonced script or an external file.
- Inside a function or a hook included from one, add `global $userspice_nonce;`.
- External files (`<script src>`, `<link rel="stylesheet">`) from your own site don't need a nonce under a `'self'` policy.

---

## Before you ship

- `php -l` every changed PHP file.
- Activate, deactivate and reactivate the plugin on a test site; run the updater twice; confirm nothing errors the second time.
- Load the pages your code touches before and after running the updater.
- Check the Security Dashboard (`users/admin.php?view=security`).
