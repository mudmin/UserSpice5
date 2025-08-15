    <!-- admin messages -->
    <div id="messages" class="sufee-alert alert with-close alert-primary alert-dismissible fade show d-none">
      <span id="message"></span>
      <button type="button" class="close btn-close" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php require_once $abs_us_root . $us_url_root . 'users/views/_admin_header.php';

    if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/admin_override.php')) {
      include $abs_us_root . $us_url_root . 'usersc/includes/admin_override.php';
    }
    ?>
    <!-- debug/maintenance mode -->
    <?php
    if ($settings->site_offline > 0 || $settings->debug > 0) { ?>
      <div class="row">
        <?php if ($settings->site_offline > 0) { ?>
          <div class="col-12 col-sm-6">
            <div class="alert alert-danger">
              <svg class="me-2" role="img" aria-label="Danger:" style="height:16px;width:16px;" fill="CurrentColor">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
              </svg>
              Maintenance Mode Active
            </div>
          </div>
        <?php } ?>
        <?php if ($settings->debug > 0) { ?>
          <div class="col-12 col-sm-6">
            <div class="alert alert-warning">
              <svg class="me-2" role="img" aria-label="Warning:" style="height:16px;width:16px;" fill="CurrentColor">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
              </svg>
              Debug Mode Active
              <a class="alert-link ms-3" href="<?= $us_url_root ?>users/admin.php?view=logs&mode=debug">
                View Debug Logs
              </a>
            </div>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
