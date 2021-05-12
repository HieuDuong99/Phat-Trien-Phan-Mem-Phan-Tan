<?php
require_once ROOT.'/base/AuthRequiredController.php';
require_once ROOT.'/models/Article.php';
require_once ROOT.'/helpers/FlashMessages.php';

class DeleteArticleController extends AuthRequiredController {
	public function permission_required() {
		return ["staff", "author"];
	}

	public function post() {
		if (isset($_POST["delete_id"])) {
			$article = new Article();
			$article->get($_POST["delete_id"]);
			$msg = new \Plasticbrain\FlashMessages\FlashMessages();
			if ($article->author->id = $this->auth->user->id) {
				if ($article->delete() > 0) {
					$msg->success("Xóa thành công");
				} else {
					$msg->error("Xóa thất bại");
				}
			} else {
				$msg->error("Bạn không có quyền xóa bài viết này");
			}
			header("Location: ".$this->get_prev_url());
		};
	}
}

 ?>