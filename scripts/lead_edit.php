<div class="page-header">
	<h2>Lead Edit Page</h2>
</div>

<head>
	<script>
	function focusCommentBox() {
		document.getElementById('commentBoxID').focus();
	}
	</script>
</head>

<?php
	// Connect to database
	include('database_helper.php');

	function isValid($pattern, $value){
		return preg_match($pattern, $value) ? true : false;
	}

	$db = new DatabaseHelper();
	$nh =  new NotificationHelper();

	$phonePattern = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";
	$phoneERR = $emailERR = '';

	$TelepERR = '';
	$lidNotif = $seenNotif = 0;
	if(isset($_GET["lid"])) {
		$lidNotif = $_GET["lid"];
	}

	$lead_info = array();
	$partner_info = array();

	// Get  category options
	$sql = "SELECT * FROM categoryoptions";
	$s = $db->prepareStatement($sql);
	$db->executeStatement($s);
	$categories = $db->getResult($db);

	// Checking whether deleting comment is failed or not
	if(isset($_GET['failed'])) {
		$failedDeleting = $_SESSION['failedDeleting'];
		if($failedDeleting == 1) {
			$_SESSION['failedDeleting'] = 0;

			echo "<script type=\"text/javascript\">\n";
			echo "alert('You are not allowed to delete this comment!');\n";
			echo "</script>\n";			
		}
	}

// Get  category options
$sql = "SELECT * FROM categoryoptions";
$s = $db->prepareStatement($sql);
$db->executeStatement($s);
$categories = $db->getResult($db);

// Get  existing community partners
$sql = "SELECT * FROM communitypartner ORDER BY community_partner";
$s = $db->prepareStatement($sql);
$db->executeStatement($s);
$partners = $db->getResult($db);

// Get lead data if lead exists
if(isset($_GET['lid'])){
	$lid = $_SESSION['lid'] = $_GET['lid']; // lid for lead_handler
	
	$sql = "SELECT * FROM cbel_lead WHERE lid=?";
	$stmt = $db->prepareStatement($sql);
	$db->bindParameter($db, 'i', $_GET['lid']);
	$db->executeStatement($stmt);
	$lead_info = $db->getResult($stmt);

	$sql = "SELECT * FROM communitypartner WHERE pid=?";
	$stmt = $db->prepareStatement($sql);
	$db->bindParameter($db, 'i', $lead_info[0]['pid']);
	$db->executeStatement($stmt);
	$partner_info = $db->getResult($stmt);
	
?>
	<!-- For exporting existing lead to CSV -->
	<div class="well">
		<input type="button" class="btn btn-info btn-sm" value="Export Lead" id="export"  onclick="exportLead()">
		<script>
			function exportLead(){
				var lids = ["<?php print $lid; ?>"];
				$.ajax({
					type: "POST",
					url: "export_handler.php",
					data: {lids: lids},
					success: function(result){
						alert(result);
					}
				});
			}
		</script>
	</div>
<?php
}

// Check input for proper format
if(array_key_exists("submit", $_POST)){
	if(!isValid($phonePattern, $_POST['phone']))
		$phoneERR = "Please use the form XXX-XXX-XXXX";

	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
    	$emailERR = "Please use the form email@domain.ca";
}
?>

