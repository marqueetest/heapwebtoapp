<!-- MAIN -->

<div class="main">

	<!-- MAIN CONTENT -->

	<div class="main-content">

		<div class="container-fluid">

			<!-- OVERVIEW -->

			<div class="panel panel-headline">

				<div class="panel-heading">

					<h3 class="panel-title">Form Validation Settings</h3>

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



					<form class="form-auth-small" action="" method="post" id="validation-settings">



						<table class="table table-bordered">

                 			<thead>

                   				<tr>

                     				<th><strong>Column Name</strong></th>

                     				<th><strong>Mandatory</strong></th>

                   				</tr>

                 			</thead>

                     		<tbody>

                  				<?php

								foreach ( $defaultFields as $key => $value) {
									$sel_no  = '';
									$sel_yes = '';
									if ( isset($vals[$value]) && ($vals[$value] == '' || $vals[$value] == 1) )
										$sel_yes = 'selected="selected"';
									else
										$sel_no = 'selected="selected"';
									?>
	                         		<tr>
	                            		<td>
	                                   		<label for="es"><?php echo $key;?></label>
	                            		</td>
	                            		<td>
	                                   		<select name="<?php echo $value;?>" class="form-control">
	                                        	<option <?php echo $sel_no;?> value="0">No</option>
	                                        	<option <?php echo $sel_yes;?> value="1">Yes</option>
	                                   		</select>
	                            		</td>
	                         		</tr>
					 				<?php
					 			}
					 			?>

                     		</tbody>

	                   	 	<tfoot>

		                       	<tr>

		                        	<td class="text-center" colspan="2">

		                           		<button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>

		                         	</td>

		                       	</tr>

	                     	</tfoot>

                   		</table>



					</form>



				</div>

			</div>

			<!-- END OVERVIEW -->

		</div>

	</div>

	<!-- END MAIN CONTENT -->

</div>

<!-- END MAIN -->