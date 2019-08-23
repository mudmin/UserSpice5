<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
          <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
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
$dirs = glob($abs_us_root.$us_url_root.'usersc/plugins/*' , GLOB_ONLYDIR);
$plugins = [];
if(!is_writeable($abs_us_root.$us_url_root.'usersc/plugins/plugins.ini.php')){
  err("Warning. Your plugins.ini.php file is not writeable. This will cause problems installing plugins.");
}
foreach($dirs as $d){
  $plugins[] = str_replace($abs_us_root.$us_url_root.'usersc/plugins/', "", $d);
  $thisPlugin = end($plugins);
  if(!array_key_exists($thisPlugin,$usplugins)){
    $usplugins[$thisPlugin] = 2;
    write_php_ini($usplugins, $abs_us_root.$us_url_root.'usersc/plugins/plugins.ini.php');
    include $abs_us_root.$us_url_root.'usersc/plugins/'.$thisPlugin.'/install.php';
  }
}

$pluginsC = sizeof($plugins);

if(!empty($_POST)){
  $disable = Input::get('disable');
  $activate = Input::get('activate');
  $uninstall = Input::get('uninstall');
  $install = Input::get('install');
  $plugin = Input::get('plugin');
  $jump = Input::get('jump');


  if($activate != ''){
    $usplugins[$plugin] = 1;
    write_php_ini($usplugins, $abs_us_root.$us_url_root.'usersc/plugins/plugins.ini.php');
    if(file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$plugin.'/activate.php')){
      include $abs_us_root.$us_url_root.'usersc/plugins/'.$plugin.'/activate.php';
    }
    Redirect::to('admin.php?view=plugins&err='.$plugin.' activated'.$jump);
  }

  if($disable != ''){
    $usplugins[$plugin] = 0;
    write_php_ini($usplugins, $abs_us_root.$us_url_root.'usersc/plugins/plugins.ini.php');
    $db->update('us_plugins',['plugin','=',$plugin],['status'=>'disabled']);
    Redirect::to('admin.php?view=plugins&err='.$plugin.' disabled'.$jump);
  }

  if($uninstall != ''){
    $usplugins[$plugin] = 2;
    $db->update('us_plugins',['plugin','=',$plugin],['status'=>'uninstalled']);
    write_php_ini($usplugins, $abs_us_root.$us_url_root.'usersc/plugins/plugins.ini.php');
    if(file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$plugin.'/uninstall.php')){
      echo "file exists";
      include $abs_us_root.$us_url_root.'usersc/plugins/'.$plugin.'/uninstall.php';
    }
    Redirect::to('admin.php?view=plugins&err='.$plugin.' uninstalled. You may delete the plugin files if you wish.'.$jump);
  }

  if($install != ''){
    $usplugins[$plugin] = 0;
    write_php_ini($usplugins, $abs_us_root.$us_url_root.'usersc/plugins/plugins.ini.php');
    if(file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$plugin.'/install.php')){
      include $abs_us_root.$us_url_root.'usersc/plugins/'.$plugin.'/install.php';
    }
    Redirect::to('admin.php?view=plugins&err='.$plugin.' installed but not enabled.'.$jump);
  }
}
$token = Token::generate();
?>
<div class="content mt-3">
  <div class="row">
    <div class="col-6">
      <h2>Plugin Manager</h2>
      <strong>Please Note:</strong>There are often important installation and security notes in the big table at the bottom of this page.<br>
    </div>
    <div class="col-6">
      <a href="admin.php?view=spice&type=plugin">Download Official Plugins</a> or <a href="https://userspice.com/plugins" class="button">Download More Plugins</a>
    </div>
  </div>
  <?php resultBlock($errors,$successes);?>
