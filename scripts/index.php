<div class="container" style="overflow: hidden">
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
</div>
