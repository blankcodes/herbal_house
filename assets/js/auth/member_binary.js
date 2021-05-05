var base_url;
var page;
var user_code;

if (page == 'member_binary_list') {
	showBinaryTree(user_code);
}
$("#_select_package").on('change', function() {
    code = $(this).val();
    getPackageData(code)
})

$('#register_direct_form').on('submit', function(e) {
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
		url: base_url+'api/v1/register/_direct_user',
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
               window.location.href=base_url+"member/binary";
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
function showBinaryTree(code_id) {
	$("#orgChart").html('<div class="text-center">Loading records...</div>');
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/binary/_get_tree_genealogy',
		type: 'GET',
		dataType: 'JSON',
		data: {user_code:code_id}
	})
	.done(function(res) {
		string = '';
		tbl_node_left = '<a class="register-name" href="'+base_url+'register/sponsor/'+user_code+'/'+res.data.user_code+'/left">Register</a>';
		tbl_node_right = '<a class="register-name" href="'+base_url+'register/sponsor/'+user_code+'/'+res.data.user_code+'/right">Register</a>';

		tbl_node_l_left_lvl2 = '';
		tbl_node_l_right_lvl2 = '';

		tbl_node_r_right_lvl2 = '';
		tbl_node_r_left_lvl2 = '';

		direct = res.data.direct;

		
		if (direct.length > 0) {
			// direct | level 1 left and right
			if (direct[0] != undefined && direct[0].position == 'left') {
				tbl_node_left = '<a class="name-direct-invite text-capitalize" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="top" title="'+direct[0].fname+' '+direct[0].lname+'" onclick="showBinaryTree(\''+direct[0].user_code+'\')">'+direct[0].fname+' '+direct[0].lname+'</a>';
			}
			else if(direct[0] != undefined && direct[0].position == 'right') {
				tbl_node_right = '<a class="name-direct-invite text-capitalize" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="top" title="'+direct[0].fname+' '+direct[0].lname+'" onclick="showBinaryTree(\''+direct[0].user_code+'\')"">'+direct[0].fname+' '+direct[0].lname+'</a>';
			}

			if (direct[1] != undefined && direct[1].position == 'right') {
				tbl_node_right = '<a data-position="direct_direct" class="name-direct-invite text-capitalize" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="'+direct[1].fname+' '+direct[1].lname+'" onclick="showBinaryTree(\''+direct[1].user_code+'\')">'+direct[1].fname+' '+direct[1].lname+'</a>';
			}
			else if(direct[1] != undefined && direct[1].position == 'left') {
				tbl_node_left = '<a data-position="left_direct" class="name-direct-invite text-capitalize" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="'+direct[1].fname+' '+direct[1].lname+'" onclick="showBinaryTree(\''+direct[1].user_code+'\')">'+direct[1].fname+' '+direct[1].lname+'</a>';
			}


			// level 2 LEFT (left and right)
			if (direct[0].position == 'left') {
				tbl_node_l_left_lvl2 = '<a class="register-name" href="'+base_url+'register/sponsor/'+user_code+'/'+direct[0].user_code+'/left">Register</a>';
				tbl_node_l_right_lvl2 = '<a class="register-name" href="'+base_url+'register/sponsor/'+user_code+'/'+direct[0].user_code+'/right">Register</a>';


				if (direct[0].dLvl2[0] != undefined && direct[0].dLvl2[0].position == 'left') {
					tbl_node_l_left_lvl2 = '<a class="name-direct-invite text-capitalize" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="top" title="'+direct[0].dLvl2[0].fname+' '+direct[0].dLvl2[0].lname+'" onclick="showBinaryTree(\''+direct[0].dLvl2[0].user_code+'\')">'+direct[0].dLvl2[0].fname+' '+direct[0].dLvl2[0].lname+'</a>';
				}
				else if(direct[0].dLvl2[0] != undefined && direct[0].dLvl2[0].position == 'right') {
					tbl_node_l_right_lvl2 = '<a class="name-direct-invite text-capitalize" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="top" title="'+direct[0].dLvl2[0].fname+' '+direct[0].dLvl2[0].lname+'" onclick="showBinaryTree(\''+direct[0].dLvl2[0].user_code+'\')">'+direct[0].dLvl2[0].fname+' '+direct[0].dLvl2[0].lname+'</a>';
				}
				
				
				if (direct[0].dLvl2[1] != undefined && direct[0].dLvl2[1].position == 'left') {
					tbl_node_l_left_lvl2 = '<a class="name-direct-invite text-capitalize" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="top" title="'+direct[0].dLvl2[1].fname+' '+direct[0].dLvl2[1].lname+'" onclick="showBinaryTree(\''+direct[0].dLvl2[1].user_code+'\')">'+direct[0].dLvl2[1].fname+' '+direct[0].dLvl2[1].lname+'</a>';
				}
				else if(direct[0].dLvl2[1] != undefined && direct[0].dLvl2[1].position == 'right') {
					tbl_node_l_right_lvl2 = '<a class="name-direct-invite text-capitalize" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="top" title="'+direct[0].dLvl2[1].fname+' '+direct[0].dLvl2[1].lname+'" onclick="showBinaryTree(\''+direct[0].dLvl2[1].user_code+'\')">'+direct[0].dLvl2[1].fname+' '+direct[0].dLvl2[1].lname+'</a>';
				}
			}

            if (direct[0].position == 'right') {
                tbl_node_r_left_lvl2 = '<a class="register-name" href="'+base_url+'register/sponsor/'+user_code+'/'+direct[0].user_code+'/left">Register</a>';
                tbl_node_r_right_lvl2 = '<a class="register-name" href="'+base_url+'register/sponsor/'+user_code+'/'+direct[0].user_code+'/right">Register</a>';

                if (direct[0].dLvl2[0] != undefined && direct[0].dLvl2[0].position == 'left') {
                    tbl_node_r_left_lvl2 = '<a class="name-direct-invite text-capitalize" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="top" title="'+direct[0].dLvl2[0].fname+' '+direct[0].dLvl2[0].lname+'" onclick="showBinaryTree(\''+direct[0].dLvl2[0].user_code+'\')">'+direct[0].dLvl2[0].fname+' '+direct[0].dLvl2[0].lname+'</a>';
                }
                else if(direct[0].dLvl2[0] != undefined && direct[0].dLvl2[0].position == 'right') {
                    tbl_node_r_right_lvl2 = '<a class="name-direct-invite text-capitalize" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="top" title="'+direct[0].dLvl2[0].fname+' '+direct[0].dLvl2[0].lname+'" onclick="showBinaryTree(\''+direct[0].dLvl2[0].user_code+'\')">'+direct[0].dLvl2[0].fname+' '+direct[0].dLvl2[0].lname+'</a>';
                }

                if (direct[0].dLvl2[1] != undefined && direct[0].dLvl2[1].position == 'left') {
                    tbl_node_r_left_lvl2 = '<a class="name-direct-invite text-capitalize" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="top" title="'+direct[0].dLvl2[1].fname+' '+direct[0].dLvl2[1].lname+'" onclick="showBinaryTree(\''+direct[0].dLvl2[1].user_code+'\')">'+direct[0].dLvl2[1].fname+' '+direct[0].dLvl2[1].lname+'</a>';
                }
                else if(direct[0].dLvl2[1] != undefined && direct[0].dLvl2[1].position == 'right') {
                    tbl_node_r_right_lvl2 = '<a class="name-direct-invite text-capitalize" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="top" title="'+direct[0].dLvl2[1].fname+' '+direct[0].dLvl2[1].lname+'" onclick="showBinaryTree(\''+direct[0].dLvl2[1].user_code+'\')">'+direct[0].dLvl2[1].fname+' '+direct[0].dLvl2[1].lname+'</a>';
                }
            }


			if (direct[1] != undefined ) {
                // level 2 RIGHT (left and right)
                if (direct[1].position == 'right') {
                    tbl_node_r_left_lvl2 = '<a class="register-name" href="'+base_url+'register/sponsor/'+user_code+'/'+direct[1].user_code+'/left">Register</a>';
                    tbl_node_r_right_lvl2 = '<a class="register-name" href="'+base_url+'register/sponsor/'+user_code+'/'+direct[1].user_code+'/right">Register</a>';
                    
                    if (direct[1].dLvl2[0] != undefined && direct[1].dLvl2[0].position == 'left') {
                        tbl_node_r_left_lvl2 = '<a class="name-direct-invite text-capitalize" onclick="showBinaryTree(\''+direct[1].dLvl2[0].user_code+'\')">'+direct[1].dLvl2[0].fname+' '+direct[1].dLvl2[0].lname+'</a>';
                    }
                    else if(direct[1].dLvl2[0] != undefined && direct[1].dLvl2[0].position == 'right') {
                        tbl_node_r_right_lvl2 = '<a class="name-direct-invite text-capitalize" onclick="showBinaryTree(\''+direct[1].dLvl2[0].user_code+'\')">'+direct[1].dLvl2[0].fname+' '+direct[1].dLvl2[0].lname+'</a>';
                    }
                    
                    
                    if (direct[1].dLvl2[1] != undefined && direct[1].dLvl2[1].position == 'left') {
                        tbl_node_r_left_lvl2 = '<a class="name-direct-invite text-capitalize" onclick="showBinaryTree(\''+direct[1].dLvl2[1].user_code+'\')">'+direct[1].dLvl2[1].fname+' '+direct[1].dLvl2[1].lname+'</a>';
                    }
                    else if(direct[1].dLvl2[1] != undefined && direct[1].dLvl2[1].position == 'right') {
                        tbl_node_r_right_lvl2 = '<a class="name-direct-invite text-capitalize" onclick="showBinaryTree(\''+direct[1].dLvl2[1].user_code+'\')">'+direct[1].dLvl2[1].fname+' '+direct[1].dLvl2[1].lname+'</a>';
                    }
                }

                if (direct[1].position == 'left') {
                    tbl_node_l_left_lvl2 = '<a class="register-name" href="'+base_url+'register/sponsor/'+user_code+'/'+direct[1].user_code+'/left">Register</a>';
                    tbl_node_l_right_lvl2 = '<a class="register-name" href="'+base_url+'register/sponsor/'+user_code+'/'+direct[1].user_code+'/right">Register</a>';
                    
                    if (direct[1].dLvl2[0] != undefined && direct[1].dLvl2[0].position == 'left') {
                        tbl_node_l_left_lvl2 = '<a class="name-direct-invite text-capitalize" onclick="showBinaryTree(\''+direct[1].dLvl2[0].user_code+'\')">'+direct[1].dLvl2[0].fname+' '+direct[1].dLvl2[0].lname+'</a>';
                    }
                    else if(direct[1].dLvl2[0] != undefined && direct[1].dLvl2[0].position == 'right') {
                        tbl_node_l_right_lvl2 = '<a class="name-direct-invite text-capitalize" onclick="showBinaryTree(\''+direct[1].dLvl2[0].user_code+'\')">'+direct[1].dLvl2[0].fname+' '+direct[1].dLvl2[0].lname+'</a>';
                    }
                    
                    
                    if (direct[1].dLvl2[1] != undefined && direct[1].dLvl2[1].position == 'left') {
                        tbl_node_l_left_lvl2 = '<a class="name-direct-invite text-capitalize" onclick="showBinaryTree(\''+direct[1].dLvl2[1].user_code+'\')">'+direct[1].dLvl2[1].fname+' '+direct[1].dLvl2[1].lname+'</a>';
                    }
                    else if(direct[1].dLvl2[1] != undefined && direct[1].dLvl2[1].position == 'right') {
                        tbl_node_l_right_lvl2 = '<a class="name-direct-invite text-capitalize" onclick="showBinaryTree(\''+direct[1].dLvl2[1].user_code+'\')">'+direct[1].dLvl2[1].fname+' '+direct[1].dLvl2[1].lname+'</a>';
                    }
                }
            }
		}

		
		string+='<table cellspacing="0" cellpadding="0" border="0">'
                   	+'<tbody>'
                       	+'<tr>'
                           	+'<td colspan="4">'
                               	+'<div class="node" node-id="1">'
                                   	+'<h2 class="uil-user-circle font-40"></h2>'
                                   	+'<a class="user-name text-capitalize" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="top" title="'+res.data.fname+' '+res.data.lname+'">'+res.data.fname+' '+res.data.lname+'</a>'
                               	+'</div>'
                           	+'</td>'
                       	+'</tr>'

                        +'<tr class="lines">'
                            +'<td colspan="4">'
                                +'<table cellspacing="0" cellpadding="0" border="0">'
                                    +'<tbody>'
                                        +'<tr class="lines x">'
                                            +'<td class="line left half"></td>'
                                            +'<td class="line right half"></td>'
                                        +'</tr>'
                                    +'</tbody>'
                                +'</table>'
                            +'</td>'
                        +'</tr>'

                        +'<!-- vertical lines -->'
                        +'<tr class="lines v">'
                            +'<td class="line left"></td>'
                            +'<td class="line right top"></td>'
                            +'<td class="line left top"></td>'
                            +'<td class="line right"></td>'
                        +'</tr>'

                        // if (direct.length > 0) {
                        // 	for(var i in direct )
                        // }
                        +'<tr>'
                            +'<td colspan="2">'
                                +'<table cellspacing="0" cellpadding="0" border="0">'
                                    +'<tbody>'

                                        +'<tr>'
                                            +'<td colspan="4">'
                                                +'<div class="node" node-id="2">'
                                                    +'<h2 class="uil-user-circle font-40"></h2>'
                                                   	+tbl_node_left
                                                +'</div>'
                                            +'</td>'
                                        +'</tr>'

                                        +'<tr class="lines">'
                                            +'<td colspan="4">'
                                                +'<table cellspacing="0" cellpadding="0" border="0">'
                                                    +'<tbody>'
                                                        +'<tr class="lines x">'
                                                            +'<td class="line left half"></td>'
                                                            +'<td class="line right half"></td></tr>'
                                                    +'</tbody>'
                                                +'</table>'
                                             +'</td>'
                                        +'</tr>'

                                        +'<tr class="lines v">'
                                            +'<td class="line left"></td>'
                                            +'<td class="line right top"></td>'
                                            +'<td class="line left top"></td>'
                                            +'<td class="line right"></td>'
                                        +'</tr>'
                                        +'<tr>'
                                            +'<td colspan="2">'
                                                +'<table cellspacing="0" cellpadding="0" border="0">'
                                                    +'<tbody>'
                                                        +'<tr>'
                                                            +'<td colspan="4">'
                                                                +'<div class="node" node-id="4">'
                                                                    +'<h2 class="uil-user-circle font-40"></h2>'
                                                                    +tbl_node_l_left_lvl2
                                                                +'</div>'
                                                            +'</td>'
                                                        +'</tr>'
                                                    +'</tbody>'
                                                +'</table>'
                                            +'</td>'

                                            +'<td colspan="2">'
                                                +'<table cellspacing="0" cellpadding="0" border="0">'
                                                    +'<tbody>'
                                                        +'<tr>'
                                                            +'<td colspan="4">'
                                                                +'<div class="node" node-id="5">'
                                                                    +'<h2 class="uil-user-circle font-40"></h2>'
                                                                    +tbl_node_l_right_lvl2
                                                                +'</div>'
                                                            +'</td>'
                                                        +'</tr>'
                                                    +'</tbody>'
                                                +'</table>'
                                            +'</td>'
                                        +'</tr>'
                                    +'</tbody>'
                                +'</table>'
                            +'</td>'

                            +'<td colspan="2">'
                                +'<table cellspacing="0" cellpadding="0" border="0">'
                                    +'<tbody>'
                                        +'<tr>'
                                            +'<td colspan="4">'
                                                +'<div class="node" node-id="3">'
                                                    +'<h2 class="uil-user-circle font-40"></h2>'
                                                	+tbl_node_right
                                                +'</div>'
                                            +'</td>'
                                        +'</tr>'

                                        +'<tr class="lines">'
                                            +'<td colspan="4">'
                                                +'<table cellspacing="0" cellpadding="0" border="0">'
                                                    +'<tbody>'
                                                        +'<tr class="lines x">'
                                                            +'<td class="line left half"></td>'
                                                            +'<td class="line right half"></td>'
                                                        +'</tr>'
                                                     +'</tbody>'
                                                +'</table>'
                                             +'</td>'
                                        +'</tr>'

                                        +'<tr class="lines v">'
                                            +'<td class="line left"></td>'
                                            +'<td class="line right top"></td>'
                                            +'<td class="line left top"></td>'
                                            +'<td class="line right"></td>'
                                        +'</tr>'

                                        +'<tr>'
                                            +'<td colspan="2">'
                                                +'<table cellspacing="0" cellpadding="0" border="0">'
                                                    +'<tbody>'
                                                        +'<tr>'
                                                            +'<td colspan="4">'
                                                                +'<div class="node" node-id="6">'
                                                                    +'<h2 class="uil-user-circle font-40"></h2>'
                                                                    +tbl_node_r_left_lvl2
                                                                +'</div>'
                                                            +'</td>'
                                                        +'</tr>'
                                                    +'</tbody>'
                                                +'</table>'
                                            +'</td>'

                                            +'<td colspan="2">'
                                                +'<table cellspacing="0" cellpadding="0" border="0">'
                                                    +'<tbody>'
                                                        +'<tr>'
                                                            +'<td colspan="4">'
                                                                +'<div class="node" node-id="7">'
                                                                    +'<h2 class="uil-user-circle font-40"></h2>'
                                                                    +tbl_node_r_right_lvl2 
                                                                +'</div>'
                                                            +'</td>'
                                                        +'</tr>'
                                                    +'</tbody>'
                                                +'</table>'
                                            +'</td>'
                                        +'</tr>'
                                    +'</tbody>'
                                +'</table>'
                            +'</td>'
                        +'</tr>'
                    +'</tbody>'
                +'</table>'

        $("#orgChart").html(string);
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
	})	
}

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