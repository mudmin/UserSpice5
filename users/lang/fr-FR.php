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
%m1% - Dymamic markers which are replaced at run time by the relevant index.
*/

/*
Translated by Telnz, Alexandre FLEURET, moonwatch.fr, pousterlus, and Simple Electronics
*/

$lang = array();
//important strings
//You definitely want to customize these for your language
$lang = array_merge($lang,array(
  "THIS_LANGUAGE"	=>"French",
  "THIS_CODE"			=>"fr-FR",
  "MISSING_TEXT"	=>"Texte manquant",
));

//Database Menus
$lang = array_merge($lang,array(
  "MENU_HOME"			=> "Accueil",
  "MENU_HELP"			=> "Aide",
  "MENU_ACCOUNT"	=> "Compte",
  "MENU_DASH"			=> "Administration",
  "MENU_USER_MGR"	=> "Utilisateurs",
  "MENU_PAGE_MGR"	=> "Pages",
  "MENU_PERM_MGR"	=> "Autorisations",
  "MENU_MSGS_MGR"	=> "Messages",
  "MENU_LOGS_MGR"	=> "Logs",
  "MENU_LOGOUT"		=> "Déconnexion",
));

// Signup
$lang = array_merge($lang,array(
  "SIGNUP_TEXT"					=> "Inscription",
  "SIGNUP_BUTTONTEXT"		=> "S'inscrire",
  "SIGNUP_AUDITTEXT"		=> "Inscrit",
));

// Signin
$lang = array_merge($lang,array(
  "SIGNIN_FAIL"				=> "** ÉCHEC DE LA CONNEXION **",
  "SIGNIN_PLEASE_CHK" => "Accès refusé, vérifiez vos identifiants",
  "SIGNIN_UORE"				=> "Nom d'utilisateur ou email",
  "SIGNIN_PASS"				=> "Mot de passe",
  "SIGNIN_TITLE"			=> "Connectez-vous",
  "SIGNIN_TEXT"				=> "Connexion",
  "SIGNOUT_TEXT"			=> "Déconnexion",
  "SIGNIN_BUTTONTEXT"	=> "S'identifier",
  "SIGNIN_REMEMBER"		=> "Se souvenir de moi",
  "SIGNIN_AUDITTEXT"	=> "Connecté",
  "SIGNIN_FORGOTPASS"	=> "Mot de passe oublié",
  "SIGNOUT_AUDITTEXT"	=> "Déconnecté",
));

// Account Page
$lang = array_merge($lang,array(
  "ACCT_EDIT"					=> "Modifier mes infos",
  "ACCT_2FA"					=> "Authentification à 2 facteurs",
  "ACCT_SESS"					=> "Gérer les sessions",
  "ACCT_HOME"					=> "Mon compte",
  "ACCT_SINCE"				=> "Membre depuis",
  "ACCT_LOGINS"				=> "Nombre de connexions",
  "ACCT_SESSIONS"			=> "Nombre de sessions actives",
  "ACCT_MNG_SES"			=> "Cliquez sur le bouton 'Gérer les sessions' à gauche pour plus d'informations.",
));

