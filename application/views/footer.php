        <div id="loader" class="loader-div" hidden>
            <div class="loader-wrapper">
                <img src="<?=base_url('assets/images/loader.gif')?>" width="120" heigth="120">
            </div>
        </div>
        <!-- START FOOTER -->
        <footer class="bg-dark py-4">
            <div class="container">
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <a href="<?=base_url()?>"><img src="<?=base_url()?>assets/images/herbal-house-logo.png" alt="" class="logo-dark" height="78" /></a>
                        <p class="text-muted mt-2">Your partner for good health. </p>

                        <ul class="social-list list-inline mt-3">
                            <li class="list-inline-item text-center">
                                <a href="https://www.facebook.com/Herbal-HOUSE-109460497862924" target="_blank" rel="noopener nofollow" class="btn btn-social-outline btn-social facebook-c"><i class="uil-facebook-f font-18"></i></a>
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
                        <h5 class="text-light">Company</h5>
                        <ul class="list-unstyled ps-0 mb-0 mt-3">
                            <li class="mt-2"><a href="./about" class="text-muted">About</a></li>
                            <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Terms</a></li>
                            <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Privacy</a></li>
                        </ul>
                    </div>
                    
                    <div class="col-lg-2 col-6 mt-4 mt-lg-0">
                        <h5 class="text-light">Payment</h5>

                        <ul class="list-unstyled ps-0 mb-0 mt-3">
                            <li class="mt-2"><a href="javascript: void(0);" class="text-muted">COD</a></li>
                            <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Paypal</a></li>
                        </ul>

                    </div>

                    <div class="col-lg-2 col-6 mt-4 mt-lg-0">
                        <h5 class="text-light">Follow Us</h5>
                        <ul class="list-unstyled ps-0 mb-0 mt-3">
                            <li class="mt-2"><a href="https://www.facebook.com/Herbal-HOUSE-109460497862924" class="text-muted"><i class="uil-facebook "></i> Facebook</a></li>
                            <li class="mt-2"><a href="javascript: void(0);" class="text-muted"><i class="uil-twitter "></i> Twitter</a></li>
                        </ul>
                    </div>
                </div>


                <div class="row footer-bt mt-3">
                    <div class="col-md-6 mt-4">
                        <span class="text-muted font-13">&copy; All rights reserved. HerbalHouse.com</span>
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
        <!-- END FOOTER -->
        <script>
        	var base_url = '<?=base_url();?>';
        	var page = '<?=$page;?>';
            function openNav() {
              document.getElementById("mySidenav").style.width = "250px";
            }

            /* Set the width of the side navigation to 0 */
            function closeNav() {
              document.getElementById("mySidenav").style.width = "0";
            }

            var navItems = document.querySelectorAll(".mobile-bottom-nav__item");
            navItems.forEach(function(e, i) {
                e.addEventListener("click", function(e) {
                    navItems.forEach(function(e2, i2) {
                        e2.classList.remove("mobile-bottom-nav__item--active");
                    })
                    this.classList.add("mobile-bottom-nav__item--active");
                });
            });

        </script>
        <!-- bundle -->
        <script src="<?=base_url()?>assets/js/vendor.min.js"></script>
        <script src="<?=base_url()?>assets/js/app.min.js"></script>
        <script src="<?=base_url()?>assets/js/auth/cart.js"></script>
        <script src="<?=base_url()?>assets/js/auth/_products.js"></script>

    </body>

</html>