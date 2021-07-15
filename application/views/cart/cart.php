                    <!-- Start Content-->
                    <div class="container mb-5">

                       <!-- start page title -->
                        <div class="row margin-top-90">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-left">
                                        <ol class="breadcrumb mt-2">
                                            <li class="breadcrumb-item"><a href="<?=base_url();?>">Herbal House</a></li>
                                            <li class="breadcrumb-item"><a href="<?=base_url('#shop_now');?>">Shop</a></li>
                                            <li class="breadcrumb-item active">Shopping Cart</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div id="mobile-view" class="cart-page-header">
                            <h2 class="cart-page-title"><i class="uil-cart"></i> My Cart</h2>
                            
                            <button class="btn btn-light btn-rounded cart-page-back-btn" onclick="window.history.back();"><i class="uil-angle-left font-25"></i></button>
                            <span id="cart_count" class="fw-700"></span>
                        </div>
                        <div class="row mobile_cart_wrapper" id="mobile-view">
                    
                        </div>

                        <div id="mobile-view">
                            <div class="col-12">
                                <div class="card " style="border-radius: 25px;">
                                    <div class="card-body">
                                       <h4 class="header-title mb-3">Order Summary</h4>
                                            <div class="table-responsive">
                                                 <table class="table mb-0">
                                                    <tbody>

                                                        <tr>
                                                            <td>SubTotal :</td>
                                                            <td id="_sub_total_mob">₱ 0.00</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Discount : </td>
                                                            <td id="_discount_mob">₱ 0.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Shipping Charge :</td>
                                                            <td id="_shipping_charge">₱ 0.00</td>
                                                        </tr>
                                                        <!-- <tr>
                                                            <td>Estimated Tax : </td>
                                                            <td>$19.22</td>
                                                        </tr> -->

                                                        
                                                        
                                                        <tr>
                                                            <th>Total :</th>
                                                            <th id="_total_mob">₱ 0.00</th>
                                                        </tr>
                                                    </tbody>
                                            </table>
                                        </div>
                                        <!-- end table-responsive -->
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                            
                        </div>

                        <div class="row" id="web-view">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless table-centered mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Price</th>
                                                                <th>Quantity</th>
                                                                <th>Total</th>
                                                                <th style="width: 50px;"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="_shopping_cart_tbl">
                                                           
                                                        </tbody>
                                                    </table>
                                                </div> <!-- end table-responsive-->

                                                
                                            </div>
                                            <!-- end col -->

                                            <div class="col-lg-4">
                                                <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                    <h4 class="header-title mb-3">Order Summary</h4>

                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>SubTotal :</td>
                                                                    <td id="_sub_total">₱ 0.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Discount : </td>
                                                                    <td id="_discount">₱ 0.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Total :</th>
                                                                    <th id="_total">₱ 0.00</th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- end table-responsive -->
                                                </div>

                                            </div> <!-- end col -->

                                            <!-- Add note input-->
                                            <div class="col-lg-8">
                                               
                                                <!-- action buttons-->
                                                <div class="row mt-4">
                                                    <div class="col-sm-6">
                                                        <a href="<?=base_url('#shop_now');?>" class="btn text-muted d-none d-sm-inline-block btn-link fw-semibold">
                                                            <i class="mdi mdi-arrow-left"></i> Continue Shopping </a>
                                                    </div> <!-- end col -->
                                                    <div class="col-sm-6">
                                                        <div class="text-sm-end">
                                                            <button id="_checkout_btn" onclick="window.location='<?=base_url('checkout')?>'" class="btn btn-success font-15 rounded k-btn">
                                                                <i class="uil-cart me-1"></i> Check Out </button>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row-->
                                            </div>

                                        </div> <!-- end row -->
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->
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
                                <div class="mobile-nav-btn">
                                    <button id="_checkout_btn" onclick="window.location.href='<?=base_url('checkout')?>'" class="c-white cart-checkout-btn btn btn-success btn-rounded">Checkout</button>
                                </div>      
                            </div>
                        </nav>
                    </div>
                    <!-- End Mobile Nav -->