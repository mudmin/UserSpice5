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
