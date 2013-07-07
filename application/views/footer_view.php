<!-- FOOTER -->
<footer>
	<p>&copy; 2013 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
</footer>

</div>
<!-- /.container -->


<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url ('assets/js/jquery.js'); ?>"></script>
<script src="<?php echo base_url ('assets/js/bootstrap.min.js'); ?>"></script>
<script>

	function prepareMenuOptions(userId) {
		var baseUrl = '<?php echo base_url(); ?>';
		if (userId == 0) {
			console.log('No userId set');
			return false;
		}
		$('#menuOptions #addPayment').attr('href', baseUrl + 'payments/add/' + userId);
		$('#menuOptions #deactivateUser').attr('href', baseUrl + 'users/deactivate/' + userId);
		console.log('set');
	}

</script>
</body>
</html>
