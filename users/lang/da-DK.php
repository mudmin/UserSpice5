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

$lang = array();
//important strings
//You defiitely want to customize these for your language
$lang = array_merge($lang,array(
"THIS_LANGUAGE"	=>"Dansk",
"THIS_CODE"			=>"da-DK",
"MISSING_TEXT"	=>"Manglende tekst",
));

//Database Menus
$lang = array_merge($lang,array(
"MENU_HOME"			=> "Hjem",
"MENU_HELP"			=> "Hjælp",
"MENU_ACCOUNT"	=> "Konto",
"MENU_DASH"			=> "Admin Instrumentbræt",
"MENU_USER_MGR"	=> "Brugeradministration",
"MENU_PAGE_MGR"	=> "Administration af sider",
"MENU_PERM_MGR"	=> "Administration af tilladelser",
"MENU_MSGS_MGR"	=> "Meddelelseshåndtering",
"MENU_LOGS_MGR"	=> "Systemlogfiler",
"MENU_LOGOUT"		=> "Log Ud",
));

// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"					=> "Registrer",
	"SIGNUP_BUTTONTEXT"		=> "Registrer Mig",
	"SIGNUP_AUDITTEXT"		=> "Registreret",
	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"				=> "** LOGIND FEJLEDE **",
	"SIGNIN_PLEASE_CHK" => "Tjek venligst dit brugernavn og din adgangskode, og prøv igen",
	"SIGNIN_UORE"				=> "Brugernavn ELLER Email",
	"SIGNIN_PASS"				=> "Adgangskode",
	"SIGNIN_TITLE"			=> "Log venligst ind",
	"SIGNIN_TEXT"				=> "Log Ind",
	"SIGNOUT_TEXT"			=> "Log Ud",
	"SIGNIN_BUTTONTEXT"	=> "Log Ind",
	"SIGNIN_REMEMBER"		=> "Husk mig",
	"SIGNIN_AUDITTEXT"	=> "Logget ind",
	"SIGNIN_FORGOTPASS"	=>"Glemt adgangskode",
	"SIGNOUT_AUDITTEXT"	=> "Logget ud",
	));

// Account Page
$lang = array_merge($lang,array(
	"ACCT_EDIT"					=> "Rediger kontooplysninger",
	"ACCT_2FA"					=> "Administrer 2-faktor-godkendelse",
	"ACCT_SESS"					=> "Administrer sessioner",
	"ACCT_HOME"					=> "Konto Hjem",
	"ACCT_SINCE"				=> "Medlem siden",
	"ACCT_LOGINS"				=> "Antal logins",
	"ACCT_SESSIONS"			=> "Antal aktive sessioner",
	"ACCT_MNG_SES"			=> "Klik på knappen Administrer sessioner i venstre sidepanel for at få flere oplysninger.",
	));

	//General Terms
	$lang = array_merge($lang,array(
		"GEN_ENABLED"			=> "Aktiveret",
		"GEN_DISABLED"		=> "Deaktiveret",
		"GEN_ENABLE"			=> "Aktiver",
		"GEN_DISABLE"			=> "Deaktiver",
		"GEN_NO"					=> "Nej",
		"GEN_YES"					=> "Ja",
		"GEN_MIN"					=> "min",
		"GEN_MAX"					=> "max",
		"GEN_CHAR"				=> "Karakter", //as in characters
		"GEN_SUBMIT"			=> "Indsend",
		"GEN_MANAGE"			=> "Administrer",
		"GEN_VERIFY"			=> "Verificer",
		"GEN_SESSION"			=> "Session",
		"GEN_SESSIONS"		=> "Sessioner",
		"GEN_EMAIL"				=> "Email",
		"GEN_FNAME"				=> "Fornavn",
		"GEN_LNAME"				=> "Efternavn",
		"GEN_UNAME"				=> "Brugernavn",
		"GEN_PASS"				=> "Adgangskode",
		"GEN_MSG"					=> "Besked",
		"GEN_TODAY"				=> "I dag",
		"GEN_CLOSE"				=> "Luk",
		"GEN_CANCEL"			=> "Afbryd",
		"GEN_CHECK"				=> "[ tjek/fjern markeringen af alle ]",
		"GEN_WITH"				=> "Med",
		"GEN_UPDATED"			=> "Opdateret",
		"GEN_UPDATE"			=> "Opdatering",
		"GEN_BY"					=> "Ved",
		"GEN_FUNCTIONS"		=> "Funktioner",
		"GEN_NUMBER"			=> "Tal",
		"GEN_NUMBERS"			=> "Tal",
		"GEN_INFO"				=> "Information",
		"GEN_REC"					=> "Registreret",
		"GEN_DEL"					=> "Slet",
		"GEN_NOT_AVAIL"		=> "Ikke tilgængelig",
		"GEN_AVAIL"				=> "Tilgængelig",
		"GEN_BACK"				=> "Tilbage",
		"GEN_RESET"				=> "Nulstille",
		"GEN_REQ"					=> "Kræves",
		"GEN_AND"					=> "Og",
		"GEN_SAME"				=> "Skal være det samme",
		));

