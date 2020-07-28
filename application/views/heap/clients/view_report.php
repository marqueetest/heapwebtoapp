<style>
body {
  background-color: #f2f6f6 !important;
}
.border_rightgrey {
    font-size: 14px;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    line-height: 1;
}
.divtableblack {
    background-color: #2B333E;
    color: white;
    border-right: #D6CEC3 solid 1px;
    font-weight: bold !important;
    padding: 13px 9px 13px 9px !important;
}
.embed-responsive .embed-responsive-item, .embed-responsive iframe, .embed-responsive embed, .embed-responsive object, .embed-responsive video {
    position: absolute;
    top: 0;
    bottom: 0;
    left: .6%  !important;
    width: 98.7% !important;
    height: 100%;
    border: 0;
}
.embed-responsive-4by3 {
    padding-bottom: 38% !important;
}
tfoot.sub_total {
    font-weight: bold;
    background-color: #ddd;
    border-right: #D6CEC3 solid 1px !important;
}
.td_padding{
    padding-left: 5px !important;
}
.sub_th {
    background-color: gray !important;
    color: white !important;
    font-weight: 500 !important;
}
.newtd_left{
    background-color: gray !important;
    color: white !important;

}
.td_reportleft {
    width: 75%;
    text-transform: uppercase !important;
    border-right: #D6CEC3 solid 1px !important;
}
.td_reportright {
    width: 25%;
    background-color: white !important;
    border-right: 1px solid #D6CEC3;
}
.text_reportright {
    /* padding-left: 30px !important; */
    text-align: center !important;
}
tfoot.sub_total td {
    border: #D6CEC3 solid 1px !important;
}
.fa {
    padding-left: 5px !important;
}
h3.saved_reports {
    color: #2B333E;
    font-weight: bold;
}
</style>
<!-- MAIN -->
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<!--<div class="panel-heading">
					<h3 class="panel-title"></h3>
					<p class="panel-subtitle"></p>
				</div>-->
				<div class="panel-body">

					<?php
					if( $this->session->flashdata("success") ) {
						?>
						<div class="alert alert-success">
							<?php echo $this->session->flashdata("success") ?>
						</div>
						<?php
					}
					?>

					<div class="row">
						<div class="col-md-12">

							<div class="col-md-12">
								<a href="<?php echo base_url() ?>download-report/<?php echo $client_id ?>/<?php echo $report_id ?>" class="btn btn-primary pull-right" target="_blank"><i class="fa fa-download"></i>&nbsp;Download PDF</a>

								<a href="<?php echo base_url() ?>heap-clients" class="btn btn-primary pull-right">Heap Clients</a>

								<a href="<?php echo base_url() ?>" class="btn btn-primary pull-right">Dashboard</a>
							</div>

						</div>
					</div>

					<div class="col-md-12">
						<hr/>
					</div>

					<div class="col-md-12">
					    <p>The following report will illustrate how much sooner you will be able to pay off your home mortgage debt using H.E.A.P.&#8482;. The ultimate conclusions outlined in this report are based on the information you provided to your H.E.A.P.&#8482; advisor. To the extent you did not provide accurate information to your H.E.A.P.&#8482; advisor, that can positively or negatively affect the conclusions in this report. Based on the numbers provided, you can save $<?php echo number_format($interest_saved,2); ?> in interest over the life of your mortgage.</p>
					</div>

					<div class="row">
				        <div class="col-md-12">
				            <div class="col-md-4">
				               <h3 class="saved_reports">Current Laibilities</h3>
				            </div>
				            <div class="col-md-8"></div>
				            <div class="col-md-12">
				               	<div class="table-responsive" data-example-id="bordered-table">
					                <table class="table table-responsive" width="100%">
					                    <thead class="">
					                        <tr>
					                            <th width="50%" height="29" class="divtableblack">Existing Debt (to be paid off)</th>
					                            <th width="25%" height="29" class="divtableblack">BALANCE</th>
					                            <th width="25%" height="29" class="divtableblack">MONTHLY PAYMENT</th>
					                        </tr>

					                         <?php $exp_total_balance = $rep['mortgage_balance']; ?>
					                         <?php $exp_total_payments = $rep['mortgage_payment']; ?>
					                         <?php $rowColor = 'rowColor2'; ?>
					                    </thead>
					                    <tr>
			                                <td class="border_rightgrey <?php echo $rowColor; ?>" width="10%" height="29" scope="row">Current Mortgage</td>
			                                <td class="border_rightgrey <?php echo $rowColor; ?>"  width="25%" height="29">&nbsp;$ <?php echo number_format($rep['mortgage_balance'],2); ?></td>
			                                <td class="border_rightgrey <?php echo $rowColor; ?>"  width="25%" height="29">&nbsp;$ <?php echo number_format($rep['mortgage_payment'],2); ?></td>
					                    </tr>

					                    <?php $cl_count = count($exp['expense']); ?>
					                    <?php
					                    foreach($exp['expense'] as  $e_value) {
					                        if(empty($e_value)) $cl_count--;
					                    }
					                    ?>
					                    <?php for($r = 0; $r < $cl_count; $r++): ?>
					                    	<?php $rowColor = $rowColor == 'rowColor2' ? 'rowColor1' : 'rowColor2'; ?>

					                       <tr>
					                            <td align="left" class="<?php echo $rowColor; ?> <?php if($r == $cl_count - 1) echo 'borderBottom'; ?>">&nbsp;<?php echo $exp['expense'][$r]; ?></td>
					                            <td align="right" class="<?php echo $rowColor; ?> <?php if($r == $cl_count - 1) echo 'borderBottom'; ?>">&nbsp;<?php echo $exp['balance'][$r]; ?></td>
					                            <td align="right" class="<?php echo $rowColor; ?> <?php if($r == $cl_count - 1) echo 'borderBottom'; ?>">&nbsp;<?php echo $exp['payments'][$r]; ?></td>
					                        </tr>
					                        <?php $exp_total_balance += floatval(preg_replace( "/[\$\s,]/", '',$exp['balance'][$r])); ?>
					                        <?php $exp_total_payments += floatval(preg_replace( "/[\$\s,]/", '',$exp['payments'][$r])); ?>

					                    <?php endfor; ?>

						                <tfoot class="sub_total">
						                    <tr>
						                      <td><span>Total Monthly Fixed Expenses:</span></td>
						                      <td><span class="td_padding">$ <?php echo number_format($exp_total_balance,2); ?></span></td>
						                      <td><span class="td_padding">$ <?php echo number_format($exp_total_payments,2); ?></span></td>
						                    </tr>
						                </tfoot>
					                </table>
				                </div>
				            </div>
				         </div>
				    </div>

     				<div class="row">
        				<div class="col-md-12">
				            <div class="col-md-4">
				               <h3 class="saved_reports">Net Income</h3>
				            </div>
				            <div class="col-md-8"></div>
					        <div class="col-md-12">
					            <div class="table-responsive" data-example-id="bordered-table">
					                <table class="table table-responsive" width="100%">
					                    <thead class="">
					                        <tr>
					                            <th width="50%" height="29" class="divtableblack">EMPLOYER</th>
					                            <th width="25%" height="29" class="divtableblack">INTERNAL</th>
					                            <th width="25%" height="29" class="divtableblack">AMOUNT</th>
					                        </tr>
					                    </thead>
					                    <tr>
			                                <th class="border_rightgrey" width="10%" height="29" scope="row">
			                                    <?php if($rep['income1'] > 0): ?>
			                                  		Income 1
			                                  	<?php endif; ?></th>
			                                <td class="border_rightgrey"  width="25%" height="29">
			                                    <?php if($rep['income1'] > 0): ?>
			                                  		<?php echo ucwords($rep['income1_interval']); ?>
			                                  	<?php endif; ?>
			                                </td>
			                                <td class="border_rightgrey"  width="25%" height="29">
					                            <?php if($rep['income1'] > 0): ?>
					                            	$ <?php echo number_format($rep['income1']); ?>
					                            <?php endif; ?>
					                        </td>
					                    </tr>
					                    <tr>
			                                <th class="border_rightgrey rowColor1 " width="10%" height="29" scope="row">
			                                	<?php if($rep['income2'] > 0): ?>
			                                  		Income 2
			                                  	<?php endif; ?>
			                                </th>
			                                <td class="border_rightgrey rowColor1"  width="25%" height="29">
			                                    <?php if($rep['income2'] > 0): ?>
			                                  		<?php echo ucwords($rep['income2_interval']); ?>
			                                  	<?php endif; ?>
			                                </td>
			                                <td class="border_rightgrey rowColor1"  width="25%" height="29">
			                                    <?php if($rep['income2'] > 0): ?>
			                                  		$ <?php echo number_format($rep['income2']); ?>
			                                  	<?php endif; ?>
			                                </td>
					                    </tr>
					                 	<tfoot class="sub_total">
					                    	<tr>
					                       		<td></td>
					                      		<td><span>Total Monthly Net Income:</span></td>
					                       		<?php $income_total = $rep['income1'] + $rep['income2']; ?>
					                      		<td><span class="td_padding">$ <?php echo number_format($income_total); ?></span></td>
					                    	</tr>
					                	</tfoot>
					                </table>
					            </div>
					        </div>
         				</div>
    				</div>

				    <div class="row">
				        <div class="col-md-12">
				            <div class="col-md-8">
				               <h3 class="saved_reports title_table">"Surplus" Calculation (Keeping Current Debt Structure)</h3>
				            </div>
				            <div class="col-md-4">
				            </div>
				            <div class="col-md-12">
				               	<div class="table-responsive" data-example-id="bordered-table">
					                <table class="table table-responsive report_table" width="100%">
					                    <?php if($display_current_term): ?>
					                        <tr>
					                            <th nowrap="nowrap">&nbsp;</th>
					                            <th>Original Surplus</th>
					                            <?php if($display_current_term): ?>
					                            	<th>Current Surplus (Term <?php echo $term; ?>)</th>
					                            <?php endif; ?>
					                        </tr>
					                    <?php endif; ?>
					                  	<table class="table" width="100%">
					                     	<tbody
					                      		<tr>
					                         		<th height="29"  class="divtableblack td_reportleft newtd_left" nowrap="nowrap">Total Monthly Net Income</th>
					                         		<td  height="29"   class="td_reportright text_reportright"> $ <?php echo number_format($income_total,2); ?></td>
					                         		<?php if($display_current_term): ?>
					                             		<td  height="29"   class="td_reportright text_reportright"> $ <?php echo number_format($term_total_income,2); ?></td>
					                         		<?php endif; ?>
					                      		</tr>
					                        	<?php $total_monthly_fixed_expenses = $exp_total_payments; ?>
					                        	<tr>
					                           		<th height="29"  class="divtableblack td_reportleft newtd_left" nowrap="nowrap">Total Monthly Fixed Expenses</th>
					                              	<td height="29"  class="td_reportright text_reportright">-$ <?php echo number_format($total_monthly_fixed_expenses,2); ?></td>
					                              	<?php if($display_current_term): ?>
					                              		<td height="29"  class="td_reportright text_reportright">-$ <?php echo number_format($term_exp['total_payments'] + $rep['mortgage_payment'],2); ?></td>
					                              	<?php endif; ?>
					                        	</tr>
					                        	<?php $total_monthly_variable_expenses = $other_expenses + $nonmonthly_expenses; ?>
					                       		<tr>
					                           		<td height="29"  class="divtableblack td_reportleft newtd_left" nowrap="nowrap">TOTAL MONTHLY VARIABLE EXPENSES (AS BUDGETED)</td>
					                           		<td height="29"  class="td_reportright text_reportright">-$ <?php echo number_format($total_monthly_variable_expenses,2); ?></td>
					                               	<?php if($display_current_term): ?>
					                               		<td class="td_reportright text_reportright">-$ <?php echo number_format($term_exp['total_other_expenses'] + $term_exp['nonmonthly_expenses'],2); ?></td>
					                              	<?php endif; ?>
					                       		</tr>
					                     	</tbody>
					                     	<tfoot class="sub_total">
					                        	<tr>
					                          		<td><span class="td_padding td_reportleft" style="padding-left:69% !important;">Monthly "Surplus"</td>
					                           		<?php $monthly_surplus_current = $income_total - $exp_total_payments - $other_expenses - $nonmonthly_expenses; ?>
					                          		<td><span class="td_padding td_reportleft" style="padding-left: 38% !important;">$ <?php echo number_format($monthly_surplus_current,2); ?></td>

					                          		<?php if($display_current_term): ?>
					                          			<span class="text_reportright"><strong>$ <?php echo number_format($term_total_income - $term_exp['total_payments'] - $rep['mortgage_payment'] - $term_exp['total_other_expenses'] - $term_exp['nonmonthly_expenses'],2); ?></strong></span>
					            					<?php endif; ?>
					                        	</tr>
					                     	</tfoot>
					                  	</table>
					                </table>
				            	</div>
				        	</div>
				        </div>
				    </div>

    				<?php //if($fixed_expenses_payment_toHeloc > 0): ?>

				    <div class="row">
				    	<div class="col-md-3"></div>
				    	<div class="col-md-6"><span>(Money that can be allocated to pay down mortgage debt)	</span></div>
				        <div class="col-md-3"></div>
				    </div>
				    <div class="col-md-12">
				    	<center class="text_word bottom_text">
				    		With H.E.A.P.™, your mortgage debt (and other debt if added to the program) will be paid off without adjusting your monthly living expenses as budgeted in 0.17 years.
				        </center>
				    </div>

				    <div class="row">
				        <div class="col-md-12">
				            <div class="col-md-8">
				               <h3 class="saved_reports">Proposed Liability Structure</h3>
				            </div>
				            <div class="col-md-4">
				            </div>
				            <div class="col-md-12">
				               	<div class="table-responsive" data-example-id="bordered-table">
				                	<table class="table table-responsive" width="100%">
				                    	<thead class="">
					                        <tr>
					                            <th width="25%" height="29" class="divtableblack"></th>
					                            <th width="25%" height="29" class="divtableblack">1ST TERM BALANCE</th>
					                            <th width="25%" height="29" class="divtableblack">1ST TERM PAYMENT</th>
					                            <th width="25%" height="29" class="divtableblack">PAYMENT</th>
					                        </tr>

				                         	<?php
				                         	if($heloc_addto_consolidated == 'yes') {
				                                $purposed_mortgage_1st_term_balance = $rep['mortgage_balance'] - $rep['heloc_amount'];
				                                $heap_acct_1st_term_balance = $rep['heloc_amount'] + $fixed_expenses_toHeloc;

												$heap_current_amount = $rep['heloc_amount'] + $fixed_expenses_toHeloc;
				                            } else {
				                                $purposed_mortgage_1st_term_balance = $rep['mortgage_balance'] - $rep['heloc_amount'] + $fixed_expenses_toHeloc;
				                                $heap_acct_1st_term_balance = $rep['heloc_amount'];

												if($fixed_expenses_toHeloc > $rep['heloc_amount'])
													$heap_current_amount = $fixed_expenses_toHeloc;
												else
													$heap_current_amount = $rep['heloc_amount'];
				                            }
				                          	?>
				                    	</thead>
				                    	<tr>
				                            <th class="border_rightgrey" width="10%" height="29" scope="row">Purposed Mortgage</th>
				                            <td class="border_rightgrey"  width="25%" height="29">$ <?php echo number_format($purposed_mortgage_1st_term_balance,2); ?></td>
				                            <td class="border_rightgrey"  width="25%" height="29">$ <?php echo number_format($rep['mortgage_payment'],2); ?></td>
				                            <td class="border_rightgrey"  width="25%" height="29">$ <?php echo number_format($rep['mortgage_payment'],2); ?></td>
				                    	</tr>

				                     	<tr>
				                            <th class="border_rightgrey" width="10%" height="29" scope="row">H.E.A.P.™ Account</th>
				                            <td class="border_rightgrey rowColor1 borderBottom"  width="25%" height="29">$ <?php echo number_format($heap_acct_1st_term_balance,2); ?></td>
				                            <td class="border_rightgrey rowColor1 borderBottom"  width="25%" height="29">$ <?php echo number_format($avg_heloc_interest_paid_first_year,2); ?></td>
				                            <td class="border_rightgrey rowColor1 borderBottom"  width="25%" height="29">$ <?php echo number_format($avg_heloc_interest_paid_2,2); ?></td>
				                    	</tr>

				                     	<?php
				                     	$proposed_payment_total = $rep['mortgage_payment'] + $avg_heloc_interest_paid_first_year;
				                        $proposed_balance_total = $rep['mortgage_balance'] + $fixed_expenses_toHeloc;

				                        $proposed_payment_total2 = $rep['mortgage_payment'] + $avg_heloc_interest_paid_2;
				                        $proposed_balance_total2 = $rep['mortgage_balance'];

				                        if($fixed_expenses_payment_toHeloc > 0) {
				                            $proposed_payment_savings = $monthly_surplus_with_heap - $monthly_surplus_current - $avg_heloc_interest_paid_first_year;
											$proposed_payment_savings2 = $monthly_surplus_with_heap - $monthly_surplus_current - $avg_heloc_interest_paid_2;
										} else {
				                            $proposed_payment_savings = $total_monthly_fixed_expenses + $total_monthly_variable_expenses - $proposed_payment_total;
											$proposed_payment_savings2 = $total_monthly_fixed_expenses + $total_monthly_variable_expenses - $proposed_payment_total2;
										}
				                        ?>
					                    <tfoot class="sub_total">
					                        <tr>
					                          <td><span>Total:</span></td>
					                          <td><span class="td_padding">$ <?php echo number_format($proposed_balance_total,2); ?></td>
					                          <td><span class="td_padding">$ <?php echo number_format($proposed_payment_total,2); ?></td>
					                          <td><span class="td_padding">$ <?php echo number_format($proposed_payment_total2,2); ?></td>
					                        </tr>
					                    </tfoot>
				                	</table>
				                </div>
				            </div>
				        </div>

				        <?php if($fixed_expenses_payment_toHeloc > 0): ?>
			        		<div class="col-md-12">
			        			<div class="col-md-4"></div>
			        			<div class="col-md-8">
			        				<div class="pull-right">
				        				<span class="borderBottom"><strong>Monthly Payment Savings:</strong></span>
				        				<strong>$ <?php echo number_format($proposed_payment_savings,2); ?></strong>
				        				<strong>$ <?php echo number_format($proposed_payment_savings2,2); ?></strong>
			        				</div>
			        			</div>
			        		</div>
				        <?php endif; ?>
				    </div>

			     	<div class="row">
			        	<div class="col-md-12">
			               <h3 class="saved_reports "><center class="text_word ">Amortization Comparison</center></h3>
			            </div>
			        </div>

				    <div class="row">
				        <div class="col-md-6">
				            <div class="col-md-4">
				               <span class="saved_reports"></span>
				            </div>
				            <div class="col-md-4">
				            </div>
				            <div class="col-md-12">
				               	<div class="table-responsive " data-example-id="bordered-table">
				                	<table class="table table-responsive table_margin" width="100%">
					                    <thead class="">
					                        <tr>
					                            <th width="100%" height="29" class="divtableblack title_table">CURRENT MORTGAGE</th>

					                        </tr>
					                    </thead>
				                	</table>
				                	<table class="table table-responsive table_margin" width="100%">
				                    	<tr>
				                            <th class="border_rightgrey" width="50%" height="29" scope="row">Current Amount</th>
				                            <td class="border_rightgrey"  width="50%" height="29">$<?php  echo number_format($rep['mortgage_balance'],2); ?></td>
				                    	</tr>
				                     	<tr>
				                            <th class="border_rightgrey" width="50%" height="29" scope="row">Interest Rate</th>
				                            <td class="border_rightgrey"  width="50%" height="29"><?php echo $rep['mortgage_rate']; ?>%</td>
				                    	</tr>
				                     	<tr>
				                            <th class="border_rightgrey" width="50%" height="29" scope="row">Remaining Term</th>
				                            <td class="border_rightgrey"  width="50%" height="29"><?php echo $rep['mortgage_term']; ?></td>
				                    	</tr>
				                     	<tr>
				                            <th class="border_rightgrey" width="50%" height="29" scope="row">Interest Payment</th>
				                            <td class="border_rightgrey rowColor1"  width="50%" height="29"><?php $interest_payment = $rep['mortgage_balance'] * $rep['mortgage_rate'] / 100 / 12; ?>$<?php echo number_format($interest_payment,2); ?></td>

				                    	</tr>
				                     	<tr>
				                            <?php $principal_payment = $rep['mortgage_payment'] - $interest_payment; ?>
				                            <th class="border_rightgrey" width="50%" height="29" scope="row">Principal Payment</th>
				                            <td class="border_rightgrey"  width="50%" height="29">$<?php echo number_format($principal_payment,2); ?></td>
				                    	</tr>

				                     	<tr>
				                            <th class="border_rightgrey" width="50%" height="29" scope="row">Escrow Amount</th>
				                            <td class="border_rightgrey"  width="50%" height="29">&nbsp;</td>
				                    	</tr>

				                    	<tfoot class="sub_total">
					                     	<tr>
					                          <td class="td_padding">Total Payment</td>
					                          <td class="td_padding">$<?php echo number_format($rep['mortgage_payment'],2); ?></td>
					                    	</tr>
				                    	</tfoot>
				                	</table>
				                   	<table class="table table-responsive table_margin" width="100%">
					                    <thead class="">
					                        <tr>
					                            <th width="100%" height="29" class="divtableblack">CURRENT DEBT AMORTIZATION</th>
					                        </tr>
					                    </thead>
				                	</table>
				                   	<table class="table table-responsive table_margin" width="100%">
				                    	<tr>
			                                <th class="border_rightgrey sub_th" width="25%" height="29" scope="row">Year</th>
			                                <td class="border_rightgrey sub_th"  width="25%" height="29">Total MTG Debt</td>
			                                <th class="border_rightgrey sub_th" width="25%" height="29" scope="row">Total Debt Paid</th>
			                                <td class="border_rightgrey sub_th"  width="25%" height="29">Total Interest</td>
				                    	</tr>
				                       	<?php foreach($mort_summary as $myear => $mort): ?>
				                            <?php $rowColor = $rowColor == 'rowColor2' ? 'rowColor1' : 'rowColor2'; ?>
				                        	<tr>
				                            	<th class="border_rightgrey <?php echo $rowColor; ?> <?php if($myear == $last_year_mortgage) echo 'borderBottom'; ?>" width="25%" height="29" scope="row"><?php echo $myear; ?></th>
				                                <td class="border_rightgrey <?php echo $rowColor; ?> <?php if($myear == $last_year_mortgage) echo 'borderBottom'; ?>" width="25%" height="29" scope="row">$<?php echo number_format($mort['principle_balance'],2); ?></td>
				                                <th class="border_rightgrey <?php echo $rowColor; ?> <?php if($myear == $last_year_mortgage) echo 'borderBottom';?>" width="25%" height="29" scope="row">&nbsp;$<?php echo number_format($mort['principle_paid'],2); ?></th>
				                                <td class="border_rightgrey <?php echo $rowColor; ?> <?php if($myear == $last_year_mortgage) echo 'borderBottom'; ?>"  width="25%" height="29">$<?php echo number_format($mort['total_interest'],2); ?></td>
				                    		</tr>
				                    	<?php endforeach;?>
				                   	</table>
				                </div>
				            </div>
				        </div>

				       	<div class="col-md-6">
				            <div class="col-md-4">
				               <span class="saved_reports"></span>
				            </div>
				            <div class="col-md-4">
				            </div>
				            <div class="col-md-12">
				               	<div class="table-responsive " data-example-id="bordered-table">
					                <table class="table table-responsive table_margin" width="100%">
					                    <thead class="">
					                        <tr>
					                            <th width="100%" height="29" class="divtableblack">H.E.A.P.™</th>
					                        </tr>
					                    </thead>
					                </table>
				                	<table class="table table-responsive table_margin" width="100%">
				                    	<tr>
				                            <th class="border_rightgrey" width="50%" height="29" scope="row">Current Amount	</th>
				                            <td class="border_rightgrey"  width="50%" height="29">$<?php echo number_format($heap_current_amount,2); ?></td>
				                    	</tr>
				                     	<tr>
				                            <th class="border_rightgrey" width="50%" height="29" scope="row">Note Rate</th>
				                            <td class="border_rightgrey rowColor1"  width="50%" height="29">$<?php echo $rep['heloc_rate']; ?>%</td>
				                    	</tr>
				                    	<?php $available_mma_amount = $rep['est_market_value'] - $rep['mortgage_balance'] - $rep['heloc_amount'] - $fixed_expenses_toHeloc; ?>
				                     	<tr>
				                            <th class="border_rightgrey" width="50%" height="29" scope="row">Available Amount</th>
				                            <td class="border_rightgrey"  width="50%" height="29">$<?php echo number_format($available_mma_amount,2); ?></td>
				                    	</tr>
				                     	<tr>
				                            <th class="border_rightgrey" width="50%" height="29" scope="row">&nbsp;</th>
				                            <td class="border_rightgrey rowColor1"  width="50%" height="29">&nbsp;</td>
				                    	</tr>
				                     	<tr>
				                            <th class="border_rightgrey" width="50%" height="29" scope="row">&nbsp;</th>
				                            <td class="border_rightgrey"  width="50%" height="29">&nbsp;</td>
				                    	</tr>
				                     	<tr>
				                            <th class="border_rightgrey" width="50%" height="29" scope="row">Program Start Date</th>
				                            <td class="border_rightgrey rowColor1"  width="50%" height="29">&nbsp;</td>
				                    	</tr>
				                     	<tr>
				                            <th class="border_rightgrey" width="50%" height="29" scope="row">Monthly Expenses</th>
				                            <td class="border_rightgrey"  width="50%" height="29"><?php echo number_format($monthly_expenses,2); ?></td>
				                    	</tr>

				                	</table>

				                   	<table class="table table-responsive table_margin" width="100%">
				                    	<thead class="">
				                        	<tr>
				                            	<th width="100%" height="29" class="divtableblack">H.E.A.P.™ Amortization</th>
				                        	</tr>
				                    	</thead>
				                	</table>

				                   	<table class="table table-responsive table_margin" width="100%">
				                    	<thead class="table_heading">
				                            <tr>
				                                <th class="border_rightgrey sub_th" width="25%" height="29">Year</th>
				                                <th class="border_rightgrey sub_th"  width="25%" height="29">Total MTG Debt</th>
				                                <th class="border_rightgrey sub_th" width="25%" height="29" scope="row">Total Debt Paid</th>
				                                <th class="border_rightgrey sub_th"  width="25%" height="29">Total Interest</th>
				                            </tr>
				                     	</thead>

				                       	<?php $rowColor = null; ?>
				                        <?php for($y = 1; $y <= ceil($term_remaining/12); $y++): ?>
				                            <?php $rowColor = $rowColor == 'rowColor2' ? 'rowColor1' : 'rowColor2'; ?>
				                            <?php
							                if(isset($summary[$y]) && $summary[$y]['mort_balance'] <= '0') {
							                    $total_mtg_debt_comparison = '0';
							                    $total_debt_paid_comparison = $rep['mortgage_balance'] + $fixed_expenses_toHeloc;
							                    $rigged = true;
							                } else if( isset($summary[$y]) ) {
							                    //$total_mtg_debt_comparison = $rep['mortgage_balance'] - $summary[$y]['total_debt1'];
							                    $total_mtg_debt_comparison = isset($summary[$y]['mort_balance_calc']) ? $summary[$y]['mort_balance_calc'] : 0;
							                    $total_debt_paid_comparison = $summary[$y]['total_debt1'];
							                    $rigged = false;
							                } else {
							                	$total_mtg_debt_comparison = 0;
							                    $total_debt_paid_comparison = 0;
							                    $rigged = false;
							                }

							                if($rigged && $summary[$y]['mort_balance'] != '0') {
							                    $total_mtg_debt_comparison = '0';
							                    $total_debt_paid_comparison = '0';
							                }

				                			if($total_mtg_debt_comparison < 0)
				                				$total_mtg_debt_comparison = 0;
				                			?>

				                        	<tr>
				                                <th class="border_rightgrey <?php echo $rowColor; ?> <?php if($y == ceil($term_remaining/12)) echo 'borderBottom'; ?>" width="25%" height="29" scope="row"><?php echo $y; ?></th>
				                                <td class="border_rightgrey <?php echo $rowColor; ?> <?php if($y == ceil($term_remaining/12)) echo 'borderBottom'; ?>"  width="25%" height="29">$<?php echo number_format($total_mtg_debt_comparison,2); ?></td>
				                                <th class="border_rightgrey <?php echo $rowColor; ?> <?php if($y == ceil($term_remaining/12)) echo 'borderBottom'; ?>" width="25%" height="29" scope="row">$<?php echo number_format($total_debt_paid_comparison,2); ?></th>
				                                <td class="border_rightgrey <?php echo $rowColor; ?> <?php if($y == ceil($term_remaining/12)) echo 'borderBottom'; ?>"  width="25%" height="29">$<?php echo isset($summary[$y]['total_interest']) ? number_format($summary[$y]['total_interest'],2) : number_format(0,2); ?></td>
				                    		</tr>
				                        <?php endfor; ?>
				                   	</table>
				                </div>
				            </div>
				        </div>
				    </div>

				    <div class="row text_word">
				        <div class="col-md-12">
				            <div class="col-md-4">
				               <h3 class="saved_reports">Savings Summary</h3>
				            </div>
				            <div class="col-md-8">
				            </div>
				            <div class="col-md-12">
				               	<div class="table-responsive" data-example-id="bordered-table">
				                	<table class="table table-responsive" width="100%">
				                    	<thead class="">
					                        <tr>
					                            <th width="10%" height="29" class="divtableblack">FINAL</th>
					                            <th width="10%" height="29" class="divtableblack">MONTHS PAID</th>
					                            <th width="10%" height="29" class="divtableblack">MONTHS SAVED</th>
					                            <th width="10%" height="29" class="divtableblack">YEAR PAID</th>
					                            <th width="10%" height="29" class="divtableblack">YEAR SAVED</th>
					                            <th width="10%" height="29" class="divtableblack">INTEREST PAID</th>
					                            <th width="10%" height="29" class="divtableblack">INTEREST SAVED</th>
					                        </tr>
				                    	</thead>
				                    	<tr>
			                                <th class="border_rightgrey borderBottom" width="14.28%" height="29" scope="row"><?php echo date("n/Y",strtotime("+ $heloc_total_months months")); ?></th>
			                                <td class="border_rightgrey borderBottom"  width="14.28%" height="29"><?php echo $heloc_total_months; ?></td>
			                                <td class="border_rightgrey borderBottom"  width="14.28%" height="29"><?php echo $term_remaining - $heloc_total_months; ?></td>
			                                 <td class="border_rightgrey borderBottom"  width="14.28%" height="29"><?php echo number_format($heloc_total_months/12,2); ?></td>
			                                <td class="border_rightgrey borderBottom" width="14.28%"  height="29"><?php echo number_format(($term_remaining - $heloc_total_months)/12,2); ?></td>
			                                <td class="border_rightgrey borderBottom"  width="14.28%" height="29">$<?php echo number_format($total_interest_paid,2); ?></td>
			                                <td class="border_rightgrey borderBottom"  width="14.28%" height="29">$<?php echo number_format($interest_saved,2); ?></td>
				                    	</tr>
				                	</table>
				                </div>
				            </div>
				        </div>
				    </div>

    				<div class="row">

					    <div class="col-md-12 graph_boot">
					        <div class=" embed-responsive embed-responsive-4by3">
					        	<div class="graph_center">

					        		<?php $this->load->view('heap/clients/report_graph'); ?>

					        		<?php //require_once("print_graph_swf_ali.php") ?><?php /*?> <? echo InsertChart ( "/php-bin/phpswf_charts/charts.swf", "/php-bin/phpswf_charts/charts_library", "print_graph_swf.php?id={$client_id}&r={$report_id}&uniqueID=".uniqid(rand(),true), 700, 350, "eeeeee" ); ?><?php */?>

					        	</div>
					        </div>
					    </div>

        				<div class="col-md-3 col-xs-3 graph_boot"></div>

        				<div class="col-md-6 col-xs-6 graph_boot">
					        <div class="down_graph">
					            <div class="graph_low_maroon">&nbsp;</div> Standard Mortgage Schedule
					        </div>
					        <div  class="down_graph">
					            <div class="graph_low_green">&nbsp;</div>H.E.A.P. Schedule
					        </div>
             				<div  class="down_graph">
            					<div class="graph_low_orange">&nbsp;</div>HELOC
        					</div>
        				</div>

        				<div class="col-md-3 col-xs-3 graph_boot"></div>

    				</div>


			        <div class="col-md-12 bottom_text">
			    		<p>With the Home Equity Acceleration Plan (H.E.A.P.&#8482;), as budgeted, you will pay off your "home mortgage" debt in <?php echo number_format($heloc_total_months/12,2); ?> years.</p>
			        </div>

    				<div class="col-md-12 bottom_text">
        				<p>This will save you $<?php echo number_format($interest_saved,2); ?>  in mortgage interest over the life of the plan.</p>
        			</div>

				    <div class="col-md-12 bottom_text">
				        <p>*The H.E.A.P.&#8482; numbers calculated for this report are based on the inputs given to your H.E.A.P.&#8482; advisor. It is understood that you will be able to pay off your mortgage debt sooner if you earn more income and/or decrease your variable expenses over the life of the plan. It is understood that it will take longer to pay off your mortgage debt if you decrease your income and/or increase your variable expenses over the life of the plan.</p>
				    </div>

    				<div class="col-md-12 bottom_text">
    					If you need to re-run these numbers due to a substantial change in your income or expenses, <br />please contact <?php  echo $adviser['first_name']." ".$adviser['last_name']; ?> at <?php  echo !empty($adviser['phone']) ? $adviser['phone'] : $adviser['email_address']; ?>
                        <!-- <?php  echo !empty($adviser['phone']) ? $adviser['phone'] : "________________________"; ?>-->

					    <strong>
						    <?php
							if ( isset($adviser11['email_footer']) && $adviser11['email_footer'] != '' )
								echo $adviser11['email_footer'];
							?>
						</strong>
    				</div>

    				<?php if($debug): ?>
        				<div width="100%" border="0" cellspacing="0" cellpadding="5">
    						<div>
        						<div align="left" style="font-size: 11px;font-family: 'Courier New', Courier, monospace;">
        							<b>Raw data from CalculatorApp.jar</b><br />
									MortgagePrincipal MortgageTerm MortgageInterestRate HelocAmount HelocStartTerm Salary BillAmount HelocInterestRate BimonthlySalary(True or False) FirstSalaryDay SecondSalaryDay(0 if not bimontly) BillPaymentDay MortgagePaymentDay InterestOnly(True or False) ConsolidatedDebt InputPayments(True or False) AddDebtToHeloc(True or False) PaymentFile ClientId IterationNo<br />
									<br /><?php echo $rep['java_calc_string']; ?><br />
									<?php foreach($calc_file as $line): ?>
										<?php echo $line."<br>\n"; ?>
									<?php endforeach; ?>
        						</div>
            				</div>
    					</div>
    				<?php endif; ?>

				</div>
			</div>
			<!-- END OVERVIEW -->
		</div>
	</div>
	<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->

