<?php
/*
Do not put any content above the opening PHP tag
TO CREATE A NEW LANGUAGE, COPY THE en-us.php to your own localization code name.
We are going to keep these files in the iso xx-xx format because that will also
allow us to autoformat numbers on the sites.

PLEASE put your name somewhere at the top of the language file so we can get in touch with
you to update it and thank you for your hard work!

PLEASE NOTE: DO NOT ADD RANDOM KEYS in the middle of the translations.  In order to make it easier to tell what language keys are missing, from this point forward, we are going to add all new language keys at the BOTTOM of this file. The number of lines in your language file will tell you which keys still need to be translated.  If you have questions please ask on the forums or on Discord.

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

/*
%m1% - Dymamic markers which are replaced at run time by the relevant index.
*/

$lang = array();
//important strings
$lang = array_merge($lang,array(
"THIS_LANGUAGE"	=>"Canadian",
"THIS_CODE"			=>"en-CA",
"MISSING_TEXT"	=>"Text is down the biffy",
));
//Database Menus
$lang = array_merge($lang,array(
"MENU_HOME"			=> "Home, eh?",
"MENU_HELP"			=> "Help, eh?",
"MENU_ACCOUNT"	=> "Account, eh?",
"MENU_DASH"			=> "Admin Dashboard, eh?",
"MENU_USER_MGR"	=> "Ooooser Management",
"MENU_PAGE_MGR"	=> "Page Management, eh?",
"MENU_PERM_MGR"	=> "Permissions Management, eh?",
"MENU_MSGS_MGR"	=> "Messages Manager, eh?",
"MENU_LOGS_MGR"	=> "System Logs, eh?",
"MENU_LOGOUT"		=> "Logout, eh?",
));

// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"					=> "Register, eh?",
	"SIGNUP_BUTTONTEXT"		=> "Register Me, eh?",
	"SIGNUP_AUDITTEXT"		=> "Registered, eh?",
	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"				=> "** FAILED LOGIN **, eh?",
	"SIGNIN_PLEASE_CHK" => "Please check your username and password and try again, eh?",
	"SIGNIN_UORE"				=> "Username OR Email, eh?",
	"SIGNIN_PASS"				=> "Password, eh?",
	"SIGNIN_TITLE"			=> "Please Log In, eh?",
	"SIGNIN_TEXT"				=> "Log In, eh?",
	"SIGNOUT_TEXT"			=> "Log Out, eh?",
	"SIGNIN_BUTTONTEXT"	=> "Login, eh?",
	"SIGNIN_REMEMBER"		=> "Remember Me, eh?",
	"SIGNIN_AUDITTEXT"	=> "Logged In, eh?",
	"SIGNIN_FORGOTPASS"	=>"Forgot Password, eh?",
	"SIGNOUT_AUDITTEXT"	=> "Logged Out, eh?",
	));

