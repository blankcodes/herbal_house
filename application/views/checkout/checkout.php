                    
                    <!-- Start Content-->
                    <div class="container mb-5">

                       <!-- start page title -->
                        <div class="row margin-top-90">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-left">
                                        <ol class="breadcrumb mt-2">
                                            <li class="breadcrumb-item"><a href="<?=base_url();?>">Herbal House</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Shop</a></li>
                                            <li class="breadcrumb-item"><a href="<?=base_url('cart')?>">Shopping Cart</a></li>
                                            <li class="breadcrumb-item active">Checkout</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <!-- Checkout Steps -->
                                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                            <li class="nav-item">
                                                <a id="_billing_info_tab" href="#billing-information" data-bs-toggle="tab" aria-expanded="false"
                                                    class="nav-link rounded-0 active">
                                                    <i class="mdi mdi-account-circle font-18"></i>
                                                    <span class="d-none d-lg-block">Billing Info</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a id="_shipping_info_tab" href="#shipping-information" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                                    <i class="mdi mdi-truck-fast font-18"></i>
                                                    <span class="d-none d-lg-block">Shipping Info</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a id="_payment_info_tab" href="#payment-information" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                                    <i class="mdi mdi-cash-multiple font-18"></i>
                                                    <span class="d-none d-lg-block">Payment Info</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Steps Information -->
                                        <div class="tab-content">

                                            <!-- Billing Content-->
                                            <div class="tab-pane show active" id="billing-information">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h4 class="mt-2">Billing information</h4>

                                                        <p class="text-muted mb-4">Fill the form below in order to
                                                            send you the order's invoice.</p>

                                                        <form id="_billing_info_form">
                                                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="billing-first-name" class="form-label">First Name <span class="text-danger">*</span></label>
                                                                        <input class="form-control" name="fname" type="text" placeholder="Enter your first name" id="billing_first_name" required />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="billing-last-name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                                        <input class="form-control" name="lname" type="text" placeholder="Enter your last name" id="billing_last_name" required/>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end row -->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="billing-email-address" class="form-label">Email Address <span class="text-danger">*</span></label>
                                                                        <input class="form-control" name="email_address" type="email" placeholder="Enter your email" id="billing_email_address" required/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="billing-phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                                                        <input class="form-control" name="phone" type="text" placeholder="09xx xxxx xxxx" id="billing_phone" required />
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end row -->
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label for="billing-address" class="form-label">Address <span class="text-danger">*</span></label>
                                                                        <input class="form-control" name="address" type="text" placeholder="House/Apt. no. St. name, Subdivision/Ville/Brgy." id="billing_address" required>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end row -->
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label for="billing-town-city" class="form-label">Town / City <span class="text-danger">*</span></label>
                                                                        <input class="form-control" name="city" type="text" placeholder="Enter your city name" id="billing_town_city" required/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label for="billing-state" class="form-label">Province <span class="text-danger">*</span></label>
                                                                        <input class="form-control" name="state" type="text" placeholder="Enter your Province" id="billing_state" required/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label for="billing-zip-postal" class="form-label">Zip / Postal Code <span class="text-danger">*</span></label>
                                                                        <input class="form-control" name="zip_code" type="text" placeholder="Enter your zip code" id="billing_zip_postal" required/>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end row -->
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Country <span class="text-danger">*</span></label>
                                                                        <select id="billing_country" data-toggle="select2" name="country" title="Country" required>
                                                                            <option selected disabled="">Select Country</option>
                                                                            <!-- <option value="Cambodia">Cambodia</option> -->
                                                                            <!-- <option value="Indonesia">Indonesia</option> -->
                                                                            <!-- <option value="Malaysia">Malaysia</option> -->
                                                                            <option value="Philippines">Philippines</option>
                                                                            <!-- <option value="Singapore">Singapore</option> -->
                                                                            <!-- <option value="Thailand">Thailand</option> -->
                                                                            <!-- <option value="Vietnam">Vietnam</option> -->
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end row -->

                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <div class="form-check">
                                                                            <input id="_ship_same_address" name="ship_same_address" type="checkbox" class="form-check-input" checked>
                                                                            <label class="form-check-label" for="_ship_same_address">Ship to the same address ?</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end row -->

                                                            <div class="row mt-4">
                                                                <div class="col-sm-6">
                                                                    <a href="<?=base_url('cart')?>" class="btn text-muted d-none d-sm-inline-block btn-link fw-semibold">
                                                                        <i class="mdi mdi-arrow-left"></i> Back to Shopping Cart </a>
                                                                </div> <!-- end col -->
                                                                <div class="col-sm-6">
                                                                    <div class="text-sm-end">
                                                                       <button type="submit" id="_proceed_to_shipping_btn" class="btn btn-primary btn-lg k-btn rounded">
                                                                           <i class="mdi mdi-truck-fast me-1"></i> Proceed to Shipping 
                                                                       </button>
                                                                    </div>
                                                                </div> <!-- end col -->
                                                            </div> <!-- end row -->
                                                        </form>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                            <h4 class="header-title mb-3">Order Summary</h4>
            
                                                            <div class="table-responsive">
                                                                <table class="table table-centered mb-0">
                                                                    <tbody id="_billing_order_summary">
                                                                       
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <!-- end table-responsive -->
                                                        </div> <!-- end .border-->
            
                                                    </div> <!-- end col -->            
                                                </div> <!-- end row-->
                                            </div>
                                            <!-- End Billing Information Content-->

                                            <!-- Shipping Content-->
                                            <div class="tab-pane" id="shipping-information">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                   

                                                        <h4 class="mt-2">Shipping Information</h4>

                                                        <p class="text-muted mb-4">Fill the form below where to ship your order.</p>

                                                        <form id="_shipping_info_form">
                                                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="new-adr-first-name" class="form-label">First Name <span class="text-danger">*</span></label>
                                                                        <input class="form-control" type="text" placeholder="Enter your first name" name="fname" id="shipping_first_name" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="new-adr-last-name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                                        <input name="lname" class="form-control" type="text" placeholder="Enter your last name" id="shipping_last_name" />
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end row -->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="new-adr-email-address" class="form-label">Email Address <span class="text-danger">*</span></label>
                                                                        <input name="email_address" class="form-control" type="email" placeholder="Enter your email" id="shipping_email_address" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="new-adr-phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                                                        <input class="form-control" type="text" name="phone" placeholder="09xx xxxx xxxx" id="shipping_phone" />
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end row -->
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label for="new-adr-address" class="form-label">Address <span class="text-danger">*</span></label>
                                                                        <input class="form-control" type="text" name="address" placeholder="Enter full address" id="shipping_address">
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end row -->
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label for="new-adr-town-city" class="form-label">Town / City <span class="text-danger">*</span></label>
                                                                        <input class="form-control" type="text" name="city" placeholder="Enter your city name" id="shipping_town_city" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label for="new-adr-state" class="form-label">Province <span class="text-danger">*</span></label>
                                                                        <input class="form-control" type="text" name="state" placeholder="Enter your state" id="shipping_state" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label for="new-adr-zip-postal" class="form-label">Zip / Postal Code <span class="text-danger">*</span></label>
                                                                        <input class="form-control" type="text" name="zip_code" placeholder="Enter your zip code" id="shipping_zip_postal" />
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end row -->
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Country <span class="text-danger">*</span></label>
                                                                        <select id="shipping_country" name="country" data-toggle="select2" title="Country">
                                                                           <option selected disabled="">Select Country</option>
                                                                            <!-- <option value="Cambodia">Cambodia</option> -->
                                                                            <!-- <option value="Indonesia">Indonesia</option> -->
                                                                            <!-- <option value="Malaysia">Malaysia</option> -->
                                                                            <option value="Philippines">Philippines</option>
                                                                            <!-- <option value="Singapore">Singapore</option> -->
                                                                            <!-- <option value="Thailand">Thailand</option> -->
                                                                            <!-- <option value="Vietnam">Vietnam</option>                                   -->
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end row -->

                                                            <!-- <h4 class="mt-4">Shipping Method</h4>

                                                            <p class="text-muted mb-3">Fill the form below in order to
                                                                send you the order's invoice.</p>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="border p-3 rounded mb-3 mb-md-0">
                                                                        <div class="form-check">
                                                                            <input type="radio" id="shippingMethodRadio1" name="shippingOptions" class="form-check-input" checked>
                                                                            <label class="form-check-label font-16 fw-bold" for="shippingMethodRadio1">Standard Delivery - FREE</label>
                                                                        </div>
                                                                        <p class="mb-0 ps-3 pt-1">Estimated 5-7 days shipping (Duties and tax may be due upon delivery)</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="border p-3 rounded">
                                                                        <div class="form-check">
                                                                            <input type="radio" id="shippingMethodRadio2" name="shippingOptions" class="form-check-input">
                                                                            <label class="form-check-label font-16 fw-bold" for="shippingMethodRadio2">Fast Delivery - $25</label>
                                                                        </div>
                                                                        <p class="mb-0 ps-3 pt-1">Estimated 1-2 days shipping (Duties and tax may be due upon delivery)</p>
                                                                    </div>
                                                                </div>
                                                            </div> -->
                                                            <!-- end row-->

                                                            <div class="row mt-4">
                                                                <div class="col-sm-6">
                                                                    <a href="<?=base_url('cart')?>" class="btn text-muted d-none d-sm-inline-block btn-link fw-semibold">
                                                                        <i class="mdi mdi-arrow-left"></i> Back to Shopping Cart </a>
                                                                </div> <!-- end col -->
                                                                <div class="col-sm-6">
                                                                    <div class="text-sm-end">
                                                                        <button type="submit" id="_cont_to_payment_btn" class="btn btn-primary btn-lg k-btn rounded">
                                                                            <i class="mdi mdi-cash-multiple me-1"></i> Continue to Payment </button>
                                                                    </div>
                                                                </div> <!-- end col -->
                                                            </div> <!-- end row -->
                                                        </form>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                            <h4 class="header-title mb-3">Order Summary</h4>
            
                                                            <div class="table-responsive">
                                                                <table class="table table-centered mb-0">
                                                                    <tbody id="_shipping_order_summary">
                                                                        
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <!-- end table-responsive -->
                                                        </div> <!-- end .border-->
            
                                                    </div> <!-- end col -->            
                                                </div> <!-- end row-->
                                            </div>
                                            <!-- End Shipping Information Content-->

                                            <!-- Payment Content-->
                                            <div class="tab-pane" id="payment-information">
                                                <div class="row">

                                                    <div class="col-lg-8">
                                                        <h4 class="mt-2">Payment Selection</h4>

                                                        <p class="text-muted mb-4">Fill the form below in order to
                                                            send you the order's invoice.</p>
                                                        <form id="_complete_order_form">
                                                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                                        <div id="payment_wrapper">
                                                            
                                                        </div>

                                                        <div class="mb-3 mt-3">
                                                            <label for="example-textarea" class="form-label">Order Notes:</label>
                                                            <textarea class="form-control" id="order_notes" name="order_notes" rows="3" placeholder="Write some note.."></textarea>
                                                            <small class="mt-2 font-12">***Double check your information before placing an order to avoid issues.</small>
                                                         </div>
                                                        <!-- end Cash on Delivery box-->

                                                        <div class="row mt-4">
                                                            <div class="col-sm-6">
                                                                <a href="<?=base_url('cart')?>" class="btn text-muted d-none d-sm-inline-block btn-link fw-semibold">
                                                                    <i class="mdi mdi-arrow-left"></i> Back to Shopping Cart </a>
                                                            </div> <!-- end col -->
                                                            <div class="col-sm-6">
                                                                <div class="text-sm-end">
                                                                    <button id="_complete_order_btn" type="submit" class="btn btn-success btn-lg k-btn rounded"> <i class="uil-bill  me-1"></i> Place Order</button>

                                                                </div>
                                                            </div> <!-- end col -->
                                                        </div> <!-- end row-->


                                                                    
                                                        </form>

                                                    </div> <!-- end col -->

                                                    <div class="col-lg-4">
                                                        <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                            <h4 class="header-title mb-3">Order Summary</h4>
            
                                                            <div class="table-responsive">
                                                                <table class="table table-centered mb-0">
                                                                    <tbody id="_payment_order_summary">
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <!-- end table-responsive -->
                                                        </div> <!-- end .border-->
            
                                                    </div> <!-- end col -->            
                                                </div> <!-- end row-->
                                            </div>
                                            <!-- End Payment Information Content-->
                                        </div> <!-- end tab content-->

                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                    </div> <!-- container -->
                    <div id="loader" class="loader-div" hidden>
                        <div class="loader-wrapper">
                          <img src="<?=base_url('assets/images/loader.gif')?>" width="120" heigth="120">
                        </div>
                    </div>