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
							<label for="password" class="control-label">Password:</label>
							<input type="password" class="form-control" id="password" name="password" value="" placeholder="Password" />
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label for="first" class="control-label">First Name: <span class="required">*</span></label>
									<input type="text" class="form-control" id="first" name="first" placeholder="First Name" value="<?php echo set_value('first', DBout($client['first'])); ?>" />
								</div>
								<div class="col-md-6">
									<label for="last" class="control-label">Last Name: <span class="required">*</span></label>
									<input type="text" class="form-control" id="last" name="last" value="<?php echo set_value('last', DBout($client['last'])); ?>" placeholder="Last Name" />
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="street" class="control-label">Street Address: <span class="required">*</span></label>
							<input type="text" class="form-control" id="street" name="street" value="<?php echo set_value('street', DBout($client['street'])); ?>" placeholder="Street Address" />
						</div>

						<div class="form-group">
							<label for="city" class="control-label">City: <span class="required">*</span></label>
							<input type="text" class="form-control" id="city" name="city" value="<?php echo set_value('city', DBout($client['city'])); ?>" placeholder="City" />
						</div>

						<div class="form-group">
							<label for="state" class="control-label">State: <span class="required">*</span></label>
							<input type="text" class="form-control" id="state" name="state" value="<?php echo set_value('state', DBout($client['state'])); ?>" placeholder="State" />
						</div>

						<div class="form-group">
							<label for="zip" class="control-label">Zipcode: <span class="required">*</span></label>
							<input type="text" class="form-control" id="zip" name="zip" value="<?php echo set_value('zip', DBout($client['zip'])); ?>" placeholder="Zipcode" />
						</div>

						<div class="form-group">
							<label for="phone" class="control-label">Phone: <span class="required">*</span></label>
							<input type="text" class="form-control" id="phone" name="phone" value="<?php echo set_value('phone', DBout($client['phone'])); ?>" placeholder="Phone" />
						</div>

						<h3>Quick Survey</h3>

		               	<div class="form-group">
		                  	<label class="control-label" for="protect_asset">1) I am interested in protecting my assets from creditors.</label>
		                  	<select name="protect_asset" class="form-control custom_control" id="protect_asset">
		                        <option selected="selected" value="">Choose...</option>
		                        <option value="Yes" <?php echo $client["protect_asset"] == "Yes" ? "selected" : "" ?>>Yes</option>
		                        <option value="No" <?php echo $client["protect_asset"] == "No" ? "selected" : "" ?>>No</option>
		                    </select>
		               	</div>

		               	<div class="form-group">
		                  	<label class="control-label" for="reduce_inctax"> 2) I am interested in reducing my income taxes.</label>
		                    <select name="reduce_inctax" class="form-control custom_control" id="reduce_inctax">
		                        <option selected="selected" value="">Choose...</option>
		                        <option value="Yes" <?php echo $client["reduce_inctax"] == "Yes" ? "selected" : "" ?>>Yes</option>
		                        <option value="No" <?php echo $client["reduce_inctax"] == "No" ? "selected" : "" ?>>No</option>
		                    </select>
		               	</div>

			           	<div class="form-group">
			              	<label class="control-label" for="guarantee_income"> 3) I am interested in a guaranteed income for life that can’t be outlived.</label>  
			                <select name="guarantee_income" class="form-control custom_control" id="guarantee_income">
			                    <option selected="selected" value="">Choose...</option>
			                    <option value="Yes" <?php echo $client["guarantee_income"] == "Yes" ? "selected" : "" ?>>Yes</option>
			                    <option value="No" <?php echo $client["guarantee_income"] == "No" ? "selected" : "" ?>>No</option>
			                </select>
			           	</div>

		               	<div class="form-group">
		                  	<label class="control-label" for="financial_help">4) I would like help with my financial/retirement plan or estate plan.</label>  
		                    <select name="financial_help" class="form-control custom_control" id="financial_help">
		                        <option selected="selected" value="">Choose...</option>
		                        <option value="Yes" <?php echo $client["financial_help"] == "Yes" ? "selected" : "" ?>>Yes</option>
		                        <option value="No" <?php echo $client["financial_help"] == "No" ? "selected" : "" ?>>No</option>
		                    </select>
		               	</div>

		               	<!--here is the complete hanfdling for the labels for books-->
		               	<h3>Available Books</h3>

						<?php
						if( !empty( $efpBooks ) ) {
							foreach( $efpBooks as $efpBook ) {
			                	?>

			                	<div class="form-group">
		                  			<label class="control-label" for=""></label>
		                   			<input type="checkbox" name="ebook[]" value="<?php echo $efpBook["pdfid"];?>" <?php echo in_array($efpBook["pdfid"], $ebook) ? "checked" : "" ?> />
		                   			<?php echo $efpBook["title"]; ?>
		               			</div>

			                	<?php
			                }
						}
						?>
                

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