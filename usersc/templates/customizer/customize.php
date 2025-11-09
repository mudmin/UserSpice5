<?php
require_once "assets/template_name.php";
require_once '../../../users/init.php';
if (Input::get('child_theme') != "") {
  $child_theme = Input::get('child_theme');
}
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

if (!hasPerm([2], $user->data()->id)) {
  logger($user->data()->id, "Permissions", "User attempted to access template customizer without permission");
  usError("You do not have permission to access this page. This has been logged.");
  Redirect::to($us_url_root);
}

// Create the child_themes directory if it doesn't exist
$childThemesDir = $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/child_themes';
if (!is_dir($childThemesDir)) {
  mkdir($childThemesDir, 0755, true);
}

if (!empty($_POST)) {
  // token check
  if (!Token::check(Input::get('csrf'))) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }
}

// Apply child theme as standard theme
if (!empty($_POST['apply_as_standard'])) {
  $themeToApply = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get('apply_theme_name'));
  $sourceFile = $childThemesDir . '/' . $themeToApply . '.php';
  $destFile = $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/customizations.php';

  if (file_exists($sourceFile)) {
    // Copy the customizations from child theme to the standard theme
    copy($sourceFile, $destFile);

    // Generate the CSS file
    require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/processor.php';

    usSuccess("Child theme '$themeToApply' has been applied as your standard theme");
  } else {
    usError("Child theme file not found");
  }

  Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php');
}

