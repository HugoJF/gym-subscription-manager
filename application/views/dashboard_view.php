<div class="container marketing">
	<div class="row">
		<div class="span12">

			<!-----------------------------
			| ERROR/WARNING/MESSAGE BOXES |
			------------------------------>

			<br>
			<?php if($this->session->flashdata('error') != ''): ?>
				<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<?php echo $this->session->flashdata('error'); ?>
				</div>
			<?php endif; ?>
			<?php if($this->session->flashdata('warning') != ''): ?>
				<div class="alert alert-info">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<?php echo $this->session->flashdata('warning'); ?>
				</div>
			<?php endif; ?>
			<?php if($this->session->flashdata('message') != ''): ?>
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<?php echo $this->session->flashdata('message'); ?>
				</div>
			<?php endif; ?>

			<!-------
			| TITLE |
			-------->

			<h2><?php echo $this->lang->line('user_list_all'); ?></h2>
			<br>

			<!---------------------
			| MAIN TABLE OF USERS |
			---------------------->

			<div style="overflow-y: auto;width:100%;padding-bottom: 75px" id="table-wrapper">

				<?php

					foreach($tables as $table)
					{
						echo '<h4>' . $table->get_description() . ' (' . $table->get_name() . ')' . '</h4>';

						echo $table->get_element_html();
					}
				?>

			</div>
			<!-- /.table-wrapper -->
		</div>
		<!-- /.span12 -->
	</div>
	<!-- /.row -->