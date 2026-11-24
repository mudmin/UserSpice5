<?php /* UserSpice AI Prompt — protected from HTTP access. Markdown content below. */ __halt_compiler(); ?>

# UserSpice — Permissions and Access Control

Load this when the task is about who can see a page or do an action: permission levels, `securePage()`, `hasPerm()`, tags, the page manager, master accounts, cloaking, or gating an AJAX parser.

Authentication answers "who is this?" Authorization answers "may they do this?" Hiding a button, a menu item or a URL is never authorization. Every page and every endpoint checks on the server.

---

## The data model

| Table | Holds |
|---|---|
| `permissions` | The permission levels: `id`, `name`, `descrip`. Fresh installs have `1` (User) and `2` (Administrator). |
| `user_permission_matches` | Which users have which levels (`user_id`, `permission_id`). A user can have several. |
| `pages` | Every page the framework knows: `page` (path from the site root, e.g. `reports/sales.php`), `title`, `private` (0 = public, 1 = login + permission). |
| `permission_page_matches` | Which levels may open which private pages (`page_id`, `permission_id`). |
| `plg_tags`, `plg_tags_matches` | Tags: labels on users that code can check. |

Levels above 2 are created per site in **Admin → Permissions** (`users/admin.php?view=permissions`), so their IDs differ between installs. Check the `permissions` table before writing `hasPerm(5)`; don't assume.

**Banned is not a level.** A banned user has `users.permissions = 0` (a column on the user row). `users/includes/loader.php` (run by `init.php`) sends any logged-in user with `permissions = 0` to `usersc/scripts/banned.php` on every request, whether or not the page calls `securePage()`. `banned.php` and `logout.php` are exempt, and a cloaked admin has the cloak ended instead. Blacklisted IP addresses are separate: `ipCheckBan()` runs in the same loader.

---

## What `securePage()` does

Every protected page starts with:

```php
require_once '../users/init.php';   // adjust ../ to the page's depth
if (!securePage($_SERVER['PHP_SELF'])) { die(); }
```

The flow (`users/helpers/permissions.php`):

Banned users never reach `securePage()`; the loader has already redirected them.

1. **Page not in `pages`:**
   - An admin visiting it: the row is created (private or public per the "New Pages Default To Private" setting), then the admin is sent to `users/admin.php?view=page&new=yes&id=…` to choose levels. If the page is under `usersc/` and the same path exists under `users/`, its title, privacy and permissions are copied instead, with no setup screen.
   - Anyone else: the text "You must go into the Admin Panel and click the Manage Pages button…", and the request stops. Have an admin open the page once.
2. **Public page** (`private = 0`): returns `true`.
3. **Not logged in:** writes an `audit` row, includes `usersc/scripts/not_logged_in.php`, saves the page with `safelyCaptureDest()` (top-level GET page loads only), redirects to `users/login.php`, returns `false`.
4. **Logged in:** reads `permission_page_matches` for the page. **No rows means admin only (`[2]`).** Access if `hasPerm()` matches any level, or the user is a master account.
5. **Denied:** writes an `audit` row, includes `usersc/scripts/did_not_have_permission.php`, runs `noAccess` hooks, redirects to `Config::get('homepage')` (or the site root), returns `false`.

`securePage()` checks the page as a whole. When several levels can open a page but only some may do a given action, add a `hasPerm()` check around that action.

---

## `hasPerm()`

```php
hasPerm($permissions, $id = null, $masterCheck = true)
```

- `$permissions`: one ID or an array. OR logic: true if the user has any of them.
- `$id`: the user to check. Defaults to the logged-in user; false when nobody is logged in.
- `$masterCheck`: master accounts pass unless you pass `false`.
- Fails closed on a database error (logged).

There is no `hasPermission` method on `User`; use `hasPerm()`.

```php
if (hasPerm(2)) { /* administrators */ }
if (hasPerm([2, 5])) { /* admin OR level 5 */ }
if (hasPerm(2, $otherUserId)) { /* is that user an admin? */ }
if (hasPerm(2, null, false)) { /* strict: master accounts don't bypass */ }
```

To grant or revoke in code use `addPermission($permissionIds, $userIds)` and `removePermission($permissionIds, $userIds)`. Both take a single ID or an array for either argument. `fetchUserPermissions($userId)` lists a user's rows.

---

## Tags

Tags are labels on users, managed at **Admin → User Tags** (`users/admin.php?view=user_tags`). They are not attached to pages; `securePage()` never reads them. Use them in code for finer rules inside a page:

```php
hasTag('beta');                    // by name (case sensitive) or tag ID
hasOneTag(['beta', 'staff']);      // any of them
hasAllTags(['staff', 'billing']);  // all of them
usersWithTag('beta');              // array of user IDs
```

The first three take an optional user ID as their last argument (default: the logged-in user). Use a permission level when the rule is "who may open this page"; use a tag when it is a feature flag or a sub-group inside a page.

---

## Master accounts

`$master_account` in `users/init.php` is an array of user IDs (usually `[1]`). A master account:

- passes `hasPerm()` (unless `$masterCheck` is false) and the denial step of `securePage()`;
- is the only kind of user who may install or configure plugins, open `phpinfo`, use **Admin → Dashboard Access**, or grant cloaking;
- can use the site during maintenance mode.

It exists so you can't lock yourself out. Plugin admin files (`install.php`, `activate.php`, `migrate.php`, `uninstall.php`, `configure.php`) wrap everything in:

