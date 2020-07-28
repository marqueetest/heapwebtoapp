<?php
class Course_model extends CI_Model {

        function __construct(){
                $this->load->database();
        }

        public function getCourses( $params = array() ) {
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
                $query = "SELECT * FROM `ep_courses` ".$where." ORDER BY `created_datetime` DESC";
                $result = $this->db->query( $query );
                if( $result->num_rows() > 0 ) {
                        return $result->result_array();
                } else {
                        return array();
                }
        }

}
?>