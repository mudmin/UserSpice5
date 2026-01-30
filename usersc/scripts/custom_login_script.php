<?php
//Whatever you put here will happen after the username and password are verified and the user is "technically" logged in, but they have not yet been redirected to their starting page.  This gives you access to all the user's data through $user->data()

//Where do you want to redirect the user after login
// First check if user was trying to access a specific page (stored in $dest by login.php)
// Otherwise, admins go to the dashboard and others go to the configured redirect location

if (isset($dest) && !empty($dest)) {
    // User was redirected to login from a protected page - send them back there
    Redirect::sanitized($dest);
} elseif (hasPerm([2], $user->data()->id)) {
    Redirect::to($us_url_root . 'users/admin.php');
} else {
    Redirect::to($us_url_root . $settings->redirect_uri_after_login);
}
?>
