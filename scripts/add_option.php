<?php

session_start();
if ($_SESSION['isAdmin']) {

include('database_helper.php');

// Connecting to database server
$DBServer = "localhost";
$DBUser = "root";
$DBPass = "T*am01tmp!";
$DBName = "cbel_db";
		 
// Connect to database
$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

if($conn->connect_error)
	trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);

$category = filter_var($_GET['category'], FILTER_SANITIZE_SPECIAL_CHARS);
$optionName = filter_var($_GET['optionName'], FILTER_SANITIZE_SPECIAL_CHARS);

// Query Database for list of Options
$sql = "SELECT iid,".$category." FROM categoryoptions WHERE ".$category." IS NULL";
$result = $conn->query($sql);

// Fetching matching username and password from the sql result 
$row = mysqli_fetch_array($result);

if (empty($row)) {
    $sql = "INSERT INTO categoryoptions (".$category.")
VALUES ('".$optionName."');";
    $result = $conn->query($sql);
    
// failed result what happens?

// if succeeds go back to admin panel
header("Location: index.php?content=admin");
die();
} else {

$iid = $row[0];

$sql = "UPDATE categoryoptions
SET ".$category."='".$optionName."'
WHERE iid='".$iid."';";
echo $sql;
$result = $conn->query($sql);
    
// failed result what happens?

// if succeeds go back to admin panel
header("Location: index.php?content=admin");
die();
}

} else { echo "ACCESS DENIED"; }
?>