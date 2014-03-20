<div class="page-header">
	<h2>Leads Mother Fucker!</h2>
</div>

<?php
	include('database_helper.php');
	
		$db = new DatabaseHelper();

	if(isset($_POST['submit'])){
			$query = "SELECT idea_name FROM cbel_lead WHERE";
			$client=NULL;
			$name = NULL;
			$type=NULL;
			$referral=NULL;
			$mandate=NULL;
			$focus=NULL;
			$activities=NULL;
			$delivery=NULL;
			$disciplines=NULL;
			$timeframe=NULL;
			$status=NULL;
			
			if (isset($_POST['name'])){
				foreach($_POST['name'] as $row){
					$query = $query." idea_name LIKE '%".$row."%' OR";	
				}
			}
			if (isset($_POST['type'])){
				foreach($_POST['type'] as $row){
					$query = $query." idea_type LIKE '%".$row."%' OR";	
				}
				print_r ($type);
			}
				if (isset($_POST['referral'])){
				
				foreach($_POST['referral'] as $row){
				$query = $query." referral LIKE '%".$row."%' OR";	
				}
			}
				if (isset($_POST['mandate'])){
				foreach($_POST['mandate'] as $row){
			$query = $query." mandate LIKE '%".$row."%' OR";	
			}
			}
				if (isset($_POST['focus'])){
				foreach($_POST['focus'] as $row){
			$query = $query." focus LIKE '%".$row."%' OR";	
			}
				print_r ($focus);
			}
				if (isset($_POST['activities'])){
				foreach($_POST['activities'] as $row){
				$query = $query." main_activities LIKE '%".$row."%' OR";	
					
			}
				}
				if (isset($_POST['delivery'])){
				foreach($_POST['delivery'] as $row){
					$query = $query." delivery_location LIKE '%".$row."%' OR";	
		
					}
			}
				if (isset($_POST['disciplines'])){
				foreach($_POST['disciplines'] as $row){
$query = $query." disciplines LIKE '%".$row."%' OR";	
					
			}
			}
				if (isset($_POST['timeframe'])){
				foreach($_POST['timeframe'] as $row){
$query = $query." timeframe LIKE '%".$row."%' OR";	
		
				}
				}
				if (isset($_POST['status'])){
				foreach($_POST['status'] as $row){
				$query = $query." status LIKE '%".$row."%' OR";	
		
				}
			}
		
$or = 'OR';			
    if (substr($query, -strlen($or)) === $or){
		$state =substr_replace($query ,"",-2);
//		echo $state;
		$stmt = $db->prepareStatement($state);
		$db->executeStatement($stmt);
		$result = $db->getResult();
		print_r ($result);	
	
	}
			
		
	}
	else{
		echo "<div class='well'><a href='index.php?content=lead_edit' class='btn btn-large btn-success'>Create a Lead</a></div>";
		echo "<hr />";
		
		// Connect to database		
		// Get  category options
		$sql = "SELECT * FROM CategoryOptions";
		$stmt = $db->prepareStatement($sql);
		$db->executeStatement($stmt);
		$categories = $db->getResult();
		
		// Get community partners
		$sql = "SELECT community_partner FROM CommunityPartner";
		$s = $db->prepareStatement($sql);
		$db->executeStatement($s);
		$partners = $db->getResult();
		
		// Get  CBEL lead names
		$sql = "SELECT idea_name FROM CBEL_Lead";
		$s = $db->prepareStatement($sql);
		$db->executeStatement($s);
		$names = $db->getResult();
?>
		<!--Categories  for narrowing search results.  Options are populated from database-->
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
			<div class="well">
				<div class="row clearfix">
					<div class="col-md-2">Community Partner:</div>
					<div class="col-md-4">
						<select multiple="multiple" class="form-control" name="client[]" size="5">
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
									if($row['idea_name'] != NULL)
										echo "<option value='{$row['idea_name']}'>".$row['idea_name']."</option>";
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