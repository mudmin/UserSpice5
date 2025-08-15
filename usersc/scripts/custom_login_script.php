<?php
//Whatever you put here will happen after the username and password are verified and the user is "technically" logged in, but they have not yet been redirected to their starting page.  This gives you access to all the user's data through $user->data()

//Where do you want to redirect the user after login
//in this example, admins will go to the dashboard and others will go to the location you configured
//in the dashboard under settings->general->Redirect After Login
if(hasPerm([2],$user->data()->id)){
  Redirect::to($us_url_root.'users/admin.php');
}else{
Redirect::to($us_url_root.$settings->redirect_uri_after_login);
}
?>
