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
if (!empty(Input::get('active_child_theme'))) {
    // Only use the child theme from POST when explicitly set
    $childThemeName = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get('active_child_theme'));
} elseif (Input::get('child_theme') != '') {
    $childThemeName = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get('child_theme'));
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

    usError("You do not have permission to access this page.");
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

// Relative luminance (WCAG 2.x) of an "#rgb"/"#rrggbb" colour.
function relLuminance($r, $g, $b) {
    $chan = function($c) {
        $c /= 255;
        return $c <= 0.04045 ? $c / 12.92 : pow(($c + 0.055) / 1.055, 2.4);
    };
    return 0.2126 * $chan($r) + 0.7152 * $chan($g) + 0.0722 * $chan($b);
}

// WCAG contrast ratio between two hex colours, or null if either isn't hex.
function contrastRatio($hexA, $hexB) {
    if (!preg_match('/^#[0-9a-f]{3,6}$/i', $hexA) || !preg_match('/^#[0-9a-f]{3,6}$/i', $hexB)) {
        return null;
    }
    list($ar, $ag, $ab) = hexToRgb($hexA);
    list($br, $bg, $bb) = hexToRgb($hexB);
    $la = relLuminance($ar, $ag, $ab);
    $lb = relLuminance($br, $bg, $bb);
    return (max($la, $lb) + 0.05) / (min($la, $lb) + 0.05);
}

/**
 * Build the CSS body for one theme: the custom-property block, the selector
 * rules (config css_rules + component templates), and any custom CSS.
 *
 * $scope controls where the CSS lands:
 *   ''                        -> light theme: ":root" + bare selectors.
 *   '[data-bs-theme="dark"]'   -> dark theme: that prefix scopes every block,
 *                                 so the same file carries both colour modes
 *                                 and Bootstrap 5.3's data-bs-theme switch
 *                                 picks between them with no extra download.
 */
