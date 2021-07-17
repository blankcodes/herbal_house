var base_url;
if (page == 'dashboard') {
	if (typeof $.cookie('earn_more_modal') === 'undefined') { //cookie warning-terms-conditions
      	setTimeout(function(){
         	$("#_news_earn_more_modal").modal('show');
     	}, 1000)
     	$("#_news_earn_more_modal, .btn").click(function() {
         	$.cookie('earn_more_modal', 'true', { expires: 1, path: '/' });
     	}); 
 	}
}
	

if (page == 'dashboard') {
	checkUserStatus();
	getUserDashboardOverview(user_code);
	showProductUnilevelPoints(1);
}

else if (page == 'admin_dashboard') {
	getHerbalHouseOverview();
	showWithdrawRequestDashboard();
	showAllOrders(1)
	showOrderChart();
	checkToDoList();
}
else if (page == 'withdraw_request') {
	showWithdrawRequest(1);
}
else if (page == 'user_overview') {
	getUserDashboardOverviewOpt(user_code);
	showInDirectList(2, user_code, 1)
	showProductUnilevelPointsOpt(1, user_code)
	getWalletActivity(1, user_code)
}
$(".close-jq-toast-single").on('click', function() {
	$("#_alert_web_message").fadeOut(500)
})
$('#_repeat_purchase_opt_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showProductUnilevelPointsOpt(page_no, user_code);
});
$('#_indirect_invites_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    var level = $("#_select_level").val();
    showInDirectList(level, user_code, page_no)
});
function checkUserStatus(){
	$.ajax({
		url: base_url+'api/v1/user/_get_user_status', type: 'GET', dataType: 'JSON',
	})
	.done(function(res) {
		if (res.data.status == 'inactive') {
			$("#_alert_title").text('Welcome!');
			$("#_alert_message").text('This is your Herbal House account!');
			$("#_alert_web_message").show()
			updateUserStatus();	
		}
	})
	.fail(function() {
		console.log("error");
	})
}

function updateUserStatus(){
	$.ajax({
		url: base_url+'my-account/updateUserStatus', type: 'GET', dataType: 'JSON',
	})
}

