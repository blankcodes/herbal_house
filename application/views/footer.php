        <div id="loader" class="loader-div" hidden>
            <div class="loader-wrapper">
                <img src="<?=base_url('assets/images/loader.gif')?>" width="120" heigth="120">
            </div>
        </div>

        <!-- Warning Alert Modal -->
        <div id="_product_warning_modal" class="modal margin-top-50" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"> 
            <div class="modal-dialog modal-md ">
                <div class="modal-content rounded-modal">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="uil-exclamation-triangle h1 text-warning"></i>
                            <h2 class="mt-2 font-23" id="err_title"></h2>
                            <p class="mt-3" id="err_message"></p>
                            <button type="button" class="btn btn-warning my-2 rounded" onclick="window.location.reload()">Refresh</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- START FOOTER -->
        <footer class="bg-dark py-4 font-13">
            <div class="container">
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <a href="<?=base_url()?>"><img src="<?=base_url()?>assets/images/herbal-house-logo.webp" alt="herbal house philippines" class="logo-dark" height="78" /></a>
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

        <!-- <div class="footer-below-3rd" style="">
            <div class="container pad-20">
            <div class="text-center margin-top-10 ">
                <div class="row">
                     <div class="copy-wrapper col-lg-4 col-12 mt-3">
                         <p class="c-gray">Payment Method We Accept</p>
                        <div>
                            <a rel="noopener" href="#payment-availability"><img style="width: 330px;" src="<?=base_url()?>assets/images/payments/payment-available.png" alt="payment methods"></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12 ">
                            
                    </div>

                    <div class="col-lg-4 col-12 margin-top-20 mb-3">
                        <div class=" text-start" style="">
                            <span class="mt-2 mb-2" id="">
                                <script type="text/javascript"> //<![CDATA[
                                    var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");
                                    document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
                                //]]></script>
                                <script language="JavaScript" type="text/javascript">
                                    TrustLogo("https://sectigo.com/images/seals/sectigo_trust_seal_sm_2x.png", "SECEV", "none");
                                </script>
                            </span>

                            <span class="">
                                <a href="https://transparencyreport.google.com/safe-browsing/search?url=https:%2F%2Fherbalhouseph.com&hl=en" title="Google Safe Browsing" onclick="javascript:window.open('https://transparencyreport.google.com/safe-browsing/search?url=https:%2F%2Fherbalhouseph.com&hl=en','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;">
                                    <img class="mt-2 mb-2 margin-right-5 margin-left-5" style="height:42px;border-radius: 10px;" src="<?=base_url('assets/images/google-safe-browsing.jpg')?>" alt="Google Safe Browsing">
                                </a>
                            </span>

                            <span class="">
                                <a href="https://www.paypal.com/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;">
                                <img class="mt-2 mb-2 margin-right-5 margin-left-5" style="height:42px; border-radius: 10px;" src="https://www.paypalobjects.com/digitalassets/c/website/marketing/na/us/logo-center/9_bdg_secured_by_pp_2line.png" alt="Secured by PayPal">
                                </a>
                            </span>



                        </div>
                    </div>

                    

                </div>
            </div>
        </div>
    </div> -->
    
        <!-- END FOOTER -->
        <script src="<?=base_url()?>assets/js/vendor.min.js"></script>
        <script>
        	var base_url = '<?=base_url();?>';
        	var page = '<?=$page;?>';
<?php if (isset($nonce['hash'])) { ?>
            <?= 'var nonce = "'.$nonce['hash'].'";'; ?><?php } ?>
            
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
        <script src="<?=base_url()?>assets/js/app.min.js"></script>
        <script src="<?=base_url()?>assets/js/auth/cart.js"></script>
        <script src="<?=base_url()?>assets/js/auth/_csrf.js"></script>
        <script src="<?=base_url()?>assets/js/auth/_products.js"></script>
        <script src="<?=base_url()?>assets/js/auth/_contact.js"></script>
<?php if ($page == 'register_new_account'){ ?><script src="<?=base_url()?>assets/js/auth/_register.js"></script><?php } ?>
    </body>

</html>