var base_url;
var product_pub_id;
var page;
var p_qty;

getCartData();
if (page == 'shopping_cart') {
	getShoppingCartData();
}
else if(page == 'shop_product') {
	recommendedProducts(product_pub_id, nonce)
}


$("#_add_to_cart").on('click', function(e) {
	e.preventDefault();
	$(this).attr('disabled','disabled');
	var qty = $('#_qty').val();
	if (qty == 0) {
		$.NotificationApp.send("Oh Snap!","Quantity should be higher than zero!","top-right","rgba(0,0,0,0.2)","warning");
		$('#_qty').val('1')
		$("#_add_to_cart").removeAttr('disabled');
		return false;
	}
	if (parseInt(qty) > parseInt(p_qty)) {
		$.NotificationApp.send("Oh Snap!","You can only add a maximum of "+p_qty+" item of this product!","top-right","rgba(0,0,0,0.2)","warning");
		$('#_qty').val(p_qty);
		$("#_add_to_cart").removeAttr('disabled');
		return false;
	}
	$.ajax({
		url: base_url+'api/v1/product/_add_to_cart',type: 'POST',dataType: 'JSON', data: {product_pub_id:product_pub_id,qty:qty},
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			getCartData();
		}
		$("#_add_to_cart").removeAttr('disabled');
	})
})

