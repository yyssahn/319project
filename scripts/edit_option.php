<?php

session_start();
if ($_SESSION['isAdmin']) {
    
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

$category = filter_var($_GET['category'], FILTER_SANITIZE_SPECIAL_CHARS);
$optionName = filter_var($_GET['option'], FILTER_SANITIZE_SPECIAL_CHARS);
$newOptionName = filter_var($_GET['newOptionName'], FILTER_SANITIZE_SPECIAL_CHARS);

// Query Database for list of Options

$sql = "UPDATE categoryoptions SET ".$category." = '".$newOptionName."' WHERE ".$category." = '".$optionName."';";
$result = $conn->query($sql);

// failed result what happens?

// if succeeds go back to admin panel
header("Location: index.php?content=admin");
die();

} else { echo "ACCESS DENIED"; }
?>