<?php
require_once '../init.php';
$db = DB::getInstance();

if ((!isset($user) || !$user->isLoggedIn()) || !hasPerm([2], $user->data()->id) ) {
    die('You do not have permission to be here.');
}

if(!Token::check(Input::get('token'))){
  $msg = [];
  $msg['success'] = "false";
  $msg['msg'] = "Invalid token";
  echo json_encode($msg);
  die;
}

$return = [
  'isJson' => false,
  'Data' => null,
];

header('Content-Type: text/plain; charset=UTF-8');
header('X-Content-Type-Options: nosniff');

$id = Input::get('id');
$db->query('SELECT * FROM logs WHERE id = ?', [$id]);
if ($db->count() == 1) {
    $return['Data'] = $db->first();
    if (validateJson($return['Data']->metadata)) {
        $return['isJson'] = true;
        $return['Data']->metadata = json_decode($return['Data']->metadata);
    }
    var_dump($return['Data']->metadata);
} else {
    var_dump(null);
}

die();
