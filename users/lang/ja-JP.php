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
	"THIS_LANGUAGE" => "日本語",
	"THIS_CODE"     => "ja-JP",
	"MISSING_TEXT"  => "テキストが見つかりません",
));

$lang = array_merge($lang, array(
    "PASS_ENTER_CODE"     => "メールで送信されたコードを入力してください",
    "PASS_EMAIL_ONLY"     => "ログインリンクについてメールをご確認ください",
    "PASS_CODE_ONLY"      => "メールで送信されたコードを入力してください",
    "PASS_BOTH"           => "ログインリンクについてメールをご確認いただくか、送信されたコードを入力してください",
    "PASS_VER_BUTTON"     => "コードを確認",
    "PASS_EMAIL_ONLY_MSG" => "下記のリンクをクリックしてメールアドレスを確認してください",
    "PASS_CODE_ONLY_MSG"  => "ログインするには下記のコードを入力してください",
    "PASS_BOTH_MSG"       => "下記のリンクをクリックしてメールアドレスを確認するか、コードを入力してログインしてください",
    "PASS_YOUR_CODE"      => "確認コード: ",
    "PASS_CONFIRM_LOGIN"  => "ログインを確認",
    "PASS_CONFIRM_CLICK"  => "クリックしてログインを完了",
    "PASS_GENERIC_ERROR"  => "エラーが発生しました",
));

//Database Menus
$lang = array_merge($lang, array(
	"MENU_MENU"      => "メニュー",
	"MENU_HOME"      => "ホーム",
	"MENU_HELP"      => "ヘルプ",
	"MENU_ACCOUNT"   => "アカウント",
	"MENU_DASH"      => "管理ダッシュボード",
	"MENU_USER_MGR"  => "ユーザー管理",
	"MENU_PAGE_MGR"  => "ページ管理",
	"MENU_PERM_MGR"  => "権限管理",
	"MENU_MSGS_MGR"  => "メッセージ管理",
	"MENU_LOGS_MGR"  => "システムログ",
	"MENU_LOGOUT"    => "ログアウト",
));

// Signup
$lang = array_merge($lang, array(
	"SIGNUP_TEXT"          => "登録",
	"SIGNUP_BUTTONTEXT"    => "私を登録する",
	"SIGNUP_AUDITTEXT"     => "登録済み",
));

// Signin
$lang = array_merge($lang, array(
	"SIGNIN_FAIL"         => "** ログインに失敗しました **",
	"SIGNIN_PLEASE_CHK"   => "ユーザー名とパスワードを確認して再試行してください",
	"SIGNIN_UORE"         => "ユーザー名またはメールアドレス",
	"SIGNIN_PASS"         => "パスワード",
	"SIGNIN_TITLE"        => "ログインしてください",
	"SIGNIN_TEXT"         => "ログイン",
	"SIGNOUT_TEXT"        => "ログアウト",
	"SIGNIN_BUTTONTEXT"   => "ログイン",
	"SIGNIN_REMEMBER"     => "ログイン情報を保存する",
	"SIGNIN_AUDITTEXT"    => "ログイン済み",
	"SIGNIN_FORGOTPASS"   => "パスワードを忘れた場合",
	"SIGNOUT_AUDITTEXT"   => "ログアウト済み",
));

// Account Page
$lang = array_merge($lang, array(
	"ACCT_EDIT"        => "アカウント情報の編集",
	"ACCT_2FA"         => "2要素認証の管理",
	"ACCT_SESS"        => "セッションの管理",
	"ACCT_HOME"        => "アカウントホーム",
	"ACCT_SINCE"       => "登録日",
	"ACCT_LOGINS"      => "ログイン回数",
	"ACCT_SESSIONS"    => "アクティブセッション数",
	"ACCT_MNG_SES"     => "詳細については、左のサイドバーの「セッションの管理」ボタンをクリックしてください。",
));

//General Terms
$lang = array_merge($lang, array(
	"GEN_ENABLED"       => "有効",
	"GEN_DISABLED"      => "無効",
	"GEN_ENABLE"        => "有効化",
	"GEN_DISABLE"       => "無効化",
	"GEN_NO"            => "いいえ",
	"GEN_YES"           => "はい",
	"GEN_MIN"           => "分",
	"GEN_MAX"           => "最大",
	"GEN_CHAR"          => "文字", //as in characters
	"GEN_SUBMIT"        => "送信",
	"GEN_MANAGE"        => "管理",
	"GEN_VERIFY"        => "確認",
	"GEN_SESSION"       => "セッション",
	"GEN_SESSIONS"      => "セッション",
	"GEN_EMAIL"         => "メール",
	"GEN_FNAME"         => "名",
	"GEN_LNAME"         => "姓",
	"GEN_UNAME"         => "ユーザー名",
	"GEN_PASS"          => "パスワード",
	"GEN_MSG"           => "メッセージ",
	"GEN_TODAY"         => "今日",
	"GEN_CLOSE"         => "閉じる",
	"GEN_CANCEL"        => "キャンセル",
	"GEN_CHECK"         => "[ 全てを選択/解除 ]",
	"GEN_WITH"          => "を使用して",
	"GEN_UPDATED"       => "更新済み",
	"GEN_UPDATE"        => "更新",
	"GEN_BY"            => "by",
	"GEN_FUNCTIONS"     => "機能",
	"GEN_NUMBER"        => "番号",
	"GEN_NUMBERS"       => "番号",
	"GEN_INFO"          => "情報",
	"GEN_REC"           => "記録済み",
	"GEN_DEL"           => "削除",
	"GEN_NOT_AVAIL"     => "利用不可",
	"GEN_AVAIL"         => "利用可能",
	"GEN_BACK"          => "戻る",
	"GEN_RESET"         => "リセット",
	"GEN_REQ"           => "必須",
	"GEN_AND"           => "および",
	"GEN_SAME"          => "同じでなければなりません",
));

