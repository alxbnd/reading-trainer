<?php

namespace Model;

use Core\DBdriver;

class Parse extends Base
{
	public function __construct ($db) {
		parent::__construct ($db);
		$this->table = '';
	}
	
	public function get_page ($link) {
		print_r($link);
	}
	
	private function get_scheme () {
		return [
			'reg_match'=>'',
			'mask'=>'https://$adr.$domain/$instr'
			];
	}
}