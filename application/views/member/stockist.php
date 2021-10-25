                    <!-- end Topbar -->

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Herbal House</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Stockist Account</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Stockist Account</h4> 
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                    

                        <div class="row">
                            <div class="">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body ">
                                            <div class="alert alert-success bg-light text-dark border-0" role="alert">
                                                This is your monitoring and inventory dashboard for your Stockist account. 
                                            </div>
                                        </div>
                                    </div>

                                </div> <!-- end col-->
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="uil-box widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="">Available Stocks</h5>
                                        <h2 class="mt-3 mb-3" id="_available_stocks">0</h2>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="uil-cart widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="">Sold Products</h5>
                                        <h2 class="mt-3 mb-3" id="_sold_products">0</h2>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="uil-bill widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="">Sales (Computed from product's SRP)</h5>
                                        <h2 class="mt-3 mb-3" id="_sales">₱ 0.00</h2>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                        </div>


                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <button class="btn btn-success mb-2" id="_process_purchase_btn"><i class="uil-shopping-trolley  me-2"></i> Process Purchase</button>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="text-sm-end">
                                            <button type="button" class="btn btn-light mb-2" onclick="productsAvail(1)">Refresh</button>
                                            <button type="button" class="btn btn-light mb-2">Export</button>
                                        </div>
                                    </div><!-- end col-->
                                </div>
                                
                                <div class="table-responsive">
                                    <h4>Products Available</h4>
                                    <div class="bg-default text-dark border-0 mb-4" role="alert">
                                        List of Products that you can resell, make sure you have enough stocks in every product you want to sell.
                                    </div>

                                    <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                                        <thead class="table-light font-13" >
                                            <tr>
                                                <th class="all">Product</th>
                                                <th>Category</th>
                                                <th>Retail Price</th>
                                                <th>Stocks</th>
                                            </tr>
                                        </thead>
                                        <tbody id="_products_tbl" class="font-13">
                                                    
                                        </tbody>
                                    </table>
                                </div>
                                <div id="_products_tbl_pagination"></div>
                                        
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-body">

                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="text-sm-end">
                                            <button type="button" class="btn btn-light mb-2" onclick="stockistTransactionHistory(1)">Refresh</button>
                                            <button type="button" class="btn btn-light mb-2">Export</button>
                                        </div>
                                    </div><!-- end col-->
                                </div>

                                <div class="table-responsive">
                                    <h4>Transaction History</h4>
                                    <div class="bg-default text-dark border-0 mb-4" role="alert">
                                        List of transactions from your customer's purchase.
                                    </div>

                                    <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap" id="products-datatable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Order Ref No.</th>
                                                <th>Member User ID</th>
                                                <th>Product Name</th>
                                                <th>Status</th>
                                                <th>Date Purchased</th>
                                                        <!-- <th style="width: 75px;">Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="_tx_tbl">
                                                    
                                        </tbody>
                                    </table>
                                    <div class="mt-3">
                                        <div id="_tx_tbl_pagination"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- container -->
                </div> <!-- content -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

            <div id="_process_purchase_modal" data-bs-backdrop="static" data-bs-keyboard="false" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-shopping-trolley"></i> <span id="_modal_title">Process Purchase</span></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        
                            <div class="modal-body mb-3">
                                
                                
                                <div id="_choose_btn_wrapper" class="">
                                    <div>
                                        Choose if the buyer is a member of Herbal House choose "Member Buyer" if not choose "Non-Member Buyer".
                                    </div>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-lg font-17 rounded btn-success mt-1" id="_member_buyer_btn">Member Buyer</button>
                                        <button type="button" class="btn btn-primary btn-lg font-17 rounded mt-1" id="_non_member_buyer_btn">Non-Member Buyer</button>
                                    </div>
                                </div>

                                <div id="_non_member_buyer" hidden="hidden">
                                    <div class="alert alert-success bg-success text-white border-0" role="alert">
                                        For non-member buyers, choose what Product to purchase, input the Quantity, and Submit.
                                    </div>
                                    <div class="mt-3">
                                        <label>Product Name</label>
                                        <select class="form-control select2" name="product" data-toggle="select2" id="__select_product2">
                                            <option disabled="" selected="">Select Product</option>
                                        </select>
                                    </div>
                                    <div class="mt-3">
                                        <label>Quantity</label>
                                        <input type="number" class="form-control mt-1" id="__qty" name="qty" placeholder="Product Qty" >
                                    </div>

                                </div>

                                <div id="_user_member" hidden="hidden">
                                    <div class="alert alert-success bg-success text-white border-0" role="alert">
                                        Search or scan the QR code of the user (Member of Herbal House). Choose what Product to purchase, input the Quantity, and Submit.
                                    </div>
                                    <form id="_search_user_form">
                                        <div class="dropdown mt-3">
                                            <label>Search User</label>
                                            <input type="text" class="form-control dropdown-toggle mt-1" id="search_code_name" name="code_name" placeholder="Search Name/User ID/Mobile number">
                                                <div class="dropdown-menu dropdown-menu-animated dropdown-lg search-user-dropdown" id="search_user_dropdown">
                                                <div id="_member_search" class="mb-1 mt-1">
                                                                <!-- item-->
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-success rounded mt-1 float-right"><i class="uil-search"></i> Search</button>
                                            <button type="button" class="btn btn-success rounded mt-1 float-right"><i class="mdi mdi-qrcode"></i> Scan QR Code</button>
                                        </div>
                                    </form>

                                    <div class="mt-3">
                                        <label>User Full Name</label>
                                        <input type="text" class="form-control" id="_user_name" name="user_name" placeholder="User Full Name" readonly="">
                                    </div>

                                    <div class="mt-2 mb-3">
                                        <label>User ID</label>
                                        <input type="text" class="form-control" id="_user_code" name="user_code" placeholder="User ID" readonly="">
                                    </div>
                                    <hr>


                                    <div class="mt-3">
                                        <label>Product Name</label>
                                        <select class="form-control select2" name="product" data-toggle="select2" id="_select_product">
                                            <option disabled="" selected="">Select Product</option>
                                        </select>
                                    </div>


                                    <div class="mt-3">
                                        <label>Quantity</label>
                                        <input type="number" class="form-control mt-1" id="_qty" name="qty" placeholder="Product Qty">
                                    </div>

                                </div>
                                <input type="hidden" name="type"  id="_type">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success btn-lg font-17 rounded mt-1" id="_process_purchase_stockist_btn">Process Purchase</button>
                                <button type="button" class="btn btn-success btn-lg font-17 rounded mt-1" id="_process_purchase_stockist_non_member_btn" hidden="hidden">Process Purchase</button>
                                <button type="button" class="btn btn-lg font-17 rounded btn-light" data-bs-dismiss="modal">Close</button>
                            </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal --> 
        </div>



        <!-- END wrapper -->

