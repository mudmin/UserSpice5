<?php

//UserSpice functions for Pages and Permissions
//Do not deactivate!

//Check if a permission level ID exists in the DB
if (!function_exists('permissionIdExists')) {
    function permissionIdExists($id)
    {
        $db = DB::getInstance();
        $query = $db->query('SELECT id FROM permissions WHERE id = ? LIMIT 1', [$id]);
        $num_returns = $query->count();

        if ($num_returns > 0) {
            return true;
        } else {
            return false;
        }
    }
}

//Retrieve information for a single permission level
if (!function_exists('fetchPermissionDetails')) {
    function fetchPermissionDetails($id)
    {
        $db = DB::getInstance();
        $query = $db->query('SELECT id, name FROM permissions WHERE id = ? LIMIT 1', [$id]);
        $results = $query->first();
        $row = ['id' => $results->id, 'name' => $results->name];

        return $row;
    }
}

//Change a permission level's name
if (!function_exists('updatePermissionName')) {
    function updatePermissionName($id, $name)
    {
        $db = DB::getInstance();
        $fields = ['name' => $name];
        $db->update('permissions', $id, $fields);
    }
}

//Retrieve list of permission levels a user has
if (!function_exists('fetchUserPermissions')) {
    function fetchUserPermissions($user_id)
    {
        $db = DB::getInstance();
        $query = $db->query('SELECT * FROM user_permission_matches WHERE user_id = ?', [$user_id]);
        $results = $query->results();

        return $results;
    }
}

//Retrieve list of users who have a permission level
if (!function_exists('fetchPermissionUsers')) {
    function fetchPermissionUsers($permission_id)
    {
        $db = DB::getInstance();
        $query = $db->query('SELECT id, user_id FROM user_permission_matches WHERE permission_id = ?', [$permission_id]);
        $results = $query->results();

        return $results;
        $row[$user] = ['id' => $id, 'user_id' => $user];
        if (isset($row)) {
            return $row;
        }
    }
}

//Unmatch permission level(s) from user(s)
if (!function_exists('removePermission')) {
    function removePermission($permissions, $members)
    {
        $db = DB::getInstance();
        if (is_array($members)) {
            $memberString = '';
            foreach ($members as $member) {
                $memberString .= $member.',';
            }
            $memberString = rtrim($memberString, ',');

            $q = $db->query("DELETE FROM user_permission_matches WHERE permission_id = ? AND user_id IN ({$memberString})", [$permissions]);
        } elseif (is_array($permissions)) {
            $permissionString = '';
            foreach ($permissions as $permission) {
                $permissionString .= $permission.',';
            }
            $permissionString = rtrim($permissionString, ',');
            $q = $db->query("DELETE FROM user_permission_matches WHERE user_id = ? AND permission_id IN ({$permissionString})", [$members]);
        }

        return $q->count();
    }
}

//Retrieve a list of all .php files in root files folder
if (!function_exists('getPathPhpFiles')) {
    function getPathPhpFiles($absRoot, $urlRoot, $fullPath)
    {
        $directory = $absRoot.$urlRoot.$fullPath;
        //bold ($directory);
        $pages = glob($directory.'*.php');

        foreach ($pages as $page) {
            $fixed = str_replace($absRoot.$urlRoot, '', $page);
            $row[$fixed] = $fixed;
        }
        if ($pages != null) {
            return $row;
        }
    }
}

//Delete a page from the DB
if (!function_exists('deletePages')) {
    function deletePages($pages)
    {
        $db = DB::getInstance();
        if (!$query = $db->query("DELETE FROM pages WHERE id IN ({$pages})")) {
            throw new Exception('There was a problem deleting pages.');
        } else {
            cleanupPermissionPageMatches();

            return true;
        }
    }
}

