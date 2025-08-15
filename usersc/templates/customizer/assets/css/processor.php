<?php
/**
 * UserSpice CSS Processor - Streamlined Version
 * Generates CSS based on customizations defined in customizer_config.php
 */
if(count(get_included_files()) == 1) die(); // Prevent direct access

if(!empty($_POST)){
    // Token check
    if(!Token::check(Input::get('csrf'))){
        include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
    }
}

// Check if we're processing for a child theme
$childThemeName = '';
if (!empty($_POST['active_child_theme'])) {
    // Only use the child theme from POST when explicitly set
    $childThemeName = preg_replace('/[^a-zA-Z0-9_]/', '_', $_POST['active_child_theme']);
} elseif (isset($_GET['child_theme']) && $_GET['child_theme'] != '') {
    $childThemeName = preg_replace('/[^a-zA-Z0-9_]/', '_', $_GET['child_theme']);
}

$usingChildTheme = !empty($childThemeName);

// Create revision file if it doesn't exist
$revisionFile = $abs_us_root . $us_url_root . 'usersc/templates/'.$template_override.'/assets/css/revision.php';
if (!file_exists($revisionFile)) {
    $initialContent = "<?php\n// This file is automatically updated by the processor.php script\n// Do not edit manually\n\n\$css_revision = '';\n\$child_themes = array();\n";
    file_put_contents($revisionFile, $initialContent);
}

require_once $revisionFile;

// Ensure child_themes array exists
if (!isset($child_themes) || !is_array($child_themes)) {
    $child_themes = array();
}

// Permission check
if(!hasPerm([2],$user->data()->id)){
    logger($user->data()->id, "Permissions", "User attempted to access template customizer without permission");
    usError("You do not have permission to access this page. This has been logged.");
    Redirect::to($us_url_root);
    exit();
}

// Get configurations
$templateConfig = require $abs_us_root.$us_url_root.'usersc/templates/'.$template_override.'/assets/css/customizer_config.php';

// Load customizations
$customizations = [];
// If a child theme is active, load its customizations; otherwise load the primary customizations file
if ($usingChildTheme) {
    $childThemeFile = $abs_us_root.$us_url_root.'usersc/templates/'.$template_override.'/assets/child_themes/'.$childThemeName.'.php';
    if (file_exists($childThemeFile)) {
        $customizations = require $childThemeFile;
    }
} else {
    $customizationFile = $abs_us_root.$us_url_root.'usersc/templates/'.$template_override.'/assets/css/customizations.php';
    if (file_exists($customizationFile)) {
        $customizations = require $customizationFile;
    }
}

if(isset($customizations['custom-css'])){
    $customCSS = $customizations['custom-css'];
    unset($customizations['custom-css']);
} else {
    $customCSS = '';
}




// Start building the CSS output
$cssOutput = "/* Generated Bootstrap 5 Customizations */\n";
$cssOutput .= "/* Generated on: " . date('Y-m-d H:i:s') . " by ". $user->data()->fname . " " . $user->data()->lname ." */\n";

if ($usingChildTheme) {
    $cssOutput .= "/* Child theme: " . $childThemeName . " */\n";
}

// Helper function to convert hex to RGB
function hexToRgb($hex) {
    $hex = ltrim($hex, '#');
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    return array($r, $g, $b);
}

// Helper function to handle variable references in color values
function resolveColorValue($value, $allVariables) {
    // If it's a direct hex color, return it
    if (preg_match('/^#[0-9a-f]{3,6}$/i', $value)) {
        return $value;
    }
    
    // If it's a var reference
    if (preg_match('/var\(--bs-([^)]+)\)/', $value, $matches)) {
        $varName = $matches[1];
        if (isset($allVariables[$varName])) {
            // Recursively resolve nested references
            return resolveColorValue($allVariables[$varName], $allVariables);
        }
    }
    
    // If we can't resolve it, return the original
    return $value;
}

