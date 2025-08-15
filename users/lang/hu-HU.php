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
The Hungarian translation is done by
Tamás Szabó, Ph.D.
SpaceBar Consulting
klaymen@spacebar.hu
*/

/*
%m1% - Dynamic markers which are replaced at run time by the relevant index.
*/

$lang = array();
$lang = array_merge($lang, array(
	"THIS_LANGUAGE"	=> "Hungarian",
	"THIS_CODE"			=> "hu-HU",
	"MISSING_TEXT"	=> "Hiányzó szöveg",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "Írja be az e-mailben kapott kódot",
    "PASS_EMAIL_ONLY"     => "Kérjük, ellenőrizze e-mailjeit a bejelentkezési linkért",
    "PASS_CODE_ONLY"      => "Kérjük, írja be az e-mailben kapott kódot",
    "PASS_BOTH"           => "Kérjük, ellenőrizze e-mailjeit a bejelentkezési linkért, vagy írja be az e-mailben kapott kódot",
    "PASS_VER_BUTTON"     => "Kód ellenőrzése",
    "PASS_EMAIL_ONLY_MSG" => "Kérjük, erősítse meg e-mail címét az alábbi linkre kattintva",
    "PASS_CODE_ONLY_MSG"  => "Kérjük, írja be az alábbi kódot a bejelentkezéshez",
    "PASS_BOTH_MSG"       => "Kérjük, erősítse meg e-mail címét az alábbi linkre kattintva, vagy írja be a kódot a bejelentkezéshez",
    "PASS_YOUR_CODE"      => "Az Ön ellenőrző kódja: ",
    "PASS_CONFIRM_LOGIN"  => "Bejelentkezés megerősítése",
    "PASS_CONFIRM_CLICK"  => "Kattintson a bejelentkezés befejezéséhez",
    "PASS_GENERIC_ERROR"  => "Valami hiba történt",
));

//Database Menus
$lang = array_merge($lang, array(
	"MENU_HOME"			=> "Kezdőlap",
	"MENU_HELP"			=> "Segítség",
	"MENU_ACCOUNT"	=> "Adatlap",
	"MENU_DASH"			=> "Irányítópult",
	"MENU_USER_MGR"	=> "Felhasználók",
	"MENU_PAGE_MGR"	=> "Oldalak",
	"MENU_PERM_MGR"	=> "Engedélyek",
	"MENU_MSGS_MGR"	=> "Üzenet-kezelő",
	"MENU_LOGS_MGR"	=> "Rendszernaplók",
	"MENU_LOGOUT"		=> "Kijelentkezés",
));

// Signup
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"					=> "Regisztráció",
	"SIGNUP_BUTTONTEXT"		=> "Regisztrálok",
	"SIGNUP_AUDITTEXT"		=> "Regisztrált",
));

// Signin
$lang = array_merge($lang, array(
	"SIGNIN_FAIL"				=> "** SIKERTELEN BEJELENTKEZÉS **",
	"SIGNIN_PLEASE_CHK" => "Kérlek ellenőrizd a felhasználóneved és a jelszavad, majd próbálkozz újra",
	"SIGNIN_UORE"				=> "Felhasználónév VAGY e-mail cím",
	"SIGNIN_PASS"				=> "Jelszó",
	"SIGNIN_TITLE"			=> "Kérlek jelentkezz be",
	"SIGNIN_TEXT"				=> "Bejelentkezés",
	"SIGNOUT_TEXT"			=> "Kijelentkezés",
	"SIGNIN_BUTTONTEXT"	=> "Bejelentkezek",
	"SIGNIN_REMEMBER"		=> "Emlékezz rám",
	"SIGNIN_AUDITTEXT"	=> "Bejelentkezve",
	"SIGNIN_FORGOTPASS"	=> "Elfelejtett jelszó",
	"SIGNOUT_AUDITTEXT"	=> "Kijelentkezve",
));

// Account Page
$lang = array_merge($lang, array(
	"ACCT_EDIT"					=> "Adatlap szerkesztése",
	"ACCT_2FA"					=> "Kétfaktoros hitelesítés",
	"ACCT_SESS"					=> "Munkamenetek kezelése",
	"ACCT_HOME"					=> "Fiók kezdőlapja",
	"ACCT_SINCE"				=> "Csatlakozott",
	"ACCT_LOGINS"				=> "Bejelentkezések száma",
	"ACCT_SESSIONS"			=> "Aktív munkamenetek száma",
	"ACCT_MNG_SES"			=> "További információkért kattintson a bal oldali sávban a Munkamenetek kezelése gombra.",
));

//General Terms
$lang = array_merge($lang, array(
	"GEN_ENABLED"			=> "Engedélyezve",
	"GEN_DISABLED"		=> "Letiltva",
	"GEN_ENABLE"			=> "Engedélyezés",
	"GEN_DISABLE"			=> "Letiltás",
	"GEN_NO"					=> "Nem",
	"GEN_YES"					=> "Igen",
	"GEN_MIN"					=> "min",
	"GEN_MAX"					=> "max",
	"GEN_CHAR"				=> "karakter", //as in characters
	"GEN_SUBMIT"			=> "Beküldés",
	"GEN_MANAGE"			=> "Kezelés",
	"GEN_VERIFY"			=> "Ellenőrzés",
	"GEN_SESSION"			=> "Munkamenet",
	"GEN_SESSIONS"		=> "Munkamenetek",
	"GEN_EMAIL"				=> "E-mail cím",
	"GEN_FNAME"				=> "Keresztnév",
	"GEN_LNAME"				=> "Vezetéknév",
	"GEN_UNAME"				=> "Felhasználónév",
	"GEN_PASS"				=> "Jelszó",
	"GEN_MSG"					=> "Üzenet",
	"GEN_TODAY"				=> "Ma",
	"GEN_CLOSE"				=> "Bezár",
	"GEN_CANCEL"			=> "Mégsem",
	"GEN_CHECK"				=> "[ összes kijelölése/törlése ]",
	"GEN_WITH"				=> "val/vel",
	"GEN_UPDATED"			=> "Frissítve",
	"GEN_UPDATE"			=> "Frissít",
	"GEN_BY"					=> "tól/től",
	"GEN_FUNCTIONS"		=> "Funkciók",
	"GEN_NUMBER"			=> "száma",
	"GEN_NUMBERS"			=> "számai",
	"GEN_INFO"				=> "Információ",
	"GEN_REC"					=> "Rögzített",
	"GEN_DEL"					=> "Törlés",
	"GEN_NOT_AVAIL"		=> "Nem Elérhető",
	"GEN_AVAIL"				=> "Elérhető",
	"GEN_BACK"				=> "Vissza",
	"GEN_RESET"				=> "Visszaállítás",
	"GEN_REQ"					=> "szükséges",
	"GEN_AND"					=> "és",
	"GEN_SAME"				=> "nem egyezik",
));

