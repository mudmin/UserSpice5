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
if($hooks['bottom'] == []){
  $resize = [];
}else{
  $resize = [];
}
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

$grav = fetchProfilePicture($user->data()->id);
$raw = date_parse($user->data()->join_date);
$signupdate = $raw['month'].'/'.$raw['year'];
if($hooks['bottom'] == []){ //no plugin hooks present
  $resize = [
    'cardClass'=>'col-md-6 offset-md-3',
    'nameSize' =>'style="font-size:3em;"',
    'sinceSize' =>'style="font-size:2.25em;"',
  ];
}else{
  $resize = [
    'cardClass'=>'col-md-3',
    'nameSize' =>'',
    'sinceSize' =>'',
  ];
}
?>

<div class="container">
<div class="row">
  <div class="col-12 <?=$resize['cardClass']?> mt-2 mb-4 p-3 d-flex justify-content-center">
    <div class="card p-4" style="width:100%">
      <div class="image text-center">
        <img src="<?=$grav; ?>" width="60%" alt="Generic placeholder thumbnail">
        <p class="mt-3" <?=$resize['nameSize']?>><span id="fname" class="font-weight-bold fw-bold"><?=$user->data()->fname.' '.$user->data()->lname; ?> </span>
        <br />
        <span class="idd">@<?=$user->data()->username?></span></p>
        <p><a href="<?=$us_url_root?>users/user_settings.php" class="btn btn-primary btn-block mt-3">Edit Info</a></p>

        <?php if (isset($_SESSION['cloak_to'])) { ?>
        <form class="" action="" method="post">
          <input type="hidden" name="uncloak" value="Uncloak!">
          <button class="btn btn-danger btn-block mt-3" role="submit">Uncloak</button>
        </form>
        <?php  } //end cloak button ?>
        <div class="px-2 rounded mt-2" <?=$resize['sinceSize']?>><span class="join small"><?=lang('ACCT_SINCE'); ?>: <?=$signupdate; ?></span> </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-9">
    <?php
    includeHook($hooks, 'bottom');
    ?>
  </div>
</div>
</div>

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
