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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Wallet</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Wallet</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <?php if ($siteSetting['withdrawal'] == 'disabled'){ ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close font-12" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Notice: </strong> Website Withdrawal has been Disabled as of the moment! Kindly wait for further announcement! Thank you!
                            </div>
                        <?php } ?>

                        <?php if ($userData['status'] == 'disabled'){ ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close font-12" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Notice: </strong> Your account's withdrawal has been disabled! If you think this is a mistake, kindly message us to update your status</a>.
                            </div>
                        <?php } ?>


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

                        <div id="e_wallet" class="row">
                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="uil-wallet widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Main Wallet Balance</h5>
                                        <h2 class="mt-3 mb-3" id="_wallet_balance">₱ 0.00</h2>
                                        <!-- <p class="mb-0 text-muted">
                                             <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                                            <span class="text-nowrap">Since last month</span>  
                                        </p> -->
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="uil-wallet widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Indirect Referral Balance</h5>
                                        <h2 class="mt-3 mb-3" id="_indirect_ref_balance">₱ 0.00</h2>
                                        <!-- <p class="mb-0 text-muted">
                                             <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                                            <span class="text-nowrap">Since last month</span>  
                                        </p> -->
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="uil-wallet widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Unilevel Balance</h5>
                                        <h2 class="mt-3 mb-3" id="_unilevel_balance">₱ 0.00</h2>
                                        <!-- <p class="mb-0 text-muted">
                                             <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                                            <span class="text-nowrap">Since last month</span>  
                                        </p> -->
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div>
                                <button class="btn btn-primary rounded mt-1 <?= ($userData['status'] == 'disabled') ? 'disabled' : '' ?>"  id="_withdraw_request_btn"><i class="uil-money-withdrawal" ></i> Withdrawal Request</button>

                                 <button class="btn btn-primary rounded mt-1 <?= ($userData['status'] == 'disabled') ? 'disabled' : '' ?>" id="_tranfer_bal_btn"><i class="uil-exchange-alt"></i> Transfer Balance</button>
                            </div>

                            <div class="col-lg-12">
                                <div class="card widget-flat mt-3">
                                    <div class="card-body table-responsive mt-2">
                                        <h3 class="font-21">Recent Activity</h3>
                                            <table class="table table-centered table-hover w-100 dt-responsive nowrap mt-2" id="">
                                                <thead class="table-light">
                                                    <tr>
                                                        
                                                        <th>Date</th>
                                                        <th>Reference No.</th>
                                                        <th>Activity</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                    </thead>
                                                 <tbody id="_wallet_activity_tbl">
                                                </tbody>
                                            </table>
                                        <div class="mt-3">
                                            <div id="_wallet_activity_pagination"></div>
                                        </div>
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
            <div id="withdrawal_req_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-money-withdrawal"></i> <span id="_modal_title">Withdrawal Request</span></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <form id="_withdrawal_request_form">
                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            <div class="modal-body mb-3">
                                <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                    Notice: ₱ 50.00 will be deducted for processing fee. Withdrawal request will be processed within 24 hours. 
                                </div>

                                <div class="mt-1">
                                    Your Balance: <br><span id="_balance" class="font-31 fw-600"> </span>
                                </div>

                                <div class="mt-3">
                                    <label class="fw-400">Enter the amount you want to withdraw. Must be a whole number!</label>
                                </div>

                                <div class="form-floating mt-1">
                                    <input type="number" class="form-control" name="amount" id="_withdraw_amount" placeholder="User ID" required=""/>
                                    <label for="_withdraw_amount" class="fw-400">Amount</label>
                                </div>
                                <!-- <div class="form-check form-checkbox-success mb-2 mt-1">
                                    <input type="checkbox" class="form-check-input" id="_get_full_amount">
                                    <label class="form-check-label fw-400 font-13" for="_get_full_amount">Withdraw Full amount</label>
                                </div> -->

                                <div class="text-sm-start mt-2">
                                    <select class="form-control select2" name="payment_method" data-toggle="select2" id="_payment_method" required>
                                        <option disabled="" selected="">Select Payment Method</option>
                                        <option value="Gcash">Gcash</option>
                                    </select>
                                </div>

                                <div class="form-floating mt-2">
                                    <input type="text" class="form-control" name="account_name" id="_account_name" placeholder="Juan Dela Cruz" required=""/>
                                    <label for="_account_name" class="fw-400">Account Name</label>
                                </div>


                                <div class="form-floating mt-2">
                                    <input type="text" class="form-control" name="account_number" id="_account_number" placeholder="Ex. 10085298452" required=""/>
                                    <label for="_account_number" class="fw-400">Account Number</label>
                                </div>

                               
                            </div>
                            <div class="modal-footer mb-2">
                                <button type="submit" class="btn btn-success btn-lg rounded font-15 mt-1" id="_withdraw_review_btn">Withdraw</button>
                                <button type="button" class="btn btn-rounded btn-lg rounded font-15 btn-light" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div id="withdrawal_review_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-md ">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-money-withdrawal"></i> <span id="_modal_title">Review Your Request</span></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <form id="_withdraw_form">
                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            <div class="modal-body mb-3">
                                <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                    Make sure you input your correct details to avoid issue.
                                </div>

                                <div class="mt-1">
                                    You will get: <br><span id="_review_balance" class="font-31 fw-600"> </span>
                                </div>

                                <div class="mt-2">
                                    Processing Fee: <br><span id="_processing_fee" class="font-25 fw-600"> </span>
                                </div>

                                <div class="mt-2">
                                    Payment Method: <br><span id="__review_pay_method" class="font-25 fw-600"> </span>
                                </div>

                                <div class="mt-2">
                                    Account Name: <br><span id="__review_acct_name" class="font-25 fw-600"> </span>
                                </div>

                                <div class="mt-2">
                                    Account Number: <br><span id="__review_acct_num" class="font-25 fw-600"> </span>
                                </div>

                                <input type="hidden" name="amount" id="__withdraw_amount"  required=""/>
                                <input type="hidden" name="payment_method" id="__payment_method"  required=""/>
                                <input type="hidden" name="account_name" id="__account_name"  required=""/>
                                <input type="hidden" name="account_number" id="__account_number" required=""/>
                            </div>
                            <div class="modal-footer mb-2">
                                <button type="submit" class="btn btn-success btn-lg rounded font-15 mt-1" id="_withdraw_btn">Withdraw</button>
                                <button type="button" class="btn btn-rounded btn-lg rounded font-15 btn-light" id="_cancel_withdraw" >Cancel</button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div id="tranfer_bal_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-exchange-alt"></i> <span id="_modal_title">Transfer Balance</span></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <form id="_transfer_amnt_form">
                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            <div class="modal-body mb-3">
                                <div class="alert alert-success bg-success text-white border-0" role="alert">
                                    Transfer your Indirect Referral Points to Main wallet every 15th of the month. And Transfer your Unilevel Points every end date of the month.
                                </div>

                                <div class="alert alert-success bg-success text-white border-0" role="alert">
                                    Transfer your balance from Indirect referral and Unilevel Balance to your Main Wallet.<br> Minimum of <span class="fw-500">₱ 300.00</span>
                                </div>

                                

                                <div class="mt-3">
                                    <label class="fw-400">Input the amount you want to transfer. Must be a whole number!</label>
                                </div>

                                <div class="row">
                                    <div class="text-sm-start col-lg-5 mt-2 mb-1">
                                        <select class="form-control select2" name="wallet_type" data-toggle="select2" id="_select_wallet" required>
                                            <option disabled="" selected="">Select Wallet</option>
                                            <option value="indirect_referral">Indirect Referral Wallet</option>
                                            <option value="unilevel_bonus">Unilevel Wallet</option>
                                        </select>
                                    </div>
                                </div>

                               <div class="row" id="form_input">
                                    <div class="form-floating mt-1 col-lg-5">
                                        <input type="number" class="form-control" name="transfer_amnt" id="_transfer_amnt" placeholder="Transfer Amount" required=""/>
                                        <label for="_transfer_amnt" class="fw-400 transfer-amount-label">Amount</label>
                                    </div>
                                    <div class="col-lg-2 mt-2 mb-1 text-center block">
                                        <i class="uil-exchange-alt font-30"></i>
                                    </div>
                                    <div class="form-floating mt-1 col-lg-5">
                                        <input type="number" class="form-control" name="receive_transfer_amnt" id="_receive_transfer" placeholder="Amount" readonly=""/>
                                        <label for="_withdraw_amount" class="fw-400 transfer-amount-label">Main Wallet</label>
                                    </div>
                               </div>

                                
                               
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success rounded font-15 mt-1" id="_transfer_amnt_btn">Transfer</button>
                                <button type="button" class="btn rounded btn-light font-15" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div id="_show_wallet_activity_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-money-withdrawal"></i> <span id="_wallet_activity_title">Wallet Activity</span></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="container-fluid">
                            <div class="card mt-2">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h1 id="_wallet_amnt"></h1>
                                    </div>
                                </div>
                            </div>

                            <div class="card" style="margin-top: -15px;">
                                <div class="card-body">
                                    <div class=" mt-2">
                                        <table class="table mb-0 order-item-tbl">
                                            <thead class="table-light">
                                            
                                            </thead>
                                            <tbody id="">
                                                <tr>
                                                    <td>Reference No: </td>
                                                    <td><span class="font-14" id="_ref_no"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Create Time: </td>
                                                    <td><span class="font-14" id="_created_at"></span></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card" style="margin-top: -15px;">
                                <div class="card-body">
                                    <h4 class="font-15 fw-500">Details: </h4>
                                    <div class="table-responsive mt-2">
                                        <table class="table mb-0 order-item-tbl">
                                            <thead class="table-light">
                                            <tr>
                                        <th>Date & Time</th>
                                            <th>Activity</th>
                                        </tr>
                                        </thead>
                                            <tbody id="_event_logs">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn rounded btn-light font-15" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
        <!-- END wrapper -->

