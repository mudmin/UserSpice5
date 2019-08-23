<?php //UserSpice functions for Pages and Permissions
//Do not deactivate!

//Check if a permission level ID exists in the DB
if(!function_exists('permissionIdExists')) {
	function permissionIdExists($id) {
		$db = DB::getInstance();
		$query = $db->query("SELECT id FROM permissions WHERE id = ? LIMIT 1",array($id));
		$num_returns = $query->count();

		if ($num_returns > 0) {
			return true;
		} else {
			return false;
		}
	}
}

//Retrieve information for a single permission level
if(!function_exists('fetchPermissionDetails')) {
	function fetchPermissionDetails($id) {
		$db = DB::getInstance();
		$query = $db->query("SELECT id, name FROM permissions WHERE id = ? LIMIT 1",array($id));
		$results = $query->first();
		$row = array('id' => $results->id, 'name' => $results->name);
		return ($row);
	}
}

//Change a permission level's name
if(!function_exists('updatePermissionName')) {
	function updatePermissionName($id, $name) {
		$db = DB::getInstance();
		$fields=array('name'=>$name);
		$db->update('permissions',$id,$fields);
	}
}

//Retrieve list of permission levels a user has
if(!function_exists('fetchUserPermissions')) {
	function fetchUserPermissions($user_id) {
		$db = DB::getInstance();
		$query = $db->query("SELECT * FROM user_permission_matches WHERE user_id = ?",array($user_id));
		$results = $query->results();
		return ($results);
	}
}

//Retrieve list of users who have a permission level
if(!function_exists('fetchPermissionUsers')) {
	function fetchPermissionUsers($permission_id) {
		$db = DB::getInstance();
		$query = $db->query("SELECT id, user_id FROM user_permission_matches WHERE permission_id = ?",array($permission_id));
		$results = $query->results();
		return ($results);
		$row[$user] = array('id' => $id, 'user_id' => $user);
		if (isset($row)){
			return ($row);
		}
	}
}

//Unmatch permission level(s) from user(s)
if(!function_exists('removePermission')) {
	function removePermission($permissions, $members) {
		$db = DB::getInstance();
		if(is_array($members)){
			$memberString = '';
			foreach($members as $member){
				$memberString .= $member.',';
			}
			$memberString = rtrim($memberString,',');

			$q = $db->query("DELETE FROM user_permission_matches WHERE permission_id = ? AND user_id IN ({$memberString})",[$permissions]);
		}elseif(is_array($permissions)){
			$permissionString = '';
			foreach($permissions as $permission){
				$permissionString .= $permission.',';
			}
			$permissionString = rtrim($permissionString,',');
			$q = $db->query("DELETE FROM user_permission_matches WHERE user_id = ? AND permission_id IN ({$permissionString})",[$members]);
		}
		return $q->count();
	}
}


//Retrieve a list of all .php files in root files folder
if(!function_exists('getPathPhpFiles')) {
	function getPathPhpFiles($absRoot,$urlRoot,$fullPath) {
		$directory = $absRoot.$urlRoot.$fullPath;
		//bold ($directory);
		$pages = glob($directory . "*.php");

		foreach ($pages as $page){
			$fixed = str_replace($absRoot.$urlRoot,'',$page);
			$row[$fixed] = $fixed;
		}
		if ($pages != null) {
	 		return $row;
		}
	}
}


//Delete a page from the DB
if(!function_exists('deletePages')) {
	function deletePages($pages) {
		$db = DB::getInstance();
		if(!$query = $db->query("DELETE FROM pages WHERE id IN ({$pages})")){
			throw new Exception('There was a problem deleting pages.');
		}else{
			return true;
		}
	}
}

//Fetch information on all pages
if(!function_exists('fetchAllPages')) {
	function fetchAllPages() {
		$db = DB::getInstance();
		$query = $db->query("SELECT id, page, title, private, re_auth FROM pages ORDER BY id DESC");
		$pages = $query->results();
		//return $pages;

		if (isset($row)){
			return ($row);
		}else{
			return $pages;
		}
	}
}

//Fetch information for a specific page
if(!function_exists('fetchPageDetails')) {
	function fetchPageDetails($id) {
		$db = DB::getInstance();
		$query = $db->query("SELECT id, page, title, private, re_auth FROM pages WHERE id = ?",array($id));
		$row = $query->first();
		return $row;
	}
}

