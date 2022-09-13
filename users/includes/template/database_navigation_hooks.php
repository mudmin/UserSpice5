<?php
//these deal with dynamic and multilanguage content in the menus.
if(isset($user) && $user->isLoggedIn()){
$itemString = parse_menu_hook('{{username}}',$user->data()->username,$itemString);
$itemString = parse_menu_hook('{{fname}}',$user->data()->fname,$itemString);
$itemString = parse_menu_hook('{{lname}}',$user->data()->lname,$itemString);
}
$itemString = parse_menu_hook('{{home}}',lang("MENU_HOME"),$itemString);
$itemString = parse_menu_hook('{{login}}',lang("SIGNIN_TEXT"),$itemString);
$itemString = parse_menu_hook('{{register}}',lang("SIGNUP_TEXT"),$itemString);
$itemString = parse_menu_hook('{{help}}',lang("MENU_HELP"),$itemString);
