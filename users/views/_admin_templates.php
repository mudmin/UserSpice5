  <?php
  $settings = $db->query("SELECT * FROM settings")->first();
  $dirs = glob($abs_us_root . $us_url_root . 'usersc/templates/*', GLOB_ONLYDIR);
  $templates = [];
  foreach ($dirs as $d) {
    $templates[] = str_replace($abs_us_root . $us_url_root . 'usersc/templates/', "", $d);
  }

  if (!empty($_POST['template'])) {
    $choice = Input::get('template');
    $navstyle = Input::get('navstyle');
    //check if choice is a valid template
    if (in_array($choice, $templates)) {
      $db->update('settings', 1, ['template' => $choice]);
      if (!$db->error()) {
        usSuccess("Template assigned");
        Redirect::to('admin.php?view=templates');
      } else {
        logger($user->data()->id, "Admin Templates", "Failed to assign template, Error: " . $db->errorString());
        usSuccess("Template assigned");
        Redirect::to('admin.php?view=templates');
      }
    } else {
      usError("Invalid template");
      Redirect::to('admin.php?view=templates');
    }
  }
  ?>

  <style>
    #hr,
    #hr1 {
      display: none;
    }

    @media (max-width:767px) {
      #hr {
        border: 1px black solid;
        display: block;
      }
    }

    @media (min-width:768px) {
      #hr1 {
        border: 1px black solid;
        display: block;
      }
    }
  </style>
  <!-- Existing Templates -->
  <div class="container">
    <div class="row">
      <div class="col-4">
        <h2>Template Manager</h2>
        <br>
      </div>
      <div class="col-8">
        <a href="admin.php?view=spice&type=template">Download Official Templates</a> or <a href="https://userspice.com/templates">Download More Templates</a>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <?php foreach ($templates as $t) { ?>

          <div class="row">
            <div class="col-md-6 text-center">
              <h3><?= ucfirst($t); ?> Theme </h3>
              <img src="<?= $us_url_root . 'usersc/templates/' . $t . '/thumbnail.jpg' ?>" alt="thumbnail" width="300" class="border">

              <div class="row mt-3">
                <div class="col-12 col-sm-6">
                  <?php
                  if (file_exists($abs_us_root . $us_url_root . 'usersc/templates/' . $t . '/preview.php')) {
                  ?>
                    <a href="../usersc/templates/<?= $t ?>/preview.php" type="button" class="btn btn-primary float-end" target="_blank">Preview</a>
                  <?php } else { ?>
                    <p><a href="#" type="button" class="btn btn-default float-end">No Preview Available</a></p>
                  <?php } ?>
                </div>
                <div class="col-12 col-sm-6">
                  <form class="" id="temlate" action="" method="post">
                    <input type="hidden" name="template" value="<?= $t ?>">

                    <?php if ($t != $settings->template) { ?>
                      <input type="submit" name="activate" value="Activate" class="btn btn-primary float-start">

                    <?php } else { ?>
                      <input type="button" name="go" value="Active" class="btn btn-success float-start">
                    <?php } ?>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <?php
              if (file_exists($abs_us_root . $us_url_root . 'usersc/templates/' . $t . '/info.xml')) {
                $path = $abs_us_root . $us_url_root . 'usersc/templates/' . $t . '/info.xml';
                $xml = simplexml_load_file($path);
              }
              ?>
              <?php if (file_exists($abs_us_root . $us_url_root . 'usersc/templates/' . $t . '/info.xml')) { ?>
                <table class="table">
                  <tbody>
                    <tr>
                      <td><b>Author</b></td>
                      <td><?= $xml->author ?></td>
                    </tr>

                    <tr>
                      <td><b>Template Version</b></td>
                      <td><?= $xml->version ?></td>
                    </tr>

                    <tr>
                      <td><b>Released</b></td>
                      <td><?= $xml->release ?></td>
                    </tr>
                    <!-- <tr>
                    <td><b>Tested Through Version</b></td>
                    <td><?= $xml->tested ?></td>
                  </tr> -->
                    <tr>
                      <td><b>Library</b></td>
                      <td><?= $xml->library ?></td>
                    </tr>

                    <tr>
                      <td><b>UltraMenu</b></td>
                      <td>
                        <?php if (isset($xml->ultramenu) && $xml->ultramenu == 1) {
                          echo bin(1);
                        } else {
                          echo bin(0);
                        } ?>
                      </td>
                    </tr>

                    <tr>
                      <td><b>Classic Menu (v5.4 and before)</b></td>
                      <td><?php bin($xml->dbnav); ?></td>
                    </tr>

                    <tr>
                      <td><b>File-based Nav Available</b></td>
                      <td><?php bin($xml->filenav); ?></td>
                    </tr>

                    <tr>
                      <td><b>Enhanced Accessibility</b></td>
                      <td>
                        <?php if (isset($xml->accessible) && $xml->accessible == 1) {
                          echo bin(1);
                        } else {
                          echo bin(0);
                        } ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
            </div>

          <?php } ?>
          <hr class="mt-3 mb-3">
          </div>
        <?php } ?>

        <div class="clearfix"></div>

        <div class="ln_solid"></div>
