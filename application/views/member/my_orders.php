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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">My Orders</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">My Orders</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

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
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-centered mb-0 font-13">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Order Ref No.</th>
                                                <th>Order Status</th>
                                                <th>Amount To Pay</th>
                                                <th>Payment Method</th>
                                                <th>Payment Status</th>
                                                <th>Ordered Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="my_orders_tbl">
                                                            
                                        </tbody>
                                    </table>
                                    <div class="mt-1" id="my_order_pagination">
                                                        
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

        </div>
        <!-- END wrapper -->

