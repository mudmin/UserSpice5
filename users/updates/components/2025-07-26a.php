<?php
$countE = $count = 0;
//This is the upgrade file for version 2025-06-21b - Encrypt TOTP Secrets
// Define the file paths
$header_file = $abs_us_root . $us_url_root . "users/includes/template/header1_must_include.php";
$head_tags_file = $abs_us_root . $us_url_root . "usersc/includes/head_tags.php";

// The line we're looking for
$favicon_line = '<link rel="shortcut icon" href="/favicon.ico">';
$comment_replacement = '<!-- moved favicon to usersc/includes/head_tags.php -->';
$new_favicon_line = '<link rel="shortcut icon" href="<?=$us_url_root?>favicon.ico">';

// Check if header file exists and process if it does
if (file_exists($header_file)) {
    // Read the header file
    $header_content = file_get_contents($header_file);
    
    // Check if the favicon line exists
    if ($header_content !== false && strpos($header_content, $favicon_line) !== false) {
        // Replace the favicon line with comment
        $updated_header_content = str_replace($favicon_line, $comment_replacement, $header_content);
        
        // Write the updated content back to header file
        if (file_put_contents($header_file, $updated_header_content) !== false) {
            // Now add the favicon line to head_tags.php
            // Check if head_tags file exists, if not create it
            if (!file_exists($head_tags_file)) {
                $head_tags_content = "<?php\n// Head tags file\n?>\n" . $new_favicon_line . "\n";
            } else {
                // Read existing content and append favicon line
                $head_tags_content = file_get_contents($head_tags_file);
                
                // Check if favicon line already exists in head_tags.php
                if ($head_tags_content !== false && strpos($head_tags_content, $new_favicon_line) === false) {
                    $head_tags_content .= $new_favicon_line . "\n";
                }
            }
            
            // Write to head_tags file
            file_put_contents($head_tags_file, $head_tags_content);
        }
    }
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
