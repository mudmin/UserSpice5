<?php
/*
UserSpice
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
// UserSpice Specific Functions

$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? Input::sanitize(Server::get('HTTP_USER_AGENT', 'MISSING')) : 'MISSING';
if (!function_exists('ipCheck')) {
  function ipCheck(): string
  {
    // Treat true CLI & PHPDBG as "no remote addr"
    if (PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg') {
      return '127.0.0.1';
    }
    return Server::get('REMOTE_ADDR');
  }
}

if (!function_exists('ipCheckBan')) {
  function ipCheckBan()
  {
    global $db;

    $ip = ipCheck();
    $ban = $db->query('SELECT id FROM us_ip_blacklist WHERE ip = ?', [$ip])->count();
    if ($ban > 0) {
      $unban = $db->query('SELECT id FROM us_ip_whitelist WHERE ip = ?', [$ip])->count();
      if ($unban == 0) {
        //Removed log. If anyone wants to re-add it, you can do it as a hook.
        if ($eventhooks = getMyHooks(['page' => 'hitBanned'])) {
          includeHook($eventhooks, 'body');
        }

        return true;
      } else {
        //blacklisted but also whitelisted and whitelist prevails
        return false;
      }
    } else {
      //not on blacklist
      return false;
    }
  }
}

if (!function_exists('passwordsAllowed')) {
  /**
   * Check if password logins are allowed based on setting and client IP
   * @param int $no_passwords_setting The no_passwords setting value (0=enabled, 1=disabled, 2=localhost only)
   * @return bool True if passwords are allowed, false otherwise
   */
  function passwordsAllowed($no_passwords_setting)
  {
    if ($no_passwords_setting == 0) {
      return true; // Passwords enabled
    }
    if ($no_passwords_setting == 1) {
      return false; // Passwords disabled
    }
    if ($no_passwords_setting == 2) {
      // Passwords disabled except on localhost
      $ip = ipCheck();
      return ($ip === '127.0.0.1' || $ip === '::1');
    }
    return true; // Default to enabled
  }
}

function randomString(int $len): string
{
    if ($len <= 0) {
        return '';
    }

    static $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    static $max   = 61;

    $out = '';

    for ($i = 0; $i < $len; $i++) {
        $out .= $chars[random_int(0, $max)];
    }

    return $out;
}

/**
 * Get the server secret key for HMAC operations.
 * Generates and stores a key file if one doesn't exist.
 */
if (!function_exists('getVericodeSecret')) {
  function getVericodeSecret(): string
  {
    global $abs_us_root, $us_url_root;
    $keyFile = $abs_us_root . $us_url_root . 'usersc/vericode_secret.php';

    if (file_exists($keyFile)) {
      include $keyFile;
      if (isset($vericode_secret) && !empty($vericode_secret)) {
        return $vericode_secret;
      }
    }

    // Generate a new secret
    $newSecret = bin2hex(random_bytes(32));
    $content = "<?php\n\$vericode_secret = '" . $newSecret . "';\n";

    if (file_put_contents($keyFile, $content) !== false) {
      return $newSecret;
    }

    // Fallback: derive from config if file write fails
    return hash('sha256', Config::get('mysql/password') . Config::get('session/session_name'));
  }
}

/**
 * Hash a vericode using HMAC-SHA256
 */
if (!function_exists('hashVericode')) {
  function hashVericode(string $vericode): string
  {
    return hash_hmac('sha256', $vericode, getVericodeSecret());
  }
}

/**
 * Find a user by vericode (hashed lookup only).
 * Returns the user data or null if not found.
 */
if (!function_exists('findUserByVericode')) {
  function findUserByVericode(string $vericode, ?int $user_id = null): ?object
  {
    global $db;

    $hashedVericode = hashVericode($vericode);

    // Build query with optional user_id constraint
    if ($user_id !== null) {
      $result = $db->query(
        "SELECT * FROM users WHERE vericode = ? AND id = ?",
        [$hashedVericode, $user_id]
      );
    } else {
      $result = $db->query(
        "SELECT * FROM users WHERE vericode = ?",
        [$hashedVericode]
      );
    }

    return $result->count() > 0 ? $result->first() : null;
  }
}

/**
 * Find an email login record by vericode (hashed lookup only).
 * Returns the login data or null if not found.
 */
if (!function_exists('findEmailLoginByVericode')) {
  function findEmailLoginByVericode(string $vericode, ?int $user_id = null): ?object
  {
    global $db;

    $hashedVericode = hashVericode($vericode);

    $baseQuery = "SELECT l.*, u.email_verified
      FROM us_email_logins l
      LEFT OUTER JOIN users u ON l.user_id = u.id
      WHERE l.vericode = ?";

    if ($user_id !== null) {
      $baseQuery .= " AND l.user_id = ?";
      $result = $db->query($baseQuery, [$hashedVericode, $user_id]);
    } else {
      $result = $db->query($baseQuery, [$hashedVericode]);
    }

    return $result->count() > 0 ? $result->first() : null;
  }
}

if (!function_exists('get_gravatar')) {
  function get_gravatar($email, $s = 120, $d = 'mm', $r = 'pg', $img = false, $atts = [])
  {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img) {
      $url = '<img src="' . $url . '"';
      foreach ($atts as $key => $val) {
        $url .= ' ' . $key . '="' . $val . '"';
      }
      $url .= ' />';
    }

    return $url;
  }
}


//Checks if a username exists in the DB
if (!function_exists('usernameExists')) {
  function usernameExists($username)
  {
    global $db;

    $query = $db->query('SELECT * FROM users WHERE username = ?', [$username]);
    $results = $query->results();

    return $results;
  }
}



// retrieve ?dest=page and check that it exists in the legitimate pages in the
// database or is in the Config::get('whitelisted_destinations')
if (!function_exists('sanitizedDest')) {
  function sanitizedDest($varname = 'dest')
  {
    if ($dest = Input::get($varname)) {
      // if it exists in the database then it is a legitimate destination
      global $db;

      $query = $db->query('SELECT id, page, private FROM pages WHERE `page` = ?', [$dest]);
      $count = $query->count();
      if ($count > 0) {
        return $dest;
      }
      // if the administrator has intentionally whitelisted a destination it is legitimate
      if ($whitelist = Config::get('whitelisted_destinations')) {
        if (in_array($dest, (array) $whitelist)) {
          return $dest;
        }
      }
    }

    return false;
  }
}

//Displays error and success messages
//As of 5.3.0, this function automatically converts old resultBlock
//error messages to the new Session based system
if (!function_exists('resultBlock')) {
  function resultBlock($errors, $successes)
  {
    sessionValMessages($errors, $successes, null);
  }
}

//Inputs language strings from selected language.
if (!function_exists('lang')) {
  function lang($key, $markers = null)
  {
    global $lang, $us_url_root, $abs_us_root;
    if ($markers == null) {
      if (isset($lang[$key])) {
        $str = $lang[$key];
      } else {
        $str = '';
      }
    } else {
      //Replace any dyamic markers
      if (isset($lang[$key])) {
        $str = $lang[$key];
        $iteration = 1;
        foreach ($markers as $marker) {
          $str = str_replace('%m' . $iteration . '%', $marker, $str);
          ++$iteration;
        }
      } else {
        $str = '';
      }
    }

    //Ensure we have something to return
    // dump($key);
    if ($str == '') {
      if (isset($lang['MISSING_TEXT'])) {
        $missing = $lang['MISSING_TEXT'];
      } else {
        $missing = 'Missing Text';
      }
      //This both allows the dev to figure out which key is missing and gives the end user a clue of what you are trying to say.
      $missing = $missing . " - " . $key;
      //if nothing is found, let's check to see if the language is English.
      if (isset($lang['THIS_CODE']) && $lang['THIS_CODE'] != 'en-US') {
        $save = $lang['THIS_CODE'];
        if ($save == '') {
          $save = 'en-US';
        }
        //if it is NOT English, we are going to try to grab the key from the English translation
        include $abs_us_root . $us_url_root . 'users/lang/en-US.php';
        if ($markers == null) {
          if (isset($lang[$key])) {
            $str = $lang[$key];
          } else {
            $str = '';
          }
        } else {
          //Replace any dyamic markers
          if (isset($lang[$key])) {
            $str = $lang[$key];
            $iteration = 1;
            foreach ($markers as $marker) {
              $str = str_replace('%m' . $iteration . '%', $marker, $str);
              ++$iteration;
            }
          } else {
            $str = '';
          }
        }
        $lang = [];
        include $abs_us_root . $us_url_root . "users/lang/$save.php";
        if ($str == '') {
          //This means that we went to the English file and STILL did not find the language key, so...
          $str = "{ $missing }";

          return $str;
        } else {
          //falling back to English
          return $str;
        }
      } else {
        //the language is already English but the code is not found so...
        $str = "{ $missing }";

        return $str;
      }
    } else {
      return $str;
    }
  }
}

if (!function_exists('isValidEmail')) {
  //Checks if an email is valid
  function isValidEmail($email)
  {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return true;
    } else {
      return false;
    }
  }
}

if (!function_exists('emailExists')) {
  //Check if an email exists in the DB (either in email or username column)
  function emailExists($email)
  {
    global $db;

    $query = $db->query('SELECT id FROM users WHERE (email = ? OR username = ?)', [$email,$email]);
    $num_returns = $query->count();
    if ($num_returns > 0) {
      return true;
    } else {
      return false;
    }
  }
}

if (!function_exists('updateEmail')) {
  //Update a user's email
  function updateEmail($id, $email)
  {
    global $db;
    //Check if this email is the username or email of another user
    $query = $db->query('SELECT id FROM users WHERE (email = ? OR username = ?) AND id != ?', [$email, $email, $id]);
    $num_returns = $query->count();
    if ($num_returns > 0) {
      return false;
    }
    //check if it's an email address
    if (!isValidEmail($email)) {
      return false;
    }
    $fields = ['email' => $email];
    $db->update('users', $id, $fields);

    return true;
  }
}



