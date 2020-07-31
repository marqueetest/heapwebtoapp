<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Authentication extends MY_Controller {
    public $data = array();
    function __construct() {
        parent::__construct();
        //$this->load->library('session');
		//$this->load->helper('url');
		$this->load->model("user_model");
		$this->load->model("client_model");
	}

	public function index() {
		die("Are you lost?");
	}

	public function login() {
		if( $this->isLogin() ) {
			redirect(base_url(), 'refresh');
		}
		if( count($this->input->post()) > 0 ) {
			if( $this->input->post("username") != "" && $this->input->post("password") != "" ) {
				$username = $this->input->post("username", TRUE);
				$password = $this->input->post("password", TRUE);
				$loginData = $this->user_model->validateClientLogin( $username, $password );
			
				if( $loginData ) {
					/* Login successful. Set session and add login entry */
					$client_row = $loginData[0];
					if($client_row["api_access_admin_controll"]=='1'){
						$match_password = password_verify( $password , $client_row['password'] );
						if($match_password == 1){
							$adviser_id = getSingleColumn("adviser_id","SELECT `adviser_id` from adviser_clients where client_id = '".(int)$client_row["id"]."'");
							$sessionData = array(
								"client_id" => $client_row["id"],
								"adviser_id" => $adviser_id,
								"username" => $client_row["username"],
								"first_name" => $client_row["first_name"],
								"last_name" => $client_row["last_name"],
								"auth" => TRUE,
								"cgroup_id" => 1,
								'logged_in' => TRUE
							);
							$this->session->set_userdata($sessionData);
							if($this->input->post("save")){
								$day = time() + 3600;
								setcookie('remember_user', $this->input->post("username"), $day);
								setcookie('remember_pwd', $this->input->post("password"), $day);
							}
							//$this->user_model->addLoginHistory( $loginData["id"] );
							redirect(base_url(), 'refresh');
							// redirect('report/reportStep1/'.$client_row["id"], 'refresh');
							
						}else{
							$this->data['error'] = "Invalid password";
						}
						
					} else {
						$this->data['error'] = "Sorry app access is disable.Please contact you adviser";
					}
				
				} else {
					 $this->data['error'] = "Wrong username/email or password!";
				}
			} else {
				$this->data['error'] = "Please enter username or password!";
			}
		}
		$this->load->view("login", $this->data);
	}

	public function logout() {
		$this->session->unset_userdata('client_id');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('first_name');
		$this->session->unset_userdata('last_name');
		$this->session->unset_userdata('auth');
		$this->session->unset_userdata('cgroup_id');
		$this->session->unset_userdata('cgroup_id');
		$this->session->sess_destroy();
		redirect('/authentication/login', 'logged_in');
	}

	public function impersonate( $admin_adviser_id ) {
		$adviser_id = tep_decrypt_impersonate($admin_adviser_id);

		$loginData = $this->user_model->impersonateLogin( $adviser_id );
		if( $loginData ) {
			/* Login successful. Set session and add login entry */
			$loginData = $loginData[0];
			$permissions = $this->user_model->getAdviserPermissions( $loginData["id"] );
			$permissions = $permissions[0]["adviser_permissions"];
			$permissions = explode(",", $permissions);
			$sessionData = array(
				"adviser_id" => $loginData["id"],
				"username" => $loginData["username"],
				"first_name" => $loginData["first_name"],
				"last_name" => $loginData["last_name"],
				"auth" => TRUE,
				"cgroup_id" => $loginData["cgroup_id"],
				"permissions" => $permissions,
            	'logged_in' => TRUE
           	);
			$this->session->set_userdata($sessionData);
			if($this->input->post("save")){
                $day = time() + 3600;
                setcookie('remember_user', $this->input->post("username"), $day);
                setcookie('remember_pwd', $this->input->post("password"), $day);
            }
			//$this->user_model->addLoginHistory( $loginData["id"] );
			redirect(base_url(), 'refresh');
		} else {
			 $this->data['error'] = "Invalid Request!";
		}
	}

	public function register() {
		$this->load->view('register');
	}

	public function forgot() {
		if( $this->isLogin() ) {
			redirect(base_url(), 'refresh');
		}
		if( count($this->input->post()) > 0 ) {
			if( $this->input->post("forgot_user_email") != "") {
				$email = $this->input->post("forgot_user_email", TRUE);
				$cgroup_id = 1;
				$cleintData = $this->client_model->validateClientEmail( $cgroup_id, $email );
				
				$email_address = trim($email);
				if( $cleintData ) {
					/* Login successful. Set session and add login entry */
					$reset_password_pincode = $this->client_model->random_numbers(4);
					$reset_password_expiry = date("Y-m-d H:i:s",strtotime(date('Y-m-d H:i:s'))+86400);
					$client_row = $cleintData[0];
					$client_id = $client_row['id'];

					$reset_email_text = '
						<table style="padding:68px 75px" width="100%" bgcolor="#ebebeb" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td>
										<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
											<tbody>
												<tr>
													<td>
														<table style="border-collapse:collapse" width="660" align="center" border="0" cellpadding="0" cellspacing="0">
															<tbody>
																<tr>
																	<td style="padding:45px 0 30px 0" colspan="3" align="center">
																		<img src="http://www.heaplan.com/wp-content/uploads/2015/03/Heaplan-280-501.png" alt="Heaplan" style="display:block" height="52" width="205" >
																	</td>
																</tr>
																<tr>
																	<td style="padding:5px 75px" colspan="3" align="center">
																	Dear '.ucwords($client_row['first_name']). ' ' . ucwords($client_row['last_name']).',
																	</td>
																</tr>
																<tr>
																	<td style="padding:5px 75px" colspan="3" align="center">
																	Thank you for contacting us, Below is your password reset pincode.<br><br><h2>'.(int)$reset_password_pincode.'</h2><br><br>This pincode will be expire after 24 hours.
																	</td>
																</tr>
																<tr>
																	<td style="padding:5px 75px" colspan="3" align="center">
																	If you have any queries, feel free to contact at info@heaplan.com<br>Thank you,
																	</td>
																</tr>

																<tr>
																	<td style="padding:20px 0"><br>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>';

					$to = ucwords($client_row['first_name']). ' ' . ucwords($client_row['last_name'])."<".$email_address.">";
					$subject  = 'Password Reset Pincode';
					$headers  = "From: Heaplan <" . strip_tags("info@heaplan.com") . ">\r\n";
					$headers .= "Reply-To: ". strip_tags("info@heaplan.com") . "\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					$headers .= "X-Priority: 1\r\n";
					@mail($to, $subject, $reset_email_text, $headers);

					$cleintDataUpdate = $this->client_model->updateClientResetPassword($reset_password_pincode, $reset_password_expiry, $client_id );
					$this->session->set_flashdata('success', 'Password reset pincode has been sent your e-mail address.Please check your Inbox or Spam Folder');
					redirect('/reset-password?email=aklapawar@gmail.com', 'refresh');
				}
					$this->data['error'] = "Your email is not exits. Please enter valid email";
					$this->load->view("forgot", $this->data);
			}
				$this->data['error'] = "Please enter email";
		}

		$this->load->view("forgot", $this->data);
	}

	public function resetPassword() {
		if( $this->isLogin() ) {
			redirect(base_url(), 'refresh');
		}
		
		if( count($this->input->post()) > 0 ) {
			if( $this->input->post("change_user_code") != "") {
				$change_user_email 		= trim($this->input->post("change_user_email", TRUE));
				$verification_code 		= trim($this->input->post("change_user_code", TRUE));
				$newpassword		 	= trim($this->input->post("chnage_new_password", TRUE));
				$repeat_newpassword 	= trim($this->input->post("chnage_repeat_password", TRUE));
				$cgroup_id = 1;
				
				$resetData = array(
					"change_user_email" => $change_user_email,
					"verification_code" => $verification_code,
					"newpassword" => $newpassword,
					"repeat_newpassword" => $repeat_newpassword,
					"cgroup_id" => $cgroup_id
				);
				$cleintResetPass = $this->client_model->resetClientPassword($resetData);
				if(sizeof($cleintResetPass) != 0 && is_numeric($verification_code)){
						$client_row = $cleintResetPass[0];
						$reset_password_pincode = $client_row["reset_password_pincode"];
						if((int)$reset_password_pincode === (int)$verification_code){
							$client_id = $client_row['id'];
							$cleintResetPass = $this->client_model->updateResetClientPassword($resetData, $client_id);	
							$this->session->set_flashdata('success', 'Your password successfully changed');				
							redirect('/authentication/login', 'refresh');
						}else{
							$this->data['error'] = "Invalid pincode";
							$this->load->view("reset-password", $this->data);
						}
				}else{
					$this->data['error'] = "Invalid pincode or email address.";
					$this->load->view("reset-password", $this->data);
				}
			}else{
				$this->data['error'] = "Please enter varification pincode";
				$this->load->view("reset-password", $this->data);
			}
				$this->data['error'] = "Please enter email";
				$this->load->view("reset-password", $this->data);
		}

		$this->load->view("reset-password", $this->data);
	}

	public function isLogin() {
		if($this->session->userdata('logged_in')){
	    	return true;
		}else{
		    return false;
		}
	}

}
