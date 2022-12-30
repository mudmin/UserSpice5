<?php
function parseMenuLabel($string){
	global $lang,$user,$settings;

	if(substr($string, 0, 2) != "{{"){
		$newString =  $string;
	}elseif($string == "{{LOGGED_IN_USERNAME}}"){
			if(isset($user) && $user->isLoggedIn()){

			$newString = echouser($user->data()->id,$settings->echouser,true);

		}else{
			$newString = "";
		}
		return $newString;
	}else{
		$newString = str_replace(['{', '}'], '', $string);
		if(array_key_exists($newString,$lang)){
			return $lang[$newString];
		}else{
			return $newString;
		}

	}
	return $newString;
}

function _assert( $expr, $msg){ if( !$expr ) print "<br/><b>ASSERTION FAIL: </b>{$msg}<br>";  }

function prepareMenuTree($menuResults){
	/*
	Get instance of tree manager and build the tree
	*/
	$treeManager = treeManager::get();
	$menuTree = $treeManager->getTree($menuResults, 'id','parent','display_order');
	/*
	Indent the tree
	*/
	//$menuTree = $treeManager->slapTree($recordsTree, 1 ); //1 for indent count

	return $menuTree;
}

function prepareIndentedMenuTree($menuResults){
	/*
	Get instance of tree manager and build the tree
	*/
	$treeManager = treeManager::get();
	$menuTree = $treeManager->getTree($menuResults, 'id','parent','display_order');
	/*
	Indent the tree
	*/
	$menuIndentedTree = $treeManager->slapTree($menuTree, 1,'menu_title' ); //1 for indent count

	return $menuIndentedTree;
}

function prepareDropdownString($menuItem,$user_id){
	$itemString='';
	$itemString.='<li class="dropdown">';
	$itemString.='<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].' <span class="caret"></span></a>';
	$itemString.='<ul class="dropdown-menu">';
	foreach ($menuItem['children'] as $childItem){
		$authorizedGroups = array();
    foreach (fetchGroupsByMenu($childItem['id']) as $g) {
    	$authorizedGroups[] = $g->group_id;
    }
		if($childItem['logged_in']==0 || (hasPerm($authorizedGroups,$user_id) || in_array(0,$authorizedGroups))) {
		$itemString.=prepareItemString($childItem,$user_id); }
	}
	$itemString.='</ul></li>';
	return $itemString;
}

function prepareItemString($menuItem,$user_id){
	$itemString='';
	if($menuItem['label']=='{{hr}}') { $itemString = "<li class='divider'></li>"; }
	elseif($menuItem['link']=='users/verify_resend.php' || $menuItem['link']=='usersc/verify_resend.php') {
		$db = DB::getInstance();
		$query = $db->query("SELECT * FROM email");
		$results = $query->first();
		$email_act=$results->email_act;
		if($email_act==1) {
			$itemString.='<li><a href="'.US_URL_ROOT.$menuItem['link'].'"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].'</a></li>'; }
	}
	elseif($menuItem['link']=='users/join.php' || $menuItem['link']=='usersc/join.php') {
		$db = DB::getInstance();
		$query = $db->query("SELECT * FROM settings");
		$results = $query->first();
		$registration=$results->registration;
		if($registration==1) {
			$itemString.='<li><a href="'.US_URL_ROOT.$menuItem['link'].'"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].'</a></li>'; }
	}
	else {
		$fix = $menuItem['link'];
		if(substr($fix,0,4) == "http"){$e = 1;}else{$e=0;}
		if($e == 1){
	$itemString.='<li><a href="'.$menuItem['link'].'"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].'</a></li>';
	}else{
	$itemString.='<li><a href="'.US_URL_ROOT.$menuItem['link'].'"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].'</a></li>';
}}
	return $itemString;

}

if(!function_exists("parse_menu_hook")){
	function parse_menu_hook($find,$replace,$string){
		if(is_null($replace)){
			$replace = "";
		}
		if(is_null($string)){
			$string = "";
		}
	return str_replace($find,$replace,$string);
	}
}

if(!function_exists("migrateUSMainMenu")){
	function migrateUSMainMenu($truncate = false){
  global $db;

  if($truncate){
    $db->query("TRUNCATE TABLE us_menu_items");
  }else{
		$db->query("DELETE FROM us_menu_items WHERE menu = 1");
	}
		$db->query("DELETE FROM us_menu_perms WHERE menu = 1");

  $old = $db->query("SELECT * FROM menus ORDER BY parent")->results();
  $oldIds = [];
  $newIds = [];
  $counter = 0;
  $labels = [
    "{{home}}"=>"{{MENU_HOME}}",
    "{{username}}" =>"{{LOGGED_IN_USERNAME}}",
    "{{help}}" =>"{{MENU_HELP}}",
    "{{register}}" =>"{{SIGNUP_TEXT}}",
    "{{login}}" =>"{{SIGNIN_BUTTONTEXT}}",
    "{{account}}" =>"{{MENU_ACCOUNT}}",
    "{{dashboard}}" =>"{{MENU_DASH}}",
    "{{users}}" =>"{{MENU_USER_MGR}}",
    "{{perms}}" =>"{{MENU_PERM_MGR}}",
    "{{pages}}" =>"{{MENU_PAGE_MGR}}",
    "{{logs}}" =>"{{MENU_LOGS_MGR}}",
    "{{logout}}" =>"{{MENU_LOGOUT}}",
    "{{forgot}}" =>"{{SIGNIN_FORGOTPASS}}",
    "{{resend}}" =>"{{VER_RESEND}}",
  ];

  foreach($old as $o){

    $fields = [
      "menu"=>1,
      "label"=>$o->label,
      "link"=>$o->link,
      "icon_class"=>str_replace("fa-fw ","",$o->icon_class),
      "link_target"=>"_self",
      "display_order"=>$o->display_order,
      "parent"=>$o->parent,
    ];

    if($o->dropdown == 0){
      $fields['type'] = "link";
    }else{
      $fields['type'] = "dropdown";
    }

    if($o->label == "{{hr}}"){
      $fields['type'] = "separator";
      $fields['label'] = "";
    }

    //switch to standard userspice multilanguage
    if(array_key_exists($fields['label'],$labels)){
      $fields['label'] = $labels[$fields['label']];
    }

    $db->insert("us_menu_items",$fields);
    // dump("Item insert " . $db->errorString());
    $id = $db->lastId();
    $oldIds[$counter] = $o->id;
    $newIds[$counter] = $id;
    $counter++;

    $perms = $db->query("SELECT DISTINCT group_id FROM groups_menus WHERE menu_id = ?",[$o->id])->results();
    $newPerms = "[";
    foreach($perms as $p){
      $newPerms .= $p->group_id .",";
    }
    $newPerms = rtrim($newPerms, ',');
    $newPerms .= "]";
    if($o->logged_in == 0 && ($newPerms == "[]" || $newPerms == "[0]")){
      $newPerms = "[0]";
    }
    if($o->logged_in == 1 && $newPerms == "[0]"){
      $newPerms = "[1]";
    }
    $db->update("us_menu_items",$id,["permissions"=>$newPerms]);
    // dump("Perm Update " . $db->errorString());
  }


  $new = $db->query("SELECT * FROM us_menu_items WHERE menu = 1")->results();
  foreach($new as $n){
    $newParent = 0;

    if(!$n->parent == "-1"){
      $newParent = 0;
    }else{
      foreach($oldIds as $k=>$v){
        if($n->parent == $v){
          $newParent = $newIds[$k];
          break;
        }
      }
    }

    $db->update("us_menu_items",$n->id,['parent'=>$newParent]);
  }

}
}

?>
