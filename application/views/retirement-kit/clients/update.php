<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Edit Client</h3>
					<p class="panel-subtitle">Please enter all the required fields to update a client.</p>
				</div>
				<div class="panel-body">

					<?php
					if( validation_errors() ) {
						?>
						<div class="alert alert-danger">
						  	<?php echo validation_errors(); ?>
						</div>
						<?php
					}

					if( $this->session->flashdata("error") ) {
						?>
						<div class="alert alert-danger">
							<?php echo $this->session->flashdata("error") ?>
						</div>
						<?php
					}

					if( $this->session->flashdata("success") ) {
						?>
						<div class="alert alert-success">
							<?php echo $this->session->flashdata("success") ?>
						</div>
						<?php
					}
					?>

					<form class="form-auth-small" action="" method="post" id="udate-client">
						
						<div class="form-group">
							<label for="username" class="control-label">Username: <span class="required">*</span></label>
							<input type="text" class="form-control" id="username" name="username" value="<?php echo set_value('username', DBout($client['username'])); ?>" placeholder="Username" />
						</div>

						<div class="form-group">
							<label for="first" class="control-label">First Name: <span class="required">*</span></label>
							<input type="text" class="form-control" id="first" name="first" placeholder="First Name" value="<?php echo set_value('first', DBout($client['first'])); ?>" />
						</div>
						
						<div class="form-group">
							<label for="last" class="control-label">Last Name: <span class="required">*</span></label>
							<input type="text" class="form-control" id="last" name="last" value="<?php echo set_value('last', DBout($client['last'])); ?>" placeholder="Last Name" />
						</div>

						<div class="form-group">
							<label for="phone" class="control-label">Phone: <span class="required">*</span></label>
							<input type="text" class="form-control" id="phone" name="phone" value="<?php echo set_value('phone', DBout($client['phone'])); ?>" placeholder="Phone" />
						</div>

						<button type="submit" class="btn btn-primary btn-lg btn-block">UPDATE</button>

					</form>	
				</div>
			</div>
			<!-- END OVERVIEW -->
			
		</div>
	</div>
	<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->