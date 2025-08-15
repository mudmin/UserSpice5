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
//You definitely want to customize these for your language
$lang = array_merge($lang, array(
	"THIS_LANGUAGE"	=> "French",
	"THIS_CODE" => "fr-FR",
	"MISSING_TEXT"	=> "Texte manquant",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "Saisissez le code envoyé à votre e-mail",
    "PASS_EMAIL_ONLY"     => "Veuillez vérifier votre e-mail pour le lien de connexion",
    "PASS_CODE_ONLY"      => "Veuillez saisir le code envoyé à votre e-mail",
    "PASS_BOTH"           => "Veuillez vérifier votre e-mail pour le lien de connexion ou saisir le code envoyé",
    "PASS_VER_BUTTON"     => "Vérifier le code",
    "PASS_EMAIL_ONLY_MSG" => "Veuillez vérifier votre adresse e-mail en cliquant sur le lien ci-dessous",
    "PASS_CODE_ONLY_MSG"  => "Veuillez saisir le code ci-dessous pour vous connecter",
    "PASS_BOTH_MSG"       => "Veuillez vérifier votre adresse e-mail en cliquant sur le lien ci-dessous ou saisir le code pour vous connecter",
    "PASS_YOUR_CODE"      => "Votre code de vérification est : ",
    "PASS_CONFIRM_LOGIN"  => "Confirmer la connexion",
    "PASS_CONFIRM_CLICK"  => "Cliquez pour terminer la connexion",
    "PASS_GENERIC_ERROR"  => "Une erreur s'est produite",
));

//Database Menus
$lang = array_merge($lang, array(
	"MENU_HOME"			=> "Accueil",
	"MENU_HELP"			=> "Aide",
	"MENU_ACCOUNT"	=> "Compte",
	"MENU_DASH"			=> "Tableau de bord administrateur",
	"MENU_USER_MGR"	=> "Gestion des utilisateurs",
	"MENU_PAGE_MGR"	=> "Gestion de page",
	"MENU_PERM_MGR"	=> "Gestion des autorisations",
	"MENU_MSGS_MGR"	=> "Gestionnaire de messages",
	"MENU_LOGS_MGR"	=> "Journaux système",
	"MENU_LOGOUT"		=> "Se déconnecter",
));

// Signup
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"					=> "S'inscrire",
	"SIGNUP_BUTTONTEXT"		=> "S'inscrire",
	"SIGNUP_AUDITTEXT"		=> "Inscrit",
));

// Signin
$lang = array_merge($lang, array(
	"SIGNIN_FAIL"				=> "** ÉCHEC DE LA CONNEXION **",
	"SIGNIN_PLEASE_CHK" => "Veuillez vérifier vos identifiants et mots de passe puis ré-essayer",
	"SIGNIN_UORE"				=> "Nom d'utilisateur ou courriel",
	"SIGNIN_PASS"				=> "Mot de passe",
	"SIGNIN_TITLE"			=> "Veuillez vous connecter",
	"SIGNIN_TEXT"				=> "S'identifier",
	"SIGNOUT_TEXT"			=> "se déconnecter",
	"SIGNIN_BUTTONTEXT"	=> "S'identifier",
	"SIGNIN_REMEMBER"		=> "Se souvenir de moi",
	"SIGNIN_AUDITTEXT"	=> "Connecté",
	"SIGNIN_FORGOTPASS"	=> "Mot de passe oublié",
	"SIGNOUT_AUDITTEXT"	=> "Déconnecté",
));

// Account Page
$lang = array_merge($lang, array(
	"ACCT_EDIT"					=> "Editer les infos du compte",
	"ACCT_2FA"					=> "Gérer l'authentification à 2 facteurs",
	"ACCT_SESS"					=> "Gérer les sessions",
	"ACCT_HOME"					=> "Accueil du compte",
	"ACCT_SINCE"				=> "Membre depuis",
	"ACCT_LOGINS"				=> "Nombre de connexions",
	"ACCT_SESSIONS"			=> "Nombre de sessions actives",
	"ACCT_MNG_SES"			=> "Cliquez sur le bouton Gérer les sessions dans la barre latérale gauche pour plus d'informations.",
));

//General Terms
$lang = array_merge($lang, array(
	"GEN_ENABLED"			=> "Activé",
	"GEN_DISABLED"		=> "Désactivé",
	"GEN_ENABLE"			=> "Activer",
	"GEN_DISABLE"			=> "Désactiver",
	"GEN_NO"					=> "Non",
	"GEN_YES"					=> "Oui",
	"GEN_MIN"					=> "min",
	"GEN_MAX"					=> "max",
	"GEN_CHAR"				=> "caractères", //as in characters
	"GEN_SUBMIT"			=> "Soumettre",
	"GEN_MANAGE"			=> "Gérer",
	"GEN_VERIFY"			=> "Vérifier",
	"GEN_SESSION"			=> "Session",
	"GEN_SESSIONS"		=> "Sessions",
	"GEN_Courriel"				=> "Courriel", // probablement courriel en France
	"GEN_FNAME"				=> "Prénom",
	"GEN_LNAME"				=> "Nom de famille",
	"GEN_UNAME"				=> "Nom d'utilisateur",
	"GEN_PASS"				=> "Mot de passe",
	"GEN_MSG"					=> "Message",
	"GEN_TODAY"				=> "aujourd'hui",
	"GEN_CLOSE"				=> "Fermer",
	"GEN_CANCEL"			=> "Annuler",
	"GEN_CHECK"				=> "[ Tout sélectionner/Désélectionner ]",
	"GEN_WITH"				=> "Avec",
	"GEN_UPDATED"			=> "Mis à jour",
	"GEN_UPDATE"			=> "Mettre à jour",
	"GEN_BY"					=> "Par",
	"GEN_FUNCTIONS"		=> "Fonctions",
	"GEN_NUMBER"			=> "Nombre",
	"GEN_NUMBERS"			=> "Nombres",
	"GEN_INFO"				=> "Information",
	"GEN_REC"					=> "Enregistré",
	"GEN_DEL"					=> "Effacé",
	"GEN_NOT_AVAIL"		=> "Non disponible",
	"GEN_AVAIL"				=> "Disponible",
	"GEN_BACK"				=> "Retour",
	"GEN_RESET"				=> "Reinitialiser",
	"GEN_REQ"					=> "Requis",
	"GEN_AND"					=> "et",
	"GEN_SAME"				=> "doit être le même",
));

