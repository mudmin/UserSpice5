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
%m1% - Dynamic markers which are replaced at run time by the relevant index.
*/

$lang = array();
//important strings
$lang = array_merge($lang, array(
	"THIS_LANGUAGE"	=> "Canadian",
	"THIS_CODE"			=> "en-CA",
	"MISSING_TEXT"	=> "Text is down the biffy",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "Enter the code sent to your email, eh?",
    "PASS_EMAIL_ONLY"     => "Better check your email for a login link, eh?",
    "PASS_CODE_ONLY"      => "Just pop in that code we sent to your email, eh?",
    "PASS_BOTH"           => "Take a look at your email for a login link or enter the code we sent, eh?",
    "PASS_VER_BUTTON"     => "Verify code, eh?",
    "PASS_EMAIL_ONLY_MSG" => "Give that link below a click to verify your email, eh?",
    "PASS_CODE_ONLY_MSG"  => "Pop in that code below to login, eh?",
    "PASS_BOTH_MSG"       => "Click that link below to verify your email or enter the code to login, eh?",
    "PASS_YOUR_CODE"      => "Here's your verification code, eh?: ",
    "PASS_CONFIRM_LOGIN"  => "Confirm Login, eh?",
    "PASS_CONFIRM_CLICK"  => "Just click here to finish up, eh?",
    "PASS_GENERIC_ERROR"  => "Oops, sorry about that! Something went wrong, eh?",
));

//Database Menus
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"					=> "Register, eh?",
	"SIGNUP_BUTTONTEXT"		=> "Register Me, eh?",
	"SIGNUP_AUDITTEXT"		=> "Registered, eh?",
));

// Signin
$lang = array_merge($lang, array(
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
	"SIGNIN_FORGOTPASS"	=> "Forgot Password, eh?",
	"SIGNOUT_AUDITTEXT"	=> "Logged Out, eh?",
));

// Account Page
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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

