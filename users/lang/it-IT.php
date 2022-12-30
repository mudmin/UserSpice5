<?php
/*
Do not put any content above the opening PHP tag
TO CREATE A NEW LANGUAGE, COPY THE en-us.php to your own localization code name.
We are going to keep these files in the iso xx-xx format because that will also
allow us to autoformat numbers on the sites.

PLEASE put your name somewhere at the top of the language file so we can get in touch with
you to update it and thank you for your hard work!

PLEASE NOTE: DO NOT ADD RANDOM KEYS in the middle of the translations. In order to make it easier to tell what language keys are missing, from this point forward, we are going to add all new language keys at the BOTTOM of this file. The number of lines in your language file will tell you which keys still need to be translated. If you have questions please ask on the forums or on Discord.

UserSpice
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

/*
%m1% - Dymamic markers which are replaced at run time by the relevant index.
*/

$lang = array();
//important strings
//You defiitely want to customize these for your language
$lang = array_merge($lang, array(
    "THIS_LANGUAGE" 		=> "Italiano",
    "THIS_CODE" 		=> "it-IT",
    "MISSING_TEXT" 		=> "Testo mancante"
));

//Database Menus
$lang = array_merge($lang, array(
    "MENU_HOME" 		=> "Inizio",
    "MENU_HELP" 		=> "Aiuto",
    "MENU_ACCOUNT" 		=> "Il mio Account",
    "MENU_DASH" 		=> "Cruscotto Admin",
    "MENU_USER_MGR" 	=> "Gestione Utenti",
    "MENU_PAGE_MGR" 	=> "Gestione Pagine",
    "MENU_PERM_MGR" 	=> "Gestione Permessi",
    "MENU_MSGS_MGR" 	=> "Gestione Messaggi",
    "MENU_LOGS_MGR" 	=> "Accesso al Sistema",
    "MENU_LOGOUT" 		=> "Uscita"
));

// Signup
$lang = array_merge($lang, array(
    "SIGNUP_TEXT" 		=> "Registrazione",
    "SIGNUP_BUTTONTEXT" => "Registrami",
    "SIGNUP_AUDITTEXT" 	=> "Registrato"
));

// Signin
$lang = array_merge($lang, array(
    "SIGNIN_FAIL" 		=> "** ERRORE DI ACCESSO **",
    "SIGNIN_PLEASE_CHK" => "Si prega di controllare il proprio Nome Utente e di riprovare",
    "SIGNIN_UORE" 		=> "Nome Utente o Email",
    "SIGNIN_PASS" 		=> "Password",
    "SIGNIN_TITLE" 		=> "Si prega di effettuare l'accesso",
    "SIGNIN_TEXT" 		=> "Login",
    "SIGNOUT_TEXT" 		=> "Logout",
    "SIGNIN_BUTTONTEXT" => "Login",
    "SIGNIN_REMEMBER" 	=> "Ricordami",
    "SIGNIN_AUDITTEXT" 	=> "Connesso",
   	"SIGNIN_FORGOTPASS"	=>"Password dimenticata",
    "SIGNOUT_AUDITTEXT" => "Disconnesso"
));

// Account Page
$lang = array_merge($lang, array(
    "ACCT_EDIT" 		=> "Modifica Account",
    "ACCT_2FA" 			=> "Gestisci doppia autenticazione",
    "ACCT_SESS" 		=> "Gestisci Sessioni",
    "ACCT_HOME" 		=> "Il mio Account",
    "ACCT_SINCE" 		=> "Membro dal",
    "ACCT_LOGINS" 		=> "Numero Accessi",
    "ACCT_SESSIONS" 	=> "Sessioni Attive",
    "ACCT_MNG_SES" 		=> "Clicca sul pulsante Gestisci sessioni nella barra laterale di sinistra per ulteriori informazioni."
));

