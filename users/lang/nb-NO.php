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

/*
Translation by Scourgess
*/

$lang = array();
//important strings
//You definitely want to customize these for your language
$lang = array_merge($lang, array(
	"THIS_LANGUAGE"	=> "Norsk",
	"THIS_CODE"			=> "nb-NO",
	"MISSING_TEXT"	=> "Mangler tekst",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"    => "Skriv inn koden som ble sendt til e-posten din",
    "PASS_EMAIL_ONLY"    => "Vennligst sjekk e-posten din for en innloggingslenke.",
    "PASS_CODE_ONLY"     => "Vennligst skriv inn koden som ble sendt til e-posten din.",
    "PASS_BOTH"          => "Vennligst sjekk e-posten din for en innloggingslenke eller skriv inn koden som ble sendt til e-posten din.",
    "PASS_VER_BUTTON"    => "Bekreft kode",
    "PASS_EMAIL_ONLY_MSG" => "Vennligst bekreft e-postadressen din ved å klikke på lenken nedenfor.",
    "PASS_CODE_ONLY_MSG"  => "Vennligst skriv inn koden nedenfor for å logge inn.",
    "PASS_BOTH_MSG"       => "Vennligst bekreft e-postadressen din ved å klikke på lenken nedenfor eller skriv inn koden nedenfor for å logge inn.",
    "PASS_YOUR_CODE"      => "Din bekreftelseskode er: ",
    "PASS_CONFIRM_LOGIN"  => "Bekreft innlogging",
    "PASS_CONFIRM_CLICK"  => "Klikk for å fullføre innlogging",
    "PASS_GENERIC_ERROR"  => "Noe gikk galt.",
));

//Database Menus
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"					=> "Registrer",
	"SIGNUP_BUTTONTEXT"		=> "Registrer meg",
	"SIGNUP_AUDITTEXT"		=> "Registrert",
));

// Signin
$lang = array_merge($lang, array(
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
	"SIGNIN_FORGOTPASS"	=> "Glemt passord",
	"SIGNOUT_AUDITTEXT"	=> "Logget ut",
));

// Account Page
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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

