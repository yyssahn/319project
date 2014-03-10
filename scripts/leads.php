<h2>Leads Mother Fucker!</h2>

<br />

<p><a href="index.php?content=lead_edit" class="btn btn-large btn-success">Create a Lead</a></p>

<br />

<?php
	if($_POST['submit'] == 'submit'){
		$client=$_POST['client'];
		print $client;
	}
	else{
		$DBServer = "localhost";
		$DBUser = "root";
		$DBPass = "";
		$DBName = "cbel_db";
		
		$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
		
		if($conn->connect_error){
			trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
		}
		
		$sql = "SELECT * FROM CategoryOptions";
		$result = $conn->query($sql);
		
		if($result === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		} 
		else {
			$arr = $result->fetch_all(MYSQLI_ASSOC);
		}
		
		foreach($arr as $row){
			echo $row['idea_type'];
		}
		
?>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
			<div class="input-group">
				<select multiple="multiple" class="form-control" name="client" size="2">
					<option value="client1">Client 1</option>
					<option value="client2">Client 2</option>
					<option value="client3">Client 3</option>
					<option value="client4">Client 4</option>
					<option value="client5">Client 5</option>
					<option value="client6">Client 6</option>
				</select>
			</div>
			
			<div class="input-group">
				<select multiple="multiple" class="form-control" name="type" size="5">
					<?php
					
					?>
				</select>
			</div>
			
			<div class="input-group">
				<select multiple="multiple" class="form-control" name="referral" size="5">
					<?php

					?>
				</select>
			</div>
			
			<p><input type="submit" name="submit" value="Submit"></p>
		   <input type="hidden" name="submit" value="submit">
		</form>

<?php 
	} 
?>