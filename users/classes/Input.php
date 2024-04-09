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

	public static function get($item, $trim = true, $fallback = false){
		if (isset($_POST[$item])) {
			/*
			If the $_POST item is an array, process each item independently, and return array of sanitized items.
			*/
			return self::sanitize($_POST[$item], $trim, $fallback);

		} elseif(isset($_GET[$item])){
			/*
			If the $_GET item is an array, process each item independently, and return array of sanitized items.
			*/
			return self::sanitize($_GET[$item], $trim, $fallback);
		}
		return '';
	}

	public static function sanitize($item, $trim = true, $fallback = false){
		if($item == []){
			return $item;
		}
		if (is_array($item)){
			foreach ($item as $key => $itemValue){
				$postItems[$key]=self::sanitize($itemValue, $trim, $fallback);
			}
			return $postItems;
		}elseif(is_object($item)){
			$item = (array)$item;
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
					$item = htmlentities($item, ENT_QUOTES, 'UTF-8');
				}else{
			 		$item = htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
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
