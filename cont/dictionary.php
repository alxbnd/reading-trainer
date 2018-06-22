<?php

namespace Cont;

use Model\Word as Model;
use Core\Request;
use Core\DBdriver;
use Model\Validator;
use Core\Exceptions\E404;

class Dictionary extends Base
{
	public function __construct (Request $request) {
		parent::__construct($request);
		$this->model = new Model (DBdriver::instance());
	}
	
	public function action_index () {
		header('Location:'.ROOT.'dictionary/list');
		exit;
	}
	
	public function action_list () {
		$this->content = $this->render('list.html.php', ['list'=>$this->model->get_list('date_add DESC')]);
	}
	
	public function action_word () {
		$word = $this->model->get_one (['word'=>$this->request->get_elem(2)]);
		if (!$word) throw new E404 ('Sorry, word "'.$this->request->get_elem(2).'" not found in the base');
		$this->title = 'word';
		$this->content = $this->render('word.html.php', ['word'=>$word]);
	}
	
	public function action_search () {
		if ($this->request->is_post()) {
			$word = $this->model->search_word($this->request->get_post(), new Validator ($this->model->get_rules('search')));
			$this->title = $word['word'];
			$this->content = $this->render('word.html.php', ['word'=>$word]);
		} else {
			$this->title = 'search word';
			$this->content = $this->render('search.html.php');
		}
	}	
	
	public function action_delete () {
		$this->model->del_word ($this->request->get_uri()[2]);
		header('Location:'.ROOT);
		exit;
	}
	
	public function action_random () {
		$rand = $this->model->get_all('word');
		$rand = $rand[mt_rand(0, count($rand) - 1)];
		$this->title = 'random word';
		$this->content = $this->render('word.html.php', ['word'=>$this->model->get_word ($rand['word'])]);
	}
	
}