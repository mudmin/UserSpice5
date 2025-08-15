<?php
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

  td {
    width: 50%;
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
            <img src="<?= $us_url_root . 'usersc/templates/' . $t . '/thumbnail.jpg' ?>" alt="thumbnail" width="70%" class="border">

            <div class="row mt-3">
              <div class="col-12 text-center">
                <div class="d-flex justify-content-center gap-2">
                  <?php if (file_exists($abs_us_root . $us_url_root . 'usersc/templates/' . $t . '/customize.php')) { ?>
                    <a href="../usersc/templates/<?= $t ?>/customize.php" class="btn btn-outline-primary" target="_blank">Customize</a>
                  <?php } ?>

                  <?php if (file_exists($abs_us_root . $us_url_root . 'usersc/templates/' . $t . '/preview.php')) { ?>
                    <a href="../usersc/templates/<?= $t ?>/preview.php" class="btn btn-primary" target="_blank">Preview</a>
                  <?php } else { ?>
                    <a href="#" class="btn btn-secondary">No Preview Available</a>
                  <?php } ?>

                  <form id="template_<?= $t ?>" action="" method="post" class="d-inline">
                    <input type="hidden" name="template" value="<?= $t ?>">
                    <?php if ($t != $core_template) { ?>
                      <input type="submit" name="activate" value="Activate" class="btn btn-primary">
                    <?php } else { ?>
                      <button type="button" class="btn btn-success">Active</button>
                    <?php } ?>
                  </form>
                </div>
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
                    <td><b>Customizer</b></td>
                    <td>
                      <?php if (isset($xml->customizer) && $xml->customizer == 1) {
                        echo bin(1);
                      } else {
                        echo bin(0);
                      } ?>
                    </td>
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
                    <td><b>Meets Accessibility Guidelines</b></td>
                    <td>
                      <?php if (!isset($xml->accessibility)) {
                        echo "None";
                      } else {
                        echo $xml->accessibility;
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