<?php
global $user, $us_url_root;
$db = DB::getInstance();
$menuId = Input::get('menu_id');
if($id == 1 || $id == 2){
    usError("You cannot delete menu 1 or 2");
    Redirect::to("{$us_url_root}users/admin.php?view=menus");
}
$menu = $db->findById($menuId, 'us_menus')->first();
if($menu) {
  // delete all menu items
  $db->query("DELETE FROM us_menu_items WHERE menu = ?", [$menu->id]);
  // delete menu
  $db->deleteById('us_menus', $menu->id);
}
usSuccess("Menu Deleted");
Redirect::to("{$us_url_root}users/admin.php?view=menus");
