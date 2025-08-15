<?php
/*
Do not put any content above the opening PHP tag
/**
      Afrikaans Translation by John Dovey <boondock@criptext.com> & Big G
      v 2.0: 16 December 2024
      Any suggestions for improvements are appreciated
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
%m1% - Dynamic markers which are replaced at run time by the relevant index.
*/

$lang = array();
//important strings
//You definitely want to customize these for your language
$lang = array_merge($lang, array(
	"THIS_LANGUAGE"	=> "Afrikaans",
	"THIS_CODE"	=> "af-AF",
	"MISSING_TEXT"	=> "Ontbrekende teks",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "Voer die kode in wat na jou e-pos gestuur is",
    "PASS_EMAIL_ONLY"     => "Bevestig asseblief jou e-pos vir 'n skakel om aan te teken.",
    "PASS_CODE_ONLY"      => "Voer asseblief die kode in wat na jou e-pos gestuur is.",
    "PASS_BOTH"           => "Bevestig asseblief jou e-pos vir 'n skakel om aan te teken of voer die kode in wat na jou e-pos gestuur is.",
    "PASS_VER_BUTTON"     => "Verifieer kode",
    "PASS_EMAIL_ONLY_MSG" => "Verifieer asseblief jou e-posadres deur op die onderstaande skakel te klik.",
    "PASS_CODE_ONLY_MSG"  => "Voer asseblief die onderstaande kode in om aan te teken.",
    "PASS_BOTH_MSG"       => "Verifieer asseblief jou e-posadres deur op die onderstaande skakel te klik of voer die onderstaande kode in om aan te teken.",
    "PASS_YOUR_CODE"      => "Jou verifiëringskode is: ",
    "PASS_CONFIRM_LOGIN"  => "Bevestig Aanmelding",
    "PASS_CONFIRM_CLICK"  => "Klik om aan tekening te Voltooi",
    "PASS_GENERIC_ERROR"  => "Iets het verkeerd gegaan.",
));

//Database Menus
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"		=> "Registreer",
	"SIGNUP_BUTTONTEXT"	=> "Registreer my",
	"SIGNUP_AUDITTEXT"	=> "Geregistreer",
));

// Signin
$lang = array_merge($lang, array(
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
	"SIGNIN_FORGOTPASS"	=> "Wagwoord vergeet",
	"SIGNOUT_AUDITTEXT"	=> "Uitgeteken",
));

// Account Page
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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