//added during passkey/totp update
$lang = array_merge($lang, array(
    "GEN_PASSKEY"                         => "Jelszókulcs",
    "GEN_ACTIONS"                         => "Műveletek",
    "GEN_BACK_TO_ACCT"                    => "Vissza a fiókhoz",
    "GEN_DB_ERROR"                        => "Adatbázis hiba történt. Kérjük, próbálja újra.",
    "GEN_IMPORTANT"                       => "Fontos",
    "GEN_NO_PERMISSIONS"                  => "Nincs jogosultsága az oldal megtekintéséhez.",
    "GEN_NO_PERMISSIONS_MSG"              => "Nincs jogosultsága az oldal megtekintéséhez. Ha úgy gondolja, hogy ez téves, kérjük, lépjen kapcsolatba az oldal adminisztrátorával.",
    "PASSKEYS_MANAGE_TITLE"               => "Jelszókulcsainak kezelése",
    "PASSKEYS_LOGIN_TITLE"                => "Bejelentkezés jelszókulccsal",
    "PASSKEY_DELETE_SUCCESS"              => "A jelszókulcs sikeresen törölve.",
    "PASSKEY_DELETE_FAIL_DB"              => "A jelszókulcs törlése az adatbázisból sikertelen.",
    "PASSKEY_DELETE_NOT_FOUND"            => "A jelszókulcs nem található, vagy a törlési engedély elutasítva.",
    "PASSKEY_NOTE_UPDATE_SUCCESS"         => "A jelszókulcs jegyzete sikeresen frissítve.",
    "PASSKEY_NOTE_UPDATE_FAIL"            => "A jelszókulcs jegyzetének frissítése sikertelen.",
    "PASSKEY_REGISTER_NEW"                => "Új jelszókulcs regisztrálása",
    "PASSKEY_ERR_LIMIT_REACHED"           => "Elérte a maximális 10 jelszókulcsot.",
    "PASSKEY_NOTE_TH"                     => "Jelszókulcs jegyzet",
    "PASSKEY_TIMES_USED_TH"               => "Használatok száma",
    "PASSKEY_LAST_USED_TH"                => "Utoljára használva",
    "PASSKEY_LAST_IP_TH"                  => "Utolsó IP-cím",
    "PASSKEY_EDIT_NOTE_BTN"               => "Jegyzet szerkesztése",
    "PASSKEY_CONFIRM_DELETE_JS"           => "Biztosan törölni szeretné ezt a jelszókulcsot?",
    "PASSKEY_EDIT_MODAL_TITLE"            => "Jelszókulcs jegyzet szerkesztése",
    "PASSKEY_EDIT_MODAL_LABEL"            => "Jelszókulcs jegyzet",
    "PASSKEY_SAVE_CHANGES_BTN"            => "Változtatások mentése",
    "PASSKEY_NONE_REGISTERED"             => "Még nincsenek regisztrált jelszókulcsai.",
    "PASSKEY_MUST_REGISTER_FIRST"         => "A funkció használata előtt regisztrálnia kell egy jelszókulcsot egy hitelesített fiókból.",
    "PASSKEY_STORING"                     => "Jelszókulcs mentése...",
    "PASSKEY_STORED_SUCCESS"              => "A jelszókulcs sikeresen mentve!",
    "PASSKEY_INVALID_ACTION"              => "Érvénytelen művelet: ",
    "PASSKEY_NO_ACTION_SPECIFIED"         => "Nincs művelet megadva",
    "PASSKEY_ERR_NETWORK_SUGGESTION"      => "Hálózati probléma észlelve. Próbáljon másik hálózatot vagy frissítse az oldalt.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "Eszközök közötti hitelesítés észlelve. Győződjön meg róla, hogy mindkét eszköz rendelkezik internetkapcsolattal.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "Próbálja meg inkább közvetlenül a telefonján megnyitni ezt az oldalt.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"       => "Nem sikerült diagnosztikát készíteni: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"     => "Hiányoznak a tároláshoz szükséges hitelesítő adatok.",
    "PASSKEY_MISSING_AUTH_DATA"           => "Hiányoznak a szükséges hitelesítési adatok.",
    "PASSKEY_LOG_NO_MESSAGE"              => "Nincs üzenet",
    "PASSKEY_USER_NOT_FOUND"              => "A felhasználó nem található a jelszókulcs érvényesítése után.",
    "PASSKEY_FATAL_ERROR"                 => "Végzetes hiba: ",
    "PASSKEY_LOGIN_SUCCESS"               => "Sikeres bejelentkezés.",
    // JavaScript status messages (passkeys.php)
    "PASSKEY_CROSS_DEVICE_PREP"           => "Eszközök közötti regisztráció előkészítése. Lehet, hogy telefonját vagy tabletjét kell használnia.",
    "PASSKEY_DEVICE_REGISTRATION"         => "Eszköz jelszókulcs-regisztrációjának használata...",
    "PASSKEY_STARTING_REGISTRATION"       => "Jelszókulcs-regisztráció indítása...",
    "PASSKEY_REQUEST_OPTIONS"             => "Regisztrációs opciók kérése a szerverről...",
    "PASSKEY_FOLLOW_PROMPTS"              => "Kövesse az utasításokat a jelszókulcs létrehozásához. Lehet, hogy másik eszközt kell használnia.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"       => "Kövesse az utasításokat a jelszókulcs létrehozásához...",
    "PASSKEY_CREATION_FAILED"             => "A jelszókulcs létrehozása sikertelen - nem érkezett hitelesítő adat.",
    "PASSKEY_STORING_SERVER"              => "Jelszókulcsának mentése...",
    "PASSKEY_CREATED_SUCCESS"             => "A jelszókulcs sikeresen létrehozva!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP"      => "Eszközök közötti hitelesítés előkészítése. Győződjön meg róla, hogy telefonja és számítógépe is rendelkezik internetkapcsolattal.",
    "PASSKEY_DEVICE_AUTH"                 => "Eszköz jelszókulcs-hitelesítésének használata...",
    "PASSKEY_STARTING_AUTH"               => "Jelszókulcs-hitelesítés indítása...",
    "PASSKEY_QR_CODE_INSTRUCTION"         => "Olvassa be a QR-kódot a telefonjával, amikor megjelenik. Győződjön meg róla, hogy mindkét eszköz rendelkezik internetkapcsolattal.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"    => "Válassza a \"Telefon vagy tablet használata\" lehetőséget, amikor a rendszer kéri, majd olvassa be a QR-kódot.",
    "PASSKEY_AUTHENTICATING"              => "Hitelesítés a jelszókulcsával...",
    "PASSKEY_SUCCESS_REDIRECTING"         => "Sikeres hitelesítés! Átirányítás...",
    // Timeout messages
    "PASSKEY_TIMEOUT_CROSS_DEVICE"        => "A regisztráció időtúllépés miatt megszakadt. Eszközök közötti regisztráció esetén: 1) Próbálja újra, 2) Győződjön meg róla, hogy az eszközök rendelkeznek internetkapcsolattal, 3) Fontolja meg a regisztrációt közvetlenül a telefonján.",
    "PASSKEY_TIMEOUT_SIMPLE"              => "A regisztráció időtúllépés miatt megszakadt. Kérjük, próbálja újra.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"   => "Az eszközök közötti hitelesítés időtúllépés miatt megszakadt. Hibaelhárítás: 1) Mindkét eszköznek internetkapcsolatra van szüksége, 2) Próbálja gyorsabban beolvasni a QR-kódot, 3) Fontolja meg ugyanazon eszköz használatát, 4) Néhány hálózat blokkolja az eszközök közötti hitelesítést.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"         => "A hitelesítés időtúllépés miatt megszakadt. Kérjük, próbálja újra.",
    "PASSKEY_NO_CREDENTIAL"               => "Nem érkezett hitelesítő adat. Újrapróbálkozás...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"   => "A hitelesítés sikertelen - nem érkezett hitelesítő adat.",
    "PASSKEY_ATTEMPT_RETRY"               => "sikertelen. Újrapróbálkozás... (%d kísérlet maradt)",
    // Error messages
    "PASSKEY_CROSS_DEVICE_FAILED"         => "Az eszközök közötti regisztráció sikertelen. Próbálja meg: 1) Győződjön meg róla, hogy mindkét eszköz rendelkezik internetkapcsolattal, 2) Fontolja meg a regisztrációt közvetlenül a telefonján, 3) Néhány vállalati hálózat blokkolja ezt a funkciót.",
    "PASSKEY_REGISTRATION_CANCELLED"      => "A regisztráció megszakadt, vagy az eszköz nem támogatja a jelszókulcsokat.",
    "PASSKEY_NOT_SUPPORTED"               => "A jelszókulcsok nem támogatottak ezen az eszköz/böngésző kombináción.",
    "PASSKEY_SECURITY_ERROR"              => "Biztonsági hiba - ez általában domain/eredet eltérésre utal.",
    "PASSKEY_ALREADY_EXISTS"              => "Már létezik jelszókulcs ehhez a fiókhoz ezen az eszközön. Próbáljon másik eszközt használni, vagy először törölje a meglévő jelszókulcsokat.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"    => "Az eszközök közötti hitelesítés sikertelen. Próbálja meg: 1) Győződjön meg róla, hogy mindkét eszköz stabil internetkapcsolattal rendelkezik, 2) Ha lehetséges, használja ugyanazt a WiFi hálózatot, 3) Próbálja meg a hitelesítést közvetlenül a telefonján, 4) Néhány vállalati hálózat blokkolja ezt a funkciót.",
    "PASSKEY_AUTH_CANCELLED"              => "A hitelesítés megszakadt, vagy nem lett jelszókulcs kiválasztva.",
    "PASSKEY_NETWORK_ERROR"               => "Hálózati hiba. Az eszközök közötti hitelesítéshez mindkét eszköznek internetkapcsolatra van szüksége, és lehet, hogy ugyanazon a hálózaton kell lenniük.",
    "PASSKEY_CREDENTIAL_NOT_FOUND"        => "A hitelesítés sikertelen - a hitelesítő adat nem ismerhető fel.",
    // Cross-device guidance
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "Tippek az eszközök közötti hitelesítéshez:",
    "PASSKEY_GUIDANCE_INTERNET"           => "Győződjön meg róla, hogy számítógépe és telefonja is rendelkezik internetkapcsolattal",
    "PASSKEY_GUIDANCE_WIFI"               => "Az ugyanazon a WiFi hálózaton való tartózkodás segíthet (de nem mindig szükséges)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"      => "Amikor a rendszer kéri, válassza a \"Telefon vagy tablet használata\" lehetőséget",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"       => "Olvassa be gyorsan a QR-kódot, amikor megjelenik",
    "PASSKEY_GUIDANCE_TRY_DIRECT"         => "Ha sikertelen, próbálja meg frissíteni az oldalt és közvetlenül a telefon böngészőjét használni",
    // Troubleshooting
    "PASSKEY_SHOW_TROUBLESHOOTING"        => "Hibaelhárítási tippek megjelenítése",
    "PASSKEY_HIDE_TROUBLESHOOTING"        => "Hibaelhárítási tippek elrejtése",
    "PASSKEY_DIAGNOSTICS_RUNNING"         => "Diagnosztika futtatása...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"        => "A diagnosztika befejeződött. Részletekért ellenőrizze a konzolt.",
    "PASSKEY_ISSUES_DETECTED"             => "Észlelt problémák:",
    "PASSKEY_ENVIRONMENT_SUITABLE"        => "A környezet megfelelőnek tűnik a jelszókulcsokhoz.",
    "PASSKEY_DIAGNOSTICS_FAILED"          => "A diagnosztika sikertelen:",
    // Modal
    "PASSKEY_ADD_NOTE_NEW"                => "Jegyzet hozzáadása az új jelszókulcsához",
    // Technical errors
    "PASSKEY_BASE64_ERROR"                => "Base64 dekódolási hiba:",
    // Server-side errors (passkey_parser.php)
    "PASSKEY_INVALID_JSON"                => "Érvénytelen JSON adat érkezett:",
    // Session/validation errors (PasskeyHandler.php)
    "PASSKEY_NO_CHALLENGE_SESSION"        => "Nem található jelszókulcs regisztrációs kihívás a munkamenetben. Kérjük, próbálja újra a regisztrációt.",
    "PASSKEY_USER_MISMATCH"               => "Felhasználói azonosító eltérés. Kérjük, próbálja újra a regisztrációt.",
    "PASSKEY_CHALLENGE_USER_MISMATCH"     => "A kihívás opcióiban szereplő felhasználói azonosító nem egyezik a jelenlegi felhasználóval. Kérjük, próbálja újra a regisztrációt.",
    "PASSKEY_REGISTRATION_FAILED_ERROR"   => "A jelszókulcs regisztrációja sikertelen. Kérjük, győződjön meg róla, hogy eszköze és böngészője támogatja a WebAuthn-t, és próbálja újra. Hiba:",
    "PASSKEY_NO_AUTH_CHALLENGE_SESSION"   => "Nem található jelszókulcs hitelesítési kihívás a munkamenetben. Kérjük, próbáljon újra bejelentkezni.",
    "PASSKEY_CREDENTIAL_NOT_IN_DB"        => "A jelszókulcs hitelesítő adatai nem találhatók az adatbázisban.",
    "PASSKEY_CREDENTIAL_WRONG_USER"       => "A jelszókulcs hitelesítő adatai nem a várt felhasználóhoz tartoznak.",
    "PASSKEY_VALIDATION_FAILED_ERROR"     => "A jelszókulcs érvényesítése sikertelen. Kérjük, próbálja újra, vagy lépjen kapcsolatba a támogatással, ha a probléma továbbra is fennáll. Hiba:",
    "PASSKEY_USER_NOT_FOUND_REGISTRATION" => "A felhasználó nem található a regisztrációhoz.",
    // --- Used in passkey_parser.php ---
    "PASSKEY_LOGIN_REQUIRED"              => "A művelet végrehajtásához be kell jelentkeznie.",
    "PASSKEY_ACTION_MISSING"              => "A kérésből hiányzott a szükséges 'action' paraméter.",
    "PASSKEY_STORAGE_FAILED"              => "A jelszókulcs tárolása sikertelen. A művelet nem volt sikeres.",
    "PASSKEY_LOGIN_FAILED"                => "A jelszókulcsos bejelentkezés sikertelen. A hitelesítést nem sikerült ellenőrizni.",
    "PASSKEY_INVALID_METHOD"              => "Érvénytelen kérés metódus:", // The script appends the method name after this key
    // --- Used in passkeys.php ---
    "CSRF_ERROR"                          => "A CSRF token ellenőrzése sikertelen. Kérjük, lépjen vissza, és próbálja meg újra elküldeni az űrlapot.",
    // Network analysis from analyzeNetworkConditions()
    "PASSKEY_NETWORK_PRIVATE"             => "Lehetséges probléma: Úgy tűnik, privát hálózaton van, ami néha zavarhatja az eszközök közötti kommunikációt.",
    "PASSKEY_NETWORK_PROXY"               => "Lehetséges probléma: Proxy vagy VPN észlelve. Ez zavarhatja az eszközök közötti kommunikációt.",
    "PASSKEY_NETWORK_MOBILE"              => "Megjegyzés: Úgy tűnik, mobilhálózaton van. Biztosítson stabil kapcsolatot az eszközök közötti műveletekhez.",
    "PASSKEY_NETWORK_CORPORATE"           => "Lehetséges probléma: Vállalati tűzfal lehet aktív, ami befolyásolhatja az eszközök közötti hitelesítést.",
    // Recommendations from getCrossDeviceRecommendations()
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "Ajánlás: Valószínűleg asztali gépet használ. Készüljön fel telefonja használatára egy QR-kód beolvasásához.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "Ajánlás: A legjobb eredmény érdekében győződjön meg róla, hogy számítógépe és mobil eszköze ugyanazon a Wi-Fi hálózaton van.",
    "PASSKEY_RECOMMENDATION_QR_QUICK"     => "Ajánlás: Legyen készen a QR-kód gyors beolvasására, mivel a kérés időtúllépés miatt megszakadhat.",
    "PASSKEY_RECOMMENDATION_INTERNET"     => "Ajánlás: Győződjön meg róla, hogy számítógépe és mobil eszköze is stabil internetkapcsolattal rendelkezik.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "Ajánlás: Unity WebView esetén győződjön meg róla, hogy az oldalnak elegendő ideje van betölteni és feldolgozni a jelszókulcs kérést.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "Ajánlás: Az időtúllépések hosszabbak lehetnek a Unityben. Kérjük, legyen türelemmel.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "Ajánlás: Mivel mobilon van, képesnek kell lennie egy jelszókulcsot közvetlenül erre az eszközre regisztrálni.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Ajánlás: Androidon a jelszókulcsait a Google Jelszókezelőben kezelheti.",
    // Validation from validateCrossDeviceEnvironment()
    "PASSKEY_VALIDATION_RP_IP"            => "Konfigurációs figyelmeztetés: A Relying Party ID egy IP-címre van beállítva.",
    "PASSKEY_VALIDATION_RP_DOMAIN"        => "Ajánlás: A jobb biztonság és kompatibilitás érdekében állítsa be a Relying Party ID-t a domain nevére (pl. weboldalad.hu).",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"   => "Konfigurációs hiba: A jelszókulcsok működéséhez élő szerveren HTTPS szükséges. Úgy tűnik, az oldala HTTP-n fut.",
    "PASSKEY_VALIDATION_NETWORK"          => "Hálózati figyelmeztetés", // Generic prefix for network issues
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "Ajánlás: Ha problémákat tapasztal, próbáljon másik hálózatot (pl. váltson vállalati Wi-Fi-ről mobil hotspotra).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "Ajánlás: Az eszközök közötti műveletekhez győződjön meg róla, hogy mindkét eszköz megbízható internetkapcsolattal rendelkezik.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"  => "Ajánlás: Ha az eszközök közötti műveletek sikertelenek, próbálja meg a műveletet közvetlenül a mobil eszközén végrehajtani ezen az oldalon.",
    "PASSKEY_INFO_TITLE"                  => "A jelszókulcsokról",
    "PASSKEY_INFO_DESC"                   => "A jelszókulcsok egy biztonságos, jelszómentes bejelentkezési módszer, amely az eszköz beépített biztonsági funkcióit, például ujjlenyomatot, arcfelismerést vagy PIN-kódot használja. Biztonságosabbak a jelszavaknál, gyorsabb bejelentkezést tesznek lehetővé, működnek eszközökön át, ha jelszókezelőkkel szinkronizálják őket, és ellenállnak az adathalász támadásoknak. A jelszókulcsok modern okostelefonokon, tableteken, számítógépeken működnek, és tárolhatók jelszókezelőkben, mint például a 1Password, Bitwarden, iCloud Kulcskarika vagy a Google Jelszókezelő.",
    "PASSKEY_BACK_TO_LOGIN"               => "Vissza a bejelentkezéshez",
));