function getUserDashboardOverview (user_code) {
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/member/_get_user_overview', type: 'GET', dataType: 'JSON', data: {user_code:user_code}
	})
	.done(function(res) {
		$("#_total_revenue").text(res.data.wallet)
		$("#_cash_wallet").text(res.data.wallet)
		$("#_indirect_ref_wallet").text(res.data.indirect_ref.balance)
		$("#_unilvel_wallet").text(res.data.unilevel_bonus.balance)
		$("#_direct_users").text(res.data.direct_invites)
		$("#_indirect_users").text(res.data.indirect_invites)
		$("#_code_credits").text(res.data.code_credits.count)
		$("#_order_count").text(res.data.orders.count)
		$("#loader").attr('hidden','hidden');

		setTimeout(function() {
			getUserDashboardOverview(user_code)
			showProductUnilevelPoints(1)
		}, 30000)
	})
	.fail(function() {
		
	})
}
function getHerbalHouseOverview() {
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/website/_get_overview', type: 'GET', dataType: 'JSON',
	})
	.done(function(res) {
		$("#_members_count").text(res.data.member_count)
		$("#_orders_today_count").text(res.data.orders_today)
		$("#_orders_count").text(res.data.order_count)
		$("#_withdraw_request").text(res.data.withdrawal_request)

		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		console.log("error");
	})
}
$('#_repeat_purchase_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showProductUnilevelPoints(page_no);
});
$('#_withdraw_request_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showWithdrawRequest(page_no);
});
$('#_wallet_activity_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    getWalletActivity(page_no, user_code);
});
function showProductUnilevelPoints(page_no){
	$("#_repeat_purchase_tbl").html('<tr class="text-center"><td colspan="5">Loading data...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/product/_get_repeat_purchase_record',
		type: 'GET',
		dataType: 'JSON',
        data: {page_no:page_no}
	})
	.done(function(res) {
		$('#_repeat_purchase_pagination').html(res.pagination);
		mob_string = '';
		string = '';
		order_status_badge = 'info';

		if (parseInt(res.count) > 0) {
			for(var i in res.result) {
				if (res.result[i].status == 'complete') {
					order_status_badge = 'success';
				}
				
				string +='<tr>'
                 	+'<td>'
	                    +'<div class="form-check">'
	                        +'<input type="checkbox" class="form-check-input" id="customCheck2">'
	                        +'<label class="form-check-label" for="customCheck2">&nbsp;</label>'
	                    +'</div>'
                    +'</td>'
                    +'<td>#'+res.result[i].ref_no+'</td>'
                    +'<td>'+res.result[i].product+'</td>'
                    +'<td><span class="badge badge-success-lighten font-14">'+res.result[i].points+'</span></td>'
                    +'<td>'+res.result[i].created_at+'</td>'
       			+'</tr>'
			}
		}
        else{
			string = '<tr class="text-center"><td colspan="5">No records found!</td></tr>';
        }
        $("#_repeat_purchase_tbl").html(string);
	})
	.fail(function() {
		$("#_repeat_purchase_tbl").html('<tr class="text-center"><td colspan="5">No records found!</td></tr>');
	});
}
function generateQr(qr_code, name) { 
	$("#loader").removeAttr('hidden');
	let data = { qr_code: qr_code, name: name }; 
    var qrcode = new QRCode(document.getElementById("qr_code"), {
	    width : 320,
	    height : 320
	});
    qrcode.makeCode(JSON.stringify(data));
    $("#qr_code img").addClass('img-fluid');
    $("#qr_code_modal").modal('show');
	$("#loader").attr('hidden','hidden');
}
function earnMore(user_code) { 
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/user/_get_aff_id', type: 'GET', dataType: 'JSON'
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$("#copy_url_btn").removeAttr('disabled', 'disabled');
			$('#_aff_alert_div').attr('hidden','hidden');
			$("#copy_url_btn").attr('onclick','copyAffUrl("'+res.data.aff_link+'")');
			$("#_aff_link").val(res.data.aff_link);
		}
		else if (res.data.status == 'failed') {
			$("#copy_url_btn").attr('disabled', 'disabled');
			$('#_aff_alert_div').removeAttr('hidden','hidden');
			$('#_aff_alert_message').text(res.data.response);
			$("#copy_url_btn").attr('onclick','copyAffUrl("'+res.data.aff_link+'")');
			$("#_aff_link").val(res.data.aff_link);
		}
		$("#loader").attr('hidden','hidden');
    	$("#earn_more_modal").modal('show');
	})
	.fail(function() {
		
	})
}
function copyAffUrl(url) {
    new ClipboardJS('#copy_url_btn', {
        text: function(trigger) {
            return url;
       }
   	}); 
   	$.NotificationApp.send("Success!","Copied URL!","top-right","rgba(0,0,0,0.2)","success")
}
$("#_qr_modal_close_btn").on('click', function() {
	$("#qr_code img").attr('src','').attr('alt','');;
})
$("#__qr_modal_close_btn").on('click', function() {
	$("#qr_code img").attr('src','').attr('alt','');;
})

