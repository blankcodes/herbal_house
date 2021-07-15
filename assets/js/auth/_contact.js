$("#_contact_form").on('submit', function(e) {
	_fullname = $("#_fullname").val();
	_email_address = $("#_email_address").val();
	_subject = $("#_subject").val();
	_message = $("textarea#_message").val();

	if (!_fullname || _fullname == '') {
		$.NotificationApp.send("Oh, Snap!","Fullname is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	if (!_email_address || _email_address == '') {
		$.NotificationApp.send("Oh, Snap!","Email Address is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	if (!_subject || _subject == '') {
		$.NotificationApp.send("Oh, Snap!","Subject is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	if (!_message || _message == '') {
		$.NotificationApp.send("Oh, Snap!","Message is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	$("#loader").removeAttr('hidden');
	e.preventDefault();
	$.ajax({
		url: base_url+'api/v1/message/_send',
		type: 'POST',
		dataType: 'JSON',
        data: $(this).serialize(),
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			$("#_contact_form .form-control").val('')
		}
		else{
			$.NotificationApp.send("Oh, Snap!",res.data.message.email_address,"top-right","rgba(0,0,0,0.2)","error");
		}
		$("#loader").attr('hidden','hidden');
		newCsrfData();
	});
})