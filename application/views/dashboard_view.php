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
						<?php if(strtolower(uri_string()) == 'dashboard/user_id/desc' || uri_string() == 'dashboard/user_id'): ?>
							<th>
								<a href="<?php echo base_url('dashboard/user_id/asc'); ?>"><?php echo $this->lang->line('user_id'); ?>
									&#9660;</a></th>
						<?php elseif(uri_string() == 'dashboard/user_id/asc'): ?>
							<th>
								<a href="<?php echo base_url('dashboard/user_id/desc'); ?>"><?php echo $this->lang->line('user_id'); ?>
									&#9650;</a></th>
						<?php else: ?>
							<th>
								<a href="<?php echo base_url('dashboard/user_id'); ?>"><?php echo $this->lang->line('user_id'); ?></a>
							</th>
						<?php endif; ?>


						<?php if(strtolower(uri_string()) == 'dashboard/name/desc' || uri_string() == 'dashboard/name'): ?>
							<th>
								<a href="<?php echo base_url('dashboard/name/asc'); ?>"><?php echo $this->lang->line('user_name'); ?>
									&#9660;</a></th>
						<?php elseif(uri_string() == 'dashboard/name/asc'): ?>
							<th>
								<a href="<?php echo base_url('dashboard/name/desc'); ?>"><?php echo $this->lang->line('user_name'); ?>
									&#9650;</a></th>
						<?php else: ?>
							<th>
								<a href="<?php echo base_url('dashboard/name'); ?>"><?php echo $this->lang->line('user_name'); ?></a>
							</th>
						<?php endif; ?>


						<?php if(strtolower(uri_string()) == 'dashboard/payment_date/desc' || uri_string() == 'dashboard/payment_date'): ?>
							<th>
								<a href="<?php echo base_url('dashboard/payment_date/asc'); ?>"><?php echo $this->lang->line('payment_date_last'); ?>
									&#9660;</a></th>
						<?php elseif(uri_string() == 'dashboard/payment_date/asc'): ?>
							<th>
								<a href="<?php echo base_url('dashboard/payment_date/desc'); ?>"><?php echo $this->lang->line('payment_date_last'); ?>
									&#9650;</a></th>
						<?php else: ?>
							<th>
								<a href="<?php echo base_url('dashboard/payment_date'); ?>"><?php echo $this->lang->line('payment_date_last'); ?></a>
							</th>
						<?php endif; ?>

						<?php if(strtolower(uri_string()) == 'dashboard/payment_valid_until/desc' || uri_string() == 'dashboard/payment_valid_until'): ?>
							<th>
								<a href="<?php echo base_url('dashboard/payment_valid_until/asc'); ?>"><?php echo $this->lang->line('payment_valid_until'); ?>
									&#9660;</a></th>
						<?php elseif(uri_string() == 'dashboard/payment_valid_until/asc'): ?>
							<th>
								<a href="<?php echo base_url('dashboard/payment_valid_until/desc'); ?>"><?php echo $this->lang->line('payment_valid_until'); ?>
									&#9650;</a></th>
						<?php else: ?>
							<th>
								<a href="<?php echo base_url('dashboard/payment_valid_until'); ?>"><?php echo $this->lang->line('payment_valid_until'); ?></a>
							</th>
						<?php endif; ?>

						<th>Status</th>
						<th class="action-table-header"><?php echo $this->lang->line('general_actions'); ?> </th>
					</thead>
					<tbody>
						<?php foreach($users->result() as $user): ?>
							<?php $valid = ($user->payment_valid_until > now()) ? TRUE : FALSE; ?>
							<?php $remaining = ceil(($user->payment_valid_until - time()) / 60 / 60 / 24); ?>

							<?php if($valid):
								if($this->config->item('gsm_payment_warning_time') > $user->payment_valid_until - time()): ?>
									<tr class="warning">
								<?php else: ?>
									<tr class="success">
								<?php endif; ?>
							<?php else: ?>
								<tr class="error">
							<?php endif; ?>


							<td><?php echo $user->id ?></td>
							<td><?php echo $user->first_name . ' ' . $user->last_name ?></td>
							<?php if($user->payment_date != ''): ?>
								<td><?php echo date($this->config->item('gsm_payment_date_format'), $user->payment_date); ?>
									(
									<?php echo abs($remaining);
										echo ' ';
										if($remaining == 1) {
											echo strtolower($this->lang->line('general_day'));
										} else {
											echo strtolower($this->lang->line('general_days'));
										}?>
									<?php if($remaining > 0) {
										echo 'restantes)';
									} else {
										echo 'vencidos)';
									}?>
								</td>
							<?php else: ?>
								<td><?php echo $this->lang->line('general_not_available'); ?></td>
							<?php endif; ?>
							<td><?php echo ($user->payment_valid_until != '') ? date($this->config->item('gsm_payment_valid_until_format'), $user->payment_valid_until) : $this->lang->line('general_not_available'); ?></td>
							<td><?php echo ($valid) ? $this->lang->line('payment_valid') : $this->lang->line('payment_invalid'); ?></td>
							<td>
								<a class="btn btn-mini" href="<?php echo base_url('users/detail/' . $user->id) ?>">
									<strong>Mais Informacoes</strong>
								</a>
							</td>
							</tr>

						<?php endforeach; ?>

					</tbody>
				</table>
				<?php
					$cur_page = 0;

					$uri = uri_string();
					$uri_sep = explode('/', $uri);
					if(sizeof($uri_sep) != 5) {
						$type     = (isset($uri_sep[1])) ? $uri_sep[1] : 'user_id';
						$cur_page = 0;
						$uri      = 'dashboard/' . $type . '/asc/0/' . $this->config->item('gsm_users_per_page');
						$uri_sep  = explode('/', $uri);
					} else {
						$cur_page = floor(($uri_sep[3] / $this->config->item('gsm_users_per_page')));
					}
					$cur_page ++;
				?>
				<div class="pagination pagination-centered pagination-large">
					<ul>
						<?php if($cur_page == 1): ?>
							<li class="disabled"><a>Prev</a></li>
						<?php else: ?>
							<li>
								<a href="<?php echo base_url($uri_sep[0] . '/' . $uri_sep[1] . '/' . $uri_sep[2] . '/' . ($cur_page - 2) * $this->config->item('gsm_users_per_page') . '/' . $uri_sep[4]); ?>">Prev</a>
							</li>
						<?php endif; ?>
						<li class="active"><a><?php echo $cur_page; ?></a></li>
						<?php for($i = 0; $i < $this->config->item('gsm_pagination_links') - 1; $i ++):
							$offset = ($cur_page + $i) * $this->config->item('gsm_users_per_page');
							$link   = $uri_sep[0] . '/' . $uri_sep[1] . '/' . $uri_sep[2] . '/' . $offset . '/' . $uri_sep[4];
							?>
							<li><a href="<?php echo base_url($link) ?>"><?php echo $cur_page + 1 + $i ?></a></li>
						<?php endfor; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- /.row -->