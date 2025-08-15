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
	"THIS_LANGUAGE"	=> "Brazilian Portuguese",
	"THIS_CODE"			=> "pt-BR",
	"MISSING_TEXT"	=> "Texto Perdido",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"    => "Introduza o código enviado para o seu e-mail",
    "PASS_EMAIL_ONLY"    => "Por favor, verifique o seu e-mail para obter a hiperligação de início de sessão.",
    "PASS_CODE_ONLY"     => "Por favor, introduza o código enviado para o seu e-mail.",
    "PASS_BOTH"          => "Por favor, verifique o seu e-mail para obter a hiperligação de início de sessão ou introduza o código enviado para o seu e-mail.",
    "PASS_VER_BUTTON"    => "Verificar código",
    "PASS_EMAIL_ONLY_MSG" => "Por favor, verifique o seu endereço de e-mail clicando na hiperligação abaixo.",
    "PASS_CODE_ONLY_MSG"  => "Por favor, introduza o código abaixo para iniciar sessão.",
    "PASS_BOTH_MSG"       => "Por favor, verifique o seu endereço de e-mail clicando na hiperligação abaixo ou introduza o código abaixo para iniciar sessão.",
    "PASS_YOUR_CODE"      => "O seu código de verificação é: ",
    "PASS_CONFIRM_LOGIN"  => "Confirmar Início de Sessão",
    "PASS_CONFIRM_CLICK"  => "Clique para Completar o Início de Sessão",
    "PASS_GENERIC_ERROR"  => "Ocorreu um erro.",
));

//Database Menus
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"					=> "Registrar",
	"SIGNUP_BUTTONTEXT"		=> "Registe-me",
	"SIGNUP_AUDITTEXT"		=> "Registrado",
));

// Signin
$lang = array_merge($lang, array(
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
	"SIGNIN_FORGOTPASS"	=> "Perdeu a senha",
	"SIGNOUT_AUDITTEXT"	=> "Saiu",
));

// Account Page
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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

