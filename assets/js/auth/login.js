var base_url;

$("#show_password").on('click', function() {
	$("#password").attr('type','text');
	$(this).attr('hidden','hidden');
	$("#hide_password").removeAttr('hidden');
})
$("#hide_password").on('click', function() {
	$("#password").attr('type','password');
	$(this).attr('hidden','hidden');
	$("#show_password").removeAttr('hidden');
})
$("#_forgot_password").on('click', function() {
	swal({
		title: "Forgot Password",
		text: "Please contact the website Admin to reset your password!",
		icon: 'info',
		button: "Okay",
	});
})
$("#login_form").on('submit', function(e) {
	e.preventDefault();
	$("#login_btn").attr('disabled','disabled').text('Please wait...');
	$.ajax({
		url: base_url+'api/v1/account/_login',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
		statusCode: {
		403: function() {
			  	$.NotificationApp.send("Oh Snap!","Something went wrong! Refresh this page and try again!","top-right","rgba(0,0,0,0.2)","error");
			}
		}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$("#login_btn").text(res.data.message);
			setTimeout(function(){window.location.href=res.data.url}, 3000)
		}
		else{
			swal({
			  	title: "Error!",
			 	text: res.data.message,
				icon: 'error',
			  	button: "Try again!",
			});
			newCsrfData();
			$("#login_btn").removeAttr('disabled').text('Log In');
		}

	})
	.fail(function() {
		console.log("error");
		$("#login_btn").removeAttr('disabled').text('Log In');
		newCsrfData();
	})
})