<?php

include('notification_helper.php');
$nh = new NotificationHelper();

if(isset($_POST['searchLead'])) {
	$searchBoxContent = $_POST['searchBox'];

	if(strlen(trim($searchBoxContent)) < 1) {
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Please fill in the search box!');\n";
		echo "</script>\n";

	}else {
		echo $searchBoxContent;
		header("Location: ./searchByType.php?searchContent=$searchBoxContent");
	}
}

if (!isset($_GET['content'])) {
	$_GET['content'] = NULL;
}
if(!isset($_SESSION['notifications']))
	$notifs = 0;
else
	$notifs = $nh->getNumberNotif($_SESSION["User_ID"]);

?>

<!-- Navbar
    ================================================== -->
<div class="navbar navbar-default navbar-fixed-top">
	<!-- Title and Search bar -->
	<div style="background-color:#008cba;"> <!-- alternative colour: #428bca -->
		<div class="navbar-header">
			<a href="index.php" class="navbar-brand" style="color: white">
				<Strong>CBEL Tracker</Strong>
			</a>
		</div>

		<div class="navbar-collapse collapse navbar-responsive-collapse">
			<form class="navbar-form navbar-left" action="" method="POST">
				<input type="text" class="form-control col-lg-8" style="width:300px" placeholder="Search for Lead by Name" name="searchBox" onkeypress="enterFunction(event);">
				<button type="submit" class="btn btn-default" style="margin-left:5px;" name="searchLead" id="searchButton">Search</button>
			</form>

			<ul class="nav navbar-nav navbar-right" style="margin-right:3px;">
				<li class="nav navbar-nav"><a href="logout.php" style="color:white"><Strong>Log out</Strong></a></li>
			</ul>
		</div>
	</div>
	
	<!-- Links for content loaded into index.php.  Highlights active page in navbar -->
	<div class="subnav scrollnav">
		<ul class="nav nav-pills">
			<li <?php if($_GET['content'] == 'home'){ ?> class="active" <?php } ?>>
				<a href="index.php?content=home">
					<Strong>Home</Strong>
				</a>
			</li>
				
			<li <?php if($_GET['content'] == 'leads' || $_GET['content'] == 'lead_edit'){ ?> class="active" <?php }else{?> class="dropdown" <?php } ?>>
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<strong>Leads</strong>
					<strong class="caret"></strong>
				</a>
				<ul class="dropdown-menu">
					<li><a href="index.php?content=lead_edit">Add Lead</a></li>
					<li><a href="index.php?content=leads">Search for Leads</a></li>
					<li><a href="#" onclick="downloadLead()">Download CBEL Lead CSV</a></li>
					<li><a href="#" onclick="downloadPartner()">Download Community Partner CSV</a></li>
				</ul>
			</li>

			<li <?php if($_GET['content'] == 'notifications'){ ?> class="active" <?php } ?>>
				<a style="margin-top: 1px;" href="index.php?content=notifications">
					<Strong>Notifications <span class="badge"><?php print $notifs ?></span>
					</Strong>
				</a>
			</li>

			<li <?php if($_GET['content'] == 'settings'){ ?> class="active" <?php } ?>>
				<a href="index.php?content=settings">
					<Strong>Settings</Strong>
				</a>
			</li>
		 
			<?php if ($_SESSION['isAdmin']) { ?>
			<li <?php if($_GET['content'] == 'admin'){ ?> class="active" <?php } ?>>
				<a href="index.php?content=admin">
					<Strong>Admin</Strong>
				</a>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>