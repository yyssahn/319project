<div class="page-header">
	<h2>Notifications Page</h2>
</div>

<?php
include('database_helper.php');

$dbhelp = new DatabaseHelper();
$uid = $_SESSION["User_ID"];

$nh = new NotificationHelper();
?>

<div class="well">
	<div class="row clearfix">
		<div class="col-md-10 col-md-offset-1" style="height:40%; overflow:scroll">
			<table class="table table-striped table-hover" style="border: solid #008cba 1px;">
				<thead>
					<tr style='background-color: #008cba; color: white'><th>My Tag(s)</th></tr>
				</thead>
				<tbody>
					<?php
						$notif = $nh->getNotifications( $uid);
						for($i=0; $i < count($notif); $i++){

							if($notif[$i]['tags'] == 1){
								$string = $notif[$i]['lead_name'];
								$lids = $notif[$i]['lid'];

								print "	<tr onmouseover=\"this.style.cursor='pointer' \"
												onclick=\"window.location='index.php?content=lead_view&lid=$lids&seen=1'\">
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
						$notif = $nh->getNotifications($uid);
						for($i=0; $i < count($notif); $i++){
							if($notif[$i]['seen'] == 1){
								$string = $notif[$i]['lead_name'];
								$lids = $notif[$i]['lid'];
								print "	<tr onmouseover=\"this.style.cursor='pointer' \" 
												onclick=\"window.location='index.php?content=lead_view&lid=$lids&seen=1'\">
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



