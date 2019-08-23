<?php
include('install/includes/install_settings.php');
//If Submitted
if (!empty($_POST['submit'])) {
	$chunk = file_get_contents("install/chunks/restore.php");
	$fh=fopen($config_file , "w+");
	fwrite($fh , $chunk);
	fclose($fh);
	header("Location: index.php");
}

require_once("install/includes/header.php"); ?>

<div class="container mt-4 mb-5">

	<div class="jumbotron text-center bg-white text-dark">
		<h1 class="display-4">Having Problems?</h1>
		<p class="lead">It's easy to start over!</p>
		<form class="form" action="" method="post">
			<input class="btn btn-danger" type="submit" name="submit" value="Reset and Start Over!">
		</form>
	</div>

</div>

<?php require_once("install/includes/footer.php"); ?>
