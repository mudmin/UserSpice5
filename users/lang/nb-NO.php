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

/*
Translation by Scourgess
*/

$lang = array();
//important strings
//You defiitely want to customize these for your language
$lang = array_merge($lang,array(
"THIS_LANGUAGE"	=>"Norsk",
"THIS_CODE"			=>"nb-NO",
"MISSING_TEXT"	=>"Mangler tekst",
));

//Database Menus
$lang = array_merge($lang,array(
"MENU_HOME"			=> "Hjem",
"MENU_HELP"			=> "Hjelp",
"MENU_ACCOUNT"	=> "Konto",
"MENU_DASH"			=> "Kontrollpanel",
"MENU_USER_MGR"	=> "Brukerhåndtering",
"MENU_PAGE_MGR"	=> "Sidehåndtering",
"MENU_PERM_MGR"	=> "Tilgangshåndtering",
"MENU_MSGS_MGR"	=> "Meldingshåndtering",
"MENU_LOGS_MGR"	=> "Systemlogger",
"MENU_LOGOUT"		=> "Logg ut",
));

// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"					=> "Registrer",
	"SIGNUP_BUTTONTEXT"		=> "Registrer meg",
	"SIGNUP_AUDITTEXT"		=> "Registrert",
	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"				=> "** INNLOGGINGSFEIL **",
	"SIGNIN_PLEASE_CHK" => "Vennligst kontroller brukernavnet og passordet ditt og prøv igjen",
	"SIGNIN_UORE"				=> "Brukernavn ELLER e-post",
	"SIGNIN_PASS"				=> "Passord",
	"SIGNIN_TITLE"			=> "Vennligst logg inn",
	"SIGNIN_TEXT"				=> "Logg inn",
	"SIGNOUT_TEXT"			=> "Logg ut",
	"SIGNIN_BUTTONTEXT"	=> "Logg inn",
	"SIGNIN_REMEMBER"		=> "Husk meg",
	"SIGNIN_AUDITTEXT"	=> "Logget på",
	"SIGNIN_FORGOTPASS"	=>"Glemt passord",
	"SIGNOUT_AUDITTEXT"	=> "Logget ut",
	));

// Account Page
$lang = array_merge($lang,array(
	"ACCT_EDIT"					=> "Rediger kontoinformasjon",
	"ACCT_2FA"					=> "Håndter flerfaktor autentisering",
	"ACCT_SESS"					=> "Håndter sesjoner",
	"ACCT_HOME"					=> "Konto hjem",
	"ACCT_SINCE"				=> "Medlem siden",
	"ACCT_LOGINS"				=> "Antall innlogginger",
	"ACCT_SESSIONS"			=> "Antall aktive sesjoner",
	"ACCT_MNG_SES"			=> "Klikk håndter sesjoner knappen i venstre meny for mer informasjon.",
	));

	//General Terms
	$lang = array_merge($lang,array(
		"GEN_ENABLED"			=> "Aktivert",
		"GEN_DISABLED"		=> "Deaktivert",
		"GEN_ENABLE"			=> "Aktiver",
		"GEN_DISABLE"			=> "Deaktiver",
		"GEN_NO"					=> "Nei",
		"GEN_YES"					=> "Ja",
		"GEN_MIN"					=> "min",
		"GEN_MAX"					=> "maks",
		"GEN_CHAR"				=> "bokstaver", //as in characters
		"GEN_SUBMIT"			=> "Send inn",
		"GEN_MANAGE"			=> "Håndter",
		"GEN_VERIFY"			=> "Verifiser",
		"GEN_SESSION"			=> "Sesjon",
		"GEN_SESSIONS"		=> "Sesjoner",
		"GEN_EMAIL"				=> "E-post",
		"GEN_FNAME"				=> "Fornavn",
		"GEN_LNAME"				=> "Etternavn",
		"GEN_UNAME"				=> "Brukernavn",
		"GEN_PASS"				=> "Passord",
		"GEN_MSG"					=> "Melding",
		"GEN_TODAY"				=> "I dag",
		"GEN_CLOSE"				=> "Lukk",
		"GEN_CANCEL"			=> "Avbryt",
		"GEN_CHECK"				=> "[ kryss av/fjern avkrysning på alle ]",
		"GEN_WITH"				=> "med",
		"GEN_UPDATED"			=> "Oppdatert",
		"GEN_UPDATE"			=> "Oppdater",
		"GEN_BY"					=> "av",
		"GEN_FUNCTIONS"		=> "Funksjoner",
		"GEN_NUMBER"			=> "tall",
		"GEN_NUMBERS"			=> "tall",
		"GEN_INFO"				=> "Informasjon",
		"GEN_REC"					=> "Registrert",
		"GEN_DEL"					=> "Slett",
		"GEN_NOT_AVAIL"		=> "Ikke tilgjengelig",
		"GEN_AVAIL"				=> "Tilgjengelig",
		"GEN_BACK"				=> "Tilbake",
		"GEN_RESET"				=> "Nullstill",
		"GEN_REQ"					=> "påkrevd",
		"GEN_AND"					=> "og",
		"GEN_SAME"				=> "må være like",
		));

