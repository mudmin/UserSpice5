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
$lang = array_merge($lang, array(
	"THIS_LANGUAGE"	=> "Deutsch",
	"THIS_CODE"			=> "de-DE",
	"MISSING_TEXT"	=> "Missing Text",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "Geben Sie den an Ihre E-Mail gesendeten Code ein",
    "PASS_EMAIL_ONLY"     => "Bitte prüfen Sie Ihre E-Mail für einen Anmeldelink",
    "PASS_CODE_ONLY"      => "Bitte geben Sie den an Ihre E-Mail gesendeten Code ein",
    "PASS_BOTH"           => "Bitte prüfen Sie Ihre E-Mail für einen Anmeldelink oder geben Sie den gesendeten Code ein",
    "PASS_VER_BUTTON"     => "Code bestätigen",
    "PASS_EMAIL_ONLY_MSG" => "Bitte bestätigen Sie Ihre E-Mail-Adresse durch Klicken auf den untenstehenden Link",
    "PASS_CODE_ONLY_MSG"  => "Bitte geben Sie den untenstehenden Code ein, um sich anzumelden",
    "PASS_BOTH_MSG"       => "Bitte bestätigen Sie Ihre E-Mail-Adresse durch Klicken auf den untenstehenden Link oder geben Sie den Code ein, um sich anzumelden",
    "PASS_YOUR_CODE"      => "Ihr Bestätigungscode lautet: ",
    "PASS_CONFIRM_LOGIN"  => "Anmeldung bestätigen",
    "PASS_CONFIRM_CLICK"  => "Klicken Sie, um die Anmeldung abzuschließen",
    "PASS_GENERIC_ERROR"  => "Etwas ist schiefgelaufen",
));

// Signup
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"					=> "Registrieren",
	"SIGNUP_BUTTONTEXT"		=> "Registrieren",
	"SIGNUP_AUDITTEXT"		=> "Registriert",
));

// Signin
$lang = array_merge($lang, array(
	"SIGNIN_FAIL"				=> "** Anmeldung fehlgeschlagen **",
	"SIGNIN_PLEASE_CHK" => " Anmeldungsdaten bitte überprüfen, und erneut versuchen",
	"SIGNIN_UORE"				=> "Benutzername oder Email",
	"SIGNIN_PASS"				=> "Passwort",
	"SIGNIN_TITLE"			=> "Bitte anmelden",
	"SIGNIN_FORGOTPASS"		=> "Passwort vergessen",
	"SIGNIN_TEXT"				=> "Anmelden",
	"SIGNOUT_TEXT"			=> "Abmelden",
	"SIGNIN_BUTTONTEXT"	=> "Anmelden",
	"SIGNIN_REMEMBER"		=> "Angemeldet bleiben",
	"SIGNIN_AUDITTEXT"	=> "Angemeldet",
	"SIGNOUT_AUDITTEXT"	=> "Abgemeldet",
));

// Account Page
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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

