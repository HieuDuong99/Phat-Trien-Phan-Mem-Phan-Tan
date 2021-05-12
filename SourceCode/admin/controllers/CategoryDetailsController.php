<?php
require_once ROOT.'/base/ModelTemplateController.php';
require_once ROOT.'/base/trait/AuthRequiredTrait.php';
require_once ROOT.'/base/trait/ModelTemplateTrait.php';
require_once ROOT.'/models/Category.php';
require_once ROOT.'/helpers/FlashMessages.php';

class CategoryDetailsController extends ModelTemplateController {
	use AuthRequiredTrait;

	public $template = 'views/category_details_view.php';
	public $model = 'Category';

	public function permission_required() {
		return "superuser";
	}

	public function get_context() {
		$categories = new Category();
		$categories = $categories->all();

		$context['categories'] = $categories;
		$context["msg"] = new \Plasticbrain\FlashMessages\FlashMessages();
		return $context;
	}

	public function post() {
		$data = $_POST;
		
		if (!isset($data['active'])) {
			$data['active'] = false;
		}

		if ($data['parent_id'] == 0) {
			$data['parent_id'] = null;
		}

		$this->item->map($data);

		$msg = new \Plasticbrain\FlashMessages\FlashMessages();
		if ($this->item->save() > 0) {
			$msg->success("Đã lưu thành công");
			header("Location: ?cn=category");
		} else {
			$msg->error("Chưa thể lưu thay đổi");
			header("Location: ".$this->get_url());
		}
	}
}

 ?>