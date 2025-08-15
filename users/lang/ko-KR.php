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
	"THIS_LANGUAGE"	=> "한국어",
	"THIS_CODE"		=> "ko-KR",
	"MISSING_TEXT"	=> "누락된 텍스트",
));

//Database Menus
$lang = array_merge($lang, array(
	"MENU_HOME"		=> "홈",
	"MENU_HELP"		=> "도움말",
	"MENU_ACCOUNT"	=> "내 계정",
	"MENU_DASH"		=> "관리 대시보드",
	"MENU_USER_MGR"	=> "사용자 관리",
	"MENU_PAGE_MGR"	=> "페이지 관리",
	"MENU_PERM_MGR"	=> "사용 권한 관리",
	"MENU_MSGS_MGR"	=> "메시지 관리자를",
	"MENU_LOGS_MGR"	=> "시스템 로그",
	"MENU_LOGOUT"	=> "로그아웃",
));


$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"    => "이메일로 전송된 코드를 입력하세요",
    "PASS_EMAIL_ONLY"    => "로그인 링크를 이메일로 확인해 주세요.",
    "PASS_CODE_ONLY"     => "이메일로 전송된 코드를 입력해 주세요.",
    "PASS_BOTH"          => "로그인 링크를 이메일로 확인하거나 이메일로 전송된 코드를 입력해 주세요.",
    "PASS_VER_BUTTON"    => "코드 확인",
    "PASS_EMAIL_ONLY_MSG" => "아래 링크를 클릭하여 이메일 주소를 확인해 주세요.",
    "PASS_CODE_ONLY_MSG"  => "로그인하려면 아래 코드를 입력하세요.",
    "PASS_BOTH_MSG"       => "아래 링크를 클릭하여 이메일 주소를 확인하거나 아래 코드를 입력하여 로그인하세요.",
    "PASS_YOUR_CODE"      => "귀하의 인증 코드는: ",
    "PASS_CONFIRM_LOGIN"  => "로그인 확인",
    "PASS_CONFIRM_CLICK"  => "클릭하여 로그인 완료",
    "PASS_GENERIC_ERROR"  => "문제가 발생했습니다.",
));

// Signup
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"			=> "계정 만들기",
	"SIGNUP_BUTTONTEXT"		=> "나를 등록",
	"SIGNUP_AUDITTEXT"		=> "등록됨",
));

// Signin
$lang = array_merge($lang, array(
	"SIGNIN_FAIL"		=> "** 로그인하지 못했습니다 **",
	"SIGNIN_PLEASE_CHK" => "사용자 이름과 암호를 확인하고 다시 시도하세요",
	"SIGNIN_UORE"		=> "아이디 또는 이메일 주소",
	"SIGNIN_PASS"		=> "비밀번호",
	"SIGNIN_TITLE"		=> "로그인 해주세요",
	"SIGNIN_TEXT"		=> "로그인",
	"SIGNOUT_TEXT"		=> "로그아웃",
	"SIGNIN_BUTTONTEXT"	=> "로그인",
	/* doesn't translate directly. does the Remember Me feature remember username, password, or both? */
	"SIGNIN_REMEMBER"	=> "사용자 이름 저장",
	"SIGNIN_AUDITTEXT"	=> "로그인됨",
	"SIGNIN_FORGOTPASS"	=> "암호 찾기",
	"SIGNOUT_AUDITTEXT"	=> "로그아웃됨",
));

// Account Page
$lang = array_merge($lang, array(
	"ACCT_EDIT"				=> "계정 편집",
	"ACCT_2FA"				=> "2단계 인증 관리",
	"ACCT_SESS"				=> "세션 관리",
	"ACCT_HOME"				=> "계정 홈",
	"ACCT_SINCE"			=> "가입일",
	"ACCT_LOGINS"			=> "로그인 횟수",
	"ACCT_SESSIONS"			=> "활성 세션 수",
	"ACCT_MNG_SES"			=> "Click the Manage Sessions button in the left sidebar for more information.",
));

//General Terms
$lang = array_merge($lang, array(
	"GEN_ENABLED"		=> "사용",
	"GEN_DISABLED"		=> "사용 안 함",
	"GEN_ENABLE"		=> "사용 하다",
	"GEN_DISABLE"		=> "사용 중지",
	"GEN_NO"			=> "아니요",
	"GEN_YES"			=> "네",
	"GEN_MIN"			=> "최소",
	"GEN_MAX"			=> "최대",
	"GEN_CHAR"			=> "문자", //as in characters
	"GEN_SUBMIT"		=> "제출",
	"GEN_MANAGE"		=> "관리",
	"GEN_VERIFY"		=> "확인",
	"GEN_SESSION"		=> "세션",
	"GEN_SESSIONS"		=> "세션",
	"GEN_EMAIL"			=> "전자 메일 주소",
	"GEN_FNAME"			=> "이름",
	"GEN_LNAME"			=> "성",
	"GEN_UNAME"			=> "사용자 이름",
	"GEN_PASS"			=> "암호",
	"GEN_MSG"			=> "Message", //context?
	"GEN_TODAY"			=> "오늘",
	"GEN_CLOSE"			=> "닫기",
	"GEN_CANCEL"		=> "취소",
	"GEN_CHECK"			=> "[ 모두 선택|선택 취소 ]",
	"GEN_WITH"			=> "with", //context?
	"GEN_UPDATED"		=> "업데이트됨",
	"GEN_UPDATE"		=> "업데이트",
	"GEN_BY"			=> "by",
	"GEN_FUNCTIONS"		=> "함수",
	"GEN_NUMBER"		=> "number", //context?
	"GEN_NUMBERS"		=> "numbers", //context?
	"GEN_INFO"			=> "정보",
	"GEN_REC"			=> "녹화됨",
	"GEN_DEL"			=> "삭제",
	"GEN_NOT_AVAIL"		=> "사용 불가",
	"GEN_AVAIL"			=> "사용 가능한",
	"GEN_BACK"			=> "뒤로",
	"GEN_RESET"			=> "다시 설정",
	"GEN_REQ"			=> "필요한 공간",
	"GEN_AND"			=> "and", //context?
	"GEN_SAME"			=> "길이가 같아야 합니다",
));