// Passkey Translations
$lang = array_merge($lang, array(
    "GEN_PASSKEY"           => "Clé d'accès",
    "GEN_ACTIONS"           => "Actions",
    "GEN_BACK_TO_ACCT"      => "Retour au compte",
    "GEN_DB_ERROR"          => "Une erreur de base de données s'est produite. Veuillez réessayer.",
    "GEN_IMPORTANT"         => "Important",
    "GEN_NO_PERMISSIONS"    => "Vous n'avez pas la permission d'accéder à cette page.",
    "GEN_NO_PERMISSIONS_MSG" => "Vous n'avez pas la permission d'accéder à cette page. Si vous pensez qu'il s'agit d'une erreur, veuillez contacter l'administrateur du site.",
    "PASSKEYS_MANAGE_TITLE" => "Gérer les clés d'accès",
    "PASSKEYS_LOGIN_TITLE"  => "Connexion avec clé d'accès",
    "PASSKEY_DELETE_SUCCESS" => "Clé d'accès supprimée avec succès.",
    "PASSKEY_DELETE_FAIL_DB" => "Échec de la suppression de la clé d'accès de la base de données.",
    "PASSKEY_DELETE_NOT_FOUND" => "Clé d'accès non trouvée ou vous n'avez pas la permission de la supprimer.",
    "PASSKEY_NOTE_UPDATE_SUCCESS" => "Note de la clé d'accès mise à jour avec succès.",
    "PASSKEY_NOTE_UPDATE_FAIL" => "Échec de la mise à jour de la note de la clé d'accès.",
    "PASSKEY_REGISTER_NEW"  => "Enregistrer une nouvelle clé d'accès",
    "PASSKEY_ERR_LIMIT_REACHED" => "Vous avez atteint la limite maximale de 10 clés d'accès.",
    "PASSKEY_NOTE_TH"       => "Note de la clé d'accès",
    "PASSKEY_TIMES_USED_TH" => "Nombre d'utilisations",
    "PASSKEY_LAST_USED_TH"  => "Dernière utilisation",
    "PASSKEY_LAST_IP_TH"    => "Dernière IP",
    "PASSKEY_EDIT_NOTE_BTN" => "Modifier la note",
    "PASSKEY_CONFIRM_DELETE_JS" => "Êtes-vous sûr de vouloir supprimer cette clé d'accès ?",
    "PASSKEY_EDIT_MODAL_TITLE" => "Modifier la note de la clé d'accès",
    "PASSKEY_EDIT_MODAL_LABEL" => "Note de la clé d'accès",
    "PASSKEY_SAVE_CHANGES_BTN" => "Enregistrer les modifications",
    "PASSKEY_NONE_REGISTERED" => "Vous n'avez encore aucune clé d'accès enregistrée.",
    "PASSKEY_MUST_REGISTER_FIRST" => "Vous devez d'abord enregistrer une clé d'accès depuis un compte authentifié avant d'utiliser cette fonctionnalité.",
    "PASSKEY_STORING"       => "Enregistrement de la clé d'accès...",
    "PASSKEY_STORED_SUCCESS" => "Clé d'accès enregistrée avec succès !",
    "PASSKEY_INVALID_ACTION" => "Action invalide : ",
    "PASSKEY_NO_ACTION_SPECIFIED" => "Aucune action spécifiée",
    "PASSKEY_ERR_NETWORK_SUGGESTION" => "Problème de réseau détecté. Essayez un autre réseau ou actualisez la page.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "Authentification multi-appareils détectée. Assurez-vous que les deux appareils ont accès à Internet.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "Essayez d'ouvrir cette page directement sur votre téléphone.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED" => "Impossible de générer des diagnostics : ",
    "PASSKEY_MISSING_CREDENTIAL_DATA" => "Données d'identifiants requises manquantes pour l'enregistrement.",
    "PASSKEY_MISSING_AUTH_DATA" => "Données d'authentification requises manquantes.",
    "PASSKEY_LOG_NO_MESSAGE" => "Aucun message",
    "PASSKEY_USER_NOT_FOUND" => "Utilisateur non trouvé après la validation de la clé d'accès.",
    "PASSKEY_FATAL_ERROR"    => "Erreur fatale : ",
    "PASSKEY_LOGIN_SUCCESS"  => "Connexion réussie.",
    "PASSKEY_CROSS_DEVICE_PREP" => "Préparation de l'enregistrement multi-appareils. Vous devrez peut-être utiliser votre téléphone ou tablette.",
    "PASSKEY_DEVICE_REGISTRATION" => "Utilisation de l'enregistrement de la clé d'accès sur l'appareil...",
    "PASSKEY_STARTING_REGISTRATION" => "Démarrage de l'enregistrement de la clé d'accès...",
    "PASSKEY_REQUEST_OPTIONS" => "Demande des options d'enregistrement au serveur...",
    "PASSKEY_FOLLOW_PROMPTS" => "Suivez les instructions pour créer votre clé d'accès. Vous devrez peut-être utiliser un autre appareil.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE" => "Suivez les instructions pour créer votre clé d'accès...",
    "PASSKEY_CREATION_FAILED" => "Échec de la création de la clé d'accès - aucune identifiant retourné.",
    "PASSKEY_STORING_SERVER" => "Enregistrement de votre clé d'accès...",
    "PASSKEY_CREATED_SUCCESS" => "Clé d'accès créée avec succès !",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP" => "Préparation de l'authentification multi-appareils. Assurez-vous que votre téléphone et votre ordinateur ont accès à Internet.",
    "PASSKEY_DEVICE_AUTH"    => "Utilisation de l'authentification de la clé d'accès sur l'appareil...",
    "PASSKEY_STARTING_AUTH"  => "Démarrage de l'authentification de la clé d'accès...",
    "PASSKEY_QR_CODE_INSTRUCTION" => "Scannez le code QR avec votre téléphone lorsqu'il apparaît. Assurez-vous que les deux appareils ont accès à Internet.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION" => "Choisissez « Utiliser un téléphone ou une tablette » lorsque cela vous est demandé, puis scannez le code QR.",
    "PASSKEY_AUTHENTICATING" => "Authentification avec votre clé d'accès...",
    "PASSKEY_SUCCESS_REDIRECTING" => "Authentification réussie ! Redirection...",
    "PASSKEY_TIMEOUT_CROSS_DEVICE" => "L'enregistrement a expiré. Pour multi-appareils : 1) Réessayez, 2) Assurez-vous que les appareils ont accès à Internet, 3) Envisagez d'enregistrer directement sur votre téléphone.",
    "PASSKEY_TIMEOUT_SIMPLE" => "L'enregistrement a expiré. Veuillez réessayer.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE" => "L'authentification multi-appareils a expiré. Dépannage : 1) Les deux appareils doivent avoir accès à Internet, 2) Essayez de scanner le code QR plus rapidement, 3) Envisagez d'utiliser le même appareil, 4) Certains réseaux bloquent l'authentification multi-appareils.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE" => "L'authentification a expiré. Veuillez réessayer.",
    "PASSKEY_NO_CREDENTIAL"  => "Aucune identifiant reçue. Nouvelle tentative...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL" => "Échec de l'authentification - aucune identifiant retournée.",
    "PASSKEY_ATTEMPT_RETRY"  => "échec. Nouvelle tentative... (%d tentatives restantes)",
    "PASSKEY_CROSS_DEVICE_FAILED" => "Échec de l'enregistrement multi-appareils. Essayez : 1) Assurez-vous que les deux appareils ont accès à Internet, 2) Envisagez d'enregistrer directement sur votre téléphone, 3) Certains réseaux d'entreprise bloquent cette fonctionnalité.",
    "PASSKEY_REGISTRATION_CANCELLED" => "L'enregistrement a été annulé ou l'appareil ne prend pas en charge les clés d'accès.",
    "PASSKEY_NOT_SUPPORTED"  => "Les clés d'accès ne sont pas prises en charge sur cette combinaison appareil/navigateur.",
    "PASSKEY_SECURITY_ERROR" => "Erreur de sécurité - cela indique généralement une incompatibilité de domaine/origine.",
    "PASSKEY_ALREADY_EXISTS" => "Une clé d'accès existe déjà pour ce compte sur cet appareil. Essayez d'utiliser un autre appareil ou supprimez d'abord les clés d'accès existantes.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED" => "Échec de l'authentification multi-appareils. Essayez : 1) Assurez-vous que les deux appareils ont un accès Internet stable, 2) Utilisez le même réseau WiFi si possible, 3) Essayez de vous authentifier directement sur votre téléphone, 4) Certains réseaux d'entreprise bloquent cette fonctionnalité.",
    "PASSKEY_AUTH_CANCELLED" => "L'authentification a été annulée ou aucune clé d'accès n'a été sélectionnée.",
    "PASSKEY_NETWORK_ERROR"  => "Erreur de réseau. Pour l'authentification multi-appareils, les deux appareils doivent avoir accès à Internet et pourraient devoir être sur le même réseau.",
    "PASSKEY_CREDENTIAL_NOT_FOUND" => "Échec de l'authentification - identifiant non reconnu.",
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "Conseils pour l'authentification multi-appareils :",
    "PASSKEY_GUIDANCE_INTERNET" => "Assurez-vous que votre ordinateur et votre téléphone ont accès à Internet",
    "PASSKEY_GUIDANCE_WIFI"  => "Être sur le même réseau WiFi peut aider (mais n'est pas toujours nécessaire)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE" => "Lorsque cela vous est demandé, sélectionnez « Utiliser un téléphone ou une tablette »",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY" => "Scannez le code QR rapidement lorsqu'il apparaît",
    "PASSKEY_GUIDANCE_TRY_DIRECT" => "En cas d'échec, essayez de rafraîchir et d'utiliser directement le navigateur de votre téléphone",
    "PASSKEY_SHOW_TROUBLESHOOTING" => "Afficher les conseils de dépannage",
    "PASSKEY_HIDE_TROUBLESHOOTING" => "Masquer les conseils de dépannage",
    "PASSKEY_DIAGNOSTICS_RUNNING" => "Exécution des diagnostics...",
    "PASSKEY_DIAGNOSTICS_COMPLETE" => "Diagnostics terminés. Vérifiez la console pour plus de détails.",
    "PASSKEY_ISSUES_DETECTED" => "Problèmes détectés :",
    "PASSKEY_ENVIRONMENT_SUITABLE" => "L'environnement semble adapté aux clés d'accès.",
    "PASSKEY_DIAGNOSTICS_FAILED" => "Diagnostics échoués :",
    "PASSKEY_ADD_NOTE_NEW"  => "Ajouter une note à votre nouvelle clé d'accès",
    "PASSKEY_BASE64_ERROR"  => "Erreur de décodage Base64 :",
    "PASSKEY_INVALID_JSON"  => "Données JSON invalides reçues :",
    "PASSKEY_LOGIN_REQUIRED" => "Vous devez être connecté pour effectuer cette action.",
    "PASSKEY_ACTION_MISSING" => "Le paramètre 'action' requis est manquant dans la requête.",
    "PASSKEY_STORAGE_FAILED" => "Échec de l'enregistrement de la clé d'accès. L'opération n'a pas abouti.",
    "PASSKEY_LOGIN_FAILED"   => "Échec de la connexion avec la clé d'accès. L'authentification n'a pas pu être vérifiée.",
    "PASSKEY_INVALID_METHOD" => "Méthode de requête invalide :",
    "CSRF_ERROR"            => "Échec de la vérification du jeton CSRF. Veuillez revenir en arrière et essayer de soumettre à nouveau le formulaire.",
    "PASSKEY_NETWORK_PRIVATE" => "Problème potentiel : Il semble que vous soyez sur un réseau privé, ce qui peut parfois interférer avec la communication entre appareils.",
    "PASSKEY_NETWORK_PROXY"  => "Problème potentiel : Un proxy ou VPN a été détecté. Cela peut interférer avec la communication entre appareils.",
    "PASSKEY_NETWORK_MOBILE" => "Note : Il semble que vous soyez sur un réseau mobile. Assurez-vous d'une connexion stable pour les opérations multi-appareils.",
    "PASSKEY_NETWORK_CORPORATE" => "Problème potentiel : Un pare-feu d'entreprise peut être actif, ce qui pourrait affecter l'authentification multi-appareils.",
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "Recommandation : Vous utilisez probablement un ordinateur de bureau. Préparez-vous à utiliser votre téléphone pour scanner un code QR.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "Recommandation : Pour de meilleurs résultats, assurez-vous que votre ordinateur et votre appareil mobile sont sur le même réseau WiFi.",
    "PASSKEY_RECOMMENDATION_QR_QUICK" => "Recommandation : Soyez prêt à scanner le code QR rapidement, car la requête peut expirer.",
    "PASSKEY_RECOMMENDATION_INTERNET" => "Recommandation : Assurez-vous que votre ordinateur et votre appareil mobile ont une connexion Internet stable.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "Recommandation : Pour les WebViews Unity, assurez-vous que la page a suffisamment de temps pour charger et traiter la requête de clé d'accès.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "Recommandation : Les délais d'attente peuvent être plus longs dans Unity. Veuillez être patient.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "Recommandation : Puisque vous êtes sur un appareil mobile, vous devriez pouvoir enregistrer une clé d'accès directement sur cet appareil.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Recommandation : Sur Android, vous pouvez gérer vos clés d'accès dans le Gestionnaire de mots de passe Google.",
    "PASSKEY_VALIDATION_RP_IP" => "Avertissement de configuration : L'ID de la partie de confiance est défini sur une adresse IP.",
    "PASSKEY_VALIDATION_RP_DOMAIN" => "Recommandation : Définissez l'ID de la partie de confiance sur votre nom de domaine (par exemple, votresite.fr) pour une meilleure sécurité et compatibilité.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED" => "Erreur de configuration : HTTPS est requis pour que les clés d'accès fonctionnent sur un serveur en direct. Votre site semble être en HTTP.",
    "PASSKEY_VALIDATION_NETWORK" => "Avertissement réseau",
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "Recommandation : Si vous rencontrez des problèmes, essayez un autre réseau (par exemple, passez du WiFi d'entreprise à un point d'accès mobile).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "Recommandation : Pour les actions multi-appareils, assurez-vous que les deux appareils ont une connexion Internet fiable.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK" => "Recommandation : Si les actions multi-appareils échouent, essayez de visiter cette page directement sur votre appareil mobile pour compléter l'action.",
    "PASSKEY_INFO_TITLE"    => "À propos des clés d'accès",
    "PASSKEY_INFO_DESC"     => "Les clés d'accès sont un moyen sécurisé et sans mot de passe de se connecter en utilisant les fonctionnalités de sécurité intégrées de votre appareil, comme l'empreinte digitale, la reconnaissance faciale ou un code PIN. Elles sont plus sécurisées que les mots de passe, offrent une connexion plus rapide, fonctionnent sur plusieurs appareils lorsqu'elles sont synchronisées avec des gestionnaires de mots de passe et sont résistantes aux attaques de phishing. Les clés d'accès fonctionnent sur les smartphones modernes, les tablettes, les ordinateurs et peuvent être stockées dans des gestionnaires de mots de passe comme 1Password, Bitwarden, iCloud Keychain ou le Gestionnaire de mots de passe Google.",
    "PASSKEY_BACK_TO_LOGIN" => "Retour à la connexion",
));


