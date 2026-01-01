<?php
$countE = $count = 0;
if(!file_exists($abs_us_root.$us_url_root.'usersc/includes/user_manager_columns.php')){
    $defaultContent = '<?php
/**
 * User Manager Columns Configuration
 *
 * This file allows you to customize the columns and query used in the admin users table.
 * You can add, remove, or modify columns as needed for your application.
 * Most of the time, you just want to show something extra from the users table, so you can
 * do that by adding to the $user_manager_columns array and updating the switch statement if
 * you want to do something special
 */

// Define the column headers for the table
$user_manager_columns = [
    \'id\' => \'ID\',
    \'force_pr\' => \'\', // Lock icon column
    \'username\' => \'Username\',
    \'name\' => \'Name\',
    \'email\' => \'Email\',
    \'last_login\' => \'Last Sign In\',
    \'perms\' => \'Permissions\',
    \'status\' => \'Status\',
];

// Define column data handlers
// This function takes a user object and column name and returns the HTML for that cell
// Only define special cases here - standard columns will be handled by the default case
$user_manager_column_data = function($user, $column) use ($act, $uCount, $maxUsers) {
    switch($column) {
        case \'id\':
            return \'<span class="hideMe">\' . sprintf(\'%08d\', $user->id) . \'</span>
                <a class="nounderline text-dark" href="admin.php?view=user&id=\' . $user->id . \'">\' . $user->id . \'</a>\';

        case \'force_pr\':
            if ($user->force_pr == 1) {
                return \'<a class="nounderline text-danger" href="admin.php?view=user&id=\' . $user->id . \'"><i class="fa fa-lock"></i></a>\';
            }
            return \'\';

        case \'name\':
            return \'<a class="nounderline text-dark" href="admin.php?view=user&id=\' . $user->id . \'">\' . $user->fname . \' \' . $user->lname . \'</a>\';

        case \'last_login\':
            if ($user->last_login != "0000-00-00 00:00:00") {
                return $user->last_login;
            } else {
                return \'<i>Never</i>\';
            }

        case \'perms\':
            if ($uCount < $maxUsers) {
                return $user->perms;
            }
            return null; // Don\'t show this column

        case \'status\':
            $html = \'\';
            if($user->permissions == 0) {
                $html .= \'<i class="fa fa-fw fa-lock text-danger" data-bs-toggle="tooltip" title="The users\\\'s account locked (banned)"></i>\';
            } else {
                $html .= \'<i class="fa fa-fw fa-unlock" data-bs-toggle="tooltip" title="The users\\\'s account unlocked (active)"></i>\';
            }

            if ($act == 1 && $user->email_verified == 1) {
                $html .= \' <i class="fa fa-envelope" data-bs-toggle="tooltip" title="User email is verified"></i>\';
            }
            return $html;

        default:
            // For standard columns, just return the value if it exists, otherwise blank
            return isset($user->$column) ? $user->$column : \'\';
    }
};

// Define the query function based on the search mode
$user_manager_get_data = function($settings, $db, $uCount, $maxUsers) {
    if($settings->uman_search == 0) {
        $showAllUsers = Input::get(\'showAllUsers\');

        if ($showAllUsers == 1) {
            if ($uCount < $maxUsers) {
                $userData = $db->query("SELECT
                    u.*,
                    group_concat(p.name SEPARATOR \', \') AS perms
                    FROM users AS u
                    JOIN user_permission_matches AS upm ON u.id = upm.user_id
                    LEFT OUTER JOIN permissions AS p ON p.id = upm.permission_id
                    GROUP BY u.id
                ")->results();
            } else {
                $userData = fetchAllUsers(\'permissions DESC,id\', false, true);
            }
        } else {
            if ($uCount < $maxUsers) {
                $userData = $db->query("SELECT
                    u.*,
                    group_concat(p.name SEPARATOR \', \') AS perms
                    FROM users AS u
                    JOIN user_permission_matches AS upm ON u.id = upm.user_id
                    LEFT OUTER JOIN permissions AS p ON p.id = upm.permission_id
                    WHERE u.active = 1
                    GROUP BY u.id
                ")->results();
            } else {
                $userData = fetchAllUsers(\'permissions DESC,id\', false, false);
            }
        }
    } else {
        // Search using the search form
        if(!empty($_POST[\'search\'])) {
            $search = Input::get(\'searchTerm\');
            $userData = $db->query("SELECT
                u.*,
                group_concat(p.name SEPARATOR \', \') AS perms
                FROM users AS u
                JOIN user_permission_matches AS upm ON u.id = upm.user_id
                LEFT OUTER JOIN permissions AS p ON p.id = upm.permission_id
                WHERE fname LIKE ? OR lname LIKE ? OR username LIKE ? OR email LIKE ?
                GROUP BY u.id
            ", ["%$search%", "%$search%", "%$search%", "%$search%"])->results();
        } else {
            $userData = new stdClass();
        }
    }

    return $userData;
};

/**
 * CUSTOMIZATION EXAMPLES:
 *
 * 1. To add a simple column from the users table (e.g., phone):
 *
 * $user_manager_columns[\'phone\'] = \'Phone Number\';
 *
 * That\'s it! The default case will automatically display $user->phone if it exists.
 *
 *
 * 2. To add a column with custom formatting:
 *
 * $user_manager_columns[\'created_date\'] = \'Member Since\';
 *
 * Then in the switch statement in $user_manager_column_data, add:
 *
 * case \'created_date\':
 *     return date(\'M j, Y\', strtotime($user->join_date));
 *
 *
 * 3. To remove a column:
 *
 * Just remove it from the $user_manager_columns array.
 *
 *
 * 4. To modify the query to include additional data from other tables:
 *
 * Modify the SELECT statements in $user_manager_get_data to include your fields.
 * For example, to join with a profile table:
 *
 * SELECT u.*, up.bio, group_concat(p.name SEPARATOR \', \') AS perms
 * FROM users AS u
 * LEFT JOIN user_profiles AS up ON u.id = up.user_id
 * JOIN user_permission_matches AS upm ON u.id = upm.user_id
 * ...
 *
 * Then add to the columns array:
 * $user_manager_columns[\'bio\'] = \'Biography\';
 */
';

    $filePath = $abs_us_root.$us_url_root.'usersc/includes/user_manager_columns.php';
    file_put_contents($filePath, $defaultContent);
    chmod($filePath, 0755);
    $count++;
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
