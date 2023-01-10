<?php
/*
UserSpice 5
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
ini_set('max_execution_time', 1356);
ini_set('memory_limit', '1024M');
?>
<?php
require_once '../users/init.php';
// change container_open_class so pages will be full-height.
$settings->container_open_class = "container-fluid d-flex flex-column flex-grow-1";
$settings->navigation_type = 1;
require_once $abs_us_root . $us_url_root . 'usersc/includes/dashboard_overrides.php';
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
<?php $view = Input::get('view'); ?>
<?php

if (file_exists($abs_us_root . $us_url_root . 'usersc/views/_admin_menu.php')) {
  require_once $abs_us_root . $us_url_root . 'usersc/views/_admin_menu.php';
} else {
  require_once $abs_us_root . $us_url_root . 'users/views/_admin_menu.php';
}
if ($view == '' || $view == 'dashboard') {
  if ((time() - strtotime($settings->announce)) > 10800) {
    $db->update('settings', 1, ['announce' => date('Y-m-d H:i:s')]);
    require_once $abs_us_root . $us_url_root . 'users/views/_admin_announcements.php';
  }
}

?>
<style media="screen">
  .grippy {
    cursor: grab;
  }

  .dashboard-icon-label {
    margin-top: .3rem;
    font-size: .75rem;
    line-height: .75rem;
  }

  .font-info {
    color: var(--bs-link-color);
    padding-left: .25rem;
  }

  .dash-icon {
    height: 2.8rem;
    max-width: 3.2rem;
  }

  .dashboard-icon-label {
    line-height: 1rem;
  }

  .collapseCard {
    cursor: pointer;
    padding-left: .5rem;
    padding-right: .5rem;
  }

  .card-title-text {
    font-weight: 650;
  }

  .dash-card {
    width: 48%;
    margin: 1%;
    padding-left: 0px;
    padding-right: 0px;
  }

  @media only screen and (max-width: 960px) {
    .dash-card {
      width: 100%;
      margin: 0%;
    }
  }

  form label,
  th {
    font-weight: 600;
  }

  p {
    margin: 0em;
  }

  .form-group {
    margin-bottom: 1rem;
  }

  .hideMe {
    display: none;
  }

  .offset-switch {
    margin-top: .5rem;
  }

  .offset-circle {
    margin-bottom: .5rem;
  }
</style>

<div class="row flex-grow-1" id="page-wrap">
  <?php
  if ($dashboard_sidebar_menu == true) {
    if (file_exists($abs_us_root . $us_url_root . "usersc/views/_admin_sidebar.php")) {
      require_once $abs_us_root . $us_url_root . 'usersc/views/_admin_sidebar.php';
    } else {
      require_once $abs_us_root . $us_url_root . 'users/views/_admin_sidebar.php'; // are these the same?
    }
  }
  ?>
  <div class="col content my-3">
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
    <!-- load page content -->
    <?php
    switch ($view) {
      case 'access':
        $path = usView('_dashboard_access.php');
        include $path;
        break;
      case 'backup':
        $path = usView('_admin_tools_backup.php');
        include $path;
        break;
      case 'bugs':
        $path = usView('_bug_report.php');
        include $path;
        break;
      case 'cron':
        $path = usView('_admin_cron.php');
        include $path;
        break;
      case 'custom':
        $path = usView('_admin_settings_custom.php');
        include $path;
        break;
      case 'email':
        $path = usView('_admin_email.php');
        include $path;
        break;
      case 'email_test':
        $path = usView('_admin_email_test.php');
        include $path;
        break;
      case 'general':
        $path = usView('_admin_settings_general.php');
        include $path;
        break;
      case 'ip':
        $path = usView('_admin_manage_ip.php');
        include $path;
        break;
      case 'legacy':
        if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/admin_panels.php')) {
          include $abs_us_root . $us_url_root . 'usersc/includes/admin_panels.php';
        } else {
          usError("Legacy files not found");
          Redirect::to('admin.php?view=stats');
        }
        break;
      case 'logs':
        $path = usView('_admin_logs.php');
        include $path;
        break;
      case 'nav':
        $path = usView('_admin_nav.php');
        include $path;
        break;
      case 'menus':
        $path = usView('_admin_menus.php');
        include $path;
        break;
      case 'menu_form':
        $path = usView('_admin_menu_form.php');
        include $path;
        break;
      case 'edit_menu':
        $path = usView('_admin_menu_edit.php');
        include $path;
        break;
      case 'delete_menu':
        $path = usView('_admin_menu_delete.php');
        include $path;
        break;
      case 'delete_menu_item':
        $path = usView('_admin_menu_delete_item.php');
        include $path;
        break;
      case 'nav_item':
        $path = usView('_admin_nav_item.php');
        include $path;
        break;
      case 'page':
        $path = usView('_admin_page.php');
        include $path;
        break;
      case 'pages':
        $path = usView('_admin_pages.php');
        include $path;
        break;
      case 'permission':
        $path = usView('_admin_permissions.php'); //compatibility
        include $path;
        break;
      case 'permissions':
        $path = usView('_admin_permissions.php');
        include $path;
        break;
      case 'pin':
        $path = usView('_admin_pin.php');
        include $path;
        break;
      case 'plugins':
        $path = usView('_admin_plugins.php');
        include $path;
        break;
      case 'plugins_config':
        $plugin = Input::get('plugin');
        if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/configure.php')) {
          if (file_exists($abs_us_root . $us_url_root . 'users/views/_configure_plugin_header.php')) {
            include $abs_us_root . $us_url_root . 'users/views/_configure_plugin_header.php';
          }
          include $abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/configure.php';
          echo '</div>'; // what is this for?
        }
        break;
      case 'reg':
        $path = usView('_admin_settings_register.php');
        include $path;
        break;
      case 'security_logs':
        $path = usView('_admin_security_logs.php');
        include $path;
        break;
      case 'sessions':
        $path = usView('_admin_sessions.php');
        include $path;
        break;
      case 'spice':
        $path = usView('_spice_shaker.php');
        include $path;
        break;
      case 'stats':
        $path = usView('_admin_statistics.php');
        include $path;
        break;
      case 'templates':
        $path = usView('_admin_templates.php');
        include $path;
        break;
      case 'updates':
        $path = usView('_admin_tools_check_updates.php');
        include $path;
        break;
      case 'user':
        $path = usView('_admin_user.php');
        include $path;
        break;
      case 'users':
        $path = usView('_admin_users.php');
        include $path;
        break;
      case 'verify':
        $path = usView('_admin_verify.php');
        include $path;
        break;
      default:
        if ($view == '') {
          include $abs_us_root . $us_url_root . 'users/views/_admin_dashboard.php';
        } else {
          $path = usView($view . '.php');
          include $path;
        }
    }

    if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/system_messages_header.php')) {
      require_once $abs_us_root . $us_url_root . 'usersc/includes/system_messages_header.php';
    } else {
      require_once $abs_us_root . $us_url_root . 'users/includes/system_messages_header.php';
    }
    ?>
  </div> <!-- .content -->
</div><!-- .row -->

<?php
if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/system_messages_footer.php')) {
  require_once $abs_us_root . $us_url_root . 'usersc/includes/system_messages_footer.php';
} else {
  require_once $abs_us_root . $us_url_root . 'users/includes/system_messages_footer.php';
}
?>

<script type="text/javascript">
  $(document).ready(function() {
    $('[data-toggle="popover"]').popover();

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })


    function messages(data) {
      console.log(data.msg);
      console.log("messages found");
      $('#messages').removeClass();
      $('#message').text("");
      $('#messages').show();
      if (data.success == "true") {
        $('#messages').addClass("sufee-alert alert with-close alert-success alert-dismissible fade show");
      } else {
        $('#messages').addClass("sufee-alert alert with-close alert-success alert-dismissible fade show");
      }

      $('#message').html(data.msg);
      $('#messages').delay(3000).fadeOut('slow');

    }

    $(".toggle").change(function() {
      var value = $(this).prop("checked");
      $(this).prop("checked", value);

      var field = $(this).attr("id"); //the id in the input tells which field to update
      var desc = $(this).attr("data-desc"); //For messages
      var formData = {
        'value': value,
        'field': field,
        'desc': desc,
        'type': 'toggle',
        'token': "<?= Token::generate() ?>",
      };

      $.ajax({
          type: 'POST',
          url: 'parsers/admin_settings.php',
          data: formData,
          dataType: 'json',
        })

        .done(function(data) {
          messages(data);
        })
    });

    $("#force_user_pr").click(function(data) {
      console.log("clicked");
      var formData = {
        'type': 'resetPW',
        'token': "<?= Token::generate() ?>",
      };
      $.ajax({
          type: 'POST',
          url: 'parsers/admin_settings.php',
          data: formData,
          dataType: 'json',
          encode: true
        })
        .done(function(data) {
          messages(data);
        })
    });

    $(".ajxnum").change(function() {
      var value = $(this).val();
      // console.log(value);

      var field = $(this).attr("id"); //the id in the input tells which field to update
      var desc = $(this).attr("data-desc"); //For messages
      var formData = {
        'value': value,
        'field': field,
        'desc': desc,
        'type': 'num',
        'token': "<?= Token::generate() ?>",
      };

      $.ajax({
          type: 'POST',
          url: 'parsers/admin_settings.php',
          data: formData,
          dataType: 'json',
        })

        .done(function(data) {
          messages(data);
        })
    });

    $(".ajxtxt").change(function() {
      var value = $(this).val();
      console.log(value);

      var field = $(this).attr("id"); //the id in the input tells which field to update
      var desc = $(this).attr("data-desc"); //For messages
      var formData = {
        'value': value,
        'field': field,
        'desc': desc,
        'type': 'txt',
        'token': "<?= Token::generate() ?>",
      };

      $.ajax({
          type: 'POST',
          url: 'parsers/admin_settings.php',
          data: formData,
          dataType: 'json',
        })

        .done(function(data) {
          console.log(data);
          if (data.api != "") {
            $("#APIKeyMessage").html(data.api);
          }
          messages(data);
        })
    });


    // hide cards
    $('.collapseCard').on('click', function() {
      let card = $(this).attr('data-card');
      $('#' + card + '-card-body').toggle();
      if ($('#' + card + '-card-body').is(':visible')) {
        $('#' + card + '-caret').html(`<i class="fa fa-caret-down"></i>`);
        localStorage.setItem("<?= INSTANCE ?>" + card, "true");
      } else {
        $('#' + card + '-caret').html(`<i class="fa fa-caret-right"></i>`);
        localStorage.setItem("<?= INSTANCE ?>" + card, "false");
      }

    });
    // Toggle menu
    $('#menuToggle').on('click', function() {
      $('body').toggleClass('open');
      $(".dropdown-toggle").dropdown('toggle');

    });

    $('.search-trigger').on('click', function() {
      $('.search-trigger').parent('.header-left').addClass('open');
    });

    $('.search-close').on('click', function() {
      $('.search-trigger').parent('.header-left').removeClass('open');
    });
  });
</script>

<script type="text/javascript" src="<?= $us_url_root ?>users/js/pagination/datatables.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.paginate').DataTable({
      "pageLength": 25,
      "stateSave": true,
      "aLengthMenu": [
        [25, 50, 100, -1],
        [25, 50, 100, 250, 500]
      ],
      "aaSorting": []
    });
  });
</script>
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

?>