//added during passkey/totp update
$lang = array_merge($lang, array(
    "GEN_PASSKEY"                         => "Toegangsleutel",
    "GEN_ACTIONS"                         => "Aksies",
    "GEN_BACK_TO_ACCT"                    => "Terug na Rekening",
    "GEN_DB_ERROR"                        => "'n Databasisfout het voorgekom. Probeer asseblief weer.",
    "GEN_IMPORTANT"                       => "Belangrik",
    "GEN_NO_PERMISSIONS"                  => "Jy het nie toestemming om hierdie bladsy te sien nie.",
    "GEN_NO_PERMISSIONS_MSG"              => "Jy het nie toestemming om hierdie bladsy te sien nie. As jy voel dit is 'n fout, kontak asseblief die webwerf-administrateur.",
    "PASSKEYS_MANAGE_TITLE"               => "Bestuur Jou Toegangsleutels",
    "PASSKEYS_LOGIN_TITLE"                => "Teken in met Toegangsleutel",
    "PASSKEY_DELETE_SUCCESS"              => "Toegangsleutel suksesvol uitgevee.",
    "PASSKEY_DELETE_FAIL_DB"              => "Kon nie toegangsleutel uit databasis verwyder nie.",
    "PASSKEY_DELETE_NOT_FOUND"            => "Toegangsleutel nie gevind of toestemming geweier.",
    "PASSKEY_NOTE_UPDATE_SUCCESS"         => "Toegangsleutel-nota suksesvol opgedateer.",
    "PASSKEY_NOTE_UPDATE_FAIL"            => "Kon nie toegangsleutel-nota opdateer nie.",
    "PASSKEY_REGISTER_NEW"                => "Registreer Nuwe Toegangsleutel",
    "PASSKEY_ERR_LIMIT_REACHED"           => "Jy het die maksimum van 10 toegangsleutels bereik.",
    "PASSKEY_NOTE_TH"                     => "Toegangsleutel Nota",
    "PASSKEY_TIMES_USED_TH"               => "Kere Gebruik",
    "PASSKEY_LAST_USED_TH"                => "Laas Gebruik",
    "PASSKEY_LAST_IP_TH"                  => "Laaste IP",
    "PASSKEY_EDIT_NOTE_BTN"               => "Wysig Nota",
    "PASSKEY_CONFIRM_DELETE_JS"           => "Is jy seker jy wil hierdie toegangsleutel uitvee?",
    "PASSKEY_EDIT_MODAL_TITLE"            => "Wysig Toegangsleutel Nota",
    "PASSKEY_EDIT_MODAL_LABEL"            => "Toegangsleutel Nota",
    "PASSKEY_SAVE_CHANGES_BTN"            => "Stoor Veranderinge",
    "PASSKEY_NONE_REGISTERED"             => "Jy het nog geen toegangsleutels geregistreer nie.",
    "PASSKEY_MUST_REGISTER_FIRST"         => "Jy moet eers 'n toegangsleutel vanaf 'n geauthentiseerde rekening registreer voordat jy hierdie funksie kan gebruik.",
    "PASSKEY_STORING"                     => "Stoor tans toegangsleutel...",
    "PASSKEY_STORED_SUCCESS"              => "Toegangsleutel suksesvol gestoor!",
    "PASSKEY_INVALID_ACTION"              => "Ongeldige aksie: ",
    "PASSKEY_NO_ACTION_SPECIFIED"         => "Geen aksie gespesifiseer nie",
    "PASSKEY_ERR_NETWORK_SUGGESTION"      => "Netwerkprobleem bespeur. Probeer 'n ander netwerk of verfris die bladsy.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "Kruis-toestel stawing bespeur. Maak seker beide toestelle het internettoegang.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "Probeer eerder hierdie bladsy direk op jou foon oopmaak.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"       => "Kon nie diagnostiek genereer nie: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"     => "Vereiste geloofsbriefdata vir stoor ontbreek.",
    "PASSKEY_MISSING_AUTH_DATA"           => "Vereiste stawingdata ontbreek.",
    "PASSKEY_LOG_NO_MESSAGE"              => "Geen boodskap",
    "PASSKEY_USER_NOT_FOUND"              => "Gebruiker nie gevind na toegangsleutel-validering nie.",
    "PASSKEY_FATAL_ERROR"                 => "Fatale fout: ",
    "PASSKEY_LOGIN_SUCCESS"               => "Suksesvol ingeteken.",
    // JavaScript status messages (passkeys.php)
    "PASSKEY_CROSS_DEVICE_PREP"           => "Berei voor vir kruis-toestel registrasie. Jy mag dalk jou foon of tablet moet gebruik.",
    "PASSKEY_DEVICE_REGISTRATION"         => "Gebruik toestel se toegangsleutel-registrasie...",
    "PASSKEY_STARTING_REGISTRATION"       => "Begin toegangsleutel-registrasie...",
    "PASSKEY_REQUEST_OPTIONS"             => "Versoek registrasie-opsies van bediener...",
    "PASSKEY_FOLLOW_PROMPTS"              => "Volg die aanwysings om jou toegangsleutel te skep. Jy mag dalk 'n ander toestel moet gebruik.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"       => "Volg die aanwysings om jou toegangsleutel te skep...",
    "PASSKEY_CREATION_FAILED"             => "Toegangsleutel-skepping het misluk - geen geloofsbrief terug ontvang nie.",
    "PASSKEY_STORING_SERVER"              => "Stoor tans jou toegangsleutel...",
    "PASSKEY_CREATED_SUCCESS"             => "Toegangsleutel suksesvol geskep!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP"      => "Berei voor vir kruis-toestel stawing. Maak seker jou foon en rekenaar het internettoegang.",
    "PASSKEY_DEVICE_AUTH"                 => "Gebruik toestel se toegangsleutel-stawing...",
    "PASSKEY_STARTING_AUTH"               => "Begin toegangsleutel-stawing...",
    "PASSKEY_QR_CODE_INSTRUCTION"         => "Skandeer die QR-kode met jou foon wanneer dit verskyn. Maak seker beide toestelle het internettoegang.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"    => "Kies \"Gebruik 'n foon of tablet\" wanneer gevra, en skandeer dan die QR-kode.",
    "PASSKEY_AUTHENTICATING"              => "Besig om met jou toegangsleutel te staaf...",
    "PASSKEY_SUCCESS_REDIRECTING"         => "Stawing suksesvol! Stuur aan...",
    // Timeout messages
    "PASSKEY_TIMEOUT_CROSS_DEVICE"        => "Registrasie het uitgetel. Vir kruis-toestel: 1) Probeer weer, 2) Verseker toestelle het internet, 3) Oorweeg om direk op jou foon te registreer.",
    "PASSKEY_TIMEOUT_SIMPLE"              => "Registrasie het uitgetel. Probeer asseblief weer.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"   => "Kruis-toestel stawing het uitgetel. Foutsporing: 1) Beide toestelle benodig internet, 2) Probeer die QR-kode vinniger skandeer, 3) Oorweeg om dieselfde toestel te gebruik, 4) Sommige netwerke blokkeer kruis-toestel stawing.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"         => "Stawing het uitgetel. Probeer asseblief weer.",
    "PASSKEY_NO_CREDENTIAL"               => "Geen geloofsbrief ontvang nie. Probeer weer...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"   => "Stawing het misluk - geen geloofsbrief terug ontvang nie.",
    "PASSKEY_ATTEMPT_RETRY"               => "het misluk. Probeer weer... (%d pogings oorblywend)",
    // Error messages
    "PASSKEY_CROSS_DEVICE_FAILED"         => "Kruis-toestel registrasie het misluk. Probeer: 1) Verseker beide toestelle het internet, 2) Oorweeg om direk op jou foon te registreer, 3) Sommige korporatiewe netwerke blokkeer hierdie funksie.",
    "PASSKEY_REGISTRATION_CANCELLED"      => "Registrasie is gekanselleer of die toestel ondersteun nie toegangsleutels nie.",
    "PASSKEY_NOT_SUPPORTED"               => "Toegangsleutels word nie op hierdie toestel/blaaier-kombinasie ondersteun nie.",
    "PASSKEY_SECURITY_ERROR"              => "Sekuriteitsfout - dit dui gewoonlik op 'n domein/oorsprong-wanverhouding.",
    "PASSKEY_ALREADY_EXISTS"              => "'n Toegangsleutel bestaan reeds vir hierdie rekening op hierdie toestel. Probeer 'n ander toestel gebruik of vee eers bestaande toegangsleutels uit.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"    => "Kruis-toestel stawing het misluk. Probeer: 1) Verseker beide toestelle het stabiele internet, 2) Gebruik dieselfde WiFi-netwerk indien moontlik, 3) Probeer eerder direk op jou foon staaf, 4) Sommige korporatiewe netwerke blokkeer hierdie funksie.",
    "PASSKEY_AUTH_CANCELLED"              => "Stawing is gekanselleer of geen toegangsleutel is gekies nie.",
    "PASSKEY_NETWORK_ERROR"               => "Netwerkfout. Vir kruis-toestel stawing benodig beide toestelle internettoegang en moet moontlik op dieselfde netwerk wees.",
    "PASSKEY_CREDENTIAL_NOT_FOUND"        => "Stawing het misluk - geloofsbrief nie herken nie.",
    // Cross-device guidance
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "Wenke vir Kruis-Toestel Stawing:",
    "PASSKEY_GUIDANCE_INTERNET"           => "Maak seker beide jou rekenaar en foon het internettoegang",
    "PASSKEY_GUIDANCE_WIFI"               => "Om op dieselfde WiFi-netwerk te wees kan help (maar is nie altyd nodig nie)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"      => "Wanneer gevra, kies \"Gebruik 'n foon of tablet\"",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"       => "Skandeer die QR-kode vinnig wanneer dit verskyn",
    "PASSKEY_GUIDANCE_TRY_DIRECT"         => "As dit misluk, probeer verfris en gebruik jou foon se blaaier direk",
    // Troubleshooting
    "PASSKEY_SHOW_TROUBLESHOOTING"        => "Wys Foutsporingswenke",
    "PASSKEY_HIDE_TROUBLESHOOTING"        => "Versteek Foutsporingswenke",
    "PASSKEY_DIAGNOSTICS_RUNNING"         => "Voer tans diagnostiek uit...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"        => "Diagnostiek voltooi. Gaan konsole na vir besonderhede.",
    "PASSKEY_ISSUES_DETECTED"             => "Probleme bespeur:",
    "PASSKEY_ENVIRONMENT_SUITABLE"        => "Omgewing blyk geskik te wees vir toegangsleutels.",
    "PASSKEY_DIAGNOSTICS_FAILED"          => "Diagnostiek het misluk:",
    // Modal
    "PASSKEY_ADD_NOTE_NEW"                => "Voeg 'n Nota by Jou Nuwe Toegangsleutel",
    // Technical errors
    "PASSKEY_BASE64_ERROR"                => "Base64-dekoderingsfout:",
    // Server-side errors (passkey_parser.php)
    "PASSKEY_INVALID_JSON"                => "Ongeldige JSON-data ontvang:",
    // Session/validation errors (PasskeyHandler.php)
    "PASSKEY_NO_CHALLENGE_SESSION"        => "Geen toegangsleutel-registrasie-uitdaging in sessie gevind nie. Probeer asseblief weer registreer.",
    "PASSKEY_USER_MISMATCH"               => "Gebruiker-ID stem nie ooreen nie. Probeer asseblief weer registreer.",
    "PASSKEY_CHALLENGE_USER_MISMATCH"     => "Gebruiker-ID in uitdaging-opsies stem nie ooreen met huidige gebruiker nie. Probeer asseblief weer registreer.",
    "PASSKEY_REGISTRATION_FAILED_ERROR"   => "Toegangsleutel-registrasie het misluk. Maak seker jou toestel en blaaier ondersteun WebAuthn en probeer weer. Fout:",
    "PASSKEY_NO_AUTH_CHALLENGE_SESSION"   => "Geen toegangsleutel-stawing-uitdaging in sessie gevind nie. Probeer asseblief weer inteken.",
    "PASSKEY_CREDENTIAL_NOT_IN_DB"        => "Toegangsleutel-geloofsbrief nie in die databasis gevind nie.",
    "PASSKEY_CREDENTIAL_WRONG_USER"       => "Toegangsleutel-geloofsbrief behoort nie aan die verwagte gebruiker nie.",
    "PASSKEY_VALIDATION_FAILED_ERROR"     => "Toegangsleutel-validering het misluk. Probeer asseblief weer of kontak ondersteuning as die probleem voortduur. Fout:",
    "PASSKEY_USER_NOT_FOUND_REGISTRATION" => "Gebruiker nie gevind vir registrasie nie.",
    // --- Used in passkey_parser.php ---
    "PASSKEY_LOGIN_REQUIRED"              => "Jy moet ingeteken wees om hierdie aksie uit te voer.",
    "PASSKEY_ACTION_MISSING"              => "Die vereiste 'action'-parameter het in die versoek ontbreek.",
    "PASSKEY_STORAGE_FAILED"              => "Kon nie die toegangsleutel stoor nie. Die operasie was onsuksesvol.",
    "PASSKEY_LOGIN_FAILED"                => "Toegangsleutel-intekening het misluk. Die stawing kon nie geverifieer word nie.",
    "PASSKEY_INVALID_METHOD"              => "Ongeldige versoekmetode:", // The script appends the method name after this key
    // --- Used in passkeys.php ---
    "CSRF_ERROR"                          => "CSRF-token-kontrole het misluk. Gaan asseblief terug en probeer die vorm weer indien.",
    // Network analysis from analyzeNetworkConditions()
    "PASSKEY_NETWORK_PRIVATE"             => "Moontlike Probleem: Jy blyk op 'n private netwerk te wees, wat soms met kruis-toestel kommunikasie kan inmeng.",
    "PASSKEY_NETWORK_PROXY"               => "Moontlike Probleem: 'n Proxy of VPN is bespeur. Dit mag inmeng met kruis-toestel kommunikasie.",
    "PASSKEY_NETWORK_MOBILE"              => "Let Wel: Jy blyk op 'n mobiele netwerk te wees. Verseker 'n stabiele verbinding vir kruis-toestel operasies.",
    "PASSKEY_NETWORK_CORPORATE"           => "Moontlike Probleem: 'n Korporatiewe brandmuur mag aktief wees, wat kruis-toestel stawing kan beïnvloed.",
    // Recommendations from getCrossDeviceRecommendations()
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "Aanbeveling: Jy gebruik waarskynlik 'n rekenaar. Berei voor om jou foon te gebruik om 'n QR-kode te skandeer.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "Aanbeveling: Vir die beste resultate, maak seker jou rekenaar en mobiele toestel is op dieselfde Wi-Fi-netwerk.",
    "PASSKEY_RECOMMENDATION_QR_QUICK"     => "Aanbeveling: Wees voorbereid om die QR-kode vinnig te skandeer, aangesien die versoek kan uittel.",
    "PASSKEY_RECOMMENDATION_INTERNET"     => "Aanbeveling: Maak seker beide jou rekenaar en jou mobiele toestel het 'n stabiele internetverbinding.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "Aanbeveling: Vir Unity WebViews, maak seker die bladsy het genoeg tyd om te laai en die toegangsleutel-versoek te verwerk.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "Aanbeveling: Tydsverlope mag langer wees in Unity. Wees asseblief geduldig.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "Aanbeveling: Aangesien jy op 'n mobiele toestel is, behoort jy 'n toegangsleutel direk op hierdie toestel te kan registreer.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Aanbeveling: Op Android kan jy jou toegangsleutels in die Google Wagwoordbestuurder bestuur.",
    // Validation from validateCrossDeviceEnvironment()
    "PASSKEY_VALIDATION_RP_IP"            => "Konfigurasie Waarskuwing: Die Relying Party ID is gestel as 'n IP-adres.",
    "PASSKEY_VALIDATION_RP_DOMAIN"        => "Aanbeveling: Stel die Relying Party ID na jou domeinnaam (bv. jouwebwerf.com) vir beter sekuriteit en versoenbaarheid.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"   => "Konfigurasie Fout: HTTPS is nodig vir toegangsleutels om op 'n lewendige bediener te werk. Jou werf blyk op HTTP te wees.",
    "PASSKEY_VALIDATION_NETWORK"          => "Netwerk Waarskuwing", // Generic prefix for network issues
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "Aanbeveling: As jy probleme ondervind, probeer 'n ander netwerk (bv. skakel oor van korporatiewe Wi-Fi na 'n mobiele hotspot).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "Aanbeveling: Vir kruis-toestel aksies, maak seker beide toestelle het 'n betroubare internetverbinding.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"  => "Aanbeveling: As kruis-toestel aksies misluk, probeer hierdie bladsy direk op jou mobiele toestel besoek om die aksie te voltooi.",
    "PASSKEY_INFO_TITLE"                  => "Oor Toegangsleutels",
    "PASSKEY_INFO_DESC"                   => "Toegangsleutels is 'n veilige, wagwoordvrye manier om aan te meld deur jou toestel se ingeboude sekuriteitskenmerke soos vingerafdruk, gesigsherkenning of PIN te gebruik. Hulle is veiliger as wagwoorde, bied vinniger aanmelding, werk oor verskeie toestelle wanneer dit met wagwoordbestuurders gesinkroniseer word, en is bestand teen uitvissing-aanvalle. Toegangsleutels werk op moderne slimfone, tablette, rekenaars, en kan in wagwoordbestuurders soos 1Password, Bitwarden, iCloud Sleutelhanger, of Google Wagwoordbestuurder gestoor word.",
    "PASSKEY_BACK_TO_LOGIN"               => "Terug na Intekening",
));

