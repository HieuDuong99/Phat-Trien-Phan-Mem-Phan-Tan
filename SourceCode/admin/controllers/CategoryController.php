<?php
require_once ROOT.'/base/AuthRequiredTemplateController.php';
require_once ROOT.'/models/Category.php';
require_once ROOT.'/helpers/FlashMessages.php';
require_once ROOT.'/helpers/library.php';

class CategoryController extends AuthRequiredTemplateController {
	public $template = 'views/category_view.php';

	public function permission_required() {
		return ["staff"];
	}

	public function get_context() {
		$keyword = isset($_GET['keyword'])? $_GET['keyword']: '';

		$categories = new Category();
		$categories = $categories->all($keyword);

		$page = isset($_GET['page'])? $_GET['page']:1;

		$params = [];
		$params['cn'] = $GLOBALS['cn'];

		$url =  Library::createLink("", $params);

		if ($keyword != '') {
			$params['keyword'] = $keyword;
		}
		$params['page'] = '{page}';

		$link = Library::createLink("", $params);

		$paging = Library::paging($link, $categories, $page, 5);

		$context["paging"] = $paging["html"];
		$context["categories"] = [];
		if (count($paging["data"]) >= $page) {
			$context["categories"] = $paging["data"][$page-1];
		}

		$context["msg"] = new \Plasticbrain\FlashMessages\FlashMessages();
		$context["url"] = $url;
		return $context;
	}
}

 ?>