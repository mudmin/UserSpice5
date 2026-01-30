<?php

//UserSpice User-Related functions
//Do not deactivate!

//Check if a user ID exists in the DB
if (!function_exists('userIdExists')) {
  function userIdExists($id)
  {
    $db = DB::getInstance();
    $query = $db->query('SELECT * FROM users WHERE id = ?', [$id]);
    $num_returns = $query->count();
    if ($num_returns == 1) {
      return true;
    } else {
      return false;
    }
  }
}


//Retrieve complete user info by id ID
if (!function_exists('fetchUser')) {
  function fetchUser($id)
  {
    global $db;
    $query = $db->query("SELECT * FROM users WHERE id = ?", [$id]);
    if ($query->count() > 0) {
      return $query->first();
    } else {
      return false;
    }
  }
}



//Delete a defined array of users
if (!function_exists('deleteUsers')) {
  function deleteUsers($users)
  {
    global $db, $abs_us_root, $us_url_root;

    $i = 0;
    foreach ($users as $id) {
      $query1 = $db->query('DELETE FROM users WHERE id = ?', [$id]);
      $query2 = $db->query('DELETE FROM user_permission_matches WHERE user_id = ?', [$id]);
      if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/after_user_deletion.php')) {
        include $abs_us_root . $us_url_root . 'usersc/scripts/after_user_deletion.php';
      }
      ++$i;
    }

    return $i;
  }
}

if (!function_exists('echouser')) {
  function echouser($id, $echoType = null, $return = false)
  {
    global $db, $settings;

    if ($id == "" || $id == 0) {
      $string = "Guest";
    } else {
      $id = (int) $id;
      $echoType = ($echoType !== null) ? (int) $echoType : $settings->echouser;

      $query = $db->query('SELECT username, fname, lname FROM users WHERE id = ? LIMIT 1', [$id]);
      if ($query->count() == 0) {
        $string = "Unknown";
      } else {
        $user = $query->first();
        switch ($echoType) {
          case 0:
            $string = $user->fname . ' ' . $user->lname;
            break;
          case 1:
            $string = ucfirst($user->username);
            break;
          case 2:
            $string = ucfirst($user->username) . ' (' . $user->fname . ' ' . $user->lname . ')';
            break;
          case 3:
            $string = ucfirst($user->username) . ' (' . $user->fname . ')';
            break;
          case 4:
            $string = ucfirst($user->fname) . ' ' . substr(ucfirst($user->lname), 0, 1);
            break;
          default:
            $string = "Unknown";
        }
      }
    }

    if ($return) {
      return safeReturn($string);
    }
    echo safeReturn($string);
  }
}


if (!function_exists('echousername')) {
  function echousername($id)
  {
    global $db;
    $query = $db->query('SELECT username FROM users WHERE id = ? LIMIT 1', [$id]);
    $count = $query->count();
    if ($count > 0) {
      $results = $query->first();

      return safeReturn($results->username);
    } else {
      return 'Unknown';
    }
  }
}

if (!function_exists('isAdmin')) {
  function isAdmin()
  {
    if (hasPerm(2) || (isset($_SESSION['cloak_from']) && hasPerm(2, $_SESSION['cloak_from']))) {
      return true;
    } else {
      return false;
    }
  }
}

if (!function_exists('name_from_id')) {
  function name_from_id($id)
  {
    global $db;
    $query = $db->query('SELECT username FROM users WHERE id = ? LIMIT 1', [$id]);
    $count = $query->count();
    if ($count > 0) {
      $results = $query->first();

      return ucfirst($results->username);
    } else {
      return '-';
    }
  }
}


//checks if a user has a tag by either tag id or tag name (case sensitive)
if (!function_exists("hasTag")) {
  function hasTag($tag, $user_id = "")
  {
    global $db, $user;

    if ($user_id == "") {
      if ($user_id == "" && isset($user) && $user->isLoggedIn()) {
        $user_id = $user->data()->id;
      }
    }

    if (!is_numeric($user_id) || $user_id < 0 || $user_id == "") {
      return false;
    }

    if (is_numeric($tag)) {
      $c = $db->query("SELECT * FROM plg_tags_matches WHERE tag_id = ? AND user_id = ?", [$tag, $user_id])->count();
      if ($c < 1) {
        return false;
      } else {
        return true;
      }
    } else {
      $c = $db->query("SELECT * FROM plg_tags_matches WHERE tag_name = ? AND user_id = ?", [$tag, $user_id])->count();
      if ($c < 1) {
        return false;
      } else {
        return true;
      }
    }
    return false;
  }
}

