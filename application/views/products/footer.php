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
		</script>

		 <!-- bundle -->
		<script src="<?=base_url()?>assets/vendor/jquery-3.4.1.min.js"></script>
		<script src="<?=base_url()?>assets/js/vendor.min.js"></script>
		<script src="<?=base_url()?>assets/js/app.min.js"></script>
        <script src="<?=base_url()?>assets/js/auth/my_account.js"></script>
        <script src="<?=base_url()?>assets/js/auth/admin_products.js"></script>
        <script src="<?=base_url()?>assets/js/auth/admin_orders.js"></script>
        <script src="<?=base_url()?>assets/js/auth/notification.js"></script>
        <script src="<?=base_url()?>assets/js/auth/cart.js"></script>
        <script src="<?=base_url()?>assets/js/auth/_csrf.js"></script>
        <script src="<?=base_url()?>assets/js/sweetalert2.all.min.js"></script>

        <!-- quill js -->
        <script src="https://cdn.tiny.cloud/1/g1blia2o88rxqgmga9veyff1ifba6j8a2uy9gj1va25lthdn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


		<!-- third party js -->

        <script>
            tinymce.init({
                selector: 'textarea#editor_description',
                height: 500,
                plugins: 'lists',
                toolbar: 'undo redo | bold italic | bullist numlist | styleselect | link image',
                toolbar_mode: 'floating',
                entity_encoding : 'raw',
                relative_urls : false,
                target_list: [
                    {title: 'Same page', value: '_self'},
                    {title: 'New Window', value: '_blank'},
                ],
                rel_list: [
                    {title: 'None', value: ''},
                    {title: 'No Referrer', value: 'noreferrer'},
                    {title: 'No Follow', value: 'nofollow'}
                ]
            });

            tinymce.init({
                selector: 'textarea#_edit_editor_description',
                height: 500,
                plugins: 'lists',
                toolbar: 'undo redo | bold italic | bullist numlist | styleselect | link image',
                toolbar_mode: 'floating',
                entity_encoding : 'raw',
                relative_urls : false,
                target_list: [
                    {title: 'Same page', value: '_self'},
                    {title: 'New Window', value: '_blank'},
                ],
                rel_list: [
                    {title: 'None', value: ''},
                    {title: 'No Referrer', value: 'noreferrer'},
                    {title: 'No Follow', value: 'nofollow'}
                ]
            });
        </script>
        <script>
            $(function () {
              $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
	</body>
</html>