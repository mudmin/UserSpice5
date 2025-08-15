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

//TODO contact UserSpice and ask them if they want Czech language

$lang = array();
//important strings
//You definitely want to customize these for your language
$lang = array_merge($lang, array(
	"THIS_LANGUAGE"	=> "Čeština",
	"THIS_CODE"			=> "cs-CZ",
	"MISSING_TEXT"	=> "Chybějící Text",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "Zadejte kód zaslaný na váš e-mail",
    "PASS_EMAIL_ONLY"     => "Pro přihlášení klikněte na odkaz zaslaný na váš e-mail",
    "PASS_CODE_ONLY"      => "Zadejte prosím kód zaslaný na váš e-mail",
    "PASS_BOTH"           => "Pro přihlášení klikněte na odkaz zaslaný na váš e-mail nebo zadejte kód z e-mailu",
    "PASS_VER_BUTTON"     => "Ověřit kód",
    "PASS_EMAIL_ONLY_MSG" => "Ověřte prosím svou e-mailovou adresu kliknutím na odkaz níže",
    "PASS_CODE_ONLY_MSG"  => "Pro přihlášení zadejte následující kód",
    "PASS_BOTH_MSG"       => "Ověřte prosím svoji e-mailovou adresu kliknutím na následující odkaz, nebo se přihlaste zadáním kódu",
    "PASS_YOUR_CODE"      => "Váš ověřovací kód je: ",
    "PASS_CONFIRM_LOGIN"  => "Potvrdit přihlášení",
    "PASS_CONFIRM_CLICK"  => "Klikněte pro dokončení přihlášení",
    "PASS_GENERIC_ERROR"  => "Něco se pokazilo",
));

//Database Menus
$lang = array_merge($lang, array(
	"MENU_HOME"			=> "Domů",
	"MENU_HELP"			=> "Pomoc",
	"MENU_ACCOUNT"	=> "Účet",
	"MENU_DASH"			=> "Menu admina",
	"MENU_USER_MGR"	=> "Správa uživatelů",
	"MENU_PAGE_MGR"	=> "Správa stránek",
	"MENU_PERM_MGR"	=> "Správa povolení",
	"MENU_MSGS_MGR"	=> "Správa zpráv",
	"MENU_LOGS_MGR"	=> "Systémové logy",
	"MENU_LOGOUT"		=> "Odhlásit se",
));

// Signup
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"					=> "Registrovat",
	"SIGNUP_BUTTONTEXT"		=> "Registujte mě",
	"SIGNUP_AUDITTEXT"		=> "Registrováno",
));

// Signin
$lang = array_merge($lang, array(
	"SIGNIN_FAIL"				=> "** Přihlášení selhalo **",
	"SIGNIN_PLEASE_CHK" => "Prosím, zkontrolujte své uživatelské jméno a heslo a zkuste to znovu",
	"SIGNIN_UORE"				=> "Uživatelské jméno nebo email",
	"SIGNIN_PASS"				=> "Heslo",
	"SIGNIN_TITLE"			=> "Prosím, přihlaste se",
	"SIGNIN_TEXT"				=> "Přihlásit se",
	"SIGNOUT_TEXT"			=> "Odhlásit se",
	"SIGNIN_BUTTONTEXT"	=> "Přihlásit se",
	"SIGNIN_REMEMBER"		=> "Zapamatovat si mě",
	"SIGNIN_AUDITTEXT"	=> "Přihlášen",
	"SIGNIN_FORGOTPASS"	=> "Zapomenuté heslo",
	"SIGNOUT_AUDITTEXT"	=> "Odhlášen",
));

// Account Page
$lang = array_merge($lang, array(
	"ACCT_EDIT"					=> "Editovat informace o účtu",
	"ACCT_2FA"					=> "Spravovat dvoufaktorovou autentizaci",
	"ACCT_SESS"					=> "Spravovat relace",
	"ACCT_HOME"					=> "Account Home",
	"ACCT_SINCE"				=> "Členem od",
	"ACCT_LOGINS"				=> "Počet přihlášení",
	"ACCT_SESSIONS"			=> "Počet aktivních relací",
	"ACCT_MNG_SES"			=> "Pro více informací klikněte na tlačítko spravovat relace v levém menu.",
));

