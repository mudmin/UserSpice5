<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
        <li>Settings</li>
        <li class="active">Templates</li>
      </ol>
    </div>
  </div>
</div>
</div>
</header>

<div class="content mt-3">
  <?php
  $dirs = glob($abs_us_root . $us_url_root . 'usersc/templates/*', GLOB_ONLYDIR);
  $templates = [];
  foreach ($dirs as $d) {
    $templates[] = str_replace($abs_us_root . $us_url_root . 'usersc/templates/', "", $d);
  }

  if (!empty($_POST['template'])) {
    $choice = Input::get('template');
    $delete = Input::get('delete');
    $navstyle = Input::get('navstyle');
    //check if choice is a valid template
    if (in_array($choice, $templates)) {
      $db->update('settings', 1, ['template' => $choice]);
      if(!$db->error()) {
        usSuccess("Template assigned");
        Redirect::to('admin.php?view=templates');
      } else {
        logger($user->data()->id,"Admin Templates","Failed to assign template, Error: ".$db->errorString());
        usSuccess("Template assigned");
        Redirect::to('admin.php?view=templates');
      }
    }  else {
      usError("Invalid template");
      Redirect::to('admin.php?view=templates');
    }
  }
  ?>

  <style>
  #hr, #hr1 {
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
          <?php echo "<h3 align='center'>" . ucfirst($t) . "</h3>"; ?>
          <div class="row">
            <div class="col-md-6 text-center">
              <img src="<?= $us_url_root . 'usersc/templates/' . $t . '/thumbnail.jpg' ?>" alt="thumbnail" width="300">
                <?php
                if (file_exists($abs_us_root . $us_url_root . 'usersc/templates/' . $t . '/preview.php')) {
                  ?>
                  <p align="center"><a href="../usersc/templates/<?= $t ?>/preview.php" type="button" class="btn btn-primary">Preview</a></p>
                  <?php }else{ ?>
                  <p align="center"><a href="#" type="button" class="btn btn-default">No Preview Available</a></p>
              <?php } ?>
              <form class="" id="temlate" action="" method="post">
                <input type="hidden" name="template" value="<?= $t ?>">

                <?php if ($t != $settings->template) { ?>
                  <p align="center"><input type="submit" name="activate" value="Activate" class="btn btn-primary"></p>

                <?php } else { ?>
                  <p align="center"><input type="button" name="go" value="Active" class="btn btn-success"></p>
                <?php } ?>
              </form>

            <?php
            if (file_exists($abs_us_root . $us_url_root . 'usersc/templates/' . $t . '/info.xml')) {
              $path = $abs_us_root . $us_url_root . 'usersc/templates/' . $t . '/info.xml';
              $xml = simplexml_load_file($path);
            }
            ?>
            <?php
            if (!empty($_POST['navstyle'])) {
              $navstyle = Input::get('navstyle');
              $tpath = Input::get('tpath');

              if (!empty($navstyle)) {
                if ($navstyle == 'Default') {
                  $xml->navstyle = 'Default';
                  $xml->asXML($tpath);
                  usSuccess("Default nav activated");
                  Redirect::to('admin.php?view=templates');
                }
                if ($navstyle == 'Left Side') {
                  $xml->navstyle = 'Left Side';
                  $xml->asXML($tpath);
                  usSuccess("Left side nav activated");
                  Redirect::to('admin.php?view=templates');
                }
                if ($navstyle == 'Right Side') {
                  $xml->navstyle = 'Right Side';
                  $xml->asXML($tpath);
                  usSuccess("Right side nav activated");
                  Redirect::to('admin.php?view=templates');
                }
              }
            }
            ?>
          </div>
          <div class="col-sm-6">
            <?php if (file_exists($abs_us_root . $us_url_root . 'usersc/templates/' . $t . '/info.xml')) { ?>
              <strong>Author:</strong><a href="<?= $xml->website ?>"><?= $xml->author ?></a><br>
              <strong>Released:</strong><?= $xml->release ?><br>
              <strong>Version:</strong><?= $xml->version ?><br>
              <strong>Tested With:</strong><?= $xml->tested ?><br>
            <?php } ?>


            <?php
            if (file_exists($abs_us_root . $us_url_root . 'usersc/templates/' . $t . '/info.xml')) {
              ?>
              <strong>Library:</strong><span style="color:blue"><?= $xml->library ?></span><br>
              <strong>DB Nav:</strong><?php bin($xml->dbnav); ?><br>
              <strong>Dropdown Nav:</strong><?php bin($xml->dropnav); ?><br>
              <strong>File Nav:</strong><?php bin($xml->filenav); ?><br>

                      <?php
                      $save = $xml->navopts;
                      if($save != ''){
                        $opts = explode(',', $save);
                        $xml->navopts = $save;
                        $xml->asXML($path);
                        ?>

                        <strong>Nav Style:</strong>
                        <form class="form" id="navstyle"  action="" method="POST">
                          <div class="form-group">
                            <span style="color:blue">
                              <select class="form-control" id="navstyle" name="navstyle">
                                <?php
                                foreach($opts as $o){?>
                                  <option <?php if($o == $xml->navstyle){echo "selected";}?> value="<?=$o?>"><?=$o?></option>
                                <?php } ?>
                              </select></span>
                              <input hidden="true" name="tpath" value="<?php echo $path ?>">
                              <div class="text-center">
                                <button class="btn btn-success" type="submit">Apply</button>
                              </div>
                            </div>
                          </form>
                      <?php } ?>


            </div><div class="col-sm-6">
                <hr id="hr">
              <?php } ?>
            </div></div><hr id="hr1">

          <?php } ?>
          <br><br>

          <div class="clearfix"></div>

          <div class="ln_solid"></div>
