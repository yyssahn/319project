<?php
error_reporting(0);
include('database_helper.php');

$db = new DatabaseHelper();

// Variables for inserting into database
$referral = $mandate = $focus = $activities = 		$location = $disciplines = $startdate = $enddate=NULL;

if(array_key_exists("delete", $_POST)){
	$sql = "DELETE FROM CBEL_LEAD WHERE lid = ?";
	$stmt = $db->prepareStatement($sql);
	$db->bindParameter($stmt, 'i', $_SESSION['lid']);
	$db->executeStatement($stmt);
	
	if($db->getAffectedRows($stmt) > 0){
		$sql = "UPDATE User
					SET activity_count = activity_count + 1
					WHERE uid=?";
		$stmt = $db->prepareStatement($sql);
		$db->bindParameter($stmt, 'i', $_SESSION['User_ID']);
		$db->executeStatement($stmt);
?>
		<div class='alert alert-success'>Lead Successfully Deleted</div>
		<div class="row">
			<div class="col-md-offset-10">
				<a href="index.php?content=leads" class="btn btn-large btn-success">Edit Another Lead</a>
			</div>
		</div>
<?php
	}
	else{
		print "<div class='alert alert-danger'>Something Went Wrong. Lead Not Deleted</div>";
	}
}
else{				
	//=======================================================================================================================
	// Take each array from each multi-select box in form and combine selected options into comma separated string
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

	// To get rid of warnings
	if(isset($_POST['delivery'])){
		$location = $_POST['delivery'];
	}
	if(isset($_POST['disciplines'])){
		$disciplines = $_POST['disciplines'];
	}
	if(isset($_POST['startdate'])){
		$startdate = $_POST['startdate'];
	}
	if(isset($_POST['enddate'])){
		$enddate=$_POST['enddate'];
	}
	//=======================================================================================================================
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
	//=======================================================================================================================
	// Prepare statement
	if($_SESSION['lid'] == NULL){
		$sql = "INSERT INTO CBEL_Lead(pid, lead_name, description, idea_type, referral, mandate, focus, main_activities, location, 	
						disciplines, startdate,enddate, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
						
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
		$sql = "UPDATE CBEL_Lead 
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

	if($db->getAffectedRows($stmt) > 0){
		$sql = "UPDATE CBEL_Lead AS L, User AS U
					SET L.activity_count = L.activity_count + 1, 
							U.activity_count = U.activity_count + 1
					WHERE L. lid=? AND U.uid=?";
		$stmt = $db->prepareStatement($sql);
		$db->bindArray($stmt, array('i' , 'i'), array($_SESSION['lid'], $_SESSION['User_ID']));
		$db->executeStatement($stmt);
		
		$_SESSION['lid'] = NULL; // Makes sure lead is not visible when creating a new lead
	?>
		<div class="alert alert-success">Lead Successfully Updated</div>
		<div class="row">
			<div class="col-md-offset-10">
			<a href='index.php?content=leads' class='btn btn-large btn-success'>Edit Another Lead</a>
			</div>
		</div>
	<?php
	}
	else if ($db->getAffectedRows($stmt) == 0){
	?>
		<div class="alert alert-warning">You Did Not Change Anything.  No Leads Were Updated</div>
		<div class="row">
			<div class="col-md-offset-10">
				<a href='index.php?content=leads' class='btn btn-large btn-success'>Edit Another Lead</a>
			</div>
		</div>
	<?php
	}
	else{
	?>
		<div class="alert alert-danger">Something Went Wrong.  No Leads Were Updated</div>
		<div class="row">
			<div class="col-md-offset-10">
				<a href='index.php?content=leads' class='btn btn-large btn-success'>Edit Another Lead</a>
			</div>
		</div>
	<?php
	}
}

$db->closeConnection($db);
?> 