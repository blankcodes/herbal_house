var base_url;
var page;

getNotifications();

function getNotifications(){
	$.ajax({
		url: base_url+'api/v1/account/_get_notifications', type: 'GET', dataType: 'JSON',
	})
	.done(function(res) {
		string = '';
		if (res.data.length > 0) {
			for(var i in res.data) {
				string+=' <a href="javascript:void(0);" class="dropdown-item notify-item">'
                    +'<div class="notify-icon bg-success">'
                        +'<i class="uil-bell"></i>'
                    +'</div>'
                    +'<p class="notify-details">'+res.data[i].message+''
                        +'<small class="text-muted">'+res.data[i].time+'</small>'
                   +' </p>'
                +'</a>'
			}
			$("#notif_pannel").html(string)
		}
	})
	.fail(function() {
		console.log("error");
	})
}