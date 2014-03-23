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
	<!-- Include Bootstrap -->
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<!-- Validate plugin -->
	<script src="../bootstrap/js/jquery.validate.min.js"></script>
	<!-- Prettify plugin -->
		<script src="assets/js/prettify/prettify.js"></script>
	<!-- Scripts specific to this page -->
		<script src="script.js"></script>
		<script>
			// Activate Google Prettify in this page
				addEventListener('load', prettyPrint, false);

			$(document).ready(function(){

				// Add prettyprint class to pre elements
					$('pre').addClass('prettyprint linenums');

			});

		</script>
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-22151549-3']);
		  _gaq.push(['_trackPageview']);

		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
</div>
