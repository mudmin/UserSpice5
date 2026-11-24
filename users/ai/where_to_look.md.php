<?php /* UserSpice AI Prompt — protected from HTTP access. Markdown content below. */ __halt_compiler(); ?>

# UserSpice: Where to Look

This is the map. When you need to find or change something, it tells you which file to open first. When it's silent, grep: `grep -rn "functionName" users/` for an API, and `grep -rn "usersc/" users/` for override points.

---

## Folder layout

```
project root/
├── z_us_root.php            # marks the install root; $path lists folders scanned for pages
├── users/                   # CORE: replaced by patches, never edit
│   ├── init.php             # bootstrap; holds this site's DB credentials and constants, so patches leave it alone
│   ├── classes/             # DB, Input, Server, ClientIP, Token, Validate, Redirect, User, RateLimit, ...
│   ├── helpers/             # global functions (us_helpers.php, permissions.php, users.php, helpers.php, ...)
│   ├── includes/            # loader.php, template/prep.php, html_footer.php, rate_limits.php, totp_enforcement.php
│   ├── views/               # page bodies and admin screens (_join.php, _admin_*.php)
│   ├── modules/             # admin dashboard building blocks
│   ├── parsers/             # core AJAX endpoints
│   ├── auth/                # passkeys, TOTP, OAuth client/server code and its Composer vendor/
│   ├── updates/             # updater and update components (migrations)
│   ├── cron/                # cron.php runner and core cron jobs
│   ├── lang/                # 24 core language packs
│   ├── logs/                # file activity log
│   ├── ai/                  # these prompts
│   ├── _blank_pages/        # project_root.php starter page
│   └── *.php                # login, join, account, user_settings, admin, logout, verify, reauth, passkeys, ...
├── usersc/                  # SITE CUSTOMIZATION (survives patches, except the shipped customizer template)
│   ├── includes/            # custom_functions.php, loader.php, head_tags.php, footer.php, security_headers.php, ...
│   ├── scripts/             # event scripts (custom_login_script.php, during_user_creation.php, ...)
│   ├── views/               # optional replacements for core form views (create as needed)
│   ├── lang/                # additive language overrides and new keys
│   ├── templates/           # front-end templates (customizer ships with core)
│   ├── plugins/             # plugins; plugins.ini.php records which are active
│   ├── widgets/             # admin dashboard widgets
│   ├── oauth_client/, oauth_server/   # OAuth assets and login scripts
│   ├── ai/                  # optional prompt overrides and site-specific prompts
│   └── <page>.php           # optional replacement for users/<page>.php
└── *.php, your folders/     # APP PAGES go here
```

---

## "I want to..." → open this

| Goal | Where |
|---|---|
| Make a new page | Copy `users/_blank_pages/project_root.php` to the root and rename it (see `new_project`) |
| Add pages in a subfolder | Add the folder on Admin → Pages (`users/admin.php?view=pages`), which edits `$path` in `z_us_root.php` |
| A function available on every page | `usersc/includes/custom_functions.php` |
| Override a core helper | Same file, same name, if core guards it with function_exists (see `customizing_core`) |
| Run code on every request | `usersc/includes/loader.php` |
| `<head>` tags, CSS, favicon | `usersc/includes/head_tags.php` |
| Footer markup or scripts | `usersc/includes/footer.php` |
| CSP and security headers | `usersc/includes/security_headers.php` |
| Rate-limit thresholds or a new limited action | `usersc/includes/rate_limits.php` (core defaults: `users/includes/rate_limits.php`) |
| After-login redirect or logic | `usersc/scripts/custom_login_script.php` |
| Extra registration fields | `usersc/scripts/additional_join_form_fields.php` + `usersc/scripts/during_user_creation.php` |
| Replace the join form | `usersc/views/_join.php` |
| Replace an admin screen | `usersc/includes/admin/_admin_<x>.php` |
| Change or add language strings | `usersc/lang/<code>.php` |
| Composer packages | `usersc/vendor/autoload.php` (loaded automatically) |
| AJAX endpoint | A `parsers/` folder beside the calling page |
| Trusted proxies / CDN | Admin → Proxy & CDN (`users/admin.php?view=proxy`), saved to `usersc/includes/trusted_proxies.php` |
| Page permissions | Admin → Pages; per-page access is in `pages` and `permission_page_matches` |
| Security posture check | Admin → Security (`users/admin.php?view=security`) |
| Logs | Admin → Logs (`view=logs`), Security Logs (`view=security_logs`); file log in `users/logs/` |
| AI assistant pointer files (AGENTS.md / CLAUDE.md) | Admin → AI (`users/admin.php?view=ai`) |
| Installed version | `users/includes/user_spice_ver.php` |

---

## Core classes (`users/classes/`, autoloaded)

