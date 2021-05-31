<?php 	
require_once ROOT.'/models/Database.php';

class Category extends Database {
	public $id;
	public $name;
	public $parent;
	public $active;

	public function all($keyword = '') {
		$sql = "SELECT * FROM categories WHERE name LIKE :keyword";
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

		$categories = [];
		foreach($data as $item) {
			$category = new Category();
			$category->map($item);
			array_push($categories, $category);
		}
		return $categories;
	}

	public function all_active($keyword = '') {
		$sql = "SELECT * FROM categories WHERE active = 1 AND name LIKE :keyword";
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

		$categories = [];
		foreach($data as $item) {
			$category = new Category();
			$category->map($item);
			array_push($categories, $category);
		}
		return $categories;
	}

	public function get($id) {
		$sql = "SELECT * FROM categories WHERE id = :id";
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

		$this->map($data);
	}

	public function save() {
		if (!isset($this->id)) {
			$sql = "INSERT INTO category(name, parent_id, active) VALUES(:name, :parent_id, :active)";
			$stmt = $this->connect->prepare($sql);
			if ($stmt) {
				$this->bindValuesAdv($stmt, [
					"name" => [$this->name, PDO::PARAM_STR],
					"parent_id" => [$this->parent->id, PDO::PARAM_INT],
					"active" => [$this->active, PDO::PARAM_BOOL]
				]);
			}

			if ($stmt->execute()) {
				$rowCount = $stmt->rowCount();
				if ($rowCount > 0) {
					$this->id = $this->connect->lastInsertId();
				}
			}
		} else {
			$sql = "UPDATE category SET name = :name, parent_id = :parent_id, active = :active WHERE id = :id";
			$stmt = $this->connect->prepare($sql);
			if ($stmt) {
				$this->bindValuesAdv($stmt, [
					"id" => [$this->id, PDO::PARAM_INT],
					"name" => [$this->name, PDO::PARAM_STR],
					"parent_id" => [$this->parent->id, PDO::PARAM_INT],
					"active" => [$this->active, PDO::PARAM_BOOL]
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
			if ($key == "parent") {
				$parent = new Category();
				if (isset($data["parent_id"])) {
					$parent->id = $data["parent_id"];
					if (isset($data["parent_name"])) {
						$parent->name = $data["parent_name"];
					}
					if (isset($data["parent_active"])) {
						$parent->active = $data["parent_active"];
					}
				}
				$this->$key = $parent;
				continue;
			}
			$this->$key = isset($data[$key])? $data[$key]:$this->$key;
		}
	}
}

 ?>