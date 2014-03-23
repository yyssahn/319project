<div class="container" style="height:145%">
	<?php 
		session_start();

		// For keeping user logged in
		if(!isset($_SESSION['Input_username'])) {
			header("Location:login_page.html");
		}
	
		include("head.php");
		include("navbar.php");
	
		//Loads content of page. Initially goes to homepage, 
		//else goes to page specified by link.  Only part on site
		//that changes
		if(IsSet($_GET['content'])){
			include($_GET['content'].".php"); 
		}
		else{
			include("home.php");
		}

		include("foot.php");
	?>
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../bootstrap/js/jquery-1.11.0.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="../bootstrap/js/bootstrap.min.js"></script>

</div>
