<div class="page-header">
	<h2>Leads Page</h2>
</div>

<?php
include('database_helper.php');

// Connect to database
$db = new DatabaseHelper();
	
if(isset($_POST['submit'])){
	$query = "SELECT lid, lead_name, description FROM cbel_lead WHERE";

	// Need to add community partner search
	$subquery = NULL;
	if(isset($_POST['partner'])){
		$pquery = "SELECT pid FROM CommunityPartner WHERE";
		$psubquery = '';
		foreach($_POST['partner'] as $row){
			$psubquery = $psubquery." community_partner = '".$row."' OR";
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
	if (isset($_POST['timeframe'])){
		foreach($_POST['timeframe'] as $row){
			$subquery = $subquery." timeframe LIKE '%".$row."%' OR";	
		}
	}
	if (isset($_POST['status'])){
		foreach($_POST['status'] as $row){
			$subquery = $subquery." status LIKE '%".$row."%' OR";	
		}
	}

	// Removes the trailing WHERE or OR from the query
	if($subquery == NULL)
		$query = substr_replace($query, "", -(strlen(' WHERE')));
	else if(substr($subquery, -strlen('OR')) === 'OR'){
		$subquery = substr_replace($subquery ,"",-2);
		$query .= $subquery;
	}

	$stmt = $db->prepareStatement($query);
	$db->executeStatement($stmt);
	$result = $db->getResult($db);
		
	if($result != NULL){
?>
		<div class="well">
			<div class="row clearfix">
				<div class="col-md-10 col-md-offset-1" style="height:40%; overflow:scroll">
					<table class="table table-striped table-hover">
						<thead>
							<tr class="warning"><th>Lead Name</th><th>Lead Description</th></tr>
						</thead>
						<tbody>
							<?php
								foreach($result as $row){
									$lid = $row['lid'];
									if($row['lead_name'] != NULL){
							?>
								<tr class='info' onmouseover="this.style.cursor='pointer' " 
									onclick="window.location='index.php?content=lead_edit&lid=<?php echo htmlspecialchars($lid); ?>'">
									<td><?php print $row['lead_name']; ?></td><td><?php print $row['description'] ?></td>
								</tr>
							<?php
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
<?php
	}
	else{
		print "<div class='alert alert-danger'>There are no leads that match the given criteria</div>";
	}	
}
else{
	// Get  category options
	$sql = "SELECT * FROM CategoryOptions";
	$stmt = $db->prepareStatement($sql);
	$db->executeStatement($stmt);
	$categories = $db->getResult($db);
	
	// Get community partners
	$sql = "SELECT community_partner FROM CommunityPartner";
	$s = $db->prepareStatement($sql);
	$db->executeStatement($s);
	$partners = $db->getResult($db);
	
	// Get  CBEL lead names
	$sql = "SELECT lead_name FROM CBEL_Lead";
	$s = $db->prepareStatement($sql);
	$db->executeStatement($s);
	$names = $db->getResult($db);
?>
	<div class='well'><a href='index.php?content=lead_edit' class='btn btn-large btn-success'>Create a Lead</a></div>
	<hr />
	<!--Categories  for narrowing search results.  Options are populated from database-->
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
		<div class="jumbotron">
			<div class="row clearfix">
				<label for="partner" class="col-md-2 control-label">Community Partner:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="form-control" name="partner[]" size="5">
						<?php
							foreach($partners as $row){
								if($row['community_partner'] != NULL)
									echo "<option value='{$row['community_partner']}'>".$row['community_partner']."</option>";
							}
						?>
					</select>
				</div>
				
				<label for="name" class="col-md-2 control-label">Idea Name:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="form-control" name="name[]" size="5">
						<?php
							foreach($names as $row){
								if($row['lead_name'] != NULL)
									echo "<option value='{$row['lead_name']}'>".$row['lead_name']."</option>";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row clearfix">
				<label for="type" class="col-md-2 control-label">Idea Type:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="form-control" name="type[]" size="5">
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
					<select multiple="multiple" class="form-control" name="referral[]" size="5">
						<?php
							foreach($categories as $row){
								if($row['referral'] != NULL)
									echo "<option value='{$row['referral']}'>".$row['referral']."</option>";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row clearfix">
				<label for="mandate" class="col-md-2 control-label">Organization's Mandate:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="form-control" name="mandate[]" size="5">
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
					<select multiple="multiple" class="form-control" name="focus[]" size="5">
						<?php
							foreach($categories as $row){
								if($row['focus'] != NULL)
									echo "<option value='{$row['focus']}'>".$row['focus']."</option>";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row clearfix">
				<label for="activities" class="col-md-2 control-label">Main Activities:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="form-control" name="activities[]" size="5">
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
					<select multiple="multiple" class="form-control" name="delivery[]" size="5">
						<?php
							foreach($categories as $row){
								if($row['delivery_location'] != NULL)
									echo "<option value='{$row['delivery_location']}'>".$row['delivery_location']."</option>";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row clearfix">
				<label for="disciplines" class="col-md-2 control-label">Possible Disciplines::</label>
				<div class="col-md-4">
					<select multiple="multiple" class="form-control" name="disciplines[]" size="5">
						<?php
							foreach($categories as $row){
								if($row['disciplines'] != NULL)
									echo "<option value='{$row['disciplines']}'>".$row['disciplines']."</option>";
							}
						?>
					</select>
				</div>
				
				<label for="timefram" class="col-md-2 control-label">Timeframe:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="form-control" name="timeframe[]" size="5">
						<?php
							foreach($categories as $row){
								if($row['timeframe'] != NULL)
									echo "<option value='{$row['timeframe']}'>".$row['timeframe']."</option>";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row clearfix">
				<label for="status" class="col-md-2 control-label">Current Status:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="form-control" name="status[]" size="5">
						<?php
							foreach($categories as $row){
								if($row['referral'] != NULL)
									echo "<option value='{$row['status']}'>".$row['status']."</option>";
							}
						?>
					</select>
				</div>
			</div>
		</div>	
		
		<div class="row clearfix">
			<div class="col-md-offset-11">
				<input type="submit" class="btn btn-large btn-primary" name="submit" value="Submit">
				<input type="hidden" name="submit" value="submit">
			</div>
		</div>
	</form>
<?php 
} 
?>