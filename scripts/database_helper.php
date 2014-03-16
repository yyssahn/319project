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
	if($this->conn === NULL)
			print "NULL mother fucker!";
		$this->stmt = $this->conn->prepare($sql);
		if($this->stmt === false)
			trigger_error($this->conn->error, E_USER_ERROR);
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
}

?>