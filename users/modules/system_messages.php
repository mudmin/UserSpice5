<?php
    if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/system_messages_header.php')) {
      require_once $abs_us_root . $us_url_root . 'usersc/includes/system_messages_header.php';
    } else {
      require_once $abs_us_root . $us_url_root . 'users/includes/system_messages_header.php';
    } 
