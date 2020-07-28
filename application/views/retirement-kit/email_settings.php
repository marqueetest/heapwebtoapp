<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Dynamic Email Contents</h3>
					<!--<p class="panel-subtitle">Please enter all the required fields to create a client.</p>-->
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

					<form class="form-auth-small" action="" method="post" id="heap-email-settings">

	                    <div class="form-group">
	                        <label class="control-label" for="email_name">From Name:</label>
	                        <input type="text" name="email_name" class="form-control" id="email_name" value="<?php echo $email_name; ?>"/>
	                    </div>

	                    <div class="form-group">
	                        <label class="control-label" for="email_subject">Email Subject: </label>
	                        <input type="text" name="email_subject" class="form-control" id="email_subject" value="<?php echo $email_subject; ?>"/>
	                    </div>

	                    <div class="form-group">
	                        <label class="control-label" for="email_content">Email Contents Heading: </label>
	                        <input type="text" name="email_content" class="form-control" id="email_content" value="<?php echo $email_content; ?>"/>
	                    </div>

	                    <div class="form-group">
	                        <label class="control-label" for="email_reply">Reply-to Email Address: </label>
	                        <input type="text" name="email_reply" class="form-control" id="email_reply" value="<?php echo $email_reply; ?>"/>
	                    </div>

	                    <div class="form-group">
	                        <label class="control-label" for="email_title">Title in Email:</label>
	                        <input type="text" name="email_title" class="form-control" id="email_title" value="<?php echo $email_title; ?>"/>
	                    </div>

	                    <div class="form-group">
	                        <label class="control-label" for="email_footer">Email Footer: </label>
	                        <textarea name="email_footer" class="form-control editor" id="email_footer"><?php echo $email_footer; ?></textarea>
	                    </div>

						<button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>

					</form>

				</div>
			</div>
			<!-- END OVERVIEW -->
			
		</div>
	</div>
	<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->