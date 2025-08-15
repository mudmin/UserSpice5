<?php 
$noMaintenanceRedirect = true; 
require_once '../init.php'; 
$resp = ['success'=>false, 'score'=>0];
if(!isset($_POST['pw_settings'])){
    echo json_encode($resp);die;
}
if(!isset($_POST['password'])){
    echo json_encode($resp);die;
}
$pw_settings = $_POST['pw_settings'];
if(!is_array($pw_settings) && !is_object($pw_settings)){
    echo json_encode($resp);die;
}
$pw_settings = (object) $pw_settings;
if(!isset($pw_settings->min_length)){
    echo json_encode($resp);die;
}
foreach($pw_settings as $key => $value){
    $pw_settings->key = (int) $value;
}
$password = $_POST['password'];
$score = userSpicePasswordScore($password);
$response = ['success'=>true, 'score'=>$score];
echo json_encode($response);die;
