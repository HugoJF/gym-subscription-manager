<div class="container marketing">
	<div class="row">
		<div class="span12">
			<h2>Informacoes sobre  <?php echo $user->first_name . ' ' . $user->last_name ?></h2>
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>User ID</th>

						<th>Name</th>

						<th>Payment Date</th>

						<th>Payment Validation</th>

						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<tr class="info">
						<?php $valid = (strtotime ($user->payment_valid_until) > now ()) ? TRUE : FALSE; ?>
						<td><?php echo $user->id; ?></td>
						<td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
						<td><?php echo $user->payment_date; ?></td>
						<td><?php echo $user->payment_valid_until; ?></td>
						<td><?php echo ($valid) ? 'Aprovado' : 'Vencido' ?></td>
					</tr>
				</tbody>
			</table>
			<h2>Lista de pagamentos</h2>
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>ID</th>
						<th>Date</th>
						<th>Valid Until</th>
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
