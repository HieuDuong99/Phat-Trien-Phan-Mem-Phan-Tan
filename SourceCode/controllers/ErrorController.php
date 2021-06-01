<?php 
require_once ROOT.'/base/TemplateController.php';
require_once ROOT.'/models/Category.php';

class ErrorController extends TemplateController {
	public $template = "views/error_view.php";

	public function get_context() {
		$categories = new Category();
		$categories = $categories->all_active();

		$context["categories"] = $categories;
		return $context;
	}
}
 ?>