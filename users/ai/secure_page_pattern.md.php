<?php /* UserSpice AI Prompt — protected from HTTP access. Markdown content below. */ __halt_compiler(); ?>

# UserSpice: The Secure Page Pattern

Load this when you're writing the code for a page, form handler, or AJAX endpoint. It's the recipe shipped core pages follow. When in doubt, open `users/_blank_pages/project_root.php` or a core page like `users/account.php` and match it.

---

## The skeleton

```php
<?php
require_once 'users/init.php';   // '../users/init.php' one folder down, '../../users/init.php' two down
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if (!securePage(Server::get('PHP_SELF'))) { die(); }
?>

<!-- page content -->

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
```

1. **`users/init.php`** bootstraps everything. After it runs, `$db`, `$user`, `$settings`, `$abs_us_root`, `$us_url_root`, and every core class and helper exist. This is the only include that uses a relative path, because the root variables don't exist until it runs.
2. **`prep.php`** loads the active template: header, navigation, and the message banners.
3. **`securePage()`** checks the page against the `pages` and `permission_page_matches` tables. Public pages pass, and private pages require login and a matching permission. (Banned users are already sent away by `users/includes/loader.php`.) Skip it and the page is wide open.
4. **`html_footer.php`** closes the template, renders the flash messages, and runs plugin and `usersc/includes/footer.php` footers. A page that loads `prep.php` must end with it.

Pages that don't use the template (JSON endpoints, file downloads) skip `prep.php` and `html_footer.php`.

### Paths

- **Filesystem** (`require_once`, `include`, `file_exists`): `$abs_us_root . $us_url_root . 'path/file.php'`. Don't build include paths from `__DIR__`, dirname of `__FILE__`, or `../` chains.
- **URLs** (href, src, redirects): `$us_url_root . 'path/file.php'`. `$us_url_root` always ends in `/` and may be a subpath like `/myapp/`, so a hard-coded leading `/` or `../` breaks subpath installs.

```php
<link rel="stylesheet" href="<?= $us_url_root ?>assets/site.css">
<a href="<?= $us_url_root ?>users/account.php">Account</a>
Redirect::to($us_url_root . 'contacts.php');
```

---

## Page with a form: CSRF, then validate, then write, then redirect

```php
<?php
require_once 'users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if (!securePage(Server::get('PHP_SELF'))) { die(); }

if (Input::exists()) {                              // "is this a POST with data?"
    if (!Token::check(Input::get('csrf'))) {
        include $abs_us_root . $us_url_root . 'usersc/scripts/token_error.php'; // shows the error and dies
    }

    $validate = new Validate();
    $validate->check($_POST, [                      // passing $_POST as the source is the core pattern
        'name'  => ['display' => 'Name',  'required' => true, 'min' => 2, 'max' => 80],
        'email' => ['display' => 'Email', 'required' => true, 'valid_email' => true],
    ]);

    if ($validate->passed()) {
        $db->insert('contacts', [
            'name'    => Input::get('name'),        // stored HTML-escaped, which is the core convention
            'email'   => Input::get('email'),
            'user_id' => $user->data()->id,
        ]);
        usSuccess('Saved.');
        Redirect::to($us_url_root . 'contacts.php'); // redirect after POST so a refresh doesn't resubmit
    }
    foreach ($validate->errors() as $e) {
        usError(is_array($e) ? $e[0] : $e);         // shown by html_footer.php on this same request
    }
}
?>

<form method="post">
    <?= tokenHere(); ?>
    <label>Name  <input type="text"  name="name"  value="<?= safeReturn(Input::get('name'), true) ?>"></label>
    <label>Email <input type="email" name="email" value="<?= safeReturn(Input::get('email'), true) ?>"></label>
    <button type="submit">Save</button>
</form>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
```

Each step gates the next. If the CSRF check fails, stop. If validation fails, don't write. After a successful write, redirect.

`$validate->display_errors()` returns an HTML list if you'd rather render errors next to the form. It also emits small inline scripts without a nonce, which a strict CSP will block. The list still shows.

**Leave the form `action` empty** (or set `action=""`) so it posts back to the same file that holds the handler. A hand-written action (`contacts.php`, `#`, `.`) breaks on subpath installs or posts to the wrong place. Only set one when the form really targets a different page.

---

## Output escaping

`Input::get()` already runs htmlspecialchars with ENT_QUOTES. Escaping its result again turns `&` into `&amp;amp;`.

| Value | Echo it with |
|---|---|
| Came through `Input::get()`, now or stored in the DB earlier | `safeReturn($v, true)`, which decodes and then escapes once |
| Any other text (an API response, a computed value, DB data written by other code) | `safeReturn($v)` |
| A string going into a `<script>` block | `safeJsonEncodeForJs($v)`. It casts to string, so arrays need a json_encode call with `JSON_HEX_TAG \| JSON_HEX_APOS \| JSON_HEX_QUOT \| JSON_HEX_AMP` |
| HTML you trust and meant to keep (admin-authored content) | `trustedHtml($v)`. This is a marker for the taint scanner and does no escaping. |
| Plain text needed for an email body, an external API, or a comparison | `hed($v)` |

