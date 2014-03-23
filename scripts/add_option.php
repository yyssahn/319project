<?php
include('database_helper.php');

// Connecting to database server
$DBServer = "localhost";
$DBUser = "root";
$DBPass = "";
$DBName = "cbel_db";
		 
// Connect to database
$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

if($conn->connect_error)
	trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);

// Query Database for list of Options
$sql = "SELECT iid,".$_GET['category']." FROM categoryoptions WHERE ".$_GET['category']." IS NULL";
$result = $conn->query($sql);

// Fetching matching username and password from the sql result 
$row = mysqli_fetch_array($result);

$iid = $row[0];

$sql = "UPDATE categoryoptions
SET ".$_GET['category']."='".$_GET['optionName']."'
WHERE iid='".$iid."';";
echo $sql;
$result = $conn->query($sql);
    
// failed result what happens?

// if succeeds go back to admin panel
header("Location: index.php?content=admin");
die();
?>