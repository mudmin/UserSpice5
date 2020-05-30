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
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
ini_set("allow_url_fopen", 1);
require_once '../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

?>

<?php if (!securePage($_SERVER['PHP_SELF'])){die();}
$hooks =  getMyHooks();
if(ipCheckBan()){Redirect::to($us_url_root.'usersc/scripts/banned.php');die();}
if($user->isLoggedIn()) Redirect::to($us_url_root.'index.php');
if($settings->recaptcha == 1 || $settings->recaptcha == 2){
        //require_once($abs_us_root.$us_url_root."users/includes/recaptcha.config.php");
}
includeHook($hooks,'pre');
//There is a lot of commented out code for a future release of sign ups with payments
$form_method = 'POST';
$form_action = 'join.php';
$vericode = randomstring(15);

$form_valid=FALSE;

//Decide whether or not to use email activation
$query = $db->query("SELECT * FROM email");
$results = $query->first();
$act = $results->email_act;

//Opposite Day for Pre-Activation - Basically if you say in email
//settings that you do NOT want email activation, this lists new
//users as active in the database, otherwise they will become
//active after verifying their email.
if($act==1){
        $pre = 0;
} else {
        $pre = 1;
}

$reCaptchaValid=FALSE;

if(Input::exists()){
  $token = $_POST['csrf'];
  if(!Token::check($token)){
    include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
  }

        $fname = Input::get('fname');
        $lname = Input::get('lname');
        $email = Input::get('email');
        if($settings->auto_assign_un==1) {
          $username=username_helper($fname,$lname,$email);
          if(!$username) $username=NULL;
        } else {
          $username=Input::get('username');
        }

        $validation = new Validate();
        if($settings->auto_assign_un==0) {
        $validation->check($_POST,array(
          'username' => array(
                'display' => lang("GEN_UNAME"),
                'is_not_email' => true,
                'required' => true,
                'min' => $settings->min_un,
                'max' => $settings->max_un,
                'unique' => 'users',
          ),
          'fname' => array(
                'display' => lang("GEN_FNAME"),
                'required' => true,
                'min' => 1,
                'max' => 100,
          ),
          'lname' => array(
                'display' => lang("GEN_LNAME"),
                'required' => true,
                'min' => 1,
                'max' => 100,
          ),
          'email' => array(
                'display' => lang("GEN_EMAIL"),
                'required' => true,
                'valid_email' => true,
                'unique' => 'users',
          ),

          'password' => array(
                'display' => lang("GEN_PASS"),
                'required' => true,
                'min' => $settings->min_pw,
                'max' => $settings->max_pw,
          ),
          'confirm' => array(
                'display' => lang("PW_CONF"),
                'required' => true,
                'matches' => 'password',
          ),
        )); }
        if($settings->auto_assign_un==1) {
          $validation->check($_POST,array(
            'fname' => array(
                  'display' => lang("GEN_FNAME"),
                  'required' => true,
                  'min' => 1,
                  'max' => 60,
            ),
            'lname' => array(
                  'display' => lang("GEN_LNAME"),
                  'required' => true,
                  'min' => 1,
                  'max' => 60,
            ),
            'email' => array(
                  'display' => lang("GEN_EMAIL"),
                  'required' => true,
                  'valid_email' => true,
                  'unique' => 'users',
                  'min' => 5,
                  'max' => 100,
            ),

            'password' => array(
                  'display' => lang("GEN_PASS"),
                  'required' => true,
                  'min' => $settings->min_pw,
                  'max' => $settings->max_pw,
            ),
            'confirm' => array(
                  'display' => lang("PW_CONF"),
                  'required' => true,
                  'matches' => 'password',
            ),
          ));
        }

        if($validation->passed()){
                //Logic if ReCAPTCHA is turned ON
        if($settings->recaptcha > 0){
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
           $form_valid = TRUE;
          }
                } //else for recaptcha

                if($reCaptchaValid || $settings->recaptcha == 0){
                        $form_valid = TRUE;
                        //add user to the database
                        $user = new User();
                        $join_date = date("Y-m-d H:i:s");
                        $params = array(
                                'fname' => Input::get('fname'),
                                'email' => $email,
                                'username' => $username,
                                'vericode' => $vericode,
                                'join_vericode_expiry' => $settings->join_vericode_expiry
                        );
                        $vericode_expiry=date("Y-m-d H:i:s");
                        if($act == 1) {
                                //Verify email address settings
                                $to = rawurlencode($email);
                                $subject = 'Welcome to '.$settings->site_name;
                                $body = email_body('_email_template_verify.php',$params);
                                email($to,$subject,$body);
                                $vericode_expiry=date("Y-m-d H:i:s",strtotime("+$settings->join_vericode_expiry hours",strtotime(date("Y-m-d H:i:s"))));
                        }
                        try {
                                // echo "Trying to create user";
                              $theNewId = $user->create(array(
                                        'username' => $username,
                                        'fname' => ucfirst(Input::get('fname')),
                                        'lname' => ucfirst(Input::get('lname')),
                                        'email' => Input::get('email'),
                                        'password' => password_hash(Input::get('password', true), PASSWORD_BCRYPT, array('cost' => 12)),
                                        'permissions' => 1,
                                        'account_owner' => 1,
                                        'join_date' => $join_date,
                                        'email_verified' => $pre,
                                        'active' => 1,
                                        'vericode' => $vericode,
                                        'vericode_expiry' => $vericode_expiry,
                                        'oauth_tos_accepted' => true
                                ));
                        includeHook($hooks,'post');
                        } catch (Exception $e) {
                                die($e->getMessage());
                        }
                        if($form_valid == TRUE){ //this allows the plugin hook to kill the post but it must delete the created user
                        if($settings->twofa == 1){
                        $twoKey = $google2fa->generateSecretKey();
                        $db->update('users',$theNewId,['twoKey' => $twoKey]);
                        }
                        include($abs_us_root.$us_url_root.'usersc/scripts/during_user_creation.php');

                        if($act == 1) {
                          logger($theNewId,"User","Registration completed and verification email sent.");
                          $query = $db->query("SELECT * FROM email");
                          $results = $query->first();
                          $act = $results->email_act;
                          require $abs_us_root.$us_url_root.'users/views/_joinThankYou_verify.php';
                        }else{
                          logger($theNewId,"User","Registration completed.");
                          if(file_exists($abs_us_root.$us_url_root.'usersc/views/_joinThankYou.php')){
                            require_once $abs_us_root.$us_url_root.'usersc/views/_joinThankYou.php';
                          }else{
                            require $abs_us_root.$us_url_root.'users/views/_joinThankYou.php';
                          }
                        }
                        die();

                }
              }
        } //Validation
} //Input exists

?>
<?php header('X-Frame-Options: DENY'); ?>
<div id="page-wrapper">
<div class="container">
<?php
if($settings->registration==1) {
  require $abs_us_root.$us_url_root.'users/views/_join.php';
}
else {
  require $abs_us_root.$us_url_root.'users/views/_joinDisabled.php';
}
includeHook($hooks,'bottom');
?>

</div>
</div>

<!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<?php if($settings->recaptcha > 0){ ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    function submitForm() {
        document.getElementById("payment-form").submit();
    }
</script>
<?php } ?>
<?php if($settings->auto_assign_un==0) { ?>

<?php } ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#password_view_control').hover(function () {
            $('#password').attr('type', 'text');
            $('#confirm').attr('type', 'text');
        }, function () {
            $('#password').attr('type', 'password');
            $('#confirm').attr('type', 'password');
        });
    });
</script>



<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
