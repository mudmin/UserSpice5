<?php
require_once "assets/template_name.php";
require_once '../../../users/init.php';
if (Input::get('child_theme') != "") {
  $child_theme = Input::get('child_theme');
}
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

if (!hasPerm([2], $user->data()->id)) {
  usError("You do not have permission to access this page. ");
  Redirect::to($us_url_root);
}

// Create the child_themes directory if it doesn't exist
$childThemesDir = $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/child_themes';
// theme_pair.php stores the live light/dark pair for each surface (see readThemePairFile()).
$themePairFile = $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/theme_pair.php';
if (!is_dir($childThemesDir)) {
  mkdir($childThemesDir, 0755, true);
}

// Install any preset shipped in assets/presets/ that isn't present yet. Runs
// every load so presets added by a theme update appear automatically; never
// overwrites an existing child theme, so user edits are always preserved.
require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/initialize.php';
syncCustomizerPresets(
  $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/presets',
  $childThemesDir
);

// Theme export — stream a child theme's .php file as a download. This is a
// read-only GET action; it is already behind the page-level hasPerm([2]) gate
// above (which redirects unauthorised users before reaching this point). The
// requested name is sanitised exactly like every other handler on this page.
if (isset($_GET['export_theme'])) {
  $exportName = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get('export_theme'));
  $exportFile = $childThemesDir . '/' . $exportName . '.php';

  if ($exportName !== '' && is_file($exportFile)) {
    // Discard any captured template output so only the file body is sent.
    while (ob_get_level() > 0) {
      ob_end_clean();
    }
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $exportName . '.php"');
    header('Content-Length: ' . filesize($exportFile));
    header('X-Content-Type-Options: nosniff');
    readfile($exportFile);
    exit;
  }

  usError("Theme file not found for export.");
  Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php');
}

if (!empty($_POST)) {
  // token check
  if (!Token::check(Input::get('csrf'))) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }
}

// ---------------------------------------------------------------------------
// Apply a theme PAIR to a surface. The "Site Themes" panel is the only place a
// theme goes live: the front end (public site) and the backend (admin
// dashboard) each get a light theme + an optional dark theme.
//   - front end light  = the parent theme  (assets/css/customizations.php)
//   - backend  light   = the 'dashboard' child theme
//   - dark themes are baked into that surface's stylesheet via data-bs-theme.
// Both handlers are behind hasPerm([2]) (page gate) + Token::check (POST block).
// ---------------------------------------------------------------------------
if (!empty($_POST['apply_frontend_pair']) || !empty($_POST['apply_backend_pair'])) {
  $isBackend  = !empty($_POST['apply_backend_pair']);
  $surfaceKey = $isBackend ? 'backend' : 'frontend';
  $lightField = $isBackend ? 'be_light_theme' : 'fe_light_theme';
  $darkField  = $isBackend ? 'be_dark_theme'  : 'fe_dark_theme';
  $returnUrl  = $us_url_root . 'usersc/templates/' . $template_override . '/customize.php'
              . ($isBackend ? '?child_theme=dashboard' : '');

  $lightChoice = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get($lightField));
  $darkChoice  = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get($darkField));
  if ($darkChoice === '__none__') {
    $darkChoice = '';
  }
  if ($darkChoice !== '' && !file_exists($childThemesDir . '/' . $darkChoice . '.php')) {
    usError("The selected dark-mode theme could not be found.");
    Redirect::to($returnUrl);
  }

  $pair = readThemePairFile($themePairFile);
  $pair[$surfaceKey]['dark'] = $darkChoice;

  // Optionally replace the surface's editable light theme with a chosen theme.
  if ($lightChoice !== '' && $lightChoice !== '__keep__') {
    $sourceFile = $childThemesDir . '/' . $lightChoice . '.php';
    if (!file_exists($sourceFile)) {
      usError("The selected light theme could not be found.");
      Redirect::to($returnUrl);
    }
    // Backend's light theme IS the 'dashboard' child — picking it is a no-op.
    if (!($isBackend && $lightChoice === 'dashboard')) {
      $destFile = $isBackend
        ? $childThemesDir . '/dashboard.php'
        : $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/customizations.php';
      copy($sourceFile, $destFile);
      if (function_exists('opcache_invalidate')) {
        opcache_invalidate($destFile, true);
      }
      $pair[$surfaceKey]['light'] = $lightChoice;
    }
  }

  writeThemePairFile($themePairFile, $pair);

  // Neutral capability marker read by core (the UltraMenu light/dark toggle):
  // true when EITHER surface has a dark theme paired.
  $darkMarkerFile = $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/dark_mode.php';
  $anyDark = ($pair['frontend']['dark'] !== '' || $pair['backend']['dark'] !== '');
  file_put_contents(
    $darkMarkerFile,
    "<?php\n// Auto-written by customize.php — true when a dark theme is paired.\nreturn " . ($anyDark ? 'true' : 'false') . ";\n"
  );
  if (function_exists('opcache_invalidate')) {
    opcache_invalidate($darkMarkerFile, true);
  }

  // Regenerate the surface's stylesheet so the pair (and its dark block) is
  // baked in. processor.php keys off these request values to pick the target.
  unset($_GET['child_theme'], $_POST['child_theme']);
  if ($isBackend) {
    $_POST['active_child_theme'] = 'dashboard';
  } else {
    unset($_POST['active_child_theme']);
  }
  require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/processor.php';

  usSuccess(($isBackend ? 'Backend dashboard' : 'Front-end') . ' theme pair applied.');
  Redirect::to($returnUrl);
}

// Delete a child theme
if (!empty($_POST['delete_child_theme'])) {
  $themeToDelete = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get('delete_theme_name'));

  // Don't allow deleting the dashboard theme
  if ($themeToDelete === 'dashboard') {
    usError("The dashboard theme cannot be deleted as it's required by the system.");
  } else {
    $themeFile = $childThemesDir . '/' . $themeToDelete . '.php';

    $deleted = false;
    if (file_exists($themeFile)) {
      unlink($themeFile);
      $deleted = true;
    }

    // The generated CSS is named "<theme>-<timestamp>.css" and recorded in
    // revision.php — look it up there rather than guessing "<theme>.css", or
    // the real file is orphaned and the revision entry left dangling.
    $revisionFile = $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/revision.php';
    if (file_exists($revisionFile)) {
      require $revisionFile; // sets $css_revision, $child_themes
      if (isset($child_themes) && is_array($child_themes) && isset($child_themes[$themeToDelete])) {
        $generatedCss = $childThemesDir . '/' . $child_themes[$themeToDelete];
        if (file_exists($generatedCss)) {
          unlink($generatedCss);
        }
        unset($child_themes[$themeToDelete]);
        $revisionContent  = "<?php\n// This file is automatically updated by the processor.php script\n// Do not edit manually\n\n";
        $revisionContent .= "\$css_revision = '" . (isset($css_revision) ? $css_revision : '') . "';\n";
        $revisionContent .= "\$child_themes = " . var_export($child_themes, true) . ";\n";
        file_put_contents($revisionFile, $revisionContent);
        if (function_exists('opcache_invalidate')) {
          opcache_invalidate($revisionFile, true);
        }
        $deleted = true;
      }
    }

    // Sweep up a legacy non-timestamped CSS file if an older build left one.
    $legacyCss = $childThemesDir . '/' . $themeToDelete . '.css';
    if (file_exists($legacyCss)) {
      unlink($legacyCss);
    }

    if ($deleted) {
      usSuccess("Child theme '$themeToDelete' has been deleted successfully");
    } else {
      usError("Child theme files not found");
    }
  }

  // If we just deleted the currently active theme, redirect to the base page
  if ($themeToDelete === Input::get('child_theme')) {
    Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php');
  } else {
    Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php' .
      (!empty(Input::get('child_theme')) ? '?child_theme=' . urlencode(Input::get('child_theme')) : ''));
  }
}

if (!empty($_POST['unload_child_theme'])) {
  // Just redirect to the customize page without the child_theme parameter
  usSuccess("Child theme unloaded successfully");
  Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php');
}

// Handle child theme operations
$childThemeName = '';
$childThemeMode = false;
$currentChildTheme = '';

// Set by the import handler when an upload collides with an existing theme —
// triggers the overwrite-confirm dialog instead of clobbering the file.
$importPendingName = '';
$importPendingContent = '';

// Load a child theme
if (!empty($_POST['load_child_theme'])) {
  $selectedTheme = Input::get('child_theme_select');
  $customizationFile = $childThemesDir . '/' . $selectedTheme . '.php';

  if (file_exists($customizationFile)) {
    // Load this theme's customizations directly from the child theme file
    $customizations = require $customizationFile;

    // Generate the CSS file with the child theme name parameter
    $_POST['active_child_theme'] = $selectedTheme; // Set this for the processor
    require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/processor.php';

    $currentChildTheme = $selectedTheme;
    usSuccess("Child theme '$selectedTheme' loaded successfully");
  } else {
    usError("Child theme file not found");
  }

  Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php?child_theme=' . urlencode($currentChildTheme));
}

// Save as child theme
if (!empty($_POST['save_child_theme'])) {
  $themeName = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get('child_theme_name'));

  if (empty($themeName)) {
    usError("Please enter a valid theme name");
  } else {
    $customizationFile = $childThemesDir . '/' . $themeName . '.php';

    // Check if file exists and confirm overwrite if needed
    $overwrite = true;
    if (file_exists($customizationFile) && empty($_POST['confirm_overwrite'])) {
      // Store the theme name for the confirmation dialog
      $childThemeName = $themeName;
      $overwrite = false;
    }

    if ($overwrite) {
      // Get the current form values instead of loading from the regular customization file
      $customizations = [];

      // Load the template config (plus any site overrides) here: this POST
      // handler runs before the main $templateConfig assignment further down,
      // and the loop below relies on it to know which form fields exist.
      $templateConfig = require $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/customizer_config.php';
      $customizerOverrides = $abs_us_root . $us_url_root . 'usersc/templates/template_customizer_overrides.php';
      if (file_exists($customizerOverrides)) {
        require $customizerOverrides;
      }

      // Process all form fields to get current values
      foreach ($templateConfig as $category => $variables) {
        // Skip component_templates as it has a different structure
        if ($category === 'component_templates') continue;

        foreach ($variables as $name => $set) {
          if (isset($set['variable'])) {
            $varName = str_replace('--bs-', '', $set['variable']);
            $inputName = 'var_' . $varName;

            // Skip custom CSS - handled separately to preserve CSS selectors
            if ($inputName === 'var_custom-css') continue;

            // Only include fields that exist in the form
            if (isset($_POST[$inputName])) {
              $customizations[$varName] = Input::get($inputName);
            }
          }
        }
      }

      // Handle special case for custom CSS if it exists
      // Use html_entity_decode to preserve CSS selectors like > (child combinator)
      if (isset($_POST['var_custom-css'])) {
        $customizations['custom_css'] = html_entity_decode(Input::get('var_custom-css'), ENT_QUOTES, 'UTF-8');
      }

      // Save to child theme file (stamps a "My Themes" docblock for new themes)
      writeChildThemeFile($customizationFile, $customizations, $themeName, $user->data()->fname . ' ' . $user->data()->lname);

      usSuccess("Child theme '$themeName' saved successfully");
      $currentChildTheme = $themeName;
    }
  }

  if ($overwrite) {
    Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php?child_theme=' . urlencode($currentChildTheme));
  }
}

