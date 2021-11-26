
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Activation Code List</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Activation Code List</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <button class="btn btn-success mb-2" id="_add_code_btn"><i class="mdi mdi-plus-circle me-2"></i> Generate Activation Codes</button>

                                                <button class="btn btn-success mb-2" id="_add_bulk_codes_btn"><i class=" uil-message me-2"></i> Send Multiple Codes</button>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="text-sm-end">
                                                    <button type="button" class="btn btn-light mb-2" onclick="showMemberCodes(1)">Refresh</button>
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
                                                        <th>Code</th>
                                                        <th>Package Name</th>
                                                        <th>User</th>
                                                        <th>Status</th>
                                                        <th>Date Added</th>
                                                        <th style="width: 75px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="_code_list_tbl">
                                                    
                                                   
                                                </tbody>
                                            </table>
                                            <div class="mt-3">
                                                <div id="_code_pagination"></div>
                                            </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div id="generate_code_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-edit"></i> <span id="_modal_title">Generate Activation Codes</span></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <form id="_code_form">
                                    <div class="modal-body mb-3">
                                        <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                            Input a number on how many codes will be generated at once.
                                        </div>
                                        <label>Input numbers</label>
                                        <input type="number" class="form-control mt-2" name="number" placeholder="Ex. 20">
                                        <small>*Numbers on how many activation codes will be generated.</small>
                                        <div class="mt-2">
                                            <label>Package Name</label>
                                            <select class="form-control select2" name="package" data-toggle="select2" id="_select_package" required="">
                                                <option disabled="" selected="">Select Package</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="_generate_code" class="btn btn-rounded btn-success">Generate Codes</button>
                                        <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                                    </div>
                                    </form>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal --> 

                        <div id="send_generate_code_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-edit"></i> <span id="_modal_title">Send Multiple Activation Codes</span></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body mb-3">
                                        <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                            Choose Package and input a number on how many codes will be generated at once.
                                        </div>
                                        <label>Input numbers</label>
                                        <input type="number" class="form-control mt-2" name="qty" id="_mult_qty" placeholder="Ex. 20">
                                        <small>*Numbers on how many activation codes will be send.</small>
                                        <div class="mt-2">
                                            <label>Package Name</label>
                                            <select class="form-control select2" name="package" data-toggle="select2" id="__select_package">
                                                <option disabled="" selected="">Select Package</option>
                                            </select>
                                        </div>

                                        <label class=" mt-2">Send to</label>
                                        <form id="_search_user_name_form">
                                            <div class="dropdown">
                                                <input type="text" class="form-control dropdown-toggle" id="search_user_name_" name="code_name" placeholder="Search Name/User ID/Mobile number">
                                                 <div class="dropdown-menu dropdown-menu-animated dropdown-lg search-user-dropdown" id="__search_user_dropdown">
                                                    <div id="__member_search" class="mb-1 mt-1">
                                                        <!-- item-->
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-success rounded mt-1 float-right">Search</button>
                                            </div>
                                        

                                        <hr>
                                        
                                        <div class="mt-3">
                                            <label>User Full Name</label>
                                            <input type="text" class="form-control" id="__user_name" name="user_name" placeholder="User Full Name"readonly="">
                                        </div>

                                        <div class="mt-2">
                                            <label>User ID</label>
                                            <input type="text" class="form-control" id="__user_code" name="user_code" placeholder="User ID" readonly="">
                                        </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="_send_multiple_codes_btn" class="btn btn-rounded btn-success">Generate Codes</button>
                                        <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal --> 

                        <div id="send_to_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-message"></i> <span id="_modal_title">Send Activation Code to</span></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <form id="search_code_name_form">
                                        <div class="modal-body mb-3">
                                            <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                                Send this code to a member for their direct referral. Search using Member name or User ID and click "Send".
                                            </div>
                                            <div class="dropdown">
                                                <input type="text" class="form-control dropdown-toggle mt-2" id="search_code_name" name="code_name" placeholder="Search Name/User ID/Mobile number">
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
                                                <label>User ID</label>
                                                <input type="text" class="form-control" id="_user_code" name="user_code" placeholder="User ID" readonly="">
                                            </div>

                                            <div class="mt-2">
                                                <label>Activation Code for Refered users</label>
                                                <input type="text" class="form-control"  id="_activation_code" name="activation_code" readonly="">
                                            </div>

                                                
                                               
                                            

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success btn-rounded mt-1" id="_send_member_code_btn">Send Code</button>
                                            <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
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

