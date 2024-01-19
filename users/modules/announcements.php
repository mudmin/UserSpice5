<?php
if ($view == '' || $view == 'dashboard') {
  if ((time() - strtotime($settings->announce)) > 10800) {
    $db->update('settings', 1, ['announce' => date('Y-m-d H:i:s')]);
    require_once $abs_us_root . $us_url_root . 'users/views/_admin_announcements.php';
  }
}
