<?php
/*
UserSpice 5
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
if(file_exists($abs_us_root.$us_url_root.'usersc/includes/footer.php')){
  require_once $abs_us_root.$us_url_root.'usersc/includes/footer.php';
}

//Plugin hooks
foreach($usplugins as $k=>$v){
  if($v == 1){
  if(file_exists($abs_us_root.$us_url_root."usersc/plugins/".$k."/footer.php")){
    include($abs_us_root.$us_url_root."usersc/plugins/".$k."/footer.php");
    }
  }
}

require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/footer.php';

?>
<script type="text/javascript">
setTimeout(function(){
$(".errSpan").html("<h4><br></h4>");
} , "<?=$settings->err_time*1000?>");


var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})

var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
var tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

</script>

  </body>
</html>