//user must have at least one of the tags in the array
if (!function_exists("hasOneTag")) {
  function hasOneTag($tags, $user_id = "")
  {
    global $db, $user;
    if ($user_id == "") {
      if ($user_id == "" && isset($user) && $user->isLoggedIn()) {
        $user_id = $user->data()->id;
      }
    }

    if (!is_numeric($user_id) || $user_id < 0 || $user_id == "") {
      return false;
    }

    if (!is_array($tags)) {
      return false;
    }

    foreach ($tags as $t) {
      if (hasTag($t, $user_id)) {
        return true;
      }
    }
    return false;
  }
}

//user must have all of the tags in the array
if (!function_exists("hasAllTags")) {
  function hasAllTags($tags, $user_id = "")
  {
    global $db, $user;
    if ($user_id == "") {
      if ($user_id == "" && isset($user) && $user->isLoggedIn()) {
        $user_id = $user->data()->id;
      }
    }

    if (!is_numeric($user_id) || $user_id < 0 || $user_id == "") {
      return false;
    }

    if (!is_array($tags)) {
      return false;
    }

    foreach ($tags as $t) {
      if (!hasTag($t, $user_id)) {
        return false;
      }
    }
    return true;
  }
}


//returns an array of users with a given tag by tag name or id
if (!function_exists("usersWithTag")) {
  function usersWithTag($tag)
  {
    $db = DB::getInstance();
    $users = [];
    if (is_numeric($tag)) {
      $q = $db->query("SELECT user_id FROM plg_tags_matches WHERE tag_id = ?", [$tag])->results();
      foreach ($q as $t) {
        $users[] = $t->user_id;
      }
      return $users;
    } else {
      $q = $db->query("SELECT user_id FROM plg_tags_matches WHERE tag_name = ?", [$tag])->results();
      foreach ($q as $t) {
        $users[] = $t->user_id;
      }
      return $users;
    }
    return $users;
  }
}


