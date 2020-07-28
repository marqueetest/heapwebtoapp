<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Add Coupon Code</h3>
					<p class="panel-subtitle">Please enter all the required fields to create a coupon code.</p>
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
							<strong>You have <?php echo $this->data["coupon_remaining"] ?> coupon(s) remaining</strong>
						</div>
						
						<div class="form-group">
							<label for="coupon_code" class="control-label">Coupon Code: <span class="required">*</span></label>
							<input type="text" class="form-control" id="coupon_code" name="coupon_code" value="<?php echo set_value('coupon_code'); ?>" placeholder="Enter Coupon Code" />
						</div>

						<div class="form-group">
							<label for="is_active" class="control-label">Status</label>
							<select id="is_active" name="is_active"  class="form-control">
                                <option value="No" <?php echo set_select("is_active", "No") ?>>No</option>
                                <option value="Yes" <?php echo set_select("is_active", "Yes") ?>>Yes</option>
                        	</select>
						</div>
						
						<button type="submit" class="btn btn-primary btn-lg btn-block">SAVE</button>

					</form>	
				</div>
			</div>
			<!-- END OVERVIEW -->
			
		</div>
	</div>
	<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->