//validation class
$lang = array_merge($lang, array(
	"VAL_SAME"				=> "doit être le même",
	"VAL_EXISTS"			=> "existe déjà. Merci d'en choisir un autre",
	"VAL_DB"					=> "erreur de la base de données",
	"VAL_NUM"					=> "doit être un nombre",
	"VAL_INT"					=> "doit être un nombre entier",
	"VAL_Courriel"				=> "doit être une adresse courriel valide",
	"VAL_NO_Courriel"		=> "ne peut pas être une adresse courriel",
	"VAL_SERVER"			=> "Doit être un serveur valide",
	"VAL_LESS"				=> "Doit être inférieur à",
	"VAL_GREAT"				=> "Doit être supérieur à",
	"VAL_LESS_EQ"			=> "Doit être inférieur ou égal à",
	"VAL_GREAT_EQ"		=> "Doit être supérieur ou égal à",
	"VAL_NOT_EQ"			=> "Ne doit pas être égal à",
	"VAL_EQ"					=> "Doit être égal à",
	"VAL_TZ"					=> "doit être un nom de fuseau horaire valide",
	"VAL_MUST"				=> "Doit être",
	"VAL_MUST_LIST"		=> "Doit être l'un des suivants",
	"VAL_TIME"				=> "Doit être une heure valide",
	"VAL_SEL"					=> "n'est pas une sélection valide",
	"VAL_NA_PHONE"		=> "doit être un numéro de téléphone nord-américain valide",
));

