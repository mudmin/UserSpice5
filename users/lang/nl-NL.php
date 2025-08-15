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
//You definitely want to customize these for your language
$lang = array_merge($lang, array(
	"THIS_LANGUAGE" => "Nederlands",
	"THIS_CODE" => "nl-NL",
	"MISSING_TEXT" => "Tekst niet aanwezig",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"    => "Voer de code in die naar uw e-mail is verzonden",
    "PASS_EMAIL_ONLY"    => "Controleer uw e-mail voor een inloglink.",
    "PASS_CODE_ONLY"     => "Voer de code in die naar uw e-mail is verzonden.",
    "PASS_BOTH"          => "Controleer uw e-mail voor een inloglink of voer de code in die naar uw e-mail is verzonden.",
    "PASS_VER_BUTTON"    => "Code verifiëren",
    "PASS_EMAIL_ONLY_MSG" => "Verifieer uw e-mailadres door op onderstaande link te klikken.",
    "PASS_CODE_ONLY_MSG"  => "Voer onderstaande code in om in te loggen.",
    "PASS_BOTH_MSG"       => "Verifieer uw e-mailadres door op onderstaande link te klikken of voer onderstaande code in om in te loggen.",
    "PASS_YOUR_CODE"      => "Uw verificatiecode is: ",
    "PASS_CONFIRM_LOGIN"  => "Bevestig inloggen",
    "PASS_CONFIRM_CLICK"  => "Klik om inloggen te voltooien",
    "PASS_GENERIC_ERROR"  => "Er is iets misgegaan.",
));

// Databasemenu's
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"SIGNUP_TEXT" => "Registreren",
	"SIGNUP_BUTTONTEXT" => "Registreer mij",
	"SIGNUP_AUDITTEXT" => "Geregistreerd",
));

// Aanmelden
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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

