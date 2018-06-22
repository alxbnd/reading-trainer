<?php

namespace Core;

class Parse implements iParse
{
	private $words;
	private $scheme;
	private $obj=[];
	private $agent;
	
	public function __construct($words, $scheme, $agent) {
		$this->words = $words;
		$this->scheme = $scheme;
		$this->agent = $agent;
	}
	
	public function run ($type) {	
		$i = 1;
		foreach ($this->words as $k=>$word) {
			if ($i < 4) $this->obj[$word] = $this->parse_mean($word);
			$i++;
		}
		
		return $this->obj;
	}
	
	public function parse_mean ($word) {
		$word = stripslashes($word);
		$path = $this->scheme['source'].'/'.$word;
		$snoopy = new Snoopy ();
		$snoopy->agent = $this->agent;
		$snoopy->fetch($path);
		$result = $snoopy->results;
		preg_match_all($this->scheme['reg_match'], $result, $prep);
		if (!$prep[0]) preg_match_all($this->scheme['reg_sec'], $result, $prep);		
		if (!$prep[0]) return str_replace($this->scheme['false_replace'], $word, $this->scheme['false_result']);		
		$prep = strip_tags($prep[0][0]);
		
		return preg_replace($this->scheme['erase'], ' ', $prep);
	}
	
	private function split_var () {
		$mass_mass = preg_split('', $mass);
	}
}