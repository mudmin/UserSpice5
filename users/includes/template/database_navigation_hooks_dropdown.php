<?php
if(isset($user) && $user->isLoggedIn()){
$dropdownString = parse_menu_hook('{{username}}',$user->data()->username,$dropdownString);
$dropdownString = parse_menu_hook('{{fname}}',$user->data()->fname,$dropdownString);
$dropdownString = parse_menu_hook('{{home}}',lang("MENU_HOME"),$dropdownString);
$dropdownString = parse_menu_hook('{{account}}',lang("MENU_ACCOUNT"),$dropdownString);
$dropdownString = parse_menu_hook('{{dashboard}}',lang("MENU_DASH"),$dropdownString);
$dropdownString = parse_menu_hook('{{perms}}',lang("MENU_PERM_MGR"),$dropdownString);
$dropdownString = parse_menu_hook('{{pages}}',lang("MENU_PAGE_MGR"),$dropdownString);
$dropdownString = parse_menu_hook('{{users}}',lang("MENU_USER_MGR"),$dropdownString);
$dropdownString = parse_menu_hook('{{messages}}',lang("MENU_MSGS_MGR"),$dropdownString);
$dropdownString = parse_menu_hook('{{logs}}',lang("MENU_LOGS_MGR"),$dropdownString);
$dropdownString = parse_menu_hook('{{logout}}',lang("MENU_LOGOUT"),$dropdownString);
}
$dropdownString = parse_menu_hook('{{forgot}}',lang("SIGNIN_FORGOTPASS"),$dropdownString);
$dropdownString = parse_menu_hook('{{resend}}',lang("VER_RESEND"),$dropdownString);
$dropdownString = parse_menu_hook('{{help}}',lang("MENU_HELP"),$dropdownString);