//validation class
$lang = array_merge($lang, array(
	"VAL_SAME"				=> "nem egyezik",
	"VAL_EXISTS"			=> "már létezik. Kérlek válassz egy másikat",
	"VAL_DB"					=> "Adatbázis hiba",
	"VAL_NUM"					=> "számnak kell lennie",
	"VAL_INT"					=> "egész számnak kell lennie",
	"VAL_EMAIL"				=> "érvényes e-mail címnek kell lennie",
	"VAL_NO_EMAIL"		=> "nem lehet e-mail cím",
	"VAL_SERVER"			=> "létező szerverhez kell tartoznia",
	"VAL_LESS"				=> "kevesebbnek kell lennie, mint",
	"VAL_GREAT"				=> "többnek kell lennie, mint",
	"VAL_LESS_EQ"			=> "kevesebbnek vagy egyenlőnek kell lennie, mint",
	"VAL_GREAT_EQ"		=> "többnek vagy egyenlőnek kell lennie, mint",
	"VAL_NOT_EQ"			=> "nem lehet egyenlő",
	"VAL_EQ"					=> "egyenlőnek kell lennie",
	"VAL_TZ"					=> "érvényes időzóna nevének kell lennie",
	"VAL_MUST"				=> "kell, hogy legyen",
	"VAL_MUST_LIST"		=> "a következők egyikének kell lennie",
	"VAL_TIME"				=> "érvényes időnek kell lennie",
	"VAL_SEL"					=> "nem érvényes kijelölés",
	"VAL_NA_PHONE"		=> "érvényes észak-amerikai telefonszámnak kell lennie",
));

