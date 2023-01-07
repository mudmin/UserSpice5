<?php
$menu_title = "main";

if (!empty($_POST['migrateMenu'])) {
  $token = $_POST['csrf'];
  if (!Token::check($token)) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }
  migrateUSMainMenu();
  usSuccess("Your main menu has been migrated");
  Redirect::to($us_url_root . 'users/admin.php?view=nav');
}

if (!empty($_GET['action'])) {
  $action = Input::get('action');

  if ($action == 'newDropdown') {
    /*
    Inserts default "dropdown" entry
    */
    $fields = array('menu_title' => $menu_title, 'parent' => '-1', 'dropdown' => '1', 'logged_in' => '1', 'display_order' => '99999', 'label' => 'New Dropdown', 'link' => '#', 'icon_class' => '');
    $db->insert('menus', $fields);
    $lastId = $db->lastId();
    logger($user->data()->id, "Menu Manager", "Added new dropdown");
    Redirect::to($us_url_root . "users/admin.php?view=nav_item&id=$lastId&action=edit");
  } elseif ($action == 'newItem') {
    /*
    Inserts default "item" entry
    */
    $fields = array('menu_title' => $menu_title, 'parent' => '-1', 'dropdown' => '0', 'logged_in' => '1', 'display_order' => '99999', 'label' => 'New Item', 'link' => '#', 'icon_class' => '');
    $db->insert('menus', $fields);
    $lastId = $db->lastId();
    logger($user->data()->id, "Menu Manager", "Added new item");
    Redirect::to($us_url_root . "users/admin.php?view=nav_item&id=$lastId&action=edit");
  } elseif ($action == 'delete' && isset($_GET['id'])) {
    $itemId = Input::get('id');
    if (is_numeric($itemId)) {
      $db->deleteById('menus', $itemId);
      logger($user->data()->id, "Menu Manager", "Deleted menu $itemId");
      Redirect::to($us_url_root . 'users/admin.php?view=nav');
    } else {
      usError("This menu item does not exist");
      Redirect::to($us_url_root . 'users/admin.php?view=nav');
    }
  } else {
    Redirect::to($us_url_root . 'users/admin.php?view=nav');
  }
}
/*
Query requested menu_title
*/
$menu_item_results = $db->query("SELECT * FROM menus WHERE menu_title=? ORDER BY display_order", [$menu_title]);
$menu_items = $menu_item_results->results();


if (!$menu_items) {
  //Redirect::to($us_url_root.'users/admin_menus.php?err=This+menu+does+not+exist.');
}

/*
Make indented tree
*/
$indentedMenuItems = prepareIndentedMenuTree($menu_item_results->results(true));
//dump($indentedMenuItems);
/*
$menu_items will contain array of associative arrays
*/
$menu_items_array = $indentedMenuItems;

/*
foreach below will loop through array and build array of objects from the associative arrays
*/
$menu_items = [];
foreach ($menu_items_array as $menu_item) {
  $menu_items[] = (object)$menu_item;
}

/*
Grab all records which are marked as dropdowns/parents
*/
$parent_results = $db->query("SELECT * FROM menus WHERE menu_title=? AND dropdown=1", [$menu_title]);
$parents = $parent_results->results();
$parentsSelect[-1] = 'No Parent';
foreach ($parents as $parent) {
  $parentsSelect[$parent->id] = $parent->label;
}

/*
Get groups and names
*/
// $allGroups = fetchAllGroups();
// $groupsSelect[0]='Unrestricted';
// foreach ($allGroups as $group) {
// 	$groupsSelect[$group->id]=$group->name;
// }
?>

