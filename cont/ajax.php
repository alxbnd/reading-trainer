<?php

namespace Cont;

use Model\Word as Model;
use Core\Request;
use Model\Validator;
use Core\DBdriver;

class Ajax extends Base 
{
	public function __construct (Request $request) {
		parent::__construct($request);
		$this->model = new Model (DBdriver::instance());
	}

	public function action_word() {
		if ($this->request->is_post()) {
			$word = false;
			foreach ($this->request->get_post() as $k=>$v) {
				$word = $k;
			}
			$word = $this->model->search_word(['word'=>$word], new Validator ($this->model->get_rules('search')));

			echo $word['mean'];
			exit;
		}
	}
	
	public function action_text() {
		if ($this->request->is_post()) {
			print_r($this->request->get_post());	
			exit;
		}
	}
	
}