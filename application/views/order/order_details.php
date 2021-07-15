                        <div class="container mb-5 margin-top-30">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12 mt-5">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Herbal House</a></li>
                                            <li class="breadcrumb-item active">Order Details</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Order Details</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row justify-content-center">
                            <div class="col-lg-7 col-md-10 col-sm-11">
        
                                <div class="horizontal-steps mt-4 mb-4 pb-5" id="tooltip-container">
                                    <div class="horizontal-steps-content">
                                        <div class="step-item" id="order_placed_timeline">
                                            <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" style="font-size: 90%;">Order Placed</span>
                                        </div>
                                        <div class="step-item " id="order_packed_timeline" >
                                            <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" style="font-size: 90%;">Packed</span>
                                        </div>
                                        <div class="step-item" id="order_shipped_timeline">
                                            <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" style="font-size: 90%;">Shipped</span>
                                        </div>
                                        <div class="step-item " id="order_delivered_timeline">
                                            <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" style="font-size: 90%;">Delivered</span>
                                        </div>
                                    </div>
        
                                    <div id="_order_process_line" class="process-line" style="width: 1%;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->    
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="font-17 fw-600">Order Details: &nbsp;<span id="_view_ref_no"></span></h4>
                                        <span id="_order_placed" class="font-14 fw-400"></span><br>
                                        <div>
                                            Order Status: <span id="_order_status"></span> 
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>


                        <!-- start row -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h4 class="header-title mb-1 mt-3 order-title-label mb-2">Billing Information</h4>
                                        <h5 id="_view_bill_name" class="text-capitalize fw-300">Full Name</h5>
                                        <address class="mb-0 font-14 address-lg">
                                            <abbr title="Mobile" ><a href="tel:" id="_view_bill_phone"></a></abbr> <br>
                                            <abbr title="Email" ><a href="mailto:" id="_view_bill_email"></a></abbr> <br>
                                            <span id="_view_bill_full_address"></span><br>
                                             <br/>
                                        </address>
                                    </div>

                                    <div class="col-lg-4">
                                        <h4 class="header-title mb-1 mt-3 order-title-label mb-2">Shipping Information</h4>

                                        <h5 id="_view_ship_name" class="text-capitalize fw-300">Full Name</h5>
                                        
                                        <address class="mb-0 font-14 address-lg">
                                            <abbr title="Mobile" ><a href="tel:" id="_view_ship_phone"></a></abbr> <br/>
                                            <abbr title="Email" ><a href="mailto:" id="_view_ship_email"></a></abbr> <br/>
                                            <span id="_view_ship_full_address"></span><br>
                                            
                                        </address>
                                    </div>
        
                                    <div class="col-lg-4">
                                        <h4 class="header-title mb-1 mt-3 order-title-label mb-2">Delivery Info</h4>
            
                                        <div class="text-left">
                                            <!-- <i class="mdi mdi-truck-fast h3 text-muted"></i> -->
                                            <h5><span  id="_view_ship_courier"></span></h5>
                                            <p class="mb-1"><b class="fw-600">Tracking Number :</b> <span id="_view_shipping_order_id">Processing...</span></p>
                                            <p class="mb-0"><b class="fw-600">Payment Method  :</b> <span id="_view_payment_method"></span></p>
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
                                                                <td>Shipping Charge :</td>
                                                                <td id="_view_shipping_fee">₱ 0.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td>SubTotal :</td>
                                                                <td id="_view_grand_total">₱ 0.00</td>
                                                            </tr>
                                                            <!-- <tr>
                                                                <td>Estimated Tax : </td>
                                                                <td>$19.22</td>
                                                            </tr> -->
                                                            <tr>
                                                                <th>Total :</th>
                                                                <th id="_view_total" class="text-success font-18 fw-700">₱ 0.00</th>
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

                        <div id="order_tracking_details_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-parcel"></i> <span id="_modal_title">Order Tracking Details</span></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body mb-3">
                                        <div id="tracking_details">
                                            
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal --> 
                    </div> <!-- container -->