var base_url;

function newCsrfData(){
	$.ajax({
		url: base_url+'api/v1/xss/_get_csrf_data',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		$("input[name=csrf_token]").val(res.data.hash)
		$("#csrf_token").val(res.data.hash)
		var csrf_token = res.data.hash;
	})
}