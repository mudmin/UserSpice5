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

//TODO contact UserSpice and ask them if they want Czech language

$lang = array();
//important strings
//You defiitely want to customize these for your language
$lang = array_merge($lang,array(
"THIS_LANGUAGE"	=>"Čeština",
"THIS_CODE"			=>"cs-CZ",
"MISSING_TEXT"	=>"Chybějící Text",
));

//Database Menus
$lang = array_merge($lang,array(
"MENU_HOME"			=> "Domů",
"MENU_HELP"			=> "Pomoc",
"MENU_ACCOUNT"	=> "Účet",
"MENU_DASH"			=> "Menu admina",
"MENU_USER_MGR"	=> "Správa uživatelů",
"MENU_PAGE_MGR"	=> "Správa stránek",
"MENU_PERM_MGR"	=> "Správa povolení",
"MENU_MSGS_MGR"	=> "Správa zpráv",
"MENU_LOGS_MGR"	=> "Systémové logy",
"MENU_LOGOUT"		=> "Odhlásit se",
));

// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"					=> "Registrovat",
	"SIGNUP_BUTTONTEXT"		=> "Registujte mě",
	"SIGNUP_AUDITTEXT"		=> "Registrováno",
	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"				=> "** Přihlášení selhalo **",
	"SIGNIN_PLEASE_CHK" => "Prosím, zkontrolujte své uživatelské jméno a heslo a zkuste to znovu",
	"SIGNIN_UORE"				=> "Uživatelské jméno nebo email",
	"SIGNIN_PASS"				=> "Heslo",
	"SIGNIN_TITLE"			=> "Prosím, přihlaste se",
	"SIGNIN_TEXT"				=> "Přihlásit se",
	"SIGNOUT_TEXT"			=> "Odhlásit se",
	"SIGNIN_BUTTONTEXT"	=> "Přihlásit se",
	"SIGNIN_REMEMBER"		=> "Zapamatovat si mě",
	"SIGNIN_AUDITTEXT"	=> "Přihlášen",
	"SIGNIN_FORGOTPASS"	=>"Zapomenuté heslo",
	"SIGNOUT_AUDITTEXT"	=> "Odhlášen",
	));

// Account Page
$lang = array_merge($lang,array(
	"ACCT_EDIT"					=> "Editovat informace o účtu",
	"ACCT_2FA"					=> "Spravovat dvoufaktorovou autentizaci",
	"ACCT_SESS"					=> "Spravovat relace",
	"ACCT_HOME"					=> "Account Home",
	"ACCT_SINCE"				=> "Členem od",
	"ACCT_LOGINS"				=> "Počet přihlášení",
	"ACCT_SESSIONS"			=> "Počet aktivních relací",
	"ACCT_MNG_SES"			=> "Pro více informací klikněte na tlačítko spravovat relace v levém menu.",
	));

	//General Terms
	$lang = array_merge($lang,array(
		"GEN_ENABLED"			=> "Povoleno",
		"GEN_DISABLED"		=> "Zakázáno",
		"GEN_ENABLE"			=> "Povolit",
		"GEN_DISABLE"			=> "Zakázat",
		"GEN_NO"					=> "Ne",
		"GEN_YES"					=> "Ano",
		"GEN_MIN"					=> "minimálně",
		"GEN_MAX"					=> "maximálně",
		"GEN_CHAR"				=> "znaků", //as in characters
		"GEN_SUBMIT"			=> "Odeslat",
		"GEN_MANAGE"			=> "Spravovat",
		"GEN_VERIFY"			=> "Ověřit",
		"GEN_SESSION"			=> "Relace",
		"GEN_SESSIONS"		=> "Relace",
		"GEN_EMAIL"				=> "Email",
		"GEN_FNAME"				=> "Křestní jméno",
		"GEN_LNAME"				=> "Příjmení",
		"GEN_UNAME"				=> "Uživatelské jméno",
		"GEN_PASS"				=> "Heslo",
		"GEN_MSG"					=> "Zpráva",
		"GEN_TODAY"				=> "Dnes",
		"GEN_CLOSE"				=> "Zavřít",
		"GEN_CANCEL"			=> "Zrušit",
		"GEN_CHECK"				=> "[ check/uncheck all ]",
		"GEN_WITH"				=> "s",
		"GEN_UPDATED"			=> "Aktualizováno",
		"GEN_UPDATE"			=> "Aktualizovat",
		"GEN_BY"					=> "do",
		//"GEN_ENABLE"			=> "Enable",
		//"GEN_DISABLE"			=> "Disable",
		"GEN_FUNCTIONS"		=> "Funkce",
		"GEN_NUMBER"			=> "číslo",
		"GEN_NUMBERS"			=> "čísla",
		"GEN_INFO"				=> "Informace",
		"GEN_REC"					=> "Zaznamenáno", //TODO kontext?
		"GEN_DEL"					=> "Smazat",
		"GEN_NOT_AVAIL"		=> "Nedostupný", //TODO rod?
		"GEN_AVAIL"				=> "Dostupný",
		"GEN_BACK"				=> "Zpět",
		"GEN_RESET"				=> "Resetovat",
		"GEN_REQ"					=> "vyžadováno",
		"GEN_AND"					=> "a",
		"GEN_SAME"				=> "musí se shodovat",
		));