//added during passkey/totp update
$lang = array_merge($lang, array(
    "GEN_PASSKEY"                         => "パスキー",
    "GEN_ACTIONS"                         => "操作",
    "GEN_BACK_TO_ACCT"                    => "アカウントに戻る",
    "GEN_DB_ERROR"                        => "データベースエラーが発生しました。もう一度お試しください。",
    "GEN_IMPORTANT"                       => "重要",
    "GEN_NO_PERMISSIONS"                  => "このページにアクセスする権限がありません。",
    "GEN_NO_PERMISSIONS_MSG"              => "このページにアクセスする権限がありません。これがエラーだと思われる場合は、サイト管理者にご連絡ください。",
    "PASSKEYS_MANAGE_TITLE"               => "パスキーの管理",
    "PASSKEYS_LOGIN_TITLE"                => "パスキーでログイン",
    "PASSKEY_DELETE_SUCCESS"              => "パスキーを正常に削除しました。",
    "PASSKEY_DELETE_FAIL_DB"              => "データベースからのパスキーの削除に失敗しました。",
    "PASSKEY_DELETE_NOT_FOUND"            => "パスキーが見つからないか、権限が拒否されました。",
    "PASSKEY_NOTE_UPDATE_SUCCESS"         => "パスキーのメモを正常に更新しました。",
    "PASSKEY_NOTE_UPDATE_FAIL"            => "パスキーのメモの更新に失敗しました。",
    "PASSKEY_REGISTER_NEW"                => "新しいパスキーを登録",
    "PASSKEY_ERR_LIMIT_REACHED"           => "パスキーの最大数（10個）に達しました。",
    "PASSKEY_NOTE_TH"                     => "パスキーのメモ",
    "PASSKEY_TIMES_USED_TH"               => "使用回数",
    "PASSKEY_LAST_USED_TH"                => "最終使用日時",
    "PASSKEY_LAST_IP_TH"                  => "最終IPアドレス",
    "PASSKEY_EDIT_NOTE_BTN"               => "メモを編集",
    "PASSKEY_CONFIRM_DELETE_JS"           => "このパスキーを本当に削除しますか？",
    "PASSKEY_EDIT_MODAL_TITLE"            => "パスキーのメモを編集",
    "PASSKEY_EDIT_MODAL_LABEL"            => "パスキーのメモ",
    "PASSKEY_SAVE_CHANGES_BTN"            => "変更を保存",
    "PASSKEY_NONE_REGISTERED"             => "まだ登録されているパスキーはありません。",
    "PASSKEY_MUST_REGISTER_FIRST"         => "この機能を使用する前に、認証済みのアカウントからパスキーを登録する必要があります。",
    "PASSKEY_STORING"                     => "パスキーを保存中...",
    "PASSKEY_STORED_SUCCESS"              => "パスキーが正常に保存されました！",
    "PASSKEY_INVALID_ACTION"              => "無効な操作です: ",
    "PASSKEY_NO_ACTION_SPECIFIED"         => "操作が指定されていません",
    "PASSKEY_ERR_NETWORK_SUGGESTION"      => "ネットワークの問題が検出されました。別のネットワークを試すか、ページを更新してください。",
    "PASSKEY_ERR_CROSS_DEVICE_SUGGESTION" => "クロスデバイス認証が検出されました。両方のデバイスがインターネットに接続されていることを確認してください。",
    "PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE" => "代わりに、このページを直接スマートフォンで開いてみてください。",
    "PASSKEY_ERR_DIAGNOSTIC_FAILED"       => "診断情報を生成できませんでした: ",
    "PASSKEY_MISSING_CREDENTIAL_DATA"     => "保存に必要な認証情報がありません。",
    "PASSKEY_MISSING_AUTH_DATA"           => "認証に必要なデータがありません。",
    "PASSKEY_LOG_NO_MESSAGE"              => "メッセージなし",
    "PASSKEY_USER_NOT_FOUND"              => "パスキーの検証後、ユーザーが見つかりませんでした。",
    "PASSKEY_FATAL_ERROR"                 => "致命的なエラー: ",
    "PASSKEY_LOGIN_SUCCESS"               => "ログインに成功しました。",
    // JavaScript status messages (passkeys.php)
    "PASSKEY_CROSS_DEVICE_PREP"           => "クロスデバイス登録の準備をしています。スマートフォンやタブレットを使用する必要がある場合があります。",
    "PASSKEY_DEVICE_REGISTRATION"         => "デバイスのパスキー登録を使用しています...",
    "PASSKEY_STARTING_REGISTRATION"       => "パスキー登録を開始しています...",
    "PASSKEY_REQUEST_OPTIONS"             => "サーバーから登録オプションを要求しています...",
    "PASSKEY_FOLLOW_PROMPTS"              => "画面の指示に従ってパスキーを作成してください。別のデバイスを使用する必要がある場合があります。",
    "PASSKEY_FOLLOW_PROMPTS_SIMPLE"       => "画面の指示に従ってパスキーを作成してください...",
    "PASSKEY_CREATION_FAILED"             => "パスキーの作成に失敗しました - 認証情報が返されませんでした。",
    "PASSKEY_STORING_SERVER"              => "パスキーを保存しています...",
    "PASSKEY_CREATED_SUCCESS"             => "パスキーが正常に作成されました！",
    "PASSKEY_CROSS_DEVICE_AUTH_PREP"      => "クロスデバイス認証の準備をしています。スマートフォンとコンピュータの両方がインターネットに接続されていることを確認してください。",
    "PASSKEY_DEVICE_AUTH"                 => "デバイスのパスキー認証を使用しています...",
    "PASSKEY_STARTING_AUTH"               => "パスキー認証を開始しています...",
    "PASSKEY_QR_CODE_INSTRUCTION"         => "QRコードが表示されたら、スマートフォンでスキャンしてください。両方のデバイスがインターネットに接続されていることを確認してください。",
    "PASSKEY_PHONE_TABLET_INSTRUCTION"    => "プロンプトが表示されたら「スマートフォンまたはタブレットを使用する」を選択し、QRコードをスキャンしてください。",
    "PASSKEY_AUTHENTICATING"              => "パスキーで認証中...",
    "PASSKEY_SUCCESS_REDIRECTING"         => "認証に成功しました！リダイレクトしています...",
    // Timeout messages
    "PASSKEY_TIMEOUT_CROSS_DEVICE"        => "登録がタイムアウトしました。クロスデバイスの場合: 1) 再試行する, 2) デバイスがインターネットに接続されているか確認する, 3) スマートフォンで直接登録することを検討する。",
    "PASSKEY_TIMEOUT_SIMPLE"              => "登録がタイムアウトしました。もう一度お試しください。",
    "PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE"   => "クロスデバイス認証がタイムアウトしました。トラブルシューティング: 1) 両方のデバイスにインターネットが必要, 2) QRコードをより速くスキャンする, 3) 同じデバイスを使用することを検討する, 4) 一部のネットワークはクロスデバイス認証をブロックします。",
    "PASSKEY_AUTH_TIMEOUT_SIMPLE"         => "認証がタイムアウトしました。もう一度お試しください。",
    "PASSKEY_NO_CREDENTIAL"               => "認証情報が受信されませんでした。再試行中...",
    "PASSKEY_AUTH_FAILED_NO_CREDENTIAL"   => "認証に失敗しました - 認証情報が返されませんでした。",
    "PASSKEY_ATTEMPT_RETRY"               => "に失敗しました。再試行中... (残り%d回)",
    // Error messages
    "PASSKEY_CROSS_DEVICE_FAILED"         => "クロスデバイス登録に失敗しました。試すこと: 1) 両方のデバイスがインターネットに接続されているか確認する, 2) スマートフォンで直接登録することを検討する, 3) 一部の企業ネットワークはこの機能をブロックします。",
    "PASSKEY_REGISTRATION_CANCELLED"      => "登録がキャンセルされたか、デバイスがパスキーをサポートしていません。",
    "PASSKEY_NOT_SUPPORTED"               => "このデバイス/ブラウザの組み合わせではパスキーはサポートされていません。",
    "PASSKEY_SECURITY_ERROR"              => "セキュリティエラー - これは通常、ドメイン/オリジンの不一致を示します。",
    "PASSKEY_ALREADY_EXISTS"              => "このアカウントには、このデバイスに既にパスキーが存在します。別のデバイスを使用するか、既存のパスキーを先に削除してください。",
    "PASSKEY_CROSS_DEVICE_AUTH_FAILED"    => "クロスデバイス認証に失敗しました。試すこと: 1) 両方のデバイスが安定したインターネットに接続されているか確認する, 2) 可能であれば同じWiFiネットワークを使用する, 3) 代わりにスマートフォンで直接認証する, 4) 一部の企業ネットワークはこの機能をブロックします。",
    "PASSKEY_AUTH_CANCELLED"              => "認証がキャンセルされたか、パスキーが選択されませんでした。",
    "PASSKEY_NETWORK_ERROR"               => "ネットワークエラー。クロスデバイス認証の場合、両方のデバイスにインターネット接続が必要であり、同じネットワーク上にある必要がある場合があります。",
    "PASSKEY_CREDENTIAL_NOT_FOUND"        => "認証に失敗しました - 認証情報が認識されませんでした。",
    // Cross-device guidance
    "PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE" => "クロスデバイス認証のヒント:",
    "PASSKEY_GUIDANCE_INTERNET"           => "コンピュータとスマートフォンの両方にインターネット接続があることを確認してください",
    "PASSKEY_GUIDANCE_WIFI"               => "同じWiFiネットワーク上にいると役立つ場合があります（必須ではありません）",
    "PASSKEY_GUIDANCE_SELECT_DEVICE"      => "プロンプトが表示されたら、「スマートフォンまたはタブレットを使用する」を選択してください",
    "PASSKEY_GUIDANCE_SCAN_QUICKLY"       => "QRコードが表示されたら、素早くスキャンしてください",
    "PASSKEY_GUIDANCE_TRY_DIRECT"         => "失敗した場合は、ページを更新してスマートフォンのブラウザを直接使用してみてください",
    // Troubleshooting
    "PASSKEY_SHOW_TROUBLESHOOTING"        => "トラブルシューティングのヒントを表示",
    "PASSKEY_HIDE_TROUBLESHOOTING"        => "トラブルシューティングのヒントを非表示",
    "PASSKEY_DIAGNOSTICS_RUNNING"         => "診断を実行中...",
    "PASSKEY_DIAGNOSTICS_COMPLETE"        => "診断が完了しました。詳細はコンソールを確認してください。",
    "PASSKEY_ISSUES_DETECTED"             => "問題が検出されました:",
    "PASSKEY_ENVIRONMENT_SUITABLE"        => "環境はパスキーに適しているようです。",
    "PASSKEY_DIAGNOSTICS_FAILED"          => "診断に失敗しました:",
    // Modal
    "PASSKEY_ADD_NOTE_NEW"                => "新しいパスキーにメモを追加",
    // Technical errors
    "PASSKEY_BASE64_ERROR"                => "Base64デコードエラー:",
    // Server-side errors (passkey_parser.php)
    "PASSKEY_INVALID_JSON"                => "無効なJSONデータを受信しました:",
    // Session/validation errors (PasskeyHandler.php)
    "PASSKEY_NO_CHALLENGE_SESSION"        => "セッションにパスキー登録チャレンジが見つかりません。もう一度登録をお試しください。",
    "PASSKEY_USER_MISMATCH"               => "ユーザーIDが一致しません。もう一度登録をお試しください。",
    "PASSKEY_CHALLENGE_USER_MISMATCH"     => "チャレンジオプションのユーザーIDが現在のユーザーと一致しません。もう一度登録をお試しください。",
    "PASSKEY_REGISTRATION_FAILED_ERROR"   => "パスキー登録に失敗しました。お使いのデバイスとブラウザがWebAuthnをサポートしていることを確認し、もう一度お試しください。エラー:",
    "PASSKEY_NO_AUTH_CHALLENGE_SESSION"   => "セッションにパスキー認証チャレンジが見つかりません。もう一度ログインをお試しください。",
    "PASSKEY_CREDENTIAL_NOT_IN_DB"        => "パスキーの認証情報がデータベースに見つかりません。",
    "PASSKEY_CREDENTIAL_WRONG_USER"       => "パスキーの認証情報が期待されるユーザーのものではありません。",
    "PASSKEY_VALIDATION_FAILED_ERROR"     => "パスキーの検証に失敗しました。もう一度お試しいただくか、問題が解決しない場合はサポートにお問い合わせください。エラー:",
    "PASSKEY_USER_NOT_FOUND_REGISTRATION" => "登録するユーザーが見つかりません。",
    // --- Used in passkey_parser.php ---
    "PASSKEY_LOGIN_REQUIRED"              => "この操作を実行するにはログインする必要があります。",
    "PASSKEY_ACTION_MISSING"              => "リクエストに必要な 'action' パラメータがありませんでした。",
    "PASSKEY_STORAGE_FAILED"              => "パスキーの保存に失敗しました。操作は成功しませんでした。",
    "PASSKEY_LOGIN_FAILED"                => "パスキーでのログインに失敗しました。認証を確認できませんでした。",
    "PASSKEY_INVALID_METHOD"              => "無効なリクエストメソッド:", // The script appends the method name after this key
    // --- Used in passkeys.php ---
    "CSRF_ERROR"                          => "CSRFトークンのチェックに失敗しました。戻ってフォームを再送信してください。",
    // Network analysis from analyzeNetworkConditions()
    "PASSKEY_NETWORK_PRIVATE"             => "潜在的な問題: プライベートネットワーク上にいるようです。これがクロスデバイス通信に干渉することがあります。",
    "PASSKEY_NETWORK_PROXY"               => "潜在的な問題: プロキシまたはVPNが検出されました。これがクロスデバイス通信に干渉する可能性があります。",
    "PASSKEY_NETWORK_MOBILE"              => "注意: モバイルネットワーク上にいるようです。クロスデバイス操作のために安定した接続を確保してください。",
    "PASSKEY_NETWORK_CORPORATE"           => "潜在的な問題: 企業のファイアウォールが有効になっている可能性があり、クロスデバイス認証に影響を与える可能性があります。",
    // Recommendations from getCrossDeviceRecommendations()
    "PASSKEY_RECOMMENDATION_CROSS_DEVICE" => "推奨事項: デスクトップを使用している可能性が高いです。QRコードをスキャンするためにスマートフォンを使用する準備をしてください。",
    "PASSKEY_RECOMMENDATION_SAME_NETWORK" => "推奨事項: 最良の結果を得るために、コンピュータとモバイルデバイスが同じWi-Fiネットワーク上にあることを確認してください。",
    "PASSKEY_RECOMMENDATION_QR_QUICK"     => "推奨事項: リクエストがタイムアウトする可能性があるため、QRコードを素早くスキャンする準備をしてください。",
    "PASSKEY_RECOMMENDATION_INTERNET"     => "推奨事項: コンピュータとモバイルデバイスの両方が安定したインターネット接続を持っていることを確認してください。",
    "PASSKEY_RECOMMENDATION_UNITY_WEBVIEW" => "推奨事項: Unity WebViewの場合、ページがパスキーリクエストを読み込んで処理するのに十分な時間があることを確認してください。",
    "PASSKEY_RECOMMENDATION_UNITY_TIMEOUT" => "推奨事項: Unityではタイムアウトが長くなる可能性があります。しばらくお待ちください。",
    "PASSKEY_RECOMMENDATION_MOBILE_LOCAL" => "推奨事項: モバイルデバイス上にいるため、このデバイスに直接パスキーを登録できるはずです。",
    "PASSKEY_RECOMMENDATION_GOOGLE_MANAGER" => "推奨事項: Androidでは、Googleパスワードマネージャーでパスキーを管理できます。",
    // Validation from validateCrossDeviceEnvironment()
    "PASSKEY_VALIDATION_RP_IP"            => "設定警告: Relying Party IDがIPアドレスに設定されています。",
    "PASSKEY_VALIDATION_RP_DOMAIN"        => "推奨事項: セキュリティと互換性を向上させるために、Relying Party IDをドメイン名（例: yourwebsite.com）に設定してください。",
    "PASSKEY_VALIDATION_HTTPS_REQUIRED"   => "設定エラー: ライブサーバーでパスキーが機能するにはHTTPSが必要です。あなたのサイトはHTTP上のようです。",
    "PASSKEY_VALIDATION_NETWORK"          => "ネットワーク警告", // Generic prefix for network issues
    "PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK" => "推奨事項: 問題が発生した場合は、別のネットワークを試してください（例: 企業のWi-Fiからモバイルホットスポットに切り替える）。",
    "PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET" => "推奨事項: クロスデバイス操作の場合、両方のデバイスが信頼性の高いインターネット接続を持っていることを確認してください。",
    "PASSKEY_VALIDATION_MOBILE_FALLBACK"  => "推奨事項: クロスデバイス操作が失敗した場合は、このページをモバイルデバイスで直接開いて操作を完了してみてください。",
    "PASSKEY_INFO_TITLE"                  => "パスキーについて",
    "PASSKEY_INFO_DESC"                   => "パスキーは、指紋、顔認証、PINなど、お使いのデバイスに組み込まれたセキュリティ機能を使用してサインインする、安全でパスワード不要の方法です。パスワードよりも安全で、サインインが速く、パスワードマネージャーと同期するとデバイス間で機能し、フィッシング攻撃にも耐性があります。パスキーは、最新のスマートフォン、タブレット、コンピュータで動作し、1Password、Bitwarden、iCloudキーチェーン、Googleパスワードマネージャーなどのパスワードマネージャーに保存できます。",
    "PASSKEY_BACK_TO_LOGIN"               => "ログインに戻る",
));

