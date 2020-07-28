<?php
class Report_model extends CI_Model {

    function __construct(){
        $this->load->database();
    }

    public function listReports( $client_id, $adviser_id ) {
        $response = array();
        $query1 = "SELECT `id`, `POST`, `current_term`, `creation_date`, `mortgage_term` FROM `heaplan_reports` WHERE `client_id` = '".$client_id."' ORDER BY creation_date DESC";
        $result1 = $this->db->query( $query1 );
        if( $result1->num_rows() > 0 ) {
            $reports = $result1->result_array();
            foreach( $reports as $report ) {
                $POST =  unserialize($report['POST']); // Original posted values
                $current_term = $report['current_term'];
                if(empty($current_term) || $current_term < 1) {
                    $current_term = $POST['total_original_term_months'] - $POST['months_remaining_mortgage_term'] + 1;
                }

                $mortgage_term_total = $report['mortgage_term'];

                $query2 = "SELECT `term`, `date_modified` FROM `heaplan_inputtextfile` WHERE `report_id` = '".$report["id"]."' AND `client_id` = '".$client_id."' ORDER BY date_modified DESC LIMIT 1";
                $result2 = $this->db->query( $query2 );
                if( $result2->num_rows() > 0 ) {
                    $u = $result2->result_array();
                    $u  =$u[0];

                    $report_updated_date = $u['date_modified'];
                    $last_term_updated = $u['term'];
                } else {
                    $report_updated_date = "";
                    $last_term_updated = "";
                }

                $query3 = "SELECT max(monthnumber) as `last_term` FROM `heaplan_output` WHERE `report_id` = '".$report["id"]."' AND `client_id` = '".$client_id."'";
                $result3 = $this->db->query($query3);
                $last_term = $result3->result_array();
                $last_term = $last_term[0];

                $mortgage_last_calc_term = $last_term['last_term'];

                $mtg_term_loop = $mortgage_last_calc_term > 0 ? $mortgage_last_calc_term : $mortgage_term_total;

                $report_created_date = date("m/d/Y",strtotime($report['creation_date']));
                $report_updated_date = empty($report_updated_date) ? null : date("m/d/Y",strtotime($report_updated_date));

                if(empty($mtg_term_loop) || $mtg_term_loop == 0)
                    $mtg_term_loop = 1;

                $response[] = array(
                                    "id" => $report["id"],
                                    "POST" => $report["POST"],
                                    "mortgage_term" => $report["mortgage_term"],
                                    "creation_date" => $report["creation_date"],
                                    "report_created_date" => $report_created_date,
                                    "report_updated_date" => $report_updated_date,
                                    "last_term_updated" => $last_term_updated,
                                    "mtg_term_loop" => $mtg_term_loop,
                                    "current_term" => $current_term
                                    );
            }
            return $response;
        } else {
            return array();
        }

    }

