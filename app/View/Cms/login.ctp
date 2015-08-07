<div class="col-md-4 col-md-offset-4">
	<div class="login-panel panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo __d('cms', 'Please enter your username and password to login'); ?></h3>
		</div>
		<div class="panel-body">
			<form role="form" id="frmLogin" method="post" action="<?php echo $this->Html->url('/bakery/login'); ?>">
				<fieldset>
					<div class="form-group">
						<input class="form-control" placeholder="<?php echo __d('cms', 'Username'); ?>" name="user" type="text" autofocus>
					</div>
					<div class="form-group">
						<input class="form-control" placeholder="<?php echo __d('cms', 'Password'); ?>" name="pass" type="password" value="">
					</div>
					
					<!-- Change this to a button or input when using this as a form -->
					<button type="submit" class="btn btn-lg btn-success btn-block"><?php echo __d('cms', 'Login'); ?></button>
				</fieldset>
			</form>
		</div>
	</div>
</div>