// Handle reset to defaults
if (!empty($_POST['reset_defaults'])) {
  if (isset($_POST['active_child_theme']) && $_POST['active_child_theme'] != "") {

    $customizationFile = $childThemesDir . '/' . Input::get('active_child_theme') . '.php';
  } else {

    $customizationFile = $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/customizations.php';
  }

  // Check if customizations file exists and put the default
  /* <?php
return array (
);
 */
  if (file_exists($customizationFile)) {
    file_put_contents($customizationFile, "<?php\nreturn array (\n);\n");
    // Invalidate OPcache so new values are loaded immediately
    if (function_exists('opcache_invalidate')) {
      opcache_invalidate($customizationFile, true);
    }
  }


  // Generate a new CSS file with default values
  require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/processor.php';

  // Get the current child theme if one is active
  $currentActiveTheme = '';
  if (!empty(Input::get('child_theme'))) {
    $currentActiveTheme = Input::get('child_theme');
  } elseif (!empty(Input::get('active_child_theme'))) {
    $currentActiveTheme = Input::get('active_child_theme');
  }

  // Keep the child theme loaded but with default values
  if (!empty($currentActiveTheme)) {
    usSuccess("Settings have been reset to default values while maintaining your child theme selection");
    // @phpstan-ignore function.alreadyNarrowedType (intentional backward-compat guard; this customizer template can run on older UserSpice cores where the Redirect::sanitized method does not exist.)
    if (method_exists('Redirect', 'sanitized')) {
      Redirect::sanitized($us_url_root . 'usersc/templates/' . $template_override . '/customize.php?child_theme=' . urlencode($currentActiveTheme));
    } else {
      Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php?child_theme=' . urlencode($currentActiveTheme));
    }
  } else {
    usSuccess("Settings have been reset to default values");
    Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php');
  }
  exit;
}

// Confirm overwrite
// this may be wrong
if (!empty($_POST['confirm_overwrite_yes'])) {
  $themeName = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get('child_theme_name'));
  $customizationFile = $childThemesDir . '/' . $themeName . '.php';

  // Load existing parent customizations
  $regularCustomizationFile = $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/customizations.php';
  $customizations = [];

  if (file_exists($regularCustomizationFile)) {
    $customizations = require $regularCustomizationFile;
  }

  // Save to child theme file, overwriting the existing one (keeps its docblock)
  writeChildThemeFile($customizationFile, $customizations, $themeName, $user->data()->fname . ' ' . $user->data()->lname);

  usSuccess("Child theme '$themeName' has been overwritten successfully");
  $currentChildTheme = $themeName;
  Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php?child_theme=' . urlencode($currentChildTheme));
}

if (!empty($_POST['confirm_overwrite_no'])) {
  // User decided not to overwrite
  Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php');
}

// Import a child theme from an uploaded .php preset file. The upload is fully
// validated by validateImportedThemeFile() before it is trusted. An imported
// theme is user content, so it lands ONLY in child_themes/ — never in the
// shipped presets/ master directory. Behind hasPerm([2]) (page-level gate) and
// Token::check (the POST block above).
if (!empty($_POST['import_theme'])) {
  if (
    !isset($_FILES['import_file']) || !is_array($_FILES['import_file'])
    || $_FILES['import_file']['error'] !== UPLOAD_ERR_OK
    || !is_uploaded_file($_FILES['import_file']['tmp_name'])
  ) {
    usError("No file was uploaded, or the upload failed. Please choose a .php theme file.");
    Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php');
  }

  $importOrigName = $_FILES['import_file']['name'];
  if (strtolower(pathinfo($importOrigName, PATHINFO_EXTENSION)) !== 'php') {
    usError("Only .php theme preset files can be imported.");
    Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php');
  }

  // Sanitise the theme name the same way every other handler on this page does.
  $importName = preg_replace('/[^a-zA-Z0-9_]/', '_', pathinfo($importOrigName, PATHINFO_FILENAME));
  $importContent = file_get_contents($_FILES['import_file']['tmp_name']);

  $check = validateImportedThemeFile($importContent);
  if ($importName === '') {
    usError("Import rejected: the file name does not produce a valid theme name.");
    Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php');
  }
  if (!$check['ok']) {
    usError("Import rejected: " . $check['error']);
    Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php');
  }

  $importDest = $childThemesDir . '/' . $importName . '.php';

  // Name collision — defer to the overwrite-confirm dialog (rendered below)
  // rather than clobbering an existing theme.
  if (file_exists($importDest)) {
    $importPendingName = $importName;
    $importPendingContent = $importContent;
  } else {
    file_put_contents($importDest, $importContent);
    if (function_exists('opcache_invalidate')) {
      opcache_invalidate($importDest, true);
    }
    usSuccess("Theme '$importName' imported successfully");
    Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php?child_theme=' . urlencode($importName));
  }
}

// Confirmed overwrite of an existing theme by an import. The file content is
// carried through the dialog (base64) and FULLY re-validated here, so a
// tampered hidden field cannot smuggle in untrusted code.
if (!empty($_POST['confirm_import_yes'])) {
  $importName = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get('import_theme_name'));
  $importContent = base64_decode((string) Input::get('import_theme_payload'), true);

  $check = ($importContent === false)
    ? ['ok' => false, 'error' => 'the upload payload was corrupt.', 'data' => []]
    : validateImportedThemeFile($importContent);

  if ($importName === '' || !$check['ok']) {
    usError("Import failed: the theme could not be verified.");
    Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php');
  }

  $importDest = $childThemesDir . '/' . $importName . '.php';
  file_put_contents($importDest, $importContent);
  if (function_exists('opcache_invalidate')) {
    opcache_invalidate($importDest, true);
  }
  usSuccess("Theme '$importName' imported (existing theme overwritten)");
  Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php?child_theme=' . urlencode($importName));
}

if (!empty($_POST['confirm_import_no'])) {
  // User declined the import overwrite.
  Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php');
}

// (The light/dark pairing is handled by the apply_frontend_pair /
// apply_backend_pair handlers near the top of this file — the "Site Themes"
// panel — so there is no separate save_theme_pair handler any more.)

if (!empty($_POST['process_css'])) {
  // Load existing customizations based on whether we're in child theme mode or not
  $customizations = [];

  if (!empty($_POST['active_child_theme'])) {
    // In child theme mode, load from the child theme file
    $childThemeName = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get('active_child_theme'));
    $childThemeFile = $childThemesDir . '/' . $childThemeName . '.php';

    if (file_exists($childThemeFile)) {
      $customizations = require $childThemeFile;
    }
  } else {

    // Not in child theme mode, load from regular customization file
    $customizationFile = $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/customizations.php';
    if (file_exists($customizationFile)) {
      $customizations = require $customizationFile;
    }
  }

  // Check which fields were actually changed
  $changedFields = [];
  if (isset($_POST['changed_fields']) && !empty($_POST['changed_fields'])) {
    $changedFields = explode(',', Input::get('changed_fields'));
  }

  // Process only the fields that were explicitly changed
  foreach ($changedFields as $fieldName) {
    if (isset($_POST[$fieldName])) {
      $varName = Input::sanitize(substr($fieldName, 4)); // Remove 'var_' prefix
      // Use html_entity_decode for CSS to preserve selectors like > (child combinator)
      if ($fieldName === 'var_custom-css') {
        $customizations['custom_css'] = html_entity_decode(Input::get($fieldName), ENT_QUOTES, 'UTF-8');
      } else {
        $customizations[$varName] = Input::get($fieldName);
      }
    }
  }

  // Always ensure custom_css is decoded (fixes legacy encoded values and form submissions)
  if (isset($_POST['var_custom-css'])) {
    $customizations['custom_css'] = html_entity_decode(Input::get('var_custom-css'), ENT_QUOTES, 'UTF-8');
  } elseif (isset($customizations['custom_css'])) {
    // Decode any existing value that might have been loaded with encoding
    $customizations['custom_css'] = html_entity_decode($customizations['custom_css'], ENT_QUOTES, 'UTF-8');
  }

  // Check if we're in child theme mode
  if (!empty($_POST['active_child_theme'])) {

    $childThemeName = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get('active_child_theme'));
    $childThemeFile = $childThemesDir . '/' . $childThemeName . '.php';

    // Save to the child theme file (preserves an existing preset docblock)
    writeChildThemeFile($childThemeFile, $customizations, $childThemeName, $user->data()->fname . ' ' . $user->data()->lname);

    $currentChildTheme = $childThemeName;
  } else {
    // Save to the regular customization file when not in child theme mode
    $customizationFile = $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/customizations.php';
    file_put_contents($customizationFile, "<?php\nreturn " . var_export($customizations, true) . ";\n");
    // Invalidate OPcache so new values are loaded immediately
    if (function_exists('opcache_invalidate')) {
      opcache_invalidate($customizationFile, true);
    }
  }

  // Generate the CSS file
  require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/processor.php';

  usSuccess("Customizations processed successfully");

  if (!empty($currentChildTheme)) {
    Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php?child_theme=' . urlencode($currentChildTheme));
  } else {
    Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php');
  }
}

// Check if a child theme is active
if (isset($_GET['child_theme'])) {
  $currentChildTheme = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get('child_theme') ?? "");;
  $childThemeMode = true;
  $bannerTheme = "alert-warning";
} else {
  $bannerTheme = "alert-info";
}

// Get list of available child themes
$childThemes = [];
if (is_dir($childThemesDir)) {
  $files = scandir($childThemesDir);
  foreach ($files as $file) {
    if ($file != '.' && $file != '..' && pathinfo($file, PATHINFO_EXTENSION) == 'php') {
      $childThemes[] = pathinfo($file, PATHINFO_FILENAME);
    }
  }
}

// Theme pairs: each surface (front end / backend) has a light theme plus an
// optional dark theme baked into its stylesheet. processor.php reads the same
// file to emit the [data-bs-theme="dark"] block.
$themePair = readThemePairFile($themePairFile);
$frontendDark = $themePair['frontend']['dark'] !== ''
  ? preg_replace('/[^a-zA-Z0-9_]/', '_', $themePair['frontend']['dark']) : '';
