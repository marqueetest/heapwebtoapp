<?php
class Coupon_model extends CI_Model {

    function __construct(){
        $this->load->database();
    }

    public function getCoupons( $params = array(), $coupon_id = 0 ) {
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

        if( $coupon_id != 0 ) {
            if( $where == "" )  {
                $where .= " WHERE `id` != '".$coupon_id."'";
            } else {
                $where .= " AND `id` != '".$coupon_id."'";
            }
        }

        $query = "SELECT * FROM `adviser_coupon_codes` ".$where." ORDER BY `create_date` DESC";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return array();
        }
    }

    public function listCoupons( $adviser_id ) {
        $query = "SELECT *, IF(coupon_limit = '0', '<span style=\"color:green\">No Limit</span>', coupon_limit) as used_limit FROM `adviser_coupon_codes` WHERE `adviser_id` = '".$adviser_id."' ORDER BY `id` DESC";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function addCoupon( $data ) {
        $query =  "INSERT INTO `adviser_coupon_codes` (`adviser_id`, `coupon_code`, `create_date`, `is_active`) values ('".$data["adviser_id"]."', '".$data["coupon_code"]."', '".$data["created_date"]."' , '".$data["is_active"]."')";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function updateCoupon( $data ) {
        $query = "UPDATE `adviser_coupon_codes` SET `coupon_code` = '".$data["coupon_code"]."', `is_active` = '".$data["is_active"]."' WHERE `id` = '".$data["coupon_id"]."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function getCouponLimit( $adviser_id ) {
        $query = "SELECT `coupon_limit` FROM `advisers` WHERE `id` = '".$adviser_id."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            $response = $result->result_array();
            return $response[0]["coupon_limit"];
        } else {
            return false;
        }
    }

    public function getCouponCount( $adviser_id ) {
        $query = "SELECT COUNT(*) as coupon_count FROM `adviser_coupon_codes` WHERE `adviser_id` = '".$adviser_id."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            $response = $result->result_array();
            return $response[0]["coupon_count"];
        } else {
            return false;
        }
    }

    public function deleteCoupon( $coupon_id ) {
        $query = $this->db->where(array("id" => $coupon_id));
        $result = $this->db->delete('adviser_coupon_codes');

        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function isAdviserCoupon( $adviser_id, $coupon_id ) {
        $query = "SELECT id FROM `adviser_coupon_codes` WHERE `adviser_id` = '".$adviser_id."' AND `id` = '".$coupon_id."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return true;
        } else {
            return false;
        }
    }

}
?>