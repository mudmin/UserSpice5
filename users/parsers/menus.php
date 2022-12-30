<?php
require_once '../init.php';
$db = DB::getInstance();
if (!isset($user) || (!hasPerm([2], $user->data()->id) ) ) {
  die("You do not have permission to be here.");
}

$resp = ['success' => false];
if(!Token::check(Input::get('token'))){
  $resp['msg'] = "Invalid token";
  echo json_encode($resp);
  die;
}

$action = Input::get('action');

if($action == 'sort_menu_items') {
  $menuId = Input::get('menu_id');
  $itemId = Input::get('item_id');
  $order = Input::get('order');
  $sql = "";
  $binds = [];
  foreach($order as $index  => $id) {
    $ordering = $index + 1;
    $sql .= "UPDATE us_menu_items SET display_order = ? WHERE id = ? AND menu = ?;";
    $binds[] = $ordering;
    $binds[] = $id;
    $binds[] = $menuId;
  }
  if(!empty($sql)) {
    $db->query($sql, $binds);
    $success = !$db->error();
    $resp['success'] = $success;
  }
}
echo json_encode($resp);
die;