$lang = array_merge($lang, array(
    "GEN_PASSKEY"           => "패스키",
    "GEN_ACTIONS"           => "작업",
    "GEN_BACK_TO_ACCT"      => "계정으로 돌아가기",
    "GEN_DB_ERROR"          => "데이터베이스 오류가 발생했습니다. 다시 시도해주세요.",
    "GEN_IMPORTANT"         => "중요",
    "GEN_NO_PERMISSIONS"    => "이 페이지에 접근할 권한이 없습니다.",
    "GEN_NO_PERMISSIONS_MSG" => "이 페이지에 접근할 권한이 없습니다. 오류라고 생각되시면 사이트 관리자에게 문의하세요.",
    "PASSKEYS_MANAGE_TITLE"                 => "패스키 관리",
    "PASSKEYS_LOGIN_TITLE"                  => "패스키로 로그인",
    "PASSKEY_DELETE_SUCCESS"                => "패스키가 성공적으로 삭제되었습니다.",
    "PASSKEY_DELETE_FAIL_DB"                => "데이터베이스에서 패스키 삭제에 실패했습니다.",
    "PASSKEY_DELETE_NOT_FOUND"              => "패스키를 찾을 수 없거나 삭제 권한이 없습니다.",
    "PASSKEY_NOTE_UPDATE_SUCCESS"           => "패스키 메모가 성공적으로 업데이트되었습니다.",
    "PASSKEY_NOTE_UPDATE_FAIL"              => "패스키 메모 업데이트에 실패했습니다.",
    "PASSKEY_REGISTER_NEW"                  => "새 패스키 등록",
    "PASSKEY_ERR_LIMIT_REACHED"             => "최대 10개의 패스키 한도에 도달했습니다.",
    "PASSKEY_NOTE_TH"                       => "패스키 메모",
    "PASSKEY_TIMES_USED_TH"                 => "사용 횟수",
    "PASSKEY_LAST_USED_TH"                  => "마지막 사용",
    "PASSKEY_LAST_IP_TH"                    => "마지막 IP",
    "PASSKEY_EDIT_NOTE_BTN"                 => "메모 편집",
    "PASSKEY_CONFIRM_DELETE_JS"             => "이 패스키를 삭제하시겠습니까?",
    "PASSKEY_EDIT_MODAL_TITLE"              => "패스키 메모 편집",
    "PASSKEY_EDIT_MODAL_LABEL"              => "패스키 메모",
    "PASSKEY_SAVE_CHANGES_BTN"              => "변경사항 저장",
    "PASSKEY_NONE_REGISTERED"               => "아직 등록된 패스키가 없습니다.",
    "PASSKEY_MUST_REGISTER_FIRST"           => "이 기능을 사용하기 전에 먼저 인증된 계정에서 패스키를 등록해야 합니다.",
    "PASSKEY_STORING"                       => "패스키 저장 중...",
    "PASSKEY_STORED_SUCCESS"                => "패스키가 성공적으로 저장되었습니다!",
    "PASSKEY_INVALID_ACTION"                => "잘못된 작업: ",
    "PASSKEY_NO_ACTION_SPECIFIED"           => "작업이 지정되지 않았습니다",
    "PASSKEY_DELETE_NOT_FOUND"              => "패스키를 찾을 수 없거나 권한이 거부되었습니다.",
    "PASSKEY_ERR_NETWORK_SUGGESTION"        => "네트워크 문제가 감지되었습니다. 다른 네트워크를 시도하거나 페이지를 새로고침하세요.",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION"   => "디바이스 간 인증이 감지되었습니다. 두 디바이스 모두 인터넷에 연결되어 있는지 확인하세요.",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE"  => "대신 휴대폰에서 직접 이 페이지를 열어보세요.",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"         => "진단을 생성할 수 없습니다: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"       => "저장에 필요한 자격 증명 데이터가 누락되었습니다.",
    "PASSKEY_MISSING_AUTH_DATA"             => "필요한 인증 데이터가 누락되었습니다.",
    "PASSKEY_LOG_NO_MESSAGE"                => "메시지 없음",
    "PASSKEY_USER_NOT_FOUND"                => "패스키 검증 후 사용자를 찾을 수 없습니다.",
    "PASSKEY_FATAL_ERROR"                   => "치명적 오류: ",
    "PASSKEY_LOGIN_SUCCESS"                 => "로그인 성공.",
    "PASSKEY_CROSS_DEVICE_PREP"             => "디바이스 간 등록을 준비 중입니다. 휴대폰이나 태블릿을 사용해야 할 수도 있습니다.",
    "PASSKEY_DEVICE_REGISTRATION"           => "디바이스 패스키 등록을 사용 중...",
    "PASSKEY_STARTING_REGISTRATION"         => "패스키 등록을 시작합니다...",
    "PASSKEY_REQUEST_OPTIONS"               => "서버에서 등록 옵션을 요청 중...",
    "PASSKEY_FOLLOW_PROMPTS"                => "패스키 생성을 위한 안내를 따르세요. 다른 디바이스를 사용해야 할 수도 있습니다.",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"         => "패스키를 생성하기 위한 안내를 따르세요...",
    "PASSKEY_CREATION_FAILED"               => "패스키 생성 실패 - 자격 증명이 반환되지 않았습니다.",
    "PASSKEY_STORING_SERVER"                => "패스키를 저장 중...",
    "PASSKEY_CREATED_SUCCESS"               => "패스키가 성공적으로 생성되었습니다!",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP"        => "디바이스 간 인증을 준비 중입니다. 휴대폰과 컴퓨터가 인터넷에 연결되어 있는지 확인하세요.",
    "PASSKEY_DEVICE_AUTH"                   => "디바이스 패스키 인증을 사용 중...",
    "PASSKEY_STARTING_AUTH"                 => "패스키 인증을 시작합니다...",
    "PASSKEY_QR_CODE_INSTRUCTION"           => "QR 코드가 나타나면 휴대폰으로 스캔하세요. 두 디바이스 모두 인터넷에 연결되어 있는지 확인하세요.",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"      => "안내가 나타나면 \"휴대폰 또는 태블릿 사용\"을 선택한 후 QR 코드를 스캔하세요.",
    "PASSKEY_AUTHENTICATING"                => "패스키로 인증 중...",
    "PASSKEY_SUCCESS_REDIRECTING"           => "인증 성공! 리디렉션 중...",
    "PASSKEY_TIMEOUT_CROSS_DEVICE"          => "등록 시간 초과. 디바이스 간 등록의 경우: 1) 다시 시도, 2) 디바이스가 인터넷에 연결되어 있는지 확인, 3) 휴대폰에서 직접 등록 고려.",
    "PASSKEY_TIMEOUT_SIMPLE"                => "등록 시간 초과. 다시 시도해주세요.",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"     => "디바이스 간 인증 시간 초과. 문제 해결: 1) 두 디바이스 모두 인터넷 필요, 2) QR 코드를 더 빨리 스캔해보세요, 3) 같은 디바이스 사용 고려, 4) 일부 네트워크는 디바이스 간 인증을 차단합니다.",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"           => "인증 시간 초과. 다시 시도해주세요.",
    "PASSKEY_NO_CREDENTIAL"                 => "자격 증명을 받지 못했습니다. 다시 시도 중...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"     => "인증 실패 - 자격 증명이 반환되지 않았습니다.",
    "PASSKEY_ATTEMPT_RETRY"                 => "실패. 다시 시도 중... (%d번의 시도 남음)",
    "PASSKEY_CROSS_DEVICE_FAILED"           => "디바이스 간 등록 실패. 시도해보세요: 1) 두 디바이스가 인터넷에 연결되어 있는지 확인, 2) 휴대폰에서 직접 등록 고려, 3) 일부 기업 네트워크는 이 기능을 차단합니다.",
    "PASSKEY_REGISTRATION_CANCELLED"        => "등록이 취소되었거나 디바이스가 패스키를 지원하지 않습니다.",
    "PASSKEY_NOT_SUPPORTED"                 => "이 디바이스/브라우저 조합에서는 패스키가 지원되지 않습니다.",
    "PASSKEY_SECURITY_ERROR"                => "보안 오류 - 일반적으로 도메인/원본 불일치를 나타냅니다.",
    "PASSKEY_ALREADY_EXISTS"                => "이 디바이스의 이 계정에 대해 패스키가 이미 존재합니다. 다른 디바이스를 사용하거나 기존 패스키를 먼저 삭제하세요.",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"      => "디바이스 간 인증 실패. 시도해보세요: 1) 두 디바이스가 안정적인 인터넷에 연결되어 있는지 확인, 2) 가능하면 같은 WiFi 네트워크 사용, 3) 대신 휴대폰에서 직접 인증 시도, 4) 일부 기업 네트워크는 이 기능을 차단합니다.",
    "PASSKEY_AUTH_CANCELLED"                => "인증이 취소되었거나 패스키가 선택되지 않았습니다.",
    "PASSKEY_NETWORK_ERROR"                 => "네트워크 오류. 디바이스 간 인증의 경우, 두 디바이스 모두 인터넷 접근이 필요하며 같은 네트워크에 있어야 할 수도 있습니다.",
    "PASSKEY_CREDENTIAL_NOT_FOUND"          => "인증 실패 - 자격 증명이 인식되지 않았습니다.",
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE"   => "디바이스 간 인증 팁:",
    "PASSKEY_GUIDANCE_INTERNET"             => "컴퓨터와 휴대폰 모두 인터넷에 연결되어 있는지 확인하세요",
    "PASSKEY_GUIDANCE_WIFI"                 => "같은 WiFi 네트워크에 있으면 도움이 될 수 있습니다 (항상 필요한 것은 아님)",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"        => "안내가 나타나면 \"휴대폰 또는 태블릿 사용\"을 선택하세요",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"         => "QR 코드가 나타나면 빠르게 스캔하세요",
    "PASSKEY_GUIDANCE_TRY_DIRECT"           => "실패하면 새로고침 후 휴대폰 브라우저에서 직접 사용해보세요",
    "PASSKEY_SHOW_TROUBLESHOOTING"          => "문제 해결 팁 보기",
    "PASSKEY_HIDE_TROUBLESHOOTING"          => "문제 해결 팁 숨기기",
    "PASSKEY_DIAGNOSTICS_RUNNING"           => "진단 실행 중...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"          => "진단 완료. 자세한 내용은 콘솔을 확인하세요.",
    "PASSKEY_ISSUES_DETECTED"               => "감지된 문제:",
    "PASSKEY_ENVIRONMENT_SUITABLE"          => "환경이 패스키에 적합해 보입니다.",
    "PASSKEY_DIAGNOSTICS_FAILED"            => "진단 실패:",
    "PASSKEY_ADD_NOTE_NEW"                  => "새 패스키에 메모 추가",
    "PASSKEY_BASE64_ERROR"                  => "Base64 디코드 오류:",
    "PASSKEY_INVALID_JSON"                  => "잘못된 JSON 데이터 수신:",
    "PASSKEY_NO_CHALLENGE_SESSION"          => "세션에서 패스키 등록 챌린지를 찾을 수 없습니다. 다시 등록해주세요.",
    "PASSKEY_USER_MISMATCH"                 => "사용자 ID 불일치. 다시 등록해주세요.",
    "PASSKEY_CHALLENGE_USER_MISMATCH"       => "챌린지 옵션의 사용자 ID가 현재 사용자와 일치하지 않습니다. 다시 등록해주세요.",
    "PASSKEY_REGISTRATION_FAILED_ERROR"     => "패스키 등록 실패. 디바이스와 브라우저가 WebAuthn을 지원하는지 확인한 후 다시 시도하세요. 오류:",
    "PASSKEY_NO_AUTH_CHALLENGE_SESSION"     => "세션에서 패스키 어설션 챌린지를 찾을 수 없습니다. 다시 로그인해주세요.",
    "PASSKEY_CREDENTIAL_NOT_IN_DB"          => "데이터베이스에서 패스키 자격 증명을 찾을 수 없습니다.",
    "PASSKEY_CREDENTIAL_WRONG_USER"         => "패스키 자격 증명이 예상된 사용자에게 속하지 않습니다.",
    "PASSKEY_VALIDATION_FAILED_ERROR"       => "패스키 검증 실패. 다시 시도하거나 문제가 지속되면 지원팀에 문의하세요. 오류:",
    "PASSKEY_USER_NOT_FOUND_REGISTRATION"   => "등록을 위한 사용자를 찾을 수 없습니다.",
    "PASSKEY_LOGIN_REQUIRED"        => "이 작업을 수행하려면 로그인해야 합니다.",
    "PASSKEY_ACTION_MISSING"        => "요청에서 필수 'action' 매개변수가 누락되었습니다.",
    "PASSKEY_STORAGE_FAILED"        => "패스키 저장에 실패했습니다. 작업이 성공하지 못했습니다.",
    "PASSKEY_LOGIN_FAILED"          => "패스키 로그인 실패. 인증을 확인할 수 없습니다.",
    "PASSKEY_INVALID_METHOD"        => "잘못된 요청 방법:",
    "CSRF_ERROR"                    => "CSRF 토큰 확인 실패. 뒤로 가서 양식을 다시 제출해주세요.",
    "PASSKEY_NETWORK_PRIVATE"       => "잠재적 문제: 개인 네트워크에 있는 것으로 보이며, 이는 때때로 디바이스 간 통신을 방해할 수 있습니다.",
    "PASSKEY_NETWORK_PROXY"         => "잠재적 문제: 프록시 또는 VPN이 감지되었습니다. 이는 디바이스 간 통신을 방해할 수 있습니다.",
    "PASSKEY_NETWORK_MOBILE"        => "참고: 모바일 네트워크에 있는 것으로 보입니다. 디바이스 간 작업을 위해 안정적인 연결을 확보하세요.",
    "PASSKEY_NETWORK_CORPORATE"     => "잠재적 문제: 기업 방화벽이 활성화되어 있을 수 있으며, 이는 디바이스 간 인증에 영향을 줄 수 있습니다.",
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE"   => "권장사항: 데스크톱을 사용하고 있는 것 같습니다. QR 코드를 스캔하기 위해 휴대폰을 사용할 준비를 하세요.",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK"   => "권장사항: 최상의 결과를 위해 컴퓨터와 모바일 디바이스가 같은 Wi-Fi 네트워크에 있는지 확인하세요.",
    "PASSKEY_RECOMMENDATION_QR_QUICK"       => "권장사항: 요청이 시간 초과될 수 있으므로 QR 코드를 빨리 스캔할 준비를 하세요.",
    "PASSKEY_RECOMMENDATION_INTERNET"       => "권장사항: 컴퓨터와 모바일 디바이스 모두 안정적인 인터넷 연결이 있는지 확인하세요.",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW"  => "권장사항: Unity WebView의 경우, 페이지가 패스키 요청을 로드하고 처리할 충분한 시간이 있는지 확인하세요.",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT"  => "권장사항: Unity에서는 시간 초과가 더 길 수 있습니다. 기다려주세요.",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL"   => "권장사항: 모바일에서 사용 중이므로 이 디바이스에 직접 패스키를 등록할 수 있어야 합니다.",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "권장사항: Android에서는 Google 비밀번호 관리자에서 패스키를 관리할 수 있습니다.",
    "PASSKEY_VALIDATION_RP_IP"                  => "설정 경고: 신뢰 당사자 ID가 IP 주소로 설정되어 있습니다.",
    "PASSKEY_VALIDATION_RP_DOMAIN"              => "권장사항: 더 나은 보안과 호환성을 위해 신뢰 당사자 ID를 도메인 이름(예: yourwebsite.com)으로 설정하세요.",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"         => "설정 오류: 라이브 서버에서 패스키가 작동하려면 HTTPS가 필요합니다. 사이트가 HTTP에 있는 것 같습니다.",
    "PASSKEY_VALIDATION_NETWORK"                => "네트워크 경고",
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK"  => "권장사항: 문제가 발생하면 다른 네트워크를 시도하세요(예: 기업 Wi-Fi에서 모바일 핫스팟으로 전환).",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET"  => "권장사항: 디바이스 간 작업의 경우, 두 디바이스 모두 안정적인 인터넷 연결이 있는지 확인하세요.",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"        => "권장사항: 디바이스 간 작업이 실패하면 모바일 디바이스에서 직접 이 페이지를 방문하여 작업을 완료하세요.",
    "PASSKEY_INFO_TITLE"           => "패스키 정보",
    "PASSKEY_INFO_DESC"            => "패스키는 지문, 얼굴 인식 또는 PIN과 같은 디바이스의 내장 보안 기능을 사용하여 비밀번호 없이 안전하게 로그인하는 방법입니다. 비밀번호보다 더 안전하고, 더 빠른 로그인을 제공하며, 비밀번호 관리자와 동기화될 때 디바이스 간에 작동하고, 피싱 공격에 저항력이 있습니다. 패스키는 최신 스마트폰, 태블릿, 컴퓨터에서 작동하며 1Password, Bitwarden, iCloud 키체인 또는 Google 비밀번호 관리자와 같은 비밀번호 관리자에 저장할 수 있습니다.",
    "PASSKEY_BACK_TO_LOGIN"                      => "로그인으로 돌아가기",
));
//validation class
$lang = array_merge($lang, array(
	"VAL_SAME"			=> "길이가 같아야 합니다",
	"VAL_EXISTS"		=> "이미 있습니다. 다른 값 주소를 선택하세요", //this doesn't translate well. verb-surbject-object order requires a generic object be used.
	"VAL_DB"			=> "데이터베이스 오류",
	"VAL_NUM"			=> "숫자여야 합니다",
	"VAL_INT"			=> "모두 숫자여야 합니다", //context? "은(는) 정수여야 합니다" might be more appropriate whether the value is printed back with it
	"VAL_EMAIL"			=> "유효한 전자 메일 주소여야 합니다",
	"VAL_NO_EMAIL"		=> "이메일 주소일 수 없습니다", //Papago
	"VAL_SERVER"		=> "must belong to a valid server", //context?
	"VAL_LESS"			=> "다음 값보다 짧아야 함니다",
	"VAL_GREAT"			=> "보다 커야 합니다",
	"VAL_LESS_EQ"		=> "다음 값보다 작거나 같아야 함니다",
	"VAL_GREAT_EQ"		=> "보다 크거나 같아야 합니다",
	"VAL_NOT_EQ"		=> "과(와) 같지 않아야 합니다", //this doesn't translate well in the expected order
	"VAL_EQ"			=> "과(와) 같아야 합니다", //this doesn't translate well in the expected order
	"VAL_TZ"			=> "이 데이터는 유효한 시간대 이름이어야 합니다.", //no idea
	"VAL_MUST"			=> "이 값은 다음과 같아야 합니다", //no idea
	"VAL_MUST_LIST"		=> "다음 중 하나여야 합니다",
	"VAL_TIME"			=> "유효한 시간이어야 합니다",
	"VAL_SEL"			=> "경로는 선택할 수 없습니다",
	"VAL_NA_PHONE"		=> "올바른 전화 번호여야 합니다 (북아메리카)", //not a 1:1 translation
));

