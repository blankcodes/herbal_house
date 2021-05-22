                        <!-- start page title -->
                        <div class="row margin-top-20">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Herbal House</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Products</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Products</h4>
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
                                                <a href="#add_product" id="add_product_modal_btn" class="btn btn-success mb-2"><i class="mdi mdi-plus-circle me-2"></i> Add Products</a>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <!-- <button type="button" class="btn btn-success mb-2 me-1"><i class="mdi mdi-cog-outline"></i></button> -->
                                                    <button type="button" id="refresh_prodct_tbl" class="btn btn-light mb-2 me-1">Refresh</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>
                
                                        <div class="table-responsive">
                                            <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                                                <thead class="table-light font-13" >
                                                    <tr>
                                                        <th class="all" style="width: 20px;">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                            </div>
                                                        </th>
                                                        <th class="all">Product</th>
                                                        <th>Category</th>
                                                        <th>Retail Price</th>
                                                        <th>Disc. Price</th>
                                                        <th>UniLvl Points <i data-toggle="tooltip" data-placement="top" title="Points displayed is already 10% calculated." class="uil-question-circle pointer-cursor"></i></th>
                                                        <th>Qty</th>
                                                        <th>Status</th>
                                                        <th>Added Date</th>
                                                        <th style="width: 85px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="_products_tbl" class="font-13">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="product_pagination"></div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->        
                        
                    </div> <!-- container -->

                    <div id="add_product_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg ">
                            <div class="modal-content">
                                <div class="modal-header bg-success">
                                    <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-cart me-2"></i> <span id="_modal_title">Add Products</span></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                </div>
                                <div class="modal-body">

                                    <form class="ps-3 pe-3" action="#" id="_add_product_form">
                                        <input type="hidden" id="csrf_token" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                        <input type="hidden" id="p_id" name="p_id" value="">


                                        <div class="mb-3 col-lg-6">
                                            <div class="col-md-12 col-xs-12">
                                                <img src="<?=base_url('assets/images/thumbnail.png')?>" alt="thumbnail" id="prodct_img_thumbnail" width="150" class="img-fluid br-10">
                                            </div>
                                            <label for="product_image" class="form-label">Product Image</label>
                                            <input onchange="readURL(this)" type="file" id="product_image" name="product_image" class="form-control">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="product_name" class="form-label">Product Name</label>
                                            <input class="form-control" type="text" id="product_name" name="product_name" required="" placeholder="Product Name">
                                        </div>

                                        <div class="mb-3"  >
                                            <label for="qty" class="form-label">Product Category</label>
                                            <select class="select2 form-control select2-multiple" data-toggle="select2" required name="product_category" id="product_category">
                                                
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-lg-6">
                                                <label for="srp_price" class="form-label">Retail Price</label>
                                                <input class="form-control" type="number" id="srp_price" name="srp_price" required="" placeholder="Ex. 400.00">
                                            </div>

                                            <div class="mb-3 col-lg-6">
                                                <label for="dc_price" class="form-label">Discounted/Membership Price</label>
                                                <input class="form-control" type="number" id="dc_price" name="dc_price" required="" placeholder="Ex. 200.00">
                                            </div>

                                            <div class="mb-3 col-lg-6">
                                                <label for="qty" class="form-label">Available Stocks</label>
                                                <input class="form-control" type="number" id="qty" name="qty" required="" placeholder="Available quantity of the products">
                                            </div>

                                            <div class="mb-3 col-lg-6">
                                                <label for="priority" class="form-label">Listing Priority</label>
                                                <select class="form-select" name="priority" id="">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>

                                            <div class="mb-3 col-lg-6">
                                                <label for="qty" class="form-label">Points Earned</label>
                                                <input class="form-control" type="number" id="points" name="points" required="" placeholder="Points Earned when a member purchase this product.">
                                            </div>

                                            <div class="mb-3 col-lg-6">
                                                <label for="qty" class="form-label">Profit Sharing Points</label>
                                                <input class="form-control" type="number" id="profit_sharing_points" name="profit_sharing_points" required="" placeholder="Points allocated to profit sharing">
                                            </div>
                                        </div>


                                        <div class="mb-3" >
                                            <label for="editor_description" class="form-label">Description</label>
                                            <!-- <div id="snow-editor" style="height: 200px;"></div> -->
                                            <textarea id="editor_description"></textarea>
                                        </div>

                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-rounded btn-success" id="add_product_btn">Add Product</button>
                                </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


                    <div id="edit_product_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg ">
                            <div class="modal-content">
                                <div class="modal-header bg-success">
                                    <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-cart me-2"></i> <span id="_edit_modal_title">Update Products</span></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                </div>
                                <div class="modal-body">

                                    <form class="ps-3 pe-3" action="#" id="_update_product_form">
                                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                        <input type="hidden" id="_edit_p_id" name="p_id" value="">

                                        <div class="mb-3 col-lg-6">
                                            <div class="col-md-12 col-xs-12">
                                                <img src="<?=base_url('assets/images/thumbnail.png')?>" alt="thumbnail" id="_edit_prodct_img_thumbnail" width="150" class="img-fluid br-10">
                                            </div>
                                            <label for="product_image" class="form-label">Product Image</label>
                                            <input onchange="readURL(this)" type="file" id="_edit_product_image" name="product_image" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label for="product_name" class="form-label">Product Name</label>
                                            <input class="form-control" type="text" id="_edit_product_name" name="product_name" required="" placeholder="Product Name">
                                        </div>

                                        <div class="mb-3"  >
                                            <label for="qty" class="form-label">Product Category</label>
                                            <select class="form-control select2" data-toggle="select2" required name="product_category" id="_edit_product_category">
                                                
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-lg-6">
                                                <label for="srp_price" class="form-label">SRP Price</label>
                                                <input class="form-control" type="number" id="_edit_srp_price" name="srp_price" required="" placeholder="Ex. 400.00">
                                            </div>

                                            <div class="mb-3 col-lg-6">
                                                <label for="dc_price" class="form-label">Discounted/Membership Price</label>
                                                <input class="form-control" type="number" id="_edit_dc_price" name="dc_price" required="" placeholder="Ex. 200.00">
                                            </div>

                                            <div class="mb-3 col-lg-6">
                                                <label for="qty" class="form-label">Available Stocks</label>
                                                <input class="form-control" type="number" id="_edit_qty" name="qty" required="" placeholder="Available quantity of the products">
                                            </div>

                                            <div class="mb-3 col-lg-6">
                                                <label for="priority" class="form-label">Listing Priority</label>
                                                <select class="form-select" name="priority" id="_edit_priority">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>

                                            <div class="mb-3 col-lg-6">
                                                <label for="qty" class="form-label">Points Earned</label>
                                                <input class="form-control" type="number" id="_edit_points" name="points" required="" placeholder="Points Earned when a member purchase this product.">
                                            </div>

                                            <div class="mb-3 col-lg-6">
                                                <label for="qty" class="form-label">Profit Sharing Points</label>
                                                <input class="form-control" type="number" id="_edit_profit_sharing_points" name="profit_sharing_points" required="" placeholder="Points allocated to profit sharing">
                                            </div>

                                        </div>


                                        <div class="mb-3" >
                                            <label for="editor_description" class="form-label">Description</label>
                                            <!-- <div id="snow-editor" style="height: 200px;"></div> -->
                                            <textarea id="_edit_editor_description"></textarea>
                                        </div>


                                        <div class="accordion" id="accordionExample">
                                            <div class=" mb-0">
                                                <div class="" id="headingOne">
                                                    <h5 class="m-0">
                                                        <a class="custom-accordion-title d-block pt-2 pb-2 text-success" data-bs-toggle="collapse" href="#advance_product_url" aria-expanded="true" aria-controls="advance_product_url">
                                                            Advance <span class=" uil-cog"></span>
                                                        </a>
                                                    </h5>
                                                </div>

                                                <div id="advance_product_url" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="">
                                                        <label for="qty" class="form-label">Product URL 
                                                            <span class="uil-edit pointer-cursor" id="edit_product_url_"></span>
                                                            <span class="uil-check-circle  pointer-cursor" id="close_edit_product_url_" hidden></span>
                                                        </label>
                                                        <input class="form-control" readonly type="text" id="_edit_product_url" name="product_url" required="" placeholder="Product URL">
                                                        <small>*Optimized Product URL or readable URL can get more leads, product views and traffic.</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-rounded btn-success" id="update_product_btn">Update Product</button>
                                </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <div id="view_product_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg ">
                            <div class="modal-content">
                                <div class="modal-header bg-success">
                                    <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="dripicons-cart me-2"></i> <span id="_view_title_modal"></span></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="">
                                                <div class="">
                                                    <div class="row">
                                                        <div class="col-lg-5">
                                                            <!-- Product image -->
                                                            <a href="javascript: void(0);" class="text-center d-block mb-4">
                                                                <img id="main_prod_img" src="" class="img-fluid" style="max-width: 280px;" alt="Product-img" />
                                                            </a>

                                                            <!-- <div class="d-lg-flex d-none justify-content-center">
                                                                <a href="javascript: void(0);">
                                                                    <img src="assets/images/products/product-1.jpg" class="img-fluid img-thumbnail p-2" style="max-width: 75px;" alt="Product-img" />
                                                                </a>
                                                                <a href="javascript: void(0);" class="ms-2">
                                                                    <img src="assets/images/products/product-6.jpg" class="img-fluid img-thumbnail p-2" style="max-width: 75px;" alt="Product-img" />
                                                                </a>
                                                                <a href="javascript: void(0);" class="ms-2">
                                                                    <img src="assets/images/products/product-3.jpg" class="img-fluid img-thumbnail p-2" style="max-width: 75px;" alt="Product-img" />
                                                                </a>
                                                            </div> -->
                                                        </div> <!-- end col -->
                                                        <div class="col-lg-7">
                                                            <form class="ps-lg-4">
                                                                <!-- Product title -->
                                                                <h3 class="mt-0" id="_view_prod_name"><a href="javascript: void(0);" class="text-muted"><i class="mdi mdi-square-edit-outline ms-2"></i></a> Product name</h3>
                                                                <p class="mt-0">Added Date: <span id=_view_added_date></span></p>

                                                                <!-- Product stock -->
                                                                <div class="mt-0">
                                                                    <h4 id="_view_stock_status"></h4>
                                                                </div>

                                                                <!-- Product price -->
                                                                <div class="row mt-1">
                                                                    <div class="col-lg-4">
                                                                        <h6 class="font-14">Retail Price:</h6>
                                                                        <h3 id="_view_srp_price"> </h3>
                                                                    </div>

                                                                    <div class="col-lg-4">
                                                                        <h6 class="font-14">Discounted Price:</h6>
                                                                        <h3 id="_view_dc_price"> </h3>
                                                                    </div>
                                                                </div>

                                                                <!-- Quantity -->
                                                                <!-- <div class="mt-4">
                                                                    <h6 class="font-14">Quantity</h6>
                                                                    <div class="d-flex">
                                                                        <input type="number" min="1" value="1" class="form-control" placeholder="Qty" style="width: 90px;">
                                                                        <button type="button" class="btn btn-danger ms-2"><i class="mdi mdi-cart me-1"></i> Add to cart</button>
                                                                    </div>
                                                                </div> -->
                                                    
                                                                <!-- Product description -->
                                                                <div class="mt-3">
                                                                    <h6 class="font-14">Description:</h6>
                                                                    <p id="_view_description"></p>
                                                                </div>

                                                            </form>
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row-->
                                                </div> <!-- end card-body-->
                                            </div> <!-- end card-->
                                        </div> <!-- end col-->
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <div id="update_qty_product_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md ">
                            <div class="modal-content">
                                <div class="modal-header bg-success">
                                    <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-cart me-2"></i> <span id="_modal_title">Update Product Qty</span></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                </div>
                                <div class="modal-body">

                                    <form class="ps-3 pe-3" action="#" id="_update_product_qty_form">
                                        <input type="hidden" id="__edit_p_id" name="p_id" value="">
                                        <div class="mb-3">
                                            <label for="__edit_qty" class="form-label">Quantity</label>
                                            <input class="form-control" type="number" id="__edit_qty" name="qty" required="" placeholder="Quantity">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-rounded btn-success" id="update_product_qty_btn">Update Quantity</button>
                                </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->
        