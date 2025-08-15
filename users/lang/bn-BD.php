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

/* Language Pack: Bengali
   Country: Bangladesh
   Language Code: bn-BD
   Author: Meraj-Ul Islam
   Web: https://merajbd.com
   Email: merajbd7@gmail.com
   GitHub: MerajBD
*/

$lang = array();
//important strings
//You definitely want to customize these for your language
$lang = array_merge($lang, array(
	"THIS_LANGUAGE"	=> "বাংলা",
	"THIS_CODE"			=> "bn-BD",
	"MISSING_TEXT"	=> "Missing Text",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "Zadejte kód zaslaný na váš e-mail",
    "PASS_EMAIL_ONLY"     => "Zkontrolujte prosím svůj e-mail pro přihlašovací odkaz",
    "PASS_CODE_ONLY"      => "Zadejte prosím kód zaslaný na váš e-mail",
    "PASS_BOTH"           => "Zkontrolujte prosím svůj e-mail pro přihlašovací odkaz nebo zadejte kód zaslaný na váš e-mail",
    "PASS_VER_BUTTON"     => "Ověřit kód",
    "PASS_EMAIL_ONLY_MSG" => "Ověřte prosím svou e-mailovou adresu kliknutím na odkaz níže",
    "PASS_CODE_ONLY_MSG"  => "Pro přihlášení zadejte kód níže",
    "PASS_BOTH_MSG"       => "Ověřte prosím svou e-mailovou adresu kliknutím na odkaz níže nebo se přihlaste zadáním kódu níže",
    "PASS_YOUR_CODE"      => "Váš ověřovací kód je: ",
    "PASS_CONFIRM_LOGIN"  => "Potvrdit přihlášení",
    "PASS_CONFIRM_CLICK"  => "Klikněte pro dokončení přihlášení",
    "PASS_GENERIC_ERROR"  => "Něco se pokazilo",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "আপনার ইমেইলে পাঠানো কোডটি লিখুন",
    "PASS_EMAIL_ONLY"     => "লগইন লিংকের জন্য আপনার ইমেইল চেক করুন",
    "PASS_CODE_ONLY"      => "আপনার ইমেইলে পাঠানো কোডটি লিখুন",
    "PASS_BOTH"           => "লগইন লিংকের জন্য আপনার ইমেইল চেক করুন অথবা ইমেইলে পাঠানো কোডটি লিখুন",
    "PASS_VER_BUTTON"     => "কোড যাচাই করুন",
    "PASS_EMAIL_ONLY_MSG" => "নিচের লিংকে ক্লিক করে আপনার ইমেইল ঠিকানা যাচাই করুন",
    "PASS_CODE_ONLY_MSG"  => "লগইন করতে নিচের কোডটি লিখুন",
    "PASS_BOTH_MSG"       => "নিচের লিংকে ক্লিক করে আপনার ইমেইল ঠিকানা যাচাই করুন অথবা লগইন করতে নিচের কোডটি লিখুন",
    "PASS_YOUR_CODE"      => "আপনার যাচাইকরণ কোড হলো: ",
    "PASS_CONFIRM_LOGIN"  => "লগইন নিশ্চিত করুন",
    "PASS_CONFIRM_CLICK"  => "লগইন সম্পন্ন করতে ক্লিক করুন",
    "PASS_GENERIC_ERROR"  => "কিছু একটা ভুল হয়েছে",
));

//Database Menus
$lang = array_merge($lang, array(
	"MENU_HOME"			=> "প্রধান পৃষ্ঠা",
	"MENU_HELP"			=> "সাহায্য",
	"MENU_ACCOUNT"	=> "একাউন্ট",
	"MENU_DASH"			=> "পরিচালকের ড্যাশবোর্ড",
	"MENU_USER_MGR"	=> "ব্যবহারকারীদের ব্যবস্থাপনা",
	"MENU_PAGE_MGR"	=> "পৃষ্ঠা ব্যবস্থাপনা",
	"MENU_PERM_MGR"	=> "অনুমোদন ব্যবস্থাপনা",
	"MENU_MSGS_MGR"	=> "বার্তা ব্যবস্থাপনা",
	"MENU_LOGS_MGR"	=> "সিস্টেম লগ ব্যবস্থাপনা",
	"MENU_LOGOUT"		=> "লগ আউট",
));

// Signup
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"					=> "নিবন্ধন",
	"SIGNUP_BUTTONTEXT"		=> "আমাকে নিবন্ধিত করুন",
	"SIGNUP_AUDITTEXT"		=> "নিবন্ধিত করা হয়েছে",
));

// Signin
$lang = array_merge($lang, array(
	"SIGNIN_FAIL"				=> "** লগইন ব্যার্থ **",
	"SIGNIN_PLEASE_CHK" => "অনুগ্রহ করে আপনার ব্যাবহারকারীর নাম এবং পাসওয়ার্ড যাচাই করুন এবং পুনরায় চেষ্টা করুন",
	"SIGNIN_UORE"				=> "ব্যাবহারকারীর নাম অথবা ইমেইল",
	"SIGNIN_PASS"				=> "পাসওয়ার্ড",
	"SIGNIN_TITLE"			=> "অনুগ্রহ পুর্বক লগইন করুন",
	"SIGNIN_TEXT"				=> "লগ ইন",
	"SIGNOUT_TEXT"			=> "লগ আউট",
	"SIGNIN_BUTTONTEXT"	=> "লগইন",
	"SIGNIN_REMEMBER"		=> "আমাকে মনে রাখুন",
	"SIGNIN_AUDITTEXT"	=> "লগইন করা হয়েছে",
	"SIGNIN_FORGOTPASS"	=> "পাসওয়ার্ড ভুলে গেছি",
	"SIGNOUT_AUDITTEXT"	=> "লগ আউট করা হয়েছে",
));

// Account Page
$lang = array_merge($lang, array(
	"ACCT_EDIT"					=> "একাউন্ট তথ্য সম্পাদনা করুন",
	"ACCT_2FA"					=> "২ স্তরের যাচাই",
	"ACCT_SESS"					=> "অধিবেশন ব্যবস্থাপনা",
	"ACCT_HOME"					=> "একাউন্ট হোম",
	"ACCT_SINCE"				=> "সদস্য অবধি ",
	"ACCT_LOGINS"				=> "লগইন এর সংখ্যা ",
	"ACCT_SESSIONS"			=> "সক্রিয় অধিবেশনের সংখ্যা ",
	"ACCT_MNG_SES"			=> "আরো তথ্যের জন্য বাম পাশে থেকে অধিবেশন ব্যবস্থাপক বোতামে চাপুন",
));

//General Terms
$lang = array_merge($lang, array(
	"GEN_ENABLED"			=> "চালু করা আছে",
	"GEN_DISABLED"		=> "বন্ধ করা আছে",
	"GEN_ENABLE"			=> "চালু করুন",
	"GEN_DISABLE"			=> "বন্ধ করুন",
	"GEN_NO"					=> "না",
	"GEN_YES"					=> "হ্যা",
	"GEN_MIN"					=> "সর্বনিম্ন",
	"GEN_MAX"					=> "সর্বোচ্চ",
	"GEN_CHAR"				=> "অক্ষর", //as in characters
	"GEN_SUBMIT"			=> "জমা দিন",
	"GEN_MANAGE"			=> "ব্যবস্থাপনা",
	"GEN_VERIFY"			=> "যাচাই",
	"GEN_SESSION"			=> "অধিবেশন",
	"GEN_SESSIONS"		=> "অধিবেশনগুলো",
	"GEN_EMAIL"				=> "ইমেইল",
	"GEN_FNAME"				=> "নামের প্রথম অংশ",
	"GEN_LNAME"				=> "নামের শেষের অংশ",
	"GEN_UNAME"				=> "ব্যাবহারকারীর নাম",
	"GEN_PASS"				=> "পাসওয়ার্ড",
	"GEN_MSG"					=> "বার্তা",
	"GEN_TODAY"				=> "আজ",
	"GEN_CLOSE"				=> "বন্ধ",
	"GEN_CANCEL"			=> "বাতিল",
	"GEN_CHECK"				=> "[ বাছাই/বাদ সব ]",
	"GEN_WITH"				=> "সাথে",
	"GEN_UPDATED"			=> "হালনাগাদ করা হয়েছে",
	"GEN_UPDATE"			=> "হালনাগাদ করুন",
	"GEN_BY"					=> "মাধ্যমে",
	"GEN_FUNCTIONS"		=> "ফাংশনগুলো",
	"GEN_NUMBER"			=> "সংখ্যা",
	"GEN_NUMBERS"			=> "সংখ্যাগুলো",
	"GEN_INFO"				=> "তথ্য",
	"GEN_REC"					=> "ধারণ করা হয়েছে",
	"GEN_DEL"					=> "মুছুন",
	"GEN_NOT_AVAIL"		=> "উপলভ্য নেই",
	"GEN_AVAIL"				=> "উপলভ্য আছে",
	"GEN_BACK"				=> "পিছনে",
	"GEN_RESET"				=> "নতুন করে",
	"GEN_REQ"					=> "অবশ্যই করণীয়",
	"GEN_AND"					=> "এবং",
	"GEN_SAME"				=> "অবশ্যই এক রকম হতে হবে",
));