// Passkey Translations
$lang = array_merge($lang, array(
    "GEN_PASSKEY"           => "Passkey",
    "GEN_ACTIONS"           => "Acties",
    "GEN_BACK_TO_ACCT"      => "Terug naar account",
    "GEN_DB_ERROR"          => "Er is een databasefout opgetreden. Probeer het opnieuw.",
    "GEN_IMPORTANT"         => "Belangrijk",
    "GEN_NO_PERMISSIONS"    => "Je hebt geen toegang tot deze pagina.",
    "GEN_NO_PERMISSIONS_MSG" => "Je hebt geen toegang tot deze pagina. Neem contact op met de sitebeheerder als je denkt dat dit een fout is.",
    "PASSKEYS_MANAGE_TITLE" => "Passkeys beheren",
    "PASSKEYS_LOGIN_TITLE"  => "Inloggen met passkey",
    "PASSKEY_DELETE_SUCCESS" => "Passkey succesvol verwijderd.",
    "PASSKEY_DELETE_FAIL_DB" => "Kon passkey niet verwijderen uit de database.",
    "PASSKEY_DELETE_NOT_FOUND" => "Passkey niet gevonden of je hebt geen toestemming om deze te verwijderen.",
    "PASSKEY_NOTE_UPDATE_SUCCESS" => "Passkey-notitie succesvol bijgewerkt.",
    "PASSKEY_NOTE_UPDATE_FAIL" => "Kon passkey-notitie niet bijwerken.",
    "PASSKEY_REGISTER_NEW"  => "Nieuwe passkey registreren",
    "PASSKEY_ERR_LIMIT_REACHED" => "Je hebt het maximum van 10 passkeys bereikt.",
    "PASSKEY_NOTE_TH"       => "Passkey-notitie",
    "PASSKEY_TIMES_USED_TH" => "Aantal keren gebruikt",
    "PASSKEY_LAST_USED_TH"  => "Laatst gebruikt",
    "PASSKEY_LAST_IP_TH"    => "Laatste IP",
    "PASSKEY_EDIT_NOTE_BTN" => "Notitie bewerken",
    "PASSKEY_CONFIRM_DELETE_JS" => "Weet je zeker dat je deze passkey wilt verwijderen?",
    "PASSKEY_EDIT_MODAL_TITLE" => "Passkey-notitie bewerken",
    "PASSKEY_EDIT_MODAL_LABEL" => "Passkey-notitie",
    "PASSKEY_SAVE_CHANGES_BTN" => "Wijzigingen opslaan",
    "PASSKEY_NONE_REGISTERED" => "Je hebt nog geen passkeys geregistreerd.",
    "PASSKEY_MUST_REGISTER_FIRST" => "Je moet eerst een passkey registreren vanuit een geverifieerd account voordat je deze functie kunt gebruiken.",
    "PASSKEY_STORING"       => "Passkey wordt opgeslagen...",
    "PASSKEY_STORED_SUCCESS" => "Passkey succesvol opgeslagen!",
    "PASSKEY_INVALID_ACTION" => "Ongeldige actie: ",
    "PASSKEY_NO_ACTION_SPECIFIED" => "Geen actie gespecificeerd",
    "PASSKEY_ERR_NETWORK_SUGGESTION" => "Netwerkprobleem gedetecteerd. Probeer een ander netwerk of vernieuw de pagina.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "Cross-device authenticatie gedetecteerd. Zorg ervoor dat beide apparaten internettoegang hebben.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "Probeer deze pagina direct op je telefoon te openen.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED" => "Kon geen diagnostiek genereren: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA" => "Vereiste gegevens voor authenticatie ontbreken voor opslag.",
    "PASSKEY_MISSING_AUTH_DATA" => "Vereiste authenticatiegegevens ontbreken.",
    "PASSKEY_LOG_NO_MESSAGE" => "Geen bericht",
    "PASSKEY_USER_NOT_FOUND" => "Gebruiker niet gevonden na passkey-validatie.",
    "PASSKEY_FATAL_ERROR"    => "Fatale fout: ",
    "PASSKEY_LOGIN_SUCCESS"  => "Inloggen geslaagd.",
    "PASSKEY_CROSS_DEVICE_PREP" => "Voorbereiden van cross-device registratie. Mogelijk moet je je telefoon of tablet gebruiken.",
    "PASSKEY_DEVICE_REGISTRATION" => "Gebruik van passkey-registratie op apparaat...",
    "PASSKEY_STARTING_REGISTRATION" => "Starten van passkey-registratie...",
    "PASSKEY_REQUEST_OPTIONS" => "Registratieopties aanvragen bij server...",
    "PASSKEY_FOLLOW_PROMPTS" => "Volg de aanwijzingen om je passkey te maken. Mogelijk moet je een ander apparaat gebruiken.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE" => "Volg de aanwijzingen om je passkey te maken...",
    "PASSKEY_CREATION_FAILED" => "Passkey-aanmaak mislukt - geen credentials geretourneerd.",
    "PASSKEY_STORING_SERVER" => "Je passkey wordt opgeslagen...",
    "PASSKEY_CREATED_SUCCESS" => "Passkey succesvol aangemaakt!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP" => "Voorbereiden van cross-device authenticatie. Zorg ervoor dat je telefoon en computer internettoegang hebben.",
    "PASSKEY_DEVICE_AUTH"    => "Gebruik van passkey-authenticatie op apparaat...",
    "PASSKEY_STARTING_AUTH"  => "Starten van passkey-authenticatie...",
    "PASSKEY_QR_CODE_INSTRUCTION" => "Scan de QR-code met je telefoon wanneer deze verschijnt. Zorg ervoor dat beide apparaten internettoegang hebben.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION" => "Kies 'Gebruik een telefoon of tablet' wanneer gevraagd, en scan vervolgens de QR-code.",
    "PASSKEY_AUTHENTICATING" => "Authenticeren met je passkey...",
    "PASSKEY_SUCCESS_REDIRECTING" => "Authenticatie geslaagd! Doorverwijzen...",
    "PASSKEY_TIMEOUT_CROSS_DEVICE" => "Registratie verlopen. Voor cross-device: 1) Probeer opnieuw, 2) Zorg ervoor dat apparaten internet hebben, 3) Overweeg direct op je telefoon te registreren.",
    "PASSKEY_TIMEOUT_SIMPLE" => "Registratie verlopen. Probeer opnieuw.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE" => "Cross-device authenticatie verlopen. Probleemoplossing: 1) Beide apparaten hebben internet nodig, 2) Probeer de QR-code sneller te scannen, 3) Overweeg hetzelfde apparaat te gebruiken, 4) Sommige netwerken blokkeren cross-device authenticatie.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE" => "Authenticatie verlopen. Probeer opnieuw.",
    "PASSKEY_NO_CREDENTIAL"  => "Geen credential ontvangen. Opnieuw proberen...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL" => "Authenticatie mislukt - geen credential geretourneerd.",
    "PASSKEY_ATTEMPT_RETRY"  => "mislukt. Opnieuw proberen... (%d pogingen over)",
    "PASSKEY_CROSS_DEVICE_FAILED" => "Cross-device registratie mislukt. Probeer: 1) Zorg ervoor dat beide apparaten internet hebben, 2) Overweeg direct op je telefoon te registreren, 3) Sommige bedrijfsnetwerken blokkeren deze functie.",
    "PASSKEY_REGISTRATION_CANCELLED" => "Registratie geannuleerd of apparaat ondersteunt geen passkeys.",
    "PASSKEY_NOT_SUPPORTED"  => "Passkeys worden niet ondersteund op deze combinatie van apparaat/browser.",
    "PASSKEY_SECURITY_ERROR" => "Beveiligingsfout - dit wijst meestal op een mismatch van domein/oorsprong.",
    "PASSKEY_ALREADY_EXISTS" => "Er bestaat al een passkey voor dit account op dit apparaat. Probeer een ander apparaat te gebruiken of verwijder eerst bestaande passkeys.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED" => "Cross-device authenticatie mislukt. Probeer: 1) Zorg ervoor dat beide apparaten stabiel internet hebben, 2) Gebruik indien mogelijk hetzelfde WiFi-netwerk, 3) Probeer direct op je telefoon te authenticeren, 4) Sommige bedrijfsnetwerken blokkeren deze functie.",
    "PASSKEY_AUTH_CANCELLED" => "Authenticatie geannuleerd of geen passkey geselecteerd.",
    "PASSKEY_NETWORK_ERROR"  => "Netwerkfout. Voor cross-device authenticatie moeten beide apparaten internettoegang hebben en mogelijk op hetzelfde netwerk zijn.",
    "PASSKEY_CREDENTIAL_NOT_FOUND" => "Authenticatie mislukt - credential niet herkend.",
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "Tips voor cross-device authenticatie:",
    "PASSKEY_GUIDANCE_INTERNET" => "Zorg ervoor dat zowel je computer als je telefoon internettoegang hebben",
    "PASSKEY_GUIDANCE_WIFI"  => "Op hetzelfde WiFi-netwerk zijn kan helpen (maar is niet altijd nodig)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE" => "Kies 'Gebruik een telefoon of tablet' wanneer gevraagd",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY" => "Scan de QR-code snel wanneer deze verschijnt",
    "PASSKEY_GUIDANCE_TRY_DIRECT" => "Als het mislukt, probeer te vernieuwen en gebruik de browser van je telefoon direct",
    "PASSKEY_SHOW_TROUBLESHOOTING" => "Toon tips voor probleemoplossing",
    "PASSKEY_HIDE_TROUBLESHOOTING" => "Verberg tips voor probleemoplossing",
    "PASSKEY_DIAGNOSTICS_RUNNING" => "Diagnostiek wordt uitgevoerd...",
    "PASSKEY_DIAGNOSTICS_COMPLETE" => "Diagnostiek voltooid. Controleer de console voor details.",
    "PASSKEY_ISSUES_DETECTED" => "Problemen gedetecteerd:",
    "PASSKEY_ENVIRONMENT_SUITABLE" => "De omgeving lijkt geschikt voor passkeys.",
    "PASSKEY_DIAGNOSTICS_FAILED" => "Diagnostiek mislukt:",
    "PASSKEY_ADD_NOTE_NEW"  => "Voeg een notitie toe aan je nieuwe passkey",
    "PASSKEY_BASE64_ERROR"  => "Base64 decodeerfout:",
    "PASSKEY_INVALID_JSON"  => "Ongeldige JSON-gegevens ontvangen:",
    "PASSKEY_LOGIN_REQUIRED" => "Je moet ingelogd zijn om deze actie uit te voeren.",
    "PASSKEY_ACTION_MISSING" => "De vereiste 'actie' parameter ontbreekt in het verzoek.",
    "PASSKEY_STORAGE_FAILED" => "Kon de passkey niet opslaan. De operatie is niet gelukt.",
    "PASSKEY_LOGIN_FAILED"   => "Inloggen met passkey mislukt. De authenticatie kon niet worden geverifieerd.",
    "PASSKEY_INVALID_METHOD" => "Ongeldige verzoekmethode:",
    "CSRF_ERROR"            => "CSRF-token controle mislukt. Ga terug en probeer het formulier opnieuw in te dienen.",
    "PASSKEY_NETWORK_PRIVATE" => "Mogelijk probleem: Je lijkt op een privénetwerk te zitten, wat soms kan interfereren met cross-device communicatie.",
    "PASSKEY_NETWORK_PROXY"  => "Mogelijk probleem: Een proxy of VPN gedetecteerd. Dit kan interfereren met cross-device communicatie.",
    "PASSKEY_NETWORK_MOBILE" => "Opmerking: Je lijkt op een mobiel netwerk te zitten. Zorg voor een stabiele verbinding voor cross-device operaties.",
    "PASSKEY_NETWORK_CORPORATE" => "Mogelijk probleem: Een bedrijfsfirewall kan actief zijn, wat cross-device authenticatie kan beïnvloeden.",
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "Aanbeveling: Je gebruikt waarschijnlijk een desktop. Bereid je voor om je telefoon te gebruiken om een QR-code te scannen.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "Aanbeveling: Voor de beste resultaten, zorg ervoor dat je computer en mobiele apparaat op hetzelfde WiFi-netwerk zijn.",
    "PASSKEY_RECOMMENDATION_QR_QUICK" => "Aanbeveling: Wees voorbereid om de QR-code snel te scannen, aangezien het verzoek kan verlopen.",
    "PASSKEY_RECOMMENDATION_INTERNET" => "Aanbeveling: Zorg ervoor dat zowel je computer als je mobiele apparaat een stabiele internetverbinding hebben.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "Aanbeveling: Voor Unity WebViews, zorg ervoor dat de pagina voldoende tijd heeft om te laden en de passkey-verzoek te verwerken.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "Aanbeveling: Time-outs kunnen langer zijn in Unity. Wees geduldig.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "Aanbeveling: Aangezien je op een mobiel apparaat bent, zou je direct een passkey op dit apparaat moeten kunnen registreren.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Aanbeveling: Op Android kun je je passkeys beheren in de Google Wachtwoordmanager.",
    "PASSKEY_VALIDATION_RP_IP" => "Configuratiewaarschuwing: De Relying Party ID is ingesteld op een IP-adres.",
    "PASSKEY_VALIDATION_RP_DOMAIN" => "Aanbeveling: Stel de Relying Party ID in op je domeinnaam (bijv. jouwwebsite.nl) voor betere beveiliging en compatibiliteit.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED" => "Configuratiefout: HTTPS is vereist voor passkeys op een live server. Je site lijkt op HTTP te draaien.",
    "PASSKEY_VALIDATION_NETWORK" => "Netwerkwaarschuwing",
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "Aanbeveling: Als je problemen ondervindt, probeer een ander netwerk (bijv. schakel van bedrijfs-WiFi naar een mobiele hotspot).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "Aanbeveling: Voor cross-device acties, zorg ervoor dat beide apparaten een betrouwbare internetverbinding hebben.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK" => "Aanbeveling: Als cross-device acties mislukken, probeer deze pagina direct op je mobiele apparaat te bezoeken om de actie te voltooien.",
    "PASSKEY_INFO_TITLE"    => "Over Passkeys",
    "PASSKEY_INFO_DESC"     => "Passkeys zijn een veilige, wachtwoordloze manier om in te loggen met behulp van de ingebouwde beveiligingsfuncties van je apparaat, zoals vingerafdruk, gezichtsherkenning of PIN. Ze zijn veiliger dan wachtwoorden, bieden snellere toegang, werken op meerdere apparaten wanneer gesynchroniseerd met wachtwoordmanagers en zijn bestand tegen phishing-aanvallen. Passkeys werken op moderne smartphones, tablets, computers en kunnen worden opgeslagen in wachtwoordmanagers zoals 1Password, Bitwarden, iCloud Keychain of Google Wachtwoordmanager.",
    "PASSKEY_BACK_TO_LOGIN" => "Terug naar inloggen",
));

