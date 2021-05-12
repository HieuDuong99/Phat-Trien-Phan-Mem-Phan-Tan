<?php
require_once ROOT.'/base/ModelTemplateController.php';
require_once ROOT.'/base/trait/UserPassTestTrait.php';
require_once ROOT.'/models/Article.php';
require_once ROOT.'/models/Category.php';
require_once ROOT.'/models/Tag.php';
require_once ROOT.'/helpers/FlashMessages.php';
require_once ROOT.'/helpers/library.php';

class UpdateArticleController extends ModelTemplateController {
	use UserPassTestTrait;

	public $template = 'views/update_article_view.php';
	public $model = 'Article';

	public function permission_required() {
		return ["staff", "author"];
	}

	public function test_user() {
		$this->get_item();
		return $this->item->author->id == $this->auth->user->id;
	}

	public function get_context() {
		$article_id = isset($_GET['id'])? $_GET['id']: NULL;
		if ($article_id == NULL) {
			header("Location: ?cn=error");
		}

		$article = $this->item;

		$categories = new Category();
		$categories = $categories->all();
		$tags = new Tag();
		$tags = $tags->all();

		$context["article"] = $article;
		$context["categories"] = $categories;
		$context["tags"] = $tags;
		$context["msg"] = new \Plasticbrain\FlashMessages\FlashMessages();
		return $context;
	}

	public function post() {
		$article_id = isset($_GET['id'])? $_GET['id']: NULL;
		if ($article_id == NULL) {
			header("Location: ?cn=error");
		}

		$data = $_POST;

		$msg = new \Plasticbrain\FlashMessages\FlashMessages();

		if (!isset($_POST['title']) || empty($_POST['title'])) {
			$msg->error('Tiêu đề không được chống');
		}

		if (!isset($_POST['description']) || empty($_POST['description'])) {
			$msg->error('Tóm tắt không được chống');
		}

		if (!isset($_POST['content']) || empty(strip_tags($_POST['content']))) {
			$msg->error('Bài báo phải có nội dung');
		}

		if (!isset($_POST['category_id']) || empty($_POST['category_id'])) {
			$msg->error('Bài báo phải có danh mục');
		}

		if ($msg->hasErrors()) {
			$this->get();
			return;
		}

		if (isset($data["tags"])) {
			foreach ($data["tags"] as $key => $val) {
				if (intval($val) == 0) {
					$tag = new Tag();
					$tag->name = $val;
					if ($tag->save() > 0) {
						$data["tags"][$key] = $tag->id;
					} else {
						header("Location: ?cn=error");
					}
				}
			}
			$data["tag_ids"] = join(",", $data["tags"]);
		}

		$article = $this->item;
		$article->map($data);
		
		if (is_uploaded_file($_FILES['new_image']['tmp_name'])) {
			if (isset($article->image) && !empty($article->image)) {
				Library::deleteFiles($article->image, UPLOAD_IMG);
			}
			$article->image = Library::uploadFiles($_FILES['new_image'], UPLOAD_IMG);
		}

		$msg = new \Plasticbrain\FlashMessages\FlashMessages();
		if ($article->update() > 0) {
			$msg->success("Đã lưu thành công");
		} else {
			$msg->error("Chưa thể lưu thay đổi");
		}

		header("Location: ?cn=article_preview&article_id=".$article_id);
	}
}

 ?>