<?php
$countE = $count = 0;

// this update adds support for totp cookie options
$file = $abs_us_root . $us_url_root . "users/init.php";
$file2 = $abs_us_root . $us_url_root . "users/includes/totp_requirements.php";


if (($content = file_get_contents($file)) !== false) {
    if (strpos($content, '$_SESSION[$inst . \'_login_method\'] = "cookie";') === false) {
        $search = '$user->login();';
        
        $replace = '$inst = Config::get(\'session/session_name\');
        $_SESSION[$inst . \'_login_method\'] = "cookie";
        $user->login();';
        
        $newContent = str_replace($search, $replace, $content);
        
        if ($newContent !== $content) {
            file_put_contents($file, $newContent);
        }
    }
}


if (($content2 = file_get_contents($file2)) !== false) {
    if (strpos($content2, "'cookie' => false,") === false) {
        $search2 = "'login_methods' => [";
        
        $replace2 = "'login_methods' => [
        'cookie' => false,";
        
        $newContent2 = str_replace($search2, $replace2, $content2);
        
        if ($newContent2 !== $content2) {
            file_put_contents($file2, $newContent2);
        }
    }
}


include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
