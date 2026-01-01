<?php
// This is a user-facing page
/*
UserSpice
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

header('X-Frame-Options: DENY');
require_once '../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
$pw_settings = $db->query("SELECT * FROM us_password_strength WHERE id = 1")->first();
if (!isset($pw_settings->meter_active)) {
    $pw_settings->meter_active = 0;
    $pw_settings->enforce_rules = 0;
}
$socials = $db->query("SELECT * FROM plg_social_logins WHERE built_in = 0 ORDER BY `provider`;")->results();
$hooks = getMyHooks();

if ($user->isLoggedIn()) {
    Redirect::to($us_url_root.'index.php');
}

includeHook($hooks, 'pre');

$form_method = 'POST';
$form_action = 'join.php';
$vericode = uniqid().randomstring(15);

//Decide whether or not to use email activation
$act = $db->query('SELECT * FROM email')->first()->email_act;

$form_valid = false;

$allowPasswords = passwordsAllowed($settings->no_passwords);

//If you say in email settings that you do NOT want email activation,
//new users are active in the database, otherwise they will become
//active after verifying their email.
if ($act == 1 || !$allowPasswords) {
    $pre = 0;
} else {
    $pre = 1;
}

if (Input::exists()) {
    $token = $_POST['csrf'];
    if (!Token::check($token)) {
        include $abs_us_root.$us_url_root.'usersc/scripts/token_error.php';
    }

    // Check rate limit for registration attempts before processing
    if (!checkRateLimit('registration_attempt')) {
        $errors[] = getRateLimitErrorMessage('registration_attempt');
        usError(getRateLimitErrorMessage('registration_attempt'));
        Redirect::to(currentPage());
        exit;
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
        $valArray = [
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
        ];
        if($allowPasswords){
            $valArray['password'] = [
                    'display' => lang('PW_PASS'),
                    'required' => true,
                    'min' => $settings->min_pw,
                    'max' => $settings->max_pw,
            ];
            $valArray['confirm'] = [
                    'display' => lang('PW_CONF'),
                    'required' => true,
                    'matches' => 'password',
            ];

        }else{
            $_POST['password'] = randomstring(25);
        }
        $validation->check($_POST, $valArray);

    if ($eventhooks = getMyHooks(['page' => 'joinAttempt'])) {
        includeHook($eventhooks, 'body');
    }

    if($pw_settings->meter_active == 1 && $pw_settings->enforce_rules == 1){
        $doubleCheckPassword = userSpicePasswordStrength(Input::get('password'));
        if($doubleCheckPassword['isValid'] == false){
            //inject error before processing
            $validation->addError([lang("JOIN_INVALID_PW"), 'password']);
        }
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
            
            if($act == 1 || !$allowPasswords){
                $vericode_expiry = date('Y-m-d H:i:s', strtotime("+$settings->join_vericode_expiry hours", strtotime(date('Y-m-d H:i:s'))));
            }else{
                $vericode_expiry = date('Y-m-d H:i:s');
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
                    'password' => password_hash(Input::get('password', true), PASSWORD_BCRYPT, ['cost' => 13]),
                    'permissions' => 1,
                    'join_date' => $join_date,
                    'email_verified' => $pre,
                    'vericode' => $vericode,
                    'vericode_expiry' => $vericode_expiry,
                    'oauth_tos_accepted' => true,
                    'language'=>$newLang,
                    'active'=>1
                    ];

                $theNewId = $user->create($fields);

                // Record successful registration
                handleAuthSuccess('registration_attempt', $theNewId, $email, [], [
                    'username' => $username,
                    'email' => $email,
                    'user_agent' => Server::get('HTTP_USER_AGENT')
                ]);

                includeHook($hooks, 'post');
                if ($act == 1 || !$allowPasswords) {
                    //Verify email address settings
                    $to = rawurlencode($email);
                    $subject = html_entity_decode($settings->site_name, ENT_QUOTES);
                    $body = email_body('_email_template_verify.php', $params);
                    email($to, $subject, $body);

                }
            } catch (Exception $e) {
                // Record failed registration attempt
                handleAuthFailure('registration_attempt', null, $email, [], [
                    'username_attempted' => $username,
                    'email_attempted' => $email,
                    'error' => $e->getMessage(),
                    'user_agent' => Server::get('HTTP_USER_AGENT')
                ]);
                
                if ($eventhooks = getMyHooks(['page' => 'joinFail'])) {
                    includeHook($eventhooks, 'body');
                }
                logger(null, 'Exception Caught', Input::sanitize($e->getMessage())); die("A system error occurred. We apologize for the inconvenience. Logging is available.");
            }
            if ($form_valid == true) {
              //this allows the plugin hook to kill the post but it must delete the created user
                include $abs_us_root.$us_url_root.'usersc/scripts/during_user_creation.php';

                if ($act == 1 || !$allowPasswords) {
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

    }else{
      // Record failed registration attempt
      handleAuthFailure('registration_attempt', null, $email, [], [
          'username_attempted' => $username ?? '',
          'email_attempted' => $email ?? '',
          'validation_errors' => $validation->_errors,
          'user_agent' => Server::get('HTTP_USER_AGENT')
      ]);
      
      foreach($validation->_errors as $e){
        usError($e);

      }
  Redirect::to(currentPage());
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

<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>" type="text/javascript">
    $(document).ready(function(){
        $('.password_view_control').hover(function () {
            $('#password').attr('type', 'text');
            $('#confirm').attr('type', 'text');
        }, function () {
            $('#password').attr('type', 'password');
            $('#confirm').attr('type', 'password');
        });
    });
</script>

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>