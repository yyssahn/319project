<?php
include('database_helper.php');

// Variables for inserting into database
$referral = $mandate = $focus = $activities = NULL;

// Take each array form each multi-select box in form and combine selected options into comma separated string
$i=0;
for(; $i<count($_POST['referral'])-1; $i++){
	$referral .= $_POST['referral'][$i].", ";
}
$referral .= $_POST['referral'][$i];

$i=0;
for(; $i<count($_POST['mandate'])-1; $i++){
	$mandate .= $_POST['mandate'][$i].", ";
}
$mandate .= $_POST['mandate'][$i];

$i=0;
for(; $i<count($_POST['focus'])-1; $i++){
	$focus .= $_POST['focus'][$i].", ";
}
$focus .= $_POST['focus'][$i];

$i=0;
for(; $i<count($_POST['activities'])-1; $i++){
	$activities .= $_POST['activities'][$i].", ";
}
$activities .= $_POST['activities'][$i];


$db = new DatabaseHelper();

// Get pid to be associated with lead
$sql = "SELECT pid FROM CommunityPartner WHERE community_partner = ? AND contact_name = ?";
$params = array($_POST['partner'], $_POST['contact_name']);
$stmt = $db->prepareStatement($sql);
$param_types = array('s', 's');
$db->bindArray($stmt, $param_types, $params);
$db->executeStatement($stmt);
$pids = $db->getArrayResult();
var_dump($pids);
/*
// Create query and array of parameters and prepare statement
$sql = "INSERT INTO CBEL_Lead(pid, lead_name, description, idea_type, referral, mandate, focus, main_activities, location, 
														disciplines, timeframe, status) 
									VALUES(2, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$params = array();
array_push($params, $_POST['lead_name'], $_POST['description'], $_POST['idea_type'], $referral, $mandate, $focus, $activities, 									$_POST['location'], $_POST['disciplines'], $_POST['timeframe'], $_POST['status']);									
$stmt = $db->prepareStatement($sql);

// Set types of each parameter
$param_types = array();
for($i=0; $i<11; $i++)
	$param_types[] = 's'; // s = strung
	
// Bind parameters and execute statement	
$db->bindArray($stmt, $param_types, $params);
$db->executeStatement($stmt);
*/
?> 