<?php
 //these are old UserCake and UserSpice functions that are not used  in our system by default
//However, if you found some use for them and your code stopped working, please copy the function(s)
//that you are missing into usersc/custom_functions.php and you'll be back to normal.

//lol
function output_message($message) {
return $message;
}

//Does user have permission
//This is the old school UserSpice Permission System
if (!function_exists('checkPermission')) {
    function checkPermission($permission)
    {
        $db = DB::getInstance();
        global $user;
        //Grant access if master user
        $access = 0;

        foreach ($permission[0] as $perm) {
            if ($access == 0) {
                $query = $db->query('SELECT id FROM user_permission_matches  WHERE user_id = ? AND permission_id = ?', [$user->data()->id, $perm->permission_id]);
                $results = $query->count();
                if ($results > 0) {
                    $access = 1;
                }
            }
        }
        if ($access == 1) {
            return true;
        }
        if ($user->data()->id == 1) {
            return true;
        } else {
            return false;
        }
    }
}

function inputBlock($type,$label,$id,$divAttr=array(),$inputAttr=array(),$helper=''){
	$divAttrStr = '';
	foreach($divAttr as $k => $v){
		$divAttrStr .= ' '.$k.'="'.$v.'"';
	}
	$inputAttrStr = '';
	foreach($inputAttr as $k => $v){
		$inputAttrStr .= ' '.$k.'="'.$v.'"';
	}
	$html = '<div'.$divAttrStr.'>';
	$html .= '<label for="'.$id.'">'.$label.'</label>';
	if($helper != ''){
		$html .= '<button class="help-trigger"><span class="fa fa-question"></span></button>';
	}
	$html .= '<input type="'.$type.'" id="'.$id.'" name="'.$id.'"'.$inputAttrStr.'>';
  if($helper != ''){
		$html .= '<div class="helper-text">'.$helper.'</div>';
	}
	$html .= '</div>';
    return $html;
}

//returns the id of the current page
function currentPageId($uri) {
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
  $path=substr($uri,$urlRootLength,strlen($uri)-$urlRootLength);
    $db = DB::getInstance();
    $query = $db->query("SELECT id FROM pages WHERE page = ?",array($path));
    $count = $query->count();
    if($count>0){
        $result = $query->first();
        return $result->id;    //Return the id of the page we're on
    } else {
        return 0; //Fail nicely
    }
}

//Retrive a list of all .php files in users/ folder
if(!function_exists('getUSPageFiles')) {
	function getUSPageFiles() {
		global $us_url_root;
		$directory = "../users/";
		$pages = glob($directory . "*.php");
		foreach ($pages as $page){
			$fixed = str_replace('../users/','/'.$us_url_root.'users/',$page);
			$row[$fixed] = $fixed;
		}
		return $row;
	}
}

//Retrieve a list of all .php files in root files folder
if(!function_exists('getPageFiles')) {
	function getPageFiles() {
		global $us_url_root;
		$directory = "../";
		$pages = glob($directory . "*.php");
		foreach ($pages as $page){
			$fixed = str_replace('../','/'.$us_url_root,$page);
			$row[$fixed] = $fixed;
		}
		return $row;
	}
}


