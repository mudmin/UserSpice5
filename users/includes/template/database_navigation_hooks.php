<?php
//these deal with dynamic and multilanguage content in the menus.
if(isset($user) && $user->isLoggedIn()){
$itemString = str_replace('{{username}}',$user->data()->username,$itemString);
$itemString = str_replace('{{fname}}',$user->data()->fname,$itemString);
$itemString = str_replace('{{lname}}',$user->data()->lname,$itemString);
}
$itemString = str_replace('{{home}}',lang("MENU_HOME"),$itemString);
$itemString = str_replace('{{login}}',lang("SIGNIN_TEXT"),$itemString);
$itemString = str_replace('{{register}}',lang("SIGNUP_TEXT"),$itemString);
$itemString = str_replace('{{help}}',lang("MENU_HELP"),$itemString);
