<?php
/*
Do not put any content above the opening PHP tag
/**
      Afrikaans Translation by John Dovey <boondock@criptext.com>
      v 1.0: 8 January 2021
      Any suggestions for improvements greately appreciated
**/
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
"THIS_LANGUAGE"	=>"Afrikaans",
"THIS_CODE"	=>"af-AF",
"MISSING_TEXT"	=>"Ontbrekende teks",
));

//Database Menus
$lang = array_merge($lang,array(
"MENU_HOME"	=> "Tuis",
"MENU_HELP"	=> "Hulp",
"MENU_ACCOUNT"	=> "Rekening",
"MENU_DASH"	=> "Beheerpaneel",
"MENU_USER_MGR"	=> "Gebruikersbestuur",
"MENU_PAGE_MGR"	=> "Bladsybestuur",
"MENU_PERM_MGR"	=> "Toestemmingsbestuur",
"MENU_MSGS_MGR"	=> "Toestemmingsbestuur",
"MENU_LOGS_MGR"	=> "Stelsellogboeke",
"MENU_LOGOUT"	=> "Afmeld",
));

// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"		=> "Registreer",
	"SIGNUP_BUTTONTEXT"	=> "Registreer my",
	"SIGNUP_AUDITTEXT"	=> "Geregistreer",
	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"		=> "** MISLUKTE AANMELDING **",
	"SIGNIN_PLEASE_CHK" 	=> "Gaan u gebruikersnaam en wagwoord na en probeer weer",
	"SIGNIN_UORE"		=> "Gebruikersnaam OF E-pos",
	"SIGNIN_PASS"		=> "Wagwoord",
	"SIGNIN_TITLE"		=> "Meld u asseblief aan",
	"SIGNIN_TEXT"		=> "Meld aan",
	"SIGNOUT_TEXT"		=> "Afmeld",
	"SIGNIN_BUTTONTEXT"	=> "Teken in",
	"SIGNIN_REMEMBER"	=> "Onthou my",
	"SIGNIN_AUDITTEXT"	=> "Aangemeld",
	"SIGNIN_FORGOTPASS"	=>"Wagwoord vergeet",
	"SIGNOUT_AUDITTEXT"	=> "Uitgeteken",
	));

// Account Page
$lang = array_merge($lang,array(
	"ACCT_EDIT"		=> "Wysig rekeninginligting",
	"ACCT_2FA"		=> "Bestuur 2-faktor-verifikasie",
	"ACCT_SESS"		=> "Sessies bestuur",
	"ACCT_HOME"		=> "Rekening tuis",
	"ACCT_SINCE"		=> "Lid sedert",
	"ACCT_LOGINS"		=> "Aantal aanmeldings",
	"ACCT_SESSIONS"		=> "Aantal aktiewe sessies",
	"ACCT_MNG_SES"		=> "Klik op die knoppie Beheer sessies in die linker sidebalk vir meer inligting.",
	));

	//General Terms
	$lang = array_merge($lang,array(
	"GEN_ENABLED"		=> "Geaktiveer",
	"GEN_DISABLED"		=> "Uitgeskakel",
	"GEN_ENABLE"		=> "Aktiveer",
	"GEN_DISABLE"		=> "Deaktiveer",
	"GEN_NO"		=> "Nee",
	"GEN_YES"		=> "Ja",
	"GEN_MIN"		=> "min",
	"GEN_MAX"		=> "max",
	"GEN_CHAR"		=> "Karakters", //soos in karakters
	"GEN_SUBMIT"		=> "Dien in",
	"GEN_MANAGE"		=> "Bestuur",
	"GEN_VERIFY"		=> "Verifieer",
	"GEN_SESSION"		=> "Sessie",
	"GEN_SESSIONS"		=> "Sessies",
	"GEN_EMAIL"		=> "E-pos",
	"GEN_FNAME"		=> "Voornaam",
	"GEN_LNAME"		=> "Van",
	"GEN_UNAME"		=> "Gebruikersnaam",
	"GEN_PASS"		=> "Wagwoord",
	"GEN_MSG"		=> "Boodskap",
	"GEN_TODAY"		=> "Vandag",
	"GEN_CLOSE"		=> "Sluit",
	"GEN_CANCEL"		=> "Kanselleer",
	"GEN_CHECK"		=> "[ merk / vink alles uit ]",
	"GEN_WITH"		=> "met",
	"GEN_UPDATED"		=> "Opgedateer",
	"GEN_UPDATE"		=> "Opdatering",
	"GEN_BY"		=> "deur",
	"GEN_FUNCTIONS"		=> "Funksies",
	"GEN_NUMBER"		=> "nommer",
	"GEN_NUMBERS"		=> "getalle",
	"GEN_INFO"		=> "Inligting",
	"GEN_REC"		=> "Opgeneem",
	"GEN_DEL"		=> "Vee uit",
	"GEN_NOT_AVAIL"		=> "Nie beskikbaar nie",
	"GEN_AVAIL"		=> "Beskikbaar",
	"GEN_BACK"		=> "Terug",
	"GEN_RESET"		=> "Herstel",
	"GEN_REQ"		=> "vereis",
	"GEN_AND"		=> "en",
	"GEN_SAME"		=> "moet dieselfde wees",
		));

