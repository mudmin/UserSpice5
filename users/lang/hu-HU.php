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
The Hungarian translation is done by
Tamás Szabó, Ph.D.
SpaceBar Consulting
klaymen@spacebar.hu
*/

/*
%m1% - Dymamic markers which are replaced at run time by the relevant index.
*/

$lang = array();
$lang = array_merge($lang,array(
"THIS_LANGUAGE"	=>"Hungarian",
"THIS_CODE"			=>"hu-HU",
"MISSING_TEXT"	=>"Hiányzó szöveg",
));

//Database Menus
$lang = array_merge($lang,array(
"MENU_HOME"			=> "Kezdőlap",
"MENU_HELP"			=> "Segítség",
"MENU_ACCOUNT"	=> "Adatlap",
"MENU_DASH"			=> "Irányítópult",
"MENU_USER_MGR"	=> "Felhasználók",
"MENU_PAGE_MGR"	=> "Oldalak",
"MENU_PERM_MGR"	=> "Engedélyek",
"MENU_MSGS_MGR"	=> "Üzenet-kezelő",
"MENU_LOGS_MGR"	=> "Rendszernaplók",
"MENU_LOGOUT"		=> "Kijelentkezés",
));

// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"					=> "Regisztráció",
	"SIGNUP_BUTTONTEXT"		=> "Regisztrálok",
	"SIGNUP_AUDITTEXT"		=> "Regisztrált",
	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"				=> "** SIKERTELEN BEJELENTKEZÉS **",
	"SIGNIN_PLEASE_CHK" => "Kérlek ellenőrizd a felhasználóneved és a jelszavad, majd próbálkozz újra",
	"SIGNIN_UORE"				=> "Felhasználónév VAGY e-mail cím",
	"SIGNIN_PASS"				=> "Jelszó",
	"SIGNIN_TITLE"			=> "Kérlek jelentkezz be",
	"SIGNIN_TEXT"				=> "Bejelentkezés",
	"SIGNOUT_TEXT"			=> "Kijelentkezés",
	"SIGNIN_BUTTONTEXT"	=> "Bejelentkezek",
	"SIGNIN_REMEMBER"		=> "Emlékezz rám",
	"SIGNIN_AUDITTEXT"	=> "Bejelentkezve",
	"SIGNIN_FORGOTPASS"	=>"Elfelejtett jelszó",
	"SIGNOUT_AUDITTEXT"	=> "Kijelentkezve",
	));

// Account Page
$lang = array_merge($lang,array(
	"ACCT_EDIT"					=> "Adatlap szerkesztése",
	"ACCT_2FA"					=> "Kétfaktoros hitelesítés",
	"ACCT_SESS"					=> "Munkamenetek kezelése",
	"ACCT_HOME"					=> "Fiók kezdőlapja",
	"ACCT_SINCE"				=> "Csatlakozott",
	"ACCT_LOGINS"				=> "Bejelentkezések száma",
	"ACCT_SESSIONS"			=> "Aktív munkamenetek száma",
	"ACCT_MNG_SES"			=> "További információkért kattintson a bal oldali sávban a Munkamenetek kezelése gombra.",
	));

	//General Terms
	$lang = array_merge($lang,array(
		"GEN_ENABLED"			=> "Engedélyezve",
		"GEN_DISABLED"		=> "Letiltva",
		"GEN_ENABLE"			=> "Engedélyezés",
		"GEN_DISABLE"			=> "Letiltás",
		"GEN_NO"					=> "Nem",
		"GEN_YES"					=> "Igen",
		"GEN_MIN"					=> "min",
		"GEN_MAX"					=> "max",
		"GEN_CHAR"				=> "karakter", //as in characters
		"GEN_SUBMIT"			=> "Beküldés",
		"GEN_MANAGE"			=> "Kezelés",
		"GEN_VERIFY"			=> "Ellenőrzés",
		"GEN_SESSION"			=> "Munkamenet",
		"GEN_SESSIONS"		=> "Munkamenetek",
		"GEN_EMAIL"				=> "E-mail cím",
		"GEN_FNAME"				=> "Keresztnév",
		"GEN_LNAME"				=> "Vezetéknév",
		"GEN_UNAME"				=> "Felhasználónév",
		"GEN_PASS"				=> "Jelszó",
		"GEN_MSG"					=> "Üzenet",
		"GEN_TODAY"				=> "Ma",
		"GEN_CLOSE"				=> "Bezár",
		"GEN_CANCEL"			=> "Mégsem",
		"GEN_CHECK"				=> "[ összes kijelölése/törlése ]",
		"GEN_WITH"				=> "val/vel",
		"GEN_UPDATED"			=> "Frissítve",
		"GEN_UPDATE"			=> "Frissít",
		"GEN_BY"					=> "tól/től",
		"GEN_FUNCTIONS"		=> "Funkciók",
		"GEN_NUMBER"			=> "száma",
		"GEN_NUMBERS"			=> "számai",
		"GEN_INFO"				=> "Információ",
		"GEN_REC"					=> "Rögzített",
		"GEN_DEL"					=> "Törlés",
		"GEN_NOT_AVAIL"		=> "Nem Elérhető",
		"GEN_AVAIL"				=> "Elérhető",
		"GEN_BACK"				=> "Vissza",
		"GEN_RESET"				=> "Visszaállítás",
		"GEN_REQ"					=> "szükséges",
		"GEN_AND"					=> "és",
		"GEN_SAME"				=> "nem egyezik",
		));

