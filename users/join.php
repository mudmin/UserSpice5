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
        $agreement_checkbox = Input::get('agreement_checkbox');

        if ($agreement_checkbox=='on'){
                $agreement_checkbox=TRUE;
        }else{
          if($settings->show_tos == 1){
                $agreement_checkbox=FALSE;
          }else{
            $agreement_checkbox=TRUE;
          }
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

        //if the agreement_checkbox is not checked, add error
        if (!$agreement_checkbox){
                $validation->addError([lang("ERR_TC")]);
        }

        if($validation->passed() && $agreement_checkbox){
                //Logic if ReCAPTCHA is turned ON
        if($settings->recaptcha == 1 || $settings->recaptcha == 2){
                        //require_once($abs_us_root.$us_url_root."users/includes/recaptcha.config.php");
                        //reCAPTCHA 2.0 check
                        $response = null;

                        // check secret key
                        $reCaptcha = new \ReCaptcha\ReCaptcha($settings->recap_private);

                        // if submitted check response
                        if ($_POST["g-recaptcha-response"]) {
                                $response = $reCaptcha->verify($_POST["g-recaptcha-response"],$_SERVER["REMOTE_ADDR"]);
                        }
                        if ($response != null && $response->isSuccess()) {
                                // account creation code goes here
                                $reCaptchaValid=TRUE;
                                $form_valid=TRUE;
                        }else{
                                $reCaptchaValid=FALSE;
                                $form_valid=FALSE;
                                $validation->addError([lang("ERR_CAP")]);
                                $reCapErrors = $response->getErrorCodes();
                                // $count=0;
                                foreach($reCapErrors as $error) {
                                  // if($count==0) $error_message = $error;
                                  // else $error_message .= "<br>".$error;
                                  logger(1,"Recapatcha","Error with reCaptcha: ".$error);
                                }
                        }

                } //else for recaptcha

                if($reCaptchaValid || $settings->recaptcha == 0){

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
                        if($settings->twofa == 1){
                        $twoKey = $google2fa->generateSecretKey();
                        $db->update('users',$theNewId,['twoKey' => $twoKey]);
                        }
                        include($abs_us_root.$us_url_root.'usersc/scripts/during_user_creation.php');
                        if($act==1) logger($theNewId,"User","Registration completed and verification email sent.");
                        if($act==0) logger($theNewId,"User","Registration completed.");
                        Redirect::to($us_url_root.'users/joinThankYou.php');
                }

        } //Validation and agreement checbox
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

<?php if($settings->recaptcha == 1 || $settings->recaptcha == 2){ ?>
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