//validation class
	$lang = array_merge($lang,array(
	"VAL_SAME"		=> "moet dieselfde wees",
	"VAL_EXISTS"		=> "bestaan reeds. Kies 'n ander",
	"VAL_DB"		=> "Databasisfout",
	"VAL_NUM"		=> "moet 'n getal wees",
	"VAL_INT"		=> "moet 'n heel getal wees",
	"VAL_EMAIL"		=> "moet 'n geldige e-posadres wees",
	"VAL_NO_EMAIL"		=> "kan nie 'n e-posadres wees nie",
	"VAL_SERVER"		=> "moet aan 'n geldige bediener behoort",
	"VAL_LESS"		=> "moet minder wees as",
	"VAL_GREAT"		=> "moet groter wees as",
	"VAL_LESS_EQ"		=> "moet kleiner as of gelyk wees aan",
	"VAL_GREAT_EQ"		=> "moet groter as of gelyk wees aan",
	"VAL_NOT_EQ"		=> "mag nie gelyk wees aan",
	"VAL_EQ"		=> "moet gelyk wees aan",
	"VAL_TZ"		=> "moet 'n geldige tydsone benoem",
	"VAL_MUST"		=> "moet wees",
	"VAL_MUST_LIST"		=> "moet een van die volgende wees",
	"VAL_TIME"		=> "moet 'n geldige tyd wees",
	"VAL_SEL"		=> "is nie 'n geldige keuse nie",
	"VAL_NA_PHONE"		=> "moet 'n geldige Noord-Amerikaanse telefoonnommer wees",
	));

		//Time
	$lang = array_merge($lang,array(
	"T_YEARS"		=> "Jare",
	"T_YEAR"		=> "Jaar",
	"T_MONTHS"		=> "Maande",
	"T_MONTH"		=> "Maand",
	"T_WEEKS"		=> "Weke",
	"T_WEEK"		=> "Week",
	"T_DAYS"		=> "Dae",
	"T_DAY"			=> "Dag",
	"T_HOURS"		=> "Ure",
	"T_HOUR"		=> "Uur",
	"T_MINUTES"		=> "Minuute",
	"T_MINUTE"		=> "Minuut",
	"T_SECONDS"		=> "Sekondes",
	"T_SECOND"		=> "Sekond",
		));


		//Passwords
	$lang = array_merge($lang,array(
	"PW_NEW"		=> "Nuwe wagwoord",
	"PW_OLD"		=> "Ou wagwoord",
	"PW_CONF"		=> "Bevestig wagwoord",
	"PW_RESET"		=> "Stel wagwoord terug",
	"PW_UPD"		=> "Wagwoord opgedateer",
	"PW_SHOULD"		=> "Wagwoorde moet ...",
	"PW_SHOW"		=> "Wys wagwoord",
	"PW_SHOWS"		=> "Wys wagwoorde",
		));


		//Join
	$lang = array_merge($lang,array(
	"JOIN_SUC"		=> "Welkom by ",
	"JOIN_THANKS"		=> "Dankie dat u geregistreer het!",
	"JOIN_HAVE"		=> "Het ten minste ",
	"JOIN_CAP"		=> " hoofletter",
	"JOIN_TWICE"		=> "Word twee keer korrek getik",
	"JOIN_CLOSED"		=> "Registrasie is op hierdie stadium ongelukkig uitgeskakel. Kontak asseblief die webwerfadministrateur as u enige vrae of probleme het.",
	"JOIN_TC"		=> "Registrasiegebruikersvoorwaardes",
	"JOIN_ACCEPTTC" 	=> "Ek aanvaar gebruikersbepalings en -voorwaardes",
	"JOIN_CHANGED"		=> "Ons bepalings het verander",
	"JOIN_ACCEPT" 		=> "Aanvaar gebruikersbepalings en gaan voort",
		));

		//Sessions
	$lang = array_merge($lang,array(
	"SESS_SUC"		=> "Suksesvol uitgewis ", // Suksesvol doodgemaak
		));

		//Messages
	$lang = array_merge($lang,array(
	"MSG_SENT"		=> "U boodskap is gestuur!",
	"MSG_MASS"		=> "U massaboodskap is gestuur!",
	"MSG_NEW"		=> "Nuwe boodskap",
	"MSG_NEW_MASS"		=> "Nuwe massaboodskap",
	"MSG_CONV"		=> "Nuwe massaboodskap",
	"MSG_NO_CONV"		=> "Geen gesprekke",
	"MSG_NO_ARC"		=> "Geen gesprekke",
	"MSG_QUEST"		=> "Stuur e-poskennisgewing as dit geaktiveer is?",
	"MSG_ARC"		=> "Gearchiveerde drade",
	"MSG_VIEW_ARC"		=> "Bekyk argiewe drade",
	"MSG_SETTINGS"  	=> "Boodskapinstellings",
	"MSG_READ"		=> "Gelees",
	"MSG_BODY"		=> "Liggaam",
	"MSG_SUB"		=> "Onderwerp",
	"MSG_DEL"		=> "Afgelewer",
	"MSG_REPLY"		=> "Antwoord",
	"MSG_QUICK"		=> "Vinnige antwoord",
	"MSG_SELECT"		=> "Kies 'n gebruiker",
	"MSG_UNKN"		=> "Onbekende ontvanger",
	"MSG_NOTIF"		=> "E-poskennisgewings vir boodskappe",
	"MSG_BLANK"		=> "Boodskap kan nie leeg wees nie",
	"MSG_MODAL"		=> "Klik hier of druk op Alt + R om op hierdie kassie te fokus OF druk op Shift + R om die uitgebreide antwoordvenster te open!",
	"MSG_ARCHIVE_SUCCESSFUL"	=> "U het %m1% drade suksesvol geargiveer",
	"MSG_UNARCHIVE_SUCCESSFUL"      => "U het %m1% drade suksesvol gedeargiveer",
	"MSG_DELETE_SUCCESSFUL"         => "U het %m1% drade suksesvol uitgevee",
	"USER_MESSAGE_EXEMPT"         	=> "Gebruiker is %m1% vrygestel van boodskappe.",
	"MSG_MK_READ"		=> "Gelees",
	"MSG_MK_UNREAD"		=> "Ongelees",
	"MSG_ARC_THR"		=> "Argiveer geselekteerde drade",
	"MSG_UN_THR"		=> "Uittrek van geselekteerde onderwerpe",
	"MSG_DEL_THR"		=> "Verwyder geselekteerde onderwerpe",
	"MSG_SEND"		=> "Stuur boodskap",
		));

	//2 Factor Authentication
	$lang = array_merge($lang,array(
	"2FA"				=> "2-faktor-verifikasie",
	"2FA_CONF"	=> "Is u seker dat u 2FA wil deaktiveer? U rekening sal nie meer beskerm word nie.",
	"2FA_SCAN"	=> "Skandeer hierdie QR-kode met u verifikasieprogram of voer die sleutel in",
	"2FA_THEN"	=> "Voer dan een van u eenmalige sleutelwoorde hier in",
	"2FA_FAIL"	=> "Kon nie 2FA verifieer nie. Gaan die internet na of kontak die ondersteuning.",
	"2FA_CODE"	=> "2FA-kode",
	"2FA_EXP"	=> "1 vingerafdruk verval",
	"2FA_EXPD"	=> "Verstreken",
	"2FA_EXPS"	=> "Verval",
	"2FA_ACTIVE"	=> "Aktiewe sessies",
	"2FA_NOT_FN"	=> "Geen vingerafdrukke gevind nie",
	"2FA_FP"	=> "Vingerafdrukke",
	"2FA_NP"	=> "<strong>Aanmelding het misluk </strong> Twee faktor-outentiekode was nie beskikbaar nie. Probeer asseblief weer.",
	"2FA_INV"	=> "<strong> Aanmelding het misluk </strong> Auth-kode met twee faktore was ongeldig. Probeer asseblief weer.",
	"2FA_FATAL"	=> "<strong> fatale fout </strong> Kontak asseblief die stelselbeheerder.",
		));

	//Redirect Messages - These get a plus between each word
  // It seems pointless to me to translate these. Feel free to contribute, Voel Vry!
	$lang = array_merge($lang,array(
	"REDIR_2FA"		=> "Sorry.Two+factor+is+not+enabled+at+this+time",
	"REDIR_2FA_EN"		=> "2+Factor+Authentication+Enabled",
	"REDIR_2FA_DIS"		=> "2+Factor+Authentication+Disabled",
	"REDIR_2FA_VER"		=> "2+Factor+Authentication+Verified+and+Enabled",
	"REDIR_SOM_TING_WONG"	=> "Something+went+wrong.+Please+try+again.",
	"REDIR_MSG_NOEX"	=> "That+thread+does+not+belong+to+you+or+does+not+exist.",
	"REDIR_UN_ONCE"		=> "Username+has+already+been+changed+once.",
	"REDIR_EM_SUCC"		=> "Email+Updated+Successfully",
		));

	//Emails
	$lang = array_merge($lang,array(
	"EML_CONF"		=> "Bevestig e-posadres",
	"EML_VER"		=> "Verifieer u e-posadres",
	"EML_CHK"		=> "E-posversoek ontvang. Gaan asseblief u e-pos na om verifikasie uit te voer. Gaan seker dat u die strooipos van spam en rommel nagaan, aangesien die verifikasieskakel verval ",
	"EML_MAT"		=> "U e-posadres stem nie ooreen nie.",
	"EML_HELLO"		=> "Hallo van ",
	"EML_HI"		=> "Hallo ",
	"EML_AD_HAS"		=> "\'n Administrateur het u wagwoord teruggestel.", // backslash escaped the single apostrophe
	"EML_AC_HAS"		=> "\'n Administrateur het u rekening geskep.",      // backslash escaped the single apostrophe
	"EML_REQ"		=> "U sal u wagwoord moet instel met behulp van die skakel hierbo.",
	"EML_EXP"		=> "Let wel, wagwoordskakels verval in ",
	"EML_VER_EXP"		=> "Let wel, verifikasie skakels verval in ",
	"EML_CLICK"		=> "Klik hier om aan te meld.",
	"EML_REC"		=> "Dit word aanbeveel om u wagwoord te verander na aanmelding.",
	"EML_MSG"		=> "U het 'n nuwe boodskap van",
	"EML_REPLY"		=> "Klik hier om te antwoord of die draad te sien",
	"EML_WHY"		=> "U ontvang hierdie e-pos omdat daar versoek is om u wagwoord terug te stel. As dit nie u was nie, kan u hierdie e-pos ignoreer.",
	"EML_HOW"		=> "As dit u was, klik op die onderstaande skakel om voort te gaan met die herstel van die wagwoord.",
	"EML_EML"		=> "'n Versoek om u e-posadres te verander, is vanuit u gebruikersrekening gerig.", // backslash escaped the single apostrophe
	"EML_VER_EML"		=> "Dankie dat u ingeteken het. Sodra u u e-posadres geverifieer het, is u gereed om aan te meld! Klik op die skakel hieronder om u e-posadres te verifieer.",

		));

		//Verification
		$lang = array_merge($lang,array(
	"VER_SUC"		=> "U e-posadres is geverifieer!",
	"VER_FAIL"		=> "Ons kon nie u rekening verifieer nie. Probeer asseblief weer.",
	"VER_RESEND"		=> "Stuur verifikasie-e-pos weer",
	"VER_AGAIN"		=> "Voer u e-posadres in en probeer weer",
	"VER_PAGE"		=> "<li> Gaan u e-pos na en klik op die skakel wat aan u gestuur word </li> <li> Klaar </li>",
	"VER_RES_SUC" 		=> "<p> U verifikasieskakel is na u e-posadres gestuur. </p> <p> Klik op die skakel in die e-posadres om die verifikasie te voltooi. Kontroleer u strooiposmap as die e-pos nie in u posbus. </p> <p> Verifikasie skakels is slegs geldig vir ",
	"VER_OOPS"		=> "Oeps ... iets het verkeerd gegaan, miskien 'n ou reset-skakel waarop u geklik het. Klik hieronder om weer te probeer",
	"VER_RESET"		=> "U wagwoord is herstel!",
	"VER_INS"		=> "<li> Voer u e-posadres in en klik op Herstel </li>
					<li> Kontroleer u e-posadres en klik op die skakel wat aan u gestuur word. </li>
					<li> Volg die instruksies op die skerm </li> ",
	"VER_SENT"		=> "<p> U skakel vir die herstel van wagwoord is na u e-posadres gestuur. </p>
					<p> Klik op die skakel in die e-pos om u wagwoord terug te stel. Maak seker dat u u strooipos van die strooipos nagaan as die e-pos nie in u posbus is nie. </p>
					<p> Terugstelskakels is slegs geldig vir ",
	"VER_PLEASE"		=> "Stel u wagwoord asseblief terug",
			));

	//User Settings
	$lang = array_merge($lang,array(
	"SET_PIN"	=> "Stel PIN terug",
	"SET_WHY"	=> "Waarom kan ek dit nie verander nie?",
	"SET_PW_MATCH"	=> "Moet ooreenstem met die nuwe wagwoord",
	"SET_PIN_NEXT"	=> "U kan 'n nuwe PIN instel die volgende keer as u verifikasie benodig",
	"SET_UPDATE"	=> "Dateer u gebruikersinstellings op",
	"SET_NOCHANGE"	=> "Die administrateur het veranderende gebruikersname uitgeskakel.",
	"SET_ONECHANGE"	=> "Die administrateur het ingestel dat gebruikersnaamveranderings slegs een keer plaasvind en u het dit al gedoen.",
	"SET_GRAVITAR"	=> "<strong> Wil u profielfoto verander? </strong> <br>Besoek <a href='https://af.gravatar.com/'>https://en.gravatar.com/</a> en stel 'n rekening op met dieselfde e-pos as wat u op hierdie webwerf gebruik het. Dit werk op miljoene webwerwe. Dit is vinnig en maklik! ",
	"SET_NOTE1"	=> "<p> <strong> Let wel </strong> daar is 'n hangende versoek om u e-pos op te dateer na",
	"SET_NOTE2"	=> ". </p> <p> Gebruik die verifikasie-e-pos om hierdie versoek te voltooi. </p>
				<p> As u 'n nuwe verifikasie-e-posadres benodig, voer dan weer die e-pos hierbo in en dien die versoek weer in. </p>",
	"SET_PW_REQ" 	=> "benodig om wagwoord, e-posadres te verander of PIN te herstel",
	"SET_PW_REQI" 	=> "Vereis om u wagwoord te verander",

		));

	//Errors
	$lang = array_merge($lang,array(
	"ERR_FAIL_ACT"	=> "Kon nie aktiewe sessies doodmaak nie, fout: ",
	"ERR_EMAIL"	=> "E-pos word NIE gestuur as gevolg van 'n fout nie. Kontak die webwerfadministrateur.",
	"ERR_EM_DB"	=> "Die e-posadres bestaan nie in ons databasis nie",
	"ERR_TC"	=> "Lees en aanvaar asseblief die bepalings en voorwaardes",
	"ERR_CAP"	=> "U het die Captcha-toets misluk, Robot!",
	"ERR_PW_SAME"	=> "U ou wagwoord kan nie dieselfde wees as u nuwe nie",
	"ERR_PW_FAIL"	=> "Huidige wagwoordverifikasie het misluk. Opdatering het misluk. Probeer asseblief weer.",
	"ERR_GOOG"	=> "<strong> OPMERKING: </strong> As u oorspronklik by u Google / Facebook-rekening aangemeld het, moet u die skakel vir vergeet wagwoord gebruik om u wagwoord te verander ... tensy u regtig goed is met raai. ",
	"ERR_EM_VER"	=> "E-posverifikasie is nie geaktiveer nie. Kontak asseblief die stelseladministrateur.",
	"ERR_EMAIL_STR"	=> "Iets is vreemd. Verifieer asseblief u e-pos weer. Ons is jammer oor die ongerief",
		));

	//Maintenance Page
	$lang = array_merge($lang,array(
	"MAINT_HEAD"	=> "Ons sal binnekort weer terugkom!",
	"MAINT_MSG"	=> "Jammer vir die ongerief, maar ons is op die oomblik besig met onderhoud. <br> Ons sal binnekort weer aanlyn wees!",
	"MAINT_BAN"	=> "Jammer. U is verban. Kontak die administrateur as u meen dat dit 'n fout is.",
	"MAINT_TOK"	=> "Daar was 'n fout met u vorm. Gaan terug en probeer weer. Let daarop dat die indien van die vorm deur die bladsy te verfris 'n fout sal veroorsaak. As dit aanhou gebeur, kontak die administrateur.",
	"MAINT_OPEN"	=> "\'n Open source PHP-gebruikersbestuurraamwerk.",
	"MAINT_PLEASE"	=> "U het UserSpice suksesvol geïnstalleer! <br>  Om aan die slag te kom met dokumentasie, Besoek graag "
		));

	//dataTables Added in 4.4.08
	//NOTE: do not change the words like _START_ between the two _ symbols!
	$lang = array_merge($lang,array(
	"DAT_SEARCH"	=> "Soek",
	"DAT_FIRST"	=> "Eerste",
	"DAT_LAST"	=> "Laaste",
	"DAT_NEXT"	=> "Volgende",
	"DAT_PREV"	=> "Vorige",
	"DAT_NODATA"	=> "Geen data beskikbaar in tabel",
	"DAT_INFO"	=> "Wys _START_ tot _END_ van _TOTAL_ inskrywings",
	"DAT_ZERO"	=> "Vertoon 0 tot 0 van 0 inskrywings",
	"DAT_FILTERED"	=> "(gefilter uit _MAX_ totale inskrywings)",
	"DAT_MENU_LENG"	=> "Wys _MENU_ inskrywings",
	"DAT_LOADING"	=> "Laai ...",
	"DAT_PROCESS"	=> "Verwerk ...",
	"DAT_NO_REC"	=> "Geen ooreenstemmende rekords gevind nie",
	"DAT_ASC"	=> "Aktiveer om kolom oplopend te sorteer",
	"DAT_DESC"	=> "Aktiveer om kolom dalend te sorteer",
		));


///////////////////////////////////////////////////////////////

//Backend Translations for UserSpice
$lang = array_merge($lang,array(
"BE_DASH"	=> "Dashboard",
"BE_SETTINGS"	=> "Instellings",
"BE_GEN"	=> "Algemeen",
"BE_REG"	=> "Registrasie",
"BE_CUS"	=> "Aangepaste instellings",
"BE_DASH_ACC"	=> "Dashboard toegang",
"BE_TOOLS"	=> "Gereedskap",
"BE_BACKUP"	=> "Rugsteun",
"BE_UPDATE"	=> "Updates",
"BE_CRON"	=> "Cron Jobs",
"BE_IP"		=> "IP bestuurder",
));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
 //do not put a closing php tag here
