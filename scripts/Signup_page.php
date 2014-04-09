<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Signup Page</title>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../bootstrap/js/jquery-2.1.0.min.js"></script>
	
	<!-- Bootstrap -->
	<link href="../bootstrap/css/bootstrap-3.1.1.css" rel="stylesheet">
	<script src="../bootstrap/js/bootstrap-3.1.1.min.js"></script>
	
	<!-- Validate plugin -->
	<link href="style.css" rel="stylesheet">
	<script src="../bootstrap/js/jquery.validate.js"></script>
	<script src="validator_script.js"></script>	
</head>
<?php

$phonePattern = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";
$user = $PWSRD = $CPWSRD = $Fname = $Lname = $Telep = $Email = "";
$userERR = $PWSRDERR = $CPWSRDERR = $FnameERR = $LnameERR = $TelepERR = $EmailERR = $keyErr = "";

include('database_helper.php');

$dbHelper = new DatabaseHelper();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["Fname"]))
        $FnameERR = "Required";
    else
        $Fname = $_POST["Fname"];

    if (empty($_POST["Lname"]))
        $LnameERR = "Required";
    else
        $Lname = $_POST["Lname"];

    if (empty($_POST["user"]))
        $userERR = "Required";
    else
        $user = $_POST["user"];

    if (empty($_POST["pswd"]))
        $PWSRDERR = "Required";
    else
        $PWSRD = $_POST["pswd"];

    if (empty($_POST["confirmpswd"]))
        $CPWSRDERR = "Required";
    else
        $CPWSRD = $_POST["confirmpswd"];


	if (empty($_POST["pNum"]))
        $TelepERR = "Required";
    else{
        //$Telep = str_replace("-" , "" ,$_POST["pNum"]);
        $Telep = $_POST["pNum"];
        if(!isValid($phonePattern, $Telep)){
        	$TelepERR = "Incorrect Input";
        }
    }

    if (empty($_POST["emailAddr"]))
        $EmailERR = "Required";
    else{
        $Email = filter_var($_POST['emailAddr'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) 
        	$EmailERR = "Email must be of the form: email@domain.ca";
    }
}

// Database credentials
$DBServer = "localhost";
$DBUser = "root";
$DBPass = "";
$DBName = "cbel_db";
$key ="";
 
// Connect to database
$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

if($conn->connect_errno)
	trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);

function samePassword($pass, $confPass) {
        return ($pass == $confPass && $pass != NULL);
}
 
function noUserExists($db,$userE){
	$sql = "SELECT * FROM user WHERE (username = ?)";
	$stmt = $db->prepareStatement($sql);
	$db->bindParameter($stmt, 's', $userE);
	$db->executeStatement($stmt);
	$result = $db->getResult($stmt);

	if(count($result) == 0){
		return true;
	}
	else{	
		return false;
	}
}

function mailExists($db, $mail){
	$sql = "SELECT * FROM user WHERE (email = ?)";
	$stmt = $db->prepareStatement($sql);
	$db->bindParameter($stmt, 's', $mail);
	$db->executeStatement($stmt);
	$result = $db->getResult($stmt);
	
	if(count($result) > 0){
		return true;
	}
	else{	
		return false;
	}
}

function runInsert($db, $u, $p, $f, $l, $ph, $e){
	$query = "INSERT INTO user( username, password, firstname, lastname, phonenumber, email) 
		VALUES(?, ?, ?, ?, ?, ?)";
	$params = array();
	array_push($params, $u, $p, $f, $l, $ph, $e);
	$stmt = $db -> prepareStatement($query);

	$param_types = array();
	array_push($param_types, 's', 's', 's', 's', 's', 's');

	$db->bindArray($stmt, $param_types, $params);
	$db->executeStatement($stmt);
}

//Check if key exists in the database
function checkKey($db, $k){
	$sql = "SELECT count(*) FROM genkeys WHERE unusedkey = ?";
	$stmt = $db->prepareStatement($sql);
	$params = array($k);
	$param_types = array('s');
	$db->bindArray($stmt, $param_types, $params);
	$db->executeStatement($stmt);
	$key_results = $db->getResult($stmt);
	return ($key_results[0]['count(*)'] == 1);
}

// Taranbir commenting this out for now, writing my own
//function deleteKey($db, $key){
//	$db->query("DELETE FROM genkeys WHERE (unusedkey = '$key')");
//	return($db->affected_rows == 1);
//}

function deleteKey($key) {
    $db = new DatabaseHelper();
    $sql = "DELETE FROM genkeys WHERE unusedkey=?";
    $stmt = $db->prepareStatement($sql);
    $db->bindParameter($stmt, 's', $key);
    $db->executeStatement($stmt);
}

function isValid($pattern, $value){
	return preg_match($pattern, $value) ? true : false;
}

