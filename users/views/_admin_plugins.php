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
if(!in_array($user->data()->id,$master_account)){
  Redirect::to('admin.php?err=Plugin administration is for master accounts only.');
}
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
  $token = $_POST['csrf'];
  if(!Token::check($token)){
    include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
  }


  $plugin = Input::get('plugin');

  if(!empty($_POST['lock'])){
    $action = Input::get('action');
    $file = $abs_us_root.$us_url_root."usersc/plugins/".$plugin."/.noupdate";
    if($action == "unlockme"){
      unlink($file);
      Redirect::to('admin.php?view=plugins&err=' . $plugin . ' unlocked');
    }

    if($action == "lockme"){
      $write = fopen($file,"w");
      fwrite($write,"");
      fclose($write);
      Redirect::to('admin.php?view=plugins&err=' . $plugin . ' has been locked');
    }
  }
  $activate = Input::get('activate');
  $delete = Input::get('delete');
  $deactivate = Input::get('deactivate');
  $install = Input::get('install');
  $purge = Input::get('purge');

  $jump = Input::get('jump');


  if ($delete != '' || $purge != '') {
    if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/uninstall.php')) {
      include $abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/uninstall.php';
    }
    $usplugins[$plugin] = 2;
    $db->update('us_plugins', ['plugin', '=', $plugin], ['status' => 'uninstalled']);
    write_php_ini($usplugins, $abs_us_root . $us_url_root . 'usersc/plugins/plugins.ini.php');
    if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/uninstall.php')) {
      include $abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/uninstall.php';
    }
    // TODO: Is this still Needed? Code can be added to uninstall.php?
    // ? Only run if user selected to purge files
    if (Input::get('purgePlugin') || $purge != '') {
      if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/delete.php')) {
        include $abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/delete.php';
      }
      // Verify that user has chosen to purge the plugin
      if(is_dir($abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin)) {
        $files = new RecursiveIteratorIterator(
          new RecursiveDirectoryIterator($abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin, RecursiveDirectoryIterator::SKIP_DOTS),
          RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
          $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
          $todo($fileinfo->getRealPath());
        }

        rmdir($abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin);
      }
    }
    Redirect::to('admin.php?view=plugins&err=' . $plugin . ' deleted');
  }

  if ($deactivate != '') {
    $usplugins[$plugin] = 0;
    $db->update('us_plugins', ['plugin', '=', $plugin], ['status' => 'uninstalled']);
    write_php_ini($usplugins, $abs_us_root . $us_url_root . 'usersc/plugins/plugins.ini.php');
    if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/uninstall.php')) {
      include $abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/uninstall.php';
    }
    Redirect::to('admin.php?view=plugins&err=' . $plugin . ' deactivated. You may click the trash can icon to delete the plugin' . $jump);
  }


  if ($activate != '') {
    $usplugins[$plugin] = 1;
    $db->update('us_plugins', ['plugin', '=', $plugin], ['status' => 'active']);
    write_php_ini($usplugins, $abs_us_root . $us_url_root . 'usersc/plugins/plugins.ini.php');

    if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/activate.php')) {
      include $abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/activate.php';
    }
    if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/migrate.php')) {
      include $abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/migrate.php';
    }
    $pluginId = $db->query("SELECT id FROM us_plugins WHERE plugin = ?",[$plugin])->first();
    $db->update('us_plugins',$pluginId->id,['last_check'=>date("Y-m-d H:i:s")]);


    Redirect::to('admin.php?view=plugins&err=' . $plugin . ' Activated.' . $jump);
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
<style media="screen">
    .hov:hover{
    opacity: 0.5;
    transition: .4s ease;
    }
