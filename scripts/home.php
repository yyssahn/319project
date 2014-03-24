<div class="page-header">
	<h2>Home Mother Fucker!</h2> 
</div>
<?php 
	include('database_helper.php');
	
		$db = new DatabaseHelper();
	$query = "SELECT lead_name, description FROM 
					(
						SELECT lead_name, description FROM `cbel_lead` 
						WHERE `activity_count` > 0 
						ORDER BY `activity_count` DESC LIMIT 8
					) AS T1
					ORDER BY `lead_name` ASC";
	
	$stmt = $db->prepareStatement($query);
		$db->executeStatement($stmt);
		$result = $db->getResult($stmt);
	

//	print_r($result[0]['lead_name']);
//	echo count($result);
	$int = 0; 
//	while ($int < count($result)){
//		if ($int %2 ==0){
//			echo $int;
//			echo($result[$int]['lead_name']);
//		}else {
//		echo $int;
//		echo ($result[$int]['lead_name']);
//		}
//		$int++;
//	}
echo '
	
<div class="well">
';

while ($int < count($result)){
	if ($int %2 == 0){
		echo'<div class="row clearfix">
		<div class="col-md-6 column">
			<div class="panel panel-primary">
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
			<div class="panel panel-primary">
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