//validation class
$lang = array_merge($lang, array(
	"VAL_SAME"           => "同じでなければなりません",
	"VAL_EXISTS"         => "はすでに存在します。別のものを選択してください",
	"VAL_DB"             => "データベースエラー",
	"VAL_NUM"            => "数字でなければなりません",
	"VAL_INT"            => "整数でなければなりません",
	"VAL_EMAIL"          => "有効なメールアドレスでなければなりません",
	"VAL_NO_EMAIL"       => "メールアドレスではないこと",
	"VAL_SERVER"         => "有効なサーバーに属していなければなりません",
	"VAL_LESS"           => "未満でなければなりません",
	"VAL_GREAT"          => "より大きい必要があります",
	"VAL_LESS_EQ"        => "以下でなければなりません",
	"VAL_GREAT_EQ"       => "以上でなければなりません",
	"VAL_NOT_EQ"         => "等しくない必要があります",
	"VAL_EQ"             => "等しい必要があります",
	"VAL_TZ"             => "有効なタイムゾーン名である必要があります",
	"VAL_MUST"           => "でなければなりません",
	"VAL_MUST_LIST"      => "以下のいずれかでなければなりません",
	"VAL_TIME"           => "有効な時間でなければなりません",
	"VAL_SEL"            => "有効な選択肢ではありません",
	"VAL_NA_PHONE"       => "有効な北米の電話番号でなければなりません",
));

