
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Website Settings</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Website Settings</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        
                        <div class="row">
                        	<div class="col-lg-12">
                        		<!-- <h4>Add Maintenance Status</h4> -->
                        	</div>

                        	<div class="mt-2 col-lg-6">
                                <div class="">
                                    <div class="dropdown">
                                        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Withdrawal Status
                                        </button>
                                        <div class="mt-3">
                                            <label>Current Status: <span id="_withdrawal_status_badge" class="badge font-12 <?=($siteSetting['withdrawal'] == 'disabled') ? 'bg-danger' : 'bg-success'?>"><?=ucwords($siteSetting['withdrawal'])?></span></label>
                                        </div>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#enabled" onclick="webWithdrawalStatus('enabled')">Enabled</a>
                                            <a class="dropdown-item" href="#disabled" onclick="webWithdrawalStatus('disabled')">Disabled</a>
                                        </div>
                                    </div>
                                </div>
                        	</div>
                        </div>

                        <div class="mt-3">
                            <h4>Withdrawal Status Logs</h4>
                            <table class="table table-centered mb-0 mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th>User</th>
                                        <th>Activity</th>
                                        <th>Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody id="_withdrawal_status_tbl">
                                                    
                                </tbody>
                            </table>
                            <div class="mt-2" id="_withdrawal_status_pagination">
                                
                            </div>
                        </div>

                        <div class="mt-5">
                        	<h4>Maintenance Logs</h4>
                        	<table class="table table-centered mb-0 mt-3">
                               	<thead class="table-light">
                                	<tr>
                                        <th>Date & Time</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                	</tr>
                                </thead>
                                <tbody id="maintenance_tbl">
                                                    
                                </tbody>
                            </table>
                        </div>

                        

                    </div> <!-- container -->

                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