```php
<script nonce="<?=htmlspecialchars($userspice_nonce ?? '')?>">
  const greeting = <?= safeJsonEncodeForJs($row->greeting) ?>;
</script>
```

---

## AJAX endpoint (a `parsers/` folder)

Put AJAX endpoints in a `parsers/` folder next to the page that calls them, as core does with `users/parsers/`. The optional clean-URL rewrite rules exempt `/parsers` paths, so an endpoint placed elsewhere can break when those rules are on.

A parser is a separate request. It must do its own method, CSRF, and auth checks. Don't call `securePage()` from it: that answers with redirects and HTML (the login page or the page-setup screen), which a fetch or XHR caller can't use, and it needs the parser registered on Admin → Pages. Check access explicitly the way core parsers do.

```php
<?php
// contacts/parsers/delete_contact.php
require_once '../../users/init.php';
header('Content-Type: application/json');

if (Server::get('REQUEST_METHOD') !== 'POST') {
    http_response_code(405);
    die(json_encode(['success' => false, 'msg' => 'POST required']));
}
if (!Token::check(Input::get('csrf'))) {
    http_response_code(403);
    die(json_encode(['success' => false, 'msg' => 'Invalid token']));
}
if (!$user->isLoggedIn()) {
    http_response_code(401);
    die(json_encode(['success' => false, 'msg' => 'Login required']));
}

$id = (int)Input::get('id');
if ($id <= 0) {
    http_response_code(400);
    die(json_encode(['success' => false, 'msg' => 'Bad id']));
}

// Authorization: admins (permission 2) can delete any row; everyone else only their own
if (hasPerm([2])) {
    $db->query("DELETE FROM contacts WHERE id = ?", [$id]);
} else {
    $db->query("DELETE FROM contacts WHERE id = ? AND user_id = ?", [$id, $user->data()->id]);
}
echo json_encode(['success' => !$db->error() && $db->count() > 0]);
```

Call it from the page with the token `tokenHere()` already put in the form:

```html
<script nonce="<?=htmlspecialchars($userspice_nonce ?? '')?>">
async function deleteContact(id) {
  const body = new URLSearchParams({
    csrf: document.querySelector('input[name="csrf"]').value,
    id: id
  });
  const res = await fetch('parsers/delete_contact.php', { method: 'POST', body });
  return res.json();
}
</script>
```

`Input::get()` reads POST and then GET, so a CSRF check alone would also accept a token in the query string. The REQUEST_METHOD check is what keeps state changes on POST.

---

## Use the helper, not raw PHP

| Don't | Do |
|---|---|
| `$_POST['x']`, `$_GET['x']` | `Input::get('x')`, or `Input::get('x', 'default')` for a default |
| `$_SERVER['HTTP_HOST']`, `$_SERVER['PHP_SELF']` | `Server::get('HTTP_HOST')`, `Server::get('PHP_SELF')`; `Server::getHost()` / `Server::getOrigin()` behind proxies |
| `$_SERVER['REMOTE_ADDR']` | `ipCheck()` for logs, rate limits, and bans; `ClientIP::peer()` for an allowlist that is the only gate (see `proxies_and_ips`) |
| `$_SERVER['HTTPS']`, `$ip === '127.0.0.1'` | `ClientIP::isHttps()`, `ClientIP::isLocal()` |
| A header('Location: ...') call | `Redirect::to($us_url_root . 'page.php')` for fixed targets; `Redirect::sanitized($target)` for anything user-influenced (same-origin by default, strips control characters, turns `//host` and `javascript:` targets into on-site paths, roots relative paths at `$us_url_root`) |
| md5 of uniqid, or mt_rand, for tokens | `Hash::unique()` (64 hex characters from random_bytes) |
| SQL with values concatenated in | `$db->query("... WHERE x = ?", [$x])` |
| Hand-rolled field checks | The `Validate` class: `$validate->check($_POST, $rules)` |
| Plaintext secrets in the DB | `spiceEncrypt($v)`, which returns an array; store its `['encrypted']` value and read it back with `spiceDecrypt($stored)` |
| An `echo` of an error before a redirect | `usError()` / `usSuccess()`, which survive the redirect |

---

## SQL identifiers and LIMIT/OFFSET

Placeholders bind values only. Table names, column names, sort direction, and LIMIT/OFFSET can't be bound, and PDO quotes bound values (so `LIMIT '10'` fails). Allowlist identifiers and cast numbers to int in named variables:

