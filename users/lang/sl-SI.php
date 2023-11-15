<?php
/*
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
	"THIS_LANGUAGE"	=>"Slovenščina",
	"THIS_CODE"		=>"sl-SI",
	"MISSING_TEXT"	=>"Manjkajoče besedilo",
));

//Database Menus
$lang = array_merge($lang,array(
	"MENU_HOME"			=> "Domov",
	"MENU_HELP"			=> "Pomoč",
	"MENU_ACCOUNT"		=> "Račun",
	"MENU_DASH"			=> "Nadzorna plošča za skrbnike",
	"MENU_USER_MGR"		=> "Upravljanje uporabnikov",
	"MENU_PAGE_MGR"		=> "Upravljanje strani",
	"MENU_PERM_MGR"		=> "Upravljanje dovoljenj",
	"MENU_MSGS_MGR"		=> "Upravitelj sporočil",
	"MENU_LOGS_MGR"		=> "Sistemski dnevniki",
	"MENU_LOGOUT"		=> "Odjava",
));

// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"		=> "Registracija",
	"SIGNUP_BUTTONTEXT"	=> "Registriraj me",
	"SIGNUP_AUDITTEXT"	=> "Registriran",

	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"		=> "** NEUSPEŠNA PRIJAVA **",
	"SIGNIN_PLEASE_CHK" => "Prosimo, preverite svoje uporabniško ime in geslo ter poskusite znova",
	"SIGNIN_UORE"		=> "Uporabniško ime ALI E-pošta",
	"SIGNIN_PASS"		=> "Geslo",
	"SIGNIN_TITLE"		=> "Prosimo, prijavite se",
	"SIGNIN_TEXT"		=> "Prijavi se",
	"SIGNOUT_TEXT"		=> "Odjavi se",
	"SIGNIN_BUTTONTEXT"	=> "Prijava",
	"SIGNIN_REMEMBER"	=> "Zapomni si me",
	"SIGNIN_AUDITTEXT"	=> "Prijavljen",
	"SIGNIN_FORGOTPASS"	=>"Pozabljeno geslo",
	"SIGNOUT_AUDITTEXT"	=> "Odjavljen",
	));

// Account Page
$lang = array_merge($lang,array(
	"ACCT_EDIT"			=> "Uredi podatke o računu",
	"ACCT_2FA"			=> "Upravljanje z dvofaktorsko avtentikacijo",
	"ACCT_SESS"			=> "Upravljanje sej",
	"ACCT_HOME"			=> "Domov računa",
	"ACCT_SINCE"		=> "Član od",
	"ACCT_LOGINS"		=> "Število prijav",
	"ACCT_SESSIONS"		=> "Število aktivnih sej",
	"ACCT_MNG_SES"		=> "Za več informacij kliknite gumb Upravljanje sej v levem stranskem meniju.",
	));

	//General Terms
	$lang = array_merge($lang,array(
		"GEN_ENABLED"	=> "Omogočeno",
		"GEN_DISABLED"	=> "Onemogočeno",
		"GEN_ENABLE"	=> "Omogoči",
		"GEN_DISABLE"	=> "Onemogoči",
		"GEN_NO"		=> "Ne",
		"GEN_YES"		=> "Da",
		"GEN_MIN"		=> "min",
		"GEN_MAX"		=> "max",
		"GEN_CHAR"		=> "znak", //as in characters
		"GEN_SUBMIT"	=> "Pošlji",
		"GEN_MANAGE"	=> "Upravljaj",
		"GEN_VERIFY"	=> "Preveri",
		"GEN_SESSION"	=> "Seja",
		"GEN_SESSIONS"	=> "Seje",
		"GEN_EMAIL"		=> "E-pošta",
		"GEN_FNAME"		=> "Ime",
		"GEN_LNAME"		=> "Priimek",
		"GEN_UNAME"		=> "Uporabniško ime",
		"GEN_PASS"		=> "Geslo",
		"GEN_MSG"		=> "Sporočilo",
		"GEN_TODAY"		=> "Danes",
		"GEN_CLOSE"		=> "Zapri",
		"GEN_CANCEL"	=> "Prekliči",
		"GEN_CHECK"		=> "[ označi/odznači vse ]",
		"GEN_WITH"		=> "z",
		"GEN_UPDATED"	=> "Posodobljeno",
		"GEN_UPDATE"	=> "Posodobi",
		"GEN_BY"		=> "od",
		"GEN_FUNCTIONS"	=> "Funkcije",
		"GEN_NUMBER"	=> "število",
		"GEN_NUMBERS"	=> "števila",
		"GEN_INFO"		=> "Informacije",
		"GEN_REC"		=> "Posneto",
		"GEN_DEL"		=> "Izbriši",
		"GEN_NOT_AVAIL"	=> "Ni na voljo",
		"GEN_AVAIL"		=> "Na voljo",
		"GEN_BACK"		=> "Nazaj",
		"GEN_RESET"		=> "Ponastavi",
		"GEN_REQ"		=> "zahtevano",
		"GEN_AND"		=> "in",
		"GEN_SAME"		=> "mora biti enako",
		));

//validation class
	$lang = array_merge($lang,array(
		"VAL_SAME"		=> "mora biti enako",
		"VAL_EXISTS"	=> "že obstaja. Izberite drugo",
		"VAL_DB"		=> "Napaka v bazi podatkov",
		"VAL_NUM"		=> "mora biti število",
		"VAL_INT"		=> "mora biti celo število",
		"VAL_EMAIL"		=> "mora biti veljaven e-poštni naslov",
		"VAL_NO_EMAIL"	=> "ne sme biti e-poštni naslov",
		"VAL_SERVER"	=> "mora pripadati veljavnemu strežniku",
		"VAL_LESS"		=> "mora biti manjše od",
		"VAL_GREAT"		=> "mora biti večje od",
		"VAL_LESS_EQ"	=> "mora biti manjše ali enako",
		"VAL_GREAT_EQ"	=> "mora biti večje ali enako",
		"VAL_NOT_EQ"	=> "ne sme biti enako",
		"VAL_EQ"		=> "mora biti enako",
		"VAL_TZ"		=> "mora biti veljavno ime časovnega pasu",
		"VAL_MUST"		=> "mora biti",
		"VAL_MUST_LIST"	=> "mora biti eden od naslednjih",
		"VAL_TIME"		=> "mora biti veljaven čas",
		"VAL_SEL"		=> "ni veljavna izbira",
		"VAL_NA_PHONE"	=> "mora biti veljavna telefonska številka",
	));

		//Time
	$lang = array_merge($lang,array(
		"T_YEARS"		=> "Leta",
		"T_YEAR"		=> "Leto",
		"T_MONTHS"		=> "Meseci",
		"T_MONTH"		=> "Mesec",
		"T_WEEKS"		=> "Tedni",
		"T_WEEK"		=> "Teden",
		"T_DAYS"		=> "Dnevi",
		"T_DAY"			=> "Dan",
		"T_HOURS"		=> "Ure",
		"T_HOUR"		=> "Ura",
		"T_MINUTES"		=> "Minute",
		"T_MINUTE"		=> "Minuta",
		"T_SECONDS"		=> "Sekunde",
		"T_SECOND"		=> "Sekund",
		));


		//Passwords
	$lang = array_merge($lang,array(
		"PW_NEW"		=> "Novo geslo",
		"PW_OLD"		=> "Staro geslo",
		"PW_CONF"		=> "Potrdi geslo",
		"PW_RESET"		=> "Ponastavi geslo",
		"PW_UPD"		=> "Geslo posodobljeno",
		"PW_SHOULD"		=> "Gesla morajo biti...",
		"PW_SHOW"		=> "Prikaži geslo",
		"PW_SHOWS"		=> "Prikaži gesla",
		));


		//Join
	$lang = array_merge($lang,array(
		"JOIN_SUC"		=> "Dobrodošli v ",
		"JOIN_THANKS"	=> "Hvala za registracijo!",
		"JOIN_HAVE"		=> "Imeti vsaj ",
		"JOIN_CAP"		=> " veliko črko",
		"JOIN_TWICE"	=> "Biti pravilno vneseno dvakrat",
		"JOIN_CLOSED"	=> "Na žalost je registracija trenutno onemogočena. Če imate kakršna koli vprašanja ali pomisleke, se obrnite na skrbnika spletnega mesta.",
		"JOIN_TC"		=> "Pogoji in določila za uporabnike pri registraciji",
		"JOIN_ACCEPTTC" => "Sprejemam pogoje in določila za uporabnike",
		"JOIN_CHANGED"	=> "Naši pogoji so se spremenili",
		"JOIN_ACCEPT" 	=> "Sprejmite pogoje in določila za uporabnike in nadaljujte",

		));

		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "Uspešno zaključena ",
		));

		//Messages
	$lang = array_merge($lang,array(
		"MSG_SENT"		=> "Vaše sporočilo je bilo poslano!",
		"MSG_MASS"		=> "Vaše masovno sporočilo je bilo poslano!",
		"MSG_NEW"		=> "Novo sporočilo",
		"MSG_NEW_MASS"	=> "Novo masovno sporočilo",
		"MSG_CONV"		=> "Pogovori",
		"MSG_NO_CONV"	=> "Ni pogovorov",
		"MSG_NO_ARC"	=> "Ni pogovorov",
		"MSG_QUEST"		=> "Pošlji obvestilo po e-pošti, če je omogočeno?",
		"MSG_ARC"		=> "Arhivirane niti",
		"MSG_VIEW_ARC"	=> "Ogled arhiviranih niti",
		"MSG_SETTINGS"  => "Nastavitve sporočil",
		"MSG_READ"		=> "Prebrano",
		"MSG_BODY"		=> "Telo",
		"MSG_SUB"		=> "Zadeva",
		"MSG_DEL"		=> "Dostavljeno",
		"MSG_REPLY"		=> "Odgovori",
		"MSG_QUICK"		=> "Hiter odgovor",
		"MSG_SELECT"	=> "Izberite uporabnika",
		"MSG_UNKN"		=> "Neznan prejemnik",
		"MSG_NOTIF"		=> "Obvestila o sporočilih po e-pošti",
		"MSG_BLANK"		=> "Sporočilo ne sme biti prazno",
		"MSG_MODAL"		=> "Kliknite tukaj ali pritisnite Alt + R, da se osredotočite na to polje ALI pritisnite Shift + R, da odprete razširjeno okno za odgovor!",
		"MSG_ARCHIVE_SUCCESSFUL"        => "Uspešno ste arhivirali %m1% niti",
		"MSG_UNARCHIVE_SUCCESSFUL"      => "Uspešno ste de-arhivirali %m1% niti",
		"MSG_DELETE_SUCCESSFUL"         => "Uspešno ste izbrisali %m1% niti",
		"USER_MESSAGE_EXEMPT"         	=> "Uporabnik je %m1% izvzet iz sporočil.",
		"MSG_MK_READ"	=> "Prebrano",
		"MSG_MK_UNREAD"	=> "Neprebrano",
		"MSG_ARC_THR"	=> "Arhiviraj izbrane niti",
		"MSG_UN_THR"	=> "Dearhiviraj izbrane niti",
		"MSG_DEL_THR"	=> "Izbriši izbrane niti",
		"MSG_SEND"		=> "Pošlji sporočilo",
		));

	//2 Factor Authentication
	$lang = array_merge($lang,array(
		"2FA"			=> "2 faktorska avtentikacija",
		"2FA_CONF"		=> "Ali ste prepričani, da želite onemogočiti 2FA? Vaš račun ne bo več zaščiten.",
		"2FA_SCAN"		=> "Skenirajte to QR kodo z vašo aplikacijo za avtentikacijo ali vnesite ključ",
		"2FA_THEN"		=> "Nato vnesite enega od vaših enkratnih gesel tukaj",
		"2FA_FAIL"		=> "Pri preverjanju 2FA je prišlo do težave. Preverite internet ali se obrnite na podporo.",
		"2FA_CODE"		=> "2FA koda",
		"2FA_EXP"		=> "Potekel 1 prstni odtis",
		"2FA_EXPD"		=> "Potekel",
		"2FA_EXPS"		=> "Poteče",
		"2FA_ACTIVE"	=> "Aktivne seje",
		"2FA_NOT_FN"	=> "Prstnih odtisov ni bilo mogoče najti",
		"2FA_FP"		=> "Prstni odtisi",
		"2FA_NP"		=> "<strong>Prijava ni uspela</strong> Kode za dvofaktorsko avtentikacijo ni bilo. Poskusite znova.",
		"2FA_INV"		=> "<strong>Prijava ni uspela</strong> Koda za dvofaktorsko avtentikacijo je bila neveljavna. Poskusite znova.",
		"2FA_FATAL"		=> "<strong>Usodna napaka</strong> Obrnite se na sistemskega administratorja.",
		));

	//Redirect Messages - These get a plus between each word
	$lang = array_merge($lang,array(
		"REDIR_2FA"					=> "Oprostite.Dvofaktorska+avtentikacija+trenutno+ni+omogočena",
		"REDIR_2FA_EN"				=> "Dvofaktorska+avtentikacija+omogočena",
		"REDIR_2FA_DIS"				=> "Dvofaktorska+avtentikacija+onemogočena",
		"REDIR_2FA_VER"				=> "Dvofaktorska+avtentikacija+preverjena+in+omogočena",
		"REDIR_SOM_TING_WONG" 		=> "Nekaj+je+šlo+narobe.+Prosimo,+poskusite+znova.",
		"REDIR_MSG_NOEX"			=> "Ta+vlaknica+vam+ne+pripada+ali+ne+obstaja.",
		"REDIR_UN_ONCE"				=> "Uporabniško+ime+je+bilo+že+enkrat+spremenjeno.",
		"REDIR_EM_SUCC"				=> "E-pošta+uspešno+posodobljena",
		));

	//Emails
	$lang = array_merge($lang,array(
		"EML_CONF"		=> "Potrditev e-pošte",
		"EML_VER"		=> "Preverite svojo e-pošto",
		"EML_CHK"		=> "Prejeli smo zahtevo za e-pošto. Prosimo, preverite svojo e-pošto za izvedbo preverjanja. Ne pozabite preveriti tudi mape za neželeno pošto, saj povezava za preverjanje poteče v ",
		"EML_MAT"		=> "Vaša e-pošta se ni ujemala.",
		"EML_HELLO"		=> "Pozdravljeni od ",
		"EML_HI"		=> "Pozdravljeni ",
		"EML_AD_HAS"	=> "Administrator je ponastavil vaše geslo.",
		"EML_AC_HAS"	=> "Administrator je ustvaril vaš račun.",
		"EML_REQ"		=> "Z uporabo zgornje povezave boste morali nastaviti svoje geslo.",
		"EML_EXP"		=> "Upoštevajte, da povezave za geslo potečejo v ",
		"EML_VER_EXP"	=> "Upoštevajte, da povezave za preverjanje potečejo v ",
		"EML_CLICK"		=> "Kliknite tukaj za prijavo.",
		"EML_REC"		=> "Priporočljivo je, da ob prijavi spremenite svoje geslo.",
		"EML_MSG"		=> "Prejeli ste novo sporočilo od",
		"EML_REPLY"		=> "Kliknite tukaj za odgovor ali ogled niti",
		"EML_WHY"		=> "To e-pošto ste prejeli, ker je bila podana zahteva za ponastavitev vašega gesla. Če to niste bili vi, lahko to e-pošto prezrete.",
		"EML_HOW"		=> "Če ste bili to vi, kliknite spodnjo povezavo, da nadaljujete s postopkom ponastavitve gesla.",
		"EML_EML"		=> "Zahtevo za spremembo vaše e-pošte je bilo podano znotraj vašega uporabniškega računa.",
		"EML_VER_EML"	=> "Hvala za prijavo. Ko boste preverili svoj e-poštni naslov, boste pripravljeni za prijavo! Kliknite spodnjo povezavo, da preverite svoj e-poštni naslov.",
		));

		//Verification
		$lang = array_merge($lang,array(
			"VER_SUC"		=> "Vaš e-poštni naslov je bil preverjen!",
			"VER_FAIL"		=> "Vašega računa nismo mogli preveriti. Prosimo, poskusite znova.",
			"VER_RESEND"	=> "Ponovno pošlji e-pošto za preverjanje",
			"VER_AGAIN"		=> "Vnesite svoj e-poštni naslov in poskusite znova",
			"VER_PAGE"		=> "<li>Preverite svojo e-pošto in kliknite na povezavo, ki vam je bila poslana</li><li>Končano</li>",
			"VER_RES_SUC" 	=> "<p>Povezava za preverjanje je bila poslana na vaš e-poštni naslov.</p><p>Kliknite na povezavo v e-pošti, da dokončate preverjanje. Če e-pošte ni v vašem nabiralniku, preverite mapo z neželeno pošto.</p><p>Povezave za preverjanje so veljavne samo ",
			"VER_OOPS"		=> "Ups...nekaj je šlo narobe, morda ste kliknili na staro povezavo za ponastavitev. Kliknite spodaj, da poskusite znova",
			"VER_RESET"		=> "Vaše geslo je bilo ponastavljeno!",
			"VER_INS"		=> "<li>Vnesite svoj e-poštni naslov in kliknite Ponastavi</li> <li>Preverite svojo e-pošto in kliknite na povezavo, ki vam je bila poslana.</li>
															<li>Sledite navodilom na zaslonu</li>",
			"VER_SENT"		=> "<p>Povezava za ponastavitev gesla je bila poslana na vaš e-poštni naslov.</p>
						    							<p>Kliknite na povezavo v e-pošti, da ponastavite geslo. Če e-pošte ni v vašem nabiralniku, preverite mapo z neželeno pošto.</p><p>Povezave za ponastavitev so veljavne samo ",
			"VER_PLEASE"	=> "Prosimo, ponastavite svoje geslo",
			));

	//User Settings
	$lang = array_merge($lang,array(
		"SET_PIN"		=> "Ponastavi PIN",
		"SET_WHY"		=> "Zakaj tega ne morem spremeniti?",
		"SET_PW_MATCH"	=> "Se mora ujemati z novim geslom",

		"SET_PIN_NEXT"	=> "Naslednjič, ko boste potrebovali preverjanje, lahko nastavite nov PIN",
		"SET_UPDATE"	=> "Posodobite nastavitve svojega uporabnika",
		"SET_NOCHANGE"	=> "Administrator je onemogočil spreminjanje uporabniških imen.",
		"SET_ONECHANGE"	=> "Administrator je nastavil, da se lahko uporabniška imena spremenijo samo enkrat, vi pa ste to že storili.",

		"SET_GRAVITAR"	=> "<strong>Želite spremeniti svojo profilno sliko? </strong><br> Obiščite <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> in ustvarite račun z istim e-poštnim naslovom, ki ste ga uporabili na tej strani. Deluje na milijonih strani. Hitro in enostavno!",

		"SET_NOTE1"		=> "<p><strong>Upoštevajte</strong>, da obstaja čakajoča zahteva za posodobitev vaše e-pošte na",

		"SET_NOTE2"		=> ".</p><p>Uporabite e-pošto za preverjanje, da dokončate to zahtevo.</p>
		<p>Če potrebujete novo e-pošto za preverjanje, ponovno vnesite zgornji e-poštni naslov in ponovno pošljite zahtevo.</p>",

		"SET_PW_REQ" 	=> "potrebno za spreminjanje gesla, e-pošte ali ponastavitev PIN",
		"SET_PW_REQI" 	=> "Potrebno za spremembo gesla",
		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"	=> "Ni uspelo prekiniti aktivnih sej, napaka: ",
		"ERR_EMAIL"		=> "E-pošte NI bilo mogoče poslati zaradi napake. Obrnite se na skrbnika spletnega mesta.",
		"ERR_EM_DB"		=> "Ta e-pošta ne obstaja v naši bazi podatkov",
		"ERR_TC"		=> "Prosimo, preberite in sprejmite pogoje uporabe",
		"ERR_CAP"		=> "Niste uspešno opravili Captcha testa, robot!",
		"ERR_PW_SAME"	=> "Vaše staro geslo ne more biti enako kot novo",
		"ERR_PW_FAIL"	=> "Preverjanje trenutnega gesla ni uspelo. Posodobitev ni uspela. Poskusite znova.",
		"ERR_GOOG"		=> "<strong>OPOMBA:</strong> Če ste se prvotno prijavili s svojim Google/Facebook računom, boste morali uporabiti povezavo za pozabljeno geslo, da spremenite svoje geslo... razen če ste res dobri v ugibanju.",
		"ERR_EM_VER"	=> "Preverjanje e-pošte ni omogočeno. Obrnite se na sistemski admin.",
		"ERR_EMAIL_STR"	=> "Nekaj je čudno. Prosimo, ponovno preverite svojo e-pošto. Opravičujemo se za nevšečnosti",
		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"	=> "Kmalu bomo nazaj!",
		"MAINT_MSG"		=> "Oprostite za nevšečnosti, trenutno izvajamo nekaj vzdrževalnih del.<br> Kmalu bomo spet na spletu!",
		"MAINT_BAN"		=> "Oprostite. Bili ste bannani. Če menite, da je to napaka, se obrnite na administratorja.",
		"MAINT_TOK"		=> "Prišlo je do napake z vašim obrazcem. Prosimo, pojdite nazaj in poskusite znova. Upoštevajte, da bo osvežitev strani in posledično ponovno pošiljanje obrazca povzročilo napako. Če se to še naprej dogaja, se obrnite na administratorja.",
		"MAINT_OPEN"	=> "Odprtokodni PHP okvir za upravljanje uporabnikov.",
		"MAINT_PLEASE"	=> "Uspešno ste namestili UserSpice!<br>Če želite ogledati našo dokumentacijo za začetek, obiščite"
		));

		//dataTables Added in 4.4.08
		//NOTE: do not change the words like _START_ between the two _ symbols!
		$lang = array_merge($lang,array(
			"DAT_SEARCH"    => "Iskanje",
			"DAT_FIRST"     => "Prvi",
			"DAT_LAST"      => "Zadnji",
			"DAT_NEXT"      => "Naslednji",
			"DAT_PREV"      => "Prejšnji",
			"DAT_NODATA"    => "V tabeli ni na voljo nobenih podatkov",
			"DAT_INFO"      => "Prikazujem _START_ do _END_ od _TOTAL_ vnosov",
			"DAT_ZERO"      => "Prikazujem 0 do 0 od 0 vnosov",
			"DAT_FILTERED"  => "(filtrirano iz _MAX_ skupnih vnosov)",
			"DAT_MENU_LENG" => "Prikaži _MENU_ vnosov",
			"DAT_LOADING"   => "Nalaganje...",
			"DAT_PROCESS"   => "Obdelava...",
			"DAT_NO_REC"    => "Ni najdenih ustreznih zapisov",
			"DAT_ASC"       => "Aktiviraj za naraščajoče razvrščanje stolpca",
			"DAT_DESC"      => "Aktiviraj za padajoče razvrščanje stolpca",
		));


///////////////////////////////////////////////////////////////

//Backend Translations for UserSpice
$lang = array_merge($lang,array(
"BE_DASH"    	=> "Dashboard",
"BE_SETTINGS"   => "Settings",
"BE_GEN"		=> "General",
"BE_REG"		=> "Registration",
"BE_CUS"		=> "Custom Settings",
"BE_DASH_ACC"	=> "Dashboard Access",
"BE_TOOLS"		=> "Tools",
"BE_BACKUP"		=> "Backup",
"BE_UPDATE"		=> "Updates",
"BE_CRON"		=> "Cron Jobs",
"BE_IP"			=> "IP Manager",
));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
?>
