                <div class="container-fluid margin-top-20">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Herbal House</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                            <li class="breadcrumb-item active">Orders</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Orders</h4>
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
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="mt-1 mb-1">
                                                <h3 class="btn btn-success rounded font-17"><i class="uil-exclamation-circle "></i> Notice</h3>
                                               <div class="alert alert-light fade show c-black" role="alert">
                                                    Once items were packed already, kindly UPDATE the <span class="fw-600">Order Status</span> to <b><span class="badge badge-info-lighten">Packed</span></b><br><br>
                                                    After the courier pickup the parcels from your location, kindly UPDATE the <span class="fw-600">Order Status</span> to <b><span class="badge badge-warning-lighten">Shipped</span></b> and choose your Courier and put the Tracking Number.<br><br>
                                                    Once the courier delivered the order, kindly UPDATE the <span class="fw-600">Order Status</span> to <b><span class="badge badge-success-lighten">Delivered</span></b> to Complete the orders and distibute the Unilvel points to the users.
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <form class="row gy-2 gx-2 align-items-center">

                                                    <div class="col-auto">
                                                        <label for="inputPassword2" class="visually-hidden">Search</label>
                                                        <input type="search" class="form-control" id="inputPassword2" placeholder="Search...">
                                                    </div>
                                                </form>                            
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="text-lg-end">
                                                    <!-- <button type="button" class="btn btn-danger mb-2 me-2"><i class="mdi mdi-basket me-1"></i> Add New Order</button> -->
                                                    <button type="button" class="btn btn-light mb-2 margin-top-5" onclick="showAllOrders(1)">Refresh</button>
                                                    <button type="button" class="btn btn-light mb-2 margin-top-5">Export</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>
                
                                        <div class="table-responsive">
                                            <table class="table table-centered mb-0 font-13">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Order Ref No.</th>
                                                        <th>Order Status</th>
                                                        <th>Sales</th>
                                                        <th>Payment Method</th>
                                                        <th>Payment Status</th>
                                                        <th>Ordered Date</th>
                                                        <th style="width: 125px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="orders_tbl">
                                                    
                                                </tbody>
                                            </table>
                                            <div class="mt-1" id="order_pagination">
                                                
                                            </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row --> 
                       
                        <div id="update_order_status_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md ">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-edit"></i> <span id="_modal_title">Update Order Status</span></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body mb-3">
                                        <h3 class="font-18 fw-600">Update Order Status</h3>
                                        <form id="_order_status_form">
                                            <select  class="select2 form-control select2-multiple" name="status"  data-toggle="select2" id="__order_status_select" required="">
                                                
                                            </select>
                                            <input type="hidden" id="order_id_status" name="order_id" value="">

                                            <div hidden="" id="ship_wrapper">
                                                <div class="mt-2">
                                                    <label>Courier</label>
                                                    <select  class="select2 form-control select2-multiple" name="courier"  data-toggle="select2" id="_courier">
                                                        <option selected disabled="">Choose Courier</option>
                                                        <option value="LBC Express">LBC Express</option>
                                                        <option value="J&T Express">J&T Express</option>
                                                        <option value="JRS Express">JRS Express</option>
                                                    </select>
                                                </div>

                                                <div class="mt-2">
                                                    <label>Tracking Number</label>
                                                    <input type="text" id="_tracking_number" class="form-control" name="tracking_number" value="" placeholder="Ex. LBC38W852SZ5341">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="update_order_status_" class="btn btn-rounded btn-success" data-bs-dismiss="modal">Update</button>
                                        <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal --> 
                    </div> <!-- container -->