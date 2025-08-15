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
%m1% - Dynamic markers which are replaced at run time by the relevant index.
*/

$lang = array();
//important strings
//You definitely want to customize these for your language
$lang = array_merge($lang, array(
	"THIS_LANGUAGE"	=> "English",
	"THIS_CODE"			=> "en-US",
	"MISSING_TEXT"	=> "Missing Text",
));

//Database Menus
$lang = array_merge($lang, array(
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
//passwordless
// Signup
$lang = array_merge($lang, array(
	"PASS_ENTER_CODE"	=> "Enter the code sent to your email",
	"PASS_EMAIL_ONLY"	=> "Please check your email for a link to login.",
	"PASS_CODE_ONLY" 	=> "Please enter the code sent to your email.",
	"PASS_BOTH"		=> "Please check your email for a link to login or enter the code sent to your email.",
	"PASS_VER_BUTTON" => "Verify code",
	"PASS_EMAIL_ONLY_MSG" => "Please verify your email address by clicking the link below.",
	"PASS_CODE_ONLY_MSG" => "Please enter the code below to login.",
	"PASS_BOTH_MSG" => "Please verify your email address by clicking the link below or enter the code below to login.",
	"PASS_YOUR_CODE" => "Your verification code is: ",
	"PASS_CONFIRM_LOGIN" => "Confirm Login",
	"PASS_CONFIRM_CLICK" => "Click to Complete Login",
	"PASS_GENERIC_ERROR" => "Something went wrong.",
));

// Signup
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"					=> "Register",
	"SIGNUP_BUTTONTEXT"		=> "Register Me",
	"SIGNUP_AUDITTEXT"		=> "Registered",
));

// Signin
$lang = array_merge($lang, array(
	"SIGNIN_FAIL"				=> "** FAILED LOGIN **",
	"SIGNIN_PLEASE_CHK" => "Please check your username and password and try again",
	"SIGNIN_UORE"				=> "Username OR Email",
	"SIGNIN_PASS"				=> "Password",
	"SIGNIN_TITLE"			=> "Please Log In",
	"SIGNIN_TEXT"				=> "Log In",
	"SIGNOUT_TEXT"			=> "Log Out",
	"SIGNIN_BUTTONTEXT"	=> "Login",
	"SIGNIN_REMEMBER"		=> "Remember Me",
	"SIGNIN_AUDITTEXT"	=> "Logged In",
	"SIGNIN_FORGOTPASS"	=> "Forgot Password",
	"SIGNOUT_AUDITTEXT"	=> "Logged Out",

));

// Account Page
$lang = array_merge($lang, array(
	"ACCT_EDIT"					=> "Edit Account Info",
	"ACCT_2FA"					=> "Manage Two Factor Authentication",
	"ACCT_SESS"					=> "Manage Sessions",
	"ACCT_HOME"					=> "Account Home",
	"ACCT_SINCE"				=> "Member Since",
	"ACCT_LOGINS"				=> "Number of Logins",
	"ACCT_SESSIONS"			=> "Number of Active Sessions",
	"ACCT_MNG_SES"			=> "Click the Manage Sessions button in the left sidebar for more information.",
));

//General Terms
$lang = array_merge($lang, array(
	"GEN_ENABLED"			=> "Enabled",
	"GEN_DISABLED"			=> "Disabled",
	"GEN_ENABLE"			=> "Enable",
	"GEN_DISABLE"			=> "Disable",
	"GEN_NO"				=> "No",
	"GEN_YES"				=> "Yes",
	"GEN_MIN"				=> "min",
	"GEN_MAX"				=> "max",
	"GEN_CHAR"				=> "char", //as in characters
	"GEN_SUBMIT"			=> "Submit",
	"GEN_MANAGE"			=> "Manage",
	"GEN_VERIFY"			=> "Verify",
	"GEN_SESSION"			=> "Session",
	"GEN_SESSIONS"			=> "Sessions",
	"GEN_EMAIL"				=> "Email",
	"GEN_FNAME"				=> "First Name",
	"GEN_LNAME"				=> "Last Name",
	"GEN_UNAME"				=> "Username",
	"GEN_PASS"				=> "Password",
	"GEN_MSG"				=> "Message",
	"GEN_TODAY"				=> "Today",
	"GEN_CLOSE"				=> "Close",
	"GEN_CANCEL"			=> "Cancel",
	"GEN_CHECK"				=> "[ check/uncheck all ]",
	"GEN_WITH"				=> "with",
	"GEN_UPDATED"			=> "Updated",
	"GEN_UPDATE"			=> "Update",
	"GEN_BY"				=> "by",
	"GEN_FUNCTIONS"			=> "Functions",
	"GEN_NUMBER"			=> "number",
	"GEN_NUMBERS"			=> "numbers",
	"GEN_INFO"				=> "Information",
	"GEN_REC"				=> "Recorded",
	"GEN_DEL"				=> "Delete",
	"GEN_NOT_AVAIL"			=> "Not Available",
	"GEN_AVAIL"				=> "Available",
	"GEN_BACK"				=> "Back",
	"GEN_RESET"				=> "Reset",
	"GEN_REQ"				=> "required",
	"GEN_AND"				=> "and",
	"GEN_SAME"				=> "must be the same",
));