$backendDark = $themePair['backend']['dark'] !== ''
  ? preg_replace('/[^a-zA-Z0-9_]/', '_', $themePair['backend']['dark']) : '';

// Load the configuration
$templateConfig = require $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/customizer_config.php';

// Load existing customizations if they exist
$customizations = [];
if (isset($child_theme)) {
  $customizationFile = $childThemesDir . '/' . $child_theme . '.php';
} else {
  $customizationFile = $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/customizations.php';
}

if (file_exists($customizationFile)) {
  $customizations = require $customizationFile;
}

//this file allows you to add/remove things to the $templateConfig or $customizationFile before they are used in the customizer
if (file_exists($abs_us_root . $us_url_root . 'usersc/templates/template_customizer_overrides.php')) {
  require_once $abs_us_root . $us_url_root . 'usersc/templates/template_customizer_overrides.php';
}

// Apply existing customizations to the config
foreach ($customizations as $varName => $value) {
  // Skip the custom_css entry as it's handled differently
  if ($varName === 'custom_css') {
    if (isset($templateConfig['custom_css']['custom_css_code'])) {
      $templateConfig['custom_css']['custom_css_code']['value'] = $value;
    }
    continue;
  }

  // Skip legacy custom_css_code key (now stored as custom_css)
  if ($varName === 'custom_css_code') continue;

  // Find the correct category and variable
  $found = false;

  foreach ($templateConfig as $category => $variables) {  // <-- This is the duplicate loop
    // Skip component_templates as it has a different structure
    if ($category === 'component_templates') continue;

    foreach ($variables as $name => $set) {
      // Check if this is the right variable
      if (isset($set['variable']) && $set['variable'] === '--bs-' . $varName) {
        $templateConfig[$category][$name]['value'] = $value;
        $found = true;
        break 2;
      }
    }
  }
}
// dump($customizationFile);
// dump($customizations);

// Read a theme's metadata from its docblock header (Preset / Description / Tags / Mode).
// Falls back to a humanized filename when no docblock is present.
function getThemeMeta($childThemesDir, $themeName)
{
  $meta = [
    'title'       => ucwords(str_replace('_', ' ', $themeName)),
    'description' => '',
    'tags'        => [],
    'mode'        => '',
    'category'    => '',
    'wcag'        => '',
  ];

  $file = $childThemesDir . '/' . $themeName . '.php';
  if (!file_exists($file)) {
    return $meta;
  }

  // The docblock lives at the very top of the file; only read the first chunk.
  $head = file_get_contents($file, false, null, 0, 1024);
  if ($head === false) {
    return $meta;
  }

  if (preg_match('/Preset:\s*(.+)/', $head, $m)) {
    $meta['title'] = trim($m[1]);
  }
  if (preg_match('/Description:\s*(.+)/', $head, $m)) {
    $meta['description'] = trim($m[1]);
  }
  if (preg_match('/Tags:\s*(.+)/', $head, $m)) {
    $meta['tags'] = array_values(array_filter(array_map('trim', explode(',', $m[1]))));
  }
  if (preg_match('/Mode:\s*(\w+)/', $head, $m)) {
    $meta['mode'] = strtolower(trim($m[1]));
  }
  if (preg_match('/Category:\s*(.+)/', $head, $m)) {
    $meta['category'] = trim($m[1]);
  }
  if (preg_match('/WCAG:\s*(\w+)/', $head, $m)) {
    $meta['wcag'] = strtolower(trim($m[1]));
  }

  return $meta;
}

/**
 * Pull the headline colors from a child theme file for the gallery swatch.
 * Falls back to Bootstrap defaults for any color the preset does not override.
 */
function getThemeSwatch($childThemesDir, $themeName)
{
  $sw = [
    'body-bg'   => '#ffffff',
    'primary'   => '#0d6efd',
    'secondary' => '#6c757d',
    'success'   => '#198754',
    'warning'   => '#ffc107',
    'danger'    => '#dc3545',
  ];
  $file = $childThemesDir . '/' . $themeName . '.php';
  if (is_file($file)) {
    $arr = include $file;
    if (is_array($arr)) {
      foreach ($sw as $k => $v) {
        if (!empty($arr[$k]) && is_string($arr[$k])) {
          $sw[$k] = $arr[$k];
        }
      }
    }
  }
  return $sw;
}

/**
 * Read theme_pair.php into a normalized structure:
 *   ['frontend' => ['light' => '', 'dark' => ''],
 *    'backend'  => ['light' => '', 'dark' => '']]
 * 'light' '' means the surface's own editable theme (front end = parent theme,
 * backend = the 'dashboard' child). 'dark' '' means dark mode is off.
 * A legacy single-key file (['dark' => X]) is read as the front-end dark theme.
 */
function readThemePairFile($file)
{
  $pair = [
    'frontend' => ['light' => '', 'dark' => ''],
    'backend'  => ['light' => '', 'dark' => ''],
  ];
  if (!file_exists($file)) {
    return $pair;
  }
  $data = require $file;
  if (!is_array($data)) {
    return $pair;
  }
  if (!isset($data['frontend']) && isset($data['dark'])) {
    $pair['frontend']['dark'] = (string) $data['dark'];
    return $pair;
  }
  foreach (['frontend', 'backend'] as $surface) {
    if (isset($data[$surface]) && is_array($data[$surface])) {
      $pair[$surface]['light'] = (string) ($data[$surface]['light'] ?? '');
      $pair[$surface]['dark']  = (string) ($data[$surface]['dark'] ?? '');
    }
  }
  return $pair;
}

/**
 * Write theme_pair.php. Every stored name is sanitised to [a-zA-Z0-9_], so the
 * values are safe to inline into the generated PHP.
 */
function writeThemePairFile($file, array $pair)
{
  $clean = function ($v) {
    return preg_replace('/[^a-zA-Z0-9_]/', '_', (string) $v);
  };
  $c  = "<?php\n";
  $c .= "// Theme pairs for the customizer's two surfaces. Written by customize.php.\n";
  $c .= "//   light = a child-theme name, or '' for the surface's own editable theme\n";
  $c .= "//           (front end = parent theme, backend = the 'dashboard' child).\n";
  $c .= "//   dark  = a child-theme name baked in via [data-bs-theme=\"dark\"], '' = off.\n\n";
  $c .= "return array (\n";
  foreach (['frontend', 'backend'] as $surface) {
    $light = $clean($pair[$surface]['light'] ?? '');
    $dark  = $clean($pair[$surface]['dark'] ?? '');
    $c .= "  '" . $surface . "' => array ( 'light' => '" . $light . "', 'dark' => '" . $dark . "' ),\n";
  }
  $c .= ");\n";
  file_put_contents($file, $c);
  if (function_exists('opcache_invalidate')) {
    opcache_invalidate($file, true);
  }
}

/**
 * Render <option> tags for a theme-picker <select>. $themeMetas is keyed by
 * theme name => meta array (from getThemeMeta). A fixed leading option is
 * emitted first; remaining themes are grouped dark-first or light-first.
 */
function customizerThemeOptions(array $themeMetas, $selected, $firstValue, $firstLabel, $darkFirst = true)
{
  $out = '<option value="' . htmlspecialchars($firstValue) . '"'
       . (($selected === '' || $selected === $firstValue) ? ' selected' : '') . '>'
       . htmlspecialchars($firstLabel) . '</option>';
  // Flag themes that ship in both light and dark. A "family" is the theme name
  // with any trailing _light/_dark stripped; paired = the family has both a
  // light-mode and a dark-mode member. Paired options get a leading ◐ marker
  // (mirrors the half-circle badge on the gallery cards) so the picker shows
  // at a glance which themes have a matching variant.
  $familyModes = [];
  foreach ($themeMetas as $fName => $fMeta) {
    $fBase = preg_replace('/_(light|dark)$/', '', $fName);
    $fMode = $fMeta['mode'] ?? '';
    if ($fMode === 'light' || $fMode === 'dark') {
      $familyModes[$fBase][$fMode] = true;
    }
  }
  $dark = [];
  $light = [];
  foreach ($themeMetas as $name => $meta) {
    if (($meta['mode'] ?? '') === 'dark') {
      $dark[$name] = $meta['title'];
    } else {
      $light[$name] = $meta['title'];
    }
  }
  $groups = $darkFirst
    ? [['dark', $dark], ['light', $light]]
    : [['light', $light], ['dark', $dark]];
  foreach ($groups as $group) {
    foreach ($group[1] as $name => $title) {
      $base = preg_replace('/_(light|dark)$/', '', $name);
      $isPaired = !empty($familyModes[$base]['light']) && !empty($familyModes[$base]['dark']);
      $out .= '<option value="' . htmlspecialchars($name) . '"'
            . ($name === $selected ? ' selected' : '') . '>'
            . htmlspecialchars($title) . ($isPaired ? ' ◐' : '') . ' (' . $group[0] . ')</option>';
    }
  }
  return $out;
}

/**
 * Write a child theme file, preserving an existing metadata docblock if present.
 * New files (and headerless ones) get a "My Themes" docblock so user-saved
 * themes group separately from the shipped presets in the gallery.
 */
function writeChildThemeFile($file, array $customizations, $themeName, $authorName = '')
{
  $header = '';

  // Preserve an existing docblock so re-saving a shipped preset keeps its category.
  if (file_exists($file)) {
    $existing = file_get_contents($file, false, null, 0, 1024);
    if ($existing !== false && preg_match('#/\*\*.*?\*/#s', $existing, $m)) {
      $header = $m[0] . "\n";
    }
  }

  if ($header === '') {
    $title = ucwords(str_replace('_', ' ', $themeName));

    // Derive light/dark from the saved body background so user themes get the
    // same sun/moon gallery icon as the shipped presets.
    $mode = 'light';
    if (!empty($customizations['body-bg']) && is_string($customizations['body-bg'])) {
      $hex = ltrim(trim($customizations['body-bg']), '#');
      if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
      }
      if (strlen($hex) === 6 && ctype_xdigit($hex)) {
        $luma = (0.299 * hexdec(substr($hex, 0, 2))
               + 0.587 * hexdec(substr($hex, 2, 2))
               + 0.114 * hexdec(substr($hex, 4, 2))) / 255;
        $mode = $luma < 0.5 ? 'dark' : 'light';
      }
    }

    $header  = "/**\n";
    $header .= " * Preset: " . $title . "\n";
    $header .= " * Category: My Themes\n";
    $header .= " * Description: Saved from the UserSpice Customizer.\n";
    $header .= " * Mode: " . $mode . "\n";
    if ($authorName !== '') {
      $header .= " * Author: " . $authorName . "\n";
    }
    $header .= " */\n";
  }

  file_put_contents($file, "<?php\n" . $header . "return " . var_export($customizations, true) . ";\n");
  if (function_exists('opcache_invalidate')) {
    opcache_invalidate($file, true);
  }
}

