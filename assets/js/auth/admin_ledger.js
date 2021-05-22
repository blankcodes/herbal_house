var page;
var base_url;


if (page == 'admin_ledger') {
	showPackageList(1);
}
$("#add_package").on('click', function() {
	$("#new_package_modal").modal('show');
})
$('#_package_list_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showPackageList(page_no);
});
$("#_new_package_form").on('submit', function(e){
	$("#_add_package_btn").attr('disabled','disabled').text('Adding...');
	e.preventDefault();

	$.ajax({
		url: base_url+'api/v1/package/_add_new',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			$("#_new_package_form .form-control").val('');
			$("#new_package_modal").modal('hide');
			showPackageList(1)
		}
		else{
			$.NotificationApp.send("Oh, Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		$("#_add_package_btn").removeAttr('disabled').text('Add');
		newCsrfData();
	})
	.fail(function() {
		newCsrfData();
	})
})

function showPackageList(page_no) {
	$("#_package_list_tbl").html('<tr class="text-center"><td colspan="10">Getting package list...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/package/_get_package_list/'+page_no,
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		$('#_package_list_pagination').html(res.pagination);
		string = '';
		badge_status = 'warning';
		status_update = 'active';
		if (res.result.length > 0) {
			for(var i in res.result) {
				if (res.result[i].status == 'active') {
					badge_status = 'success'
					status_update = 'disabled';
				}
				
				string += '<tr>'
	                    +'<td class="table-user">'
	                        +'<a href="javascript:void(0);" class="text-body">'+res.result[i].name+'</a>'
	                    +'</td>'
	                    +'<td>'
	                        +'<span class="">'+res.result[i].cost+'</span>'
	                    +'</td>'
	                    +'<td>'
	                        +'<span class="">'+res.result[i].direct_points+'</span>'
	                    +'</td>'
	                    +'<td>'
	                        +'<span class="">'+res.result[i].match_points+'</span>'
	                    +'</td>'
	                    +'<td>'
	                        +'<span class="">'+res.result[i].unilvl_points+'</span>'
	                    +'</td>'
	                    +'<td>'
	                        +'<span class="">'+res.result[i].pm_maximum_points+'</span>'
	                    +'</td>'
	                    +'<td>'
	                        +'<span class="">'+res.result[i].am_maximum_points+'</span>'
	                    +'</td>'
	                    +'<td class=""><span>'+res.result[i].profit_sharing_points+'</td>'
	                    +'<td>'
	                        +'<span class="fw-400 badge badge-'+badge_status+'-lighten text-capitalize pointer-cursor font-12" onclick="updatePackageStatus(\''+res.result[i].p_id+'\', \''+status_update+'\',\''+page_no+'\')">'+res.result[i].status+'</span>'
	                    +'</td>'
	                    +'<td class=""><span>'+res.result[i].created_at+'</td>'
	                    
	                    +'<td>'
	                        +'<div class="dropdown">'
							    +'<button class="btn btn-light btn-sm dropdown-toggle font-12" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
							        +'Action'
							    +'</button>'
							    +'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'
							        +'<a class="dropdown-item" href="#edit_package" onclick="editPackage('+res.result[i].p_id+')">Edit</a>'
							    +'</div>'
							+'</div>'
	                    +'</td>'
	           	+'</tr>'
			}
		}
		else{
			string = '<tr class="text-center"><td colspan="10">No record found!</td></tr>';
		}
		$("#_package_list_tbl").html(string);

	})
	.fail(function() {
		$("#_package_list_tbl").html('<tr class="text-center"><td colspan="10">No record found!</td></tr>');

	})
}
function editPackage(p_id){
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/package/_get_package',
		type: 'GET',
		dataType: 'JSON',
		data: {p_id:p_id}
	})
	.done(function(res) {
		$("#p_id").val(res.data.p_id);
		$("#_edit_match_points").val(res.data.match_points);
		$("#_edit_direct_points").val(res.data.direct_points);
		$("#_edit_package").val(res.data.name);
		$("#_edit_cost").val(res.data.cost);
		$("#_edit_unilvl_points").val(res.data.unilvl_points);
		$("#_edit_description").val(res.data.description);
		$("#_edit_max_points_am").val(res.data.am_maximum_points);
		$("#_edit_max_points_pm").val(res.data.pm_maximum_points);
		$("#edit_package_modal").modal('show');
		$("#loader").attr('hidden','hidden');

	})
	.fail(function() {
		console.log("error");
		$("#loader").attr('hidden','hidden');

	})
}
$("#_update_package_form").on('submit', function(e){
	$("#_update_package_btn").attr('disabled','disabled').text('Updating Package...');
	e.preventDefault();

	$.ajax({
		url: base_url+'api/v1/package/_update_package',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			showPackageList(1)
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			$("#edit_package_modal").modal('hide');
		}
		else{
			$.NotificationApp.send("Oh, Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		$("#_update_package_btn").removeAttr('disabled').text('Update Package');
		newCsrfData();
	})
	.fail(function() {
		newCsrfData();
	})
})
function updatePackageStatus(p_id, status, page_no) {
	sweetAlert({
		title:'Update Package Status?',
		text: "This will update package status to "+status+".",
		type:'warning',
		showCancelButton: true,
		confirmButtonColor: '#3699ff',
		cancelButtonColor: '#98a6ad',
		confirmButtonText: 'Yes, proceed!'
	},function(isConfirm){
		('ok');
	});
	$('.swal2-confirm').click(function(){
		$.ajax({
	    	url: base_url+'api/v1/package/_update_status',
	    	type: 'GET',
	    	dataType: 'JSON',
	    	data: {p_id:p_id, status:status},
	    })
	    .done(function(res) {
	    	if (res.data.status == 'success') {
	    		$.NotificationApp.send(
	    			"Success!",
	    			res.data.message,
	    			"top-right",
	    			"rgba(0,0,0,0.2)", "success"
	    		);
				showPackageList(page_no);
	    	}
	    })
	    .fail(function() {
	    	console.log("error");
	    })
	});
}