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
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

//if (!securePage($_SERVER['PHP_SELF'])){die();}

$settingsQ = $db->query("SELECT * FROM settings");
$settings = $settingsQ->first();

?>
<div id="page-wrapper">
<div class="container">
<div class="row">
	<div class="col-sm-12">
				<h1 align="center" style="font-size: 140px; color: #FFD700; text-align:center"><i class="fa fa-frown-o fa-2x"></i></h1>
				    <h3 align="center"><?=lang("MAINT_HEAD");?></h3>
				        <p align="center"><?=lang("MAINT_MSG")?></p>
				        <p align="center">&mdash; -<?=$settings->site_name?></p>
		</div>
	</div>
</div>
</div>

<?php require_once $abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/container_close.php'; //custom template container ?>
<!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->

<?php require_once $abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/footer.php'; //custom template footer?>
