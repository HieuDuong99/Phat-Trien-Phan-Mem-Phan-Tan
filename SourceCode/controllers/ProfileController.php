
<?php
require_once ROOT.'/base/AuthRequiredTemplateController.php';
require_once ROOT.'/helpers/FlashMessages.php';
require_once ROOT.'/auth/Authentication.php';
require_once ROOT.'/helpers/library.php';

class ProfileController extends AuthRequiredTemplateController {
	public $template = 'views/profile_view.php';

	public function login_redirect_url() {
		return '?cn=home';
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

		$this->auth->user->map($data);

		if (is_uploaded_file($_FILES['avatar_img']['tmp_name'])) {
			if (isset($this->auth->user->avatar_img) && !empty($this->auth->user->avatar_img)) {
				Library::deleteFiles($this->auth->user->avatar_img, UPLOAD_IMG.'/avatars');
			}
			$this->auth->user->avatar_img = Library::uploadFiles($_FILES['avatar_img'], UPLOAD_IMG.'/avatars');
		}

		if ($this->auth->user->update() > 0) {
			$msg->success("Đã lưu thành công");
			header("Location: ".$this->get_prev_url());
		} else {
			$msg->error("Chưa thể lưu thay đổi");
			header("Location: ".$this->get_prev_url());
		}
	}
}

 ?>