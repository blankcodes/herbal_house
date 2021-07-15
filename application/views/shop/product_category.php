                    <!-- Start Content-->
                    <div class="container mb-5">
                        
                        <!-- start page title -->
                        <div id="web-view" class="row margin-top-90">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-left">
                                        <ol class="breadcrumb mt-2">
                                            <li class="breadcrumb-item"><a href="<?=base_url();?>">Herbal House</a></li>
                                            <li class="breadcrumb-item"><a href="<?=base_url('#shop_now')?>">Shop</a></li>
                                            <li class="breadcrumb-item"><a href="<?=base_url('#product_category')?>">Category</a></li>
                                            <li class="breadcrumb-item active"><?=$category['name']?></li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <section class="product_section" id="mobile-view">
                            <div class="" id="shop_now">
                                <div class="mb-3 search_wrapper_home">
                                    <form id="_mobile_search_product_form">
                                        <div class="d-flex search-mobile-product-wrapper">
                                            <input type="text" id="_mobile_search_product" name="keyword" class="form-control search-mobile-product" placeholder="Search products...">
                                            <span class="uil-search search-mobile-icon" ></span>
                                        </div>
                                    </form>
                                    <div class="search-result-wrapper" id="search_result_panel" hidden="hidden">
                                        <div class="header padding-right-10 padding-left-10" id="search_header__">
                                            Found <span class="text-success">0</span> results.
                                        </div>
                                        <div id="_search_result_wrapper">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                           
                        <div class="mt-4" id="mobile-view"></div>
                        <div class="row" id="_prodcat_products">
                            <?php foreach($products as $p) { ?>
                            <div class="col-md-4 col-lg-3 col-6">
                                <div class="card">
                                        <a href="<?=$p['product_url']?>"><img src="<?=$p['image_url']?>" class="card-img-top" alt="<?=$p['name']?>"></a>
                                        <div class="card-body card-title-div">
                                            <a href="<?=$p['product_url']?>"><h2 class="card-title text-secondary product-name"><?=$p['name']?><br>
                                                <small class="product-category"><?=$category['name']?></small></h2>
                                            </a>
                                            <h3 class="card-title text-success">₱ <?=$p['price']?></h3>
                                            <button href="#add_to_cart" class="btn btn-success rounded btn-sm mt-2 prod-cat-btn" onclick="addToCart('<?=$p['p_pub_id']?>')"><i class="uil-shopping-cart-alt me-1"></i> Add to cart</button>
                                        </div> 
                                </div> 
                            </div> 
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Mobile Nav -->
                    <div id="mobile-view" class="mobile-menu">
                        <nav class="mobile-bottom-nav row">
                            <div class="col-4 col-md-4">
                                <div class="mobile-nav-btn" onclick="window.location.href='<?=base_url()?>'">
                                    <i class="uil-home-alt "></i> 
                                </div>      
                            </div>
                            <div class="col-4 col-md-4">
                                <div class="mobile-nav-btn" onclick="window.location.href='<?=base_url('account')?>'">
                                    <i class="uil-user"></i>
                                </div>      
                            </div>
                            <div class="col-4 col-md-4">       
                                <div class="mobile-nav-btn" onclick="window.location.href='<?=base_url('cart')?>'">
                                    <i class="dripicons-cart"></i> <span class="bounce bg-success" id="mobile_nav_cart_alert"></span>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <!-- End Mobile Nav -->

                    <?php if (isset($_GET['ref'])){
                        $user = $this->db->WHERE('username', $_GET['ref'])->GET('user_tbl')->row_array();
                        if (isset($user) && !isset($this->session->username)) {
                            $this->session->set_userdata('referrer', $user['username']);
                        }
                    }?>

                   
