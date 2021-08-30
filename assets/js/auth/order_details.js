var base_url;
var page; 
var ref_no;

if (page == 'order_details') {
	getOrderdetails(ref_no);
}

function getOrderdetails(ref_no) {
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/order/_get_details',
		type: 'GET',
		dataType: 'JSON',
		data: {ref_no:ref_no}
	})
	.done(function(res) {
		order_data = '';
		cart_string = '';
		cart = res.data.order_cart;
		payment_mode = '';
		process_line_num = '0';
		order_status_label = '';
		order_status = '';
		stat_icon = '';
		update_status = '';
		order_status = res.data.status;
		track_btn = '';
		track_url = '';
		tracking_number = '';

		if (order_status == 'created') {
			order_status_label = 'info';
			stat_icon = 'uil-shopping-cart-alt';
			update_status = 'packed';
		}
		else if (order_status == 'delivered') {
			order_status_label = 'success';
			stat_icon = 'uil-check'
		}
		else if (order_status == 'cancelled') {
			order_status_label = 'danger';
			stat_icon = 'mdi mdi-cancel'
		}
		else if (order_status == 'packed') {
			order_status_label = 'info';
			stat_icon = 'uil-box'
			update_status = 'shipped'
		}
		else if (order_status == 'shipped') {
			order_status_label = 'warning';
			stat_icon = 'mdi mdi-truck-fast-outline'
			update_status = 'delivered'
		}

		for(var x in res.data.ship_order_track ){
			if (res.data.ship_order_track[x].activity == 'Order Placed') {
				console.log(res.data.ship_order_track.activity )
				$("#order_placed_timeline").addClass('current');
				$("#order_placed_timeline span").attr('title', res.data.ship_order_track[x].date);
				$("#_order_process_line").css('width','1%');
			}

			else if (res.data.ship_order_track[x].activity == 'Packed') {
				console.log(res.data.ship_order_track.activity )
				$("#order_placed_timeline").removeClass('current');
				$("#order_packed_timeline").addClass('current');
				$("#order_packed_timeline span").attr('title', res.data.ship_order_track[x].date);
				$("#_order_process_line").css('width','33%');
			}

			else if (res.data.ship_order_track[x].activity == 'Shipped') {
				console.log(res.data.ship_order_track.activity )
				$("#order_placed_timeline").removeClass('current');
				$("#order_packed_timeline").removeClass('current');
				$("#order_shipped_timeline").addClass('current');
				$("#order_shipped_timeline span").attr('title', res.data.ship_order_track[x].date);
				$("#_order_process_line").css('width','66%');
			}

			else if (res.data.ship_order_track[x].activity == 'Delivered') {
				console.log(res.data.ship_order_track.activity )
				$("#order_placed_timeline").removeClass('current');
				$("#order_packed_timeline").removeClass('current');
				$("#order_shipped_timeline").removeClass('current');
				$("#order_delivered_timeline").addClass('current');
				$("#order_delivered_timeline span").attr('title', res.data.ship_order_track[x].date);
				$("#_order_process_line").css('width','100%');
			}
		}

		if (res.data.status == 'created') {
			$("#order_placed_timeline").text();
		}

		if (cart.length > 0) {
			for(var i in cart) {
				cart_string +='<tr>'
                        +'<td><a href="'+cart[i].product_url+'" target="_blank" rel="noopener"><img src="'+cart[i].product_image+'" height="25" class="rounded"> '+cart[i].product_name+'</a></td>'
                        +'<td>'+cart[i].qty+'</td>'
                        +'<td>₱ '+cart[i].price+'</td>'
                        +'<td>₱ '+cart[i].total+'</td>'
                +'</tr>'
			}
			$("#_view_ordered_item_tbl").html(cart_string)
		}

		if (res.data.payment_method == 'Cash On Delivery') {
			payment_mode = 'COD';
		}
		else{
			payment_mode = 'NON-COD'
		}


		tracking_num = res.data.ship_courier.tracking_number;
		if (tracking_num === null) {
			tracking_number = '<span class="badge badge-warning-lighten pointer-cursor font-14">Processing... </span>';
		}
		else{
			tracking_number = '<span class="badge badge-success-lighten pointer-cursor font-14">'+res.data.ship_courier.tracking_number+' <i class="uil-external-link-alt "></i></span>';
		}

		if (res.data.ship_courier.courier == 'J&T Express') {
			track_base_url = 'https://www.jtexpress.ph/index/query/gzquery.html';
			track_url = 'https://www.jtexpress.ph/index/router/index.html';
			track_btn = '<span class="badge badge-success-lighten pointer-cursor font-14" onclick="trackOrder(\''+track_url+'\',\''+res.data.ship_courier.tracking_number+'\',\''+track_base_url+'\')">'+tracking_number+' <i class="uil-external-link-alt "></i></span>';
		}
		else{
			track_btn = '';
		}

		$("#_order_status").html('<span class="badge badge-'+order_status_label+'-lighten text-capitalize font-14 rounded fw-700 padding-right-10 padding-left-10">'+order_status+' <i class="'+stat_icon+'"></i></span>')
		$("#_view_payment_mode").text(payment_mode);
		$("#_view_ref_no").text('#'+res.data.reference_no);
		$("#_view_grand_total").text('₱ '+res.data.order_amount.grand_total);
		$("#_view_shipping_fee").text('₱ '+res.data.order_amount.shipping);
		$("#_view_total").text('₱ '+res.data.order_amount.total);

		$("#_view_ship_name").text(res.data.shipping_info.full_name);
		$("#_view_ship_full_address").text(res.data.shipping_info.address);
		$("#_view_ship_email").text(res.data.shipping_info.email_address);
		$("#_view_ship_phone").text(res.data.shipping_info.phone);

		$("#_view_bill_name").text(res.data.billing_info.full_name);
		$("#_view_bill_full_address").text(res.data.billing_info.address);
		$("#_view_bill_email").text(res.data.billing_info.email_address);
		$("#_view_bill_phone").text(res.data.billing_info.phone);

		$("#_view_ship_courier").text(res.data.ship_courier.courier)
		$("#_view_shipping_order_id").html(tracking_number)
		
		$("#_view_payment_method").text(res.data.payment_method);
		$("#_order_placed").text(res.data.order_created)
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		$("#loader").attr('hidden','hidden');
	})
}
// function trackOrder(track_url, t_num){
// 	data = [];
// 	billcode = '';
// 	lang = '';
// 	source = '';
// 	$(data).serializeArray()
// 	// data = JSON.stringify({ billcode: t_num, lang: 'en', source:'3'})