<!-- Display lead edit form. Values are pre-populated if lead exists (editing lead), else nothing selected-->
<form name="form"id="form" action="index.php?content=lead_handler" method="POST">
	<h4><strong>Community Partner:</strong></h4>
	<hr />
	
	<!-- User can choose an existing Community Partner, which will automatically fill the partner info with this info -->
	<div class="well">
		<div class="row">
			<label for="existingPartner" class="col-md-2 control-label">Existing Partner:</label>
			<div class="col-md-8">
				<select class="form-control" name="existingPartner" id="existing" placeholder="Select One">
					<?php
						// Populate each option from database. Automatically selects options that are associated with the lead
						print "<option>Please Select One</option>";
						foreach($partners as $row){
							if($row['contact_name'] != NULL){
								echo "<option value='{$row['community_partner']}".','."{$row['contact_name']}".','."{$row['phone']}".','."{$row['email']}' 
											$selected >".$row['community_partner']." - ".
												$row['contact_name']."</option>";
							}
						}
					?>
				</select>
			</div>	
		</div>
	</div>
	
	<!-- Community Partner information -->
	<div class="well">
		<div class="row" style="padding-top:10px; padding-bottom:10px">
			<label for="partner" class="control-label col-md-2">Community Partner:</label>
			<div class="col-md-4 controls">
				<input type="text" class="form-control" name="partner" id="partner" placeholder="Enter Community Partner"
					value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['community_partner']);?>">
			</div>
			
			<label for="contact_name" class="col-md-2 control-label">Contact Name:</label>
			<div class="col-md-4">
				<input type="text" class="form-control" name="contact_name" id="contact_name"placeholder="Enter Contact Name"
					value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['contact_name']);?>">
			</div>
		</div>
		
		<div class="row" style="padding-top:10px; padding-bottom:10px">
			<label for="phone" class="col-md-2 control-label">Contact Phone:</label>
			<div class="col-md-4">
				<input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Valid Phone Number"
					value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['phone']);?>">
				<span class="error"><?php echo $phoneERR;?></span>
			</div>
		
			<label for="email" class="col-md-2 control-label">Contact Email:</label>
			<div class="col-md-4">
				<input type="email" class="form-control" name="email" id="email" placeholder="Enter Valid Email Address"
					value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['email']);?>">
			</div>
			
			<!-- Automatically fill partner information if partner selected from select box -->
			<script>
				var partner = document.getElementById("partner");
				var contact = document.getElementById("contact_name");
				var phone = document.getElementById("phone");
				var email = document.getElementById("email");
				var existingPartner = document.getElementById("existing");

				existingPartner.onchange = function(){
				
					var str = this.value;
					var values = str.split(",");
					
					partner.value = values[0];
					contact.value = values[1];
					phone.value = values[2];
					email.value = values[3];
				}
			</script>
		</div>
	</div>

	<h4><strong>Lead:</strong></h4>
	<hr />
	
	<!-- Lead information -->
	<div class="well">
		<div class="row" style="padding-top:10px; padding-bottom:10px">
			<label for="lead_name" class="col-md-2 control-label">Lead Name:</label>
			<div class="col-md-5">
					<input type="text" class="form-control" name="lead_name" placeholder="Enter a Name for the Lead"
						value="<?php if($lead_info) echo htmlspecialchars($lead_info[0]['lead_name']);?>">
			</div>
		</div>
		
		<div class="row">
			<label for="description" class="col-md-2 control-label">Description:</label>
			<div class="col-md-10">
					<textarea class="form-control" name="description" rows="6" placeholder='Enter a Brief Description of the Lead'><?php if($lead_info) echo htmlspecialchars($lead_info[0]['description']);?></textarea>
			</div>
		</div>
		
		<div class="row" style="padding-top:10px; padding-bottom:10px">
			<label for="idea_type" class="col-md-2 control-label">Idea Type:</label>
			<div class="col-md-4">
				<select class="form-control single" name="idea_type">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['idea_type'], $row['idea_type']) !== false){
								$selected = 'selected';
							}
							
							if($row['idea_type'] != NULL){
								echo "<option value='{$row['idea_type']}' $selected >".$row['idea_type']."</option>";
							}
						}
					?>
				</select>
			</div>
			
			<label for="referral" class="col-md-2 control-label">Possible Program Referral:</label>
			<div class="col-md-4">
				<select multiple="multiple" class="multiselect" name="referral[]" size="5">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['referral'], $row['referral']) !== false){
								$selected = 'selected';
							}
							if($row['referral'] != NULL)
								echo "<option value='{$row['referral']}' $selected >".$row['referral']."</option>";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="row" style="padding-top:10px; padding-bottom:10px">
			<label for="mandate" class="col-md-2 control-label">Organization's Mandate:</label>
			<div class="col-md-4">
				<select multiple="multiple" class="multiselect" name="mandate[]" size="5">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['mandate'], $row['mandate']) !== false){
								$selected = 'selected';
							}
							if($row['mandate'] != NULL)
								echo "<option value='{$row['mandate']}' $selected >".$row['mandate']."</option>";
						}
					?>
				</select>
			</div>
			
			<label for="focus" class="col-md-2 control-label">Focus Area:</label>
			<div class="col-md-4">
				<select multiple="multiple" class="multiselect" name="focus[]" size="5">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['focus'], $row['focus']) !== false){
								$selected = 'selected';
							}
							if($row['focus'] != NULL)
								echo "<option value='{$row['focus']}' $selected >".$row['focus']."</option>";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="row" style="padding-top:10px; padding-bottom:10px">
			<label for="activities" class="col-md-2 control-label">Main Activities:</label>
			<div class="col-md-4">
				<select multiple="multiple" class="multiselect" name="activities[]" size="5">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['main_activities'], $row['main_activities']) !== false){
								$selected = 'selected';
							}
							if($row['main_activities'] != NULL)
								echo "<option value='{$row['main_activities']}' $selected >".$row['main_activities']."</option>";
						}
					?>
				</select>
			</div>
			
			<label for="delivery" class="col-md-2 control-label">Delivery Location:</label>
			<div class="col-md-4">
				<select multiple="multiple" class="multiselect" name="delivery[]" size="5">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['location'], $row['location']) !== false){
								$selected = 'selected';
							}
							if($row['location'] != NULL)
								echo "<option value='{$row['location']}' $selected >".$row['location']."</option>";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="row" style="padding-top:10px; padding-bottom:10px">
			<label for="disciplines" class="col-md-2 control-label">Possible Disciplines:</label>
			<div class="col-md-4">
				<select multiple="multiple" class="multiselect" name="disciplines[]" size="5">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['disciplines'], $row['disciplines']) !== false){
								$selected = 'selected';
							}
							if($row['disciplines'] != NULL)
								echo "<option value='{$row['disciplines']}' $selected >".$row['disciplines']."</option>";
						}
					?>
				</select>
			</div>
			
			<label for="status" class="col-md-2 control-label">Current Status</label>
			<div class="col-md-4">
				<select class="form-control single" name="status">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['status'], $row['status']) !== false){
								$selected = 'selected';
							}
							if($row['status'] != NULL)
								echo "<option value='{$row['status']}' $selected >".$row['status']."</option>";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="row" style="padding-top:10px; padding-bottom:10px">
			<label for="startdate" class="col-md-2 control-label">Starting Date:</label>
			<div class="col-md-4 input-append date" data-date-format="dd-mm-yyyy">
				<input type="text" class="form-control datepicker" name="startdate" id="dpd1"
					value="<?php if($lead_info) echo htmlspecialchars($lead_info[0]['startdate']);?>">
			</div>
			
			<label for="enddate" class="col-md-2 control-label">Deadline:</label>
			<div class="col-md-4 input-append date" data-date-format="dd-mm-yyyy">
				<input type="text"  class="form-control datepicker" name="enddate" id="dpd2"
					<?php if($lead_info) echo 'value="'.htmlspecialchars($lead_info[0]['enddate']).'"';?>>
			</div>
		</div>
		
		<div class="row" style="padding-top:10px; padding-bottom:10px">		
			<label for="yes" class="col-md-2 control-label">Tag Self?:</label>
			<div class="col-md-4">
				<div class="radio-inline">
						<input type="radio" name="Ntag" value="1" <?php
				if($nh->isTag($_SESSION["User_ID"], $lidNotif)){
				?> checked <?php } ?> >Yes &nbsp;&nbsp;&nbsp;
				</div>
				<div class="radio-inline">
						<input type="radio" name="Ntag" value="2"<?php
				if(!($nh->isTag($_SESSION["User_ID"], $lidNotif))){
				?> checked <?php } ?>>No
				</div> 
			</div>
		</div>
	</div>
	
	<div class="row" style="padding-top:10px; padding-bottom:10px">
<?php
	// Delete button only shows up when edititin existing lead, not when adding a new lead
	if(isset($_GET['lid'])){ 
?>
		<div class="col-md-1">
			<input type="submit" class="btn btn-danger btn-sm" name="delete" value="Delete Lead" 
					onclick="return confirm('Are you sure?');">
			<input type="hidden" name="submit" value="submit">
		</div>
<?php
	}
?>
		<div class="col-md-offset-11">
			<input type="submit" class="btn btn-primary btn-sm" name="submit" value="Submit">
				<input type="hidden" name="submit" value="submit">
		</div>
	</div>
</form>

<?php
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//=========================================================================================================================
if (isset($_GET['lid'])) {
	// Show linked leads form
	require_once 'link_lead.php';
	$link = new LinkLead();
	$link->displayLinkForm();
	
	//Show comments form
	require_once 'lead_comment.php';
} 