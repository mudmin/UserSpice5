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
%m1% - Dynamic markers which are replaced at run time by the relevant index.
*/

$lang = array();
//important strings
//You definitely want to customize these for your language
$lang = array_merge($lang, array(
    "THIS_LANGUAGE"         => "Italiano",
    "THIS_CODE"         => "it-IT",
    "MISSING_TEXT"         => "Testo mancante"
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "Inserisci il codice inviato alla tua email",
    "PASS_EMAIL_ONLY"     => "Per favore controlla la tua email per il link di accesso",
    "PASS_CODE_ONLY"      => "Per favore inserisci il codice inviato alla tua email",
    "PASS_BOTH"           => "Per favore controlla la tua email per il link di accesso o inserisci il codice inviato",
    "PASS_VER_BUTTON"     => "Verifica codice",
    "PASS_EMAIL_ONLY_MSG" => "Per favore verifica il tuo indirizzo email cliccando sul link qui sotto",
    "PASS_CODE_ONLY_MSG"  => "Per favore inserisci il codice qui sotto per accedere",
    "PASS_BOTH_MSG"       => "Per favore verifica il tuo indirizzo email cliccando sul link qui sotto o inserisci il codice per accedere",
    "PASS_YOUR_CODE"      => "Il tuo codice di verifica è: ",
    "PASS_CONFIRM_LOGIN"  => "Conferma accesso",
    "PASS_CONFIRM_CLICK"  => "Clicca per completare l'accesso",
    "PASS_GENERIC_ERROR"  => "Qualcosa è andato storto",
));

//Database Menus
$lang = array_merge($lang, array(
    "MENU_HOME"         => "Inizio",
    "MENU_HELP"         => "Aiuto",
    "MENU_ACCOUNT"         => "Il mio Account",
    "MENU_DASH"         => "Cruscotto Admin",
    "MENU_USER_MGR"     => "Gestione Utenti",
    "MENU_PAGE_MGR"     => "Gestione Pagine",
    "MENU_PERM_MGR"     => "Gestione Permessi",
    "MENU_MSGS_MGR"     => "Gestione Messaggi",
    "MENU_LOGS_MGR"     => "Accesso al Sistema",
    "MENU_LOGOUT"         => "Uscita"
));

// Signup
$lang = array_merge($lang, array(
    "SIGNUP_TEXT"         => "Registrazione",
    "SIGNUP_BUTTONTEXT" => "Registrami",
    "SIGNUP_AUDITTEXT"     => "Registrato"
));

// Signin
$lang = array_merge($lang, array(
    "SIGNIN_FAIL"         => "** ERRORE DI ACCESSO **",
    "SIGNIN_PLEASE_CHK" => "Si prega di controllare il proprio Nome Utente e di riprovare",
    "SIGNIN_UORE"         => "Nome Utente o Email",
    "SIGNIN_PASS"         => "Password",
    "SIGNIN_TITLE"         => "Si prega di effettuare l'accesso",
    "SIGNIN_TEXT"         => "Login",
    "SIGNOUT_TEXT"         => "Logout",
    "SIGNIN_BUTTONTEXT" => "Login",
    "SIGNIN_REMEMBER"     => "Ricordami",
    "SIGNIN_AUDITTEXT"     => "Connesso",
    "SIGNIN_FORGOTPASS"    => "Password dimenticata",
    "SIGNOUT_AUDITTEXT" => "Disconnesso"
));

// Account Page
$lang = array_merge($lang, array(
    "ACCT_EDIT"         => "Modifica Account",
    "ACCT_2FA"             => "Gestisci doppia autenticazione",
    "ACCT_SESS"         => "Gestisci Sessioni",
    "ACCT_HOME"         => "Il mio Account",
    "ACCT_SINCE"         => "Membro dal",
    "ACCT_LOGINS"         => "Numero Accessi",
    "ACCT_SESSIONS"     => "Sessioni Attive",
    "ACCT_MNG_SES"         => "Clicca sul pulsante Gestisci sessioni nella barra laterale di sinistra per ulteriori informazioni."
));

//General Terms
$lang = array_merge($lang, array(
    "GEN_ENABLED"         => "Attivato",
    "GEN_DISABLED"         => "Disattivato",
    "GEN_ENABLE"         => "Attivare",
    "GEN_DISABLE"         => "Disattivare",
    "GEN_NO"             => "No",
    "GEN_YES"             => "Si",
    "GEN_MIN"             => "minimo",
    "GEN_MAX"             => "massimo",
    "GEN_CHAR"                => "caratteri", //as in characters
    "GEN_SUBMIT"         => "Invio",
    "GEN_MANAGE"         => "Gestire",
    "GEN_VERIFY"         => "Verifica",
    "GEN_SESSION"         => "Sessione",
    "GEN_SESSIONS"         => "Sessioni",
    "GEN_EMAIL"         => "Email",
    "GEN_FNAME"         => "Nome",
    "GEN_LNAME"         => "Cognome",
    "GEN_UNAME"         => "Nome Utente",
    "GEN_PASS"             => "Password",
    "GEN_MSG"             => "Messaggio",
    "GEN_TODAY"         => "Oggi",
    "GEN_CLOSE"         => "Chiudere",
    "GEN_CANCEL"         => "Cancellare",
    "GEN_CHECK"         => "[ seleziona/deseleziona tutto ]",
    "GEN_WITH"             => "con",
    "GEN_UPDATED"         => "Aggiornato",
    "GEN_UPDATE"         => "Aggiornare",
    "GEN_BY"             => "per",
    "GEN_FUNCTIONS"     => "Funzioni",
    "GEN_NUMBER"         => "numero",
    "GEN_NUMBERS"         => "numeri",
    "GEN_INFO"             => "Informazioni",
    "GEN_REC"             => "Registrato",
    "GEN_DEL"             => "Eliminare",
    "GEN_NOT_AVAIL"     => "Non Disponibile",
    "GEN_AVAIL"         => "Disponibile",
    "GEN_BACK"             => "Indietro",
    "GEN_RESET"         => "Resettare",
    "GEN_REQ"             => "obbligatorio",
    "GEN_AND"             => "e",
    "GEN_SAME"             => "deve essere uguale"
));

