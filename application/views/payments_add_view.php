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
					<label class="control-label">Metodo</label>
					<div class="controls">
						<label class="radio"><input type="radio" name="payment_method" value="renew">Renovar(data do pagamento = hoje)</label>
						<label class="radio"><input type="radio" name="payment_method" value="extend">Extender(data do pagamento = data de vencimento do ultimo pagamento)</label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo $this->lang->line('payment_valid_time'); ?></label>
					<div class="controls">
						<?php foreach($this->config->item('gsm_payment_options') as $option): ?>
						<label class="radio"><input type="radio" name="payment_time" value="<?php echo $option['value'] . '|' . $option['type']; ?>"><?php echo $option['name']; ?></label>
						<?php endforeach; ?>
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