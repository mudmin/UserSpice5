<?php //UserSpice Database-based Menu Functions
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
