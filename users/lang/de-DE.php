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
%m1% - Dymamic markers which are replaced at run time by the relevant index.
*/

$lang = array();
//important strings
$lang = array_merge($lang,array(
"THIS_LANGUAGE"	=>"Deutsch",
"THIS_CODE"			=>"de-DE",
"MISSING_TEXT"	=>"Missing Text",
));
// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"					=> "Registrieren",
	"SIGNUP_BUTTONTEXT"		=> "Registrieren",
	"SIGNUP_AUDITTEXT"		=> "Registriert",
	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"				=> "** Anmeldung fehlgeschlagen **",
	"SIGNIN_PLEASE_CHK" => " Anmeldungsdaten bitte überprüfen, und erneut versuchen",
	"SIGNIN_UORE"				=> "Benutzername oder Email",
	"SIGNIN_PASS"				=> "Passwort",
	"SIGNIN_TITLE"			=> "Bitte anmelden",
	"SIGNIN_FORGOTPASS"		=>"Passwort vergessen",
	"SIGNIN_TEXT"				=> "Anmelden",
	"SIGNOUT_TEXT"			=> "Abmelden",
	"SIGNIN_BUTTONTEXT"	=> "Anmelden",
	"SIGNIN_REMEMBER"		=> "Angemeldet bleiben",
	"SIGNIN_AUDITTEXT"	=> "Angemeldet",
	"SIGNOUT_AUDITTEXT"	=> "Abgemeldet",
	));

// Account Page
$lang = array_merge($lang,array(
	"ACCT_EDIT"					=> "Konto bearbeiten",
	"ACCT_2FA"					=> "2Faktor-Authentisierung verwalten",
	"ACCT_SESS"					=> "Sitzungen verwalten",
	"ACCT_HOME"					=> "Kontoseite",
	"ACCT_SINCE"				=> "Mitglieder seit",
	"ACCT_LOGINS"				=> "Anzahl der Anmeldungen",
	"ACCT_SESSIONS"			=> "Anzahl der aktiven Sitzungen",
	"ACCT_MNG_SES"			=> "Für weitere Informationen, bitte auf - Sitzungen verwalten - links klicken.",
	));

	//General Terms
	$lang = array_merge($lang,array(
		"GEN_ENABLED"			=> "Aktiviert",
		"GEN_DISABLED"		=> "Deaktiviert",
		"GEN_ENABLE"			=> "Aktivieren",
		"GEN_DISABLE"			=> "Deaktivieren",
		"GEN_NO"					=> "Nein",
		"GEN_YES"					=> "Ja",
		"GEN_MIN"					=> "min",
		"GEN_MAX"					=> "max",
		"GEN_CHAR"				=> "char", //as in characters
		"GEN_SUBMIT"			=> "Senden",
		"GEN_MANAGE"			=> "Verwalten",
		"GEN_VERIFY"			=> "Überprüfen",
		"GEN_SESSION"			=> "Sitzung",
		"GEN_SESSIONS"		=> "Sitzungen",
		"GEN_EMAIL"				=> "Email",
		"GEN_FNAME"				=> "Vorname",
		"GEN_LNAME"				=> "Nachname",
		"GEN_UNAME"				=> "Benutzername",
		"GEN_PASS"				=> "Passwort",
		"GEN_MSG"					=> "Nachricht",
		"GEN_TODAY"				=> "Heute",
		"GEN_CLOSE"				=> "Schließen",
		"GEN_CANCEL"			=> "Abbrechen",
		"GEN_CHECK"				=> "[ Alles selektieren / deselektieren ]",
		"GEN_WITH"				=> "mit",
		"GEN_UPDATED"			=> "aktualisiert",
		"GEN_UPDATE"			=> "Aktualisieren",
		"GEN_BY"					=> "bei",
		"GEN_FUNCTIONS"		=> "Funktionen",
		"GEN_NUMBER"			=> "Zahl",
		"GEN_NUMBERS"			=> "Zahlen",
		"GEN_INFO"				=> "Information",
		"GEN_REC" 				=> "Aufnahme",
		"GEN_DEL" 				=> "Entfernen",
		"GEN_NOT_AVAIL" 	=> "nicht verfügbar",
		"GEN_AVAIL" 			=> "verfügbar",
		"GEN_BACK" 				=> "Zurück",
		"GEN_RESET" 			=> "Zurück setzen",
		"GEN_REQ"					=> "benötigt",
		"GEN_AND"					=> "und",
		"GEN_SAME"				=> "muss gleich sein",
		));

