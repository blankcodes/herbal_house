
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Member List</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Member List</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-6 mb-2">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <a href="javascript:void(0);" id="_add_member" class="btn btn-success mb-2"><i class="mdi mdi-plus-circle me-2"></i> Add Member</a>
                                                    </div>
                                                    <form id="_search_user_form">
                                                        <div class="input-group col-sm-6">
                                                            <input type="text" class="form-control" name="query" id="_search_query" placeholder="Search Username, User ID, Name" aria-label="Recipient's username">
                                                            <button class="btn btn-success" id="_search_user_btn" type="submit"><i class="uil-search"></i> Search</button>
                                                        </div>
                                                   </form>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-2">
                                                <div class="text-sm-end">
                                                    <button type="button" class="btn btn-light mb-2" onclick="showMemberList(1)">Refresh</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>
                
                                        <div class="table-responsive mt-2">
                                            <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap font-12" id="products-datatable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>User ID</th>
                                                        <th>Username</th>
                                                        <th>Referrer</th>
                                                        <th>Credits</th>
                                                        <th>Mobile Number</th>
                                                        <th>Status</th>
                                                        <th>Date Registered</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="_member_list_tbl">
                                                    
                                                   
                                                </tbody>
                                            </table>
                                            <div id="member_list_pagination" class="mt-2">
                                                
                                            </div>
                                            <div hidden id="_search_member_list_pagination" class="mt-2">
                                                
                                            </div>

                                            <div id="" class="text-sm-end">
                                                Total Count: <span id="_member_count"></span>
                                            </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div id="add_member_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header modal-colored-header bg-success">
                                        <h4 class="modal-title" id="success-header-modalLabel"><i class="uil-user-plus"></i> Add New Member</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="_register_new_member_form">
                                            <div class=" mt-2">
                                                <select class="form-control select2" name="user_type" data-toggle="select2" id="user_type" required="">
                                                    <option disabled="" selected="">Select User Type</option>
                                                    <option value="member">Member</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="investor">Investor</option>
                                                </select>
                                            </div>

                                            <div class="mb-2 mt-2" id="package_id" hidden="hidden">
                                                <select class="form-control select2" name="package" data-toggle="select2" id="_select_package">
                                                    
                                                </select>
                                            </div>

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

                                            <div class="form-floating">
                                                <input type="password" class="form-control" name="password" value="123456" id="password" placeholder="Enter Password" required autofocus="autofocus" />
                                                <label for="password" class="fw-400">Password</label>
                                                <small class="">*Default password is 123456</small>
                                                <div class="mt-2 pointer-cursor" data-password="false">
                                                    <small><span class="password-eye pointer-cursor"></span> Show/Hide Password</small>
                                                </div>
                                            </div>

                                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                            <div class="modal-footer mt-3">
                                                <button type="submit" class="btn btn-success btn-rounded" id="add_new_member">Register Member</button>
                                                <button type="button" class="btn btn-light btn-rounded" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>

                                    </div>
                                   
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <div id="change_user_package_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header modal-colored-header bg-success">
                                        <h4 class="modal-title" id="success-header-modalLabel"><i class="uil-user-plus"></i> Change Package</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="_change_package_form">
                                          
                                            <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                               This will effect when this user refer someone, he will get the amount declared on the package.
                                            </div>
                                            <div class="form-floating" class="mb-2 mt-2" >
                                                <select class="form-select" id="__select_package" name="package" required="">
                                                          
                                                </select>
                                                <label for="__select_package">Select Package</label>
                                            </div>

                                            <input type="hidden" name="user_code" id="_user_code" >
                                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                                            <div class="modal-footer mt-3">
                                                <button type="submit" class="btn btn-success btn-rounded" id="add_new_member">Change package</button>
                                                <button type="button" class="btn btn-light btn-rounded" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>

                                    </div>
                                   
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->



                        <div id="user_info_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-user font-23"></i> <span id="_modal_title"></span></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div id="">
                                        <div class="modal-body mb-3">
                                            <form id="_user_payment_status_form">
                                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                                <div id="_status_wrapper">
                                                
                                                </div>

                                            </form>
                                            
                                            <div id="_package_wrapper">
                                                
                                            </div>

                                            <label class="font-18">Personal Information</label>
                                            <div class="mt-2">
                                                User ID: <br><span id="_user_id" class="font-23 fw-600"> </span>
                                            </div>

                                            <div class="mt-2">
                                                Full Name: <br><span id="_full_name" class="font-23 fw-600"> </span>
                                            </div>

                                            <div class="mt-2">
                                                Mobile Number: <br><span id="_mobile_number" class="font-23 fw-600"> </span>
                                            </div>

                                            <div class="mt-2">
                                                Email Address: <br><span id="_email_address" class="font-23 fw-600"> </span>
                                            </div>

                                            <div class="mt-2">
                                                Address: <br><span id="_address" class="font-23 fw-600"> </span>
                                            </div>

                                            <div id="_referrer_wrapper">
                                                
                                            </div>

                                        </div>
                                        <div class="modal-footer mb-2">
                                            <button type="button" class="btn btn-rounded btn-lg rounded font-15 btn-light" id="" data-bs-dismiss="modal" >Close</button>
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

