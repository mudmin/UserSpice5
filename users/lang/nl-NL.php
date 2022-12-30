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
"THIS_LANGUAGE" => "Nederlands",
"THIS_CODE" => "nl-NL",
"MISSING_TEXT" => "Tekst niet aanwezig",
));

// Databasemenu's
$lang = array_merge($lang,array(
"MENU_HOME" => "Home",
"MENU_HELP" => "Help",
"MENU_ACCOUNT" => "Account",
"MENU_DASH" => "Admin Dashboard",
"MENU_USER_MGR" => "Gebruikersbeheer",
"MENU_PAGE_MGR" => "Paginabeheer",
"MENU_PERM_MGR" => "Machtigingenbeheer",
"MENU_MSGS_MGR" => "Berichtenbeheer",
"MENU_LOGS_MGR" => "Systeemlogboeken",
"MENU_LOGOUT" => "Uitloggen",
));

// Aanmelden
$lang = array_merge($lang,array(
"SIGNUP_TEXT" => "Registreren",
"SIGNUP_BUTTONTEXT" => "Registreer mij",
"SIGNUP_AUDITTEXT" => "Geregistreerd",
));

// Aanmelden
$lang = array_merge($lang,array(
"SIGNIN_FAIL" => "** INLOGGEN MISLUKT **",
"SIGNIN_PLEASE_CHK" => "Controleer uw gebruikersnaam en wachtwoord en probeer het opnieuw",
"SIGNIN_UORE" => "Gebruikersnaam OF e-mail",
"SIGNIN_PASS" => "Wachtwoord",
"SIGNIN_TITLE" => "Meld u aan",
"SIGNIN_TEXT" => "Inloggen",
"SIGNOUT_TEXT" => "Uitloggen",
"SIGNIN_BUTTONTEXT" => "Inloggen",
"SIGNIN_REMEMBER" => "Onthoud mij",
"SIGNIN_AUDITTEXT" => "Ingelogd",
"SIGNIN_FORGOTPASS" => "Wachtwoord vergeten",
"SIGNOUT_AUDITTEXT" => "Uitgelogd",
));

// Accountpagina
$lang = array_merge($lang,array(
"ACCT_EDIT" => "Accountinfo bewerken",
"ACCT_2FA" => "Beheer 2-factorenauthenticatie",
"ACCT_SESS" => "Sessies beheren",
"ACCT_HOME" => "Account Home",
"ACCT_SINCE" => "Lid sinds",
"ACCT_LOGINS" => "Aantal aanmeldingen",
"ACCT_SESSIONS" => "Aantal actieve sessies",
"ACCT_MNG_SES" => "Klik op de knop Sessies beheren in de linkerzijbalk voor meer informatie.",
));

//Algemene voorwaarden
$lang = array_merge($lang,array(
"GEN_ENABLED" => "Ingeschakeld",
"GEN_DISABLED" => "Uitgeschakeld",
"GEN_ENABLE" => "Inschakelen",
"GEN_DISABLE" => "Uitschakelen",
"GEN_NO" => "Nee",
"GEN_YES" => "Ja",
"GEN_MIN" => "min",
"GEN_MAX" => "max",
"GEN_CHAR" => "teken", // zoals in tekens
"GEN_SUBMIT" => "Verzenden",
"GEN_MANAGE" => "Beheren",
"GEN_VERIFY" => "Verifi벥n",
"GEN_SESSION" => "Sessie",
"GEN_SESSIONS" => "Sessies",
"GEN_EMAIL" => "Email",
"GEN_FNAME" => "Voornaam",
"GEN_LNAME" => "Achternaam",
"GEN_UNAME" => "Gebruikersnaam",
"GEN_PASS" => "Wachtwoord",
"GEN_MSG" => "Bericht",
"GEN_TODAY" => "Vandaag",
"GEN_CLOSE" => "Sluiten",
"GEN_CANCEL" => "Annuleren",
"GEN_CHECK" => "[alles in-/uitschakelen]",
"GEN_WITH" => "met",
"GEN_UPDATED" => "Bijgewerkt",
"GEN_UPDATE" => "Bijwerken",
"GEN_BY" => "door",
"GEN_FUNCTIONS" => "Functies",
"GEN_NUMBER" => "nummer",
"GEN_NUMBERS" => "nummers",
"GEN_INFO" => "Informatie",
"GEN_REC" => "Vastgelegd",
"GEN_DEL" => "Verwijderen",
"GEN_NOT_AVAIL" => "Niet beschikbaar",
"GEN_AVAIL" => "Beschikbaar",
"GEN_BACK" => "Terug",
"GEN_RESET" => "Reset",
"GEN_REQ" => "vereist",
"GEN_AND" => "en",
"GEN_SAME" => "moet hetzelfde zijn",
));

