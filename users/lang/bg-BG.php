<?php
/*
Do not put any content above the opening PHP tag
Translated by: LYNX Data Systems ltd.
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
$lang = array_merge($lang, array(
	"THIS_LANGUAGE"	=> "Bulgarian",
	"THIS_CODE"			=> "bg-BG",
	"MISSING_TEXT"	=> "Missing Text",
));

//Database Menus
$lang = array_merge($lang, array(
	"MENU_HOME"			=> "Начало",
	"MENU_HELP"			=> "Помощ",
	"MENU_ACCOUNT"	=> "Профил",
	"MENU_DASH"			=> "Админ панел",
	"MENU_USER_MGR"	=> "Управление на потребители",
	"MENU_PAGE_MGR"	=> "Управление на страници",
	"MENU_PERM_MGR"	=> "управление на права",
	"MENU_MSGS_MGR"	=> "Управление на съобщения",
	"MENU_LOGS_MGR"	=> "Системен лог",
	"MENU_LOGOUT"		=> "Изход",
));

// Signup
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"					=> "Регистрация",
	"SIGNUP_BUTTONTEXT"		=> "Регистрирай ме",
	"SIGNUP_AUDITTEXT"		=> "Регистриран",
));

// Signin
$lang = array_merge($lang, array(
	"SIGNIN_FAIL"				=> "** НЕУСПЕШЕН ВХОД **",
	"SIGNIN_PLEASE_CHK" => "Моля проверерете вашите потребител и парола и опитайте отново",
	"SIGNIN_UORE"				=> "Потребител или И-мейл адрес",
	"SIGNIN_PASS"				=> "Парола",
	"SIGNIN_TITLE"			=> "Вход в системата",
	"SIGNIN_TEXT"				=> "Вход",
	"SIGNOUT_TEXT"			=> "Изход",
	"SIGNIN_BUTTONTEXT"	=> "Вход",
	"SIGNIN_REMEMBER"		=> "Запомни ме",
	"SIGNIN_AUDITTEXT"	=> "Влязъл",
	"SIGNIN_FORGOTPASS"	=> "Забравена парола",
	"SIGNOUT_AUDITTEXT"	=> "Излязъл",
));

// Account Page
$lang = array_merge($lang, array(
	"ACCT_EDIT"					=> "Промяна на информация",
	"ACCT_2FA"					=> "Управление на 2 Факторна Аутентификация",
	"ACCT_SESS"					=> "Управление на сесии",
	"ACCT_HOME"					=> "Account Home",
	"ACCT_SINCE"				=> "Член от",
	"ACCT_LOGINS"				=> "Брой влизания",
	"ACCT_SESSIONS"			=> "Брой активни сесии",
	"ACCT_MNG_SES"			=> "Натиснете бутон упраление на сесии в лявата част за повече информация.",
));

//General Terms
$lang = array_merge($lang, array(
	"GEN_ENABLED"			=> "Активно",
	"GEN_DISABLED"		=> "Неактивно",
	"GEN_ENABLE"			=> "Активирай",
	"GEN_DISABLE"			=> "Деактивирай",
	"GEN_NO"					=> "Не",
	"GEN_YES"					=> "Да",
	"GEN_MIN"					=> "мин",
	"GEN_MAX"					=> "макс",
	"GEN_CHAR"				=> "символ", //as in characters
	"GEN_SUBMIT"			=> "Изпрати",
	"GEN_MANAGE"			=> "Управление на",
	"GEN_VERIFY"			=> "Потвърди",
	"GEN_SESSION"			=> "Сесия",
	"GEN_SESSIONS"		=> "Сесии",
	"GEN_EMAIL"				=> "И-мейл адрес",
	"GEN_FNAME"				=> "Име",
	"GEN_LNAME"				=> "Фамилия",
	"GEN_UNAME"				=> "Потребител",
	"GEN_PASS"				=> "Парола",
	"GEN_MSG"					=> "Съобщение",
	"GEN_TODAY"				=> "Днес",
	"GEN_CLOSE"				=> "Затвори",
	"GEN_CANCEL"			=> "Откажи",
	"GEN_CHECK"				=> "[ маркирай/демаркирай всички ]",
	"GEN_WITH"				=> "with",
	"GEN_UPDATED"			=> "Актуализиран",
	"GEN_UPDATE"			=> "Актуализирай",
	"GEN_BY"					=> "от",
	"GEN_FUNCTIONS"		=> "Функции",
	"GEN_NUMBER"			=> "номер",
	"GEN_NUMBERS"			=> "номера",
	"GEN_INFO"				=> "Информация",
	"GEN_REC"					=> "Записано",
	"GEN_DEL"					=> "Изтрий",
	"GEN_NOT_AVAIL"		=> "Не е налично",
	"GEN_AVAIL"				=> "Налично",
	"GEN_BACK"				=> "Назад",
	"GEN_RESET"				=> "Промяна",
	"GEN_REQ"					=> "задължително",
	"GEN_AND"					=> "и",
	"GEN_SAME"				=> "трябва да бъдат еднакви",
));

//validation class
$lang = array_merge($lang, array(
	"VAL_SAME"				=> "трябва да бъдат еднакви",
	"VAL_EXISTS"			=> "вече съществува. Моля изберете друго",
	"VAL_DB"					=> "Грешка в базата данни",
	"VAL_NUM"					=> "трябва да бъде число",
	"VAL_INT"					=> "трябва да бъде цяло число",
	"VAL_EMAIL"				=> "трябва да бъде валиден И-мейл адрес",
	"VAL_NO_EMAIL"		=> "не трябва да бъде И-мейл адрес",
	"VAL_SERVER"			=> "трябва да принадлежи на валиден сървър",
	"VAL_LESS"				=> "трябва да бъде по-малко от",
	"VAL_GREAT"				=> "трябва да бъде по-голямо от",
	"VAL_LESS_EQ"			=> "трябва да бъде по-малко или равно на",
	"VAL_GREAT_EQ"		=> "трябва да бъде по-голямо или равно на",
	"VAL_NOT_EQ"			=> "не трябва да бъде равно на",
	"VAL_EQ"					=> "трябва да бъде раввно на",
	"VAL_TZ"					=> "трябва да бъде валидно име на часова зона",
	"VAL_MUST"				=> "трябва да бъде",
	"VAL_MUST_LIST"		=> "трябва да бъде едно от следните",
	"VAL_TIME"				=> "трябва да бъде валидно време",
	"VAL_SEL"					=> "невалидна селекция",
	"VAL_NA_PHONE"		=> "Трябва да бъде валиден Български телефонен номер",
));

//Time
$lang = array_merge($lang, array(
	"T_YEARS"			=> "Години",
	"T_YEAR"			=> "Година",
	"T_MONTHS"		=> "Месеци",
	"T_MONTH"			=> "Месец",
	"T_WEEKS"			=> "Седмици",
	"T_WEEK"			=> "Седмица",
	"T_DAYS"			=> "Дни",
	"T_DAY"				=> "Ден",
	"T_HOURS"			=> "Часа",
	"T_HOUR"			=> "Час",
	"T_MINUTES"		=> "Минути",
	"T_MINUTE"		=> "Минута",
	"T_SECONDS"		=> "Секунди",
	"T_SECOND"		=> "Секунда",
));


//Passwords
$lang = array_merge($lang, array(
	"PW_NEW"		=> "Нова парола",
	"PW_OLD"		=> "Стара парола",
	"PW_CONF"		=> "Потвърди парола",
	"PW_RESET"	=> "Забравена парола",
	"PW_UPD"		=> "Паролата е променена",
	"PW_SHOULD"	=> "Паролата трябва...",
	"PW_SHOW"		=> "Покажи паролата",
	"PW_SHOWS"	=> "Покажи паролите",
));


//Join
$lang = array_merge($lang, array(
	"JOIN_SUC"			=> "Добре дошли в ",
	"JOIN_THANKS"		=> "Благодарим ви, че се регистрирахте!",
	"JOIN_HAVE"			=> "Трябва да има поне ",
	"JOIN_LOWER"		=>	" малка буква",
	"JOIN_SYMBOL"		=> " символ",
	"JOIN_CAP"			=> " главна буква",
	"JOIN_TWICE"		=> "бъде написано правилно два пъти",
	"JOIN_CLOSED"		=> "Регистрацията не е позволена. Свържете се с администратор..",
	"JOIN_TC"				=> "Политика за поверителност и споразумения при регистрация",
	"JOIN_ACCEPTTC" => "Приемам политиката за поверителност и споразуменията при регистрация",
	"JOIN_CHANGED"	=> "Нашата политика е променена",
	"JOIN_ACCEPT" 	=> "Приемам политиката за поверителност и споразуменията",
	"JOIN_SCORE" => "Резултат:",
	"JOIN_INVALID_PW" => "Невалидна парола",

));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "Успешно прекаратена ",
));

//Messages
$lang = array_merge($lang, array(
	"MSG_SENT"			=> "Вашето съобщение беше изпратено!",
	"MSG_MASS"			=> "Вашето масово съобщение беше изпратено!",
	"MSG_NEW"				=> "Ново съобщение",
	"MSG_NEW_MASS"	=> "Ново масово съобщение",
	"MSG_CONV"			=> "Кореспондеция",
	"MSG_NO_CONV"		=> "Няма кореспонденция",
	"MSG_NO_ARC"		=> "Няма кореспонденция",
	"MSG_QUEST"			=> "Изпрати известие по И-мейл, ако е активно?",
	"MSG_ARC"				=> "Архивирани съобщения",
	"MSG_VIEW_ARC"	=> "Преглед на архивирани",
	"MSG_SETTINGS"  => "Настройки",
	"MSG_READ"			=> "Прочетено",
	"MSG_BODY"			=> "Текст",
	"MSG_SUB"				=> "Тема",
	"MSG_DEL"				=> "Доставено",
	"MSG_REPLY"			=> "Отговор",
	"MSG_QUICK"			=> "Бърз отговор",
	"MSG_SELECT"		=> "Избери потребител",
	"MSG_UNKN"			=> "Непознат получател",
	"MSG_NOTIF"			=> "Съобщение чрез известяване по И-мейл",
	"MSG_BLANK"			=> "Съобщението не може да бъде празно",
	"MSG_MODAL"			=> "Натиснете тук или Alt + R за да изполвате полето или натиснете Shift + R за да разширите панела за отговор!",
	"MSG_ARCHIVE_SUCCESSFUL"        => "Успешно архивирахте %m1% съобщения",
	"MSG_UNARCHIVE_SUCCESSFUL"      => "Успешно разархивирахте %m1% съобщения",
	"MSG_DELETE_SUCCESSFUL"         => "Успешно изтрихте %m1% съобщения",
	"USER_MESSAGE_EXEMPT"         			=> "User is %m1% exempted from messages.",
	"MSG_MK_READ"		=> "Прочетено",
	"MSG_MK_UNREAD"	=> "Непрочетено",
	"MSG_ARC_THR"		=> "Архивирай маркираните съобщения",
	"MSG_UN_THR"		=> "Разархивирай маркираните съобщения",
	"MSG_DEL_THR"		=> "Изтрий маркираните съобщения",
	"MSG_SEND"			=> "Изпрати съобщение",
));

//2 Factor Authentication
$lang = array_merge($lang, array(
	"2FA"				=> "2 Степенна Аутентификация",
	"2FA_CONF"	=> "Сигурни ли сте, че искате да деактивирате 2ФА? Профила ви няма да бъде защитен.",
	"2FA_SCAN"	=> "Сканирайте този QR код с приложението authenticator или въведете кода.",
	"2FA_THEN"	=> "После въведете един от еднократните си кодове тук",
	"2FA_FAIL"	=> "Неуспешна аутентификация с 2ФА. Моля проверете вашата интернет връзка или се свържете с администратор.",
	"2FA_CODE"	=> "2ФА код",
	"2FA_EXP"		=> "Изтекъл 1 пръстов отпечатък",
	"2FA_EXPD"	=> "Изтекъл",
	"2FA_EXPS"	=> "Изтича",
	"2FA_ACTIVE" => "Активни сесии",
	"2FA_NOT_FN" => "Няма намерени пръстови отпечатъци",
	"2FA_FP"		=> "Пръстови отпечатъци",
	"2FA_NP"		=> "Неуспешен вход  Няма наличен код за 2ФА. Моля опитайте отново.",
	"2FA_INV"		=> "Неуспешен вход  Невалиден код за 2ФА. Моля опитайте отново.",
	"2FA_FATAL"	=> "Грешка  Моля свържете се с администратор.",
));

//Redirect Messages - These get a plus between each word
$lang = array_merge($lang, array(
	"REDIR_2FA"						=> "Съжаляваме.Дву+Факторна+Аутентификация+не+е+активна",
	"REDIR_2FA_EN"				=> "2+Факторна+Аутентификация+Активна",
	"REDIR_2FA_DIS"				=> "2+Факторна+Аутентификация+Неактивна",
	"REDIR_2FA_VER"				=> "2+Факторна+Аутентификация+Проверена+и+Активна",
	"REDIR_SOM_TING_WONG" => "Грешка.+Моля+опитайте+отново.",
	"REDIR_MSG_NOEX"			=> "Това+съобщение+не+ви+принадлежи+или+не+съществува.",
	"REDIR_UN_ONCE"				=> "Потребителското име+е+било+променяно+вече.",
	"REDIR_EM_SUCC"				=> "И-мейла+е+Актуализиран+Успешно",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "Вход с:",
	"EML_FEATURE_DISABLED" => "Тази функция е деактивирана",
	"EML_PASSWORDLESS_SENT" => "Моля, проверете имейла си за връзка за вход.",
	"EML_PASSWORDLESS_SUBJECT" => "Моля, потвърдете вашия имейл, за да влезете.",
	"EML_PASSWORDLESS_BODY" => "Моля, потвърдете вашия имейл, като кликнете върху връзката по-долу. Ще бъдете вписани автоматично.",

	"EML_CONF"			=> "Потвърди И-мейл адрес",
	"EML_VER"				=> "Потвърдете вашият И-мейл адрес",
	"EML_CHK"				=> "Изпратен е И-мейл за активация. Моля проверете вашата електронна поща. Също проверете и папката СПАМ, линка за активация е валиден само ",
	"EML_MAT"				=> "И-мейл адресите не съвпадат.",
	"EML_HELLO"			=> "Здравейте от ",
	"EML_HI" => "Здравейте",
	"EML_AD_HAS" => "Администраторът е нулирал вашата парола.",
	"EML_AC_HAS" => "Администраторът е създал вашия акаунт.",
	"EML_REQ" => "Ще трябва да зададете вашата парола, използвайки горепосочения линк.",
	"EML_EXP" => "Моля, обърнете внимание, линковете за парола изтичат след",
	"EML_VER_EXP" => "Моля, обърнете внимание, линковете за верификация изтичат след",
	"EML_CLICK" => "Натиснете тук, за да влезете в системата.",
	"EML_REC" => "Препоръчва се да промените паролата си след влизане в системата.",
	"EML_MSG" => "Имате ново съобщение от",
	"EML_REPLY" => "Натиснете тук, за да отговорите или да видите темата.",
	"EML_WHY" => "Получавате този имейл, защото е направена заявка за нулиране на вашата парола. Ако това не сте вие, можете да пренебрегнете този имейл.",
	"EML_HOW" => "Ако сте вие, натиснете линка по-долу, за да продължите с процеса за нулиране на паролата.",
	"EML_EML" => "Беше направена заявка за промяна на вашия имейл от вашия потребителски акаунт.",
	"EML_VER_EML" => "Благодарим ви за регистрацията. След като потвърдите вашия имейл адрес, ще можете да влезете в системата! Моля, натиснете линка по-долу, за да потвърдите вашия имейл адрес.",

));

//Verification
$lang = array_merge($lang, array(
	"VER_SUC"			=> "Вашият И-мейл адрес e потвърден!",
	"VER_FAIL"		=> "Не успяхме да потвърдим вашият акаунт. Моля опитайте отново.",
	"VER_RESEND"	=> "Изпрати отново активационен И-мейл",
	"VER_AGAIN"		=> "Въведете И-мейл адрес и опитайте отново",
	"VER_PAGE"		=> "<li>Проверете вашата електронна поща и натиснете на линка за активация</li><li>Готово</li>",
	"VER_RES_SUC" => " Линк за активация е изпратен на вашата електронна поща.  Натиснете линка за да завършите активацията. Също проверете и папката СПАМ, ако не откривате нищо в основната папка.  Линковете за активация са валидни само ",
	"VER_OOPS"		=> "Грешка, вероятно е изтекъл срокът за активация. Натиснете линка долу и опитайте отново",
	"VER_RESET"		=> "Вашата парола е променена успешно!",
	"VER_INS"			=> "<li>Въведете И-мейл адрес за да продължите със смяната на парола.</li> <li>Проверете вашата електронна поща и натиснете върху получения линк.</li>
												<li>Следвайте инструкцийте.</li>",
	"VER_SENT"		=> " Линк за промяна на паролата е изпратен на вашата електронна поща. 
			    							 Натиснете линка в съощението за промяна на паролата. Също проверете и папката СПАМ, ако не откривате нищо в основната папка..  Линковете за активация са валидни само ",
	"VER_PLEASE"	=> "Моля променете вашата парола",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"				=> "ПИН за промяна",
	"SET_WHY"				=> "Защо не мога да променя това?",
	"SET_PW_MATCH"	=> "Новите пароли трябва да съвпадат",

	"SET_PIN_NEXT"	=> "Може да променяте вашият ПИН при следващото влизане",
	"SET_UPDATE"		=> "Актуализирайте вашите потребителски настройки",
	"SET_NOCHANGE"	=> "Промяната на потребителски имена е забранена от администратор.",
	"SET_ONECHANGE"	=> "Промяната на потребителски имена е разрешена само веднъж.",

	"SET_GRAVITAR"	=> "Искате да промените вашата профилна снимка?  <br> Посетете <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> и се регистрирайте със същия И-мейл адрес, както в този сайт. Става бързо и лесно!",

	"SET_NOTE1"			=> " Забележка  има заявка на изчакване за актуализация на вашия И-мейл адрес ",

	"SET_NOTE2"			=> ".  Моля използвайте верификационния И-мейл за тази заявка. 
		 Ако ви е необходим нов верификационен И-мейл, Моля въведете И-мейл адрес и изпратете заявката отново. ",

	"SET_PW_REQ" 		=> "Необходимо при смяна на парола, И-мейл, или смяна на ПИН",
	"SET_PW_REQI" 	=> "Необходимо при смяна на парола",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "Неуспешно прекратяване на активна сесия, Грешка: ",
	"ERR_EMAIL"				=> "И-мейл не беше изпратен поради грешка. Моля свържете се с администратор.",
	"ERR_EM_DB"				=> "Този И-мейл адрес не съществува в базата данни",
	"ERR_TC"					=> "Моля прочетете и приемете политиката за поверителност и споразуменията",
	"ERR_CAP"					=> "Неуспешен Captcha тест, Робот!",
	"ERR_PW_SAME"			=> "Старата парола не може да бъде същата като новата",
	"ERR_PW_FAIL"			=> "Неуспешна верификация на парола. Неуспешна актуализация. Моля опитайте отново.",
	"ERR_GOOG"				=> "Забележка:  Ако първоначално сте се регистрирали с Google/Facebook акаунт, ще трябва да използвате линка за забравена парола за да промените вашата парола.",
	"ERR_EM_VER"			=> "Верификацията по И-мейл не е активна. Моля свържете се с администратор.",
	"ERR_EMAIL_STR"		=> "Грешка. Моля потвърдете вашия И-мейл адрес отново.",
));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "Ще се върнем скоро!",
	"MAINT_MSG"			=> "Съжаляваме за неудобството, в момента правим промени по сайта.<br> Ще се върнем скоро!",
	"MAINT_BAN"			=> "Съжаляваме. Вие сте блокирани. Ако е станала грешка, моля свържете се с администратор.",
	"MAINT_TOK"			=> "Има грешка във вашата форма. Моля опитайте отново. Ако тази грешка продължи, моля свържете се с администратор.",
	"MAINT_OPEN"		=> "PHP платформа за управление на потребители с отворен код.",
	"MAINT_PLEASE"	=> "Успешно инсталирахте UserSpice!<br>За да разгледате документацията, моля посетете"
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
	"DAT_SEARCH" => "Търсене",
	"DAT_FIRST" => "Първи",
	"DAT_LAST" => "Последен",
	"DAT_NEXT" => "Следващ",
	"DAT_PREV" => "Предишен",
	"DAT_NODATA" => "Няма налични данни в таблицата",
	"DAT_INFO" => "Показване на _START_ до _END_ от общо _TOTAL_ записа",
	"DAT_ZERO" => "Показване на 0 до 0 от 0 записа",
	"DAT_FILTERED" => "(филтрирани от общо _MAX_ записа)",
	"DAT_MENU_LENG" => "Покажи _MENU_ записи",
	"DAT_LOADING" => "Зареждане...",
	"DAT_PROCESS" => "Обработка...",
	"DAT_NO_REC" => "Не бяха намерени съответстващи записи",
	"DAT_ASC" => "Активирайте, за да сортирате колоната във възходящ ред",
	"DAT_DESC" => "Активирайте, за да сортирате колоната в низходящ ред",

));


//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
