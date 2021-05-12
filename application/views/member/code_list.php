
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Code List</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Code List</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="mt-2">
                                                <div class="col-lg-3 col-12 col-md-6">
                                                    <div class="card widget-flat">
                                                        <div class="card-body">
                                                            <div class="float-end">
                                                                <i class="mdi mdi-account-multiple-plus widget-icon"></i>
                                                            </div>
                                                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Code Credits</h5>
                                                            <h3 class="mt-3 mb-3" id="_code_credits">0</h3>
                                                        </div> <!-- end card-body-->
                                                    </div> <!-- end card-->
                                                </div> <!-- end col-->
                                            </div>

                                            <div class="col-sm-4">
                                            </div>
                                            <div class="col-sm-8">
                                               <!--  <div class="text-sm-end">
                                                    <button type="button" class="btn btn-light mb-2" onclick="showCodeHistory(1)">Refresh</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div> -->
                                            </div><!-- end col-->
                                        </div>
 
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->



                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-4">
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <button type="button" class="btn btn-light mb-2" onclick="showMemberCodes(1)">Refresh</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>
                                        
                                        <div class="table-responsive mt-1">
                                            <h3 class="font-21">Available Activation Codes</h3>
                                            <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap mt-2" id="">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 20px;">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                            </div>
                                                        </th>
                                                        <th>Code</th>
                                                        <th>Package Name</th>
                                                        <th>Date Purchased</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="_avail_code_tbl">
                                                    
                                                   
                                                </tbody>
                                            </table>
                                            <div class="mt-3">
                                                <div id="_avail_code_pagination"></div>
                                            </div>
                                        </div>

                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-4"> </div>
                                            <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <button type="button" class="btn btn-light mb-2" onclick="showCodeHistory(1)">Refresh</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>

                                        <div class="table-responsive mt-1">
                                            <h3 class="font-21">Code History</h3>
                                            <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap mt-2" id="">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 20px;">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                            </div>
                                                        </th>
                                                        <th>Code</th>
                                                        <th>Package Name</th>
                                                        <th>Date Purchased</th>
                                                        <th>Date Used</th>
                                                        <th>Used by</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="_code_history_tbl">
                                                    
                                                   
                                                </tbody>
                                            </table>
                                            <div class="mt-3">
                                                <div id="_code_history_pagination"></div>
                                            </div>
                                        </div>

                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
            <div id="send_to_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-message"></i> <span id="_modal_title">Transfer Activation Code</span></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <form id="search_code_name_form">
                            <div class="modal-body mb-3">
                                <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                    Search using Member Name, Mobile Number or User Code and click "Transfer Code" button.
                                    <div class="mt-2">
                                        Note that this action's cannot be undone once transfered, not unless the receiver send back the code to you
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <input type="text" class="form-control dropdown-toggle mt-2" id="search_code_name" name="code_name" placeholder="Search Name/User Code/Mobile number">
                                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg search-user-dropdown" id="search_user_dropdown">
                                        <div id="_member_search" class="mb-1 mt-1">
                                                        <!-- item-->
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success rounded mt-1 float-right">Search</button>
                                </div>
                                            
                                <div class="mt-3">
                                    <label>User Full Name</label>
                                    <input type="text" class="form-control" id="_user_name" name="user_name" placeholder="User Full Name" readonly="">
                                </div>

                                <div class="mt-2">
                                    <label>User Code</label>
                                    <input type="text" class="form-control" id="_user_code" name="user_code" placeholder="User Code" readonly="">
                                </div>

                                <div class="mt-2">
                                    <label>Activation Code for Refered users</label>
                                    <input type="text" class="form-control"  id="_activation_code" name="activation_code" readonly="">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success btn-rounded mt-1" id="_send_member_code_btn">Transfer Code</button>
                                <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
        <!-- END wrapper -->