// Passkey Translations
$lang = array_merge($lang, array(
    "GEN_PASSKEY"           => "Passkey",
    "GEN_ACTIONS"           => "Azioni",
    "GEN_BACK_TO_ACCT"      => "Torna all'account",
    "GEN_DB_ERROR"          => "Si è verificato un errore del database. Riprova.",
    "GEN_IMPORTANT"         => "Importante",
    "GEN_NO_PERMISSIONS"    => "Non hai il permesso per accedere a questa pagina.",
    "GEN_NO_PERMISSIONS_MSG" => "Non hai il permesso per accedere a questa pagina. Se pensi che sia un errore, contatta l'amministratore del sito.",
    "PASSKEYS_MANAGE_TITLE" => "Gestisci Passkey",
    "PASSKEYS_LOGIN_TITLE"  => "Accesso con Passkey",
    "PASSKEY_DELETE_SUCCESS" => "Passkey eliminata con successo.",
    "PASSKEY_DELETE_FAIL_DB" => "Impossibile eliminare la passkey dal database.",
    "PASSKEY_DELETE_NOT_FOUND" => "Passkey non trovata o non hai il permesso per eliminarla.",
    "PASSKEY_NOTE_UPDATE_SUCCESS" => "Nota della passkey aggiornata con successo.",
    "PASSKEY_NOTE_UPDATE_FAIL" => "Impossibile aggiornare la nota della passkey.",
    "PASSKEY_REGISTER_NEW"  => "Registra nuova Passkey",
    "PASSKEY_ERR_LIMIT_REACHED" => "Hai raggiunto il massimo di 10 passkey.",
    "PASSKEY_NOTE_TH"       => "Nota Passkey",
    "PASSKEY_TIMES_USED_TH" => "Volte utilizzata",
    "PASSKEY_LAST_USED_TH"  => "Ultimo utilizzo",
    "PASSKEY_LAST_IP_TH"    => "Ultimo IP",
    "PASSKEY_EDIT_NOTE_BTN" => "Modifica nota",
    "PASSKEY_CONFIRM_DELETE_JS" => "Sei sicuro di voler eliminare questa passkey?",
    "PASSKEY_EDIT_MODAL_TITLE" => "Modifica nota Passkey",
    "PASSKEY_EDIT_MODAL_LABEL" => "Nota Passkey",
    "PASSKEY_SAVE_CHANGES_BTN" => "Salva modifiche",
    "PASSKEY_NONE_REGISTERED" => "Non hai ancora nessuna passkey registrata.",
    "PASSKEY_MUST_REGISTER_FIRST" => "Devi prima registrare una passkey da un account autenticato prima di utilizzare questa funzione.",
    "PASSKEY_STORING"       => "Salvataggio passkey...",
    "PASSKEY_STORED_SUCCESS" => "Passkey salvata con successo!",
    "PASSKEY_INVALID_ACTION" => "Azione non valida: ",
    "PASSKEY_NO_ACTION_SPECIFIED" => "Nessuna azione specificata",
    "PASSKEY_ERR_NETWORK_SUGGESTION" => "Rilevato un problema di rete. Prova con una rete diversa o aggiorna la pagina.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "Rilevata autenticazione tra dispositivi. Assicurati che entrambi i dispositivi abbiano accesso a internet.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "Prova ad aprire questa pagina direttamente sul tuo telefono.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED" => "Impossibile generare diagnostica: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA" => "Dati delle credenziali richiesti mancanti per il salvataggio.",
    "PASSKEY_MISSING_AUTH_DATA" => "Dati di autenticazione richiesti mancanti.",
    "PASSKEY_LOG_NO_MESSAGE" => "Nessun messaggio",
    "PASSKEY_USER_NOT_FOUND" => "Utente non trovato dopo la validazione della passkey.",
    "PASSKEY_FATAL_ERROR"    => "Errore fatale: ",
    "PASSKEY_LOGIN_SUCCESS"  => "Accesso riuscito.",
    "PASSKEY_CROSS_DEVICE_PREP" => "Preparazione registrazione tra dispositivi. Potresti dover utilizzare il tuo telefono o tablet.",
    "PASSKEY_DEVICE_REGISTRATION" => "Utilizzo della registrazione passkey del dispositivo...",
    "PASSKEY_STARTING_REGISTRATION" => "Avvio registrazione passkey...",
    "PASSKEY_REQUEST_OPTIONS" => "Richiesta opzioni di registrazione dal server...",
    "PASSKEY_FOLLOW_PROMPTS" => "Segui le istruzioni per creare la tua passkey. Potresti dover utilizzare un altro dispositivo.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE" => "Segui le istruzioni per creare la tua passkey...",
    "PASSKEY_CREATION_FAILED" => "Creazione passkey fallita - nessuna credenziale restituita.",
    "PASSKEY_STORING_SERVER" => "Salvataggio della tua passkey...",
    "PASSKEY_CREATED_SUCCESS" => "Passkey creata con successo!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP" => "Preparazione autenticazione tra dispositivi. Assicurati che il tuo telefono e computer abbiano accesso a internet.",
    "PASSKEY_DEVICE_AUTH"    => "Utilizzo dell'autenticazione passkey del dispositivo...",
    "PASSKEY_STARTING_AUTH"  => "Avvio autenticazione passkey...",
    "PASSKEY_QR_CODE_INSTRUCTION" => "Scansiona il codice QR con il tuo telefono quando appare. Assicurati che entrambi i dispositivi abbiano accesso a internet.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION" => "Scegli \"Usa un telefono o tablet\" quando richiesto, quindi scansiona il codice QR.",
    "PASSKEY_AUTHENTICATING" => "Autenticazione con la tua passkey...",
    "PASSKEY_SUCCESS_REDIRECTING" => "Autenticazione riuscita! Reindirizzamento...",
    "PASSKEY_TIMEOUT_CROSS_DEVICE" => "Registrazione scaduta. Per tra dispositivi: 1) Riprova, 2) Assicurati che i dispositivi abbiano internet, 3) Considera di registrarti direttamente sul tuo telefono.",
    "PASSKEY_TIMEOUT_SIMPLE" => "Registrazione scaduta. Riprova.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE" => "Autenticazione tra dispositivi scaduta. Risoluzione problemi: 1) Entrambi i dispositivi necessitano di internet, 2) Prova a scansionare il codice QR più velocemente, 3) Considera di usare lo stesso dispositivo, 4) Alcune reti bloccano l'autenticazione tra dispositivi.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE" => "Autenticazione scaduta. Riprova.",
    "PASSKEY_NO_CREDENTIAL"  => "Nessuna credenziale ricevuta. Riprovo...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL" => "Autenticazione fallita - nessuna credenziale restituita.",
    "PASSKEY_ATTEMPT_RETRY"  => "fallito. Riprovo... (%d tentativi rimanenti)",
    "PASSKEY_CROSS_DEVICE_FAILED" => "Registrazione tra dispositivi fallita. Prova: 1) Assicurati che entrambi i dispositivi abbiano internet, 2) Considera di registrarti direttamente sul tuo telefono, 3) Alcune reti aziendali bloccano questa funzione.",
    "PASSKEY_REGISTRATION_CANCELLED" => "Registrazione annullata o il dispositivo non supporta passkey.",
    "PASSKEY_NOT_SUPPORTED"  => "Le passkey non sono supportate su questa combinazione dispositivo/browser.",
    "PASSKEY_SECURITY_ERROR" => "Errore di sicurezza - di solito indica una discrepanza di dominio/origine.",
    "PASSKEY_ALREADY_EXISTS" => "Esiste già una passkey per questo account su questo dispositivo. Prova a usare un dispositivo diverso o elimina prima le passkey esistenti.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED" => "Autenticazione tra dispositivi fallita. Prova: 1) Assicurati che entrambi i dispositivi abbiano internet stabile, 2) Usa la stessa rete WiFi se possibile, 3) Prova ad autenticarti direttamente sul tuo telefono, 4) Alcune reti aziendali bloccano questa funzione.",
    "PASSKEY_AUTH_CANCELLED" => "Autenticazione annullata o nessuna passkey selezionata.",
    "PASSKEY_NETWORK_ERROR"  => "Errore di rete. Per l'autenticazione tra dispositivi, entrambi i dispositivi necessitano di accesso a internet e potrebbero dover essere sulla stessa rete.",
    "PASSKEY_CREDENTIAL_NOT_FOUND" => "Autenticazione fallita - credenziale non riconosciuta.",
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "Suggerimenti per l'autenticazione tra dispositivi:",
    "PASSKEY_GUIDANCE_INTERNET" => "Assicurati che sia il tuo computer che il tuo telefono abbiano accesso a internet",
    "PASSKEY_GUIDANCE_WIFI"  => "Essere sulla stessa rete WiFi può aiutare (ma non è sempre necessario)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE" => "Quando richiesto, seleziona \"Usa un telefono o tablet\"",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY" => "Scansiona il codice QR velocemente quando appare",
    "PASSKEY_GUIDANCE_TRY_DIRECT" => "Se fallisce, prova ad aggiornare e utilizzare direttamente il browser del tuo telefono",
    "PASSKEY_SHOW_TROUBLESHOOTING" => "Mostra suggerimenti per la risoluzione dei problemi",
    "PASSKEY_HIDE_TROUBLESHOOTING" => "Nascondi suggerimenti per la risoluzione dei problemi",
    "PASSKEY_DIAGNOSTICS_RUNNING" => "Esecuzione diagnostica...",
    "PASSKEY_DIAGNOSTICS_COMPLETE" => "Diagnostica completata. Controlla la console per i dettagli.",
    "PASSKEY_ISSUES_DETECTED" => "Problemi rilevati:",
    "PASSKEY_ENVIRONMENT_SUITABLE" => "L'ambiente sembra adatto per le passkey.",
    "PASSKEY_DIAGNOSTICS_FAILED" => "Diagnostica fallita:",
    "PASSKEY_ADD_NOTE_NEW"  => "Aggiungi nota alla tua nuova Passkey",
    "PASSKEY_BASE64_ERROR"  => "Errore di decodifica Base64:",
    "PASSKEY_INVALID_JSON"  => "Dati JSON non validi ricevuti:",
    "PASSKEY_LOGIN_REQUIRED" => "Devi essere loggato per eseguire questa azione.",
    "PASSKEY_ACTION_MISSING" => "Il parametro 'azione' richiesto manca dalla richiesta.",
    "PASSKEY_STORAGE_FAILED" => "Impossibile salvare la passkey. L'operazione non è riuscita.",
    "PASSKEY_LOGIN_FAILED"   => "Accesso con passkey fallito. L'autenticazione non può essere verificata.",
    "PASSKEY_INVALID_METHOD" => "Metodo di richiesta non valido:",
    "CSRF_ERROR"            => "Controllo token CSRF fallito. Torna indietro e prova a inviare nuovamente il modulo.",
    "PASSKEY_NETWORK_PRIVATE" => "Possibile problema: Sembra che tu sia su una rete privata, che a volte può interferire con la comunicazione tra dispositivi.",
    "PASSKEY_NETWORK_PROXY"  => "Possibile problema: Rilevato un proxy o VPN. Questo può interferire con la comunicazione tra dispositivi.",
    "PASSKEY_NETWORK_MOBILE" => "Nota: Sembra che tu sia su una rete mobile. Assicurati una connessione stabile per operazioni tra dispositivi.",
    "PASSKEY_NETWORK_CORPORATE" => "Possibile problema: Potrebbe essere attivo un firewall aziendale, che potrebbe influire sull'autenticazione tra dispositivi.",
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "Raccomandazione: Probabilmente stai usando un desktop. Preparati a usare il tuo telefono per scansionare un codice QR.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "Raccomandazione: Per migliori risultati, assicurati che il tuo computer e dispositivo mobile siano sulla stessa rete Wi-Fi.",
    "PASSKEY_RECOMMENDATION_QR_QUICK" => "Raccomandazione: Preparati a scansionare il codice QR velocemente, poiché la richiesta potrebbe scadere.",
    "PASSKEY_RECOMMENDATION_INTERNET" => "Raccomandazione: Assicurati che sia il tuo computer che il tuo dispositivo mobile abbiano una connessione internet stabile.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "Raccomandazione: Per WebViews di Unity, assicurati che la pagina abbia abbastanza tempo per caricare ed elaborare la richiesta di passkey.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "Raccomandazione: I timeout possono essere più lunghi in Unity. Sii paziente.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "Raccomandazione: Poiché sei su mobile, dovresti essere in grado di registrare una passkey direttamente su questo dispositivo.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Raccomandazione: Su Android, puoi gestire le tue passkey nel Gestore di Password di Google.",
    "PASSKEY_VALIDATION_RP_IP" => "Avviso di configurazione: L'ID della parte fidata è impostato su un indirizzo IP.",
    "PASSKEY_VALIDATION_RP_DOMAIN" => "Raccomandazione: Imposta l'ID della parte fidata sul tuo nome di dominio (es. tuositoweb.com) per maggiore sicurezza e compatibilità.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED" => "Errore di configurazione: HTTPS è richiesto per le passkey su un server live. Il tuo sito sembra essere su HTTP.",
    "PASSKEY_VALIDATION_NETWORK" => "Avviso di rete",
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "Raccomandazione: Se riscontri problemi, prova una rete diversa (es. passa da Wi-Fi aziendale a hotspot mobile).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "Raccomandazione: Per azioni tra dispositivi, assicurati che entrambi i dispositivi abbiano una connessione internet affidabile.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK" => "Raccomandazione: Se le azioni tra dispositivi falliscono, prova a visitare questa pagina direttamente sul tuo dispositivo mobile per completare l'azione.",
    "PASSKEY_INFO_TITLE"    => "Informazioni sulle Passkey",
    "PASSKEY_INFO_DESC"     => "Le passkey sono un modo sicuro e senza password per accedere utilizzando le funzionalità di sicurezza integrate del tuo dispositivo, come impronte digitali, riconoscimento facciale o PIN. Sono più sicure delle password, offrono un accesso più veloce, funzionano su più dispositivi quando sincronizzate con gestori di password e sono resistenti agli attacchi di phishing. Le passkey funzionano su smartphone moderni, tablet, computer e possono essere memorizzate in gestori di password come 1Password, Bitwarden, iCloud Keychain o Google Password Manager.",
    "PASSKEY_BACK_TO_LOGIN" => "Torna al login",
));

