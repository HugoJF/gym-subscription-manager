<!-- Marketing messaging and featurettes
================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->
<div class="container marketing">
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
				<table class="table table-hover table-bordered">
					<thead>
						<th><?php echo $this->lang->line('user_id'); ?></th>

						<th><?php echo $this->lang->line('user_name'); ?></th>

						<th><?php echo $this->lang->line('user_email'); ?></th>
						<th class="action-table-header"><?php echo $this->lang->line('general_actions'); ?> </th>
					</thead>
					<tbody>
						<?php foreach($users->result() as $user): ?>

							<tr class="info">

								<td><?php echo $user->id ?></td>
								<td><?php echo $user->first_name . ' ' . $user->last_name ?></td>
								<td><?php echo $user->email; ?></td>
								<td>
									<a class="btn btn-mini" href="<?php echo base_url('users/detail/' . $user->id) ?>">
										<strong>Mais Informacoes</strong>
									</a>
								</td>
							</tr>

						<?php endforeach; ?>

					</tbody>
				</table>
			</div>
		</div>
		<!-- /.row -->