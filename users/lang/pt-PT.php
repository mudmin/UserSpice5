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
"THIS_LANGUAGE"	=>"Brazilian Portuguese",
"THIS_CODE"			=>"pt-BR",
"MISSING_TEXT"	=>"Texto Perdido",
));

//Database Menus
$lang = array_merge($lang,array(
"MENU_HOME"			=> "Início",
"MENU_HELP"			=> "Ajuda",
"MENU_ACCOUNT"	=> "Conta",
"MENU_DASH"			=> "Painel Administrativo",
"MENU_USER_MGR"	=> "Gestão de utilizadores",
"MENU_PAGE_MGR"	=> "gestão de páginas",
"MENU_PERM_MGR"	=> "gestão de permissões",
"MENU_MSGS_MGR"	=> "gestão de mensagens",
"MENU_LOGS_MGR"	=> "Logs do sistema",
"MENU_LOGOUT"		=> "Sair",
));

// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"					=> "Registrar",
	"SIGNUP_BUTTONTEXT"		=> "Registe-me",
	"SIGNUP_AUDITTEXT"		=> "Registrado",
	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"				=> "** FALHA NO LOGIN **",
	"SIGNIN_PLEASE_CHK" => "Por favor verifique seu utilizador e senha e tente novamente",
	"SIGNIN_UORE"				=> "Username ou Email",
	"SIGNIN_PASS"				=> "Senha",
	"SIGNIN_TITLE"			=> "Por favor autentique-se",
	"SIGNIN_TEXT"				=> "Entrar",
	"SIGNOUT_TEXT"			=> "Sair",
	"SIGNIN_BUTTONTEXT"	=> "Entrar",
	"SIGNIN_REMEMBER"		=> "Lembre-se de mim",
	"SIGNIN_AUDITTEXT"	=> "Autenticado",
	"SIGNIN_FORGOTPASS"	=>"Perdeu a senha",
	"SIGNOUT_AUDITTEXT"	=> "Saiu",
	));

// Account Page
$lang = array_merge($lang,array(
	"ACCT_EDIT"					=> "Editar informações da conta",
	"ACCT_2FA"					=> "Gerir 2 Factor Authentication",
	"ACCT_SESS"					=> "Gerir Sessões",
	"ACCT_HOME"					=> "Minha conta",
	"ACCT_SINCE"				=> "Membro desde",
	"ACCT_LOGINS"				=> "Número de Logins",
	"ACCT_SESSIONS"			=> "Número de sessões ativas",
	"ACCT_MNG_SES"			=> "Click no botão Gerir Sessões na barra lateral esquerda para mais informações.",
	));

	//General Terms
	$lang = array_merge($lang,array(
		"GEN_ENABLED"			=> "Habilitado",
		"GEN_DISABLED"		=> "Desabilitado",
		"GEN_ENABLE"			=> "Habilitar",
		"GEN_DISABLE"			=> "Desabilitar",
		"GEN_NO"					=> "Não",
		"GEN_YES"					=> "Sim",
		"GEN_MIN"					=> "min",
		"GEN_MAX"					=> "max",
		"GEN_CHAR"				=> "char", //as in characters
		"GEN_SUBMIT"			=> "Enviar",
		"GEN_MANAGE"			=> "Gerir",
		"GEN_VERIFY"			=> "Verificar",
		"GEN_SESSION"			=> "Sessão",
		"GEN_SESSIONS"		=> "Sessões",
		"GEN_EMAIL"				=> "Email",
		"GEN_FNAME"				=> "Nome",
		"GEN_LNAME"				=> "Apelido",
		"GEN_UNAME"				=> "Username",
		"GEN_PASS"				=> "Senha",
		"GEN_MSG"					=> "Mensagem",
		"GEN_TODAY"				=> "Hoje",
		"GEN_CLOSE"				=> "Fechar",
		"GEN_CANCEL"			=> "Cancelar",
		"GEN_CHECK"				=> "[ marcar/desmarcar todos ]",
		"GEN_WITH"				=> "com",
		"GEN_UPDATED"			=> "Atualizado",
		"GEN_UPDATE"			=> "Atualizar",
		"GEN_BY"					=> "por",
		"GEN_FUNCTIONS"		=> "Funções",
		"GEN_NUMBER"			=> "número",
		"GEN_NUMBERS"			=> "números",
		"GEN_INFO"				=> "informação",
		"GEN_REC"					=> "Gravado",
		"GEN_DEL"					=> "Apagar",
		"GEN_NOT_AVAIL"		=> "Não disponível",
		"GEN_AVAIL"				=> "Disponível",
		"GEN_BACK"				=> "Voltar",
		"GEN_RESET"				=> "Reset",
		"GEN_REQ"					=> "exigido",
		"GEN_AND"					=> "e",
		"GEN_SAME"				=> "deve ser igual",
		));