//Time
$lang = array_merge($lang, array(
	"T_YEARS"		=> "년도",
	"T_YEAR"		=> "년도",
	"T_MONTHS"		=> "월",
	"T_MONTH"		=> "월", //unless you mean which month specifically (Jan, Feb, Mar, etc.)
	"T_WEEKS"		=> "주",
	"T_WEEK"		=> "주",
	"T_DAYS"		=> "날",
	"T_DAY"			=> "날",
	"T_HOURS"		=> "시",
	"T_HOUR"		=> "시",
	"T_MINUTES"		=> "분",
	"T_MINUTE"		=> "분",
	"T_SECONDS"		=> "초",
	"T_SECOND"		=> "초",
));


//Passwords
$lang = array_merge($lang, array(
	"PW_NEW"		=> "새 비밀번호",
	"PW_OLD"		=> "기존 비밀번호",
	"PW_CONF"		=> "비밀번호 확인",
	"PW_RESET"		=> "비밀번호 재설정",
	"PW_UPD"		=> "비밀번호 업데이트",
	"PW_SHOULD"		=> "비밀번호는 반드시",
	"PW_SHOW"		=> "비밀번호 표시",
	"PW_SHOWS"		=> "비밀번호 표시",
));


//Join
$lang = array_merge($lang, array(
	"JOIN_SUC"		=> "시작 - ",
	"JOIN_THANKS"	=> "제품을 등록해주셔서 감사합니다.",
	"JOIN_HAVE"		=> "이상이어야 합니다 ", //papago
	"JOIN_LOWER"	=> "영문 소문자",
	"JOIN_SYMBOL"		=> "기호",
	"JOIN_CAP"		=> " 영문 대문자",
	"JOIN_TWICE"	=> "암호가 일치해야 합니다", //assuming these are passwords
	"JOIN_CLOSED"	=> "등록이 비활성화됨. 질문이나 우려 사항이 있으면 사이트 관리자에게 문의하십시오.",
	"JOIN_TC"		=> "사용 약관",
	"JOIN_ACCEPTTC" => "사용 약관에 동의합니다",
	"JOIN_CHANGED"	=> "약관이 변경되었습니다.",
	"JOIN_ACCEPT" 	=> "사용자 이용약관에 동의하고 계속하기",
	"JOIN_SCORE" => "점수:",
	"JOIN_INVALID_PW" => "비밀번호가 유효하지 않습니다",

));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"		=> " 종료함",
));