// Generate CSS variables first
$cssOutput .= "\n:root {\n";

// First, build a complete array of all variables
$allVariables = [];

// Get default values from config
foreach ($templateConfig as $category => $variables) {
    // Skip 'component_templates' as it's not for variables
    if ($category === 'component_templates') continue;
    
    foreach ($variables as $name => $set) {
        if (isset($set['variable'])) {
            $varName = str_replace('--bs-', '', $set['variable']);
            $allVariables[$varName] = $set['value'];
        }
    }
}

// Apply customizations over defaults
foreach ($customizations as $varName => $value) {

    // Handle both forms: with or without the --bs- prefix
    $cleanVarName = str_replace('--bs-', '', $varName);
    $allVariables[$cleanVarName] = $value;
}


// Add RGB variables for each theme color
$colorVars = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark'];
foreach ($colorVars as $colorVar) {
    if (isset($allVariables[$colorVar])) {
        $colorValue = resolveColorValue($allVariables[$colorVar], $allVariables);
        
        // Only process if we have a resolved hex color
        if (preg_match('/^#[0-9a-f]{3,6}$/i', $colorValue)) {
            list($r, $g, $b) = hexToRgb($colorValue);
            $allVariables[$colorVar.'-rgb'] = "$r, $g, $b";
        }
    }
}

// Output all CSS variables in :root
foreach ($templateConfig as $category => $variables) {
    // Skip 'component_templates' as it's not for variables
    if ($category === 'component_templates' || $category === 'custom_css') continue;
    
    $cssOutput .= "  /* " . ucfirst($category) . " */\n";
    
    foreach ($variables as $name => $set) {
        if (isset($set['variable'])) {
            $varName = str_replace('--bs-', '', $set['variable']);
            
            // Use value from allVariables array, which has customizations already applied
            $value = $allVariables[$varName] ?? $set['value'];
            
            $cssOutput .= "  " . $set['variable'] . ": " . $value . ";\n";
        }
    }
    
    $cssOutput .= "\n";
}

// Add RGB variables that we calculated
foreach ($colorVars as $colorVar) {
    if (isset($allVariables[$colorVar.'-rgb'])) {
        $cssOutput .= "  --bs-" . $colorVar . "-rgb: " . $allVariables[$colorVar.'-rgb'] . ";\n";
    }
}

$cssOutput .= "}\n\n";

// Generate CSS rules based on 'css_rules' in the config
$cssRules = [];

// First collect all rules from variables in config
foreach ($templateConfig as $category => $variables) {
    // Skip 'component_templates' as it's handled separately
    if ($category === 'component_templates') continue;
    
    foreach ($variables as $name => $set) {
        if (isset($set['css_rules'])) {
            foreach ($set['css_rules'] as $selector => $properties) {
                if (!isset($cssRules[$selector])) {
                    $cssRules[$selector] = [];
                }
                
                foreach ($properties as $property => $propValue) {
                    // No need to replace variable references since we're using CSS variables
                    $cssRules[$selector][$property] = $propValue;
                }
            }
        }
    }
}

// Process component templates (for buttons, alerts, etc.)
if (isset($templateConfig['component_templates'])) {
    foreach ($templateConfig['component_templates'] as $componentType => $config) {
        if (isset($config['colors']) && isset($config['templates'])) {
            foreach ($config['templates'] as $templateName => $template) {
                foreach ($config['colors'] as $color) {
                    $selector = str_replace('{color}', $color, $template['selector']);
                    
                    if (!isset($cssRules[$selector])) {
                        $cssRules[$selector] = [];
                    }
                    
                    foreach ($template['properties'] as $property => $value) {
                        // Replace {color} placeholders
                        $value = str_replace('{color}', $color, $value);
                        
                        // Handle special value replacements
                        if (isset($template['values'])) {
                            foreach ($template['values'] as $placeholder => $valueOptions) {
                                $replaceValue = $valueOptions['default'];
                                
                                if (isset($valueOptions[$color])) {
                                    $replaceValue = $valueOptions[$color];
                                }
                                
                                // Replace the placeholder with its value
                                $replaceValue = str_replace('{color}', $color, $replaceValue);
                                $value = str_replace('{' . $placeholder . '}', $replaceValue, $value);
                            }
                        }
                        
                        $cssRules[$selector][$property] = $value;
                    }
                }
            }
        }
    }
}

