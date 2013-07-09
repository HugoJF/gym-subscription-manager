<div class="container marketing">
	<div class="row">
		<div class="span12">
			<h2><?php echo $this->lang->line ('user_info_about'); ?> <?php echo $user->first_name . ' ' . $user->last_name ?></h2>
			<a href="<?php echo base_url ('payments/add/' . $user->id) ?>" class="btn btn-primary"><?php echo $this->lang->line ('payment_add'); ?></a>
			<a class="btn btn-primary"><?php echo $this->lang->line ('user_deactivate'); ?></a>
			<br>
			<br>

			<div style="overflow-y: auto;width:100%;" id="table-wrapper">
				<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th><?php echo $this->lang->line ('user_id'); ?></th>

							<th><?php echo $this->lang->line ('user_name'); ?></th>

							<th><?php echo $this->lang->line ('payment_date'); ?></th>

							<th><?php echo $this->lang->line ('payment_valid_until'); ?></th>

							<th><?php echo $this->lang->line ('user_status'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php $valid = (strtotime ($user->payment_valid_until) > now ()) ? TRUE : FALSE; ?>
						<tr class="<?php echo ($valid) ? 'info' : 'error'; ?>">
							<td><?php echo $user->id; ?></td>
							<td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
							<td><?php echo ($user->payment_date != '') ? date ('m.d.y', strtotime ($user->payment_date)) : $this->lang->line ('general_not_available'); ?></td>
							<td><?php echo ($user->payment_valid_until != '') ? $user->payment_valid_until : $this->lang->line ('general_not_available'); ?></td>
							<td><?php echo ($valid) ? $this->lang->line ('payment_valid') : $this->lang->line ('payment_invalid') ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<h2><?php echo $this->lang->line ('payment_list'); ?></h2>

			<div style="overflow-y: auto;width:100%;" id="table-wrapper">
				<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th><?php echo $this->lang->line ('user_id'); ?></th>
							<th><?php echo $this->lang->line ('payment_date'); ?></th>
							<th><?php echo $this->lang->line ('payment_valid_until') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($payments->result () as $payment): ?>
							<?php $valid = (strtotime ($payment->valid_until) > time ()) ? TRUE : FALSE ?>
							<tr class="<?php echo ($valid) ? 'success' : 'error'; ?>">
								<td><?php echo $payment->id; ?></td>
								<td><?php echo $payment->date; ?></td>
								<td><?php echo $payment->valid_until; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
