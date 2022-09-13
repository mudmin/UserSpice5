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

	public static function get($item){
		if (isset($_POST[$item])) {
			/*
			If the $_POST item is an array, process each item independently, and return array of sanitized items.
			*/
			return self::sanitize($_POST[$item]);

		} elseif(isset($_GET[$item])){
			/*
			If the $_GET item is an array, process each item independently, and return array of sanitized items.
			*/
			return self::sanitize($_GET[$item]);
		}
		return '';
	}

	public static function sanitize($item){
		if($item == []){
			return $item;
		}
		if (is_array($item)){
			foreach ($item as $key => $itemValue){
				$postItems[$key]=self::sanitize($itemValue);
			}
			return $postItems;
		}elseif(is_object($item)){
			$item = (array)$item;
			foreach ($item as $key => $itemValue){
				$postItems[$key]=self::sanitize($itemValue);
			}
			return (object)$postItems;
		}else{
			if(is_bool($item)){
				return $item;
			}else{
			return trim(htmlentities($item, ENT_QUOTES, 'UTF-8'));
		}
	}
}

public static function recursive($object){
	foreach($object as $key => $val){
		if(is_array($val)){
			$object[$key] = self::recursive($val);
		} else {
			$object[$key] = self::sanitize($val);
		}
	}
	return $object;
}

public static function json($json, $associative = false, $encode = false) {
	if(is_string($json)) $json = json_decode($json, true);
	$cleaned = self::recursive($json);
	$encoded = json_encode($cleaned);
	if($encode) return $encoded;
	return json_decode($encoded, $associative);
}
}
