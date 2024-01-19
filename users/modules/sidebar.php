<div class="row flex-grow-1" id="page-wrap">
  <?php
  if (isset($dashboard_sidebar_menu) && $dashboard_sidebar_menu == true) {
    if (file_exists($abs_us_root . $us_url_root . "usersc/views/_admin_sidebar.php")) {
      require_once $abs_us_root . $us_url_root . 'usersc/views/_admin_sidebar.php';
    } else {
      require_once $abs_us_root . $us_url_root . 'users/views/_admin_sidebar.php'; // are these the same?
    }
  }
  ?>
