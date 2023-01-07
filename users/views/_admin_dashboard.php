<!-- Begin Widgets -->
<!-- <div class="col-sm-12 mb-6"> -->
<div class="row" id="widgetList">
  <?php
  $ordered = explode(",",$settings->widgets);
  // dnd($ordered);
  $widgets = glob($abs_us_root.$us_url_root.'usersc/widgets/*' , GLOB_ONLYDIR);
  $found = false;
  foreach($widgets as $w){
    $string = str_replace($abs_us_root.$us_url_root.'usersc/widgets/',"",$w);
    if(!in_array($string,$ordered)){
      $ordered[] = $string;
      $found = true;
    }
  }
  if($found){
    $string = implode(",",$ordered);
    usSuccess("New widget found");
    $db->update("settings",1,["widgets"=>$string]);
  }

  foreach($ordered as $w){
    if(file_exists($abs_us_root.$us_url_root.'usersc/widgets/'.$w.'/widget.php')){
      $widgetName = $w;
      include($abs_us_root.$us_url_root.'usersc/widgets/'.$w.'/widget.php');
    }
  }
  ?>
  </div>
  <script type="text/javascript">
    let cardVisibility = "";
    <?php foreach($ordered as $w){ ?>
      cardVisibility = localStorage.getItem("<?=INSTANCE.$w?>");
      if(cardVisibility == "false"){
        $("#<?=$w?>-card-body").hide();
        $('#<?=$w?>-caret').html(`<i class="fa fa-caret-right"></i>`);
      }
    <?php } ?>
  </script>
<!-- </div> -->

<!-- End Widgets -->
<!-- admin_panel_buttons.php-->
<?php if(file_exists($abs_us_root.$us_url_root.'usersc/includes/admin_panel_buttons.php')){ ?>
  <div class="col-sm-12 mb-6">
    <?php include($abs_us_root.$us_url_root.'usersc/includes/admin_panel_buttons.php');?>
  </div>
<?php } ?>
<div class="row">
  <div class="col-6 text-start">
    <?php if(in_array($user->data()->id,$master_account)){ ?>
        You have a Master Account (<a href="https://userspice.com/master-account/">What's this?</a>)
    <?php } ?>
  </div>
  <div class="col-6 text-end">
    <a href="admin.php?view=spice&type=widget">Download More Widgets</a>
  </div>
</div>

<script type="text/javascript">


new Sortable(widgetList, {
  sortable: true, draggable: '.dash-card',
  store: {
        set: (sortable) => {
          var order = sortable.toArray();
          console.log(order);
          $.ajax({
            url: 'parsers/widgets.php',
            type: 'POST',
            dataType: 'json',
            data: {action: 'sort_widgets', order, token: "<?=Token::generate()?>"}
          });
        }
      }
});

</script>
