<?php
require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/container_close.php';
require_once $abs_us_root . $us_url_root . 'users/includes/page_footer.php';
?>

<footer  id="footer" class="footer mt-auto border-top bg-light pt-3">
  <div class="container">
    <p class="text-center">&copy; <?php echo date("Y"); ?> <?=$settings->copyright; ?></p>
  </div>
</footer>

<?php
// Light/dark toggle — FALLBACK only.
//
// The primary toggle is the core UltraMenu snippet item
// (users/includes/menu_hooks/theme_toggle.php), which sets
// $GLOBALS['usThemeToggleRendered'] when it draws. This floating button is
// shown only when that didn't happen — e.g. file-based navigation, a page
// with no menu (login/reauth), or an admin who disabled the menu item — and
// only when a dark preset is paired. The core script users/js/theme-toggle.js
// wires every .us-theme-toggle element; header.php sets data-bs-theme pre-paint.
$customizerPairFile = $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/assets/css/theme_pair.php';
$customizerDarkPaired = false;
if (file_exists($customizerPairFile)) {
  $customizerPair = require $customizerPairFile;
  if (is_array($customizerPair)) {
    // This request is the backend when the dashboard child theme is loaded.
    $customizerSurface = (isset($child_theme) && $child_theme === 'dashboard') ? 'backend' : 'frontend';
    if (!isset($customizerPair['frontend']) && isset($customizerPair['dark'])) {
      $customizerDarkPaired = ($customizerSurface === 'frontend') && !empty($customizerPair['dark']);
    } else {
      $customizerDarkPaired = !empty($customizerPair[$customizerSurface]['dark']);
    }
  }
}
if ($customizerDarkPaired && empty($GLOBALS['usThemeToggleRendered'])) :
?>
<style>
  .customizer-theme-toggle {
    position: fixed;
    right: 1rem;
    bottom: 1rem;
    z-index: 1030;
    width: 2.85rem;
    height: 2.85rem;
    border-radius: 50%;
    border: 1px solid var(--bs-border-color, rgba(0, 0, 0, 0.15));
    background: var(--bs-body-bg, #ffffff);
    color: var(--bs-body-color, #212529);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    cursor: pointer;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
  }
  .customizer-theme-toggle:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.28);
  }
</style>
<button type="button" class="customizer-theme-toggle us-theme-toggle"
        aria-label="Toggle light or dark mode" aria-pressed="false" title="Switch to dark mode">
  <i class="fas fa-moon"></i>
</button>
<script nonce="<?= htmlspecialchars($userspice_nonce ?? '') ?>" defer src="<?= $us_url_root ?>users/js/theme-toggle.js"></script>
<?php endif; ?>

</body>

<?php require_once($abs_us_root.$us_url_root.'users/includes/html_footer.php');?>
