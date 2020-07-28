<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Register a Class</h3>
					<p class="panel-subtitle">Please enter all the required fields to register a class</p>
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

					<form class="form-auth-small" action="" method="post" id="register-class">

						<div class="form-group">
							<label for="title" class="control-label">Title</label>
							<input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title'); ?>" placeholder="Enter Course Title" />
						</div>

						<div class="form-group">
							<label for="intro" class="control-label">Description</label>
							<input type="text" class="form-control" id="description" name="description" value="<?php echo set_value('description'); ?>" placeholder="Enter Class Description" />
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