$("#_add_to_mobile_cart").on('click', function(e) {
	e.preventDefault();
	$(this).attr('disabled','disabled');
	var qty = $('#_qty_').val();
	if (qty == 0) {
		$.NotificationApp.send("Oh Snap!","Quantity should be higher than zero!","top-right","rgba(0,0,0,0.2)","warning");
		$('#_qty_').val('1')
		$("#_add_to_mobile_cart").removeAttr('disabled');
		return false;
	}
	if (parseInt(qty) > parseInt(p_qty)) {
		$.NotificationApp.send("Oh Snap!","You only add a maximum of "+p_qty+" item of this product!","top-right","rgba(0,0,0,0.2)","warning");
		$('#_qty_').val(p_qty);
		$("#_add_to_mobile_cart").removeAttr('disabled');
		return false;
	}
	$.ajax({
		url: base_url+'api/v1/product/_add_to_cart',type: 'POST',dataType: 'JSON', data: {product_pub_id:product_pub_id,qty:qty},
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			getCartData();
		}
		$("#_add_to_mobile_cart").removeAttr('disabled');
	})
})
$("#_buy_now").on('click', function(e) {
	e.preventDefault();
	$(this).attr('disabled','disabled');
	var qty = $('#_qty').val();
	if (qty == 0) {
		$.NotificationApp.send("Oh Snap!","Quantity should be higher than zero!","top-right","rgba(0,0,0,0.2)","warning");
		$("#_buy_now").removeAttr('disabled');
		return false;
	}
	if (parseInt(qty) > parseInt(p_qty)) {
		$.NotificationApp.send("Oh Snap!","You only add a maximum of "+p_qty+" item of this product!","top-right","rgba(0,0,0,0.2)","warning");
		$('#_qty').val(p_qty);
		$("#_buy_now").removeAttr('disabled');
		return false;
	}
	$.ajax({
		url: base_url+'api/v1/product/_add_to_cart',type: 'POST',dataType: 'JSON', data: {product_pub_id:product_pub_id,qty:qty},
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			window.location.href=base_url+'cart';
		}
		$("#_buy_now").removeAttr('disabled');
	})
	.fail(function(){
		$("#_buy_now").removeAttr('disabled');
	})
})
function addToCart(p_pub_id) {
	$(".mobile-add-to-cart-btn").attr('disabled','disabled');
	qty = 1;
	$.ajax({
		url: base_url+'api/v1/product/_add_to_cart',type: 'POST',dataType: 'JSON', data: {product_pub_id:p_pub_id, qty:qty},
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			// $.toast({
			//     heading: '',
			//     text: res.data.message,
			//     showHideTransition: 'slide',
			//     position: 'top-right', 
   //  			bgColor: '#05cb62',
   //  			loader: false, 
			// })
			getCartData();
		}
		$("#_add_to_cart").removeAttr('disabled');
	})
	.always(function() {
		$(".mobile-add-to-cart-btn").removeAttr('disabled');
	})
}
function getCartData(){
	fetch(base_url+'api/v1/cart/_get_cart_data', {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		string = '';
		if (res.data.length > 0) {
			for(var i in res.data) {
				string+=' <a href="'+res.data[i].product_url+'" class="dropdown-item notify-item">'
                    +'<div class="notify-icon">'
                        +'<img src="'+res.data[i].product_image+'" height="36" alt="product img" />'
                    +'</div>'
                    +'<p class="notify-details">'+res.data[i].product_name+''
                   +' </p>'

                   +'<p class="notify-details text-success fw-700 font-16">₱ '+res.data[i].price+''
                   +' </p>'
                +'</a>'
			}
			$("#cart_span").addClass('bounce');
		}
		else{
			string= '<div class="text-center mb-2"><i class="uil-sad-squint"></i> Your cart is empty!</div>';
			$("#cart_span").removeClass('bounce');
		}
		$("#cart_panel").html(string)
		$("#cart_panel_home_mobile").html(string)
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
function getShoppingCartData(){
	$("#_shopping_cart_tbl").html('<tr class="text-center mt-1 mb-3"><td colspan="4">Getting your cart...</td></tr>');
	$(".mobile_cart_wrapper").html('<div class="text-center mb-3">Getting your cart...</div>');
	$.ajax({
		url: base_url+'api/v1/cart/_get_shopping_cart_data', type: 'GET', dataType: 'JSON',
	})
	.done(function(res) {
		string = '';
		mob_string = '';
		
		$("#cart_count").text(res.data.count+ ' items')
		if (parseInt(res.data.count) > 0) {
			for(var i in res.data.cart) {
				string+='<tr>'
                        +'<td>'
                           	+'<a href="'+res.data.cart[i].product_url+'" class="text-body"><img src="'+res.data.cart[i].product_image+'" alt="contact-img" title="contact-img" class="rounded me-3" height="54" /></a>'
                            +'<p class="m-0 d-inline-block align-middle font-15" style="width: 260px;">'
                                +'<a href="'+res.data.cart[i].product_url+'" class="text-body cart-product-title">'+res.data.cart[i].product_name+'</a>'
                                +'</small>'
                            +'</p>'
                        +'</td>'
                        +'<td>₱ '+res.data.cart[i].price+'</td>'
                       	+'<td><input onchange="updateCartQty(\''+res.data.cart[i].c_pub_id+'\',\''+res.data.cart[i].p_qty+'\')" id="__qty_'+res.data.cart[i].c_pub_id+'" type="number" min="1" value="'+res.data.cart[i].qty+'" class="form-control" placeholder="Qty" style="width: 90px;"></td>'
                       	+'<td>₱ '+res.data.cart[i].total_price+'</td>'
                        +'<td><a href="#delete_cart" onclick="deleteCart(\''+res.data.cart[i].c_pub_id+'\')" class="action-icon"> <i class="mdi mdi-delete"></i></a></td>'
                    +'</tr>'
                $("#_sub_total").text('₱ '+res.data.subtotal);
                $("#_total").text('₱ '+res.data.subtotal);

			}

			for(var i in res.data.cart) {
				mob_string += '<div class="col-md-12 col-12">'
                        +'<div class="card product-cards">'
                            +'<div class="row">'
                                +'<div class="col-4 product-cards-img">'
                                	+'<a href="'+res.data.cart[i].product_url+'">'
                                    	+'<img src="'+res.data.cart[i].product_image+'" class="card-img-top" alt="'+res.data.cart[i].product_name+'">'
                                    +'</a>'
                                +'</div>' 
                                +'<div class="card-body col-8">'
                                    +'<a href="'+res.data.cart[i].product_url+'">'
                                        +'<h2 class="card-title text-secondary fw-500">'+res.data.cart[i].product_name+'<br>'
                                        +'</h2>'
                                    +'</a>'
                                    +'<h3 class=" text-success cart-page-product-price fw-600">₱ '+res.data.cart[i].price+' <input onchange="updateCartQtyMobile(\''+res.data.cart[i].c_pub_id+'\',\''+res.data.cart[i].p_qty+'\')" id="_qty_'+res.data.cart[i].c_pub_id+'" type="number" min="1" value="'+res.data.cart[i].qty+'" class="form-control mobile-qty-cart" placeholder="Qty" style="width: 60px;"></h3>'
                                	+'<a href="#remove_cart" class="mt-1 font-13 text-primary fw-500"  onclick="deleteCart(\''+res.data.cart[i].c_pub_id+'\')"><i class=" dripicons-trash "></i> Remove</a>'
                                +'</div> '
                            +'</div>'
                       +'</div> '
                    +'</div>'

                $("#_sub_total_mob").text('₱ '+res.data.subtotal);
                $("#_total_mob").text('₱ '+res.data.subtotal);
            }
		}
		else{
			string = '<tr class="text-center mt-3"><td colspan="4"><img width="200" class="mt-3" src="'+base_url+'assets/images/empty_cart.webp" alt="Empty Cart"><br><h4 class="mt-4">You Cart is Empty!</h4><br><button onclick="_accessPage(\''+base_url+'#shop_now\')" class="btn btn-success btn-rounded">Shop Now</button></td></tr>'
			mob_string = '<div class="text-center mb-5 mt-3"><tr class="text-center mt-1"><td colspan="4"><img width="250" src="'+base_url+'assets/images/empty_cart.webp" alt="Empty Cart"><br><h4 class="mt-4">You Cart is Empty!</h4><br><button onclick="_accessPage(\''+base_url+'#shop_now\')" class="btn btn-success btn-rounded">Shop Now</button></td></tr></div>'

			$("#_sub_total_mob").text('₱ 0.00');
            $("#_total_mob").text('₱ 0.00');

            $("#_sub_total").text('₱ 0.00');
            $("#_total").text('₱ 0.00');
		}

		$("#_shopping_cart_tbl").html(string);
		$(".mobile_cart_wrapper").html(mob_string);
	})
	.fail(function() {
		$("#_shopping_cart_tbl").html('<tr class="text-center mt-1"><td colspan="4"><img width="200" class="mt-3" src="'+base_url+'assets/images/empty_cart.webp" alt="Empty Cart"><br><h4 class="mt-4">You Cart is Empty!</h4><br><button onclick="_accessPage(\''+base_url+'#shop_now\')" class="btn btn-success btn-rounded">Shop Now</button></td></tr>');
		$(".mobile_cart_wrapper").html('<div class="text-center mb-5 mt-3"><tr class="text-center mt-1"><td colspan="4"><img width="250" src="'+base_url+'assets/images/empty_cart.webp" alt="Empty Cart"><br><h4 class="mt-4">You Cart is Empty!</h4><br><button onclick="_accessPage(\''+base_url+'#shop_now\')" class="btn btn-success btn-rounded">Shop Now</button></td></tr></div>');
		
		$("#_sub_total_mob").text('₱ 0.00');
        $("#_total_mob").text('₱ 0.00');
        $("#_sub_total").text('₱ 0.00');
        $("#_total").text('₱ 0.00');
	})
}

function deleteCart(c_pub_id) {
	swal({
		title: "Remove cart?",
	  	text: "Are you sure to remove this item in your cart?",
	  	icon: "warning",
	  	buttons: true,
	})
	.then((res) => {
		if (res) {
	    	$.ajax({
	    		url: base_url+'api/v1/cart/_delete_cart',
	    		type: 'POST',
	    		dataType: 'JSON',
	    		data: {c_pub_id:c_pub_id},
	    	})
	    	.done(function(res) {
	    		if (res.data.status == 'success') {
	    			$.NotificationApp.send(
	    				"Success!",
	    				res.data.message,
	    				"top-right",
	    				"rgba(0,0,0,0.2)", "success"
	    			);
					getShoppingCartData();
					getCartData();
	    		}
	    	})
	    	.fail(function() {
	    		console.log("error");
	    	})
	  	}
	});	
}
function updateCartQty(c_pub_id, p_qty) {
	var qty = $('#__qty_'+c_pub_id).val();

	if (parseInt(qty) > parseInt(p_qty)) {
		$.NotificationApp.send("Oh Snap!","You can only add a maximum of "+p_qty+" item of this product!","top-right","rgba(0,0,0,0.2)","warning");
		$('#__qty_'+c_pub_id).val(p_qty);
		$("#_add_to_cart").removeAttr('disabled');
		return false;
	}

	$.ajax({
		url: base_url+'api/v1/cart/_update_qty',
		type: 'POST',
		dataType: 'JSON',
		data: {c_pub_id:c_pub_id, qty:qty},
	})
	.done(function(res) {
		if (res.data.status == 'success') {
	    	$.NotificationApp.send(
	    		"Success!",
	    		res.data.message,
	    		"top-right",
	    		"rgba(0,0,0,0.2)", "success"
	    	);
	    }
	    else{
	    	$.NotificationApp.send(
	    		"Oh, snap!",
	    		res.data.message,
	    		"top-right",
	    		"rgba(0,0,0,0.2)", "warning"
	    	);
	    }
	    getShoppingCartData();
	    getCartData();
	})
	.fail(function() {
		console.log("error");
	})
}
function updateCartQtyMobile(c_pub_id, p_qty) {
	var qty = $('#_qty_'+c_pub_id).val();

	if (parseInt(qty) > parseInt(p_qty)) {
		$.NotificationApp.send("Oh Snap!","You can only add a maximum of "+p_qty+" item of this product!","top-right","rgba(0,0,0,0.2)","warning");
		$('#_qty_'+c_pub_id).val(p_qty);
		$("#_add_to_cart").removeAttr('disabled');
		return false;
	}

	$.ajax({
		url: base_url+'api/v1/cart/_update_qty',
		type: 'POST',
		dataType: 'JSON',
		data: {c_pub_id:c_pub_id, qty:qty},
	})
	.done(function(res) {
		if (res.data.status == 'success') {
	    	$.NotificationApp.send(
	    		"Success!",
	    		res.data.message,
	    		"top-right",
	    		"rgba(0,0,0,0.2)", "success"
	    	);
	    }
	    else{
	    	$.NotificationApp.send(
	    		"Oh, snap!",
	    		res.data.message,
	    		"top-right",
	    		"rgba(0,0,0,0.2)", "warning"
	    	);
	    }
	    getShoppingCartData();
	    getCartData();
	})
	.fail(function() {
		console.log("error");
	})
}
function recommendedProducts(p_pub_id, nonce) {
	qty = 1;
	$.ajax({
		url: base_url+'api/v1/product/_get_recommended_products',type: 'GET',dataType: 'JSON', data: {p_pub_id:p_pub_id, nonce:nonce},
	})
	.done(function(res) {
		string = '';
		referrer = '';
		if (res.data.products.length > 0) {
			products = res.data.products;
			for(var i in products) {
				if (res.data.referrer == 'TRUE') {
					referrer = '<button href="#add_to_cart" class="btn btn-success rounded btn-sm mt-1 prod-cat-btn" onclick="addToCart(\''+products[i].p_pub_id+'\')"><i class="uil-shopping-cart-alt me-1"></i> Add to cart</button>'
				}
				string += '<div class="col-md-3 col-lg-3 col-6">'
                       +'<div class="card">'
                           	+'<a href="#'+products[i].product_name+'" onclick="_accessPage(\''+products[i].url+'\')"><img src="'+products[i].product_image+'" class="card-img-top" alt="'+products[i].product_name+'"></a>'
                           	+'<div class="card-body">'
                                +'<a href="#'+products[i].product_name+'" onclick="_accessPage(\''+products[i].url+'\')"><h5 class="card-title text-secondary">'+products[i].product_name+'<br>'
                                	+'<small class="product-category">'+products[i].category+'</small></h5>'
                                +'</a>'
                                +'<h3 class="card-title text-success">₱ '+products[i].price+'</h3>'
                                +referrer
                            +'</div> '
                        +'</div> '
                +'</div> '
			}
			$("#products_wrapper_").html(string);
		}
	})
}

$("#search_product_form").on('submit', function(e) {
	keyword = $("#top-search").val();
	if (!keyword || keyword == '' || keyword == ' ') {
		$.NotificationApp.send("Oh Snap!","Type a keyword to search products!","top-right","rgba(0,0,0,0.2)","warning");
		return false;
	}
	$("#search_product_form button").attr('disabled','disabled').text('Searching...');
	string = '';
	e.preventDefault();
	$.ajax({
		url: base_url+'api/v1/product/_search',
		type: 'GET',
		dataType: 'JSON',
		data: $(this).serialize(),
	})
	.done(function(res) {
		if (parseInt(res.data.count) > 0) {
			$("#search_fund_title").html('Found <span class="text-success">'+res.data.count+'</span> results')
			for(var i in res.data.result) {
				string+='<a href="'+res.data.result[i].product_url+'" class="dropdown-item notify-item">'
                        +'<span id="product_name_url"><img src="'+res.data.result[i].product_image+'" height="20" class="rounded">&nbsp; '+res.data.result[i].product_name+'</span>'
                    +'</a>'
			}
		}
		else{
			$("#search_fund_title").html('Found <span class="text-success">0</span> results')
			string = '<div><a href="#result" class="dropdown-item notify-item"><span id="product_name_url"></span></a></div>'
		}
		$("#_product_search_result").html(string);
		$("#search_product_form button").removeAttr('disabled').text('Search');
		$("#_search_dropdown").removeAttr('hidden').addClass('d-block');
	})
	.fail(function() {
		console.log("error");
		$("#_search_dropdown").removeAttr('hidden').addClass('d-block');
	})
})
$("#top-search").on('focusin', function(){
	$("#search_fund_title").html('<div class="col-12">Start searching...</div>')
	$("#_search_dropdown").removeAttr('hidden').addClass('d-block')
	$('#_product_search_result').html('')
})
// $("#top-search").on('focusout', function(){
// 	$("#search_fund_title").html('<div class="col-12">Start searching...</div>')
// 	$("#_search_dropdown").attr('hidden','hidden').removeClass('d-block')
// 	$('#_product_search_result').html('')
// })
$("#_close_search_wrapper").on('click', function () {
	$("#search_fund_title").html('<div class="col-12">Start searching...</div>')
	$("#_search_dropdown").attr('hidden','hidden').removeClass('d-block')
	$('#_product_search_result').html('')
})
$("#_mobile_search_product").on('focusin', function(){
	$("#search_result_panel").removeAttr('hidden');
	$("#search_header__").text('Start Searching...')
	$('#_search_result_wrapper').html('')
})

// $("#_mobile_search_product").on('focusout', function(){
// 	$("#search_result_panel").attr('hidden','hidden');
// 	$("#search_header__").text('Start Searching...')
// 	$('#_search_result_wrapper').html('')
// })

if (screen.width <= 768) {
	if (page == 'index') {
		window.addEventListener('click', function(e){   
		  	if (!document.getElementById('_mobile_search_product').contains(e.target)){
				$("#search_result_panel").attr('hidden','hidden');
		  	}
		});
	}
}

$("#_mobile_search_product_form").on('submit', function(e) {
	keyword = $('#_mobile_search_product').val();
	if (!keyword || keyword == '') {
		return false;
	}
	string = '';
	e.preventDefault();
	$.ajax({
		url: base_url+'api/v1/product/_search',
		type: 'GET',
		dataType: 'JSON',
		data: $(this).serialize(),
	})
	.done(function(res) {
		if (res.data.count > 0) {
			$("#search_header__").html('Found <span class="text-success">'+res.data.count+'</span> results')
			for(var i in res.data.result) {
				string+='<a href="'+res.data.result[i].product_url+'" class="dropdown-item notify-item">'
                        +'<span id="product_name_url"><img src="'+res.data.result[i].product_image+'" height="20" class="rounded">&nbsp; '+res.data.result[i].product_name+'</span>'
                    +'</a>'
			}
		}
		else{
			$("#search_header__").html('Found <span class="text-success">0</span> results')
			string = '<div><a href="#result" class="dropdown-item notify-item"><span></span></a></div>'
		}
		$("#_search_result_wrapper").html(string);
	})
	.fail(function() {
		console.log("error");
	})
})
function openProductImg() {
	img = $("#prod_shp_img").attr('src');
	img = $("#product_image_details").attr('src');
	alt = $("#prod_shp_img").attr('alt');

	$("#prod_modal_img").html('<img src="'+img+'" class="rounded img-fluid" alt="'+alt+'">')
	
	$("#open_product_img").modal('toggle');
}	