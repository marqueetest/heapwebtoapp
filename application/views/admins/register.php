<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Register an Admin</h3>
					<p class="panel-subtitle">Please enter all the required fields to register an admin</p>
				</div>
				<div class="panel-body">

					<div class="bs-callout bs-callout-warning hidden">
					  <h4>Oh snap!</h4>
					  <p>This form seems to be invalid :(</p>
					</div>

					<div class="bs-callout bs-callout-info hidden">
					  <h4>Yay!</h4>
					  <p>Everything seems to be ok :)</p>
					</div>

					<?php echo validation_errors(); ?>

					<form class="form-auth-small" action="" method="post" id="register-user">
						
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label for="first_name" class="control-label">First Name:</label>
									<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="<?php echo set_value('first_name'); ?>" />
								</div>
								<div class="col-md-6">
									<label for="last_name" class="control-label">Last Name:</label>
									<input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo set_value('last_name'); ?>" placeholder="Last Name" />
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="cnic" class="control-label">CNIC#</label>
							<input type="text" class="form-control" id="cnic" name="cnic" value="<?php echo set_value('cnic'); ?>" placeholder="xxxxx-xxxxxxx-x" />
						</div>

						<div class="form-group">
							<label class="fancy-radio">
								<input name="gender" value="M" type="radio">
								<span><i></i>Male</span>
							</label>
							<label class="fancy-radio">
								<input name="gender" value="F" type="radio">
								<span><i></i>Female</span>
							</label>
						</div>

						<div class="form-group">
							<label for="dob" class="control-label">DOB</label>
							<input type="text" class="form-control" id="dob" name="dob" value="<?php echo set_value('dob'); ?>" placeholder="yyyy-mm-dd" />
						</div>

						<div class="form-group">
							<label for="address" class="control-label">Address</label>
							<input type="address" class="form-control" id="address" name="address" value="<?php echo set_value('address'); ?>" placeholder="Address" />
						</div>

						<div class="form-group">
							<label for="contact" class="control-label">Contact#</label>
							<input type="contact" class="form-control" id="contact" name="contact" value="<?php echo set_value('contact'); ?>" placeholder="Contact" />
						</div>

						<div class="form-group">
							<label for="email" class="control-label">Email</label>
							<input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email'); ?>" placeholder="xyz@gmail.com" />
						</div>

						<div class="form-group">
							<label for="username" class="control-label">Username</label>
							<input type="text" class="form-control" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="Username" />
						</div>

						<div class="form-group">
							<label for="password" class="control-label">Password</label>
							<input type="password" class="form-control" id="password" name="password" value="" placeholder="Password" />
						</div>

						<div class="form-group">
							<label for="rpassword" class="control-label">Confirm Password</label>
							<input type="password" class="form-control" id="confirm_password" name="confirm_password" value="" placeholder="Repeat Password" />
						</div>
						
						<button type="submit" class="btn btn-primary btn-lg btn-block">REGISTER</button>

					</form>	
				</div>
			</div>
			<!-- END OVERVIEW -->
			
		</div>
	</div>
	<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->