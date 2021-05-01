var base_url;

$("#register_form").on('submit', function(e) {
	e.preventDefault();

	$("#register_btn").attr('disabled', 'disabled');
	if( !$("#checkbox_signup").is(':checked') ) {
		swal({
		    icon: 'warning',
		    title: 'Oops!',
		    text: 'Please indicate that you accept our Terms & Conditions.',
		});
		$("#checkbox_signup").focus();
		$("#register_btn").removeAttr('disabled');
		return false;
	}

	$.ajax({
		url: base_url+'register/account',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
	})
	.done(function(res) {
		if (res.data.status == 'success') {
	        swal({
			  	title: "Success!",
			  	text: res.data.message,
			 	icon: 'success',
			  	button: "You can now login!",
			  	closeOnClickOutside: false,
			}).then(function() {
			    window.location = base_url+"login";
			});
		}
		else{
			if (res.data.message.email_address) {
				swal({
				  	title: "Error!",
				  	text: res.data.message.email_address,
				 	icon: 'error',
				  	button: "Try again!",
				});
			}
			else if(res.data.message.mobile_number) {
				swal({
				  	title: "Error!",
				  	text: res.data.message.mobile_number,
				 	icon: 'error',
				  	button: "Try again!",
				});
			}


			$('html, body').animate({
			    scrollTop: 0
			}, 800);
		}
		$("#register_btn").removeAttr('disabled')
	})
	.fail(function() {
		console.log("error");
	})
})