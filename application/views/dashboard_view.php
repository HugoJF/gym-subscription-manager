<div id="menuOptions" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel"><?php echo $this->lang->line ('user_options'); ?></h3>
	</div>
	<div class="modal-footer">
		<p class="text-center">
			<a id="addPayment" href="#" class="btn btn-inverse"><?php echo $this->lang->line ('payment_add'); ?></a>
			<a id="deactivateUser" href="#" class="btn btn-inverse"><?php echo $this->lang->line ('user_deactivate'); ?></a>
		</p>
	</div>
</div>


<!-- Marketing messaging and featurettes
================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->
<div class="container marketing">
	<!-- Three columns of text below the carousel -->
	<div class="row">
		<div class="span12">
			<br>
			<?php if ($this->session->flashdata ('error') != ''): ?>
				<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<?php echo $this->session->flashdata ('error'); ?>
				</div>
			<?php endif; ?>
			<?php if ($this->session->flashdata ('warning') != ''): ?>
				<div class="alert alert-info">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<?php echo $this->session->flashdata ('warning'); ?>
				</div>
			<?php endif; ?>
			<?php if ($this->session->flashdata ('message') != ''): ?>
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<?php echo $this->session->flashdata ('message'); ?>
				</div>
			<?php endif; ?>
			<h2><?php echo $this->lang->line ('user_list_all'); ?></h2>
			<br>

			<div style="overflow-y: auto;width:100%;padding-bottom: 75px" id="table-wrapper">
				<table class="table table-hover table-bordered">
					<thead>
						<?php if (strtolower (uri_string ()) == 'dashboard/user_id/desc' || uri_string () == 'dashboard/user_id'): ?>
							<th>
								<a href="<?php echo base_url ('dashboard/user_id/asc'); ?>"><?php echo $this->lang->line ('user_id'); ?>
									&#9660;</a></th>
						<?php elseif (uri_string () == 'dashboard/user_id/asc'): ?>
							<th>
								<a href="<?php echo base_url ('dashboard/user_id/desc'); ?>"><?php echo $this->lang->line ('user_id'); ?>
									&#9650;</a></th>
						<?php else: ?>
							<th>
								<a href="<?php echo base_url ('dashboard/user_id'); ?>"><?php echo $this->lang->line ('user_id'); ?></a>
							</th>
						<?php endif; ?>


						<?php if (strtolower (uri_string ()) == 'dashboard/name/desc' || uri_string () == 'dashboard/name'): ?>
							<th>
								<a href="<?php echo base_url ('dashboard/name/asc'); ?>"><?php echo $this->lang->line ('user_name'); ?>
									&#9660;</a></th>
						<?php elseif (uri_string () == 'dashboard/name/asc'): ?>
							<th>
								<a href="<?php echo base_url ('dashboard/name/desc'); ?>"><?php echo $this->lang->line ('user_name'); ?>
									&#9650;</a></th>
						<?php else: ?>
							<th>
								<a href="<?php echo base_url ('dashboard/name'); ?>"><?php echo $this->lang->line ('user_name'); ?></a>
							</th>
						<?php endif; ?>


						<?php if (strtolower (uri_string ()) == 'dashboard/payment_date/desc' || uri_string () == 'dashboard/payment_date'): ?>
							<th>
								<a href="<?php echo base_url ('dashboard/payment_date/asc'); ?>"><?php echo $this->lang->line ('payment_date'); ?>
									&#9660;</a></th>
						<?php elseif (uri_string () == 'dashboard/payment_date/asc'): ?>
							<th>
								<a href="<?php echo base_url ('dashboard/payment_date/desc'); ?>"><?php echo $this->lang->line ('payment_date'); ?>
									&#9650;</a></th>
						<?php else: ?>
							<th>
								<a href="<?php echo base_url ('dashboard/payment_date'); ?>"><?php echo $this->lang->line ('payment_date'); ?></a>
							</th>
						<?php endif; ?>

						<?php if (strtolower (uri_string ()) == 'dashboard/payment_valid_until/desc' || uri_string () == 'dashboard/payment_valid_until'): ?>
							<th>
								<a href="<?php echo base_url ('dashboard/payment_valid_until/asc'); ?>"><?php echo $this->lang->line ('payment_valid_until'); ?>
									&#9660;</a></th>
						<?php elseif (uri_string () == 'dashboard/payment_valid_until/asc'): ?>
							<th>
								<a href="<?php echo base_url ('dashboard/payment_valid_until/desc'); ?>"><?php echo $this->lang->line ('payment_valid_until'); ?>
									&#9650;</a></th>
						<?php else: ?>
							<th>
								<a href="<?php echo base_url ('dashboard/payment_valid_until'); ?>"><?php echo $this->lang->line ('payment_valid_until'); ?></a>
							</th>
						<?php endif; ?>

						<th>Status</th>
						<th class="action-table-header"><?php echo $this->lang->line ('general_actions'); ?> </th>
					</thead>
					<tbody>
						<?php foreach ($users->result () as $user): ?>
							<?php $valid = (strtotime ($user->payment_valid_until) > now ()) ? TRUE : FALSE; ?>

							<?php if ($valid): ?>
								<tr class="success">
							<?php else: ?>
								<tr class="error">
							<?php endif; ?>


							<td><?php echo $user->id ?></td>
							<td><?php echo $user->first_name . ' ' . $user->last_name ?></td>
							<td><?php echo ($user->payment_date != '') ? date ('m.d.y', strtotime ($user->payment_date)) : $this->lang->line ('general_not_available'); ?></td>
							<td><?php echo ($user->payment_valid_until != '') ? $user->payment_valid_until : $this->lang->line ('general_not_available'); ?></td>
							<td><?php echo ($valid) ? $this->lang->line ('payment_valid') : $this->lang->line ('payment_invalid'); ?></td>
							<?php if ($valid): ?>
								<td>
									<a class="btn btn-mini" href="<?php echo base_url ('users/detail/' . $user->id) ?>">
										<strong>Mais Informacoes</strong>
									</a>
								</td>
							<?php else: ?>
								<td>
									<div class="btn-group visible-desktop">
										<a class="btn btn-mini" href="<?php echo base_url ('payments/add/' . $user->id) ?>">
											<strong><?php echo $this->lang->line ('payment_add'); ?> </strong>
										</a>
										<a class="btn btn-mini" href="<?php echo base_url ('users/deactivate/' . $user->id) ?>">
											<strong><?php echo $this->lang->line ('user_deactivate'); ?> </strong>
										</a>
									</div>
									<div class="btn-group hidden-desktop">
										<a onclick="prepareMenuOptions(<?php echo $user->id ?>)" href="#menuOptions" role="button" class="btn btn-mini" data-toggle="modal">
											<strong><?php echo $this->lang->line ('general_actions'); ?> </strong>
											<span class="caret"></span>
										</a>
									</div>
								</td>
							<?php endif; ?>
							</tr>

						<?php endforeach; ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- /.row -->