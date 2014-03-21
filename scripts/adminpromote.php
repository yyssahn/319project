<?php

// TODO: SECURITY STUFF

// Connect to the Database

$DBServer = "localhost";
$DBUser = "root";
$DBPass = "";
$DBName = "cbel_db";

$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

if($conn->connect_error) {
	trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
}
// Query Database for list of Usernames

$sql = "UPDATE user
SET admin='1'
WHERE username='".$_GET['content']."'";

$result = $conn->query($sql);

// failed result what happens?

// if succeeds go back to admin panel
header("Location: index.php?content=admin");
die();
?>