<?php
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
?>
<?php require_once '../users/init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php'; ?>

<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
$errors = $successes = [];
$validation = new Validate();
$form_valid=TRUE;
$current=date("Y-m-d H:i:s");
if(empty($_POST)) {
  $actual_link = Input::get('actual_link');
  $page = Input::get('page');
  if (empty($actual_link) || empty($page)) {
    $actual_link = '';
    $page = '';
    Redirect::to('../index.php');
  }
}
if(isset($_SESSION['last_confirm']) && $_SESSION['last_confirm']!='' && !is_null($_SESSION['last_confirm'])) $last_confirm=$_SESSION['last_confirm'];
else $last_confirm=date("Y-m-d H:i:s",strtotime("-3 hours",strtotime(date("Y-m-d H:i:s"))));
$ctFormatted = date("Y-m-d H:i:s", strtotime($current));
$dbPlus = date("Y-m-d H:i:s", strtotime('+2 hours', strtotime($last_confirm)));
if (strtotime($ctFormatted) < strtotime($dbPlus)){
  Redirect::to(html_entity_decode($actual_link));
}
if (!empty($_POST)) {
  $token = $_POST['csrf'];
  if(!Token::check($token)){
    include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
  }

  if(!empty($_POST['addPin'])) {
    $pin=Input::get('pin');
    $pin_confirm=Input::get('pin_confirm');
    $actual_link = Input::get('verify_uri');
    $page = Input::get('verify_page');
    $validation->check($_POST,array(
      'pin' => array(
        'display' => 'PIN',
        'required' => true,
        'min' => 4,
        'max' => 10,
        'is_numeric' => true,
      ),
      'pin_confirm' => array(
        'display' => 'Confirm PIN',
        'required' => true,
        'matches' => 'pin',
        'is_numeric' => true,
      ),
    ));
    foreach ($validation->errors() as $error) {
      $errors[] = $error[0];
    }
    if(empty($errors)) {
      $pin_hash = password_hash(Input::get('pin'),PASSWORD_BCRYPT,array('cost' => 12));
      $db->update('users',$user->data()->id,['pin' => $pin_hash]);
      if(!$db->error()) {
        logger($user->data()->id,"Admin Verification","User set PIN Code");
        $_SESSION['last_confirm']=date("Y-m-d H:i:s");
        if(!empty($actual_link)){
          Redirect::to(html_entity_decode($actual_link));
        }
      } else {
        $errors[] = 'There was an error updating the user: '.$db->errorString();
        logger($user->data()->id,"Admin Verification",'Error setting PIN: '.$db->errorString());
      }
    }
  }
}

?>

    <div class="row">
      <?=resultBlock($errors,$successes);?>
      <?php if ($actual_link !='') { ?>
        <div class="col-xs-12 col-md-7">
          <h1>Please select a PIN code</h1>
          <p>PIN Codes are used for verification when accessing administrative pages. Your PIN should be 4-10 digits long.</p>
        </div>

      </div>
      <div class="row">
        <form class="verify-admin" action="" method="POST" id="payment-form">
          <div class="col-md-3">
            <input class="form-control" type="password" name="pin" id="pin" placeholder="Please enter your PIN code" autocomplete="new-password" required autofocus>
          </div>
          <div class="col-md-4">
            <div class="input-group"><input class="form-control" type="password" name="pin_confirm" id="pin_confirm" placeholder="Please confirm your PIN code" autocomplete="new-password">
              <span class="input-group-btn">
                <input class='btn btn-primary' type='submit' name='addPin' value='Save PIN' />
              </span></div>
              <input type="hidden" name="verify_uri" value="<?=$actual_link?>" />
              <input type="hidden" name="verify_page" value="<?=$page?>" />
              <input type="hidden" value="<?=Token::generate();?>" name="csrf">
            <?php } ?>
          </div>
        </div>
      </form>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
