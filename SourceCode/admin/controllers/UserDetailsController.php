<?php
require_once ROOT.'/base/ModelTemplateController.php';
require_once ROOT.'/base/trait/AuthRequiredTrait.php';
require_once ROOT.'/base/trait/ModelTemplateTrait.php';
require_once ROOT.'/models/User.php';
require_once ROOT.'/helpers/FlashMessages.php';
require_once ROOT.'/helpers/library.php';

class UserDetailsController extends ModelTemplateController {
	use AuthRequiredTrait;

	public $template = 'views/user_details_view.php';
	public $model = 'User';

	public function permission_required() {
		return "superuser";
	}

	public function get_context() {
		$context["msg"] = new \Plasticbrain\FlashMessages\FlashMessages();
		return $context;
	}

	public function post() {
		$msg = new \Plasticbrain\FlashMessages\FlashMessages();

		if (!isset($_POST['full_name']) || empty($_POST['full_name'])) {
			$msg->error('Tên không được chống');
		}

		if (!isset($_POST['email']) || empty($_POST['email'])) {
			$msg->error('Email không được chống');
		}

		if ($msg->hasErrors()) {
			$this->get();
			return;
		}

		$data = $_POST;

		if (!isset($data['perms'])) {
			$data['perms'] = [];
		}

		$this->item->map($data);

		if (is_uploaded_file($_FILES['avatar_img']['tmp_name'])) {
			if (isset($this->item->avatar_img) && !empty($this->item->avatar_img)) {
				Library::deleteFiles($this->item->avatar_img, UPLOAD_IMG.'/avatars');
			}
			$this->item->avatar_img = Library::uploadFiles($_FILES['avatar_img'], UPLOAD_IMG.'/avatars');
		}

		if ($this->item->update() > 0) {
			$msg->success("Đã lưu thành công");
			header("Location: ".$this->get_prev_url());
		} else {
			$msg->error("Chưa thể lưu thay đổi");
			header("Location: ".$this->get_prev_url());
		}
	}
}

 ?>