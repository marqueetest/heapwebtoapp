<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors', 0);
class Report extends MY_Controller {

    public $data = array();
    public $adviser_id;

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
    	$this->load->library('form_validation');

		$this->load->model("client_model");
		$this->load->model("report_model");

		$this->adviser_id = $this->session->userdata("adviser_id");
	}

	public function index() {
		$this->load->view('errors/html/error_404');
	}

	public function listReports( $client_id ) {

		if( $this->client_model->isAdviserClient($this->adviser_id, $client_id) ) {

			$reports = $this->report_model->listReports( $client_id, $this->session->userdata("adviser_id") );

			/*$counter = 0;
			foreach( $reports as $r ) {
				echo "<pre>";print_r( $r );echo "</pre>";
				$POST =  unserialize($r['POST']); // Original posted values
                $current_term = $r['current_term'];
                if(empty($current_term) || $current_term < 1) {
                    $current_term = $POST['total_original_term_months'] - $POST['months_remaining_mortgage_term'] + 1;
                }
                $mortgage_term_total = $r['mortgage_term'];

                $params = array("client_id" => $client_id, "report_id" => $r["id"]);
                $u = $this->report_model->getFileData2( $params );
                if( $u ) {
                	$u = $u[0];
                	$report_updated_date = $u['date_modified'];
                    $last_term_updated = $u['term'];

                    $l = $this->report_model->getLastTerm( $params );
                    if( $l ) {
                    	$l = $l[0];

                    	$mortgage_last_calc_term = $l['last_term'];

                    	$mtg_term_loop = $mortgage_last_calc_term > 0 ? $mortgage_last_calc_term : $mortgage_term_total;
                    }
                    $report_created_date = date("m/d/Y",strtotime($r['creation_date']));
                	$report_updated_date = empty($report_updated_date) ? null : date("m/d/Y",strtotime($report_updated_date));
                }

                $reports[$counter]["mtg_term_loop"] = $mtg_term_loop;
                $reports[$counter]["current_term"] = $current_term;
                $counter++;
			}*/

			$this->data["reports"] = $reports;
			$params = array("id" => $client_id);
			$this->data["client"] = $this->client_model->heapGetClient( $params );
			$this->data["client"] = $this->data["client"][0];

			$this->load->view('common/header', $this->data);
			$this->load->view('heap/clients/list_reports', $this->data);
			$this->load->view('common/footer', $this->data);
		} else {
			$this->load->view("errors/html/error_404");
		}

	}

	public function createReport( $client_id, $term = 0 ) {
		if( $this->client_model->isAdviserClient($this->adviser_id, $client_id) ) {

			$params = array("id" => $client_id);
			$client = $this->client_model->heapGetClient( $params );
			$this->data["client"] = $client[0];
			$this->data["term"] = $term;

			$this->load->view('common/header', $this->data);
			$this->load->view('heap/clients/create_report', $this->data);
			$this->load->view('common/footer', $this->data);

		} else {
			$this->load->view("errors/html/error_404");
		}
	}

	public function reportStep1( $client_id, $report_id = 0, $term = 0 ) {
		$adviser_id = $this->client_model->getSingleColumn("adviser_id", "SELECT `adviser_id` from adviser_clients where client_id = '".(int)$client_id."'");
		if( $this->client_model->isAdviserClient($adviser_id, $client_id) ) {
			$params = array("id" => $client_id);
			$client = $this->client_model->heapGetClient( $params );
			$this->data["client"] = $client[0];
			$this->data["report_id"] = $report_id;
			$this->data["term"] = $term;

			if( $report_id > 0 ) {
				/* REPORT EDIT DATA */
				$params = array("id" => $report_id);
				$report = $this->report_model->getReport( $params );
				$report = $report[0];

				$current_term = $report['current_term'];
			    // Workaround for older data in database prior to latest update
			    if(empty($current_term) || $current_term < 1) {
			        $POST = unserialize($report['POST']); // Original posted values
			        $current_term = $POST['total_original_term_months'] - $POST['months_remaining_mortgage_term'] + 1;
			    }
			}

			if( count($this->input->post()) > 0 ) {

				$expenses = array();
				$expenses["expense"] = is_array($this->input->post("expense")) ? $this->input->post("expense") : array();
		        $expenses["balance"] = is_array($this->input->post("balance")) ? $this->input->post("balance") : array();
		        $expenses["payments"] = is_array($this->input->post("payments")) ? $this->input->post("payments") : array();
		        $expenses["addTo_heloc"] = is_array($this->input->post("addTo_heloc")) ? $this->input->post("addTo_heloc") : array();
		        $expenses["other"]["amount"] = is_array($this->input->post("otherAmount")) ? $this->input->post("otherAmount") : array();
		        $expenses["nonMonthly"]["annual_amount"] = !empty($this->input->post("annual_exp_amount")) ? $this->input->post("annual_exp_amount") : "$ 0.00";
		        $expenses["nonMonthly"]["semi_amount"] = !empty($this->input->post("semi_exp_amount")) ? $this->input->post("semi_exp_amount") : "$ 0.00";

		        $expenses_serial = serialize($expenses);

		        $sessionData = array();
		        $sessionData['expenses'][$client_id][$report_id][$term] = $expenses_serial;
				$this->session->set_userdata($sessionData);

		        if($report_id == 0 || $term == 0 || $term == $current_term) {
		        	redirect("/report/reportStep2/".$client_id."/".$report_id."/".$term, "refresh");
		            //echo '<script type="text/javascript">window.location.href = "hea_calc.php?id='.$client_id.'&r='.$report_id.'&t='.$term.'&m=Expenses+updated"</script>';
		        }
		        else
		        	redirect("/report/reportStep2_update/".$client_id."/".$report_id."/".$term, "refresh");
		            //echo '<script type="text/javascript">window.location.href = "hea_calc_update.php?id='.$client_id.'&r='.$report_id.'&t='.$term.'&m=Expenses+updated"</script>';
		        exit;
			}

			$clientExp = $this->report_model->getClientExp($client_id, $this->adviser_id);
			$clientExp = $clientExp[0];
			$term1_expenses = "";

			if($report_id == 0 || $term == 0) {
		        $expenses = array();
		        $otherExpenses = array();
		    } else {
		        // If expenses not found in client_expenses table for term 1, pull from clients table (work around for update to tables & code changing to use separate expenses table)
		        // then insert into correct table (client_expenses)
		    	$client_expenses = $this->report_model->getClientExpenses2( $client_id, $report_id, $term );
		    	if( $client_expenses ) {
		    		$client_expenses = $client_expenses[0];
		    		$expenses = unserialize($client_expenses['expenses']);
		            $term1_expenses = $expenses;
		    	} else {
		    		// Insert data into proper table
		    		$params = array(
		    						"client_id" => $client_id,
		    						"report_id" => $report_id,
		    						"term" => $term,
		    						"expenses" => $clientExp["expenses"],
		    						"date_created" => date("Y-m-d H:i:s")
		    						);
		    		$new_expense = $this->report_model->insertExpense( $params );

		            if($term == $current_term) {
		                $expenses = unserialize($c['expenses']);
		                $term1_expenses = $expenses;
		            }
		        }


		        if($term > $current_term) {

		        	$client_expenses = $this->report_model->getClientExpenses( $client_id, $report_id, $term );
		    		if( $client_expenses && isset($client_expenses['expenses']) ) {
		            	$expenses = unserialize($client_expenses['expenses']);
		            } else {
		            	$expenses = $term1_expenses;
		            }

		        } else {
		        	$expenses = $term1_expenses;
		        }

		        if( isset($expenses['other']) ) {
		        	$otherExpenses = $expenses['other'];
		        } else {
		        	$otherExpenses = 0;
		        }

		    }

		    $this->data["expenses"] = $expenses;
		    $this->data["otherExpenses"] = $otherExpenses;

			$this->load->view('common/header', $this->data);
			$this->load->view('heap/clients/report_step_1', $this->data);
			$this->load->view('common/footer', $this->data);

		} else {
			print_r("Akash");
			$this->load->view("errors/html/error_404");
		}
	}

	public function reportStep2( $client_id, $report_id = 0, $term = 0 ) {

		$adviser_id = $this->client_model->getSingleColumn("adviser_id", "SELECT `adviser_id` from adviser_clients where client_id = '".(int)$client_id."'");

		if( $this->client_model->isAdviserClient($adviser_id, $client_id) ) {

			$params = array("id" => $client_id);
			$client = $this->client_model->heapGetClient( $params );
			$this->data["client"] = $client[0];
			$this->data["report_id"] = $report_id;
			$this->data["term"] = $term;

			$current_term = $term;

			/* DATA PROCESSING STARTS */
			$calc_data_dir = ASSETS_PATH."calc_data/";
			$session_expenses = $this->session->userdata("expenses");
			if( !is_array($session_expenses) || !is_array($session_expenses[$client_id]) ){
				/* DATA NOT SET */
				die("ERROR: Could not retrieve expenses!");
			}

			if( is_numeric($report_id) && is_numeric($term) ) {
        		$serialized_expenses = $session_expenses[$client_id][$report_id][$term];
    		} else {
        		$serialized_expenses = $session_expenses[$client_id][0][0];
    		}
    		$expenses = unserialize($serialized_expenses);
    		if(!is_array($expenses)) die("ERROR: Could not retrieve expenses! [2]");

    		// If saved report, get previously posted values & repopulate fields
		    if( is_numeric($report_id) && $report_id > 0 ) {
		    	$params = array("id" => $report_id);
		    	$reportData = $this->report_model->getReport( $params );
		    	if( $reportData ) {
		    		$reportData = $reportData[0];
		    		$this->data["POST"] = $POST = unserialize($reportData['POST']); // Original posted values
			        $current_term = $reportData['current_term'];

			        // Workaround for older data in database prior to latest update
			        if(empty($current_term) || $current_term < 1) {
			            $current_term = $POST['total_original_term_months'] - $POST['months_remaining_mortgage_term'] + 1;
			        }
		    	}
		    }

		    $total_m_expense = 0;
		    $total_monthly_expenses = 0;
		    $fixed_expenses_toHeloc = 0;
		    $fixed_expenses_payment_toHeloc = 0;
		    if(is_array($expenses['payments'])) {
		        foreach($expenses['payments'] as $exp_key => $expense) {
		            if(!empty($expense)) {
		                $expense = preg_replace( "/[\$\s,]/", '', $expense );

		                $total_m_expense += round($expense,2);
		                if(isset($expenses['addTo_heloc'][$exp_key]) && $expenses['addTo_heloc'][$exp_key] != 'true') {
		                    $total_monthly_expenses += round($expense,2);
		                } else {
		                    $x_bal = preg_replace( "/[\$\s,]/", '', $expenses['balance'][$exp_key]);
		                    $fixed_expenses_toHeloc += round($x_bal,2);

		                    $fixed_expenses_payment_toHeloc += $expense;
		                }
		            }
		        }

		        if(!is_numeric($fixed_expenses_toHeloc)) $fixed_expenses_toHeloc = '0';

		        if(is_array($expenses['other']['amount'])) {
		            foreach($expenses['other']['amount'] as $other_expenses) {
		                $other_expenses = preg_replace( "/[\$\s,]/", '', $other_expenses );
		              	if($other_expenses != '' && $other_expenses != null){
							$total_monthly_expenses += $other_expenses;
						}
		            }
		        }
		        $annual_exp = preg_replace( "/[\$\s,]/", '', $expenses['nonMonthly']['annual_amount'] );
		        $semi_exp = preg_replace( "/[\$\s,]/", '', $expenses['nonMonthly']['semi_amount'] );
		        $total_monthly_expenses += number_format($annual_exp/12,2);
		        $total_monthly_expenses += number_format($semi_exp/6,2);
		    }
		    $this->data["total_monthly_expenses"] = $total_monthly_expenses;

		    /* PROCESS STEP 2 Submission */
		    if( count($this->input->post()) > 0 ) {

		    	/* FIXES */
		    	$non_annual_expenses = 0;

		        $current_term = $this->input->post("total_original_term_months") - $this->input->post("months_remaining_mortgage_term") + 1;
		        $original_mort_balance = sprintf("%01.2f", $this->input->post("total_original_mortgage"));
		        $mort_principal = sprintf("%01.2f", empty($this->input->post("current_mortgage_balance")) ? $this->input->post("current_principal_balance") : $this->input->post("current_mortgage_balance"));
		        $mort_payment = sprintf("%01.2f", $this->input->post("mortgage_payment_monthly"));
		        $total_income = sprintf("%01.2f", $this->input->post("total_income"));
		        $interest_only = $this->input->post("interest_only") == "true" ? "true" : "false";
		        $expenses = $this->input->post("expenses");

		        // TODO: Need to determine firstSalaryDay for other salary types as well (monthly,weekly,etc)
		        if($this->input->post("income_bimonthly_1") && $this->input->post("income_knowdays1") == "yes") {
		            $bimonthly_salary = "true";
		            $first_salary_day = $this->input->post("day_paid1")[0];
		            $second_salary_day =  $this->input->post("day_paid1")[1];
		        } else {
		            $bimonthly_salary = 'false';
		            $first_salary_day = 15; // For now just use 15 as first salary day until it's decided what to do on form
		            $second_salary_day = 0;
		        }

		        $iteration = 1;

		        // If file already exists, increase iteration by 1 and rename file
		        while(file_exists($calc_data_dir.$client_id."-".$iteration.".txt")) {
		            $iteration++;
		        }
		        $calc_ouputFile = $client_id."-".$iteration.".txt";

		        // Usage : CalculatorApp
		        // MortgagePrincipal MortgageTerm MortgageInterestRate HelocAmount HelocStartTerm Salary BillAmount HelocInterestRate BimonthlySalary(True or False) FirstSalaryDay
		        // SecondSalaryDay(0 if not bimontly) BillPaymentDay MortgagePaymentDay InterestOnly(True or False) ConsolidatedDebt InputPayments(True or False)
		        // AddDebtToHeloc(True or False) PaymentFile ClientId IterationNo

		        // BillAmount = Monthly Expenses (variable expenses plus fixed expenses not paid by heloc)

		        // Calculate bill amount
		        $bill_amount = $expenses;

		        if($this->input->post("heloc_addto_consolidated") == "yes") {
		        	$add_debt_to_heloc = 'true';
		        } else {
		        	$add_debt_to_heloc = 'false';
		        }
		        $consolidated_debt = $fixed_expenses_toHeloc;

		        //$heap = new Heap();

		        // Run the calculator after we get the report_id

		        if($this->input->post("income_bimonthly_1") == "true") {
		            $income1 = $this->input->post("income1") * 2;
		            $income1_interval = "bimonthly";
		        } else {
		            $income1 = $this->input->post("income1");
		            $income1_interval = "monthly";
		        }

		        if($this->input->post("income_bimonthly_2") == "true") {
		            $income2 = $this->input->post("income2") * 2;
		            $income2_interval = "bimonthly";
		        } else {
		            $income2 = $this->input->post("income2");
		            $income2_interval = "monthly";
		        }

		        $income1 = $this->input->post("income_bimonthly_1") == "true" ? $this->input->post("income1") * 2 : $this->input->post("income1");
		        $income2 = $this->input->post("income_bimonthly_2") == "true" ? $this->input->post("income2") * 2 : $this->input->post("income2");

		        $income1 = sprintf("%01.2f",$income1);
		        $income2 = sprintf("%01.2f",$income2);
		        $non_annual_expenses = sprintf("%01.2f",$non_annual_expenses);

		        //$calcFile = str_replace('/home/heaplan/public_html/advisors_a/', '', $calc_data_dir.$calc_ouputFile);
		        $calcFile = str_replace(ASSETS_PATH, '', $calc_data_dir.$calc_ouputFile);

		        $params = array(
		            'client_id' => $client_id,
		            'calc_file' => $calcFile,
		            'original_mortgage_balance' => $original_mort_balance,
		            'mortgage_balance' => $mort_principal,
		            'mortgage_term' => $this->input->post('months_remaining_mortgage_term'),
		            'mortgage_rate' => $this->input->post('interest_rate_annual'),
		            'mortgage_payment' => $mort_payment,
		            'income1' => $income1,
		            'income1_interval' => $income1_interval,
		            'income2' => $income2,
		            'income2_interval' => $income2_interval,
		            'other_expenses' => $non_annual_expenses,
		            'est_mortgage_balance' => $this->input->post('current_principal_balance'),
		            'est_mortgage_payment' => $this->input->post('mortgage_payment_monthly'),
		            'heloc_amount' => $this->input->post('heloc_amount'),
		            'heloc_start_term' => $this->input->post('heloc_start_term'),
		            'heloc_rate' => $this->input->post('heloc_interest_rate'),
		            'est_market_value' => $this->input->post('est_market_value'),
		            'client_expenses' => $serialized_expenses,
		            'post' => serialize($this->input->post()),
		            'current_term' => $current_term
		        );


		        // If modifying saved report, update it, otherwise insert new
		        if( is_numeric($report_id) && $report_id > 0 ) {
		            $params['id'] = $report_id;


		            $updateReport = $this->report_model->updateReport( $params );

		            // Update Client Expenses table for current term
		            $params = array(
		                'expenses' => $serialized_expenses,
		                'client_id' => $client_id,
		                'report_id' => $report_id,
		                'term' => $current_term
		            );
		            $updateExpenses = $this->report_model->updateExpenses( $params );

		        } else {
		        	$report_id = $this->report_model->insertReport( $params );

		        	if( $report_id ) {
		        		$params = array(
			                'expenses' => $serialized_expenses,
			                'client_id' => $client_id,
			                'report_id' => $report_id,
			                'term' => $current_term,
			                "date_created" => date("Y-m-d H:i:s")
			            );
			            $insertExpense = $this->report_model->insertExpense( $params );
		        	}

		        }

		        // If  current term is smaller than original term, add line to payments file for starting term (original minus current) and current mortgage amount
		        if( $mort_principal != $original_mort_balance ) {

		        	$params = array(
		        					"client_id" => $client_id,
		        					"report_id" => $report_id,
		        					"term" => $current_term
		        					);
		        	$i = $this->report_model->getInputtextfile($params);
		            $i = $i[0];

		             // Insert/Update heaplan_inputtextfile table with updated values
		            if(empty($i['id'])) {
		                $params = array(
		                				"client_id" => $client_id,
		                				"report_id" => $report_id,
		                				"term" => $term,
		                				"mortgagebalance" => $mort_principal,
		                				"date_created" => date("Y-m-d H:i:s")
		                				);

		                $insert = $this->report_model->insertInputtextfile($params);
		            } else {
		            	$params = array(
		            					"id" => $i["id"],
		            					"mortgagebalance" => $mort_principal
		            					);
		            	$update = $this->report_model->updateInputtextfile( $params );

		            }

		            if( !$this->createPaymentFile($client_id, $report_id) )
		            	die("Error! Could not create payment file");

		        }

		        if( !$this->createPaymentFile($client_id, $report_id) )
		           	die("Error! Could not create payment file");

		        $payment_file = ASSETS_PATH."payment_files/pay-{$client_id}-{$report_id}.txt";

		        // Usage : CalculatorApp
		        // MortgagePrincipal MortgageTerm MortgageInterestRate HelocAmount HelocStartTerm Salary BillAmount HelocInterestRate BimonthlySalary(True or False) FirstSalaryDay
		        // SecondSalaryDay(0 if not bimontly) BillPaymentDay MortgagePaymentDay InterestOnly(True or False) ConsolidatedDebt InputPayments(True or False)
		        // AddDebtToHeloc(True or False) PaymentFile ClientId IterationNo

		        //$jarFilePath = realpath(dirname(__FILE__)."/../java_calc/");
		        $jarFilePath = ABSOLUTE_PATH."java_calc/";

		        if( !file_exists($jarFilePath) ) {
		        	die("ERROR: Missing jar file: CalculatorApp.jar");
		        }

		        //$calcFile = "/home/heaplan/jdk1.6.0_05/bin/java -jar {$jarFilePath}/CalculatorApp.jar";
		       $calcFile = "java"." -jar {$jarFilePath}CalculatorApp.jar";
		        $calc_values = array(round($original_mort_balance, 2),(int) $this->input->post('total_original_term_months'), round($this->input->post('interest_rate_annual'), 6),round($this->input->post('heloc_amount'), 2), (int) $this->input->post('heloc_start_term'), round($total_income, 2), round($bill_amount, 2), round($this->input->post('heloc_interest_rate'), 6), round($bimonthly_salary, 2), (int) $first_salary_day, (int) $second_salary_day, (int) $this->input->post('expenses_payment_date'), (int) $this->input->post('mortgage_due_date'), $interest_only, round($consolidated_debt,2), 'true', $add_debt_to_heloc, $payment_file, $client_id, $iteration);

		        $java_calc_string = $calcFile." ".implode(" ",$calc_values);

		        $execCalc = str_replace("CalculatorApp.jar","CalculatorApp_new.jar",$java_calc_string); // Replace this with $java_calc_string when ready for production

		        $params = array(
		        				"java_calc_string" => $java_calc_string,
		        				"report_id" => $report_id
		        				);
		        $updateString = $this->report_model->updateJavaCalcString( $params );

		        //echo $execCalc."<br/>";
		        exec($execCalc,$output,$return_var);
		        if(!empty($output))
		        	die("Unexpected error from CalculatorApp_new.jar:<br>Command Line: $execCalc<br> Output:".print_r($output,1));

		        $wait_count = 0;

		        while( !file_exists($calc_ouputFile) ) {
		            $wait_count++;
		            if($wait_count > 50) die('Output file not found<br/>'.$calc_ouputFile);
		            usleep(100000);
		        }
		        $moveNextPath = $calc_data_dir.$calc_ouputFile;
		        //echo $calc_ouputFile."<br/>";
		       	//echo $moveNextPath;
		        rename($calc_ouputFile, $moveNextPath);

		        while( !file_exists($moveNextPath) ) {
		            $wait_count++;
		            if($wait_count > 50) die('Output file move failed: '.$moveNextPath);
		            usleep(100000);
		        }

		        // Insert calculator output into database
		        if( !$this->outputToDB($client_id,$report_id,$moveNextPath) )
		        	die ("Error inserting calc output into database");

		        redirect("view-report/".$client_id."/".$report_id, "refresh");
		        exit;

		    }

		    $this->data["client_id"] = $client_id;
		    $this->data["current_term"] = $current_term;

			$this->load->view('common/header', $this->data);
			$this->load->view('heap/clients/report_step_2', $this->data);
			$this->load->view('common/footer', $this->data);

		} else {
			$this->load->view("errors/html/error_404");
		}
	}

	public function reportStep2_update( $client_id, $report_id = 0, $term = 0 ) {

		if( $this->client_model->isAdviserClient($this->adviser_id, $client_id) ) {

			$params = array("id" => $client_id);
			$client = $this->client_model->heapGetClient( $params );
			$this->data["client"] = $client[0];
			$this->data["report_id"] = $report_id;
			$this->data["term"] = $term;

			$current_term = $term;

			/* DATA PROCESSING STARTS */
			$calc_data_dir = ASSETS_PATH."calc_data/";
			$session_expenses = $this->session->userdata("expenses");
			if( !is_array($session_expenses) || !is_array($session_expenses[$client_id]) ){
				/* DATA NOT SET */
				die("ERROR: Could not retrieve expenses!");
			}

			if( is_numeric($report_id) && is_numeric($term) ) {
        		$serialized_expenses = $session_expenses[$client_id][$report_id][$term];
    		} else {
        		$serialized_expenses = $session_expenses[$client_id][0][0];
    		}
    		$new_expenses = unserialize($serialized_expenses);
    		if(!is_array($new_expenses)) die("ERROR: Could not retrieve expenses! [2]");

    		$total_monthly_expenses = 0;

		    $new_exp = $this->calcMonthlyExpenses($new_expenses);
		    $total_new_monthly_expenses = $new_exp['total_monthly_expenses'];

    		// If saved report, get previously posted values & repopulate fields
		    if( is_numeric($report_id) && $report_id > 0 ) {
		    	$params = array("id" => $report_id);
		    	$reportData = $this->report_model->getReport( $params );
		    	if( $reportData ) {
		    		$reportData = $reportData[0];
		    		$this->data["POST"] = $POST = unserialize($reportData['POST']); // Original posted values
		    		$java_calc_string = $reportData['java_calc_string'];
			        $current_term = $reportData['current_term'];

			        // Workaround for older data in database prior to latest update
			        if(empty($current_term) || $current_term < 1) {
			            $current_term = $POST['total_original_term_months'] - $POST['months_remaining_mortgage_term'] + 1;
			        }
		    	}

		    	$curExpenses = $this->report_model->getClientExpenses2( $client_id, $report_id, $current_term );
		    	$curExpenses = $curExpenses[0];
		    	$original_expenses = unserialize($curExpenses['expenses']);

        		$original_monthly_expenses = $this->calcMonthlyExpenses($original_expenses);
		        $total_original_monthly_expenses = $original_monthly_expenses['total_monthly_expenses'];
		    } else {
		    	die("Error: invalid report id");
		    }

		    $total_m_expense = 0;
		    $total_monthly_expenses = 0;
		    $fixed_expenses_toHeloc = 0;
		    $fixed_expenses_payment_toHeloc = 0;
		    $expenses = "";
		    $params = array(
        					"client_id" => $client_id,
        					"report_id" => $report_id,
        					"term" => $term
        					);
        	$i = $this->report_model->getInputtextfile2($params);
            $i = $i[0];

		    /* PROCESS STEP 2 Submission */
		    if( count($this->input->post()) > 0 ) {

		    	/* FIXES */
		    	$non_annual_expenses = 0;

		    	// Calculate Surplus
		        $original_income_total = $POST['total_income'];

		        $new_total_income = trim($this->input->post('u_total_income'));

		        if(empty($new_total_income))
		        	$surplus_income = $original_income_total;
		        else
		        	$surplus_income = $new_total_income;

		        $new_surplus = $surplus_income - $new_exp['total_payments'] + $POST['mortgage_payment_monthly'] + $new_exp['fixed_expenses_payment_toHeloc'] -
		                       $new_exp['total_other_expenses'] - $new_exp['nonmonthly_expenses'];

		        $new_surplus = round($new_surplus,2);

		        $iteration = 1;
		        // If file already exists, increase iteration by 1 and rename file
		        while(file_exists($calc_data_dir.$client_id."-".$iteration.".txt")) {
		            $iteration++;
		        }
		        $calc_ouputFile = $client_id."-".$iteration.".txt";

		        // Usage : CalculatorApp
		        // MortgagePrincipal MortgageTerm MortgageInterestRate HelocAmount HelocStartTerm Salary BillAmount HelocInterestRate BimonthlySalary(True or False) FirstSalaryDay
		        // SecondSalaryDay(0 if not bimontly) BillPaymentDay MortgagePaymentDay InterestOnly(True or False) ConsolidatedDebt InputPayments(True or False)
		        // AddDebtToHeloc(True or False) PaymentFile ClientId IterationNo

		        // BillAmount = Monthly Expenses (variable expenses plus fixed expenses not paid by heloc)

		        // Calculate bill amount
		        $bill_amount = $expenses;
		        //$bill_amount = $new_expenses;

		        if($this->input->post("heloc_addto_consolidated") == "yes") {
		        	$add_debt_to_heloc = 'true';
		        } else {
		        	$add_debt_to_heloc = 'false';
		        }
		        $consolidated_debt = $fixed_expenses_toHeloc;

		        $params = array(
	        					"client_id" => $client_id,
	        					"report_id" => $report_id,
	        					"term" => $term
	        					);
	        	$i = $this->report_model->getInputtextfile2($params);
	            $i = $i[0];

	             // Insert/Update heaplan_inputtextfile table with updated values
	            if(empty($i['id'])) {
	                $params = array(
	                				"client_id" => $client_id,
	                				"report_id" => $report_id,
	                				"term" => $term,
	                				"total_income" => $this->input->post("u_total_income"),
	                				"mortgagebalance" => $this->input->post("u_mortgage_balance"),
	                				"helocbalance" => $this->input->post("u_heloc_balance"),
	                				"mortginterestrate" => $this->input->post("u_mortgage_interest"),
	                				"helocpayment" => $new_surplus,
	                				"helocinterestrate" => $this->input->post("u_heloc_interest"),
	                				"date_created" => date("Y-m-d H:i:s")
	                				);
	                $insert = $this->report_model->insertInputtextfile($params);
	            } else {
	            	$params = array(
	            					"id" => $i["id"],
	            					"total_income" => $this->input->post("u_total_income"),
	            					"mortgagebalance" => $this->input->post("u_mortgage_balance"),
	            					"helocbalance" => $this->input->post("u_heloc_balance"),
	            					"mortginterestrate" => $this->input->post("u_mortgage_interest"),
	            					"helocpayment" => $new_surplus,
	            					"helocinterestrate" => $this->input->post("u_heloc_interest")
	            					);
	            	$update = $this->report_model->updateInputtextfile( $params );

	            }

	            if( !$this->createPaymentFile($client_id, $report_id) )
		           	die("Error! Could not create payment file");

		        $payment_file = ASSETS_PATH."payment_files/pay-{$client_id}-{$report_id}.txt";

		        // Replace the iteration number & payment file name on the original java calc string with the new calculated iteration number
		        // If old java calc input string, remove last 2 values, otherwise remove last 3
		        $java_calc_string_array = explode(" ",$java_calc_string);

		        if(count($java_calc_string_array) >= 22) {
		            array_pop($java_calc_string_array);
		        }

		        array_pop($java_calc_string_array);
		        array_pop($java_calc_string_array);

		        array_push($java_calc_string_array,$payment_file,$client_id,$iteration);
		        $java_calc_string = implode(" ",$java_calc_string_array);

		        $execCalc = str_replace("CalculatorApp.jar","CalculatorApp_new.jar",$java_calc_string); // Replace this with $java_calc_string when ready for production



		        exec($execCalc,$output,$return_var);
		        if(!empty($output))
		        	die("Unexpected error from CalculatorApp.jar - input({$execCalc}) ouput:".print_r($output,1));

		        $wait_count = 0;

		        while(!file_exists($calc_ouputFile)) {
		            $wait_count++;
		            if($wait_count > 50) die('Output file not found');
		            usleep(100000);
		        }
		        $moveNextPath = $calc_data_dir.$calc_ouputFile;
		        rename($calc_ouputFile, $moveNextPath);

		        while(!file_exists($moveNextPath)) {
		            $wait_count++;
		            if($wait_count > 50) die('Output file move failed: '.$calc_ouputFile);
		            usleep(100000);
		        }

		        $calcFile = str_replace(ASSETS_PATH, '', $calc_data_dir.$calc_ouputFile);
		        $params = array(
		        				"calc_file" => $calcFile,
		        				"java_calc_string" => $java_calc_string,
		        				"report_id" => $report_id,
		        				"client_id" => $client_id
		        				);
		        $updateReport2 = $this->report_model->updateReport2( $params );

		        $curExp = $this->report_model->getClientExpenses2($client_id, $report_id, $term);
		        if( !empty($curExp) ) {
		        	$curExp = $curExp[0];
		        	// Update Client Expenses table
		            $params = array(
		            				"expenses" => $serialized_expenses,
		            				"expense_id" => $curExp["id"]
		            				);
		            $updateExpenses2 = $this->report_model->updateExpenses2($params);
		        } else{
		        	// Insert/Update Client Expenses table
		            $params = array(
		            				"client_id" => $client_id,
		            				"report_id" => $report_id,
		            				"term" => $term,
		            				"expenses" => $serialized_expenses,
		            				"date_created" => date("Y-m-d H:i:s")
		            				);
		            $insertExpense = $this->report_model->insertExpense($params);
		        }

		        // Insert calculator output into database
		        if( !$this->outputToDB($client_id,$report_id,$moveNextPath) )
		        	die ("Error inserting calc output into database");

		        redirect("view-report/".$client_id."/".$report_id, "refresh");
		        exit;

		    }

		    $this->data["client_id"] = $client_id;
		    $this->data["current_term"] = $current_term;
		    $this->data["total_monthly_expenses"] = $total_monthly_expenses;
		    $this->data["total_original_monthly_expenses"] = $total_original_monthly_expenses;
		    $this->data["total_new_monthly_expenses"] = $total_new_monthly_expenses;
		    $this->data["i"] = $i;

			$this->load->view('common/header', $this->data);
			$this->load->view('heap/clients/report_step_2_update', $this->data);
			$this->load->view('common/footer', $this->data);

		} else {
			$this->load->view("errors/html/error_404");
		}
	}

	public function viewReport( $client_id, $report_id, $term = "" ) {
		
		$params = array("id" => $report_id);
		$report = $this->report_model->getReport( $params );

		if( $report ) {
			$this->data["report"] = $report[0];
			$adviser_id = $this->client_model->getSingleColumn("adviser_id", "SELECT `adviser_id` from adviser_clients where client_id = '".(int)$client_id."'");
			if( $this->client_model->isAdviserClient($adviser_id, $client_id) ) {
				/* GET ADVISER */
				$adviser = $this->client_model->heapGetAdviser( array("id" => $this->adviser_id) );
				$adviser = $adviser[0];

				/* GET EMAIL SETTINGS */
				$adviser11 = $this->client_model->getAdviserEmailSetting( $this->adviser_id );

				/* GET REPORT */
				$rep = $this->report_model->getReport( array("id" => $report_id) );
				$rep = $rep[0];
				$original_post = unserialize($rep['POST']);

				/*CALCULATIONS*/
				$current_term = $rep['current_term']; // The original current term
			    $original_mortgage_balance = $rep['original_mortgage_balance'];
			    $total_original_term_months = $original_post['total_original_term_months'];
			    if( isset($original_post['heloc_addto_consolidated']) ) {
			    	$heloc_addto_consolidated = $original_post['heloc_addto_consolidated'];
			    } else {
			    	$heloc_addto_consolidated = "";
			    }

			    $heloc_start_term = $rep['heloc_start_term'];

			    $term_remaining = $total_original_term_months - $current_term;

			    $exp = unserialize($rep['client_expenses']);

    			$other_expenses = 0;
			    if(is_array($exp['other']['amount'])) {
			        foreach($exp['other']['amount'] as $o_exp) {
						if($o_exp != ''){
							$other_expenses += preg_replace( "/[\$\s,]/", '', $o_exp );
						}
			        }
			    } else {
			    	$other_expenses = 0;
			    }
			    $fixed_expenses_toHeloc = 0;
			    $fixed_expenses_payment_toHeloc = 0;
			    if(is_array($exp['balance'])) {
			        foreach($exp['balance'] as $exp_key => $exp_val) {
			            if(!empty($exp_val)) {
			                if(isset($exp['addTo_heloc'][$exp_key]) && $exp['addTo_heloc'][$exp_key] == 'true') {
			                    $exp_val = preg_replace( "/[\$\s,]/", '', $exp_val );
			                    $fixed_expenses_toHeloc += round($exp_val,2);

			                    $fx_pay = preg_replace( "/[\$\s,]/", '', $exp['payments'][$exp_key] );
			                    $fixed_expenses_payment_toHeloc += round($fx_pay,2);
			                }
			            }
			        }
			    }
			    $annual_expenses = preg_replace( "/[\$\s,]/", '', $exp['nonMonthly']['annual_amount'] );
			    $semi_expenses = preg_replace( "/[\$\s,]/", '', $exp['nonMonthly']['semi_amount'] );
			    $nonmonthly_expenses = number_format($annual_expenses/12,2);
			    $nonmonthly_expenses += number_format($semi_expenses/6,2);
			    if (strpos($rep['calc_file'], 'assets') !== false) {
					$calc_file = file($rep['calc_file']);
				}else{
			    	if( file_exists(ASSETS_PATH.$rep['calc_file']) )
			    		$calc_file = file(ASSETS_PATH.$rep['calc_file']);
					else
						$calc_file = file($_SERVER['DOCUMENT_ROOT']."/advisors_a/".$rep['calc_file']);
				}
			    $total_interest_paid = 0;
			    $total_debt_paid = 0;
			    $year = 0;
			    $total_debt_paid_year = 0;
			    $heloc_total_months = 0;
			    $total_heloc_interest_paid = 0;
			    $summary = array();
			    $avg_heloc_interest_paid_first_year = 0;

			    $get_principle_nextline = "";
			    $prior_month_mort_balance = 0;
			    $start_2nd_avg_month = 0;
			    $start_2nd_avg = "";
			    $heloc_interest_paid_2 = 0;
			    $avg_heloc_interest_paid_2 = 0;

			    foreach($calc_file as $key => $value) {
			        if($key == 0 || $key == 1) continue;
			        if(substr($value,0,5) == "Total") break;



			        // Check report date & use the updated jar file if after 6/13/2008 (columns changed after that date)
			        if(strtotime($rep['creation_date']) > strtotime('6/13/2008'))
			            list($month,$mort_balance,$mort_principle,$mort_int,$mort_tot,$HBal,$HWithdrawn,$Hprinc,$HInt,$HTotal) = explode(" : ",trim($value));
			        else
			            list($month,$mort_balance,$mort_principle,$mort_int,$mort_tot,$HBal,$Hprinc,$HInt,$HTotal) = explode(" : ",trim($value));

			        if($month < $heloc_start_term) continue;
			        $heloc_total_months++;


			        $total_interest_paid += $mort_int + $HInt;
			        $total_debt_paid += $mort_principle + $Hprinc;

			        $total_heloc_interest_paid += $HInt;

			        if($get_principle_nextline) {
			            $summary[$year]['mort_balance_calc'] = $mort_balance;
			            $get_principle_nextline = false;
			        }

			        if($month % 12 == 0) {
			            $year++;
			            if( !isset($summary[$year]) ) {
			            	$summary[$year] = array();
			            }
			            if( isset($summary[$year]['total_interest']) ) {
			            	$summary[$year]['total_interest'] += $total_interest_paid;
			            } else {
			            	$summary[$year]['total_interest'] = $total_interest_paid;
			            }
			            if( isset($summary[$year]['total_debt1']) ) {
			            	$summary[$year]['total_debt1'] += $total_debt_paid;
			            } else {
			            	$summary[$year]['total_debt1'] = $total_debt_paid;
			            }

			            $summary[$year]['mort_balance'] = $mort_balance;

			            // Another Alternate method for calculating debt paid
			            if( isset($summary[$year]['total_debt2']) ){
			            	$summary[$year]['total_debt2'] += $rep['mortgage_balance'] - $mort_balance;
			            } else {
			            	$summary[$year]['total_debt2'] = $rep['mortgage_balance'] - $mort_balance;
			            }

			            $get_principle_nextline = true;
			        }

			        if($month == $heloc_start_term + 12) {
			        	$avg_heloc_interest_paid_first_year = $total_heloc_interest_paid / 12;
			        }

			        // Get avg heloc interest for year after consolidated debt is paid off
			        if($fixed_expenses_toHeloc > 0) {
			            if($start_2nd_avg && $month <= $start_2nd_avg_month + 12) $heloc_interest_paid_2 += $HInt;
			            if($month > $start_2nd_avg_month + 12) $avg_heloc_interest_paid_2 = $heloc_interest_paid_2 / 12;
			            if($month > 1 && $HWithdrawn > 0 && !$start_2nd_avg) {
			                $start_2nd_avg = true;
			                $start_2nd_avg_month = $month;
			            }
			        } else {
			        	$avg_heloc_interest_paid_2 = $avg_heloc_interest_paid_first_year;
			        }

			        // Calculate total debt paid by determining the total principal paid off for mortgage for the year
			        if($month == 1)
			        	$prior_month_mort_balance = $mort_balance;
			        $total_debt_paid_year += $prior_month_mort_balance - $mort_balance;
			        $prior_month_mort_balance = $mort_balance;
			        if(($month - 1) % 12 == 0) {
			        	if( isset( $summary[$year]['total_debt'] ) ) {
			        		$summary[$year]['total_debt'] += $total_debt_paid_year;
			        	} else {
			        		$summary[$year]['total_debt'] = $total_debt_paid_year;
			        	}
			        }

			    }

			    if($month % 12 != 0) {
			        $year++;

			        if( !isset($summary[$year]) ) {
		            	$summary[$year] = array();
		            }
		            if( isset($summary[$year]['total_interest']) ) {
		            	$summary[$year]['total_interest'] += $total_interest_paid;
		            } else {
		            	$summary[$year]['total_interest'] = $total_interest_paid;
		            }
		            if( isset($summary[$year]['total_debt1']) ) {
		            	$summary[$year]['total_debt1'] += $total_debt_paid;
		            } else {
		            	$summary[$year]['total_debt1'] = $total_debt_paid;
		            }

		            $summary[$year]['mort_balance'] = $mort_balance;

		            // Another Alternate method for calculating debt paid
		            if( isset($summary[$year]['total_debt2']) ){
		            	$summary[$year]['total_debt2'] += $rep['mortgage_balance'] - $mort_balance;
		            } else {
		            	$summary[$year]['total_debt2'] = $rep['mortgage_balance'] - $mort_balance;
		            }
			    }
			    if( isset( $summary[$year]['total_debt'] ) ) {
	        		$summary[$year]['total_debt'] += $total_debt_paid_year;
	        	} else {
	        		$summary[$year]['total_debt'] = $total_debt_paid_year;
	        	}

			    // Temp solution to find heloc monthly payment
			    $heloc_payment_line = explode(" : ",$calc_file[3]);
			    if( isset($heloc_payment_line[8]) ) {
			    	$heloc_payment = $heloc_payment_line[8];
			    } else {
			    	$heloc_payment = 0;
			    }


			    // Original mortgage summary
			    $p_bal = $rep['mortgage_balance'];
			    $yr = 0;
			    $rowColor = null;
			    $last_year_mortgage = ceil($term_remaining/12);

			    $mort_summary_paid = false;
			    $last_line = false;
			    $total_mortgage_interest = 0;
			    $total_pr_paid = 0;
			    $mort_summary = array();

			    for($m = 1; $m <= $term_remaining; $m++) {
			        $int_paid = sprintf("%01.2f",$p_bal * $rep['mortgage_rate'] / 100 / 12);
			        $principle_paid = $rep['mortgage_payment'] - $int_paid;
			        $p_bal = $p_bal - $principle_paid;

			        $mort_summary_months[$m]['principle_paid'] = $principle_paid;
			        $mort_summary_months[$m]['interest_paid'] = $int_paid;
			        $mort_summary_months[$m]['principle_balance'] = $p_bal;


			        $total_mortgage_interest += $int_paid;
			        $total_pr_paid += $principle_paid;

			        if($p_bal <= 0) {
			            $last_line = true;
			            $p_bal = 0;
			            $total_pr_paid = $rep['mortgage_balance'];
			            if(!isset($final_mtg_summary_interest)) $final_mtg_summary_interest = $total_mortgage_interest;

			            $total_mortgage_interest = $final_mtg_summary_interest;
			        }

			        if($m % 12 == 0 || $m == $term_remaining) {
			            $yr++;
			            if($m == $term_remaining) {
			                $total_pr_paid = $total_pr_paid + $p_bal;
			                $p_bal = 0;
			            }


			            if(!$mort_summary_paid) {
			                $mort_summary[$yr]['principle_balance'] = $p_bal;
			                $mort_summary[$yr]['principle_paid'] = $total_pr_paid;
			                $mort_summary[$yr]['total_interest'] = $total_mortgage_interest;
			            } else {
			                $mort_summary[$yr]['principle_balance'] = '0';
			                $mort_summary[$yr]['principle_paid'] = '0';
			                $mort_summary[$yr]['total_interest'] = '0';
			            }

			            if($last_line) {
			                $last_line = false;
			                $mort_summary_paid = true;
			            }
			        }
			    }
			    /*print_r($mort_summary_months);
			    exit;*/
			    $interest_saved = $total_mortgage_interest - $total_interest_paid;

			    // If payments file used, get data from selected term and use in 'current surplus' column
			    $display_current_term = false;
			    $term_total_income = 0;
			    $term_exp = 0;
			    if($term > $current_term) {

			        /*$data = array($client_id,$report_id,$term);
			        $types = array('integer','integer','integer');

			        $resultset =& $mdb2->Query("SELECT h.total_income,c.expenses FROM client_expenses as c,heaplan_inputtextfile as h
			                                    WHERE c.client_id=h.client_id AND c.report_id=h.report_id and c.term=h.term
			                                    AND c.client_id=? AND c.report_id=? AND c.term=?",'SELECT',$data,$types);
			        $row = $mdb2->FetchAssocRow($resultset);*/

			        $clientExpenses = $this->report_model->getClientExpenses( $client_id, $report_id, $term );
			        if( $clientExpenses ) {
			            $display_current_term = true;
			            $term_exp = $this->calcMonthlyExpenses(unserialize($clientExpenses['expenses']));
			            $term_total_income = $clientExpenses['total_income'];

			            if($term_total_income < 1) $term_total_income = $rep['income1'] + $rep['income2'];
			        }

			    }

			    $this->data["adviser"] = $adviser;
			    $this->data["adviser11"] = isset($adviser11[0]) ? $adviser11[0] : array();
			    $this->data["interest_saved"] = $interest_saved;
			    $this->data["rep"] = $rep;
			    $this->data["exp"] = $exp;
			    $this->data["display_current_term"] = $display_current_term;
			    $this->data["term"] = $term;
			    $this->data["term_total_income"] = $term_total_income;
			    $this->data["term_exp"] = $term_exp;
			    $this->data["other_expenses"] = $other_expenses;
			    $this->data["nonmonthly_expenses"] = $nonmonthly_expenses;
			    $this->data["heloc_addto_consolidated"] = $heloc_addto_consolidated;
			    $this->data["fixed_expenses_toHeloc"] = $fixed_expenses_toHeloc;
			    $this->data["avg_heloc_interest_paid_first_year"] = $avg_heloc_interest_paid_first_year;
			    $this->data["avg_heloc_interest_paid_2"] = $avg_heloc_interest_paid_2;
			    $this->data["fixed_expenses_payment_toHeloc"] = $fixed_expenses_payment_toHeloc;
			    //$this->data["monthly_surplus_with_heap"] = $monthly_surplus_with_heap;
			    $this->data["mort_summary"] = $mort_summary;
			    $this->data["last_year_mortgage"] = $last_year_mortgage;
			    $this->data["summary"] = $summary;
			    $this->data["term_remaining"] = $term_remaining;
			    $this->data["heloc_total_months"] = $heloc_total_months;
			    $this->data["total_interest_paid"] = $total_interest_paid;
			    $this->data["interest_saved"] = $interest_saved;
			    $this->data["calc_file"] = $calc_file;
			    $this->data["debug"] = false;

			    $this->data["monthly_expenses"] = 0;
			    $this->data["monthly_surplus_with_heap"] = 0;

			    $this->data["client_id"] = $client_id;
			    $this->data["report_id"] = $report_id;
			    $this->load->view('common/header', $this->data);
				$this->load->view('heap/clients/view_report', $this->data);
				$this->load->view('common/footer', $this->data);

			} else {
				$this->load->view("errors/html/error_404");
			}

		} else {
			$this->load->view("errors/html/error_404");
		}

	}

	public function saveChart() {
		$filename     	= $this->input->post('filename');
		$filename		= ASSETS_PATH."graphs/".$filename;
	    $src     		= $this->input->post('src');
	    $src     		= substr($src, strpos($src, ",") + 1);
	    $decoded 		= base64_decode($src);


	    $fp = fopen($filename,'wb');
	    fwrite($fp, $decoded);
	    fclose($fp);
	}

	public function downloadReport( $client_id = 0, $report_id = 0, $term = "" ) {
		$this->load->library("Pdf");
		$this->load->library("financials");

        // create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set font
		$pdf->SetFont('helvetica', 'B', 20);

		// add a page
		$pdf->AddPage();

		$pdf->SetFont('helvetica', '', 8);

		/*REPORT STARTS*/
	    //require_once(ASSETS_PATH.'/php-bin/phpswf_charts/charts.php');
	    //require_once("heap.class.php");
	    if( $report_id > 0 ) {
	    	$params = array("id" => $this->adviser_id);
	    	$adviser = $this->client_model->heapGetAdviser( $params );
	    	$adviser11 = $this->client_model->getAdviserEmailSetting( $this->adviser_id );
	    	$adviser11 = isset($adviser11[0]) ? $adviser11[0] : array();
	    	if( $adviser ) {
	    		$adviser = $adviser[0];
	    		if( $this->client_model->isAdviserClient($this->adviser_id, $client_id) ) {

	    			/*FIXES*/
	    			$other_expenses = 0;
	    			$fixed_expenses_payment_toHeloc = 0;
	    			$total_heloc_interest_paid = 0;
	    			$get_principle_nextline = 0;
	    			$summary = array();
	    			$start_2nd_avg_month = 0;
			    	$start_2nd_avg = "";
			    	$heloc_interest_paid_2 = 0;
			    	$prior_month_mort_balance = 0;
			    	$heloc_interest_paid_2 = 0;
			    	$total_mortgage_interest = 0;
			    	$total_pr_paid = 0;
			    	$mort_summary_paid = 0;
			    	$display_current_term = false;

	    			$params = array("id" => $report_id);
	    			$rep = $this->report_model->getReport( $params );
	    			$rep = $rep[0];

	    			$original_post = unserialize($rep['POST']);

				    $current_term = $rep['current_term']; // The original current term
				    $original_mortgage_balance = $rep['original_mortgage_balance'];
				    $total_original_term_months = $original_post['total_original_term_months'];
				    $heloc_addto_consolidated = isset($original_post['heloc_addto_consolidated']) ? $original_post['heloc_addto_consolidated'] : "";
				    $heloc_start_term = $rep['heloc_start_term'];

				    $term_remaining = $total_original_term_months - $current_term; // Term months remaining from start of original current term

				    $exp = unserialize($rep['client_expenses']);

				    if(is_array($exp['other']['amount'])) {
				        foreach($exp['other']['amount'] as $o_exp) {
							if($o_exp != ''){
								$other_expenses += preg_replace( "/[\$\s,]/", '', $o_exp );
							}
				        }
				    } else {
				    	$other_expenses = 0;
				    }

				    $fixed_expenses_toHeloc = 0;

				    if(is_array($exp['balance'])) {
				        foreach($exp['balance'] as $exp_key => $exp_val) {
				            if(!empty($exp_val)) {
				                if(isset($exp['addTo_heloc'][$exp_key]) && $exp['addTo_heloc'][$exp_key] == 'true') {
				                    $exp_val = preg_replace( "/[\$\s,]/", '', $exp_val );
				                    $fixed_expenses_toHeloc += round($exp_val,2);

				                    $fx_pay = preg_replace( "/[\$\s,]/", '', $exp['payments'][$exp_key] );
				                    $fixed_expenses_payment_toHeloc += round($fx_pay,2);
				                }
				            }
				        }
				    }
				    $annual_expenses = preg_replace( "/[\$\s,]/", '', $exp['nonMonthly']['annual_amount'] );
				    $semi_expenses = preg_replace( "/[\$\s,]/", '', $exp['nonMonthly']['semi_amount'] );
				    $nonmonthly_expenses = number_format($annual_expenses/12,2);
				    $nonmonthly_expenses += number_format($semi_expenses/6,2);

					$graphFileName = $rep['calc_file'];
					// ../mortgage-parole/calc_data/924-4.txt
					$graphFileName = str_replace("calc_data/","",$graphFileName);
					$graphFileName = str_replace("../mortgage-parole/","",$graphFileName);
					$graphFileName = str_replace(".txt",".png",$graphFileName);

					/*if ( !file_exists($rep['calc_file']) )
						$rep['calc_file'] = "../mortgage-parole/" . $rep['calc_file'];

				    $calc_file = file($rep['calc_file']);
					*/

					if (strpos($rep['calc_file'], 'advisors_a') !== false) {
						$calc_file = file($rep['calc_file']);
					}else{
				    	$calc_file = file(ASSETS_PATH.$rep['calc_file']);
					}
				    $total_interest_paid = 0;
				    $total_debt_paid = 0;
				    $year = 0;
				    $total_debt_paid_year = 0;
				    $heloc_total_months = 0;
				    $last_line = false;
				    $avg_heloc_interest_paid_first_year = 0;
				    $avg_heloc_interest_paid_2 = 0;

				    foreach($calc_file as $key => $value) {
				        if($key == 0 || $key == 1) continue;
				        if(substr($value,0,5) == "Total") break;

				        // Check report date & use the updated jar file if after 6/13/2008 (columns changed after that date)
				        if(strtotime($rep['creation_date']) > strtotime('6/13/2008'))
				            list($month,$mort_balance,$mort_principle,$mort_int,$mort_tot,$HBal,$HWithdrawn,$Hprinc,$HInt,$HTotal) = explode(" : ",trim($value));
				        else
				            list($month,$mort_balance,$mort_principle,$mort_int,$mort_tot,$HBal,$Hprinc,$HInt,$HTotal) = explode(" : ",trim($value));

				        if($month < $heloc_start_term) continue;
				        $heloc_total_months++;


				        $total_interest_paid += $mort_int + $HInt;
				        $total_debt_paid += $mort_principle + $Hprinc;

				        $total_heloc_interest_paid += $HInt;

				        if($get_principle_nextline) {
				            $summary[$year]['mort_balance_calc'] = $mort_balance;
				            $get_principle_nextline = false;
				        }

				        if($month % 12 == 0) {
				            $year++;
				            if( !isset($summary[$year]) ) {
				            	$summary[$year] = array();
				            }
				            if( isset($summary[$year]['total_interest']) ) {
				            	$summary[$year]['total_interest'] += $total_interest_paid;
				            } else {
				            	$summary[$year]['total_interest'] = $total_interest_paid;
				            }
				            if( isset($summary[$year]['total_debt1']) ) {
				            	$summary[$year]['total_debt1'] += $total_debt_paid;
				            } else {
				            	$summary[$year]['total_debt1'] = $total_debt_paid;
				            }

				            $summary[$year]['mort_balance'] = $mort_balance;

				            // Another Alternate method for calculating debt paid
				            if( isset($summary[$year]['total_debt2']) ){
				            	$summary[$year]['total_debt2'] += $rep['mortgage_balance'] - $mort_balance;
				            } else {
				            	$summary[$year]['total_debt2'] = $rep['mortgage_balance'] - $mort_balance;
				            }
				            $get_principle_nextline = true;
				        }


				        if($month == $heloc_start_term + 12) $avg_heloc_interest_paid_first_year = $total_heloc_interest_paid / 12;

				        // Get avg heloc interest for year after consolidated debt is paid off
				        if($fixed_expenses_toHeloc > 0) {
				            if($start_2nd_avg && $month <= $start_2nd_avg_month + 12) $heloc_interest_paid_2 += $HInt;
				            if($month > $start_2nd_avg_month + 12)
				            	$avg_heloc_interest_paid_2 = $heloc_interest_paid_2 / 12;
				            if($month > 1 && $HWithdrawn > 0 && !$start_2nd_avg) {
				                $start_2nd_avg = true;
				                $start_2nd_avg_month = $month;
				            }
				        }
				        else $avg_heloc_interest_paid_2 = $avg_heloc_interest_paid_first_year;

				        // Calculate total debt paid by determining the total principal paid off for mortgage for the year
				        if($month == 1) $prior_month_mort_balance = $mort_balance;
				        $total_debt_paid_year += $prior_month_mort_balance - $mort_balance;
				        $prior_month_mort_balance = $mort_balance;
				        if(($month - 1) % 12 == 0) {
				        	if( isset( $summary[$year]['total_debt'] ) ) {
				        		$summary[$year]['total_debt'] += $total_debt_paid_year;
				        	} else {
				        		$summary[$year]['total_debt'] = $total_debt_paid_year;
				        	}
				        }

				    }

				    if($month % 12 != 0) {
				        $year++;

				        if( !isset($summary[$year]) ) {
			            	$summary[$year] = array();
			            }
			            if( isset($summary[$year]['total_interest']) ) {
			            	$summary[$year]['total_interest'] += $total_interest_paid;
			            } else {
			            	$summary[$year]['total_interest'] = $total_interest_paid;
			            }
			            if( isset($summary[$year]['total_debt1']) ) {
			            	$summary[$year]['total_debt1'] += $total_debt_paid;
			            } else {
			            	$summary[$year]['total_debt1'] = $total_debt_paid;
			            }

			            $summary[$year]['mort_balance'] = $mort_balance;

			            // Another Alternate method for calculating debt paid
			            if( isset($summary[$year]['total_debt2']) ){
			            	$summary[$year]['total_debt2'] += $rep['mortgage_balance'] - $mort_balance;
			            } else {
			            	$summary[$year]['total_debt2'] = $rep['mortgage_balance'] - $mort_balance;
			            }
				    }
				    if( isset( $summary[$year]['total_debt'] ) ) {
		        		$summary[$year]['total_debt'] += $total_debt_paid_year;
		        	} else {
		        		$summary[$year]['total_debt'] = $total_debt_paid_year;
		        	}

				    // Temp solution to find heloc monthly payment
				    $heloc_payment_line = explode(" : ",$calc_file[3]);
				    $heloc_payment = isset($heloc_payment_line[8]) ? $heloc_payment_line[8] : 0;

				    // Original mortgage summary
				    $p_bal = $rep['mortgage_balance'];
				    $yr = 0;
				    $rowColor = null;
				    $last_year_mortgage = ceil($term_remaining/12);
				    $mort_summary = array();

				    for($m = 1; $m <= $term_remaining; $m++) {
				        $int_paid = sprintf("%01.2f",$p_bal * $rep['mortgage_rate'] / 100 / 12);
				        $principle_paid = $rep['mortgage_payment'] - $int_paid;
				        $p_bal = $p_bal - $principle_paid;

				        $mort_summary_months[$m]['principle_paid'] = $principle_paid;
				        $mort_summary_months[$m]['interest_paid'] = $int_paid;
				        $mort_summary_months[$m]['principle_balance'] = $p_bal;


				        $total_mortgage_interest += $int_paid;
				        $total_pr_paid += $principle_paid;

				        if($p_bal <= 0) {
				            $last_line = true;
				            $p_bal = 0;
				            $total_pr_paid = $rep['mortgage_balance'];
				            if(!isset($final_mtg_summary_interest)) $final_mtg_summary_interest = $total_mortgage_interest;

				            $total_mortgage_interest = $final_mtg_summary_interest;
				        }

				        if($m % 12 == 0 || $m == $term_remaining) {
				            $yr++;
				            if($m == $term_remaining) {
				                $total_pr_paid = $total_pr_paid + $p_bal;
				                $p_bal = 0;
				            }

				            if(!$mort_summary_paid) {
				                $mort_summary[$yr]['principle_balance'] = $p_bal;
				                $mort_summary[$yr]['principle_paid'] = $total_pr_paid;
				                $mort_summary[$yr]['total_interest'] = $total_mortgage_interest;
				            } else {
				                $mort_summary[$yr]['principle_balance'] = '0';
				                $mort_summary[$yr]['principle_paid'] = '0';
				                $mort_summary[$yr]['total_interest'] = '0';
				            }

				            if($last_line) {
				                $last_line = false;
				                $mort_summary_paid = true;
				            }
				        }
				    }
				    /*print_r($mort_summary_months);
				    exit;*/
				    $interest_saved = $total_mortgage_interest - $total_interest_paid;

				    // If payments file used, get data from selected term and use in 'current surplus' column
				    if($term > $current_term) {

				    	$row = $this->report_model->getClientExpenses($client_id, $report_id, $term);
				    	if( $row ) {
				    		$row = $row[0];
				    		$display_current_term = true;
				            $term_exp = $this->calcMonthlyExpenses(unserialize($row['expenses']));
				            $term_total_income = $row['total_income'];

				            if($term_total_income < 1)
				            	$term_total_income = $rep['income1'] + $rep['income2'];
				    	}

				    }

				    $this->data["interest_saved"] = $interest_saved;
				    $this->data["fixed_expenses_payment_toHeloc"] = $fixed_expenses_payment_toHeloc;
				    $this->data["rep"] = $rep;
				    $this->data["exp"] = $exp;
				    $this->data["display_current_term"] = $display_current_term;
				    $this->data["nonmonthly_expenses"] = $nonmonthly_expenses;
				    $this->data["other_expenses"] = $other_expenses;
				    $this->data["heloc_total_months"] = $heloc_total_months;
				    $this->data["heloc_addto_consolidated"] = $heloc_addto_consolidated;
				    $this->data["fixed_expenses_toHeloc"] = $fixed_expenses_toHeloc;
				    $this->data["avg_heloc_interest_paid_first_year"] = $avg_heloc_interest_paid_first_year;
				    $this->data["avg_heloc_interest_paid_2"] = $avg_heloc_interest_paid_2;
				    $this->data["mort_summary"] = $mort_summary;
				    $this->data["term_remaining"] = $term_remaining;
				    $this->data["last_year_mortgage"] = $last_year_mortgage;
				    $this->data["summary"] = $summary;
				    $this->data["total_interest_paid"] = $total_interest_paid;
				    $this->data["adviser"] = $adviser;
				    $this->data["adviser11"] = $adviser11;
				    $this->data["graphFileName"] = $graphFileName;

				    /* $this->load->view('heap/clients/report_pdf', $this->data); */

				    $pdf_content = $this->load->view('heap/clients/report_pdf', $this->data, true);
				    $pdf->writeHTML($pdf_content, true, false, false, false, '');
					$pdf->Output('Report_'.$report_id.'.pdf', 'D');
	    		}
	    	} else {
	    		$this->load->view("errors/html/error_404");
	    	}
	    } else {
	    	$this->load->view("errors/html/error_404");
	    }

	}

	public function delete( $client_id, $report_id ) {
		if( $this->client_model->isAdviserClient($this->adviser_id, $client_id) ) {
			$params = array(
							"client_id" => $client_id,
							"id" => $report_id
							);
			$report = $this->report_model->getReport( $params );
			if( $report ) {
				$report = $report[0];
				$deleteReport = $this->report_model->deleteReport( $client_id, $report_id );
				if( $deleteReport ) {
					$calc_file = $_SERVER['DOCUMENT_ROOT']."/heaplan/assets/".$report["calc_file"];
					if(	is_file($calc_file) )
						unlink($calc_file);

					$this->session->set_flashdata('success', 'Report deleted successfully!');
				} else {
					$this->session->set_flashdata('error', 'There is a problem processing your request!');
				}
				redirect("list-reports/".$client_id, "refresh");
			} else {
				$this->load->view("errors/html/error_404");
			}

		} else {
			$this->load->view("errors/html/error_404");
		}
	}

	public function calcMonthlyExpenses($expenses = array()) {
        $total_monthly_expenses = 0;
        $total_m_expense = 0;
        $fixed_expenses_payment_toHeloc = 0;
        $nonmonthly_expenses = 0;
        $total_other_expenses = 0;
        $fixed_expenses_toHeloc = 0;
        $annual_expenses = 0;
        $semi_expenses = 0;

        if(is_array($expenses['payments'])) {
            foreach($expenses['payments'] as $exp_key => $expense) {
                if(!empty($expense)) {
                    $expense = preg_replace( "/[\$\s,]/", '', $expense );

                    $total_m_expense += round($expense,2);
                    if($expenses['addTo_heloc'][$exp_key] != 'true') {
                        $total_monthly_expenses += round($expense,2);
                    } else {
                        $x_bal = preg_replace( "/[\$\s,]/", '', $expenses['balance'][$exp_key]);
                        $fixed_expenses_toHeloc += round($x_bal,2);

                        $fixed_expenses_payment_toHeloc += $expense;
                    }
                }
            }

            if(!is_numeric($fixed_expenses_toHeloc)) $fixed_expenses_toHeloc = '0';

            if(is_array($expenses['other']['amount'])) {
                foreach($expenses['other']['amount'] as $other_expenses) {
                    $other_expenses = preg_replace( "/[\$\s,]/", '', $other_expenses );
                    $total_monthly_expenses += $other_expenses;
                    $total_other_expenses += $other_expenses;
                }
            }
            $annual_exp = preg_replace( "/[\$\s,]/", '', $expenses['nonMonthly']['annual_amount'] );
            $semi_exp = preg_replace( "/[\$\s,]/", '', $expenses['nonMonthly']['semi_amount'] );
            $total_monthly_expenses += number_format($annual_exp/12,2);
            $total_monthly_expenses += number_format($semi_exp/6,2);

            $nonmonthly_expenses = number_format($annual_expenses/12,2);
            $nonmonthly_expenses += number_format($semi_expenses/6,2);
        }

        $expense = array();
        $expense['total_payments'] = $total_m_expense;
        $expense['fixed_expenses_payment_toHeloc'] = $fixed_expenses_payment_toHeloc;
        $expense['total_other_expenses'] = $total_other_expenses;
        $expense['nonmonthly_expenses'] = $nonmonthly_expenses;
        $expense['total_monthly_expenses'] = $total_monthly_expenses;

        return $expense;
    }

    public function createPaymentFile( $client_id, $report_id, $output_dir = 'payment_files', $file_basename = 'pay' ) {
        if(empty($report_id)) $report_id = 0;

        $data = array($client_id,$report_id);
        $types = array('integer','integer');

        $payment_file = ASSETS_PATH.$output_dir."/".$file_basename."-".$client_id."-".$report_id.".txt";

        $fh = fopen($payment_file,"w");

        // Write header row
        fwrite($fh,"TERM;MORTGAGEBALANCE;HELOCBALANCE;MORTGAGEINTERESTRATE;HELOCPAYMENT;HELOCINTERESTRATE\n");

        $params = array(
        				"client_id" => $client_id,
        				"report_id" => $report_id
        				);
        $fileData = $this->report_model->getFileData( $params );
        if( $fileData ) {
        	foreach( $fileData as $key => $value ) {
        		if(intval($value['mortgagebalance']) == 0) $value['mortgagebalance'] = null;
	            if(intval($value['helocbalance']) == 0) $value['helocbalance'] = null;
	            if(intval($value['mortginterestrate']) == 0) $value['mortginterestrate'] = null;
	            if(intval($value['helocpayment']) == 0) $value['helocpayment'] = null;
	            if(intval($value['helocinterestrate']) == 0) $value['helocinterestrate'] = null;
	            $line = implode(";",$value);

	            fwrite($fh,$line.";\n");
        	}
        }

        fclose($fh);

        if(file_exists($payment_file))
        	return true;
        else
        	return false;

    }

    // Insert calculator output into database - calcfile is full file path
    function outputToDB( $client_id, $report_id, $calcFile ) {

        $params = array(
        				"client_id" => $client_id,
        				"report_id" => $report_id
        				);
        $delete = $this->report_model->deleteOutput( $params );

        if(!file_exists($calcFile)) return false;

        $data = file($calcFile);
        foreach( $data as $key => $value ) {
            if( $key == 0 || $key == 1 ) continue;
            if( substr($value,0,5) == "Total" ) break;

            list($month, $mort_balance, $mort_principle, $mort_int, $mort_tot, $HBal, $HWithdrawn, $Hprinc, $HInt, $HTotal) = explode(" : ",trim($value));

            $params = array(
            				"client_id" => $client_id,
            				"report_id" => $report_id,
            				"monthnumber" => $month,
            				"mortgagebal" => $mort_balance,
            				"mortprincipalpaid" => $mort_principle,
            				"mortinterestpaid" => $mort_int,
            				"monthlymortgamt" => $mort_tot,
            				"helocbalance" => $HBal,
            				"helocwithdrawn" => $HWithdrawn,
            				"helocprincipalpaid" => $Hprinc,
            				"helocinterestpaid" => $HInt,
            				"totalhelocpaid" => $HTotal
            			);
            $insertOutput = $this->report_model->insertOutput( $params );
        }

        if( $insertOutput )
        	return true;
        else
        	return false;
    }

}