    public function getReport( $params = array() ) {
        $where = "";
        if( !empty( $params ) ) {
            $counter = 1;
            $where .= " WHERE ";
            foreach( $params as $key => $val ) {
                    $where .= $key." = "."'".$val."'";
                    if( $counter != count( $params ) ) {
                            $where .= " AND ";
                            $counter++;
                    }
            }

        }
        $query = "SELECT * FROM `heaplan_reports` ".$where." ORDER BY `id` DESC";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
                return $result->result_array();
        } else {
                return false;
        }
    }

    public function getClientExpenses( $client_id, $report_id, $term ) {
        $query = "SELECT h.`total_income`, c.`expenses` FROM `client_expenses` as c, `heaplan_inputtextfile` as h WHERE c.`client_id` = h.`client_id` AND c.`report_id` = h.`report_id` AND c.`term` = h.`term` AND c.`client_id` = '".$client_id."' AND c.`report_id` = '".$report_id."' AND c.`term` = '".$term."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function getClientExpenses2( $client_id, $report_id, $term ) {
        $query = "SELECT * FROM client_expenses WHERE `client_id` = '".$client_id."' AND `report_id` = '".$report_id."' AND `term` = '".$term."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function insertExpense( $data ) {
        $query = "INSERT INTO `client_expenses` (`client_id`, `report_id`, `term`, `expenses`, `date_created`) VALUES('".$data["client_id"]."', '".$data["report_id"]."', '".$data["term"]."', '".$data["expenses"]."', '".$data["date_created"]."')";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function insertReport( $data ) {
        $query = "INSERT INTO `heaplan_reports` (`client_id`, `calc_file`, `original_mortgage_balance`, `mortgage_balance`, `mortgage_term`, `mortgage_rate`, `mortgage_payment`, `creation_date`, `income1`, `income1_interval`, `income2`, `income2_interval`, `other_expenses`, `est_mortgage_balance`, `est_mortgage_payment`, `heloc_amount`, `heloc_start_term`, `heloc_rate`, `est_market_value`, `client_expenses`, `POST`, `current_term`) VALUES('".$data["client_id"]."', '".$data["calc_file"]."', '".$data["original_mortgage_balance"]."', '".$data["mortgage_balance"]."', '".$data["mortgage_term"]."', '".$data["mortgage_rate"]."', '".$data["mortgage_payment"]."', NOW(), '".$data["income1"]."', '".$data["income1_interval"]."', '".$data["income2"]."', '".$data["income2_interval"]."', '".$data["other_expenses"]."', '".$data["est_mortgage_balance"]."', '".$data["est_mortgage_payment"]."', '".$data["heloc_amount"]."', '".$data["heloc_start_term"]."', '".$data["heloc_rate"]."', '".$data["est_market_value"]."', '".$data["client_expenses"]."', '".$data["post"]."', '".$data["current_term"]."')";
        $result = $this->db->query( $query );
        if( $result ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function updateReport( $data ) {
        $query = "UPDATE `heaplan_reports` SET `client_id` = '".$data["client_id"]."', `calc_file` = '".$data["calc_file"]."', `original_mortgage_balance` = '".$data["original_mortgage_balance"]."', `mortgage_balance` = '".$data["mortgage_balance"]."', `mortgage_term` = '".$data["mortgage_term"]."', `mortgage_rate` = '".$data["mortgage_rate"]."', `mortgage_payment` = '".$data["mortgage_payment"]."', `income1` = '".$data["income1"]."', `income1_interval` = '".$data["income1_interval"]."', `income2` = '".$data["income2"]."', `income2_interval` = '".$data["income2_interval"]."', `other_expenses` = '".$data["other_expenses"]."', `est_mortgage_balance` = '".$data["est_mortgage_balance"]."', `est_mortgage_payment` = '".$data["est_mortgage_payment"]."', `heloc_amount` = '".$data["heloc_amount"]."', `heloc_start_term` = '".$data["heloc_start_term"]."', `heloc_rate` = '".$data["heloc_rate"]."', `est_market_value` = '".$data["est_market_value"]."', `client_expenses` = '".$data["client_expenses"]."', `POST` = '".$data["post"]."', `current_term` = '".$data["current_term"]."' WHERE `id` = '".$data["id"]."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function updateReport2( $data ) {
        $query = "UPDATE `heaplan_reports` SET `calc_file` = '".$data["calc_file"]."', `java_calc_string` = '".$data["java_calc_string"]."' WHERE id = '".$data["report_id"]."' AND client_id = '".$data["client_id"]."'";
        $result = $this->db->query($query);
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    public function updateExpenses( $data ) {
        $query = "UPDATE `client_expenses` SET `expenses` = '".$data["expenses"]."' WHERE `client_id` = '".$data["client_id"]."' AND `report_id` = '".$data["report_id"]."' AND `term` = '".$data["term"]."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function updateExpenses2($data) {
        $query = "UPDATE `client_expenses` SET `expenses` = '".$data["expenses"]."' WHERE `id` = '".$data["expense_id"]."'";
        $result = $this->db->query($query);
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getInputtextfile( $data ) {
        $query = "SELECT `id` FROM `heaplan_inputtextfile` WHERE `client_id` = '".$data["client_id"]."' AND `report_id` = '".$data["report_id"]."' AND `term` = '".$data["term"]."' LIMIT 1";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function getInputtextfile2( $data ) {
        $query = "SELECT * FROM `heaplan_inputtextfile` WHERE `client_id` = '".$data["client_id"]."' AND `report_id` = '".$data["report_id"]."' AND `term` = '".$data["term"]."' LIMIT 1";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function insertInputtextfile( $data ) {
        $query = "INSERT INTO `heaplan_inputtextfile`(`client_id`, `report_id`, `term`, `mortgagebalance`, `date_created`) VALUES('".$data["client_id"]."', '".$data["report_id"]."', '".$data["term"]."', '".$data["mortgagebalance"]."', '".$data["date_created"]."')";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function insertInputtextfile2( $data ) {
        $query = "INSERT INTO `heaplan_inputtextfile` (`client_id`, `report_id`, `term`, `total_income`, `mortgagebalance`, `helocbalance`, `mortginterestrate`, `helocpayment`, `helocinterestrate`, `date_created` VALUES('".$data["client_id"]."', '".$data["report_id"]."', '".$data["term"]."', '".$data["total_income"]."', '".$data["mortgagebalance"]."', '".$data["helocbalance"]."', '".$data["mortginterestrate"]."', '".$data["helocpayment"]."', '".$data["helocinterestrate"]."', '".$data["date_created"]."')";
        $result = $this->db->query($query);
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    public function updateInputtextfile( $data ) {
        $query = "UPDATE `heaplan_inputtextfile` SET `mortgagebalance` = '".$data["mortgagebalance"]."' WHERE `id` = '".$data["id"]."'";
        $result = $this->db->query( $query );
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    public function updateInputtextfile2($data) {
        $query = "UPDATE `heaplan_inputtextfile` SET `total_income` = '".$data["total_income"]."', `mortgagebalance` = '".$data["mortgagebalance"]."', `helocbalance` = '".$data["helocbalance"]."', `mortginterestrate` = '".$data["mortginterestrate"]."', `helocpayment` = '".$data["helocpayment"]."', `helocinterestrate` = '".$data["helocinterestrate"]."' WHERE `id` = '".$data["id"]."'";
        $result = $this->db->query($query);
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getFileData( $data ) {
        $query = "SELECT `term`, `mortgagebalance`, `helocbalance`, `mortginterestrate`, `helocpayment`, `helocinterestrate` FROM `heaplan_inputtextfile` WHERE `client_id` = '".$data["client_id"]."' AND `report_id` = '".$data["report_id"]."' ORDER BY `term` ASC";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function getFileData2( $data ) {
        $query = "SELECT `term`, `date_modified` FROM `heaplan_inputtextfile` WHERE `client_id` = '".$data["client_id"]."' AND `report_id` = '".$data["report_id"]."' ORDER BY `date_modified` DESC LIMIT 1";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function getLastTerm( $data ) {
        $query = "SELECT max(monthnumber) as last_term FROM `heaplan_output` WHERE client_id = '".$data["client_id"]."' AND report_id = '".$report_id."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function updateJavaCalcString( $data ) {
        $query = "UPDATE `heaplan_reports` SET `java_calc_string` = '".$data["java_calc_string"]."' WHERE `id` = '".$data["report_id"]."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteOutput( $data ) {
        $query = "DELETE FROM `heaplan_output` WHERE `client_id` = '".$data["client_id"]."' AND `report_id` = '".$data["report_id"]."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function insertOutput( $data ) {
        $query = "INSERT INTO `heaplan_output`(`client_id`, `report_id`, `monthnumber`, `mortgagebal`, `mortprincipalpaid`, `mortinterestpaid`, `monthlymortgamt`, `helocbalance`, `helocwithdrawn`, `helocprincipalpaid`, `helocinterestpaid`, `totalhelocpaid`) VALUES('".$data["client_id"]."', '".$data["report_id"]."', '".$data["monthnumber"]."', '".$data["mortgagebal"]."', '".$data["mortprincipalpaid"]."', '".$data["mortinterestpaid"]."', '".$data["monthlymortgamt"]."', '".$data["helocbalance"]."', '".$data["helocwithdrawn"]."', '".$data["helocprincipalpaid"]."', '".$data["helocinterestpaid"]."', '".$data["totalhelocpaid"]."')";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteReport( $client_id, $report_id ) {
        $query = "DELETE FROM `heaplan_reports` WHERE `id` = '".$report_id."' AND `client_id` = '".$client_id."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function getClientExp( $client_id, $adviser_id ) {
        $query = "SELECT clients.* FROM clients, adviser_clients AS ac WHERE clients.id = '".$client_id."' AND ac.adviser_id = '".$adviser_id."' AND ac.client_id=clients.id";
        $result = $this->db->query($query);
        if($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

}
?>
