<div class="page-header">
	<h2>Leads Mother Fucker!</h2>
</div>

<?php
include('database_helper.php');

// Connect to database
$db = new DatabaseHelper();
	
if(isset($_POST['submit'])){
	$query = "SELECT lid, lead_name, description FROM cbel_lead WHERE";

	// Need to add community partner search
	$subquery = NULL;
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
							?>
									<tr class='info' onmouseover="this.style.cursor='pointer' " 
										onclick="window.location='index.php?content=lead_edit&lid=<?php echo htmlspecialchars($lid); ?>'">
										<td><?php print $row['lead_name']; ?></td><td><?php print $row['description'] ?></td>
									</tr>
							<?php
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
		<div class="well">
			<div class="row clearfix">
				<div class="col-md-2">Community Partner:</div>
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
				
				<div class="col-md-2">Idea Name:</div>
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
				<div class="col-md-2">Idea Type:</div>
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
			
				<div class="col-md-2">Possible Program Referral:</div>
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
				<div class="col-md-2">Organization's Mandate:</div>
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
				
				<div class="col-md-2">Focus Area:</div>
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
				<div class="col-md-2">Main Activities:</div>
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
				
				<div class="col-md-2">Delivery Location:</div>
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
				<div class="col-md-2">Possible Disciplines:</div>
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
				
				<div class="col-md-2">Timeframe:</div>
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
				<div class="col-md-2">Current Status:</div>
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