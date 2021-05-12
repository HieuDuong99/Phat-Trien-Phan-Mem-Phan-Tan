<?php
require_once ROOT.'/base/AuthRequiredTemplateController.php';

class ErrorController extends AuthRequiredTemplateController {
	public $template = 'views/error_view.php';

	public function get_context() {
		$m = isset($_GET['info'])? $_GET['info']: 'error';
		if ($m == "error") {
			$context["error_title"] = "Có lỗi xảy ra!";
			$context["error_info"] = "Có lỗi xảy ra khi xử lí phía server! Xin thử lại sau!";
		}
		if ($m == "no_perm") {
			$context["error_title"] = "Bạn không có quyền vào trang này!";
			$context["error_info"] = "";
		}
		return $context;
	}
}

 ?>