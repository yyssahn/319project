 <?php
include('database_helper.php');
$db = new DatabaseHelper();
session_start();

// Input username and password
$Input_username = $_POST["username"];
$Input_password = $_POST["password"];

// Get user information
$sql = "SELECT * FROM user WHERE username = ? AND password = ?";
$stmt = $db->prepareStatement($sql);
$db->bindArray($stmt, array('s','s'), array($Input_username, $Input_password));
$db->executeStatement($stmt);
$result = $db->getResult($stmt);

if($result){
// starts new session
$_SESSION['Input_username'] = $Input_username;
$_SESSION['User_ID'] = $result[0]['uid'];
$_SESSION['isAdmin'] = $result[0]['admin'];
header("Location: index.php");

}else {
	echo "<script>alert('Your login account information is incorrect!');history.back();</script>";
}
?>



