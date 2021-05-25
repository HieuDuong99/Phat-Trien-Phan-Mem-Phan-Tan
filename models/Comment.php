<?php 	
require_once ROOT.'/models/Database.php';
require_once ROOT.'/models/User.php';

class Comment extends Database {
	public $id;
	public $article_id;
	public $user;
	public $content;
	public $create_time;
	public $update_time;

	public function all() {
		$sql = "SELECT * FROM comments";
		$stmt = $this->connect->prepare($sql);
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$comments = [];
		foreach($data as $item) {
			$comment = new Comment();
			$comment->map($item);
			array_push($comments, $comment);
		}
		return $comments;
	}

	public function get_cmts_on_article($id) {
		$sql = "SELECT * FROM comments WHERE article_id = :id";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":id", $id, PDO::PARAM_INT);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$comments = [];
		foreach($data as $item) {
			$comment = new Comment();
			$comment->map($item);
			array_push($comments, $comment);
		}

		return $comments;
	}

	public function count_recent_cmt() {
		$sql = "SELECT COUNT(id) AS count FROM comments WHERE create_time >= current_timestamp() - interval 7 day";
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

	public function save() {
		if (!isset($this->id)) {
			$sql = "CALL commentArticle(:article_id, :user_id, :content);";
			$stmt = $this->connect->prepare($sql);
			if ($stmt) {
				$this->bindValuesAdv($stmt, [
					"article_id" => [$this->article_id, PDO::PARAM_INT],
					"user_id" => [$this->user->id, PDO::PARAM_INT],
					"content" => [$this->content, PDO::PARAM_STR]
				]);
			}

			$data = [];
			if ($stmt->execute()) {
				$rowCount = $stmt->rowCount();
				if ($rowCount > 0) {
					$data = $stmt->fetch(PDO::FETCH_ASSOC);
				}
			}

			$this->map($data);
		} else {
			$sql = "UPDATE comment SET :content WHERE id = :id";
			$stmt = $this->connect->prepare($sql);
			if ($stmt) {
				$this->bindValuesAdv($stmt, [
					"content" => [$this->content, PDO::PARAM_STR],
					"id" => [$this->id, PDO::PARAM_INT]
				]);
			}

			if ($stmt->execute()) {
				$rowCount = $stmt->rowCount();
			}
		}

		$stmt->closeCursor();
		return $rowCount;
	}

	public function map($data) {
		foreach ($this as $key => $value) {
			if ($key == "user") {
				$user = new User();
				if (isset($data[$key."_id"])) {
					$user->id = $data[$key."_id"];
				}
				if (isset($data[$key."_username"])) {
					$user->username = $data[$key."_username"];
				}
				$this->$key = $user;
				continue;
			}
			$this->$key = isset($data[$key])? $data[$key]:$this->$key;
		}
	}
}

 ?>