if (!function_exists('bin')) {
  function bin($number)

  {
    global $lang;
    $number = (int) $number;
    if ($number == 0) {
      echo "<strong><span style='color:red'>" . lang("GEN_NO") . "</span></strong>";
    }
    if ($number == 1) {
      echo "<strong><span style='color:green'>" . lang("GEN_YES") . "</span></strong>";
    }
    if ($number != 0 && $number != 1) {
      echo "<strong><span style='color:blue'>-</span></strong>";
    }
  }
}




if (!function_exists('clean')) {
  //Cleaning function
  function clean($string)
  {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9]/', '', $string); // Removes special chars.

    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
  }
}


if (!function_exists('encodeURIComponent')) {
  function encodeURIComponent($str)
  {
    $revert = ['%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')'];

    return strtr(rawurlencode($str), $revert);
  }
}

if (!function_exists('logger')) {
  function logger($user_id = "", $logtype = "", $lognote = "", $metadata = null)
  {
    global $db, $user;

    if (!isset($user_id) || $user_id == "") {
      if (isset($user) && $user->isLoggedIn()) {
        $user_id = $user->data()->id;
      } else {
        $user_id = 0;
      }
    }
    if (is_array($lognote) || is_object($lognote)) {
      $lognote = json_encode($lognote);
    }
    if (is_array($metadata) || is_object($metadata)) {
      $metadata = json_encode($metadata);
    }

    $fields = [
      'user_id' => $user_id,
      'logdate' => date('Y-m-d H:i:s'),
      'logtype' => $logtype,
      'lognote' => $lognote,
      'ip' => ipCheck(),
      'metadata' => $metadata,
    ];

    if (cloakFrom() > 0) {
      $fields['cloak_from'] = cloakFrom();
    }

    $db->insert('logs', $fields);
    $lastId = $db->lastId();

    return $lastId;
  }
}

if (!function_exists('echodatetime')) {
  function echodatetime($ts)
  {
    $ts_converted = strtotime($ts);
    $difference = ceil((time() - $ts_converted) / (60 * 60 * 24));
    // if($difference==0) { $last_update = "Today, "; $last_update .= date("g:i A",$convert); }
    if ($difference >= 0 && $difference < 7) {
      $today = date('j');
      $ts_date = date('j', $ts_converted);
      if ($today == $ts_date) {
        $date = 'Today, ';
        $date .= date('g:i A', $ts_converted);
      } else {
        $date = date('l g:i A', $ts_converted);
      }
    } elseif ($difference >= 7) {
      $date = date('M j, Y g:i A', $ts_converted);
    }

    return $date;
  }
}

if (!function_exists('time2str')) {
  function time2str($ts)
  {
    if ($ts === null || $ts == "") {
      return null;
    }

    $ts = strtotime($ts);

    $diff = time() - $ts;
    if ($diff == 0) {
      return 'now';
    } elseif ($diff > 0) {
      $day_diff = floor($diff / 86400);
      if ($day_diff == 0) {
        if ($diff < 60) {
          return 'just now';
        }
        if ($diff < 120) {
          return '1 minute ago';
        }
        if ($diff < 3600) {
          return floor($diff / 60) . ' minutes ago';
        }
        if ($diff < 7200) {
          return '1 hour ago';
        }
        if ($diff < 86400) {
          return floor($diff / 3600) . ' hours ago';
        }
      }
      if ($day_diff == 1) {
        return 'Yesterday';
      }
      if ($day_diff < 7) {
        return $day_diff . ' days ago';
      }
      if ($day_diff < 31) {
        return ceil($day_diff / 7) . ' weeks ago';
      }
      if ($day_diff < 60) {
        return 'last month';
      }

      return date('F Y', $ts);
    } else {
      $diff = abs($diff);
      $day_diff = floor($diff / 86400);
      if ($day_diff == 0) {
        if ($diff < 120) {
          return 'in a minute';
        }
        if ($diff < 3600) {
          return 'in ' . floor($diff / 60) . ' minutes';
        }
        if ($diff < 7200) {
          return 'in an hour';
        }
        if ($diff < 86400) {
          return 'in ' . floor($diff / 3600) . ' hours';
        }
      }
      if ($day_diff == 1) {
        if ($day_diff < 4) {
          return date('l', $ts);
        } else {
          return 'Tomorrow';
        }
      }
      if ($day_diff < 4) {
        return date('l', $ts);
      }
      if ($day_diff < 7 + (7 - date('w'))) {
        return 'next week';
      }
      if (ceil($day_diff / 7) < 4) {
        return 'in ' . ceil($day_diff / 7) . ' weeks';
      }
      if (date('n', $ts) == date('n') + 1) {
        return 'next month';
      }

      return date('F Y', $ts);
    }
  }
}

if (!function_exists('ipReason')) {
  function ipReason($reason)
  {
    if ($reason == 0) {
      echo 'Manually Entered';
    } elseif ($reason == 1) {
      echo 'Invalid Attempts';
    } else {
      echo 'Unknown';
    }
  }
}

if (!function_exists('checkBan')) {
  function checkBan($ip)
  {
    global $db;

    $c = $db->query('SELECT id FROM us_ip_blacklist WHERE ip = ?', [$ip])->count();
    if ($c > 0) {
      return true;
    } else {
      return false;
    }
  }
}

if (!function_exists('random_password')) {
  function random_password($length = 16)
  {
    if ($length <= 0) {
      return '';
    }
    // CSPRNG sampling over the password alphabet. The legacy str_shuffle
    // implementation used Mersenne Twister, capped output at 80 chars, and
    // produced unique-char-only strings — none acceptable for passwords.
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?';
    $max = strlen($chars) - 1;
    $password = '';
    for ($i = 0; $i < $length; $i++) {
      $password .= $chars[random_int(0, $max)];
    }
    return $password;
  }
}

if (!function_exists('returnError')) {
  function returnError($errorMsg)
  {
    $responseAr = [];
    $responseAr['success'] = true;
    $responseAr['error'] = true;
    $responseAr['errorMsg'] = $errorMsg;
    header('Content-Type: application/json;');
    exit(json_encode($responseAr));
  }
}

if (!function_exists('requestCheck')) {
  function requestCheck($expectedAr)
  {
    $requestAr = array_replace_recursive($_GET, $_POST);
    $diffAr = array_diff_key(array_flip($expectedAr), $requestAr);
    if (count($diffAr) > 0) {
      returnError('Missing variables: ' . implode(',', array_flip($diffAr)) . '.');
    } else {
      return $requestAr;
    }
  }
}

if (!function_exists('adminNotifications')) {
  function adminNotifications($type, $threads, $user_id)
  {
    global $db;

    $i = 0;
    foreach ($threads as $id) {
      $id = (int) $id;
      if ($type == 'read') {
        $db->query("UPDATE notifications SET is_read = 1 WHERE id = ?", [$id]);
        // logger($user_id, 'Notifications - Admin', "Marked Notification ID #$id read.");
      }
      if ($type == 'unread') {
        $db->query("UPDATE notifications SET is_read = 0,is_archived=0 WHERE id = ?", [$id]);
        // logger($user_id, 'Notifications - Admin', "Marked Notification ID #$id unread.");
      }
      if ($type == 'delete') {
        $db->query("UPDATE notifications SET is_archived = 1 WHERE id = ?", [$id]);
        // logger($user_id, 'Notifications - Admin', "Deleted Notification ID #$id.");
      }
      ++$i;
    }

    return $i;
  }
}

if (!function_exists('lognote')) {
  function lognote($logid)
  {
    global $db;

    $logQ = $db->query('SELECT * FROM logs WHERE id = ?', [$logid]);
    if ($logQ->count() > 0) {
      $log = $logQ->first();
      // @phpstan-ignore equal.alwaysFalse (intentional always-false placeholder; this is the documented extension point where integrators add their own elseif log hooks - see the comment block below.)
      if (1 == 2) {
        return 'This is a placeholder';
      }
      /* elseif here for your custom hooks! */ else {
        return $log->lognote;
      }
      /*With this function you can use whatever hooks you want within your admin logs. Say for example you track each the Page ID the user visits, and you
      want to return the page name, you would store the Page ID in the lognote and 'Page' as the LogType, and do this:
      elseif($row->logtype=='Page') {
      $pageQ = $db->query("SELECT title FROM pages WHERE id = ?",[$row->lognote]);
      if($pageQ->count()>0) return $pageQ->first()->title;
      else return 'Error finding page information';
    }
    ---
    You can have as many elseifs that you want! You can also replace the Placeholder with a normal if.
    TO USE THIS FUNCTION:
    Copy it all except the function_exists (outside wrapper) to your usersc/includes/custom_functions.php. It will override any
    chages we make to this helper and avoids you from editing core files. */
    } else {
      return false;
    }
  }
}

if (!function_exists('isLocalhost')) {
  function isLocalhost()
  {
    $ip = ipCheck();
    if ($ip == '127.0.0.1' || $ip == '::1' || $ip == 'localhost') {
      return true;
    } else {
      return false;
    }
  }
}

if (!function_exists('currentPageStrict')) {
  function currentPageStrict(): string
  {
    global $us_url_root;

    $uri  = Server::get('REQUEST_URI', '/');
    $qpos = strpos($uri, '?');
    if ($qpos !== false) $uri = substr($uri, 0, $qpos);

    $base = rtrim((string)$us_url_root, '/');
    if ($base !== '' && $base !== '/' && str_starts_with($uri, $base)) {
      $page = ltrim(substr($uri, strlen($base)), '/');
    } else {
      $page = ltrim($uri, '/');
    }

    $page = preg_replace('#/{2,}#', '/', $page);
    $out  = [];
    foreach (explode('/', $page) as $seg) {
      if ($seg === '' || $seg === '.') continue;
      if ($seg === '..') {
        array_pop($out);
        continue;
      }
      $out[] = $seg;
    }
    return implode('/', $out);
  }
}


if (!function_exists('UserSessionCount')) {
  function UserSessionCount()
  {
    global $db, $user;

    $q = $db->query('SELECT * FROM us_user_sessions WHERE fkUserID = ? AND UserSessionEnded=0', [$user->data()->id]);

    return $q->count();
  }
}

