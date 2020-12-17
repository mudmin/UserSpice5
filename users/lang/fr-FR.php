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
	"SIGNUP_AUDITTEXT"		=> "Inscrite",
	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"				=> "** ÉCHEC DE LA CONNEXION **",
	"SIGNIN_PLEASE_CHK" => "Veuillez vérifier vos identifiant et mot de passe puis ré-essayer",
	"SIGNIN_UORE"				=> "Nom d'utilisateur ou email",
	"SIGNIN_PASS"				=> "Mot de passe",
	"SIGNIN_TITLE"			=> "Veuillez vous connecter",
	"SIGNIN_TEXT"				=> "s'identifier",
	"SIGNOUT_TEXT"			=> "se déconnecter",
	"SIGNIN_BUTTONTEXT"	=> "S'identifier",
	"SIGNIN_REMEMBER"		=> "souviens-toi de moi",
	"SIGNIN_AUDITTEXT"	=> "connecté",
	"SIGNIN_FORGOTPASS"	=>"Mot de passe oublié",
	"SIGNOUT_AUDITTEXT"	=> "Déconnecté",
	));

// Account Page
$lang = array_merge($lang,array(
	"ACCT_EDIT"					=> "Editer infos compte",
	"ACCT_2FA"					=> "Gérer l'authentification à 2 facteurs",
	"ACCT_SESS"					=> "Gérer les sessions",
	"ACCT_HOME"					=> "Compte Accueil",
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
		"GEN_CHAR"				=> "char", //as in characters
		"GEN_SUBMIT"			=> "Soumettre",
		"GEN_MANAGE"			=> "Manage",
		"GEN_VERIFY"			=> "Vérifier",
		"GEN_SESSION"			=> "Session",
		"GEN_SESSIONS"		=> "Sessions",
		"GEN_EMAIL"				=> "Email",
		"GEN_FNAME"				=> "Prénom",
		"GEN_LNAME"				=> "nom de famille",
		"GEN_UNAME"				=> "Nom d'utilisateur",
		"GEN_PASS"				=> "mot de passe",
		"GEN_MSG"					=> "Message",
		"GEN_TODAY"				=> "aujourd'hui",
		"GEN_CLOSE"				=> "Fermer",
		"GEN_CANCEL"			=> "Annuler",
		"GEN_CHECK"				=> "[ Verifier/non vérifiés  tous ]",
		"GEN_WITH"				=> "Avec",
		"GEN_UPDATED"			=> "Mis à jour",
		"GEN_UPDATE"			=> "Mise à jour",
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
		"VAL_EMAIL"				=> "doit être une adresse email valide",
		"VAL_NO_EMAIL"		=> "ne peut pas être une adresse email",
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
		"PW_CONF"		=> "Confirmer mot de passe",
		"PW_RESET"	=> "Réinitialiser mot de passe",
		"PW_UPD"		=> "Mot de passe mis à jour",
		"PW_SHOULD"	=> "Mot de passe devrait...",
		"PW_SHOW"		=> "Montrer le mot de passe",
		"PW_SHOWS"	=> "Montrer les mots de passe",
		));


		//Join
	$lang = array_merge($lang,array(
		"JOIN_SUC"			=> "Bienvenue ",
		"JOIN_THANKS"		=> "Merci de votre inscription!",
		"JOIN_HAVE"			=> "Avoir au moins ",
		"JOIN_CAP"			=> " lettre capitale",
		"JOIN_TWICE"		=> "taper deux fois correctement",
		"JOIN_CLOSED"		=> "Inscription malheureusement désactivée en ce moment. SVP contacter l'administrateur du site si vous avez des questions ou des problèmes.",
		"JOIN_TC"				=> "Utilisateur termes et conditions",
		"JOIN_ACCEPTTC" => "J'accepte les termes et conditions de l'utilisateur",
		"JOIN_CHANGED"	=> "Nos termes ont été modifiés",
		"JOIN_ACCEPT" 	=> "Accepter les termes et conditions utilisateur et continuer",
		));

		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "tué avec succès ",
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
		"MSG_QUEST"			=> "Envoyer un E mail de confirmation si activé?",
		"MSG_ARC"				=> "threads archivés",
		"MSG_VIEW_ARC"	=> "Voir les threads archivés",
		"MSG_SETTINGS"  => "Message paramètres",
		"MSG_READ"			=> "Lire",
		"MSG_BODY"			=> "Contenu",
		"MSG_SUB"				=> "Sujet",
		"MSG_DEL"				=> "Délivré",
		"MSG_REPLY"			=> "Réponse",
		"MSG_QUICK"			=> "Réponse rapide",
		"MSG_SELECT"		=> "Sélectionner un utilisateur",
		"MSG_UNKN"			=> "Récipient inconnu",
		"MSG_NOTIF"			=> "Message Email Notifications",
		"MSG_BLANK"			=> "Le message doit avoir un contenu",
		"MSG_MODAL"			=> "Cliquez ici ou appuyez sur Alt + R pour vous concentrer sur cette case OU appuyez sur Maj + R pour ouvrir le panneau de réponse développé

