<?php
require_once ROOT.'/base/TemplateController.php';
require_once ROOT.'/models/Article.php';
require_once ROOT.'/models/Comment.php';
require_once ROOT.'/helpers/library.php';

class ArticleController extends TemplateController {
	public $template = 'views/article_view.php';

	public function get_context() {
		$article_id = isset($_GET['article_id'])? $_GET['article_id']: NULL;
		if ($article_id == NULL) {
			header("Location: ?cn=error");
		}

		$article = new Article();
		$article->get($article_id);

		if ($article->id == NULL) {
			header("Location: ?cn=error");
		}
		
		$context["liked"] = false;

		$article->viewed();
		if ($this->auth->check_login()) {
			$this->auth->user->read($article->id);
			$context["liked"] = $this->auth->user->has_like($article->id);
		}

		$cmts = new Comment();
		$cmts = $cmts->get_cmts_on_article($article->id);

		$cmt_paging = Library::paging('', $cmts, 1, 4);

		$context["cmts"] = [];
		$context["cmt_page"] = count($cmt_paging["data"]);
		if ($context["cmt_page"] > 0) {
			$context["cmts"] = $cmt_paging["data"][0];
		}

		$hot_tags = new Tag();
		$hot_tags = $hot_tags->get_hot_tags();

		$pop_articles = $article->get_popular_articles();

		$categories = new Category();
		$categories = $categories->all_active();
		
		$context["article"] = $article;
		$context["categories"] = $categories;
		$context["pop_articles"] = $pop_articles;
		$context["hot_tags"] = $hot_tags;
		return $context;
	}
}

 ?>