//added during passkey/totp update
$lang = array_merge($lang, array(
    "GEN_PASSKEY"                         => "Passkey",
    "GEN_ACTIONS"                         => "Aktionen",
    "GEN_BACK_TO_ACCT"                    => "Zurück zum Konto",
    "GEN_DB_ERROR"                        => "Ein Datenbankfehler ist aufgetreten. Bitte versuchen Sie es erneut.",
    "GEN_IMPORTANT"                       => "Wichtig",
    "GEN_NO_PERMISSIONS"                  => "Sie haben keine Berechtigung, auf diese Seite zuzugreifen.",
    "GEN_NO_PERMISSIONS_MSG"              => "Sie haben keine Berechtigung, auf diese Seite zuzugreifen. Wenn Sie glauben, dass dies ein Fehler ist, kontaktieren Sie bitte den Seitenadministrator.",
    "PASSKEYS_MANAGE_TITLE"               => "Ihre Passkeys verwalten",
    "PASSKEYS_LOGIN_TITLE"                => "Anmeldung mit Passkey",
    "PASSKEY_DELETE_SUCCESS"              => "Passkey erfolgreich gelöscht.",
    "PASSKEY_DELETE_FAIL_DB"              => "Fehler beim Löschen des Passkeys aus der Datenbank.",
    "PASSKEY_DELETE_NOT_FOUND"            => "Passkey nicht gefunden oder Berechtigung verweigert.",
    "PASSKEY_NOTE_UPDATE_SUCCESS"         => "Passkey-Notiz erfolgreich aktualisiert.",
    "PASSKEY_NOTE_UPDATE_FAIL"            => "Fehler beim Aktualisieren der Passkey-Notiz.",
    "PASSKEY_REGISTER_NEW"                => "Neuen Passkey registrieren",
    "PASSKEY_ERR_LIMIT_REACHED"           => "Sie haben das Maximum von 10 Passkeys erreicht.",
    "PASSKEY_NOTE_TH"                     => "Passkey-Notiz",
    "PASSKEY_TIMES_USED_TH"               => "Anzahl der Verwendungen",
    "PASSKEY_LAST_USED_TH"                => "Zuletzt verwendet",
    "PASSKEY_LAST_IP_TH"                  => "Letzte IP",
    "PASSKEY_EDIT_NOTE_BTN"               => "Notiz bearbeiten",
    "PASSKEY_CONFIRM_DELETE_JS"           => "Sind Sie sicher, dass Sie diesen Passkey löschen möchten?",
    "PASSKEY_EDIT_MODAL_TITLE"            => "Passkey-Notiz bearbeiten",
    "PASSKEY_EDIT_MODAL_LABEL"            => "Passkey-Notiz",
    "PASSKEY_SAVE_CHANGES_BTN"            => "Änderungen speichern",
    "PASSKEY_NONE_REGISTERED"             => "Sie haben noch keine Passkeys registriert.",
    "PASSKEY_MUST_REGISTER_FIRST"         => "Sie müssen zuerst einen Passkey von einem authentifizierten Konto registrieren, bevor Sie diese Funktion nutzen können.",
    "PASSKEY_STORING"                     => "Passkey wird gespeichert...",
    "PASSKEY_STORED_SUCCESS"              => "Passkey erfolgreich gespeichert!",
    "PASSKEY_INVALID_ACTION"              => "Ungültige Aktion: ",
    "PASSKEY_NO_ACTION_SPECIFIED"         => "Keine Aktion angegeben",
    "PASSKEY_ERR_NETWORK_SUGGESTION"      => "Netzwerkproblem erkannt. Versuchen Sie ein anderes Netzwerk oder aktualisieren Sie die Seite.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "Geräteübergreifende Authentifizierung erkannt. Stellen Sie sicher, dass beide Geräte Internetzugang haben.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "Versuchen Sie stattdessen, diese Seite direkt auf Ihrem Smartphone zu öffnen.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"       => "Diagnose konnte nicht erstellt werden: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"     => "Fehlende erforderliche Anmeldedaten für die Speicherung.",
    "PASSKEY_MISSING_AUTH_DATA"           => "Fehlende erforderliche Authentifizierungsdaten.",
    "PASSKEY_LOG_NO_MESSAGE"              => "Keine Nachricht",
    "PASSKEY_USER_NOT_FOUND"              => "Benutzer nach Passkey-Validierung nicht gefunden.",
    "PASSKEY_FATAL_ERROR"                 => "Fataler Fehler: ",
    "PASSKEY_LOGIN_SUCCESS"               => "Anmeldung erfolgreich.",
    // JavaScript status messages (passkeys.php)
    "PASSKEY_CROSS_DEVICE_PREP"           => "Vorbereitung für die geräteübergreifende Registrierung. Möglicherweise müssen Sie Ihr Smartphone oder Tablet verwenden.",
    "PASSKEY_DEVICE_REGISTRATION"         => "Geräte-Passkey-Registrierung wird verwendet...",
    "PASSKEY_STARTING_REGISTRATION"       => "Passkey-Registrierung wird gestartet...",
    "PASSKEY_REQUEST_OPTIONS"             => "Registrierungsoptionen vom Server werden angefordert...",
    "PASSKEY_FOLLOW_PROMPTS"              => "Folgen Sie den Anweisungen, um Ihren Passkey zu erstellen. Möglicherweise müssen Sie ein anderes Gerät verwenden.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"       => "Folgen Sie den Anweisungen, um Ihren Passkey zu erstellen...",
    "PASSKEY_CREATION_FAILED"             => "Erstellung des Passkeys fehlgeschlagen - keine Anmeldedaten zurückgegeben.",
    "PASSKEY_STORING_SERVER"              => "Ihr Passkey wird gespeichert...",
    "PASSKEY_CREATED_SUCCESS"             => "Passkey erfolgreich erstellt!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP"      => "Vorbereitung für die geräteübergreifende Authentifizierung. Stellen Sie sicher, dass Ihr Smartphone und Ihr Computer Internetzugang haben.",
    "PASSKEY_DEVICE_AUTH"                 => "Geräte-Passkey-Authentifizierung wird verwendet...",
    "PASSKEY_STARTING_AUTH"               => "Passkey-Authentifizierung wird gestartet...",
    "PASSKEY_QR_CODE_INSTRUCTION"         => "Scannen Sie den QR-Code mit Ihrem Smartphone, wenn er erscheint. Stellen Sie sicher, dass beide Geräte Internetzugang haben.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"    => "Wählen Sie \"Ein Smartphone oder Tablet verwenden\", wenn Sie dazu aufgefordert werden, und scannen Sie dann den QR-Code.",
    "PASSKEY_AUTHENTICATING"              => "Authentifizierung mit Ihrem Passkey...",
    "PASSKEY_SUCCESS_REDIRECTING"         => "Authentifizierung erfolgreich! Weiterleitung...",
    // Timeout messages
    "PASSKEY_TIMEOUT_CROSS_DEVICE"        => "Zeitüberschreitung bei der Registrierung. Für geräteübergreifend: 1) Erneut versuchen, 2) Sicherstellen, dass die Geräte Internet haben, 3) Erwägen Sie die Registrierung direkt auf Ihrem Smartphone.",
    "PASSKEY_TIMEOUT_SIMPLE"              => "Zeitüberschreitung bei der Registrierung. Bitte versuchen Sie es erneut.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"   => "Zeitüberschreitung bei der geräteübergreifenden Authentifizierung. Fehlerbehebung: 1) Beide Geräte benötigen Internet, 2) Versuchen Sie, den QR-Code schneller zu scannen, 3) Erwägen Sie die Verwendung desselben Geräts, 4) Einige Netzwerke blockieren die geräteübergreifende Authentifizierung.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"         => "Zeitüberschreitung bei der Authentifizierung. Bitte versuchen Sie es erneut.",
    "PASSKEY_NO_CREDENTIAL"               => "Keine Anmeldedaten erhalten. Erneuter Versuch...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"   => "Authentifizierung fehlgeschlagen - keine Anmeldedaten zurückgegeben.",
    "PASSKEY_ATTEMPT_RETRY"               => "fehlgeschlagen. Erneuter Versuch... (%d Versuche verbleibend)",
    // Error messages
    "PASSKEY_CROSS_DEVICE_FAILED"         => "Geräteübergreifende Registrierung fehlgeschlagen. Versuchen Sie: 1) Sicherstellen, dass beide Geräte Internet haben, 2) Erwägen Sie die Registrierung direkt auf Ihrem Smartphone, 3) Einige Unternehmensnetzwerke blockieren diese Funktion.",
    "PASSKEY_REGISTRATION_CANCELLED"      => "Registrierung wurde abgebrochen oder das Gerät unterstützt keine Passkeys.",
    "PASSKEY_NOT_SUPPORTED"               => "Passkeys werden auf dieser Geräte-/Browser-Kombination nicht unterstützt.",
    "PASSKEY_SECURITY_ERROR"              => "Sicherheitsfehler - dies deutet normalerweise auf eine Nichtübereinstimmung von Domain/Ursprung hin.",
    "PASSKEY_ALREADY_EXISTS"              => "Ein Passkey für dieses Konto auf diesem Gerät existiert bereits. Versuchen Sie, ein anderes Gerät zu verwenden oder löschen Sie zuerst vorhandene Passkeys.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"    => "Geräteübergreifende Authentifizierung fehlgeschlagen. Versuchen Sie: 1) Sicherstellen, dass beide Geräte eine stabile Internetverbindung haben, 2) Wenn möglich, dasselbe WLAN-Netzwerk verwenden, 3) Versuchen Sie stattdessen, sich direkt auf Ihrem Smartphone zu authentifizieren, 4) Einige Unternehmensnetzwerke blockieren diese Funktion.",
    "PASSKEY_AUTH_CANCELLED"              => "Authentifizierung wurde abgebrochen oder es wurde kein Passkey ausgewählt.",
    "PASSKEY_NETWORK_ERROR"               => "Netzwerkfehler. Für die geräteübergreifende Authentifizierung benötigen beide Geräte Internetzugang und müssen möglicherweise im selben Netzwerk sein.",
    "PASSKEY_CREDENTIAL_NOT_FOUND"        => "Authentifizierung fehlgeschlagen - Anmeldedaten nicht erkannt.",
    // Cross-device guidance
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "Tipps zur geräteübergreifenden Authentifizierung:",
    "PASSKEY_GUIDANCE_INTERNET"           => "Stellen Sie sicher, dass sowohl Ihr Computer als auch Ihr Smartphone Internetzugang haben",
    "PASSKEY_GUIDANCE_WIFI"               => "Im selben WLAN-Netzwerk zu sein kann helfen (ist aber nicht immer erforderlich)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"      => "Wenn Sie dazu aufgefordert werden, wählen Sie \"Ein Smartphone oder Tablet verwenden\"",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"       => "Scannen Sie den QR-Code schnell, wenn er erscheint",
    "PASSKEY_GUIDANCE_TRY_DIRECT"         => "Wenn es fehlschlägt, versuchen Sie, die Seite zu aktualisieren und direkt den Browser Ihres Smartphones zu verwenden",
    // Troubleshooting
    "PASSKEY_SHOW_TROUBLESHOOTING"        => "Tipps zur Fehlerbehebung anzeigen",
    "PASSKEY_HIDE_TROUBLESHOOTING"        => "Tipps zur Fehlerbehebung ausblenden",
    "PASSKEY_DIAGNOSTICS_RUNNING"         => "Diagnose wird ausgeführt...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"        => "Diagnose abgeschlossen. Überprüfen Sie die Konsole für Details.",
    "PASSKEY_ISSUES_DETECTED"             => "Probleme erkannt:",
    "PASSKEY_ENVIRONMENT_SUITABLE"        => "Die Umgebung scheint für Passkeys geeignet zu sein.",
    "PASSKEY_DIAGNOSTICS_FAILED"          => "Diagnose fehlgeschlagen:",
    // Modal
    "PASSKEY_ADD_NOTE_NEW"                => "Fügen Sie Ihrem neuen Passkey eine Notiz hinzu",
    // Technical errors
    "PASSKEY_BASE64_ERROR"                => "Base64-Dekodierungsfehler:",
    // Server-side errors (passkey_parser.php)
    "PASSKEY_INVALID_JSON"                => "Ungültige JSON-Daten empfangen:",
    // Session/validation errors (PasskeyHandler.php)
    "PASSKEY_NO_CHALLENGE_SESSION"        => "Keine Passkey-Registrierungs-Challenge in der Sitzung gefunden. Bitte versuchen Sie die Registrierung erneut.",
    "PASSKEY_USER_MISMATCH"               => "Benutzer-ID-Nichtübereinstimmung. Bitte versuchen Sie die Registrierung erneut.",
    "PASSKEY_CHALLENGE_USER_MISMATCH"     => "Benutzer-ID in den Challenge-Optionen stimmt nicht mit dem aktuellen Benutzer überein. Bitte versuchen Sie die Registrierung erneut.",
    "PASSKEY_REGISTRATION_FAILED_ERROR"   => "Passkey-Registrierung fehlgeschlagen. Bitte stellen Sie sicher, dass Ihr Gerät und Browser WebAuthn unterstützen, und versuchen Sie es erneut. Fehler:",
    "PASSKEY_NO_AUTH_CHALLENGE_SESSION"   => "Keine Passkey-Bestätigungs-Challenge in der Sitzung gefunden. Bitte versuchen Sie die Anmeldung erneut.",
    "PASSKEY_CREDENTIAL_NOT_IN_DB"        => "Passkey-Anmeldedaten nicht in der Datenbank gefunden.",
    "PASSKEY_CREDENTIAL_WRONG_USER"       => "Passkey-Anmeldedaten gehören nicht zum erwarteten Benutzer.",
    "PASSKEY_VALIDATION_FAILED_ERROR"     => "Passkey-Validierung fehlgeschlagen. Bitte versuchen Sie es erneut oder kontaktieren Sie den Support, wenn das Problem weiterhin besteht. Fehler:",
    "PASSKEY_USER_NOT_FOUND_REGISTRATION" => "Benutzer für die Registrierung nicht gefunden.",
    // --- Used in passkey_parser.php ---
    "PASSKEY_LOGIN_REQUIRED"              => "Sie müssen angemeldet sein, um diese Aktion durchzuführen.",
    "PASSKEY_ACTION_MISSING"              => "Der erforderliche 'action'-Parameter fehlte in der Anfrage.",
    "PASSKEY_STORAGE_FAILED"              => "Speichern des Passkeys fehlgeschlagen. Die Operation war nicht erfolgreich.",
    "PASSKEY_LOGIN_FAILED"                => "Passkey-Anmeldung fehlgeschlagen. Die Authentifizierung konnte nicht überprüft werden.",
    "PASSKEY_INVALID_METHOD"              => "Ungültige Anfragemethode:", // The script appends the method name after this key
    // --- Used in passkeys.php ---
    "CSRF_ERROR"                          => "CSRF-Token-Überprüfung fehlgeschlagen. Bitte gehen Sie zurück und versuchen Sie, das Formular erneut abzusenden.",
    // Network analysis from analyzeNetworkConditions()
    "PASSKEY_NETWORK_PRIVATE"             => "Mögliches Problem: Sie scheinen sich in einem privaten Netzwerk zu befinden, was manchmal die geräteübergreifende Kommunikation stören kann.",
    "PASSKEY_NETWORK_PROXY"               => "Mögliches Problem: Ein Proxy oder VPN wurde erkannt. Dies kann die geräteübergreifende Kommunikation stören.",
    "PASSKEY_NETWORK_MOBILE"              => "Hinweis: Sie scheinen sich in einem Mobilfunknetz zu befinden. Stellen Sie eine stabile Verbindung für geräteübergreifende Operationen sicher.",
    "PASSKEY_NETWORK_CORPORATE"           => "Mögliches Problem: Eine Unternehmens-Firewall könnte aktiv sein, was die geräteübergreifende Authentifizierung beeinträchtigen könnte.",
    // Recommendations from getCrossDeviceRecommendations()
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "Empfehlung: Sie verwenden wahrscheinlich einen Desktop. Bereiten Sie sich darauf vor, Ihr Smartphone zum Scannen eines QR-Codes zu verwenden.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "Empfehlung: Für beste Ergebnisse stellen Sie sicher, dass Ihr Computer und Ihr Mobilgerät im selben WLAN-Netzwerk sind.",
    "PASSKEY_RECOMMENDATION_QR_QUICK"     => "Empfehlung: Seien Sie bereit, den QR-Code schnell zu scannen, da die Anfrage eine Zeitüberschreitung haben könnte.",
    "PASSKEY_RECOMMENDATION_INTERNET"     => "Empfehlung: Stellen Sie sicher, dass sowohl Ihr Computer als auch Ihr Mobilgerät eine stabile Internetverbindung haben.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "Empfehlung: Für Unity WebViews stellen Sie sicher, dass die Seite genügend Zeit hat, um die Passkey-Anfrage zu laden und zu verarbeiten.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "Empfehlung: Zeitüberschreitungen können in Unity länger sein. Bitte haben Sie Geduld.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "Empfehlung: Da Sie auf einem Mobilgerät sind, sollten Sie in der Lage sein, einen Passkey direkt auf diesem Gerät zu registrieren.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Empfehlung: Unter Android können Sie Ihre Passkeys im Google Passwortmanager verwalten.",
    // Validation from validateCrossDeviceEnvironment()
    "PASSKEY_VALIDATION_RP_IP"            => "Konfigurationswarnung: Die Relying Party ID ist auf eine IP-Adresse eingestellt.",
    "PASSKEY_VALIDATION_RP_DOMAIN"        => "Empfehlung: Setzen Sie die Relying Party ID auf Ihren Domainnamen (z.B. ihrewebseite.de) für bessere Sicherheit und Kompatibilität.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"   => "Konfigurationsfehler: HTTPS ist für die Funktion von Passkeys auf einem Live-Server erforderlich. Ihre Seite scheint auf HTTP zu laufen.",
    "PASSKEY_VALIDATION_NETWORK"          => "Netzwerkwarnung", // Generic prefix for network issues
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "Empfehlung: Wenn Sie Probleme haben, versuchen Sie ein anderes Netzwerk (z.B. wechseln Sie von Unternehmens-WLAN zu einem mobilen Hotspot).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "Empfehlung: Für geräteübergreifende Aktionen stellen Sie sicher, dass beide Geräte eine zuverlässige Internetverbindung haben.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"  => "Empfehlung: Wenn geräteübergreifende Aktionen fehlschlagen, versuchen Sie, diese Seite direkt auf Ihrem Mobilgerät aufzurufen, um die Aktion abzuschließen.",
    "PASSKEY_INFO_TITLE"                  => "Über Passkeys",
    "PASSKEY_INFO_DESC"                   => "Passkeys sind eine sichere, passwortfreie Methode zur Anmeldung, die die integrierten Sicherheitsfunktionen Ihres Geräts wie Fingerabdruck, Gesichtserkennung oder PIN nutzt. Sie sind sicherer als Passwörter, ermöglichen eine schnellere Anmeldung, funktionieren geräteübergreifend, wenn sie mit Passwortmanagern synchronisiert werden, und sind resistent gegen Phishing-Angriffe. Passkeys funktionieren auf modernen Smartphones, Tablets, Computern und können in Passwortmanagern wie 1Password, Bitwarden, iCloud-Schlüsselbund oder Google Passwortmanager gespeichert werden.",
    "PASSKEY_BACK_TO_LOGIN"               => "Zurück zur Anmeldung",
));