// validatieklasse
$lang = array_merge($lang,array(
"VAL_SAME" => "moet hetzelfde zijn",
"VAL_EXISTS" => "bestaat al. Kies een andere",
"VAL_DB" => "Databasefout",
"VAL_NUM" => "moet een nummer zijn",
"VAL_INT" => "moet een geheel getal zijn",
"VAL_EMAIL" => "moet een geldig e-mailadres zijn",
"VAL_NO_EMAIL" => "kan geen e-mailadres zijn",
"VAL_SERVER" => "moet tot een geldige server behoren",
"VAL_LESS" => "moet kleiner zijn dan",
"VAL_GREAT" => "moet groter zijn dan",
"VAL_LESS_EQ" => "moet kleiner zijn dan of gelijk aan",
"VAL_GREAT_EQ" => "moet groter zijn dan of gelijk aan",
"VAL_NOT_EQ" => "mag niet gelijk zijn aan",
"VAL_EQ" => "moet gelijk zijn aan",
"VAL_TZ" => "moet een geldige tijdzonenaam zijn",
"VAL_MUST" => "moet zijn",
"VAL_MUST_LIST" => "moet een van de volgende zijn",
"VAL_TIME" => "moet een geldige tijd zijn",
"VAL_SEL" => "is geen geldige selectie",
"VAL_NA_PHONE" => "moet een geldig Noord-Amerikaans telefoonnummer zijn",
));

//Tijd
$lang = array_merge($lang,array(
"T_YEARS" => "jaren",
"T_YEAR" => "jaar",
"T_MONTHS" => "maanden",
"T_MONTH" => "maand",
"T_WEEKS" => "weken",
"T_WEEK" => "week",
"T_DAYS" => "dagen",
"T_DAY" => "dag",
"T_HOURS" => "uren",
"T_HOUR" => "uur",
"T_MINUTES" => "minuten",
"T_MINUTE" => "minuut",
"T_SECONDS" => "seconden",
"T_SECOND" => "seconde",
));


// Wachtwoorden
$lang = array_merge($lang,array(
"PW_NEW" => "Nieuw wachtwoord",
"PW_OLD" => "Oud wachtwoord",
"PW_CONF" => "Wachtwoord bevestigen",
"PW_RESET" => "Wachtwoord opnieuw instellen",
"PW_UPD" => "Wachtwoord is bijgewerkt",
"PW_SHOULD" => "Wachtwoorden moeten ...",
"PW_SHOW" => "Wachtwoord weergeven",
"PW_SHOWS" => "Toon wachtwoorden",
));


// Join
$lang = array_merge($lang,array(
"JOIN_SUC" => "Welkom bij",
"JOIN_THANKS" => "Bedankt voor het registreren!",
"JOIN_HAVE" => "Heeft tenminste",
"JOIN_CAP" => "hoofdletter",
"JOIN_TWICE" => "Twee keer correct worden getypt",
"JOIN_CLOSED" => "Helaas is registratie momenteel uitgeschakeld. Neem contact op met de sitebeheerder als u vragen of opmerkingen hebt.",
"JOIN_TC" => "Algemene gebruiksvoorwaarden voor registratie",
"JOIN_ACCEPTTC" => "Ik accepteer de gebruikersvoorwaarden",
"JOIN_CHANGED" => "Onze voorwaarden zijn gewijzigd",
"JOIN_ACCEPT" => "Gebruikersvoorwaarden accepteren en doorgaan",
));

// Sessions
$lang = array_merge($lang,array(
"SESS_SUC" => "Met succes afgebroken",
));

