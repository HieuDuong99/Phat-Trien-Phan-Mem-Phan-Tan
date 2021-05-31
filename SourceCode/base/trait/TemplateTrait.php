<?php 
trait TemplateTrait {
	public $template;

	public function get() {
		if (!isset($this->template)) {
			echo "No template found";
			return;
		}
		$context = $this->get_context();
		foreach ($context as $key => $value) {
			$$key = $value;
		}
		require_once $this->template;
	}

	public function get_context() {
		$context = [];
		return $context;
	}
}
 ?>