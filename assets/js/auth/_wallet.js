var base_url;
var page;

if (page == 'wallet') {
	getWalletBalance();
	getWalletActivity(1)
}
$('#_wallet_activity_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    getWalletActivity(page_no);
});
function getWalletBalance() {
	$.ajax({
		url: base_url+'api/v1/wallet/_get_wallet_balance',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		$("#_wallet_balance").text(res.data.balance)
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