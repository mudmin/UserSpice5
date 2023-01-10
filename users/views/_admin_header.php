<!-- Header-->
<header id="header" class="header">

  <?php
  require_once $abs_us_root . $us_url_root . 'users/includes/template/header3_must_include.php';
  if (isset($_GET['err'])) {
    $err = Input::get('err');
    err($err);
  }

  if (isset($_GET['msg'])) {
    $msg = Input::get('msg');
    bold($msg);
  }

  if (!isset($us_loader_loaded)) {
    echo '<h4><b>IMPORTANT:</b> You must add the line</h4><h4><span style="color:blue">require_once $abs_us_root.$us_url_root."users/includes/loader.php";</span></h4><h4>to the bottom of your users/init.php file.</h4>';
  }
  ?>

  <link rel="stylesheet" href="<?= $us_url_root ?>users/js/pagination/datatables.min.css">
  <div class="header-menu">
    <div class="col-sm-4">
      <!-- <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-hand-o-left"></i></a> -->
      <div class="page-header float-left">
        <div class="page-title">
          <?php
          include($abs_us_root . $us_url_root . 'users/includes/migrations.php');
          $updates = $db->query("SELECT * FROM updates");
          if (!$db->error()) {
            $updates = $db->results();
            $existing_updates = [];
            foreach ($updates as $u) {
              $existing_updates[] = $u->migration;
            }

            $missing = array_diff($migrations, $existing_updates);
            if (count($missing)) { ?>
              <span style="color:red">Your database is out of date. Please <a href='<?= $us_url_root ?>users/updates/' class='nounderline'>click here</a> to run the updater.</span>
          <?php }
          } ?>
        </div>
      </div>
    </div>
  </div>
</header>