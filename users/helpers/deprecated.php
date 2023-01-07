<?php //these are old UserCake and UserSpice functions that are not used  in our system by default
//However, if you found some use for them and your code stopped working, please copy the function(s)
//that you are missing into usersc/custom_functions.php and you'll be back to normal.


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
