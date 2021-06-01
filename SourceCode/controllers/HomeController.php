<?php 
require_once ROOT.'/base/TemplateController.php';
require_once ROOT.'/models/Category.php';
require_once ROOT.'/models/Article.php';
require_once ROOT.'/models/Tag.php';

class HomeController extends TemplateController {
	public $template = 'views/home_view.php';

	public function get_context() {
		$categories = new Category();
		$categories = $categories->all_active();

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

		$model = new Article();
		$articles = $model->get_all_published_active_articles();

		$article_map = [];
		foreach ($category_map as $main => $subs) {
			$article_map[$main] = [];
			foreach ($articles as $article) {
				if ($article->category->id == $main || in_array($article->category->id, $subs)) {
					array_push($article_map[$main], $article);
				}
			}
		}

		$hot_articles = $model->get_hot_articles();

		$pop_articles = $model->get_popular_articles();

		$hot_tags = new Tag();
		$hot_tags = $hot_tags->get_hot_tags();

		$context["categories"] = $categories;
		$context["articles"] = $articles;
		$context["hot_articles"] = $hot_articles;
		$context["pop_articles"] = $pop_articles;
		$context["hot_tags"] = $hot_tags;
		$context["article_map"] = $article_map;
		return $context;
	}
}
 ?>