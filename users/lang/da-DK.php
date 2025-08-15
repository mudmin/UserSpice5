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
	"THIS_LANGUAGE"	=> "Dansk",
	"THIS_CODE"			=> "da-DK",
	"MISSING_TEXT"	=> "Manglende tekst",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "Indtast koden sendt til din e-mail",
    "PASS_EMAIL_ONLY"     => "Tjek venligst din e-mail for et login-link",
    "PASS_CODE_ONLY"      => "Indtast venligst koden sendt til din e-mail",
    "PASS_BOTH"           => "Tjek venligst din e-mail for et login-link eller indtast koden sendt til din e-mail",
    "PASS_VER_BUTTON"     => "Bekræft kode",
    "PASS_EMAIL_ONLY_MSG" => "Bekræft venligst din e-mailadresse ved at klikke på linket nedenfor",
    "PASS_CODE_ONLY_MSG"  => "Indtast venligst koden nedenfor for at logge ind",
    "PASS_BOTH_MSG"       => "Bekræft venligst din e-mailadresse ved at klikke på linket nedenfor eller indtast koden nedenfor for at logge ind",
    "PASS_YOUR_CODE"      => "Din bekræftelseskode er: ",
    "PASS_CONFIRM_LOGIN"  => "Bekræft Login",
    "PASS_CONFIRM_CLICK"  => "Klik for at fuldføre login",
    "PASS_GENERIC_ERROR"  => "Noget gik galt",
));


//Database Menus
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"					=> "Registrer",
	"SIGNUP_BUTTONTEXT"		=> "Registrer Mig",
	"SIGNUP_AUDITTEXT"		=> "Registreret",
));

// Signin
$lang = array_merge($lang, array(
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
	"SIGNIN_FORGOTPASS"	=> "Glemt adgangskode",
	"SIGNOUT_AUDITTEXT"	=> "Logget ud",
));

// Account Page
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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

//added during passkey/totp update

