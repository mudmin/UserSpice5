<?php
require_once $abs_us_root.$us_url_root.'usersc/includes/analytics.php';

foreach($usplugins as $k=>$v){
  if($v == 1){
  if(file_exists($abs_us_root.$us_url_root."usersc/plugins/".$k."/header.php")){
    include($abs_us_root.$us_url_root."usersc/plugins/".$k."/header.php");
    }
  }
}
	?>
