<!-- Footer -->
<script>
	var base_url = '<?=base_url()?>';
</script>
<footer class="footer footer-alt">
   &copy; <?=date('Y');?> HerbalHouse.com
</footer>

 <!-- bundle -->
<script src="assets/vendor/jquery-3.4.1.min.js"></script>
<?php if ($page == 'register'){ ?>
<script src="assets/js/auth/register.js"></script>
<?php } elseif($page = 'login') { ?>
<script src="assets/js/auth/login.js"></script>
<script src="assets/js/auth/_csrf.js"></script>
<?php } ?>
<script src="assets/vendor/sweetalert/sweetalert.min.js"></script>
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>

</body>
</html>