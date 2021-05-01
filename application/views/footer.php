        <div id="loader" class="loader-div" hidden>
            <div class="loader-wrapper">
                <img src="<?=base_url('assets/images/loader.gif')?>" width="120" heigth="120">
            </div>
        </div>
        <!-- START FOOTER -->
        <footer class="bg-dark py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <img src="assets/images/herbal-house-logo.png" alt="" class="logo-dark" height="78" />
                        <p class="text-muted mt-4">Your partner for good health. Prevention is better than cure;
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

                     <div class="col-lg-2 col-6 mt-4 mt-lg-0">
                        <h5 class="text-light">Discover</h5>
                        <ul class="list-unstyled ps-0 mb-0 mt-3">
                            <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Help Center</a></li>
                            <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Our Products</a></li>
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

                <div class="row">
                    <div class="col-lg-12">
                        <div class="mt-5">
                            <p class="text-muted mt-4 text-center mb-0">&copy; <?=date('Y')?> HerbalHouse</p>
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