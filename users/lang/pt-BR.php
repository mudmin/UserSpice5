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
    "PASS_ENTER_CODE"    => "Digite o código enviado para seu e-mail",
    "PASS_EMAIL_ONLY"    => "Por favor, verifique seu e-mail para obter o link de login.",
    "PASS_CODE_ONLY"     => "Por favor, digite o código enviado para seu e-mail.",
    "PASS_BOTH"          => "Por favor, verifique seu e-mail para obter o link de login ou digite o código enviado para seu e-mail.",
    "PASS_VER_BUTTON"    => "Verificar código",
    "PASS_EMAIL_ONLY_MSG" => "Por favor, verifique seu endereço de e-mail clicando no link abaixo.",
    "PASS_CODE_ONLY_MSG"  => "Por favor, digite o código abaixo para fazer login.",
    "PASS_BOTH_MSG"       => "Por favor, verifique seu endereço de e-mail clicando no link abaixo ou digite o código abaixo para fazer login.",
    "PASS_YOUR_CODE"      => "Seu código de verificação é: ",
    "PASS_CONFIRM_LOGIN"  => "Confirmar Login",
    "PASS_CONFIRM_CLICK"  => "Clique para Completar o Login",
    "PASS_GENERIC_ERROR"  => "Algo deu errado.",
));

//Database Menus
$lang = array_merge($lang, array(
	"MENU_HOME"			=> "Início",
	"MENU_HELP"			=> "Ajuda",
	"MENU_ACCOUNT"	=> "Conta",
	"MENU_DASH"			=> "Painel Administrativo",
	"MENU_USER_MGR"	=> "Gerenciar usuários",
	"MENU_PAGE_MGR"	=> "Gerenciar páginas",
	"MENU_PERM_MGR"	=> "Gerenciar permissões",
	"MENU_MSGS_MGR"	=> "Gerenciar mensagens",
	"MENU_LOGS_MGR"	=> "Logs do sistema",
	"MENU_LOGOUT"		=> "Sair",
));

// Signup
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"					=> "Registrar",
	"SIGNUP_BUTTONTEXT"		=> "Registre me",
	"SIGNUP_AUDITTEXT"		=> "Registrado",
));

// Signin
$lang = array_merge($lang, array(
	"SIGNIN_FAIL"				=> "** FALHA NO LOGIN **",
	"SIGNIN_PLEASE_CHK" => "Por favor verifique seu usuário e senha e tente novamente",
	"SIGNIN_UORE"				=> "Username ou Email",
	"SIGNIN_PASS"				=> "Senha",
	"SIGNIN_TITLE"			=> "Por favor se logue",
	"SIGNIN_TEXT"				=> "Logar",
	"SIGNOUT_TEXT"			=> "Sair",
	"SIGNIN_BUTTONTEXT"	=> "Logar",
	"SIGNIN_REMEMBER"		=> "Lembre-se de mim",
	"SIGNIN_AUDITTEXT"	=> "Logado",
	"SIGNIN_FORGOTPASS"	=> "Perdeu a senha",
	"SIGNOUT_AUDITTEXT"	=> "Deslogado",
));

