
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
                                            <div class="col-sm-4">
                                                <a href="javascript:void(0);" id="_add_member" class="btn btn-success mb-2"><i class="mdi mdi-plus-circle me-2"></i> Add Member</a>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <button type="button" class="btn btn-light mb-2" onclick="showMemberList(1)">Refresh</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>
                
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
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Mobile Number</th>
                                                        <th>User Type</th>
                                                        <th>Date Registered</th>
                                                        <th style="width: 75px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="_member_list_tbl">
                                                    
                                                   
                                                </tbody>
                                            </table>
                                            <div id="member_list_pagination" class="mt-2">
                                                
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
                                                </select>
                                            </div>

                                            <div class="mb-2 mt-2" id="package_id" hidden="hidden">
                                                <select class="form-control select2" name="package" data-toggle="select2" id="_select_package">
                                                    <!-- <option disabled="" selected="">Select Package</option>
                                                    <?php foreach ($package as $p ){ ?>
                                                    <option value="<?=$p['p_id']?>"><?=$p['name']?></option>
                                                    <?php } ?> -->
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
                                                    <small><span class="password-eye pointer-cursor"></span> Show Password</small>
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
                    </div> <!-- container -->

                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

