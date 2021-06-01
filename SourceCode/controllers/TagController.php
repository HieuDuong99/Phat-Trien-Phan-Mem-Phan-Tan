<?php
require_once ROOT.'/base/TemplateController.php';
require_once ROOT.'/models/Article.php';
require_once ROOT.'/models/Category.php';
require_once ROOT.'/models/Tag.php';
require_once ROOT.'/helpers/library.php';

class TagController extends TemplateController {
	public $template = 'views/tag_view.php';

	public function get_context() {
		$tag_id = isset($_GET['id'])? $_GET['id']:'';
		if (empty($tag_id)) {
			header("Location: ?cn=error");
		}

		$tag = new Tag();
		$tag = $tag->getByIds($tag_id);
		if (count($tag) == 0) {
			header("Location: ?cn=error");
		}

		$tag = $tag[0];

		$categories = new Category();
		$categories = $categories->all_active();

		$model = new Article();
		$articles = $model->get_all_published_active_articles_by_tag($tag_id);

		$page = isset($_GET['page'])? $_GET['page']:1;

		$params = [];
		$params['cn'] = $GLOBALS['cn'];
		$params['id'] = $tag_id;
		$params['page'] = '{page}';

		$link = Library::createLink("", $params);

		$paging = Library::paging($link, $articles, $page, 10);

		$context["paging"] = $paging["html"];
		$context["articles"] = [];
		if (count($paging["data"]) >= $page) {
			$context["articles"] = $paging["data"][$page-1];
		}
		
		$context["categories"] = $categories;
		$context["tag"] = $tag;
		return $context;
	}
}

 ?>