//General Terms
$lang = array_merge($lang, array(
    "GEN_ENABLED" 		=> "Attivato",
    "GEN_DISABLED" 		=> "Disattivato",
    "GEN_ENABLE" 		=> "Attivare",
    "GEN_DISABLE" 		=> "Disattivare",
    "GEN_NO" 			=> "No",
    "GEN_YES" 			=> "Si",
    "GEN_MIN" 			=> "minimo",
    "GEN_MAX" 			=> "massimo",
    "GEN_CHAR"				=> "caratteri", //as in characters
    "GEN_SUBMIT" 		=> "Invio",
    "GEN_MANAGE" 		=> "Gestire",
    "GEN_VERIFY" 		=> "Verifica",
    "GEN_SESSION" 		=> "Sessione",
    "GEN_SESSIONS" 		=> "Sessioni",
    "GEN_EMAIL" 		=> "Email",
    "GEN_FNAME" 		=> "Nome",
    "GEN_LNAME" 		=> "Cognome",
    "GEN_UNAME" 		=> "Nome Utente",
    "GEN_PASS" 			=> "Password",
    "GEN_MSG" 			=> "Messaggio",
    "GEN_TODAY" 		=> "Oggi",
    "GEN_CLOSE" 		=> "Chiudere",
    "GEN_CANCEL" 		=> "Cancellare",
    "GEN_CHECK" 		=> "[ seleziona/deseleziona tutto ]",
    "GEN_WITH" 			=> "con",
    "GEN_UPDATED" 		=> "Aggiornato",
    "GEN_UPDATE" 		=> "Aggiornare",
    "GEN_BY" 			=> "per",
    "GEN_FUNCTIONS" 	=> "Funzioni",
    "GEN_NUMBER" 		=> "numero",
    "GEN_NUMBERS" 		=> "numeri",
    "GEN_INFO" 			=> "Informazioni",
    "GEN_REC" 			=> "Registrato",
    "GEN_DEL" 			=> "Eliminare",
    "GEN_NOT_AVAIL" 	=> "Non Disponibile",
    "GEN_AVAIL" 		=> "Disponibile",
    "GEN_BACK" 			=> "Indietro",
    "GEN_RESET" 		=> "Resettare",
    "GEN_REQ" 			=> "obbligatorio",
    "GEN_AND" 			=> "e",
    "GEN_SAME" 			=> "deve essere uguale"
));

//validation class
$lang = array_merge($lang, array(
    "VAL_SAME" 			=> "deve essere uguale",
    "VAL_EXISTS" 		=> "esiste gi&agrve;. Per favore, scegli altro",
    "VAL_DB" 			=> "Errore nel Database",
    "VAL_NUM" 			=> "deve essere un numero",
    "VAL_INT" 			=> "deve essere un numero intero",
    "VAL_EMAIL" 		=> "deve essere un indirizzo email valido",
    "VAL_NO_EMAIL" 		=> "non pu&ograve; essere un indirizzo email",
    "VAL_SERVER" 		=> "deve essere un server valido",
    "VAL_LESS" 			=> "deve essere minore di",
    "VAL_GREAT" 		=> "deve essere maggiore di",
    "VAL_LESS_EQ" 		=> "deve essere minore o uguale a",
    "VAL_GREAT_EQ" 		=> "deve essere maggiore o uguale a",
    "VAL_NOT_EQ" 		=> "non deve essere uguale a",
    "VAL_EQ" 			=> "deve essere uguale a",
    "VAL_TZ" 			=> "deve essere un nome di fuso orario valido",
    "VAL_MUST" 			=> "deve essere",
    "VAL_MUST_LIST" 	=> "deve essere uno dei seguenti",
    "VAL_TIME" 			=> "deve essere un orario valido",
    "VAL_SEL" 			=> "selezione non valida",
    "VAL_NA_PHONE" 		=> "deve essere un numero di telefono nordamericano valido"
));

//Time
$lang = array_merge($lang, array(
    "T_YEARS" 			=> "Anni",
    "T_YEAR" 			=> "Anno",
    "T_MONTHS" 			=> "Mesi",
    "T_MONTH" 			=> "Mese",
    "T_WEEKS" 			=> "Settimane",
    "T_WEEK" 			=> "Settimana",
    "T_DAYS" 			=> "Giorni",
    "T_DAY" 			=> "Giorno",
    "T_HOURS" 			=> "Ore",
    "T_HOUR" 			=> "Ora",
    "T_MINUTES" 		=> "Minuti",
    "T_MINUTE" 			=> "Minuto",
    "T_SECONDS" 		=> "Secondi",
    "T_SECOND" 			=> "Secondo"
));


