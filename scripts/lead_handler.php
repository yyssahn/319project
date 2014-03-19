<?php
include('database_helper.php');

// Variables for inserting into database
$referral = $mandate = $focus = $activities = '';
//=========================================================================================================================
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
//=========================================================================================================================
$db = new DatabaseHelper();

// Get pid to be associated with lead
$sql = "SELECT pid FROM CommunityPartner WHERE community_partner = ? AND contact_name = ?";
$stmt = $db->prepareStatement($sql);
$params = array($_POST['partner'], $_POST['contact_name']);
$param_types = array('s', 's');
$db->bindArray($stmt, $param_types, $params);
$db->executeStatement($stmt);
$pid_results = $db->getResult($stmt);

// If community partner exists, use its pid, else insert new community partner and use it's new pid
if($pid_results == NULL){
	$sql = "INSERT INTO CommunityPartner(community_partner, contact_name, email, phone) VALUES(?,?,?,?)";
	$params = array($_POST['partner'], $_POST['contact_name'], $_POST['phone'], $_POST['email']);
	$stmt = $db->prepareStatement($sql);
	$param_types = array('s', 's', 's', 's');
	$db->bindArray($stmt, $param_types, $params);
	$db->executeStatement($stmt);
	
	$sql = "SELECT pid FROM CommunityPartner WHERE community_partner = ? AND contact_name = ?";
	$stmt = $db->prepareStatement($sql);
	$params = array($_POST['partner'], $_POST['contact_name']);
	$param_types = array('s', 's');
	$db->bindArray($stmt, $param_types, $params);
	$db->executeStatement($stmt);
	$pid_results = $db->getResult($stmt);
	$pid = $pid_results[0]['pid'];
}
else{ 
	$pid = $pid_results[0]['pid'];
}
//=========================================================================================================================
// Prepare statement
$sql = "INSERT INTO CBEL_Lead(pid, lead_name, description, idea_type, referral, mandate, focus, main_activities, location, 
														disciplines, timeframe, status) 
									VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $db->prepareStatement($sql);

// Set array of parameters to be bound
$params = array();
array_push($params, $pid, $_POST['lead_name'], $_POST['description'], $_POST['idea_type'], $referral, $mandate, $focus, 		
					$activities, $_POST['location'], $_POST['disciplines'], $_POST['timeframe'], $_POST['status']);	

// Set array of types of parameters to be bound				
$param_types = array();
$param_types[0] = 'i';
for($i=1; $i<12; $i++)
	$param_types[] = 's'; // s = strung
	
// Bind parameters and execute statement	
$db->bindArray($stmt, $param_types, $params);
$db->executeStatement($stmt);
?> 