//validation class
	$lang = array_merge($lang,array(
		"VAL_SAME"				=> "se musí shodovat",
		"VAL_EXISTS"			=> "již existuje. Prosím, vyberte jiné",
		"VAL_DB"					=> "Database Error",
		"VAL_NUM"					=> "musí být číslo",
		"VAL_INT"					=> "musí být celé číslo",
		"VAL_EMAIL"				=> "musí být validní emailová adresa",
		"VAL_NO_EMAIL"		=> "nesmí být emailová adresa",
		"VAL_SERVER"			=> "musí patřit existujícímu serveru",
		"VAL_LESS"				=> "musí být menší než",
		"VAL_GREAT"				=> "musí být větší než",
		"VAL_LESS_EQ"			=> "musí být menší nebo rovno",
		"VAL_GREAT_EQ"		=> "musí být větší nebo rovno",
		"VAL_NOT_EQ"			=> "nesmí se rovnat",
		"VAL_EQ"					=> "musí se rovnat",
		"VAL_TZ"					=> "musí být validní časová zóna",
		"VAL_MUST"				=> "musí být",
		"VAL_MUST_LIST"		=> "musí být jedno z následujících",
		"VAL_TIME"				=> "musí být validní čas",
		"VAL_SEL"					=> "není validní možnost",
		"VAL_NA_PHONE"		=> "musí být validní české telefonní číslo",
	));

		//Time
	$lang = array_merge($lang,array(
		"T_YEARS"			=> "roků",
		"T_YEAR"			=> "rok",
		"T_MONTHS"		=> "měsíců",
		"T_MONTH"			=> "měsíc",
		"T_WEEKS"			=> "týdnů",
		"T_WEEK"			=> "týden",
		"T_DAYS"			=> "dní",
		"T_DAY"				=> "den",
		"T_HOURS"			=> "hodin",
		"T_HOUR"			=> "hodinu",
		"T_MINUTES"		=> "minut",
		"T_MINUTE"		=> "minutu",
		"T_SECONDS"		=> "sekund",
		"T_SECOND"		=> "sekundu",
		));


		//Passwords
	$lang = array_merge($lang,array(
		"PW_NEW"		=> "Nové heslo",
		"PW_OLD"		=> "Staré heslo",
		"PW_CONF"		=> "Potvrdit heslo",
		"PW_RESET"	=> "Resetovat heslo",
		"PW_UPD"		=> "Heslo aktualizováno",
		"PW_SHOULD"	=> "Heslo by mělo...",
		"PW_SHOW"		=> "Ukázat heslo",
		"PW_SHOWS"	=> "Ukázat hesla",
		));


		//Join
	$lang = array_merge($lang,array(
		"JOIN_SUC"			=> "Vítejte na webu ",
		"JOIN_THANKS"		=> "Děkujeme za registraci!",
		"JOIN_HAVE"			=> "Mít alespoň ",
		"JOIN_CAP"			=> " velké písmeno",
		"JOIN_TWICE"		=> "být dvakrát správně napsáno",
		"JOIN_CLOSED"		=> "Bohužel, registrace je nyní vypnutá. Pokud máte jakékoliv dotazy, kontaktujte prosím administrátora stránky.",
		"JOIN_TC"				=> "Podmínky použití",
		"JOIN_ACCEPTTC" => "Souhlasím s podmínkami použití",
		"JOIN_CHANGED"	=> "Naše podmínky se změnily",
		"JOIN_ACCEPT" 	=> "Souhlasit s podmínkami použití a pokračovat",
		));

		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "Úspěšně ukončeno ",
		));

		//Messages
	$lang = array_merge($lang,array(
		"MSG_SENT"			=> "Vaše zpráva byla odeslána!",
		"MSG_MASS"			=> "Vaše hromadná zpráva byla odeslána!",
		"MSG_NEW"				=> "Nová zpráva",
		"MSG_NEW_MASS"	=> "Nová hromadná zpráva",
		"MSG_CONV"			=> "Konverzace",
		"MSG_NO_CONV"		=> "Žádná konverzace",
		"MSG_NO_ARC"		=> "Žádné konverzace",
		"MSG_QUEST"			=> "Pokud je povoleno, poslat upozornění emailem?",
		"MSG_ARC"				=> "Archivovaná vlákna",
		"MSG_VIEW_ARC"	=> "Zobrazit archivovaná vlákna",
		"MSG_SETTINGS"  => "Nastavení zpráv",
		"MSG_READ"			=> "Přečteno", //TODO
		"MSG_BODY"			=> "Tělo",
		"MSG_SUB"				=> "Předmět",
		"MSG_DEL"				=> "Doručeno",
		"MSG_REPLY"			=> "Odpovědět",
		"MSG_QUICK"			=> "Rychlá odpověď",
		"MSG_SELECT"		=> "Vybrat uživatele",
		"MSG_UNKN"			=> "Neznámý příjemce",
		"MSG_NOTIF"			=> "Message Email Notifications", // TODO kontext?
		"MSG_BLANK"			=> "Zpráva nemůže být prázdná",
		"MSG_MODAL"			=> "Klikněte zde nebo stiskněte Alt + R pro zaměření tohoto pole nebo stiskněte Shift + R pro otevření odpovědního menu",
		"MSG_ARCHIVE_SUCCESSFUL"        => "Úspěšně jste zarchivovali %m1% vláken",
		"MSG_UNARCHIVE_SUCCESSFUL"      => "Úspěšně jste odarchivovali %m1% vláken",
		"MSG_DELETE_SUCCESSFUL"         => "Úspěšně jste smazali %m1% vláken",
		"USER_MESSAGE_EXEMPT"         			=> "User is %m1% exempted from messages.", // TODO?
		"MSG_MK_READ"		=> "Označit za přečtené",
		"MSG_MK_UNREAD"	=> "Označit za nepřečtené",
		"MSG_ARC_THR"		=> "Archivovat vybraná vlákna",
		"MSG_UN_THR"		=> "Odarchivovat vybraná vlákna",
		"MSG_DEL_THR"		=> "Smazat vybraná vlákna",
		"MSG_SEND"			=> "Odeslat zprávu",
		));

	//2 Factor Authentication
	$lang = array_merge($lang,array(
		"2FA"				=> "Dvoufaktorová autentizace",
		"2FA_CONF"	=> "Jste si jisti, že chcete vypnout 2FA? Váš účet tak nebude chráněn.",
		"2FA_SCAN"	=> "Naskenujte tento QR kód Vaší autentizační aplikací nebo zadejte klíč",
		"2FA_THEN"	=> "Poté zadejte jeden z Vašich jednorázových klíčů zde",
		"2FA_FAIL"	=> "Nastal problém během 2FA ověřování. Zkontrolujte své připojení (check Internet?) nebo kontaktujte podporu.",//TODO kontext
		"2FA_CODE"	=> "2FA Kód",
		"2FA_EXP"		=> "Vypršela platnost 1 fingerprintu", //TODO překlad fingerprint?
		"2FA_EXPD"	=> "Platnost vypršela",
		"2FA_EXPS"	=> "Platnost vyprší",
		"2FA_ACTIVE"=> "Aktivní relace",
		"2FA_NOT_FN"=> "Žádné fingerprinty nebyly nalezeny",
		"2FA_FP"		=> "Fingerprinty",
		"2FA_NP"		=> "<strong>Přihlášení selhalo</strong> Dvoufaktorový autentizační kód nebyl zadán. Prosím, zkuste znovu.",
		"2FA_INV"		=> "<strong>Přihlášení selhalo</strong> Dvoufaktorový autentizační kód nebyl správný. Prosím, zkuste znovu.",
		"2FA_FATAL"	=> "<strong>Fatální error</strong> Prosím, kontaktujte systémového administrátora.",
		));

	//Redirect Messages - These get a plus between each word
	$lang = array_merge($lang,array(
		"REDIR_2FA"						=> "Omlouváme+se.Dvoufaktorová+autentizace+není+nyní+dostupná.",
		"REDIR_2FA_EN"				=> "Dvoufaktorová+autentizace+povolena",
		"REDIR_2FA_DIS"				=> "Dvoufaktorová+autentizace+zakázána",
		"REDIR_2FA_VER"				=> "Dvoufaktorová+autentizace+ověřena+a+povolena",
		"REDIR_SOM_TING_WONG" => "Něco+se+nepodařilo.+Prosím,+zkuste+to+znovu.",
		"REDIR_MSG_NOEX"			=> "Toto+vlákno+neexistuje+nebo+Vám+nepatří.",
		"REDIR_UN_ONCE"				=> "Uživatelské+jméno+již+bylo+jednou+změněno.",
		"REDIR_EM_SUCC"				=> "Email+úspěšně+zaktualizován",
		));

    //Emails
	$lang = array_merge($lang,array(
		"EML_CONF"			=> "Potvrdit Email",
		"EML_VER"				=> "Ověřit svůj Email",
		"EML_CHK"				=> "Požadavek odeslán. Pro ověření prosím zkontrolujte svůj email. Zkontrolujte také spam složku, neboť platnost ověrovacího odkazu vyprší za ",
		"EML_MAT"				=> "Váš email se neshoduje.",
        "EML_HELLO"			=> "Dobrý den",
		"EML_HI"				=> "Nazdar ",
		"EML_AD_HAS"		=> "Administrátor Vám resetoval heslo.",
		"EML_AC_HAS"		=> "Administrátor Vám vytvořil účet.",
		"EML_REQ"				=> "Budete vyzváni ke změně hesla skrze odkaz výše.",
		"EML_EXP"				=> "Prosím pozor, platnost odkazu vyprší za ",
		"EML_VER_EXP"		=> "Platnost odkazu vyprší za ",
		"EML_CLICK"			=> "Pro přihlášení klikněte zde.",
		"EML_REC"				=> "Doporučujeme Vám změnit si heslo při přihlášení.",
		"EML_MSG"				=> "Máte novou zprávu od",
		"EML_REPLY"			=> "Pro odpovězení nebo zobrazní vlákna klikněte zde",
		"EML_WHY"				=> "Tento email Vám přišel, protože někdo (nejspíše Vy) požádal o resetování Vašeho hesla. Pokud jste to nebyli Vy, tento email ignorujte.",
		"EML_HOW"				=> "Pokud jste to byli Vy, klikněte na odkaz níže pro dokončení resetování hesla.",
		"EML_EML"				=> "Z Vašeho uživatelského účtu jsme zaregistrovali požadavek na změnu Vašeho emailu.",
		"EML_VER_EML"		=> "Díky za registraci. Až si ověříte emailovou adresu, budete se moci přihlásit! Pro ověření Vaší emailové adresy klikněte na odkaz níže.",
        "EML_INTRO"         => "těší nás, že chcete využívat mapu inspirativních škol a případně se i podílet na jejím rozvoji. Budeme rádi za sdílení jakýchkoliv podnětů či zaslání zpětné vazby na email ",
		"EML_SUBJ_WELCOME" => "Vítejte na webu ",
		"EML_SIGNATURE"		=> "Tým mapy škol",
    ));

		//Verification
		$lang = array_merge($lang,array(
			"VER_SUC"			=> "Váš email byl ověřen!",
			"VER_FAIL"		=> "Nebyli jsme schopni Váš účet ověřit. Prosím, zkuste to znovu.",
			"VER_RESEND"	=> "Znovu poslat ověřovací email",
			"VER_AGAIN"		=> "Zadejte svou emailovou adresu a zkuste to znovu",
			"VER_PAGE"		=> "<li>Zkontrolujte svůj email a klikněte na odkaz, který jsme Vám poslali.</li><li>Hotovo</li>",
			"VER_RES_SUC" => "<p>Ověřovací odkaz jsme poslali na Vaši emailovou adresu.</p><p>Pro dokončení ověření klikněte na odkaz v emailu. V případě, že se email nenachází ve Vaší schránce, zkontrolujte také spam složku.</p><p>Ověřovací odkazy jsou platné jen ",
			"VER_OOPS"		=> "Ajéje...něco se nepodařilo, možná jste klikli na již neplatný odkaz. Zkuste to znovu kliknutím níže.",
			"VER_RESET"		=> "Vaše heslo bylo resetováno!",
			"VER_INS"			=> "<li>Zadejte svou emailovou adresu a klikněte na Resetovat.</li> <li>Zkontolujte svůj email a klikněte na námi zaslaný odkaz.</li>
												<li>Postupujte podle instrukcí na obrazovce.</li>",
			"VER_SENT"		=> "<p>Odkaz na resetování hesla jsme zaslali na Vaši emailovou adresu.</p>
			    							<p>Pro resetování hesla klikněte v emailu na námi zaslaný odkaz.  V případě, že se email nenachází ve Vaší schránce, zkontrolujte také spam složku.</p><p>Ověřovací odkazy jsou platné jen ",
			"VER_PLEASE"	=> "Prosím, resetujte své heslo",
			));

	//User Settings
	$lang = array_merge($lang,array(
		"SET_PIN"				=> "Resetovat PIN",
		"SET_WHY"				=> "Proč toto nemohu změnit?",
		"SET_PW_MATCH"	=> "Musí se shodovat s novým heslem",

		"SET_PIN_NEXT"	=> "Můžete si nastavit nový PIN při příštím vyžádání ověření", //TODO ?
		"SET_UPDATE"		=> "Aktualizovat uživatelské nastavení",
		"SET_NOCHANGE"	=> "Administrátor zakázal měnit uživatelská jména.",
		"SET_ONECHANGE"	=> "Administrátor nastavil povolený počet změn uživatelského jména na 1 a tento počet jste již provedli.",

		"SET_GRAVITAR"	=> "<strong>Chcete si změnit profilový obrázek? </strong><br> Navštivte <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> a zařiďtě si účet se stejným emailem, jako jste použili u nás. Funguje to na milionech stránkách. Je to rychlé a snadné!",

		"SET_NOTE1"			=> "<p><strong>Prosím pozor,</strong> máte nevyřízený požadavek aktualizovat svůj email na",

		"SET_NOTE2"			=> ".</p><p>Prosím použijte ověřovací email pro splnění tohoto požadavku.</p>
		<p>Pokud potřebujete nový ověřovací email, zadejte prosím výše svou emailovou adresu a odešlete požadavek znovu.</p>",

		"SET_PW_REQ" 		=> "vyžadováno pro změnu hesla, emailu nebo resetování PINu",
		"SET_PW_REQI" 	=> "Vyžadováno pro změnu Vašeho hesla",

		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"		=> "Nepodařilo se ukončit aktivní relace, Error: ",
		"ERR_EMAIL"				=> "Email NEBYL poslán kvůli chybě. Prosím, kontaktujre administrátora stránky.",
		"ERR_EM_DB"				=> "Tento email v naší databázi neexistuje.",
		"ERR_TC"					=> "Prosím, přečtete si a odsouhlaste podmínky použití.",
		"ERR_CAP"					=> "Neprošel jsi Captcha testem, Ty jeden Robote!",
		"ERR_PW_SAME"			=> "Vaše staré heslo nesmí být stejné jako Vaše nové heslo.",
		"ERR_PW_FAIL"			=> "Ověření hesla selhalo. Aktualizace selhala. Prosím, zkuste to znovu.",
		"ERR_GOOG"				=> "<strong>POZNÁMKA:</strong> Pokud jste se původně registrovali Vaším Google/Facebook účtem, pro změnu Vašeho hesla budete muset použít odkaz \"Zapomenuté heslo\"...pokud tedy nejste velmi dobří v hádání.",
		"ERR_EM_VER"			=> "Ověření emailu není povoleno. Kontaktujte prosím systémového administrátora.",
		"ERR_EMAIL_STR"		=> "Něco se nepovedlo. Prosím, znovu ověřte svůj email. Za vzniklé nepříjemnosti se omlouváme.",

		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"		=> "Brzy se vrátíme!",
		"MAINT_MSG"			=> "Omlouváme se za nepříjemnosti, ale právě teď provádíme údržbu.<br> Za chvíli budeme zpět online!",
		"MAINT_BAN"			=> "Pardon, ale byli jste zabanováni. Pokud máte pocit, že se jedná o chybu, kontaktujte prosím administrátora.",
		"MAINT_TOK"			=> "Během zpracování Vašeho požadavku se vyskytla chyba. Prosím, zkuste to znovu. Pozor, odeslání formuláře obnovením stránky způsobí error. Pokud se tato chyba nepřestává objevovat, kontaktujte prosím administrátora.",
		"MAINT_OPEN"		=> "An Open Source PHP User Management Framework.",
		"MAINT_PLEASE"	=> "Úspěšně jste si nainstalovali UserSpice!<br>Pro zobrazení dokumentace Jak začít navštivte prosím "
		));

		//dataTables Added in 4.4.08
		//NOTE: do not change the words like _START_ between the two _ symbols!
		$lang = array_merge($lang,array(
		"DAT_SEARCH"    => "Hledat",
		"DAT_FIRST"     => "První",
		"DAT_LAST"      => "Poslední",
		"DAT_NEXT"      => "Další",
		"DAT_PREV"      => "Předchozí",
		"DAT_NODATA"        => "V tabulce nejsou žádná dostupná data",
		"DAT_INFO"          => "Zobrazeny záznamy _START_ až _END_ z celkem _TOTAL_ záznamů",
		"DAT_ZERO"          => "Zobrazeny záznamy 0 až 0 z celkem 0 záznamů",
		"DAT_FILTERED"      => "(filtrováno z celkem _MAX_ záznamů)",
		"DAT_MENU_LENG"     => "Zobrazit _MENU_ záznamy",
		"DAT_LOADING"       => "Načítání...",
		"DAT_PROCESS"       => "Zpracovávání...",
		"DAT_NO_REC"        => "Žádné odpovídající záznamy nenalezeny",
		"DAT_ASC"           => "Aktivujte pro setřídění dat vzestupně",
		"DAT_DESC"          => "Aktivujte pro setřídění dat sestupně",
		));


///////////////////////////////////////////////////////////////

//Backend Translations for UserSpice 5
$lang = array_merge($lang,array(
"BE_DASH"    			=> "Menu",
"BE_SETTINGS"     => "Nastavení",
"BE_GEN"					=> "Obecné",
"BE_REG"					=> "Registrace",
"BE_CUS"					=> "Custom Settings",
"BE_DASH_ACC"			=> "Přístup k menu",
"BE_TOOLS"				=> "Nástroje",
"BE_BACKUP"				=> "Záloha",
"BE_UPDATE"				=> "Aktualizace",
"BE_CRON"				  => "Cron Jobs",
"BE_IP"				  	=> "IP Manager",
));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
 //do not put a closing php tag here
