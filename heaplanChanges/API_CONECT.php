<?php
    session_start();
    ini_set('display_errors', 0);
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
	header('Access-Control-Max-Age: 1000');
	header('Access-Control-Allow-Headers: Content-Type');
	header('Content-Type: application/json');
	global $db_connect;
	$USER_TYPE = $_GET["USER_TYPE"];

	if($_GET["action"]!=''){
			$action = $_GET["action"];
		}
		else if($_POST["action"]!=''){
			$action = $_POST["action"];
	}
	if($_GET["action"]!=''){
		$action = $_GET["action"];
	}
	else if($_POST["action"]!=''){
		$action = $_POST["action"];
}
    if($_GET["API_KEY"]=="234fsd43rdfsdr2323423ef"){
		require_once($_SERVER['DOCUMENT_ROOT'].'/php-bin/class.mdb2_helper.php');
		require_once('system.config.php');
		$db_connect = new MDB2_helper("mysqli://$username_systemDB:$password_systemDB@$hostname_systemDB/$database_systemDB");
    	$db_connect->connect();
		require_once('API_CONECT_FUNCTIONS.php');
		$withTokenAction  = array("getClients","deleteReportSuccess","clientManage","deleteClient","clientReports","adviserManage","viewReport","saveCreteReport","loadCreateReportHTML","newTermUpdate","oldTermUpdate","updateTermHTML","clientInfo");
		if($USER_TYPE=="adviser"){
			if((int)$_POST["adviser_id"]>0 && in_array($action,$withTokenAction)){
				$api_access_admin_controll = getSingleColumn("api_access_admin_controll","SELECT `api_access_admin_controll` from advisers where id = '".(int)$_POST["adviser_id"]."'");
				if($api_access_admin_controll!='1'){
					apiError("Sorry app access is disable.Please contact to heplan administration.");
				}
			}
			$api_access_token = getSingleColumn("api_access_token","SELECT `api_access_token` from advisers where id = '".(int)$_POST["adviser_id"]."'");
			if($api_access_token!=trim($_GET["ACCESS_TOKEN"]) && in_array($action,$withTokenAction)){
				apiError("Sorry your session is invalid please logout and try again.");
			}
		}else{
			if((int)$_POST["adviser_id"]>0 && $_POST["client_id"] && in_array($action,$withTokenAction)){
				$api_access_admin_controll = getSingleColumn("api_access_admin_controll","SELECT `api_access_admin_controll` from clients where id = '".(int)$_POST["client_id"]."'");
				if($api_access_admin_controll!='1'){
					apiError("Sorry app access is disable.Please contact your adviser.");
				}
			}
			$api_access_token = getSingleColumn("api_access_token","SELECT `api_access_token` from clients where id = '".(int)$_POST["client_id"]."'");
			if($api_access_token!=trim($_GET["ACCESS_TOKEN"]) && in_array($action,$withTokenAction)){
				apiError("Sorry your session is invalid please logout and try again.");
			}
		}

		switch($action):
			case "validateUser":
				$query_data = array($cgroup_id,$_POST['username'],$_POST['password']);
        		$query_types = array('integer','text','text');
				if($USER_TYPE=="adviser"){
					$adviser_login =& $db_connect->Query("SELECT advisers.* FROM advisers
										Inner Join adviser_cgroups ON adviser_cgroups.adviser_id=advisers.id AND adviser_cgroups.cgroup_id= ?
										WHERE advisers.username = ?","SELECT",$query_data,$query_types);
					if($adviser_login->numRows()){
						$row = $db_connect->FetchAssocRow($adviser_login);
						$access_token = $row["api_access_token"];
						if($row["api_access_admin_controll"]=='1'){
							$match_password = password_verify($_POST['password'] , $row['password'] );
							if($match_password == 1){
								if($access_token==''){
									$new_string  = tep_create_random_value(8);
									$new_string2 = tep_create_random_value(10);
									$access_token_value = $new_string2.$row["username"].(int)$row['id'].$new_string;
									$access_token 		= md5($access_token_value);
									$db_connect->Query("Update advisers SET `api_access_token` = '".$access_token."' where id = '".(int)$row['id']."'","UPDATE");
								}
									$data["result"] 		= "success";
									$data["email_address"] 	= $row["email_address"];
									$data["adviser_id"]	   	= $row["id"];
									$data["first_name"] 	= DBout($row["first_name"]);
									$data["last_name"] 	   	= DBout($row["last_name"]);
									$data["username"] 		= DBout($row["username"]);
									$data["address1"]	   	= DBout($row["address1"]);
									$data["address2"] 	   	= DBout($row["address2"]);
									$data["city"] 	   		= DBout($row["city"]);
									$data["state"] 	   		= DBout($row["state"]);
									$data["zipcode"] 	   	= DBout($row["zipcode"]);
									$data["phone"] 	   		= $row["phone"];
									$data["access_token"]   = $access_token;
									$data["cgroup_id"]      = $cgroup_id;
							} else {
								$data["result"]  = "error";
								$data["message"] = "Invalid password. ";
							}
						}else{
							$data["result"]  = "error";
							$data["message"] = "Sorry app access is disable.Please connect to heplan administration. ";
						}

					}else{
						$data["result"]  = "error";
						$data["message"] = "Invalid credential.";

					}
				} else {
					$query_data = array($cgroup_id,$_POST['username'],$_POST['password']);
					$query_types = array('integer','text','text');
					$client_login =& $db_connect->Query("SELECT clients.* FROM clients
										Inner Join client_cgroups ON client_cgroups.client_id=clients.id AND client_cgroups.cgroup_id= ?
										WHERE clients.username = ?  AND clients.password = ?","SELECT",$query_data,$query_types);
					if($client_login->numRows()){
						$client_row = $db_connect->FetchAssocRow($client_login);
						$access_token = $client_row["api_access_token"];
						if($client_row["api_access_admin_controll"]=='1'){
							if($access_token==''){
								$new_string  = tep_create_random_value(8);
								$new_string2 = tep_create_random_value(10);
								$access_token_value = $new_string2.$client_row["username"].(int)$client_row['id'].$new_string;
								$access_token = md5($access_token_value);
								$db_connect->Query("Update clients SET `api_access_token` = '".$access_token."' where id = '".(int)$client_row['id']."'","UPDATE");
							}
								$adviser_id = getSingleColumn("adviser_id","SELECT `adviser_id` from adviser_clients where client_id = '".(int)$client_row["id"]."'");
								$query_data = array($cgroup_id,$adviser_id);
        						$query_types = array('integer','integer');

								$adviser_login =& $db_connect->Query("SELECT advisers.* FROM advisers
										Inner Join adviser_cgroups ON adviser_cgroups.adviser_id=advisers.id AND adviser_cgroups.cgroup_id= ?
										WHERE advisers.id = ?","SELECT",$query_data,$query_types);
								if(!$adviser_login->numRows()){
									$db_connect->Query("UPDATE adviser_clients SET  adviser_id = '257' WHERE client_id='".(int)$client_row["id"]."'","UPDATE");
									$adviser_id = getSingleColumn("adviser_id","SELECT `adviser_id` from adviser_clients where client_id = '".(int)$client_row["id"]."'");
									$query_data = array($cgroup_id,$adviser_id);
        							$query_types = array('integer','integer');
									$adviser_login =& $db_connect->Query("SELECT advisers.* FROM advisers
										Inner Join adviser_cgroups ON adviser_cgroups.adviser_id=advisers.id AND adviser_cgroups.cgroup_id= ?
										WHERE advisers.id = ?","SELECT",$query_data,$query_types);
								}
								$row = $db_connect->FetchAssocRow($adviser_login);

								$data["result"] 		= "success";
								$data["email_address"] 	= $row["email_address"];
								$data["adviser_id"]	   	= $row["id"];
								$data["first_name"] 	= DBout($row["first_name"]);
								$data["last_name"] 	   	= DBout($row["last_name"]);
								$data["username"] 		= DBout($row["username"]);
								$data["address1"]	   	= DBout($row["address1"]);
								$data["address2"] 	   	= DBout($row["address2"]);
								$data["city"] 	   		= DBout($row["city"]);
								$data["state"] 	   		= DBout($row["state"]);
								$data["zipcode"] 	   	= DBout($row["zipcode"]);
								$data["phone"] 	   		= $row["phone"];
								$data["access_token"]   = $access_token;
								$data["cgroup_id"]      = $cgroup_id;

								$data["client"]["client_id"][]	   	= $client_row["id"];
								$data["client"]["email_address"][] 	= $client_row["email_address"];
								$data["client"]["first_name"][] 	= DBout($client_row["first_name"]);
								$data["client"]["last_name"][] 	   	= DBout($client_row["last_name"]);
								$data["client"]["address1"][]	   	= DBout($client_row["address1"]);
								$data["client"]["address2"][] 	   	= DBout($client_row["address2"]);
								$data["client"]["city"][] 	   		= DBout($client_row["city"]);
								$data["client"]["state"][] 	   		= DBout($client_row["state"]);
								$data["client"]["zipcode"][] 	   	= DBout($client_row["zipcode"]);
								$data["client"]["phone"][] 	   		= $client_row["phone"];
								$data["client"]["expenses"][] 	   	= $client_row["expenses"];
								$data["client"]["income"][] 	   	= $client_row["income"];
						}else{
							$data["result"]  = "error";
							$data["message"] = "Sorry app access is disable.Please contact you adviser. ";
						}
					}else{
						$query_data = array($cgroup_id,$_POST['username']);
						$query_types = array('integer','text');
						$client_login =& $db_connect->Query("SELECT clients.* FROM clients
										Inner Join client_cgroups ON client_cgroups.client_id=clients.id AND client_cgroups.cgroup_id= ?
										WHERE clients.username = ?","SELECT",$query_data,$query_types);
						if($client_login->numRows()){
							$client_row = $db_connect->FetchAssocRow($client_login);
							$access_token = $client_row["api_access_token"];
							if($client_row["api_access_admin_controll"] =='1'){
								$match_password = password_verify($_POST['password'] , $client_row['password'] );
								if($match_password == 1){
									if($access_token==''){
										$new_string  = tep_create_random_value(8);
										$new_string2 = tep_create_random_value(10);
										$access_token_value = $new_string2.$client_row["username"].(int)$client_row['id'].$new_string;
										$access_token = md5($access_token_value);
										$db_connect->Query("Update clients SET `api_access_token` = '".$access_token."' where id = '".(int)$client_row['id']."'","UPDATE");
									}
										$adviser_id = getSingleColumn("adviser_id","SELECT `adviser_id` from adviser_clients where client_id = '".(int)$client_row["id"]."'");
										$query_data = array($cgroup_id,$adviser_id);
										$query_types = array('integer','integer');

										$adviser_login =& $db_connect->Query("SELECT advisers.* FROM advisers
												Inner Join adviser_cgroups ON adviser_cgroups.adviser_id=advisers.id AND adviser_cgroups.cgroup_id= ?
												WHERE advisers.id = ?","SELECT",$query_data,$query_types);
										if(!$adviser_login->numRows()){
											$db_connect->Query("UPDATE adviser_clients SET  adviser_id = '257' WHERE client_id='".(int)$client_row["id"]."'","UPDATE");
											$adviser_id = getSingleColumn("adviser_id","SELECT `adviser_id` from adviser_clients where client_id = '".(int)$client_row["id"]."'");
											$query_data = array($cgroup_id,$adviser_id);
											$query_types = array('integer','integer');
											$adviser_login =& $db_connect->Query("SELECT advisers.* FROM advisers
												Inner Join adviser_cgroups ON adviser_cgroups.adviser_id=advisers.id AND adviser_cgroups.cgroup_id= ?
												WHERE advisers.id = ?","SELECT",$query_data,$query_types);
										}
										$row = $db_connect->FetchAssocRow($adviser_login);

										$data["result"] 		= "success";
										$data["email_address"] 	= $row["email_address"];
										$data["adviser_id"]	   	= $row["id"];
										$data["first_name"] 	= DBout($row["first_name"]);
										$data["last_name"] 	   	= DBout($row["last_name"]);
										$data["username"] 		= DBout($row["username"]);
										$data["address1"]	   	= DBout($row["address1"]);
										$data["address2"] 	   	= DBout($row["address2"]);
										$data["city"] 	   		= DBout($row["city"]);
										$data["state"] 	   		= DBout($row["state"]);
										$data["zipcode"] 	   	= DBout($row["zipcode"]);
										$data["phone"] 	   		= $row["phone"];
										$data["access_token"]   = $access_token;
										$data["cgroup_id"]      = $cgroup_id;

										$data["client"]["client_id"][]	   	= $client_row["id"];
										$data["client"]["email_address"][] 	= $client_row["email_address"];
										$data["client"]["first_name"][] 	= DBout($client_row["first_name"]);
										$data["client"]["last_name"][] 	   	= DBout($client_row["last_name"]);
										$data["client"]["address1"][]	   	= DBout($client_row["address1"]);
										$data["client"]["address2"][] 	   	= DBout($client_row["address2"]);
										$data["client"]["city"][] 	   		= DBout($client_row["city"]);
										$data["client"]["state"][] 	   		= DBout($client_row["state"]);
										$data["client"]["zipcode"][] 	   	= DBout($client_row["zipcode"]);
										$data["client"]["phone"][] 	   		= $client_row["phone"];
										$data["client"]["expenses"][] 	   	= $client_row["expenses"];
										$data["client"]["income"][] 	   	= $client_row["income"];
								}else{
									$data["result"]  = "error";
									$data["message"] = "Invalid password.";
								}
							}else{
								$data["result"]  = "error";
								$data["message"] = "Sorry app access is disable.Please contact you adviser. ";
							}
						}else{
							$data["result"]  = "error";
							$data["message"] = "Invalid credential.";
						}
					}
				}
				echo json_encode($data);
			break;
			case "clientInfo":
				$query_data = array($cgroup_id,$_POST['client_id']);
        		$query_types = array('integer','integer');
				$client_login =& $db_connect->Query("SELECT clients.* FROM clients
										Inner Join client_cgroups ON client_cgroups.client_id=clients.id AND client_cgroups.cgroup_id= ?
										WHERE clients.id = ?","SELECT",$query_data,$query_types);
					if($client_login->numRows()){
						$client_row 		  = $db_connect->FetchAssocRow($client_login);
						$data["result"] 		= "success";
						$data["email_address"] 	= $client_row["email_address"];
						$data["client_id"]	   	= $client_row["id"];
						$data["first_name"] 	= DBout($client_row["first_name"]);
						$data["last_name"] 	   	= DBout($client_row["last_name"]);
						$data["username"] 		= DBout($client_row["username"]);
						$data["address1"]	   	= DBout($client_row["address1"]);
						$data["address2"] 	   	= DBout($client_row["address2"]);
						$data["city"] 	   		= DBout($client_row["city"]);
						$data["state"] 	   		= DBout($client_row["state"]);
						$data["zipcode"] 	   	= DBout($client_row["zipcode"]);
						$data["phone"] 	   		= $client_row["phone"];

					}else{
						$data["result"]  = "error";
						$data["message"] = "Some error occured.";

					}
					echo json_encode($data);

			break;
			case "getClients":
				$adviser_id 	= (int)$_POST['adviser_id'];
				$username 		= trim($_POST['username']);
				$query_data 	=  array($cgroup_id,$username ,$adviser_id );
        		$query_types    =  array('integer','text','integer');


				$adviser_data =& $db_connect->Query("SELECT advisers.* FROM advisers
                                    Inner Join adviser_cgroups ON adviser_cgroups.adviser_id=advisers.id AND adviser_cgroups.cgroup_id= ?
                                    WHERE advisers.username = ?  AND advisers.id = ?","SELECT",$query_data,$query_types);
				if($adviser_data->numRows()>0){
						$adviser_data_row 		= $db_connect->FetchAssocRow($adviser_data);
						$data["result"] 		= "success";
						$data["email_address"] 	= $adviser_data_row["email_address"];
						$data["adviser_id"]	   	= $adviser_data_row["id"];
						$data["first_name"] 	= DBout($adviser_data_row["first_name"]);
						$data["last_name"] 	   	= DBout($adviser_data_row["last_name"]);
						$data["username"] 		= DBout($adviser_data_row["username"]);
						$data["address1"]	   	= DBout($adviser_data_row["address1"]);
						$data["address2"] 	   	= DBout($adviser_data_row["address2"]);
						$data["city"] 	   		= DBout( $adviser_data_row["city"]);
						$data["state"] 	   		= DBout($adviser_data_row["state"]);
						$data["zipcode"] 	   	= DBout($adviser_data_row["zipcode"]);
						$data["phone"] 	   		= $adviser_data_row["phone"];
						$data["cgroup_id"]      = $cgroup_id;
						$query_data 	=  array($adviser_id,$cgroup_id);
        				$query_types    =  array('integer','text','integer');
						$clients_data  =& $db_connect->Query("SELECT clients.* FROM clients,adviser_clients as ac,client_cgroups as cg
                                WHERE ac.adviser_id = ? AND ac.client_id=clients.id AND cg.client_id=clients.id
                                AND cg.cgroup_id=?","SELECT",$query_data,$query_types);
						if($clients_data->numRows()){

							while($clients_data_rows = $db_connect->FetchAssocRow($clients_data)){
								$data["client"]["client_id"][]	   	= $clients_data_rows["id"];
								$data["client"]["email_address"][] 	= $clients_data_rows["email_address"];
								$data["client"]["first_name"][] 	= DBout($clients_data_rows["first_name"]);
								$data["client"]["last_name"][] 	   	= DBout($clients_data_rows["last_name"]);
								$data["client"]["address1"][]	   	= DBout($clients_data_rows["address1"]);
								$data["client"]["address2"][] 	   	= DBout($clients_data_rows["address2"]);
								$data["client"]["city"][] 	   		= DBout($clients_data_rows["city"]);
								$data["client"]["state"][] 	   		= DBout($clients_data_rows["state"]);
								$data["client"]["zipcode"][] 	   	= DBout($clients_data_rows["zipcode"]);
								$data["client"]["phone"][] 	   		= $clients_data_rows["phone"];
								$data["client"]["expenses"][] 	   	= $clients_data_rows["expenses"];
								$data["client"]["income"][] 	   	= $clients_data_rows["income"];
							}
						}else{

						}

				}
				else{
					$data["result"]  = "error";
					$data["message"] = "Invalid request.";

				}
				echo json_encode($data);
			break;
			case "clientManage":
				$adviser_id 	= (int)$_POST['adviser_id'];
				if($adviser_id<=0){
					$data["result"] = "error";
					$data["message"] = "Sorry we are unable to identify your request";
					echo json_encode($data);
					exit();
				}
				if((int)$_POST["client_id"]>0){

					$alredy_email_address = getSingleColumn("email_address","select email_address from clients where email_address='".$_POST['email_address']."' and id!='".(int)$_POST["client_id"]."'");

					if($_POST['email_address']=='' || !filter_var($_POST['email_address'], FILTER_VALIDATE_EMAIL))
						$errors = "Invalid Email address";
					elseif($alredy_email_address!='')
						$errors = "Email Address already exist.";

					if($errors!=''){
						apiError($errors);
					}
					else{
						$update =& $db_connect->Query("UPDATE clients as c,adviser_clients as ac SET c.first_name = '".DBin($_POST['first_name'])."', c.last_name = '".DBin($_POST['last_name'])."', c.phone = '".$_POST['phone']."', c.email_address = '".$_POST['email_address']."',c.address1 = '".DBin($_POST['address1'])."', c.address2 = '".DBin($_POST['address2'])."', c.city = '".DBin($_POST['city'])."', c.state = '".DBin($_POST['states'])."', c.zipcode = '".DBin($_POST['zipcode'])."' WHERE c.id = '".(int)$_POST['client_id']."' AND ac.client_id=c.id AND ac.adviser_id= '".$adviser_id."'","UPDATE");

						if($update){
							$data["result"]  = "success";
							$data["message"] = "Successfully updated.";
							$data["client"]  = "update";
						}else{
							$data["result"] = "error";
							$data["message"] = "Sorry we are unable to process your request.Try later";
						}
					}

				}else{
					$alredy_email_address = getSingleColumn("email_address","select email_address from clients where email_address='".$_POST['email_address']."'");
					if($_POST['email_address']=='' || !filter_var($_POST['email_address'], FILTER_VALIDATE_EMAIL))
						$errors = "Invalid Email address";
					elseif($alredy_email_address!='')
						$errors = "Email Address already exist.";

					if($errors!=''){
						apiError($errors);
					}else{
						$data_query = array($_POST['email_address'],$_POST['email_address'],$_POST['first_name'],$_POST['last_name'],$_POST['phone'],$_POST['email_address'],$_POST['address1'],$_POST['address2'],$_POST['city'],$_POST['states'],$_POST['zipcode']);
						$types_query = array('text','text','text','text','text','text','text','text','text','text','text');

						$resultset =& $db_connect->Query("INSERT INTO clients (username,password,first_name,last_name,phone,email_address,address1,address2,
													city,state,zipcode) VALUES(?,?,?,?,?,?,?,?,?,?,?)",'INSERT',$data_query,$types_query);
						$client_id = $db_connect->db->lastInsertID();
						if($client_id>0){
							$data_query = array($client_id,$adviser_id);
							$types_query = array('integer','integer');

							$resultset =& $db_connect->Query("INSERT INTO adviser_clients (client_id,adviser_id) VALUES(?,?)",'INSERT',$data_query,$types_query);

							$data_query = array($client_id,$cgroup_id);
							$types_query = array('integer','integer');

							$resultset =& $db_connect->Query("INSERT INTO client_cgroups (client_id,cgroup_id) VALUES(?,?)",'INSERT',$data_query,$types_query);

							$data["result"]  = "success";
							$data["message"] = "Client successfully added.";
							$data["client"]  = "create";
						}else{
							$data["result"]  = "error";
							$data["message"] = "Sorry we are unable to process your request.Try later";
						}
					}

				}
				echo json_encode($data);
			break;
			case "deleteClient":
				$adviser_id 	= (int)$_POST['adviser_id'];
				$client_id 		= (int)$_POST['client_id'];
				$del1 =& $db_connect->Query("DELETE clients.* FROM clients,adviser_clients as ac WHERE ac.adviser_id = '".$adviser_id."'
                                AND ac.client_id=clients.id AND clients.id = '".$client_id."'","DELETE");

    			$del2 =&  $db_connect->Query("DELETE cg.* FROM client_cgroups as cg,adviser_clients as ac WHERE ac.adviser_id = '".$adviser_id."'
                                AND ac.client_id=cg.client_id AND cg.client_id='".$client_id."'AND cg.cgroup_id = '".$cgroup_id."'","DELETE");

				$del3 =& $db_connect->Query("DELETE ac.* FROM adviser_clients as ac WHERE ac.adviser_id = '".$adviser_id."'
                                AND ac.client_id='".$client_id."'","DELETE");

				if(!$db_connect->error){
					$data["result"]  = "success";
					$data["message"] = "Client successfully deleted.";
				}else{
					$data["result"]  = "error";
					$data["message"] = "Sorry we are unable to process your request.Try later";
				}
				echo json_encode($data);
			break;
			case "adviserManage":
					$adviser_id = (int)$_POST["adviser_id"];
					$resultset =& $db_connect->Query("SELECT advisers.* FROM advisers Inner Join adviser_cgroups ON adviser_cgroups.adviser_id=advisers.id AND adviser_cgroups.cgroup_id='".$cgroup_id."' WHERE advisers.email_address = '".$_POST['email_address']."' AND advisers.id != '".$adviser_id."'","SELECT");

					if($resultset->numRows()>0){
						$data["result"]  = "error";
						$data["message"] = "Sorry this email address already exist.";
						echo json_encode($data);
						exit();

					}
					$update =& $db_connect->Query("UPDATE advisers SET first_name = '".DBin($_POST['first_name'])."', last_name = '".DBin($_POST['last_name'])."', phone = '".$_POST['phone']."', email_address = '".$_POST['email_address']."',address1 = '".DBin($_POST['address1'])."', address2 = '".DBin($_POST['address2'])."', city = '".DBin($_POST['city'])."', state = '".DBin($_POST['states'])."', zipcode = '".DBin($_POST['zipcode'])."' WHERE id= '".$adviser_id."'","UPDATE");
					if($update){
						$data["result"]  = "success";
						$data["message"] = "Account successfully updated.";
					}else{
						$data["result"]  = "error";
						$data["message"] = "Sorry we are unable to process your request.Try later";
					}
					echo json_encode($data);
			break;
			case "clientReports":
				$client_id 		= (int)$_POST["client_id"];
				$client_reports =& $db_connect->Query("SELECT id,POST,current_term,creation_date,mortgage_term FROM heaplan_reports WHERE client_id = '".$client_id."' ORDER BY creation_date DESC","SELECT");
     			$total_reports = $client_reports->numRows();

     			if($total_reports){
     			$complete_list = '';
				while($r = $db_connect->FetchAssocRow($client_reports)):
					$POST =  unserialize($r['POST']); // Original posted values
					 $current_term = $r['current_term'];
					 if(empty($current_term) || $current_term < 1)
					 		$current_term = $POST['total_original_term_months'] - $POST['months_remaining_mortgage_term'] + 1;

					 $mortgage_term_total = $r['mortgage_term'];

					 $data = array($r['id'],$client_id);
					 $types = array('integer','integer');

					 $resultset_u =& $db_connect->Query("SELECT term,date_modified FROM heaplan_inputtextfile WHERE report_id = '".$r['id']."' AND client_id = '".$client_id."' ORDER BY date_modified DESC LIMIT 1","SELECT");
					 $u = $db_connect->FetchAssocRow($resultset_u);

					 $report_updated_date = $u['date_modified'];
					 $last_term_updated   = $u['term'];

					 $resultset_l =& $db_connect->Query("SELECT max(monthnumber) as last_term FROM heaplan_output WHERE report_id = '".$r['id']."' AND client_id = '".$client_id."'","SELECT");
					 $l = $db_connect->FetchAssocRow($resultset_l);
					 $mortgage_last_calc_term = $l['last_term'];
					 $mtg_term_loop = $mortgage_last_calc_term > 0 ? $mortgage_last_calc_term : $mortgage_term_total;
					 $report_created_date = date("m/d/Y",strtotime($r['creation_date']));
  					 $report_updated_date = empty($report_updated_date) ? null : date("m/d/Y",strtotime($report_updated_date));

					 ob_start();
					 ?>
                     	<tr style="border-bottom:1px solid #E0E0E0;" id="report_tr<? echo $r['id']; ?>">
                            <td align="left"><? echo $r['id']; ?></td>
                            <td align="left"><? echo $report_created_date; ?>&nbsp;</td>
                            <td align="left"><? echo $report_updated_date; ?>&nbsp;<? if(!empty($last_term_updated)): ?>(Term <? echo $last_term_updated; ?>)<? endif; ?></td>
                            <td  align="right">
                            	<a class="add_to_list green" href="javascript:viewReport(<? echo $client_id; ?>,<? echo $r['id']; ?>);">View</a>
                                <a class="add_to_list red"  href="javascript:deleteReport(<? echo $client_id; ?>,<? echo $r['id']; ?>);">Delete</a>
                                <? if($r['id'] >= 633): ?>
								<? if(empty($mtg_term_loop) || $mtg_term_loop == 0)
										$mtg_term_loop = 1;
								?>
                                	<a class="add_to_list blue"  href="javascript:editTerm(<? echo $client_id; ?>,<? echo $r['id']; ?>,<? echo $current_term; ?>,<? echo $mtg_term_loop; ?>);">Edit/Update Term&nbsp;</a>
                                <? endif;?>
							</td>
                          </tr>
                     <?php
					 $reportlist 	  = ob_get_contents();
					 ob_clean();
					 $complete_list .= $reportlist;

				endwhile;
					$data["result"] = "success";
					$data["reportlist"] = $complete_list;
				}else{
					$data["result"] = "error";
					$data["message"] = "No Reports Found";
				}

				echo json_encode($data);
			break;
			case "viewReport":
				include_once("API_REPORT.php");
			break;
			case "deleteReportSuccess":
				$adviser_id 	= (int)$_POST['adviser_id'];
				$client_id 		= (int)$_POST['client_id'];
				$report_id 		= (int)$_POST['report_id'];
				$data_query 	= array($report_id,$client_id);
				$types_query 	= array('integer','integer');

				$resultset =& $db_connect->Query("SELECT calc_file FROM heaplan_reports WHERE id=? AND client_id=?",'SELECT',$data_query,$types_query);
				$r = $db_connect->FetchAssocRow($resultset);
				$calc_file = $r['calc_file'];

				$resultset =& $db_connect->Query("DELETE FROM heaplan_reports WHERE id=? AND client_id=?",'DELETE',$data_query,$types_query);

				if(is_file($calc_file))
					@unlink("$calc_file");

				if(!$db_connect->error){
					$data["result"]  = "success";
					$data["message"] = "Report successfully deleted.";
				}else{
					$data["result"]  = "error";
					$data["message"] = "Sorry we are unable to process your request.Try later";
				}
				echo json_encode($data);
			break;
			case "loadGraph":
				require_once('class.financials.php');
				$client_id = (int)$_POST["client_id"];
				$report_id = (int)$_POST["report_id"];
				$resultset =& $db_connect->Query("SELECT * FROM heaplan_reports WHERE client_id = '".$client_id."' AND id='".$report_id."'","SELECT");
				if($resultset->numRows()<=0){
					$data["result"] = "error";
					$data["message"] = "Sorry no graph data availabe.";
					//$data["message"] = $db_connect->error;
				}else{
					$rep = $db_connect->FetchAssocRow($resultset);
					$original_post = unserialize($rep['POST']);
					$total_original_term_months = $original_post['total_original_term_months'];
					$heloc_start_term = $rep['heloc_start_term'];

					//$mort_term = $r['mortgage_term'];
					$mort_term = $total_original_term_months;


					$max_months_display = $mort_term; // use $mort_term to display full chart

					if(!empty($mort_term)) {

					$input_file = $rep['calc_file'];

					if(file_exists($input_file)){

						$datafile = file($input_file);
						$f = new phpfinancials();

					// create category labels
					$chart = array();

					//Add data for 2nd & 3rd dataset (HEAP Schedule + HELOC)
					$year = 0;
					$month = 0;
					$display_mort_balance = false;
					foreach($datafile as $key => $value)
					{
						if($key == 0 || $key == 1) continue;
						if(substr($value,0,5) == "Total") break;

						//MortgagePrincipal MortgageTermInMonths MortgageInterestRate HelocAmount HelocStartMonth Salary(bimonthly) BillAmount HelocInterestRate BillPaymentDay
						// MortgagePaymentDay InterestOnly ClientId IterationNo

						$month++;
						if($month > $max_months_display) break;
						if($month % 12 == 0 || $month == $max_months_display)
						{
							$year++;
							list($term,$mort_balance,$mort_principle,$mort_int,$mort_tot,$HBal,$Hprinc,$HInt,$HTotal) = explode(" : ",trim($value));

							$chart['HELOC'][] = $HBal;
							if($HBal > 0) $display_mort_balance = true;
							if($display_mort_balance)
								$chart['HEAP'][] = $mort_balance;
							else
								$chart['HEAP'][] = 0;

							//echo "$year $mort_balance<br>";
						}

						if($key == 2)
						{
							$total_mort = $mort_balance;
						}
					}

					$year = 0;
					for($m = 1; $m <= $max_months_display; $m++)
					{
						if($m % 12 == 0 || $m == $max_months_display)
						{
							$pv = abs($f->PV($rep['mortgage_rate']/100/12,$mort_term - $m,$rep['est_mortgage_payment']));
							$chart['Mortgage'][] = $pv;
						}
					}
					ob_start();
					$value_new = 0;
					for($m = 1; $m <= $max_months_display; $m++)
					{

						if($m % 12 == 0 || $m == $max_months_display){

								$Mortgage = (round($chart['Mortgage'][$value_new])!='' ? round($chart['Mortgage'][$value_new]) : 0);
								$HEAP 	  = (round($chart['HEAP'][$value_new])!='' ? round($chart['HEAP'][$value_new]) : 0);
								$HELOC    = (round($chart['HELOC'][$value_new])!='' ? round($chart['HELOC'][$value_new]) : 0);

								$displlay_year = $value_new;
						?>

                               <tr>
                               <td align="left" valign="top" width="10%">
                                 <?php echo "Year ".($displlay_year+1);?>
                               </td>
                                <td align="left" valign="top">
                                    <div class="chart-horiz clearfix">
                                      <!-- Actual bar chart -->
                                      <ul class="chart">
                                    	<li class="current" title=""><span class="bar Mortgage" data-number="<?php echo $Mortgage; ?>"></span><span class="number"><?php echo "$".$Mortgage; ?></span></li>
                                    	<li class="past" title=""><span class="bar heap" data-number="<?php echo $HEAP; ?>"></span><span class="number"><?php echo "$".$HEAP; ?></span></li>
                                    	<li class="past" title=""><span class="bar helco" data-number="<?php echo $HELOC; ?>"></span><span class="number"><?php echo "$".$HELOC; ?></span></li>
                                    </ul>
                                   </div>

                                </td>
                               </tr>

                        <?php

						$value_new++;
						}
					}
						$array_start = ob_get_contents();
						ob_clean();
						$data["result"]  	= "success";
						$data["message"] 	= "Graph data availabe.";
						$data["graphdata"]  = $array_start;

					}else{
						$data["result"] = "error";
						$data["message"] = "Sorry no graph data availabe.";
					}
					}else{
						$data["result"] = "error";
						$data["message"] = "Sorry no graph data availabe.";
					}
				}
			echo json_encode($data);
			break;
			case "resetPassword":
				if($USER_TYPE=="adviser")
					resetPassword($cgroup_id,trim($_POST["email"]));
				else
					resetPasswordClient($cgroup_id,trim($_POST["email"]));
			break;
			case "changePassword":
				$change_user_email 		= trim($_POST["change_user_email"]);
				$verification_code 		= trim($_POST["verification_code"]);
				$newpassword  = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
				$plain_password		 	= trim($_POST["newpassword"]);
				$repeat_newpassword 	= trim($_POST["repeat_newpassword"]);
			if($USER_TYPE=="adviser"){
				$resultset =& $db_connect->Query("SELECT advisers.* FROM advisers Inner Join adviser_cgroups ON adviser_cgroups.adviser_id=advisers.id AND adviser_cgroups.cgroup_id='".$cgroup_id."' WHERE advisers.email_address = '".$change_user_email."' AND advisers.reset_password_pincode = '".$verification_code."' AND advisers.reset_password_pincode != ''  AND advisers.reset_password_pincode != '0' AND advisers.email_address!=''","SELECT");

					if($resultset->numRows() && is_numeric($verification_code)){
						$row = $db_connect->FetchAssocRow($resultset);
						if((int)$row["reset_password_pincode"]===(int)$verification_code){

							$update =& $db_connect->Query("UPDATE advisers SET  reset_password_pincode = '', password = '".$newpassword."', plain_password = '".$plain_password."',reset_password_expiry = '' WHERE id= '".$row["id"]."'","UPDATE");

							$data["result"] = "success";
							$data["message"] = "Your password successfully changed.";
					}else{
						$data["result"] = "error";
						$data["message"] = "Invalid Pincode.";
					}

				}else{
					$data["result"] = "error";
					$data["message"] = "Invalid pincode or email address.";
				}
			}else{
				$resultset =& $db_connect->Query("SELECT clients.* FROM clients Inner Join client_cgroups ON client_cgroups.client_id=clients.id AND client_cgroups.cgroup_id='".$cgroup_id."' WHERE clients.email_address = '".$change_user_email."' AND clients.reset_password_pincode = '".$verification_code."' AND clients.reset_password_pincode != ''  AND clients.reset_password_pincode != '0' AND clients.email_address!=''","SELECT");

					if($resultset->numRows() && is_numeric($verification_code)){
						$row = $db_connect->FetchAssocRow($resultset);
						if((int)$row["reset_password_pincode"]===(int)$verification_code){
							$update =& $db_connect->Query("UPDATE clients SET  reset_password_pincode = '', password = '".$newpassword."',reset_password_expiry = '' WHERE id= '".$row["id"]."'","UPDATE");

							$data["result"] = "success";
							$data["message"] = "Your password successfully changed.";
					}else{
						$data["result"] = "error";
						$data["message"] = "Invalid Pincode.";
					}

				}else{
					$data["result"] = "error";
					$data["message"] = "Invalid pincode or email address.";
				}

			}
				echo json_encode($data);
			break;
			case "loadCreateReportHTML":
				include_once("API_REPORT_HTML.php");
			break;
			case "saveCreteReport":
				$adviser_id 	= (int)$_POST['adviser_id'];
				$client_id 		= (int)$_POST['client_id'];
				$expenses['expense'] = is_array($_POST['expense']) ? $_POST['expense'] : array();
				$expenses['balance'] = is_array($_POST['balance']) ? $_POST['balance'] : array();
				$expenses['payments'] = is_array($_POST['payments']) ? $_POST['payments'] : array();
				$expenses['addTo_heloc'] = is_array($_POST['addTo_heloc']) ? $_POST['addTo_heloc'] : array();
				$expenses['other']['amount'] = is_array($_POST['otherAmount']) ? $_POST['otherAmount'] : array();
				$expenses['nonMonthly']['annual_amount'] = !empty($_POST['annual_exp_amount']) ? $_POST['annual_exp_amount'] : '$ 0.00';
				$expenses['nonMonthly']['semi_amount'] = !empty($_POST['semi_exp_amount']) ? $_POST['semi_exp_amount'] : '$ 0.00';
				$serialized_expenses = serialize($expenses);
				include_once("API_CREATE_REPORT.php");
			break;
			case "updateTermHTML":
				include_once("API_REPORT_UPDATE_HTML.php");
			break;
			case "oldTermUpdate":
				$adviser_id 	= (int)$_POST['adviser_id'];
				$client_id 		= (int)$_POST['client_id'];
				$term	 		= (int)$_POST['term'];
				$report_id	 	= (int)$_POST['report_id'];
				$expenses['expense'] = is_array($_POST['expense']) ? $_POST['expense'] : array();
				$expenses['balance'] = is_array($_POST['balance']) ? $_POST['balance'] : array();
				$expenses['payments'] = is_array($_POST['payments']) ? $_POST['payments'] : array();
				$expenses['addTo_heloc'] = is_array($_POST['addTo_heloc']) ? $_POST['addTo_heloc'] : array();
				$expenses['other']['amount'] = is_array($_POST['otherAmount']) ? $_POST['otherAmount'] : array();
				$expenses['nonMonthly']['annual_amount'] = !empty($_POST['annual_exp_amount']) ? $_POST['annual_exp_amount'] : '$ 0.00';
				$expenses['nonMonthly']['semi_amount'] = !empty($_POST['semi_exp_amount']) ? $_POST['semi_exp_amount'] : '$ 0.00';
				$serialized_expenses = serialize($expenses);
				include_once("API_OLD_TERM_UPDATE.php");
			break;
			case "newTermUpdate":
				$adviser_id 	= (int)$_POST['adviser_id'];
				$client_id 		= (int)$_POST['client_id'];
				$term	 		= (int)$_POST['term'];
				$report_id	 	= (int)$_POST['report_id'];
				$expenses['expense'] = is_array($_POST['expense']) ? $_POST['expense'] : array();
				$expenses['balance'] = is_array($_POST['balance']) ? $_POST['balance'] : array();
				$expenses['payments'] = is_array($_POST['payments']) ? $_POST['payments'] : array();
				$expenses['addTo_heloc'] = is_array($_POST['addTo_heloc']) ? $_POST['addTo_heloc'] : array();
				$expenses['other']['amount'] = is_array($_POST['otherAmount']) ? $_POST['otherAmount'] : array();
				$expenses['nonMonthly']['annual_amount'] = !empty($_POST['annual_exp_amount']) ? $_POST['annual_exp_amount'] : '$ 0.00';
				$expenses['nonMonthly']['semi_amount'] = !empty($_POST['semi_exp_amount']) ? $_POST['semi_exp_amount'] : '$ 0.00';
				$serialized_expenses = serialize($expenses);
				include_once("API_NEW_TERM_UPDATE.php");
			break;
			case "createAdviser":
				$bc_username	=	$_POST["adviser_username"];
				$bc_password	=	$_POST["password"];
				$bc_first_name	=	DBin($_POST["first_name"]);
				$bc_last_name	=	DBin($_POST["last_name"]);
				$bc_email_address	= $_POST["email_address"];
				$bc_address1	=	DBin($_POST["address1"]);
				$bc_address2	=	DBin($_POST["address2"]);
				$bc_city		=	DBin($_POST["city"]);
				$bc_state		=	DBin($_POST["states_adviser"]);
				$bc_zipcode		=	DBin($_POST["zipcode"]);
				$bc_phone		=	$_POST["phone"];
				$app_coupon		=	$_POST["app_coupon"];
				$coupon_code	=	$_POST["coupon_code"];
				$backend        = 	1;

			if($USER_TYPE=="adviser"){
				$alredy_username 	  = getSingleColumn("username","select username from advisers where username='".$bc_username."'");
				if($alredy_username!=''){
						apiError("Username already exist.");
				}
				$alredy_email_address = getSingleColumn("email_address","select email_address from advisers where email_address='".$bc_email_address."'");
				if($alredy_email_address!=''){
						apiError("Email already exist.");
				}
				if($app_coupon=="yes"){
					$resultset =& $db_connect->Query("SELECT * FROM coupon_codes WHERE coupon_code='".$coupon_code."'","SELECT");

					if($resultset->numRows()){
						$row = $db_connect->FetchAssocRow($resultset);
						if($row["allow_use"]>0 && $row["total_use"] >= $row["allow_use"]){
							apiError("Invalid coupon code");
						}else{
							include_once("API_CREATE_ADVISER.php");
							echo json_encode($data);
						}
					}else{
						apiError("Invalid coupon code.");
					}

				}else if($app_coupon=="no"){

					 include_once("authorize.net.php");
					 $customer_details = array("first_name" => $bc_first_name,"last_name" => $bc_last_name,"email_address" => $bc_email_address,"address1" => $bc_address1,"address2" => $bc_address2,"city" => $bc_city,"state" => $bc_state,"zipcode" => $bc_zipcode,"phone" => $bc_phone,"card_number" => $_POST["card_number"],"month" => $_POST["month"],"year" => $_POST["year"],"card_cvv" => $_POST["card_cvv"]);

					 $response = authorize_process($customer_details);
					 list($processed, $response_arr) = authorize_isProcessed($response);
					 $response_code = $response_arr[0];
					 $response_reason = $response_arr[3];
					 $response_full = serialize($response_arr);

					 if (!$processed) {
					 	apiError("Sorry we are unable to process your credit card.");

					 }else{
					  	$transaction_id = $response_arr[6];
						include_once("API_CREATE_ADVISER.php");
						echo json_encode($data);

					 }

					}
			}else{
					$alredy_username 	  = getSingleColumn("username","select username from clients where username='".$bc_username."'");
					if($alredy_username!=''){
							apiError("Username already exist.");
					}
					$alredy_email_address = getSingleColumn("email_address","select email_address from clients where email_address='".$bc_email_address."'");
					if($alredy_email_address!=''){
							apiError("Email already exist.");
					}

					$resultset =& $db_connect->Query("SELECT * FROM adviser_coupon_codes WHERE coupon_code='".$coupon_code."'","SELECT");

					if($resultset->numRows()){
						$row = $db_connect->FetchAssocRow($resultset);
						if($row["is_active"]!="Yes" || $row["total_use"] >= 1){
							apiError("Invalid coupon code");
						}else{
							$adviser_id = $row["adviser_id"];
							include_once("API_CREATE_CLIENT.php");
							echo json_encode($data);
						}
					}else{
						apiError("Invalid coupon code.");
					}

			}

			break;
			case "appPrice":
				$resultset =& $db_connect->Query("select appPrice from app_configration LIMIT 1","SELECT");
				if($resultset->numRows()){
					$row = $db_connect->FetchAssocRow($resultset);
					$appPrice	= number_format((float)$row["appPrice"], 2, '.', '');
					$data["result"]   = "success";
					$data["appPrice"] = $appPrice;
					echo json_encode($data);
				}

			break;
			default:
				apiError("Sorry we are unable to identify your request.");
			break;
		endswitch;


	}else{
		$data["result"] = "error";
		$data["message"] = "Sorry we are unable to identify your request.";
		echo json_encode($data);
		exit();
	}
?>