//Time
$lang = array_merge($lang, array(
	"T_YEARS"     => "年",
	"T_YEAR"      => "年",
	"T_MONTHS"    => "月",
	"T_MONTH"     => "月",
	"T_WEEKS"     => "週",
	"T_WEEK"      => "週",
	"T_DAYS"      => "日",
	"T_DAY"       => "日",
	"T_HOURS"     => "時間",
	"T_HOUR"      => "時間",
	"T_MINUTES"   => "分",
	"T_MINUTE"    => "分",
	"T_SECONDS"   => "秒",
	"T_SECOND"    => "秒",
));


//Passwords
$lang = array_merge($lang, array(
	"PW_NEW"    => "新しいパスワード",
	"PW_OLD"    => "古いパスワード",
	"PW_CONF"   => "パスワードの確認",
	"PW_RESET"  => "パスワードのリセット",
	"PW_UPD"    => "パスワードが更新されました",
	"PW_SHOULD" => "パスワードは...",
	"PW_SHOW"   => "パスワードを表示",
	"PW_SHOWS"  => "パスワードを表示",
));


//Join
$lang = array_merge($lang, array(
	"JOIN_SUC"        => "ようこそ",
	"JOIN_THANKS"     => "登録ありがとうございます！",
	"JOIN_HAVE"       => "少なくとも",
	"JOIN_LOWER"	=> "小文字のアルファベット",
	"JOIN_SYMBOL"		=> "記号",
	"JOIN_CAP"        => "大文字のアルファベット",
	"JOIN_TWICE"      => "2回正しく入力されている必要があります",
	"JOIN_CLOSED"     => "申し訳ありませんが、現在登録は無効になっています。ご質問や懸念がある場合は、サイト管理者にお問い合わせください。",
	"JOIN_TC"         => "ユーザー登録規約",
	"JOIN_ACCEPTTC"   => "ユーザー登録規約に同意する",
	"JOIN_CHANGED"    => "規約が変更されました",
	"JOIN_ACCEPT"     => "ユーザー登録規約に同意して続行",
	"JOIN_SCORE" => "スコア：",
	"JOIN_INVALID_PW" => "パスワードが無効です",

));

