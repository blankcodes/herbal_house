<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Herbal House - Business Helping Porgram</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Explore Herbal House - Business Helping Porgram Herbal and Healthy products. Your partner for good health."/>
        <meta name="theme-color" content="#0acf67" />
        <meta name="mobile-web-app-capable" content="yes">

        <!-- Open Graph data -->
        <meta property="fb:app_id" content="" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="Herbal House - Business Helping Porgram" />
        <meta property="og:description" content="Your partner for good health." />
        <meta property="og:url" content="<?=base_url()?>" />
        <meta property="og:site_name" content="Herbal House - Business Helping Porgram" />
        <meta property="og:image" content="<?=base_url('assets/images/bg2.jpg')?>" />
        <meta property="og:image:width" content="800" />
        <meta property="og:image:height" content="800" />
        <meta property="og:image:alt" content="Herbal House - Business Helping Program" />

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@herbalhouse>">
        <meta name="twitter:creator" content="@herbalhouse">
        <meta name="twitter:title" content="Herbal House - Business Helping Program">
        <meta name="twitter:description" content="Your partner for good health.">
        <meta name="twitter:image" content="Herbal House - Business Helping Progra">

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png">

        <!-- App css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />  
        <link href="assets/css/default.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/product.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="loading" data-layout-config='{"darkMode":false}'>

        <!-- NAVBAR START -->
         <!-- style="background-image:url(./assets/images/bg.jpg);background-position: center bottom no-repeat;" -->
        <div id="web-view">
            <nav class="navbar navbar-expand-lg py-lg-3 navbar-dark" style="z-index: 100;">
                <div class="container">

                    <!-- logo -->
                    <a href="<?=base_url()?>" class="navbar-brand me-lg-5">
                        <img src="assets/images/herbal-house-logo-light.png" alt="" class="logo-dark hh-logo" />
                    </a>

                        <div class="dropdown notification-list cart-nav-mobile " id="mobile-view">
                            <a class="nav-link dropdown-toggle arrow-none c-white" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="dripicons-cart noti-icon"></i>
                            <span id="cart_span" class="cart-icon-badge circle bg-success" style="top: 30px; right: 10px;"></span>
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
                        <a  class="closebtn" onclick="closeNav()">&times;</a>
                        <a class="nav-link active" href="#shop_now">Products</a>
                        <a class="nav-link active" href="#contact_us">Contact</a>
                        <a class="nav-link active" href="<?=base_url('about')?>">About</a>
                        <a class="nav-link active" href="<?=base_url('login')?>">Account</a>
                    </div>
                    <!-- menus -->
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">

                        <!-- left menu -->
                        <ul class="navbar-nav me-auto align-items-center">
                            <li class="nav-item mx-lg-1">
                            </li>
                            <li class="nav-item mx-lg-1">
                                <a class="nav-link active" href="#shop_now">Products</a>
                            </li>
                            <li class="nav-item mx-lg-1">
                                <a class="nav-link active" href="#contact_us">Contact</a>
                            </li>
                            <li class="nav-item mx-lg-1">
                                <a class="nav-link active" href="<?=base_url('about')?>">About</a>
                            </li>
                            <li class="nav-item mx-lg-1">
                                <a class="nav-link active" href="<?=base_url('login')?>">Account</a>
                            </li>
                        </ul>

                        <!-- right menu -->
                        <ul class="navbar-nav ms-auto align-items-center">
                            <li class="dropdown notification-list" id="web-view">
                                <a class="nav-link dropdown-toggle arrow-none c-white" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-cart noti-icon"></i>
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
                                <a href="#shop_now" class="btn btn-sm btn-light btn-rounded d-none d-lg-inline-flex">
                                    <i class="uil-cart me-2"></i> Shop Now
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>
            <!-- NAVBAR END -->

            <!-- START HERO -->
            <section class="herbal-section">
                <div id="carouselExampleCaption" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img src="assets/images/bg1.jpg" alt="..." class="d-block img-fluid">
                            <div class="carousel-caption d-none d-md-block ">
                                <h3 class="text-white --carousel-text">Enjoy our delicious Coffee Products...</h3>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="assets/images/bg2.jpg" alt="..." class="d-block img-fluid">
                            <div class="carousel-caption d-none d-md-block ">
                                <h3 class="text-white --carousel-text">Food, Dietary Supplements...</h3>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="assets/images/bg.jpg" alt="..." class="d-block img-fluid">
                            <div class="carousel-caption d-none d-md-block ">
                                <h3 class="text-white --carousel-text">And Herbal Products with no side-effects.</h3>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleCaption" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleCaption" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </section>
        </div>
        <!-- END HERO -->

       <!-- START PRODUCTS -->
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
                <div class="row py-4 product_top_menu">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <h3 class="mt-0 font-30"><i class=" uil-heartbeat "></i></h3>
                            <h1 class="font-25">Explore our <span class="text-success">Herbal</span> and <span class="text-success">Healthy</span> products</h1>
                            <p class="text-muted mt-2">Prevention is better than cure;<br>
                            Why wait for things to go wrong with your health?</p>
                        </div>
                    </div>
                </div>

                <div class="row mobile_products_wrapper" id="mobile-view">
                    
                </div>


                <div class="row web-view" id="products_wrapper_home">

                </div>
                <div class="">
                    <div class="mt-3" id="products_pagination"></div>
                </div>
            </div>
        </section>
        <!-- END PRODUCTS -->

        <!-- Mobile Nav -->
        <div id="mobile-view" class="mobile-menu">
            <nav class="mobile-bottom-nav row">
                <div class="col-4 col-md-4">
                    <div class="mobile-nav-btn" onclick="window.location.href='<?=base_url()?>'">
                        <i class="uil-home-alt active"></i> home
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

        <!-- START CONTACT -->
        <section class="py-5 bg-light-lighten border-top border-bottom border-light"  id="contact_us">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <h3>Get in <span class="text-success">Touch</span></h3>
                            <p class="text-muted mt-2">Please fill out the following form and we will get back to you shortly. For more 
                                <br>information please contact us.</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center mt-3">
                    <div class="col-md-4">
                        <p class="text-muted"><span class="fw-bold">Customer Support:</span><br> <span class="d-block mt-1">+63 912345687</span></p>
                        <p class="text-muted mt-4"><span class="fw-bold">Email Address:</span><br> <span class="d-block mt-1">info@herbalhouse.com</span></p>
                        <p class="text-muted mt-4"><span class="fw-bold">Office Address:</span><br> <span class="d-block mt-1">Tacloban City</span></p>
                        <p class="text-muted mt-4"><span class="fw-bold">Office Time:</span><br> <span class="d-block mt-1">9:00AM To 6:00PM</span></p>
                    </div>

                    <div class="col-md-8">
                        <form>
                            <div class="row mt-4">
                                <div class="col-lg-6">
                                    <div class="mb-2">
                                        <label for="fullname" class="form-label">Your Name</label>
                                        <input class="form-control form-control-light" type="text" id="fullname" placeholder="Name...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-2">
                                        <label for="emailaddress" class="form-label">Your Email</label>
                                        <input class="form-control form-control-light" type="email" required="" id="emailaddress" placeholder="Enter you email...">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-lg-12">
                                    <div class="mb-2">
                                        <label for="subject" class="form-label">Your Subject</label>
                                        <input class="form-control form-control-light" type="text" id="subject" placeholder="Enter subject...">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-lg-12">
                                    <div class="mb-2">
                                        <label for="comments" class="form-label">Message</label>
                                        <textarea id="comments" rows="4" class="form-control form-control-light" placeholder="Type your message here..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12 text-end">
                                    <button class="btn btn-success btn-rounded"> <i class="mdi mdi-telegram ms-1"></i>  Send a Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- END CONTACT -->
