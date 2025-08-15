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
	"THIS_LANGUAGE"	=> "Español",
	"THIS_CODE"			=> "es-ES",
	"MISSING_TEXT"	=> "Texto no Encontrado",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "Introduzca el código enviado a su correo electrónico",
    "PASS_EMAIL_ONLY"     => "Por favor, revise su correo electrónico para encontrar el enlace de inicio de sesión",
    "PASS_CODE_ONLY"      => "Por favor, introduzca el código enviado a su correo electrónico",
    "PASS_BOTH"           => "Por favor, revise su correo electrónico para encontrar el enlace de inicio de sesión o introduzca el código enviado",
    "PASS_VER_BUTTON"     => "Verificar código",
    "PASS_EMAIL_ONLY_MSG" => "Por favor, verifique su dirección de correo electrónico haciendo clic en el enlace siguiente",
    "PASS_CODE_ONLY_MSG"  => "Por favor, introduzca el código siguiente para iniciar sesión",
    "PASS_BOTH_MSG"       => "Por favor, verifique su dirección de correo electrónico haciendo clic en el enlace siguiente o introduzca el código para iniciar sesión",
    "PASS_YOUR_CODE"      => "Su código de verificación es: ",
    "PASS_CONFIRM_LOGIN"  => "Confirmar inicio de sesión",
    "PASS_CONFIRM_CLICK"  => "Haga clic para completar el inicio de sesión",
    "PASS_GENERIC_ERROR"  => "Algo ha salido mal",
));

//Database Menus
$lang = array_merge($lang, array(
	"MENU_HOME"			=> "Inicio",
	"MENU_HELP"			=> "Ayuda",
	"MENU_ACCOUNT"		=> "Mi Cuenta",
	"MENU_DASH"			=> "Administraci&oacute;n",
	"MENU_USER_MGR"		=> "Gesti&oacute;n de Usuarios",
	"MENU_PAGE_MGR"		=> "P&aacute;ginas",
	"MENU_PERM_MGR"		=> "Permisos",
	"MENU_MSGS_MGR"		=> "Mensajes",
	"MENU_LOGS_MGR"		=> "Accesos al Sistema",
	"MENU_LOGOUT"		=> "Salir",
));

// Signup
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"			=> "Registrarse",
	"SIGNUP_BUTTONTEXT"		=> "Reg&iacute;strame",
	"SIGNUP_AUDITTEXT"		=> "Registrado",
));

// Signin
$lang = array_merge($lang, array(
	"SIGNIN_FAIL"		=> "** ERROR DE ACCESO ** ",
	"SIGNIN_PLEASE_CHK" => "Por favor comprueba tu usuario y contrase&ntilde;a e int&eacute;ntalo de nuevo",
	"SIGNIN_UORE"		=> "Usuario o Email",
	"SIGNIN_PASS"		=> "Contrase&ntilde;a",
	"SIGNIN_FORGOTPASS" => "Olvid&eacute; mi contrase&ntilde;a",
	"SIGNIN_TITLE"		=> "Acceso de Usuarios",
	"SIGNIN_TEXT"		=> "Acceder",
	"SIGNOUT_TEXT"		=> "Salir",
	"SIGNIN_BUTTONTEXT"	=> "Acceder",
	"SIGNIN_REMEMBER"	=> "Recu&eacute;rdame",
	"SIGNIN_AUDITTEXT"	=> "Conectado",
	"SIGNOUT_AUDITTEXT"	=> "Desconectado",
));

// Account Page
$lang = array_merge($lang, array(
	"ACCT_EDIT"					=> "Editar Cuenta",
	"ACCT_2FA"					=> "Gestionar Doble Autenticaci&oacute;n",
	"ACCT_SESS"					=> "Gestionar Sesiones",
	"ACCT_HOME"					=> "Mi Cuenta",
	"ACCT_SINCE"				=> "Miembro Desde",
	"ACCT_LOGINS"				=> "Accesos",
	"ACCT_SESSIONS"				=> "Sesiones Activas",
	"ACCT_MNG_SES"				=> "Para m&aacute;s informaci&oacute;n, haz click en el bot&oacute;n Gestionar Sesiones.",
));

//General Terms
$lang = array_merge($lang, array(
	"GEN_ENABLED"			=> "Activado",
	"GEN_DISABLED"			=> "Desactivado",
	"GEN_ENABLE"			=> "Activar",
	"GEN_DISABLE"			=> "Desactivar",
	"GEN_NO"				=> "No",
	"GEN_YES"				=> "Si",
	"GEN_MIN"				=> "m&iacute;nimo",
	"GEN_MAX"				=> "m&aacute;ximo",
	"GEN_CHAR"				=> "caracteres", //as in characters
	"GEN_SUBMIT"			=> "Enviar",
	"GEN_MANAGE"			=> "Gestionar",
	"GEN_VERIFY"			=> "Verifica",
	"GEN_SESSION"			=> "Sesi&oacute;n",
	"GEN_SESSIONS"			=> "Sesiones",
	"GEN_EMAIL"				=> "Email",
	"GEN_FNAME"				=> "Nombre",
	"GEN_LNAME"				=> "Apellidos",
	"GEN_UNAME"				=> "Usuario",
	"GEN_PASS"				=> "Contrase&ntilde;a",
	"GEN_MSG"				=> "Mensaje",
	"GEN_TODAY"				=> "Hoy",
	"GEN_CLOSE"				=> "Cerrar",
	"GEN_CANCEL"			=> "Cancelar",
	"GEN_CHECK"				=> "[ selecciona/deselecciona todo ]",
	"GEN_WITH"				=> "con",
	"GEN_UPDATED"			=> "Actualizado",
	"GEN_UPDATE"			=> "Actualizar",
	"GEN_BY"					=> "por",
	"GEN_FUNCTIONS"			=> "Funciones",
	"GEN_NUMBER"			=> "n&uacute;mero",
	"GEN_NUMBERS"			=> "n&uacute;meros",
	"GEN_INFO" 				=> "Informaci&oacute;n",
	"GEN_REC" 				=> "Grabada",
	"GEN_DEL" 				=> "Eliminar",
	"GEN_NOT_AVAIL" 		=> "No Disponible",
	"GEN_AVAIL" 			=> "Disponible",
	"GEN_BACK" 				=> "Volver",
	"GEN_RESET" 			=> "Resetear",
	"GEN_REQ"				=> "obligatorio",
	"GEN_AND"				=> "y",
	"GEN_SAME"				=> "debe ser el mismo",
));