if (!function_exists('fetchUserSessions')) {
  function fetchUserSessions($all = false)
  {
    global $db, $user;

    if (!$all) {
      $q = $db->query('SELECT * FROM us_user_sessions WHERE fkUserID = ? AND UserSessionEnded=0 ORDER BY UserSessionStarted', [$user->data()->id]);
    } else {
      $q = $db->query('SELECT * FROM us_user_sessions WHERE fkUserID = ? ORDER BY UserSessionStarted', [$user->data()->id]);
    }
    if ($q->count() > 0) {
      return $q->results();
    } else {
      return false;
    }
  }
}

if (!function_exists('fetchAdminSessions')) {
  function fetchAdminSessions($all = false)
  {
    global $db, $user;

    if (!$all) {
      $q = $db->query('SELECT * FROM us_user_sessions WHERE UserSessionEnded=0 ORDER BY UserSessionStarted');
    } else {
      $q = $db->query('SELECT * FROM us_user_sessions ORDER BY UserSessionStarted');
    }
    if ($q->count() > 0) {
      return $q->results();
    } else {
      return false;
    }
  }
}

if (!function_exists('killSessions')) {
  function killSessions($sessions, $admin = false)
  {
    global $db, $user;

    $i = 0;
    foreach ($sessions as $session) {
      if (is_numeric($session)) {
        if (!$admin) {
          $db->query('UPDATE us_user_sessions SET UserSessionEnded=1,UserSessionEnded_Time=NOW() WHERE kUserSessionID = ? AND fkUserId = ?', [$session, $user->data()->id]);
        } else {
          $db->query('UPDATE us_user_sessions SET UserSessionEnded=1,UserSessionEnded_Time=NOW() WHERE kUserSessionID = ?', [$session]);
        }
        if (!$db->error()) {
          ++$i;
          logger($user->data()->id, 'User Tracker', "Killed Session ID#$session");
        } else {
          $error = $db->errorString();
          logger($user->data()->id, 'User Tracker', "Error killing Session ID#$session: $error");
        }
      }
    }
    if ($i > 0) {
      return $i;
    } else {
      return false;
    }
  }
}

if (!function_exists('passwordResetKillSessions')) {
  function passwordResetKillSessions($uid = null)
  {
    global $db, $user;

    if (is_null($uid)) {
      if (isset($_SESSION['kUserSessionID'])) {
        $q = $db->query('UPDATE us_user_sessions SET UserSessionEnded=1,UserSessionEnded_Time=NOW() WHERE fkUserID = ? AND UserSessionEnded=0 AND kUserSessionID <> ?', [$user->data()->id, $_SESSION['kUserSessionID']]);
      }
    } else {
      $q = $db->query('UPDATE us_user_sessions SET UserSessionEnded=1,UserSessionEnded_Time=NOW() WHERE fkUserID = ? AND UserSessionEnded=0', [$uid]);
    }
    if (!$db->error()) {
      $count = $db->count();
      if (is_null($uid)) {
        if ($count == 1) {
          logger($user->data()->id, 'User Tracker', 'Killed 1 Session via Password Reset.');
        }
        if ($count > 1) {
          logger($user->data()->id, 'User Tracker', "Killed $count Sessions via Password Reset.");
        }
      } else {
        if ($count == 1) {
          logger($user->data()->id, 'User Tracker', "Killed 1 Session via Password Reset for UID $uid.");
        }
        if ($count > 1) {
          logger($user->data()->id, 'User Tracker', "Killed $count Sessions via Password Reset for UID $uid.");
        }
      }

      return $count;
    } else {
      $error = $db->errorString();
      if (is_null($uid)) {
        logger($user->data()->id, 'User Tracker', 'Password Reset Session Kill failed, Error: ' . $error);
      } else {
        logger($user->data()->id, 'User Tracker', "Password Reset Session Kill failed for UID $uid, Error: " . $error);
      }

      return $error;
    }
  }
}

if (!function_exists('username_helper')) {
  function username_helper($fname, $lname, $email)
  {
    global $db, $settings;

    $preusername = $fname[0];
    $preusername .= $lname;
    $preusername = strtolower(clean($preusername));
    $preQ = $db->query('SELECT username FROM users WHERE username = ?', [$preusername]);
    if (!$db->error()) {
      $preQCount = $preQ->count();
    } else {
      return false;
    }
    if ($preQCount == 0) {
      return $preusername;
    }
    $preusername = $fname;
    $preusername .= $lname[0];
    $preusername = strtolower(clean($preusername));
    $preQ = $db->query('SELECT username FROM users WHERE username = ?', [$preusername]);
    if (!$db->error()) {
      $preQCount = $preQ->count();
    } else {
      return false;
    }
    if ($preQCount == 0) {
      return $preusername;
    }

    return $email;
  }
}

if (!function_exists('oxfordList')) {
  function oxfordList($data, $opts = ['final' => 'and'])
  {
    if (!is_array($data) || empty($data)) {
      return '';
    }
    $count = count($data);
    if ($count === 1) {
      return $data[0];
    }

    $final = $opts['final'] ?? 'and';

    if ($count === 2) {
      return $data[0] . ' ' . $final . ' ' . $data[1];
    }

    $last = array_pop($data);
    return implode(', ', $data) . ', ' . $final . ' ' . $last;
  }
}

if (!function_exists('currentFile')) {
  function currentFile(): string
  {
    global $us_url_root;

    $uri  = Server::get('REQUEST_URI', '/');
    $qpos = strpos($uri, '?');
    if ($qpos !== false) $uri = substr($uri, 0, $qpos);

    $base = rtrim((string)$us_url_root, '/');
    $rel  = $uri;

    if ($base !== '' && $base !== '/' && str_starts_with($uri, $base)) {
      $rel = substr($uri, strlen($base));
    }

    $rel = ltrim($rel, '/');
    $rel = preg_replace('#/{2,}#', '/', $rel);

    $out = [];
    foreach (explode('/', $rel) as $seg) {
      if ($seg === '' || $seg === '.') continue;
      if ($seg === '..') {
        array_pop($out);
        continue;
      }
      $out[] = $seg;
    }

    return implode('/', $out); // same as old: path from us_url_root (e.g., "users/profile.php")
  }
}

if (!function_exists('currentFileName')) {
  function currentFileName(): string
  {
    $p = currentFile();
    return $p === '' ? '' : basename($p);
  }
}

if (!function_exists('importSQL')) {
  function importSQL($file)
  {
    global $db;

    $lines = file($file);
    $templine = '';
    // Loop through each line
    foreach ($lines as $line) {
      // Skip it if it's a comment
      if (substr($line, 0, 2) == '--' || $line == '') {
        continue;
      }

      // Add this line to the current segment
      $templine .= $line;
      // If it has a semicolon at the end, it's the end of the query
      if (substr(trim($line), -1, 1) == ';') {
        // Perform the query
        $db->query($templine);
        // Reset temp variable to empty
        $templine = '';
      }
    }
  }
}

if (!function_exists('pluginActive')) {
  function pluginActive($plugin, $checkOnly = false)
  {
    global $db, $us_url_root;
    $integrated = ["usertags"];
    if (in_array($plugin, $integrated)) {
      return true;
    }
    $check = $db->query('SELECT id FROM us_plugins WHERE plugin = ? and status = ?', [$plugin, 'active'])->count();
    if ($check != 1) {

      if (!$checkOnly) {
        usError("Plugin is disabled");
        Redirect::to($us_url_root . 'users/admin.php?view=plugins');
      }

      return false;
    } else {
      return true;
    }
  }
}

if (!function_exists('languageSwitcher')) {
  function languageSwitcher()
  {

    global $db, $user, $abs_us_root, $us_url_root, $currentPage, $settings, $token;
    if ($settings->allow_language != 1) {
      return false;
    }
    $your_token = ipCheck();
    if (!empty($_POST['language_selector'])) {
      $the_token = Input::get('your_token');
      if ($your_token != $the_token) {
        err('Language change failed');

        return false;
      } else {
        $count = 0;
        $set = '';
        foreach ($_POST as $k => $v) {
          ++$count;

          if ($count != 3) {
            continue;
          } else {
            $set = substr($k, 0, -2);
          }
        }
        if (strlen($set) != 5 || (substr($set, 2, 1) != '-')) {
          //something is fishy with this language key
          err('Language change failed');

          return false;
        }
        $installedLangs = array_map(function ($f) {
          return substr($f, 0, -4);
        }, array_values(array_filter(scandir($abs_us_root . $us_url_root . 'users/lang'), function ($f) {
          return substr($f, -4) === '.php';
        })));
        if (!in_array($set, $installedLangs, true)) {
          err('Language change failed');

          return false;
        }
        $_SESSION['us_lang'] = $set;
        if (isUserLoggedIn()) {
          $db->update('users', $user->data()->id, ['language' => $set]);
        }
        Redirect::to(currentPage());
      }
    }
    $_SESSION['your_token'] = $your_token;
    $languages = scandir($abs_us_root . $us_url_root . 'users/lang'); ?>

    <form class="" action="" method="post">
      <p align="center">
        <input type="hidden" name="your_token" value="<?php echo $your_token; ?>">

        <input type="hidden" name="language_selector" value="1">
        <?php
        foreach ($languages as $k => $v) {
          $languages[$k] = substr($v, 0, -4);
          if (file_exists($abs_us_root . $us_url_root . 'users/lang/flags/' . $languages[$k] . '.png')) { ?>
            <input type="image" title="<?php echo $languages[$k]; ?>" alt="<?php echo $languages[$k]; ?>" name="<?php echo $languages[$k]; ?>" src="<?php echo $us_url_root . 'users/lang/flags/' . $languages[$k] . '.png'; ?>" border="0" alt="Submit" style="width: 40px;" />
        <?php }
        } ?>
      </p>
      <input type="hidden" name="csrf" value="<?php echo $token; ?>">
    </form>
  <?php
  }
}

