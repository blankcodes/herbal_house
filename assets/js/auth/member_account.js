if (page == 'member_code_list') {
	showMemberCodes(1, user_code)
	showAvailCodeCredit();
	showCodeHistory(1)

}
else if (page == 'direct_invites') {
	showDirectList(user_code, 1)
	showInDirectList(2, user_code, 1)
}
else if (page == 'member_products') {
	showProductData(1, nonce)
}
else if (page == 'my_orders') {
	showMyOrders(1)
}
else if (page == 'customer_orders') {
	showAllOrders(1)
}
$("#show_password").on('click', function() {
	$("#_account_password_form input[type=password]").attr('type','text');
	$(this).attr('hidden','hidden');
	$("#hide_password").removeAttr('hidden');
})
$("#hide_password").on('click', function() {
	$("#_account_password_form input[type=text]").attr('type','password');
	$(this).attr('hidden','hidden');
	$("#show_password").removeAttr('hidden');
})

$('#_avail_code_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showMemberCodes(page_no, user_code);
});
$('#my_order_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showMyOrders(page_no);
});
$('#_indirect_invites_pagination').on('click','a',function(e){
    e.preventDefault(); 
    lvl_val  = $("#_select_level").val();
    var page_no = $(this).attr('data-ci-pagination-page');
    showInDirectList(lvl_val, user_code, page_no);
});
$('#_direct_invites_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showDirectList(user_code, page_no);
});
function showAvailCodeCredit(){
	$("#_code_credits").text('0')
	$.ajax({
		url: base_url+'api/v1/member/_get_code_count',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		$("#_code_credits").text(res.data.count)
	})
}
function showMemberCodes(page_no, user_code){
	$("#_avail_code_tbl").html('<tr class="text-center"><td colspan="5">Getting Activation Codes...</td></tr>');

	$.ajax({
		url: base_url+'api/v1/member/_get_codes',
		type: 'GET',
		dataType: 'JSON',
		data: {page_no:page_no}
	})
	.done(function(res) {
		string ='';
		stat_label = '';
		btn_disabled = '';
		$('#_avail_code_pagination').html(res.pagination);
		if (parseInt(res.count) > 0) {
			for(var i in res.result) {
				status = res.result[i].status;
				if (status == 'new') {
					stat_label = 'success';
					btn_disabled = '';
				}
				else if (status == 'sent') {
					stat_label = 'warning'
					btn_disabled = 'disabled="disabled"';
				}
				else{
					stat_label = 'danger';
					btn_disabled = '';
				}

				string +='<tr>'
                        +'<td>'
                            +'<div class="form-check">'
                                +'<input type="checkbox" class="form-check-input" id="customCheck2">'
                                +'<label class="form-check-label" for="customCheck2">&nbsp;</label>'
                            +'</div>'
                        +'</td>'
                        +'<td>'+res.result[i].package_name+'</td>'
                        +'<td>'+res.result[i].code+'</td>'
                        +'<td>'+res.result[i].date_purchased+'</td>'
                        +'<td width="150">'
                            +'<button id="code_'+res.result[i].uc_id+'_btn" onclick="copyCode(\''+res.result[i].uc_id+'\',\''+res.result[i].code+'\')" class="font-12 text-left btn btn-light btn-sm mt-1"><i class="dripicons-copy"></i> </button>&nbsp;'
                            +'<a onclick="transferActCode(\''+res.result[i].ac_id+'\',\''+res.result[i].code+'\',\''+res.result[i].cost+'\')" target="_blank" rel="noopener" class="font-12 text-left btn btn-light btn-sm mt-1"><i class="uil-message"></i> </a>&nbsp;'
                        +'</td>'
				+'</tr>'
			}
		}
		else{
			string = '<tr class="text-center"><td colspan="5">No Records Found!</td></tr>';
		}
		showAvailCodeCredit();
		$("#_avail_code_tbl").html(string);
	})
	.fail(function() {
		$("#_avail_code_tbl").html('<tr class="text-center"><td colspan="5">No records found!</td></tr>');
	})
}
function copyCode(uc_id, code) {
    new ClipboardJS('#code_'+uc_id+'_btn', {
        text: function(trigger) {
            return code;
       }
   	}); 
   	$.NotificationApp.send("Success!","Copied "+code+"! ","top-right","rgba(0,0,0,0.2)","success")
}

