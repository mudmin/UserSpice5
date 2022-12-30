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
//You defiitely want to customize these for your language
$lang = array_merge($lang,array(
"THIS_LANGUAGE"	=>"French",
"THIS_CODE"			=>"en-US",
"MISSING_TEXT"	=>"Texte manquant",
));

//Database Menus
$lang = array_merge($lang,array(
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
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"					=> "S'inscrire",
	"SIGNUP_BUTTONTEXT"		=> "S'inscrire",
	"SIGNUP_AUDITTEXT"		=> "Inscrit",
	));

// Signin
$lang = array_merge($lang,array(
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
	"SIGNIN_FORGOTPASS"	=>"Mot de passe oublié",
	"SIGNOUT_AUDITTEXT"	=> "Déconnecté",
	));

// Account Page
$lang = array_merge($lang,array(
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
	$lang = array_merge($lang,array(
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

//validation class
	$lang = array_merge($lang,array(
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
		"PW_RESET"	=> "Réinitialiser le mot de passe",
		"PW_UPD"		=> "Mot de passe mis à jour",
		"PW_SHOULD"	=> "Le mot de passe devrait...",
		"PW_SHOW"		=> "Montrer le mot de passe",
		"PW_SHOWS"	=> "Montrer les mots de passe",
		));


		//Join
	$lang = array_merge($lang,array(
		"JOIN_SUC"			=> "Bienvenue ",
		"JOIN_THANKS"		=> "Merci pour votre inscription!",
		"JOIN_HAVE"			=> "avoir au moins ",
		"JOIN_CAP"			=> " lettre majuscule",
		"JOIN_TWICE"		=> "Être tapé deux fois correctement",
		"JOIN_CLOSED"		=> "Inscription malheureusement désactivée en ce moment. S.V.P. contacter l'administrateur du site si vous avez des questions ou des problèmes.",
		"JOIN_TC"				=> "Termes et conditions de l'inscription",
		"JOIN_ACCEPTTC" => "J'accepte les termes et conditions de l'utilisateur",
		"JOIN_CHANGED"	=> "Nos termes ont été modifiés",
		"JOIN_ACCEPT" 	=> "Accepter les termes et conditions pour utilisateur et continuer",
		));

		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "Fermé avec succès ",
		));

		//Messages
	$lang = array_merge($lang,array(
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
		"MSG_MODAL"			=> "Cliquez ici ou appuyez sur Alt + R pour atteindre sur cette case OU appuyez sur Maj + R pour ouvrir la boîte de réponse allongée

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

	//2 Factor Authentication
	$lang = array_merge($lang,array(
		"2FA"				=> "Authentification à 2 facteurs",
		"2FA_CONF"	=> "Etes vous sûr de vouloir désactiver 2FA ? Votre compte ne sera plus protégé.",
		"2FA_SCAN"	=> "lisez ce code QR avec votre application d'authentification ou saisissez la clé",
		"2FA_THEN"	=> "Puis entrer une de vos clés uniques ici",
		"2FA_FAIL"	=> "Il y a eu un problème pour vérifier 2FA. S.V.P. voir Internet ou contacter l'assistance.",
		"2FA_CODE"	=> "Code 2FA",
		"2FA_EXP"		=> "1 empreinte digitale expirée",
		"2FA_EXPD"	=> "Expiré",
		"2FA_EXPS"	=> "En cours d'expiration",
		"2FA_ACTIVE"=> "sessions actives",
		"2FA_NOT_FN"=> "Pas d'empreinte trouvée",
		"2FA_FP"		=> "Empreintes digitales",
		"2FA_NP"		=> "<strong>Echec login</strong> Double facteur d'authentification non présent. S.V.P. essayer de nouveau.",
		"2FA_INV"		=> "<strong>Echec login</strong> double facteur d'authentification invalide. S.V.P. essayer de nouveau.",
		"2FA_FATAL"	=> "<strong>Erreur fatale</strong> S.V.P. contacter l'administrateur du système.",
		));

	//Redirect Messages - These get a plus between each word // needs work in French
	$lang = array_merge($lang,array(
		"REDIR_2FA"						=> "Désolé.Deux+facteurs+n'est+pas+activé+en+ce+moment",
		"REDIR_2FA_EN"				=> "2+facteur+authentification+Activée",
		"REDIR_2FA_DIS"				=> "2+facteur+authentification+Desactivée",
		"REDIR_2FA_VER"				=> "2+facteur+authentification+vérifiée+et+activée",
		"REDIR_SOM_TING_WONG" => "erreur+S.V.P.+essayer+de+nouveau.",
		"REDIR_MSG_NOEX"			=> "Ce+thread+ne+vous+appartient+pas+ou+n'existe+pas.",
		"REDIR_UN_ONCE"				=> "Le+nom+d'utilisateur+a+déjà+été+changé.",
		"REDIR_EM_SUCC"				=> "Courriel+Mise+à+jour+réussie",
		));

	//Courriels
	$lang = array_merge($lang,array(
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
		$lang = array_merge($lang,array(
			"VER_SUC"			=> "Votre courriel a été vérifié!",
			"VER_FAIL"		=> "Il nous est impossible de vérifier votre compte . S.V.P. essayez de nouveau.",
			"VER_RESEND"	=> "Renvoyer un courriel de vérification",
			"VER_AGAIN"		=> "Saisir votre adresse courriel et essayez de nouveau",
			"VER_PAGE"		=> "<li>Vérifiez votre courriel et cliquez sur le lien qui vous est envoyé</li><li>Terminé</li>",
			"VER_RES_SUC" => "<p>Votre lien de vérification a été envoyé à votre adresse e-mail.</p><p>Cliquez sur le lien dans l'e-mail pour terminer la vérification. Assurez-vous de vérifier votre dossier de courrier indésirable si le courriel n'est pas dans votre boîte de réception.</p><p>Les liens de vérification ne sont valables que pour ",
			"VER_OOPS"		=> "Ooops...quelque chose n'a pas fonctionné, peut-être un lien ancien sur lequel vous avez cliqué. Cliquez ci dessous pour essayer de nouveau",
			"VER_RESET"		=> "Votre mot de passe a été changé!",
			"VER_INS"			=> "<li>Entrez votre adresse courriel et cliquez sur réinitialiser</li> <li> regardez vos courriels et cliquez sur le lien qui vous a été envoyé.</li><li>Suivez les instructions sur l'écran</li>",
			"VER_SENT"		=> "<p>Votre lien pour modifier votre mot de passe a été envoyé à votre adresse courriel.</p>
			    							<p>Cliquez sur le lien dans le courriel pour réinitialiser votre mot de passe. Assurez-vous de vérifier votre dossier de courrier indésirable si le courriel n'est pas dans votre boîte de réception.</p><pLes liens de réinitialisation ne sont valables que pour ",
			"VER_PLEASE"	=> "S.V.P. Modifiez votre mot de passe",
			));

	//User Settings
	$lang = array_merge($lang,array(
		"SET_PIN"				=> "réinitialiser le PIN",
		"SET_WHY"				=> "Pourquoi je ne peux pas changer ça?",
		"SET_PW_MATCH"	=> "Doit être semblable au nouveau mot de passe",

		"SET_PIN_NEXT"	=> "Vous pourrez changer le PIN la prochaine fois que vous ferez une vérification",
		"SET_UPDATE"		=> "Mettre à jour vos données d'utilisateur",
		"SET_NOCHANGE"	=> "L'administrateur a désactivé la capacité de changer de nom d'utilisateur.",
		"SET_ONECHANGE"	=> "L'administrateur n'a autorisé qu'un changement de nom d'utilisateur et vous avez déjà utilisé cette possibilité.",

		"SET_GRAVITAR"	=> "<strong>Voulez vous changer votre photo? </strong><br> Visitez <a href='https://en.gravatar.com/'https://en.gravatar.com/</a> et créez votre compte avec le même courriel que vous utilisez sur ce site . Cela fonctionne pour des millions de sites. C'est rapide et facile! utilisée sur ce site",

		"SET_NOTE1"			=> "<p><strong>S.V.P., notez</strong> qu'il y a une demande en attente pour mettre à jour votre courriel à",

		"SET_NOTE2"			=> ".</p><p>S.V.P., utilisez le courriel de vérification pour répondre à cette demande.</p>
		<p>Si vous avez besoin d'un nouveau courriel de vérification, S.V.P. re-entrez le courriel ci dessus et faites de nouveau la demande.</p>",

		"SET_PW_REQ" 		=> "Nécessaire pour changer de mot de passe: courriel, ou réinitialiser le PIN",
		"SET_PW_REQI" 	=> "Nécessaire pour changer de mot de passe",

		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"		=> "Echec pour fermer la session en cours , Erreur: ",
		"ERR_Courriel"				=> "Courriel non envoyé pour cause d'erreur. S.V.P. contacter l'administrateur du site.",
		"ERR_EM_DB"				=> "Ce courriel n'existe pas dans votre base de données",
		"ERR_TC"					=> "S.V.P. lire et accepter les termes et conditions",
		"ERR_CAP"					=> "Vous avez échoué au test captcha, robot!",
		"ERR_PW_SAME"			=> "Votre ancien mot de passe ne peut être le même que le nouveau",
		"ERR_PW_FAIL"			=> "La vérification de mot de passe en cours a échoué . Echec de la mise à jour. S.V.P. essayer de nouveau.",
		"ERR_GOOG"				=> "<strong>REMARQUE:</strong> Si vous êtes connecté avec votre compte google / facebook, utilisez le lien mot de passe oublié pour changer de mot de passe ... sauf si vous êtes doué pour quesser",
		"ERR_EM_VER"			=> "La vérification de courriel n'est pas activée. S.V.P. Contacter l'administrateur système.",
		"ERR_Courriel_STR"		=> "Quelque chose est bizarre. S.V.P. re-vérifiez notre courriel. Nous sommes désolés pour les inconvénients",

		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"		=> "Nous serons bientôt de retour!",
		"MAINT_MSG"			=> "Désolé pour le désagrément mais nous effectuons actuellement des opérations de maintenance .<br> Nous reviendrons très rapidement en ligne.!",
		"MAINT_BAN"			=> "Désolé , vous avez été interdit . Si vous pensez que c'est une erreur , S.V.P. contactez l'administrateur.",
		"MAINT_TOK"			=> "Il y avait une erreur dans votre formulaire . S.V.P. retournez en arrière et essayez de nouveau. S.V.P. notez que soumettre le formulaire en rafraîchissant la page peut causer une erreur. Si cela continue de se produire , S.V.P. contactez l'administrateur.",
		"MAINT_OPEN"		=> "Un logiciel libre de gestion d'utilisateurs en PHP.",
		"MAINT_PLEASE"	=> "Vous avez correctement installé UserSpice! <br> Pour consulter notre documentation de mise en route, rendez-vous sur"
		));

		//dataTables Added in 4.4.08
		//NOTE: do not change the words like _START_ between the two _ symbols!
		$lang = array_merge($lang,array(
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
$lang = array_merge($lang,array(
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
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
 //do not put a closing php tag here