function showWithdrawRequest(page_no){
	$("#_withdraw_request_tbl").html('<tr class="text-center"><td colspan="10">Loading data...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/wallet/_withdraw_request',
		type: 'GET',
		dataType: 'JSON',
        data: {page_no:page_no}
	})
	.done(function(res) {
		$('#_withdraw_request_pagination').html(res.pagination);
		string = '';
		btn_stat = '';
		option_list = '';
		if (parseInt(res.count) > 0) {
			for(var i in res.result) {
				if (res.result[i].status == 'complete') {
					btn_stat = 'success';
					option_list = '';
					option_text = '--';
				}
				else if (res.result[i].status == 'pending') {
					btn_stat = 'primary';
					option_list = 'processWithdrawRequest(\''+res.result[i].ref_no+'\')';
					option_text = 'Process';
				}
				else if (res.result[i].status == 'closed') {
					btn_stat = 'danger';
					option_list = '';
					option_text = '--';
				}
				else if (res.result[i].status == 'processing') {
					btn_stat = 'warning';
					option_list = 'processWithdrawRequest(\''+res.result[i].ref_no+'\')';
					option_text = 'Process';
				}

				string +='<tr>'
                    +'<td>#'+res.result[i].ref_no+'</td>'
                    +'<td><a target="_blank" href="'+base_url+'user/overview/'+res.result[i].user_code+'">'+res.result[i].user_code+'</td>'
                    +'<td>'+res.result[i].amount+'</td>'
                    +'<td>'+res.result[i].payment_method+'</td>'
                    +'<td>'+res.result[i].acct_name+'</td>'
                    +'<td>'+res.result[i].acct_number+'</td>'
                    +'<td><span class="badge badge-'+btn_stat+'-lighten font-12 text-capitalize">'+res.result[i].status+'</span></td>'
                    +'<td>'+res.result[i].created_at+'</td>'
                    +'<td class="take-action">'
                    	+'<div class="dropdown">'
					    +'<button class="btn btn-light dropdown-toggle btn-md font-12" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
					       +'Action'
					    +'</button>'
					    +'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'
					        +'<a class="dropdown-item" href="#process" onclick="'+option_list+'">'+option_text+'</a>'
						+'</div>'
                    +'</td>'
       			+'</tr>'
			}
		}
        else{
			string = '<tr class="text-center"><td colspan="10">No records found!</td></tr>';
        }
        $("#_withdraw_request_tbl").html(string);
	})
	.fail(function() {
		$("#_withdraw_request_tbl").html('<tr class="text-center"><td colspan="10">No records found!</td></tr>');
	});
}
function showWithdrawRequestDashboard(page_no){
	$("#_withdraw_request_tbl").html('<tr class="text-center"><td colspan="10">Loading data...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/wallet/_withdraw_request',
		type: 'GET',
		dataType: 'JSON',
        data: {page_no:page_no}
	})
	.done(function(res) {
		$('#_withdraw_request_pagination').html(res.pagination);
		string = '';
		btn_stat = '';
		if (parseInt(res.count) > 0) {
			for(var i in res.result) {
				if (res.result[i].status == 'complete') {
					btn_stat = 'success';
				}
				else if (res.result[i].status == 'pending') {
					btn_stat = 'primary';
				}
				else if (res.result[i].status == 'closed') {
					btn_stat = 'danger';
				}
				else if (res.result[i].status == 'processing') {
					btn_stat = 'warning';
				}
				string +='<tr>'
                    +'<td>#'+res.result[i].ref_no+'</td>'
                    +'<td>'+res.result[i].user_code+'</td>'
                    +'<td>'+res.result[i].amount+'</td>'
                    +'<td>'+res.result[i].payment_method+'</td>'
                    +'<td>'+res.result[i].acct_name+'</td>'
                    +'<td>'+res.result[i].acct_number+'</td>'
                    +'<td><span class="badge badge-'+btn_stat+'-lighten font-12 text-capitalize">'+res.result[i].status+'</span></td>'
                    +'<td>'+res.result[i].created_at+'</td>'
       			+'</tr>'
			}
		}
        else{
			string = '<tr class="text-center"><td colspan="10">No records found!</td></tr>';
        }
        $("#_withdraw_request_tbl").html(string);
	})
	.fail(function() {
		$("#_withdraw_request_tbl").html('<tr class="text-center"><td colspan="10">No records found!</td></tr>');
	});
}
function processWithdrawRequest(ref_no) {
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/wallet/_get_withdraw_request_data',
		type: 'GET',
		dataType: 'JSON',
        data: {ref_no:ref_no}
	})
	.done(function(res) {
		$("#_request_amount").text('₱ '+res.data.request_amount)
		$("#_amount_to_send").text('₱ '+res.data.amount_to_send)
		$("#_processing_fee").text('₱ '+res.data.processing_fee)
		$("#_payment_method").text(res.data.payment_method)
		$("#_acct_name").text(res.data.acct_name)
		$("#_acct_num").text(res.data.acct_number)

		$("#__amount").val(res.data.amount)
		$("#status").val(res.data.amount)
		$("#_user_id").val(res.data.user_code)
		$("#_ref_no").val(res.data.reference_no)
		$('#process_wr_modal').modal('show');
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		$("#_withdraw_request_tbl").html('<tr class="text-center"><td colspan="10">No records found!</td></tr>');
		$("#loader").attr('hidden','hidden');
	});
}
$("#_withdraw_request_form").on('submit', function(e) {
	e.preventDefault();
	status = $("#_rw_status").val();
	ref_no = $("#_ref_no").val();
	amount = $("#__amount").val();
	user_id = $("#_user_id").val();
	if (!status || status == '') {
		$.NotificationApp.send("Oh, Snap!","Status is requered! Please try again!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/wallet/_update_withdraw_request_status',
		type: 'POST',
		dataType: 'JSON',
        data: {status:status, ref_no:ref_no, amount:amount, user_id:user_id}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			showWithdrawRequest(1);
			$('#process_wr_modal').modal('hide');
		}
		else if(res.data.status == 'failed') {
			$.NotificationApp.send("Oh, Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		else{
			$.NotificationApp.send("Oh, Snap!","Something went wrong! Please try again!","top-right","rgba(0,0,0,0.2)","error");
		}
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		$("#_withdraw_request_tbl").html('<tr class="text-center"><td colspan="10">No records found!</td></tr>');
	});
})

