<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Authentication extends MY_Controller {
    public $data = array();
    function __construct() {
        parent::__construct();
        //$this->load->library('session');
	    //$this->load->helper('url');
		$this->load->model("user_model");
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

	public function isLogin() {
		if($this->session->userdata('logged_in')){
	    	return true;
		}else{
		    return false;
		}
	}
}
