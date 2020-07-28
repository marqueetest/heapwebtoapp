<?php
  $advisor_key = $form_key;
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
</style>
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
						<div class="form-group">
                            <label class="control-label" for="client_signup_url">Custom Landing URL</label>
							<small id="urlHelp" class="form-text text-muted">( You can use this landing url to your custom landing page )</small>
							<div class="input-group">
							<input type="hidden" name="hidden_signup_url" class="form-control" id="hidden_signup_url" aria-describedby="basic-addon3" value="<?php echo isset( $client_signup_url) ? "https://heaplan.com/signup/".$client_signup_url : ""; ?>"/>
								<span class="input-group-addon" >https://heaplan.com/signup/</span>
								<input type="text" name="client_signup_url" class="form-control" id="client_signup_url" aria-describedby="basic-addon3" value="<?php echo isset( $client_signup_url) ? $client_signup_url : ""; ?>"/>
								<span class="signup-copy input-group-addon">Copy</span>
							</div>
						</div>
						<div class="form-group">
                            <label class="control-label" for="email_subject">Custom Thankyou Page URL</label>
    						<small id="urlHelp" class="form-text text-muted">( You can use this thankyou url to check your thankyou page )</small>
							<div class="input-group">
							<input type="hidden" name="hidden_thankyou_url" class="form-control" id="hidden_thankyou_url" aria-describedby="basic-addon3" value="<?php echo isset( $client_thankyou_url) ? "https://heaplan.com/thankyou/".$client_thankyou_url : ""; ?>"/>
								<span class="input-group-addon">https://heaplan.com/thankyou/</span>
								<input type="text" class="form-control" id="client_thankyou_url" name="client_thankyou_url" aria-describedby="basic-addon3" value="<?php echo isset( $client_thankyou_url) ? $client_thankyou_url : ""; ?>"/>
								<span class="thankyou-copy input-group-addon">Copy</span>

							</div>
						</div>
						<?php
                        for ($i = 0; $i <= 4; $i++){
                        	?>

		                    <div class="form-group">
		                        <label class="control-label" for="landing_page_<?php echo $i ?>">Domain <?php echo ($i + 1); ?></label>
		                        <input type="text" name="landing_page[]" class="form-control" id="landing_page_<?php echo $i ?>" value="<?php echo isset( $landing_page[$i] ) ? $landing_page[$i] : ""; ?>"/>
		                    </div>

		                    <div class="form-group">
		                        <label class="control-label" for="username_<?php echo $i ?>">Thankyou page <?php echo ($i + 1); ?></label>
		                        <input type="text"  name="thanks_page[]"  class="form-control" id="username_<?php echo $i ?>" value="<?php echo isset( $thanks_page[$i] ) ? $thanks_page[$i] : ""; ?>"/>
		                    </div>

                    		<?php
                    	}
                    	?>

						<button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>

					</form>

					<br/>

					<div class="row">
						<div class="col-md-12">
	                    	<label class="control- col-sm-12 text-center">Copy the code below and past in your landing page</label>
	                    	<textarea class="form-control custom_textarea" id="formtext" onclick="this.focus();this.select()">
								<!--here is the start code for landing apge-->
								<style type="text/css">
							   	#create_client_form td {
								   	font-family: Arial, Helvetica, sans-serif;
								   	font-size: 12px;
								   	vertical-align: top;
							   	}
							   	#create_client_form td span {
							   		color:#F00;
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
								</style>
								<form name="create_client_form" id="create_client_form">
							   		<input type="hidden" value="<?php echo $form_key;?>" name="ADVISOR_PBULIC_KEY" id="ADVISOR_PBULIC_KEY" data-mini="true">
								   	<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
								      	<tr>
								        	<td align="left" width="200"><label for="first_name">First Name: <span>*</span></label></td>
								        	<td align="left" width="300"><input type="text" value="" name="first_name" id="first_name" data-mini="true"></td>
								      	</tr>
								      	<tr>
								        	<td align="left"><label for="last_name">Last Name: <span>*</span></label></td>
								         	<td align="left"><input type="text" name="last_name" value="" id="last_name" data-mini="true"></td>
								      	</tr>
								      	<tr>
								         	<td align="left"><label for="email_address">Email: <span>*</span></label></td>
								         	<td align="left"><input type="text" value="" name="email_address" id="email_address" data-mini="true"></td>
								      	</tr>
								      	<tr>
								        	<td align="left"><label for="adviser_username">Username: <span>*</span></label></td>
								         	<td align="left"><input type="text" value="" name="adviser_username" id="adviser_username" data-mini="true"></td>
								      	</tr>
								      	<tr>
								         	<td align="left"><label for="password">Password: <span>*</span></label></td>
								         	<td align="left"><input type="password" name="password" id="password" data-mini="true"></td>
								      	</tr>
								      	<tr>
								         	<td align="left"><label for="phone">Telephone Number:</label></td>
								         	<td align="left"><input type="text" value="" name="phone" id="phone" data-mini="true"></td>
								      	</tr>
								      	<tr>
								         	<td align="left"><label for="address1">Address: </label></td>
								         	<td align="left"><input type="text" value="" name="address1" id="address1" data-mini="true"></td>
								      	</tr>
								      	<tr>
								         	<td align="left"><label for="address2">Address 2:</label></td>
								         	<td align="left"><input type="text" value="" name="address2" id="address2" data-mini="true"></td>
								      	</tr>
								      	<tr>
								         	<td align="left"><label for="city">City:</label></td>
								         	<td align="left"><input type="text" value="" name="city" id="city" data-mini="true"></td>
								      	</tr>
								      	<tr>
								         	<td align="left"><label for="states" class="select">State:</label></td>
								         	<td align="left">
								            	<select name="states" id="states_adviser" data-native-menu="true" data-mini="true">
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
								         	</td>
								      	</tr>
								      	<tr>
								         	<td align="left"><label for="zipcode" >Zip Code:</label></td>
								         	<td align="left"><input type="text" value="" name="zipcode" id="zipcode" data-mini="true"></td>
								      	</tr>
								      	<tr>
								         	<td align="center" colspan="2"><input type="button" onClick="ProcessAdvisor()" name="save_account" class="button_blue" data-icon="check" value="Create Account" data-theme="button_blue"></td>
								      	</tr>
								   	</table>
								</form>
								<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
								<script type="text/javascript" src="<?php echo ASSETS_URL ?>js/client_singup.js"></script>
								<!--here is the end code for landing apge-->
	                  		</textarea>
	                 	</div>
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
   document.getElementById("formtext").select();
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
