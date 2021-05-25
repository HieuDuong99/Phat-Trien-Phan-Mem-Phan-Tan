<?php 	
require_once ROOT.'/models/Database.php';

class User extends Database {
	public $id;
	public $username;
	public $password;
	public $email;
	public $phone_number;
	public $avatar_img;
	public $full_name;
	public $super_user;
	public $create_time;
	public $update_time;
	public $permissions;
	public $perms;

	public function all($keyword = "") {
		$sql = "SELECT * FROM users WHERE username LIKE :keyword OR email LIKE :keyword";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$this->bindValuesAdv($stmt, [
				"keyword" => ["%".$keyword."%", PDO::PARAM_STR]
			]);
		}

		$data = [];
		if ($stmt) {
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}

		$users = [];
		foreach($data as $item) {
			$user = new User();
			$user->map($item);
			array_push($users, $user);
		}

		return $users;
	}

	public function get($id) {
		$stmt = $this->connect;

		$sql = "SELECT * FROM users WHERE id = :id";
		$stmt = $stmt->prepare($sql);
		if ($stmt) {
			$this->bindValuesAdv($stmt, [
				"id" => [$id, PDO::PARAM_INT]
			]);
		}

		$data = [];
		if ($stmt->execute()) {
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		$stmt->closeCursor();
		$this->map($data);
	}

	public function get_by_username($username, $password = '') {
		$stmt = $this->connect;

		if ($password == '') {
			$sql = "SELECT * FROM users WHERE username = :username";
			$stmt = $stmt->prepare($sql);
			if ($stmt) {
				$this->bindValue($stmt, [
					"username" => $username
				]);
			}
		} else {
			$sql = "SELECT * FROM users WHERE username = :username AND password = :password";
			$stmt = $stmt->prepare($sql);
			if ($stmt) {
				$this->bindValue($stmt, [
					"username" => $username,
					"password" => $password
				]);
			}
		}

		$data = [];
		if ($stmt->execute()) {
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		$stmt->closeCursor();
		$this->map($data);
	}

	public function count_new_user() {
		$sql = "SELECT COUNT(id) AS count FROM user WHERE create_time >= current_timestamp() - interval 7 day";
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

	public function read($article_id) {
		$sql = "CALL readArticle(:article_id, :user_id)";
		$stmt = $this->connect->prepare($sql);

		if ($stmt) {
			$this->bindValuesAdv($stmt, [
				"article_id" => [$article_id, PDO::PARAM_INT],
				"user_id" => [$this->id, PDO::PARAM_INT]
			]);
		}

		$rowCount = 0;
		if ($stmt->execute()) {
			$rowCount = $stmt->rowCount();
		}

		$stmt->closeCursor();
		return $rowCount;
	}

	public function like($article_id) {
		$sql = "CALL likeArticle(:article_id,:user_id)";
		$stmt = $this->connect->prepare($sql);

		if ($stmt) {
			$this->bindValuesAdv($stmt, [
				"article_id" => [$article_id, PDO::PARAM_INT],
				"user_id" => [$this->id, PDO::PARAM_INT]
			]);
		}

		$rowCount = 0;
		if ($stmt->execute()) {
			$rowCount = $stmt->rowCount();
		}

		$stmt->closeCursor();
		return $rowCount;
	}

	public function has_like($article_id) {
		$sql = "SELECT * FROM `like` WHERE `like`.article_id = :article_id AND `like`.user_id = :user_id";
		$stmt = $this->connect->prepare($sql);

		if ($stmt) {
			$this->bindValuesAdv($stmt, [
				"article_id" => [$article_id, PDO::PARAM_INT],
				"user_id" => [$this->id, PDO::PARAM_INT]
			]);
		}

		$liked = false;
		$rowCount = 0;
		if ($stmt->execute()) {
			if ($stmt->rowCount() > 0) {
				$liked = true;
			};
		}

		$stmt->closeCursor();
		return $liked;
	}

	public function has_perm($perm) {
		return $this->is_super_user() || in_array($perm, $this->permissions) || $perm == "user";
	} 

	public function is_super_user() {
		return $this->super_user;
	}

	public function save() {
		$sql = "CALL newUser(:username, :password, :full_name, :email, :phone_number, :avatar_img, :superuser, :perms)";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$this->bindValuesAdv($stmt, [
				"username" => [$this->username, PDO::PARAM_STR],
				"password" => [$this->password, PDO::PARAM_STR],
				"full_name" => [$this->full_name, PDO::PARAM_STR],
				"email" => [$this->email, PDO::PARAM_STR],
				"phone_number" => [$this->phone_number, PDO::PARAM_STR],
				"avatar_img" => [$this->avatar_img, PDO::PARAM_STR],
				"superuser" => [$this->super_user, PDO::PARAM_BOOL],
				"perms" => [join(",",$this->perms), PDO::PARAM_STR],
			]);
		}

		if ($stmt->execute()) {
			$rowCount = $stmt->rowCount();
			$stmt->closeCursor();
			return $rowCount;
		}
		$stmt->closeCursor();
	}

	public function update() {
		$sql = "CALL updateUser(:user_id, :full_name, :email, :phone_number, :avatar_img, :superuser, :perms)";
		$stmt = $this->connect->prepare($sql);
		if ($stmt) {
			$this->bindValuesAdv($stmt, [
				"user_id" => [$this->id, PDO::PARAM_INT],
				"full_name" => [$this->full_name, PDO::PARAM_STR],
				"email" => [$this->email, PDO::PARAM_STR],
				"phone_number" => [$this->phone_number, PDO::PARAM_STR],
				"avatar_img" => [$this->avatar_img, PDO::PARAM_STR],
				"superuser" => [$this->super_user, PDO::PARAM_BOOL],
				"perms" => [join(",",$this->perms), PDO::PARAM_STR],
			]);
		}

		if ($stmt->execute()) {
			$rowCount = $stmt->rowCount();
			$stmt->closeCursor();
			return $rowCount;
		}
		$stmt->closeCursor();
	}

	public function map($data) {
		foreach ($this as $key => $value) {
			if ($key == "permissions") {
				$this->$key = [];
				if (isset($data[$key])) {
					$this->$key = explode(",", $data[$key]);
				}
				continue;
			}
			$this->$key = isset($data[$key])? $data[$key]:$this->$key;
		}
	}
}

 ?>