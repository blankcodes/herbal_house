var base_url;
var page;
var ref_no;

if (page == 'admin_orders') {
	showAllOrders(1);
}
else if (page == 'order_details_admin') {
	getOrderdetails(ref_no);
}

$('#order_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showAllOrders(page_no);
});

function showAllOrders(page){
	$("#orders_tbl").html('<tr class="text-center"><td colspan="9">Getting Orders...</td></tr>');
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

			for(var i in res.result) {
				status = res.result[i].status;
				payment_status = res.result[i].payment_status;

				if (status == 'created') {
					order_status_label = 'info';
				}
				else if (status == 'delivered') {
					order_status_label = 'success';
				}
				else if (status == 'cancelled') {
					order_status_label = 'danger';
				}
				else if (status == 'packed') {
					order_status_label = 'primary';
				}
				else if (status == 'shipped') {
					order_status_label = 'warning';
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
					referrer = '<span class="badge badge-warning-lighten font-12">None</span>';
				}
				else{
					referrer = '<span class="badge badge-primary-lighten font-12">'+res.result[i].referrer +'</span>';
				}

				string +='<tr>'
                        +'<td><a target="_blank" href="'+base_url+'order/'+res.result[i].reference_no+'" class="text-body fw-bold cursor-pointer">#'+res.result[i].reference_no+'</a> </td>'
                        +'<td>'
                        	+'<h5 class="dropdown">'
                                 +'<span onclick="updateOrderStatusModal(\''+res.result[i].reference_no+'\', \''+res.result[i].order_id+'\')" class="badge badge-'+order_status_label+'-lighten font-12 text-capitalize pointer-cursor" ><i class="uil-edit"></i> '+res.result[i].status+' </span>'
                        	+'</h5>'
                        +'</td>'
                        +'<td><a class="badge badge-info-lighten font-12" target="_blank" href="'+res.result[i].member_overview+'">'+res.result[i].member+'</a></td>'
                        +'<td class="text-capitalize fw-600">₱ '+res.result[i].total_revenue+'</td>'
                        +'<td>'+res.result[i].payment_method+'</td>'
                        +'<td><h5><span class="badge '+payment_status_label+' text-capitalize font-12"><i class="mdi mdi-coin"></i> '+res.result[i].payment_status+'</span></h5></td>'
                        +'<td><a target="_blank" href="'+res.result[i].referrer_overview+'">'+referrer+'</a></td>'
                        +'<td>'+res.result[i].created_at+'</small></td>'

                        +'<td width=150>'
                            +'<a target="_blank" rel="noopener" href="'+base_url+'order/details/'+res.result[i].reference_no+'" class="font-12 "> <i class="mdi mdi-clipboard-text-search-outline"></i> Check details  </a>'
                            // +'<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>'
                            // +'<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>'
                       +'</td>'
                    +'</tr>'
			}
		}
		else{
			string = '<tr class="text-center"><td colspan="9">No Orders Found!</td></tr>'
		}
		$('#orders_tbl').html(string)
	})
	.fail(function() {
		$("#orders_tbl").html('<tr class="text-center"><td colspan="9">No Orders Found!</td></tr>');
	})
	.always(function() {
		// $("#orders_tbl").html('<tr class="text-center"><td colspan="7">Loading Products...</td></tr>');
	});
	
}