//Passwords
$lang = array_merge($lang, array(
    "PW_NEW" 			=> "Nuova Password",
    "PW_OLD" 			=> "Password Precedente",
    "PW_CONF" 			=> "Conferma Password",
    "PW_RESET" 			=> "Reimposta Password",
    "PW_UPD" 			=> "Password Aggiornata",
    "PW_SHOULD" 		=> "La password dovrebbe...",
    "PW_SHOW" 			=> "Mostra Password",
    "PW_SHOWS" 			=> "Mostra password"
));


//Join
$lang = array_merge($lang, array(
    "JOIN_SUC" 			=> "Benvenuto a ",
    "JOIN_THANKS" 		=> "Grazie per esserti registrato",
    "JOIN_HAVE" 		=> "Avere almeno ",
    "JOIN_CAP" 			=> " lettera maiuscola",
    "JOIN_TWICE" 		=> "Essere scritto correttamente due volte",
    "JOIN_CLOSED" 		=> "In questo momento la registrazione &egrave; disabilitata. Per favore, contattare l'amministratore del sito per qualsiasi informazione.",
    "JOIN_TC" 			=> "Termini e condizioni per l'utente per la registrazione",
    "JOIN_ACCEPTTC" 	=> "Accetto i Termini e le condizioni per l'utente",
    "JOIN_CHANGED" 		=> "I nostri termini sono cambiati",
    "JOIN_ACCEPT" 		=> "Accetta i Termini e le condizioni per l'utente e continua"
));

//Sessions
$lang = array_merge($lang, array(
    "SESS_SUC" 			=> "Terminato correttamente "
));

//Messages
$lang = array_merge($lang, array(
    "MSG_SENT" 			=> "Il messaggio &egrave; stato inviato!",
    "MSG_MASS" 			=> "Il messaggio multiplo &egrave; stato inviato!",
    "MSG_NEW" 			=> "Nuovo messaggio",
    "MSG_NEW_MASS" 		=> "Nuovo messaggio multiplo",
    "MSG_CONV" 			=> "Conversazioni",
    "MSG_NO_CONV" 		=> "Nessuna conversazione",
    "MSG_NO_ARC" 		=> "Nessuna conversazione",
    "MSG_QUEST" 		=> "Invia email con notifiche se Attiva?",
    "MSG_ARC" 			=> "Thread archiviato",
    "MSG_VIEW_ARC" 		=> "Vedi Thread archiviati",
    "MSG_SETTINGS" 		=> "Impostazioni dei messaggi",
    "MSG_READ" 			=> "Leggere",
    "MSG_BODY" 			=> "Corpo",
    "MSG_SUB" 			=> "Oggetto",
    "MSG_DEL" 			=> "Inviato",
    "MSG_REPLY" 		=> "Rispondere",
    "MSG_QUICK" 		=> "Risposta Rapida",
    "MSG_SELECT" 		=> "Selezionare un Utente",
    "MSG_UNKN" 			=> "Destinatario sconosciuto",
    "MSG_NOTIF" 		=> "Messaggio di notifica via email",
    "MSG_BLANK" 		=> "Il messaggio non può essere vuoto",
    "MSG_MODAL" 		=> "Fare clic qui o premere Alt + R per mettere a fuoco questa casella OPPURE premere Maiusc + R per aprire il riquadro di risposta esteso!",
    "MSG_ARCHIVE_SUCCESSFUL" 		=> "Sono stati archiviati %m1% thread correttamente",
    "MSG_UNARCHIVE_SUCCESSFUL" 		=> "Sono stati espansi %m1% thread correttamente",
    "MSG_DELETE_SUCCESSFUL" 		=> "Sono stati eliminati %m1% thread correttamente",
    "USER_MESSAGE_EXEMPT" 			=> "L'Utente %m1% non riceve messaggi.",
    "MSG_MK_READ" 		=> "Leggere",
    "MSG_MK_UNREAD" 	=> "Non letto",
    "MSG_ARC_THR" 		=> "Archiviare i Thread Selezionati",
    "MSG_UN_THR" 		=> "Espandere i Thread Selezionati",
    "MSG_DEL_THR" 		=> "Eliminare i Thread Selezionati",
    "MSG_SEND" 			=> "Inviare Messaggio"
));