//Time
$lang = array_merge($lang, array(
	"T_YEARS"			=> "Évek",
	"T_YEAR"			=> "Év",
	"T_MONTHS"		=> "Hónapok",
	"T_MONTH"			=> "Hónap",
	"T_WEEKS"			=> "Hetek",
	"T_WEEK"			=> "Hét",
	"T_DAYS"			=> "Napok",
	"T_DAY"				=> "Nap",
	"T_HOURS"			=> "Órák",
	"T_HOUR"			=> "Óra",
	"T_MINUTES"		=> "Percek",
	"T_MINUTE"		=> "Perc",
	"T_SECONDS"		=> "Másodpercek",
	"T_SECOND"		=> "Másodperc",
));


//Passwords
$lang = array_merge($lang, array(
	"PW_NEW"		=> "Új Jelszó",
	"PW_OLD"		=> "Régi Jelszó",
	"PW_CONF"		=> "Jelszó Ellenőrzése",
	"PW_RESET"	=> "Jelszó visszaállítása",
	"PW_UPD"		=> " Frissítve",
	"PW_SHOULD"	=> "A jelszó",
	"PW_SHOW"		=> "Jelszó megmutatása",
	"PW_SHOWS"	=> "Jelszavak megmutatása",
));


//Join
$lang = array_merge($lang, array(
	"JOIN_SUC"			=> "Üdvözöllek a ",
	"JOIN_THANKS"		=> "Köszönjük, hogy regisztráltál!",
	"JOIN_HAVE"			=> "Tartalmaznia kell ",
	"JOIN_LOWER"	=> " kisbetűt",
	"JOIN_SYMBOL"		=> " szimbólumot",
	"JOIN_CAP"			=> " nagybetűt",
	"JOIN_TWICE"		=> "kétszer be lett írva helyesen",
	"JOIN_CLOSED"		=> "Sajnos a regisztráció jelenleg le van tiltva. Ha bármilyen kérdésed vagy aggályod van, fordulj az adminisztrátorhoz.",
	"JOIN_TC"				=> "Regisztrációs felhasználási feltételek",
	"JOIN_ACCEPTTC" => "Elfogadom a felhasználási feltételeket",
	"JOIN_CHANGED"	=> "Feltételeink megváltoztak",
	"JOIN_ACCEPT" 	=> "Fogadd el a felhasználási feltételeket és folytasd",
	"JOIN_SCORE" => "Pont:",
	"JOIN_INVALID_PW" => "A jelszava érvénytelen",

));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "Sikeresen lezárt ",
));

