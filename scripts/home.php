<div class="page-header">
	<h2>Home Mother Fucker!</h2> 
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
	
echo '
	
<div class="well">
';

$int = 0;
while ($int < count($result)){
	$lid = $result[$int]['lid'];
	if ($int %2 == 0){
		echo'<div class="row clearfix">
		<div class="col-md-6 column">
			<div class="panel panel-primary" onmouseover="this.style.cursor=\'pointer\' " 
									onclick="window.location=\'index.php?content=lead_edit&lid='.htmlspecialchars($lid).'\'">
				<div class="panel-heading">
					<h3 class="panel-title">'.
						$result[$int]['lead_name'].'
					</h3>
				</div>
				<div class="panel-body">'.
					$result[$int]['description'].
				'</div>
				<div class="panel-footer">
					Panel footer
				</div>
			</div>
		</div>';
	}else{
		echo '<div class="col-md-6 column">
			<div class="panel panel-primary" onmouseover="this.style.cursor=\'pointer\' " 
									onclick="window.location=\'index.php?content=lead_edit&lid='.htmlspecialchars($lid).'\'">
				<div class="panel-heading">
					<h3 class="panel-title">'.
							$result[$int]['lead_name'].'
				</h3>
				</div>
				<div class="panel-body">'.
					$result[$int]['description'].'</div>
				<div class="panel-footer">
					Panel footer
				</div>
			</div>
		</div>
	</div>';
	}
	$int++;
}

	
		
	echo '</div>';
?>
