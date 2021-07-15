<!-- Footer -->
<script>
	var base_url = '<?=base_url()?>';
</script>
<footer class="footer footer-alt">
   &copy; <?=date('Y');?> Herbal House Philippines
</footer>

 <!-- bundle -->
<script src="<?=base_url();?>assets/vendor/jquery-3.4.1.min.js"></script>
<?php if ($page == 'register'){ ?>
<script src="<?=base_url();?>assets/js/auth/register.js"></script>
<?php } elseif($page = 'login') { ?>
<script src="<?=base_url();?>assets/js/auth/login.js"></script>
<script src="<?=base_url();?>assets/js/auth/_csrf.js"></script>
<?php } ?>
<script src="<?=base_url();?>assets/vendor/sweetalert/sweetalert.min.js"></script>
<script src="<?=base_url();?>assets/js/vendor.min.js"></script>
<script src="<?=base_url();?>assets/js/app.min.js"></script>

</body>
</html>