if(array_key_exists("createNewACC" , $_POST)){

	if(noUserExists($dbHelper , $user) == true){
	 	if(samePassword($PWSRD, $CPWSRD)){ 
			if( (mailExists($dbHelper, $Email)) == false){
			//echo "$user - Doesn't exist, We are adding it now.";
				$key = $_POST['signupkey'];
				if(checkKey($dbHelper, $key)){
					runInsert($dbHelper, $user, $PWSRD, $Fname, $Lname, $Telep, $Email);
					// if(deleteKey($dbHelper, $key)){
                                        deleteKey($key);
						$genGOO = "Account created successfully.  You will be taken to the login page.";
		    			header('Refresh: 3; login_page.html');
    			}
    			else
    				$genErr = "The key you entered is not valid.
					 Please request a new key from the site administrator";
			}
			else
				$genErr = "The email address you entered is already in use.
					Please enter a different email address.";
		}
		else
			$genErr = "The entered password(s) don't match!";
	}
	else
		$genErr = "That username is already taken. 
					Please enter a new username";
}

?>
	<body>
	
	
		<div class="container" style="overflow:hidden">
		
			<div class="row clearfix">
		<div class="col-md-12 column">
			<img alt="140x140" src="http://www.blisteredthumbs.net/avatars/1301063364.png" height="140" width="140">
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-md-12 column">
			<nav class="navbar navbar-default navbar-inverse" style="background-color: #008cba ; border: #428bca" 
				role="navigation">
				<div class="navbar-header">
					<a class="navbar-brand" style="color:white">Home</a>
				</div>			
			</nav>
			<div class="page-header">
				<h1>
					<span>Sign Up</span>
				</h1>
			</div>
		</div>
	</div>
	<?php
		if(isset($genErr)){
			print "<div class='alert alert-danger' style='font-size:1em'>"
			.$genErr. "</div>";
		}
		if(isset($genGOO)){
			print "<div class='alert alert-success' style='font-size:1em'>"
			.$genGOO. "</div>";
		}

	?>
			
			<h3> Please create an account </h3>
			
			<form id="form" method= "POST" action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
				<div class="well">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<label for="Fname" class="col-md-3 control-label">First Name:</label>
							<div class="col-md-8 controls">
								<input type = "text" class="form-control" name = "Fname" placeholder = "First Name" 
											value="<?php echo htmlspecialchars($Fname);?>">
							</div>
						</div>
					</div>
					
					<div class="row" style="padding-top: 20px">
						<div class="col-md-10 col-md-offset-1">
							<label for="Lname" class="col-md-3 control-label">Last Name:</label>
							<div class="col-md-8 controls">
								<input type = "text" class="form-control" name = "Lname" placeholder = "Last Name"
											value="<?php echo htmlspecialchars($Lname);?>">
							</div>
						</div>
					</div>
					
					<div class="row" style="padding-top: 20px">
						<div class="col-md-10 col-md-offset-1">
							<label for="user" class="col-md-3 control-label">Username:</label>
							<div class="col-md-8 controls">
								<input type = "text" class="form-control" name = "user" placeholder = "Username" autocomplete="off"
											value="<?php echo htmlspecialchars($user);?>">
							</div>
						</div>
					</div>
					
					<div class="row" style="padding-top: 20px">
						<div class="col-md-10 col-md-offset-1">
							<label for="pswd" class="col-md-3 control-label">Password:</label>
							<div class="col-md-8 controls">
								<input type = "password" class="form-control" name = "pswd" placeholder = "Password"/>
							</div>
						</div>
					</div>
					
					<div class="row" style="padding-top: 20px">
						<div class="col-md-10 col-md-offset-1">
							<label for="confimpswd" class="col-md-3 control-label">Confirm Password:</label>
							<div class="col-md-8 controls">
								<input type = "password" class="form-control" name = "confirmpswd" placeholder = "Password"/>
							</div>
						</div>
					</div>
					
					<div class="row" style="padding-top: 20px">
						<div class="col-md-10 col-md-offset-1">
							<label for="partner" class="col-md-3 control-label">E-Mail:</label>
							<div class="col-md-8 controls">
								<input type = "email" class="form-control" placeholder ="E-mail" name = "emailAddr"   
											value="<?php echo htmlspecialchars($Email);?>">
							</div>
						</div>
					</div>
					
					<div class="row" style="padding-top: 20px">
						<div class="col-md-10 col-md-offset-1">
							<label for="pNum" class="col-md-3 control-label">Phone Number:</label>
							<div class="col-md-8 controls">
								<input type = "text" class="form-control" name = "pNum" placeholder ="XXX-XXX-XXXX"
											value="<?php echo htmlspecialchars($Telep);?>">
							</div>
						</div>
					</div>

					<div class="row" style="padding-top: 20px">
						<div class="col-md-10 col-md-offset-1">
							<label for="pNum" class="col-md-3 control-label">Key:</label>
							<div class="col-md-8 controls">
								<input type = "text" class="form-control" name = "signupkey" placeholder ="XXXXXXXX">
							</div>
						</div>
					</div>
				</div>
				
				<div class="row clearfix">
					<div class="col-md-1">
						<div>
							<a class="btn btn-sm btn-primary" href="login_page.html">Back To Login</a>
						</div>
							
					</div>
					<div class="col-md-offset-11">
						<input type ="submit" class="btn btn-sm btn-success" name = "createNewACC" value="Signup">
					</div>
				</div>
			</form>
		</div>
	</body>
</html>

<?php
$conn->close();
?>