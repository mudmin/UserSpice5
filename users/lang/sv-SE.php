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

/* Translation assisted by Tekniskedirektorn */

$lang = array();
//important strings
//You defiitely want to customize these for your language
$lang = array_merge($lang,array(
"THIS_LANGUAGE"	=>"Svenska",
"THIS_CODE"			=>"sv-SE",
"MISSING_TEXT"	=>"Text saknas",
));

//Database Menus
$lang = array_merge($lang,array(
"MENU_HOME"			=> "Hem",
"MENU_HELP"			=> "Hjälp",
"MENU_ACCOUNT"	=> "Konto",
"MENU_DASH"			=> "Admin Dashboard",
"MENU_USER_MGR"	=> "Hantera användare",
"MENU_PAGE_MGR"	=> "Hantera sidor",
"MENU_PERM_MGR"	=> "Hantera rättigheter",
"MENU_MSGS_MGR"	=> "Hantera meddelanden",
"MENU_LOGS_MGR"	=> "Systemloggar",
"MENU_LOGOUT"		=> "Logga ut",
));

// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"					=> "Registrera",
	"SIGNUP_BUTTONTEXT"		=> "Registera mig",
	"SIGNUP_AUDITTEXT"		=> "Registerad",
	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"				=> "** LOGIN MISSLYCKADES **",
	"SIGNIN_PLEASE_CHK" => "Vänligen kontrollera användarnamn och lösenord och försök igen",
	"SIGNIN_UORE"				=> "Användarnamn ELLER e-postadress",
	"SIGNIN_PASS"				=> "Lösenord",
	"SIGNIN_TITLE"			=> "Vänligen logga in",
	"SIGNIN_TEXT"				=> "Logga in",
	"SIGNOUT_TEXT"			=> "Logga ut",
	"SIGNIN_BUTTONTEXT"	=> "Logga in",
	"SIGNIN_REMEMBER"		=> "Kom ihåg mig",
	"SIGNIN_AUDITTEXT"	=> "Inloggad",
	"SIGNIN_FORGOTPASS"	=>"Glömt lösenord",
	"SIGNOUT_AUDITTEXT"	=> "Utloggad",
	));

// Account Page
$lang = array_merge($lang,array(
	"ACCT_EDIT"					=> "Redigera kontoinformation",
	"ACCT_2FA"					=> "Hantera 2-faktorsautentisering",
	"ACCT_SESS"					=> "Hantera sessioner",
	"ACCT_HOME"					=> "Konto hem",
	"ACCT_SINCE"				=> "Medlem sedan",
	"ACCT_LOGINS"				=> "Antal inloggningar",
	"ACCT_SESSIONS"			=> "Antal aktiva sessioner",
	"ACCT_MNG_SES"			=> "Klicka på knappen Hantera sessioner i vänstra sidofältet för mer information.",
	));

	//General Terms
	$lang = array_merge($lang,array(
		"GEN_ENABLED"			=> "Aktiverad",
		"GEN_DISABLED"		=> "Inaktiverad",
		"GEN_ENABLE"			=> "Aktivera",
		"GEN_DISABLE"			=> "Inaktivera",
		"GEN_NO"					=> "Nej",
		"GEN_YES"					=> "Ja",
		"GEN_MIN"					=> "min",
		"GEN_MAX"					=> "max",
		"GEN_CHAR"				=> "tkn", //as in characters
		"GEN_SUBMIT"			=> "Skicka",
		"GEN_MANAGE"			=> "Hantera",
		"GEN_VERIFY"			=> "Verifiera",
		"GEN_SESSION"			=> "Session",
		"GEN_SESSIONS"		=> "Sessioner",
		"GEN_EMAIL"				=> "E-post",
		"GEN_FNAME"				=> "Förnamn",
		"GEN_LNAME"				=> "Efternamn",
		"GEN_UNAME"				=> "Användarnamn",
		"GEN_PASS"				=> "Lösenord",
		"GEN_MSG"					=> "Meddelande",
		"GEN_TODAY"				=> "Idag",
		"GEN_CLOSE"				=> "Stäng",
		"GEN_CANCEL"			=> "Avbryt",
		"GEN_CHECK"				=> "[ checka/avchecka all ]",
		"GEN_WITH"				=> "med",
		"GEN_UPDATED"			=> "Updaterad",
		"GEN_UPDATE"			=> "Updatera",
		"GEN_BY"					=> "av",
		"GEN_FUNCTIONS"		=> "Funktioner",
		"GEN_NUMBER"			=> "nummer",
		"GEN_NUMBERS"			=> "nummer",
		"GEN_INFO"				=> "Information",
		"GEN_REC"					=> "Sparat",
		"GEN_DEL"					=> "Ta bort",
		"GEN_NOT_AVAIL"		=> "Ej tillgängligt",
		"GEN_AVAIL"				=> "Tillgängligt",
		"GEN_BACK"				=> "Tillbaka",
		"GEN_RESET"				=> "Återställ",
		"GEN_REQ"					=> "obligatoriskt",
		"GEN_AND"					=> "och",
		"GEN_SAME"				=> "måste vara likadant",
		));

