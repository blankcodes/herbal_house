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
        <footer class="bg-dark py-4 font-13 ">
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
                            <li class="mt-2"><a href="#about_us" onclick="_accessPage('<?=base_url('about')?>')" class="text-muted">About Us</a></li>
                            <li class="mt-2"><a href="#membership" onclick="_accessPage('<?=base_url('membership')?>')" class="text-muted">Membership</a></li>
                            <li class="mt-2"><a href="#signup" onclick="_accessPage('<?=base_url('account/signup')?>')" class="text-muted">Sign Up</a></li>
                            <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Terms</a></li>
                            <li class="mt-2"><a href="javascript: void(0);" class="text-muted">Privacy</a></li>
                        </ul>
                    </div>
                    
                    <div class="col-lg-2 col-6 mt-4 mt-lg-0">
                        <h5 class="text-light font-13">Categories</h5>

                        <ul class="list-unstyled ps-0 mb-0 mt-3">
                        <?php  foreach($this->products_model->getProductCategoryLimit() as $q) { ?>
                            <li class="mt-2"><a href="#category" onclick="_accessPage('<?=base_url('product/category/').$q['category_url']?>')"  rel="noopener" class="text-muted"><?=$q['name']?></a></li>
                        <?php } ?>
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
                            <a href="http://dev.kenkarlo.com" target="_blank" class="font-13">Developed by Kenkarlo</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- END FOOTER -->
        <script src="<?=base_url()?>assets/js/vendor.js"></script>
        <script src="<?=base_url()?>assets/js/app.js"></script>
        <script>
        	var base_url = '<?=base_url();?>';
        	var page = '<?=$page;?>';
<?php if (isset($nonce['hash'])) { ?>
            <?= 'var nonce = "'.$nonce['hash'].'";'; ?><?php } ?>
            
        </script>
        <!-- bundle -->
        <script src="<?=base_url()?>assets/js/auth/cart.js"></script>
        <script src="<?=base_url()?>assets/js/auth/_csrf.js"></script>
        <script src="<?=base_url()?>assets/js/auth/_products.js"></script>
        <script src="<?=base_url()?>assets/js/auth/_contact.js"></script>
        <script src="<?=base_url()?>assets/js/auth/_access.js"></script>
        <script src="<?=base_url()?>assets/js/auth/app.js"></script>
<?php if ($page == 'register_new_account'){ ?><script src="<?=base_url()?>assets/js/auth/_register.js"></script><?php } ?>
    </body>

</html>