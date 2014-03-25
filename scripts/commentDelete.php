<?php
include ('database_helper.php');
$selectedCID = $_GET["commentID"];
$selectedLeadID = $_GET["selectedLeadID"];

echo $selectedCID;
echo $selectedLeadID;

// Connect to database
$db = new DatabaseHelper();
	
// Get  category options
$sql = "DELETE * FROM comment WHERE cid = '$selectedCID'";
$s = $db->prepareStatement($sql);
$db->executeStatement($s);

require_once $_SERVER['/project/scripts/index.php?content=lead_edit&lid='.$selectedLeadID.''];





?>