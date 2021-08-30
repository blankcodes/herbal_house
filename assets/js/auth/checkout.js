var base_url;
var page;

if (page == 'checkout') {
	getShoppingCartData();
	getUserBillingInfo();
	getShippingInfo()
	getPaymentOptions();
}
function getShoppingCartData(){
	$("#_order_summary").html('<tr class="text-center mt-1"><td colspan="2">Getting your cart.!</td></tr>');
	$.ajax({
		url: base_url+'api/v1/cart/_get_shopping_cart_data', type: 'GET', dataType: 'JSON',
	})
	.done(function(res) {
		string = '';
		price_details = '<tr class="">'
                    +'<td>'
                       	+'<h6 class="m-0">Sub Total:</h6></td>'
      	            	+'<td class="text-end" width=150">₱ '+res.data.subtotal+'</td>'
                   +'</tr>'
                   +'<tr class="">'
                        +'<td><h6 class="m-0">Shipping:</h6></td>'
                        +'<td class="text-end" width=150">₱ '+res.data.shipping_charge+'</td>'
                    +'</tr>'
                    +'<tr class="">'
                        +'<td>'
                           +'<h5 class="m-0">Total:</h5>'
                        +'</td>'
                        +'<td width="200" class="text-end font-17 fw-700 text-success" style="font-weight: 700 !important;">₱ '+res.data.total+'</td>'
         		+'</tr>'

		if (res.data.cart.length > 0) {
			for(var i in res.data.cart) {
				string+='<tr>'
                    	+'<td width="400">'
                        	+'<img src="'+res.data.cart[i].product_image+'" alt="contact-img" title="contact-img" class="rounded me-2" height="35" />'
                        	+'<p class="m-0 d-inline-block align-middle">'
                            	+'<a href="'+res.data.cart[i].product_url+'"class="text-body fw-semibold">'+res.data.cart[i].product_name+'</a>'
                            	+'<br>'
                            	+'<small>'+res.data.cart[i].qty+' x ₱ '+res.data.cart[i].price+'</small>'
                        	+'</p>'
                    	+'</td>'
                    	+'<td class="text-end">₱ '+res.data.cart[i].total_price+'</td>'
                	+'</tr>'
                $("#_grand_total").text('₱ '+res.data.grand_total);
                $("#_total").text('₱ '+res.data.total);
			}
		}
		else{
			string= '<tr class="text-center mt-1"><td colspan="4"><i class="uil-sad-squint"></i> Your cart is empty!</td></tr>'
		}
		$("#_billing_order_summary").html(string)
		$("#_shipping_order_summary").html(string)
		$("#_payment_order_summary").html(string)

		$("#_billing_order_summary").append(price_details)
		$("#_shipping_order_summary").append(price_details)
		$("#_payment_order_summary").append(price_details)
	})
	.fail(function() {
		console.log("error");
	})
}
$("#_billing_info_form").on('submit', function(e) {
	$("#_proceed_to_shipping_btn").attr('disabled','disabled');
	$("#loader").removeAttr('hidden');
	e.preventDefault();
	$.ajax({
		url: base_url+'api/v1/checkout/_add_billing_info',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
		statusCode: {
			403: function() {
				$.NotificationApp.send("Oh Snap!","Something went wrong! Please try again!","top-right","rgba(0,0,0,0.2)","error");
				newCsrfData();
			}
		}
	})
	.done(function(res) {
		if (res.data.status == 'success' || res.data.status == 'already_exist') {
			$("#_shipping_info_tab").addClass('active');
			$("#shipping-information").addClass('active');

			$("#_billing_info_tab").removeClass('active');
			$("#billing-information").removeClass('active');
			newCsrfData();
			getShippingInfo();
			getUserBillingInfo();
		}
		$("#_proceed_to_shipping_btn").removeAttr('disabled');
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		console.log("error");
		$("#_proceed_to_shipping_btn").removeAttr('disabled');
		$("#loader").attr('hidden','hidden');
	})
})
function getUserBillingInfo() {
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/checkout/_get_billing_info',
		type: 'GET',
		dataType: 'JSON',
		data: $(this).serialize(),
		
	})
	.done(function(res) {
		if (res.data !== null) {
			$("#_shipping_info_tab").addClass('active');
			$("#shipping-information").addClass('active');

			$("#_billing_info_tab").removeClass('active');
			$("#billing-information").removeClass('active');
			$("#_payment_info_tab").removeClass('active');
			$("#payment-information").removeClass('active');


			$("#billing_first_name").val(res.data.fname)
			$("#billing_last_name").val(res.data.lname)
			$("#billing_email_address").val(res.data.email_address)
			$("#billing_phone").val(res.data.phone_number)
			$("#billing_address").val(res.data.full_address)
			$("#billing_town_city").val(res.data.city)
			$("#billing_state").val(res.data.state)
			$("#billing_zip_postal").val(res.data.zip_code)
			$("#billing_country").html('<option selected value="'+res.data.country+'">'+res.data.country+'</option>')
			newCsrfData()
		}
		$("#loader").attr('hidden', 'hidden');
	})
	.fail(function() {
		console.log("error");
	})
}
$("#_shipping_info_form").on('submit', function(e) {
	$("#_cont_to_payment_btn").attr('disabled','disabled');
	$("#loader").removeAttr('hidden');
	e.preventDefault();
	$.ajax({
		url: base_url+'api/v1/checkout/_add_shipping_info',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
		statusCode: {
			403: function() {
				$.NotificationApp.send("Oh Snap!","Something went wrong! Please try again!","top-right","rgba(0,0,0,0.2)","error");
				newCsrfData();
			}
		}
	})
	.done(function(res) {
		if (res.data.status == 'success' || res.data.status == 'already_exist') {
			$("#_payment_info_tab").addClass('active');
			$("#payment-information").addClass('active');

			$("#_shipping_info_tab").removeClass('active');
			$("#shipping-information").removeClass('active');

			newCsrfData();
		}
		$("#_cont_to_payment_btn").removeAttr('disabled');
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		console.log("error");
		$("#_cont_to_payment_btn").removeAttr('disabled');
		$("#loader").attr('hidden','hidden');
	})
})
function getShippingInfo(){
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/checkout/_get_shipping_info',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		if (res.data !== null) {
			$("#_payment_info_tab").addClass('active');
			$("#payment-information").addClass('active');

			$("#_billing_info_tab").removeClass('active');
			$("#billing-information").removeClass('active');
			$("#_shipping_info_tab").removeClass('active');
			$("#shipping-information").removeClass('active');
			
			$("#shipping_first_name").val(res.data.fname)
			$("#shipping_last_name").val(res.data.lname)
			$("#shipping_email_address").val(res.data.email_address)
			$("#shipping_phone").val(res.data.phone_number)
			$("#shipping_address").val(res.data.full_address)
			$("#shipping_town_city").val(res.data.city)
			$("#shipping_state").val(res.data.state)
			$("#shipping_zip_postal").val(res.data.zip_code)
			$("#shipping_country").html('<option selected value="'+res.data.country+'">'+res.data.country+'</option>')
			newCsrfData()
		}
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		console.log("error");
	})
}

