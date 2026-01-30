<?php
$countE = $count = 0;

if (!isset($userspice_nonce)) {
    $file = $abs_us_root . $us_url_root . "users/init.php";

    if (file_exists($file)) {
        $contents = file_get_contents($file);
        
       
         $search_pattern = 'require_once $abs_us_root.$us_url_root."users/includes/loader.php";';
        $correct_nonce = '$userspice_nonce = base64_encode(random_bytes(16));';
        $misspelled_nonce = '$usespice_nonce = base64_encode(random_bytes(16));';

        // Check if correct nonce already exists
        if (strpos($contents, $correct_nonce) !== false) {
            // Already correct, do nothing
        }
        // Check if misspelled nonce exists
        elseif (strpos($contents, $misspelled_nonce) !== false) {
            // Fix the typo
            $contents = str_replace($misspelled_nonce, $correct_nonce, $contents);
            file_put_contents($file, $contents);
            $count++;
        }
        // Nonce doesn't exist at all, add it above the loader
        elseif (strpos($contents, $search_pattern) !== false) {
            $replacement = $correct_nonce . "\n" . $search_pattern;
            $contents = str_replace($search_pattern, $replacement, $contents);
            file_put_contents($file, $contents);
            $count++;
        }
    }
}
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
