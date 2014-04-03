<div class="page-header">
	<h2>Lead Edit Page</h2>
</div>

<head>
	<script>
	function focusCommentBox() {
		document.getElementById('commentBoxID').focus();
	}

	</script>

</head>

<?php
// Connect to database
	include('database_helper.php');

	function isValid($pattern, $value){
		return preg_match($pattern, $value) ? true : false;
	
	}

	$db = new DatabaseHelper();
	$nh =  new NotificationHelper();

	$phonePattern = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";
	$phoneERR = $emailERR = '';

	$TelepERR = '';
	$lidNotif =	$tagNotif = $seenNotif = 0;
	if(isset($_GET["lid"])) {
		$lidNotif = $_GET["lid"];
	}

	if(isset($_GET["tags"]))
		$tagNotif = $_GET["tags"];
	if (isset($_GET["seen"]))
		$seenNotif = $_GET["seen"];
	
	$lead_info = array();
	$partner_info = array();

	if($tagNotif == 1 )
		$nh->turnoffTag($_SESSION["User_ID"], $lidNotif);
	if($seenNotif == 1)
		$nh->turnoff($_SESSION["User_ID"],$lidNotif);
	
	// Get  category options
	$sql = "SELECT * FROM CategoryOptions";
	$s = $db->prepareStatement($sql);
	$db->executeStatement($s);
	$categories = $db->getResult($db);
/*	
	// Enforce phone number formatting
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$phonePattern = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";
		if(!isValid($phonePattern, $_POST['phone'])){
			$TelepERR = "Incorrect Input";
		}
	} */

	// Checking whether deleting comment is failed or not
	if(isset($_GET['failed'])) {

		$failedDeleting = $_SESSION['failedDeleting'];
		if($failedDeleting == 1) {
			$_SESSION['failedDeleting'] = 0;

			echo "<script type=\"text/javascript\">\n";
			echo "alert('You are not allowed to delete this comment!');\n";
			echo "</script>\n";			
		}
	}


// Get  category options
$sql = "SELECT * FROM CategoryOptions";
$s = $db->prepareStatement($sql);
$db->executeStatement($s);
$categories = $db->getResult($db);

// Get  existing community partners
$sql = "SELECT * FROM CommunityPartner ORDER BY community_partner";
$s = $db->prepareStatement($sql);
$db->executeStatement($s);
$partners = $db->getResult($db);

// Get lead data if lead exists
if(isset($_GET['lid'])){
	$lid = $_SESSION['lid'] = $_GET['lid']; // lid for lead_handler
	
	$sql = "SELECT * FROM CBEL_Lead WHERE lid=?";
	$stmt = $db->prepareStatement($sql);
	$db->bindParameter($db, 'i', $_GET['lid']);
	$db->executeStatement($stmt);
	$lead_info = $db->getResult($stmt);

	$sql = "SELECT * FROM CommunityPartner WHERE pid=?";
	$stmt = $db->prepareStatement($sql);
	$db->bindParameter($db, 'i', $lead_info[0]['pid']);
	$db->executeStatement($stmt);
	$partner_info = $db->getResult($stmt);
	
?>

<div class="well">
	<input type="button" class="btn btn-large btn-info" value="Export Lead" id="export"  onclick="exportLead()">
	<script>
		function exportLead(){
			var lids = ["<?php print $lid; ?>"];
			$.ajax({
				type: "POST",
				url: "export_handler.php",
				data: {lids: lids},
				success: function(result){
					alert(result);
				}
			});
		}
	</script>
</div>
	
<?php
}

