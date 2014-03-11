<h2>Leads Mother Fucker!</h2>

<?php
	if($_POST['submit'] == 'submit'){
		echo "Input submitted mother fucker!";
	}
	else{
		echo "<p><a href='index.php?content=lead_edit' class='btn btn-large btn-success'>Create a Lead</a></p>";
		echo "<hr />";
		// Database credentials
		$DBServer = "localhost";
		$DBUser = "root";
		$DBPass = "";
		$DBName = "cbel_db";
		 
		// Connect to database
		$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
		if($conn->connect_error)
			trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
		
		// Query database
		$sql = "SELECT * FROM CategoryOptions";
		$result = $conn->query($sql);
		
		if($result === false)
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR); 
		else{ 
			$result_array = $result->fetch_all(MYSQLI_ASSOC);
?>
		<!--Options for narrowing search results-->
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
			<div class="jumbotron">
				<div class="row">
					<div class="col-md-2">Client Name:</div>
					<div class="col-md-4">
						<select multiple="multiple" class="form-control" name="client" size="5">
							<option value="client1">Client 1</option>
							<option value="client2">Client 2</option>
							<option value="client3">Client 3</option>
							<option value="client4">Client 4</option>
							<option value="client5">Client 5</option>
							<option value="client6">Client 6</option>
						</select>
					</div>
					
					<div class="col-md-2">Idea Name:</div>
					<div class="col-md-4">
						<select multiple="multiple" class="form-control" name="name" size="5">
							<option value="name1">Name 1</option>
							<option value="name2">Name 2</option>
							<option value="name3">Name 3</option>
							<option value="name4">Name 4</option>
							<option value="name5">Name 5</option>
							<option value="name6">Name 6</option>
						</select>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-2">Idea Type:</div>
					<div class="col-md-4">
						<select multiple="multiple" class="form-control" name="type" size="5">
							<?php
								foreach($result_array as $row){
									if($row['idea_type'] != NULL)
										echo "<option value='{$row['idea_type']}'>".$row['idea_type']."</option>";
								}
							?>
						</select>
					</div>
				
					<div class="col-md-2">Possible Program Referral:</div>
					<div class="col-md-4">
						<select multiple="multiple" class="form-control" name="referral" size="5">
							<?php
								foreach($result_array as $row){
									if($row['referral'] != NULL)
										echo "<option value='{$row['referral']}'>".$row['referral']."</option>";
								}
							?>
						</select>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-2">Organization's Mandate:</div>
					<div class="col-md-4">
						<select multiple="multiple" class="form-control" name="mandate" size="5">
							<?php
								foreach($result_array as $row){
									if($row['mandate'] != NULL)
										echo "<option value='{$row['mandate']}'>".$row['mandate']."</option>";
								}
							?>
						</select>
					</div>
					
					<div class="col-md-2">Focus Area:</div>
					<div class="col-md-4">
						<select multiple="multiple" class="form-control" name="focus" size="5">
							<?php
								foreach($result_array as $row){
									if($row['focus'] != NULL)
										echo "<option value='{$row['focus']}'>".$row['focus']."</option>";
								}
							?>
						</select>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-2">Main Activities:</div>
					<div class="col-md-4">
						<select multiple="multiple" class="form-control" name="activities" size="5">
							<?php
								foreach($result_array as $row){
									if($row['main_activities'] != NULL)
										echo "<option value='{$row['main_activities']}'>".$row['main_activities']."</option>";
								}
							?>
						</select>
					</div>
					
					<div class="col-md-2">Delivery Location:</div>
					<div class="col-md-4">
						<select multiple="multiple" class="form-control" name="delivery" size="5">
							<?php
								foreach($result_array as $row){
									if($row['delivery_location'] != NULL)
										echo "<option value='{$row['delivery_location']}'>".$row['delivery_location']."</option>";
								}
							?>
						</select>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-2">Possible Disciplines:</div>
					<div class="col-md-4">
						<select multiple="multiple" class="form-control" name="disciplines" size="5">
							<?php
								foreach($result_array as $row){
									if($row['disciplines'] != NULL)
										echo "<option value='{$row['disciplines']}'>".$row['disciplines']."</option>";
								}
							?>
						</select>
					</div>
					
					<div class="col-md-2">Timeframe:</div>
					<div class="col-md-4">
						<select multiple="multiple" class="form-control" name="timeframe" size="5">
							<?php
								foreach($result_array as $row){
									if($row['timeframe'] != NULL)
										echo "<option value='{$row['timeframe']}'>".$row['timeframe']."</option>";
								}
							?>
						</select>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-2">Current Status:</div>
					<div class="col-md-4">
						<select multiple="multiple" class="form-control" name="status" size="5">
							<?php
								foreach($result_array as $row){
									if($row['referral'] != NULL)
										echo "<option value='{$row['status']}'>".$row['status']."</option>";
								}
							?>
						</select>
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
<?php 
		$result->free();
		$conn->close();
		}
	} 
?>