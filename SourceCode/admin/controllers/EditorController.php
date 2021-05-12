<?php
require_once ROOT.'/base/AuthRequiredTemplateController.php';
require_once ROOT.'/models/Article.php';
require_once ROOT.'/helpers/FlashMessages.php';

class EditorController extends AuthRequiredTemplateController {
	public $template = 'views/editor_view.php';

	public function permission_required() {
		return ["staff", "editor"];
	}

	public function get_context() {
		$articles = new Article();
		$articles = $articles->get_all_pass_articles();
		$context["articles"] = $articles;
		$context["msg"] = new \Plasticbrain\FlashMessages\FlashMessages();
		return $context;
	}

	public function post() {
		$msg = new \Plasticbrain\FlashMessages\FlashMessages();
		if (isset($_POST['articles'])) {
			$model = new Article();
			
			if ($model->publish(join(",",$_POST['articles']),$this->auth->user->id) > 0) {
				$msg->success("Đã xuất bản thành công");
			} else {
				$msg->error("Chưa thể xuất bản");
			}
		} else {
			$msg->error("Chưa có bài báo nào được chọn");
		}
		header("Location: ".$this->get_prev_url());
	}
}

 ?>