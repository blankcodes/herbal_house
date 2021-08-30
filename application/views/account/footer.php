			<div id="loader" class="loader-div" hidden>
                <div class="loader-wrapper">
                    <img src="<?=base_url('assets/images/loader.gif')?>" width="120" heigth="120">
                </div>
            </div>
        
            <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                &copy; <?=date('Y');?> Herbal House Philippines
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-md-block">
                                    <!-- <a href="javascript: void(0);">About</a>
                                    <a href="javascript: void(0);">Support</a>
                                    <a href="javascript: void(0);">Contact Us</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->
                
			</div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

		<script>
			var base_url = '<?=base_url()?>';
            var page = '<?=$page?>';
            <?php if ($page == 'user_overview') {echo 'var user_code = "'.$user_code.'";';}
            else{ echo 'var user_code = "'.$userData['user_code'].'";';} ?>
            <?php if ($page == 'order_details_admin') {echo 'var ref_no = "'.$reference_no.'";';} ?>

		</script>
    
    
		 <!-- bundle -->
		<script src="<?=base_url()?>assets/vendor/jquery-3.4.1.min.js"></script>
		<script src="<?=base_url()?>assets/js/vendor.min.js"></script>
        <script src="<?=base_url()?>assets/js/app.min.js"></script>
		<script src="<?=base_url()?>assets/js/cilpboard.min.js"></script>
        <script src="<?=base_url()?>assets/js/auth/notification.js"></script>
        <script src="<?=base_url()?>assets/js/auth/cart.js"></script>
        <script src="<?=base_url()?>assets/js/auth/_csrf.js"></script>
        
        <?php if ($page=='code_list'){ ?>
        <script src="<?=base_url()?>assets/js/auth/admin_code_list.js"></script>
        <?php }else if($page == 'order_details_admin') { ?>
        <script src="<?=base_url()?>assets/js/auth/admin_orders.js"></script>
        <?php }else if($page == 'members_page') { ?><script src="<?=base_url()?>assets/js/auth/admin_members.js"></script>
        <?php }else if($page == 'admin_ledger') { ?><script src="<?=base_url()?>assets/js/auth/admin_ledger.js"></script>
        <?php }else if($page == 'admin_walkin_buyers') { ?><script src="<?=base_url()?>assets/js/auth/admin_products.js"></script>
        <?php }else if($page == 'dashboard') { ?><script src="<?=base_url()?>assets/js/jquery.cookie.js"></script>
    <?php } ?>
    <script src="<?=base_url()?>assets/js/auth/my_account.js"></script>
        
        <script>
            $(function () {
              $('[data-toggle="tooltip"]').tooltip()
            })
        </script>

        
	</body>
</html>