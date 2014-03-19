<!DOCTYPE html>
<?php

$phonePattern = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";
$user = $PWSRD = $CPWSRD = $Fname = $Lname = $Telep = $Email = "";
$userERR = $PWSRDERR = $CPWSRDERR = $FnameERR = $LnameERR = $TelepERR = $EmailERR = "";

include('database_helper.php');

$dbHelper = new DatabaseHelper();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["Fname"]))
        $FnameERR = "Missing";
    else
        $Fname = $_POST["Fname"];

    if (empty($_POST["Lname"]))
        $LnameERR = "Missing";
    else
        $Lname = $_POST["Lname"];

    if (empty($_POST["user"]))
        $userERR = "Missing";
    else
        $user = $_POST["user"];

    if (empty($_POST["pswd"]))
        $PWSRDERR = "Missing";
    else
        $PWSRD = $_POST["pswd"];

    if (empty($_POST["confirmpswd"]))
        $CPWSRDERR = "Missing";
    else
        $CPWSRD = $_POST["confirmpswd"];


	if (empty($_POST["pNum"]))
        $TelepERR = "Missing";
    else{
        //$Telep = str_replace("-" , "" ,$_POST["pNum"]);
        $Telep = $_POST["pNum"];
        if(!isValid($phonePattern, $Telep)){
        	$TelepERR = "Incorrect Input";
        }
    }

    if (empty($_POST["emailAddr"]))
        $EmailERR = "Missing";
    else{
        $Email = filter_var($_POST['emailAddr'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) 
        	$EmailERR = "Incorrect Email";
    }

}

?>

<html>
	<head>
  		<meta charset="utf-8">
  		<title>Signup Page</title>
	</head>
	
	<body>
		<div>
			<form method= "POST" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	            <h1> Please create an account </h1>
	           		First Name: <input type = "text" name = "Fname" placeholder = "First Name"
	           					value="<?php echo htmlspecialchars($Fname);?>">
								<span class="error"><?php echo $FnameERR;?></span> 
	               	<br/> <br/>
	                Last Name: <input type = "text" name = "Lname" placeholder = "Last Name"
	           					value="<?php echo htmlspecialchars($Lname);?>">
								<span class="error"><?php echo $LnameERR;?></span>
	                <br/> <br/>
	                Username: <input type = "text" name = "user" placeholder = "Username"
           						value="<?php echo htmlspecialchars($user);?>">
								<span class="error"><?php echo $userERR;?></span>
	                <br/> <br/>
	                Password: <input type = "password" name = "pswd" placeholder = "Password"/>
								<span class="error"><?php echo $PWSRDERR;?></span>
	                <br/> <br/>
	                Confirm password: <input type = "password" name = "confirmpswd" placeholder = "Password"/>
								<span class="error"><?php echo $CPWSRDERR;?></span>
	                <br/> <br/>
	                E-Mail: <input type = "text" placeholder ="E-mail" name = "emailAddr"   
								value="<?php echo htmlspecialchars($Email);?>">
								<span class="error"><?php echo $EmailERR;?></span>
	                <br/> <br/>
	                Phone Number: <input type = "text" name = "pNum" placeholder ="XXX-XXX-XXXX"
								value="<?php echo htmlspecialchars($Telep);?>">
								<span class="error"><?php echo $TelepERR;?></span>
	                <br/> <br/>
	                <input type ="submit" name = "createNewACC" value="Submit">
           </form>
		</div>
	</body>
</html>


<?php
$phonePattern = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";

// Database credentials
$DBServer = "localhost";
$DBUser = "root";
$DBPass = "";
$DBName = "cbel_db";
 
// Connect to database
$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

if($conn->connect_errno)
	trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);

function samePassword($pass, $confPass) {
        return ($pass == $confPass && $pass != NULL);
}
 
function noUserExists($db,$userE){
	$result = $db->query("SELECT * FROM user WHERE (username = '$userE')");
	return ($result->num_rows == 0);
}

function mailExists($db, $mail){ //TODO: MAKE IT NO? 
	//TODO: CHANGE QUERY TO THE RIGHT COLOMN.
	$resultMail = $db->query("SELECT * FROM user WHERE (email = '$mail')");
	return ($resultMail->num_rows != 0);
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


function isValid($pattern, $value){
	return preg_match($pattern, $value) ? true : false;
}


if(array_key_exists("createNewACC" , $_POST)){

	if(noUserExists($conn , $user) && samePassword($PWSRD, $CPWSRD) && 
		!mailExists($conn, $Email)){
			echo "$user - Doesn't exist, We are adding it now.";

		runInsert($dbHelper, $user, $PWSRD, $Fname, $Lname, $Telep, $Email);

			echo "Congratulations, you have been registered. Sign in plz";
		$result = $conn->query("SELECT * FROM user WHERE (username = '$user')");
		echo ", $result->num_rows. Should be 1.";
		echo "THIS PAGE WILL AUTOMATICALLY GO TO LOGIN just wait";
		$result->close();
    	header('Refresh: 5; http://localhost/new/project/scripts/login_page.html');    


		
	}
	else
		echo "$user - Already exists - OR passwords dont match";

}





$conn->close();



?>

























