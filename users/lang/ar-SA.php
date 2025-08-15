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
	"THIS_LANGUAGE"	=> "ARABIC",
	"THIS_CODE"			=> "ar-SA",
	"MISSING_TEXT"	=> "الترجمة مفقودة",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "أدخل الرمز المرسل إلى بريدك الإلكتروني",
    "PASS_EMAIL_ONLY"     => "يرجى التحقق من بريدك الإلكتروني للحصول على رابط تسجيل الدخول",
    "PASS_CODE_ONLY"      => "يرجى إدخال الرمز المرسل إلى بريدك الإلكتروني",
    "PASS_BOTH"           => "يرجى التحقق من بريدك الإلكتروني للحصول على رابط تسجيل الدخول أو إدخال الرمز المرسل",
    "PASS_VER_BUTTON"     => "التحقق من الرمز",
    "PASS_EMAIL_ONLY_MSG" => "يرجى التحقق من عنوان بريدك الإلكتروني بالنقر على الرابط أدناه",
    "PASS_CODE_ONLY_MSG"  => "يرجى إدخال الرمز أدناه لتسجيل الدخول",
    "PASS_BOTH_MSG"       => "يرجى التحقق من عنوان بريدك الإلكتروني بالنقر على الرابط أدناه أو إدخال الرمز للدخول",
    "PASS_YOUR_CODE"      => "رمز التحقق الخاص بك هو: ",
    "PASS_CONFIRM_LOGIN"  => "تأكيد تسجيل الدخول",
    "PASS_CONFIRM_CLICK"  => "انقر لإكمال تسجيل الدخول",
    "PASS_GENERIC_ERROR"  => "حدث خطأ ما",
));


//Database Menus
$lang = array_merge($lang, array(
	"MENU_HOME"			=> "الرئيسية",
	"MENU_HELP"			=> "مساعدة",
	"MENU_ACCOUNT"	=> "الحساب",
	"MENU_DASH"			=> "لوحة المدير",
	"MENU_USER_MGR"	=> "ادارة المستخدمين",
	"MENU_PAGE_MGR"	=> "ادارة الصفحات",
	"MENU_PERM_MGR"	=> "ادارة الاذونات",
	"MENU_MSGS_MGR"	=> "مركز الرسائل",
	"MENU_LOGS_MGR"	=> "سجلات النظام",
	"MENU_LOGOUT"		=> "خروج",
));

// Signup
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"					=> "التسجيل",
	"SIGNUP_BUTTONTEXT"		=> "تسجيل",
	"SIGNUP_AUDITTEXT"		=> "تم التسجيل",
));

// Signin
$lang = array_merge($lang, array(
	"SIGNIN_FAIL"				=> "** فشل تسجيل الدخول **",
	"SIGNIN_PLEASE_CHK" => "يرجى التحقق من اسم المستخدم وكلمة المرور الخاصة بك وحاول مرة أخرى",
	"SIGNIN_UORE"				=> "اسم المستخدم او البريد الالكتروني",
	"SIGNIN_PASS"				=> "كلمة المرور",
	"SIGNIN_TITLE"			=> "الرجاء تسجيل الدخول",
	"SIGNIN_TEXT"				=> "تسجيل دخول",
	"SIGNOUT_TEXT"			=> "خروج",
	"SIGNIN_BUTTONTEXT"	=> "دخول",
	"SIGNIN_REMEMBER"		=> "تذكرني",
	"SIGNIN_AUDITTEXT"	=> "تم تسجيل الدخول",
	"SIGNIN_FORGOTPASS"	=> "نسيت كلمة المرور",
	"SIGNOUT_AUDITTEXT"	=> "تم تسجيل الدخول",
));

// Account Page
$lang = array_merge($lang, array(
	"ACCT_EDIT"					=> "تعديل بيانات الحساب",
	"ACCT_2FA"					=> "ادارة التحقق بخطوتين",
	"ACCT_SESS"					=> "ادارة الجلسات",
	"ACCT_HOME"					=> "رئيسية الحساب",
	"ACCT_SINCE"				=> "تاريخ الانضمام",
	"ACCT_LOGINS"				=> "مرات تسجيل الدخول",
	"ACCT_SESSIONS"			=> "الجلسات النشطة",
	"ACCT_MNG_SES"			=> "اضغط على ادارة الجلسات للمزيد من المعلومات",
));

//General Terms
$lang = array_merge($lang, array(
	"GEN_ENABLED"			=> "مفعل",
	"GEN_DISABLED"		=> "معطل",
	"GEN_ENABLE"			=> "تفعيل",
	"GEN_DISABLE"			=> "تعطيل",
	"GEN_NO"					=> "لا",
	"GEN_YES"					=> "نعم",
	"GEN_MIN"					=> "اقل",
	"GEN_MAX"					=> "اكثر",
	"GEN_CHAR"				=> "حروف", //as in characters
	"GEN_SUBMIT"			=> "تأكيد",
	"GEN_MANAGE"			=> "ادارة",
	"GEN_VERIFY"			=> "تأكيد",
	"GEN_SESSION"			=> "جلسة",
	"GEN_SESSIONS"		=> "جلسات",
	"GEN_EMAIL"				=> "الايميل",
	"GEN_FNAME"				=> "الاسم الاول",
	"GEN_LNAME"				=> "الاسم الاخير",
	"GEN_UNAME"				=> "اسم المستخدم",
	"GEN_PASS"				=> "كلمة السر",
	"GEN_MSG"					=> "رسالة",
	"GEN_TODAY"				=> "اليوم",
	"GEN_CLOSE"				=> "اغلاق",
	"GEN_CANCEL"			=> "الغاء",
	"GEN_CHECK"				=> "[ تحديد/عدم تحديد الكل ]",
	"GEN_WITH"				=> "مع",
	"GEN_UPDATED"			=> "مُحدث",
	"GEN_UPDATE"			=> "تحديث",
	"GEN_BY"					=> "بواسطة",
	"GEN_FUNCTIONS"		=> "الدوال",
	"GEN_NUMBER"			=> "رقم",
	"GEN_NUMBERS"			=> "ارقام",
	"GEN_INFO"				=> "معلومات",
	"GEN_REC"					=> "سُجل",
	"GEN_DEL"					=> "حذف",
	"GEN_NOT_AVAIL"		=> "غير متاح",
	"GEN_AVAIL"				=> "متاح",
	"GEN_BACK"				=> "عودة",
	"GEN_RESET"				=> "اعادة ضبط",
	"GEN_REQ"					=> "مطلوب",
	"GEN_AND"					=> "و",
	"GEN_SAME"				=> "يجب ان يتطابقا",
));