//added during passkey/totp update
$lang = array_merge($lang, array(
    "GEN_PASSKEY"                         => "পাসকি",
    "GEN_ACTIONS"                         => "কার্যক্রম",
    "GEN_BACK_TO_ACCT"                    => "অ্যাকাউন্টে ফিরে যান",
    "GEN_DB_ERROR"                        => "একটি ডাটাবেস ত্রুটি ঘটেছে। অনুগ্রহ করে আবার চেষ্টা করুন।",
    "GEN_IMPORTANT"                       => "গুরুত্বপূর্ণ",
    "GEN_NO_PERMISSIONS"                  => "আপনার এই পৃষ্ঠাটি দেখার অনুমতি নেই।",
    "GEN_NO_PERMISSIONS_MSG"              => "আপনার এই পৃষ্ঠাটি দেখার অনুমতি নেই। যদি আপনি মনে করেন এটি একটি ত্রুটি, অনুগ্রহ করে সাইট প্রশাসকের সাথে যোগাযোগ করুন।",
    "PASSKEYS_MANAGE_TITLE"               => "আপনার পাসকি পরিচালনা করুন",
    "PASSKEYS_LOGIN_TITLE"                => "পাসকি দিয়ে লগইন করুন",
    "PASSKEY_DELETE_SUCCESS"              => "পাসকি সফলভাবে মুছে ফেলা হয়েছে।",
    "PASSKEY_DELETE_FAIL_DB"              => "ডাটাবেস থেকে পাসকি মুছতে ব্যর্থ হয়েছে।",
    "PASSKEY_DELETE_NOT_FOUND"            => "পাসকি পাওয়া যায়নি বা অনুমতি প্রত্যাখ্যান করা হয়েছে।",
    "PASSKEY_NOTE_UPDATE_SUCCESS"         => "পাসকির নোট সফলভাবে আপডেট করা হয়েছে।",
    "PASSKEY_NOTE_UPDATE_FAIL"            => "পাসকির নোট আপডেট করতে ব্যর্থ হয়েছে।",
    "PASSKEY_REGISTER_NEW"                => "নতুন পাসকি নিবন্ধন করুন",
    "PASSKEY_ERR_LIMIT_REACHED"           => "আপনি সর্বোচ্চ ১০টি পাসকির সীমায় পৌঁছেছেন।",
    "PASSKEY_NOTE_TH"                     => "পাসকির নোট",
    "PASSKEY_TIMES_USED_TH"               => "ব্যবহৃত সংখ্যা",
    "PASSKEY_LAST_USED_TH"                => "শেষ ব্যবহার",
    "PASSKEY_LAST_IP_TH"                  => "শেষ আইপি",
    "PASSKEY_EDIT_NOTE_BTN"               => "নোট সম্পাদনা করুন",
    "PASSKEY_CONFIRM_DELETE_JS"           => "আপনি কি নিশ্চিতভাবে এই পাসকিটি মুছে ফেলতে চান?",
    "PASSKEY_EDIT_MODAL_TITLE"            => "পাসকির নোট সম্পাদনা করুন",
    "PASSKEY_EDIT_MODAL_LABEL"            => "পাসকির নোট",
    "PASSKEY_SAVE_CHANGES_BTN"            => "পরিবর্তনগুলি সংরক্ষণ করুন",
    "PASSKEY_NONE_REGISTERED"             => "আপনি এখনও কোনো পাসকি নিবন্ধন করেননি।",
    "PASSKEY_MUST_REGISTER_FIRST"         => "এই বৈশিষ্ট্যটি ব্যবহার করার আগে আপনাকে অবশ্যই একটি প্রমাণীকৃত অ্যাকাউন্ট থেকে একটি পাসকি নিবন্ধন করতে হবে।",
    "PASSKEY_STORING"                     => "পাসকি সংরক্ষণ করা হচ্ছে...",
    "PASSKEY_STORED_SUCCESS"              => "পাসকি সফলভাবে সংরক্ষিত হয়েছে!",
    "PASSKEY_INVALID_ACTION"              => "অবৈধ কার্যক্রম: ",
    "PASSKEY_NO_ACTION_SPECIFIED"         => "কোনো কার্যক্রম নির্দিষ্ট করা হয়নি",
    "PASSKEY_ERR_NETWORK_SUGGESTION"      => "নেটওয়ার্ক সমস্যা সনাক্ত করা হয়েছে। অন্য কোনো নেটওয়ার্ক চেষ্টা করুন বা পৃষ্ঠাটি রিফ্রেশ করুন।",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "ক্রস-ডিভাইস প্রমাণীকরণ সনাক্ত করা হয়েছে। নিশ্চিত করুন উভয় ডিভাইসেই ইন্টারনেট সংযোগ আছে।",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "এর পরিবর্তে সরাসরি আপনার ফোনে এই পৃষ্ঠাটি খোলার চেষ্টা করুন।",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"       => "ডায়াগনস্টিক তৈরি করা যায়নি: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"     => "সংরক্ষণের জন্য প্রয়োজনীয় প্রমাণপত্র ডেটা অনুপস্থিত।",
    "PASSKEY_MISSING_AUTH_DATA"           => "প্রয়োজনীয় প্রমাণীকরণ ডেটা অনুপস্থিত।",
    "PASSKEY_LOG_NO_MESSAGE"              => "কোনো বার্তা নেই",
    "PASSKEY_USER_NOT_FOUND"              => "পাসকি যাচাইয়ের পরে ব্যবহারকারীকে পাওয়া যায়নি।",
    "PASSKEY_FATAL_ERROR"                 => "মারাত্মক ত্রুটি: ",
    "PASSKEY_LOGIN_SUCCESS"               => "লগইন সফল হয়েছে।",
    // JavaScript status messages (passkeys.php)
    "PASSKEY_CROSS_DEVICE_PREP"           => "ক্রস-ডিভাইস নিবন্ধনের জন্য প্রস্তুতি চলছে। আপনার ফোন বা ট্যাবলেট ব্যবহার করার প্রয়োজন হতে পারে।",
    "PASSKEY_DEVICE_REGISTRATION"         => "ডিভাইসের পাসকি নিবন্ধন ব্যবহার করা হচ্ছে...",
    "PASSKEY_STARTING_REGISTRATION"       => "পাসকি নিবন্ধন শুরু হচ্ছে...",
    "PASSKEY_REQUEST_OPTIONS"             => "সার্ভার থেকে নিবন্ধনের বিকল্পগুলির জন্য অনুরোধ করা হচ্ছে...",
    "PASSKEY_FOLLOW_PROMPTS"              => "আপনার পাসকি তৈরি করতে নির্দেশাবলী অনুসরণ করুন। আপনার অন্য একটি ডিভাইস ব্যবহার করার প্রয়োজন হতে পারে।",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"       => "আপনার পাসকি তৈরি করতে নির্দেশাবলী অনুসরণ করুন...",
    "PASSKEY_CREATION_FAILED"             => "পাসকি তৈরি ব্যর্থ হয়েছে - কোনো প্রমাণপত্র ফেরত আসেনি।",
    "PASSKEY_STORING_SERVER"              => "আপনার পাসকি সংরক্ষণ করা হচ্ছে...",
    "PASSKEY_CREATED_SUCCESS"             => "পাসকি সফলভাবে তৈরি হয়েছে!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP"      => "ক্রস-ডিভাইস প্রমাণীকরণের জন্য প্রস্তুতি চলছে। নিশ্চিত করুন আপনার ফোন এবং কম্পিউটারে ইন্টারনেট সংযোগ আছে।",
    "PASSKEY_DEVICE_AUTH"                 => "ডিভাইসের পাসকি প্রমাণীকরণ ব্যবহার করা হচ্ছে...",
    "PASSKEY_STARTING_AUTH"               => "পাসকি প্রমাণীকরণ শুরু হচ্ছে...",
    "PASSKEY_QR_CODE_INSTRUCTION"         => "যখন QR কোডটি দেখা যাবে, আপনার ফোন দিয়ে সেটি স্ক্যান করুন। নিশ্চিত করুন উভয় ডিভাইসেই ইন্টারনেট সংযোগ আছে।",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"    => "যখন অনুরোধ করা হবে, \"একটি ফোন বা ট্যাবলেট ব্যবহার করুন\" নির্বাচন করুন, তারপর QR কোডটি স্ক্যান করুন।",
    "PASSKEY_AUTHENTICATING"              => "আপনার পাসকি দিয়ে প্রমাণীকরণ করা হচ্ছে...",
    "PASSKEY_SUCCESS_REDIRECTING"         => "প্রমাণীকরণ সফল! পুনঃনির্দেশিত করা হচ্ছে...",
    // Timeout messages
    "PASSKEY_TIMEOUT_CROSS_DEVICE"        => "নিবন্ধনের সময়সীমা শেষ। ক্রস-ডিভাইসের জন্য: ১) আবার চেষ্টা করুন, ২) ডিভাইসগুলিতে ইন্টারনেট আছে কিনা নিশ্চিত করুন, ৩) সরাসরি আপনার ফোনে নিবন্ধন করার কথা ভাবুন।",
    "PASSKEY_TIMEOUT_SIMPLE"              => "নিবন্ধনের সময়সীমা শেষ। অনুগ্রহ করে আবার চেষ্টা করুন।",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"   => "ক্রস-ডিভাইস প্রমাণীকরণের সময়সীমা শেষ। সমস্যা সমাধান: ১) উভয় ডিভাইসেই ইন্টারনেট প্রয়োজন, ২) QR কোডটি দ্রুত স্ক্যান করার চেষ্টা করুন, ৩) একই ডিভাইস ব্যবহার করার কথা ভাবুন, ৪) কিছু নেটওয়ার্ক ক্রস-ডিভাইস প্রমাণীকরণ ব্লক করে।",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"         => "প্রমাণীকরণের সময়সীমা শেষ। অনুগ্রহ করে আবার চেষ্টা করুন।",
    "PASSKEY_NO_CREDENTIAL"               => "কোনো প্রমাণপত্র পাওয়া যায়নি। পুনরায় চেষ্টা করা হচ্ছে...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"   => "প্রমাণীকরণ ব্যর্থ হয়েছে - কোনো প্রমাণপত্র ফেরত আসেনি।",
    "PASSKEY_ATTEMPT_RETRY"               => "ব্যর্থ হয়েছে। পুনরায় চেষ্টা করা হচ্ছে... (%d টি চেষ্টা বাকি আছে)",
    // Error messages
    "PASSKEY_CROSS_DEVICE_FAILED"         => "ক্রস-ডিভাইস নিবন্ধন ব্যর্থ হয়েছে। চেষ্টা করুন: ১) উভয় ডিভাইসেই ইন্টারনেট আছে কিনা নিশ্চিত করুন, ২) সরাসরি আপনার ফোনে নিবন্ধন করার কথা ভাবুন, ৩) কিছু কর্পোরেট নেটওয়ার্ক এই বৈশিষ্ট্যটি ব্লক করে।",
    "PASSKEY_REGISTRATION_CANCELLED"      => "নিবন্ধন বাতিল করা হয়েছে অথবা ডিভাইসটি পাসকি সমর্থন করে না।",
    "PASSKEY_NOT_SUPPORTED"               => "এই ডিভাইস/ব্রাউজার সংমিশ্রণে পাসকি সমর্থিত নয়।",
    "PASSKEY_SECURITY_ERROR"              => "নিরাপত্তা ত্রুটি - এটি সাধারণত একটি ডোমেন/উৎসের অমিল নির্দেশ করে।",
    "PASSKEY_ALREADY_EXISTS"              => "এই অ্যাকাউন্টের জন্য এই ডিভাইসে ইতিমধ্যে একটি পাসকি বিদ্যমান। অন্য একটি ডিভাইস ব্যবহার করার চেষ্টা করুন বা প্রথমে বিদ্যমান পাসকিগুলি মুছে ফেলুন।",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"    => "ক্রস-ডিভাইস প্রমাণীকরণ ব্যর্থ হয়েছে। চেষ্টা করুন: ১) উভয় ডিভাইসেই স্থিতিশীল ইন্টারনেট আছে কিনা নিশ্চিত করুন, ২) সম্ভব হলে একই ওয়াইফাই নেটওয়ার্ক ব্যবহার করুন, ৩) এর পরিবর্তে সরাসরি আপনার ফোনে প্রমাণীকরণ করার চেষ্টা করুন, ৪) কিছু কর্পোরেট নেটওয়ার্ক এই বৈশিষ্ট্যটি ব্লক করে।",
    "PASSKEY_AUTH_CANCELLED"              => "প্রমাণীকরণ বাতিল করা হয়েছে বা কোনো পাসকি নির্বাচন করা হয়নি।",
    "PASSKEY_NETWORK_ERROR"               => "নেটওয়ার্ক ত্রুটি। ক্রস-ডিভাইস প্রমাণীকরণের জন্য, উভয় ডিভাইসেই ইন্টারনেট সংযোগ প্রয়োজন এবং একই নেটওয়ার্কে থাকার প্রয়োজন হতে পারে।",
    "PASSKEY_CREDENTIAL_NOT_FOUND"        => "প্রমাণীকরণ ব্যর্থ হয়েছে - প্রমাণপত্র স্বীকৃত নয়।",
    // Cross-device guidance
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "ক্রস-ডিভাইস প্রমাণীকরণের জন্য টিপস:",
    "PASSKEY_GUIDANCE_INTERNET"           => "নিশ্চিত করুন আপনার কম্পিউটার এবং ফোন উভয়ই ইন্টারনেট সংযোগ পেয়েছে",
    "PASSKEY_GUIDANCE_WIFI"               => "একই ওয়াইফাই নেটওয়ার্কে থাকা সাহায্য করতে পারে (কিন্তু সবসময় প্রয়োজন হয় না)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"      => "যখন অনুরোধ করা হবে, \"একটি ফোন বা ট্যাবলেট ব্যবহার করুন\" নির্বাচন করুন",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"       => "যখন QR কোডটি দেখা যাবে, দ্রুত স্ক্যান করুন",
    "PASSKEY_GUIDANCE_TRY_DIRECT"         => "যদি এটি ব্যর্থ হয়, রিফ্রেশ করে সরাসরি আপনার ফোনের ব্রাউজার ব্যবহার করার চেষ্টা করুন",
    // Troubleshooting
    "PASSKEY_SHOW_TROUBLESHOOTING"        => "সমস্যা সমাধানের টিপস দেখান",
    "PASSKEY_HIDE_TROUBLESHOOTING"        => "সমস্যা সমাধানের টিপস লুকান",
    "PASSKEY_DIAGNOSTICS_RUNNING"         => "ডায়াগনস্টিকস চলছে...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"        => "ডায়াগনস্টিকস সম্পন্ন। বিস্তারিত জানার জন্য কনসোল দেখুন।",
    "PASSKEY_ISSUES_DETECTED"             => "সমস্যা সনাক্ত করা হয়েছে:",
    "PASSKEY_ENVIRONMENT_SUITABLE"        => "পরিবেশ পাসকির জন্য উপযুক্ত বলে মনে হচ্ছে।",
    "PASSKEY_DIAGNOSTICS_FAILED"          => "ডায়াগনস্টিকস ব্যর্থ হয়েছে:",
    // Modal
    "PASSKEY_ADD_NOTE_NEW"                => "আপনার নতুন পাসকিতে একটি নোট যোগ করুন",
    // Technical errors
    "PASSKEY_BASE64_ERROR"                => "Base64 ডিকোড ত্রুটি:",
    // Server-side errors (passkey_parser.php)
    "PASSKEY_INVALID_JSON"                => "অবৈধ JSON ডেটা প্রাপ্ত হয়েছে:",
    // Session/validation errors (PasskeyHandler.php)
    "PASSKEY_NO_CHALLENGE_SESSION"        => "সেশনে কোনো পাসকি নিবন্ধনের চ্যালেঞ্জ পাওয়া যায়নি। অনুগ্রহ করে আবার নিবন্ধন করার চেষ্টা করুন।",
    "PASSKEY_USER_MISMATCH"               => "ব্যবহারকারী আইডি মেলেনি। অনুগ্রহ করে আবার নিবন্ধন করার চেষ্টা করুন।",
    "PASSKEY_CHALLENGE_USER_MISMATCH"     => "চ্যালেঞ্জ বিকল্পে ব্যবহারকারী আইডি বর্তমান ব্যবহারকারীর সাথে মেলে না। অনুগ্রহ করে আবার নিবন্ধন করার চেষ্টা করুন।",
    "PASSKEY_REGISTRATION_FAILED_ERROR"   => "পাসকি নিবন্ধন ব্যর্থ হয়েছে। অনুগ্রহ করে নিশ্চিত করুন যে আপনার ডিভাইস এবং ব্রাউজার WebAuthn সমর্থন করে এবং আবার চেষ্টা করুন। ত্রুটি:",
    "PASSKEY_NO_AUTH_CHALLENGE_SESSION"   => "সেশনে কোনো পাসকি প্রতিপাদনের চ্যালেঞ্জ পাওয়া যায়নি। অনুগ্রহ করে আবার লগইন করার চেষ্টা করুন।",
    "PASSKEY_CREDENTIAL_NOT_IN_DB"        => "ডাটাবেসে পাসকির প্রমাণপত্র পাওয়া যায়নি।",
    "PASSKEY_CREDENTIAL_WRONG_USER"       => "পাসকির প্রমাণপত্র প্রত্যাশিত ব্যবহারকারীর নয়।",
    "PASSKEY_VALIDATION_FAILED_ERROR"     => "পাসকি যাচাইকরণ ব্যর্থ হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন বা সমস্যা চলতে থাকলে সহায়তার সাথে যোগাযোগ করুন। ত্রুটি:",
    "PASSKEY_USER_NOT_FOUND_REGISTRATION" => "নিবন্ধনের জন্য ব্যবহারকারীকে পাওয়া যায়নি।",
    // --- Used in passkey_parser.php ---
    "PASSKEY_LOGIN_REQUIRED"              => "এই কাজটি সম্পাদন করতে আপনাকে অবশ্যই লগইন করতে হবে।",
    "PASSKEY_ACTION_MISSING"              => "অনুরোধ থেকে প্রয়োজনীয় 'action' প্যারামিটারটি অনুপস্থিত ছিল।",
    "PASSKEY_STORAGE_FAILED"              => "পাসকি সংরক্ষণ করতে ব্যর্থ হয়েছে। অপারেশনটি অসফল ছিল।",
    "PASSKEY_LOGIN_FAILED"                => "পাসকি লগইন ব্যর্থ হয়েছে। প্রমাণীকরণ যাচাই করা যায়নি।",
    "PASSKEY_INVALID_METHOD"              => "অবৈধ অনুরোধ পদ্ধতি:", // The script appends the method name after this key
    // --- Used in passkeys.php ---
    "CSRF_ERROR"                          => "CSRF টোকেন পরীক্ষা ব্যর্থ হয়েছে। অনুগ্রহ করে ফিরে যান এবং ফর্মটি আবার জমা দেওয়ার চেষ্টা করুন।",
    // Network analysis from analyzeNetworkConditions()
    "PASSKEY_NETWORK_PRIVATE"             => "সম্ভাব্য সমস্যা: আপনি একটি ব্যক্তিগত নেটওয়ার্কে আছেন বলে মনে হচ্ছে, যা কখনও কখনও ক্রস-ডিভাইস যোগাযোগে হস্তক্ষেপ করতে পারে।",
    "PASSKEY_NETWORK_PROXY"               => "সম্ভাব্য সমস্যা: একটি প্রক্সি বা ভিপিএন সনাক্ত করা হয়েছে। এটি ক্রস-ডিভাইস যোগাযোগে হস্তক্ষেপ করতে পারে।",
    "PASSKEY_NETWORK_MOBILE"              => "দ্রষ্টব্য: আপনি একটি মোবাইল নেটওয়ার্কে আছেন বলে মনে হচ্ছে। ক্রস-ডিভাইস অপারেশনের জন্য একটি স্থিতিশীল সংযোগ নিশ্চিত করুন।",
    "PASSKEY_NETWORK_CORPORATE"           => "সম্ভাব্য সমস্যা: একটি কর্পোরেট ফায়ারওয়াল সক্রিয় থাকতে পারে, যা ক্রস-ডিভাইস প্রমাণীকরণকে প্রভাবিত করতে পারে।",
    // Recommendations from getCrossDeviceRecommendations()
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "সুপারিশ: আপনি সম্ভবত একটি ডেস্কটপ ব্যবহার করছেন। একটি QR কোড স্ক্যান করতে আপনার ফোন ব্যবহার করার জন্য প্রস্তুত হন।",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "সুপারিশ: সেরা ফলাফলের জন্য, নিশ্চিত করুন আপনার কম্পিউটার এবং মোবাইল ডিভাইস একই ওয়াই-ফাই নেটওয়ার্কে আছে।",
    "PASSKEY_RECOMMENDATION_QR_QUICK"     => "সুপারিশ: QR কোডটি দ্রুত স্ক্যান করার জন্য প্রস্তুত থাকুন, কারণ অনুরোধের সময়সীমা শেষ হয়ে যেতে পারে।",
    "PASSKEY_RECOMMENDATION_INTERNET"     => "সুপারিশ: নিশ্চিত করুন আপনার কম্পিউটার এবং আপনার মোবাইল ডিভাইসে একটি স্থিতিশীল ইন্টারনেট সংযোগ আছে।",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "সুপারিশ: ইউনিটি ওয়েবভিউর জন্য, নিশ্চিত করুন যে পৃষ্ঠাটি লোড হতে এবং পাসকি অনুরোধ প্রক্রিয়া করতে পর্যাপ্ত সময় পেয়েছে।",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "সুপারিশ: ইউনিটিতে সময়সীমা দীর্ঘ হতে পারে। অনুগ্রহ করে ধৈর্য ধরুন।",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "সুপারিশ: যেহেতু আপনি মোবাইলে আছেন, আপনার এই ডিভাইসে সরাসরি একটি পাসকি নিবন্ধন করতে পারা উচিত।",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "সুপারিশ: অ্যান্ড্রয়েডে, আপনি গুগল পাসওয়ার্ড ম্যানেজারে আপনার পাসকিগুলি পরিচালনা করতে পারেন।",
    // Validation from validateCrossDeviceEnvironment()
    "PASSKEY_VALIDATION_RP_IP"            => "কনফিগারেশন সতর্কতা: রিলাইং পার্টি আইডি (Relying Party ID) একটি আইপি ঠিকানায় সেট করা আছে।",
    "PASSKEY_VALIDATION_RP_DOMAIN"        => "সুপারিশ: ভাল নিরাপত্তা এবং সামঞ্জস্যের জন্য রিলাইং পার্টি আইডি আপনার ডোমেন নামে (যেমন, yourwebsite.com) সেট করুন।",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"   => "কনফিগারেশন ত্রুটি: একটি লাইভ সার্ভারে পাসকি কাজ করার জন্য HTTPS প্রয়োজন। আপনার সাইটটি HTTP-তে আছে বলে মনে হচ্ছে।",
    "PASSKEY_VALIDATION_NETWORK"          => "নেটওয়ার্ক সতর্কতা", // Generic prefix for network issues
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "সুপারিশ: যদি আপনি সমস্যার সম্মুখীন হন, একটি ভিন্ন নেটওয়ার্ক চেষ্টা করুন (যেমন, কর্পোরেট ওয়াই-ফাই থেকে একটি মোবাইল হটস্পটে স্যুইচ করুন)।",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "সুপারিশ: ক্রস-ডিভাইস কার্যক্রমের জন্য, নিশ্চিত করুন উভয় ডিভাইসেই একটি নির্ভরযোগ্য ইন্টারনেট সংযোগ আছে।",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"  => "সুপারিশ: যদি ক্রস-ডিভাইস কার্যক্রম ব্যর্থ হয়, কার্যক্রমটি সম্পন্ন করতে সরাসরি আপনার মোবাইল ডিভাইসে এই পৃষ্ঠাটি দেখার চেষ্টা করুন।",
    "PASSKEY_INFO_TITLE"                  => "পাসকি সম্পর্কে",
    "PASSKEY_INFO_DESC"                   => "পাসকি হলো আপনার ডিভাইসের অন্তর্নির্মিত নিরাপত্তা বৈশিষ্ট্য যেমন ফিঙ্গারপ্রিন্ট, ফেস রিকগনিশন বা পিন ব্যবহার করে সাইন ইন করার একটি নিরাপদ, পাসওয়ার্ড-মুক্ত উপায়। এগুলি পাসওয়ার্ডের চেয়ে বেশি নিরাপদ, দ্রুত সাইন-ইন প্রদান করে, পাসওয়ার্ড ম্যানেজারের সাথে সিঙ্ক করা হলে একাধিক ডিভাইসে কাজ করে এবং ফিশিং আক্রমণ প্রতিরোধী। পাসকি আধুনিক স্মার্টফোন, ট্যাবলেট, কম্পিউটারে কাজ করে এবং 1Password, Bitwarden, iCloud Keychain বা Google Password Manager-এর মতো পাসওয়ার্ড ম্যানেজারে সংরক্ষণ করা যায়।",
    "PASSKEY_BACK_TO_LOGIN"               => "লগইনে ফিরে যান",
));