// Output all the CSS rules
foreach ($cssRules as $selector => $properties) {
    $cssOutput .= $selector . " {\n";
    
    foreach ($properties as $property => $value) {
        $cssOutput .= "  " . $property . ": " . $value . ";\n";
    }
    
    $cssOutput .= "}\n\n";
}

// Finally, add custom CSS if provided (always at the end)
if (!empty($customCSS)) {
    // Ensure custom CSS is properly formed
    if (trim($customCSS) !== '') {
        $cssOutput .= "\n/* Custom CSS */\n";
        $cssOutput .= trim($customCSS) . "\n";
    }
}


// Save the CSS file with the current timestamp for cache busting
$timestamp = date('YmdHis');
$newCssFilename = "custom-bootstrap-{$timestamp}.css";

// Determine where to save the CSS file
if ($usingChildTheme) {
    // For child themes, only save in the child theme location
    $childThemesDir = $abs_us_root.$us_url_root.'usersc/templates/'.$template_override.'/assets/child_themes';
    if (!is_dir($childThemesDir)) {
        mkdir($childThemesDir, 0755, true);
    }
    
    // Create timestamped filename for child theme
    $childThemeTimestamp = $timestamp;
    $childThemeFilename = "{$childThemeName}-{$childThemeTimestamp}.css";
    
    // Delete previous timestamped file for this child theme if it exists
    if (isset($child_themes[$childThemeName]) && 
        file_exists($childThemesDir . '/' . $child_themes[$childThemeName])) {
        unlink($childThemesDir . '/' . $child_themes[$childThemeName]);
    }
    
    // Save to child theme location with timestamp
    $childThemeFile = $childThemesDir . '/' . $childThemeFilename;
    file_put_contents($childThemeFile, $cssOutput);
    chmod($childThemeFile, 0644);
    
    // Update the child themes array with the new timestamped filename
    $child_themes[$childThemeName] = $childThemeFilename;
    
    // Update revision file with the array, but don't change $css_revision
    $revisionContent = "<?php\n// This file is automatically updated by the processor.php script\n// Do not edit manually\n\n";
    $revisionContent .= "\$css_revision = '{$css_revision}';\n"; // Keep existing main CSS revision
    $revisionContent .= "\$child_themes = " . var_export($child_themes, true) . ";\n";
    
} else {
    // Only update the main CSS when not using a child theme
    
    // Delete the previous CSS file if it exists
    if (isset($css_revision) && !empty($css_revision) && 
        file_exists($abs_us_root.$us_url_root.'usersc/templates/'.$template_override.'/assets/css/'.$css_revision)) {
        unlink($abs_us_root.$us_url_root.'usersc/templates/'.$template_override.'/assets/css/'.$css_revision);
    }
    
    // Save to main location only
    $cssFile = $abs_us_root.$us_url_root.'usersc/templates/'.$template_override.'/assets/css/'.$newCssFilename;
    file_put_contents($cssFile, $cssOutput);
    chmod($cssFile, 0644);
    
    // Update revision file, preserving the child_themes array
    $revisionContent = "<?php\n// This file is automatically updated by the processor.php script\n// Do not edit manually\n\n";
    $revisionContent .= "\$css_revision = '{$newCssFilename}';\n";
    $revisionContent .= "\$child_themes = " . var_export($child_themes, true) . ";\n";
}

// Write the revision file
file_put_contents($revisionFile, $revisionContent);

return true;
