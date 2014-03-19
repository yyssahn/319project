 <?php

session_start();

// Input username and password
$Input_username = $_POST["username"];
$Input_password = $_POST["password"];


// Connecting to database server
$DBServer = "localhost";
$DBUser = "root";
$DBPass = "";
$DBName = "cbel_db";
		 
// Connect to database
$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

if($conn->connect_error)
	trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
		
// Query database
$sql = "SELECT * 
		FROM user 
		WHERE username = '$Input_username' AND password = '$Input_password'";

$result = $conn->query($sql);

// Fetching matching username and password from the sql result 
$row = mysqli_fetch_array($result);

// If the username and password are matched correctly, then the result should have one user tuple (should not be NULL)
if($row) {
	// starts new session
	$_SESSION['Input_username'] = $Input_username;
	$_SESSION['User_ID'] = $row[0];
	header("Location: index.php");

}else {
	echo "<script>alert('Your login account information is incorrect!');history.back();</script>";
}

?>



