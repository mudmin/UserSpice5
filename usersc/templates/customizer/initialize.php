<?php 
/**
 * Initialize the Customizer Theme files if they don't exist
 * This ensures that when the template is first installed or updated,
 * default configuration files are created without overriding user customizations
 */
function initializeCustomizerTheme() {
    global $abs_us_root, $us_url_root;
    require_once "assets/template_name.php";
    
    $template_dir = $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override;
    $css_dir = $template_dir . '/assets/css';
    $child_themes_dir = $template_dir . '/assets/child_themes';
    $defaults_dir = $template_dir . '/assets/defaults';
    $presets_dir = $template_dir . '/assets/presets';

    // Create directories if they don't exist
    if (!is_dir($css_dir)) {
        mkdir($css_dir, 0755, true);
    }
    
    if (!is_dir($child_themes_dir)) {
        mkdir($child_themes_dir, 0755, true);
    }
    
    // Generate timestamp for filenames
    $timestamp = date('YmdHis');
    $mainCssFilename = "custom-bootstrap-{$timestamp}.css";
    $dashboardCssFilename = "dashboard-{$timestamp}.css";
    
    // Check for customizations.php
    $customizations_file = $css_dir . '/customizations.php';
    if (!file_exists($customizations_file)) {
        $customizations_content = "<?php\nreturn array (\n);\n";
        file_put_contents($customizations_file, $customizations_content);
        chmod($customizations_file, 0644);
    }
    
    // Check for dashboard child theme file
    $dashboard_file = $child_themes_dir . '/dashboard.php';
    if (!file_exists($dashboard_file)) {
        $dashboard_content = "<?php\nreturn array (\n);\n";
        file_put_contents($dashboard_file, $dashboard_content);
        chmod($dashboard_file, 0644);
    }
    
    // Copy the default CSS files with the new timestamped names
    if (file_exists($defaults_dir . '/main.css')) {
        copy($defaults_dir . '/main.css', $css_dir . '/' . $mainCssFilename);
        chmod($css_dir . '/' . $mainCssFilename, 0644);
    }
    
    if (file_exists($defaults_dir . '/dash.css')) {
        copy($defaults_dir . '/dash.css', $child_themes_dir . '/' . $dashboardCssFilename);
        chmod($child_themes_dir . '/' . $dashboardCssFilename, 0644);
    }
    
    // Create or update revision.php with the new filenames
    $revision_file = $css_dir . '/revision.php';
    $revision_content = "<?php\n// This file is automatically updated by the processor.php script\n// Do not edit manually\n\n";
    $revision_content .= "\$css_revision = '{$mainCssFilename}';\n";
    $revision_content .= "\$child_themes = array (\n";
    $revision_content .= "  'dashboard' => '{$dashboardCssFilename}',\n";
    $revision_content .= ");\n";
    
    file_put_contents($revision_file, $revision_content);
    chmod($revision_file, 0644);

    // Seed the presets shipped with the theme into child_themes/ on first setup.
    syncCustomizerPresets($presets_dir, $child_themes_dir);
}

/**
 * Copy any preset shipped in assets/presets/ into assets/child_themes/ when it
 * is not already installed. Never overwrites — a preset the user has edited (or
 * any child theme already present) is left untouched. Safe to call on every
 * customizer load; returns the count of presets newly installed.
 *
 * This is how preset packs ship WITH the theme: .php files placed in
 * assets/presets/ appear for users on the next customizer load. A theme update
 * that adds new presets is picked up automatically; nothing is ever deleted.
 */
function syncCustomizerPresets($presets_dir, $child_themes_dir) {
    if (!is_dir($presets_dir)) {
        return 0;
    }
    if (!is_dir($child_themes_dir) && !mkdir($child_themes_dir, 0755, true)) {
        return 0;
    }
    $installed = 0;
    foreach (glob($presets_dir . '/*.php') as $preset) {
        $dest = $child_themes_dir . '/' . basename($preset);
        if (!file_exists($dest) && copy($preset, $dest)) {
            chmod($dest, 0644);
            $installed++;
        }
    }
    return $installed;
}