//validation class
$lang = array_merge($lang, array(
    "VAL_SAME"             => "deve essere uguale",
    "VAL_EXISTS"         => "esiste gi&agrve;. Per favore, scegli altro",
    "VAL_DB"             => "Errore nel Database",
    "VAL_NUM"             => "deve essere un numero",
    "VAL_INT"             => "deve essere un numero intero",
    "VAL_EMAIL"         => "deve essere un indirizzo email valido",
    "VAL_NO_EMAIL"         => "non pu&ograve; essere un indirizzo email",
    "VAL_SERVER"         => "deve essere un server valido",
    "VAL_LESS"             => "deve essere minore di",
    "VAL_GREAT"         => "deve essere maggiore di",
    "VAL_LESS_EQ"         => "deve essere minore o uguale a",
    "VAL_GREAT_EQ"         => "deve essere maggiore o uguale a",
    "VAL_NOT_EQ"         => "non deve essere uguale a",
    "VAL_EQ"             => "deve essere uguale a",
    "VAL_TZ"             => "deve essere un nome di fuso orario valido",
    "VAL_MUST"             => "deve essere",
    "VAL_MUST_LIST"     => "deve essere uno dei seguenti",
    "VAL_TIME"             => "deve essere un orario valido",
    "VAL_SEL"             => "selezione non valida",
    "VAL_NA_PHONE"         => "deve essere un numero di telefono nordamericano valido"
));

