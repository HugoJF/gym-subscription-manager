	<!-- Three columns of text below the carousel -->
	<div class="row">
		<div class="span12">
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
			<h2><?php echo $this->lang->line('user_list_all'); ?></h2>
			<br>

			<div style="overflow-y: auto;width:100%;padding-bottom: 75px" id="table-wrapper">
				<?php echo $table->get_element_html(); ?>
			</div>
		</div>
		<!-- /.row -->