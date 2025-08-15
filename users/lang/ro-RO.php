<?php
/*
Do not put any content above the opening PHP tag
TO CREATE A NEW LANGUAGE, COPY THE en-us.php to your own localization code name.
We are going to keep these files in the iso xx-xx format because that will also
allow us to autoformat numbers on the sites.

PLEASE put your name somewhere at the top of the language file so we can get in touch with
you to update it and thank you for your hard work!

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
$lang = array_merge($lang, array(
	"THIS_LANGUAGE"	=> "Română",
	"THIS_CODE"			=> "ro-RO",
	"MISSING_TEXT"	=> "Textul lipsa",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"    => "Introduceți codul trimis pe e-mail",
    "PASS_EMAIL_ONLY"    => "Vă rugăm să verificați e-mailul pentru link-ul de autentificare.",
    "PASS_CODE_ONLY"     => "Vă rugăm să introduceți codul trimis pe e-mail.",
    "PASS_BOTH"          => "Vă rugăm să verificați e-mailul pentru link-ul de autentificare sau să introduceți codul trimis pe e-mail.",
    "PASS_VER_BUTTON"    => "Verifică codul",
    "PASS_EMAIL_ONLY_MSG" => "Vă rugăm să verificați adresa de e-mail făcând clic pe link-ul de mai jos.",
    "PASS_CODE_ONLY_MSG"  => "Vă rugăm să introduceți codul de mai jos pentru autentificare.",
    "PASS_BOTH_MSG"       => "Vă rugăm să verificați adresa de e-mail făcând clic pe link-ul de mai jos sau să introduceți codul de mai jos pentru autentificare.",
    "PASS_YOUR_CODE"      => "Codul dumneavoastră de verificare este: ",
    "PASS_CONFIRM_LOGIN"  => "Confirmă Autentificarea",
    "PASS_CONFIRM_CLICK"  => "Click pentru Finalizarea Autentificării",
    "PASS_GENERIC_ERROR"  => "A apărut o eroare.",
));

//Database Menus
$lang = array_merge($lang, array(
	"MENU_HOME"			=> "Acasa",
	"MENU_HELP"			=> "Ajutor",
	"MENU_ACCOUNT"	=> "Cont",
	"MENU_DASH"			=> "Admin Tabloul de bord",
	"MENU_USER_MGR"	=> "Gestionarea utilizatorilor",
	"MENU_PAGE_MGR"	=> "Administrare paginii",
	"MENU_PERM_MGR"	=> "Gestionarea permiselor",
	"MENU_MSGS_MGR"	=> "Mesaje manager",
	"MENU_LOGS_MGR"	=> "urnale de sistem",
	"MENU_LOGOUT"		=> "Deconectare",
));

// Signup
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"			=> "Registrare",
	"SIGNUP_BUTTONTEXT"		=> "Registraz-ma",
	"SIGNUP_AUDITTEXT"		=> "Inregistrat",
));

// Signin
$lang = array_merge($lang, array(
	"SIGNIN_FORGOTPASS"	=> "Ați uitat parola",
	"SIGNIN_FAIL"				=> "** CONECTARE NEREUSITA**",
	"SIGNIN_PLEASE_CHK" => "Verificați numele de utilizator și parola, și încercați din nou",
	"SIGNIN_UORE"				=> "Nume de utilizator sau email",
	"SIGNIN_PASS"				=> "Parola",
	"SIGNIN_TITLE"			=> "Va rugam sa va logati",
	"SIGNIN_TEXT"				=> "Logare",
	"SIGNOUT_TEXT"			=> "Deconectați-vă",
	"SIGNIN_BUTTONTEXT"	=> "Logare",
	"SIGNIN_REMEMBER"		=> "Amintește-ți de mine",
	"SIGNIN_AUDITTEXT"	=> "Conectat",
	"SIGNOUT_AUDITTEXT"	=> "Delogat",
));

// Account Page
$lang = array_merge($lang, array(
	"ACCT_EDIT"					=> "Editați informațiile despre cont",
	"ACCT_2FA"					=> "Gestionați doi factori de autentificare",
	"ACCT_SESS"					=> "Gestionați sesiunile",
	"ACCT_HOME"					=> "Acasa cont",
	"ACCT_SINCE"				=> "Membru din",
	"ACCT_LOGINS"				=> "Numărul de conectări",
	"ACCT_SESSIONS"			=> "Numărul de sesiuni active",
	"ACCT_MNG_SES"			=> "Faceți clic pe butonul Gestionați sesiunile din bara laterală stângă pentru mai multe informații.",
));

//General Terms
$lang = array_merge($lang, array(
	"GEN_ENABLED"			=> "Activat",
	"GEN_DISABLED"		=> "Invalid",
	"GEN_ENABLE"			=> "Permite",
	"GEN_DISABLE"			=> "Dezactivați",
	"GEN_NO"					=> "Nu",
	"GEN_YES"					=> "Da",
	"GEN_MIN"					=> "mic",
	"GEN_MAX"					=> "maxim",
	"GEN_CHAR"				=> "caracter", //as in characters
	"GEN_SUBMIT"			=> "Executa",
	"GEN_MANAGE"			=> "Administra",
	"GEN_VERIFY"			=> "Verifica",
	"GEN_SESSION"			=> "Sesiune",
	"GEN_SESSIONS"		=> "Sesiuni",
	"GEN_EMAIL"				=> "E-mail",
	"GEN_FNAME"				=> "Nume",
	"GEN_LNAME"				=> "Prenume",
	"GEN_UNAME"				=> "Utilizator",
	"GEN_PASS"				=> "Parola",
	"GEN_MSG"					=> "Mesaj",
	"GEN_TODAY"				=> "Astăzi",
	"GEN_CLOSE"				=> "Închide",
	"GEN_CANCEL"			=> "Anulare",
	"GEN_CHECK"				=> "[ bifați / debifați toate ]",
	"GEN_WITH"				=> "cu",
	"GEN_UPDATED"			=> "actualizare",
	"GEN_UPDATE"			=> "Actualizați",
	"GEN_BY"					=> "de",
	"GEN_FUNCTIONS"		=> "Funcţii",
	"GEN_NUMBER"			=> "număr",
	"GEN_NUMBERS"			=> "numerele",
	"GEN_INFO" => "Informatie",
	"GEN_REC" => "Inregistrate",
	"GEN_DEL" => "Sterge",
	"GEN_NOT_AVAIL" => "Nu e disponibil",
	"GEN_AVAIL" => "Disponibil",
	"GEN_BACK" => "Inapoi",
	"GEN_RESET" => "Restabili",
	"GEN_REQ" => "necesar",
	"GEN_AND" => "si",
	"GEN_SAME" => "trebuie sa fie la fel",
));

// Passkey Translations
$lang = array_merge($lang, array(
    "GEN_PASSKEY"           => "Cheie de acces",
    "GEN_ACTIONS"           => "Acțiuni",
    "GEN_BACK_TO_ACCT"      => "Înapoi la cont",
    "GEN_DB_ERROR"          => "A apărut o eroare de bază de date. Te rugăm să încerci din nou.",
    "GEN_IMPORTANT"         => "Important",
    "GEN_NO_PERMISSIONS"    => "Nu ai permisiunea de a accesa această pagină.",
    "GEN_NO_PERMISSIONS_MSG" => "Nu ai permisiunea de a accesa această pagină. Dacă crezi că aceasta este o eroare, te rugăm să contactezi administratorul site-ului.",
    "PASSKEYS_MANAGE_TITLE" => "Gestionează cheile de acces",
    "PASSKEYS_LOGIN_TITLE"  => "Autentificare cu cheie de acces",
    "PASSKEY_DELETE_SUCCESS" => "Cheie de acces ștearsă cu succes.",
    "PASSKEY_DELETE_FAIL_DB" => "Nu s-a putut șterge cheia de acces din baza de date.",
    "PASSKEY_DELETE_NOT_FOUND" => "Cheia de acces nu a fost găsită sau nu ai permisiunea de a o șterge.",
    "PASSKEY_NOTE_UPDATE_SUCCESS" => "Notiță pentru cheia de acces actualizată cu succes.",
    "PASSKEY_NOTE_UPDATE_FAIL" => "Nu s-a putut actualiza notița pentru cheia de acces.",
    "PASSKEY_REGISTER_NEW"  => "Înregistrează o nouă cheie de acces",
    "PASSKEY_ERR_LIMIT_REACHED" => "Ai atins limita maximă de 10 chei de acces.",
    "PASSKEY_NOTE_TH"       => "Notiță cheie de acces",
    "PASSKEY_TIMES_USED_TH" => "Număr utilizări",
    "PASSKEY_LAST_USED_TH"  => "Ultima utilizare",
    "PASSKEY_LAST_IP_TH"    => "Ultimul IP",
    "PASSKEY_EDIT_NOTE_BTN" => "Editează notița",
    "PASSKEY_CONFIRM_DELETE_JS" => "Ești sigur că vrei să ștergi această cheie de acces?",
    "PASSKEY_EDIT_MODAL_TITLE" => "Editează notița cheii de acces",
    "PASSKEY_EDIT_MODAL_LABEL" => "Notiță cheie de acces",
    "PASSKEY_SAVE_CHANGES_BTN" => "Salvează modificările",
    "PASSKEY_NONE_REGISTERED" => "Nu ai nicio cheie de acces înregistrată încă.",
    "PASSKEY_MUST_REGISTER_FIRST" => "Trebuie să înregistrezi mai întâi o cheie de acces dintr-un cont autentificat înainte de a utiliza această funcție.",
    "PASSKEY_STORING"       => "Se stochează cheia de acces...",
    "PASSKEY_STORED_SUCCESS" => "Cheie de acces stocată cu succes!",
    "PASSKEY_INVALID_ACTION" => "Acțiune invalidă: ",
    "PASSKEY_NO_ACTION_SPECIFIED" => "Nicio acțiune specificată",
    "PASSKEY_ERR_NETWORK_SUGGESTION" => "A fost detectată o problemă de rețea. Încearcă o altă rețea sau reîmprospătează pagina.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "A fost detectată autentificarea între dispozitive. Asigură-te că ambele dispozitive au acces la internet.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "Încearcă să deschizi această pagină direct pe telefonul tău.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED" => "Nu s-a putut genera diagnosticul: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA" => "Lipsesc datele de acreditare necesare pentru stocare.",
    "PASSKEY_MISSING_AUTH_DATA" => "Lipsesc datele de autentificare necesare.",
    "PASSKEY_LOG_NO_MESSAGE" => "Fără mesaj",
    "PASSKEY_USER_NOT_FOUND" => "Utilizatorul nu a fost găsit după validarea cheii de acces.",
    "PASSKEY_FATAL_ERROR"    => "Eroare fatală: ",
    "PASSKEY_LOGIN_SUCCESS"  => "Autentificare reușită.",
    "PASSKEY_CROSS_DEVICE_PREP" => "Se pregătește înregistrarea între dispozitive. Este posibil să fie nevoie să folosești telefonul sau tableta.",
    "PASSKEY_DEVICE_REGISTRATION" => "Se utilizează înregistrarea cheii de acces pe dispozitiv...",
    "PASSKEY_STARTING_REGISTRATION" => "Se inițiază înregistrarea cheii de acces...",
    "PASSKEY_REQUEST_OPTIONS" => "Se solicită opțiuni de înregistrare de la server...",
    "PASSKEY_FOLLOW_PROMPTS" => "Urmează instrucțiunile pentru a crea cheia ta de acces. Este posibil să fie nevoie să folosești un alt dispozitiv.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE" => "Urmează instrucțiunile pentru a crea cheia ta de acces...",
    "PASSKEY_CREATION_FAILED" => "Crearea cheii de acces a eșuat - nu s-a returnat nicio acreditare.",
    "PASSKEY_STORING_SERVER" => "Se stochează cheia ta de acces...",
    "PASSKEY_CREATED_SUCCESS" => "Cheie de acces creată cu succes!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP" => "Se pregătește autentificarea între dispozitive. Asigură-te că telefonul și computerul au acces la internet.",
    "PASSKEY_DEVICE_AUTH"    => "Se utilizează autentificarea cheii de acces pe dispozitiv...",
    "PASSKEY_STARTING_AUTH"  => "Se inițiază autentificarea cheii de acces...",
    "PASSKEY_QR_CODE_INSTRUCTION" => "Scanează codul QR cu telefonul când apare. Asigură-te că ambele dispozitive au acces la internet.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION" => "Alege „Folosește un telefon sau o tabletă” când ți se solicită, apoi scanează codul QR.",
    "PASSKEY_AUTHENTICATING" => "Se autentifică cu cheia ta de acces...",
    "PASSKEY_SUCCESS_REDIRECTING" => "Autentificare reușită! Se redirecționează...",
    "PASSKEY_TIMEOUT_CROSS_DEVICE" => "Înregistrarea a expirat. Pentru dispozitive multiple: 1) Încearcă din nou, 2) Asigură-te că dispozitivele au acces la internet, 3) Ia în considerare înregistrarea direct pe telefonul tău.",
    "PASSKEY_TIMEOUT_SIMPLE" => "Înregistrarea a expirat. Te rugăm să încerci din nou.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE" => "Autentificarea între dispozitive a expirat. Depanare: 1) Ambele dispozitive au nevoie de internet, 2) Încearcă să scanezi codul QR mai rapid, 3) Ia în considerare utilizarea aceluiași dispozitiv, 4) Unele rețele blochează autentificarea între dispozitive.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE" => "Autentificarea a expirat. Te rugăm să încerci din nou.",
    "PASSKEY_NO_CREDENTIAL"  => "Nu s-a primit nicio acreditare. Se reîncearcă...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL" => "Autentificarea a eșuat - nu s-a returnat nicio acreditare.",
    "PASSKEY_ATTEMPT_RETRY"  => "a eșuat. Se reîncearcă... (%d încercări rămase)",
    "PASSKEY_CROSS_DEVICE_FAILED" => "Înregistrarea între dispozitive a eșuat. Încearcă: 1) Asigură-te că ambele dispozitive au acces la internet, 2) Ia în considerare înregistrarea direct pe telefonul tău, 3) Unele rețele corporative blochează această funcție.",
    "PASSKEY_REGISTRATION_CANCELLED" => "Înregistrarea a fost anulată sau dispozitivul nu acceptă chei de acces.",
    "PASSKEY_NOT_SUPPORTED"  => "Cheile de acces nu sunt suportate pe această combinație de dispozitiv/browser.",
    "PASSKEY_SECURITY_ERROR" => "Eroare de securitate - aceasta indică de obicei o nepotrivire de domeniu/origine.",
    "PASSKEY_ALREADY_EXISTS" => "Există deja o cheie de acces pentru acest cont pe acest dispozitiv. Încearcă să folosești un alt dispozitiv sau șterge mai întâi cheile de acces existente.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED" => "Autentificarea între dispozitive a eșuat. Încearcă: 1) Asigură-te că ambele dispozitive au internet stabil, 2) Folosește aceeași rețea WiFi dacă este posibil, 3) Încearcă să te autentifici direct pe telefonul tău, 4) Unele rețele corporative blochează această funcție.",
    "PASSKEY_AUTH_CANCELLED" => "Autentificarea a fost anulată sau nu a fost selectată nicio cheie de acces.",
    "PASSKEY_NETWORK_ERROR"  => "Eroare de rețea. Pentru autentificarea între dispozitive, ambele dispozitive au nevoie de acces la internet și ar putea fi necesar să fie în aceeași rețea.",
    "PASSKEY_CREDENTIAL_NOT_FOUND" => "Autentificarea a eșuat - acreditarea nu a fost recunoscută.",
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "Sfaturi pentru autentificarea între dispozitive:",
    "PASSKEY_GUIDANCE_INTERNET" => "Asigură-te că atât computerul, cât și telefonul tău au acces la internet",
    "PASSKEY_GUIDANCE_WIFI"  => "Conectarea la aceeași rețea WiFi poate ajuta (dar nu este întotdeauna necesară)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE" => "Când ți se solicită, selectează „Folosește un telefon sau o tabletă”",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY" => "Scanează codul QR rapid când apare",
    "PASSKEY_GUIDANCE_TRY_DIRECT" => "Dacă eșuează, încearcă să reîmprospătezi și să folosești browserul telefonului tău direct",
    "PASSKEY_SHOW_TROUBLESHOOTING" => "Afișează sfaturi de depanare",
    "PASSKEY_HIDE_TROUBLESHOOTING" => "Ascunde sfaturi de depanare",
    "PASSKEY_DIAGNOSTICS_RUNNING" => "Se rulează diagnosticul...",
    "PASSKEY_DIAGNOSTICS_COMPLETE" => "Diagnostic complet. Verifică consola pentru detalii.",
    "PASSKEY_ISSUES_DETECTED" => "Probleme detectate:",
    "PASSKEY_ENVIRONMENT_SUITABLE" => "Mediul pare potrivit pentru cheile de acces.",
    "PASSKEY_DIAGNOSTICS_FAILED" => "Diagnosticul a eșuat:",
    "PASSKEY_ADD_NOTE_NEW"  => "Adaugă o notiță la noua ta cheie de acces",
    "PASSKEY_BASE64_ERROR"  => "Eroare de decodare Base64:",
    "PASSKEY_INVALID_JSON"  => "Date JSON nevalide primite:",
    "PASSKEY_LOGIN_REQUIRED" => "Trebuie să fii autentificat pentru a efectua această acțiune.",
    "PASSKEY_ACTION_MISSING" => "Parametrul 'acțiune' necesar lipsește din cerere.",
    "PASSKEY_STORAGE_FAILED" => "Nu s-a putut stoca cheia de acces. Operațiunea nu a avut succes.",
    "PASSKEY_LOGIN_FAILED"   => "Autentificarea cu cheia de acces a eșuat. Autentificarea nu a putut fi verificată.",
    "PASSKEY_INVALID_METHOD" => "Metodă de cerere nevalidă:",
    "CSRF_ERROR"            => "Verificarea tokenului CSRF a eșuat. Te rugăm să te întorci și să încerci să trimiți formularul din nou.",
    "PASSKEY_NETWORK_PRIVATE" => "Problemă posibilă: Se pare că ești pe o rețea privată, ceea ce poate interfera uneori cu comunicarea între dispozitive.",
    "PASSKEY_NETWORK_PROXY"  => "Problemă posibilă: A fost detectat un proxy sau VPN. Acest lucru poate interfera cu comunicarea între dispozitive.",
    "PASSKEY_NETWORK_MOBILE" => "Notă: Se pare că ești pe o rețea mobilă. Asigură-te de o conexiune stabilă pentru operațiuni între dispozitive.",
    "PASSKEY_NETWORK_CORPORATE" => "Problemă posibilă: Un firewall corporativ poate fi activ, ceea ce ar putea afecta autentificarea între dispozitive.",
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "Recomandare: Probabil folosești un desktop. Pregătește-te să folosești telefonul pentru a scana un cod QR.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "Recomandare: Pentru cele mai bune rezultate, asigură-te că computerul și dispozitivul mobil sunt pe aceeași rețea Wi-Fi.",
    "PASSKEY_RECOMMENDATION_QR_QUICK" => "Recomandare: Fii pregătit să scanezi codul QR rapid, deoarece cererea poate expira.",
    "PASSKEY_RECOMMENDATION_INTERNET" => "Recomandare: Asigură-te că atât computerul, cât și dispozitivul tău mobil au o conexiune stabilă la internet.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "Recomandare: Pentru WebViews Unity, asigură-te că pagina are suficient timp pentru a se încărca și a procesa cererea cheii de acces.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "Recomandare: Timpii de expirare pot fi mai lungi în Unity. Te rugăm să ai răbdare.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "Recomandare: Deoarece ești pe un dispozitiv mobil, ar trebui să poți înregistra o cheie de acces direct pe acest dispozitiv.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Recomandare: Pe Android, poți gestiona cheile de acces în Managerul de Parole Google.",
    "PASSKEY_VALIDATION_RP_IP" => "Avertisment de configurare: ID-ul părții de încredere este setat la o adresă IP.",
    "PASSKEY_VALIDATION_RP_DOMAIN" => "Recomandare: Setează ID-ul părții de încredere la numele tău de domeniu (de exemplu, website-ul tău.ro) pentru o mai bună securitate și compatibilitate.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED" => "Eroare de configurare: HTTPS este necesar pentru ca cheile de acces să funcționeze pe un server live. Site-ul tău pare să fie pe HTTP.",
    "PASSKEY_VALIDATION_NETWORK" => "Avertisment de rețea",
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "Recomandare: Dacă întâmpini probleme, încearcă o altă rețea (de exemplu, trece de la Wi-Fi corporativ la un hotspot mobil).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "Recomandare: Pentru acțiuni între dispozitive, asigură-te că ambele dispozitive au o conexiune la internet fiabilă.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK" => "Recomandare: Dacă acțiunile între dispozitive eșuează, încearcă să vizitezi această pagină direct pe dispozitivul tău mobil pentru a finaliza acțiunea.",
    "PASSKEY_INFO_TITLE"    => "Despre cheile de acces",
    "PASSKEY_INFO_DESC"     => "Cheile de acces sunt o modalitate sigură și fără parolă de a te autentifica folosind funcțiile de securitate încorporate ale dispozitivului tău, cum ar fi amprenta, recunoașterea facială sau PIN-ul. Sunt mai sigure decât parolele, oferă autentificare mai rapidă, funcționează pe mai multe dispozitive atunci când sunt sincronizate cu managerii de parole și sunt rezistente la atacurile de phishing. Cheile de acces funcționează pe smartphone-uri moderne, tablete, computere și pot fi stocate în manageri de parole precum 1Password, Bitwarden, iCloud Keychain sau Google Password Manager.",
    "PASSKEY_BACK_TO_LOGIN" => "Înapoi la autentificare",
));

//validation class
$lang = array_merge($lang, array(
	"VAL_SAME"				=> "trebuie sa fie la fel",
	"VAL_EXISTS"			=> "deja exista. Alegeți altul",
	"VAL_DB"					=> "Eroare baza de date",
	"VAL_NUM"					=> "trebuie sa fie un numar",
	"VAL_INT"					=> "trebuie să fie un numar întreg",
	"VAL_EMAIL"				=> "trebuie sa fie o adresa de e-mail valida",
	"VAL_NO_EMAIL"		=> "nu poate fi o adresa de e-mail",
	"VAL_SERVER"			=> "trebuie sa apartina unui server valid",
	"VAL_LESS"				=> "trebuie sa fie mai mica decat",
	"VAL_GREAT"				=> "trebuie sa fie mai mare decat",
	"VAL_LESS_EQ"			=> "trebuie sa fie mai mica sau egala cu",
	"VAL_GREAT_EQ"		=> "trebuie sa fie mai mare sau egala cu",
	"VAL_NOT_EQ"			=> "nu trebuie sa fie egal cu",
	"VAL_EQ"					=> "trebuie sa fie egal cu",
	"VAL_TZ"					=> "trebuie sa fie un ora din nume zona",
	"VAL_MUST"				=> "trebuie sa fie",
	"VAL_MUST_LIST"		=> "trebuie sa fie una dintre urmatoarele",
	"VAL_TIME"				=> "trebuie sa fie un ora valabila",
	"VAL_SEL"					=> "nu este o selectie valida",
	"VAL_NA_PHONE"		=> "trebuie sa fie un numar de telefon din Romania valabil",
));

//Time
$lang = array_merge($lang, array(
	"T_YEARS"			=> "Ani",
	"T_YEAR"			=> "An",
	"T_MONTHS"		=> "Luni",
	"T_MONTH"			=> "Lună",
	"T_WEEKS"			=> "Săptămâni",
	"T_WEEK"			=> "Săptămână",
	"T_DAYS"			=> "Zile",
	"T_DAY"				=> "Zi",
	"T_HOURS"			=> "Ore",
	"T_HOUR"			=> "Ora",
	"T_MINUTES"		=> "Minut",
	"T_MINUTE"		=> "Minut",
	"T_SECONDS"		=> "Secunde",
	"T_SECOND"		=> "Secunda",
));


//Passwords
$lang = array_merge($lang, array(
	"PW_NEW"		=> "Parolă Nouă",
	"PW_OLD"		=> "Parola veche",
	"PW_CONF"		=> "Confirma parola",
	"PW_RESET"	=> "Resetare parola",
	"PW_UPD"		=> "Parolă actualizată",
	"PW_SHOULD"	=> "Parolele trebuie să ...",
	"PW_SHOW"		=> "Arata parola",
	"PW_SHOWS"	=> "Afișați parolele",
));


//Join
$lang = array_merge($lang, array(
	"JOIN_SUC"		=> "Bun venit la ",
	"JOIN_THANKS"	=> "Vă mulțumim pentru înregistrare!",
	"JOIN_HAVE"		=> "Cel puțin ",
	"JOIN_LOWER"	=> " Literă mică",
	"JOIN_SYMBOL"		=> " Simbol",
	"JOIN_CAP"		=> " Majusculă",
	"JOIN_TWICE"	=> "Tastat corect de două ori",
	"JOIN_CLOSED"	=> "Din păcate, înregistrarea este dezactivată în acest moment. Contactați administratorul site-ului dacă aveți întrebări sau nelămuriri.",
	"JOIN_TC"			=> "Înregistrare Termeni și condiții pentru utilizatori",
	"JOIN_ACCEPTTC" => "Accept Termeni si conditii pentru utilizatori",
	"JOIN_CHANGED"	=> "Termenii nostri s-au schimbat",
	"JOIN_ACCEPT" 	=> "Acceptati Termenii si conditiile utilizatorului si continuati",
	"JOIN_SCORE" => "Scor:",
	"JOIN_INVALID_PW" => "Parola dvs. este invalidă",

));


//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "S-a distrus cu succes",
));

//Messages
$lang = array_merge($lang, array(
	"MSG_SENT"			=> "Mesajul tau a fost trimis!",
	"MSG_MASS"			=> "Toate mesajele au trimis!",
	"MSG_NEW"				=> "Mesaj nou",
	"MSG_NEW_MASS"	=> "Mesaje noi",
	"MSG_CONV"			=> "Conversaţii",
	"MSG_NO_CONV"		=> "Nici o conversaţie",
	"MSG_NO_ARC"		=> "Nici o conversaţie",
	"MSG_QUEST"			=> "Trimiteți notificarea prin e-mail dacă este activată?",
	"MSG_ARC"				=> "Arhiva subiecte",
	"MSG_VIEW_ARC"	=> "Arată subiectele arhivate",
	"MSG_SETTINGS"  => "Setări de mesaje",
	"MSG_READ"			=> "Citit",
	"MSG_BODY"			=> "Corp",
	"MSG_SUB"				=> "Subiect",
	"MSG_DEL"				=> "Livrat",
	"MSG_REPLY"			=> "Răspuns",
	"MSG_QUICK"			=> "Răspuns rapid",
	"MSG_SELECT"		=> "Selectați un utilizator",
	"MSG_UNKN"			=> "Destinatar necunoscut",
	"MSG_NOTIF"			=> "Mesaje Notificări prin e-mail",
	"MSG_BLANK"			=> "Mesajul nu poate fi gol",
	"MSG_MODAL"			=> "Faceți clic aici sau apăsați pe Alt + R pentru a vă aici SAU apăsați Shift + R pentru a deschide panoul de răspuns extins!",
	"MSG_ARCHIVE_SUCCESSFUL"        => "Ați arhivat cu succes fișierele %m1%",
	"MSG_UNARCHIVE_SUCCESSFUL"      => "Ați dezarhivat cu succes fișierele %m1%",
	"MSG_DELETE_SUCCESSFUL"         => "Ați șters cu succes contul %m1%",
	"USER_MESSAGE_EXEMPT"         			=> "Utilizatorul este% m1% scutit de la mesaje.",
	"MSG_MK_READ" => "Citit",
	"MSG_MK_UNREAD" => "Necitit",
	"MSG_ARC_THR" => "Arhiva selectate Subiecte",
	"MSG_UN_THR" => "Dezarhivati Selectat Subiecte",
	"MSG_DEL_THR" => "Sterge Selectat Subiecte",
	"MSG_SEND" => "Trimite mesaj",
));

// Two Factor Authentication Translations
$lang = array_merge($lang, array(
    "2FA"               => "Autentificare cu doi factori",
    "2FA_CONF"          => "Ești sigur că vrei să dezactivezi autentificarea cu doi factori? Contul tău nu va mai fi protejat.",
    "2FA_SCAN"          => "Scanează acest cod QR cu aplicația ta de autentificare sau introdu cheia",
    "2FA_THEN"          => "Apoi introdu aici una dintre cheile tale de unică folosință",
    "2FA_FAIL"          => "A apărut o problemă la verificarea autentificării cu doi factori. Verifică conexiunea la internet sau contactează suportul.",
    "2FA_CODE"          => "Cod 2FA",
    "2FA_EXP"           => "1 amprentă expirată",
    "2FA_EXPD"          => "Expirat",
    "2FA_EXPS"          => "Expiră",
    "2FA_ACTIVE"        => "Sesiuni active",
    "2FA_NOT_FN"        => "Nu s-au găsit amprente",
    "2FA_FP"            => "Amprente",
    "2FA_NP"            => "Autentificare eșuată. Codul de autentificare cu doi factori nu a fost prezent. Te rugăm să încerci din nou.",
    "2FA_INV"           => "Autentificare eșuată. Codul de autentificare cu doi factori a fost invalid. Te rugăm să încerci din nou.",
    "2FA_FATAL"         => "Eroare fatală. Te rugăm să contactezi administratorul de sistem. Nu putem genera un cod de autentificare cu doi factori în acest moment.",
    "2FA_SECTION_TITLE" => "Autentificare cu doi factori (TOTP)",
    "2FA_SK_ALT"       => "Dacă nu poți scana codul QR, introdu manual această cheie secretă în aplicația ta de autentificare.",
    "2FA_IS_ENABLED"    => "Autentificarea cu doi factori îți protejează contul.",
    "2FA_NOT_ENABLED_INFO" => "Autentificarea cu doi factori nu este activată în prezent.",
    "2FA_NOT_ENABLED_EXPLAIN" => "Autentificarea cu doi factori (TOTP) adaugă un strat suplimentar de securitate contului tău, cerând un cod de la o aplicație de autentificare de pe telefonul tău, pe lângă parolă.",
    "2FA_SETUP_TITLE"  => "Configurare autentificare cu doi factori",
    "2FA_SECRET_KEY_LABEL" => "Cheie secretă:",
    "2FA_SETUP_VERIFY_CODE_LABEL" => "Introdu codul de verificare din aplicație",
    "2FA_SUCCESS_ENABLED_TITLE" => "Autentificare cu doi factori activată! Salvează-ți codurile de rezervă",
    "2FA_SUCCESS_ENABLED_INFO" => "Mai jos sunt codurile tale de rezervă. Păstrează-le în siguranță - fiecare poate fi folosit doar o dată.",
    "2FA_BACKUP_CODES_WARNING" => "Tratează aceste coduri ca pe parole. Păstrează-le în siguranță.",
    "2FA_SUCCESS_BACKUP_REGENERATED" => "Coduri de rezervă noi generate. Păstrează-le în siguranță.",
    "2FA_BACKUP_CODE_LABEL" => "Cod de rezervă",
    "2FA_REGEN_CODES_BTN" => "Regenerează codurile de rezervă",
    "2FA_INVALIDATE_WARNING" => "Aceasta va invalida toate codurile de rezervă existente. Ești sigur?",
    "2FA_CODE_LABEL"    => "Cod de autentificare",
    "2FA_VERIFY_BTN"    => "Verifică și autentifică-te",
    "2FA_VERIFY_TITLE"  => "Autentificare cu doi factori necesară",
    "2FA_VERIFY_INFO"   => "Introdu codul de 6 cifre din aplicația ta de autentificare.",
    "2FA_ENABLE_BTN"    => "Activează autentificarea cu doi factori",
    "2FA_DISABLE_BTN"   => "Dezactivează autentificarea cu doi factori",
    "2FA_VERIFY_ACTIVATE_BTN" => "Verifică și activează",
    "2FA_CANCEL_SETUP_BTN" => "Anulează configurarea",
    "2FA_DONE_BTN"      => "Gata",
    "REDIR_2FA_DIS"     => "Autentificarea cu doi factori a fost dezactivată.",
    "2FA_SUCCESS_BACKUP_ACK" => "Codurile de rezervă au fost confirmate.",
    "2FA_SUCCESS_SETUP_CANCELLED" => "Configurarea a fost anulată.",
    "2FA_ERR_INVALID_BACKUP" => "Cod de rezervă invalid. Te rugăm să încerci din nou.",
    "2FA_ERR_DISABLE_FAILED" => "Nu s-a putut dezactiva autentificarea cu doi factori.",
    "2FA_ERR_NO_SECRET" => "Nu s-a putut recupera secretul de autentificare. Te rugăm să încerci din nou.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL" => "Codul de rezervă a fost verificat, dar nu s-a putut invalida. Te rugăm să contactezi suportul.",
    "2FA_ERR_NO_CODE_PROVIDED" => "Nu a fost furnizat niciun cod de autentificare.",
    "RATE_LIMIT_LOGIN"   => "Prea multe încercări de autentificare eșuate. Te rugăm să aștepți înainte de a încerca din nou.",
    "RATE_LIMIT_TOTP"    => "Prea multe coduri de autentificare incorecte. Te rugăm să aștepți înainte de a încerca din nou.",
    "RATE_LIMIT_PASSKEY" => "Prea multe încercări de autentificare cu cheie de acces. Te rugăm să aștepți înainte de a încerca din nou.",
    "RATE_LIMIT_PASSKEY_STORE" => "Prea multe încercări de înregistrare a cheii de acces. Te rugăm să aștepți înainte de a încerca din nou.",
    "RATE_LIMIT_PASSWORD_RESET" => "Prea multe cereri de resetare a parolei. Te rugăm să aștepți înainte de a solicita o altă resetare.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT" => "Prea multe încercări de resetare a parolei. Te rugăm să aștepți înainte de a încerca din nou.",
    "RATE_LIMIT_REGISTRATION" => "Prea multe încercări de înregistrare. Te rugăm să aștepți înainte de a încerca din nou.",
    "RATE_LIMIT_EMAIL_VERIFICATION" => "Prea multe cereri de verificare a e-mailului. Te rugăm să aștepți înainte de a solicita o altă verificare.",
    "RATE_LIMIT_EMAIL_CHANGE" => "Prea multe cereri de schimbare a e-mailului. Te rugăm să aștepți înainte de a încerca din nou.",
    "RATE_LIMIT_PASSWORD_CHANGE" => "Prea multe încercări de schimbare a parolei. Te rugăm să aștepți înainte de a încerca din nou.",
    "RATE_LIMIT_GENERIC" => "Prea multe încercări. Te rugăm să aștepți înainte de a încerca din nou.",
));


$lang = array_merge($lang, array(
	"REDIR_2FA"					=> "Scuze.Doua factor este nu activat la acest timp",
	"REDIR_2FA_EN"				=> "2 Factor Autentificare Activat",
	"REDIR_2FA_DIS"				=> "2 Factor Autentificare Dezactivat",
	"REDIR_2FA_VER"				=> "2 Factor Autentificare Verificat si Activat",
	"REDIR_SOMETHING_WRONG" => "Ceva a mers greșit. Vă rugăm să încercați din nou.",
	"REDIR_MSG_NOEX"			=> "Asta fir nu nu apartine pentru tine sau nu nu exista",
	"REDIR_UN_ONCE"				=> "Utilizator a fost deja schimbat o dată.",
	"REDIR_EM_SUCC"				=> "E-mail Actualizat cu succes",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "Conectare cu:",
	"EML_FEATURE_DISABLED" => "Această caracteristică este dezactivată",
	"EML_PASSWORDLESS_SENT" => "Vă rugăm să verificați e-mailul pentru un link de autentificare.",
	"EML_PASSWORDLESS_SUBJECT" => "Vă rugăm să verificați e-mailul pentru a vă conecta.",
	"EML_PASSWORDLESS_BODY" => "Vă rugăm să verificați adresa dvs. de e-mail făcând clic pe linkul de mai jos. Veți fi autentificat automat.",

	"EML_CONF"			=> "Confirmați adresa de e-mail",
	"EML_VER"				=> "Verifica-ți email-ul",
	"EML_CHK"				=> "Solicitare de e-mail primită. Verificați e-mailul pentru a efectua verificarea. Asigurați-vă că ați verificat fisierul Spam și Junk, deoarece link-ul de verificare expiră",
	"EML_MAT"				=> "E-mailul dvs. nu se potrivește.",
	"EML_HELLO"			=> "Salutari de la ",
	"EML_HI"				=> "Hi ",
	"EML_AD_HAS"		=> "An Administrator has reset your password.",
	"EML_AC_HAS"		=> "An Administrator has created your account.",
	"EML_REQ"				=> "You will be required to set your password using the link above.",
	"EML_EXP"				=> "Please note, Password links expire in ",
	"EML_VER_EXP"		=> "Please note, Verification links expire in ",
	"EML_CLICK"			=> "Click here to login.",
	"EML_REC"				=> "It is recommended to change your password upon logging in.",
	"EML_MSG"				=> "You have a new message from",
	"EML_REPLY"			=> "Click here to reply or view the thread",
	"EML_WHY"				=> "You are receiving this email because a request was made to reset your password. If this was not you, you may disregard this email.",
	"EML_HOW"				=> "If this was you, click the link below to continue with the password reset process.",
	"EML_EML"				=> "A request to change your email was made from within your user account.",
	"EML_VER_EML"		=> "Thanks for signing up.  Once you verify your email address you will be ready to login! Please click the link below to verify your email address.",
));

//Verification
$lang = array_merge($lang, array(
	"VER_SUC"			=> "E-mail-ul a fost verificat!",
	"VER_FAIL"		=> "Nu am putut verifica contul. Vă rugăm să încercați din nou.",
	"VER_RESEND"	=> "Retrimite email-ul de verificare",
	"VER_AGAIN"		=> "Introduceți adresa de e-mail și încercați din nou",
	"VER_PAGE"		=> "<li>Verificați adresa de e-mail și faceți clic pe link-ul care vi-a fost trimis</li><li>Terminat</li>",
	"VER_RES_SUC" => " Linkul dvs. de verificare a fost trimis la adresa dvs. de e-mail.  Dați clic pe linkul din e-mail pentru a finaliza verificarea. Asigurați-vă că verificați dosarul dvs. de spam dacă e-mailul nu este în căsuța de e-mail.  Link-urile de verificare sunt valabile numai pentru ",
	"VER_OOPS" => "Oops ... ceva a mers prost, poate o legătură de resetare veche pe care ați făcut clic. Faceți clic mai jos pentru a încerca din nou.",
	"VER_RESET" => "Parola ta a fost resetata!",

	"VER_INS" => "<li>Introduceți adresa dvs. de email și apăsați Resetare</li> <li>Verificați-vă emailul și apăsați pe linkul trimis către dvs.</li> <li>Urmați instrucțiunile de pe ecran</li>",

	"VER_SENT" => " Linkul de resetare a parolei a fost trimis la adresa dvs. de email. Apăsați pe linkul din email pentru a vă reseta parola. Asigurați-vă că verificați folderul de spam dacă emailul nu se află în inbox-ul dvs. Linkurile de resetare sunt valabile doar pentru ",

	"VER_PLEASE" => "vă rugăm să vă resetati parola",

));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"				=> "Resetați codul PIN",
	"SET_WHY"				=> "De ce nu pot schimba asta?",
	"SET_PW_MATCH"	=> "Trebuie să se potrivească cu noua parolă",

	"SET_PIN_NEXT"	=> "Puteți stabili un nou cod PIN la următoarea solicitare de verificare",
	"SET_UPDATE"		=> "Actualizați setările de utilizator",
	"SET_NOCHANGE"	=> "Administratorul a dezactivat utilizator.",
	"SET_ONECHANGE"	=> "Administratorul a setat modificările numelui de utilizator să apară o singură dată și ați făcut deja acest lucru.",

	"SET_GRAVITAR"	=> "Doriți să modificați imaginea de profil?  <br> Vizita <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> și configurați un cont cu aceleași adrese de e-mail pe care le-ați utilizat pe acest site. Lucrează pe milioane de site-uri. Este rapid și ușor!",

	"SET_NOTE1"			=> " Vă rugăm să rețineți  există o solicitare în așteptare pentru a vă actualiza adresa de e-mail",

	"SET_NOTE2"			=> ".  Utilizați e-mailul de verificare pentru a finaliza această solicitare. 
		 Dacă aveți nevoie de un nou e-mail de verificare, reintroduceți e-mailul de mai sus și trimiteți din nou solicitarea. ",

	"SET_PW_REQ" 		=> "necesar pentru schimbarea parolei, a e-mailului sau resetarea codului PIN",
	"SET_PW_REQI" 	=> "Este necesar să vă schimbați parola",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "Nu a reușit să se distruga sesiunile active, Eroare: ",
	"ERR_EMAIL"				=> "Emailul nu a fost trimis din cauza erorii. Contactați administratorul site-ului.",
	"ERR_EM_DB"				=> "Acest e-mail nu există în baza noastră de date",
	"ERR_TC"					=> "Vă rugăm să citiți și să acceptați termenii și condițiile",
	"ERR_CAP"					=> "Nu ai reușit testul Captcha, Robot!",
	"ERR_PW_SAME"			=> "Vechea parolă, nu poate fi aceeași cu cea nouă",
	"ERR_PW_FAIL"			=> "Verificarea parolei curentă a eșuat Actualizare esuata. Vă rugăm să încercați din nou.",
	"ERR_GOOG"				=> "NOTĂ:  Dacă v-ați înscris inițial în contul dvs. Google / Facebook, va trebui să utilizați linkul de parolă uitat pentru a vă schimba parola ... cu excepția cazului în care sunteți foarte bun la ghicit.",
	"ERR_EM_VER"			=> "Verificarea e-mailului nu este activată. Contactați administratorul de sistem.",
	"ERR_EMAIL_STR"		=> "Ceva este ciudat. Verificați din nou e-mailul. Ne cerem scuze pentru neplăceri",
));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "Vom reveni in curand!",
	"MAINT_MSG"			=> "Ne pare rau pentru neplacere, dar în prezent efectuam o întretinere.<br> Vom reveni online în curand!",
	"MAINT_BAN" => "Scuze. Ati fost interzis. Daca credeti ca este o eroare, contactati administratorul.",
	"MAINT_TOK" => "A aparut o eroare la formularul dvs. Reveniti si încercati din nou. Rețineți ca trimiterea formularului prin actualizarea paginii va duce la o eroare. Daca acest lucru se întâmpla în continuare, contactati administratorul.",
	"MAINT_OPEN" => "Un cadru de gestionare a utilizatorilor PHP Open Source.",
	"MAINT_PLEASE" => "Ati instalat cu succes UserSpice!<br>Pentru a vedea documentatia noastra de început, va rugam sa vizitati",
));

//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
