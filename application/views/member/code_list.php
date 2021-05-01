
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Code List</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Code List</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="mt-2">
                                                <div class="col-lg-3 col-12 col-md-6">
                                                    <div class="card widget-flat">
                                                        <div class="card-body">
                                                            <div class="float-end">
                                                                <i class="mdi mdi-account-multiple-plus widget-icon"></i>
                                                            </div>
                                                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Code Credits</h5>
                                                            <h3 class="mt-3 mb-3" id="_code_credits">0</h3>
                                                        </div> <!-- end card-body-->
                                                    </div> <!-- end card-->
                                                </div> <!-- end col-->
                                            </div>

                                            <div class="col-sm-4">
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <button type="button" class="btn btn-light mb-2" onclick="showCodeHistory(1)">Refresh</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>
                
                                         <div class="table-responsive mt-3">
                                            <h3 class="font-21">Code History</h3>
                                            <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap mt-2" id="">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 20px;">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                            </div>
                                                        </th>
                                                        <th>Code</th>
                                                        <th>Package Name</th>
                                                        <th>Date Purchased</th>
                                                        <th>Date Used</th>
                                                        <th>Used by</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="_code_history_tbl">
                                                    
                                                   
                                                </tbody>
                                            </table>
                                            <div class="mt-3">
                                                <div id="_code_history_pagination"></div>
                                            </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
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

