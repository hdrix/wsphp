<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


class Database{

	private $dbname = "demo";
	private $dbuser  = "demo";
	private $dbpass  = "aqswdefr1";
	private $dbhost = "localhost";
	private $conn;

	function __construct(){

		$this->conn = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname) or die(" No se puede conectar a la BD");
		//mysql_select_db($dbname);
		

	}

	function exec_query($query){
		$result = $this->_exec($query);


	}

	function exist($query){
		$result = $this->_exec($query);

		$num_rows = mysqli_num_rows($result);

		if($num_rows == 0){
			return false;
		}

		return true;

	}

	function get_row($query){
		$result = $this->_exec($query);

		$num_rows = mysqli_num_rows($result);

		if($num_rows == 0){
			return false;
		}

		return mysqli_fetch_object($result);

	}

	function get_rows($query){
		$result = $this->_exec($query);

		$num_rows = mysqli_num_rows($result);

		if($num_rows == 0){
			return false;
		}

		 //var_dump(mysqli_fetch_object($result));
		$rows = array();
		while($obj = mysqli_fetch_object($result)){
			$rows[] =  $obj;
		}

		return $rows;
	}

	private function _exec($query){
		
		$result = mysqli_query($this->conn,$query);

		if(!$result){
			die('Error al ejecutar la consulta. '.mysql_error());
		}

		return $result;
	}



}