//added during passkey/totp update
$lang = array_merge($lang, array(
    "GEN_PASSKEY"                         => "Passkey",
    "GEN_ACTIONS"                         => "Actions",
    "GEN_BACK_TO_ACCT"                    => "Back to Your Account, bud",
    "GEN_DB_ERROR"                        => "Oh, sorry aboot that. A database error happened. Please give'r another go, eh?",
    "GEN_IMPORTANT"                       => "Important, eh?",
    "GEN_NO_PERMISSIONS"                  => "Sorry, you don't have permission to see this page.",
    "GEN_NO_PERMISSIONS_MSG"              => "Sorry, you can't go there. If you think this is a mistake, maybe give the site administrator a shout.",
    "PASSKEYS_MANAGE_TITLE"               => "Manage Your Passkeys, eh?",
    "PASSKEYS_LOGIN_TITLE"                => "Log in with a Passkey",
    "PASSKEY_DELETE_SUCCESS"              => "She's gone! Passkey deleted successfully.",
    "PASSKEY_DELETE_FAIL_DB"              => "Well, that's a kerfuffle. Couldn't delete the passkey from the database.",
    "PASSKEY_DELETE_NOT_FOUND"            => "Couldn't find that passkey, or maybe you don't have permission. Sorry!",
    "PASSKEY_NOTE_UPDATE_SUCCESS"         => "Beauty! Passkey note updated.",
    "PASSKEY_NOTE_UPDATE_FAIL"            => "Shoot, couldn't update the passkey note. Sorry.",
    "PASSKEY_REGISTER_NEW"                => "Register a New Passkey",
    "PASSKEY_ERR_LIMIT_REACHED"           => "Whoa there! You've hit the max of 10 passkeys. That's more toques than one person needs, eh?",
    "PASSKEY_NOTE_TH"                     => "Passkey Note",
    "PASSKEY_TIMES_USED_TH"               => "Times Used",
    "PASSKEY_LAST_USED_TH"                => "Last Used",
    "PASSKEY_LAST_IP_TH"                  => "Last IP",
    "PASSKEY_EDIT_NOTE_BTN"               => "Edit Note",
    "PASSKEY_CONFIRM_DELETE_JS"           => "Are you sure you wanna get rid of this passkey, eh? No take-backsies.",
    "PASSKEY_EDIT_MODAL_TITLE"            => "Edit Your Passkey Note",
    "PASSKEY_EDIT_MODAL_LABEL"            => "Passkey Note",
    "PASSKEY_SAVE_CHANGES_BTN"            => "Save Changes",
    "PASSKEY_NONE_REGISTERED"             => "Looks like you don't have any passkeys registered yet, bud.",
    "PASSKEY_MUST_REGISTER_FIRST"         => "You gotta register a passkey from a logged-in account first before you can use this feature.",
    "PASSKEY_STORING"                     => "Storin' your passkey...",
    "PASSKEY_STORED_SUCCESS"              => "All set! Passkey stored successfully.",
    "PASSKEY_INVALID_ACTION"              => "That's not a valid action, sorry: ",
    "PASSKEY_NO_ACTION_SPECIFIED"         => "No action specified, eh?",
    "PASSKEY_ERR_NETWORK_SUGGESTION"      => "Looks like a network issue. Maybe try a different one or give the page a refresh?",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "Cross-device thingy detected. Make sure both gizmos have internet, eh?",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "If that doesn't work, try opening this page right on your phone.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"       => "Couldn't generate diagnostics, sorry: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"     => "Missing some required credential data for storage. Whoops!",
    "PASSKEY_MISSING_AUTH_DATA"           => "Missing some required authentication data, bud.",
    "PASSKEY_LOG_NO_MESSAGE"              => "No message",
    "PASSKEY_USER_NOT_FOUND"              => "Couldn't find a user after that passkey validation. Weird.",
    "PASSKEY_FATAL_ERROR"                 => "Oh, that's a beaut of an error: ",
    "PASSKEY_LOGIN_SUCCESS"               => "You're in! Login successful.",
    // JavaScript status messages (passkeys.php)
    "PASSKEY_CROSS_DEVICE_PREP"           => "Gettin' ready for cross-device registration. You might need to grab your phone or tablet.",
    "PASSKEY_DEVICE_REGISTRATION"         => "Using this device's passkey registration...",
    "PASSKEY_STARTING_REGISTRATION"       => "Starting up the passkey registration...",
    "PASSKEY_REQUEST_OPTIONS"             => "Asking the server for registration options...",
    "PASSKEY_FOLLOW_PROMPTS"              => "Just follow the prompts to create your passkey. Might need another device, eh?",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"       => "Follow the prompts to create your passkey...",
    "PASSKEY_CREATION_FAILED"             => "Passkey creation failed - didn't get a credential back. Bummer.",
    "PASSKEY_STORING_SERVER"              => "Storing your passkey now...",
    "PASSKEY_CREATED_SUCCESS"             => "Right on! Passkey created successfully!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP"      => "Prepping for cross-device authentication. Make sure your phone and computer have internet.",
    "PASSKEY_DEVICE_AUTH"                 => "Using this device's passkey authentication...",
    "PASSKEY_STARTING_AUTH"               => "Starting passkey authentication...",
    "PASSKEY_QR_CODE_INSTRUCTION"         => "Scan the QR code with your phone when it pops up. Both devices need internet, eh?",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"    => "Choose \"Use a phone or tablet\" when it asks, then scan the QR code.",
    "PASSKEY_AUTHENTICATING"              => "Authenticating with your passkey...",
    "PASSKEY_SUCCESS_REDIRECTING"         => "Authentication's good! Redirecting ya now...",
    // Timeout messages
    "PASSKEY_TIMEOUT_CROSS_DEVICE"        => "Registration timed out. For cross-device: 1) Give'r another try, 2) Make sure both devices have internet, 3) Maybe just register right on your phone, eh?",
    "PASSKEY_TIMEOUT_SIMPLE"              => "Registration timed out. Please try again, sorry.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"   => "Cross-device authentication timed out. Troubleshooting: 1) Both devices need internet, 2) Try scanning the QR code a bit quicker, 3) Maybe use the same device, 4) Some networks are hosers and block this.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"         => "Authentication timed out. Please try again.",
    "PASSKEY_NO_CREDENTIAL"               => "No credential received. Let's try that again...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"   => "Authentication failed - didn't get a credential back. Sorry.",
    "PASSKEY_ATTEMPT_RETRY"               => "failed. Retrying... (%d attempts remaining, bud)",
    // Error messages
    "PASSKEY_CROSS_DEVICE_FAILED"         => "Cross-device registration failed. Try: 1) Make sure both devices have internet, 2) Maybe just register on your phone, 3) Some corporate networks can be a real pain aboot this.",
    "PASSKEY_REGISTRATION_CANCELLED"      => "Registration was cancelled or this device doesn't support passkeys. No worries.",
    "PASSKEY_NOT_SUPPORTED"               => "Sorry, passkeys aren't supported on this device/browser combo.",
    "PASSKEY_SECURITY_ERROR"              => "Security error - that usually means a domain/origin mismatch.",
    "PASSKEY_ALREADY_EXISTS"              => "A passkey already exists for this account on this device. Try a different device or delete the old one first, eh?",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"    => "Cross-device authentication failed. Try: 1) Make sure both gizmos have stable internet, 2) Use the same WiFi if you can, 3) Try authenticating right on your phone instead, 4) Some networks just don't like this feature.",
    "PASSKEY_AUTH_CANCELLED"              => "Authentication was cancelled or no passkey was selected.",
    "PASSKEY_NETWORK_ERROR"               => "Network error. For cross-device stuff, both devices need internet and might need to be on the same network.",
    "PASSKEY_CREDENTIAL_NOT_FOUND"        => "Authentication failed - credential not recognized. Sorry!",
    // Cross-device guidance
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "Cross-Device Authentication Tips:",
    "PASSKEY_GUIDANCE_INTERNET"           => "Make sure both your computer and phone have internet access",
    "PASSKEY_GUIDANCE_WIFI"               => "Being on the same WiFi network can help (but isn't always required)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"      => "When prompted, select \"Use a phone or tablet\"",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"       => "Scan the QR code pretty quick when it appears, eh?",
    "PASSKEY_GUIDANCE_TRY_DIRECT"         => "If it fails, try refreshing and using your phone's browser directly",
    // Troubleshooting
    "PASSKEY_SHOW_TROUBLESHOOTING"        => "Show Troubleshooting Tips",
    "PASSKEY_HIDE_TROUBLESHOOTING"        => "Hide Troubleshooting Tips",
    "PASSKEY_DIAGNOSTICS_RUNNING"         => "Running diagnostics...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"        => "Diagnostics complete. Check the console for the details, eh?",
    "PASSKEY_ISSUES_DETECTED"             => "Issues detected:",
    "PASSKEY_ENVIRONMENT_SUITABLE"        => "Environment looks good for passkeys.",
    "PASSKEY_DIAGNOSTICS_FAILED"          => "Diagnostics failed:",
    // Modal
    "PASSKEY_ADD_NOTE_NEW"                => "Add a Note to Your New Passkey",
    // Technical errors
    "PASSKEY_BASE64_ERROR"                => "Base64 decode error:",
    // Server-side errors (passkey_parser.php)
    "PASSKEY_INVALID_JSON"                => "Invalid JSON data received:",
    // Session/validation errors (PasskeyHandler.php)
    "PASSKEY_NO_CHALLENGE_SESSION"        => "No passkey registration challenge found in the session. Please try registering again, sorry.",
    "PASSKEY_USER_MISMATCH"               => "User ID mismatch. Please try registering again.",
    "PASSKEY_CHALLENGE_USER_MISMATCH"     => "User ID in challenge options doesn't match the current user. Please try registering again.",
    "PASSKEY_REGISTRATION_FAILED_ERROR"   => "Passkey registration failed. Please make sure your device and browser support WebAuthn and try again. Error:",
    "PASSKEY_NO_AUTH_CHALLENGE_SESSION"   => "No passkey assertion challenge found in the session. Please try logging in again.",
    "PASSKEY_CREDENTIAL_NOT_IN_DB"        => "Passkey credential not found in the database.",
    "PASSKEY_CREDENTIAL_WRONG_USER"       => "Passkey credential doesn't belong to the expected user.",
    "PASSKEY_VALIDATION_FAILED_ERROR"     => "Passkey validation failed. Please try again or contact support if the issue persists. Error:",
    "PASSKEY_USER_NOT_FOUND_REGISTRATION" => "User not found for registration.",
    // --- Used in passkey_parser.php ---
    "PASSKEY_LOGIN_REQUIRED"              => "You must be logged in to do that, bud.",
    "PASSKEY_ACTION_MISSING"              => "The required 'action' parameter was missing from the request. Whoops.",
    "PASSKEY_STORAGE_FAILED"              => "Failed to store the passkey. The operation was unsuccessful, sorry.",
    "PASSKEY_LOGIN_FAILED"                => "Passkey login failed. Couldn't verify the authentication.",
    "PASSKEY_INVALID_METHOD"              => "Invalid request method:",
    // --- Used in passkeys.php ---
    "CSRF_ERROR"                          => "CSRF token check failed. Please go back and try submitting the form again, eh?",
    // Network analysis from analyzeNetworkConditions()
    "PASSKEY_NETWORK_PRIVATE"             => "Potential Issue: You seem to be on a private network, which can sometimes cause a kerfuffle with cross-device communication.",
    "PASSKEY_NETWORK_PROXY"               => "Potential Issue: A proxy or VPN was detected. This might interfere with cross-device communication.",
    "PASSKEY_NETWORK_MOBILE"              => "Note: You seem to be on a mobile network. Make sure you have a good connection for cross-device operations.",
    "PASSKEY_NETWORK_CORPORATE"           => "Potential Issue: A corporate firewall might be active, which could affect cross-device authentication.",
    // Recommendations from getCrossDeviceRecommendations()
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "Recommendation: You're likely on a desktop. Get ready to use your phone to scan a QR code.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "Recommendation: For best results, make sure your computer and mobile device are on the same Wi-Fi network.",
    "PASSKEY_RECOMMENDATION_QR_QUICK"     => "Recommendation: Be ready to scan the QR code quickly, as the request might time out.",
    "PASSKEY_RECOMMENDATION_INTERNET"     => "Recommendation: Make sure both your computer and your mobile device have a stable internet connection.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "Recommendation: For Unity WebViews, make sure the page has enough time to load and process the passkey request.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "Recommendation: Timeouts might be longer in Unity. Please be patient, eh?",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "Recommendation: Since you're on mobile, you should be able to register a passkey directly to this device.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Recommendation: On Android, you can manage your passkeys in the Google Password Manager.",
    // Validation from validateCrossDeviceEnvironment()
    "PASSKEY_VALIDATION_RP_IP"            => "Configuration Warning: The Relying Party ID is set to an IP address.",
    "PASSKEY_VALIDATION_RP_DOMAIN"        => "Recommendation: Set the Relying Party ID to your domain name (e.g., yourwebsite.ca) for better security and compatibility.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"   => "Configuration Error: HTTPS is required for passkeys to work on a live server. Your site appears to be on HTTP.",
    "PASSKEY_VALIDATION_NETWORK"          => "Network Warning",
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "Recommendation: If you run into issues, try a different network (e.g., switch from corporate Wi-Fi to a mobile hotspot).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "Recommendation: For cross-device actions, make sure both devices have a reliable internet connection.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"  => "Recommendation: If cross-device actions fail, try visiting this page directly on your mobile device to complete the action.",
    "PASSKEY_INFO_TITLE"                  => "Aboot Passkeys",
    "PASSKEY_INFO_DESC"                   => "Passkeys are a real slick way to sign in without a password, eh? They use your device's built-in security like fingerprint, face recognition, or a PIN. They're safer than a goalie in the third period, get you signed in faster, work across your devices when synced up, and are resistant to phishing. They work on modern phones, tablets, computers, and you can keep 'em in password managers like 1Password, Bitwarden, iCloud Keychain, or Google Password Manager.",
    "PASSKEY_BACK_TO_LOGIN"               => "Back to Login",
));

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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"JOIN_SUC"		=> "Tim Hortons presents",
	"JOIN_THANKS"	=> "Thanks for registering!, eh?",
	"JOIN_HAVE"		=> "Have at least , eh?",
	"JOIN_LOWER"	=> " lowercase letter, eh?",
	"JOIN_SYMBOL"		=> " special funny squiggly character, eh?",
	"JOIN_CAP"		=> " capital letter, eh?",
	"JOIN_TWICE"	=> "Be typed correctly twice, eh?",
	"JOIN_CLOSED"	=> "Unfortunately registration is disabled at this time. Please contact the Site Administrator if you have any questions or concerns., eh?",
	"JOIN_TC"			=> "Registration User Terms and Conditions, eh?",
	"JOIN_ACCEPTTC" => "I Absolootley Accept User Terms and Conditions,",
	"JOIN_CHANGED"	=> "Our Terms Have Changed",
	"JOIN_ACCEPT" 	=> "Oookey Dookie",
	"JOIN_SCORE" => "Score, eh:",
	"JOIN_INVALID_PW" => "Sorry, bud. Your password ain't quite right, eh?",

));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "Successfully killed , eh?",
));

