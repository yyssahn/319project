<div class="page-header">
	<h2>Home Page</h2> 
</div>
<?php 
include('database_helper.php');

$db = new DatabaseHelper();

$query = "SELECT lid, lead_name, description FROM 
				(
					SELECT lid, lead_name, description FROM `cbel_lead` 
					WHERE `activity_count` > 0 
					ORDER BY `activity_count` DESC LIMIT 8
				) AS T1
				ORDER BY `lead_name` ASC";

$stmt = $db->prepareStatement($query);
$db->executeStatement($stmt);
$result = $db->getResult($stmt);

$query2 = "SELECT lid, lead_name, description FROM `cbel_lead` WHERE DATEDIFF(CURDATE(),enddate)>= -7 AND DATEDIFF(CURDATE(),enddate)<= 0";
$stmt2 = $db->prepareStatement($query2);
$db->executeStatement($stmt2);
$result2 = $db->getResult($stmt2);
	
echo '
<div class="well">';
	$int = 0;
	if (count($result)==0){
		echo'
		<h3> There are no leads that are active</h3>';
	}else{
		echo '
		<h3> Popular Leads</h3>
		<hr />';
		
		while ($int < count($result2)){
				$lid = $result2[$int]['lid'];
				if ($int % 2 == 0){
					echo'
				<div class="row clearfix">
					<div class="col-md-6 column">
						<div class="panel panel-primary" onmouseover="this.style.cursor=\'pointer\' "
							onclick="window.location=\'index.php?content=lead_edit&lid='.htmlspecialchars($lid).'\'">
							<div class="panel-heading">
								<h3 class="panel-title">'.$result2[$int]['lead_name'].'</h3>
							</div>
							<div class="panel-body" style="height:150px">'.
								$result2[$int]['description'].
							'</div>
						</div>
					</div>';
				}else{
					echo '
					<div class="col-md-6 column">
						<div class="panel panel-primary" onmouseover="this.style.cursor=\'pointer\' " 
								onclick="window.location=\'index.php?content=lead_edit&lid='.htmlspecialchars($lid).'\'">
							<div class="panel-heading">
								<h3 class="panel-title">'.$result2[$int]['lead_name'].'</h3>
							</div>
							<div class="panel-body" style="height:150px">'.
								$result2[$int]['description'].'
							</div>
						</div>
					</div>
				</div>';
				}
				$int++;
		}
	}
echo'
</div></div>';

echo '
<div class="well">';
	$int = 0;
	if (count($result)==0){
		echo'
		<h3> There are no leads that are active</h3>';
	}else{
		echo '
		<h3> Popular Leads</h3>
		<hr />';
		
		while ($int < count($result)){
				$lid = $result[$int]['lid'];
				if ($int % 2 == 0){
					echo'
				<div class="row clearfix">
					<div class="col-md-6 column">
						<div class="panel panel-primary" onmouseover="this.style.cursor=\'pointer\' "
							onclick="window.location=\'index.php?content=lead_edit&lid='.htmlspecialchars($lid).'\'">
							<div class="panel-heading">
								<h3 class="panel-title">'.$result[$int]['lead_name'].'</h3>
							</div>
							<div class="panel-body" style="height:150px">'.
								$result[$int]['description'].
							'</div>
						</div>
					</div>';
				}else{
					echo '
					<div class="col-md-6 column">
						<div class="panel panel-primary" onmouseover="this.style.cursor=\'pointer\' " 
								onclick="window.location=\'index.php?content=lead_edit&lid='.htmlspecialchars($lid).'\'">
							<div class="panel-heading">
								<h3 class="panel-title">'.$result[$int]['lead_name'].'</h3>
							</div>
							<div class="panel-body" style="height:150px">'.
								$result[$int]['description'].'
							</div>
						</div>
					</div>
				</div>';
				}
				$int++;
		}
	}
echo'
</div></div>';

?>