//Check if a page ID exists
if(!function_exists('pageIdExists')) {
	function pageIdExists($id) {
		$db = DB::getInstance();
		$query = $db->query("SELECT private FROM pages WHERE id = ? LIMIT 1",array($id));
		$num_returns = $query->count();
		if ($num_returns > 0){
			return true;
		}else{
			return false;
		}
	}
}

//Toggle private/public setting of a page
if(!function_exists('updatePrivate')) {
	function updatePrivate($id, $private) {
		$db = DB::getInstance();
		if($private == 0) $result = $db->query("UPDATE pages SET private = ?,re_auth = ? WHERE id = ?",array($private,0,$id));
		else $result = $db->query("UPDATE pages SET private = ? WHERE id = ?",array($private,$id));
		return $result;
	}
}

//Add a page to the DB
if(!function_exists('createPages')) {
	function createPages($pages) {
		$db = DB::getInstance();
		foreach($pages as $page){
			$setting = $db->query("SELECT page_default_private FROM settings")->first();
			$fields=array('page'=>$page, 'private'=>$setting->page_default_private);
			$db->insert('pages',$fields);
		}
	}
}

//Match permission level(s) with page(s)
if(!function_exists('addPage')) {
function addPage($page, $permission) {
	$db = DB::getInstance();
	$i = 0;
	if (is_array($permission)){
		foreach($permission as $id){
			$query = $db->query("INSERT INTO permission_page_matches (
				permission_id, page_id ) VALUES ( $id , $page )");
				$i++;
	}
} elseif (is_array($page)){
	foreach($page as $id){
		$query = $db->query("INSERT INTO permission_page_matches (
			permission_id, page_id ) VALUES ( $permission , $id )");
			$i++;
		}
	} else {
		$query = $db->query("INSERT INTO permission_page_matches (
			permission_id, page_id ) VALUES ( $permission , $page )");
			$i++;
		}
		return $i;
	}
}