// Passkey Translations
$lang = array_merge($lang, array(
    "GEN_PASSKEY"           => "Clave de acceso",
    "GEN_ACTIONS"           => "Acciones",
    "GEN_BACK_TO_ACCT"      => "Volver a la cuenta",
    "GEN_DB_ERROR"          => "Ocurrió un error en la base de datos. Por favor, intenta de nuevo.",
    "GEN_IMPORTANT"         => "Importante",
    "GEN_NO_PERMISSIONS"    => "No tienes permiso para acceder a esta página.",
    "GEN_NO_PERMISSIONS_MSG" => "No tienes permiso para acceder a esta página. Si crees que esto es un error, por favor contacta al administrador del sitio.",
    "PASSKEYS_MANAGE_TITLE" => "Administrar claves de acceso",
    "PASSKEYS_LOGIN_TITLE"  => "Inicio de sesión con clave de acceso",
    "PASSKEY_DELETE_SUCCESS" => "Clave de acceso eliminada con éxito.",
    "PASSKEY_DELETE_FAIL_DB" => "No se pudo eliminar la clave de acceso de la base de datos.",
    "PASSKEY_DELETE_NOT_FOUND" => "Clave de acceso no encontrada o no tienes permiso para eliminarla.",
    "PASSKEY_NOTE_UPDATE_SUCCESS" => "Nota de la clave de acceso actualizada con éxito.",
    "PASSKEY_NOTE_UPDATE_FAIL" => "No se pudo actualizar la nota de la clave de acceso.",
    "PASSKEY_REGISTER_NEW"  => "Registrar nueva clave de acceso",
    "PASSKEY_ERR_LIMIT_REACHED" => "Has alcanzado el máximo de 10 claves de acceso.",
    "PASSKEY_NOTE_TH"       => "Nota de la clave de acceso",
    "PASSKEY_TIMES_USED_TH" => "Veces utilizada",
    "PASSKEY_LAST_USED_TH"  => "Último uso",
    "PASSKEY_LAST_IP_TH"    => "Última IP",
    "PASSKEY_EDIT_NOTE_BTN" => "Editar nota",
    "PASSKEY_CONFIRM_DELETE_JS" => "¿Estás seguro de que quieres eliminar esta clave de acceso?",
    "PASSKEY_EDIT_MODAL_TITLE" => "Editar nota de la clave de acceso",
    "PASSKEY_EDIT_MODAL_LABEL" => "Nota de la clave de acceso",
    "PASSKEY_SAVE_CHANGES_BTN" => "Guardar cambios",
    "PASSKEY_NONE_REGISTERED" => "Aún no tienes ninguna clave de acceso registrada.",
    "PASSKEY_MUST_REGISTER_FIRST" => "Debes registrar una clave de acceso desde una cuenta autenticada antes de usar esta función.",
    "PASSKEY_STORING"       => "Almacenando clave de acceso...",
    "PASSKEY_STORED_SUCCESS" => "¡Clave de acceso almacenada con éxito!",
    "PASSKEY_INVALID_ACTION" => "Acción no válida: ",
    "PASSKEY_NO_ACTION_SPECIFIED" => "No se especificó ninguna acción",
    "PASSKEY_ERR_NETWORK_SUGGESTION" => "Se detectó un problema de red. Intenta con una red diferente o actualiza la página.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "Se detectó autenticación entre dispositivos. Asegúrate de que ambos dispositivos tengan acceso a internet.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "Intenta abrir esta página directamente en tu teléfono.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED" => "No se pudieron generar los diagnósticos: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA" => "Faltan datos de credenciales requeridos para el almacenamiento.",
    "PASSKEY_MISSING_AUTH_DATA" => "Faltan datos de autenticación requeridos.",
    "PASSKEY_LOG_NO_MESSAGE" => "Sin mensaje",
    "PASSKEY_USER_NOT_FOUND" => "Usuario no encontrado después de la validación de la clave de acceso.",
    "PASSKEY_FATAL_ERROR"    => "Error fatal: ",
    "PASSKEY_LOGIN_SUCCESS"  => "Inicio de sesión exitoso.",
    "PASSKEY_CROSS_DEVICE_PREP" => "Preparando registro entre dispositivos. Es posible que necesites usar tu teléfono o tableta.",
    "PASSKEY_DEVICE_REGISTRATION" => "Usando registro de clave de acceso del dispositivo...",
    "PASSKEY_STARTING_REGISTRATION" => "Iniciando registro de clave de acceso...",
    "PASSKEY_REQUEST_OPTIONS" => "Solicitando opciones de registro al servidor...",
    "PASSKEY_FOLLOW_PROMPTS" => "Sigue las instrucciones para crear tu clave de acceso. Puede que necesites usar otro dispositivo.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE" => "Sigue las instrucciones para crear tu clave de acceso...",
    "PASSKEY_CREATION_FAILED" => "Fallo en la creación de la clave de acceso - no se devolvió ninguna credencial.",
    "PASSKEY_STORING_SERVER" => "Almacenando tu clave de acceso...",
    "PASSKEY_CREATED_SUCCESS" => "¡Clave de acceso creada con éxito!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP" => "Preparando autenticación entre dispositivos. Asegúrate de que tu teléfono y computadora tengan acceso a internet.",
    "PASSKEY_DEVICE_AUTH"    => "Usando autenticación de clave de acceso del dispositivo...",
    "PASSKEY_STARTING_AUTH"  => "Iniciando autenticación de clave de acceso...",
    "PASSKEY_QR_CODE_INSTRUCTION" => "Escanea el código QR con tu teléfono cuando aparezca. Asegúrate de que ambos dispositivos tengan acceso a internet.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION" => "Elige \"Usar un teléfono o tableta\" cuando se te solicite, luego escanea el código QR.",
    "PASSKEY_AUTHENTICATING" => "Autenticando con tu clave de acceso...",
    "PASSKEY_SUCCESS_REDIRECTING" => "¡Autenticación exitosa! Redirigiendo...",
    "PASSKEY_TIMEOUT_CROSS_DEVICE" => "El registro ha caducado. Para autenticación entre dispositivos: 1) Intenta de nuevo, 2) Asegúrate de que los dispositivos tengan internet, 3) Considera registrar directamente en tu teléfono.",
    "PASSKEY_TIMEOUT_SIMPLE" => "El registro ha caducado. Por favor, intenta de nuevo.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE" => "La autenticación entre dispositivos ha caducado. Solución de problemas: 1) Ambos dispositivos necesitan internet, 2) Intenta escanear el código QR más rápido, 3) Considera usar el mismo dispositivo, 4) Algunas redes bloquean la autenticación entre dispositivos.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE" => "La autenticación ha caducado. Por favor, intenta de nuevo.",
    "PASSKEY_NO_CREDENTIAL"  => "No se recibió ninguna credencial. Reintentando...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL" => "Fallo en la autenticación - no se devolvió ninguna credencial.",
    "PASSKEY_ATTEMPT_RETRY"  => "falló. Reintentando... (%d intentos restantes)",
    "PASSKEY_CROSS_DEVICE_FAILED" => "Fallo en el registro entre dispositivos. Intenta: 1) Asegúrate de que ambos dispositivos tengan internet, 2) Considera registrar directamente en tu teléfono, 3) Algunas redes corporativas bloquean esta función.",
    "PASSKEY_REGISTRATION_CANCELLED" => "El registro fue cancelado o el dispositivo no soporta claves de acceso.",
    "PASSKEY_NOT_SUPPORTED"  => "Las claves de acceso no son compatibles con esta combinación de dispositivo/navegador.",
    "PASSKEY_SECURITY_ERROR" => "Error de seguridad - esto usualmente indica una discrepancia de dominio/origen.",
    "PASSKEY_ALREADY_EXISTS" => "Ya existe una clave de acceso para esta cuenta en este dispositivo. Intenta usar un dispositivo diferente o elimina las claves de acceso existentes primero.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED" => "Fallo en la autenticación entre dispositivos. Intenta: 1) Asegúrate de que ambos dispositivos tengan internet estable, 2) Usa la misma red WiFi si es posible, 3) Intenta autenticar directamente en tu teléfono, 4) Algunas redes corporativas bloquean esta función.",
    "PASSKEY_AUTH_CANCELLED" => "La autenticación fue cancelada o no se seleccionó ninguna clave de acceso.",
    "PASSKEY_NETWORK_ERROR"  => "Error de red. Para la autenticación entre dispositivos, ambos dispositivos necesitan acceso a internet y podrían necesitar estar en la misma red.",
    "PASSKEY_CREDENTIAL_NOT_FOUND" => "Fallo en la autenticación - credencial no reconocida.",
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "Consejos para autenticación entre dispositivos:",
    "PASSKEY_GUIDANCE_INTERNET" => "Asegúrate de que tanto tu computadora como tu teléfono tengan acceso a internet",
    "PASSKEY_GUIDANCE_WIFI"  => "Estar en la misma red WiFi puede ayudar (pero no siempre es necesario)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE" => "Cuando se te solicite, selecciona \"Usar un teléfono o tableta\"",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY" => "Escanea el código QR rápidamente cuando aparezca",
    "PASSKEY_GUIDANCE_TRY_DIRECT" => "Si falla, intenta actualizar y usar el navegador de tu teléfono directamente",
    "PASSKEY_SHOW_TROUBLESHOOTING" => "Mostrar consejos de solución de problemas",
    "PASSKEY_HIDE_TROUBLESHOOTING" => "Ocultar consejos de solución de problemas",
    "PASSKEY_DIAGNOSTICS_RUNNING" => "Ejecutando diagnósticos...",
    "PASSKEY_DIAGNOSTICS_COMPLETE" => "Diagnósticos completados. Revisa la consola para más detalles.",
    "PASSKEY_ISSUES_DETECTED" => "Problemas detectados:",
    "PASSKEY_ENVIRONMENT_SUITABLE" => "El entorno parece adecuado para claves de acceso.",
    "PASSKEY_DIAGNOSTICS_FAILED" => "Diagnósticos fallidos:",
    "PASSKEY_ADD_NOTE_NEW"  => "Agregar nota a tu nueva clave de acceso",
    "PASSKEY_BASE64_ERROR"  => "Error de decodificación Base64:",
    "PASSKEY_INVALID_JSON"  => "Datos JSON no válidos recibidos:",
    "PASSKEY_LOGIN_REQUIRED" => "Debes estar conectado para realizar esta acción.",
    "PASSKEY_ACTION_MISSING" => "Falta el parámetro 'acción' requerido en la solicitud.",
    "PASSKEY_STORAGE_FAILED" => "No se pudo almacenar la clave de acceso. La operación no fue exitosa.",
    "PASSKEY_LOGIN_FAILED"   => "Fallo en el inicio de sesión con clave de acceso. No se pudo verificar la autenticación.",
    "PASSKEY_INVALID_METHOD" => "Método de solicitud no válido:",
    "CSRF_ERROR"            => "La verificación del token CSRF falló. Por favor, regresa e intenta enviar el formulario de nuevo.",
    "PASSKEY_NETWORK_PRIVATE" => "Problema potencial: Parece que estás en una red privada, lo que a veces puede interferir con la comunicación entre dispositivos.",
    "PASSKEY_NETWORK_PROXY"  => "Problema potencial: Se detectó un proxy o VPN. Esto puede interferir con la comunicación entre dispositivos.",
    "PASSKEY_NETWORK_MOBILE" => "Nota: Parece que estás en una red móvil. Asegúrate de tener una conexión estable para operaciones entre dispositivos.",
    "PASSKEY_NETWORK_CORPORATE" => "Problema potencial: Puede estar activo un cortafuegos corporativo, lo que podría afectar la autenticación entre dispositivos.",
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "Recomendación: Es probable que estés usando un escritorio. Prepárate para usar tu teléfono para escanear un código QR.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "Recomendación: Para mejores resultados, asegúrate de que tu computadora y dispositivo móvil estén en la misma red Wi-Fi.",
    "PASSKEY_RECOMMENDATION_QR_QUICK" => "Recomendación: Prepárate para escanear el código QR rápidamente, ya que la solicitud puede caducar.",
    "PASSKEY_RECOMMENDATION_INTERNET" => "Recomendación: Asegúrate de que tanto tu computadora como tu dispositivo móvil tengan una conexión a internet estable.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "Recomendación: Para WebViews de Unity, asegúrate de que la página tenga suficiente tiempo para cargar y procesar la solicitud de clave de acceso.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "Recomendación: Los tiempos de espera pueden ser más largos en Unity. Por favor, ten paciencia.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "Recomendación: Dado que estás en un móvil, deberías poder registrar una clave de acceso directamente en este dispositivo.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "Recomendación: En Android, puedes administrar tus claves de acceso en el Administrador de Contraseñas de Google.",
    "PASSKEY_VALIDATION_RP_IP" => "Advertencia de configuración: El ID de la parte confiable está configurado como una dirección IP.",
    "PASSKEY_VALIDATION_RP_DOMAIN" => "Recomendación: Configura el ID de la parte confiable con tu nombre de dominio (por ejemplo, tusitio.com) para mayor seguridad y compatibilidad.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED" => "Error de configuración: Se requiere HTTPS para que las claves de acceso funcionen en un servidor en vivo. Tu sitio parece estar en HTTP.",
    "PASSKEY_VALIDATION_NETWORK" => "Advertencia de red",
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "Recomendación: Si experimentas problemas, intenta con una red diferente (por ejemplo, cambia de Wi-Fi corporativo a un punto de acceso móvil).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "Recomendación: Para acciones entre dispositivos, asegúrate de que ambos dispositivos tengan una conexión a internet confiable.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK" => "Recomendación: Si las acciones entre dispositivos fallan, intenta visitar esta página directamente en tu dispositivo móvil para completar la acción.",
    "PASSKEY_INFO_TITLE"    => "Acerca de las claves de acceso",
    "PASSKEY_INFO_DESC"     => "Las claves de acceso son una forma segura y sin contraseña de iniciar sesión utilizando las funciones de seguridad integradas de tu dispositivo, como huella dactilar, reconocimiento facial o PIN. Son más seguras que las contraseñas, ofrecen un inicio de sesión más rápido, funcionan en múltiples dispositivos cuando se sincronizan con administradores de contraseñas y son resistentes a ataques de phishing. Las claves de acceso funcionan en teléfonos inteligentes modernos, tabletas, computadoras y pueden almacenarse en administradores de contraseñas como 1Password, Bitwarden, iCloud Keychain o Google Password Manager.",
    "PASSKEY_BACK_TO_LOGIN" => "Volver al inicio de sesión",
));