$('#order_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showAllOrders(page_no);
});

function showAllOrders(page){
	$("#orders_tbl").html('<tr class="text-center"><td colspan="7">Getting Orders...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/orders/_get_all',
		type: 'GET',
		dataType: 'JSON',
		data: {page_no:page}
	})
	.done(function(res) {
		if (parseInt(res.count) > 0) {
			string = '';
			payment_status_label = '';
			order_status_label = '';
			referrer = '';
			stat_icon = '';

			for(var i in res.result) {
				status = res.result[i].status;
				payment_status = res.result[i].payment_status;

				if (status == 'created') {
					order_status_label = 'info';
					stat_icon = 'uil-shopping-cart-alt';
				}
				else if (status == 'delivered') {
					order_status_label = 'success';
					stat_icon = 'uil-check'
				}
				else if (status == 'cancelled') {
					order_status_label = 'danger';
					stat_icon = 'mdi mdi-cancel'
				}
				else if (status == 'packed') {
					order_status_label = 'primary';
					stat_icon = 'uil-box'
				}
				else if (status == 'shipped') {
					order_status_label = 'warning';
					stat_icon = 'mdi mdi-truck-fast-outline'
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

				if (res.result[i].referrer == 'none') {
					referrer = '<span class="badge badge-warning-lighten font-13">None</span>';
				}
				else{
					referrer = '<span class="badge badge-primary-lighten font-13">'+res.result[i].referrer +'</span>';
				}

				string +='<tr>'
                        +'<td><a target="_blank" href="'+base_url+'order/'+res.result[i].reference_no+'" class="text-body fw-bold cursor-pointer">#'+res.result[i].reference_no+'</a> </td>'
                        +'<td>'
                        	+'<h5 class="dropdown">'
                                 +'<span class="badge badge-'+order_status_label+'-lighten font-12 text-capitalize pointer-cursor" ><i class="'+stat_icon+'"></i> '+res.result[i].status+' </span>'
                        	+'</h5>'

                        +'</td>'
                        +'<td><a class="badge badge-info-lighten font-12" target="_blank" href="'+res.result[i].member_overview+'">'+res.result[i].member+'</a></td>'
                        +'<td class="text-capitalize fw-600">₱ '+res.result[i].total_revenue+'</td>'
                        +'<td>'+res.result[i].payment_method+'</td>'
                        +'<td><h5><span class="badge '+payment_status_label+' text-capitalize font-12"><i class="mdi mdi-coin"></i> '+res.result[i].payment_status+'</span></h5></td>'
                        +'<td><a target="_blank" href="'+res.result[i].referrer_overview+'">'+referrer+'</a></td>'
                        +'<td>'+res.result[i].created_at+'</small></td>'
                    +'</tr>'
			}
		}
		else{
			string = '<tr class="text-center"><td colspan="7">No Orders Found!</td></tr>'
		}
		$('#orders_tbl').html(string)
	})
	.fail(function() {
		$("#orders_tbl").html('<tr class="text-center"><td colspan="8">No Orders Found!</td></tr>');
	})
	.always(function() {
		// $("#orders_tbl").html('<tr class="text-center"><td colspan="7">Loading Products...</td></tr>');
	});
	
}

