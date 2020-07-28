<script type="text/javascript" src="<?php echo base_url() ?>assets/js/financials.js"></script>
<script type="text/javascript">
var pageLoading = true;
$(function()
{
    verifyTerms();
    PTaxSchedSelect();
    calculate_property_tax();
    calculate_total_income();
    calcMortgageValues();
    pageLoading = false;
});
function calcMortgageValues()
{
	var est_market_value = $("#est_market_value");
	if(!IsEmpty(est_market_value)) est_market_value.val(filterNum(est_market_value.val()));

	var total_original_mortgage = $("#total_original_mortgage");
	if(!IsEmpty(total_original_mortgage)) total_original_mortgage.val(filterNum(total_original_mortgage.val()));

    calcMonthlyMortgage()
    calcPrincipal();
    calculate_equity();
    calcTotalPaid();


}
function calcTotalPaid()
{
    if(!IsEmpty($("#mortgage_payment_monthly")) && !IsEmpty($("#current_principal_balance")) && !IsEmpty($("#current_equity")))
    {
        var total = parseFloat($("#mortgage_payment_monthly").val() * $("#months_remaining_mortgage_term").val());

        $("#total_paid_current_terms_value").val(formatNumber(total));
        $("#total_paid_current_terms").val(total);
    }
    else
    {
        $("#total_paid_current_terms_value").val('--');
        $("#total_paid_current_terms").val('');
    }
}
function calculate_equity()
{

    if(!IsEmpty($("#est_market_value")) && !IsEmpty($("#current_principal_balance")))
    {
        var current_equity = parseFloat($("#est_market_value").val()) - parseFloat($("#current_principal_balance").val());
        if(current_equity == 0) current_equity = 0;
        if(current_equity < 0) current_equity = 0;
        $("#current_equity_value").val(formatNumber(current_equity));
        $("#current_equity").val(current_equity.toFixed(2));
    }
    else
    {
        $("#current_equity_value").val('--');
        $("#current_equity").val('');
    }
}
function verifyTerms()
{
    if(!IsEmpty($("#total_original_term_months")) && !IsEmpty($("#months_remaining_mortgage_term")))
    {
        if($("#months_remaining_mortgage_term").val() > $("#total_original_term_months").val())
        {
            alert("Error: Original Mortgage Term should be greater than years remaining!")
            $("#months_remaining_mortgage_term").focus();
            return false;
        }

		var current_term = $("#total_original_term_months").val() - $("#months_remaining_mortgage_term").val() + 1;
		$("#current_term").html(current_term);
    }
}
function calcPrincipal()
{


    if(!IsEmpty($("#mortgage_payment_monthly")) && !IsEmpty($("#months_remaining_mortgage_term")) && !IsEmpty($("#interest_rate_annual")))
    {
		var total_original_mortgage = $("#total_original_mortgage").val();
        var intRate = $("#interest_rate_annual").val() / 100;
        var numPayments = $("#months_remaining_mortgage_term").val();
        var monthlyPayment = $("#mortgage_payment_monthly").val();

		if($("#interest_only").attr("checked") == true)
		{
			principal = total_original_mortgage;
        }
		else
		{
			var principal = PV(intRate / 12, numPayments, monthlyPayment);
			if(principal > 0) principal = 0;
			principal = Math.abs(principal);
		}

        $("#current_principal_balance_value").val(formatNumber(principal));
        $("#current_principal_balance").val(principal);
    }
    else
    {
        $("#current_principal_balance_value").val('--');
        $("#current_principal_balance").val('');
    }
}
function calcMonthlyMortgage() {

    if(!IsEmpty($("#interest_rate_annual")) && !IsEmpty($("#total_original_term_months")) && !IsEmpty($("#total_original_mortgage"))) {
        var intRate = $("#interest_rate_annual").val() / 100;
        var numPayments = $("#total_original_term_months").val();
        var principal = $("#total_original_mortgage").val();
		var total_original_mortgage = $("#total_original_mortgage").val();

		//if($("#interest_only").attr("checked") == true){
		if( $("#interest_only").is(':checked') ) {
    		pmt = total_original_mortgage * intRate/12;
		} else {
			var pmt = PMT(intRate / 12,numPayments,principal);
			if(pmt > 0) pmt = 0;
			pmt = Math.abs(pmt);
		}

        $("#mortgage_payment_monthly_value").val(formatNumber(pmt));
		$("#mortgage_payment_value").val(formatNumber(pmt));
        $("#mortgage_payment_monthly").val(pmt);
    } else {
        $("#mortgage_payment_monthly_value").val('--');
		$("#mortgage_payment_value").val('--');
        $("#mortgage_payment_monthly").val('');
    }
}
function calculate_total_income() {
    /*var income1Field = document.form1.income1;
    var income2Field = document.form1.income2;
    //if(IsEmpty(income1Field)) income1Field.value = '0';
    //if(IsEmpty(income2Field)) income2Field.value = '0';
    var total_income = eval(income1Field.value) + eval(income2Field.value);
    document.form1.total_income.value = total_income.toFixed(0);
    document.getElementById('total_income_value').innerHTML = total_income.toFixed(0);*/

    //income_bimonthly_1, income_row2, daypaid_table1, income_knowdays1_no, knowdays1_row

    var income1_payFreq;
    var income2_payFreq;



    /*if($("#income_knowdays1_yes").attr('checked') || $("#income_knowdays2_yes").attr('checked')) {
        $("#income_row2").css("display","");
    } else {
    	$("#income_row2").css("display","none");
    }*/

    //if($("#income_bimonthly_1").attr('checked')) {
    if( $("#income_bimonthly_1").is(':checked') ) {
        income1_payFreq = 2;
        $("#knowdays1_row").css("display","");
        //if($("#income_knowdays1_yes").attr('checked'))
        if( $("#income_knowdays1_yes").is(':checked') ) {
        	$("#daypaid_table1").css("display","");
        } else {
        	$("#daypaid_table1").css("display","none");
        }
    } else {
        income1_payFreq = 1;
        $("#daypaid_table1").css("display","none");
        $("#knowdays1_row").css("display","none");
        $("#income_knowdays1_yes").attr('checked',false)
        $("#income_knowdays1_no").attr('checked',false)
    }

    //if($("#income_bimonthly_2").attr('checked')) {
    if( $("#income_bimonthly_2").is(':checked') ) {
        income2_payFreq = 2;
        $("#knowdays2_row").css("display","");
        //if($("#income_knowdays2_yes").attr('checked'))
        if( $("#income_knowdays2_yes").is(':checked') ) {
        	$("#daypaid_table2").css("display","");
        } else {
        	$("#daypaid_table2").css("display","none");
        }
    } else {
        income2_payFreq = 1;
        $("#daypaid_table2").css("display","none");
        $("#knowdays2_row").css("display","none");
        $("#income_knowdays2_yes").attr('checked',false)
        $("#income_knowdays2_no").attr('checked',false)
    }

	var income1 = $("#income1");
	if(!IsEmpty(income1)) income1.val(filterNum(income1.val()));

	var income2 = $("#income2");
	if(!IsEmpty(income2)) income2.val(filterNum(income2.val()));

    income1 = IsEmpty($("#income1")) ? 0 : eval($("#income1").val());
    income2 = IsEmpty($("#income2")) ? 0 : eval($("#income2").val());
    var total_income = 0;
    total_income = (income1*income1_payFreq + income2*income2_payFreq).toFixed(0);

    if(isNaN(total_income)) total_income = '0';

    $("#total_income_value").val(total_income);
    $("#total_income").val(total_income);
}
function PTaxSchedSelect()
{
    if($("#property_tax_schedule").val() == '1')
    {
        $("#ptax_half1").hide();
        $("#ptax_half2").hide();
        $("#ptax_annual").show();
    }
    else if ($("#property_tax_schedule").val() == '2')
    {
        $("#ptax_half1").show();
        $("#ptax_half2").show();
        $("#ptax_annual").hide();
    }

    if(!pageLoading)
    {
        $("#property_tax_1").val('0');
        $("#property_tax_2").val('0');
        $("#property_tax").val('0');
    }
    calculate_property_tax();

}
function calculate_property_tax()
{
    var ptax1 = IsEmpty($("#property_tax_1")) ? 0 : eval($("#property_tax_1").val());
    var ptax2 = IsEmpty($("#property_tax_2")) ? 0 : eval($("#property_tax_2").val());
    var ptax = IsEmpty($("#property_tax")) ? 0 : eval($("#property_tax").val());
    var total_ptax = 0;

    switch($("#property_tax_schedule").val())
    {
        case '1':
            total_ptax = ptax;
            break;
        case '2':
            total_ptax = ptax1 + ptax2;
            break;
    }
    total_tax = total_ptax.toFixed(0);
    if(isNaN(total_tax)) total_tax = '0';

    $("#annual_property_tax_display").html(total_tax);
    $("#annual_property_tax").val(total_tax);
}
function IsEmpty(aTextField)
{
   if ((aTextField.val()==null) || (aTextField.val().length==0)) {
      return true;
   }
   else { return false; }
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

function filterNum(str)
{
	str = str.replace(/[^0-9\.]/g, "");
    //re = /^\$|,/g;
    // remove "$" and ","
    //return str.replace(re, "");
	return str;
}
</script>
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
                                    <span>Step 2:Expenses(<?php echo $client["first_name"]." ".$client["last_name"]; ?>)</span>
                                    (<span class="new_head upr_head"><?php  if($term < 1): ?>NEW<?php else: ?> <?php echo $term; ?><?php  endif; ?></span>)
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
						<input name="t" type="hidden" id="t" value="<?php echo $current_term; ?>">

						<div class="row">
							<hr>

						    <div class="col-md-12">
						        <h3 class="client_list m0">INCOME(PER MONTH)</h3>
						        <input type="hidden" name="total_income" id="total_income">
						    </div>
					    </div>

					    <div class="row">

		                    <div class="col-md-4">
		                       	<label for="basic-addon1" class="control-label">Income 1:</label>
		                       	<div class="row">
		                           	<div class="col-md-12">
		                               	<div class="form-group">
			                               	<div class="input-group">
			                                  	<span class="input-group-addon" id="basic-addon1" >$</span>
			                                  	<input type="text" class="form-control" aria-describedby="basic-addon1" name="income1" type="text" id="income1" onKeyUp="calculate_total_income();" value="<?php echo empty($POST['income1']) ? '0' : $POST['income1']; ?>" />
			                                </div>
		                            	</div>
		                               	<span><input name="income_bimonthly_1" type="checkbox" class="noBorder" id="income_bimonthly_1" onClick="calculate_total_income();" value="true" <?php if(!empty($POST['income_bimonthly_1'])) echo 'checked'; ?>> Semi-Monthly</span>
		                               	<div id="knowdays1_row">
		                               		<span>Do you know the days you get paid?</span>
		                                   	<input name="income_knowdays1" type="radio" class="noBorder" id="income_knowdays1_yes" value="yes" onClick="calculate_total_income();" <?php echo (isset($POST['income_knowdays1']) && $POST['income_knowdays1'] == "yes") ? "checked='checked'":"" ?> />
		                                   Yes &nbsp;

		                                    <input  name="income_knowdays1" type="radio" class="noBorder" id="income_knowdays1_no" value="no" onClick="calculate_total_income();" <?php echo (isset($POST['income_knowdays1']) && $POST['income_knowdays1'] == "no") ? "checked='checked'":"" ?> />No

		                            	</div>
		                           		<div id="income_row2">
		                              		<div id="daypaid_table1">
		                               			<div>Days of Month Paid:</div>
	                           					<input name="day_paid1[0]" type="text" id="day_paid1[0]" size="2" maxlength="2" value="<?php echo empty($POST['day_paid1'][0]) ? '' : $POST['day_paid1'][0]; ?>" />
	                          					&amp; <input name="day_paid1[1]" type="text" id="day_paid1[1]" size="2" maxlength="2" value="<?php echo empty($POST['day_paid1'][1]) ? '' : $POST['day_paid1'][1]; ?>" />
		                        			</div>
		                               	</div>
		                           	</div>
		                       	</div>
		                    </div>

		                    <div class="col-md-4">
		                       	<label for="income2" class="control-label">Income 2:</label>
		                       	<div class="row">
		                           	<div class="col-md-12">
		                               	<div class="form-group">
			                               	<div class="input-group">
			                                  	<span class="input-group-addon" id="basic-addon1">$</span>
			                                  	<input type="text" class="form-control" aria-describedby="basic-addon1" name="income2" id="income2" onKeyUp="calculate_total_income();" value="<?php echo empty($POST['income2']) ? '0' : $POST['income2']; ?>" />
			                                </div>
		                            	</div>
		                               	<span><input name="income_bimonthly_2" type="checkbox" class="noBorder" id="income_bimonthly_2" value="true" onClick="calculate_total_income();" <?php if(!empty($POST['income_bimonthly_2'])) echo 'checked'; ?>> Semi-Monthly</span>
		                               	<div id="knowdays2_row">
		                               		<span>Do you know the days you get paid?</span>
		                                   	<input name="income_knowdays2" type="radio" class="noBorder" id="income_knowdays2_yes" value="yes" onClick="calculate_total_income();" <?php echo (isset($POST['income_knowdays2']) && $POST['income_knowdays2'] == 'yes') ? "checked='checked'" : ""; ?> />
		                                   	Yes &nbsp;
		                                    <input  name="income_knowdays2" type="radio" class="noBorder" id="income_knowdays2_no" value="no" onClick="calculate_total_income();" <?php echo (isset($POST['income_knowdays2']) && $POST['income_knowdays2'] == 'no') ? "checked='checked'" : ""; ?> />No
		                           		</div>
		                           		<div id="income_row2">
		                           			<div id="daypaid_table2">
		                           				<div>Days of Month Paid:</div>
		                           				<input name="day_paid2[0]" type="text" id="day_paid2[0]" size="2" maxlength="2" value="<?php echo empty($POST['day_paid2'][0]) ? '' : $POST['day_paid2'][0]; ?>">
		                          				&amp; <input name="day_paid2[1]" type="text" id="day_paid2[1]" size="2" maxlength="2" value="<?php echo empty($POST['day_paid2'][1]) ? '' : $POST['day_paid2'][1]; ?>">
		                         			</div>
		                           		</div>
		                           	</div>
		                        </div>
		                    </div>

		                    <div class="col-md-4">
		                       	<label for="total_income_value" class="control-label">Total income:</label>
		                       	<div class="row">
		                           	<div class="col-md-12">
		                               	<div class="input-group">
		                                  	<span class="input-group-addon" id="basic-addon1">$</span>
		                                  	<input type="text" id='total_income_value' class="form-control readable_form" aria-describedby="basic-addon1" readonly />
		                                </div>
		                           	</div>
		                        </div>
		                    </div>
		                    
		              	</div> <!-- row ends -->

		              	<div class="row">
			              	<div class="col-md-12 portion_top">
							    <h3 class="client_list m0">REAL ESTATE</h3>
							</div>
						</div>

						<div class="row">
		                    <div class="col-md-3">
		                        <label for="est_market_value" class="control-label">Estimated Market Value</label>
		                        <div class="row">
		                          	<div class="col-md-12">
		                          		<div class="form-group">
			                               	<div class="input-group">
			                                  	<span class="input-group-addon" id="basic-addon1">$</span>
			                                  	<input type="text" class="form-control" name="est_market_value" id="est_market_value" onKeyUp="calcMortgageValues();" value="<?php echo empty($POST['est_market_value']) ? '' : $POST['est_market_value']; ?>" />
			                                </div>
		                            	</div>
		                           	</div>
		                        </div>
		                    </div>

		                   	<div class="col-md-3">
		                       <label for="total_original_mortgage" class="control-label">Total Original Mortgage</label>
		                       <div class="row">
		                           	<div class="col-md-12">
		                           		<div class="form-group">
			                               	<div class="input-group">
			                                  <span class="input-group-addon" id="basic-addon1">$</span>
			                                  <input type="text" name="total_original_mortgage" class="form-control" id="total_original_mortgage" onKeyUp="calcMortgageValues();" value="<?php echo empty($POST['total_original_mortgage']) ? '' : $POST['total_original_mortgage']; ?>" />
			                                </div>
		                            	</div>
		                           	</div>
		                        </div>
		                    </div>

		                    <div class="col-md-3">
		                        <label for="current_principal_balance_value" class="control-label">
		                            Current Principal Balance
		                        </label>
		                        <input type="hidden" name="current_principal_balance" id="current_principal_balance">
		                       	<div class="row">
		                           	<div class="col-md-12">
		                           		<div class="control-label">
			                               	<div class="input-group">
			                                  	<span class="input-group-addon" id="basic-addon1">$</span>
			                                  	<input type="text" id='current_principal_balance_value' class="calc_values form-control readable_form" aria-describedby="basic-addon1" readonly />
			                                </div>
		                            	</div>
		                           	</div>
		                        </div>
		                   	</div>


		                   	<div class="col-md-3">
		                        <label for="current_equity_value" class="control-label">
		                            Current Equity
		                       	</label>
		                       	<input type="hidden" name="current_equity" id="current_equity">
		                       	<div class="row">
		                           <div class="col-md-12">
		                               	<div class="form-group">
			                               	<div class="input-group">
			                                  <span class="input-group-addon" id="basic-addon1">$</span>
			                                  <input type="text" id='current_equity_value' class="calc_values form-control readable_form" aria-describedby="basic-addon1" readonly />
			                                </div>
			                            </div>
		                           </div>
		                        </div>
		                   	</div>

						</div><!-- row ends -->

						<div class="row">
		                    
		                    <div class="col-md-3 padding_form">
                                <label for="mortgage_payment_monthly" class="control-label">Mortgage Payment (monthly)</label>
		                        <input type="hidden" name="mortgage_payment_monthly" id="mortgage_payment_monthly" />
		                       	<div class="row">
		                           	<div class="col-md-12">
		                               	<div class="input-group">
		                                  	<span class="input-group-addon" id="basic-addon1">$</span>
		                                  	<input type="text" id='mortgage_payment_monthly_value' class="calc_values form-control " aria-describedby="basic-addon1" readonly />
		                                </div>
		                           	</div>
		                        </div>
		                    </div>

		                   	<div class="col-md-3 padding_form">
                                <label for="total_original_term_months" class="control-label">Total Original Mortgage Term</label>
		                       	<div class="row">
		                            <div class="col-md-12">
		                               	<div class="input-group">
		                                  	<span class="input-group-addon" id="basic-addon1">$</span>
		                                  	<input name="total_original_term_months" class="form-control" type="text" id="total_original_term_months" size="6" maxlength="3" onKeyUp="calcMortgageValues();" value="<?php echo empty($POST['total_original_term_months']) ? '' : $POST['total_original_term_months']; ?>">
		                                </div>
		                           	</div>
		                        </div>
		                    </div>

		                    <div class="col-md-3 padding_form">
                                <label for="months_remaining_mortgage_term" class="control-label">Months Remaining in Mortgage Term</label>
		                       <div class="row">
		                            <div class="col-md-12">
		                               <div class="input-group">
		                                  <span class="input-group-addon" id="basic-addon1">$</span>
		                                  <input name="months_remaining_mortgage_term" type="text" class="form-control" id="months_remaining_mortgage_term" size="6" maxlength="3" onKeyUp="calcMortgageValues();" value="<?php echo empty($POST['months_remaining_mortgage_term']) ? '' : $POST['months_remaining_mortgage_term']; ?>">
		                                </div>
		                           </div>
		                        </div>
		                   </div>

		                   	<div class="col-md-3 padding_form">
		                        <label for="interest_rate_annual" class="control-label">Interest Rate (annual)</label>
		                       	<div class="row">
		                           	<div class="col-md-12">
		                               <div class="input-group">
		                                  <span class="input-group-addon" id="basic-addon1">$</span>
		                                  <input name="interest_rate_annual" type="text" id="interest_rate_annual" class="form-control" size="8" maxlength="8" onKeyUp="calcMortgageValues();" value="<?php echo empty($POST['interest_rate_annual']) ? '' : $POST['interest_rate_annual']; ?>">
		                                </div>
		                           </div>
		                        </div>
		                   	</div>

			            </div><!-- row ends -->

			            <div class="row">

		                    <div class="col-md-3 padding_form">
		                        <label class="control-label">Estimated Total Amount Paid at Current Terms</label>
		                        <input type="hidden" name="total_paid_current_terms" id="total_paid_current_terms" />
		                       	<div class="row">
	                            	
	                            	<div class="col-md-12">
	                           			<div class="col-md-10"><hr></div>
	                               		<div class="col-md-2"></div>
	                               	</div>

		                           	<div class="col-md-12">
		                            	<div class="input-group">
		                                  	<span class="input-group-addon" id="basic-addon1">$</span>
		                                  	<input type="text" id='total_paid_current_terms_value' class="calc_values form-control readable_form" aria-describedby="basic-addon1" readonly />
		                                </div>
		                            </div>

		                        </div>
		                    </div>

		                    <div class="col-md-3 padding_form">
		                        <label class="control-label" for="current_mortgage_balance">Current Mortgage Balance</label>
		                       	<div class="row">
		                          	<div class="col-md-12">
		                            	<div class="input-group">
		                                  	<span class="input-group-addon" id="basic-addon1">$</span>
		                                   	<input type="text" name="current_mortgage_balance" onkeyup="$(this).val(filterNum($(this).val()));" id="current_mortgage_balance" value="<?php echo empty($POST['current_mortgage_balance']) ? '' : $POST['current_mortgage_balance']; ?>" class="form-control" />
		                                </div>
		                            </div>
		                        </div>
		                    </div>

		                    <div class="col-md-3">
		                        &nbsp;
		                    </div>

		                   	<div class="col-md-3">
		                       	<input name="interest_only" type="checkbox"  onClick="calcMortgageValues();" id="interest_only" value="true" <?php if(!empty($POST['interest_only'])) echo 'checked'; ?> /><label class="control-label" for="interest_only"> Interest Only</label>
		                   	</div>

			            </div> <!-- row ends -->

			            <div class="row">
				            <div class="col-md-12 portion_top">
								<h3 class="client_list m0">EXPENSES (MONTHLY)</h3>
							</div>
						</div>

						<input type="hidden" name="expenses" id="expenses" value="<?php echo $total_monthly_expenses; ?>" />

						<div class="row">

		                   <div class="col-md-6 ">
		                        <label class="form-control">Expenses</label>
		                       	<div class="row">
		                          	<div class="col-md-12">
		                            	<div class="input-group">
		                                 	<span class="input-group-addon" id="basic-addon1">$</span>
		                                	<input type="text" class="form-control readable_form"value="<?php echo $total_monthly_expenses; ?>"  aria-describedby="basic-addon1" readonly />
		                                </div>
		                            </div>
		                        </div>
		                    </div>

		                   	<div class="col-md-6">
		                        <label class="form-control" for="expenses_payment_date">Payment Date: (1-28)</label>
		                        <div class="row">
	                           		<div class="col-md-11">
	                           			<input type="text" class="form-control" name="expenses_payment_date" id="expenses_payment_date" value="<?php echo empty($POST['expenses_payment_date']) ? '' : $POST['expenses_payment_date']; ?>" />
	                           		</div>
		                        </div>
		                    </div>
		               	</div> <!-- row ends -->

		               	<div class="row">
			               	<div class="col-md-12 portion_top">
							    <h3 class="client_list m0">MORTGAGE</h3>
							</div>
						</div>

		               	<div class="row">

			                <div class="col-md-6">
			                    <div class="font_size">&nbsp;</div>
			                    <div class="row">
			                        <div class="col-md-12">
			                            <div class="input-group">
			                                <span class="input-group-addon" id="basic-addon1">$</span>
			                                <input type="text" id='mortgage_payment_value' class="calc_values form-control readable_form" aria-describedby="basic-addon1" readonly />
			                            </div>
			                        </div>
			                    </div>
			                </div>

			                <div class="col-md-6">
			                    <label class="control-label">Mortgage Due Date:(1-28)</label>
			                    <div class="row">
			                        <div class="col-md-11">
			                        	<input type="text" name="mortgage_due_date"  class="form-control" id="mortgage_due_date" value="<?php echo empty($POST['mortgage_due_date']) ? '' : $POST['mortgage_due_date']; ?>" />
			                        </div>
			                    </div>
			                </div>

			            </div> <!-- row ends -->

			            <div class="row">
				            <div class="col-md-12 portion_top">
							    <h3 class="client_list m0">HELOC</h3>
							</div>
						</div>

						<div class="row form-group">

		                   	<div class="col-md-4">
		                        <label class="control-label" for="heloc_amount">HELOC Amount:</label>
		                       	<div class="row">
		                          	<div class="col-md-12">
		                            	<div class="input-group">
		                                  	<span class="input-group-addon" id="basic-addon1">$</span>
		                                  	<input type="text" name="heloc_amount" class="form-control " onkeyup="$(this).val(filterNum($(this).val()));" id="heloc_amount" value="<?php echo empty($POST['heloc_amount']) ? '' : $POST['heloc_amount']; ?>" />
		                                </div>
		                            </div>
		                        </div>
		                    </div>

		                    <div class="col-md-4">
		                        <label class="control-label">HELOC Start Term:</label>
		                       	<div class="row">
		                          	<div class="col-md-12">
		                            	<div class="input-group">
		                                  	<span class="input-group-addon" id="basic-addon1">Months</span>
		                                	<input name="heloc_start_term" class="form-control " type="text" id="heloc_start_term" size="6" maxlength="6" value="<?php echo empty($POST['heloc_start_term']) ? '' : $POST['heloc_start_term']; ?>" />
		                                </div>
		                            </div>
		                        </div>
		                    </div>

		                   <div class="col-md-4">
		                        <label class="control-label">HELOC Interest Rate:</label>
		                       	<div class="row">
		                           	<div class="col-md-12">
		                            	<div class="input-group">
		                                  	<span class="input-group-addon" id="basic-addon1">%</span>
		                                  	<input class="form-control" name="heloc_interest_rate" type="text" id="heloc_interest_rate" size="10" maxlength="10" value="<?php echo empty($POST['heloc_interest_rate']) ? '' : $POST['heloc_interest_rate']; ?>" />
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		               	</div><!-- row ends -->

		               	<div class="row">
						    <div class="col-md-12 portion_top">
						        <span>Do you want this amount applied to consolidated debt?</span>
							        <input name="heloc_addto_consolidated" type="radio" class="noBorder" id="heloc_addto_consolidated" value="yes" <?php echo (isset($POST['heloc_addto_consolidated']) && $POST['heloc_addto_consolidated'] == "yes") ? "checked='checked'" : "" ?> />Yes&nbsp;
							        <input name="heloc_addto_consolidated" type="radio" class="noBorder" id="heloc_addto_consolidated2" value="no" <?php echo (isset($POST['heloc_addto_consolidated']) && $POST['heloc_addto_consolidated'] == "no") ? "checked='checked'" : "" ?> /> No 
						    	
						    </div>
						</div>
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