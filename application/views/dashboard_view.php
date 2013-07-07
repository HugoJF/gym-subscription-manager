<div id="menuOptions" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Opcao do usuario</h3>
	</div>
	<div class="modal-footer">
		<p class="text-center">
			<a id="addPayment" href="#" class="btn btn-large btn-inverse">Efetuar pagamento</a>
			<a id="deactivateUser" href="#" class="btn btn-large btn-inverse">Desativar usuario</a>
		</p>
	</div>
</div>


<!-- Marketing messaging and featurettes
================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->
<div class="container marketing">
	<?php echo $this->session->flashdata('error');?>
	<!-- Three columns of text below the carousel -->
	<div class="row">
		<div class="span12">
			<h2>Listagem de todos os usuarios</h2>
			<br>
			<div style="overflow-y: auto;width:100%;padding-bottom: 75px" id="table-wrapper">
				<table class="table table-hover table-bordered">
					<thead>
						<?php if (strtolower (uri_string ()) == 'dashboard/user_id/desc' || uri_string () == 'dashboard/user_id'): ?>
							<th><a href="<?php echo base_url ('dashboard/user_id/asc'); ?>">User ID &#9660;</a></th>
						<?php elseif (uri_string () == 'dashboard/user_id/asc'): ?>
							<th><a href="<?php echo base_url ('dashboard/user_id/desc'); ?>">User ID &#9650;</a></th>
						<?php else: ?>
							<th><a href="<?php echo base_url ('dashboard/user_id'); ?>">User ID</a></th>
						<?php endif; ?>


						<?php if (strtolower (uri_string ()) == 'dashboard/name/desc' || uri_string () == 'dashboard/name'): ?>
							<th><a href="<?php echo base_url ('dashboard/name/asc'); ?>">Name &#9660;</a></th>
						<?php elseif (uri_string () == 'dashboard/name/asc'): ?>
							<th><a href="<?php echo base_url ('dashboard/name/desc'); ?>">Name &#9650;</a></th>
						<?php else: ?>
							<th><a href="<?php echo base_url ('dashboard/name'); ?>">Name</a></th>
						<?php endif; ?>


						<?php if (strtolower (uri_string ()) == 'dashboard/payment_date/desc' || uri_string () == 'dashboard/payment_date'): ?>
							<th><a href="<?php echo base_url ('dashboard/payment_date/asc'); ?>">Payment Date &#9660;</a></th>
						<?php elseif (uri_string () == 'dashboard/payment_date/asc'): ?>
							<th><a href="<?php echo base_url ('dashboard/payment_date/desc'); ?>">Payment Date &#9650;</a></th>
						<?php else: ?>
							<th><a href="<?php echo base_url ('dashboard/payment_date'); ?>">Payment Date</a></th>
						<?php endif; ?>

						<?php if (strtolower (uri_string ()) == 'dashboard/payment_valid_until/desc' || uri_string () == 'dashboard/payment_valid_until'): ?>
							<th><a href="<?php echo base_url ('dashboard/payment_valid_until/asc'); ?>">Payment Validation &#9660;</a></th>
						<?php elseif (uri_string () == 'dashboard/payment_valid_until/asc'): ?>
							<th><a href="<?php echo base_url ('dashboard/payment_valid_until/desc'); ?>">Payment Validation &#9650;</a></th>
						<?php else: ?>
							<th><a href="<?php echo base_url ('dashboard/payment_valid_until'); ?>">Payment Validation</a></th>
						<?php endif; ?>

						<th>Status</th>
						<th class="action-table-header">Acao</th>
					</thead>
					<tbody>
						<?php foreach ($users->result () as $user): ?>
							<?php $valid = (strtotime ($user->payment_valid_until) > now ()) ? TRUE : FALSE; ?>

							<?php if ($valid): ?>
								<tr class="success">
							<?php else: ?>
								<tr class="error">
							<?php endif; ?>


							<td><?php echo $user->id ?></td>
							<td><?php echo $user->first_name . ' ' . $user->last_name ?></td>
							<td><?php echo ($user->payment_date != '') ? date('m.d.y',strtotime($user->payment_date)) : 'N/A'; ?></td>
							<td><?php echo ($user->payment_valid_until != '') ? $user->payment_valid_until : 'N/A'; ?></td>
							<td><?php echo ($valid) ? 'Aprovado' : 'Vencido' ?></td>
							<?php if ($valid): ?>
								<td>
									<a class="btn btn-mini" href="<?php echo base_url ('users/detail/' . $user->id) ?>">
										<strong>Mais Informacoes</strong>
									</a>
								</td>
							<?php else: ?>
								<td>
									<div class="btn-group visible-desktop">
										<a class="btn btn-mini" href="<?php echo base_url ('payments/add/' . $user->id) ?>">
											<strong> Efetuar pagamento </strong>
										</a>
										<a class="btn btn-mini" href="<?php echo base_url ('users/deactivate/' . $user->id) ?>">
											<strong> Desativar usuario </strong>
										</a>
									</div>
									<div class="btn-group hidden-desktop">
										<a onclick="prepareMenuOptions(<?php echo $user->id ?>)" href="#menuOptions" role="button" class="btn btn-mini" data-toggle="modal">
											<strong>Action</strong>
											<span class="caret"></span>
										</a>
									</div>
								</td>
							<?php endif; ?>
							</tr>

						<?php endforeach; ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- /.row -->