/**
 * Validate an uploaded child-theme .php file before it is trusted.
 *
 * A legitimate preset is nothing but: an opening tag, an optional docblock,
 * and `return array( ... )` of scalar key/value pairs. The file is tokenised
 * and every token whitelisted — anything that could execute (variables,
 * function calls, eval/include, control flow, string interpolation, heredocs)
 * is rejected outright. Only after that whitelist passes is the file actually
 * evaluated to confirm it returns a sane array.
 *
 * Returns ['ok' => bool, 'error' => string, 'data' => array].
 */
function validateImportedThemeFile($content)
{
  $fail = function ($msg) {
    return ['ok' => false, 'error' => $msg, 'data' => []];
  };

  if (!is_string($content) || trim($content) === '') {
    return $fail('the file is empty.');
  }
  if (strlen($content) > 256 * 1024) {
    return $fail('the file is too large to be a theme preset.');
  }
  if (strpos($content, '<?php') === false) {
    return $fail('the file does not look like a PHP theme preset.');
  }

  // Whitelist: only literals, an optional docblock and `return array(...)` may
  // appear. No variables, no calls, no control flow, no interpolation.
  $allowed = [
    T_OPEN_TAG     => true,
    T_CLOSE_TAG    => true,
    T_DOC_COMMENT  => true,
    T_COMMENT      => true,
    T_WHITESPACE   => true,
    T_RETURN       => true,
    T_ARRAY        => true,
    T_CONSTANT_ENCAPSED_STRING => true,
    T_DOUBLE_ARROW => true,
    T_LNUMBER      => true,
    T_DNUMBER      => true,
  ];
  $allowedChars = ['(' => true, ')' => true, '[' => true, ']' => true, ',' => true, ';' => true];

  $tokens   = token_get_all($content);
  $sawReturn = false;
  foreach ($tokens as $tok) {
    if (is_array($tok)) {
      $id = $tok[0];
      // Whitespace-only inline HTML (e.g. a trailing newline after a close
      // tag) is harmless and ignored.
      if ($id === T_INLINE_HTML) {
        if (trim($tok[1]) !== '') {
          return $fail('the file contains markup or text outside the PHP block.');
        }
        continue;
      }
      if (empty($allowed[$id])) {
        return $fail('the file contains disallowed PHP code (' . token_name($id) . ').');
      }
      if ($id === T_RETURN) {
        $sawReturn = true;
      }
    } else {
      if (empty($allowedChars[$tok])) {
        return $fail('the file contains a disallowed symbol ("' . $tok . '").');
      }
    }
  }
  if (!$sawReturn) {
    return $fail('the file must return an array of customizations.');
  }

  // The whitelist guarantees the file is pure data — now evaluate it (in a
  // temp file) to confirm it parses and returns a well-formed array.
  $tmp = tempnam(sys_get_temp_dir(), 'usct');
  if ($tmp === false) {
    return $fail('a temporary file could not be created to validate the upload.');
  }
  file_put_contents($tmp, $content);
  try {
    $data = include $tmp;
  } catch (\Throwable $e) {
    unlink($tmp);
    return $fail('the file could not be parsed as PHP.');
  }
  unlink($tmp);

  if (!is_array($data)) {
    return $fail('the file did not return an array.');
  }

  // Keys must be sane identifiers; values must be plain scalars (theme data,
  // not structures or objects).
  foreach ($data as $k => $v) {
    if (!is_string($k) || !preg_match('/^[a-zA-Z0-9_-]+$/', $k)) {
      return $fail('the theme contains an invalid setting name.');
    }
    if (!is_string($v) && !is_int($v) && !is_float($v) && !is_bool($v)) {
      return $fail('the theme contains a non-text value for "' . $k . '".');
    }
  }

  return ['ok' => true, 'error' => '', 'data' => $data];
}

// Function to render the appropriate input field based on type
function renderInputField($name, $set)
{
  if (!isset($set['variable'])) {
    return;
  }
  $varName = str_replace('--bs-', '', $set['variable']);
  $inputName = 'var_' . $varName;
  $value = htmlspecialchars($set['value']);

  echo '<div class="mb-3">';

  // Create label with tooltip if description exists
  echo '<label for="' . $inputName . '" class="form-label">';
  echo $set['label'];

  // Add tooltip icon and data attributes if description exists
  if (isset($set['description'])) {
    echo ' <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" 
            data-bs-placement="top" title="' . htmlspecialchars($set['description']) . '"></i>';
  }

  echo '</label>';

  // No inline on*= handlers: a delegated 'change' listener on #customizerForm
  // calls trackChanges() (see the script block below). Keeps the template
  // clean under a strict Content-Security-Policy.
  switch ($set['type']) {
    case 'textarea':
      echo '<textarea class="form-control" id="' . $inputName . '" name="' . $inputName . '" rows="18" width="100%">' . $value . '</textarea>';
      break;

    case 'color':
      echo '<div class="input-group">';
      echo '<input type="color" class="form-control form-control-color" id="' . $inputName . '" name="' . $inputName . '" value="' . $value . '">';
      echo '<input type="text" class="form-control" aria-label="Color HEX value" value="' . $value . '" data-color-target="' . $inputName . '">';
      echo '</div>';
      break;

    case 'var-reference':
      echo '<select class="form-select" id="' . $inputName . '" name="' . $inputName . '">';

      if (isset($set['options'])) {
        foreach ($set['options'] as $optValue => $optLabel) {
          $selected = ($optValue === $value) ? 'selected' : '';
          echo '<option value="' . htmlspecialchars($optValue) . '" ' . $selected . '>' . htmlspecialchars($optLabel) . '</option>';
        }
      } else {
        echo '<option value="' . $value . '" selected>' . $value . '</option>';
      }

      echo '</select>';
      break;

    case 'select':
      echo '<select class="form-select" id="' . $inputName . '" name="' . $inputName . '">';

      if (isset($set['options'])) {
        foreach ($set['options'] as $optValue => $optLabel) {
          $selected = ($optValue === $value) ? 'selected' : '';
          echo '<option value="' . htmlspecialchars($optValue) . '" ' . $selected . '>' . htmlspecialchars($optLabel) . '</option>';
        }
      }

      echo '</select>';
      break;

    case 'size':
    case 'shadow':
      echo '<input type="text" class="form-control" id="' . $inputName . '" name="' . $inputName . '" value="' . $value . '">';
      break;

    case 'font-family':
      echo '<textarea class="form-control" id="' . $inputName . '" name="' . $inputName . '" rows="2">' . $value . '</textarea>';
      break;

    case 'number':
      echo '<input type="number" class="form-control" id="' . $inputName . '" name="' . $inputName . '" value="' . $value . '">';
      break;

    default:
      echo '<input type="text" class="form-control" id="' . $inputName . '" name="' . $inputName . '" value="' . $value . '">';
  }

  echo '<div class="form-text customizer-varname">Variable: ' . $set['variable'] . '</div>';
  echo '</div>';
}

?>

