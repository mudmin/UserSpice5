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
ini_set("allow_url_fopen", 1);
if(isset($_SESSION)){session_destroy();}
require_once '../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
$hooks =  getMyHooks();
includeHook($hooks,'pre');
if($settings->twofa == 1){
  $google2fa = new PragmaRX\Google2FA\Google2FA();
}
?>
<?php
if(ipCheckBan()){Redirect::to($us_url_root.'usersc/scripts/banned.php');die();}
$errors = [];
$successes = [];
if (@$_REQUEST['err']) $errors[] = $_REQUEST['err']; // allow redirects to display a message
$reCaptchaValid=FALSE;
if($user->isLoggedIn()) Redirect::to($us_url_root.'index.php');

if (!empty($_POST['login_hook'])) {
  $token = Input::get('csrf');
  if(!Token::check($token)){
    include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
  }

  //Check to see if recaptcha is enabled
  if($settings->recaptcha == 1){
  if(!function_exists('post_captcha')){
    function post_captcha($user_response) {
    global $settings;
    $fields_string = '';
    $fields = array(
        'secret' => $settings->recap_private,
        'response' => $user_response
    );
    foreach($fields as $key=>$value)
    $fields_string .= $key . '=' . $value . '&';
    $fields_string = rtrim($fields_string, '&');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}
}

// Call the function post_captcha
$res = post_captcha($_POST['g-recaptcha-response']);

if (!$res['success']) {
    // What happens when the reCAPTCHA is not properly set up
    echo 'reCAPTCHA error: Check to make sure your keys match the registered domain and are in the correct locations. You may also want to doublecheck your code for typos or syntax errors.';
}else{
 $reCaptchaValid=TRUE;
}
}
  if($reCaptchaValid || $settings->recaptcha == 0 || $settings->recaptcha == 2 ){ //if recaptcha valid or recaptcha disabled

    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      'username' => array('display' => 'Username','required' => true),
      'password' => array('display' => 'Password', 'required' => true)));
      //plugin goes here with the ability to kill validation
      includeHook($hooks,'post');
      if ($validation->passed()) {
        //Log user in
        $remember = (Input::get('remember') === 'on') ? true : false;
        $user = new User();
        $login = $user->loginEmail(Input::get('username'), trim(Input::get('password')), $remember);
        if ($login) {
          $dest = sanitizedDest('dest');
              # if user was attempting to get to a page before login, go there
              $_SESSION['last_confirm']=date("Y-m-d H:i:s");

              if (!empty($dest)) {
                $redirect=htmlspecialchars_decode(Input::get('redirect'));
                if(!empty($redirect) || $redirect!=='') Redirect::to($redirect);
                else Redirect::to($dest);
              } elseif (file_exists($abs_us_root.$us_url_root.'usersc/scripts/custom_login_script.php')) {

                # if site has custom login script, use it
                # Note that the custom_login_script.php normally contains a Redirect::to() call
                require_once $abs_us_root.$us_url_root.'usersc/scripts/custom_login_script.php';
              } else {
                if (($dest = Config::get('homepage')) ||
                ($dest = 'account.php')) {
                  #echo "DEBUG: dest=$dest<br />\n";
                  #die;
                  Redirect::to($dest);
                }
              }

          } else {
            $msg = lang("SIGNIN_FAIL");
            $msg2 = lang("SIGNIN_PLEASE_CHK");
            $errors[] = '<strong>'.$msg.'</strong>'.$msg2;
          }
        }
      }
    }
    if (empty($dest = sanitizedDest('dest'))) {
      $dest = '';
    }
    $token = Token::generate();
    ?>
    <div id="page-wrapper">
      <div class="container">
        <?=resultBlock($errors,$successes);?>
        <div class="row">
          <div class="col-sm-12">
            <?php
            includeHook($hooks,'body');
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <form name="login" id="login-form" class="form-signin" action="login.php" method="post">
              <h2 class="form-signin-heading"></i> <?=lang("SIGNIN_TITLE","");?></h2>
              <input type="hidden" name="dest" value="<?= $dest ?>" />

              <div class="form-group">
                <label for="username" id="username-label" ><?=lang("SIGNIN_UORE")?></label>
                <input  class="form-control" type="text" name="username" id="username" placeholder="<?=lang("SIGNIN_UORE")?>" required autofocus autocomplete="username">
              </div>

              <div class="form-group">
                <label for="password" id="password-label"><?=lang("SIGNIN_PASS")?></label>
                <input type="password" class="form-control"  name="password" id="password"  placeholder="<?=lang("SIGNIN_PASS")?>" required autocomplete="current-password">
              </div>
              <?php   includeHook($hooks,'form');?>
              <div class="form-group">
                <label for="remember">
                  <input type="checkbox" name="remember" id="remember" > <?=lang("SIGNIN_REMEMBER")?></label>
                </div>
                <input type="hidden" name="login_hook" value="1">
                <input type="hidden" name="csrf" value="<?=$token?>">
                <input type="hidden" name="redirect" value="<?=Input::get('redirect')?>" />
                <button class="submit  btn  btn-primary" id="next_button" type="submit"><i class="fa fa-sign-in"></i> <?=lang("SIGNIN_BUTTONTEXT","");?></button>
                <?php
                if($settings->recaptcha == 1){
                  ?>
                  <div class="g-recaptcha" data-sitekey="<?=$settings->recap_public; ?>" data-bind="next_button" data-callback="submitForm"></div>
                <?php } ?>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6"><br>
              <a class="pull-left" href='../users/forgot_password.php'><i class="fa fa-wrench"></i> <?=lang("SIGNIN_FORGOTPASS","");?></a>
              <br><br>
            </div>
            <?php if($settings->registration==1) {?>
              <div class="col-sm-6"><br>
                <a class="pull-right" href='../users/join.php'><i class="fa fa-plus-square"></i> <?=lang("SIGNUP_TEXT","");?></a><br><br>
              </div><?php } ?>
              <?php   includeHook($hooks,'bottom');?>
                <?php languageSwitcher();?>
            </div>
          </div>
        </div>

        <?php require_once $abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/container_close.php'; //custom template container ?>

        <!-- footers -->
        <?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

        <!-- Place any per-page javascript here -->

        <?php   if($settings->recaptcha == 1){ ?>
          <script src="https://www.google.com/recaptcha/api.js" async defer></script>
          <script>
          function submitForm() {
            document.getElementById("login-form").submit();
          }
          </script>
        <?php } ?>
        <?php require_once $abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/footer.php'; //custom template footer?>