// Berichten
$lang = array_merge($lang,array(
"MSG_SENT" => "Uw bericht is verzonden!",
"MSG_MASS" => "Uw massa-bericht is verzonden!",
"MSG_NEW" => "Nieuw bericht",
"MSG_NEW_MASS" => "Nieuw massabericht",
"MSG_CONV" => "Conversaties",
"MSG_NO_CONV" => "Geen gesprekken",
"MSG_NO_ARC" => "Geen gesprekken",
"MSG_QUEST" => "E-mailmelding verzenden indien ingeschakeld?",
"MSG_ARC" => "Gearchiveerde threads",
"MSG_VIEW_ARC" => "Gearchiveerde threads bekijken",
"MSG_SETTINGS" => "Berichtinstellingen",
"MSG_READ" => "Lezen",
"MSG_BODY" => "Berichttekst",
"MSG_SUB" => "Onderwerp",
"MSG_DEL" => "Bezorgd",
"MSG_REPLY" => "Antwoord",
"MSG_QUICK" => "Snelle reactie",
"MSG_SELECT" => "Selecteer een gebruiker",
"MSG_UNKN" => "Onbekende ontvanger",
"MSG_NOTIF" => "E-mailmeldingen voor berichten",
"MSG_BLANK" => "Bericht mag niet leeg zijn",
"MSG_MODAL" => "Klik hier of druk op Alt + R om u op dit vak te concentreren OF druk op Shift + R om het uitgebreide antwoordvenster te openen!",
"MSG_ARCHIVE_SUCCESSFUL" => "U hebt %m1% threads gearchiveerd",
"MSG_UNARCHIVE_SUCCESSFUL" => "U heeft %m1% threads met succes gedearchiveerd",
"MSG_DELETE_SUCCESSFUL" => "U hebt %m1% threads verwijderd",
"USER_MESSAGE_EXEMPT" => "Gebruiker is %m1% vrijgesteld van berichten.",
"MSG_MK_READ" => "Gelezen",
"MSG_MK_UNREAD" => "Ongelezen",
"MSG_ARC_THR" => "Geselecteerde threads archiveren",
"MSG_UN_THR" => "Geselecteerde threads dearchiveren",
"MSG_DEL_THR" => "Geselecteerde discussies verwijderen",
"MSG_SEND" => "Bericht verzenden",
));

// 2 Factorauthenticatie
$lang = array_merge($lang,array(
"2FA" => "2 Factor Authenticatie",
"2FA_CONF" => "Weet u zeker dat u 2FA wilt uitschakelen? Uw account wordt niet langer beveiligd.",
"2FA_SCAN" => "Scan deze QR-code met uw authenticator-app of voer de sleutel in",
"2FA_THEN" => "Voer hier een van uw eenmalige toegangscodes in",
"2FA_FAIL" => "Er is een probleem opgetreden bij het verifi벥n van 2FA. Controleer internet of neem contact op met ondersteuning.",
"2FA_CODE" => "2FA Code",
"2FA_EXP" => "1 vingerafdruk verlopen",
"2FA_EXPD" => "Vervallen",
"2FA_EXPS" => "Vervalt",
"2FA_ACTIVE" => "Actieve sessies",
"2FA_NOT_FN" => "Geen vingerafdrukken gevonden",
"2FA_FP" => "Vingerafdrukken",
"2FA_NP" => "<strong> Inloggen mislukt</strong> er was geen code voor 2 Factor Authenticatie. Probeer het opnieuw.",
"2FA_INV" => "<strong> Inloggen mislukt</strong> 2 Factor Authenticatie is ongeldig. Probeer het opnieuw.",
"2FA_FATAL" => "<strong> Fatale fout </strong> neem contact op met de systeembeheerder.",
));

// Omleidingsberichten - deze krijgen een plus tussen elk woord
$lang = array_merge($lang,array(
"REDIR_2FA" => "Sorry.2+factor+is+niet+ingeschakeld+op+dit+moment",
"REDIR_2FA_EN" => "2+factor+authenticatie+ingeschakeld",
"REDIR_2FA_DIS" => "2+Factor+authenticatie+uitgeschakeld",
"REDIR_2FA_VER" => "2+factor+authenticatie+geverifieerd+en+ingeschakeld",
"REDIR_SOM_TING_WONG" => "Er+is+iets+fout+gegaan.+probeer+alstublieft+opnieuw.",
"REDIR_MSG_NOEX" => "Die+thread+hoort+niet+tot+u+of+bestaat+niet.",
"REDIR_UN_ONCE" => "Gebruikersnaam+is+al+eenmaal+gewijzigd.",
"REDIR_EM_SUCC" => "E-mail+succesvol+bijgewerkt",
));

