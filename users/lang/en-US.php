<?php
/*
Do not put any content above the opening PHP tag
TO CREATE A NEW LANGUAGE, COPY THE en-us.php to your own localization code name.
We are going to keep these files in the iso xx-xx format because that will also
allow us to autoformat numbers on the sites.

PLEASE put your name somewhere at the top of the language file so we can get in touch with
you to update it and thank you for your hard work!

PLEASE NOTE: DO NOT ADD RANDOM KEYS in the middle of the translations.  In order to make it easier to tell what language keys are missing, from this point forward, we are going to add all new language keys at the BOTTOM of this file. The number of lines in your language file will tell you which keys still need to be translated.  If you have questions please ask on the forums or on Discord.

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

/*
%m1% - Dymamic markers which are replaced at run time by the relevant index.
*/

$lang = array();
//important strings
//You defiitely want to customize these for your language
$lang = array_merge($lang,array(
"THIS_LANGUAGE"	=>"English",
"THIS_CODE"			=>"en-US",
"MISSING_TEXT"	=>"Missing Text",
));

//Database Menus
$lang = array_merge($lang,array(
"MENU_HOME"			=> "Home",
"MENU_HELP"			=> "Help",
"MENU_ACCOUNT"	=> "Account",
"MENU_DASH"			=> "Admin Dashboard",
"MENU_USER_MGR"	=> "User Management",
"MENU_PAGE_MGR"	=> "Page Management",
"MENU_PERM_MGR"	=> "Permissions Management",
"MENU_MSGS_MGR"	=> "Messages Manager",
"MENU_LOGS_MGR"	=> "System Logs",
"MENU_LOGOUT"		=> "Logout",
));

// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"					=> "Register",
	"SIGNUP_BUTTONTEXT"		=> "Register Me",
	"SIGNUP_AUDITTEXT"		=> "Registered",
	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"				=> "** FAILED LOGIN **",
	"SIGNIN_PLEASE_CHK" => "Please check your username and password and try again",
	"SIGNIN_UORE"				=> "Username or Email",
	"SIGNIN_PASS"				=> "Password",
	"SIGNIN_TITLE"			=> "Please Log In",
	"SIGNIN_TEXT"				=> "Log In",
	"SIGNOUT_TEXT"			=> "Log Out",
	"SIGNIN_BUTTONTEXT"	=> "Login",
	"SIGNIN_REMEMBER"		=> "Remember Me",
	"SIGNIN_AUDITTEXT"	=> "Logged In",
	"SIGNIN_FORGOTPASS"	=>"Forgot Password",
	"SIGNOUT_AUDITTEXT"	=> "Logged Out",
	));