//Sessions
$lang = array_merge($lang, array(
	"SESS_SUC"	=> "正常に終了しました ",
));

//Messages
$lang = array_merge($lang, array(
	"MSG_SENT"              => "メッセージが送信されました！",
	"MSG_MASS"              => "大量メッセージが送信されました！",
	"MSG_NEW"               => "新しいメッセージ",
	"MSG_NEW_MASS"          => "新しい大量メッセージ",
	"MSG_CONV"              => "会話",
	"MSG_NO_CONV"           => "会話はありません",
	"MSG_NO_ARC"            => "アーカイブされたスレッドはありません",
	"MSG_QUEST"             => "有効になっている場合はメール通知を送信しますか？",
	"MSG_ARC"               => "アーカイブされたスレッド",
	"MSG_VIEW_ARC"          => "アーカイブされたスレッドを表示",
	"MSG_SETTINGS"          => "メッセージの設定",
	"MSG_READ"              => "読む",
	"MSG_BODY"              => "本文",
	"MSG_SUB"               => "件名",
	"MSG_DEL"               => "配信済み",
	"MSG_REPLY"             => "返信",
	"MSG_QUICK"             => "クイックリプライ",
	"MSG_SELECT"            => "ユーザーを選択",
	"MSG_UNKN"              => "不明な受信者",
	"MSG_NOTIF"             => "メッセージのメール通知",
	"MSG_BLANK"             => "メッセージが空白であってはいけません",
	"MSG_MODAL"             => "ここをクリックするか、Alt + Rを押してこのボックスに焦点を当てるか、 Shift + Rを押して展開された返信ペインを開きます！",
	"MSG_ARCHIVE_SUCCESSFUL" => "スレッド %m1% が正常にアーカイブされました",
	"MSG_UNARCHIVE_SUCCESSFUL"   => "スレッド %m1% が正常にアーカイブ解除されました",
	"MSG_DELETE_SUCCESSFUL"      => "スレッド %m1% が正常に削除されました",
	"USER_MESSAGE_EXEMPT"   => "ユーザーはメッセージから %m1% 除外されています。",
	"MSG_MK_READ"           => "既読にする",
	"MSG_MK_UNREAD"         => "未読にする",
	"MSG_ARC_THR"           => "選択したスレッドをアーカイブ",
	"MSG_UN_THR"            => "選択したスレッドのアーカイブ解除",
	"MSG_DEL_THR"           => "選択したスレッドを削除",
	"MSG_SEND"              => "メッセージを送信",
));

