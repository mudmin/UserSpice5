<?php
global $user, $us_url_root, $abs_us_root;
$db = DB::getInstance();
if (!Token::check(Input::get('token'))) {
  include $abs_us_root . $us_url_root . 'usersc/scripts/token_error.php';
}
$menuId = (int)Input::get('menu_id');
if($menuId == 1 || $menuId == 2){
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