//validation class
$lang = array_merge($lang, array(
	"VAL_SAME"			=> "debe ser el mismo",
	"VAL_EXISTS"		=> "ya existe. Por favor, elija otro",
	"VAL_DB"			=> "Error en la Base de Datos",
	"VAL_NUM"			=> "debe ser un n&uacute;mero",
	"VAL_INT"			=> "debe ser un n&uacute;mero entero",
	"VAL_EMAIL"			=> "debe ser una direcci&oacute;n de correo v&aacute;lida",
	"VAL_NO_EMAIL"		=> "no puede ser una direcci&oacute;n email",
	"VAL_SERVER"		=> "debe ser un servidor v&aacute;lido",
	"VAL_LESS"			=> "debe ser menor que",
	"VAL_GREAT"			=> "debe ser mayor que",
	"VAL_LESS_EQ"		=> "debe ser menor o igual que",
	"VAL_GREAT_EQ"		=> "debe ser mayor o igual que",
	"VAL_NOT_EQ"		=> "no debe ser igual que",
	"VAL_EQ"			=> "debe ser igual que",
	"VAL_TZ"			=> "tiene que un nombre de zona horaria v&aacute;lido",
	"VAL_MUST"			=> "debe ser",
	"VAL_MUST_LIST"		=> "debe ser uno de los siguientes",
	"VAL_TIME"			=> "debe ser una hora v&aacute;lida",
	"VAL_SEL"			=> "no es v&aacute;lido lo seleccionado",
	"VAL_NA_PHONE"		=> "debe ser un n&uacute;mero de ltel&eacute;fono de Norte America v&aacute;lido",
));