//Messages
$lang = array_merge($lang, array(
	"MSG_SENT"		=> "메시지를 보냈습니다.",
	"MSG_MASS"		=> "그룹 메시지 보냈습니다.",
	"MSG_NEW"		=> "새 메시지",
	"MSG_NEW_MASS"	=> "새 그룹 메시지",
	"MSG_CONV"		=> "대화",
	"MSG_NO_CONV"	=> "대화 없음",
	"MSG_NO_ARC"	=> "대화 없음",
	"MSG_QUEST"		=> "이메일 알림 발송?",
	"MSG_ARC"		=> "보관된 스레드",
	"MSG_VIEW_ARC"	=> "보관된 스레드 보기",
	"MSG_SETTINGS"  => "메시지 설정",
	"MSG_READ"		=> "읽다", //context?
	"MSG_BODY"		=> "본문",
	"MSG_SUB"		=> "제목",
	"MSG_DEL"		=> "배달됨",
	"MSG_REPLY"		=> "회신",
	"MSG_QUICK"		=> "빠른 회신",
	"MSG_SELECT"	=> "사용자 선택",
	"MSG_UNKN"		=> "알 수 없는 수신자",
	"MSG_NOTIF"		=> "전자 메일 알림",
	"MSG_BLANK"		=> "메시지는 비워둘 수 없습니다",
	"MSG_MODAL"		=> "여기를 클릭하거나, <Alt>   <ㄱ>를 눌러 이 상자에 초점을 맞추거나, <Shift>   <ㄱ>를 눌러 확장된 응답 창을 엽니다", //way past my ability
	"MSG_ARCHIVE_SUCCESSFUL"        => "%m1% 스레드를 성공적으로 보관했습니다.", //way past my ability
	"MSG_UNARCHIVE_SUCCESSFUL"      => "%m1% 스레드를 성공적으로 보관 해제했습니다.", //way past my ability
	"MSG_DELETE_SUCCESSFUL"         => "%m1% 스레드를 삭제했습니다.", //way past my ability
	"USER_MESSAGE_EXEMPT"         			=> "사용자는 메시지에서 %m1% 면제됩니다.", //way past my ability
	"MSG_MK_READ"	=> "확인함",
	"MSG_MK_UNREAD"	=> "읽지 않은",
	"MSG_ARC_THR"	=> "선택한 항목 보관",
	"MSG_UN_THR"	=> "Unarchive Selected Threads", //no idea
	"MSG_DEL_THR"	=> "선택한 항목 삭제",
	"MSG_SEND"		=> "메시지 보내기",
));