//validation class
	$lang = array_merge($lang,array(
		"VAL_SAME"				=> "muss gleich sein",
		"VAL_EXISTS"			=> "existiert bereits. Bitte wähle einen anderen",
		"VAL_DB"					=> "Database Error",
		"VAL_NUM"					=> "muss eine Nummer sein",
		"VAL_INT"					=> "muss eine Ganzzahl sein",
		"VAL_EMAIL"				=> "muss eine valide email Adresse sein",
		"VAL_NO_EMAIL"		=> "darf keine email Adresse sein",
		"VAL_SERVER"			=> "muss zu einem validen Server gehören",
		"VAL_LESS"				=> "muss kleiner sein als",
		"VAL_GREAT"				=> "muss größer sein als",
		"VAL_LESS_EQ"			=> "muss kleiner oder gleich sein als",
		"VAL_GREAT_EQ"		=> "muss größer oder gleich sein als",
		"VAL_NOT_EQ"			=> "muss ungleich sein",
		"VAL_EQ"					=> "muss gleich sein",
		"VAL_TZ"					=> "muss eine valide Zeitzone sein",
		"VAL_MUST"				=> "muss sein",
		"VAL_MUST_LIST"		=> "muss eines der folgenden sein",
		"VAL_TIME"				=> "muss eine valide Zeit sein",
		"VAL_SEL"					=> "ist keine valide Auswahl",
		"VAL_NA_PHONE"		=> "muss eine valide Telefonnummer sein",
	));
		//Time
	$lang = array_merge($lang,array(
		"T_YEARS"			=> "Jahre",
		"T_YEAR"			=> "Jahr",
		"T_MONTHS"		=> "Monate",
		"T_MONTH"			=> "Monat",
		"T_WEEKS"			=> "Wochen",
		"T_WEEK"			=> "Woche",
		"T_DAYS"			=> "Tage",
		"T_DAY"				=> "Tag",
		"T_HOURS"			=> "Stunden",
		"T_HOUR"			=> "Stunde",
		"T_MINUTES"		=> "Minuten",
		"T_MINUTE"		=> "Minute",
		"T_SECONDS"		=> "Sekunden",
		"T_SECOND"		=> "Sekunde",
		));


		//Passwords
	$lang = array_merge($lang,array(
		"PW_NEW"		=> "Neues Passwort",
		"PW_OLD"		=> "Altes Passwort",
		"PW_CONF"		=> "Passwort bestätigen",
		"PW_RESET"	=> "Passwort zurücksetzen",
		"PW_UPD"		=> "Passwort aktualisiert",
		"PW_SHOULD"	=> "Passwörter sollen...",
		"PW_SHOW"		=> "Passwort anzeigen",
		"PW_SHOWS"	=> "Passwörter anzeigen",
		));


		//Join
	$lang = array_merge($lang,array(
		"JOIN_SUC"		=> "Willkommen bei ",
		"JOIN_THANKS"	=> "Danke für die Registrierung!",
		"JOIN_HAVE"		=> "Muss mindestens ",
		"JOIN_CAP"		=> " Großbuchstabe",
		"JOIN_TWICE"	=> "Zweimal richtig eingegeben",
		"JOIN_CLOSED"	=> "Registrierung is derzeit leider deaktiviert. Bei Fragen melden Sie sich bitte beim Administrator.",
		"JOIN_TC"			=> "Allgemeine Geschäftsbedingungen (AGB)",
		"JOIN_ACCEPTTC" => "Ich akzeptiere die allgemeine Geschäftsbedingungen ",
		"JOIN_CHANGED"	=> "Unsere Geschäftsbedingungen haben sich geändert",
		"JOIN_ACCEPT" 	=> "Akzeptieren sie unsere Geschäftsbedingungen und fahren sie fort.",
		));


		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "Erfolgreich geschlossen ",
		));

		//Messages
	$lang = array_merge($lang,array(
		"MSG_SENT"			=> "Nachricht wurde gesendet!",
		"MSG_MASS"			=> "Massennachricht wurde gesendet!",
		"MSG_NEW"				=> "Neue Nachricht",
		"MSG_NEW_MASS"	=> "Neue Massennachricht",
		"MSG_CONV"			=> "Konversationen",
		"MSG_NO_CONV"		=> "Keine Konversationen",
		"MSG_NO_ARC"		=> "Keine Konversationen",
		"MSG_QUEST"			=> "Email senden, wenn aktiviert?",
		"MSG_ARC"				=> "Archivierte Threads",
		"MSG_VIEW_ARC"	=> "Archivierte Threads anzeigen",
		"MSG_SETTINGS"  => "Nachrichteinstellungen",
		"MSG_READ"			=> "gelesen",
		"MSG_BODY"			=> "Text",
		"MSG_SUB"				=> "Betreff",
		"MSG_DEL"				=> "Geliefert",
		"MSG_REPLY"			=> "Antworten",
		"MSG_QUICK"			=> "Schnelle Antwort",
		"MSG_SELECT"		=> "Benutzer auswählen",
		"MSG_UNKN"			=> "Unbekannter Empfänger",
		"MSG_NOTIF"			=> "email-Benachrichtigungen",
		"MSG_BLANK"			=> "Nachricht kann nicht leer sein",
		"MSG_MODAL"			=> "Hier klicken oder Alt + R drucken, um eine schnelle Antwort zu schreiben, oder Umschalttaste + R um ein erweitertes Fenster zu öffnen!",
		"MSG_ARCHIVE_SUCCESSFUL"        => "%m1% Threads wurden erfolgreich archiviert",
		"MSG_UNARCHIVE_SUCCESSFUL"      => "%m1% Threads wurden erfolgreich dearchiviert",
		"MSG_DELETE_SUCCESSFUL"         => "%m1% Threads wurden erfolgreich gelöscht",
		"USER_MESSAGE_EXEMPT"         			=> "Benutzer %m1% ist von Nachrichten ausgenommen.",
		"MSG_MK_READ" 		=> "gelesen",
		"MSG_MK_UNREAD" 	=> "ungelesen",
		"MSG_ARC_THR" 		=> "Ausgewählte Threads archivieren",
		"MSG_UN_THR" 			=> "Ausgewählte Threads dearchivieren",
		"MSG_DEL_THR" 		=> "Ausgewählte Threads entfernen",
		"MSG_SEND" 				=> "Nachricht senden",

		));

	//2 Factor Authentication
	$lang = array_merge($lang,array(
		"2FA"				=> "2Faktor-Authentisierung",
		"2FA_CONF"	=> "Wollen Sie wirklich 2FA deaktivieren? Ihr Konto wird dadurch nicht mehr geschützt.",
		"2FA_SCAN"	=> "QR-Code bitte mit Ihrer Authentisierung-App scannen, oder Schlüssel eingeben",
		"2FA_THEN"	=> "Dann geben Sie einen Ihrer einmaligen Passkeys hier ein",
		"2FA_FAIL"	=> "Problem bei Verifizierung von 2FA. Bitte Ihre Internetverbindung Prüfen, oder Support kontaktieren .",
		"2FA_CODE"	=> "2FA-Code",
		"2FA_EXP"		=> "1 Fingerabdruck ist abgelaufen",
		"2FA_EXPD"	=> "Abgelaufen",
		"2FA_FP"		=> "Fingerabdruck",
		"2FA_NP"		=> "<strong>Anmeldung fehlgeschlagen</strong> 2Faktor-Authentisierungscode fehlt. Bitte erneut versuchen.",
		"2FA_INV"		=> "<strong>Anmeldung fehlgeschlagen</strong> 2Faktor-Authentisierungscode ist nicht gültig. Bitte erneut versuchen.",
		"2FA_FATAL"	=> "<strong>Unbehebbarer+Fehler</strong> Systemadministrator bitte kontaktieren.",
		"2FA_EXPS"	=> "läuft ab",
		"2FA_ACTIVE"=> "Aktive Sitzungen",
		"2FA_NOT_FN"=> "Keine Fingerabdrücke gefunden",
		));

	//Redirect Messages - These get a plus between each word
	$lang = array_merge($lang,array(
		"REDIR_2FA"						=> "Entschuldigung.2Faktor-Authentisierung+ist+für+diesen+Benutzer+deaktiviert",
		"REDIR_2FA_EN"				=> "2Faktor-Authentisierung+wurde+aktiviert",
		"REDIR_2FA_DIS"				=> "2Faktor-Authentisierung+wurde+deaktiviert",
		"REDIR_2FA_VER"				=> "2Faktor-Authentisierung+wurde+verifiziert+und+aktiviert",
		"REDIR_SOM_TING_WONG" => "Irgendetwas ist schief gelaufen. Bitte noch einmal probieren.",
		"REDIR_MSG_NOEX"			=> "Der+Thread+existiert+nicht+oder+Zugriff+verweigert.",
		"REDIR_UN_ONCE"				=> "Benutzername+kann+nur+einmal+aktualisiert+werden",
		"REDIR_EM_SUCC"				=> "Emailadresse+erfolgreich+aktualisiert",
		));

	//Emails
	$lang = array_merge($lang,array(
		"EML_CONF"			=> "Email-Adresse bestätigen",
		"EML_VER"				=> "Email-Adresse bestätigen",
		"EML_CHK"				=> "Ihre Anfrage wurde erhalten. Prüfen Sie bitte Ihr Posteingang, um die Verifizierung auszuführen. Prüfen Sie Bitte Ihren Spam-Ordner, falls Sie die Email im Posteingang nicht finden können. Gültigkeit des Verifizierunglinks: ",
		"EML_MAT"				=> "Email-Adressen stimmen nicht überein.",
		"EML_HELLO"			=> "Hallo von ",
		"EML_HI"				=> "Hi ",
		"EML_AD_HAS"		=> "Ein Administrator hat ihr Passwort zurückgesetz.",
		"EML_AC_HAS"		=> "Ein Administrator hat ihren Account angelegt.",
		"EML_REQ"				=> "Sie müssen ihr Passwort über den oben angegebenen Link setzen.",
		"EML_EXP"				=> "Bitte beachten, der Passwort Link verfällt in ",
		"EML_VER_EXP"		=> "Bitte beachten, der Verifizierunglink  verfällt in ",
		"EML_CLICK"			=> "Klicke hier zum Login.",
		"EML_REC"				=> "Es wird empfohlen ihr Passwort nach dem login zu ändern.",
		"EML_MSG"				=> "Sie haben eine neue Nachricht von ",
		"EML_REPLY"			=> "Klicken sie hier um zu antworten.",
		"EML_WHY"				=> "Sie erhalten diese email weil ein Passwort Reset angefragt wurde. Weil sie es nicht waren, ignorieren sie diese email.",
		"EML_HOW"				=> "Falls sie es waren, klicken sie auf den Link und folgen sie den Anweisungen.",
		"EML_EML"				=> "Eine Änderung Ihrer email-Adresse wurde von Ihrem account beauftragt.",
		"EML_VER_EML"		=> "Danke für ihre Registrierung. Sobald ihre email Adresse verifiziert wurde, können sie sich einloggen. Bitte klicken sie auf den Link um Ihre email-Adresse zu verifizieren.",
		));

		//Verification
		$lang = array_merge($lang,array(
			"VER_SUC"			=> "Ihre Emailadresse wurde verifiziert!",
			"VER_FAIL"		=> "Ihr Konto konnte nicht verifiziert werden. Bitte erneut versuchen.",
			"VER_RESEND"	=> "Verifizierungsemail neu senden",
			"VER_AGAIN"		=> "Emailadresse nochmal eingeben, und erneut versuchen.",
			"VER_PAGE"		=> "<li>Wir haben Ihnen einen Link per Email gesendet</li><li>Fertig</li>",
			"VER_RES_SUC" => "<p>Ihre Anfrage wurde erhalten. Prüfen Sie bitte Ihren Posteingang, um die Verifizierung auszuführen. Prüfen Sie Bitte Ihren Spam-Ordner, falls Sie die Email im Posteingang nicht finden können.</p><p>Gültigkeit des Verifizierungslinks: ",
			"VER_OOPS" 		=> "Oh je! Etwas ist schiefgegengen, Vielleicht wurde ein abgelaufener Reset-Link geklickt. Bitte unten klicken, um neu zu versuchen",
			"VER_RESET" 	=> "Ihr Passwort wurde zurückgesetzt!",
			"VER_INS" 		=> "<li>Emailadresse eingeben und auf zurücksetzen klicken</li> <li>Posteingang prüfen und auf den Reset-Link Klicken.</li> <li>Bildschirmanweisungen folgen</li>",
			"VER_SENT" 		=> "<p>Einen Link zur Passwortrücksetzung wurde Ihnen per Email gschickt.</p> <p>Bitte darauf klicken, um Ihr Passwort zurück zu setzen. Prüfen Sie Bitte Ihren Spam-Ordner, falls Sie die Email im Posteingang nicht finden können.</p><p>Gültigkeit des Verifizierungslinks: ",
			"VER_PLEASE" => "Bitte setzen Sie Ihr Passwort zurück",
			));

	//User Settings
	$lang = array_merge($lang,array(
		"SET_PIN"				=> "PIN zurücksetzen",
		"SET_WHY"				=> "Warum kann ich das nicht ändern?",
		"SET_PW_MATCH"	=> "Muss das neue Passwort übereinstimmen",

		"SET_PIN_NEXT"	=> "PIN kann bei n&auml;chstem Verifizierungsberarf erneut werden",
		"SET_UPDATE"		=> "Benutzereinstellungen aktualisieren",
		"SET_NOCHANGE"	=> "Änderung des Benutzername ist deaktiviert.",
		"SET_ONECHANGE"	=> "Benutzername kann nur einmal geändert werden. Ihr Benutzername wurden bereits einmal geändert.",

		"SET_GRAVITAR"	=> "<strong>Wollen Sie Ihr Profilbild ändern? </strong><br> Bitte ein Konto auf <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> mit der selben Emailadresse erstellen. Es funktioniert auf vielen Websiten. Es geht schnell und einfach!",

		"SET_NOTE1"			=> "<p><strong>Hinweis</strong> Wir haben eine ausstehende Anfrage, Ihre Emailadresse nach",

		"SET_NOTE2"			=> ".</p><p> zu ändern. Bitte den Link in der Verifizierungsemail benutzen um Ihre Anfrage fort zu setzen.</p>
		<p>Um die Verifizierungsemail nochmal zu erhalten, Geben Sie bitte Ihre Emailadresse oben ein, und die Formular neu senden.</p>",

		"SET_PW_REQ" 		=> "Benötigt, um Ihr Passwort, PIN, oder Emailadresse zu ändern",
		"SET_PW_REQI" 	=> "Benötigt, um Ihr Passwort zu ändern",

		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"		=> "Aktive Sitzung konnte nicht geschlossen werden, Fehler: ",
		"ERR_EMAIL"				=> "Email wurde nicht gesendet. Bitte Administrator kontaktieren.",
		"ERR_EM_DB"				=> "Diese Emailadresse existiert in unserer Datenbank nicht.",
		"ERR_TC"					=> "AGB bitte lesen und akzeptieren",
		"ERR_CAP"					=> "Captcha-Test nicht bestanden, Roboter!",
		"ERR_PW_SAME"			=> "Das neue Passwort muss anders als das alte Passwort sein.",
		"ERR_PW_FAIL"			=> "Altes Passwort stimmt nicht. Aktualisierung fehlgeschlagen. Bitte erneut versuchen.",
		"ERR_GOOG"				=> "<strong>Hinweis:</strong> Falls Sie sich mit Ihrem Google/Facebook Konto registriert haben, müssen sie den - Passwort vergessen - Link benutzen, um Ihr Passwort zu ändern, es sei denn, dass Sie richtig gut raten können",
		"ERR_EM_VER"			=>  "Email&uuml;berpr&uuml;fung ist nicht aktiviert. Bitte Systemadministrator kontaktieren.",
		"ERR_EMAIL_STR"		=> "Etwas stimmt nicht. Emailadresse bitte überprüfen. Entschuldigung sie die Unannehmlichkeit.",
		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"		=> "Wir werden bald zur&uuml;ck sein!",
		"MAINT_MSG"			=> "Entschuldigung Sie die Unannehmlichkeiten, wir führen gerade enige Wartungsarbeiten aus.<br> Wir werden in Kürze wieder online sein!",
		"MAINT_BAN" 		=> "Es tut uns leid. Sie wurden Blockiert. Bitte den Systemadministrator kontaktieren, falls Sie glauben, das es einen Fehler gibt.",
		"MAINT_TOK" 		=> "Es gibt einen Fehler im Formular. Bitte erneut versuchen. Hinweis: Sollte dies erneut passieren, wenden sie sich bitte an den Administrator.",
		"MAINT_OPEN" 		=> "Ein quelloffenes PHP-Benutzerverwaltungssystem.",
		"MAINT_PLEASE" 	=> "Sie haben Userspice erfolgreich installiert!<br>Die Kurzanleitung befindet sich unter ",
		));

	//Database Menus
	$lang = array_merge($lang,array(
		"MENU_HOME"            => "Startseite",
		"MENU_HELP"            => "Hilfe",
		"MENU_ACCOUNT"    		 => "Konto",
		"MENU_DASH"            => "Adminbereich",
		"MENU_USER_MGR"				 => "Benutzerverwaltung",
		"MENU_PAGE_MGR"   		 => "Seitenverwaltung",
		"MENU_PERM_MGR"    		 => "Zugriffsverwaltung",
		"MENU_MSGS_MGR"    		 => "Nachrichtenverwaltung",
		"MENU_LOGS_MGR"        => "Systembericht",
		"MENU_LOGOUT"          => "Abmelden",
		));

		//dataTables Added in 4.4.08
		//NOTE: do not change the words like _START_ between the two _ symbols!
		$lang = array_merge($lang,array(
		"DAT_SEARCH"    => "Suche",
		"DAT_FIRST"     => "Erste",
		"DAT_LAST"      => "Letzte",
		"DAT_NEXT"      => "Nächste",
		"DAT_PREV"      => "Vorherige",
		"DAT_NODATA"        => "Keine Daten in der Tabelle vorhanden",
		"DAT_INFO"          => "Zeige _START_ bis _END_ von _TOTAL_ Einträgen",
		"DAT_ZERO"          => "Zeige 0 bis 0 von 0 Einträgen",
		"DAT_FILTERED"      => "(gefiltert von _MAX_ Einträgen)",
		"DAT_MENU_LENG"     => "Zeige _MENU_ Einträge",
		"DAT_LOADING"       => "Lade...",
		"DAT_PROCESS"       => "Bearbeite...",
		"DAT_NO_REC"        => "Keine passenden Datensätze gefunden",
		"DAT_ASC"           => "Aktivieren Sie diese Option, um die Spalte aufsteigend zu sortieren.",
		"DAT_DESC"          => "Aktivieren Sie diese Option, um die Spalte absteigend zu sortieren.",
		));

		//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
		if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
			include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
		}
 //do not put a closing php tag here