//added during passkey/totp update
$lang = array_merge($lang, array(
    "GEN_PASSKEY"                         => "مفتاح المرور",
    "GEN_ACTIONS"                         => "الإجراءات",
    "GEN_BACK_TO_ACCT"                    => "العودة إلى الحساب",
    "GEN_DB_ERROR"                        => "حدث خطأ في قاعدة البيانات. يرجى المحاولة مرة أخرى.",
    "GEN_IMPORTANT"                       => "هام",
    "GEN_NO_PERMISSIONS"                  => "ليس لديك الصلاحية للوصول إلى هذه الصفحة.",
    "GEN_NO_PERMISSIONS_MSG"              => "ليس لديك الصلاحية للوصول إلى هذه الصفحة. إذا كنت تعتقد أن هذا خطأ، يرجى الاتصال بمسؤول الموقع.",
    "PASSKEYS_MANAGE_TITLE"               => "إدارة مفاتيح المرور الخاصة بك",
    "PASSKEYS_LOGIN_TITLE"                => "تسجيل الدخول باستخدام مفتاح المرور",
    "PASSKEY_DELETE_SUCCESS"              => "تم حذف مفتاح المرور بنجاح.",
    "PASSKEY_DELETE_FAIL_DB"              => "فشل حذف مفتاح المرور من قاعدة البيانات.",
    "PASSKEY_DELETE_NOT_FOUND"            => "مفتاح المرور غير موجود أو تم رفض الإذن.",
    "PASSKEY_NOTE_UPDATE_SUCCESS"         => "تم تحديث ملاحظة مفتاح المرور بنجاح.",
    "PASSKEY_NOTE_UPDATE_FAIL"            => "فشل تحديث ملاحظة مفتاح المرور.",
    "PASSKEY_REGISTER_NEW"                => "تسجيل مفتاح مرور جديد",
    "PASSKEY_ERR_LIMIT_REACHED"           => "لقد وصلت إلى الحد الأقصى وهو 10 مفاتيح مرور.",
    "PASSKEY_NOTE_TH"                     => "ملاحظة مفتاح المرور",
    "PASSKEY_TIMES_USED_TH"               => "عدد مرات الاستخدام",
    "PASSKEY_LAST_USED_TH"                => "آخر استخدام",
    "PASSKEY_LAST_IP_TH"                  => "آخر IP",
    "PASSKEY_EDIT_NOTE_BTN"               => "تعديل الملاحظة",
    "PASSKEY_CONFIRM_DELETE_JS"           => "هل أنت متأكد من رغبتك في حذف مفتاح المرور هذا؟",
    "PASSKEY_EDIT_MODAL_TITLE"            => "تعديل ملاحظة مفتاح المرور",
    "PASSKEY_EDIT_MODAL_LABEL"            => "ملاحظة مفتاح المرور",
    "PASSKEY_SAVE_CHANGES_BTN"            => "حفظ التغييرات",
    "PASSKEY_NONE_REGISTERED"             => "ليس لديك أي مفاتيح مرور مسجلة حتى الآن.",
    "PASSKEY_MUST_REGISTER_FIRST"         => "يجب عليك أولاً تسجيل مفتاح مرور من حساب موثق قبل استخدام هذه الميزة.",
    "PASSKEY_STORING"                     => "جاري تخزين مفتاح المرور...",
    "PASSKEY_STORED_SUCCESS"              => "تم تخزين مفتاح المرور بنجاح!",
    "PASSKEY_INVALID_ACTION"              => "إجراء غير صالح: ",
    "PASSKEY_NO_ACTION_SPECIFIED"         => "لم يتم تحديد أي إجراء",
    "PASSKEY_ERR_NETWORK_SUGGESTION"      => "تم اكتشاف مشكلة في الشبكة. جرب شبكة مختلفة أو قم بتحديث الصفحة.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "تم اكتشاف مصادقة عبر الأجهزة. تأكد من أن كلا الجهازين لديهما اتصال بالإنترنت.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "حاول فتح هذه الصفحة مباشرة على هاتفك بدلاً من ذلك.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"       => "لا يمكن إنشاء التشخيصات: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"     => "بيانات الاعتماد المطلوبة للتخزين مفقودة.",
    "PASSKEY_MISSING_AUTH_DATA"           => "بيانات المصادقة المطلوبة مفقودة.",
    "PASSKEY_LOG_NO_MESSAGE"              => "لا توجد رسالة",
    "PASSKEY_USER_NOT_FOUND"              => "لم يتم العثور على المستخدم بعد التحقق من صحة مفتاح المرور.",
    "PASSKEY_FATAL_ERROR"                 => "خطأ فادح: ",
    "PASSKEY_LOGIN_SUCCESS"               => "تم تسجيل الدخول بنجاح.",
    // JavaScript status messages (passkeys.php)
    "PASSKEY_CROSS_DEVICE_PREP"           => "جاري التحضير للتسجيل عبر الأجهزة. قد تحتاج إلى استخدام هاتفك أو جهازك اللوحي.",
    "PASSKEY_DEVICE_REGISTRATION"         => "جاري استخدام تسجيل مفتاح المرور الخاص بالجهاز...",
    "PASSKEY_STARTING_REGISTRATION"       => "جاري بدء تسجيل مفتاح المرور...",
    "PASSKEY_REQUEST_OPTIONS"             => "جاري طلب خيارات التسجيل من الخادم...",
    "PASSKEY_FOLLOW_PROMPTS"              => "اتبع التعليمات لإنشاء مفتاح المرور الخاص بك. قد تحتاج إلى استخدام جهاز آخر.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"       => "اتبع التعليمات لإنشاء مفتاح المرور الخاص بك...",
    "PASSKEY_CREATION_FAILED"             => "فشل إنشاء مفتاح المرور - لم يتم إرجاع أي بيانات اعتماد.",
    "PASSKEY_STORING_SERVER"              => "جاري تخزين مفتاح المرور الخاص بك...",
    "PASSKEY_CREATED_SUCCESS"             => "تم إنشاء مفتاح المرور بنجاح!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP"      => "جاري التحضير للمصادقة عبر الأجهزة. تأكد من أن هاتفك وجهاز الكمبيوتر الخاص بك لديهما اتصال بالإنترنت.",
    "PASSKEY_DEVICE_AUTH"                 => "جاري استخدام مصادقة مفتاح المرور الخاص بالجهاز...",
    "PASSKEY_STARTING_AUTH"               => "جاري بدء مصادقة مفتاح المرور...",
    "PASSKEY_QR_CODE_INSTRUCTION"         => "امسح رمز QR بهاتفك عندما يظهر. تأكد من أن كلا الجهازين لديهما اتصال بالإنترنت.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"    => "اختر \"استخدام هاتف أو جهاز لوحي\" عند الطلب، ثم امسح رمز QR.",
    "PASSKEY_AUTHENTICATING"              => "جاري المصادقة باستخدام مفتاح المرور الخاص بك...",
    "PASSKEY_SUCCESS_REDIRECTING"         => "نجحت المصادقة! جاري إعادة التوجيه...",
    // Timeout messages
    "PASSKEY_TIMEOUT_CROSS_DEVICE"        => "انتهت مهلة التسجيل. للتسجيل عبر الأجهزة: 1) حاول مرة أخرى، 2) تأكد من أن الأجهزة لديها اتصال بالإنترنت، 3) فكر في التسجيل مباشرة على هاتفك.",
    "PASSKEY_TIMEOUT_SIMPLE"              => "انتهت مهلة التسجيل. يرجى المحاولة مرة أخرى.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"   => "انتهت مهلة المصادقة عبر الأجهزة. استكشاف الأخطاء: 1) كلا الجهازين بحاجة إلى إنترنت، 2) حاول مسح رمز QR بسرعة أكبر، 3) فكر في استخدام نفس الجهاز، 4) بعض الشبكات تمنع المصادقة عبر الأجهزة.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"         => "انتهت مهلة المصادقة. يرجى المحاولة مرة أخرى.",
    "PASSKEY_NO_CREDENTIAL"               => "لم يتم استلام أي بيانات اعتماد. جاري إعادة المحاولة...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"   => "فشلت المصادقة - لم يتم إرجاع أي بيانات اعتماد.",
    "PASSKEY_ATTEMPT_RETRY"               => "فشل. جاري إعادة المحاولة... (%d محاولات متبقية)",
    // Error messages
    "PASSKEY_CROSS_DEVICE_FAILED"         => "فشل التسجيل عبر الأجهزة. جرب: 1) تأكد من أن كلا الجهازين لديهما اتصال بالإنترنت، 2) فكر في التسجيل مباشرة على هاتفك، 3) بعض شبكات الشركات تمنع هذه الميزة.",
    "PASSKEY_REGISTRATION_CANCELLED"      => "تم إلغاء التسجيل أو أن الجهاز لا يدعم مفاتيح المرور.",
    "PASSKEY_NOT_SUPPORTED"               => "مفاتيح المرور غير مدعومة على هذا الجهاز/المتصفح.",
    "PASSKEY_SECURITY_ERROR"              => "خطأ أمني - يشير هذا عادةً إلى عدم تطابق النطاق/الأصل.",
    "PASSKEY_ALREADY_EXISTS"              => "يوجد مفتاح مرور بالفعل لهذا الحساب على هذا الجهاز. جرب استخدام جهاز مختلف أو احذف مفاتيح المرور الحالية أولاً.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"    => "فشلت المصادقة عبر الأجهزة. جرب: 1) تأكد من أن كلا الجهازين لديهما إنترنت مستقر، 2) استخدم نفس شبكة الواي فاي إن أمكن، 3) جرب المصادقة مباشرة على هاتفك بدلاً من ذلك، 4) بعض شبكات الشركات تمنع هذه الميزة.",
    "PASSKEY_AUTH_CANCELLED"              => "تم إلغاء المصادقة أو لم يتم تحديد أي مفتاح مرور.",
    "PASSKEY_NETWORK_ERROR"               => "خطأ في الشبكة. للمصادقة عبر الأجهزة، يحتاج كلا الجهازين إلى اتصال بالإنترنت وقد يحتاجان إلى أن يكونا على نفس الشبكة.",
    "PASSKEY_CREDENTIAL_NOT_FOUND"        => "فشلت المصادقة - لم يتم التعرف على بيانات الاعتماد.",
    // Cross-device guidance
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "نصائح للمصادقة عبر الأجهزة:",
    "PASSKEY_GUIDANCE_INTERNET"           => "تأكد من أن جهاز الكمبيوتر وهاتفك لديهما اتصال بالإنترنت",
    "PASSKEY_GUIDANCE_WIFI"               => "التواجد على نفس شبكة الواي فاي يمكن أن يساعد (ولكن ليس مطلوبًا دائمًا)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"      => "عندما يُطلب منك، حدد \"استخدام هاتف أو جهاز لوحي\"",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"       => "امسح رمز QR بسرعة عندما يظهر",
    "PASSKEY_GUIDANCE_TRY_DIRECT"         => "إذا فشل ذلك، جرب تحديث الصفحة واستخدام متصفح هاتفك مباشرة",
    // Troubleshooting
    "PASSKEY_SHOW_TROUBLESHOOTING"        => "إظهار نصائح استكشاف الأخطاء وإصلاحها",
    "PASSKEY_HIDE_TROUBLESHOOTING"        => "إخفاء نصائح استكشاف الأخطاء وإصلاحها",
    "PASSKEY_DIAGNOSTICS_RUNNING"         => "جاري تشغيل التشخيصات...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"        => "اكتملت التشخيصات. تحقق من الكونسول للحصول على التفاصيل.",
    "PASSKEY_ISSUES_DETECTED"             => "تم اكتشاف مشاكل:",
    "PASSKEY_ENVIRONMENT_SUITABLE"        => "البيئة تبدو مناسبة لمفاتيح المرور.",
    "PASSKEY_DIAGNOSTICS_FAILED"          => "فشلت التشخيصات:",
    // Modal
    "PASSKEY_ADD_NOTE_NEW"                => "أضف ملاحظة إلى مفتاح المرور الجديد الخاص بك",
    // Technical errors
    "PASSKEY_BASE64_ERROR"                => "خطأ في فك تشفير Base64:",
    // Server-side errors (passkey_parser.php)
    "PASSKEY_INVALID_JSON"                => "تم استلام بيانات JSON غير صالحة:",
    // Session/validation errors (PasskeyHandler.php)
    "PASSKEY_NO_CHALLENGE_SESSION"        => "لم يتم العثور على تحدي تسجيل مفتاح مرور في الجلسة. يرجى محاولة التسجيل مرة أخرى.",
    "PASSKEY_USER_MISMATCH"               => "عدم تطابق معرّف المستخدم. يرجى محاولة التسجيل مرة أخرى.",
    "PASSKEY_CHALLENGE_USER_MISMATCH"     => "معرّف المستخدم في خيارات التحدي لا يتطابق مع المستخدم الحالي. يرجى محاولة التسجيل مرة أخرى.",
    "PASSKEY_REGISTRATION_FAILED_ERROR"   => "فشل تسجيل مفتاح المرور. يرجى التأكد من أن جهازك ومتصفحك يدعمان WebAuthn وحاول مرة أخرى. الخطأ:",
    "PASSKEY_NO_AUTH_CHALLENGE_SESSION"   => "لم يتم العثور على تحدي تأكيد مفتاح المرور في الجلسة. يرجى محاولة تسجيل الدخول مرة أخرى.",
    "PASSKEY_CREDENTIAL_NOT_IN_DB"        => "بيانات اعتماد مفتاح المرور غير موجودة في قاعدة البيانات.",
    "PASSKEY_CREDENTIAL_WRONG_USER"       => "بيانات اعتماد مفتاح المرور لا تنتمي إلى المستخدم المتوقع.",
    "PASSKEY_VALIDATION_FAILED_ERROR"     => "فشل التحقق من صحة مفتاح المرور. يرجى المحاولة مرة أخرى أو الاتصال بالدعم إذا استمرت المشكلة. الخطأ:",
    "PASSKEY_USER_NOT_FOUND_REGISTRATION" => "لم يتم العثور على المستخدم للتسجيل.",
    // --- Used in passkey_parser.php ---
    "PASSKEY_LOGIN_REQUIRED"              => "يجب أن تكون مسجلاً للدخول لتنفيذ هذا الإجراء.",
    "PASSKEY_ACTION_MISSING"              => "المعلمة المطلوبة 'action' كانت مفقودة من الطلب.",
    "PASSKEY_STORAGE_FAILED"              => "فشل تخزين مفتاح المرور. العملية لم تنجح.",
    "PASSKEY_LOGIN_FAILED"                => "فشل تسجيل الدخول بمفتاح المرور. تعذرت المصادقة.",
    "PASSKEY_INVALID_METHOD"              => "طريقة طلب غير صالحة:", // The script appends the method name after this key
    // --- Used in passkeys.php ---
    "CSRF_ERROR"                          => "فشل التحقق من رمز CSRF. يرجى العودة ومحاولة إرسال النموذج مرة أخرى.",
    // Network analysis from analyzeNetworkConditions()
    "PASSKEY_NETWORK_PRIVATE"             => "مشكلة محتملة: يبدو أنك على شبكة خاصة، والتي يمكن أن تتداخل أحيانًا مع الاتصال عبر الأجهزة.",
    "PASSKEY_NETWORK_PROXY"               => "مشكلة محتملة: تم اكتشاف وكيل (بروكسي) أو VPN. قد يتداخل هذا مع الاتصال عبر الأجهزة.",
    "PASSKEY_NETWORK_MOBILE"              => "ملاحظة: يبدو أنك على شبكة جوال. تأكد من وجود اتصال مستقر للعمليات عبر الأجهزة.",
    "PASSKEY_NETWORK_CORPORATE"           => "مشكلة محتملة: قد يكون جدار حماية الشركة نشطًا، مما قد يؤثر على المصادقة عبر الأجهزة.",
    // Recommendations from getCrossDeviceRecommendations()
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "توصية: من المحتمل أنك تستخدم جهاز كمبيوتر مكتبي. استعد لاستخدام هاتفك لمسح رمز QR.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "توصية: للحصول على أفضل النتائج، تأكد من أن جهاز الكمبيوتر وجهازك المحمول على نفس شبكة الواي فاي.",
    "PASSKEY_RECOMMENDATION_QR_QUICK"     => "توصية: كن مستعدًا لمسح رمز QR بسرعة، حيث قد ينتهي وقت الطلب.",
    "PASSKEY_RECOMMENDATION_INTERNET"     => "توصية: تأكد من أن جهاز الكمبيوتر وجهازك المحمول لديهما اتصال إنترنت مستقر.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "توصية: بالنسبة لـ Unity WebViews، تأكد من أن الصفحة لديها وقت كافٍ لتحميل ومعالجة طلب مفتاح المرور.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "توصية: قد تكون فترات المهلة أطول في Unity. يرجى التحلي بالصبر.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "توصية: نظرًا لأنك على جهاز محمول، يجب أن تكون قادرًا على تسجيل مفتاح مرور مباشرة على هذا الجهاز.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "توصية: على أندرويد، يمكنك إدارة مفاتيح المرور الخاصة بك في مدير كلمات مرور جوجل.",
    // Validation from validateCrossDeviceEnvironment()
    "PASSKEY_VALIDATION_RP_IP"            => "تحذير التكوين: تم تعيين معرّف الطرف الموثوق (Relying Party ID) إلى عنوان IP.",
    "PASSKEY_VALIDATION_RP_DOMAIN"        => "توصية: قم بتعيين معرّف الطرف الموثوق إلى اسم النطاق الخاص بك (على سبيل المثال, yourwebsite.com) لتحسين الأمان والتوافق.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"   => "خطأ في التكوين: مطلوب HTTPS لكي تعمل مفاتيح المرور على خادم مباشر. يبدو أن موقعك على HTTP.",
    "PASSKEY_VALIDATION_NETWORK"          => "تحذير الشبكة", // Generic prefix for network issues
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "توصية: إذا واجهت مشاكل، جرب شبكة مختلفة (على سبيل المثال، قم بالتبديل من شبكة الواي فاي الخاصة بالشركة إلى نقطة اتصال محمولة).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "توصية: للإجراءات عبر الأجهزة، تأكد من أن كلا الجهازين لديهما اتصال إنترنت موثوق.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"  => "توصية: إذا فشلت الإجراءات عبر الأجهزة، جرب زيارة هذه الصفحة مباشرة على جهازك المحمول لإكمال الإجراء.",
    "PASSKEY_INFO_TITLE"                  => "حول مفاتيح المرور",
    "PASSKEY_INFO_DESC"                   => "مفاتيح المرور هي طريقة آمنة وخالية من كلمات المرور لتسجيل الدخول باستخدام ميزات الأمان المدمجة في جهازك مثل بصمة الإصبع أو التعرف على الوجه أو رمز PIN. إنها أكثر أمانًا من كلمات المرور، وتوفر تسجيل دخول أسرع، وتعمل عبر الأجهزة عند مزامنتها مع مديري كلمات المرور، ومقاومة لهجمات التصيد الاحتيالي. تعمل مفاتيح المرور على الهواتف الذكية والأجهزة اللوحية وأجهزة الكمبيوتر الحديثة، ويمكن تخزينها في مديري كلمات المرور مثل 1Password أو Bitwarden أو iCloud Keychain أو Google Password Manager.",
    "PASSKEY_BACK_TO_LOGIN"               => "العودة إلى صفحة تسجيل الدخول",
));