//General Terms
$lang = array_merge($lang,array(
  "GEN_ENABLED"			=> "Activé",
  "GEN_DISABLED"		=> "Désactivé",
  "GEN_ENABLE"			=> "Activer",
  "GEN_DISABLE"			=> "Désactiver",
  "GEN_NO"					=> "Non",
  "GEN_YES"					=> "Oui",
  "GEN_MIN"					=> "min",
  "GEN_MAX"					=> "max",
  "GEN_CHAR"				=> "car", //as in characters
  "GEN_SUBMIT"			=> "Envoyer",
  "GEN_MANAGE"			=> "Gérer",
  "GEN_VERIFY"			=> "Vérifier",
  "GEN_SESSION"			=> "session",
  "GEN_SESSIONS"		=> "sessions",
  "GEN_EMAIL"				=> "Email",
  "GEN_FNAME"				=> "Prénom",
  "GEN_LNAME"				=> "Nom",
  "GEN_UNAME"				=> "Nom d'utilisateur",
  "GEN_PASS"				=> "Mot de passe",
  "GEN_MSG"					=> "Message",
  "GEN_TODAY"				=> "Aujourd'hui",
  "GEN_CLOSE"				=> "Fermer",
  "GEN_CANCEL"			=> "Annuler",
  "GEN_CHECK"				=> "[cocher tout / tout décocher]",
  "GEN_WITH"				=> "avec",
  "GEN_UPDATED"			=> "Mis à jour",
  "GEN_UPDATE"			=> "Mettre à jour",
  "GEN_BY"					=> "par",
  "GEN_FUNCTIONS"		=> "fonctions",
  "GEN_NUMBER"			=> "nombre",
  "GEN_NUMBERS"			=> "nombres",
  "GEN_INFO"				=> "Information",
  "GEN_REC"					=> "Enregistré",
  "GEN_DEL"					=> "Effacé",
  "GEN_NOT_AVAIL"		=> "Indisponible",
  "GEN_AVAIL"				=> "Disponible",
  "GEN_BACK"				=> "Retour",
  "GEN_RESET"				=> "Réinitialiser",
  "GEN_REQ"					=> "requis",
  "GEN_AND"					=> "et",
  "GEN_SAME"				=> "doit être identique",
));

//validation class
$lang = array_merge($lang,array(
  "VAL_SAME"				=> "doit être identique",
  "VAL_EXISTS"			=> "existe déjà. Merci d'en choisir un autre",
  "VAL_DB"					=> "Erreur de la base de données",
  "VAL_NUM"					=> "doit être un nombre",
  "VAL_INT"					=> "doit être un nombre entier",
  "VAL_EMAIL"				=> "doit être une adresse email valide",
  "VAL_NO_EMAIL"		=> "ne peut pas être une adresse email",
  "VAL_SERVER"			=> "doit appartenir à un serveur valide",
  "VAL_LESS"				=> "doit être inférieur à",
  "VAL_GREAT"				=> "doit être supérieur à",
  "VAL_LESS_EQ"			=> "doit être inférieur ou égal à",
  "VAL_GREAT_EQ"		=> "doit être supérieur ou égal à",
  "VAL_NOT_EQ"			=> "ne doit pas être égal à",
  "VAL_EQ"					=> "doit être égal à",
  "VAL_TZ"					=> "doit être un fuseau horaire valide",
  "VAL_MUST"				=> "doit être",
  "VAL_MUST_LIST"		=> "doit être l'un des suivants",
  "VAL_TIME"				=> "doit être une heure valide",
  "VAL_SEL"					=> "n'est pas une sélection valide",
  "VAL_NA_PHONE"		=> "doit être un numéro de téléphone Nord-Américain valide",
));

//Time
$lang = array_merge($lang,array(
  "T_YEARS"			=> "Années",
  "T_YEAR"			=> "Année",
  "T_MONTHS"		=> "Mois",
  "T_MONTH"			=> "Mois",
  "T_WEEKS"			=> "Semaines",
  "T_WEEK"			=> "Semaine",
  "T_DAYS"			=> "Jours",
  "T_DAY"				=> "Jour",
  "T_HOURS"			=> "Heures",
  "T_HOUR"			=> "Heure",
  "T_MINUTES"		=> "Minutes",
  "T_MINUTE"		=> "Minute",
  "T_SECONDS"		=> "Secondes",
  "T_SECOND"		=> "Seconde",
));


//Passwords
$lang = array_merge($lang,array(
  "PW_NEW"		=> "Nouveau mot de passe",
  "PW_OLD"		=> "Ancien mot de passe",
  "PW_CONF"		=> "Confirmer le mot de passe",
  "PW_RESET"	=> "Réinitialiser mot de passe",
  "PW_UPD"		=> "Le mot de passe a été mis à jour",
  "PW_SHOULD"	=> "Le mot de passe devrait...",
  "PW_SHOW"		=> "Révéler le mot de passe",
  "PW_SHOWS"	=> "Révéler les mots de passe",
));


