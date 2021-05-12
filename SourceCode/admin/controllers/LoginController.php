<?php
require_once ROOT.'/auth/Authentication.php';
require_once ROOT.'/base/TemplateController.php';

class LoginController extends TemplateController {
	public $template = 'views/login_view.php';

	public function permission_required() {
		return ["staff"];
	}

	public function get_context() {
		$context = parent::get_context();
		$m = isset($_GET['m'])? $_GET['m']: 'index';

		switch ($m) {
			case 'logout':
				return $this->logout();

			case 'index':
			default:
				$auth = new Authentication();
				if ($auth->check_login()) {
					header("Location: ?cn=home");
				}
		}

		return $context;
	}

	public function post() {
		$username = isset($_POST['username'])? $_POST['username']: "";
		$password = isset($_POST['password'])? $_POST['password']: "";
		$remember = isset($_POST['remember'])? $_POST['remember'] == "true": false;

		if (!empty($username) && !empty($password)) {
			$model = new Authentication();
			$user = $model->login($username, $password, $remember);
			if (isset($user) && isset($user->id)) {
				echo json_encode(['message' => 'success', 'status' => 1]);
			} else {
				echo json_encode(['message' => 'Tên đăng nhập hoặc mật khẩu sai', 'status' => 0]);
			}
		} else {
			echo json_encode(['message' => 'Tên đăng nhập và mật khẩu trống', 'status' => 0]);
		}
	}

	public function logout() {
		$model = new Authentication();
		$user = $model->logout();
		header("Location: ".$this->get_prev_url());
	}
}

 ?>