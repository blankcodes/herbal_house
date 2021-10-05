
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div id="_to_do_order">
                            
                        </div>

                        <div id="_to_do_wr" >
                            
                        </div>


                        <div class="row">
                            <div class="col-xl-6 col-lg-6">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-end">
                                                    <i class="uil-users-alt widget-icon"></i>
                                                </div>
                                                <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Members</h5>
                                                <h3 class="mt-3 mb-3" id="_members_count">0</h3>
                                                <!-- <p class="mb-0 text-muted">
                                                    <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                                                    <span class="text-nowrap">Since last month</span>  
                                                </p> -->
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-end">
                                                    <i class="uil-shopping-cart-alt widget-icon"></i>
                                                </div>
                                                <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Orders Today</h5>
                                                <h3 class="mt-3 mb-3" id="_orders_today_count">0</h3>
                                                <!-- <p class="mb-0 text-muted">
                                                    <span class="text-danger me-2"><i class="mdi mdi-arrow-down-bold"></i> 1.08%</span>
                                                    <span class="text-nowrap">Since last month</span>
                                                </p> -->
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-end">
                                                    <i class="uil-shopping-trolley widget-icon"></i>
                                                </div>
                                                <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Complete Orders</h5>
                                                <h3 class="mt-3 mb-3" id="_orders_count">0</h3>
                                                <!-- <p class="mb-0 text-muted">
                                                    <span class="text-danger me-2"><i class="mdi mdi-arrow-down-bold"></i> 1.08%</span>
                                                    <span class="text-nowrap">Since last month</span>
                                                </p> -->
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-end">
                                                    <span class=" widget-icon"><i class="uil-money-withdrawal"></i></span>
                                                </div>
                                                <h5 class="text-muted fw-normal mt-0" title="Average Revenue">Withdrawal Request</h5>
                                                <h3 class="mt-3 mb-3" id="_withdraw_request">₱ 0.00</h3>
                                                <!-- <p class="mb-0 text-muted">
                                                    <span class="text-danger me-2"><i class="mdi mdi-arrow-down-bold"></i> 7.00%</span>
                                                    <span class="text-nowrap">Since last month</span>
                                                </p> -->
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                </div> <!-- end row -->


                            </div> <!-- end col -->

                            <div class="col-xl-6 col-lg-6">
                                <div class="card card-h-100">
                                    <div class="card-body">
                                        <!-- <div class="dropdown float-end">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="javascript:void(0);" class="dropdown-item">Today</a>
                                                <a href="javascript:void(0);" class="dropdown-item">Yesterday</a>
                                                <a href="javascript:void(0);" class="dropdown-item">Last 7 Days</a>
                                                <a href="javascript:void(0);" class="dropdown-item">This month</a>
                                                <a href="javascript:void(0);" class="dropdown-item">Overall</a>
                                            </div>
                                        </div>
                                        <h4 class="header-title mb-3">Order Statistics</h4> -->

                                        <div dir="ltr" id="order_chart">
                                            <div id="high-performing-product" class="apex-charts" data-colors="#727cf5,#e3eaef"></div>
                                        </div>
                                            
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="card">
                            <div class="card-body">
                                <div class="mt-4">
                                    <h4><i class="uil-shopping-cart-alt"></i> Orders &nbsp;<a href="<?=base_url('ecom/orders')?>" class="btn btn-success btn-sm rounded">Process Orders <i class="uil-arrow-right"></i></a></h4>
                                    <div class="table-responsive">
                                        <table class="table table-centered mb-0 font-13">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order Ref No.</th>
                                                    <th>Order Status</th>
                                                    <th>Member <i class="uil-question-circle pointer-cursor" data-toggle="tooltip" data-placement="top" title="The member (Username) who purchase this order." class="uil-question-circle pointer-cursor"></i></th>
                                                    <th>Sales</th>
                                                    <th>Payment Method</th>
                                                    <th>Payment Status</th>
                                                    <th>Referrer <i class="uil-question-circle pointer-cursor" data-toggle="tooltip" data-placement="top" title="The member (Username) who gave its product URL to a non-member user." class="uil-question-circle pointer-cursor"></i></th>
                                                    <th>Ordered Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="orders_tbl">
                                                            
                                            </tbody>
                                        </table>
                                        <div class="mt-1" id="order_pagination">
                                                        
                                       </div>
                                    </div>
                               </div>
                            </div>
                        </div>
                        

                        <div class="card">
                            <div class="card-body">
                                <div class="mt-5">
                                    <h4><i class="uil-money-withdrawal"></i> Withdrawal Request &nbsp;<a href="<?=base_url('withdraw-request')?>" class="btn btn-success btn-sm rounded">Process Requests <i class="uil-arrow-right"></i></a></h4>
                                    <div class="table-responsive">
                                        <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap font-13" id="products-datatable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Reference no.</th>
                                                    <th>User ID</th>
                                                    <th>Amount</th>
                                                    <th>Payment Method</th>
                                                    <th>Acct. Name</th>
                                                    <th>Acct. Number</th>
                                                    <th>Status</th>
                                                    <th>Date Requested</th>
                                                </tr>
                                            </thead>
                                            <tbody id="_withdraw_request_tbl">
                                                
                                            </tbody>
                                        </table>
                                        <div class="mt-2" id="_withdraw_request_pagination"></div>
                                    </div>
                               </div>
                            </div>
                        </div>
                        



                        <!-- end row -->
                    </div> <!-- container -->

                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