//Join
$lang = array_merge($lang,array(
  "JOIN_SUC"			=> "Bienvenue chez ",
  "JOIN_THANKS"		=> "Merci pour votre inscription !",
  "JOIN_HAVE"			=> "Avoir au moins ",
  "JOIN_CAP"			=> " lettre majuscule",
  "JOIN_TWICE"		=> "Doit être saisi correctement deux fois",
  "JOIN_CLOSED"		=> "Les inscriptions sont actuellement désactivées. Contactez l'administrateur du site pour toute question ou problème.",
  "JOIN_TC"				=> "Conditions d'utilisation",
  "JOIN_ACCEPTTC" => "J'accepte les conditions d'utilisation",
  "JOIN_CHANGED"	=> "Nos conditions d'utilisation ont évolué",
  "JOIN_ACCEPT" 	=> "Accepter les conditions d'utilisation et continuer",
));

//Sessions
$lang = array_merge($lang,array(
  "SESS_SUC"	=> "Expiration de ",
));

//Messages
$lang = array_merge($lang,array(
  "MSG_SENT"			=> "Votre message a été envoyé !",
  "MSG_MASS"			=> "Votre campagne a été envoyée !",
  "MSG_NEW"				=> "Nouveau message",
  "MSG_NEW_MASS"	=> "Nouvelle campagne",
  "MSG_CONV"			=> "Conversations",
  "MSG_NO_CONV"		=> "Aucune discussion",
  "MSG_NO_ARC"		=> "Aucune discussion",
  "MSG_QUEST"			=> "Notifier les emails si activé ?",
  "MSG_ARC"				=> "Discussions archivées",
  "MSG_VIEW_ARC"	=> "Voir les discussions archivées",
  "MSG_SETTINGS"  => "Paramètres des messages",
  "MSG_READ"			=> "Ouvrir",
  "MSG_BODY"			=> "Contenu",
  "MSG_SUB"				=> "Sujet",
  "MSG_DEL"				=> "Délivré",
  "MSG_REPLY"			=> "Répondre",
  "MSG_QUICK"			=> "Répondre vite",
  "MSG_SELECT"		=> "Sélectionner un destinataire",
  "MSG_UNKN"			=> "Destinataire inconnu",
  "MSG_NOTIF"			=> "Notifications des emails",
  "MSG_BLANK"			=> "Le message ne peut pas être vide",
  "MSG_MODAL"			=> "Cliquez ici ou appuyez sur Alt+R pour vous concentrer ici OU appuyez sur Maj+R pour agrandir le volet de réponse !",
  "MSG_ARCHIVE_SUCCESSFUL"        => "Vous avez correctement archivé %m1% discussions",
  "MSG_UNARCHIVE_SUCCESSFUL"      => "Vous avez correctement désarchivé %m1% discussions",
  "MSG_DELETE_SUCCESSFUL"         => "Vous avez correctement supprimé %m1% discussions",
  "USER_MESSAGE_EXEMPT"         	=> "L'utilisateur est %m1% exempté de messages.",
  "MSG_MK_READ"		=> "Lu",
  "MSG_MK_UNREAD"	=> "Non lu",
  "MSG_ARC_THR"		=> "Archiver les discussions sélectionnées",
  "MSG_UN_THR"		=> "Désarchiver les discussions sélectionnées",
  "MSG_DEL_THR"		=> "Supprimer les discussions sélectionnées",
  "MSG_SEND"			=> "Envoyer le message",
));