<div class="container">
  <div class="row">
    <div class="col-12">
      <h1>UserSpice Theme Customizer
        <button type="button" class="btn btn-outline-success how-it-works-button" data-bs-toggle="modal" data-bs-target="#themeExplanationModal">
          <i class="fas fa-question-circle"></i> How it works
        </button>
      </h1>


      <?php if (!empty($childThemeName)) : ?>
        <!-- Overwrite confirmation dialog -->
        <div class="alert alert-warning">
          <h5><i class="fas fa-exclamation-triangle"></i> Confirm Overwrite</h5>
          <p>A child theme with the name "<?= htmlspecialchars($childThemeName) ?>" already exists. Do you want to overwrite it?</p>
          <form method="post" action="">
            <?= tokenHere(); ?>
            <input type="hidden" name="child_theme_name" value="<?= htmlspecialchars($childThemeName) ?>">
            <button type="submit" name="confirm_overwrite_yes" value="1" class="btn btn-sm btn-danger">Yes, Overwrite</button>
            <button type="submit" name="confirm_overwrite_no" value="1" class="btn btn-sm btn-secondary ms-2">No, Cancel</button>
          </form>
        </div>
      <?php elseif (!empty($importPendingName)) : ?>
        <!-- Import overwrite confirmation dialog -->
        <div class="alert alert-warning">
          <h5><i class="fas fa-exclamation-triangle"></i> Confirm Import Overwrite</h5>
          <p>A theme named "<?= htmlspecialchars($importPendingName) ?>" already exists. Importing this file will replace it. Do you want to continue?</p>
          <form method="post" action="">
            <?= tokenHere(); ?>
            <input type="hidden" name="import_theme_name" value="<?= htmlspecialchars($importPendingName) ?>">
            <input type="hidden" name="import_theme_payload" value="<?= htmlspecialchars(base64_encode($importPendingContent)) ?>">
            <button type="submit" name="confirm_import_yes" value="1" class="btn btn-sm btn-danger">Yes, Overwrite</button>
            <button type="submit" name="confirm_import_no" value="1" class="btn btn-sm btn-secondary ms-2">No, Cancel</button>
          </form>
        </div>
      <?php else : ?>

        <!-- Sticky status bar: shows what you're editing, color-coded by mode -->
        <div class="customizer-status-bar" data-mode="<?= $childThemeMode ? 'child' : 'parent' ?>">
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="customizer-status-msg">
              <?php if (!empty($childThemeMode) && $currentChildTheme === 'dashboard') : ?>
                <i class="fas fa-gauge-high me-1"></i>
                Editing the <strong>backend dashboard theme</strong> &mdash; your admin area's style.
                <small class="d-block d-md-inline ms-md-2 customizer-status-hint">
                  <strong>Save Child Theme</strong> saves your edits. Set the dashboard's live light/dark pair in the <strong>Site Themes</strong> panel above.
                </small>
              <?php elseif (!empty($childThemeMode)) : ?>
                <i class="fas fa-layer-group me-1"></i>
                Editing child theme: <strong><?= htmlspecialchars($currentChildTheme) ?></strong>
                <small class="d-block d-md-inline ms-md-2 customizer-status-hint">
                  <strong>Save Child Theme</strong> saves changes to this theme. Put it live on a surface from the <strong>Site Themes</strong> panel above.
                </small>
              <?php else : ?>
                <i class="fas fa-paint-roller me-1"></i>
                Editing the <strong>parent theme</strong> &mdash; your site's default style.
                <small class="d-block d-md-inline ms-md-2 customizer-status-hint">
                  Click <strong>Save &amp; Apply Theme</strong> below to apply your changes sitewide.
                </small>
              <?php endif; ?>
            </div>
            <?php if ($childThemeMode) : ?>
              <form method="post" action="" class="m-0">
                <?= tokenHere(); ?>
                <button type="submit" name="unload_child_theme" value="1" class="btn btn-sm btn-dark" data-confirm="Exit child theme and return to editing the parent theme?">
                  <i class="fas fa-times me-1"></i> Exit child theme
                </button>
              </form>
            <?php endif; ?>
          </div>
        </div>

        <style>
          .customizer-status-bar {
            position: sticky;
            top: 0;
            /* Keep below the UserSpice ultramenu (default z-index 50) so its
               dropdowns are never covered by this banner. */
            z-index: 5;
            padding: 0.65rem 1rem;
            margin: 0 -0.75rem 1.25rem -0.75rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            font-size: 0.95rem;
          }
          .customizer-status-bar[data-mode="parent"] {
            background-color: #cfe2ff;
            color: #052c65;
          }
          .customizer-status-bar[data-mode="child"] {
            background-color: #fff3cd;
            color: #664d03;
            border-bottom: 2px solid #ffc107;
          }
          .customizer-status-hint {
            opacity: 0.75;
            font-weight: normal;
          }
          /* Self-contained badges (own bg + own text) so the theme-list chrome
             stays legible whether the page is previewing a light or dark theme. */
          .customizer-meta-badge {
            display: inline-flex;
            align-items: center;
            font-size: 0.72rem;
            font-weight: 600;
            line-height: 1;
            padding: 0.32em 0.6em;
            border-radius: 0.35rem;
            white-space: nowrap;
          }
          .customizer-badge-dark   { background: #212529; color: #ffffff; }
          .customizer-badge-light  { background: #f1f3f5; color: #212529; border: 1px solid #ced4da; }
          .customizer-badge-system { background: #0dcaf0; color: #043b45; }
          .customizer-badge-active { background: #ffc107; color: #3d2e00; }
          .customizer-badge-tag    {
            background: #f1f3f5;
            color: #495057;
            border: 1px solid #dee2e6;
            border-radius: 50rem;
            font-weight: 400;
          }
        </style>

        <?php
        // Theme metadata for the Site Themes pickers — every child theme except
        // 'dashboard' (that IS the backend surface, offered as "keep current").
        $pairThemeMetas = array();
        foreach ($childThemes as $ptName) {
          if ($ptName === 'dashboard') {
            continue;
          }
          $pairThemeMetas[$ptName] = getThemeMeta($childThemesDir, $ptName);
        }
        ?>
        <!-- Site Themes: the live light/dark pair for each surface -->
        <div class="card mb-4 border-primary">
          <div class="card-header bg-body-tertiary d-flex justify-content-between align-items-center customizer-collapse-toggle"
               role="button" data-bs-toggle="collapse" data-bs-target="#siteThemesPanel"
               aria-expanded="true" aria-controls="siteThemesPanel">
            <h5 class="mb-0"><i class="fas fa-swatchbook me-2"></i>Site Themes</h5>
            <i class="fas fa-chevron-up customizer-collapse-chevron"></i>
          </div>
          <div id="siteThemesPanel" class="collapse show">
            <div class="card-body">
              <p class="text-muted small mb-3">
                Your site has two surfaces, each with its own <strong>light&nbsp;+&nbsp;dark theme pair</strong>.
                Set the pair here and click <strong>Apply</strong> &mdash; this is the only place a theme goes live.
                Loading a theme from the gallery below just opens it for editing; it does not change what visitors see.
              </p>
              <div class="row g-3">
                <!-- Front end -->
                <div class="col-12 col-lg-6">
                  <div class="border rounded h-100 p-3">
                    <h6 class="fw-bold mb-2"><i class="fas fa-globe me-2 text-primary"></i>Front End
                      <small class="text-muted fw-normal">&mdash; public site</small></h6>
                    <form method="post" action="">
                      <?= tokenHere(); ?>
                      <label class="form-label small fw-bold text-uppercase text-muted mb-1" for="fe_light_theme">Light theme</label>
                      <select name="fe_light_theme" id="fe_light_theme" class="form-select form-select-sm mb-2">
                        <?= customizerThemeOptions($pairThemeMetas, '', '__keep__', 'Keep current parent theme', false) ?>
                      </select>
                      <label class="form-label small fw-bold text-uppercase text-muted mb-1" for="fe_dark_theme">Dark theme</label>
                      <select name="fe_dark_theme" id="fe_dark_theme" class="form-select form-select-sm mb-2">
                        <?= customizerThemeOptions($pairThemeMetas, $frontendDark, '__none__', 'Disabled (light only)', true) ?>
                      </select>
                      <button type="submit" name="apply_frontend_pair" value="1" class="btn btn-sm btn-success w-100"
                              data-confirm="Apply this light/dark pair to the public-facing site?">
                        <i class="fas fa-check me-1"></i>Apply Front-End Pair
                      </button>
                    </form>
                  </div>
                </div>
                <!-- Backend -->
                <div class="col-12 col-lg-6">
                  <div class="border rounded h-100 p-3">
                    <h6 class="fw-bold mb-2"><i class="fas fa-gauge-high me-2 text-primary"></i>Backend
                      <small class="text-muted fw-normal">&mdash; admin dashboard</small></h6>
                    <form method="post" action="">
                      <?= tokenHere(); ?>
                      <label class="form-label small fw-bold text-uppercase text-muted mb-1" for="be_light_theme">Light theme</label>
                      <select name="be_light_theme" id="be_light_theme" class="form-select form-select-sm mb-2">
                        <?= customizerThemeOptions($pairThemeMetas, '', '__keep__', 'Keep current dashboard theme', false) ?>
                      </select>
                      <label class="form-label small fw-bold text-uppercase text-muted mb-1" for="be_dark_theme">Dark theme</label>
                      <select name="be_dark_theme" id="be_dark_theme" class="form-select form-select-sm mb-2">
                        <?= customizerThemeOptions($pairThemeMetas, $backendDark, '__none__', 'Disabled (light only)', true) ?>
                      </select>
                      <button type="submit" name="apply_backend_pair" value="1" class="btn btn-sm btn-success w-100"
                              data-confirm="Apply this light/dark pair to the admin dashboard?">
                        <i class="fas fa-check me-1"></i>Apply Backend Pair
                      </button>
                    </form>
                  </div>
                </div>
              </div>
              <div class="form-text mt-2">
                <i class="fas fa-circle-info me-1"></i>
                The <strong>light theme</strong> is the one you edit with the controls further down this page
                (front end = the parent theme; backend = the <code>dashboard</code> child theme). Picking a
                theme in a light dropdown replaces it. The <strong>dark theme</strong> is baked in behind a
                sun/moon toggle that visitors can switch &mdash; choose <em>Disabled</em> to turn it off.
              </div>
            </div>
          </div>
        </div>

        <!-- Themes & Presets (collapsible) -->
        <div class="card mb-4">
          <div class="card-header bg-body-tertiary d-flex justify-content-between align-items-center customizer-collapse-toggle"
               role="button" data-bs-toggle="collapse" data-bs-target="#childThemePanel"
               aria-expanded="true" aria-controls="childThemePanel">
            <h5 class="mb-0">
              <i class="fas fa-layer-group me-2"></i>Themes &amp; Presets
              <span class="badge bg-secondary ms-1"><?= count($childThemes) ?></span>
            </h5>
            <i class="fas fa-chevron-up customizer-collapse-chevron"></i>
          </div>
          <div id="childThemePanel" class="collapse show">
            <div class="card-body">
              <p class="text-muted small mb-3">
                A <strong>theme</strong> is a saved set of customizations. <strong>Load &amp; Edit</strong> opens one
                so you can preview and adjust it, then save it. To put a theme live, pick it in the
                <strong>Site Themes</strong> panel above.
              </p>

              <?php if (!empty($childThemes)) :
                // Detect light/dark sibling pairs. A "family" is the theme name
                // with any trailing _light/_dark stripped; a family counts as
                // paired only when it has BOTH a light-mode member and a
                // dark-mode member (e.g. solarized_light + solarized_dark, or
                // harbor + harbor_dark). Members of a paired family get a badge.
                $familyModes  = []; // base => ['light' => true, 'dark' => true]
                $themeFamily  = []; // theme => base
                foreach ($childThemes as $pTheme) {
                  if ($pTheme === 'dashboard') {
                    continue;
                  }
                  $base = preg_replace('/_(light|dark)$/', '', $pTheme);
                  $themeFamily[$pTheme] = $base;
                  $pMode = getThemeMeta($childThemesDir, $pTheme)['mode'];
                  if ($pMode === 'light' || $pMode === 'dark') {
                    $familyModes[$base][$pMode] = true;
                  }
                }
                $pairedThemes = []; // set of theme names that are half of a pair
                foreach ($themeFamily as $pTheme => $base) {
                  if (!empty($familyModes[$base]['light']) && !empty($familyModes[$base]['dark'])) {
                    $pairedThemes[$pTheme] = true;
                  }
                }

                // Bucket themes by their Category docblock field for grouped display
                $catOrder = ['Clean', 'Wild', 'Themed', 'My Themes', 'System', 'Uncategorized'];
                $themeBuckets = [];
                foreach ($childThemes as $bTheme) {
                  $bMeta = getThemeMeta($childThemesDir, $bTheme);
                  if ($bTheme === 'dashboard') {
                    $bCat = 'System';
                  } elseif ($bMeta['category'] !== '') {
                    $bCat = $bMeta['category'];
                  } else {
                    $bCat = 'Uncategorized';
                  }
                  $themeBuckets[$bCat][] = $bTheme;
                }
                // Known categories in preferred order, then any others appended
                $orderedCats = array_values(array_unique(array_merge(
                  array_values(array_intersect($catOrder, array_keys($themeBuckets))),
                  array_keys($themeBuckets)
                )));
              ?>
                <?php foreach ($orderedCats as $catName) : ?>
                  <div class="text-uppercase small fw-bold text-muted mt-3 mb-1">
                    <?= htmlspecialchars($catName) ?>
                    <span class="badge bg-secondary rounded-pill ms-1"><?= count($themeBuckets[$catName]) ?></span>
                  </div>
                  <div class="row g-2 mb-2">
                    <?php foreach ($themeBuckets[$catName] as $theme) :
                      $meta = getThemeMeta($childThemesDir, $theme);
                      $sw = getThemeSwatch($childThemesDir, $theme);
                      $isActive = ($theme === $currentChildTheme);
                    ?>
                      <div class="col-6 col-lg-4">
                        <div class="card h-100 customizer-theme-card<?= $isActive ? ' customizer-card-active' : '' ?>">
                          <div class="customizer-swatch" style="background-color: <?= htmlspecialchars($sw['body-bg']) ?>;">
                            <?php foreach (['primary', 'secondary', 'success', 'warning', 'danger'] as $sk) : ?>
                              <span class="customizer-swatch-dot" style="background-color: <?= htmlspecialchars($sw[$sk]) ?>;"></span>
                            <?php endforeach; ?>
                          </div>
                          <div class="card-body p-2 d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between gap-1">
                              <strong class="small text-truncate" title="<?= htmlspecialchars($meta['title']) ?>"><?= htmlspecialchars($meta['title']) ?></strong>
                              <span class="d-flex align-items-center gap-1 flex-shrink-0">
                                <?php if ($meta['wcag'] === 'marginal') : ?>
                                  <i class="fas fa-triangle-exclamation text-warning" title="Faithful palette reproduction — some button labels fall just below WCAG AA contrast"></i>
                                <?php endif; ?>
                                <?php if (isset($pairedThemes[$theme])) : ?>
                                  <i class="fas fa-circle-half-stroke text-primary" title="Paired theme &mdash; ships in both light and dark"></i>
                                <?php endif; ?>
                                <?php if ($meta['mode'] === 'dark') : ?>
                                  <i class="fas fa-moon text-secondary" title="Dark theme"></i>
                                <?php elseif ($meta['mode'] === 'light') : ?>
                                  <i class="fas fa-sun text-warning" title="Light theme"></i>
                                <?php endif; ?>
                              </span>
                            </div>
                            <?php if ($isActive) : ?>
                              <span class="customizer-meta-badge customizer-badge-active mt-1 align-self-start"><i class="fas fa-pen me-1"></i>Editing</span>
                            <?php elseif ($theme === 'dashboard') : ?>
                              <span class="customizer-meta-badge customizer-badge-system mt-1 align-self-start">System</span>
                            <?php endif; ?>
                            <?php if ($meta['description'] !== '') : ?>
                              <div class="customizer-card-desc text-muted mt-1"><?= htmlspecialchars($meta['description']) ?></div>
                            <?php endif; ?>
                            <div class="mt-auto pt-2 d-flex gap-1">
                              <form method="post" action="" class="m-0 flex-grow-1">
                                <?= tokenHere(); ?>
                                <input type="hidden" name="child_theme_select" value="<?= htmlspecialchars($theme) ?>">
                                <button type="submit" name="load_child_theme" value="1" class="btn btn-sm btn-outline-primary w-100">
                                  <i class="fas fa-pen me-1"></i>Load &amp; Edit
                                </button>
                              </form>
                              <a href="?export_theme=<?= urlencode($theme) ?>" class="btn btn-sm btn-outline-secondary" title="Download &quot;<?= htmlspecialchars($meta['title']) ?>&quot; as a .php file" download>
                                <i class="fas fa-download"></i>
                              </a>
                              <?php if ($theme !== 'dashboard') : ?>
                                <form method="post" action="" class="m-0">
                                  <?= tokenHere(); ?>
                                  <input type="hidden" name="delete_theme_name" value="<?= htmlspecialchars($theme) ?>">
                                  <input type="hidden" name="child_theme" value="<?= htmlspecialchars($currentChildTheme) ?>">
                                  <button type="submit" name="delete_child_theme" value="1" class="btn btn-sm btn-outline-danger" title="Delete this theme" data-confirm="Delete the &quot;<?= htmlspecialchars($meta['title']) ?>&quot; theme? This cannot be undone.">
                                    <i class="fas fa-trash-alt"></i>
                                  </button>
                                </form>
                              <?php endif; ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>

              <div class="border-top pt-3">
                <label class="form-label small fw-bold text-uppercase text-muted mb-1">
                  Save current customizations as a new theme
                </label>
                <form method="post" action="">
                  <?= tokenHere(); ?>
                  <div class="input-group">
                    <input type="text" name="child_theme_name" class="form-control" placeholder="New theme name" required value="<?= htmlspecialchars($currentChildTheme) ?>">
                    <button type="submit" name="save_child_theme" value="1" class="btn btn-success">
                      <i class="fas fa-save"></i> Save as New Theme
                    </button>
                  </div>
                  <div class="form-text">Creates a copy &mdash; your current parent theme is left untouched.</div>
                </form>
              </div>

              <div class="border-top pt-3">
                <label class="form-label small fw-bold text-uppercase text-muted mb-1">
                  Import a theme preset
                </label>
                <form method="post" action="" enctype="multipart/form-data">
                  <?= tokenHere(); ?>
                  <div class="input-group">
                    <input type="file" name="import_file" class="form-control" accept=".php" required>
                    <button type="submit" name="import_theme" value="1" class="btn btn-primary">
                      <i class="fas fa-file-import me-1"></i> Import Theme
                    </button>
                  </div>
                  <div class="form-text">
                    Upload a <code>.php</code> preset file (such as one exported with the
                    <i class="fas fa-download"></i> button on a card above). It is validated before
                    being saved &mdash; only a docblock and a <code>return array(...)</code> of values
                    are accepted, and it is added to your child themes only.
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <style>
          .customizer-collapse-toggle { cursor: pointer; }
          .customizer-collapse-chevron { transition: transform 0.2s ease; }
          .customizer-collapse-toggle.collapsed .customizer-collapse-chevron { transform: rotate(180deg); }

          /* Preset gallery cards */
          .customizer-theme-card {
            transition: box-shadow 0.15s ease, transform 0.15s ease;
          }
          .customizer-theme-card:hover {
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.13);
            transform: translateY(-2px);
          }
          .customizer-card-active {
            outline: 3px solid #ffc107;
            outline-offset: -1px;
          }
          .customizer-swatch {
            display: flex;
            align-items: center;
            gap: 5px;
            height: 38px;
            padding: 0 9px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.12);
            border-radius: var(--bs-card-inner-border-radius) var(--bs-card-inner-border-radius) 0 0;
          }
          .customizer-swatch-dot {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.55);
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.18);
          }
          .customizer-card-desc {
            font-size: 0.78rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
          }
        </style>





        <!-- Light/dark pairing now lives in the "Site Themes" panel above. -->

    </div>
  </div>

  <form method="post" action="" id="customizerForm">
    <?= tokenHere(); ?>
    <div class="d-flex flex-wrap justify-content-between align-items-center my-4 gap-2">
      <div class="d-flex flex-wrap gap-2">
        <button type="submit" name="process_css" value="1" class="btn btn-primary">
          <i class="fas fa-cog me-1"></i>
          <?= $childThemeMode ? 'Save Child Theme' : 'Save &amp; Apply Theme' ?>
        </button>
        <button type="submit" name="reset_defaults" value="1" class="btn btn-outline-danger" data-confirm="Reset all customizations on <?= $childThemeMode ? 'this child theme' : 'the parent theme' ?> back to default values?">
          <i class="fas fa-undo me-1"></i> Reset to Defaults
        </button>
      </div>
      <a href="<?= $us_url_root ?>users/admin.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Admin
      </a>
    </div>
    <?= tokenHere(); ?>
    <!-- Hidden field to track which fields changed -->
    <input type="hidden" name="changed_fields" id="changed_fields" value="">

    <?php if (!empty($currentChildTheme)) : ?>
      <!-- Hidden field to track active child theme -->
      <input type="hidden" name="active_child_theme" value="<?= htmlspecialchars($currentChildTheme) ?>">
    <?php endif; ?>
    <div class="d-flex flex-wrap justify-content-between align-items-center ps-2 mb-2 gap-2">
      <p class="mb-0">Customize your UserSpice theme by adjusting the variables below.</p>
      <div class="form-check form-switch mb-0">
        <input class="form-check-input" type="checkbox" role="switch" id="toggleVarNames">
        <label class="form-check-label small text-muted" for="toggleVarNames">Show CSS variable names</label>
      </div>
    </div>
    <style>
      /* Variable-name hints are advanced-only — hidden until the switch is on. */
      .customizer-varname { display: none; }
      .customizer-show-varnames .customizer-varname { display: block; }
    </style>
    <div class="accordion" id="customizer-accordion">
      <?php foreach ($templateConfig as $category => $variables) : ?>
        <?php if ($category === 'component_templates') : ?>
          <!-- Special handling for component_templates -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading-component_templates">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-component_templates" aria-expanded="false" aria-controls="collapse-component_templates">
                Component Templates
              </button>
            </h2>
            <div id="collapse-component_templates" class="accordion-collapse collapse" aria-labelledby="heading-component_templates" data-bs-parent="#customizer-accordion">
              <div class="accordion-body">
                <div class="alert alert-info">
                  <i class="fas fa-info-circle"></i> Component templates are automatically generated based on your color settings. They provide consistent styling for buttons, alerts, badges, and other components.
                </div>

                <div class="row">
                  <?php if (isset($variables)) : ?>
                    <?php foreach ($variables as $componentType => $componentConfig) : ?>
                      <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card">
                          <div class="card-header">
                            <h5 class="mb-0"><?= ucwords(str_replace('_', ' ', $componentType)) ?></h5>
                          </div>
                          <div class="card-body">
                            <?php if ($componentType === 'buttons') : ?>
                              <div class="d-flex flex-wrap gap-1 mb-2">
                                <?php foreach ($componentConfig['colors'] as $color) : ?>
                                  <button type="button" class="btn btn-<?= $color ?> btn-sm"><?= ucfirst($color) ?></button>
                                <?php endforeach; ?>
                              </div>
                              <div class="d-flex flex-wrap gap-1">
                                <?php foreach (array_slice($componentConfig['colors'], 0, 4) as $color) : ?>
                                  <button type="button" class="btn btn-outline-<?= $color ?> btn-sm"><?= ucfirst($color) ?></button>
                                <?php endforeach; ?>
                              </div>
                            <?php elseif ($componentType === 'alerts') : ?>
                              <?php foreach (array_slice($componentConfig['colors'], 0, 4) as $color) : ?>
                                <div class="alert alert-<?= $color ?> py-1 px-2 mb-1" style="font-size: 0.8rem;">
                                  <?= ucfirst($color) ?> alert
                                </div>
                              <?php endforeach; ?>
                            <?php elseif ($componentType === 'badges') : ?>
                              <div class="d-flex flex-wrap gap-1">
                                <?php foreach ($componentConfig['colors'] as $color) : ?>
                                  <span class="badge bg-<?= $color ?>"><?= ucfirst($color) ?></span>
                                <?php endforeach; ?>
                              </div>
                            <?php elseif ($componentType === 'list_groups') : ?>
                              <ul class="list-group list-group-flush" style="font-size: 0.8rem;">
                                <?php foreach (array_slice($componentConfig['colors'], 0, 5) as $color) : ?>
                                  <li class="list-group-item list-group-item-<?= $color ?> py-1 px-2"><?= ucfirst($color) ?></li>
                                <?php endforeach; ?>
                              </ul>
                            <?php elseif ($componentType === 'backgrounds') : ?>
                              <div class="d-flex flex-wrap gap-1">
                                <?php foreach ($componentConfig['colors'] as $color) : ?>
                                  <div class="rounded px-2 py-1 bg-<?= $color ?> <?= in_array($color, ['light', 'warning', 'info']) ? 'text-dark' : 'text-white' ?>" style="font-size: 0.75rem;">
                                    <?= ucfirst($color) ?>
                                  </div>
                                <?php endforeach; ?>
                              </div>
                            <?php else : ?>
                              <p class="mb-0 text-muted">Styles for: <?= implode(', ', $componentConfig['colors']) ?></p>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <div class="col-12">
                      <div class="alert alert-warning">
                        No component templates defined.
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php else : ?>
          <!-- Regular categories -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading-<?= $category ?>">
              <button class="accordion-button <?= ($category !== 'typography') ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $category ?>" aria-expanded="<?= ($category === 'typography') ? 'true' : 'false' ?>" aria-controls="collapse-<?= $category ?>">
                <?= str_replace("_", " ", ucfirst($category ?? "")); ?>
              </button>
            </h2>
            <div id="collapse-<?= $category ?>" class="accordion-collapse collapse <?= ($category === 'typography') ? 'show' : '' ?>" aria-labelledby="heading-<?= $category ?>" data-bs-parent="#customizer-accordion">
              <div class="accordion-body">
                <div class="row">
                  <?php foreach ($variables as $name => $set) :
                    if ($name == "custom_css_code") { ?>
                      <div class="col-12">
                      <?php } else { ?>
                        <div class="col-md-6 col-lg-4">
                        <?php } ?>

                        <?php renderInputField($name, $set); ?>
                        </div>
                      <?php endforeach; ?>
                      </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
          </div>

          <div class="d-flex flex-wrap justify-content-between align-items-center my-4 gap-2">
            <div class="d-flex flex-wrap gap-2">
              <button type="submit" name="process_css" value="1" class="btn btn-primary">
                <i class="fas fa-cog me-1"></i>
                <?= $childThemeMode ? 'Save Child Theme' : 'Save &amp; Apply Theme' ?>
              </button>
              <button type="submit" name="reset_defaults" value="1" class="btn btn-outline-danger" data-confirm="Reset all customizations on <?= $childThemeMode ? 'this child theme' : 'the parent theme' ?> back to default values?">
                <i class="fas fa-undo me-1"></i> Reset to Defaults
              </button>
            </div>
            <a href="<?= $us_url_root ?>users/admin.php" class="btn btn-secondary">
              <i class="fas fa-arrow-left me-1"></i> Back to Admin
            </a>
          </div>
  </form>