$lang = array_merge($lang, array(
    "2FA"               => "2단계 인증",
    "2FA_CONF"  => "2FA를 비활성화하시겠습니까? 계정이 더 이상 보호되지 않습니다.",
    "2FA_SCAN"  => "인증 앱으로 이 QR 코드를 스캔하거나 키를 입력하세요",
    "2FA_THEN"  => "그런 다음 일회용 패스키 중 하나를 여기에 입력하세요",
    "2FA_FAIL"  => "2FA 확인에 문제가 있었습니다. 인터넷을 확인하거나 지원팀에 문의하세요.",
    "2FA_CODE"  => "2FA 코드",
    "2FA_EXP"       => "만료된 지문 1개",
    "2FA_EXPD"  => "만료됨",
    "2FA_EXPS"  => "만료됨",
    "2FA_ACTIVE" => "활성 세션",
    "2FA_NOT_FN" => "지문을 찾을 수 없음",
    "2FA_FP"        => "지문",
    "2FA_NP"        => "로그인 실패 - 2단계 인증 코드가 없습니다. 다시 시도해주세요.",
    "2FA_INV"       => "로그인 실패 - 2단계 인증 코드가 잘못되었습니다. 다시 시도해주세요.",
    "2FA_FATAL" => "치명적 오류 - 시스템 관리자에게 문의하세요. 현재 2단계 인증 코드를 생성할 수 없습니다.",
    "2FA_SECTION_TITLE"                    => "2단계 인증 (TOTP)",
    "2FA_SK_ALT"                          => "QR 코드를 스캔할 수 없으면 이 비밀 키를 인증 앱에 수동으로 입력하세요.",
    "2FA_IS_ENABLED"                       => "2단계 인증이 계정을 보호하고 있습니다.",
    "2FA_NOT_ENABLED_INFO"                 => "2단계 인증이 현재 활성화되지 않았습니다.",
    "2FA_NOT_ENABLED_EXPLAIN"              => "2단계 인증(TOTP)은 비밀번호 외에 휴대폰의 인증 앱 코드를 요구하여 계정에 추가 보안 계층을 제공합니다.",
    "2FA_SETUP_TITLE"                      => "2단계 인증 설정",
    "2FA_SECRET_KEY_LABEL"                 => "비밀 키:",
    "2FA_SETUP_VERIFY_CODE_LABEL"          => "앱에서 확인 코드 입력",
    "2FA_SUCCESS_ENABLED_TITLE"            => "2단계 인증이 활성화되었습니다! 백업 코드를 저장하세요",
    "2FA_SUCCESS_ENABLED_INFO"             => "아래는 백업 코드입니다. 안전하게 저장하세요 - 각각 한 번만 사용할 수 있습니다.",
    "2FA_BACKUP_CODES_WARNING"             => "이 코드들을 비밀번호처럼 취급하세요. 안전하게 저장하세요.",
    "2FA_SUCCESS_BACKUP_REGENERATED"       => "새 백업 코드가 생성되었습니다. 안전하게 저장하세요.",
    "2FA_BACKUP_CODE_LABEL"                => "백업 코드",
    "2FA_REGEN_CODES_BTN"                  => "백업 코드 재생성",
    "2FA_INVALIDATE_WARNING"            => "이렇게 하면 기존의 모든 백업 코드가 무효화됩니다. 확실합니까?",
    "2FA_CODE_LABEL"                       => "인증 코드",
    "2FA_VERIFY_BTN"                       => "확인 및 로그인",
    "2FA_VERIFY_TITLE"                     => "2단계 인증 필요",
    "2FA_VERIFY_INFO"                      => "인증 앱에서 6자리 코드를 입력하세요.",
    "2FA_ENABLE_BTN"                       => "2단계 인증 활성화",
    "2FA_DISABLE_BTN"                       => "2단계 인증 비활성화",
    "2FA_VERIFY_ACTIVATE_BTN"              => "확인 및 활성화",
    "2FA_CANCEL_SETUP_BTN"                 => "설정 취소",
    "2FA_DONE_BTN"                         => "완료",
    "REDIR_2FA_DIS"                 => "2단계 인증이 비활성화되었습니다.",
    "2FA_SUCCESS_BACKUP_ACK"               => "백업 코드가 확인되었습니다.",
    "2FA_SUCCESS_SETUP_CANCELLED"          => "설정이 취소되었습니다.",
    "2FA_ERR_INVALID_BACKUP"               => "잘못된 백업 코드. 다시 시도해주세요.",
    "2FA_ERR_DISABLE_FAILED"               => "2단계 인증 비활성화에 실패했습니다.",
    "2FA_ERR_NO_SECRET"                    => "인증 비밀을 검색할 수 없습니다. 다시 시도해주세요.",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"       => "백업 코드는 확인되었지만 무효화에 실패했습니다. 지원팀에 문의하세요.",
    "2FA_ERR_NO_CODE_PROVIDED"             => "인증 코드가 제공되지 않았습니다.",
    "RATE_LIMIT_LOGIN"              => "로그인 시도 실패가 너무 많습니다. 다시 시도하기 전에 기다려주세요.",
    "RATE_LIMIT_TOTP"               => "잘못된 인증 코드가 너무 많습니다. 다시 시도하기 전에 기다려주세요.",
    "RATE_LIMIT_PASSKEY"            => "패스키 인증 시도가 너무 많습니다. 다시 시도하기 전에 기다려주세요.",
    "RATE_LIMIT_PASSKEY_STORE"      => "패스키 등록 시도가 너무 많습니다. 다시 시도하기 전에 기다려주세요.",
    "RATE_LIMIT_PASSWORD_RESET"     => "비밀번호 재설정 요청이 너무 많습니다. 다른 재설정을 요청하기 전에 기다려주세요.",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT" => "비밀번호 재설정 시도가 너무 많습니다. 다시 시도하기 전에 기다려주세요.",
    "RATE_LIMIT_REGISTRATION"       => "등록 시도가 너무 많습니다. 다시 시도하기 전에 기다려주세요.",
    "RATE_LIMIT_EMAIL_VERIFICATION" => "이메일 확인 요청이 너무 많습니다. 다른 확인을 요청하기 전에 기다려주세요.",
    "RATE_LIMIT_EMAIL_CHANGE"       => "이메일 변경 요청이 너무 많습니다. 다시 시도하기 전에 기다려주세요.",
    "RATE_LIMIT_PASSWORD_CHANGE"    => "비밀번호 변경 시도가 너무 많습니다. 다시 시도하기 전에 기다려주세요.",
    "RATE_LIMIT_GENERIC"            => "시도가 너무 많습니다. 다시 시도하기 전에 기다려주세요.",
));