//Time
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"PW_NEW"		=> "Nouveau mot de passe",
	"PW_OLD"		=> "Ancien mot de passe",
	"PW_CONF"		=> "Confirmer le mot de passe",
	"PW_RESET"	=> "Réinitialiser le mot de passe",
	"PW_UPD"		=> "Mot de passe mis à jour",
	"PW_SHOULD"	=> "Le mot de passe devrait...",
	"PW_SHOW"		=> "Montrer le mot de passe",
	"PW_SHOWS"	=> "Montrer les mots de passe",
));


//Join
$lang = array_merge($lang, array(
	"JOIN_SUC"			=> "Bienvenue ",
	"JOIN_THANKS"		=> "Merci pour votre inscription!",
	"JOIN_HAVE"			=> "avoir au moins ",
	"JOIN_LOWER"	=> " lettre minuscule",
	"JOIN_SYMBOL"		=> " symbole",
	"JOIN_CAP"			=> " lettre majuscule",
	"JOIN_TWICE"		=> "Être tapé deux fois correctement",
	"JOIN_CLOSED"		=> "Inscription malheureusement désactivée en ce moment. S.V.P. contacter l'administrateur du site si vous avez des questions ou des problèmes.",
	"JOIN_TC"				=> "Termes et conditions de l'inscription",
	"JOIN_ACCEPTTC" => "J'accepte les termes et conditions de l'utilisateur",
	"JOIN_CHANGED"	=> "Nos termes ont été modifiés",
	"JOIN_ACCEPT" 	=> "Accepter les termes et conditions pour utilisateur et continuer",
	"JOIN_SCORE" => "Score:",
	"JOIN_INVALID_PW" => "Votre mot de passe est invalide",

));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "Fermé avec succès ",
));