<?php if($pluginsC > 0){ ?>
  <table id="plugins" class='table table-striped' cellspacing="0" width="100%">

    <thead>
      <tr>
        <th>Name (Click for Details)</th>
        <th style = "text-align:center">Logo</th>
        <th style = "text-align:center">Status</th>
        <th style = "text-align:center">Action</th>
        <th style = "text-align:center">Run</th>
      </tr>
    </thead>

    <tbody>
      <?php
        foreach($plugins as $t){
          $xml=simplexml_load_file($abs_us_root.$us_url_root.'usersc/plugins/'.$t.'/info.xml');
           ?>
        <tr>
          <td><div id="ctrl-<?=$xml->name?>"></div><strong><a href="#<?=$xml->name?>"><?=$xml->name?></a></strong></td>
          <td align="center">
            <?php if(file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$t.'/logo.png')){ ?>
              <img src="<?=$us_url_root.'usersc/plugins/'.$t.'/logo.png'?>" alt="thumbnail" width="50">
            <?php }else{ ?>
              <img src="<?=$us_url_root.'users/images/plugin.png'?>" alt="thumbnail"  width="40">
            <?php }
            ?>
          </td>
          <td align="center">
              <?php pluginStatus($usplugins[$t]); ?>
          </td>
          <td align="center">
            <form class="" action="admin.php?view=plugins" method="post">
              <input type="hidden" name="jump" value="#ctrl-<?=$xml->name?>">
              <input type="hidden" name="plugin" value="<?=$t?>">
              <?php if($usplugins[$t] == 1){ ?>
                <input type="submit" name="disable" value="Disable" class="btn btn-danger">
              <?php } ?>
              <?php if($usplugins[$t] == 0){ ?>
                <input type="submit" name="activate" value="Activate" class="btn btn-success">
                <input type="submit" name="uninstall" value="Uninstall" class="btn btn-default">
              <?php } ?>
              <?php if($usplugins[$t] != 0 && $usplugins[$t] != 1){ ?>
                <input type="submit" name="install" value="Install" class="btn btn-primary">
                <!-- <input type="submit" name="uninstall" value="Uninstall" class="btn btn-default"> -->
              <?php } ?>

            </form>

          </td>
          <td align="center">
            <?php
              if(file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$t.'/configure.php') && ($usplugins[$t] == 1)){?>
              <a class="btn btn-primary" href="<?=$us_url_root.'users/admin.php?view=plugins_config&plugin='.$t?>" role="button">
                <?php
                if($xml->button != ''){
                  echo $xml->button;
                }else{
                  echo "Configure Plugin";
                } ?>

                </a>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
  <table id="plugins" class='table table-striped' cellspacing="0" width="100%">

    <thead>
      <tr>
        <th class="column-title">Name</th>
        <th class="column-title">Logo</th>
        <th width="40%" class="column-title text-center">Description</th>
        <th class="column-title">About</th>
      </tr>
    </thead>

    <tbody>
      <?php
        foreach($plugins as $t){
          $xml=simplexml_load_file($abs_us_root.$us_url_root.'usersc/plugins/'.$t.'/info.xml');
            ?>
        <tr>
          <td><div id="<?=$xml->name?>">  </div><?php echo "<h5>".$xml->name."</h5>"; ?>
            <p><?php pluginStatus($usplugins[$t]); ?><br>
          <a href="#ctrl-<?=$xml->name?>"><font color="blue">Manage</font></a></p>
          </td>
          <td>
            <?php if(file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$t.'/logo.png')){ ?>
              <img src="<?=$us_url_root.'usersc/plugins/'.$t.'/logo.png'?>" alt="thumbnail" width="150">
            <?php }else{ ?>
              <img src="<?=$us_url_root.'users/images/plugin.png'?>" alt="thumbnail"  width="125">
            <?php }
            ?>
          </td>
          <td>
            <?php
            if(file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$t.'/info.xml')){
              $xml=simplexml_load_file($abs_us_root.$us_url_root.'usersc/plugins/'.$t.'/info.xml');
              echo $xml->description;
            }
            ?>
          </td>
          <td>
            <?php
            if(file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$t.'/info.xml')){ ?>
              <strong>Author:</strong><a href="<?=$xml->website?>"><?=$xml->author?></a><br>
              <strong>Released:</strong><?=$xml->release?><br>
              <strong>Version:</strong><?=$xml->version?><br>
              <strong>Tested With:</strong><?=$xml->tested?><br>
            <?php } ?>
          </td>
        </tr>
      <?php }
    }else{ //pluginsC < 1
      echo "<br><strong>No plugins are currently installed.</strong>";
    }?>
    </tbody>
  </table>

</div>
<?php function pluginStatus($status){
  if($status == 0) { ?>
    <font color="blue">Installed but Disabled</font>
    <?php
  }elseif($status == 1) { ?>
    <font color="green">Active</font>
    <?php
  }else{ ?>
    <font color="red">Not Installed</font>
    <?php
  }
}
?>
