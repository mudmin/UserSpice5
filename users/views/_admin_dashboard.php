<!-- Begin Widgets -->
<!-- <div class="col-sm-12 mb-6"> -->
<div class="row">
    <div class="col-12 col-sm-6 offset-sm-3 col-md-4 offset-md-4 text-center mb-1">
      <input type="text" id="filter" style="width:100%" autofocus placeholder="Filter">
    </div>
  </div>
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
  sortable: true,
  draggable: '.dash-card',
  handle: '.grippy', // 'filtered' class is not draggable
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

document.addEventListener("DOMContentLoaded", function () {
  const filterInput = document.getElementById("filter");
  const dashCards = document.querySelectorAll(".dash-card"); // Select all dash-card elements
  const filterableElements = document.querySelectorAll(".icon-link, .dashboard-icon-label, .filterable-card"); 
  filterInput.addEventListener("keyup", function () {
    const filterText = filterInput.value.toLowerCase();

    // Check if the filter input is empty
    if (filterText.length === 0) {
      // If it's empty, show all dash cards and all filterable elements
      dashCards.forEach(function (dashCard) {
        dashCard.style.display = "block";
      });

      filterableElements.forEach(function (element) {
        element.style.display = "block";
      });

      return;
    }

    // Loop through each dash-card element
    dashCards.forEach(function (dashCard) {
      const iconsInCard = dashCard.querySelectorAll(".icon-link"); // Select icons within the current dash-card

      // Check if there are any icons within the current card
      const cardHasIcons = Array.from(iconsInCard).some(function (iconLink) {
        const label = iconLink.querySelector(".dashboard-icon-label");
        return label.textContent.toLowerCase().includes(filterText);
      });

      // Check if the card has the class 'manual-filter'
      const hasManualFilter = dashCard.querySelector(".manual-filter");

      // Show or hide the dash-card based on whether it has icons and the manual-filter class
      if ((cardHasIcons || hasManualFilter) && !hasManualFilter) {
        dashCard.style.display = "block";
      } else {
        dashCard.style.display = "none";
      }
    });

    // Loop through each filterable element
    filterableElements.forEach(function (element) {
      // Check if the text content of the element contains the filter text
      if (element.textContent.toLowerCase().includes(filterText)) {
        element.style.display = "block";
      } else {
        element.style.display = "none";
      }
    });
  });
});
</script>
