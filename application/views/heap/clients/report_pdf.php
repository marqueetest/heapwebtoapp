<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>H.E.A.P. Results</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<link href="clients.css" rel="stylesheet" type="text/css" />
<link href="results.css" rel="stylesheet" type="text/css" />
<link href="report.css" rel="stylesheet" type="text/css" />
<style type="text/css">
div.error_summary {
    margin: 0 auto 30px auto;
}

body {
    margin-top:0;
    font-family: Helvetica;
    font-size: 14px;
    line-height: 20px;
}
.h1, .h2, .h3, h1, h2, h3 {
    margin-top: 20px;
    margin-bottom: 10px;
}
h3{
    color: #2B333E;
    font-weight: bold;
    font-size: 24px;
    line-height: 30px;
}
.report_table {
    border-spacing: 0;
    border-collapse: collapse;
    background-color: #FFF;
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
}
.report_table thead {
    border-bottom: 1px solid #ccc;
    font-weight: bold;
}
@media print {
    #navlinks {
        display: none;
    }

    body {
        background-color: white;
    }
}
</style>

<style type="text/css" media="print">


</style>

</head>
<body >
    <table width="742" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF" id="navlinks5"><img src="<?php echo base_url() ?>assets/img/logo.png" width="400"/></td>
        </tr>
        <tr>
            <td align="right" valign="top" bgcolor="#FFFFFF" id="navlinks5">&nbsp;</td>
        </tr>
        <tr>
            <td valign="top" bgcolor="#FFFFFF" id="navlinks4">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="10">
                    <tr>
                        <td align="left">
                            <p>The following report will illustrate how much sooner you will be able to pay off your home mortgage debt using H.E.A.P.&#8482;</p>
                            <p>The ultimate conclusions outlined in this report are based on the information you provided to your H.E.A.P.&#8482; advisor. To the extent you did not provide accurate information to your H.E.A.P.&#8482; advisor, that can positively or negatively affect the conclusions in this report.</p>

                            <p>Based on the numbers provided, you can save $<?php echo number_format($interest_saved,2); ?> in interest over the life of your mortgage.</p>
                        </td>
                    </tr>
                    <tr>
                      <td>
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="title_table">
                            <tr>
                                <td align="center"><h3>Current Liabilities</h3></td>
                            </tr>
                        </table>
                        <table class="report_table">
                            <thead>
                                <tr>
                                    <th width="50%" align="left"><strong>Existing Debt</strong> (to be paid off)</th>
                                    <th width="25%" align="right"><strong>Balance</strong></th>
                                    <th width="25%" align="right"><strong>Monthly Payments</strong></th>
                                </tr>
                            </thead>
                            <?php $exp_total_balance = $rep['mortgage_balance']; ?>
                            <?php $exp_total_payments = $rep['mortgage_payment']; ?>
                            <?php $rowColor = 'rowColor2'; ?>
                            <tr>
                                <td align="left" class="<?php echo $rowColor; ?>">&nbsp;Current Mortgage</td>
                                <td align="right" class="<?php echo $rowColor; ?>">&nbsp;$ <?php echo number_format($rep['mortgage_balance'],2); ?></td>
                                <td align="right" class="<?php echo $rowColor; ?>">&nbsp;$ <?php echo number_format($rep['mortgage_payment'],2); ?></td>
                            </tr>
                            <?php $cl_count = count($exp['expense']); ?>
                            <?php
                            foreach($exp['expense'] as  $e_value) {
                                if(empty($e_value))
                                    $cl_count--;
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
                            <tr>
                                <td align="left"><strong>Total Monthly Fixed Expenses:</strong></td>
                                <td align="right"><strong>$ <?php echo number_format($exp_total_balance,2); ?></strong></td>
                                <td align="right"><strong>$ <?php echo number_format($exp_total_payments,2); ?></strong></td>
                            </tr>
                        </table>
                        <br />
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="title_table">
                            <tr>
                                <td align="center"><h3>Net Income</h3></td>
                            </tr>
                        </table>
                        <table class="report_table" width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                            <tr>
                                <thead>
                                    <th width="50%" align="left"><strong>Employer</strong></th>
                                    <th width="25%" align="right"><strong>Interval</strong></th>
                                    <th width="25%" align="right"><strong>Amount</strong></th>
                                </thead>
                            </tr>
                            <tr>
                                <td align="left">
                                    &nbsp;
                                    <?php if($rep['income1'] > 0): ?>
                                        Income 1
                                    <?php endif; ?>
                                </td>
                                <td align="right">
                                    &nbsp;
                                    <?php if($rep['income1'] > 0): ?>
                                        <?php echo ucwords($rep['income1_interval']); ?>
                                    <?php endif; ?>
                                </td>
                                <td align="right">&nbsp;
                                    <?php if($rep['income1'] > 0): ?>
                                        $ <?php echo number_format($rep['income1']); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" class="rowColor1 borderBottom">&nbsp;
                                    <?php if($rep['income2'] > 0): ?>
                                        Income 2
                                    <?php endif; ?>
                                </td>
                                <td align="right" class="rowColor1 borderBottom">&nbsp;
                                    <?php if($rep['income2'] > 0): ?>
                                        <?php echo ucwords($rep['income2_interval']); ?>
                                    <?php endif; ?>
                                </td>
                                <td align="right" class="rowColor1 borderBottom">&nbsp;
                                    <?php if($rep['income2'] > 0): ?>
                                        $ <?php echo number_format($rep['income2']); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right"><strong>Total Monthly Net Income</strong></td>
                                <?php $income_total = $rep['income1'] + $rep['income2']; ?>
                                <td align="right"><strong>$ <?php echo number_format($income_total); ?></strong></td>
                            </tr>
                        </table>
                        <br />
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="title_table">
                            <tr>
                                <td align="center">
                                    <h3>&quot;Surplus&quot; Calculation (Keeping Current Debt Structure)</h3>
                                </td>
                            </tr>
                        </table>
                        <table class="report_table" width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                            <?php if($display_current_term): ?>
                                <tr>
                                    <th align="left" nowrap="nowrap">&nbsp;</th>
                                    <th align="center">Original Surplus</th>
                                    <?php if($display_current_term): ?>
                                        <th align="center">Current Surplus (Term <?php echo $term; ?>)</th>
                                    <?php endif; ?>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <th width="75%" align="left" nowrap="nowrap">Total Monthly Net Income</th>
                                <td width="25%" align="right">
                                    $ <?php echo number_format($income_total,2); ?>
                                </td>
                                <?php if($display_current_term): ?>
                                    <td width="25%" align="right">$ <?php echo number_format($term_total_income,2); ?></td>
                                <?php endif; ?>
                            </tr>
                            <?php $total_monthly_fixed_expenses = $exp_total_payments; ?>
                            <tr>
                                <th align="left" nowrap="nowrap">Total Monthly Fixed Expenses</th>
                                <td align="right" class="rowColor1">-$ <?php echo number_format($total_monthly_fixed_expenses,2); ?></td>
                                <?php if($display_current_term): ?>
                                    <td align="right" class="rowColor1">-$ <?php echo number_format($term_exp['total_payments'] + $rep['mortgage_payment'],2); ?></td>
                                <?php endif; ?>
                            </tr>
                            <?php $total_monthly_variable_expenses = $other_expenses + $nonmonthly_expenses; ?>
                            <tr>
                                <th align="left" nowrap="nowrap">Total Monthly Variable Expenses (as budgeted) </th>
                                <td align="right" class="borderBottom">-$ <?php echo number_format($total_monthly_variable_expenses,2); ?></td>
                                <?php if($display_current_term): ?>
                                    <td align="right" class="borderBottom">-$ <?php echo number_format($term_exp['total_other_expenses'] + $term_exp['nonmonthly_expenses'],2); ?></td>
                                <?php endif; ?>
                            </tr>
                            <tr>
                                <td align="right" valign="top" nowrap="nowrap"><strong>Monthly &quot;Surplus&quot;</strong><br />
                                      (Money that can be allocated to pay down mortgage debt)</td>
                                <?php $monthly_surplus_current = $income_total - $exp_total_payments - $other_expenses - $nonmonthly_expenses; ?>
                                <td align="right" valign="top"><strong>$ <?php echo number_format($monthly_surplus_current,2); ?></strong></td>
                                <?php if($display_current_term): ?>
                                    <td align="right" valign="top"><strong>$ <?php echo number_format($term_total_income - $term_exp['total_payments'] - $rep['mortgage_payment'] - $term_exp['total_other_expenses'] - $term_exp['nonmonthly_expenses'],2); ?></strong></td>
                                <?php endif; ?>
                            </tr>
                        </table>
                    </td>
                </tr>

                <?php if($fixed_expenses_payment_toHeloc > 0): ?>

                    <tr>
                        <td>
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="title_table">
                                <tr>
                                    <td align="center">
                                        <h3>&quot;Surplus&quot; Calculation (Moving All or some non-mortgage Debt to H.E.A.P.™ Account)</h3>
                                    </td>
                                </tr>
                            </table>
                            <table class="report_table" width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                                <?php if($display_current_term): ?>
                                    <tr>
                                        <th align="left">&nbsp;</th>
                                        <th align="center">Original Surplus</th>
                                        <?php if($display_current_term): ?>
                                            <th align="center">Current Surplus (Term <?php echo $term; ?>)</th>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <th width="50%" align="left" nowrap="nowrap">Total Monthly Net Income</th>
                                    <td width="25%" align="right">$ <?php echo number_format($income_total,2); ?></td>
                                    <?php if($display_current_term): ?>
                                        <td width="25%" align="right">$ <?php echo number_format($term_total_income,2); ?></td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <th align="left" nowrap="nowrap">Total Monthly Fixed Expenses</th>
                                    <td align="right" class="rowColor1">-$ <?php echo number_format($exp_total_payments - $fixed_expenses_payment_toHeloc,2); ?></td>
                                    <?php if($display_current_term): ?>
                                        <td align="right" class="rowColor1">-$ <?php echo number_format($term_exp['total_payments'] + $rep['mortgage_payment'] - $term_exp['fixed_expenses_payment_toHeloc'],2); ?></td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <th align="left" nowrap="nowrap">Total Monthly Variable Expenses (as budgeted) </th>
                                    <td align="right" class="borderBottom">-$ <?php echo number_format($other_expenses + $nonmonthly_expenses,2); ?></td>
                                    <?php if($display_current_term): ?>
                                        <td align="right" class="borderBottom">-$ <?php echo number_format($term_exp['total_other_expenses'] + $term_exp['nonmonthly_expenses'],2); ?></td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <td align="right" valign="top" nowrap="nowrap"><strong>Monthly &quot;Surplus&quot;</strong><br />
                                          (Money that can be allocated to pay down mortgage debt)</td>
                                      <?php $monthly_surplus_with_heap = $income_total - $exp_total_payments + $fixed_expenses_payment_toHeloc - $other_expenses - $nonmonthly_expenses; ?>
                                    <td align="right" valign="top"><strong>$ <?php echo number_format($monthly_surplus_with_heap,2); ?></strong></td>
                                    <?php if($display_current_term): ?>
                                        <td align="right" valign="top"><strong>$ <?php echo number_format($term_total_income - $term_exp['total_payments'] - $rep['mortgage_payment'] + $term_exp['fixed_expenses_payment_toHeloc'] - $term_exp['total_other_expenses'] - $term_exp['nonmonthly_expenses'],2); ?></strong></td>
                                    <?php endif; ?>
                                </tr>
                            </table>
                            <br/><br/>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td valign="top">
                            <p>With H.E.A.P.™, your mortgage debt (and other debt if added to the program) will be paid off without adjusting your monthly living expenses as budgeted in <?php echo number_format($heloc_total_months/12,2); ?> years.</p>
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="title_table">
                                <tr>
                                    <td align="center">
                                        <h3>Proposed Liability Structure</h3>
                                    </td>
                                </tr>
                            </table>
                            <table class="report_table" width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                                <thead>
                                    <tr>
                                        <th align="center">&nbsp;</th>
                                        <th align="right"><strong>1st Term Balance</strong></th>
                                        <th align="right"><strong>1st Term Payment</strong></th>
                                        <th align="right"><strong>Payment</strong></th>
                                    </tr>
                                </thead>
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
                                <tr>
                                    <td align="left">Purposed Mortgage</td>
                                    <td align="right">$ <?php echo number_format($purposed_mortgage_1st_term_balance,2); ?></td>
                                    <td align="right">$ <?php echo number_format($rep['mortgage_payment'],2); ?></td>
                                    <td align="right">$ <?php echo number_format($rep['mortgage_payment'],2); ?></td>
                                </tr>
                                <tr>
                                    <td align="left" class="rowColor1 borderBottom"><font color="#333333"> H.E.A.P.™ Account</font></td>
                                    <td align="right" class="rowColor1 borderBottom">$ <?php echo number_format($heap_acct_1st_term_balance,2); ?></td>
                                    <td align="right" class="rowColor1 borderBottom">$ <?php echo number_format($avg_heloc_interest_paid_first_year,2); ?></td>
                                    <td align="right" class="rowColor1 borderBottom">$ <?php echo number_format($avg_heloc_interest_paid_2,2); ?></td>
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
                                <tr>
                                    <td align="right"><strong>Total:</strong></td>
                                    <td align="right" class="borderBottom"><strong>$ <?php echo number_format($proposed_balance_total,2); ?></strong></td>
                                    <td align="right" class="borderBottom"><strong>$ <?php echo number_format($proposed_payment_total,2); ?></strong></td>
                                    <td align="right" class="borderBottom"><strong>$ <?php echo number_format($proposed_payment_total2,2); ?></strong></td>
                                </tr>
                                <?php if($fixed_expenses_payment_toHeloc > 0): ?>
                                    <tr>
                                        <td align="right"><span class="borderBottom"><strong>Monthly Payment Savings:</strong></span></td>
                                        <td align="right" class="borderBottom">&nbsp;</td>
                                        <td align="right" class="borderBottom"><strong>$ <?php echo number_format($proposed_payment_savings,2); ?></strong></td>
                                        <td align="right" class="borderBottom"><strong>$ <?php echo number_format($proposed_payment_savings2,2); ?></strong></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="page-break-before:always">&nbsp;</div>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td colspan="2" align="center" valign="top" style="padding-right: 8px;">
                                        <h3>Amortization Comparison<br/><br/></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding-right: 8px;">
                                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="title_table">
                                            <tr>
                                                <td align="center">
                                                    <h3>Current Mortgage</h3>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="report_table" width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                                            <tr>
                                                <th width="50%" align="right">Current Amount</th>
                                                <td width="50%" colspan="2" align="right">$<?php echo number_format($rep['mortgage_balance'],2); ?></td>
                                            </tr>
                                            <tr>
                                                <th align="right">Interest Rate</th>
                                                <td colspan="2" align="right" class="rowColor1"><?php echo $rep['mortgage_rate']; ?>%</td>
                                            </tr>
                                            <tr>
                                                <th align="right">Remaining Term</th>
                                                <td colspan="2" align="right"><?php echo $rep['mortgage_term']; ?></td>
                                            </tr>
                                            <tr>
                                                <th align="right">Interest Payment</th>
                                                <?php $interest_payment = $rep['mortgage_balance'] * $rep['mortgage_rate'] / 100 / 12; ?>
                                                <td colspan="2" align="right" class="rowColor1">$<?php echo number_format($interest_payment,2); ?></td>
                                            </tr>
                                            <tr>
                                                <?php $principal_payment = $rep['mortgage_payment'] - $interest_payment; ?>
                                                <th align="right">Principal Payment</th>
                                                <td colspan="2" align="right">$<?php echo number_format($principal_payment,2); ?></td>
                                            </tr>
                                            <tr>
                                                <th align="right">Escrow Amount</th>
                                                <td colspan="2" align="right" class="rowColor1">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th align="right">Total Payment</th>
                                                <td colspan="2" align="right">$<?php echo number_format($rep['mortgage_payment'],2); ?></td>
                                            </tr>
                                        </table>
                                        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" class="title_table">
                                            <tr>
                                                <td align="center">
                                                    <h3>Current Debt Amortization</h3>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="report_table" width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
                                            <thead>
                                                <tr>
                                                    <th width="10%" align="center">Year</th>
                                                    <th width="30%" align="center">Total<br />MTG Debt</th>
                                                    <th width="30%" align="center">Total<br />Debt Paid</th>
                                                    <th width="30%" align="center">Total<br />Interest</th>
                                                </tr>
                                            </thead>
                                            <?php foreach($mort_summary as $myear => $mort): ?>
                                                <?php $rowColor = $rowColor == 'rowColor2' ? 'rowColor1' : 'rowColor2'; ?>
                                                <tr>
                                                    <td align="center" class="<?php echo $rowColor; ?> <?php if($myear == $last_year_mortgage) echo 'borderBottom'; ?>"><?php echo $myear; ?></td>
                                                    <td align="right" class="<?php echo $rowColor; ?> <?php if($myear == $last_year_mortgage) echo 'borderBottom'; ?>">$<?php echo number_format($mort['principle_balance'],2); ?></td>
                                                    <td align="right" class="<?php echo $rowColor; ?> <?php if($myear == $last_year_mortgage) echo 'borderBottom'; ?>">&nbsp;$<?php echo number_format($mort['principle_paid'],2); ?></td>
                                                    <td align="right" class="<?php echo $rowColor; ?> <?php if($myear == $last_year_mortgage) echo 'borderBottom'; ?>">&nbsp;$<?php echo number_format($mort['total_interest'],2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </td>
                                    <td width="50%" valign="top" style="padding-left: 8px;">
                                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="title_table">
                                            <tr>
                                                <td align="center">
                                                    <h3>H.E.A.P.™</h3>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="report_table" width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                                            <tr>
                                                <th width="50%" align="right">Current Amount</th>
                                                <td width="50%" colspan="2" align="right">$<?php echo number_format($heap_current_amount,2); ?></td>
                                            </tr>
                                            <tr>
                                                <th align="right">Note Rate</th>
                                                <td colspan="2" align="right" class="rowColor1">$<?php echo $rep['heloc_rate']; ?>%</td>
                                            </tr>
                                            <?php $available_mma_amount = $rep['est_market_value'] - $rep['mortgage_balance'] - $rep['heloc_amount'] - $fixed_expenses_toHeloc; ?>
                                            <tr>
                                                <th align="right">Available Amount</th>
                                                <td colspan="2" align="right">$<?php echo number_format($available_mma_amount,2); ?></td>
                                            </tr>
                                            <tr>
                                                <th align="right">&nbsp;</th>
                                                <td colspan="2" align="right" class="rowColor1">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th align="right">&nbsp;</th>
                                                <td colspan="2" align="right">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th align="right">Program Start Date</th>
                                                <td colspan="2" align="right" class="rowColor1">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th align="right">Monthly Expenses</th>
                                                <?php //$monthly_expenses = $rep['mortgage_payment'] + $heloc_payment; ?>
                                                <td colspan="2" align="right"><!--$<?php echo number_format($monthly_expenses,2); ?>--></td>
                                            </tr>
                                        </table>
                                        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" class="title_table">
                                            <tr>
                                                <td align="center">
                                                    <h3>H.E.A.P.™ Amortization</h3>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="report_table" width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
                                            <thead>
                                                <tr>
                                                    <th width="10%" align="center">Year</th>
                                                    <th width="30%" align="center">Total<br />MTG Debt</th>
                                                    <th width="30%" align="center">Total<br />Debt Paid</th>
                                                    <th width="30%" align="center">Total<br />Interest</th>
                                                </tr>
                                            </thead>
                                            <?php $rowColor = null; ?>
                                            <?php for($y = 1; $y <= ceil($term_remaining/12); $y++): ?>
                                                <?php $rowColor = $rowColor == 'rowColor2' ? 'rowColor1' : 'rowColor2'; ?>
                                                <?php
                                                $rigged = false;
                                                if(!isset($summary[$y]['mort_balance']) || $summary[$y]['mort_balance'] <= '0') {
                                                    $total_mtg_debt_comparison = '0';
                                                    $total_debt_paid_comparison = $rep['mortgage_balance'] + $fixed_expenses_toHeloc;
                                                    $rigged = true;
                                                } else {
                                                    //$total_mtg_debt_comparison = $rep['mortgage_balance'] - $summary[$y]['total_debt1'];
                                                    //$total_mtg_debt_comparison = $summary[$y]['mort_balance_calc'];
                                                    $total_mtg_debt_comparison = isset($summary[$y]['mort_balance_calc']) ? $summary[$y]['mort_balance_calc'] : 0;
                                                    $total_debt_paid_comparison = $summary[$y]['total_debt1'];
                                                }

                                                if($rigged && isset($summary[$y]['mort_balance']) && $summary[$y]['mort_balance'] != '0') {
                                                    $total_mtg_debt_comparison = '0';
                                                    $total_debt_paid_comparison = '0';
                                                }

                                                if($total_mtg_debt_comparison < 0) $total_mtg_debt_comparison = 0;

                                                ?>
                                                <tr>
                                                    <td align="center" class="<?php echo $rowColor; ?> <?php if($y == ceil($term_remaining/12)) echo 'borderBottom'; ?>"><?php echo $y; ?></td>
                                                    <td align="right" class="<?php echo $rowColor; ?> <?php if($y == ceil($term_remaining/12)) echo 'borderBottom'; ?>">$<?php echo number_format($total_mtg_debt_comparison,2); ?></td>
                                                    <td align="right" class="<?php echo $rowColor; ?> <?php if($y == ceil($term_remaining/12)) echo 'borderBottom'; ?>">$<?php echo number_format($total_debt_paid_comparison,2); ?></td>
                                                    <td align="right" class="<?php echo $rowColor; ?> <?php if($y == ceil($term_remaining/12)) echo 'borderBottom'; ?>">
                                                    $<?php echo isset($summary[$y]['total_interest']) ? number_format($summary[$y]['total_interest'],2) : "0.00"; ?>
                                                  </td>
                                                </tr>
                                            <?php endfor; ?>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" valign="top" style="padding-right: 8px;">
                                        <div style="page-break-before:always">&nbsp;</div>
                                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="title_table">
                                                <tr>
                                                    <td align="center">
                                                        <h3>Savings Summary</h3>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table class="report_table" width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                                                <thead>
                                                    <tr>
                                                        <th align="center">Final</th>
                                                        <th align="center">Months Paid</th>
                                                        <th align="center">Months Saved</th>
                                                        <th align="center">Years Paid</th>
                                                        <th align="center">Years Saved</th>
                                                        <th align="center">Interest Paid</th>
                                                        <th align="center">Interest Saved</th>
                                                    </tr>
                                                </thead>
                                                <tr>
                                                    <td align="center" class="borderBottom"><?php echo date("n/Y",strtotime("+ $heloc_total_months months")); ?></td>
                                                    <td align="center" class="borderBottom"><?php echo $heloc_total_months; ?></td>
                                                    <td align="center" class="borderBottom"><?php echo $term_remaining - $heloc_total_months; ?></td>
                                                    <td align="center" class="borderBottom"><?php echo number_format($heloc_total_months/12,2); ?></td>
                                                    <td align="center" class="borderBottom"><?php echo number_format(($term_remaining - $heloc_total_months)/12,2); ?></td>
                                                    <td align="center" class="borderBottom">$<?php echo number_format($total_interest_paid,2); ?></td>
                                                    <td align="center" class="borderBottom">$<?php echo number_format($interest_saved,2); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td align="left" valign="top" bgcolor="#FFFFFF"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <!-- Content start -->
                            <table id="report_content" width="711" border="0" cellspacing="0" cellpadding="3">

                                <tr>
                                    <td align="center" valign="bottom">
                                        <img src="<?php echo base_url()."assets/graphs/".$graphFileName; ?>" height="400" width="650" />
                                        <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <table border="0" cellspacing="3" cellpadding="0">
                                            <tr>
                                                <td width="10" bgcolor="#800000">&nbsp;</td>
                                                <td align="left"><strong>Standard Mortgage Schedule&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                                <td width="10" bgcolor="#006600">&nbsp;</td>
                                                <td><strong>H.E.A.P. Schedule&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                                <td width="10" bgcolor="#FF6600">&nbsp;</td>
                                                <td><strong>HELOC&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                            </tr>
                                        </table>
                                        <br />
                                        <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                            <tr>
                                                <td align="left">
                                                    <p>With the Home Equity Acceleration Plan (H.E.A.P.&#8482;), as budgeted, you will pay off your "home mortgage" debt in <?php echo number_format($heloc_total_months/12,2); ?> years.</p>
                                                    <p>This will save you $<?php echo number_format($interest_saved,2); ?>  in mortgage interest over the life of the plan.</p>
                                                    <p>*The H.E.A.P.&#8482; numbers calculated for this report are based on the inputs given to your H.E.A.P.&#8482; advisor. It is understood that you will be able to pay off your mortgage debt sooner if you earn more income and/or decrease your variable expenses over the life of the plan. It is understood that it will take longer to pay off your mortgage debt if you decrease your income and/or increase your variable expenses over the life of
                                                    the plan.</p>
                                                    <p>If you need to re-run these numbers due to a substantial change in your income or expenses, please contact <?php echo $adviser['first_name']." ".$adviser['last_name']; ?> at <?php echo !empty($adviser['phone']) ? $adviser['phone'] : $adviser['email_address']; ?></p>
                                                        												
                                    				<?php
                                                    if ( isset($adviser11['email_footer']) && $adviser11['email_footer'] != '' )
                                                        echo $adviser11['email_footer'];
                                                    ?>
                                                </td>
                                            </tr>
                                        </table>
                                        <br/><br/>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <!-- Content end -->
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>

    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</body>
</html>
