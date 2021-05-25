<?php 	

class Database {
	protected $connect;

	function __construct() {
		$this->connect = $this->connection();
	}

	function __destruct() {
		$this->connect = null;
	}

	public function connection() {
		try {
			$con = new PDO("mysql:host=localhost;dbname=article_management;charset=utf8", 'root', '');
			return $con;
		}
		catch(PDOException $e) {
			echo "Error: ".$e->getMessage();
			die;
		}
	}

	public function bindValue(&$stmt, $params) {
		foreach ($params as $key => $value) {
			$stmt->bindValue(":$key", $value, PDO::PARAM_STR);
		}
	}

	public function bindValuesAdv(&$stmt, $params) {
		foreach ($params as $key => $value) {
			$stmt->bindValue(":$key", $value[0], $value[1]);
		}
	}
}

 ?>