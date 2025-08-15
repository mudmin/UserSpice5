<?php
if (file_exists($abs_us_root . $us_url_root . 'usersc/views/_admin_menu.php')) {
  require_once $abs_us_root . $us_url_root . 'usersc/views/_admin_menu.php';
} else {
  require_once $abs_us_root . $us_url_root . 'users/views/_admin_menu.php';
}
