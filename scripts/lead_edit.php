<div class="page-header">
	<h2>Lead Edit Page Mother Fucker!</h2>
</div>
<head>
	<style type="text/css">
	.commentList{
				width: 600px;
				margin-top: 100 auto;		
				
				}
	
	.commentCSS{
			border-bottom: 2px solid #eee;
			margin-bottom: 0.5em;
			font-family: Verdana, Geneva, sans-serif;
			font-size: 12px;

	}
	.deleteCSS{
			float: right;
	}
	</style>

</head>
<?php

	include('database_helper.php');
	
	$TelepERR = '';
	
	$lead_info = array();
	$partner_info = array();
	
	// Connect to database
	$db = new DatabaseHelper();
	
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

/*
	// Checking whether deleting comment is failed or not ---> might not use this
	if(isset($_GET['deleteComment'])) {
		$succeedDeleting = $_GET['deleteComment'];
		if($succeedDeleting == 0) {
			$theLead = $_GET['lid'];
			echo "<script type=\"text/javascript\">\n";
			echo "alert('You are not allowed to delete this comment!');\n";
			echo "</script>\n";			
		}
	}
*/

	
	// Get lead data if lead exists
	if(isset($_GET['lid'])){
		$_SESSION['lid'] = $_GET['lid']; // lid for lead_handler
		
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
	}
?>
	<form id="form" action="index.php?content=lead_handler" method="POST">
		<h4><strong>Community Partner:</strong></h4>
		<hr />
		<div class="jumbotron">
			<div class="row">
				<label for="partner" class="control-label col-md-2">Community Partner:</label>
				<div class="col-md-4 controls">
						<input type="text" class="form-control" name="partner" id="partner" placeholder="Enter Community Partner"
							value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['community_partner']);?>">
				</div>
				
				<label for="contact_name" class="col-md-2 control-label">Contact Name:</label>
				<div class="col-md-4">
						<input type="text" class="form-control" name="contact_name" placeholder="Enter Contact Name"
							value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['contact_name']);?>">
				</div>
			</div>
			
			<div class="row">
				<label for="phone" class="col-md-2 control-label">Contact Phone:</label>
				<div class="col-md-4">
						<input type="text" class="form-control" name="phone" placeholder="Enter Valid Phone Number"
							value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['phone']);?>">
						<span class="error"><?php echo $TelepERR;?></span>
				</div>
			
				<label for="email" class="col-md-2 control-label">Contact Email:</label>
				<div class="col-md-4">
						<input type="email" class="form-control" name="email" placeholder="Enter Valid Email Address"
							value="<?php if($partner_info) echo htmlspecialchars($partner_info[0]['email']);?>">
				</div>
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
						<textarea class="form-control" name="description" rows="4" placeholder="Enter a Brief Description of the 
							Lead"><?php if($lead_info) echo htmlspecialchars($lead_info[0]['description']);?></textarea>
				</div>
			</div>
			
			<div class="row">
				<label for="idea_type" class="col-md-2 control-label">Idea Type:</label>
				<div class="col-md-4">
					<select class="form-control" name="idea_type" placeholder="Select One">
						<?php
							// Populate each option from database. Automatically selects options that associated with the lead
							echo "<option>".NULL."</option>";
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
					<select multiple="multiple" class="form-control" name="referral[]" size="5">
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
					<select multiple="multiple" class="form-control" name="mandate[]" size="5">
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
					<select multiple="multiple" class="form-control" name="focus[]" size="5">
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
					<select multiple="multiple" class="form-control" name="activities[]" size="5">
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
					<select multiple="multiple" class="form-control" name="delivery[]" size="5">
						<?php
							// Populate each option from database. Automatically selects options that associated with the lead
							foreach($categories as $row){
								$selected = 'selected';
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
				<label for="disciplines" class="col-md-2 control-label">Possible Disciplines:</label>
				<div class="col-md-4">
					<select multiple="multiple" class="form-control" name="disciplines[]" size="5">
						<?php
							// Populate each option from database. Automatically selects options that associated with the lead
							foreach($categories as $row){
								$selected = 'selected';
								if(strpos($lead_info[0]['disciplines'], $row['disciplines']) !== false){
									$selected = 'selected';
								}
								if($row['disciplines'] != NULL)
									echo "<option value='{$row['disciplines']}' $selected >".$row['disciplines']."</option>";
							}
						?>
					</select>
				</div>
				
				<label for="timeframe" class="col-md-2 control-label">Timeframe:</label>
				<div class="col-md-4">
					<select class="form-control" name="timeframe">
						<?php
							// Populate each option from database. Automatically selects options that associated with the lead
							foreach($categories as $row){
								$selected = 'selected';
								if(strpos($lead_info[0]['timeframe'], $row['timeframe']) !== false){
									$selected = 'selected';
								}
								if($row['timeframe'] != NULL)
									echo "<option value='{$row['timeframe']}' $selected >".$row['timeframe']."</option>";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row">
				<label for="status" class="col-md-2 control-label">Current Status</label>
				<div class="col-md-4">
					<select class="form-control" name="status">
						<?php
							// Populate each option from database. Automatically selects options that associated with the lead
							echo "<option>".NULL."</option>";
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
				
				<label for="yes" class="col-md-2 control-label">Tag Self?:</label>
				<div class="col-md-4">
					<div class="radio-inline">
							<input type="radio" name="tag" value="1" checked>Yes &nbsp;&nbsp;&nbsp;
					</div>
					<div class="radio-inline">
							<input type="radio" name="tag" value="2">No
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
				<input type="submit" class="btn btn-large btn-danger" name="delete" value="Delete Lead">
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
	
	<?php if(isset($_GET['lid'])) :?> 
	<div class="container">
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
					
					<ol class="commentList">
					
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
	
							echo "<script type=\"text/javascript\">\n";
							echo "document.commentBoxID.value = \"\";\n";
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
										'<a href = "" title = ',
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
						echo'<li><a href ="http://'.$_SERVER['HTTP_HOST'].'/project/scripts/index.php?content=lead_edit&lid='.$selectedLeadID.'&page='.$prevPage.'">Prev</a></li>';
					}

					$startPage =($currentBlock-1)*$pagePerBlock+1;
					$endPage =$currentBlock*$pagePerBlock;
					if($endPage > $totalPage) {
						$endPage = $totalPage;
					}
					
					?>
					
					<?php for($i=$startPage; $i<=$endPage; $i++):?>
						<li> <a href="./index.php?content=lead_edit&lid=<?php echo $selectedLeadID; ?>&page=<?php echo $i; ?>"><?php echo $i; ?> </a> </li>
					<?php endfor?>
					
					<?php
					if($currentBlock < $totalBlock) {
						$nextPage = ($currentBlock)*$pagePerBlock+1;
						echo '<li> <a href="http://'.$_SERVER['HTTP_HOST'].'/project/scripts/index.php?content=lead_edit&lid='.$selectedLeadID.'&page='.$nextPage.'">Next</a> <li>';
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
								<textarea name="commentBox" id="commentBoxID" autofocus="autofocus" cols="105" rows="8" aria-required="true"></textarea> 
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