//Check if a permission level name exists in the DB
if(!function_exists('permissionNameExists')) {
	function permissionNameExists($permission) {
		$db = DB::getInstance();
		$query = $db->query("SELECT id FROM permissions WHERE
			name = ?",array($permission));
		$results = $query->results();
		if($results) return true;
		else return false;
	}
}

if(!function_exists('stripPagePermissions')) {
	function stripPagePermissions($id) {
		$db = DB::getInstance();
		$result = $db->query("DELETE from permission_page_matches WHERE page_id = ?",array($id));
		return $result;
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

//Checks if a username exists in the DB
if(!function_exists('usernameExists')) {
	function usernameExists($username)   {
		$db = DB::getInstance();
		$query = $db->query("SELECT * FROM users WHERE username = ?",array($username));
		$results = $query->results();
		return ($results);
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

if (!function_exists('format_date')) {
  function format_date($date, $tz)
  {
    //return date("m/d/Y ~ h:iA", strtotime($date));
    $format = 'Y-m-d H:i:s';
    $dt = DateTime::createFromFormat($format, $date);
    // $dt->setTimezone(new DateTimeZone($tz));
    return $dt->format('m/d/y ~ h:iA');
  }
}

if (!function_exists('abbrev_date')) {
  function abrev_date($date, $tz)
  {
    $format = 'Y-m-d H:i:s';
    $dt = DateTime::createFromFormat($format, $date);
    // $dt->setTimezone(new DateTimeZone($tz));
    return $dt->format('M d,Y');
  }
}

// ----------- former audit.php files
// Get user IP
	if(!function_exists("getIP")){
	function getIP() {
	/*
	This function will try to find out if user is coming behind proxy server. Why is this important?
	If you have high traffic web site, it might happen that you receive lot of traffic
	from the same proxy server (like AOL). In that case, the script would count them all as 1 user.
	This function tryes to get real IP address.
	Note that getenv() function doesn't work when PHP is running as ISAPI module
	*/
		if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP');
		}
		elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_X_FORWARDED')) {
			$ip = getenv('HTTP_X_FORWARDED');
		}
		elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip = getenv('HTTP_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_FORWARDED')) {
			$ip = getenv('HTTP_FORWARDED');
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}

// Pie Chart for Page Permission Counts
if(!function_exists("fetchUserjsonPIE")){
function fetchUserjsonPIE()
	{
	// Example query
	$db = DB::getInstance();
	$stmt = $db->query("SELECT * AS ?,?
	FROM permission_page_matches LEFT JOIN permissions ON permission_id = permissions.id  GROUP BY permission_id",[sum1,name]);
	$results = $stmt->results();
	$count = $stmt->count();
	return $results;
	return $count;
	}
}

// Bar Chart for Login Counts
if(!function_exists("fetchUserjsonLG2")){
function fetchUserjsonLG2()
	{
	// Example query
	$db = DB::getInstance();
	$stmt = $db->query("SELECT * FROM audit WHERE audit_eventcode = 1 GROUP BY MINUTE(FROM_UNIXTIME(audit_timestamp)) ORDER BY audit_timestamp DESC LIMIT 100");
	$count = $stmt->count();
	$results = $stmt->results();
	return $count;
	return $results;
	}
}

// Bar Chart for Signup Counts
if(!function_exists("fetchUserjsonLG")){
function fetchUserjsonLG()
	{
	// Example query
	$db = DB::getInstance();
	$stmt = $db->query("SELECT COUNT(*) AS sum1,sign_up_stamp	FROM users GROUP BY DAY(FROM_UNIXTIME(sign_up_stamp))ORDER BY sign_up_stamp DESC");
	$stmt->execute();
	$stmt->bind_result($sum1, $name);
	while ($stmt->fetch())
		{
		$row[] = array('sum1' => $sum1, 'sign_up_stamp' => $name);
		}
	$stmt->close();
	return ($row);
	}
}


// complex query gets audit
	if(!function_exists("fetchAllLatest")){
	function fetchAllLatest($userid,$start,$end,$eventcode)
		{
		$db = DB::getInstance();
		$stmt = $db->query("SELECT
									id,
									username,
									audit_id,
									audit_userid,
									audit_userip,
									audit_othus,
									audit_eventcode,
									audit_action,
									audit_itemid,
									audit_timestamp
			FROM audit LEFT JOIN users ON audit_userid = id
									WHERE
									audit_userid != ?
									AND audit_timestamp >= ?
									AND audit_timestamp <= ?
									AND audit_eventcode = ?
									ORDER BY audit_id DESC
			",[$userid,$start,$end,$eventcode]);
			$results = $stmt->results();
			$num_returns = $stmt->count();
			return $results;
			return $num_returns;
		}
	}

// simplest count function
if(!function_exists("countStuff")){
function countStuff($what)
	{
	$db = DB::getInstance();
	$stmt = $db->query("SELECT * FROM ?",[$what]);
	$result = $stmt->results();
	$num_returns = $stmt->count();
	return $result;
	return $num_returns;
	}
}

// greedy count function with a modifier
if(!function_exists("countLoginsSince")){
function countLoginsSince($eventcode,$since) {
	$db = DB::getInstance();
	$stmt = $db->query("SELECT * FROM audit WHERE audit_eventcode = ? AND audit_timestamp > ?",[$eventcode,$since]);
	$num_returns = $stmt->count();
	return $num_returns;
	}
}

// handy ago() function for UserSpice timestamps
if(!function_exists("ago")){
function ago($time) {
    $timediff=time()-$time;
    $days=intval($timediff/86400);
    $remain=$timediff%86400;
    $hours=intval($remain/3600);
    $remain=$remain%3600;
    $mins=intval($remain/60);
    $secs=$remain%60;

    if ($secs>=0) $timestring = $secs."s";//"0m".
    if ($mins>0) $timestring = $mins."m";//.$secs."s";
    if ($hours>0) $timestring = $hours."h";//.$mins."m";
    if ($days>0) $timestring = $days."d";//.$hours."h";

    return $timestring;
}
}

//Retrieve information for admin audit
if(!function_exists("fetchAllAudit")){
	function fetchAllAudit()
		{
		$db = DB::getInstance();
		$stmt = $db->query("SELECT
				id,
				username,
				audit_id,
				audit_userid,
				audit_userip,
				audit_othus,
				audit_eventcode,
				audit_action,
				audit_itemid,
				audit_timestamp
			FROM audit LEFT JOIN users ON audit_userid = id ORDER BY audit_id DESC");
			$results = $stmt->results();
			$count = $stmt->count();
			return $results;
			return $count;
		}
	}

		//Retrieve information for user audit
	if(!function_exists("fetchUserAudit")){
	function fetchUserAudit($userid)
		{
		$db = DB::getInstance();
		$stmt = $db->query("SELECT
				id,
				username,
				audit_id,
				audit_userid,
				audit_userip,
				audit_othus,
				audit_eventcode,
				audit_action,
				audit_itemid,
				audit_timestamp

			FROM audit LEFT JOIN users ON audit_userid = id WHERE audit_userid = ? ORDER BY audit_id DESC",[$userid]) ;
			$results = $stmt->results();
			$num_returns = $stmt->count();
			return $results;
			return $num_returns;
		}
}

if(!function_exists("writeAudit")){
 function writeAudit($userid,$userip,$othus,$event,$action,$itemid=0)
	{
	$db = DB::getInstance();
	$time = time();
	$stmt = $db->query("INSERT INTO audit (
	audit_userid,audit_userip,audit_othus,audit_eventcode,audit_action,audit_itemid,audit_timestamp
	)
	VALUES (
	?,
	?,
	?,
	?,
	?,
	?,
	?
)",[$userid,$userip,$othus,$event,$action,$itemid,$time]);
	$result = $stmt->results();
	return $result;
	}
}
//------------end of audit.php files

if (!function_exists('mqtt')) {
	function mqtt($id, $topic, $message)
	{
	  //id is the server id in the mqtt_settings.php
	  $db = DB::getInstance();
	  $query = $db->query('SELECT * FROM mqtt WHERE id = ?', [$id]);
	  $count = $query->count();
	  if ($count > 0) {
		$server = $query->first();
  
		$host = $server->server;
		$port = $server->port;
		$username = $server->username;
		$password = $server->password;
  
		$mqtt = new phpMQTT($host, $port, 'ClientID'.rand());
  
		if ($mqtt->connect(true, null, $username, $password)) {
		  $mqtt->publish($topic, $message, 0);
		  $mqtt->close();
		} else {
		  echo 'Fail or time out';
		}
	  } else {
		echo 'Server not found. Please check your id.';
	  }
	}
  }