if (!function_exists('getMyHooks')) {
  function getMyHooks($opts = [])
  {
    global $db, $currentPage;


    if ($opts == []) {
      $hooks = $db->query('SELECT * FROM us_plugin_hooks WHERE `page` = ? AND `disabled` = 0', [$currentPage])->results();
    } elseif (isset($opts['page']) && $opts['page'] != '') {
      $hooks = $db->query('SELECT * FROM us_plugin_hooks WHERE `page` = ? AND `disabled` = 0', [$opts['page']])->results();
    }
    $data = [];
    $data['pre'] = [];
    $data['post'] = [];
    $data['form'] = [];
    $data['body'] = [];
    $data['bottom'] = [];
    $counter = 0;
    foreach ($hooks as $h) {
      if ($h->position == 'pre') {
        $data['pre'][$counter] = $h->folder . '/' . $h->hook;
      } elseif ($h->position == 'post') {
        $data['post'][$counter] = $h->folder . '/' . $h->hook;
      } elseif ($h->position == 'form') {
        $data['form'][$counter] = $h->folder . '/' . $h->hook;
      } elseif ($h->position == 'body') {
        $data['body'][$counter] = $h->folder . '/' . $h->hook;
      } elseif ($h->position == 'bottom') {
        $data['bottom'][$counter] = $h->folder . '/' . $h->hook;
      }
      ++$counter;
    }

    return $data;
  }
}

if (!function_exists('includeHook')) {
  function includeHook($hooks, $position)
  {
    global $db, $abs_us_root, $us_url_root, $usplugins, $hookData;
    if (is_null($hookData)) {
      $hookData = [];
    }

    if (is_array($hooks) && isset($hooks[$position])) {
      foreach ($hooks[$position] as $h) {
        if (isset($h) && file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $h) && $h != '') {
          $plugin = strstr($h, '/', true);
          if (isset($usplugins[$plugin]) && $usplugins[$plugin] == 1) { //only include this file if plugin is installed and active.
            include $abs_us_root . $us_url_root . 'usersc/plugins/' . $h;
          }
          //does the link include the string "oauth", manually include it
        } elseif (strpos($h, 'oauth') !== false && file_exists($abs_us_root . $us_url_root . $h)) {
          include $abs_us_root . $us_url_root . $h;
        } else {
        }
      }
    }
  }
}

if (!function_exists('registerHooks')) {
  function registerHooks($hooks, $plugin_name)
  {
    global $db;
    foreach ($hooks as $k => $v) {
      foreach ($v as $key => $value) {
        $checkQ = $db->query('SELECT * FROM us_plugin_hooks WHERE `page` = ? AND folder = ? AND position = ? AND hook = ?', [$k, $plugin_name, $key, $value]);

        $checkC = $checkQ->count();
        if ($checkC > 0) {
          $check = $checkQ->first();
          $db->update('us_plugin_hooks', $check->id, ['disabled' => 0]);
          continue;
        }
        $fields = [
          'page' => $k,
          'folder' => $plugin_name,
          'position' => $key,
          'hook' => $value,
        ];
        $db->insert('us_plugin_hooks', $fields);
      }
    }
  }
}

if (!function_exists('deRegisterHooks')) {
  function deRegisterHooks($plugin_name)
  {
    global $db;
    $hooks = $db->query('UPDATE us_plugin_hooks SET disabled = 1 WHERE folder = ?', [$plugin_name]);
  }
}

if (!function_exists('shakerIsInstalled')) {
  function shakerIsInstalled($type, $reserved)
  {
    global $abs_us_root, $us_url_root;

    $response = ["installed" => false, "ver" => "0.0.0"];

    if ($type == 'translation') {
      $response = ["installed" => true, "ver" => "0.0.0"];
      return $response;
    } elseif ($type == 'plugin' || $type == 'widget' || $type == 'template') {
      $type = $type . 's';
      if (file_exists($abs_us_root . $us_url_root . 'usersc/' . $type . '/' . $reserved)) {
        $response = ["installed" => true, "ver" => "0.0.0"];
        if (file_exists($abs_us_root . $us_url_root . 'usersc/' . $type . '/' . $reserved . '/info.xml')) {
          $xml = simplexml_load_file($abs_us_root . $us_url_root . 'usersc/' . $type . '/' . $reserved . '/info.xml');
          if (isset($xml->version)) {
            $response["ver"] = $xml->version;
          }
        }
        return $response;
      } else {
        return $response;
      }
    } else {
      return $response;
    }
  }
}

function spiceShakerBadge($shaker, $installed)
{
  $result = array();

  // Check if $shaker is newer than $installed
  if (version_compare($shaker, $installed, '>')) {
    $result['text'] = 'Update';
  } else {
    $result['text'] = 'Reload';
  }

  // Check if the version numbers match
  if ($shaker == $installed) {
    $result['badge'] = array(
      'class' => 'badge bg-info',
      'text' => 'Current'
    );
  } else {
    $result['badge'] = array(
      'class' => 'badge bg-danger',
      'text' => 'Installed: ' . $installed
    );
  }

  return $result;
}


/* ============================================================
   Core ReAuth — step-up (re-)authentication
   Added 2026-05-17. The verification UI lives in users/reauth.php.
   "Logging in counts as a reauth" — every successful login calls
   reauthMarkConfirmed(), so a fresh login satisfies the grace window.
   ============================================================ */

// Isolated session bucket key holding all reauth state for this session.
if (!function_exists('reauthSessionKey')) {
  function reauthSessionKey()
  {
    return Config::get('session/session_name') . '_reauth';
  }
}

// Stamp the session as freshly authenticated. Called on every successful
// login AND on every successful reauth.
if (!function_exists('reauthMarkConfirmed')) {
  function reauthMarkConfirmed()
  {
    $k = reauthSessionKey();
    if (!isset($_SESSION[$k]) || !is_array($_SESSION[$k])) {
      $_SESSION[$k] = [];
    }
    $_SESSION[$k]['last_confirm'] = date('Y-m-d H:i:s');
  }
}

// Most recent successful auth timestamp. Tolerates the pre-consolidation
// keys so sessions established before this upgrade still count.
if (!function_exists('reauthLastConfirm')) {
  function reauthLastConfirm()
  {
    $k = reauthSessionKey();
    if (!empty($_SESSION[$k]['last_confirm'])) {
      return $_SESSION[$k]['last_confirm'];
    }
    $sn = Config::get('session/session_name');
    if (!empty($_SESSION[$sn . '_last_confirm'])) {
      return $_SESSION[$sn . '_last_confirm'];
    }
    if (!empty($_SESSION['last_confirm'])) {
      return $_SESSION['last_confirm'];
    }
    return null;
  }
}

// True when the session was confirmed within the timeout window (minutes).
// Falls back to settings.reauth_timeout, then a 15-minute default.
if (!function_exists('reauthConfirmed')) {
  function reauthConfirmed($timeoutMinutes = null)
  {
    global $settings;
    if ($timeoutMinutes === null) {
      $timeoutMinutes = (isset($settings->reauth_timeout) && (int) $settings->reauth_timeout > 0)
        ? (int) $settings->reauth_timeout : 15;
    }
    $lc = reauthLastConfirm();
    if ($lc === null) {
      return false;
    }
    return (strtotime($lc) + ((int) $timeoutMinutes * 60)) > time();
  }
}

// Write one row to the us_reauth_log audit trail.
if (!function_exists('recordReauth')) {
  function recordReauth($userId, $method, $purpose = '', $success = 1)
  {
    global $db;
    $ua = Server::get('HTTP_USER_AGENT');
    $db->insert('us_reauth_log', [
      'user_id'    => (int) $userId,
      'purpose'    => ($purpose !== '' && $purpose !== null) ? substr($purpose, 0, 64) : null,
      'method'     => ($method !== '' && $method !== null) ? substr($method, 0, 32) : null,
      'success'    => $success ? 1 : 0,
      'ip'         => ipCheck(),
      'user_agent' => $ua ? substr($ua, 0, 255) : null,
    ]);
  }
}

// Is outbound email actually configured? Mirrors the placeholder check used on
// login.php / forgot_password.php: if the SMTP account is still the shipped
// defaults (or blank) we can't send mail, so email-code options should be
// hidden rather than offered and then silently failing.
if (!function_exists('emailSendingConfigured')) {
  function emailSendingConfigured()
  {
    global $db;
    $e = $db->query("SELECT email_login, email_pass FROM email")->first();
    if (!$e) {
      return false;
    }
    if ($e->email_login === '' || $e->email_login === 'yourEmail@gmail.com') {
      return false;
    }
    if ($e->email_pass === '1234') {
      return false;
    }
    return true;
  }
}

// Is a single reauth method usable by this user right now? Centralizes the
// per-method capability checks so reauthMethods() and any forced-method path
// agree. $relaxTotp loosens the TOTP gate for the case where a caller has
// explicitly *forced* TOTP (see forceReauth()'s 'methods' option): normally
// TOTP is only offered for reauth when it is Required site-wide, but if an admin
// forces it we honor any user who actually has TOTP set up, as long as the
// feature is not fully disabled.
if (!function_exists('reauthMethodAvailable')) {
  function reauthMethodAvailable($userId, $method, $u = null, $relaxTotp = false)
  {
    global $db, $settings;
    if ($u === null) {
      $u = $db->query("SELECT * FROM users WHERE id = ?", [(int) $userId])->first();
    }
    if (!$u) {
      return false;
    }
    // OAuth-only accounts get a random password they never see, so password
    // reauth would be a dead end for them.
    $isOauthOnly = !empty($u->oauth_provider) && !empty($u->oauth_uid);

    switch ($method) {
      case 'password':
        $noPw = isset($settings->no_passwords) ? $settings->no_passwords : 0;
        return function_exists('passwordsAllowed') && passwordsAllowed($noPw)
          && !empty($u->password) && !$isOauthOnly;

      case 'totp':
        if (version_compare(PHP_VERSION, '8.2.0', '<')) {
          return false;
        }
        // TOTP is "set up" when the user has a VERIFIED secret. Read the
        // authoritative us_totp_secrets table directly; do not rely on any
        // denormalized per-user flag, which can be missing or stale.
        $tr = $db->query(
          "SELECT id FROM us_totp_secrets WHERE user_id = ? AND verified = 1",
          [(int) $userId]
        )->first();
        if (!$tr) {
          return false;
        }
        // Forced TOTP honors any user who has it set up; natural reauth only
        // offers TOTP when it is Required site-wide.
        return $relaxTotp ? true : (isset($settings->totp) && $settings->totp > 1);

      case 'passkey':
        if (!isset($settings->passkeys) || $settings->passkeys != 1) {
          return false;
        }
        $pc = $db->query("SELECT COUNT(*) AS c FROM us_passkeys WHERE user_id = ?", [(int) $userId])->first();
        return $pc && $pc->c > 0;

      case 'email':
        // Email code — for reauth this is ALWAYS a 6-digit code, never the
        // magic link, regardless of which email_login mode the site uses. Only
        // offer it if the site can actually send mail.
        return isset($settings->email_login) && $settings->email_login > 0
          && !empty($u->email) && emailSendingConfigured();

      case 'social':
        if (!isset($settings->oauth) || $settings->oauth != 1 || empty($u->oauth_provider)) {
          return false;
        }
        $oc = $db->query("SELECT COUNT(*) AS c FROM us_oauth_client_login_options WHERE oauth = 1")->first();
        return $oc && $oc->c > 0;
    }
    return false;
  }
}

