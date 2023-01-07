<style media="screen">
.sidebar {
  height: 100%;
}

.sidebar > nav > ul > li {
  padding-top: 4px;
  padding-bottom: 4px;
}
.sidebar .caret {
  position: absolute;
  right: 1em;
  top: 0.85em;
  transform: rotate(-90deg);
}
.sidebar .open .caret {
  transform: rotate(0deg);
}

.sidebar-wrapper{
  width:auto;
}

.sidebar-fallback{
  width:100%;
}

@media only screen and (max-width: 960px) {
  .sidebar-wrapper {
    display:none !important;
  }
  .sidebar-fallback {
    display:unset !important;
  }

}

@media only screen and (min-width: 961px) {
  .sidebar-fallback {
    display:none !important;
  }
  .sidebar-wrapper {
      display:unset !important;
  }
}
</style>
<?php
if($dashboard_sidebar_menu == true && $hide_top_navigation == true){
?>
<div class="row sidebar-fallback">
<div class="col-xs-12">
    <span class="mx-2"><a href="<?=$us_url_root?>"><?=$lang["MENU_HOME"];?></a></span>
    <span class="mx-2"><a href="<?=$us_url_root?>users/admin.php"><?=$lang["MENU_DASH"];?></a></span>
</div>
</div>
<?php } ?>


<div class="col-xs-3 col-xl-2 sidebar-wrapper" style="margin-left: -1rem;">
  <div class="d-flex flex-column p-3 text-bg-dark sidebar">
    <?php
     // $menu_override is the menu you specified in usersc/includes/dashboard_overrides.php
    $menu = new Menu($menu_override);
    $override = [
      "layout"=>"accordion",  //horizontal, accordion
  ];
  if($dashboard_sidebar_menu == true && $hide_top_navigation == false){
    $override["show_branding"] = false;
  }else{
    $override["show_branding"] = true;
  }
  $menu->display($override);
?>
  </div>
</div>