//Messages
$lang = array_merge($lang, array(
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

//Two Factor Authentication
$lang = array_merge($lang, array(
    "2FA"                                => "Two-Factor Authentication",
    "2FA_CONF"                           => "Are you sure you want to disable 2FA? Sorry, but your account won't be as protected.",
    "2FA_SCAN"                           => "Scan this QR code with your authenticator app or pop in the key",
    "2FA_THEN"                           => "Then enter one of your one-time passkeys here, eh?",
    "2FA_FAIL"                           => "There was a problem verifying 2FA. Please check your internet or give support a shout, sorry.",
    "2FA_CODE"                           => "2FA Code",
    "2FA_EXP"                            => "Expired 1 fingerprint",
    "2FA_EXPD"                           => "Expired",
    "2FA_EXPS"                           => "Expires",
    "2FA_ACTIVE"                         => "Active Sessions",
    "2FA_NOT_FN"                         => "No fingerprints found, bud.",
    "2FA_FP"                             => "Fingerprints",
    "2FA_NP"                             => "Login Failed - Two Factor Auth Code was not present. Please try again, eh?",
    "2FA_INV"                            => "Login Failed - Two Factor Auth Code was invalid. Please try again, sorry.",
    "2FA_FATAL"                          => "Fatal Error - Please contact the System Admin. We can't generate a Two Factor Auth Code right now.",
    "2FA_SECTION_TITLE"                  => "Two-Factor Authentication (TOTP)",
    "2FA_SK_ALT"                         => "If you can't scan the QR code, just manually enter this secret key into your authenticator app.",
    "2FA_IS_ENABLED"                     => "Two-factor authentication is protecting your account. Good on ya!",
    "2FA_NOT_ENABLED_INFO"               => "Two-factor authentication isn't currently enabled.",
    "2FA_NOT_ENABLED_EXPLAIN"            => "Two-factor authentication (TOTP) adds an extra layer of security, like a good toque in winter. It requires a code from an app on your phone in addition to your password.",
    // Setup Process
    "2FA_SETUP_TITLE"                    => "Set up Two-Factor Authentication",
    "2FA_SECRET_KEY_LABEL"               => "Secret Key:",
    "2FA_SETUP_VERIFY_CODE_LABEL"        => "Enter Verification Code from App",
    // Backup Codes
    "2FA_SUCCESS_ENABLED_TITLE"          => "Two-Factor Authentication Enabled! Save Your Backup Codes",
    "2FA_SUCCESS_ENABLED_INFO"           => "Below are your backup codes. Keep 'em safe, like a fresh jar of maple syrup - each one can only be used once.",
    "2FA_BACKUP_CODES_WARNING"           => "Treat these codes like passwords. Keep them somewhere safe.",
    "2FA_SUCCESS_BACKUP_REGENERATED"     => "New backup codes generated. Save them somewhere safe, eh?",
    "2FA_BACKUP_CODE_LABEL"              => "Backup Code",
    "2FA_REGEN_CODES_BTN"                => "Regenerate Backup Codes",
    "2FA_INVALIDATE_WARNING"             => "This will invalidate all existing backup codes. Are you sure aboot that?",
    // Authentication
    "2FA_CODE_LABEL"                     => "Authentication Code",
    "2FA_VERIFY_BTN"                     => "Verify & Sign In",
    "2FA_VERIFY_TITLE"                   => "Two-Factor Authentication Required",
    "2FA_VERIFY_INFO"                    => "Enter the 6-digit code from your authenticator app.",
    // Actions & Buttons
    "2FA_ENABLE_BTN"                     => "Enable Two-Factor Authentication",
    "2FA_DISABLE_BTN"                    => "Disable Two-Factor Authentication",
    "2FA_VERIFY_ACTIVATE_BTN"            => "Verify & Activate",
    "2FA_CANCEL_SETUP_BTN"               => "Cancel Setup",
    "2FA_DONE_BTN"                       => "Done",
    // Success Messages
    "REDIR_2FA_DIS"                      => "Two-factor authentication has been disabled.",
    "2FA_SUCCESS_BACKUP_ACK"             => "Backup codes acknowledged.",
    "2FA_SUCCESS_SETUP_CANCELLED"        => "Setup cancelled. No worries.",
    // Error Messages
    "2FA_ERR_INVALID_BACKUP"             => "Sorry, that's an invalid backup code. Please try again.",
    "2FA_ERR_DISABLE_FAILED"             => "Failed to disable two-factor authentication. Sorry aboot that.",
    "2FA_ERR_NO_SECRET"                  => "Couldn't retrieve the authentication secret. Please try again.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"     => "Backup code was verified but failed to invalidate. Please contact support, sorry.",
    "2FA_ERR_NO_CODE_PROVIDED"           => "No authentication code provided.",
    "RATE_LIMIT_LOGIN"                   => "Whoa, take'er easy! Too many failed login attempts. Please wait a bit before trying again, sorry.",
    "RATE_LIMIT_TOTP"                    => "Too many incorrect authentication codes. Maybe go for a walk and try again in a bit.",
    "RATE_LIMIT_PASSKEY"                 => "Too many passkey authentication attempts. Please wait a bit before trying again.",
    "RATE_LIMIT_PASSKEY_STORE"           => "Too many passkey registration attempts. Please wait a bit.",
    "RATE_LIMIT_PASSWORD_RESET"          => "Too many password reset requests. Please wait before asking for another one.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT"   => "Too many password reset attempts. Please wait a bit before trying again.",
    "RATE_LIMIT_REGISTRATION"            => "Too many registration attempts. Please wait before trying again, eh?",
    "RATE_LIMIT_EMAIL_VERIFICATION"      => "Too many email verification requests. Please wait before asking for another one.",
    "RATE_LIMIT_EMAIL_CHANGE"            => "Too many email change requests. Please try again in a bit.",
    "RATE_LIMIT_PASSWORD_CHANGE"         => "Too many password change attempts. Please wait before trying again.",
    "RATE_LIMIT_GENERIC"                 => "Aboot time for a little break, eh? Too many attempts. Please wait before trying again.",
));


$lang = array_merge($lang, array(
	"REDIR_2FA"						=> "Sorry.Two factor is not enabled at this time, eh?",
	"REDIR_2FA_EN"				=> "2 Factor Authentication Enabled, eh?",
	"REDIR_2FA_DIS"				=> "2 Factor Authentication Disabled, eh?",
	"REDIR_2FA_VER"				=> "2 Factor Authentication Verified and Enabled, eh?",
	"REDIR_SOMETHING_WRONG" => "Something went wrong. Please try again., eh?",
	"REDIR_MSG_NOEX"			=> "That thread does not belong to you or does not exist., eh?",
	"REDIR_UN_ONCE"				=> "Username has already been changed once., eh?",
	"REDIR_EM_SUCC"				=> "Email Updated Successfully, eh?",
));

//Emails
$lang = array_merge($lang, array(

	"EML_SIGN_IN_WITH" => "Sign in with, eh:",
	"EML_FEATURE_DISABLED" => "Sorry, this feature is disabled, eh",
	"EML_PASSWORDLESS_SENT" => "Could you check your email for a link to login, eh?",
	"EML_PASSWORDLESS_SUBJECT" => "Hey, could you verify your email to login, eh?",
	"EML_PASSWORDLESS_BODY" => "Hey there, could you verify your email address by clicking the link below, eh? You'll be automatically logged in, bud.",

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
$lang = array_merge($lang, array(
	"VER_SUC"			=> "Your Email has been verified!, eh?",
	"VER_FAIL"		=> "We were unable to verify your account. Please try again., eh?",
	"VER_RESEND"	=> "Resend Verification Email, eh?",
	"VER_AGAIN"		=> "Enter your email address and try again, eh?",
	"VER_PAGE"		=> "<li>Check your email and click the link that is sent to you</li><li>Done</li>, eh?",
	"VER_RES_SUC" => " Your verification link has been sent to your email address.  Click the link in the email to complete verification. Be sure to check your spam folder if the email isn't in your inbox.  Verification links are only valid for , eh?",
	"VER_OOPS" => "Oops...something went wrong, maybe an old reset link you clicked on. Click below to try again",
	"VER_RESET" => "Your password has been reset!",
	"VER_INS" => "<li>Enter your email address and click Reset</li> <li>Check your email and click the link that is sent to you.</li> <li>Follow the on screen instructions</li><li>Get a donut at Tim's</li>",
	"VER_SENT" => " Your password reset link has been sent to your email address.   Click the link in the email to Reset your password. Be sure to check your spam folder if the email isn't in your inbox.  Reset links are only valid for ",
	"VER_PLEASE" => "Please reset your password, pretty please",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"				=> "Reset PIN, eh?",
	"SET_WHY"				=> "Why can't I change this?, eh?",
	"SET_PW_MATCH"	=> "Must match the New Password, eh?",

	"SET_PIN_NEXT"	=> "You can set a new PIN the next time you require verification, eh?",
	"SET_UPDATE"		=> "Update your user settings, eh?",
	"SET_NOCHANGE"	=> "The Administrator has disabled changing usernames., eh?",
	"SET_ONECHANGE"	=> "The Administrator set username changes to occur only once and you have done so already., eh?",

	"SET_GRAVITAR"	=> "Want to change your profile picture?  <br> Visit <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> and setup an account with the same email you used on this site.It works across millions of sites. It's fast and easy!, eh?",

	"SET_NOTE1"			=> " Please note  there is a pending request to update your email to, eh?",

	"SET_NOTE2"			=> ".  Please use the verification email to complete this request. 
		 If you need a new verification email, please re-enter the email above and submit the request again. , eh?",

	"SET_PW_REQ" 		=> "required for changing password, email, or resetting PIN, eh?",
	"SET_PW_REQI" 	=> "Required to change your password, eh?",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "Failed to kill active sessions, Error: , eh?",
	"ERR_EMAIL"				=> "Email NOT sent due to error. Please contact site administrator., eh?",
	"ERR_EM_DB"				=> "That email does not exist in our database, eh?",
	"ERR_TC"					=> "Please read and accept terms and conditions, eh?",
	"ERR_CAP"					=> "You failed the Captcha Test, Robot!, eh?",
	"ERR_PW_SAME"			=> "Your old password cannot be the same as your new, eh?",
	"ERR_PW_FAIL"			=> "Current password verification failed. Update failed. Please try again., eh?",
	"ERR_GOOG"				=> "NOTE:  If you originally signed up with your Google/Facebook account, you will need to use the forgot password link to change your password...unless you're really good at guessing., eh?",
	"ERR_EM_VER"			=> "Email verification is not enabled. Please contact the System Administrator., eh?",
	"ERR_EMAIL_STR"		=> "Something is strange. Please re-verify your email. We are sorry for the inconvenience, eh?",
));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "We will be back soon!, eh?",
	"MAINT_MSG"			=> "Sorry for the inconvenience but we are performing some maintenance at the moment.<br> We will be back online shortly!, eh?",
	"MAINT_BAN" => "The Americans made us put a wall around you. Sorry.",
	"MAINT_TOK" => "There was an error with your form. Please go back and try again. Please note that submitting the form by refreshing the page will cause an error. If this continues to happen, please contact a local beaver to chew through the problem.",
	"MAINT_OPEN" => "It's free, like America.",
	"MAINT_PLEASE" => "So sit back, grab a donut and visit",
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

//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