// Account Page
$lang = array_merge($lang, array(
	"ACCT_EDIT"					=> "Editar informações da conta",
	"ACCT_2FA"					=> "Gerenciar 2 Factor Authentication",
	"ACCT_SESS"					=> "Gerenciar Sessões",
	"ACCT_HOME"					=> "Minha conta",
	"ACCT_SINCE"				=> "Membro desde",
	"ACCT_LOGINS"				=> "Número de Logins",
	"ACCT_SESSIONS"			=> "Número de sessões ativas",
	"ACCT_MNG_SES"			=> "Click no botão Gerenciar Sessões na barra lateral esquerda para mais informações.",
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
	"GEN_MANAGE"			=> "Gerenciar",
	"GEN_VERIFY"			=> "Verificar",
	"GEN_SESSION"			=> "Sessão",
	"GEN_SESSIONS"		=> "Sessões",
	"GEN_EMAIL"				=> "Email",
	"GEN_FNAME"				=> "Nome",
	"GEN_LNAME"				=> "Sobrenome",
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

$lang = array_merge($lang, array(
    "GEN_PASSKEY"           => "Chave de acesso",
    "GEN_ACTIONS"           => "Ações",
    "GEN_BACK_TO_ACCT"      => "Voltar para a conta",
    "GEN_DB_ERROR"          => "Ocorreu um erro no banco de dados. Tente novamente.",
    "GEN_IMPORTANT"         => "Importante",
    "GEN_NO_PERMISSIONS"    => "Você não tem permissão para acessar esta página.",
    "GEN_NO_PERMISSIONS_MSG" => "Você não tem permissão para acessar esta página. Se acredita que isso é um erro, entre em contato com o administrador do site.",
    "PASSKEYS_MANAGE_TITLE"                 => "Gerenciar chaves de acesso",
    "PASSKEYS_LOGIN_TITLE"                  => "Login com chave de acesso",
    "PASSKEY_DELETE_SUCCESS"                => "Chave de acesso excluída com sucesso.",
    "PASSKEY_DELETE_FAIL_DB"                => "Falha ao excluir a chave de acesso do banco de dados.",
    "PASSKEY_DELETE_NOT_FOUND"              => "Chave de acesso não encontrada ou você não tem permissão para excluí-la.",
    "PASSKEY_NOTE_UPDATE_SUCCESS"           => "Nota da chave de acesso atualizada com sucesso.",
    "PASSKEY_NOTE_UPDATE_FAIL"              => "Falha ao atualizar a nota da chave de acesso.",
    "PASSKEY_REGISTER_NEW"                  => "Registrar nova chave de acesso",
    "PASSKEY_ERR_LIMIT_REACHED"             => "Você atingiu o máximo de 10 chaves de acesso.",
    "PASSKEY_NOTE_TH"                       => "Nota da chave",
    "PASSKEY_TIMES_USED_TH"                 => "Vezes usada",
    "PASSKEY_LAST_USED_TH"                  => "Último uso",
    "PASSKEY_LAST_IP_TH"                    => "Último IP",
    "PASSKEY_EDIT_NOTE_BTN"                 => "Editar nota",
    "PASSKEY_CONFIRM_DELETE_JS"             => "Tem certeza de que deseja excluir esta chave de acesso?",
    "PASSKEY_EDIT_MODAL_TITLE"              => "Editar nota da chave de acesso",
    "PASSKEY_EDIT_MODAL_LABEL"              => "Nota da chave de acesso",
    "PASSKEY_SAVE_CHANGES_BTN"              => "Salvar alterações",
    "PASSKEY_NONE_REGISTERED"               => "Você ainda não tem chaves de acesso registradas.",
    "PASSKEY_MUST_REGISTER_FIRST"           => "Você deve primeiro registrar uma chave de acesso de uma conta autenticada antes de usar este recurso.",
    "PASSKEY_STORING"                       => "Salvando chave de acesso...",
    "PASSKEY_STORED_SUCCESS"                => "Chave de acesso salva com sucesso!",
    "PASSKEY_INVALID_ACTION"                => "Ação inválida: ",
    "PASSKEY_NO_ACTION_SPECIFIED"           => "Nenhuma ação especificada",
    "PASSKEY_DELETE_NOT_FOUND"              => "Chave de acesso não encontrada ou permissão negada.",
    "PASSKEY_ERR_NETWORK_SUGGESTION"        => "Problema de rede detectado. Tente uma rede diferente ou atualize a página.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION"   => "Autenticação entre dispositivos detectada. Certifique-se de que ambos os dispositivos tenham acesso à internet.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE"  => "Tente abrir esta página diretamente no seu telefone.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"         => "Não foi possível gerar diagnósticos: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"       => "Dados de credencial necessários para armazenamento estão faltando.",
    "PASSKEY_MISSING_AUTH_DATA"             => "Dados de autenticação necessários estão faltando.",
    "PASSKEY_LOG_NO_MESSAGE"                => "Nenhuma mensagem",
    "PASSKEY_USER_NOT_FOUND"                => "Usuário não encontrado após validação da chave de acesso.",
    "PASSKEY_FATAL_ERROR"                   => "Erro fatal: ",
    "PASSKEY_LOGIN_SUCCESS"                 => "Login bem-sucedido.",
    "PASSKEY_CROSS_DEVICE_PREP"             => "Preparando registro entre dispositivos. Você pode precisar usar seu telefone ou tablet.",
    "PASSKEY_DEVICE_REGISTRATION"           => "Usando registro de chave de acesso do dispositivo...",
    "PASSKEY_STARTING_REGISTRATION"         => "Iniciando registro da chave de acesso...",
    "PASSKEY_REQUEST_OPTIONS"               => "Solicitando opções de registro do servidor...",
    "PASSKEY_FOLLOW_PROMPTS"                => "Siga as instruções para criar sua chave de acesso. Você pode precisar usar outro dispositivo.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"         => "Siga as instruções para criar sua chave de acesso...",
    "PASSKEY_CREATION_FAILED"               => "Criação da chave de acesso falhou - nenhuma credencial retornada.",
    "PASSKEY_STORING_SERVER"                => "Salvando sua chave de acesso...",
    "PASSKEY_CREATED_SUCCESS"               => "Chave de acesso criada com sucesso!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP"        => "Preparando autenticação entre dispositivos. Certifique-se de que seu telefone e computador tenham acesso à internet.",
    "PASSKEY_DEVICE_AUTH"                   => "Usando autenticação de chave de acesso do dispositivo...",
    "PASSKEY_STARTING_AUTH"                 => "Iniciando autenticação da chave de acesso...",
    "PASSKEY_QR_CODE_INSTRUCTION"           => "Escaneie o código QR com seu telefone quando aparecer. Certifique-se de que ambos os dispositivos tenham acesso à internet.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"      => "Escolha \"Usar um telefone ou tablet\" quando solicitado, depois escaneie o código QR.",
    "PASSKEY_AUTHENTICATING"                => "Autenticando com sua chave de acesso...",
    "PASSKEY_SUCCESS_REDIRECTING"           => "Autenticação bem-sucedida! Redirecionando...",
    "PASSKEY_TIMEOUT_CROSS_DEVICE"          => "Registro expirado. Para dispositivos cruzados: 1) Tente novamente, 2) Certifique-se de que os dispositivos tenham internet, 3) Considere registrar diretamente no seu telefone.",
    "PASSKEY_TIMEOUT_SIMPLE"                => "Registro expirado. Tente novamente.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"     => "Autenticação entre dispositivos expirada. Solução de problemas: 1) Ambos os dispositivos precisam de internet, 2) Tente escanear o código QR mais rapidamente, 3) Considere usar o mesmo dispositivo, 4) Algumas redes bloqueiam autenticação entre dispositivos.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"           => "Autenticação expirada. Tente novamente.",
    "PASSKEY_NO_CREDENTIAL"                 => "Nenhuma credencial recebida. Tentando novamente...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"     => "Autenticação falhou - nenhuma credencial retornada.",
    "PASSKEY_ATTEMPT_RETRY"                 => "falhou. Tentando novamente... (%d tentativas restantes)",
    "PASSKEY_CROSS_DEVICE_FAILED"           => "Registro entre dispositivos falhou. Tente: 1) Certifique-se de que ambos os dispositivos tenham internet, 2) Considere registrar diretamente no seu telefone, 3) Algumas redes corporativas bloqueiam este recurso.",
    "PASSKEY_REGISTRATION_CANCELLED"        => "Registro foi cancelado ou o dispositivo não suporta chaves de acesso.",
    "PASSKEY_NOT_SUPPORTED"                 => "Chaves de acesso não são suportadas nesta combinação de dispositivo/navegador.",
    "PASSKEY_SECURITY_ERROR"                => "Erro de segurança - isso geralmente indica uma incompatibilidade de domínio/origem.",
    "PASSKEY_ALREADY_EXISTS"                => "Uma chave de acesso já existe para esta conta neste dispositivo. Tente usar um dispositivo diferente ou exclua as chaves existentes primeiro.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"      => "Autenticação entre dispositivos falhou. Tente: 1) Certifique-se de que ambos os dispositivos tenham internet estável, 2) Use a mesma rede WiFi se possível, 3) Tente autenticar diretamente no seu telefone, 4) Algumas redes corporativas bloqueiam este recurso.",
    "PASSKEY_AUTH_CANCELLED"                => "Autenticação foi cancelada ou nenhuma chave de acesso foi selecionada.",
    "PASSKEY_NETWORK_ERROR"                 => "Erro de rede. Para autenticação entre dispositivos, ambos os dispositivos precisam de acesso à internet e podem precisar estar na mesma rede.",
    "PASSKEY_CREDENTIAL_NOT_FOUND"          => "Autenticação falhou - credencial não reconhecida.",
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE"   => "Dicas para autenticação entre dispositivos:",
    "PASSKEY_GUIDANCE_INTERNET"             => "Certifique-se de que tanto seu computador quanto seu telefone tenham acesso à internet",
    "PASSKEY_GUIDANCE_WIFI"                 => "Estar na mesma rede WiFi pode ajudar (mas nem sempre é necessário)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"        => "Quando solicitado, selecione \"Usar um telefone ou tablet\"",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"         => "Escaneie o código QR rapidamente quando aparecer",
    "PASSKEY_GUIDANCE_TRY_DIRECT"           => "Se falhar, tente atualizar e usar o navegador do seu telefone diretamente",
    "PASSKEY_SHOW_TROUBLESHOOTING"          => "Mostrar dicas de solução de problemas",
    "PASSKEY_HIDE_TROUBLESHOOTING"          => "Ocultar dicas de solução de problemas",
    "PASSKEY_DIAGNOSTICS_RUNNING"           => "Executando diagnósticos...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"          => "Diagnósticos concluídos. Verifique o console para detalhes.",
    "PASSKEY_ISSUES_DETECTED"               => "Problemas detectados:",
    "PASSKEY_ENVIRONMENT_SUITABLE"          => "O ambiente parece adequado para chaves de acesso.",
    "PASSKEY_DIAGNOSTICS_FAILED"            => "Diagnósticos falharam:",
    "PASSKEY_ADD_NOTE_NEW"                  => "Adicionar nota à sua nova chave de acesso",
    "PASSKEY_BASE64_ERROR"                  => "Erro de decodificação Base64:",
    "PASSKEY_INVALID_JSON"                  => "Dados JSON inválidos recebidos:",
    "PASSKEY_NO_CHALLENGE_SESSION"          => "Nenhum desafio de registro de chave de acesso encontrado na sessão. Tente registrar novamente.",
    "PASSKEY_USER_MISMATCH"                 => "ID do usuário não corresponde. Tente registrar novamente.",
    "PASSKEY_CHALLENGE_USER_MISMATCH"       => "ID do usuário nas opções de desafio não corresponde ao usuário atual. Tente registrar novamente.",
    "PASSKEY_REGISTRATION_FAILED_ERROR"     => "Registro da chave de acesso falhou. Certifique-se de que seu dispositivo e navegador suportem WebAuthn e tente novamente. Erro:",
    "PASSKEY_NO_AUTH_CHALLENGE_SESSION"     => "Nenhum desafio de asserção de chave de acesso encontrado na sessão. Tente fazer login novamente.",
    "PASSKEY_CREDENTIAL_NOT_IN_DB"          => "Credencial da chave de acesso não encontrada no banco de dados.",
    "PASSKEY_CREDENTIAL_WRONG_USER"         => "Credencial da chave de acesso não pertence ao usuário esperado.",
    "PASSKEY_VALIDATION_FAILED_ERROR"       => "Validação da chave de acesso falhou. Tente novamente ou entre em contato com o suporte se o problema persistir. Erro:",
    "PASSKEY_USER_NOT_FOUND_REGISTRATION"   => "Usuário não encontrado para registro.",
    "PASSKEY_LOGIN_REQUIRED"        => "Você deve estar logado para realizar esta ação.",
    "PASSKEY_ACTION_MISSING"        => "O parâmetro 'action' obrigatório estava ausente da solicitação.",
    "PASSKEY_STORAGE_FAILED"        => "Falha ao armazenar a chave de acesso. A operação não foi bem-sucedida.",
    "PASSKEY_LOGIN_FAILED"          => "Login com chave de acesso falhou. A autenticação não pôde ser verificada.",
    "PASSKEY_INVALID_METHOD"        => "Método de solicitação inválido:",
    "CSRF_ERROR"                    => "Verificação do token CSRF falhou. Volte e tente enviar o formulário novamente.",
    "PASSKEY_NETWORK_PRIVATE"       => "Problema potencial: Você parece estar em uma rede privada, que às vezes pode interferir na comunicação entre dispositivos.",
    "PASSKEY_NETWORK_PROXY"         => "Problema potencial: Um proxy ou VPN foi detectado. Isso pode interferir na comunicação entre dispositivos.",
    "PASSKEY_NETWORK_MOBILE"        => "Nota: Você parece estar em uma rede móvel. Garanta uma conexão estável para operações entre dispositivos.",
    "PASSKEY_NETWORK_CORPORATE"     => "Problema potencial: Um firewall corporativo pode estar ativo, o que poderia afetar a autenticação entre dispositivos.",
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE"   => "Recomendação: Você provavelmente está usando um desktop. Prepare-se para usar seu telefone para escanear um código QR.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK"   => "Recomendação: Para melhores resultados, certifique-se de que seu computador e dispositivo móvel estejam na mesma rede Wi-Fi.",
    "PASSKEY_RECOMMENDATION_QR_QUICK"       => "Recomendação: Esteja preparado para escanear o código QR rapidamente, pois a solicitação pode expirar.",
    "PASSKEY_RECOMMENDATION_INTERNET"       => "Recomendação: Certifique-se de que tanto seu computador quanto seu dispositivo móvel tenham uma conexão de internet estável.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW"  => "Recomendação: Para Unity WebViews, certifique-se de que a página tenha tempo suficiente para carregar e processar a solicitação da chave de acesso.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT"  => "Recomendação: Os timeouts podem ser mais longos no Unity. Seja paciente.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL"   => "Recomendação: Como você está no celular, deve conseguir registrar uma chave de acesso diretamente neste dispositivo.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Recomendação: No Android, você pode gerenciar suas chaves de acesso no Gerenciador de Senhas do Google.",
    "PASSKEY_VALIDATION_RP_IP"                  => "Aviso de configuração: O ID da Parte Confiável está definido como um endereço IP.",
    "PASSKEY_VALIDATION_RP_DOMAIN"              => "Recomendação: Defina o ID da Parte Confiável para seu nome de domínio (ex: seusite.com) para melhor segurança e compatibilidade.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"         => "Erro de configuração: HTTPS é necessário para que as chaves de acesso funcionem em um servidor ativo. Seu site parece estar em HTTP.",
    "PASSKEY_VALIDATION_NETWORK"                => "Aviso de rede",
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK"  => "Recomendação: Se você tiver problemas, tente uma rede diferente (ex: mude do Wi-Fi corporativo para um hotspot móvel).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET"  => "Recomendação: Para ações entre dispositivos, certifique-se de que ambos os dispositivos tenham uma conexão de internet confiável.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"        => "Recomendação: Se as ações entre dispositivos falharem, tente visitar esta página diretamente no seu dispositivo móvel para completar a ação.",
    "PASSKEY_INFO_TITLE"           => "Sobre chaves de acesso",
    "PASSKEY_INFO_DESC"            => "Chaves de acesso são uma forma segura e sem senha de fazer login usando os recursos de segurança integrados do seu dispositivo, como impressão digital, reconhecimento facial ou PIN. Elas são mais seguras que senhas, proporcionam login mais rápido, funcionam entre dispositivos quando sincronizadas com gerenciadores de senhas, e são resistentes a ataques de phishing. Chaves de acesso funcionam em smartphones modernos, tablets, computadores, e podem ser armazenadas em gerenciadores de senhas como 1Password, Bitwarden, iCloud Keychain ou Google Password Manager.",
    "PASSKEY_BACK_TO_LOGIN"                      => "Voltar ao login",
));


//validation class
$lang = array_merge($lang, array(
	"VAL_SAME"				=> "deve ser igual",
	"VAL_EXISTS"			=> "já existe. Por favor escolha outro",
	"VAL_DB"					=> "Erro no Banco de dados",
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
	"JOIN_HAVE"			=> "Ter ao mínimo ",
	"JOIN_LOWER"	=> " letra minúscula",
	"JOIN_SYMBOL"		=> " símbolo",
	"JOIN_CAP"			=> " letra maiúscula",
	"JOIN_TWICE"		=> "Seja digitado corretamente duas vezes",
	"JOIN_CLOSED"		=> "Infelizmente, o registro está desativado no momento. Por favor, entre em contato com o Administrador do Site se tiver alguma dúvida ou preocupação.",
	"JOIN_TC"				=> "Termo de registro e condições",
	"JOIN_ACCEPTTC" => "Eu aceito os termos de registro e condições",
	"JOIN_CHANGED"	=> "Nossos termos foram modificados",
	"JOIN_ACCEPT" 	=> "Aceite os termos e condições e continue",
	"JOIN_SCORE" => "Pontuação:",
"JOIN_INVALID_PW" => "Sua senha é inválida",

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
	"MSG_SELECT"		=> "Selecione um usuário",
	"MSG_UNKN"			=> "Destinatário Desconhecido",
	"MSG_NOTIF"			=> "Notificações por email",
	"MSG_BLANK"			=> "Mensagem não pode estar vazia",
	"MSG_MODAL"			=> "Clique aqui ou pressione Alt + R para focar nessa caixa OU pressione Shift + R para abrir o painel de resposta expandido!",
	"MSG_ARCHIVE_SUCCESSFUL"        => "Você arquivou com sucesso %m1% tópicos",
	"MSG_UNARCHIVE_SUCCESSFUL"      => "Você desarquivou com sucesso %m1% tópicos",
	"MSG_DELETE_SUCCESSFUL"         => "Você apagou com sucesso %m1% tópicos",
	"USER_MESSAGE_EXEMPT"         			=> "Usuário é %m1% isento de mensagens.",
	"MSG_MK_READ"		=> "Lida",
	"MSG_MK_UNREAD"	=> "Não lida",
	"MSG_ARC_THR"		=> "Arquivar Tópicos Selecionados",
	"MSG_UN_THR"		=> "Desarquivar Tópicos Selecionados",
	"MSG_DEL_THR"		=> "Apagar Tópicos Selecionados",
	"MSG_SEND"			=> "Enviar Mensagem",
));

//Two Factor Authentication

$lang = array_merge($lang, array(
    "2FA"               => "Autenticação de dois fatores",
    "2FA_CONF"  => "Tem certeza de que deseja desabilitar a 2FA? Sua conta não estará mais protegida.",
    "2FA_SCAN"  => "Escaneie este código QR com seu aplicativo autenticador ou digite a chave",
    "2FA_THEN"  => "Em seguida, digite uma de suas chaves únicas aqui",
    "2FA_FAIL"  => "Houve um problema ao verificar a 2FA. Verifique a internet ou entre em contato com o suporte.",
    "2FA_CODE"  => "Código 2FA",
    "2FA_EXP"       => "Expirou 1 impressão digital",
    "2FA_EXPD"  => "Expirado",
    "2FA_EXPS"  => "Expira",
    "2FA_ACTIVE" => "Sessões ativas",
    "2FA_NOT_FN" => "Nenhuma impressão digital encontrada",
    "2FA_FP"        => "Impressões digitais",
    "2FA_NP"        => "Login falhou - Código de autenticação de dois fatores não estava presente. Tente novamente.",
    "2FA_INV"       => "Login falhou - Código de autenticação de dois fatores era inválido. Tente novamente.",
    "2FA_FATAL" => "Erro fatal - Entre em contato com o administrador do sistema. Não podemos gerar um código de autenticação de dois fatores no momento.",
    "2FA_SECTION_TITLE"                    => "Autenticação de dois fatores (TOTP)",
    "2FA_SK_ALT"                          => "Se não conseguir escanear o código QR, digite manualmente esta chave secreta no seu aplicativo autenticador.",
    "2FA_IS_ENABLED"                       => "A autenticação de dois fatores está protegendo sua conta.",
    "2FA_NOT_ENABLED_INFO"                 => "A autenticação de dois fatores não está habilitada no momento.",
    "2FA_NOT_ENABLED_EXPLAIN"              => "A autenticação de dois fatores (TOTP) adiciona uma camada extra de segurança à sua conta, exigindo um código de um aplicativo autenticador no seu telefone além de sua senha.",
    "2FA_SETUP_TITLE"                      => "Configurar autenticação de dois fatores",
    "2FA_SECRET_KEY_LABEL"                 => "Chave secreta:",
    "2FA_SETUP_VERIFY_CODE_LABEL"          => "Digite o código de verificação do aplicativo",
    "2FA_SUCCESS_ENABLED_TITLE"            => "Autenticação de dois fatores habilitada! Salve seus códigos de backup",
    "2FA_SUCCESS_ENABLED_INFO"             => "Abaixo estão seus códigos de backup. Armazene-os com segurança - cada um pode ser usado apenas uma vez.",
    "2FA_BACKUP_CODES_WARNING"             => "Trate esses códigos como senhas. Armazene-os com segurança.",
    "2FA_SUCCESS_BACKUP_REGENERATED"       => "Novos códigos de backup gerados. Salve-os com segurança.",
    "2FA_BACKUP_CODE_LABEL"                => "Código de backup",
    "2FA_REGEN_CODES_BTN"                  => "Regenerar códigos de backup",
    "2FA_INVALIDATE_WARNING"            => "Isso invalidará todos os códigos de backup existentes. Tem certeza?",
    "2FA_CODE_LABEL"                       => "Código de autenticação",
    "2FA_VERIFY_BTN"                       => "Verificar e entrar",
    "2FA_VERIFY_TITLE"                     => "Autenticação de dois fatores necessária",
    "2FA_VERIFY_INFO"                      => "Digite o código de 6 dígitos do seu aplicativo autenticador.",
    "2FA_ENABLE_BTN"                       => "Habilitar autenticação de dois fatores",
    "2FA_DISABLE_BTN"                       => "Desabilitar autenticação de dois fatores",
    "2FA_VERIFY_ACTIVATE_BTN"              => "Verificar e ativar",
    "2FA_CANCEL_SETUP_BTN"                 => "Cancelar configuração",
    "2FA_DONE_BTN"                         => "Concluído",
    "REDIR_2FA_DIS"                 => "A autenticação de dois fatores foi desabilitada.",
    "2FA_SUCCESS_BACKUP_ACK"               => "Códigos de backup confirmados.",
    "2FA_SUCCESS_SETUP_CANCELLED"          => "Configuração cancelada.",
    "2FA_ERR_INVALID_BACKUP"               => "Código de backup inválido. Tente novamente.",
    "2FA_ERR_DISABLE_FAILED"               => "Falha ao desabilitar a autenticação de dois fatores.",
    "2FA_ERR_NO_SECRET"                    => "Não foi possível recuperar o segredo de autenticação. Tente novamente.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"       => "Código de backup verificado, mas falha ao invalidar. Entre em contato com o suporte.",
    "2FA_ERR_NO_CODE_PROVIDED"             => "Nenhum código de autenticação fornecido.",
    "RATE_LIMIT_LOGIN"              => "Muitas tentativas de login falharam. Aguarde antes de tentar novamente.",
    "RATE_LIMIT_TOTP"               => "Muitos códigos de autenticação incorretos. Aguarde antes de tentar novamente.",
    "RATE_LIMIT_PASSKEY"            => "Muitas tentativas de autenticação de chave de acesso. Aguarde antes de tentar novamente.",
    "RATE_LIMIT_PASSKEY_STORE"      => "Muitas tentativas de registro de chave de acesso. Aguarde antes de tentar novamente.",
    "RATE_LIMIT_PASSWORD_RESET"     => "Muitas solicitações de redefinição de senha. Aguarde antes de solicitar outra redefinição.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT" => "Muitas tentativas de redefinição de senha. Aguarde antes de tentar novamente.",
    "RATE_LIMIT_REGISTRATION"       => "Muitas tentativas de registro. Aguarde antes de tentar novamente.",
    "RATE_LIMIT_EMAIL_VERIFICATION" => "Muitas solicitações de verificação de email. Aguarde antes de solicitar outra verificação.",
    "RATE_LIMIT_EMAIL_CHANGE"       => "Muitas solicitações de alteração de email. Aguarde antes de tentar novamente.",
    "RATE_LIMIT_PASSWORD_CHANGE"    => "Muitas tentativas de alteração de senha. Aguarde antes de tentar novamente.",
    "RATE_LIMIT_GENERIC"            => "Muitas tentativas. Aguarde antes de tentar novamente.",
));


$lang = array_merge($lang, array(
	"REDIR_2FA"						=> "Desculpe.Autenticação em 2 Fatores não habilitada até o momento",
	"REDIR_2FA_EN"				=> "Autenticação em 2 Fatores habilitada",
	"REDIR_2FA_DIS"				=> "Autenticação em 2 Fatores desabilitada",
	"REDIR_2FA_VER"				=> "Autenticação em 2 Fatores verificada e habilitada",
	"REDIR_SOMETHING_WRONG" => "Algo aconteceu errado. Por favor tente novamente.",
	"REDIR_MSG_NOEX"			=> "Esta ação não te pertence ou não existe.",
	"REDIR_UN_ONCE"				=> "O nome de usuário já foi modificado uma vez",
	"REDIR_EM_SUCC"				=> "Email Atualizado Com Sucesso",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "Entrar com:",
	"EML_FEATURE_DISABLED" => "Esta função está desabilitada",
	"EML_PASSWORDLESS_SENT" => "Por favor, verifique seu e-mail para um link de login.",
	"EML_PASSWORDLESS_SUBJECT" => "Por favor, verifique seu e-mail para fazer login.",
	"EML_PASSWORDLESS_BODY" => "Por favor, verifique seu endereço de e-mail clicando no link abaixo. Você será conectado automaticamente.",

	"EML_CONF"			=> "Confirme o Email",
	"EML_VER"				=> "Verifique Seu Email",
	"EML_CHK"				=> "Solicitação de email recebida. Por favor, verifique seu e-mail para realizar a verificação. Certifique-se de verificar sua pasta Spam e Lixeira à medida que o link de verificação expira em",
	"EML_MAT"				=> "Seu email não coincidiu.",
	"EML_HELLO"			=> "Olá de ",
	"EML_HI"				=> "Olá ",
	"EML_AD_HAS"		=> "Um administrador redefiniu sua senha.",
	"EML_AC_HAS"		=> "Um administrador criou sua conta.",
	"EML_REQ"				=> "Você será solicitado a definir sua senha usando o link acima.",
	"EML_EXP"				=> "Por favor, note que os links de senha expiram em ",
	"EML_VER_EXP"		=> "Observe que os links de verificação expiram em ",
	"EML_CLICK"			=> "Clique aqui para logar.",
	"EML_REC"				=> "Recomenda-se alterar sua senha ao fazer login.",
	"EML_MSG"				=> "Você tem uma nova mensagem de",
	"EML_REPLY"			=> "Clique aqui para responder ou ver o tópico",
	"EML_WHY"				=> "Você está recebendo este e-mail porque uma solicitação foi feita para redefinir sua senha. Se não foi você, ignore este e-mail.",
	"EML_HOW"				=> "Se foi você, clique no link abaixo para continuar com o processo de redefinição de senha.",
	"EML_EML"				=> "Um pedido para alterar o seu email foi feito a partir da sua conta de usuário.",
	"EML_VER_EML"		=> "Obrigado por inscrever-se. Depois de verificar seu endereço de e-mail, você estará pronto para fazer o login! Por favor, clique no link abaixo para verificar seu endereço de e-mail.",
));

//Verification
$lang = array_merge($lang, array(
	"VER_SUC"			=> "Seu Email foi verificado!",
	"VER_FAIL"		=> "Não foi possível confirmar sua conta. Por favor, tente novamente.",
	"VER_RESEND"	=> "Reenviar o Email de verificação",
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
	"SET_UPDATE"		=> "Atualize suas configurações de usuário",
	"SET_NOCHANGE"	=> "O administrador desativou a alteração de nomes de usuário.",
	"SET_ONECHANGE"	=> "O Administrador definiu alterações de nome de usuário para ocorrer apenas uma vez e você já fez isso.",

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
	"ERR_CAP"					=> "Você falhou no Teste Captcha, Robô!",
	"ERR_PW_SAME"			=> "Sua senha antiga não pode ser igual à sua nova senha",
	"ERR_PW_FAIL"			=> "A verificação da senha atual falhou. Atualização falhou. Por favor, tente novamente.",
	"ERR_GOOG"				=> "ATENÇÃO: Se você se inscreveu originalmente com sua conta do Google / Facebook, precisará usar o link de senha esquecida para alterar sua senha ... a menos que seja realmente bom em adivinhar.",
	"ERR_EM_VER"			=> "A verificação de e-mail não está ativada. Por favor contacte o administrador do sistema.",
	"ERR_EMAIL_STR"		=> "Algo está estranho. Por favor, verifique novamente o seu email. Lamentamos o inconveniente",
));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "Nós voltaremos em breve!",
	"MAINT_MSG"			=> "Desculpe pelo inconveniente, mas estamos realizando uma manutenção no momento. <br> Estaremos de volta on-line em breve!",
	"MAINT_BAN"			=> "Desculpa. Você foi banido. Se você acha que isso é um erro, entre em contato com o administrador.",
	"MAINT_TOK"			=> "Houve um erro com o seu formulário. Por favor volte e tente novamente. Observe que enviar o formulário atualizando a página causará um erro. Se isso continuar a acontecer, entre em contato com o administrador.",
	"MAINT_OPEN"		=> "Uma estrutura de gerenciamento de usuários PHP de código aberto.",
	"MAINT_PLEASE"	=> "Você instalou com sucesso o UserSpice! <br> Para ver nossa documentação inicial, visite"
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
	"DAT_SEARCH"    => "Pesquisar",
	"DAT_FIRST"     => "Primeiro",
	"DAT_LAST"      => "Último",
	"DAT_NEXT"      => "Próximo",
	"DAT_PREV"      => "Anterior",
	"DAT_NODATA"        => "Nenhum registro encontrado",
	"DAT_INFO"          => "Mostrando de _START_ até _END_ de _TOTAL_ registros",
	"DAT_ZERO"          => "Mostrando 0 até 0 de 0 registros",
	"DAT_FILTERED"      => "(Filtrados de _MAX_ registros)",
	"DAT_MENU_LENG"     => "_MENU_ resultados por página",
	"DAT_LOADING"       => "Carregando...",
	"DAT_PROCESS"       => "Processando...",
	"DAT_NO_REC"        => "Nenhum registro encontrado",
	"DAT_ASC" => "Ativar para ordenar a coluna ascendente",
	"DAT_DESC" => "Ativar para ordenar a coluna descendente",
));

//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