function getOrderdetails(ref_no) {
	$("#_view_ordered_item_tbl").html('<tr class="text-center"><td colspan="4">Loading items...</td></tr>')
	$("#_event_logs").html('<tr class="text-center"><td colspan="2">Loading event logs...</td></tr>')
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/order/_admin_get_details',
		type: 'GET',
		dataType: 'JSON',
		data: {ref_no:ref_no}
	})
	.done(function(res) {
		order_data = '';
		cart_string = '';
		cart = res.data.order_cart;
		payment_mode = '';
		order_status_label = ''
		order_status = res.data.status
		stat_icon = ''
		update_status = '';
		event_logs = res.data.event_logs;
		event_logs_string = '';

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

		if (event_logs.length > 0) {
			for(var i in event_logs) {
				event_logs_string +='<tr>'
                        +'<td>'+event_logs[i].date+'</td>'
                        +'<td>'+event_logs[i].activity+'</td>'
                +'</tr>'
			}
			$("#_event_logs").html(event_logs_string);
		}

		$("#_update_order_status_btn").attr('onclick','updateOrderStatus(\''+res.data.order_id+'\',\''+update_status+'\')')
		$("#_order_status").html('<span class="badge badge-'+order_status_label+'-lighten text-capitalize font-13 rounded fw-700 padding-right-10 padding-left-10">'+order_status+' <i class="'+stat_icon+'"></i></span>')
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
$("#update_order_status_").on('click', function(){
	order_id = $("#order_id_status").val();
	status = $("#__order_status_select").val();

	if (status == '' || !status) {
		$.NotificationApp.send("Error!","Please select an Order Status!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	if (status == 'shipped') {
		courier = $("#_courier").val();
		tracking_number = $("#_tracking_number").val();

		if (!courier || courier == '') {
			$.NotificationApp.send("Error!","Please select a courier!","top-right","rgba(0,0,0,0.2)","error");
			return false;
		}
		else if (!tracking_number || tracking_number == '') {
			$.NotificationApp.send("Error!","Tracking number is required!","top-right","rgba(0,0,0,0.2)","error");
			return false;
		}
	}
	$("#loader").removeAttr('hidden','hidden');
	$.ajax({
	    url: base_url+'api/v1/order/_update_status',
	    type: 'POST',
	    dataType: 'JSON',
	    data: $("#_order_status_form").serialize(),
	})
	.done(function(res) {
	   	if (res.data.status == 'success') {
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			showAllOrders(1);
			$("#update_order_status_modal").modal('hide')
		}
		else if (res.data.status == 'failed') {
			$.NotificationApp.send("Oh, Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		$("#loader").attr('hidden','hidden');
 	})
	.fail(function() {
	    console.log("error");
	})
})
$("#__order_status_select").on('change', function(){
	status = $("#__order_status_select").val();
	if (status == 'shipped') {
		$("#ship_wrapper").removeAttr('hidden')
		$("#_courier").attr('required','required')
		$("#_tracking_number").attr('required','required')
	}
	else{
		$("#ship_wrapper").attr('hidden','hidden');
		$("#_courier").removeAttr('required')
		$("#_tracking_number").removeAttr('required')

	}
})

function updateOrderStatusModal(reference_no, order_id){
	$("#loader").removeAttr('hidden','hidden');
	$.ajax({
	    url: base_url+'api/v1/order/_get_order_details',
	    type: 'GET',
	    dataType: 'JSON',
	    data: {reference_no:reference_no},
	})
	.done(function(res) {
	   	string = '';
		if (res.data.status == 'created') {
			string +='<option selected disabled="">Choose Order Status</option>'
	            +'<option value="packed">Packed</option>'
	            +'<option value="cancelled">Cancel</option>'
		}
		else if(res.data.status == 'packed'){
			string +='<option selected disabled="">Choose Order Status</option>'
				+'<option value="shipped">Shipped</option>'
	            +'<option value="cancelled">Cancel</option>'
		}
		else if(res.data.status == 'shipped'){
			$("#ship_wrapper").hide();
			string += '<option selected disabled="">Choose Order Status</option>'
				+'<option value="delivered">Delivered</option>'
		}
		else if(res.data.status == 'delivered'){
			string += '<option selected disabled="">Choose Order Status</option>'
				+'<option disabled="">Dispute</option>'
		}
		else if(res.data.status == 'cancelled'){
			string += '<option selected disabled="">Choose Order Status</option>'
				+'<option disabled="">Dispute</option>'
		}
		$("#__order_status_select").html(string)
		$("#order_id_status").val(order_id);
		$("#update_order_status_modal").modal('show');
		$("#loader").attr('hidden','hidden');
 	})
	.fail(function() {
	    console.log("error");
	})
	
}