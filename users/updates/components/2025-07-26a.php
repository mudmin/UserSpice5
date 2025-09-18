<?php
$countE = $count = 0;
$header_file = $abs_us_root . $us_url_root . "users/includes/template/header1_must_include.php";
$head_tags_file = $abs_us_root . $us_url_root . "usersc/includes/head_tags.php";

$favicon_line = '<link rel="shortcut icon" href="/favicon.ico">';
$comment_replacement = '<!-- moved favicon to usersc/includes/head_tags.php -->';
$new_favicon_line = '<link rel="shortcut icon" href="<?=$us_url_root?>favicon.ico">';

if (file_exists($header_file)) {
    $header_content = file_get_contents($header_file);
    
    if ($header_content !== false && strpos($header_content, $favicon_line) !== false) {
        $updated_header_content = str_replace($favicon_line, $comment_replacement, $header_content);
        
        if (file_put_contents($header_file, $updated_header_content) !== false) {
            if (!file_exists($head_tags_file)) {
                $head_tags_content = $new_favicon_line . "\n";
            } else {
                $head_tags_content = file_get_contents($head_tags_file);
                
                if ($head_tags_content !== false && strpos($head_tags_content, $new_favicon_line) === false) {
                    $head_tags_content = $new_favicon_line . "\n" . $head_tags_content;
                }
            }
            
            file_put_contents($head_tags_file, $head_tags_content);
        }
    }
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
