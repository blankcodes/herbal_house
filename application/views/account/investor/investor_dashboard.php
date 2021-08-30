
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

                        <div class="row">
                            <div class="col-xl-12 col-lg-12">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card text-white bg-success overflow-hidden">
                                            <div class="card-body">
                                                <h4 class="header-title mb-2 text-capitalize">Total Sales</h4>

                                                <div class="toll-free-box text-center pt-2 pb-2">
                                                    <h2 class="font-28"> <i class="uil-usd-circle"></i> <span id="_total_sales">₱ 0.00</span></h2>
                                                </div>
                                            </div> <!-- end card-body-->
                                        </div>
                                    </div> <!-- end col-->

                                    <div class="col-lg-6">
                                        <div class="card text-white bg-success">
                                            <div class="card-body">
                                                <div class="dropdown float-end">
                                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">
                                                        <li onclick="sortMonthSales('01', 'January')" class="dropdown-item pointer-cursor">January</li>
                                                        <li onclick="sortMonthSales('02','February')" class="dropdown-item pointer-cursor">February</li>
                                                        <li onclick="sortMonthSales('03','March')" class="dropdown-item pointer-cursor">March</li>
                                                        <li onclick="sortMonthSales('04','April')" class="dropdown-item pointer-cursor">April</li>
                                                        <li onclick="sortMonthSales('05','May')" class="dropdown-item pointer-cursor">May</li>
                                                        <li onclick="sortMonthSales('06','June')" class="dropdown-item pointer-cursor">June</li>
                                                        <li onclick="sortMonthSales('07','July')" class="dropdown-item pointer-cursor">July</li>
                                                        <li onclick="sortMonthSales('08','August')" class="dropdown-item pointer-cursor">August</li>
                                                        <li onclick="sortMonthSales('09','September')" class="dropdown-item pointer-cursor">September</li>
                                                        <li onclick="sortMonthSales('10','October')" class="dropdown-item pointer-cursor">October</li>
                                                        <li onclick="sortMonthSales('11','November')" class="dropdown-item pointer-cursor">November</li>
                                                        <li onclick="sortMonthSales('12','December')" class="dropdown-item pointer-cursor">December</li>
                                                    </div>
                                                </div>
                                                <h4 class="header-title mb-2 text-capitalize">Monthly Sales (<span id="_month"></span>)</h4>
                                                <div class="toll-free-box text-center pt-2 pb-2">
                                                    <h2 class="font-28"> <i class="uil-usd-circle  "></i> <span id="_monthly_sales">₱ 0.00</span></h2>
                                                </div>
                                            </div> <!-- end card-body-->
                                        </div>
                                    </div> <!-- end col-->

                                </div> <!-- end row -->


                            </div> <!-- end col -->

               

                            <div class="col-xl-12 col-lg-12">
                                <div class="card card-h-100">
                                    <div class="card-body">
                                        <h3 class="header-title mb-2 text-capitalize font-20">Sales Statistics</h3>

                                       <div class=" mb-3">
                                            <form >
                                                <div class="row">
                                                    <div class="col-lg-3 mb-2">
                                                        <label class="form-label">From</label>
                                                        <input type="text" class="form-control date" name="from" value="<?=date('m/d/Y', strtotime('-30 day'))?>" id="_from" data-toggle="date-picker" data-single-date-picker="true">
                                                     </div>

                                                     <div class="col-lg-3 mb-2">
                                                        <label class="form-label">To</label>
                                                        <input type="text" class="form-control date" name="to" id="_to" value="<?=date('m/d/Y')?>" data-toggle="date-picker" data-single-date-picker="true">
                                                     </div>
                                                </div>
                                                 <div class="">
                                                     <button class="btn btn-success btn-md rounded" id="_sort_btn" type="button">Sort</button>
                                                 </div>
                                            </form>
                                       </div>
                                        <div dir="ltr" id="_sales_chart">
                                            <div id="high-performing-product" class="apex-charts" data-colors="#727cf5,#e3eaef"></div>
                                        </div>    
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                            </div> <!-- end col -->


                        </div>
                        <!-- end row -->

                        <div class="card">
                            <div class="card-body">
                                <div class="">
                                    <h4 class="font-20"><i class="uil-shopping-cart-alt"></i> Product Purchase</h4>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <form id="_sort_purchase_form" class="mt-3">
                                                <div class="row">
                                                    <div class="col-lg-4 mb-2">
                                                        <label class="form-label">From</label>
                                                        <input type="text" class="form-control date" value="<?=date('m/d/Y', strtotime('-60 day'))?>" id="_pp_from" data-toggle="date-picker" data-single-date-picker="true">
                                                    </div>

                                                   <div class="col-lg-4 mb-2">
                                                        <label class="form-label">To</label>
                                                        <input type="text" class="form-control date" id="_pp_to" value="<?=date('m/d/Y')?>" data-toggle="date-picker" data-single-date-picker="true">
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <button class="btn btn-success btn-md rounded" id="_sort_purchase_btn" type="button">Sort</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-lg-4 mt-3 text-end">
                                            <div class="text-lg-end">
                                                <button type="button" class="btn btn-light mb-2 margin-top-5" id="_refresh_purchase">Refresh</button>
                                                <button type="button" class="btn btn-light mb-2 margin-top-5">Export</button>
                                            </div>
                                        </div><!-- end col-->
                                    </div>

                                    

                                    <div class="table-responsive mt-3">
                                        <table class="table table-centered mb-0 font-13">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Product Name</th>
                                                    <th>Product Category</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody id="_product_purchase_tbl">
                                                            
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <div class="mt-2" id="_product_purchase_pagination"></div>
                                        </div>
                                        <div class="col-lg-6 text-lg-end">
                                            <div class="mt-2" >Count: <span id="_product_puchase_count"> </span></div>
                                        </div>
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