//added during passkey/totp update
$lang = array_merge($lang, array(
	"GEN_PASSKEY"			=> "Passkey",
	"GEN_ACTIONS"       	=> "Actions",
	"GEN_BACK_TO_ACCT"      => "Back to Account",
	"GEN_DB_ERROR"          => "A database error occurred. Please try again.",
	"GEN_IMPORTANT"         => "Important",
	"GEN_DB_ERROR"          => "A database error occurred. Please try again.",
	"GEN_IMPORTANT"         => "Important",
	"GEN_NO_PERMISSIONS"    => "You do not have permission to access this page.",
	"GEN_NO_PERMISSIONS_MSG" => "You do not have permission to access this page. If you feel this is an error, please contact the site administrator.",
	"PASSKEYS_MANAGE_TITLE"                 => "Manage Passkeys",
	"PASSKEYS_LOGIN_TITLE"                  => "Passkey Login",
	"PASSKEY_DELETE_SUCCESS"                => "Passkey deleted successfully.",
	"PASSKEY_DELETE_FAIL_DB"                => "Failed to delete passkey from database.",
	"PASSKEY_DELETE_NOT_FOUND"              => "Passkey not found or you don't have permission to delete it.",
	"PASSKEY_NOTE_UPDATE_SUCCESS"           => "Passkey note updated successfully.",
	"PASSKEY_NOTE_UPDATE_FAIL"              => "Failed to update passkey note.",
	"PASSKEY_REGISTER_NEW"                  => "Register New Passkey",
	"PASSKEY_ERR_LIMIT_REACHED"             => "You have reached the maximum of 10 passkeys.",
	"PASSKEY_NOTE_TH"                       => "Passkey Note",
	"PASSKEY_TIMES_USED_TH"                 => "Times Used",
	"PASSKEY_LAST_USED_TH"                  => "Last Used",
	"PASSKEY_LAST_IP_TH"                    => "Last IP",
	"PASSKEY_EDIT_NOTE_BTN"                 => "Edit Note",
	"PASSKEY_CONFIRM_DELETE_JS"             => "Are you sure you want to delete this passkey?",
	"PASSKEY_EDIT_MODAL_TITLE"              => "Edit Passkey Note",
	"PASSKEY_EDIT_MODAL_LABEL"              => "Passkey Note",
	"PASSKEY_SAVE_CHANGES_BTN"              => "Save Changes",
	"PASSKEY_NONE_REGISTERED"               => "You don't have any passkeys registered yet.",
	"PASSKEY_MUST_REGISTER_FIRST"           => "You must first register a passkey from an authenticated account before using this feature.",
	"PASSKEY_STORING"                       => "Storing passkey...",
	"PASSKEY_STORED_SUCCESS"                => "Passkey stored successfully!",
	"PASSKEY_INVALID_ACTION"                => "Invalid action: ",
	"PASSKEY_NO_ACTION_SPECIFIED"           => "No action specified",
	"PASSKEYS_MANAGE_TITLE"                 => "Manage Your Passkeys",
	"PASSKEYS_LOGIN_TITLE"                  => "Login with Passkey",
	"PASSKEY_DELETE_SUCCESS"                => "Passkey deleted successfully.",
	"PASSKEY_DELETE_FAIL_DB"                => "Failed to delete passkey from database.",
	"PASSKEY_DELETE_NOT_FOUND"              => "Passkey not found or permission denied.",
	"PASSKEY_NOTE_UPDATE_SUCCESS"           => "Passkey note updated successfully.",
	"PASSKEY_NOTE_UPDATE_FAIL"              => "Failed to update passkey note.",
	"PASSKEY_ERR_NETWORK_SUGGESTION"        => "Network issue detected. Try a different network or refresh the page.",
	"PASSKEY_ERR_CROSS_DEVICE_SUGGESTION"   => "Cross-device authentication detected. Ensure both devices have internet access.",
	"PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE"  => "Try opening this page directly on your phone instead.",
	"PASSKEY_ERR_DIAGNOSTIC_FAILED"         => "Could not generate diagnostics: ",
	"PASSKEY_MISSING_CREDENTIAL_DATA"       => "Missing required credential data for storage.",
	"PASSKEY_MISSING_AUTH_DATA"             => "Missing required authentication data.",
	"PASSKEY_LOG_NO_MESSAGE"                => "No message",
	"PASSKEY_USER_NOT_FOUND"                => "User not found after passkey validation.",
	"PASSKEY_FATAL_ERROR"                   => "Fatal error: ",
	"PASSKEY_LOGIN_SUCCESS"                 => "Login successful.",
	// JavaScript status messages (passkeys.php)
	"PASSKEY_CROSS_DEVICE_PREP"             => "Preparing cross-device registration. You may need to use your phone or tablet.",
	"PASSKEY_DEVICE_REGISTRATION"           => "Using device passkey registration...",
	"PASSKEY_STARTING_REGISTRATION"         => "Starting passkey registration...",
	"PASSKEY_REQUEST_OPTIONS"               => "Requesting registration options from server...",
	"PASSKEY_FOLLOW_PROMPTS"                => "Follow the prompts to create your passkey. You may need to use another device.",
	"PASSKEY_FOLLOW_PROMPTS_SIMPLE"         => "Follow the prompts to create your passkey...",
	"PASSKEY_CREATION_FAILED"               => "Passkey creation failed - no credential returned.",
	"PASSKEY_STORING_SERVER"                => "Storing your passkey...",
	"PASSKEY_CREATED_SUCCESS"               => "Passkey created successfully!",

	"PASSKEY_CROSS_DEVICE_AUTH_PREP"        => "Preparing cross-device authentication. Ensure your phone and computer have internet access.",
	"PASSKEY_DEVICE_AUTH"                   => "Using device passkey authentication...",
	"PASSKEY_STARTING_AUTH"                 => "Starting passkey authentication...",
	"PASSKEY_QR_CODE_INSTRUCTION"           => "Scan the QR code with your phone when it appears. Make sure both devices have internet access.",
	"PASSKEY_PHONE_TABLET_INSTRUCTION"      => "Choose \"Use a phone or tablet\" when prompted, then scan the QR code.",
	"PASSKEY_AUTHENTICATING"                => "Authenticating with your passkey...",
	"PASSKEY_SUCCESS_REDIRECTING"           => "Authentication successful! Redirecting...",

	// Timeout messages
	"PASSKEY_TIMEOUT_CROSS_DEVICE"          => "Registration timed out. For cross-device: 1) Try again, 2) Ensure devices have internet, 3) Consider registering directly on your phone.",
	"PASSKEY_TIMEOUT_SIMPLE"                => "Registration timed out. Please try again.",
	"PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"     => "Cross-device authentication timed out. Troubleshooting: 1) Both devices need internet, 2) Try scanning the QR code more quickly, 3) Consider using the same device, 4) Some networks block cross-device authentication.",
	"PASSKEY_AUTH_TIMEOUT_SIMPLE"           => "Authentication timed out. Please try again.",
	"PASSKEY_NO_CREDENTIAL"                 => "No credential received. Retrying...",
	"PASSKEY_AUTH_FAILED_NO_CREDENTIAL"     => "Authentication failed - no credential returned.",
	"PASSKEY_ATTEMPT_RETRY"                 => "failed. Retrying... (%d attempts remaining)",

	// Error messages
	"PASSKEY_CROSS_DEVICE_FAILED"           => "Cross-device registration failed. Try: 1) Ensure both devices have internet, 2) Consider registering directly on your phone, 3) Some corporate networks block this feature.",
	"PASSKEY_REGISTRATION_CANCELLED"        => "Registration was cancelled or device does not support passkeys.",
	"PASSKEY_NOT_SUPPORTED"                 => "Passkeys are not supported on this device/browser combination.",
	"PASSKEY_SECURITY_ERROR"                => "Security error - this usually indicates a domain/origin mismatch.",
	"PASSKEY_ALREADY_EXISTS"                => "A passkey already exists for this account on this device. Try using a different device or delete existing passkeys first.",
	"PASSKEY_CROSS_DEVICE_AUTH_FAILED"      => "Cross-device authentication failed. Try: 1) Ensure both devices have stable internet, 2) Use the same WiFi network if possible, 3) Try authenticating directly on your phone instead, 4) Some corporate networks block this feature.",
	"PASSKEY_AUTH_CANCELLED"                => "Authentication was cancelled or no passkey was selected.",
	"PASSKEY_NETWORK_ERROR"                 => "Network error. For cross-device authentication, both devices need internet access and may need to be on the same network.",
	"PASSKEY_CREDENTIAL_NOT_FOUND"          => "Authentication failed - credential not recognized.",

	// Cross-device guidance
	"PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE"   => "Cross-Device Authentication Tips:",
	"PASSKEY_GUIDANCE_INTERNET"             => "Ensure both your computer and phone have internet access",
	"PASSKEY_GUIDANCE_WIFI"                 => "Being on the same WiFi network can help (but isn't always required)",
	"PASSKEY_GUIDANCE_SELECT_DEVICE"        => "When prompted, select \"Use a phone or tablet\"",
	"PASSKEY_GUIDANCE_SCAN_QUICKLY"         => "Scan the QR code quickly when it appears",
	"PASSKEY_GUIDANCE_TRY_DIRECT"           => "If it fails, try refreshing and using your phone's browser directly",

	// Troubleshooting
	"PASSKEY_SHOW_TROUBLESHOOTING"          => "Show Troubleshooting Tips",
	"PASSKEY_HIDE_TROUBLESHOOTING"          => "Hide Troubleshooting Tips",
	"PASSKEY_DIAGNOSTICS_RUNNING"           => "Running diagnostics...",
	"PASSKEY_DIAGNOSTICS_COMPLETE"          => "Diagnostics complete. Check console for details.",
	"PASSKEY_ISSUES_DETECTED"               => "Issues detected:",
	"PASSKEY_ENVIRONMENT_SUITABLE"          => "Environment appears suitable for passkeys.",
	"PASSKEY_DIAGNOSTICS_FAILED"            => "Diagnostics failed:",

	// Modal
	"PASSKEY_ADD_NOTE_NEW"                  => "Add Note to Your New Passkey",

	// Technical errors
	"PASSKEY_BASE64_ERROR"                  => "Base64 decode error:",

	// Server-side errors (passkey_parser.php)
	"PASSKEY_ERR_NETWORK_SUGGESTION"        => "Network issue detected. Try a different network or refresh the page.",
	"PASSKEY_ERR_CROSS_DEVICE_SUGGESTION"   => "Cross-device authentication detected. Ensure both devices have internet access.",
	"PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE"  => "Try opening this page directly on your phone instead.",
	"PASSKEY_ERR_DIAGNOSTIC_FAILED"         => "Could not generate diagnostics: ",
	"PASSKEY_INVALID_JSON"                  => "Invalid JSON data received:",
	"PASSKEY_LOG_NO_MESSAGE"                => "No message",
	"PASSKEY_MISSING_CREDENTIAL_DATA"       => "Missing required credential data for storage.",
	"PASSKEY_MISSING_AUTH_DATA"             => "Missing required authentication data.",
	"PASSKEY_FATAL_ERROR"                   => "Fatal error: ",

	// Session/validation errors (PasskeyHandler.php)
	"PASSKEY_NO_CHALLENGE_SESSION"          => "No passkey registration challenge found in session. Please try registering again.",
	"PASSKEY_USER_MISMATCH"                 => "User ID mismatch. Please try registering again.",
	"PASSKEY_CHALLENGE_USER_MISMATCH"       => "User ID in challenge options does not match current user. Please try registering again.",
	"PASSKEY_REGISTRATION_FAILED_ERROR"     => "Passkey registration failed. Please ensure your device and browser support WebAuthn and try again. Error:",
	"PASSKEY_NO_AUTH_CHALLENGE_SESSION"     => "No passkey assertion challenge found in session. Please try logging in again.",
	"PASSKEY_CREDENTIAL_NOT_IN_DB"          => "Passkey credential not found in the database.",
	"PASSKEY_CREDENTIAL_WRONG_USER"         => "Passkey credential does not belong to the expected user.",
	"PASSKEY_VALIDATION_FAILED_ERROR"       => "Passkey validation failed. Please try again or contact support if the issue persists. Error:",
	"PASSKEY_USER_NOT_FOUND_REGISTRATION"   => "User not found for registration.",

	// --- Used in passkey_parser.php ---
	"PASSKEY_LOGIN_REQUIRED"        => "You must be logged in to perform this action.",
	"PASSKEY_ACTION_MISSING"        => "The required 'action' parameter was missing from the request.",
	"PASSKEY_STORAGE_FAILED"        => "Failed to store the passkey. The operation was unsuccessful.",
	"PASSKEY_LOGIN_FAILED"          => "Passkey login failed. The authentication could not be verified.",
	"PASSKEY_INVALID_METHOD"        => "Invalid request method:", // The script appends the method name after this key

	// --- Used in passkeys.php ---
	"CSRF_ERROR"                    => "CSRF token check failed. Please go back and try submitting the form again.",



	// Network analysis from analyzeNetworkConditions()
	"PASSKEY_NETWORK_PRIVATE"       => "Potential Issue: You appear to be on a private network, which can sometimes interfere with cross-device communication.",
	"PASSKEY_NETWORK_PROXY"         => "Potential Issue: A proxy or VPN was detected. This may interfere with cross-device communication.",
	"PASSKEY_NETWORK_MOBILE"        => "Note: You appear to be on a mobile network. Ensure a stable connection for cross-device operations.",
	"PASSKEY_NETWORK_CORPORATE"     => "Potential Issue: A corporate firewall may be active, which could affect cross-device authentication.",

	// Recommendations from getCrossDeviceRecommendations()
	"PASSKEY_RECOMMENDATION_CROSS_DEVICE"   => "Recommendation: You are likely using a desktop. Prepare to use your phone to scan a QR code.",
	"PASSKEY_RECOMMENDATION_SAME_NETWORK"   => "Recommendation: For best results, ensure your computer and mobile device are on the same Wi-Fi network.",
	"PASSKEY_RECOMMENDATION_QR_QUICK"       => "Recommendation: Be prepared to scan the QR code quickly, as the request may time out.",
	"PASSKEY_RECOMMENDATION_INTERNET"       => "Recommendation: Ensure both your computer and your mobile device have a stable internet connection.",
	"PASSKEY_RECOMMENDATION_UNITY_WEBVIEW"  => "Recommendation: For Unity WebViews, ensure the page has enough time to load and process the passkey request.",
	"PASSKEY_RECOMMENDATION_UNITY_TIMEOUT"  => "Recommendation: Timeouts may be longer in Unity. Please be patient.",
	"PASSKEY_RECOMMENDATION_MOBILE_LOCAL"   => "Recommendation: Since you are on mobile, you should be able to register a passkey directly to this device.",
	"PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Recommendation: On Android, you can manage your passkeys in the Google Password Manager.",

	// Validation from validateCrossDeviceEnvironment()
	"PASSKEY_VALIDATION_RP_IP"                  => "Configuration Warning: The Relying Party ID is set to an IP address.",
	"PASSKEY_VALIDATION_RP_DOMAIN"              => "Recommendation: Set the Relying Party ID to your domain name (e.g., yourwebsite.com) for better security and compatibility.",
	"PASSKEY_VALIDATION_HTTPS_REQUIRED"         => "Configuration Error: HTTPS is required for passkeys to work on a live server. Your site appears to be on HTTP.",
	"PASSKEY_VALIDATION_NETWORK"                => "Network Warning", // Generic prefix for network issues
	"PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK"  => "Recommendation: If you experience issues, try a different network (e.g., switch from corporate Wi-Fi to a mobile hotspot).",
	"PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET"  => "Recommendation: For cross-device actions, ensure both devices have a reliable internet connection.",
	"PASSKEY_VALIDATION_MOBILE_FALLBACK"        => "Recommendation: If cross-device actions fail, try visiting this page directly on your mobile device to complete the action.",
	"PASSKEY_INFO_TITLE"           => "About Passkeys",
	"PASSKEY_INFO_DESC"            => "Passkeys are a secure, password-free way to sign in using your device's built-in security features like fingerprint, face recognition, or PIN. They're more secure than passwords, provide faster sign-in, work across devices when synced with password managers, and are resistant to phishing attacks. Passkeys work on modern smartphones, tablets, computers, and can be stored in password managers like 1Password, Bitwarden, iCloud Keychain, or Google Password Manager.",
	"PASSKEY_BACK_TO_LOGIN"               		 => "Back to Login",
));

