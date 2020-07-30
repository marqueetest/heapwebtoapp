<?php
class Client_model extends CI_Model {

    function __construct(){
            $this->load->database();
    }

    public function listHeapClients( $adviser_id ) {
        $query = "SELECT c.*,ac.coupon,IF(c.api_access_admin_controll = '0', '<span style=\"color:red\">Disable</span>', 'Enable') as api_access FROM clients c , adviser_clients ac WHERE c.id = ac.client_id AND ac.adviser_id = '".$adviser_id ."' ORDER by c.id DESC";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
                return $result->result_array();
        } else {
                return false;
        }
    }

    public function addClient( $params ) {

        $query1 = "INSERT INTO `clients` (`first_name`, `last_name`, `username`, `password`, `plain_password`, `phone`, `email_address`, `address1`, `address2`, `city`, `state`, `zipcode`, `api_access_admin_controll`, `created_date`) VALUES('".$params["first_name"]."', '".$params["last_name"]."', '".$params["username"]."', '".$params["password"]."', '".$params["plain_password"]."', '".$params["phone"]."', '".$params["email_address"]."', '".$params["address1"]."', '".$params["address2"]."', '".$params["city"]."', '".$params["state"]."', '".$params["zipcode"]."', '".$params["api_access_admin_controll"]."', '".$params["created_date"]."')";
        $result1 = $this->db->query( $query1 );
        if( $result1 ) {
            $client_id = $this->db->insert_id();

            $query2 = "INSERT INTO `adviser_clients` (`client_id`, `adviser_id`) VALUES('".$client_id."', '".$params["adviser_id"]."')";
            $result2 = $this->db->query( $query2 );

            $query3 = "INSERT INTO `client_cgroups` (`client_id`, `cgroup_id`) VALUES('".$client_id."', '1')";
            $result3 = $this->db->query( $query3 );

            return true;
        } else {
            return false;
        }
    }

    public function deleteClient( $client_id ) {
        $query1 = $this->db->where(array("id" => $client_id));
        $result1 = $this->db->delete('clients');

        $query2 = $this->db->where(array("client_id" => $client_id));
        $result2 = $this->db->delete('adviser_clients');

        $query2 = $this->db->where(array("client_id" => $client_id));
        $result2 = $this->db->delete('client_cgroups');

        if( $result1 ) {
            return true;
        } else {
            return false;
        }
    }

    public function heapUpdateClient( $params ) {
        if($params["password"] == '' || $params["confirm_password"] == '' ){
            $query1 = "UPDATE `clients` SET `first_name` = '" . $params["first_name"] . "', `last_name` = '" . $params["last_name"] . "', `username` = '" . $params["username"] . "', `phone` = '" . $params["phone"] . "', email_address = '" . $params["email_address"] . "', address1 = '" . $params["address1"] . "', address2 = '" . $params["address2"] . "', city = '" . $params["city"] . "', state = '" . $params["state"] . "', zipcode = '" . $params["zipcode"] . "', `api_access_admin_controll` = '" . $params["api_access_admin_controll"] . "' WHERE `id` = '".$params["client_id"]."'";
        }else{
            $query1 = "UPDATE `clients` SET `first_name` = '" . $params["first_name"] . "', `last_name` = '" . $params["last_name"] . "', `username` = '" . $params["username"] . "', `password` = '" . $params["password"] . "', `plain_password` = '" . $params["plain_password"] . "', `phone` = '" . $params["phone"] . "', email_address = '" . $params["email_address"] . "', address1 = '" . $params["address1"] . "', address2 = '" . $params["address2"] . "', city = '" . $params["city"] . "', state = '" . $params["state"] . "', zipcode = '" . $params["zipcode"] . "', `api_access_admin_controll` = '" . $params["api_access_admin_controll"] . "' WHERE `id` = '".$params["client_id"]."'";
        }
        $result1 = $this->db->query( $query1 );
        if( $result1 ) {
            return true;
        } else {
            return false;
        }

    }

    public function heapGetClient( $params = array(), $client_id = 0 ) {

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

        if( $client_id != 0 ) {
            if( $where == "" )  {
                $where .= " WHERE `id` != '".$client_id."'";
            } else {
                $where .= " AND `id` != '".$client_id."'";
            }
        }


        $query = "SELECT * FROM `clients` ".$where." ORDER BY `id` DESC";

        // print_r($params);
        // echo "<pre>";
        //     print_r($where);
        // echo "</pre>";
        // echo $query;
        // exit();
        
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function isAdviserClient( $adviser_id, $client_id ) {
        $query = "SELECT id FROM `adviser_clients` WHERE `adviser_id` = '".$adviser_id."' AND `client_id` = '".$client_id."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function validateLogin( $username, $password ) {
        $query = "SELECT advisers.*, adviser_cgroups.cgroup_id FROM advisers
                        Inner Join adviser_cgroups ON adviser_cgroups.adviser_id=advisers.id
                        WHERE advisers.username = '".$username."' AND advisers.password = '".$password."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
                return $result->result_array();
        } else {
                return false;
        }
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

    public function heapUpdateLandingPage( $data ) {
        $query = "UPDATE `advisers` SET `landing_page` = '". @implode(",",$data["landing_page"]) ."' , thanks_page = '" . @implode(",",$data["thanks_page"]) . "',
          client_signup_url ='".$data["client_signup_url"]."',
          client_thankyou_url ='".$data["client_thankyou_url"]."' WHERE id='".$data["adviser_id"]."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function heapUpdateThankyouPageSetting( $data ) {
        $query = "UPDATE `advisers` SET `custom_landing_header` = '".$data["custom_landing_header"]."',`thankyou_page_header` = '".$data["thankyou_page_header"]."', `thankyou_page_footer` = '".$data["thankyou_page_footer"]."',
             `client_signup_url` ='".$data["client_signup_url"]."', `client_thankyou_url` ='".$data["client_thankyou_url"]."' WHERE `id`='".$data["adviser_id"]."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    // public function heapUpdateThankyouPageSetting( $data ) {

    //     for($i= 300;$i<1000 ; $i++){
    //         $query = "SELECT id FROM `advisers` WHERE `id` = $i";
    //         $res = $this->db->query( $query );

    //         if( $res->num_rows() > 0 ) {
    //             $query = "UPDATE `advisers` SET `thankyou_page_header` = '".$data["thankyou_page_header"]."',
    //             `custom_landing_header` = '".$data["custom_landing_header"]."', `custom_landing_footer` = '".$data["custom_landing_footer"]."',
    //              `thankyou_page_footer` = '".$data["thankyou_page_footer"]."' WHERE `id`=$i";
    //             $result = $this->db->query( $query );
    //             if( $result ) {
    //                 print_r("updated ". $i);
    //             }
    //         }
    //     }
    // }

    public function checkClientSignupUrl( $data) {
        $client_signup_url = $data["client_signup_url"];
        $adviser_id = $data["adviser_id"];
        $query = "SELECT client_signup_url FROM `advisers` WHERE `client_signup_url` = '".$client_signup_url."' AND id != '".$adviser_id."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return false;
        } else {
            return true;
        }
    }

    public function checkClientThankyouUrl( $data) {
        $client_thankyou_url = $data["client_thankyou_url"];
        $adviser_id = $data["adviser_id"];
        $query = "SELECT client_thankyou_url FROM `advisers` WHERE `client_thankyou_url` = '".$client_thankyou_url."' AND id != '".$adviser_id."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return false;
        } else {
            return true;
        }
    }


    public function heapUpdateEmailSetting( $data ) {
        $query = "UPDATE `advisers` SET `email_subject` = '".$data["email_subject"]."', `email_content` = '".$data["email_content"]."', `email_reply` = '".$data["email_reply"]."', `email_footer` = '".$data["email_footer"]."' WHERE `id` = '".$data["adviser_id"]."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function listEFPClients( $adviser_id ) {
        $query = "SELECT *,userid as id FROM freebook_adviser_clients where adviser_id = '".$adviser_id."' ORDER BY id DESC";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
                return $result->result_array();
        } else {
                return false;
        }
    }

    public function efpGetAdviser( $adviser_id ) {
        $query = "SELECT * FROM `adviser_pages` WHERE `adviser_id` = '".$adviser_id."' AND `adviser_permissions` = 2";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
                return $result->result_array();
        } else {
                return false;
        }
    }

    public function efpGetClient( $user_id, $adviser_id ) {
        $query = "SELECT fac.*, fsr.* FROM freebook_adviser_clients as fac, freebook_survey_response as fsr WHERE fac.userid = fsr.userid AND fac.userid = '".$user_id."' AND fac.adviser_id = '".$adviser_id."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function efpcheckUsername( $user_id, $username ) {
        $query = "SELECT * FROM `freebook_adviser_clients` WHERE `userid` != '".$user_id."' AND `username` = '".$username."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function efpGetClientBooks( $user_id ) {
        $query = "SELECT `pdfid` FROM `freebook_userpdf` WHERE `userid` = '".$user_id."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function efpIsAdviserClient( $adviser_id, $client_id ) {
        $query = "SELECT userid FROM `freebook_adviser_clients` WHERE `adviser_id` = '".$adviser_id."' AND `userid` = '".$client_id."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function efpUpdateClient( $params ) {


        $query1 = "UPDATE `freebook_adviser_clients` SET `username` = '".$params["username"]."', `password` = '".$params["password"]."', `first` = '".$params["first"]."', `last` = '".$params["last"]."', `street` = '".$params["street"]."', `city` = '".$params["city"]."', `state` = '".$params["state"]."', zip = '".$params["zip"]."', `phone` = '".$params["phone"]."' WHERE `userid` = '".$params["client_id"]."'";
        $result1 = $this->db->query( $query1 );

        $query2 = "UPDATE `freebook_survey_response` SET `protect_asset` = '".$params["protect_asset"]."', `reduce_inctax` = '".$params["reduce_inctax"]."', `guarantee_income` = '".$params["guarantee_income"]."', financial_help = '".$params["financial_help"]."', survey_date = '".date("Y-m-d")."'  WHERE `userid` = '".$params["client_id"]."'";
        $result2 = $this->db->query( $query2 );

        $query3 = "DELETE FROM `freebook_userpdf` WHERE `userid` = '".$params["client_id"]."'";
        $result3 = $this->db->query( $query3 );

        if( !empty($params["ebook"]) ) {
            foreach($params["ebook"] as $key => $value) {
                $query4 = "INSERT INTO `freebook_userpdf` SET `pdfid` = '".$value."', userid = '".$params["client_id"]."'";
                $result4 = $this->db->query( $query4 );
            }
        }

        if( $result1 && $result2 && $result3 ) {
            return true;
        } else {
            return false;
        }

    }

    public function efpDeleteClient( $client_id ) {
        $query1 = "DELETE FROM `freebook_adviser_clients` WHERE `userid` = '".$client_id."'";
        $result1 = $this->db->query( $query1 );

        if($result1) {
            $query2 = "DELETE FROM `freebook_survey_response` WHERE `userid` = '".$client_id."'";
            $result2 = $this->db->query( $query2 );

            $query3 = "DELETE FROM `freebook_userpdf` WHERE `userid` = '".$client_id."'";
            $result3 = $this->db->query( $query3 );

            return true;
        } else {
            return false;
        }
    }

    public function efpClientChangeStatus( $client_id, $status ) {
        $query = "UPDATE `freebook_adviser_clients` SET `disabled` = '".$status."' WHERE `userid` = '".$client_id."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function efpGetEmailSettings( $adviser_id ) {
        $query = "SELECT * FROM `adviser_emailsettings` WHERE adviser_id = '".$adviser_id."' AND adviser_permissions = 2";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
                return $result->result_array();
        } else {
                return false;
        }
    }

    public function efpUpdateEmailSetting( $data ) {
        $query = "UPDATE `adviser_emailsettings` SET `email_subject` = '".$data["email_subject"]."', `email_content` = '".$data["email_content"]."', `email_reply` = '".$data["email_reply"]."', `email_footer` = '".$data["email_footer"]."' WHERE `adviser_id` = '".$data["adviser_id"]."' AND `adviser_permissions` = 2";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function efpGetValidationSetting( $advisor_id ) {

        $query = "SELECT * FROM `freebook_validationsettings` WHERE `advisor_id` = '". $advisor_id ."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function efpUpdateValidationSetting( $params, $advisor_id ) {

        foreach ( $params as $key => $value) {
            if ( $key != 'submit' ) {

                $query = "SELECT `field_value` FROM `freebook_validationsettings` WHERE `advisor_id` = '".$advisor_id."' AND `field_name` = '".$key."'";
                $result = $this->db->query( $query );
                if( $result->num_rows() > 0 ) {
                    $insert = "INSERT INTO freebook_validationsettings (advisor_id,field_name,field_value) VALUES ('".$advisor_id."','".$key."','".$value."')";
                    $result1 = $this->db->query( $insert );
                } else {
                    $update = "UPDATE freebook_validationsettings SET field_value='".$value."' where advisor_id='". $advisor_id ."' AND field_name='". $key ."'";
                    $result = $this->db->query( $update );
                }

            }
        }

        return true;
    }

    public function efpGetForewords( $adviser_id ) {
        $query = "SELECT id,book_id, CASE WHEN foreword = '' THEN 'NO' ELSE 'YES' END as 'foreword2' ,(select title from freebook_pdftrack where pdfid=freebook_custom_foreword.book_id) as book_name FROM freebook_custom_foreword where advisor_id = '". $adviser_id ."'";
        // echo $query;
        // exit();
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function getForeword( $foreword_id ) {
        $query = "SELECT *,(SELECT `title` FROM `freebook_pdftrack` WHERE `pdfid` = freebook_custom_foreword.book_id) AS book_name FROM `freebook_custom_foreword` WHERE `id` = '".$foreword_id."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function updateForeword( $data ) {
        $query = "UPDATE `freebook_custom_foreword` SET `foreword` = '".$data["foreword"]."' WHERE `id` = ".$data['foreword_id'];
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function efpUpdateLandingPage( $data ) {
        $query = "UPDATE `adviser_pages` SET `landing_page` = '". @implode(",",$data["landing_page"]) ."', `thanks_page` = '" . @implode(",",$data["thanks_page"]) . "' WHERE `adviser_id` = '".$data["adviser_id"]."' AND `adviser_permissions` = 2";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function efpGetBooksPermission( $data ) {
        $query = "SELECT * FROM `allow_books` WHERE `field_name`='".$data["field_name"]."' AND `advisor_permission`='2' and adviser_id ='".$data["adviser_id"]."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function efpGetEbooks( $pfid = 0 ) {
        if( $pfid == 0 ) {
            $query = "SELECT * FROM freebook_pdftrack WHERE active ='1' ORDER BY pdfid";
        } else {
            $query = "SELECT * FROM `freebook_pdftrack` WHERE `active` ='1' and `pdfid` = '".$pfid."' ORDER BY pdfid";
        }

        $result = $this->db->query( $query );
        if( $result ) {
            return $result->result_array();
        } else {
            return array();
        }
    }

    public function listRKClients( $adviser_id ) {
        $query = "SELECT *,userid as id FROM wealth_adviser_clients where adviser_id = '".$adviser_id."' ORDER BY userid DESC";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
                return $result->result_array();
        } else {
                return false;
        }
    }

    public function rkGetClient( $user_id, $adviser_id ) {
        $query = "SELECT * FROM `wealth_adviser_clients` WHERE `userid` = '".$user_id."' AND `adviser_id` = '".$adviser_id."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function rkGetAdviser( $adviser_id ) {
        $query = "SELECT * FROM `adviser_pages` WHERE `adviser_id` = '".$adviser_id."' AND `adviser_permissions` = 3";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
                return $result->result_array();
        } else {
                return false;
        }
    }

    public function rkIsAdviserClient( $adviser_id, $client_id ) {
        $query = "SELECT userid FROM `wealth_adviser_clients` WHERE `adviser_id` = '".$adviser_id."' AND `userid` = '".$client_id."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function rkClientChangeStatus( $client_id, $status ) {
        $query = "UPDATE `wealth_adviser_clients` SET `disabled` = '".$status."' WHERE `userid` = '".$client_id."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function rkCheckUsername( $user_id, $username ) {
        $query = "SELECT * FROM `wealth_adviser_clients` WHERE `userid` != '".$user_id."' AND `username` = '".$username."'";
        $result = $this->db->query( $query );
        if( $result ) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function rkUpdateClient( $params ) {
        $query1 = "UPDATE `wealth_adviser_clients` SET `username` = '".$params["username"]."', `first` = '".$params["first"]."', `last` = '".$params["last"]."', `phone` = '".$params["phone"]."' WHERE `userid` = '".$params["client_id"]."'";
        $result1 = $this->db->query( $query1 );

        if( $result1 ) {
            return true;
        } else {
            return false;
        }

    }

    public function rkDeleteClient( $client_id ) {
        $query1 = "DELETE FROM `wealth_adviser_clients` WHERE `userid` = '".$client_id."'";
        $result1 = $this->db->query( $query1 );

        if($result1) {
            return true;
        } else {
            return false;
        }
    }

    public function rkUpdateLandingPage( $data ) {
        $query = "UPDATE `adviser_pages` SET `landing_page` = '". @implode(",",$data["landing_page"]) ."', `thanks_page` = '" . @implode(",",$data["thanks_page"]) . "' WHERE `adviser_id` = '".$data["adviser_id"]."' AND `adviser_permissions` = 3";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function rkGetEmailSettings( $adviser_id ) {
        $query = "SELECT * FROM `adviser_emailsettings` WHERE adviser_id = '".$adviser_id."' AND adviser_permissions = 3";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
                return $result->result_array();
        } else {
                return false;
        }
    }

    public function rkUpdateEmailSetting( $data ) {
        $query = "UPDATE `adviser_emailsettings` SET `email_subject` = '".$data["email_subject"]."', `email_content` = '".$data["email_content"]."', `email_reply` = '".$data["email_reply"]."', `email_footer` = '".$data["email_footer"]."', `email_name` = '".$data["email_name"]."', `email_title` = '".$data["email_title"]."' WHERE `adviser_id` = '".$data["adviser_id"]."' AND `adviser_permissions` = 3";
        $result = $this->db->query( $query );
        if( $result ) {
            return true;
        } else {
            return false;
        }
    }

    public function getAdviserEmailSetting( $adviser_id ) {
        $query = "SELECT * FROM `adviser_emailsettings` WHERE adviser_id = '".$adviser_id."'";
        $result = $this->db->query( $query );
        if( $result->num_rows() > 0 ) {
            return $result->result_array();
        } else {
            return array();
        }
    }

}
?>