//validation class
	$lang = array_merge($lang,array(
		"VAL_SAME"				=> "måste vara likadant",
		"VAL_EXISTS"			=> "finns redan. Vänligen välj något annat.",
		"VAL_DB"					=> "Databasfel",
		"VAL_NUM"					=> "måste vara ett nummer",
		"VAL_INT"					=> "måste vara ett heltal",
		"VAL_EMAIL"				=> "måste vara en giltig e-postadress",
		"VAL_NO_EMAIL"		=> "kan inte vara en e-postadress",
		"VAL_SERVER"			=> "måste tillhöra en giltig server",
		"VAL_LESS"				=> "måste vara mindre än",
		"VAL_GREAT"				=> "måste vara mer än",
		"VAL_LESS_EQ"			=> "måste vara mindre eller lika med",
		"VAL_GREAT_EQ"		=> "måste vara mer eller lika med",
		"VAL_NOT_EQ"			=> "får inte vara lika med",
		"VAL_EQ"					=> "måste vara lika med",
		"VAL_TZ"					=> "måste vara ett giltigt tidzonsnamn",
		"VAL_MUST"				=> "måste vara",
		"VAL_MUST_LIST"		=> "måste vara något av följande",
		"VAL_TIME"				=> "måste vara en gitlig tid",
		"VAL_SEL"					=> "är inte ett giltigt val",
		"VAL_NA_PHONE"		=> "måste vara ett giltigt telefonnummer (North American)",
	));

		//Time
	$lang = array_merge($lang,array(
		"T_YEARS"			=> "År",
		"T_YEAR"			=> "År",
		"T_MONTHS"		=> "Månader",
		"T_MONTH"			=> "Månad",
		"T_WEEKS"			=> "Veckor",
		"T_WEEK"			=> "Vecka",
		"T_DAYS"			=> "Dagar",
		"T_DAY"				=> "Dag",
		"T_HOURS"			=> "Timmar",
		"T_HOUR"			=> "Timme",
		"T_MINUTES"		=> "Minuter",
		"T_MINUTE"		=> "Minut",
		"T_SECONDS"		=> "Sekunder",
		"T_SECOND"		=> "Sekund",
		));


		//Passwords
	$lang = array_merge($lang,array(
		"PW_NEW"		=> "Nytt lösenord",
		"PW_OLD"		=> "Gammalt lösenord",
		"PW_CONF"		=> "Bekräfta lösenord",
		"PW_RESET"	=> "Återställ lösenord",
		"PW_UPD"		=> "Lösenord uppdaterat",
		"PW_SHOULD"	=> "Lösenord måste...",
		"PW_SHOW"		=> "Visa lösenord",
		"PW_SHOWS"	=> "Visa lösenord",
		));


		//Join
	$lang = array_merge($lang,array(
		"JOIN_SUC"			=> "Välkommen till ",
		"JOIN_THANKS"		=> "Tack för registreringen!",
		"JOIN_HAVE"			=> "Ha åtminstone ",
		"JOIN_CAP"			=> " versaler",
		"JOIN_TWICE"		=> "Inmatas korrekt två gånger",
		"JOIN_CLOSED"		=> "Tyvärr är registreringen avvaktiverad för närvarande. Var vänlig kontakta administratören om du har frågor eller ärenden.",
		"JOIN_TC"				=> "Registrering allmänna villkor",
		"JOIN_ACCEPTTC" => "Jag accepterar de allmänna villkoren",
		"JOIN_CHANGED"	=> "Våra allmänna villkor har uppdaterats",
		"JOIN_ACCEPT" 	=> "Acceptera allmänna villkor och fortsätt",
		));

		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "Lyckades avsluta ",
		));

		//Messages
	$lang = array_merge($lang,array(
		"MSG_SENT"			=> "Ditt meddelande har skickats!",
		"MSG_MASS"			=> "Ditt massmeddelande har skickats!",
		"MSG_NEW"				=> "nytt meddelande",
		"MSG_NEW_MASS"	=> "Nytt massmeddelande",
		"MSG_CONV"			=> "Konversationer",
		"MSG_NO_CONV"		=> "Inga konversationer",
		"MSG_NO_ARC"		=> "Inga konversationer",
		"MSG_QUEST"			=> "Skicka e-postnotifikation om aktiverad?",
		"MSG_ARC"				=> "Arkiverade trådar",
		"MSG_VIEW_ARC"	=> "Se arkiverade trådar",
		"MSG_SETTINGS"  => "Meddelandeinställningar",
		"MSG_READ"			=> "Läs",
		"MSG_BODY"			=> "Innehåll",
		"MSG_SUB"				=> "Rubrik",
		"MSG_DEL"				=> "Levererad",
		"MSG_REPLY"			=> "Svara",
		"MSG_QUICK"			=> "Snabbsvar",
		"MSG_SELECT"		=> "Välj en användare",
		"MSG_UNKN"			=> "Mottagare okänd",
		"MSG_NOTIF"			=> "Meddelande e-postnotifikation",
		"MSG_BLANK"			=> "Meddelandet kan inte vara tomt",
		"MSG_MODAL"			=> "Klicka här eller tryck Alt + R för att sätta fokus på denna box ELLER tryck Shift + R för att öppna den expanderade svarspanelen!",
		"MSG_ARCHIVE_SUCCESSFUL"        => "Du har lyckats arkivera %m1% trådar",
		"MSG_UNARCHIVE_SUCCESSFUL"      => "Du har lyckats hämtat %m1% arkiverade trådar",
		"MSG_DELETE_SUCCESSFUL"         => "Du har lyckats ta bort %m1% trådar",
		"USER_MESSAGE_EXEMPT"         			=> "Användare är %m1% undantagen från meddelanden.",
		"MSG_MK_READ"		=> "Läst",
		"MSG_MK_UNREAD"	=> "Oläst",
		"MSG_ARC_THR"		=> "Arkivera valda trådar",
		"MSG_UN_THR"		=> "Hämta valda arkiverade trådar",
		"MSG_DEL_THR"		=> "Ta bort valda trådar",
		"MSG_SEND"			=> "Skicka meddelande",
		));

	//2 Factor Authentication
	$lang = array_merge($lang,array(
		"2FA"				=> "2-faktorsautentisering",
		"2FA_CONF"	=> "Är du säker på att du vill avaktivera 2FA? Ditt konto kommer inte längre vara skyddat.",
		"2FA_SCAN"	=> "Skanna denna QR-kod med din autentiseringsapp eller skriv in nyckeln",
		"2FA_THEN"	=> "Skriv sedan in en av dina engångslösen här",
		"2FA_FAIL"	=> "Problem med att verifiera 2FA. Vänligen kontrollera internetanslutning eller kontakta support.",
		"2FA_CODE"	=> "2FA-kod",
		"2FA_EXP"		=> "Utgånget 1 fingeravtryck",
		"2FA_EXPD"	=> "Utgånget",
		"2FA_EXPS"	=> "Går ut",
		"2FA_ACTIVE"=> "Aktiva sessioner",
		"2FA_NOT_FN"=> "Inget fingeravtryck hittades",
		"2FA_FP"		=> "Fingeravtryck",
		"2FA_NP"		=> "<strong>Login misslyckades</strong> Tvåfaktors autentiseringskod fanns inte. Vänligen försök igen.",
		"2FA_INV"		=> "<strong>Login misslyckades</strong> Ogiltig tvåfaktors autentiseringskod. Vänligen försök igen.",
		"2FA_FATAL"	=> "<strong>Allvarligt fel</strong> Vänligen kontakta systemadministratör.",
		));

	//Redirect Messages - These get a plus between each word
	$lang = array_merge($lang,array(
		"REDIR_2FA"						=> "Tyvärr.Tvåfaktor+är+inte+aktiverat+för+närvarande",
		"REDIR_2FA_EN"				=> "2-faktorsautentisering+aktiverad",
		"REDIR_2FA_DIS"				=> "2-faktorsautentisering+inaktiverad",
		"REDIR_2FA_VER"				=> "2-faktorsautentisering+verifierad+och+aktiverad",
		"REDIR_SOM_TING_WONG" => "Något+gick+fel.+Vänligen+försök+igen.",
		"REDIR_MSG_NOEX"			=> "Den+tråden+tillhör+inte+dig+eller+finns+inte.",
		"REDIR_UN_ONCE"				=> "Användarnamn+har+redan+ändrats+en+gång.",
		"REDIR_EM_SUCC"				=> "Uppdatering+av+E-post+lyckades.",
		));

	//Emails
	$lang = array_merge($lang,array(
		"EML_CONF"			=> "Bekräfta e-post",
		"EML_VER"				=> "Verifiera din e-post",
		"EML_CHK"				=> "E-post förfrågan mottagen. Vänligen kontrollera din e-post för att verifiera den. Kontrollera foldrar för skräppost då verifieringslänken går ut om ",
		"EML_MAT"				=> "Din e-post matchade inte.",
		"EML_HELLO"			=> "Hej från ",
		"EML_HI"				=> "Hej ",
		"EML_AD_HAS"		=> "En administratör har återställt ditt lösenord.",
		"EML_AC_HAS"		=> "En administratör har skapat ditt konto.",
		"EML_REQ"				=> "Du måste ställa in ditt lösenord med hjälp av länken ovan.",
		"EML_EXP"				=> "Vänligen notera, lösenordslänkar går ut om ",
		"EML_VER_EXP"		=> "Vänligen notera, verifieringslänkar går ut om ",
		"EML_CLICK"			=> "Klicka här för att logga in.",
		"EML_REC"				=> "Det är rekommenderat att du uppdaterar ditt lösenord när du loggar in.",
		"EML_MSG"				=> "Du har ett nytt meddelande från",
		"EML_REPLY"			=> "Klicka här för att se eller svara på tråden",
		"EML_WHY"				=> "Du får detta e-postmeddelande eftersom en begäran gjordes om att återställa ditt lösenord. Om detta inte var du, kan du bortse från detta e-postmeddelande.",
		"EML_HOW"				=> "Om det var du, klicka på länken nedan för att fortsätta med återställningsprocessen av lösenord.",
		"EML_EML"				=> "En begäran om att ändra din e-post gjordes från ditt användarkonto.",
		"EML_VER_EML"		=> "Tack för att du registrerade dig. När du har verifierat din e-postadress är du redo att logga in! Klicka på länken nedan för att verifiera din e-postadress.",

		));

		//Verification
		$lang = array_merge($lang,array(
			"VER_SUC"			=> "Din e-postadress har verifierats!",
			"VER_FAIL"		=> "Vi kunde inte verifiera ditt konto. Var god försök igen.",
			"VER_RESEND"	=> "Skicka verifikationsmail igen",
			"VER_AGAIN"		=> "Skriv in din e-postadress och försök igen",
			"VER_PAGE"		=> "<li>Kontrollera din e-post och klicka på länken som skickas till dig</li><li>Klart</li>",
			"VER_RES_SUC" => "<p>En verifieringslänk har skickats till din e-postadress.</p><p>Klicka på länken i e-postmeddelandet för att slutföra verifieringen. Kontrollera din skräppostmapp om e-postmeddelandet inte finns i din inkorg.</p><p>Verifieringslänkar är endast giltiga ",
			"VER_OOPS"		=> "Ojoj...något gick fel, kan vara en gammal återställningslänk du klickade på. Klicka nedan och försök igen.",
			"VER_RESET"		=> "Ditt löenord har återställts!",
			"VER_INS"			=> "<li>Ange din e-postadress och klicka på Återställ</li> <li>Kontrollera din e-post och klicka på länken som skickas till dig.</li>
												<li>Följ instruktionerna på skärmen</li>",
			"VER_SENT"		=> "<p>Länken för återställning av lösenord har skickats till din e-postadress.</p>
			    							<p>Klicka på länken i e-postmeddelandet för att återställa ditt lösenord. Kontrollera din skräppostmapp om e-postmeddelandet inte finns i din inkorg.</p><p>Återställningslänkar gäller endast ",
			"VER_PLEASE"	=> "Vänligen återställ ditt lösenord",
			));

	//User Settings
	$lang = array_merge($lang,array(
		"SET_PIN"				=> "Återställ PIN",
		"SET_WHY"				=> "Varför kan jag inte ändra det här?",
		"SET_PW_MATCH"	=> "Måste matcha det nya lösenordet",

		"SET_PIN_NEXT"	=> "Du kan ställa in en ny PIN-kod nästa gång du behöver verifiering",
		"SET_UPDATE"		=> "Uppdatera dina användarinställningar",
		"SET_NOCHANGE"	=> "Administratören har avaktiverat möjligheten att byta användarnamn.",
		"SET_ONECHANGE"	=> "Administratören ställde in användarnamnändringar att inträffa endast en gång och du har redan gjort det.",

		"SET_GRAVITAR"	=> "<strong>Vill du ändra din profilbild? </strong><br> Besök <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> och konfigurera ett konto med samma e-postmeddelande som du använde på den här webbplatsen. Det fungerar på miljontals webbplatser. Det är snabbt och enkelt!",

		"SET_NOTE1"			=> "<p><strong>Vänligen observera</strong> det finns en pågående begäran om att uppdatera din e-post till",

		"SET_NOTE2"			=> ".</p><p>Vänligen använd verifieringsmeddelandet för att slutföra denna begäran.</p>
		<p>Om du behöver ett nytt verifieringsmeddelande, ange e-postmeddelandet igen och skicka in begäran igen.</p>",

		"SET_PW_REQ" 		=> "behövs för byte av lösenord, e-post, eller återställa PIN",
		"SET_PW_REQI" 	=> "Behövs för att byta lösenord",

		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"		=> "Misslyckades med att avsluta aktiva sessioner, Fel: ",
		"ERR_EMAIL"				=> "E-post skickades EJ pga fel. Kontakta administrator.",
		"ERR_EM_DB"				=> "Den e-postadressen existerar inte i databasen",
		"ERR_TC"					=> "Vänligen läs och acceptera våra allmänna villkor",
		"ERR_CAP"					=> "Du falerade Captcha Test, robot!",
		"ERR_PW_SAME"			=> "Ditt nya lösenord kan inte vara samma som ditt gamla",
		"ERR_PW_FAIL"			=> "Lösenordsverifieringen misslyckades. Uppdateringen misslyckades. Var god försök igen.",
		"ERR_GOOG"				=> "<strong>Observera:</strong> Om du ursprungligen registrerade dig med ditt Google / Facebook-konto måste du använda länken Glömt lösenord för att ändra ditt lösenord ... såvida du inte är riktigt bra på att gissa.",
		"ERR_EM_VER"			=> "E-postverifiering är inte aktiverad. Vänligen kontakta systemadministratören.",
		"ERR_EMAIL_STR"		=> "Något är konstigt. Vänligen återverifiera din e-post. Vi beklagar olägenheten",

		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"		=> "Vi kommer tillbaka snart!",
		"MAINT_MSG"			=> "Ledsen för besväret men vi utför något underhåll för tillfället.<br> Vi är snart tillbaka online!",
		"MAINT_BAN"			=> "Ledsen men du har blivit avaktiverad. Om du känner att detta är ett fel, vänligen kontakta administratören.",
		"MAINT_TOK"			=> "Det var något fel med formuläret. Gå tillbaka och försök igen. Observera att skicka in formuläret genom att uppdatera sidan kommer att orsaka ett fel. Om detta fortsätter att hända, kontakta administratören.",
		"MAINT_OPEN"		=> "Ett Open Source PHP User Management Framework.",
		"MAINT_PLEASE"	=> "Du har installerat UserSpice!<br>För att se vår dokumentation över hur du kommer igång vänligen besök"
		));

		//dataTables Added in 4.4.08
		//NOTE: do not change the words like _START_ between the two _ symbols!
		$lang = array_merge($lang,array(
		"DAT_SEARCH"    => "Sök",
		"DAT_FIRST"     => "Första",
		"DAT_LAST"      => "Sista",
		"DAT_NEXT"      => "Nästa",
		"DAT_PREV"      => "Föregående",
		"DAT_NODATA"        => "Ingen data tillgänglig i denna tabell",
		"DAT_INFO"          => "Visar _START_ till _END_ av _TOTAL_ poster",
		"DAT_ZERO"          => "Visar 0 till 0 av 0 poster",
		"DAT_FILTERED"      => "(filtrerat från _MAX_ totalt antal poster)",
		"DAT_MENU_LENG"     => "Visa _MENU_ poster",
		"DAT_LOADING"       => "Laddar...",
		"DAT_PROCESS"       => "Processar...",
		"DAT_NO_REC"        => "Inga matchande poster hittades",
		"DAT_ASC"           => "Aktivera för att sortera kolumn stigande",
		"DAT_DESC"          => "Aktivera för att sortera kolumn fallande",
		));


///////////////////////////////////////////////////////////////

//Backend Translations for UserSpice 5
$lang = array_merge($lang,array(
"BE_DASH"    			=> "Dashboard",
"BE_SETTINGS"     => "Inställningar",
"BE_GEN"					=> "Generellt",
"BE_REG"					=> "Registrering",
"BE_CUS"					=> "Anpassade inställnignar",
"BE_DASH_ACC"			=> "Dashboard åtkomst",
"BE_TOOLS"				=> "Verktyg",
"BE_BACKUP"				=> "Backup",
"BE_UPDATE"				=> "Uppdateringar",
"BE_CRON"				  => "Cron Jobs",
"BE_IP"				  	=> "IP hantering",
));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
 //do not put a closing php tag here