//Messages
$lang = array_merge($lang, array(
	"MSG_SENT"			=> "Message envoyé!",
	"MSG_MASS"			=> "Votre message collectif a été envoyé!",
	"MSG_NEW"				=> "Nouveau message",
	"MSG_NEW_MASS"	=> "Nouveau message collectif",
	"MSG_CONV"			=> "Conversations",
	"MSG_NO_CONV"		=> "Pas de conversations",
	"MSG_NO_ARC"		=> "Pas de conversation",
	"MSG_QUEST"			=> "Envoyer un courriel de confirmation si activé?",
	"MSG_ARC"				=> "conversations archivés",
	"MSG_VIEW_ARC"	=> "Voir les conversations archivés",
	"MSG_SETTINGS"  => "Paramètres de la messagerie",
	"MSG_READ"			=> "Lire",
	"MSG_BODY"			=> "Contenu",
	"MSG_SUB"				=> "Sujet",
	"MSG_DEL"				=> "Remis",
	"MSG_REPLY"			=> "Réponse",
	"MSG_QUICK"			=> "Réponse rapide",
	"MSG_SELECT"		=> "Sélectionner un utilisateur",
	"MSG_UNKN"			=> "Destinataire inconnu",
	"MSG_NOTIF"			=> "Message de notifications de courriels",
	"MSG_BLANK"			=> "Le message doit avoir un contenu",
	"MSG_MODAL"			=> "Cliquez ici ou appuyez sur Alt + R pour atteindre sur cette case OU appuyez sur Maj   R pour ouvrir la boîte de réponse allongée

!",
	"MSG_ARCHIVE_SUCCESSFUL"        => "Vous avez archivé avec succès %m1% discussions",
	"MSG_UNARCHIVE_SUCCESSFUL"      => "Vous avez désarchivé %m1% discussions avec succès",
	"MSG_DELETE_SUCCESSFUL"         => "Vous avez supprimé avec succès %m1% discussions",
	"USER_MESSAGE_EXEMPT"         			=> "L'utilisateur est %m1% exempté de messages.",
	"MSG_MK_READ"		=> "lu",
	"MSG_MK_UNREAD"	=> "Non lu",
	"MSG_ARC_THR"		=> "Archiver les discussions sélectionnées",
	"MSG_UN_THR"		=> "Désarchiver les discussions sélectionnées",
	"MSG_DEL_THR"		=> "Supprimer les discussions sélectionnées",
	"MSG_SEND"			=> "Envoyer le message",
));


