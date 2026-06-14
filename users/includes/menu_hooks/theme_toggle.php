<?php
/*
 * UltraMenu snippet — light / dark colour-mode toggle.
 *
 * Rendered as a "snippet" menu item (added to the Main and Dashboard menus by
 * the 2026-05-17b update component). Menu.php includes this file and injects
 * its output straight into the menu <ul>.
 *
 * Self-gating: the toggle is emitted only when the ACTIVE template advertises
 * a dark colour scheme via usersc/templates/<template>/dark_mode.php — a file
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
// (e.g. the customizer) writes this when it ships a dark colour scheme.
$marker = $abs_us_root . $us_url_root . 'usersc/templates/' . $tpl . '/dark_mode.php';
if (!is_file($marker) || !(require $marker)) {
    return; // active template has no dark colour scheme — emit nothing
}

$GLOBALS['usThemeToggleRendered'] = true;
$nonce = htmlspecialchars($userspice_nonce ?? '', ENT_QUOTES, 'UTF-8');
?>
<li class="ms-2 me-2 us-theme-toggle-item">
  <button type="button" class="nav-link us-theme-toggle" aria-pressed="false"
          aria-label="Toggle light or dark mode" title="Switch light / dark mode">
    <i class="fas fa-moon" aria-hidden="true"></i>
    <span class="labelText">Light / Dark Mode</span>
  </button>
</li>
<?php
// Load the wiring + scoped styling once, even if the toggle appears in more
// than one menu on the same page (Main + Dashboard). The colour uses the
// theme's own --bs-primary variable, so it stays on-theme in light and dark.
if (empty($GLOBALS['usThemeToggleJsLoaded'])) {
    $GLOBALS['usThemeToggleJsLoaded'] = true;
    // Desktop: button is icon-only (label hidden). Mobile expanded view: button
    // takes full row width with the menu's standard item padding and the label
    // becomes visible so it stops looking like a stray icon.
    echo '<style nonce="' . $nonce . '">'
       . '.us-theme-toggle-item .us-theme-toggle{'
       . 'background:transparent;border:0;cursor:pointer;'
       . 'color:var(--bs-primary);}'
       . '.us-theme-toggle-item .us-theme-toggle:hover{'
       . 'color:var(--bs-primary);opacity:.7;}'
       . '.us-theme-toggle-item .us-theme-toggle .labelText{display:none;}'
       . '@media screen and (max-width:992px){'
       . 'ul.us_menu .us-theme-toggle-item{margin-left:0;margin-right:0;}'
       . 'ul.us_menu .us-theme-toggle-item .us-theme-toggle{'
       . 'width:100%;padding:5px 18px;}'
       . 'ul.us_menu .us-theme-toggle-item .us-theme-toggle .labelText{'
       . 'display:inline;margin-right:0;}'
       . '}'
       . '</style>';
    echo '<script nonce="' . $nonce . '" defer src="'
       . htmlspecialchars($us_url_root, ENT_QUOTES, 'UTF-8')
       . 'users/js/theme-toggle.js"></script>';
}
