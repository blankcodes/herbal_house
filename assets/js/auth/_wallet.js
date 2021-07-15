var base_url;
var page;

if (page == 'wallet') {
	getIndirectWalletBalance();
	getUnilevelWalletBalance();
	getWalletBalance();
	getWalletActivity(1)
}
$('#_wallet_activity_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    getWalletActivity(page_no);
});
$("#_withdraw_request_btn").on('click', function() {
	$.ajax({
		url: base_url+'api/v1/wallet/_get_wallet_balance',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		$("#_balance").text(res.data.balance);
		$("#withdrawal_req_modal").modal('show');
	})
	.fail(function() {
		console.log("error");
	})
})
$("#_tranfer_bal_btn").on('click', function() {
	$("#tranfer_bal_modal").modal('show')
})
function getWalletBalance() {
	$.ajax({
		url: base_url+'api/v1/wallet/_get_wallet_balance',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		$("#_wallet_balance").text(res.data.balance);
		if (res.data.status == 'allow') {
			$("#_withdraw_request_btn").removeAttr('disabled','disabled');
		}
		else{
			$("#_withdraw_request_btn").attr('disabled','disabled');
		}
	})
	.fail(function() {
		console.log("error");
	})
}
function getIndirectWalletBalance() {
	$.ajax({
		url: base_url+'api/v1/wallet/_get_indirect_wallet_balance',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		$("#_indirect_ref_balance").text(res.data.balance)
	})
	.fail(function() {
		console.log("error");
	})
}
function getUnilevelWalletBalance() {
	$.ajax({
		url: base_url+'api/v1/wallet/_get_unilevel_wallet_balance',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		$("#_unilevel_balance").text(res.data.balance)
	})
	.fail(function() {
		console.log("error");
	})
}
function getWalletActivity(page_no){
	$("#_wallet_activity_tbl").html("<tr class='text-center'><td colspan='4'>Getting wallet's recent activity...</td></tr>");
	$.ajax({
		url: base_url+'api/v1/wallet/_get_recent_activity',
		type: 'GET',
		dataType: 'JSON',
		data: {page_no:page_no}
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
// $("#_withdraw_review_btn").on('submit', function() {
// 	_withdraw_amount = $("#_withdraw_amount").val();
// 	_payment_method = $("#_payment_method").val();
// 	_account_name = $("#_account_name").val();
// 	_account_number = $("#_account_number").val();


// 	if (_withdraw_amount == '' || !_withdraw_amount) {
// 		$.NotificationApp.send("Oh, Snap!","Amount is required!","top-right","rgba(0,0,0,0.2)","error");
// 		return false;
// 	}


// 	if (_payment_method == '' || !_payment_method) {
// 		$.NotificationApp.send("Oh, Snap!","Payment Method is required!","top-right","rgba(0,0,0,0.2)","error");
// 		return false;
// 	}

// 	if (_account_name == '' || !_account_name) {
// 		$.NotificationApp.send("Oh, Snap!","Account Name is required!","top-right","rgba(0,0,0,0.2)","error");
// 		return false;
// 	}

// 	if (_account_number == '' || !_account_number) {
// 		$.NotificationApp.send("Oh, Snap!","Account Number is required!","top-right","rgba(0,0,0,0.2)","error");
// 		return false;
// 	}

// 	total_amnt = parseInt(_withdraw_amount) - 50;
// 	$("#_review_balance").text(total_amnt);
// 	$("#_review_pay_method").text(_payment_method);
// 	$("#_review_acct_name").text(_account_name);
// 	$("#_review_acct_num").text(_account_number);

// 	$("#withdrawal_req_modal").modal('hide');
// 	$("#withdrawal_review_modal").modal('show');
// })

$("#_cancel_withdraw").on('click', function() {
	$("#withdrawal_req_modal").modal('show');
	$("#withdrawal_review_modal").modal('hide');
})

$("#_withdrawal_request_form").on('submit', function(e){
	e.preventDefault();

	_withdraw_amount = $("#_withdraw_amount").val();
	_payment_method = $("#_payment_method").val();
	_account_name = $("#_account_name").val();
	_account_number = $("#_account_number").val();


	if (_withdraw_amount == '' || !_withdraw_amount) {
		$.NotificationApp.send("Oh, Snap!","Amount is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}


	if (_payment_method == '' || !_payment_method) {
		$.NotificationApp.send("Oh, Snap!","Payment Method is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	if (_account_name == '' || !_account_name) {
		$.NotificationApp.send("Oh, Snap!","Account Name is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	if (_account_number == '' || !_account_number) {
		$.NotificationApp.send("Oh, Snap!","Account Number is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	$("#loader").removeAttr('hidden');
	$("#_withdraw_review_btn").attr('disabled', 'disabled');
	$.ajax({
		url: base_url+'api/v1/wallet/_review_withdraw_request',
		type: 'GET',
		dataType: 'JSON',
		data: {amount: _withdraw_amount}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			
			$("#_review_balance").text(res.data.total_amount);
			$("#_processing_fee").text(res.data.processing_fee);
			$("#_review_pay_method").text(_payment_method);
			$("#_review_acct_name").text(_account_name);
			$("#_review_acct_num").text(_account_number);

			$("#__withdraw_amount").val(res.data.total);
		 	$("#__payment_method").val(_payment_method);
			$("#__account_name").val(_account_name);
			$("#__account_number").val(_account_number);

			$("#withdrawal_req_modal").modal('hide');
			$("#withdrawal_review_modal").modal('show');
		}
		else if(res.data.status == 'failed') {
			$.NotificationApp.send("Oh, snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}

		newCsrfData();
		$("#loader").attr('hidden','hidden');
		$("#_withdraw_review_btn").removeAttr('disabled', 'disabled');
	})
	.fail(function() {
		$("#loader").attr('hidden','hidden');
		$("#_withdraw_review_btn").removeAttr('disabled', 'disabled');
	})
})

$("#_withdraw_form").on('submit', function(e) {

	_amount = $('#__withdraw_amount').val();
	_payment_method = $('#__payment_method').val();
	_account_name = $('#__account_name').val();
	_account_number = $('#__account_number').val();

	if (_amount == '' || !_amount) {
		$.NotificationApp.send("Oh, Snap!","Amount is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	if (_payment_method == '' || !_payment_method) {
		$.NotificationApp.send("Oh, Snap!","Payment Method is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	if (_account_name == '' || !_account_name) {
		$.NotificationApp.send("Oh, Snap!","Account Name is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	if (_account_number == '' || !_account_number) {
		$.NotificationApp.send("Oh, Snap!","Account Number is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	e.preventDefault();
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/wallet/_withdraw',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize()
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			$("#withdrawal_req_modal").modal('hide');
			$("#withdrawal_review_modal").modal('hide');

			getWalletActivity(1);
			getWalletBalance();
		}
		else if(res.data.status == 'failed') {
			$.NotificationApp.send("Oh, snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		newCsrfData();
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		console.log("error");
	})
})
$('#_select_wallet').on('change', function() {
	type = $(this).val();
	
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/wallet/_get_wallet_balance_transfer',
		type: 'GET',
		dataType: 'JSON',
		data: {type:type}
	})
	.done(function(res) {
		$("#_transfer_amnt").val(res.data.balance)
		$("#_receive_transfer").val(res.data.balance)
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		console.log("error");
	})
})

$('#_select_wallet').on('change', function() {
	type = $(this).val();
	
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/wallet/_get_wallet_balance_transfer',
		type: 'GET',
		dataType: 'JSON',
		data: {type:type}
	})
	.done(function(res) {
		$("#_transfer_amnt").val(res.data.balance)
		$("#_receive_transfer").val(res.data.balance)
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		console.log("error");
	})
})



$("#_transfer_amnt").on('keyup', function(){
	amnt = $(this).val();
	$("#_receive_transfer").val(amnt)
})

$("#_transfer_amnt_form").on('submit', function(e){
	e.preventDefault();
	trans_amnt = $('#_transfer_amnt').val();
	wallet_type = $('#_select_wallet').val();
	if (!trans_amnt || trans_amnt == '' || trans_amnt == 0) {
		$.NotificationApp.send("Oh, snap!","Amount should not be blank or zero!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}
	if (!wallet_type || wallet_type == '') {
		$.NotificationApp.send("Oh, snap!","Please Select a wallet!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/wallet/_transfer_wallet_balance',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
		statusCode: {
		403: function() {
			  	$.NotificationApp.send("Oh Snap!","Something went wrong! Refresh this page and try again!","top-right","rgba(0,0,0,0.2)","error");
			}
		}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			$("#tranfer_bal_modal").modal('hide');
			$('#form_input input' )
			getWalletActivity(1);
			getIndirectWalletBalance();
			getWalletBalance();
		}
		else if(res.data.status == 'failed') {
			$.NotificationApp.send("Oh, snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		newCsrfData();
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		console.log("error");
		$("#loader").attr('hidden','hidden');
	})

})