!",
		"MSG_ARCHIVE_SUCCESSFUL"        => "Vous avez archivé avec succès %m1% discussions",
		"MSG_UNARCHIVE_SUCCESSFUL"      => "Vous avez désarchivé %m1% threads avec succès",
		"MSG_DELETE_SUCCESSFUL"         => "Vous avez supprimé avec succès %m1% discussions",
		"USER_MESSAGE_EXEMPT"         			=> "L'utilisateur est %m1% exempté de messages.",
		"MSG_MK_READ"		=> "lu",
		"MSG_MK_UNREAD"	=> "Non lu",
		"MSG_ARC_THR"		=> "Archiver les threads sélectionnés",
		"MSG_UN_THR"		=> "Désarchiver les threads sélectionnés",
		"MSG_DEL_THR"		=> "Supprimer les threads sélectionnés",
		"MSG_SEND"			=> "Envoyer le message",
		));

	//2 Factor Authentication
	$lang = array_merge($lang,array(
		"2FA"				=> "Authentification à 2 facteurs",
		"2FA_CONF"	=> "Etes vous sûr de vouloir désactiver 2FA ? Votre compte ne sera plus protégé.",
		"2FA_SCAN"	=> "Scan this QR code avec votre application d'authentification ou rentrer la clé",
		"2FA_THEN"	=> "Puis entrer de vos passes clés uniques ici",
		"2FA_FAIL"	=> "Il y a eu un problème pour vérifier 2FA. SVOP voir Internet ou contacter l'assistance.",
		"2FA_CODE"	=> "2FA Code",
		"2FA_EXP"		=> "Expiré 1 empreinte digitale",
		"2FA_EXPD"	=> "Expiré",
		"2FA_EXPS"	=> "En cours d'expiration",
		"2FA_ACTIVE"=> "sessions actives",
		"2FA_NOT_FN"=> "Pas d'empreinte trouvée",
		"2FA_FP"		=> "Empreintes digitales",
		"2FA_NP"		=> "<strong>Echec login</strong> Double facteur d'authentification non présent. SVP essayer de nouveau.",
		"2FA_INV"		=> "<strong>Echec login</strong> double facteur d'authentification invalide. SVP essayer de nouveau.",
		"2FA_FATAL"	=> "<strong>Erreur fatale</strong> SVP contacter l'administrateur du système.",
		));

	//Redirect Messages - These get a plus between each word
	$lang = array_merge($lang,array(
		"REDIR_2FA"						=> "Désolé.Deux+facteurs+n'est+pas+activé+en+ce+moment",
		"REDIR_2FA_EN"				=> "2+facteur+authentification+Activée",
		"REDIR_2FA_DIS"				=> "2+facteur+authentification+Desactivée",
		"REDIR_2FA_VER"				=> "2+facteur+authentification+vérifiée+et+activée",
		"REDIR_SOM_TING_WONG" => "erreur+SVP+essayer+de+nouveau.",
		"REDIR_MSG_NOEX"			=> "Ce+thread+ne+vous+appartient+pas+ou+n'existe+pas.",
		"REDIR_UN_ONCE"				=> "Le+nom+d'utilisateur+a+déjà+été+changé.",
		"REDIR_EM_SUCC"				=> "Email+Mise+à+jour+réussie",
		));

	//Emails
	$lang = array_merge($lang,array(
		"EML_CONF"			=> "Confirmer Email",
		"EML_VER"				=> "Vérifiez votre email",
		"EML_CHK"				=> "Demande d'email reçue. SVP voir vos emails pour vérification. Veillez à consulter vos dossiers Spam et Junk lorsque le lien de vérification expire ",
		"EML_MAT"				=> "Votre Email n'était pas le même.",
		"EML_HELLO"			=> "Hello de ",
		"EML_HI"				=> "Bonjour ",
		"EML_AD_HAS"		=> "Un administrateur a changé votre mot de passe.",
		"EML_AC_HAS"		=> "Un administrateur a créé votre compte.",
		"EML_REQ"				=> "Vous devrez établir votre mot de passe en utilisant le lien ci dessus.",
		"EML_EXP"				=> "SVP , notez , le lien mot de passe expirer dans ",
		"EML_VER_EXP"		=> "SVP , notez, le lien de vérification expire dans ",
		"EML_CLICK"			=> "Cliquer ici pour connection.",
		"EML_REC"				=> "Il est recommandé de changer de mot de passe après connection.",
		"EML_MSG"				=> "Vous avez un nouveau message de",
		"EML_REPLY"			=> "Cliquez ici pour répondre ou voir le thread",
		"EML_WHY"				=> "Vous recevez cet Email parce qu'une demande de renouvellement de mot de passe a été faite. Si ce n'était pas vous , vous pouvez ignorer cet Email.",
		"EML_HOW"				=> "Si c'était vous , cliquez sur le lien ci dessous pour poursuivre le processus de changement de mot de passe.",
		"EML_EML"				=> "Une demande de modification de votre email a été faite à partir de votre compte d'utilisateur.",
		"EML_VER_EML"		=> "Merci de votre inscription. une fois que vous aurez vérifié votre adresse mail vous serez prêt à vous connecter ! SVP cliquez sur le lien ci dessous pour vérifier votre adresse mail.",

		));

		//Verification
		$lang = array_merge($lang,array(
			"VER_SUC"			=> "Votre Email a été vérifié!",
			"VER_FAIL"		=> "Il nous est impossible de vérifier votre compte . SVP essayez de nouveau.",
			"VER_RESEND"	=> "renvoyer un e mail de vérification",
			"VER_AGAIN"		=> "entrer votre adresse mail et essayez de nouveau",
			"VER_PAGE"		=> "<li>Vérifiez votre email et cliquez sur le lien qui vous est envoyé</li><li>Terminé</li>",
			"VER_RES_SUC" => "<p>Votre lien de vérification a été envoyé à votre adresse e-mail.</p><p>Cliquez sur le lien dans l'e-mail pour terminer la vérification. Assurez-vous de vérifier votre dossier de courrier indésirable si l'email n'est pas dans votre boîte de réception.</p><p>Les liens de vérification ne sont valables que pour ",
			"VER_OOPS"		=> "Ooops...quelque chose n'a pas fonctionné, peut-être un lien ancien sur lequel vous avez cliqué. Cliquez ci dessous pour essayer de nouveau",
			"VER_RESET"		=> "Votre mot de passe a été changé!",
			"VER_INS"			=> "<li>Entrez votre adresse mail et cliquez sur réinitialiser</li> <li> regardez vos emails et cliquez sur le lien qui vous a été envoyé.</li><li>Suivez les instructions sur l'écran</li>",
			"VER_SENT"		=> "<p>Votre lien pour modifier votre mot de passe a été envoyé à votre adresse mail.</p>
			    							<p>Cliquez sur le lien dans l'email pour réinitialiser votre mot de passe. Assurez-vous de vérifier votre dossier de courrier indésirable si l'email n'est pas dans votre boîte de réception.</p><pLes liens de réinitialisation ne sont valables que pour ",
			"VER_PLEASE"	=> "SVP Modifiez votre mot de passe",
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

		"SET_GRAVITAR"	=> "<strong>Voulez vous changer votre photo? </strong><br> Visitez <a href='https://en.gravatar.com/'https://en.gravatar.com/</a> et créez votre compte avec le même Email que vous utilisez sur ce site . Cela fonctionne pour des millions de sites. C'est rapide et facile! utilisée sur ce site",

		"SET_NOTE1"			=> "<p><strong>SVP notez</strong> il y a une demande en attente pour mettre à jour votre Email à",

		"SET_NOTE2"			=> ".</p><p>SVP utilisez l'Email de vérification pour répondre à cette demande.</p>
		<p>Si vous avez besoin d'un nouvel Email de vérification, SVP re-entrez l'Email ci dessus et faites de nouveau la demande.</p>",

		"SET_PW_REQ" 		=> "Nécessaire pour changer de mot de passe, Email, or réinitialiser le PIN",
		"SET_PW_REQI" 	=> "Nécessaire pour changer de mot de passe",

		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"		=> "Echec pour fermer la session en cours , Erreur: ",
		"ERR_EMAIL"				=> "Email non envoyé pour cause d'erreur. SVP contacter l'administrateur du site.",
		"ERR_EM_DB"				=> "Cet email n'existe pas dans votre base de données",
		"ERR_TC"					=> "SVP lire et accepter les termes et conditions",
		"ERR_CAP"					=> "Vous avez échoué au test captcha, robot!",
		"ERR_PW_SAME"			=> "Votre ancien mot de passe ne peut être le même que le nouveau",
		"ERR_PW_FAIL"			=> "La vérification de mot de passe en cours a échoué . Echec de la mise à jour. SVP essayer de nouveau.",
		"ERR_GOOG"				=> "<strong>REMARQUE:</strong> Si vous êtes connecté avec votre compte google / facebook, utilisez le lien mot de passe oublié pour changer de mot de passe ... sauf si vous êtes doué pour quesser",
		"ERR_EM_VER"			=> "La vérification dEmail n'est pas activée. SVP Contacter l'administrateur système.",
		"ERR_EMAIL_STR"		=> "Quelque chose est bizarre. SVP re-vérifiez notre Email.Nous sommes désolés pour les inconvénients",

		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"		=> "Nous serons bientôt de retour!",
		"MAINT_MSG"			=> "Désolé pour le désagrément mais nous effectuons actuellement des opérations de maintenance .<br> Nous reviendrons très rapidement en ligne.!",
		"MAINT_BAN"			=> "Désolé , vous avez été interdit . Si vous pensez que c'est une erreur , SVP contactez l'administrateur.",
		"MAINT_TOK"			=> "Il y avait une erreur dans votre formulaire . SVP retournez en arrière et essayez de nouveau. SVP notez que soumettre le formulaire en rafraîchissant la page peut causer une erreur. Si cela continue de se produire , SVP contactez l'administrateur.",
		"MAINT_OPEN"		=> "Une source ouverte PHP utilisateur management programme.",
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
		"DAT_ASC"           => "activer pour trier ordre ascendant",
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
"BE_CRON"				  => "Cron planifiées",
"BE_IP"				  	=> "IP Manager",
));



//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
?>
