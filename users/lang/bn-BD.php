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
//You defiitely want to customize these for your language
$lang = array_merge($lang,array(
"THIS_LANGUAGE"	=>"বাংলা",
"THIS_CODE"			=>"bn-BD",
"MISSING_TEXT"	=>"Missing Text",
));

//Database Menus
$lang = array_merge($lang,array(
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
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"					=> "নিবন্ধন",
	"SIGNUP_BUTTONTEXT"		=> "আমাকে নিবন্ধিত করুন",
	"SIGNUP_AUDITTEXT"		=> "নিবন্ধিত করা হয়েছে",
	));

// Signin
$lang = array_merge($lang,array(
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
$lang = array_merge($lang,array(
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
	$lang = array_merge($lang,array(
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

//validation class
	$lang = array_merge($lang,array(
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
	$lang = array_merge($lang,array(
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
	$lang = array_merge($lang,array(
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
	$lang = array_merge($lang,array(
		"JOIN_SUC"			=> "এইখানে স্বাগতমকঃ ",
		"JOIN_THANKS"		=> "নিবন্ধন করার জন্য আপনাকে ধন্যবাদ!",
		"JOIN_HAVE"			=> "কমপক্ষে ",
		"JOIN_CAP"			=> " বড় হাতের অক্ষর",
		"JOIN_TWICE"		=> "সঠিকভাবে দুইবার লিখতে হবে",
		"JOIN_CLOSED"		=> "দুর্ভাগ্যজনক ভাবে নিবন্ধন বন্ধ আছে। আপনার যদি কোন প্রশ্ন বা প্রয়োজন থাকে, তাহলে আপনি পরিচালকের সাথে যোগাযোগ করুন।",
		"JOIN_TC"				=> "ব্যবহারকারী নিবন্ধন সম্পর্কিত নিয়ম এবং শর্তাদি",
		"JOIN_ACCEPTTC" => "আমি ব্যাবহারকারী নিয়ম এবং শর্তাদি মেনে নিলাম",
		"JOIN_CHANGED"	=> "আমাদের নিয়ম এবং শর্তাদিতে পরিবর্তন আনা হয়েছে",
		"JOIN_ACCEPT" 	=> "ব্যবহারকারী নিবন্ধন সম্পর্কিত নিয়ম এবং শর্তাদি মেনে নিন এবং এগিয়ে যান",
		));

		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "সফলভাবে বন্ধ হয়েছে ",
		));

		//Messages
	$lang = array_merge($lang,array(
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

	//2 Factor Authentication
	$lang = array_merge($lang,array(
		"2FA"				=> "২ স্তরের যাচাই",
		"2FA_CONF"	=> "আপনি কি ২ স্তরের যাচাই বন্ধ করতে চান? আপনার একাউন্ট পরবর্তীতে আর সুরক্ষিত থাকবে না।",
		"2FA_SCAN"	=> "এই কোডটি QR স্ক্যানার দিয়ে স্ক্যান করুন আপনার অথেনটিক্যাটর আ্যপ থেকে অথবা কি এইখানে লিখুন",
		"2FA_THEN"	=> "এরপর এইখানে আপনার অস্থায়ী পাসওয়ার্ড এর যে কোন একটি লিখুন",
		"2FA_FAIL"	=> "আপনার ২ স্তর যাচাই করনে সমস্যা হয়েছে। অনুগ্রহ করে ইন্টারনেট সংযোগ যাচাই করুন এবং আবার চেষ্টা করুন।",
		"2FA_CODE"	=> "২ স্তরের যাচাইকারী কোড",
		"2FA_EXP"		=> "১ আঙুলের ছাপ মেয়াদ উত্তীর্ণ হয়ে গেছে",
		"2FA_EXPD"	=> "মেয়াদ উত্তীর্ণ হয়ে গেছে",
		"2FA_EXPS"	=> "মেয়াদ উত্তীর্ণ হবে",
		"2FA_ACTIVE"=> "সক্রিয় অধিবেশন",
		"2FA_NOT_FN"=> "কোন আঙুলের ছাপ পাওয়া যায় নি",
		"2FA_FP"		=> "আঙুলের ছাপ সমূহ",
		"2FA_NP"		=> "<strong>লগইন ব্যার্থ</strong> ২ স্তরের যাচাইকারী কোড উপস্থিত নেই। অনুগ্রহ করে আবার চেষ্টা করুন",
		"2FA_INV"		=> "<strong>লগইন ব্যার্থ</strong> ২ স্তরের যাচাইকারী কোড সঠিক নয়। অনুগ্রহ করে আবার চেষ্টা করুন।",
		"2FA_FATAL"	=> "<strong>মারাত্মক ত্রুটি</strong> অনুগ্রহ করে সিস্টেম পরিচালকের সাথে যোগাযোগ করুন।",
		));

	//Redirect Messages - These get a plus between each word
	$lang = array_merge($lang,array(
		"REDIR_2FA"						=> "দুঃখিত।+২+স্তরের+যাচাই+এই+মুহূর্তে+চালু+করা+নেই।",
		"REDIR_2FA_EN"				=> "২+স্তরের+যাচাই+চালু+করা",
		"REDIR_2FA_DIS"				=> "২+স্তরের+যাচাই+বন্ধ+করা",
		"REDIR_2FA_VER"				=> "২+স্তরের+যাচাই+চালু+করা+এবং+সঠিক",
		"REDIR_SOM_TING_WONG" => "কোন+একটা+সমস্যা+হয়েছে।+অনুগ্রহ+করে+আবার+চেষ্টা+করুন।",
		"REDIR_MSG_NOEX"			=> "বার্তার+কর্তৃত্ব+আপনার+কাছে+নেই অথবা+বার্তার+অস্তিত্বই+নেই।",
		"REDIR_UN_ONCE"				=> "ব্যাবহারকারীর+নাম+ইতিমধ্যেই+একবার+পরিবর্তন+করা+হয়ে+গেছে।",
		"REDIR_EM_SUCC"				=> "ইমেইল+সফলভাবে+হালনাগাদ+হয়েছে",
		));

	//Emails
	$lang = array_merge($lang,array(
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
		$lang = array_merge($lang,array(
			"VER_SUC"			=> "আপনার ইমেইল যাচাইকরণ সম্পন্ন।",
			"VER_FAIL"		=> "আমরা আপনার একাউন্ট যাচাইকরণে ব্যার্থ হয়েছি!",
			"VER_RESEND"	=> "পুনরায় যাচাইকরণ ইমেইল পাঠান",
			"VER_AGAIN"		=> "আপনার ইমেইল এড্রেসটি লিখুন এবং আবার চেষ্টা করুন",
			"VER_PAGE"		=> "<li>আপনার ইমেইল খুজে দেখুন এবং লিঙ্ক এ ক্লিক করুন যেটা আমরা আপনাকে পাঠিয়েছি ম</li><li>সম্পন্ন</li>",
			"VER_RES_SUC" => "<p>আপনার যাচাইকরণ ইমেইল আপনার ইমেইলে পাঠানো হয়েছে</p><p>ওই লিঙ্ক এ ক্লিক করুন যেইটা পাঠানো হয়েছে। স্পাম বক্সে দেখতে ভুল করবেন না কিন্তু। অনেক সময় সেইখানে ইমেইল চলে যায়।</p><p>যাচাইকরণ কোড এর মেয়াদকাল  ",
			"VER_OOPS"		=> "ওহো! কোন একটা সমস্যা হয়েছে। সম্ভবত আপনি পুরাতন কোন লিংকে ক্লিক করেছেন। অনুগ্রহ করে নিচে ক্লিক করুন পুনরায় চেষ্টা করার জন্য।",
			"VER_RESET"		=> "আপনার পাসওয়ার্ড নতুন করে বসানো হয়েছে!",
			"VER_INS"			=> "<li>আপনার ইমেইল এড্রেস লিখুন এবং নতুন করে বসানোর জন্য চাপুন</li> <li>লিঙ্ক এ ক্লিক করুন যেইটা পাঠানো হয়েছে</li>
												<li>যেইভাবে নির্দেশনা দেওয়া আছে সেইভাবে অনুসরণ করুন</li>",
			"VER_SENT"		=> "<p>পাসওয়ার্ড নতুন করে বসানোর লিংক আপনার ইমেইলে পাঠানো হয়েছে।</p>
			    							<p>আপনার যাচাইকরণ ইমেইল আপনার ইমেইলে পাঠানো হয়েছে</p><p>ওই লিঙ্ক এ ক্লিক করুন যেইটা পাঠানো হয়েছে। স্পাম বক্সে দেখতে ভুল করবেন না কিন্তু। অনেক সময় সেইখানে ইমেইল চলে যায়।</p><p>যাচাইকরণ কোড এর মেয়াদকাল ",
			"VER_PLEASE"	=> "অনুগ্রহ করে আপনার পাসওয়ার্ড পরিবর্তন করুন",
			));

	//User Settings
	$lang = array_merge($lang,array(
		"SET_PIN"				=> "নতুন করে পিন সেট করুন",
		"SET_WHY"				=> "কেন আমি এইটা পরিবর্তন করতে পারব না?",
		"SET_PW_MATCH"	=> "নতুন পাসওয়ার্ড এর সাথে অবশ্যই মিল থাকতে হবে",

		"SET_PIN_NEXT"	=> "আপনি নতুন করে পিন বসাতে পারবেন পরবর্তীতে যখন আপনার যাচাইকরণ প্রয়োজন হবে",
		"SET_UPDATE"		=> "আপনার ব্যাবহারকারী সেটিং পরিবর্তন করুন",
		"SET_NOCHANGE"	=> "পরিচালক উজারনেম পরিবর্তন করার পদ্ধতি বন্ধ করে দিয়েছে",
		"SET_ONECHANGE"	=> "পরিচালক শুধু একবার ব্যাবহারকারীর নাম। পরিবর্তন করার অনুমিত দিয়েছেন, আর সেটা আপনি একবার ব্যাবহারকারী করেও ফেলেছেন।",

		"SET_GRAVITAR"	=> "<strong>আপনার প্রোফাইল ছবি পরিবর্তন করতে চান? </strong><br> <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> উক্ত লিংকে যান এবং আপনার ইমেইল এড্রেস ব্যবহার করে ছবি পরিবর্তন করুন যেই ইমেইলটা আপনি এইখানে ব্যবহার করেছেন। এইটা খুবই দ্রুত কাজ করে এবং একইসাথে লাখ লাখ সাইটে কাজ করে!",

		"SET_NOTE1"			=> "<p><strong>লক্ষ করুন</strong> ইমেইল হালনাগাদ করার জন্য ইতিমধ্যেই অনুরোধ করা আছে ",

		"SET_NOTE2"			=> ".</p><p>যাচাইকারী ইমেইলটি ব্যাবহার করুন প্রক্রিয়া সম্পন্ন করতে।</p>
		<p>আপনার যদি নতুন যাচাইকারী ইমেইলের প্রয়োজন হয়, তবে পুনরায় আপনার ইমেইলটি উপরে লিখুন এবং নতুন করে অনুরোধ করুন।</p>",

		"SET_PW_REQ" 		=> "পাসওয়ার্ড এবং ইমেইল পরিবর্তন অথবা পিন নতুন করে বসানোর জন্য অত্যাবশ্যকীয়",
		"SET_PW_REQI" 	=> "আপনার পাসওয়ার্ড পরিবর্তনের জন্য অত্যাবশ্যকীয়",

		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"		=> "সক্রিয় অধিবেশন শেষ করতে ত্রুটি: ",
		"ERR_EMAIL"				=> "ত্রুটির কারনে ইমেইল পাঠানো যায়নি। অনুগ্রহ করে পরিচালকের সাথে যোগাযোগ করুন।",
		"ERR_EM_DB"				=> "এই ইমেইলটা আমাদের ডাটাবেজে নেই",
		"ERR_TC"					=> "অনুগ্রহ করে আমাদের নিয়ম এবং শর্তাদি পড়ুন এবং গ্রহন করুন।",
		"ERR_CAP"					=> "ক্যপচা পরীক্ষায় ব্যার্থ! রোবট!",
		"ERR_PW_SAME"			=> "আপনার নতুন পাসওয়ার্ড পুরাতন পাসওয়ার্ড এর মত হতে পারবে না",
		"ERR_PW_FAIL"			=> "বর্তমান পাসওয়ার্ড যাচাইকরণে ব্যার্থ! হালনাগাদ করা যায় নি। অনুগ্রহ করে আবার চেষ্টা করুন।",
		"ERR_GOOG"				=> "<strong>লক্ষ করুন :</strong> আপনি যদি আসলে ফেসবুক কিংবা গুগলের মাধ্যমে লগইন করে থাকেন, তাহলে আপনাকে নতুন করে পাসওয়ার্ড বসানোর জন্য অনুরোধ করতে হবে। যদি না আপনি খুব ভালো আন্দাজ করতে পারেন!",
		"ERR_EM_VER"			=> "ইমেইল যাচাইকরণ চালু করা নেই। অনুগ্রহ করে পরিচালকের সাথে যোগাযোগ করুন।",
		"ERR_EMAIL_STR"		=> "কিছু একটা অদ্ভুত হয়েছে! অনুগ্রহ করে আপনার ইমেইল পুনরায় যাচাই করুন। সমস্যার জন্য আমরা আন্তরিকভাবে দুঃখিত।",

		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"		=> "আমরা খুব শীঘ্রই ফিরে আসবো!",
		"MAINT_MSG"			=> "সাময়িক সমস্যার জন্য আমরা দুঃখিত। কিন্তু আমরা কিছু জরুরী কাজ করছি।<br> আমরা খুব শীঘ্রই ফিরে আসছি!",
		"MAINT_BAN"			=> "দুঃখিত! আপনাকে নিষিদ্ধ করা হয়েছে। আপনি যদি মনে করেন এটি একটি ত্রুটি, তাহলে আপনি পরিচালকের সাথে যোগাযোগ করুন।",
		"MAINT_TOK"			=> "আপনার ফরমে কোন সমস্যা হয়েছে। আপনি পিছনে যান এবং আবার চেষ্টা করুন। মনে রাখবেন, আপনি যদি ফরম জমা দেওয়ার আগে পৃষ্ঠা রিফ্রেশ করেন তাহলে এইরকম হবে। যদি এই সমস্যা বার বার ঘটতে থাকে তাহলে অবশ্যই পরিচালকের সাথে যোগাযোগ করুন।",
		"MAINT_OPEN"		=> "একটি মুক্ত পিএইচপি ব্যাবহারকারী ব্যবস্থানা কাঠামো",
		"MAINT_PLEASE"	=> "আপনি সফলভাবে userspice ইন্সটল করেছেন!<br>বিস্তারিত সাহায্যের জন্য যানঃ "
		));

		//dataTables Added in 4.4.08
		//NOTE: do not change the words like _START_ between the two _ symbols!
		$lang = array_merge($lang,array(
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
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
 //do not put a closing php tag here
