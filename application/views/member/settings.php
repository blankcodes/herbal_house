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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Account Settings</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Account Settings</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-lg-6">
                                <form id="_account_settings_form">
                                    <h2 class="font-22 fw-600"><i class="uil-edit"></i> Update Account Info</h2>
                                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" name="fname" value="<?=$userData['fname']?>" id="floatingInput" placeholder="First Name" />
                                        <label for="floatingInput" class="fw-400">First Name</label>
                                    </div>

                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control"  name="lname" value="<?=$userData['lname']?>" id="floatingPassword" placeholder="Last Name" />
                                        <label for="floatingPassword" class="fw-400">Last Name</label>
                                    </div>

                                    <div class="form-floating mb-2">
                                        <input type="email" class="form-control"  name="email_address" value="<?=$userData['email_address']?>" id="floatingPassword" placeholder="Email Address" />
                                        <label for="floatingPassword" class="fw-400">Email Address</label>
                                    </div>

                                    <div class="form-floating mb-2">
                                        <input type="number" class="form-control" name="mobile_number" value="<?=$userData['mobile_number']?>" id="floatingPassword" placeholder="Mobile Number" />
                                        <label for="floatingPassword" class="fw-400">Mobile Number</label>
                                    </div>

                                    <div class="mt-2">
                                        <button class="btn btn-lg btn-primary rounded font-17 k-btn" type="submit" id="_update_acct_btn">Update</button>
                                    </div>
                                </form>
                            </div>

                            <div id="mobile-view" class="margin-top-40"></div>
                            <div class="col-lg-6">
                                <form id="_account_password_form">
                                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                    <h2 class="font-22 fw-600"><i class="uil-lock"></i> Update Password</h2>
                                    <div class="form-floating mb-2">
                                        <input type="password" class="form-control" id="floatingInput" name="old_pass" placeholder="Old Password" />
                                        <label for="floatingInput" class="fw-400">Old Password</label>
                                    </div>

                                   <div class="form-floating mb-2">
                                        <input type="password" class="form-control"  id="floatingInput" name="new_pass" placeholder="New Password" />
                                        <label for="floatingInput" class="fw-400">New Password</label>
                                    </div>

                                    <div class="form-floating mb-2">
                                        <input type="password" class="form-control"  id="floatingInput" name="confirm_pass" placeholder="Confirm New Password" />
                                        <label for="floatingInput" class="fw-400">Confirm New Password</label>
                                    </div>
                                    <div class="mt-2">
                                        <div class="mt-2 pointer-cursor">
                                            <small id="show_password"><span class="pointer-cursor" ></span><i class="uil-eye "></i> Show Password</small>
                                            <small hidden id="hide_password"><span class="pointer-cursor" ></span><i class="uil-eye-slash "></i> Hide Password</small>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <button class="btn btn-lg btn-primary rounded font-17 k-btn" type="submit" id="_change_pass_btn">Change Password</button>
                                    </div>
                                </form>
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

