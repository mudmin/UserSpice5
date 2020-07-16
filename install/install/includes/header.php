<?php
ini_set('max_execution_time', 1356);
ini_set('memory_limit','1024M');
?><?php require_once("install_settings.php"); ?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>UserSpice Installation</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY=" crossorigin="anonymous" />
		<style>.table td,.table th{padding: .2rem .7rem}</style>
	</head>
<body>
<header>
  <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container d-flex justify-content-between">
      <a href="/install/" class="navbar-brand d-flex align-items-center">
		<strong>User</strong>Spice
      </a>
    </div>
  </div>
</header>

 <?php
 function redirect($location = null){
   if ($location) {
       if (!headers_sent()){
           header('Location: '.$location);
           exit();
         } else {
           echo '<script type="text/javascript">';
           echo 'window.location.href="'.$location.'";';
           echo '</script>';
           echo '<noscript>';
           echo '<meta http-equiv="refresh" content="0;url='.$location.'" />';
           echo '</noscript>'; exit;
         }
   }
 }
 ?>
