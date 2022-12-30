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
	"THIS_LANGUAGE"	=>"한국어",
	"THIS_CODE"		=>"ko-KR",
	"MISSING_TEXT"	=>"누락된 텍스트",
));

	//Database Menus
$lang = array_merge($lang,array(
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

	// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"			=> "계정 만들기",
	"SIGNUP_BUTTONTEXT"		=> "나를 등록",
	"SIGNUP_AUDITTEXT"		=> "등록됨",
	));

	// Signin
$lang = array_merge($lang,array(
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
$lang = array_merge($lang,array(
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
$lang = array_merge($lang,array(
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

	//validation class
$lang = array_merge($lang,array(
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
$lang = array_merge($lang,array(
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
$lang = array_merge($lang,array(
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
$lang = array_merge($lang,array(
	"JOIN_SUC"		=> "시작 - ",
	"JOIN_THANKS"	=> "제품을 등록해주셔서 감사합니다.",
	"JOIN_HAVE"		=> "이상이어야 합니다 ", //papago
	"JOIN_CAP"		=> " 영문 대문자",
	"JOIN_TWICE"	=> "암호가 일치해야 합니다", //assuming these are passwords
	"JOIN_CLOSED"	=> "등록이 비활성화됨. 질문이나 우려 사항이 있으면 사이트 관리자에게 문의하십시오.",
	"JOIN_TC"		=> "사용 약관",
	"JOIN_ACCEPTTC" => "사용 약관에 동의합니다",
	"JOIN_CHANGED"	=> "약관이 변경되었습니다.",
	"JOIN_ACCEPT" 	=> "사용자 이용약관에 동의하고 계속하기",
	));

	//Sessions
$lang = array_merge($lang,array(
	"SESS_SUC"		=> " 종료함",
	));

	//Messages
$lang = array_merge($lang,array(
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
	"MSG_MODAL"		=> "여기를 클릭하거나, <Alt> + <ㄱ>를 눌러 이 상자에 초점을 맞추거나, <Shift> + <ㄱ>를 눌러 확장된 응답 창을 엽니다", //way past my ability
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

	//2 Factor Authentication
$lang = array_merge($lang,array(
	"2FA"			=> "2단계 인증",
	"2FA_CONF"		=> "2단계 인증을 사용하지 않도록 설정하시겠습니까? 계정이 더 이상 보호되지 않습니다.", //papago
	"2FA_SCAN"		=> "인증 앱으로 이 QR 코드를 스캔하거나 키를 입력하십시오.", //papago
	"2FA_THEN"		=> "이제 여기에 일회용 암호 중 하나를 입력하십시오.", //papago
	"2FA_FAIL"		=> "2단계 인증을 확인하는 동안 문제가 발생했습니다. 인터넷 연결을 확인하거나 지원부에 문의하십시오.",
	"2FA_CODE"		=> "2단계 인증 코드",
	"2FA_EXP"		=> "Expired 1 fingerprint", //what?
	"2FA_EXPD"		=> "기한이 지났습니다",
	"2FA_EXPS"		=> "그것은 에 만료됩니다",
	"2FA_ACTIVE"	=> "활성 세션",
	"2FA_NOT_FN"	=> "지문을 찾을 수 없습니다",
	"2FA_FP"		=> "Fingerprints", //what?
	"2FA_NP"		=> "<strong>로그인 실패</strong> 2단계 인증 코드가 제공되지 않았습니다. 다시 시도하십시오.",
	"2FA_INV"		=> "<strong>로그인 실패</strong> 2단계 인증 코드가 잘못되었습니다. 다시 시도하십시오.",
	"2FA_FATAL"		=> "<strong>오류</strong> 시스템 관리자에게 문의하십시오.",
	));

	//Redirect Messages - These get a plus between each word
$lang = array_merge($lang,array(
	"REDIR_2FA"				=> "%EC%A3%84%EC%86%A1%ED%95%A9%EB%8B%88%EB%8B%A4.+%EC%A7%80%EA%B8%88%EC%9D%80+2%EB%8B%A8%EA%B3%84+%EC%9D%B8%EC%A6%9D%EC%9D%84+%EC%82%AC%EC%9A%A9%ED%95%A0+%EC%88%98+%EC%97%86%EC%8A%B5%EB%8B%88%EB%8B%A4.", //assuming you want a URL encode here
	"REDIR_2FA_EN"			=> "2%EB%8B%A8%EA%B3%84+%EC%9D%B8%EC%A6%9D%EC%9D%84+%EC%82%AC%EC%9A%A9%ED%95%A0+%EC%88%98+%EC%9E%88%EC%8A%B5%EB%8B%88%EB%8B%A4.",
	"REDIR_2FA_DIS"			=> "2%EB%8B%A8%EA%B3%84%20%EC%9D%B8%EC%A6%9D%EC%9D%84%20%EC%82%AC%EC%9A%A9%ED%95%A0%20%EC%88%98%20%EC%97%86%EC%8A%B5%EB%8B%88%EB%8B%A4.",
	"REDIR_2FA_VER"			=> "2%EB%8B%A8%EA%B3%84+%EC%9D%B8%EC%A6%9D+%ED%99%95%EC%9D%B8+%EB%B0%8F+%EC%82%AC%EC%9A%A9+%EA%B0%80%EB%8A%A5.",
	"REDIR_SOM_TING_WONG" 	=> "%EB%AD%94%EA%B0%80+%EC%9E%98%EB%AA%BB%EB%90%90%EC%96%B4%EC%9A%94.+%EB%8B%A4%EC%8B%9C+%EC%8B%9C%EB%8F%84%ED%95%98%EC%8B%AD%EC%8B%9C%EC%98%A4.",
	"REDIR_MSG_NOEX"		=> "%ED%95%B4%EB%8B%B9+%ED%94%84%EB%A1%9C%EC%84%B8%EC%8A%A4+%EC%8A%A4%EB%A0%88%EB%93%9C%EB%8A%94+%EC%82%AC%EC%9A%A9%EC%9E%90%EC%9D%98+%EA%B2%83%EC%9D%B4+%EC%95%84%EB%8B%88%EA%B1%B0%EB%82%98+%EC%A1%B4%EC%9E%AC%ED%95%98%EC%A7%80+%EC%95%8A%EC%8A%B5%EB%8B%88%EB%8B%A4.",
	"REDIR_UN_ONCE"			=> "%EC%82%AC%EC%9A%A9%EC%9E%90+%EC%9D%B4%EB%A6%84%EC%9D%B4+%EC%9D%B4%EB%AF%B8+%ED%95%9C+%EB%B2%88+%EB%B3%80%EA%B2%BD%EB%90%98%EC%97%88%EC%8A%B5%EB%8B%88%EB%8B%A4.",
	"REDIR_EM_SUCC"			=> "%EC%A0%84%EC%9E%90+%EB%A9%94%EC%9D%BC+%EC%A3%BC%EC%86%8C%EA%B0%80+%EC%97%85%EB%8D%B0%EC%9D%B4%ED%8A%B8%EB%90%98%EC%97%88%EC%8A%B5%EB%8B%88%EB%8B%A4.",
	));

	//Emails
$lang = array_merge($lang,array(
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
$lang = array_merge($lang,array(
	"VER_SUC"		=> "이메일이 확인되었습니다!",
	"VER_FAIL"		=> "계정을 확인할 수 없습니다. 다시 시도하십시오.",
	"VER_RESEND"	=> "확인 이메일을 다시 보내",
	"VER_AGAIN"		=> "이메일 주소를 입력하고 다시 시도하십시오.",
	"VER_PAGE"		=> "<li>이메일을 확인하고 사용자에게 전송된 링크를 클릭합니다</li><li>완료</li>",
	"VER_RES_SUC" 	=> "<p>확인 링크가 전자 메일 주소로 전송되었습니다.</p><p>전자 메일의 링크를 클릭하여 확인을 완료합니다. 전자 메일이 받은 편지함에 없으면 스팸 폴더를 확인하십시오.</p><p>확인 링크는 0분 동안만 유효합니다",
	"VER_OOPS"		=> "오류가 발생했습니다. 이전 암호 재설정 링크가 클릭되었을 수 있습니다. 다시 시도하려면 아래를 클릭하십시오.",
	"VER_RESET"		=> "암호가 재설정되었습니다!",
	"VER_INS"		=> "<li>전자 메일 주소를 입력하고 재설정 단추를 클릭합니다.</li> <li>이메일을 확인하고 사용자에게 전송된 링크를 클릭합니다.</li>
										<li>화면에 나타나는 지침을 따릅니다.</li>",
	"VER_SENT"		=> "<p>암호 재설정 링크가 사용자의 전자 메일 주소로 전송되었습니다.</p>
	    							<p>전자 메일의 링크를 클릭하여 암호를 재설정합니다. 전자 메일이 받은 편지함에 없으면 스팸 폴더를 확인하십시오.</p><p>재설정 링크는 0분 동안만 유효합니다",
	"VER_PLEASE"	=> "암호를 재설정하십시오",
	));

	//User Settings
$lang = array_merge($lang,array(
	"SET_PIN"			=> "PIN 초기화",
	"SET_WHY"			=> "왜 이걸 바꿀 수 없나요?",
	"SET_PW_MATCH"		=> "새 암호와 일치해야 합니다.",

	"SET_PIN_NEXT"		=> "다음에 확인이 필요할 때 새 PIN을 설정할 수 있습니다.",
	"SET_UPDATE"		=> "사용자 설정을 업데이트합니다.",
	"SET_NOCHANGE"		=> "관리자가 사용자 이름 변경을 사용 불가능으로 설정했습니다.",
	"SET_ONECHANGE"		=> "관리자가 사용자 이름 변경을 한 번만 수행하도록 설정했으며 사용자가 이미 변경했습니다.",

	"SET_GRAVITAR"		=> "<strong>프로필 사진을 바꾸고 싶으신가요? </strong><br> <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a>을 방문하여 이 사이트에서 사용한 것과 동일한 전자 메일로 계정을 설정하십시오. 수백만 개의 사이트에서 작동합니다. 그것은 빠르고 쉽습니다!",

	"SET_NOTE1"			=> "<p><strong>부디 참고하세요</strong> 이메일을 업데이트하기 위한 보류 중인 요청이 있습니다. 으로", //the order in this translation doesn't match

	"SET_NOTE2"			=> ".</p><p>확인 이메일을 사용하여 이 요청을 완료하십시오.</p>
	<p>새 확인 이메일이 필요한 경우 위의 이메일을 다시 입력하고 요청을 다시 제출하십시오.</p>",

	"SET_PW_REQ" 		=> "암호, 전자 메일 또는 PIN을 재설정하는 데 필요합니다",
	"SET_PW_REQI" 		=> "암호를 변경하는 데 필요합니다",

	));

	//Errors
$lang = array_merge($lang,array(
	"ERR_FAIL_ACT"		=> "활성 세션을 종료하지 못했습니다. 오류: ",
	"ERR_EMAIL"			=> "오류로 인해 전자 메일이 전송되지 않습니다. 사이트 관리자에게 문의하십시오.",
	"ERR_EM_DB"			=> "해당 전자 메일 주소가 데이터베이스에 없습니다.",
	"ERR_TC"			=> "약관을 읽고 동의하십시오.",
	"ERR_CAP"			=> "캡차 테스트를 통과하지 못했습니다. 당신은 로봇이에요!",
	"ERR_PW_SAME"		=> "이전 암호는 새 암호와 같을 수 없습니다.",
	"ERR_PW_FAIL"		=> "현재 암호를 확인하지 못했습니다. 업데이트에 실패했습니다. 다시 시도하십시오.",
	"ERR_GOOG"			=> "<strong>메모</strong> 원래 Google 또는 Facebook 계정으로 등록한 경우 암호를 변경하려면 암호 분실 링크를 사용해야 합니다.",
	"ERR_EM_VER"		=> "전자 메일 확인이 활성화되지 않았습니다. 시스템 관리자에게 문의하십시오.",
	"ERR_EMAIL_STR"		=> "뭔가 잘못됐어요. 전자 메일을 다시 확인하십시오. 불편을 드려 죄송합니다.",

	));

	//Maintenance Page
$lang = array_merge($lang,array(
	"MAINT_HEAD"		=> "그 웹사이트는 곧 다시 온라인 상태가 될 것입니다!",
	"MAINT_MSG"			=> "불편을 끼쳐 드려 죄송합니다만, 현재 약간의 정비를 진행하고 있습니다<br>곧 다시 접속하겠습니다!",
	"MAINT_BAN"			=> "죄송합니다. 금지되었습니다. 오류가 발생한 경우 관리자에게 문의하십시오.",
	"MAINT_TOK"			=> "양식에 오류가 있습니다. 돌아가서 다시 시도하십시오. 페이지를 새로 고쳐서 양식을 제출하면 오류가 발생합니다. 이 문제가 계속 발생하면 관리자에게 문의하십시오.",
	"MAINT_OPEN"		=> "오픈 소스 PHP 사용자 관리 프레임워크",
	"MAINT_PLEASE"		=> "UserSpice가 성공적으로 설치되었습니다!<br>시작 설명서를 보려면 아래 링크를 클릭하십시오"
	));

	//dataTables Added in 4.4.08
	//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang,array(
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
$lang = array_merge($lang,array(
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
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php")){
	include($abs_us_root.$us_url_root."usersc/lang/".$lang["THIS_CODE"].".php");
}
 //do not put a closing php tag here