//Time
$lang = array_merge($lang, array(
    "T_YEARS"             => "Anni",
    "T_YEAR"             => "Anno",
    "T_MONTHS"             => "Mesi",
    "T_MONTH"             => "Mese",
    "T_WEEKS"             => "Settimane",
    "T_WEEK"             => "Settimana",
    "T_DAYS"             => "Giorni",
    "T_DAY"             => "Giorno",
    "T_HOURS"             => "Ore",
    "T_HOUR"             => "Ora",
    "T_MINUTES"         => "Minuti",
    "T_MINUTE"             => "Minuto",
    "T_SECONDS"         => "Secondi",
    "T_SECOND"             => "Secondo"
));


//Passwords
$lang = array_merge($lang, array(
    "PW_NEW"             => "Nuova Password",
    "PW_OLD"             => "Password Precedente",
    "PW_CONF"             => "Conferma Password",
    "PW_RESET"             => "Reimposta Password",
    "PW_UPD"             => "Password Aggiornata",
    "PW_SHOULD"         => "La password dovrebbe...",
    "PW_SHOW"             => "Mostra Password",
    "PW_SHOWS"             => "Mostra password"
));


//Join
$lang = array_merge($lang, array(
    "JOIN_SUC"             => "Benvenuto a ",
    "JOIN_THANKS"         => "Grazie per esserti registrato",
    "JOIN_HAVE"         => "Avere almeno ",
    "JOIN_LOWER"    => " lettera minuscola",
    "JOIN_SYMBOL"        => " simbolo",
    "JOIN_CAP"             => " lettera maiuscola",
    "JOIN_TWICE"         => "Essere scritto correttamente due volte",
    "JOIN_CLOSED"         => "In questo momento la registrazione &egrave; disabilitata. Per favore, contattare l'amministratore del sito per qualsiasi informazione.",
    "JOIN_TC"             => "Termini e condizioni per l'utente per la registrazione",
    "JOIN_ACCEPTTC"     => "Accetto i Termini e le condizioni per l'utente",
    "JOIN_CHANGED"         => "I nostri termini sono cambiati",
    "JOIN_ACCEPT"         => "Accetta i Termini e le condizioni per l'utente e continua",
    "JOIN_SCORE" => "Punteggio:",
    "JOIN_INVALID_PW" => "La tua password non è valida",

));

