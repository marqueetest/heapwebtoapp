<?php
class Grade_model extends CI_Model {

        function __construct(){
                $this->load->database();
        }

        public function listGrades( $params = array() ) {
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
                $query = "SELECT * FROM `ep_classes` ".$where." ORDER BY `created_datetime` DESC";
                $result = $this->db->query( $query );
                if( $result->num_rows() > 0 ) {
                        return $result->result_array();
                } else {
                        return array();
                }
        }

        public function registerGrade( $params = array() ) {
                $query = "INSERT INTO `ep_classes` (`title`, `description`, `status`, `created_datetime`, `updated_datetime`) VALUES('".$params['title']."', '".$params['description']."', '".$params['status']."', '".$params['created_datetime']."', '".$params['updated_datetime']."')";
                $result = $this->db->query( $query );
                if( $result ) {
                        return true;
                } else {
                        return false;
                }
        }

        public function deleteGrade( $grade_id ) {
                $query = "DELETE FROM `ep_classes` WHERE `id` = '".$grade_id."'";
                $result = $this->db->query( $query );
                if( $result ) {
                        return true;
                } else {
                        return false;
                }
        }

}
?>