<?php endif; ?>
</div>
</div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Variable-name visibility toggle — hidden by default, choice persisted.
    const varToggle = document.getElementById('toggleVarNames');
    const accordionEl = document.getElementById('customizer-accordion');
    if (varToggle && accordionEl) {
      const showVars = localStorage.getItem('customizerShowVarNames') === '1';
      varToggle.checked = showVars;
      accordionEl.classList.toggle('customizer-show-varnames', showVars);
      varToggle.addEventListener('change', function() {
        accordionEl.classList.toggle('customizer-show-varnames', this.checked);
        localStorage.setItem('customizerShowVarNames', this.checked ? '1' : '0');
      });
    }

    // Accordion handling using Bootstrap's collapse events

    // First, close all accordion items (ensure none are open by default)
    document.querySelectorAll('.accordion-collapse').forEach(collapse => {
      collapse.classList.remove('show');
    });

    // Set up event listeners for Bootstrap collapse events to track open accordion item
    const accordionCollapses = document.querySelectorAll('.accordion-collapse');
    accordionCollapses.forEach(collapse => {
      collapse.addEventListener('shown.bs.collapse', function() {
        // Extract identifier from id, assuming id format is "collapse-<identifier>"
        const id = this.id.replace('collapse-', '');
        localStorage.setItem('lastOpenAccordionItem', id);
      });
      collapse.addEventListener('hidden.bs.collapse', function() {
        const id = this.id.replace('collapse-', '');
        if (localStorage.getItem('lastOpenAccordionItem') === id) {
          localStorage.removeItem('lastOpenAccordionItem');
        }
      });
    });

    // On page load, open the last opened accordion item if it exists
    const lastOpenItem = localStorage.getItem('lastOpenAccordionItem');
    if (lastOpenItem) {
      const collapseToShow = document.getElementById('collapse-' + lastOpenItem);
      if (collapseToShow) {
        // Use Bootstrap's Collapse API to show the accordion
        new bootstrap.Collapse(collapseToShow, {
          show: true
        });
      }
    }

    // Store initial values for all form fields for change tracking
    const fields = document.querySelectorAll('input, select, textarea');
    fields.forEach(field => {
      field.setAttribute('data-initial-value', field.value);
    });

    // Changed fields tracking
    const changedFields = new Set();
    window.trackChanges = function(fieldId) {
      const field = document.getElementById(fieldId);
      const initialValue = field.getAttribute('data-initial-value');
      if (field.value !== initialValue) {
        changedFields.add(fieldId);
      } else {
        changedFields.delete(fieldId);
      }
      // Update hidden field with the list of changed fields
      document.getElementById('changed_fields').value = Array.from(changedFields).join(',');
    };

    // Delegated change tracking — replaces the per-field inline onchange=
    // handlers, so the template carries no inline JS (clean under a strict CSP).
    const customizerForm = document.getElementById('customizerForm');
    if (customizerForm) {
      customizerForm.addEventListener('change', function(e) {
        const t = e.target;
        if (!t) return;
        // The hex text field paired with a color picker: mirror its value into
        // the color <input>, then track that input as changed.
        if (t.dataset && t.dataset.colorTarget) {
          const colorInput = document.getElementById(t.dataset.colorTarget);
          if (colorInput) {
            colorInput.value = t.value;
            trackChanges(t.dataset.colorTarget);
          }
          return;
        }
        if (t.id && t.id.indexOf('var_') === 0) {
          trackChanges(t.id);
        }
      });
    }

    // Delegated confirm() — replaces the old inline confirm handlers.
    // Any submit button carrying data-confirm prompts before its form submits.
    document.addEventListener('submit', function(e) {
      const btn = e.submitter;
      if (btn && btn.dataset && btn.dataset.confirm) {
        if (!window.confirm(btn.dataset.confirm)) {
          e.preventDefault();
        }
      }
    });
  });
