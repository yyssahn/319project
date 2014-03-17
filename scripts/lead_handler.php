<?php
	/*
	include('database_helper.php');
	
	$db = new DatabaseHelper();
	
	$sql = "INSERT INTO CBEL_Lead(pid, idea_name, description, idea_type, referral, mandate, focus, main_activities, location, 
															disciplines, timeframe, status, ) 
										VALUES(2, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$db->prepareStatement($sql);
	$db->bindParameters('isssssssssss', $par);
	
	foreach($par as $element){
		
		$db->executeStatement();
	}
	*/
	
	
	foreach($_POST as $key=>$value)
			print "$key=$value";
?> 