//2 Factor Authentication
$lang = array_merge($lang,array(
  "2FA"				=> "Authentification à 2 facteurs",
  "2FA_CONF"	=> "Êtes-vous certain de vouloir désactiver 2FA ? Votre compte ne sera plus protégé.",
  "2FA_SCAN"	=> "Scannez ce code QR avec votre application d'authentification ou saisissez manuellement la clé",
  "2FA_THEN"	=> "Entrez ensuite l'une de vos clés d'accès à usage unique ici",
  "2FA_FAIL"	=> "Impossible de vérifier 2FA. Vérifier votre connexion Internet ou contactez l'assistance.",
  "2FA_CODE"	=> "Code 2FA",
  "2FA_EXP"		=> "Empreinte expirée",
  "2FA_EXPD"	=> "Expirée",
  "2FA_EXPS"	=> "En cours d'expiration",
  "2FA_ACTIVE"=> "Sessions actives",
  "2FA_NOT_FN"=> "Aucune empreinte trouvée",
  "2FA_FP"		=> "Empreintes",
  "2FA_NP"		=> "<strong>Échec de connexion</strong> Pas d'authentification à 2 facteurs. Réessayez.",
  "2FA_INV"		=> "<strong>Échec de connexion</strong> Authentification à 2 facteurs invalide. Réessayez.",
  "2FA_FATAL"	=> "<strong>Erreur</strong> Contactez l'administrateur du système.",
));

//Redirect Messages - These get a plus between each word
$lang = array_merge($lang,array(
  "REDIR_2FA"						=> "Désolé,+l'authentification+à+2+facteurs+est+désactivée",
  "REDIR_2FA_EN"				=> "L'authentification+à+2+facteurs+est+activée",
  "REDIR_2FA_DIS"				=> "L'authentification+à+2+facteurs+est+desactivée",
  "REDIR_2FA_VER"				=> "L'authentification+à+2+facteurs+est+vérifiée+et+activée",
  "REDIR_SOM_TING_WONG" => "Erreur.+Réessayez.",
  "REDIR_MSG_NOEX"			=> "Cette+discussion+ne+vous+appartient+pas+ou+n'existe+pas.",
  "REDIR_UN_ONCE"				=> "Le+nom+d'utilisateur+a+déjà+été+changé.",
  "REDIR_EM_SUCC"				=> "Mise+à+jour+de+l'adresse+email+réussie",
));

//Emails
$lang = array_merge($lang,array(
  "EML_CONF"			=> "Confirmez votre adresse email",
  "EML_VER"				=> "Vérifiez votre adresse email",
  "EML_CHK"				=> "Un email vous a été envoyé contenant un lien de vérification. N'oubliez pas de vérifier votre dossier 'Spam', le lien expire dans ",
  "EML_MAT"				=> "Votre adresse email ne correspond pas.",
  "EML_HELLO"			=> "Bonjour depuis ",
  "EML_HI"				=> "Bonjour ",
  "EML_AD_HAS"		=> "Un administrateur a réinitialisé votre mot de passe.",
  "EML_AC_HAS"		=> "Un administrateur a créé votre compte.",
  "EML_REQ"				=> "Vous devrez créer votre mot de passe en cliquant sur le lien ci-dessus.",
  "EML_EXP"				=> "Attention, le lien de création de votre mot de passe expire dans ",
  "EML_VER_EXP"		=> "Attention, le lien de vérification de votre adresse email expire dans ",
  "EML_CLICK"			=> "Cliquez ici pour vous connecter.",
  "EML_REC"				=> "Il est conseillé de changer de mot de passe après votre première connexion.",
  "EML_MSG"				=> "Vous avez un nouveau message de",
  "EML_REPLY"			=> "Cliquez ici pour répondre ou lire la discussion",
  "EML_WHY"				=> "Nous avons bien reçu votre demande de réinitialisation de votre mot de passe. Si vous n'avez pas demandé à réinitialiser votre mot de passe, vous pouvez ignorer ce message.",
  "EML_HOW"				=> "Pour modifier votre mot de passe, veuillez suivre ce lien :",
  "EML_EML"				=> "Une demande de modification de votre email a été faite à partir de votre compte.",
  "EML_VER_EML"		=> "Merci pour votre inscription. Dès que vous aurez vérifié votre adresse email, vous serez prêt à vous connecter ! Cliquez sur le lien ci-dessous pour valider le processus de vérification.",

));