</script>

<!-- Theme Explanation Modal -->
<div class="modal fade" id="themeExplanationModal" tabindex="-1" aria-labelledby="themeExplanationModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl wide-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="themeExplanationModalLabel">Understanding the Customizer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5>Types of Themes</h5>
        <p>The customizer allows you to take the standard Bootstrap values and customize them to be used on the front end of your site. Once you have saved your changes, the template will work and look just like any other UserSpice template. You can also have "child themes" which are presets that allow you to apply special styling to any particular page. Child themes start off as forks of your primary theme, but after that can be infinitely changed for your own purposes.</p>

        <h5>What is a Child Theme?</h5>
        <p>A child theme is a way to save a different "version" of your theme customizations. This allows you to create and switch between multiple visual styles for your UserSpice site without losing your customizations.</p>

        <h5>Light + Dark Theme Pairs</h5>
        <p>UserSpice has two surfaces &mdash; the <strong>front end</strong> (your public site) and the <strong>backend</strong> (the admin dashboard) &mdash; and each one can be assigned its own <strong>light theme</strong> and <strong>dark theme</strong>. Visitors see the pair through a sun/moon toggle. Choose <em>Disabled (light only)</em> in a dark slot to turn dark mode off for that surface.</p>
        <p>The live assignment lives in <span class='text-success'>usersc/templates/<?=$template_override?>/assets/css/theme_pair.php</span> and is written exclusively by the <strong>Site Themes</strong> panel at the top of the customizer &mdash; this is the only place a theme goes live. Loading a theme from the gallery below just opens it in the editor; it does not change what visitors see.</p>
        <p>The light theme for the front end is your <em>parent</em> theme (the one you edit with the controls further down the page); the light theme for the backend is the protected <code>dashboard</code> child theme. The dark theme for either surface can be any child theme whose <code>Mode:</code> header is set to <code>dark</code>.</p>

        <h5>Working with Child Themes</h5>
        <ul>
          <li><strong>Save as Child Theme:</strong> Saves your current customizations as a named child theme</li>
          <li><strong>Load &amp; Edit:</strong> Opens a child theme in the editor so you can preview and adjust it (does <em>not</em> put it live)</li>
          <li><strong>Site Themes panel:</strong> Assigns the live light/dark pair for the front end and the backend &mdash; this is where a theme goes live</li>
          <li><strong>Delete:</strong> Removes a child theme (except for the <code>dashboard</code> theme, which is protected)</li>
        </ul>

        <h5>Theme Metadata (Docblock Headers)</h5>
        <p>The gallery, the pickers, and the dark-mode pairing logic all read a small docblock at the top of each child theme PHP file. Recognized fields:</p>
        <ul>
          <li><code>Preset:</code> &mdash; human-readable title shown in the gallery and pickers</li>
          <li><code>Description:</code> &mdash; one-line summary shown on the gallery card</li>
          <li><code>Tags:</code> &mdash; comma-separated keywords (decorative)</li>
          <li><code>Mode:</code> &mdash; <code>light</code> or <code>dark</code>. Drives the sun/moon icon, the dark-theme picker, and pair detection</li>
          <li><code>Category:</code> &mdash; one of <em>Clean</em>, <em>Wild</em>, <em>Themed</em>, <em>My Themes</em>, <em>System</em>, or <em>Uncategorized</em>. Themes are bucketed by this in the gallery</li>
          <li><code>WCAG:</code> &mdash; set to <code>marginal</code> to flag a faithful palette that falls just below WCAG AA contrast on some buttons; gets a warning triangle in the gallery</li>
        </ul>

        <h5>Reading the Gallery</h5>
        <p>The gallery cards carry a few quick indicators:</p>
        <ul>
          <li><i class="fas fa-circle-half-stroke text-primary"></i> <strong>Half-circle (paired):</strong> this theme ships with both a light and a dark sibling (e.g. <code>solarized_light</code> + <code>solarized_dark</code>). A "family" is the theme name with any trailing <code>_light</code>/<code>_dark</code> stripped. Paired themes also show <code>◐</code> next to their name in the Site Themes pickers.</li>
          <li><i class="fas fa-moon text-secondary"></i> <strong>Moon:</strong> Mode is <code>dark</code> &mdash; eligible for a dark slot in a Site Themes pair.</li>
          <li><i class="fas fa-sun text-warning"></i> <strong>Sun:</strong> Mode is <code>light</code>.</li>
          <li><i class="fas fa-triangle-exclamation text-warning"></i> <strong>Warning triangle:</strong> WCAG marginal &mdash; the palette is reproduced faithfully but some labels are below AA contrast.</li>
        </ul>

        <h5>Loading Child Themes in Your Code</h5>
        <p>You can programmatically load a child theme by adding this code <strong>before</strong> including prep.php:</p>
        <pre class="bg-body-tertiary p-3 rounded">$child_theme = "your_theme_name";</pre>

        <p>For example, to load the "dashboard" theme:</p>
        <pre class="bg-body-tertiary p-3 rounded">$child_theme = "dashboard";
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';</pre>

        <h5>The UserSpice Menu (UltraMenu)</h5>
        <p>Please note that each UltraMenu has themes, and you should use the "custom" theme for the backgrounds and colors in the customizer to override your menu properly.</p>

        <h5>Custom CSS</h5>
        <p>Although there is a section for custom CSS, you can also create a css file <span class='text-success'>usersc/templates/theme_name.css</span> with your own custom css. This has the added benefit of working across parent and child themes.</p>

        <h5>Dark Mode &amp; Bootstrap Utilities</h5>
        <p>Bootstrap 5.3's <code>[data-bs-theme="dark"]</code> block flips the body/emphasis/secondary CSS variables, but it does <strong>not</strong> flip the hard-coded utility classes (<code>.bg-light</code>, <code>.bg-white</code>, <code>.text-muted</code>, <code>.text-dark</code>, <code>.text-light</code>, <code>.toast-body</code> &hellip;). Left alone, those produce white-on-white or dark-on-dark text the moment the theme inverts.</p>
        <p>Two safety nets sit in front of that:</p>
        <ul>
          <li><strong>Per-theme:</strong> when a child theme with <code>Mode: dark</code> is baked into a Site Themes pair, <code>processor.php</code> appends override rules to its generated CSS so those utilities resolve to theme-aware variables under <code>[data-bs-theme="dark"]</code>.</li>
          <li><strong>Site-wide:</strong> <span class='text-success'>users/css/dark-mode-safety.css</span> ships the same overrides for every page (loaded from <code>header1_must_include.php</code>), so even installs without a paired dark theme &mdash; and pages that don't touch the customizer at all &mdash; render readably in dark mode.</li>
        </ul>
        <p>When you author new pages, prefer the dark-aware Bootstrap utilities: <code>bg-body</code>, <code>bg-body-tertiary</code>, <code>text-body</code>, <code>text-body-emphasis</code>, <code>text-body-secondary</code>. Leave decorative pairings (e.g. <code>bg-warning text-dark</code> badges, <code>bg-dark text-light</code> code blocks) alone &mdash; both halves are intentionally non-flipping.</p>

        <h5>Customizing the Customizer</h5>

        <p>You can add/remove things to the <span class='text-danger'>$templateConfig</span> or <span class='text-danger'>$customizationFile</span> before they are used in the customizer by creating/editing the <code>usersc/templates/template_customizer_overrides.php</code> file. The folder <span class='text-success'>usersc/templates/<?=$template_override?>/assets/css/customizers</span> contains all the individual customizer files that make up the entire system. You can add your own files. The filename determines the order the css is loaded and processed.</p>


        <h5>Sharing your themes</h5>
        <p>You can share your child themes by sharing both the php and css file with the name of your child theme. To share a customized core template, you will share your custom-bootstrap-xxx.css file as well as the customizations.php file. They will also need to update revision.php so the builder recognizes that css filename. Pro tip, although the ui does not allow you to delete the dashboard child theme (because it's used on the dashboard), you can delete it manually and just create a new child theme called dashboard. </p>
        <p>The revisions.php file allows us to generate new css filenames which automatically break the cache for your users while still allowing the css files to be cached on subsequent loads.</p>

        <h5>Distributing this Theme</h5>
        <p>If you distribute/modify this code, it is recommended that you release it without the following files.
        <ul>
          <li>usersc/templates/<?=$template_override?>/assets/css/revision.php</li>
          <li>usersc/templates/<?=$template_override?>/assets/css/customizations.php</li>
          <li>usersc/templates/<?=$template_override?>/assets/css/custom-bootstrap-202xxxxxxxxx.css</li>
          <li>usersc/templates/<?=$template_override?>/assets/child_themes/dashboard.php</li>
          <li>usersc/templates/<?=$template_override?>/assets/child_themes/dashboard-202xxxxxxxxx.css</li>
        </ul>


        You can put defaults for these in <span class='text-success'>usersc/templates/<?=$template_override?>/assets/defaults</span> By doing this you will not overwrite anyone's existing files. The first time the template loads without finding usersc/templates/<?=$template_override?>/assets/css/customizations.php It will create a new set of defaults. Otherwise, the existing files will be left alone during the update process.</p>

        If you appreciate this work and would like to make a donation to the author, you can do so at <a href="https://UserSpice.com/donate">https://UserSpice.com/donate</a>. Either way, thanks for using UserSpice!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<style>
  .how-it-works-button {
    transition: all 0.5s ease;
    overflow: hidden;
    position: relative;
  }

  .button-highlight {
    box-shadow: 0 0 15px rgba(40, 167, 69, 0.7);
    transform: scale(1.1, 1);
    transform-origin: center;
  }

  @keyframes pulse {
    0% {
      box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
    }

    70% {
      box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
    }

    100% {
      box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
    }
  }

  .pulse-animation {
    animation: pulse 1.5s infinite;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const wideModals = document.querySelectorAll('.modal-dialog.modal-xl');
    
    // Apply the width to each modal
    wideModals.forEach(function(modal) {
      modal.style.maxWidth = '95vw';
      modal.style.width = '95vw';
    });

    // Get the button
    const howItWorksButton = document.querySelector('.how-it-works-button');

    // Store original width
    const originalWidth = howItWorksButton.offsetWidth;

    // Animate after a short delay
    setTimeout(function() {
      // Add highlight class - makes button wider
      howItWorksButton.classList.add('button-highlight');

      // After button expands, add pulsing effect
      setTimeout(function() {
        howItWorksButton.classList.add('pulse-animation');

        // Stop pulsing after a few seconds
        setTimeout(function() {
          howItWorksButton.classList.remove('pulse-animation');
        }, 3000);
      }, 600);
    }, 800);
  });
