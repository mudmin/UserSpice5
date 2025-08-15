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
$lang = array_merge($lang, array(
	"THIS_LANGUAGE"	=> "Arabic (Egyptian)",
	"THIS_CODE"			=> "ar-EG",
	"MISSING_TEXT"	=> "Missing Text",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "دخل الكود اللي اتبعت على إيميلك",
    "PASS_EMAIL_ONLY"     => "لو سمحت شوف إيميلك علشان لينك تسجيل الدخول",
    "PASS_CODE_ONLY"      => "لو سمحت دخل الكود اللي اتبعت على إيميلك",
    "PASS_BOTH"           => "لو سمحت شوف إيميلك علشان لينك تسجيل الدخول أو دخل الكود اللي اتبعت على إيميلك",
    "PASS_VER_BUTTON"     => "تأكيد الكود",
    "PASS_EMAIL_ONLY_MSG" => "لو سمحت أكد إيميلك بالضغط على اللينك اللي تحت",
    "PASS_CODE_ONLY_MSG"  => "لو سمحت دخل الكود اللي تحت علشان تسجل دخول",
    "PASS_BOTH_MSG"       => "لو سمحت أكد إيميلك بالضغط على اللينك اللي تحت أو دخل الكود اللي تحت علشان تسجل دخول",
    "PASS_YOUR_CODE"      => "كود التأكيد بتاعك هو: ",
    "PASS_CONFIRM_LOGIN"  => "تأكيد تسجيل الدخول",
    "PASS_CONFIRM_CLICK"  => "اضغط لإكمال تسجيل الدخول",
    "PASS_GENERIC_ERROR"  => "في حاجة غلط حصلت",
));

