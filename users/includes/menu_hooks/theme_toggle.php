<?php
/*
 * UltraMenu snippet — light / dark color-mode toggle.
 *
 * Rendered as a "snippet" menu item (added to the Main and Dashboard menus by
 * the 2026-05-17b update component). Menu.php includes this file and injects
 * its output straight into the menu <ul>, so everything it emits (including
 * the one-time <style>/<script>) stays inside its <li>.
 *
 * Self-gating: the toggle is emitted only when the ACTIVE template advertises
 * a dark color scheme via usersc/templates/<template>/dark_mode.php — a file
 * that returns a truthy value. On any template without that marker this file
 * outputs nothing, so the menu item is present but invisible (no dead link,
 * no stock-Bootstrap dark mode clashing with a light-only theme).
 *
 * CSP: the click wiring is external JS (users/js/theme-toggle.js); there are
 * no inline on* handlers. The injected <script> tag carries $userspice_nonce.
 *
 * Side effect: sets $GLOBALS['usThemeToggleRendered'] = true when the toggle
 * is emitted, so a template can suppress its own fallback toggle button.
 */

global $abs_us_root, $us_url_root, $settings, $userspice_nonce;

$tpl = isset($settings->template) ? $settings->template : '';
if ($tpl === '') {
    return;
}

// Neutral capability marker — see core_update_plan.md. The active template
// (e.g. the customizer) writes this when it ships a dark color scheme.
$marker = $abs_us_root . $us_url_root . 'usersc/templates/' . $tpl . '/dark_mode.php';
if (!is_file($marker) || !(require $marker)) {
    return; // active template has no dark color scheme — emit nothing
}

$GLOBALS['usThemeToggleRendered'] = true;
$nonce = htmlspecialchars($userspice_nonce ?? '', ENT_QUOTES, 'UTF-8');
?>
<li class="us-theme-toggle-item">
  <?php
  // An <a role="button"> rather than a <button> so every menu theme's link rules
  // (color, hover, padding) style it exactly like its neighbors. A fixed color
  // such as --bs-primary is a fill color and fails text contrast on dark menus.
  // theme-toggle.js adds the Space key and suppresses the "#" navigation.
  ?>
  <a href="#" role="button" class="us-theme-toggle" aria-pressed="false"
     aria-label="Toggle light or dark mode" title="Switch light / dark mode">
    <i class="fas fa-moon" aria-hidden="true"></i>
    <span class="labelText">Light / Dark Mode</span>
  </a>
<?php
// Load the wiring + scoped styling once, even if the toggle appears in more
// than one menu on the same page (Main + Dashboard).
if (empty($GLOBALS['usThemeToggleJsLoaded'])) {
    $GLOBALS['usThemeToggleJsLoaded'] = true;
    // Desktop: icon-only (label hidden, so drop the icon's label gap). Mobile
    // expanded view: the label becomes visible so it stops looking like a stray icon.
    echo '<style nonce="' . $nonce . '">'
       . 'ul.us_menu .us-theme-toggle-item .us-theme-toggle i{margin-right:0;}'
       . '.us-theme-toggle-item .us-theme-toggle .labelText{display:none;}'
       . '@media screen and (max-width:992px){'
       . 'ul.us_menu .us-theme-toggle-item .us-theme-toggle i{margin-right:10px;}'
       . 'ul.us_menu .us-theme-toggle-item .us-theme-toggle .labelText{'
       . 'display:inline;margin-right:0;}'
       . '}'
       . '</style>';
    echo '<script nonce="' . $nonce . '" defer src="'
       . htmlspecialchars($us_url_root, ENT_QUOTES, 'UTF-8')
       . 'users/js/theme-toggle.js?v='
       . filemtime($abs_us_root . $us_url_root . 'users/js/theme-toggle.js')
       . '"></script>';
}
?>
</li>