//Verification
$lang = array_merge($lang,array(
  "VER_SUC"			=> "Votre adresse email a été vérifiée !",
  "VER_FAIL"		=> "Nous n'arrivons pas à vérifier votre adresse email. Merci de réessayer.",
  "VER_RESEND"	=> "Envoyer un nouvel email de vérification",
  "VER_AGAIN"		=> "Saisissez votre adresse mail et essayez de nouveau",
  "VER_PAGE"		=> "<li>Relevez votre boite aux lettres électronique et cliquez sur le lien qui vous a été envoyé</li><li>Terminé</li>",
  "VER_RES_SUC" => "<p>Un lien de vérification vous a été envoyé par email.</p><p>Vérifiez votre adresse en cliquant sur le lien présent dans l'email. Pensez à vérifier aussi vos courriers indésirables si l'email n'est pas dans votre boîte de réception.</p><p>Le lien de vérification est valable ",
  "VER_OOPS"		=> "Quelque chose n'a pas fonctionné : peut-être avez-vous cliqué sur un lien expiré ou déjà utilisé. Cliquez ci-dessous pour réessayer",
  "VER_RESET"		=> "Votre mot de passe a été réinitialisé !",
  "VER_INS"			=> "<li>Entrez votre adresse email et cliquez sur 'Réinitialiser'</li> <li>Relevez votre boite aux lettres électronique et cliquez sur le lien qui vous a été envoyé.</li><li>Suivez ensuite les instructions à l'écran</li>",
  "VER_SENT"		=> "<p>Le lien de réinitialisation de votre mot de passe a été envoyé à votre adresse email.</p>
  <p>Cliquez sur le lien dans l'email pour réinitialiser votre mot de passe. Pensez à vérifier aussi vos courriers indésirables si l'email n'est pas dans votre boîte de réception.</p><p>Le lien de réinitialisation est valable ",
  "VER_PLEASE"	=> "Veuillez modifier votre mot de passe",
));

//User Settings
$lang = array_merge($lang,array(
  "SET_PIN"				=> "Réinitialiser le PIN",
  "SET_WHY"				=> "Pourquoi je ne peux pas changer ça ?",
  "SET_PW_MATCH"	=> "Doit être identique à celui précédemment saisi",

  "SET_PIN_NEXT"	=> "Vous pourrez changer le PIN la prochaine fois que vous effectuerez une vérification",
  "SET_UPDATE"		=> "Modifier vos informations personnelles",
  "SET_NOCHANGE"	=> "L'administrateur a interdit le changement de nom d'utilisateur.",
  "SET_ONECHANGE"	=> "L'administrateur n'a autorisé qu'un seul changement de nom d'utilisateur et vous l'avez déjà effectué.",

  "SET_GRAVITAR"	=> "<strong>Vous voulez changer votre avatar ? </strong><br> Visitez <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> et créez votre compte avec la même adresse email que celle utilisée sur ce site. Cela fonctionne sur des millions de sites. C'est rapide et facile !",

  "SET_NOTE1"			=> "<p><strong>Attention</strong> une demande de modification de votre adresse email est en cours vers ",

  "SET_NOTE2"			=> ".</p><p>Veuillez cliquer sur le lien présent dans l'email de vérification que nous vous avons envoyé.</p>
  <p>Si vous avez besoin d'un nouvel email de vérification, veuillez saisir une nouvelle fois ci-dessous votre adresse email et validez la demande à nouveau.</p>",

  "SET_PW_REQ" 		=> "nécessaire pour modifier le mot de passe, l'adresse email, ou réinitialiser le PIN",
  "SET_PW_REQI" 	=> "Nécessaire pour modifier le mot de passe",

));

