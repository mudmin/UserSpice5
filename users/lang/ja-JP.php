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
$lang = array_merge($lang, array(
	"THIS_LANGUAGE" => "日本語",
	"THIS_CODE"     => "ja-JP",
	"MISSING_TEXT"  => "テキストが見つかりません",
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
	"JOIN_CAP"        => "大文字のアルファベット",
	"JOIN_TWICE"      => "2回正しく入力されている必要があります",
	"JOIN_CLOSED"     => "申し訳ありませんが、現在登録は無効になっています。ご質問や懸念がある場合は、サイト管理者にお問い合わせください。",
	"JOIN_TC"         => "ユーザー登録規約",
	"JOIN_ACCEPTTC"   => "ユーザー登録規約に同意する",
	"JOIN_CHANGED"    => "規約が変更されました",
	"JOIN_ACCEPT"     => "ユーザー登録規約に同意して続行",
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
	"MSG_MODAL"             => "ここをクリックするか、Alt + Rを押してこのボックスに焦点を当てるか、Shift + Rを押して展開された返信ペインを開きます！",
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

//2 Factor Authentication
$lang = array_merge($lang, array(
	"2FA"           => "2要素認証",
	"2FA_CONF"      => "本当に2要素認証を無効にしますか？アカウントはこれ以上保護されません。",
	"2FA_SCAN"      => "このQRコードを認証アプリでスキャンするか、キーを入力してください",
	"2FA_THEN"      => "その後、ここにワンタイムパスキーのいずれかを入力してください",
	"2FA_FAIL"      => "2要素認証の検証中に問題が発生しました。インターネットを確認するか、サポートにお問い合わせください。",
	"2FA_CODE"      => "2要素認証コード",
	"2FA_EXP"       => "期限切れ 1 指紋",
	"2FA_EXPD"      => "期限切れ",
	"2FA_EXPS"      => "有効期限",
	"2FA_ACTIVE"    => "アクティブセッション",
	"2FA_NOT_FN"    => "指紋が見つかりません",
	"2FA_FP"        => "指紋",
	"2FA_NP"        => "<strong>ログインに失敗しました</strong> 2要素認証コードが存在しませんでした。もう一度試してください。",
	"2FA_INV"       => "<strong>ログインに失敗しました</strong> 2要素認証コードが無効でした。もう一度試してください。",
	"2FA_FATAL"     => "<strong>致命的なエラー</strong> システム管理者に連絡してください。",
));

//Redirect Messages - These get a plus between each word
$lang = array_merge($lang, array(
	"REDIR_2FA"             => "申し訳ありません。現在2要素認証は有効ではありません。",
	"REDIR_2FA_EN"          => "2要素認証が有効です",
	"REDIR_2FA_DIS"         => "2要素認証が無効です",
	"REDIR_2FA_VER"         => "2要素認証が確認され、有効です",
	"REDIR_SOM_TING_WONG"   => "何かがうまくいかなかったようです。もう一度お試しください。",
	"REDIR_MSG_NOEX"        => "そのスレッドはあなたのものでないか存在しません。",
	"REDIR_UN_ONCE"         => "ユーザー名は既に1回変更されています。",
	"REDIR_EM_SUCC"         => "メールが正常に更新されました",
));

//Emails
$lang = array_merge($lang, array(
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