// Two Factor Authentication Translations
$lang = array_merge($lang, array(
    "2FA"               => "Authentification à deux facteurs",
    "2FA_CONF"          => "Êtes-vous sûr de vouloir désactiver l'authentification à deux facteurs ? Votre compte ne sera plus protégé.",
    "2FA_SCAN"          => "Scannez ce code QR avec votre application d'authentification ou entrez la clé",
    "2FA_THEN"          => "Ensuite, entrez l'une de vos clés à usage unique ici",
    "2FA_FAIL"          => "Un problème est survenu lors de la vérification de l'authentification à deux facteurs. Vérifiez votre connexion Internet ou contactez le support.",
    "2FA_CODE"          => "Code 2FA",
    "2FA_EXP"           => "1 empreinte digitale expirée",
    "2FA_EXPD"          => "Expiré",
    "2FA_EXPS"          => "Expire",
    "2FA_ACTIVE"        => "Sessions actives",
    "2FA_NOT_FN"        => "Aucune empreinte digitale trouvée",
    "2FA_FP"            => "Empreintes digitales",
    "2FA_NP"            => "Échec de la connexion. Le code d'authentification à deux facteurs n'était pas présent. Veuillez réessayer.",
    "2FA_INV"           => "Échec de la connexion. Le code d'authentification à deux facteurs était invalide. Veuillez réessayer.",
    "2FA_FATAL"         => "Erreur fatale. Veuillez contacter l'administrateur du système. Nous ne pouvons pas générer de code d'authentification à deux facteurs pour le moment.",
    "2FA_SECTION_TITLE" => "Authentification à deux facteurs (TOTP)",
    "2FA_SK_ALT"       => "Si vous ne pouvez pas scanner le code QR, entrez manuellement cette clé secrète dans votre application d'authentification.",
    "2FA_IS_ENABLED"    => "L'authentification à deux facteurs protège votre compte.",
    "2FA_NOT_ENABLED_INFO" => "L'authentification à deux facteurs n'est pas actuellement activée.",
    "2FA_NOT_ENABLED_EXPLAIN" => "L'authentification à deux facteurs (TOTP) ajoute une couche supplémentaire de sécurité à votre compte en exigeant un code provenant d'une application d'authentification sur votre téléphone en plus de votre mot de passe.",
    "2FA_SETUP_TITLE"  => "Configurer l'authentification à deux facteurs",
    "2FA_SECRET_KEY_LABEL" => "Clé secrète :",
    "2FA_SETUP_VERIFY_CODE_LABEL" => "Entrez le code de vérification de l'application",
    "2FA_SUCCESS_ENABLED_TITLE" => "Authentification à deux facteurs activée ! Enregistrez vos codes de secours",
    "2FA_SUCCESS_ENABLED_INFO" => "Ci-dessous se trouvent vos codes de secours. Conservez-les en lieu sûr - chacun ne peut être utilisé qu'une seule fois.",
    "2FA_BACKUP_CODES_WARNING" => "Traitez ces codes comme des mots de passe. Conservez-les en lieu sûr.",
    "2FA_SUCCESS_BACKUP_REGENERATED" => "Nouveaux codes de secours générés. Conservez-les en lieu sûr.",
    "2FA_BACKUP_CODE_LABEL" => "Code de secours",
    "2FA_REGEN_CODES_BTN" => "Régénérer les codes de secours",
    "2FA_INVALIDATE_WARNING" => "Cela invalidera tous les codes de secours existants. Êtes-vous sûr ?",
    "2FA_CODE_LABEL"    => "Code d'authentification",
    "2FA_VERIFY_BTN"    => "Vérifier et se connecter",
    "2FA_VERIFY_TITLE"  => "Authentification à deux facteurs requise",
    "2FA_VERIFY_INFO"   => "Entrez le code à 6 chiffres de votre application d'authentification.",
    "2FA_ENABLE_BTN"    => "Activer l'authentification à deux facteurs",
    "2FA_DISABLE_BTN"   => "Désactiver l'authentification à deux facteurs",
    "2FA_VERIFY_ACTIVATE_BTN" => "Vérifier et activer",
    "2FA_CANCEL_SETUP_BTN" => "Annuler la configuration",
    "2FA_DONE_BTN"      => "Terminé",
    "REDIR_2FA_DIS"     => "L'authentification à deux facteurs a été désactivée.",
    "2FA_SUCCESS_BACKUP_ACK" => "Codes de secours confirmés.",
    "2FA_SUCCESS_SETUP_CANCELLED" => "Configuration annulée.",
    "2FA_ERR_INVALID_BACKUP" => "Code de secours invalide. Veuillez réessayer.",
    "2FA_ERR_DISABLE_FAILED" => "Échec de la désactivation de l'authentification à deux facteurs.",
    "2FA_ERR_NO_SECRET" => "Impossible de récupérer le secret d'authentification. Veuillez réessayer.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL" => "Code de secours vérifié mais échec de l'invalidation. Veuillez contacter le support.",
    "2FA_ERR_NO_CODE_PROVIDED" => "Aucun code d'authentification fourni.",
    "RATE_LIMIT_LOGIN"   => "Trop de tentatives de connexion échouées. Veuillez attendre avant de réessayer.",
    "RATE_LIMIT_TOTP"    => "Trop de codes d'authentification incorrects. Veuillez attendre avant de réessayer.",
    "RATE_LIMIT_PASSKEY" => "Trop de tentatives d'authentification avec clé d'accès. Veuillez attendre avant de réessayer.",
    "RATE_LIMIT_PASSKEY_STORE" => "Trop de tentatives d'enregistrement de clé d'accès. Veuillez attendre avant de réessayer.",
    "RATE_LIMIT_PASSWORD_RESET" => "Trop de demandes de réinitialisation de mot de passe. Veuillez attendre avant de demander une autre réinitialisation.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT" => "Trop de tentatives de réinitialisation de mot de passe. Veuillez attendre avant de réessayer.",
    "RATE_LIMIT_REGISTRATION" => "Trop de tentatives d'enregistrement. Veuillez attendre avant de réessayer.",
    "RATE_LIMIT_EMAIL_VERIFICATION" => "Trop de demandes de vérification d'e-mail. Veuillez attendre avant de demander une autre vérification.",
    "RATE_LIMIT_EMAIL_CHANGE" => "Trop de demandes de changement d'e-mail. Veuillez attendre avant de réessayer.",
    "RATE_LIMIT_PASSWORD_CHANGE" => "Trop de tentatives de changement de mot de passe. Veuillez attendre avant de réessayer.",
    "RATE_LIMIT_GENERIC" => "Trop de tentatives. Veuillez attendre avant de réessayer.",
));

 // needs work in French
