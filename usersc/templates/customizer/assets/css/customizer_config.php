<?php
// Main customizer configuration file that dynamically loads all customizer components

// Define the path for customizer files
$customizer_path = $abs_us_root . $us_url_root . 'usersc/templates/'.$template_override .'/assets/css/customizers/';

// Initialize the configuration array
$templateConfig = [];

// Get all PHP files from the customizer directory
$customizer_files = glob($customizer_path . '*.php');

// Sort files by name to ensure correct loading order (files are prefixed with numbers)
sort($customizer_files);

// Load and merge each customizer file's configuration
foreach ($customizer_files as $file) {
    if (file_exists($file)) {
        $file_config = include $file;
        
        // If the file returns an array, merge it with our config
        if (is_array($file_config)) {
            $templateConfig = array_merge($templateConfig, $file_config);
        }
    }
}

return $templateConfig;