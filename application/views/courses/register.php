<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Register a Course</h3>
					<p class="panel-subtitle">Please enter all the required fields to register a course</p>
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

					<form class="form-auth-small" action="" method="post" id="register-acourse">

						<div class="form-group">
							<label for="title" class="control-label">Title</label>
							<input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title'); ?>" placeholder="Enter Course Title" />
						</div>

						<div class="form-group">
							<label for="description" class="control-label">Description</label>
							<input type="text" class="form-control" id="description" name="description" value="<?php echo set_value('description'); ?>" placeholder="Enter Course Description" />
						</div>

						<div class="form-group">
							<label for="class" class="control-label">Class</label>
							<select name="class" id="class" class="form-control">
								<option value="">-SELECT CLASS-</option>
								<?php
								if( !empty( $classes ) ) {
									foreach( $classes as $class ) {
										?>
										<option value="<?php echo $class['id'] ?>" <?php echo set_value('class') == $class['id']?"selected='selected'":''; ?>><?php echo $class["title"] ?></option>
										<?php
									}
								}
								?>
							</select>
						</div>

						<div class="form-group">
							<label for="duration" class="control-label">Duration</label>
							<select name="duration" id="duration" class="form-control">
								<option value="">-SELECT COURSE DURATION-</option>
								<option value="1" <?php echo set_value('title') == 1?"selected='selected'":''; ?>>1 Month</option>
								<option value="3" <?php echo set_value('title') == 3?"selected='selected'":''; ?>>3 Months</option>
								<option value="6" <?php echo set_value('title') == 6?"selected='selected'":''; ?>>6 Months</option>
								<option value="12" <?php echo set_value('title') == 12?"selected='selected'":''; ?>>12 Months</option>
							</select>
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