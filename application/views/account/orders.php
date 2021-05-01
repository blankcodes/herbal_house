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

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="mt-1 mb-1">
                                                <h3 class="badge badge-success-lighten font-17"><i class="uil-exclamation-circle "></i> Notice</h3>
                                                <div class="alert alert-light fade show c-black" role="alert">
                                                    Once items were packed already, kindly UPDATE the order status to <b><span class="badge badge-info-lighten">Packed</span></b><br>
                                                    After the courier pickup the parcels on the wearhouse, kindly UPDATE the order status to <b><span class="badge badge-warning-lighten">Shipped</span></b> and include the Courier's name and the Tracking Number
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <form class="row gy-2 gx-2 align-items-center">

                                                    <div class="col-auto">
                                                        <label for="inputPassword2" class="visually-hidden">Search</label>
                                                        <input type="search" class="form-control" id="inputPassword2" placeholder="Search...">
                                                    </div>
                                                   
                                                    <div class="col-auto">
                                                        <div class="ms-sm-2">
                                                            <label for="status-select">Order Status</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="me-sm-4">
                                                            <select  class="select2 form-control select2-multiple"  data-toggle="select2" id="order_status_select">
                                                                <option selected>Choose...</option>
                                                                <option value="delivered">Delivered</option>
                                                                <option value="shipped">Shipped</option>
                                                                <option value="packed">Packed</option>
                                                                <option value="created">Created</option>
                                                                <option value="cancelled">Cancelled</option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="ms-sm-2">
                                                            <label for="status-select">Payment Status</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="me-sm-4">
                                                            <select  class="select2 form-control select2-multiple"  data-toggle="select2" id="payment_status_select">
                                                                <option selected>Choose...</option>
                                                                <option value="paid">Paid</option>
                                                                <option value="unpaid">Unpaid</option>
                                                                <option value="payment failed">Payment Failed</option>
                                                            </select>
                                                        </div>
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
                                            <table class="table table-centered mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 20px;">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                            </div>
                                                        </th>
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
                                            <select  class="select2 form-control select2-multiple" name="status"  data-toggle="select2" id="__order_status_select">
                                                <option selected disabled="">Choose Order Status</option>
                                                <option value="packed">Packed</option>
                                                <option value="shipped">Shipped</option>
                                                <option value="delivered">Delivered</option>
                                                <option value="cancelled">Cancelled</option>
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
                                        <button type="submit" id="update_order_status_" class="btn btn-rounded btn-success" data-bs-dismiss="modal">Update</button>
                                        <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal --> 
                    </div> <!-- container -->