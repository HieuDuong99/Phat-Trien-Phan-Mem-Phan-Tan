<?php
require_once ROOT.'/base/AuthRequiredTemplateController.php';
require_once ROOT.'/models/Article.php';
require_once ROOT.'/helpers/FlashMessages.php';
require_once ROOT.'/helpers/library.php';

class ReviewController extends AuthRequiredTemplateController {
	public $template = 'views/review_view.php';

	public function permission_required() {
		return ["staff", "moderator"];
	}

	public function get_context() {
		$keyword = isset($_GET['keyword'])? $_GET['keyword']: '';

		$articles = new Article();
		$articles = $articles->get_all_unreviewed_articles($keyword);

		$page = isset($_GET['page'])? $_GET['page']:1;
		
		$params = [];
		$params['cn'] = $GLOBALS['cn'];

		$url =  Library::createLink("", $params);

		if ($keyword != '') {
			$params['keyword'] = $keyword;
		}
		$params['page'] = '{page}';

		$link = Library::createLink("", $params);

		$paging = Library::paging($link, $articles, $page, 5);

		$context["paging"] = $paging["html"];
		$context["articles"] = [];
		if (count($paging["data"]) >= $page) {
			$context["articles"] = $paging["data"][$page-1];
		}

		$context["msg"] = new \Plasticbrain\FlashMessages\FlashMessages();
		$context["url"] = $url;
		return $context;
	}

	public function post() {
		$article_id = isset($_GET['id'])? $_GET['id']: NULL;
		if ($article_id == NULL) {
			header("Location: ?cn=error");
		}

		$article = new Article();
		$article->get($article_id);

		$msg = new \Plasticbrain\FlashMessages\FlashMessages();

		if (isset($_POST['pass'])) {
			$rc = $article->review($this->auth->user, 0);
		}
		if (isset($_POST['no_pass'])) {
			$rc = $article->review($this->auth->user, 1);
		}

		
		if ($rc > 0) {
			if ($article->drafft) {
				$msg->warning($article->title." không qua kiểm duyệt");
			} else {
				$msg->success($article->title." đã được nộp biên tập");
			}
		} else {
			$msg->error("Chưa thể thực hiên kiểm duyệt");
		}
		header('Location: ?cn=review');
	}
}

 ?>