//2 Factor Authentication
$lang = array_merge($lang, array(
    "2FA" 			=> "Autenticazione a due fattori (2FA)",
    "2FA_CONF" 		=> "Sei sicuro di voler disattivare 2FA? Il tuo account sarà non protetto.",
    "2FA_SCAN" 		=> "Esegui la scansione di questo codice QR con la l'app di autenticazione o inserisci la chiave",
    "2FA_THEN" 		=> "Quindi digita una delle tue chiavi monouso qui.",
    "2FA_FAIL" 		=> "Si è verificato un problema durante la verifica di 2FA. Controlla la tua connessione o contatta l'assistenza.",
    "2FA_CODE" 		=> "Chiave 2FA",
    "2FA_EXP" 		=> "1 impronta digitale scaduta",
    "2FA_EXPD" 		=> "Scaduta",
    "2FA_EXPS" 		=> "Scade",
    "2FA_ACTIVE" 	=> "Sessioni attive",
    "2FA_NOT_FN" 	=> "Nessuna impronta digitale trovata",
    "2FA_FP" 		=> "Impronte digitali",
    "2FA_NP" 		=> "<strong>Login Fallito</strong> Codice 2FA non presente. Riprova per favore.",
    "2FA_INV" 		=> "<strong>Login Fallito</strong> Codice 2FA non valido. Riprova per favore.",
    "2FA_FATAL" 	=> "<strong>Errore fatale</strong> Per favore, contatta l'Amministratore di sistema."
));

//Redirect Messages - These get a plus between each word
$lang = array_merge($lang, array(
    "REDIR_2FA" 			=> "Spiacenti.2FA+non+&egrave;+disponibile+in+questo+momento",
    "REDIR_2FA_EN" 			=> "Autenticazione+2FA+Abilitata",
    "REDIR_2FA_DIS" 		=> "Autenticazione+2FA+Disattivata",
    "REDIR_2FA_VER" 		=> "Autenticazione+2FA+Verificata+e+Abilitata",
    "REDIR_SOM_TING_WONG" 	=> "Qualcosa+&egrave;+andato+male.+Per+favore+prova+di+nuovo.",
    "REDIR_MSG_NOEX" 		=> "Quel+thread+non+&egrave;+tuo+o+non+esiste.",
    "REDIR_UN_ONCE" 		=> "Il+Nome+Utente+&egrave;+gi&agrave;+stato+modificato+una+volta.",
    "REDIR_EM_SUCC" 		=> "Email+Aggiornata+Correttamente"
));

//Emails
$lang = array_merge($lang, array(
    "EML_CONF" 		=> "Confermare Email",
    "EML_VER" 		=> "Verifica la tua Email",
    "EML_CHK" 		=> "Richiesta ricevuta. Si prega di controllare la posta per la verifica. Assicurati di controllare la cartella Spam e Junk, poich&eacute; il link di verifica scade tra ",
    "EML_MAT" 		=> "La tua email non coincide.",
    "EML_HELLO" 	=> "Ciao da ",
    "EML_HI" 		=> "Ciao ",
    "EML_AD_HAS" 	=> "Un amministratore ha reimpostato la tua password.",
    "EML_AC_HAS" 	=> "Un amministratore ha creato il tuo account.",
    "EML_REQ" 		=> "Ti verr&agrave; chiesto di impostare la tua password usando il link sopra.",
    "EML_EXP" 		=> "Attenzione, i link delle password scadono tra ",
    "EML_VER_EXP" 	=> "Attenzione, i link di verifica scadono tra ",
    "EML_CLICK" 	=> "Clicca qui per accedere.",
    "EML_REC" 		=> "Si consiglia di modificare la password subito dopo l'accesso.",
    "EML_MSG" 		=> "Hai un nuovo messaggio da",
    "EML_REPLY" 	=> "Clicca qui per rispondere o vedere il thread",
    "EML_WHY" 		=> "Hai ricevuto questa email perch&eacute; hai richiesto il ripristino della tua password. Se non sei stato tu, ignora questa email.",
    "EML_HOW" 		=> "Se sei stato tu, clicca sul link per continuare con il processo di reimpostazione.",
    "EML_EML" 		=> "Una richiesta di modificare la tua email &egrave; stata fatta dal tuo account utente.",
    "EML_VER_EML" 	=> "Grazie per esserti registrato. Una volta verificato il tuo indirizzo email, sarai pronto per accedere! Clicca sul seguente link per verificare il tuo indirizzo email."

));