// Decide which verification methods are valid for a given user, mirroring the
// login.php decision tree. Returns a subset of:
// ['password','totp','passkey','email','social'].
// $only restricts the result to a caller-supplied set (used by forceReauth()'s
// 'methods' option); when set, the TOTP gate is relaxed (see
// reauthMethodAvailable()) and the result follows $only's order.
if (!function_exists('reauthMethods')) {
  function reauthMethods($userId, $only = [])
  {
    global $db;
    $u = $db->query("SELECT * FROM users WHERE id = ?", [(int) $userId])->first();
    if (!$u) {
      return [];
    }
    $only = array_values(array_intersect(
      (array) $only,
      ['password', 'totp', 'passkey', 'email', 'social']
    ));
    $candidates = !empty($only) ? $only : ['password', 'totp', 'passkey', 'email', 'social'];
    $relaxTotp  = !empty($only);

    $methods = [];
    foreach ($candidates as $m) {
      if (reauthMethodAvailable($userId, $m, $u, $relaxTotp)) {
        $methods[] = $m;
      }
    }
    return $methods;
  }
}

// Guard: require a fresh re-authentication before continuing. Drop this at
// the top of any page (after init.php). If the session is still within the
// grace window it returns immediately; otherwise it redirects to reauth.php
// and, on success, returns the user to $returnTo (defaults to the current URL).
//   $opts['timeout'] — override the grace window, in minutes.
//   $opts['methods'] — restrict to specific verification method(s): a single
//                      name or an array, e.g. 'totp' or ['totp','passkey'].
//                      If none are set up for the user, reauth.php shows an
//                      explanatory message instead of falling back.
if (!function_exists('forceReauth')) {
  function forceReauth($returnTo = '', $purpose = '', $opts = [])
  {
    global $user, $us_url_root;
    if (!isset($user) || !$user->isLoggedIn()) {
      return; // Not logged in — the page's own securePage guard handles this.
    }
    $timeout = isset($opts['timeout']) ? (int) $opts['timeout'] : null;
    if (reauthConfirmed($timeout)) {
      return;
    }
    $k = reauthSessionKey();
    if (!isset($_SESSION[$k]) || !is_array($_SESSION[$k])) {
      $_SESSION[$k] = [];
    }
    $_SESSION[$k]['dest']    = ($returnTo !== '') ? $returnTo : Server::get('REQUEST_URI');
    $_SESSION[$k]['purpose'] = $purpose;
    if ($timeout !== null) {
      $_SESSION[$k]['timeout'] = $timeout;
    } else {
      unset($_SESSION[$k]['timeout']);
    }
    // Restrict which verification methods reauth.php may offer (string or array).
    if (!empty($opts['methods'])) {
      $_SESSION[$k]['methods'] = array_values((array) $opts['methods']);
    } else {
      unset($_SESSION[$k]['methods']);
    }
    Redirect::to($us_url_root . 'users/reauth.php');
  }
}

// Legacy admin step-up guard. Retained for backward compatibility — it is now
// a thin wrapper over forceReauth() using the admin_verify_timeout window.
// The old numeric-PIN flow (admin_pin.php) has been retired.
if (!function_exists('verifyadmin')) {
  function verifyadmin($page = '')
  {
    global $settings;
    $timeout = (isset($settings->admin_verify_timeout) && (int) $settings->admin_verify_timeout > 0)
      ? (int) $settings->admin_verify_timeout : 15;
    forceReauth('', 'admin', ['timeout' => $timeout]);
  }
}

/* ============================================================================
 * Cloaking  (admin "log in as" / impersonation)
 * ----------------------------------------------------------------------------
 * Cloak state lives under instance-namespaced session keys so two UserSpice
 * installs sharing one domain don't stomp on each other:
 *     {session_name}_cloak_to    - id of the user being impersonated
 *     {session_name}_cloak_from  - the admin's real id
 * The legacy un-namespaced $_SESSION['cloak_to'] / ['cloak_from'] are STILL
 * written and read (as a fallback) so older custom code keeps working. Always
 * go through these helpers rather than touching $_SESSION directly.
 * ==========================================================================*/

// Internal: the namespaced session key for a cloak field ('to'|'from'|'pending').
if (!function_exists('cloakKey')) {
  function cloakKey($which)
  {
    return Config::get('session/session_name') . '_cloak_' . $which;
  }
}

// Is a cloak currently active? (checks namespaced key, then legacy)
if (!function_exists('isCloaked')) {
  function isCloaked()
  {
    return isset($_SESSION[cloakKey('to')]) || isset($_SESSION['cloak_to']);
  }
}

// The user id being impersonated, or null.
if (!function_exists('cloakTo')) {
  function cloakTo()
  {
    if (isset($_SESSION[cloakKey('to')])) {
      return (int) $_SESSION[cloakKey('to')];
    }
    if (isset($_SESSION['cloak_to'])) {
      return (int) $_SESSION['cloak_to'];
    }
    return null;
  }
}

// The admin's real user id behind an active cloak, or null.
if (!function_exists('cloakFrom')) {
  function cloakFrom()
  {
    if (isset($_SESSION[cloakKey('from')])) {
      return (int) $_SESSION[cloakKey('from')];
    }
    if (isset($_SESSION['cloak_from'])) {
      return (int) $_SESSION['cloak_from'];
    }
    return null;
  }
}

// Low-level: write the cloak into the session. Sets BOTH the namespaced keys
// (preferred) and the legacy keys (backward compatibility) so nothing breaks.
if (!function_exists('setCloakSession')) {
  function setCloakSession($fromId, $toId)
  {
    $fromId = (int) $fromId;
    $toId   = (int) $toId;
    $_SESSION[cloakKey('from')] = $fromId;
    $_SESSION[cloakKey('to')]   = $toId;
    $_SESSION['cloak_from']     = $fromId;  // legacy
    $_SESSION['cloak_to']       = $toId;    // legacy
  }
}

// Decide whether the current admin may cloak into $targetId. Returns bool;
// on false, $reason is filled with a user-facing message. Mirrors the checks
// that previously lived inline in views/_admin_user.php.
if (!function_exists('canCloak')) {
  function canCloak($targetId, &$reason = null)
  {
    global $user, $db, $master_account;
    $targetId = (int) $targetId;
    $meId     = (int) $user->data()->id;

    // Base permission: cloak_allowed, OR a master account, OR already mid-cloak
    // (so an admin can hop between users without re-enabling the flag).
    if ($user->data()->cloak_allowed != 1
        && !in_array($meId, $master_account)
        && !isCloaked()) {
      $reason = 'You do not have permission to cloak';
      return false;
    }
    // Never cloak into a master account unless you are one yourself.
    if (in_array($targetId, $master_account) && !in_array($meId, $master_account)) {
      $reason = 'You cannot cloak into a master account';
      return false;
    }
    // No self-cloak.
    if ($targetId === $meId) {
      $reason = 'Cloaking into yourself would open up a black hole';
      return false;
    }
    // Target must exist.
    if ($db->query('SELECT id FROM users WHERE id = ?', [$targetId])->count() < 1) {
      $reason = 'You broke it! User not found';
      return false;
    }
    return true;
  }
}

// Full cloak entry point. Fires the cloakAttempt seam (event hook + the
// usersc/scripts/cloak_attempt.php script) BEFORE any permission check so
// custom code can intercept the whole process — typically to require step-up
// auth via forceReauth($cloak_resume_url,'cloak'), or to block outright by
// setting $cloak_attempt_block = true. Then validates perms and, on success,
// establishes the cloak and redirects to the account page.
//
// Returns ['ok'=>bool, 'error'=>string]. On a successful cloak it redirects
// and never returns (unless $opts['noRedirect'] is set).
if (!function_exists('cloakUser')) {
  function cloakUser($targetId, $opts = [])
  {
    global $user, $abs_us_root, $us_url_root;
    $targetId = (int) $targetId;
    $meId     = (int) $user->data()->id;

    // ---- cloakAttempt seam (runs before perm checks) --------------------
    // Exposed to the hook and the script:
    //   $cloak_target_id     int     who the admin is trying to cloak into
    //   $cloak_resume_url    string  one-time GET URL that resumes & finishes
    //                                this cloak after a forceReauth() round-trip
    //   $cloak_attempt_block bool    set true to deny the attempt
    //   $cloak_attempt_error string  optional message shown when blocking
    $nonce = bin2hex(random_bytes(16));
    $_SESSION[cloakKey('pending')] = ['id' => $targetId, 'nonce' => $nonce, 'ts' => time()];

    $cloak_target_id     = $targetId;
    $cloak_resume_url    = $us_url_root . 'users/admin.php?view=user&id=' . $targetId . '&cloak_confirm=' . $nonce;
    $cloak_attempt_block = false;
    $cloak_attempt_error = '';

    $attemptHooks = getMyHooks(['page' => 'cloakAttempt']);
    includeHook($attemptHooks, 'body');

    $cloakAttemptScript = $abs_us_root . $us_url_root . 'usersc/scripts/cloak_attempt.php';
    if (file_exists($cloakAttemptScript)) {
      include $cloakAttemptScript;
    }

    // @phpstan-ignore if.alwaysFalse ($cloak_attempt_block is set true by the cloakAttempt hook / usersc/scripts/cloak_attempt.php included above; PHPStan cannot analyse into those seams so it treats it as still false.)
    if ($cloak_attempt_block) {
      unset($_SESSION[cloakKey('pending')]);
      logger($meId, 'Cloaking', 'Cloak attempt into ' . $targetId . ' was blocked by custom code.');
      // @phpstan-ignore ternary.alwaysFalse ($cloak_attempt_error is populated by the same cloak_attempt seam above; PHPStan cannot analyse into the include so it treats it as still '' and the fallback as always taken.)
      return ['ok' => false, 'error' => $cloak_attempt_error ?: 'Cloaking was blocked.'];
    }

    // ---- permission checks ----------------------------------------------
    if (!canCloak($targetId, $reason)) {
      unset($_SESSION[cloakKey('pending')]);
      logger($meId, 'Cloaking', 'User attempted to cloak User ID #' . $targetId . ' - denied: ' . $reason);
      return ['ok' => false, 'error' => $reason];
    }

    // ---- establish the cloak --------------------------------------------
    unset($_SESSION[cloakKey('pending')]);
    setCloakSession($meId, $targetId);
    logger($meId, 'Cloaking', 'Cloaked into ' . $targetId);

    $cloakHook = getMyHooks(['page' => 'cloakBegin']);
    includeHook($cloakHook, 'body');

    if (empty($opts['noRedirect'])) {
      usSuccess('You are now cloaked!');
      Redirect::to($us_url_root . 'users/account.php');
    }
    return ['ok' => true, 'error' => ''];
  }
}

