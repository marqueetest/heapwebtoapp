<?php
    if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
		$data["result"] = "error";
		$data["message"] = "Sorry you do not have permission for this action";
		echo json_encode($data);
		exit();
	}
	$data  = array($adviser_id);
    $types = array('integer');
	$advisor_api =& $db_connect->Query("SELECT api_access_client_controll FROM advisers WHERE id = ? ","SELECT",$data,$types);
    if($advisor_api->numRows()){
		$rows = $db_connect->FetchAssocRow($advisor_api);
		$api_access_client_control= $rows["api_access_client_controll"];
	}
	$api_access_admin_controll =  $api_access_client_control;
	$data_query = array($bc_username,$bc_password,$bc_password_plain,$bc_first_name,$bc_last_name,$bc_email_address,$bc_address1,$bc_address2,$bc_city,$bc_state,$bc_zipcode,$bc_phone,$api_access_admin_controll);
	$types_query = array('text','text','text','text','text','text','text','text','text','text','text','text','text');

   $resultset =& $db_connect->Query("INSERT INTO clients (username,password,plain_password,first_name,last_name,email_address,address1,address2,city,state,zipcode,phone,api_access_admin_controll) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)",'INSERT',$data_query,$types_query);
	$client_id = $db_connect->db->lastInsertID();

		if($client_id>0){
				$db_connect->Query("INSERT INTO client_cgroups SET client_id = '".$client_id."' , cgroup_id = '1'","INSERT");
				$db_connect->Query("INSERT INTO adviser_clients SET adviser_id = '".$adviser_id."' , client_id = '".$client_id."', coupon = '".$coupon_code."'","INSERT");

		if($coupon_code!=''){
			$registed_using = "Coupon Code ".$coupon_code;
			$db_connect->Query("UPDATE adviser_coupon_codes SET  total_use = '1' WHERE coupon_code='".$coupon_code."'","UPDATE");
		}
		singUpemail('1',$client_id,$adviser_id);
		notifyAdviser('1',$adviser_id,$client_id,$registed_using);
		$data["result"] = "success";
		$data["message"] = "You have created an account.";
	}else{
		$data["result"] = "error";
		$data["message"] = "Some error occured please try again.";
	}
?>
