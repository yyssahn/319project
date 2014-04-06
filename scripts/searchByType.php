<?php
session_start();
include('database_helper.php');
$db = new DatabaseHelper();

$searchContent = $_GET['searchContent'];

$sql = "SELECT lid,lead_name,description FROM cbel_lead 
			WHERE lead_name = '$searchContent' OR description LIKE '%$searchContent%'";
$s = $db->prepareStatement($sql);
$db->executeStatement($s);
$perfectlyMatchingLead = $db->getResult($db);

// case1: finds the perfectly matching lead
if($perfectlyMatchingLead != null) {
	$_SESSION['matchings'] = $perfectlyMatchingLead;
}else {
	$sql = "SELECT lid,lead_name,description FROM cbel_lead 
				WHERE soundex(lead_name) = soundex('$searchContent')";
	$s = $db->prepareStatement($sql);
	$db->executeStatement($s);
	$nearlyMatchingLeads = $db->getResult($db);

	// case2: could not find the perfectly matching lead, but closely matching leads are found
	if($nearlyMatchingLeads != null) {
		
		$_SESSION['matchings'] = $nearlyMatchingLeads;

	// case3: finds all the possibly mathcing lead(s)
	}else {
		$token = strtok($searchContent, " ");
		$query = "SELECT lid,lead_name,description FROM cbel_lead WHERE";

		while($token != false) {
			$query = $query." lead_name LIKE '%".$token."%' OR";
			$token = strtok(" ");
		}

		$query = substr_replace($query, "",-2);

		$s = $db->prepareStatement($query);
		$db->executeStatement($s);
		$matchingLeads = $db->getResult($db);

		$_SESSION['matchings'] = $matchingLeads;
	}
}

header('Location: index.php?content=leads&searchByType=true');
?>