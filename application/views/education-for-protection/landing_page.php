<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Education for Protection Landing Page</h3>
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
		                        <input type="text" name="landing_page[]" class="form-control" id="landing_page_<?php echo $i ?>" value="<?php echo isset($landing_page[$i]) ? $landing_page[$i] : ""; ?>"/>
		                    </div>
		                    <div class="form-group">
		                        <label class="control-label" for="username_<?php echo $i ?>">Thankyou page <?php echo ($i + 1); ?></label>
		                        <input type="text"  name="thanks_page[]"  class="form-control" id="username_<?php echo $i ?>" value="<?php echo isset($thanks_page[$i]) ? $thanks_page[$i] : ""; ?>"/>
		                    </div>
                    		<?php
                    	}
                    	?>
						<input name="landing_page_form" type="submit" class="btn btn-primary btn-lg btn-block" value="Save" />
					</form>
					<br/>
					<div class="row">
                 		<form method="post" class="form-horizontal" enctype="multipart/form-data" action=""  >
				   			<?php 
                       		//here is the complete code for selection of the books based on the admin 
					   		if( $books_permission == 1 ){
					   			?>
                             	<label class="control-label col-sm-3 text-right">Available Books</label>
                             	<div class="col-sm-9">
                             		<select  name="custom_book_select[]" id="custom_book_select"  multiple="multiple" class="form-control">
	                             		<?php
	                             		if( !empty( $ebook_array ) ) {
	                             			foreach( $ebook_array as $ebook ) {
	                             				?>
		                                   		<option value="<?php echo $ebook["pdfid"];?>"><?php echo $ebook["title"];?></option>
		                                		<?php
	                             			}
	                             		}
	                                	?> 
                              		</select>
                              		<input type="submit" name="select_books" value="Update Code" class="btn btn-primary">
                             	</div>
					   		<?php } ?>                      
                 		</form>
               		</div>
               		<div class="col-sm-12 clearfix" style="margin-top:30px;">
                		<label class="control- col-sm-12 text-center">Copy the code below and past in your landing page</label>
                		<textarea class="form-control custom_textarea" id="formtext">
							<!--here is the start code for landing apge-->
							<style type="text/css">
							    .form-1e.te {
							        width: 94% !important;   
							    }
							    .form-zp {
							        width: 81% !important; 
							    }
							    .form-st {
							        width: 79% !important;
							    }
							    .form-2 {
							        width: 49% !important;
							        display: inline-block;
							    }
							    .form-1 {
							        width: 98% !important;
							        display: inline-block;
							    }
							    .cr-def {
							        cursor: default !important;
							    }
							    .form-1a, .form-1b {
							        width: 95% !important;
							        display: inline-block;
							    }
							    .form-1aa {
							        width: 86% !important;
							        display: inline-block;
							    }
							    .form-1c {
							        width: 89.6% !important;
							        display: inline-block;
							    }
							    .form-1d {
							        width: 91% !important;
							        display: inline-block;
							    }
							    .form-1e {
							        width: 78.3% !important;
							        display: inline-block;
							    }
							    .form-3 {
							        width: 32.24444% !important;
							        display: inline-block;
							    }
							    .form-sp-b {
							        width: 66% !important;
							        display: inline-block;
							    }
							    .form-sp-s {
							        display: inline-block;
							        width: 32.4% !important;
							    }
							    .lb-in-div {
							        font-size: 16px;
							        margin-top: 30px;
							    }
							    .btn-red-input {
							        background: #bc2b2b;
							        color: #ffffff;
							        padding: 20px 80px;
							        font-size: 16px;
							        font-weight: 600;
							        border: none;
							        text-transform: uppercase;
							    }
							    .red-btn-dv {
							        text-align: center;
							    }
							    em {
							        color: red;
							    }
							    .lb-label {
							        float: left;
							        padding-top: 8px;
							        width: 75% !important;
							    }
							    .lb-select {
							        width: 23%;
							        float: right;
							    }
							    .form-1 > br {
							        display: none;
							    }
							    .lb-select {
							        float: right !important;
							        position: relative !important;
							        right: -1.2% !important;
							        width: 23% !important;
							    }
							    .client_form_style{ 
							    	width:100%;
							    }
								#create_client_form td {
									font-family: Arial, Helvetica, sans-serif;
									font-size: 12px;
									vertical-align: top;
									width:100%;
									max-width:100%;
								}
								#create_client_form td span {
									color:#F00;
								}
								#create_client_form td em{
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
								#overlayer_adviosr {
									background: #000 none repeat scroll 0 0;
									height: 100%;
									opacity: 0.5;
									position: fixed;
									left: 0px;
									top: 0px;
									width: 100%;
									z-index: 9999;
								}
								input::-webkit-input-placeholder {
							   		color:black;
								}
								input:-moz-placeholder { /* Firefox 18- */
								   color:black;
								}
								input::-moz-placeholder {  /* Firefox 19+ */
								   color:black;
								}
								input:-ms-input-placeholder {  
								   color:black;
								}
								input[type='text'], input[type='password'], input[type='email'], input[type='tel'], textarea, select {
									padding:5px!important;
									border:#CCC solid 1px!important;
								}
								@media only screen and (max-width: 768px) {
									#create_client_form > table {
									  max-width: 600px;
									  width: 100%;
									  padding: 0 10px;
									}
								}
								@media only screen and (max-width: 510px) {
									select {
									  display: block;
									  margin-top: 19px;
									  width: 100%;
									}
								}
							    @media only screen and (max-width:767px) {
							        .lb-select {
							            right: -4.7% !important;
							        }        
							    }
							    @media only screen and (max-width:480px) {
							        .form-2, .form-1, .form-st, .form-zp, .form-1aa, .form-1b, .form-sp-b, .form-1c, .form-sp-s, .form-1d, .form-3, .form-1e, .form-1e.te, .lb-label, .lb-select {
							            width: 100% !important;
							 			box-sizing: border-box;
							        }
							        .form-1 > br {
							            display: none !important;
							        }
							        .lb-select {
							            right: 0 !important;
							        }
							    }
							    @media only screen and (min-width:480px) and (max-width:510px) {
							        .lb-label {
							            padding-top: 14px;
							        }
							    }
							</style>
							<div class="client_form_style">
								<form name="create_client_form" id="create_client_form">     
    								<input type="hidden" value="<?php echo $form_key;?>" name="ADVISOR_PBULIC_KEY" id="ADVISOR_PBULIC_KEY" data-mini="true">
	          						<div>
							            <div class="form-2 a">
							                <div class="form-group">
							                    <label for="email_address" class="form-1 cr-def">Email Address (Username) <em>*</em></label>
							                    <input type="email" name="email_address" class="form-1aa" id="email_address" value="" placeholder="username@domain.com">
							                </div>
							            </div>
							            <div class="form-2 b">
							                <div class="form-group">
							                    <label for="email_address" class="form-1 cr-def">Password: <?php echo $validation;?></label>
							                    <input type="password" class="form-1b" name="password" id="password" value="" autocomplete="off">
							                </div>
							            </div>
							            <div class="form-2">
							                <div class="form-group">
							                    <label for="first_name" class="form-1 cr-def">First Name: <em>*</em></label>
							                    <input type="email" name="first_name" class="form-control form-1aa" id="first_name" placeholder="First Name" value="">
							                </div>
							            </div>
							            <div class="form-2">
							                <div class="form-group">
							                    <label for="last_name" class="form-1 cr-def">Last Name: <em>*</em></label>
							                    <input type="text" name="last_name" id="last_name" class="form-control form-1b" placeholder="Last Name" value="">
							                </div>
							            </div>
							            <div class="form-sp-b">
							                <div class="form-group">
							                    <label for="street" class="form-1 cr-def">Street Address: <?php echo $validation;?></label>
							                    <input type="text" name="street" id="street" class="form-1c"  placeholder="XXXX Someplace Street" value="">
							                </div>
							            </div>
							            <div class="form-sp-s">
							                <div class="form-group">
							                    <label for="city" class="form-1 cr-def">City: <?php echo $validation;?></label>
							                    <input type="text" name="city" id="city" class="form-1d" placeholder="City" value="">
							                </div>
							            </div>
							            <div class="form-sp-b">
							                <div class="form-group form-2">
							                    <label for="state" class="form-1 cr-def">State: <?php echo $validation;?></label>
							                    <input type="text" name="state" id="state" class="form-st" placeholder="XX" maxlength="2" value="">
							                </div>
							                <div class="form-group form-2">
							                    <label for="zipcode" class="form-1 cr-def">Zip: <?php echo $validation;?></label>
							                    <input type="text" name="zipcode" id="zipcode" class="form-zp" placeholder="XXXXX" maxlength="8" value="">
							                </div>
							            </div>
							            <div class="form-sp-s">
							                <div class="form-group">
							                    <label for="phone" class="form-1 cr-def">Telephone: <?php echo $validation;?></label>
							                    <input type="text" name="phone" id="phone" class="form-1d" placeholder="XXX-XXX-XXXX" maxlength="12" value="">
							                </div>
							            </div>
							            <div class="form-1 lb-in-div">
							                <label class="cr-def"><b>Quick Survey:</b></label>
							            </div>
							            <div class="form-1">
						                    <label  class="lb-label cr-def">1) I am interested in protecting my assets from creditors.</label>
						                    <select name="protect_asset" class="lb-select">
						                        <option selected="selected" value="">Choose...</option>
						                        <option value="Yes">Yes</option>
						                        <option value="No">No</option>
						                    </select>
							            </div>
							            <div class="form-1">
						                    <label  class="lb-label cr-def">2) I am interested in reducing my income taxes.</label>
						                    <select name="reduce_inctax" class="lb-select">
							                    <option selected="selected" value="">Choose...</option>
							                    <option value="Yes">Yes</option>
							                    <option value="No">No</option>
						                    </select>
							            </div>
							            <div class="form-1">
						                    <label  class="lb-label cr-def">3) I am interested in a guaranteed income for life that can not be outlived.</label>
						                    <select name="guarantee_income" class="lb-select">
							                    <option selected="selected" value="">Choose...</option>
							                    <option value="Yes">Yes</option>
							                    <option value="No">No</option>
						                    </select>
							            </div>
							            <div class="form-1">
						                    <label  class="lb-label cr-def">4) I would like help with my financial/retirement plan or estate plan.</label>
						                    <select name="financial_help" class="lb-select">
							                    <option selected="selected" value="">Choose...</option>
							                    <option value="Yes">Yes</option>
							                    <option value="No">No</option>
						                    </select>
							            </div>
							            <?php 
										/*here first of all check whether books option selected or not*/
										if($books_permission==1){
										   	if( $is_books_posted == 1 ){
											    if( !empty($selected_books) ) {
											    	?>
											    	<div class="form-1 lb-in-div">
										                <label class="cr-def"><b>Available Books:</b></label>
										            </div>
											    	<?php
											    	$i = 0;
											    	foreach($selected_books as $selected_book){
											    		$i++; 
														if($i==1)
														   $checked	= 'checked="checked"  id="checked"'  ;
													   	else
														   $checked	= '';
														?>
							                         	<div class="form-1">
							                                <div class="form-group">
							                                	<label><input <?php echo $checked; ?> type="checkbox"  name="ebook[]" value="<?php echo $selected_book["pdfid"];?>"> <?php echo $selected_book["title"];?> </label>
							                                </div>
							                          	</div>
							                        	<?php 
											    	}
											    }
							                }
							            } else{
							            	if( !empty($ebook_array) ) {
							            		?>
							            		<div class="form-1 lb-in-div">
									                <label class="cr-def"><b>Available Books:</b></label>
									            </div>
							            		<?php
							            		$i = 0;
							            		foreach( $ebook_array as $ebook ) {
							            			$i++;
												   	if($i==1)
													   $checked	= 'checked="checked"  id="checked"'  ;
												   	else
													   $checked	= '';
											   		?>
										            <div class="form-1">
										                <div class="form-group">
										                    <label><input <?php echo $checked; ?> type="checkbox"  name="ebook[]" value="<?php echo $ebook["pdfid"];?>"> <?php echo $ebook["title"];?> </label>
										                </div>
										            </div>
								            		<?php
							            		}
							            	}
							            }
							            ?>
							            <div>
							                <div class="red-btn-dv">
							                	<!-- Make Sure Onclick Action is Here -->
							                    <input class="btn-red-input" type="button" value="Register" id="bc_register" onClick="ceateFreeBookClient();" />
							                </div>
							            </div>
	        						</div>            
								</form>
								<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
						        <script type="text/javascript" src="<?php echo ASSETS_URL ?>js/client_signup_efp.js?key=<?php echo $form_key;?>"></script> 
        					</div>
							<!--here is the end code for landing apge-->
  						</textarea>
               		</div>
				</div>
			</div>
			<!-- END OVERVIEW -->
		</div>
	</div>
	<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->