//Messages
$lang = array_merge($lang, array(
	"MSG_SENT"			=> "Az üzeneted el lett küldve!",
	"MSG_MASS"			=> "A tömeges üzeneted elküldve!",
	"MSG_NEW"				=> "Új Üzenet",
	"MSG_NEW_MASS"	=> "Új Tömeges Üzenet",
	"MSG_CONV"			=> "Beszélgetések",
	"MSG_NO_CONV"		=> "Nincsenek Beszélgetések",
	"MSG_NO_ARC"		=> "Nincsenek Beszélgetések",
	"MSG_QUEST"			=> "E-mail értesítés küldése, ha engedélyezve van?",
	"MSG_ARC"				=> "Archivált Témák",
	"MSG_VIEW_ARC"	=> "Archivált Témák Megjelenítése",
	"MSG_SETTINGS"  => "Üzenet Beállítások",
	"MSG_READ"			=> "Olvasás",
	"MSG_BODY"			=> "Tartalom",
	"MSG_SUB"				=> "Tárgy",
	"MSG_DEL"				=> "Kézbesítve",
	"MSG_REPLY"			=> "Válasz",
	"MSG_QUICK"			=> "Gyors Válasz",
	"MSG_SELECT"		=> "Felhasználó kiválasztása",
	"MSG_UNKN"			=> "Ismeretlen Címzett",
	"MSG_NOTIF"			=> "Üzenetküldési e-mail értesítések",
	"MSG_BLANK"			=> "Az üzenet nem lehet üres",
	"MSG_MODAL"			=> "Kattints ide, vagy használd az Alt R kombinációt, VAGY nyomd meg a Shift R kombinációt a válaszablak megnyitásához!",
	"MSG_ARCHIVE_SUCCESSFUL"        => "Sikeresen archiváltál %m1% témát",
	"MSG_UNARCHIVE_SUCCESSFUL"      => "Sikeresen aktiváltál %m1% témát",
	"MSG_DELETE_SUCCESSFUL"         => "Sikeresen töröltél %m1% témát",
	"USER_MESSAGE_EXEMPT"         			=> "A felhasználó %m1% kihagyva az üzenetekből",
	"MSG_MK_READ"		=> "Olvasott",
	"MSG_MK_UNREAD"	=> "Olvasatlan",
	"MSG_ARC_THR"		=> "Kiválasztott témák archiválása",
	"MSG_UN_THR"		=> "Kiválasztott témák aktiválása",
	"MSG_DEL_THR"		=> "Kiválasztott témák törlése",
	"MSG_SEND"			=> "Üzenet Küldése",
));

