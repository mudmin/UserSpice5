<?php if (hasPerm(2)) { ?>
  <div class="card dash-card" data-id="<?= $widgetName ?>" id="<?= $widgetName ?>-card">
    <div class="card-header" id="<?= $widgetName ?>-card-header">
      <span class="collapseCard" data-card="<?= $widgetName ?>" id="<?= $widgetName ?>-caret"><i class="fa fa-caret-down"></i></span>
      <span class="card-title-text">Plugins</span>
      <span class="float-end"><a href="?view=plugins">Manage Plugins</a>
        <i class="fa-solid fa-grip ps-2 grippy"></i>
      </span>
    </div>
    <div class="card-body" id="<?= $widgetName ?>-card-body">
      <p class="card-text">
      <div class="row">
        <?php
        // Build the full plugin list (active + inactive) from the plugins directory.
        // Integrated plugins are part of core and are not shown as configurable tiles.
        $integrated = ["userspice_core", "usertags"];
        $pluginDirs = glob($abs_us_root . $us_url_root . 'usersc/plugins/*', GLOB_ONLYDIR);
        $pluginList = [];
        foreach ($pluginDirs as $pd) {
          $p = str_replace($abs_us_root . $us_url_root . 'usersc/plugins/', '', $pd);
          if (in_array($p, $integrated)) {
            continue;
          }
          $isActive = pluginActive($p, true);
          $buttonTitle = 'Configure Plugin';
          $pluginName = $p;
          if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $p . '/info.xml')) {
            $xml = simplexml_load_file($abs_us_root . $us_url_root . 'usersc/plugins/' . $p . '/info.xml');
            $buttonTitle = $xml->button != '' ? (string)$xml->button : 'Configure Plugin';
            $pluginName = $xml->name != '' ? (string)$xml->name : $p;
          }
          if (file_exists($abs_us_root . $us_url_root . "usersc/plugins/$p/logo.png")) {
            $img_src = $us_url_root . "usersc/plugins/$p/logo.png";
          } else {
            $img_src = $us_url_root . 'users/images/plugin.png';
          }
          $pluginList[] = [
            'dir'    => $p,
            'active' => $isActive,
            'title'  => $buttonTitle,
            'name'   => $pluginName,
            'img'    => $img_src,
          ];
        }
        // Active plugins first, inactive at the end; alphabetical within each group.
        usort($pluginList, function ($a, $b) {
          if ($a['active'] !== $b['active']) {
            return $a['active'] ? -1 : 1;
          }
          return strcasecmp($a['title'], $b['title']);
        });

        foreach ($pluginList as $pl) {
          if ($pl['active']) {
            $href = '?view=plugins_config&plugin=' . $pl['dir'];
            $imgStyle = '';
          } else {
            // Inactive plugins can't be configured - jump to the plugin manager,
            // anchored to that plugin's row (same #ctrl- anchor activation uses).
            $anchor = str_replace('%2F', '/', rawurlencode($pl['name']));
            $href = '?view=plugins#ctrl-' . $anchor;
            $imgStyle = 'filter:grayscale(100%);opacity:0.25;';
          }
        ?>
            <div class="col-3 col-sm-2 mb-4 text-center">
              <a href="<?= $href ?>" data-bs-toggle="tooltip" title="<?= htmlspecialchars($pl['title']) ?><?= $pl['active'] ? '' : ' (inactive)' ?>">
                <div class="icon-link">
                  <img src="<?= $pl['img'] ?>" alt="<?= htmlspecialchars($pl['title']) ?>" height="50em" style="<?= $imgStyle ?>">
                  <div class="dashboard-icon-label"<?= $pl['active'] ? '' : ' style="color:#9a9a9a;"' ?>>
                    <?= htmlspecialchars($pl['title']) ?>
                  </div>
                </div>
              </a>
            </div>
        <?php
        }
        if (file_exists($abs_us_root . $us_url_root . 'usersc/widgets/' . $widgetName . '/custom.php')) {
          include $abs_us_root . $us_url_root . 'usersc/widgets/' . $widgetName . '/custom.php';
        }
        ?>
      </div>
      </p>
    </div>
  </div>
<?php } ?>
