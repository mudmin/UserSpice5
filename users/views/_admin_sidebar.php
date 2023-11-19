<style media="screen">
  .sidebar {
    height: 100%;
  }
  .sidebar > nav > ul >li {
    padding-top: 4px;
    padding-bottom: 4px;
  }
  .sidebar .caret {
    position: absolute;
    right: 8px;
    top: 0.85em;
    transform: rotate(-90deg);
  }
  .sidebar .open .caret {
    transform: rotate(0deg);
  }
  .sidebar-wrapper {
    width: auto;
  }
  .sidebar-fallback {
    width: 100%;
    padding: 1em;
    margin-bottom: 1.5em;
  }
   .sidebar-fallback {
    display: none;
  }
  .sidebar-wrapper {
    display: unset;
  }

  @media only screen and (max-width: 960px) {
    .sidebar-wrapper {
      display: none;
    }
    .sidebar-fallback {
      display: unset;
    }
    #page-wrap {
      flex-direction: column;
    }
  }
</style>
<?php
if ($dashboard_sidebar_menu == true && $hide_top_navigation == true) {
  if(file_exists($abs_us_root . $us_url_root . "usersc/views/_admin_sidebar_fallback_menu.php")){
    require_once $abs_us_root . $us_url_root . "usersc/views/_admin_sidebar_fallback_menu.php";
  }else{
?>
  <div class="col-12 sidebar-fallback w-100 border-bottom bg-light mb-4">
    <nav>
      <ul class="nav">
        <li class="nav-link mx-2"><a href="<?= $us_url_root ?>"><?= $lang["MENU_HOME"]; ?></a></li>
        <li class="nav-link mx-2"><a href="<?= $us_url_root ?>users/admin.php"><?= $lang["MENU_DASH"]; ?></a></li>
      </ul>
    </nav>
  </div>
<?php } 
}
?>


<div class="col-xs-3 col-xl-2 ps-0 sidebar-wrapper">
  <div class="d-flex flex-column p-2 text-bg-dark sidebar">
    <?php
    // $menu_override is the menu you specified in usersc/includes/dashboard_overrides.php

    //There is a new sidebar_menu_id that allows you to set a different menu in the sidebar than the top in dashboard_overrides. If it's not there, you can add it.

    if(isset($sidebar_menu_id)){
      $menu_override = $sidebar_menu_id;
    }
    
    $menu = new Menu($menu_override);
    $override = [
      "layout" => "accordion",  //horizontal, accordion
    ];
    if ($dashboard_sidebar_menu == true && $hide_top_navigation == false) {
      $override["show_branding"] = false;
    } else {
      $override["show_branding"] = true;
    }
    $menu->display($override);
    ?>
  </div>
</div>