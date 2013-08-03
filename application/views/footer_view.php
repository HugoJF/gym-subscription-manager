<!-- FOOTER -->
<footer>
	<p>&copy; 2013, Inc. &middot; Powered by <a href>CodeIgniter</a> & <a href>Twitter Boostrap</a></p>
</footer>

</div>
<!-- /.container -->


<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript">

	$(function () {

		$('#user_search').typeahead({

			source: function (query, process) {
				return $.getJSON(
					'ajax/user_search',
					{ query: query },
					function (data) {
						return process(data);
					});
			},
			updater: function(item) {
				this.$element[0].value = item;
				this.$element[0].form.submit();
				return item;
			}

		});

	});


</script>
</body>
</html>