// Tear down an active cloak: restore the admin's real session, clear both the
// namespaced and legacy keys, log, and fire the cloakEnd hook. Returns
// ['ok'=>bool, 'from'=>?int, 'to'=>?int]. The caller handles messaging/redirect.
if (!function_exists('endCloak')) {
  function endCloak()
  {
    if (!isCloaked()) {
      return ['ok' => false, 'from' => null, 'to' => null];
    }
    $to   = cloakTo();
    $from = cloakFrom();

    // Restore the real (admin) user into the logged-in session slot.
    $_SESSION[Config::get('session/session_name')] = $from;

    unset(
      $_SESSION[cloakKey('to')],
      $_SESSION[cloakKey('from')],
      $_SESSION[cloakKey('pending')]
    );
    unset($_SESSION['cloak_to'], $_SESSION['cloak_from']); // legacy

    logger($from, 'Cloaking', 'uncloaked from ' . $to);
    $cloakHook = getMyHooks(['page' => 'cloakEnd']);
    includeHook($cloakHook, 'body');

    return ['ok' => true, 'from' => $from, 'to' => $to];
  }
}

// The id of the real human operating this session: the admin behind a cloak
// (cloak_from) when cloaked, otherwise the logged-in user. Use this for
// security decisions that must apply to the actual person — above all re-auth,
// which must verify the ADMIN's credentials, not the impersonated account's.
// Returns null if nobody is logged in.
if (!function_exists('realUserId')) {
  function realUserId()
  {
    global $user;
    $from = cloakFrom();
    if ($from) {
      return (int) $from;
    }
    return (isset($user) && $user->isLoggedIn()) ? (int) $user->data()->id : null;
  }
}

if (!function_exists('validateJson')) {
  function validateJson($string)
  {
    json_decode($string ?? '');

    return json_last_error() == JSON_ERROR_NONE;
  }
}

//Added in 5.3.0
//Grabs messages stored in the $_SESSION varaible and gets them ready for the error message system
//These are errors and successes from the validation class and an extra place to store general messages.
if (!function_exists('parseSessionMessages')) {
  function parseSessionMessages()
  {
    $sn = Config::get('session/session_name');
    $messages = [];
    $keys = ['genMsg', 'valSuc', 'valErr'];
    foreach ($keys as $key) {
      if (isset($_SESSION[$sn . $key])) {
        if (is_array($_SESSION[$sn . $key])) {
          $string = '';
          foreach ($_SESSION[$sn . $key] as $s) {
            //deal with compatibility of display_errors function
            if (is_array($s)) {
              foreach ($s as $str) {

                $string .= '<li>' . $str . '</li>';
              }
            } elseif (count($_SESSION[$sn . $key]) > 1) {
              $string .= '<li>' . $s . '</li>';
            } else {
              $string .= $s;
            }
          }
          $messages[$key] = $string;
        } else {
          $messages[$key] = $_SESSION[$sn . $key];
        }
      } else {
        $messages[$key] = '';
      }
      $_SESSION[$sn . $key] = '';
    }

    return $messages;
  }
}

//Added in 5.3.0
//This allows you to pass 3 parameters from standard php arrays
//to the $_SESSION varables without having to deal with the crazy naming
//Note that the session variables have these crazy names to prevent cross talk
//on shared hosting environments
if (!function_exists('sessionValMessages')) {
  function sessionValMessages($valErr = [], $valSuc = [], $genMsg = []): void
  {
    $keys = ['valErr', 'valSuc', 'genMsg'];
    foreach ($keys as $key) {
      $sessionKey = Config::get('session/session_name') . $key;
      $value = $$key;

      if (!empty($value)) {
        $value = is_array($value) ? $value : [$value];

        foreach ($value as $item) {
          $sanitizedItem = sanitizeHTML($item);

          if (isset($_SESSION[$sessionKey]) && is_array($_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey][] = $sanitizedItem;
          } elseif (isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey] !== '') {
            $save = $_SESSION[$sessionKey];
            $_SESSION[$sessionKey] = [
              sanitizeHTML($save),
              $sanitizedItem
            ];
          } else {
            $_SESSION[$sessionKey] = $sanitizedItem;
          }
        }
      }
    }
  }
}