//validation class
	$lang = array_merge($lang,array(
		"VAL_SAME"				=> "nem egyezik",
		"VAL_EXISTS"			=> "már létezik. Kérlek válassz egy másikat",
		"VAL_DB"					=> "Adatbázis hiba",
		"VAL_NUM"					=> "számnak kell lennie",
		"VAL_INT"					=> "egész számnak kell lennie",
		"VAL_EMAIL"				=> "érvényes e-mail címnek kell lennie",
		"VAL_NO_EMAIL"		=> "nem lehet e-mail cím",
		"VAL_SERVER"			=> "létező szerverhez kell tartoznia",
		"VAL_LESS"				=> "kevesebbnek kell lennie, mint",
		"VAL_GREAT"				=> "többnek kell lennie, mint",
		"VAL_LESS_EQ"			=> "kevesebbnek vagy egyenlőnek kell lennie, mint",
		"VAL_GREAT_EQ"		=> "többnek vagy egyenlőnek kell lennie, mint",
		"VAL_NOT_EQ"			=> "nem lehet egyenlő",
		"VAL_EQ"					=> "egyenlőnek kell lennie",
		"VAL_TZ"					=> "érvényes időzóna nevének kell lennie",
		"VAL_MUST"				=> "kell, hogy legyen",
		"VAL_MUST_LIST"		=> "a következők egyikének kell lennie",
		"VAL_TIME"				=> "érvényes időnek kell lennie",
		"VAL_SEL"					=> "nem érvényes kijelölés",
		"VAL_NA_PHONE"		=> "érvényes észak-amerikai telefonszámnak kell lennie",
	));

		//Time
	$lang = array_merge($lang,array(
		"T_YEARS"			=> "Évek",
		"T_YEAR"			=> "Év",
		"T_MONTHS"		=> "Hónapok",
		"T_MONTH"			=> "Hónap",
		"T_WEEKS"			=> "Hetek",
		"T_WEEK"			=> "Hét",
		"T_DAYS"			=> "Napok",
		"T_DAY"				=> "Nap",
		"T_HOURS"			=> "Órák",
		"T_HOUR"			=> "Óra",
		"T_MINUTES"		=> "Percek",
		"T_MINUTE"		=> "Perc",
		"T_SECONDS"		=> "Másodpercek",
		"T_SECOND"		=> "Másodperc",
		));


		//Passwords
	$lang = array_merge($lang,array(
		"PW_NEW"		=> "Új Jelszó",
		"PW_OLD"		=> "Régi Jelszó",
		"PW_CONF"		=> "Jelszó Ellenőrzése",
		"PW_RESET"	=> "Jelszó visszaállítása",
		"PW_UPD"		=> " Frissítve",
		"PW_SHOULD"	=> "A jelszó",
		"PW_SHOW"		=> "Jelszó megmutatása",
		"PW_SHOWS"	=> "Jelszavak megmutatása",
		));


		//Join
	$lang = array_merge($lang,array(
		"JOIN_SUC"			=> "Üdvözöllek a ",
		"JOIN_THANKS"		=> "Köszönjük, hogy regisztráltál!",
		"JOIN_HAVE"			=> "Tartalmaznia kell ",
		"JOIN_CAP"			=> " nagybetűt",
		"JOIN_TWICE"		=> "kétszer be lett írva helyesen",
		"JOIN_CLOSED"		=> "Sajnos a regisztráció jelenleg le van tiltva. Ha bármilyen kérdésed vagy aggályod van, fordulj az adminisztrátorhoz.",
		"JOIN_TC"				=> "Regisztrációs felhasználási feltételek",
		"JOIN_ACCEPTTC" => "Elfogadom a felhasználási feltételeket",
		"JOIN_CHANGED"	=> "Feltételeink megváltoztak",
		"JOIN_ACCEPT" 	=> "Fogadd el a felhasználási feltételeket és folytasd",
		));

		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "Sikeresen lezárt ",
		));

		//Messages
	$lang = array_merge($lang,array(
		"MSG_SENT"			=> "Az üzeneted el lett küldve!",
		"MSG_MASS"			=> "A tömeges üzeneted elküldve!",
		"MSG_NEW"				=> "Új Üzenet",
		"MSG_NEW_MASS"	=> "Új Tömeges Üzenet",
		"MSG_CONV"			=> "Beszélgetések",
		"MSG_NO_CONV"		=> "Nincsenek Beszélgetések",
		"MSG_NO_ARC"		=> "Nincsenek Beszélgetések",
		"MSG_QUEST"			=> "E-mail értesítés küldése, ha engedélyezve van?",
		"MSG_ARC"				=> "Archivált Témák",
		"MSG_VIEW_ARC"	=> "Archivált Témák Megjelenítése",
		"MSG_SETTINGS"  => "Üzenet Beállítások",
		"MSG_READ"			=> "Olvasás",
		"MSG_BODY"			=> "Tartalom",
		"MSG_SUB"				=> "Tárgy",
		"MSG_DEL"				=> "Kézbesítve",
		"MSG_REPLY"			=> "Válasz",
		"MSG_QUICK"			=> "Gyors Válasz",
		"MSG_SELECT"		=> "Felhasználó kiválasztása",
		"MSG_UNKN"			=> "Ismeretlen Címzett",
		"MSG_NOTIF"			=> "Üzenetküldési e-mail értesítések",
		"MSG_BLANK"			=> "Az üzenet nem lehet üres",
		"MSG_MODAL"			=> "Kattints ide, vagy használd az Alt+R kombinációt, VAGY nyomd meg a Shift+R kombinációt a válaszablak megnyitásához!",
		"MSG_ARCHIVE_SUCCESSFUL"        => "Sikeresen archiváltál %m1% témát",
		"MSG_UNARCHIVE_SUCCESSFUL"      => "Sikeresen aktiváltál %m1% témát",
		"MSG_DELETE_SUCCESSFUL"         => "Sikeresen töröltél %m1% témát",
		"USER_MESSAGE_EXEMPT"         			=> "A felhasználó %m1% kihagyva az üzenetekből",
		"MSG_MK_READ"		=> "Olvasott",
		"MSG_MK_UNREAD"	=> "Olvasatlan",
		"MSG_ARC_THR"		=> "Kiválasztott témák archiválása",
		"MSG_UN_THR"		=> "Kiválasztott témák aktiválása",
		"MSG_DEL_THR"		=> "Kiválasztott témák törlése",
		"MSG_SEND"			=> "Üzenet Küldése",
		));

	//2 Factor Authentication
	$lang = array_merge($lang,array(
		"2FA"				=> "Kétfaktoros Hitelesítés",
		"2FA_CONF"	=> "Biztosan letiltod a kétfaktoros hitelesítést (2FA)? A fiókod már nem lesz így védve.",
		"2FA_SCAN"	=> "Olvasd be a QR-kódot a hitelesítő alkalmazással, vagy add meg a kulcsot",
		"2FA_THEN"	=> "Ezután adja meg az egyszeri kulcsok egyikét",
		"2FA_FAIL"	=> "Probléma volt a kétfaktoros hitelesítés (2FA) ellenőrzése során. Kérlek, ellenőrizd az internetet vagy fordulj az adminisztrátorhoz.",
		"2FA_CODE"	=> "2FA Kód",
		"2FA_EXP"		=> "Lejárt 1 ujjlenyomat",
		"2FA_EXPD"	=> "Lejárt",
		"2FA_EXPS"	=> "Lejár",
		"2FA_ACTIVE"=> "Aktív Munkamenetek",
		"2FA_NOT_FN"=> "Nincsenek ujjlenyomatok",
		"2FA_FP"		=> "Ujjlenyomatok",
		"2FA_NP"		=> "<strong>Sikertelen Bejelentkezés</strong> Nincs kétfaktoros hitelesítő kód. Kérlek próbáld újra.",
		"2FA_INV"		=> "<strong>Sikertelen Bejelentkezés</strong> Érvénytelen kétfaktoros hitelesítő kód. Kérlek próbáld újra.",
		"2FA_FATAL"	=> "<strong>Végzetes Hiba</strong> Kérlek fordulj az adminisztrátorhoz.",
		));

	//Redirect Messages - These get a plus between each word
	$lang = array_merge($lang,array(
		"REDIR_2FA"						=> "Sajnos+a+kétfaktoros+hitelesítés+nincs+engedélyezve.",
		"REDIR_2FA_EN"				=> "Kétfaktoros+Hitelesítés+Engedélyezve",
		"REDIR_2FA_DIS"				=> "Kétfaktoros+Hitelesítés+Letiltva",
		"REDIR_2FA_VER"				=> "Kétfaktoros+Hitelesítés+Ellenőrizve+és+Engedélyezve",
		"REDIR_SOM_TING_WONG" => "Valami+baj+történt.+Kérlek+próbáld+újra.",
		"REDIR_MSG_NOEX"			=> "A+téma+nem+hozzád+tartozik+vagy+nem+létezik.",
		"REDIR_UN_ONCE"				=> "A+felhasználónév+már+megváltozott+egyszer.",
		"REDIR_EM_SUCC"				=> "E-mail+Sikeresen+Frissítve",
		));

	//Emails
	$lang = array_merge($lang,array(
		"EML_CONF"			=> "E-mail megerősítése",
		"EML_VER"				=> "Hitelesítsd az e-mail címed",
		"EML_CHK"				=> "Hitelesítő e-mail kiküldve. Kérlek ellenőrizd a megadott e-mail fiókot és kövesd a hitelesítési igazolást tartalmazó üzenet utasításait. Ha nem találod elsőre a levelet győződj meg róla, hogy ellenőrizted a Spam és a Junk mappákat is. A hitelesítési hivatkozás lejárati ideje: ",
		"EML_MAT"				=> "Az e-mail címed nem egyezik.",
		"EML_HELLO"			=> "Üdvözöllek ",
		"EML_HI"				=> "Üdv ",
		"EML_AD_HAS"		=> "Az adminisztrátor visszaállította a jelszavad.",
		"EML_AC_HAS"		=> "Az adminisztrátor létrehozta fiókod.",
		"EML_REQ"				=> "Be kell állítanod az új jelszavad a fenti hivatkozás segítségével.",
		"EML_EXP"				=> "Kérlek, vedd figyelembe, hogy a jelszó hivatkozás lejárati ideje: ",
		"EML_VER_EXP"		=> "Kérlek, vedd figyelembe, hogy a hitelesítő hivatkozás lejárati ideje: ",
		"EML_CLICK"			=> "Kattints ide a bejelentkezéshez.",
		"EML_REC"				=> "A következő bejelentkezéskor érdemes megváltoztatni a jelszavad.",
		"EML_MSG"				=> "Új üzeneted érkezett tőle: ",
		"EML_REPLY"			=> "Kattints ide a téma megválaszolásához vagy megtekintéséhez",
		"EML_WHY"				=> "Ezt az e-mailt kapod, mert kérés érkezett a jelszavad visszaállítására. Ha ezt nem te kezdeményezted, akkor figyelmen kívül hagyhatod ezt az e-mailt.",
		"EML_HOW"				=> "Ha te kezdeményezted a folyamatot, kattints az alábbi hivatkozásra a jelszó-visszaállítási folyamat folytatásához.",
		"EML_EML"				=> "A felhasználói fiókodból indítottak egy e-mail megváltoztatására irányuló kérelmet.",
		"EML_VER_EML"		=> "Köszönjük, hogy regisztráltál. Miután megerősítetted az e-mail címed, készen állsz a bejelentkezésre! Kérlek, kattints az alábbi hivatkozásra az e-mail címed ellenőrzéséhez.",
		));

		//Verification
		$lang = array_merge($lang,array(
			"VER_SUC"			=> "E-mail hitelesítése megtörtént!",
			"VER_FAIL"		=> "Nem tudtuk hitelesíteni az e-mail címed. Kérlek próbáld újra.",
			"VER_RESEND"	=> "Hitelesítő e-mail újraküldése",
			"VER_AGAIN"		=> "Add meg az e-mail címed, és próbáld újra",
			"VER_PAGE"		=> "<li>Ellenőrizd az e-mail címed, és kattints a kapott hivatkozásra</li><li>Kész</li>",
			"VER_RES_SUC" => "<p>A hitelesítő hivatkozást elküldtük az e-mail címedre.</p><p>A hitelesítés befejezéséhez kattints az e-mailben található hivatkozásra. Nézd meg a Spam vagy Junk mappákat is, ha az e-mailt nem találod a postafiókodban.</p><p>A hitelesítő hivatkozás lejárati ideje: ",
			"VER_OOPS"		=> "Hoppá... valami baj van, előfordulhat, hogy egy régi hivatkozásra kattintottál. Kattints az alábbi gombra, és próbáld újra",
			"VER_RESET"		=> "Új jelszó lett beállítva a fiókodhoz!",
			"VER_INS"			=> "<li>Add meg az e-mail címed, majd kattints a Visszaállítás gombra</li> <li>Ellenőrizd az e-mail címed, és kattints a kapott hivatkozásra.</li>
												<li>Kövesd a képernyőn megjelenő utasításokat</li>",
			"VER_SENT"		=> "<p>Az új jelszó megadásához szükséges hivatkozást elküldtük az e-mail címedre.</p>
			    							<p>Kattinst a levélben található hivatkozásra új jelszó beállításához. Nézd meg a Spam vagy Junk mappákat is, ha az e-mailt nem találod a postafiókodban.</p><p>A jelszó visszaállító hivatkozás lejárati ideje ",
			"VER_PLEASE"	=> "Kérlek, állíts be új jelszót",
			));

	//User Settings
	$lang = array_merge($lang,array(
		"SET_PIN"				=> "PIN visszaállítás",
		"SET_WHY"				=> "Miért nem tudom ezt megváltoztatni?",
		"SET_PW_MATCH"	=> "Meg kell egyeznie az új jelszóval",

		"SET_PIN_NEXT"	=> "Új PIN-kódot állíthatsz be a következő hitelesítéskor",
		"SET_UPDATE"		=> "Frissítsd felhasználói beállításaid",
		"SET_NOCHANGE"	=> "Az adminisztrátor letiltotta a felhasználónevek módosítását.",
		"SET_ONECHANGE"	=> "Az adminisztrátor letiltotta a felhasználónevek többszöri módosítását és te már egyszer módosítottad azt.",

		"SET_GRAVITAR"	=> "<strong>Szeretnéd megváltoztatni a profilképed? </strong><br> Látogass el ide <a href='https://hu.gravatar.com/'>https://hu.gravatar.com/</a> és regisztrálj be egy fiókot ugyanazzal az e-mail címmel, amit ezen a webhelyen is használsz. Gyors és egyszerű!",

		"SET_NOTE1"			=> "<p><strong>Kérlek vedd figyelembe,</strong> hogy függőben van egy kérés az e-mail címed megváltoztatásához a következőre: ",

		"SET_NOTE2"			=> ".</p><p>Kérlek, használd a hitelesítő e-mailt a folyamat befejezéséhez.</p>
		<p>Ha új hitelesítő e-mailt szeretnél, írd be újra a fenti e-mail címet, és küldd el újra a kérést.</p>",

		"SET_PW_REQ" 		=> " e-mail vagy jelszó megváltoztatásához, PIN-kód visszaállításához szükséges",
		"SET_PW_REQI" 	=> "Muszáj megváltoztatnod a jelszavadat",

		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"		=> "Nem sikerült leállítani az aktív munkameneteket, Hiba: ",
		"ERR_EMAIL"				=> "NEM tudtuk elküldeni az e-mailt egy hiba miatt. Kérlek, fordulj a webhely adminisztrátorához.",
		"ERR_EM_DB"				=> "Ez az e-mail nem létezik adatbázisunkban",
		"ERR_TC"					=> "Kérlek, olvasd el és fogadd el a felhasználási feltételeket",
		"ERR_CAP"					=> "Nem sikerült a Captcha teszt, robot!",
		"ERR_PW_SAME"			=> "A régi jelszó nem lehet ugyanaz, mint az új",
		"ERR_PW_FAIL"			=> "Nem sikerült a jelenlegi jelszó ellenőrzése. Sikertelen módosítás. Kérlek próbáld újra.",
		"ERR_GOOG"				=> "<strong>MEGJEGYZÉS:</strong> Ha eredetileg a Google vagy Facebook fiókoddal regisztráltál, akkor a jelszó megváltoztatásához az elfelejtett jelszó linket kell használnod ... kivéve, ha jól tudsz tippelni.",
		"ERR_EM_VER"			=> "Az e-mail hitelesítése nem engedélyezett. Kérlek, fordulj az adminisztrátorhoz.",
		"ERR_EMAIL_STR"		=> "Valami furcsa. Kérlek, hitelesítsd újra az e-mail címed. Elnézést a kellemetlenségért!",
		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"		=> "Hamarosan visszajövünk!",
		"MAINT_MSG"			=> "Elnézést a kellemetlenségért, jelenleg karbantartást végzünk.<br> Hamarosan visszajövünk!",
		"MAINT_BAN"			=> "Sajnálom. Ki lettél tiltva a webhelyről. Ha úgy érzed, ez hiba, kérlek, fordulj az adminisztrátorhoz.",
		"MAINT_TOK"			=> "Hiba történt az űrlap elküldésekor. Kérlek, próbáld újra és vedd figyelembe, hogy az űrlap újraküldése az oldal frissítésével hibát okoz. Ha ez továbbra is fennáll, fordulj az adminisztrátorhoz.",
		"MAINT_OPEN"		=> "Egy nyílt forráskódú PHP alapú Felhasználó-kezelő Keretrendszer",
		"MAINT_PLEASE"	=> "Sikeresen telepítetted a UserSpice-t! <br> Az első lépések megtételében sokat segít az alábbi webhely: "
		));

		//dataTables Added in 4.4.08
		//NOTE: do not change the words like _START_ between the two _ symbols!
		$lang = array_merge($lang,array(
		"DAT_SEARCH"    => "Keresés",
		"DAT_FIRST"     => "Első",
		"DAT_LAST"      => "Utolsó",
		"DAT_NEXT"      => "Következő",
		"DAT_PREV"      => "Előző",
		"DAT_NODATA"        => "Nincs rendelkezésre álló adat a táblázatban",
		"DAT_INFO"          => "_START_ - _END_ összesen _TOTAL_ találat",
		"DAT_ZERO"          => "0 - 0 összesen 0 találat",
		"DAT_FILTERED"      => "(szűrve _MAX_ találatból)",
		"DAT_MENU_LENG"     => "_MENU_ találat",
		"DAT_LOADING"       => "Betöltés...",
		"DAT_PROCESS"       => "Feldolgozás...",
		"DAT_NO_REC"        => "Nem található megfelelő rekord",
		"DAT_ASC"           => "Aktiváld az oszlop növekvő sorba rendezéséhez",
		"DAT_DESC"          => "Aktiváld az oszlop csökkenő sorba rendezéséhez",
		));

//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
 //do not put a closing php tag here
