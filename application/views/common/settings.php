<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Settings</h3>
					<p class="panel-subtitle">Please enter old and new password to update your password.</p>
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

					<form class="form-auth-small" action="" method="post" id="add-coupon">
						
						<div class="form-group">
							<label for="username" class="control-label">Username:</label>
							<input type="text" class="form-control" id="username" name="username" value="<?php echo $adviser['username'] ?>" readonly />
						</div>

						<div class="form-group">
							<label for="password" class="control-label">Current Password: <span class="required">*</span></label>
							<input type="password" class="form-control" id="password" name="password" value="" placeholder="Enter Current Password" />
						</div>

						<div class="form-group">
							<label for="new_password" class="control-label">New Password: <span class="required">*</span></label>
							<input type="password" class="form-control" id="new_password" name="new_password" value="" placeholder="Enter New Password" />
						</div>

						<div class="form-group">
							<label for="confirm_password" class="control-label">Confirm Password: <span class="required">*</span></label>
							<input type="password" class="form-control" id="confirm_password" name="confirm_password" value="" placeholder="Confirm Password" />
						</div>
						
						<button type="submit" class="btn btn-primary btn-lg btn-block">Update</button>

					</form>	
				</div>
			</div>
			<!-- END OVERVIEW -->
			
		</div>
	</div>
	<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->