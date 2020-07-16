<p align="center"><?php
include("install/includes/install_settings.php");
foreach ($files as $file) {
	if (!unlink($file)) {
		echo ("Error deleting $file<br>");
	}else{
		echo ("Deleted $file<br>");
	}
}

function rrmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (is_dir($dir."/".$object))
          rrmdir($dir."/".$object);
        else
          unlink($dir."/".$object);
      }
    }
    rmdir($dir);
  }
}

function randomstring($len){
	$len = $len++;
	$string = "";
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	for($i=0;$i<$len;$i++)
	$string.=substr($chars,rand(0,strlen($chars)),1);
	return $string;
}

//read the entire string
$str=file_get_contents('../users/init.php');

//replace something in the file string - this is a VERY simple example
$str=str_replace('pmqesoxiw318374csb', randomString(20),$str);
$str=str_replace("'session_name' => 'user'", "'session_name' => '".randomString(20)."'",$str);

//write the entire string
file_put_contents('../users/init.php', $str);
rmdir("install");
?>
</p>
<p align="center">If you made it this far, everything SHOULD be good to go. If you see any errors above, you will want to navigate to the install folder, and delete it manually.  Don't forget to check out UserSpice.com if you need any help. Click the button below to make sure you have the latest updates to your database.</p>


<h3 align="center"><a class="button" href="../users/update.php">Update Database and Login!</a></h3>

<?php
//this is a temporary fix
require_once("../users/classes/Redirect.php");
Redirect::to("../users/update.php?installer=1");

?>