function showDirectList(user_code, page_no){
	$("#_direct_invites_tbl").html('<tr class="text-center"><td colspan="7">Getting your list...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/member/_get_direct_list',
		type: 'GET',
		dataType: 'JSON',
		data: {user_code:user_code, page_no:page_no},
	})
	.done(function(res) {
		string = '';
		$('#_direct_invites_pagination').html(res.pagination);
		if (res.result.length > 0) {
			for(var i in res.result) {
				string +='<tr>'
	                    +'<td>'
	                    +'<div class="form-check">'
	                        +'<input type="checkbox" class="form-check-input" id="customCheck2">'
	                        +'<label class="form-check-label" for="customCheck2">&nbsp;</label>'
	                    +'</div>'
	                    +'</td>'
	                    +'<td>'+res.result[i].user_code+'</td>'
	                    +'<td>'+res.result[i].name+'</td>'
	                    +'<td>'+res.result[i].mobile_number+'</td>'
	                    +'<td>'+res.result[i].package_name+'</td>'
	                    +'<td>'+res.result[i].created_at+'</td>'
	                    +'<td>'
	                       	// +'<a target="_blank" href="'+base_url+'direct/binary/'+res.result[i].user_code+'" rel="noopener" class="font-12 text-left btn btn-primary btn-sm mt-1"><i class="uil-eye"></i> View Downline</a>&nbsp;'
	                   	+'</td>'
				+'</tr>'
			}
		}
		else{
			string = '<tr class="text-center"><td colspan="7">No record found. Try to invite first.</td></tr>';
		}
		$("#_direct_invites_tbl").html(string);
	})
	.fail(function() {
		$("#_direct_invites_tbl").html('<tr class="text-center"><td colspan="7">No record found. Try to invite first.</td></tr>');
	})
}
$("#_select_level").on('change', function() {
	lvl_val = $(this).val();
	showInDirectList(lvl_val, user_code, 1)
})
function showInDirectList(level, user_code, page_no){
	$("#_indirect_invites_tbl").html('<tr class="text-center"><td colspan="4">Getting your list...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/member/_get_indirect_list',
		type: 'GET',
		dataType: 'JSON',
		data: {user_code:user_code, level:level, page_no:page_no},
	})
	.done(function(res) {
		string = '';
		$('#_indirect_invites_pagination').html(res.pagination);
		if (res.result.length > 0) {
			for(var i in res.result) {

				string +='<tr>'
	                    +'<td>'
	                    +'<div class="form-check">'
	                        +'<input type="checkbox" class="form-check-input" id="customCheck2">'
	                        +'<label class="form-check-label" for="customCheck2">&nbsp;</label>'
	                    +'</div>'
	                    +'</td>'
	                    +'<td>'+res.result[i].user_code+'</td>'
	                    +'<td>'+res.result[i].name+'</td>'
	                    +'<td>'+res.result[i].created_at+'</td>'
				+'</tr>'
			}
		}
		else{
			string = '<tr class="text-center"><td colspan="4">No record found. Try to invite first.</td></tr>';
		}
		$("#_indirect_invites_tbl").html(string);
	})
	.fail(function() {
		$("#_indirect_invites_tbl").html('<tr class="text-center"><td colspan="7">No record found. Try to invite first.</td></tr>');
	})
}

