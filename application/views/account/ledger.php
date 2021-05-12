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
                                            <table class="table table-centered w-100 dt-responsive nowrap font-12" id="products-datatable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="all">Package Name</th>
                                                        <th>Cost</th>
                                                        <th>Direct Referral</th>
                                                        <th>Match Points</th>
                                                        <th>UniLvl Points</th>
                                                        <th>AM Points</th>
                                                        <th>PM Points</th>
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

                        <div class="form-floating mt-2">
                            <input type="text" class="form-control"  name="package"  id="" placeholder="Ex. Package 2498" required="required"/>
                            <label for="" class="fw-400">Package Name</label>
                       </div>

                       <div class="form-floating mt-2">
                            <input type="number" class="form-control"  name="cost" id="" placeholder="Ex. 2498" required="required"/>
                            <label for="" class="fw-400">Package Cost</label>
                       </div>

                       <div class="form-floating mt-2">
                            <input type="number" class="form-control"  name="direct_points" id="" placeholder="Points/Cash earned for Direct Referral" required="required"/>
                            <label for="" class="fw-400">Direct Referral Bonus</label>
                       </div>

                       <div class="form-floating mt-2">
                            <input type="number" class="form-control"  name="match_points"  id="" placeholder="Ex. Package 2498" required="required" />
                            <label for="" class="fw-400">Sales Match Points</label>
                        </div>

                        <div class="form-floating mt-2">
                            <input type="number" class="form-control"  name="unilvl_points"  id="" placeholder="Ex. Package 2498" required="required"/>
                            <label for="" class="fw-400">Entry UniLevel Bonus</label>
                        </div>

                         <div class="form-floating mt-2">
                            <input type="number" class="form-control"  name="max_points_am"  id="" placeholder="Ex. Package 2498" required="required"/>
                            <label for="" class="fw-400">AM Sales Match Points</label>
                            <small>Maximum Sales Match Bunos get in the AM period (00:01 - 11:59)</small>
                        </div>

                        <div class="form-floating mt-2">
                            <input type="number" class="form-control"  name="max_points_pm" id="" placeholder="Ex. Package 2498" required="required"/>
                            <label for="" class="fw-400">PM Sales Match Points</label>
                            <small>Maximum Sales Match Bunos get in the PM period (12:00 - 23:59)</small>
                        </div>

                        <div class="mt-2">
                            <textarea class="form-control" name="description" id="" placeholder="Package Description" required="required"></textarea>
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

                        <div class="form-floating mt-2">
                            <input type="text" class="form-control"  name="package" value="" id="_edit_package" placeholder="Ex. Package 2498" required="required"/>
                            <label for="_edit_package" class="fw-400">Package Name</label>
                       </div>

                       <div class="form-floating mt-2">
                            <input type="number" class="form-control"  name="cost" value="" id="_edit_cost" placeholder="Ex. 2498" required="required"/>
                            <label for="_edit_cost" class="fw-400">Package Cost</label>
                       </div>

                       <div class="form-floating mt-2">
                            <input type="number" class="form-control"  name="direct_points" value="" id="_edit_direct_points" placeholder="Points/Cash earned for Direct Referral" required="required"/>
                            <label for="_edit_direct_points" class="fw-400">Direct Referral Bonus</label>
                       </div>

                       <div class="form-floating mt-2">
                            <input type="number" class="form-control"  name="match_points" value="" id="_edit_match_points" placeholder="Ex. Package 2498" required="required" />
                            <label for="_edit_match_points" class="fw-400">Sales Match Points</label>
                        </div>

                        <div class="form-floating mt-2">
                            <input type="number" class="form-control"  name="unilvl_points" value="" id="_edit_unilvl_points" placeholder="Ex. Package 2498" required="required"/>
                            <label for="_edit_unilvl_points" class="fw-400">Entry UniLevel Bonus</label>
                        </div>

                         <div class="form-floating mt-2">
                            <input type="number" class="form-control"  name="max_points_am" value="" id="_edit_max_points_am" placeholder="Ex. Package 2498" required="required"/>
                            <label for="_edit_max_points_am" class="fw-400">AM Sales Match Points</label>
                            <small>Maximum Sales Match Bunos get in the AM period (00:01 - 11:59)</small>
                        </div>

                        <div class="form-floating mt-2">
                            <input type="number" class="form-control"  name="max_points_pm" value="" id="_edit_max_points_pm" placeholder="Ex. Package 2498" required="required"/>
                            <label for="_edit_max_points_pm" class="fw-400">PM Sales Match Points</label>
                            <small>Maximum Sales Match Bunos get in the PM period (12:00 - 23:59)</small>
                        </div>

                        <div class="mt-2">
                            <textarea class="form-control" name="description" id="_edit_description" placeholder="Package Description" required="required"></textarea>
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