//validation class
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"JOIN_SUC"		=> "Willkommen bei ",
	"JOIN_THANKS"	=> "Danke für die Registrierung!",
	"JOIN_HAVE"		=> "Muss mindestens ",
	"JOIN_LOWER"	=> " Kleinbuchstabe",
	"JOIN_SYMBOL"		=> " Symbol",
	"JOIN_CAP"		=> " Großbuchstabe",
	"JOIN_TWICE"	=> "Zweimal richtig eingegeben",
	"JOIN_CLOSED"	=> "Registrierung is derzeit leider deaktiviert. Bei Fragen melden Sie sich bitte beim Administrator.",
	"JOIN_TC"			=> "Allgemeine Geschäftsbedingungen (AGB)",
	"JOIN_ACCEPTTC" => "Ich akzeptiere die allgemeine Geschäftsbedingungen ",
	"JOIN_CHANGED"	=> "Unsere Geschäftsbedingungen haben sich geändert",
	"JOIN_ACCEPT" 	=> "Akzeptieren sie unsere Geschäftsbedingungen und fahren sie fort.",
	"JOIN_SCORE" => "Punkte:",
	"JOIN_INVALID_PW" => "Ihr Passwort ist ungültig",

));


//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "Erfolgreich geschlossen ",
));

//Messages
$lang = array_merge($lang, array(
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
	"MSG_MODAL"			=> "Hier klicken oder Alt + R drucken, um eine schnelle Antwort zu schreiben, oder Umschalttaste   R um ein erweitertes Fenster zu öffnen!",
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

//Two Factor Authentication
$lang = array_merge($lang, array(
    "2FA"                                => "Zwei-Faktor-Authentifizierung",
    "2FA_CONF"                           => "Sind Sie sicher, dass Sie die 2FA deaktivieren möchten? Ihr Konto wird dann nicht mehr geschützt sein.",
    "2FA_SCAN"                           => "Scannen Sie diesen QR-Code mit Ihrer Authenticator-App oder geben Sie den Schlüssel ein",
    "2FA_THEN"                           => "Geben Sie dann hier einen Ihrer Einmal-Passcodes ein",
    "2FA_FAIL"                           => "Bei der Überprüfung der 2FA ist ein Problem aufgetreten. Bitte überprüfen Sie das Internet oder kontaktieren Sie den Support.",
    "2FA_CODE"                           => "2FA-Code",
    "2FA_EXP"                            => "1 Fingerabdruck abgelaufen",
    "2FA_EXPD"                           => "Abgelaufen",
    "2FA_EXPS"                           => "Läuft ab",
    "2FA_ACTIVE"                         => "Aktive Sitzungen",
    "2FA_NOT_FN"                         => "Keine Fingerabdrücke gefunden",
    "2FA_FP"                             => "Fingerabdrücke",
    "2FA_NP"                             => "Anmeldung fehlgeschlagen - Der Zwei-Faktor-Authentifizierungscode war nicht vorhanden. Bitte versuchen Sie es erneut.",
    "2FA_INV"                            => "Anmeldung fehlgeschlagen - Der Zwei-Faktor-Authentifizierungscode war ungültig. Bitte versuchen Sie es erneut.",
    "2FA_FATAL"                          => "Fataler Fehler - Bitte kontaktieren Sie den Systemadministrator. Wir können derzeit keinen Zwei-Faktor-Authentifizierungscode generieren.",
    "2FA_SECTION_TITLE"                  => "Zwei-Faktor-Authentifizierung (TOTP)",
    "2FA_SK_ALT"                         => "Wenn Sie den QR-Code nicht scannen können, geben Sie diesen geheimen Schlüssel manuell in Ihre Authenticator-App ein.",
    "2FA_IS_ENABLED"                     => "Die Zwei-Faktor-Authentifizierung schützt Ihr Konto.",
    "2FA_NOT_ENABLED_INFO"               => "Die Zwei-Faktor-Authentifizierung ist derzeit nicht aktiviert.",
    "2FA_NOT_ENABLED_EXPLAIN"            => "Die Zwei-Faktor-Authentifizierung (TOTP) fügt Ihrem Konto eine zusätzliche Sicherheitsebene hinzu, indem zusätzlich zu Ihrem Passwort ein Code von einer Authenticator-App auf Ihrem Telefon erforderlich ist.",
    // Setup Process
    "2FA_SETUP_TITLE"                    => "Zwei-Faktor-Authentifizierung einrichten",
    "2FA_SECRET_KEY_LABEL"               => "Geheimer Schlüssel:",
    "2FA_SETUP_VERIFY_CODE_LABEL"        => "Bestätigungscode aus der App eingeben",
    // Backup Codes
    "2FA_SUCCESS_ENABLED_TITLE"          => "Zwei-Faktor-Authentifizierung aktiviert! Speichern Sie Ihre Backup-Codes",
    "2FA_SUCCESS_ENABLED_INFO"           => "Unten finden Sie Ihre Backup-Codes. Bewahren Sie sie sicher auf - jeder kann nur einmal verwendet werden.",
    "2FA_BACKUP_CODES_WARNING"           => "Behandeln Sie diese Codes wie Passwörter. Bewahren Sie sie sicher auf.",
    "2FA_SUCCESS_BACKUP_REGENERATED"     => "Neue Backup-Codes generiert. Bewahren Sie sie sicher auf.",
    "2FA_BACKUP_CODE_LABEL"              => "Backup-Code",
    "2FA_REGEN_CODES_BTN"                => "Backup-Codes neu generieren",
    "2FA_INVALIDATE_WARNING"             => "Dies macht alle vorhandenen Backup-Codes ungültig. Sind Sie sicher?",
    // Authentication
    "2FA_CODE_LABEL"                     => "Authentifizierungscode",
    "2FA_VERIFY_BTN"                     => "Bestätigen & Anmelden",
    "2FA_VERIFY_TITLE"                   => "Zwei-Faktor-Authentifizierung erforderlich",
    "2FA_VERIFY_INFO"                    => "Geben Sie den 6-stelligen Code aus Ihrer Authenticator-App ein.",
    // Actions & Buttons
    "2FA_ENABLE_BTN"                     => "Zwei-Faktor-Authentifizierung aktivieren",
    "2FA_DISABLE_BTN"                    => "Zwei-Faktor-Authentifizierung deaktivieren",
    "2FA_VERIFY_ACTIVATE_BTN"            => "Bestätigen & Aktivieren",
    "2FA_CANCEL_SETUP_BTN"               => "Einrichtung abbrechen",
    "2FA_DONE_BTN"                       => "Fertig",
    // Success Messages
    "REDIR_2FA_DIS"                      => "Die Zwei-Faktor-Authentifizierung wurde deaktiviert.",
    "2FA_SUCCESS_BACKUP_ACK"             => "Backup-Codes bestätigt.",
    "2FA_SUCCESS_SETUP_CANCELLED"        => "Einrichtung abgebrochen.",
    // Error Messages
    "2FA_ERR_INVALID_BACKUP"             => "Ungültiger Backup-Code. Bitte versuchen Sie es erneut.",
    "2FA_ERR_DISABLE_FAILED"             => "Fehler beim Deaktivieren der Zwei-Faktor-Authentifizierung.",
    "2FA_ERR_NO_SECRET"                  => "Authentifizierungsgeheimnis konnte nicht abgerufen werden. Bitte versuchen Sie es erneut.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"     => "Backup-Code verifiziert, aber Fehler beim Ungültigmachen. Bitte kontaktieren Sie den Support.",
    "2FA_ERR_NO_CODE_PROVIDED"           => "Kein Authentifizierungscode angegeben.",
    "RATE_LIMIT_LOGIN"                   => "Zu viele fehlgeschlagene Anmeldeversuche. Bitte warten Sie, bevor Sie es erneut versuchen.",
    "RATE_LIMIT_TOTP"                    => "Zu viele falsche Authentifizierungscodes. Bitte warten Sie, bevor Sie es erneut versuchen.",
    "RATE_LIMIT_PASSKEY"                 => "Zu viele Passkey-Authentifizierungsversuche. Bitte warten Sie, bevor Sie es erneut versuchen.",
    "RATE_LIMIT_PASSKEY_STORE"           => "Zu viele Passkey-Registrierungsversuche. Bitte warten Sie, bevor Sie es erneut versuchen.",
    "RATE_LIMIT_PASSWORD_RESET"          => "Zu viele Anfragen zur Passwortwiederherstellung. Bitte warten Sie, bevor Sie eine weitere anfordern.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT"   => "Zu viele Versuche zur Passwortwiederherstellung. Bitte warten Sie, bevor Sie es erneut versuchen.",
    "RATE_LIMIT_REGISTRATION"            => "Zu viele Registrierungsversuche. Bitte warten Sie, bevor Sie es erneut versuchen.",
    "RATE_LIMIT_EMAIL_VERIFICATION"      => "Zu viele Anfragen zur E-Mail-Verifizierung. Bitte warten Sie, bevor Sie eine weitere anfordern.",
    "RATE_LIMIT_EMAIL_CHANGE"            => "Zu viele Anfragen zur E-Mail-Änderung. Bitte warten Sie, bevor Sie es erneut versuchen.",
    "RATE_LIMIT_PASSWORD_CHANGE"         => "Zu viele Versuche zur Passwortänderung. Bitte warten Sie, bevor Sie es erneut versuchen.",
    "RATE_LIMIT_GENERIC"                 => "Zu viele Versuche. Bitte warten Sie, bevor Sie es erneut versuchen.",
));


$lang = array_merge($lang, array(
	"REDIR_2FA"						=> "Entschuldigung.2Faktor-Authentisierung ist für diesen Benutzer deaktiviert",
	"REDIR_2FA_EN"				=> "2Faktor-Authentisierung wurde aktiviert",
	"REDIR_2FA_DIS"				=> "2Faktor-Authentisierung wurde deaktiviert",
	"REDIR_2FA_VER"				=> "2Faktor-Authentisierung wurde verifiziert und aktiviert",
	"REDIR_SOMETHING_WRONG" => "Irgendetwas ist schief gelaufen. Bitte noch einmal probieren.",
	"REDIR_MSG_NOEX"			=> "Der Thread existiert nicht oder Zugriff verweigert.",
	"REDIR_UN_ONCE"				=> "Benutzername kann nur einmal aktualisiert werden",
	"REDIR_EM_SUCC"				=> "Emailadresse erfolgreich aktualisiert",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "Anmelden mit:",
	"EML_FEATURE_DISABLED" => "Diese Funktion ist deaktiviert",
	"EML_PASSWORDLESS_SENT" => "Bitte überprüfen Sie Ihr E-Mail-Postfach auf einen Anmeldelink.",
	"EML_PASSWORDLESS_SUBJECT" => "Bitte bestätigen Sie Ihre E-Mail-Adresse, um sich anzumelden.",
	"EML_PASSWORDLESS_BODY" => "Bitte bestätigen Sie Ihre E-Mail-Adresse, indem Sie auf den unten stehenden Link klicken. Sie werden automatisch angemeldet.",

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
$lang = array_merge($lang, array(
	"VER_SUC"			=> "Ihre Emailadresse wurde verifiziert!",
	"VER_FAIL"		=> "Ihr Konto konnte nicht verifiziert werden. Bitte erneut versuchen.",
	"VER_RESEND"	=> "Verifizierungsemail neu senden",
	"VER_AGAIN"		=> "Emailadresse nochmal eingeben, und erneut versuchen.",
	"VER_PAGE"		=> "<li>Wir haben Ihnen einen Link per Email gesendet</li><li>Fertig</li>",
	"VER_RES_SUC" => " Ihre Anfrage wurde erhalten. Prüfen Sie bitte Ihren Posteingang, um die Verifizierung auszuführen. Prüfen Sie Bitte Ihren Spam-Ordner, falls Sie die Email im Posteingang nicht finden können.  Gültigkeit des Verifizierungslinks: ",
	"VER_OOPS" 		=> "Oh je! Etwas ist schiefgegengen, Vielleicht wurde ein abgelaufener Reset-Link geklickt. Bitte unten klicken, um neu zu versuchen",
	"VER_RESET" 	=> "Ihr Passwort wurde zurückgesetzt!",
	"VER_INS" 		=> "<li>Emailadresse eingeben und auf zurücksetzen klicken</li> <li>Posteingang prüfen und auf den Reset-Link Klicken.</li> <li>Bildschirmanweisungen folgen</li>",
	"VER_SENT" 		=> " Einen Link zur Passwortrücksetzung wurde Ihnen per Email gschickt.   Bitte darauf klicken, um Ihr Passwort zurück zu setzen. Prüfen Sie Bitte Ihren Spam-Ordner, falls Sie die Email im Posteingang nicht finden können.  Gültigkeit des Verifizierungslinks: ",
	"VER_PLEASE" => "Bitte setzen Sie Ihr Passwort zurück",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"				=> "PIN zurücksetzen",
	"SET_WHY"				=> "Warum kann ich das nicht ändern?",
	"SET_PW_MATCH"	=> "Muss das neue Passwort übereinstimmen",

	"SET_PIN_NEXT"	=> "PIN kann bei n&auml;chstem Verifizierungsberarf erneut werden",
	"SET_UPDATE"		=> "Benutzereinstellungen aktualisieren",
	"SET_NOCHANGE"	=> "Änderung des Benutzername ist deaktiviert.",
	"SET_ONECHANGE"	=> "Benutzername kann nur einmal geändert werden. Ihr Benutzername wurden bereits einmal geändert.",

	"SET_GRAVITAR"	=> "Wollen Sie Ihr Profilbild ändern?  <br> Bitte ein Konto auf <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> mit der selben Emailadresse erstellen. Es funktioniert auf vielen Websiten. Es geht schnell und einfach!",

	"SET_NOTE1"			=> " Hinweis  Wir haben eine ausstehende Anfrage, Ihre Emailadresse nach",

	"SET_NOTE2"			=> ".   zu ändern. Bitte den Link in der Verifizierungsemail benutzen um Ihre Anfrage fort zu setzen. 
		 Um die Verifizierungsemail nochmal zu erhalten, Geben Sie bitte Ihre Emailadresse oben ein, und die Formular neu senden. ",

	"SET_PW_REQ" 		=> "Benötigt, um Ihr Passwort, PIN, oder Emailadresse zu ändern",
	"SET_PW_REQI" 	=> "Benötigt, um Ihr Passwort zu ändern",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "Aktive Sitzung konnte nicht geschlossen werden, Fehler: ",
	"ERR_EMAIL"				=> "Email wurde nicht gesendet. Bitte Administrator kontaktieren.",
	"ERR_EM_DB"				=> "Diese Emailadresse existiert in unserer Datenbank nicht.",
	"ERR_TC"					=> "AGB bitte lesen und akzeptieren",
	"ERR_CAP"					=> "Captcha-Test nicht bestanden, Roboter!",
	"ERR_PW_SAME"			=> "Das neue Passwort muss anders als das alte Passwort sein.",
	"ERR_PW_FAIL"			=> "Altes Passwort stimmt nicht. Aktualisierung fehlgeschlagen. Bitte erneut versuchen.",
	"ERR_GOOG"				=> "Hinweis:  Falls Sie sich mit Ihrem Google/Facebook Konto registriert haben, müssen sie den - Passwort vergessen - Link benutzen, um Ihr Passwort zu ändern, es sei denn, dass Sie richtig gut raten können",
	"ERR_EM_VER"			=>  "Email&uuml;berpr&uuml;fung ist nicht aktiviert. Bitte Systemadministrator kontaktieren.",
	"ERR_EMAIL_STR"		=> "Etwas stimmt nicht. Emailadresse bitte überprüfen. Entschuldigung sie die Unannehmlichkeit.",
));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "Wir werden bald zur&uuml;ck sein!",
	"MAINT_MSG"			=> "Entschuldigung Sie die Unannehmlichkeiten, wir führen gerade enige Wartungsarbeiten aus.<br> Wir werden in Kürze wieder online sein!",
	"MAINT_BAN" 		=> "Es tut uns leid. Sie wurden Blockiert. Bitte den Systemadministrator kontaktieren, falls Sie glauben, das es einen Fehler gibt.",
	"MAINT_TOK" 		=> "Es gibt einen Fehler im Formular. Bitte erneut versuchen. Hinweis: Sollte dies erneut passieren, wenden sie sich bitte an den Administrator.",
	"MAINT_OPEN" 		=> "Ein quelloffenes PHP-Benutzerverwaltungssystem.",
	"MAINT_PLEASE" 	=> "Sie haben Userspice erfolgreich installiert!<br>Die Kurzanleitung befindet sich unter ",
));

//Database Menus
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
