<div class="container marketing">
	<div class="row">
		<div class="span12">
			<h2><?php echo $this->lang->line('payment_confirm'); ?></h2>

			<form method="POST" action="<?php echo current_url(); ?>" class="form-horizontal">
				<input type="hidden" name="confirmed" value="yes">
				<input type="hidden" name="payment_time" value="<?php echo $_POST['payment_time']; ?>">
				<input type="hidden" name="payment_method" value="<?php echo $_POST['payment_method']; ?>">

				<div class="control-group">
					<label class="control-label"><?php echo $this->lang->line('user'); ?></label>

					<div class="controls">
						<h4><?php echo $user->first_name . ' ' . $user->last_name; ?></h4>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo $this->lang->line('login_email'); ?></label>

					<div class="controls">
						<h4><?php echo $user->email; ?></h4>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo $this->lang->line('payment_last'); ?></label>

					<div class="controls">
						<h4><?php

								if(isset($user->payment_date) && $user->payment_date != ''):
									echo date($this->config->item('gsm_payments_add_conf_remaining_format'), $user->payment_date) . ' (' . round((time() - $user->payment_date) / (60 * 60 * 24)) . ' ' . strtolower($this->lang->line('payment_days_ago')) . ')';
								else:
									echo $this->lang->line('general_not_available');
								endif;

							?></h4>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Metodo</label>

					<div class="controls">
						<?php if($_POST['payment_method'] == 'renew'): ?>
							<h4>Renovacao</h4>
						<?php elseif($_POST['payment_method'] == 'extend'): ?>
							<h4>Estender</h4>
						<?php endif; ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo $this->lang->line('payment_valid_time'); ?></label>

					<div class="controls">
						<?php $payment_type = explode('|', $_POST['payment_time']); ?>
						<?php if($payment_type[1] == 'maintain_day'): ?>

							<h4><?php echo intval($_POST['payment_time']) . ' ' . ((intval($_POST['payment_time']) == 1) ? ' mes' : ' meses'); ?></h4>

						<?php elseif($payment_type[1] == 'period_sum'): ?>

							<h4><?php echo intval($_POST['payment_time']) / 24 / 60 / 60 . ' ' . strtolower($this->lang->line('general_days')) ?></h4>

						<?php endif; ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('payment_confirm'); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>