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
class Hash{

	public static function make($string, $salt = ''){
		return hash('sha256', $string . $salt);
	}

	//Deprecated because mcrypt_create_iv is no longer availabe in modern php versions.
	
	// public static function salt($length){
	// 	return mcrypt_create_iv($length);
	// }

	public static function unique(){
		return self::make(uniqid());
	}
}
