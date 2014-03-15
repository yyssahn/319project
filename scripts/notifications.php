<div class="page-header">
	<h2>Notifications Mother Fucker!</h2>
</div>

<div class="well">
	<div class="row clearfix">
		<div class="col-md-10 col-md-offset-1" style="height:40%; overflow:scroll">
			<table class="table">
				<thead>
					<tr class="warning"><th>Notification Type</th><th>Notification Text</th></tr>
				</thead>
				<tbody>
					<?php
						for($i=0; $i< 15; $i++){
							$n = rand(0, 10);
							if($n<7)
								$string = "Lead Notification";
							else
								$string = "Tag Notification";
								
							if($i%2 == 0)
								print "<tr class='info'><td>{$string}</td><td>Notification Text {$i}</td></tr>";
							else 
								print "<tr class='success'><td>{$string}</td><td>Notification Text {$i}</td></tr>";
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>