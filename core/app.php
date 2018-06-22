<?php

namespace Core;

use Core\Exceptions\E404;
use Core\Exceptions\Ebd;
use Cont\Dictionary;

class App
{
	public $request;
	private $controller;
	private $action;
	private $admin = false;
	
	public function __construct () {
		$this->init_request();
		$this->in_uri();
	}
	
	public function run () {
		try {
			$controller = new $this->controller($this->request);
			$action = $this->action;
			$controller->$action();
		} catch (E404 $e) {
			$this->run_error($e);
		} catch (Ebd $e) {
			$this->run_error($e);
		} catch (\PDOException $e) {
			$this->run_error($e);
		} finally {	
			if ($this->admin) {
				echo '<pre>';
				var_dump($e);
				echo '</pre>';
			}
			$controller->response();	
		}
	}
	
	private function run_error ($e) {	
		$e->index();
		$e->response ();
		exit;
	}
	
	private function init_request() {
		$this->request = new Request($_GET, $_POST, $_FILES, $_SERVER);
	}
	
	private function in_uri () {
		$arg = $this->request->get_uri();
		$this->set_id_uri($arg);
		try {
			$this->controller = $this->get_controller($arg);
		} catch (E404 $e) {
			$this->run_error($e);
		}
		$this->action = $this->get_action($arg);
	}
	
	private function get_controller (array $uri) {
		if((isset($uri[0])) && $uri[0] === 'admin') {
			$this->admin = true;
			unset($uri[0]);
		}
		$controller = $uri[0] ? $uri[0] : DEFAULT_CONTROLLER;
		$controller = $this->admin ? 'admin/'.ucfirst($controller) : $controller;
		if (!file_exists("cont/$controller".'.php')) throw new E404("wrong controller $controller");
		
		return 'cont\\'.ucfirst($controller);
	}
	
	private function get_action (array $uri) {
		$action = $uri[1] ?? DEFAULT_ACTION;	

		return $action ? 'action_'.$action : false;
	}
	
	private function set_id_uri (array $uri) {
		if (isset($uri[3])) $this->request->get['id'] = $uri[3];
	}
}
