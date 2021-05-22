var base_url;
var page;

if (page == 'code_list') {
	showMemberCodes(1);
}
$("#_add_code_btn").on('click', function(){
	$.ajax({
		url: base_url+'api/v1/package/_get_package_list',
		type: 'GET',
		dataType: 'JSOn',
	})
	.done(function(res) {
		string = '<option disabled="" selected="">Select Package</option>';
		if (res.data.length > 0) {
			for(var i in res.data) {
				string += '<option value="'+res.data[i].p_id+'">'+res.data[i].name+'</option>'
			}
			$("#_select_package").html(string)
			$("#generate_code_modal").modal('show');
		}
		else{
			$.NotificationApp.send("Oh, Snap!","Kindly add Package first","top-right","rgba(0,0,0,0.2)","error");
		}
	})
	.fail(function() {
		console.log("error");
	})
})
$('#_code_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showMemberCodes(page_no);
});
$("#_code_form").on('submit', function(e){
	e.preventDefault();
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/codes/_generate',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			$("#generate_code_modal").modal('hide');
			showMemberCodes(1)
			$("#_code_form input").val('');
		}
		else {
			$.NotificationApp.send("Oh, snap!","Something went wrong. Please try again!","top-right","rgba(0,0,0,0.2)","error");
		}
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		console.log("error");
		$("#loader").attr('hidden','hidden');
	})
})

function showMemberCodes(page_no){
	$("#_code_list_tbl").html('<tr class="text-center"><td colspan="6">Getting activation codes...</td></tr>');

	$.ajax({
		url: base_url+'api/v1/codes/_get',
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
					btn_disabled = 'disabled="disabled"';
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
                        +'<td><span class="badge badge-'+stat_label+'-lighten text-capitalize">'+res.result[i].status+'</span></td>'
                        +'<td>'+res.result[i].created_at+'</td>'
                        +'<td width="200">'
                            +'<button id="code_'+res.result[i].ac_id+'_btn" onclick="copyCode(\''+res.result[i].ac_id+'\',\''+res.result[i].code+'\')" class="font-12 text-left btn btn-light btn-sm "><i class="dripicons-copy"></i> </button>&nbsp;'
                            +'<button '+btn_disabled+' onclick="deleteCode('+res.result[i].ac_id+')" class="font-12 text-left btn btn-light btn-sm"><i class="dripicons-trash"></i> </button>&nbsp;'
                            +'<button '+btn_disabled+' onclick="sendTo(\''+res.result[i].ac_id+'\',\''+res.result[i].code+'\',\''+res.result[i].cost+'\',\''+page_no+'\')" class="font-12 text-left btn btn-light btn-sm"><i class=" uil-message"></i>  </button>'
                        +'</td>'
				+'</tr>'
			}
		}
		else{
			string = '<tr class="text-center"><td colspan="6">No Records Found!</td></tr>';
		}
		$("#_code_list_tbl").html(string);
	})
	.fail(function() {
		$("#_code_list_tbl").html('<tr class="text-center"><td colspan="6">No records Found!</td></tr>');
	})
}
function deleteCode(id){
	sweetAlert({
		title:'Are you sure?',
		text: "Once removed, it cannot be recovered!",
		type:'warning',
		showCancelButton: true,
		confirmButtonText: 'Yes, proceed!'
	},function(isConfirm){
		('ok');
	});
	$('.swal2-confirm').click(function(){
		$.ajax({
	    	url: base_url+'api/v1/codes/_delete',
	    	type: 'POST',
	    	dataType: 'JSON',
	    	data: {id:id},
	    	statusCode: {
				403: function() {
					$.NotificationApp.send("Oh Snap!","Something went wrong! Refresh this page and try again!","top-right","rgba(0,0,0,0.2)","error");
				}
			}
	    })
	    .done(function(res) {
	    	if (res.data.status == 'success') {
				$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
				showMemberCodes(1);
	    	}
	    })
	    .fail(function() {
	    	console.log("error");
	    })
	});
}
function copyCode(ac_id, code) {

    new ClipboardJS('#code_'+ac_id+'_btn', {
        text: function(trigger) {
            return code;
       }

   	}); 
   	$.NotificationApp.send("Success!","Copied "+code+"! ","top-right","rgba(0,0,0,0.2)","success")
}
function sendTo(ac_id, code, cost, page_no){
	$("#_user_code").val(''); /* user code, the receiver*/
	$("#_activation_code").val(code);
	$("#send_to_modal").modal('show');
}


function searchUserCode(user_code, name){
	$("#search_code_name").val('');
	$("#_user_name").val(name);
	$("#_user_code").val(user_code)
	$("#search_user_dropdown").hide()
}

if ($("#search_code_name_form").val() == '') {
	$("#search_user_dropdown").hide()
}

if (page == 'code_list') {
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
					string+='<a href="#" onclick="searchUserCode(\''+res.data.search[i].user_code+'\',\''+res.data.search[i].name+'\')" class="dropdown-item notify-item"><span id="user_name"> '+res.data.search[i].name+'</span> <span>(#'+res.data.search[i].user_code+')</span></a>'
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
function searchUserCode(search_user_code, name){
	$("#search_code_name").val('');
	$("#_user_name").val(name);
	$("#_user_code").val(search_user_code)
	$("#search_user_dropdown").hide()
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
		url: base_url+'api/v1/users/_send_code',
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
		}
		else{
			$.NotificationApp.send("Oh, snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
	})
	.fail(function() {
		console.log("error");
	})
})
