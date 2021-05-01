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
		$("#_view_payment_mode").text(payment_mode);
		$("#_view_ref_no").text('#'+res.data.reference_no);
		$("#_view_grand_total").text('₱ '+res.data.order_amount.grand_total);
		$("#_view_shipping_fee").text('₱ '+res.data.order_amount.shipping);
		$("#_view_total").text('₱ '+res.data.order_amount.total);

		$("#_view_ship_name").text(res.data.billing_info.full_name);
		$("#_view_ship_full_address").text(res.data.billing_info.address);
		$("#_view_ship_email").text(res.data.billing_info.email_address);
		$("#_view_ship_phone").text(res.data.billing_info.phone);

		$("#_view_bill_name").text(res.data.billing_info.full_name);
		$("#_view_bill_full_address").text(res.data.billing_info.address);
		$("#_view_bill_email").text(res.data.billing_info.email_address);
		$("#_view_bill_phone").text(res.data.billing_info.phone);

		$("#_view_ship_courier").text(res.data.ship_courier.courier)
		$("#_view_shipping_order_id").text(res.data.ship_courier.tracking_number)
		
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