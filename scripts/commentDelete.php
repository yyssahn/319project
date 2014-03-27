<?php
include ('database_helper.php');
include('notification_helper.php');

$selectedCID = $_GET["commentID"];
$selectedLead = $_GET["leadID"];
$currentUser = $_GET["loginUser"];
$currentPage = $_GET["pg"];

// Connect to database
$db = new DatabaseHelper();

// retrieving currently logged in user information
$sql = "SELECT admin,username,uid FROM user WHERE username = '$currentUser'";
$s = $db->prepareStatement($sql);
$db->executeStatement($s);
$currentUser = $db->getResult($db);
$currentUserAdmin = $currentUser[0]['admin'];
$currentUsername = $currentUser[0]['username'];
$currentUserID = $currentUser[0]['uid'];


// retrieving the owner of the selected comment
$sql = "SELECT username FROM comment WHERE cid = '$selectedCID'";
$s = $db->prepareStatement($sql);
$db->executeStatement($s);
$tempCommentOwner = $db->getResult($db);
$commentOwner = $tempCommentOwner[0]['username'];

// Only the owner of the comment and admin account can delete the comment
if($currentUserAdmin == 1 || strcmp($currentUsername, $commentOwner) == 0) {

	$sql = "DELETE FROM comment WHERE cid = '$selectedCID'";
	$s = $db->prepareStatement($sql);
	$db->executeStatement($s);
	
	$nh = new NotificationHelper();
	$nh->turnon($db, $currentUserID, $selectedLead);	


	header("Location: http://localhost/project/scripts/index.php?content=lead_edit&lid=$selectedLead&page=$currentPage");	
}else {
	echo "<script>history.back();alert('You are not allowed to delete this comment!');</script>";
	
//	header("Location: http://localhost/project/scripts/index.php?content=lead_edit&lid=$selectedLead&deleteComment=0");	
}
exit();

?>