//General Terms
$lang = array_merge($lang, array(
	"GEN_ENABLED"			=> "Povoleno",
	"GEN_DISABLED"		=> "Zakázáno",
	"GEN_ENABLE"			=> "Povolit",
	"GEN_DISABLE"			=> "Zakázat",
	"GEN_NO"					=> "Ne",
	"GEN_YES"					=> "Ano",
	"GEN_MIN"					=> "minimálně",
	"GEN_MAX"					=> "maximálně",
	"GEN_CHAR"				=> "znaků", //as in characters
	"GEN_SUBMIT"			=> "Odeslat",
	"GEN_MANAGE"			=> "Spravovat",
	"GEN_VERIFY"			=> "Ověřit",
	"GEN_SESSION"			=> "Relace",
	"GEN_SESSIONS"		=> "Relace",
	"GEN_EMAIL"				=> "Email",
	"GEN_FNAME"				=> "Křestní jméno",
	"GEN_LNAME"				=> "Příjmení",
	"GEN_UNAME"				=> "Uživatelské jméno",
	"GEN_PASS"				=> "Heslo",
	"GEN_MSG"					=> "Zpráva",
	"GEN_TODAY"				=> "Dnes",
	"GEN_CLOSE"				=> "Zavřít",
	"GEN_CANCEL"			=> "Zrušit",
	"GEN_CHECK"				=> "[ check/uncheck all ]",
	"GEN_WITH"				=> "s",
	"GEN_UPDATED"			=> "Aktualizováno",
	"GEN_UPDATE"			=> "Aktualizovat",
	"GEN_BY"					=> "do",
	//"GEN_ENABLE"			=> "Enable",
	//"GEN_DISABLE"			=> "Disable",
	"GEN_FUNCTIONS"		=> "Funkce",
	"GEN_NUMBER"			=> "číslo",
	"GEN_NUMBERS"			=> "čísla",
	"GEN_INFO"				=> "Informace",
	"GEN_REC"					=> "Zaznamenáno", //TODO kontext?
	"GEN_DEL"					=> "Smazat",
	"GEN_NOT_AVAIL"		=> "Nedostupný", //TODO rod?
	"GEN_AVAIL"				=> "Dostupný",
	"GEN_BACK"				=> "Zpět",
	"GEN_RESET"				=> "Resetovat",
	"GEN_REQ"					=> "vyžadováno",
	"GEN_AND"					=> "a",
	"GEN_SAME"				=> "musí se shodovat",
));
//added during passkey/totp update
$lang = array_merge($lang, array(
    "GEN_PASSKEY"                         => "Přístupový klíč",
    "GEN_ACTIONS"                         => "Akce",
    "GEN_BACK_TO_ACCT"                    => "Zpět na účet",
    "GEN_DB_ERROR"                        => "Došlo k chybě databáze. Zkuste to prosím znovu.",
    "GEN_IMPORTANT"                       => "Důležité",
    "GEN_NO_PERMISSIONS"                  => "Nemáte oprávnění k přístupu na tuto stránku.",
    "GEN_NO_PERMISSIONS_MSG"              => "Nemáte oprávnění k přístupu na tuto stránku. Pokud si myslíte, že se jedná o chybu, kontaktujte prosím správce webu.",
    "PASSKEYS_MANAGE_TITLE"               => "Správa vašich přístupových klíčů",
    "PASSKEYS_LOGIN_TITLE"                => "Přihlášení pomocí přístupového klíče",
    "PASSKEY_DELETE_SUCCESS"              => "Přístupový klíč byl úspěšně smazán.",
    "PASSKEY_DELETE_FAIL_DB"              => "Nepodařilo se smazat přístupový klíč z databáze.",
    "PASSKEY_DELETE_NOT_FOUND"            => "Přístupový klíč nebyl nalezen nebo nemáte oprávnění jej smazat.",
    "PASSKEY_NOTE_UPDATE_SUCCESS"         => "Poznámka k přístupovému klíči byla úspěšně aktualizována.",
    "PASSKEY_NOTE_UPDATE_FAIL"            => "Nepodařilo se aktualizovat poznámku k přístupovému klíči.",
    "PASSKEY_REGISTER_NEW"                => "Registrovat nový přístupový klíč",
    "PASSKEY_ERR_LIMIT_REACHED"           => "Dosáhli jste maximálního počtu 10 přístupových klíčů.",
    "PASSKEY_NOTE_TH"                     => "Poznámka k přístupovému klíči",
    "PASSKEY_TIMES_USED_TH"               => "Počet použití",
    "PASSKEY_LAST_USED_TH"                => "Naposledy použito",
    "PASSKEY_LAST_IP_TH"                  => "Poslední IP adresa",
    "PASSKEY_EDIT_NOTE_BTN"               => "Upravit poznámku",
    "PASSKEY_CONFIRM_DELETE_JS"           => "Opravdu chcete smazat tento přístupový klíč?",
    "PASSKEY_EDIT_MODAL_TITLE"            => "Upravit poznámku k přístupovému klíči",
    "PASSKEY_EDIT_MODAL_LABEL"            => "Poznámka k přístupovému klíči",
    "PASSKEY_SAVE_CHANGES_BTN"            => "Uložit změny",
    "PASSKEY_NONE_REGISTERED"             => "Zatím nemáte zaregistrované žádné přístupové klíče.",
    "PASSKEY_MUST_REGISTER_FIRST"         => "Než budete moci použít tuto funkci, musíte nejprve zaregistrovat přístupový klíč z ověřeného účtu.",
    "PASSKEY_STORING"                     => "Ukládání přístupového klíče...",
    "PASSKEY_STORED_SUCCESS"              => "Přístupový klíč byl úspěšně uložen!",
    "PASSKEY_INVALID_ACTION"              => "Neplatná akce: ",
    "PASSKEY_NO_ACTION_SPECIFIED"         => "Nebyla zadána žádná akce",
    "PASSKEY_ERR_NETWORK_SUGGESTION"      => "Byl zjištěn problém se sítí. Zkuste jinou síť nebo obnovte stránku.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "Bylo zjištěno ověření mezi zařízeními. Ujistěte se, že obě zařízení mají přístup k internetu.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "Zkuste místo toho otevřít tuto stránku přímo ve svém telefonu.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"       => "Nepodařilo se vygenerovat diagnostiku: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"     => "Chybí požadované přihlašovací údaje pro uložení.",
    "PASSKEY_MISSING_AUTH_DATA"           => "Chybí požadované ověřovací údaje.",
    "PASSKEY_LOG_NO_MESSAGE"              => "Žádná zpráva",
    "PASSKEY_USER_NOT_FOUND"              => "Uživatel po ověření přístupového klíče nebyl nalezen.",
    "PASSKEY_FATAL_ERROR"                 => "Fatální chyba: ",
    "PASSKEY_LOGIN_SUCCESS"               => "Přihlášení proběhlo úspěšně.",
    // JavaScript status messages (passkeys.php)
    "PASSKEY_CROSS_DEVICE_PREP"           => "Příprava na registraci mezi zařízeními. Možná budete muset použít svůj telefon nebo tablet.",
    "PASSKEY_DEVICE_REGISTRATION"         => "Používání registrace přístupového klíče zařízení...",
    "PASSKEY_STARTING_REGISTRATION"       => "Zahajování registrace přístupového klíče...",
    "PASSKEY_REQUEST_OPTIONS"             => "Žádost o možnosti registrace ze serveru...",
    "PASSKEY_FOLLOW_PROMPTS"              => "Postupujte podle pokynů a vytvořte si přístupový klíč. Možná budete muset použít jiné zařízení.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"       => "Postupujte podle pokynů a vytvořte si přístupový klíč...",
    "PASSKEY_CREATION_FAILED"             => "Vytvoření přístupového klíče se nezdařilo - nebyly vráceny žádné přihlašovací údaje.",
    "PASSKEY_STORING_SERVER"              => "Ukládání vašeho přístupového klíče...",
    "PASSKEY_CREATED_SUCCESS"             => "Přístupový klíč byl úspěšně vytvořen!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP"      => "Příprava na ověření mezi zařízeními. Ujistěte se, že váš telefon i počítač mají přístup k internetu.",
    "PASSKEY_DEVICE_AUTH"                 => "Používání ověření přístupovým klíčem zařízení...",
    "PASSKEY_STARTING_AUTH"               => "Zahajování ověření přístupovým klíčem...",
    "PASSKEY_QR_CODE_INSTRUCTION"         => "Až se objeví QR kód, naskenujte jej telefonem. Ujistěte se, že obě zařízení mají přístup k internetu.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"    => "Na výzvu vyberte „Použít telefon nebo tablet“ a poté naskenujte QR kód.",
    "PASSKEY_AUTHENTICATING"              => "Ověřování pomocí vašeho přístupového klíče...",
    "PASSKEY_SUCCESS_REDIRECTING"         => "Ověření proběhlo úspěšně! Přesměrovávání...",
    // Timeout messages
    "PASSKEY_TIMEOUT_CROSS_DEVICE"        => "Časový limit registrace vypršel. Pro registraci mezi zařízeními: 1) Zkuste to znovu, 2) Ujistěte se, že zařízení mají internet, 3) Zvažte registraci přímo v telefonu.",
    "PASSKEY_TIMEOUT_SIMPLE"              => "Časový limit registrace vypršel. Zkuste to prosím znovu.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"   => "Časový limit ověření mezi zařízeními vypršel. Řešení problémů: 1) Obě zařízení potřebují internet, 2) Zkuste QR kód naskenovat rychleji, 3) Zvažte použití stejného zařízení, 4) Některé sítě blokují ověření mezi zařízeními.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"         => "Časový limit ověření vypršel. Zkuste to prosím znovu.",
    "PASSKEY_NO_CREDENTIAL"               => "Nebyly přijaty žádné přihlašovací údaje. Opakuji pokus...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"   => "Ověření se nezdařilo - nebyly vráceny žádné přihlašovací údaje.",
    "PASSKEY_ATTEMPT_RETRY"               => "se nezdařilo. Opakuji pokus... (zbývá %d pokusů)",
    // Error messages
    "PASSKEY_CROSS_DEVICE_FAILED"         => "Registrace mezi zařízeními se nezdařila. Zkuste: 1) Ujistit se, že obě zařízení mají internet, 2) Zvážit registraci přímo v telefonu, 3) Některé firemní sítě tuto funkci blokují.",
    "PASSKEY_REGISTRATION_CANCELLED"      => "Registrace byla zrušena nebo zařízení nepodporuje přístupové klíče.",
    "PASSKEY_NOT_SUPPORTED"               => "Přístupové klíče nejsou na této kombinaci zařízení/prohlížeče podporovány.",
    "PASSKEY_SECURITY_ERROR"              => "Bezpečnostní chyba - obvykle to značí neshodu domény/původu.",
    "PASSKEY_ALREADY_EXISTS"              => "Na tomto zařízení již existuje přístupový klíč pro tento účet. Zkuste jiné zařízení nebo nejprve smažte stávající přístupové klíče.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"    => "Ověření mezi zařízeními se nezdařilo. Zkuste: 1) Ujistit se, že obě zařízení mají stabilní internet, 2) Pokud je to možné, použít stejnou Wi-Fi síť, 3) Zkusit ověření přímo v telefonu, 4) Některé firemní sítě tuto funkci blokují.",
    "PASSKEY_AUTH_CANCELLED"              => "Ověření bylo zrušeno nebo nebyl vybrán žádný přístupový klíč.",
    "PASSKEY_NETWORK_ERROR"               => "Chyba sítě. Pro ověření mezi zařízeními potřebují obě zařízení přístup k internetu a mohou být vyžadována ve stejné síti.",
    "PASSKEY_CREDENTIAL_NOT_FOUND"        => "Ověření se nezdařilo - přihlašovací údaje nebyly rozpoznány.",
    // Cross-device guidance
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "Tipy pro ověření mezi zařízeními:",
    "PASSKEY_GUIDANCE_INTERNET"           => "Ujistěte se, že váš počítač i telefon mají přístup k internetu",
    "PASSKEY_GUIDANCE_WIFI"               => "Být na stejné Wi-Fi síti může pomoci (ale není to vždy nutné)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"      => "Na výzvu vyberte „Použít telefon nebo tablet“",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"       => "Až se objeví QR kód, rychle jej naskenujte",
    "PASSKEY_GUIDANCE_TRY_DIRECT"         => "Pokud se to nepodaří, zkuste obnovit stránku a použít přímo prohlížeč telefonu",
    // Troubleshooting
    "PASSKEY_SHOW_TROUBLESHOOTING"        => "Zobrazit tipy pro odstraňování potíží",
    "PASSKEY_HIDE_TROUBLESHOOTING"        => "Skrýt tipy pro odstraňování potíží",
    "PASSKEY_DIAGNOSTICS_RUNNING"         => "Spouštění diagnostiky...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"        => "Diagnostika dokončena. Podrobnosti naleznete v konzoli.",
    "PASSKEY_ISSUES_DETECTED"             => "Zjištěné problémy:",
    "PASSKEY_ENVIRONMENT_SUITABLE"        => "Prostředí se zdá být vhodné pro přístupové klíče.",
    "PASSKEY_DIAGNOSTICS_FAILED"          => "Diagnostika se nezdařila:",
    // Modal
    "PASSKEY_ADD_NOTE_NEW"                => "Přidat poznámku k novému přístupovému klíči",
    // Technical errors
    "PASSKEY_BASE64_ERROR"                => "Chyba při dekódování Base64:",
    // Server-side errors (passkey_parser.php)
    "PASSKEY_INVALID_JSON"                => "Byla přijata neplatná data JSON:",
    // Session/validation errors (PasskeyHandler.php)
    "PASSKEY_NO_CHALLENGE_SESSION"        => "V relaci nebyla nalezena žádná výzva k registraci přístupového klíče. Zkuste se prosím zaregistrovat znovu.",
    "PASSKEY_USER_MISMATCH"               => "Neshoda ID uživatele. Zkuste se prosím zaregistrovat znovu.",
    "PASSKEY_CHALLENGE_USER_MISMATCH"     => "ID uživatele v možnostech výzvy neodpovídá aktuálnímu uživateli. Zkuste se prosím zaregistrovat znovu.",
    "PASSKEY_REGISTRATION_FAILED_ERROR"   => "Registrace přístupového klíče se nezdařila. Ujistěte se prosím, že vaše zařízení a prohlížeč podporují WebAuthn, a zkuste to znovu. Chyba:",
    "PASSKEY_NO_AUTH_CHALLENGE_SESSION"   => "V relaci nebyla nalezena žádná výzva k ověření přístupového klíče. Zkuste se prosím přihlásit znovu.",
    "PASSKEY_CREDENTIAL_NOT_IN_DB"        => "Přihlašovací údaje přístupového klíče nebyly nalezeny v databázi.",
    "PASSKEY_CREDENTIAL_WRONG_USER"       => "Přihlašovací údaje přístupového klíče nepatří očekávanému uživateli.",
    "PASSKEY_VALIDATION_FAILED_ERROR"     => "Ověření přístupového klíče se nezdařilo. Zkuste to prosím znovu, nebo pokud problém přetrvává, kontaktujte podporu. Chyba:",
    "PASSKEY_USER_NOT_FOUND_REGISTRATION" => "Uživatel pro registraci nebyl nalezen.",
    // --- Used in passkey_parser.php ---
    "PASSKEY_LOGIN_REQUIRED"              => "K provedení této akce musíte být přihlášeni.",
    "PASSKEY_ACTION_MISSING"              => "Požadovaný parametr 'action' v požadavku chyběl.",
    "PASSKEY_STORAGE_FAILED"              => "Uložení přístupového klíče se nezdařilo. Operace byla neúspěšná.",
    "PASSKEY_LOGIN_FAILED"                => "Přihlášení pomocí přístupového klíče se nezdařilo. Ověření nebylo možné ověřit.",
    "PASSKEY_INVALID_METHOD"              => "Neplatná metoda požadavku:", // The script appends the method name after this key
    // --- Used in passkeys.php ---
    "CSRF_ERROR"                          => "Kontrola CSRF tokenu selhala. Vraťte se prosím zpět a zkuste formulář odeslat znovu.",
    // Network analysis from analyzeNetworkConditions()
    "PASSKEY_NETWORK_PRIVATE"             => "Možný problém: Zdá se, že jste v soukromé síti, což může někdy rušit komunikaci mezi zařízeními.",
    "PASSKEY_NETWORK_PROXY"               => "Možný problém: Byl zjištěn proxy server nebo VPN. To může rušit komunikaci mezi zařízeními.",
    "PASSKEY_NETWORK_MOBILE"              => "Poznámka: Zdá se, že jste v mobilní síti. Zajistěte stabilní připojení pro operace mezi zařízeními.",
    "PASSKEY_NETWORK_CORPORATE"           => "Možný problém: Může být aktivní firemní firewall, což by mohlo ovlivnit ověření mezi zařízeními.",
    // Recommendations from getCrossDeviceRecommendations()
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "Doporučení: Pravděpodobně používáte stolní počítač. Připravte se na použití telefonu k naskenování QR kódu.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "Doporučení: Pro nejlepší výsledky se ujistěte, že váš počítač a mobilní zařízení jsou ve stejné Wi-Fi síti.",
    "PASSKEY_RECOMMENDATION_QR_QUICK"     => "Doporučení: Buďte připraveni rychle naskenovat QR kód, protože požadavek může vypršet.",
    "PASSKEY_RECOMMENDATION_INTERNET"     => "Doporučení: Ujistěte se, že váš počítač i mobilní zařízení mají stabilní připojení k internetu.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "Doporučení: U Unity WebViews se ujistěte, že stránka má dostatek času na načtení a zpracování požadavku na přístupový klíč.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "Doporučení: V Unity mohou být časové limity delší. Buďte prosím trpěliví.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "Doporučení: Jelikož jste na mobilním zařízení, měli byste být schopni zaregistrovat přístupový klíč přímo na tomto zařízení.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Doporučení: Na Androidu můžete své přístupové klíče spravovat ve Správci hesel Google.",
    // Validation from validateCrossDeviceEnvironment()
    "PASSKEY_VALIDATION_RP_IP"            => "Upozornění na konfiguraci: ID spoléhající se strany (Relying Party ID) je nastaveno na IP adresu.",
    "PASSKEY_VALIDATION_RP_DOMAIN"        => "Doporučení: Pro lepší bezpečnost a kompatibilitu nastavte ID spoléhající se strany na název vaší domény (např. vasestranka.cz).",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"   => "Chyba konfigurace: Pro fungování přístupových klíčů na živém serveru je vyžadován HTTPS. Zdá se, že vaše stránka běží na HTTP.",
    "PASSKEY_VALIDATION_NETWORK"          => "Upozornění sítě", // Generic prefix for network issues
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "Doporučení: Pokud narazíte na problémy, zkuste jinou síť (např. přejděte z firemní Wi-Fi na mobilní hotspot).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "Doporučení: Pro akce mezi zařízeními se ujistěte, že obě zařízení mají spolehlivé připojení k internetu.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"  => "Doporučení: Pokud akce mezi zařízeními selžou, zkuste navštívit tuto stránku přímo na svém mobilním zařízení a dokončit akci.",
    "PASSKEY_INFO_TITLE"                  => "O přístupových klíčích",
    "PASSKEY_INFO_DESC"                   => "Přístupové klíče jsou bezpečný způsob přihlašování bez hesla, který využívá vestavěné bezpečnostní funkce vašeho zařízení, jako je otisk prstu, rozpoznávání obličeje nebo PIN. Jsou bezpečnější než hesla, poskytují rychlejší přihlášení, fungují napříč zařízeními, pokud jsou synchronizovány se správci hesel, a jsou odolné proti phishingovým útokům. Přístupové klíče fungují na moderních smartphonech, tabletech, počítačích a lze je ukládat do správců hesel, jako jsou 1Password, Bitwarden, Klíčenka na iCloudu nebo Správce hesel Google.",
    "PASSKEY_BACK_TO_LOGIN"               => "Zpět na přihlášení",
));

