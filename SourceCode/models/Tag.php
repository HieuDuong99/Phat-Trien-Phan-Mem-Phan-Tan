<?php 	
require_once ROOT.'/models/Database.php';

class Tag extends Database {
	public $id;
	public $name;

	public function all($keyword = '') {
		$sql = "SELECT * FROM tag WHERE name LIKE :keyword";
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

		$tags = [];
		foreach($data as $item) {
			$tag = new Tag();
			$tag->map($item);
			array_push($tags, $tag);
		}
		return $tags;
	}

	public function get_hot_tags($limit = 10) {
		$sql = "SELECT * FROM hot_tags LIMIT :lim";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$stmt->bindValue(":lim", $limit, PDO::PARAM_INT);
		}
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$tags = [];
		foreach($data as $item) {
			$tag = new Tag();
			$tag->map($item);
			array_push($tags, $tag);
		}
		return $tags;
	}

	public function getByIds($ids) {
		$sql = "SELECT * FROM tag WHERE id IN(".$ids.")";
		$stmt = $this->connect->prepare($sql);
		
		$data = [];
		if ($stmt->execute()) {
			if ($stmt->rowCount()>0) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		$stmt->closeCursor();

		$tags = [];
		foreach($data as $item) {
			$tag = new Tag();
			$tag->map($item);
			array_push($tags, $tag);
		}
		return $tags;
	}

	public function save() {
		if (!isset($this->id)) {
			$sql = "INSERT INTO tag(name) VALUES(:name)";
			$stmt = $this->connect->prepare($sql);
			if ($stmt) {
				$this->bindValuesAdv($stmt, [
					"name" => [$this->name, PDO::PARAM_STR]
				]);
			}

			if ($stmt->execute()) {
				$rowCount = $stmt->rowCount();
				if ($rowCount > 0) {
					$this->id = $this->connect->lastInsertId();
				}
			}
		} else {
			$sql = "UPDATE tag SET name = :name WHERE id = :id";
			$stmt = $this->connect->prepare($sql);
			if ($stmt) {
				$this->bindValuesAdv($stmt, [
					"id" => [$this->id, PDO::PARAM_INT],
					"name" => [$this->name, PDO::PARAM_STR]
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
			$this->$key = isset($data[$key])? $data[$key]:$this->$key;
		}
	}
}

 ?>