function buildCustomizerCss(array $customizations, array $templateConfig, $scope = '') {
    // Custom CSS is emitted last; pull it out of the variable set.
    $customCSS = '';
    if (isset($customizations['custom_css'])) {
        $customCSS = $customizations['custom_css'];
        unset($customizations['custom_css']);
    }

    $out = '';

    // Build the complete variable map: config defaults, then customizations.
    $allVariables = [];
    foreach ($templateConfig as $category => $variables) {
        if ($category === 'component_templates') continue;
        foreach ($variables as $name => $set) {
            if (isset($set['variable'])) {
                $varName = str_replace('--bs-', '', $set['variable']);
                $allVariables[$varName] = $set['value'];
            }
        }
    }
    foreach ($customizations as $varName => $value) {
        // Handle both forms: with or without the --bs- prefix
        $allVariables[str_replace('--bs-', '', $varName)] = $value;
    }

    // Derived RGB triples for each theme colour.
    $colorVars = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark'];
    foreach ($colorVars as $colorVar) {
        if (isset($allVariables[$colorVar])) {
            $colorValue = resolveColorValue($allVariables[$colorVar], $allVariables);
            if (preg_match('/^#[0-9a-f]{3,6}$/i', $colorValue)) {
                list($r, $g, $b) = hexToRgb($colorValue);
                $allVariables[$colorVar.'-rgb'] = "$r, $g, $b";
            }
        }
    }

    // --- Custom-property block (":root" for light, the scope for dark) ---
    $out .= "\n" . ($scope === '' ? ':root' : $scope) . " {\n";
    foreach ($templateConfig as $category => $variables) {
        if ($category === 'component_templates' || $category === 'custom_css') continue;
        $out .= "  /* " . ucfirst($category) . " */\n";
        foreach ($variables as $name => $set) {
            if (isset($set['variable'])) {
                $varName = str_replace('--bs-', '', $set['variable']);
                $value = $allVariables[$varName] ?? $set['value'];
                $out .= "  " . $set['variable'] . ": " . $value . ";\n";
            }
        }
        $out .= "\n";
    }
    foreach ($colorVars as $colorVar) {
        if (isset($allVariables[$colorVar.'-rgb'])) {
            $out .= "  --bs-" . $colorVar . "-rgb: " . $allVariables[$colorVar.'-rgb'] . ";\n";
        }
    }
    $out .= "}\n\n";

    // --- Selector rules: config css_rules, then component templates ---
    $cssRules = [];
    foreach ($templateConfig as $category => $variables) {
        if ($category === 'component_templates') continue;
        foreach ($variables as $name => $set) {
            if (isset($set['css_rules'])) {
                foreach ($set['css_rules'] as $selector => $properties) {
                    if (!isset($cssRules[$selector])) {
                        $cssRules[$selector] = [];
                    }
                    foreach ($properties as $property => $propValue) {
                        $cssRules[$selector][$property] = $propValue;
                    }
                }
            }
        }
    }

    // Component templates (buttons, alerts, badges, ...).
    if (isset($templateConfig['component_templates'])) {
        foreach ($templateConfig['component_templates'] as $componentType => $componentConfig) {
            if (isset($componentConfig['colors']) && isset($componentConfig['templates'])) {
                foreach ($componentConfig['templates'] as $templateName => $template) {
                    foreach ($componentConfig['colors'] as $color) {
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

                                    // For a label/text color: keep the template's
                                    // name-based pick when it already meets WCAG AA,
                                    // but if it fails, re-pick #fff vs var(--bs-dark)
                                    // by the actual background color's luminance — so
                                    // bright custom palettes keep readable buttons.
                                    // Resolved against THIS theme's palette, so the
                                    // dark block recomputes contrast independently.
                                    if ($placeholder === 'text_color') {
                                        $bgHex   = resolveColorValue(isset($allVariables[$color]) ? $allVariables[$color] : '', $allVariables);
                                        $pickHex = resolveColorValue($replaceValue, $allVariables);
                                        $current = contrastRatio($pickHex, $bgHex);
                                        if ($current !== null && $current < 4.5) {
                                            $darkHex   = resolveColorValue('var(--bs-dark)', $allVariables);
                                            $withWhite = contrastRatio('#ffffff', $bgHex);
                                            $withDark  = contrastRatio($darkHex, $bgHex);
                                            if ($withWhite !== null && $withDark !== null) {
                                                $replaceValue = ($withDark >= $withWhite) ? 'var(--bs-dark)' : '#fff';
                                            }
                                        }
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

    // Output all the CSS rules, scoping each selector for the dark block.
    foreach ($cssRules as $selector => $properties) {
        $outSelector = $selector;
        if ($scope !== '') {
            // A selector may be a comma-separated list — scope every part.
            $parts = array_map('trim', explode(',', $selector));
            foreach ($parts as &$part) {
                $part = $scope . ' ' . $part;
            }
            unset($part);
            $outSelector = implode(', ', $parts);
        }
        $out .= $outSelector . " {\n";
        foreach ($properties as $property => $value) {
            $out .= "  " . $property . ": " . $value . ";\n";
        }
        $out .= "}\n\n";
    }

    // Custom CSS, always last. For the dark block it is wrapped in the scope
    // (CSS nesting) so a dark preset's custom CSS does not leak into light.
    if (trim((string)$customCSS) !== '') {
        if ($scope === '') {
            $out .= "\n/* Custom CSS */\n" . trim($customCSS) . "\n";
        } else {
            $out .= "\n/* Custom CSS (dark mode) */\n" . $scope . " {\n" . trim($customCSS) . "\n}\n";
        }
    }

    return $out;
}

// Start building the CSS output
$cssOutput = "/* Generated Bootstrap 5 Customizations */\n";
$cssOutput .= "/* Generated on: " . date('Y-m-d H:i:s') . " by ". $user->data()->fname . " " . $user->data()->lname ." */\n";

if ($usingChildTheme) {
    $cssOutput .= "/* Child theme: " . $childThemeName . " */\n";
}

// The light theme (the site's parent theme, or the child theme being saved).
$cssOutput .= buildCustomizerCss($customizations, $templateConfig, '');

// Append a scoped dark-mode block when the surface being built has a dark
// theme paired in the customizer's "Site Themes" panel. The front end (the
// parent theme) reads the 'frontend' pair; the 'dashboard' child reads the
// 'backend' pair. All other child themes stay single-mode.
$pairFile = $abs_us_root.$us_url_root.'usersc/templates/'.$template_override.'/assets/css/theme_pair.php';
$darkName = '';
if (file_exists($pairFile)) {
    $themePair = require $pairFile;
    if (is_array($themePair)) {
        if (!isset($themePair['frontend']) && isset($themePair['dark'])) {
            // Legacy single-key file — applies to the front end only.
            if (!$usingChildTheme) {
                $darkName = (string) $themePair['dark'];
            }
        } elseif (!$usingChildTheme) {
            $darkName = (string) ($themePair['frontend']['dark'] ?? '');
        } elseif ($childThemeName === 'dashboard') {
            $darkName = (string) ($themePair['backend']['dark'] ?? '');
        }
    }
}
if ($darkName !== '') {
    $darkName = preg_replace('/[^a-zA-Z0-9_]/', '_', $darkName);
    $darkFile = $abs_us_root.$us_url_root.'usersc/templates/'.$template_override.'/assets/child_themes/'.$darkName.'.php';
    if (file_exists($darkFile)) {
        $darkCustomizations = require $darkFile;
        if (is_array($darkCustomizations)) {
            $cssOutput .= "\n\n/* ===== Dark mode (preset: " . $darkName . ") ===== */\n";
            $cssOutput .= buildCustomizerCss($darkCustomizations, $templateConfig, '[data-bs-theme="dark"]');

            // Dark-mode safety overrides for Bootstrap utility classes that DO NOT
            // auto-flip via data-bs-theme. Pages (including the customizer itself)
            // commonly use .bg-light on card headers and .bg-white on surfaces; in
            // dark mode those still render white because --bs-light / hard-coded
            // #fff don't switch. Remap them to surfaces that do flip. Same for the
            // .text-light / .text-dark color utilities, which otherwise produce
            // light-on-light or dark-on-dark text when the theme inverts.
            $cssOutput .= "\n/* Dark-mode safety overrides — utility classes that don't auto-flip. */\n";
            $cssOutput .= "[data-bs-theme=\"dark\"] .bg-light { background-color: var(--bs-secondary-bg) !important; color: var(--bs-body-color); }\n";
            $cssOutput .= "[data-bs-theme=\"dark\"] .bg-white { background-color: var(--bs-body-bg) !important; color: var(--bs-body-color); }\n";
            $cssOutput .= "[data-bs-theme=\"dark\"] .text-dark { color: var(--bs-body-color) !important; }\n";
            $cssOutput .= "[data-bs-theme=\"dark\"] .text-light { color: var(--bs-emphasis-color) !important; }\n";
            $cssOutput .= "[data-bs-theme=\"dark\"] .text-muted { color: var(--bs-secondary-color) !important; }\n";
            $cssOutput .= "[data-bs-theme=\"dark\"] .text-black { color: var(--bs-body-color) !important; }\n";
            $cssOutput .= "[data-bs-theme=\"dark\"] .text-white-50 { color: rgba(255, 255, 255, 0.5) !important; }\n";
        }
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
// Invalidate OPcache so the redirected page picks up the new CSS filename immediately
// (otherwise the stale revision.php points at a deleted file and the page loads with no theme CSS)
if (function_exists('opcache_invalidate')) {
    opcache_invalidate($revisionFile, true);
}

return true;