//validation class
$lang = array_merge($lang, array(
	"VAL_SAME"				=> "se musí shodovat",
	"VAL_EXISTS"			=> "již existuje. Prosím, vyberte jiné",
	"VAL_DB"					=> "Database Error",
	"VAL_NUM"					=> "musí být číslo",
	"VAL_INT"					=> "musí být celé číslo",
	"VAL_EMAIL"				=> "musí být validní emailová adresa",
	"VAL_NO_EMAIL"		=> "nesmí být emailová adresa",
	"VAL_SERVER"			=> "musí patřit existujícímu serveru",
	"VAL_LESS"				=> "musí být menší než",
	"VAL_GREAT"				=> "musí být větší než",
	"VAL_LESS_EQ"			=> "musí být menší nebo rovno",
	"VAL_GREAT_EQ"		=> "musí být větší nebo rovno",
	"VAL_NOT_EQ"			=> "nesmí se rovnat",
	"VAL_EQ"					=> "musí se rovnat",
	"VAL_TZ"					=> "musí být validní časová zóna",
	"VAL_MUST"				=> "musí být",
	"VAL_MUST_LIST"		=> "musí být jedno z následujících",
	"VAL_TIME"				=> "musí být validní čas",
	"VAL_SEL"					=> "není validní možnost",
	"VAL_NA_PHONE"		=> "musí být validní české telefonní číslo",
));

