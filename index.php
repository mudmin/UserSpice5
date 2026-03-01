<?php
if (file_exists("install/index.php")) {
	//perform redirect if installer files exist
	//this if{} block may be deleted once installed
	header("Location: install/index.php");
}
// $child_theme = 'dashboard';
require_once 'users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';


?>
<main>
	<div class="px-4 py-5 my-5 bg-light text-center">
		<h1><?= lang("JOIN_SUC"); ?> <?php echo $settings->site_name; ?></h1>
		<p class="text-muted"><?= lang("MAINT_OPEN") ?></p>
		<p class="my-4">
			<?php
			if ($user->isLoggedIn()) { ?>
				<a class="btn btn-primary" href="users/account.php" role="button"><span class="fa fa-user-circle-o mr-2 me-2"></span><?= lang("ACCT_HOME"); ?></a>
			<?php } else { ?>
				<a class="btn btn-warning mr-3 me-3" href="users/login.php" role="button"><span class="fa fa-sign-in mr-2 me-2"></span><?= lang("SIGNIN_TEXT"); ?></a>
				<a class="btn btn-info" href="users/join.php" role="button"><span class="fa fa-user-plus mr-2 me-2"></span><?= lang("SIGNUP_TEXT"); ?></a>
			<?php } ?>
		</p>
		<p><?= lang("MAINT_PLEASE"); ?></p>
		<p class="h4"><a href="https://userspice.com/getting-started/">https://userspice.com/getting-started/</a></h4>
	</div>
	<?php 
	languageSwitcher(); ?>
</main>

<!-- Place any per-page javascript here -->
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>