//Two Factor Authentication
$lang = array_merge($lang, array(
    "2FA"                                => "Kétfaktoros hitelesítés",
    "2FA_CONF"                           => "Biztosan ki szeretné kapcsolni a kétfaktoros hitelesítést? Fiókja ezután már nem lesz védett.",
    "2FA_SCAN"                           => "Olvassa be ezt a QR-kódot a hitelesítő alkalmazásával, vagy írja be a kulcsot",
    "2FA_THEN"                           => "Ezután írja be ide az egyszer használatos jelszavai egyikét",
    "2FA_FAIL"                           => "Probléma merült fel a kétfaktoros hitelesítés ellenőrzése során. Kérjük, ellenőrizze az internetkapcsolatot, vagy lépjen kapcsolatba a támogatással.",
    "2FA_CODE"                           => "Kétfaktoros hitelesítési kód",
    "2FA_EXP"                            => "1 ujjlenyomat lejárt",
    "2FA_EXPD"                           => "Lejárt",
    "2FA_EXPS"                           => "Lejár",
    "2FA_ACTIVE"                         => "Aktív munkamenetek",
    "2FA_NOT_FN"                         => "Nem található ujjlenyomat",
    "2FA_FP"                             => "Ujjlenyomatok",
    "2FA_NP"                             => "Bejelentkezés sikertelen - A kétfaktoros hitelesítési kód hiányzott. Kérjük, próbálja újra.",
    "2FA_INV"                            => "Bejelentkezés sikertelen - A kétfaktoros hitelesítési kód érvénytelen volt. Kérjük, próbálja újra.",
    "2FA_FATAL"                          => "Végzetes hiba - Kérjük, lépjen kapcsolatba a rendszergazdával. Jelenleg nem tudunk kétfaktoros hitelesítési kódot generálni.",
    "2FA_SECTION_TITLE"                  => "Kétfaktoros hitelesítés (TOTP)",
    "2FA_SK_ALT"                         => "Ha nem tudja beolvasni a QR-kódot, írja be ezt a titkos kulcsot manuálisan a hitelesítő alkalmazásába.",
    "2FA_IS_ENABLED"                     => "A kétfaktoros hitelesítés védi a fiókját.",
    "2FA_NOT_ENABLED_INFO"               => "A kétfaktoros hitelesítés jelenleg nincs engedélyezve.",
    "2FA_NOT_ENABLED_EXPLAIN"            => "A kétfaktoros hitelesítés (TOTP) egy extra biztonsági réteget ad a fiókjához azáltal, hogy a jelszaván kívül egy kódot is kér a telefonján lévő hitelesítő alkalmazásból.",
    // Setup Process
    "2FA_SETUP_TITLE"                    => "Kétfaktoros hitelesítés beállítása",
    "2FA_SECRET_KEY_LABEL"               => "Titkos kulcs:",
    "2FA_SETUP_VERIFY_CODE_LABEL"        => "Írja be az ellenőrző kódot az alkalmazásból",
    // Backup Codes
    "2FA_SUCCESS_ENABLED_TITLE"          => "Kétfaktoros hitelesítés engedélyezve! Mentse el a helyreállító kódjait",
    "2FA_SUCCESS_ENABLED_INFO"           => "Az alábbiakban találja a helyreállító kódjait. Tárolja őket biztonságosan - mindegyik csak egyszer használható fel.",
    "2FA_BACKUP_CODES_WARNING"           => "Kezelje ezeket a kódokat jelszóként. Tárolja őket biztonságosan.",
    "2FA_SUCCESS_BACKUP_REGENERATED"     => "Új helyreállító kódok generálva. Mentse el őket biztonságosan.",
    "2FA_BACKUP_CODE_LABEL"              => "Helyreállító kód",
    "2FA_REGEN_CODES_BTN"                => "Helyreállító kódok újragenerálása",
    "2FA_INVALIDATE_WARNING"             => "Ez érvényteleníti az összes meglévő helyreállító kódot. Biztos benne?",
    // Authentication
    "2FA_CODE_LABEL"                     => "Hitelesítési kód",
    "2FA_VERIFY_BTN"                     => "Ellenőrzés és bejelentkezés",
    "2FA_VERIFY_TITLE"                   => "Kétfaktoros hitelesítés szükséges",
    "2FA_VERIFY_INFO"                    => "Írja be a 6 számjegyű kódot a hitelesítő alkalmazásából.",
    // Actions & Buttons
    "2FA_ENABLE_BTN"                     => "Kétfaktoros hitelesítés engedélyezése",
    "2FA_DISABLE_BTN"                    => "Kétfaktoros hitelesítés kikapcsolása",
    "2FA_VERIFY_ACTIVATE_BTN"            => "Ellenőrzés és aktiválás",
    "2FA_CANCEL_SETUP_BTN"               => "Beállítás megszakítása",
    "2FA_DONE_BTN"                       => "Kész",
    // Success Messages
    "REDIR_2FA_DIS"                      => "A kétfaktoros hitelesítés ki lett kapcsolva.",
    "2FA_SUCCESS_BACKUP_ACK"             => "A helyreállító kódok tudomásul véve.",
    "2FA_SUCCESS_SETUP_CANCELLED"        => "A beállítás megszakítva.",
    // Error Messages
    "2FA_ERR_INVALID_BACKUP"             => "Érvénytelen helyreállító kód. Kérjük, próbálja újra.",
    "2FA_ERR_DISABLE_FAILED"             => "A kétfaktoros hitelesítés kikapcsolása sikertelen.",
    "2FA_ERR_NO_SECRET"                  => "A hitelesítési titok nem kérhető le. Kérjük, próbálja újra.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"     => "A helyreállító kód ellenőrizve, de az érvénytelenítés sikertelen. Kérjük, lépjen kapcsolatba a támogatással.",
    "2FA_ERR_NO_CODE_PROVIDED"           => "Nincs hitelesítési kód megadva.",
    "RATE_LIMIT_LOGIN"                   => "Túl sok sikertelen bejelentkezési próbálkozás. Kérjük, várjon, mielőtt újra próbálkozna.",
    "RATE_LIMIT_TOTP"                    => "Túl sok helytelen hitelesítési kód. Kérjük, várjon, mielőtt újra próbálkozna.",
    "RATE_LIMIT_PASSKEY"                 => "Túl sok jelszókulcsos hitelesítési próbálkozás. Kérjük, várjon, mielőtt újra próbálkozna.",
    "RATE_LIMIT_PASSKEY_STORE"           => "Túl sok jelszókulcs regisztrációs próbálkozás. Kérjük, várjon, mielőtt újra próbálkozna.",
    "RATE_LIMIT_PASSWORD_RESET"          => "Túl sok jelszó-visszaállítási kérelem. Kérjük, várjon, mielőtt újat kérne.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT"   => "Túl sok jelszó-visszaállítási próbálkozás. Kérjük, várjon, mielőtt újra próbálkozna.",
    "RATE_LIMIT_REGISTRATION"            => "Túl sok regisztrációs próbálkozás. Kérjük, várjon, mielőtt újra próbálkozna.",
    "RATE_LIMIT_EMAIL_VERIFICATION"      => "Túl sok e-mail ellenőrzési kérelem. Kérjük, várjon, mielőtt újat kérne.",
    "RATE_LIMIT_EMAIL_CHANGE"            => "Túl sok e-mail cím módosítási kérelem. Kérjük, várjon, mielőtt újra próbálkozna.",
    "RATE_LIMIT_PASSWORD_CHANGE"         => "Túl sok jelszóváltoztatási próbálkozás. Kérjük, várjon, mielőtt újra próbálkozna.",
    "RATE_LIMIT_GENERIC"                 => "Túl sok próbálkozás. Kérjük, várjon, mielőtt újra próbálkozna.",
));