// Account Page
$lang = array_merge($lang,array(
	"ACCT_EDIT"					=> "Edit Account Info, eh?",
	"ACCT_2FA"					=> "Manage 2 Factor Authentication, eh?",
	"ACCT_SESS"					=> "Manage Sessions, eh?",
	"ACCT_HOME"					=> "Account Home, eh?",
	"ACCT_SINCE"				=> "Member Since, eh?",
	"ACCT_LOGINS"				=> "Number of Logins, eh?",
	"ACCT_SESSIONS"			=> "Number of Active Sessions, eh?",
	"ACCT_MNG_SES"			=> "Click the Manage Sessions button in the left sidebar for more information., eh?",
	));

	//General Terms
	$lang = array_merge($lang,array(
		"GEN_ENABLED"			=> "Enabled, eh?",
		"GEN_DISABLED"		=> "Disabled, eh?",
		"GEN_ENABLE"			=> "Enable, eh?",
		"GEN_DISABLE"			=> "Disable, eh?",
		"GEN_NO"					=> "No, eh?",
		"GEN_YES"					=> "Yes, eh?",
		"GEN_MIN"					=> "min, eh?",
		"GEN_MAX"					=> "max, eh?",
		"GEN_CHAR"				=> "char, eh?", //as in characters
		"GEN_SUBMIT"			=> "Submit, eh?",
		"GEN_MANAGE"			=> "Manage, eh?",
		"GEN_VERIFY"			=> "Verify, eh?",
		"GEN_SESSION"			=> "Session, eh?",
		"GEN_SESSIONS"		=> "Sessions, eh?",
		"GEN_EMAIL"				=> "Email, eh?",
		"GEN_FNAME"				=> "First Name, eh?",
		"GEN_LNAME"				=> "Last Name, eh?",
		"GEN_UNAME"				=> "Username, eh?",
		"GEN_PASS"				=> "Password, eh?",
		"GEN_MSG"					=> "Message, eh?",
		"GEN_TODAY"				=> "Today, eh?",
		"GEN_CLOSE"				=> "Close, eh?",
		"GEN_CANCEL"			=> "Cancel, eh?",
		"GEN_CHECK"				=> "[ check/uncheck all ], eh?",
		"GEN_WITH"				=> "with, eh?",
		"GEN_UPDATED"			=> "Updated, eh?",
		"GEN_UPDATE"			=> "Update, eh?",
		"GEN_BY"					=> "by, eh?",
		"GEN_ENABLE"			=> "Enable, eh?",
		"GEN_DISABLE"			=> "Disable, eh?",
		"GEN_FUNCTIONS"		=> "Functions, eh?",
		"GEN_NUMBER"			=> "number, eh?",
		"GEN_NUMBERS"			=> "numbers, eh?",
		"GEN_INFO" 				=> "Information, Please",
		"GEN_REC" 				=> "Recorded, with Permission",
		"GEN_DEL" 				=> "Delete,S'il vous plaît",
		"GEN_NOT_AVAIL" 	=> "Not Available, eh",
		"GEN_AVAIL" 			=> "Available at Canadian Tire",
		"GEN_BACK" 				=> "Back, eh?",
		"GEN_RESET" 			=> "Reset, Please",
		"GEN_REQ"					=> "required",
		"GEN_AND"					=> "and",
		"GEN_SAME"				=> "must be the same",
		));

