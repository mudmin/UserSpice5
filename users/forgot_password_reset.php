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
require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
$pw_settings = $db->query("SELECT * FROM us_password_strength")->first();
if (!securePage(Server::get('PHP_SELF'))) {
	die();
}

if (isset($user) && $user->isLoggedIn()) {
	Redirect::to($us_url_root . "users/user_settings.php");
}

$error_message = null;
$errors = array();
$reset_password_success = FALSE;
$password_change_form = FALSE;


$token = Input::get('csrf');
if (Input::exists()) {
	if (!Token::check($token)) {
		include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
	}
}

if (Input::get('reset') == 1) { //$_GET['reset'] is set when clicking the link in the password reset email.

	//display the reset form.
	$email = Input::get('email');
	$email = str_replace(" ","+",$email);
	$vericode = Input::get('vericode');
	$user_id = Input::get('user_id');

	// Try to find user by vericode (hashed first, then plaintext fallback)
	$user_id_int = is_numeric($user_id) ? (int)$user_id : null;
	$foundUser = findUserByVericode($vericode, $user_id_int);

	// Fall back to email lookup for backwards compatibility with old links
	if ($foundUser) {
		$ruser = new User($foundUser->id);
		$vericode_valid = true;
	} else {
		$ruser = new User($email);
		// Check if plaintext vericode matches (legacy)
		$vericode_valid = $ruser->exists() && $ruser->data()->vericode == $vericode;
	}

	$eventhooks =  getMyHooks(['page' => 'forgotPasswordResponse']);
	includeHook($eventhooks, 'body');
	if (isset($hookData['ruser'])) {
		$ruser = $hookData['ruser'];
		$vericode_valid = true; // Trust hook override
	}

	if (Input::get('resetPassword')) {
		// Check rate limit before processing
		if (!checkRateLimit('password_reset_submit', null, $email, ['token' => $vericode])) {
			$errors[] = getRateLimitErrorMessage('password_reset_submit');
		} else {
		$newPw = lang("PW_NEW");
		$confPw = lang("PW_CONF");
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'password' => array(
				'display' => $newPw,
				'required' => true,
				'min' => $settings->min_pw,
				'max' => $settings->max_pw,
			),
			'confirm' => array(
				'display' => $confPw,
				'required' => true,
				'matches' => 'password',
			),
		));

		if ($pw_settings->meter_active == 1 && $pw_settings->enforce_rules == 1) {
			$doubleCheckPassword = userSpicePasswordStrength(Input::get('password'));
			if ($doubleCheckPassword['isValid'] == false) {
				//inject error before processing
				$validation->addError([lang("JOIN_INVALID_PW"), 'password']);
			}
		}
		if ($validation->passed()) {
			// Check vericode validity and expiry
			$expired = strtotime($ruser->data()->vericode_expiry) - strtotime(date("Y-m-d H:i:s")) <= 0;
			if (!$vericode_valid || $expired) {
				$msg = lang("REDIR_SOMETHING_WRONG");
				usError($msg);
				handleAuthFailure('password_reset_submit', $ruser->data()->id, $email, ['token' => $vericode]);
				Redirect::to($us_url_root . 'users/forgot_password_reset.php');
			}
			//update password - store hashed vericode
			$newVericode = randomstring(15);
			$ruser->update(array(
				'password' => password_hash(Input::get('password'), PASSWORD_BCRYPT, array('cost' => 13)),
				'vericode' => hashVericode($newVericode),
				'vericode_expiry' => date("Y-m-d H:i:s"),
				'email_verified' => true,
				'force_pr' => 0,
			), $ruser->data()->id);
			$reset_password_success = TRUE;
			logger($ruser->data()->id, "User", "Reset password.");
			handleAuthSuccess('password_reset_submit', $ruser->data()->id, $email, ['token' => $vericode]);
			$eventhooks =  getMyHooks(['page' => 'passwordResetSuccess']);
			includeHook($eventhooks, 'body');
			if ($settings->session_manager == 1) {
				$passwordResetKillSessions = passwordResetKillSessions();
				if (is_numeric($passwordResetKillSessions)) {
					$msg1 = lang("SESS_SUC");
					$msg2 = lang("GEN_SESSION");
					$msg3 = lang("GEN_SESSIONS");
					if ($passwordResetKillSessions == 1) $successes[] = $msg1 . " 1 " . $msg2;
					if ($passwordResetKillSessions > 1) $successes[] = $msg1 . " " . $passwordResetKillSessions . " " . $msg3;
				} else {
					$msg = lang("ERR_FAIL_ACT");
					$errors[] = $msg . " " . $passwordResetKillSessions;
				}
			}
		} else {
			$reset_password_success = FALSE;
			$errors = $validation->errors();
			handleAuthFailure('password_reset_submit', $ruser->data()->id ?? null, $email, ['token' => $vericode]);
			$eventhooks =  getMyHooks(['page' => 'passwordResetFail']);
			includeHook($eventhooks, 'body');
		}
		} // end rate limit check
	}
	if ($ruser->exists() && $vericode_valid) {
		//if the user exists and verification code is correct, show the form
		$password_change_form = TRUE;
	}
}

if ((Input::get('reset') == 1)) {
	if ($reset_password_success) {
		require $abs_us_root . $us_url_root . 'users/views/_forgot_password_reset_success.php';
	} elseif ((!Input::get('resetPassword') || !$reset_password_success) && $password_change_form) {
		require $abs_us_root . $us_url_root . 'users/views/_forgot_password_reset.php';
	} else {
		require $abs_us_root . $us_url_root . 'users/views/_forgot_password_reset_error.php';
	}
} else {
	require $abs_us_root . $us_url_root . 'users/views/_forgot_password_reset_error.php';
}

require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
