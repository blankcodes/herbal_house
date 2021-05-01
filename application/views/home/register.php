<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Register | Herbal House</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
		<meta name="theme-color" content="#0acf67" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png">

        <!-- App css -->
        <link href="<?=base_url()?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="<?=base_url()?>assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
        <link href="<?=base_url()?>assets/css/default.css" rel="stylesheet" type="text/css" />
        

    </head>

    <body class="loading">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-5">
                        <div class="card">
                            <!-- Logo-->
                            <div class="card-header pt-4 pb-4 text-center bg-success">
                            	<span><h2 class="c-white">Herbal House</h2></span>
                                <a href="index.html">
                                    <!-- <span><img src="assets/images/logo.png" alt="" height="18"></span> -->
                                </a>
                            </div>

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center mt-0 fw-bold">Register Account</h4>
                                    <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute </p>
                                </div>

                                <form action="#" id="register_form">

                                    <div class="mb-3">
                                        <label for="fname" class="form-label">First Name</label>
                                        <input class="form-control" type="text" id="fname" name="fname" placeholder="Enter your First name" required autofocus="autofocus">
                                    </div>

                                    <div class="mb-3">
                                        <label for="lname" class="form-label">Last Name</label>
                                        <input class="form-control" type="text" id="lname" name="lname" placeholder="Enter your Last name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mobile_number" class="form-label">Mobile Number</label>
                                        <input class="form-control" type="number" maxlength="11" id="mobile_number" name="mobile_number" required placeholder="Enter your mobile number">
                                    </div>

                                    <div class="mb-3">
                                        <label for="email_address" class="form-label">Email address</label>
                                        <input class="form-control" type="email" id="email_address" name="email_address" required placeholder="Enter your email">
                                    </div>


                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye pointer-cursor"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check pointer-cursor">
                                            <input type="checkbox" class="form-check-input" id="checkbox_signup">
                                            <label class="form-check-label " for="checkbox-signup">Read and accept our <a href="#" class="text-muted">Terms and Conditions</a></label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                    <div class="mb-3 text-center">
                                        <button class="btn btn-success" type="submit" id="register_btn"> Register</button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted">Already have account? <a href="./login" class="text-muted ms-1"><b>Log In</b></a></p>
                            </div> <!-- end col-->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