if (!function_exists('socialLogin')) {
  function socialLogin($email, $username, $idArray, $fields, $loginMethod = null)
  {
    global $db, $settings, $abs_us_root, $us_url_root;

    // =========================================================================
    // #1: Sanitize $idArray - only allow valid column names from users table
    // =========================================================================
    $userColumns = socialLoginGetUserColumns($db);
    $sanitizedIdArray = [];
    foreach ($idArray as $key => $value) {
      // Key must be a valid SQL identifier
      if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key)) {
        continue;
      }
      // Key must exist as a column in users table
      if (!in_array($key, $userColumns, true)) {
        continue;
      }
      // Value must be non-empty
      if ($value === null || $value === '') {
        continue;
      }
      $sanitizedIdArray[$key] = $value;
    }

    // =========================================================================
    // #2: Normalize email and handle blank email case
    // =========================================================================
    $email = trim((string)$email);
    $hasValidEmail = ($email !== '');

    // Build query parts as arrays (proper condition builder)
    $idConditions = [];
    $idParams = [];
    foreach ($sanitizedIdArray as $key => $value) {
      $idConditions[] = "`$key` = ?";
      $idParams[] = $value;
    }

    // If no email and no provider IDs, we can't identify the user
    // Keep original behavior: redirect to join.php without error param
    if (!$hasValidEmail && empty($sanitizedIdArray)) {
      session_destroy();
      Redirect::to($us_url_root . 'users/join.php');
      die();
    }

    // =========================================================================
    // #3: Provider-ID-first lookup (non-breaking pre-check)
    // =========================================================================
    $existingUser = null;

    // First, try to find by provider ID (more reliable than email)
    // Use known provider order for deterministic behavior when multiple IDs present
    if (!empty($sanitizedIdArray)) {
      $providerPriority = ['oauth_uid', 'google_id', 'github_id', 'disc_uid', 'facebook_id', 'twitter_id', 'twitch_id', 'okta_id', 'microsoft_id'];
      $providerKey = null;
      $providerValue = null;

      // Find first matching provider in priority order
      foreach ($providerPriority as $pKey) {
        if (isset($sanitizedIdArray[$pKey])) {
          $providerKey = $pKey;
          $providerValue = $sanitizedIdArray[$pKey];
          break;
        }
      }
      // Fall back to first key if no priority match
      if ($providerKey === null) {
        $providerKey = array_key_first($sanitizedIdArray);
        $providerValue = $sanitizedIdArray[$providerKey];
      }

      $providerCheck = $db->query("SELECT * FROM users WHERE `$providerKey` = ? LIMIT 1", [$providerValue]);
      if ($providerCheck->count() > 0) {
        $existingUser = $providerCheck->first();
      }
    }

    // Fall back to email OR provider ID lookup if provider-first didn't match
    if ($existingUser === null) {
      if ($hasValidEmail && !empty($idConditions)) {
        // email OR provider_id OR provider_id2 ...
        $whereClause = "email = ? OR " . implode(' OR ', $idConditions);
        $findExistingUS = $db->query("SELECT * FROM users WHERE " . $whereClause . " LIMIT 1", array_merge([$email], $idParams));
      } elseif ($hasValidEmail) {
        // email only
        $findExistingUS = $db->query("SELECT * FROM users WHERE email = ? LIMIT 1", [$email]);
      } elseif (!empty($idConditions)) {
        // provider IDs only (no email)
        $whereClause = implode(' OR ', $idConditions);
        $findExistingUS = $db->query("SELECT * FROM users WHERE " . $whereClause . " LIMIT 1", $idParams);
      } else {
        $findExistingUS = null;
      }

      if ($findExistingUS !== null && $findExistingUS->count() > 0) {
        $existingUser = $findExistingUS->first();
      }
    }

    // Handle no registration allowed
    if ($settings->registration == 0 && $existingUser === null) {
      session_destroy();
      Redirect::to($us_url_root . 'users/join.php');
      die();
    }

    // =========================================================================
    // #4: Mass-assignment hardening - filter $fields
    // =========================================================================
    $protectedFields = [
      'id',
      'permissions',
      'password',
      'pin',
      'active',
      'protected',
      'dev_user',
      'email_verified',
      'vericode',
      'vericode_expiry',
      'join_date',
      'last_login',
      'logins',
      'force_pr',
      'account_owner',
      'account_id',
    ];

    // Filter incoming $fields to remove protected columns and invalid keys
    $filteredFields = [];
    foreach ($fields as $key => $value) {
      // Key must be valid identifier
      if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key)) {
        continue;
      }
      // Key must exist in users table
      if (!in_array($key, $userColumns, true)) {
        continue;
      }
      // Key must not be protected
      if (in_array($key, $protectedFields, true)) {
        continue;
      }
      $filteredFields[$key] = $value;
    }

    // For existing users, don't allow OAuth to overwrite email
    $isNewUser = ($existingUser === null);
    if (!$isNewUser) {
      unset($filteredFields['email']);
    }

    // Handle existing user
    if ($existingUser !== null) {
      $user = new User($existingUser->id);
      $date = date('Y-m-d H:i:s');
      $db->query('UPDATE users SET last_login = ?, logins = logins + 1 WHERE id = ?', [$date, $user->data()->id]);
      $_SESSION['last_confirm'] = date('Y-m-d H:i:s');
      $db->insert('logs', ['logdate' => $date, 'user_id' => $user->data()->id, 'logtype' => 'Login', 'lognote' => 'User logged in.', 'ip' => ipCheck()]);
      $ip = ipCheck();
      $q = $db->query('SELECT id FROM us_ip_list WHERE ip = ?', [$ip]);
      $c = $q->count();
      if ($c < 1) {
        $db->insert('us_ip_list', [
          'user_id' => $user->data()->id,
          'ip' => $ip,
          'timestamp' => date('Y-m-d H:i:s'),
        ]);
      } else {
        $f = $q->first();
        $db->update('us_ip_list', $f->id, [
          'user_id' => $user->data()->id,
          'ip' => $ip,
          'timestamp' => date('Y-m-d H:i:s'),
        ]);
      }

      // Update with filtered fields only
      if (!empty($filteredFields)) {
        $user->update($filteredFields);
      }

    // Handle new user
    } else {
      // #2 continued: If no valid email, don't create new user
      if (!$hasValidEmail) {
        session_destroy();
        Redirect::to($us_url_root . 'users/join.php?err=' . urlencode('Email address required to create account'));
        die();
      }

      $user = new User();

      if (isset($_SESSION['us_lang'])) {
        $newLang = $_SESSION['us_lang'];
      } else {
        $newLang = $settings->default_language;
      }
      $date = date("Y-m-d H:i:s");

      // #7: Removed duplicate join_date assignment
      $defaultFields = [
        'username' => generateUsername($username, $filteredFields['fname'] ?? "", $filteredFields['lname'] ?? "", $email),
        'email' => $email,
        'password' => null,
        'permissions' => 1,
        'oauth_tos_accepted' => false,
        'language' => $newLang,
        'logins' => 1,
        'join_date' => $date,
        'last_login' => $date,
        'email_verified' => 1,
      ];

      // Merge: defaults first, then filtered OAuth fields (can add profile fields but not override security)
      $createFields = array_merge($defaultFields, $filteredFields);

      // Re-apply protected defaults that OAuth shouldn't override
      $createFields['permissions'] = 1;
      $createFields['email_verified'] = 1;
      $createFields['join_date'] = $date;
      $createFields['last_login'] = $date;
      $createFields['logins'] = 1;

      $activeCheck = $db->query('SELECT active FROM users LIMIT 1');
      if (!$activeCheck->error()) {
        $createFields['active'] = 1;
      }

      $theNewId = $user->create($createFields);
      $user->find($theNewId);

      if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/during_user_creation.php')) {
        include $abs_us_root . $us_url_root . 'usersc/scripts/during_user_creation.php';
      }

      logger($theNewId, 'User', 'Registration completed using Social Login.');
    }
    $user->login();
    if (!isset($_SESSION['redirect'])) {
      $_SESSION['redirect'] = null;
    }

    if ($loginMethod !== null) {
      setLoginMethod($loginMethod);
    } else {
      $backtrace = debug_backtrace();
      $filePath = $backtrace[0]['file'];
      if (strpos($filePath, 'oauth_login') !== false) {
        $loginMethod = 'oauth';
      } elseif (strpos($filePath, 'google_login') !== false) {
        $loginMethod = 'google';
      } elseif (strpos($filePath, 'facebook_login') !== false || strpos($filePath, 'fb') !== false) {
        $loginMethod = 'facebook';
      } elseif (strpos($filePath, 'github_login') !== false) {
        $loginMethod = 'github';
      } elseif (strpos($filePath, 'discord_login') !== false) {
        $loginMethod = 'discord';
      } elseif (strpos($filePath, 'twitch_login') !== false) {
        $loginMethod = 'twitch';
      } elseif (strpos($filePath, 'okta_login') !== false) {
        $loginMethod = 'okta';
      } elseif (strpos($filePath, 'microsoft_login') !== false || strpos($filePath, 'azure_login') !== false) {
        $loginMethod = 'microsoft';
      } elseif (strpos($filePath, 'saml') !== false) {
        $loginMethod = 'saml';
      } else {
        $loginMethod = 'password';
      }
      setLoginMethod($loginMethod);
    }

    // =========================================================================
    // #5 & #6: Redirect handling - use Redirect::sanitized() for safe redirects
    // =========================================================================
    $redirect = $_SESSION['redirect'] ?? Input::get('redirect');
    $dest = $_SESSION['dest'] ?? $settings->redirect_uri_after_login;

    $hooks = getMyHooks(['page' => 'loginSuccess']);
    includeHook($hooks, 'body');

    if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/oauth_success_redirect.php')) {
      require_once $abs_us_root . $us_url_root . 'usersc/includes/oauth_success_redirect.php';
    }
    if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php')) {
      require_once $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
    }

    // Use Redirect::sanitized() which enforces same-origin, blocks schemes, normalizes paths
    if (!empty($redirect)) {
      Redirect::sanitized($redirect);
    } elseif (!empty($dest)) {
      Redirect::sanitized($dest);
    }

    Redirect::sanitized($settings->redirect_uri_after_login);
  }
}

