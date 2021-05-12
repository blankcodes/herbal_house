                    <!-- Start Content-->
                    <div class="container mb-5">
                        
                        <!-- start page title -->
                        <div id="web-view" class="row margin-top-90">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-left">
                                        <ol class="breadcrumb mt-2">
                                            <li class="breadcrumb-item"><a href="<?=base_url();?>">Herbal House</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Shop</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);"><?=$product['category']?></a></li>
                                            <li class="breadcrumb-item active"><?=$product['name']?></li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row" style="margin-top: -10px;" id="web-view">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <!-- Product image -->
                                                <a href="javascript: void(0);" class="text-center d-block mb-4">
                                                   <img id="prod_shp_img" onclick="openProductImg()" src="<?=$product['image_url']?>" class="img-fluid product--image" style="max-width: 500px;" alt="<?=$product['name']?> - Herbal House" />
                                                </a>

                                            </div> <!-- end col -->
                                            <div class="col-lg-6 product--details">
                                                <!-- Product title -->
                                                <h1 class="mt-0 font-24" id="_view_prod_name"><a href="javascript: void(0);" class=""></a> <?=$product['name']?></h1>

                                                <!-- Product stock -->
                                                <div class="mt-0">
                                                    <h4 id="_view_stock_status"></h4>
                                                </div>

                                                <!-- Product price -->
                                                <div class="row mt-1">
                                                        <div class="col-lg-6">
                                                            <h2 id="_view_dc_price" class="text-success font-35"> ₱  <?=number_format($product['price'], 2)?></h2>
                                                        </div>
                                                </div>

                                                <!-- Quantity -->
                                                <div class="mt-3">
                                                    <h6 class="font-14">Quantity</h6>
                                                    <div class="d-flex col-lg-4 col-md-3 col-6">
                                                        <!-- <input type="number" min="1" value="1" class="form-control" placeholder="Qty" style="width: 90px;"> -->
                                                        <input data-toggle="touchspin" id="_qty" value="1" type="text" data-bts-button-down-class="btn btn-light rounded" data-bts-button-up-class="btn btn-light" style="margin: 0 5px !important; border-radius: 4px; border-color: ">
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <div class="d-flex">
                                                        <?php if ($product['qty'] <= 0) { ?>
                                                        <button type="button" class="btn btn-outline-primary btn-lg add-cart-btn" style="font-size: 15px !important; padding: 13px 30px;"><i class="uil-shopping-cart-alt me-1"></i> Sold out</button>
                                                        <?php } else{ ?>
                                                        <button id="_add_to_cart" type="button" class="btn btn-outline-success btn-lg add-cart-btn rounded" style="font-size: 15px !important; padding: 13px 30px;"><i class="uil-shopping-cart-alt me-1"></i> Add to cart</button>
                                                        <?php } ?>
                                                        <button id="_buy_now" type="button" class="btn btn-success btn-lg add-cart-btn ms-2 rounded" style="font-size: 15px !important; padding: 13px 30px;">Buy Now</button>
                                                    </div>
                                                </div>
                                                            
                                                <!-- Shipping Details -->
                                                <div class="mt-3">
                                                    <h6 class="font-14"><i class="mdi mdi-truck-fast font-16"></i> Shipping:</h6>
                                                 </div>

                                                <!-- Share  -->
                                                <div class="mt-3">
                                                    <h6 class="font-14"><i class="uil-share-alt"></i> Share:</h6>
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$product['product_url'];?>" target="_blank" rel="noopener nofollow"><span class="facebook-color font-25 mdi mdi-facebook "></span></a>
                                                    <a href="https://www.pinterest.com/pin/create/button/?url=<?=$product['product_url'];?>&media=<?=$product['image_url'];?>&description=<?=$product['category'];?>&title=<?=$product['name'];?>" target="_blank" rel="noopener nofollow"><span class="pinterest-color font-25 mdi mdi-pinterest "></span></a>
                                                    <!-- <a href="" target="_blank" rel="noopener nofollow"><span class="facebook-color font-25 uil-link-alt  "></span></a> -->
                                                    <a id="mobile-view" href="fb-messenger://share/?link=<?=$product['product_url'];?>&app_id=576747789395855" target="_blank" rel="noopener nofollow"><span class="fb-messenger-color font-25 uil-facebook-messenger  "></span></a>
                                                    <a href="https://twitter.com/intent/tweet?original_referer=<?=$product['product_url'];?>&text=Buy <?=$product['name'];?>&url=<?=$product['product_url'];?>&hashtags=HerbalHouse" target="_blank" rel="noopener nofollow"><span class="twitter-color font-25 uil-twitter "></span></a>
                                                    <a href="<?=$product['product_url'];?>" target="_blank" rel="noopener nofollow"><span class="facebook-color font-25 uil-link-alt  "></span></a>
                                                 </div>

                                            </div> <!-- end col -->
                                        </div> <!-- end row-->

                                       
                                        
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row-->

                        <div class="row" style="" id="web-view">
                            <div class="col-lg-12">
                                <div class="card ribbon-box">
                                    <div class="card-body">
                                        <div class="mt-1 alert alert-light text-secondary product--title-desc font-17 fw-600" id="_view_prod_name">Product Specifications</div>
                                        <div class="col-lg-12 product--description margin-left-20">
                                            <div class="font-15 text-secondary">
                                                <span class="fw-600 ">Category:</span> &nbsp;&nbsp;&nbsp;Herbal House <i class="uil-angle-right "></i> Shop <i class="uil-angle-right "></i> <?=$product['category']?>
                                            </div>
                                            <div class="font-15 mt-2 text-secondary">
                                                <span class="fw-600 ">Stock: </span><span>&nbsp;&nbsp;&nbsp;<?=$product['qty']?></span>
                                            </div>
                                        </div>

                                        <div class="mt-4 alert alert-light text-secondary product--title-desc font-17 fw-600" id="_view_prod_name">Product Description</div>
                                        <div class="margin-left-20">
                                            <div class="mt-1 product--description font-15">
                                               <?=$product['description'];?>
                                            </div>
                                        </div>
                                       
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>


                        <div class="row" id="mobile-view">
                            <div class="col-12">
                                <div class="mobile-nav-product-details" hidden="hidden" id="_mobile_nav_top">
                                   
                                    <div style="width: 320px;">
                                        <h3 class="mob-nav-title-product"><?=$product['name']?></h3>
                                    </div>
                                    <!-- <button class="btn"><i class=" uil-ellipsis-v "></i></button> -->
                                </div>
                                 <button id="_shop_back_btn" class="btn product-page-back-btn" onclick="window.history.back();"><i class="mdi mdi-arrow-left font-22"></i></button>

                                <div class="search-result-wrapper" id="search_result_panel" hidden="hidden">
                                    <div class="header padding-right-10 padding-left-10" id="search_header__">
                                        Found <span class="text-success">0</span> results.
                                    </div>
                                    <div id="_search_result_wrapper">
                                        
                                    </div>
                                </div>

                                 <img onclick="openProductImg()" id="product_image_details" src="<?=$product['image_url']?>" class="img-fluid mobile-product-page-img  mt-2" alt="<?=$product['name']?> - Herbal House" />

                                <div class="card product-page-body">
                                    <div class="card-body">
                                        <h1 class="product-page-title"><?=$product['name']?></h1>
                                        <small><?=$product['category']?></small>

                                        <div class="mt-2">
                                            <h2 class="text-success font-28 fw-700">₱ <?=number_format($product['price'], 2)?></h2>
                                        </div>
                                        <div class="mt-3">
                                            <h3 class="fw-600 font-17">Description</h3>
                                            <div class="font-15">
                                                <?=$product['description']?>
                                            </div>
                                        </div>

                                        <!-- Share  -->
                                        <div class="mt-4">
                                        <h6 class="font-16"><i class="uil-share-alt"></i> Share:</h6>
                                            <a href="https://twitter.com/intent/tweet?original_referer=<?=$product['product_url'];?>&text=Buy <?=$product['name'];?>&url=<?=$product['product_url'];?>&hashtags=HerbalHouse" target="_blank" rel="noopener nofollow"><span class="twitter-color font-25 uil-twitter "></span></a>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$product['product_url'];?>" target="_blank" rel="noopener nofollow"><span class="facebook-color font-25 mdi mdi-facebook"></span></a>
                                            <a href="https://www.pinterest.com/pin/create/button/?url=<?=$product['product_url'];?>&media=<?=$product['image_url'];?>&description=<?=$product['category'];?>&title=<?=$product['name'];?>" target="_blank" rel="noopener nofollow"><span class="pinterest-color font-25 mdi mdi-pinterest "></span></a>
                                            <a id="mobile-view" href="fb-messenger://share/?link=<?=$product['product_url'];?>&app_id=576747789395855" target="_blank" rel="noopener nofollow"><span class="fb-messenger-color font-25 uil-facebook-messenger  "></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mobile Nav -->
                        <div id="mobile-view" class="mobile-menu">
                            <nav class="mobile-bottom-nav row">
                                <div class="col-3 col-md-3">
                                    <div class="mobile-nav-btn" onclick="window.location.href='<?=base_url()?>'">
                                        <i class="uil-home-alt "></i>
                                    </div>      
                                </div>

                                <div class="col-3 col-md-3">       
                                    <div class="mobile-prod-nav-btn cart-prod-btn" onclick="window.location.href='<?=base_url('cart')?>'">
                                        <i class="dripicons-cart font-32 ms-2"></i> <span class=" bounce bg-success" id="mobile_nav_cart_alert"></span>
                                    </div>
                                </div>
                                <input min="1" value="1" type="hidden" id="_qty_" name="qty" class="mobile-qty-prod form-control">

                                <!-- <div class="col-3 col-md-3">
                                    <div class="mobile-prod-nav-btn">
                                       <input min="1" value="1" type="number" id="_qty_" name="qty" class="mobile-qty-prod form-control">
                                    </div>     
                                </div> -->

                                <div class="col-6 col-md-6">
                                    <div class="mobile-prod-nav-btn">
                                        <button class="c-white prod-add-to-cart-btn btn btn-success btn-rounded" id="_add_to_mobile_cart"><i class=" uil-shopping-trolley "></i> Add to Cart</button>
                                    </div>      
                                </div>
                                
                            </nav>
                        </div>
                        <!-- End Mobile Nav -->


                         <div class="row" style="">
                            <div class="col-lg-12">
                                <div class="card ribbon-box">
                                    <div class="card-body">
                                        <div>
                                            <h3 class="fw-500 font-19 mb-2">Products you may like</h3>
                                        </div>
                                        <div id="products_wrapper_" class="row">
                                            
                                        </div>
                                       
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            
                        </div>

                    </div> <!-- container -->
                    <div id="open_product_img" class="modal " tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg ">
                            <div class="modal-content rounded-modal" >
                                <div class="modal-header">
                                    <h4 class="modal-title font-18" id="fullWidthModalLabel"><i class="uil-pricetag-alt "></i> <?=$product['name']?></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                </div>
                                <div class="modal-body text-center mb-4" id="prod_modal_img">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="_product_nonce" name="<?=$nonce['name'];?>" value="<?=$nonce['hash'];?>" />

                   
