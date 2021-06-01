<?php
require_once ROOT.'/base/Controller.php';
require_once ROOT.'/base/trait/AuthRequiredTrait.php';

class LikeController extends Controller {
	use AuthRequiredTrait;
	
	public function post() {
		$article_id = isset($_POST['article_id'])? $_POST['article_id']: "";

		if ($this->auth->user->like($article_id) > 0) {
			echo json_encode(['message' => 'success', 'status' => 1]);
		} else {
			echo json_encode(['message' => 'failed', 'status' => 0]);
		}
	}
}

 ?>