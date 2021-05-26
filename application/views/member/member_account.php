
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
                                    <h4 class="page-title">Welcome to Herbal House! </h4> 
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                       

                       <div class="row">

                            <div class="">
                                <div class="col-sm-12">
                                    <!-- Profile -->
                                    <div class="card bg-success">
                                        <div class="card-body profile-user-box">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto col-12 col-lg-2 col-md-4">
                                                            <div class="avatar-lg">
                                                                <!-- <a href=""><img src="assets/images/users/avatar-2.jpg" alt="" class="rounded-circle img-thumbnail"></a> -->
                                                                <?php if (!empty($userData['image'])){ ?>
                                                                 <img src="<?=base_url().$userData['image']?>" id="profile_image_thumbnail" width="150" height="150" class="rounded-circle img-thumbnail"/>
                                                                <?php } else{ ?>
                                                                <img src="<?=base_url('assets/images/blank-profile-img.png')?>" alt="thumbnail" id="profile_image_thumbnail" width="150" height="150" class="rounded-circle img-thumbnail"/>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div>
                                                                <h4 class="mt-1 mb-1 text-white text-capitalize"><?=$userData['fname'].' '.$userData['lname']?> <br>
                                                                    <span class="font-13 fw-300"><?= (isset($this->session->user_code)) ? '#'.$this->session->user_code : ''?></span></h4>
                                                                <!-- <p class="font-13 text-white-50"> Authorised Distributor</p> -->
                                                                <p class="font-13 text-white-50"> Member</p>
        
                                                                <ul class="mb-0 list-inline text-light">
                                                                    <li class="list-inline-item me-3">
                                                                        <h5 class="mb-1">₱ 0.00</h5>
                                                                        <p class="mb-0 font-13 text-white-50">Total Revenue</p>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <h5 class="mb-1">0</h5>
                                                                        <p class="mb-0 font-13 text-white-50">Number of Orders</p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- end col-->

                                                <div class="col-sm-4">
                                                    <div class="text-center mt-sm-0 mt-3 text-sm-end">
                                                        <a href="<?=base_url()?>member/settings" class="btn btn-light btn-sm">
                                                            <i class="mdi mdi-account-edit me-1"></i> Edit Profile
                                                        </a>
                                                    </div>
                                                </div> <!-- end col-->
                                            </div> <!-- end row -->

                                        </div> <!-- end card-body/ profile-user-box-->
                                    </div><!--end profile/ card -->
                                </div> <!-- end col-->
                            </div>

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="mdi mdi-account-cash widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Cash Wallet</h5>
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
                                            <i class="mdi mdi-account-arrow-left widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Left Side Monitor</h5>
                                        <h3 class="mt-3 mb-3" id="_left_side_monitor">0</h3>
                                        
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="mdi mdi-account-arrow-right widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Right Side Monitor</h5>
                                        <h3 class="mt-3 mb-3" id="_right_side_monitor">0</h3>
                                        
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="mdi mdi-cart-check widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Product Wallet</h5>
                                        <h3 class="mt-3 mb-3" id="_product_wallet">0</h3>
                                        
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="mdi mdi-account-box-multiple widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Fifth Pair</h5>
                                        <h3 class="mt-3 mb-3" id="_fifth_pair">0</h3>
                                        
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="mdi mdi-account-group widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Pair</h5>
                                        <h3 class="mt-3 mb-3" id="_total_pair">0</h3>
                                        
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                       </div>



                       <div class="mt-4">
                            <h4>Product Unilevel Activity</h4>
                            <div class="table-responsive">
                                <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap" id="products-datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20px;">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheck1">
                                                    <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>TXID</th>
                                            <th>Code</th>
                                            <th>Date Paid</th>
                                            <th>Points Earned</th>
                                        </tr>
                                    </thead>
                                    <tbody id="">
                                        
                                    </tbody>
                                </table>
                            </div>
                       </div>

                    </div> <!-- container -->

                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

