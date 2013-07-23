<div class="container marketing">
	<div class="row">
		<div class="span12">
			<h2><?php echo $this->lang->line('payment_add'); ?></h2>

			<form method="POST" action="<?php echo current_url(); ?>" class="form-horizontal">
				<input type="hidden" name="sending" value="yes">
				<div class="control-group">
					<label class="control-label"><?php echo $this->lang->line('user'); ?></label>
					<div class="controls">
						<h4><?php echo $user->username; ?></h4>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Email</label>
					<div class="controls">
						<input name="email" type="text" placeholder="<?php echo $user->email; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Primeiro Nome</label>
					<div class="controls">
						<input name="first_name" type="text" placeholder="<?php echo $user->first_name; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Ultimo Nome</label>
					<div class="controls">
						<input name="last_name" type="text" placeholder="<?php echo $user->last_name; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Grupo</label>
					<div class="controls">
						<select name="group">
							<option value="-1"></option>
							<?php foreach($groups as $group): ?>
							<option value="<?php echo $group->id ?>"><?php echo $group->description; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-primary">Salvar</button>
					</div>
				</div>
			</form>
		</div>
	</div>