//validation class
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"JOIN_SUC"		=> "Welkom by ",
	"JOIN_THANKS"		=> "Dankie dat u geregistreer het!",
	"JOIN_HAVE"		=> "Het ten minste ",
	"JOIN_LOWER"		=> " kleinletter",
	"JOIN_SYMBOL"		=> " simbool",
	"JOIN_CAP"		=> " hoofletter",
	"JOIN_TWICE"		=> "Word twee keer korrek getik",
	"JOIN_CLOSED"		=> "Registrasie is op hierdie stadium ongelukkig uitgeskakel. Kontak asseblief die webwerfadministrateur as u enige vrae of probleme het.",
	"JOIN_TC"		=> "Registrasiegebruikersvoorwaardes",
	"JOIN_ACCEPTTC" 	=> "Ek aanvaar gebruikersbepalings en -voorwaardes",
	"JOIN_CHANGED"		=> "Ons bepalings het verander",
	"JOIN_ACCEPT" 		=> "Aanvaar gebruikersbepalings en gaan voort",
	"JOIN_SCORE" => "Punte:",
	"JOIN_INVALID_PW" => "Jou wagwoord is ongeldig",
));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"		=> "Suksesvol uitgewis ", // Suksesvol doodgemaak
));

//Messages
$lang = array_merge($lang, array(
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
//Two Factor Authentication
$lang = array_merge($lang, array(
    "2FA"                                => "Twee-Faktor-Verifikasie",
    "2FA_CONF"                           => "Is jy seker jy wil 2FA deaktiveer? Jou rekening sal nie meer beskerm wees nie.",
    "2FA_SCAN"                           => "Skandeer hierdie QR-kode met jou verifikasie-toepassing of voer die sleutel in",
    "2FA_THEN"                           => "Voer dan een van jou eenmalige wagkodes hier in",
    "2FA_FAIL"                           => "Daar was 'n probleem met die verifiëring van 2FA. Gaan asseblief jou internet na of kontak ondersteuning.",
    "2FA_CODE"                           => "2FA-kode",
    "2FA_EXP"                            => "1 vingerafdruk het verval",
    "2FA_EXPD"                           => "Verval",
    "2FA_EXPS"                           => "Verval op",
    "2FA_ACTIVE"                         => "Aktiewe Sessies",
    "2FA_NOT_FN"                         => "Geen vingerafdrukke gevind nie",
    "2FA_FP"                             => "Vingerafdrukke",
    "2FA_NP"                             => "Intekening Misluk - Twee-faktor-stawingskode was nie teenwoordig nie. Probeer asseblief weer.",
    "2FA_INV"                            => "Intekening Misluk - Twee-faktor-stawingskode was ongeldig. Probeer asseblief weer.",
    "2FA_FATAL"                          => "Fatale Fout - Kontak asseblief die Stelseladministrateur. Ons kan nie op die oomblik 'n Twee-faktor-stawingskode genereer nie.",
    "2FA_SECTION_TITLE"                  => "Twee-Faktor-Verifikasie (TOTP)",
    "2FA_SK_ALT"                         => "As jy nie die QR-kode kan skandeer nie, voer hierdie geheime sleutel handmatig in jou verifikasie-toepassing in.",
    "2FA_IS_ENABLED"                     => "Twee-faktor-verifikasie beskerm jou rekening.",
    "2FA_NOT_ENABLED_INFO"               => "Twee-faktor-verifikasie is tans nie geaktiveer nie.",
    "2FA_NOT_ENABLED_EXPLAIN"            => "Twee-faktor-verifikasie (TOTP) voeg 'n ekstra laag sekuriteit by jou rekening deur 'n kode van 'n verifikasie-toepassing op jou foon te vereis, bykomend tot jou wagwoord.",
    // Setup Process
    "2FA_SETUP_TITLE"                    => "Stel Twee-Faktor-Verifikasie op",
    "2FA_SECRET_KEY_LABEL"               => "Geheime Sleutel:",
    "2FA_SETUP_VERIFY_CODE_LABEL"        => "Voer Verifikasiekode vanaf Toepassing in",
    // Backup Codes
    "2FA_SUCCESS_ENABLED_TITLE"          => "Twee-Faktor-Verifikasie Geaktiveer! Stoor Jou Rugsteunkodes",
    "2FA_SUCCESS_ENABLED_INFO"           => "Hieronder is jou rugsteunkodes. Bêre hulle veilig - elkeen kan slegs een keer gebruik word.",
    "2FA_BACKUP_CODES_WARNING"           => "Hanteer hierdie kodes soos wagwoorde. Bêre hulle veilig.",
    "2FA_SUCCESS_BACKUP_REGENERATED"     => "Nuwe rugsteunkodes gegenereer. Bêre hulle veilig.",
    "2FA_BACKUP_CODE_LABEL"              => "Rugsteunkode",
    "2FA_REGEN_CODES_BTN"                => "Hergenereer Rugsteunkodes",
    "2FA_INVALIDATE_WARNING"             => "Dit sal alle bestaande rugsteunkodes ongeldig maak. Is jy seker?",
    // Authentication
    "2FA_CODE_LABEL"                     => "Stawingskode",
    "2FA_VERIFY_BTN"                     => "Verifieer & Teken In",
    "2FA_VERIFY_TITLE"                   => "Twee-Faktor-Verifikasie Vereis",
    "2FA_VERIFY_INFO"                    => "Voer die 6-syfer kode van jou verifikasie-toepassing in.",
    // Actions & Buttons
    "2FA_ENABLE_BTN"                     => "Aktiveer Twee-Faktor-Verifikasie",
    "2FA_DISABLE_BTN"                    => "Deaktiveer Twee-Faktor-Verifikasie",
    "2FA_VERIFY_ACTIVATE_BTN"            => "Verifieer & Aktiveer",
    "2FA_CANCEL_SETUP_BTN"               => "Kanselleer Opstelling",
    "2FA_DONE_BTN"                       => "Klaar",
    // Success Messages
    "REDIR_2FA_DIS"                      => "Twee-faktor-verifikasie is gedeaktiveer.",
    "2FA_SUCCESS_BACKUP_ACK"             => "Rugsteunkodes erken.",
    "2FA_SUCCESS_SETUP_CANCELLED"        => "Opstelling gekanselleer.",
    // Error Messages
    "2FA_ERR_INVALID_BACKUP"             => "Ongeldige rugsteunkode. Probeer asseblief weer.",
    "2FA_ERR_DISABLE_FAILED"             => "Kon nie twee-faktor-verifikasie deaktiveer nie.",
    "2FA_ERR_NO_SECRET"                  => "Kon nie stawinggeheim herwin nie. Probeer asseblief weer.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"     => "Rugsteunkode geverifieer, maar kon dit nie ongeldig maak nie. Kontak asseblief ondersteuning.",
    "2FA_ERR_NO_CODE_PROVIDED"           => "Geen stawingskode verskaf nie.",
    "RATE_LIMIT_LOGIN"                   => "Te veel mislukte intekenpogings. Wag asseblief voor jy weer probeer.",
    "RATE_LIMIT_TOTP"                    => "Te veel verkeerde stawingskodes. Wag asseblief voor jy weer probeer.",
    "RATE_LIMIT_PASSKEY"                 => "Te veel pogings tot toegangsleutel-stawing. Wag asseblief voor jy weer probeer.",
    "RATE_LIMIT_PASSKEY_STORE"           => "Te veel pogings tot toegangsleutel-registrasie. Wag asseblief voor jy weer probeer.",
    "RATE_LIMIT_PASSWORD_RESET"          => "Te veel wagwoord-terugstelversoeke. Wag asseblief voor jy nog een aanvra.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT"   => "Te veel wagwoord-terugstelpogings. Wag asseblief voor jy weer probeer.",
    "RATE_LIMIT_REGISTRATION"            => "Te veel registrasiepogings. Wag asseblief voor jy weer probeer.",
    "RATE_LIMIT_EMAIL_VERIFICATION"      => "Te veel e-pos-verifikasieversoeke. Wag asseblief voor jy nog een aanvra.",
    "RATE_LIMIT_EMAIL_CHANGE"            => "Te veel e-pos-veranderingsversoeke. Wag asseblief voor jy weer probeer.",
    "RATE_LIMIT_PASSWORD_CHANGE"         => "Te veel wagwoord-veranderingspogings. Wag asseblief voor jy weer probeer.",
    "RATE_LIMIT_GENERIC"                 => "Te veel pogings. Wag asseblief voor jy weer probeer.",
));


// It seems pointless to me to translate these. Feel free to contribute, Voel Vry!
$lang = array_merge($lang, array(
	"REDIR_2FA"             => "Jammer. Twee factor is nou nie geaktiveer nie.",
	"REDIR_2FA_EN"          => "2 Factor Verifikasie Geaktiveer",
	"REDIR_2FA_DIS"         => "2 Factor Verifikasie Gedeaktiveer",
	"REDIR_2FA_VER"         => "2 Factor Verifikasie Geverifieer en Geaktiveer",
	"REDIR_SOMETHING_WRONG"   => "Iets het verkeerd geloop. Probeer asseblief weer.",
	"REDIR_MSG_NOEX"        => "Daardie draad behoort niet aan jou nie of bestaan nie.",
	"REDIR_UN_ONCE"         => "Gebruikersnaam is reeds een keer verander.",
	"REDIR_EM_SUCC"         => "E-pos Suksesvol Opgedateer",

));

//Emails
$lang = array_merge($lang, array(

	"EML_SIGN_IN_WITH" => "Teken aan met:",
	"EML_FEATURE_DISABLED" => "Hierdie funksie is uitgeskakel",
	"EML_PASSWORDLESS_SENT" => "Kyk asseblief na jou e-pos vir 'n skakel om in te teken.",
	"EML_PASSWORDLESS_SUBJECT" => "Verifieer asseblief jou e-pos om in te teken.",
	"EML_PASSWORDLESS_BODY" => "Verifieer asseblief jou e-posadres deur op die skakel hieronder te klik. Jy sal outomaties ingeteken word.",

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
$lang = array_merge($lang, array(
	"VER_SUC"		=> "U e-posadres is geverifieer!",
	"VER_FAIL"		=> "Ons kon nie u rekening verifieer nie. Probeer asseblief weer.",
	"VER_RESEND"		=> "Stuur verifikasie-e-pos weer",
	"VER_AGAIN"		=> "Voer u e-posadres in en probeer weer",
	"VER_PAGE"		=> "<li> Gaan u e-pos na en klik op die skakel wat aan u gestuur word </li> <li> Klaar </li>",
	"VER_RES_SUC" 		=> "  U verifikasieskakel is na u e-posadres gestuur.     Klik op die skakel in die e-posadres om die verifikasie te voltooi. Kontroleer u strooiposmap as die e-pos nie in u posbus.     Verifikasie skakels is slegs geldig vir ",
	"VER_OOPS"		=> "Oeps ... iets het verkeerd gegaan, miskien 'n ou reset-skakel waarop u geklik het. Klik hieronder om weer te probeer",
	"VER_RESET"		=> "U wagwoord is herstel!",
	"VER_INS"		=> "<li> Voer u e-posadres in en klik op Herstel </li>
					<li> Kontroleer u e-posadres en klik op die skakel wat aan u gestuur word. </li>
					<li> Volg die instruksies op die skerm </li> ",
	"VER_SENT"		=> "  U skakel vir die herstel van wagwoord is na u e-posadres gestuur.  
					  Klik op die skakel in die e-pos om u wagwoord terug te stel. Maak seker dat u u strooipos van die strooipos nagaan as die e-pos nie in u posbus is nie.  
					  Terugstelskakels is slegs geldig vir ",
	"VER_PLEASE"		=> "Stel u wagwoord asseblief terug",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"	=> "Stel PIN terug",
	"SET_WHY"	=> "Waarom kan ek dit nie verander nie?",
	"SET_PW_MATCH"	=> "Moet ooreenstem met die nuwe wagwoord",
	"SET_PIN_NEXT"	=> "U kan 'n nuwe PIN instel die volgende keer as u verifikasie benodig",
	"SET_UPDATE"	=> "Dateer u gebruikersinstellings op",
	"SET_NOCHANGE"	=> "Die administrateur het veranderende gebruikersname uitgeskakel.",
	"SET_ONECHANGE"	=> "Die administrateur het ingestel dat gebruikersnaamveranderings slegs een keer plaasvind en u het dit al gedoen.",
	"SET_GRAVITAR"	=> " Wil u profielfoto verander?   <br>Besoek <a href='https://af.gravatar.com/'>https://en.gravatar.com/</a> en stel 'n rekening op met dieselfde e-pos as wat u op hierdie webwerf gebruik het. Dit werk op miljoene webwerwe. Dit is vinnig en maklik! ",
	"SET_NOTE1"	=> "   Let wel   daar is 'n hangende versoek om u e-pos op te dateer na",
	"SET_NOTE2"	=> ".     Gebruik die verifikasie-e-pos om hierdie versoek te voltooi.  
				  As u 'n nuwe verifikasie-e-posadres benodig, voer dan weer die e-pos hierbo in en dien die versoek weer in.  ",
	"SET_PW_REQ" 	=> "benodig om wagwoord, e-posadres te verander of PIN te herstel",
	"SET_PW_REQI" 	=> "Vereis om u wagwoord te verander",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"	=> "Kon nie aktiewe sessies doodmaak nie, fout: ",
	"ERR_EMAIL"	=> "E-pos word NIE gestuur as gevolg van 'n fout nie. Kontak die webwerfadministrateur.",
	"ERR_EM_DB"	=> "Die e-posadres bestaan nie in ons databasis nie",
	"ERR_TC"	=> "Lees en aanvaar asseblief die bepalings en voorwaardes",
	"ERR_CAP"	=> "U het die Captcha-toets misluk, Robot!",
	"ERR_PW_SAME"	=> "U ou wagwoord kan nie dieselfde wees as u nuwe nie",
	"ERR_PW_FAIL"	=> "Huidige wagwoordverifikasie het misluk. Opdatering het misluk. Probeer asseblief weer.",
	"ERR_GOOG"	=> " OPMERKING:   As u oorspronklik by u Google / Facebook-rekening aangemeld het, moet u die skakel vir vergeet wagwoord gebruik om u wagwoord te verander ... tensy u regtig goed is met raai. ",
	"ERR_EM_VER"	=> "E-posverifikasie is nie geaktiveer nie. Kontak asseblief die stelseladministrateur.",
	"ERR_EMAIL_STR"	=> "Iets is vreemd. Verifieer asseblief u e-pos weer. Ons is jammer oor die ongerief",
));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"	=> "Ons sal binnekort weer terugkom!",
	"MAINT_MSG"	=> "Jammer vir die ongerief, maar ons is op die oomblik besig met onderhoud. <br> Ons sal binnekort weer aanlyn wees!",
	"MAINT_BAN"	=> "Jammer. U is verban. Kontak die administrateur as u meen dat dit 'n fout is.",
	"MAINT_TOK"	=> "Daar was 'n fout met u vorm. Gaan terug en probeer weer. Let daarop dat die indien van die vorm deur die bladsy te verfris 'n fout sal veroorsaak. As dit aanhou gebeur, kontak die administrateur.",
	"MAINT_OPEN"	=> "\'n Open source PHP-gebruikersbestuurraamwerk.",
	"MAINT_PLEASE"	=> "U het UserSpice suksesvol geïnstalleer! <br>  Om aan die slag te kom met dokumentasie, Besoek graag "
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