// Cleanup orphraned permissions after removing pages
if (!function_exists('cleanupPermissionPageMatches')) {
    function cleanupPermissionPageMatches()
    {
        global $db, $user;
        if (!isset($db)) {
            $db = DB::getInstance();
        }

        if (isUserLoggedIn()) {
            $userId = $user->data()->id;
        } else {
            $userId = 1;
        }

        $db->query('DELETE FROM permission_page_matches WHERE page_id NOT IN (SELECT id FROM pages)');
        if (!$db->error()) {
            $count = $db->count();
            $plural = 'permission';
            if ($count > 1) {
                $plural .= 's';
            }
            if ($count > 0) {
                logger($userId, 'cleanupPermissionPageMatches', "Removed {$count} orphaned {$plural}");
            }

            return true;
        } else {
            logger($userId, 'cleanupPermissionPageMatches', 'Error while cleaning up orphaned permissions', ['ERROR' => $db->errorString()]);

            return false;
        }
    }
}

//Fetch information on all pages
if (!function_exists('fetchAllPages')) {
    function fetchAllPages()
    {
        $db = DB::getInstance();
        $query = $db->query('SELECT id, page, title, private, re_auth, core FROM pages ORDER BY id DESC');
        $pages = $query->results();
        //return $pages;

        if (isset($row)) {
            return $row;
        } else {
            return $pages;
        }
    }
}

//Fetch information for a specific page
if (!function_exists('fetchPageDetails')) {
    function fetchPageDetails($id)
    {
        $db = DB::getInstance();
        $query = $db->query('SELECT id, page, title, private, re_auth FROM pages WHERE id = ?', [$id]);
        $row = $query->first();

        return $row;
    }
}

//Check if a page ID exists
if (!function_exists('pageIdExists')) {
    function pageIdExists($id)
    {
        $db = DB::getInstance();
        $query = $db->query('SELECT private FROM pages WHERE id = ? LIMIT 1', [$id]);
        $num_returns = $query->count();
        if ($num_returns > 0) {
            return true;
        } else {
            return false;
        }
    }
}

//Toggle private/public setting of a page
if (!function_exists('updatePrivate')) {
    function updatePrivate($id, $private)
    {
        $db = DB::getInstance();
        if ($private == 0) {
            $result = $db->query('UPDATE pages SET private = ?,re_auth = ? WHERE id = ?', [$private, 0, $id]);
        } else {
            $result = $db->query('UPDATE pages SET private = ? WHERE id = ?', [$private, $id]);
        }

        return $result;
    }
}

//Add a page to the DB
if (!function_exists('createPages')) {
    function createPages($pages)
    {
        $db = DB::getInstance();
        foreach ($pages as $page) {
            $setting = $db->query('SELECT page_default_private FROM settings')->first();
            $fields = ['page' => $page, 'private' => $setting->page_default_private];
            $db->insert('pages', $fields);
        }
    }
}

//Match permission level(s) with page(s)
if (!function_exists('addPage')) {
    function addPage($page, $permission)
    {
        $db = DB::getInstance();
        $i = 0;
        if (is_array($permission)) {
            foreach ($permission as $id) {
                $query = $db->query("INSERT INTO permission_page_matches (
				permission_id, page_id ) VALUES ( $id , $page )");
                ++$i;
            }
        } elseif (is_array($page)) {
            foreach ($page as $id) {
                $query = $db->query("INSERT INTO permission_page_matches (
			permission_id, page_id ) VALUES ( $permission , $id )");
                ++$i;
            }
        } else {
            $query = $db->query("INSERT INTO permission_page_matches (
			permission_id, page_id ) VALUES ( $permission , $page )");
            ++$i;
        }

        return $i;
    }
}

