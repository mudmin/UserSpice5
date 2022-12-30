<?php if(hasPerm(2)){ ?>
      <div class="card dash-card" data-id="<?=$widgetName?>" id="<?=$widgetName?>-card">
        <div class="card-header" id="<?=$widgetName?>-card-header">
          <span class="collapseCard" data-card="<?=$widgetName?>" id="<?=$widgetName?>-caret"><i class="fa fa-caret-down"></i></span>
             <span class="card-title-text">Plugins</span>
          <span class="float-end"><a href="?view=plugins">Manage Plugins</a>
            <i class="fa-solid fa-grip ps-2 grippy"></i>
          </span>
        </div>
        <div class="card-body" id="<?=$widgetName?>-card-body">
      <p class="card-text">
        <div class="row">

          <?php
          foreach($plugins as $p){

            if(pluginActive($p,true)){
              $xml = simplexml_load_file($abs_us_root . $us_url_root . 'usersc/plugins/' . $p . '/info.xml');
              $buttonTitle = $xml->button != '' ? $xml->button : "Configure Plugin";
              if(file_exists($abs_us_root . $us_url_root . "usersc/plugins/$p/logo.png")){
                $img_src = $abs_us_root . $us_url_root . "usersc/plugins/$p/logo.png";
              }else{
                $img_src = $us_url_root . 'users/images/plugin.png';
              }
                  ?>
                <div class="col-3 col-sm-2 mb-4 text-center">
                  <a href="?view=plugins_config&plugin=<?=$p?>" data-bs-toggle="tooltip" title="<?=$buttonTitle?>">
                  <img src="<?=$us_url_root?>usersc/plugins/<?=$p?>/logo.png" alt="" height="50em">
                </a>
                <br>
                <div class="dashboard-icon-label">
                  <?=$buttonTitle?>
                </div>
                </div>

                <?php
              }
            }

          ?>
        </div>
      </p>
    </div>
  </div>
<?php } ?>
