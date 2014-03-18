<?php
	include('database_helper.php');
	
	$db = new DatabaseHelper();
	
	// Create query and array of parameters and prepare statement
	$sql = "INSERT INTO CBEL_Lead(pid, idea_name, description, idea_type, referral, mandate, focus, main_activities, location, 
															disciplines, timeframe, status) 
										VALUES(2, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

	$params = array();
	array_push($params, $_POST['lead_name'], $_POST['description'], $_POST['idea_type'], $_POST['referral'], $_POST['mandate'],
										$_POST['focus'], $_POST['activities'], $_POST['location'], $_POST['disciplines'], $_POST['timeframe'],
										$_POST['status']);									
	$stmt = $db->prepareStatement($sql);
	
	// Set types of each parameter
	$param_types = array();
	for($i=0; $i<11; $i++)
		$param_types[] = 's'; // s = strung
		
	// Bind parameters and execute statement	
	$db->bindArray($stmt, $param_types, $params);
	$db->executeStatement($stmt);
?> 