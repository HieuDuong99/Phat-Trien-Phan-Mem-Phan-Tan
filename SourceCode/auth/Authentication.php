<?php 
require_once ROOT.'/models/User.php';

class Authentication {
	public $user;

	public function __construct() {
		$session = isset($_SESSION['username']) && !empty($_SESSION['username']);
		$cookie = isset($_COOKIE['admin']) && !empty($_COOKIE['admin']);
		if ($session || $cookie) {
			$username = isset($_SESSION['username'])? $_SESSION['username']:$_COOKIE['admin'];
			$this->user = new User();
			$this->user->get_by_username($username);
		}
	}

	public function check_login() {
		if (isset($this->user) && isset($this->user->id)) {
			return true;
		} else {
			return false;
		}
	}

	public function login($username, $password, $remember = false) {
		if ($this->check_login()) {
			return $this->user;
		}
		$this->user = new User();
		$this->user->get_by_username($username, $password);
		$time = time();
		if ($remember) {
			$time += 60*60*24*30;
		} else {
			$time += 60*30;
		}
		$_SESSION['username'] = $this->user->username;
		setcookie('admin', $this->user->username, $time, '/', '', 0);
		return $this->user;
	}

	public function logout() {
		if ($this->check_login()) {
			setcookie('admin', '', time() - 3600, '/', '', 0);
			session_destroy();
		}
	}
}

 ?>
