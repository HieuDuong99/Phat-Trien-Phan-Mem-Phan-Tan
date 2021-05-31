<?php 
require_once ROOT.'/auth/Authentication.php';

class Controller {
	public $auth;
	
	public function __construct() {
		$this->auth = new Authentication();
		$this->run();
	}

	public function run() {
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$this->post();
		}
		if ($_SERVER['REQUEST_METHOD'] == "GET") {
			$this->get();
		}
	}

	public function post() {
		header("HTTP/1.1 403 Forbidden" );
	}

	public function get() {
		header("HTTP/1.1 403 Forbidden" );
	}

	public function get_url() {
		return $_SERVER['REQUEST_URI'];
	}

	public function get_prev_url() {
		return $_SERVER['HTTP_REFERER'];
	}
}

 ?>