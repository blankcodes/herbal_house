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
		user_type = 'info'
		for(var i in res.result) {
			if (res.result[i].user_type == 'admin') {
				user_type = 'success';
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