//Time
$lang = array_merge($lang, array(
	"T_YEARS"			=> "roků",
	"T_YEAR"			=> "rok",
	"T_MONTHS"		=> "měsíců",
	"T_MONTH"			=> "měsíc",
	"T_WEEKS"			=> "týdnů",
	"T_WEEK"			=> "týden",
	"T_DAYS"			=> "dní",
	"T_DAY"				=> "den",
	"T_HOURS"			=> "hodin",
	"T_HOUR"			=> "hodinu",
	"T_MINUTES"		=> "minut",
	"T_MINUTE"		=> "minutu",
	"T_SECONDS"		=> "sekund",
	"T_SECOND"		=> "sekundu",
));


//Passwords
$lang = array_merge($lang, array(
	"PW_NEW"		=> "Nové heslo",
	"PW_OLD"		=> "Staré heslo",
	"PW_CONF"		=> "Potvrdit heslo",
	"PW_RESET"	=> "Resetovat heslo",
	"PW_UPD"		=> "Heslo aktualizováno",
	"PW_SHOULD"	=> "Heslo by mělo...",
	"PW_SHOW"		=> "Ukázat heslo",
	"PW_SHOWS"	=> "Ukázat hesla",
));


//Join
$lang = array_merge($lang, array(
	"JOIN_SUC"			=> "Vítejte na webu ",
	"JOIN_THANKS"		=> "Děkujeme za registraci!",
	"JOIN_HAVE"			=> "Mít alespoň ",
	"JOIN_LOWER"		=> " malé písmeno",
	"JOIN_SYMBOL"		=> " speciální znak",
	"JOIN_CAP"			=> " velké písmeno",
	"JOIN_TWICE"		=> "být dvakrát správně napsáno",
	"JOIN_CLOSED"		=> "Bohužel, registrace je nyní vypnutá. Pokud máte jakékoliv dotazy, kontaktujte prosím administrátora stránky.",
	"JOIN_TC"				=> "Podmínky použití",
	"JOIN_ACCEPTTC" => "Souhlasím s podmínkami použití",
	"JOIN_CHANGED"	=> "Naše podmínky se změnily",
	"JOIN_ACCEPT" 	=> "Souhlasit s podmínkami použití a pokračovat",
	"JOIN_SCORE" => "Skóre:",
	"JOIN_INVALID_PW" => "Vaše heslo je neplatné",

));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "Úspěšně ukončeno ",
));