function sanitizeHTML($input)
{
  $allowed_tags = '<strong><em><p><br><ul><li><a>';
  $allowed_attributes = ['href', 'title'];

  if (is_array($input)) {
    return array_map('sanitizeHTML', $input);
  }

  // Decode HTML entities first
  $input = html_entity_decode($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');

  // Remove all HTML tags except allowed ones
  $output = strip_tags($input, $allowed_tags);

  // Remove all attributes except those in the whitelist
  $output = preg_replace_callback('/<([^>]+)>/i', function ($matches) use ($allowed_attributes) {
    $tag = preg_replace('/\s+.*$/i', '', $matches[1]);
    preg_match_all('/(\w+)\s*=\s*"[^"]*"/i', $matches[1], $attributes);
    $filtered_attributes = array_intersect($attributes[1], $allowed_attributes);
    $tag_content = $tag . ' ' . implode(' ', $filtered_attributes);
    return "<$tag_content>";
  }, $output);

  return $output;
}

//Alias for passing error messages. Can be a message or array of messsages.
if (!function_exists("usError")) {
  function usError($msg)
  {
    sessionValMessages($msg);
  }
}

//Alias for passing warning messages. Can be a message or array of messsages.

if (!function_exists("usWarning")) {
  function usWarning($msg)
  {
    sessionValMessages("", "", $msg);
  }
}

//Alias for passing success messages. Can be a message or array of messsages.
if (!function_exists("usSuccess")) {
  function usSuccess($msg)
  {
    sessionValMessages("", $msg);
  }
}

//Alias for passing generic messages. Can be a message or array of messsages.
if (!function_exists("usMessage")) {
  function usMessage($msg)
  {
    sessionValMessages("", "", $msg);
  }
}

if (!function_exists('isUserLoggedIn')) {
  function isUserLoggedIn()
  {
    global $user;
    if (isset($user) && $user->isLoggedIn()) {
      return true;
    } else {
      return false;
    }
  }
}

//slightly shortens repetitive code for checkbox, radio, and dropdown form elements
if (!function_exists('isSelected')) {
  function isSelected($one, $two, $output = "selected='selected'")
  {
    if ($one == $two) {
      echo $output . " ";
    }
  }
}

if (!function_exists('checkAPIkey')) {
  function checkAPIkey($key)
  {
    $msg = "";
    if ($key == "") {
      $msg = "<h6><span style='color:blue'>Entering your free API key will enable cool features like Updates, Bug Reports, and Spice Shaker.</span> </h6>";
    } elseif (
      !preg_match("/^[\w]{5}-[\w]{5}-[\w]{5}-[\w]{5}-[\w]{5}$/", trim($key))
      && !preg_match("/^[\w]{5}-[\w]{5}-[\w]{5}-[\w]{5}-[\w]{4}$/", trim($key))
    ) {
      $msg = "<h4><span style='color:red'>The API Key does not appear to be valid.</span> </h4>";
    } else {
      $msg =  "<h4><span style='color:green'><span>&#10003;</span> Your API Key appears to be valid.</span> </h4>";
    }
    return $msg;
  }
}

if (!function_exists('UserSpice_getLogs')) {
  function UserSpice_getLogs($opts = [])
  {

    global $db, $user;
    if ($user->isLoggedIn()) {
      $userId = $user->data()->id;
    } else {
      // Most of my functions would use 1, but I can't assume that for all US installations
      $userId = 0;
    }

    // Current Accepted $opts:
    // - preset | String: "diag"
    // - limit | int (eg. 1000) | string (eg. "LIMIT 5000") | null
    $preset = $opts['preset'] ?? null;

    // We have to do this check in case limit is set to NULL, otherwise the concatenation I would want to do won't work (it'll set it anyways)
    if (array_key_exists('limit', $opts)) {
      $limit = $opts['limit'];
      if (is_int($limit)) {
        $limit = "LIMIT {$limit}";
      }
    } else {
      $limit = 'LIMIT 5000';
    }

    $query_where = '';
    // Later we will add the ability to register a hook that can add additional clauses to this function without overriding it
    if ($preset == 'debug') {
      if (strpos(strtolower($query_where), 'where ') == false) {
        $query_where = 'WHERE ';
      }
      // Since we are not allowing user input into this, it is safe to pass without sanitizing it
      $query_where .= "logtype = 'Redirect Diag' OR logtype = 'Form Data'";
    } elseif ($preset == 'passwordless') {
      if (strpos(strtolower($query_where), 'where ') == false) {
        $query_where = 'WHERE ';
      }

      $query_where .= " logtype = 'Passwordless Debug' OR logtype = 'Passwordless Debug UA' ";
    } elseif ($preset == "database_debug") {
      if (strpos(strtolower($query_where), 'where ') == false) {
        $query_where = 'WHERE ';
      }

      $query_where .= " logtype = 'DATABASE_INSERT' OR logtype = 'DATABASE_UPDATE' ";
    }

    if ($query_where != '') {
    }
    $query = trim(str_replace('  ', ' ', "SELECT * FROM logs {$query_where} ORDER BY id DESC {$limit}"));

    $db->query($query);
    if (!$db->error()) {
      // Return the results
      return $db->results();
    } else {

      // Return an array since views/_admin_logs expects this
      return [];
    }
  }
}

//creates a form csrf security token
if (!function_exists("tokenHere")) {
  function tokenHere()
  {
  ?>
    <input type="hidden" name="csrf" value="<?= Token::generate(); ?>">
<?php
  }
}

if (!function_exists("fetchProfilePicture")) {
  function fetchProfilePicture($userid)
  {
    global $db;
    $q = $db->query("SELECT * FROM users WHERE id = ?", [$userid]);
    $c = $q->count();
    if ($c < 1) {
      //build in default photo
      $grav = get_gravatar(strtolower(trim("userspicephp@gmail.com")));
    } else {
      $u = $q->first();
      if (isset($u->steam_avatar) && $u->steam_avatar != '') {
        $grav = $u->steam_avatar;
      } elseif (isset($u->picture) && $u->picture != '') {
        $grav = $u->picture;
      } else {
        $grav = get_gravatar(strtolower(trim($u->email)));
      }
    }
    return $grav;
  }
}

if (!function_exists("fetchFolderFiles")) {
  function fetchFolderFiles($folder, $extension = "php")
  {
    global $abs_us_root, $us_url_root;
    if (!is_array($extension)) {
      $extension = (array)$extension;
    }

    $files = [];
    $links = [];
    $direct = [];
    if (substr($folder, -1) != "/") {
      $folder = $folder . "/";
    }
    $linkpath = $us_url_root .  $folder;
    $basepath = $abs_us_root . $linkpath;

    if (is_dir($basepath)) {
      $scan_arr = scandir($basepath);
      $files_arr = array_diff($scan_arr, array('.', '..'));

      foreach ($files_arr as $file) {
        $file_path = $basepath . $file;
        $file_ext = pathinfo($file_path, PATHINFO_EXTENSION);
        if (in_array($file_ext, $extension)) {
          $files[] = $file;
          $links[] = $linkpath  . $file;
          $direct[] = $basepath . $file;
        }
      }
    }
    $response = ["files" => $files, "direct" => $direct, "links" => $links];
    return $response;
  }
}


//examples
//30 days from today
//echo offsetDate(30);

//7 days ago
//echo offsetDate(-7);

//can be hours, months, days, years, etc
// Or what the day will be in 17 hours with
// echo offsetDate(17,"","hours");
// Or you can do it from another date so 20 days from Jan 1, 2023
// echo offsetDate(20,"2023-01-01");

function offsetDate($number, $datestring = "", $unit = "days")
{
  if ($datestring == "") {
    $datestring = date("Y-m-d");
  }
  $first = substr($number, 0, 1);
  if ($first != "+" && $first != "-") {
    $symbol = "+ ";
  } else {
    $symbol = "";
  }
  return date("Y-m-d", strtotime($symbol . $number . $unit, strtotime($datestring)));
}

if (!function_exists("hed")) {
  function hed($string, $stripTags = false)
  {
    if (!is_string($string)) {
      return $string;
    }
    $decoded = htmlspecialchars_decode(html_entity_decode($string, ENT_QUOTES, "UTF-8"));
    return $stripTags ? strip_tags($decoded) : $decoded;
  }
}

function checkInternet($host = 'www.google.com')
{
  $result = @dns_get_record($host, DNS_A); // Check for A records of the host
  if (!empty($result)) {
    return true; // Internet seems to be available
  } else {
    return false; // No internet connection
  }
}


// This function checks the strength of the password and uses the score from userSpicePasswordScore.
if (!function_exists("userSpicePasswordStrength")) {
  function userSpicePasswordStrength($password)
  {
    global $pw_settings, $db;


    if (!isset($pw_settings->min_length)) {
      $pw_settings = $db->query("SELECT * FROM us_password_strength")->first();
    }

    $result = array(
      'isValid' => true,
      'strength' => 0,
      'errors' => []
    );

    if (!isset($pw_settings->min_length) || $pw_settings->enforce_rules == 0) {
      $result['strength'] = 100;
      return $result;
    }

    // Calculate the score using the dedicated function
    $result['strength'] = userSpicePasswordScore($password, $pw_settings);

    // Individual Checks
    if (strlen($password) < $pw_settings->min_length) {
      $result['isValid'] = false;
      $result['errors'][] = "Password must be at least " . $pw_settings->min_length . " characters long.";
    }

    if (strlen($password) > $pw_settings->max_length) {
      $result['isValid'] = false;
      $result['errors'][] = "Password cannot be longer than " . $pw_settings->max_length . " characters.";
    }

    if ($pw_settings->require_uppercase && !preg_match('/[A-Z]/', $password)) {
      $result['isValid'] = false;
      $result['errors'][] = "Password must contain at least one uppercase letter.";
    }

    if ($pw_settings->require_lowercase && !preg_match('/[a-z]/', $password)) {
      $result['isValid'] = false;
      $result['errors'][] = "Password must contain at least one lowercase letter.";
    }

    if ($pw_settings->require_numbers && !preg_match('/[0-9]/', $password)) {
      $result['isValid'] = false;
      $result['errors'][] = "Password must contain at least one number.";
    }

    if ($pw_settings->require_symbols && !preg_match('/[^A-Za-z0-9]/', $password)) {
      $result['isValid'] = false;
      $result['errors'][] = "Password must contain at least one symbol.";
    }

    if ($result['strength'] < $pw_settings->min_score) {
      $result['isValid'] = false;
      $result['errors'][] = "Password must meet the minimum strength score.";
    }


    return $result;
  }
}

// This function computes the password score based on its characteristics.
function userSpicePasswordScore($password)
{
  global $pw_settings, $db;

  if (!isset($pw_settings->min_length)) {
    $pw_settings = $db->query("SELECT * FROM us_password_strength")->first();
  }

  $score = 0;

  // Score computation logic
  // Adjusting the score computation logic based on password length
  $score += (strlen($password) >= 8) ? $pw_settings->greater_eight : 0;
  $score += (strlen($password) >= 12) ? $pw_settings->greater_twelve : 0;
  $score += (strlen($password) > 16) ? $pw_settings->greater_sixteen : 0;

  // Scoring based on character types
  $score += (preg_match('/[A-Z]/', $password)) ? $pw_settings->uppercase_score : 0;
  $score += (preg_match('/[a-z]/', $password)) ? $pw_settings->lowercase_score : 0;
  $score += (preg_match('/[0-9]/', $password)) ? $pw_settings->number_score : 0;
  $score += (preg_match('/[^A-Za-z0-9]/', $password)) ? $pw_settings->symbol_score : 0;

  // Adding additional points for length, capped at 20
  $score += min(20, strlen($password) * 2);

  //if score is > 74 but is missing one of the key rules, we're going to drop it back down to 74
  if ($score > 74) {
    if (
      strlen($password) < $pw_settings->min_length ||
      strlen($password) > $pw_settings->max_length ||
      !preg_match('/[a-z]/', $password) ||
      !preg_match('/[A-Z]/', $password) ||
      !preg_match('/[0-9]/', $password) ||
      !preg_match('/[^A-Za-z0-9]/', $password)
    ) {
      $score = 74;
    }
  }

  // Ensure the score does not exceed 100
  if ($score > 100) {
    $score = 100;
  }

  return $score;
}


// Active logging
// users/init.php set
//define('USERSPICE_ACTIVE_LOGGING', true);
//to turn on file based active logging


//to prevent logging on a page
//add this to the top of the page above init.php
// define('USERSPICE_DO_NOT_LOG', true);
// or add the page name to the array in usersc/includes/active_logging_custom.php

//usersc/includes/active_logging_custom.php
function userspiceActiveLog($currentPage, $user = null, $additionalData = [])
{
  global $abs_us_root, $us_url_root;
  // Only proceed if active logging is enabled and page isn't excluded
  $activeLoggingEnabled = defined('USERSPICE_ACTIVE_LOGGING') && constant('USERSPICE_ACTIVE_LOGGING');
  if (!$activeLoggingEnabled) {
    return false;
  }

  // Defaults — the optional custom file included below is the canonical place
  // to override any of these. Declaring them up front means the rest of the
  // function can use them unconditionally (and keeps static analysis happy).
  $do_not_log_files  = ["heartbeat.php", "fetchMessages.php"];
  $do_not_log_fields = ["password", "password_confirm", "confirm"];
  $filename          = null;

  if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/active_logging_custom.php')) {
    include $abs_us_root . $us_url_root . 'usersc/includes/active_logging_custom.php';
  }

  if (in_array($currentPage, $do_not_log_files)) {
    return false;
  }

  // Check if this page should be excluded from logging
  // @phpstan-ignore booleanAnd.rightAlwaysTrue (USERSPICE_DO_NOT_LOG is defined by user pages before init.php and may be false; PHPStan only sees the single true define call in users/logs/index.php.)
  if (defined('USERSPICE_DO_NOT_LOG') && USERSPICE_DO_NOT_LOG) {
    return false;
  }



  // Get full URL
  $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
  $fullUrl = $protocol . Server::get('HTTP_HOST') . Server::get('REQUEST_URI');

  // Prepare log entry
  $logEntry = [
    'timestamp' => date('Y-m-d H:i:s'),
    'ip' => Server::get('REMOTE_ADDR'),
    'user_id' => ($user && isset($user->data()->id)) ? $user->data()->id : 0,
    'page' => $currentPage,
    'full_url' => $fullUrl,
    'request_method' => Server::get('REQUEST_METHOD'),
    'get_data' => [],
    'post_data' => [],
    'json_data' => [],
    'additional_data' => $additionalData
  ];

  // Process GET data
  foreach ($_GET as $k => $v) {
    $logEntry['get_data'][$k] = Input::sanitize($v);
  }

  // Process POST data (excluding sensitive fields)
  foreach ($_POST as $k => $v) {
    if (!in_array($k, $do_not_log_fields)) {
      $logEntry['post_data'][$k] = Input::sanitize($v);
    }
  }

  // Process JSON input if content type is application/json
  $contentType = isset($_SERVER["CONTENT_TYPE"]) ? Input::sanitize(Server::get("CONTENT_TYPE")) : '';
  if (stripos($contentType, 'application/json') !== false) {
    $json_data = json_decode(file_get_contents('php://input'), true);
    if ($json_data) {
      // Remove sensitive fields from JSON data
      array_walk_recursive($json_data, function (&$value, $key) use ($do_not_log_fields) {
        if (in_array($key, $do_not_log_fields)) {
          $value = '[REDACTED]';
        }
      });
      $logEntry['json_data'] = $json_data;
    }
  }

  // Add user agent
  $logEntry['user_agent'] = Input::sanitize(Server::get('HTTP_USER_AGENT'));

  // Convert to JSON and append to file
  $jsonEntry = json_encode($logEntry) . "\n";

  // $filename is normally set by active_logging_custom.php (included above).
  // Fall back to a default — mirroring that file's logic — when the custom
  // file has been removed, so logging never writes to an empty path.
  // @phpstan-ignore booleanNot.alwaysTrue ($filename is populated by usersc/includes/active_logging_custom.php, included above; PHPStan cannot analyse into that include so it treats $filename as still null.)
  if (!$filename) {
    $logDir = $abs_us_root . $us_url_root . 'users/logs';
    if (!is_dir($logDir)) {
      mkdir($logDir, 0755, true);
    }
    $logUid   = ($user && isset($user->data()->id)) ? $user->data()->id : 0;
    $filename = $logDir . '/' . date('Ymd_H') . '_' . $logUid . '.log.php';
    if (!file_exists($filename)) {
      file_put_contents($filename, ";<?php die(); ?>\n");
    }
  }

  // Append log entry to file
  return file_put_contents($filename, $jsonEntry, FILE_APPEND | LOCK_EX);
}