//validation class
	$lang = array_merge($lang,array(
		"VAL_SAME"				=> "must be the same",
		"VAL_EXISTS"			=> "already exists. Please choose another",
		"VAL_DB"					=> "Database Error",
		"VAL_NUM"					=> "must be a number",
		"VAL_INT"					=> "must be a whole number",
		"VAL_EMAIL"				=> "must be a valid email addresss",
		"VAL_NO_EMAIL"		=> "cannot be an email addresss",
		"VAL_SERVER"			=> "must belong to a valid server",
		"VAL_LESS"				=> "must be less than",
		"VAL_GREAT"				=> "must be greater than",
		"VAL_LESS_EQ"			=> "must be less than or equal to",
		"VAL_GREAT_EQ"		=> "must be greater than or equal to",
		"VAL_NOT_EQ"			=> "must not be equal to",
		"VAL_EQ"					=> "must be equal to",
		"VAL_TZ"					=> "has to be a valid time zone name",
		"VAL_MUST"				=> "must be",
		"VAL_MUST_LIST"		=> "must be one of the following",
		"VAL_TIME"				=> "must be a valid time",
		"VAL_SEL"					=> "is not a valid selection",
		"VAL_NA_PHONE"		=> "must be a valid North American phone number",
	));
		//Time
	$lang = array_merge($lang,array(
		"T_YEARS"			=> "Years, eh?",
		"T_YEAR"			=> "Year, eh?",
		"T_MONTHS"		=> "Months, eh?",
		"T_MONTH"			=> "Month, eh?",
		"T_WEEKS"			=> "Weeks, eh?",
		"T_WEEK"			=> "Week, eh?",
		"T_DAYS"			=> "Days, eh?",
		"T_DAY"				=> "Day, eh?",
		"T_HOURS"			=> "Hours, eh?",
		"T_HOUR"			=> "Hour, eh?",
		"T_MINUTES"		=> "Minutes, eh?",
		"T_MINUTE"		=> "Minute, eh?",
		"T_SECONDS"		=> "Seconds, eh?",
		"T_SECOND"		=> "Second, eh?",
		));


		//Passwords
	$lang = array_merge($lang,array(
		"PW_NEW"		=> "New Password, eh?",
		"PW_OLD"		=> "Old Password, eh?",
		"PW_CONF"		=> "Confirm Password, eh?",
		"PW_RESET"	=> "Password Reset, eh?",
		"PW_UPD"		=> "Password Updated, eh?",
		"PW_SHOULD"	=> "Passwords Should..., eh?",
		"PW_SHOW"		=> "Show Password, eh?",
		"PW_SHOWS"	=> "Show Passwords, eh?",
		));


		//Join
	$lang = array_merge($lang,array(
		"JOIN_SUC"		=> "Tim Hortons presents",
		"JOIN_THANKS"	=> "Thanks for registering!, eh?",
		"JOIN_HAVE"		=> "Have at least , eh?",
		"JOIN_CAP"		=> " capital letter, eh?",
		"JOIN_TWICE"	=> "Be typed correctly twice, eh?",
		"JOIN_CLOSED"	=> "Unfortunately registration is disabled at this time. Please contact the Site Administrator if you have any questions or concerns., eh?",
		"JOIN_TC"			=> "Registration User Terms and Conditions, eh?",
		"JOIN_ACCEPTTC" => "I Absolootley Accept User Terms and Conditions,",
		"JOIN_CHANGED"	=> "Our Terms Have Changed",
		"JOIN_ACCEPT" 	=> "Oookey Dookie",
		));

		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "Successfully killed , eh?",
		));

		//Messages
	$lang = array_merge($lang,array(
		"MSG_SENT"			=> "Your message has been sent!, eh?",
		"MSG_MASS"			=> "Your mass message has been sent!, eh?",
		"MSG_NEW"				=> "New Message, eh?",
		"MSG_NEW_MASS"	=> "New Mass Message, eh?",
		"MSG_CONV"			=> "Conversations, eh?",
		"MSG_NO_CONV"		=> "No Conversations, eh?",
		"MSG_NO_ARC"		=> "No Conversations, eh?",
		"MSG_QUEST"			=> "Send Email Notification if Enabled?, eh?",
		"MSG_ARC"				=> "Archived Threads, eh?",
		"MSG_VIEW_ARC"	=> "View Archived Threads, eh?",
		"MSG_SETTINGS"  => "Message Settings, eh?",
		"MSG_READ"			=> "Read, eh?",
		"MSG_BODY"			=> "Body, eh?",
		"MSG_SUB"				=> "Subject, eh?",
		"MSG_DEL"				=> "Delivered, eh?",
		"MSG_REPLY"			=> "Reply, eh?",
		"MSG_QUICK"			=> "Quick Reply, eh?",
		"MSG_SELECT"		=> "Select a user, eh?",
		"MSG_UNKN"			=> "Unknown Recipient, eh?",
		"MSG_NOTIF"			=> "Message Email Notifications, eh?",
		"MSG_BLANK"			=> "Message cannot be blank, eh?",
		"MSG_MODAL"			=> "Click here or press Alt + R to focus on this box OR press Shift + R to open the expanded reply pane!, eh?",
		"MSG_ARCHIVE_SUCCESSFUL"        => "You have successfully archived %m1% threads, eh?",
		"MSG_UNARCHIVE_SUCCESSFUL"      => "You have successfully unarchived %m1% threads, eh?",
		"MSG_DELETE_SUCCESSFUL"         => "You have successfully deleted %m1% threads, eh?",
		"USER_MESSAGE_EXEMPT"         			=> "User is %m1% exempted from messages., eh?",
		"MSG_MK_READ" => "Read",
		"MSG_MK_UNREAD" => "Unread",
		"MSG_ARC_THR" => "Send unwanted threads to America",
		"MSG_UN_THR" => "Unarchive Selected Threads, eh?",
		"MSG_DEL_THR" => "Delete Selected Threads and Apologize",
		"MSG_SEND" => "Send Message to Timmy Ho",
		));

	//2 Factor Authentication
	$lang = array_merge($lang,array(
		"2FA"				=> "2 Factor Authentication, eh?",
		"2FA_CONF"	=> "Are you sure you want to disable 2FA? Your account will no longer be protected., eh?",
		"2FA_SCAN"	=> "Scan this QR code with your authenticator app or input the key, eh?",
		"2FA_THEN"	=> "Then enter one of your one-time passkeys here, eh?",
		"2FA_FAIL"	=> "There was a problem verifying 2FA. Please check Internet or contact support., eh?",
		"2FA_CODE"	=> "2FA Code, eh?",
		"2FA_EXP"		=> "Expired 1 fingerprint, eh?",
		"2FA_EXPD"	=> "Expired, eh?",
		"2FA_FP"		=> "Fingerprints, eh?",
		"2FA_NP"		=> "<strong>Login Failed</strong> Two Factor Auth Code was not present. Please try again., eh?",
		"2FA_INV"		=> "<strong>Login Failed</strong> Two Factor Auth Code was invalid. Please try again., eh?",
		"2FA_FATAL"	=> "<strong>Fatal Error</strong> Please contact System Admin., eh?",
		"2FA_EXPS" 	=> "Expires, eh?",
		"2FA_ACTIVE"=> "Active Mooses",
		"2FA_NOT_FN"=> "No Moose Prints Found",
		));

	//Redirect Messages - These get a plus between each word
	$lang = array_merge($lang,array(
		"REDIR_2FA"						=> "Sorry.Two+factor+is+not+enabled+at+this+time, eh?",
		"REDIR_2FA_EN"				=> "2+Factor+Authentication+Enabled, eh?",
		"REDIR_2FA_DIS"				=> "2+Factor+Authentication+Disabled, eh?",
		"REDIR_2FA_VER"				=> "2+Factor+Authentication+Verified+and+Enabled, eh?",
		"REDIR_SOM_TING_WONG" => "Something+went+wrong.+Please+try+again., eh?",
		"REDIR_MSG_NOEX"			=> "That+thread+does+not+belong+to+you+or+does+not+exist., eh?",
		"REDIR_UN_ONCE"				=> "Username+has+already+been+changed+once., eh?",
		"REDIR_EM_SUCC"				=> "Email+Updated+Successfully, eh?",
		));

	//Emails
	$lang = array_merge($lang,array(
		"EML_CONF"			=> "Confirm Email, eh?",
		"EML_VER"				=> "Verify Your Email, eh?",
		"EML_CHK"				=> "Email request received. Please check your email to perform verification. Be sure to check your Spam and Junk folder as the verification link expires in , eh?",
		"EML_MAT"				=> "Your email did not match., eh?",
		"EML_HELLO"			=> "Hello from , eh?",
		"EML_HI"				=> "Hi ",
		"EML_AD_HAS"		=> "An Administrator has reset your password.",
		"EML_AC_HAS"		=> "An Administrator has created your account.",
		"EML_REQ"				=> "You will be required to set your password using the link above.",
		"EML_EXP"				=> "Please note, Password links expire in ",
		"EML_VER_EXP"		=> "Please note, Verification links expire in ",
		"EML_CLICK"			=> "Click here to login.",
		"EML_REC"				=> "It is recommended to change your password upon logging in.",
		"EML_MSG"				=> "You have a new message from",
		"EML_REPLY"			=> "Click here to reply or view the thread",
		"EML_WHY"				=> "You are receiving this email because a request was made to reset your password. If this was not you, you may disregard this email.",
		"EML_HOW"				=> "If this was you, click the link below to continue with the password reset process.",
		"EML_EML"				=> "A request to change your email was made from within your user account.",
		"EML_VER_EML"		=> "Thanks for signing up.  Once you verify your email address you will be ready to login! Please click the link below to verify your email address.",
		));

		//Verification
		$lang = array_merge($lang,array(
			"VER_SUC"			=> "Your Email has been verified!, eh?",
			"VER_FAIL"		=> "We were unable to verify your account. Please try again., eh?",
			"VER_RESEND"	=> "Resend Verification Email, eh?",
			"VER_AGAIN"		=> "Enter your email address and try again, eh?",
			"VER_PAGE"		=> "<li>Check your email and click the link that is sent to you</li><li>Done</li>, eh?",
			"VER_RES_SUC" => "<p>Your verification link has been sent to your email address.</p><p>Click the link in the email to complete verification. Be sure to check your spam folder if the email isn't in your inbox.</p><p>Verification links are only valid for , eh?",
			"VER_OOPS" => "Oops...something went wrong, maybe an old reset link you clicked on. Click below to try again",
			"VER_RESET" => "Your password has been reset!",
			"VER_INS" => "<li>Enter your email address and click Reset</li> <li>Check your email and click the link that is sent to you.</li> <li>Follow the on screen instructions</li><li>Get a donut at Tim's</li>",
			"VER_SENT" => "<p>Your password reset link has been sent to your email address.</p> <p>Click the link in the email to Reset your password. Be sure to check your spam folder if the email isn't in your inbox.</p><p>Reset links are only valid for ",
			"VER_PLEASE" => "Please reset your password, pretty please",
			));

	//User Settings
	$lang = array_merge($lang,array(
		"SET_PIN"				=> "Reset PIN, eh?",
		"SET_WHY"				=> "Why can't I change this?, eh?",
		"SET_PW_MATCH"	=> "Must match the New Password, eh?",

		"SET_PIN_NEXT"	=> "You can set a new PIN the next time you require verification, eh?",
		"SET_UPDATE"		=> "Update your user settings, eh?",
		"SET_NOCHANGE"	=> "The Administrator has disabled changing usernames., eh?",
		"SET_ONECHANGE"	=> "The Administrator set username changes to occur only once and you have done so already., eh?",

		"SET_GRAVITAR"	=> "<strong>Want to change your profile picture? </strong><br> Visit <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> and setup an account with the same email you used on this site.It works across millions of sites. It's fast and easy!, eh?",

		"SET_NOTE1"			=> "<p><strong>Please note</strong> there is a pending request to update your email to, eh?",

		"SET_NOTE2"			=> ".</p><p>Please use the verification email to complete this request.</p>
		<p>If you need a new verification email, please re-enter the email above and submit the request again.</p>, eh?",

		"SET_PW_REQ" 		=> "required for changing password, email, or resetting PIN, eh?",
		"SET_PW_REQI" 	=> "Required to change your password, eh?",

		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"		=> "Failed to kill active sessions, Error: , eh?",
		"ERR_EMAIL"				=> "Email NOT sent due to error. Please contact site administrator., eh?",
		"ERR_EM_DB"				=> "That email does not exist in our database, eh?",
		"ERR_TC"					=> "Please read and accept terms and conditions, eh?",
		"ERR_CAP"					=> "You failed the Captcha Test, Robot!, eh?",
		"ERR_PW_SAME"			=> "Your old password cannot be the same as your new, eh?",
		"ERR_PW_FAIL"			=> "Current password verification failed. Update failed. Please try again., eh?",
		"ERR_GOOG"				=> "<strong>NOTE:</strong> If you originally signed up with your Google/Facebook account, you will need to use the forgot password link to change your password...unless you're really good at guessing., eh?",
		"ERR_EM_VER"			=> "Email verification is not enabled. Please contact the System Administrator., eh?",
		"ERR_EMAIL_STR"		=> "Something is strange. Please re-verify your email. We are sorry for the inconvenience, eh?",
		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"		=> "We will be back soon!, eh?",
		"MAINT_MSG"			=> "Sorry for the inconvenience but we are performing some maintenance at the moment.<br> We will be back online shortly!, eh?",
		"MAINT_BAN" => "The Americans made us put a wall around you. Sorry.",
		"MAINT_TOK" => "There was an error with your form. Please go back and try again. Please note that submitting the form by refreshing the page will cause an error. If this continues to happen, please contact a local beaver to chew through the problem.",
		"MAINT_OPEN" => "It's free, like America.",
		"MAINT_PLEASE" => "So sit back, grab a donut and visit",
		));

		//dataTables Added in 4.4.08
		//NOTE: do not change the words like _START_ between the two _ symbols!
		$lang = array_merge($lang,array(
		"DAT_SEARCH"    => "Search",
		"DAT_FIRST"     => "First",
		"DAT_LAST"      => "Last",
		"DAT_NEXT"      => "Next",
		"DAT_PREV"      => "Previous",
		"DAT_NODATA"        => "No data available in table",
		"DAT_INFO"          => "Showing _START_ to _END_ of _TOTAL_ entries",
		"DAT_ZERO"          => "Showing 0 to 0 of 0 entries",
		"DAT_FILTERED"      => "(filtered from _MAX_ total entries)",
		"DAT_MENU_LENG"     => "Show _MENU_ entries",
		"DAT_LOADING"       => "Loading...",
		"DAT_PROCESS"       => "Processing...",
		"DAT_NO_REC"        => "No matching records found",
		"DAT_ASC"           => "Activate to sort column ascending",
		"DAT_DESC"          => "Activate to sort column descending",
		));

		//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
		if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
			include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
		}
 //do not put a closing php tag here
