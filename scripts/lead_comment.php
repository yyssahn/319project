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
									<textarea name="commentBox" id="commentBoxID" style="width:70%"  rows="8" aria-required="true"></textarea> 
								</div>
								<div class="view" class = "deleteCSS" /*style = "margin-left:530px; margin-top: 30px"*/>
									<input type="submit" name="commentSubmit" id="commentSubmitID" value ="Post Comment" class="btn btn-primary btn-sm">
								</div>	
							</form>
						</p>
					</div>
				</div>
			</div>
	</div>