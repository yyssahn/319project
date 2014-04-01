<div class="page-header">
	<h2>Admin Page</h2>
</div>

<?php

if ($_SESSION['isAdmin']) {

include('database_helper.php');

// Connect to the Database
$db = new DatabaseHelper();


function random_key(){
   $character_set_array = array();
   $character_set_array[] = array('count' => 4, 'characters' => 'abcdefghijklmnopqrstuvwxyz');
   $character_set_array[] = array('count' => 2, 'characters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
   $character_set_array[] = array('count' => 2, 'characters' => '0123456789');
   $temp_array = array();
   foreach ($character_set_array as $character_set) {
       for ($i = 0; $i < $character_set['count']; $i++) {
           $temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
       }
   }
   shuffle($temp_array);
   return implode('', $temp_array);
}

//Puts a newly created key in the keys table
function initKey($dbhelper, $key){
	$query = "INSERT INTO genkeys VALUES(?)";
	$params = array($key);
	$stmt = $dbhelper -> prepareStatement($query);
	$param_types = array('s');
	$dbhelper->bindArray($stmt, $param_types, $params);
	$dbhelper->executeStatement($stmt);
}
$key="";
if(array_key_exists("genkey", $_POST)){
	$key = random_key();
	initKey($db,$key);
}

//=========================================================================================================================
function accountsTab(){
	global $db;
	// Query Database for list of Usernames
	$sql = "SELECT username, admin, activity_count FROM user";
	$stmt = $db->prepareStatement($sql);
	$db->executeStatement($stmt);
	$listOfUsers = $db->getResult($stmt);
?>
	<br />
	<form method = "POST" action = "index.php?content=admin" >
	<input class='btn btn-large btn-success' type="submit" name = "genkey" value ="Generate Key">&nbsp;&nbsp;&nbsp;&nbsp;
	<strong>Active Keys:</strong> <?php echo $GLOBALS['key'];?>
	</form>

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
									<td>".$username['activity_count']."</td>
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
                                    <form name = "option_form" method = "post" action = "">	
										<table class="table table-condensed">
											<?php
												$sql = "SELECT idea_type FROM categoryoptions";
												$stmt = $db->prepareStatement($sql);
												$db->executeStatement($stmt);
												$listOfSubcats = $db->getResult($stmt);

												foreach($listOfSubcats as $subcat) {
													if (isset($subcat['idea_type'])) { ?>
														<tr>
															<td><?php print $subcat['idea_type']; ?></td>
															<td>
																<input type ='button' id ='editOption' value='Edit' onClick='edit_option("<?php print 
																	$subcat['idea_type']; ?>", "idea_type")' class='btn btn-large btn-info'>
																<a href='remove_option.php?optionName=<?php print $subcat['idea_type']; ?>
																	&category=idea_type' class='btn btn-large btn-danger'>Remove</a>
															</td>
														</tr>
													<?php }
												} ?>
											
											<tr>
												<td>
													<input type="text" name="optionName" class="form-control" id="optionName" 
														placeholder="Option Name">
												</td>
												<td>
													 <input type ="button" id ="addOption" value="Add Option" 
																onClick="optionForm_add(this.form,'idea_type')" class="btn btn-large btn-success" 
																contenteditable="true">
												</td>
											</tr>
										</table>
                                    </form>
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
                                    <form name = "option_form" method = "post" action = "">	
										<table class="table table-condensed">
											<?php
												$sql = "SELECT referral FROM categoryoptions";
												$stmt = $db->prepareStatement($sql);
												$db->executeStatement($stmt);
												$listOfSubcats = $db->getResult($stmt);

												foreach($listOfSubcats as $subcat) {
													if (isset($subcat['referral'])) { ?>
														<tr>
															<td><?php print $subcat['referral']; ?></td>
															<td>
																<input type ='button' id ='editOption' value='Edit' onClick='edit_option("<?php print 
																	$subcat['referral']; ?>", "referral")' class='btn btn-large btn-info'>
																<a href='remove_option.php?optionName=<?php print $subcat['referral']; ?>
																	&category=referral' class='btn btn-large btn-danger'>Remove</a>
															</td>
														</tr>
													<?php }
												} ?>
											
											<tr>
												<td>
													<input type="text" name="optionName" class="form-control" id="optionName" 
														placeholder="Option Name">
												</td>
												<td>
													 <input type ="button" id ="addOption" value="Add Option" 
																onClick="optionForm_add(this.form,'referral')" class="btn btn-large btn-success" 
																contenteditable="true">
												</td>
											</tr>
										</table>
                                    </form>
								</div>
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class ="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
										Organization's Mandate
									</a>
								</h4>
							</div>
							<div id="collapseThree" class="panel-collapse collpase collapse">
								<div class="panel-body">
                                    <form name = "option_form" method = "post" action = "">	
										<table class="table table-condensed">
											<?php
												$sql = "SELECT mandate FROM categoryoptions";
												$stmt = $db->prepareStatement($sql);
												$db->executeStatement($stmt);
												$listOfSubcats = $db->getResult($stmt);

												foreach($listOfSubcats as $subcat) {
													if (isset($subcat['mandate'])) { ?>
														<tr>
															<td><?php print $subcat['mandate']; ?></td>
															<td>
																<input type ='button' id ='editOption' value='Edit' onClick='edit_option("<?php print 
																	$subcat['mandate']; ?>", "mandate")' class='btn btn-large btn-info'>
																<a href='remove_option.php?optionName=<?php print $subcat['mandate']; ?>
																	&category=mandate' class='btn btn-large btn-danger'>Remove</a>
															</td>
														</tr>
													<?php }
												} ?>
											
											<tr>
												<td>
													<input type="text" name="optionName" class="form-control" id="optionName" 
														placeholder="Option Name">
												</td>
												<td>
													 <input type ="button" id ="addOption" value="Add Option" 
																onClick="optionForm_add(this.form,'mandate')" class="btn btn-large btn-success" 
																contenteditable="true">
												</td>
											</tr>
										</table>
                                    </form>
								</div>
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class ="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
										Focus Area
									</a>
								</h4>
							</div>
							<div id="collapseFour" class="panel-collapse collpase collapse">
								<div class="panel-body">
                                    <form name = "option_form" method = "post" action = "">	
										<table class="table table-condensed">
											<?php
												$sql = "SELECT focus FROM categoryoptions";
												$stmt = $db->prepareStatement($sql);
												$db->executeStatement($stmt);
												$listOfSubcats = $db->getResult($stmt);

												foreach($listOfSubcats as $subcat) {
													if (isset($subcat['focus'])) { ?>
														<tr>
															<td><?php print $subcat['focus']; ?></td>
															<td>
																<input type ='button' id ='editOption' value='Edit' onClick='edit_option("<?php print 
																	$subcat['focus']; ?>", "focus")' class='btn btn-large btn-info'>
																<a href='remove_option.php?optionName=<?php print $subcat['focus']; ?>
																	&category=focus' class='btn btn-large btn-danger'>Remove</a>
															</td>
														</tr>
													<?php }
												} ?>
											
											<tr>
												<td>
													<input type="text" name="optionName" class="form-control" id="optionName" 
														placeholder="Option Name">
												</td>
												<td>
													 <input type ="button" id ="addOption" value="Add Option" 
																onClick="optionForm_add(this.form,'focus')" class="btn btn-large btn-success" 
																contenteditable="true">
												</td>
											</tr>
										</table>
                                    </form>
								</div>
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class ="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
										Main Activities
									</a>
								</h4>
							</div>
							<div id="collapseFive" class="panel-collapse collpase collapse">
								<div class="panel-body">
                                    <form name = "option_form" method = "post" action = "">	
										<table class="table table-condensed">
											<?php
												$sql = "SELECT main_activities FROM categoryoptions";
												$stmt = $db->prepareStatement($sql);
												$db->executeStatement($stmt);
												$listOfSubcats = $db->getResult($stmt);

												foreach($listOfSubcats as $subcat) {
													if (isset($subcat['main_activities'])) { ?>
														<tr>
															<td><?php print $subcat['main_activities']; ?></td>
															<td>
																<input type ='button' id ='editOption' value='Edit' onClick='edit_option("<?php print 
																	$subcat['main_activities']; ?>", "main_activities")' class='btn btn-large btn-info'>
																<a href='remove_option.php?optionName=<?php print $subcat['main_activities']; ?>
																	&category=main_activities' class='btn btn-large btn-danger'>Remove</a>
															</td>
														</tr>
													<?php }
												} ?>
											
											<tr>
												<td>
													<input type="text" name="optionName" class="form-control" id="optionName" 
														placeholder="Option Name">
												</td>
												<td>
													 <input type ="button" id ="addOption" value="Add Option" 
																onClick="optionForm_add(this.form,'main_activities')" class="btn btn-large btn-success" 
																contenteditable="true">
												</td>
											</tr>
										</table>
                                    </form>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class ="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
										Delivery Location
									</a>
								</h4>
							</div>
							<div id="collapseSix" class="panel-collapse collpase collapse">
								<div class="panel-body">
                                    <form name = "option_form" method = "post" action = "">	
										<table class="table table-condensed">
											<?php
												$sql = "SELECT location FROM categoryoptions";
												$stmt = $db->prepareStatement($sql);
												$db->executeStatement($stmt);
												$listOfSubcats = $db->getResult($stmt);

												foreach($listOfSubcats as $subcat) {
													if (isset($subcat['location'])) { ?>
														<tr>
															<td><?php print $subcat['location']; ?></td>
															<td>
																<input type ='button' id ='editOption' value='Edit' onClick='edit_option("<?php print 
																	$subcat['location']; ?>", "location")' class='btn btn-large btn-info'>
																<a href='remove_option.php?optionName=<?php print $subcat['location']; ?>
																	&category=location' class='btn btn-large btn-danger'>Remove</a>
															</td>
														</tr>
													<?php }
												} ?>
											
											<tr>
												<td>
													<input type="text" name="optionName" class="form-control" id="optionName" 
														placeholder="Option Name">
												</td>
												<td>
													 <input type ="button" id ="addOption" value="Add Option" 
																onClick="optionForm_add(this.form,'location')" class="btn btn-large btn-success" 
																contenteditable="true">
												</td>
											</tr>
										</table>
                                    </form>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class ="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
										Possible Disciplines
									</a>
								</h4>
							</div>
							<div id="collapseSeven" class="panel-collapse collpase collapse">
								<div class="panel-body">
                                    <form name = "option_form" method = "post" action = "">	
										<table class="table table-condensed">
											<?php
												$sql = "SELECT disciplines FROM categoryoptions";
												$stmt = $db->prepareStatement($sql);
												$db->executeStatement($stmt);
												$listOfSubcats = $db->getResult($stmt);

												foreach($listOfSubcats as $subcat) {
													if (isset($subcat['disciplines'])) { ?>
														<tr>
															<td><?php print $subcat['disciplines']; ?></td>
															<td>
																<input type ='button' id ='editOption' value='Edit' onClick='edit_option("<?php print 
																	$subcat['disciplines']; ?>", "disciplines")' class='btn btn-large btn-info'>
																<a href='remove_option.php?optionName=<?php print $subcat['disciplines']; ?>
																	&category=disciplines' class='btn btn-large btn-danger'>Remove</a>
															</td>
														</tr>
													<?php }
												} ?>
											
											<tr>
												<td>
													<input type="text" name="optionName" class="form-control" id="optionName" 
														placeholder="Option Name">
												</td>
												<td>
													 <input type ="button" id ="addOption" value="Add Option" 
																onClick="optionForm_add(this.form,'disciplines')" class="btn btn-large btn-success" 
																contenteditable="true">
												</td>
											</tr>
										</table>
                                    </form>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class ="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
										Timeframe
									</a>
								</h4>
							</div>
							<div id="collapseEight" class="panel-collapse collpase collapse">
								<div class="panel-body">
                                    <form name = "option_form" method = "post" action = "">	
										<table class="table table-condensed">
											<?php
												$sql = "SELECT timeframe FROM categoryoptions";
												$stmt = $db->prepareStatement($sql);
												$db->executeStatement($stmt);
												$listOfSubcats = $db->getResult($stmt);

												foreach($listOfSubcats as $subcat) {
													if (isset($subcat['timeframe'])) { ?>
														<tr>
															<td><?php print $subcat['timeframe']; ?></td>
															<td>
																<input type ='button' id ='editOption' value='Edit' onClick='edit_option("<?php print 
																	$subcat['timeframe']; ?>", "timeframe")' class='btn btn-large btn-info'>
																<a href='remove_option.php?optionName=<?php print $subcat['timeframe']; ?>
																	&category=timeframe' class='btn btn-large btn-danger'>Remove</a>
															</td>
														</tr>
													<?php }
												} ?>
											
											<tr>
												<td>
													<input type="text" name="optionName" class="form-control" id="optionName" 
														placeholder="Option Name">
												</td>
												<td>
													 <input type ="button" id ="addOption" value="Add Option" 
																onClick="optionForm_add(this.form,'timeframe')" class="btn btn-large btn-success" 
																contenteditable="true">
												</td>
											</tr>
										</table>
                                    </form>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class ="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseNine">
										Current Status
									</a>
								</h4>
							</div>
							<div id="collapseNine" class="panel-collapse collpase collapse">
								<div class="panel-body">
                                    <form name = "option_form" method = "post" action = "">	
										<table class="table table-condensed">
											<?php
												$sql = "SELECT status FROM categoryoptions";
												$stmt = $db->prepareStatement($sql);
												$db->executeStatement($stmt);
												$listOfSubcats = $db->getResult($stmt);

												foreach($listOfSubcats as $subcat) {
													if (isset($subcat['status'])) { ?>
														<tr>
															<td><?php print $subcat['status']; ?></td>
															<td>
																<input type ='button' id ='editOption' value='Edit' onClick='edit_option("<?php print 
																	$subcat['status']; ?>", "status")' class='btn btn-large btn-info'>
																<a href='remove_option.php?optionName=<?php print $subcat['status']; ?>
																	&category=status' class='btn btn-large btn-danger'>Remove</a>
															</td>
														</tr>
													<?php }
												} ?>
											
											<tr>
												<td>
													<input type="text" name="optionName" class="form-control" id="optionName" 
														placeholder="Option Name">
												</td>
												<td>
													 <input type ="button" id ="addOption" value="Add Option" 
																onClick="optionForm_add(this.form,'status')" class="btn btn-large btn-success" 
																contenteditable="true">
												</td>
											</tr>
										</table>
                                    </form>
								</div>
							</div>
						</div>
						
					</div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

	<script language ="javascript">
	
	function optionForm_add(form, category) { 
		
                var optionName = form.optionName.value;
		window.location.href = "add_option.php?optionName=" + optionName + "&category=" + category;
	}
        
//        function optionForm_expand(option) {
//            alert(option);
//        }

        function edit_option(option, category) {

            var newOptionName=prompt("New Option Name");

            if (newOptionName!=null) {
                window.location.href = "edit_option.php?newOptionName=" + newOptionName + "&option=" + option + "&category=" + category;
            }
        }
	</script>
        
<?php
}

//=========================================================================================================================
function statisticsTab(){
	global $db;
	// Query database
	$allProjectSQL = "SELECT count(*) FROM cbel_lead";

	$allDroppedSQL = "SELECT count(*) FROM cbel_lead WHERE status = 'Dropped'";

	$allSuccessedSQL = "SELECT count(*) FROM cbel_lead 
										WHERE status = 'Project/Placement Completed (Ready for Archiving)' OR status = 'Archived'";

	$projectExecute= $db->prepareStatement($allProjectSQL);	
	$db->executeStatement($projectExecute);
	$projectResult = $db->getResult($projectExecute);
	$allProjects = $projectResult[0]['count(*)'];
	

	$droppedExecute= $db->prepareStatement($allDroppedSQL);	
	$db->executeStatement($droppedExecute);
	$droppedResult = $db->getResult($droppedExecute);
	$allDropped = $droppedResult[0]['count(*)'];

	$successedExecute= $db->prepareStatement($allSuccessedSQL);	
	$db->executeStatement($successedExecute);
	$successedResult = $db->getResult($successedExecute);
	$allSuccessed = $successedResult[0]['count(*)'];

	$OnGoingProjects = $allProjects - ($allSuccessed + $allDropped);

	$SuccessRate = round($allSuccessed / $allProjects, 2)*100;
	$FailedRate = round($allDropped / $allProjects, 2)*100;
	$OnGoingRate = 100 - ($SuccessRate + $FailedRate);
?>
	<div class="row" style="padding-top:50px">
		<div class="col-md-10 column col-md-offset-1">
			<table class="table">
				<tbody>
					<tr class="warning"><td>Projects Completed: <?php  echo $allSuccessed ?>  <td><td>Projects Dropped: <?php  echo $allDropped ?> <td><td>On-going Projects: <?php echo $OnGoingProjects ?></td><tr>

					<tr class="warning"><td>Projects Attempted: <?php  echo $allProjects ?> <td><td>Projects Attempted: <?php  echo $allProjects ?>  <td><td>Projects Attempted: <?php  echo $allProjects ?></td><tr>
				
					<tr class="success"><td>Success Rate:  <?php  echo $SuccessRate ?>%<td><td>Failure Rate:  <?php echo $FailedRate ?>% <td><td>On-Going Projects Rate: <?php echo $OnGoingRate ?>% </td><tr>
				</tbody>
			</table>
		</div>
	</div>

  <html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
		
	var dropRate = <?php echo ($allDropped); ?>;
	var successRate = <?php echo ($allSuccessed); ?>;
	var onGoingRate = <?php echo ($OnGoingProjects); ?>; 
	
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {
		
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Dropped Project Rate', dropRate],
          ['Succeeded Project Rate',successRate],
          ['On-Going Project Rate',onGoingRate],
        ]);

        // Set chart options
        var options = {'title':'Pie Chart Statistic Rate:',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('statisticChart'));
        chart.draw(data, options);
      }
    </script>

  </head>
</html>

<div id="statisticChart" style="margin-left: 90px;"></div>

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

					<?php statisticsTab(); ?>

				</div>
            </div>
        </div>
    </div>
</div>

<?php } else { echo "ACCESS DENIED"; } ?>
