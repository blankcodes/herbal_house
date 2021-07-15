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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Invites Lists</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Invites Lists</h4>
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
                                                <a href="<?=base_url('member/register')?>" class="btn btn-success mb-2" id="_process_walkin_buyer"><i class="uil-user-plus  me-2"></i> Add New Direct Invite</a>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <button type="button" class="btn btn-light mb-2" onclick="showDirectList('<?=$userData['user_code']?>', 1)">Refresh</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>
                
                                         <div class="table-responsive mt-3">
                                            <h3 class="font-21">Direct Invites List</h3>
                                            <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap mt-2" id="">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 20px;">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                            </div>
                                                        </th>
                                                        <th>User ID</th>
                                                        <th>Name</th>
                                                        <th>Mobile Number</th>
                                                        <th>Package Name</th>
                                                        <th>Date Registered</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="_direct_invites_tbl">
                                                </tbody>
                                            </table>
                                            <div class="mt-3">
                                                <div id="_direct_invites_pagination"></div>
                                            </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-4 mt-2">
                                                <div class="text-sm-start">
                                                    <select class="form-control select2" name="" data-toggle="select2" id="_select_level" >
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
                                                </div>
                                            </div>
                                            <div class="col-sm-8 mt-2">
                                                <div class="text-sm-end">
                                                    <button type="button" class="btn btn-light mb-2" onclick="showInDirectList(2,'<?=$userData['user_code']?>', 1)">Refresh</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>
                
                                         <div class="table-responsive mt-3">
                                            <h3 class="font-21">Indirect Invites List</h3>
                                            <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap mt-2" id="">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 20px;">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                            </div>
                                                        </th>
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
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        <!-- end row -->
                    </div> <!-- container -->
                </div> <!-- content -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->