//validation class
$lang = array_merge($lang, array(
	"VAL_SAME"				=> "يجب ان يتطابقا",
	"VAL_EXISTS"			=> "موجود بالفعل. برجاء اختيار قيمة مختلفة",
	"VAL_DB"					=> "خطأ في قاعدة البيانات",
	"VAL_NUM"					=> "مسموح بالأرقام فقط",
	"VAL_INT"					=> "يجب ان يكون عدد صحيحاً",
	"VAL_EMAIL"				=> "يجب ان يكون بريد الكتروني صالح",
	"VAL_NO_EMAIL"		=> "لا يمكنك استخدام بريد الكتروني",
	"VAL_SERVER"			=> "يجب أن ينتمي إلى خادم صالح",
	"VAL_LESS"				=> "يجب ان يكون اقل من",
	"VAL_GREAT"				=> "يجب ان يكون اكبر من",
	"VAL_LESS_EQ"			=> "يجب ان يكون اقل من او يساوي",
	"VAL_GREAT_EQ"		=> "يجب ان يكون اكبر من او يساوي",
	"VAL_NOT_EQ"			=> "يجب الا يساوي",
	"VAL_EQ"					=> "يجب ان يساوي",
	"VAL_TZ"					=> "يجب ان يكون اسم منطقة زمنية صالح",
	"VAL_MUST"				=> "يجب ان يكون",
	"VAL_MUST_LIST"		=> "يجب ان يكون واحد من",
	"VAL_TIME"				=> "يجب ان يكون توقيت صالح",
	"VAL_SEL"					=> "اختيار خطأ",
	"VAL_NA_PHONE"		=> "يجب أن يكون رقم هاتف صالحًا في أمريكا الشمالية",
));

