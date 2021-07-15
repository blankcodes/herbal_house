<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Register Account - Herbal House Philippines</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Create an account and start earning while staying healthy."/>
        <meta name="theme-color" content="#0acf67" />
        <meta name="mobile-web-app-capable" content="yes">

        <!-- Open Graph data -->
        <meta property="fb:app_id" content="" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="Register Account - Herbal House Philippines" />
        <meta property="og:description" content="Create an account and start earning while staying healthy." />
        <meta property="og:url" content="<?=base_url('account/signup')?>" />
        <meta property="og:site_name" content="Herbal House Philippines" />
        <meta property="og:image" content="<?=base_url('assets/images/gallery/herbal-house-philippines-cover.jpg')?>" />
        <meta property="og:image:width" content="900" />
        <meta property="og:image:height" content="900" />
        <meta property="og:image:alt" content="Herbal House Philippines. Your partner for good health." />

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@herbalhouse>">
        <meta name="twitter:creator" content="@herbalhouse">
        <meta name="twitter:title" content="Register Account - Herbal House Philippines">
        <meta name="twitter:description" content="Create an account and start earning while staying healthy.">
        <meta name="twitter:image" content="<?=base_url('assets/images/gallery/herbal-house-philippines-cover.jpg')?>">

        <!-- favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png">
        <link rel="canonical" href="<?=base_url('account/signup')?>">

        <!-- Css -->
        <link href="<?=base_url()?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="<?=base_url()?>assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />  
        <link href="<?=base_url()?>assets/css/default.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/product.css" rel="stylesheet" type="text/css" />
        <script src="<?=base_url()?>assets/js/sweetalert2.all.min.js"></script>
        <?= $analyticSrc; ?>
        
        <?= $analyticData; ?>
    </head>

    <body class="loading  bg-white" data-layout-config='{"darkMode":false}'>
    <script type="application/ld+json">
    {
        "@context":"https:\/\/schema.org",
        "@type":"Organization",
        "name":"Herbal House Philippines",
        "url":"https:\/\/herbalhouseph.com\/",
        "sameAs":["https:\/\/www.facebook.com\/herbalhouseofficial"],
        "@id":"#organization",
        "logo":"<?=base_url()?>assets/images/favicon.png"
    }
    </script>

        <!-- NAVBAR START -->
         <!-- style="background-image:url(./assets/images/bg.jpg);background-position: center bottom no-repeat;" -->
        <div id="">
            <nav class="navbar navbar-expand navbar-dark navbar-home" id="web-view" style="z-index: 100; left: 0px !important;" >
                <div class="container" i>
                    <!-- logo -->
                    <a href="<?=base_url()?>" class="navbar-brand me-lg-5">
                        <img src="<?=base_url()?>assets/images/herbal-house-logo.webp" id="" alt="herbal house philippines" class="logo-dark hh-logo" />
                    </a>

                        <div class="dropdown notification-list c-black cart-nav-mobile " id="mobile-view">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="uil-shopping-cart noti-icon c-gray" style="color: #808080;"></i>
                            <span class="cart-icon-badge circle bg-success" style="top: 30px; right: 10px;"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">
                                    <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">
                                       Cart
                                    </h5>
                                </div>
                                <div style="max-height: 230px;" data-simplebar id="cart_panel_home_mobile">
                                        
                                </div>
                               <a href="<?=base_url('cart')?>" class="check-cart dropdown-item text-center">
                                    Check Cart
                                </a>
                            </div>
                        </div>
                    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#"
                        aria-controls="" aria-expanded="false" aria-label="Toggle navigation" onclick="openNav()">
                        Menu <i class="mdi mdi-menu"></i>
                    </button>
                    <div id="mySidenav" class="sidenav mobile-view">
                        <a class="closebtn" onclick="closeNav()">&times;</a>
                        <a class="nav-link active" href="#shop_now">Products</a>
                        <a class="nav-link active" href="#contact_us">Contact</a>
                        <a class="nav-link active" href="<?=base_url('about')?>">About</a>
                        <a class="nav-link active" href="<?=base_url('login')?>">Account</a>
                    </div>
                    <!-- menus -->
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">

                        <!-- left menu -->
                        <ul class="navbar-nav me-auto align-items-center text-uppercase fw-500">
                            <li class="nav-item mx-lg-1">
                            </li>
                            <li class="nav-item mx-lg-1">
                                <a class="nav-link active c-gray" href="<?=base_url()?>#shop_now">Products <i class="uil uil-angle-down"></i></a>
                            </li>
                            <li class="nav-item mx-lg-1">
                                <a class="nav-link active c-gray" href="<?=base_url()?>#contact_us">Contact</a>
                            </li>
                            <li class="nav-item mx-lg-1">
                                <a class="nav-link active c-gray" href="<?=base_url('about')?>">About</a>
                            </li>
                            <li class="nav-item mx-lg-1">
                                <a class="nav-link active c-gray" href="<?=base_url('membership')?>">Membership</a>
                            </li>
                        </ul>

                        <!-- right menu -->
                        <ul class="navbar-nav ms-auto align-items-center">
                            <li class="dropdown notification-list" id="web-view">
                                <a class="nav-link dropdown-toggle arrow-none cart-icon-home" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-cart noti-icon c-gray"></i>
                                <span class="cart-icon-badge bg-success" style="top: 30px; "></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5 class="m-0">
                                           Cart
                                        </h5>
                                    </div>
                                    <div style="max-height: 230px;" data-simplebar id="cart_panel">
                                            
                                    </div>
                                   <a href="<?=base_url('cart')?>" class="check-cart dropdown-item text-center">
                                        Check Cart
                                    </a>
                                </div>
                            </li>&nbsp;&nbsp;&nbsp;&nbsp;
                            <li class="nav-item me-0">
                                <!-- <a href="#">Shop now</a> -->
                                <a href="<?=base_url('login')?>" class="btn btn-sm btn-success btn-rounded text-uppercase padding-right-15 padding-left-15 d-none d-lg-inline-flex">
                                   Login
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>
            <!-- NAVBAR END -->
                    <!-- Start Content-->
                    <div class="container" style="">
                        <div class="product_section mb-3 search_wrapper_home" style="margin-bottom: -90px !important; ">
                            <form id="_mobile_search_product_form">
                                <div class="d-flex search-mobile-product-wrapper">
                                    <input type="text" id="_mobile_search_product" name="keyword" class="form-control search-mobile-product" placeholder="Search products...">
                                    <span class="uil-search search-mobile-icon" ></span>
                                </div>
                            </form>
                            <div class="search-result-wrapper" id="search_result_panel" hidden="hidden">
                                <div class="header padding-right-10 padding-left-10" id="search_header__">
                                    Found <span class="text-success">0</span> results.
                                </div>
                                <div id="_search_result_wrapper">
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- start page title -->
                        <!-- <div class="row margin-top-100">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Herbal House</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Register Account</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Register Account</h4>
                                </div>
                            </div>
                        </div>  -->    
                        <!-- end page title --> 

                        <section class="registration-section margin-top-140">
                            <div class="hero-overlay">
                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                            <div class="mt-md-4 margin-top-50">
                                                <h1 class="text-white text-center text-uppercase fw-600 mb-4 hero-title">
                                                    Account Registration
                                                </h1>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </section>
                    <div class="account-pages margin-top-90">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 ">
                                    <div class="alert alert-light fade show c-gray">
                                        <p class="mt-1">Join Herbal House Philippines and start Earning at Home through E-commerce and Dropshipping while Staying Healthy. Check the benefits on <a target="_blank" rel="noopener" href="<?=base_url('membership')?>">Membership</a> page.
                                        </p>
                                    </div>


                                    <form id="_register_form">
                                        <h2 class="margin-top-30 font-25">Fill the form below</h2>
                                        <div class="mt-3">
                                            <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" role="alert" id="_package_details" hidden="hidden">
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                <b class="fw-600">Package <span class="text-uppercase" id="_package_initial"></span> details:</b>
                                                <div class="mt-2">
                                                    You will get:
                                                    <div id="_package_choosen">
                                                        
                                                    </div>
                                                
                                                </div>
                                            </div>

                                            <label class="fw-500 mb-1">Select Package</label>
                                            <select class="form-control select2" name="package_used" data-toggle="select2" id="_select_package" required="">
                                                <option disabled="" selected="">Select Package</option>
                                                <option value="a">Package A</option>
                                                <option value="b">Package B</option>
                                                <option value="c">Package C</option>
                                                <option value="d">Package D</option>
                                                <option value="e">Package E</option>
                                                <option value="f">Package F</option>
                                            </select>
                                            <small>*Bundle products you will get. Check <a href="<?=base_url('membership')?>" target="_blank" rel="noopener">Membership page</a>.</small>
                                        </div>
                                        <!-- <input type="hidden" id="_package_code" name="package_code" value="" required> -->

                                        <div class="form-floating mb-2 mt-2">
                                            <input type="text" class="form-control" name="username" value="" id="username" placeholder="Enter username" required autofocus="autofocus" />
                                            <label for="username" class="fw-400">Username</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" name="fname" value="" id="fname" placeholder="Enter First Name" required />
                                            <label for="fname" class="fw-400">First Name</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" name="lname" value="" id="lname" placeholder="Enter Last Name" required />
                                            <label for="lname" class="fw-400">Last Name</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input type="text" maxlength="11" class="form-control" name="mobile_number" value="09" id="mobile_number" placeholder="Enter Mobile Number" required  />
                                            <label for="mobile_number" class="fw-400">Mobile Number</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input type="email" class="form-control" name="email_address" id="email_address" placeholder="Email Address" required  />
                                            <label for="email_address" class="fw-400">Email Address</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" name="address" id="address" placeholder="dAddress" required  />
                                            <label for="address" class="fw-400">Address</label>
                                            <small>This address will be used for shipping the products to your location. Make sure it's accurate.</small>
                                        </div>

                                        <div class="form-floating">
                                            <input type="password" class="form-control" name="password" value="" id="password" placeholder="Enter Password" required autofocus="autofocus" />
                                            <label for="password" class="fw-400">Password</label>
                                            <div class="mt-2 pointer-cursor" data-password="false">
                                                <span class="password-eye pointer-cursor"></span> <small id="show_pass_reg">Show/Hide Password</small>
                                            </div>
                                        </div>
       
                                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                        <div class="mb-5">
                                            <button class="btn btn-success rounded btn-lg mt-4 font-16" type="submit" id="register_user_btn"> Register Account</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div> <!-- container -->

                </div> <!-- content -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

            <div id="watch-video" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <h3 class="modal-title" id="standard-modalLabel"><i class="uil-video"></i> How You can Earn on Herbal House Philippines</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-2 mb-2">
                                <div class=" text-center">
                                    <div class="row">
                                        <div class="col-lg-1"></div>
                                        <div class="col-lg-10">
                                            <!-- <div class="ratio ratio-4x3 ">
                                                <iframe src="https://www.youtube.com/embed/NniUoSJqiMY?autohide=0&showinfo=0&controls=0" class="br-10"></iframe>
                                            </div> -->
                                        </div>
                                        <div class="col-lg-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light rounded" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
        <!-- END wrapper -->

        <!-- Mobile Nav -->
        <div id="mobile-view" class="mobile-menu">
            <nav class="mobile-bottom-nav row">
                <div class="col-4 col-md-4">
                    <div class="mobile-nav-btn" onclick="window.location.href='<?=base_url()?>'">
                        <i class="uil-home-alt"></i> 
                    </div>      
                </div>
                <div class="col-4 col-md-4">
                    <div class="mobile-nav-btn" onclick="window.location.href='<?=base_url('account')?>'">
                        <i class="uil-user"></i>
                    </div>      
                </div>
                <div class="col-4 col-md-4">       
                    <div class="mobile-nav-btn" onclick="window.location.href='<?=base_url('cart')?>'">
                        <i class="dripicons-cart"></i> <span class="bounce bg-success" id="mobile_nav_cart_alert"></span>
                    </div>
                </div>
            </nav>
        </div>
        <!-- End Mobile Nav -->

        <?php if (isset($_GET['ref'])){
            $user = $this->db->WHERE('username', $_GET['ref'])->GET('user_tbl')->row_array();
            if (isset($user) && !isset($this->session->username)) {
                $this->session->set_userdata('referrer', $user['username']);
            }
        }?>