//Time
$lang = array_merge($lang, array(
	"T_YEARS"		=> "A&ntilde;os",
	"T_YEAR"		=> "A&ntilde;o",
	"T_MONTHS"		=> "Meses",
	"T_MONTH"		=> "Mes",
	"T_WEEKS"		=> "Semanas",
	"T_WEEK"		=> "Semana",
	"T_DAYS"		=> "D&iacute;as",
	"T_DAY"			=> "D&iacute;a",
	"T_HOURS"		=> "Horas",
	"T_HOUR"		=> "Hora",
	"T_MINUTES"		=> "Minutos",
	"T_MINUTE"		=> "Minuto",
	"T_SECONDS"		=> "Segundos",
	"T_SECOND"		=> "Segundo",
));


//Passwords
$lang = array_merge($lang, array(
	"PW_NEW"		=> "Nueva Contrase&ntilde;a",
	"PW_OLD"		=> "Contrase&ntilde;a Anterior",
	"PW_CONF"		=> "Confirmar Contrase&ntilde;a",
	"PW_RESET"		=> "Resetear Contrase&ntilde;a",
	"PW_UPD"		=> "Contrase&ntilde;a Actualizada",
	"PW_SHOULD"		=> "La Contrase&ntilde;a Deber&iacute;a...",
	"PW_SHOW"		=> "Mostrar Contrase&ntilde;a",
	"PW_SHOWS"		=> "Mostrar Contrase&ntilde;as",
));