<h2>Classic Navigation System</h2>
<p>Note: This is the original database-based naviation that has been around since version since UserSpice 3. This is no longer being supported and is primarily here for those who have been using it in existing projects. It's clunky, but it works. For modern projects and templates, you should use the <a href="admin.php?view=menus">UltraMenu</a> instead. We also have a tool at the bottom of this page for migrating your exsting menu system to the UltraMenu.</p>
<p class="text-center mb-3">
  <a href="admin.php?view=nav&action=newDropdown" class="btn btn-dark" role="button">New Dropdown</a>
  <a href="admin.php?view=nav&action=newItem" class="btn btn-dark" role="button">New Item</a>
  <!-- <a href="admin_menu.php?menu_title=<?= $menu_title ?>&action=renumberOrder" class="btn btn-primary" role="button">Renumber Order</a> -->
  <a href="admin.php?view=nav" class="btn btn-dark" role="button">Refresh</a>
</p>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-striped table-hover table-condensed" id="navTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Label</th>
              <th>Parent</th>
              <th>Link*</th>
              <th>Dropdown*</th>
              <th>Authorized Groups</th>
              <th class="text-nowrap">Logged In*</th>
              <th>Display Order*</th>
              <th>Icon Class*</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 0;
            $itemCount = sizeof($menu_items);
            foreach ($menu_items as $item) {
            ?>
              <tr>
                <td><?= $item->id ?></td>

                <td class="text-nowrap"><?= (($item->indent) ? '>>> ' : '') . $item->label ?></td>
                <td class="text-nowrap"><?= $parentsSelect[$item->parent] ?></td>
                <td>
                  <p class="oce text-dark" data-id="<?= $item->id ?>" data-field="link" data-input="input"><?= $item->link ?></p>
                </td>

                <td>
                  <p class="oce text-dark" data-id="<?= $item->id ?>" data-field="dropdown" data-input="select"><?= ($item->dropdown) ? 'Yes' : 'No'; ?></p>
                </td>
                <td>
                  <?php
                  $_auth_group = "";
                  foreach (fetchGroupsByMenu($item->id) as $g) {
                    switch ($g->group_id) {
                      case '0':
                        $_auth_group = "Everyone";
                        break;
                      default:
                        $_auth_group .= $db->findById($g->group_id, 'permissions')->first()->name;
                        $_auth_group .= ",";
                    }
                  }
                  if ($_auth_group == "Everyone") {
                    echo $_auth_group;
                  } else {
                    echo substr($_auth_group, 0, -1);
                  }
                  ?>
                </td>
                <td>
                  <p class="oce text-dark" data-id="<?= $item->id ?>" data-field="logged_in" data-input="select"><?= ($item->logged_in) ? 'Yes' : 'No'; ?></p>
                </td>
                <td>
                  <p class="oce text-dark" data-id="<?= $item->id ?>" data-field="display_order" data-input="input"><?= $item->display_order ?></p< /td>


                <td><?= $item->icon_class ?></td>
                <td>
                  <a class="text-dark" href="admin.php?view=nav_item&id=<?= $item->id ?>&action=edit"><span class="fa fa-cog fa-lg"></span></a> /
                  <a class="text-dark" href="admin.php?view=nav&id=<?= $item->id ?>&action=delete"><span class="fa fa-remove fa-lg"></span></a>
                </td>
              </tr>
            <?php
              $i++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<p>This tool will convert your existing "classic" menu to the new UltraMenu system. It is experimental, but it will get you close. It does not touch or affect your current classic menu in any way, however it will erase anything that you currently have stored in menu id 1 in the UltraMenu system. The good news is that you can run this tool over and over again without affecting your current menu. UltraMenu only works with the newer Bootstrap 5 templates. The thought is that as you migrate from older versions of UserSpice, you can test everything until it's right before going live with a new template and menu system.</p>
<form class="" action="" method="post">
  <?= tokenHere(); ?>
  <p class="text-center">
    <input type="submit" name="migrateMenu" value="Please migrate my menu to UltraMenu" class="btn btn-primary mb-4">
  </p>

</form>

<script type="text/javascript" src="js/pagination/datatables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#navTable').DataTable({
      "pageLength": 25,
      "stateSave": true,
      "aLengthMenu": [
        [25, 50, 100, -1],
        [25, 50, 100, "All"]
      ],
      "aaSorting": []
    });
  });
</script>