<?php
// Note: This is designed to allow you to create your own custom settings that will appear in the dashboard.
// By putting the settings here, they will not be overwritten by updates.  Note that you can also make
// settings appear on the statistics page by adding files to the usersc/widgets folder or adding the file
// usersc/includes/admin_panel_buttons.php

if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/admin_panel_custom_settings_post.php')) {
  require_once $abs_us_root . $us_url_root . 'usersc/includes/admin_panel_custom_settings_post.php';
} ?>

<h2>Custom Settings</h2>
<?php
if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/admin_panel_custom_settings.php')) {
  include $abs_us_root . $us_url_root . 'usersc/includes/admin_panel_custom_settings.php';
} else { ?>
  You can create your own custom settings in<br>
  usersc/includes/admin_panel_custom_settings_post.php<br>
  and<br>
  usersc/includes/admin_panel_custom_settings.php
  </div>

<?php } ?>