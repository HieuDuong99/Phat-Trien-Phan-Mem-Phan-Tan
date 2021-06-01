<?php
require_once ROOT.'/base/TemplateController.php';
require_once ROOT.'/models/Category.php';
require_once ROOT.'/models/User.php';
require_once ROOT.'/helpers/FlashMessages.php';
require_once ROOT.'/auth/Authentication.php';

class RegisterController extends TemplateController {
	public $template = 'views/register_view.php';

	public function get_context() {
		$cat = new Category();
		$categories = $cat->all_active();
		
		$context["categories"] = $categories;
		$context["msg"] = new \Plasticbrain\FlashMessages\FlashMessages();
		return $context;
	}

	public function post() {
		$msg = new \Plasticbrain\FlashMessages\FlashMessages();

		if (!isset($_POST['username']) || empty($_POST['username'])) {
			$msg->error('Username không được chống');
		}

		if (!isset($_POST['password']) || empty($_POST['password'])) {
			$msg->error('Mật khẩu không được chống');
		}

		if (!isset($_POST['full_name']) || empty($_POST['full_name'])) {
			$msg->error('Tên không được chống');
		}

		if (!isset($_POST['email']) || empty($_POST['email'])) {
			$msg->error('Email không được chống');
		}

		if ($_POST['password'] != $_POST['cf_password']) {
			$msg->error('Mật khẩu không giống nhau');
		}

		if ($msg->hasErrors()) {
			$this->get();
			return;
		}

		$data = $_POST;

		if (!isset($data['perms'])) {
			$data['perms'] = [];
		}

		$user = new User();
		$user->map($data);

		if ($user->save() > 0) {
			$model = new Authentication();
			$user = $model->login($user->username, $user->password, true);
			header("Location: /knn");
		} else {
			$msg->error("Chưa thể tạo người dùng");
			header("Location: ".$this->get_prev_url());
		}
	}
}

 ?>