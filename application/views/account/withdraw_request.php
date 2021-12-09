
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Withdrawal Request</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Withdrawal Request</h4>
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
                                                <button class="btn btn-success rounded mb-2" id="_manual_process_btn">Manual Process </button>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="text-sm-end">
                                                    <button type="button" class="btn btn-light mb-2" onclick="showWithdrawRequest(1)">Refresh</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div><!-- end col-->

                                            <div class="font-12">
                                                *Manual Process can <b>Add</b> or <b>Deduct</b> Wallet Balance on every user depends on its purpose.
                                            </div>
                                        </div>
                
                                        <div class="mt-3">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap font-13" id="products-datatable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Ref. no.</th>
                                                        <th>User ID</th>
                                                        <th>Amount</th>
                                                        <th>Payment</th>
                                                        <th>Acct. Name</th>
                                                        <th>Acct. Number</th>
                                                        <th>Status</th>
                                                        <th>Date Requested</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="_withdraw_request_tbl">
                                                    
                                                </tbody>
                                            </table>
                                            <div class="mt-2" id="_withdraw_request_pagination"></div>
                                        </div>
                                   </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->


                        <div id="process_wr_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-money-withdrawal"></i> <span id="_modal_title">Process Withdrawal Request</span></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <form id="_withdraw_request_form">
                                        <div class="modal-body mb-3">
                                            <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                                After sending the amount to the user, update the Request Status from <span class="badge badge-primary-lighten">Pending</span> <i class="uil-angle-right "></i> <span class="badge badge-warning-lighten"> Processing</span> <i class="uil-angle-right "></i> <span class="badge badge-success-lighten"> Complete</span> or <span class="badge badge-danger-lighten">Close</span> once Closed or Cancelled.<br>
                                            </div>
                                            <hr>
                                            <label>Withdrawal Details</label>

                                            <div class="mt-3">
                                                You should send total of: <br><span id="_amount_to_send" class="font-35 fw-600 text-success"> </span>
                                            </div>

                                            <div class="mt-2">
                                                Requested Amount: <br><span id="_request_amount" class="font-25 fw-600"> </span>
                                            </div>

                                            <div class="mt-2">
                                                Collected Processing Fee: <br><span id="_processing_fee" class="font-25 fw-600"> </span>
                                            </div>

                                            <div class="mt-2">
                                                Payment Method: <br><span id="_payment_method" class="font-25 fw-600"> </span>
                                            </div>

                                            <div class="mt-2">
                                                Account Name: <br><span id="_acct_name" class="font-25 fw-600"> </span>
                                            </div>

                                            <div class="mt-2">
                                                Account Number: <br><span id="_acct_num" class="font-25 fw-600"> </span>
                                            </div>

                                            <hr>

                                            <div class="text-sm-start mt-2 form-floating">
                                                <select class="form-select  mt-3" name="status" id="_rw_status" required aria-label="Floating label select example">
                                                    <option disabled="" selected="" value="">Select Status</option>
                                                    <option value="processing">Processing</option>
                                                    <option value="complete">Complete</option>
                                                    <option value="closed">Closed</option>
                                                    <option value="pending">Pending</option>
                                                </select>
                                               <label for="_rw_status" class="fw-400 mb-2">Update the request Status after Payment.</label>
                                            </div>
                                         <input type="hidden" class="form-control" value="" id="_ref_no" />
                                         <input type="hidden" class="form-control" value="" id="_user_id" />
                                         <input type="hidden" class="form-control" value="" id="__amount" />
                                        </div>
                                        <div class="modal-footer mb-2">
                                            <button type="submit" class="btn btn-success btn-lg rounded font-15 mt-1" id="_update_wr_btn">Update Request</button>
                                            <button type="button" class="btn btn-rounded btn-lg rounded font-15 btn-light" id="" data-bs-dismiss="modal" >Close</button>
                                        </div>
                                    </form>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                        

                        <div id="_manual_process_modal" data-bs-backdrop="static" data-bs-keyboard="false" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-money-withdrawal "></i> <span id="_modal_title">Processing Finance</span></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <form id="_finance_manual_process_form">
                                        <div class="modal-body mb-3">
                                            <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                               Here you can Add and Deduct users' balance.
                                            </div>


                                            <div class="dropdown mt-3">
                                                <label>Search User</label>
                                                <input type="text" class="form-control dropdown-toggle mt-1" id="search_code_name" name="" placeholder="Search Name/User ID/Mobile number">
                                                 <div class="dropdown-menu dropdown-menu-animated dropdown-lg search-user-dropdown" id="search_user_dropdown">
                                                    <div id="_member_search" class="mb-1 mt-1">
                                                        <!-- item-->
                                                    </div>
                                                </div>
                                                <button type="button" id="_search_user_finance_btn" class="btn btn-success rounded mt-1 float-right"><i class="uil-search"></i> Search</button>
                                                <button type="button" class="btn btn-success rounded mt-1 float-right disabled"><i class="mdi mdi-qrcode"></i> Scan QR Code</button>
                                            </div>

                                            <div class="row">
                                                <div class="mt-2 col-lg-6">
                                                    <label>User's Name</label>
                                                    <input type="text" class="form-control" id="_user_name" name="user_name" placeholder="User Full Name" readonly="">
                                                </div>

                                                <div class="mt-2 col-lg-6">
                                                    <label>User ID</label>
                                                    <input type="text" class="form-control" id="_user_code" name="user_code" placeholder="User ID" readonly="">
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="mt-3">
                                                <label>Description</label>
                                                <select class="form-control select2" name="description" data-toggle="select2" id="_select_description">
                                                    <option disabled="" selected="">Select Description</option>
                                                    <option value="System Notice: Fix for Indirect Referral Bonus">System Fix for Indirect Referral Bonus</option>
                                                    <option value="System Notice: Fix for Unilevel Bonus">System Fix for Unilevel Bonus</option>
                                                    <option value="System Notice: Fix for Main Wallet Balance">System Fix for Main Wallet Balance</option>
                                                </select>
                                            </div>

                                            <div class="mt-3">
                                                <label>Wallet Type</label>
                                                <select class="form-control select2" name="wallet_type" data-toggle="select2" id="_wallet_type">
                                                    <option disabled="">Select Wallet Type</option>
                                                    <option value="main" >Main Wallet</option>
                                                    <option value="indirect_referral" >Indirect Referral</option>
                                                    <option value="unilevel_bonus" >Unilevel Bonus</option>
                                                </select>
                                            </div>

                                            <div class="row">
                                                <div class="mt-3 col-lg-6">
                                                    <label> Type</label>
                                                    <select class="form-control select2 " name="type" data-toggle="select2" id="_type">
                                                        <option disabled="" selected="">Select Type</option>
                                                        <option value="add" >Add</option>
                                                        <option value="deduct" >Deduct</option>
                                                    </select>
                                                </div>

                                                <div class="mt-3 col-lg-6">
                                                    <label>Amount</label>
                                                    <input type="number" class="form-control" id="_amount" name="amount" placeholder="Amount to be added or deduct..." value="500">
                                                </div>

                                            </div>
                                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success rounded mt-1" id="_process_finance_btn">Process </button>
                                            <button type="button" class="btn rounded btn-light" data-bs-dismiss="modal">Close</button>
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

