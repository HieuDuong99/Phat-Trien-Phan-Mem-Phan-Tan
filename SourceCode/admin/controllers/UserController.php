<?php
require_once ROOT.'/base/AuthRequiredTemplateController.php';
require_once ROOT.'/models/User.php';
require_once ROOT.'/helpers/FlashMessages.php';
require_once ROOT.'/helpers/library.php';

class UserController extends AuthRequiredTemplateController {
	public $template = 'views/user_view.php';

	public function permission_required() {
		return ["superuser"];
	}

	public function get_context() {
		$keyword = isset($_GET['keyword'])? $_GET['keyword']: '';

		$users = new User();
		$users = $users->all($keyword);

		$page = isset($_GET['page'])? $_GET['page']:1;

		$params = [];
		$params['cn'] = $GLOBALS['cn'];

		$url =  Library::createLink("", $params);

		if ($keyword != '') {
			$params['keyword'] = $keyword;
		}
		$params['page'] = '{page}';

		$link = Library::createLink("", $params);

		$paging = Library::paging($link, $users, $page, 5);

		$context["paging"] = $paging["html"];
		$context["users"] = [];
		if (count($paging["data"]) >= $page) {
			$context["users"] = $paging["data"][$page-1];
		}

		$context["msg"] = new \Plasticbrain\FlashMessages\FlashMessages();
		$context["url"] = $url;
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

		if (is_uploaded_file($_FILES['avatar_img']['tmp_name'])) {
			$user->avatar_img = Library::uploadFiles($_FILES['avatar_img'], UPLOAD_IMG.'/avatars');
		}

		if ($user->save() > 0) {
			$msg->success("Đã tạo thành công");
			header("Location: ".$this->get_prev_url());
		} else {
			$msg->error("Chưa thể tạo người dùng");
			header("Location: ".$this->get_prev_url());
		}
	}
}

 ?>