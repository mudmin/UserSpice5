<?php
/*
this is a user-facing page
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
?>
<div class="row">
	<div class="col-sm-12">
		<h2><?=lang("PW_RESET");?></h2>
		<ol>
			<?=lang("VER_INS");?>
		</ol>
		<?php if(!$errors=='') { display_errors($errors); } ?>
		<form action="" method="post" class="form " id="pwReset">

			<div class="form-group">
				<label for="email"><?=lang("GEN_EMAIL");?></label>
				<input type="text" name="email" placeholder="<?=lang("GEN_EMAIL");?>" class="form-control" autofocus autocomplete='email'>
			</div>

			<input type="hidden" name="csrf" value="<?=Token::generate();?>">
			<p><input type="submit" name="forgotten_password" value="<?=lang("GEN_RESET");?>" class="btn btn-primary"></p>
		</form>

	</div><!-- /.col -->
</div><!-- /.row -->
