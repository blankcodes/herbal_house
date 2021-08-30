
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
                        <?php if ($userData['website_invites_status'] == 'inactive'){ ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close font-12" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Notice: </strong> Start Earning by Activating your account! Click <a href="#click_here" onclick="paymentInfo()">here</a>.
                            </div>
                        <?php } ?>

                        <?php if ($order_check > 0){ ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close font-12" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Notice: </strong> You have active Order/s that needs to be Packed or Shipped! Go to <a href="<?=base_url('member/customer-orders')?>">Customer's Orders</a>.
                            </div>
                        <?php } ?>

                        <?php if ($password_check == 'unchange'){ ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close font-12" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Notice: </strong> You're still using the default password. We recommend to change it for the security of your account. Go to <a href="<?=base_url('member/settings')?>">Settings</a>.
                            </div>
                        <?php } ?>

                        <?php if (empty($userData['email_address'])){ ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close font-12" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Notice: </strong> You didn't set up your email address yet, kindly Set it to notify you in every activity you will make! Go to <a href="<?=base_url('member/settings')?>">Settings</a>.
                            </div>
                        <?php } ?>
                        <div class="row">

                            <div class="">
                                <div class="col-sm-12">
                                    <!-- Profile -->
                                    <div class="card bg- profile-user-box">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto col-12 col-lg-2 col-md-4">
                                                            <div class="avatar-lg">
                                                                <!-- <a href=""><img src="assets/images/users/avatar-2.jpg" alt="" class="rounded-circle img-thumbnail"></a> -->
                                                                <?php if (!empty($userData['image'])){ ?>
                                                                 <img src="<?=base_url().$userData['image']?>" id="profile_image_thumbnail" class="rounded-circle profile-image-thumbnail"/>
                                                                <?php } else{ ?>
                                                                <img src="<?=base_url('assets/images/blank-profile-img.png')?>" alt="thumbnail" id="profile_image_thumbnail" class="rounded-circle img profile-image-thumbnail"/>
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
                                                                        <h5 class="mb-1" id="_total_revenue">₱ 0.00</h5>
                                                                        <p class="mb-0 font-13 text-white-50">Total Revenue</p>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <h5 class="mb-1" id="_order_count">0</h5>
                                                                        <p class="mb-0 font-13 text-white-50">Number of Orders</p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- end col-->

                                                <div class="col-sm-4">
                                                    <div class="text-center mt-sm-0 mt-3 text-sm-end">
                                                        <button onclick="earnMore('<?=$userData['user_code']?>')" class="btn btn-success btn-sm font-12 mt-1">
                                                            <i class="mdi mdi-cash-multiple me-1"></i> Earn More
                                                        </button>
                                                        <a href="<?=base_url()?>member/settings" class="btn btn-primary btn-sm font-12 mt-1">
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
                                <div class="mt-4">
                                    <h4><i class="uil-shopping-cart-alt"></i> Repeat Purchase Activity</h4>
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
                                        <div class="mt-2" id="_repeat_purchase_pagination"></div>
                                    </div>
                               </div>
                            </div>
                        </div>


                       <div id="qr_code_modal" data-bs-backdrop="static" data-bs-keyboard="false" class="modal fade rounded" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md ">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="mdi mdi-qrcode"></i> <span id="_modal_title">Scan QR Code</span></h4>
                                        <button type="button" class="btn-close" id="_qr_modal_close_btn" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body mb-3">
                                        <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                               Use this QR Code when you purchase products through walk-in process. 
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div id="qr_code" class="mt-1 col-lg-8" title="QR Code">
                                                <img src="">
                                            </div>
                                            <div class="mt-1 text-center">
                                                <p>Scan QR Code</p>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-rounded btn-light" id="__qr_modal_close_btn" data-bs-dismiss="modal">Close</button>
                                    </div>
                                 </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->

                        <div id="earn_more_modal" data-bs-backdrop="static" data-bs-keyboard="false" class="modal fade rounded" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="mdi mdi-cash-multiple"></i> <span id="_modal_title">Affiliate Program</span></h4>
                                        <button type="button" class="btn-close" id="_qr_modal_close_btn" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body mb-3">
                                        <div id="_aff_alert_div" hidden="hidden" class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <div id="_aff_alert_message"></div>
                                        </div>

                                        <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                            Use your affiliate link to earn more. Get ₱ 1,000 from anyone who register using your affiliate link and activate their account.
                                        </div>
                                        <div class="mt-2">
                                            <div class="form-floating mb-2 mt-2">
                                                <input type="text" class="form-control" value="" id="_aff_link" />
                                                <label for="" class="fw-400">Affiliate Link</label>
                                            </div>
                                            <div class="mt-2 text-end">
                                                <button id="copy_url_btn" class="btn btn-success btn-sm rounded"> <i class="uil-copy"></i> Copy</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn rounded btn-light" id="__qr_modal_close_btn" data-bs-dismiss="modal">Close</button>
                                    </div>
                                 </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->

                        <div id="payment_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-info-circle"></i> <span id="_modal_title">Payment Information</span></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div id="">
                                        <div class="modal-body mb-3">
                                            <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                                Make sure to pay exact amount of <span class="font-20 fw-600">₱ 2,499</span> and contact us through text/call <a href="tel:09667618942">+63 966 761 8942</a> or email us at <a href="mailto:herbalhouseph@gmail.com">herbalhouseph@gmail.com</a>. <br><br>
                                                Message us your User ID, mobile number, account name and dont forget to include the screenshot or transaction reference number of your payment.
                                            </div>

                                            <div class="mt-2">
                                                Payment Method: <br><span id="_review_pay_method" class="font-25 fw-600"> Gcash</span>
                                            </div>

                                            <div class="mt-2">
                                                Account Number: <br><span id="_review_acct_num" class="font-25 fw-600"> 09955441680</span>
                                            </div>

                                            <div class="mt-2">
                                                Account Name: <br><span id="_review_acct_name" class="font-25 fw-600"> Mark Joseph Susaya</span>
                                            </div>

                                        </div>
                                        <div class="modal-footer mb-2">
                                            <button type="button" class="btn rounded btn-lg rounded font-15 btn-light" data-bs-dismiss="modal" >Close</button>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <div id="_news_earn_more_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-info-circle"></i> <span id="_modal_title">Ways to Earn More!</span></h4>
                                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div id="">
                                        <div class="modal-body mb-3">
                                            <img src="<?=base_url('assets/images/earn-more.jpg')?>" class="img-fluid br-10" alt="earn more">
                                            <div class="alert alert-light bg-light text-dark border-0 mt-2" role="alert">
                                                <p>You can now use your Affiliate Link to invite your friends, family and anyone on the internet!</p>
                                                <p>What you will only do is to share your Affiliate link which can be seen on <a href="<?=base_url('member/membership')?>" target="_blank">Membership Page</a>. </p> 
                                                <p>You can include your Affiliate Link on your posts that is related to Herbal House Philippines on your social media accounts. You may use the marketing materials available on the Membership Page as well.</p>
                                            </div>

                                        </div>
                                        <div class="modal-footer mb-2">
                                            <button type="button" class="btn rounded btn-lg rounded font-15 btn-light " data-bs-dismiss="modal" >Close</button>
                                        </div>
                                    </div>
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

