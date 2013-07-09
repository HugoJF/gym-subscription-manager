<div class="container marketing">
	<div class="row">
		<div class="span12">
			<h2><?php echo $this->lang->line('payment_add'); ?></h2>

			<form method="POST" action="<?php echo current_url (); ?>" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="inputEmail"><?php echo $this->lang->line('login_email'); ?></label>

					<div class="controls">
						<input name="email" type="text" id="inputEmail" placeholder="<?php echo $this->lang->line('login_email_opt'); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputFirstName"><?php echo $this->lang->line('login_first_name'); ?></label>

					<div class="controls">
						<input name="first_name" type="text" id="inputFirstName" placeholder="<?php echo $this->lang->line('login_first_name'); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputLastName"><?php echo $this->lang->line('login_last_name'); ?></label>

					<div class="controls">
						<input name="last_name" type="text" id="inputLastName" placeholder="<?php echo $this->lang->line('login_last_name'); ?>">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label class="checkbox">
						</label>
						<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('login_register'); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>