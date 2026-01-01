<?php
/*
UserSpice
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

?>
<?php
ini_set('allow_url_fopen', 1);
require_once '../users/init.php';

$view = Input::get('view');

//note that the dashboard widget cards are in either users/modules/widgets.php or usersc/modules/widgets.php and are called from a view, which explains why they are not included in the list below. 
$modules = [
  "dashboard_prep", //open class, overrides, basic checks
  "menus",
  "announcements",  //userspice announcements and version updates
  "styling",
  "sidebar",
  "content_open",
  "header", //maint mode, debug mode, and legacy dashboard overrides
  "views",  //this decides which views can and cannot be loaded.  Feel free to put some overrides in here based on perm/tag
  "system_messages", //successs/fail messages etc
  "content_close",
  "system_messages_footer",
  "footer", //footer and plugin footers
  "dashboard_js", //ajax calls and general dashboard javascript
];

foreach($modules as $m){
  if(file_exists($abs_us_root . $us_url_root . "usersc/modules/".$m.".php")){
    require_once $abs_us_root . $us_url_root . "usersc/modules/".$m.".php";
  }else{
    require_once $abs_us_root . $us_url_root . "users/modules/".$m.".php";
  }
}