//Join
$lang = array_merge($lang, array(
	"JOIN_SUC"		=> "Bienvenido A ",
	"JOIN_THANKS"	=> "Gracias por registrarte",
	"JOIN_HAVE"		=> "Tener al menos ",
	"JOIN_LOWER"	=>	" letra min&uacute;scula",
	"JOIN_SYMBOL"		=> " s&iacute;mbolo",
	"JOIN_CAP"		=> " letra may&uacute;scula",
	"JOIN_TWICE"	=> "Ser esctrito correctamente dos veces",
	"JOIN_CLOSED"	=> "En estos momentos el registrarse est&aacute; deshabilitado. por favor, contacta con el Administrador del Sitio para cualquier duda.",
	"JOIN_TC"		=> "Condiciones y T&eacute;rminos de Usuario al Registrarse",
	"JOIN_ACCEPTTC" => "Acepto las Condiciones y T&eacute;rminos de Usuario",
	"JOIN_CHANGED"	=> "Nuestror T&eacute;rminos han Cambiado",
	"JOIN_ACCEPT" 	=> "Aceptar las Condiciones y T&eacute;rminos de Usuario y Continuar",
	"JOIN_SCORE" => "Puntos:",
	"JOIN_INVALID_PW" => "Su contraseña es inválida",

));


//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "Acabada Correctamente ",
));

//Messages
$lang = array_merge($lang, array(
	"MSG_SENT"			=> "&iexcl;Tu mensaje ha sido enviado!",
	"MSG_MASS"			=> "&iexcl;Tu mensaje m&uacute;ltiple ha sido enviado!",
	"MSG_NEW"			=> "Nuevo Mensaje",
	"MSG_NEW_MASS"		=> "Nuevo Mensaje M&uacute;ltiple",
	"MSG_CONV"			=> "Conversaciones",
	"MSG_NO_CONV"		=> "Sin Conversaciones",
	"MSG_NO_ARC"		=> "Sin Conversaciones",
	"MSG_QUEST"			=> "&iquest;Enviar Email con Notificaciones si est&aacute; Activo?",
	"MSG_ARC"			=> "Hilo Archivado",
	"MSG_VIEW_ARC"		=> "Ver Hilos Archivados",
	"MSG_SETTINGS"  	=> "Configuraci&oacute;n de Mensajes",
	"MSG_READ"			=> "Leer",
	"MSG_BODY"			=> "Cuerpo",
	"MSG_SUB"			=> "Asunto",
	"MSG_DEL"			=> "Enviado",
	"MSG_REPLY"			=> "Responder",
	"MSG_QUICK"			=> "Respuesta R&aacute;pida",
	"MSG_SELECT"		=> "Seleccionar un usuario",
	"MSG_UNKN"			=> "Receptor Desconocido",
	"MSG_NOTIF"			=> "Mensaje de Notificaciones por Email",
	"MSG_BLANK"			=> "El mensaje no puede estar en blanco",
	"MSG_MODAL"			=> "&iexcl;Haz click aqu&iacute; o teclea Alt + R para activar este cuadro o teclea May&uacute;s   R para abrir la versi&oacute;n expandida del panel!",
	"MSG_ARCHIVE_SUCCESSFUL"        => "Se han archivado %m1% hilos correctamente",
	"MSG_UNARCHIVE_SUCCESSFUL"      => "Se han desarchivado %m1% hilos correctamente",
	"MSG_DELETE_SUCCESSFUL"         => "Se han eliminado %m1% hilos correctamente",
	"USER_MESSAGE_EXEMPT"         	=> "Usuario %m1% no recibe mensajes.",
	"MSG_MK_READ" 		=> "Le&iacute;do",
	"MSG_MK_UNREAD" 	=> "Sin Leer",
	"MSG_ARC_THR" 		=> "Archivar Hilos Seleccionados",
	"MSG_UN_THR" 		=> "Desarchivar Hilos Seleccionados",
	"MSG_DEL_THR" 		=> "Borrar Hilos Seleccionados",
	"MSG_SEND" 			=> "Enviar Mensaje",
));

