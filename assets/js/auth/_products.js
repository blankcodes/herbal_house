var nonce;

$('#products_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showProductData(page_no, nonce);
});

if (page == 'index') {
	showProductData(1, nonce)
    showProductDataCat(1, nonce);
}

var $w = $(window).scroll(function(){
    if ( $w.scrollTop()) {   
        $("#_home_navbar").addClass('navbar-home');
        $("#_logo_default").removeAttr('hidden','hidden');
        $("#_logo_light").attr('hidden','hidden');
        $(".noti-icon").css('color','#515659')
        $("#_home_navbar").removeClass('home-index-default');

    } else {
        $("#_home_navbar").removeClass('navbar-home');
        $("#_logo_default").attr('hidden','hidden');
        $("#_logo_light").removeAttr('hidden','hidden');
        $(".noti-icon").css('color','#fff')
        $("#_home_navbar").addClass('home-index-default');
    }
});
function showProductData(page_no, nonce) {
	$("#loader").removeAttr('hidden');
    let params = new URLSearchParams({page_no:page_no,nonce:nonce});
    fetch(base_url+'api/v1/product/_get_products?' + params, {
        method: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
    })
    .then(response => response.json())
    .then(res => {
        $('#products_pagination').html(res.pagination);
        mob_string = '';
        string = '';
        if (parseInt(res.count) > 0) {
            for(var i in res.result) {
                string += '<div class="col-md-4 col-lg-3 col-6">'
                       +'<div class="card pointer-cursor" onclick="_accessPage(\''+res.result[i].url+'\')">'
                            +'<img src="'+res.result[i].product_image+'" class="card-img-top" alt="'+res.result[i].product_name+'">'
                            +'<div class="card-body card-title-div">'
                                +'<span href="'+res.result[i].url+'"><h2 class="card-title text-secondary product-name">'+res.result[i].product_name+'<br>'
                                    +'<small class="product-category">'+res.result[i].category+'</small></h2>'
                                +'</span>'
                                +'<h3 class="card-title text-success">₱ '+res.result[i].price+'</h3>'
                                // +'<button href="#add_to_cart" class="btn btn-success btn-sm mt-2" onclick="addToCart(\''+res.result[i].p_pub_id+'\')"><i class="uil-shopping-cart-alt me-1"></i> Add to cart</button>'
                            +'</div> '
                        +'</div> '
                +'</div> '
            }

            for(var i in res.result) {
                mob_string += '<div class="col-md-6 col-12">'
                        +'<div class="card product-cards pointer-cursor" >'
                            +'<div class="row">'
                                +'<div class="col-4 product-cards-img">'
                                    +'<span onclick="_accessPage(\''+res.result[i].url+'\')">'
                                        +'<img src="'+res.result[i].product_image+'" class="card-img-top" alt="'+res.result[i].product_name+'">'
                                    +'</span>'
                                +'</div>' 
                                +'<div class="card-body col-8">'
                                    +'<span onclick="_accessPage(\''+res.result[i].url+'\')">'
                                        +'<h2 class="card-title text-secondary">'+res.result[i].product_name+'<br>'
                                        +'<small class="product-category">'+res.result[i].category+'</small>'
                                        +'</h2>'
                                    +'</span>'
                                    +'<h3 class=" text-success cart-product-price">₱ '+res.result[i].price+' <button class="btn btn-success btn-sm btn-rounded mobile-add-to-cart-btn" onclick="addToCart(\''+res.result[i].p_pub_id+'\')"><i class="uil-shopping-trolley "></i> Add to cart</button></h3>'
                                +'</div> '
                            +'</div>'
                       +'</div> '
                    +'</div>'
            }
        }
        else{
            string = "<div class='text-center text-secondary'>Seems there's an error. Please try again!</div>"
            mob_string = "<div class='text-center text-secondary'>Seems there's an error. Please try again!</div>"
        }

        $("#products_wrapper_home").html(string);
        $(".mobile_products_wrapper").html(mob_string);
        $("#loader").attr('hidden','hidden');

    })
    .catch((error) => {
        $("#loader").attr('hidden','hidden');
        console.error('Error:', error);
    });
	
}
function showProductDataCat(page_no, nonce) {
    $("#_category_wrapper").html('<div class="mt-1 mb-1 text-center">Getting List...</div>');
    $("#_mob_category_wrapper").html('<div class="mt-1 mb-1 text-center">Getting List...</div>');

    let params = new URLSearchParams({page_no:page_no,nonce:nonce});
    fetch(base_url+'api/v1/product/_get_product_category_home?' + params, {
        method: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
    })
    .then(response => response.json())
    .then(res => {
        mob_string = '';
        string = '';
        if (parseInt(res.count) > 0) {
            for(var i in res.result) {
                string += ' <div class="col-md-6 col-lg-3 col-6">'
                        +'<div class="card pointer-cursor" onclick="_accessPage(\''+base_url+'product/category/'+res.result[i].category_url+'\')">'
                            +'<img src="'+base_url+''+res.result[i].image+'" class="card-img-top" alt="'+res.result[i].name+'">'
                            +'<div class="card-body">'
                                +'<span class="text-success product-category-btn fw-600 stretched-link">'+res.result[i].name+' </span>'
                            +'</div> '
                        +'</div> '
                    +'</div>'
            }
        }
        else{
            string = "<div class='text-center text-secondary'>Seems there's an error. Please try again!</div>"
            mob_string = "<div class='text-center text-secondary'>Seems there's an error. Please try again!</div>"
        }

        $("#_category_wrapper").html(string);
        $("#_mob_category_wrapper").html(string);
        $("#loader").attr('hidden','hidden');

    })
    .catch((error) => {
        $("#loader").attr('hidden','hidden');
        console.error('Error:', error);
    });
}
