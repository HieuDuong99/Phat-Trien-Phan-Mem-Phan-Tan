<?php
require_once ROOT.'/base/AuthRequiredTemplateController.php';
require_once ROOT.'/models/Article.php';
require_once ROOT.'/models/Comment.php';
require_once ROOT.'/models/User.php';

class HomeController extends AuthRequiredTemplateController {
	public $template = "views/home_view.php";

	public function permission_required() {
		return ["staff"];
	}

	public function get_context() {
		$article = new Article();
		$cmt = new Comment();
		$user = new User();

		$context['publish_count'] = $article->count_published_acticles();
		$context['cmt_count'] = $cmt->count_recent_cmt();
		$context['user_count'] = $user->count_new_user();
		return $context;
	}
}

 ?>