<?php
require_once ROOT.'/base/Controller.php';
require_once ROOT.'/base/trait/AuthRequiredTrait.php';
require_once ROOT.'/models/Comment.php';

class CommentController extends Controller {
	use AuthRequiredTrait;
	
	public function post() {
		$article_id = isset($_POST['article_id'])? $_POST['article_id']: "";
		$user_id = isset($_POST['user_id'])? $_POST['user_id']: "";
		$content = isset($_POST['content'])? $_POST['content'] == "true": false;

		$cmt = new Comment();
		$cmt->map($_POST);

		if ($cmt->save() > 0) {
			echo json_encode(['message' => 'success', 'status' => 1, 'comment' => ['id' => $cmt->id, 'create_time' => date_format(date_create($cmt->create_time), 'd/m/Y, H:i')]]);
		} else {
			echo json_encode(['message' => 'failed', 'status' => 0]);
		}
	}
}

 ?>