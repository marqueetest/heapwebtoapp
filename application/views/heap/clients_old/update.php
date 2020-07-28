<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Edit Client</h3>
					<p class="panel-subtitle">Please enter all the required fields to update a client</p>
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

					<form class="form-auth-small" action="" method="post" id="register-client">
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label for="first_name" class="control-label">First Name: <span class="required">*</span></label>
									<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="<?php echo set_value('first_name', $client['first_name']); ?>" />
								</div>

								<div class="col-md-6">

									<label for="last_name" class="control-label">Last Name: <span class="required">*</span></label>

									<input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo set_value('last_name', $client['last_name']); ?>" placeholder="Last Name" />

								</div>

							</div>

						</div>



						<div class="form-group">

							<label for="address1" class="control-label">Address: <span class="required">*</span></label>

							<input type="text" class="form-control" id="address1" name="address1" value="<?php echo set_value('address1', $client['address1']); ?>" placeholder="Address" />

						</div>



						<div class="form-group">

							<label for="address2" class="control-label">Address2:</label>

							<input type="text" class="form-control" id="address2" name="address2" value="<?php echo set_value('address2', $client['address2']); ?>" placeholder="Address2" />

						</div>



						<div class="form-group">

							<label for="city" class="control-label">City:</label>

							<input type="text" class="form-control" id="city" name="city" value="<?php echo set_value('city', $client['city']); ?>" placeholder="City" />

						</div>



						<div class="form-group">

							<label for="state" class="control-label">State:</label>

							<select id="state" name="state"  class="form-control">

                                <option value=""> Select State</option>

                                <?php

                                foreach( $states as $key => $value ) {

                                	?>

                                	<option value="<?php echo $key ?>" <?php echo set_select('state', $key) == "" ? $client['state'] == $key ? "selected='selected'":"" : set_select('state', $key) ; ?>> <?php echo $value ?></option>

                                	<?php

                                }

                                ?>

                        	</select>

						</div>



						<div class="form-group">

							<label for="zipcode" class="control-label">Zipcode:</label>

							<input type="text" class="form-control" id="zipcode" name="zipcode" value="<?php echo set_value('zipcode', $client['zipcode']); ?>" placeholder="Zipcode" />

						</div>



						<div class="form-group">

							<label for="phone" class="control-label">Phone: <span class="required">*</span></label>

							<input type="text" class="form-control" id="phone" name="phone" value="<?php echo set_value('phone', $client['phone']); ?>" placeholder="Phone" />

						</div>



						<div class="form-group">

							<label for="email_address" class="control-label">Email: <span class="required">*</span></label>

							<input type="email" class="form-control" id="email_address" name="email_address" value="<?php echo set_value('email_address', $client['email_address']); ?>" placeholder="xyz@gmail.com" />

						</div>



						<div class="form-group">

							<label for="username" class="control-label">Username: </label>

							<input type="text" class="form-control" id="username" name="username" value="<?php echo set_value('username', $client['username']); ?>" placeholder="Username" />

						</div>



						<div class="form-group">

							<label for="password" class="control-label">Password:</label>

							<input type="text" class="form-control" id="password" name="password" value="<?php echo $client['password'] ?>" placeholder="Password" />

						</div>

						<div class="form-group">
							<label for="rpassword" class="control-label">Confirm Password:</label>
							<input type="text" class="form-control" id="confirm_password" name="confirm_password" value="<?php echo $client['password'] ?>" placeholder="Repeat Password" />
						</div>

						<div class="form-group">

                  			<label class="control-label" for="api_access_admin_controll">Approve for Mobile App Use:</label>

                   			<input type="checkbox" name="api_access_admin_controll" id="api_access_admin_controll" value="1" <?php echo set_checkbox('api_access_admin_controll', "1") == "" ? $client['api_access_admin_controll'] == 1 ? "checked='checked'":"" : set_checkbox('api_access_admin_controll', "1") ; ?> />

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