//Time
$lang = array_merge($lang, array(
	"T_YEARS"			=> "سنوات",
	"T_YEAR"			=> "سنة",
	"T_MONTHS"		=> "شهور",
	"T_MONTH"			=> "شهر",
	"T_WEEKS"			=> "اسابيع",
	"T_WEEK"			=> "اسبوع",
	"T_DAYS"			=> "ايام",
	"T_DAY"				=> "يوم",
	"T_HOURS"			=> "ساعات",
	"T_HOUR"			=> "ساعة",
	"T_MINUTES"		=> "دقائق",
	"T_MINUTE"		=> "دقيقة",
	"T_SECONDS"		=> "ثواني",
	"T_SECOND"		=> "ثانية",
));


//Passwords
$lang = array_merge($lang, array(
	"PW_NEW"		=> "كلمة  السر جديدة",
	"PW_OLD"		=> "كلمة السر القديمة",
	"PW_CONF"		=> "تأكيد كلمة السر",
	"PW_RESET"	=> "اعدة ضبط كلمة السر",
	"PW_UPD"		=> "تم تحديث كلمة السر",
	"PW_SHOULD"	=> "...كلمة السر يجب انـ",
	"PW_SHOW"		=> "اظهار كلمة السر",
	"PW_SHOWS"	=> "اظهار كلمات السر",
));


