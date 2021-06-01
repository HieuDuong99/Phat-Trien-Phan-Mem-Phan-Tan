<?php
require_once ROOT.'/base/Controller.php';
require_once ROOT.'/models/Comment.php';
require_once ROOT.'/helpers/library.php';

class AjaxArticleCommentController extends Controller {
	public function post() {
		$article_id = isset($_POST['article_id'])? $_POST['article_id']: NULL;
		$page = isset($_POST['page'])? $_POST['page']:1;

		if (!isset($article_id)) {
			return;
		}

		$model = new Comment();
		$data = $model->get_cmts_on_article($article_id);

		$cmt_paging = Library::paging('', $data, $page, 4);

		$cmts = [];
		$cmt_page = count($cmt_paging["data"]);
		if ($cmt_page >= $page) {
			$cmts = $cmt_paging["data"][$page - 1];
		}

		require_once 'views/ajax_article_comment.php';
	}
}

 ?>