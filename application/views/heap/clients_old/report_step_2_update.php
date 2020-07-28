<style type="text/css">
    .panel .table > thead > tr > th,
    .panel .table > tbody > tr > th,
    .panel .table > tfoot > tr > th,
    .panel .table > thead > tr > td,
    .panel .table > tbody > tr > td,
    .panel .table > tfoot > tr > td,
    .panel .table > thead > tr > td:last-child,
    .panel .table > thead > tr > th:last-child,
    .panel .table > tbody > tr > td:last-child,
    .panel .table > tbody > tr > th:last-child,
    .panel .table > tfoot > tr > td:last-child,
    .panel .table > tfoot > tr > th:last-child,
    .panel .table > thead > tr > td:first-child,
    .panel .table > thead > tr > th:first-child,
    .panel .table > tbody > tr > td:first-child,
    .panel .table > tbody > tr > th:first-child,
    .panel .table > tfoot > tr > td:first-child,
    .panel .table > tfoot > tr > th:first-child {
        border-top: none;
        padding: 0px;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 10px ;
    }
    .client_list {
        font-weight: 600;
        color: white;
        padding: 7px 18px 7px 10px;
    }
    .panel .table > thead > tr > td {
        padding-top: 0;
        padding-bottom: 0;
    }
    .panel .table > thead {
        background: #2B333E;
        color: #FFFFFF;
    }
    .panel .table > tbody > tr > td {
        background: #eee;
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
                    <div class="row">
                        <div class="col-sm-12 col-lg-5">
                            <h3 class="panel-title">
                                <span  class="upr_head ">
                                    <span>(Updating Term <?php if($term < 1): ?>?????<?php else: ?><?php echo $term; ?><?php endif; ?>)</span>
                                    (<span class="new_head upr_head">NEW</span>)
                                </span>
                            </h3>
                        </div>

                        <div class="col-sm-12 col-lg-7">

                            <a href="<?php echo base_url() ?>heap-clients" class="btn btn-primary pull-right">Heap Clients</a>

                            <a href="#" class="btn btn-primary pull-right" onClick="window.history.go(-1); return false;">Back to Step1</a>
                        </div>
                    </div>

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

					<form id="form1" name="form1" method="post" runat="vdaemon">

						<input name="id" type="hidden" id="id" value="<?php echo $client_id; ?>">
						<input name="r" type="hidden" id="r" value="<?php echo $report_id; ?>">
						<input name="t" type="hidden" id="t" value="<?php echo $term; ?>">

						<table class="table">
                            <thead class="client_list">
                                <tr>
                                    <td class="text-left" colspan="4">
                                        <h4>Income&nbsp;&nbsp;(per month)</h4>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Income 1:
                                        <br><strong>$ <?php echo $POST['income1']; ?></strong>
                                    </td>
                                    <td>Income 2:
                                        <br><strong>$ <?php echo $POST['income2']; ?></strong>
                                    </td>
                                    <td>Total Income:
                                        <br><strong>$ <?php echo $POST['total_income']; ?></strong>
                                    </td>

                                </tr>
                                <tr>
                                    <td>Semi-monthly:
                                        <br><strong> <?php echo isset($POST['income_bimonthly_1']) && $POST['income_bimonthly_1'] == 'true' ? 'Yes' : 'No'; ?></strong>
                                    </td>
                                    <td>Semi-monthly:
                                        <br> <strong> <?php echo isset($POST['income_bimonthly_2']) && $POST['income_bimonthly_2'] == 'true' ? 'Yes' : 'No'; ?></strong>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table">
                            <thead class="client_list">
                                <tr>
                                    <td colspan="4">
                                        <h4>Real Estate</h4>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Estimated Market Value
                                        <br><strong>$ <?php echo number_format($POST['est_market_value'],2); ?></strong> </td>
                                    <td>Total Original Mortgage
                                        <br><strong>$ <?php echo number_format($POST['total_original_mortgage'],2); ?></strong>
                                    </td>
                                    <td>Current Principal Balance
                                        <br><strong>$&nbsp;<span  id='current_principal_balance_value'><?php echo number_format($POST['total_original_mortgage'],2); ?></span></strong>
                                    </td>
                                    <td>Current Equity
                                        <br><strong>$&nbsp;<span  id='current_equity_value'><?php echo number_format($POST['est_market_value'] - $POST['total_original_mortgage'],2); ?></span></strong>
                                    </td>
                                </tr>
                                <tr></tr>
                                <tr>
                                    <td>Mortgage Payment (monthly)
                                        <br><strong>$&nbsp;<span class='style2' id='mortgage_payment_monthly_value'><?php echo number_format($POST['mortgage_payment_monthly'],2); ?></span>&nbsp;</strong>
                                    </td>
                                    <td>Total Original Mortgage Term <strong><br>$ <?php echo $POST['total_original_term_months']; ?> Months </strong>
                                    </td>
                                    <td>Months Remaining in Mortgage Term <strong><br>$ <?php echo $POST['months_remaining_mortgage_term']; ?> Months  </strong>
                                    </td>
                                    <td>Interest Rate(annual)<strong><br>$ <?php echo $POST['interest_rate_annual']; ?> % </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top: 1px solid #ddd!important;">Estimated Total Amount Paid at Current Terms</td>
                                    <td>Current Mortgage Balance </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong id='current_principal_balance_value'><?php echo number_format($POST['total_paid_current_terms'],2); ?></strong>
                                    </td>
                                    <td><strong>$&nbsp;<?php echo $POST['current_mortgage_balance'] != "" ? number_format($POST['current_mortgage_balance'],2) : "0.00"; ?></strong>
                                    </td>
                                    <td></td>
                                    <td>Interest Only: <strong><?php echo isset($POST['interest_only']) && $POST['interest_only'] == 'true' ? "YES" : "No"; ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table">
                            <thead class="client_list">
                                <tr>
                                    <td colspan="2">
                                        <h4>Expenses&nbsp;&nbsp;(monthly)</h4>
                                        <input type="hidden" name="expenses" id="expenses" value="<?php echo $total_monthly_expenses; ?>">
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="50">Expenses: <strong>$ <?php echo number_format($total_original_monthly_expenses,2); ?> </strong>
                                    </td>
                                    <td width="50">Payment Date: <strong><?php echo $POST['expenses_payment_date']; ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table">
                            <thead class="client_list">
                                <tr>
                                    <td colspan="2">
                                        <h4>Mortgage</h4>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="50"><strong>$ <span id='mortgage_payment_value' class='calc_values'><?php echo number_format($POST['mortgage_payment_monthly'],2); ?></span></strong>
                                    </td>
                                    <td width="50">Mortgage Due Date: <strong><?php echo $POST['mortgage_due_date']; ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table">
                            <thead class="client_list">
                                <tr>
                                    <td colspan="4">
                                        <h4>HELOC</h4>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>HELOC Amount: <strong>$ <?php echo number_format($POST['heloc_amount'],2); ?></strong>
                                    </td>
                                    <td>HELOC Start Term: <strong><?php echo $POST['heloc_start_term']; ?> Months</strong> </td>
                                    <td>HELOC Interest Rate: <strong><?php echo $POST['heloc_interest_rate']; ?> %</strong> </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">Do you want this amount applied to consolidated debt? <strong><?php echo $POST['heloc_addto_consolidated'] == 'yes' ? 'Yes' : 'No'; ?></strong>
                                    </td>
                                </tr>
                                <tr>
                            </tbody>
                        </table>
                        <table class="table">
                            <thead class="client_list">
                                <tr>
                                    <td colspan="4">
                                        <h4>Values to Update for  Term <?php echo $term; ?></strong></h4>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center"><strong><vllabel form="form1" for="u_mortgage_balance" validators="valMB" errclass="error_label" cerrclass="error_input">Mortage Balance:</vllabel></strong>
                                        <br />
                                        <input name="u_mortgage_balance" type="text" id="u_mortgage_balance" value="<?php echo $i['mortgagebalance'] > 0 ? $i['mortgagebalance'] : null; ?>">
                                        <vlvalidator name="valMB" type="checktype" control="u_mortgage_balance" errmsg="Mortgage Balance should be a numeric value." validtype="float" clientvalidate="true" setfocus="true">
                                    </td>
                                    <td align="center"><strong><vllabel form="form1" for="u_mortgage_interest" validators="valMI" errclass="error_label" cerrclass="error_input">Mortgage Interest Rate:</vllabel></strong>
                                        <br />
                                        <input name="u_mortgage_interest" type="text" id="u_mortgage_interest" value="<?php echo $i['mortginterestrate'] > 0 ? $i['mortginterestrate'] : null; ?>" size="6" maxlength="8"> %
                                        <vlvalidator name="valMI" type="checktype" control="u_mortgage_interest" errmsg="Mortgage Interest should be a numeric value." validtype="float" clientvalidate="true" setfocus="true">
                                    </td>
                                    <td align="center"><strong><vllabel form="form1" for="u_heloc_balance" validators="valHB" errclass="error_label">Heloc Balance:</vllabel></strong>
                                        <br />
                                        <input name="u_heloc_balance" type="text" id="u_heloc_balance" value="<?php echo $i['helocbalance'] > 0 ? $i['helocbalance'] : null; ?>">
                                        <vlvalidator name="valHB" type="checktype" control="u_heloc_balance" errmsg="Heloc Balance should be a numeric value." validtype="float" clientvalidate="true" setfocus="true">
                                    </td>
                                    <td align="center"><strong><vllabel form="form1" for="u_heloc_interest" validators="valHI" errclass="error_label" cerrclass="error_input">Heloc Interest Rate:</vllabel></strong>
                                        <br />
                                        <input name="u_heloc_interest" type="text" id="u_heloc_interest" value="<?php echo $i['helocinterestrate'] > 0 ? $i['helocinterestrate'] : null; ?>" size="6" maxlength="8"> %
                                        <vlvalidator name="valHI" type="checktype" control="u_heloc_interest" errmsg="Heloc Interest should be a numeric value." validtype="float" clientvalidate="true" setfocus="true">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center"><strong><vllabel form="form1" for="u_total_income" validators="valTI" errclass="error_label" cerrclass="calc_values">Total Income:</vllabel></strong> (per month)
                                        <br />
                                        <input name="u_total_income" type="text" id="u_total_income" value="<?php echo $i['total_income'] > 0 ? $i['total_income'] : null; ?>">
                                        <vlvalidator name="valTI" type="checktype" control="u_total_income" errmsg="Total Income should be a numeric value." validtype="float" clientvalidate="true" setfocus="true">
                                    </td>
                                    <td align="center"><strong>Updated Total Expenses:</strong>
                                        <br />
                                        <strong>$ <?php echo $total_new_monthly_expenses; ?></strong>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>

                        <br/>
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