if(array_key_exists("submit", $_POST)){

	if(!isValid($phonePattern, $_POST['phone']))
		$phoneERR = "Please use the form XXX-XXX-XXXX";

	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
    	$emailERR = "Please use the form email@domain.ca";
}
?>
<form name="form"id="form" action="index.php?content=lead_handler" method="POST">
	<h4><strong>Community Partner:</strong></h4>
	<hr />
	
	<div class="jumbotron">
		<div class="row">
			<label for="existingPartner" class="col-md-2 control-label">Existing Partner:</label>
			<div class="col-md-8">
				<select class="form-control" name="existingPartner" id="existing" placeholder="Select One">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						print "<option>Please Select One</option>";
						foreach($partners as $row){
							if($row['contact_name'] != NULL){
								echo "<option value='{$row['community_partner']}".','."{$row['contact_name']}".','."{$row['phone']}".','."{$row['email']}' 
											$selected >".$row['community_partner']." - ".
												$row['contact_name']."</option>";
							}
						}
					?>
				</select>
			</div>	
		</div>
	</div>
	
	<div class="jumbotron">
		<div class="row">
			<label for="partner" class="control-label col-md-2">Community Partner:</label>
			<div class="col-md-4 controls">
					<input type="text" class="form-control" name="partner" id="partner" placeholder="Enter Community Partner"
						value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['community_partner']);?>">
			</div>
			
			<label for="contact_name" class="col-md-2 control-label">Contact Name:</label>
			<div class="col-md-4">
					<input type="text" class="form-control" name="contact_name" id="contact_name"placeholder="Enter Contact Name"
						value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['contact_name']);?>">
			</div>
		</div>
		
		<div class="row">
			<label for="phone" class="col-md-2 control-label">Contact Phone:</label>
			<div class="col-md-4">
					<input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Valid Phone Number"
						value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['phone']);?>">
					<span class="error"><?php echo $phoneERR;?></span>
			</div>
		
			<label for="email" class="col-md-2 control-label">Contact Email:</label>
			<div class="col-md-4">
					<input type="email" class="form-control" name="email" id="email" placeholder="Enter Valid Email Address"
						value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['email']);?>">
			</div>
			
			<!-- Automatically fill partner information if partner selected from select box -->
			<script>
				var partner = document.getElementById('partner');
				var contact = document.getElementById('contact_name');
				var phone = document.getElementById('phone');
				var email = document.getElementById('email');
				var existingPartner = document.getElementById('existing');

				existingPartner.onchange = function(){
					var str = this.value;
					var values = str.split(",");
					
					partner.value = values[0];
					contact.value = values[1];
					phone.value = values[2];
					email.value = values[3];
				}
			</script>
		</div>
	</div>

	<h4><strong>Lead:</strong></h4>
	<hr />
	
	<div class="jumbotron">
		<div class="row">
			<label for="lead_name" class="col-md-2 control-label">Lead Name:</label>
			<div class="col-md-4">
					<input type="text" class="form-control" name="lead_name" placeholder="Enter a Name for the Lead"
						value="<?php if($lead_info) echo htmlspecialchars($lead_info[0]['lead_name']);?>">
			</div>
			
			<label for="description" class="col-md-2 control-label">Description:</label>
			<div class="col-md-4">
					<textarea class="form-control" name="description" rows="6" placeholder="Enter a Brief Description of the 
						Lead"><?php if($lead_info) echo htmlspecialchars($lead_info[0]['description']);?></textarea>
			</div>
		</div>
		
		<div class="row">
			<label for="idea_type" class="col-md-2 control-label">Idea Type:</label>
			<div class="col-md-4">
				<select class="form-control" name="idea_type">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['idea_type'], $row['idea_type']) !== false){
								$selected = 'selected';
							}
							
							if($row['idea_type'] != NULL){
								echo "<option value='{$row['idea_type']}' $selected >".$row['idea_type']."</option>";
							}
						}
					?>
				</select>
			</div>
			
			<label for="referral" class="col-md-2 control-label">Possible Program Referral:</label>
			<div class="col-md-4">
				<select multiple="multiple" class="multiselect" name="referral[]" size="5">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['referral'], $row['referral']) !== false){
								$selected = 'selected';
							}
							if($row['referral'] != NULL)
								echo "<option value='{$row['referral']}' $selected >".$row['referral']."</option>";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="row">
			<label for="mandate" class="col-md-2 control-label">Organization's Mandate:</label>
			<div class="col-md-4">
				<select multiple="multiple" class="multiselect" name="mandate[]" size="5">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['mandate'], $row['mandate']) !== false){
								$selected = 'selected';
							}
							if($row['mandate'] != NULL)
								echo "<option value='{$row['mandate']}' $selected >".$row['mandate']."</option>";
						}
					?>
				</select>
			</div>
			
			<label for="focus" class="col-md-2 control-label">Focus Area:</label>
			<div class="col-md-4">
				<select multiple="multiple" class="multiselect" name="focus[]" size="5">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['focus'], $row['focus']) !== false){
								$selected = 'selected';
							}
							if($row['focus'] != NULL)
								echo "<option value='{$row['focus']}' $selected >".$row['focus']."</option>";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="row">
			<label for="activities" class="col-md-2 control-label">Main Activities:</label>
			<div class="col-md-4">
				<select multiple="multiple" class="multiselect" name="activities[]" size="5">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['main_activities'], $row['main_activities']) !== false){
								$selected = 'selected';
							}
							if($row['main_activities'] != NULL)
								echo "<option value='{$row['main_activities']}' $selected >".$row['main_activities']."</option>";
						}
					?>
				</select>
			</div>
			
			<label for="delivery" class="col-md-2 control-label">Delivery Location:</label>
			<div class="col-md-4">
				<select multiple="multiple" class="multiselect" name="delivery[]" size="5">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['location'], $row['location']) !== false){
								$selected = 'selected';
							}
							if($row['location'] != NULL)
								echo "<option value='{$row['location']}' $selected >".$row['location']."</option>";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="row">
			
			<label for="startdate" class="col-md-2 control-label">Starting Date:</label>
				<div class="col-md-4">
								<input type="date" class="form-control" name="startdate" id="startdate" onchange="changedVal();" placeholder="Enter Starting Date"
							value="<?php if($lead_info) echo htmlspecialchars($lead_info[0]['startdate']);?>">
								<script type="text/javascript">
								function changedVal() {
							var NameValue = document.forms["form"]["startdate"].value;
							document.forms["form"]["enddate"].min = NameValue;
							document.forms["form"]["enddate"].value;
							}
							</script>
							</input>
		
				</div>
				<label for="enddate" class="col-md-2 control-label">Deadline:</label>
				<div class="col-md-4">
								<input type="date"  class="form-control" name="enddate" id="enddate" onchange="some();" placeholder="Enter Deadline"
							<?php if($lead_info) echo 'value="'.htmlspecialchars($lead_info[0]['enddate']).'"';?>>
							<script type="text/javascript">
								function some() {
							alert(document.forms["form"]["enddate"].min);
							alert(document.forms["form"]["enddate"].value);
							}
							</script>
							
							</input>
				</div>
		</div>
		
		<div class="row">
			<label for="status" class="col-md-2 control-label">Current Status</label>
			<div class="col-md-4">
				<select class="form-control" name="status">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['status'], $row['status']) !== false){
								$selected = 'selected';
							}
							if($row['status'] != NULL)
								echo "<option value='{$row['status']}' $selected >".$row['status']."</option>";
						}
					?>
				</select>
			</div>
			<label for="disciplines" class="col-md-2 control-label">Possible Disciplines:</label>
			<div class="col-md-4">
				<select multiple="multiple" class="multiselect" name="disciplines[]" size="5">
					<?php
						// Populate each option from database. Automatically selects options that associated with the lead
						foreach($categories as $row){
							$selected = '';
							if(strpos($lead_info[0]['disciplines'], $row['disciplines']) !== false){
								$selected = 'selected';
							}
							if($row['disciplines'] != NULL)
								echo "<option value='{$row['disciplines']}' $selected >".$row['disciplines']."</option>";
						}
					?>
				</select>
			</div>
			
			
		</div>
		<div class="row">		
			<label for="yes" class="col-md-2 control-label">Tag Self?:</label>
			<div class="col-md-4">
				<div class="radio-inline">
						<input type="radio" name="Ntag" value="1" <?php
				if($nh->isTag($_SESSION["User_ID"], $lidNotif)){
				?> checked <?php } ?> >Yes &nbsp;&nbsp;&nbsp;
				</div>
				<div class="radio-inline">
						<input type="radio" name="Ntag" value="2"<?php
				if(!($nh->isTag($_SESSION["User_ID"], $lidNotif))){
				?> checked <?php } ?>>No
				</div> 
			</div>
		</div>
	</div>
	
	<div class="row">
