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

                        <div class="row mb-5">
                            <div class="col-lg-6 mt-3">
                                <form id="_account_profile_form">
                                    <h2 class="font-22 fw-600"><i class="uil-image"></i> Update Profile</h2>
                                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                    <div class="col-md-12 col-xs-12 mb-2 profile-image-upload">
                                        <label for="profile_image">
                                            <?php if (!empty($userData['image'])){ ?>
                                            <img src="<?=base_url().$userData['image']?>" id="profile_image_thumbnail"  class="rounded-circle  profile-image-thumbnail-settings pointer-cursor"/>
                                            <?php } else{ ?>
                                            <img src="<?=base_url('assets/images/blank-profile-img.png')?>" alt="thumbnail" id="profile_image_thumbnail" class="rounded-circle profile-image-thumbnail pointer-cursor"/>
                                            <?php } ?>
                                        </label>
                                        <input onchange="readURL(this)" type="file" id="profile_image" name="profile_image" class="profile-image-thumbnail"  />
                                     </div>
                                     <small class="mt-2">Can upload Max of 2 MB, and max of 1000px per width and height.</small>
                                    <div class="mt-1">
                                        <button class="btn btn-lg btn-primary rounded font-15 k-btn" type="submit" id="_update_profile">Upload Profile</button>
                                    </div>
                                </form>
                            </div>



                            <div class="col-lg-6 mt-3">
                                <form id="_account_username_form">
                                    <h2 class="font-22 fw-600"><i class="uil-edit"></i> Update Username</h2>
                                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                    <?php if ($userData['user_type'] == 'member'){ ?>
                                    <div class="alert bg-white fade show c-black" role="alert">
                                        Note that updating your Username will affect your Shop's URL. Your previous product URLs will not work due to this change. <br>

                                        After this change, make sure you share the new <a href="<?=base_url('member/products')?>" target="_blank" rel="noopener">product URL</a> to your previous buyers and update your existing marketing materials posted on various social media websites. . 
                                    </div>
                                    <?php } ?>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" name="username" value="<?=$userData['username']?>" id="floatingInput" placeholder="User ID"  />
                                        <label for="floatingInput" class="fw-400">Username</label>
                                    </div>
                                    <div class="mt-2">
                                        <button class="btn btn-lg btn-primary rounded font-15 k-btn" type="submit" id="_update_username_btn">Update</button>
                                    </div>
                                </form>
                            </div>

                            <div class="col-lg-6 mt-3">
                                <form id="_account_password_form">
                                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                    <h2 class="font-22 fw-600"><i class="uil-lock"></i> Update Password</h2>
                                    <div class="form-floating mb-2">
                                        <input type="password" class="form-control" id="floatingInput" name="old_pass" placeholder="Old Password" required/>
                                        <label for="floatingInput" class="fw-400">Old Password</label>
                                    </div>

                                   <div class="form-floating mb-2">
                                        <input type="password" class="form-control"  id="floatingInput" name="new_pass" placeholder="New Password" required/>
                                        <label for="floatingInput" class="fw-400">New Password</label>
                                    </div>

                                    <div class="form-floating mb-2">
                                        <input type="password" class="form-control"  id="floatingInput" name="confirm_pass" placeholder="Confirm New Password" required/>
                                        <label for="floatingInput" class="fw-400">Confirm New Password</label>
                                    </div>
                                    <div class="mt-2">
                                        <div class="mt-2 pointer-cursor">
                                            <small id="show_password"><span class="pointer-cursor" ></span><i class="uil-eye "></i> Show Password</small>
                                            <small hidden id="hide_password"><span class="pointer-cursor" ></span><i class="uil-eye-slash "></i> Hide Password</small>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <button class="btn btn-lg btn-primary rounded font-15 k-btn" type="submit" id="_change_pass_btn">Change Password</button>
                                    </div>
                                </form>
                            </div>


                            <div class="col-lg-6 mt-3">
                                <form id="_account_settings_form">
                                    <h2 class="font-22 fw-600"><i class="uil-edit"></i> Update Account Info</h2>
                                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" name="" value="<?=$userData['user_code']?>" id="floatingInput" placeholder="User ID" readonly />
                                        <label for="floatingInput" class="fw-400">User ID</label>
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
                                        <button class="btn btn-lg btn-primary rounded font-15 k-btn" type="submit" id="_update_acct_btn">Update</button>
                                    </div>
                                </form>
                            </div>

                          
                            <div id="mobile-view" class="margin-top-40"></div>
                            
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

