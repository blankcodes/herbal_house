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
                                                <a href="#generate_code_modal" id="generate_code_btn" class="btn btn-success mb-2"><i class="mdi mdi-plus-circle me-2"></i> Generate Product Codes</a>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <!-- <button type="button" class="btn btn-success mb-2 me-1"><i class="mdi mdi-cog-outline"></i></button> -->
                                                    <button type="button" id="refresh_prodct_code_tbl" class="btn btn-light mb-2 me-1">Refresh</button>
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
                                                        <th>Codes</th>
                                                        <th>Status</th>
                                                        <th>Date Added </th>
                                                        <th style="width: 85px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="_product_codes_tbl" class="font-13">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="product_code_pagination"></div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->        
                        
                    </div> <!-- container -->

                    <div id="generate_prod_code_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-edit"></i> <span id="_modal_title">Generate Product Codes</span></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <form id="_generate_prod_form">
                                    <div class="modal-body mb-3">
                                        <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                            Input a number on how many product code will be generated at once.
                                        </div>
                                        <label>Input numbers</label>
                                        <input type="number" class="form-control mt-2" name="number" placeholder="Ex. 20">
                                        <small>*Numbers on how many activation codes will be generated.</small>
                                        <div class="mt-2">
                                            <label>Product Name</label>
                                            <select class="form-control select2" name="product" data-toggle="select2" id="_select_product" required="">
                                                <option disabled="" selected="">Select Product</option>
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


                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->
        