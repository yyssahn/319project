<?php
include('database_helper.php');

session_start();
if ($_SESSION['isAdmin']) {

// Connect to the Database
$db = new DatabaseHelper();

// Query Database for list of Usernames
$sql = "UPDATE user SET admin='1' WHERE username=?";
$stmt = $db->prepareStatement($sql);
$db->bindParameter($stmt, 's', $_GET['username']);
$db->executeStatement($stmt);

// failed result what happens?

// if succeeds go back to admin panel
header("Location: index.php?content=admin");
die();

} else { echo "ACCESS DENIED"; }
?>