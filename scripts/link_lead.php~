<?php
error_reporting(E_ALL ^ E_NOTICE);

require_once 'database_helper.php';
class LinkLead{
	private $db;
	
	function __construct(){
		global $db;
		$db = new DatabaseHelper();
	}
	
	public function linkLeads($main ,$link){
		global $db;
                if ($main == $link) {
                } else {
		$sql = "INSERT INTO linked_ids (lid_main,lid_link) VALUES (?,?)";
		$stmt = $db->prepareStatement($sql);
		$db->bindArray($stmt, array('i','i'), array($main, $link));
                $db->executeStatement($stmt);
                $sql = "INSERT INTO linked_ids (lid_main,lid_link) VALUES (?,?)";
                $stmt = $db->preparedStatement($sql);
                $db->bindArray($stmt, array('i','i'), array($link, $main));
                $db->executeStatement($stmt);
                }
	}
	
	public function deleteLink($main, $link){
		global $db;
		print $main;
		$sql = "DELETE FROM linked_ids
					WHERE lid_main=? AND lid_link=?";
		$stmt = $db->prepareStatement($sql);
		$db->bindArray($stmt, array('i','i'), array($main, $link));
		$db->executeStatement($stmt);
	}

	//Editable links used in the lead_edit page
	public function displayLinkForm(){
		global $db;
		
		$sql = "SELECT cbel_lead.lead_name, linked_ids.lid_main, linked_ids.lid_link
					FROM cbel_lead
					INNER JOIN linked_ids
					ON cbel_lead.lid=linked_ids.lid_link
					WHERE linked_ids.lid_main = ?;";
		$stmt = $db->prepareStatement($sql);
		$db->bindParameter($db, 'i', $_GET['lid']);
		$db->executeStatement($stmt);
		$listOfLinks = $db->getResult($stmt);

		$sql = "SELECT lead_name, lid FROM cbel_lead";
		$s = $db->prepareStatement($sql);
		$db->executeStatement($s);
		$listOfLeads = $db->getResult($stmt);
		?>
		<a name="links"></a>
		<div class="well" style="margin-top:15px">
			<div class="row clearfix">
				<div class="col-md-12 column">
					<div class="row clearfix">
						<div class="col-md-12 column">
							<h2>Linked Leads</h2>
							<table class="table">
								<?php
									foreach($listOfLinks as $link) {
										print "	<tr>
														<td class='col-md-4'>
															<a href=index.php?content=lead_edit&lid=".$link['lid_link'].">".$link['lead_name']."</a>
														</td>"."
														<td>
															<a class='btn btn-danger btn-sm' onclick='deleteLink({$_GET['lid']}, {$link['lid_link']})'>
																Remove Link
															</a>
														</td>
													</tr>";
									}
									?>
							</table>
							
							<div class="col-md-4">
								<form>
									<select  class="form-control" name="link" id='link'>
										<?php
											print "<option>Please Select One</option>";
											foreach($listOfLeads as $lead) {
												print "<option value='".$lead['lid']."'>".$lead['lead_name']."</option>";
											}
										?>
									</select>
								</form>
							</div>
								<div class="col-md-8" style="padding-top:5px">
									<input type ="button" value="Link" onClick="link_lead(<?php print $_GET['lid']; ?>)" class="btn btn-info btn-sm">
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script language="javascript">
			function link_lead(main) {      
				var x = document.getElementById("link").selectedIndex;
				var y = document.getElementById("link").options;
				var link = y[x].value;
				
				$.ajax({
					type: "POST",
					url: "link_handler.php",
					data: {add: 'add', main: main, link:link},
					success: function(){
						window.location.reload();
					}
				});
			}
			
			function deleteLink(main, link){
				$.ajax({
					type: "POST",
					url: "link_handler.php",
					data: {delete: 'delete', main: main, link:link},
					success: function(){
						window.location.reload();
					}
				});
			}
		</script>
<?php
	}

	//Same funtion as above but displays immutable links
	public function displayLink(){
		global $db;
		
		$sql = "SELECT cbel_lead.lead_name, linked_ids.lid_main, linked_ids.lid_link
					FROM cbel_lead
					INNER JOIN linked_ids
					ON cbel_lead.lid=linked_ids.lid_link
					WHERE linked_ids.lid_main = ?;";
		$stmt = $db->prepareStatement($sql);
		$db->bindParameter($db, 'i', $_GET['lid']);
		$db->executeStatement($stmt);
		$listOfLinks = $db->getResult($stmt);

		$sql = "SELECT lead_name, lid FROM cbel_lead";
		$s = $db->prepareStatement($sql);
		$db->executeStatement($s);
		$listOfLeads = $db->getResult($stmt);
		if(!is_null($listOfLinks[0])){
		?>
		<a name="links"></a>
		<div class="well" style="margin-top:15px">
			<div class="row clearfix">
				<div class="col-md-12 column">
					<div class="row clearfix">
						<div class="col-md-12 column">
							<h2>Linked Leads</h2>
							<table class="table">
								<?php
									foreach($listOfLinks as $link) {
										print "	<tr>
														<td class='col-md-4'>
															<a href=index.php?content=lead_view&lid=".$link['lid_link'].">".$link['lead_name']."</a>
														</td>"."
														<td>
														</td>
													</tr>";
									}
									?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script language="javascript">
			function link_lead(main) {      
				var x = document.getElementById("link").selectedIndex;
				var y = document.getElementById("link").options;
				var link = y[x].value;
				
				$.ajax({
					type: "POST",
					url: "link_handler.php",
					data: {add: 'add', main: main, link:link},
					success: function(){
						window.location.reload();
					}
				});
			}
			
			function deleteLink(main, link){
				$.ajax({
					type: "POST",
					url: "link_handler.php",
					data: {delete: 'delete', main: main, link:link},
					success: function(){
						window.location.reload();
					}
				});
			}
		</script>
<?php
}
	}
}
?>