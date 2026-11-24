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

/**
 * SHA-1 of a theme file with CRs stripped, so a copy that went through a
 * Windows checkout or FTP transfer still matches its shipped hash. Must match
 * the hashing in build_preset_hashes.sh.
 */
function customizerThemeHash($file) {
    $content = is_file($file) ? file_get_contents($file) : false;
    return $content === false ? '' : sha1(str_replace("\r", '', $content));
}

/**
 * Copy $src over $dest and make sure the next require sees the new file.
 * No chmod: copying over an existing file keeps its mode, and chmod fails
 * (with a warning) when the web server is not the file's owner.
 */
function customizerReplaceThemeFile($src, $dest) {
    if (!copy($src, $dest)) {
        return false;
    }
    if (function_exists('opcache_invalidate')) {
        opcache_invalidate($dest, true);
    }
    return true;
}

/**
 * Surfaces whose live stylesheet was compiled from a theme that has since been
 * repaired, e.g. ['backend' => ['solarized_light', 'solarized_dark']]. Written
 * by repairCustomizerPresets(); a surface is removed when compileCustomizerTheme()
 * rebuilds it. The file is install-specific and must never ship.
 */
function customizerRebuildPendingFile() {
    return __DIR__ . '/assets/css/rebuild_pending.php';
}

function readCustomizerRebuildPending() {
    $file = customizerRebuildPendingFile();
    if (!is_file($file)) {
        return [];
    }
    $pending = require $file;
    return is_array($pending) ? $pending : [];
}

function writeCustomizerRebuildPending(array $pending) {
    $file = customizerRebuildPendingFile();
    $pending = array_filter($pending);
    if (empty($pending)) {
        $ok = !is_file($file) || unlink($file);
    } else {
        $content  = "<?php\n// Written by repairCustomizerPresets(); an entry is removed when it is rebuilt.\n";
        $content .= "// Install-specific - never ship this file.\n\nreturn " . var_export($pending, true) . ";\n";
        $created = !is_file($file);
        $writable = $created ? is_writable(dirname($file)) : is_writable($file);
        $ok = $writable && file_put_contents($file, $content) !== false;
        if ($ok && $created) {
            chmod($file, 0644); // only on a file we just created; chmod fails if we are not the owner
        }
    }
    if (function_exists('opcache_invalidate')) {
        opcache_invalidate($file, true);
    }
    return $ok;
}

/**
 * Bring installed copies of shipped presets up to date without touching edits.
 *
 * assets/preset_hashes.php lists the hash of every version of each preset we
 * ever shipped. A copy matching one of them was never edited by the admin, so
 * it is replaced with the current preset; a copy matching none was customized
 * and is left alone. Checks the gallery copies in child_themes/ and the light
 * theme a Site Themes pair copied into customizations.php / dashboard.php.
 *
 * Only theme FILES change here. Stylesheets are compiled, so every stylesheet a
 * replacement makes stale is queued in rebuild_pending.php first: the Site Themes
 * surfaces that use the theme, plus any gallery theme with its own compiled CSS
 * (a page can load one directly with $child_theme). The customizer then shows a
 * "Rebuild live stylesheets" banner - nothing visitors see changes until an
 * admin clicks it. If the queue cannot be written, nothing is replaced.
 *
 * Returns ['repaired' => [names], 'customized' => [names]], where 'customized'
 * are gallery copies that differ from every shipped version and were kept.
 */
function repairCustomizerPresets($template_dir) {
    $result = ['repaired' => [], 'customized' => []];

    $hashFile = $template_dir . '/assets/preset_hashes.php';
    $stock = is_file($hashFile) ? require $hashFile : [];
    if (!is_array($stock) || empty($stock)) {
        return $result;
    }

    $presetsDir = $template_dir . '/assets/presets';
    $childDir = $template_dir . '/assets/child_themes';
    $cssDir = $template_dir . '/assets/css';

    $pair = is_file($cssDir . '/theme_pair.php') ? require $cssDir . '/theme_pair.php' : [];
    if (!is_array($pair)) {
        $pair = [];
    }
    if (!isset($pair['frontend']) && isset($pair['dark'])) {
        // Legacy single-key file: a front-end dark theme only.
        $pair = ['frontend' => ['light' => '', 'dark' => (string) $pair['dark']]];
    }
    // Where each surface's editable light theme lives.
    $lightFiles = [
        'frontend' => $cssDir . '/customizations.php',
        'backend'  => $childDir . '/dashboard.php',
    ];
    // Gallery themes that have a compiled stylesheet of their own.
    $compiled = [];
    if (is_file($cssDir . '/revision.php')) {
        require $cssDir . '/revision.php'; // sets $child_themes
        if (isset($child_themes) && is_array($child_themes)) {
            $compiled = array_diff(array_keys($child_themes), ['dashboard']);
        }
    }

    // Plan: which files to replace, and which stylesheets that makes stale.
    $replace = [];
    $pending = [];
    foreach ($stock as $name => $hashes) {
        $preset = $presetsDir . '/' . $name . '.php';
        if (!is_array($hashes) || !is_file($preset)) {
            continue;
        }
        $current = customizerThemeHash($preset);

        $copy = $childDir . '/' . $name . '.php';
        $copyHash = customizerThemeHash($copy);
        if ($copyHash !== '' && $copyHash !== $current) {
            if (!in_array($copyHash, $hashes, true)) {
                $result['customized'][] = $name;
            } else {
                $replace[$copy] = [$preset, $name];
                foreach ($pair as $surface => $p) {
                    if (is_array($p) && isset($lightFiles[$surface]) && ($p['dark'] ?? '') === $name) {
                        $pending[$surface][] = $name;
                    }
                }
                if (in_array($name, $compiled, true)) {
                    $pending['child_themes'][] = $name;
                }
            }
        }

        // A light theme applied from this preset was copied into the surface's
        // own file, so it needs its own check.
        foreach ($lightFiles as $surface => $lightFile) {
            if (($pair[$surface]['light'] ?? '') !== $name) {
                continue;
            }
            $lightHash = customizerThemeHash($lightFile);
            if ($lightHash !== '' && $lightHash !== $current && in_array($lightHash, $hashes, true)) {
                $replace[$lightFile] = [$preset, $name];
                $pending[$surface][] = $name;
            }
        }
    }
    if (empty($replace)) {
        return $result;
    }

    // Queue the rebuilds before touching anything: a replaced theme whose
    // stylesheet never gets rebuilt would leave the live site silently stale.
    if (!empty($pending)) {
        $queued = readCustomizerRebuildPending();
        foreach ($pending as $key => $names) {
            $queued[$key] = array_values(array_unique(array_merge($queued[$key] ?? [], $names)));
        }
        if (!writeCustomizerRebuildPending($queued)) {
            return $result;
        }
    }

    foreach ($replace as $dest => $source) {
        list($preset, $name) = $source;
        if (is_writable($dest) && customizerReplaceThemeFile($preset, $dest)
            && !in_array($name, $result['repaired'], true)) {
            $result['repaired'][] = $name;
        }
    }

    return $result;
}