//added during passkey/totp update
$lang = array_merge($lang, array(
    "GEN_PASSKEY"                         => "Passnøkkel",
    "GEN_ACTIONS"                         => "Handlinger",
    "GEN_BACK_TO_ACCT"                    => "Tilbake til konto",
    "GEN_DB_ERROR"                        => "Det oppstod en databasefeil. Vennligst prøv igjen.",
    "GEN_IMPORTANT"                       => "Viktig",
    "GEN_NO_PERMISSIONS"                  => "Du har ikke tillatelse til å se denne siden.",
    "GEN_NO_PERMISSIONS_MSG"              => "Du har ikke tillatelse til å se denne siden. Hvis du mener dette er en feil, vennligst kontakt nettstedsadministratoren.",
    "PASSKEYS_MANAGE_TITLE"               => "Administrer dine passnøkler",
    "PASSKEYS_LOGIN_TITLE"                => "Logg inn med passnøkkel",
    "PASSKEY_DELETE_SUCCESS"              => "Passnøkkelen ble slettet.",
    "PASSKEY_DELETE_FAIL_DB"              => "Kunne ikke slette passnøkkelen fra databasen.",
    "PASSKEY_DELETE_NOT_FOUND"            => "Passnøkkelen ble ikke funnet eller du mangler tillatelse til å slette den.",
    "PASSKEY_NOTE_UPDATE_SUCCESS"         => "Notatet for passnøkkelen ble oppdatert.",
    "PASSKEY_NOTE_UPDATE_FAIL"            => "Kunne ikke oppdatere notatet for passnøkkelen.",
    "PASSKEY_REGISTER_NEW"                => "Registrer ny passnøkkel",
    "PASSKEY_ERR_LIMIT_REACHED"           => "Du har nådd maksgrensen på 10 passnøkler.",
    "PASSKEY_NOTE_TH"                     => "Notat for passnøkkel",
    "PASSKEY_TIMES_USED_TH"               => "Antall ganger brukt",
    "PASSKEY_LAST_USED_TH"                => "Sist brukt",
    "PASSKEY_LAST_IP_TH"                  => "Siste IP-adresse",
    "PASSKEY_EDIT_NOTE_BTN"               => "Rediger notat",
    "PASSKEY_CONFIRM_DELETE_JS"           => "Er du sikker på at du vil slette denne passnøkkelen?",
    "PASSKEY_EDIT_MODAL_TITLE"            => "Rediger notat for passnøkkel",
    "PASSKEY_EDIT_MODAL_LABEL"            => "Notat for passnøkkel",
    "PASSKEY_SAVE_CHANGES_BTN"            => "Lagre endringer",
    "PASSKEY_NONE_REGISTERED"             => "Du har ingen registrerte passnøkler ennå.",
    "PASSKEY_MUST_REGISTER_FIRST"         => "Du må først registrere en passnøkkel fra en autentisert konto før du kan bruke denne funksjonen.",
    "PASSKEY_STORING"                     => "Lagrer passnøkkel...",
    "PASSKEY_STORED_SUCCESS"              => "Passnøkkelen ble lagret!",
    "PASSKEY_INVALID_ACTION"              => "Ugyldig handling: ",
    "PASSKEY_NO_ACTION_SPECIFIED"         => "Ingen handling angitt",
    "PASSKEY_ERR_NETWORK_SUGGESTION"      => "Nettverksproblem oppdaget. Prøv et annet nettverk eller oppdater siden.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "Autentisering på tvers av enheter oppdaget. Sørg for at begge enhetene har internettilgang.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "Prøv å åpne denne siden direkte på telefonen din i stedet.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"       => "Kunne ikke generere diagnostikk: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"     => "Nødvendig påloggingsinformasjon for lagring mangler.",
    "PASSKEY_MISSING_AUTH_DATA"           => "Nødvendig autentiseringsinformasjon mangler.",
    "PASSKEY_LOG_NO_MESSAGE"              => "Ingen melding",
    "PASSKEY_USER_NOT_FOUND"              => "Brukeren ble ikke funnet etter validering av passnøkkel.",
    "PASSKEY_FATAL_ERROR"                 => "Alvorlig feil: ",
    "PASSKEY_LOGIN_SUCCESS"               => "Innloggingen var vellykket.",
    // JavaScript status messages (passkeys.php)
    "PASSKEY_CROSS_DEVICE_PREP"           => "Forbereder registrering på tvers av enheter. Du må kanskje bruke telefonen eller nettbrettet.",
    "PASSKEY_DEVICE_REGISTRATION"         => "Bruker enhetens passnøkkelregistrering...",
    "PASSKEY_STARTING_REGISTRATION"       => "Starter registrering av passnøkkel...",
    "PASSKEY_REQUEST_OPTIONS"             => "Ber om registreringsalternativer fra serveren...",
    "PASSKEY_FOLLOW_PROMPTS"              => "Følg instruksjonene for å opprette passnøkkelen din. Du må kanskje bruke en annen enhet.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"       => "Følg instruksjonene for å opprette passnøkkelen din...",
    "PASSKEY_CREATION_FAILED"             => "Oppretting av passnøkkel mislyktes - ingen påloggingsinformasjon ble returnert.",
    "PASSKEY_STORING_SERVER"              => "Lagrer passnøkkelen din...",
    "PASSKEY_CREATED_SUCCESS"             => "Passnøkkelen ble opprettet!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP"      => "Forbereder autentisering på tvers av enheter. Sørg for at telefonen og datamaskinen din har internettilgang.",
    "PASSKEY_DEVICE_AUTH"                 => "Bruker enhetens passnøkkelautentisering...",
    "PASSKEY_STARTING_AUTH"               => "Starter autentisering med passnøkkel...",
    "PASSKEY_QR_CODE_INSTRUCTION"         => "Skann QR-koden med telefonen din når den vises. Sørg for at begge enhetene har internettilgang.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"    => "Velg \"Bruk en telefon eller et nettbrett\" når du blir bedt om det, og skann deretter QR-koden.",
    "PASSKEY_AUTHENTICATING"              => "Autentiserer med passnøkkelen din...",
    "PASSKEY_SUCCESS_REDIRECTING"         => "Autentisering vellykket! Omdirigerer...",
    // Timeout messages
    "PASSKEY_TIMEOUT_CROSS_DEVICE"        => "Registreringen fikk tidsavbrudd. For registrering på tvers av enheter: 1) Prøv igjen, 2) Sørg for at enhetene har internett, 3) Vurder å registrere direkte på telefonen din.",
    "PASSKEY_TIMEOUT_SIMPLE"              => "Registreringen fikk tidsavbrudd. Vennligst prøv igjen.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"   => "Autentisering på tvers av enheter fikk tidsavbrudd. Feilsøking: 1) Begge enhetene trenger internett, 2) Prøv å skanne QR-koden raskere, 3) Vurder å bruke samme enhet, 4) Noen nettverk blokkerer autentisering på tvers av enheter.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"         => "Autentiseringen fikk tidsavbrudd. Vennligst prøv igjen.",
    "PASSKEY_NO_CREDENTIAL"               => "Ingen påloggingsinformasjon mottatt. Prøver igjen...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"   => "Autentiseringen mislyktes - ingen påloggingsinformasjon ble returnert.",
    "PASSKEY_ATTEMPT_RETRY"               => "mislyktes. Prøver igjen... (%d forsøk gjenstår)",
    // Error messages
    "PASSKEY_CROSS_DEVICE_FAILED"         => "Registrering på tvers av enheter mislyktes. Prøv: 1) Sørg for at begge enhetene har internett, 2) Vurder å registrere direkte på telefonen din, 3) Noen bedriftsnettverk blokkerer denne funksjonen.",
    "PASSKEY_REGISTRATION_CANCELLED"      => "Registreringen ble avbrutt, eller enheten støtter ikke passnøkler.",
    "PASSKEY_NOT_SUPPORTED"               => "Passnøkler støttes ikke på denne kombinasjonen av enhet/nettleser.",
    "PASSKEY_SECURITY_ERROR"              => "Sikkerhetsfeil - dette indikerer vanligvis en uoverensstemmelse mellom domene/opprinnelse.",
    "PASSKEY_ALREADY_EXISTS"              => "En passnøkkel finnes allerede for denne kontoen på denne enheten. Prøv å bruke en annen enhet eller slett eksisterende passnøkler først.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"    => "Autentisering på tvers av enheter mislyktes. Prøv: 1) Sørg for at begge enhetene har stabilt internett, 2) Bruk samme WiFi-nettverk om mulig, 3) Prøv å autentisere direkte på telefonen din i stedet, 4) Noen bedriftsnettverk blokkerer denne funksjonen.",
    "PASSKEY_AUTH_CANCELLED"              => "Autentiseringen ble avbrutt, eller ingen passnøkkel ble valgt.",
    "PASSKEY_NETWORK_ERROR"               => "Nettverksfeil. For autentisering på tvers av enheter trenger begge enhetene internettilgang og må kanskje være på samme nettverk.",
    "PASSKEY_CREDENTIAL_NOT_FOUND"        => "Autentiseringen mislyktes - påloggingsinformasjonen ble ikke gjenkjent.",
    // Cross-device guidance
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "Tips for autentisering på tvers av enheter:",
    "PASSKEY_GUIDANCE_INTERNET"           => "Sørg for at både datamaskinen og telefonen din har internettilgang",
    "PASSKEY_GUIDANCE_WIFI"               => "Å være på samme WiFi-nettverk kan hjelpe (men er ikke alltid nødvendig)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"      => "Når du blir bedt om det, velg \"Bruk en telefon eller et nettbrett\"",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"       => "Skann QR-koden raskt når den vises",
    "PASSKEY_GUIDANCE_TRY_DIRECT"         => "Hvis det mislykkes, prøv å oppdatere og bruke telefonens nettleser direkte",
    // Troubleshooting
    "PASSKEY_SHOW_TROUBLESHOOTING"        => "Vis feilsøkingstips",
    "PASSKEY_HIDE_TROUBLESHOOTING"        => "Skjul feilsøkingstips",
    "PASSKEY_DIAGNOSTICS_RUNNING"         => "Kjører diagnostikk...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"        => "Diagnostikken er fullført. Sjekk konsollen for detaljer.",
    "PASSKEY_ISSUES_DETECTED"             => "Problemer oppdaget:",
    "PASSKEY_ENVIRONMENT_SUITABLE"        => "Miljøet ser ut til å være egnet for passnøkler.",
    "PASSKEY_DIAGNOSTICS_FAILED"          => "Diagnostikken mislyktes:",
    // Modal
    "PASSKEY_ADD_NOTE_NEW"                => "Legg til et notat til din nye passnøkkel",
    // Technical errors
    "PASSKEY_BASE64_ERROR"                => "Base64-avkodingsfeil:",
    // Server-side errors (passkey_parser.php)
    "PASSKEY_INVALID_JSON"                => "Ugyldig JSON-data mottatt:",
    // Session/validation errors (PasskeyHandler.php)
    "PASSKEY_NO_CHALLENGE_SESSION"        => "Ingen utfordring for passnøkkelregistrering funnet i økten. Vennligst prøv å registrere på nytt.",
    "PASSKEY_USER_MISMATCH"               => "Bruker-ID stemmer ikke overens. Vennligst prøv å registrere på nytt.",
    "PASSKEY_CHALLENGE_USER_MISMATCH"     => "Bruker-ID i utfordringsalternativene samsvarer ikke med den nåværende brukeren. Vennligst prøv å registrere på nytt.",
    "PASSKEY_REGISTRATION_FAILED_ERROR"   => "Registrering av passnøkkel mislyktes. Sørg for at enheten og nettleseren din støtter WebAuthn, og prøv igjen. Feil:",
    "PASSKEY_NO_AUTH_CHALLENGE_SESSION"   => "Ingen utfordring for passnøkkelautentisering funnet i økten. Vennligst prøv å logge inn på nytt.",
    "PASSKEY_CREDENTIAL_NOT_IN_DB"        => "Passnøkkelens påloggingsinformasjon ble ikke funnet i databasen.",
    "PASSKEY_CREDENTIAL_WRONG_USER"       => "Passnøkkelens påloggingsinformasjon tilhører ikke den forventede brukeren.",
    "PASSKEY_VALIDATION_FAILED_ERROR"     => "Validering av passnøkkel mislyktes. Vennligst prøv igjen eller kontakt support hvis problemet vedvarer. Feil:",
    "PASSKEY_USER_NOT_FOUND_REGISTRATION" => "Bruker for registrering ble ikke funnet.",
    // --- Used in passkey_parser.php ---
    "PASSKEY_LOGIN_REQUIRED"              => "Du må være logget inn for å utføre denne handlingen.",
    "PASSKEY_ACTION_MISSING"              => "Den nødvendige parameteren 'action' manglet i forespørselen.",
    "PASSKEY_STORAGE_FAILED"              => "Kunne ikke lagre passnøkkelen. Operasjonen mislyktes.",
    "PASSKEY_LOGIN_FAILED"                => "Innlogging med passnøkkel mislyktes. Autentiseringen kunne ikke verifiseres.",
    "PASSKEY_INVALID_METHOD"              => "Ugyldig forespørselsmetode:", // The script appends the method name after this key
    // --- Used in passkeys.php ---
    "CSRF_ERROR"                          => "CSRF-tokenkontrollen mislyktes. Gå tilbake og prøv å sende inn skjemaet på nytt.",
    // Network analysis from analyzeNetworkConditions()
    "PASSKEY_NETWORK_PRIVATE"             => "Mulig problem: Du ser ut til å være på et privat nettverk, som noen ganger kan forstyrre kommunikasjon på tvers av enheter.",
    "PASSKEY_NETWORK_PROXY"               => "Mulig problem: En proxy eller VPN ble oppdaget. Dette kan forstyrre kommunikasjon på tvers av enheter.",
    "PASSKEY_NETWORK_MOBILE"              => "Merk: Du ser ut til å være på et mobilnettverk. Sørg for en stabil tilkobling for operasjoner på tvers av enheter.",
    "PASSKEY_NETWORK_CORPORATE"           => "Mulig problem: En bedriftsbrannmur kan være aktiv, noe som kan påvirke autentisering på tvers av enheter.",
    // Recommendations from getCrossDeviceRecommendations()
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "Anbefaling: Du bruker sannsynligvis en stasjonær datamaskin. Forbered deg på å bruke telefonen din til å skanne en QR-kode.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "Anbefaling: For best resultat, sørg for at datamaskinen og mobilenheten din er på samme Wi-Fi-nettverk.",
    "PASSKEY_RECOMMENDATION_QR_QUICK"     => "Anbefaling: Vær forberedt på å skanne QR-koden raskt, da forespørselen kan få tidsavbrudd.",
    "PASSKEY_RECOMMENDATION_INTERNET"     => "Anbefaling: Sørg for at både datamaskinen og mobilenheten din har en stabil internettforbindelse.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "Anbefaling: For Unity WebViews, sørg for at siden har nok tid til å laste inn og behandle passnøkkel-forespørselen.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "Anbefaling: Tidsavbrudd kan være lengre i Unity. Vær tålmodig.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "Anbefaling: Siden du er på en mobilenhet, bør du kunne registrere en passnøkkel direkte på denne enheten.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Anbefaling: På Android kan du administrere passnøklene dine i Google Passordbehandling.",
    // Validation from validateCrossDeviceEnvironment()
    "PASSKEY_VALIDATION_RP_IP"            => "Konfigurasjonsadvarsel: Relying Party ID er satt til en IP-adresse.",
    "PASSKEY_VALIDATION_RP_DOMAIN"        => "Anbefaling: Sett Relying Party ID til domenenavnet ditt (f.eks. dinnettside.no) for bedre sikkerhet og kompatibilitet.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"   => "Konfigurasjonsfeil: HTTPS kreves for at passnøkler skal fungere på en live server. Nettstedet ditt ser ut til å være på HTTP.",
    "PASSKEY_VALIDATION_NETWORK"          => "Nettverksadvarsel", // Generic prefix for network issues
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "Anbefaling: Hvis du opplever problemer, prøv et annet nettverk (f.eks. bytt fra bedriftens Wi-Fi til et mobilt hotspot).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "Anbefaling: For handlinger på tvers av enheter, sørg for at begge enhetene har en pålitelig internettforbindelse.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"  => "Anbefaling: Hvis handlinger på tvers av enheter mislykkes, prøv å besøke denne siden direkte på mobilenheten din for å fullføre handlingen.",
    "PASSKEY_INFO_TITLE"                  => "Om passnøkler",
    "PASSKEY_INFO_DESC"                   => "Passnøkler er en sikker, passordfri måte å logge inn på ved å bruke enhetens innebygde sikkerhetsfunksjoner som fingeravtrykk, ansiktsgjenkjenning eller PIN-kode. De er sikrere enn passord, gir raskere innlogging, fungerer på tvers av enheter når de synkroniseres med passordbehandlere, og er motstandsdyktige mot phishing-angrep. Passnøkler fungerer på moderne smarttelefoner, nettbrett, datamaskiner og kan lagres i passordbehandlere som 1Password, Bitwarden, iCloud-nøkkelring eller Google Passordbehandling.",
    "PASSKEY_BACK_TO_LOGIN"               => "Tilbake til innlogging",
));

