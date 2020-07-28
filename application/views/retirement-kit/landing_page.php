<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Client Signup Landing Page</h3>
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

					<form class="form-auth-small" action="" method="post" id="heap-landing-page">

						<?php
                        for ($i = 0; $i <= 4; $i++){
                        	?>
		                    
		                    <div class="form-group">
		                        <label class="control-label" for="landing_page_<?php echo $i ?>">Domain <?php echo ($i + 1); ?></label>
		                        <input type="text" name="landing_page[]" class="form-control" id="landing_page_<?php echo $i ?>" value="<?php echo isset( $landing_page[$i] ) ? $landing_page[$i] : ""; ?>"/>
		                    </div>

		                    <div class="form-group">
		                        <label class="control-label" for="username_<?php echo $i ?>">Thankyou page <?php echo ($i + 1); ?></label>
		                        <input type="text"  name="thanks_page[]"  class="form-control" id="username_<?php echo $i ?>" value="<?php echo isset($thanks_page[$i]) ? $thanks_page[$i] : ""; ?>"/>
		                    </div>
                    		
                    		<?php
                    	}
                    	?>

						<button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>

					</form>
					<br/>

                    <div class="col-sm-12 clearfix">
						<!--here is the start code for single  landing apge-->
                		<div class="col-sm-6">

	                    	<label class="control- col-sm-12 text-center">Copy the code below and past in your lending page for making the single columns form</label>

	                    	<textarea class="form-control custom_textarea" id="formtext" onclick="this.focus();this.select()">

	                    	<div class="client_form_style">

								<style type="text/css">
									@import url(https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,100,700);
								   	.sign-up_wrapper {
									   	background: #083f8d none repeat scroll 0 0;
									   	box-sizing: border-box;
									   	padding: 10px 26px 10px;
									   	overflow: hidden;
									   	border-radius: 10px 10px 0 0;
								   	}
								   	.my_form {
									   	background: #ebebeb;
									   	padding-bottom: 7px;
									   	padding-top: 27px;
									   	padding-left: 20px;
									  	padding-right: 20px;
									   	border-radius: 0px 0px 10px 10px;
								   	}
								   	.my_form > div > input {
									   	width: 100%;
									   	background: #ffffff;
									   	border: 1px solid #ccc;
									   	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
									   	display: block;
									   	padding: 11px 15px 10px;
									   	text-align: left;
									   	text-transform: capitalize;
									   	font-family: 'Roboto', sans-serif;
									   	transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
									   	font-size: 15px;
									   	box-sizing: border-box;
									   	border: none;
									   	color: #555;
									   	margin-bottom: 20px;
									   	border-radius: 4px;
								   	}

								   .info_advisor_from, .success_advisor_from, .warning_advisor_from, .error_advisor_from {

								   border: 1px solid;

								   margin: 10px 0px;

								   padding:15px 10px 15px 15px;

								   position: fixed;

								   top: 20px;

								   right:20px;

								   z-index:100000000 !important;

								   }

								   .info_advisor_from {

								   color: #00529B;

								   background-color: #BDE5F8;

								   }

								   .success_advisor_from {

								   color: #4F8A10;

								   background-color: #DFF2BF;

								   }

								   .warning_advisor_from {

								   color: #9F6000;

								   background-color: #FEEFB3;

								   }

								   .error_advisor_from {

								   color: #D8000C;

								   background-color: #FFBABA;

								   }

								   .my_form > div >.submit {

								   background: #65bd0e !important;

								   text-align: center !important;

								   text-transform: uppercase !important;

								   font-size: 20px !important;

								   color: #ffffff !important;

								   font-weight: bold !important;

								   font-family: 'Roboto Slab', serif;

								   padding: 15px 15px 15px !important;

								   }

								   .right_article_header > h6 {

								   font-size: 21.81px;

								   color: #ffffff;

								   font-weight: bold;

								   text-align: center;

								   font-family: 'Roboto Slab', serif;

								   line-height: normal;

								   }

								   .right_article_header > h4 {

								   color: #ffffff;

								   font-family: "Roboto Slab", serif;

								   font-size: 33.15px;

								   font-weight: bold;

								   letter-spacing: 0;

								   line-height: normal;

								   text-align: center;

								   }

								   .right_article_header {

								   background: #004ed2;

								   padding: 22px 52px 24px;

								   box-sizing: border-box;

								   border-radius: 10px 10px 0 0;

								   }

								</style>

								<div class="before_form">

								   	<header class="right_article_header">

								      <h6>I Want My Worry</h6>

								      <h4>Free Retirement Kit</h4>

								   	</header>

	   								<form class="my_form" method="post" id="create_client_form" >

	      								<input type="hidden" value="<?php echo $form_key;?>" name="ADVISOR_PBULIC_KEY" id="ADVISOR_PBULIC_KEY" data-mini="true">

								      	<div class="form-group first-name-group">
								        	<input type="text" id="first_name" class="form-control" placeholder="First Name"  name="first_name" required />
								      	</div>

								      	<div class="form-group last-name-group">
								        	<input type="text" placeholder="Last Name"  id="last_name" class="form-control" name="last_name"   required >
								      	</div>

								      	<div class="form-group phone-group">
								        	<input type="text" name="phone" id="phone" class="bc_input" placeholder="Phone Number" maxlength="12" value=""/>
								      	</div>

								      	<div class="form-group email-group">
								        	<input type="text" name="email_address" id="email_address" class="bc_input" value="" placeholder="Email Address"/>
								      	</div>

								      	<div class="form-group">
								        	<input type="button"  onClick="ceateFreeBookClient();" class="btn btn-danger col-sm-8 col-sm-offset-2 submit"  value="Sign Up Now!" name="submit" /> 
								      	</div>

	   								</form>

								   	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
								   	<script type="text/javascript" src="<?php echo ASSETS_URL ?>js/client_signup_rk.js"></script>
								</div>
	                    	</textarea>
	                 	</div>
						<!--here is the end code for single  landing apg-->

						<!--here is the start code for multiple  landing apge-->

                 		<div class="col-sm-6">
                    		<label class="control- col-sm-12 text-center">Copy the code below and past in your lending page for making the two columns form</label>

							<textarea class="form-control custom_textarea" id="formtext2" onclick="this.focus();this.select()">

								<div class="client_form_style">

   									<style type="text/css">

								      @import url(https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,100,700);

								      .sign-up_wrapper {

								      background: #083f8d none repeat scroll 0 0;

								      box-sizing: border-box;

								      padding: 10px 26px 10px;

								      overflow: hidden;

								      border-radius: 10px 10px 0 0;

								      }

								      .income_form {

								      background: #ebebeb none repeat scroll 0 0;

								      padding: 29px 26px 23px 31px;

								      overflow: hidden;

								      border-radius: 0px 0px 10px 10px;

								      }

								      .income_form > div > input {

								      background: #ffffff none repeat scroll 0 0;

								      border: none;

								      border-radius: 4px;

								      box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;

								      box-sizing: border-box;

								      color: #555;

								      float: left;

								      font-family: "Roboto", sans-serif;

								      font-size: 14px;

								      height: 34px;

								      line-height: 1.42857;

								      margin-bottom: 15px;

								      padding: 8px 13px;

								      text-align: left;

								      text-transform: capitalize;

								      transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;

								      width: 286px;

								      margin-right: 11px;

								      margin-left: 11px;

								      height: 40px;

								      }

								      .info_advisor_from, .success_advisor_from, .warning_advisor_from, .error_advisor_from {

								      border: 1px solid;

								      margin: 10px 0px;

								      padding:15px 10px 15px 15px;

								      position: fixed;

								      top: 20px;

								      right:20px;

								      z-index:100000000 !important;

								      }

								      .info_advisor_from {

								      color: #00529B;

								      background-color: #BDE5F8;

								      }

								      .success_advisor_from {

								      color: #4F8A10;

								      background-color: #DFF2BF;

								      }

								      .warning_advisor_from {

								      color: #9F6000;

								      background-color: #FEEFB3;

								      }

								      .error_advisor_from {

								      color: #D8000C;

								      background-color: #FFBABA;

								      }

								      .sign-up_wrapper > h6 {

								      color: #ffffff;

								      font-family: "Roboto Slab", serif;

								      font-size: 19px;

								      font-weight: 600;

								      margin-bottom: 10px;

								      line-height: 25px;

								      margin-top: 9px;

								      text-align: left;

								      }

								      .income_form > div > .submit {

								      background: #65bd0e none repeat scroll 0 0 !important;

								      color: #ffffff !important;

								      font-size: 20px !important;

								      font-weight: 600 !important;

								      height: auto !important;

								      padding: 6px 15px !important;

								      text-align: center !important;

								      text-transform: uppercase !important;

								      width: 100% !important;

								      }

								      @media only screen and (max-width: 900px){

								      .income_form > div > input {

								      display: inline-block;

								      width: 44.28%;

								      }

								      }

								      @media only screen and (max-width: 800px){

								      .income_form > div > input {

								      display: inline-block;

								      width: 44.28%;

								      }

								      }

								      @media only screen and (max-width: 786px){

								      .income_form > div > input {

								      display: inline-block;

								      width: 44.28%;

								      }

								      }

								      @media only screen and (max-width: 486px){

								      .income_form > div > input {

								      display: inline-block;

								      width: 100%;

								      }

								      }

								   	</style>

   									<div class="before_form">
								      	<header class="sign-up_wrapper">
								        	<h6>*This download has been over ten  years in the making. For the first time ever, I write on the elusive topic of identifying the *best* way to grow  wealth in the stock market.</h6>
								      	</header>

								      	<form class="income_form" method="post" id="create_client_form" >

								         <input type="hidden" value="<?php echo $form_key;?>" name="ADVISOR_PBULIC_KEY" id="ADVISOR_PBULIC_KEY" data-mini="true">

								         <div class="form-group first-name-group">

								            <input type="text" id="first_name" class="form-control" placeholder="First Name"  name="first_name" required />

								         </div>

								         <div class="form-group last-name-group">

								            <input type="text" placeholder="Last Name"  id="last_name" class="form-control" name="last_name"   required >

								         </div>

								         <div class="form-group phone-group">

								            <input type="text" name="phone" id="phone" class="bc_input" placeholder="Phone Number" maxlength="12" value=""/>

								         </div>

								         <div class="form-group email-group">

								            <input type="text" name="email_address" id="email_address" class="bc_input" value="" placeholder="Email Address"/>

								         </div>

								         	<div class="form-group">
								            	<input type="button"  onClick="ceateFreeBookClient();" class="btn btn-danger col-sm-8 col-sm-offset-2 submit"  value="Sign Up Now!" name="submit" /> 
								         	</div>
								         	
								      	</form>
   									</div>

								   	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
								   	<script type="text/javascript" src="<?php echo ASSETS_URL ?>js/client_signup_rk.js"></script>

								</div>
							</textarea>
                 		</div>
						<!--here is the end code for multiple  landing apg-->
               		</div>

				</div>
			</div>
			<!-- END OVERVIEW -->
		</div>
	</div>
	<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->
<script>
   $("#formtext").focus(function() {
		$(this).select();
	});

	$("#formtext2").focus(function() {
		$(this).select();
	});
</script>