//Two Factor Authentication
$lang = array_merge($lang, array(
    "2FA"                                => "二要素認証",
    "2FA_CONF"                           => "二要素認証を無効にしてもよろしいですか？あなたのアカウントは保護されなくなります。",
    "2FA_SCAN"                           => "認証アプリでこのQRコードをスキャンするか、キーを入力してください",
    "2FA_THEN"                           => "次に、ワンタイムパスコードのいずれかをここに入力してください",
    "2FA_FAIL"                           => "二要素認証の確認中に問題が発生しました。インターネット接続を確認するか、サポートにお問い合わせください。",
    "2FA_CODE"                           => "二要素認証コード",
    "2FA_EXP"                            => "1つの指紋の有効期限が切れました",
    "2FA_EXPD"                           => "有効期限切れ",
    "2FA_EXPS"                           => "有効期限",
    "2FA_ACTIVE"                         => "アクティブなセッション",
    "2FA_NOT_FN"                         => "指紋が見つかりません",
    "2FA_FP"                             => "指紋",
    "2FA_NP"                             => "ログインに失敗しました - 二要素認証コードがありませんでした。もう一度お試しください。",
    "2FA_INV"                            => "ログインに失敗しました - 二要素認証コードが無効でした。もう一度お試しください。",
    "2FA_FATAL"                          => "致命的なエラー - システム管理者にお問い合わせください。現在、二要素認証コードを生成できません。",
    "2FA_SECTION_TITLE"                  => "二要素認証 (TOTP)",
    "2FA_SK_ALT"                         => "QRコードをスキャンできない場合は、このシークレットキーを認証アプリに手動で入力してください。",
    "2FA_IS_ENABLED"                     => "二要素認証があなたのアカウントを保護しています。",
    "2FA_NOT_ENABLED_INFO"               => "現在、二要素認証は有効になっていません。",
    "2FA_NOT_ENABLED_EXPLAIN"            => "二要素認証（TOTP）は、パスワードに加えて、お使いのスマートフォンの認証アプリからのコードを要求することで、アカウントにさらなるセキュリティ層を追加します。",
    // Setup Process
    "2FA_SETUP_TITLE"                    => "二要素認証を設定",
    "2FA_SETUP_SECRET_KEY_LABEL"         => "シークレットキー:",
    "2FA_SETUP_VERIFY_CODE_LABEL"        => "アプリからの確認コードを入力",
    // Backup Codes
    "2FA_SUCCESS_ENABLED_TITLE"          => "二要素認証が有効になりました！バックアップコードを保存してください",
    "2FA_SUCCESS_ENABLED_INFO"           => "以下はあなたのバックアップコードです。安全な場所に保管してください - 各コードは一度しか使用できません。",
    "2FA_BACKUP_CODES_WARNING"           => "これらのコードはパスワードのように扱ってください。安全な場所に保管してください。",
    "2FA_SUCCESS_BACKUP_REGENERATED"     => "新しいバックアップコードが生成されました。安全な場所に保存してください。",
    "2FA_BACKUP_CODE_LABEL"              => "バックアップコード",
    "2FA_REGEN_CODES_BTN"                => "バックアップコードを再生成",
    "2FA_INVALIDATE_WARNING"             => "これにより、既存のすべてのバックアップコードが無効になります。よろしいですか？",
    // Authentication
    "2FA_CODE_LABEL"                     => "認証コード",
    "2FA_VERIFY_BTN"                     => "確認してサインイン",
    "2FA_VERIFY_TITLE"                   => "二要素認証が必要です",
    "2FA_VERIFY_INFO"                    => "認証アプリからの6桁のコードを入力してください。",
    // Actions & Buttons
    "2FA_ENABLE_BTN"                     => "二要素認証を有効にする",
    "2FA_DISABLE_BTN"                    => "二要素認証を無効にする",
    "2FA_VERIFY_ACTIVATE_BTN"            => "確認して有効化",
    "2FA_CANCEL_SETUP_BTN"               => "設定をキャンセル",
    "2FA_DONE_BTN"                       => "完了",
    // Success Messages
    "REDIR_2FA_DIS"                      => "二要素認証が無効になりました。",
    "2FA_SUCCESS_BACKUP_ACK"             => "バックアップコードが確認されました。",
    "2FA_SUCCESS_SETUP_CANCELLED"        => "設定がキャンセルされました。",
    // Error Messages
    "2FA_ERR_INVALID_BACKUP"             => "無効なバックアップコードです。もう一度お試しください。",
    "2FA_ERR_DISABLE_FAILED"             => "二要素認証の無効化に失敗しました。",
    "2FA_ERR_NO_SECRET"                  => "認証シークレットを取得できませんでした。もう一度お試しください。",
    "2FA_ERR_BACKUP_INVALIDATE_FAIL"     => "バックアップコードは検証されましたが、無効化に失敗しました。サポートにお問い合わせください。",
    "2FA_ERR_NO_CODE_PROVIDED"           => "認証コードが提供されていません。",
    "RATE_LIMIT_LOGIN"                   => "ログイン試行回数が多すぎます。しばらく待ってからもう一度お試しください。",
    "RATE_LIMIT_TOTP"                    => "不正な認証コードの試行回数が多すぎます。しばらく待ってからもう一度お試しください。",
    "RATE_LIMIT_PASSKEY"                 => "パスキー認証の試行回数が多すぎます。しばらく待ってからもう一度お試しください。",
    "RATE_LIMIT_PASSKEY_STORE"           => "パスキー登録の試行回数が多すぎます。しばらく待ってからもう一度お試しください。",
    "RATE_LIMIT_PASSWORD_RESET"          => "パスワードリセット要求が多すぎます。別のリセットを要求する前にしばらくお待ちください。",
    "RATE_LIMIT_PASSWORD_RESET_SUBMIT"   => "パスワードリセットの試行回数が多すぎます。しばらく待ってからもう一度お試しください。",
    "RATE_LIMIT_REGISTRATION"            => "登録試行回数が多すぎます。しばらく待ってからもう一度お試しください。",
    "RATE_LIMIT_EMAIL_VERIFICATION"      => "メール確認要求が多すぎます。別の確認を要求する前にしばらくお待ちください。",
    "RATE_LIMIT_EMAIL_CHANGE"            => "メール変更要求が多すぎます。しばらく待ってからもう一度お試しください。",
    "RATE_LIMIT_PASSWORD_CHANGE"         => "パスワード変更の試行回数が多すぎます。しばらく待ってからもう一度お試しください。",
    "RATE_LIMIT_GENERIC"                 => "試行回数が多すぎます。しばらく待ってからもう一度お試しください。",
));


