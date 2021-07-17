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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Register New Direct Invite</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Register New Direct Invite</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <?php if ($userData['website_invites_status'] == 'inactive'){ ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close font-12" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Notice: </strong> Start Earning by Activating your account! Click <a data-bs-toggle="modal" data-bs-target="#payment_modal" href="#click_here" >here</a>.
                            </div>
                        <?php } ?>

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


                        <div>
                            <div class="row">
                                <div class="col-lg-12 row">
                                    <form id="register_invite_form">

                                        <div class=" mt-4">
                                            <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" role="alert" id="_package_details" hidden="hidden">
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                <b class="fw-600">Package Details:</b>
                                                <div class="mt-2">
                                                    Package Name: <span class="fw-500" id="_package_name_details"></span>
                                                </div>
                                                <div>
                                                    Activation Code: <span class="fw-500" id="_package_code_details"></span>
                                                </div>
                                            </div>

                                            <label class="fw-500 mb-1">Select Package</label>
                                            <select class="form-control select2" name="" data-toggle="select2" id="_select_package" required="">
                                                <option disabled="" selected="">Select Package</option>
                                                <?php foreach ($packageCredit as $p ){ ?>
                                                <option value="<?=$p['code']?>"><?=$p['package_name']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <input type="hidden" id="_package_code" name="package_code" value="" required>
                                        <div class="form-floating mb-2 mt-2">
                                            <input type="text" class="form-control" name="username" value="" id="username" placeholder="Enter username" required autofocus="autofocus" />
                                            <label for="username" class="fw-400">Username</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" name="fname" value="" id="fname" placeholder="Enter First Name" required />
                                            <label for="fname" class="fw-400">First Name</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" name="lname" value="" id="lname" placeholder="Enter Last Name" required />
                                            <label for="lname" class="fw-400">Last Name</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input type="text" maxlength="11" class="form-control" name="mobile_number" value="09" id="mobile_number" placeholder="Enter Mobile Number" required  />
                                            <label for="mobile_number" class="fw-400">Mobile Number</label>
                                        </div>

                                        <div class="form-floating">
                                            <input type="password" class="form-control" name="password" value="123456" id="password" placeholder="Enter Password" required autofocus="autofocus" />
                                            <label for="password" class="fw-400">Password</label>
                                            <small>*Default password is 123456</small>
                                            <div class="mt-2 pointer-cursor" data-password="false">
                                                <span class="password-eye pointer-cursor"></span> <small id="show_pass_reg">Show/Hide Password</small>
                                            </div>
                                        </div>
       
                                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                        <div class="mb-3">
                                            <button class="btn btn-success rounded btn-lg mt-4" type="submit" id="register_user_btn"> Register User</button>
                                        </div>

                                    </form>
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