/**
 * Get cached list of column names from users table
 * Caches result for the duration of the request
 */
if (!function_exists('socialLoginGetUserColumns')) {
  function socialLoginGetUserColumns($db)
  {
    static $columns = null;
    if ($columns === null) {
      $columns = [];
      $result = $db->query('DESCRIBE users');
      if (!$result->error()) {
        foreach ($result->results() as $row) {
          $columns[] = $row->Field;
        }
      }
    }
    return $columns;
  }
}

if (!function_exists('generateUsername')) {
  function generateUsername($username, $first, $last, $email)
  {
    global $db, $settings;
    if ($username !== null) {
      $count = $db->query("SELECT * FROM users WHERE username = ?", [$username])->count();
      if ($count == 0) {
        return $username;
      }
    }

    if ($settings->auto_assign_un == 1) {
      $username = username_helper($first, $last, $email);
      if (!$username) {
        $username = null;
      }
    } else {
      $username = $email;
    }
    return $username;
  }
}

/**
 * Set login method in session - called by various login handlers
 */
function setLoginMethod($method)
{
  $_SESSION[INSTANCE . '_login_method'] = $method;

  // Log the login method for debugging
  if (isset($GLOBALS['user']) && $GLOBALS['user']->isLoggedIn()) {
    logger($GLOBALS['user']->data()->id, "Login_Method", "Login method set to: " . $method);
  }
}