// Passkey Translations
$lang = array_merge($lang, array(
    "GEN_PASSKEY"           => "Chave de Acesso",
    "GEN_ACTIONS"           => "Ações",
    "GEN_BACK_TO_ACCT"      => "Voltar à Conta",
    "GEN_DB_ERROR"          => "Ocorreu um erro na base de dados. Por favor, tenta novamente.",
    "GEN_IMPORTANT"         => "Importante",
    "GEN_NO_PERMISSIONS"    => "Não tens permissão para aceder a esta página.",
    "GEN_NO_PERMISSIONS_MSG" => "Não tens permissão para aceder a esta página. Se achas que isto é um erro, por favor contacta o administrador do site.",
    "PASSKEYS_MANAGE_TITLE" => "Gerir Chaves de Acesso",
    "PASSKEYS_LOGIN_TITLE"  => "Iniciar Sessão com Chave de Acesso",
    "PASSKEY_DELETE_SUCCESS" => "Chave de acesso eliminada com sucesso.",
    "PASSKEY_DELETE_FAIL_DB" => "Falha ao eliminar a chave de acesso da base de dados.",
    "PASSKEY_DELETE_NOT_FOUND" => "Chave de acesso não encontrada ou não tens permissão para a eliminar.",
    "PASSKEY_NOTE_UPDATE_SUCCESS" => "Nota da chave de acesso atualizada com sucesso.",
    "PASSKEY_NOTE_UPDATE_FAIL" => "Falha ao atualizar a nota da chave de acesso.",
    "PASSKEY_REGISTER_NEW"  => "Registar Nova Chave de Acesso",
    "PASSKEY_ERR_LIMIT_REACHED" => "Atingiste o limite máximo de 10 chaves de acesso.",
    "PASSKEY_NOTE_TH"       => "Nota da Chave de Acesso",
    "PASSKEY_TIMES_USED_TH" => "Vezes Utilizada",
    "PASSKEY_LAST_USED_TH"  => "Última Utilização",
    "PASSKEY_LAST_IP_TH"    => "Último IP",
    "PASSKEY_EDIT_NOTE_BTN" => "Editar Nota",
    "PASSKEY_CONFIRM_DELETE_JS" => "Tens a certeza de que queres eliminar esta chave de acesso?",
    "PASSKEY_EDIT_MODAL_TITLE" => "Editar Nota da Chave de Acesso",
    "PASSKEY_EDIT_MODAL_LABEL" => "Nota da Chave de Acesso",
    "PASSKEY_SAVE_CHANGES_BTN" => "Guardar Alterações",
    "PASSKEY_NONE_REGISTERED" => "Ainda não tens nenhuma chave de acesso registada.",
    "PASSKEY_MUST_REGISTER_FIRST" => "Deves primeiro registar uma chave de acesso a partir de uma conta autenticada antes de usares esta funcionalidade.",
    "PASSKEY_STORING"       => "A armazenar chave de acesso...",
    "PASSKEY_STORED_SUCCESS" => "Chave de acesso armazenada com sucesso!",
    "PASSKEY_INVALID_ACTION" => "Ação inválida: ",
    "PASSKEY_NO_ACTION_SPECIFIED" => "Nenhuma ação especificada",
    "PASSKEY_ERR_NETWORK_SUGGESTION" => "Problema de rede detetado. Tenta uma rede diferente ou atualiza a página.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "Autenticação entre dispositivos detetada. Assegura-te de que ambos os dispositivos têm acesso à internet.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "Tenta abrir esta página diretamente no teu telemóvel.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED" => "Não foi possível gerar diagnósticos: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA" => "Faltam dados de credenciais necessários para armazenamento.",
    "PASSKEY_MISSING_AUTH_DATA" => "Faltam dados de autenticação necessários.",
    "PASSKEY_LOG_NO_MESSAGE" => "Sem mensagem",
    "PASSKEY_USER_NOT_FOUND" => "Utilizador não encontrado após validação da chave de acesso.",
    "PASSKEY_FATAL_ERROR"    => "Erro fatal: ",
    "PASSKEY_LOGIN_SUCCESS"  => "Início de sessão bem-sucedido.",
    "PASSKEY_CROSS_DEVICE_PREP" => "A preparar registo entre dispositivos. Poderás precisar de usar o teu telemóvel ou tablet.",
    "PASSKEY_DEVICE_REGISTRATION" => "A usar registo de chave de acesso do dispositivo...",
    "PASSKEY_STARTING_REGISTRATION" => "A iniciar registo de chave de acesso...",
    "PASSKEY_REQUEST_OPTIONS" => "A solicitar opções de registo ao servidor...",
    "PASSKEY_FOLLOW_PROMPTS" => "Segue as instruções para criar a tua chave de acesso. Poderás precisar de usar outro dispositivo.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE" => "Segue as instruções para criar a tua chave de acesso...",
    "PASSKEY_CREATION_FAILED" => "Falha na criação da chave de acesso - nenhuma credencial retornada.",
    "PASSKEY_STORING_SERVER" => "A armazenar a tua chave de acesso...",
    "PASSKEY_CREATED_SUCCESS" => "Chave de acesso criada com sucesso!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP" => "A preparar autenticação entre dispositivos. Assegura-te de que o teu telemóvel e computador têm acesso à internet.",
    "PASSKEY_DEVICE_AUTH"    => "A usar autenticação de chave de acesso do dispositivo...",
    "PASSKEY_STARTING_AUTH"  => "A iniciar autenticação de chave de acesso...",
    "PASSKEY_QR_CODE_INSTRUCTION" => "Digitaliza o código QR com o teu telemóvel quando aparecer. Assegura-te de que ambos os dispositivos têm acesso à internet.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION" => "Escolhe \"Usar um telemóvel ou tablet\" quando solicitado, depois digitaliza o código QR.",
    "PASSKEY_AUTHENTICATING" => "A autenticar com a tua chave de acesso...",
    "PASSKEY_SUCCESS_REDIRECTING" => "Autenticação bem-sucedida! A redirecionar...",
    "PASSKEY_TIMEOUT_CROSS_DEVICE" => "O registo expirou. Para entre dispositivos: 1) Tenta novamente, 2) Assegura-te de que os dispositivos têm internet, 3) Considera registar diretamente no teu telemóvel.",
    "PASSKEY_TIMEOUT_SIMPLE" => "O registo expirou. Por favor, tenta novamente.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE" => "A autenticação entre dispositivos expirou. Resolução de problemas: 1) Ambos os dispositivos precisam de internet, 2) Tenta digitalizar o código QR mais rapidamente, 3) Considera usar o mesmo dispositivo, 4) Algumas redes bloqueiam a autenticação entre dispositivos.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE" => "A autenticação expirou. Por favor, tenta novamente.",
    "PASSKEY_NO_CREDENTIAL"  => "Nenhuma credencial recebida. A tentar novamente...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL" => "Autenticação falhou - nenhuma credencial retornada.",
    "PASSKEY_ATTEMPT_RETRY"  => "falhou. A tentar novamente... (%d tentativas restantes)",
    "PASSKEY_CROSS_DEVICE_FAILED" => "Registo entre dispositivos falhou. Tenta: 1) Assegura-te de que ambos os dispositivos têm internet, 2) Considera registar diretamente no teu telemóvel, 3) Algumas redes corporativas bloqueiam esta funcionalidade.",
    "PASSKEY_REGISTRATION_CANCELLED" => "O registo foi cancelado ou o dispositivo não suporta chaves de acesso.",
    "PASSKEY_NOT_SUPPORTED"  => "As chaves de acesso não são suportadas nesta combinação de dispositivo/navegador.",
    "PASSKEY_SECURITY_ERROR" => "Erro de segurança - isto normalmente indica uma incompatibilidade de domínio/origem.",
    "PASSKEY_ALREADY_EXISTS" => "Já existe uma chave de acesso para esta conta neste dispositivo. Tenta usar um dispositivo diferente ou elimina primeiro as chaves de acesso existentes.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED" => "Autenticação entre dispositivos falhou. Tenta: 1) Assegura-te de que ambos os dispositivos têm internet estável, 2) Usa a mesma rede WiFi, se possível, 3) Tenta autenticar diretamente no teu telemóvel, 4) Algumas redes corporativas bloqueiam esta funcionalidade.",
    "PASSKEY_AUTH_CANCELLED" => "A autenticação foi cancelada ou nenhuma chave de acesso foi selecionada.",
    "PASSKEY_NETWORK_ERROR"  => "Erro de rede. Para autenticação entre dispositivos, ambos os dispositivos precisam de acesso à internet e podem precisar de estar na mesma rede.",
    "PASSKEY_CREDENTIAL_NOT_FOUND" => "Autenticação falhou - credencial não reconhecida.",
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "Dicas para Autenticação Entre Dispositivos:",
    "PASSKEY_GUIDANCE_INTERNET" => "Assegura-te de que tanto o teu computador como o teu telemóvel têm acesso à internet",
    "PASSKEY_GUIDANCE_WIFI"  => "Estar na mesma rede WiFi pode ajudar (mas nem sempre é necessário)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE" => "Quando solicitado, seleciona \"Usar um telemóvel ou tablet\"",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY" => "Digitaliza o código QR rapidamente quando aparecer",
    "PASSKEY_GUIDANCE_TRY_DIRECT" => "Se falhar, tenta atualizar e usar o navegador do teu telemóvel diretamente",
    "PASSKEY_SHOW_TROUBLESHOOTING" => "Mostrar Dicas de Resolução de Problemas",
    "PASSKEY_HIDE_TROUBLESHOOTING" => "Ocultar Dicas de Resolução de Problemas",
    "PASSKEY_DIAGNOSTICS_RUNNING" => "A executar diagnósticos...",
    "PASSKEY_DIAGNOSTICS_COMPLETE" => "Diagnósticos concluídos. Verifica a consola para detalhes.",
    "PASSKEY_ISSUES_DETECTED" => "Problemas detetados:",
    "PASSKEY_ENVIRONMENT_SUITABLE" => "O ambiente parece adequado para chaves de acesso.",
    "PASSKEY_DIAGNOSTICS_FAILED" => "Diagnósticos falharam:",
    "PASSKEY_ADD_NOTE_NEW"  => "Adicionar Nota à Tua Nova Chave de Acesso",
    "PASSKEY_BASE64_ERROR"  => "Erro de descodificação Base64:",
    "PASSKEY_INVALID_JSON"  => "Dados JSON inválidos recebidos:",
    "PASSKEY_LOGIN_REQUIRED" => "Deves estar autenticado para realizar esta ação.",
    "PASSKEY_ACTION_MISSING" => "O parâmetro 'ação' necessário está ausente do pedido.",
    "PASSKEY_STORAGE_FAILED" => "Falha ao armazenar a chave de acesso. A operação não foi bem-sucedida.",
    "PASSKEY_LOGIN_FAILED"   => "Início de sessão com chave de acesso falhou. A autenticação não pôde ser verificada.",
    "PASSKEY_INVALID_METHOD" => "Método de pedido inválido:",
    "CSRF_ERROR"            => "Verificação do token CSRF falhou. Por favor, volta atrás e tenta submeter o formulário novamente.",
    "PASSKEY_NETWORK_PRIVATE" => "Possível problema: Parece que estás numa rede privada, o que por vezes pode interferir com a comunicação entre dispositivos.",
    "PASSKEY_NETWORK_PROXY"  => "Possível problema: Foi detetado um proxy ou VPN. Isto pode interferir com a comunicação entre dispositivos.",
    "PASSKEY_NETWORK_MOBILE" => "Nota: Parece que estás numa rede móvel. Assegura uma ligação estável para operações entre dispositivos.",
    "PASSKEY_NETWORK_CORPORATE" => "Possível problema: Um firewall corporativo pode estar ativo, o que pode afetar a autenticação entre dispositivos.",
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "Recomendação: Provavelmente estás a usar um desktop. Prepara-te para usar o teu telemóvel para digitalizar um código QR.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "Recomendação: Para melhores resultados, assegura-te de que o teu computador e dispositivo móvel estão na mesma rede Wi-Fi.",
    "PASSKEY_RECOMMENDATION_QR_QUICK" => "Recomendação: Prepara-te para digitalizar o código QR rapidamente, pois o pedido pode expirar.",
    "PASSKEY_RECOMMENDATION_INTERNET" => "Recomendação: Assegura-te de que tanto o teu computador como o teu dispositivo móvel têm uma ligação à internet estável.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "Recomendação: Para WebViews do Unity, assegura-te de que a página tem tempo suficiente para carregar e processar o pedido de chave de acesso.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "Recomendação: Os tempos de espera podem ser mais longos no Unity. Por favor, tem paciência.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "Recomendação: Como estás num dispositivo móvel, deves conseguir registar uma chave de acesso diretamente neste dispositivo.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Recomendação: No Android, podes gerir as tuas chaves de acesso no Gestor de Palavras-passe do Google.",
    "PASSKEY_VALIDATION_RP_IP" => "Aviso de configuração: O ID da Parte Confiável está definido como um endereço IP.",
    "PASSKEY_VALIDATION_RP_DOMAIN" => "Recomendação: Define o ID da Parte Confiável como o teu nome de domínio (por exemplo, oteusite.pt) para maior segurança e compatibilidade.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED" => "Erro de configuração: HTTPS é necessário para que as chaves de acesso funcionem num servidor ao vivo. O teu site parece estar em HTTP.",
    "PASSKEY_VALIDATION_NETWORK" => "Aviso de rede",
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "Recomendação: Se tiveres problemas, tenta uma rede diferente (por exemplo, muda de Wi-Fi corporativo para um hotspot móvel).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "Recomendação: Para ações entre dispositivos, assegura-te de que ambos os dispositivos têm uma ligação à internet fiável.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK" => "Recomendação: Se as ações entre dispositivos falharem, tenta visitar esta página diretamente no teu dispositivo móvel para completar a ação.",
    "PASSKEY_INFO_TITLE"    => "Sobre Chaves de Acesso",
    "PASSKEY_INFO_DESC"     => "As chaves de acesso são uma forma segura e sem palavra-passe de iniciar sessão usando as funcionalidades de segurança integradas do teu dispositivo, como impressão digital, reconhecimento facial ou PIN. São mais seguras do que as palavras-passe, proporcionam um início de sessão mais rápido, funcionam em vários dispositivos quando sincronizadas com gestores de palavras-passe e são resistentes a ataques de phishing. As chaves de acesso funcionam em smartphones modernos, tablets, computadores e podem ser armazenadas em gestores de palavras-passe como 1Password, Bitwarden, iCloud Keychain ou Gestor de Palavras-passe do Google.",
    "PASSKEY_BACK_TO_LOGIN" => "Voltar ao Início de Sessão",
));

