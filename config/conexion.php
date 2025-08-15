<?php
require_once("const.php");
class Conectar {
	protected $dbh;
	protected function conexion() {
		try {
			$conectar = $this->dbh = new PDO("mysql:hostr=".SERVER_DB.";dbname=".NAME_DB,USER_DB,PASS_DB);
			return $conectar;
		} catch (Exception $e) {
			print "¡Error!: " . $e->getMessage() . "<br/>";
			die();
		}
	}

	public function set_names(){
		return $this->dbh->query("SET NAMES 'utf8'");
	}
}
?>