<?php
//This serves as an example to make your own template with DB based navigation
//Edit these functions to meet your own style needs.
//Note that there are a few "default" menu items that you are free to delete at your own risk
//Generally you can look for the <li> tags and anything you change in there will be reflected in your template.
function customItemString($menuItem,$user_id){
	$itemString='';

  //what do you want to happen if someone wants a "divider in their dropdown menu?"



  // typical bootstrap 4 styling...
  if($menuItem['label']=='{{hr}}') { $itemString = "<div class='dropdown-divider'></div>"; } //some bs4 css files will ignore this


	elseif($menuItem['link']=='users/verify_resend.php' || $menuItem['link']=='usersc/verify_resend.php') {
		$db = DB::getInstance();
		$query = $db->query("SELECT * FROM email");
		$results = $query->first();
		$email_act=$results->email_act;
		if($email_act==1) {

			$itemString.='<li class="nav-item"><a class="nav-link" href="'.US_URL_ROOT.$menuItem['link'].'"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].'</a></li>'; }
	}


	elseif($menuItem['link']=='users/join.php' || $menuItem['link']=='usersc/join.php') {
		$db = DB::getInstance();
		$query = $db->query("SELECT * FROM settings");
		$results = $query->first();
		$registration=$results->registration;
		if($registration==1) {
			$itemString.='<li class="nav-item"><a class="nav-link" href="'.US_URL_ROOT.$menuItem['link'].'"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].'</a></li>'; }
	}
	else {


// THIS is a typical menu link.  What do you want it to look like?
// Note that this is in here twice to deal with if the link has http in it for a link to another website
		$fix = $menuItem['link'];
		if(substr($fix,0,4) == "http"){$e = 1;}else{$e=0;}
		if($e == 1){

//It works the same for bootstrap 3 and 4 by default, but yourt template might want something other than li tags
	$itemString.='<li class="nav-item"><a class="nav-link" href="'.$menuItem['link'].'"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].'</a></li>';
	}else{
	$itemString.='<li class="nav-item"><a class="nav-link" href="'.US_URL_ROOT.$menuItem['link'].'"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].'</a></li>';
}}
	return $itemString;

}


function DropdownString($menuItem,$user_id){
	$itemString='';

  //what do you want to happen if someone wants a "divider in their dropdown menu?"



  // typical bootstrap 4 styling...
  if($menuItem['label']=='{{hr}}') { $itemString = "<div class='dropdown-divider'></div>"; } //some bs4 css files will ignore this


	elseif($menuItem['link']=='users/verify_resend.php' || $menuItem['link']=='usersc/verify_resend.php') {
		$db = DB::getInstance();
		$query = $db->query("SELECT * FROM email");
		$results = $query->first();
		$email_act=$results->email_act;
		if($email_act==1) {

			$itemString.='<li class="nav-item"><a class="nav-link" href="'.US_URL_ROOT.$menuItem['link'].'"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].'</a></li>'; }
	}


	elseif($menuItem['link']=='users/join.php' || $menuItem['link']=='usersc/join.php') {
		$db = DB::getInstance();
		$query = $db->query("SELECT * FROM settings");
		$results = $query->first();
		$registration=$results->registration;
		if($registration==1) {
			$itemString.='<li class="nav-item"><a class="nav-link" href="'.US_URL_ROOT.$menuItem['link'].'"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].'</a></li>'; }
	}
	else {


// THIS is a typical menu link.  What do you want it to look like?
// Note that this is in here twice to deal with if the link has http in it for a link to another website
		$fix = $menuItem['link'];
		if(substr($fix,0,4) == "http"){$e = 1;}else{$e=0;}
		if($e == 1){

//It works the same for bootstrap 3 and 4 by default, but yourt template might want something other than li tags
	$itemString.='<a class="dropdown-item" href="'.$menuItem['link'].'"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].'</a>';
	}else{
	$itemString.='<a class="dropdown-item" href="'.US_URL_ROOT.$menuItem['link'].'"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].'</a>';
}}
	return $itemString;

}

// Let's deal with dropdown menus
function customDropdownString($menuItem,$user_id){
	$itemString='';
  //bs4 usually uses divs, bs3 often uses li tags here
	$itemString.='<li class="nav-item dropdown">';

  // This is the little down arrow next to a dropdown menu. It works for bs3 and 4
	$itemString.='<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="navbardrop" aria-haspopup="true" aria-expanded="false"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].'</a>';

  //bs4 usually uses divs, bs3 often uses ul tags here
  $itemString.='<div class="dropdown-menu">';

  // These are the "child items" -- the things in the dropdown menu itself
  // You can usually leave this section alone
  foreach ($menuItem['children'] as $childItem){
		$authorizedGroups = array();
    foreach (fetchGroupsByMenu($childItem['id']) as $g) {
    	$authorizedGroups[] = $g->group_id;
    }
		if($childItem['logged_in']==0 || (hasPerm($authorizedGroups,$user_id) || in_array(0,$authorizedGroups))) {
		$itemString.=DropdownString($childItem,$user_id); }
	}
 //if you used li and ul above, make sure you close those here.
	$itemString.='</div></li>';
	return $itemString;
}

// Set up notifications button/modal
if ($user->isLoggedIn()) {
    if ($dayLimitQ = $db->query('SELECT notif_daylimit FROM settings', array())) $dayLimit = $dayLimitQ->results()[0]->notif_daylimit;
    else $dayLimit = 7;

    // 2nd parameter- true/false for all notifications or only current
  $notifications = new Notification($user->data()->id, false, $dayLimit);
}
/*
Load main navigation menus
*/
$main_nav_all = $db->query("SELECT * FROM menus WHERE menu_title='main' ORDER BY display_order");

/*
Set "results" to true to return associative array instead of object...part of db class
*/
$main_nav=$main_nav_all->results(true);
$prep=prepareMenuTree($main_nav); ;
foreach ($prep as $key => $value) {
  $authorizedGroups = array();
  foreach (fetchGroupsByMenu($value['id']) as $g) {
    $authorizedGroups[] = $g->group_id;
  }
  /*
  Check if there are children of the current nav item...if no children, display single menu item, if children display dropdown menu
  */
  if (sizeof($value['children'])==0) {
    if ($user->isLoggedIn()) {
      if((hasPerm($authorizedGroups,$user->data()->id) || in_array(0,$authorizedGroups)) && $value['logged_in']==1) {
      //if (checkMenu($value['id'],$user->data()->id) && $value['logged_in']==1) {
        if($value['label']=='{{notifications}}') {
            $itemString='';
            if($settings->notifications==1) {
                $itemString='<li class="nav-item"><a class="nav-link" href="#" onclick="displayNotifications(';
                $itemString.="'new')";
                $itemString.='"';
                $itemString.='id="notificationsTrigger" data-toggle="modal" data-target="#notificationsModal"><span class="fa fa-fw fa-bell-o"></span><span id="notifCount" class="badge badge-pill badge-primary" style="margin-top: -5px;">';
                 $itemString.=(int)$notifications->getUnreadCount();
                $itemString.='</span></a></li>';
            }
         }
        elseif($value['label']=='{{messages}}') {
            $itemString='';
            if($settings->messaging==1) {
// glyphicons are deprecated out of bootstrap 4. Annoying.  Let's override with a font-awesome 4.7 icon.
                $itemString='<li class="nav-item"><a class="nav-link" href="'.$us_url_root.'users/messages.php"><i data-count="'.$msgC.'" class="fa fa-fw fa-envelope-o icon-white badge"> ';
                if($msgC > 0) $itemString.= '('.$msgC.')';//I'm being lazy and putting () around the msg count
                $itemString.='</i></a></li>'; }
         }
        else {
        $itemString = customItemString($value,$user->data()->id);
				include $abs_us_root.$us_url_root.'users/includes/template/database_navigation_hooks.php';
        include $abs_us_root.$us_url_root.'usersc/includes/database_navigation_hooks.php';
       }
        echo $itemString;
      }
    } else {
      if ($value['logged_in']==0) {
				$itemString = customItemString($value,0);
				include $abs_us_root.$us_url_root.'users/includes/template/database_navigation_hooks.php';
				include $abs_us_root.$us_url_root.'usersc/includes/database_navigation_hooks.php';
				echo $itemString;
      }
    }
  } else {
    if ($user->isLoggedIn()) {
      if((hasPerm($authorizedGroups,$user->data()->id) || in_array(0,$authorizedGroups)) && $value['logged_in']==1) {
        $dropdownString=customDropdownString($value,$user->data()->id);
				include $abs_us_root.$us_url_root.'users/includes/template/database_navigation_hooks_dropdown.php';
				include $abs_us_root.$us_url_root.'usersc/includes/database_navigation_hooks_dropdown.php';
        echo $dropdownString;
      }
    } else {
      if ($value['logged_in']==0) {
        $dropdownString=customDropdownString($value,0);
				include $abs_us_root.$us_url_root.'users/includes/template/database_navigation_hooks_dropdown.php';
				include $abs_us_root.$us_url_root.'usersc/includes/database_navigation_hooks_dropdown.php';
        echo $dropdownString;
      }
    }
  }
}
?>