</style>
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
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <?php resultBlock($errors, $successes); ?>
            </div>
          </div>
          <?php if ($pluginsC > 0) { ?>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col" width="25%">Plugin (Click to Configure)</th>
                  <th scope="col" width="50%">Description</th>
                  <th scope="col" width="10%" class="text-center">Status</th>
                  <th scope="col" width="15%" class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($plugins as $t) {
                    if(!file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $t . '/info.xml')) { ?>
                      <tr>
                        <td colspan="4">
                          Loading <?=$t?> has failed, XML file does not exist
                        </td>
                      </tr>
                    <?php
                      continue;
                    }
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
                          <?php if(pluginActive($t,true)){ ?>
                          <a href="<?= $us_url_root . 'users/admin.php?view=plugins_config&plugin=' . $t ?>">
                            <img src="<?= $img_src ?>" class="hov" alt="thumbnail" width="100">
                          </a>
                        <?php }else{ ?>
                          <img src="<?= $img_src ?>" alt="thumbnail" width="100">
                        <?php } ?>
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
                      <form class="" action="" method="post">
                        <input type="hidden" name="csrf" value="<?=Token::generate();?>">
                        <input type="hidden" name="lock" value="lock">
                        <input type="hidden" name="plugin" value="<?= $t ?>">
                        <?php if(file_exists($abs_us_root.$us_url_root."usersc/plugins/".$t."/.noupdate")){ ?>
                        <button type="submit" name="action" value="unlockme" class="btn" title="Unlock this plugin to allow Spice Shaker to update it.">
                          <i class="fa fa-lock" aria-hidden="true"></i>
                        </button>
                      <?php } else { ?>
                        <button type="submit" name="action" value="lockme" class="btn" title="Lock this plugin to prevent plugin from being updated">
                          <i class="fa fa-unlock" aria-hidden="true"></i>
                        </button>
                      <?php } ?>
                      </form>
                    </td>
                    <td>
                      <div class="d-flex justify-content-center">
                        <form class="" action="" method="post">
                          <input type="hidden" name="csrf" value="<?=Token::generate();?>">
                          <input type="hidden" name="jump" value="#ctrl-<?= $xml->name ?>">
                          <input type="hidden" name="plugin" value="<?= $t ?>">
                          <input type="hidden" name="hasUninstallOptions" value="<?php echo file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $t . '/dialog.uninstall.html') ? 'true' : 'false'; ?>" />
                          <?php if(!file_exists($abs_us_root.$us_url_root."usersc/plugins/".$t."/.noupdate")) { ?>
                            <?php if ($usplugins[$t] == 1) {  // plugin installed and active ?>
                              <button type="submit" name="deactivate" value="Deactivate" class="btn btn-outline-dark" title="Deactivate">
                                <i class="fa fa-ban" aria-hidden="true"></i>
                              </button>
                              <a class="btn btn-outline-primary" title="Configure" href="<?= $us_url_root . 'users/admin.php?view=plugins_config&plugin=' . $t ?>" role="button">
                                <i class="fa fa-cogs" aria-hidden="true"></i>
                              </a>
                            <?php }else if ($usplugins[$t] == 0) { //plugin installed and inactive ?>
                              <button type="submit" name="activate" value="Activate" class="btn btn-outline-success" title="Activate">
                                <i class="fa fa-toggle-on" aria-hidden="true"></i>
                              </button>
                              <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#uninstallPlugin">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                              </button>
                            <?php } ?>
                            <?php if ($usplugins[$t] != 0 && $usplugins[$t] != 1) { // plugin not installed ?>
                              <button type="submit" name="install" value="Install" class="btn btn-outline-primary" title="Install">
                                <i class="fa fa-download" aria-hidden="true"></i>
                              </button>
                              <button type="submit" name="purge" value="Purge" class="btn btn-outline-danger" title="Purge"
                                onclick="return confirm('If you continue, the plugin files will be deleted.  The plugin may also choose to delete/clean up the data it created in your database.  To see which actions would be performed, take a look at the delete.php file in the plugin folder (if it exists).  This cannot be undone.');">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                              </button>
                              <!-- <input type="submit" name="uninstall" value="Uninstall" class="btn btn-default"> -->
                            <?php } ?>
                          <?php }else{ ?>
                            <?php if ($usplugins[$t] == 1) {  // plugin installed and active ?>
                              <a class="btn btn-outline-primary" title="Configure" href="<?= $us_url_root . 'users/admin.php?view=plugins_config&plugin=' . $t ?>" role="button">
                                <i class="fa fa-cogs" aria-hidden="true"></i>
                              </a>
                            <?php }else if ($usplugins[$t] == 0) { //plugin installed and inactive ?>
                              <span class="badge badge-info">Installed and Inactive</span>
                            <?php } ?>
                            <?php if ($usplugins[$t] != 0 && $usplugins[$t] != 1) { // plugin not installed ?>
                              <span class="badge badge-warning">Not Installed</span>
                            <?php } ?>
                          <?php } ?>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <div class="modal fade" id="uninstallPlugin" tabindex="-1" aria-labelledby="uninstallPluginLabel" aria-hidden="true">
              <div class="modal-dialog">
                <form class="modal-content" action="" method="post">
                  <div class="modal-header">
                    <h5 class="modal-title" id="uninstallPluginLabel">Uninstall: </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <!-- plugin details -->
                    <input type="hidden" name="csrf">
                    <input type="hidden" name="jump">
                    <input type="hidden" name="plugin">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="true" id="purgePlugin" name="purgePlugin">
                      <label class="form-check-label" for="purgePlugin">
                        Purge Plugin Files?
                      </label>
                    </div>
                    <div class="plugin-options"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="delete" value="Delete" class="btn btn-danger" title="Delete">Uninstall Plugin</button>
                  </div>
                </form>
              </div>
            </div>
            <script type="text/javascript">
              $('#uninstallPlugin').on('show.bs.modal', function (event) {
                // do something...
                var $pluginForm = $(event.relatedTarget).closest('form');
                var $modelForm = $(event.currentTarget).find('form');

                $modelForm.closest('.modal').find('#uninstallPluginLabel').text('Uninstall: ' + $pluginForm.closest('tr').find('h4').first().text());

                // Set Plugin Values
                $modelForm.find('[name="csrf"]').val($pluginForm.find('[name="csrf"]').val());
                $modelForm.find('[name="jump"]').val($pluginForm.find('jump').val());
                $modelForm.find('[name="plugin"]').val($pluginForm.find('[name="plugin"]').val());

                // Clear Plugin options
                $modelForm.find('.modal-body .plugin-options').html("");

                // Check if Plugin has Uninstall Options, If so, Append them.
                if ($pluginForm.find('[name="hasUninstallOptions"]').val() == 'true') {
                  $.get('<?php echo $us_url_root; ?>usersc/plugins/' + $pluginForm.find('[name="plugin"]').val() + '/dialog.uninstall.html', function( response ) {
                    $modelForm.find('.modal-body .plugin-options').html(response);
                  });
                }
              });
            </script>
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
<?php function pluginStatus($status){
  if ($status == 1) { ?>
    <span class="text-success">Active</span>

  <?php
    } else { ?>
    <span class="text-danger">Inactive</span>
<?php
  }
}
?>
