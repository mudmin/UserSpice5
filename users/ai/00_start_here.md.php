<?php /* UserSpice AI Prompt — protected from HTTP access. Markdown content below. */ __halt_compiler(); ?>

# UserSpice: Start Here

This is a **UserSpice** project. UserSpice is a PHP user-management framework (auth, permissions, sessions, CSRF, rate limits, admin dashboard, plugins, templates) that sites build their pages on. `users/` is core. `usersc/` is the site's customization layer. App pages live in the project root or in folders added on Admin → Pages.

Read this file first. Load the other prompts in `users/ai/` only when the task calls for them.

## The installed code is the source of truth

These prompts, your training data, and web tutorials can all be out of date. Check the version in `users/includes/user_spice_ver.php` and grep core (`users/`) before you rely on a function, method, setting, hook, or table. If a prompt disagrees with the code, follow the code and say so.

## Non-negotiables

1. **Never edit `users/`.** Core patches overwrite it. Customize through `usersc/` (see `customizing_core`).
2. **Use the helpers.** `Input::get()`, `Server::get()`, `Token::check()`, `Validate`, `Redirect::to()` / `Redirect::sanitized()`, `safeReturn()`, and bound `$db->query($sql, $binds)`. Don't read raw `$_GET` / `$_POST` / `$_SERVER` when a helper exists, and never build SQL from input.
3. **Every page** loads `users/init.php` and calls `securePage()`. **Every state change** is a POST with `Token::check()` plus an auth check. That includes AJAX parsers, which inherit nothing from the page that calls them.
4. **Inside functions, write `global $db;`** (the core helper convention). `DB::getInstance()` returns the same shared connection, so it's fine in classes and CLI scripts.
5. **Never assign to `$config`** at global scope. It holds the framework's configuration.

## Contracts agents get wrong

- `Input::get()` already HTML-escapes (htmlspecialchars, ENT_QUOTES) and returns `''` when the key is missing. Don't escape its result again, because that double-encodes. To echo a value that came through it (including one stored in the DB), use `safeReturn($v, true)`, which decodes first and then escapes once. Use `hed()` when you need the plain text.
- `Input::exists()` takes a type (`'post'` or `'get'`), not a field name.
- `tokenHere()` outputs `name="csrf"`. Check it with `Token::check(Input::get('csrf'))`.
- `$db->insert()` and `$db->update()` return a bool. Get the new id from `$db->lastId()`.
- `hasPerm()` is a global function. The `$user` object has no hasPermission method.
- **Finishing a login:** `$dest = consumeLoginDest()` (the page captured in the session, never a request `dest` or `redirect` parameter), then the loginSuccess hooks (`getMyHooks()` + `includeHook()`), then `usersc/scripts/custom_login_script.php`, then `Redirect::sanitized($dest)`.
- **Checking a username and password:** call `verifyLoginCredentials()`. It applies the rate limit, password check, and ban check, and returns `totp_required`. `User::login()` is a full session login with no rate limit or TOTP. Never use it as a credential check.
- `socialLogin(..., $loginMethod, $emailVerified)`: pass `false` when the provider hasn't verified the email.
- **IPs:** use `ipCheck()` / `ClientIP::get()` for logs, rate limits, and bans, and for an allowlist that sits on top of a secret. Use `ClientIP::peer()` for an allowlist that is the only gate. Use `ClientIP::isLocal()` instead of any 127.0.0.1 or ::1 literal, and `ClientIP::isHttps()` instead of `$_SERVER['HTTPS']`.
- `safeReturn()`, `safeJsonEncodeForJs()`, `trustedHtml()`, and the rate-limit helpers have no function_exists guard. Redefining them in `usersc/` is a fatal error.
- `safeJsonEncodeForJs()` casts its argument to a string, so it is for strings only.
- **CSP:** inline `<script>` and `<style>` tags need the per-request nonce:
  ```php
  <script nonce="<?=htmlspecialchars($userspice_nonce ?? '')?>">
  ```
- **Schema changes must be idempotent.** That covers update components, migrations, and plugin installers. Check INFORMATION_SCHEMA (or `$db->columnExists()`) before any ALTER, because the updater runs right after install and a fresh install may already have the column.
- **New user-facing strings:** core work adds the key to all 24 `users/lang/*.php` files. Site code adds it to `usersc/lang/<code>.php`, and `lang()` falls back to en-US. Plugins use their own lang mechanism.

## Which prompt to load

| Task | Prompt |
|---|---|
| Write a page, form handler, or AJAX parser | `secure_page_pattern` |
| Bootstrap a new page or feature | `new_project` |
| Change what core does (override, hook, custom script) | `customizing_core` |
| "Where does X live?" (file and class map) | `where_to_look` |
| Access control, permissions, "who can see X" | `permissions` |
| Something is broken and you don't know why | `debugging` |
| Login, logout, registration, TOTP, passkeys, reauth | `auth_and_login` |
| Client IPs, proxies, CDNs, Cloudflare, HTTPS detection | `proxies_and_ips` |
| Writing a plugin, update components, migrations | `plugins_and_updates` |
| OAuth client/server, social logins | `oauth` |

Each prompt is `users/ai/<name>.md.php`.

## Overrides

A file with the same name in `usersc/ai/` replaces the core prompt. Files that exist only in `usersc/ai/` are site-specific additions, so list that folder and read anything relevant to your task. If shipped guidance doesn't fit this project, check `usersc/ai/` before assuming it's wrong. Core patches update `users/ai/` and never touch `usersc/ai/`.

Each prompt file starts with a one-line PHP guard that blocks web access. Ignore it and read the Markdown below it.
