<?php

class NotificationHelper{

	//Database Credentials
	private $DBServer;
	private $DBUse;
	private $DBPass;
	private $DBName;

	// Basic information to send out in our update email(s).
	private $conn;
	private $message = "There are update(s) to lead : ";
	private $subject = " Update!";
	private $Tsubject = "New Tag: ";
	private $Tmessage = "You have been tagged in lead : ";
	private $from = "CBEL Tracker";
        private $to = "";
	 
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

	/*
		Turns a notification off. For a given user.
		Pre:  Takes user id and the specific lead id.
		Post: Notification turned off in the database.
	*/
	public function turnoff($uid, $lid){
		$query ="UPDATE tag
				SET seen = 0
				WHERE uid ='".$uid."' AND lid = '".$lid."' AND seen = 1" ;
		$this->conn->query($query);
	}
	
	/*
		Removes a tag for a specific user on a specific lead
		Pre:  Takes user id and the specific lead id.
		Post: Tag is removed from the database.
	*/	
	public function turnoffTag($uid, $lid){
		$query ="UPDATE tag
				SET tags = 0, seen = 0
				WHERE uid ='".$uid."' AND lid = '".$lid."' AND tags = 1" ;
		$this->conn->query($query);
	}

	/*
		Any updates to a lead will notifiy all other users.
		Pre:  Takes a specific lead id that has an update to it
		Post: Adds a notification to all users that are tagged on that lead.
			  Also sends a mail to everyone thats on the lead telling them
			  they have a new update.
	*/
	public function turnon($lid){
		$query ="UPDATE tag
				SET seen = 1
				WHERE lid = '".$lid."' AND seen = 0" ;
		$this->conn->query($query);
		$this->mailSpecificsUpdate($lid);
	}

	/*
		Ability to add a user onto a specific lead.
		Pre:  Takes user id and the specific lead id.
		Post: Adds a new relationship between user and lead in the database.
			  So that user is notified any update that happens.
			  Also sends out a mail when that new user is tagged.
	*/
	public function turnonTag($uid, $lid){
		
		$query ="INSERT INTO tag (`uid`, `lid`, `seen`, `tags`) 
				 VALUES ('".$uid."', '".$lid."', '1', '1')";
		
		$this->conn->query($query);
		$this->mailTags($uid, $lid);
	}

	/*
		Checks if the user is already tagged in a specific lead.	
		Pre:  Takes user id and the specific lead id.
		Post: Returns True/False if that user is tagged
	*/	
	public function isTag($uid,$lid){
		$sql = "SELECT count(*)
				From tag
				Where uid = '".$uid."' AND lid = '".$lid."'";
		 $result = $this->conn->query($sql);
		 $row = $result->fetch_row();
    	 return ($row[0] != 0);
	}

	/*
		Removes a connection between user and a specific lead
		So they no longer receive notifications.
		Pre:  Takes user id and the specific lead id.
		Post: Removes a connection between user and a specific lead
	*/
	public function removeTag($uid, $lid){
		
		$query ="DELETE
				FROM tag
				WHERE uid = '".$uid."' AND lid = '".$lid."'" ;
		$this->conn->query($query);
	}

	/*
		If a lead is removed all the users are untagged off that lead.
		Pre:  Takes a specific lead id.
		Post: Removes connection(s) between all user(s) and that specific lead
	*/
	public function delLeadTag($lid){

		$query ="DELETE
			FROM tag
			WHERE lid = '".$lid."'" ;
		$this->conn->query($query);
	}

	/*
		Gets the number of notifications a specific user has.
		Pre:  Takes user id.
		Post: Returns the number of notifications they have.
	*/
	public function getNumberNotif($uid){
		$sql = "SELECT count(*)
				From tag
				Where uid = '".$uid."' AND (seen = 1)";//or tags = 1
		 $result = $this->conn->query($sql);
		 $row = $result->fetch_row();
    	 return $row[0];
	}

	/*
		Gets all the notifications for a specific user.
		Pre:  Takes user id.
		Post: Returns the notifications they have.
	*/
	public function getNotifications($uid){
		$sql = "SELECT T.uid, T.seen, T.tags, T.lid, L.lead_name
				FROM cbel_lead L
				INNER JOIN tag T
		 		WHERE T.lid = L.lid AND T.uid = '".$uid."' 
		 			AND (T.seen = 1 OR T.tags = 1 )"; 

		$result = $this->conn->query($sql);
		return $result->fetch_all(MYSQLI_ASSOC);
	}
        
        /*
	The mail funtion that makes the mail and sends it out
	Pre:  Takes mail list.
	Post: Sends mail to the users in the mail list..
	*/
        
	/*
		Email send for new updates to the lead being followed.
		Pre:  Takes user id and the specific lead id.
		Post: Calls the updateMail function to send the update.
	*/
	public function mailSpecificsUpdate($lid){
                global $db;
                require("../phpmailer/class.phpmailer.php");
                $mail = new PHPMailer();

                                
                $sqlx = "SELECT lead_name
                                FROM cbel_lead
                                Where lid = '".$lid."'";
                $sx = $db->prepareStatement($sqlx);
                $db->executeStatement($sx);
                $leadname = $db->getResult($sqlx);
                
                $this->message = $this->message. "" . $leadname[0]['lead_name'];
                $this->subject = $leadname[0]['lead_name']. "" . $this->subject;
                
		$sqlx = "SELECT U.email
				FROM user U, tag T
				WHERE lid = '".$lid."' AND U.uid = T.uid " ;	

		$sx = $db->prepareStatement($sqlx);
		$db->executeStatement($sx);
		$listOfEmails = $db->getResult($sqlx);
                
                foreach($listOfEmails as $email) {
                    $mail->AddAddress($email['email']);
                }
                
                if (null !== $mail->Send()) {

                    // ---------- adjust these lines ---------------------------------------

                    $mail->Username = "cbeltracker@gmail.com"; // your GMail user name
                    $mail->Password = "ccelrocks";

                    //----------------------------------------------------------------------

                    $mail->FromName = $this->from; // readable name

                    $mail->Subject = $this->subject;
                    $mail->Body    = $this->message; 

                    $mail->Host = "ssl://smtp.gmail.com"; // GMail
                    $mail->Port = 465;
                    $mail->IsSMTP(); // use SMTP
                    $mail->SMTPAuth = true; // turn on SMTP authentication
                    $mail->From = $mail->Username;
                    if(!$mail->Send())
                        echo "Error: " . $mail->ErrorInfo;
                    else ;

                    }
	}
		
	/*
		Email send for new tags
		Pre:  Takes user id and the specific lead id.
		Post: Calls the updateMail function to send the update.
	*/		
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