//validation class
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"JOIN_SUC"			=> "Velkommen til ",
	"JOIN_THANKS"		=> "Takk for registrering!",
	"JOIN_HAVE"			=> "Ha mind ",
	"JOIN_LOWER"	=> " liten bokstav",
	"JOIN_SYMBOL"		=> " symbol",
	"JOIN_CAP"			=> " stor bokstav",
	"JOIN_TWICE"		=> "Være tastet riktig to ganger",
	"JOIN_CLOSED"		=> "Beklageligvis er registrering for tiden deaktivert. Vennlingst kontakt administratoren av nettsiden dersom du har spørsmål eller bekymringer.",
	"JOIN_TC"				=> "Brukervilkår ved registrering",
	"JOIN_ACCEPTTC" => "Jeg aksepterer brukervilkårene",
	"JOIN_CHANGED"	=> "Våre brukervilkår har blitt endret",
	"JOIN_ACCEPT" 	=> "Aksepter brukervilkårene og fortsett",
	"JOIN_SCORE" => "Poeng:",
	"JOIN_INVALID_PW" => "Passordet ditt er ugyldig",

));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "Vellyket drap av ",
));

//Messages
$lang = array_merge($lang, array(
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
	"MSG_MODAL"			=> "Trykk har eller trykk Alt + R for å sette fokus på denne boksen ELLER trykk Skift   R for å åpne det utvidede svarpanelet!",
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

//Two Factor Authentication
$lang = array_merge($lang, array(
    "2FA"                                => "Tofaktorautentisering",
    "2FA_CONF"                           => "Er du sikker på at du vil deaktivere tofaktorautentisering? Kontoen din vil ikke lenger være beskyttet.",
    "2FA_SCAN"                           => "Skann denne QR-koden med autentiseringsappen din eller skriv inn nøkkelen",
    "2FA_THEN"                           => "Skriv deretter inn en av engangskodene dine her",
    "2FA_FAIL"                           => "Det oppstod et problem under verifisering av tofaktorautentisering. Vennligst sjekk internettforbindelsen eller kontakt support.",
    "2FA_CODE"                           => "2FA-kode",
    "2FA_EXP"                            => "1 fingeravtrykk har utløpt",
    "2FA_EXPD"                           => "Utløpt",
    "2FA_EXPS"                           => "Utløper",
    "2FA_ACTIVE"                         => "Aktive økter",
    "2FA_NOT_FN"                         => "Ingen fingeravtrykk funnet",
    "2FA_FP"                             => "Fingeravtrykk",
    "2FA_NP"                             => "Innlogging mislyktes - Tofaktorautentiseringskode manglet. Vennligst prøv igjen.",
    "2FA_INV"                            => "Innlogging mislyktes - Tofaktorautentiseringskoden var ugyldig. Vennligst prøv igjen.",
    "2FA_FATAL"                          => "Alvorlig feil - Vennligst kontakt systemadministratoren. Vi kan ikke generere en tofaktorautentiseringskode for øyeblikket.",
    "2FA_SECTION_TITLE"                  => "Tofaktorautentisering (TOTP)",
    "2FA_SK_ALT"                         => "Hvis du ikke kan skanne QR-koden, skriv inn denne hemmelige nøkkelen manuelt i autentiseringsappen din.",
    "2FA_IS_ENABLED"                     => "Tofaktorautentisering beskytter kontoen din.",
    "2FA_NOT_ENABLED_INFO"               => "Tofaktorautentisering er for øyeblikket ikke aktivert.",
    "2FA_NOT_ENABLED_EXPLAIN"            => "Tofaktorautentisering (TOTP) legger til et ekstra sikkerhetslag til kontoen din ved å kreve en kode fra en autentiseringsapp på telefonen din i tillegg til passordet ditt.",
    // Setup Process
    "2FA_SETUP_TITLE"                    => "Sett opp tofaktorautentisering",
    "2FA_SECRET_KEY_LABEL"               => "Hemmelig nøkkel:",
    "2FA_SETUP_VERIFY_CODE_LABEL"        => "Skriv inn bekreftelseskode fra appen",
    // Backup Codes
    "2FA_SUCCESS_ENABLED_TITLE"          => "Tofaktorautentisering aktivert! Lagre reservekodene dine",
    "2FA_SUCCESS_ENABLED_INFO"           => "Nedenfor er reservekodene dine. Lagre dem på et sikkert sted - hver kan bare brukes én gang.",
    "2FA_BACKUP_CODES_WARNING"           => "Behandle disse kodene som passord. Lagre dem på et sikkert sted.",
    "2FA_SUCCESS_BACKUP_REGENERATED"     => "Nye reservekoder generert. Lagre dem på et sikkert sted.",
    "2FA_BACKUP_CODE_LABEL"              => "Reservekode",
    "2FA_REGEN_CODES_BTN"                => "Generer nye reservekoder",
    "2FA_INVALIDATE_WARNING"             => "Dette vil ugyldiggjøre alle eksisterende reservekoder. Er du sikker?",
    // Authentication
    "2FA_CODE_LABEL"                     => "Autentiseringskode",
    "2FA_VERIFY_BTN"                     => "Verifiser og logg inn",
    "2FA_VERIFY_TITLE"                   => "Tofaktorautentisering kreves",
    "2FA_VERIFY_INFO"                    => "Skriv inn den 6-sifrede koden fra autentiseringsappen din.",
    // Actions & Buttons
    "2FA_ENABLE_BTN"                     => "Aktiver tofaktorautentisering",
    "2FA_DISABLE_BTN"                    => "Deaktiver tofaktorautentisering",
    "2FA_VERIFY_ACTIVATE_BTN"            => "Verifiser og aktiver",
    "2FA_CANCEL_SETUP_BTN"               => "Avbryt oppsett",
    "2FA_DONE_BTN"                       => "Ferdig",
    // Success Messages
    "REDIR_2FA_DIS"                      => "Tofaktorautentisering er deaktivert.",
    "2FA_SUCCESS_BACKUP_ACK"             => "Reservekoder bekreftet.",
    "2FA_SUCCESS_SETUP_CANCELLED"        => "Oppsett avbrutt.",
    // Error Messages
    "2FA_ERR_INVALID_BACKUP"             => "Ugyldig reservekode. Vennligst prøv igjen.",
    "2FA_ERR_DISABLE_FAILED"             => "Kunne ikke deaktivere tofaktorautentisering.",
    "2FA_ERR_NO_SECRET"                  => "Kunne ikke hente autentiseringshemmeligheten. Vennligst prøv igjen.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"     => "Reservekoden ble verifisert, men ugyldiggjøringen mislyktes. Vennligst kontakt support.",
    "2FA_ERR_NO_CODE_PROVIDED"           => "Ingen autentiseringskode ble oppgitt.",
    "RATE_LIMIT_LOGIN"                   => "For mange mislykkede innloggingsforsøk. Vennligst vent før du prøver igjen.",
    "RATE_LIMIT_TOTP"                    => "For mange feilaktige autentiseringskoder. Vennligst vent før du prøver igjen.",
    "RATE_LIMIT_PASSKEY"                 => "For mange autentiseringsforsøk med passnøkkel. Vennligst vent før du prøver igjen.",
    "RATE_LIMIT_PASSKEY_STORE"           => "For mange registreringsforsøk for passnøkkel. Vennligst vent før du prøver igjen.",
    "RATE_LIMIT_PASSWORD_RESET"          => "For mange forespørsler om passordtilbakestilling. Vennligst vent før du ber om en ny.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT"   => "For mange forsøk på passordtilbakestilling. Vennligst vent før du prøver igjen.",
    "RATE_LIMIT_REGISTRATION"            => "For mange registreringsforsøk. Vennligst vent før du prøver igjen.",
    "RATE_LIMIT_EMAIL_VERIFICATION"      => "For mange forespørsler om e-postbekreftelse. Vennligst vent før du ber om en ny.",
    "RATE_LIMIT_EMAIL_CHANGE"            => "For mange forespørsler om e-postendring. Vennligst vent før du prøver igjen.",
    "RATE_LIMIT_PASSWORD_CHANGE"         => "For mange forsøk på passordendring. Vennligst vent før du prøver igjen.",
    "RATE_LIMIT_GENERIC"                 => "For mange forsøk. Vennligst vent før du prøver igjen.",
));


$lang = array_merge($lang, array(
	"REDIR_2FA" => "Beklager. To-faktor er ikke aktivert på dette tidspunktet.",
	"REDIR_2FA_EN" => "To-faktor autentisering aktivert",
	"REDIR_2FA_DIS" => "To-faktor autentisering deaktivert",
	"REDIR_2FA_VER" => "To-faktor autentisering bekreftet og aktivert",
	"REDIR_SOMETHING_WRONG" => "Noe gikk galt. Vennligst prøv igjen.",
	"REDIR_MSG_NOEX" => "Denne tråden tilhører ikke deg eller eksisterer ikke.",
	"REDIR_UN_ONCE" => "Brukernavnet har allerede blitt endret én gang.",
	"REDIR_EM_SUCC" => "E-post oppdatert vellykket",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "Logg inn med:",
	"EML_FEATURE_DISABLED" => "Denne funksjonen er deaktivert",
	"EML_PASSWORDLESS_SENT" => "Vennligst sjekk e-posten din for en lenke for å logge inn.",
	"EML_PASSWORDLESS_SUBJECT" => "Vennligst bekreft e-posten din for å logge inn.",
	"EML_PASSWORDLESS_BODY" => "Vennligst bekreft din e-postadresse ved å klikke på lenken nedenfor. Du vil bli automatisk logget inn.",

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
$lang = array_merge($lang, array(
	"VER_SUC"			=> "E-postadressen din har blitt verifisert!",
	"VER_FAIL"		=> "Vi kunne ikke verifisere kontoen din. Vennligst prøv igjen.",
	"VER_RESEND"	=> "Send ny e-post med verifisering",
	"VER_AGAIN"		=> "Skriv inn e-postadressen din og prøv igjen",
	"VER_PAGE"		=> "<li>Sjekk e-posten din og kikk på lenken som du har fått tilsendt</li><li>Ferdig</li>",
	"VER_RES_SUC" => " En verifiseringslenke har blitt sendt til e-postadressen din.  Trykk på lenken i e-posten for å fullføre verifiseringen. Se i søppelpost dersom e-posten ikke er i innboksen din.  Verifiseringslenker er kun gyldige i ",
	"VER_OOPS"		=> "Oops...noe gikk galt, kanskje du brukte en utgått link. Trykk under for å prøve på nytt",
	"VER_RESET"		=> "Passordet ditt har blitt nullstilt!",
	"VER_INS"			=> "<li>Skriv inn e-postadressen og klikk nullstill</li> <li>Se i e-posten din og klikk på lenken som du har fått tilsendt.</li>
												<li>Følg instruksjonene som vises på skjermen</li>",
	"VER_SENT"		=> " Link for å nullstille passordet ditt har blitt sendt til e-postadressen din. 
			    							 Trykk på linken i e-posten for å nullstille passordet ditt. Se i søppelpost dersom e-posten ikke ligger i innboksen din.  Passordlenker er kun gyldige i ",
	"VER_PLEASE"	=> "Vennligst bytt passordet ditt",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"				=> "Nullstill PIN",
	"SET_WHY"				=> "Hvorfor kan jeg ikke endre dette?",
	"SET_PW_MATCH"	=> "Må tilsvare det nye passordet",

	"SET_PIN_NEXT"	=> "Du kan sette en ny PIN til neste gang du trenger verifisering",
	"SET_UPDATE"		=> "Oppdater brukerinnstillingine dine",
	"SET_NOCHANGE"	=> "Administratoren har deaktivert endring av brukernavn.",
	"SET_ONECHANGE"	=> "Administratoren har satt opp endring av brukernavn til å kun kunne skje en gang, og du har allerede endret brukernavnet en gang.",

	"SET_GRAVITAR"	=> "Har du lyst til å endre profilbildet?  <br> Besøk <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> og opprett en konto med samme e-postadresse som du har på denne nettsiden. Det fungerer på millioner av nettsider. Det er raskt og enkelt!",

	"SET_NOTE1"			=> " Vennligst merk  det foreligger en ventende anmodning for oppdatering av e-postadressen din til",

	"SET_NOTE2"			=> ".  Vennligst bruk verifiseringen tilsendt på e-post for å fullføre denne forespørselen. 
		 Dersom du trenger en ny verifiseringse-post, vennligst skriv inn e-posten over og utfør forespørselen på nytt. ",

	"SET_PW_REQ" 		=> "påkrevd for å endre passord, e-post, eller nullstille PIN",
	"SET_PW_REQI" 	=> " Må endre passordet ditt",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "Klarte ikke å drepe aktive sesjoner, feil: ",
	"ERR_EMAIL"				=> "E-post IKKE sendt grunnet en feil. Vennligst kontakt administratoren.",
	"ERR_EM_DB"				=> "Den e-postadressen eksisterer ikke i vår database",
	"ERR_TC"					=> "Vennligst les og aksepter brukervilkårene",
	"ERR_CAP"					=> "Du klarte ikke Captcha-testen, robot!",
	"ERR_PW_SAME"			=> "Det nye passordet ditt kan ikke være det samme som det gamle",
	"ERR_PW_FAIL"			=> "Feil ved verifisering av gjeldende passord. Oppdateringsfeil. Vennligst prøv igjen.",
	"ERR_GOOG"				=> "MERK:  Dersom du først registrerte deg med en Google eller Facebook konto må du bruke glemt passord-linken for å bytte passordet ditt...hvis ikke du er veldig god til å gjette.",
	"ERR_EM_VER"			=> "E-postverifisering er ikke aktivert. Vennligst kontakt systemadministratoren.",
	"ERR_EMAIL_STR"		=> "Noe rart har skjedd. Vennligst verifiser e-postadressen din på nytt. Vi beklager ulempen",

));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "Vi er snart tilbake",
	"MAINT_MSG"			=> "Beklager ulempen. Vi utfører litt vedlikehold akkurat nå.<br> Vi er straks tilbake!",
	"MAINT_BAN"			=> "Beklager. Du har blitt utestengt. Dersom du anser dette som en feil, vennligst kontakt administratoren.",
	"MAINT_TOK"			=> "Det er en feil med skjemaet ditt. Vennligst gå tilbake og prøv igjen. Merk at det vil oppstå en feil dersom du frisker opp siden på nytt. Dersom denne feilen vedvarer, vennligst kontakt administratoren.",
	"MAINT_OPEN"		=> "Et åpen kildekode brukerhåndteringsrammeverk.",
	"MAINT_PLEASE"	=> "Installasjonen av UserSpice var vellykket!<br>For vår kom-i-gang dokumentasjon, vennligst besøk"
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
