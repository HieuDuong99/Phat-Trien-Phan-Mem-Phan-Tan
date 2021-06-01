<?php
require_once ROOT.'/base/TemplateController.php';
require_once ROOT.'/models/Article.php';
require_once ROOT.'/models/Category.php';
require_once ROOT.'/helpers/library.php';

class SearchController extends TemplateController {
	public $template = 'views/search_view.php';

	public function get_context() {
		$keyword = isset($_GET['keyword'])? $_GET['keyword']:'';

		$categories = new Category();
		$categories = $categories->all_active();

		$model = new Article();
		$articles = $model->get_all_published_active_articles([], $keyword);

		$page = isset($_GET['page'])? $_GET['page']:1;

		$params = [];
		$params['cn'] = $GLOBALS['cn'];
		$params['keyword'] = $keyword;

		$params['page'] = '{page}';

		$link = Library::createLink("", $params);

		$paging = Library::paging($link, $articles, $page, 10);

		$context["paging"] = $paging["html"];
		$context["articles"] = [];
		if (count($paging["data"]) >= $page) {
			$context["articles"] = $paging["data"][$page-1];
		}
		
		$context["categories"] = $categories;
		$context["keyword"] = $keyword;
		return $context;
	}
}

 ?>