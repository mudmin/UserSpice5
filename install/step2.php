<?php
require_once("install/includes/header.php");
$go = 0;
?>

<div class="container">
	<div class="row justify-content-center mt-4">
		<div class="col-6">
			<div class="list-group list-group-horizontal-xl">
				<a href="#" class="list-group-item list-group-item-action">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Step 1</h5>
					</div>
					<p class="mb-1"><?= $step1 ?></p>
				</a>
				<a href="#" class="list-group-item list-group-item-action active">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Step 2</h5>
					</div>
					<p class="mb-1"><?= $step2 ?></p>
				</a>
				<a href="#" class="list-group-item list-group-item-action">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Step 3</h5>
					</div>
					<p class="mb-1"><?= $step3 ?></p>
				</a>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12 mt-4">
			<?php
			if (!empty($_POST)){
				echo '<div class="alert alert-primary" role="alert">We are importing the tables... one moment please!</div>';
			}
			?>
			<h3>Please fill in your information</h3>
			<form class="form" action="" method="post">
				<div class="form-group row">
					<label for="timezone" class="col-sm-4 control-label">Region/Timezone (required)</label>
					<div class="col-sm-8">
						<?php
						$regions = array(
							'Africa' => DateTimeZone::AFRICA,
							'America' => DateTimeZone::AMERICA,
							'Antarctica' => DateTimeZone::ANTARCTICA,
							'Asia' => DateTimeZone::ASIA,
							'Atlantic' => DateTimeZone::ATLANTIC,
							'Australia' => DateTimeZone::AUSTRALIA,
							'Europe' => DateTimeZone::EUROPE,
							'Indian' => DateTimeZone::INDIAN,
							'Pacific' => DateTimeZone::PACIFIC
						);
						$timezones = array();
						foreach ($regions as $name => $mask)
						{
							$zones = DateTimeZone::listIdentifiers($mask);
							foreach($zones as $timezone)
							{
								// Lets sample the time there right now
								$time = new DateTime("now", new DateTimeZone($timezone));
								// Us dumb Americans can't handle millitary time
								$ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
								// Remove region name and add a sample time
								$timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm;
							}
						}
						// View
						?>
						<select required class="form-control" id="timezone" name="timezone" data-live-search="true">
							<?php
							print '<option disabled selected="selected">--Select Timezone--</option>';
							foreach($timezones as $region => $list)
							{
								print '<optgroup label="' . $region . '">' . "\n";
								if(!empty($_POST['timezone'])){?>
									<option value="<?=$_POST['timezone']?>" selected="selected"><?=$_POST['timezone']?></option>
									<?php
								}
								foreach($list as $timezone => $name)
								{
									print '<option value="' . $timezone . '"name="' . $timezone . '">' . $name . '</option>' . "\n";
								}
								print '<optgroup>' . "\n";
							}
							print '</select>';?>
						</div>
					</div>
					<div class="form-group row">
						<label for="dbh" class="col-sm-4 control-label">Database Host (required)</label>
						<div class="col-sm-8">
							<input required class="form-control" type="text" name="dbh" value="<?php if (!empty($_POST['dbh'])){ print $_POST['dbh']; } ?>" required>
						</div>
					</div>

					<div class="form-group row">
						<label for="port" class="col-sm-4 control-label">Database Port (required) (Normally 3306)</label>
						<div class="col-sm-8">
							<input required class="form-control" type="text" name="port" value="<?php if (!empty($_POST['port'])){ print $_POST['port']; }else{ echo "3306"; } ?>" required>
						</div>
					</div>

					<div class="form-group row">
						<label for="dbu" class="col-sm-4 control-label">Database User (required)</label>
						<div class="col-sm-8">
							<input required class="form-control" type="text" name="dbu" value="<?php if (!empty($_POST['dbu'])){ print $_POST['dbu']; } ?>" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="dbp" class="col-sm-4 control-label">Database Password (usually required)</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" name="dbp" value="<?php if (!empty($_POST['dbp'])){ print $_POST['dbp']; } ?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="dbn" class="col-sm-4 control-label">Database Name (required)</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" name="dbn" value="<?php if (!empty($_POST['dbn'])){ print $_POST['dbn']; } ?>" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-12 text-right">
							<input style="display:none;" id="sub" class="btn btn-primary" type="submit" name="test" value="Try These Settings (This will take a moment)">
							<a href="#" id="nosub" class="btn btn-warning">Please Select a Timezone</a>
						</div>
					</div>
				</div>
			</div>
			<?php
			//PHP Logic Goes Here
			if (!empty($_POST)){

				$fh=fopen($config_file , "a+");

				fwrite($fh ,"");

				fclose($fh);
				$fh=fopen($config_file , "a+");
				$end = "',";

				$dbh_syn="'host'         => '";
				$dbh=$_POST['dbh'];

				$dbu_syn="'username'     => '";
				$dbu=$_POST['dbu'];

				$dbp_syn="'password'     => '";
				$dbp=$_POST['dbp'];

				$dbn_syn="'db'           => '";
				$dbn=$_POST['dbn'];

				$port = $_POST['port'];
				//attempt manual db creation
				$dbFail = 0;
				//If Submitted
				if (!empty($_POST['submit'])) {

					$timezone_syn='$timezone_string = \'';
					$tz=$_POST['timezone'];
					fwrite($fh ,
					$dbh_syn . $dbh . "; port=" . $port . $end . PHP_EOL .
					$dbu_syn . $dbu . $end . PHP_EOL .
					$dbp_syn . $dbp . $end . PHP_EOL .
					$dbn_syn . $dbn . $end . PHP_EOL
				);
				$chunk1 = file_get_contents("install/chunks/chunk1.php");
				file_put_contents($config_file, $chunk1, FILE_APPEND);
				fclose($fh);
				$fh=fopen($config_file , "a+");
				$end = "';";
				fwrite($fh , $timezone_syn . $tz . $end . PHP_EOL);
				fclose($fh);
				$chunk2 = file_get_contents("install/chunks/chunk2.php");
				file_put_contents($config_file, $chunk2, FILE_APPEND);
				redirect("step3.php");
			}

				if (!empty($_POST['test'])) {
					try {
						$dsn = "mysql:host=$dbh;charset=utf8";
						$opt = array(
							PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
						);
						$pdo = new PDO($dsn, $dbu, $dbp, $opt) or die('could not connect');
						$pdo->exec("CREATE DATABASE `$dbn`;
							CREATE USER '$dbu'@'$dbh' IDENTIFIED BY '$dbp';
							GRANT ALL ON `$dbn`.* TO '$dbu'@'$dbh';
							FLUSH PRIVILEGES;")
							or die(print_r($pdo->errorInfo(), true));

						} catch (PDOException $e) {
							//I'm commenting this out because the script tries create a user and will fail if the user exists, but that is fine. We'll  stick with the if don't see a bunch of errors
						}
					$success = true;
					try {
						$dsn = "mysql:host=$dbh;charset=utf8";
						$opt = array(
							PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
						);
						$pdo = new PDO($dsn, $dbu, $dbp, $opt) or die('could not connect');
					} catch (PDOException $e) {
						$success = false;
						echo '<div class="alert alert-danger" role="alert">Database connection <strong>unsuccessful</strong>! Please try again.</div>';
					}

					if ($success) {
						$link = @mysqli_connect($dbh, $dbu, $dbp, $dbn);
						if (!$link) {
							$dbError =  mysqli_connect_errno();
							if($dbError == '1049'){?>
								<form class="" action="" method="post">
									<input type="hidden" name="test" value="1">
									<input type="hidden" name="dbh" value="<?=$dbh?>">
									<input type="hidden" name="dbu" value="<?=$dbu?>">
									<input type="hidden" name="dbp" value="<?=$dbp?>">
									<input type="hidden" name="dbn" value="<?=$dbn?>">
									<strong>
										<br>
										<div class="alert alert-primary" role="alert">Your credentials appear to be correct but the database name is not found.<br> If you would like to attempt to create it, please hit "Yes".
											Otherwise, edit your information and try again.</div>
											<div class="text-center"><input type="submit" name="tryToCreate" value="Yes, Create it For Me" class='btn btn-success btn-lg'></div>
										<?php }else{
											echo '<div class="alert alert-warning" role="alert">Database connection <strong>partially successful</strong>! Please see the errors below and make corrections as necessary.</div>';
											echo "Error: Unable to connect to MySQL." . PHP_EOL;
											echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
											echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
										}

									}else{
										$go = 1;
									}
									if($go === 1){
										// Temporary variable, used to store current query
										$templine = '';
										// Read in entire file
										$lines = file($sqlfile);
										// Loop through each line
										foreach ($lines as $line)
										{
											// Skip it if it's a comment
											if (substr($line, 0, 2) == '--' || $line == '')
											continue;

											// Add this line to the current segment
											$templine .= $line;
											// If it has a semicolon at the end, it's the end of the query
											if (substr(trim($line), -1, 1) == ';')
											{
												// Perform the query
												mysqli_query($link,$templine) or print('<div class="alert alert-danger" role="alert">Error performing query:<br><code>' . $templine . '</code></div>');
												// Reset temp variable to empty
												$templine = '';
											}
										}
										echo '<div class="alert alert-success" role="alert">If you do not see a bunch of errors above this line, your tables imported successfully</div>';
										?>
										<div class="text-center">
											<input class="btn btn-success btn-lg" type="submit" name="submit" value="Finalize Install">
											<br><br>
										</div>

									</form>
									<?php
								}
							}

						}
					} // if go =1
					?>
				</form>

			</div>
		</div>
	</div>
</div>


<?php require_once("install/includes/footer.php"); ?>
<script type="text/javascript">
$( document ).ready(function() {
	var tz = $("#timezone").val();
	if(tz != null){
		console.log("not");
		$("#sub").show();
		$("#nosub").hide();
	}
});
$("#timezone").change(function () {
	var tz = this.value;
	if(tz != ""){
		$("#sub").show();
		$("#nosub").hide();
	}else{
		$("#sub").hide();
		$("#nosub").show();
	}
});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.10/css/bootstrap-select.min.css" integrity="sha256-jwJEU4p1YdtymLFwAjYfam5Pj5NOnylms63k7LYQ9Jk=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.10/js/bootstrap-select.min.js" integrity="sha256-FXzZGmaRFZngOjUKy3lWZJq/MflaMpffBbu3lPT0izE=" crossorigin="anonymous"></script>
<script>
$(function () {
	$('select').selectpicker();
});


</script>
