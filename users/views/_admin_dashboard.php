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
          <a href="admin.php?view=spice&type=widget">Download Official Widgets</a> or <a href="https://userspice.com/widgets" class="button">Download More Widgets</a>
    </div>
  </div>


<!-- Begin Widgets -->
<!-- <div class="col-sm-12 mb-6"> -->
  <?php
  $widgets = glob($abs_us_root.$us_url_root.'usersc/widgets/*' , GLOB_ONLYDIR);
  foreach($widgets as $w){
    include($w.'/widget.php');
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
<!-- End admin_panel_buttons.php -->
<div class="row">
<div class="col-12">

  <?php if(isset($message) && $message != ''){  ?>
  <div class="sufee-alert alert with-close alert-<?=$class?> alert-dismissible fade show">
    <span class="badge badge-pill badge-<?=$class?>"><?php echo htmlspecialchars($title);?></span> <a href="<?php echo htmlspecialchars($link);?>"><?php echo htmlspecialchars($message);?></a>
    <button type="button" class="close dismiss-announcement" data-dismiss="alert"
    data-dis="<?=$dis?>"
    data-ignore="<?=$ignore?>"
    data-title="<?=$title?>"
    data-class="<?=$class?>"
    data-link="<?=$link?>"
    data-message="<?=$message?>"
    aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>
</div>
</div>
  <script type="text/javascript">
  $(document).ready(function() {
    //dismiss notifications
    $(".dismiss-announcement").click(function(event) {
      event.preventDefault();
      console.log("clicked");

      var formData = {
        'dismissed' 					: $(this).attr("data-dis"),
        'link' 					: $(this).attr("data-link"),
        'title' 					: $(this).attr("data-title"),
        'class' 					: $(this).attr("data-class"),
        'message' 					: $(this).attr("data-message"),
        'ignore' 					: $(this).attr("data-ignore")
      };
      //
      $.ajax({
        type 		: 'POST',
        url 		: 'parsers/dismiss_announcements.php',
        data 		: formData,
        dataType 	: 'json',
        encode 		: true
      })
    });


  }); //End DocReady
</script>