//Check if a user has access to a page
if (!function_exists('securePage')) {
    function securePage($uri)
    {
        global $user,$master_account, $us_url_root,$abs_us_root;
        $urlRootLength = strlen($us_url_root);
        $page = substr($uri, $urlRootLength, strlen($uri) - $urlRootLength);
        $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
        $dest = encodeURIComponent($protocol."://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
        $db = DB::getInstance();
        $id = null;
        $private = null;

        if (isset($user) && $user->data() != null) {
            if ($user->data()->permissions == 0) {
                Redirect::to($us_url_root.'usersc/scripts/banned.php');
                die();
            }
        }
        //retrieve page details
        $query = $db->query('SELECT id, page, private FROM pages WHERE page = ?', [$page]);
        $count = $query->count();
        if ($count == 0) {
            if (hasPerm([2])) {
                $setting = $db->query('SELECT page_default_private FROM settings')->first();
                $fields = [
                    'page' => $page,
                    'private' => $setting->page_default_private,
                ];
                $new = $db->insert('pages', $fields);
                $last = $db->lastId();

                if (strpos($page, 'usersc/') !== false) {
                    $q = $db->query('SELECT * FROM pages WHERE page = ?', [str_replace('usersc/', 'users/', $page)]);
                    if ($q->count() == 1) {
                        $result = $q->first();
                        $db->update('pages', $last, ['title' => $result->title, 'private' => $result->private, 're_auth' => $result->re_auth]);
                        if (!$db->error()) {
                            logger($user->data()->id, 'securePage', "Updated $page based on users match.");
                        } else {
                            logger($user->data()->id, 'securePage', "Failed to update $page based on match, Error: ".$db->errorString());
                        }
                        $permissions = fetchPagePermissions($result->id);
                        foreach ($permissions as $permission) {
                            $db->insert('permission_page_matches', ['page_id' => $last, 'permission_id' => $permission->permission_id]);
                            if (!$db->error()) {
                                logger($user->data()->id, 'securePage', 'Auto-Added Permission #'.$permission->permission_id." to $page.");
                            } else {
                                logger($user->data()->id, 'securePage', 'Failed ot add Permission ID#'.$permission->permission_id." to $page, Error: ".$db->errorString());
                            }
                        }
                        usSuccess("Page inserted and auto-mapped.");
                        Redirect::to($us_url_root.$page);
                    }
                }
                usError("Please confirm permission settings");
                Redirect::to($us_url_root.'users/admin.php?view=page&new=yes&id='.$last.'&dest='.$dest);
            } else {
                bold('<br><br>You must go into the Admin Panel and click the Manage Pages button to add this page to the database. Doing so will make this error go away.');
                die();
            }
        }
        $results = $query->first();

        $pageDetails = ['id' => $results->id, 'page' => $results->page, 'private' => $results->private];

        $pageID = $results->id;
        $ip = ipCheck();
        //If page does not exist in DB, allow access
        if (empty($pageDetails)) {
            return true;
        } elseif ($pageDetails['private'] == 0) {//If page is public, allow access
            return true;
        } elseif (!$user->isLoggedIn()) { //If user is not logged in, deny access
            $fields = [
                'user' => 0,
                'page' => $pageID,
                'ip' => $ip,
            ];
            $db->insert('audit', $fields);
            require_once $abs_us_root.$us_url_root.'usersc/scripts/not_logged_in.php';
            Redirect::to($us_url_root.'users/login.php?dest='.$page.'&redirect='.$dest);

            return false;
        } else {
            //Retrieve list of permission levels with access to page
            $pagePermissions = [];
            $permissions = $db->query('SELECT permission_id FROM permission_page_matches WHERE page_id = ?', [$pageID])->results();
            foreach($permissions as $p){
              $pagePermissions[] = $p->permission_id;
            }

            if($pagePermissions == []){
              //default to admin only
              $pagePermissions = [2];
            }

            //Check if user's permission levels allow access to page
            if (hasPerm($pagePermissions)) {
                return true;
            } elseif (in_array($user->data()->id, $master_account)) { //Grant access if master user
                return true;
            } else {
                if (!$homepage = Config::get('homepage')) {
                    $homepage = $us_url_root;
                }
                $fields = [
                    'user' => $user->data()->id,
                    'page' => $pageID,
                    'ip' => $ip,
                ];
                $db->insert('audit', $fields);
                require_once $abs_us_root.$us_url_root.'usersc/scripts/did_not_have_permission.php';
                if ($eventhooks = getMyHooks(['page' => 'noAccess'])) {
                    includeHook($eventhooks, 'body');
                }

                Redirect::to($homepage);

                return false;
            }
        }
    }
}

//Retrieve list of permission levels that can access a page
if (!function_exists('fetchPagePermissions')) {
    function fetchPagePermissions($page_id)
    {
        $db = DB::getInstance();
        $query = $db->query('SELECT id, permission_id FROM permission_page_matches WHERE page_id = ? ', [$page_id]);
        $results = $query->results();

        return $results;
    }
}

//Retrieve list of pages that a permission level can access
if (!function_exists('fetchPermissionPages')) {
    function fetchPermissionPages($permission_id)
    {
        $db = DB::getInstance();

        $query = $db->query(
        'SELECT m.id as id, m.page_id as page_id, p.page as page, p.private as private
		FROM permission_page_matches AS m
		INNER JOIN pages AS p ON m.page_id = p.id
		WHERE m.permission_id = ?', [$permission_id]);
        $results = $query->results();

        return $results;
    }
}

//Unmatched permission and page
if (!function_exists('removePage')) {
    function removePage($pages, $permissions)
    {
        $db = DB::getInstance();
        if (is_array($permissions)) {
            $ids = '';
            for ($i = 0; $i < count($permissions); ++$i) {
                $ids .= $permissions[$i].',';
            }
            $ids = rtrim($ids, ',');
            if ($query = $db->query("DELETE FROM permission_page_matches WHERE permission_id IN ({$ids}) AND page_id = ?", [$pages])) {
                return $query->count();
            }
        } elseif (is_array($pages)) {
            $ids = '';
            for ($i = 0; $i < count($pages); ++$i) {
                $ids .= $pages[$i].',';
            }
            $ids = rtrim($ids, ',');
            if ($query = $db->query("DELETE FROM permission_page_matches WHERE page_id IN ({$ids}) AND permission_id = ?", [$permissions])) {
                return $query->count();
            }
        }
    }
}

if (!function_exists('checkMenu')) {
    function checkMenu($permission, $id = 0)
    {
        $db = DB::getInstance();
        global $user;
        if ($id == 0 && $user->isLoggedIn()) {
            $id = $user->data()->id;
        }
        //Grant access if master user
        $access = 0;

        if ($access == 0) {
            $query = $db->query('SELECT id FROM user_permission_matches  WHERE user_id = ? AND permission_id = ?', [$id, $permission]);
            $results = $query->count();
            if ($results > 0) {
                $access = 1;
            }
        }
        if ($access == 1) {
            return true;
        }
        if ($user->isLoggedIn() && $user->data()->id == 1) {
            // return true;
        } else {
            return false;
        }
    }
}

//Retrieve information for all permission levels
if (!function_exists('fetchAllPermissions')) {
    function fetchAllPermissions()
    {
        $db = DB::getInstance();
        $query = $db->query('SELECT id, name FROM permissions');
        $results = $query->results();

        return $results;
    }
}


//Check if a permission level name exists in the DB
if (!function_exists('permissionNameExists')) {
    function permissionNameExists($permission)
    {
        $db = DB::getInstance();
        $query = $db->query('SELECT id FROM permissions WHERE
			name = ?', [$permission]);
        $results = $query->results();
        if ($results) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('addPermission')) {
    //Match permission level(s) with user(s)
    function addPermission($permission_ids, $members)
    {
        $db = DB::getInstance();
        $i = 0;
        if (is_array($permission_ids)) {
            foreach ($permission_ids as $permission_id) {
                if ($db->query('INSERT INTO user_permission_matches (user_id,permission_id) VALUES (?,?)', [$members, $permission_id])) {
                    ++$i;
                }
            }
        } elseif (is_array($members)) {
            foreach ($members as $member) {
                if ($db->query('INSERT INTO user_permission_matches (user_id,permission_id) VALUES (?,?)', [$member, $permission_ids])) {
                    ++$i;
                }
            }
        }

        return $i;
    }
}

if (!function_exists('deletePermission')) {
    //Delete a permission level from the DB
    function deletePermission($permission)
    {
        global $errors;
        $i = 0;
        $db = DB::getInstance();
        foreach ($permission as $id) {
            if ($id == 1) {
                $errors[] = lang('CANNOT_DELETE_NEWUSERS');
            } elseif ($id == 2) {
                $errors[] = lang('CANNOT_DELETE_ADMIN');
            } else {
                $query1 = $db->query('DELETE FROM permissions WHERE id = ?', [$id]);
                $query2 = $db->query('DELETE FROM user_permission_matches WHERE permission_id = ?', [$id]);
                $query3 = $db->query('DELETE FROM permission_page_matches WHERE permission_id = ?', [$id]);
                ++$i;
            }
        }

        return $i;
    }
}

if (!function_exists('hasPerm')) {
    function hasPerm($permissions, $id = null, $masterCheck = true)
    {
        global $user, $master_account;
        $access = false;

        if(!isset($user)) {
          return $access;
        }

        if (!is_array($permissions)) {
            $permissions = [$permissions];
        }

        if ($id === null && $user->isLoggedIn()) {
            $id = $user->data()->id;
        } elseif ($id === null && !$user->isLoggedIn()) {
            return $access;
        }

        $id = (int) $id;

        $db = DB::getInstance();
        $query = $db->query('SELECT * FROM user_permission_matches WHERE user_id = ?', [$id]);
        if (!$query->error()) {
            $userPerms = [];
            foreach ($query->results() as $row) {
                $userPerms[] = $row->permission_id;
            }
        } else {
            logger($id, 'hasPerm', 'Database error while checking permission', $query->errorString());

            return $access;
        }

        foreach ($permissions as $p) {
            if (in_array($p, $userPerms)) {
                $access = true;
                break;
            }
        }

        if (!$access && $masterCheck && in_array($id, $master_account)) {
            $access = true;
        }

        return $access;
    }
}

if (!function_exists('echopage')) {
    function echopage($id)
    {
        $db = DB::getInstance();
        $query = $db->query('SELECT page FROM pages WHERE id = ? LIMIT 1', [$id]);
        $count = $query->count();

        if ($count > 0) {
            $results = $query->first();
            echo $results->page;
        } else {
            echo 'Unknown';
        }
    }
}

if (!function_exists('isStandardUser')) {
    function isStandardUser($user_id)
    {
        $db = DB::getInstance();
        $q = $db->query('SELECT permission_id FROM user_permission_matches WHERE user_id = ? ORDER BY permission_id DESC', [$user_id]);
        $c = $q->count();
        if ($c != 1) {
            return false;
        } else {
            $f = $q->first();
            if ($f->permission_id != 1) {
                return false;
            } else {
                return true;
            }
        }
    }
}


//this is a dashboard-specific access control function
if(!function_exists('checkAccess')){
function checkAccess($key, $value)
{
    global $db, $user, $master_account;
    //Check if they belong to the master account array or have the Administrator (default 2) Perm
    if (in_array($user->data()->id, $master_account) || hasPerm([2], $user->data()->id)) {
        return true;
    } else {
        //They're not, now we're gonna check if the view exists in us_management and if they have perms
        $checkQ = $db->query("SELECT * FROM us_management WHERE $key = ?", [$value]);
        if (!$db->error()) {
            $checkC = $checkQ->count();
            if ($checkC < 1) {
                //The page isn't in the table, so we're gonna reject their ability to go
                return false;
            } else {
                //The page is in there, so now we're gonna check if they have permission
                $check = $checkQ->first();
                if (hasPerm(explode(',', $check->access), $user->data()->id)) {
                    //They have permissions listed in us_management, let them through
                    return true;
                } else {
                    //They don't have permissions, reject them
                    return false;
                }
            }
        } else {
            //It failed to retrieve anything from us_management, so we log the error and send them away
            logger($user->data()->id, 'checkAccess', 'Failed to check access for '.$value.', Error: '.$db->errorString());
            return false;
        }
    }
}
}
