<?php

namespace Model;

use Core\Text as Prepare;
use Core\DBdriver;
use Core\Parse;

class Text extends Base
{
	private $words=[];
	private $model;
	private $flag;
	
	public function __construct ($db) {
		parent::__construct ($db);
		$this->table = 'texts';
		$this->model = new Word ($this->db);
	}
	
	public function get_book ($id1, $page) {
		$id = FILES_DIR.'/ready/'.$id1;
		if (!is_readable($id)) {
			$proc = new Prepare();
			$proc->book_processing($id1);
		}
		$page = $page > 0 ? $page - 1 : $page;
		$str = wordwrap(file_get_contents($id), COUNT_SYMB, '--///--');
		$str = explode('--///--', $str);
		$num = count($str);
		$str = $page ? $str[$page] : $str[0];
		$this->get_means($this->get_mass_words($str));
		$str = $this->text_span($str) ;
			
		return  ['text'=>$str, 'words'=>$this->words, 'pages'=>['num_act'=>$page,'num'=>$num]];
	}
	
	public function get_words (array $words) {
		$obj = [];
		$this->get_means($words);
		foreach ($this->words as $k=>$v) {
			$obj['word'] = $k;
			$obj['mean'] = $v;
		}
		
		return $obj;
	}
	
	private function text_span ($text) {
		$mass = str_split($text);
		$str = [];
		$match = 0;
		$teg = 0;
		foreach ($mass as $k=>$v) {
			$k = (preg_match('/[<\/p>]/', $v));
			if (($k === 0) || ($k != 0 && $teg === 0)) {
				if((preg_match('/[A-Za-z\']+/', $v) === 0) && ($match === 1)) {
					$v = '</span>'.$v;
					$match = 0;
				} elseif((preg_match('/[A-Za-z\']+/', $v) != 0) && ($match === 0)) {
					$v = '<span class="word">'.$v;
					$match = 1;
				}
			}
			$teg = $k;
			$str[] = $v;		
		}
		$str = implode($str);

		return $str;
	}
		
	private function get_mass_words ($text) {
		$text = str_ireplace($this->get_mask_symb('text'), ' ', (strtolower($text)));
		$prem = str_word_count($text, 1, '\'’'); 		
		$prem = array_unique($prem);
		foreach ($prem as $k=>$v) {
			$prem[$k] = addslashes($v);
		}
		return $prem;
	}
	
	private function parse_mean ($words) {
		$parse = new Parse ($words, $this->get_scheme('mean'), AGENT_SNOOPY);
		$words_parse = [];
		$mass = $parse->run('mean');
		foreach ($mass as $k=>$v) {
			$words_parse[] = ['word'=>$k, 'mean'=>$v];
		}
		$this->words = array_merge($this->words, $mass);
		
		return $words_parse;
	}
	
	private function get_means ($words) {
		$mean_db = $this->model->get_fields('mean', 'word', $words);
		$base_fields = [];
		foreach ($mean_db as $mean) {
			$base_fields[] = $mean['word'];
			$this->words[$mean['word']] = $mean['mean'];
		}
		$words = array_diff($words, $base_fields);
		if (count($words) > 0) {
			$this->model->new_words ($this->parse_mean ($words));
		}
	}
	
	private function mean_processing ($text) {
		$lines = preg_split('/\.\s+\d+\./', $text);
		
		return $lines;
	}

	private function get_mask_symb ($type) {
		if ($type === 'text') return ['<p>', '</p>', '—', '…', '“', '”', '-', 'xxx'];
	}
	
	public function get_scheme (String $type) {
		return [
			'source'=>'https://www.thefreedictionary.com',
			'reg_match'=>'#<section data-src="rHouse">(.+?)</section>#',
			'reg_sec'=>'#<section data-src="hm">(.+?)</section>#',
			'false_result'=>'<a href="'.ROOT.'dictionary/del/#word#">delete this word</a> <a href="'.ROOT.'dictionary/edit/#word#">edit this word</a>',
			'false_replace'=>'#word#',
			'erase'=>'/\[(.+)\]/'		
			];
	}

}