//validation class
	$lang = array_merge($lang,array(
		"VAL_SAME"				=> "må være like",
		"VAL_EXISTS"			=> "eksisterer allerede. Vennligst velg en annen",
		"VAL_DB"					=> "Databasefeil",
		"VAL_NUM"					=> "må være et tall",
		"VAL_INT"					=> "må være et heltall",
		"VAL_EMAIL"				=> "må være en gyldig e-postadresse",
		"VAL_NO_EMAIL"		=> "kan ikke være en e-postadresse",
		"VAL_SERVER"			=> "må tilhøre en gyldig tjener",
		"VAL_LESS"				=> "må være mindre enn",
		"VAL_GREAT"				=> "må være større enn",
		"VAL_LESS_EQ"			=> "må være mindre eller lik",
		"VAL_GREAT_EQ"		=> "må være større eller lik",
		"VAL_NOT_EQ"			=> "må ikke være lik",
		"VAL_EQ"					=> "må være lik",
		"VAL_TZ"					=> "må være et gyldig navn på en tidssone",
		"VAL_MUST"				=> "må være",
		"VAL_MUST_LIST"		=> "må være en av følgende",
		"VAL_TIME"				=> "må være et gyldig tidsformat",
		"VAL_SEL"					=> "Er ikke et gyldig valg",
		"VAL_NA_PHONE"		=> "må være et gyldig nordamerikansk telefonnummer",
	));

		//Time
	$lang = array_merge($lang,array(
		"T_YEARS"			=> "År",
		"T_YEAR"			=> "År",
		"T_MONTHS"		=> "Måneder",
		"T_MONTH"			=> "Måned",
		"T_WEEKS"			=> "Uker",
		"T_WEEK"			=> "Uke",
		"T_DAYS"			=> "Dager",
		"T_DAY"				=> "Dag",
		"T_HOURS"			=> "Timer",
		"T_HOUR"			=> "Time",
		"T_MINUTES"		=> "Minutter",
		"T_MINUTE"		=> "Minutt",
		"T_SECONDS"		=> "Sekunder",
		"T_SECOND"		=> "Sekund",
		));


		//Passwords
	$lang = array_merge($lang,array(
		"PW_NEW"		=> "Nytt passord",
		"PW_OLD"		=> "Gammelt passord",
		"PW_CONF"		=> "Bekreft passord",
		"PW_RESET"	=> "Nullstill passord",
		"PW_UPD"		=> "Passord oppdatert",
		"PW_SHOULD"	=> "Passord burde...",
		"PW_SHOW"		=> "Vis passord",
		"PW_SHOWS"	=> "Vis passord",
		));


		//Join
	$lang = array_merge($lang,array(
		"JOIN_SUC"			=> "Velkommen til ",
		"JOIN_THANKS"		=> "Takk for registrering!",
		"JOIN_HAVE"			=> "Ha mind ",
		"JOIN_CAP"			=> " stor bokstav",
		"JOIN_TWICE"		=> "Være tastet riktig to ganger",
		"JOIN_CLOSED"		=> "Beklageligvis er registrering for tiden deaktivert. Vennlingst kontakt administratoren av nettsiden dersom du har spørsmål eller bekymringer.",
		"JOIN_TC"				=> "Brukervilkår ved registrering",
		"JOIN_ACCEPTTC" => "Jeg aksepterer brukervilkårene",
		"JOIN_CHANGED"	=> "Våre brukervilkår har blitt endret",
		"JOIN_ACCEPT" 	=> "Aksepter brukervilkårene og fortsett",
		));

		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "Vellyket drap av ",
		));

		//Messages
	$lang = array_merge($lang,array(
		"MSG_SENT"			=> "Meldingen din har blitt sendt!",
		"MSG_MASS"			=> "Massemeldingen din har blitt sendt!",
		"MSG_NEW"				=> "Ny melding",
		"MSG_NEW_MASS"	=> "Massemelding",
		"MSG_CONV"			=> "Samtaler",
		"MSG_NO_CONV"		=> "Ingen samtaler",
		"MSG_NO_ARC"		=> "Ingen samtaler",
		"MSG_QUEST"			=> "Send e-postvarsel dersom aktivert?",
		"MSG_ARC"				=> "Arkiverte tråder",
		"MSG_VIEW_ARC"	=> "Vis arkiverte tråder",
		"MSG_SETTINGS"  => "Meldingsinnstillinger",
		"MSG_READ"			=> "Les",
		"MSG_BODY"			=> "Tekst",
		"MSG_SUB"				=> "Emne",
		"MSG_DEL"				=> "Levert",
		"MSG_REPLY"			=> "Svar",
		"MSG_QUICK"			=> "Hurtigsvar",
		"MSG_SELECT"		=> "Velg en bruker",
		"MSG_UNKN"			=> "Ukjent mottaker",
		"MSG_NOTIF"			=> "E-postvarsel for melding",
		"MSG_BLANK"			=> "Meldingen kan ikke være tom",
		"MSG_MODAL"			=> "Trykk har eller trykk Alt + R for å sette fokus på denne boksen ELLER trykk Skift + R for å åpne det utvidede svarpanelet!",
		"MSG_ARCHIVE_SUCCESSFUL"        => "Arkivering av %m1% tråder var vellykket",
		"MSG_UNARCHIVE_SUCCESSFUL"      => "Dearkivering av %m1% tråder var vellykket",
		"MSG_DELETE_SUCCESSFUL"         => "Sletting av %m1% tråder var vellykket",
		"USER_MESSAGE_EXEMPT"         			=> "Bruker er %m1% unntatt fra meldinger.",
		"MSG_MK_READ"		=> "Lest",
		"MSG_MK_UNREAD"	=> "Ulest",
		"MSG_ARC_THR"		=> "Arkiver valgte tråder",
		"MSG_UN_THR"		=> "Dearkiver valgte tråder",
		"MSG_DEL_THR"		=> "Slett valgte tråder",
		"MSG_SEND"			=> "Send melding",
		));

	//2 Factor Authentication
	$lang = array_merge($lang,array(
		"2FA"				=> "2-Faktorautentisering",
		"2FA_CONF"	=> "Er du sikker på at du vil deaktivere 2FA? Kontoen din vil ikke lengre være beskyttet.",
		"2FA_SCAN"	=> "Scan denne QR-koden med autentiseringsappen din, eller skriv inn nøkkelen",
		"2FA_THEN"	=> "Skriv deretter inn en av dine engangspasssordnøkler her",
		"2FA_FAIL"	=> "Det var et problem med å verifisere 2FA. Vennligst sjekk internett eller kontakt kundestøtte.",
		"2FA_CODE"	=> "2FA Kode",
		"2FA_EXP"		=> "Utgått 1 fingeravtrykk",
		"2FA_EXPD"	=> "Utgått",
		"2FA_EXPS"	=> "Utgår",
		"2FA_ACTIVE"=> "Aktive Sesjoner",
		"2FA_NOT_FN"=> "Ingen fingeravtrykk funnet",
		"2FA_FP"		=> "Fingeravtrykk",
		"2FA_NP"		=> "<strong>Innlogging feilet</strong> Tofaktorautentiseringskode var ikke tilstede. Vennligst prøv på nytt.",
		"2FA_INV"		=> "<strong>Innlogging feilet</strong> Tofaktorautentiseringskode var feil. Vennligst prøv på nytt.",
		"2FA_FATAL"	=> "<strong>Kritisk feil</strong> Vennligst kontakt systemadministratoren.",
		));

	//Redirect Messages - These get a plus between each word
	$lang = array_merge($lang,array(
		"REDIR_2FA"						=> "Sorry.Two+factor+is+not+enabled+at+this+time",
		"REDIR_2FA_EN"				=> "2+Factor+Authentication+Enabled",
		"REDIR_2FA_DIS"				=> "2+Factor+Authentication+Disabled",
		"REDIR_2FA_VER"				=> "2+Factor+Authentication+Verified+and+Enabled",
		"REDIR_SOM_TING_WONG" => "Something+went+wrong.+Please+try+again.",
		"REDIR_MSG_NOEX"			=> "That+thread+does+not+belong+to+you+or+does+not+exist.",
		"REDIR_UN_ONCE"				=> "Username+has+already+been+changed+once.",
		"REDIR_EM_SUCC"				=> "Email+Updated+Successfully",
		));

	//Emails
	$lang = array_merge($lang,array(
		"EML_CONF"			=> "Bekreft e-postadresse",
		"EML_VER"				=> "Verifiser e-posten din",
		"EML_CHK"				=> "E-postforespørsel mottatt. Vennligst sjekk e-posten din for å utføre verifisering. Se i spam og søppelpost ettersom verifiseringlenken utgår om ",
		"EML_MAT"				=> "E-postadressen din tilsvarte ikke.",
		"EML_HELLO"			=> "Hallo fra ",
		"EML_HI"				=> "Hei ",
		"EML_AD_HAS"		=> "En administrator har nullstilt passordet ditt.",
		"EML_AC_HAS"		=> "En administrator har opprettet en konto for deg.",
		"EML_REQ"				=> "Du må sette passordet ditt ved å bruke lenken over.",
		"EML_EXP"				=> "Vennligst merk, passordlenker utgår etter ",
		"EML_VER_EXP"		=> "Vennligst merk, verifiseringslenker utgår etter ",
		"EML_CLICK"			=> "Klikk her for å logge inn.",
		"EML_REC"				=> "Det er anbefalt å endre passordet ved pålogging.",
		"EML_MSG"				=> "Du har en ny melding fra",
		"EML_REPLY"			=> "Trykk her for å svare, eller vise tråden",
		"EML_WHY"				=> "Du mottar denne e-posten fordi en forespørsel om å nullstille passordet ditt ble opprettet. Dersom det ikke var deg kan du se bort fra denne e-posten.",
		"EML_HOW"				=> "Dersom det var deg, trykk på lenken under for å fortsette med å nullstille passordet.",
		"EML_EML"				=> "En forespørsel om å endre e-postadressen din var opprettet fra brukerokontoen din.",
		"EML_VER_EML"		=> "Takk for at du registrerte deg.  Med en gang du har verifisert e-postadressen din kan du logge inn! Vennligst klikk på linken under for å verifisere e-postadressen din.",

		));

		//Verification
		$lang = array_merge($lang,array(
			"VER_SUC"			=> "E-postadressen din har blitt verifisert!",
			"VER_FAIL"		=> "Vi kunne ikke verifisere kontoen din. Vennligst prøv igjen.",
			"VER_RESEND"	=> "Send ny e-post med verifisering",
			"VER_AGAIN"		=> "Skriv inn e-postadressen din og prøv igjen",
			"VER_PAGE"		=> "<li>Sjekk e-posten din og kikk på lenken som du har fått tilsendt</li><li>Ferdig</li>",
			"VER_RES_SUC" => "<p>En verifiseringslenke har blitt sendt til e-postadressen din.</p><p>Trykk på lenken i e-posten for å fullføre verifiseringen. Se i søppelpost dersom e-posten ikke er i innboksen din.</p><p>Verifiseringslenker er kun gyldige i ",
			"VER_OOPS"		=> "Oops...noe gikk galt, kanskje du brukte en utgått link. Trykk under for å prøve på nytt",
			"VER_RESET"		=> "Passordet ditt har blitt nullstilt!",
			"VER_INS"			=> "<li>Skriv inn e-postadressen og klikk nullstill</li> <li>Se i e-posten din og klikk på lenken som du har fått tilsendt.</li>
												<li>Følg instruksjonene som vises på skjermen</li>",
			"VER_SENT"		=> "<p>Link for å nullstille passordet ditt har blitt sendt til e-postadressen din.</p>
			    							<p>Trykk på linken i e-posten for å nullstille passordet ditt. Se i søppelpost dersom e-posten ikke ligger i innboksen din.</p><p>Passordlenker er kun gyldige i ",
			"VER_PLEASE"	=> "Vennligst bytt passordet ditt",
			));

	//User Settings
	$lang = array_merge($lang,array(
		"SET_PIN"				=> "Nullstill PIN",
		"SET_WHY"				=> "Hvorfor kan jeg ikke endre dette?",
		"SET_PW_MATCH"	=> "Må tilsvare det nye passordet",

		"SET_PIN_NEXT"	=> "Du kan sette en ny PIN til neste gang du trenger verifisering",
		"SET_UPDATE"		=> "Oppdater brukerinnstillingine dine",
		"SET_NOCHANGE"	=> "Administratoren har deaktivert endring av brukernavn.",
		"SET_ONECHANGE"	=> "Administratoren har satt opp endring av brukernavn til å kun kunne skje en gang, og du har allerede endret brukernavnet en gang.",

		"SET_GRAVITAR"	=> "<strong>Har du lyst til å endre profilbildet? </strong><br> Besøk <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> og opprett en konto med samme e-postadresse som du har på denne nettsiden. Det fungerer på millioner av nettsider. Det er raskt og enkelt!",

		"SET_NOTE1"			=> "<p><strong>Vennligst merk</strong> det foreligger en ventende anmodning for oppdatering av e-postadressen din til",

		"SET_NOTE2"			=> ".</p><p>Vennligst bruk verifiseringen tilsendt på e-post for å fullføre denne forespørselen.</p>
		<p>Dersom du trenger en ny verifiseringse-post, vennligst skriv inn e-posten over og utfør forespørselen på nytt.</p>",

		"SET_PW_REQ" 		=> "påkrevd for å endre passord, e-post, eller nullstille PIN",
		"SET_PW_REQI" 	=> " Må endre passordet ditt",

		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"		=> "Klarte ikke å drepe aktive sesjoner, feil: ",
		"ERR_EMAIL"				=> "E-post IKKE sendt grunnet en feil. Vennligst kontakt administratoren.",
		"ERR_EM_DB"				=> "Den e-postadressen eksisterer ikke i vår database",
		"ERR_TC"					=> "Vennligst les og aksepter brukervilkårene",
		"ERR_CAP"					=> "Du klarte ikke Captcha-testen, robot!",
		"ERR_PW_SAME"			=> "Det nye passordet ditt kan ikke være det samme som det gamle",
		"ERR_PW_FAIL"			=> "Feil ved verifisering av gjeldende passord. Oppdateringsfeil. Vennligst prøv igjen.",
		"ERR_GOOG"				=> "<strong>MERK:</strong> Dersom du først registrerte deg med en Google eller Facebook konto må du bruke glemt passord-linken for å bytte passordet ditt...hvis ikke du er veldig god til å gjette.",
		"ERR_EM_VER"			=> "E-postverifisering er ikke aktivert. Vennligst kontakt systemadministratoren.",
		"ERR_EMAIL_STR"		=> "Noe rart har skjedd. Vennligst verifiser e-postadressen din på nytt. Vi beklager ulempen",

		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"		=> "Vi er snart tilbake",
		"MAINT_MSG"			=> "Beklager ulempen. Vi utfører litt vedlikehold akkurat nå.<br> Vi er straks tilbake!",
		"MAINT_BAN"			=> "Beklager. Du har blitt utestengt. Dersom du anser dette som en feil, vennligst kontakt administratoren.",
		"MAINT_TOK"			=> "Det er en feil med skjemaet ditt. Vennligst gå tilbake og prøv igjen. Merk at det vil oppstå en feil dersom du frisker opp siden på nytt. Dersom denne feilen vedvarer, vennligst kontakt administratoren.",
		"MAINT_OPEN"		=> "Et åpen kildekode brukerhåndteringsrammeverk.",
		"MAINT_PLEASE"	=> "Installasjonen av UserSpice var vellykket!<br>For vår kom-i-gang dokumentasjon, vennligst besøk"
		));

		//dataTables Added in 4.4.08
		//NOTE: do not change the words like _START_ between the two _ symbols!
		$lang = array_merge($lang,array(
		"DAT_SEARCH"    => "Søk",
		"DAT_FIRST"     => "Første",
		"DAT_LAST"      => "Siste",
		"DAT_NEXT"      => "Neste",
		"DAT_PREV"      => "Forrige",
		"DAT_NODATA"        => "Ingen data tilgjengelig i tabellen",
		"DAT_INFO"          => "Viser _START_ til _END_ av _TOTAL_ oppføringer",
		"DAT_ZERO"          => "Viser 0 til 0 av 0 oppføringer",
		"DAT_FILTERED"      => "(filtrert fra _MAX_ oppføringer)",
		"DAT_MENU_LENG"     => "Vis _MENU_ oppføringer",
		"DAT_LOADING"       => "Laster...",
		"DAT_PROCESS"       => "Prosesserer...",
		"DAT_NO_REC"        => "Ingen samsvarende oppføringer funnet",
		"DAT_ASC"           => "Aktiver for å sortere kolonner stigende",
		"DAT_DESC"          => "Aktiver for å sortere kolonner synkende",
		));


///////////////////////////////////////////////////////////////

//Backend Translations for UserSpice
$lang = array_merge($lang,array(
"BE_DASH"    			=> "Dashboard",
"BE_SETTINGS"     => "Innstillinger",
"BE_GEN"					=> "Generelt",
"BE_REG"					=> "Registrering",
"BE_CUS"					=> "Tilpassede Innstillinger",
"BE_DASH_ACC"			=> "Dashboard Access",
"BE_TOOLS"				=> "Verktøy",
"BE_BACKUP"				=> "Sikkerhetskopi",
"BE_UPDATE"				=> "Oppdateringer",
"BE_CRON"				  => "Cron-jobber",
"BE_IP"				  	=> "IP-håndtering",
));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
 //do not put a closing php tag here