</script>


<!-- Select2 on the four Site-Themes pickers. jQuery is already loaded in
     header.php; Select2's default theme is used (no Bootstrap-5 add-on). The
     small CSS block aligns the rendered control with .form-select-sm heights
     and lets paired-theme rows show the ◐ glyph in their natural width. -->
<link rel="stylesheet" href="<?= $us_url_root ?>users/css/select2.min.css">
<script nonce="<?=htmlspecialchars($userspice_nonce ?? '')?>" type="text/javascript" src="<?= $us_url_root ?>users/js/select2.min.js"></script>
<style>
  /* Match Bootstrap .form-select-sm sizing so the picker doesn't grow the row */
  #fe_light_theme + .select2-container .select2-selection--single,
  #fe_dark_theme + .select2-container .select2-selection--single,
  #be_light_theme + .select2-container .select2-selection--single,
  #be_dark_theme + .select2-container .select2-selection--single {
    height: calc(1.5em + 0.5rem + 2px);
    padding: 0;
    border-color: var(--bs-border-color, #ced4da);
    border-radius: var(--bs-border-radius-sm, 0.25rem);
    font-size: 0.875rem;
  }
  #fe_light_theme + .select2-container .select2-selection__rendered,
  #fe_dark_theme + .select2-container .select2-selection__rendered,
  #be_light_theme + .select2-container .select2-selection__rendered,
  #be_dark_theme + .select2-container .select2-selection__rendered {
    line-height: calc(1.5em + 0.5rem);
    padding-left: 0.5rem;
    padding-right: 1.75rem;
    color: var(--bs-body-color);
  }
  #fe_light_theme + .select2-container .select2-selection__arrow,
  #fe_dark_theme + .select2-container .select2-selection__arrow,
  #be_light_theme + .select2-container .select2-selection__arrow,
  #be_dark_theme + .select2-container .select2-selection__arrow {
    height: calc(1.5em + 0.5rem);
  }

  /* Dark-mode treatment. Select2 ships hard-coded light colors on its chrome
     and renders its dropdown popup as a child of <body> (outside the original
     <select>'s DOM ancestor), so it doesn't inherit our theme automatically.
     Scope by [data-bs-theme="dark"] on <html> so both the rendered selection
     and the floating popup pick up dark surfaces. */
  [data-bs-theme="dark"] .select2-container--default .select2-selection--single {
    background-color: var(--bs-form-control-bg, var(--bs-body-bg)) !important;
    border-color: var(--bs-border-color) !important;
  }
  [data-bs-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: var(--bs-body-color) !important;
  }
  [data-bs-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: var(--bs-secondary-color) !important;
  }
  [data-bs-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-top-color: var(--bs-body-color) !important;
  }
  /* The popup is appended to <body>, so it sees [data-bs-theme="dark"] on <html>. */
  [data-bs-theme="dark"] .select2-dropdown {
    background-color: var(--bs-form-control-bg, var(--bs-body-bg)) !important;
    border-color: var(--bs-border-color) !important;
    color: var(--bs-body-color) !important;
  }
  [data-bs-theme="dark"] .select2-search--dropdown .select2-search__field {
    background-color: var(--bs-body-bg) !important;
    border-color: var(--bs-border-color) !important;
    color: var(--bs-body-color) !important;
  }
  [data-bs-theme="dark"] .select2-results__option {
    color: var(--bs-body-color) !important;
  }
  [data-bs-theme="dark"] .select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: var(--bs-secondary-bg) !important;
    color: var(--bs-emphasis-color) !important;
  }
  [data-bs-theme="dark"] .select2-container--default .select2-results__option[aria-selected="true"] {
    background-color: var(--bs-tertiary-bg) !important;
    color: var(--bs-body-color) !important;
  }
</style>
<script nonce="<?=htmlspecialchars($userspice_nonce ?? '')?>" type="text/javascript">
  jQuery(function($){
    $('#fe_light_theme, #fe_dark_theme, #be_light_theme, #be_dark_theme').select2({
      width: '100%',
      minimumResultsForSearch: 6,
      dropdownAutoWidth: true
    });
  });
</script>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>