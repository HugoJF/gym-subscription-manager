<div class="container marketing">
	<div class="row">
		<div class="span12">
			<h2><?php echo $this->lang->line('user_info_about'); ?> <?php echo $user->first_name . ' ' . $user->last_name ?></h2>

			<a href="<?php echo base_url('dashboard'); ?>" class="btn btn-inverse"><i class="icon-arrow-left icon-white"></i> Voltar</a>

			<a href="<?php echo base_url('payments/add/' . $user->id); ?>" class="btn"><i class="icon-tags"></i> <?php echo $this->lang->line('payment_add'); ?></a>

			<a href="<?php echo base_url('users/edit/' . $user->id) ?>" class="btn"><i class="icon-pencil"></i> Editar usuario</a>

			<?php if($this->gsm_model->is_user_deactivated($user->id)): ?>
				<a href="<?php echo base_url('users/activate/' . $user->id); ?>" class="btn btn-success"><i class="icon-ok-sign icon-white"></i> <?php echo $this->lang->line('user_activate'); ?></a>
			<?php else: ?>
				<a href="<?php echo base_url('users/deactivate/' . $user->id); ?>" class="btn btn-danger"><i class="icon-remove-sign icon-white"></i> <?php echo $this->lang->line('user_deactivate'); ?></a>
			<?php endif; ?>

			<br>
			<br>

			<div style="overflow-y: auto;width:100%;" id="table-wrapper">
				<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th><?php echo $this->lang->line('user_id'); ?></th>

							<th><?php echo $this->lang->line('user_name'); ?></th>

							<th><?php echo $this->lang->line('payment_date'); ?></th>

							<th><?php echo $this->lang->line('payment_valid_until'); ?></th>

							<th><?php echo $this->lang->line('user_status'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php $valid = ($user->payment_valid_until) > now() ? TRUE : FALSE; ?>
						<tr class="<?php echo ($valid) ? 'info' : 'error'; ?>">
							<td><?php echo $user->id; ?></td>
							<td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
							<td><?php echo ($user->payment_date != '') ? date($this->config->item('gsm_payment_date_format'), $user->payment_date) : $this->lang->line('general_not_available'); ?></td>
							<td><?php echo ($user->payment_valid_until != '') ? date($this->config->item('gsm_payment_valid_until_format'), $user->payment_valid_until) : $this->lang->line('general_not_available'); ?></td>
							<td><?php echo ($valid) ? $this->lang->line('payment_valid') : $this->lang->line('payment_invalid') ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<h2><?php echo $this->lang->line('payment_list'); ?></h2>

			<div style="overflow-y: auto;width:100%;" id="table-wrapper">
				<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th><?php echo $this->lang->line('user_id'); ?></th>
							<th><?php echo $this->lang->line('payment_date'); ?></th>
							<th><?php echo $this->lang->line('payment_valid_until') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($payments->result() as $payment): ?>
							<?php $valid = ($payment->valid_until) > time() ? TRUE : FALSE ?>
							<tr class="<?php echo ($valid) ? 'success' : 'error'; ?>">
								<td><?php echo $payment->id; ?></td>
								<td><?php echo date($this->config->item('gsm_payment_date_detail_format'), $payment->date); ?></td>
								<td><?php echo date($this->config->item('gsm_payment_valid_until_detail_format'), $payment->valid_until); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
