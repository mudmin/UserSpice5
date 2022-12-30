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
ini_set('allow_url_fopen', 1);
header('X-Frame-Options: DENY');
require_once '../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

$hooks = getMyHooks();

if ($user->isLoggedIn()) {
    Redirect::to($us_url_root.'index.php');
}

includeHook($hooks, 'pre');

$form_method = 'POST';
$form_action = 'join.php';
$vericode = randomstring(15);

//Decide whether or not to use email activation
$act = $db->query('SELECT * FROM email')->first()->email_act;


$form_valid = false;

//If you say in email settings that you do NOT want email activation,
//new users are active in the database, otherwise they will become
//active after verifying their email.
if ($act == 1) {
    $pre = 0;
} else {
    $pre = 1;
}

if (Input::exists()) {
    $token = $_POST['csrf'];
    if (!Token::check($token)) {
        include $abs_us_root.$us_url_root.'usersc/scripts/token_error.php';
    }

    $fname = Input::get('fname');
    $lname = Input::get('lname');
    $email = Input::get('email');
    $username = Input::get('username');


    $validation = new Validate();
        if (pluginActive('userInfo', true)) {
            $is_not_email = false;
        } else {
            $is_not_email = true;
        }

        $validation->check($_POST, [
          'username' => [
                'display' => lang('GEN_UNAME'),
                'is_not_email' => $is_not_email,
                'required' => true,
                'min' => $settings->min_un,
                'max' => $settings->max_un,
                'unique' => 'users',
          ],
          'fname' => [
                'display' => lang('GEN_FNAME'),
                'required' => true,
                'min' => 1,
                'max' => 60,
          ],
          'lname' => [
                'display' => lang('GEN_LNAME'),
                'required' => true,
                'min' => 1,
                'max' => 60,
          ],
          'email' => [
                'display' => lang('GEN_EMAIL'),
                'required' => true,
                'valid_email' => true,
                'unique' => 'users',
                'min' => 5,
                'max' => 100,
          ],

          'password' => [
                'display' => lang('GEN_PASS'),
                'required' => true,
                'min' => $settings->min_pw,
                'max' => $settings->max_pw,
          ],
          'confirm' => [
                'display' => lang('PW_CONF'),
                'required' => true,
                'matches' => 'password',
          ],
        ]);

    if ($eventhooks = getMyHooks(['page' => 'joinAttempt'])) {
        includeHook($eventhooks, 'body');
    }

    if ($validation->passed()) {
            $form_valid = true;
            //add user to the database
            $user = new User();
            $join_date = date('Y-m-d H:i:s');
            $params = [
                      'fname' => Input::get('fname'),
                      'email' => $email,
                      'username' => $username,
                      'vericode' => $vericode,
                      'join_vericode_expiry' => $settings->join_vericode_expiry,
                        ];
            $vericode_expiry = date('Y-m-d H:i:s');

            if ($act == 1) {
                //Verify email address settings
                $to = rawurlencode($email);
                $subject = html_entity_decode($settings->site_name, ENT_QUOTES);
                $body = email_body('_email_template_verify.php', $params);
                email($to, $subject, $body);
                $vericode_expiry = date('Y-m-d H:i:s', strtotime("+$settings->join_vericode_expiry hours", strtotime(date('Y-m-d H:i:s'))));
            }
            try {
                if(isset($_SESSION['us_lang'])){
                  $newLang = $_SESSION['us_lang'];
                }else{
                  $newLang = $settings->default_language;
                }
                $fields = [
                    'username' => $username,
                    'fname' => ucfirst(Input::get('fname')),
                    'lname' => ucfirst(Input::get('lname')),
                    'email' => Input::get('email'),
                    'password' => password_hash(Input::get('password', true), PASSWORD_BCRYPT, ['cost' => 12]),
                    'permissions' => 1,
                    'join_date' => $join_date,
                    'email_verified' => $pre,
                    'vericode' => $vericode,
                    'vericode_expiry' => $vericode_expiry,
                    'oauth_tos_accepted' => true,
                    'language'=>$newLang,
                                ];
                $activeCheck = $db->query('SELECT active FROM users');
                if (!$activeCheck->error()) {
                    $fields['active'] = 1;
                }
                $theNewId = $user->create($fields);

                includeHook($hooks, 'post');
            } catch (Exception $e) {
                if ($eventhooks = getMyHooks(['page' => 'joinFail'])) {
                    includeHook($eventhooks, 'body');
                }
                die($e->getMessage());
            }
            if ($form_valid == true) {
              //this allows the plugin hook to kill the post but it must delete the created user
                include $abs_us_root.$us_url_root.'usersc/scripts/during_user_creation.php';

                if ($act == 1) {
                    logger($theNewId, 'User', 'Registration completed and verification email sent.');

                    Redirect::to($us_url_root . "users/complete.php?action=thank_you_verify");


                } else {
                    logger($theNewId, 'User', 'Registration completed.');
                    if (file_exists($abs_us_root.$us_url_root.'usersc/views/_joinThankYou.php')) {

                        Redirect::to($us_url_root . "users/complete.php?action=thank_you_join");

                    } else {
                        Redirect::to($us_url_root . "users/complete.php?action=thank_you");
                    }

                }
            }

    } //Validation
} //Input exists



if ($settings->registration == 1) {
    if(file_exists($abs_us_root.$us_url_root.'usersc/views/_join.php')){
      require($abs_us_root.$us_url_root.'usersc/views/_join.php');
    }else{
      require $abs_us_root.$us_url_root.'users/views/_join.php';
    }

} else {
  if(file_exists($abs_us_root.$us_url_root.'usersc/views/_joinDisabled.php')){
    require $abs_us_root.$us_url_root.'usersc/views/_joinDisabled.php';
  }else{
    require $abs_us_root.$us_url_root.'users/views/_joinDisabled.php';
  }
}
includeHook($hooks, 'bottom');
?>

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

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
