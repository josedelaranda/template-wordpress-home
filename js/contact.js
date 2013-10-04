jQuery(function() {

	 $("#quick_contact").validate({

	    invalidHandler: function(form, validator) {
	      var errors = validator.numberOfInvalids();
	      if (errors) {
	        var message ='All fields are required.';
	        $("#messageBox").html(message);
	        $("#messageBox").show();
	      } else {
	        $("#messageBox").hide();
	      }
	    },
	    showErrors: function(errorMap, errorList) {

	    },
	    submitHandler: function() {

				var form = jQuery('#quick_contact');
				var action_val = form.attr('action');	
				
				jQuery.ajax({
					type: "POST",
					url: action_val,
					data: form.serialize(),
					//data: dataString,
					success: function() {
						jQuery('#form_content_1').hide();
						jQuery('#form_content_2').fadeIn();

						setTimeout(function(){
							jQuery('#form_content_2').hide();
							jQuery('#form_content_1').fadeIn();
						}, 6000);
				  }
				 });

				 $(form)[0].reset();
				

				return false;
			}

	 })
	
  
});