$lang = array_merge($lang, array(
	"REDIR_2FA"						=> "Sajnos a kétfaktoros hitelesítés nincs engedélyezve.",
	"REDIR_2FA_EN"				=> "Kétfaktoros Hitelesítés Engedélyezve",
	"REDIR_2FA_DIS"				=> "Kétfaktoros Hitelesítés Letiltva",
	"REDIR_2FA_VER"				=> "Kétfaktoros Hitelesítés Ellenőrizve és Engedélyezve",
	"REDIR_SOMETHING_WRONG" => "Valami baj történt. Kérlek próbáld újra.",
	"REDIR_MSG_NOEX"			=> "A téma nem hozzád tartozik vagy nem létezik.",
	"REDIR_UN_ONCE"				=> "A felhasználónév már megváltozott egyszer.",
	"REDIR_EM_SUCC"				=> "E-mail Sikeresen Frissítve",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "Bejelentkezés itt:",
	"EML_FEATURE_DISABLED" => "Ez a funkció letiltva van",
	"EML_PASSWORDLESS_SENT" => "Kérjük, ellenőrizze e-mailját a bejelentkezési hivatkozásért.",
	"EML_PASSWORDLESS_SUBJECT" => "Kérjük, erősítse meg e-mailcímét a bejelentkezéshez.",
	"EML_PASSWORDLESS_BODY" => "Kérjük, erősítse meg e-mailcímét az alábbi hivatkozásra kattintva. Automatikusan bejelentkezik.",

	"EML_CONF"			=> "E-mail megerősítése",
	"EML_VER"				=> "Hitelesítsd az e-mail címed",
	"EML_CHK"				=> "Hitelesítő e-mail kiküldve. Kérlek ellenőrizd a megadott e-mail fiókot és kövesd a hitelesítési igazolást tartalmazó üzenet utasításait. Ha nem találod elsőre a levelet győződj meg róla, hogy ellenőrizted a Spam és a Junk mappákat is. A hitelesítési hivatkozás lejárati ideje: ",
	"EML_MAT"				=> "Az e-mail címed nem egyezik.",
	"EML_HELLO"			=> "Üdvözöllek ",
	"EML_HI"				=> "Üdv ",
	"EML_AD_HAS"		=> "Az adminisztrátor visszaállította a jelszavad.",
	"EML_AC_HAS"		=> "Az adminisztrátor létrehozta fiókod.",
	"EML_REQ"				=> "Be kell állítanod az új jelszavad a fenti hivatkozás segítségével.",
	"EML_EXP"				=> "Kérlek, vedd figyelembe, hogy a jelszó hivatkozás lejárati ideje: ",
	"EML_VER_EXP"		=> "Kérlek, vedd figyelembe, hogy a hitelesítő hivatkozás lejárati ideje: ",
	"EML_CLICK"			=> "Kattints ide a bejelentkezéshez.",
	"EML_REC"				=> "A következő bejelentkezéskor érdemes megváltoztatni a jelszavad.",
	"EML_MSG"				=> "Új üzeneted érkezett tőle: ",
	"EML_REPLY"			=> "Kattints ide a téma megválaszolásához vagy megtekintéséhez",
	"EML_WHY"				=> "Ezt az e-mailt kapod, mert kérés érkezett a jelszavad visszaállítására. Ha ezt nem te kezdeményezted, akkor figyelmen kívül hagyhatod ezt az e-mailt.",
	"EML_HOW"				=> "Ha te kezdeményezted a folyamatot, kattints az alábbi hivatkozásra a jelszó-visszaállítási folyamat folytatásához.",
	"EML_EML"				=> "A felhasználói fiókodból indítottak egy e-mail megváltoztatására irányuló kérelmet.",
	"EML_VER_EML"		=> "Köszönjük, hogy regisztráltál. Miután megerősítetted az e-mail címed, készen állsz a bejelentkezésre! Kérlek, kattints az alábbi hivatkozásra az e-mail címed ellenőrzéséhez.",
));