//Messages
$lang = array_merge($lang, array(
	"MSG_SENT"			=> "Vaše zpráva byla odeslána!",
	"MSG_MASS"			=> "Vaše hromadná zpráva byla odeslána!",
	"MSG_NEW"				=> "Nová zpráva",
	"MSG_NEW_MASS"	=> "Nová hromadná zpráva",
	"MSG_CONV"			=> "Konverzace",
	"MSG_NO_CONV"		=> "Žádná konverzace",
	"MSG_NO_ARC"		=> "Žádné konverzace",
	"MSG_QUEST"			=> "Pokud je povoleno, poslat upozornění emailem?",
	"MSG_ARC"				=> "Archivovaná vlákna",
	"MSG_VIEW_ARC"	=> "Zobrazit archivovaná vlákna",
	"MSG_SETTINGS"  => "Nastavení zpráv",
	"MSG_READ"			=> "Přečteno", //TODO
	"MSG_BODY"			=> "Tělo",
	"MSG_SUB"				=> "Předmět",
	"MSG_DEL"				=> "Doručeno",
	"MSG_REPLY"			=> "Odpovědět",
	"MSG_QUICK"			=> "Rychlá odpověď",
	"MSG_SELECT"		=> "Vybrat uživatele",
	"MSG_UNKN"			=> "Neznámý příjemce",
	"MSG_NOTIF"			=> "Message Email Notifications", // TODO kontext?
	"MSG_BLANK"			=> "Zpráva nemůže být prázdná",
	"MSG_MODAL"			=> "Klikněte zde nebo stiskněte Alt + R pro zaměření tohoto pole nebo stiskněte Shift + R pro otevření odpovědního menu",
	"MSG_ARCHIVE_SUCCESSFUL"        => "Úspěšně jste zarchivovali %m1% vláken",
	"MSG_UNARCHIVE_SUCCESSFUL"      => "Úspěšně jste odarchivovali %m1% vláken",
	"MSG_DELETE_SUCCESSFUL"         => "Úspěšně jste smazali %m1% vláken",
	"USER_MESSAGE_EXEMPT"         			=> "User is %m1% exempted from messages.", // TODO?
	"MSG_MK_READ"		=> "Označit za přečtené",
	"MSG_MK_UNREAD"	=> "Označit za nepřečtené",
	"MSG_ARC_THR"		=> "Archivovat vybraná vlákna",
	"MSG_UN_THR"		=> "Odarchivovat vybraná vlákna",
	"MSG_DEL_THR"		=> "Smazat vybraná vlákna",
	"MSG_SEND"			=> "Odeslat zprávu",
));