function showCodeHistory(page_no) {
	$("#_code_history_tbl").html('<tr class="text-center"><td colspan="6">Getting code history...</td></tr>');

	$.ajax({
		url: base_url+'api/v1/member/_get_code_history',
		type: 'GET',
		dataType: 'JSON',
		data: {page_no:page_no}
	})
	.done(function(res) {
		string ='';
		stat_label = '';
		btn_disabled = '';
		$('#_code_pagination').html(res.pagination);
		if (parseInt(res.count) > 0) {
			for(var i in res.result) {
				string +='<tr>'
                        +'<td>'
                            +'<div class="form-check">'
                                +'<input type="checkbox" class="form-check-input" id="customCheck2">'
                                +'<label class="form-check-label" for="customCheck2">&nbsp;</label>'
                            +'</div>'
                        +'</td>'
                        +'<td>'+res.result[i].package_name+'</td>'
                        +'<td>'+res.result[i].code+'</td>'
                        +'<td>'+res.result[i].date_purchased+'</td>'
                        +'<td>'+res.result[i].date_used+'</td>'
                        +'<td>'+res.result[i].used_by+'</td>'
					+'</tr>'
			}
		}
		else{
			string = '<tr class="text-center"><td colspan="6">No Records Found!</td></tr>';
		}
		$("#_code_history_tbl").html(string);
	})
	.fail(function() {
		$("#_code_history_tbl").html('<tr class="text-center"><td colspan="6">No Records Found!</td></tr>');
	})
}
$("#_account_password_form").on('submit', function(e){
	$("#_change_pass_btn").attr('disabled','disabled').text('Changing Password...');
	e.preventDefault();

	$.ajax({
		url: base_url+'api/v1/member/_change_password',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
	})
	.done(function(res) {
		if (res.data.status == 'success') {
   			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
   			$("#_account_password_form input").val('');
		}
		else {
   			$.NotificationApp.send("Oh, snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		$("#_change_pass_btn").removeAttr('disabled').text('Change Password');
   		newCsrfData();
	})
	.fail(function() {
		console.log("error");
	})
})
$("#_account_settings_form").on('submit', function(e){
	$("#_update_acct_btn").attr('disabled','disabled').text('Updating...');
	e.preventDefault();

	$.ajax({
		url: base_url+'api/v1/member/_update_info',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
	})
	.done(function(res) {
		if (res.data.status == 'success') {
   			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
   			$("#_account_password_form input").val('');
		}
		else {
   			$.NotificationApp.send("Oh, snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		
		$("#_update_acct_btn").removeAttr('disabled').text('Update');
   		newCsrfData();
	})
	.fail(function() {
		console.log("error");
	})
})
$("#_account_username_form").on('submit', function(e){
	$("#_update_username_btn").attr('disabled','disabled').text('Updating...');
	e.preventDefault();

	$.ajax({
		url: base_url+'api/v1/member/_update_username',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
	})
	.done(function(res) {
		if (res.data.status == 'success') {
   			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
   			$("#_account_password_form input").val('');
		}
		else {
   			$.NotificationApp.send("Oh, snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		
		$("#_update_username_btn").removeAttr('disabled').text('Update');
   		newCsrfData();
	})
	.fail(function() {
		console.log("error");
	})
})
function transferActCode(ac_id, code, cost, user_code){
	$("#_user_code").val(''); /* user code, the receiver*/
	$("#_activation_code").val(code);
	$("#send_to_modal").modal('show')
}
if ($("#search_code_name_form").val() == '') {
	$("#search_user_dropdown").hide()
}
if (page == 'member_code_list') {
	$("#search_code_name_form").on('submit', function(e) {
		e.preventDefault();
		keyword = $("#search_code_name").val();

		if (!keyword || keyword == '' || keyword == ' ') {
			return false;
		}
		$.ajax({
			url: base_url+'api/v1/users/_get',
			type: 'GET',
			dataType: 'JSON',
			data: {keyword:keyword}
		})
		.done(function(res) {
			string = '';
			if (res.data.status == 'success') {
				for(var i in res.data.search){
					string+='<a href="#" onclick="searchUserCode(\''+user_code+'\',\''+res.data.search[i].user_code+'\',\''+res.data.search[i].name+'\')" class="dropdown-item notify-item"><span id="user_name"> '+res.data.search[i].name+'</span> <span>(#'+res.data.search[i].user_code+')</span></a>'
				}
			}
			else if(res.data.status == 'no_record'){
				string = '<span class="margin-left-10">'+res.data.message+'</span>'
			}
			$("#search_user_dropdown").show()
			$("#_member_search").html(string);
		})
		.fail(function() {
			string = '<span class="margin-left-10">No records found!</span>'
			$("#_member_search").html(string);

		})
	});
}
function searchUserCode(user_code, search_user_code, name){
	if (search_user_code == user_code) {
   		$.NotificationApp.send("Oh, snap!","You can't transfer this code to yourself!","top-right","rgba(0,0,0,0.2)","error")
	}
	else{
		$("#search_code_name").val('');
		$("#_user_name").val(name);
		$("#_user_code").val(search_user_code)
		$("#search_user_dropdown").hide()
	}
}
$("#_send_member_code_btn").on('click', function(){
	code = $("#_activation_code").val(); /* code to be sent */
	user_code = $("#_user_code").val(); /* user code, the receiver*/

	if (!code || code == '') {
		$.NotificationApp.send("Oh, snap!","Activation Code is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}
	if (!user_code || user_code == '') {
		$.NotificationApp.send("Oh, snap!","User ID is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	$.ajax({
		url: base_url+'api/v1/code/_transfer',
		type: 'GET',
		dataType: 'JSON',
		data: {code:code, user_code:user_code},
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			$("#search_code_name_form input").val('');
			$("#send_to_modal").modal('hide');
			showMemberCodes(1)
			showAvailCodeCredit();
		}
		else{
			$.NotificationApp.send("Oh, snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
	})
	.fail(function() {
		console.log("error");
	})
})
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#profile_image_thumbnail')
                .attr('src', e.target.result)
                .width(150)
        };
        reader.readAsDataURL(input.files[0]);
    }
}
$("#_account_profile_form").on('submit', function(e) {
	e.preventDefault();
	var formData = new FormData(this);
	var prof_img = $("#profile_image").val();
	if (!prof_img) {
		$.NotificationApp.send("Oh Snap!","Image is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/user/_update_profile_img',
		type: 'POST',
		dataType: 'JSON',
		data: formData,
		cache       : false,
	    contentType : false,
	    processData : false,
	    statusCode: {
			403: function() {
				$.NotificationApp.send("Oh Snap!","Something went wrong! Refresh this page and try again!","top-right","rgba(0,0,0,0.2)","error");
			}
		}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$(".account-user-avatar img").attr('src',res.data.full_path)
			console.log(res.data.full_path)
			$.NotificationApp.send("Success!",res.data.success,"top-right","rgba(0,0,0,0.2)","success");
		}
		else if (res.data.status == 'error') {
			$.NotificationApp.send("Oh Snap!",res.data.message.error,"top-right","rgba(0,0,0,0.2)","warning");
		}
		else{
			$.NotificationApp.send("Oh Snap!!",res.data.message,"top-right","rgba(0,0,0,0.2)","warning");
		}
		newCsrfData();
		$("#loader").attr('hidden','hidden');

	})
	.fail(function() {
		$("#loader").attr('hidden','hidden');

	});
});

function showProductData(page_no, nonce) {
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/product/_get_user_products',
		type: 'GET',
		dataType: 'JSON',
        data: {page_no:page_no,nonce:nonce}
	})
	.done(function(res) {
		$('#products_pagination').html(res.pagination);
		mob_string = '';
		string = '';
		if (parseInt(res.count) > 0) {
			for(var i in res.result) {
				string += '<div class="col-md-4 col-lg-3 col-6">'
                       +'<div class="card">'
                           	+'<a href="'+res.result[i].url+'"><img src="'+res.result[i].product_image+'" class="card-img-top" alt="'+res.result[i].product_name+'"></a>'
                           	+'<div class="card-body card-title-div">'
                                +'<a href="'+res.result[i].url+'" width="120"><h2 class="card-title text-secondary product-name">'+res.result[i].product_name+'<br>'
                                	+'<small class="product-category">'+res.result[i].category+'</small></h2>'
                                +'</a>'
                                +'<h3 class="card-title text-success mt-1">₱ '+res.result[i].price+'</h3>'
                               	+'<div class="inline-block">'
                                +'<button href="#add_to_cart" class="btn btn-success rounded btn-sm mt-2 col-lg-12 prod_buy_btn" onclick="addToCart(\''+res.result[i].p_pub_id+'\')"><i class="uil-shopping-cart-alt"></i> Add to cart</button>'
                                +'<button href="#add_to_cart" id="code_'+res.result[i].p_pub_id+'_btn"  class="btn btn-light rounded btn-sm margin-top-10 col-lg-12 prod_buy_btn" onclick="copyUrl(\''+res.result[i].url+'\', \''+res.result[i].p_pub_id+'\')"><i class="uil-copy"></i> Copy URL</button>'
                               	+'</div>'
                            +'</div> '
                        +'</div> '
                +'</div> '
			}
		}
        else{
            $('#err_title').text('Error Getting Products!')
            $('#err_message').html("There's an error getting Products! Please refresh the page or click the <b>Refresh</b> button below.")
            $("#_product_warning_modal").modal('show');
            string = "<div class='text-center text-secondary'>Seems there's an error. Please try again!</div>"
            mob_string = "<div class='text-center text-secondary'>Seems there's an error. Please try again!</div>"
        }
        $("#products_wrapper").html(string);
	})
	.fail(function() {
		
	})
	.always(function() {
		$("#loader").attr('hidden','hidden');
	});
	
}
function showMyOrders(page_no){
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/order/_get_my_orders',
		type: 'GET',
		dataType: 'JSON',
        data: {page_no:page_no}
	})
	.done(function(res) {
		$('#my_order_pagination').html(res.pagination);
		if (parseInt(res.count) > 0) {
			string = '';
			payment_status_label = '';
			order_status_label = '';
			for(var i in res.result) {
				status = res.result[i].status;
				payment_status = res.result[i].payment_status;

				if (status == 'created') {
					order_status_label = 'info';
				}
				else if (status == 'delivered') {
					order_status_label = 'success';
				}
				else if (status == 'cancelled') {
					order_status_label = 'danger';
				}
				else if (status == 'packed') {
					order_status_label = 'info';
				}
				else if (status == 'shipped') {
					order_status_label = 'warning';
				}

				if (payment_status == 'unpaid') {
					payment_status_label = 'badge-info-lighten';
				}
				else if (payment_status == 'paid') {
					payment_status_label = 'badge-success-lighten';
				}
				else if (payment_status == 'payment failed') {
					payment_status_label = 'badge-danger-lighten';
				}

				string +='<tr>'
                        +'<td><a target="_blank" href="'+base_url+'order/'+res.result[i].reference_no+'" class="text-body fw-bold cursor-pointer">#'+res.result[i].reference_no+'</a> </td>'
                        +'<td>'
                        	+'<h5 class="dropdown">'
                                 +'<span class="badge badge-'+order_status_label+'-lighten font-12 text-capitalize pointer-cursor" >'+res.result[i].status+' </span>'
                        	+'</h5>'

                        +'</td>'
                        +'<td class="text-capitalize fw-600">₱ '+res.result[i].total_revenue+'</td>'
                        +'<td>'+res.result[i].payment_method+'</td>'
                        +'<td><h5><span class="badge '+payment_status_label+' text-capitalize font-12"><i class="mdi mdi-coin"></i> '+res.result[i].payment_status+'</span></h5></td>'
                        +'<td>'+res.result[i].created_at+'</small></td>'
                    +'</tr>'
			}
		}
		else{
			string = '<tr class="text-center"><td colspan="7">No Orders Found!</td></tr>'
		}
        $("#my_orders_tbl").html(string);
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		$("#loader").attr('hidden','hidden');
	});
}

$("#_select_package").on('change', function() {
    code = $(this).val();
    getPackageData(code)
})
function getPackageData(code) {
    $("#loader").removeAttr('hidden');
    $.ajax({
        url: base_url+'api/v1/package/_package_by_code',
        type: 'GET',
        dataType: 'JSON',
        data: {code:code},
    })
    .done(function(res) {
        if (res.data) {
            $("#_package_details").removeAttr('hidden');
            $("#_package_name_details").text(res.data.package_name)
            $("#_package_code_details").text(res.data.code)
            $("#_package_code").val(res.data.code)
        }
        $("#loader").attr('hidden','hidden');
    })
    .fail(function() {
        $("#loader").attr('hidden','hidden');
        console.log("error");
    })
}
$('#register_invite_form').on('submit', function(e) {
	e.preventDefault();
    package_code = $('#_package_code').val();

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
		url: base_url+'api/v1/register/_register_invite',
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
               window.location.href=base_url+"member/invites-list";
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
function copyUrl(url, p_pub_id){
    new ClipboardJS('#code_'+p_pub_id+'_btn', {
        text: function(trigger) {
            return url;
       }
   	}); 
   	$.NotificationApp.send("Success!","Copied! ","top-right","rgba(0,0,0,0.2)","success")
}

function showAllOrders(page_no){
	$("#orders_tbl").html('<tr class="text-center"><td colspan="7">Getting Orders...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/order/_get_user_orders',
		type: 'GET',
		dataType: 'JSON',
		data: {page_no:page_no}
	})
	.done(function(res) {
		if (parseInt(res.count) > 0) {
			string = '';
			payment_status_label = '';
			order_status_label = '';
			for(var i in res.result) {
				status = res.result[i].status;
				payment_status = res.result[i].payment_status;

				if (status == 'created') {
					order_status_label = 'info';
				}
				else if (status == 'delivered') {
					order_status_label = 'success';
				}
				else if (status == 'cancelled') {
					order_status_label = 'danger';
				}
				else if (status == 'packed') {
					order_status_label = 'primary';
				}
				else if (status == 'shipped') {
					order_status_label = 'warning';
				}

				if (payment_status == 'unpaid') {
					payment_status_label = 'badge-info-lighten';
				}
				else if (payment_status == 'paid') {
					payment_status_label = 'badge-success-lighten';
				}
				else if (payment_status == 'payment failed') {
					payment_status_label = 'badge-danger-lighten';
				}

				string +='<tr>'
                        +'<td><a target="_blank" href="'+base_url+'order/'+res.result[i].reference_no+'" class="text-body fw-bold cursor-pointer">#'+res.result[i].reference_no+'</a> </td>'
                        +'<td>'
                        	+'<h5 class="dropdown">'
                        	// +'<span class="badge badge'+order_status_label+'-lighten text-capitalize" >'+res.result[i].status+' </span>'
                        		// +'<button class="btn btn-'+order_status_label+' dropdown-toggle text-capitalized btn-s" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                          //           +res.result[i].status+''
                          //       +'</button>'
                                 +'<span onclick="updateOrderStatusModal(\''+res.result[i].reference_no+'\', \''+res.result[i].order_id+'\')"class="badge badge-'+order_status_label+'-lighten font-13 text-capitalize pointer-cursor" ><i class="uil-edit"></i> '+res.result[i].status+' </span>'
                                   
                        	+'</h5>'

                        +'</td>'
                        +'<td class="text-capitalize fw-600">₱ '+res.result[i].total_revenue+'</td>'
                        +'<td>'+res.result[i].payment_method+'</td>'
                        +'<td><h5><span class="badge '+payment_status_label+' text-capitalize font-13"><i class="mdi mdi-coin"></i> '+res.result[i].payment_status+'</span></h5></td>'
                        +'<td>'+res.result[i].created_at+'</small></td>'

                        +'<td width=150>'
                            +'<a target="_blank" rel="noopener" href="'+base_url+'member/order/details/'+res.result[i].reference_no+'" class="font-13 "> <i class="mdi mdi-clipboard-text-search-outline"></i> Check details  </a>'
                       +'</td>'
                    +'</tr>'
			}
		}
		else{
			string = '<tr class="text-center"><td colspan="7">No Orders Found!</td></tr>'
		}
		$('#orders_tbl').html(string)
	})
	.fail(function() {
		$("#orders_tbl").html('<tr class="text-center"><td colspan="7">No Orders Found!</td></tr>');
	})
	.always(function() {
		// $("#orders_tbl").html('<tr class="text-center"><td colspan="7">Loading Products...</td></tr>');
	});
}
$("#update_order_status_").on('click', function(){
	order_id = $("#order_id_status").val();
	status = $("#__order_status_select").val();

	if (status == '' || !status) {
		$.NotificationApp.send("Error!","Please select an Order Status!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	if (status == 'shipped') {
		courier = $("#_courier").val();
		tracking_number = $("#_tracking_number").val();

		if (!courier || courier == '') {
			$.NotificationApp.send("Error!","Please select a courier!","top-right","rgba(0,0,0,0.2)","error");
			return false;
		}
		else if (!tracking_number || tracking_number == '') {
			$.NotificationApp.send("Error!","Tracking number is required!","top-right","rgba(0,0,0,0.2)","error");
			return false;
		}
	}
	$("#loader").removeAttr('hidden','hidden');
	$.ajax({
	    url: base_url+'api/v1/order/_update_status',
	    type: 'POST',
	    dataType: 'JSON',
	    data: $("#_order_status_form").serialize(),
	})
	.done(function(res) {
	   	if (res.data.status == 'success') {
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			showAllOrders(1);
			$("#update_order_status_modal").modal('hide')
		}
		else if (res.data.status == 'failed') {
			$.NotificationApp.send("Oh! Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		$("#loader").attr('hidden','hidden');
 	})
	.fail(function() {
	    console.log("error");
	})
})
$("#__order_status_select").on('change', function(){
	status = $("#__order_status_select").val();
	if (status == 'shipped') {
		$("#ship_wrapper").removeAttr('hidden')
		$("#_courier").attr('required','required')
		$("#_tracking_number").attr('required','required')
	}
	else{
		$("#ship_wrapper").attr('hidden','hidden');
		$("#_courier").removeAttr('required')
		$("#_tracking_number").removeAttr('required')

	}
})

function updateOrderStatusModal(reference_no, order_id){
	$("#loader").removeAttr('hidden','hidden');
	$.ajax({
	    url: base_url+'api/v1/order/_get_order_details',
	    type: 'GET',
	    dataType: 'JSON',
	    data: {reference_no:reference_no},
	})
	.done(function(res) {
	   	string = '';
		if (res.data.status == 'created') {
			string +='<option selected disabled="">Choose Order Status</option>'
	            +'<option value="packed">Packed</option>'
	            +'<option value="cancelled">Cancel</option>'
		}
		else if(res.data.status == 'packed'){
			string +='<option selected disabled="">Choose Order Status</option>'
				+'<option value="shipped">Shipped</option>'
	            +'<option value="cancelled">Cancel</option>'
		}
		else if(res.data.status == 'shipped'){
			$("#ship_wrapper").hide();
			string += '<option selected disabled="">Choose Order Status</option>'
				+'<option value="delivered">Delivered</option>'
		}
		else if(res.data.status == 'delivered'){
			string += '<option selected disabled="">Choose Order Status</option>'
				+'<option disabled="">Dispute</option>'
		}
		else if(res.data.status == 'cancelled'){
			string += '<option selected disabled="">Choose Order Status</option>'
				+'<option disabled="">Dispute</option>'
		}
		$("#__order_status_select").html(string)
		$("#order_id_status").val(order_id);
		$("#update_order_status_modal").modal('show');
		$("#loader").attr('hidden','hidden');
 	})
	.fail(function() {
	    console.log("error");
	})
}
