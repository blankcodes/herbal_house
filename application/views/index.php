<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Herbal House Philippines - Explore our Healthy, Organic, Herbal Products</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Explore our Herbal Products, Healthy Products, Nutritious, Organic Products, Supplements, Coffee, Healthy Diet, Juice. Mangosteen, Buah Merah, Purple Corn Juice, Spirulina, Glutagen, Serpentina. Earning at Home through E-commerce and Dropshipping while Staying Healthy."/>
        <meta name="theme-color" content="#0acf67" />
        <meta name="mobile-web-app-capable" content="yes">

        <!-- Open Graph data -->
        <meta property="fb:app_id" content="" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="Herbal House Philippines" />
        <meta property="og:description" content="Your partner for good health. Explore our Healthy Option, Herbal Products, Supplements, Nutritious, Organics, Coffee, Healthy Diet, Juice. Magosteen, Buah Merah, Purple Corn Juice, Spirulina, Glutagen, Serpentina. " />
        <meta property="og:url" content="<?=base_url()?>" />
        <meta property="og:site_name" content="Herbal House Philippines. Your partner for good health." />
        <meta property="og:image" content="<?=base_url('assets/images/gallery/herbal-house-philippines-cover.webp')?>" />
        <meta property="og:image:width" content="500" />
        <meta property="og:image:height" content="500" />
        <meta property="og:image:alt" content="Herbal House Philippines. Your partner for good health." />

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@herbalhouse>">
        <meta name="twitter:creator" content="@herbalhouse">
        <meta name="twitter:title" content="Herbal House Philippines - Explore our Healthy, Organic, Herbal Products">
        <meta name="twitter:description" content="Explore our Herbal Products, Healthy Products, Nutritious, Organic Products, Supplements, Coffee, Healthy Diet, Juice. Mangosteen, Buah Merah, Purple Corn Juice, Spirulina, Glutagen, Serpentina. Earning at Home through E-commerce and Dropshipping while Staying Healthy.">
        <meta name="twitter:image" content="<?=base_url('assets/images/gallery/herbal-house-philippines-cover.jpg')?>">

        <!-- favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png">

        <!-- Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />  
        <link href="assets/css/default.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/product.css" rel="stylesheet" type="text/css" />
        <?= $analyticSrc; ?>
        
        <?= $analyticData; ?>
    </head>

    <body class="loading" data-layout-config='{"darkMode":false}'>
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
        <div id="web-view">
            <nav class="navbar navbar-expand navbar-dark" id="_home_navbar" style="z-index: 100; left: 0px !important;" >
                <div class="container">
                   
                    <!-- logo -->
                    <a href="<?=base_url()?>" class="navbar-brand me-lg-5">
                        <img src="assets/images/herbal-house-logo-light.webp" id="_logo_light" alt="herbal house philippines" class="logo-dark hh-logo" />
                        <img src="assets/images/herbal-house-logo.webp" hidden="" id="_logo_default" alt="herbal house philippines" class="logo-dark hh-logo" />
                    </a>

                        <div class="dropdown notification-list c-black cart-nav-mobile " id="mobile-view">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="uil-shopping-cart noti-icon" style="color: #fff;"></i>
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
                        <a class="closebtn" onclick="closeNav()">&times;</a>
                        <a class="nav-link active" href="#shop_now">Products</a>
                        <a class="nav-link active" href="#contact_us">Contact</a>
                        <a class="nav-link active" href="<?=base_url('about')?>">About Us</a>
                        <a class="nav-link active" href="<?=base_url('login')?>">Account</a>
                    </div>
                    <!-- menus -->
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">

                        <!-- left menu -->
                        <ul class="navbar-nav me-auto align-items-center text-uppercase fw-500">
                            <li class="nav-item mx-lg-1">
                            </li>
                            <li class="nav-item mx-lg-1">
                                <a class="nav-link active" href="#shop_now">Products <i class="uil uil-angle-down"></i></a>
                            </li>
                            <li class="nav-item mx-lg-1">
                                <a class="nav-link active" href="#contact_us">Contact</a>
                            </li>
                            <li class="nav-item mx-lg-1">
                                <a class="nav-link active" href="<?=base_url('about')?>">About Us</a>
                            </li>
                            <li class="nav-item mx-lg-1">
                                <a class="nav-link active" href="<?=base_url('membership')?>">Membership</a>
                            </li>
                            <!-- <li class="nav-item mx-lg-1">
                                <a class="nav-link active" href="<?=base_url('login')?>">Account</a>
                            </li> -->
                        </ul>

                        <!-- right menu -->
                        <ul class="navbar-nav ms-auto align-items-center">
                            <li class="dropdown notification-list" id="web-view">
                                <a class="nav-link dropdown-toggle arrow-none cart-icon-home" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
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
                                <a href="<?=base_url('login')?>" class="btn btn-sm btn-success btn-rounded text-uppercase padding-right-15 padding-left-15 d-none d-lg-inline-flex">
                                   Login
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
                            <img src="assets/images/bg1.webp" alt="herbal house philippines organic products" class="d-block img-fluid">
                            <div class="carousel-caption d-none d-md-block ">
                                <h3 class="text-white --carousel-text">Enjoy our Healthy & Organic Coffee Products...</h3>
                                <!-- <button class="btn btn-outline-light">Shop Now</button> -->
                            </div>
                       </div>
                        <div class="carousel-item">
                            <img src="assets/images/bg2.webp" alt="herbal house philippines organic products" class="d-block img-fluid">
                            <div class="carousel-caption d-none d-md-block ">
                                <h3 class="text-white --carousel-text">Juice, Dietary Supplements...</h3>
                                <!-- <button class="btn btn-outline-light">Shop Now</button> -->
                            </div>
                       </div>
                        <div class="carousel-item">
                            <img src="assets/images/bg.webp" alt="herbal house philippines organic products" class="d-block img-fluid">
                            <div class="carousel-caption d-none d-md-block ">
                                <h3 class="text-white --carousel-text">and Food Supplements with no side-effects.</h3>
                                <!-- <button class="btn btn-outline-light">Shop Now</button> -->
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


        
        <!-- START CATEGORIES -->
        <section class=" margin-bottom-30" id="web-view">
            <div class="container text-center" id="product_category">
                <h2 class="font-30"><span class="text-success">Healthy</span> and <span class="text-success">Organic</span> Products</h2>
                <p class="text-muted mt-2 font-15">Explore our Healthy products inspired by and created for a healthier life.</p>

                <div class="row mt-4" id="_category_wrapper">
                </div>
            </div>
        </section>

       <!-- START PRODUCTS MOB-->
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


                <div class=" text-center mt-4" id="mobile-view">
                    <div class="mt-2 product_cat_top_menu">
                        <div class="col-lg-12">
                            <div class="text-center">
                                 <h2 class="product-title-home"><span class="text-success">Healthy</span> and <span class="text-success">Organic</span> Products</h2>
                        <p class="text-muted mt-2 font-15">Check our Healthy products inspired by and created for a healthier life.</p>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-4" id="_mob_category_wrapper">
                        <div class="col-md-6 col-lg-3 col-6">
                            <div class="card">
                                <img src="<?=base_url()?>assets/images/category/dietary-supplements.webp" class="card-img-top" alt="Dietary Supplements">
                                <div class="card-body">
                                    <a href="#" class="btn btn-link text-success font-15 fw-600 stretched-link">Dietary Supplement <i class="uil-angle-right "></i></a>
                                </div> <!-- end card-body -->
                            </div> <!-- end card -->
                        </div>
                    </div>
                </div>

                <div class="row py-4 mt-4 product_top_menu">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <!-- <h3 class="mt-0 font-30"><i class=" uil-heartbeat "></i></h3> -->
                            <h1 class="product-title-home">Explore our <span class="text-success">Herbal</span> Products</h1>
                            <p class="text-muted mt-2 product-sub-home">Prevention is better than cure;<br>
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



        <section class=" mb-5 margin-top-40 pt-4 bg-light-lighten border-top border-light" >
            <div class="container text-center">
                <h3 class="product-title-home"><span class="">About <span class="text-success">Herbal</span> House <span class="text-success">Philippines</span></h3>
                <p class="text-muted mt-2 product-sub-home">Earning at home through E-commerce and Dropshipping while Staying Healthy.</p>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="ratio ratio-4x3 ">
                            <iframe src="https://www.youtube.com/embed/NniUoSJqiMY?autohide=0&showinfo=0&controls=0" class="br-10"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                </div>
            </div>
        </section>
        

        <!-- Mobile Nav -->
        <div id="mobile-view" class="mobile-menu">
            <nav class="mobile-bottom-nav row">
                <div class="col-4 col-md-4">
                    <div class="mobile-nav-btn" onclick="window.location.href='<?=base_url()?>'">
                        <i class="uil-home-alt active"></i> 
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
        <section class="pt-4 mb-5 pb-4 bg-light-lighten border-top border-bottom border-light"  id="contact_us">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <h3 class="product-title-home">Get in <span class="text-success">Touch</span></h3>
                            <p class="text-muted mt-2">Please fill out the following form and we will get back to you shortly. For more 
                                <br>information please contact us.</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center mt-3">
                    <div class="col-md-4">
                        <p class="text-muted"><span class="fw-bold">Customer Support:</span><br> <span class="d-block mt-1">+63 966 761 8942</span></p>
                        <p class="text-muted mt-4"><span class="fw-bold">Email Address:</span><br> <span class="d-block mt-1">herbalhouseph@gmail.com</span></p>
                        <p class="text-muted mt-4"><span class="fw-bold">Office Address:</span><br> <span class="d-block mt-1">Tacloban City</span></p>
                    </div>

                    <div class="col-md-8">
                        <form id="_contact_form">
                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            <div class="row mt-4">
                                <div class="col-lg-6">
                                    <div class="mb-2">
                                        <label for="fullname" class="form-label">Your Name</label>
                                        <input class="form-control form-control-light" type="text" name="fullname" id="_fullname" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-2">
                                        <label for="emailaddress" class="form-label">Your Email</label>
                                        <input class="form-control form-control-light" type="email" required="" name="email_address" id="_email_address" placeholder="Enter you email">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-lg-12">
                                    <div class="mb-2">
                                        <label for="subject" class="form-label">Your Subject</label>
                                        <input class="form-control form-control-light" type="text" name="subject" id="_subject" placeholder="Enter subject">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-lg-12">
                                    <div class="mb-2">
                                        <label for="comments" class="form-label">Message</label>
                                        <textarea id="_message" name="message" rows="4" class="form-control form-control-light" placeholder="Type your message here..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-success btn-rounded" id="_send_message_btn"> <i class="mdi mdi-telegram ms-1"></i>  Send a Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- END CONTACT -->
