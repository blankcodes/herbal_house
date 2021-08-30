<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>About Us - Herbal House Philippines</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Herbal House is a 100% Filipino owned company based in Leyte particularly in Tacloban City. It is a company led by passionate and goal-driven young entrepreneurs that aims to help improve the health and wellness of every individual. "/>
        <meta name="theme-color" content="#0acf67" />
        <meta name="mobile-web-app-capable" content="yes">

        <!-- Open Graph data -->
        <meta property="fb:app_id" content="" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="About Us - Herbal House Philippines" />
        <meta property="og:description" content="Herbal House is a 100% Filipino owned company based in Leyte particularly in Tacloban City. It is a company led by passionate and goal-driven young entrepreneurs that aims to help improve the health and wellness of every individual. " />
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
        <meta name="twitter:title" content="About Us - Herbal House Philippines">
        <meta name="twitter:description" content="Herbal House is a 100% Filipino owned company based in Leyte particularly in Tacloban City. It is a company led by passionate and goal-driven young entrepreneurs that aims to help improve the health and wellness of every individual. ">
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
                                <a class="nav-link  text-success" href="<?=base_url('about')?>">About</a>
                            </li>
                            <li class="nav-item mx-lg-1">
                                <a class="nav-link c-gray" href="<?=base_url('membership')?>">Membership</a>
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

        <section class="about-section">
            <div class="hero-overlay">
                <div class="container">
                    <div class="row align-items-center">
                        <div id="web-view" class=" margin-top-200"></div>
                        <div class="col-md-8 ">
                            <div class="mt-md-4">
                                <h1 class="text-white fw-normal mb-4 hero-title">
                                    About Us
                                </h1>
                                <p class="mb-4 font-16 c-white">Herbal House is a 100% Filipino owned company based in Leyte particularly in Tacloban City. It is a company led by passionate and goal-driven young entrepreneurs that aims to help improve the health and wellness of every individual. </p>

                                <a href="<?=base_url('account/signup?utm_source=herbalhouse&utm_medium=join_btn&utm_campaign=about_page')?>" target="_blank" class="btn btn-success rounded font-15 k-btn">Join Us Now <i class="mdi mdi-arrow-right"></i> </a>
                            </div>
                        </div>
                        <div class="col-md-5 offset-md-2">
                            <div class="text-md-end mt-3 mt-md-0">
                                <img src="assets/images/startup.svg" alt="" class="img-fluid">
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
                        <div class="col-lg-5">
                            <img src="<?=base_url('assets/images/gallery/mission.webp')?>" class="rounded img-fluid abt-img-shadow" height="420" alt="mission">
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-6 mt-5">
                            <div class="">
                                <span class="fw-300 badge bg-success font-13 text-left text-uppercase abt-img-shadow p-1">Our Mission</span>
                                <h2>Leading Multilevel Marketing Business</h2>
                                <p class="mt-3 font-17"> To be part of every Filipino home who uses all Herbal House products and become one of the leading multi level marketing business in Asia.</p>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-lg-5" id="mobile-view">
                            <img src="<?=base_url('assets/images/gallery/vision.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="mission">
                        </div>
                        <div class="col-lg-1" id="mobile-view"></div>
                        <div class="col-lg-6 mt-5">
                            <div class="">
                                <span class="fw-300 badge bg-success font-13 text-left text-uppercase abt-img-shadow p-1">Our Vision</span>
                                <h2>Attain Financial Literacy, Stability and Freedom</h2>
                                <p class="mt-3 font-17">To help every Filipino individual and family attain financial literacy, stability and freedom.</p>
                            </div>
                        </div>
                        <div class="col-lg-1" id="web-view"></div>
                        <div class="col-lg-5" id="web-view">
                            <img src="<?=base_url('assets/images/gallery/vision.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="vision">
                        </div>
                    </div>

                
                    <div class="row mt-4">
                        <div class="col-lg-5">
                            <img src="<?=base_url('assets/images/gallery/core-values.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="core values">
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-5 mt-5">
                            <div class="">
                                <span class="badge bg-success font-13 text-left fw-300 text-uppercase abt-img-shadow p-1">Core Values</span>
                                <h2>To Lead</h2>
                                <p class="mt-3 font-17"> Knowledge, Skill, Attitude, Integrity, Leadership, Honesty, and Loyalty.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->


                <div class=" margin-top-90 text-center">
                    <h2 class="">Leadership Team</h2>
                    <p class="font-15">Meet the doer and builder.</p>
                    <div class="row margin-top-20 padding-bottom-50" id="_leadership_team">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body mt-2 mb-2">
                                    <img alt="mark susaya" src="<?=base_url('assets/images/team/mark-susaya.webp')?>" class="avatar-xl rounded-circle">
                                    <div>
                                        <div class="name">
                                            <label class="mt-2">Mark Susaya</label>
                                        </div>
                                        <div class="position">
                                            <label class="font-12 fw-500">Founder & Chief Executive Officer</label>
                                        </div>
                                        <div class="social">
                                            <a href="https://www.facebook.com/markjoseph.m.susaya" rel="noopener nofollow noreferrer" target="_blank" class="font-23 facebook-color facebook-c"><i class="mdi mdi-facebook"></i></a>
                                            <a href="#twitter" class="font-23 twitter-color twitter-c"><i class="mdi mdi-twitter"></i></a>
                                            <a href="#instagram" class="font-23 instagram-color instagram-c"><i class="mdi mdi-email"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row-->

            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
        <!-- Mobile Nav -->
        <div id="mobile-view" class="mobile-menu">
            <nav class="mobile-bottom-nav row">
                <div class="col-4 col-md-4">
                    <div class="mobile-nav-btn" onclick="window.location.href='<?=base_url()?>'">
                        <i class="uil-home-alt "></i> 
                        <div class="mt--28">
                            <small>Home</small>
                        </div>
                    </div>      
                </div>
                <div class="col-4 col-md-4">
                    <div class="mobile-nav-btn" onclick="window.location.href='<?=base_url('account')?>'">
                        <i class="uil-user"></i>
                        <div class="mt--28">
                            <small>Account</small>
                        </div>
                     </div>      
                 </div>
                <div class="col-4 col-md-4">       
                    <div class="mobile-nav-btn" onclick="window.location.href='<?=base_url('cart')?>'">
                        <i class="uil-shopping-trolley"></i> <span class="bounce bg-success" id="mobile_nav_cart_alert"></span>
                        <div class="mt--28">
                            <small>Cart</small>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- End Mobile Nav -->
