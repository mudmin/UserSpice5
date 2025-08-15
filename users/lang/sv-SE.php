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
%m1% - Dynamic markers which are replaced at run time by the relevant index.
*/

/* Translation assisted by Tekniskedirektorn */

$lang = array();
//important strings
//You definitely want to customize these for your language
$lang = array_merge($lang, array(
	"THIS_LANGUAGE"	=> "Svenska",
	"THIS_CODE"			=> "sv-SE",
	"MISSING_TEXT"	=> "Text saknas",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "Ange koden som skickats till din e-post",
    "PASS_EMAIL_ONLY"     => "Vänligen kontrollera din e-post för en inloggningslänk",
    "PASS_CODE_ONLY"      => "Vänligen ange koden som skickats till din e-post",
    "PASS_BOTH"           => "Vänligen kontrollera din e-post för en inloggningslänk eller ange koden som skickats",
    "PASS_VER_BUTTON"     => "Verifiera kod",
    "PASS_EMAIL_ONLY_MSG" => "Vänligen verifiera din e-postadress genom att klicka på länken nedan",
    "PASS_CODE_ONLY_MSG"  => "Vänligen ange koden nedan för att logga in",
    "PASS_BOTH_MSG"       => "Vänligen verifiera din e-postadress genom att klicka på länken nedan eller ange koden för att logga in",
    "PASS_YOUR_CODE"      => "Din verifieringskod är: ",
    "PASS_CONFIRM_LOGIN"  => "Bekräfta inloggning",
    "PASS_CONFIRM_CLICK"  => "Klicka för att slutföra inloggningen",
    "PASS_GENERIC_ERROR"  => "Något gick fel",
));

//Database Menus
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"					=> "Registrera",
	"SIGNUP_BUTTONTEXT"		=> "Registera mig",
	"SIGNUP_AUDITTEXT"		=> "Registerad",
));

// Signin
$lang = array_merge($lang, array(
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
	"SIGNIN_FORGOTPASS"	=> "Glömt lösenord",
	"SIGNOUT_AUDITTEXT"	=> "Utloggad",
));

// Account Page
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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

