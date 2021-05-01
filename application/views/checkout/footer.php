
        <div>
            <!-- Footer Start -->
                <footer class="bg-dark py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <img src="assets/images/herbal-house-logo.png" alt="" class="logo-dark" height="78" />
                                <p class="text-muted mt-4">Your partner for good health. Prevention is better than cure;<br>
                                why wait for things to go wrong with your health?</p>

                                <ul class="social-list list-inline mt-3">
                                    <li class="list-inline-item text-center">
                                        <a href="https://www.facebook.com/Herbal-HOUSE-109460497862924" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                    </li>
                                    
                                    <li class="list-inline-item text-center">
                                        <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                    </li>
                                </ul>
                            </div>

                             <div class="col-lg-2 mt-4 mt-lg-0">
                                <h5 class="text-light">Discover</h5>
                                <ul class="list-unstyled ps-0 mb-0 mt-3">
                                    <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Help Center</a></li>
                                    <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Our Products</a></li>
                                    <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Privacy</a></li>
                                </ul>
                            </div>
                            
                            <div class="col-lg-2 mt-4 mt-lg-0">
                                <h5 class="text-light">Payment</h5>

                                <ul class="list-unstyled ps-0 mb-0 mt-3">
                                    <li class="mt-2"><a href="javascript: void(0);" class="text-muted">COD</a></li>
                                    <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Paypal</a></li>
                                </ul>

                            </div>

                            <div class="col-lg-2 mt-4 mt-lg-0">
                                <h5 class="text-light">Follow Us</h5>
                                <ul class="list-unstyled ps-0 mb-0 mt-3">
                                    <li class="mt-2"><a href="https://www.facebook.com/Herbal-HOUSE-109460497862924" class="text-muted"><i class="uil-facebook "></i> Facebook</a></li>
                                    <li class="mt-2"><a href="javascript: void(0);" class="text-muted"><i class="uil-twitter "></i> Twitter</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mt-5">
                                    <p class="text-muted mt-4 text-center mb-0">&copy; <?=date('Y')?> HerbalHouse</p>
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