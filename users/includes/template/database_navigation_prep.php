  <?php
  /*
  Load main navigation menus
  */
  $main_nav_all = $db->query("SELECT * FROM menus WHERE menu_title='main' ORDER BY display_order");

  /*
  Set "results" to true to return associative array instead of object...part of db class
  */
  $main_nav=$main_nav_all->results(true);

  /*
  Make menu tree
  */
  $prep=prepareMenuTree($main_nav);

  ?>
