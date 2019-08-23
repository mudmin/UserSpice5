<?php
if(isset($user) && $user->isLoggedIn()){
$dropdownString=str_replace('{{username}}',$user->data()->username,$dropdownString);
$dropdownString = str_replace('{{fname}}',$user->data()->fname,$dropdownString);
$dropdownString = str_replace('{{home}}',lang("MENU_HOME"),$dropdownString);
$dropdownString = str_replace('{{account}}',lang("MENU_ACCOUNT"),$dropdownString);
$dropdownString = str_replace('{{dashboard}}',lang("MENU_DASH"),$dropdownString);
$dropdownString = str_replace('{{perms}}',lang("MENU_PERM_MGR"),$dropdownString);
$dropdownString = str_replace('{{pages}}',lang("MENU_PAGE_MGR"),$dropdownString);
$dropdownString = str_replace('{{users}}',lang("MENU_USER_MGR"),$dropdownString);
$dropdownString = str_replace('{{messages}}',lang("MENU_MSGS_MGR"),$dropdownString);
$dropdownString = str_replace('{{logs}}',lang("MENU_LOGS_MGR"),$dropdownString);
$dropdownString = str_replace('{{logout}}',lang("MENU_LOGOUT"),$dropdownString);
}
$dropdownString = str_replace('{{forgot}}',lang("SIGNIN_FORGOTPASS"),$dropdownString);
$dropdownString = str_replace('{{resend}}',lang("VER_RESEND"),$dropdownString);
$dropdownString = str_replace('{{help}}',lang("MENU_HELP"),$dropdownString);
