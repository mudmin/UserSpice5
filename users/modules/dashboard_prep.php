<?php 
$child_theme = "dashboard";
$core_template = $settings->template;

// save the original container_open_class so we can edit in general settings
$og_container_open_class = $settings->container_open_class;
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

if(!securePage(Server::get('PHP_SELF'))){
  die();
}
$chartsLoaded = "true"; //widget signal not to reload js
?>
<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js" integrity="sha512-CQBWl4fJHWbryGE+Pc7UAxWMUMNMWzWxF4SQo9CgkJIN1kx6djDQZjh3Y8SZ1d+6I+1zze6Z7kHXO7q3UyZAWw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/user_spice_ver.php'; ?>
