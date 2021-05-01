                        <div class="container mb-5 margin-top-20">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Herbal House</a></li>
                                            <li class="breadcrumb-item">Order</li>
                                            <li class="breadcrumb-item active">Order Details</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Order Details 
                                    </h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->  
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="font-17 fw-700">Order Details: &nbsp;<span id="_view_ref_no"></span></h4>
                                        <span id="_order_placed" class="font-14"></span><br>
                                        <div>
                                            Order Status: <span id="_order_status"></span> 
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>


        
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h4 class="header-title mb-3">Billing Information</h4>
                                        <h5 id="_view_bill_name" class="text-capitalize">Full Name</h5>
                                        <address class="mb-0 font-14 address-lg">
                                            <span id="_view_bill_full_address"></span><br>
                                            <abbr title="Email" ><a href="mailto:" id="_view_bill_email"></a></abbr> <br/>
                                            <abbr title="Mobile" ><a href="tel:" id="_view_bill_phone"></a></abbr> 
                                        </address>
                                    </div>

                                    <div class="col-lg-4">
                                        <h4 class="header-title mb-3">Shipping Information</h4>

                                        <h5 id="_view_ship_name" class="text-capitalize">Full Name</h5>
                                        
                                        <address class="mb-0 font-14 address-lg">
                                            <span id="_view_ship_full_address"></span><br>
                                            <abbr title="Email" ><a href="mailto:" id="_view_ship_email"></a></abbr> <br/>
                                            <abbr title="Mobile" ><a href="tel:" id="_view_ship_phone"></a></abbr> 
                                        </address>
                                    </div>
        
                                    <div class="col-lg-4">
                                        <h4 class="header-title mb-3">Delivery Info</h4>
            
                                        <div class="text-left">
                                            <i class="mdi mdi-truck-fast h3 text-muted"></i>
                                            <h5><b>Courier: </b><span  id="_view_ship_courier">Processing...</span></h5>
                                            <p class="mb-1"><b>Tracking Number :</b> <span id="_view_shipping_order_id">Processing...</span></p>
                                            <p class="mb-0"><b>Payment Method  :</b> <span id="_view_payment_method"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <!-- start row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
            
                                        <div class="table-responsive mt-2">
                                            <table class="table mb-0 order-item-tbl">
                                                <thead class="table-light">
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                </tr>
                                                </thead>
                                                <tbody id="_view_ordered_item_tbl">
                                                
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- end table-responsive -->
                                        <div class="row">
                                            <div class="col-lg-8"></div>
                                                <div class="col-lg-4 mt-3">
                                                    <table class="table mb-0">
                                                        <tbody id="order_price_tally_tbl">
                                                            <tr>
                                                                <td>Grand Total :</td>
                                                                <td id="_view_grand_total">₱ 0.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Shipping Charge :</td>
                                                                <td id="_view_shipping_fee">₱ 0.00</td>
                                                            </tr>
                                                            <!-- <tr>
                                                                <td>Estimated Tax : </td>
                                                                <td>$19.22</td>
                                                            </tr> -->
                                                            <tr>
                                                                <th>Total :</th>
                                                                <th id="_view_total">₱ 0.00</th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                        </div>
            
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        <!-- start row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="font-17 fw-700">Event Logs: </h4>
                                        <div class="table-responsive mt-2">
                                            <table class="table mb-0 order-item-tbl">
                                                <thead class="table-light">
                                                <tr>
                                                    <th>Date & Time</th>
                                                    <th>Activity</th>
                                                </tr>
                                                </thead>
                                                <tbody id="_event_logs">
                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->