//Sessions
$lang = array_merge($lang, array(
    "SESS_SUC"             => "Terminato correttamente "
));

//Messages
$lang = array_merge($lang, array(
    "MSG_SENT"             => "Il messaggio &egrave; stato inviato!",
    "MSG_MASS"             => "Il messaggio multiplo &egrave; stato inviato!",
    "MSG_NEW"             => "Nuovo messaggio",
    "MSG_NEW_MASS"         => "Nuovo messaggio multiplo",
    "MSG_CONV"             => "Conversazioni",
    "MSG_NO_CONV"         => "Nessuna conversazione",
    "MSG_NO_ARC"         => "Nessuna conversazione",
    "MSG_QUEST"         => "Invia email con notifiche se Attiva?",
    "MSG_ARC"             => "Thread archiviato",
    "MSG_VIEW_ARC"         => "Vedi Thread archiviati",
    "MSG_SETTINGS"         => "Impostazioni dei messaggi",
    "MSG_READ"             => "Leggere",
    "MSG_BODY"             => "Corpo",
    "MSG_SUB"             => "Oggetto",
    "MSG_DEL"             => "Inviato",
    "MSG_REPLY"         => "Rispondere",
    "MSG_QUICK"         => "Risposta Rapida",
    "MSG_SELECT"         => "Selezionare un Utente",
    "MSG_UNKN"             => "Destinatario sconosciuto",
    "MSG_NOTIF"         => "Messaggio di notifica via email",
    "MSG_BLANK"         => "Il messaggio non può essere vuoto",
    "MSG_MODAL"         => "Fare clic qui o premere Alt + R per mettere a fuoco questa casella OPPURE premere Maiusc   R per aprire il riquadro di risposta esteso!",
    "MSG_ARCHIVE_SUCCESSFUL"         => "Sono stati archiviati %m1% thread correttamente",
    "MSG_UNARCHIVE_SUCCESSFUL"         => "Sono stati espansi %m1% thread correttamente",
    "MSG_DELETE_SUCCESSFUL"         => "Sono stati eliminati %m1% thread correttamente",
    "USER_MESSAGE_EXEMPT"             => "L'Utente %m1% non riceve messaggi.",
    "MSG_MK_READ"         => "Leggere",
    "MSG_MK_UNREAD"     => "Non letto",
    "MSG_ARC_THR"         => "Archiviare i Thread Selezionati",
    "MSG_UN_THR"         => "Espandere i Thread Selezionati",
    "MSG_DEL_THR"         => "Eliminare i Thread Selezionati",
    "MSG_SEND"             => "Inviare Messaggio"
));

