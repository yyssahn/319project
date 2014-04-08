<div class="page-header">
	<h2>Lead Details Page</h2>
</div>
<?php

include('database_helper.php');

if(isset($_GET['lid'])){
	$db = new DatabaseHelper();

	//Copy from lead_edit.php
	$lidNotif = $_GET["lid"];
	$seenNotif = 0;
	if (isset($_GET["seen"]))
		$seenNotif = $_GET["seen"];

	if($seenNotif == 1)
		$nh->turnoff($_SESSION["User_ID"],$lidNotif);


	$sql = "SELECT * FROM cbel_lead WHERE lid=?";
	$stmt = $db->prepareStatement($sql);
	$db->bindParameter($stmt, 'i', $_GET['lid']);
	$db->executeStatement($stmt);
	$lead_info = $db->getResult($stmt);

	if($lead_info == NULL){
		print("Failure");
	}
	else{
		$sql = "SELECT * FROM communitypartner WHERE pid=?";
		$stmt = $db->prepareStatement($sql);
		$db->bindParameter($stmt, 'i', $lead_info[0]['pid']);
		$db->executeStatement($stmt);
		$partner_info = $db->getResult($stmt);
?>
		<div class="well" style="padding-top:0px; padding-bottom:5px">
		<h3><strong><?php print $lead_info[0]['lead_name']; ?></strong></h3>
		</div>
		
		<br />
		
		<h4>Community Partner</h4>
		<hr />
		<div class="well">
			<div class="row" style="padding-top:10px; padding-bottom:10px">
				<label class="col-md-2" style="font-size: 1em"><strong>Community Partner:</strong></label>
				<div class="col-md-4">
					<?php	print $partner_info[0]['community_partner']; ?>
				</div>
				
				<label class="col-md-2" style="font-size: 1em"><strong>Contact Name:</strong></label>
				<div class="col-md-4">
					<?php print $partner_info[0]['contact_name'];?>
				</div>
			</div>
		
			<div class="row" style="padding-top:10px; padding-bottom:10px">
				<label class="col-md-2" style="font-size: 1em"><strong>Contact Phone:</strong></label>
				<div class="col-md-4">
					<?php print $partner_info[0]['phone'];?>
				</div>
			
				<label class="col-md-2" style="font-size: 1em"><strong>Contact Email:</strong></label>
				<div class="col-md-4">
					<?php print $partner_info[0]['email'];?>
				</div>
			</div>
		</div>
		
		<h4>Lead</h4>
		<hr />
		<div class="well">
			<div class="row" style="padding-top:10px; padding-bottom:10px">
				<label class="col-md-2" style="font-size: 1em"><strong>Description:</strong></label>
				<div class="col-md-4">
					<?php print $lead_info[0]['description'];?>
				</div>
				
				<label class="col-md-2" style="font-size: 1em"><strong>Idea Type:</strong></label>
				<div class="col-md-4">
					<?php print $lead_info[0]['idea_type'];?>
				</div>
			</div>
			
			<div class="row" style="padding-top:10px; padding-bottom:10px">
				<label class="col-md-2" style="font-size: 1em"><strong>Possible Program Referral:</strong></label>
				<div class="col-md-4">
					<?php 
						$tok = strtok($lead_info[0]['referral'], ",");
						
						while($tok){
							print $tok."<br />";
							$tok = strtok(",");
						}
					?>
				</div>
				
				<label class="col-md-2" style="font-size: 1em"><strong>Ogranization's Mandate:</strong></label>
				<div class="col-md-4">
					<?php 
						$tok = strtok($lead_info[0]['mandate'], ",");
						
						while($tok){
							print $tok."<br />";
							$tok = strtok(",");
						}
					?>
				</div>
			</div>
			
			<div class="row" style="padding-top:10px; padding-bottom:10px">
				<label class="col-md-2" style="font-size: 1em"><strong>Focus Area:</strong></label>
				<div class="col-md-4">
					<?php 
						$tok = strtok($lead_info[0]['focus'], ",");
						
						while($tok){
							print $tok."<br />";
							$tok = strtok(",");
						}
					?>
				</div>
				
				<label class="col-md-2" style="font-size: 1em"><strong>Main Activites:</strong></label>
				<div class="col-md-4">
					<?php 
						$tok = strtok($lead_info[0]['main_activities'], ",");
						
						while($tok){
							print $tok."<br />";
							$tok = strtok(",");
						}
					?>
				</div>
			</div>
			
			<div class="row" style="padding-top:10px; padding-bottom:10px">
				<label class="col-md-2" style="font-size: 1em"><strong>Delivery Location:</strong></label>
				<div class="col-md-4">
					<?php 
						$tok = strtok($lead_info[0]['location'], ",");
						
						while($tok){
							print $tok."<br />";
							$tok = strtok(",");
						}
					?>
				</div>
				
				<label class="col-md-2" style="font-size: 1em"><strong>Disciplines:</strong></label>
				<div class="col-md-4">
					<?php 
						$tok = strtok($lead_info[0]['disciplines'], ",");
						
						while($tok){
							print $tok."<br />";
							$tok = strtok(",");
						}
					?>
				</div>
			</div>
			
			<div class="row" style="padding-top:10px; padding-bottom:10px">
				<label class="col-md-2" style="font-size: 1em"><strong>Current Status:</strong></label>
				<div class="col-md-4">
					<?php print $lead_info[0]['status'];?>
				</div>
				
				<label class="col-md-2" style="font-size: 1em"><strong>Start Date:</strong></label>
				<div class="col-md-4">
					<?php print $lead_info[0]['startdate'];?>
				</div>
			</div>
			
			<div class="row" style="padding-top:10px; padding-bottom:10px">
				<label class="col-md-2" style="font-size: 1em"><strong>End Date:</strong></label>
				<div class="col-md-4">
					<?php print $lead_info[0]['enddate'];?>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-offset-11">
				<a class="btn btn-success btn-sm" href="index.php?content=lead_edit&lid=<?php print $_GET['lid']; ?>">
					Edit Lead
				</a>
			</div>
		</div>
		
		<br />
		
<?php
		//Show comments form
	require_once 'lead_comment.php';
	}
}
else{
	print("No lead information");
}
?>