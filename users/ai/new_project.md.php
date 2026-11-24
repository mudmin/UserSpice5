<?php /* UserSpice AI Prompt — protected from HTTP access. Markdown content below. */ __halt_compiler(); ?>

# UserSpice: Starting a Page or Feature

Load this when you're adding something new: a page, a form, a table, an AJAX action. To change something core already does, use `customizing_core` instead.

---

## Step 0: Know the install

- **Version:** `users/includes/user_spice_ver.php`. Code that must also run on older cores (plugins, shared snippets) should check `function_exists` or `method_exists` before calling newer APIs.
- **Health:** Admin → Security (`users/admin.php?view=security`) scores the configuration and offers fixes. Admin → Settings (`view=general`) and Registration (`view=reg`) have a tooltip on every option.
- **Spice Shaker** (`view=spice`) needs a free API key from bugs.userspice.com for plugins, templates, language packs, and in-dashboard updates.
- **Site prompts:** check `usersc/ai/` for project-specific instructions before you start.

---

## Step 1: Where the page goes

- **App pages go in the project root**, or in a folder you add on Admin → Pages (`users/admin.php?view=pages`). Folders are stored in `$path` in `z_us_root.php` (default: root, `users/`, `usersc/`).
- **Never in `users/`**, which is core.
- **Not in `usersc/`** unless it's an override point (see `customizing_core`).

---

## Step 2: Create the page

Copy the starter and rename it:

```bash
cp users/_blank_pages/project_root.php contacts.php
```

It contains the canonical skeleton:

```php
<?php
require_once 'users/init.php';                  // '../users/init.php' from a subfolder
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if (!securePage(Server::get('PHP_SELF'))) { die(); }
?>

<div class="row">
  <div class="col-sm-12">
    <!-- content -->
  </div>
</div>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
```

**Registering the page:**
- **First visit as an admin** registers the page in the `pages` table and sends you to its permission screen. Choose public, or private plus the permission levels that may open it.
- **Until then**, non-admins get a "go into the Admin Panel" message instead of the page.
- **New pages default to private** when "New Pages Default To Private" is on (Admin → Settings).

For forms, AJAX, escaping, and validation, follow `secure_page_pattern`. For access rules beyond page level, see `permissions`.

---

## Step 3: A database table

Schema code must be safe to run twice. Use `CREATE TABLE IF NOT EXISTS` and the DB helpers that check first:

```php
<?php
// setup_contacts.php: run once as an admin, then delete it
require_once 'users/init.php';
if (!hasPerm([2])) { die('Admins only'); }

$db->query("
    CREATE TABLE IF NOT EXISTS contacts (
        id         INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id    INT NOT NULL,
        name       VARCHAR(80) NOT NULL,
        email      VARCHAR(120) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");
$db->addColumn('contacts', 'phone', 'VARCHAR(40) NULL');   // returns true without altering if the column exists
$db->addIndex('contacts', 'idx_user', 'user_id');          // skips if the index exists
echo $db->error() ? safeReturn($db->errorString()) : 'Done';
```

- **InnoDB** gives you transactions (`$db->beginTransaction()`, `$db->commit()`, `$db->rollBack()`).
- **utf8mb4** handles every character.
- **Plugins and update components** have their own install and migration flow, with the same idempotency rule: check INFORMATION_SCHEMA or `$db->columnExists()` before any ALTER. See `plugins_and_updates`.

**Everyday queries:**

```php
$rows = $db->query("SELECT * FROM contacts WHERE user_id = ?", [$user->data()->id])->results();
foreach ($rows as $row) {
    echo safeReturn($row->name, true);       // name was stored via Input::get(), so decode then escape once
}

$one = $db->query("SELECT * FROM contacts WHERE id = ?", [$id])->first();   // object, or [] when no row: test with if (!$one)

$db->insert('contacts', ['user_id' => $user->data()->id, 'name' => Input::get('name')]);
$newId = $db->lastId();                       // insert() returns bool, not the id

$db->update('contacts', $newId, ['name' => Input::get('name')]);
$db->deleteById('contacts', $newId);
$db->get('contacts', ['email', '=', $email]);  // simple where array; read with ->results()
```