//Join
$lang = array_merge($lang, array(
	"JOIN_SUC"		=> " مرحبا في ",
	"JOIN_THANKS"	=> "شكراً لتسجيلك",
	"JOIN_HAVE"		=> " يحتوي على الاقل",
	"JOIN_SYMBOL"		=> "رمز",
	"JOIN_LOWER"		=> "حروف صغيرة",
	"JOIN_CAP"		=> " حروف كبيرة",
	"JOIN_TWICE"	=> "متطابق",
	"JOIN_CLOSED"	=> "للأسف التسجيل مغلق الان برجاء التواصل مع ادارة الموقع اذا كان لديك اي استفسار",
	"JOIN_TC"			=> "شروط وقوانين التسجيل",
	"JOIN_ACCEPTTC" => "اوافق على الشروط والاحكام",
	"JOIN_CHANGED"	=> "تم تغيير شروطنا",
	"JOIN_ACCEPT" 	=> "قبول الشروط والاحكام والمتابعة",
	"JOIN_SCORE" => "النقاط:",
	"JOIN_INVALID_PW" => "كلمة المرور غير صالحة",

));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "تم الحذف بنجاح",
));

//Messages
$lang = array_merge($lang, array(
	"MSG_SENT"			=> "تم ارسال رسالتك",
	"MSG_MASS"			=> "تم ارسال رسالتك الجماعية",
	"MSG_NEW"				=> "رسالة جديدة",
	"MSG_NEW_MASS"	=> "رسالة جماعية جديدة",
	"MSG_CONV"			=> "المحادثات",
	"MSG_NO_CONV"		=> "لا توجد محادثات",
	"MSG_NO_ARC"		=> "لا توجد محادثات",
	"MSG_QUEST"			=> "ارسال اشعارات عبر البريد اذا كانت مفعلة؟",
	"MSG_ARC"				=> "مواضيع مؤرشفة",
	"MSG_VIEW_ARC"	=> "عرض المواضيع المؤرشفة",
	"MSG_SETTINGS"  => "اعدادت الرسائل",
	"MSG_READ"			=> "قراءة",
	"MSG_BODY"			=> "نص الرسالة",
	"MSG_SUB"				=> "الموضوع",
	"MSG_DEL"				=> "تم التسليم",
	"MSG_REPLY"			=> "الرد",
	"MSG_QUICK"			=> "رد سريع",
	"MSG_SELECT"		=> "تحديد عضو",
	"MSG_UNKN"			=> "مستلم مجهول",
	"MSG_NOTIF"			=> "اشعارات البريد الالكتروني",
	"MSG_BLANK"			=> "الرسالة لا يمكن ان تكون فارغة",
	"MSG_MODAL"			=> "لفتح جزء الرد الموسع Shift + R للتركيز على هذا المربع أو اضغط على او اضغط على Alt + R انقر هنا أو اضغط على",
	"MSG_ARCHIVE_SUCCESSFUL"        => "محادثة %m1% تم ارشفة",
	"MSG_UNARCHIVE_SUCCESSFUL"      => "محادثة %m1% تم الغاء ارشفة",
	"MSG_DELETE_SUCCESSFUL"         => "محادثة %m1% تم حذف",
	"USER_MESSAGE_EXEMPT"         			=> "معفي من الرسائل %m1% المستخدم",
	"MSG_MK_READ"		=> "قراءة.",
	"MSG_MK_UNREAD"	=> "غير مقروء",
	"MSG_ARC_THR"		=> "ارشفة المواضيع المحددة",
	"MSG_UN_THR"		=> "عدم ارشفة المواضيع المحددة",
	"MSG_DEL_THR"		=> "مسح المواضيع المحددة",
	"MSG_SEND"			=> "ارسال رسالة",
));
//2 Factor Authentication
//Two Factor Authentication
$lang = array_merge($lang, array(
    "2FA"                                => "المصادقة الثنائية",
    "2FA_CONF"                           => "هل أنت متأكد من رغبتك في تعطيل المصادقة الثنائية؟ لن يكون حسابك محميًا بعد الآن.",
    "2FA_SCAN"                           => "امسح رمز QR هذا باستخدام تطبيق المصادقة الخاص بك أو أدخل المفتاح",
    "2FA_THEN"                           => "ثم أدخل أحد رموز المرور لمرة واحدة هنا",
    "2FA_FAIL"                           => "حدثت مشكلة في التحقق من المصادقة الثنائية. يرجى التحقق من الإنترنت أو الاتصال بالدعم.",
    "2FA_CODE"                           => "رمز المصادقة الثنائية",
    "2FA_EXP"                            => "انتهت صلاحية بصمة إصبع واحدة",
    "2FA_EXPD"                           => "منتهية الصلاحية",
    "2FA_EXPS"                           => "تنتهي الصلاحية",
    "2FA_ACTIVE"                         => "الجلسات النشطة",
    "2FA_NOT_FN"                         => "لم يتم العثور على بصمات أصابع",
    "2FA_FP"                             => "بصمات الأصابع",
    "2FA_NP"                             => "فشل تسجيل الدخول - رمز المصادقة الثنائية لم يكن موجودًا. يرجى المحاولة مرة أخرى.",
    "2FA_INV"                            => "فشل تسجيل الدخول - رمز المصادقة الثنائية كان غير صالح. يرجى المحاولة مرة أخرى.",
    "2FA_FATAL"                          => "خطأ فادح - يرجى الاتصال بمسؤول النظام. لا يمكننا إنشاء رمز مصادقة ثنائية في هذا الوقت.",
    "2FA_SECTION_TITLE"                  => "المصادقة الثنائية (TOTP)",
    "2FA_SK_ALT"                         => "إذا لم تتمكن من مسح رمز QR، فأدخل هذا المفتاح السري يدويًا في تطبيق المصادقة الخاص بك.",
    "2FA_IS_ENABLED"                     => "المصادقة الثنائية تحمي حسابك.",
    "2FA_NOT_ENABLED_INFO"               => "المصادقة الثنائية غير مفعلة حاليًا.",
    "2FA_NOT_ENABLED_EXPLAIN"            => "المصادقة الثنائية (TOTP) تضيف طبقة إضافية من الأمان إلى حسابك من خلال طلب رمز من تطبيق المصادقة على هاتفك بالإضافة إلى كلمة المرور الخاصة بك.",
    // Setup Process
    "2FA_SETUP_TITLE"                    => "إعداد المصادقة الثنائية",
    "2FA_SECRET_KEY_LABEL"               => "المفتاح السري:",
    "2FA_SETUP_VERIFY_CODE_LABEL"        => "أدخل رمز التحقق من التطبيق",
    // Backup Codes
    "2FA_SUCCESS_ENABLED_TITLE"          => "تم تفعيل المصادقة الثنائية! احفظ رموزك الاحتياطية",
    "2FA_SUCCESS_ENABLED_INFO"           => "فيما يلي رموزك الاحتياطية. قم بتخزينها بشكل آمن - يمكن استخدام كل منها مرة واحدة فقط.",
    "2FA_BACKUP_CODES_WARNING"           => "تعامل مع هذه الرموز مثل كلمات المرور. قم بتخزينها بشكل آمن.",
    "2FA_SUCCESS_BACKUP_REGENERATED"     => "تم إنشاء رموز احتياطية جديدة. احفظها بشكل آمن.",
    "2FA_BACKUP_CODE_LABEL"              => "الرمز الاحتياطي",
    "2FA_REGEN_CODES_BTN"                => "إعادة إنشاء الرموز الاحتياطية",
    "2FA_INVALIDATE_WARNING"             => "سيؤدي هذا إلى إبطال جميع الرموز الاحتياطية الحالية. هل أنت متأكد؟",
    // Authentication
    "2FA_CODE_LABEL"                     => "رمز المصادقة",
    "2FA_VERIFY_BTN"                     => "تحقق وسجل الدخول",
    "2FA_VERIFY_TITLE"                   => "المصادقة الثنائية مطلوبة",
    "2FA_VERIFY_INFO"                    => "أدخل الرمز المكون من 6 أرقام من تطبيق المصادقة الخاص بك.",
    // Actions & Buttons
    "2FA_ENABLE_BTN"                     => "تفعيل المصادقة الثنائية",
    "2FA_DISABLE_BTN"                    => "تعطيل المصادقة الثنائية",
    "2FA_VERIFY_ACTIVATE_BTN"            => "تحقق وفعّل",
    "2FA_CANCEL_SETUP_BTN"               => "إلغاء الإعداد",
    "2FA_DONE_BTN"                       => "تم",
    // Success Messages
    "REDIR_2FA_DIS"                      => "تم تعطيل المصادقة الثنائية.",
    "2FA_SUCCESS_BACKUP_ACK"             => "تم الإقرار بالرموز الاحتياطية.",
    "2FA_SUCCESS_SETUP_CANCELLED"        => "تم إلغاء الإعداد.",
    // Error Messages
    "2FA_ERR_INVALID_BACKUP"             => "رمز احتياطي غير صالح. يرجى المحاولة مرة أخرى.",
    "2FA_ERR_DISABLE_FAILED"             => "فشل تعطيل المصادقة الثنائية.",
    "2FA_ERR_NO_SECRET"                  => "تعذر استرداد سر المصادقة. يرجى المحاولة مرة أخرى.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"     => "تم التحقق من الرمز الاحتياطي ولكن فشل إبطاله. يرجى الاتصال بالدعم.",
    "2FA_ERR_NO_CODE_PROVIDED"           => "لم يتم تقديم رمز مصادقة.",
    "RATE_LIMIT_LOGIN"                   => "عدد كبير جدًا من محاولات تسجيل الدخول الفاشلة. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_TOTP"                    => "عدد كبير جدًا من رموز المصادقة غير الصحيحة. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_PASSKEY"                 => "عدد كبير جدًا من محاولات المصادقة بمفتاح المرور. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_PASSKEY_STORE"           => "عدد كبير جدًا من محاولات تسجيل مفتاح المرور. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_PASSWORD_RESET"          => "عدد كبير جدًا من طلبات إعادة تعيين كلمة المرور. يرجى الانتظار قبل طلب إعادة تعيين أخرى.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT"   => "عدد كبير جدًا من محاولات إعادة تعيين كلمة المرور. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_REGISTRATION"            => "عدد كبير جدًا من محاولات التسجيل. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_EMAIL_VERIFICATION"      => "عدد كبير جدًا من طلبات التحقق من البريد الإلكتروني. يرجى الانتظار قبل طلب تحقق آخر.",
    "RATE_LIMIT_EMAIL_CHANGE"            => "عدد كبير جدًا من طلبات تغيير البريد الإلكتروني. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_PASSWORD_CHANGE"         => "عدد كبير جدًا من محاولات تغيير كلمة المرور. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_GENERIC"                 => "عدد كبير جدًا من المحاولات. يرجى الانتظار قبل المحاولة مرة أخرى.",
));

