<?php 
trait AuthRequiredTrait {
	public $perm='user';
	
	function login_redirect_url() {
		return '?cn=login';
	}

	function user_failed_redirect_url() {
		return '?cn=error&info=no_perm';
	}

	function permission_required() {
		return $this->perm;
	}

	function set_perm() {
		$this->perm = $this->permission_required();
	}

	function has_perm() {
		if (is_array($this->perm)) {
			$test = true;
			foreach ($this->perm as $value) {
				$test = $test && $this->auth->user->has_perm($value);
			}
			return $test;
		}
		return $this->auth->user->has_perm($this->perm);
	}

	function authenticate_user() {
		if (!$this->auth->check_login()) {
			header("Location: ".$this->login_redirect_url());
		}
		$this->set_perm();
		if (!$this->has_perm()) {
			header("Location: ".$this->user_failed_redirect_url());
		}
	}

	function run() {
		$this->authenticate_user();
		parent::run();
	}
}
 ?>