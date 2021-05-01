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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Register New Member</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Register New Member</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div>
                            <div class="row">
                                <div class="col-lg-12 row">
                                    <form id="register_direct_form">

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
                                            <input type="text" maxlength="11" class="form-control" name="mobile_number" value="" id="mobile_number" placeholder="Enter Mobile Number" required  />
                                            <label for="mobile_number" class="fw-400">Mobile Number</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" readonly="" name="position" id="position" placeholder="Enter Position" value="<?=$position?>" required  />
                                            <label for="position" class="fw-400">Position</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input class="form-control" type="text" readonly="" id="sponsor" name="sponsor" required placeholder="Sponsor" value="<?=$sponsorData['fname'].' '.$sponsorData['lname']?>"/>
                                            <label for="sponsor" class="fw-400">Sponsor</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input class="form-control" type="text" readonly="" name="link_user" id="link_user" required placeholder="Link User" value="<?=$linkData['fname'].' '.$linkData['lname']?>"/>
                                            <label for="link_user" class="fw-400">Link User</label>
                                        </div>

                                        <div class="form-floating">
                                            <input type="password" class="form-control" name="password" value="" id="password" placeholder="Enter Password" required autofocus="autofocus" />
                                            <label for="password" class="fw-400">Password</label>
                                            
                                            <div class="mt-2 pointer-cursor" data-password="false">
                                                <small><span class="password-eye pointer-cursor"></span> Show Password</small>
                                            </div>
                                        </div>

                                     
<!-- 
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye pointer-cursor"></span>
                                                </div>
                                            </div>
                                        </div> -->
                                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                        <input type="hidden" name="sponsorID" value="<?=$sponsorID;?>" />
                                        <input type="hidden" name="linkID" value="<?=$linkID;?>" />
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

