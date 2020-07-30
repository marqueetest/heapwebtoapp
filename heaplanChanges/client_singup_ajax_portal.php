<?php
        session_start();
        ini_set('display_errors', 0);
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
        global $db_connect;
        require_once('system.config.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/php-bin/class.mdb2_helper.php');
        $db_connect = new MDB2_helper("mysqli://$username_systemDB:$password_systemDB@$hostname_systemDB/$database_systemDB");
        $db_connect->connect();
        require_once('API_CONECT_FUNCTIONS.php');
        $bc_username    =	trim($_POST["adviser_username"]);
		$bc_password_plain	=	trim($_POST["password"]);
        // $bc_password	=	trim($_POST["password"]);
        $bc_password  = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
		$bc_first_name	=	trim($_POST["first_name"]);
		$bc_last_name	=	trim($_POST["last_name"]);
		$bc_email_address	= trim($_POST["email_address"]);
		$bc_address1	=	trim($_POST["address1"]);
		$summary_info	=	trim($_POST["summary_info"]);
        if($summary_info == ''){
            $summary_info = 0;
		}
		$bc_address2	=	trim($_POST["address2"]);
		$bc_city		=	trim($_POST["city"]);
		$bc_state		=	trim($_POST["states"]);
		$bc_zipcode		=	trim($_POST["zipcode"]);
		$bc_phone		=	trim($_POST["phone"]);
		$ADVISOR_PBULIC_KEY	= trim($_POST["ADVISOR_PBULIC_KEY"]);
		$HTTP_ORIGIN			= cleanOrigin($_SERVER["HTTP_ORIGIN"]);

		$alredy_username 		= getSingleColumn("username","select username from clients where username='".$bc_username."'");
		$alredy_email_address 	= getSingleColumn("email_address","select email_address from clients where email_address='".$bc_email_address."'");
		if($alredy_email_address != ''){
			$getClient_id 	= getClient_id("id","select id from clients where email_address='".$bc_email_address."'");
			$alredy_advisors_client = getSingleColumn("adviser_id","select adviser_id from adviser_clients where adviser_id='".tep_decrypt($ADVISOR_PBULIC_KEY)."' AND client_id='".$getClient_id."'");
		}

	$errors = array();
	if($bc_username==''){
		$errors = "Username is required";
	}
	elseif($alredy_username!=''){
		$errors = "Username already exist.";
	}
	elseif($bc_password=='' || strlen($bc_password)<5){
		$errors = "Password minimum 5 chracter is required";
	}
	elseif($bc_first_name==''){
		$errors = "First Nname is required";
	}

	elseif($bc_last_name==''){
		$errors = "Last Name is required";
	}

	else if($bc_email_address=='' || !filter_var($bc_email_address, FILTER_VALIDATE_EMAIL)){
		$errors = "Invalid Email address";
	}

	else if($alredy_advisors_client!=''){
		$errors = "Email Address already exist.";
	}


if ($_POST["action"]=="createClient")  {
	if (!count($errors)) {
			$resultset =& $db_connect->Query("SELECT * FROM advisers WHERE id='".tep_decrypt($ADVISOR_PBULIC_KEY)."' AND id>0","SELECT");
			if($resultset->numRows()){
					$row = $db_connect->FetchAssocRow($resultset);
					$landing_array 	   = @explode(",",$row["landing_page"]);
					$thanks_array 	   = @explode(",",$row["thanks_page"]);
                    $thanks_page =  "https://heaplan.com/thankyou/".$row["client_thankyou_url"];
						$adviser_id = $row["id"];
						include_once("API_CREATE_CLIENT.php");
						$return["result"]  = $data["result"];
						$return["message"] = $data["message"];
					    $return["thanks_page"] = trim($thanks_page);
			}else{
				$return["result"] = "error";
				$return["message"] = "Invalid Request.";
			}

	}else {
		$sucMessage = $errors;
		$return["result"] = "error";
		$return["message"] = $sucMessage;
	}
	echo json_encode($return);
}

 function tep_decrypt($data){
   $output = '';
    if($data!=''){
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'GG101GG';
		$secret_iv = '801AS';
		// hash
		$key = hash('sha512', $secret_key);
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha512', $secret_iv), 0, 16);
		return $output = trim(openssl_decrypt(base64_decode($data), $encrypt_method, $key, 0, $iv));
	}else
		return '';
 }
 function cleanOrigin($input ){
	// in case scheme relative URI is passed, e.g., //www.google.com/
	$input = trim($input, '/');

	// If scheme not included, prepend it
	if (!preg_match('#^http(s)?://#', $input)) {
    		$input = 'http://' . $input;
	}

	$urlParts = parse_url($input);

	// remove www
	$domain = preg_replace('/^www\./', '', $urlParts['host']);

	return $domain;

}
?>
