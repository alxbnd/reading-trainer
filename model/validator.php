<?php

namespace Model;

use Core\ArrayHelper;

class Validator implements iValidator
{
	private $rules;
	private $errors = [];
	private $ready = [];
	
	public function __construct (array $rules) {
		$this->rules = $rules;
	}
	
	public function run (array $fields) {
		$pass = [];
		foreach ($fields as $k=>$v) {
			$v = addslashes($v);
			$value = in_array($k, $this->rules['fields']) ? trim(strip_tags($v)) : false;
			if (in_array($k, $this->rules['required']) && $value == '') $this->errors[$k] = 'empty';
			if (isset($this->rules['string']) && !is_string($value) && in_array($k, $this->rules['string'])) $this->errors[$k] = 'not_string';
			if (isset($this->rules['identic']) && in_array($k, $this->rules['identic'])) $pass [] = $v;
			
			if (!$this->errors) $this->ready[$k] = $value;
		}
		if ($pass) {
			if ($pass [0] != $pass[1]) $this->errors['pass_ident'] = 'different';
		}
		
		return $this->errors ? $this->errors : false;
	}
	
	public function get_clean () {
		return $this->ready;
	}
	
	public function check (array $input, array $true) {
		$resp = [];
		foreach ($input as $k=>$v) {
			$valid = ArrayHelper::get($true, $k, false);
			if ($valid) {
				$resp[$k] = $valid === $v;
			}
		}
		return $resp;
	}
}