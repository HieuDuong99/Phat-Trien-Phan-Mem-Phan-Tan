<?php 
require_once ROOT.'/base/trait/TemplateTrait.php';

trait ModelTemplateTrait {
	use TemplateTrait;
	public $model;
	public $item;

	public function run() {
		$this->get_item();
		parent::run();
	}

	public function item($prop) {
		if (isset($this->item->$prop)) {
			return $this->item->$prop;
		}
	}

	public function get_item() {
		if (isset($this->model)) {
			if (!isset($this->item)) {
				$id = isset($_GET['id'])? $_GET['id']: NULL;
				$this->item = new $this->model();
				if ($id != NULL) {
					$this->item->get($id);
				}
			}
		} else {
			throw new Exception('No model specified');
		}
	}

	// public function get() {
	// 	if (!isset($this->template)) {
	// 		echo "No template found";
	// 		return;
	// 	}
	// 	$context = $this->get_context();
	// 	require_once $this->template;
	// }
}
 ?>