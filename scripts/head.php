<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>CBEL Tracker</title>

		<!-- Bootstrap -->

		<link href="../bootstrap/css/bootstrap-3.1.1.css" rel="stylesheet">
		<script src="../bootstrap/js/jquery-2.1.0.min.js"></script>
		<script src="../bootstrap/js/jquery.smooth-scroll.min.js"></script>
		<script src="../bootstrap/js/bootstrap-3.1.1.js"></script>
		<script src="../bootstrap/js/retro.js"></script>
			
		<!-- Multiselect Plugin: -->
		<link rel="stylesheet" href="../bootstrap/css/bootstrap-multiselect.css" type="text/css"/>
		<script type="text/javascript" src="../bootstrap/js/bootstrap-multiselect.js"></script>

		<!-- For validation plugin -->
		<link href="style.css" rel="stylesheet">
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
		
		<!-- Set styles for multiselect plugin -->
		<script type="text/javascript">
			$(document).ready(function() {
				$('.multiselect').multiselect({
					includeSelectAllOption: true,
					enableFiltering: true,
					buttonWidth: '319px',
					buttonText: function(options) {
						if (options.length === 0) {
							return 'None selected <b class="caret"></b>';
						}
						else if (options.length > 3) {
							return options.length + ' selected  <b class="caret"></b>';
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
				$('#existing').multiselect({
					enableFiltering: true,
					buttonWidth: '500px',
				});
				$('#link').multiselect({
					includeSelectAllOption: true,
					enableFiltering: true,
					buttonWidth: '360px',
					onChange: function(option, checked) {
						var values = [];
						$('#link option').each(function() {
							if ($(this).val() !== option.val()) {
								values.push($(this).val());
							}
						});
						
						$('#link').multiselect('deselect', values);
					}
				});
			});
		</script>
		
		<script language ="javascript">
			function enterFunction(event) {
				if(event.keyCode == 13) {
					document.getElementById('searchButton').click();
				}
			}
		</script>

		<!-- For downloading CSVs -->
		<script>
			function downloadLead(){
				$.ajax({
					type: "POST",
					url: "export_handler.php",
					data: {lead: 'lead'},
					success: function(filename){
							window.location=filename;
					},
					error: function(filename){
						alert("Please export at least one CBEL Lead to the CSV");
					}
				});
			}
			function downloadPartner(){
				$.ajax({
					type: "POST",
					url: "export_handler.php",
					data: {partner: 'partner'},
					success: function(filename){
						window.location=filename;
					}
				});
			}
		</script>
	</head>
  
	<body>