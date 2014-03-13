<?php
	$name = $_POST['lead_name'];
	print $name;
	
	$conn = new mysqli('localhost', 'root', '', 'cbel_db');
	
	if(mysqli_connect_errno()) {
      echo "Connection Failed: " . mysqli_connect_errno();
      exit();
   }
   
   if($stmt = $conn -> prepare("INSERT INTO CBEL_Lead VALUES(NULL,NULL,'NULL',?,'NULL','NULL','NULL','NULL','NULL','NULL'
													,'NULL','NULL','NULL')")){
		$stmt->bind_param("s", $name);
		$stmt->execute();
		$stmt->bind_result($result);
		$stmt->close();
   }
   
   $conn->close();
?> 