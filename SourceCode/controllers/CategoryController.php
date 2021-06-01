<?php
require_once ROOT.'/base/TemplateController.php';
require_once ROOT.'/models/Article.php';
require_once ROOT.'/models/Category.php';
require_once ROOT.'/helpers/library.php';

class CategoryController extends TemplateController {
	public $template = 'views/category_view.php';

	public function get_context() {
		$category_id = isset($_GET['id'])? $_GET['id']: NULL;
		if ($category_id == NULL) {
			header("Location: ?cn=error");
		}

		$cat = new Category();
		$cat->get($category_id);

		$categories = $cat->all_active();

		$category_map = [];
		foreach ($categories as $category) {
			if (!isset($category->parent->id)) {
				$category_map[$category->id] = [];
			} else {
				if (!isset($category_map[$category->parent->id])) {
					$category_map[$category->parent->id] = [];
				}
				array_push($category_map[$category->parent->id], $category->id);
			}
		}

		$category_ids = [$cat->id];
		if (isset($category_map[$cat->id])) {
			$category_ids = array_merge($category_ids, $category_map[$cat->id]);
		}

		$model = new Article();
		$articles = $model->get_all_published_active_articles($category_ids);

		$hot_articles = $model->get_hot_articles($category_ids);

		$pop_articles = $model->get_popular_articles($category_ids);

		$page = isset($_GET['page'])? $_GET['page']:1;

		$params = [];
		$params['cn'] = $GLOBALS['cn'];
		$params['id'] = $category_id;

		$url =  Library::createLink("", $params);

		$params['page'] = '{page}';

		$link = Library::createLink("", $params);

		$paging = Library::paging($link, $articles, $page, 10);

		$context["paging"] = $paging["html"];
		$context["articles"] = [];
		if (count($paging["data"]) >= $page) {
			$context["articles"] = $paging["data"][$page-1];
		}
		
		$context["categories"] = $categories;
		$context["cat"] = $cat;
		$context["pop_articles"] = $pop_articles;
		$context["hot_articles"] = $hot_articles;
		return $context;
	}
}

 ?>