$lang = array_merge($lang, array(
	"REDIR_2FA"             => "申し訳ありません。現在2要素認証は有効ではありません。",
	"REDIR_2FA_EN"          => "2要素認証が有効です",
	"REDIR_2FA_DIS"         => "2要素認証が無効です",
	"REDIR_2FA_VER"         => "2要素認証が確認され、有効です",
	"REDIR_SOMETHING_WRONG"   => "何かがうまくいかなかったようです。もう一度お試しください。",
	"REDIR_MSG_NOEX"        => "そのスレッドはあなたのものでないか存在しません。",
	"REDIR_UN_ONCE"         => "ユーザー名は既に1回変更されています。",
	"REDIR_EM_SUCC"         => "メールが正常に更新されました",
));

//Emails
$lang = array_merge($lang, array(
	"EML_SIGN_IN_WITH" => "次でサインイン：",
	"EML_FEATURE_DISABLED" => "この機能は無効です",
	"EML_PASSWORDLESS_SENT" => "ログイン用のリンクをメールで確認してください。",
	"EML_PASSWORDLESS_SUBJECT" => "ログインするにはメールを確認してください。",
	"EML_PASSWORDLESS_BODY" => "以下のリンクをクリックしてメールアドレスを確認してください。自動的にログインされます。",

	"EML_CONF"      => "メールの確認",
	"EML_VER"       => "メールの確認",
	"EML_CHK"       => "メールリクエストが受信されました。確認を行うためにメールを確認してください。確認リンクの有効期限は ",
	"EML_MAT"       => "メールアドレスが一致しませんでした。",
	"EML_HELLO"     => "こんにちは、",
	"EML_HI"        => "こんにちは、",
	"EML_AD_HAS"    => "管理者があなたのパスワードをリセットしました。",
	"EML_AC_HAS"    => "管理者があなたのアカウントを作成しました。",
	"EML_REQ"       => "上記のリンクを使用してパスワードを設定する必要があります。",
	"EML_EXP"       => "パスワードリンクの有効期限は ",
	"EML_VER_EXP"   => "確認リンクの有効期限は ",
	"EML_CLICK"     => "ここをクリックしてログインしてください。",
	"EML_REC"       => "ログイン後にパスワードを変更することがお勧めされています。",
	"EML_MSG"       => "新しいメッセージがあります。差出人：",
	"EML_REPLY"     => "ここをクリックして返信するか、スレッドを表示する",
	"EML_WHY"       => "このメールを受信しているのは、パスワードをリセットするためのリクエストが行われたためです。もし自分でない場合は、このメールを無視してください。",
	"EML_HOW"       => "もし自分である場合は、以下のリンクをクリックしてパスワードリセットプロセスを続行してください。",
	"EML_EML"       => "ユーザーアカウントからメールアドレスの変更リクエストが行われました。",
	"EML_VER_EML"   => "登録ありがとうございます。メールアドレスを確認すると、ログインできるようになります！メールアドレスを確認するには、以下のリンクをクリックしてください。",
));

//Verification
$lang = array_merge($lang, array(
	"VER_SUC"       => "メールが確認されました！",
	"VER_FAIL"      => "アカウントを確認できませんでした。もう一度お試しください。",
	"VER_RESEND"    => "確認メールを再送信",
	"VER_AGAIN"     => "メールアドレスを入力してもう一度お試しください",
	"VER_PAGE"      => "<li>メールを確認して送信されたリンクをクリックしてください</li><li>完了</li>",
	"VER_RES_SUC"   => "<p>確認リンクがメールアドレスに送信されました。</p><p>確認を完了するには、メール内のリンクをクリックしてください。メールが受信トレイにない場合は、スパムフォルダを確認してください。</p><p>確認リンクの有効期限は ",
	"VER_OOPS"      => "おっと...何かがうまくいかなかったようです。おそらくクリックした古いリセットリンクです。もう一度お試しするには以下をクリックしてください",
	"VER_RESET"     => "パスワードがリセットされました！",
	"VER_INS"       => "<li>メールアドレスを入力し、[リセット] をクリックしてください</li> <li>メールを確認して送信されたリンクをクリックしてください。</li>
						<li>画面の指示に従ってください</li>",
	"VER_SENT"      => "<p>パスワードリセットリンクがメールアドレスに送信されました。</p><p>パスワードをリセットするには、メール内のリンクをクリックしてください。メールが受信トレイにない場合は、スパムフォルダを確認してください。</p><p>リセットリンクの有効期限は ",
	"VER_PLEASE"    => "パスワードをリセットしてください",
));

