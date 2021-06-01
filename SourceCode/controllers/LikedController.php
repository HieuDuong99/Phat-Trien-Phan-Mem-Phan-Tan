
<?php
require_once ROOT.'/base/AuthRequiredTemplateController.php';
require_once ROOT.'/models/Article.php';
require_once ROOT.'/helpers/library.php';

class LikedController extends AuthRequiredTemplateController {
	public $template = 'views/like_view.php';

	public function login_redirect_url() {
		return '?cn=home';
	}

	public function get_context() {
		$page = isset($_GET['page'])? $_GET['page']:1;

		$model = new Article();
		$articles = $model->get_user_like($this->auth->user->id);

		$params = [];
		$params['cn'] = $GLOBALS['cn'];

		$url =  Library::createLink("", $params);

		$params['page'] = '{page}';

		$link = Library::createLink("", $params);

		$paging = Library::paging($link, $articles, $page, 5);

		$context["paging"] = $paging["html"];
		$context["articles"] = [];
		if (count($paging["data"]) >= $page) {
			$context["articles"] = $paging["data"][$page-1];
		}

		return $context;
	}
}

 ?>