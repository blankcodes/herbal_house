$("#_select_package").on('change', function() {
	package =  $(this).val();
	choosen = '';
	if (package == 'a') {
		choosen +='<ul>'
                +'<li>2 Spirulina Food Supplement</li>'
                +'<li>1 Purple Corn Juice</li>'
            +'</ul>'
        $("#_package_details").removeAttr('hidden', 'hidden');
	}
	else if (package == 'b') {
		choosen +='<ul>'
                +'<li>2 Spirulina Food Supplement</li>'
                +'<li>1 Buah Merah Juice</li>'
            +'</ul>'
        $("#_package_details").removeAttr('hidden', 'hidden');
	}
	else if (package == 'c') {
		choosen +='<ul>'
                +'<li>2 Spirulina Food Supplement</li>'
                +'<li>1 Herbal House Coffee</li>'
            +'</ul>'
        $("#_package_details").removeAttr('hidden', 'hidden');
	}

	else if (package == 'd') {
		choosen +='<ul>'
                +'<li>1 Spirulina Food Supplement</li>'
                +'<li>1 Mangosteen Dietary Supplement</li>'
                +'<li>1 Purple Corn Juice</li>'
            +'</ul>'
        $("#_package_details").removeAttr('hidden', 'hidden');
	}

	else if (package == 'e') {
		choosen +='<ul>'
                +'<li>1 Spirulina Food Supplement</li>'
                +'<li>1 Serpentina Food Supplement</li>'
                +'<li>1 Buah Merah Juice</li>'
            +'</ul>'
        $("#_package_details").removeAttr('hidden', 'hidden');
	}

	else if (package == 'f') {
		choosen +='<ul>'
                +'<li>1 Serpentina Food Supplement</li>'
                +'<li>1 Mangosteen Dietary Supplement</li>'
                +'<li>1 Herbal House Coffee</li>'
            +'</ul>'
        $("#_package_details").removeAttr('hidden', 'hidden');
	}
	else{
    	$("#_package_details").attr('hidden', 'hidden');
	}
	$("#_package_initial").text(package)
	$("#_package_choosen").html(choosen)
})

$('#_register_form').on('submit', function(e) {
	e.preventDefault();
    package_code = $('#_select_package').val();

    if (!package_code || package_code == '') {
        $.NotificationApp.send("Oh, Snap!","Package is Required","top-right","rgba(0,0,0,0.2)","error");
        $('html, body').animate({
            scrollTop: 0
        }, 800);
        return false;
    }
    $("#loader").removeAttr('hidden');
    $("#register_user_btn").attr('disabled','disabled');
	$.ajax({
		url: base_url+'api/v1/register/_register_new_user',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
	})
	.done(function(res) {
		if (res.data.status == 'success') {
            sweetAlert({
                title:'Success!',
                text: res.data.message,
                type:'success',
                allowOutsideClick: false,
                confirmButtonText: 'Okay!'
            },function(isConfirm){
                ('ok');
            });
            $('.swal2-confirm').click(function(){
               window.location.href=base_url+"login";
            });
			$("#register_user_btn").attr('disabled','disabled');
		}
		else if (res.data.status == 'failed' && res.data.message.mobile_number){
			$.NotificationApp.send("Oh, Snap!",res.data.message.mobile_number,"top-right","rgba(0,0,0,0.2)","error");
			$("#register_user_btn").removeAttr('disabled');
		}
		else if (res.data.status == 'failed' && res.data.message.username){
			$.NotificationApp.send("Oh, Snap!",res.data.message.username,"top-right","rgba(0,0,0,0.2)","error");
			$("#register_user_btn").removeAttr('disabled');
		}
		else if (res.data.status == 'failed' && res.data.message.password){
			$.NotificationApp.send("Oh, Snap!",res.data.message.password,"top-right","rgba(0,0,0,0.2)","error");
			$("#register_user_btn").removeAttr('disabled');
		}
		else if (res.data.status == 'failed' && res.data.message.email_address){
			$.NotificationApp.send("Oh, Snap!",res.data.message.email_address,"top-right","rgba(0,0,0,0.2)","error");
			$("#register_user_btn").removeAttr('disabled');
		}
		else {
			$.NotificationApp.send("Oh, Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
			$("#register_user_btn").removeAttr('disabled');
		}
        $("#loader").attr('hidden','hidden');
		newCsrfData();
	})
	.fail(function() {
        $("#loader").attr('hidden','hidden');
	})
})