//Database Menus
$lang = array_merge($lang, array(
	"MENU_HOME"			=> "الرئيسية",
	"MENU_HELP"			=> "مساعدة",
	"MENU_ACCOUNT"	=> "الحساب",
	"MENU_DASH"			=> "لوحة الادارة",
	"MENU_USER_MGR"	=> "ادارة المستخدمين",
	"MENU_PAGE_MGR"	=> "ادارة الصفحات",
	"MENU_PERM_MGR"	=> "ادارة الصلاحيات",
	"MENU_MSGS_MGR"	=> "مدير الرسائل",
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
	"SIGNIN_PLEASE_CHK" => "برجاء التحقق من اسم المستخدم وكلمة المرور",
	"SIGNIN_UORE"				=> "اسم المستخدم او الايميل",
	"SIGNIN_PASS"				=> "كلمة السر",
	"SIGNIN_TITLE"			=> "برجاء تسجيل الدخول",
	"SIGNIN_TEXT"				=> "تسجيل دخول",
	"SIGNOUT_TEXT"			=> "خروج",
	"SIGNIN_BUTTONTEXT"	=> "دخول",
	"SIGNIN_REMEMBER"		=> "تذكرني",
	"SIGNIN_AUDITTEXT"	=> "تم تسجيل الدخول",
	"SIGNIN_FORGOTPASS"	=> "نسيت كلمة السر",
	"SIGNOUT_AUDITTEXT"	=> "تم تسجيل الخروج",
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

// added during passkey/totp update
$lang = array_merge($lang, array(

    // --- General ---
    "GEN_PASSKEY"                   => "مفتاح المرور",
    "GEN_ACTIONS"                   => "الإجراءات",
    "GEN_BACK_TO_ACCT"              => "الرجوع إلى الحساب",
    "GEN_DB_ERROR"                  => "حدث خطأ في قاعدة البيانات. حاول مرة أخرى.",
    "GEN_IMPORTANT"                 => "هام",
    "GEN_NO_PERMISSIONS"            => "ليس لديك صلاحية للوصول إلى هذه الصفحة.",
    "GEN_NO_PERMISSIONS_MSG"        => "ليس لديك صلاحية للوصول إلى هذه الصفحة. إذا كنت تعتقد أن هذا خطأ، يرجى التواصل مع مسؤول الموقع.",

    // --- Passkeys (titles / headings) ---
    "PASSKEYS_MANAGE_TITLE"         => "إدارة مفاتيح المرور",
    "PASSKEYS_LOGIN_TITLE"          => "تسجيل الدخول بمفتاح المرور",

    // --- Passkey CRUD ---
    "PASSKEY_DELETE_SUCCESS"        => "تم حذف مفتاح المرور بنجاح.",
    "PASSKEY_DELETE_FAIL_DB"        => "فشل حذف مفتاح المرور من قاعدة البيانات.",
    "PASSKEY_DELETE_NOT_FOUND"      => "لم يتم العثور على مفتاح المرور أو لا تملك صلاحية الحذف.",
    "PASSKEY_NOTE_UPDATE_SUCCESS"   => "تم تحديث ملاحظة مفتاح المرور بنجاح.",
    "PASSKEY_NOTE_UPDATE_FAIL"      => "فشل تحديث ملاحظة مفتاح المرور.",
    "PASSKEY_REGISTER_NEW"          => "تسجيل مفتاح مرور جديد",
    "PASSKEY_ERR_LIMIT_REACHED"     => "لقد وصلت إلى الحد الأقصى وهو 10 مفاتيح مرور.",

    // --- Table / list headers & buttons ---
    "PASSKEY_NOTE_TH"               => "ملاحظة مفتاح المرور",
    "PASSKEY_TIMES_USED_TH"         => "عدد مرات الاستخدام",
    "PASSKEY_LAST_USED_TH"          => "آخر استخدام",
    "PASSKEY_LAST_IP_TH"            => "آخر عنوان IP",
    "PASSKEY_EDIT_NOTE_BTN"         => "تعديل الملاحظة",
    "PASSKEY_CONFIRM_DELETE_JS"     => "هل أنت متأكد أنك تريد حذف مفتاح المرور هذا؟",
    "PASSKEY_EDIT_MODAL_TITLE"      => "تعديل ملاحظة مفتاح المرور",
    "PASSKEY_EDIT_MODAL_LABEL"      => "ملاحظة مفتاح المرور",
    "PASSKEY_SAVE_CHANGES_BTN"      => "حفظ التغييرات",
    "PASSKEY_NONE_REGISTERED"       => "ليس لديك أي مفاتيح مرور مسجلة بعد.",
    "PASSKEY_MUST_REGISTER_FIRST"   => "يجب عليك أولاً تسجيل مفتاح مرور من حساب موثَّق قبل استخدام هذه الميزة.",

    // --- Status / progress ---
    "PASSKEY_STORING"               => "جارٍ حفظ مفتاح المرور...",
    "PASSKEY_STORED_SUCCESS"        => "تم حفظ مفتاح المرور بنجاح!",
    "PASSKEY_INVALID_ACTION"        => "إجراء غير صالح: ",
    "PASSKEY_NO_ACTION_SPECIFIED"   => "لم يتم تحديد أي إجراء",

    // --- Duplicate titles (keep for compatibility) ---
    "PASSKEYS_MANAGE_TITLE"         => "إدارة مفاتيح المرور الخاصة بك",
    "PASSKEYS_LOGIN_TITLE"          => "تسجيل الدخول بمفتاح المرور",

    // --- Errors / suggestions ---
    "PASSKEY_ERR_NETWORK_SUGGESTION"        => "تم اكتشاف مشكلة في الشبكة. جرِّب شبكة مختلفة أو حدّث الصفحة.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION"   => "تم اكتشاف مصادقة بين جهازين. تأكد من أن كلا الجهازين متصلان بالإنترنت.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE"  => "جرّب فتح هذه الصفحة مباشرة على هاتفك بدلاً من ذلك.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"         => "تعذر إنشاء بيانات التشخيص: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"       => "تبيّن فقدان بيانات الاعتماد المطلوبة للحفظ.",
    "PASSKEY_MISSING_AUTH_DATA"             => "تبيّن فقدان بيانات المصادقة المطلوبة.",
    "PASSKEY_LOG_NO_MESSAGE"                => "لا توجد رسالة",
    "PASSKEY_USER_NOT_FOUND"                => "لم يتم العثور على المستخدم بعد التحقق من مفتاح المرور.",
    "PASSKEY_FATAL_ERROR"                   => "خطأ فادح: ",
    "PASSKEY_LOGIN_SUCCESS"                 => "تم تسجيل الدخول بنجاح.",

    // --- JavaScript (registration / auth flow) ---
    "PASSKEY_CROSS_DEVICE_PREP"             => "جارٍ تجهيز التسجيل بين جهازين. قد تحتاج لاستخدام هاتفك أو تابلت.",
    "PASSKEY_DEVICE_REGISTRATION"           => "جارٍ استخدام تسجيل مفتاح مرور للجهاز...",
    "PASSKEY_STARTING_REGISTRATION"         => "جارٍ بدء تسجيل مفتاح المرور...",
    "PASSKEY_REQUEST_OPTIONS"               => "جارٍ طلب خيارات التسجيل من الخادم...",
    "PASSKEY_FOLLOW_PROMPTS"                => "اتبع الإرشادات لإنشاء مفتاح المرور. قد تحتاج لاستخدام جهاز آخر.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"         => "اتبع الإرشادات لإنشاء مفتاح المرور...",
    "PASSKEY_CREATION_FAILED"               => "فشل إنشاء مفتاح المرور - لم يتم إرجاع بيانات اعتماد.",
    "PASSKEY_STORING_SERVER"                => "جارٍ حفظ مفتاح المرور...",
    "PASSKEY_CREATED_SUCCESS"               => "تم إنشاء مفتاح المرور بنجاح!",

    "PASSKEY_CROSS_DEVICE_AUTH_PREP"        => "جارٍ تجهيز المصادقة بين جهازين. تأكد من أن هاتفك والكمبيوتر متصلان بالإنترنت.",
    "PASSKEY_DEVICE_AUTH"                   => "جارٍ استخدام مصادقة مفتاح المرور للجهاز...",
    "PASSKEY_STARTING_AUTH"                 => "جارٍ بدء مصادقة مفتاح المرور...",
    "PASSKEY_QR_CODE_INSTRUCTION"           => "امسح رمز QR بهاتفك عند ظهوره. تأكد من أن كلا الجهازين متصلان بالإنترنت.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"      => "اختر \"استخدام هاتف أو تابلت\" عند الطلب، ثم امسح رمز QR.",
    "PASSKEY_AUTHENTICATING"                => "جارٍ المصادقة بمفتاح المرور...",
    "PASSKEY_SUCCESS_REDIRECTING"           => "تمت المصادقة بنجاح! جارٍ التحويل...",

    // --- Timeouts ---
    "PASSKEY_TIMEOUT_CROSS_DEVICE"          => "انتهت مهلة التسجيل. للتسجيل بين جهازين: 1) حاول مرة أخرى، 2) تأكد من اتصال الجهازين بالإنترنت، 3) ضع في اعتبارك التسجيل مباشرة على هاتفك.",
    "PASSKEY_TIMEOUT_SIMPLE"                => "انتهت مهلة التسجيل. يرجى المحاولة مرة أخرى.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"     => "انتهت مهلة المصادقة بين جهازين. استكشاف الأخطاء: 1) يجب أن يكون كلا الجهازين متصلين بالإنترنت، 2) جرّب مسح رمز QR بسرعة أكبر، 3) جرّب المصادقة على نفس الجهاز، 4) بعض الشبكات تحجب المصادقة بين الأجهزة.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"           => "انتهت مهلة المصادقة. يرجى المحاولة مرة أخرى.",
    "PASSKEY_NO_CREDENTIAL"                 => "لم يتم تلقي بيانات اعتماد. جارٍ إعادة المحاولة...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"     => "فشلت المصادقة - لم يتم إرجاع بيانات اعتماد.",
    "PASSKEY_ATTEMPT_RETRY"                 => "فشل. جارٍ إعادة المحاولة... (%d محاولات متبقية)",

    // --- Additional errors ---
    "PASSKEY_CROSS_DEVICE_FAILED"           => "فشل التسجيل بين جهازين. جرّب: 1) تأكد من اتصال الجهازين بالإنترنت، 2) ضع في اعتبارك التسجيل مباشرة على هاتفك، 3) بعض الشبكات المؤسسية تحجب هذه الميزة.",
    "PASSKEY_REGISTRATION_CANCELLED"        => "تم إلغاء التسجيل أو الجهاز لا يدعم مفاتيح المرور.",
    "PASSKEY_NOT_SUPPORTED"                 => "مفاتيح المرور غير مدعومة على هذا الجهاز/المتصفح.",
    "PASSKEY_SECURITY_ERROR"                => "خطأ أمني - عادة يدل على عدم تطابق النطاق/الأصل.",
    "PASSKEY_ALREADY_EXISTS"                => "يوجد مفتاح مرور بالفعل لهذا الحساب على هذا الجهاز. جرّب استخدام جهاز مختلف أو حذف المفاتيح الموجودة أولاً.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"      => "فشلت المصادقة بين جهازين. جرّب: 1) تأكد من اتصال الجهازين بالإنترنت، 2) استخدم نفس شبكة Wi-Fi إذا أمكن، 3) جرّب المصادقة مباشرة على هاتفك، 4) بعض الشبكات المؤسسية تحجب هذه الميزة.",
    "PASSKEY_AUTH_CANCELLED"                => "تم إلغاء المصادقة أو لم يتم اختيار مفتاح مرور.",
    "PASSKEY_NETWORK_ERROR"                 => "خطأ في الشبكة. للمصادقة بين جهازين، يجب أن يكون الجهازان متصلين بالإنترنت وربما على نفس الشبكة.",
    "PASSKEY_CREDENTIAL_NOT_FOUND"          => "فشلت المصادقة - بيانات الاعتماد غير معروفة.",

    // --- Cross‑device guidance ---
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE"   => "نصائح المصادقة بين جهازين:",
    "PASSKEY_GUIDANCE_INTERNET"             => "تأكد من أن الكمبيوتر والهاتف متصلان بالإنترنت",
    "PASSKEY_GUIDANCE_WIFI"                 => "التواجد على نفس شبكة Wi-Fi قد يساعد (لكن ليس ضرورياً دائماً)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"        => "عند الطلب، اختر \"استخدام هاتف أو تابلت\"",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"         => "امسح رمز QR بسرعة عندما يظهر",
    "PASSKEY_GUIDANCE_TRY_DIRECT"           => "إذا فشل، جرّب تحديث الصفحة واستخدام متصفح هاتفك مباشرة",

    // --- Troubleshooting modal ---
    "PASSKEY_SHOW_TROUBLESHOOTING"          => "إظهار نصائح استكشاف الأخطاء",
    "PASSKEY_HIDE_TROUBLESHOOTING"          => "إخفاء نصائح استكشاف الأخطاء",
    "PASSKEY_DIAGNOSTICS_RUNNING"           => "جارٍ تشغيل التشخيص...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"          => "اكتمل التشخيص. تحقق من وحدة التحكم للتفاصيل.",
    "PASSKEY_ISSUES_DETECTED"               => "المشكلات التي تم اكتشافها:",
    "PASSKEY_ENVIRONMENT_SUITABLE"          => "يبدو أن البيئة مناسبة لمفاتيح المرور.",
    "PASSKEY_DIAGNOSTICS_FAILED"            => "فشل التشخيص:",

    // --- Modal titles / labels ---
    "PASSKEY_ADD_NOTE_NEW"                  => "أضف ملاحظة إلى مفتاح المرور الجديد",

    // --- Technical errors ---
    "PASSKEY_BASE64_ERROR"                  => "خطأ في فك ترميز Base64:",

    // --- Server‑side (passkey_parser.php) ---
    "PASSKEY_INVALID_JSON"                  => "بيانات JSON غير صالحة تم استلامها:",
    "PASSKEY_LOGIN_REQUIRED"                => "يجب تسجيل الدخول للقيام بهذا الإجراء.",
    "PASSKEY_ACTION_MISSING"                => "معلمة 'action' المطلوبة مفقودة من الطلب.",
    "PASSKEY_STORAGE_FAILED"                => "فشل حفظ مفتاح المرور. العملية لم تنجح.",
    "PASSKEY_LOGIN_FAILED"                  => "فشل تسجيل الدخول بمفتاح المرور. لم يمكن التحقق من المصادقة.",
    "PASSKEY_INVALID_METHOD"                => "طريقة طلب غير صالحة:",

    // --- CSRF ---
    "CSRF_ERROR"                            => "فشل فحص رمز CSRF. يرجى العودة ومحاولة إرسال النموذج مرة أخرى.",

    // --- Network analysis ---
    "PASSKEY_NETWORK_PRIVATE"               => "مشكلة محتملة: يبدو أنك على شبكة خاصة، مما قد يعيق الاتصال بين جهازين.",
    "PASSKEY_NETWORK_PROXY"                 => "مشكلة محتملة: تم اكتشاف وكيل أو VPN. قد يعيق الاتصال بين جهازين.",
    "PASSKEY_NETWORK_MOBILE"                => "ملاحظة: يبدو أنك على شبكة محمول. تأكد من اتصال ثابت للعمليات بين جهازين.",
    "PASSKEY_NETWORK_CORPORATE"             => "مشكلة محتملة: قد يكون هناك جدار ناري مؤسسي قد يؤثر على المصادقة بين جهازين.",

    // --- Recommendations (getCrossDeviceRecommendations) ---
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE"   => "توصية: يبدو أنك تستخدم جهاز سطح مكتب. استعد لاستخدام هاتفك لمسح رمز QR.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK"   => "توصية: للحصول على أفضل نتيجة، تأكد من أن الكمبيوتر والجهاز المحمول على نفس شبكة Wi-Fi.",
    "PASSKEY_RECOMMENDATION_QR_QUICK"       => "توصية: كن مستعداً لمسح رمز QR بسرعة، قد تنفد المهلة.",
    "PASSKEY_RECOMMENDATION_INTERNET"       => "توصية: تأكد من اتصال الكمبيوتر والجهاز المحمول بالإنترنت بشكل مستقر.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW"  => "توصية: في Unity WebView، تأكد من أن الصفحة لديها وقت كافٍ للتحميل ومعالجة طلب مفتاح المرور.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT"  => "توصية: قد تكون المهلات أطول في Unity. يرجى التحلي بالصبر.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL"   => "توصية: بما أنك على الجوال، يمكنك تسجيل مفتاح المرور مباشرة على هذا الجهاز.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "توصية: على أندرويد، يمكنك إدارة مفاتيح المرور في مدير كلمات مرور Google.",

    // --- Validation (validateCrossDeviceEnvironment) ---
    "PASSKEY_VALIDATION_RP_IP"                     => "تحذير إعداد: تم ضبط معرف الطرف المعتمد على عنوان IP.",
    "PASSKEY_VALIDATION_RP_DOMAIN"                 => "توصية: اضبط معرف الطرف المعتمد على اسم نطاقك (مثل yourwebsite.com) لأمان وتوافق أفضل.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"            => "خطأ إعداد: يتطلب مفاتيح المرور HTTPS على الخادم الحي. يبدو أن موقعك يعمل بـ HTTP.",
    "PASSKEY_VALIDATION_NETWORK"                   => "تحذير شبكة",
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK"     => "توصية: إذا واجهت مشكلات، جرّب شبكة مختلفة (مثلاً التحويل من Wi-Fi مؤسسي إلى نقطة اتصال محمولة).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET"     => "توصية: لإجراءات بين جهازين، تأكد من اتصال كلا الجهازين بالإنترنت بشكل موثوق.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"           => "توصية: إذا فشلت الإجراءات بين جهازين، جرّب زيارة هذه الصفحة مباشرة على جهازك المحمول لإكمال الإجراء.",

    // --- Info section ---
    "PASSKEY_INFO_TITLE"           => "حول مفاتيح المرور",
    "PASSKEY_INFO_DESC"            => "مفاتيح المرور هي وسيلة آمنة وخالية من كلمات المرور لتسجيل الدخول باستخدام ميزات الأمان المدمجة في جهازك مثل البصمة، التعرف على الوجه، أو رمز PIN. إنها أكثر أماناً من كلمات المرور وتوفّر تسجيل دخول أسرع، وتعمل عبر الأجهزة عند مزامنتها مع مديري كلمات المرور، ومقاومة لعمليات الاصطياد. تعمل مفاتيح المرور على الهواتف الذكية الحديثة والأجهزة اللوحية وأجهزة الكمبيوتر، ويمكن تخزينها في مديري كلمات المرور مثل 1Password وBitwarden وiCloud Keychain أو مدير كلمات مرور Google.",
    "PASSKEY_BACK_TO_LOGIN"        => "الرجوع إلى تسجيل الدخول",

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
	"JOIN_LOWER"		=> "حروف صغيرة",
	"JOIN_SYMBOL"		=> "رموز",
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

// Two Factor Authentication
$lang = array_merge($lang, array(

    // --- General ---
    "2FA"                          => "المصادقة الثنائية",
    "2FA_CONF"                     => "هل أنت متأكد من أنك تريد تعطيل المصادقة الثنائية؟ لن يكون حسابك محمياً بعد الآن.",
    "2FA_SCAN"                     => "امسح رمز QR هذا باستخدام تطبيق المصادقة أو أدخل المفتاح",
    "2FA_THEN"                     => "ثم أدخل أحد مفاتيح المرور لمرة واحدة هنا",
    "2FA_FAIL"                     => "حدثت مشكلة في التحقق من المصادقة الثنائية. يرجى التحقق من الإنترنت أو الاتصال بالدعم.",
    "2FA_CODE"                     => "رمز المصادقة الثنائية",
    "2FA_EXP"                      => "بصمة واحدة منتهية",
    "2FA_EXPD"                     => "منتهي",
    "2FA_EXPS"                     => "ينتهي",
    "2FA_ACTIVE"                   => "جلسات نشطة",
    "2FA_NOT_FN"                   => "لا توجد بصمات",
    "2FA_FP"                       => "بصمات",
    "2FA_NP"                       => "فشل تسجيل الدخول. لم يكن رمز المصادقة الثنائية موجوداً. يرجى المحاولة مرة أخرى.",
    "2FA_INV"                      => "فشل تسجيل الدخول. رمز المصادقة الثنائية غير صالح. يرجى المحاولة مرة أخرى.",
    "2FA_FATAL"                    => "خطأ فادح. يرجى الاتصال بمسؤول النظام. لا يمكن إنشاء رمز المصادقة الثنائية حالياً.",

    // --- Section headers ---
    "2FA_SECTION_TITLE"            => "المصادقة الثنائية (TOTP)",
    "2FA_SK_ALT"                   => "إذا لم تتمكن من مسح رمز QR، أدخل مفتاح السر هذا يدوياً في تطبيق المصادقة.",

    // --- Status info ---
    "2FA_IS_ENABLED"               => "المصادقة الثنائية تحمي حسابك.",
    "2FA_NOT_ENABLED_INFO"         => "المصادقة الثنائية غير مفعلة حالياً.",
    "2FA_NOT_ENABLED_EXPLAIN"      => "المصادقة الثنائية (TOTP) تضيف طبقة أمان إضافية لحسابك من خلال طلب رمز من تطبيق المصادقة على هاتفك بالإضافة إلى كلمة المرور.",

    // --- Setup process ---
    "2FA_SETUP_TITLE"              => "إعداد المصادقة الثنائية",
    "2FA_SECRET_KEY_LABEL"         => "مفتاح السر:",
    "2FA_SETUP_VERIFY_CODE_LABEL"  => "أدخل رمز التحقق من التطبيق",

    // --- Backup codes ---
    "2FA_SUCCESS_ENABLED_TITLE"    => "تم تفعيل المصادقة الثنائية! احفظ رموز النسخ الاحتياطي",
    "2FA_SUCCESS_ENABLED_INFO"     => "فيما يلي رموز النسخ الاحتياطي الخاصة بك. احفظها بأمان - كل رمز يمكن استخدامه مرة واحدة فقط.",
    "2FA_BACKUP_CODES_WARNING"     => "تعامل مع هذه الرموز مثل كلمات المرور. احفظها بأمان.",
    "2FA_SUCCESS_BACKUP_REGENERATED"=> "تم إنشاء رموز نسخ احتياطي جديدة. احفظها بأمان.",
    "2FA_BACKUP_CODE_LABEL"        => "رمز نسخ احتياطي",
    "2FA_REGEN_CODES_BTN"          => "إعادة إنشاء رموز النسخ الاحتياطي",
    "2FA_INVALIDATE_WARNING"       => "سيؤدي هذا إلى إلغاء صلاحية جميع رموز النسخ الاحتياطي الحالية. هل أنت متأكد؟",

    // --- Authentication screen ---
    "2FA_CODE_LABEL"               => "رمز المصادقة",
    "2FA_VERIFY_BTN"               => "تحقق وسجّل الدخول",
    "2FA_VERIFY_TITLE"             => "المطلوب المصادقة الثنائية",
    "2FA_VERIFY_INFO"              => "أدخل الرمز المكوّن من 6 أرقام من تطبيق المصادقة.",

    // --- Action buttons ---
    "2FA_ENABLE_BTN"               => "تفعيل المصادقة الثنائية",
    "2FA_DISABLE_BTN"              => "تعطيل المصادقة الثنائية",
    "2FA_VERIFY_ACTIVATE_BTN"      => "تحقق وفعّل",
    "2FA_CANCEL_SETUP_BTN"         => "إلغاء الإعداد",
    "2FA_DONE_BTN"                 => "تم",

    // --- Success messages ---
    "REDIR_2FA_DIS"                => "تم تعطيل المصادقة الثنائية.",
    "2FA_SUCCESS_BACKUP_ACK"       => "تم تأكيد رموز النسخ الاحتياطي.",
    "2FA_SUCCESS_SETUP_CANCELLED"  => "تم إلغاء الإعداد.",

    // --- Error messages ---
    "2FA_ERR_INVALID_BACKUP"       => "رمز النسخ الاحتياطي غير صالح. حاول مرة أخرى.",
    "2FA_ERR_DISABLE_FAILED"       => "فشل تعطيل المصادقة الثنائية.",
    "2FA_ERR_NO_SECRET"            => "تعذر الحصول على مفتاح السر. يرجى المحاولة مرة أخرى.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"=> "تم التحقق من رمز النسخ الاحتياطي لكن فشل إبطاله. يرجى الاتصال بالدعم.",
    "2FA_ERR_NO_CODE_PROVIDED"     => "لم يتم تقديم رمز المصادقة.",

    // --- Rate‑limit messages ---
    "RATE_LIMIT_LOGIN"             => "عدد محاولات تسجيل الدخول الفاشلة كبير جداً. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_TOTP"              => "عدد رموز المصادقة غير الصحيحة كبير جداً. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_PASSKEY"           => "عدد محاولات مصادقة مفتاح المرور كبير جداً. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_PASSKEY_STORE"     => "عدد محاولات تسجيل مفتاح المرور كبير جداً. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_PASSWORD_RESET"    => "عدد طلبات إعادة ضبط كلمة المرور كبير جداً. يرجى الانتظار قبل طلب إعادة أخرى.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT"=> "عدد محاولات إعادة ضبط كلمة المرور كبير جداً. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_REGISTRATION"      => "عدد محاولات التسجيل كبير جداً. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_EMAIL_VERIFICATION"=> "عدد طلبات التحقق من البريد الإلكتروني كبير جداً. يرجى الانتظار قبل طلب تحقق آخر.",
    "RATE_LIMIT_EMAIL_CHANGE"      => "عدد طلبات تغيير البريد الإلكتروني كبير جداً. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_PASSWORD_CHANGE"   => "عدد محاولات تغيير كلمة المرور كبير جداً. يرجى الانتظار قبل المحاولة مرة أخرى.",
    "RATE_LIMIT_GENERIC"           => "عدد المحاولات كبير جداً. يرجى الانتظار قبل المحاولة مرة أخرى.",

));


$lang = array_merge($lang, array(
	"REDIR_2FA" => "عذرًا، لم يتم تمكين التحقق المزدوج في الوقت الحالي.",
	"REDIR_2FA_EN" => "تم تمكين المصادقة الثنائية.",
	"REDIR_2FA_DIS" => "تم تعطيل المصادقة الثنائية.",
	"REDIR_2FA_VER" => "تم التحقق وتمكين المصادقة الثنائية.",
	"REDIR_SOMETHING_WRONG" => "حدث خطأ ما. يرجى المحاولة مرة أخرى.",
	"REDIR_MSG_NOEX" => "هذا الموضوع لا ينتمي إليك أو لا يوجد.",
	"REDIR_UN_ONCE" => "تم تغيير اسم المستخدم مرة واحدة بالفعل.",
	"REDIR_EM_SUCC" => "تم تحديث البريد الإلكتروني بنجاح.",

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
	"DAT_INFO" => "عرض _START_ إلى _END_ من مجموع _TOTAL_ مُدخل",
	"DAT_ZERO" => "عرض 0 إلى 0 من 0 مُدخل",
	"DAT_FILTERED" => "(تمت تصفيةها من مجموع _MAX_ مُدخل)",
	"DAT_MENU_LENG" => "عرض _MENU_ مُدخل",

	"DAT_LOADING"       => "...جاري التحميل",
	"DAT_PROCESS"       => "تتم المعالجة",
	"DAT_NO_REC"        => "لا توجد سجلات مطابقة",
	"DAT_ASC"           => "تفعيل لفرز العمود تصاعدي",
	"DAT_DESC"          => "تفعيل لفرز العمود تنازلي",
));
//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
