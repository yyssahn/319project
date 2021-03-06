<?php
//error_reporting(0);
include('database_helper.php');
//include('notification_helper.php');

$db = new DatabaseHelper();
$nh = new NotificationHelper();

// Variables for inserting into database
$tagSelf = $referral = $mandate = $focus = $activities = $location = $disciplines = $startdate = $enddate=NULL;

if(array_key_exists("delete", $_POST)){
	$sql = "DELETE FROM cbel_lead WHERE lid = ?";
	$stmt = $db->prepareStatement($sql);
	$db->bindParameter($stmt, 'i', $_SESSION['lid']);
	$db->executeStatement($stmt);

	$nh->delLeadTag($_SESSION['lid']);
	
	if($db->getAffectedRows($stmt) > 0){
		$sql = "UPDATE user
					SET activity_count = activity_count + 1
					WHERE uid=?";
		$stmt = $db->prepareStatement($sql);
		$db->bindParameter($stmt, 'i', $_SESSION['User_ID']);
		$db->executeStatement($stmt);
?>
		<div class="alert alert-success" style="margin-top: 50px; font-size: 1.2em">
			Lead Successfully Deleted
		</div>
		<div class="row">
			<div class="col-md-offset-10">
				<a href="index.php?content=leads" class="btn btn-success btn-sm">Edit Another Lead</a>
			</div>
		</div>
<?php
	}
	else{
?>
		<div class="alert alert-danger" style="margin-top: 50px; font-size: 1.2em">
			Something Went Wrong. Lead Not Deleted
		</div>
<?php
	}
}
else{				
	//=======================================================================================================================
	// Take each array from each multi-select box in form and combine selected options into comma separated string
	if(isset($_POST['referral'])){
		$i=0;

		if(strpos($_POST['referral'][0], 'multiselect-all') !== false) {
			$i = 1;
		}
		for(; $i<count($_POST['referral'])-1; $i++){
			$referral .= $_POST['referral'][$i].", ";
		}
		$referral .= $_POST['referral'][$i];
	}

	if(isset($_POST['mandate'])){
		$i=0;

		if(strpos($_POST['mandate'][0], 'multiselect-all') !== false) {
			$i = 1;
		}
		for(; $i<count($_POST['mandate'])-1; $i++){
			$mandate .= $_POST['mandate'][$i].", ";
		}
		$mandate .= $_POST['mandate'][$i];
	}

	if(isset($_POST['focus'])){
		$i=0;

		if(strpos($_POST['focus'][0], 'multiselect-all') !== false) {
			$i = 1;
		}
		for(; $i<count($_POST['focus'])-1; $i++){
			$focus .= $_POST['focus'][$i].", ";
		}
		$focus .= $_POST['focus'][$i];
	}

	if(isset($_POST['activities'])){
		$i=0;

		if(strpos($_POST['activities'][0], 'multiselect-all') !== false) {
			$i = 1;
		}
		for(; $i<count($_POST['activities'])-1; $i++){
			$activities .= $_POST['activities'][$i].", ";
		}
		$activities .= $_POST['activities'][$i];
	}

	// To get rid of warnings
	if(isset($_POST['delivery'])){
		$i=0;

		if(strpos($_POST['delivery'][0], 'multiselect-all') !== false) {
			$i = 1;
		}
		for(; $i<count($_POST['delivery'])-1; $i++){
			$location .= $_POST['delivery'][$i].", ";
		}
		$location .= $_POST['delivery'][$i];
	
	}
	if(isset($_POST['disciplines'])){
		$i=0;

		if(strpos($_POST['disciplines'][0], 'multiselect-all') !== false) {
			$i = 1;
		}

		for(; $i<count($_POST['disciplines'])-1; $i++){
			$disciplines .= $_POST['disciplines'][$i].", ";
		}
		$disciplines .= $_POST['disciplines'][$i];
			}
	if(isset($_POST['startdate'])){
		$startdate = $_POST['startdate'];
	}
	if(isset($_POST['enddate'])){
		$enddate=$_POST['enddate'];
	}
  	if(isset($_POST['Ntag'])){
   		
		if ($_POST['Ntag']==2){
		$tagSelf=2;
		}else{
		$tagSelf=1;
		}
		
		}
	//=======================================================================================================================
	// Get pid to be associated with lead
	$sql = "SELECT pid FROM communitypartner WHERE community_partner = ? AND contact_name = ?";
	$stmt = $db->prepareStatement($sql);
	$params = array($_POST['partner'], $_POST['contact_name']);
	$param_types = array('s', 's');
	$db->bindArray($stmt, $param_types, $params);
	$db->executeStatement($stmt);
	$pid_results = $db->getResult($stmt);

	// If community partner exists, use its pid, else insert new community partner and use it's new pid
	if($pid_results == NULL){
		$sql = "INSERT INTO communitypartner(community_partner, contact_name, email, phone) VALUES(?,?,?,?)";
		$params = array($_POST['partner'], $_POST['contact_name'], $_POST['email'], $_POST['phone']);
		$stmt = $db->prepareStatement($sql);
		$param_types = array('s', 's', 's', 's');
		$db->bindArray($stmt, $param_types, $params);
		$db->executeStatement($stmt);
		
		$sql = "SELECT pid FROM communitypartner WHERE community_partner = ? AND contact_name = ?";
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
	//=======================================================================================================================
	// Prepare statement
	
	if(isset($_SESSION['lid']) == NULL){
	
		$sql = "INSERT INTO cbel_lead(pid, lead_name, description, idea_type, referral, mandate, focus, main_activities, location, 	
						disciplines, startdate,enddate, status, timestamp, creation_date) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,NULL,CURRENT_DATE())";
						
		$stmt = $db->prepareStatement($sql);

		// Set array of parameters to be bound
		$params = array();
		array_push($params, $pid, $_POST['lead_name'], $_POST['description'], $_POST['idea_type'], $referral, $mandate, $focus, 		
							$activities, $location, $disciplines, $startdate,$enddate, $_POST['status']);	

		// Set array of types of parameters to be bound				
		$param_types = array();
		$param_types[0] = 'i';
		for($i=1; $i<13; $i++)
			$param_types[] = 's'; // s = strung
	}
	else if($_SESSION['lid'] != NULL){
		
		$sql = "UPDATE cbel_lead
					SET pid=?, lead_name=?, description=?, idea_type=?, referral=?, mandate=?, focus=?, main_activities=?, 		
						location=?, disciplines=?, startdate=?, enddate=?, status=?
					WHERE lid=?";
					
		$stmt = $db->prepareStatement($sql);
		
		// Set array of parameters to be bound
		$params = array();
		array_push($params, $pid, $_POST['lead_name'], $_POST['description'], $_POST['idea_type'], $referral, $mandate, $focus, 		
							$activities, $location, $disciplines, $startdate, $enddate, $_POST['status'], $_SESSION['lid']);	
							
		// Set array of types of parameters to be bound				
		$param_types = array();
		$param_types[0] = 'i';
		for($i=1; $i<13; $i++)
			$param_types[] = 's'; // s = strung
		$param_types[] = 'i';
	}
		
	// Bind parameters and execute statement	
	$db->bindArray($stmt, $param_types, $params);
	$db->executeStatement($stmt);
	if($tagSelf!=NULL){
	
		if($tagSelf == 1 ){
			
			$nh->turnonTag($_SESSION['User_ID'], $_SESSION['lid']);
			} else
		if($tagSelf == 2){
			$nh->removeTag($_SESSION['User_ID'], $_SESSION['lid']);
		}
	}
	if($db->getAffectedRows($stmt) > 0){
				$sqli = "UPDATE cbel_lead , user  
					 SET cbel_lead.activity_count = cbel_lead.activity_count + 1, user.activity_count = user.activity_count + 1 , 
						cbel_lead.timestamp=CURRENT_TIMESTAMP 
					 WHERE cbel_lead.lid=? AND user.uid=?";
				$stmt3 = $db->prepareStatement($sqli);
				$db->bindArray($stmt3, array('i','i'), array($_SESSION['lid'], $_SESSION['User_ID']));
				
				$db->executeStatement($stmt3);
		
			$nh->turnon($_SESSION['lid']);
		$_SESSION['lid'] = NULL; // Makes sure lead is not visible when creating a new lead
	?>
		<div class="row">
			<div >
				<div class="alert alert-success" style="margin-top: 50px; font-size: 1.2em">
					Lead successfully updated!
				</div>
			</div>
		</div>
		<div class="row">
			<div class="pull-right">
				<a href='index.php?content=leads' class='btn btn-sm btn-primary'>Edit Another Lead</a>
			</div>
		</div>
	<?php
	}
	else if ($db->getAffectedRows($stmt) == 0){
	?>
		<div class="row">
			<div >
				<div class="alert alert-warning" style="margin-top: 50px; font-size: 1.2em">
					You did not change anything. No Leads were updated!
				</div>
			</div>
		</div>
		<div class="row">
			<div class="pull-right">
				<a href='index.php?content=leads' class='btn btn-sm btn-primary'>Edit Another Lead</a>
			</div>
		</div>
	<?php
	}
	else{
	?>
		<div class="row">
			<div >
				<div class="alert alert-error" style="margin-top: 50px; font-size: 1.2em">
					Something went wrong. No Leads were updated!
				</div>
			</div>
		</div>
		<div class="row">
			<div class="pull-right">
				<a href='index.php?content=leads' class='btn btn-sm btn-primary'>Edit Another Lead</a>
			</div>
		</div>
	<?php
	}
}

$db->closeConnection($db);
?> 
