<?php
/*
UserSpice 5
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

$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'MISSING';


function ipCheck() {
  $ip = $_SERVER['REMOTE_ADDR'];
  return $ip;
}

function ipCheckBan(){
  $db = DB::getInstance();
  $ip = ipCheck();
  $ban = $db->query("SELECT id FROM us_ip_blacklist WHERE ip = ?",array($ip))->count();
  if($ban > 0){
    $unban = $db->query("SELECT id FROM us_ip_whitelist WHERE ip = ?",array($ip))->count();
    if($unban==0){
      logger(0,'IP Logging','Blacklisted '.$ip.' attempted visit');
      return false;
    }else{
      return true;
    }
  }else{
    //  logger(0,'User','Blacklisted '.$ip.' attempted visit');
    return false;
  }
}

if(!function_exists('randomstring')) {
  function randomstring($len){
    $len = $len++;
    $string = "";
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for($i=0;$i<$len;$i++)
    $string.=substr($chars,rand(0,strlen($chars)),1);
    return $string;
  }
}

if(!function_exists('get_gravatar')) {
  function get_gravatar($email, $s = 120, $d = 'mm', $r = 'pg', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
      $url = '<img src="' . $url . '"';
      foreach ( $atts as $key => $val )
      $url .= ' ' . $key . '="' . $val . '"';
      $url .= ' />';
    }
    return $url;
  }
}


//Retrieve list of groups that can access a menu
if(!function_exists('fetchGroupsByMenu')) {
  function fetchGroupsByMenu($menu_id) {
    $db = DB::getInstance();
    $query = $db->query("SELECT id, group_id FROM groups_menus WHERE menu_id = ? ",array($menu_id));
    $results = $query->results();
    return($results);
  }
}

//Delete all authorized groups for the given menu(s) and then add from args
if(!function_exists('updateGroupsMenus')) {
  function updateGroupsMenus($group_ids, $menu_ids) {
    $db = DB::getInstance();
    $sql = "DELETE FROM groups_menus WHERE menu_id = ?";
    foreach((array)$menu_ids as $menu_id) {
      #echo "<pre>DEBUG: UGM: group_id=$group_id, menu_id=$menu_id</pre><br />\n";
      $db->query($sql,[$menu_id]);
    }
    return addGroupsMenus($group_ids, $menu_ids);
  }
}

//Add all groups/menus to the groups_menus mapping table
if(!function_exists('addGroupsMenus')) {
  function addGroupsMenus($group_ids, $menu_ids) {
    $db = DB::getInstance();
    $i = 0;
    $sql = "INSERT INTO groups_menus (group_id,menu_id) VALUES (?,?)";
    foreach((array)$group_ids as $group_id){
      foreach((array)$menu_ids as $menu_id){
        #echo "<pre>DEBUG: AGM: group_id=$group_id, menu_id=$menu_id</pre><br />\n";
        if($db->query($sql,[$group_id,$menu_id])) {
          $i++;
        }
      }
    }
    return $i;
  }
}



//Checks if a username exists in the DB
if(!function_exists('usernameExists')) {
  function usernameExists($username)   {
    $db = DB::getInstance();
    $query = $db->query("SELECT * FROM users WHERE username = ?",array($username));
    $results = $query->results();
    return ($results);
  }
}


//Retrieve a list of all .php files in root files folder
if(!function_exists('getPageFiles')) {
  function getPageFiles() {
    $directory = "../";
    $pages = glob($directory . "*.php");
    foreach ($pages as $page){
      $fixed = str_replace('../','/'.$us_url_root,$page);
      $row[$fixed] = $fixed;
    }
    return $row;
  }
}

//Retrive a list of all .php files in users/ folder
if(!function_exists('getUSPageFiles')) {
  function getUSPageFiles() {
    $directory = "../users/";
    $pages = glob($directory . "*.php");
    foreach ($pages as $page){
      $fixed = str_replace('../users/','/'.$us_url_root.'users/',$page);
      $row[$fixed] = $fixed;
    }
    return $row;
  }
}


        // retrieve ?dest=page and check that it exists in the legitimate pages in the
        // database or is in the Config::get('whitelisted_destinations')
        if(!function_exists('sanitizedDest')) {
          function sanitizedDest($varname='dest') {
            if ($dest = Input::get($varname)) {
              // if it exists in the database then it is a legitimate destination
              $db = DB::getInstance();
              $query = $db->query("SELECT id, page, private FROM pages WHERE page = ?",[$dest]);
              $count = $query->count();
              if ($count>0){
                return $dest;
              }
              // if the administrator has intentionally whitelisted a destination it is legitimate
              if ($whitelist = Config::get('whitelisted_destinations')) {
                if (in_array($dest, (array)$whitelist)) {
                  return $dest;
                }
              }
            }
            return false;
          }
        }


        //Displays error and success messages
        if(!function_exists('resultBlock')) {
          function resultBlock($errors,$successes){
            //Error block
            if(count($errors) > 0){
              echo "<div class='alert alert-danger alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
              <ul style='padding-left:1.25rem !important'>";
              foreach($errors as $error){
                echo "<li>".$error."</li>";
              }
              echo "</ul>";
              echo "</div>";
            }

            //Success block
            if(count($successes) > 0){
              echo "<div class='alert alert-success alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
              <ul style='padding-left:1.25rem !important'>";
              foreach($successes as $success){
                echo "<li>".$success."</li>";
              }
              echo "</ul>";
              echo "</div>";
            }
          }
        }

        //Inputs language strings from selected language.
        if(!function_exists('lang')) {
          function lang($key,$markers = NULL){
            global $lang, $us_url_root, $abs_us_root;
            if($markers == NULL){
              if(isset($lang[$key])){
                $str = $lang[$key];
              }else{
                $str = "";
              }
            }else{
              //Replace any dyamic markers
              if(isset($lang[$key])){
                $str = $lang[$key];
                $iteration = 1;
                foreach($markers as $marker){
                  $str = str_replace("%m".$iteration."%",$marker,$str);
                  $iteration++;
                }
              }else{
                $str = "";
              }
            }


            //Ensure we have something to return
            // dump($key);
            if($str == ""){
              if(isset($lang["MISSING_TEXT"])){
                $missing = $lang["MISSING_TEXT"];
              }else{
                $missing = "Missing Text";
              }
              //if nothing is found, let's check to see if the language is English.
              if(isset($lang['THIS_CODE']) && $lang['THIS_CODE'] != "en-US"){
                $save = $lang['THIS_CODE'];
                if($save == ''){
                  $save = 'en-US';
                }
                //if it is NOT English, we are going to try to grab the key from the English translation
                include($abs_us_root.$us_url_root."users/lang/en-US.php");
                if($markers == NULL){
                  if(isset($lang[$key])){
                    $str = $lang[$key];
                  }else{
                    $str = "";
                  }
                }else{
                  //Replace any dyamic markers
                  if(isset($lang[$key])){
                    $str = $lang[$key];
                    $iteration = 1;
                    foreach($markers as $marker){
                      $str = str_replace("%m".$iteration."%",$marker,$str);
                      $iteration++;
                    }
                  }else{
                    $str = "";
                  }
                }
                $lang = [];
                include($abs_us_root.$us_url_root."users/lang/$save.php");
                if($str == ""){
                  //This means that we went to the English file and STILL did not find the language key, so...
                  $str = "{ $missing }";
                  return $str;
                }else{
                  //falling back to English
                  return $str;
                }
              }else{
                //the language is already English but the code is not found so...
                $str = "{ $missing }";
                return $str;
              }
            }else{
              return $str;
            }
          }
        }

          if(!function_exists('isValidEmail')) {
            //Checks if an email is valid
            function isValidEmail($email){
              if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
              }
              else {
                return false;
              }
            }
          }

          if(!function_exists('emailExists')) {
            //Check if an email exists in the DB
            function emailExists($email) {
              $db = DB::getInstance();
              $query = $db->query("SELECT email FROM users WHERE email = ?",array($email));
              $num_returns = $query->count();
              if ($num_returns > 0){
                return true;
              }else{
                return false;
              }
            }
          }

          if(!function_exists('updateEmail')) {
            //Update a user's email
            function updateEmail($id, $email) {
              $db = DB::getInstance();
              $fields=array('email'=>$email);
              $db->update('users',$id,$fields);

              return true;
            }
          }

          if(!function_exists('echoId')) {
            function echoId($id,$table,$column){
              $db = DB::getInstance();
              $query = $db->query("SELECT $column FROM $table WHERE id = $id LIMIT 1");
              $count=$query->count();

              if ($count > 0) {
                $results=$query->first();
                foreach ($results as $result){
                  echo $result;
                }
              } else {
                echo "Not in database";
                Return false;
              }
            }
          }

          if(!function_exists('bin')) {
            function bin($number){
              if ($number == 0){
                echo "<strong><font color='red'>No</font></strong>";
              }
              if ($number == 1){
                echo "<strong><font color='green'>Yes</font></strong>";
              }
              if ($number != 0 && $number !=1){
                echo "<strong><font color='blue'>Other</font></strong>";
              }
            }
          }

          if(!function_exists('generateForm')) {
            function generateForm($table,$id, $skip=[]){
              $db = DB::getInstance();
              $fields = [];
              $q=$db->query("SELECT * FROM {$table} WHERE id = ?",array($id));
              $r=$q->first();

              foreach($r as $field => $value) {
                if(!in_array($field, $skip)){
                  echo '<div class="form-group">';
                  echo '<label for="'.$field.'">'.ucfirst($field).'</label>';
                  echo '<input type="text" class="form-control" name="'.$field.'" id="'.$field.'" value="'.$value.'">';
                  echo '</div>';
                }
              }
              return true;
            }
          }

          if(!function_exists('generateAddForm')) {
            function generateAddForm($table, $skip=[]){
              $db = DB::getInstance();
              $fields = [];
              $q=$db->query("SELECT * FROM {$table}");
              $r=$q->first();

              foreach($r as $field => $value) {
                if(!in_array($field, $skip)){
                  echo '<div class="form-group">';
                  echo '<label for="'.$field.'">'.ucfirst($field).'</label>';
                  echo '<input type="text" class="form-control" name="'.$field.'" id="'.$field.'" value="">';
                  echo '</div>';
                }
              }
              return true;
            }
          }

          if(!function_exists('updateFields2')) {
            function updateFields2($post, $skip=[]){
              $fields = [];
              foreach($post as $field => $value) {
                if(!in_array($field, $skip)){
                  $fields[$field] = sanitize($post[$field]);
                }
              }
              return $fields;
            }
          }


          if(!function_exists('mqtt')) {
            function mqtt($id,$topic,$message){
              //id is the server id in the mqtt_settings.php
              $db = DB::getInstance();
              $query = $db->query("SELECT * FROM mqtt WHERE id = ?",array($id));
              $count=$query->count();
              if($count > 0){
                $server = $query->first();

                $host = $server->server;
                $port = $server->port;
                $username = $server->username;
                $password = $server->password;

                $mqtt = new phpMQTT($host, $port, "ClientID".rand());

                if ($mqtt->connect(true,NULL,$username,$password)) {
                  $mqtt->publish($topic,$message, 0);
                  $mqtt->close();
                }else{
                  echo "Fail or time out";
                }
              }else{
                echo "Server not found. Please check your id.";
              }
            }
          }


          if(!function_exists('clean')) {
            //Cleaning function
            function clean($string) {
              $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
              $string = preg_replace('/[^A-Za-z0-9]/', '', $string); // Removes special chars.

              return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
            }
          }

          if(!function_exists('stripPagePermissions')) {
            function stripPagePermissions($id) {
              $db = DB::getInstance();
              $result = $db->query("DELETE from permission_page_matches WHERE page_id = ?",array($id));
              return $result;
            }
          }

          if(!function_exists('encodeURIComponent')) {
            function encodeURIComponent($str) {
              $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
              return strtr(rawurlencode($str), $revert);
            }
          }

          if(!function_exists('logger')) {
            function logger($user_id,$logtype,$lognote) {
              $db = DB::getInstance();

              $fields = array(
                'user_id' => $user_id,
                'logdate' => date("Y-m-d H:i:s"),
                'logtype' => $logtype,
                'lognote' => $lognote,
                'ip'			=> $_SERVER['REMOTE_ADDR'],
              );
              $db->insert('logs',$fields);
              $lastId = $db->lastId();
              return $lastId;
            }
          }

          if(!function_exists('echodatetime')) {
            function echodatetime($ts) {
              $ts_converted = strtotime($ts);
              $difference = ceil((time() - $ts_converted) / (60 * 60 * 24));
              // if($difference==0) { $last_update = "Today, "; $last_update .= date("g:i A",$convert); }
              if($difference >= 0 && $difference < 7) {
                $today = date("j");
                $ts_date = date("j",$ts_converted);
                if($today==$ts_date) { $date = "Today, "; $date .= date("g:i A",$ts_converted); }
                else {
                  $date = date("l g:i A",$ts_converted); } }
                  elseif($difference >= 7) { $date = date("M j, Y g:i A",$ts_converted); }
                  return $date;
                }
              }

              if(!function_exists('time2str')) {
                function time2str($ts)
                {
                  if(!ctype_digit($ts))
                  $ts = strtotime($ts);

                  $diff = time() - $ts;
                  if($diff == 0)
                  return 'now';
                  elseif($diff > 0)
                  {
                    $day_diff = floor($diff / 86400);
                    if($day_diff == 0)
                    {
                      if($diff < 60) return 'just now';
                      if($diff < 120) return '1 minute ago';
                      if($diff < 3600) return floor($diff / 60) . ' minutes ago';
                      if($diff < 7200) return '1 hour ago';
                      if($diff < 86400) return floor($diff / 3600) . ' hours ago';
                    }
                    if($day_diff == 1) return 'Yesterday';
                    if($day_diff < 7) return $day_diff . ' days ago';
                    if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
                    if($day_diff < 60) return 'last month';
                    return date('F Y', $ts);
                  }
                  else
                  {
                    $diff = abs($diff);
                    $day_diff = floor($diff / 86400);
                    if($day_diff == 0)
                    {
                      if($diff < 120) return 'in a minute';
                      if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
                      if($diff < 7200) return 'in an hour';
                      if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
                    }
                    if($day_diff == 1) {
                      if($day_diff < 4) {
                        return date('l', $ts);
                      } else {
                        return 'Tomorrow';
                      }
                    }
                    if($day_diff < 4) return date('l', $ts);
                    if($day_diff < 7 + (7 - date('w'))) return 'next week';
                    if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
                    if(date('n', $ts) == date('n') + 1) return 'next month';
                    return date('F Y', $ts);
                  }
                }
              }

              if(!function_exists('ipReason')) {
                function ipReason($reason){
                  if($reason == 0){
                    echo "Manually Entered";
                  }elseif($reason == 1){
                    echo "Invalid Attempts";
                  }else{
                    echo "Unknown";
                  }
                }
              }

              if(!function_exists('checkBan')) {
                function checkBan($ip){
                  $db = DB::getInstance();
                  $c = $db->query("SELECT id FROM us_ip_blacklist WHERE ip = ?",array($ip))->count();
                  if($c > 0){
                    return true;
                  }else{
                    return false;
                  }
                }
              }

              if(!function_exists('random_password')) {
                function random_password( $length = 16 ) {
                  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
                  $password = substr( str_shuffle( $chars ), 0, $length );
                  return $password;
                }
              }


              if(!function_exists('returnError')) {
                function returnError($errorMsg){
                  $responseAr = [];
                  $responseAr['success'] = true;
                  $responseAr['error'] = true;
                  $responseAr['errorMsg'] = $errorMsg;
                  die(json_encode($responseAr));
                }
              }

              if(!function_exists('userHasPermission')) {
                function userHasPermission($userID,$permissionID) {
                  $permissionsAr = fetchUserPermissions($userID);
                  //if($permissions[0])
                  foreach($permissionsAr as $perm)
                  {
                    if($perm->permission_id == $permissionID)
                    {
                      return TRUE;
                    }
                  }
                  return FALSE;
                }
              }

              if(!function_exists('requestCheck')) {
                function requestCheck($expectedAr)
                {
                  if(isset($_GET) && isset($_POST))
                  {
                    $requestAr = array_replace_recursive($_GET, $_POST);
                  }elseif(isset($_GET)){
                    $requestAr = $_GET;
                  }elseif(isset($_POST)){
                    $requestAr = $_POST;
                  }else{
                    $requestAr = array();
                  }
                  $diffAr = array_diff_key(array_flip($expectedAr),$requestAr);
                  if(count($diffAr) > 0)
                  {
                    returnError("Missing variables: ".implode(',',array_flip($diffAr)).".");
                  }else {
                    return $requestAr;
                  }
                }
              }

              if(!function_exists('adminNotifications')) {
                function adminNotifications($type,$threads,$user_id) {
                  $db = DB::getInstance();
                  $i = 0;
                  foreach($threads as $id){
                    if($type=="read") {
                      $db->query("UPDATE notifications SET is_read = 1 WHERE id = $id");
                      logger($user_id,"Notifications - Admin","Marked Notification ID #$id read.");
                    }
                    if($type=="unread") {
                      $db->query("UPDATE notifications SET is_read = 0,is_archived=0 WHERE id = $id");
                      logger($user_id,"Notifications - Admin","Marked Notification ID #$id unread.");
                    }
                    if($type=="delete") {
                      $db->query("UPDATE notifications SET is_archived = 1 WHERE id = $id");
                      logger($user_id,"Notifications - Admin","Deleted Notification ID #$id.");
                    }
                    $i++;
                  }
                  return $i;
                }
              }

              if(!function_exists('lognote')) {
                function lognote($logid) {
                  $db = DB::getInstance();
                  $logQ=$db->query("SELECT * FROM logs WHERE id=?",[$logid]);
                  if($logQ->count()>0) {
                    $log=$logQ->first();
                    if(1==2) return 'This is a placeholder';
                    /* elseif here for your custom hooks! */
                    else return $log->lognote;
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
                }
                else return false;
              }
            }

            if(!function_exists('isLocalhost')) {
              function isLocalhost() {
                if($_SERVER["REMOTE_ADDR"]=="127.0.0.1" || $_SERVER["REMOTE_ADDR"]=="::1" || $_SERVER["REMOTE_ADDR"]=="localhost"){
                  return true;
                }else{
                  return false;
                }
              }
            }

            if(!function_exists('currentPageStrict')) {
              function currentPageStrict() {
                global $abs_us_root, $us_url_root;
                $uri=$_SERVER['PHP_SELF'];


                $self_path=explode("/", $_SERVER['PHP_SELF']);
                $self_path_length=count($self_path);
                $file_found=FALSE;

                for($i = 1; $i < $self_path_length; $i++){
                  array_splice($self_path, $self_path_length-$i, $i);
                  // $us_url_root=implode("/",$self_path)."/";

                  if (file_exists($abs_us_root.$us_url_root.'z_us_root.php')){
                    $file_found=TRUE;
                    break;
                  }else{
                    $file_found=FALSE;
                  }
                }

                $urlRootLength=strlen($us_url_root);
                $page=substr($uri,$urlRootLength,strlen($uri)-$urlRootLength);
                return $page;
              }
            }

            if(!function_exists('UserSessionCount')) {
              function UserSessionCount() {
                global $user;
                $db=DB::getInstance();
                $q=$db->query("SELECT * FROM us_user_sessions WHERE fkUserID = ? AND UserSessionEnded=0",[$user->data()->id]);
                return $q->count();
              }
            }

            if(!function_exists('fetchUserSessions')) {
              function fetchUserSessions($all=false) {
                global $user;
                $db = DB::getInstance();
                if(!$all) $q = $db->query("SELECT * FROM us_user_sessions WHERE fkUserID = ? AND UserSessionEnded=0 ORDER BY UserSessionStarted",[$user->data()->id]);
                else $q = $db->query("SELECT * FROM us_user_sessions WHERE fkUserID = ? ORDER BY UserSessionStarted",[$user->data()->id]);
                if($q->count()>0) return $q->results();
                else return false;
              }
            }

            if(!function_exists('fetchAdminSessions')) {
              function fetchAdminSessions($all=false) {
                global $user;
                $db = DB::getInstance();
                if(!$all) $q = $db->query("SELECT * FROM us_user_sessions WHERE UserSessionEnded=0 ORDER BY UserSessionStarted");
                else $q = $db->query("SELECT * FROM us_user_sessions ORDER BY UserSessionStarted");
                if($q->count()>0) return $q->results();
                else return false;
              }
            }

            if(!function_exists('killSessions')) {
              function killSessions($sessions,$admin=false) {
                global $user;
                $db = DB::getInstance();
                $i=0;
                foreach($sessions as $session) {
                  if(is_numeric($session)) {
                    if(!$admin) $db->query("UPDATE us_user_sessions SET UserSessionEnded=1,UserSessionEnded_Time=NOW() WHERE kUserSessionID = ? AND fkUserId = ?",[$session,$user->data()->id]);
                    else $db->query("UPDATE us_user_sessions SET UserSessionEnded=1,UserSessionEnded_Time=NOW() WHERE kUserSessionID = ?",[$session]);
                    if(!$db->error()) {
                      $i++;
                      logger($user->data()->id,"User Tracker","Killed Session ID#$session");
                    } else {
                      $error=$db->errorString();
                      logger($user->data()->id,"User Tracker","Error killing Session ID#$session: $error");
                    }
                  }
                }
                if($i>0) return $i;
                else return false;
              }
            }

            if(!function_exists('passwordResetKillSessions')) {
              function passwordResetKillSessions($uid=NULL) {
                global $user;
                $db = DB::getInstance();
                if(is_null($uid)) $q = $db->query("UPDATE us_user_sessions SET UserSessionEnded=1,UserSessionEnded_Time=NOW() WHERE fkUserID = ? AND UserSessionEnded=0 AND kUserSessionID <> ?",[$user->data()->id,$_SESSION['kUserSessionID']]);
                else $q = $db->query("UPDATE us_user_sessions SET UserSessionEnded=1,UserSessionEnded_Time=NOW() WHERE fkUserID = ? AND UserSessionEnded=0",[$uid]);
                if(!$db->error()) {
                  $count=$db->count();
                  if(is_null($uid)) {
                    if($count==1) logger($user->data()->id,"User Tracker","Killed 1 Session via Password Reset.");
                    if($count >1) logger($user->data()->id,"User Tracker","Killed $count Sessions via Password Reset.");
                  } else {
                    if($count==1) logger($user->data()->id,"User Tracker","Killed 1 Session via Password Reset for UID $uid.");
                    if($count >1) logger($user->data()->id,"User Tracker","Killed $count Sessions via Password Reset for UID $uid.");
                  }
                  return $count;
                } else {
                  $error=$db->errorString();
                  if(is_null($uid)) {
                    logger($user->data()->id,"User Tracker","Password Reset Session Kill failed, Error: ".$error);
                  } else {
                    logger($user->data()->id,"User Tracker","Password Reset Session Kill failed for UID $uid, Error: ".$error);
                  }
                  return $error;
                }
              }
            }

            if(!function_exists('username_helper')) {
              function username_helper($fname,$lname,$email) {
                $db = DB::getInstance();
                $settings=$db->query("SELECT * FROM settings")->first();
                $preusername = $fname[0];
                $preusername .= $lname;
                $preusername=strtolower(clean($preusername));
                $preQ = $db->query("SELECT username FROM users WHERE username = ?",array($preusername));
                if(!$db->error()) {
                  $preQCount=$preQ->count();
                } else {
                  return false;
                }
                if($preQCount == 0) {
                  return $preusername;
                }
                $preusername = $fname;
                $preusername .= $lname[0];
                $preusername=strtolower(clean($preusername));
                $preQ = $db->query("SELECT username FROM users WHERE username = ?",array($preusername));
                if(!$db->error()) {
                  $preQCount=$preQ->count();
                } else {
                  return false;
                }
                if($preQCount == 0) {
                  return $preusername;
                }
                return $email;
              }
            }

            if(!function_exists('oxfordList')){
              function oxfordList($data,$opts=[]){
                $msg = '';
                if(is_array($data)){
                  if($opts == []){
                    echo implode(", ", $data);
                  }else{
                    $final = $opts['final'];
                    $c= count($data);
                    for($i = 0; $i<=$c; $i++){
                      if(isset($data[$i])){
                        if($i == $c-1){
                          $msg .= " ".$final." ";
                        }

                        $msg .= $data[$i];
                        if($i < $c-1){
                          $msg .= ",";
                        }

                      }
                    }
                  }
                }
                return $msg;
              }
            }

            if(!function_exists('currentFile')) {
              function currentFile() {
                global $abs_us_root, $us_url_root;

                $self_path=explode("/", $_SERVER['PHP_SELF']);
                $self_path_length=count($self_path);
                $file_found=FALSE;

                for($i = 1; $i < $self_path_length; $i++){
                  array_splice($self_path, $self_path_length-$i, $i);

                  if (file_exists($abs_us_root.$us_url_root.'z_us_root.php')){
                    $file_found=TRUE;
                    break;
                  }else{
                    $file_found=FALSE;
                  }
                }

                $urlRootLength=strlen($us_url_root);
                return substr($_SERVER['PHP_SELF'],$urlRootLength,strlen($_SERVER['PHP_SELF'])-$urlRootLength);
              }
            }

            if(!function_exists('importSQL')) {
              function importSQL($file) {
                global $db;
                $lines = file($file);
                // Loop through each line
                foreach ($lines as $line)
                {
                  // Skip it if it's a comment
                  if (substr($line, 0, 2) == '--' || $line == '')
                  continue;

                  // Add this line to the current segment
                  $templine .= $line;
                  // If it has a semicolon at the end, it's the end of the query
                  if (substr(trim($line), -1, 1) == ';')
                  {
                    // Perform the query
                    $db->query($templine);
                    // Reset temp variable to empty
                    $templine = '';
                  }
                }
              }
            }

            if(!function_exists('pluginActive')) {
              function pluginActive($plugin,$checkOnly = false) {
                global $db,$user,$us_url_root;
                $check = $db->query("SELECT id FROM us_plugins WHERE plugin = ? and status = ?",array($plugin,"active"))->count();
                if($check != 1) {
                  logger($user->data()->id,"Errors","Attempted to access disabled $plugin");
                  if(!$checkOnly){
                    Redirect::to($us_url_root.'users/admin.php?view=plugins&err=Plugin+is+disabled');
                  }
                  return false;
                }else{
                  return true;
                }
              }
            }


            if(!function_exists('languageSwitcher')) {
              function languageSwitcher() {
                $db = DB::getInstance();
                global $user,$abs_us_root,$us_url_root,$currentPage,$settings,$token;
                if($settings->allow_language != 1){
                  return false;
                }
                $your_token = $_SERVER['REMOTE_ADDR'];
                if(!empty($_POST['language_selector'])){

                  $the_token = Input::get("your_token");
                  if($your_token != $the_token){
                    err("Language change failed");
                    return false;
                  }else{
                    $count = 0;
                    $set = '';
                    foreach($_POST as $k=>$v){
                      $count++;

                      if($count != 3){
                        continue;
                      }else{
                        $set = substr($k, 0, -2);
                      }
                    }
                    if(strlen($set) != 5 || (substr($set,2,1) != '-')){
                      //something is fishy with this language key
                      err("Language change failed");
                      return false;
                    }
                    $_SESSION['us_lang']=$set;
                    if(isset($user) && $user->isLoggedIn()){
                      $db->update('users',$user->data()->id,['language'=>$set]);
                    }
                    header("Refresh:0");
                  }

                }
                $_SESSION['your_token']=$your_token;
                $languages = scandir($abs_us_root.$us_url_root."users/lang");?>

                <form class="" action="" method="post">
                  <p align="center">
                    <input type="hidden" name="your_token" value="<?=$your_token?>">

                    <input type="hidden" name="language_selector" value="1">
                    <?php
                    foreach($languages as $k=>$v){
                      $languages[$k] = substr($v,0,-4);
                      if(file_exists($abs_us_root.$us_url_root."users/lang/flags/".$languages[$k].".png")){?>
                        <input type="image" title="<?=$languages[$k]?>" alt="<?=$languages[$k]?>" name="<?=$languages[$k]?>" src="<?=$us_url_root."users/lang/flags/".$languages[$k].".png"?>" border="0" alt="Submit" style="width: 40px;" />
                      <?php }
                    } ?>
                  </p>
                  <input type="hidden" name="csrf" value="<?=$token?>">
                </form>
                <?php
              }
            }

            if(!function_exists('getMyHooks')) {
              function getMyHooks($opts = []) {
                global $db, $currentPage;

                if($opts == []){
                  $hooks = $db->query("SELECT * FROM us_plugin_hooks WHERE page = ? AND disabled = 0",[$currentPage])->results();
                }elseif(isset($opts['page']) && $opts['page'] != ''){
                  $hooks = $db->query("SELECT * FROM us_plugin_hooks WHERE page = ? AND disabled = 0",[$opts['page']])->results();
                }
                $data = [];
                $data['pre'] = [];
                $data['post'] = [];
                $data['form'] = [];
                $data['body'] = [];
                $data['bottom'] = [];
                $counter = 0;
                foreach($hooks as $h){
                  if($h->position == "pre"){
                    $data['pre'][$counter] = $h->folder.'/'.$h->hook;
                  }elseif($h->position == "post"){
                    $data['post'][$counter] = $h->folder.'/'.$h->hook;
                  }elseif($h->position == "form"){
                    $data['form'][$counter] = $h->folder.'/'.$h->hook;
                  }elseif($h->position == "body"){
                    $data['body'][$counter] = $h->folder.'/'.$h->hook;
                  }elseif($h->position == "bottom"){
                    $data['bottom'][$counter] = $h->folder.'/'.$h->hook;
                  }
                  $counter++;
                }
                return $data;
              }
            }

            if(!function_exists('includeHook')) {
              function includeHook($hooks,$position) {
                global $db, $abs_us_root, $us_url_root, $usplugins;
                foreach($hooks[$position] as $h)
                if(isset($h) && file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$h) && $h != ''){
                  $plugin = strstr($h, '/', 'before_needle');
                  if($usplugins[$plugin] == 1){//only include this file if plugin is installed and active.
                    include $abs_us_root.$us_url_root.'usersc/plugins/'.$h;
                  }
                }else{
                  //automatically disable hook ...eventually
                }
              }
            }



            if(!function_exists('registerHooks')) {
              function registerHooks($hooks,$plugin_name) {
                global $db;
                foreach($hooks as $k=>$v){
                  foreach($v as $key=>$value){
                    $fields = array(
                      'page'=>$k,
                      'folder'=>$plugin_name,
                      'position'=>$key,
                      'hook'=>$value,
                    );
                    $db->insert('us_plugin_hooks',$fields);
                  }
                }
              }
            }

            if(!function_exists('deRegisterHooks')) {
              function deRegisterHooks($plugin_name) {
                global $db;
                $hooks = $db->query("DELETE FROM us_plugin_hooks WHERE folder = ?",[$plugin_name]);
              }
            }


            if(!function_exists('shakerIsInstalled')) {
              function shakerIsInstalled($type,$reserved) {
                global $abs_us_root, $us_url_root;
                if($type == 'translation'){
                  return true;
                }elseif($type == 'plugin' || $type == 'widget' || $type == 'template'){
                  $type = $type."s";
                  if(file_exists($abs_us_root.$us_url_root.'usersc/'.$type.'/'.$reserved)){
                    return true;
                  }else{
                    return false;
                  }
                }else{
                  return false;
                }
              }
            }

            if(!function_exists('updateReAuth')) {
            	function updateReAuth($id, $re_auth) {
            		$db = DB::getInstance();
            		$result = $db->query("UPDATE pages SET re_auth = ? WHERE id = ?",array($re_auth,$id));
            		return $result;
            	}
            }

            if(!function_exists('reAuth')) {
            	function reAuth(){
            		$abs_us_root=$_SERVER['DOCUMENT_ROOT'];
            		$self_path=explode("/", $_SERVER['PHP_SELF']);
            		$self_path_length=count($self_path);
            		$file_found=FALSE;

            		for($i = 1; $i < $self_path_length; $i++){
            			array_splice($self_path, $self_path_length-$i, $i);
            			$us_url_root=implode("/",$self_path)."/";

            			if (file_exists($abs_us_root.$us_url_root.'z_us_root.php')){
            				$file_found=TRUE;
            				break;
            			}else{
            				$file_found=FALSE;
            			}
            		}

            		$urlRootLength=strlen($us_url_root);
            		$page=substr($_SERVER['PHP_SELF'],$urlRootLength,strlen($_SERVER['PHP_SELF'])-$urlRootLength);
            		$db = DB::getInstance();
            		$id = null;
            		$query = $db->query("SELECT id, page, re_auth FROM pages WHERE page = ?",[$page]);
            		$count = $query->count();
            		if ($count > 0){
            			$results = $query->first();
            			$pageDetails = array( 'id' =>$results->id, 'page' => $results->page, 're_auth' => $results->re_auth);
            			$pageID = $results->id;
            			if($_SERVER["REMOTE_ADDR"]=="127.0.0.1" || $_SERVER["REMOTE_ADDR"]=="::1" || $_SERVER["REMOTE_ADDR"]=="localhost"){
            				$local = True;
            			}else{
            				$local = False;
            			}
            			if (empty($pageDetails)){
            				return true;
            			}elseif ($pageDetails['re_auth'] == 0){//If page is public, allow access
            				return true;
            			} elseif ($page=='users/admin_verify.php' || $page=='usersc/admin_verify.php') {
            				return true;
            			} elseif ($page=='users/admin_pin.php' || $page=='usersc/admin_pin.php') {
            				return true;
            				} elseif ($local) {
            					return true;
            			} else{ //Authorization is required.  Insert your authorization code below.
            				if(!isset($_SESSION['cloak_to'])) verifyadmin($page);
            			}
            		}
            	}
            }

            if(!function_exists('verifyadmin')) {
            	function verifyadmin($page) {
            		global $user;
            		global $us_url_root;
            		$actual_link = encodeURIComponent("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
            		$db = DB::getInstance();
            		$settings=$db->query("SELECT * FROM settings WHERE id=1")->first();
            		$null=$settings->admin_verify_timeout-1;
            		if(isset($_SESSION['last_confirm']) && $_SESSION['last_confirm']!='' && !is_null($_SESSION['last_confirm'])) $last_confirm=$_SESSION['last_confirm'];
            		else $last_confirm=date("Y-m-d H:i:s",strtotime('-'.$null.' day',strtotime(date("Y-m-d H:i:s"))));
            		$current=date("Y-m-d H:i:s");
            		$ctFormatted = date("Y-m-d H:i:s", strtotime($current));
            		$dbPlus = date("Y-m-d H:i:s", strtotime('+'.$settings->admin_verify_timeout.' minutes', strtotime($last_confirm)));
            		if (strtotime($ctFormatted) > strtotime($dbPlus)){
            			$q = $db->query("SELECT pin FROM users WHERE id = ?",[$user->data()->id]);
            			if(is_null($q->first()->pin)) Redirect::to($us_url_root.'users/admin_pin.php?actual_link='.$actual_link.'&page='.$page);
            			else Redirect::to($us_url_root.'users/admin_verify.php?actual_link='.$actual_link.'&page='.$page);
            		}
            		else
            		{
            			$db = DB::getInstance();
            			$_SESSION['last_confirm']=$current;
            		}
            	}
            }