// Two Factor Authentication Translations
$lang = array_merge($lang, array(
    "2FA"               => "Autenticación de dos factores",
    "2FA_CONF"          => "¿Estás seguro de que quieres desactivar la autenticación de dos factores? Tu cuenta ya no estará protegida.",
    "2FA_SCAN"          => "Escanea este código QR con tu aplicación de autenticación o ingresa la clave",
    "2FA_THEN"          => "Luego ingresa una de tus claves de un solo uso aquí",
    "2FA_FAIL"          => "Hubo un problema al verificar la autenticación de dos factores. Por favor, verifica tu conexión a internet o contacta al soporte.",
    "2FA_CODE"          => "Código de autenticación de dos factores",
    "2FA_EXP"           => "1 huella digital caducada",
    "2FA_EXPD"          => "Caducado",
    "2FA_EXPS"          => "Caduca",
    "2FA_ACTIVE"        => "Sesiones activas",
    "2FA_NOT_FN"        => "No se encontraron huellas digitales",
    "2FA_FP"            => "Huellas digitales",
    "2FA_NP"            => "Inicio de sesión fallido. El código de autenticación de dos factores no estaba presente. Por favor, intenta de nuevo.",
    "2FA_INV"           => "Inicio de sesión fallido. El código de autenticación de dos factores no es válido. Por favor, intenta de nuevo.",
    "2FA_FATAL"         => "Error fatal. Por favor, contacta al administrador del sistema. No podemos generar un código de autenticación de dos factores en este momento.",
    "2FA_SECTION_TITLE" => "Autenticación de dos factores (TOTP)",
    "2FA_SK_ALT"       => "Si no puedes escanear el código QR, ingresa manualmente esta clave secreta en tu aplicación de autenticación.",
    "2FA_IS_ENABLED"    => "La autenticación de dos factores está protegiendo tu cuenta.",
    "2FA_NOT_ENABLED_INFO" => "La autenticación de dos factores no está habilitada actualmente.",
    "2FA_NOT_ENABLED_EXPLAIN" => "La autenticación de dos factores (TOTP) agrega una capa adicional de seguridad a tu cuenta al requerir un código de una aplicación de autenticación en tu teléfono además de tu contraseña.",
    "2FA_SETUP_TITLE"  => "Configurar autenticación de dos factores",
    "2FA_SECRET_KEY_LABEL" => "Clave secreta:",
    "2FA_SETUP_VERIFY_CODE_LABEL" => "Ingresa el código de verificación de la aplicación",
    "2FA_SUCCESS_ENABLED_TITLE" => "¡Autenticación de dos factores habilitada! Guarda tus códigos de respaldo",
    "2FA_SUCCESS_ENABLED_INFO" => "A continuación se muestran tus códigos de respaldo. Guárdalos de forma segura; cada uno solo se puede usar una vez.",
    "2FA_BACKUP_CODES_WARNING" => "Trata estos códigos como contraseñas. Guárdalos de forma segura.",
    "2FA_SUCCESS_BACKUP_REGENERATED" => "Nuevos códigos de respaldo generados. Guárdalos de forma segura.",
    "2FA_BACKUP_CODE_LABEL" => "Código de respaldo",
    "2FA_REGEN_CODES_BTN" => "Regenerar códigos de respaldo",
    "2FA_INVALIDATE_WARNING" => "Esto invalidará todos los códigos de respaldo existentes. ¿Estás seguro?",
    "2FA_CODE_LABEL"    => "Código de autenticación",
    "2FA_VERIFY_BTN"    => "Verificar e iniciar sesión",
    "2FA_VERIFY_TITLE"  => "Se requiere autenticación de dos factores",
    "2FA_VERIFY_INFO"   => "Ingresa el código de 6 dígitos de tu aplicación de autenticación.",
    "2FA_ENABLE_BTN"    => "Habilitar autenticación de dos factores",
    "2FA_DISABLE_BTN"   => "Deshabilitar autenticación de dos factores",
    "2FA_VERIFY_ACTIVATE_BTN" => "Verificar y activar",
    "2FA_CANCEL_SETUP_BTN" => "Cancelar configuración",
    "2FA_DONE_BTN"      => "Hecho",
    "REDIR_2FA_DIS"     => "La autenticación de dos factores ha sido desactivada.",
    "2FA_SUCCESS_BACKUP_ACK" => "Códigos de respaldo confirmados.",
    "2FA_SUCCESS_SETUP_CANCELLED" => "Configuración cancelada.",
    "2FA_ERR_INVALID_BACKUP" => "Código de respaldo no válido. Por favor, intenta de nuevo.",
    "2FA_ERR_DISABLE_FAILED" => "No se pudo deshabilitar la autenticación de dos factores.",
    "2FA_ERR_NO_SECRET" => "No se pudo recuperar el secreto de autenticación. Por favor, intenta de nuevo.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL" => "Código de respaldo verificado pero no se pudo invalidar. Por favor, contacta al soporte.",
    "2FA_ERR_NO_CODE_PROVIDED" => "No se proporcionó ningún código de autenticación.",
    "RATE_LIMIT_LOGIN"   => "Demasiados intentos de inicio de sesión fallidos. Por favor, espera antes de intentar de nuevo.",
    "RATE_LIMIT_TOTP"    => "Demasiados códigos de autenticación incorrectos. Por favor, espera antes de intentar de nuevo.",
    "RATE_LIMIT_PASSKEY" => "Demasiados intentos de autenticación con clave de acceso. Por favor, espera antes de intentar de nuevo.",
    "RATE_LIMIT_PASSKEY_STORE" => "Demasiados intentos de registro de clave de acceso. Por favor, espera antes de intentar de nuevo.",
    "RATE_LIMIT_PASSWORD_RESET" => "Demasiadas solicitudes de restablecimiento de contraseña. Por favor, espera antes de solicitar otro restablecimiento.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT" => "Demasiados intentos de restablecimiento de contraseña. Por favor, espera antes de intentar de nuevo.",
    "RATE_LIMIT_REGISTRATION" => "Demasiados intentos de registro. Por favor, espera antes de intentar de nuevo.",
    "RATE_LIMIT_EMAIL_VERIFICATION" => "Demasiadas solicitudes de verificación de correo electrónico. Por favor, espera antes de solicitar otra verificación.",
    "RATE_LIMIT_EMAIL_CHANGE" => "Demasiadas solicitudes de cambio de correo electrónico. Por favor, espera antes de intentar de nuevo.",
    "RATE_LIMIT_PASSWORD_CHANGE" => "Demasiados intentos de cambio de contraseña. Por favor, espera antes de intentar de nuevo.",
    "RATE_LIMIT_GENERIC" => "Demasiados intentos. Por favor, espera antes de intentar de nuevo.",
));