$lang = array_merge($lang, array(
	"REDIR_2FA"						=> "Désolé.Deux facteurs n'est pas activé en ce moment",
	"REDIR_2FA_EN"				=> "2 facteur authentification Activée",
	"REDIR_2FA_DIS"				=> "2 facteur authentification Desactivée",
	"REDIR_2FA_VER"				=> "2 facteur authentification vérifiée et activée",
	"REDIR_SOMETHING_WRONG" => "erreur S.V.P. essayer de nouveau.",
	"REDIR_MSG_NOEX"			=> "Ce thread ne vous appartient pas ou n'existe pas.",
	"REDIR_UN_ONCE"				=> "Le nom d'utilisateur a déjà été changé.",
	"REDIR_EM_SUCC"				=> "Courriel Mise à jour réussie",
));

//Courriels
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "Se connecter avec:",
	"EML_FEATURE_DISABLED" => "Cette fonctionnalité est désactivée",
	"EML_PASSWORDLESS_SENT" => "Veuillez vérifier votre e-mail pour un lien de connexion.",
	"EML_PASSWORDLESS_SUBJECT" => "Veuillez vérifier votre e-mail pour vous connecter.",
	"EML_PASSWORDLESS_BODY" => "Veuillez vérifier votre adresse e-mail en cliquant sur le lien ci-dessous. Vous serez automatiquement connecté.",

	"EML_CONF"			=> "Confirmer courriel",
	"EML_VER"				=> "Vérifiez votre courriel",
	"EML_CHK"				=> "Demande d'Courriel reçue. S.V.P. voir vos courriels pour vérification. Pensez à consulter vos dossiers Spam et Junk lorsque le lien de vérification expire ",
	"EML_MAT"				=> "Votre courriel n'était pas le même.",
	"EML_HELLO"			=> "Bonjour de ",
	"EML_HI"				=> "Bonjour ",
	"EML_AD_HAS"		=> "Un administrateur a changé votre mot de passe.",
	"EML_AC_HAS"		=> "Un administrateur a créé votre compte.",
	"EML_REQ"				=> "Vous devrez établir votre mot de passe en utilisant le lien ci dessus.",
	"EML_EXP"				=> "S.V.P. , notez , le lien mot de passe expirera dans ",
	"EML_VER_EXP"		=> "S.V.P. , notez, le lien de vérification expirera dans ",
	"EML_CLICK"			=> "Cliquer ici pour connection.",
	"EML_REC"				=> "Il est recommandé de changer de mot de passe après connection.",
	"EML_MSG"				=> "Vous avez un nouveau message de",
	"EML_REPLY"			=> "Cliquez ici pour répondre ou voir la discussion",
	"EML_WHY"				=> "Vous recevez ce courriel parce qu'une demande de renouvellement de mot de passe a été faite. Si ce n'était pas vous , vous pouvez ignorer ce courriel.",
	"EML_HOW"				=> "Si c'était vous , cliquez sur le lien ci dessous pour poursuivre le processus de changement de mot de passe.",
	"EML_EML"				=> "Une demande de modification de votre courriel a été faite à partir de votre compte d'utilisateur.",
	"EML_VER_EML"		=> "Merci pour votre inscription. une fois que vous aurez vérifié votre adresse courriel vous serez prêt à vous connecter ! S.V.P. cliquez sur le lien ci dessous pour vérifier votre adresse courriel.",

));