//Two Factor Authentication
$lang = array_merge($lang, array(
    "2FA"                                => "Dvoufaktorové ověření",
    "2FA_CONF"                           => "Opravdu chcete vypnout dvoufaktorové ověření? Váš účet již nebude chráněn.",
    "2FA_SCAN"                           => "Naskenujte tento QR kód vaší ověřovací aplikací nebo zadejte klíč",
    "2FA_THEN"                           => "Poté sem zadejte jeden ze svých jednorázových kódů",
    "2FA_FAIL"                           => "Při ověřování dvoufaktorového ověření došlo k problému. Zkontrolujte prosím internet nebo kontaktujte podporu.",
    "2FA_CODE"                           => "2FA kód",
    "2FA_EXP"                            => "Platnost 1 otisku prstu vypršela",
    "2FA_EXPD"                           => "Vypršelo",
    "2FA_EXPS"                           => "Vyprší",
    "2FA_ACTIVE"                         => "Aktivní relace",
    "2FA_NOT_FN"                         => "Nebyly nalezeny žádné otisky prstů",
    "2FA_FP"                             => "Otisky prstů",
    "2FA_NP"                             => "Přihlášení se nezdařilo - kód dvoufaktorového ověření chyběl. Zkuste to prosím znovu.",
    "2FA_INV"                            => "Přihlášení se nezdařilo - kód dvoufaktorového ověření byl neplatný. Zkuste to prosím znovu.",
    "2FA_FATAL"                          => "Fatální chyba - kontaktujte prosím systémového administrátora. V tuto chvíli nemůžeme vygenerovat kód dvoufaktorového ověření.",
    "2FA_SECTION_TITLE"                  => "Dvoufaktorové ověření (TOTP)",
    "2FA_SK_ALT"                         => "Pokud nemůžete naskenovat QR kód, zadejte tento tajný klíč do své ověřovací aplikace ručně.",
    "2FA_IS_ENABLED"                     => "Dvoufaktorové ověření chrání váš účet.",
    "2FA_NOT_ENABLED_INFO"               => "Dvoufaktorové ověření není v současné době povoleno.",
    "2FA_NOT_ENABLED_EXPLAIN"            => "Dvoufaktorové ověření (TOTP) přidává vašemu účtu další vrstvu zabezpečení tím, že kromě hesla vyžaduje kód z ověřovací aplikace ve vašem telefonu.",
    // Setup Process
    "2FA_SETUP_TITLE"                    => "Nastavení dvoufaktorového ověření",
    "2FA_SECRET_KEY_LABEL"               => "Tajný klíč:",
    "2FA_SETUP_VERIFY_CODE_LABEL"        => "Zadejte ověřovací kód z aplikace",
    // Backup Codes
    "2FA_SUCCESS_ENABLED_TITLE"          => "Dvoufaktorové ověření povoleno! Uložte si záložní kódy",
    "2FA_SUCCESS_ENABLED_INFO"           => "Níže jsou vaše záložní kódy. Uložte je na bezpečné místo - každý lze použít pouze jednou.",
    "2FA_BACKUP_CODES_WARNING"           => "S těmito kódy zacházejte jako s hesly. Uložte je na bezpečné místo.",
    "2FA_SUCCESS_BACKUP_REGENERATED"     => "Byly vygenerovány nové záložní kódy. Uložte je na bezpečné místo.",
    "2FA_BACKUP_CODE_LABEL"              => "Záložní kód",
    "2FA_REGEN_CODES_BTN"                => "Znovu vygenerovat záložní kódy",
    "2FA_INVALIDATE_WARNING"             => "Tímto zneplatníte všechny stávající záložní kódy. Jste si jisti?",
    // Authentication
    "2FA_CODE_LABEL"                     => "Ověřovací kód",
    "2FA_VERIFY_BTN"                     => "Ověřit a přihlásit se",
    "2FA_VERIFY_TITLE"                   => "Je vyžadováno dvoufaktorové ověření",
    "2FA_VERIFY_INFO"                    => "Zadejte 6místný kód z vaší ověřovací aplikace.",
    // Actions & Buttons
    "2FA_ENABLE_BTN"                     => "Povolit dvoufaktorové ověření",
    "2FA_DISABLE_BTN"                    => "Vypnout dvoufaktorové ověření",
    "2FA_VERIFY_ACTIVATE_BTN"            => "Ověřit a aktivovat",
    "2FA_CANCEL_SETUP_BTN"               => "Zrušit nastavení",
    "2FA_DONE_BTN"                       => "Hotovo",
    // Success Messages
    "REDIR_2FA_DIS"                      => "Dvoufaktorové ověření bylo vypnuto.",
    "2FA_SUCCESS_BACKUP_ACK"             => "Záložní kódy byly potvrzeny.",
    "2FA_SUCCESS_SETUP_CANCELLED"        => "Nastavení bylo zrušeno.",
    // Error Messages
    "2FA_ERR_INVALID_BACKUP"             => "Neplatný záložní kód. Zkuste to prosím znovu.",
    "2FA_ERR_DISABLE_FAILED"             => "Nepodařilo se vypnout dvoufaktorové ověření.",
    "2FA_ERR_NO_SECRET"                  => "Nepodařilo se získat ověřovací tajemství. Zkuste to prosím znovu.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"     => "Záložní kód byl ověřen, ale nepodařilo se jej zneplatnit. Kontaktujte prosím podporu.",
    "2FA_ERR_NO_CODE_PROVIDED"           => "Nebyl poskytnut žádný ověřovací kód.",
    "RATE_LIMIT_LOGIN"                   => "Příliš mnoho neúspěšných pokusů o přihlášení. Počkejte prosím, než to zkusíte znovu.",
    "RATE_LIMIT_TOTP"                    => "Příliš mnoho nesprávných ověřovacích kódů. Počkejte prosím, než to zkusíte znovu.",
    "RATE_LIMIT_PASSKEY"                 => "Příliš mnoho pokusů o ověření přístupovým klíčem. Počkejte prosím, než to zkusíte znovu.",
    "RATE_LIMIT_PASSKEY_STORE"           => "Příliš mnoho pokusů o registraci přístupového klíče. Počkejte prosím, než to zkusíte znovu.",
    "RATE_LIMIT_PASSWORD_RESET"          => "Příliš mnoho žádostí o resetování hesla. Počkejte prosím, než požádáte o další reset.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT"   => "Příliš mnoho pokusů o resetování hesla. Počkejte prosím, než to zkusíte znovu.",
    "RATE_LIMIT_REGISTRATION"            => "Příliš mnoho pokusů o registraci. Počkejte prosím, než to zkusíte znovu.",
    "RATE_LIMIT_EMAIL_VERIFICATION"      => "Příliš mnoho žádostí o ověření e-mailu. Počkejte prosím, než požádáte o další ověření.",
    "RATE_LIMIT_EMAIL_CHANGE"            => "Příliš mnoho žádostí o změnu e-mailu. Počkejte prosím, než to zkusíte znovu.",
    "RATE_LIMIT_PASSWORD_CHANGE"         => "Příliš mnoho pokusů o změnu hesla. Počkejte prosím, než to zkusíte znovu.",
    "RATE_LIMIT_GENERIC"                 => "Příliš mnoho pokusů. Počkejte prosím, než to zkusíte znovu.",
));