$lang = array_merge($lang, array(
    "GEN_PASSKEY"           => "Adgangsnøgle",
    "GEN_ACTIONS"           => "Handlinger",
    "GEN_BACK_TO_ACCT"      => "Tilbage til konto",
    "GEN_DB_ERROR"          => "Der opstod en databasefejl. Prøv venligst igen.",
    "GEN_IMPORTANT"         => "Vigtigt",
    "GEN_NO_PERMISSIONS"    => "Du har ikke tilladelse til at tilgå denne side.",
    "GEN_NO_PERMISSIONS_MSG" => "Du har ikke tilladelse til at tilgå denne side. Hvis du mener dette er en fejl, kontakt venligst sideadministratoren.",
    "PASSKEYS_MANAGE_TITLE"                 => "Administrer adgangsnøgler",
    "PASSKEYS_LOGIN_TITLE"                  => "Log ind med adgangsnøgle",
    "PASSKEY_DELETE_SUCCESS"                => "Adgangsnøgle slettet med succes.",
    "PASSKEY_DELETE_FAIL_DB"                => "Kunne ikke slette adgangsnøgle fra database.",
    "PASSKEY_DELETE_NOT_FOUND"              => "Adgangsnøgle ikke fundet eller du har ikke tilladelse til at slette den.",
    "PASSKEY_NOTE_UPDATE_SUCCESS"           => "Adgangsnøgle note opdateret med succes.",
    "PASSKEY_NOTE_UPDATE_FAIL"              => "Kunne ikke opdatere adgangsnøgle note.",
    "PASSKEY_REGISTER_NEW"                  => "Registrer ny adgangsnøgle",
    "PASSKEY_ERR_LIMIT_REACHED"             => "Du har nået maksimum på 10 adgangsnøgler.",
    "PASSKEY_NOTE_TH"                       => "Adgangsnøgle note",
    "PASSKEY_TIMES_USED_TH"                 => "Gange brugt",
    "PASSKEY_LAST_USED_TH"                  => "Sidst brugt",
    "PASSKEY_LAST_IP_TH"                    => "Sidste IP",
    "PASSKEY_EDIT_NOTE_BTN"                 => "Rediger note",
    "PASSKEY_CONFIRM_DELETE_JS"             => "Er du sikker på, at du vil slette denne adgangsnøgle?",
    "PASSKEY_EDIT_MODAL_TITLE"              => "Rediger adgangsnøgle note",
    "PASSKEY_EDIT_MODAL_LABEL"              => "Adgangsnøgle note",
    "PASSKEY_SAVE_CHANGES_BTN"              => "Gem ændringer",
    "PASSKEY_NONE_REGISTERED"               => "Du har ikke registreret nogen adgangsnøgler endnu.",
    "PASSKEY_MUST_REGISTER_FIRST"           => "Du skal først registrere en adgangsnøgle fra en godkendt konto, før du kan bruge denne funktion.",
    "PASSKEY_STORING"                       => "Gemmer adgangsnøgle...",
    "PASSKEY_STORED_SUCCESS"                => "Adgangsnøgle gemt med succes!",
    "PASSKEY_INVALID_ACTION"                => "Ugyldig handling: ",
    "PASSKEY_NO_ACTION_SPECIFIED"           => "Ingen handling angivet",
    "PASSKEY_DELETE_NOT_FOUND"              => "Adgangsnøgle ikke fundet eller tilladelse nægtet.",
    "PASSKEY_ERR_NETWORK_SUGGESTION"        => "Netværksproblem opdaget. Prøv et andet netværk eller opdater siden.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION"   => "Tværs-enheds-godkendelse opdaget. Sørg for at begge enheder har internetadgang.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE"  => "Prøv at åbne denne side direkte på din telefon i stedet.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"         => "Kunne ikke generere diagnostik: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"       => "Mangler nødvendige legitimationsdata til lagring.",
    "PASSKEY_MISSING_AUTH_DATA"             => "Mangler nødvendige godkendelsesdata.",
    "PASSKEY_LOG_NO_MESSAGE"                => "Ingen besked",
    "PASSKEY_USER_NOT_FOUND"                => "Bruger ikke fundet efter adgangsnøgle validering.",
    "PASSKEY_FATAL_ERROR"                   => "Fatal fejl: ",
    "PASSKEY_LOGIN_SUCCESS"                 => "Login succesfuldt.",
    "PASSKEY_CROSS_DEVICE_PREP"             => "Forbereder tværs-enheds-registrering. Du skal muligvis bruge din telefon eller tablet.",
    "PASSKEY_DEVICE_REGISTRATION"           => "Bruger enheds-adgangsnøgle registrering...",
    "PASSKEY_STARTING_REGISTRATION"         => "Starter adgangsnøgle registrering...",
    "PASSKEY_REQUEST_OPTIONS"               => "Anmoder om registreringsmuligheder fra server...",
    "PASSKEY_FOLLOW_PROMPTS"                => "Følg promptsne for at oprette din adgangsnøgle. Du skal muligvis bruge en anden enhed.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"         => "Følg promptsne for at oprette din adgangsnøgle...",
    "PASSKEY_CREATION_FAILED"               => "Oprettelse af adgangsnøgle mislykkedes - ingen legitimation returneret.",
    "PASSKEY_STORING_SERVER"                => "Gemmer din adgangsnøgle...",
    "PASSKEY_CREATED_SUCCESS"               => "Adgangsnøgle oprettet med succes!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP"        => "Forbereder tværs-enheds-godkendelse. Sørg for at din telefon og computer har internetadgang.",
    "PASSKEY_DEVICE_AUTH"                   => "Bruger enheds-adgangsnøgle godkendelse...",
    "PASSKEY_STARTING_AUTH"                 => "Starter adgangsnøgle godkendelse...",
    "PASSKEY_QR_CODE_INSTRUCTION"           => "Scan QR-koden med din telefon når den vises. Sørg for at begge enheder har internetadgang.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"      => "Vælg \"Brug en telefon eller tablet\" når du bliver spurgt, scan derefter QR-koden.",
    "PASSKEY_AUTHENTICATING"                => "Godkender med din adgangsnøgle...",
    "PASSKEY_SUCCESS_REDIRECTING"           => "Godkendelse succesfuld! Omdirigerer...",
    "PASSKEY_TIMEOUT_CROSS_DEVICE"          => "Registrering udløb. For tværs-enheder: 1) Prøv igen, 2) Sørg for at enheder har internet, 3) Overvej at registrere direkte på din telefon.",
    "PASSKEY_TIMEOUT_SIMPLE"                => "Registrering udløb. Prøv venligst igen.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"     => "Tværs-enheds-godkendelse udløb. Fejlfinding: 1) Begge enheder har brug for internet, 2) Prøv at scanne QR-koden hurtigere, 3) Overvej at bruge samme enhed, 4) Nogle netværk blokerer tværs-enheds-godkendelse.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"           => "Godkendelse udløb. Prøv venligst igen.",
    "PASSKEY_NO_CREDENTIAL"                 => "Ingen legitimation modtaget. Prøver igen...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"     => "Godkendelse mislykkedes - ingen legitimation returneret.",
    "PASSKEY_ATTEMPT_RETRY"                 => "mislykkedes. Prøver igen... (%d forsøg tilbage)",
    "PASSKEY_CROSS_DEVICE_FAILED"           => "Tværs-enheds-registrering mislykkedes. Prøv: 1) Sørg for at begge enheder har internet, 2) Overvej at registrere direkte på din telefon, 3) Nogle virksomhedsnetværk blokerer denne funktion.",
    "PASSKEY_REGISTRATION_CANCELLED"        => "Registrering blev aflyst eller enheden understøtter ikke adgangsnøgler.",
    "PASSKEY_NOT_SUPPORTED"                 => "Adgangsnøgler understøttes ikke på denne enhed/browser kombination.",
    "PASSKEY_SECURITY_ERROR"                => "Sikkerhedsfejl - dette indikerer normalt et domæne/oprindelse mismatch.",
    "PASSKEY_ALREADY_EXISTS"                => "En adgangsnøgle eksisterer allerede for denne konto på denne enhed. Prøv at bruge en anden enhed eller slet eksisterende adgangsnøgler først.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"      => "Tværs-enheds-godkendelse mislykkedes. Prøv: 1) Sørg for at begge enheder har stabilt internet, 2) Brug samme WiFi-netværk hvis muligt, 3) Prøv at godkende direkte på din telefon i stedet, 4) Nogle virksomhedsnetværk blokerer denne funktion.",
    "PASSKEY_AUTH_CANCELLED"                => "Godkendelse blev aflyst eller ingen adgangsnøgle blev valgt.",
    "PASSKEY_NETWORK_ERROR"                 => "Netværksfejl. For tværs-enheds-godkendelse har begge enheder brug for internetadgang og skal muligvis være på samme netværk.",
    "PASSKEY_CREDENTIAL_NOT_FOUND"          => "Godkendelse mislykkedes - legitimation ikke genkendt.",
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE"   => "Tips til tværs-enheds-godkendelse:",
    "PASSKEY_GUIDANCE_INTERNET"             => "Sørg for at både din computer og telefon har internetadgang",
    "PASSKEY_GUIDANCE_WIFI"                 => "At være på samme WiFi-netværk kan hjælpe (men kræves ikke altid)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"        => "Når du bliver spurgt, vælg \"Brug en telefon eller tablet\"",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"         => "Scan QR-koden hurtigt når den vises",
    "PASSKEY_GUIDANCE_TRY_DIRECT"           => "Hvis det fejler, prøv at opdatere og bruge din telefons browser direkte",
    "PASSKEY_SHOW_TROUBLESHOOTING"          => "Vis fejlfindingstips",
    "PASSKEY_HIDE_TROUBLESHOOTING"          => "Skjul fejlfindingstips",
    "PASSKEY_DIAGNOSTICS_RUNNING"           => "Kører diagnostik...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"          => "Diagnostik færdig. Tjek konsol for detaljer.",
    "PASSKEY_ISSUES_DETECTED"               => "Problemer opdaget:",
    "PASSKEY_ENVIRONMENT_SUITABLE"          => "Miljø ser ud til at være egnet til adgangsnøgler.",
    "PASSKEY_DIAGNOSTICS_FAILED"            => "Diagnostik mislykkedes:",
    "PASSKEY_ADD_NOTE_NEW"                  => "Tilføj note til din nye adgangsnøgle",
    "PASSKEY_BASE64_ERROR"                  => "Base64 afkodningsfejl:",
    "PASSKEY_INVALID_JSON"                  => "Ugyldige JSON data modtaget:",
    "PASSKEY_NO_CHALLENGE_SESSION"          => "Ingen adgangsnøgle registreringsudfordring fundet i session. Prøv venligst at registrere igen.",
    "PASSKEY_USER_MISMATCH"                 => "Bruger ID mismatch. Prøv venligst at registrere igen.",
    "PASSKEY_CHALLENGE_USER_MISMATCH"       => "Bruger ID i udfordringsvalgmuligheder matcher ikke nuværende bruger. Prøv venligst at registrere igen.",
    "PASSKEY_REGISTRATION_FAILED_ERROR"     => "Adgangsnøgle registrering mislykkedes. Sørg venligst for at din enhed og browser understøtter WebAuthn og prøv igen. Fejl:",
    "PASSKEY_NO_AUTH_CHALLENGE_SESSION"     => "Ingen adgangsnøgle assertions udfordring fundet i session. Prøv venligst at logge ind igen.",
    "PASSKEY_CREDENTIAL_NOT_IN_DB"          => "Adgangsnøgle legitimation ikke fundet i databasen.",
    "PASSKEY_CREDENTIAL_WRONG_USER"         => "Adgangsnøgle legitimation tilhører ikke den forventede bruger.",
    "PASSKEY_VALIDATION_FAILED_ERROR"       => "Adgangsnøgle validering mislykkedes. Prøv venligst igen eller kontakt support hvis problemet fortsætter. Fejl:",
    "PASSKEY_USER_NOT_FOUND_REGISTRATION"   => "Bruger ikke fundet for registrering.",
    "PASSKEY_LOGIN_REQUIRED"        => "Du skal være logget ind for at udføre denne handling.",
    "PASSKEY_ACTION_MISSING"        => "Den påkrævede 'action' parameter manglede fra anmodningen.",
    "PASSKEY_STORAGE_FAILED"        => "Kunne ikke gemme adgangsnøglen. Operationen var ikke succesfuld.",
    "PASSKEY_LOGIN_FAILED"          => "Adgangsnøgle login mislykkedes. Godkendelsen kunne ikke verificeres.",
    "PASSKEY_INVALID_METHOD"        => "Ugyldig anmodningsmetode:",
    "CSRF_ERROR"                    => "CSRF token tjek mislykkedes. Gå venligst tilbage og prøv at indsende formularen igen.",
    "PASSKEY_NETWORK_PRIVATE"       => "Potentielt problem: Du ser ud til at være på et privat netværk, hvilket nogle gange kan forstyrre tværs-enheds-kommunikation.",
    "PASSKEY_NETWORK_PROXY"         => "Potentielt problem: En proxy eller VPN blev opdaget. Dette kan forstyrre tværs-enheds-kommunikation.",
    "PASSKEY_NETWORK_MOBILE"        => "Bemærk: Du ser ud til at være på et mobilt netværk. Sørg for en stabil forbindelse til tværs-enheds-operationer.",
    "PASSKEY_NETWORK_CORPORATE"     => "Potentielt problem: En virksomhedsfirewall kan være aktiv, hvilket kunne påvirke tværs-enheds-godkendelse.",
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE"   => "Anbefaling: Du bruger sandsynligvis en desktop. Forbered dig på at bruge din telefon til at scanne en QR-kode.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK"   => "Anbefaling: For bedste resultater, sørg for at din computer og mobile enhed er på samme Wi-Fi netværk.",
    "PASSKEY_RECOMMENDATION_QR_QUICK"       => "Anbefaling: Vær klar til at scanne QR-koden hurtigt, da anmodningen kan udløbe.",
    "PASSKEY_RECOMMENDATION_INTERNET"       => "Anbefaling: Sørg for at både din computer og din mobile enhed har en stabil internetforbindelse.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW"  => "Anbefaling: For Unity WebViews, sørg for at siden har nok tid til at indlæse og behandle adgangsnøgle anmodningen.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT"  => "Anbefaling: Timeouts kan være længere i Unity. Vær venligst tålmodig.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL"   => "Anbefaling: Da du er på mobil, skulle du kunne registrere en adgangsnøgle direkte til denne enhed.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Anbefaling: På Android kan du administrere dine adgangsnøgler i Google Password Manager.",
    "PASSKEY_VALIDATION_RP_IP"                  => "Konfigurationsadvarsel: Relying Party ID er sat til en IP-adresse.",
    "PASSKEY_VALIDATION_RP_DOMAIN"              => "Anbefaling: Indstil Relying Party ID til dit domænenavn (f.eks. yourwebsite.com) for bedre sikkerhed og kompatibilitet.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"         => "Konfigurationsfejl: HTTPS er påkrævet for at adgangsnøgler virker på en live server. Din side ser ud til at være på HTTP.",
    "PASSKEY_VALIDATION_NETWORK"                => "Netværksadvarsel",
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK"  => "Anbefaling: Hvis du oplever problemer, prøv et andet netværk (f.eks. skift fra virksomheds Wi-Fi til en mobil hotspot).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET"  => "Anbefaling: For tværs-enheds-handlinger, sørg for at begge enheder har en pålidelig internetforbindelse.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"        => "Anbefaling: Hvis tværs-enheds-handlinger fejler, prøv at besøge denne side direkte på din mobile enhed for at fuldføre handlingen.",
    "PASSKEY_INFO_TITLE"           => "Om adgangsnøgler",
    "PASSKEY_INFO_DESC"            => "Adgangsnøgler er en sikker, adgangskode-fri måde at logge ind på ved hjælp af din enheds indbyggede sikkerhedsfunktioner som fingeraftryk, ansigtsgenkendelse eller PIN. De er mere sikre end adgangskoder, giver hurtigere login, virker på tværs af enheder når synkroniseret med adgangskodemanagere, og er modstandsdygtige over for phishing-angreb. Adgangsnøgler virker på moderne smartphones, tablets, computere og kan gemmes i adgangskodemanagere som 1Password, Bitwarden, iCloud Keychain eller Google Password Manager.",
    "PASSKEY_BACK_TO_LOGIN"                      => "Tilbage til login",
));


