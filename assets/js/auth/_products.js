var nonce;

$('#products_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showProductData(page_no, nonce);
});

if (page == 'index') {
	showProductData(1, nonce)
}

function showProductData(page_no, nonce) {
	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/product/_get_products',
		type: 'GET',
		dataType: 'JSON',
        data: {page_no:page_no,nonce:nonce}
	})
	.done(function(res) {
		$('#products_pagination').html(res.pagination);
		mob_string = '';
		string = '';
		if (parseInt(res.count) > 0) {
			for(var i in res.result) {
				string += '<div class="col-md-4 col-lg-3 col-6">'
                       +'<div class="card">'
                           	+'<a href="'+res.result[i].url+'"><img src="'+res.result[i].product_image+'" class="card-img-top" alt="'+res.result[i].product_name+'"></a>'
                           	+'<div class="card-body card-title-div">'
                                +'<a href="'+res.result[i].url+'"><h2 class="card-title text-secondary product-name">'+res.result[i].product_name+'<br>'
                                	+'<small class="product-category">'+res.result[i].category+'</small></h2>'
                                +'</a>'
                                +'<h3 class="card-title text-success">₱ '+res.result[i].price+'</h3>'
                                // +'<button href="#add_to_cart" class="btn btn-success btn-sm mt-2" onclick="addToCart(\''+res.result[i].p_pub_id+'\')"><i class="uil-shopping-cart-alt me-1"></i> Add to cart</button>'
                            +'</div> '
                        +'</div> '
                +'</div> '
			}

			for(var i in res.result) {
				mob_string += '<div class="col-md-6 col-12">'
                        +'<div class="card product-cards">'
                            +'<div class="row">'
                                +'<div class="col-4 product-cards-img">'
                                	+'<a href="'+res.result[i].url+'">'
                                    	+'<img src="'+res.result[i].product_image+'" class="card-img-top" alt="'+res.result[i].product_name+'">'
                                    +'</a>'
                                +'</div>' 
                                +'<div class="card-body col-8">'
                                    +'<a href="'+res.result[i].url+'">'
                                        +'<h2 class="card-title text-secondary">'+res.result[i].product_name+'<br>'
                                        +'<small class="product-category">'+res.result[i].category+'</small>'
                                        +'</h2>'
                                    +'</a>'
                                    +'<h3 class=" text-success cart-product-price">₱ '+res.result[i].price+' <button class="btn btn-success btn-sm btn-rounded mobile-add-to-cart-btn" onclick="addToCart(\''+res.result[i].p_pub_id+'\')"><i class="uil-shopping-trolley "></i> Add to cart</button></h3>'
                                +'</div> '
                            +'</div>'
                       +'</div> '
                    +'</div>'
            }
		}
        else{
            $('#err_title').text('Error Getting Products!')
            $('#err_message').html("There's an error getting Products! Please refresh the page or click the <b>Refresh</b> button below.")
            $("#_product_warning_modal").modal('show');
            string = "<div class='text-center text-secondary'>Seems there's an error. Please try again!</div>"
            mob_string = "<div class='text-center text-secondary'>Seems there's an error. Please try again!</div>"
        }

        $("#products_wrapper_home").html(string);
        $(".mobile_products_wrapper").html(mob_string);
	})
	.fail(function() {
		
	})
	.always(function() {
		$("#loader").attr('hidden','hidden');
	});
	
}