<?php
include('database_helper.php');

$dbhelp = new DatabaseHelper();

$uid = $_SESSION['User_ID'];

function deleteAccount($db, $uid){
	return $result = $db -> query("DELETE FROM user WHERE (uid =  '$uid')");
}

//Updates everything other than the user.
function updateInfo($db, $uid, $f, $l, $ph, $e){
	$query = "UPDATE user 
		SET firstname = ?, lastname = ?, phonenumber = ?, email = ?
		WHERE (uid = ?)";
	$stmt = $db -> prepareStatement($query);

	$params = array($f, $l, $ph, $e,$uid, );
	$param_types = array('s', 's', 's', 's', 'i');

	$db->bindArray($stmt, $param_types, $params);
	$db->executeStatement($stmt);
}

function samePassword($pass, $confPass) {
    return ($pass == $confPass && $pass != NULL);
}

//Check old pass is correct
function correctOldPass($dbhelp, $id, $old){
	$sql = "SELECT username FROM User WHERE uid = ? AND password = ?";
	$stmt = $dbhelp->prepareStatement($sql);
	
	$params = array($id, $old);
	$param_types = array('i', 's');
	$dbhelp->bindArray($stmt, $param_types, $params);
	$dbhelp->executeStatement($stmt);
	$result = $dbhelp->getResult($stmt);
	return ($result != NULL);
}

//Update password in database
function updatePass($dbhelp, $uid, $p){
	$query = "UPDATE user 
		SET password = ?
		WHERE (uid = ?)";
	$stmt = $dbhelp -> prepareStatement($query);

	$params = array($p, $uid);
	$param_types = array('s', 'i');
	$dbhelp->bindArray($stmt, $param_types, $params);
	$dbhelp->executeStatement($stmt);
}

//Delete account
if (array_key_exists("delSubmit", $_POST)){
	if(deleteAccount($conn, $uid)){
		session_destroy();
		header('Location: logout.php');
	}
}

//Update general info.
if(array_key_exists("Usubmit", $_POST)){
	$f = $_POST['fpartner'];	$l = $_POST['lpartner'];
	$p = $_POST['ppartner'];	$e = $_POST['epartner'];

	updateInfo($dbhelp, $uid, $f, $l, $p, $e );
}

$sql = "SELECT username,firstname,lastname,phonenumber,email FROM user WHERE uid = ?";
$stmt = $dbhelp->prepareStatement($sql);
$dbhelp->bindParameter($stmt, 'i', $uid);
$dbhelp->executeStatement($stmt);
$row = $dbhelp->getResult($stmt);

//Get all information about the account.
$fn = $row[0]['firstname'];
$ln = $row[0]['lastname'];
$ph = $row[0]['phonenumber'];
$e = $row[0]['email'];
$u = $row[0]['username'];

//Update Password
if(array_key_exists("Psubmit", $_POST)){
	$old_pass = $_POST["Opartner"];
	$new_pass = $_POST["Ppartner"];

	if(samePassword($new_pass, $_POST["CPpartner"])){
		if(correctOldPass($dbhelp, $uid, $old_pass)){
			updatePass($dbhelp, $uid, $new_pass);
			echo "UPDATED SUCCESFULLY!!!!";
		}
		else
			echo "YOU FUCKING STUPID.";
	}
	else
		echo "YOU STUPID.";
}
?>

<div class="page-header">
	<h2>Settings Mother Fucker!</h2>
</div>
<!-- Need to SHOW PROPER ERROR MESSAGES ! NOT JUST U STUPID! 
	Need to add checks for phone and email. -->
<form method = "POST" action = "index.php?content=settings">
<div class="well">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label">Username:</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="partner" placeholder="Enter Text"
				value="<?php echo htmlspecialchars($u);?>" readonly>					
			</div>
		</div>
	</div>

	<br>

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label">First Name:</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="fpartner" placeholder="Enter Text"
				 value="<?php echo htmlspecialchars($fn);?>">
			</div>
		</div>
	</div>
	
	<br>

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label">Last Name:</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="lpartner" placeholder="Enter Text"
				 value="<?php echo htmlspecialchars($ln);?>">
			</div>
		</div>
	</div>
	
	<br>

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label">Phone:</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="ppartner" placeholder="Enter Text"
				value="<?php echo htmlspecialchars($ph);?>">					
			</div>
		</div>
	</div>
	
	<br>
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label">Email:</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="epartner" placeholder="Enter Text"
				value="<?php echo htmlspecialchars($e);?>">
			</div>
		</div>
	</div>
	
	<br>
		<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label"></label>
			<div class="col-md-8">
				<input type="submit" class="btn btn-large btn-primary pull-right" name="Usubmit" 
				value="Update Information">				
			</div>
		</div>
	</div>
	<br>
	
	<p class="text-center" ><strong>TO CHANGE YOUR PASSWORD ENTER THE FOLLOWING FIELDS</strong></p>
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label">Old Password:</label>
			<div class="col-md-8">
				<input type="password" class="form-control" name="Opartner" placeholder="Enter Text">					
			</div>
		</div>
	</div>
	<br>
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label">Password:</label>
			<div class="col-md-8">
				<input type="password" class="form-control" name="Ppartner" placeholder="Enter Text">					
			</div>
		</div>
	</div>
	
	<br>
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label">Confirm Password:</label>
			<div class="col-md-8">
				<input type="password" class="form-control" name="CPpartner" placeholder="Enter Text">					
			</div>
		</div>
	</div>
	
	<br>

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<label for="partner" class="col-md-3 control-label"></label>
			<div class="col-md-8">
				<input type="submit" class="btn btn-large btn-primary pull-right" name="Psubmit" 
				value="Update Password">		
				<div class="col-md-8 col-md-pull-5">
				<input type="submit" class="btn btn-large btn-primary pull-left" name="delSubmit" value="Delete Account">			
			</div>		
			</div>
		</div>
	</div>

	<br>

	</form>
</div>