//validation class
$lang = array_merge($lang, array(
	"VAL_SAME"				=> "অবশ্যই এক রকম হতে হব",
	"VAL_EXISTS"			=> "আগে থেকেই ব্যবহৃত। অন্য রকম বাছুন।",
	"VAL_DB"					=> "ডাটাবেজ ত্রুটি",
	"VAL_NUM"					=> "অবশ্যই সংখ্যা হতে হবে",
	"VAL_INT"					=> "অবশ্যই সংখ্যা হতে হবে",
	"VAL_EMAIL"				=> "অবশ্যই একটি সঠিক ইমেইল হতে হবে",
	"VAL_NO_EMAIL"		=> "একটি ইমেইল ঠিকানা হতে পারবে না",
	"VAL_SERVER"			=> "অবশ্যই একটি নির্দিষ্ট এবং সঠিক সার্ভার হতে হবে",
	"VAL_LESS"				=> "অবশ্যই এর থেকে ছোট হতে হবে ",
	"VAL_GREAT"				=> "অবশ্যই এর থেকে বড় হতে হবে ",
	"VAL_LESS_EQ"			=> "অবশ্যই এর সমান অথবা ছোট হতে হবে ",
	"VAL_GREAT_EQ"		=> "অবশ্যই এর সমান অথবা ওর থেকে ছোট হতে হবে ",
	"VAL_NOT_EQ"			=> "অবশ্যই এর সমান হতে পারবে না ",
	"VAL_EQ"					=> "অবশ্যই এর সমান হতে হবে ",
	"VAL_TZ"					=> "একটি সঠিক সময় জোন হওয়া অবশ্যক",
	"VAL_MUST"				=> "অবশ্যই হতে হবে",
	"VAL_MUST_LIST"		=> "অবশ্যই নিচের যে কোন একটি হতে হবে",
	"VAL_TIME"				=> "অবশ্যই সঠিক সময় হতে হবে",
	"VAL_SEL"					=> "এইটা সঠিক বাছাই নয়",
	"VAL_NA_PHONE"		=> "অবশ্যই দক্ষিণ আমেরিকার ফোন নাম্বার হতে হবে",
));

