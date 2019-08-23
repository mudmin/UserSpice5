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

if (!securePage($_SERVER['PHP_SELF'])){die();}

if(ipCheckBan()){Redirect::to($us_url_root.'usersc/scripts/banned.php');die();}
$error_message = null;
$errors = array();
$email_sent=FALSE;

$token = Input::get('csrf');
if(Input::exists()){
    if(!Token::check($token)){
        include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
    }
}

if (Input::get('forgotten_password')) {
    $email = Input::get('email');
    $fuser = new User($email);
    //validate the form
    $validate = new Validate();
    $msg1 = lang("GEN_EMAIL");
    $validation = $validate->check($_POST,array('email' => array('display' => $msg1,'valid_email' => true,'required' => true,),));

    if($validation->passed()){
        if($fuser->exists()){
          $vericode=randomstring(15);
          $vericode_expiry=date("Y-m-d H:i:s",strtotime("+$settings->reset_vericode_expiry minutes",strtotime(date("Y-m-d H:i:s"))));
          $db->update('users',$fuser->data()->id,['vericode' => $vericode,'vericode_expiry' => $vericode_expiry]);
            //send the email
            $options = array(
              'fname' => $fuser->data()->fname,
              'email' => rawurlencode($email),
              'vericode' => $vericode,
              'reset_vericode_expiry' => $settings->reset_vericode_expiry
            );
            $subject = lang("PW_RESET");
            $encoded_email=rawurlencode($email);
            $body =  email_body('_email_template_forgot_password.php',$options);
            $email_sent=email($email,$subject,$body);
            logger($fuser->data()->id,"User","Requested password reset.");
            if(!$email_sent){
                $errors[] = lang("ERR_EMAIL");
            }
        }else{
            $errors[] = lang("ERR_EM_DB");
        }
    }else{
        //display the errors
        $errors = $validation->errors();
    }
}
?>
<?php
if ($user->isLoggedIn()) $user->logout();
?>

<div id="page-wrapper">
<div class="container">
<?php

if($email_sent){
    require $abs_us_root.$us_url_root.'users/views/_forgot_password_sent.php';
}else{
    require $abs_us_root.$us_url_root.'users/views/_forgot_password.php';
}

?>
</div><!-- /.container-fluid -->
</div><!-- /#page-wrapper -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!-- footer -->
<!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
