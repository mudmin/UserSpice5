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
%m1% - Dymamic markers which are replaced at run time by the relevant index.
*/

$lang = array();
//important strings
$lang = array_merge($lang,array(
"THIS_LANGUAGE"	=>"Română",
"THIS_CODE"			=>"ro-RO",
"MISSING_TEXT"	=>"Textul lipsa",
));
//Database Menus
$lang = array_merge($lang,array(
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
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"			=> "Registrare",
	"SIGNUP_BUTTONTEXT"		=> "Registraz-ma",
	"SIGNUP_AUDITTEXT"		=> "Inregistrat",
	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FORGOTPASS"	=>"Ați uitat parola",
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
$lang = array_merge($lang,array(
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
	$lang = array_merge($lang,array(
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

//validation class
	$lang = array_merge($lang,array(
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
	$lang = array_merge($lang,array(
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
	$lang = array_merge($lang,array(
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
	$lang = array_merge($lang,array(
		"JOIN_SUC"		=> "Bun venit la ",
		"JOIN_THANKS"	=> "Vă mulțumim pentru înregistrare!",
		"JOIN_HAVE"		=> "Cel puțin ",
		"JOIN_CAP"		=> "Majusculă",
		"JOIN_TWICE"	=> "Tastat corect de două ori",
		"JOIN_CLOSED"	=> "Din păcate, înregistrarea este dezactivată în acest moment. Contactați administratorul site-ului dacă aveți întrebări sau nelămuriri.",
		"JOIN_TC"			=> "Înregistrare Termeni și condiții pentru utilizatori",
		"JOIN_ACCEPTTC" => "Accept Termeni si conditii pentru utilizatori",
		"JOIN_CHANGED"	=> "Termenii nostri s-au schimbat",
		"JOIN_ACCEPT" 	=> "Acceptati Termenii si conditiile utilizatorului si continuati",
		));


		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "S-a distrus cu succes",
		));

		//Messages
	$lang = array_merge($lang,array(
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

	//2 Factor Authentication
	$lang = array_merge($lang,array(
		"2FA"				=> "2 factori de autentificare",
		"2FA_CONF"	=> "Sigur doriți să dezactivați 2FA? Contul dvs. nu va mai fi protejat.",
		"2FA_SCAN"	=> "Scanați acest cod QR cu aplicația dvs. de autentificare sau introduceți cheia",
		"2FA_THEN"	=> "Apoi introduceți aici unul dintre parchetele dvs. unice",
		"2FA_FAIL"	=> "A apărut o problemă de verificare a 2FA. Verificați Internetul sau contactați asistența.",
		"2FA_CODE"	=> "Codul 2FA",
		"2FA_EXP"		=> "A expirat o amprentă digitală",
		"2FA_EXPD"	=> "Expirat",
		"2FA_FP"		=> "Amprente",
		"2FA_NP"		=> "<strong>Autentificare esuata</strong> Codul de confirmare nu era prezent. Vă rugăm să încercați din nou.",
		"2FA_INV"		=> "<strong>Autentificare esuata/strong> Codul de confirmare este nevalid. Vă rugăm să încercați din nou.",
		"2FA_FATAL"	=> "<strong>Eroare fatala</strong> Contactați administratorul de problema.",
		"2FA_EXPS" => "Expira",
		"2FA_ACTIVE" => "Sesiuni active",
		"2FA_NOT_FN" => "Nu au fost gasite amprente digitale",
		));

	//Redirect Messages - These get a plus between each word
	$lang = array_merge($lang,array(
		"REDIR_2FA"					=> "Scuze.Doua+factor+este+nu+activat+la+acest+timp",
		"REDIR_2FA_EN"				=> "2+Factor+Autentificare+Activat",
		"REDIR_2FA_DIS"				=> "2+Factor+Autentificare+Dezactivat",
		"REDIR_2FA_VER"				=> "2+Factor+Autentificare+Verificat+si+Activat",
		"REDIR_SOM_TING_WONG" => "Ceva+a+mers+greșit.+Vă+rugăm+să+încercați+din+nou.",
		"REDIR_MSG_NOEX"			=> "Asta+fir+nu+nu+apartine+pentru+tine+sau+nu+nu+exista",
		"REDIR_UN_ONCE"				=> "Utilizator+a+fost+deja+schimbat+o+dată.",
		"REDIR_EM_SUCC"				=> "E-mail+Actualizat+cu+succes",
		));

	//Emails
	$lang = array_merge($lang,array(
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
		$lang = array_merge($lang,array(
			"VER_SUC"			=> "E-mail-ul a fost verificat!",
			"VER_FAIL"		=> "Nu am putut verifica contul. Vă rugăm să încercați din nou.",
			"VER_RESEND"	=> "Retrimite email-ul de verificare",
			"VER_AGAIN"		=> "Introduceți adresa de e-mail și încercați din nou",
			"VER_PAGE"		=> "<li>Verificați adresa de e-mail și faceți clic pe link-ul care vi-a fost trimis</li><li>Terminat</li>",
			"VER_RES_SUC" => "<p>Linkul dvs. de verificare a fost trimis la adresa dvs. de e-mail.</p><p>Dați clic pe linkul din e-mail pentru a finaliza verificarea. Asigurați-vă că verificați dosarul dvs. de spam dacă e-mailul nu este în căsuța de e-mail.</p><p>Link-urile de verificare sunt valabile numai pentru ",
			"VER_OOPS" => "Oops ... ceva a mers prost, poate o legătură de resetare veche pe care ați făcut clic. Faceți clic mai jos pentru a încerca din nou.",
			"VER_RESET" => "Parola ta a fost resetata!",

			"VER_INS" => "<li>Enter your email address and click Reset</li> <li>Check your email and click the link that is sent to you.</li> <li>Follow the on screen instructions</li>",

			"VER_SENT" => "<p>Your password reset link has been sent to your email address.</p> <p>Click the link in the email to Reset your password. Be sure to check your spam folder if the email isn't in your inbox.</p><p>Reset links are only valid for ",

			"VER_PLEASE" => "va rugam sa va resetati parola",
			));

	//User Settings
	$lang = array_merge($lang,array(
		"SET_PIN"				=> "Resetați codul PIN",
		"SET_WHY"				=> "De ce nu pot schimba asta?",
		"SET_PW_MATCH"	=> "Trebuie să se potrivească cu noua parolă",

		"SET_PIN_NEXT"	=> "Puteți stabili un nou cod PIN la următoarea solicitare de verificare",
		"SET_UPDATE"		=> "Actualizați setările de utilizator",
		"SET_NOCHANGE"	=> "Administratorul a dezactivat utilizator.",
		"SET_ONECHANGE"	=> "Administratorul a setat modificările numelui de utilizator să apară o singură dată și ați făcut deja acest lucru.",

		"SET_GRAVITAR"	=> "<strong>Doriți să modificați imaginea de profil? </strong><br> Vizita <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> și configurați un cont cu aceleași adrese de e-mail pe care le-ați utilizat pe acest site. Lucrează pe milioane de site-uri. Este rapid și ușor!",

		"SET_NOTE1"			=> "<p><strong>Vă rugăm să rețineți</strong> există o solicitare în așteptare pentru a vă actualiza adresa de e-mail",

		"SET_NOTE2"			=> ".</p><p>Utilizați e-mailul de verificare pentru a finaliza această solicitare.</p>
		<p>Dacă aveți nevoie de un nou e-mail de verificare, reintroduceți e-mailul de mai sus și trimiteți din nou solicitarea.</p>",

		"SET_PW_REQ" 		=> "necesar pentru schimbarea parolei, a e-mailului sau resetarea codului PIN",
		"SET_PW_REQI" 	=> "Este necesar să vă schimbați parola",

		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"		=> "Nu a reușit să se distruga sesiunile active, Eroare: ",
		"ERR_EMAIL"				=> "Emailul nu a fost trimis din cauza erorii. Contactați administratorul site-ului.",
		"ERR_EM_DB"				=> "Acest e-mail nu există în baza noastră de date",
		"ERR_TC"					=> "Vă rugăm să citiți și să acceptați termenii și condițiile",
		"ERR_CAP"					=> "Nu ai reușit testul Captcha, Robot!",
		"ERR_PW_SAME"			=> "Vechea parolă, nu poate fi aceeași cu cea nouă",
		"ERR_PW_FAIL"			=> "Verificarea parolei curentă a eșuat Actualizare esuata. Vă rugăm să încercați din nou.",
		"ERR_GOOG"				=> "<strong>NOTĂ:</strong> Dacă v-ați înscris inițial în contul dvs. Google / Facebook, va trebui să utilizați linkul de parolă uitat pentru a vă schimba parola ... cu excepția cazului în care sunteți foarte bun la ghicit.",
		"ERR_EM_VER"			=> "Verificarea e-mailului nu este activată. Contactați administratorul de sistem.",
		"ERR_EMAIL_STR"		=> "Ceva este ciudat. Verificați din nou e-mailul. Ne cerem scuze pentru neplăceri",
		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"		=> "Vom reveni in curand!",
		"MAINT_MSG"			=> "Ne pare rau pentru neplacere, dar în prezent efectuam o întretinere.<br> Vom reveni online în curand!",
		"MAINT_BAN" => "Scuze. Ati fost interzis. Daca credeti ca este o eroare, contactati administratorul.",
		"MAINT_TOK" => "A aparut o eroare la formularul dvs. Reveniti si încercati din nou. Rețineți ca trimiterea formularului prin actualizarea paginii va duce la o eroare. Daca acest lucru se întâmpla în continuare, contactati administratorul.",
		"MAINT_OPEN" => "Un cadru de gestionare a utilizatorilor PHP Open Source.",
		"MAINT_PLEASE" => "Ati instalat cu succes UserSpice!<br>Pentru a vedea documentatia noastra de început, va rugam sa vizitati",
		));

		//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
		if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
			include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
		}
 //do not put a closing php tag here
