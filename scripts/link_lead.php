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
$sql = "INSERT INTO linked_ids (lid_main,lid_link)
VALUES (".$_GET['main'].",".$_GET['link'].");";
$result = $conn->query($sql);
    
// failed result what happens?

// if succeeds go back to admin panel
header("Location: index.php?content=lead_edit&lid=".$_GET['main']);
die();
?>