```php
$allowedCols = ['id', 'name', 'created_at'];
$col = in_array(Input::get('sort'), $allowedCols, true) ? Input::get('sort') : 'id';
$dir = strtoupper(Input::get('dir')) === 'ASC' ? 'ASC' : 'DESC';

$page    = max(1, (int)Input::get('page', 1));
$perPage = in_array((int)Input::get('per_page', 25), [10, 25, 50, 100], true) ? (int)Input::get('per_page', 25) : 25;
$offset  = ($page - 1) * $perPage;

$rows = $db->query("SELECT * FROM contacts ORDER BY $col $dir LIMIT $offset, $perPage")->results();
```

For DataTables server-side endpoints, `DataTableRequest` builds a safe ORDER BY and LIMIT for you (see `users/parsers/ssp_users.php`).

---

## `insert()` and `update()` return bool

```php
$db->insert('contacts', ['name' => $name]);
if (!$db->error()) {
    $newId = $db->lastId();                 // not the return value of insert()
}

$db->update('contacts', $newId, ['name' => $newName]);   // second argument: an id, or a where array
if (!$db->error()) {
    $changed = $db->count();                // affected rows
}
```

Check `$db->error()` before you read `lastId()` or `count()`. Both reflect the most recent query on the connection.

---

## `Input` gotchas

- A missing key returns `''`, not `false` or `null`. Test it with `=== ''` or with empty.
- `Input::exists()` is "was there any POST data" (or `Input::exists('get')` for query data). `Input::exists('action')` is always `false`, so the block it guards never runs. To test a specific field, use `Input::get('action') === 'save'`.
- The default value is returned as-is, without escaping.
- Arrays come back escaped recursively, keys included.

---

## Validate rules

`$validate->check($source, $rules)` collects every error. `$validate->passed()` reports the result, and `$validate->errors()` returns `[message, field]` pairs.

| Rule | Checks |
|---|---|
| `display` | Label used in messages (required on every field) |
| `required` | Not empty |
| `min` / `max` | String length |
| `matches` | Equals another field: `'matches' => 'password'` |
| `unique` | Not already in table; column = field name: `'unique' => 'users'` |
| `unique_update` | Like unique but ignores one row. The value is **comma**-separated: `'unique_update' => 'users,' . $id` |
| `valid_email` / `is_not_email` | Is / isn't an email |
| `is_numeric` / `is_num`, `is_integer` / `is_int` | Numeric / integer |
| `<` `>` `<=` `>=` `!=` `==` | Numeric comparison: `'>' => 0` |
| `in` | In a fixed list: `'in' => ['a', 'b']` |
| `is_in_array` | In a runtime array |
| `is_in_database` | Exists. Either `'is_in_database' => 'categories'` (column = field name) or `['categories', ['slug', '=', $value]]` |
| `is_datetime`, `is_timezone`, `is_valid_north_american_phone` | Format checks |

All rules except `required` are skipped when the field is empty. Add `'required' => true` if empty isn't allowed.

---

## Rate-limit auth-adjacent and expensive endpoints

```php
$rl  = new RateLimit();
$ids = ['ip' => ipCheck(), 'email' => $email];
if (!$rl->check('contact_form', $ids)) {
    usError('Too many attempts. Try again later.');
    Redirect::to($us_url_root . 'contact.php');
}
// ... do the work ...
$rl->record('contact_form', $ids, $ok);   // $ok = true on success
```

`check()` returns `true` for any action with no limits configured, so a new action does nothing until you define it in `usersc/includes/rate_limits.php`:

```php
$rateLimits['contact_form']['ip_max'] = 5;        // ip_max and ip_window are required
$rateLimits['contact_form']['ip_window'] = 3600;
$rateLimits['contact_form']['email_max'] = 3;
$rateLimits['contact_form']['email_window'] = 3600;
```

The Admin → Rate Limits screen rewrites that file from what it lists: `ip_`, `user_`, `email_`, and `total_` limits per action. Use those identifier types and plain assignment lines like the ones above, or a save from the dashboard will drop your changes.

Core action names include `login_attempt`, `registration_attempt`, `password_reset_request`, `password_reset_submit`, `email_verification`, `totp_verify`, and `passkey_auth`. See `users/includes/rate_limits.php` for the full list. `checkRateLimit()` and `handleAuthFailure()` / `handleAuthSuccess()` are the wrappers core login code uses.

---

## Checklist before you call it done

- [ ] `users/init.php` → `prep.php` → `securePage()` … `html_footer.php` (or init plus explicit checks for a parser)
- [ ] Every state change is POST, `Token::check()` comes first, then auth and ownership checks
- [ ] Every SQL value is bound; every identifier is allowlisted; LIMIT/OFFSET are cast to int
- [ ] Output escaped once: `safeReturn($v, true)` for Input-derived values, `safeReturn($v)` for other text
- [ ] No raw `$_GET` / `$_POST` / `$_SERVER` reads where a helper exists
- [ ] Redirect after a successful POST; user-influenced targets use `Redirect::sanitized()`
- [ ] Inline scripts and styles carry the `$userspice_nonce` nonce
- [ ] New user-facing strings go through `lang()` keys in `usersc/lang/`
- [ ] Login, registration, reset, and expensive endpoints are rate-limited