$lang = array_merge($lang, array(
	"REDIR_2FA"				=> "%EC%A3%84%EC%86%A1%ED%95%A9%EB%8B%88%EB%8B%A4. %EC%A7%80%EA%B8%88%EC%9D%80 2%EB%8B%A8%EA%B3%84 %EC%9D%B8%EC%A6%9D%EC%9D%84 %EC%82%AC%EC%9A%A9%ED%95%A0 %EC%88%98 %EC%97%86%EC%8A%B5%EB%8B%88%EB%8B%A4.", //assuming you want a URL encode here
	"REDIR_2FA_EN"			=> "2%EB%8B%A8%EA%B3%84 %EC%9D%B8%EC%A6%9D%EC%9D%84 %EC%82%AC%EC%9A%A9%ED%95%A0 %EC%88%98 %EC%9E%88%EC%8A%B5%EB%8B%88%EB%8B%A4.",
	"REDIR_2FA_DIS"			=> "2%EB%8B%A8%EA%B3%84%20%EC%9D%B8%EC%A6%9D%EC%9D%84%20%EC%82%AC%EC%9A%A9%ED%95%A0%20%EC%88%98%20%EC%97%86%EC%8A%B5%EB%8B%88%EB%8B%A4.",
	"REDIR_2FA_VER"			=> "2%EB%8B%A8%EA%B3%84 %EC%9D%B8%EC%A6%9D %ED%99%95%EC%9D%B8 %EB%B0%8F %EC%82%AC%EC%9A%A9 %EA%B0%80%EB%8A%A5.",
	"REDIR_SOMETHING_WRONG" 	=> "%EB%AD%94%EA%B0%80 %EC%9E%98%EB%AA%BB%EB%90%90%EC%96%B4%EC%9A%94. %EB%8B%A4%EC%8B%9C %EC%8B%9C%EB%8F%84%ED%95%98%EC%8B%AD%EC%8B%9C%EC%98%A4.",
	"REDIR_MSG_NOEX"		=> "%ED%95%B4%EB%8B%B9 %ED%94%84%EB%A1%9C%EC%84%B8%EC%8A%A4 %EC%8A%A4%EB%A0%88%EB%93%9C%EB%8A%94 %EC%82%AC%EC%9A%A9%EC%9E%90%EC%9D%98 %EA%B2%83%EC%9D%B4 %EC%95%84%EB%8B%88%EA%B1%B0%EB%82%98 %EC%A1%B4%EC%9E%AC%ED%95%98%EC%A7%80 %EC%95%8A%EC%8A%B5%EB%8B%88%EB%8B%A4.",
	"REDIR_UN_ONCE"			=> "%EC%82%AC%EC%9A%A9%EC%9E%90 %EC%9D%B4%EB%A6%84%EC%9D%B4 %EC%9D%B4%EB%AF%B8 %ED%95%9C %EB%B2%88 %EB%B3%80%EA%B2%BD%EB%90%98%EC%97%88%EC%8A%B5%EB%8B%88%EB%8B%A4.",
	"REDIR_EM_SUCC"			=> "%EC%A0%84%EC%9E%90 %EB%A9%94%EC%9D%BC %EC%A3%BC%EC%86%8C%EA%B0%80 %EC%97%85%EB%8D%B0%EC%9D%B4%ED%8A%B8%EB%90%98%EC%97%88%EC%8A%B5%EB%8B%88%EB%8B%A4.",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "다음으로 로그인:",
	"EML_FEATURE_DISABLED" => "이 기능은 비활성화되었습니다",
	"EML_PASSWORDLESS_SENT" => "로그인 링크를 이메일에서 확인하세요.",
	"EML_PASSWORDLESS_SUBJECT" => "로그인하려면 이메일을 확인하세요.",
	"EML_PASSWORDLESS_BODY" => "아래 링크를 클릭하여 이메일 주소를 확인하세요. 자동으로 로그인됩니다.",

	"EML_CONF"			=> "전자 메일 주소 확인",
	"EML_VER"			=> "전자 메일 확인",
	"EML_CHK"			=> "전자 메일 요청이 수신되었습니다. 확인을 수행하려면 전자 메일을 확인하십시오. 다음 날짜에 확인 링크가 만료되면 스팸 및 정크 폴더를 확인하십시오.", //impossible to translate correctly in this order?
	"EML_MAT"			=> "이메일 주소가 일치하지 않습니다.",
	"EML_HELLO"			=> "에서 안녕하세요 ", //doesn't work in this order?
	"EML_HI"			=> "안녕하세요 ",
	"EML_AD_HAS"		=> "관리자가 암호를 재설정했습니다.",
	"EML_AC_HAS"		=> "관리자가 계정을 만들었습니다.",
	"EML_REQ"			=> "위의 링크를 사용하여 암호를 설정해야 합니다.",
	"EML_EXP"			=> "암호 링크는 다음 날짜에 만료됩니다. ", //impossible to translate in this order?
	"EML_VER_EXP"		=> "확인 링크는 다음 날짜에 만료됩니다. ", //impossible to translate in this order?
	"EML_CLICK"			=> "로그인하려면 여기 클릭.",
	"EML_REC"			=> "로그인할 때 암호를 변경하는 것이 좋습니다.",
	"EML_MSG"			=> "새 메시지가 있습니다 ", //name probably should come first
	"EML_REPLY"			=> "답장하거나 스레드를 보려면 여기를 클릭하십시오.",
	"EML_WHY"			=> "암호 재설정 요청이 있어 이 이메일을 수신합니다. 이것이 당신이 아니라면, 당신은 이 이메일을 무시해야 합니다.",
	"EML_HOW"			=> "사용자인 경우 아래 링크를 클릭하여 암호 재설정 프로세스를 계속하십시오.",
	"EML_EML"			=> "사용자 계정 내에서 전자 메일 주소 변경 요청이 수행되었습니다.",
	"EML_VER_EML"		=> "가입해 주셔서 감사합니다.  이메일 주소를 확인하면 로그인할 준비가 됩니다! 아래 링크를 클릭하여 이메일 주소를 확인하십시오.",

));

