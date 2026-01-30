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
class Token {
  public static function generate($force = false) {
    $tokenName = Config::get('session/token_name');

    if (Session::exists($tokenName)) {
      $token = Session::get($tokenName);
      if (
        !$force &&
        is_string($token) &&
        strlen($token) === 64 &&
        ctype_xdigit($token)
      ) {
        return $token;
      }
    }

    return Session::put($tokenName, bin2hex(random_bytes(32)));
  }

  public static function check($token) {
    $tokenName = Config::get('session/token_name');

    // Validate incoming token format
    if (!is_string($token) || strlen($token) !== 64 || !ctype_xdigit($token)) {
      return false;
    }

    if (!Session::exists($tokenName)) {
      return false;
    }

    $storedToken = Session::get($tokenName);

    // Validate stored token format
    if (!is_string($storedToken) || strlen($storedToken) !== 64 || !ctype_xdigit($storedToken)) {
      return false;
    }

    return hash_equals($storedToken, $token);
  }
}