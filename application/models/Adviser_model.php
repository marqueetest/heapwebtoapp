<?php
class Adviser_model extends CI_Model {

    function __construct(){
        $this->load->database();
    }

    public function heapGetAdviser( $params = array() ) {
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
        $query = "SELECT * FROM `advisers` ".$where." ORDER BY `id` DESC";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
                return $result->result_array();
        } else {
                return false;
        }
    }

    // changed
    public function updateAdviser($params, $adviser_id ) {
        $set = "";
        if( !empty($params) ) {
                $counter = 1;
                $count = 1;
                foreach( $params as $key => $val ) {
                        $set .= $key." = "."'".$val."'";
                        if($count == 1){
                            $set .= ',';
                        }
                        $count++;
                    // if( $counter != count( $params ) ) {
                    //         $where .= ", ";
                    //         $counter++;
                    // }
                }

        }
        $query = "UPDATE `advisers` SET ".$set." WHERE `id` = '".$adviser_id."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

}
?>