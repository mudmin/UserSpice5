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
        $db = DB::getInstance();
        $q = 'SELECT * FROM users';
        if (!$disabled) {
            $q .= ' WHERE permissions=1';
        }
        if ($orderBy !== null) {
            if ($desc === true) {
                $q .= " ORDER BY $orderBy DESC";
            } else {
                $q .= " ORDER BY $orderBy";
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
    $db = DB::getInstance();
    $query = $db->query("SELECT * FROM users WHERE id = ?", [$id]);
    if ($query->count() > 0) {
      return $query->first();
    }else{
      return false;
    }
  }
}

//Retrieve complete user information by username, token or ID
//This function is primarily for legacy purposes
if (!function_exists('fetchUserDetails')) {
  function fetchUserDetails($column = null, $term = null, $id = null)
  {
    $db = DB::getInstance();
    if($column == null || $column == ""){
      $column = "id";
    }

    if($term == null || $term == ""){
      $term = $id;
    }

    $query = $db->query("SELECT * FROM users WHERE $column = ? LIMIT 1", [$term]);
    if ($query->count() == 1) {
      return $query->first();
    }else{
      return false;
    }

  }
}

//Delete a defined array of users
if (!function_exists('deleteUsers')) {
    function deleteUsers($users)
    {
        global $abs_us_root, $us_url_root;
        $db = DB::getInstance();
        $i = 0;
        foreach ($users as $id) {
            $query1 = $db->query('DELETE FROM users WHERE id = ?', [$id]);
            $query2 = $db->query('DELETE FROM user_permission_matches WHERE user_id = ?', [$id]);
            if (file_exists($abs_us_root.$us_url_root.'usersc/scripts/after_user_deletion.php')) {
                include $abs_us_root.$us_url_root.'usersc/scripts/after_user_deletion.php';
            }
            ++$i;
        }

        return $i;
    }
}

if (!function_exists('echouser')) {
    function echouser($id, $echoType = null, $return = false)
    {

        $db = DB::getInstance();
        if($id == "" || $id == 0){
          $string = "Guest";
          if($return){
            return $string;
          }else{
            echo $string;
          }
        }

        $id = (int) $id;

        if ($echoType !== null) {
            $echoType = (int) $echoType;
        } else {
            $settingsQ = $db->query('SELECT echouser FROM settings');
            $settings = $settingsQ->first();
            $echoType = $settings->echouser;
        }
        $string = "Unknown";
        if ($echoType == 0) {
            $query = $db->query('SELECT fname,lname FROM users WHERE id = ? LIMIT 1', [$id]);

            $count = $query->count();
            if ($count > 0) {
                $results = $query->first();
                $string = $results->fname.' '.$results->lname;

            }
        }elseif ($echoType == 1) {
            $query = $db->query('SELECT username FROM users WHERE id = ? LIMIT 1', [$id]);
            $count = $query->count();
            if ($count > 0) {
                $results = $query->first();
                $string = ucfirst($results->username);
            }
        }elseif ($echoType == 2) {
            $query = $db->query('SELECT username,fname,lname FROM users WHERE id = ? LIMIT 1', [$id]);
            $count = $query->count();
            if ($count > 0) {
                $results = $query->first();
                $string = ucfirst($results->username).' ('.$results->fname.' '.$results->lname.')';
            }
        }elseif ($echoType == 3) {
            $query = $db->query('SELECT username,fname FROM users WHERE id = ? LIMIT 1', [$id]);
            $count = $query->count();
            if ($count > 0) {
                $results = $query->first();
                $string =  ucfirst($results->username).' ('.$results->fname.')';
            }
        }elseif ($echoType == 4) {
            $query = $db->query('SELECT fname,lname FROM users WHERE id = ? LIMIT 1', [$id]);
            $count = $query->count();
            if ($count > 0) {
                $results = $query->first();
                $string = ucfirst($results->fname).' '.substr(ucfirst($results->lname), 0, 1);
            }

          }

        if($return == true){
          return $string;
        }else{
          echo $string;
        }
    }
}


if (!function_exists('echousername')) {
    function echousername($id)
    {
        $db = DB::getInstance();
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
        $db = DB::getInstance();
        $result = $db->query("UPDATE users SET $column = ? WHERE id = ?", [$value, $id]);

        return $result;
    }
}

if (!function_exists('fetchUserName')) {
    //Fetchs CONCAT of Fname Lname
    function fetchUserName($username = null, $token = null, $id = null)
    {
        if ($username != null) {
            $column = 'username';
            $data = $username;
        } elseif ($id != null) {
            $column = 'id';
            $data = $id;
        }
        $db = DB::getInstance();
        $query = $db->query("SELECT CONCAT(fname,' ',lname) AS name FROM users WHERE $column = $data LIMIT 1");
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
        $db = DB::getInstance();
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
