var targetOffset = $("#product_image_details").offset().top;

var $w = $(window).scroll(function(){
    if ( $w.scrollTop() > targetOffset ) {   
        $("#_mobile_nav_top").removeAttr('hidden');
        $("#_shop_back_btn").removeClass('product-page-back-btn').addClass('product-page-back-btn-green');
    } else {
        $("#_mobile_nav_top").attr('hidden','hidden');
        $("#_shop_back_btn").removeClass('product-page-back-btn-green').addClass('product-page-back-btn');
    }
});