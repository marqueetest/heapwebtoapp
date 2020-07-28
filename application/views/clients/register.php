<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Add Client</h3>
					<p class="panel-subtitle">Please enter all the required fields to create a client.</p>
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
					?>

					<div class="bs-callout bs-callout-info hidden">
					  <h4>Yay!</h4>
					  <p>Everything seems to be ok :)</p>
					</div>

					<form class="form-auth-small" action="" method="post" id="register-client">
						
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
							<label for="address1" class="control-label">Address</label>
							<input type="text" class="form-control" id="address1" name="address1" value="<?php echo set_value('address1'); ?>" placeholder="Address" />
						</div>

						<div class="form-group">
							<label for="address2" class="control-label">Address2</label>
							<input type="text" class="form-control" id="address2" name="address2" value="<?php echo set_value('address2'); ?>" placeholder="Address2" />
						</div>

						<div class="form-group">
							<label for="city" class="control-label">City</label>
							<input type="text" class="form-control" id="city" name="city" value="<?php echo set_value('city'); ?>" placeholder="City" />
						</div>

						<div class="form-group">
							<label for="state" class="control-label">State</label>
							<select id="state" name="state"  class="form-control">
                                <option value=""> Select State</option>
                                <option value="AL"> Alabama</option>
                                <option value="AK"> Alaska</option>
                                <option value="AZ"> Arizona</option>
                                <option value="AR"> Arkansas</option>
                                <option value="CA"> California</option>
                                <option value="CO"> Colorado</option>
                                <option value="CT"> Connecticut</option>
                                <option value="DE"> Delaware</option>
                                <option value="DC"> District of Columbia</option>
                                <option value="FL"> Florida</option>
                                <option value="GA"> Georgia</option>
                                <option value="HI"> Hawaii</option>
                                <option value="ID"> Idaho</option>
                                <option value="IL"> Illinois</option>
                                <option value="IN"> Indiana</option>
                                <option value="IA"> Iowa</option>
                                <option value="KS"> Kansas</option>
                                <option value="KY"> Kentucky</option>
                                <option value="LA"> Louisiana</option>
                                <option value="ME"> Maine</option>
                                <option value="MD"> Maryland</option>
                                <option value="MA"> Massachusetts</option>
                                <option value="MI"> Michigan</option>
                                <option value="MN"> Minnesota</option>
                                <option value="MS"> Mississippi</option>
                                <option value="MO"> Missouri</option>
                                <option value="MT"> Montana</option>
                                <option value="NE"> Nebraska</option>
                                <option value="NV"> Nevada</option>
                                <option value="NH"> New Hampshire</option>
                                <option value="NJ"> New Jersey</option>
                                <option value="NM"> New Mexico</option>
                                <option value="NY"> New York</option>
                                <option value="NC"> North Carolina</option>
                                <option value="ND"> North Dakota</option>
                                <option value="OH"> Ohio</option>
                                <option value="OK"> Oklahoma</option>
                                <option value="OR"> Oregon</option>
                                <option value="PA"> Pennsylvania</option>
                                <option value="PR"> Puerto Rico</option>
                                <option value="RI"> Rhode Island</option>
                                <option value="SC"> South Carolina</option>
                                <option value="SD"> South Dakota</option>
                                <option value="TN"> Tennessee</option>
                                <option value="TX"> Texas</option>
                                <option value="UT"> Utah</option>
                                <option value="VT"> Vermont</option>
                                <option value="VI"> Virgin Islands</option>
                                <option value="VA"> Virginia</option>
                                <option value="WA"> Washington</option>
                                <option value="WV"> West Virginia</option>
                                <option value="WI"> Wisconsin</option>
                                <option value="WY"> Wyoming</option>
                        	</select>
						</div>

						<div class="form-group">
							<label for="zipcode" class="control-label">Zipcode</label>
							<input type="text" class="form-control" id="zipcode" name="zipcode" value="<?php echo set_value('zipcode'); ?>" placeholder="Zipcode" />
						</div>

						<div class="form-group">
							<label for="phone" class="control-label">Phone</label>
							<input type="text" class="form-control" id="phone" name="phone" value="<?php echo set_value('phone'); ?>" placeholder="Phone" />
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