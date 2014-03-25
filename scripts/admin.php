<div class="page-header">
	<h2>Admin Mother Fucker!</h2>
</div>

<?php
include('database_helper.php');

// Connect to the Database
$db = new DatabaseHelper();

function accountsTab(){
	global $db;
	// Query Database for list of Usernames
	$sql = "SELECT username, admin, activityCount FROM user";
	$stmt = $db->prepareStatement($sql);
	$db->executeStatement($stmt);
	$listOfUsers = $db->getResult($stmt);
?>
	<br />
	<a href='blah' class='btn btn-large btn-success'>Generate Key</a>&nbsp;&nbsp;&nbsp;&nbsp;
	<strong>Active Keys:</strong> F4SD5-FS465-SDF54; F4S56-54FDS-FS456
	
	<div class="row" style="padding-top:50px">
		<div class="col-md-10 column col-md-offset-1" style="height:500px; overflow:scroll">
			<table class="table table-striped">
				<thead>
					<tr><th>Name</th><th>Selected</th><th>MonthlyActivityCount</th></tr>
				</thead>
				<tbody>
					<?php
						foreach($listOfUsers as $username) {
							// Show Promote or Demote
							if ($username['admin']) {
								$promoteornot = "<a href='admin_demote.php?username=".$username['username']."' class='btn btn-large btn-danger'>Demote</a>";
							} else {
								$promoteornot = "<a href='admin_promote.php?username=".$username['username']."' class='btn btn-large btn-success'>Promote</a>";
							}
								
							print "<tr><td>".$username['username'].
									"</td><td><div><a href='admin_delete.php?username=".$username['username']."' class='btn btn-large btn-danger'>Delete</a>"
									. $promoteornot
									. "</div></td>
									<td>".$username['activityCount']."</td>
									</tr>";
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
<?php
}

//=========================================================================================================================
function categoriesTab(){
	global $db;
?>
<!-- The nested collapse tables-->
<div class="row" style="padding-top:50px">
    <div class="col-md-10 column col-md-offset-1" style="height:600px; overflow:scroll">
        <table class="table table-striped">
            <thead>
				<tr><th>Categories </th></tr>
            </thead>
            <tbody>
                <tr><td>
					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class ="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
										Idea Type
									</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collpase collapse">
								<div class="panel-body">
									<table class="table table-condensed">
										<?php
											$sql = "SELECT idea_type FROM categoryoptions";
											$stmt = $db->prepareStatement($sql);
											$db->executeStatement($stmt);
											$listOfSubcats = $db->getResult($stmt);
											
											foreach($listOfSubcats as $subcat) {
												if (isset($subcat['idea_type'])) {
													print "<tr><td>".$subcat['idea_type']."</td>".
														"<td><a href='index.php?content=admin' class='btn btn-large btn-info'>Edit</a>".
														"<a href='index.php?content=admin' class='btn btn-large btn-danger'>Remove</a>".
														"</td></tr>";
												}
											}
										?>
										<tr>
											<td>
												<form role="form">
													<input type="text" class="form-control" id="optionName" placeholder="Option Name">
												</form>
											</td>
											<td>
												<button type="submit" class="btn btn-large btn-success">Add Option</button>
											</td>
										</tr>
									</table>    
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class ="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
										Possible Program Referral
									</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collpase collapse">
								<div class="panel-body">
									Hidden Content 1
								</div>
							</div>
						</div>
					</div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

<?php
}

//=========================================================================================================================
function statisticsTab(){
	global $db;
	// Query database
	$allProjectSQL = "SELECT count(*) FROM cbel_lead";

	$allDroppedSQL = "SELECT count(*) FROM cbel_lead WHERE status = 'Project Dropped'";

	$allSuccessedSQL = "SELECT count(*) FROM cbel_lead 
										WHERE status = 'Project/Placement Completed (Ready for Archiving)' OR status = 'Archived'";

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
	<div class="row" style="padding-top:50px">
		<div class="col-md-10 column col-md-offset-1">
			<table class="table">
				<tbody>
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
<!-- Shows the tabs and loads their content -->
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