function getUserDashboardOverviewOpt (user_code) {
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/user/_get_user_overview', type: 'GET', dataType: 'JSON', data: {user_code:user_code}
	})
	.done(function(res) {
		$("#_total_revenue").text(res.data.wallet)
		$("#_cash_wallet").text(res.data.wallet)
		$("#_indirect_ref_wallet").text(res.data.indirect_ref.balance)
		$("#_unilvel_wallet").text(res.data.unilevel_bonus.balance)
		$("#_direct_users").text(res.data.direct_invites)
		$("#_indirect_users").text(res.data.indirect_invites)
		$("#_code_credits").text(res.data.code_credits.count)
		$("#_order_count").text(res.data.orders.count)
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		
	})
}
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
	                    +'<td>'+res.result[i].user_code+'</td>'
	                    +'<td><a href="'+base_url+'user/overview/'+res.result[i].user_code+'">'+res.result[i].name+'</a></td>'
	                    +'<td>'+res.result[i].created_at+'</td>'
				+'</tr>'
			}
		}
		else{
			string = '<tr class="text-center"><td colspan="4">No records found!</td></tr>';
		}
		$("#_indirect_invites_tbl").html(string);
	})
	.fail(function() {
		$("#_indirect_invites_tbl").html('<tr class="text-center"><td colspan="4">No records found!</td></tr>');
	})
}
$("#_select_level").on('change', function() {
	lvl_val = $(this).val();
	showInDirectList(lvl_val, user_code, 1)
})
function showProductUnilevelPointsOpt(page_no, user_code){
	$("#_repeat_purchase_tbl").html('<tr class="text-center"><td colspan="5">Loading data...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/product/_get_repeat_purchase_record_opt',
		type: 'GET',
		dataType: 'JSON',
        data: {page_no:page_no, user_code:user_code}
	})
	.done(function(res) {
		$('#_repeat_purchase_opt_pagination').html(res.pagination);
		mob_string = '';
		string = '';
		order_status_badge = 'info';

		if (parseInt(res.count) > 0) {
			for(var i in res.result) {
				if (res.result[i].status == 'complete') {
					order_status_badge = 'success';
				}
				
				string +='<tr>'
                 	+'<td>'
	                    +'<div class="form-check">'
	                        +'<input type="checkbox" class="form-check-input" id="customCheck2">'
	                        +'<label class="form-check-label" for="customCheck2">&nbsp;</label>'
	                    +'</div>'
                    +'</td>'
                    +'<td>#'+res.result[i].ref_no+'</td>'
                    +'<td>'+res.result[i].product+'</td>'
                    +'<td><span class="badge badge-success-lighten font-14">'+res.result[i].points+'</span></td>'
                    +'<td>'+res.result[i].created_at+'</td>'
       			+'</tr>'
			}
		}
        else{
			string = '<tr class="text-center"><td colspan="5">No records found!</td></tr>';
        }
        $("#_repeat_purchase_tbl").html(string);
	})
	.fail(function() {
		$("#_repeat_purchase_tbl").html('<tr class="text-center"><td colspan="5">No records found!</td></tr>');
	});
}
function getWalletActivity(page_no, user_code){
	$("#_wallet_activity_tbl").html("<tr class='text-center'><td colspan='4'>Getting wallet's recent activity...</td></tr>");
	$.ajax({
		url: base_url+'api/v1/wallet/_get_wallet_recent_activity',
		type: 'GET',
		dataType: 'JSON',
		data: {page_no:page_no,user_code:user_code}
	})
	.done(function(res) {
		string = '';
		$("#_wallet_activity_pagination").html(res.pagination)
		if (res.result.length > 0) {
			for(var i in res.result) {
				string += '<tr>'
	                    +'<td>'
	                        +'<div class="form-check">'
	                            +'<input type="checkbox" class="form-check-input" id="customCheck2">'
	                            +'<label class="form-check-label" for="customCheck2">&nbsp;</label>'
	                        +'</div>'
	                    +'</td>'
	                    +'<td>'
	                        +'<span class="font-14">'+res.result[i].date+'</span>'
	                    +'</td>'
	                    +'<td class="table-user">'
	                        +'<a href="javascript:void(0);" class="text-body"font-14">'+res.result[i].activity+'</a>'
	                    +'</td>'
	                    +'<td>'
	                        +'<span class="font-14">'+res.result[i].amount+'</span>'
	                    +'</td>'
	                    
	           	+'</tr>';
			}
		}
		else{
			string = "<tr class='text-center'><td colspan='4'><i class=' uil-meh-closed-eye '></i> Nothing yet. Start Inviting users now.</td></tr>";
		}
        $("#_wallet_activity_tbl").html(string);

	})
	.fail(function() {
		$("#_wallet_activity_tbl").html("<tr class='text-center'><td colspan='4'><i class=' uil-meh-closed-eye '></i> Nothing yet. Start Inviting users now.</td></tr>");
	})
}
function showOrderChart(from, to){
	$.ajax({
		url: base_url+'api/v1/stat/_order_sales', type: 'GET', dataType: 'JSON', data: {from:from, to:to}
	})
	.done(function(res) {
		orderAreaChart(res.data)
	})
	.fail(function() {
		
	})
}
function orderAreaChart(data){
	date = [];
	sales = [];
	for(var i in data){
        date.push(data[i].date);
        sales.push(data[i].sales);
    }
	var options = {
        	series: [{
        	name: "Sales",
        	data: sales
      	}],
        chart: {
          	type: 'area',
          	height: 238,
          	zoom: {
            	enabled: false
          	}
        },
       	colors: ['#0acf97'],
        dataLabels: {
          	enabled: false
        },
        stroke: {
          	curve: 'smooth'
        },
        
        title: {
          	text: 'Order Sales Statistics (30 days)',
          	align: 'left',
          	colors: '#98a6ad',
        },
        subtitle: {
          	text: '',
          	align: 'left'
        },
        labels: date,
        xaxis: {
          	type: 'datetime',
        },
        yaxis: {
          	opposite: true
        },
        legend: {
          	horizontalAlign: 'left'
        }
    };

    var chart = new ApexCharts(document.querySelector("#order_chart"), options);
    chart.render();
}
function checkToDoList(){
	to_do_wr = '';
	to_do_order = '';
	$.ajax({
		url: base_url+'api/v1/todo/_check_to_do_list', type: 'GET', dataType: 'JSON'
	})
	.done(function(res) {
		if (res.data.check_order > 0) {
			to_do_order +='<div class="alert alert-warning alert-dismissible fade show" role="alert">'
                    +'<button type="button" class="btn-close font-12 mt-1" data-bs-dismiss="alert" aria-label="Close"></button>'
                    +'<strong><i class="uil-exclamation-triangle font-20"></i> </strong> You have active order/s that needs to be Packed or Shipped! Go to <a href="'+base_url+'ecom/orders">Orders List</a>.'
                +'</div>'
			$("#_to_do_order").html(to_do_order)
		}

		if (res.data.check_withdraw_request > 0) {
			to_do_wr +='<div class="alert alert-warning alert-dismissible fade show" role="alert">'
                    +'<button type="button" class="btn-close font-12 mt-1" data-bs-dismiss="alert" aria-label="Close"></button>'
                    +'<strong><i class="uil-exclamation-triangle font-20"></i> </strong> There are still Withdrawal Request you need to Process! Go to <a href="'+base_url+'withdraw-request">Withdrawal Request List</a>.'
                +'</div>'
			$("#_to_do_wr").html(to_do_wr)
		}


	})
	.fail(function() {
		
	})
}
function paymentInfo(){
	$("#payment_modal").modal('show');
}
