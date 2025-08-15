<?php
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
$lang = array_merge($lang,array(
	"THIS_LANGUAGE"	=>"Slovenščina",
	"THIS_CODE"		=>"sl-SI",
	"MISSING_TEXT"	=>"Manjkajoče besedilo",
));

//Database Menus
$lang = array_merge($lang,array(
	"MENU_HOME"			=> "Domov",
	"MENU_HELP"			=> "Pomoč",
	"MENU_ACCOUNT"		=> "Račun",
	"MENU_DASH"			=> "Nadzorna plošča za skrbnike",
	"MENU_USER_MGR"		=> "Upravljanje uporabnikov",
	"MENU_PAGE_MGR"		=> "Upravljanje strani",
	"MENU_PERM_MGR"		=> "Upravljanje dovoljenj",
	"MENU_MSGS_MGR"		=> "Upravitelj sporočil",
	"MENU_LOGS_MGR"		=> "Sistemski dnevniki",
	"MENU_LOGOUT"		=> "Odjava",
));

// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"		=> "Registracija",
	"SIGNUP_BUTTONTEXT"	=> "Registriraj me",
	"SIGNUP_AUDITTEXT"	=> "Registriran",

	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"		=> "** NEUSPEŠNA PRIJAVA **",
	"SIGNIN_PLEASE_CHK" => "Prosimo, preverite svoje uporabniško ime in geslo ter poskusite znova",
	"SIGNIN_UORE"		=> "Uporabniško ime ALI E-pošta",
	"SIGNIN_PASS"		=> "Geslo",
	"SIGNIN_TITLE"		=> "Prosimo, prijavite se",
	"SIGNIN_TEXT"		=> "Prijavi se",
	"SIGNOUT_TEXT"		=> "Odjavi se",
	"SIGNIN_BUTTONTEXT"	=> "Prijava",
	"SIGNIN_REMEMBER"	=> "Zapomni si me",
	"SIGNIN_AUDITTEXT"	=> "Prijavljen",
	"SIGNIN_FORGOTPASS"	=>"Pozabljeno geslo",
	"SIGNOUT_AUDITTEXT"	=> "Odjavljen",
	));

// Account Page
$lang = array_merge($lang,array(
	"ACCT_EDIT"			=> "Uredi podatke o računu",
	"ACCT_2FA"			=> "Upravljanje z dvofaktorsko avtentikacijo",
	"ACCT_SESS"			=> "Upravljanje sej",
	"ACCT_HOME"			=> "Domov računa",
	"ACCT_SINCE"		=> "Član od",
	"ACCT_LOGINS"		=> "Število prijav",
	"ACCT_SESSIONS"		=> "Število aktivnih sej",
	"ACCT_MNG_SES"		=> "Za več informacij kliknite gumb Upravljanje sej v levem stranskem meniju.",
	));

	//General Terms
	$lang = array_merge($lang,array(
		"GEN_ENABLED"	=> "Omogočeno",
		"GEN_DISABLED"	=> "Onemogočeno",
		"GEN_ENABLE"	=> "Omogoči",
		"GEN_DISABLE"	=> "Onemogoči",
		"GEN_NO"		=> "Ne",
		"GEN_YES"		=> "Da",
		"GEN_MIN"		=> "min",
		"GEN_MAX"		=> "max",
		"GEN_CHAR"		=> "znak", //as in characters
		"GEN_SUBMIT"	=> "Pošlji",
		"GEN_MANAGE"	=> "Upravljaj",
		"GEN_VERIFY"	=> "Preveri",
		"GEN_SESSION"	=> "Seja",
		"GEN_SESSIONS"	=> "Seje",
		"GEN_EMAIL"		=> "E-pošta",
		"GEN_FNAME"		=> "Ime",
		"GEN_LNAME"		=> "Priimek",
		"GEN_UNAME"		=> "Uporabniško ime",
		"GEN_PASS"		=> "Geslo",
		"GEN_MSG"		=> "Sporočilo",
		"GEN_TODAY"		=> "Danes",
		"GEN_CLOSE"		=> "Zapri",
		"GEN_CANCEL"	=> "Prekliči",
		"GEN_CHECK"		=> "[ označi/odznači vse ]",
		"GEN_WITH"		=> "z",
		"GEN_UPDATED"	=> "Posodobljeno",
		"GEN_UPDATE"	=> "Posodobi",
		"GEN_BY"		=> "od",
		"GEN_FUNCTIONS"	=> "Funkcije",
		"GEN_NUMBER"	=> "število",
		"GEN_NUMBERS"	=> "števila",
		"GEN_INFO"		=> "Informacije",
		"GEN_REC"		=> "Posneto",
		"GEN_DEL"		=> "Izbriši",
		"GEN_NOT_AVAIL"	=> "Ni na voljo",
		"GEN_AVAIL"		=> "Na voljo",
		"GEN_BACK"		=> "Nazaj",
		"GEN_RESET"		=> "Ponastavi",
		"GEN_REQ"		=> "zahtevano",
		"GEN_AND"		=> "in",
		"GEN_SAME"		=> "mora biti enako",
		));

		//added during passkey/totp update