//validation class
	$lang = array_merge($lang,array(
		"VAL_SAME"				=> "Skal være det samme",
		"VAL_EXISTS"			=> "Findes allerede. Vælg venligst en anden",
		"VAL_DB"					=> "Databasefejl",
		"VAL_NUM"					=> "Skal være et tal",
		"VAL_INT"					=> "Skal være et helt tal",
		"VAL_EMAIL"				=> "Skal være en gyldig e-mailadresse",
		"VAL_NO_EMAIL"		=> "Kan ikke være en e-mailadresse",
		"VAL_SERVER"			=> "Skal tilhøre en gyldig server",
		"VAL_LESS"				=> "Skal være mindre end",
		"VAL_GREAT"				=> "Skal være større end",
		"VAL_LESS_EQ"			=> "Skal være mindre end eller lig med",
		"VAL_GREAT_EQ"		=> "Skal være større end eller lig med",
		"VAL_NOT_EQ"			=> "Må ikke være lig med",
		"VAL_EQ"					=> "Skal være lig med",
		"VAL_TZ"					=> "Skal være et gyldigt tidszonenavn",
		"VAL_MUST"				=> "Skal være",
		"VAL_MUST_LIST"		=> "Skal være en af følgende",
		"VAL_TIME"				=> "Skal være et gyldigt tidspunkt",
		"VAL_SEL"					=> "Er ikke et gyldigt valg",
		"VAL_NA_PHONE"		=> "Skal være et gyldigt nordamerikansk telefonnummer",
	));

		//Time
	$lang = array_merge($lang,array(
		"T_YEARS"			=> "År",
		"T_YEAR"			=> "År",
		"T_MONTHS"		=> "Måneder",
		"T_MONTH"			=> "Måned",
		"T_WEEKS"			=> "Uger",
		"T_WEEK"			=> "Uge",
		"T_DAYS"			=> "Dage",
		"T_DAY"				=> "Dag",
		"T_HOURS"			=> "Timer",
		"T_HOUR"			=> "Time",
		"T_MINUTES"		=> "Minutter",
		"T_MINUTE"		=> "Minut",
		"T_SECONDS"		=> "Sekunder",
		"T_SECOND"		=> "Sekund",
		));


		//Passwords
	$lang = array_merge($lang,array(
		"PW_NEW"		=> "Ny adgangskode",
		"PW_OLD"		=> "Gammel adgangskode",
		"PW_CONF"		=> "Bekræft adgangskode",
		"PW_RESET"	=> "Nulstil adgangskode",
		"PW_UPD"		=> "Adgangskode opdateret",
		"PW_SHOULD"	=> "Adgangskoder skal...",
		"PW_SHOW"		=> "Vis Adgangskode",
		"PW_SHOWS"	=> "Vis Adgangskoder",
		));


		//Join
	$lang = array_merge($lang,array(
		"JOIN_SUC"			=> "Velkommen til ",
		"JOIN_THANKS"		=> "Tak for din registrering!",
		"JOIN_HAVE"			=> "Har i det mindste ",
		"JOIN_CAP"			=> "Store bogstaver",
		"JOIN_TWICE"		=> "Skrives korrekt to gange",
		"JOIN_CLOSED"		=> "Desværre er registrering ikke mulig på nuværrende tidpunkt. Kontakt venligst sidens administrator hvis du har nogle spørgsmål.",
		"JOIN_TC"				=> "Vilkår og betingelser for registrering af brugere",
		"JOIN_ACCEPTTC" => "Jeg accepterer brugervilkår og -betingelser",
		"JOIN_CHANGED"	=> "Vores vilkår har ændret sig",
		"JOIN_ACCEPT" 	=> "Accepter brugervilkår og -betingelser, og fortsæt",
		));

		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "Succesfuldt dræbt ",
		));

		//Messages
	$lang = array_merge($lang,array(
		"MSG_SENT"			=> "Din besked er blevet sendt!",
		"MSG_MASS"			=> "Din massebesked er blevet sendt!",
		"MSG_NEW"				=> "Ny besked",
		"MSG_NEW_MASS"	=> "Ny massebesked",
		"MSG_CONV"			=> "Samtaler",
		"MSG_NO_CONV"		=> "Ingen samtaler",
		"MSG_NO_ARC"		=> "Ingen samtaler",
		"MSG_QUEST"			=> "Send e-mail-notifikation, hvis den er aktiveret?",
		"MSG_ARC"				=> "Arkiverede tråde",
		"MSG_VIEW_ARC"	=> "Se arkiverede tråde",
		"MSG_SETTINGS"  => "Beskedindstillinger",
		"MSG_READ"			=> "Læst",
		"MSG_BODY"			=> "Krop",
		"MSG_SUB"				=> "Emne",
		"MSG_DEL"				=> "Leveret",
		"MSG_REPLY"			=> "Svar",
		"MSG_QUICK"			=> "Hurtigt svar",
		"MSG_SELECT"		=> "Vælg en bruger",
		"MSG_UNKN"			=> "Ukendt modtager",
		"MSG_NOTIF"			=> "Send e-mail-notifikationer",
		"MSG_BLANK"			=> "Meddelelsen kan ikke være tom",
		"MSG_MODAL"			=> "Klik her, eller tryk på Alt + R for at fokusere på dette felt ELLER tryk på Shift + R for at åbne det udvidede svarpanel!",
		"MSG_ARCHIVE_SUCCESSFUL"        => "Du har arkiveret %m1% tråde",
		"MSG_UNARCHIVE_SUCCESSFUL"      => "Du har fjernet arkiveringen af %m1% tråde",
		"MSG_DELETE_SUCCESSFUL"         => "Du har slettet %m1% tråde",
		"USER_MESSAGE_EXEMPT"         			=> "Brugeren er %m1% fritaget for beskeder.",
		"MSG_MK_READ"		=> "Læst",
		"MSG_MK_UNREAD"	=> "Ulæst",
		"MSG_ARC_THR"		=> "Arkiver udvalgte tråde",
		"MSG_UN_THR"		=> "Fjern arkivering af valgte tråde",
		"MSG_DEL_THR"		=> "Slet valgte tråde",
		"MSG_SEND"			=> "Send besked",
		));

	//2 Factor Authentication
	$lang = array_merge($lang,array(
		"2FA"				=> "2-faktor godkendelse",
		"2FA_CONF"	=> "Er du sikker på, at du vil deaktivere 2FA? Din konto vil ikke længere være beskyttet.",
		"2FA_SCAN"	=> "Scan denne QR-kode med din godkenderapp, eller indtast nøglen",
		"2FA_THEN"	=> "Indtast derefter en af dine engangsnøgler her",
		"2FA_FAIL"	=> "Der opstod et problem med at verificere 2FA. Tjek venligst internettet eller kontakt supporten.",
		"2FA_CODE"	=> "2FA Kode",
		"2FA_EXP"		=> "Udløbet 1 fingeraftryk",
		"2FA_EXPD"	=> "Udløbet",
		"2FA_EXPS"	=> "Udløber",
		"2FA_ACTIVE"=> "Aktive sessioner",
		"2FA_NOT_FN"=> "Ingen fingeraftryk fundet",
		"2FA_FP"		=> "Fingeraftryk",
		"2FA_NP"		=> "<strong>Login fejlede</strong> 2-faktor godkendelse var ikke mulig. Prøv venligst igen.",
		"2FA_INV"		=> "<strong>Login fejlede</strong> 2-faktor godkendelseskoden var ugyldig. Prøv venligst igen.",
		"2FA_FATAL"	=> "<strong>Fatal fejl</strong> Kontakt venligst system administratoren",
		));

	//Redirect Messages - These get a plus between each word
	$lang = array_merge($lang,array(
		"REDIR_2FA"						=> "Beklager.To+faktor+er+ikke+aktiveret+på+dette+tidspunkt",
		"REDIR_2FA_EN"				=> "2+Faktor+Godkendelse+Aktiveret",
		"REDIR_2FA_DIS"				=> "2+Faktor+Godkendelse+Deaktiveret",
		"REDIR_2FA_VER"				=> "2+Faktor+Godkendelse+Bekræftet+og+Aktiveret",
		"REDIR_SOM_TING_WONG" => "Noget+gik+galt.+Prøv+venligst+igen.",
		"REDIR_MSG_NOEX"			=> "Den+tråd+tilhører+ikke+dig+eller+eksisterer+ikke",
		"REDIR_UN_ONCE"				=> "Brugernavnet+er+allerede+blevet+ændret+en+gang",
		"REDIR_EM_SUCC"				=> "Email+Opdateret+med+succes",
		));

	//Emails
	$lang = array_merge($lang,array(
		"EML_CONF"			=> "Bekræft Email",
		"EML_VER"				=> "Bekræft din e-mail",
		"EML_CHK"				=> "E-mail-anmodning modtaget. Tjek venligst din e-mail for at udføre verifikationen. Sørg for at tjekke mappen Spam og uønsket post, da bekræftelseslinket udløber om ",
		"EML_MAT"				=> "Din e-mail matchede ikke.",
		"EML_HELLO"			=> "Hej fra ",
		"EML_HI"				=> "Hej ",
		"EML_AD_HAS"		=> "En administrator har nulstillet din adgangskode.",
		"EML_AC_HAS"		=> "En administrator har oprettet din konto.",
		"EML_REQ"				=> "Du bliver bedt om at indstille din adgangskode ved hjælp af linket ovenfor.",
		"EML_EXP"				=> "Bemærk, at adgangskodelinks udløber om ",
		"EML_VER_EXP"		=> "Bemærk, at bekræftelseslinks udløber om ",
		"EML_CLICK"			=> "Klik her for at logge ind.",
		"EML_REC"				=> "Det anbefales at ændre din adgangskode, når du logger ind.",
		"EML_MSG"				=> "Du har en ny besked fra",
		"EML_REPLY"			=> "Klik her for at svare eller se tråden",
		"EML_WHY"				=> "Du modtager denne e-mail, fordi der blev anmodet om at nulstille din adgangskode. Hvis dette ikke var dig, kan du se bort fra denne e-mail.",
		"EML_HOW"				=> "Hvis dette var dig, skal du klikke på nedenstående link for at fortsætte med processen til nulstilling af adgangskode.",
		"EML_EML"				=> "En anmodning om at ændre din e-mail blev foretaget fra din brugerkonto.",
		"EML_VER_EML"		=> "Tak fordi du tilmeldte dig. Når du har bekræftet din e-mail-adresse, er du klar til at logge ind! Klik på nedenstående link for at bekræfte din e-mailadresse.",

		));

		//Verification
		$lang = array_merge($lang,array(
			"VER_SUC"			=> "Din e-mail er blevet bekræftet!",
			"VER_FAIL"		=> "Vi kunne ikke bekræfte din konto. Prøv venligst igen.",
			"VER_RESEND"	=> "Send bekræftelses-e-mail igen",
			"VER_AGAIN"		=> "Indtast din e-mailadresse, og prøv igen",
			"VER_PAGE"		=> "<li>Tjek din e-mail, og klik på det link, der er blevet sendt til dig</li><li>Done</li>",
			"VER_RES_SUC" => "<p>Dit bekræftelseslink er blevet sendt til din e-mailadresse.</p><p>Klik på linket i e-mailen for at fuldføre bekræftelsen. Sørg for at tjekke din Spammappe, hvis e-mailen ikke er i din indbakke.</p><p>Bekræftelseslinks er kun gyldige i ",
			"VER_OOPS"		=> "Ups... noget gik galt, måske et gammelt nulstillingslink, du klikkede på. Klik nedenfor for at prøve igen",
			"VER_RESET"		=> "Din adgangskode er blevet nulstillet!",
			"VER_INS"			=> "<li>Indtast din e-mailadresse, og klik på Nulstil</li> <li>Tjek din e-mail, og klik på det link, der er sendt til dig.</li>
												<li>Følg vejledningen på skærmen</li>",
			"VER_SENT"		=> "<p>Dit link til nulstilling af adgangskode er blevet sendt til din e-mailadresse.</p>
			    							<p>Klik på linket i e-mailen for at nulstille din adgangskode. Sørg for at tjekke din Spammappe, hvis e-mailen ikke er i din indbakke.</p><p>Nulstil links er kun gyldige i ",
			"VER_PLEASE"	=> "Nulstil venligst din adgangskode",
			));

	//User Settings
	$lang = array_merge($lang,array(
		"SET_PIN"				=> "Nulstil pinkode",
		"SET_WHY"				=> "Hvorfor kan jeg ikke ændre dette?",
		"SET_PW_MATCH"	=> "Skal matche den nye adgangskode",

		"SET_PIN_NEXT"	=> "Du kan indstille en ny pinkode, næste gang du skal bekræftes",
		"SET_UPDATE"		=> "Opdater dine brugerindstillinger",
		"SET_NOCHANGE"	=> "Administratoren har deaktiveret muligheden for ændring af brugernavne.",
		"SET_ONECHANGE"	=> "Administratoren indstillede brugernavnsændringer til kun at kunne ske én gang, og du har allerede gjort det.",

		"SET_GRAVITAR"	=> "<strong>Vil du ændre dit profilbillede? </strong><br> Besøg <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> og opsæt en konto med den samme e-mail, som du brugte på dette websted. Det fungerer på tværs af millioner af websteder. Det er hurtigt og nemt!",

		"SET_NOTE1"			=> "<p><strong>Bemærk,</strong> at der er en afventende anmodning om at opdatere din e-mail til",

		"SET_NOTE2"			=> ".</p><p>Brug bekræftelses-e-mailen til at fuldføre denne anmodning.</p>
		<p>Hvis du har brug for en ny bekræftelses-e-mail, skal du indtaste e-mailen ovenfor igen og indsende anmodningen igen.</p>",

		"SET_PW_REQ" 		=> "kræves for at ændre adgangskode, e-mail eller nulstille pinkode",
		"SET_PW_REQI" 	=> "Påkrævet for at ændre din adgangskode",

		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"		=> "Kunne ikke afslutte aktive sessioner, Fejl:",
		"ERR_EMAIL"				=> "E-mail IKKE sendt på grund af fejl. Kontakt venligst sidens administrator.",
		"ERR_EM_DB"				=> "Denne e-mail findes ikke i vores database",
		"ERR_TC"					=> "Læs og accepter venligst vilkår og betingelser",
		"ERR_CAP"					=> "Du dumpede Captcha-testen, robot!",
		"ERR_PW_SAME"			=> "Din gamle adgangskode kan ikke være den samme som din nye",
		"ERR_PW_FAIL"			=> "Den aktuelle adgangskodebekræftelse mislykkedes. Opdateringen mislykkedes. Prøv venligst igen.",
		"ERR_GOOG"				=> "<strong>NOTE:</strong> Hvis du oprindeligt tilmeldte dig med din Google / Facebook-konto, skal du bruge linket til Glemt adgangskode, for at ændre din adgangskode... medmindre du er rigtig god til at gætte.",
		"ERR_EM_VER"			=> "E-mailbekræftelse er ikke aktiveret. Kontakt systemadministratoren.",
		"ERR_EMAIL_STR"		=> "Noget er mærkeligt. Bekræft venligst din e-mail igen. Vi beklager ulejligheden",

		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"		=> "Vi er snart tilbage!",
		"MAINT_MSG"			=> "Beklager ulejligheden, men vi udfører noget vedligeholdelse i øjeblikket.<br> Vi kommer snart online igen!",
		"MAINT_BAN"			=> "Beklager. Du er blevet udelukket. Hvis du mener, at dette er en fejl, bedes du kontakte administratoren.",
		"MAINT_TOK"			=> "Der opstod en fejl med din formular. Gå venligst tilbage og prøv igen. Bemærk, at indsendelse af formularen ved at opdatere siden vil medføre en fejl. Hvis dette fortsætter med at ske, bedes du kontakte administratoren.",
		"MAINT_OPEN"		=> "An Open Source PHP User Management Framework.",
		"MAINT_OPEN"		=> "An Open Source PHP User Management Framework.",
		"MAINT_PLEASE"	=> "Du har installeret UserSpice!<br>For at se vores Kom-i-gang-dokumentation, besøg venligst"
		));

		//dataTables Added in 4.4.08
		//NOTE: do not change the words like _START_ between the two _ symbols!
		$lang = array_merge($lang,array(
		"DAT_SEARCH"    => "Søg",
		"DAT_FIRST"     => "Første",
		"DAT_LAST"      => "Sidste",
		"DAT_NEXT"      => "Næste",
		"DAT_PREV"      => "Forrige",
		"DAT_NODATA"        => "Ingen data tilgængelige i tabellen",
		"DAT_INFO"          => "Viser _START_ til _SLUT_ af _TOTALE_ indlæg",
		"DAT_ZERO"          => "Viser 0 til 0 af 0 indlæg",
		"DAT_FILTERED"      => "(filtreret fra _MAX_ samlede indlæg)",
		"DAT_MENU_LENG"     => "Vis _MENU_ indlæggene",
		"DAT_LOADING"       => "Indlæser...",
		"DAT_PROCESS"       => "Behandler...",
		"DAT_NO_REC"        => "Ingen matchende poster fundet",
		"DAT_ASC"           => "Aktivér for at sortere kolonnen, stigende",
		"DAT_DESC"          => "Aktivér for at sortere kolonne faldende",
		));


///////////////////////////////////////////////////////////////

//Backend Translations for UserSpice
$lang = array_merge($lang,array(
"BE_DASH"    			=> "Instrumentbræt",
"BE_SETTINGS"     => "Indstillinger",
"BE_GEN"					=> "Generelt",
"BE_REG"					=> "Registrering",
"BE_CUS"					=> "Brugerdefinerede indstillinger",
"BE_DASH_ACC"			=> "Adgang til Instrumentbrættet",
"BE_TOOLS"				=> "Værktøjer",
"BE_BACKUP"				=> "Sikkerhedskopi",
"BE_UPDATE"				=> "Opdateringer",
"BE_CRON"				  => "Cron Jobs",
"BE_IP"				  	=> "IP Bestyrer",
));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
 //do not put a closing php tag here
