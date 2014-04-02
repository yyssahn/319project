<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>CBEL Tracker</title>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="../bootstrap/js/jquery-2.1.0.min.js"></script>
		
		<!-- Bootstrap -->
		<link href="../bootstrap/css/bootstrap-3.1.1.css" rel="stylesheet">
		<script src="../bootstrap/js/bootstrap-3.1.1.min.js"></script>
		
		<!-- Multiselect Plugin: -->
		<script type="text/javascript" src="../bootstrap/js/bootstrap-multiselect.js"></script>
		<link rel="stylesheet" href="../bootstrap/css/bootstrap-multiselect.css" type="text/css"/>
		<!-- Initialize the plugin: -->
		<script type="text/javascript">
			$(document).ready(function() {
				$('.multiselect').multiselect();
			});
		</script>

		<!-- For validation plugin -->
		<link href="style.css" rel="stylesheet">
		<script src="js/modernizr-2.5.3.min.js"></script>
		<script src="../bootstrap/js/jquery.validate.min.js"></script>
		<script src="script.js"></script>	
		
		<!-- For lead comments -->
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
		
		<!-- DIfferent styles for multiselect plugin -->
		<script type="text/javascript">
			    $(document).ready(function() {
					$('#example14').multiselect({
			            buttonWidth: '500px',
			            buttonText: function(options) {
			                if (options.length === 0) {
			                    return 'None selected <b class="caret"></b>';
			                }
			                else {
			                    var selected = '';
			                    options.each(function() {
			                        selected += $(this).text() + ', ';
			                    });
			                    return selected.substr(0, selected.length -2) + ' <b class="caret"></b>';
			                }
			            }
			        });
					$('#example21').multiselect({
						includeSelectAllOption: true,
						enableFiltering: true,
						buttonWidth: '500px',
						onChange: function(option, checked) {
                            var values = [];
                            $('#example21 option').each(function() {
                                if ($(this).val() !== option.val()) {
                                    values.push($(this).val());
                                }
                            });
                            
                            $('#example21').multiselect('deselect', values);
                        }
					});
					$('#example40').multiselect({
                        onChange: function(option, checked) {
                            var values = [];
                            $('#example40 option').each(function() {
                                if ($(this).val() !== option.val()) {
                                    values.push($(this).val());
                                }
                            });
                            
                            $('#example40').multiselect('deselect', values);
                        }
                    });
					$('#example41').multiselect({
                        onChange: function(option, checked) {
                            var values = [];
                            $('#example41 option').each(function() {
                                if ($(this).val() !== option.val()) {
                                    values.push($(this).val());
                                }
                            });
                            
                            $('#example41').multiselect('deselect', values);
                        }
                    });
				});
		</script>
	</head>
  
	<body>
		<h1>Welcome to CBEL Tracker</h1>
		<br />