// 	data[billcode] = t_num;
// 	data[lang] = "en";
// 	data[source] = "3";

// 	method = "app.findTrack";
	

// 	pId	= "testtesttest";
// 	pst = "712d5af47cd24adf54fe39ebc4ed0aea";

// 	$.ajax({
// 		url: track_url,
// 		type: 'POST',
// 		dataType: 'JSON',
// 		data: {
// 			method:method,
// 			data:data,
// 			pId:pId,
// 			pst:pst
// 		}
// 	})
// 	.done(function(res) {
// 	})
// }
function trackOrder(track_url, t_num, track_base_url){
	$("#loader").removeAttr('hidden');
	webtrack_ = window.open(track_base_url)
	webtrack_.moveTo(500, 80);

	lang = "en";
	source= "3";
	method = "app.findTrack";
	pId	= "testtesttest";
	pst = "712d5af47cd24adf54fe39ebc4ed0aea";
	data = 'method='+method+'&pId='+pId+'&pst='+pst+'&data[billcode]='+t_num+'&data[lang]='+lang+'&data[source]='+source;
	

	$.ajax({
		url: track_url,
		type: 'POST',
		dataType: 'JSON',
		data: data,
	})
	.done(function(res) {
		$('#tracking_details').html(res.data);
		$("#order_tracking_details_modal").modal('show');
		$("#loader").attr('hidden','hidden');
	})
	webtrack_.close();
	$("#loader").attr('hidden','hidden');
}