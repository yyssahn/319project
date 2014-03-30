<?php
// // Database credentials
// $DBServer = "localhost";
// $DBUser = "root";
// $DBPass = "";
// $DBName = "cbel_db";
 
// // Connect to database
// $conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

// $uid = $_SESSION["User_ID"];
// $result = $conn->query("SELECT firstname,lastname FROM user WHERE uid = '$uid'");
// $result = $result->fetch_row();

// //Get Name of about the account.
// $n = $result[0]. " " .$result[1];
include('notification_helper.php');
$nh = new NotificationHelper();

if (!isset($_GET['content'])) {
	$_GET['content'] = NULL;
}
if(!isset($_SESSION['notifications']))
	$notifs = 0;
else
	$notifs = $nh->getNumberNotif($_SESSION["User_ID"]);

?>

<nav class="navbar navbar-inverse" role="navigation">
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav nav-pills">
			<!-- Links for content loaded into index.php.  Highlights active page in navbar -->
			<li <?php if($_GET['content'] == 'home'){ ?> class="active" <?php } ?>>
				<a class="navbar-brand" href="index.php?content=home">Home</a>
			</li>
			<li <?php if($_GET['content'] == 'leads' || $_GET['content'] == 'lead_edit'){ ?> class="active" <?php } ?>>
				<a class="navbar-brand" href="index.php?content=leads">Leads</a>
			</li>

			<li <?php if($_GET['content'] == 'notifications'){ ?> class="active" <?php } ?>>
				<a class="navbar-brand" href="index.php?content=notifications">Notifications
					<span class="badge"><?php print $notifs ?></a>
			</li>

			<li <?php if($_GET['content'] == 'settings'){ ?> class="active" <?php } ?>>
				<a class="navbar-brand" href="index.php?content=settings">Settings</a>
			</li>
			
                        <?php if ($_SESSION['isAdmin']) { ?>
			<li <?php if($_GET['content'] == 'admin'){ ?> class="active" <?php } ?>>
				<a class="navbar-brand" href="index.php?content=admin">Admin</a>
			</li>
                        <?php } ?>
                        
			<div class="navbar-header pull-right">
				<a class="navbar-brand" href="Logout.php">Log out</a>
			</div>
		</ul>
			
	</div>
	
	<div class="col-md-6">
		<input type="text" class="form-control" placeholder="Search for Lead by Name">
	</div>

	<button type="submit" class="btn btn-default">Search</button>
</nav>