//Verification
$lang = array_merge($lang, array(
    "VER_SUC" 		=> "La tua email &egrave; stata verificata!",
    "VER_FAIL" 		=> "Non siamo riusciti a verificare il tuo account. Per favore riprova.",
    "VER_RESEND" 	=> "Invia di nuovo l'email di verifica.",
    "VER_AGAIN" 	=> "Inserisci il tuo indirizzo email e riprova",
    "VER_PAGE" 		=> "<li>Controlla la tua email e clicca sul link che ti è stato inviato</li><li>Fatto</li>",
    "VER_RES_SUC" 	=> "<p>Il tuo link di verifica &egrave; stato inviato al tuo indirizzo email.</p><p>Clicca sul link inviato per completare la verifica. Assicurati di controllare la tua cartella spam se l'e-mail non si trova nella tua casella di posta.</p><p>I link di verifica sono validi solo per ",
    "VER_OOPS" 		=> "Mannaggia... sembra che qualcosa sia andato storto. Forse hai cliccato su un vecchio link di reset. Clicca qui sotto per riprovare",
    "VER_RESET" 	=> "La tua password &egrave; stata resettata!",
    "VER_INS" 		=> "<li>Inserisci il tuo indirizzo email e clicca su Ripristina</li> <li>Controlla la tua email e clicca sul link che ti &egrave; stato inviato.</li> <li>Seguire le istruzioni indicate a schermo</li>",
    "VER_SENT" 		=> "<p>Il link per la reimpostazione della password &egrave; stato inviato alla tua email.</p> <p>Clicca sul link nell'e-mail per reimpostare la password. Se non vedi l'e-mail, controlla la tua casella di spam.</p><p>Link valido solo per ",
    "VER_PLEASE" 	=> "Reimposta la tua password"
));

//User Settings
$lang = array_merge($lang, array(
    "SET_PIN" 			=> "Reimposta PIN",
    "SET_WHY" 			=> "Perch&eacute; non posso modificare questo?",
    "SET_PW_MATCH" 		=> "Deve corrispondere alla nuova password",
    "SET_PIN_NEXT" 		=> "&Egrave; possibile impostare un nuovo PIN la prossima volta che viene richiesta la verifica.",
    "SET_UPDATE" 		=> "Aggiorna la tua configurazione utente",
    "SET_NOCHANGE" 		=> "L'amministratore ha disattivato la modifica dei nomi utente.",
    "SET_ONECHANGE" 	=> "L'amministratore ha stabilito che le modifiche al nome utente possono essere apportate una sola volta e l'hai gi&agrave; fatto.",
    "SET_GRAVITAR" 		=> "<strong>Vuoi cambiare la foto del tuo profilo? </strong><br> Visita <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a>e crea un account con la stessa email che hai usato su questo sito. Sono presenti in milioni di siti. &Egrave; veloce e semplice!",
    "SET_NOTE1" 		=> "<p><strong>Attenzione prego,</strong> C'&egrave; una richiesta in sospeso per aggiornare la tua email a",
    "SET_NOTE2" 		=> ".</p><p>Si prega di utilizzare l'e-mail di verifica per completare questa richiesta.</p> <p>Se hai bisogno di una nuova email di verifica, ridigita l'email precedente e invia nuovamente la richiesta.</p>",
    "SET_PW_REQ" 		=> "obbligatorio per cambiare password, e-mail o reimpostare il PIN",
    "SET_PW_REQI" 		=> "Obbligatorio per cambiare password"

));