//Time
$lang = array_merge($lang, array(
	"T_YEARS"			=> "বছর",
	"T_YEAR"			=> "সাল",
	"T_MONTHS"		=> "মাস",
	"T_MONTH"			=> "মাস",
	"T_WEEKS"			=> "সপ্তাহ",
	"T_WEEK"			=> "সপ্তাহ",
	"T_DAYS"			=> "দিন",
	"T_DAY"				=> "দিন",
	"T_HOURS"			=> "ঘন্টা",
	"T_HOUR"			=> "ঘন্টা",
	"T_MINUTES"		=> "মিনিট",
	"T_MINUTE"		=> "মিনিট",
	"T_SECONDS"		=> "সেকেন্ড",
	"T_SECOND"		=> "সেকেন্ড",
));


//Passwords
$lang = array_merge($lang, array(
	"PW_NEW"		=> "নতুন পাসওয়ার্ড",
	"PW_OLD"		=> "পুরাতন পাসওয়ার্ড",
	"PW_CONF"		=> "পাসওয়ার্ড পুনরায়",
	"PW_RESET"	=> "পাসওয়ার্ড নতুন করে বসান",
	"PW_UPD"		=> "পাসওয়ার্ড হালনাগাদ করা হয়েছে",
	"PW_SHOULD"	=> "পাসওয়ার্ড হতে হবেঃ ",
	"PW_SHOW"		=> "পাসওয়ার্ড দেখান",
	"PW_SHOWS"	=> "পাসওয়ার্ড দেখান",
));


