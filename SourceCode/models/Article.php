<?php 	
require_once ROOT.'/models/Database.php';
require_once ROOT.'/models/Tag.php';
require_once ROOT.'/models/User.php';
require_once ROOT.'/models/Category.php';

class Article extends Database {
	public $id;
	public $title;
	public $description;
	public $content;
	public $create_time;
	public $update_time;
	public $image;
	public $view;
	public $active;
	public $priority;
	public $published;
	public $publish_time;
	public $drafft;
	public $author;
	public $reviewer;
	public $review_time;
	public $editor;
	public $tags;
	public $category;

	public function all($keyword = '') {
		$sql = "SELECT * FROM articles WHERE title LIKE :keyword";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":keyword", '%'.$keyword.'%', PDO::PARAM_STR);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_all_without_draft($keyword = '') {
		$sql = "SELECT * FROM articles WHERE (drafft <> 1 OR drafft IS NULL) AND title LIKE :keyword";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":keyword", '%'.$keyword.'%', PDO::PARAM_STR);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_all_unreviewed_articles($keyword = '') {
		$sql = "SELECT * FROM articles WHERE (drafft <> 1 OR drafft IS NULL) AND review_person_id IS NULL AND title LIKE :keyword";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":keyword", '%'.$keyword.'%', PDO::PARAM_STR);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_all_reviewed_articles($keyword = '') {
		$sql = "SELECT * FROM reviewed_articles WHERE title LIKE :keyword";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":keyword", '%'.$keyword.'%', PDO::PARAM_STR);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_all_published_articles($keyword = '') {
		$sql = "SELECT * FROM published_articles WHERE title LIKE :keyword";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":keyword", '%'.$keyword.'%', PDO::PARAM_STR);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_all_published_active_articles($category_ids = [], $keyword = '') {
		$sql = "SELECT * FROM published_articles WHERE active = 1 AND title LIKE :keyword";
		if (!empty($category_ids)) {
			$sql = $sql." AND category_id IN (".join(",",$category_ids).")";
		}
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":keyword", '%'.$keyword.'%', PDO::PARAM_STR);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_all_published_active_articles_by_tag($tag) {
		$sql = "SELECT * FROM published_articles WHERE active = 1 AND tag_ids LIKE :tag";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":tag", '%'.$tag.'%', PDO::PARAM_STR);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_hot_articles($category_ids = []) {
		$sql = "SELECT * FROM published_articles WHERE active = 1";
		if (!empty($category_ids)) {
			$sql = $sql." AND category_id IN (".join(",",$category_ids).")";
		}
		$sql = $sql." ORDER BY priority ASC, publish_time DESC";
		$sql = $sql." LIMIT 3";
		$stmt = $this->connect->prepare($sql);
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_popular_articles($category_ids = []) {
		$sql = "SELECT * FROM published_articles WHERE active = 1";
		if (!empty($category_ids)) {
			$sql = $sql." AND category_id IN (".join(",",$category_ids).")";
		}
		$sql = $sql." ORDER BY view DESC LIMIT 3";
		$stmt = $this->connect->prepare($sql);
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_all_pass_articles($keyword = '') {
		$sql = "SELECT * FROM reviewed_articles WHERE (drafft <> 1 OR drafft IS NULL) AND publish_time IS NULL AND title LIKE :keyword";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":keyword", '%'.$keyword.'%', PDO::PARAM_STR);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_all_articles_by_user($user_id, $keyword = '') {
		$sql = "SELECT * FROM articles WHERE author_id = :id AND title LIKE :keyword";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":id", $user_id, PDO::PARAM_INT);
			$stmt->bindValue(":keyword", '%'.$keyword.'%', PDO::PARAM_STR);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_unreviewed_articles_by_user($user_id, $keyword = '') {
		$sql = "SELECT * FROM articles WHERE (drafft <> 1 OR drafft IS NULL) AND review_person_id IS NULL AND author_id = :id AND title LIKE :keyword";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":id", $user_id, PDO::PARAM_INT);
			$stmt->bindValue(":keyword", '%'.$keyword.'%', PDO::PARAM_STR);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_published_articles_by_user($user_id, $keyword = '') {
		$sql = "SELECT * FROM articles WHERE (drafft <> 1 OR drafft IS NULL) AND published = 1 AND author_id = :id AND title LIKE :keyword";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":id", $user_id, PDO::PARAM_INT);
			$stmt->bindValue(":keyword", '%'.$keyword.'%', PDO::PARAM_STR);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_draft_articles_by_user($user_id, $keyword = '') {
		$sql = "SELECT * FROM articles WHERE drafft = 1 AND author_id = :id AND title LIKE :keyword";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":id", $user_id, PDO::PARAM_INT);
			$stmt->bindValue(":keyword", '%'.$keyword.'%', PDO::PARAM_STR);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_user_history($user_id, $keyword = '') {
		$sql = "SELECT * FROM user_history WHERE user_id = :id AND title LIKE :keyword";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":id", $user_id, PDO::PARAM_INT);
			$stmt->bindValue(":keyword", '%'.$keyword.'%', PDO::PARAM_STR);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function get_user_like($user_id, $keyword = '') {
		$sql = "SELECT * FROM user_like WHERE user_id = :id AND title LIKE :keyword";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":id", $user_id, PDO::PARAM_INT);
			$stmt->bindValue(":keyword", '%'.$keyword.'%', PDO::PARAM_STR);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$articles = [];
		foreach($data as $item) {
			if (isset($item["tag_ids"])) {
				$tags = new Tag();
				$tags = $tags->getByIds($item["tag_ids"]);
				$item["tags"] = $tags;
			}
			$article = new Article();
			$article->map($item);
			array_push($articles, $article);
		}
		return $articles;
	}

	public function count_published_acticles() {
		$sql = "SELECT COUNT(id) as count FROM published_articles WHERE active = 1";
		$stmt = $this->connect->prepare($sql);
		
		$count = 0;
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				$count = $data['count'];
			}
		}
		$stmt->closeCursor();
		return $count;
	}

	public function review($reviewer, $drafft) {
		$sql = "CALL reviewArticle(:id, :review_person_id, :drafft)";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$this->bindValuesAdv($stmt, [
				"id" => [$this->id, PDO::PARAM_INT],
				"review_person_id" => [$reviewer->id, PDO::PARAM_INT],
				"drafft" => [$drafft, PDO::PARAM_BOOL]
			]);
		}
		
		if ($stmt->execute()) {
			$rowCount = $stmt->rowCount();
			if ($rowCount>0) {
				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
				$this->review_time = $rs['@review_time'];
				$this->reviewer = $reviewer;
				$this->drafft = $drafft;
			}
		}
		$stmt->closeCursor();
		return $rowCount;
	}

	public function publish($article_ids, $editor_id) {
		$sql = "CALL publishArticles(:article_ids, :editor_id)";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$this->bindValuesAdv($stmt, [
				"article_ids" => [$article_ids, PDO::PARAM_STR],
				"editor_id" => [$editor_id, PDO::PARAM_INT]
			]);
		}
		
		if ($stmt->execute()) {
			$rowCount = $stmt->rowCount();
		}
		$stmt->closeCursor();
		return $rowCount;
	}

	public function get($id) {
		$sql = "SELECT * FROM articles WHERE id = :id";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":id", $id, PDO::PARAM_INT);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		if (isset($data["tag_ids"])) {
			$tags = new Tag();
			$tags = $tags->getByIds($data["tag_ids"]);
			$data["tags"] = $tags;
		}

		$this->map($data);
	}

	public function save() {
		$sql = "CALL saveArticle(:title,:description,:content,:image,:author_id,:category_id,:drafft,:tag_ids)";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$tag_ids = [];
			if (count($this->tags)) {
				foreach ($this->tags as $tag) {
					array_push($tag_ids, $tag->id);
				}
			}
			$this->bindValuesAdv($stmt, [
				"title" => [$this->title, PDO::PARAM_STR],
				"description" => [$this->description, PDO::PARAM_STR],
				"content" => [$this->content, PDO::PARAM_STR],
				"image" => [$this->image, PDO::PARAM_STR],
				"author_id" => [$this->author->id, PDO::PARAM_INT],
				"category_id" => [$this->category->id, PDO::PARAM_INT],
				"drafft" => [$this->drafft, PDO::PARAM_BOOL],
				"tag_ids" => [join(",",$tag_ids), PDO::PARAM_STR],
			]);
		}

		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
				$this->id = $rs['@id'];
			}
		}
		$stmt->closeCursor();
	}

	public function update() {
		$sql = "CALL updateArticle(:article_id,:title,:description,:content,:image,:author_id,:category_id,:drafft,:tag_ids)";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$tag_ids = [];
			if (count($this->tags)) {
				foreach ($this->tags as $tag) {
					array_push($tag_ids, $tag->id);
				}
			}
			$this->bindValuesAdv($stmt, [
				"article_id" => [$this->id, PDO::PARAM_INT],
				"title" => [$this->title, PDO::PARAM_STR],
				"description" => [$this->description, PDO::PARAM_STR],
				"content" => [$this->content, PDO::PARAM_STR],
				"image" => [$this->image, PDO::PARAM_STR],
				"author_id" => [$this->author->id, PDO::PARAM_INT],
				"category_id" => [$this->category->id, PDO::PARAM_INT],
				"drafft" => [$this->drafft, PDO::PARAM_BOOL],
				"tag_ids" => [join(",",$tag_ids), PDO::PARAM_STR],
			]);
		}

		if ($stmt->execute()) {
			$rowCount = $stmt->rowCount();
			$stmt->closeCursor();
			return $rowCount;
		}
		$stmt->closeCursor();
	}

	public function viewed() {
		$sql = "UPDATE article SET view = view + 1 WHERE id = :id";
		$stmt = $this->connect->prepare($sql);

		if ($stmt) {
			$this->bindValuesAdv($stmt, [
				"id" => [$this->id, PDO::PARAM_INT]
			]);
		}

		$rowCount = 0;
		if ($stmt->execute()) {
			$rowCount = $stmt->rowCount();
		}

		$stmt->closeCursor();
		return $rowCount;
	}

	public function delete() {
		$sql = "CALL deleteArticle(:id)";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$this->bindValuesAdv($stmt, [
				"id" => [$this->id, PDO::PARAM_INT]
			]);
		}

		if ($stmt->execute()) {
			$rowCount = $stmt->rowCount();
			$stmt->closeCursor();
			return $rowCount;
		}
	}

	public function getTagIDs() {
		$tag_ids = [];
		if (count($this->tags)) {
			foreach ($this->tags as $tag) {
				array_push($tag_ids, $tag->id);
			}
		}
		return $tag_ids;
	}

	public function getTagNames() {
		$tag_names = [];
		if (count($this->tags)) {
			foreach ($this->tags as $tag) {
				array_push($tag_names, $tag->name);
			}
		}
		return $tag_names;
	}

	public function map($data) {
		foreach ($this as $key => $value) {
			if ($key == "author" || $key == "editor") {
				if (isset($data[$key."_id"])) {
					$user = new User();
					$user->id = $data[$key."_id"];
					$user->full_name = $data[$key."_name"];
					$this->$key = $user;
					continue;
				}
			}
			if ($key == "reviewer") {
				if (isset($data["review_person_id"])) {
					$user = new User();
					$user->id = $data["review_person_id"];
					$user->full_name = $data[$key."_name"];
					$this->$key = $user;
					continue;
				}
			}
			if ($key == "tags") {
				$this->$key = [];
				if (isset($data["tag_ids"])) {
					$tags = new Tag();
					$tags = $tags->getByIds($data["tag_ids"]);
					$this->$key = $tags;
					continue;
				}
			}
			if ($key == "category") {
				if (isset($data["category_id"])) {
					$category = new Category();
					$category->id = $data["category_id"];
					if (isset($data["category_name"])) {
						$category->name = $data["category_name"];
					}
					$this->$key = $category;
					continue;
				}
			}
			$this->$key = isset($data[$key])? $data[$key]:$this->$key;
		}
	}
}

 ?>