//validation class
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"JOIN_SUC"			=> "Velkommen til ",
	"JOIN_THANKS"		=> "Tak for din registrering!",
	"JOIN_HAVE"			=> "Har i det mindste ",
	"JOIN_LOWER"		=> "Små bogstaver",
	"JOIN_SYMBOL"		=> "Et symbol",
	"JOIN_CAP"			=> "Store bogstaver",
	"JOIN_TWICE"		=> "Skrives korrekt to gange",
	"JOIN_CLOSED"		=> "Desværre er registrering ikke mulig på nuværrende tidpunkt. Kontakt venligst sidens administrator hvis du har nogle spørgsmål.",
	"JOIN_TC"				=> "Vilkår og betingelser for registrering af brugere",
	"JOIN_ACCEPTTC" => "Jeg accepterer brugervilkår og -betingelser",
	"JOIN_CHANGED"	=> "Vores vilkår har ændret sig",
	"JOIN_ACCEPT" 	=> "Accepter brugervilkår og -betingelser, og fortsæt",
	"JOIN_SCORE" => "Point:",
	"JOIN_INVALID_PW" => "Dit kodeord er ugyldigt",

));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "Succesfuldt dræbt ",
));

//Messages
$lang = array_merge($lang, array(
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

//Two Factor Authentication

$lang = array_merge($lang, array(
    "2FA"               => "To-faktor-godkendelse",
    "2FA_CONF"  => "Er du sikker på, at du vil deaktivere 2FA? Din konto vil ikke længere være beskyttet.",
    "2FA_SCAN"  => "Scan denne QR-kode med din godkendelsesapp eller indtast nøglen",
    "2FA_THEN"  => "Indtast derefter en af dine engangs-adgangskoder her",
    "2FA_FAIL"  => "Der var et problem med at verificere 2FA. Tjek venligst internet eller kontakt support.",
    "2FA_CODE"  => "2FA kode",
    "2FA_EXP"       => "Udløbet 1 fingeraftryk",
    "2FA_EXPD"  => "Udløbet",
    "2FA_EXPS"  => "Udløber",
    "2FA_ACTIVE" => "Aktive sessioner",
    "2FA_NOT_FN" => "Ingen fingeraftryk fundet",
    "2FA_FP"        => "Fingeraftryk",
    "2FA_NP"        => "Login mislykkedes - To-faktor-godkendelse kode var ikke til stede. Prøv venligst igen.",
    "2FA_INV"       => "Login mislykkedes - To-faktor-godkendelse kode var ugyldig. Prøv venligst igen.",
    "2FA_FATAL" => "Fatal fejl - Kontakt venligst systemadministrator. Vi kan ikke generere en to-faktor-godkendelse kode på dette tidspunkt.",
    "2FA_SECTION_TITLE"                    => "To-faktor-godkendelse (TOTP)",
    "2FA_SK_ALT"                          => "Hvis du ikke kan scanne QR-koden, indtast manuelt denne hemmelige nøgle i din godkendelsesapp.",
    "2FA_IS_ENABLED"                       => "To-faktor-godkendelse beskytter din konto.",
    "2FA_NOT_ENABLED_INFO"                 => "To-faktor-godkendelse er ikke aktiveret i øjeblikket.",
    "2FA_NOT_ENABLED_EXPLAIN"              => "To-faktor-godkendelse (TOTP) tilføjer et ekstra sikkerhedslag til din konto ved at kræve en kode fra en godkendelsesapp på din telefon ud over din adgangskode.",
    "2FA_SETUP_TITLE"                      => "Opsæt to-faktor-godkendelse",
    "2FA_SECRET_KEY_LABEL"                 => "Hemmelig nøgle:",
    "2FA_SETUP_VERIFY_CODE_LABEL"          => "Indtast verifikationskode fra app",
    "2FA_SUCCESS_ENABLED_TITLE"            => "To-faktor-godkendelse aktiveret! Gem dine backup-koder",
    "2FA_SUCCESS_ENABLED_INFO"             => "Nedenfor er dine backup-koder. Gem dem sikkert - hver kan kun bruges én gang.",
    "2FA_BACKUP_CODES_WARNING"             => "Behandl disse koder som adgangskoder. Gem dem sikkert.",
    "2FA_SUCCESS_BACKUP_REGENERATED"       => "Nye backup-koder genereret. Gem dem sikkert.",
    "2FA_BACKUP_CODE_LABEL"                => "Backup kode",
    "2FA_REGEN_CODES_BTN"                  => "Regenerer backup-koder",
    "2FA_INVALIDATE_WARNING"            => "Dette vil ugyldiggøre alle eksisterende backup-koder. Er du sikker?",
    "2FA_CODE_LABEL"                       => "Godkendelseskode",
    "2FA_VERIFY_BTN"                       => "Verificer og log ind",
    "2FA_VERIFY_TITLE"                     => "To-faktor-godkendelse påkrævet",
    "2FA_VERIFY_INFO"                      => "Indtast den 6-cifrede kode fra din godkendelsesapp.",
    "2FA_ENABLE_BTN"                       => "Aktiver to-faktor-godkendelse",
    "2FA_DISABLE_BTN"                       => "Deaktiver to-faktor-godkendelse",
    "2FA_VERIFY_ACTIVATE_BTN"              => "Verificer og aktiver",
    "2FA_CANCEL_SETUP_BTN"                 => "Annuller opsætning",
    "2FA_DONE_BTN"                         => "Færdig",
    "REDIR_2FA_DIS"                 => "To-faktor-godkendelse er blevet deaktiveret.",
    "2FA_SUCCESS_BACKUP_ACK"               => "Backup-koder bekræftet.",
    "2FA_SUCCESS_SETUP_CANCELLED"          => "Opsætning annulleret.",
    "2FA_ERR_INVALID_BACKUP"               => "Ugyldig backup-kode. Prøv venligst igen.",
    "2FA_ERR_DISABLE_FAILED"               => "Kunne ikke deaktivere to-faktor-godkendelse.",
    "2FA_ERR_NO_SECRET"                    => "Kunne ikke hente godkendelseshemmelighed. Prøv venligst igen.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"       => "Backup-kode verificeret men kunne ikke ugyldiggøre. Kontakt venligst support.",
    "2FA_ERR_NO_CODE_PROVIDED"             => "Ingen godkendelseskode angivet.",
    "RATE_LIMIT_LOGIN"              => "For mange mislykkede login forsøg. Vent venligst før du prøver igen.",
    "RATE_LIMIT_TOTP"               => "For mange forkerte godkendelseskoder. Vent venligst før du prøver igen.",
    "RATE_LIMIT_PASSKEY"            => "For mange adgangsnøgle godkendelsesforsøg. Vent venligst før du prøver igen.",
    "RATE_LIMIT_PASSKEY_STORE"      => "For mange adgangsnøgle registreringsforsøg. Vent venligst før du prøver igen.",
    "RATE_LIMIT_PASSWORD_RESET"     => "For mange adgangskode nulstillingsanmodninger. Vent venligst før du anmoder om en anden nulstilling.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT" => "For mange adgangskode nulstillingsforsøg. Vent venligst før du prøver igen.",
    "RATE_LIMIT_REGISTRATION"       => "For mange registreringsforsøg. Vent venligst før du prøver igen.",
    "RATE_LIMIT_EMAIL_VERIFICATION" => "For mange email verifikationsanmodninger. Vent venligst før du anmoder om en anden verifikation.",
    "RATE_LIMIT_EMAIL_CHANGE"       => "For mange email ændringsanmodninger. Vent venligst før du prøver igen.",
    "RATE_LIMIT_PASSWORD_CHANGE"    => "For mange adgangskode ændringsforsøg. Vent venligst før du prøver igen.",
    "RATE_LIMIT_GENERIC"            => "For mange forsøg. Vent venligst før du prøver igen.",
));


$lang = array_merge($lang, array(
	"REDIR_2FA"						=> "Beklager.To faktor er ikke aktiveret på dette tidspunkt",
	"REDIR_2FA_EN"				=> "2 Faktor Godkendelse Aktiveret",
	"REDIR_2FA_DIS"				=> "2 Faktor Godkendelse Deaktiveret",
	"REDIR_2FA_VER"				=> "2 Faktor Godkendelse Bekræftet og Aktiveret",
	"REDIR_SOMETHING_WRONG" => "Noget gik galt. Prøv venligst igen.",
	"REDIR_MSG_NOEX"			=> "Den tråd tilhører ikke dig eller eksisterer ikke",
	"REDIR_UN_ONCE"				=> "Brugernavnet er allerede blevet ændret en gang",
	"REDIR_EM_SUCC"				=> "Email Opdateret med succes",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "Log ind med:",
	"EML_FEATURE_DISABLED" => "Denne funktion er deaktiveret",
	"EML_PASSWORDLESS_SENT" => "Tjek venligst din e-mail for et link til at logge ind.",
	"EML_PASSWORDLESS_SUBJECT" => "Bekræft venligst din e-mail for at logge ind.",
	"EML_PASSWORDLESS_BODY" => "Bekræft venligst din e-mail-adresse ved at klikke på linket nedenfor. Du vil blive logget ind automatisk.",

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
$lang = array_merge($lang, array(
	"VER_SUC"			=> "Din e-mail er blevet bekræftet!",
	"VER_FAIL"		=> "Vi kunne ikke bekræfte din konto. Prøv venligst igen.",
	"VER_RESEND"	=> "Send bekræftelses-e-mail igen",
	"VER_AGAIN"		=> "Indtast din e-mailadresse, og prøv igen",
	"VER_PAGE"		=> "<li>Tjek din e-mail, og klik på det link, der er blevet sendt til dig</li><li>Done</li>",
	"VER_RES_SUC" => " Dit bekræftelseslink er blevet sendt til din e-mailadresse.  Klik på linket i e-mailen for at fuldføre bekræftelsen. Sørg for at tjekke din Spammappe, hvis e-mailen ikke er i din indbakke.  Bekræftelseslinks er kun gyldige i ",
	"VER_OOPS"		=> "Ups... noget gik galt, måske et gammelt nulstillingslink, du klikkede på. Klik nedenfor for at prøve igen",
	"VER_RESET"		=> "Din adgangskode er blevet nulstillet!",
	"VER_INS"			=> "<li>Indtast din e-mailadresse, og klik på Nulstil</li> <li>Tjek din e-mail, og klik på det link, der er sendt til dig.</li>
												<li>Følg vejledningen på skærmen</li>",
	"VER_SENT"		=> " Dit link til nulstilling af adgangskode er blevet sendt til din e-mailadresse. 
			    							 Klik på linket i e-mailen for at nulstille din adgangskode. Sørg for at tjekke din Spammappe, hvis e-mailen ikke er i din indbakke.  Nulstil links er kun gyldige i ",
	"VER_PLEASE"	=> "Nulstil venligst din adgangskode",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"				=> "Nulstil pinkode",
	"SET_WHY"				=> "Hvorfor kan jeg ikke ændre dette?",
	"SET_PW_MATCH"	=> "Skal matche den nye adgangskode",

	"SET_PIN_NEXT"	=> "Du kan indstille en ny pinkode, næste gang du skal bekræftes",
	"SET_UPDATE"		=> "Opdater dine brugerindstillinger",
	"SET_NOCHANGE"	=> "Administratoren har deaktiveret muligheden for ændring af brugernavne.",
	"SET_ONECHANGE"	=> "Administratoren indstillede brugernavnsændringer til kun at kunne ske én gang, og du har allerede gjort det.",

	"SET_GRAVITAR"	=> "Vil du ændre dit profilbillede?  <br> Besøg <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> og opsæt en konto med den samme e-mail, som du brugte på dette websted. Det fungerer på tværs af millioner af websteder. Det er hurtigt og nemt!",

	"SET_NOTE1"			=> " Bemærk,  at der er en afventende anmodning om at opdatere din e-mail til",

	"SET_NOTE2"			=> ".  Brug bekræftelses-e-mailen til at fuldføre denne anmodning. 
		 Hvis du har brug for en ny bekræftelses-e-mail, skal du indtaste e-mailen ovenfor igen og indsende anmodningen igen. ",

	"SET_PW_REQ" 		=> "kræves for at ændre adgangskode, e-mail eller nulstille pinkode",
	"SET_PW_REQI" 	=> "Påkrævet for at ændre din adgangskode",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "Kunne ikke afslutte aktive sessioner, Fejl:",
	"ERR_EMAIL"				=> "E-mail IKKE sendt på grund af fejl. Kontakt venligst sidens administrator.",
	"ERR_EM_DB"				=> "Denne e-mail findes ikke i vores database",
	"ERR_TC"					=> "Læs og accepter venligst vilkår og betingelser",
	"ERR_CAP"					=> "Du dumpede Captcha-testen, robot!",
	"ERR_PW_SAME"			=> "Din gamle adgangskode kan ikke være den samme som din nye",
	"ERR_PW_FAIL"			=> "Den aktuelle adgangskodebekræftelse mislykkedes. Opdateringen mislykkedes. Prøv venligst igen.",
	"ERR_GOOG"				=> "NOTE:  Hvis du oprindeligt tilmeldte dig med din Google / Facebook-konto, skal du bruge linket til Glemt adgangskode, for at ændre din adgangskode... medmindre du er rigtig god til at gætte.",
	"ERR_EM_VER"			=> "E-mailbekræftelse er ikke aktiveret. Kontakt systemadministratoren.",
	"ERR_EMAIL_STR"		=> "Noget er mærkeligt. Bekræft venligst din e-mail igen. Vi beklager ulejligheden",

));

//Maintenance Page
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