$lang = array_merge($lang, array(
    "GEN_PASSKEY"                         => "Pristopni ključ",
    "GEN_ACTIONS"                         => "Dejanja",
    "GEN_BACK_TO_ACCT"                    => "Nazaj na račun",
    "GEN_DB_ERROR"                        => "Prišlo je do napake v podatkovni bazi. Poskusite znova.",
    "GEN_IMPORTANT"                       => "Pomembno",
    "GEN_NO_PERMISSIONS"                  => "Nimate dovoljenja za dostop do te strani.",
    "GEN_NO_PERMISSIONS_MSG"              => "Nimate dovoljenja za dostop do te strani. Če menite, da gre za napako, se obrnite na skrbnika spletnega mesta.",
    "PASSKEYS_MANAGE_TITLE"               => "Upravljanje vaših pristopnih ključev",
    "PASSKEYS_LOGIN_TITLE"                => "Prijava s pristopnim ključem",
    "PASSKEY_DELETE_SUCCESS"              => "Pristopni ključ uspešno izbrisan.",
    "PASSKEY_DELETE_FAIL_DB"              => "Brisanje pristopnega ključa iz podatkovne baze ni uspelo.",
    "PASSKEY_DELETE_NOT_FOUND"            => "Pristopni ključ ni bil najden ali nimate dovoljenja za brisanje.",
    "PASSKEY_NOTE_UPDATE_SUCCESS"         => "Opomba pristopnega ključa uspešno posodobljena.",
    "PASSKEY_NOTE_UPDATE_FAIL"            => "Posodobitev opombe pristopnega ključa ni uspela.",
    "PASSKEY_REGISTER_NEW"                => "Registriraj nov pristopni ključ",
    "PASSKEY_ERR_LIMIT_REACHED"           => "Dosegli ste največje število 10 pristopnih ključev.",
    "PASSKEY_NOTE_TH"                     => "Opomba pristopnega ključa",
    "PASSKEY_TIMES_USED_TH"               => "Število uporab",
    "PASSKEY_LAST_USED_TH"                => "Zadnja uporaba",
    "PASSKEY_LAST_IP_TH"                  => "Zadnji IP-naslov",
    "PASSKEY_EDIT_NOTE_BTN"               => "Uredi opombo",
    "PASSKEY_CONFIRM_DELETE_JS"           => "Ali ste prepričani, da želite izbrisati ta pristopni ključ?",
    "PASSKEY_EDIT_MODAL_TITLE"            => "Uredi opombo pristopnega ključa",
    "PASSKEY_EDIT_MODAL_LABEL"            => "Opomba pristopnega ključa",
    "PASSKEY_SAVE_CHANGES_BTN"            => "Shrani spremembe",
    "PASSKEY_NONE_REGISTERED"             => "Nimate še registriranih pristopnih ključev.",
    "PASSKEY_MUST_REGISTER_FIRST"         => "Pred uporabo te funkcije morate najprej registrirati pristopni ključ iz overjenega računa.",
    "PASSKEY_STORING"                     => "Shranjevanje pristopnega ključa...",
    "PASSKEY_STORED_SUCCESS"              => "Pristopni ključ uspešno shranjen!",
    "PASSKEY_INVALID_ACTION"              => "Neveljavno dejanje: ",
    "PASSKEY_NO_ACTION_SPECIFIED"         => "Dejanje ni bilo določeno",
    "PASSKEY_ERR_NETWORK_SUGGESTION"      => "Zaznana je težava z omrežjem. Poskusite z drugim omrežjem ali osvežite stran.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "Zaznana je avtentikacija med napravami. Prepričajte se, da imata obe napravi dostop do interneta.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "Poskusite to stran odpreti neposredno na svojem telefonu.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"       => "Diagnostike ni bilo mogoče ustvariti: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"     => "Manjkajo zahtevani podatki za shranjevanje poverilnic.",
    "PASSKEY_MISSING_AUTH_DATA"           => "Manjkajo zahtevani podatki za avtentikacijo.",
    "PASSKEY_LOG_NO_MESSAGE"              => "Ni sporočila",
    "PASSKEY_USER_NOT_FOUND"              => "Uporabnik po preverjanju pristopnega ključa ni bil najden.",
    "PASSKEY_FATAL_ERROR"                 => "Usodna napaka: ",
    "PASSKEY_LOGIN_SUCCESS"               => "Prijava uspešna.",
    // JavaScript status messages (passkeys.php)
    "PASSKEY_CROSS_DEVICE_PREP"           => "Priprava na registracijo med napravami. Morda boste morali uporabiti svoj telefon ali tablico.",
    "PASSKEY_DEVICE_REGISTRATION"         => "Uporaba registracije pristopnega ključa naprave...",
    "PASSKEY_STARTING_REGISTRATION"       => "Začetek registracije pristopnega ključa...",
    "PASSKEY_REQUEST_OPTIONS"             => "Zahtevanje možnosti registracije od strežnika...",
    "PASSKEY_FOLLOW_PROMPTS"              => "Sledite navodilom za ustvarjanje pristopnega ključa. Morda boste morali uporabiti drugo napravo.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"       => "Sledite navodilom za ustvarjanje pristopnega ključa...",
    "PASSKEY_CREATION_FAILED"             => "Ustvarjanje pristopnega ključa ni uspelo - poverilnica ni bila vrnjena.",
    "PASSKEY_STORING_SERVER"              => "Shranjevanje vašega pristopnega ključa...",
    "PASSKEY_CREATED_SUCCESS"             => "Pristopni ključ uspešno ustvarjen!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP"      => "Priprava na avtentikacijo med napravami. Prepričajte se, da imata vaš telefon in računalnik dostop do interneta.",
    "PASSKEY_DEVICE_AUTH"                 => "Uporaba avtentikacije s pristopnim ključem naprave...",
    "PASSKEY_STARTING_AUTH"               => "Začetek avtentikacije s pristopnim ključem...",
    "PASSKEY_QR_CODE_INSTRUCTION"         => "Skenirajte QR-kodo s telefonom, ko se prikaže. Prepričajte se, da imata obe napravi dostop do interneta.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"    => "Ko boste pozvani, izberite \"Uporabi telefon ali tablico\", nato skenirajte QR-kodo.",
    "PASSKEY_AUTHENTICATING"              => "Avtentikacija z vašim pristopnim ključem...",
    "PASSKEY_SUCCESS_REDIRECTING"         => "Avtentikacija uspešna! Preusmerjanje...",
    // Timeout messages
    "PASSKEY_TIMEOUT_CROSS_DEVICE"        => "Registracija je potekla. Za registracijo med napravami: 1) Poskusite znova, 2) Prepričajte se, da imajo naprave dostop do interneta, 3) Razmislite o registraciji neposredno na telefonu.",
    "PASSKEY_TIMEOUT_SIMPLE"              => "Registracija je potekla. Poskusite znova.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"   => "Avtentikacija med napravami je potekla. Odpravljanje težav: 1) Obe napravi potrebujeta internet, 2) Poskusite hitreje skenirati QR-kodo, 3) Razmislite o uporabi iste naprave, 4) Nekatera omrežja blokirajo avtentikacijo med napravami.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"         => "Avtentikacija je potekla. Poskusite znova.",
    "PASSKEY_NO_CREDENTIAL"               => "Poverilnica ni bila prejeta. Poskušam znova...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"   => "Avtentikacija ni uspela - poverilnica ni bila vrnjena.",
    "PASSKEY_ATTEMPT_RETRY"               => "neuspešno. Poskušam znova... (preostalo %d poskusov)",
    // Error messages
    "PASSKEY_CROSS_DEVICE_FAILED"         => "Registracija med napravami ni uspela. Poskusite: 1) Prepričajte se, da imata obe napravi internet, 2) Razmislite o registraciji neposredno na telefonu, 3) Nekatera poslovna omrežja blokirajo to funkcijo.",
    "PASSKEY_REGISTRATION_CANCELLED"      => "Registracija je bila preklicana ali naprava ne podpira pristopnih ključev.",
    "PASSKEY_NOT_SUPPORTED"               => "Pristopni ključi niso podprti na tej kombinaciji naprave/brskalnika.",
    "PASSKEY_SECURITY_ERROR"              => "Varnostna napaka - to običajno kaže na neujemanje domene/izvora.",
    "PASSKEY_ALREADY_EXISTS"              => "Pristopni ključ za ta račun na tej napravi že obstaja. Poskusite z drugo napravo ali najprej izbrišite obstoječe pristopne ključe.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"    => "Avtentikacija med napravami ni uspela. Poskusite: 1) Prepričajte se, da imata obe napravi stabilen internet, 2) Če je mogoče, uporabite isto omrežje WiFi, 3) Poskusite se avtenticirati neposredno na telefonu, 4) Nekatera poslovna omrežja blokirajo to funkcijo.",
    "PASSKEY_AUTH_CANCELLED"              => "Avtentikacija je bila preklicana ali pristopni ključ ni bil izbran.",
    "PASSKEY_NETWORK_ERROR"               => "Napaka v omrežju. Za avtentikacijo med napravami potrebujeta obe napravi dostop do interneta in morda morata biti v istem omrežju.",
    "PASSKEY_CREDENTIAL_NOT_FOUND"        => "Avtentikacija ni uspela - poverilnica ni bila prepoznana.",
    // Cross-device guidance
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "Nasveti za avtentikacijo med napravami:",
    "PASSKEY_GUIDANCE_INTERNET"           => "Prepričajte se, da imata vaš računalnik in telefon dostop do interneta",
    "PASSKEY_GUIDANCE_WIFI"               => "Biti na istem omrežju WiFi lahko pomaga (vendar ni vedno potrebno)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"      => "Ko boste pozvani, izberite \"Uporabi telefon ali tablico\"",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"       => "Hitro skenirajte QR-kodo, ko se prikaže",
    "PASSKEY_GUIDANCE_TRY_DIRECT"         => "Če ne uspe, poskusite osvežiti stran in uporabiti brskalnik neposredno na telefonu",
    // Troubleshooting
    "PASSKEY_SHOW_TROUBLESHOOTING"        => "Pokaži nasvete za odpravljanje težav",
    "PASSKEY_HIDE_TROUBLESHOOTING"        => "Skrij nasvete za odpravljanje težav",
    "PASSKEY_DIAGNOSTICS_RUNNING"         => "Izvajanje diagnostike...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"        => "Diagnostika končana. Za podrobnosti preverite konzolo.",
    "PASSKEY_ISSUES_DETECTED"             => "Zaznane težave:",
    "PASSKEY_ENVIRONMENT_SUITABLE"        => "Okolje se zdi primerno za pristopne ključe.",
    "PASSKEY_DIAGNOSTICS_FAILED"          => "Diagnostika ni uspela:",
    // Modal
    "PASSKEY_ADD_NOTE_NEW"                => "Dodajte opombo svojemu novemu pristopnemu ključu",
    // Technical errors
    "PASSKEY_BASE64_ERROR"                => "Napaka pri dekodiranju Base64:",
    // Server-side errors (passkey_parser.php)
    "PASSKEY_INVALID_JSON"                => "Prejeti neveljavni podatki JSON:",
    // Session/validation errors (PasskeyHandler.php)
    "PASSKEY_NO_CHALLENGE_SESSION"        => "V seji ni bil najden izziv za registracijo pristopnega ključa. Poskusite se registrirati znova.",
    "PASSKEY_USER_MISMATCH"               => "Neujemanje ID-ja uporabnika. Poskusite se registrirati znova.",
    "PASSKEY_CHALLENGE_USER_MISMATCH"     => "ID uporabnika v možnostih izziva se ne ujema s trenutnim uporabnikom. Poskusite se registrirati znova.",
    "PASSKEY_REGISTRATION_FAILED_ERROR"   => "Registracija pristopnega ključa ni uspela. Prepričajte se, da vaša naprava in brskalnik podpirata WebAuthn, in poskusite znova. Napaka:",
    "PASSKEY_NO_AUTH_CHALLENGE_SESSION"   => "V seji ni bil najden izziv za preverjanje pristopnega ključa. Poskusite se prijaviti znova.",
    "PASSKEY_CREDENTIAL_NOT_IN_DB"        => "Poverilnica pristopnega ključa ni bila najdena v podatkovni bazi.",
    "PASSKEY_CREDENTIAL_WRONG_USER"       => "Poverilnica pristopnega ključa ne pripada pričakovanemu uporabniku.",
    "PASSKEY_VALIDATION_FAILED_ERROR"     => "Preverjanje pristopnega ključa ni uspelo. Poskusite znova ali se obrnite na podporo, če se težava ponavlja. Napaka:",
    "PASSKEY_USER_NOT_FOUND_REGISTRATION" => "Uporabnik za registracijo ni bil najden.",
    // --- Used in passkey_parser.php ---
    "PASSKEY_LOGIN_REQUIRED"              => "Za izvedbo tega dejanja morate biti prijavljeni.",
    "PASSKEY_ACTION_MISSING"              => "Zahtevani parameter 'action' je manjkal v zahtevi.",
    "PASSKEY_STORAGE_FAILED"              => "Shranjevanje pristopnega ključa ni uspelo. Operacija ni bila uspešna.",
    "PASSKEY_LOGIN_FAILED"                => "Prijava s pristopnim ključem ni uspela. Avtentikacije ni bilo mogoče preveriti.",
    "PASSKEY_INVALID_METHOD"              => "Neveljavna metoda zahteve:", // The script appends the method name after this key
    // --- Used in passkeys.php ---
    "CSRF_ERROR"                          => "Preverjanje žetona CSRF ni uspelo. Pojdite nazaj in poskusite znova oddati obrazec.",
    // Network analysis from analyzeNetworkConditions()
    "PASSKEY_NETWORK_PRIVATE"             => "Možna težava: Zdi se, da ste v zasebnem omrežju, kar lahko včasih moti komunikacijo med napravami.",
    "PASSKEY_NETWORK_PROXY"               => "Možna težava: Zaznan je bil proxy ali VPN. To lahko moti komunikacijo med napravami.",
    "PASSKEY_NETWORK_MOBILE"              => "Opomba: Zdi se, da ste v mobilnem omrežju. Zagotovite stabilno povezavo za delovanje med napravami.",
    "PASSKEY_NETWORK_CORPORATE"           => "Možna težava: Morda je aktiven požarni zid podjetja, kar bi lahko vplivalo na avtentikacijo med napravami.",
    // Recommendations from getCrossDeviceRecommendations()
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "Priporočilo: Verjetno uporabljate namizni računalnik. Pripravite se na uporabo telefona za skeniranje QR-kode.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "Priporočilo: Za najboljše rezultate poskrbite, da sta vaš računalnik in mobilna naprava v istem omrežju Wi-Fi.",
    "PASSKEY_RECOMMENDATION_QR_QUICK"     => "Priporočilo: Bodite pripravljeni na hitro skeniranje QR-kode, saj lahko zahteva poteče.",
    "PASSKEY_RECOMMENDATION_INTERNET"     => "Priporočilo: Zagotovite, da imata vaš računalnik in mobilna naprava stabilno internetno povezavo.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "Priporočilo: Za Unity WebViews poskrbite, da ima stran dovolj časa za nalaganje in obdelavo zahteve za pristopni ključ.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "Priporočilo: Časovne omejitve so lahko v Unityju daljše. Prosimo za potrpežljivost.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "Priporočilo: Ker ste na mobilni napravi, bi morali imeti možnost registrirati pristopni ključ neposredno na tej napravi.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Priporočilo: Na Androidu lahko svoje pristopne ključe upravljate v Google Upravitelju gesel.",
    // Validation from validateCrossDeviceEnvironment()
    "PASSKEY_VALIDATION_RP_IP"            => "Opozorilo o konfiguraciji: ID odvisne strani (Relying Party ID) je nastavljen na IP-naslov.",
    "PASSKEY_VALIDATION_RP_DOMAIN"        => "Priporočilo: Za boljšo varnost in združljivost nastavite ID odvisne strani na ime vaše domene (npr. vasastran.si).",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"   => "Napaka pri konfiguraciji: Za delovanje pristopnih ključev na delujočem strežniku je potreben HTTPS. Zdi se, da je vaša stran na HTTP.",
    "PASSKEY_VALIDATION_NETWORK"          => "Opozorilo o omrežju", // Generic prefix for network issues
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "Priporočilo: Če imate težave, poskusite z drugim omrežjem (npr. preklopite s poslovnega Wi-Fi na mobilno dostopno točko).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "Priporočilo: Za dejanja med napravami zagotovite, da imata obe napravi zanesljivo internetno povezavo.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"  => "Priporočilo: Če dejanja med napravami ne uspejo, poskusite obiskati to stran neposredno na svoji mobilni napravi, da dokončate dejanje.",
    "PASSKEY_INFO_TITLE"                  => "O pristopnih ključih",
    "PASSKEY_INFO_DESC"                   => "Pristopni ključi so varen način prijave brez gesla, ki uporablja vgrajene varnostne funkcije vaše naprave, kot so prstni odtis, prepoznavanje obraza ali PIN. So varnejši od gesel, omogočajo hitrejšo prijavo, delujejo na več napravah, če so sinhronizirani z upravitelji gesel, in so odporni na napade z lažnim predstavljanjem. Pristopni ključi delujejo na sodobnih pametnih telefonih, tablicah, računalnikih in jih je mogoče shraniti v upravitelje gesel, kot so 1Password, Bitwarden, iCloud Keychain ali Google Upravitelj gesel.",
    "PASSKEY_BACK_TO_LOGIN"               => "Nazaj na prijavo",
));