// Delete a child theme
if (!empty($_POST['delete_child_theme'])) {
  $themeToDelete = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get('delete_theme_name'));

  // Don't allow deleting the dashboard theme
  if ($themeToDelete === 'dashboard') {
    usError("The dashboard theme cannot be deleted as it's required by the system.");
  } else {
    $themeFile = $childThemesDir . '/' . $themeToDelete . '.php';
    $cssFile = $childThemesDir . '/' . $themeToDelete . '.css';

    $deleted = false;
    if (file_exists($themeFile)) {
      unlink($themeFile);
      $deleted = true;
    }

    if (file_exists($cssFile)) {
      unlink($cssFile);
      $deleted = true;
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

      // Process all form fields to get current values
      foreach ($templateConfig as $category => $variables) {
        // Skip component_templates as it has a different structure
        if ($category === 'component_templates') continue;

        foreach ($variables as $name => $set) {
          if (isset($set['variable'])) {
            $varName = str_replace('--bs-', '', $set['variable']);
            $inputName = 'var_' . $varName;

            // Only include fields that exist in the form
            if (isset($_POST[$inputName])) {
              $customizations[$varName] = Input::get($inputName);
            }
          }
        }
      }

      // Handle special case for custom CSS if it exists
      if (isset($_POST['var_custom_css_code'])) {
        $customizations['custom_css'] = Input::get('var_custom_css_code');
      }

      // Save to child theme file
      file_put_contents($customizationFile, "<?php\nreturn " . var_export($customizations, true) . ";\n");

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
  }


  // Generate a new CSS file with default values
  require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/processor.php';

  // Get the current child theme if one is active
  $currentActiveTheme = '';
  if (!empty(Input::get('child_theme'))) {
    $currentActiveTheme = Input::get('child_theme');
  } elseif (!empty($_POST['active_child_theme'])) {
    $currentActiveTheme = $_POST['active_child_theme'];
  }

  // Keep the child theme loaded but with default values
  if (!empty($currentActiveTheme)) {
    usSuccess("Settings have been reset to default values while maintaining your child theme selection");
    Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php?child_theme=' . urlencode($currentActiveTheme));
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

  // Save to child theme file, overwriting the existing one
  file_put_contents($customizationFile, "<?php\nreturn " . var_export($customizations, true) . ";\n");

  usSuccess("Child theme '$themeName' has been overwritten successfully");
  $currentChildTheme = $themeName;
  Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php?child_theme=' . urlencode($currentChildTheme));
}

if (!empty($_POST['confirm_overwrite_no'])) {
  // User decided not to overwrite
  Redirect::to($us_url_root . 'usersc/templates/' . $template_override . '/customize.php');
}

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
      $customizations[$varName] = Input::get($fieldName);
    }
  }

  // Check if we're in child theme mode
  if (!empty($_POST['active_child_theme'])) {

    $childThemeName = preg_replace('/[^a-zA-Z0-9_]/', '_', Input::get('active_child_theme'));
    $childThemeFile = $childThemesDir . '/' . $childThemeName . '.php';

    // Save to the child theme file
    file_put_contents($childThemeFile, "<?php\nreturn " . var_export($customizations, true) . ";\n");

    $currentChildTheme = $childThemeName;
  } else {
    // Save to the regular customization file when not in child theme mode
    $customizationFile = $abs_us_root . $us_url_root . 'usersc/templates/' . $template_override . '/assets/css/customizations.php';
    file_put_contents($customizationFile, "<?php\nreturn " . var_export($customizations, true) . ";\n");
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

  switch ($set['type']) {
    case 'textarea':
      echo '<textarea class="form-control" id="' . $inputName . '" name="' . $inputName . '" rows="18" width="100%" onchange="trackChanges(\'' . $inputName . '\')">' . $value . '</textarea>';
      break;

    case 'color':
      echo '<div class="input-group">';
      echo '<input type="color" class="form-control form-control-color" id="' . $inputName . '" name="' . $inputName . '" value="' . $value . '" onchange="trackChanges(\'' . $inputName . '\')">';
      echo '<input type="text" class="form-control" aria-label="Color HEX value" value="' . $value . '" 
                onchange="document.getElementById(\'' . $inputName . '\').value = this.value; trackChanges(\'' . $inputName . '\')">';
      echo '</div>';
      break;

    case 'var-reference':
      echo '<select class="form-select" id="' . $inputName . '" name="' . $inputName . '" onchange="trackChanges(\'' . $inputName . '\')">';

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
      echo '<select class="form-select" id="' . $inputName . '" name="' . $inputName . '" onchange="trackChanges(\'' . $inputName . '\')">';

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
      echo '<input type="text" class="form-control" id="' . $inputName . '" name="' . $inputName . '" value="' . $value . '" onchange="trackChanges(\'' . $inputName . '\')">';
      break;

    case 'font-family':
      echo '<textarea class="form-control" id="' . $inputName . '" name="' . $inputName . '" rows="2" onchange="trackChanges(\'' . $inputName . '\')">' . $value . '</textarea>';
      break;

    case 'number':
      echo '<input type="number" class="form-control" id="' . $inputName . '" name="' . $inputName . '" value="' . $value . '" onchange="trackChanges(\'' . $inputName . '\')">';
      break;

    default:
      echo '<input type="text" class="form-control" id="' . $inputName . '" name="' . $inputName . '" value="' . $value . '" onchange="trackChanges(\'' . $inputName . '\')">';
  }

  echo '<div class="form-text">Variable: ' . $set['variable'] . '</div>';
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
      <?php else : ?>

        <div class="alert <?= $bannerTheme ?>">
          <i class="fas fa-info-circle"></i> Changes will be applied after clicking the "Save CSS" button.
          <?php if ($childThemeMode) : ?>
            <strong>You are currently editing the "<?= htmlspecialchars($currentChildTheme) ?>" child theme.</strong>
          <?php endif; ?>
        </div>

        <!-- Child Theme Management -->
        <div class="card mb-4">
          <div class="card-header bg-light">
            <div class="row">
              <div class="col-12">
                <h5 class="mb-0">Child Theme Management</h5>
              </div>
              <!-- <div class="col-12 col-md-4 text-end">

              </div> -->

            </div>
          </div>
          <div class="card-body bg-white">
            <div class="row">
              <div class="col-md-6">
                <form method="post" action="" class="mb-3">
                  <?= tokenHere(); ?>
                  <div class="input-group">
                    <input type="text" name="child_theme_name" class="form-control" placeholder="Enter child theme name" required value="<?= htmlspecialchars($currentChildTheme) ?>">
                    <button type="submit" name="save_child_theme" value="1" class="btn btn-sm btn-success">
                      <i class="fas fa-save"></i> Save as Child Theme
                    </button>
                  </div>
                </form>
              </div>
              <div class="col-md-6">
                <form method="post" action="" class="mb-3">
                  <?= tokenHere(); ?>
                  <div class="input-group">
                    <select name="child_theme_select" class="form-select">
                      <option value="">-- Select a child theme --</option>
                      <?php foreach ($childThemes as $theme) : ?>
                        <option value="<?= htmlspecialchars($theme) ?>" <?= ($theme === $currentChildTheme) ? 'selected' : '' ?>>
                          <?= htmlspecialchars($theme) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                    <button type="submit" name="load_child_theme" value="1" class="btn btn-sm btn-primary">
                      <i class="fas fa-upload"></i> Load Child Theme
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <?php if (!empty($childThemes)) : ?>
              <div class="table-responsive mt-3">
                <table class="table table-sm table-bordered">
                  <thead class="table-light">
                    <tr>
                      <th>Theme Name</th>
                      <th class="text-center">Load</th>
                      <th class="text-center">Push to Primary</th>
                      <th class="text-center">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($childThemes as $theme) : ?>
                      <tr>
                        <td><?= htmlspecialchars($theme) ?></td>
                        <td class="text-center">
                          <form method="post" action="">
                            <?= tokenHere(); ?>
                            <input type="hidden" name="child_theme_select" value="<?= htmlspecialchars($theme) ?>">
                            <button type="submit" name="load_child_theme" value="1" class="btn btn-sm btn-outline-primary">
                              <i class="fas fa-upload"></i> Load
                            </button>
                          </form>
                        </td>
                        <td class="text-center">
                          <form method="post" action="">
                            <?= tokenHere(); ?>
                            <input type="hidden" name="apply_theme_name" value="<?= htmlspecialchars($theme) ?>">
                            <button type="submit" name="apply_as_standard" value="1" class="btn btn-sm btn-outline-success" onclick="return confirm('Are you sure you want to apply this child theme as your standard theme?  You will have one extra step where you must save css to lock these changes in to actually generate that css.');">
                              <i class="fas fa-check-circle"></i> Apply
                            </button>
                          </form>
                        </td>
                        <td class="text-center">
                          <?php if ($theme !== 'dashboard') : ?>
                            <form method="post" action="">
                              <?= tokenHere(); ?>
                              <input type="hidden" name="delete_theme_name" value="<?= htmlspecialchars($theme) ?>">
                              <input type="hidden" name="child_theme" value="<?= htmlspecialchars($currentChildTheme) ?>">
                              <button type="submit" name="delete_child_theme" value="1" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this child theme? This cannot be undone.');">
                                <i class="fas fa-trash-alt"></i> Delete
                              </button>
                            </form>
                          <?php else : ?>
                            <span class="text-muted">—</span>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
        </div>





    </div>
  </div>

  <form method="post" action="" id="customizerForm">
    <?= tokenHere(); ?>
    <div class="d-flex justify-content-between my-4">
      <div>
        <button type="submit" name="process_css" value="1" class="btn btn-sm btn-primary">
          <i class="fas fa-cog"></i> Save CSS
        </button>
        <button type="submit" name="reset_defaults" value="1" class="btn btn-sm btn-outline-danger ms-2" onclick="return confirm('Are you sure you want to reset all customizations to default values?');">
          <i class="fas fa-undo"></i> Reset to Defaults
        </button>

        <?php if ($childThemeMode) : ?>


          <button type="submit" name="unload_child_theme" value="1" class="btn btn-sm btn-outline-secondary ms-2" onclick="return confirm('Are you sure you want to unload the child theme and edit the core theme?');">
            <i class="fas fa-times-circle"></i> Unload Child Theme and Edit Core Theme

          <?php endif; ?>


      </div>
      <a href="<?= $us_url_root ?>users/admin.php" class="btn btn-sm btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Admin
      </a>
    </div>
    <?= tokenHere(); ?>
    <!-- Hidden field to track which fields changed -->
    <input type="hidden" name="changed_fields" id="changed_fields" value="">

    <?php if (!empty($currentChildTheme)) : ?>
      <!-- Hidden field to track active child theme -->
      <input type="hidden" name="active_child_theme" value="<?= htmlspecialchars($currentChildTheme) ?>">
    <?php endif; ?>
    <p class="ps-2">Customize your UserSpice theme by adjusting the variables below.</p>
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
                    <?php foreach ($variables as $componentType => $config) : ?>
                      <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card">
                          <div class="card-header">
                            <h5 class="mb-0"><?= ucfirst($componentType) ?></h5>
                          </div>
                          <div class="card-body">
                            <p>Includes styles for: <?= implode(', ', $config['colors']) ?></p>
                            <p>Templates: <?= implode(', ', array_keys($config['templates'])) ?></p>
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

          <div class="d-flex justify-content-between my-4">
            <div>
              <button type="submit" name="process_css" value="1" class="btn btn-sm btn-primary">
                <i class="fas fa-cog"></i> Save CSS
              </button>
              <button type="submit" name="reset_defaults" value="1" class="btn btn-sm btn-outline-danger ms-2" onclick="return confirm('Are you sure you want to reset all customizations to default values?');">
                <i class="fas fa-undo"></i> Reset to Defaults
              </button>
            </div>
            <a href="<?= $us_url_root ?>users/admin.php" class="btn btn-sm btn-secondary">
              <i class="fas fa-arrow-left"></i> Back to Admin
            </a>
          </div>
  </form>
<?php endif; ?>
</div>
</div>
</div>

<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
  document.addEventListener('DOMContentLoaded', function() {
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

    // Add form submit handler to ensure we only process changed fields
    // document.getElementById('customizerForm').addEventListener('submit', function(e) {
    //   if (e.submitter && e.submitter.name === 'process_css') {
    //     const changedFieldsValue = document.getElementById('changed_fields').value;
    //     if (!changedFieldsValue) {
    //       e.preventDefault();
    //       alert('No changes detected. Please modify at least one setting before processing.');
    //     }
    //   }
    // });
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
        <p>The customizer allows you to take the standard bootstrap values and customize them to be used on the front end of your site. Once you have saved your changes, the template will work and look just like any other UserSpice template. You can also have "child themes" which are presets that allow you to apply special styling to any particular page. Child themes start off as forks of your primary theme,but but after that, can be infinitely changed for your own purposes.</p>

        <h5>What is a Child Theme?</h5>
        <p>A child theme is a way to save a different "version" of your theme customizations. This allows you to create and switch between multiple visual styles for your UserSpice site without losing your customizations.</p>

        <h5>Working with Child Themes</h5>
        <ul>
          <li><strong>Save as Child Theme:</strong> Saves your current customizations as a named child theme</li>
          <li><strong>Load Child Theme:</strong> Applies a previously saved child theme to your site</li>
          <li><strong>Apply as Standard:</strong> Makes a child theme your default standard theme</li>
          <li><strong>Delete:</strong> Removes a child theme (except for the 'dashboard' theme which is protected)</li>
        </ul>

        <h5>Loading Child Themes in Your Code</h5>
        <p>You can programmatically load a child theme by adding this code <strong>before</strong> including prep.php:</p>
        <pre class="bg-light p-3 rounded">$child_theme = "your_theme_name";</pre>

        <p>For example, to load the "dashboard" theme:</p>
        <pre class="bg-light p-3 rounded">$child_theme = "dashboard";
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';</pre>

        <h5>The UserSpice Menu (UltraMenu)</h5>
        <p>Please note that each UltraMenu has themes, and you should use the "custom" theme for the backgrounds and colors in the customizer to override your menu properly.</p>

        <h5>Custom CSS</h5>
        <p>Although there is a section for custom CSS, you can also create a css file <span class='text-success'>usersc/templates/theme_name.css</span> with your own custom css. This has the added benefit of working across child parent and themes.</p>

        <h5>Customizing the Customizer</h5>

        <p>You can add/remove things to the <span class='text-danger'>$templateConfig</span> or <span class='text-danger'>$customizationFile</span> before they are used in the customizer by creating/editing the <code>usersc/templates/template_customizer_overrides.php</code> file. The folder <span class='text-success'>usersc/templates/customizer/assets/css/customizers</span> contains all the individual customizer files that make up the entire system. You can add your own files. The filename determines the order the css is loaded and processed.</p>


        <h5>Sharing your themes</h5>
        <p>You can share your child themes by sharing both the php and css file with the name of your child theme. To share a customized core template, you will share your custom-bootstrap-xxx.css file as well as the customizations.php file. They will also need to update revision.php so the builder recognizes that css filename. Pro tip, although the ui does not allow you to delete the dashboard child theme (because it's used on the dashboard), you can delete it manually and just create a new child theme called dashboard. </p>
        <p>The revisions.php file allows us to generate new css filenames which automatically break the cache for your users while still allowing the css files to be cached on subsequent loads.</p>

        <h5>Distributing this Theme</h5>
        <p>If you distribute/modify this code, it is recommended that you release it without the following files.
        <ul>
          <li>usersc/templates/customizer/assets/css/revision.php</li>
          <li>usersc/templates/customizer/assets/css/customizations.php</li>
          <li>usersc/templates/customizer/assets/css/custom-bootstrap-202xxxxxxxxx.css</li>
          <li>usersc/templates/customizer/assets/child_themes/dashboard.php</li>
          <li>usersc/templates/customizer/assets/child_themes/dashboard-202xxxxxxxxx.css</li>
        </ul>


        You can put defaults for these in <span class='text-success'>usersc/templates/customizer/assets/defaults</span> By doing this you will not overwrite anyone's existing files. The first time the template loads without finding usersc/templates/customizer/assets/css/customizations.php It will create a new set of defaults. Otherwise, the existing files will be left alone during the update process.</p>

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

<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
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


<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>