//validation class
	$lang = array_merge($lang,array(
		"VAL_SAME"				=> "deve ser igual",
		"VAL_EXISTS"			=> "já existe. Por favor escolha outro",
		"VAL_DB"					=> "Erro na base de dados",
		"VAL_NUM"					=> "deve ser um número",
		"VAL_INT"					=> "deve ser um número inteiro",
		"VAL_EMAIL"				=> "deve ser um email válido",
		"VAL_NO_EMAIL"		=> "não pode ser um endereço de email",
		"VAL_SERVER"			=> "deve pertencer a um servidor válido",
		"VAL_LESS"				=> "deve ser menos que",
		"VAL_GREAT"				=> "deve ser maior que",
		"VAL_LESS_EQ"			=> "deve ser menor ou igual a",
		"VAL_GREAT_EQ"		=> "deve ser maior ou igual a",
		"VAL_NOT_EQ"			=> "não pode ser igual a",
		"VAL_EQ"					=> "deve ser igual a",
		"VAL_TZ"					=> "tem que ser um nome de fuso horário válido",
		"VAL_MUST"				=> "deve ser",
		"VAL_MUST_LIST"		=> "deve ser um dos seguintes",
		"VAL_TIME"				=> "deve ser um horário válido",
		"VAL_SEL"					=> "não é uma seleção válida",
		"VAL_NA_PHONE"		=> "deve ser um número de telefone válido",
	));

		//Time
	$lang = array_merge($lang,array(
		"T_YEARS"			=> "Anos",
		"T_YEAR"			=> "Ano",
		"T_MONTHS"		=> "Meses",
		"T_MONTH"			=> "Mes",
		"T_WEEKS"			=> "Semanas",
		"T_WEEK"			=> "Semana",
		"T_DAYS"			=> "Dias",
		"T_DAY"				=> "Dia",
		"T_HOURS"			=> "Horas",
		"T_HOUR"			=> "Hora",
		"T_MINUTES"		=> "Minutos",
		"T_MINUTE"		=> "Minuto",
		"T_SECONDS"		=> "Segundos",
		"T_SECOND"		=> "Segundo",
		));


		//Passwords
	$lang = array_merge($lang,array(
		"PW_NEW"		=> "Nova senha",
		"PW_OLD"		=> "Senha antiga",
		"PW_CONF"		=> "Confirme a Senha",
		"PW_RESET"	=> "Redefinir a senha",
		"PW_UPD"		=> "Senha atualizada",
		"PW_SHOULD"	=> "As senhas devem...",
		"PW_SHOW"		=> "Mostrar Senha",
		"PW_SHOWS"	=> "Mostrar Senhas",
		));


		//Join
	$lang = array_merge($lang,array(
		"JOIN_SUC"			=> "Bem vindo a ",
		"JOIN_THANKS"		=> "Obrigado por se registrar",
		"JOIN_HAVE"			=> "Ter no mínimo ",
		"JOIN_CAP"			=> " letra maiúscula",
		"JOIN_CAPS"			=> " letras maiúsculas",
		"JOIN_TWICE"		=> "Seja digitado corretamente duas vezes",
		"JOIN_CLOSED"		=> "Infelizmente, o registro está desativado no momento. Por favor, entre em contato com o Administrador do Site se tiver alguma dúvida ou preocupação.",
		"JOIN_TC"				=> "Termo de registro e condições",
		"JOIN_ACCEPTTC" => "Eu aceito os termos de registro e condições",
		"JOIN_CHANGED"	=> "Nossos termos foram modificados",
		"JOIN_ACCEPT" 	=> "Aceite os termos e condições e continue",
		));

		//Sessions
	$lang = array_merge($lang,array(
		"SESS_SUC"	=> "Termidada com sucesso ",
		));

		//Messages
	$lang = array_merge($lang,array(
		"MSG_SENT"			=> "Sua mensagem foi enviada!",
		"MSG_MASS"			=> "Seu envio em massa foi enviado!",
		"MSG_NEW"				=> "Nova mensagem",
		"MSG_NEW_MASS"	=> "Nova mensagem em massa",
		"MSG_CONV"			=> "Conversas",
		"MSG_NO_CONV"		=> "Sem conversas",
		"MSG_NO_ARC"		=> "Sem conversas",
		"MSG_QUEST"			=> "Enviar notificações de email, se habilitadas?",
		"MSG_ARC"				=> "Tópicos arquivados",
		"MSG_VIEW_ARC"	=> "Ver Tópicos Arquivados",
		"MSG_SETTINGS"  => "Configurações de mensagens",
		"MSG_READ"			=> "Lida",
		"MSG_BODY"			=> "Corpo",
		"MSG_SUB"				=> "Assunto",
		"MSG_DEL"				=> "Enviada",
		"MSG_REPLY"			=> "Responder",
		"MSG_QUICK"			=> "Resposta Rápida",
		"MSG_SELECT"		=> "Selecione um utilizador",
		"MSG_UNKN"			=> "Destinatário Desconhecido",
		"MSG_NOTIF"			=> "Notificações por email",
		"MSG_BLANK"			=> "Mensagem não pode estar vazia",
		"MSG_MODAL"			=> "Clique aqui ou pressione Alt + R para focar nessa caixa OU pressione Shift + R para abrir o painel de resposta expandido!",
		"MSG_ARCHIVE_SUCCESSFUL"        => "Você arquivou com sucesso %m1% tópicos",
		"MSG_UNARCHIVE_SUCCESSFUL"      => "Você desarquivou com sucesso %m1% tópicos",
		"MSG_DELETE_SUCCESSFUL"         => "Você apagou com sucesso %m1% tópicos",
		"USER_MESSAGE_EXEMPT"         			=> "Utilizador é %m1% isento de mensagens.",
		"MSG_MK_READ"		=> "Lida",
		"MSG_MK_UNREAD"	=> "Não lida",
		"MSG_ARC_THR"		=> "Arquivar Tópicos Selecionados",
		"MSG_UN_THR"		=> "Desarquivar Tópicos Selecionados",
		"MSG_DEL_THR"		=> "Apagar Tópicos Selecionados",
		"MSG_SEND"			=> "Enviar Mensagem",
		));

	//2 Factor Authentication
	$lang = array_merge($lang,array(
		"2FA"				=> "Autenticação em 2 fatores 2FA",
		"2FA_CONF"	=> "Tem certeza de que deseja desativar o 2FA? Sua conta estará menos protegida.",
		"2FA_SCAN"	=> "Digitalize este código QR com a sua aplicação ou insira a chave",
		"2FA_THEN"	=> "Em seguida, insira uma das suas chaves de acesso únicas aqui",
		"2FA_FAIL"	=> "Houve um problema ao verificar 2FA. Por favor, verifique a Internet ou entre em contato com o suporte.",
		"2FA_CODE"	=> "Código 2FA",
		"2FA_EXP"		=> "1 impressão digital expirada",
		"2FA_EXPD"	=> "Expirada",
		"2FA_EXPS"	=> "Expirará",
		"2FA_ACTIVE"=> "Sessões Ativas",
		"2FA_NOT_FN"=> "Nenhuma impressão digital encontrada",
		"2FA_FP"		=> "Impressão digital",
		"2FA_NP"		=> "<strong>Falha de Login</strong> Código de autorização de dois fatores não estava presente. Por favor, tente novamente.",
		"2FA_INV"		=> "<strongFalha de Login</strong> Código de autorização de dois fatores inválido. Por favor, tente novamente.",
		"2FA_FATAL"	=> "<strong>Erro Grave</strong> Por Favor contate o administrador.",
		));

	//Redirect Messages - These get a plus between each word
	$lang = array_merge($lang,array(
		"REDIR_2FA"						=> "Desculpe.Autenticação+em+2+Fatores+não+habilitada+até+o+momento",
		"REDIR_2FA_EN"				=> "Autenticação+em+2+Fatores+habilitada",
		"REDIR_2FA_DIS"				=> "Autenticação+em+2+Fatores+desabilitada",
		"REDIR_2FA_VER"				=> "Autenticação+em+2+Fatores+verificada+e+habilitada",
		"REDIR_SOM_TING_WONG" => "Algo+aconteceu+errado.+Por+favor+tente+novamente.",
		"REDIR_MSG_NOEX"			=> "Esta+ação+não+te+pertence+ou+não+existe.",
		"REDIR_UN_ONCE"				=> "O+nome+de+utilizador+já+foi+modificado+uma+vez",
		"REDIR_EM_SUCC"				=> "Email+Atualizado+Com+Sucesso",
		));

	//Emails
	$lang = array_merge($lang,array(
		"EML_CONF"			=> "Confirme o Email",
		"EML_VER"				=> "Verifique Seu Email",
		"EML_CHK"				=> "Solicitação de email recebida. Por favor, verifique seu e-mail para realizar a verificação. Certifique-se de verificar sua pasta Spam e Lixeira à medida que o link de verificação expira em",
		"EML_MAT"				=> "Seu email não coincidiu.",
		"EML_HELLO"			=> "Olá de ",
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
			"VER_SUC"			=> "Seu Email foi verificado!",
			"VER_FAIL"		=> "Não foi possível confirmar sua conta. Por favor, tente novamente.",
			"VER_RESEND"	=> "Reenviamos o Email de verificação",
			"VER_AGAIN"		=> "Escreva seu endereço de e-mail e tente novamente",
			"VER_PAGE"		=> "<li>Verifique seu e-mail e clique no link que é enviado para você</li><li>Pronto</li>",
			"VER_RES_SUC" => "<p>Seu link de confirmação foi enviado para seu endereço de e-mail.</p><p> Clique no link do e-mail para concluir a verificação. Certifique-se de verificar sua pasta de spam se o e-mail não estiver na sua caixa de entrada. </ P> <p> Os links de verificação só são válidos por",
			"VER_OOPS"		=> "Ops ... algo deu errado, talvez um link de reinicialização antigo em que você clicou. Clique abaixo para tentar novamente",
			"VER_RESET"		=> "Sua senha foi alterada!",
			"VER_INS"			=> "<li> Insira seu endereço de e-mail e clique em Redefinir </ li> <li> Verifique seu e-mail e clique no link que é enviado para você. </ li>
												<li> Siga as instruções da tela </ li>",
			"VER_SENT"		=> "<p>Seu link de redefinição de senha foi enviado para o seu endereço de e-mail.</p>
			    							<p>Clique no link no email para redefinir sua senha. Certifique-se de verificar sua pasta de spam se o e-mail não estiver na sua caixa de entrada. </p> <p> Os links de redefinição são válidos por",
			"VER_PLEASE"	=> "Por Favor Altere Sua Senha",
			));

	//User Settings
	$lang = array_merge($lang,array(
		"SET_PIN"				=> "Redefinir PIN",
		"SET_WHY"				=> "Poque eu não posso mudar isso?",
		"SET_PW_MATCH"	=> "Deve ser igual à nova senha",

		"SET_PIN_NEXT"	=> "Você pode definir um novo PIN na próxima vez que desejar confirmação",
		"SET_UPDATE"		=> "Atualize suas configurações de utilizador",
		"SET_NOCHANGE"	=> "O administrador desativou a alteração de nomes de utilizador.",
		"SET_ONECHANGE"	=> "O Administrador definiu alterações de nome de utilizador para ocorrer apenas uma vez e você já fez isso.",

		"SET_GRAVITAR"	=> "<strong>Deseja modificar sua imagem de perfil? </strong><br> Visite <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a>e configure uma conta com o mesmo e-mail que você usou neste site. Ele funciona em milhões de sites. É rápido e fácil!",

		"SET_NOTE1"			=> "<p><strong>Por favor repare</strong> há uma solicitação pendente para atualizar seu e-mail para",

		"SET_NOTE2"			=> ".</p><p>Por favor, use o e-mail de verificação para concluir esta solicitação.</p>
		<p>Se você precisar de um novo e-mail de verificação, insira o e-mail acima e envie a solicitação novamente.</p>",

		"SET_PW_REQ" 		=> "necessário para alterar senha, e-mail ou redefinir o PIN",
		"SET_PW_REQI" 	=> "Necessário para alterar sua senha",

		));

	//Errors
	$lang = array_merge($lang,array(
		"ERR_FAIL_ACT"		=> "Falha ao encerrar sessões ativas, erro: ",
		"ERR_EMAIL"				=> "E-mail não enviado devido a erro. Por favor entre em contato com o administrador do site.",
		"ERR_EM_DB"				=> "Esse e-mail não existe em nosso banco de dados",
		"ERR_TC"					=> "Por favor, leia e aceite os termos e condições",
		"ERR_CAP"					=> "Você falhou no Teste Captcha, Robôt!",
		"ERR_PW_SAME"			=> "Sua senha antiga não pode ser igual à sua nova senha",
		"ERR_PW_FAIL"			=> "A verificação da senha atual falhou. Atualização falhou. Por favor, tente novamente.",
		"ERR_GOOG"				=> "<strong>ATENÇÃO:</strong>Se você se inscreveu originalmente com a sua conta do Google / Facebook, precisará usar o link de senha esquecida para alterar sua senha ... a menos que seja realmente bom em adivinhar.",
		"ERR_EM_VER"			=> "A verificação de e-mail não está ativada. Por favor contacte o administrador do sistema.",
		"ERR_EMAIL_STR"		=> "Algo está estranho. Por favor, verifique novamente o seu email. Lamentamos o inconveniente",
		));

	//Maintenance Page
	$lang = array_merge($lang,array(
		"MAINT_HEAD"		=> "Nós voltaremos em breve!",
		"MAINT_MSG"			=> "Desculpe pelo inconveniente, mas estamos a efectuar uma manutenção de momento. <br> Estaremos de volta on-line em breve!",
		"MAINT_BAN"			=> "Desculpa. Você foi banido. Se você acha que isso é um erro, entre em contato com o administrador.",
		"MAINT_TOK"			=> "Houve um erro com o seu formulário. Por favor volte e tente novamente. Observe que enviar o formulário atualizando a página causará um erro. Se isso continuar a acontecer, entre em contato com o administrador.",
		"MAINT_OPEN"		=> "Uma estrutura de gestão de utilizadors PHP de código aberto.",
		"MAINT_PLEASE"	=> "Você instalou com sucesso o UserSpice! <br> Para ver nossa documentação inicial, visite"
		));


//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
 //do not put a closing php tag here
