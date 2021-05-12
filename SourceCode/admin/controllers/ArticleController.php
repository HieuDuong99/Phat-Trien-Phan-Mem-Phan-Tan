<?php
require_once ROOT.'/base/AuthRequiredTemplateController.php';
require_once ROOT.'/models/Article.php';
require_once ROOT.'/helpers/FlashMessages.php';
require_once ROOT.'/helpers/library.php';

class ArticleController extends AuthRequiredTemplateController {
	public $template = 'views/article_view.php';

	public function permission_required() {
		return ["staff"];
	}

	public function get_context() {
		$f = isset($_GET['f'])? $_GET['f']: '';
		$keyword = isset($_GET['keyword'])? $_GET['keyword']: '';

		$articles = new Article();

		switch ($f) {
			case 'unreviewed':
				$tab = "Bài viết chờ xét duyệt";
				$articles = $articles->get_all_unreviewed_articles($keyword);
				break;
			case 'published':
				$tab = "Bài viết đã xuất bản";
				$articles = $articles->get_all_published_articles($keyword);
				break;
			case 'all':
			default:
				$tab = "Tất cả";
				$articles = $articles->get_all_without_draft($keyword);
				break;
		}

		$page = isset($_GET['page'])? $_GET['page']:1;
		
		$params = [];
		$params['cn'] = $GLOBALS['cn'];
		if ($f != '') {
			$params['f'] = $f;
		}

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
		$context["f"] = $f;
		$context["tab"] = $tab;
		$context["url"] = $url;
		return $context;
	}

	public function post() {
		if (isset($_POST["delete_id"])) {
			$article = new Article();
			$article->id = $_POST["delete_id"];
			$msg = new \Plasticbrain\FlashMessages\FlashMessages();
			if ($article->delete() > 0) {
				$msg->success("Xóa thành công");
			} else {
				$msg->error("Xóa thất bại");
			}
			
			header("Location: ?cn=article");
		};
	}
}

 ?>