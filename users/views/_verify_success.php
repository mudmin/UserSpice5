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
// Auto-login if passwords are not allowed (either fully disabled or localhost-only and not on localhost)
if(!passwordsAllowed($settings->no_passwords)){
$user = $verify;
$user->login();
$abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
Redirect::to($us_url_root . $settings->redirect_uri_after_login);
}
?>
<div class="row">
  <div class="col-sm-12">
    <h2><?=lang("VER_SUC");?></h2>
    <a href="login.php" class="btn btn-primary"><?=lang("SIGNIN_BUTTONTEXT");?></a>
    <br />
  </div>
</div>
