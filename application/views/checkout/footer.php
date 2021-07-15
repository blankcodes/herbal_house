
        <div>
            <!-- Footer Start -->
            <footer class="bg-dark py-4 font-13">
                <div class="container">
                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <a href="<?=base_url()?>"><img src="<?=base_url()?>assets/images/herbal-house-logo.webp" alt="" class="logo-dark" height="78" /></a>
                            <p class="text-muted mt-2">Your partner for good health. </p>

                            <ul class="social-list list-inline mt-3">
                                <li class="list-inline-item text-center">
                                    <a href="https://web.facebook.com/herbalhouseofficial" target="_blank" rel="noopener nofollow" class="btn btn-social-outline btn-social facebook-c"><i class="uil-facebook-f font-18"></i></a>
                                </li>
                                <li class="list-inline-item text-center">
                                    <a href="javascript: void(0);" class="btn btn-social-outline btn-social twitter-c "><i class="uil-twitter font-18"></i></a>
                                </li>
                                <li class="list-inline-item text-center">
                                    <a href="javascript: void(0);" class="btn btn-social-outline btn-social instagram-c "><i class="uil-instagram font-18"></i></a>
                                </li>
                            </ul>
                        </div>

                         <div class="col-lg-2 col-6 mt-4 mt-lg-0">
                            <h5 class="text-light font-13">Company</h5>
                            <ul class="list-unstyled ps-0 mb-0 mt-3">
                                <li class="mt-2"><a href="<?=base_url('about')?>" class="text-muted">About Us</a></li>
                                <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Blog</a></li>
                                <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Terms</a></li>
                                <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Privacy</a></li>
                                <li class="mt-2"><a href="<?=base_url('login')?>" class="text-muted">Account</a></li>
                            </ul>
                        </div>
                        
                        <div class="col-lg-2 col-6 mt-4 mt-lg-0">
                            <h5 class="text-light font-13">Categories</h5>

                            <ul class="list-unstyled ps-0 mb-0 mt-3">
                                <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Dietary Supplement</a></li>
                                <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Food Supplement</a></li>
                                <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Juice</a></li>
                                <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Coffee</a></li>
                            </ul>

                        </div>

                        <div class="col-lg-2 col-6 mt-4 mt-lg-0">
                            <h5 class="text-light font-13">Follow Us</h5>
                            <ul class="list-unstyled ps-0 mb-0 mt-3">
                                <li class="mt-2"><a target="_blank" href="https://web.facebook.com/herbalhouseofficial" class="text-muted"><i class="uil-facebook "></i> Facebook</a></li>
                                <li class="mt-2"><a href="javascript: void(0);" class="text-muted"><i class="uil-twitter "></i> Twitter</a></li>
                                <li class="mt-2"><a href="javascript: void(0);" class="text-muted"><i class="uil-instagram "></i> Instagram</a></li>
                            </ul>
                        </div>
                    </div>


                    <div class="row footer-bt mt-3">
                        <div class="col-md-6 mt-4">
                            <span class="text-muted font-13">&copy; All rights reserved. Herbal House Philippines</span>
                        </div>
                        <div class="col-md-6 mt-4 web-view">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="javascript: void(0);" class="font-13">Support</a>
                                <a href="javascript: void(0);" class="font-13">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
                <!-- end Footer -->
        </div>
        <!-- END wrapper -->

        <script>
            var base_url = '<?=base_url()?>';
            var page = '<?=$page?>';
            <?php if ($page == 'shop_product') { ?>var product_pub_id = '<?=$product['p_pub_id'];?>';<?php } ?>

        </script>

         <!-- bundle -->
        <script src="<?=base_url()?>assets/vendor/jquery-3.4.1.min.js"></script>
        <script src="<?=base_url()?>assets/js/vendor.min.js"></script>
        <script src="<?=base_url()?>assets/js/app.min.js"></script>
        <script src="<?=base_url()?>assets/js/auth/cart.js"></script>
        <script src="<?=base_url()?>assets/js/auth/checkout.js"></script>
        <script src="<?=base_url()?>assets/js/auth/_csrf.js"></script>
        <?php if (isset($this->session->user_id)){ ?><script src="<?=base_url()?>assets/js/auth/notification.js"></script>
        <?php } ?>

        <!-- third party js -->
        <script src="<?=base_url()?>assets/vendor/sweetalert/sweetalert.min.js"></script>
    </body>
</html>