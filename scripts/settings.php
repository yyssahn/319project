<?php
// Database credentials
$DBServer = "localhost";
$DBUser = "root";
$DBPass = "";
$DBName = "cbel_db";
 
// Connect to database
$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

if($conn->connect_errno)
	trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);

$uid = $_SESSION['User_ID'];

$result = $conn->query("SELECT * FROM user WHERE (uid = '$uid')");
$row = mysqli_fetch_array($result);

$n = $row['firstname'] . " " . $row['lastname'];
$ph = $row['phonenumber'];
$e = $row['email'];
$u = $row[1];



?>

<div class="page-header">
	<h2>Settings Mother Fucker!</h2>
</div>
<!-- Need to add change password. 
		Add changing all information that they have.
		Add Delete Account. -->
<form method = "POST" action = "index.php?content=settings">
<div class="well">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label">Name:</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="partner" placeholder="Enter Text"
				 value="<?php echo htmlspecialchars($n);?>">
			</div>
		</div>
	</div>
	
	<br>
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label">Email:</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="partner" placeholder="Enter Text"
				value="<?php echo htmlspecialchars($e);?>">
			</div>
		</div>
	</div>
	
	<br>
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label">Phone:</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="partner" placeholder="Enter Text"
				value="<?php echo htmlspecialchars($ph);?>">					
			</div>
		</div>
	</div>
	
	<br>
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label">Username:</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="partner" placeholder="Enter Text"
				value="<?php echo htmlspecialchars($u);?>">					
			</div>
		</div>
	</div>
	
	<br>
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label">Password:</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="partner" placeholder="Enter Text">					
			</div>
		</div>
	</div>
	
	<br>
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label">Confirm Password:</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="partner" placeholder="Enter Text">					
			</div>
		</div>
	</div>
	
	<br>
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label"></label>
			<div class="col-md-8">
				<input type="submit" class="btn btn-large btn-primary pull-right" name="submit" value="UPDATE">				
			</div>
		</div>
	</div>
</form>
	<br>
<form method = "GET">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label"></label>
			<div class="col-md-8">
				<input type="submit" class="btn btn-large btn-primary pull-right" name="delSubmit" value="Delete Account">			
			</div>
		</div>
	</div>
	</form>

</div>

<?php

function deleteAccount($db, $uid){
	return $result = $db -> query("DELETE FROM user WHERE (uid =  '$uid')");

}


if (array_key_exists("delSubmit", $_GET)){
	if(deleteAccount($conn, $uid)){
		echo "string";
		session_destroy();
		header('Location: logout.php');
	}
}

?>