// Two Factor Authentication Translations
$lang = array_merge($lang, array(
    "2FA"               => "Autenticazione a due fattori",
    "2FA_CONF"          => "Sei sicuro di voler disattivare l'autenticazione a due fattori? Il tuo account non sarà più protetto.",
    "2FA_SCAN"          => "Scansiona questo codice QR con la tua app di autenticazione o inserisci la chiave",
    "2FA_THEN"          => "Quindi inserisci qui una delle tue chiavi usa e getta",
    "2FA_FAIL"          => "Si è verificato un problema nella verifica dell'autenticazione a due fattori. Controlla la connessione internet o contatta il supporto.",
    "2FA_CODE"          => "Codice 2FA",
    "2FA_EXP"           => "1 impronta digitale scaduta",
    "2FA_EXPD"          => "Scaduto",
    "2FA_EXPS"          => "Scade",
    "2FA_ACTIVE"        => "Sessioni attive",
    "2FA_NOT_FN"        => "Nessuna impronta digitale trovata",
    "2FA_FP"            => "Impronte digitali",
    "2FA_NP"            => "Accesso fallito. Il codice di autenticazione a due fattori non era presente. Riprova.",
    "2FA_INV"           => "Accesso fallito. Il codice di autenticazione a due fattori non è valido. Riprova.",
    "2FA_FATAL"         => "Errore fatale. Contatta l'amministratore di sistema. Non possiamo generare un codice di autenticazione a due fattori in questo momento.",
    "2FA_SECTION_TITLE" => "Autenticazione a due fattori (TOTP)",
    "2FA_SK_ALT"       => "Se non puoi scansionare il codice QR, inserisci manualmente questa chiave segreta nella tua app di autenticazione.",
    "2FA_IS_ENABLED"    => "L'autenticazione a due fattori sta proteggendo il tuo account.",
    "2FA_NOT_ENABLED_INFO" => "L'autenticazione a due fattori non è attualmente abilitata.",
    "2FA_NOT_ENABLED_EXPLAIN" => "L'autenticazione a due fattori (TOTP) aggiunge un ulteriore livello di sicurezza al tuo account richiedendo un codice da un'app di autenticazione sul tuo telefono oltre alla password.",
    "2FA_SETUP_TITLE"  => "Configura autenticazione a due fattori",
    "2FA_SECRET_KEY_LABEL" => "Chiave segreta:",
    "2FA_SETUP_VERIFY_CODE_LABEL" => "Inserisci il codice di verifica dall'app",
    "2FA_SUCCESS_ENABLED_TITLE" => "Autenticazione a due fattori abilitata! Salva i tuoi codici di backup",
    "2FA_SUCCESS_ENABLED_INFO" => "Di seguito sono riportati i tuoi codici di backup. Conservali in modo sicuro - ciascuno può essere usato solo una volta.",
    "2FA_BACKUP_CODES_WARNING" => "Tratta questi codici come password. Conservali in modo sicuro.",
    "2FA_SUCCESS_BACKUP_REGENERATED" => "Nuovi codici di backup generati. Conservali in modo sicuro.",
    "2FA_BACKUP_CODE_LABEL" => "Codice di backup",
    "2FA_REGEN_CODES_BTN" => "Rigenera codici di backup",
    "2FA_INVALIDATE_WARNING" => "Questo invaliderà tutti i codici di backup esistenti. Sei sicuro?",
    "2FA_CODE_LABEL"    => "Codice di autenticazione",
    "2FA_VERIFY_BTN"    => "Verifica e accedi",
    "2FA_VERIFY_TITLE"  => "Autenticazione a due fattori richiesta",
    "2FA_VERIFY_INFO"   => "Inserisci il codice a 6 cifre dalla tua app di autenticazione.",
    "2FA_ENABLE_BTN"    => "Abilita autenticazione a due fattori",
    "2FA_DISABLE_BTN"   => "Disabilita autenticazione a due fattori",
    "2FA_VERIFY_ACTIVATE_BTN" => "Verifica e attiva",
    "2FA_CANCEL_SETUP_BTN" => "Annulla configurazione",
    "2FA_DONE_BTN"      => "Fatto",
    "REDIR_2FA_DIS"     => "L'autenticazione a due fattori è stata disabilitata.",
    "2FA_SUCCESS_BACKUP_ACK" => "Codici di backup confermati.",
    "2FA_SUCCESS_SETUP_CANCELLED" => "Configurazione annullata.",
    "2FA_ERR_INVALID_BACKUP" => "Codice di backup non valido. Riprova.",
    "2FA_ERR_DISABLE_FAILED" => "Impossibile disabilitare l'autenticazione a due fattori.",
    "2FA_ERR_NO_SECRET" => "Impossibile recuperare il segreto di autenticazione. Riprova.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL" => "Codice di backup verificato ma impossibile invalidarlo. Contatta il supporto.",
    "2FA_ERR_NO_CODE_PROVIDED" => "Nessun codice di autenticazione fornito.",
    "RATE_LIMIT_LOGIN"   => "Troppi tentativi di accesso falliti. Attendi prima di riprovare.",
    "RATE_LIMIT_TOTP"    => "Troppi codici di autenticazione errati. Attendi prima di riprovare.",
    "RATE_LIMIT_PASSKEY" => "Troppi tentativi di autenticazione con passkey. Attendi prima di riprovare.",
    "RATE_LIMIT_PASSKEY_STORE" => "Troppi tentativi di registrazione passkey. Attendi prima di riprovare.",
    "RATE_LIMIT_PASSWORD_RESET" => "Troppe richieste di reimpostazione password. Attendi prima di richiedere un'altra reimpostazione.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT" => "Troppi tentativi di reimpostazione password. Attendi prima di riprovare.",
    "RATE_LIMIT_REGISTRATION" => "Troppi tentativi di registrazione. Attendi prima di riprovare.",
    "RATE_LIMIT_EMAIL_VERIFICATION" => "Troppe richieste di verifica email. Attendi prima di richiedere un'altra verifica.",
    "RATE_LIMIT_EMAIL_CHANGE" => "Troppe richieste di cambio email. Attendi prima di riprovare.",
    "RATE_LIMIT_PASSWORD_CHANGE" => "Troppi tentativi di cambio password. Attendi prima di riprovare.",
    "RATE_LIMIT_GENERIC" => "Troppi tentativi. Attendi prima di riprovare.",
));


