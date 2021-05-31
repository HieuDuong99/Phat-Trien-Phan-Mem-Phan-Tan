<?php 
require_once ROOT.'/base/trait/AuthRequiredTrait.php';

trait UserPassTestTrait {
	use AuthRequiredTrait;

	function test_user() {
		return true;
	}

	function run() {
		$this->authenticate_user();
		if (!$this->test_user()) {
			header("Location: ".$this->user_failed_redirect_url());
		}
		parent::run();
	}
}
 ?>