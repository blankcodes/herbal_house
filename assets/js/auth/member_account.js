if (page == 'member_code_list') {
	showMemberCodes(1, user_code)
	showAvailCodeCredit();
	showCodeHistory(1)

}
else if (page == 'direct_invites') {
	showDirectList(user_code, 1)
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
                        +'<td>'+res.result[i].code+'</td>'
                        +'<td>'+res.result[i].package_name+'</td>'
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
		data: {user_code:user_code},
	})
	.done(function(res) {
		string = '';
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
	                       	+'<a target="_blank" href="'+base_url+'direct/binary/'+res.result[i].user_code+'" rel="noopener" class="font-12 text-left btn btn-primary btn-sm mt-1"><i class="uil-eye"></i> View Downline</a>&nbsp;'
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
                        +'<td>'+res.result[i].code+'</td>'
                        +'<td>'+res.result[i].package_name+'</td>'
                        +'<td>'+res.result[i].date_purchased+'</td>'
                        +'<td>'+res.result[i].date_used+'</td>'
                        +'<td>'+res.result[i].used_by+'</td>'
					+'</tr>'
			}
		}
		else{
			string = '<tr class="text-center"><td colspan="6">No Records Found...</td></tr>';
		}
		$("#_code_history_tbl").html(string);
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
		$.NotificationApp.send("Oh, snap!","User Code is required!","top-right","rgba(0,0,0,0.2)","error");
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
