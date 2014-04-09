//
//	jQuery Validate example script
//
//	Prepared by David Cochran
//
//	Free for your use -- No warranties, no guarantees!
//

$(document).ready(function(){
	// Validate
	// http://bassistance.de/jquery-plugins/jquery-plugin-validation/
	// http://docs.jquery.com/Plugins/Validation/
	// http://docs.jquery.com/Plugins/Validation/validate#toptions

		$.validator.addMethod("pattern", function(value, element, regexpr){
			return this.optional(element) || regexpr.test(value);
		}, "Please use the format: XXX-XXX-XXXX");
		
		$('#form').validate({
	    rules: {
	      partner: {
	        minlength: 2,
	        required: true
	      },
		  contact_name: {
	      	minlength: 2,
	        required: true
	      },
		  phone: {
			required: false,
			pattern:  /^[0-9]{3}-[0-9]{3}-[0-9]{4}$/
		  },
		  ppartner:{
			required: false,
			pattern:  /^[0-9]{3}-[0-9]{3}-[0-9]{4}$/
		  },
		  pNum:{
			required: false,
			pattern:  /^[0-9]{3}-[0-9]{3}-[0-9]{4}$/
		  },
	      email: {
	        required: true,
	        email: true
	      },
	      lead_name: {
	        minlength: 2,
	        required: true
	      },
		  description: {
	        minlength: 2,
	        required: true
	      },
		  fpartner: {
			minlength: 2,
	        required: true
		  },
		  lpartner: {
			minlength: 2,
	        required: true
		  },
		  Fname: {
			minlength: 2,
	        required: true
		  },
		  Lname: {
			minlength: 2,
	        required: true
		  },
		  user: {
			minlength: 2,
	        required: true
		  },
		  pswd: {
			minlength: 8,
	        required: true
		  },
		  confirmpswd: {
			minlength: 8,
	        required: true
		  },
		  emailAddr: {
			minlength: 2,
	        required: true
		  },
		  signupkey: {
			minlength: 2,
	        required: true
		  }
	    },
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });

}); // end document.ready