</div> <!-- close the container class that's set in the preferences -->
<?php foreach ($usplugins as $k => $v) {
  if ($v == 1) {
    if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $k . '/footer.php')) {
      include $abs_us_root . $us_url_root . 'usersc/plugins/' . $k . '/footer.php';
    }
  }
}

if (isset($use_template_footer) && $use_template_footer == true) {
  require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
} else {
  require_once $abs_us_root . $us_url_root . 'users/includes/page_footer.php';
?>
  <footer id="footer" class="footer mt-auto border-top bg-light py-3">
    <div class="container">
      <p class="text-center">&copy; <?php echo date("Y"); ?> <?= $settings->copyright; ?></p>
    </div>
  </footer>
<?php
}