if (!function_exists('fetchUserDetails')) {
  function fetchUserDetails($column = null, $term = null, $id = null)
  {
    global $db;

    $column = trim((string)$column);
    $column = ($column === '') ? 'id' : $column;

    $termTrimmed = trim((string)$term);
    $term = ($term === null || $termTrimmed === '') ? $id : $term;

    static $whitelist = null;
    if ($whitelist === null) {
      $whitelist = [];
      $columns = $db->query("SHOW COLUMNS FROM users")->results();
      foreach ($columns as $col) {
        $whitelist[] = $col->Field;
      }
    }

    if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $column)) {
      return false;
    }

    if (!in_array($column, $whitelist, true)) {
      return false;
    }

    if ($column === 'id') {
      $term = (int)$term;
    }

    $query = $db->query("SELECT * FROM users WHERE `$column` = ? LIMIT 1", [$term]);
    return ($query->count() === 1) ? $query->first() : false;
  }
}

if (!function_exists('updateUser')) {

  function updateUser($column, $id, $value)
  {
    global $db;

    $column = trim((string)$column);
    $id = (int)$id;

    if ($column === '' || $id <= 0) {
      return false;
    }


    static $cols = null;
    if ($cols === null) {
      $cols = [];
      $rows = $db->query("SHOW COLUMNS FROM users")->results();
      foreach ($rows as $r) {
        $cols[$r->Field] = $r;
      }
    }

    if (!isset($cols[$column])) {
      return false;
    }

    $sanitizedColumn = $column;

    if ($sanitizedColumn === 'id') {
      return false;
    }

    return $db->query(
      "UPDATE users SET `$sanitizedColumn` = ? WHERE id = ? LIMIT 1",
      [$value, $id]
    );
  }
}

if (!function_exists('fetchAllUsers')) {
  function fetchAllUsers($orderBy = null, $desc = false, $onlyPermissionOne = true)
  {
    global $db;

    $q = 'SELECT * FROM users';
    if ($onlyPermissionOne) {
      $q .= ' WHERE permissions = 1';
    }

    if ($orderBy !== null) {
      $orderBy = trim((string)$orderBy);

      // Defense-in-depth: validate identifier format before any further processing
      if ($orderBy !== '' && !preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $orderBy)) {
        logger(0, 'fetchAllUsers', "Invalid ORDER BY column format attempted: " . substr($orderBy, 0, 50));
        $orderBy = ''; // Neutralize invalid input
      }

      static $whitelist = null;
      if ($whitelist === null) {
        $whitelist = [];
        $columns = $db->query("SHOW COLUMNS FROM users")->results();
        foreach ($columns as $col) {
          $whitelist[] = $col->Field;
        }
      }

      if ($orderBy !== '' && in_array($orderBy, $whitelist, true)) {
        $q .= " ORDER BY `{$orderBy}` " . ($desc ? 'DESC' : 'ASC');
      }
    }

    return $db->query($q)->results();
  }
}