$lang = array_merge($lang, array(
	"REDIR_2FA"						=> "Omlouváme se.Dvoufaktorová autentizace není nyní dostupná.",
	"REDIR_2FA_EN"				=> "Dvoufaktorová autentizace povolena",
	"REDIR_2FA_DIS"				=> "Dvoufaktorová autentizace zakázána",
	"REDIR_2FA_VER"				=> "Dvoufaktorová autentizace ověřena a povolena",
	"REDIR_SOMETHING_WRONG" => "Něco se nepodařilo. Prosím, zkuste to znovu.",
	"REDIR_MSG_NOEX"			=> "Toto vlákno neexistuje nebo Vám nepatří.",
	"REDIR_UN_ONCE"				=> "Uživatelské jméno již bylo jednou změněno.",
	"REDIR_EM_SUCC"				=> "Email úspěšně zaktualizován",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "Přihlásit se pomocí:",
	"EML_FEATURE_DISABLED" => "Tato funkce je zakázána",
	"EML_PASSWORDLESS_SENT" => "Prosím, zkontrolujte si svůj e-mail pro odkaz k přihlášení.",
	"EML_PASSWORDLESS_SUBJECT" => "Prosím, ověřte svůj e-mail pro přihlášení.",
	"EML_PASSWORDLESS_BODY" => "Prosím, ověřte svou e-mailovou adresu kliknutím na níže uvedený odkaz. Budete automaticky přihlášeni.",

	"EML_CONF"			=> "Potvrdit Email",
	"EML_VER"				=> "Ověřit svůj Email",
	"EML_CHK"				=> "Požadavek odeslán. Pro ověření prosím zkontrolujte svůj email. Zkontrolujte také spam složku, neboť platnost ověrovacího odkazu vyprší za ",
	"EML_MAT"				=> "Váš email se neshoduje.",
	"EML_HELLO"			=> "Dobrý den",
	"EML_HI"				=> "Dobrý den ",
	"EML_AD_HAS"		=> "Administrátor Vám resetoval heslo.",
	"EML_AC_HAS"		=> "Administrátor Vám vytvořil účet.",
	"EML_REQ"				=> "Budete vyzváni ke změně hesla skrze odkaz výše.",
	"EML_EXP"				=> "Prosím pozor, platnost odkazu vyprší za ",
	"EML_VER_EXP"		=> "Platnost odkazu vyprší za ",
	"EML_CLICK"			=> "Pro přihlášení klikněte zde.",
	"EML_REC"				=> "Doporučujeme Vám změnit si heslo při přihlášení.",
	"EML_MSG"				=> "Máte novou zprávu od",
	"EML_REPLY"			=> "Pro odpovězení nebo zobrazní vlákna klikněte zde",
	"EML_WHY"				=> "Tento email Vám přišel, protože někdo (nejspíše Vy) požádal o resetování Vašeho hesla. Pokud jste to nebyli Vy, tento email ignorujte.",
	"EML_HOW"				=> "Pokud jste to byli Vy, klikněte na odkaz níže pro dokončení resetování hesla.",
	"EML_EML"				=> "Z Vašeho uživatelského účtu jsme zaregistrovali požadavek na změnu Vašeho emailu.",
	"EML_VER_EML"		=> "Díky za registraci. Až si ověříte emailovou adresu, budete se moci přihlásit! Pro ověření Vaší emailové adresy klikněte na odkaz níže.",
	"EML_INTRO"         => "těší nás, že chcete využívat mapu inspirativních škol a případně se i podílet na jejím rozvoji. Budeme rádi za sdílení jakýchkoliv podnětů či zaslání zpětné vazby na email ",
	"EML_SUBJ_WELCOME" => "Vítejte na webu ",
	"EML_SIGNATURE"		=> "Tým mapy škol",
));