//Join
$lang = array_merge($lang, array(
	"JOIN_SUC"			=> "এইখানে স্বাগতমকঃ ",
	"JOIN_THANKS"		=> "নিবন্ধন করার জন্য আপনাকে ধন্যবাদ!",
	"JOIN_HAVE"			=> "কমপক্ষে ",
	"JOIN_SYMBOL"		=> 		"একটি চিহ্ন",
	"JOIN_LOWER"		=> " ছোট হাতের অক্ষর",
	"JOIN_CAP"			=> " বড় হাতের অক্ষর",
	"JOIN_TWICE"		=> "সঠিকভাবে দুইবার লিখতে হবে",
	"JOIN_CLOSED"		=> "দুর্ভাগ্যজনক ভাবে নিবন্ধন বন্ধ আছে। আপনার যদি কোন প্রশ্ন বা প্রয়োজন থাকে, তাহলে আপনি পরিচালকের সাথে যোগাযোগ করুন।",
	"JOIN_TC"				=> "ব্যবহারকারী নিবন্ধন সম্পর্কিত নিয়ম এবং শর্তাদি",
	"JOIN_ACCEPTTC" => "আমি ব্যাবহারকারী নিয়ম এবং শর্তাদি মেনে নিলাম",
	"JOIN_CHANGED"	=> "আমাদের নিয়ম এবং শর্তাদিতে পরিবর্তন আনা হয়েছে",
	"JOIN_ACCEPT" 	=> "ব্যবহারকারী নিবন্ধন সম্পর্কিত নিয়ম এবং শর্তাদি মেনে নিন এবং এগিয়ে যান",
	"JOIN_SCORE" => "স্কোর:",
	"JOIN_INVALID_PW" => "আপনার পাসওয়ার্ড অবৈধ",

));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "সফলভাবে বন্ধ হয়েছে ",
));

//Messages
$lang = array_merge($lang, array(
	"MSG_SENT"			=> "আপনার বার্তা সফলভাবে প্রেরিত হয়েছে",
	"MSG_MASS"			=> "আপনার একাধিক বার্তা সফলভাবে প্রেরিত হয়েছে",
	"MSG_NEW"				=> "নতুন বার্তা",
	"MSG_NEW_MASS"	=> "নতুন একাধিক বার্তা",
	"MSG_CONV"			=> "আলাপচারীতা",
	"MSG_NO_CONV"		=> "কোন আলাপচারীতা নেই",
	"MSG_NO_ARC"		=> "কোন আলাপচারীতা নেই",
	"MSG_QUEST"			=> "ইমেইলের মাধ্যমে ইশতেহার পাঠাবেন, যদি সেটি চালু থাকে?",
	"MSG_ARC"				=> "বার্তা সংরক্ষন",
	"MSG_VIEW_ARC"	=> "সংরক্ষিত বার্তা গুলো দেখুন",
	"MSG_SETTINGS"  => "বার্তা সেটিং",
	"MSG_READ"			=> "পড়ুন",
	"MSG_BODY"			=> "মূল অংশ",
	"MSG_SUB"				=> "বিষয়",
	"MSG_DEL"				=> "পৌঁছানো হয়েছে",
	"MSG_REPLY"			=> "উত্তর",
	"MSG_QUICK"			=> "দ্রুত উত্তর",
	"MSG_SELECT"		=> "একজন ব্যবহারকারী বাছুন",
	"MSG_UNKN"			=> "অজানা প্রাপক",
	"MSG_NOTIF"			=> "বার্তা ইমেইল ইশতেহার",
	"MSG_BLANK"			=> "বার্তা খালি হতে পারবে না",
	"MSG_MODAL"			=> "এই বক্সে দৃষ্টি ফেলতে এইখানে চাপুন অথবা Alt + R চাপুন অথবা Shift + R চাপুন জবাবের ঘর আরো বৃব্ধি করতে",
	"MSG_ARCHIVE_SUCCESSFUL"        => "আপনি সফলভাবে বার্তাঃ %m1% সংরক্ষন করেছেন",
	"MSG_UNARCHIVE_SUCCESSFUL"      => "আপনি সফলভাবে বার্তাঃ %m1% সংরক্ষনাগার থেকে বাদ দিয়েছেন",
	"MSG_DELETE_SUCCESSFUL"         => "আপনি সফলভাবে বার্তাঃ %m1% মুছেছেন",
	"USER_MESSAGE_EXEMPT"         			=> "ব্যাবহারকারীঃ %m1% বার্তা থেকে অব্যাহতি পেয়েছেন",
	"MSG_MK_READ"		=> "পড়া হয়েছে",
	"MSG_MK_UNREAD"	=> "পড়া হয়নি",
	"MSG_ARC_THR"		=> "বাছাইকৃত বার্তাগুলো সংরক্ষিত করুন",
	"MSG_UN_THR"		=> "বাছাইকৃত বার্তাগুলো সংরক্ষনাগার থেকে বাদ দিন",
	"MSG_DEL_THR"		=> "বাছাইকৃত বার্তাগুলো মুছে ফেলুন",
	"MSG_SEND"			=> "বার্তা পাঠান",
));