//Verification
$lang = array_merge($lang, array(
	"VER_SUC"			=> "Votre courriel a été vérifié!",
	"VER_FAIL"		=> "Il nous est impossible de vérifier votre compte . S.V.P. essayez de nouveau.",
	"VER_RESEND"	=> "Renvoyer un courriel de vérification",
	"VER_AGAIN"		=> "Saisir votre adresse courriel et essayez de nouveau",
	"VER_PAGE"		=> "<li>Vérifiez votre courriel et cliquez sur le lien qui vous est envoyé</li><li>Terminé</li>",
	"VER_RES_SUC" => " Votre lien de vérification a été envoyé à votre adresse e-mail.  Cliquez sur le lien dans l'e-mail pour terminer la vérification. Assurez-vous de vérifier votre dossier de courrier indésirable si le courriel n'est pas dans votre boîte de réception.  Les liens de vérification ne sont valables que pour ",
	"VER_OOPS"		=> "Ooops...quelque chose n'a pas fonctionné, peut-être un lien ancien sur lequel vous avez cliqué. Cliquez ci dessous pour essayer de nouveau",
	"VER_RESET"		=> "Votre mot de passe a été changé!",
	"VER_INS"			=> "<li>Entrez votre adresse courriel et cliquez sur réinitialiser</li> <li> regardez vos courriels et cliquez sur le lien qui vous a été envoyé.</li><li>Suivez les instructions sur l'écran</li>",
	"VER_SENT"		=> " Votre lien pour modifier votre mot de passe a été envoyé à votre adresse courriel. 
			    							 Cliquez sur le lien dans le courriel pour réinitialiser votre mot de passe. Assurez-vous de vérifier votre dossier de courrier indésirable si le courriel n'est pas dans votre boîte de réception. <pLes liens de réinitialisation ne sont valables que pour ",
	"VER_PLEASE"	=> "S.V.P. Modifiez votre mot de passe",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"				=> "réinitialiser le PIN",
	"SET_WHY"				=> "Pourquoi je ne peux pas changer ça?",
	"SET_PW_MATCH"	=> "Doit être semblable au nouveau mot de passe",

	"SET_PIN_NEXT"	=> "Vous pourrez changer le PIN la prochaine fois que vous ferez une vérification",
	"SET_UPDATE"		=> "Mettre à jour vos données d'utilisateur",
	"SET_NOCHANGE"	=> "L'administrateur a désactivé la capacité de changer de nom d'utilisateur.",
	"SET_ONECHANGE"	=> "L'administrateur n'a autorisé qu'un changement de nom d'utilisateur et vous avez déjà utilisé cette possibilité.",

	"SET_GRAVITAR" => "<strong>Voulez vous changer votre photo? </strong><br> Visitez <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> et créez votre compte avec le même courriel que vous utilisez sur ce site . Cela fonctionne pour des millions de sites. C'est rapide et facile! utilisée sur ce site",

	"SET_NOTE1"			=> " S.V.P., notez  qu'il y a une demande en attente pour mettre à jour votre courriel à",

	"SET_NOTE2"			=> ".  S.V.P., utilisez le courriel de vérification pour répondre à cette demande. 
		 Si vous avez besoin d'un nouveau courriel de vérification, S.V.P. re-entrez le courriel ci dessus et faites de nouveau la demande. ",

	"SET_PW_REQ" 		=> "Nécessaire pour changer de mot de passe: courriel, ou réinitialiser le PIN",
	"SET_PW_REQI" 	=> "Nécessaire pour changer de mot de passe",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "Echec pour fermer la session en cours , Erreur: ",
	"ERR_Courriel"				=> "Courriel non envoyé pour cause d'erreur. S.V.P. contacter l'administrateur du site.",
	"ERR_EM_DB"				=> "Ce courriel n'existe pas dans votre base de données",
	"ERR_TC"					=> "S.V.P. lire et accepter les termes et conditions",
	"ERR_CAP"					=> "Vous avez échoué au test captcha, robot!",
	"ERR_PW_SAME"			=> "Votre ancien mot de passe ne peut être le même que le nouveau",
	"ERR_PW_FAIL"			=> "La vérification de mot de passe en cours a échoué . Echec de la mise à jour. S.V.P. essayer de nouveau.",
	"ERR_GOOG"				=> "REMARQUE:  Si vous êtes connecté avec votre compte google / facebook, utilisez le lien mot de passe oublié pour changer de mot de passe ... sauf si vous êtes doué pour quesser",
	"ERR_EM_VER"			=> "La vérification de courriel n'est pas activée. S.V.P. Contacter l'administrateur système.",
	"ERR_Courriel_STR"		=> "Quelque chose est bizarre. S.V.P. re-vérifiez notre courriel. Nous sommes désolés pour les inconvénients",

));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "Nous serons bientôt de retour!",
	"MAINT_MSG"			=> "Désolé pour le désagrément mais nous effectuons actuellement des opérations de maintenance .<br> Nous reviendrons très rapidement en ligne.!",
	"MAINT_BAN"			=> "Désolé , vous avez été interdit . Si vous pensez que c'est une erreur , S.V.P. contactez l'administrateur.",
	"MAINT_TOK"			=> "Il y avait une erreur dans votre formulaire . S.V.P. retournez en arrière et essayez de nouveau. S.V.P. notez que soumettre le formulaire en rafraîchissant la page peut causer une erreur. Si cela continue de se produire , S.V.P. contactez l'administrateur.",
	"MAINT_OPEN"		=> "Un logiciel libre de gestion d'utilisateurs en PHP.",
	"MAINT_PLEASE"	=> "Vous avez correctement installé UserSpice! <br> Pour consulter notre documentation de mise en route, rendez-vous sur"
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
	"DAT_SEARCH"    => "Chercher",
	"DAT_FIRST"     => "Premier",
	"DAT_LAST"      => "Dernier",
	"DAT_NEXT"      => "Suivant",
	"DAT_PREV"      => "Précédent",
	"DAT_NODATA"        => "Pas de données disponibles en tableau",
	"DAT_INFO"          => "Affichage _START_ à _END_ du _TOTAL_ entrées",
	"DAT_ZERO"          => "Affichage ø à ø de ø entrées",
	"DAT_FILTERED"      => "(Filtré de _MAX_ total entrées)",
	"DAT_MENU_LENG"     => "affichage _MENU_ entrées",
	"DAT_LOADING"       => "Chargement...",
	"DAT_PROCESS"       => "Traitement...",
	"DAT_NO_REC"        => "Pas d'enregistrements correspondant trouvés",
	"DAT_ASC"           => "Activer pour trier ordre ascendant",
	"DAT_DESC"          => "Activer pour trier ordre descendant",
));


///////////////////////////////////////////////////////////////

//Backend Translations for UserSpice
$lang = array_merge($lang, array(
	"BE_DASH"    			=> "Tableau interface",
	"BE_SETTINGS"     => "Paramètres",
	"BE_GEN"					=> "General",
	"BE_REG"					=> "Inscription",
	"BE_CUS"					=> "Paramètres personnalisés",
	"BE_DASH_ACC"			=> "Accès au tableau interface",
	"BE_TOOLS"				=> "Outils",
	"BE_BACKUP"				=> "Sauvegarde",
	"BE_UPDATE"				=> "Mises à jour",
	"BE_CRON"				  => "Tâches Cron",
	"BE_IP"				  	=> "Gestionnaire d'IP",
));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
