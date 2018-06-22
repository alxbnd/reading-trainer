<?php

namespace Model;

use Core\DBdriver;

class Word extends Base
{	
	public function __construct ($db) {
		parent:: __construct($db);		
		$this->table = 'word';
	}
	
	public function search_word ($word, iValidator $validator) {	
		if (!$err = $validator->run($word)) {
			$result = $this->get_one($validator->get_clean ());
			if (!$result) {
				$result = new Text(DBdriver::instance());
				$result = $result->get_words([($validator->get_clean ()['word'])]);
			}
			
			return $result;	
		} 
		print_r($err);
		exit;		
	}
	
	public function get_list ($sort) {
		$list = [];
		foreach ($this->get_all_sort('word', $sort) as $mass) {
			foreach ($mass as $k=>$v) {
				$v = stripslashes($v);
				$list[] = $v;
			}
		}
		return $list;
	}
	
	public function get_word (String $word) {
		$word = $this->db->query("SELECT * FROM {$this->table} WHERE word=:word", ['word'=>$word]);

		return $word[0] ?? false;
	}
	
	public function get_fields (String $cell, String $par, array $obj) {
		$str = '\'';
		$str .= implode('\', \'', $obj).'\'';
		return $this->db->query("SELECT $cell, $par FROM {$this->table} WHERE $par IN ($str)");
	}
	
	public function get_rules (string $str) {
		switch ($str) {
			case "search": 
				return [
					'fields'=>['word'],
					'required' =>['word'],
					'string'=>['word']
					];
				break;
		}
	}
	
	public function get_scheme (String $type) {
		return [
			'source'=>'https://www.thefreedictionary.com',
			'reg_match'=>'#<section data-src="rHouse">(.+?)</section>#',
			'reg_sec'=>'#<section data-src="hm">(.+?)</section>#',
			'erase'=>'/\[(.+)\]/'		
			];
	}
}