//end passkeys/totp



//validation class
$lang = array_merge($lang, array(
	"VAL_SAME"				=> "must be the same",
	"VAL_EXISTS"			=> "already exists. Please choose another",
	"VAL_DB"					=> "Database Error",
	"VAL_NUM"					=> "must be a number",
	"VAL_INT"					=> "must be a whole number",
	"VAL_EMAIL"				=> "must be a valid email address",
	"VAL_NO_EMAIL"		=> "cannot be an email address",
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"JOIN_SUC"			=> "Welcome To ",
	"JOIN_THANKS"		=> "Thanks for registering!",
	"JOIN_HAVE"			=> "Have at least ",
	"JOIN_LOWER"		=> " lowercase letter",
	"JOIN_SYMBOL"		=> " symbol",
	"JOIN_CAP"			=> " capital letter",
	"JOIN_TWICE"		=> "Be typed correctly twice",
	"JOIN_CLOSED"		=> "Unfortunately registration is disabled at this time. Please contact the Site Administrator if you have any questions or concerns.",
	"JOIN_TC"				=> "Registration User Terms and Conditions",
	"JOIN_ACCEPTTC" => "I Accept User Terms and Conditions",
	"JOIN_CHANGED"	=> "Our Terms Have Changed",
	"JOIN_ACCEPT" 	=> "Accept User Terms and Conditions and Continue",
	"JOIN_SCORE"		=> "Score:",
	"JOIN_INVALID_PW"		=> "Your password is invalid",
));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "Successfully killed ",
));

