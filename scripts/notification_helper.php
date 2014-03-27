<?php

class NotificationHelper{
	//private $db;
	 
	/*Connect to database */
	//public function __construct(){
	//	$this->db = new Databasehelper();
	//}
	
	/* Prepare statement */
	public function turnoff($db,$uid, $lid){
		$query ="UPDATE tag
				SET seen = 0
				WHERE uid ='$uid' AND lid = '$lid' AND seen = 1" ;
		$stmt = $db->prepareStatement($query);
		$db->executeStatement($stmt);
	}
	public function turnoffTag($db, $uid, $lid){
		$query ="UPDATE tag
				SET tags = 0
				WHERE uid ='$uid' AND lid = '$lid' AND tags = 1" ;
		$stmt = $db->prepareStatement($query);
		$db->executeStatement($stmt);
	}

	public function getUnnotified($str){
		$query = "SELECT idea_name FROM notification WHERE username = '".$str."' AND notification = 1";
		$stmt = $this->db ->prepareStatement($query);
		$this->db ->executeStatement($stmt);			
		
		return $this->db->getResult();
	}
	public function createNotification($un ,$idea_name){
		$query = 'INSERT INTO `notification`(`idea_name`, `username`, `notification`) VALUES ("'.$idea_name.'","'.$un.'","")';
		$stmt = $this->db->prepareStatement($query);
		$this->db->executeStatement($stmt);
	}
	public function turnon($username, $idea_name){
		$query ='UPDATE notification
		SET notification = 1
		WHERE username ="'.$username.'" AND idea_name = "'.$idea_name.'" AND notification = 0' ;
		$stmt = $this->db->prepareStatement($query);
		$this->db->executeStatement($stmt);	
	
	}
	
	function getNotifications($dbhelper, $uid){
		$sql = "SELECT T.uid, T.seen, T.tags, T.lid, L.lead_name
				FROM cbel_lead L
				INNER JOIN tag T
		 		WHERE T.lid = L.lid AND T.uid = ? 
		 			AND (T.seen = 1 OR T.tags = 1 )";
		$stmt = $dbhelper->prepareStatement($sql);

		$params = array($uid);
		$param_types = array('s');
		$dbhelper->bindArray($stmt, $param_types, $params);
		$dbhelper->executeStatement($stmt);
		$result = $dbhelper->getResult($stmt);
		return $result;
	}
}

?>