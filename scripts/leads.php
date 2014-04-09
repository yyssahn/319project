<div class="page-header">
	<h2>Lead Search Page</h2>
</div>

<?php 
include('database_helper.php');

// Connect to database
$db = new DatabaseHelper();
		
// before searching step:
if(!isset($_POST['submit']) && !isset($_GET['searchByType'])) {

	// Get  category options
	$sql = "SELECT * FROM categoryoptions";
	$stmt = $db->prepareStatement($sql);
	$db->executeStatement($stmt);
	$categories = $db->getResult($db);
	
	// Get community partners
	$sql = "SELECT DISTINCT community_partner FROM communitypartner 
				ORDER BY length(community_partner), community_partner";
	$s = $db->prepareStatement($sql);
	$db->executeStatement($s);
	$partners = $db->getResult($db);
	
	// Get  CBEL lead names
	$sql = "SELECT lead_name FROM cbel_lead";
	$s = $db->prepareStatement($sql);
	$db->executeStatement($s);
	$names = $db->getResult($db);
	
?>
	<!--Categories  for narrowing search results.  Options are populated from database-->
	<form id="forms"action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">	
		<div class="well">
			<div class="row clearfix" style="padding-top:10px; padding-bottom:10px">
				<label for="partner" class="col-md-2 control-label">Community Partner:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="multiselect" id="widebutton" name="partner[]">
						<?php
							foreach($partners as $row){
		
								if($row['community_partner'] != NULL) {
									$tempCommunityPartner = htmlentities($row['community_partner']);
									$communityPartner = htmlspecialchars($tempCommunityPartner, ENT_QUOTES);
									echo "<option value='{$communityPartner}'>".$row['community_partner']."</option>";
								}
							}
						?>
					</select>
				</div>
				
				<label for="name" class="col-md-2 control-label">Idea Name:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="multiselect" name="name[]">
						<?php
							foreach($names as $row){
								if($row['lead_name'] != NULL)
									echo "<option value='{$row['lead_name']}'>".$row['lead_name']."</option>";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row clearfix" style="padding-top:10px; padding-bottom:10px">
				<label for="type" class="col-md-2 control-label">Idea Type:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="multiselect" name="type[]">
						<?php
							foreach($categories as $row){
								if($row['idea_type'] != NULL)
									echo "<option value='{$row['idea_type']}'>".$row['idea_type']."</option>";
							}
						?>
					</select>
				</div>
			
				<label for="referral" class="col-md-2 control-label">Possible Program Referral:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="multiselect" name="referral[]">
						<?php
							foreach($categories as $row){
								if($row['referral'] != NULL)
									echo "<option value='{$row['referral']}'>".$row['referral']."</option>";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row clearfix" style="padding-top:10px; padding-bottom:10px">
				<label for="mandate" class="col-md-2 control-label">Organization's Mandate:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="multiselect" name="mandate[]">
						<?php
							foreach($categories as $row){
								if($row['mandate'] != NULL)
									echo "<option value='{$row['mandate']}'>".$row['mandate']."</option>";
							}
						?>
					</select>
				</div>
				
				<label for="focus" class="col-md-2 control-label">Focus Area:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="multiselect" name="focus[]">
						<?php
							foreach($categories as $row){
								if($row['focus'] != NULL)
									echo "<option value='{$row['focus']}'>".$row['focus']."</option>";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row clearfix" style="padding-top:10px; padding-bottom:10px">
				<label for="activities" class="col-md-2 control-label">Main Activities:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="multiselect" name="activities[]">
						<?php
							foreach($categories as $row){
								if($row['main_activities'] != NULL)
									echo "<option value='{$row['main_activities']}'>".$row['main_activities']."</option>";
							}
						?>
					</select>
				</div>
				
				<label for="delivery" class="col-md-2 control-label">Delivery Location:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="multiselect" name="delivery[]">
						<?php
							foreach($categories as $row){
								if($row['location'] != NULL)
									echo "<option value='{$row['location']}'>".$row['location']."</option>";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row clearfix" style="padding-top:10px; padding-bottom:10px">
				<label for="disciplines" class="col-md-2 control-label">Possible Disciplines::</label>
				<div class="col-md-4">
					<select multiple="multiple" class="multiselect" name="disciplines[]">
						<?php
							foreach($categories as $row){
								if($row['disciplines'] != NULL)
									echo "<option value='{$row['disciplines']}'>".$row['disciplines']."</option>";
							}
						?>
					</select>
				</div>
				
				<label for="status" class="col-md-2 control-label">Current Status:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="multiselect" name="status[]">
						<?php
							foreach($categories as $row){
								if($row['status'] != NULL)
									echo "<option value='{$row['status']}'>".$row['status']."</option>";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row" style="padding-top:10px; padding-bottom:10px">
				<label for="startdate" class="col-md-2 control-label">Starting Date:</label>
					<div class="col-md-4 input-append date" data-date-format="dd-mm-yyyy">
						<input type="text" class="form-control datepicker" name="startdate" id="dpd1">
					</div>
					
					<label for="enddate" class="col-md-2 control-label">Deadline:</label>
					<div class="col-md-4 input-append date" data-date-format="dd-mm-yyyy">
						<input type="text"  class="form-control datepicker" name="enddate" id="dpd2">
					</div>
			</div>
		</div>	
		
		<div class="row clearfix" style="padding-top:10px; padding-bottom:10px">
			<div class="col-md-1 col-md-offset-10">
				<input type="submit" class="btn btn-sm btn-info" name="export" id="export" value="Export" />
				<input type="hidden" name="submit" value="submit" />				
			</div>

			<div class="col-md-offset-11">
				<input type="submit" class="btn btn-primary btn-sm" name="search" value="Search" />
				<input type="hidden" name="submit" value="submit" />
			</div>
		</div>
	</form>

<?php 
}else {	
	// search by filter
	if(isset($_POST['search']) || isset($_POST['export'])) {
		$query = "SELECT lid, lead_name, description FROM cbel_lead WHERE";

		// Need to add community partner search
		$subquery = NULL;
		if(isset($_POST['partner'])){
			$pquery = "SELECT pid FROM communitypartner WHERE";
			$psubquery = '';
			foreach($_POST['partner'] as $row){
				$test =  mysql_real_escape_string($row);
				$psubquery = $psubquery." community_partner = '".$test."' OR";
			}

			if(substr($psubquery, -strlen('OR')) === 'OR'){
				$psubquery = substr_replace($psubquery ,"",-2);
				$pquery .= $psubquery;
			}

			$stmt = $db->prepareStatement($pquery);
			$db->executeStatement($stmt);
			$pid_results = $db->getResult($stmt);
			foreach($pid_results as $pid){
				$subquery = $subquery." pid = ".$pid['pid']." OR";
			}
		}
		// Dynamically create query based on multi-select box choices
		if (isset($_POST['name'])){
			foreach($_POST['name'] as $row){
				$subquery = $subquery." lead_name LIKE '%".$row."%' OR";	
			}
		}
		if (isset($_POST['type'])){
			foreach($_POST['type'] as $row){
				$subquery = $subquery." idea_type LIKE '%".$row."%' OR";	
			}
		}
		if (isset($_POST['referral'])){
			foreach($_POST['referral'] as $row){
				$subquery = $subquery." referral LIKE '%".$row."%' OR";	
			}
		}
		if (isset($_POST['mandate'])){
			foreach($_POST['mandate'] as $row){
				$subquery = $subquery." mandate LIKE '%".$row."%' OR";	
			}
		}
		if (isset($_POST['focus'])){
			foreach($_POST['focus'] as $row){
				$subquery = $subquery." focus LIKE '%".$row."%' OR";	
			}
		}
		if (isset($_POST['activities'])){
			foreach($_POST['activities'] as $row){
				$subquery = $subquery." main_activities LIKE '%".$row."%' OR";		
			}
		}
		if (isset($_POST['delivery'])){
			foreach($_POST['delivery'] as $row){
				$subquery = $subquery." delivery_location LIKE '%".$row."%' OR";	
			}
		}
		if (isset($_POST['disciplines'])){
			foreach($_POST['disciplines'] as $row){
				$subquery = $subquery." disciplines LIKE '%".$row."%' OR";	
			}
		}
		if (isset($_POST['status'])){
			foreach($_POST['status'] as $row){
				$subquery = $subquery." status LIKE '%".$row."%' OR";	
			}
		}
		if ($_POST['startdate'] != "" && $_POST['enddate'] == ""){
			$subquery = $subquery." DATEDIFF('".$_POST['startdate']."',`startdate`) <= 0 OR";
		}else if ($_POST['enddate'] != "" && $_POST['startdate'] == ""){
			$subquery = $subquery." DATEDIFF('".$_POST['enddate']."',`enddate`) >= 0 OR";
		}else if ($_POST['startdate'] != "" && $_POST['enddate'] != ""){
			$subquery = $subquery." (DATEDIFF('".$_POST['startdate']."',`startdate`) <= 0 AND DATEDIFF('".$_POST['enddate'].
			"',`enddate`) >= 0) OR";
		}
		// Removes the trailing WHERE or OR from the query
		if($subquery == NULL)
			$query = substr_replace($query, "", -(strlen(' WHERE')));
		else if(substr($subquery, -strlen('OR')) === 'OR'){
			$subquery = substr_replace($subquery ,"",-2);
			$query .= $subquery;
		}

		// Only show archived or dropped leads if chosen
		if(strpos($query, "Archived") !== false || strpos($query, "Dropped") !== false){
			// Intentionally blank. Don't change query if Archived or Dropped is selected
		}
		else if($query == "SELECT lid, lead_name, description FROM cbel_lead"){
			$query .= " WHERE status != 'Archived'  AND status != 'Dropped'";
		}
		else{
			$query .= " AND status != 'Archived'  AND status != 'Dropped'";
		}

		$stmt = $db->prepareStatement($query);
		$db->executeStatement($stmt);
		$result = $db->getResult($db);

	// search by search bar
	}else { 
		$result = $_SESSION['matchings'];
	}
	
	if($result != NULL){
?>
		<!-- Display search results in table -->
		<div class="well">
			<div class="row clearfix">
				<div class="col-md-10 col-md-offset-1">
					<table class="table table-striped table-hover" style="border: solid #008cba 1px;">
						<?php
							// If Search button is clicked, show table with clickable entries that show lead details
							if(isset($_POST['search'])){
						?>
								<thead>
									<tr style="background-color: #008cba; color: white">
										<th class="col-md-4">Lead Name</th><th>Lead Description</th>
									</tr>
								</thead>
								<tbody>
						<?php
								foreach($result as $row){
									$lid = $row['lid'];
									if($row['lead_name'] != NULL){
						?>
										<tr onmouseover="this.style.cursor='pointer' " 
											onclick="window.location='index.php?content=lead_view&lid=<?php echo htmlspecialchars($lid); ?>'">
											<td><?php print $row['lead_name']; ?></td><td><?php print $row['description'] ?></td>
										</tr>
						<?php
									}
								}
							}
							// If Export button is clicked, show table where entries have check boxes for selecting leads to be exported
							else if(isset($_POST['export'])){
						?>
								<thead>
									<tr style="background-color: #008cba; color: white">
										<th class="col-md-4">Lead Name</th><th>Lead Description</th><th>Export</th>
									</tr>
								</thead>
								<tbody>
								<form onsubmit="getLids(this); return false;">
						<?php
								foreach($result as $row){
									$lid = $row['lid'];
									if($row['lead_name'] != NULL){
						?>
									<tr>
										<td><?php print $row['lead_name']; ?></td>
										<td><?php print $row['description'] ?></td>
										<td><input type="checkbox" name="exLeads[]" value="<?php print $lid; ?>" class="export"></td>
									</tr>
						<?php
									}
								}
							}
							// Display results from search bar 
							else{
						?>
								<thead>
									<tr style="background-color: #008cba; color: white">
										<th class="col-md-4">Lead Name</th><th>Lead Description</th>
									</tr>
								</thead>
								<tbody>
						<?php
								foreach($_SESSION['matchings'] as $row){
									$lid = $row['lid'];
									if($row['lead_name'] != NULL){
						?>
										<tr onmouseover="this.style.cursor='pointer' " 
											onclick="window.location='index.php?content=lead_view&lid=<?php echo htmlspecialchars($lid); ?>'">
											<td><?php print $row['lead_name']; ?></td><td><?php print $row['description'] ?></td>
										</tr>
						<?php
									}
								}
							}
						?>
						</tbody>
					</table>
				</div>
			</div>
				<?php
					if(isset($_POST['export'])){
				?>
						<div class="row">
							<div class="col-md-offset-10">
								<input type="submit" class="btn btn-sm btn-info" value="Export Leads">
							</div>
						</div>
						</form>
						<script>
							function getLids(){
								var checkedValues = $('input:checkbox:checked').map(function(){
									return this.value;
								}).get();
								
								if(checkedValues.length <= 0){
									alert("No leads selected!");
								}
								else{
									exportLead(checkedValues)
								}
							}
							
							function exportLead(lids){
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
					<?php
					}
					?>
		</div>
<?php
	}
	else{
		print "<div class='alert alert-danger' style='font-size:1.1em'>There are no leads that match the given criteria</div>";
	}	
}
?>