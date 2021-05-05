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
                                &copy; <?=date('Y');?> HerbalHouse.com
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-md-block">
                                    <a href="javascript: void(0);">About</a>
                                    <a href="javascript: void(0);">Support</a>
                                    <a href="javascript: void(0);">Contact Us</a>
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
            var user_code = '<?=$userData['user_code']?>';
        </script>
		 <!-- bundle -->
		<script src="<?=base_url()?>assets/vendor/jquery-3.4.1.min.js"></script>
		<script src="<?=base_url()?>assets/js/vendor.min.js"></script>
        <script src="<?=base_url()?>assets/js/app.min.js"></script>
		<script src="<?=base_url()?>assets/js/cilpboard.min.js"></script>
        <script src="<?=base_url()?>assets/js/auth/notification.js"></script>
        <script src="<?=base_url()?>assets/js/auth/cart.js"></script>
        <script src="<?=base_url()?>assets/js/auth/member_account.js"></script>
        <?php if ($page == 'settings' || $page == 'member_binary_list' || $page == 'member_binary_list_uc' || $page == 'member_binary_list_direct' ||  $page == 'register_direct'){ ?>
<script src="<?=base_url()?>assets/js/auth/member_binary.js"></script>
<script src="<?=base_url()?>assets/js/auth/_csrf.js"></script>
<?php } else if($page == 'wallet') { ?>
<script src="<?=base_url()?>assets/js/auth/_wallet.js"></script>
<?php } ?>
    <script>
        <?php if ($page == 'member_binary_list_uc' || $page == 'member_binary_list_direct') { ?>
        showBinaryTree('<?=$user_code?>');
        <?php } ?>
    </script>
	</body>
</html>