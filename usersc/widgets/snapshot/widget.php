      <div class="card dash-card" data-id="<?= $widgetName ?>" id="<?= $widgetName ?>-card">
        <div class="card-header" id="<?= $widgetName ?>-card-header">
          <span class="collapseCard" data-card="<?= $widgetName ?>" id="<?= $widgetName ?>-caret"><i class="fa fa-caret-down"></i></span>
          <span class="card-title-text">System Snapshot</span>
          <span class="float-end">
            <a href="<?= $us_url_root ?>users/admin.php?view=updates">Check for Updates</a>
            <i class="fa-solid fa-grip ps-2 grippy"></i>
          </span>
        </div>
        <div class="card-body" id="<?= $widgetName ?>-card-body">
          <p class="card-text">

          <table class="table">
            <tr style="border-top: hidden;">
              <td>UserSpice Version</td>
              <td class="text-end"><span class=""><?= $user_spice_ver ?></span></td>
            </tr>

            <tr>
              <td>PHP Version</td>
              <td class="text-end">
                <?php
                //modal for phpinfo
                if (in_array($user->data()->id, $master_account) && hasPerm(2) && file_exists($abs_us_root . $us_url_root . "users/views/_phpinfo.php")) { ?>
                  <a href="<?= $us_url_root ?>users/admin.php?view=phpinfo" class="me-3 btn btn-outline-primary btn-sm">PHP Info</a>
                <?php } ?>

                <?php 
                $phpver = phpversion(); 

                // Extract major.minor version (e.g., 8.1 from 8.1.25)
                $parts = explode('.', $phpver);
                $major_minor_version = $parts[0] . '.' . $parts[1];
                $class = "";

                // Query the database for the EOL date
                $eol_checkQ = $db->query("SELECT eol_date FROM us_php_eol WHERE release_version = ?", [$major_minor_version]);
                $eol_checkC = $eol_checkQ->count();

                if ($eol_checkC > 0) {
                  $eol_check = $eol_checkQ->first();
                  $eol_date = strtotime($eol_check->eol_date);
                  $today = strtotime(date("Y-m-d"));

                  if ($today > $eol_date) {
                    $class = "text-danger";
                    // If today is past the EOL date, show a warning
                    echo ' <span class="badge bg-danger mb-1">PHP Ver EOL</span>';
                  }elseif($today > strtotime("-3 months", $eol_date)) {
                    $class = "text-warning";
                    echo ' <span class="badge bg-warning mb-1">PHP Ver EOL Soon</span> ';
                  }
                }

                ?>
                <span class="<?=$class?>"><?=$phpver?></span>
              </td>
            </tr>

            <tr>
              <?php $dataB = $db->query("select version()")->results(true); ?>
              <td>Database Version</td>
              <td class="text-end"><span class=""><?= $dataB[0]["version()"]; ?></span></td>
            </tr>

            <tr>
              <td>OS Information</td>
              <td class="text-end"><span class=""><?= php_uname('s'); ?>-<?= php_uname('v'); ?></span></td>
            </tr>
          </table>
          </p>
        </div>
      </div>