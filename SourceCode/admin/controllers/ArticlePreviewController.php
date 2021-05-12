<?php
require_once ROOT.'/base/AuthRequiredTemplateController.php';
require_once ROOT.'/models/Article.php';
require_once ROOT.'/helpers/FlashMessages.php';

class ArticlePreviewController extends AuthRequiredTemplateController {
	public $template = 'views/article_preview_view.php';

	public function permission_required() {
		return ["staff"];
	}

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
		
		$context["article"] = $article;
		$context["msg"] = new \Plasticbrain\FlashMessages\FlashMessages();

		return $context;
	}
}

 ?>