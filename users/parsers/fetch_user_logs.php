<?php
require_once '../init.php';
if(!in_array($user->data()->id, $master_account)){ die();}

$response = ['status' => 'error', 'message' => 'No user found'];

if(isset($_POST['userId'])) {
    $theId = Input::get('userId');
    $query = $db->query("SELECT id, fname, lname, username, email from users WHERE id = ?",[$theId]);
    if($query->count() > 0) {
        $userData = $query->first();
        $response = [
            'status' => 'success',
            'data' => [
                'id' => $userData->id,
                'name' => $userData->fname . ' ' . $userData->lname,
                'username' => $userData->username,
                'email' => $userData->email
            ]
        ];
    }
}

echo json_encode($response);