// validatieklasse
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"JOIN_SUC" => "Welkom bij",
	"JOIN_THANKS" => "Bedankt voor het registreren!",
	"JOIN_HAVE" => "Heeft tenminste",
	"JOIN_LOWER"	=> " kleine letter",
	"JOIN_SYMBOL"		=> " symbool",
	"JOIN_CAP" => " hoofdletter",
	"JOIN_TWICE" => " Twee keer correct worden getypt",
	"JOIN_CLOSED" => "Helaas is registratie momenteel uitgeschakeld. Neem contact op met de sitebeheerder als u vragen of opmerkingen hebt.",
	"JOIN_TC" => "Algemene gebruiksvoorwaarden voor registratie",
	"JOIN_ACCEPTTC" => "Ik accepteer de gebruikersvoorwaarden",
	"JOIN_CHANGED" => "Onze voorwaarden zijn gewijzigd",
	"JOIN_ACCEPT" => "Gebruikersvoorwaarden accepteren en doorgaan",
	"JOIN_SCORE" => "Score:",
	"JOIN_INVALID_PW" => "Uw wachtwoord is ongeldig",

));

// Sessions
$lang = array_merge($lang, array(
	"SESS_SUC" => "Met succes afgebroken",
));

// Berichten
$lang = array_merge($lang, array(
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

// Two Factor Authentication Translations
$lang = array_merge($lang, array(
    "2FA"               => "Tweedelige authenticatie",
    "2FA_CONF"          => "Weet je zeker dat je 2FA wilt uitschakelen? Je account is dan niet langer beveiligd.",
    "2FA_SCAN"          => "Scan deze QR-code met je authenticator-app of voer de sleutel in",
    "2FA_THEN"          => "Voer vervolgens een van je eenmalige passkeys hier in",
    "2FA_FAIL"          => "Er was een probleem bij het verifiëren van 2FA. Controleer je internetverbinding of neem contact op met ondersteuning.",
    "2FA_CODE"          => "2FA-code",
    "2FA_EXP"           => "1 vingerafdruk verlopen",
    "2FA_EXPD"          => "Verlopen",
    "2FA_EXPS"          => "Verloopt",
    "2FA_ACTIVE"        => "Actieve sessies",
    "2FA_NOT_FN"        => "Geen vingerafdrukken gevonden",
    "2FA_FP"            => "Vingerafdrukken",
    "2FA_NP"            => "Inloggen mislukt. De tweedelige authenticatiecode was niet aanwezig. Probeer opnieuw.",
    "2FA_INV"           => "Inloggen mislukt. De tweedelige authenticatiecode was ongeldig. Probeer opnieuw.",
    "2FA_FATAL"         => "Fatale fout. Neem contact op met de systeembeheerder. We kunnen op dit moment geen tweedelige authenticatiecode genereren.",
    "2FA_SECTION_TITLE" => "Tweedelige authenticatie (TOTP)",
    "2FA_SK_ALT"       => "Als je de QR-code niet kunt scannen, voer deze geheime sleutel handmatig in je authenticator-app in.",
    "2FA_IS_ENABLED"    => "Tweedelige authenticatie beschermt je account.",
    "2FA_NOT_ENABLED_INFO" => "Tweedelige authenticatie is momenteel niet ingeschakeld.",
    "2FA_NOT_ENABLED_EXPLAIN" => "Tweedelige authenticatie (TOTP) voegt een extra beveiligingslaag toe aan je account door een code te vereisen van een authenticator-app op je telefoon naast je wachtwoord.",
    "2FA_SETUP_TITLE"  => "Tweedelige authenticatie instellen",
    "2FA_SECRET_KEY_LABEL" => "Geheime sleutel:",
    "2FA_SETUP_VERIFY_CODE_LABEL" => "Voer de verificatiecode van de app in",
    "2FA_SUCCESS_ENABLED_TITLE" => "Tweedelige authenticatie ingeschakeld! Bewaar je back-upcodes",
    "2FA_SUCCESS_ENABLED_INFO" => "Hieronder staan je back-upcodes. Bewaar ze veilig - elke code kan slechts één keer worden gebruikt.",
    "2FA_BACKUP_CODES_WARNING" => "Behandel deze codes als wachtwoorden. Bewaar ze veilig.",
    "2FA_SUCCESS_BACKUP_REGENERATED" => "Nieuwe back-upcodes gegenereerd. Bewaar ze veilig.",
    "2FA_BACKUP_CODE_LABEL" => "Back-upcode",
    "2FA_REGEN_CODES_BTN" => "Back-upcodes opnieuw genereren",
    "2FA_INVALIDATE_WARNING" => "Dit zal alle bestaande back-upcodes ongeldig maken. Weet je het zeker?",
    "2FA_CODE_LABEL"    => "Authenticatiecode",
    "2FA_VERIFY_BTN"    => "Verifiëren & inloggen",
    "2FA_VERIFY_TITLE"  => "Tweedelige authenticatie vereist",
    "2FA_VERIFY_INFO"   => "Voer de 6-cijferige code in van je authenticator-app.",
    "2FA_ENABLE_BTN"    => "Tweedelige authenticatie inschakelen",
    "2FA_DISABLE_BTN"   => "Tweedelige authenticatie uitschakelen",
    "2FA_VERIFY_ACTIVATE_BTN" => "Verifiëren & activeren",
    "2FA_CANCEL_SETUP_BTN" => "Installatie annuleren",
    "2FA_DONE_BTN"      => "Klaar",
    "REDIR_2FA_DIS"     => "Tweedelige authenticatie is uitgeschakeld.",
    "2FA_SUCCESS_BACKUP_ACK" => "Back-upcodes bevestigd.",
    "2FA_SUCCESS_SETUP_CANCELLED" => "Installatie geannuleerd.",
    "2FA_ERR_INVALID_BACKUP" => "Ongeldige back-upcode. Probeer opnieuw.",
    "2FA_ERR_DISABLE_FAILED" => "Kon tweedelige authenticatie niet uitschakelen.",
    "2FA_ERR_NO_SECRET" => "Kon het authenticatiegeheim niet ophalen. Probeer opnieuw.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL" => "Back-upcode geverifieerd maar kon niet worden ongeldig gemaakt. Neem contact op met ondersteuning.",
    "2FA_ERR_NO_CODE_PROVIDED" => "Geen authenticatiecode opgegeven.",
    "RATE_LIMIT_LOGIN"   => "Te veel mislukte inlogpogingen. Wacht even voordat je opnieuw probeert.",
    "RATE_LIMIT_TOTP"    => "Te veel onjuiste authenticatiecodes. Wacht even voordat je opnieuw probeert.",
    "RATE_LIMIT_PASSKEY" => "Te veel passkey-authenticatiepogingen. Wacht even voordat je opnieuw probeert.",
    "RATE_LIMIT_PASSKEY_STORE" => "Te veel passkey-registratiepogingen. Wacht even voordat je opnieuw probeert.",
    "RATE_LIMIT_PASSWORD_RESET" => "Te veel verzoeken om wachtwoordherstel. Wacht even voordat je een nieuw herstel aanvraagt.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT" => "Te veel pogingen voor wachtwoordherstel. Wacht even voordat je opnieuw probeert.",
    "RATE_LIMIT_REGISTRATION" => "Te veel registratiepogingen. Wacht even voordat je opnieuw probeert.",
    "RATE_LIMIT_EMAIL_VERIFICATION" => "Te veel e-mailverificatieverzoeken. Wacht even voordat je een nieuwe verificatie aanvraagt.",
    "RATE_LIMIT_EMAIL_CHANGE" => "Te veel verzoeken om e-mailwijziging. Wacht even voordat je opnieuw probeert.",
    "RATE_LIMIT_PASSWORD_CHANGE" => "Te veel pogingen voor wachtwoordwijziging. Wacht even voordat je opnieuw probeert.",
    "RATE_LIMIT_GENERIC" => "Te veel pogingen. Wacht even voordat je opnieuw probeert.",
));

// Omleidingsberichten - deze krijgen een plus tussen elk woord
$lang = array_merge($lang, array(
	"REDIR_2FA" => "Sorry.2 factor is niet ingeschakeld op dit moment",
	"REDIR_2FA_EN" => "2 factor authenticatie ingeschakeld",
	"REDIR_2FA_DIS" => "2 Factor authenticatie uitgeschakeld",
	"REDIR_2FA_VER" => "2 factor authenticatie geverifieerd en ingeschakeld",
	"REDIR_SOMETHING_WRONG" => "Er is iets fout gegaan. probeer alstublieft opnieuw.",
	"REDIR_MSG_NOEX" => "Die thread hoort niet tot u of bestaat niet.",
	"REDIR_UN_ONCE" => "Gebruikersnaam is al eenmaal gewijzigd.",
	"REDIR_EM_SUCC" => "E-mail succesvol bijgewerkt",
));

// Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "Inloggen met:",
	"EML_FEATURE_DISABLED" => "Deze functie is uitgeschakeld",
	"EML_PASSWORDLESS_SENT" => "Controleer uw e-mail voor een link om in te loggen.",
	"EML_PASSWORDLESS_SUBJECT" => "Controleer uw e-mail om in te loggen.",
	"EML_PASSWORDLESS_BODY" => "Controleer uw e-mailadres door op de onderstaande link te klikken. U wordt automatisch ingelogd.",

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
$lang = array_merge($lang, array(
	"VER_SUC" => "Uw e-mail is geverifieerd!",
	"VER_FAIL" => "We konden uw account niet verifi벥n. Probeer het opnieuw.",
	"VER_RESEND" => "Verificatie-e-mail opnieuw verzonden",
	"VER_AGAIN" => "Voer uw e-mailadres in en probeer het opnieuw",
	"VER_PAGE" => "<li> Controleer uw e-mail en klik op de link die naar u is verzonden </li> <li> Gereed </li>",
	"VER_RES_SUC" => "  Uw verificatielink is naar uw e-mailadres verzonden.     Klik op de link in de e-mail om de verificatie te voltooien. Controleer uw spam-map als de e-mail niet in uw inbox komt.     Verificatielinks zijn alleen geldig voor ",
	"VER_OOPS" => "Oeps ... er is iets misgegaan, misschien heeft u op een oude resetlink geklikt. Klik hieronder om het opnieuw te proberen",
	"VER_RESET" => "Uw wachtwoord is opnieuw ingesteld!",
	"VER_INS" => "<li> Voer uw e-mailadres in en klik op Reset </li> <li> Controleer uw e-mail en klik op de link die naar u is verzonden. </li>
<li> Volg de instructies op het scherm </li> ",
	"VER_SENT" => "  De link voor het opnieuw instellen van uw wachtwoord is verzonden naar uw e-mailadres.  
  Klik op de link in de e-mail om uw wachtwoord opnieuw in te stellen. Controleer uw spammap als de e-mail niet in uw inbox staat.     Reset-links verlopen over ",
	"VER_PLEASE" => "Stel uw wachtwoord opnieuw in",
));

//Gebruikersinstellingen
$lang = array_merge($lang, array(
	"SET_PIN" => "Reset PIN",
	"SET_WHY" => "Waarom kan ik dit niet wijzigen?",
	"SET_PW_MATCH" => "Moet overeenkomen met het nieuwe wachtwoord",

	"SET_PIN_NEXT" => "U kunt een nieuwe pincode instellen de volgende keer dat u verificatie vereist",
	"SET_UPDATE" => "Wijzig uw gebruikersinstellingen",
	"SET_NOCHANGE" => "De beheerder heeft het wijzigen van gebruikersnamen uitgeschakeld.",
	"SET_ONECHANGE" => "De beheerder heeft gebruikersnaamwijzigingen zo ingesteld dat deze slechts eenmaal mag wijzigen en u heeft dit al gedaan.",

	"SET_GRAVITAR" => " Wilt u uw profielfoto wijzigen?   <br> Bezoek <a href='https://en.gravatar.com/'> https://en.gravatar.com / </a> en stel een account in met dezelfde e-mail die u op deze site hebt gebruikt. Het werkt op miljoenen sites. Het is snel en gemakkelijk! ",

	"SET_NOTE1" => "   Let op   er is een verzoek in behandeling om uw e-mail bij te werken naar",

	"SET_NOTE2" => ".     Gebruik de verificatie-e-mail om dit verzoek te voltooien.  
  Als u een nieuwe verificatie-e-mail nodig heeft, voert u de bovenstaande e-mail opnieuw in en verzendt u de aanvraag opnieuw.   ",

	"SET_PW_REQ" => "vereist voor het wijzigen van het wachtwoord, e-mail of het opnieuw instellen van de pincode",
	"SET_PW_REQI" => "Verplicht om uw wachtwoord te wijzigen",

));

// Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT" => "Kan actieve sessies niet afbreken, Fout:",
	"ERR_EMAIL" => "E-mail NIET verzonden vanwege fout. Neem contact op met de sitebeheerder.",
	"ERR_EM_DB" => "Die e-mail bestaat niet in onze database",
	"ERR_TC" => "Lees en accepteer de algemene voorwaarden",
	"ERR_CAP" => "U heeft de Captcha-test niet goed uitgevoerd, robot!",
	"ERR_PW_SAME" => "Uw oude wachtwoord kan niet hetzelfde zijn als uw nieuwe",
	"ERR_PW_FAIL" => "Huidige wachtwoordverificatie mislukt. Update mislukt. Probeer het opnieuw.",
	"ERR_GOOG" => " OPMERKING:   als u zich oorspronkelijk heeft aangemeld met uw Google / Facebook-account, moet u de link voor het vergeten wachtwoord gebruiken om uw wachtwoord te wijzigen... tenzij u er echt goed bent in gissen.",
	"ERR_EM_VER" => "E-mailverificatie is niet ingeschakeld. Neem contact op met de systeembeheerder.",
	"ERR_EMAIL_STR" => "Er is iets vreemds. Controleer uw e-mail opnieuw. Onze excuses voor het ongemak",

));

// onderhoudspagina
$lang = array_merge($lang, array(
	"MAINT_HEAD" => "We komen snel terug!",
	"MAINT_MSG" => "Sorry voor het ongemak, maar we voeren momenteel wat onderhoud uit. <br> We zijn binnenkort weer online!",
	"MAINT_BAN" => "Sorry. U bent verbannen. Als u denkt dat dit een fout is, neem dan contact op met de beheerder.",
	"MAINT_TOK" => "Er is een fout opgetreden met uw formulier. Ga terug en probeer het opnieuw. Houd er rekening mee dat het verzenden van het formulier door de pagina te vernieuwen een fout zal veroorzaken. Neem contact op met de beheerder als dit blijft gebeuren.",
	"MAINT_OPEN" => "Een Open Source PHP Gebruiker Management Framework.",
	"MAINT_PLEASE" => "U hebt UserSpice met succes ge﮳talleerd! <br>Om aan de slag te gaan met de documentatie gaat u naar"
));

// dataTables Toegevoegd in 4.4.08
// OPMERKING: verander de woorden zoals _START_ niet tussen de twee _ -symbolen!
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
