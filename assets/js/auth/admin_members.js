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
function showMemberList (page_no) {
	$("#_member_list_tbl").html('<tr class="text-center"><td colspan="6">Getting member list...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/users/_get_member_list/'+page_no,
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		$('#member_list_pagination').html(res.pagination);
		string = '';
		user_type = ''
		for(var i in res.result) {
			if (res.result[i].user_type == 'admin') {
				user_type = 'success';
			}
			else{
				user_type = 'info';
			}
			string += '<tr>'
                    +'<td>'
                        +'<div class="form-check">'
                            +'<input type="checkbox" class="form-check-input" id="customCheck2">'
                            +'<label class="form-check-label" for="customCheck2">&nbsp;</label>'
                        +'</div>'
                    +'</td>'
                    +'<td class="table-user">'
                        +'<a href="javascript:void(0);" class="text-body"font-14">'+res.result[i].user_code+'</a>'
                    +'</td>'
                    +'<td>'
                        +'<span class="font-14">'+res.result[i].name+'</span>'
                    +'</td>'
                    +'<td>'
                        +'<span class="font-14">'+res.result[i].mobile_number+'</span>'
                    +'</td>'
                    +'<td>'
                        +'<span class="font-14"><span class="badge badge-'+user_type+'-lighten text-capitalize">'+res.result[i].user_type+'</span></span>'
                    +'</td>'
                    +'<td class=""><span class="font-14">'+res.result[i].created_at+'</td>'
                    
                    +'<td>'
                        +'<div class="dropdown">'
						    +'<button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
						        +'Action'
						    +'</button>'
						    +'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'
						        +'<a class="dropdown-item" target="_blank" href="'+base_url+'member/binary/'+res.result[i].user_code+'">View Downline</a>'
						        +'<a class="dropdown-item" href="#">Edit</a>'
						        +'<a class="dropdown-item" href="#">Deactivate</a>'
						    +'</div>'
						+'</div>'
                    +'</td>'
           	+'</tr>'
		}
		$("#_member_list_tbl").html(string);
	})
	.fail(function(){
		$("#_member_list_tbl").html('<tr class="text-center"><td colspan="6">No result found!</td></tr>');
	})
}
$("#_add_member").on('click', function() {
	$.ajax({
		url: base_url+'api/v1/package/_get_package_list',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		string = '<option disabled="" selected="">Select User Type</option>'
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