// Account Page
$lang = array_merge($lang,array(
	"ACCT_EDIT"					=> "Edit Account Info",
	"ACCT_2FA"					=> "Manage 2 Factor Authentication",
	"ACCT_SESS"					=> "Manage Sessions",
	"ACCT_HOME"					=> "Account Home",
	"ACCT_SINCE"				=> "Member Since",
	"ACCT_LOGINS"				=> "Number of Logins",
	"ACCT_SESSIONS"			=> "Number of Active Sessions",
	"ACCT_MNG_SES"			=> "Click the Manage Sessions button in the left sidebar for more information.",
	));

	//General Terms
	$lang = array_merge($lang,array(
		"GEN_ENABLED"			=> "Enabled",
		"GEN_DISABLED"		=> "Disabled",
		"GEN_ENABLE"			=> "Enable",
		"GEN_DISABLE"			=> "Disable",
		"GEN_NO"					=> "No",
		"GEN_YES"					=> "Yes",
		"GEN_MIN"					=> "min",
		"GEN_MAX"					=> "max",
		"GEN_CHAR"				=> "char", //as in characters
		"GEN_SUBMIT"			=> "Submit",
		"GEN_MANAGE"			=> "Manage",
		"GEN_VERIFY"			=> "Verify",
		"GEN_SESSION"			=> "Session",
		"GEN_SESSIONS"		=> "Sessions",
		"GEN_EMAIL"				=> "Email",
		"GEN_FNAME"				=> "First Name",
		"GEN_LNAME"				=> "Last Name",
		"GEN_UNAME"				=> "Username",
		"GEN_PASS"				=> "Password",
		"GEN_MSG"					=> "Message",
		"GEN_TODAY"				=> "Today",
		"GEN_CLOSE"				=> "Close",
		"GEN_CANCEL"			=> "Cancel",
		"GEN_CHECK"				=> "[ check/uncheck all ]",
		"GEN_WITH"				=> "with",
		"GEN_UPDATED"			=> "Updated",
		"GEN_UPDATE"			=> "Update",
		"GEN_BY"					=> "by",
		"GEN_FUNCTIONS"		=> "Functions",
		"GEN_NUMBER"			=> "number",
		"GEN_NUMBERS"			=> "numbers",
		"GEN_INFO"				=> "Information",
		"GEN_REC"					=> "Recorded",
		"GEN_DEL"					=> "Delete",
		"GEN_NOT_AVAIL"		=> "Not Available",
		"GEN_AVAIL"				=> "Available",
		"GEN_BACK"				=> "Back",
		"GEN_RESET"				=> "Reset",
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
		"T_YEARS"			=> "Years",
		"T_YEAR"			=> "Year",
		"T_MONTHS"		=> "Months",
		"T_MONTH"			=> "Month",
		"T_WEEKS"			=> "Weeks",
		"T_WEEK"			=> "Week",
		"T_DAYS"			=> "Days",
		"T_DAY"				=> "Day",
		"T_HOURS"			=> "Hours",
		"T_HOUR"			=> "Hour",
		"T_MINUTES"		=> "Minutes",
		"T_MINUTE"		=> "Minute",
		"T_SECONDS"		=> "Seconds",
		"T_SECOND"		=> "Second",
		));


		//Passwords
	$lang = array_merge($lang,array(
		"PW_NEW"		=> "New Password",
		"PW_OLD"		=> "Old Password",
		"PW_CONF"		=> "Confirm Password",
		"PW_RESET"	=> "Reset Password",
		"PW_UPD"		=> "Password Updated",
		"PW_SHOULD"	=> "Passwords Should...",
		"PW_SHOW"		=> "Show Password",
		"PW_SHOWS"	=> "Show Passwords",
		));


		//Join
	$lang = array_merge($lang,array(
		"JOIN_SUC"			=> "Welcome To ",
		"JOIN_THANKS"		=> "Thanks for registering!",
		"JOIN_HAVE"			=> "Have at least ",
		"JOIN_CAP"			=> " capital letter",
		"JOIN_TWICE"		=> "Be typed correctly twice",
		"JOIN_CLOSED"		=> "Unfortunately registration is disabled at this time. Please contact the Site Administrator if you have any questions or concerns.",
		"JOIN_TC"				=> "Registration User Terms and Conditions",
		"JOIN_ACCEPTTC" => "I Accept User Terms and Conditions",
		"JOIN_CHANGED"	=> "Our Terms Have Changed",
		"JOIN_ACCEPT" 	=> "Accept User Terms and Conditions and Continue",
		));

		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "Successfully killed ",
		));

		//Messages
	$lang = array_merge($lang,array(
		"MSG_SENT"			=> "Your message has been sent!",
		"MSG_MASS"			=> "Your mass message has been sent!",
		"MSG_NEW"				=> "New Message",
		"MSG_NEW_MASS"	=> "New Mass Message",
		"MSG_CONV"			=> "Conversations",
		"MSG_NO_CONV"		=> "No Conversations",
		"MSG_NO_ARC"		=> "No Conversations",
		"MSG_QUEST"			=> "Send Email Notification if Enabled?",
		"MSG_ARC"				=> "Archived Threads",
		"MSG_VIEW_ARC"	=> "View Archived Threads",
		"MSG_SETTINGS"  => "Message Settings",
		"MSG_READ"			=> "Read",
		"MSG_BODY"			=> "Body",
		"MSG_SUB"				=> "Subject",
		"MSG_DEL"				=> "Delivered",
		"MSG_REPLY"			=> "Reply",
		"MSG_QUICK"			=> "Quick Reply",
		"MSG_SELECT"		=> "Select a user",
		"MSG_UNKN"			=> "Unknown Recipient",
		"MSG_NOTIF"			=> "Message Email Notifications",
		"MSG_BLANK"			=> "Message cannot be blank",
		"MSG_MODAL"			=> "Click here or press Alt + R to focus on this box OR press Shift + R to open the expanded reply pane!",
		"MSG_ARCHIVE_SUCCESSFUL"        => "You have successfully archived %m1% threads",
		"MSG_UNARCHIVE_SUCCESSFUL"      => "You have successfully unarchived %m1% threads",
		"MSG_DELETE_SUCCESSFUL"         => "You have successfully deleted %m1% threads",
		"USER_MESSAGE_EXEMPT"         			=> "User is %m1% exempted from messages.",
		"MSG_MK_READ"		=> "Read",
		"MSG_MK_UNREAD"	=> "Unread",
		"MSG_ARC_THR"		=> "Archive Selected Threads",
		"MSG_UN_THR"		=> "Unarchive Selected Threads",
		"MSG_DEL_THR"		=> "Delete Selected Threads",
		"MSG_SEND"			=> "Send Message",
		));

	//2 Factor Authentication
	$lang = array_merge($lang,array(
		"2FA"				=> "2 Factor Authentication",
		"2FA_CONF"	=> "Are you sure you want to disable 2FA? Your account will no longer be protected.",
		"2FA_SCAN"	=> "Scan this QR code with your authenticator app or input the key",
		"2FA_THEN"	=> "Then enter one of your one-time passkeys here",
		"2FA_FAIL"	=> "There was a problem verifying 2FA. Please check Internet or contact support.",
		"2FA_CODE"	=> "2FA Code",
		"2FA_EXP"		=> "Expired 1 fingerprint",
		"2FA_EXPD"	=> "Expired",
		"2FA_EXPS"	=> "Expires",
		"2FA_ACTIVE"=> "Active Sessions",
		"2FA_NOT_FN"=> "No fingerprints found",
		"2FA_FP"		=> "Fingerprints",
		"2FA_NP"		=> "<strong>Login Failed</strong> Two Factor Auth Code was not present. Please try again.",
		"2FA_INV"		=> "<strong>Login Failed</strong> Two Factor Auth Code was invalid. Please try again.",
		"2FA_FATAL"	=> "<strong>Fatal Error</strong> Please contact System Admin.",
		));

	//Redirect Messages - These get a plus between each word
	$lang = array_merge($lang,array(
		"REDIR_2FA"						=> "Sorry.Two+factor+is+not+enabled+at+this+time",
		"REDIR_2FA_EN"				=> "2+Factor+Authentication+Enabled",
		"REDIR_2FA_DIS"				=> "2+Factor+Authentication+Disabled",
		"REDIR_2FA_VER"				=> "2+Factor+Authentication+Verified+and+Enabled",
		"REDIR_SOM_TING_WONG" => "Something+went+wrong.+Please+try+again.",
		"REDIR_MSG_NOEX"			=> "That+thread+does+not+belong+to+you+or+does+not+exist.",
		"REDIR_UN_ONCE"				=> "Username+has+already+been+changed+once.",
		"REDIR_EM_SUCC"				=> "Email+Updated+Successfully",
		));

	//Emails
	$lang = array_merge($lang,array(
		"EML_CONF"			=> "Confirm Email",
		"EML_VER"				=> "Verify Your Email",
		"EML_CHK"				=> "Email request received. Please check your email to perform verification. Be sure to check your Spam and Junk folder as the verification link expires in ",
		"EML_MAT"				=> "Your email did not match.",
		"EML_HELLO"			=> "Hello from ",
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
			"VER_SUC"			=> "Your Email has been verified!",
			"VER_FAIL"		=> "We were unable to verify your account. Please try again.",
			"VER_RESEND"	=> "Resend Verification Email",
			"VER_AGAIN"		=> "Enter your email address and try again",
			"VER_PAGE"		=> "<li>Check your email and click the link that is sent to you</li><li>Done</li>",
			"VER_RES_SUC" => "<p>Your verification link has been sent to your email address.</p><p>Click the link in the email to complete verification. Be sure to check your spam folder if the email isn't in your inbox.</p><p>Verification links are only valid for ",
			"VER_OOPS"		=> "Oops...something went wrong, maybe an old reset link you clicked on. Click below to try again",
			"VER_RESET"		=> "Your password has been reset!",
			"VER_INS"			=> "<li>Enter your email address and click Reset</li> <li>Check your email and click the link that is sent to you.</li>
												<li>Follow the on screen instructions</li>",
			"VER_SENT"		=> "<p>Your password reset link has been sent to your email address.</p>
			    							<p>Click the link in the email to Reset your password. Be sure to check your spam folder if the email isn't in your inbox.</p><p>Reset links are only valid for ",
			"VER_PLEASE"	=> "Please reset your password",
			));

	//User Settings
	$lang = array_merge($lang,array(
		"SET_PIN"				=> "Reset PIN",
		"SET_WHY"				=> "Why can't I change this?",
		"SET_PW_MATCH"	=> "Must match the New Password",

		"SET_PIN_NEXT"	=> "You can set a new PIN the next time you require verification",
		"SET_UPDATE"		=> "Update your user settings",
		"SET_NOCHANGE"	=> "The Administrator has disabled changing usernames.",
		"SET_ONECHANGE"	=> "The Administrator set username changes to occur only once and you have done so already.",

		"SET_GRAVITAR"	=> "<strong>Want to change your profile picture? </strong><br> Visit <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> and setup an account with the same email you used on this site. It works across millions of sites. It's fast and easy!",

		"SET_NOTE1"			=> "<p><strong>Please note</strong> there is a pending request to update your email to",

		"SET_NOTE2"			=> ".</p><p>Please use the verification email to complete this request.</p>
		<p>If you need a new verification email, please re-enter the email above and submit the request again.</p>",

		"SET_PW_REQ" 		=> "required for changing password, email, or resetting PIN",
		"SET_PW_REQI" 	=> "Required to change your password",

		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"		=> "Failed to kill active sessions, Error: ",
		"ERR_EMAIL"				=> "Email NOT sent due to error. Please contact site administrator.",
		"ERR_EM_DB"				=> "That email does not exist in our database",
		"ERR_TC"					=> "Please read and accept terms and conditions",
		"ERR_CAP"					=> "You failed the Captcha Test, Robot!",
		"ERR_PW_SAME"			=> "Your old password cannot be the same as your new",
		"ERR_PW_FAIL"			=> "Current password verification failed. Update failed. Please try again.",
		"ERR_GOOG"				=> "<strong>NOTE:</strong> If you originally signed up with your Google/Facebook account, you will need to use the forgot password link to change your password...unless you're really good at guessing.",
		"ERR_EM_VER"			=> "Email verification is not enabled. Please contact the System Administrator.",
		"ERR_EMAIL_STR"		=> "Something is strange. Please re-verify your email. We are sorry for the inconvenience",

		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"		=> "We will be back soon!",
		"MAINT_MSG"			=> "Sorry for the inconvenience but we are performing some maintenance at the moment.<br> We will be back online shortly!",
		"MAINT_BAN"			=> "Sorry. You have been banned. If you feel this is an error, please contact the administrator.",
		"MAINT_TOK"			=> "There was an error with your form. Please go back and try again. Please note that submitting the form by refreshing the page will cause an error. If this continues to happen, please contact the administrator.",
		"MAINT_OPEN"		=> "An Open Source PHP User Management Framework.",
		"MAINT_PLEASE"	=> "You have successfully installed UserSpice!<br>To view our getting started documentation, please visit"
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


///////////////////////////////////////////////////////////////

//Backend Translations for UserSpice
$lang = array_merge($lang,array(
"BE_DASH"    			=> "Dashboard",
"BE_SETTINGS"     => "Settings",
"BE_GEN"					=> "General",
"BE_REG"					=> "Registration",
"BE_CUS"					=> "Custom Settings",
"BE_DASH_ACC"			=> "Dashboard Access",
"BE_TOOLS"				=> "Tools",
"BE_BACKUP"				=> "Backup",
"BE_UPDATE"				=> "Updates",
"BE_CRON"				  => "Cron Jobs",
"BE_IP"				  	=> "IP Manager",
));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
//do not put a closing php tag here
