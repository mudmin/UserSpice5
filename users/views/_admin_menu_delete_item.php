<?php
global $user, $us_url_root;
$db = DB::getInstance();
$menuId = Input::get('menu_id');
$itemId = Input::get('item_id');

// Capture the item's parent (and grandparent) before deleting so we can return
// the admin to the submenu the item lived in, rather than the top-level menu.
$parentId = 0;
$grandParentId = 0;
$itemRow = $db->query("SELECT parent FROM us_menu_items WHERE id = ? AND menu = ?", [$itemId, $menuId])->first();
if ($itemRow) {
  $parentId = (int)$itemRow->parent;
  if ($parentId > 0) {
    $grandRow = $db->query("SELECT parent FROM us_menu_items WHERE id = ? AND menu = ?", [$parentId, $menuId])->first();
    if ($grandRow) {
      $grandParentId = (int)$grandRow->parent;
    }
  }
}

$menu = new Menu($menuId);
$menu->recursivelyDeleteMenuItem($itemId);

if ($parentId > 0) {
  // Deleted a submenu child - drop back into the parent dropdown so siblings
  // can be deleted one after another without bouncing to the top level.
  Redirect::to("{$us_url_root}users/admin.php?view=edit_menu&menu_id={$menuId}&item_id={$parentId}&parent_id={$grandParentId}");
} else {
  Redirect::to("{$us_url_root}users/admin.php?view=edit_menu&menu_id={$menuId}");
}