//User Settings
$lang = array_merge($lang, array(
	"SET_PIN"           => "PINのリセット",
	"SET_WHY"           => "なぜこれを変更できないのですか？",
	"SET_PW_MATCH"      => "新しいパスワードと一致する必要があります",
	"SET_PIN_NEXT"      => "次に認証が必要な際に新しいPINを設定できます",
	"SET_UPDATE"        => "ユーザー設定を更新してください",
	"SET_NOCHANGE"      => "管理者はユーザー名の変更を無効にしました。",
	"SET_ONECHANGE"     => "管理者はユーザー名の変更を一度だけ許可し、既に変更されています。",
	"SET_GRAVITAR"      => "<strong>プロフィール画像を変更したいですか？ </strong><br> <a href='https://en.gravatar.com/'>https://en.gravatar.com/</a> を訪れ、このサイトで使用したメールと同じメールでアカウントを設定してください。数百万のサイトで動作します。速くて簡単です！",
	"SET_NOTE1"         => "<p><strong>注意：</strong> メールを更新するための保留中のリクエストがあります",
	"SET_NOTE2"         => "。</p><p>このリクエストを完了するために確認メールを使用してください。</p>
    <p>新しい確認メールが必要な場合は、上記のメールを再入力してリクエストを再送信してください。</p>",

	"SET_PW_REQ"        => "パスワード、メールの変更、またはPINのリセットには必須です",
	"SET_PW_REQI"       => "パスワードを変更するには必須です",
));

//Errors
$lang = array_merge($lang, array(
	"ERR_FAIL_ACT"      => "アクティブなセッションの終了に失敗しました。エラー：",
	"ERR_EMAIL"         => "エラーのためメールが送信されませんでした。サイト管理者に連絡してください。",
	"ERR_EM_DB"         => "そのメールアドレスはデータベースに存在しません",
	"ERR_TC"            => "利用規約を読んで受け入れてください",
	"ERR_CAP"           => "キャプチャテストに失敗しました、ロボット！",
	"ERR_PW_SAME"       => "古いパスワードは新しいパスワードと同じにすることはできません",
	"ERR_PW_FAIL"       => "現在のパスワードの検証に失敗しました。更新に失敗しました。もう一度お試しください。",
	"ERR_GOOG"          => "<strong>注意：</strong> 最初にGoogle/Facebookアカウントでサインアップした場合、パスワードを変更するにはパスワードを忘れたリンクを使用する必要があります... それとも本当にうまく推測できるかもしれません。",
	"ERR_EM_VER"        => "メールの確認は有効ではありません。システム管理者にお問い合わせください。",
	"ERR_EMAIL_STR"     => "何かがおかしいです。メールを再確認してください。ご不便をおかけして申し訳ありません",
));

//Maintenance Page
$lang = array_merge($lang, array(
	"MAINT_HEAD"        => "もうすぐ戻ります！",
	"MAINT_MSG"         => "ご不便をおかけして申し訳ありませんが、現在メンテナンス中です。<br>まもなくオンラインに戻ります！",
	"MAINT_BAN"         => "申し訳ありません。あなたは禁止されています。これがエラーであると感じる場合は、管理者に連絡してください。",
	"MAINT_TOK"         => "フォームでエラーが発生しました。戻ってもう一度やり直してください。ページを更新してフォームを送信するとエラーが発生しますのでご注意ください。これが続く場合は、管理者に連絡してください。",
	"MAINT_OPEN"        => "オープンソースのPHPユーザー管理フレームワーク。",
	"MAINT_PLEASE"      => "UserSpiceのインストールに成功しました！<br>始めるためのドキュメンテーションを表示するには、以下をご覧ください"
));

//dataTables Added in 4.4.08
//NOTE: do not change the words like _START_ between the two _ symbols!
$lang = array_merge($lang, array(
	"DAT_SEARCH"        => "検索",
	"DAT_FIRST"         => "最初",
	"DAT_LAST"          => "最後",
	"DAT_NEXT"          => "次へ",
	"DAT_PREV"          => "前へ",
	"DAT_NODATA"        => "テーブルにデータがありません",
	"DAT_INFO"          => "エントリー _TOTAL_ 件中 _START_ から _END_ まで表示",
	"DAT_ZERO"          => "エントリー 0 件中 0 から 0 まで表示",
	"DAT_FILTERED"      => "（合計エントリーからフィルタリング済み _MAX_ ）",
	"DAT_MENU_LENG"     => "_MENU_ エントリーを表示",
	"DAT_LOADING"       => "読み込み中...",
	"DAT_PROCESS"       => "処理中...",
	"DAT_NO_REC"        => "一致するレコードが見つかりません",
	"DAT_ASC"           => "昇順で列をソートするにはクリック",
	"DAT_DESC"          => "降順で列をソートするにはクリック",
));


///////////////////////////////////////////////////////////////

//Backend Translations for UserSpice
$lang = array_merge($lang, array(
	"BE_DASH"          => "ダッシュボード",
	"BE_SETTINGS"      => "設定",
	"BE_GEN"           => "一般",
	"BE_REG"           => "登録",
	"BE_CUS"           => "カスタム設定",
	"BE_DASH_ACC"      => "ダッシュボードアクセス",
	"BE_TOOLS"         => "ツール",
	"BE_BACKUP"        => "バックアップ",
	"BE_UPDATE"        => "アップデート",
	"BE_CRON"          => "クロンジョブ",
	"BE_IP"            => "IPマネージャ",
));


//LEAVE THIS LINE AT THE BOTTOM.  It allows users/lang to override these keys
if (file_exists($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php")) {
	include($abs_us_root . $us_url_root . "usersc/lang/" . $lang["THIS_CODE"] . ".php");
}
//do not put a closing php tag here