| Concern | API |
|---|---|
| Database | `$db` global (inside functions `global $db;`; elsewhere `DB::getInstance()`, the same shared object). Methods: `query()`, `results()`, `first()`, `count()`, `error()`, `errorString()`, `lastId()`, `get()`, `findById()`, `findAll()`, `cell()`, `insert()`, `update()`, `delete()`, `deleteById()`, `tableExists()`, `columnExists()`, `addColumn()`, `addIndex()`, `beginTransaction()`, `commit()`, `rollBack()`. Second DB: `DB::getShared()` (pooled) or `DB::getDB()` (new connection). |
| Request input | `Input::get()` (escaped; `''` if missing), `Input::exists()` (`'post'`/`'get'`), `Input::sanitize()`, `Input::json()` |
| Server vars | `Server::get()`, `Server::isCli()`, `Server::getHost()`, `Server::getOrigin()`, `Server::getScheme()` |
| Client IP / HTTPS | `ClientIP::get()` (same as `ipCheck()`), `ClientIP::peer()`, `ClientIP::isLocal()`, `ClientIP::isHttps()`, `ClientIP::isProxied()` |
| CSRF | `Token::generate()`, `Token::check()`; form field via `tokenHere()` (`name="csrf"`) |
| Validation | `Validate` class: `check()`, `passed()`, `errors()`, `display_errors()` |
| Redirects | `Redirect::to()` (fixed targets), `Redirect::sanitized()` (untrusted targets, same-origin by default) |
| Sessions / cookies | `Session::get()`, `Session::put()`, `Session::exists()`, `Session::delete()`, `Session::flash()`; `Cookie::get()`, `Cookie::put()`, `Cookie::delete()` |
| Hashing / tokens | `Hash::unique()` (random 64-hex token), `Hash::make()` (sha256, not for passwords) |
| Rate limiting | `RateLimit` class: `check()`, `record()`, `clearFailed()`, `getStatus()` |
| Current user | `$user` global: `isLoggedIn()`, `data()` (the users row). Permission checks use the global `hasPerm()`. |
| Config | `Config::get('mysql/host')` style paths into `$GLOBALS['config']` |
| Server-side tables | `DataTableRequest` (safe ORDER BY / LIMIT for DataTables) |

---

## Core helpers (`users/helpers/`)

| Function | Purpose | File |
|---|---|---|
| `securePage()` | Page access guard | `permissions.php` |
| `hasPerm()` | Does the user hold permission id(s)? `hasPerm([2])` = admin | `permissions.php` |
| `consumeLoginDest()` / `safelyCaptureDest()` | Read-and-clear / capture the post-login destination | `permissions.php` |
| `verifyLoginCredentials()` | Check a username and password without logging in | `users.php` |
| `socialLogin()` | Finish a social/OAuth login | `users.php` |
| `tokenHere()` | Echo the CSRF hidden input | `us_helpers.php` |
| `safeReturn()` | Escape for HTML (`true` second arg decodes first) | `us_helpers.php` |
| `hed()` | Decode HTML entities | `us_helpers.php` |
| `safeJsonEncodeForJs()` | String into a `<script>` | `us_helpers.php` |
| `trustedHtml()` | Mark trusted HTML for the taint scanner (no escaping) | `us_helpers.php` |
| `usError()` / `usSuccess()` / `usWarning()` | Flash banners | `us_helpers.php` |
| `lang()` | Language string, with `%m1%` markers | `us_helpers.php` |
| `logger()` | Write to the `logs` table | `us_helpers.php` |
| `ipCheck()` | Resolved visitor IP | `us_helpers.php` |
| `getMyHooks()` / `includeHook()` / `registerHooks()` | Plugin hook system | `us_helpers.php` |
| `currentPage()` | Current script filename | `helpers.php` |
| `email()` | Send mail through the configured transport | `helpers.php` |
| `spiceEncrypt()` / `spiceDecrypt()` | AES-256-GCM at rest (`spiceEncrypt()` returns an array; store `['encrypted']`) | `helpers.php` |
| `checkRateLimit()` / `handleAuthFailure()` / `handleAuthSuccess()` | Rate-limit wrappers used by login code | `rate_limit_helpers.php` |

Before relying on a signature, open the definition: `grep -rn "function name" users/helpers users/classes`.

---

## Globals after `users/init.php`

| Global | Holds |
|---|---|
| `$db` | Shared DB connection |
| `$user` | Current `User` object |
| `$settings` | Row 1 of the `settings` table |
| `$config` | Config tree (DB credentials, session and token names). **Never assign to it.** |
| `$abs_us_root` / `$us_url_root` | Document root path / URL path to the install (ends in `/`) |
| `$master_account` | User ids with master rights (set in `users/init.php`) |
| `$userspice_nonce` | CSP nonce for inline scripts and styles |
| `$lang` | Active language array (read it through `lang()`) |
| `$usplugins` | Plugin name → active flag |

---

## Tables you'll see most

| Table | Holds |
|---|---|
| `users` | Accounts (`permissions = 0` means banned) |
| `permissions` | Permission levels (1 = User, 2 = Administrator by default) |
| `user_permission_matches` | Which users hold which permissions |
| `pages` | Registered pages (`private`, `re_auth`) |
| `permission_page_matches` | Which permissions may open which pages |
| `settings` | Site settings (`$settings`) |
| `logs` | Activity log written by `logger()` |
| `audit` | Denied page hits |
| `us_rate_limits` | Rate-limit attempts |
| `us_ip_blacklist` / `us_ip_whitelist` | IP bans and exceptions |
| `us_plugin_hooks` | Registered plugin hooks |
| `us_totp_secrets`, `us_passkeys` | 2FA and passkey credentials |
| `updates` | Applied update components |
| `us_menus`, `us_menu_items` | Menus |
| `plg_tags`, `plg_tags_matches` | User tags |
