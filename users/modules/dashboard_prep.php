<?php 
// change container_open_class so pages will be full-height.
$settings->container_open_class = "container-fluid d-flex flex-column flex-grow-1";
$settings->navigation_type = 1;
if(file_exists($abs_us_root . $us_url_root . 'usersc/includes/dashboard_overrides.php')){
  require_once $abs_us_root . $us_url_root . 'usersc/includes/dashboard_overrides.php';
}
if (isset($template_override)) {
  $settings->template = $template_override;
}

require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

if (ipCheckBan()) {
  Redirect::to($us_url_root . 'usersc/scripts/banned.php');
  die();
}
include $abs_us_root . $us_url_root . 'users/includes/dashboard_language.php';

if (!securePage($_SERVER['PHP_SELF'])) {
  die();
}
$chartsLoaded = "true"; //widget signal not to reload js
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/user_spice_ver.php'; ?>
