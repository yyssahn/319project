<div class="page-header">
	<h2>Notifications Page</h2>
</div>

<?php
include('database_helper.php');

$dbhelp = new DatabaseHelper();
$uid = $_SESSION["User_ID"];

function getNotifications($dbhelper, $uid){
	$sql = "SELECT T.uid, T.seen, T.tags, T.lid, L.lead_name
			FROM cbel_lead L
			INNER JOIN tag T
	 		WHERE T.lid = L.lid AND T.uid = ? 
	 			AND (T.seen = 1 OR T.tags = 1 )";
	$stmt = $dbhelper->prepareStatement($sql);

	$params = array($uid);
	$param_types = array('s');
	$dbhelper->bindArray($stmt, $param_types, $params);
	$dbhelper->executeStatement($stmt);
	$result = $dbhelper->getResult($stmt);
	return $result;
}

?>

<div class="well">
	<div class="row clearfix">
		<div class="col-md-10 col-md-offset-1" style="height:40%; overflow:scroll">
			<table class="table table-striped table-hover" style="border: solid #008cba 1px;">
				<thead>
					<tr style='background-color: #008cba; color: white'><th>New Tags</th></tr>
				</thead>
				<tbody>
					<?php
						$notif = getNotifications($dbhelp, $uid);
						$_SESSION['notifications'] = count($notif);
						for($i=0; $i < count($notif); $i++){

							if($notif[$i]['tags'] == 1){
								$string = $notif[$i]['lead_name'];
								$lids = $notif[$i]['lid'];

								print "	<tr onmouseover=\"this.style.cursor='pointer' \"
												onclick=\"window.location='index.php?content=lead_edit&lid=$lids&tags=1&seen=1'\">
												<td>$string</td>
											</tr>";
							}
						}
					?>
				</tbody>
			</table>
			<br> <br>
			<table class="table table-striped table-hover" style="border: solid #008cba 1px;">
				<thead>
					<tr style='background-color: #008cba; color: white'><th>New Updates</th></tr>
				</thead>
				<tbody>
					<?php
						$notif = getNotifications($dbhelp, $uid);
						for($i=0; $i < count($notif); $i++){
							if($notif[$i]['seen'] == 1 && $notif[$i]['tags'] == 0){
								$string = $notif[$i]['lead_name'];
								$lids = $notif[$i]['lid'];
								print "	<tr onmouseover=\"this.style.cursor='pointer' \" 
												onclick=\"window.location='index.php?content=lead_edit&lid=$lids&tags=0&seen=1'\">
												<td>$string</td>
											</tr>";
							}								
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>



