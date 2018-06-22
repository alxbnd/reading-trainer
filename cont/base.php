<?php

namespace Cont;

use Core\Request;
use Core\Exceptions\E404;

abstract class Base
{
	protected $title;
	protected $content;
	protected $request;
	protected $model;
	
	public function __construct (Request $request) {
		$this->request = $request;
	}
	
	public function response () {
		echo $this->render ('base.html.php',
						[
							'title'=>$this->title, 'menu'=>$this->render('menu.html.php'), 
							'content'=>$this->content
						]);
	}
	
	protected function render ($tmp, array $vars = []) {
		ob_start();
		extract($vars);

		include_once __DIR__.'/../view/' . $tmp;

		return ob_get_clean();
	}
	
	public function __call ($name, $params) {
		$params = implode (' / ', $params);
		throw new E404 ("function $name was called with parametrs $params");
	}
	
}