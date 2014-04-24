 <?php
include('database_helper.php');
$db = new DatabaseHelper();
session_start();

function passCorrect($pass, $hash_pass){
	if ( crypt($pass, $hash_pass) === $hash_pass ) {
		return true;
	}
	return false;
}

// Input username and password
$Input_username = $_POST["username"];
$Input_password = $_POST["password"];

// Get user information
$sql = "SELECT * FROM user WHERE username = ?";
$stmt = $db->prepareStatement($sql);
$db->bindParameter($stmt, 's', $Input_username);
$db->executeStatement($stmt);
$result = $db->getResult($stmt);

if(passCorrect($_POST['password'], $result[0]['password']) == true){
// starts new session
$_SESSION['Input_username'] = $Input_username;
$_SESSION['User_ID'] = $result[0]['uid'];
$_SESSION['isAdmin'] = $result[0]['admin'];
header("Location: index.php");

}else {
	echo "<script>alert('Your login account information is incorrect!');history.back();</script>";
}
?>



