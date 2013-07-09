<div class="container marketing">
	<div class="row">
		<div class="span12">
			<h2><?php echo $this->lang->line ('payment_confirm'); ?></h2>

			<form method="POST" action="<?php echo current_url (); ?>" class="form-horizontal">
				<input type="hidden" name="confirmed" value="yes">
				<input type="hidden" name="payment_time" value="<?php echo $_POST['payment_time']; ?>">

				<div class="control-group">
					<label class="control-label"><?php echo $this->lang->line ('user'); ?></label>

					<div class="controls">
						<h4><?php echo $user->first_name . ' ' . $user->last_name; ?></h4>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo $this->lang->line ('login_email'); ?></label>

					<div class="controls">
						<h4><?php echo $user->email; ?></h4>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo $this->lang->line ('payment_last'); ?></label>

					<div class="controls">
						<h4><?php echo (isset($user->payment_date) ? $user->payment_date : $this->lang->line ('general_not_available')); ?>
							(x dias atras)</h4>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo $this->lang->line ('payment_valid_time'); ?></label>

					<div class="controls">
						<h4><?php echo intval ($_POST['payment_time']) / 24 / 60 / 60;
								echo ' ';
								echo strtolower ($this->lang->line ('general_days')) ?></h4>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-primary"><?php echo $this->lang->line ('payment_confirm'); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>