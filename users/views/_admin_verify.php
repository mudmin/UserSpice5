<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <ol class="breadcrumb text-right">
          <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
          <li class="active">Verification</li>
        </ol>
      </ol>
    </div>
  </div>
</div>
</div>
<?php
$lang = array_merge($lang,array(
  "ADMIN_VERIFY_NOREF"        => "There is no referrer, you cannot verify yourself. Please return to the Dashboard.",
  "INCORRECT_ADMINPW"         => "Incorrect credential, please try again",
));
$errors = $successes = [];
$form_valid=TRUE;
$current=date("Y-m-d H:i:s");
if(empty($_POST)) {
  $actual_link = Input::get('actual_link');
  $page = Input::get('page');
  if (empty($actual_link) || empty($page)) {
    $actual_link = '';
    $page = '';
    $errors[] = lang("ADMIN_VERIFY_NOREF");
    logger($user->data()->id,"Errors","Admin verify - There is no referrer, you cannot verify yourself.");
    Redirect::to('../index.php');
  }
}
$null=$settings->admin_verify_timeout-1;
if(isset($_SESSION['last_confirm']) && $_SESSION['last_confirm']!='' && !is_null($_SESSION['last_confirm'])) $last_confirm=$_SESSION['last_confirm'];
else $last_confirm=date("Y-m-d H:i:s",strtotime('-'.$null.' day',strtotime(date("Y-m-d H:i:s"))));
$current=date("Y-m-d H:i:s");
$ctFormatted = date("Y-m-d H:i:s", strtotime($current));
$dbPlus = date("Y-m-d H:i:s", strtotime('+'.$settings->admin_verify_timeout.' minutes', strtotime($last_confirm)));
if (strtotime($ctFormatted) < strtotime($dbPlus)){
  Redirect::to(htmlspecialchars_decode($actual_link));
}
if (!empty($_POST)) {
  $token = $_POST['csrf'];
  if(!Token::check($token)){
    include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
  }

  if(!empty($_POST['verifyAdmin'])) {
    $password=Input::get('password');
    $actual_link = Input::get('verify_uri');
    $page = Input::get('verify_page');
    if (password_verify($password,$user->data()->password) || password_verify($password,$user->data()->pin)) {
      $_SESSION['last_confirm']=date("Y-m-d H:i:s");
      logger($user->data()->id,"Admin Verification","Access granted to $page via password verification.");
      unset($_SESSION['reauth_count']);
      if(!empty($actual_link)){
        Redirect::to(htmlspecialchars_decode($actual_link));
      }
    } else {
      $errors[] = lang("INCORRECT_ADMINPW");
      if(isset($_SESSION['reauth_count']) && $_SESSION['reauth_count']==3) {
        logger($user->data()->id,"Admin Verification","3 failed verification attempts, logging out");
        Redirect::to('../users/logout.php');
      }
      if(isset($_SESSION['reauth_count'])) $_SESSION['reauth_count'] = $_SESSION['reauth_count']+1;
      else $_SESSION['reauth_count'] = 2;
      logger($user->data()->id,"Admin Verification","Access denied to $page via password verification due to invalid password.");
    }
  }
}

?>
<div class="content mt-3">
  <div class="row">

    <div class="col-sm-12 col-md-6">
      <?=resultBlock($errors,$successes);?>
      <? if ($actual_link !='') { ?>

        <h2>Restricted Access</h2><br>
        <p><font color='slate'>Please enter your <strong>password</strong> or <strong>PIN</strong> code below to continue</font></p>
        <form class="verify-admin" action="admin.php?view=verify" method="POST">

          <div class="input-group"><input class="form-control" type="password" name="password" id="password" required autofocus>
            <span class="input-group-btn">
              <input class='btn btn-primary' type='submit' name='verifyAdmin' value='Verify' />
            </span></div>
            <input type="hidden" name="verify_uri" value="<?=$actual_link?>" />
            <input type="hidden" name="verify_page" value="<?=$page?>" />
            <input type="hidden" value="<?=Token::generate();?>" name="csrf">
          <? } ?>
        </form><br /><br /><br />
      </div>
    </div>
  </div>