// Emails
$lang = array_merge($lang,array(
"EML_CONF" => "E-mail bevestigen",
"EML_VER" => "Verifieer uw e-mail",
"EML_CHK" => "E-mailverzoek ontvangen. Controleer uw e-mail om verificatie uit te voeren. Controleer uw map met ongewenste e-mail en spam omdat de verificatielink verloopt over",
"EML_MAT" => "Uw e-mailadres komt niet overeen.",
"EML_HELLO" => "Hallo uit",
"EML_HI" => "Hallo",
"EML_AD_HAS" => "Een beheerder heeft uw wachtwoord opnieuw ingesteld.",
"EML_AC_HAS" => "Een beheerder heeft uw account gemaakt.",
"EML_REQ" => "U moet uw wachtwoord instellen met behulp van de bovenstaande link.",
"EML_EXP" => "Let op, wachtwoordlinks verlopen over",
"EML_VER_EXP" => "Let op, verificatielinks verlopen over",
"EML_CLICK" => "Klik hier om in te loggen.",
"EML_REC" => "Het wordt aanbevolen uw wachtwoord te wijzigen bij het inloggen.",
"EML_MSG" => "U hebt een nieuw bericht van",
"EML_REPLY" => "Klik hier om te antwoorden of de discussie te bekijken",
"EML_WHY" => "U ontvangt deze e-mail omdat er een verzoek is ingediend om uw wachtwoord opnieuw in te stellen. Als u dit niet bent, kunt u deze e-mail negeren.",
"EML_HOW" => "Als u dit was, klikt u op de onderstaande link om door te gaan met het proces voor het opnieuw instellen van het wachtwoord.",
"EML_EML" => "Er is een verzoek gedaan om uw e-mail te wijzigen vanuit uw gebruikersaccount.",
"EML_VER_EML" => "Bedankt voor uw aanmelding. Zodra u uw e-mailadres hebt geverifieerd, kunt u zich aanmelden! Klik op de onderstaande link om uw e-mailadres te verifi벥n.",

));

//Verificatie
$lang = array_merge($lang,array(
"VER_SUC" => "Uw e-mail is geverifieerd!",
"VER_FAIL" => "We konden uw account niet verifi벥n. Probeer het opnieuw.",
"VER_RESEND" => "Verificatie-e-mail opnieuw verzonden",
"VER_AGAIN" => "Voer uw e-mailadres in en probeer het opnieuw",
"VER_PAGE" => "<li> Controleer uw e-mail en klik op de link die naar u is verzonden </li> <li> Gereed </li>",
"VER_RES_SUC" => "<p> Uw verificatielink is naar uw e-mailadres verzonden. </p> <p> Klik op de link in de e-mail om de verificatie te voltooien. Controleer uw spam-map als de e-mail niet in uw inbox komt. </p> <p> Verificatielinks zijn alleen geldig voor ",
"VER_OOPS" => "Oeps ... er is iets misgegaan, misschien heeft u op een oude resetlink geklikt. Klik hieronder om het opnieuw te proberen",
"VER_RESET" => "Uw wachtwoord is opnieuw ingesteld!",
"VER_INS" => "<li> Voer uw e-mailadres in en klik op Reset </li> <li> Controleer uw e-mail en klik op de link die naar u is verzonden. </li>
<li> Volg de instructies op het scherm </li> ",
"VER_SENT" => "<p> De link voor het opnieuw instellen van uw wachtwoord is verzonden naar uw e-mailadres. </p>
<p> Klik op de link in de e-mail om uw wachtwoord opnieuw in te stellen. Controleer uw spammap als de e-mail niet in uw inbox staat. </p> <p> Reset-links verlopen over ",
"VER_PLEASE" => "Stel uw wachtwoord opnieuw in",
));

//Gebruikersinstellingen
$lang = array_merge($lang,array(
"SET_PIN" => "Reset PIN",
"SET_WHY" => "Waarom kan ik dit niet wijzigen?",
"SET_PW_MATCH" => "Moet overeenkomen met het nieuwe wachtwoord",

"SET_PIN_NEXT" => "U kunt een nieuwe pincode instellen de volgende keer dat u verificatie vereist",
"SET_UPDATE" => "Wijzig uw gebruikersinstellingen",
"SET_NOCHANGE" => "De beheerder heeft het wijzigen van gebruikersnamen uitgeschakeld.",
"SET_ONECHANGE" => "De beheerder heeft gebruikersnaamwijzigingen zo ingesteld dat deze slechts eenmaal mag wijzigen en u heeft dit al gedaan.",

"SET_GRAVITAR" => "<strong> Wilt u uw profielfoto wijzigen? </strong> <br> Bezoek <a href='https://en.gravatar.com/'> https://en.gravatar.com / </a> en stel een account in met dezelfde e-mail die u op deze site hebt gebruikt. Het werkt op miljoenen sites. Het is snel en gemakkelijk! ",

"SET_NOTE1" => "<p> <strong> Let op </strong> er is een verzoek in behandeling om uw e-mail bij te werken naar",

"SET_NOTE2" => ". </p> <p> Gebruik de verificatie-e-mail om dit verzoek te voltooien. </p>
<p> Als u een nieuwe verificatie-e-mail nodig heeft, voert u de bovenstaande e-mail opnieuw in en verzendt u de aanvraag opnieuw. </p> ",

"SET_PW_REQ" => "vereist voor het wijzigen van het wachtwoord, e-mail of het opnieuw instellen van de pincode",
"SET_PW_REQI" => "Verplicht om uw wachtwoord te wijzigen",

));