//Check if a user has access to a page
if(!function_exists('securePage')) {
	function securePage($uri){
		global $master_account;
		//Separate document name from uri
		//$tokens = explode('/', $uri);
		//$page = end($tokens);

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
		$page=substr($uri,$urlRootLength,strlen($uri)-$urlRootLength);
		$dest=encodeURIComponent("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

		//bold($page);

		$db = DB::getInstance();
		//if you want the ip check on every page
		// $ip = ipCheck();
		// $ban = $db->query("SELECT id FROM us_ip_blacklist WHERE ip = ?",array($ip))->count();
	  // if($ban > 0){
	  //   $unban = $db->query("SELECT id FROM us_ip_whitelist WHERE ip = ?",array($ip))->count();
	  //   if($unban < 1){
	  //     Redirect::to($us_url_root.'usersc/scripts/banned.php');die();
	  //   }
		// }

		$id = null;
		$private = null;
		// dnd($page);
		global $user;
		// dnd($user);
		if(isset($user) && $user->data() != null){
			if($user->data()->permissions==0){
				Redirect::to($us_url_root.'usersc/scripts/banned.php');
				die();
			}
		}
		//retrieve page details
		$query = $db->query("SELECT id, page, private FROM pages WHERE page = ?",[$page]);
		$count = $query->count();
		if ($count==0){
			if(hasPerm([2])){
				$setting = $db->query("SELECT page_default_private FROM settings")->first();
				$fields = array(
					'page'		=> $page,
					'private'	=> $setting->page_default_private,
				);
				$new = $db->insert('pages',$fields);
				$last = $db->lastId();
				//dnd($page);
				if(strpos($page,'usersc/')!==false) {
					//dnd(str_replace('usersc/','users/',$page));
					$q=$db->query("SELECT * FROM pages WHERE page = ?",[str_replace('usersc/','users/',$page)]);
					if($q->count()==1) {
						$result=$q->first();
						$db->update('pages',$last,['title' => $result->title,'private' => $result->private,'re_auth' => $result->re_auth]);
						if(!$db->error()) logger($user->data()->id,"securePage","Updated $page based on users match.");
						else logger($user->data()->id,"securePage","Failed to update $page based on match, Error: ".$db->errorString());
						$permissions=fetchPagePermissions($result->id);
						foreach($permissions as $permission) {
							$db->insert('permission_page_matches',['page_id' => $last,'permission_id' => $permission->permission_id]);
							if(!$db->error()) logger($user->data()->id,"securePage","Auto-Added Permission #".$permission->permission_id." to $page.");
							else logger($user->data()->id,"securePage","Failed ot add Permission ID#".$permission->permission_id." to $page, Error: ".$db->errorString());
						}
						Redirect::to($us_url_root.$page.'?msg=Page inserted and auto-mapped.');
					}
				}
				Redirect::to($us_url_root.'users/admin.php?view=page&err=Please+confirm+permission+settings.&new=yes&id='.$last.'&dest='.$dest);
			}else{
			bold('<br><br>You must go into the Admin Panel and click the Manage Pages button to add this page to the database. Doing so will make this error go away.');
			die();
		}
	}
		$results = $query->first();

		$pageDetails = array( 'id' =>$results->id, 'page' => $results->page, 'private' =>$results->private);

		$pageID = $results->id;
		$ip = ipCheck();
		//If page does not exist in DB, allow access
		if (empty($pageDetails)){
			return true;
		}elseif ($pageDetails['private'] == 0){//If page is public, allow access
			return true;
		}elseif(!$user->isLoggedIn()){ //If user is not logged in, deny access
			$fields = array(
				'user'	=> 0,
				'page'	=> $pageID,
				'ip'		=> $ip,
			);
			$db->insert('audit',$fields);
			require_once $abs_us_root.$us_url_root.'usersc/scripts/not_logged_in.php';
			Redirect::to($us_url_root.'users/login.php?dest='.$page.'&redirect='.$dest);
			return false;
		}else {
			//Retrieve list of permission levels with access to page

			$query = $db->query("SELECT permission_id FROM permission_page_matches WHERE page_id = ?",[$pageID]);

			$permission = $query->results();
			$pagePermissions[] = $permission;

			//Check if user's permission levels allow access to page
			if (checkPermission($pagePermissions)){
				return true;
			}elseif  (in_array($user->data()->id, $master_account)){ //Grant access if master user
				return true;
			}else {
				if (!$homepage = Config::get('homepage'))
				$homepage = 'index.php';
				$fields = array(
					'user'	=> $user->data()->id,
					'page'	=> $pageID,
					'ip'		=> $ip,
				);
				$db->insert('audit',$fields);
				require_once $abs_us_root.$us_url_root.'usersc/scripts/did_not_have_permission.php';
				Redirect::to($homepage);
				return false;
			}
		}
	}
}

//Retrieve list of permission levels that can access a page
if(!function_exists('fetchPagePermissions')) {
	function fetchPagePermissions($page_id) {
	$db = DB::getInstance();
	$query = $db->query("SELECT id, permission_id FROM permission_page_matches WHERE page_id = ? ",array($page_id));
	$results = $query->results();
	return($results);
	}
}

//Retrieve list of pages that a permission level can access
if(!function_exists('fetchPermissionPages')) {
	function fetchPermissionPages($permission_id) {
	$db = DB::getInstance();

	$query = $db->query(
		"SELECT m.id as id, m.page_id as page_id, p.page as page, p.private as private
		FROM permission_page_matches AS m
		INNER JOIN pages AS p ON m.page_id = p.id
		WHERE m.permission_id = ?",[$permission_id]);
		$results = $query->results();
		return ($results);
	}
}

//Unmatched permission and page
if(!function_exists('removePage')) {
	function removePage($pages, $permissions) {
		$db = DB::getInstance();
		if(is_array($permissions)){
			$ids = '';
			for($i = 0; $i < count($permissions);$i++){
				$ids .= $permissions[$i].',';
			}
			$ids = rtrim($ids,',');
			if($query = $db->query("DELETE FROM permission_page_matches WHERE permission_id IN ({$ids}) AND page_id = ?",array($pages))){
				return $query->count();
			}
		}elseif(is_array($pages)){
			$ids = '';
			for($i = 0; $i < count($pages);$i++){
				$ids .= $pages[$i].',';
			}
			$ids = rtrim($ids,',');
			if($query = $db->query("DELETE FROM permission_page_matches WHERE page_id IN ({$ids}) AND permission_id = ?",array($permissions))){
				return $query->count();
			}
		}
	}
}

if(!function_exists('checkMenu')) {
	function checkMenu($permission, $id = 0) {
		$db = DB::getInstance();
		global $user;
	            if ($id == 0 && $user->isLoggedIn()) $id = $user->data()->id;
		//Grant access if master user
		$access = 0;

		if ($access == 0){
			$query = $db->query("SELECT id FROM user_permission_matches  WHERE user_id = ? AND permission_id = ?",array($id,$permission));
			$results = $query->count();
			if ($results > 0){
				$access = 1;
			}
		}
		if ($access == 1){
			return true;
		}
		if ($user->isLoggedIn() && $user->data()->id == 1){
			return true;
		}else{
			return false;
		}
	}
}

//Retrieve information for all permission levels
if(!function_exists('fetchAllPermissions')) {
	function fetchAllPermissions() {
		$db = DB::getInstance();
		$query = $db->query("SELECT id, name FROM permissions");
		$results = $query->results();
		return ($results);
	}
}

//Does user have permission
//This is the old school UserSpice Permission System
if(!function_exists('checkPermission')) {
	function checkPermission($permission) {
		$db = DB::getInstance();
		global $user;
		//Grant access if master user
		$access = 0;

		foreach($permission[0] as $perm){
			if ($access == 0){
				$query = $db->query("SELECT id FROM user_permission_matches  WHERE user_id = ? AND permission_id = ?",array($user->data()->id,$perm->permission_id));
				$results = $query->count();
				if ($results > 0){
					$access = 1;
				}
			}
		}
		if ($access == 1){
			return true;
		}
		if ($user->data()->id == 1){
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists('addPermission')) {
	//Match permission level(s) with user(s)
	function addPermission($permission_ids, $members) {
		$db = DB::getInstance();
		$i = 0;
		if(is_array($permission_ids)){
			foreach($permission_ids as $permission_id){
				if($db->query("INSERT INTO user_permission_matches (user_id,permission_id) VALUES (?,?)",[$members,$permission_id])){
					$i++;
				}
			}
		}elseif(is_array($members)){
			foreach($members as $member){
				if($db->query("INSERT INTO user_permission_matches (user_id,permission_id) VALUES (?,?)",[$member,$permission_ids])){
					$i++;
				}
			}
		}
		return $i;
	}
}

if(!function_exists('deletePermission')) {
	//Delete a permission level from the DB
	function deletePermission($permission) {
		global $errors;
		$i = 0;
		$db = DB::getInstance();
		foreach($permission as $id){
			if ($id == 1){
				$errors[] = lang("CANNOT_DELETE_NEWUSERS");
			}
			elseif ($id == 2){
				$errors[] = lang("CANNOT_DELETE_ADMIN");
			}else{
				$query1 = $db->query("DELETE FROM permissions WHERE id = ?",array($id));
				$query2 = $db->query("DELETE FROM user_permission_matches WHERE permission_id = ?",array($id));
				$query3 = $db->query("DELETE FROM permission_page_matches WHERE permission_id = ?",array($id));
				$i++;
			}
		}
		return $i;
	}
}

if(!function_exists('hasPerm')) {
	function hasPerm($permissions, $id=null) {
		if(is_null($id)) {
			global $user;
			if($user->isLoggedIn()) $id=$user->data()->id;
			else return false;
		}
		if($id=='') return false;
		$db = DB::getInstance();
		global $user;
		global $master_account;
		//Grant access if master user
		$access = 0;
		if($id==null) $id=$user->data()->id;

		foreach($permissions as $permission){

			if ($access == 0){
				$query = $db->query("SELECT id FROM user_permission_matches  WHERE user_id = ? AND permission_id = ?",array($id,$permission));
				$results = $query->count();
				if ($results > 0){
					$access = 1;
				}
			}
		}
		if ($access == 1){
			return true;
		}
		if (in_array($user->data()->id, $master_account)){
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists('echopage')) {
	function echopage($id){
		$db = DB::getInstance();
		$query = $db->query("SELECT page FROM pages WHERE id = ? LIMIT 1",array($id));
		$count=$query->count();

		if ($count > 0) {
			$results=$query->first();
			echo $results->page;
		} else {
			echo "Unknown";
		}
	}
}
