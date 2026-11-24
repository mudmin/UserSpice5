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

// Permission check
if(!hasPerm([2],$user->data()->id)){

    usError("You do not have permission to access this page.");
    Redirect::to($us_url_root);
    exit();
}

require_once __DIR__ . '/compiler.php';
compileCustomizerTheme($childThemeName);

return true;