//validation class
	$lang = array_merge($lang,array(
		"VAL_SAME"		=> "mora biti enako",
		"VAL_EXISTS"	=> "že obstaja. Izberite drugo",
		"VAL_DB"		=> "Napaka v bazi podatkov",
		"VAL_NUM"		=> "mora biti število",
		"VAL_INT"		=> "mora biti celo število",
		"VAL_EMAIL"		=> "mora biti veljaven e-poštni naslov",
		"VAL_NO_EMAIL"	=> "ne sme biti e-poštni naslov",
		"VAL_SERVER"	=> "mora pripadati veljavnemu strežniku",
		"VAL_LESS"		=> "mora biti manjše od",
		"VAL_GREAT"		=> "mora biti večje od",
		"VAL_LESS_EQ"	=> "mora biti manjše ali enako",
		"VAL_GREAT_EQ"	=> "mora biti večje ali enako",
		"VAL_NOT_EQ"	=> "ne sme biti enako",
		"VAL_EQ"		=> "mora biti enako",
		"VAL_TZ"		=> "mora biti veljavno ime časovnega pasu",
		"VAL_MUST"		=> "mora biti",
		"VAL_MUST_LIST"	=> "mora biti eden od naslednjih",
		"VAL_TIME"		=> "mora biti veljaven čas",
		"VAL_SEL"		=> "ni veljavna izbira",
		"VAL_NA_PHONE"	=> "mora biti veljavna telefonska številka",
	));

		//Time
	$lang = array_merge($lang,array(
		"T_YEARS"		=> "Leta",
		"T_YEAR"		=> "Leto",
		"T_MONTHS"		=> "Meseci",
		"T_MONTH"		=> "Mesec",
		"T_WEEKS"		=> "Tedni",
		"T_WEEK"		=> "Teden",
		"T_DAYS"		=> "Dnevi",
		"T_DAY"			=> "Dan",
		"T_HOURS"		=> "Ure",
		"T_HOUR"		=> "Ura",
		"T_MINUTES"		=> "Minute",
		"T_MINUTE"		=> "Minuta",
		"T_SECONDS"		=> "Sekunde",
		"T_SECOND"		=> "Sekund",
		));


		//Passwords
	$lang = array_merge($lang,array(
		"PW_NEW"		=> "Novo geslo",
		"PW_OLD"		=> "Staro geslo",
		"PW_CONF"		=> "Potrdi geslo",
		"PW_RESET"		=> "Ponastavi geslo",
		"PW_UPD"		=> "Geslo posodobljeno",
		"PW_SHOULD"		=> "Gesla morajo biti...",
		"PW_SHOW"		=> "Prikaži geslo",
		"PW_SHOWS"		=> "Prikaži gesla",
		));


		//Join
	$lang = array_merge($lang,array(
		"JOIN_SUC"		=> "Dobrodošli v ",
		"JOIN_THANKS"	=> "Hvala za registracijo!",
		"JOIN_HAVE"		=> "Imeti vsaj ",
		"JOIN_CAP"		=> " veliko črko",
		"JOIN_TWICE"	=> "Biti pravilno vneseno dvakrat",
		"JOIN_CLOSED"	=> "Na žalost je registracija trenutno onemogočena. Če imate kakršna koli vprašanja ali pomisleke, se obrnite na skrbnika spletnega mesta.",
		"JOIN_TC"		=> "Pogoji in določila za uporabnike pri registraciji",
		"JOIN_ACCEPTTC" => "Sprejemam pogoje in določila za uporabnike",
		"JOIN_CHANGED"	=> "Naši pogoji so se spremenili",
		"JOIN_ACCEPT" 	=> "Sprejmite pogoje in določila za uporabnike in nadaljujte",

		));

		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "Uspešno zaključena ",
		));

		//Messages
	$lang = array_merge($lang,array(
		"MSG_SENT"		=> "Vaše sporočilo je bilo poslano!",
		"MSG_MASS"		=> "Vaše masovno sporočilo je bilo poslano!",
		"MSG_NEW"		=> "Novo sporočilo",
		"MSG_NEW_MASS"	=> "Novo masovno sporočilo",
		"MSG_CONV"		=> "Pogovori",
		"MSG_NO_CONV"	=> "Ni pogovorov",
		"MSG_NO_ARC"	=> "Ni pogovorov",
		"MSG_QUEST"		=> "Pošlji obvestilo po e-pošti, če je omogočeno?",
		"MSG_ARC"		=> "Arhivirane niti",
		"MSG_VIEW_ARC"	=> "Ogled arhiviranih niti",
		"MSG_SETTINGS"  => "Nastavitve sporočil",
		"MSG_READ"		=> "Prebrano",
		"MSG_BODY"		=> "Telo",
		"MSG_SUB"		=> "Zadeva",
		"MSG_DEL"		=> "Dostavljeno",
		"MSG_REPLY"		=> "Odgovori",
		"MSG_QUICK"		=> "Hiter odgovor",
		"MSG_SELECT"	=> "Izberite uporabnika",
		"MSG_UNKN"		=> "Neznan prejemnik",
		"MSG_NOTIF"		=> "Obvestila o sporočilih po e-pošti",
		"MSG_BLANK"		=> "Sporočilo ne sme biti prazno",
		"MSG_MODAL"		=> "Kliknite tukaj ali pritisnite Alt + R, da se osredotočite na to polje ALI pritisnite Shift + R, da odprete razširjeno okno za odgovor!",
		"MSG_ARCHIVE_SUCCESSFUL"        => "Uspešno ste arhivirali %m1% niti",
		"MSG_UNARCHIVE_SUCCESSFUL"      => "Uspešno ste de-arhivirali %m1% niti",
		"MSG_DELETE_SUCCESSFUL"         => "Uspešno ste izbrisali %m1% niti",
		"USER_MESSAGE_EXEMPT"         	=> "Uporabnik je %m1% izvzet iz sporočil.",
		"MSG_MK_READ"	=> "Prebrano",
		"MSG_MK_UNREAD"	=> "Neprebrano",
		"MSG_ARC_THR"	=> "Arhiviraj izbrane niti",
		"MSG_UN_THR"	=> "Dearhiviraj izbrane niti",
		"MSG_DEL_THR"	=> "Izbriši izbrane niti",
		"MSG_SEND"		=> "Pošlji sporočilo",
		));

