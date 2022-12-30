      <div class="card dash-card" data-id="<?=$widgetName?>" id="<?=$widgetName?>-card">
        <div class="card-header" id="<?=$widgetName?>-card-header">
          <span class="collapseCard" data-card="<?=$widgetName?>" id="<?=$widgetName?>-caret"><i class="fa fa-caret-down"></i></span>
          <span class="card-title-text">System Snapshot</span>
          <span class="float-end">
            <a href="<?=$us_url_root?>users/admin.php?view=updates">Check for Updates</a>
            <i class="fa-solid fa-grip ps-2 grippy"></i>
          </span>
        </div>
        <div class="card-body" id="<?=$widgetName?>-card-body">
      <p class="card-text">

        <table class="table">
          <tr style="border-top: hidden;">
            <td>UserSpice Version</td>
            <td class="text-end"><span class=""><?=$user_spice_ver?></span></td>
          </tr>

          <tr>
            <td>PHP
              <?php
              $ini = php_ini_loaded_file();
              echo $ini;
              ?>
            </td>
            <td class="text-end">        <span class=""><?php echo $phpver = phpversion();?></span>
              <?php
              if(version_compare('7.4.0',$phpver) ==  1){
                echo "<font color='red'>v7.4 or Greater Suggested</font>";
              }
              ?>
            </td>
          </tr>

          <tr>
            <?php $dataB = $db->query("select version()")->results(true);?>
            <td>Database Version</td>
            <td class="text-end"><span class=""><?=$dataB[0]["version()"];?></span></td>
          </tr>

          <tr>
            <td>OS Information</td>
            <td class="text-end"><span class=""><?=php_uname('s');?>-<?=php_uname('v');?></span></td>
          </tr>
        </table>

      </div>
    </div>
