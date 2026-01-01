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

//Retrieve information for all users
if (!function_exists('fetchAllUsers')) {
  function fetchAllUsers($orderBy = null, $desc = false, $disabled = true)
  {
    global $db;
    $q = 'SELECT * FROM users';
    if (!$disabled) {
      $q .= ' WHERE permissions=1';
    }
    if ($orderBy !== null) {
      $sanitize = $db->query("SELECT * FROM users LIMIT 1")->first();
      $found = false;
      foreach ($sanitize as $key => $value) {
        if ($key == $orderBy) {
          $found = true;
        }
      }
      //don't order if the column doesn't exist
      if ($found) {
        if ($desc === true) {
          $q .= " ORDER BY $orderBy DESC";
        } else {
          $q .= " ORDER BY $orderBy";
        }
      }
    }
    $query = $db->query($q);
    $results = $query->results();

    return $results;
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

//Retrieve complete user information by username, token or ID
//This function is primarily for legacy purposes
if (!function_exists('fetchUserDetails')) {
  function fetchUserDetails($column = null, $term = null, $id = null)
  {
    global $db;
    if ($column == null || $column == "") {
      $column = "id";
    }

    if ($term == null || $term == "") {
      $term = $id;
    }
    $sanitize = $db->query("SELECT * FROM users LIMIT 1")->first();
    $found = false;
    foreach ($sanitize as $key => $value) {
      if ($key == $column) {
        $found = true;
      }
    }
    if ($found == false) {
      return false;
    }
    $query = $db->query("SELECT * FROM users WHERE $column = ? LIMIT 1", [$term]);
    if ($query->count() == 1) {
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
      if ($return) {
        return $string;
      } else {
        echo $string;
      }
    }

    $id = (int) $id;

    if ($echoType !== null) {
      $echoType = (int) $echoType;
    } else {
      $echoType = $settings->echouser;
    }
    $string = "Unknown";
    if ($echoType == 0) {
      $query = $db->query('SELECT fname,lname FROM users WHERE id = ? LIMIT 1', [$id]);

      $count = $query->count();
      if ($count > 0) {
        $results = $query->first();
        $string = $results->fname . ' ' . $results->lname;
      }
    } elseif ($echoType == 1) {
      $query = $db->query('SELECT username FROM users WHERE id = ? LIMIT 1', [$id]);
      $count = $query->count();
      if ($count > 0) {
        $results = $query->first();
        $string = ucfirst($results->username);
      }
    } elseif ($echoType == 2) {
      $query = $db->query('SELECT username,fname,lname FROM users WHERE id = ? LIMIT 1', [$id]);
      $count = $query->count();
      if ($count > 0) {
        $results = $query->first();
        $string = ucfirst($results->username) . ' (' . $results->fname . ' ' . $results->lname . ')';
      }
    } elseif ($echoType == 3) {
      $query = $db->query('SELECT username,fname FROM users WHERE id = ? LIMIT 1', [$id]);
      $count = $query->count();
      if ($count > 0) {
        $results = $query->first();
        $string =  ucfirst($results->username) . ' (' . $results->fname . ')';
      }
    } elseif ($echoType == 4) {
      $query = $db->query('SELECT fname,lname FROM users WHERE id = ? LIMIT 1', [$id]);
      $count = $query->count();
      if ($count > 0) {
        $results = $query->first();
        $string = ucfirst($results->fname) . ' ' . substr(ucfirst($results->lname), 0, 1);
      }
    }

    if ($return == true) {
      return $string;
    } else {
      echo $string;
    }
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

      return $results->username;
    } else {
      return 'Unknown';
    }
  }
}

if (!function_exists('updateUser')) {
  //Update User
  function updateUser($column, $id, $value)
  {
    global $db, $user;
    if (isset($user->data()->$column)) { //check for a valid column
      $result = $db->query("UPDATE users SET $column = ? WHERE id = ?", [$value, $id]);
      return $result;
    } else {
      return false;
    }
  }
}

if (!function_exists('fetchUserName')) {
  //Fetches CONCAT of Fname Lname
  function fetchUserName($username = null, $token = null, $id = null)
  {
    global $db;
    if ($username != null) {
      $column = 'username';
      $data = $username;
    } elseif ($id != null) {
      $column = 'id';
      $data = $id;
    }

    $query = $db->query("SELECT CONCAT(fname,' ',lname) AS name FROM users WHERE $column = ? LIMIT 1", [$data]);
    $count = $query->count();
    if ($count > 0) {
      $results = $query->first();

      return $results->name;
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

    $idQuery = "";
    foreach ($idArray as $key => $value) {
      $idQuery .= " OR $key = ?";
    }
    // Handle no registration allowed, verify email already exists
    if ($settings->registration == 0) {
      $findExistingUS = $db->query("SELECT * FROM users WHERE email = ?" . $idQuery, array_merge([$email], array_values($idArray)));
      if ($findExistingUS->count() === 0) {
        session_destroy();
        Redirect::to($us_url_root . 'users/join.php');
        die();
      }
    }

    //Handle already existing UserSpice account with matching email
    $findExistingUS = $db->query("SELECT * FROM users WHERE email = ?" . $idQuery, array_merge([$email], array_values($idArray)));
    if ($findExistingUS->count() > 0) {
      $user = new User($findExistingUS->first()->id);
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

      $user->update($fields);

      // Handle new user
    } else {
      $user = new User();

      if (isset($_SESSION['us_lang'])) {
        $newLang = $_SESSION['us_lang'];
      } else {
        $newLang = $settings->default_language;
      }
      $date = date("Y-m-d H:i:s");
      $defaultFields = [
        'username' => generateUsername($username, $fields['fname'] ?? "", $fields['lname'] ?? "", $fields['email'] ?? ""),
        'email' => $email,
        'password' => null,
        'permissions' => 1,
        'join_date' => date('Y-m-d H:i:s'),
        'oauth_tos_accepted' => false,
        'language' => $newLang,
        'logins' => 1,
        'join_date' => $date,
        'last_login' => $date,
        'email_verified' => 1,
      ];

      $fields = array_merge($defaultFields, $fields);

      $activeCheck = $db->query('SELECT active FROM users');
      if (!$activeCheck->error()) {
        $fields['active'] = 1;
      }

      $theNewId = $user->create($fields);
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

    $_POST['redirect'] = $_SESSION['redirect'];
    $redirect = Input::get('redirect');
    if (!isset($_SESSION['dest'])) {
      $_SESSION['dest'] = $settings->redirect_uri_after_login;
    }
    $_POST['dest'] = $_SESSION['dest'];
    $dest = sanitizedDest('dest');

    $hooks = getMyHooks(['page' => 'loginSuccess']);
    includeHook($hooks, 'body');

    if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/oauth_success_redirect.php')) {
      require_once $abs_us_root . $us_url_root . 'usersc/includes/oauth_success_redirect.php';
    }
    if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php')) {
      require_once $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
    }

    if (!empty($dest)) {
      if (!empty($redirect) || $redirect !== '') {
        Redirect::to($redirect);
      } else {
        Redirect::to($dest);
      }
    }

    Redirect::to($settings->redirect_uri_after_login);
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