$lang = array_merge($lang, array(
    "REDIR_2FA"             => "Spiacenti.2FA non &egrave; disponibile in questo momento",
    "REDIR_2FA_EN"             => "Autenticazione 2FA Abilitata",
    "REDIR_2FA_DIS"         => "Autenticazione 2FA Disattivata",
    "REDIR_2FA_VER"         => "Autenticazione 2FA Verificata e Abilitata",
    "REDIR_SOMETHING_WRONG"     => "Qualcosa &egrave; andato male. Per favore prova di nuovo.",
    "REDIR_MSG_NOEX"         => "Quel thread non &egrave; tuo o non esiste.",
    "REDIR_UN_ONCE"         => "Il Nome Utente &egrave; gi&agrave; stato modificato una volta.",
    "REDIR_EM_SUCC"         => "Email Aggiornata Correttamente"
));

//Emails
$lang = array_merge($lang, array(
    "EML_SIGN_IN_WITH" => "Accedi con:",
    "EML_FEATURE_DISABLED" => "Questa funzione è disabilitata",
    "EML_PASSWORDLESS_SENT" => "Controlla la tua email per un link per accedere.",
    "EML_PASSWORDLESS_SUBJECT" => "Verifica la tua email per accedere.",
    "EML_PASSWORDLESS_BODY" => "Verifica il tuo indirizzo email cliccando sul link sottostante. Sarai automaticamente loggato.",

    "EML_CONF"         => "Confermare Email",
    "EML_VER"         => "Verifica la tua Email",
    "EML_CHK"         => "Richiesta ricevuta. Si prega di controllare la posta per la verifica. Assicurati di controllare la cartella Spam e Junk, poich&eacute; il link di verifica scade tra ",
    "EML_MAT"         => "La tua email non coincide.",
    "EML_HELLO"     => "Ciao da ",
    "EML_HI"         => "Ciao ",
    "EML_AD_HAS"     => "Un amministratore ha reimpostato la tua password.",
    "EML_AC_HAS"     => "Un amministratore ha creato il tuo account.",
    "EML_REQ"         => "Ti verr&agrave; chiesto di impostare la tua password usando il link sopra.",
    "EML_EXP"         => "Attenzione, i link delle password scadono tra ",
    "EML_VER_EXP"     => "Attenzione, i link di verifica scadono tra ",
    "EML_CLICK"     => "Clicca qui per accedere.",
    "EML_REC"         => "Si consiglia di modificare la password subito dopo l'accesso.",
    "EML_MSG"         => "Hai un nuovo messaggio da",
    "EML_REPLY"     => "Clicca qui per rispondere o vedere il thread",
    "EML_WHY"         => "Hai ricevuto questa email perch&eacute; hai richiesto il ripristino della tua password. Se non sei stato tu, ignora questa email.",
    "EML_HOW"         => "Se sei stato tu, clicca sul link per continuare con il processo di reimpostazione.",
    "EML_EML"         => "Una richiesta di modificare la tua email &egrave; stata fatta dal tuo account utente.",
    "EML_VER_EML"     => "Grazie per esserti registrato. Una volta verificato il tuo indirizzo email, sarai pronto per accedere! Clicca sul seguente link per verificare il tuo indirizzo email."

));

//Verification
$lang = array_merge($lang, array(
    "VER_SUC"         => "La tua email &egrave; stata verificata!",
    "VER_FAIL"         => "Non siamo riusciti a verificare il tuo account. Per favore riprova.",
    "VER_RESEND"     => "Invia di nuovo l'email di verifica.",
    "VER_AGAIN"     => "Inserisci il tuo indirizzo email e riprova",
    "VER_PAGE"         => "<li>Controlla la tua email e clicca sul link che ti è stato inviato</li><li>Fatto</li>",
    "VER_RES_SUC"     => " Il tuo link di verifica &egrave; stato inviato al tuo indirizzo email.  Clicca sul link inviato per completare la verifica. Assicurati di controllare la tua cartella spam se l'e-mail non si trova nella tua casella di posta.  I link di verifica sono validi solo per ",
    "VER_OOPS"         => "Mannaggia... sembra che qualcosa sia andato storto. Forse hai cliccato su un vecchio link di reset. Clicca qui sotto per riprovare",
    "VER_RESET"     => "La tua password &egrave; stata resettata!",
    "VER_INS"         => "<li>Inserisci il tuo indirizzo email e clicca su Ripristina</li> <li>Controlla la tua email e clicca sul link che ti &egrave; stato inviato.</li> <li>Seguire le istruzioni indicate a schermo</li>",
    "VER_SENT"         => " Il link per la reimpostazione della password &egrave; stato inviato alla tua email.   Clicca sul link nell'e-mail per reimpostare la password. Se non vedi l'e-mail, controlla la tua casella di spam.  Link valido solo per ",
    "VER_PLEASE"     => "Reimposta la tua password"
));

