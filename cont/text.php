<?php

namespace Cont;

use Core\Request;
use Core\DBdriver;
use Model\Text as Model;

class Text extends Base
{
	public function __construct (Request $request) {
		parent::__construct($request);
		$this->model = new Model (DBdriver::instance());
	}
	
	public function action_index () {
		$this->title = 'List of files';
		$index = scandir(FILES_DIR.'/ready');
		$index = array_merge($index, array_diff(scandir(FILES_DIR.'/upload'), $index));
		$this->content = $this->render('list_text.html.php', ['index'=>$index]);
	}
	
	public function action_read () {
		$id = $this->request->get_elem('2');
		$page = $this->request->is_post() ? $this->request->get_post()['page'] : false;
		$this->title = 'You read '. ucfirst($id);
		$this->content = $this->render('text.html.php', ['text'=>$this->model->get_book($id, $page)]);
	}	
}