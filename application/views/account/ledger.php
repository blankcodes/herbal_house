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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ledger</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Ledger</h4>
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
                                                <a href="#add_package" id="add_package" class="btn btn-success mb-2"><i class="mdi mdi-plus-circle me-2"></i> Add New Package</a>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <!-- <button type="button" class="btn btn-success mb-2 me-1"><i class="mdi mdi-cog-outline"></i></button> -->
                                                    <button type="button" id="refresh_prodct_tbl" class="btn btn-light mb-2 me-1" onclick="showPackageList(1)">Refresh</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>
                
                                        <div class="table-responsive">
                                            <h2 class="font-22">Package List</h2>
                                            <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="all" style="width: 20px;">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                            </div>
                                                        </th>
                                                        <th class="all">Package Name</th>
                                                        <th>Cost</th>
                                                        <th>Direct Referral</th>
                                                        <th>Match Points</th>
                                                        <th>Status</th>
                                                        <th>Added Date</th>
                                                        <th style="width: 85px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="_package_list_tbl">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="_package_list_pagination"></div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row --> 
                        <!-- end row -->
                    </div> <!-- container -->
                </div> <!-- content -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <div id="new_package_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg ">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-plus"></i> <span id="_modal_title">Add New Package</span></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <form id="_new_package_form">
                    <div class="modal-body mb-3">
                        <div class="alert alert-light bg-light text-dark border-0" role="alert">
                            Include every details about the package.
                        </div>
                        <input type="hidden" id="csrf_token" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                        <div class="mt-2">
                            <label class="fw-500">Package Name</label>
                            <input type="text" class="form-control" name="package" placeholder="Ex. Package 2498" required="required">
                        </div>

                        <div class="mt-2">
                            <label class="fw-500">Package Cost</label>
                            <input type="number" class="form-control" name="cost" placeholder="Ex. 2498" required="required">
                        </div>

                        <div class="mt-2">
                            <label class="fw-500">Direct Referral Bonus</label>
                            <input type="number" class="form-control" name="direct_points" placeholder="Points/Cash earned for Direct Referral" required="required">
                        </div>

                        <div class="mt-2">
                            <label class="fw-500">Sales Match Points</label>
                            <input type="number" class="form-control" name="match_points" placeholder="Points earned for every Sales Match" required="required">
                        </div>

                        <div class="mt-2">
                            <label class="fw-500">Package Description</label>
                            <textarea class="form-control" name="description" placeholder="Ex. Package worth PHP 2,800.00 - PHP 3,600.00" required="required"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="_add_package_btn" class="btn btn-rounded btn-success">Add</button>
                        <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
       </div><!-- /.modal --> 

       <div id="edit_package_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg ">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-edit"></i> <span id="_modal_title">Update Package</span></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <form id="_update_package_form">
                    <div class="modal-body mb-3">
                        <div class="alert alert-light bg-light text-dark border-0" role="alert">
                            Include every details about the package.
                        </div>
                        <input type="hidden" id="csrf_token" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                        <input type="hidden" id="p_id" name="p_id" value="" />
                        <div class="mt-2">
                            <label class="fw-500">Package Name</label>
                            <input type="text" class="form-control" id="_edit_package" name="package" placeholder="Ex. Package 2498" required="required">
                        </div>

                        <div class="mt-2">
                            <label class="fw-500">Package Cost</label>
                            <input type="number" class="form-control" id="_edit_cost" name="cost" placeholder="Ex. 2498" required="required">
                        </div>

                        <div class="mt-2">
                            <label class="fw-500">Direct Referral Bonus</label>
                            <input type="number" class="form-control" name="direct_points" id="_edit_direct_points" placeholder="Points/Cash earned for Direct Referral" required="required">
                        </div>

                        <div class="mt-2">
                            <label class="fw-500">Points</label>
                            <input type="number" class="form-control" id="_edit_match_points" name="match_points" placeholder="Points earned for every Sales Match" required="required">
                        </div>

                        <div class="mt-2">
                            <label class="fw-500">Package Description</label>
                            <textarea class="form-control" name="description" id="_edit_description" placeholder="Ex. Package worth PHP 2,800.00 - PHP 3,600.00" required="required"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="_update_package_btn" class="btn btn-rounded btn-success">Update Package</button>
                        <button type="button" class="btn btn-rounded btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
       </div><!-- /.modal --> 