function getPaymentOptions(){
	$.ajax({
		url: base_url+'api/v1/checkout/_get_payment_options',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		string = '';
		if (res.data.length > 0) {
			for(var i in res.data){
				string +='<div class="border p-3 mb-3 rounded">'
	                +'<div class="row">'
	                   	+'<div class="col-sm-8">'
	                       	+'<div class="form-check">'
	                           	+'<input required type="radio" id="_payment_method" name="payment_method" value="'+res.data[i].payment_method+'" class="form-check-input">'
	                           	+'<label class="form-check-label font-16 fw-bold " for="_payment_method">'+res.data[i].payment_method+'</label>'
	                       	+'</div>'
	                       	+'<p class="mb-0 ps-3 pt-1">'+res.data[i].payment_description+'</p>'
	                  	+' </div>'
	                   	+'<div class="col-sm-4 text-sm-end mt-3 mt-sm-0">'
	                       	+'<img src="'+res.data[i].payment_logo+'" height="25" alt="paypal-img">'
	                   	+'</div>'
	               	+'</div>'
	           	+'</div>'
			}
			$("#payment_wrapper").html(string);
		}
	})
	.fail(function() {
		console.log('error')
	})
}
$("#_complete_order_form").on('submit', function(e) {
	$("#loader").removeAttr('hidden');
	$("#_complete_order_btn").attr('disabled','disabled');
	e.preventDefault();

	$.ajax({
		url: base_url+'api/v1/checkout/_place_order',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
		statusCode: {
			403: function() {
				$.NotificationApp.send("Oh Snap!","Refresh the and try again!","top-right","rgba(0,0,0,0.2)","error");
				newCsrfData()
			}
		}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			setTimeout(function(){window.location.href=res.data.order_url}, 3000)
		}
		else if(res.data.status == 'no_bill_info' || res.data.status == 'no_ship_info') {
			$("#loader").attr('hidden','hidden');
			$.NotificationApp.send("Oh Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","warning");
		}
		else if(res.data.status == 'failed'){
			$("#loader").attr('hidden','hidden');
			$.NotificationApp.send("Oh Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","warning");
		}
		else{
			$("#loader").attr('hidden','hidden');
			$.NotificationApp.send("Oh Snap!",res.data.message.payment_method,"top-right","rgba(0,0,0,0.2)","warning");
		}
		$("#_complete_order_btn").removeAttr('disabled');
		$('html, body').animate({
			scrollTop: 0
		}, 800);
		newCsrfData()

	})
	.fail(function(){
		$("#_complete_order_btn").removeAttr('disabled');
		$("#loader").attr('hidden','hidden');
	})
})