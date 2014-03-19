<?php

class DatabaseHelper{
	// Database credentials 
	private $DBServer;
	private $DBUse;
	private $DBPass;
	private $DBName;
	
	// Needed to prepare and execute statement
	private $conn;
	private $stmt;
	private $result_array;
	private $sql;
	 
	/*Connect to database */
	public function __construct(){
		$DBServer = "localhost";
		$DBUser = "root";
		$DBPass = "";
		$DBName = "cbel_db";
		
		$this->conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
		if($this->conn->connect_error)
			trigger_error('Database connection failed: '  . $this->conn->connect_error, E_USER_ERROR);
			
		return $this->conn;
	}
	
	/* Prepare statement */
	public function prepareStatement($sql){
		$this->stmt = $this->conn->prepare($sql);
		if($this->stmt === false)
			trigger_error($this->conn->error, E_USER_ERROR);
			
		return $this->stmt;
	}
	
	/* Bind parameters.  May be removed */
	public function bindParameters($stmt, $types, $params){
		$this->stmt->bind_param($types, $params);
	}
	
	/* Bind an array of parameters */
	public function bindArray($stmt, $param_types, $array){
		$a_params = array();	// Array to be passed by reference
		
		// Create string of types in array
		$param_type = '';
		for($i=0; $i<count($param_types); $i++)
			$param_type .= $param_types[$i];

		// Populate array to be passed by reference to be bound	
		$a_params[] = & $param_type;
		for($i=0; $i<count($array); $i++)
			$a_params[] = & $array[$i];

		// Bind array. call_user_func_array requires the array to be passed by reference ($a_params is referenceing $array)
		call_user_func_array(array($this->stmt, 'bind_param'), $a_params);
	}
	
	/* Execute Statement */
	public function executeStatement($stmt){
		$this->stmt ->execute();
	}

	/* Store result in array */
	public function getResult(){
		$result = $this->stmt->get_result();
		$result_array = $result->fetch_all(MYSQLI_ASSOC);
		
		return $result_array;
	}
	
	public function getArrayResult(){
		$result = $this->stmt->get_result();
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			array_push($result_array, $row);
		}
		var_dump($result_array);
		return $result_array;
	}
}

?>