<?php
global $user, $us_url_root;
$db = DB::getInstance();
$menuId = Input::get('menu_id');
$itemId = Input::get('item_id');
$menu = new Menu($menuId);
if($menu) {
 $menu->recursivelyDeleteMenuItem($itemId);
}

Redirect::to("{$us_url_root}users/admin.php?view=edit_menu&menu_id={$menuId}");
