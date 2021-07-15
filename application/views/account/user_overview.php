
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title text-capitalize"><i class="uil-user-square"></i> Overview of <?=$userDataOpt['fname'].' '.$userDataOpt['lname']?> (#<?=$userDataOpt['user_code']?>)
                                        <?= ($userDataOpt['website_invites_status'] == 'inactive') ? '<span class="badge bg-danger">Inactive</span>' : '<span class="badge bg-success">Active</span>'; ?>
                                    </h4>  
                                    
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                       

                       <div class="row">

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="uil-wallet widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Main Wallet">Main Wallet</h5>
                                        <h3 class="mt-3 mb-3" id="_cash_wallet">0</h3>
                                        <!-- <p class="mb-0 text-muted">
                                             <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                                            <span class="text-nowrap">Since last month</span>  
                                        </p> -->
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="uil-wallet widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Indirect Referral Wallet">Indirect Referral Wallet</h5>
                                        <h3 class="mt-3 mb-3" id="_indirect_ref_wallet">₱ 0.00</h3>
                                        
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="uil-wallet widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Unilevel Wallet">Unilevel Wallet</h5>
                                        <h3 class="mt-3 mb-3" id="_unilvel_wallet">₱ 0.00</h3>
                                        
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->


                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="uil-users-alt  widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Total Direct Invites">Total Direct Invites</h5>
                                        <h3 class="mt-3 mb-3" id="_direct_users">0</h3>
                                        
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="uil-users-alt  widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Total Indirect Invites">Total Indirect Invites</h5>
                                        <h3 class="mt-3 mb-3" id="_indirect_users">0</h3>
                                        
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="uil-database widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Available Code Credits">Available Code Credits</h5>
                                        <h3 class="mt-3 mb-3" id="_code_credits">0</h3>
                                        
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                       </div>


                       <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-4 mt-2">
                                        <div class="form-floating text-sm-start">
                                           <select class="form-select" id="_select_level" aria-label="Floating label select example">
                                                <option disabled="" selected="">Select Level</option>
                                                <option value="1">Level 1</option>
                                                <option value="2" selected>Level 2</option>
                                                <option value="3">Level 3</option>
                                                <option value="4">Level 4</option>
                                                <option value="5">Level 5</option>
                                                <option value="6">Level 6</option>
                                                <option value="7">Level 7</option>
                                                <option value="8">Level 8</option>
                                                <option value="9">Level 9</option>
                                                <option value="10">Level 10</option>                 
                                            </select>
                                            <label for="_select_level">Select Level</label>
                                        </div>

                                    </div>
                                    <div class="col-sm-8 mt-2">
                                            <div class="text-sm-end">
                                                <button type="button" class="btn btn-light mb-2" onclick="showInDirectList(2,'<?=$userDataOpt['user_code']?>', 1)">Refresh</button>
                                                <button type="button" class="btn btn-light mb-2">Export</button>
                                            </div>
                                        </div><!-- end col-->
                                    </div>
                
                                    <div class="table-responsive mt-3">
                                        <h3 class="font-21"><i class="uil-users-alt"></i> Invites List</h3>
                                        <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap mt-2" id="">
                                        <thead class="table-light">
                                            <tr>
                                                <th>User ID</th>
                                                <th>Name</th>
                                                <th>Date Registered</th>
                                            </tr>
                                        </thead>
                                        <tbody id="_indirect_invites_tbl">
                                        </tbody>
                                    </table>
                                    <div class="mt-3">
                                        <div id="_indirect_invites_pagination"></div>
                                    </div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->


                        <div class="card">
                            <div class="card-body">
                                <div class="mt-4">
                                    <h3 class="font-21"><i class="uil-shopping-cart-alt"></i> Repeat Purchase Activity</h3>
                                    <div class="table-responsive">
                                        <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap font-14" id="products-datatable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 20px;">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="customCheck1">
                                                            <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                        </div>
                                                    </th>
                                                    <th>Order Ref. no.</th>
                                                    <th>Product</th>
                                                    <th>Points Earned</th>
                                                    <th>Date Purchase</th>
                                                </tr>
                                            </thead>
                                            <tbody id="_repeat_purchase_tbl">
                                                
                                            </tbody>
                                        </table>
                                        <div class="mt-2" id="_repeat_purchase_opt_pagination"></div>
                                    </div>
                               </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->

                       
                        <div class="card">
                            <div class="card-body">
                                <div class="mt-4">
                                    <h3 class="font-21"><i class="uil-wallet"></i> Wallet Recent Activity</h3>
                                    <div class="table-responsive">
                                        <table class="table table-centered table-hover w-100 dt-responsive nowrap mt-2" id="">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 20px;">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                            </div>
                                                        </th>
                                                        <th>Date</th>
                                                        <th>Activity</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                    </thead>
                                                 <tbody id="_wallet_activity_tbl">
                                                </tbody>
                                            </table>
                                        <div class="mt-3">
                                            <div id="_wallet_activity_pagination"></div>
                                        </div>
                                    </div>
                               </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->

                    </div> <!-- container -->

                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>


        <!-- END wrapper -->