$lang = array_merge($lang, array(
	"REDIR_2FA"						=> "عذرا التحقق بخطوتين غير متاح حاليا",
	"REDIR_2FA_EN"				=> "التحقق بخطوتين متاح",
	"REDIR_2FA_DIS"				=> "التحقق بخطوتين معطل",
	"REDIR_2FA_VER"				=> "2   عامل   مصادقة   تم التحقق   و   تمكين",
	"REDIR_SOMETHING_WRONG" => "حدث خطأ ما. يرجى المحاولة مرة أخرى.",
	"REDIR_MSG_NOEX" => "هذا الموضوع لا ينتمي لك أو لا يوجد.",
	"REDIR_UN_ONCE" => "تم تغيير اسم المستخدم مرة واحدة بالفعل.",
	"REDIR_EM_SUCC" => "تم تحديث البريد الإلكتروني بنجاح",

));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "تسجيل الدخول باستخدام:",
	"EML_FEATURE_DISABLED" => "تم تعطيل هذه الميزة",
	"EML_PASSWORDLESS_SENT" => "يرجى التحقق من بريدك الإلكتروني للحصول على رابط لتسجيل الدخول.",
	"EML_PASSWORDLESS_SUBJECT" => "يرجى التحقق من بريدك الإلكتروني لتسجيل الدخول.",
	"EML_PASSWORDLESS_BODY" => "يرجى التحقق من عنوان بريدك الإلكتروني عن طريق النقر فوق الرابط أدناه. ستتم تسجيل الدخول تلقائيًا.",

	"EML_CONF"			=> "تأكيد الايميل",
	"EML_VER"				=> "التحقق من البريد الالكتروني",
	"EML_CHK"				=> "تم تلقي طلبك. يرجى التحقق من بريدك الالكتروني لتأكيده. تأكد من التحقق من مجلد الرسائل غير المرغوب فيها",
	"EML_MAT"				=> "عنوان البريد الالكتروني غير متطابق",
	"EML_HELLO"			=> " مرحباً من",
	"EML_HI"				=> "Hi ",
	"EML_AD_HAS"		=> "لقد اعيد تعيين كلمة مرورك بواسطة فريق الادارة",
	"EML_AC_HAS"		=> "تم انشاء هذا الحساب بواسطة فريق الادارة",
	"EML_REQ"				=> "برجاء تعيين كلمة مرور جديدة بإستخدام الرابط اعلاه",
	"EML_EXP"				=> "برجاء الملاحظة ان الرابط تنتهي صلاحيته في ",
	"EML_VER_EXP"		=> "برجاء الملاحظة ان رابط التفعيل تنتهي صلاحيته في ",
	"EML_CLICK"			=> "اضغط هنا لستجيل الدخول",
	"EML_REC"				=> "ينصح بتغيير كع المرور عند تسجيل الدخول",
	"EML_MSG"				=> "رسالة جديدة من",
	"EML_REPLY"			=> "انقر للرد او لعرض المحادثة",
	"EML_WHY"				=> "تم ارسال هذه الرسالة بناءً على طلبك اعادة تعيين كلمة المرور الخاصة بحسابك, اذا لم تكن انت من قمت بطلب اعادة التعيين, يمكنك تجاهله",
	"EML_HOW"				=> "اذا كنت انت برجاء الضغط على الرابط ادناه لإكمال العملية",
	"EML_EML"				=> "تم تقديم طلب لتغيير البريد الالكتروني من حسابك",
	"EML_VER_EML"		=> "شكرا لتسجيلك, بمجرد تأكيد البريد الالكتروني سوف تتمكن من تسجيل الدخول, برجاء الضغط على الرابط ادناء لتفعيل حسابك",
));

