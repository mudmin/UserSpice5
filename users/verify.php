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
if (!isset($_POST['new']) || $_POST['new'] != 1) {
	@session_destroy();
}
if (isset($user)) {
	unset($user);
}
require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';


$new = Input::get('new');
$email = Input::get('email');
$vericode = Input::get('vericode');
$user_id = Input::get('user_id');

$verify_success = FALSE;

$errors = array();

if (Input::exists('get')) {

	if (is_numeric($user_id)) {
		//this is a passwordless login
        $ts = date("Y-m-d H:i:s");
        if(file_exists($abs_us_root . $us_url_root . 'usersc/scripts/passwordless_login_overrides.php')){
            require_once $abs_us_root . $us_url_root . 'usersc/scripts/passwordless_login_overrides.php';
        }
        if(!isset($do_not_auto_expire) || $do_not_auto_expire != true){
            $db->query("UPDATE us_email_logins set expired = 1 WHERE expired = 0 AND expires < ?", array($ts));
        }
        if(isset($passwordlessDebug) && $passwordlessDebug == true){
            logger($user_id, "Passwordless Debug", "Login Attempt with vericode: $vericode");
            // Log the user agent
            $user_agent = Input::sanitize($_SERVER['HTTP_USER_AGENT']);
            logger($user_id, "Passwordless Debug UA", $user_agent);
        }
		$searchQ = $db->query("SELECT 
			l.*, 
			u.email_verified 
			FROM us_email_logins l 
			LEFT OUTER JOIN users u ON l.user_id = u.id
			WHERE l.user_id = ? 
			AND l.vericode = ? 
			"
			, array($user_id, $vericode));
		$searchC = $searchQ->count();
		if(isset($passwordlessDebug) && $passwordlessDebug == true){
			logger($user_id, "Passwordless Debug", "Vericode Search Count: $searchC");
		}
		if($searchC > 0){
			$search = $searchQ->first();
			if($search->expired == 1){
				if(isset($passwordlessDebug) && $passwordlessDebug == true){
					logger($user_id, "Passwordless Debug", "Login Failed - Expired");
				}
				$eventhooks =  getMyHooks(['page' => 'loginFail']);
				includeHook($eventhooks, 'body');
				usError(lang("VER_FAIL"));
				Redirect::to($us_url_root . 'users/passwordless.php');
			}
		}
		if ($searchC < 1) {
			$fields = [
				'login_method' => 'passwordless',
				'ip' => ipCheck(),
				'ts' => $ts,
			];
			$db->insert('us_login_fails', $fields);
			if(isset($passwordlessDebug) && $passwordlessDebug == true){
				logger($user_id, "Passwordless Debug", "Login Failed");
			}
			$eventhooks =  getMyHooks(['page' => 'loginFail']);
			includeHook($eventhooks, 'body');
			usError(lang("VER_FAIL"));
			
			Redirect::to($us_url_root . 'users/passwordless.php');
		} else {
		
		
			$user = new User($user_id);
			$user->login();
			$hooks =  getMyHooks(['page' => 'loginSuccess']);
			includeHook($hooks, 'body');
			$fields = [
				"success"=>1,
				"login_ip"=>ipCheck(),
				"login_date"=>date("Y-m-d H:i:s"),
			
			];
			if(!isset($do_not_auto_expire) || $do_not_auto_expire != true){
				$fields['expired'] = 1;
			}
			$db->update("us_email_logins",$search->id, $fields);
			if(isset($passwordlessDebug) && $passwordlessDebug == true){
				logger($user_id, "Passwordless Debug", "Login Success");
			}
		
			$dest = sanitizedDest('dest');
			# if user was attempting to get to a page before login, go there
			$_SESSION['last_confirm'] = date("Y-m-d H:i:s");
			if($search->email_verified == 0){
				$db->update("users",$search->id,["email_verified" => 1]);
			}
			if (!empty($dest)) {
				$redirect = Input::get('redirect');
				if (!empty($redirect) || $redirect !== '') Redirect::to(html_entity_decode($redirect));
				else Redirect::to($dest);
			} elseif (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php')) {

				# if site has custom login script, use it
				# Note that the custom_login_script.php normally contains a Redirect::to() call
				require_once $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
			} else {
				if (($dest = Config::get('homepage')) ||
					($dest = 'account.php')
				) {
					Redirect::to($dest);
				}
			}
		}
	}





	$eventhooks =  getMyHooks(['page' => 'verifyEmailAttempt']);
	includeHook($eventhooks, 'body');
	if (!isset($overrideCheck)) {
		$validate = new Validate();
		$validation = $validate->check($_GET, array(
			'email' => array(
				'display' => lang("GEN_EMAIL"),
				'valid_email' => true,
				'required' => true,
			),
		));
	}

	//if email is valid, do this
	if ($validation->passed()) {
		//get the user info based on the email
		if (isset($hookData['overrideEmailVerification'])) {
			//for GDPR email hashing
		} else {
			$eventhooks =  getMyHooks(['page' => 'verifyEmailAttemptPassed']);
			includeHook($eventhooks, 'body');
			if (isset($hookData['verify'])) {
				$verify = $hookData['verify'];
			} else {
				$verify = new User($email);
			}
		}

		if ($verify->data()->email_verified == 1 && $verify->data()->vericode == $vericode && $verify->data()->email_new == "") {
			//email is already verified - Basically if the system already shows the email as verified and they click the link again, we're going to pass it regardless of the expiry because
			//the hassle of telling people verification failed (after previously successful is worse than what could go wrong)
			$eventhooks =  getMyHooks(['page' => 'verifySuccess']);
			includeHook($eventhooks, 'body');
			require $abs_us_root . $us_url_root . 'users/views/_verify_success.php';
		} elseif ($verify->data()->email_verified != 1 && $verify->data()->vericode_expiry == "0000-00-00 00:00:00") {
			//in the unlikely event someone has a blank vericode expiry, we're going to generate a new one
			$vericode_expiry = date("Y-m-d H:i:s", strtotime("+$settings->join_vericode_expiry hours", strtotime(date("Y-m-d H:i:s"))));

			echo lang("ERR_EMAIL_STR");
			$verify->update(array('email_verified' => 0, 'vericode' => randomstring(15), 'vericode_expiry' => $vericode_expiry), $verify->data()->id);
			$eventhooks =  getMyHooks(['page' => 'verifyResend']);
			includeHook($eventhooks, 'body');
			require $abs_us_root . $us_url_root . 'users/views/_verify_resend.php';
		} else {
			if ($verify->exists() && $verify->data()->vericode == $vericode && (strtotime($verify->data()->vericode_expiry) - strtotime(date("Y-m-d H:i:s")) > 0)) {
				//check if this email account exists in the DB

				if ($new == 1 && !$verify->data()->email_new == NULL)	$verify->update(array('email_verified' => 1, 'vericode' => randomstring(15), 'vericode_expiry' => date("Y-m-d H:i:s"), 'email' => $verify->data()->email_new, 'email_new' => NULL), $verify->data()->id);
				else $verify->update(array('email_verified' => 1, 'vericode' => randomstring(15), 'vericode_expiry' => date("Y-m-d H:i:s")), $verify->data()->id);
				$verify_success = TRUE;
				logger($verify->data()->id, "User", "Verification completed via vericode.");
				$msg = str_replace("+", " ", lang("REDIR_EM_SUCC"));
				$eventhooks =  getMyHooks(['page' => 'verifySuccess']);
				includeHook($eventhooks, 'body');
				usSuccess($msg);
				if ($new == 1) {
					Redirect::to($us_url_root . 'users/user_settings.php');
				}
			}
		}
	} else {
		$errors = $validation->errors();
		$eventhooks =  getMyHooks(['page' => 'verifyFail']);
		includeHook($eventhooks, 'body');
	}
}
if ($verify_success) {
	if ($eventhooks =  getMyHooks(['page' => 'verifySuccess'])) {
		includeHook($eventhooks, 'body');
	}

	if (file_exists($abs_us_root . $us_url_root . 'usersc/views/_verify_success.php')) {
		require_once $abs_us_root . $us_url_root . 'usersc/views/_verify_success.php';
	} else {
		require $abs_us_root . $us_url_root . 'users/views/_verify_success.php';
	}
} else {
	if ($eventhooks =  getMyHooks(['page' => 'verifyFail'])) {
		includeHook($eventhooks, 'body');
	}

	if (file_exists($abs_us_root . $us_url_root . 'usersc/views/_verify_error.php')) {
		require_once $abs_us_root . $us_url_root . 'usersc/views/_verify_error.php';
	} else {
		require $abs_us_root . $us_url_root . 'users/views/_verify_error.php';
	}
}

require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
