<?php
include('database_helper.php');

$db = new DatabaseHelper();

// Variables for inserting into database
$referral = $mandate = $focus = $activities = '';
//=========================================================================================================================
// Take each array form each multi-select box in form and combine selected options into comma separated string
if(isset($_POST['referral'])){
$i=0;
for(; $i<count($_POST['referral'])-1; $i++){
	$referral .= $_POST['referral'][$i].", ";
}
$referral .= $_POST['referral'][$i];
}

if(isset($_POST['mandate'])){
$i=0;
for(; $i<count($_POST['mandate'])-1; $i++){
	$mandate .= $_POST['mandate'][$i].", ";
}
$mandate .= $_POST['mandate'][$i];
}
if(isset($_POST['focus'])){
$i=0;
for(; $i<count($_POST['focus'])-1; $i++){
	$focus .= $_POST['focus'][$i].", ";
}
$focus .= $_POST['focus'][$i];
}
if(isset($_POST['activities'])){
$i=0;
for(; $i<count($_POST['activities'])-1; $i++){
	$activities .= $_POST['activities'][$i].", ";
}
$activities .= $_POST['activities'][$i];
}
//=========================================================================================================================
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
	$params = array($_POST['partner'], $_POST['contact_name'], $_POST['email'], $_POST['phone']);
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
if($_SESSION['lid'] == NULL){
	$sql = "INSERT INTO CBEL_Lead(pid, lead_name, description, idea_type, referral, mandate, focus, main_activities, location, 	
					disciplines, timeframe, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
					
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
}
else if($_SESSION['lid'] != NULL){
	$sql = "UPDATE CBEL_Lead 
				SET pid = ?, lead_name = ?, description = ?, idea_type = ?, referral = ?, mandate = ?, focus = ?, main_activities = ?, 		
					location = ?, disciplines = ?, timeframe = ?, status = ?
				WHERE lid = ?";
				
	$stmt = $db->prepareStatement($sql);

	// Set array of parameters to be bound
	$params = array();
	array_push($params, $pid, $_POST['lead_name'], $_POST['description'], $_POST['idea_type'], $referral, $mandate, $focus, 		
						$activities, $_POST['location'], $_POST['disciplines'], $_POST['timeframe'], $_POST['status'], $_SESSION['lid']);	
						
	// Set array of types of parameters to be bound				
	$param_types = array();
	$param_types[0] = 'i';
	for($i=1; $i<12; $i++)
		$param_types[] = 's'; // s = strung
	$param_types[] = 'i';
}
	
// Bind parameters and execute statement	
$db->bindArray($stmt, $param_types, $params);
$db->executeStatement($stmt);
?> 