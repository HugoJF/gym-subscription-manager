<div class="container marketing">
	<div class="row">
		<div class="span12">
			<h2><?php echo $this->lang->line('payment_add'); ?></h2>

			<form method="POST" action="<?php echo current_url(); ?>"class="form-horizontal">
				<label class="control-label"><?php echo $this->lang->line('user'); ?></label>
				<div class="control-group">
					<div class="controls">
						<h4><?php echo $user->first_name . ' ' . $user->last_name; ?></h4>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo $this->lang->line('payment_valid_time'); ?></label>
					<div class="controls">
						<label class="radio"><input type="radio" name="payment_time" value="604800">7 dias</label>
						<label class="radio"><input type="radio" name="payment_time" value="1209600">14 dias</label>
						<label class="radio"><input type="radio" name="payment_time" value="2592000">30 dias</label>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('payment_add'); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>