// Errors
$lang = array_merge($lang,array(
"ERR_FAIL_ACT" => "Kan actieve sessies niet afbreken, Fout:",
"ERR_EMAIL" => "E-mail NIET verzonden vanwege fout. Neem contact op met de sitebeheerder.",
"ERR_EM_DB" => "Die e-mail bestaat niet in onze database",
"ERR_TC" => "Lees en accepteer de algemene voorwaarden",
"ERR_CAP" => "U heeft de Captcha-test niet goed uitgevoerd, robot!",
"ERR_PW_SAME" => "Uw oude wachtwoord kan niet hetzelfde zijn als uw nieuwe",
"ERR_PW_FAIL" => "Huidige wachtwoordverificatie mislukt. Update mislukt. Probeer het opnieuw.",
"ERR_GOOG" => "<strong> OPMERKING: </strong> als u zich oorspronkelijk heeft aangemeld met uw Google / Facebook-account, moet u de link voor het vergeten wachtwoord gebruiken om uw wachtwoord te wijzigen... tenzij u er echt goed bent in gissen.",
"ERR_EM_VER" => "E-mailverificatie is niet ingeschakeld. Neem contact op met de systeembeheerder.",
"ERR_EMAIL_STR" => "Er is iets vreemds. Controleer uw e-mail opnieuw. Onze excuses voor het ongemak",

));

// onderhoudspagina
$lang = array_merge($lang,array(
"MAINT_HEAD" => "We komen snel terug!",
"MAINT_MSG" => "Sorry voor het ongemak, maar we voeren momenteel wat onderhoud uit. <br> We zijn binnenkort weer online!",
"MAINT_BAN" => "Sorry. U bent verbannen. Als u denkt dat dit een fout is, neem dan contact op met de beheerder.",
"MAINT_TOK" => "Er is een fout opgetreden met uw formulier. Ga terug en probeer het opnieuw. Houd er rekening mee dat het verzenden van het formulier door de pagina te vernieuwen een fout zal veroorzaken. Neem contact op met de beheerder als dit blijft gebeuren.",
"MAINT_OPEN" => "Een Open Source PHP Gebruiker Management Framework.",
"MAINT_PLEASE" => "U hebt UserSpice met succes ge﮳talleerd! <br>Om aan de slag te gaan met de documentatie gaat u naar"
));

// dataTables Toegevoegd in 4.4.08
// OPMERKING: verander de woorden zoals _START_ niet tussen de twee _ -symbolen!
$lang = array_merge($lang,array(
"DAT_SEARCH" => "Zoeken",
"DAT_FIRST" => "Eerste",
"DAT_LAST" => "Laatste",
"DAT_NEXT" => "Volgende",
"DAT_PREV" => "Vorige",
"DAT_NODATA" => "Geen gegevens beschikbaar in tabel",
"DAT_INFO" => "_START_ to _END_ of _TOTAL_ vermeldingen worden weergegeven",
"DAT_ZERO" => "Toont 0 tot 0 van 0 vermeldingen",
"DAT_FILTERED" => "(gefilterd uit _MAX_ totale vermeldingen)",
"DAT_MENU_LENG" => "Toon _MENU_ items",
"DAT_LOADING" => "Bezig met laden ...",
"DAT_PROCESS" => "Bezig met verwerken ...",
"DAT_NO_REC" => "Geen overeenkomende records gevonden",
"DAT_ASC" => "Activeer om de kolom oplopend te sorteren",
"DAT_DESC" => "Activeer om kolom aflopend te sorteren",
));


////////////////////////////////////////////////// /////////////

// Backend-vertalingen voor UserSpice 5
$lang = array_merge($lang,array(
"BE_DASH" => "Dashboard",
"BE_SETTINGS" => "Instellingen",
"BE_GEN" => "Algemeen",
"BE_REG" => "Registratie",
"BE_CUS" => "Aangepaste instellingen",
"BE_DASH_ACC" => "Dashboard-toegang",
"BE_TOOLS" => "Tools",
"BE_BACKUP" => "Backup",
"BE_UPDATE" => "Updates",
"BE_CRON" => "Cron-taken",
"BE_IP" => "IP-beheer",
));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
 //do not put a closing php tag here