//Verification
$lang = array_merge($lang, array(
	"VER_SUC"			=> "Váš email byl ověřen!",
	"VER_FAIL"		=> "Nebyli jsme schopni Váš účet ověřit. Prosím, zkuste to znovu.",
	"VER_RESEND"	=> "Znovu poslat ověřovací email",
	"VER_AGAIN"		=> "Zadejte svou emailovou adresu a zkuste to znovu",
	"VER_PAGE"		=> "<li>Zkontrolujte svůj email a klikněte na odkaz, který jsme Vám poslali.</li><li>Hotovo</li>",
	"VER_RES_SUC" => " Ověřovací odkaz jsme poslali na Vaši emailovou adresu.  Pro dokončení ověření klikněte na odkaz v emailu. V případě, že se email nenachází ve Vaší schránce, zkontrolujte také spam složku.  Ověřovací odkazy jsou platné jen ",
	"VER_OOPS"		=> "Ajéje...něco se nepodařilo, možná jste klikli na již neplatný odkaz. Zkuste to znovu kliknutím níže.",
	"VER_RESET"		=> "Vaše heslo bylo resetováno!",
	"VER_INS"			=> "<li>Zadejte svou emailovou adresu a klikněte na Resetovat.</li> <li>Zkontolujte svůj email a klikněte na námi zaslaný odkaz.</li>
												<li>Postupujte podle instrukcí na obrazovce.</li>",
	"VER_SENT"		=> " Odkaz na resetování hesla jsme zaslali na Vaši emailovou adresu. 
			    							 Pro resetování hesla klikněte v emailu na námi zaslaný odkaz.  V případě, že se email nenachází ve Vaší schránce, zkontrolujte také spam složku.  Ověřovací odkazy jsou platné jen ",
	"VER_PLEASE"	=> "Prosím, resetujte své heslo",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"				=> "Resetovat PIN",
	"SET_WHY"				=> "Proč toto nemohu změnit?",
	"SET_PW_MATCH"	=> "Musí se shodovat s novým heslem",

	"SET_PIN_NEXT"	=> "Můžete si nastavit nový PIN při příštím vyžádání ověření", //TODO ?
	"SET_UPDATE"		=> "Aktualizovat uživatelské nastavení",
	"SET_NOCHANGE"	=> "Administrátor zakázal měnit uživatelská jména.",
	"SET_ONECHANGE"	=> "Administrátor nastavil povolený počet změn uživatelského jména na 1 a tento počet jste již provedli.",

	"SET_GRAVITAR"	=> "Chcete si změnit profilový obrázek?  <br> Navštivte <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> a zařiďtě si účet se stejným emailem, jako jste použili u nás. Funguje to na milionech stránkách. Je to rychlé a snadné!",

	"SET_NOTE1"			=> " Prosím pozor,  máte nevyřízený požadavek aktualizovat svůj email na",

	"SET_NOTE2"			=> ".  Prosím použijte ověřovací email pro splnění tohoto požadavku. 
		 Pokud potřebujete nový ověřovací email, zadejte prosím výše svou emailovou adresu a odešlete požadavek znovu. ",

	"SET_PW_REQ" 		=> "vyžadováno pro změnu hesla, emailu nebo resetování PINu",
	"SET_PW_REQI" 	=> "Vyžadováno pro změnu Vašeho hesla",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "Nepodařilo se ukončit aktivní relace, Error: ",
	"ERR_EMAIL"				=> "Email NEBYL poslán kvůli chybě. Prosím, kontaktujre administrátora stránky.",
	"ERR_EM_DB"				=> "Tento email v naší databázi neexistuje.",
	"ERR_TC"					=> "Prosím, přečtete si a odsouhlaste podmínky použití.",
	"ERR_CAP"					=> "Neprošel jsi Captcha testem, Ty jeden Robote!",
	"ERR_PW_SAME"			=> "Vaše staré heslo nesmí být stejné jako Vaše nové heslo.",
	"ERR_PW_FAIL"			=> "Ověření hesla selhalo. Aktualizace selhala. Prosím, zkuste to znovu.",
	"ERR_GOOG"				=> "POZNÁMKA:  Pokud jste se původně registrovali Vaším Google/Facebook účtem, pro změnu Vašeho hesla budete muset použít odkaz \"Zapomenuté heslo\"...pokud tedy nejste velmi dobří v hádání.",
	"ERR_EM_VER"			=> "Ověření emailu není povoleno. Kontaktujte prosím systémového administrátora.",
	"ERR_EMAIL_STR"		=> "Něco se nepovedlo. Prosím, znovu ověřte svůj email. Za vzniklé nepříjemnosti se omlouváme.",

));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "Brzy se vrátíme!",
	"MAINT_MSG"			=> "Omlouváme se za nepříjemnosti, ale právě teď provádíme údržbu.<br> Za chvíli budeme zpět online!",
	"MAINT_BAN"			=> "Pardon, ale byli jste zabanováni. Pokud máte pocit, že se jedná o chybu, kontaktujte prosím administrátora.",
	"MAINT_TOK"			=> "Během zpracování Vašeho požadavku se vyskytla chyba. Prosím, zkuste to znovu. Pozor, odeslání formuláře obnovením stránky způsobí error. Pokud se tato chyba nepřestává objevovat, kontaktujte prosím administrátora.",
	"MAINT_OPEN"		=> "An Open Source PHP User Management Framework.",
	"MAINT_PLEASE"	=> "Úspěšně jste si nainstalovali UserSpice!<br>Pro zobrazení dokumentace Jak začít navštivte prosím "
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
	"DAT_SEARCH"    => "Hledat",
	"DAT_FIRST"     => "První",
	"DAT_LAST"      => "Poslední",
	"DAT_NEXT"      => "Další",
	"DAT_PREV"      => "Předchozí",
	"DAT_NODATA"        => "V tabulce nejsou žádná dostupná data",
	"DAT_INFO"          => "Zobrazeny záznamy _START_ až _END_ z celkem _TOTAL_ záznamů",
	"DAT_ZERO"          => "Zobrazeny záznamy 0 až 0 z celkem 0 záznamů",
	"DAT_FILTERED"      => "(filtrováno z celkem _MAX_ záznamů)",
	"DAT_MENU_LENG"     => "Zobrazit _MENU_ záznamy",
	"DAT_LOADING"       => "Načítání...",
	"DAT_PROCESS"       => "Zpracovávání...",
	"DAT_NO_REC"        => "Žádné odpovídající záznamy nenalezeny",
	"DAT_ASC"           => "Aktivujte pro setřídění dat vzestupně",
	"DAT_DESC"          => "Aktivujte pro setřídění dat sestupně",
));


///////////////////////////////////////////////////////////////

//Backend Translations for UserSpice 5
$lang = array_merge($lang, array(
	"BE_DASH"    			=> "Menu",
	"BE_SETTINGS"     => "Nastavení",
	"BE_GEN"					=> "Obecné",
	"BE_REG"					=> "Registrace",
	"BE_CUS"					=> "Custom Settings",
	"BE_DASH_ACC"			=> "Přístup k menu",
	"BE_TOOLS"				=> "Nástroje",
	"BE_BACKUP"				=> "Záloha",
	"BE_UPDATE"				=> "Aktualizace",
	"BE_CRON"				  => "Cron Jobs",
	"BE_IP"				  	=> "IP Manager",
));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
