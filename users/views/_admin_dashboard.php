<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li class="active">Dashboard</li>
      </ol>
    </div>
  </div>
</div>
</div>
</header><!-- /header -->
<div class="content mt-3">
  <div class="row">
    <div class="col-6 text-left">
      <?php if(in_array($user->data()->id,$master_account)){ ?>
          You have a Master Account (<a href="https://userspice.com/master-account/">What's this?</a>)
      <?php } ?>
    </div>
    <div class="col-6 text-right">
      <a href="admin.php?view=spice&type=widget">Download Official Widgets</a> or <a href="https://userspice.com/widgets">Download More Widgets</a>
    </div>
  </div>


<!-- Begin Widgets -->
<!-- <div class="col-sm-12 mb-6"> -->
  <?php
  $widgets = glob($abs_us_root.$us_url_root.'usersc/widgets/*' , GLOB_ONLYDIR);
  foreach($widgets as $w){
    if(file_exists($w.'/widget.php')){
      include($w.'/widget.php');
    }
  }
  ?>
<!-- </div> -->

<!-- End Widgets -->
<!-- admin_panel_buttons.php-->
<?php if(file_exists($abs_us_root.$us_url_root.'usersc/includes/admin_panel_buttons.php')){ ?>
  <div class="col-sm-12 mb-6">
    <?php include($abs_us_root.$us_url_root.'usersc/includes/admin_panel_buttons.php');?>
  </div>
<?php } ?>
