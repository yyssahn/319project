<?php

class NotificationHelper{

	//Database Credentials
	private $DBServer;
	private $DBUse;
	private $DBPass;
	private $DBName;

	// Needed to prepare and execute statement
	private $conn;
	private $message = "There are update(s) to lead : ";
	private $subject = " Update!";
	private $Tsubject = "New Tag: ";
	private $Tmessage = "You have been tagged in lead : ";
	private $from = "From: ccel_t8@yahoo.ca";
	private $to = "ccel_t8@yahoo.ca ,";
	 
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

	
	// Turns a notification off. For a given user.
	public function turnoff($uid, $lid){
		$query ="UPDATE tag
				SET seen = 0
				WHERE uid ='".$uid."' AND lid = '".$lid."' AND seen = 1" ;
		$this->conn->query($query);
	}
	// Turns off a tag notification for a new user
	public function turnoffTag($uid, $lid){
		$query ="UPDATE tag
				SET tags = 0, seen = 0
				WHERE uid ='".$uid."' AND lid = '".$lid."' AND tags = 1" ;
		$this->conn->query($query);
	}

	// Updates and provdes notifcations to all users that are tagged on a lead.
	public function turnon($lid){
		$query ="UPDATE tag
				SET seen = 1
				WHERE lid = '.$lid.' AND seen = 0" ;
		$this->conn->query($query);
		$this->mailSpecificsUpdate($lid);
	}

	// tags a new person on that lead or themselves.
	public function turnonTag($uid, $lid){
		
		$query ="INSERT INTO tag (`uid`, `lid`, `seen`, `tags`) 
				 VALUES ('".$uid."', '".$lid."', '1', '1')";
		
		$this->conn->query($query);
		$this->mailTags($uid, $lid);
	}

	//Checks if the user is already tagged
	public function isTag($uid,$lid){
		$sql = "SELECT count(*)
				From tag
				Where uid = '".$uid."' AND lid = '".$lid."'";
		 $result = $this->conn->query($sql);
		 $row = $result->fetch_row();
    	 return ($row[0] != 0);
	}

	// Allows users to untag themselves from a lead
	// They will no longer receiver updates.
	public function removeTag($uid, $lid){
		
		$query ="DELETE
				FROM tag
				WHERE uid = '".$uid."' AND lid = '".$lid."'" ;
		$this->conn->query($query);
	}

	//Remove that lead Notificaiton
	public function delLeadTag($lid){

		$query ="DELETE
			FROM tag
			WHERE lid = '".$lid."'" ;
		$this->conn->query($query);
	}

	// Allows the user to get the number of notifcation they currently have
	public function getNumberNotif($uid){
		//$this->spamMail();
		$sql = "SELECT count(*)
				From tag
				Where uid = '".$uid."' AND (seen = 1 or tags = 1)";
		 $result = $this->conn->query($sql);
		 $row = $result->fetch_row();
    	 return $row[0];
	}
	// gets all notifcaitiong for a specific user
	public function getNotifications($uid){
		$sql = "SELECT T.uid, T.seen, T.tags, T.lid, L.lead_name
				FROM cbel_lead L
				INNER JOIN tag T
		 		WHERE T.lid = L.lid AND T.uid = '".$uid."' 
		 			AND (T.seen = 1 OR T.tags = 1 )";

		$result = $this->conn->query($sql);
		return $result->fetch_all(MYSQLI_ASSOC);
	}

	public function updateMail($to){
		mail($to, $this->subject , $this->message,  $this->from);
	}
	public function mailSpecificsUpdate($lid){
		$query = "SELECT lead_name
					FROM cbel_lead
					Where lid = '".$lid."'";

		$result = $this->conn->query($query);
		$result = $result->fetch_row();
		$this->message = $this->message. "" .$result[0];
		$this->subject = $result[0]. "" .$this->subject;

		$query ="SELECT U.email
				FROM user U, tag T
				WHERE lid = '".$lid."' AND U.uid = T.uid " ;
		$result = $this->conn->query($query);
		while ($row = $result->fetch_row()) {
        	$this->to = $this->to. "" .$row[0]. " , ";
    	}
    	$this->updateMail($this->to);
	}
	public function mailTags($uid,$lid){
		$query = "SELECT lead_name
					FROM cbel_lead
					Where lid = '".$lid."'";

		$result = $this->conn->query($query);
		$result = $result->fetch_row();
		$this->Tmessage = $this->Tmessage. "" .$result[0];
		$this->Tsubject = $this->Tsubject. "" .$result[0];

		$query ="SELECT U.email
				FROM user U
				WHERE U.uid = '".$uid."'" ;
		$result = $this->conn->query($query);
		while ($row = $result->fetch_row()) {
        	$this->to = $this->to. "" .$row[0]. " , ";
    	}
		mail($this->to, $this->Tsubject , $this->Tmessage,  $this->from);
	}
}

?>