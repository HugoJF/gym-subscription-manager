<div class="container marketing">
	<div class="row">
		<div class="span12">
			<h2>Efetuar pagamento</h2>

			<form method="POST" action="<?php echo current_url (); ?>" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="inputEmail">Email</label>

					<div class="controls">
						<input name="email" type="text" id="inputEmail" placeholder="Email (optional)">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputFirstName">First Name</label>

					<div class="controls">
						<input name="first_name" type="text" id="inputFirstName" placeholder="First Name">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputLastName">Last Name</label>

					<div class="controls">
						<input name="last_name" type="text" id="inputLastName" placeholder="Last Name">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label class="checkbox">
						</label>
						<button type="submit" class="btn btn-primary">Register</button>
					</div>
				</div>
			</form>
		</div>
	</div>