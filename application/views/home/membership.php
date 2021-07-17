<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Membership - Herbal House Philippines</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Check our Earning packages. Create an account and start earning while staying healthy."/>
        <meta name="theme-color" content="#0acf67" />
        <meta name="mobile-web-app-capable" content="yes">

        <!-- Open Graph data -->
        <meta property="fb:app_id" content="" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="Membership - Herbal House Philippines" />
        <meta property="og:description" content="Check our Earning packages. Create an account and start earning while staying healthy." />
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
        <meta name="twitter:title" content="Membership - Herbal House Philippines">
        <meta name="twitter:description" content="Check our Earning packages. Create an account and start earning while staying healthy.">
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
                                <a class="nav-link  text-success" href="<?=base_url('membership')?>">Membership</a>
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
                            <?php if (isset($this->session->username)){ ?>
                               <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user arrow-none me-0 mt-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                    aria-expanded="false">
                                    <span class="account-user-avatar"> 
                                        <?= ($userData['image']) ? '<img class="rounded-circle" src="'.base_url().$userData['image'].'">' : '<i class="uil-user-circle " style="font-size: 28px;"></i>'?>
                                    </span>
                                    <span>
                                        <span class="account-user-name text-muted text-capitalize"><?=$userData['fname'].' '.$userData['lname'];?></span>
                                        <span class="account-position text-muted text-capitalize"><?=$userData['user_type']?></span>
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
                            <?php } else { ?>
                            <li class="nav-item me-0">
                                <a href="<?=base_url('login')?>" class="btn btn-sm btn-success btn-rounded text-uppercase padding-right-20 padding-left-20 d-none d-lg-inline-flex">
                                   Login
                                </a>
                            <?php } ?>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>
        </div>

        <section class="product_section" >
            <div class="container" id="shop_now">
                <div class="mb-3 search_wrapper_home">
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
        </section>
        <section class="membership-section margin-top-30">
            <div class="hero-overlay">
                <div class="container">
                    <div class="row align-items-center">
                        <div id="web-view" class=" margin-top-200"></div>
                        <div class="col-md-12">
                            <div class="mt-md-4">
                                <h1 class="text-white text-uppercase text-center fw-600 mb-4 hero-title">
                                    Membership Packages
                                </h1>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>

        <div class="account-pages margin-top-90 padding-bottom-50">
          <div class="container ">
                <div class="row justify-content-center">
                    <div class="row">
                        <div class="col-lg-12">
                           <div class="alert alert-light fade show c-gray">
                                <p class="mt-1">Join Herbal House Philippines and start Earning at Home through E-commerce and Dropshipping while Staying Healthy for only <span class="fw-700">₱ 2,499</span>. <br>
                                Upon registration you will get:
                                    <ul>
                                        <li>Products worth ₱ 2,100 (Product packages below)</li>
                                        <li>Ready made website </li>
                                        <li>Facebook Ads training for FREE</li>
                                        <li>Unlimited ₱ 1,000 Referral Bonus</li>
                                        <li>₱ 50 Indirect Referral Bonus;</li>
                                        <li>And Unilevel bonus on your product Purchase and from Indirect Referrals</li>
                                    </ul>
                                </p>
                            </div>
                        </div>

                        <div class="margin-bottom-30 margin-top-30 text-center">
                            <h2 class="font-25 mb-2">Start Earning at Home while staying Healthy!</h2>
                                <a href="<?=base_url('account/signup?utm_source=herbalhouse&utm_medium=sign_up_btn&utm_campaign=membership_page')?>" target="_blank" class="btn btn-success rounded font-15 k-btn">Sign up Now! <i class="mdi mdi-arrow-right"></i></a>
                        </div>

                        <div class="mt-4 row">
                            <h3 class="mb-3 text-center"> Watch this Video on how you can Earn at Herbal House Philippines.</h3>
                            <div class="ratio ratio-4x3 ">
                                <iframe src="https://www.youtube.com/embed/NniUoSJqiMY?autohide=0&showinfo=0&controls=0" class="br-10 abt-img-shadow"></iframe>
                            </div>
                        </div>

                        <div class="col-lg-12 margin-top-50 mb-2">
                            <h2 class="badge bg-success font-25 text-left fw-300 abt-img-shadow p-1">Packages</h2>
                        </div>
                        <div class="col-lg-5">
                            <img src="<?=base_url('assets/images/gallery/package-a.webp')?>" class="rounded img-fluid abt-img-shadow" height="420" alt="package A">
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-5 mt-1">
                            <div class="">
                                <h3>Package A</h3>
                                <p class="mt-2 font-17"> 
                                    <ul>
                                        <li>2 Spirulina Food Supplement</li>
                                        <li>1 Purple Corn Juice</li>
                                    </ul>
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-lg-5" id="mobile-view">
                            <img src="<?=base_url('assets/images/gallery/package-b.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="package b">
                        </div>
                        <div class="col-lg-1" id="mobile-view"></div>
                        <div class="col-lg-6 mt-1">
                            <div class="">
                                <h3>Package B</h3>
                                <p class="mt-2 font-17"> 
                                    <ul>
                                        <li>2 Spirulina Food Supplement</li>
                                        <li>1 Buah Merah Juice</li>
                                    </ul>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-1" id="web-view"></div>
                        <div class="col-lg-5" id="web-view">
                            <img src="<?=base_url('assets/images/gallery/package-b.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="package b">
                        </div>
                    </div>

                
                    <div class="row mt-4">
                        <div class="col-lg-5">
                            <img src="<?=base_url('assets/images/gallery/package-c.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="package c">
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-5 mt-1">
                            <div class="">
                                <h3>Package C</h3>
                                <p class="mt-3 font-17"> 
                                    <ul>
                                        <li>2 Spirulina Food Supplement</li>
                                        <li>1 Herbal House Coffee</li>
                                    </ul>
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-lg-5" id="mobile-view">
                            <img src="<?=base_url('assets/images/gallery/package-d.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="package d">
                        </div>
                        <div class="col-lg-1" id="mobile-view"></div>
                        <div class="col-lg-6 mt-1">
                            <div class="">
                                <h3>Package D</h3>
                                <p class="mt-3 font-17"> 
                                    <ul>
                                        <li>1 Spirulina Food Supplement</li>
                                        <li>1 Mangosteen Dietary Supplement</li>
                                        <li>1 Purple Corn Juice</li>
                                     </ul>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-1" id="web-view"></div>
                        <div class="col-lg-5" id="web-view">
                            <img src="<?=base_url('assets/images/gallery/package-d.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="package d">
                        </div>
                    </div>

                
                    <div class="row mt-4">
                        <div class="col-lg-5">
                            <img src="<?=base_url('assets/images/gallery/package-e.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="package e">
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-5 mt-1">
                            <div class="">
                                <h3>Package E</h3>
                                <p class="mt-3 font-17"> 
                                    <ul>
                                        <li>1 Spirulina Food Supplement</li>
                                        <li>1 Serpentina Food Supplement</li>
                                        <li>1 Buah Merah Juice</li>
                                    </ul>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-5" id="mobile-view">
                            <img src="<?=base_url('assets/images/gallery/package-f.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="package f">
                        </div>
                        <div class="col-lg-1" id="mobile-view"></div>
                        <div class="col-lg-6 mt-1">
                            <div class="">
                                <h3>Package F</h3>
                                <p class="mt-3 font-17"> 
                                    <ul>
                                        <li>1 Serpentina Food Supplement</li>
                                        <li>1 Mangosteen Dietary Supplement</li>
                                        <li>1 Herbal House Coffee</li>
                                    </ul>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-1" id="web-view"></div>
                        <div class="col-lg-5" id="web-view">
                            <img src="<?=base_url('assets/images/gallery/package-f.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="package f">
                        </div>
                    </div>


                   
                </div>

                <div class="margin-bottom-50 margin-top-70 text-center">
                    <h2 class="font-25 mb-2">Start Earning at Home while staying Healthy</h2>
                        <a href="<?=base_url('account/signup?utm_source=herbalhouse&utm_medium=sign_up_btn&utm_campaign=membership_page')?>" target="_blank" class="btn btn-success rounded font-15 k-btn">Sign up Now <i class="mdi mdi-arrow-right"></i></a>
                </div>
                <!-- end row -->

            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
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
