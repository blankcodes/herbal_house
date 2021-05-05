            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <div class="page">
                <div class="content">
                    <!-- Topbar Start -->
                    <div class="navbar-custom" style="left: 0px !important;" id="web-view">
                        <div class="container">
                            <div class="float-start padding-top-5 margin-right-20 home-logo">
                                <a href="<?=base_url();?>"><img src="<?=base_url('assets/images/herbal-house-logo.png')?>" alt="herbal house" height="60" /></a>
                            </div>
                            <ul class="list-unstyled topbar-menu float-end mb-0">

                                <li class="dropdown notification-list d-lg-none">
                                    <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        <i class="dripicons-search noti-icon"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                                        <form class="p-3">
                                            <input type="text" class="form-control" placeholder="Search Product..." aria-label="Recipient's username">
                                        </form>
                                    </div>
                                </li>
                                
                                <li class="dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        <i class="dripicons-cart noti-icon"></i>
                                        <span id="cart_span" class="cart-icon-badge circle bg-success"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg cart-mobile-wrapper">

                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5 class="m-0">
                                                Cart
                                            </h5>
                                        </div>

                                        <div style="max-height: 230px;" data-simplebar id="cart_panel">
                                            
                                        </div>

                                        <!-- All-->
                                        <a href="<?=base_url('cart')?>" class="check-cart dropdown-item text-center">
                                            Check Cart
                                        </a>

                                    </div>
                                </li>

                                <?php if (!isset($this->session->user_id)){ ?>
                                <li class="notification-list">
                                    <a href="<?=base_url('login')?>" class="btn btn-success btn-rounded" style="display: block; margin-top: 15px; padding: 5 13px;"><i class="uil-user "></i> Login</a>
                                </li>
                                <?php } ?>

                                <?php if ($this->session->user_id){ ?>
                                 <li class="dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        <i class="dripicons-bell noti-icon"></i>
                                        <span class="noti-icon-badge bg-success"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">
                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5 class="m-0">
                                                <span class="float-end">
                                                    <a href="javascript: void(0);" class="text-dark">
                                                        <small>Clear All</small>
                                                    </a>
                                                </span>Notification
                                            </h5>
                                        </div>

                                        <div style="max-height: 230px;" data-simplebar id="notif_pannel">
                                            
                                        </div>

                                        <!-- All-->
                                        <a href="javascript:void(0);" class="check-cart dropdown-item text-center notify-item notify-all">
                                            View All
                                        </a>

                                    </div>
                                </li>

                                <li class="dropdown notification-list">
                                    <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#drop" role="button" aria-haspopup="false"
                                        aria-expanded="false">
                                        <span class="account-user-avatar"> 
                                            <i class="uil-user-circle " style="font-size: 30px; margin-top: -8px;"></i>
                                        </span>
                                        <span>
                                            <span class="account-user-name text-capitalize"><?=$userData['fname'].' '.$userData['lname'];?></span>
                                            <span class="account-position text-capitalize"><?=$userData['user_type']?></span>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">

                                        <!-- item-->
                                        <a href="<?=base_url('account')?>" class="dropdown-item notify-item">
                                            <i class="mdi mdi-account-circle me-1"></i>
                                            <span>My Account</span>
                                        </a>

                                        <!-- item-->
                                        <a href="<?=base_url('member/settings')?>" class="dropdown-item notify-item">
                                            <i class="mdi mdi-account-edit me-1"></i>
                                            <span>Settings</span>
                                        </a>

                                        <!-- item-->
                                        <a href="<?=base_url('logout')?>" class="dropdown-item notify-item">
                                            <i class="mdi mdi-logout me-1"></i>
                                            <span>Logout</span>
                                        </a>
                                    </div>
                                </li>
                               <?php } ?>

                            </ul>
                            <button class="button-menu-mobile open-left disable-btn" onclick="window.location.href='<?=base_url();?>'">
                                <!-- <i class="mdi mdi-menu"></i> -->
                                <a href="<?=base_url();?>"><img src="<?=base_url('assets/images/favicon.png')?>" height="55"></a>
                            </button>


                            <div class="app-search d-none d-lg-block">
                                <form id="search_product_form">
                                    <div class="input-group">
                                        <input type="text" class="form-control dropdown-toggle" name="keyword" placeholder="Search Product..." id="top-search">
                                        <span class="mdi mdi-magnify search-icon"></span>
                                        <button class="input-group-text btn-success" type="submit">Search</button>
                                    </div>
                                </form>

                                <div class="dropdown-menu dropdown-menu-animated dropdown-lg search-product-panel" id="search-dropdown">
                                    <!-- item-->
                                    <div class="dropdown-header noti-title">
                                        <h5 class="text-overflow mb-2" id="search_fund_title">Found <span class="text-danger" id="search_prod_count">0</span> results</h5>
                                    </div>

                                    <div id="_product_search_result" class="mb-1">
                                        <!-- item-->
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- end Topbar -->

                         