Inside a function, start with `global $db;`.

---

## Step 4: Shared helpers

Put site-wide functions in `usersc/includes/custom_functions.php`. It loads on every request before the core helpers. Pick names that can't collide with core (a prefix like `myapp_` works). Reusing a core name either overrides that helper or, for unguarded ones, causes a fatal error. See `customizing_core`.

For larger code, put classes in your own folder (for example `lib/`) and load them from `custom_functions.php`, or use Composer through `usersc/vendor/autoload.php`.

---

## Step 5: AJAX

Put the endpoint in a `parsers/` folder beside the calling page. It must check POST, `Token::check()`, login, and authorization itself, then return JSON. Full recipe in `secure_page_pattern`.

---

## Step 6: React to system events

Don't patch core flows. Use the event scripts in `usersc/scripts/`:
- **After login:** `custom_login_script.php`
- **Extra registration fields:** `additional_join_form_fields.php` + `during_user_creation.php`
- **User deleted:** `after_user_deletion.php`
- **Logout:** `just_before_logout.php` / `just_after_logout.php`

The full table is in `customizing_core`.

---

## Step 7: Text, scripts, and styles

- **Text:** user-facing text goes through `lang()` with keys you add in `usersc/lang/<code>.php` (at least en-US; other languages fall back to it).
- **Inline scripts and styles:** add the nonce, or put the code in a `.js` or `.css` file under your own folder and link it with `$us_url_root`:
  ```php
  <style nonce="<?=htmlspecialchars($userspice_nonce ?? '')?>">
  ```
- **jQuery and Bootstrap 5:** the shipped customizer template loads both. Check the active template before assuming any other library.

---

## A complete feature in one file

`contact.php` in the project root shows CSRF, validation, bound SQL, single escaping, redirect after POST, and flash messages:

```php
<?php
require_once 'users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if (!securePage(Server::get('PHP_SELF'))) { die(); }

if (Input::exists()) {
    if (!Token::check(Input::get('csrf'))) {
        include $abs_us_root . $us_url_root . 'usersc/scripts/token_error.php';
    }

    $validate = new Validate();
    $validate->check($_POST, [
        'name'    => ['display' => 'Name',    'required' => true, 'min' => 2, 'max' => 80],
        'email'   => ['display' => 'Email',   'required' => true, 'valid_email' => true],
        'message' => ['display' => 'Message', 'required' => true, 'min' => 10, 'max' => 5000],
    ]);

    if ($validate->passed()) {
        $db->insert('contact_messages', [
            'name'    => Input::get('name'),
            'email'   => Input::get('email'),
            'message' => Input::get('message'),
            'ip'      => ipCheck(),
        ]);
        usSuccess('Thanks, we got your message.');
        Redirect::to($us_url_root . 'contact.php');
    }
    foreach ($validate->errors() as $e) {
        usError(is_array($e) ? $e[0] : $e);
    }
}
?>

<h1>Contact us</h1>
<form method="post">
    <?= tokenHere(); ?>
    <label>Name <input type="text" name="name" value="<?= safeReturn(Input::get('name'), true) ?>"></label>
    <label>Email <input type="email" name="email" value="<?= safeReturn(Input::get('email'), true) ?>"></label>
    <label>Message <textarea name="message"><?= safeReturn(Input::get('message'), true) ?></textarea></label>
    <button type="submit">Send</button>
</form>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
```

A public form like this should also be rate-limited (see the RateLimit section of `secure_page_pattern`).

---

## Before calling it done

- **Test as each kind of visitor:** a guest, a logged-in non-admin, and an admin. Also try a bad CSRF token, malformed and oversized input, and another user's ids.
- **Don't log secrets.** Keep passwords, tokens, and keys out of `logger()` calls.
- **Audit tools:** if the UserSpice companion skills are installed (`/userspice-audit`, `/userspice-page-scaffold`, `/userspice-helper-lookup`), run the audit over files outside `users/`.