//Verification
$lang = array_merge($lang, array(
	"VER_SUC"			=> "E-mail hitelesítése megtörtént!",
	"VER_FAIL"		=> "Nem tudtuk hitelesíteni az e-mail címed. Kérlek próbáld újra.",
	"VER_RESEND"	=> "Hitelesítő e-mail újraküldése",
	"VER_AGAIN"		=> "Add meg az e-mail címed, és próbáld újra",
	"VER_PAGE"		=> "<li>Ellenőrizd az e-mail címed, és kattints a kapott hivatkozásra</li><li>Kész</li>",
	"VER_RES_SUC" => " A hitelesítő hivatkozást elküldtük az e-mail címedre.  A hitelesítés befejezéséhez kattints az e-mailben található hivatkozásra. Nézd meg a Spam vagy Junk mappákat is, ha az e-mailt nem találod a postafiókodban.  A hitelesítő hivatkozás lejárati ideje: ",
	"VER_OOPS"		=> "Hoppá... valami baj van, előfordulhat, hogy egy régi hivatkozásra kattintottál. Kattints az alábbi gombra, és próbáld újra",
	"VER_RESET"		=> "Új jelszó lett beállítva a fiókodhoz!",
	"VER_INS"			=> "<li>Add meg az e-mail címed, majd kattints a Visszaállítás gombra</li> <li>Ellenőrizd az e-mail címed, és kattints a kapott hivatkozásra.</li>
												<li>Kövesd a képernyőn megjelenő utasításokat</li>",
	"VER_SENT"		=> " Az új jelszó megadásához szükséges hivatkozást elküldtük az e-mail címedre. 
			    							 Kattinst a levélben található hivatkozásra új jelszó beállításához. Nézd meg a Spam vagy Junk mappákat is, ha az e-mailt nem találod a postafiókodban.  A jelszó visszaállító hivatkozás lejárati ideje ",
	"VER_PLEASE"	=> "Kérlek, állíts be új jelszót",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"				=> "PIN visszaállítás",
	"SET_WHY"				=> "Miért nem tudom ezt megváltoztatni?",
	"SET_PW_MATCH"	=> "Meg kell egyeznie az új jelszóval",

	"SET_PIN_NEXT"	=> "Új PIN-kódot állíthatsz be a következő hitelesítéskor",
	"SET_UPDATE"		=> "Frissítsd felhasználói beállításaid",
	"SET_NOCHANGE"	=> "Az adminisztrátor letiltotta a felhasználónevek módosítását.",
	"SET_ONECHANGE"	=> "Az adminisztrátor letiltotta a felhasználónevek többszöri módosítását és te már egyszer módosítottad azt.",

	"SET_GRAVITAR"	=> "Szeretnéd megváltoztatni a profilképed?  <br> Látogass el ide <a href='https://hu.gravatar.com/'>https://hu.gravatar.com/</a> és regisztrálj be egy fiókot ugyanazzal az e-mail címmel, amit ezen a webhelyen is használsz. Gyors és egyszerű!",

	"SET_NOTE1"			=> " Kérlek vedd figyelembe,  hogy függőben van egy kérés az e-mail címed megváltoztatásához a következőre: ",

	"SET_NOTE2"			=> ".  Kérlek, használd a hitelesítő e-mailt a folyamat befejezéséhez. 
		 Ha új hitelesítő e-mailt szeretnél, írd be újra a fenti e-mail címet, és küldd el újra a kérést. ",

	"SET_PW_REQ" 		=> " e-mail vagy jelszó megváltoztatásához, PIN-kód visszaállításához szükséges",
	"SET_PW_REQI" 	=> "Muszáj megváltoztatnod a jelszavadat",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "Nem sikerült leállítani az aktív munkameneteket, Hiba: ",
	"ERR_EMAIL"				=> "NEM tudtuk elküldeni az e-mailt egy hiba miatt. Kérlek, fordulj a webhely adminisztrátorához.",
	"ERR_EM_DB"				=> "Ez az e-mail nem létezik adatbázisunkban",
	"ERR_TC"					=> "Kérlek, olvasd el és fogadd el a felhasználási feltételeket",
	"ERR_CAP"					=> "Nem sikerült a Captcha teszt, robot!",
	"ERR_PW_SAME"			=> "A régi jelszó nem lehet ugyanaz, mint az új",
	"ERR_PW_FAIL"			=> "Nem sikerült a jelenlegi jelszó ellenőrzése. Sikertelen módosítás. Kérlek próbáld újra.",
	"ERR_GOOG"				=> "MEGJEGYZÉS:  Ha eredetileg a Google vagy Facebook fiókoddal regisztráltál, akkor a jelszó megváltoztatásához az elfelejtett jelszó linket kell használnod ... kivéve, ha jól tudsz tippelni.",
	"ERR_EM_VER"			=> "Az e-mail hitelesítése nem engedélyezett. Kérlek, fordulj az adminisztrátorhoz.",
	"ERR_EMAIL_STR"		=> "Valami furcsa. Kérlek, hitelesítsd újra az e-mail címed. Elnézést a kellemetlenségért!",
));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "Hamarosan visszajövünk!",
	"MAINT_MSG"			=> "Elnézést a kellemetlenségért, jelenleg karbantartást végzünk.<br> Hamarosan visszajövünk!",
	"MAINT_BAN"			=> "Sajnálom. Ki lettél tiltva a webhelyről. Ha úgy érzed, ez hiba, kérlek, fordulj az adminisztrátorhoz.",
	"MAINT_TOK"			=> "Hiba történt az űrlap elküldésekor. Kérlek, próbáld újra és vedd figyelembe, hogy az űrlap újraküldése az oldal frissítésével hibát okoz. Ha ez továbbra is fennáll, fordulj az adminisztrátorhoz.",
	"MAINT_OPEN"		=> "Egy nyílt forráskódú PHP alapú Felhasználó-kezelő Keretrendszer",
	"MAINT_PLEASE"	=> "Sikeresen telepítetted a UserSpice-t! <br> Az első lépések megtételében sokat segít az alábbi webhely: "
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
	"DAT_SEARCH"    => "Keresés",
	"DAT_FIRST"     => "Első",
	"DAT_LAST"      => "Utolsó",
	"DAT_NEXT"      => "Következő",
	"DAT_PREV"      => "Előző",
	"DAT_NODATA"        => "Nincs rendelkezésre álló adat a táblázatban",
	"DAT_INFO"          => "_START_ - _END_ összesen _TOTAL_ találat",
	"DAT_ZERO"          => "0 - 0 összesen 0 találat",
	"DAT_FILTERED"      => "(szűrve _MAX_ találatból)",
	"DAT_MENU_LENG"     => "_MENU_ találat",
	"DAT_LOADING"       => "Betöltés...",
	"DAT_PROCESS"       => "Feldolgozás...",
	"DAT_NO_REC"        => "Nem található megfelelő rekord",
	"DAT_ASC"           => "Aktiváld az oszlop növekvő sorba rendezéséhez",
	"DAT_DESC"          => "Aktiváld az oszlop csökkenő sorba rendezéséhez",
));

//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
