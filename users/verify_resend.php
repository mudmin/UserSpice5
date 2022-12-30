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

//this is an event hook (v5.3.8+) to allow hashing of emails in the db


$query = $db->query("SELECT * FROM email");
$results = $query->first();
$act = $results->email_act;
$msg = lang("ERR_EM_VER");

if($act!=1){
  usError($msg);
  Redirect::to($us_url_root.'index.php');
}

if($user->isLoggedIn()) $user->logout();

$token = Input::get('csrf');
if(Input::exists()){
    if(!Token::check($token)){
        include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
    }
}

$email_sent=FALSE;

$errors = array();
if(Input::exists('post')){

    $hooks = getMyHooks(['page'=>'verifyResendSubmit']);
    includeHook($hooks,'body');

    if(!isset($hookData['overrideEmailVerification'])){
      $email = Input::get('email');
      $fuser = new User($email);
      $check = $db->query("SELECT id FROM users WHERE email = ? AND email_verified = 1",[$email])->count();
      $validate = new Validate();
      $validation = $validate->check($_POST,array(
      'email' => array(
        'display' => lang("GEN_EMAIL"),
        'valid_email' => true,
        'required' => true,
      ),
      ));
    }else{
      $fields = ["validation","fuser","check","email"];
      foreach($fields as $f){
        if(isset($hookData[$f])){
          $$f = $hookData[$f];
        }
      }

    }

    if($validation->passed()){ //if email is valid, do this

        if($fuser->exists()){
          if($check > 0){
            $string = lang("VER_SUC");
            usSuccess($string);
            Redirect::to($us_url_root."users/login.php");
          }
          $vericode=randomstring(15);
          $vericode_expiry=date("Y-m-d H:i:s",strtotime("+$settings->join_vericode_expiry hours",strtotime(date("Y-m-d H:i:s"))));
          $db->update('users',$fuser->data()->id,['vericode' => $vericode,'vericode_expiry' => $vericode_expiry]);
            //send the email
            $options = array(
              'fname' => $fuser->data()->fname,
              'email' => $email,
              'vericode' => $vericode,
              'join_vericode_expiry' => $settings->join_vericode_expiry
            );
            $encoded_email=rawurlencode($email);
            $subject = lang("EML_VER");
            $body =  email_body('_email_template_verify.php',$options);
            $email_sent=email($email,$subject,$body);
            logger($fuser->data()->id,"User","Requested a new verification email.");
            if(!$email_sent){
                $errors[] = lang("ERR_EMAIL");
            }
        }else{
            $errors[] = lang("ERR_EM_DB");
        }
    }else{
        $errors = $validation->errors();
    }
}

if ($email_sent){
    require $abs_us_root.$us_url_root.'users/views/_verify_resend_success.php';
}else{
    require $abs_us_root.$us_url_root.'users/views/_verify_resend.php';
}

require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
