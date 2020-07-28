<style>
.border_rightgrey {
    border-right: 1px;
    border-right-style: solid;
    border-right-color: #D6CEC3;
    background-color: white;
    line-height: 40px;
    font-size: 14px;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    line-height: 1;
}
.inner_table {
    font-size: 14px;
}
.form-control {
    width: 100%;
    height: 26px !important;
    padding: 4px 12px !important;
    font-size: 14px !important;
}
.divtableblack {
    background-color: #2B333E;
    color: white;
    border-right: #D6CEC3 solid 1px;
    font-weight: bold !important;
    padding: 13px 9px 13px 9px !important;
    padding-left: 12px !important;
}
.form-control {
     border: 1px solid rgba(0, 0, 0, .08);
}
input[type="radio"], input[type="checkbox"] {
    margin: 4px 37px 0 !important;
}
.other_exo {
    font-weight: bold !important;
}
.totals {
    border-top: 1px solid #ddd;
    padding-top: 20px;
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
					<h3 class="panel-title"><span  class="upr_head"><span>Step 1:Expenses(<?php echo $client["first_name"]." ".$client["last_name"]; ?>) </span> (<span class="new_head upr_head"><?php if($term < 1): ?>NEW<?php else: ?>Updating Term <?php echo $term; ?><?php endif; ?></span>)</span></h3>
					<p class="panel-subtitle"></p>
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
					?>

					<form class="form-auth-small" action="" method="post" id="register-client">
						
						<div class="form-group">
							
							<div class="row">
								<div class="col-md-4 divtableblack">Existing Debt (to be paid off)</div> 
	                            <div class="col-md-3 divtableblack">Balance</div>
	                            <div class="col-md-3 divtableblack">Monthly Payments</div>
	                            <div class="col-md-2 divtableblack">Add to Heloc</div>
							</div>

							<?php  
                            $r = 0;
                            while( $r <= 9 ){  
                                ?>
                                <div class="row"> 
                                    <div class="col-md-4 border_rightgrey">
                                        <input type="text" name="expense[<?php echo $r; ?>]" id="expense[<?php echo $r; ?>]" value="" class="form-control" /> 
                                    </div> 
                                    <div class="col-md-3 border_rightgrey">
                                        <input type="text" name="balance[<?php echo $r; ?>]"  id="balance[<?php echo $r; ?>]" onBlur="calcBalance();" value="" class="form-control" /> 
                                    </div> 
                                    <div class="col-md-3 border_rightgrey">
                                        <input type="text" name="payments[<?php echo $r; ?>]" type="text" id="payments[<?php echo $r; ?>]" onBlur="calcExpenses();" value="" class="form-control" />
                                    </div>
                                    <div class="col-md-2 panel_last">
                                        <input type="checkbox" name="addTo_heloc[<?php echo $r; ?>]" id="addTo_heloc[<?php echo $r; ?>]" value="true" />
                                    </div> 
                                </div>
                                <?php 
                                $r++;   
                            }
                            ?>
						
						</div>

						<div class="row totals">
                       		<div class="col-md-4 col-xs-2">
                       			<span class="pull-right" >Total:</span>
                       		</div>
                       		<div class="col-md-3 col-xs-2">
                   				<span id="totalBalance" class="pull-right">$ 0.00</span>
                       		</div>
	                       	<div class="col-md-3 col-xs-5">
	                   			<span id="totalPayments" class="pull-right">$ 0.00</span>
	                       	</div>
                       		<div class="col-md-2 col-xs-3">
                   				
                       		</div>
                   		</div>

                   		<h3>Other Monthly Expenses</h3>
                   		<div class="form-group" id="other_monthly_expenses">

                   			<div class="row">
                   				<div class="col-md-3 divtableblack">Expenses</div>
                   				<div class="col-md-3 divtableblack">Amount</div>
                   				<div class="col-md-3 divtableblack">Expenses</div>
                   				<div class="col-md-3 divtableblack">Amount</div>
                   			</div>

                   			<div class="row">
                   				<div class="col-md-3 border_rightgrey">
				                    <span class="inner_table">Groceries</span>
				                </div> 
				                <div class="col-md-3 border_rightgrey">
				                    <input type="text" name="otherAmount[0]" id="otherAmount[0]" onBlur="calcOther();" value="" class="form-control" /> 
				                </div> 
				                <div class="col-md-3 border_rightgrey">
				                    <span class="inner_table">Child Suppoort</span>
				                </div> 
				                <div class="col-md-3 panel_last">
				                    <input type="text" name="otherAmount[21]" id="otherAmount[21]" onBlur="calcOther();" value="" class="form-control" /> 
				                </div>
                   			</div>

                   			<div class="row"> 
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Power</span>
			                    </div> 
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[1]" id="otherAmount[1]" onBlur="calcOther();" value="" class="form-control" />
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Alimony</span>
			                    </div> 
			                    <div class="col-md-3 panel_last">
			                        <input type="text"  name="otherAmount[22]" id="otherAmount[22]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
				            </div>

				            <div class="row"> 
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Gas</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[2]" id="otherAmount[2]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                         <span class="inner_table">Public School Fees</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[23]" id="otherAmount[23]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                </div>

			                <div class="row"> 
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Sewer/Trash</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[3]" id="otherAmount[3]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                         <span class="inner_table">Public School Fees(Tuition)</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[24]" id="otherAmount[24]" onBlur="calcOther();" value="" class="form-control "> 
			                    </div>
			                </div>

			                <div class="row"> 
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Water</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[4]" id="otherAmount[4]" onBlur="calcOther();" value="" class="form-control "> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                         <span class="inner_table">Family Expenses (Children, clothing, etc)</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[25]" id="otherAmount[25]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                </div>

			                <div class="row"> 
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Car Insurance</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[5]" id="otherAmount[5]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                         <span class="inner_table">Home Owners Association</span>
			                    </div>
			                    <div class="col-md-3 panel_last" width="10%" height="23">
			                        <input type="text" name="otherAmount[26]" id="otherAmount[26]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div> 
			                </div>

			                <div class="row">
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Life Insurance</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[6]" id="otherAmount[6]" onBlur="calcOther();" value="" class="form-control" />
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                         <span class="inner_table">Secondary Properties(Include taxes, insurance, escrows, etc)</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[27]" id="otherAmount[27]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                </div>

			                <div class="row">
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">401K (if not taken from income)</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[7]" id="otherAmount[7]" onBlur="calcOther();" value="" class="form-control" />
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                         <span class="inner_table">Consumer Credit (Not consolidated)</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[28]" id="otherAmount[28]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                </div>

			                <div class="row">
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Student Loans</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[8]" id="otherAmount[8]" onBlur="calcOther();" value="" class="form-control "> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Maid Service</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[29]" id="otherAmount[29]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                </div>

			                <div class="row"> 
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Entertainment</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[9]" id="otherAmount[9]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                         <span class="inner_table">Holiday Fund</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[30]" id="otherAmount[30]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                </div>

			                <div class="row"> 
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Gasoline</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[10]" id="otherAmount[10]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Vacations</span>
			                    </div> 
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[31]" id="otherAmount[31]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                </div>

			                <div class="row"> 
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Household Items</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[11]" id="otherAmount[11]" onBlur="calcOther();" value="" class="form-control "> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                         <span class="inner_table">Repair Fund (Home or Vehicle)</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text"  name="otherAmount[32]" id="otherAmount[32]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                </div>

			                <div class="row"> 
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Cell Phone</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[12]" id="otherAmount[12]" onBlur="calcOther();" value=""  class="form-control" /> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                         <span class="inner_table">Taxes/Insurance (If not paid with mortgage)</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[33]" id="otherAmount[33]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                </div>

			                <div class="row"> 
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Home Phone</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey "  width="10%" height="23">
			                        <input type="text"  name="otherAmount[13]" id="otherAmount[13]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                         <span class="inner_table">Other</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text"  name="otherAmount[34]" id="otherAmount[34]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                </div>

			                <div class="row">
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Cable</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[14]" id="otherAmount[14]" onBlur="calcOther();" value=""  class="form-control" /> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Other</span>
			                    </div> 
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[35]" id="otherAmount[35]" onBlur="calcOther();" value=""  class="form-control" /> 
			                    </div>
			                </div>

			                <div class="row"> 
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Internet</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[15]" id="otherAmount[15]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Other</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[36]" id="otherAmount[36]" onBlur="calcOther();" value="" class="form-control" />
			                    </div>
			                </div>

			                <div class="row"> 
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Medical Co-pays</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[15]" id="otherAmount[15]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Other</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[37]" id="otherAmount[37]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                </div>

			                <div class="row"> 
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Prescriptions</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[16]" id="otherAmount[16]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Other</span>
			                    </div> 
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[38]" id="otherAmount[38]" onBlur="calcOther();" value="" class="form-control" />
			                    </div>
			                </div>

			                <div class="row">
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Dental</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[17]" id="otherAmount[17]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Other</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[39]" id="otherAmount[39]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                </div>

			                <div class="row">
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Charitable Contributions</span>
			                    </div> 
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[18]" id="otherAmount[18]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                         <span class="inner_table">Other</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text" name="otherAmount[40]" id="otherAmount[40]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                </div>
			                      
			                <div class="row">
			                    <div class="col-md-3 border_rightgrey">
			                        <span class="inner_table">Investments</span>
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                        <input type="text" name="otherAmount[19]" id="otherAmount[19]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                    <div class="col-md-3 border_rightgrey">
			                         <span class="inner_table">Other</span>
			                    </div>
			                    <div class="col-md-3 panel_last">
			                        <input type="text"  name="otherAmount[41]" id="otherAmount[41]" onBlur="calcOther();" value="" class="form-control" /> 
			                    </div>
			                </div>

				        </div> <!-- other_monthly_expenses -->

				        <div class="row totals">
				            <div class="col-md-12"> <span class="pull-right"><strong>Total: </strong>&nbsp;<span id="totalOther">$0.00</span></span></div>
				        </div>

				        <h3>Other Non-Monthly Expenses</h3>
				        <div class="form-group">

				        	<div class="row">
				        		<div class="col-md-6 divtableblack">&nbsp;</div>
	                            <div class="col-md-3 divtableblack">Amount</div> 
	                            <div class="col-md-3 divtableblack">Monthly Amount</div>
				        	</div>

				        	<div class="row">
	                            <div class="col-md-6 border_rightgrey">
	                                <span class="inner_table">Annual Expenses</span>
	                            </div>
	                            <div class="col-md-3 border_rightgrey">
	                                <input type="text" name="annual_exp_amount" id="annual_exp_amount" onBlur="calcNon();" value="" class="form-control" /> 
	                            </div>
	                            <div class="col-md-3 panel_last">
	                                <span id="annual_exp_monthly"></span> 
	                            </div>
                        	</div>

                        	<div class="row"> 
	                            <div class="col-md-6 border_rightgrey">
	                                <span class="inner_table">Semi-Annual Expenses</span>
	                            </div>
	                            <div class="col-md-3 border_rightgrey">
	                                <input type="text" name="semi_exp_amount" id="semi_exp_amount" onBlur="calcNon();" value="" class="form-control" /> 
	                            </div>
	                            <div class="col-md-3 panel_last">
	                                <span id="semi_exp_monthly"></span>
	                            </div>
                        	</div>

				        </div>

				        <div class="row totals">
	                    	<div class="col-md-8 col-xs-5"></div>
	                       	<div class="col-md-2 col-xs-4">
	                   			<span>Total:</span>
	                       	</div>
	                       	<div class="col-md-2 col-xs-3">
	                   			<span class="pull-right">$ 0.00</span>
	                       	</div>
                		</div>

				        <h3>Other Non-Monthly Expenses</h3>
				        <div class="form-group">

				        	<div class="row">
				        		<div class="col-md-8 divtableblack">&nbsp;</div> 
		                        <div class="col-md-4 divtableblack"><span class="pull-right"><strong>Total </strong></span></div>
				        	</div>

				        	<div class="row">
	                            <div class="col-md-8 border_rightgrey">
	                                <span class="inner_table pull-right">Current Debt</span>
	                            </div>
	                           
	                            <div class="col-md-4 panel_last">
	                                <span class="pull-right" id="totalPayments2"> $ 0.00</span> 
	                            </div>
				        	</div>

				        	<div class="row">
	                            <div class="col-md-8 border_rightgrey">
	                                <span class="inner_table pull-right">Annual Expenses</span>
	                            </div>
	                           
	                            <div class="col-md-4 panel_last">
	                                 <span class="pull-right" id="totalOther2">$ 0.00</span> 
	                            </div>
	                        </div>

		                    <div class="row"> 
	                            <div class="col-md-8 border_rightgrey">
	                                <span class="inner_table pull-right">Semi-Annual Expenses</span>
	                            </div>
	                           
	                            <div class="col-md-4 panel_last">
	                                 <span class="pull-right" id="totalNon2">$ 0.00</span>  
	                            </div>
	                        </div>   
		                     
				        </div>

				        <div class="row totals">
	                       	<div class="col-md-8 col-xs-7"><span class="pull-right"><strong>Total Expenses:</strong></span></div>
	                       	<div class="col-md-2 col-xs-2"></div>
	                       	<div class="col-md-2 col-xs-3">
	                   			<span class="pull-right" id="gTotalExpenses">$ 0.00</span>
	                       	</div>
	                	</div>
						
						<br/><br/>					
						<button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>

					</form>	
				</div>
			</div>
			<!-- END OVERVIEW -->
			
		</div>
	</div>
	<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->
<!-- create report script -->
<script type="text/javascript">
var gExpenses = 0;
var gOther = 0;
var gNon = 0;
$(function()
{
    //$("input:text:first").focus();
    $("#expense\\[0\\]").focus();
    calcExpenses();
    calcBalance();
    calcOther();
    calcNon();
});
var expenseRows = 10;
function calcExpenses()
{
    var totalPayments = 0;
    var paymentsField;
    
    for ( var i = 0; i < expenseRows; i++ )
    {
        paymentsField = $("#payments\\[" + i + "\\]");
        //alert($("#payments\\[" + i + "\\]"));
        if(!IsEmpty(paymentsField))
        {    
            var paymentsFieldVal = parseFloat(filterNum(paymentsField.val()));
            if(isNaN(paymentsFieldVal))
            {
                alert("Number not recognized. Use format $XX.XX or XX.XX");
            }
            paymentsFieldVal = parseFloat(paymentsFieldVal.toFixed(2));
            
            totalPayments = parseFloat(totalPayments) + paymentsFieldVal;
            paymentsField.val(formatNumber(paymentsFieldVal,2,',','.','$ '));
        }
    }
    $("#totalPayments").html(formatNumber(totalPayments.toFixed(2),2,',','.','$ '));
    $("#totalPayments2").html(formatNumber(totalPayments.toFixed(2),2,',','.','$ '));
    
    gExpenses = totalPayments.toFixed(2);
    gTotalExpenses = calcTotal();
    $("#gTotalExpenses").html(formatNumber(gTotalExpenses,2,',','.','$ '));
}
function calcBalance()
{
    var totalBalance = 0;
    var balanceField;
    
    for ( var i = 0; i <= expenseRows; i++ )
    {
        balanceField = $("#balance\\[" + i + "\\]");
        //alert($("#payments\\[" + i + "\\]"));
        if(!IsEmpty(balanceField))
        {    
            var balanceFieldVal = parseFloat(filterNum(balanceField.val()));
            if(isNaN(balanceFieldVal))
            {
                alert("Number not recognized. Use format $XX.XX or XX.XX");
            }
            balanceFieldVal = parseFloat(balanceFieldVal.toFixed(2));
            
            totalBalance = parseFloat(totalBalance) + balanceFieldVal;
            balanceField.val(formatNumber(balanceFieldVal,2,',','.','$ '));
        }
    }
    $("#totalBalance").html(formatNumber(totalBalance.toFixed(2),2,',','.','$ '));
}
function calcOther()
{
    var totalOther = 0;
    var otherAmtField;
    
    for ( var i = 0; i < 42; i++ )
    {
        otherAmtField = $("#otherAmount\\[" + i + "\\]");
        //alert($("#payments\\[" + i + "\\]"));
        if(!IsEmpty(otherAmtField))
        {    
            var otherAmtFieldVal = parseFloat(filterNum(otherAmtField.val()));
            if(isNaN(otherAmtFieldVal))
            {
                alert("Number not recognized. Use format $XX.XX or XX.XX");
            }
            otherAmtFieldVal = parseFloat(otherAmtFieldVal.toFixed(2));
            
            totalOther = parseFloat(totalOther) + otherAmtFieldVal;
            otherAmtField.val(formatNumber(otherAmtFieldVal,2,',','.','$ '));
        }
    }
    $("#totalOther").html(formatNumber(totalOther.toFixed(2),2,',','.','$ '));
    $("#totalOther2").html(formatNumber(totalOther.toFixed(2),2,',','.','$ '));
    
    gOther = totalOther.toFixed(2);
    gTotalExpenses = calcTotal();
    $("#gTotalExpenses").html(formatNumber(gTotalExpenses,2,',','.','$ '));
}
function calcNon()
{
    var totalNon = 0;
    var semiAmtField;
    var annualAmtField;
    var annual_monthly = 0;
    var semi_monthly = 0;
    
        annualAmtField = $("#annual_exp_amount");
        semiAmtField = $("#semi_exp_amount");
        
        if(!IsEmpty(annualAmtField))
        {
            annualAmtVal = filterNum(annualAmtField.val());
        }
        else annualAmtVal = '0';
        
        if(!IsEmpty(semiAmtField))
        {
            semiAmtVal = filterNum(semiAmtField.val());
        }
        else semiAmtVal = '0';
        
            var annual_monthly = parseFloat(annualAmtVal) / 12;
            var semi_monthly = parseFloat(semiAmtVal) / 6;
    
            /*if(isNaN(annualAmtFieldVal))
            {
                alert("Number not recognized. Use format $XX.XX or XX.XX");
            }*/
            
            totalNon = annual_monthly + semi_monthly;
        
        $("#annual_exp_monthly").html(formatNumber(annual_monthly,2,',','.','$ '));
    $("#annual_exp_amount").val(formatNumber(annualAmtVal,2,',','.','$ '));
    $("#semi_exp_amount").val(formatNumber(semiAmtVal,2,',','.','$ '));
    $("#annual_exp_monthly").html(formatNumber(annual_monthly,2,',','.','$ '));
    $("#semi_exp_monthly").html(formatNumber(semi_monthly,2,',','.','$ '));
    $("#totalNon").html(formatNumber(totalNon,2,',','.','$ '));
    $("#totalNon2").html(formatNumber(totalNon,2,',','.','$ '));
    
    gNon = totalNon.toFixed(2);
    gTotalExpenses = calcTotal();
    $("#gTotalExpenses").html(formatNumber(gTotalExpenses,2,',','.','$ '));
}
function calcTotal()
{
    return parseFloat(gExpenses) + parseFloat(gNon) + parseFloat(gOther);
}
function filterNum(str) 
{
    re = /^\$|,/g;
    // remove "$" and ","
    return str.replace(re, "");
}
function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2)
{
    eval(defaults(arguments,null,2,',','.','','','-',''));
    
    var x = Math.round(num * Math.pow(10,dec));
    if (x >= 0) n1=n2='';
    var y = (''+Math.abs(x)).split('');
    var z = y.length - dec;
    if (z<0) z--;
    for(var i = z; i < 0; i++) y.unshift('0');
    y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0');
    while (z > 3)
    {
        z-=3; y.splice(z,0,thou);
    }
    var r = curr1+n1+y.join('')+n2+curr2;
    return r;
}
function IsEmpty(aTextField)
{
   if ((aTextField.val()==null) || (aTextField.val().length==0)) {
      return true;
   }
   else { return false; }
}
function defaults(passed)
{
    var pattern = /function[^(]*\(([^)]*)\)/;
    var args = passed.callee.toString().match(pattern)[1].split(/\s*,\s*/);
    var str = "", i = 1;
    for ( ; i < arguments.length; i++)
    {
        if (typeof passed[i-1] == "undefined")
        {
            str += args[i-1] + "=" + fix(arguments[i]) + ";";
        }
    }
    return str;
    function fix(x)
    {
         if (typeof x == "string") return "'" + x.replace(/\'/g, "\\'") + "'";
        return x;
    }
 }
/* Script to enable hover function */
   $().ready(function() {
          $('.hoverable').hover(
               function() {
                   $(this).addClass('hovered');
          }, function() {
                $(this).removeClass('hovered');
          }
       );
   });
</script>