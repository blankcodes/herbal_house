if (page == 'profit_sharing') {
	getProfitShares();
}

function getProfitShares() {
	$.ajax({
		url: base_url+'api/v1/company/_get_total_profit_shares',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		$("#_total_profit_share").text('₱ '+res.data.amount)
		setTimeout(function() {
			getProfitShares()
		}, 3000);
	})
}