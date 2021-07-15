                        <!-- start page title -->
                        <div class="row margin-top-20">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Herbal House</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Products Category</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Products Category</h4>
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
                                               <a href="#add_product" id="add_product_cat_modal_btn" class="btn btn-success mb-2"><i class="mdi mdi-plus-circle me-2"></i> Add Products Category</a>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <!-- <button type="button" class="btn btn-success mb-2 me-1"><i class="mdi mdi-cog-outline"></i></button> -->
                                                    <button type="button" id="refresh_prodct_category_tbl" class="btn btn-light mb-2 me-1">Refresh</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>
                
                                        <div class="table-responsive">
                                            <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="all" style="width: 20px;">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                            </div>
                                                        </th>
                                                        <th class="all">Product Category</th>
                                                        <th>Status</th>
                                                        <th>Added Date</th>
                                                        <th style="width: 85px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="_products_category_tbl">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="product_category_pagination"></div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->        
                        
                    </div> <!-- container -->


                    <div id="add_product_cat_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg ">
                            <div class="modal-content">
                                <div class="modal-header bg-success">
                                    <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-tag me-2"></i> Add Product Category</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="ps-3 pe-3" action="#" id="_add_product_cat_form">

                                        <div class="mb-3 col-lg-6">
                                            <div class="col-md-12 col-xs-12">
                                                <img src="<?=base_url('assets/images/thumbnail.png')?>" alt="thumbnail" id="prodct_img_thumbnail" width="150" class="img-fluid br-10">
                                            </div>
                                            <label for="product_cat_image" class="form-label">Product Category Image</label>
                                            <input onchange="readURL(this)" type="file" id="product_cat_image" name="product_cat_image" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <input type="hidden" id="csrf_token" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                            <label for="product_name" class="form-label">Product Category Name</label>
                                            <input class="form-control" type="text" id="product_cat_name" name="product_cat_name" required="" placeholder="Product Category Name">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-rounded btn-success" id="add_product_cat_btn">Add Product Category</button>
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