//Errors
$lang = array_merge($lang, array(
    "ERR_FAIL_ACT" 		=> "Impossibile eliminare sessioni attive, errore: ",
    "ERR_EMAIL" 		=> "L'email NON &egrave; stata inviata a causa di un errore. Per favore, contatta l'amministratore del sito.",
    "ERR_EM_DB" 		=> "Questa email non esiste nel nostro database",
    "ERR_TC" 			=> "Si prega di leggere e accettare i termini e condizioni d'uso ",
    "ERR_CAP" 			=> "Non hai superato il test di prova umana, Robot!",
    "ERR_PW_SAME" 		=> "La tua password precedente non pu&ograve; essere la stessa di quella nuova",
    "ERR_PW_FAIL" 		=> "Mancata verifica della password corrente. Aggiornamento fallito. Per favore riprova.",
    "ERR_GOOG" 			=> "<strong>ATTENZIONE: </ strong> se hai effettuato l'accesso con il tuo account Google/Facebook dall'inizio, dovrai usare il link di cancellazione del codice d'accesso per cambiare la tua password ... a meno che tu non sia veramente bravo a indovinare.",
    "ERR_EM_VER" 		=> "La verifica via email non &egrave; abilitata. Per favore, contatta l'amministratore del sito.",
    "ERR_EMAIL_STR" 	=> "C'&egrave; qualcosa di strano. Per favore ricontrolla la tua email. Ci scusiamo per l'inconveniente"

));

//Maintenance Page
$lang = array_merge($lang, array(
    "MAINT_HEAD" 		=> "Torneremo presto!",
    "MAINT_MSG" 		=> "Ci scusiamo per l'inconveniente, ma al momento stiamo effettuando degli interventi di manutenzione. <br> Torneremo presto online!",
    "MAINT_BAN" 		=> "Siamo spiacenti. Sei stato bannato. Se ritieni che si tratti di un errore, contatta l'amministratore.",
    "MAINT_TOK" 		=> "C'&egrave; stato un errore nel tuo modulo. Per favore torna indietro e riprova. Si prega di notare che l'invio del modulo aggiornando la pagina causer&agrave; un errore. Se ci&ograve; dovesse continuare, contattare l'amministratore.",
    "MAINT_OPEN" 		=> "Un framework open source in PHP per la gestione degli utenti.",
    "MAINT_PLEASE" 		=> "Hai installato con successo UserSpice! <br> Per visualizzare la documentazione introduttiva, visita"
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
    "DAT_SEARCH" 		=> "Ricerca",
    "DAT_FIRST" 		=> "Primo",
    "DAT_LAST" 			=> "Ultimo",
    "DAT_NEXT" 			=> "Seguente",
    "DAT_PREV" 			=> "Precedente",
    "DAT_NODATA" 		=> "La tabella non contiene dati",
    "DAT_INFO" 			=> "Visualizzazione delle voci da _START_ a _END_ di _TOTAL_",
    "DAT_ZERO" 			=> "Visualizzazione delle voci da 0 a 0 di 0",
    "DAT_FILTERED" 		=> "(Filtro di un totale di _MAX_ voci)",
    "DAT_MENU_LENG" 	=> "Mostra le voci _MENU_",
    "DAT_LOADING" 		=> "Caricamento...",
    "DAT_PROCESS" 		=> "Elaborazione...",
    "DAT_NO_REC" 		=> "Non ci sono record che corrispondono",
    "DAT_ASC" 			=> "Attiva per ordinare la colonna in ordine crescente",
    "DAT_DESC" 			=> "Attiva per ordinare la colonna in ordine decrescent"
));



//LEAVE THIS LINE AT THE BOTTOM. It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
    include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
