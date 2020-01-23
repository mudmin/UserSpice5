<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?= $us_url_root ?>users/admin.php">Dashboard</a></li>
        <li>Manage</li>
        <li class="active">Plugins</li>
      </ol>
    </div>
  </div>
</div>
</div>
</header>
<?php
//Errors Successes
$errors = [];
$successes = [];
$dirs = glob($abs_us_root . $us_url_root . 'usersc/plugins/*', GLOB_ONLYDIR);
$plugins = [];
if (!is_writeable($abs_us_root . $us_url_root . 'usersc/plugins/plugins.ini.php')) {
  err("Warning. Your plugins.ini.php file is not writeable. This will cause problems installing plugins.");
}
foreach ($dirs as $d) {
  $plugins[] = str_replace($abs_us_root . $us_url_root . 'usersc/plugins/', "", $d);
  $thisPlugin = end($plugins);
  if (!array_key_exists($thisPlugin, $usplugins)) {
    $usplugins[$thisPlugin] = 2;
    write_php_ini($usplugins, $abs_us_root . $us_url_root . 'usersc/plugins/plugins.ini.php');
  }
}

$pluginsC = sizeof($plugins);

if (!empty($_POST)) {
  $disable = Input::get('disable');
  $activate = Input::get('activate');
  $uninstall = Input::get('uninstall');
  $install = Input::get('install');
  $plugin = Input::get('plugin');
  $jump = Input::get('jump');


  if ($activate != '') {
    $usplugins[$plugin] = 1;
    write_php_ini($usplugins, $abs_us_root . $us_url_root . 'usersc/plugins/plugins.ini.php');
    if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/activate.php')) {
      include $abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/activate.php';
    }
    Redirect::to('admin.php?view=plugins&err=' . $plugin . ' activated' . $jump);
  }

  if ($disable != '') {
    $usplugins[$plugin] = 0;
    write_php_ini($usplugins, $abs_us_root . $us_url_root . 'usersc/plugins/plugins.ini.php');
    $db->update('us_plugins', ['plugin', '=', $plugin], ['status' => 'disabled']);
    Redirect::to('admin.php?view=plugins&err=' . $plugin . ' disabled' . $jump);
  }

  if ($uninstall != '') {
    $usplugins[$plugin] = 2;
    $db->update('us_plugins', ['plugin', '=', $plugin], ['status' => 'uninstalled']);
    write_php_ini($usplugins, $abs_us_root . $us_url_root . 'usersc/plugins/plugins.ini.php');
    if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/uninstall.php')) {
      echo "file exists";
      include $abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/uninstall.php';
    }
    Redirect::to('admin.php?view=plugins&err=' . $plugin . ' uninstalled. You may delete the plugin files if you wish.' . $jump);
  }

  if ($install != '') {
    $usplugins[$plugin] = 0;
    write_php_ini($usplugins, $abs_us_root . $us_url_root . 'usersc/plugins/plugins.ini.php');
    if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/install.php')) {
      include $abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/install.php';
    }
    Redirect::to('admin.php?view=plugins&err=' . $plugin . ' installed but not enabled.' . $jump);
  }
}
$token = Token::generate();
?>
<div class="content mt-3">
  <div class="row">
    <div class="col-12 mb-2">
      <h2>Plugin Manager</h2>
      <div class="p-2 col-md-8 col-sm-12">
      </div>
      <div class="d-flex align-content-end float-right">
        <div class="mr-2">
          <a class="btn btn-outline-dark pull-right" href="admin.php?view=spice&type=plugin">Download Official Plugins</a>
        </div>
        <div>
          <a class="btn btn-outline-dark pull-right" href="https://userspice.com/plugins" class="button">Download More Plugins</a>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <?php resultBlock($errors, $successes); ?>
            </div>
          </div>
          <?php if ($pluginsC > 0) { ?>
            <table class="table table-striped table-responsive">
              <thead>
                <tr>
                  <th scope="col" width="25%">Plugin</th>
                  <th scope="col" width="50%">Description</th>
                  <th scope="col" width="15%" class="text-center">Status</th>
                  <th scope="col" width="15%" class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($plugins as $t) {
                    $xml = simplexml_load_file($abs_us_root . $us_url_root . 'usersc/plugins/' . $t . '/info.xml');
                    if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $t . '/logo.png')) {
                      $img_src = $us_url_root . 'usersc/plugins/' . $t . '/logo.png';
                    } else {
                      $img_src = $us_url_root . 'users/images/plugin.png';
                    }
                    $buttonTitle = $xml->button != '' ? $xml->button : "Configure Plugin";
                    ?>
                  <tr id="ctrl-<?= $xml->name ?>">
                    <td>
                      <div class="d-flex flex-row">
                        <div class="pr-3">
                          <img src="<?= $img_src ?>" alt="thumbnail" width="100">
                        </div>
                        <div class="d-flex flex-column">
                          <h4 class="mb-1"><?= $xml->name ?></h4>
                          <small class="ml-2"><strong>Author: </strong><a class="text-dark" href="<?= $xml->website ?>"><?= $xml->author ?></a></small>
                          <small class="ml-2"><strong>Released: </strong><?= $xml->release ?></small>
                          <small class="ml-2"><strong>Version: </strong><?= $xml->version ?></small>
                          <small class="ml-2"><strong>Tested With: </strong><?= $xml->tested ?></small>
                        </div>

                      </div>
                    </td>
                    <td>
                      <p class="text-dark"><?= $xml->description ?></p>
                    </td>
                    <td class="text-center">
                      <h4><?php pluginStatus($usplugins[$t]); ?></h4>
                    </td>
                    <td>
                      <div class="d-flex justify-content-center">
                        <form class="" action="admin.php?view=plugins" method="post">
                          <input type="hidden" name="jump" value="#ctrl-<?= $xml->name ?>">
                          <input type="hidden" name="plugin" value="<?= $t ?>">
                          <?php if ($usplugins[$t] == 1) { ?>
                            <button type="submit" name="disable" value="Disable" class="btn btn-outline-dark showTooltip" title="Disable">
                              <i class="fa fa-ban" aria-hidden="true"></i>
                            </button>
                            <a class="btn btn-outline-primary showTooltip" title="Configure" href="<?= $us_url_root . 'users/admin.php?view=plugins_config&plugin=' . $t ?>" role="button">
                              <i class="fa fa-cogs" aria-hidden="true"></i>
                            </a>
                          <?php } ?>
                          <?php if ($usplugins[$t] == 0) { ?>
                            <button type="submit" name="activate" value="Activate" class="btn btn-outline-success showTooltip" title="Activate">
                              <i class="fa fa-toggle-on" aria-hidden="true"></i>
                            </button>
                            <button type="submit" name="uninstall" value="Uninstall" class="btn btn-outline-danger showTooltip" title="Uninstall">
                              <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                          <?php } ?>
                          <?php if ($usplugins[$t] != 0 && $usplugins[$t] != 1) { ?>
                            <button type="submit" name="install" value="Install" class="btn btn-outline-primary showTooltip" title="Install">
                              <i class="fa fa-download" aria-hidden="true"></i>
                            </button>
                            <!-- <input type="submit" name="uninstall" value="Uninstall" class="btn btn-default"> -->
                          <?php } ?>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } else { //pluginsC < 1
            echo "<br><strong>No plugins are currently installed.</strong>";
          } ?>
        </div>
      </div>
    </div>
  </div>

</div>
<script>
  $(document).ready(function() {
    $('.showTooltip').tooltip()
  })
</script>
<?php function pluginStatus($status)
{
  if ($status == 0) { ?>
    <span class="text-primary">Installed but Disabled</span>
  <?php
    } elseif ($status == 1) { ?>
    <span class="text-success">Active</span>
  <?php
    } else { ?>
    <span class="text-danger">Not Installed</span>
<?php
  }
}
?>
