<?php
$countE = 0;

// Define file path
$file_path = $abs_us_root . $us_url_root . "usersc/widgets/tools/widget.php";

// Check if file exists
if (file_exists($file_path)) {
    // Open the file for reading
    $file_content = file_get_contents($file_path);
    
    // Check if file content contains the term 'Permissions Manager'
    if (strpos($file_content, 'Permissions Manager') !== false) {
        // Replace 'Permissions Manager' with 'Permissions & Tags'
        $file_content = str_replace('Permissions Manager', 'Permissions & Tags', $file_content);
        
        // Open the file for writing
        $file_handle = fopen($file_path, 'w');
        // Write the modified content back to the file
        fwrite($file_handle, $file_content);
        // Close the file handle
        fclose($file_handle);
        
        // echo "Replacement successful.";
    } 
} 

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