//Two Factor Authentication
$lang = array_merge($lang, array(
    "2FA"                                => "Dvofaktorska avtentikacija",
    "2FA_CONF"                           => "Ali ste prepričani, da želite onemogočiti dvofaktorsko avtentikacijo? Vaš račun ne bo več zaščiten.",
    "2FA_SCAN"                           => "Skenirajte to QR-kodo z vašo aplikacijo za avtentikacijo ali vnesite ključ",
    "2FA_THEN"                           => "Nato tukaj vnesite eno od svojih enkratnih gesel",
    "2FA_FAIL"                           => "Pri preverjanju dvofaktorske avtentikacije je prišlo do težave. Preverite internetno povezavo ali se obrnite na podporo.",
    "2FA_CODE"                           => "2FA koda",
    "2FA_EXP"                            => "1 prstni odtis je potekel",
    "2FA_EXPD"                           => "Poteklo",
    "2FA_EXPS"                           => "Poteče",
    "2FA_ACTIVE"                         => "Aktivne seje",
    "2FA_NOT_FN"                         => "Prstni odtisi niso bili najdeni",
    "2FA_FP"                             => "Prstni odtisi",
    "2FA_NP"                             => "Prijava ni uspela - koda za dvofaktorsko avtentikacijo ni bila prisotna. Poskusite znova.",
    "2FA_INV"                            => "Prijava ni uspela - koda za dvofaktorsko avtentikacijo je bila neveljavna. Poskusite znova.",
    "2FA_FATAL"                          => "Usodna napaka - obrnite se na sistemskega skrbnika. Trenutno ne moremo ustvariti kode za dvofaktorsko avtentikacijo.",
    "2FA_SECTION_TITLE"                  => "Dvofaktorska avtentikacija (TOTP)",
    "2FA_SK_ALT"                         => "Če ne morete skenirati QR-kode, ročno vnesite ta skrivni ključ v svojo aplikacijo za avtentikacijo.",
    "2FA_IS_ENABLED"                     => "Dvofaktorska avtentikacija ščiti vaš račun.",
    "2FA_NOT_ENABLED_INFO"               => "Dvofaktorska avtentikacija trenutno ni omogočena.",
    "2FA_NOT_ENABLED_EXPLAIN"            => "Dvofaktorska avtentikacija (TOTP) doda dodatno raven varnosti vašemu računu, saj poleg gesla zahteva kodo iz aplikacije za avtentikacijo na vašem telefonu.",
    // Setup Process
    "2FA_SETUP_TITLE"                    => "Nastavitev dvofaktorske avtentikacije",
    "2FA_SECRET_KEY_LABEL"               => "Skrivni ključ:",
    "2FA_SETUP_VERIFY_CODE_LABEL"        => "Vnesite kodo za preverjanje iz aplikacije",
    // Backup Codes
    "2FA_SUCCESS_ENABLED_TITLE"          => "Dvofaktorska avtentikacija omogočena! Shranite svoje varnostne kode",
    "2FA_SUCCESS_ENABLED_INFO"           => "Spodaj so vaše varnostne kode. Shranite jih na varno - vsako je mogoče uporabiti samo enkrat.",
    "2FA_BACKUP_CODES_WARNING"           => "Te kode obravnavajte kot gesla. Shranite jih na varno.",
    "2FA_SUCCESS_BACKUP_REGENERATED"     => "Ustvarjene so nove varnostne kode. Shranite jih na varno.",
    "2FA_BACKUP_CODE_LABEL"              => "Varnostna koda",
    "2FA_REGEN_CODES_BTN"                => "Ponovno ustvari varnostne kode",
    "2FA_INVALIDATE_WARNING"             => "To bo razveljavilo vse obstoječe varnostne kode. Ali ste prepričani?",
    // Authentication
    "2FA_CODE_LABEL"                     => "Avtentikacijska koda",
    "2FA_VERIFY_BTN"                     => "Preveri in se prijavi",
    "2FA_VERIFY_TITLE"                   => "Potrebna je dvofaktorska avtentikacija",
    "2FA_VERIFY_INFO"                    => "Vnesite 6-mestno kodo iz vaše aplikacije za avtentikacijo.",
    // Actions & Buttons
    "2FA_ENABLE_BTN"                     => "Omogoči dvofaktorsko avtentikacijo",
    "2FA_DISABLE_BTN"                    => "Onemogoči dvofaktorsko avtentikacijo",
    "2FA_VERIFY_ACTIVATE_BTN"            => "Preveri in aktiviraj",
    "2FA_CANCEL_SETUP_BTN"               => "Prekliči nastavitev",
    "2FA_DONE_BTN"                       => "Končano",
    // Success Messages
    "REDIR_2FA_DIS"                      => "Dvofaktorska avtentikacija je bila onemogočena.",
    "2FA_SUCCESS_BACKUP_ACK"             => "Varnostne kode potrjene.",
    "2FA_SUCCESS_SETUP_CANCELLED"        => "Nastavitev preklicana.",
    // Error Messages
    "2FA_ERR_INVALID_BACKUP"             => "Neveljavna varnostna koda. Poskusite znova.",
    "2FA_ERR_DISABLE_FAILED"             => "Onemogočanje dvofaktorske avtentikacije ni uspelo.",
    "2FA_ERR_NO_SECRET"                  => "Skrivnega ključa za avtentikacijo ni bilo mogoče pridobiti. Poskusite znova.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"     => "Varnostna koda je bila preverjena, vendar je razveljavitev spodletela. Obrnite se na podporo.",
    "2FA_ERR_NO_CODE_PROVIDED"           => "Avtentikacijska koda ni bila vnesena.",
    "RATE_LIMIT_LOGIN"                   => "Preveč neuspelih poskusov prijave. Počakajte, preden poskusite znova.",
    "RATE_LIMIT_TOTP"                    => "Preveč napačnih avtentikacijskih kod. Počakajte, preden poskusite znova.",
    "RATE_LIMIT_PASSKEY"                 => "Preveč poskusov avtentikacije s pristopnim ključem. Počakajte, preden poskusite znova.",
    "RATE_LIMIT_PASSKEY_STORE"           => "Preveč poskusov registracije pristopnega ključa. Počakajte, preden poskusite znova.",
    "RATE_LIMIT_PASSWORD_RESET"          => "Preveč zahtev za ponastavitev gesla. Počakajte, preden zahtevate novo ponastavitev.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT"   => "Preveč poskusov ponastavitve gesla. Počakajte, preden poskusite znova.",
    "RATE_LIMIT_REGISTRATION"            => "Preveč poskusov registracije. Počakajte, preden poskusite znova.",
    "RATE_LIMIT_EMAIL_VERIFICATION"      => "Preveč zahtev za preverjanje e-pošte. Počakajte, preden zahtevate novo preverjanje.",
    "RATE_LIMIT_EMAIL_CHANGE"            => "Preveč zahtev za spremembo e-pošte. Počakajte, preden poskusite znova.",
    "RATE_LIMIT_PASSWORD_CHANGE"         => "Preveč poskusov spremembe gesla. Počakajte, preden poskusite znova.",
    "RATE_LIMIT_GENERIC"                 => "Preveč poskusov. Počakajte, preden poskusite znova.",
));

	
	$lang = array_merge($lang,array(
		"REDIR_2FA"					=> "Oprostite.Dvofaktorska avtentikacija trenutno ni omogočena",
		"REDIR_2FA_EN"				=> "Dvofaktorska avtentikacija omogočena",
		"REDIR_2FA_DIS"				=> "Dvofaktorska avtentikacija onemogočena",
		"REDIR_2FA_VER"				=> "Dvofaktorska avtentikacija preverjena in omogočena",
		"REDIR_SOMETHING_WRONG" 		=> "Nekaj je šlo narobe. Prosimo, poskusite znova.",
		"REDIR_MSG_NOEX"			=> "Ta vlaknica vam ne pripada ali ne obstaja.",
		"REDIR_UN_ONCE"				=> "Uporabniško ime je bilo že enkrat spremenjeno.",
		"REDIR_EM_SUCC"				=> "E-pošta uspešno posodobljena",
		));

	//Emails
	$lang = array_merge($lang,array(
		"EML_CONF"		=> "Potrditev e-pošte",
		"EML_VER"		=> "Preverite svojo e-pošto",
		"EML_CHK"		=> "Prejeli smo zahtevo za e-pošto. Prosimo, preverite svojo e-pošto za izvedbo preverjanja. Ne pozabite preveriti tudi mape za neželeno pošto, saj povezava za preverjanje poteče v ",
		"EML_MAT"		=> "Vaša e-pošta se ni ujemala.",
		"EML_HELLO"		=> "Pozdravljeni od ",
		"EML_HI"		=> "Pozdravljeni ",
		"EML_AD_HAS"	=> "Administrator je ponastavil vaše geslo.",
		"EML_AC_HAS"	=> "Administrator je ustvaril vaš račun.",
		"EML_REQ"		=> "Z uporabo zgornje povezave boste morali nastaviti svoje geslo.",
		"EML_EXP"		=> "Upoštevajte, da povezave za geslo potečejo v ",
		"EML_VER_EXP"	=> "Upoštevajte, da povezave za preverjanje potečejo v ",
		"EML_CLICK"		=> "Kliknite tukaj za prijavo.",
		"EML_REC"		=> "Priporočljivo je, da ob prijavi spremenite svoje geslo.",
		"EML_MSG"		=> "Prejeli ste novo sporočilo od",
		"EML_REPLY"		=> "Kliknite tukaj za odgovor ali ogled niti",
		"EML_WHY"		=> "To e-pošto ste prejeli, ker je bila podana zahteva za ponastavitev vašega gesla. Če to niste bili vi, lahko to e-pošto prezrete.",
		"EML_HOW"		=> "Če ste bili to vi, kliknite spodnjo povezavo, da nadaljujete s postopkom ponastavitve gesla.",
		"EML_EML"		=> "Zahtevo za spremembo vaše e-pošte je bilo podano znotraj vašega uporabniškega računa.",
		"EML_VER_EML"	=> "Hvala za prijavo. Ko boste preverili svoj e-poštni naslov, boste pripravljeni za prijavo! Kliknite spodnjo povezavo, da preverite svoj e-poštni naslov.",
		));

		//Verification
		$lang = array_merge($lang,array(
			"VER_SUC"		=> "Vaš e-poštni naslov je bil preverjen!",
			"VER_FAIL"		=> "Vašega računa nismo mogli preveriti. Prosimo, poskusite znova.",
			"VER_RESEND"	=> "Ponovno pošlji e-pošto za preverjanje",
			"VER_AGAIN"		=> "Vnesite svoj e-poštni naslov in poskusite znova",
			"VER_PAGE"		=> "<li>Preverite svojo e-pošto in kliknite na povezavo, ki vam je bila poslana</li><li>Končano</li>",
			"VER_RES_SUC" 	=> "<p>Povezava za preverjanje je bila poslana na vaš e-poštni naslov.</p><p>Kliknite na povezavo v e-pošti, da dokončate preverjanje. Če e-pošte ni v vašem nabiralniku, preverite mapo z neželeno pošto.</p><p>Povezave za preverjanje so veljavne samo ",
			"VER_OOPS"		=> "Ups...nekaj je šlo narobe, morda ste kliknili na staro povezavo za ponastavitev. Kliknite spodaj, da poskusite znova",
			"VER_RESET"		=> "Vaše geslo je bilo ponastavljeno!",
			"VER_INS"		=> "<li>Vnesite svoj e-poštni naslov in kliknite Ponastavi</li> <li>Preverite svojo e-pošto in kliknite na povezavo, ki vam je bila poslana.</li>
															<li>Sledite navodilom na zaslonu</li>",
			"VER_SENT"		=> "<p>Povezava za ponastavitev gesla je bila poslana na vaš e-poštni naslov.</p>
						    							<p>Kliknite na povezavo v e-pošti, da ponastavite geslo. Če e-pošte ni v vašem nabiralniku, preverite mapo z neželeno pošto.</p><p>Povezave za ponastavitev so veljavne samo ",
			"VER_PLEASE"	=> "Prosimo, ponastavite svoje geslo",
			));

	//User Settings
	$lang = array_merge($lang,array(
		"SET_PIN"		=> "Ponastavi PIN",
		"SET_WHY"		=> "Zakaj tega ne morem spremeniti?",
		"SET_PW_MATCH"	=> "Se mora ujemati z novim geslom",

		"SET_PIN_NEXT"	=> "Naslednjič, ko boste potrebovali preverjanje, lahko nastavite nov PIN",
		"SET_UPDATE"	=> "Posodobite nastavitve svojega uporabnika",
		"SET_NOCHANGE"	=> "Administrator je onemogočil spreminjanje uporabniških imen.",
		"SET_ONECHANGE"	=> "Administrator je nastavil, da se lahko uporabniška imena spremenijo samo enkrat, vi pa ste to že storili.",

		"SET_GRAVITAR"	=> "<strong>Želite spremeniti svojo profilno sliko? </strong><br> Obiščite <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> in ustvarite račun z istim e-poštnim naslovom, ki ste ga uporabili na tej strani. Deluje na milijonih strani. Hitro in enostavno!",

		"SET_NOTE1"		=> "<p><strong>Upoštevajte</strong>, da obstaja čakajoča zahteva za posodobitev vaše e-pošte na",

		"SET_NOTE2"		=> ".</p><p>Uporabite e-pošto za preverjanje, da dokončate to zahtevo.</p>
		<p>Če potrebujete novo e-pošto za preverjanje, ponovno vnesite zgornji e-poštni naslov in ponovno pošljite zahtevo.</p>",

		"SET_PW_REQ" 	=> "potrebno za spreminjanje gesla, e-pošte ali ponastavitev PIN",
		"SET_PW_REQI" 	=> "Potrebno za spremembo gesla",
		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"	=> "Ni uspelo prekiniti aktivnih sej, napaka: ",
		"ERR_EMAIL"		=> "E-pošte NI bilo mogoče poslati zaradi napake. Obrnite se na skrbnika spletnega mesta.",
		"ERR_EM_DB"		=> "Ta e-pošta ne obstaja v naši bazi podatkov",
		"ERR_TC"		=> "Prosimo, preberite in sprejmite pogoje uporabe",
		"ERR_CAP"		=> "Niste uspešno opravili Captcha testa, robot!",
		"ERR_PW_SAME"	=> "Vaše staro geslo ne more biti enako kot novo",
		"ERR_PW_FAIL"	=> "Preverjanje trenutnega gesla ni uspelo. Posodobitev ni uspela. Poskusite znova.",
		"ERR_GOOG"		=> "<strong>OPOMBA:</strong> Če ste se prvotno prijavili s svojim Google/Facebook računom, boste morali uporabiti povezavo za pozabljeno geslo, da spremenite svoje geslo... razen če ste res dobri v ugibanju.",
		"ERR_EM_VER"	=> "Preverjanje e-pošte ni omogočeno. Obrnite se na sistemski admin.",
		"ERR_EMAIL_STR"	=> "Nekaj je čudno. Prosimo, ponovno preverite svojo e-pošto. Opravičujemo se za nevšečnosti",
		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"	=> "Kmalu bomo nazaj!",
		"MAINT_MSG"		=> "Oprostite za nevšečnosti, trenutno izvajamo nekaj vzdrževalnih del.<br> Kmalu bomo spet na spletu!",
		"MAINT_BAN"		=> "Oprostite. Bili ste bannani. Če menite, da je to napaka, se obrnite na administratorja.",
		"MAINT_TOK"		=> "Prišlo je do napake z vašim obrazcem. Prosimo, pojdite nazaj in poskusite znova. Upoštevajte, da bo osvežitev strani in posledično ponovno pošiljanje obrazca povzročilo napako. Če se to še naprej dogaja, se obrnite na administratorja.",
		"MAINT_OPEN"	=> "Odprtokodni PHP okvir za upravljanje uporabnikov.",
		"MAINT_PLEASE"	=> "Uspešno ste namestili UserSpice!<br>Če želite ogledati našo dokumentacijo za začetek, obiščite"
		));

		//dataTables Added in 4.4.08
		//NOTE: do not change the words like _START_ between the two _ symbols!
		$lang = array_merge($lang,array(
			"DAT_SEARCH"    => "Iskanje",
			"DAT_FIRST"     => "Prvi",
			"DAT_LAST"      => "Zadnji",
			"DAT_NEXT"      => "Naslednji",
			"DAT_PREV"      => "Prejšnji",
			"DAT_NODATA"    => "V tabeli ni na voljo nobenih podatkov",
			"DAT_INFO"      => "Prikazujem _START_ do _END_ od _TOTAL_ vnosov",
			"DAT_ZERO"      => "Prikazujem 0 do 0 od 0 vnosov",
			"DAT_FILTERED"  => "(filtrirano iz _MAX_ skupnih vnosov)",
			"DAT_MENU_LENG" => "Prikaži _MENU_ vnosov",
			"DAT_LOADING"   => "Nalaganje...",
			"DAT_PROCESS"   => "Obdelava...",
			"DAT_NO_REC"    => "Ni najdenih ustreznih zapisov",
			"DAT_ASC"       => "Aktiviraj za naraščajoče razvrščanje stolpca",
			"DAT_DESC"      => "Aktiviraj za padajoče razvrščanje stolpca",
		));


///////////////////////////////////////////////////////////////

//Backend Translations for UserSpice
$lang = array_merge($lang,array(
"BE_DASH"    	=> "Dashboard",
"BE_SETTINGS"   => "Settings",
"BE_GEN"		=> "General",
"BE_REG"		=> "Registration",
"BE_CUS"		=> "Custom Settings",
"BE_DASH_ACC"	=> "Dashboard Access",
"BE_TOOLS"		=> "Tools",
"BE_BACKUP"		=> "Backup",
"BE_UPDATE"		=> "Updates",
"BE_CRON"		=> "Cron Jobs",
"BE_IP"			=> "IP Manager",
));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
?>