function cleanupLogs($daysToKeep = 30)
{
  global $abs_us_root, $us_url_root;
  $logDir = $abs_us_root . $us_url_root . 'users/logs';
  $files = glob($logDir . '/*.log.php');
  $cutoffDate = strtotime("-{$daysToKeep} days");

  foreach ($files as $file) {
    $dateFromFilename = substr(basename($file), 0, 8); // Extract YYYYMMDD
    $fileDate = DateTime::createFromFormat('Ymd', $dateFromFilename);

    if ($fileDate && $fileDate->getTimestamp() < $cutoffDate) {
      unlink($file);
    }
  }
}

function isHTTPSConnection()
{
  // Direct HTTPS check
  if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    return true;
  }

  // Proxy headers check for HTTPS
  if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    return true;
  }

  // Additional proxy SSL header check
  if (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on') {
    return true;
  }

  // Port check for SSL
  if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] === '443') {
    return true;
  }

  return false;
}

/**
 * @psalm-taint-escape html — wraps htmlspecialchars with ENT_QUOTES
 */
function safeReturn($string, $hed = false)
{
  $value = $string ?? "";
  if ($hed) {
    $value = hed($value);
  }
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * json_encode a value with all HEX escape flags for safe JS embedding.
 *
 * @psalm-taint-escape html
 * @psalm-taint-escape text — json_encode with HEX flags neutralises HTML/JS special chars
 */
function safeJsonEncodeForJs($value): string
{
  return json_encode((string)$value, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP);
}

/**
 * Identity function that marks data as safe for curl/SSRF checks
 * (e.g. hardcoded URLs, or payloads sent to hardcoded endpoints).
 *
 * @psalm-taint-escape ssrf — caller must ensure the curl target is trusted
 */
function safeCurl(string $value): string
{
  return $value;
}

/**
 * Mark trusted HTML content as safe for output (e.g. admin-edited or decoded DB fields).
 *
 * @psalm-taint-escape html
 * @psalm-taint-escape text — caller must ensure content is from a trusted source
 */
function trustedHtml(string $html): string
{
  return $html;
}

/**
 * Sanitizes a file path to prevent directory traversal and remote file inclusion.
 *
 * @param string $path The potentially unsafe path to sanitize.
 * @param string $baseDir The absolute path to the trusted base directory.
 * @return string|false The sanitized, absolute path if it's safe, or false if it's not.
 */
function sanitizePath(string $path, string $baseDir)
{
  if (preg_match('~^(?:[a-z][a-z0-9+-.]*:)?//~i', $path)) {
    return false;
  }

  $fullPath = $baseDir . DIRECTORY_SEPARATOR . $path;
  $realFullPath = realpath($fullPath);
  $realBaseDir = realpath($baseDir);

  if ($realFullPath === false || strpos($realFullPath, $realBaseDir) !== 0) {
    return false;
  }

  return $realFullPath;
}

if (!function_exists('us_file_get_contents')) {
  function us_file_get_contents($url)
  {
    // Check if it's a URL
    if (filter_var($url, FILTER_VALIDATE_URL)) {
      // Use cURL for URLs
      if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; UserSpice)');
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (PHP_VERSION_ID < 80500) {
       curl_close($ch);
 }

        if ($httpCode == 200) {
          return $result;
        }
        return false;
      }
      return false;
    } else {
      // Use regular file_get_contents for local files
      return file_get_contents($url);
    }
  }
}

if (!function_exists('is_path_writable')) {
  // Check subdirectory permissions
  function is_path_writable($path, &$non_writable = [], $max_examples = 10)
  {
    if (count($non_writable) >= $max_examples) {
      return false;
    }

    // Skip files that are intentionally not writable for security
    if (basename($path) == 'totp_key.php') {
      return true;
    }

    if (!is_writable($path)) {
      $non_writable[] = $path;
      return false;
    }

    if (is_dir($path)) {
      // We don't want to scan .git folders
      if (basename($path) == '.git') {
        return true;
      }
      $files = scandir($path);
      foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
          $full_path = rtrim($path, '/') . '/' . $file;
          if (!is_path_writable($full_path, $non_writable, $max_examples)) {
            if (count($non_writable) >= $max_examples) {
              return false;
            }
          }
        }
      }
    }
    return true;
  }
}

/**
 * Validate a cURL API response for common failure modes.
 * Must be called BEFORE curl_close() since it reads curl state.
 *
 * Returns an associative array:
 *   'success'          => bool
 *   'error'            => string|null  (human-readable error message)
 *   'connectionFailed' => bool         (true if curl itself failed)
 *   'httpCode'         => int
 *   'curlErrno'        => int
 *   'curlError'        => string|null
 *   'result'           => string|null  (raw response body, null on failure)
 */
function usValidateApiResponse($result, $ch): array
{
  $curlErrno = curl_errno($ch);
  $curlError = $curlErrno ? curl_error($ch) : null;
  $httpCode  = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);

  $response = [
    'success'          => true,
    'error'            => null,
    'connectionFailed' => false,
    'httpCode'         => $httpCode,
    'curlErrno'        => $curlErrno,
    'curlError'        => $curlError,
    'result'           => $result,
  ];

  // 1. cURL-level failure (DNS, timeout, connection refused, etc.)
  if ($result === false || $curlErrno) {
    $response['success']          = false;
    $response['connectionFailed'] = true;
    $response['error']            = "Could not connect to the API"
      . ($curlError ? ": " . safeReturn($curlError) : "");
    $response['result']           = null;
    return $response;
  }

  // 2. HTTP error status
  if ($httpCode >= 400) {
    $response['success'] = false;
    $response['error']   = "API returned an error (HTTP $httpCode)";
    $response['result']  = null;
    return $response;
  }

  // 3. HTTP 200 but response body contains an API-level error
  $decoded = json_decode($result);

  if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
    $response['success'] = false;
    $response['error']   = "Invalid response from the API";
    $response['result']  = null;
    return $response;
  }

  if (is_object($decoded)) {
    if (isset($decoded->error) || (isset($decoded->success) && !$decoded->success)) {
      $response['success'] = false;
      $response['error']   = isset($decoded->error) ? (string) $decoded->error
        : (isset($decoded->msg) ? (string) $decoded->msg : "API request was not successful");
      $response['result']  = null;
      return $response;
    }
  }

  return $response;
}

if (!function_exists('fetchUserName')) {
  function fetchUserName($username = null, $id = null)
  {
    global $db;

    if ($username !== null && trim((string)$username) !== '') {
      $query = $db->query(
        "SELECT TRIM(CONCAT(COALESCE(fname,''), ' ', COALESCE(lname,''))) AS name
         FROM users WHERE `username` = ? LIMIT 1",
        [trim((string)$username)]
      );
    } elseif ($id !== null && (int)$id > 0) {
      $query = $db->query(
        "SELECT TRIM(CONCAT(COALESCE(fname,''), ' ', COALESCE(lname,''))) AS name
         FROM users WHERE `id` = ? LIMIT 1",
        [(int)$id]
      );
    } else {
      return 'Unknown';
    }

    if ($query->count() > 0) {
      $name = trim((string)$query->first()->name);
      return ($name !== '') ? $name : 'Unnamed User';
    }

    return 'Unknown';
  }
}

function usguid($trim = true)
{
  // Windows
  if (function_exists('com_create_guid') === true) {
    if ($trim === true)
      return trim(com_create_guid(), '{}');
    else
      return com_create_guid();
  }

  // OSX/Linux
  if (function_exists('openssl_random_pseudo_bytes') === true) {
    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }

  // Fallback (PHP 4.2+)
  mt_srand((int)((float)microtime() * 10000));
  $charid = strtolower(md5(uniqid((string)rand(), true)));
  $hyphen = chr(45);                  // "-"
  $lbrace = $trim ? "" : chr(123);    // "{"
  $rbrace = $trim ? "" : chr(125);    // "}"
  $guidv4 = $lbrace .
    substr($charid,  0,  8) . $hyphen .
    substr($charid,  8,  4) . $hyphen .
    substr($charid, 12,  4) . $hyphen .
    substr($charid, 16,  4) . $hyphen .
    substr($charid, 20, 12) .
    $rbrace;
  return $guidv4;
}