$lang = array_merge($lang, array(
	"REDIR_2FA"					=> "Lo sentimos.2FA no est&aacute; disponible en este momento",
	"REDIR_2FA_EN"				=> "Autentication Enabled",
	"REDIR_2FA_DIS"				=> "Doble Autenticaci&oacute;n Desactivada",
	"REDIR_2FA_VER"				=> "Doble Autenticaci&oacute;n Verificada y Activa",
	"REDIR_SOMETHING_WRONG" 		=> "Algo ha ido mal. Por favor intenta de nuevo.",
	"REDIR_MSG_NOEX"			=> "Ese hilo no es tuoyo o no exist.",
	"REDIR_UN_ONCE"				=> "El Nombre de Usuario ya ha sido modificado una vez.",
	"REDIR_EM_SUCC"				=> "Email Actualizado Correctamente",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "Iniciar sesión con:",
	"EML_FEATURE_DISABLED" => "Esta función está desactivada",
	"EML_PASSWORDLESS_SENT" => "Por favor, revise su correo electrónico para obtener un enlace para iniciar sesión.",
	"EML_PASSWORDLESS_SUBJECT" => "Por favor, verifique su correo electrónico para iniciar sesión.",
	"EML_PASSWORDLESS_BODY" => "Por favor, verifique su dirección de correo electrónico haciendo clic en el enlace a continuación. Se iniciará sesión automáticamente.",

	"EML_CONF"				=> "Confirmar Email",
	"EML_VER"				=> "Verifica Tu Email",
	"EML_CHK"				=> "Solicitud Recibida. Por favor, comprueba tu correo para la verificaci&oacute;n. Aseg&uacute;rate de revisar tu carpeta de Spam y Junk, ya que el enlace de verificaci&oacute;n caduca en ",
	"EML_MAT"				=> "Tu email no coincide.",
	"EML_HELLO"				=> "Hola desde ",
	"EML_HI"				=> "Hola ",
	"EML_AD_HAS"		=> "Un Administrador ha reseteado tu contrase&ntilde;a.",
	"EML_AC_HAS"		=> "Un Administrador ha creado yu cuenta.",
	"EML_REQ"				=> "Se te pedir&aacute; que establezcas tu contrase&ntilde;a usando el enlace de arriba.",
	"EML_EXP"				=> "Atento, los enlaces de contrase&ntilde;a caducan en ",
	"EML_VER_EXP"		=> "Atento, los enlaces de Verificaci&oacute;n caducan en ",
	"EML_CLICK"			=> "Haz click aqu&iacute; para acceder.",
	"EML_REC"				=> "Es recomendable que cambies tu contrase&ntilde;a al acceder.",
	"EML_MSG"				=> "Tienes un nuevo mensaje de",
	"EML_REPLY"			=> "Haz click aqu&iacute; para responder o ver el hilo",
	"EML_WHY"				=> "Has recibido este correo porque se ha solicitado el reseteo de tu contrase&ntilde;a. Si no has sido tu, olvida este correo.",
	"EML_HOW"				=> "Si has sido tu, haz click en el enlace para continuar con el proceso de reseteo.",
	"EML_EML"				=> "Se ha solicitado modificar tu email desde tu cuenta de usuario.",
	"EML_VER_EML"		=> "Gracias por registrarte. &iexcl; Una vez que verifiques tu direcci&oacute;n email estar&aacute;s listo para acceder! Haz click en el siguiente enlace para verificar tu direcci&oacute;n email.",
));

