<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Default Foreword</h3>
					<p class="panel-subtitle">Copy this foreword, edit as per your needs and use for your custom foreword.</p>
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

					<form class="form-auth-small" action="" method="post" id="heap-landing-page">

						<div class="form-group">
	                      	<label class="control-label" for="foreword">Foreword:</label>
	                      	<div class="form-group">
                           		<textarea name="foreword" id="foreword" class="form-control editor" onclick="this.select()"><?php echo $foreword;?></textarea>
	                      	</div>
	                 	</div>

						<input name="update_foreword" type="submit" class="btn btn-primary btn-lg btn-block" value="Save" />

					</form>

				</div>
			</div>
			<!-- END OVERVIEW -->
		</div>
	</div>
	<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->