//Two Factor Authentication
$lang = array_merge($lang, array(
    "2FA"                                => "টু-ফ্যাক্টর অথেনটিকেশন",
    "2FA_CONF"                           => "আপনি কি নিশ্চিত যে আপনি টু-ফ্যাক্টর অথেনটিকেশন নিষ্ক্রিয় করতে চান? আপনার অ্যাকাউন্ট আর সুরক্ষিত থাকবে না।",
    "2FA_SCAN"                           => "আপনার অথেনটিকেটর অ্যাপ দিয়ে এই QR কোডটি স্ক্যান করুন অথবা কী-টি লিখুন",
    "2FA_THEN"                           => "তারপর আপনার একটি এককালীন পাসকোড এখানে লিখুন",
    "2FA_FAIL"                           => "টু-ফ্যাক্টর অথেনটিকেশন যাচাই করতে সমস্যা হয়েছে। অনুগ্রহ করে ইন্টারনেট পরীক্ষা করুন বা সহায়তার সাথে যোগাযোগ করুন।",
    "2FA_CODE"                           => "টু-ফ্যাক্টর অথেনটিকেশন কোড",
    "2FA_EXP"                            => "১টি আঙ্গুলের ছাপের মেয়াদ শেষ হয়েছে",
    "2FA_EXPD"                           => "মেয়াদোত্তীর্ণ",
    "2FA_EXPS"                           => "মেয়াদ শেষ হবে",
    "2FA_ACTIVE"                         => "সক্রিয় সেশন",
    "2FA_NOT_FN"                         => "কোনো আঙ্গুলের ছাপ পাওয়া যায়নি",
    "2FA_FP"                             => "আঙ্গুলের ছাপ",
    "2FA_NP"                             => "লগইন ব্যর্থ - টু-ফ্যাক্টর অথেনটিকেশন কোড উপস্থিত ছিল না। অনুগ্রহ করে আবার চেষ্টা করুন।",
    "2FA_INV"                            => "লগইন ব্যর্থ - টু-ফ্যাক্টর অথেনটিকেশন কোডটি অবৈধ ছিল। অনুগ্রহ করে আবার চেষ্টা করুন।",
    "2FA_FATAL"                          => "মারাত্মক ত্রুটি - অনুগ্রহ করে সিস্টেম অ্যাডমিনের সাথে যোগাযোগ করুন। আমরা এই মুহূর্তে একটি টু-ফ্যাক্টর অথেনটিকেশন কোড তৈরি করতে পারছি না।",
    "2FA_SECTION_TITLE"                  => "টু-ফ্যাক্টর অথেনটিকেশন (TOTP)",
    "2FA_SK_ALT"                         => "আপনি যদি QR কোডটি স্ক্যান করতে না পারেন, তাহলে এই গোপন কী-টি আপনার অথেনটিকেটর অ্যাপে ম্যানুয়ালি লিখুন।",
    "2FA_IS_ENABLED"                     => "টু-ফ্যাক্টর অথেনটিকেশন আপনার অ্যাকাউন্টকে সুরক্ষিত রাখছে।",
    "2FA_NOT_ENABLED_INFO"               => "টু-ফ্যাক্টর অথেনটিকেশন বর্তমানে সক্রিয় নয়।",
    "2FA_NOT_ENABLED_EXPLAIN"            => "টু-ফ্যাক্টর অথেনটিকেশন (TOTP) আপনার অ্যাকাউন্টে একটি অতিরিক্ত নিরাপত্তা স্তর যোগ করে, যার জন্য আপনার পাসওয়ার্ডের পাশাপাশি আপনার ফোনের একটি অথেনটিকেটর অ্যাপ থেকে একটি কোড প্রয়োজন হয়।",
    // Setup Process
    "2FA_SETUP_TITLE"                    => "টু-ফ্যাক্টর অথেনটিকেশন সেটআপ করুন",
    "2FA_SECRET_KEY_LABEL"               => "গোপন কী:",
    "2FA_SETUP_VERIFY_CODE_LABEL"        => "অ্যাপ থেকে যাচাইকরণ কোড লিখুন",
    // Backup Codes
    "2FA_SUCCESS_ENABLED_TITLE"          => "টু-ফ্যাক্টর অথেনটিকেশন সক্রিয় হয়েছে! আপনার ব্যাকআপ কোডগুলি সংরক্ষণ করুন",
    "2FA_SUCCESS_ENABLED_INFO"           => "নীচে আপনার ব্যাকআপ কোডগুলি দেওয়া হলো। এগুলি নিরাপদে সংরক্ষণ করুন - প্রতিটি কেবল একবার ব্যবহার করা যাবে।",
    "2FA_BACKUP_CODES_WARNING"           => "এই কোডগুলিকে পাসওয়ার্ডের মতো ব্যবহার করুন। এগুলি নিরাপদে সংরক্ষণ করুন।",
    "2FA_SUCCESS_BACKUP_REGENERATED"     => "নতুন ব্যাকআপ কোড তৈরি হয়েছে। এগুলি নিরাপদে সংরক্ষণ করুন।",
    "2FA_BACKUP_CODE_LABEL"              => "ব্যাকআপ কোড",
    "2FA_REGEN_CODES_BTN"                => "ব্যাকআপ কোড পুনরায় তৈরি করুন",
    "2FA_INVALIDATE_WARNING"             => "এটি সমস্ত বিদ্যমান ব্যাকআপ কোড অকার্যকর করে দেবে। আপনি কি নিশ্চিত?",
    // Authentication
    "2FA_CODE_LABEL"                     => "অথেনটিকেশন কোড",
    "2FA_VERIFY_BTN"                     => "যাচাই করুন ও সাইন ইন করুন",
    "2FA_VERIFY_TITLE"                   => "টু-ফ্যাক্টর অথেনটিকেশন প্রয়োজন",
    "2FA_VERIFY_INFO"                    => "আপনার অথেনটিকেটর অ্যাপ থেকে ৬-সংখ্যার কোডটি লিখুন।",
    // Actions & Buttons
    "2FA_ENABLE_BTN"                     => "টু-ফ্যাক্টর অথেনটিকেশন সক্রিয় করুন",
    "2FA_DISABLE_BTN"                    => "টু-ফ্যাক্টর অথেনটিকেশন নিষ্ক্রিয় করুন",
    "2FA_VERIFY_ACTIVATE_BTN"            => "যাচাই করুন ও সক্রিয় করুন",
    "2FA_CANCEL_SETUP_BTN"               => "সেটআপ বাতিল করুন",
    "2FA_DONE_BTN"                       => "সম্পন্ন",
    // Success Messages
    "REDIR_2FA_DIS"                      => "টু-ফ্যাক্টর অথেনটিকেশন নিষ্ক্রিয় করা হয়েছে।",
    "2FA_SUCCESS_BACKUP_ACK"             => "ব্যাকআপ কোডগুলি স্বীকার করা হয়েছে।",
    "2FA_SUCCESS_SETUP_CANCELLED"        => "সেটআপ বাতিল করা হয়েছে।",
    // Error Messages
    "2FA_ERR_INVALID_BACKUP"             => "অবৈধ ব্যাকআপ কোড। অনুগ্রহ করে আবার চেষ্টা করুন।",
    "2FA_ERR_DISABLE_FAILED"             => "টু-ফ্যাক্টর অথেনটিকেশন নিষ্ক্রিয় করতে ব্যর্থ হয়েছে।",
    "2FA_ERR_NO_SECRET"                  => "অথেনটিকেশন গোপন কী পুনরুদ্ধার করা যায়নি। অনুগ্রহ করে আবার চেষ্টা করুন।",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"     => "ব্যাকআপ কোড যাচাই করা হয়েছে কিন্তু এটি অকার্যকর করতে ব্যর্থ হয়েছে। অনুগ্রহ করে সহায়তার সাথে যোগাযোগ করুন।",
    "2FA_ERR_NO_CODE_PROVIDED"           => "কোনো অথেনটিকেশন কোড প্রদান করা হয়নি।",
    "RATE_LIMIT_LOGIN"                   => "অনেক বেশি ব্যর্থ লগইন প্রচেষ্টা। অনুগ্রহ করে আবার চেষ্টা করার আগে অপেক্ষা করুন।",
    "RATE_LIMIT_TOTP"                    => "অনেক বেশি ভুল অথেনটিকেশন কোড। অনুগ্রহ করে আবার চেষ্টা করার আগে অপেক্ষা করুন।",
    "RATE_LIMIT_PASSKEY"                 => "অনেক বেশি পাসকি প্রমাণীকরণের প্রচেষ্টা। অনুগ্রহ করে আবার চেষ্টা করার আগে অপেক্ষা করুন।",
    "RATE_LIMIT_PASSKEY_STORE"           => "অনেক বেশি পাসকি নিবন্ধনের প্রচেষ্টা। অনুগ্রহ করে আবার চেষ্টা করার আগে অপেক্ষা করুন।",
    "RATE_LIMIT_PASSWORD_RESET"          => "অনেক বেশি পাসওয়ার্ড রিসেটের অনুরোধ। অনুগ্রহ করে অন্য একটি রিসেট অনুরোধ করার আগে অপেক্ষা করুন।",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT"   => "অনেক বেশি পাসওয়ার্ড রিসেটের প্রচেষ্টা। অনুগ্রহ করে আবার চেষ্টা করার আগে অপেক্ষা করুন।",
    "RATE_LIMIT_REGISTRATION"            => "অনেক বেশি নিবন্ধনের প্রচেষ্টা। অনুগ্রহ করে আবার চেষ্টা করার আগে অপেক্ষা করুন।",
    "RATE_LIMIT_EMAIL_VERIFICATION"      => "অনেক বেশি ইমেল যাচাইয়ের অনুরোধ। অনুগ্রহ করে অন্য একটি যাচাই অনুরোধ করার আগে অপেক্ষা করুন।",
    "RATE_LIMIT_EMAIL_CHANGE"            => "অনেক বেশি ইমেল পরিবর্তনের অনুরোধ। অনুগ্রহ করে আবার চেষ্টা করার আগে অপেক্ষা করুন।",
    "RATE_LIMIT_PASSWORD_CHANGE"         => "অনেক বেশি পাসওয়ার্ড পরিবর্তনের প্রচেষ্টা। অনুগ্রহ করে আবার চেষ্টা করার আগে অপেক্ষা করুন।",
    "RATE_LIMIT_GENERIC"                 => "অনেক বেশি প্রচেষ্টা। অনুগ্রহ করে আবার চেষ্টা করার আগে অপেক্ষা করুন।",
));


