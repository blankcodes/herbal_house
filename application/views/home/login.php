<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Log In - Herbal House Philippines</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Log In - Herbal House Philippines" />
        <meta name="theme-color" content="#0acf67" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.png">
        
        <!-- App css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
        <link href="assets/css/default.css" rel="stylesheet" type="text/css" />
        
    </head>

    <body class="loading">
        <div class="account-pages mt-3">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-5">
                        <div class="card ">
                            <div id="" style="margin-top: -50px;"></div>
                            <!-- Logo -->
                            <div class="card-header pt-4 pb-4 text-center bg-success rounded">
                                <span>
                                    <a href="<?=base_url();?>">
                                        <h3 class="c-white fw-500"><img src="<?=base_url('assets/images/favicon.png')?>" height="45"> Herbal House <br>
                                            <!-- <small class="c-white" style="margin-left: 50px !important;margin-top: -50px !important;">Business Helping Program</small> -->
                                        </h3>
                                    </a>
                                </span>
                            </div>

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center mt-0 fw-bold mb-2">Log In Account</h4>
                                </div>

                                <form action="#" id="login_form">
                                    <input type="hidden" name="last_url" value="<?=(isset($_GET['r'])) ? $_GET['r'] : '';?>">
                                    
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="username"  name="username" required="" placeholder="Enter your Username" />
                                        <label for="username" class="fw-400">Username</label>
                                    </div>


                                    <div class="form-floating ">
                                        <input type="password" id="password" name="password" class="form-control " placeholder="Enter your password" />
                                        <label for="password" class="fw-400">Password</label>
                                       <!--  <div class="input-group-text" data-password="false">
                                            <span class="password-eye pointer-cursor"></span>
                                        </div> -->
                                    </div>
                                    <div class="mt-1 text-sm-end">
                                        <div class="mt-1 pointer-cursor">
                                            <small id="show_password"><span class="pointer-cursor" ></span><i class="uil-eye "></i> Show Password</small>
                                            <small hidden id="hide_password"><span class="pointer-cursor" ></span><i class="uil-eye-slash "></i> Hide Password</small>
                                        </div>
                                    </div>



                                    <div class="mt-3 mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" value="<?=$login_token?>" name="remember_login" id="remember_login" checked>
                                            <label class="form-check-label" for="remember_login">Remember me</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                    <div class="mb-3 mb-0 text-center">
                                        <button class="btn btn-success rounded k-btn btn-lg col-lg-12 col-12 font-17" id="login_btn" type="submit"> Log In </button>
                                    </div>

                                    <div class="text-center mt-1 mb-3">
                                        <button type="button" class="btn-link btn" id="_forgot_password">Forgot Password</button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <!-- Mobile Nav -->
                        <div id="mobile-view" class="mobile-menu">
                            <nav class="mobile-bottom-nav row">
                                <div class="col-4 col-md-4">
                                    <div class="mobile-nav-btn" onclick="_accessPage('<?=base_url()?>')">
                                        <i class="uil-home-alt"></i> 
                                        <div class="mt--28 ">
                                            <small>Home</small>
                                        </div>
                                    </div>      
                                </div>
                                <div class="col-4 col-md-4">
                                    <div class="mobile-nav-btn" onclick="_accessPage('<?=base_url('account')?>')">
                                        <i class="uil-user active"></i>
                                        <div class="mt--28 active">
                                            <small>Account</small>
                                        </div>
                                    </div>      
                                </div>
                                <div class="col-4 col-md-4">       
                                    <div class="mobile-nav-btn" onclick="_accessPage('<?=base_url('cart')?>')">
                                        <i class="uil-shopping-trolley"></i> <span class="bounce bg-success" id="mobile_nav_cart_alert"></span>
                                        <div class="mt--28">
                                            <small>Cart</small>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                        <!-- End Mobile Nav -->

                        <!-- <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted">Don't have an account? <a href="./register" class="text-muted ms-1"><b>Register here</b></a>.</p>
                            </div> 
                        </div> -->
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
