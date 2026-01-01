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
class Input {
    public static function exists($type = 'post'){
        switch ($type) {
            case 'post':
            return (!empty($_POST)) ? true : false;
            break;

            case 'get':
            return (!empty($_GET)) ? true : false;

            default:
            return false;
            break;
        }
    }

    /**
     * Gets an item from $_POST or $_GET.
     * @param string $item - The key of the item to retrieve.
     * @param mixed $trim_or_default - If boolean, controls trimming. If not, acts as the default value.
     * @param boolean $fallback - If true, uses htmlentities instead of htmlspecialchars.
     * @param mixed $default_value - The default value to return if the item is not found (used when the 2nd param is a boolean).
     * @return mixed - The sanitized value or the default value.
	 * DEVELOPER NOTE: AI and other coding tools always expect the second param to be a default value.  These updates allow that to work without losing our default behavior. 
	 * If you do NOT want to trim the value (default behavior) and still set a default value, you can use the 4th param for that.
	 * 
	 * DO NOT rely on this feature if your code will be running on old versions of UserSpice such as plugins or at minimum, validate your input as BOTH
	 *  $password = Input::get('password', randomstring(16));
	 *	$password = Input::get('password',true,false, randomstring(16));
	 * will return "" on versions of UserSpice < 5.9.2 
     */
    public static function get($item, $trim_or_default = true, $fallback = false, $default_value = ''){
        $trim = true;
        $default = $default_value; // Start with the explicit default from the 4th param.

        if (is_bool($trim_or_default)) {
            // The 2nd param is a boolean, so it controls trimming.
            $trim = $trim_or_default;
        } else {
            // The 2nd param is not a boolean, so treat it as the default value.
            // When using this shorthand, we assume trimming is still desired.
            $trim = true;
            $default = $trim_or_default;
        }

        if (isset($_POST[$item])) {
            return self::sanitize($_POST[$item], $trim, $fallback);
        } elseif(isset($_GET[$item])){
            return self::sanitize($_GET[$item], $trim, $fallback);
        }

        // The item was not found in $_POST or $_GET, return the determined default.
        return $default;
    }

    public static function sanitize($item, $trim = true, $fallback = false){
        if($item == []){
            return $item;
        }
        if (is_array($item)){
            $postItems = [];
            foreach ($item as $key => $itemValue){
                $postItems[$key]=self::sanitize($itemValue, $trim, $fallback);
            }
            return $postItems;
        }elseif(is_object($item)){
            $item = (array)$item;
            $postItems = [];
            foreach ($item as $key => $itemValue){
                $postItems[$key]=self::sanitize($itemValue, $trim, $fallback);
            }
            return (object)$postItems;
        }else{
            if(is_bool($item)){
                return $item;
            }else{
            //optional trim and fallback from htmlspecialchars to htmlentities
                if($fallback){
                    $item = htmlentities((string)$item, ENT_QUOTES, 'UTF-8');
                }else{
                    $item = htmlspecialchars((string)$item, ENT_QUOTES, 'UTF-8');
                }
                if($trim){
                    return trim($item);
                }
                return $item;
        }
    }
}

public static function recursive($object, $trim = true, $fallback = false){
    foreach($object as $key => $val){
        if(is_array($val)){
            $object[$key] = self::recursive($val, $trim, $fallback);
        } else {
            $object[$key] = self::sanitize($val, $trim, $fallback);
        }
    }
    return $object;
}

public static function json($json, $associative = false, $encode = false, $trim = true, $fallback = false) {
    if(is_string($json)) $json = json_decode($json, true);
    $cleaned = self::recursive($json, $trim, $fallback);
    $encoded = json_encode($cleaned);
    if($encode) return $encoded;
    return json_decode($encoded, $associative);
}
}