$lang = array_merge($lang, array(
	"REDIR_2FA"						=> "দুঃখিত। ২ স্তরের যাচাই এই মুহূর্তে চালু করা নেই।",
	"REDIR_2FA_EN"				=> "২ স্তরের যাচাই চালু করা",
	"REDIR_2FA_DIS"				=> "২ স্তরের যাচাই বন্ধ করা",
	"REDIR_2FA_VER"				=> "২ স্তরের যাচাই চালু করা এবং সঠিক",
	"REDIR_SOMETHING_WRONG" => "কোন একটা সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।",
	"REDIR_MSG_NOEX"			=> "বার্তার কর্তৃত্ব আপনার কাছে নেই অথবা বার্তার অস্তিত্বই নেই।",
	"REDIR_UN_ONCE"				=> "ব্যাবহারকারীর নাম ইতিমধ্যেই একবার পরিবর্তন করা হয়ে গেছে।",
	"REDIR_EM_SUCC"				=> "ইমেইল সফলভাবে হালনাগাদ হয়েছে",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "সাইন ইন করুন:",
	"EML_FEATURE_DISABLED" => "এই ফিচারটি অক্ষম করা হয়েছে",
	"EML_PASSWORDLESS_SENT" => "লগইনের জন্য লিঙ্কের জন্য আপনার ইমেল চেক করুন।",
	"EML_PASSWORDLESS_SUBJECT" => "লগইন করতে আপনার ইমেল যাচাই করুন।",
	"EML_PASSWORDLESS_BODY" => "নিম্নের লিঙ্কে ক্লিক করে আপনার ইমেল ঠিকানা যাচাই করুন। আপনি স্বয়ংক্রিয়ভাবে লগইন হবেন।",

	"EML_CONF"			=> "ইমেইল নিশ্চিত করুন",
	"EML_VER"				=> "ইমেইল যাচাই করুন",
	"EML_CHK"				=> "ইমেইল অনুরোধ গ্রহণ করা হয়েছে। অনুগ্রহ করে ইমেইল ইনবক্স চেক করুন এবং ইমেইল অনুসরণ করুন যাচাই সম্পন্ন করার জন্য। স্পাম এবং জাংক ফোল্ডার দেখুন যদি না খুজে পান তবে। ",
	"EML_MAT"				=> "আপনার ইমেইল মিলছে না।",
	"EML_HELLO"			=> "স্বাগতমেঃ ",
	"EML_HI"				=> "শুভেচ্ছা ",
	"EML_AD_HAS"		=> "একজন পরিচালক আপনার পাসওয়ার্ড নতুন করে বসিয়ে দিয়েছে।",
	"EML_AC_HAS"		=> "একজন পরিচালক আপনার একাউন্ট তৈরী করে দিয়েছে।",
	"EML_REQ"				=> "নিচের লিঙ্ক দ্বারা অবশই আপনাকে পাসওয়ার্ড বসাতে হবে।",
	"EML_EXP"				=> "অনুগ্রহ করে লক্ষ করুন, পাসওয়ার্ড এর লিঙ্ক এর মেয়াদ শেষ হবেঃ ",
	"EML_VER_EXP"		=> "অনুগ্রহ করে লক্ষ করুন, যাচাইকরণ কোড লিঙ্ক এর মেয়াদ শেষ হবেঃ ",
	"EML_CLICK"			=> "লগইন করতে এইখানে চাপুন।",
	"EML_REC"				=> "লগইন করার পর আপনাকে পাসওয়ার্ড পরিবর্তন করার জন্য বিশেষ ভাবে অনুরোধ করা হচ্ছে।",
	"EML_MSG"				=> "আপনার একটি বার্তা আছে। প্রেরকঃ ",
	"EML_REPLY"			=> "বার্তাটি দেখতে অথবা এর জবাব দিতে এইখানে চাপুন",
	"EML_WHY"				=> "আপনি এই ইমেইলটি পাওয়ার কারন হচ্ছে আপনার পাসওয়ার্ড নতুন করে বসানোর জন্য অনুরোধ করা হয়েছিল। যদি সেটি আপনি না করে থাকেন তাহলে আপনি এই ইমেইলটি এড়িয়ে যেতে পারেন।",
	"EML_HOW"				=> "যদি এইটা আপনি হয়ে থাকেন, তাহলে নিচের লিঙ্ক এ ক্লিক করুন পাসওয়ার্ড পুনরায় বসানোর জন্য ",
	"EML_EML"				=> "আপনার একাউন্ট থেকে ইমেইল পরিবর্তন করার জন্য অনুরোধ করা হয়েছে।",
	"EML_VER_EML"		=> "নিবন্ধন করার জন্য আপনাকে ধন্যবাদ। একবার আপনার ইমেইল এড্রেসটি যাচাই করে নিলেই আপনি লগইন করার জন্য প্রস্তুত। অনুগ্রহ করে নিচের লিঙ্ক এ ক্লিক করুন ইমেইল যাচাই সম্পন্ন করার জন্য।",

));