<?php
	// Delete button only shows up when edititin existing lead, not when adding a new lead
	if(isset($_GET['lid'])){ 
?>
		<div class="col-md-1">
			<input type="submit" class="btn btn-large btn-danger" name="delete" value="Delete Lead" 
					onclick="return confirm('Are you sure?');">
			<input type="hidden" name="submit" value="submit">
		</div>
<?php
	}
?>
		<div class="col-md-offset-11">
			<input type="submit" class="btn btn-large btn-primary" name="submit" value="Submit">
				<input type="hidden" name="submit" value="submit">
		</div>
	</div>
</form>

<?php
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//=========================================================================================================================


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

<div class="container" style="margin-top:15px">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="row clearfix">
                <div class="col-md-12 column">
                    <h2>Similar Leads</h2>
                    <table class="table">
                        <?php
                            foreach($listOfLinks as $link) {
                                print "<tr><td><a href=index.php?content=lead_edit&lid=".$link['lid_link'].">"
                                        .$link['lead_name']."</a></td>"
                                        ."<td><a href='remove_link.php?main=".$_GET['lid']."&link=".$link['lid_link']."' class='btn btn-large btn-danger'>Remove Link</a>";
                            }
                            ?>
                    </table>
                    
                    <div class="col-md-4 dropup">
                        <form>
                        
                            <select class="form-control" id='link'>
                                <?php
									print "<option>Please Select One</option>";
                                    foreach($listOfLeads as $lead) {
                                        print "<option value='".$lead['lid']."'>".$lead['lead_name']."</option>";
                                    }
                                ?>
                            </select>
                        </form>
                    </div>
                        <div class="col-md-8">
                            <input type ="button" value="Link" onClick="link_lead(<?php print $_GET['lid']; ?>)" class="btn btn-large btn-info" >
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
            
        window.location.href = "link_lead.php?main=" + main + "&link=" + link;

        }
    
    </script>
    
    <br>

	<?php if(isset($_GET['lid'])) :?> 
	<div class="well">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="row clearfix">
				<div class="col-md-12 column">
				 	<h2 class="comments-title">Comments 
					
					<?php if(isset($_GET['page'])) {
								$page = $_GET['page'];
							}else {
								$page = 1;	
							}
							echo "<p><small>(page:";
							echo $page;
							echo ")</small></p>";
					?>
					</h2> 
					
					<ol id="commentList" class="commentList">
					
					<?php
					if(isset($_POST['commentSubmit'])) {
						$postedComment = htmlentities($_POST['commentBox']);

						if(strlen(trim($postedComment)) < 1) {
							echo "<script type=\"text/javascript\">\n";
							echo "alert('Please fill in the comment box!');\n";
							echo "</script>\n";

						}else {
							global $db;
							global $lead_info;

							$userName = $_SESSION['Input_username'];
							$selectedLeadID = htmlspecialchars($lead_info[0]['lid']);

							$sql = "INSERT INTO comment (username, lid, regDate, post) VALUES ('$userName', '.$selectedLeadID.', CURRENT_TIMESTAMP, '$postedComment')";

							$stml= $db->prepareStatement($sql);	
							$db->executeStatement($stml);

							$nh->turnon($selectedLeadID);
	
							echo "<script type=\"text/javascript\">\n";
							echo "document.commentBox.value = \"\";\n";
							echo "</script>\n";
						}	
					}
					?>
					
					<?php

					global $db;
					global $lead_info;
					
					$currentUsername = $_SESSION['Input_username'];
					
					$selectedLeadID = htmlspecialchars($lead_info[0]['lid']);
					$sql = "SELECT * FROM comment WHERE lid = '$selectedLeadID'";  

					$stml= $db->prepareStatement($sql);	
					$db->executeStatement($stml);
					$temp = $db->getResult($db);
					$totalNumOfComments = $db->getAffectedRows($db);
				
					if(!($totalNumOfComments == 0)) {

						if(isset($_GET['page'])) {
							$currentPage = $_GET['page'];
							if($currentPage < 0) {
								$currentPage = 1;
							}
						}else {
							$currentPage = 1;
						}
						
						$commentPerPage = 6;

						$startComment = $commentPerPage*($currentPage - 1);
						$commentToGet = $commentPerPage;
						
						

						if($startComment + $commentToGet > $totalNumOfComments) {
							$commentToGet = $totalNumOfComments - $startComment;
						}
						
						
					
						$sql = "SELECT * FROM comment WHERE lid = '$selectedLeadID' ORDER BY regDate DESC LIMIT $startComment, $commentToGet";  

						$stml= $db->prepareStatement($sql);	
						$db->executeStatement($stml);
						$listOfComments = $db->getResult($db);
						$rows = $db->getAffectedRows($db);
							

						foreach($listOfComments as $comm) {
								
							$currentUserName = $comm['username'];
							$sql = "SELECT * FROM user WHERE username = '$currentUserName'";

							$stml= $db->prepareStatement($sql);	
							$db->executeStatement($stml);

							$commentedUser = $db->getResult($db);
							
							echo
								'<li id=',
									$comm['cid'],
								'>',
									'<article id=',
										$comm['cid'],
									'>',
												
									'<header>',
										'<a href = "#commentList" title = ',
										$commentedUser[0]['email'],
												
									'>',	
											'<cite>',
												$comm['username'],
												' (',
													$commentedUser[0]['firstname'],
													" ",
													$commentedUser[0]['lastname'],						
												')  ',
												
											'</cite>',
										'</a>',

										'<time>',
											" ",
											$comm['regDate'],
											
										'</time>',
										'<a href = "./commentDelete.php?commentID='.$comm['cid'].'&leadID='.$selectedLeadID.'&loginUser='.$currentUsername.'&pg='.$currentPage.' "class= "deleteCSS"">',
											' Delete',
										'</a>',
										

									'</header>',

									'<section class= "commentCSS" ',
									'>',
									'<p>',
									$comm['post'],
									'</p>',
									'</section>',
									'</article>',
								'</li>';
						}						
					}							
					?>			
					
				
					<ul class="pagination">
					<?php
					global $currentPage;
					global $totalNumOfComments;
					
					if($totalNumOfComments != 0) {
					
					$commentPerPage = 6;

					$pagePerBlock = 2;
					$currentBlock = ceil($currentPage/$pagePerBlock);
					$totalPage = ceil($totalNumOfComments/$commentPerPage);
					$totalBlock = ceil($totalPage/$pagePerBlock);
				
					if(1 < $currentBlock) {
						$prevPage = ($currentBlock-1)*$pagePerBlock;
						echo'<li><a href ="http://'.$_SERVER['HTTP_HOST'].'/project/scripts/index.php?content=lead_edit&lid='.$selectedLeadID.'&page='.$prevPage.'#commentList">Prev</a></li>';
					}

					$startPage =($currentBlock-1)*$pagePerBlock+1;
					$endPage =$currentBlock*$pagePerBlock;
					if($endPage > $totalPage) {
						$endPage = $totalPage;
					}
					
					?>
					
					<?php for($i=$startPage; $i<=$endPage; $i++):?>
						<li> <a href="./index.php?content=lead_edit&lid=<?php echo $selectedLeadID; ?>&page=<?php echo $i; ?>#commentList"><?php echo $i; ?> </a> </li>
					<?php endfor?>
					
					<?php
					if($currentBlock < $totalBlock) {
						$nextPage = ($currentBlock)*$pagePerBlock+1;
						echo '<li> <a href="http://'.$_SERVER['HTTP_HOST'].'/project/scripts/index.php?content=lead_edit&lid='.$selectedLeadID.'&page='.$nextPage.'#commentList">Next</a> <li>';
					} 
					}
					?>
					</ul>	
				</div>
			</div>

			<div class="row clearfix">
				<div class="col-md-12 column">
					<p class="comment-form">
						<div>
							<label for="comment">Leave your comment</label>
						</div>

						<form action="" method="POST">
							<div>
								<textarea name="commentBox" id="commentBoxID" cols="105" rows="8" aria-required="true"></textarea> 
							</div>
							<div class="view" class = "deleteCSS" /*style = "margin-left:530px; margin-top: 30px"*/>
								<input type="submit" name="commentSubmit" id="commentSubmitID" value ="Post Comment" class="btn btn-primary">
							</div>	
						</form>
					</p>
				</div>
			</div>
		</div>
	</div>
	<?php endif?>
</div>
