<div class="container marketing">
	<div class="row">
		<div class="span12">
			<h2>Confirmar pagamento</h2>

			<form method="POST" action="<?php echo current_url(); ?>"class="form-horizontal">
				<input type="hidden" name="confirmed" value="yes">
				<input type="hidden" name="payment_time" value="<?php echo $_POST['payment_time']; ?>">
				<div class="control-group">
					<label class="control-label">Usuario</label>
					<div class="controls">
						<h4><?php echo $user->first_name . ' ' . $user->last_name; ?></h4>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Email</label>
					<div class="controls">
						<h4><?php echo $user->email; ?></h4>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Ultimo pagamento</label>
					<div class="controls">
						<h4><?php echo (isset($user->payment_date) ? $user->payment_date : 'N/A'); ?> (x dias atras)</h4>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Periodo</label>
					<div class="controls">
						<h4><?php echo $_POST['payment_time'] ?> dias</h4>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-primary">Confirmar pagamento</button>
					</div>
				</div>
			</form>
		</div>
	</div>