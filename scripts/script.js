/*For multiselect plugin */
$(document).ready(function() {
	$('.multiselect').multiselect({
		includeSelectAllOption: true,
		enableFiltering: true,
		buttonWidth: '346px',
		buttonHeight: '346px',
		buttonText: function(options) {
			if (options.length === 0) {
				return 'None selected <b class="caret"></b>';
			}
			else if (options.length > 0) {
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
	$('.single').multiselect({
		buttonWidth: '346px'
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

/* Pressing Enter works same as clicking Search Button*/
function enterFunction(event) {
	if(event.keyCode == 13) {
		document.getElementById('searchButton').click();
	}
}

/*For downloading CSVs */
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