//User Settings
$lang = array_merge($lang, array(
    "SET_PIN"             => "Reimposta PIN",
    "SET_WHY"             => "Perch&eacute; non posso modificare questo?",
    "SET_PW_MATCH"         => "Deve corrispondere alla nuova password",
    "SET_PIN_NEXT"         => "&Egrave; possibile impostare un nuovo PIN la prossima volta che viene richiesta la verifica.",
    "SET_UPDATE"         => "Aggiorna la tua configurazione utente",
    "SET_NOCHANGE"         => "L'amministratore ha disattivato la modifica dei nomi utente.",
    "SET_ONECHANGE"     => "L'amministratore ha stabilito che le modifiche al nome utente possono essere apportate una sola volta e l'hai gi&agrave; fatto.",
    "SET_GRAVITAR"         => "Vuoi cambiare la foto del tuo profilo?  <br> Visita <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a>e crea un account con la stessa email che hai usato su questo sito. Sono presenti in milioni di siti. &Egrave; veloce e semplice!",
    "SET_NOTE1"         => " Attenzione prego,  C'&egrave; una richiesta in sospeso per aggiornare la tua email a",
    "SET_NOTE2"         => ".  Si prega di utilizzare l'e-mail di verifica per completare questa richiesta.   Se hai bisogno di una nuova email di verifica, ridigita l'email precedente e invia nuovamente la richiesta. ",
    "SET_PW_REQ"         => "obbligatorio per cambiare password, e-mail o reimpostare il PIN",
    "SET_PW_REQI"         => "Obbligatorio per cambiare password"

));

//Errors
$lang = array_merge($lang, array(
    "ERR_FAIL_ACT"         => "Impossibile eliminare sessioni attive, errore: ",
    "ERR_EMAIL"         => "L'email NON &egrave; stata inviata a causa di un errore. Per favore, contatta l'amministratore del sito.",
    "ERR_EM_DB"         => "Questa email non esiste nel nostro database",
    "ERR_TC"             => "Si prega di leggere e accettare i termini e condizioni d'uso ",
    "ERR_CAP"             => "Non hai superato il test di prova umana, Robot!",
    "ERR_PW_SAME"         => "La tua password precedente non pu&ograve; essere la stessa di quella nuova",
    "ERR_PW_FAIL"         => "Mancata verifica della password corrente. Aggiornamento fallito. Per favore riprova.",
    "ERR_GOOG"             => "ATTENZIONE: </ strong> se hai effettuato l'accesso con il tuo account Google/Facebook dall'inizio, dovrai usare il link di cancellazione del codice d'accesso per cambiare la tua password ... a meno che tu non sia veramente bravo a indovinare.",
    "ERR_EM_VER"         => "La verifica via email non &egrave; abilitata. Per favore, contatta l'amministratore del sito.",
    "ERR_EMAIL_STR"     => "C'&egrave; qualcosa di strano. Per favore ricontrolla la tua email. Ci scusiamo per l'inconveniente"

));

//Maintenance Page
$lang = array_merge($lang, array(
    "MAINT_HEAD"         => "Torneremo presto!",
    "MAINT_MSG"         => "Ci scusiamo per l'inconveniente, ma al momento stiamo effettuando degli interventi di manutenzione. <br> Torneremo presto online!",
    "MAINT_BAN"         => "Siamo spiacenti. Sei stato bannato. Se ritieni che si tratti di un errore, contatta l'amministratore.",
    "MAINT_TOK"         => "C'&egrave; stato un errore nel tuo modulo. Per favore torna indietro e riprova. Si prega di notare che l'invio del modulo aggiornando la pagina causer&agrave; un errore. Se ci&ograve; dovesse continuare, contattare l'amministratore.",
    "MAINT_OPEN"         => "Un framework open source in PHP per la gestione degli utenti.",
    "MAINT_PLEASE"         => "Hai installato con successo UserSpice! <br> Per visualizzare la documentazione introduttiva, visita"
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
    "DAT_SEARCH"         => "Ricerca",
    "DAT_FIRST"         => "Primo",
    "DAT_LAST"             => "Ultimo",
    "DAT_NEXT"             => "Seguente",
    "DAT_PREV"             => "Precedente",
    "DAT_NODATA"         => "La tabella non contiene dati",
    "DAT_INFO"             => "Visualizzazione delle voci da _START_ a _END_ di _TOTAL_",
    "DAT_ZERO"             => "Visualizzazione delle voci da 0 a 0 di 0",
    "DAT_FILTERED"         => "(Filtro di un totale di _MAX_ voci)",
    "DAT_MENU_LENG"     => "Mostra le voci _MENU_",
    "DAT_LOADING"         => "Caricamento...",
    "DAT_PROCESS"         => "Elaborazione...",
    "DAT_NO_REC"         => "Non ci sono record che corrispondono",
    "DAT_ASC"             => "Attiva per ordinare la colonna in ordine crescente",
    "DAT_DESC"             => "Attiva per ordinare la colonna in ordine decrescent"
));



//LEAVE THIS LINE AT THE BOTTOM. It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
    include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
