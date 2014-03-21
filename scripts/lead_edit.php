<div class="page-header">
	<h2>Lead Edit Page Mother Fucker!</h2>
</div>

<?php
	include('database_helper.php');

	$lead_info = array();
	$partner_info = array();
	
	// Connect to database
	$db = new DatabaseHelper();
	
	// Get  category options
	$sql = "SELECT * FROM CategoryOptions";
	$s = $db->prepareStatement($sql);
	$db->executeStatement($s);
	$categories = $db->getResult($db);
	
	// Get lead data if lead exists
	if(isset($_GET['lid'])){
		$sql = "SELECT * FROM CBEL_Lead WHERE lid=?";
		$stmt = $db->prepareStatement($sql);
		$db->bindParameter($db, 'i', $_GET['lid']);
		$db->executeStatement($stmt);
		$lead_info = $db->getResult($stmt);
		
		$sql = "SELECT * FROM CommunityPartner WHERE pid=?";
		$stmt = $db->prepareStatement($sql);
		$db->bindParameter($db, 'i', $lead_info[0]['pid']);
		$db->executeStatement($stmt);
		$partner_info = $db->getResult($stmt);
	}
?>
	<form action="index.php?content=lead_handler" method="POST">
		<h4><strong>Community Partner:</strong></h4>
		<hr />
		<div class="jumbotron">
			<div class="row">
				<label for="partner" class="col-md-2 control-label">Community Partner:</label>
				<div class="col-md-4">
						<input type="text" class="form-control" name="partner" placeholder="Enter Community Partner"
							value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['community_partner']);?>">
				</div>
				
				<label for="contact_name" class="col-md-2 control-label">Contact Name:</label>
				<div class="col-md-4">
						<input type="text" class="form-control" name="contact_name" placeholder="Enter Contact Name"
							value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['contact_name']);?>">
				</div>
			</div>
			
			<div class="row">
				<label for="phone" class="col-md-2 control-label">Contact Phone:</label>
				<div class="col-md-4">
						<input type="text" class="form-control" name="phone" placeholder="Enter Valid Phone Number"
							value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['phone']);?>">
				</div>
			
				<label for="email" class="col-md-2 control-label">Contact Email:</label>
				<div class="col-md-4">
						<input type="email" class="form-control" name="email" placeholder="Enter Valid Email Address"
							value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['email']);?>">
				</div>
			</div>
		</div>

		<h4><strong>Lead:</strong></h4>
		<hr />
		
		<div class="jumbotron">
			<div class="row">
				<label for="lead_name" class="col-md-2 control-label">Lead Name:</label>
				<div class="col-md-4">
						<input type="text" class="form-control" name="lead_name" placeholder="Enter a Name for the Lead"
							value="<?php if($lead_info) echo htmlspecialchars($lead_info[0]['lead_name']);?>">
				</div>
				
				<label for="description" class="col-md-2 control-label">Description:</label>
				<div class="col-md-4">
						<textarea class="form-control" name="description" rows="4" placeholder="Enter a Brief Description of the 
							Lead"><?php if($lead_info) echo htmlspecialchars($lead_info[0]['description']);?></textarea>
				</div>
			</div>
			
			<div class="row">
				<label for="idea_type" class="col-md-2 control-label">Idea Type:</label>
				<div class="col-md-4">
					<select class="form-control" name="idea_type" placeholder="Select One">
						<?php
							echo "<option>".NULL."</option>";
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
								if($row['mandate'] != NULL)
									echo "<option value='{$row['referral']}'>".$row['referral']."</option>";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row">
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
			
			<div class="row">
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
					<select multiple="multiple" class="form-control" name="delivery" size="5">
						<?php
							foreach($categories as $row){
								if($row['delivery_location'] != NULL)
									echo "<option value='{$row['delivery_location']}'>".$row['delivery_location']."</option>";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row">
				<label for="disciplines" class="col-md-2 control-label">Possible Disciplines:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="form-control" name="disciplines" size="5">
						<?php
							foreach($categories as $row){
								if($row['disciplines'] != NULL)
									echo "<option value='{$row['disciplines']}'>".$row['disciplines']."</option>";
							}
						?>
					</select>
				</div>
				
				<label for="timeframe" class="col-md-2 control-label">Timeframe:</label>
				<div class="col-md-4">
					<select class="form-control" name="timeframe">
						<?php
							foreach($categories as $row){
								if($row['timeframe'] != NULL)
									echo "<option value='{$row['timeframe']}'>".$row['timeframe']."</option>";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row">
				<label for="status" class="col-md-2 control-label">Current Status</label>
				<div class="col-md-4">
					<select class="form-control" name="status">
						<?php
							echo "<option>".NULL."</option>";
							foreach($categories as $row){
								if($row['referral'] != NULL)
									echo "<option value='{$row['status']}'>".$row['status']."</option>";
							}
						?>
					</select>
				</div>
				
				<label for="yes" class="col-md-2 control-label">Tag Self?:</label>
				<div class="col-md-4">
					<div class="radio-inline">
							<input type="radio" name="tag" value="1" checked>Yes &nbsp;&nbsp;&nbsp;
					</div>
					<div class="radio-inline">
							<input type="radio" name="tag" value="2">No
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-offset-11">
				<input type="submit" class="btn btn-large btn-primary" name="submit" value="Submit">
				<input type="hidden" name="submit" value="submit">
			</div>
		</div>
	</form>