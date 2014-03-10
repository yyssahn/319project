<div class="container">
	<?php 
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
</div>
