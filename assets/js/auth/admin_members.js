var base_url;
var page;

if (page == 'members_page') {
	showMemberList(1)
}
$('#member_list_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showMemberList(page_no);
});
$('#_search_member_list_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    _search_query = $("#_search_query").val();
    if (!_search_query || _search_query == '') {
		$.NotificationApp.send("Oh, Snap!","Search query is empty!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}
    searchUser( _search_query, page_no);
});
$("#_search_user_form").on('submit', function(e) {
	_search_query = $("#_search_query").val();
	page_no = 1;
	if (!_search_query || _search_query == '') {
		$.NotificationApp.send("Oh, Snap!","Search query is empty!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}
	e.preventDefault();
	searchUser(_search_query, page_no)
})
function searchUser(_search_query, page_no) {
	$("#_member_list_tbl").html('<tr class="text-center"><td colspan="8">Getting member list...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/users/_search',
		type: 'GET',
		dataType: 'JSON',
		data: {query:_search_query, page_no:page_no}
	})
	.done(function(res) {
		if (parseInt(res.count) > 0) {
			$('#member_list_pagination').attr('hidden','hidden');
			$('#_search_member_list_pagination').html(res.pagination).removeAttr('hidden');
			displayUsersList(res.count, res.result);
		}
		else{
			$("#_member_list_tbl").html('<tr class="text-center"><td colspan="8">No result found!</td></tr>');
		}
	})
	.fail(function(){
		$("#_member_list_tbl").html('<tr class="text-center"><td colspan="8">No result found!</td></tr>');
	})
}
function showMemberList (page_no) {
	$("#_member_count").text('0')
	$("#_member_list_tbl").html('<tr class="text-center"><td colspan="8">Getting member list...</td></tr>');
	$('#_search_member_list_pagination').html('');
	$('#member_list_pagination').html('');
	
	$.ajax({
		url: base_url+'api/v1/users/_get_member_list',
		type: 'GET',
		dataType: 'JSON',
		data: {page_no:page_no}
	})
	.done(function(res) {
		$('#member_list_pagination').removeAttr('hidden','hidden');
		$('#_search_member_list_pagination').attr('hidden','hidden');
		$('#member_list_pagination').html(res.pagination);
		displayUsersList(res.count, res.result);
	})
	.fail(function(){
		$("#_member_list_tbl").html('<tr class="text-center"><td colspan="8">No result found!</td></tr>');
	})
}
function displayUsersList (count, result) {
		string = '';
		status_type = '';
		invite_status = '';
		func_type = '';
		stockist_func = '';
		stockist_label = '';
		$("#_member_count").text(count)
		for(var i in result) {
			if (result[i].invite_status == 'active') {
				invite_status = 'success';
			}
			else{
				invite_status = 'danger';
			}

			if (result[i].status == 'disabled') {
				status_type = 'Enable Withdrawal';
				func_type = 'enableUser';
			}
			else{
				status_type = 'Disable Withdrawal';
				func_type = 'disableUser';
			}

			if (result[i].type == 'stockist') {
				stockist_func = 'removeStockist';
				stockist_label = 'Remove as a Stockist';
			}
			else{
				stockist_func = 'makeStockist';
				stockist_label = 'Make A Stockist';
			}
			
			string += '<tr>'
                    +'<td class="table-user">'
                        +'<a href="javascript:void(0);" class="text-body"">'+result[i].user_code+'</a>'
                    +'</td>'
                    +'<td>'
                        +'<span class="">'+result[i].username+'</span>'
                    +'</td>'
                    // +'<td>'
                    //     +'<span class="">'+result[i].name+'</span>'
                    // +'</td>'
                    +'<td>'
                        +'<span class=""><a target="_blank" href="'+base_url+'user/overview/'+result[i].sponsor_id+'">'+result[i].sponsor+'</a></span>'
                    +'</td>'
                     +'<td>'
                        +'<span class="">'+result[i].code_credits+'</span>'
                    +'</td>'
                    +'<td>'
                        +'<span class="">'+result[i].mobile_number+'</span>'
                    +'</td>'
                    +'<td>'
                        +'<span class=""><span class="badge badge-'+invite_status+'-lighten text-capitalize">'+result[i].invite_status+'</span></span>'
                    +'</td>'
                    +'<td class=""><span class="">'+result[i].created_at+'</td>'
                    
                    +'<td>'
                        +'<div class="dropdown">'
						    +'<button class="btn btn-light btn-sm dropdown-toggle font-12" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
						        +'Action'
						    +'</button>'
						    +'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'
						        +'<a class="dropdown-item" href="#view_info" onclick="viewInfo(\''+result[i].user_code+'\')">View Info</a>'
						        +'<a class="dropdown-item" target="_blank" href="'+base_url+'user/overview/'+result[i].user_code+'">View Stats</a>'
						        // +'<a class="dropdown-item" href="#">Edit</a>'
						        // +'<a class="dropdown-item" href="#" onclick="changePackage(\''+res.result[i].user_code+'\')">Change Package</a>'
						        +'<a class="dropdown-item" href="#delete_user" onclick="resetPassword(\''+result[i].user_code+'\',\''+result[i].name+'\')">Reset Password</a>'
						        +'<a class="dropdown-item" href="#stockist" onclick="'+stockist_func+'(\''+result[i].user_code+'\',\''+result[i].name+'\')">'+stockist_label+'</a>'
						        +'<a class="dropdown-item" href="#disabled_account" onclick="'+func_type+'(\''+result[i].user_code+'\',\''+result[i].name+'\')">'+status_type+'</a>'
						        +'<a class="dropdown-item" href="#delete_user" onclick="deleteUser(\''+result[i].user_code+'\',\''+result[i].name+'\')">Delete</a>'
						    +'</div>'
						+'</div>'
                    +'</td>'
           	+'</tr>'
		$("#_member_list_tbl").html(string);
	}
}

$("#_add_member").on('click', function() {
	$.ajax({
		url: base_url+'api/v1/package/_get_package_list_opt',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		string = '<option disabled="" selected="">Select Package</option>'
		for(var i in res.data) {
			string +='<option value="'+res.data[i].p_id+'">'+res.data[i].name+'</option>'
		}
		$("#_select_package").html(string);
	})
	$("#password").val('123456'); /* default password */
	$("#add_member_modal").modal('show');
})

$('#user_type').on('change', function() {
	user_type = $(this).val();
	if (user_type == 'member') {
	    $("#package_id").removeAttr('hidden');
	    $("#_select_package").val()
	}
	else if (user_type == 'admin'){
	    $("#_select_package").val('')
	    $("#package_id").attr('hidden','hidden');
	}	
})

$("#_register_new_member_form").on('submit', function(e){
	e.preventDefault();

	user_type = $('#user_type').val();
	package = $('#_select_package').val();

    if (!user_type || user_type == '') {
        $.NotificationApp.send("Oh, Snap!","User Type is Required","top-right","rgba(0,0,0,0.2)","error");
        $('html, body').animate({
            scrollTop: 0
        }, 800);
        return false;
    }
    if (user_type == 'member' && package == '') {
    	$.NotificationApp.send("Oh, Snap!","Package is Required","top-right","rgba(0,0,0,0.2)","error");
        $('html, body').animate({
            scrollTop: 0
        }, 800);
        return false;
    }

	$("#loader").removeAttr('hidden');
    $("#add_new_member").attr('disabled','disabled');
	$.ajax({
		url: base_url+'api/v1/register/_new_member',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			showMemberList (1)
			$("#add_new_member").removeAttr('disabled');
			$("#_register_new_member_form input").val('');
			$("#add_member_modal").modal('hide');
		}
		else if (res.data.status == 'failed' && res.data.message.mobile_number){
			$.NotificationApp.send("Oh, Snap!",res.data.message.mobile_number,"top-right","rgba(0,0,0,0.2)","error");
			$("#add_new_member").removeAttr('disabled');
		}
		else if (res.data.status == 'failed' && res.data.message.username){
			$.NotificationApp.send("Oh, Snap!",res.data.message.username,"top-right","rgba(0,0,0,0.2)","error");
			$("#add_new_member").removeAttr('disabled');
		}
		else if (res.data.status == 'failed' && res.data.message.password){
			$.NotificationApp.send("Oh, Snap!",res.data.message.password,"top-right","rgba(0,0,0,0.2)","error");
			$("#add_new_member").removeAttr('disabled');
		}
		else {
			$.NotificationApp.send("Oh, Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
			$("#add_new_member").removeAttr('disabled');
		}
        $("#loader").attr('hidden','hidden');
		newCsrfData();
	})
	.fail(function() {
        $("#loader").attr('hidden','hidden');
	})
	
})
function changePackage(user_code) {
	$.ajax({
		url: base_url+'api/v1/package/_get_package_list_opt',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		string = '<option disabled="" selected="">Select Package</option>'
		for(var i in res.data) {
			string +='<option value="'+res.data[i].p_id+'">'+res.data[i].name+'</option>'
		}
		$("#__select_package").html(string);
		$("#_user_code").val(user_code);
		$("#change_user_package_modal").modal('show')
	})
}
$("#_change_package_form").on('submit', function(e) {
	e.preventDefault();

	package = $('#__select_package').val();

	if (!package || package == '') {
		$.NotificationApp.send("Oh, Snap!","Package is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/package/_update_user_package',
		type: 'POST',
		dataType: 'JSON',
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("Oh, Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		else{
			$.NotificationApp.send("Oh, Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		$("#change_user_package_modal").modal('show')
		$("#loader").attr('hidden','hidden');
	})

})
function deleteUser(user_code, name){
	sweetAlert({
		title:'Delete User?',
		text: "User "+name+" will be deleted! This cannot be undone once proceed.",
		type:'warning',
		showCancelButton: true,
		confirmButtonColor: '#3699ff',
		cancelButtonColor: '#98a6ad',
		confirmButtonText: 'Yes, proceed!'
	},function(isConfirm){
		('ok');
	});
	$('.swal2-confirm').click(function(){
		$("#loader").removeAttr('hidden','hidden');
		$.ajax({
			url: base_url+'api/v1/user/_delete_user',
			type: 'POST',
			dataType: 'JSON',
			data: {user_code:user_code, name:name}
		})
		.done(function(res) {
			if (res.data.status == 'success') {
				$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
				showMemberList(1)
			}
			if (res.data.status == 'failed') {
				$.NotificationApp.send("Error!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
				showMemberList(1)
			}
			else{
				$.NotificationApp.send("Oh, Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
			}
			$("#loader").attr('hidden','hidden');
		})
		$("#loader").attr('hidden','hidden');

	});
}
function disableUser(user_code, name){
	sweetAlert({
		title:'Disabled User?',
		text: "User "+name+" will not be able to request to withdraw! This cannot be undone once proceed.",
		type:'warning',
		showCancelButton: true,
		confirmButtonColor: '#3699ff',
		cancelButtonColor: '#98a6ad',
		confirmButtonText: 'Yes, proceed!'
	},function(isConfirm){
		('ok');
	});
	$('.swal2-confirm').click(function(){
		$("#loader").removeAttr('hidden','hidden');
		$.ajax({
			url: base_url+'api/v1/user/_disable_user',
			type: 'POST',
			dataType: 'JSON',
			data: {user_code:user_code, name:name}
		})
		.done(function(res) {
			if (res.data.status == 'success') {
				$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
				showMemberList(1)
			}
			else if (res.data.status == 'failed') {
				$.NotificationApp.send("Error!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
				showMemberList(1)
			}
			else{
				$.NotificationApp.send("Oh, Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
			}
			$("#loader").attr('hidden','hidden');
		})
		$("#loader").attr('hidden','hidden');
	});
}
function enableUser(user_code, name){
	sweetAlert({
		title:'Activate User?',
		text: "User "+name+" will now be able to request to withdraw! This cannot be undone once proceed.",
		type:'warning',
		showCancelButton: true,
		confirmButtonColor: '#3699ff',
		cancelButtonColor: '#98a6ad',
		confirmButtonText: 'Yes, proceed!'
	},function(isConfirm){
		('ok');
	});
	$('.swal2-confirm').click(function(){
		$("#loader").removeAttr('hidden','hidden');
		$.ajax({
			url: base_url+'api/v1/user/_enable_user',
			type: 'POST',
			dataType: 'JSON',
			data: {user_code:user_code, name:name}
		})
		.done(function(res) {
			if (res.data.status == 'success') {
				$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
				showMemberList(1)
			}
			else if (res.data.status == 'failed') {
				$.NotificationApp.send("Error!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
				showMemberList(1)
			}
			else{
				$.NotificationApp.send("Oh, Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
			}
			$("#loader").attr('hidden','hidden');
		})
		$("#loader").attr('hidden','hidden');
	});
}
function resetPassword(user_code, name){
	sweetAlert({
		title:'Reset Password?',
		text: "User "+name+"'s password will be reset to '123456'! This cannot be undone once proceed.",
		type:'warning',
		showCancelButton: true,
		confirmButtonColor: '#3699ff',
		cancelButtonColor: '#98a6ad',
		confirmButtonText: 'Yes, proceed!'
	},function(isConfirm){
		('ok');
	});
	$('.swal2-confirm').click(function(){
		$("#loader").removeAttr('hidden','hidden');
		$.ajax({
			url: base_url+'api/v1/user/_reset_password',
			type: 'POST',
			dataType: 'JSON',
			data: {user_code:user_code, name:name}
		})
		.done(function(res) {
			if (res.data.status == 'success') {
				$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
				showMemberList(1)
			}
			else{
				$.NotificationApp.send("Oh, Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
			}
			$("#loader").attr('hidden','hidden');
		})
		$("#loader").attr('hidden','hidden');

	});
}
function viewInfo(user_id) {
	$("#loader").removeAttr('hidden','hidden');
	$.ajax({
		url: base_url+'api/v1/user/_get_user_data',
		type: 'GET',
		dataType: 'JSON',
		data: {user_code:user_id}
	})
	.done(function(res) {
		package_wrapper = '';
		status_wrapper = '';
		referrer_wrapper = '';
		package = res.data.package;
		chosen = '';

		if (package == 'a') {
			chosen +='<ul>'
	                +'<li>2 Spirulina Food Supplement</li>'
	                +'<li>1 Purple Corn Juice</li>'
	            +'</ul>'
	        $("#_package_details").removeAttr('hidden', 'hidden');
		}
		else if (package == 'b') {
			chosen +='<ul>'
	                +'<li>2 Spirulina Food Supplement</li>'
	                +'<li>1 Buah Merah Juice</li>'
	            +'</ul>'
	        $("#_package_details").removeAttr('hidden', 'hidden');
		}
		else if (package == 'c') {
			chosen +='<ul>'
	                +'<li>2 Spirulina Food Supplement</li>'
	                +'<li>1 Herbal House Coffee</li>'
	            +'</ul>'
	        $("#_package_details").removeAttr('hidden', 'hidden');
		}

		else if (package == 'd') {
			chosen +='<ul>'
	                +'<li>1 Spirulina Food Supplement</li>'
	                +'<li>1 Mangosteen Dietary Supplement</li>'
	                +'<li>1 Purple Corn Juice</li>'
	            +'</ul>'
	        $("#_package_details").removeAttr('hidden', 'hidden');
		}

		else if (package == 'e') {
			chosen +='<ul>'
	                +'<li>1 Spirulina Food Supplement</li>'
	                +'<li>1 Serpentina Food Supplement</li>'
	                +'<li>1 Buah Merah Juice</li>'
	            +'</ul>'
	        $("#_package_details").removeAttr('hidden', 'hidden');
		}

		else if (package == 'f') {
			chosen +='<ul>'
	                +'<li>1 Serpentina Food Supplement</li>'
	                +'<li>1 Mangosteen Dietary Supplement</li>'
	                +'<li>1 Herbal House Coffee</li>'
	            +'</ul>'
	        $("#_package_details").removeAttr('hidden', 'hidden');
		}


		if (res.data.invite_status == 'inactive') {
			getPackageList();
			status_wrapper +='<label class="font-18">Update User Status</label>'
                	+'<input type="hidden" name="user_code" value="'+res.data.user_code+'">'
                	+'<input type="hidden" name="user_id" value="'+res.data.user_id+'">'
                	+'<input type="hidden" name="sponsor_id" value="'+res.data.sponsor_id+'">'
                	+'<div class="text-sm-start mt-2 mb-3 form-floating">'
	                    +'<select class="form-select mt-1" name="status" id="_user_payment_status" required aria-label="">'
	                        +'<option disabled="" selected="" value="">Select Status</option>'
	                        +'<option value="paid">Paid</option>'
	                    +'</select>'
	                   +'<label for="_rw_status" class="fw-400 mb-2">Update the Users Status after Payment.</label>'
                	+'</div>'

                	+'<div class="text-sm-start mt-2 form-floating">'
	                    +'<select class="form-select mt-1" name="package" id="_user_select_package" required aria-label="">'
	                    +'</select>'
	                   +'<label for="_rw_status" class="fw-400 mb-2">Select Package.</label>'
                	+'</div>'

                	+'<button class="btn btn-success rounded mt-2">Update Status</button>'
                +'<hr class="mb-3">'
            $("#_status_wrapper").html(status_wrapper)


            package_wrapper +='<label class="font-18 mt-1">Package <span class="text-uppercase">'+res.data.package+'</span></label>'
                +'<div class="text-sm-start mb-3">'
                   +'<div><h5>Package Details</h5></div>'
                   +chosen
                +'</div>'
                +'<hr class="mb-3">'
            $("#_package_wrapper").html(package_wrapper)


            referrer_wrapper +='<hr><div class="mt-3">'
                        +'<label class="font-18">Referrer Information</label><br>'
                        +'<small>*Referrer who invites using their <span class="badge bg-success">Affiliate Link</span></small>'
                    +'</div>' 
            		+'<div class="mt-2">'

                    +'User ID: <br><span id="_ref_user_id" class="font-23 fw-600"><a target="_blank" rel="noopener" href="'+base_url+'user/overview/'+res.data.sponsor_id+'">'+res.data.sponsor_id+'</a></span>'
               	 +'</div>'

                +'<div class="mt-2">'
                    +'Full Name: <br><span id="_ref_full_name" class="font-23 fw-600">'+res.data.sponsor+' </span>'
                +'</div>'
            $("#_referrer_wrapper").html(referrer_wrapper)
		}

		else if (res.data.registration_type == 'website_invites') {

            package_wrapper +='<label class="font-18 mt-1">Package <span class="text-uppercase">'+res.data.package+'</span></label>'
                +'<div class="text-sm-start mb-3">'
                   +'<div><h5>Package Details</h5></div>'
                   +chosen
                +'</div>'
                +'<hr class="mb-3">'
            $("#_package_wrapper").html(package_wrapper)


            referrer_wrapper +='<hr><div class="mt-3">'
                        +'<label class="font-18">Referrer Information</label><br>'
                        +'<small>*Referrer who invites using their <span class="badge bg-success">Affiliate Link</span></small>'
                    +'</div>' 
            		+'<div class="mt-2">'

                    +'User ID: <br><span id="_ref_user_id" class="font-23 fw-600"><a target="_blank" rel="noopener" href="'+base_url+'user/overview/'+res.data.sponsor_id+'">'+res.data.sponsor_id+'</a></span>'
               	 +'</div>'

                +'<div class="mt-2">'
                    +'Full Name: <br><span id="_ref_full_name" class="font-23 fw-600">'+res.data.sponsor+' </span>'
                +'</div>'
            $("#_referrer_wrapper").html(referrer_wrapper)
            $("#_status_wrapper").html('')
		}


		else{
			$("#_status_wrapper").html('')
			$("#_package_wrapper").html('')
            $("#_referrer_wrapper").html('')
		}
		$("#_modal_title").text(res.data.name+' Information')
		$("#_input_fname").val(res.data.fname)
		$("#_input_lname").val(res.data.lname)
		$("#_full_name").text(res.data.name)
		$("#_user_id").text(res.data.user_code)
		$("#_mobile_number").text(res.data.mobile_number)
		$("#_email_address").text(res.data.email_address)
		$("#_address").text(res.data.address)
		$("#_input_user_code").val(res.data.user_code)

		$("#user_info_modal").modal('show');
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {

	})
}
$("#_edit_full_name").on('click', function() {
	$("#_name_btns_div button").removeAttr('hidden', 'hidden')
	$("#_input_fname").attr('type','text')
	$("#_input_lname").attr('type','text')
});
$("#_close_name_btn").on('click', function() {
	$("#_name_btns_div button").attr('hidden', 'hidden')
	$("#_input_fname").attr('type','hidden')
	$("#_input_lname").attr('type','hidden')
})
$("#_edit_full_name_form").on('submit', function(e) {
	e.preventDefault();
	$("#_save_name_btn").attr('disabled','disabled').text('Saving...');
	_fname = $("#_input_fname").val();
	_lname = $("#_input_lname").val();
	_user_code = $("#_input_user_code").val();

	if (!_fname || _fname == '') {
		$.NotificationApp.send("Oh Snap!","First Name is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}
	if (!_lname || _lname == '') {
		$.NotificationApp.send("Oh Snap!","Last Name is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	$.ajax({
		url: base_url+'api/v1/user/_update_user_full_name',
		type: 'GET',
		dataType: 'JSON',
		data: {fname:_fname, lname:_lname, user_code:_user_code}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			$("#_name_btns_div button").attr('hidden', 'hidden');
			$("#_input_fname").attr('type','hidden');
			$("#_input_lname").attr('type','hidden');
			$("#_full_name").text(_fname+' '+_lname)

		}
		else{
			$.NotificationApp.send("Error!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		$("#loader").attr('hidden','hidden');
		newCsrfData();
		$("#_save_name_btn").removeAttr('disabled','disabled').text('Save');
	})
	.fail(function(){
	})
})
$("#_user_payment_status_form").on('submit', function(e) {
	status = $('#_user_payment_status').val();

	if (status == '' || !status || status !== 'paid') {
		$.NotificationApp.send("Error!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		return false;
	}
	e.preventDefault();
	$("#loader").removeAttr('hidden','hidden');
	$.ajax({
		url: base_url+'api/v1/user/_update_user_invite_status',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize()
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("Succes!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			$("#user_info_modal").modal('hide');
			showMemberList(1);
		}
		else{
			$.NotificationApp.send("Error!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		$("#loader").attr('hidden','hidden');
		newCsrfData();
	})
	.fail(function(){
	})
})
function getPackageList() {
	$.ajax({
		url: base_url+'api/v1/package/_get_package_list_opt',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		string = '<option disabled="" selected="">Select Package</option>';
		if (res.data.length > 0) {
			for(var i in res.data) {
				string += '<option value="'+res.data[i].p_id+'">'+res.data[i].name+'</option>'
			}
			$("#_user_select_package").html(string)
		}
		else{
			$.NotificationApp.send("Oh, Snap!","Kindly add Package first","top-right","rgba(0,0,0,0.2)","error");
		}
	})
	.fail(function() {
		console.log("error");
	})
}
function makeStockist(user_code, name){
	sweetAlert({
		title:'New Stockist?',
		text: "This make "+name+" as a Stockist and will be able to access special features of a stockist! ",
		type:'warning',
		showCancelButton: true,
		confirmButtonColor: '#3699ff',
		cancelButtonColor: '#98a6ad',
		confirmButtonText: 'Yes, proceed!'
	},function(isConfirm){
		('ok');
	});
	$('.swal2-confirm').click(function(){
		$("#loader").removeAttr('hidden','hidden');
		$.ajax({
			url: base_url+'api/v1/user/_new_stockist',
			type: 'POST',
			dataType: 'JSON',
			data: {user_code:user_code, name:name}
		})
		.done(function(res) {
			if (res.data.status == 'success') {
				$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
				showMemberList(1)
			}
			else if (res.data.status == 'failed') {
				$.NotificationApp.send("Error!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
				showMemberList(1)
			}
			
			$("#loader").attr('hidden','hidden');
		})
		$("#loader").attr('hidden','hidden');

	});
}
function removeStockist(user_code, name){
	sweetAlert({
		title:'Remove Stockist?',
		text: "This will remove "+name+" as a Stockist. ",
		type:'warning',
		showCancelButton: true,
		confirmButtonColor: '#3699ff',
		cancelButtonColor: '#98a6ad',
		confirmButtonText: 'Yes, proceed!'
	},function(isConfirm){
		('ok');
	});
	$('.swal2-confirm').click(function(){
		$("#loader").removeAttr('hidden','hidden');
		$.ajax({
			url: base_url+'api/v1/user/_remove_stockist',
			type: 'POST',
			dataType: 'JSON',
			data: {user_code:user_code, name:name}
		})
		.done(function(res) {
			if (res.data.status == 'success') {
				$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
				showMemberList(1)
			}
			else if (res.data.status == 'failed') {
				$.NotificationApp.send("Error!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
				showMemberList(1)
			}
			
			$("#loader").attr('hidden','hidden');
		})
		$("#loader").attr('hidden','hidden');

	});
}