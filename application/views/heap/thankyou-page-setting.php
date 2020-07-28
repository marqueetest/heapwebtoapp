<?php
// print_r($thankyou_page_header);
// return exit(0);
?>

<style>
.signup-copy:hover,  .thankyou-copy:hover{
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}
.copied{
    color:blue;
    font-weight: 600;
}
#tinymce{
  height: auto !important;
}
</style>

<!-- MAIN -->
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Dynamic thankyou page contents</h3>
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

					<form class="form-auth-small" action="" method="post" id="heap-thankyou-page-setting">
						<div class="form-group">
							<div class="input-group">
							<input type="hidden" name="hidden_signup_url" class="form-control" id="hidden_signup_url" aria-describedby="basic-addon3" value="<?php echo isset( $client_signup_url) ? "https://heaplan.com/signup/".$client_signup_url : ""; ?>"/>
								<span class="input-group-addon" >https://heaplan.com/signup/</span>
								<input type="text" name="client_signup_url" class="form-control" id="client_signup_url" aria-describedby="basic-addon3" value="<?php echo isset( $client_signup_url) ? $client_signup_url : ""; ?>"/>
								<span class="signup-copy input-group-addon">Copy</span>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
							<input type="hidden" name="hidden_thankyou_url" class="form-control" id="hidden_thankyou_url" aria-describedby="basic-addon3" value="<?php echo isset( $client_thankyou_url) ? "https://heaplan.com/thankyou/".$client_thankyou_url : ""; ?>"/>
								<span class="input-group-addon">https://heaplan.com/thankyou/</span>
								<input type="text" class="form-control" id="client_thankyou_url" name="client_thankyou_url" aria-describedby="basic-addon3" value="<?php echo isset( $client_thankyou_url) ? $client_thankyou_url : ""; ?>"/>
								<span class="thankyou-copy input-group-addon">Copy</span>
							</div>
						</div>
						<div class="form-group">
	                        <label class="control-label" for="thankyou_page_header">Header Content: </label>
							<!-- <small id="emailHelp" class="form-text text-muted">You can user following place holders {{company name}}, {{email id}}</small> -->
	                         <textarea name="thankyou_page_header" class="form-control editor" id="thankyou_page_header"><?php echo $thankyou_page_header; ?></textarea>
	                    </div>
	                    <div class="form-group">
	                        <label class="control-label" for="thankyou_page_footer">Footer Content: </label>
							<!-- <small id="emailHelp" class="form-text text-muted">You can user following place holders {{company name}}, {{email id}}</small> -->
	                        <textarea name="thankyou_page_footer" class="form-control editor" id="thankyou_page_footer"><?php echo $thankyou_page_footer; ?></textarea>
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
<script>
   	$(document).ready(function(){

		$(".thankyou-copy").click(function(){
			that = $(this);
			$(this).addClass("copied");
			$(this).text("copied");
			id = $("#hidden_thankyou_url").attr('id')
			copy_url(id);
			$(this).text("copied");
			setTimeout(function(){
				that.text("Copy");
				that.removeClass("copied");
			}, 2000);

		})
		$(".signup-copy").click(function(){
			$(this).addClass("copied");
			$(this).text("copied");
			that = $(this);
			id = $("#hidden_signup_url").attr('id')
			copy_url(id);
			setTimeout(function(){
				that.text("Copy");
				that.removeClass("copied");
			}, 2000);
		})
		function copy_url(id){
			var copyText = document.getElementById(id);
			copyText.type = 'text';
			copyText.select();
			document.execCommand("copy");
			copyText.type = 'hidden';

		}

   	});
</script>