//Messages
$lang = array_merge($lang, array(
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

//Two Factor Authentication
$lang = array_merge($lang, array(
	"2FA"				=> "Two Factor Authentication",
	"2FA_CONF"	=> "Are you sure you want to disable 2FA? Your account will no longer be protected.",
	"2FA_SCAN"	=> "Scan this QR code with your authenticator app or input the key",
	"2FA_THEN"	=> "Then enter one of your one-time passkeys here",
	"2FA_FAIL"	=> "There was a problem verifying 2FA. Please check Internet or contact support.",
	"2FA_CODE"	=> "2FA Code",
	"2FA_EXP"		=> "Expired 1 fingerprint",
	"2FA_EXPD"	=> "Expired",
	"2FA_EXPS"	=> "Expires",
	"2FA_ACTIVE" => "Active Sessions",
	"2FA_NOT_FN" => "No fingerprints found",
	"2FA_FP"		=> "Fingerprints",
	"2FA_NP"		=> "Login Failed  Two Factor Auth Code was not present. Please try again.",
	"2FA_INV"		=> "Login Failed  Two Factor Auth Code was invalid. Please try again.",
	"2FA_FATAL"	=> "Fatal Error  Please contact System Admin. We cannot generate a Two Factor Auth Code at this time.",

	"2FA_SECTION_TITLE"                    => "Two-Factor Authentication (TOTP)",
	"2FA_SK_ALT"						  => "If you can't scan the QR code, manually enter this secret key into your authenticator app.",

	"2FA_IS_ENABLED"                       => "Two-factor authentication is protecting your account.",
	"2FA_NOT_ENABLED_INFO"                 => "Two-factor authentication is not currently enabled.",
	"2FA_NOT_ENABLED_EXPLAIN"              => "Two-factor authentication (TOTP) adds an extra layer of security to your account by requiring a code from an authenticator app on your phone addition to your password.",

	// Setup Process
	"2FA_SETUP_TITLE"                      => "Setup Two-Factor Authentication",
	"2FA_SECRET_KEY_LABEL"                 => "Secret Key:",
	"2FA_SETUP_VERIFY_CODE_LABEL"          => "Enter Verification Code from App",

	// Backup Codes
	"2FA_SUCCESS_ENABLED_TITLE"            => "Two-Factor Authentication Enabled! Save Your Backup Codes",
	"2FA_SUCCESS_ENABLED_INFO"             => "Below are your backup codes. Store them securely - each can only be used once.",
	"2FA_BACKUP_CODES_WARNING"             => "Treat these codes like passwords. Store them securely.",
	"2FA_SUCCESS_BACKUP_REGENERATED"       => "New backup codes generated. Save them securely.",
	"2FA_BACKUP_CODE_LABEL"                => "Backup Code",
	"2FA_REGEN_CODES_BTN"                  => "Regenerate Backup Codes",
	"2FA_INVALIDATE_WARNING" 			=> "This will invalidate all existing backup codes. Are you sure?",

	// Authentication
	"2FA_CODE_LABEL"                       => "Authentication Code",
	"2FA_VERIFY_BTN"                       => "Verify & Sign In",
	"2FA_VERIFY_TITLE"                     => "Two-Factor Authentication Required",
	"2FA_VERIFY_INFO"                      => "Enter the 6-digit code from your authenticator app.",

	// Actions & Buttons
	"2FA_ENABLE_BTN"                       => "Enable Two-Factor Authentication",
	"2FA_DISABLE_BTN"                      => "Disable Two-Factor Authentication",
	"2FA_VERIFY_ACTIVATE_BTN"              => "Verify & Activate",
	"2FA_CANCEL_SETUP_BTN"                 => "Cancel Setup",
	"2FA_DONE_BTN"                         => "Done",

	// Success Messages
	"REDIR_2FA_DIS"                 => "Two-factor authentication has been disabled.",
	"2FA_SUCCESS_BACKUP_ACK"               => "Backup codes acknowledged.",
	"2FA_SUCCESS_SETUP_CANCELLED"          => "Setup cancelled.",

	// Error Messages
	"2FA_ERR_INVALID_BACKUP"               => "Invalid backup code. Please try again.",
	"2FA_ERR_DISABLE_FAILED"               => "Failed to disable two-factor authentication.",
	"2FA_ERR_NO_SECRET"                    => "Could not retrieve authentication secret. Please try again.",
	"2FA_ERR_BACKUP_INVALIDATE_FAIL"       => "Backup code verified but failed to invalidate. Please contact support.",
	"2FA_ERR_NO_CODE_PROVIDED"             => "No authentication code provided.",

	"RATE_LIMIT_LOGIN"              => "Too many failed login attempts. Please wait before trying again.",
	"RATE_LIMIT_TOTP"               => "Too many incorrect authentication codes. Please wait before trying again.",
	"RATE_LIMIT_PASSKEY"            => "Too many passkey authentication attempts. Please wait before trying again.",
	"RATE_LIMIT_PASSKEY_STORE"      => "Too many passkey registration attempts. Please wait before trying again.",
	"RATE_LIMIT_PASSWORD_RESET"     => "Too many password reset requests. Please wait before requesting another reset.",
	"RATE_LIMIT_PASSWORD_RESET_SUBMIT" => "Too many password reset attempts. Please wait before trying again.",
	"RATE_LIMIT_REGISTRATION"       => "Too many registration attempts. Please wait before trying again.",
	"RATE_LIMIT_EMAIL_VERIFICATION" => "Too many email verification requests. Please wait before requesting another verification.",
	"RATE_LIMIT_EMAIL_CHANGE"       => "Too many email change requests. Please wait before trying again.",
	"RATE_LIMIT_PASSWORD_CHANGE"    => "Too many password change attempts. Please wait before trying again.",
	"RATE_LIMIT_GENERIC"            => "Too many attempts. Please wait before trying again.",

));

$lang = array_merge($lang, array(
	"REDIR_2FA"						=> "Sorry.Two factor is not enabled at this time",
	"REDIR_2FA_EN"				=> "Two Factor Authentication Enabled",
	"REDIR_2FA_DIS"				=> "Two Factor Authentication Disabled",
	"REDIR_2FA_VER"				=> "Two Factor Authentication Verified and Enabled",
	"REDIR_SOMETHING_WRONG" => "Something went wrong. Please try again.",
	"REDIR_MSG_NOEX"			=> "That thread does not belong to you or does not exist.",
	"REDIR_UN_ONCE"				=> "Username has already been changed once.",
	"REDIR_EM_SUCC"				=> "Email Updated Successfully",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "Sign in with:",
	"EML_FEATURE_DISABLED"        => "This feature is disabled",
	"EML_PASSWORDLESS_SENT" => "Please check your email for a link to login.",
	"EML_PASSWORDLESS_SUBJECT" => "Please verify your email to login.",
	"EML_PASSWORDLESS_BODY" => "Please verify your email address by clicking the link below. You will be automatically logged in.",
	"EML_CONF"			=> "Confirm Email",
	"EML_VER"				=> "Verify Your Email",
	"EML_CHK"				=> "Email request received. Please check your email to perform verification. Be sure to check your Spam and Junk folder as the verification email expires in ",
	"EML_MAT"				=> "Your email did not match.",
	"EML_HELLO"			=> "Hello from ",
	"EML_HI"				=> "Hi ",
	"EML_AD_HAS"		=> "An Administrator has reset your password.",
	"EML_AC_HAS"		=> "An Administrator has created your account.",
	"EML_REQ"				=> "You will be required to set your password using the link above.",
	"EML_EXP"				=> "Please note: Password emails expire in ",
	"EML_VER_EXP"		=> "Please note: Verification emails expire in ",
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
$lang = array_merge($lang, array(
	"VER_SUC"			=> "Your Email has been verified!",
	"VER_FAIL"		=> "We were unable to verify your account. Please try again.",
	"VER_RESEND"	=> "Resend Verification Email",
	"VER_AGAIN"		=> "Enter your email address and try again",
	"VER_PAGE"		=> "<li>Check your email and click the link that is sent to you</li><li>Done</li>",
	"VER_RES_SUC" => " Your verification link has been sent to your email address.  Click the link in the email to complete verification. Be sure to check your spam folder if the email isn't in your inbox.  Verification links are only valid for ",
	"VER_OOPS"		=> "Oops...something went wrong, maybe an old reset link you clicked on. Click below to try again",
	"VER_RESET"		=> "Your password has been reset!",
	"VER_INS"			=> "<li>Enter your email address and click Reset</li> <li>Check your email and click the link that is sent to you.</li>
												<li>Follow the on screen instructions</li>",
	"VER_SENT"		=> " Your password reset link has been sent to your email address. 
			    							 Click the link in the email to Reset your password. Be sure to check your spam folder if the email isn't in your inbox.  Reset links are only valid for ",
	"VER_PLEASE"	=> "Please reset your password",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"				=> "Reset PIN",
	"SET_WHY"				=> "Why can't I change this?",
	"SET_PW_MATCH"	=> "Must match the New Password",

	"SET_PIN_NEXT"	=> "You can set a new PIN the next time you require verification",
	"SET_UPDATE"		=> "Update your user settings",
	"SET_NOCHANGE"	=> "The Administrator has disabled changing usernames.",
	"SET_ONECHANGE"	=> "The Administrator set username changes to occur only once and you have done so already.",

	"SET_GRAVITAR"	=> "Want to change your profile picture?  <br> Visit <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> and setup an account with the same email you used on this site. It works across millions of sites. It's fast and easy!",

	"SET_NOTE1"			=> " Please note  there is a pending request to update your email to",

	"SET_NOTE2"			=> ".  Please use the verification email to complete this request. 
		 If you need a new verification email, please re-enter the email above and submit the request again. ",

	"SET_PW_REQ" 		=> "required for changing password, email, or resetting PIN",
	"SET_PW_REQI" 	=> "Required to change your password",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "Failed to kill active sessions, Error: ",
	"ERR_EMAIL"				=> "Email NOT sent due to error. Please contact site administrator.",
	"ERR_EM_DB"				=> "That email does not exist in our database",
	"ERR_TC"					=> "Please read and accept terms and conditions",
	"ERR_CAP"					=> "You failed the Captcha Test, Robot!",
	"ERR_PW_SAME"			=> "Your old password cannot be the same as your new",
	"ERR_PW_FAIL"			=> "Current password verification failed. Update failed. Please try again.",
	"ERR_GOOG"				=> "NOTE:  If you originally signed up with your Google/Facebook account, you will need to use the forgot password link to change your password...unless you're really good at guessing.",
	"ERR_EM_VER"			=> "Email verification is not enabled. Please contact the System Administrator.",
	"ERR_EMAIL_STR"		=> "Something is strange. Please re-verify your email. We are sorry for the inconvenience",

));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "We will be back soon!",
	"MAINT_MSG"			=> "Sorry for the inconvenience but we are performing some maintenance at the moment.<br> We will be back online shortly!",
	"MAINT_BAN"			=> "Sorry. You have been banned. If you feel this is an error, please contact the administrator.",
	"MAINT_TOK"			=> "There was an error with your form. Please go back and try again. Please note that submitting the form by refreshing the page will cause an error. If this continues to happen, please contact the administrator.",
	"MAINT_OPEN"		=> "An Open Source PHP User Management Framework.",
	"MAINT_PLEASE"	=> "You have successfully installed UserSpice!<br>To view our getting started documentation, please visit"
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}




//do not put a closing php tag here