//Verification
$lang = array_merge($lang, array(
	"VER_SUC"			=> "আপনার ইমেইল যাচাইকরণ সম্পন্ন।",
	"VER_FAIL"		=> "আমরা আপনার একাউন্ট যাচাইকরণে ব্যার্থ হয়েছি!",
	"VER_RESEND"	=> "পুনরায় যাচাইকরণ ইমেইল পাঠান",
	"VER_AGAIN"		=> "আপনার ইমেইল এড্রেসটি লিখুন এবং আবার চেষ্টা করুন",
	"VER_PAGE"		=> "<li>আপনার ইমেইল খুজে দেখুন এবং লিঙ্ক এ ক্লিক করুন যেটা আমরা আপনাকে পাঠিয়েছি ম</li><li>সম্পন্ন</li>",
	"VER_RES_SUC" => " আপনার যাচাইকরণ ইমেইল আপনার ইমেইলে পাঠানো হয়েছে  ওই লিঙ্ক এ ক্লিক করুন যেইটা পাঠানো হয়েছে। স্পাম বক্সে দেখতে ভুল করবেন না কিন্তু। অনেক সময় সেইখানে ইমেইল চলে যায়।  যাচাইকরণ কোড এর মেয়াদকাল  ",
	"VER_OOPS"		=> "ওহো! কোন একটা সমস্যা হয়েছে। সম্ভবত আপনি পুরাতন কোন লিংকে ক্লিক করেছেন। অনুগ্রহ করে নিচে ক্লিক করুন পুনরায় চেষ্টা করার জন্য।",
	"VER_RESET"		=> "আপনার পাসওয়ার্ড নতুন করে বসানো হয়েছে!",
	"VER_INS"			=> "<li>আপনার ইমেইল এড্রেস লিখুন এবং নতুন করে বসানোর জন্য চাপুন</li> <li>লিঙ্ক এ ক্লিক করুন যেইটা পাঠানো হয়েছে</li>
												<li>যেইভাবে নির্দেশনা দেওয়া আছে সেইভাবে অনুসরণ করুন</li>",
	"VER_SENT"		=> " পাসওয়ার্ড নতুন করে বসানোর লিংক আপনার ইমেইলে পাঠানো হয়েছে। 
			    							 আপনার যাচাইকরণ ইমেইল আপনার ইমেইলে পাঠানো হয়েছে  ওই লিঙ্ক এ ক্লিক করুন যেইটা পাঠানো হয়েছে। স্পাম বক্সে দেখতে ভুল করবেন না কিন্তু। অনেক সময় সেইখানে ইমেইল চলে যায়।  যাচাইকরণ কোড এর মেয়াদকাল ",
	"VER_PLEASE"	=> "অনুগ্রহ করে আপনার পাসওয়ার্ড পরিবর্তন করুন",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"				=> "নতুন করে পিন সেট করুন",
	"SET_WHY"				=> "কেন আমি এইটা পরিবর্তন করতে পারব না?",
	"SET_PW_MATCH"	=> "নতুন পাসওয়ার্ড এর সাথে অবশ্যই মিল থাকতে হবে",

	"SET_PIN_NEXT"	=> "আপনি নতুন করে পিন বসাতে পারবেন পরবর্তীতে যখন আপনার যাচাইকরণ প্রয়োজন হবে",
	"SET_UPDATE"		=> "আপনার ব্যাবহারকারী সেটিং পরিবর্তন করুন",
	"SET_NOCHANGE"	=> "পরিচালক উজারনেম পরিবর্তন করার পদ্ধতি বন্ধ করে দিয়েছে",
	"SET_ONECHANGE"	=> "পরিচালক শুধু একবার ব্যাবহারকারীর নাম। পরিবর্তন করার অনুমিত দিয়েছেন, আর সেটা আপনি একবার ব্যাবহারকারী করেও ফেলেছেন।",

	"SET_GRAVITAR"	=> "আপনার প্রোফাইল ছবি পরিবর্তন করতে চান?  <br> <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> উক্ত লিংকে যান এবং আপনার ইমেইল এড্রেস ব্যবহার করে ছবি পরিবর্তন করুন যেই ইমেইলটা আপনি এইখানে ব্যবহার করেছেন। এইটা খুবই দ্রুত কাজ করে এবং একইসাথে লাখ লাখ সাইটে কাজ করে!",

	"SET_NOTE1"			=> " লক্ষ করুন  ইমেইল হালনাগাদ করার জন্য ইতিমধ্যেই অনুরোধ করা আছে ",

	"SET_NOTE2"			=> ".  যাচাইকারী ইমেইলটি ব্যাবহার করুন প্রক্রিয়া সম্পন্ন করতে। 
		 আপনার যদি নতুন যাচাইকারী ইমেইলের প্রয়োজন হয়, তবে পুনরায় আপনার ইমেইলটি উপরে লিখুন এবং নতুন করে অনুরোধ করুন। ",

	"SET_PW_REQ" 		=> "পাসওয়ার্ড এবং ইমেইল পরিবর্তন অথবা পিন নতুন করে বসানোর জন্য অত্যাবশ্যকীয়",
	"SET_PW_REQI" 	=> "আপনার পাসওয়ার্ড পরিবর্তনের জন্য অত্যাবশ্যকীয়",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "সক্রিয় অধিবেশন শেষ করতে ত্রুটি: ",
	"ERR_EMAIL"				=> "ত্রুটির কারনে ইমেইল পাঠানো যায়নি। অনুগ্রহ করে পরিচালকের সাথে যোগাযোগ করুন।",
	"ERR_EM_DB"				=> "এই ইমেইলটা আমাদের ডাটাবেজে নেই",
	"ERR_TC"					=> "অনুগ্রহ করে আমাদের নিয়ম এবং শর্তাদি পড়ুন এবং গ্রহন করুন।",
	"ERR_CAP"					=> "ক্যপচা পরীক্ষায় ব্যার্থ! রোবট!",
	"ERR_PW_SAME"			=> "আপনার নতুন পাসওয়ার্ড পুরাতন পাসওয়ার্ড এর মত হতে পারবে না",
	"ERR_PW_FAIL"			=> "বর্তমান পাসওয়ার্ড যাচাইকরণে ব্যার্থ! হালনাগাদ করা যায় নি। অনুগ্রহ করে আবার চেষ্টা করুন।",
	"ERR_GOOG"				=> "লক্ষ করুন :  আপনি যদি আসলে ফেসবুক কিংবা গুগলের মাধ্যমে লগইন করে থাকেন, তাহলে আপনাকে নতুন করে পাসওয়ার্ড বসানোর জন্য অনুরোধ করতে হবে। যদি না আপনি খুব ভালো আন্দাজ করতে পারেন!",
	"ERR_EM_VER"			=> "ইমেইল যাচাইকরণ চালু করা নেই। অনুগ্রহ করে পরিচালকের সাথে যোগাযোগ করুন।",
	"ERR_EMAIL_STR"		=> "কিছু একটা অদ্ভুত হয়েছে! অনুগ্রহ করে আপনার ইমেইল পুনরায় যাচাই করুন। সমস্যার জন্য আমরা আন্তরিকভাবে দুঃখিত।",

));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "আমরা খুব শীঘ্রই ফিরে আসবো!",
	"MAINT_MSG"			=> "সাময়িক সমস্যার জন্য আমরা দুঃখিত। কিন্তু আমরা কিছু জরুরী কাজ করছি।<br> আমরা খুব শীঘ্রই ফিরে আসছি!",
	"MAINT_BAN"			=> "দুঃখিত! আপনাকে নিষিদ্ধ করা হয়েছে। আপনি যদি মনে করেন এটি একটি ত্রুটি, তাহলে আপনি পরিচালকের সাথে যোগাযোগ করুন।",
	"MAINT_TOK"			=> "আপনার ফরমে কোন সমস্যা হয়েছে। আপনি পিছনে যান এবং আবার চেষ্টা করুন। মনে রাখবেন, আপনি যদি ফরম জমা দেওয়ার আগে পৃষ্ঠা রিফ্রেশ করেন তাহলে এইরকম হবে। যদি এই সমস্যা বার বার ঘটতে থাকে তাহলে অবশ্যই পরিচালকের সাথে যোগাযোগ করুন।",
	"MAINT_OPEN"		=> "একটি মুক্ত পিএইচপি ব্যাবহারকারী ব্যবস্থানা কাঠামো",
	"MAINT_PLEASE"	=> "আপনি সফলভাবে userspice ইন্সটল করেছেন!<br>বিস্তারিত সাহায্যের জন্য যানঃ "
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
	"DAT_SEARCH"    => "অনুসন্ধান",
	"DAT_FIRST"     => "প্রথম",
	"DAT_LAST"      => "শেষ",
	"DAT_NEXT"      => "পরবর্তী",
	"DAT_PREV"      => "পূর্ববর্তী",
	"DAT_NODATA"        => "কোন উপাত্ত পাওয়া যায়নি টেবিলে",
	"DAT_INFO"          => "_TOTAL_ এর মধ্যে _START_ থেকে _END_  পর্যন্ত দেখানো হচ্ছে",
	"DAT_ZERO"          => "০ এর মধ্যে ০ থেকে ০ পর্যন্ত দেখানো হচ্ছে",
	"DAT_FILTERED"      => "(_MAX_ থেকে ছেকে দেখানো হচ্ছে)",
	"DAT_MENU_LENG"     => "_MENU_ পর্যন্ত দেখান",
	"DAT_LOADING"       => "লোদ হচ্ছে...",
	"DAT_PROCESS"       => "প্রক্রিয়াধীন...",
	"DAT_NO_REC"        => "রেকর্ড এর সাথে কোন মিল পাওয়া যায় নি",
	"DAT_ASC"           => "কলাম কে শুরু থেকে সাজান",
	"DAT_DESC"          => "কলাম কে শেষের থেকে সাজান",
));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