//Errors
$lang = array_merge($lang,array(
  "ERR_FAIL_ACT"		=> "Impossible de terminer la session en cours. Erreur : ",
  "ERR_EMAIL"				=> "Une erreur a empêché l'envoi de l'email. Veuillez contacter l'administrateur du site.",
  "ERR_EM_DB"				=> "Cette adresse email n'existe pas dans notre base de données",
  "ERR_TC"					=> "Merci de lire et d'accepter les conditions d'utilisation",
  "ERR_CAP"					=> "Échec du test captcha, espèce de robot !",
  "ERR_PW_SAME"			=> "Votre nouveau mot de passe doit être différent de l'ancien",
  "ERR_PW_FAIL"			=> "Échec de la vérification du mot de passe actuel. Échec de la mise à jour. Veuillez réessayer.",
  "ERR_GOOG"				=> "<strong>ATTENTION :</strong> Si à l'origine vous vous êtes inscrits via votre compte Google / Facebook, utilisez la fonctionnalité 'Mot de passe oublié' avant de chercher à modifier de mot de passe... sauf si vous voulez vraiment essayer de deviner.",
  "ERR_EM_VER"			=> "La vérification d'email n'est pas activée. Veuillez contacter l'administrateur du site.",
  "ERR_EMAIL_STR"		=> "Quelque chose s'est mal passé. Merci de revérifier votre adresse email. Nous sommes désolés pour la gêne occasionnée.",

));

//Maintenance Page
$lang = array_merge($lang,array(
  "MAINT_HEAD"		=> "Nous serons bientôt de retour !",
  "MAINT_MSG"			=> "Nous effectuons actuellement des opérations de maintenance, nous sommes désolés pour la gêne occasionnée.<br> Le site sera opérationnel très rapidement.",
  "MAINT_BAN"			=> "Mince. Vous avez été exclu. Si vous pensez que c'est une erreur, veuillez contacter l'administrateur.",
  "MAINT_TOK"			=> "Il y avait une erreur dans votre formulaire. Veuillez retourner en arrière et réessayer. Attention : rafraîchir la page peut causer une erreur. Si cela continue de se produire, veuillez contacter l'administrateur.",
  "MAINT_OPEN"		=> "Un framework open-source de gestion d'utilisateurs en PHP",
  "MAINT_PLEASE"	=> "Vous avez correctement installé UserSpice !<br>Pour savoir comment bien démarrer, veuillez consulter notre documentation sur"
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang,array(
  "DAT_SEARCH"    => "Chercher",
  "DAT_FIRST"     => "Premier",
  "DAT_LAST"      => "Dernier",
  "DAT_NEXT"      => "Suivant",
  "DAT_PREV"      => "Précédent",
  "DAT_NODATA"        => "Pas de données disponibles dans la table",
  "DAT_INFO"          => "Affichage de _START_ à _END_ des _TOTAL_ entrées",
  "DAT_ZERO"          => "Affichage de 0 à 0 des 0 entrées",
  "DAT_FILTERED"      => "(filtré de _MAX_ entrées au total)",
  "DAT_MENU_LENG"     => "Affichage de _MENU_ entrées",
  "DAT_LOADING"       => "Chargement...",
  "DAT_PROCESS"       => "Traitement...",
  "DAT_NO_REC"        => "Pas d'enregistrements correspondant trouvés",
  "DAT_ASC"           => "Activer pour trier par ordre croissant",
  "DAT_DESC"          => "Activer pour trier par ordre décroissant",
));


///////////////////////////////////////////////////////////////

//Backend Translations for UserSpice
$lang = array_merge($lang,array(
  "BE_DASH"    			=> "Tableau de bord",
  "BE_SETTINGS"     => "Paramètres",
  "BE_GEN"					=> "Général",
  "BE_REG"					=> "Inscription",
  "BE_CUS"					=> "Paramètres personnalisés",
  "BE_DASH_ACC"			=> "Accès au tableau de bord",
  "BE_TOOLS"				=> "Outils",
  "BE_BACKUP"				=> "Sauvegarde",
  "BE_UPDATE"				=> "Mises à jour",
  "BE_CRON"				  => "Planifications",
  "BE_IP"				  	=> "Gestionnaire IP",
));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
  include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
?>