//Verification
$lang = array_merge($lang, array(
	"VER_SUC"			=> "تم التحقق من البريد الالكتروني",
	"VER_FAIL"		=> "لا يمكننا التحقق من حسابك برجاء المحاولة مرة اخرى",
	"VER_RESEND"	=> "اعادة ارسال التحقق من البريد الالكتروني",
	"VER_AGAIN"		=> "اعد كتابة البريد الالكتروني وحاول مجدداً",
	"VER_PAGE"		=> "<li>افحص بريدك الالكتروني واضغط على الرابط المرسل لك</li><li>انتهى</li>",
	"VER_RES_SUC" => " تم ارسال رابط التحقق الى بريدك الالكتروني  اضغط على الرابط الذي تم ارساله لإكمال التحقق.في حالة لم تجد الرسالة تأكد من مراجعة الرسائل المهملة  الرابط صالح لمدة",
	"VER_OOPS"		=> "عفواً!... حدث خطأ ما ربما استخدمت رابط تحقق منتهي الصلاحية/قديم اضغط بالأسفل للمحاولة مجدداً",
	"VER_RESET"		=> "تم اعادة ضبط كلمة المرور",
	"VER_INS"			=> "<li>اكتب بريدك الالكتروني واضغط اعادة ضبط</li> <li>افحص بريدك الالكتروني واضغط على الرابط المرسل</li>
												<li>اتبع التعليمات على الشاشة</li>",
	"VER_SENT"		=> " تم ارسال رابط اعادة ضبط كلمة المرور الى بريدك الالكتروني 
			    							 اضغط على الرابط في الرسالة لإعادة ضبط كلمة المرور. في حالة لم تجد الرسالة تأكد من مراجعة الرسائل المهملة  الرابط صالح لمدة",
	"VER_PLEASE"	=> "برجاء اعادة ضبط كلمة المرور",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"				=> "PINاعادة ضبط الـ",
	"SET_WHY"				=> "لماذا لا يمكنني تغيير ذلك؟",
	"SET_PW_MATCH"	=> "يجب أن تطابق كلمة المرور الجديدة",

	"SET_PIN_NEXT"	=> "المرة المقبلة التي تطلب فيها رابط تحقق PIN يمكنك اعادة ضبط الـ",
	"SET_UPDATE"		=> "تحديث اعدادات الحساب",
	"SET_NOCHANGE"	=> "تغيير اسم المستخدم معطل",
	"SET_ONECHANGE"	=> "عفواً!...لا يمكنك تغيير اسم المستخدم اكثر من مرة",

	"SET_GRAVITAR"	=> "هل تريد تغيير الصورة الرمزية؟ <br>توجه لـ <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a>وقم بفتح حساب بنفس الايميل المستخدم هنا هذه الخدمة مدعومة من ملايين المواقع تتميز بالسهولة والسرعة",

	"SET_NOTE1"			=> " برجاء ملاحظة  هناك طلب تحقق معلق لتحديث بريدك الالكتروني",

	"SET_NOTE2"			=> ".  يرجى استخدام رسالة التحقق لإكمال هذا الطلب 
		 إذا كنت بحاجة إلى رسالة تحقق جديدة ، يرجى إعادة إدخال البريد الإلكتروني وإرسال الطلب مرة أخرى ",

	"SET_PW_REQ" 		=> "[PIN]مطلوب لتغيير كلمة المرور أو البريد الإلكتروني أو إعادة تعيين رقم التعريف الشخصي",
	"SET_PW_REQI" 	=> "مطلوب لإعادة تعيين كلمة المرور",

));
//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> ":فشل انهاء الجلسات النشطة,خطأ",
	"ERR_EMAIL"				=> "خطأ في ارسال الايميل, برجاء التواصل مع الدعم الفني",
	"ERR_EM_DB"				=> "عنوان البريد الالكتروني الذي ادخله غير مسجل لدينا",
	"ERR_TC"					=> "برجاء قراءة البنود والشروط وقبولها",
	"ERR_CAP"					=> "خطأ,في كلمة التحقق",
	"ERR_PW_SAME"			=> "لا يمكنك استخدام كلمة المرور القديمة",
	"ERR_PW_FAIL"			=> "فشل التحقق من كلمة المرور الحالية. فشل التحديث. برجاء حاول مجدداً",
	"ERR_GOOG"				=> ":ملاحظة سيتعين عليك استخدام خاصية -نسيت كلمة المرور- لتعيين كلمة مرور خاصة بموقعنا Google/Facebook في حالة تسجيل الدخول بإستخدام حسابك في",
	"ERR_EM_VER"			=> "التحقق من البريد الالكتروني غير مفعلة",
	"ERR_EMAIL_STR"		=> "حدث خطأ ما, يرجى إعادة التحقق من بريدك الإلكتروني. نأسف على الازعاج",
));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "سوف نعود قريباً",
	"MAINT_MSG"			=> "نأسف على الازعاج, جاري عمل بعض الصيانة في الموقع<br>سيعود الموقع للعمل قريباً",
	"MAINT_BAN"			=> "عفواً,لقد تم حظر حسابك اذا كنت تشعر ان هذا خطأ برجاء التواصل مع الادارة",
	"MAINT_TOK"			=> "هناك خطأ في النموذج الخاص بك. الرجاء العودة والمحاولة مجددا. يرجى ملاحظة أن إرسال النموذج عن طريق تحديث الصفحة سوف يحدث خطأ. إذا استمر هذا في الحدوث ، يرجى التواصل مع الادارة",
	"MAINT_OPEN"		=> "لإدارة المستخدمين,مفتوح المصدر PHP اطار عمل",
	"MAINT_PLEASE"	=> "بنجاح UserSpice! تم تثبيت<br>لمشاهدة كيف يمكنك التعامل مع الخصائص المختلفة برجاء زيارة"
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
	"DAT_SEARCH"    => "بحث",
	"DAT_FIRST"     => "الاول",
	"DAT_LAST"      => "الاخير",
	"DAT_NEXT"      => "اتالي",
	"DAT_PREV"      => "السابق",
	"DAT_NODATA"        => "لا توجد بيانات في الجدول",
	"DAT_INFO" => "عرض _START_ إلى _END_ من إجمالي _TOTAL_ مدخل",
	"DAT_ZERO" => "عرض 0 إلى 0 من 0 مدخل",
	"DAT_FILTERED" => "(تمت التصفية من إجمالي _MAX_ مدخل)",
	"DAT_MENU_LENG" => "عرض _MENU_ مدخل",

	"DAT_LOADING"       => "...جاري التحميل",
	"DAT_PROCESS"       => "تتم المعالجة",
	"DAT_NO_REC"        => "لا توجد سجلات مطابقة",
	"DAT_ASC"           => "تفعيل لفرز العمود تصاعدي",
	"DAT_DESC"          => "تفعيل لفرز العمود تنازلي",
));

///////////////////////////////////////////////////////////////

//Backend Translations for UserSpice
$lang = array_merge($lang, array(
	"BE_DASH"    			=> "لوحة الادارة",
	"BE_SETTINGS"     => "اعدادات",
	"BE_GEN"					=> "عام",
	"BE_REG"					=> "التسجيل",
	"BE_CUS"					=> "إعدادات مخصصة",
	"BE_DASH_ACC"			=> "الوصول إلى لوحة التحكم",
	"BE_TOOLS"				=> "ادوات",
	"BE_BACKUP"				=> "نسخ احتياطي",
	"BE_UPDATE"				=> "تحديث",
	"BE_CRON" => "وظائف الكرون",
	"BE_IP" => "مدير الآي بي",

));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