//added during passkey/totp update
$lang = array_merge($lang, array(
    "GEN_PASSKEY"                         => "Lösennyckel",
    "GEN_ACTIONS"                         => "Åtgärder",
    "GEN_BACK_TO_ACCT"                    => "Tillbaka till kontot",
    "GEN_DB_ERROR"                        => "Ett databasfel uppstod. Vänligen försök igen.",
    "GEN_IMPORTANT"                       => "Viktigt",
    "GEN_NO_PERMISSIONS"                  => "Du har inte behörighet att komma åt den här sidan.",
    "GEN_NO_PERMISSIONS_MSG"              => "Du har inte behörighet att komma åt den här sidan. Om du anser att detta är fel, vänligen kontakta webbplatsens administratör.",
    "PASSKEYS_MANAGE_TITLE"               => "Hantera dina lösennycklar",
    "PASSKEYS_LOGIN_TITLE"                => "Logga in med lösennyckel",
    "PASSKEY_DELETE_SUCCESS"              => "Lösennyckeln har tagits bort.",
    "PASSKEY_DELETE_FAIL_DB"              => "Det gick inte att ta bort lösennyckeln från databasen.",
    "PASSKEY_DELETE_NOT_FOUND"            => "Lösennyckeln hittades inte eller så saknar du behörighet att ta bort den.",
    "PASSKEY_NOTE_UPDATE_SUCCESS"         => "Anteckningen för lösennyckeln har uppdaterats.",
    "PASSKEY_NOTE_UPDATE_FAIL"            => "Det gick inte att uppdatera anteckningen för lösennyckeln.",
    "PASSKEY_REGISTER_NEW"                => "Registrera ny lösennyckel",
    "PASSKEY_ERR_LIMIT_REACHED"           => "Du har nått maxgränsen på 10 lösennycklar.",
    "PASSKEY_NOTE_TH"                     => "Anteckning för lösennyckel",
    "PASSKEY_TIMES_USED_TH"               => "Antal användningar",
    "PASSKEY_LAST_USED_TH"                => "Senast använd",
    "PASSKEY_LAST_IP_TH"                  => "Senaste IP-adress",
    "PASSKEY_EDIT_NOTE_BTN"               => "Redigera anteckning",
    "PASSKEY_CONFIRM_DELETE_JS"           => "Är du säker på att du vill ta bort denna lösennyckel?",
    "PASSKEY_EDIT_MODAL_TITLE"            => "Redigera anteckning för lösennyckel",
    "PASSKEY_EDIT_MODAL_LABEL"            => "Anteckning för lösennyckel",
    "PASSKEY_SAVE_CHANGES_BTN"            => "Spara ändringar",
    "PASSKEY_NONE_REGISTERED"             => "Du har inga registrerade lösennycklar ännu.",
    "PASSKEY_MUST_REGISTER_FIRST"         => "Du måste först registrera en lösennyckel från ett autentiserat konto innan du kan använda den här funktionen.",
    "PASSKEY_STORING"                     => "Sparar lösennyckel...",
    "PASSKEY_STORED_SUCCESS"              => "Lösennyckeln har sparats!",
    "PASSKEY_INVALID_ACTION"              => "Ogiltig åtgärd: ",
    "PASSKEY_NO_ACTION_SPECIFIED"         => "Ingen åtgärd angiven",
    "PASSKEY_ERR_NETWORK_SUGGESTION"      => "Nätverksproblem upptäckt. Prova ett annat nätverk eller uppdatera sidan.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "Autentisering mellan enheter upptäckt. Se till att båda enheterna har internetåtkomst.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "Prova att öppna den här sidan direkt på din telefon istället.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"       => "Kunde inte generera diagnostik: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"     => "Nödvändiga inloggningsuppgifter för lagring saknas.",
    "PASSKEY_MISSING_AUTH_DATA"           => "Nödvändiga autentiseringsuppgifter saknas.",
    "PASSKEY_LOG_NO_MESSAGE"              => "Inget meddelande",
    "PASSKEY_USER_NOT_FOUND"              => "Användaren hittades inte efter validering av lösennyckel.",
    "PASSKEY_FATAL_ERROR"                 => "Allvarligt fel: ",
    "PASSKEY_LOGIN_SUCCESS"               => "Inloggningen lyckades.",
    // JavaScript status messages (passkeys.php)
    "PASSKEY_CROSS_DEVICE_PREP"           => "Förbereder registrering mellan enheter. Du kan behöva använda din telefon eller surfplatta.",
    "PASSKEY_DEVICE_REGISTRATION"         => "Använder enhetens lösennyckelregistrering...",
    "PASSKEY_STARTING_REGISTRATION"       => "Påbörjar registrering av lösennyckel...",
    "PASSKEY_REQUEST_OPTIONS"             => "Begär registreringsalternativ från servern...",
    "PASSKEY_FOLLOW_PROMPTS"              => "Följ anvisningarna för att skapa din lösennyckel. Du kan behöva använda en annan enhet.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"       => "Följ anvisningarna för att skapa din lösennyckel...",
    "PASSKEY_CREATION_FAILED"             => "Skapandet av lösennyckel misslyckades - inga inloggningsuppgifter returnerades.",
    "PASSKEY_STORING_SERVER"              => "Sparar din lösennyckel...",
    "PASSKEY_CREATED_SUCCESS"             => "Lösennyckeln har skapats!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP"      => "Förbereder autentisering mellan enheter. Se till att din telefon och dator har internetåtkomst.",
    "PASSKEY_DEVICE_AUTH"                 => "Använder enhetens lösennyckelautentisering...",
    "PASSKEY_STARTING_AUTH"               => "Påbörjar autentisering med lösennyckel...",
    "PASSKEY_QR_CODE_INSTRUCTION"         => "Skanna QR-koden med din telefon när den visas. Se till att båda enheterna har internetåtkomst.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"    => "Välj \"Använd en telefon eller surfplatta\" när du uppmanas, och skanna sedan QR-koden.",
    "PASSKEY_AUTHENTICATING"              => "Autentiserar med din lösennyckel...",
    "PASSKEY_SUCCESS_REDIRECTING"         => "Autentiseringen lyckades! Omdirigerar...",
    // Timeout messages
    "PASSKEY_TIMEOUT_CROSS_DEVICE"        => "Registreringen tog för lång tid. För registrering mellan enheter: 1) Försök igen, 2) Se till att enheterna har internet, 3) Överväg att registrera direkt på din telefon.",
    "PASSKEY_TIMEOUT_SIMPLE"              => "Registreringen tog för lång tid. Vänligen försök igen.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"   => "Autentisering mellan enheter tog för lång tid. Felsökning: 1) Båda enheterna behöver internet, 2) Försök att skanna QR-koden snabbare, 3) Överväg att använda samma enhet, 4) Vissa nätverk blockerar autentisering mellan enheter.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"         => "Autentiseringen tog för lång tid. Vänligen försök igen.",
    "PASSKEY_NO_CREDENTIAL"               => "Inga inloggningsuppgifter mottagna. Försöker igen...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"   => "Autentiseringen misslyckades - inga inloggningsuppgifter returnerades.",
    "PASSKEY_ATTEMPT_RETRY"               => "misslyckades. Försöker igen... (%d försök kvar)",
    // Error messages
    "PASSKEY_CROSS_DEVICE_FAILED"         => "Registrering mellan enheter misslyckades. Prova: 1) Se till att båda enheterna har internet, 2) Överväg att registrera direkt på din telefon, 3) Vissa företagsnätverk blockerar denna funktion.",
    "PASSKEY_REGISTRATION_CANCELLED"      => "Registreringen avbröts eller så stöder enheten inte lösennycklar.",
    "PASSKEY_NOT_SUPPORTED"               => "Lösennycklar stöds inte på denna kombination av enhet/webbläsare.",
    "PASSKEY_SECURITY_ERROR"              => "Säkerhetsfel - detta indikerar vanligtvis en felmatchning av domän/ursprung.",
    "PASSKEY_ALREADY_EXISTS"              => "En lösennyckel finns redan för detta konto på denna enhet. Prova att använda en annan enhet eller ta bort befintliga lösennycklar först.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"    => "Autentisering mellan enheter misslyckades. Prova: 1) Se till att båda enheterna har stabilt internet, 2) Använd samma WiFi-nätverk om möjligt, 3) Prova att autentisera direkt på din telefon istället, 4) Vissa företagsnätverk blockerar denna funktion.",
    "PASSKEY_AUTH_CANCELLED"              => "Autentiseringen avbröts eller så valdes ingen lösennyckel.",
    "PASSKEY_NETWORK_ERROR"               => "Nätverksfel. För autentisering mellan enheter behöver båda enheterna internetåtkomst och kan behöva vara på samma nätverk.",
    "PASSKEY_CREDENTIAL_NOT_FOUND"        => "Autentiseringen misslyckades - inloggningsuppgifterna kändes inte igen.",
    // Cross-device guidance
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "Tips för autentisering mellan enheter:",
    "PASSKEY_GUIDANCE_INTERNET"           => "Se till att både din dator och telefon har internetåtkomst",
    "PASSKEY_GUIDANCE_WIFI"               => "Att vara på samma WiFi-nätverk kan hjälpa (men är inte alltid nödvändigt)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"      => "När du uppmanas, välj \"Använd en telefon eller surfplatta\"",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"       => "Skanna QR-koden snabbt när den visas",
    "PASSKEY_GUIDANCE_TRY_DIRECT"         => "Om det misslyckas, prova att uppdatera och använda telefonens webbläsare direkt",
    // Troubleshooting
    "PASSKEY_SHOW_TROUBLESHOOTING"        => "Visa felsökningstips",
    "PASSKEY_HIDE_TROUBLESHOOTING"        => "Dölj felsökningstips",
    "PASSKEY_DIAGNOSTICS_RUNNING"         => "Kör diagnostik...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"        => "Diagnostiken är klar. Kontrollera konsolen för detaljer.",
    "PASSKEY_ISSUES_DETECTED"             => "Problem upptäckta:",
    "PASSKEY_ENVIRONMENT_SUITABLE"        => "Miljön verkar vara lämplig för lösennycklar.",
    "PASSKEY_DIAGNOSTICS_FAILED"          => "Diagnostiken misslyckades:",
    // Modal
    "PASSKEY_ADD_NOTE_NEW"                => "Lägg till en anteckning till din nya lösennyckel",
    // Technical errors
    "PASSKEY_BASE64_ERROR"                => "Base64-avkodningsfel:",
    // Server-side errors (passkey_parser.php)
    "PASSKEY_INVALID_JSON"                => "Ogiltig JSON-data mottagen:",
    // Session/validation errors (PasskeyHandler.php)
    "PASSKEY_NO_CHALLENGE_SESSION"        => "Ingen utmaning för lösennyckelregistrering hittades i sessionen. Vänligen försök registrera igen.",
    "PASSKEY_USER_MISMATCH"               => "Användar-ID matchar inte. Vänligen försök registrera igen.",
    "PASSKEY_CHALLENGE_USER_MISMATCH"     => "Användar-ID i utmaningsalternativen matchar inte den aktuella användaren. Vänligen försök registrera igen.",
    "PASSKEY_REGISTRATION_FAILED_ERROR"   => "Registrering av lösennyckel misslyckades. Se till att din enhet och webbläsare stöder WebAuthn och försök igen. Fel:",
    "PASSKEY_NO_AUTH_CHALLENGE_SESSION"   => "Ingen utmaning för lösennyckelverifiering hittades i sessionen. Vänligen försök logga in igen.",
    "PASSKEY_CREDENTIAL_NOT_IN_DB"        => "Lösennyckelns inloggningsuppgifter hittades inte i databasen.",
    "PASSKEY_CREDENTIAL_WRONG_USER"       => "Lösennyckelns inloggningsuppgifter tillhör inte den förväntade användaren.",
    "PASSKEY_VALIDATION_FAILED_ERROR"     => "Validering av lösennyckel misslyckades. Vänligen försök igen eller kontakta support om problemet kvarstår. Fel:",
    "PASSKEY_USER_NOT_FOUND_REGISTRATION" => "Användare för registrering hittades inte.",
    // --- Used in passkey_parser.php ---
    "PASSKEY_LOGIN_REQUIRED"              => "Du måste vara inloggad för att utföra den här åtgärden.",
    "PASSKEY_ACTION_MISSING"              => "Den nödvändiga parametern 'action' saknades i begäran.",
    "PASSKEY_STORAGE_FAILED"              => "Det gick inte att spara lösennyckeln. Operationen misslyckades.",
    "PASSKEY_LOGIN_FAILED"                => "Inloggning med lösennyckel misslyckades. Autentiseringen kunde inte verifieras.",
    "PASSKEY_INVALID_METHOD"              => "Ogiltig anropsmetod:", // The script appends the method name after this key
    // --- Used in passkeys.php ---
    "CSRF_ERROR"                          => "CSRF-tokenkontrollen misslyckades. Gå tillbaka och försök skicka formuläret igen.",
    // Network analysis from analyzeNetworkConditions()
    "PASSKEY_NETWORK_PRIVATE"             => "Möjligt problem: Du verkar vara på ett privat nätverk, vilket ibland kan störa kommunikationen mellan enheter.",
    "PASSKEY_NETWORK_PROXY"               => "Möjligt problem: En proxy eller VPN upptäcktes. Detta kan störa kommunikationen mellan enheter.",
    "PASSKEY_NETWORK_MOBILE"              => "Observera: Du verkar vara på ett mobilt nätverk. Se till att ha en stabil anslutning för operationer mellan enheter.",
    "PASSKEY_NETWORK_CORPORATE"           => "Möjligt problem: En företagsbrandvägg kan vara aktiv, vilket kan påverka autentiseringen mellan enheter.",
    // Recommendations from getCrossDeviceRecommendations()
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "Rekommendation: Du använder troligen en stationär dator. Förbered dig på att använda din telefon för att skanna en QR-kod.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "Rekommendation: För bästa resultat, se till att din dator och mobila enhet är på samma Wi-Fi-nätverk.",
    "PASSKEY_RECOMMENDATION_QR_QUICK"     => "Rekommendation: Var beredd på att skanna QR-koden snabbt, eftersom begäran kan ta för lång tid.",
    "PASSKEY_RECOMMENDATION_INTERNET"     => "Rekommendation: Se till att både din dator och din mobila enhet har en stabil internetanslutning.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "Rekommendation: För Unity WebViews, se till att sidan har tillräckligt med tid för att ladda och bearbeta begäran om lösennyckel.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "Rekommendation: Tidsgränser kan vara längre i Unity. Vänligen ha tålamod.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "Rekommendation: Eftersom du är på en mobil enhet bör du kunna registrera en lösennyckel direkt på den här enheten.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Rekommendation: På Android kan du hantera dina lösennycklar i Google Lösenordshanteraren.",
    // Validation from validateCrossDeviceEnvironment()
    "PASSKEY_VALIDATION_RP_IP"            => "Konfigurationsvarning: Relying Party ID är inställt på en IP-adress.",
    "PASSKEY_VALIDATION_RP_DOMAIN"        => "Rekommendation: Ställ in Relying Party ID till ditt domännamn (t.ex. dinwebbplats.se) för bättre säkerhet och kompatibilitet.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"   => "Konfigurationsfel: HTTPS krävs för att lösennycklar ska fungera på en live-server. Din webbplats verkar vara på HTTP.",
    "PASSKEY_VALIDATION_NETWORK"          => "Nätverksvarning", // Generic prefix for network issues
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "Rekommendation: Om du upplever problem, prova ett annat nätverk (t.ex. byt från företags-Wi-Fi till en mobil hotspot).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "Rekommendation: För åtgärder mellan enheter, se till att båda enheterna har en pålitlig internetanslutning.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"  => "Rekommendation: Om åtgärder mellan enheter misslyckas, prova att besöka den här sidan direkt på din mobila enhet för att slutföra åtgärden.",
    "PASSKEY_INFO_TITLE"                  => "Om lösennycklar",
    "PASSKEY_INFO_DESC"                   => "Lösennycklar är ett säkert, lösenordsfritt sätt att logga in med hjälp av din enhets inbyggda säkerhetsfunktioner som fingeravtryck, ansiktsigenkänning или PIN. De är säkrare än lösenord, ger snabbare inloggning, fungerar över flera enheter när de synkroniseras med lösenordshanterare och är motståndskraftiga mot nätfiskeattacker. Lösennycklar fungerar på moderna smartphones, surfplattor, datorer och kan lagras i lösenordshanterare som 1Password, Bitwarden, iCloud-nyckelring eller Google Lösenordshanteraren.",
    "PASSKEY_BACK_TO_LOGIN"               => "Tillbaka till inloggning",
));

