
                    <!-- end Topbar -->

                    <!-- Start Content-->
                    <div class="container-fluid margin-top-20">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Herbal House</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Walk-in Buyers</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Walk-in Buyers</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-4">
                                                <button class="btn btn-success mb-2" id="_process_walkin_buyer"><i class="uil-shopping-trolley  me-2"></i> Process Walk-in Buyer</button>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <button type="button" class="btn btn-light mb-2" onclick="showWalkinTx(1)">Refresh</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>
                
                                        <div class="table-responsive">
                                            <h4>Transaction History</h4>
                                            <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap" id="products-datatable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 20px;">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                            </div>
                                                        </th>
                                                        <th>Order Ref No.</th>
                                                        <th>Member User ID</th>
                                                        <th>Product Name</th>
                                                        <th>Status</th>
                                                        <th>Date Added</th>
                                                        <!-- <th style="width: 75px;">Action</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody id="_walkin_tx_tbl">
                                                    
                                                   
                                                </tbody>
                                            </table>
                                            <div class="mt-3">
                                                <div id="_code_pagination"></div>
                                            </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->


                        <div id="walkin_buy_modal" data-bs-backdrop="static" data-bs-keyboard="false" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-shopping-trolley"></i> <span id="_modal_title">Walk-in Product Purchase</span></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <form id="search_code_name_form">
                                        <div class="modal-body mb-3">
                                            <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                               Walk-in product repeat purchase. Choose what product to purchase, input the quantity, and search or scan the QR code of the user.
                                            </div>


                                            <div class="dropdown mt-3">
                                                <label>Search User</label>
                                                <input type="text" class="form-control dropdown-toggle mt-1" id="search_code_name" name="code_name" placeholder="Search Name/User ID/Mobile number">
                                                 <div class="dropdown-menu dropdown-menu-animated dropdown-lg search-user-dropdown" id="search_user_dropdown">
                                                    <div id="_member_search" class="mb-1 mt-1">
                                                        <!-- item-->
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-success rounded mt-1 float-right"><i class="uil-search"></i> Search</button>
                                                <button type="submit" class="btn btn-success rounded mt-1 float-right"><i class="mdi mdi-qrcode"></i> Scan QR Code</button>
                                            </div>

                                            <div class="mt-3">
                                                <label>Product Name</label>
                                                <select class="form-control select2" name="product" data-toggle="select2" id="_select_product">
                                                    <option disabled="" selected="">Select Product</option>
                                                </select>
                                            </div>


                                            <div class="mt-3">
                                                <label>Product Qty</label>
                                                <input type="number" class="form-control mt-1" id="qty" name="qty" placeholder="Product Qty" value="1">
                                            </div>

                                            <hr>
                                            <div class="mt-3">
                                                <label>User Full Name</label>
                                                <input type="text" class="form-control" id="_user_name" name="user_name" placeholder="User Full Name" readonly="">
                                            </div>

                                            <div class="mt-2">
                                                <label>User ID</label>
                                                <input type="text" class="form-control" id="_user_code" name="user_code" placeholder="User ID" readonly="">
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success btn-rounded mt-1" id="_send_product_code_btn">Process Order</button>
                                            <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal --> 
                    </div> <!-- container -->

                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