//validation class
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
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
$lang = array_merge($lang, array(
	"JOIN_SUC"			=> "Bem vindo a ",
	"JOIN_THANKS"		=> "Obrigado por se registrar",
	"JOIN_HAVE"			=> "Ter no mínimo ",
	"JOIN_LOWER"	=> " letra minúscula",
	"JOIN_SYMBOL"		=> " símbolo",
	"JOIN_CAP"			=> " letra maiúscula",
	"JOIN_CAPS"			=> " letras maiúsculas",
	"JOIN_TWICE"		=> "Seja digitado corretamente duas vezes",
	"JOIN_CLOSED"		=> "Infelizmente, o registro está desativado no momento. Por favor, entre em contato com o Administrador do Site se tiver alguma dúvida ou preocupação.",
	"JOIN_TC"				=> "Termo de registro e condições",
	"JOIN_ACCEPTTC" => "Eu aceito os termos de registro e condições",
	"JOIN_CHANGED"	=> "Nossos termos foram modificados",
	"JOIN_ACCEPT" 	=> "Aceite os termos e condições e continue",
	"JOIN_SCORE" => "Pontuação:",
	"JOIN_INVALID_PW" => "A sua senha é inválida",

));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "Termidada com sucesso ",
));

//Messages
$lang = array_merge($lang, array(
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

// Two Factor Authentication Translations
$lang = array_merge($lang, array(
    "2FA"               => "Autenticação de Dois Fatores",
    "2FA_CONF"          => "Tens a certeza de que queres desativar a autenticação de dois fatores? A tua conta deixará de estar protegida.",
    "2FA_SCAN"          => "Digitaliza este código QR com a tua aplicação de autenticação ou insere a chave",
    "2FA_THEN"          => "Depois, insere aqui uma das tuas chaves de uso único",
    "2FA_FAIL"          => "Houve um problema ao verificar a autenticação de dois fatores. Verifica a tua ligação à internet ou contacta o suporte.",
    "2FA_CODE"          => "Código 2FA",
    "2FA_EXP"           => "1 impressão digital expirada",
    "2FA_EXPD"          => "Expirado",
    "2FA_EXPS"          => "Expira",
    "2FA_ACTIVE"        => "Sessões Ativas",
    "2FA_NOT_FN"        => "Nenhuma impressão digital encontrada",
    "2FA_FP"            => "Impressões Digitais",
    "2FA_NP"            => "Início de sessão falhou. O código de autenticação de dois fatores não estava presente. Por favor, tenta novamente.",
    "2FA_INV"           => "Início de sessão falhou. O código de autenticação de dois fatores era inválido. Por favor, tenta novamente.",
    "2FA_FATAL"         => "Erro fatal. Por favor, contacta o administrador do sistema. Não podemos gerar um código de autenticação de dois fatores neste momento.",
    "2FA_SECTION_TITLE" => "Autenticação de Dois Fatores (TOTP)",
    "2FA_SK_ALT"       => "Se não conseguires digitalizar o código QR, insere manualmente esta chave secreta na tua aplicação de autenticação.",
    "2FA_IS_ENABLED"    => "A autenticação de dois fatores está a proteger a tua conta.",
    "2FA_NOT_ENABLED_INFO" => "A autenticação de dois fatores não está ativada atualmente.",
    "2FA_NOT_ENABLED_EXPLAIN" => "A autenticação de dois fatores (TOTP) adiciona uma camada extra de segurança à tua conta, exigindo um código de uma aplicação de autenticação no teu telemóvel além da tua palavra-passe.",
    "2FA_SETUP_TITLE"  => "Configurar Autenticação de Dois Fatores",
    "2FA_SECRET_KEY_LABEL" => "Chave Secreta:",
    "2FA_SETUP_VERIFY_CODE_LABEL" => "Insere o Código de Verificação da Aplicação",
    "2FA_SUCCESS_ENABLED_TITLE" => "Autenticação de Dois Fatores Ativada! Guarda os Teus Códigos de Reserva",
    "2FA_SUCCESS_ENABLED_INFO" => "Abaixo estão os teus códigos de reserva. Guarda-os em segurança - cada um só pode ser usado uma vez.",
    "2FA_BACKUP_CODES_WARNING" => "Trata estes códigos como palavras-passe. Guarda-os em segurança.",
    "2FA_SUCCESS_BACKUP_REGENERATED" => "Novos códigos de reserva gerados. Guarda-os em segurança.",
    "2FA_BACKUP_CODE_LABEL" => "Código de Reserva",
    "2FA_REGEN_CODES_BTN" => "Regenerar Códigos de Reserva",
    "2FA_INVALIDATE_WARNING" => "Isto invalidará todos os códigos de reserva existentes. Tens a certeza?",
    "2FA_CODE_LABEL"    => "Código de Autenticação",
    "2FA_VERIFY_BTN"    => "Verificar e Iniciar Sessão",
    "2FA_VERIFY_TITLE"  => "Autenticação de Dois Fatores Necessária",
    "2FA_VERIFY_INFO"   => "Insere o código de 6 dígitos da tua aplicação de autenticação.",
    "2FA_ENABLE_BTN"    => "Ativar Autenticação de Dois Fatores",
    "2FA_DISABLE_BTN"   => "Desativar Autenticação de Dois Fatores",
    "2FA_VERIFY_ACTIVATE_BTN" => "Verificar e Ativar",
    "2FA_CANCEL_SETUP_BTN" => "Cancelar Configuração",
    "2FA_DONE_BTN"      => "Concluído",
    "REDIR_2FA_DIS"     => "A autenticação de dois fatores foi desativada.",
    "2FA_SUCCESS_BACKUP_ACK" => "Códigos de reserva confirmados.",
    "2FA_SUCCESS_SETUP_CANCELLED" => "Configuração cancelada.",
    "2FA_ERR_INVALID_BACKUP" => "Código de reserva inválido. Por favor, tenta novamente.",
    "2FA_ERR_DISABLE_FAILED" => "Falha ao desativar a autenticação de dois fatores.",
    "2FA_ERR_NO_SECRET" => "Não foi possível recuperar o segredo de autenticação. Por favor, tenta novamente.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL" => "Código de reserva verificado, mas falha ao invalidar. Por favor, contacta o suporte.",
    "2FA_ERR_NO_CODE_PROVIDED" => "Nenhum código de autenticação fornecido.",
    "RATE_LIMIT_LOGIN"   => "Demasiadas tentativas de início de sessão falhadas. Por favor, espera antes de tentar novamente.",
    "RATE_LIMIT_TOTP"    => "Demasiados códigos de autenticação incorretos. Por favor, espera antes de tentar novamente.",
    "RATE_LIMIT_PASSKEY" => "Demasiadas tentativas de autenticação com chave de acesso. Por favor, espera antes de tentar novamente.",
    "RATE_LIMIT_PASSKEY_STORE" => "Demasiadas tentativas de registo de chave de acesso. Por favor, espera antes de tentar novamente.",
    "RATE_LIMIT_PASSWORD_RESET" => "Demasiados pedidos de redefinição de palavra-passe. Por favor, espera antes de solicitar outra redefinição.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT" => "Demasiadas tentativas de redefinição de palavra-passe. Por favor, espera antes de tentar novamente.",
    "RATE_LIMIT_REGISTRATION" => "Demasiadas tentativas de registo. Por favor, espera antes de tentar novamente.",
    "RATE_LIMIT_EMAIL_VERIFICATION" => "Demasiados pedidos de verificação de e-mail. Por favor, espera antes de solicitar outra verificação.",
    "RATE_LIMIT_EMAIL_CHANGE" => "Demasiados pedidos de alteração de e-mail. Por favor, espera antes de tentar novamente.",
    "RATE_LIMIT_PASSWORD_CHANGE" => "Demasiadas tentativas de alteração de palavra-passe. Por favor, espera antes de tentar novamente.",
    "RATE_LIMIT_GENERIC" => "Demasiadas tentativas. Por favor, espera antes de tentar novamente.",
));

$lang = array_merge($lang, array(
	"REDIR_2FA"						=> "Desculpe.Autenticação em 2 Fatores não habilitada até o momento",
	"REDIR_2FA_EN"				=> "Autenticação em 2 Fatores habilitada",
	"REDIR_2FA_DIS"				=> "Autenticação em 2 Fatores desabilitada",
	"REDIR_2FA_VER"				=> "Autenticação em 2 Fatores verificada e habilitada",
	"REDIR_SOMETHING_WRONG" => "Algo aconteceu errado. Por favor tente novamente.",
	"REDIR_MSG_NOEX"			=> "Esta ação não te pertence ou não existe.",
	"REDIR_UN_ONCE"				=> "O nome de utilizador já foi modificado uma vez",
	"REDIR_EM_SUCC"				=> "Email Atualizado Com Sucesso",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "Entrar com:",
	"EML_FEATURE_DISABLED" => "Esta funcionalidade está desativada",
	"EML_PASSWORDLESS_SENT" => "Por favor, verifique o seu email para um link de login.",
	"EML_PASSWORDLESS_SUBJECT" => "Por favor, verifique o seu email para fazer login.",
	"EML_PASSWORDLESS_BODY" => "Por favor, verifique o seu endereço de email clicando no link abaixo. Será automaticamente autenticado.",

	"EML_CONF"			=> "Confirme o Email",
	"EML_VER"				=> "Verifique Seu Email",
	"EML_CHK"				=> "Solicitação de email recebida. Por favor, verifique seu e-mail para realizar a verificação. Certifique-se de verificar sua pasta Spam e Lixeira à medida que o link de verificação expira em",
	"EML_MAT"				=> "Seu email não coincidiu.",
	"EML_HELLO"			=> "Olá de ",
	"EML_HI" => "Olá ",
	"EML_AD_HAS" => "Um administrador redefiniu sua senha.",
	"EML_AC_HAS" => "Um administrador criou sua conta.",
	"EML_REQ" => "Será necessário definir sua senha usando o link acima.",
	"EML_EXP" => "Por favor, observe que os links de senha expiram em ",
	"EML_VER_EXP" => "Por favor, observe que os links de verificação expiram em ",
	"EML_CLICK" => "Clique aqui para fazer login.",
	"EML_REC" => "É recomendável alterar sua senha ao fazer login.",
	"EML_MSG" => "Você tem uma nova mensagem de",
	"EML_REPLY" => "Clique aqui para responder ou visualizar a conversa",
	"EML_WHY" => "Você está recebendo este email porque foi feito um pedido para redefinir sua senha. Se isso não foi você, você pode ignorar este email.",
	"EML_HOW" => "Se isso foi você, clique no link abaixo para continuar com o processo de redefinição de senha.",
	"EML_EML" => "Foi feito um pedido para alterar seu email dentro da sua conta de usuário.",
	"EML_VER_EML" => "Obrigado por se inscrever. Assim que você verificar seu endereço de email, estará pronto para fazer login! Por favor, clique no link abaixo para verificar seu endereço de email.",

));

//Verification
$lang = array_merge($lang, array(
	"VER_SUC"			=> "Seu Email foi verificado!",
	"VER_FAIL"		=> "Não foi possível confirmar sua conta. Por favor, tente novamente.",
	"VER_RESEND"	=> "Reenviamos o Email de verificação",
	"VER_AGAIN"		=> "Escreva seu endereço de e-mail e tente novamente",
	"VER_PAGE"		=> "<li>Verifique seu e-mail e clique no link que é enviado para você</li><li>Pronto</li>",
	"VER_RES_SUC" => " Seu link de confirmação foi enviado para seu endereço de e-mail.   Clique no link do e-mail para concluir a verificação. Certifique-se de verificar sua pasta de spam se o e-mail não estiver na sua caixa de entrada. </ P>   Os links de verificação só são válidos por",
	"VER_OOPS"		=> "Ops ... algo deu errado, talvez um link de reinicialização antigo em que você clicou. Clique abaixo para tentar novamente",
	"VER_RESET"		=> "Sua senha foi alterada!",
	"VER_INS"			=> "<li> Insira seu endereço de e-mail e clique em Redefinir </ li> <li> Verifique seu e-mail e clique no link que é enviado para você. </ li>
												<li> Siga as instruções da tela </ li>",
	"VER_SENT"		=> " Seu link de redefinição de senha foi enviado para o seu endereço de e-mail. 
			    							 Clique no link no email para redefinir sua senha. Certifique-se de verificar sua pasta de spam se o e-mail não estiver na sua caixa de entrada.     Os links de redefinição são válidos por",
	"VER_PLEASE"	=> "Por Favor Altere Sua Senha",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"				=> "Redefinir PIN",
	"SET_WHY"				=> "Poque eu não posso mudar isso?",
	"SET_PW_MATCH"	=> "Deve ser igual à nova senha",

	"SET_PIN_NEXT"	=> "Você pode definir um novo PIN na próxima vez que desejar confirmação",
	"SET_UPDATE"		=> "Atualize suas configurações de utilizador",
	"SET_NOCHANGE"	=> "O administrador desativou a alteração de nomes de utilizador.",
	"SET_ONECHANGE"	=> "O Administrador definiu alterações de nome de utilizador para ocorrer apenas uma vez e você já fez isso.",

	"SET_GRAVITAR"	=> "Deseja modificar sua imagem de perfil?  <br> Visite <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a>e configure uma conta com o mesmo e-mail que você usou neste site. Ele funciona em milhões de sites. É rápido e fácil!",

	"SET_NOTE1"			=> " Por favor repare  há uma solicitação pendente para atualizar seu e-mail para",

	"SET_NOTE2"			=> ".  Por favor, use o e-mail de verificação para concluir esta solicitação. 
		 Se você precisar de um novo e-mail de verificação, insira o e-mail acima e envie a solicitação novamente. ",

	"SET_PW_REQ" 		=> "necessário para alterar senha, e-mail ou redefinir o PIN",
	"SET_PW_REQI" 	=> "Necessário para alterar sua senha",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "Falha ao encerrar sessões ativas, erro: ",
	"ERR_EMAIL"				=> "E-mail não enviado devido a erro. Por favor entre em contato com o administrador do site.",
	"ERR_EM_DB"				=> "Esse e-mail não existe em nosso banco de dados",
	"ERR_TC"					=> "Por favor, leia e aceite os termos e condições",
	"ERR_CAP"					=> "Você falhou no Teste Captcha, Robôt!",
	"ERR_PW_SAME"			=> "Sua senha antiga não pode ser igual à sua nova senha",
	"ERR_PW_FAIL"			=> "A verificação da senha atual falhou. Atualização falhou. Por favor, tente novamente.",
	"ERR_GOOG"				=> "ATENÇÃO: Se você se inscreveu originalmente com a sua conta do Google / Facebook, precisará usar o link de senha esquecida para alterar sua senha ... a menos que seja realmente bom em adivinhar.",
	"ERR_EM_VER"			=> "A verificação de e-mail não está ativada. Por favor contacte o administrador do sistema.",
	"ERR_EMAIL_STR"		=> "Algo está estranho. Por favor, verifique novamente o seu email. Lamentamos o inconveniente",
));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "Nós voltaremos em breve!",
	"MAINT_MSG"			=> "Desculpe pelo inconveniente, mas estamos a efectuar uma manutenção de momento. <br> Estaremos de volta on-line em breve!",
	"MAINT_BAN"			=> "Desculpa. Você foi banido. Se você acha que isso é um erro, entre em contato com o administrador.",
	"MAINT_TOK"			=> "Houve um erro com o seu formulário. Por favor volte e tente novamente. Observe que enviar o formulário atualizando a página causará um erro. Se isso continuar a acontecer, entre em contato com o administrador.",
	"MAINT_OPEN"		=> "Uma estrutura de gestão de utilizadors PHP de código aberto.",
	"MAINT_PLEASE"	=> "Você instalou com sucesso o UserSpice! <br> Para ver nossa documentação inicial, visite"
));


//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
