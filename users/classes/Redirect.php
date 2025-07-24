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
class Redirect {

//This method no longer checks to see if a link is valid before redirecting
//to prevent conflicts with deep folder structures
public static function to($location = null, $args=''){
    global $us_url_root,$settings,$user;
    if ($location) {

      if($settings != "" && $settings->debug > 0){
        if($settings->debug == 2 || ($settings->debug == 1 && isset($user) && $user->isLoggedIn() && $user->data()->id == 1)){
          
          // Get full backtrace for better debugging
          $backtrace = debug_backtrace();
          $caller = $backtrace[0];
          
          // Try to find the actual calling function/method
          $realCaller = '';
          if (isset($backtrace[1])) {
            if (isset($backtrace[1]['class'])) {
              $realCaller = $backtrace[1]['class'] . '::' . $backtrace[1]['function'] . '() ';
            } elseif (isset($backtrace[1]['function'])) {
              $realCaller = $backtrace[1]['function'] . '() ';
            }
          }
          
          $fullPath = $caller['file'];
          $line = $caller['line'];
          
          if(!isset($user) || !$user->isLoggedIn()){
            $loggingUserId = 0;
          }else{
            $loggingUserId = $user->data()->id;
          }
          
          $loc = Input::sanitize($location);
          logger($loggingUserId,"Redirect Diag","From {$realCaller}{$fullPath} on line {$line} to {$loc}");
        }
      }

      if ($args) $location .= $args;
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

//This is the old Redirect::to method that attempts to see if a link is valid before redirecting
  public static function safe($location = null, $args=''){
    global $us_url_root,$settings,$user;
    if ($location) {


      if($settings != "" && $settings->debug > 0){
        if($settings->debug == 2 || ($settings->debug == 1 && isset($user) && $user->isLoggedIn() && $user->data()->id == 1)){
          $cp = currentPage();
          $line = debug_backtrace();
          $line = $line[0]["line"];
          if(!isset($user) || !$user->isLoggedIn()){
            $loggingUserId = 0;
          }else{
            $loggingUserId = $user->data()->id;
          }
          logger($loggingUserId,"Redirect Diag","From $cp on line $line to $location");
        }
        }


      if (!preg_match('/^https?:\/\//', $location) && !file_exists($location)) {
        foreach (array($us_url_root, '../', 'users/', substr($us_url_root, 1), '../../', '/', '/users/') as $prefix) {
          if (file_exists($prefix.$location)) {
            $location = $prefix.$location;
            $location = preg_replace('~/{2,}~', '/', $location);
            break;
          }
        }
      }
      if ($args) $location .= $args; // allows 'login.php?err=Error+Message' or the like
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

}
