<?php
// This is a user-facing page
/*
UserSpice 5
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
require_once '../users/init.php';
if (!securePage($_SERVER['PHP_SELF'])) {
    die();
}
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
$hooks = getMyHooks();
includeHook($hooks, 'pre');

if (!empty($_POST['uncloak'])) {
    logger($user->data()->id, 'Cloaking', 'Attempting Uncloak');
    if (isset($_SESSION['cloak_to'])) {
        $to = $_SESSION['cloak_to'];
        $from = $_SESSION['cloak_from'];
        unset($_SESSION['cloak_to']);
        $_SESSION[Config::get('session/session_name')] = $_SESSION['cloak_from'];
        unset($_SESSION['cloak_from']);
        logger($from, 'Cloaking', 'uncloaked from '.$to);
        $cloakHook =  getMyHooks(['page'=>'cloakEnd']);
        includeHook($cloakHook,'body');
        usSuccess("You are now you");
        Redirect::to($us_url_root.'users/admin.php?view=users');
    } else {
        usError("Something went wrong. Please login again");
        Redirect::to($us_url_root.'users/logout.php');
    }
}

//dealing with if the user is logged in
if ($user->isLoggedIn() || !$user->isLoggedIn() && !hasPerm(2)) {
    if (($settings->site_offline == 1) && (!in_array($user->data()->id, $master_account)) && ($currentPage != 'login.php') && ($currentPage != 'maintenance.php')) {
        $user->logout();
        logger($user->data()->id, 'Errors', 'Sending to Maint');
        Redirect::to($us_url_root.'users/maintenance.php');
    }
}
$grav = fetchProfilePicture($user->data()->id);
$get_info_id = $user->data()->id;
// $groupname = ucfirst($loggedInUser->title);
$raw = date_parse($user->data()->join_date);
$signupdate = $raw['month'].'/'.$raw['day'].'/'.$raw['year'];
$userdetails = fetchUserDetails(null, null, $get_info_id); //Fetch user details
?>

<div id="page-wrapper">
<div class="container">
<div class="well">
<div class="row">
	<div class="col-sm-12 col-md-3">
		<p>
		</p>
		<p>

			<img src="<?=$grav; ?>" class="img-thumbnail" alt="Generic placeholder thumbnail"></p>
		<p><a href="../users/user_settings.php" class="btn btn-primary btn-block"><?=lang('ACCT_EDIT'); ?></a></p>
	<?php if (isset($_SESSION['cloak_to'])) { ?>
		<form class="" action="" method="post">
			<input type="submit" name="uncloak" value="Uncloak!" class='btn btn-danger btn-block'>
		</form><br>
		<?php }
        ?>
		<?php includeHook($hooks, 'body'); ?>
	</div>
	<div class="col-sm-12 col-md-9">
		<h1 id="username"><?=echousername($user->data()->id); ?></h1>
		<p><span id="fname"><?=ucfirst($user->data()->fname).' '.ucfirst($user->data()->lname); ?> </span><span id="slash">/</span> <span id="lname"><?=echouser($user->data()->id); ?></span></p>
		<p><?=lang('ACCT_SINCE'); ?>: <?=$signupdate; ?></p>
		<p><?=lang('ACCT_LOGINS'); ?>: <?=$user->data()->logins; ?></p>
		<?php
        includeHook($hooks, 'bottom'); ?>
	</div>

</div>

</div>
	<?php languageSwitcher(); ?>
</div> <!-- /container -->

</div> <!-- /#page-wrapper -->

<!-- footers -->

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
