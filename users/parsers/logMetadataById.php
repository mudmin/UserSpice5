<?php
require_once '../init.php';
$db = DB::getInstance();
$settings = $db->query('SELECT * FROM settings')->first();
if (!isset($user) || (!hasPerm([2], $user->data()->id) ) ) {
    die('You do not have permission to be here.');
}

$return = [
  'isJson' => false,
  'Data' => null,
];

$id = Input::get('id');
$db->query('SELECT * FROM logs WHERE id = ?', [$id]);
if ($db->count() == 1) {
    $return['Data'] = $db->first();
    if (validateJson($return['Data']->metadata)) {
        $return['isJson'] = true;
        $return['Data']->metadata = json_decode($return['Data']->metadata);
    }
    dump($return['Data']->metadata);
} else {
    dump(null);
}

die();