//Verification
$lang = array_merge($lang, array(
	"VER_SUC"		=> "&iexcl;Tu Email ha sido verificado!",
	"VER_FAIL"		=> "No hemos podido verificar tu cuenta. Por favor, intenta de nuevo.",
	"VER_RESEND"	=> "Email de Verificaci&oacute;n Reenviado",
	"VER_AGAIN"		=> "Escribe tu direcci&oacute;n email e intenta de nuevo",
	"VER_PAGE"		=> "<li>Comprueba tu correo y haz click en el enlace que se te ha enviado</li><li>Hecho</li>",
	"VER_RES_SUC" 	=> " Se ha enviado tu enlace de verificaci&oacute;n a tu direcci&oacute;n email.  Haz click en el enlace enviado para completar la verificaci&oacute;n. Aseg&uacute;rate de revisar tu carpeta de Spam si el email no est&aacute; en tu bandeja de entrada.  Los enlaces de verificaci&oacute;n solo son v&aacute;lidos durante ",
	"VER_OOPS" 		=> "Vaya... parece que algo no ha ido bien. Puede ser un reset que has enviado antes. Haz click abajo para intentarlo de nuevo",
	"VER_RESET" 	=> "&iexcl;Tu contrase&ntilde;a ha sido reseteada!",
	"VER_INS" 		=> "<li>Teclea tu direcci&oacute;n email y haz click en Resetear</li> <li>Comprueba tu correo y haz click en el enlace que se te ha enviado.</li> <li>Sigue las instrucciones indicadas</li>",
	"VER_SENT" 		=> " Se te ha enviado el enlace de reseteo de contrase&ntilde;a a tu correo.   Haz click en el enlace del correo para Resetear la contrase&ntilde;a. Si no ves el correo, comprueba tu bandeja de Spam.  Enlace v&aacute;lido solo durante ",
	"VER_PLEASE" 	=> "Resetear tu contrase&ntilde",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"		=> "Resetear PIN",
	"SET_WHY"		=> "&iquest;Porqu&eacute; no puedo modificar esto?",
	"SET_PW_MATCH"	=> "Debe coincidir con la Nueva Contrase&ntilde;a",
	"SET_PIN_NEXT"	=> "Puedes establecer un PIN nuevo la pr&oacute;xima vez que se solicite verificaci&oacute;n",
	"SET_UPDATE"	=> "Actualiza tu configuraci&oacute;n de usuario",
	"SET_NOCHANGE"	=> "El Administrador ha desactivado el cambio de nombre de usuario.",
	"SET_ONECHANGE"	=> "El Administrador ha establecido que los cambios de nombre de usuario solo se pueden hacer una vez y tu ya lo has hecho.",
	"SET_GRAVITAR"	=> "&iquest;Quieres cambiar la foto de tu perfil?  <br> Visita <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> y crea una cuenta con el mismo email que has usado en este sitio. Est&aacute;n presentes en millones de sitios. &iexcl;Es r&aacute;pido y sencillo!",
	"SET_NOTE1"		=> " Atento por favor,  hay pendiente una solicitud de actualizaci&oacute;n de tu email a",
	"SET_NOTE2"		=> ".  Por favor, usa el correo de verificaci&oacute;n para completar esta solicitud. 
		 Si necesitas un nuevo correo de verificaci&oacute;n, vuelve a escribir el email anterior y env&iacute;a la solicitud de nuevo. ",
	"SET_PW_REQ" 	=> "obligatorio para cambiar contrase&ntilde;a, email, o resetear el PIN",
	"SET_PW_REQI" 	=> "Obligatorio para cambiar tu contrase&ntilde;a",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "Fallo al eliminar sesiones activas, Error: ",
	"ERR_EMAIL"			=> "El correo no se ha enviado debido a un error. Por favor, contacta con el Administrador del sitio.",
	"ERR_EM_DB"			=> "Ese email no existe en nuesta base de datos",
	"ERR_TC"			=> "Por favor, lee y acepta los t&eacute;rminos y condiciones",
	"ERR_CAP"			=> "&iexcl;No has pasado el Test de comprobaci&oacute;n humana, Robot!",
	"ERR_PW_SAME"		=> "Tu contrase&ntilde;a anterior no puede ser igual que la nueva",
	"ERR_PW_FAIL"		=> "Fallo en la verificaci&oacute;n de contrase&ntilde;a actual. No se ha actualizado. Por favor, intenta de nuevo.",
	"ERR_GOOG"			=> "ATENCI&oacute;N:  Si desde el principio has entrado con tu cuenta de Google/Facebook, necesitar&aacute;s usar el enlace de olvido de contrase&ntilde;a para cambiar tu contrase&ntilde;a....a menos que seas realmente bueno adivinando.",
	"ERR_EM_VER"		=> "La verificaci&oacute;n de email no est&aacute; habilitada. Por favor, contacta con el Administrador del sitio.",
	"ERR_EMAIL_STR"		=> "Algo extra&ntilde;o ha ocurrido. Por favor, re-verifica tu email. Sentimos las molestias",
));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "&iexcl;Volveremos pronto!",
	"MAINT_MSG"			=> "&iexcl;Lo sentimos, estamos realizando tareas de mantenimiento ahora mismo.<br> Esteremos listos en breve!",
	"MAINT_BAN" 		=> "Lo setimos. Tu IP ha sido bloqueada. Si crees que esto es un error, por favor contacta con el administrador.",
	"MAINT_TOK" 		=> "Ha habido un error con tu formulario. Vuelve atr&aacute;s e intenta de nuevo. Recuerda que enviar el formulario refrecando la p&aacute;gina, dar&aacute; error. Si vuelve a ocurrir, por favor contacta con el administrador.",
	"MAINT_OPEN" 		=> "Un Framework Open Source en PHP para la Gesti&oacute;n de Usuarios.",
	"MAINT_PLEASE" 		=> "&iexcl;UserSpice se ha instalado correctamente!<br>Para ver la documentaci&oacute;n inicial (en ingl&eacute;s), visita ",
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
	"DAT_SEARCH"    => "Buscar",
	"DAT_FIRST"     => "Primero",
	"DAT_LAST"      => "Ultimo",
	"DAT_NEXT"      => "Siguiente",
	"DAT_PREV"      => "Anterior",
	"DAT_NODATA"        => "Tabla no contiene datos",
	"DAT_INFO"          => "Mostrando entradas _START_ a _END_ de _TOTAL_",
	"DAT_ZERO"          => "Mostrando entradas 0 a 0 de 0",
	"DAT_FILTERED"      => "(filtrado de un total de _MAX_ entradas)",
	"DAT_MENU_LENG"     => "Mostrar _MENU_ entradas",
	"DAT_LOADING"       => "Cargando...",
	"DAT_PROCESS"       => "Procesando...",
	"DAT_NO_REC"        => "No hay registros que coincidan",
	"DAT_ASC"           => "Activar para ordenar columna de forma ascendente",
	"DAT_DESC"          => "Activar para ordenar columna de forma descendente",
));

//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
