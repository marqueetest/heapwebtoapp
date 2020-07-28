<?php
class User_model extends CI_Model {

    function __construct(){
        $this->load->database();
    }

    public function isUserExist( $username ) {
        $query = "SELECT * FROM `ep_users` WHERE `email` = '".$username."' OR `username` = '".$username."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
                return $result->result_array();
        } else {
                return false;
        }
    }

    public function validateLogin( $username, $password ) {
        $query = "SELECT advisers.*, adviser_cgroups.cgroup_id FROM advisers
                        Inner Join adviser_cgroups ON adviser_cgroups.adviser_id=advisers.id
                        WHERE advisers.username = '".$username."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    // client start
    // cleint login
    public function validateClientLogin( $username, $password ) {

        $query ="SELECT clients.* FROM clients
        Inner Join client_cgroups ON client_cgroups.client_id=clients.id AND client_cgroups.cgroup_id
        WHERE clients.username = '".$username."'";  
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function getSingleColumn($column,$sql){
	    $res = mysql_query($sql);
	    if ( $row = mysql_fetch_assoc($res) )
		    return $row[$column];
    }

    // client end

    public function impersonateLogin( $adviser_id ) {
        $query = "SELECT advisers.*, adviser_cgroups.cgroup_id FROM advisers
                        Inner Join adviser_cgroups ON adviser_cgroups.adviser_id=advisers.id
                        WHERE advisers.id = '".$adviser_id."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function getAdviserPermissions( $adviser_id ) {
        $query = "SELECT * FROM `adviser_from` WHERE `adviser_id` = '".$adviser_id."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
                return $result->result_array();
        } else {
                return false;
        }
    }

    public function addLoginHistory( $user_id ) {
        $query = "INSERT INTO `ep_login_history` (`user_id`, `ip`, `login_datetime`) VALUES('".$user_id."', '', '".date('Y-m-d H:i:s')."')";
        $result = $this->db->query( $query );
    }

    public function registerUser( $register_data ) {

        $query = "INSERT INTO `ep_users` (`first_name`, `last_name`, `cnic`, `gender`, `dob`, `contact`, `address`, `username`, `email`, `password`, `status`, `user_type`, `created_datetime`, `updated_datetime`) VALUES('".$register_data['first_name']."', '".$register_data['last_name']."', '".$register_data['cnic']."', '".$register_data['gender']."', '".$register_data['dob']."', '".$register_data['contact']."', '".$register_data['address']."', '".$register_data['username']."', '".$register_data['email']."', '".md5($register_data['password'])."', '".$register_data['status']."', '".$register_data['user_type']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
        $result = $this->db->query( $query );
        if( $result ) {
                return true;
        } else {
                return false;
        }
    }

    public function getUsers( $params = array() ) {
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
        $query = "SELECT * FROM `ep_users` ".$where." ORDER BY `created_datetime` DESC";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
                return $result->result_array();
        } else {
                return array();
        }
    }

}
?>
