<?php
/*
This is a user-facing page
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
    <h2><?=lang("EML_VER");?></h2>
    <ol>
      <li><?=lang("VER_AGAIN");?></li>
      <?=lang("VER_PAGE");?>
    </ol>
    <form class="" action="" method="post">
      <?php if(!$errors=='') { display_errors($errors); } ?>
      <div class="form-group">
        <label for=""><?=lang("GEN_EMAIL");?></label><br>
        <input class="form-control" type="text" id="email" name="email" >
      </div>
      <input type="hidden" name="csrf" value="<?=Token::generate();?>">
      <input type="submit" value="<?=lang("VER_RESEND");?>" class="btn btn-primary">
    </form><br />
  </div>
</div>