```php
if (in_array($user->data()->id, $master_account)) {
    // all actions here
}
```

Inside a function, `global $master_account;` first.

---

## Cloaking (admin "log in as")

An admin can cloak into another user from **Admin → Users → (user)**. While cloaked, `$user` **is the impersonated user**, so `hasPerm()` and `securePage()` answer for that user, not the admin.

- `isCloaked()`: is a cloak active?
- `cloakFrom()`: the admin's real user ID; `cloakTo()`: the impersonated ID.
- `realUserId()`: the person actually at the keyboard.
- `isAdmin()`: true for an admin, or for a cloaked session whose real user is an admin.
- `cloakUser($id)` starts a cloak (it runs `canCloak()`); `endCloak()` ends one.

Who may cloak: users with `cloak_allowed = 1` (only a master account can grant it) and master accounts. Nobody but a master account can cloak into a master account. `usersc/scripts/cloak_attempt.php` and the `cloakAttempt` hook run before the permission check; set `$cloak_attempt_block = true` there to refuse, or call `forceReauth($cloak_resume_url, 'cloak')` to require step-up. Whether a cloaked admin may manage the user's passkeys or TOTP is set in `usersc/includes/custom_cloak_policy.php` (missing file = deny). `logger()` records `cloak_from` on every row written while cloaked.

When code must act as the real person (audit trails, "who approved this"), use `realUserId()`, not `$user->data()->id`.

---

## The page manager

- **Admin → Pages** (`users/admin.php?view=pages`) lists PHP files in the folders named in `$path` in `z_us_root.php` (by default the root, `users/` and `usersc/`) and syncs them with the `pages` table. Pages in other folders are registered the first time an admin opens them.
- **Admin → Pages → (page)** (`users/admin.php?view=page&id=…`) sets the title, public/private and the allowed levels.
- **Admin → Permissions** (`users/admin.php?view=permissions`) creates levels and assigns users.

Registering a page in code (for example in a plugin installer):

```php
$db->insert('pages', ['page' => 'reports/sales.php', 'title' => 'Sales', 'private' => 1]);
if (!$db->error()) {
    $pageId = $db->lastId();
    addPage($pageId, [2, 5]);   // page ID first, then one level or an array
}
```

The `page` value must equal what `securePage()` computes: `$_SERVER['PHP_SELF']` with `$us_url_root` removed.

The `pages.re_auth` column is not enforced by core. For step-up authentication on a sensitive page or action, call `forceReauth()` after `securePage()`:

```php
forceReauth('', 'delete_account');                       // grace window from settings
forceReauth('', 'payout', ['timeout' => 5, 'methods' => ['totp', 'passkey']]);
```

`checkAccess($key, $value)` is the dashboard's own delegated-access check (rows in `us_management`, managed by master accounts). Don't use it for site pages.

---

## Gating AJAX parsers

A parser is its own request. It inherits nothing from the page that called it, so it re-checks everything. Core parsers in `users/parsers/` check login, permission and the CSRF token explicitly, and that is the pattern to copy:

```php
<?php
// admin/parsers/delete_post.php
require_once '../../users/init.php';
header('Content-Type: application/json');

if (!isset($user) || !$user->isLoggedIn()) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Not logged in']));
}
if (!Token::check(Input::get('csrf'))) {
    http_response_code(403);
    die(json_encode(['success' => false, 'message' => 'Invalid token']));
}
if (!hasPerm([2, 5])) {   // the same levels the calling page allows
    http_response_code(403);
    die(json_encode(['success' => false, 'message' => 'Forbidden']));
}

$id = (int)Input::get('id');
// Check ownership too when the record belongs to a user:
// SELECT ... WHERE id = ? AND user_id = ?
$db->query('DELETE FROM posts WHERE id = ?', [$id]);
echo json_encode(['success' => !$db->error()]);
```

Why not `securePage()` in a parser? It answers with an HTML redirect to the login page, and on an unregistered page it prints the "Manage Pages" message and dies for non-admins. Both break a JavaScript fetch caller. If you want the page manager to control a parser, register the parser path first, call `securePage()`, and still return JSON for your own checks.

The page's form provides the token through `tokenHere()` (field name `csrf`), and the JavaScript sends it back. `Token::generate()` returns the same per-session token for a `data-` attribute.

When TOTP is required and not yet verified, AJAX requests get a 401 JSON error from TOTP enforcement instead of a redirect. Handle a 401 in your JavaScript.

---

## Gotchas

- **Redirected to the homepage:** logged in, no matching level. Check `permission_page_matches` for the page and `user_permission_matches` for the user. The `audit` table (Admin → Security Logs) records each denial.
- **Redirect loop:** the homepage itself denies the user, or `did_not_have_permission.php` redirects to another protected page. Make the homepage public.
- **Page wide open:** the page never called `securePage()`, or it's registered as public.
- **Page became admin-only:** its `permission_page_matches` rows were removed. No rows means `[2]`.
- **Path mismatch:** a page registered as `admin/x.php` but reached through a different `$us_url_root` or a symlink is a different page.
- **Admin pages deny a cloaked admin:** expected; `$user` is the target user. Use `isAdmin()` or `realUserId()` when the real operator matters.
- **Hard-coded level IDs:** IDs above 2 vary by install. Read them from the `permissions` table, or document the IDs your feature expects.
