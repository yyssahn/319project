<div class="page-header">
	<h2>Admin Mother Fucker!</h2>
</div>

<?php

// Connect to the Database

$DBServer = "localhost";
$DBUser = "root";
$DBPass = "";
$DBName = "cbel_db";

$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

if($conn->connect_error) {
	trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
}
// Query Database for list of Usernames

$sql = "SELECT username, admin FROM user";

$result = $conn->query($sql);

// Create a List of users

$listOfUsers = array();

while ($row = mysqli_fetch_assoc($result)) {
    $listOfUsers[] = $row;
}
//=========================================================================================================================
function accountsTab(){
?>
	<br />
	<a href='blah' class='btn btn-large btn-success'>Generate Key</a>&nbsp;&nbsp;&nbsp;&nbsp;
	<strong>Active Keys:</strong> F4SD5-FS465-SDF54; F4S56-54FDS-FS456
	
	<div class="row" style="padding-top:50px">
		<div class="col-md-10 column col-md-offset-1" style="height:500px; overflow:scroll">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>
							Name
						</th>
						<th>
							Selected
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
						global $listOfUsers;
						foreach($listOfUsers as $username) {
							//print "<tr><td>".$username['username']."</td><td><div class='checkbox'><input type='checkbox'></div></td></tr>";
							
							// Show Promote or Demote
							if ($username['admin']) {
								$promoteornot = "<a href='admindemote.php?content=".$username['username']."' class='btn btn-large btn-danger'>Demote</a>";
							} else {
								$promoteornot = "<a href='adminpromote.php?content=".$username['username']."' class='btn btn-large btn-success'>Promote</a>";
							}
								
							print "<tr><td>".$username['username'].
									"</td><td><div><a href='admindelete.php?content=".$username['username']."' class='btn btn-large btn-danger'>Delete</a>"
									. $promoteornot
									. "</div></td></tr>";
						}
					?>
				</tbody>
			</table>
		</div>
		
		<!--<div class="col-md-1 col-md-offset-10" style="padding-top: 20px">
			<a href='index.php?content=lead_edit' class='btn btn-large btn-danger'>Delete Users</a>
		</div> -->
	</div>
<?php
}
//=========================================================================================================================
function categoriesTab(){
?>
	Categories Tab
	<!--<div class="row" style="padding-top:50px">
			<div class="col-md-10 column col-md-offset-1" style="height:600px; overflow:scroll">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>
								Category
							</th>
						</tr>
					</thead>
					<tbody>
						<tr><td>Idea Type</td></tr>
						<tr><td>Possible Referral</td></tr>
						<tr><td>Organization's Mandate</td></tr>
						<tr><td>Idea Type</td></tr>
						<tr><td>Possible Referral</td></tr>
						<tr><td>Organization's Mandate</td></tr>
						<tr><td>Focus Area</td></tr>
						<tr><td>Main Activities</td></tr>
						<tr><td>Delivery Location</td></tr>
						<tr><td>Possible Disciplines</td></tr>
						<tr><td>Timeframe</td></tr>
						<tr><td>Status</td></tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="col-md-1 col-md-offset-10">
			<a href='index.php?content=lead_edit' class='btn btn-large btn-primary'>Submit</a>
		</div>-->
<?php
}
//=========================================================================================================================
function statisticsTab(){
?>
	<div class="row" style="padding-top:50px">
		<div class="col-md-10 column col-md-offset-1">
			<table class="table">
				<tbody>
					<?php 
					
					// Query database
					include('database_helper.php');

					$db = new DatabaseHelper();


					$allProjectSQL = "SELECT count(*) 
									  FROM cbel_lead";

					$allDroppedSQL = "SELECT count(*)
									  FROM cbel_lead
									  WHERE status = 'Project Dropped'";

					$allSuccessedSQL = "SELECT count(*)
										FROM cbel_lead
										
										WHERE status = 'Project/Placement Completed (Ready for Archiv' OR
													 status = 'Archived'";


					$projectExecute= $db->prepareStatement($allProjectSQL);	
					$db->executeStatement($projectExecute);
					$projectResult = $db->getResult($projectExecute);
					$allProjects = $projectResult[0];

					$droppedExecute= $db->prepareStatement($allDroppedSQL);	
					$db->executeStatement($droppedExecute);
					$droppedResult = $db->getResult($droppedExecute);
					$allDropped = $droppedResult[0];

					$successedExecute= $db->prepareStatement($allSuccessedSQL);	
					$db->executeStatement($successedExecute);
					$successedResult = $db->getResult($successedExecute);
					$allSuccessed = $successedResult[0];
					?>
					
					
					<tr class="warning"><td>Projects Completed: <?php  echo $allSuccessed['count(*)'] ?>  <td><td>Projects Dropped: <?php  echo $allDropped['count(*)'] ?> </td><tr>

					<tr class="warning"><td>Projects Attempted: <?php  echo $allProjects['count(*)'] ?> <td><td>Projects Attempted: <?php  echo $allProjects['count(*)'] ?>  </td><tr>
				
					<tr class="success"><td>Success Rate:  <?php  echo round($allSuccessed['count(*)'] / $allProjects['count(*)'], 2)*100 ?>%<td><td>Failure Rate:  <?php  echo round($allDropped['count(*)'] / $allProjects['count(*)'], 2)*100 ?>%</td><tr>

				</tbody>
			</table>
		</div>
	</div>
<?php
}
//=========================================================================================================================
?>
<!-- some change -->
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span8 well">
			<!-- Tabs to load content-->
            <ul class="nav nav-tabs">
                <li class="active"> 
					<a href="#tabs" data-target="#accounts" data-toggle="tab">Accounts</a>
                </li>
				 <li>
					<a href="#tabs" data-target="#categories" data-toggle="tab">Categories</a>
                </li>
				 <li>
					<a href="#tabs" data-target="#statistics" data-toggle="tab">Statistics</a>
                </li>
            </ul>
			
			<!--Content to be loaded into each tab on selection-->
            <div id="tabs" class="tab-content" style="height:60%">
                <div class="tab-pane active fade in" id="accounts">
					<?php accountsTab(); ?>
				</div>
				
				<div class="tab-pane" id="categories">
					<?php categoriesTab(); ?>
				</div>

				<div class="tab-pane" id="statistics">
					<?php statisticsTab() ?>
				</div>
            </div>
        </div>
    </div>
</div>