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
class Validate
{
	public
	$_errors = [],
	$_db     = null,
	$_rules_broken = [];


	public function __construct()  {
		$this->_db = DB::getInstance();
	}

	public function check($source, $items=[], $sanitize=false) {

		$this->_errors = [];

		foreach ($items as $item => $rules) {
			if($sanitize){
				$item = sanitize($item);
			}

			$display = $rules['display'];
			if(!isset($source[$item])){
				$source[$item] = "";
			}

			foreach ($rules as $rule => $rule_value) {
				$value = $source[$item];

				if ($sanitize) {
					$value = sanitize(trim($value));
				}

				$length = is_array($value) ? count($value) : strlen($value);
				$verb   = is_array($value) ? "are"         : "is";

				if ($rule==='required'  &&  $length==0) {
					$str = lang("GEN_REQ");
					if ($rule_value){
						$this->addError(["{$display} $str",$item]);
						$this->ruleBroken([$item,"required",true]);
					}
				}
				else
				if ($length != 0) {
					switch ($rule) {
						case 'min':
						if (is_array($rule_value))
						$rule_value = max($rule_value);
						$str = lang("GEN_MIN");
						$str1 = lang("GEN_CHAR");
						$str2 = lang("VAL_ALLOWED") ?? lang("GEN_REQ");
						if ($length < $rule_value){
							$this->addError(["{$display} $str {$rule_value} $str1 $str2",$item]);
							$this->ruleBroken([$item,"min",$rule_value]);
						}
						break;

						case 'max':
						if (is_array($rule_value))
						$rule_value = min($rule_value);
						$str = lang("GEN_MAX");
						$str1 = lang("GEN_CHAR");
						$str2 = lang("VAL_ALLOWED") ?? lang("GEN_REQ");
						if ($length > $rule_value){
							$this->addError(["{$display} $str {$rule_value} $str1 $str2",$item]);
							$this->ruleBroken([$item,"max",$rule_value]);
						}
						break;

						case 'matches':
						if (!is_array($rule_value))
						$array = [$rule_value];
						$str = lang("GEN_AND");
						$str1 = lang("VAL_SAME");
						foreach ($array as $rule_value)
						if ($value != trim($source[$rule_value])){
							$this->addError(["{$items[$rule_value]['display']} $str {$display} $str1",$item]);
							$this->ruleBroken([$item,"matches",$source]);
						}
						break;

						case 'unique':
						$table  = is_array($rule_value) ? $rule_value[0] : $rule_value;
						$fields = is_array($rule_value) ? $rule_value[1] : [$item, '=', $value];

						if ($this->_db->get($table, $fields)) {
							$str = lang("VAL_EXISTS");
							$str1 = lang("VAL_DB");
							if ($this->_db->count()){
								$this->addError(["{$display} $str {$display}",$item]);
								$this->ruleBroken([$item,"unique",false]);
							}

						} else {
							$this->addError([$str1,$item]);
							$this->ruleBroken([$item,"unique",false]);
						}

						break;

						case 'unique_update':
						$t     = explode(',', $rule_value);
						$table = $t[0];
						$id    = $t[1];
						$query = "SELECT * FROM {$table} WHERE id != {$id} AND {$item} = '{$value}'";
						$check = $this->_db->query($query);
						$str = lang("VAL_EXISTS");
						if ($check->count()){
							$this->addError(["{$display} $str {$display}",$item]);
							$this->ruleBroken([$item,"unique_update",false]);
						}

						break;

						case 'is_numeric': case 'is_num':
						$str = lang("VAL_NUM");
						if ($rule_value  &&  !is_numeric($value)){
							$this->addError(["{$display} $str",$item]);
							$this->ruleBroken([$item,"is_numeric",false]);
						}

						break;

						case 'valid_email':
						$str = lang("VAL_EMAIL");
						if(!filter_var($value,FILTER_VALIDATE_EMAIL)){
							$this->addError(["{$display} $str",$item]);
							$this->ruleBroken([$item,"valid_email",false]);
						}

						break;

						case 'is_not_email':
						if($rule_value){
							$str = lang("VAL_NO_EMAIL");
							if(filter_var($value,FILTER_VALIDATE_EMAIL)){
								$this->addError(["{$display} $str",$item]);
								$this->ruleBroken([$item,"is_not_email",false]);
							}
						}
						break;

						case 'valid_email_beta':
						$str = lang("VAL_EMAIL");
						if(!filter_var($value,FILTER_VALIDATE_EMAIL)){
							$this->addError(["{$display} $str",$item]);
							$this->ruleBroken([$item,"valid_email_beta",false]);
						}

						$email_parts = explode('@', $value);
						$str = lang("VAL_SERVER");
						if ((!filter_var(gethostbyname($email_parts[1]), FILTER_VALIDATE_IP) && !filter_var(gethostbyname('www.' . $email_parts[1]), FILTER_VALIDATE_IP)) && !getmxrr($email_parts[1], $mxhosts)){
							$this->addError(["{$display} $str",$item]);
							$this->ruleBroken([$item,"valid_email_server",false]);
						}
						break;

						case '<'  :
						case '>'  :
						case '<=' :
						case '>=' :
						case '!=' :
						case '==' :
						$array = is_array($rule_value) ? $rule_value : [$rule_value];

						foreach ($array as $rule_value)
						if (is_numeric($value)) {
							$rule_value_display = $rule_value;

							if (!is_numeric($rule_value)  &&  isset($source[$rule_value])) {
								$rule_value_display = $items[$rule_value]["display"];
								$rule_value         = $source[$rule_value];
							}

							if ($rule=="<"  &&  $value>=$rule_value){
								$str = lang("VAL_LESS");
								$this->addError(["{$display} $str {$rule_value_display}",$item]);
								$this->ruleBroken([$item,"<",$rule_value]);
							}

							if ($rule==">"  &&  $value<=$rule_value){
								$str = lang("VAL_GREAT");
								$this->addError(["{$display} $str {$rule_value_display}",$item]);
								$this->ruleBroken([$item,">",$rule_value]);
							}

							if ($rule=="<="  &&  $value>$rule_value){
								$str = lang("VAL_LESS_EQ");
								$this->addError(["{$display} $str {$rule_value_display}",$item]);
								$this->ruleBroken([$item,"<=",$rule_value]);
							}

							if ($rule==">="  &&  $value<$rule_value){
								$str = lang("VAL_GREAT_EQ");
								$this->addError(["{$display} $str {$rule_value_display}",$item]);
								$this->ruleBroken([$item,">=",$rule_value]);
							}

							if ($rule=="!="  &&  $value==$rule_value){
								$str = lang("VAL_NOT_EQ");
								$this->addError(["{$display} $str {$rule_value_display}",$item]);
								$this->ruleBroken([$item,"!=",$rule_value]);
							}

							if ($rule=="=="  &&  $value!=$rule_value){
								$str = lang("VAL_EQ");
								$this->addError(["{$display} $str {$rule_value_display}",$item]);
								$this->ruleBroken([$item,"==",$rule_value]);
							}
						}
						else{
							$str = lang("VAL_NUM");
							$this->addError(["{$display} $str",$item]);
							$this->ruleBroken([$item,"val_num",false]);
						}
						break;

						case 'is_integer': case 'is_int':
						if ($rule_value  &&  filter_var($value, FILTER_VALIDATE_INT)===false){
							$str = lang("VAL_INT");
							$this->addError(["{$display} $str",$item]);
							$this->ruleBroken([$item,"is_int",false]);
						}
						break;

						case 'is_timezone':
						if ($rule_value)
						if (array_search($value, DateTimeZone::listIdentifiers(DateTimeZone::ALL)) === FALSE){
							$str = lang("VAL_TZ");
							$this->addError(["{$display} $str",$item]);
							$this->ruleBroken([$item,"is_timezone",false]);
						}
						break;



						case 'in':
						$verb           = lang("VAL_MUST");
						$list_of_names  = [];	// if doesn't match then display these in an error message
						$list_of_values = [];	// to compare it against

						if (!is_array($rule_value))
						$rule_value = [$rule_value];

						foreach($rule_value as $val)
						if (!is_array($val)) {
							$list_of_names[]  = $val;
							$list_of_values[] = strtolower($val);
						} else
						if (count($val) > 0) {
							$list_of_names[]  = $val[0];
							$list_of_values[] = strtolower((count($val)>1 ? $val[1] : $val[0]));
						}

						if (!is_array($value)) {
							$verb  = lang("VAL_MUST_LIST");
							$value = [$value];
						}

						foreach ($value as $val) {
							if (array_search(strtolower($val), $list_of_values) === FALSE) {
								$this->addError(["{$display} {$verb}: ".implode(', ',$list_of_names),$item]);
								$this->ruleBroken([$item,"is_in_list",false]);
								break;
							}
						}
						break;

						case 'is_datetime':
						if ($rule_value !== false) {
							$object = DateTime::createFromFormat((empty($rule_value) || is_bool($rule_value) ? "Y-m-d H:i:s" : $rule_value), $value);

							if (!$object  ||  DateTime::getLastErrors()["warning_count"]>0  ||  DateTime::getLastErrors()["error_count"]>0){
								$str = lang("VAL_TIME");
								$this->addError(["{$display} $str",$item]);
								$this->ruleBroken([$item,"is_datetime",false]);

							}
						}
						break;

						case 'is_in_array':
						if(!is_array($rule_value)){ //If we're not checking $value against an array, that's a developer fail.
							$str = lang("2FA_FATAL");
							$this->addError(["{$display} $str",$item]);
						} else {
							$to_be_checked = $value; //The value to checked
							$array_to_check_in = $rule_value; //The array to check $value against
							if(!in_array($to_be_checked, $array_to_check_in)){
								$str = lang("VAL_SEL");
								$this->addError(["{$display} $str",$item]);
								$this->ruleBroken([$item,"is_in_array",$array_to_check_in]);
							}
						}
						break;

						case 'is_in_database':
						$table  = is_array($rule_value) ? $rule_value[0] : $rule_value;
						$fields = is_array($rule_value) ? $rule_value[1] : [$item, '=', $value];

						if ($this->_db->get($table, $fields)) {
							$str = lang("VAL_EXISTS");
							$str1 = lang("VAL_DB");
							if ($this->_db->count()==0) {
								$this->addError(["{$display} $str {$display}",$item]);
								$this->ruleBroken([$item,"is_in_database",false]);

							} else {
								$this->addError([$str1,$item]);
								$this->ruleBroken([$item,"is_in_database",false]);
							}
						}
						break;

						case 'is_valid_north_american_phone':
						$numeric_only_phone = preg_replace("/[^0-9]/", "", $value); //Strip out all non-numeric characters
						$str = lang("VAL_NA_PHONE");
						if($numeric_only_phone[0] == 0 || $numeric_only_phone[0] == 1){ //It the number starts with a 0 or 1, it's not a valid North American phone number.
							$this->addError(["{$display} $str",$item]);
							$this->ruleBroken([$item,"is_valid_north_american_phone",false]);
						}
						if(strlen($numeric_only_phone) != 10){ //Valid North American phone numbers are 10 digits long
							$this->addError(["{$display} $str",$item]);
							$this->ruleBroken([$item,"is_valid_north_american_phone",false]);
						}
						break;
					}
				}
			}

		}

		return $this;
	}

	public function addError($error) {
		if (array_search($error, $this->_errors) === FALSE){
			if(is_array($error) && count($error) > 1){
				$this->_errors[] = $error[0];
			}else{
				$this->_errors[] = $error;
			}

		}
	}

	public function ruleBroken($rule){
		if (array_search($rule, $this->_rules_broken) === FALSE){
			$this->_rules_broken[] = $rule;
		}
	}

	public function display_errors() {
		$html = "<UL CLASS='bg-danger'>";

		foreach($this->_errors as $error) {
			if (is_array($error))
			$html    .= "<LI CLASS=''>{$error[0]}</LI>
			<SCRIPT>jQuery('document').ready(function(){jQuery('#{$error[1]}').parent().closest('div').addClass('has-error');});</SCRIPT>";
			else
			$html .= "<LI CLASS=''>{$error}</LI>";
		}

		$html .= "</UL>";
		return $html;
	}

	public function rulesBroken(){
		return $this->_rules_broken;
	}

	public function errors(){
		return $this->_errors;
	}

	public function passed(){
		return empty($this->_errors);
	}
}