//Verification
$lang = array_merge($lang, array(
	"VER_SUC"		=> "이메일이 확인되었습니다!",
	"VER_FAIL"		=> "계정을 확인할 수 없습니다. 다시 시도하십시오.",
	"VER_RESEND"	=> "확인 이메일을 다시 보내",
	"VER_AGAIN"		=> "이메일 주소를 입력하고 다시 시도하십시오.",
	"VER_PAGE"		=> "<li>이메일을 확인하고 사용자에게 전송된 링크를 클릭합니다</li><li>완료</li>",
	"VER_RES_SUC" 	=> " 확인 링크가 전자 메일 주소로 전송되었습니다.  전자 메일의 링크를 클릭하여 확인을 완료합니다. 전자 메일이 받은 편지함에 없으면 스팸 폴더를 확인하십시오.  확인 링크는 0분 동안만 유효합니다",
	"VER_OOPS"		=> "오류가 발생했습니다. 이전 암호 재설정 링크가 클릭되었을 수 있습니다. 다시 시도하려면 아래를 클릭하십시오.",
	"VER_RESET"		=> "암호가 재설정되었습니다!",
	"VER_INS"		=> "<li>전자 메일 주소를 입력하고 재설정 단추를 클릭합니다.</li> <li>이메일을 확인하고 사용자에게 전송된 링크를 클릭합니다.</li>
										<li>화면에 나타나는 지침을 따릅니다.</li>",
	"VER_SENT"		=> " 암호 재설정 링크가 사용자의 전자 메일 주소로 전송되었습니다. 
	    							 전자 메일의 링크를 클릭하여 암호를 재설정합니다. 전자 메일이 받은 편지함에 없으면 스팸 폴더를 확인하십시오.  재설정 링크는 0분 동안만 유효합니다",
	"VER_PLEASE"	=> "암호를 재설정하십시오",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"			=> "PIN 초기화",
	"SET_WHY"			=> "왜 이걸 바꿀 수 없나요?",
	"SET_PW_MATCH"		=> "새 암호와 일치해야 합니다.",

	"SET_PIN_NEXT"		=> "다음에 확인이 필요할 때 새 PIN을 설정할 수 있습니다.",
	"SET_UPDATE"		=> "사용자 설정을 업데이트합니다.",
	"SET_NOCHANGE"		=> "관리자가 사용자 이름 변경을 사용 불가능으로 설정했습니다.",
	"SET_ONECHANGE"		=> "관리자가 사용자 이름 변경을 한 번만 수행하도록 설정했으며 사용자가 이미 변경했습니다.",

	"SET_GRAVITAR"		=> "프로필 사진을 바꾸고 싶으신가요?  <br> <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a>을 방문하여 이 사이트에서 사용한 것과 동일한 전자 메일로 계정을 설정하십시오. 수백만 개의 사이트에서 작동합니다. 그것은 빠르고 쉽습니다!",

	"SET_NOTE1"			=> " 부디 참고하세요  이메일을 업데이트하기 위한 보류 중인 요청이 있습니다. 으로", //the order in this translation doesn't match

	"SET_NOTE2"			=> ".  확인 이메일을 사용하여 이 요청을 완료하십시오. 
	 새 확인 이메일이 필요한 경우 위의 이메일을 다시 입력하고 요청을 다시 제출하십시오. ",

	"SET_PW_REQ" 		=> "암호, 전자 메일 또는 PIN을 재설정하는 데 필요합니다",
	"SET_PW_REQI" 		=> "암호를 변경하는 데 필요합니다",

));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"		=> "활성 세션을 종료하지 못했습니다. 오류: ",
	"ERR_EMAIL"			=> "오류로 인해 전자 메일이 전송되지 않습니다. 사이트 관리자에게 문의하십시오.",
	"ERR_EM_DB"			=> "해당 전자 메일 주소가 데이터베이스에 없습니다.",
	"ERR_TC"			=> "약관을 읽고 동의하십시오.",
	"ERR_CAP"			=> "캡차 테스트를 통과하지 못했습니다. 당신은 로봇이에요!",
	"ERR_PW_SAME"		=> "이전 암호는 새 암호와 같을 수 없습니다.",
	"ERR_PW_FAIL"		=> "현재 암호를 확인하지 못했습니다. 업데이트에 실패했습니다. 다시 시도하십시오.",
	"ERR_GOOG"			=> "메모  원래 Google 또는 Facebook 계정으로 등록한 경우 암호를 변경하려면 암호 분실 링크를 사용해야 합니다.",
	"ERR_EM_VER"		=> "전자 메일 확인이 활성화되지 않았습니다. 시스템 관리자에게 문의하십시오.",
	"ERR_EMAIL_STR"		=> "뭔가 잘못됐어요. 전자 메일을 다시 확인하십시오. 불편을 드려 죄송합니다.",

));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"		=> "그 웹사이트는 곧 다시 온라인 상태가 될 것입니다!",
	"MAINT_MSG"			=> "불편을 끼쳐 드려 죄송합니다만, 현재 약간의 정비를 진행하고 있습니다<br>곧 다시 접속하겠습니다!",
	"MAINT_BAN"			=> "죄송합니다. 금지되었습니다. 오류가 발생한 경우 관리자에게 문의하십시오.",
	"MAINT_TOK"			=> "양식에 오류가 있습니다. 돌아가서 다시 시도하십시오. 페이지를 새로 고쳐서 양식을 제출하면 오류가 발생합니다. 이 문제가 계속 발생하면 관리자에게 문의하십시오.",
	"MAINT_OPEN"		=> "오픈 소스 PHP 사용자 관리 프레임워크",
	"MAINT_PLEASE"		=> "UserSpice가 성공적으로 설치되었습니다!<br>시작 설명서를 보려면 아래 링크를 클릭하십시오"
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
	"DAT_SEARCH"    	=> "검색",
	"DAT_FIRST" 	    => "첫 번째 결과",
	"DAT_LAST"      	=> "마지막 결과",
	"DAT_NEXT"      	=> "다음 결과",
	"DAT_PREV"      	=> "이전 결과",
	"DAT_NODATA"        => "데이터베이스 테이블에 사용할 수 있는 데이터가 없습니다.",
	"DAT_INFO"          => "_TOTAL_개 항목 중 _START_~_END_개를 표시합니다",
	"DAT_ZERO"          => "0개 항목 중 0~0개를 표시합니다",
	"DAT_FILTERED"      => "(총 _MAX_개 항목에서 제외)",
	"DAT_MENU_LENG"     => "_MENU_개의 항목을 표시합니다",
	"DAT_LOADING"       => "불러오는 중...",
	"DAT_PROCESS"       => "처리 중...",
	"DAT_NO_REC"        => "일치하는 레코드를 찾을 수 없음",
	"DAT_ASC"           => "열을 오름차순으로 정렬하려면 클릭하십시오.",
	"DAT_DESC"          => "열을 내림차순으로 정렬하려면 클릭하십시오.",
));


///////////////////////////////////////////////////////////////

//Backend Translations for UserSpice
$lang = array_merge($lang, array(
	"BE_DASH"    			=> "대시보드",
	"BE_SETTINGS"     		=> "설정",
	"BE_GEN"				=> "일반",
	"BE_REG"				=> "등록",
	"BE_CUS"				=> "사용자 지정 설정",
	"BE_DASH_ACC"			=> "대시보드에 액세스",
	"BE_TOOLS"				=> "도구",
	"BE_BACKUP"				=> "백업",
	"BE_UPDATE"				=> "업데이트",
	"BE_CRON"				=> "크론 잡스",
	"BE_IP"				  	=> "IP 주소 관리자입니다.",
));

//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
 //do not put a closing php tag here
