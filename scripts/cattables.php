<?php

$DBServer = "localhost";
$DBUser = "root";
$DBPass = "";
$DBName = "cbel_db";

$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

if($conn->connect_error) {
	trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
}

?>

<!-- The nested collapse tables-->
<div class="row" style="padding-top:50px">
    
    <div class="col-md-10 column col-md-offset-1" style="height:600px; overflow:scroll">
        <table class="table table-striped">
            <thead>
		<tr>
                    <th>
			Categories
                    </th>
                                        
                </tr>
            </thead>
            <tbody>
                <tr><td><div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class ="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    Idea Type
                                </a>
                            </h4>
                        </div>
                    <div id="collapseOne" class="panel-collapse collpase collapse">
                        <div class="panel-body">
                            <table class="table table-condensed">
                            <?php
                                global $conn;
                                $sql = "SELECT idea_type FROM categoryoptions";
                                $result = $conn->query($sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $listOfSubcats[] = $row;
                                }
                                foreach($listOfSubcats as $subcat) {
                                 if (isset($subcat['idea_type'])) {
                                    print "<tr><td>".$subcat['idea_type']."</td>".
                                            "<td><a href='index.php?content=admin' class='btn btn-large btn-info'>Edit</a>".
                                            "<a href='index.php?content=admin' class='btn btn-large btn-danger'>Remove</a>".
                                            "</td></tr>";
                                 }
                                }
                            ?>
                                <tr><td><form role="form">
                                        <input type="text" class="form-control" id="optionName" placeholder="Option Name">
                                </form>
                                    </td>
                                    <td><button type="submit" class="btn btn-large btn-success">Add Option</button></td>
                                </tr>
                            </table>    
                        </div>
                     </div>
                </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class ="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                    Possible Program Referral
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collpase collapse">
                            <div class="panel-body">
                                Hidden Content 1
                            </div>
                            
                        </div>
                    </div>
                        
                </div>
                </td></tr>
            </tbody>
            
        </table>
    </div>
</div>