//validation class
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"JOIN_SUC"			=> "Välkommen till ",
	"JOIN_THANKS"		=> "Tack för registreringen!",
	"JOIN_HAVE"			=> "Ha åtminstone ",
	"JOIN_LOWER"	=> " gemener",
	"JOIN_SYMBOL"		=> " symboler",
	"JOIN_CAP"			=> " versaler",
	"JOIN_TWICE"		=> "Inmatas korrekt två gånger",
	"JOIN_CLOSED"		=> "Tyvärr är registreringen avvaktiverad för närvarande. Var vänlig kontakta administratören om du har frågor eller ärenden.",
	"JOIN_TC"				=> "Registrering allmänna villkor",
	"JOIN_ACCEPTTC" => "Jag accepterar de allmänna villkoren",
	"JOIN_CHANGED"	=> "Våra allmänna villkor har uppdaterats",
	"JOIN_ACCEPT" 	=> "Acceptera allmänna villkor och fortsätt",
	"JOIN_SCORE" => "Poäng:",
	"JOIN_INVALID_PW" => "Ditt lösenord är ogiltigt",

));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "Lyckades avsluta ",
));

//Messages
$lang = array_merge($lang, array(
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

//Two Factor Authentication
$lang = array_merge($lang, array(
    "2FA"                                => "Tvåfaktorsautentisering",
    "2FA_CONF"                           => "Är du säker på att du vill inaktivera tvåfaktorsautentisering? Ditt konto kommer inte längre att vara skyddat.",
    "2FA_SCAN"                           => "Skanna denna QR-kod med din autentiseringsapp eller ange nyckeln",
    "2FA_THEN"                           => "Ange sedan en av dina engångskoder här",
    "2FA_FAIL"                           => "Ett problem uppstod vid verifiering av tvåfaktorsautentisering. Kontrollera internetanslutningen eller kontakta support.",
    "2FA_CODE"                           => "2FA-kod",
    "2FA_EXP"                            => "1 fingeravtryck har gått ut",
    "2FA_EXPD"                           => "Utgånget",
    "2FA_EXPS"                           => "Går ut",
    "2FA_ACTIVE"                         => "Aktiva sessioner",
    "2FA_NOT_FN"                         => "Inga fingeravtryck hittades",
    "2FA_FP"                             => "Fingeravtryck",
    "2FA_NP"                             => "Inloggning misslyckades - Tvåfaktorsautentiseringskod saknades. Vänligen försök igen.",
    "2FA_INV"                            => "Inloggning misslyckades - Tvåfaktorsautentiseringskoden var ogiltig. Vänligen försök igen.",
    "2FA_FATAL"                          => "Allvarligt fel - Vänligen kontakta systemadministratören. Vi kan inte generera en tvåfaktorsautentiseringskod för närvarande.",
    "2FA_SECTION_TITLE"                  => "Tvåfaktorsautentisering (TOTP)",
    "2FA_SK_ALT"                         => "Om du inte kan skanna QR-koden, ange den här hemliga nyckeln manuellt i din autentiseringsapp.",
    "2FA_IS_ENABLED"                     => "Tvåfaktorsautentisering skyddar ditt konto.",
    "2FA_NOT_ENABLED_INFO"               => "Tvåfaktorsautentisering är för närvarande inte aktiverat.",
    "2FA_NOT_ENABLED_EXPLAIN"            => "Tvåfaktorsautentisering (TOTP) lägger till ett extra säkerhetslager till ditt konto genom att kräva en kod från en autentiseringsapp på din telefon utöver ditt lösenord.",
    // Setup Process
    "2FA_SETUP_TITLE"                    => "Ställ in tvåfaktorsautentisering",
    "2FA_SECRET_KEY_LABEL"               => "Hemlig nyckel:",
    "2FA_SETUP_VERIFY_CODE_LABEL"        => "Ange verifieringskod från appen",
    // Backup Codes
    "2FA_SUCCESS_ENABLED_TITLE"          => "Tvåfaktorsautentisering aktiverad! Spara dina reservkoder",
    "2FA_SUCCESS_ENABLED_INFO"           => "Nedan finns dina reservkoder. Förvara dem säkert - var och en kan bara användas en gång.",
    "2FA_BACKUP_CODES_WARNING"           => "Behandla dessa koder som lösenord. Förvara dem säkert.",
    "2FA_SUCCESS_BACKUP_REGENERATED"     => "Nya reservkoder har genererats. Spara dem säkert.",
    "2FA_BACKUP_CODE_LABEL"              => "Reservkod",
    "2FA_REGEN_CODES_BTN"                => "Generera nya reservkoder",
    "2FA_INVALIDATE_WARNING"             => "Detta kommer att ogiltigförklara alla befintliga reservkoder. Är du säker?",
    // Authentication
    "2FA_CODE_LABEL"                     => "Autentiseringskod",
    "2FA_VERIFY_BTN"                     => "Verifiera och logga in",
    "2FA_VERIFY_TITLE"                   => "Tvåfaktorsautentisering krävs",
    "2FA_VERIFY_INFO"                    => "Ange den 6-siffriga koden från din autentiseringsapp.",
    // Actions & Buttons
    "2FA_ENABLE_BTN"                     => "Aktivera tvåfaktorsautentisering",
    "2FA_DISABLE_BTN"                    => "Inaktivera tvåfaktorsautentisering",
    "2FA_VERIFY_ACTIVATE_BTN"            => "Verifiera och aktivera",
    "2FA_CANCEL_SETUP_BTN"               => "Avbryt inställning",
    "2FA_DONE_BTN"                       => "Klar",
    // Success Messages
    "REDIR_2FA_DIS"                      => "Tvåfaktorsautentisering har inaktiverats.",
    "2FA_SUCCESS_BACKUP_ACK"             => "Reservkoderna har bekräftats.",
    "2FA_SUCCESS_SETUP_CANCELLED"        => "Inställningen har avbrutits.",
    // Error Messages
    "2FA_ERR_INVALID_BACKUP"             => "Ogiltig reservkod. Vänligen försök igen.",
    "2FA_ERR_DISABLE_FAILED"             => "Det gick inte att inaktivera tvåfaktorsautentisering.",
    "2FA_ERR_NO_SECRET"                  => "Kunde inte hämta autentiseringshemligheten. Vänligen försök igen.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"     => "Reservkoden verifierades men det gick inte att ogiltigförklara den. Vänligen kontakta support.",
    "2FA_ERR_NO_CODE_PROVIDED"           => "Ingen autentiseringskod angavs.",
    "RATE_LIMIT_LOGIN"                   => "För många misslyckade inloggningsförsök. Vänligen vänta innan du försöker igen.",
    "RATE_LIMIT_TOTP"                    => "För många felaktiga autentiseringskoder. Vänligen vänta innan du försöker igen.",
    "RATE_LIMIT_PASSKEY"                 => "För många autentiseringsförsök med lösennyckel. Vänligen vänta innan du försöker igen.",
    "RATE_LIMIT_PASSKEY_STORE"           => "För många registreringsförsök av lösennyckel. Vänligen vänta innan du försöker igen.",
    "RATE_LIMIT_PASSWORD_RESET"          => "För många begäranden om återställning av lösenord. Vänligen vänta innan du begär en ny återställning.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT"   => "För många försök att återställa lösenord. Vänligen vänta innan du försöker igen.",
    "RATE_LIMIT_REGISTRATION"            => "För många registreringsförsök. Vänligen vänta innan du försöker igen.",
    "RATE_LIMIT_EMAIL_VERIFICATION"      => "För många begäranden om e-postverifiering. Vänligen vänta innan du begär en ny verifiering.",
    "RATE_LIMIT_EMAIL_CHANGE"            => "För många begäranden om e-poständring. Vänligen vänta innan du försöker igen.",
    "RATE_LIMIT_PASSWORD_CHANGE"         => "För många försök att ändra lösenord. Vänligen vänta innan du försöker igen.",
    "RATE_LIMIT_GENERIC"                 => "För många försök. Vänligen vänta innan du försöker igen.",
));

$lang = array_merge($lang, array(
	"REDIR_2FA"						=> "Tyvärr.Tvåfaktor är inte aktiverat för närvarande",
	"REDIR_2FA_EN"				=> "2-faktorsautentisering aktiverad",
	"REDIR_2FA_DIS"				=> "2-faktorsautentisering inaktiverad",
	"REDIR_2FA_VER"				=> "2-faktorsautentisering verifierad och aktiverad",
	"REDIR_SOMETHING_WRONG" => "Något gick fel. Vänligen försök igen.",
	"REDIR_MSG_NOEX"			=> "Den tråden tillhör inte dig eller finns inte.",
	"REDIR_UN_ONCE"				=> "Användarnamn har redan ändrats en gång.",
	"REDIR_EM_SUCC"				=> "Uppdatering av E-post lyckades.",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "Logga in med:",
	"EML_FEATURE_DISABLED" => "Denna funktion är inaktiverad",
	"EML_PASSWORDLESS_SENT" => "Vänligen kontrollera din e-post för en login-länk.",
	"EML_PASSWORDLESS_SUBJECT" => "Var vänlig verifiera din e-post för att logga in.",
	"EML_PASSWORDLESS_BODY" => "Var vänlig verifiera din e-postadress genom att klicka på länken nedan. Du kommer att bli automatiskt inloggad.",

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
$lang = array_merge($lang, array(
	"VER_SUC"			=> "Din e-postadress har verifierats!",
	"VER_FAIL"		=> "Vi kunde inte verifiera ditt konto. Var god försök igen.",
	"VER_RESEND"	=> "Skicka verifikationsmail igen",
	"VER_AGAIN"		=> "Skriv in din e-postadress och försök igen",
	"VER_PAGE"		=> "<li>Kontrollera din e-post och klicka på länken som skickas till dig</li><li>Klart</li>",
	"VER_RES_SUC" => " En verifieringslänk har skickats till din e-postadress.  Klicka på länken i e-postmeddelandet för att slutföra verifieringen. Kontrollera din skräppostmapp om e-postmeddelandet inte finns i din inkorg.  Verifieringslänkar är endast giltiga ",
	"VER_OOPS"		=> "Ojoj...något gick fel, kan vara en gammal återställningslänk du klickade på. Klicka nedan och försök igen.",
	"VER_RESET"		=> "Ditt löenord har återställts!",
	"VER_INS"			=> "<li>Ange din e-postadress och klicka på Återställ</li> <li>Kontrollera din e-post och klicka på länken som skickas till dig.</li>
												<li>Följ instruktionerna på skärmen</li>",
	"VER_SENT"		=> " Länken för återställning av lösenord har skickats till din e-postadress. 
			    							 Klicka på länken i e-postmeddelandet för att återställa ditt lösenord. Kontrollera din skräppostmapp om e-postmeddelandet inte finns i din inkorg.  Återställningslänkar gäller endast ",
	"VER_PLEASE"	=> "Vänligen återställ ditt lösenord",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"				=> "Återställ PIN",
	"SET_WHY"				=> "Varför kan jag inte ändra det här?",
	"SET_PW_MATCH"	=> "Måste matcha det nya lösenordet",

	"SET_PIN_NEXT"	=> "Du kan ställa in en ny PIN-kod nästa gång du behöver verifiering",
	"SET_UPDATE"		=> "Uppdatera dina användarinställningar",
	"SET_NOCHANGE"	=> "Administratören har avaktiverat möjligheten att byta användarnamn.",
	"SET_ONECHANGE"	=> "Administratören ställde in användarnamnändringar att inträffa endast en gång och du har redan gjort det.",

	"SET_GRAVITAR"	=> "Vill du ändra din profilbild?  <br> Besök <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> och konfigurera ett konto med samma e-postmeddelande som du använde på den här webbplatsen. Det fungerar på miljontals webbplatser. Det är snabbt och enkelt!",

	"SET_NOTE1"			=> " Vänligen observera  det finns en pågående begäran om att uppdatera din e-post till",

	"SET_NOTE2"			=> ".  Vänligen använd verifieringsmeddelandet för att slutföra denna begäran. 
		 Om du behöver ett nytt verifieringsmeddelande, ange e-postmeddelandet igen och skicka in begäran igen. ",

	"SET_PW_REQ" 		=> "behövs för byte av lösenord, e-post, eller återställa PIN",
	"SET_PW_REQI" 	=> "Behövs för att byta lösenord",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "Misslyckades med att avsluta aktiva sessioner, Fel: ",
	"ERR_EMAIL"				=> "E-post skickades EJ pga fel. Kontakta administrator.",
	"ERR_EM_DB"				=> "Den e-postadressen existerar inte i databasen",
	"ERR_TC"					=> "Vänligen läs och acceptera våra allmänna villkor",
	"ERR_CAP"					=> "Du falerade Captcha Test, robot!",
	"ERR_PW_SAME"			=> "Ditt nya lösenord kan inte vara samma som ditt gamla",
	"ERR_PW_FAIL"			=> "Lösenordsverifieringen misslyckades. Uppdateringen misslyckades. Var god försök igen.",
	"ERR_GOOG"				=> "Observera:  Om du ursprungligen registrerade dig med ditt Google / Facebook-konto måste du använda länken Glömt lösenord för att ändra ditt lösenord ... såvida du inte är riktigt bra på att gissa.",
	"ERR_EM_VER"			=> "E-postverifiering är inte aktiverad. Vänligen kontakta systemadministratören.",
	"ERR_EMAIL_STR"		=> "Något är konstigt. Vänligen återverifiera din e-post. Vi beklagar olägenheten",

));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "Vi kommer tillbaka snart!",
	"MAINT_MSG"			=> "Ledsen för besväret men vi utför något underhåll för tillfället.<br> Vi är snart tillbaka online!",
	"MAINT_BAN"			=> "Ledsen men du har blivit avaktiverad. Om du känner att detta är ett fel, vänligen kontakta administratören.",
	"MAINT_TOK"			=> "Det var något fel med formuläret. Gå tillbaka och försök igen. Observera att skicka in formuläret genom att uppdatera sidan kommer att orsaka ett fel. Om detta fortsätter att hända, kontakta administratören.",
	"MAINT_OPEN"		=> "Ett Open Source PHP User Management Framework.",
	"MAINT_PLEASE"	=> "Du har installerat UserSpice!<br>För att se vår dokumentation över hur du kommer igång vänligen besök"
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
