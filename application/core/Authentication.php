<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {

	public $data = array();

	function __construct() {
		parent::__construct();
	    $this->load->library('session');
	    $this->load->helper('url');
	    if ( !$this->session->userdata('user_id')) {
	    	echo $this->router->class;exit();
	        redirect('authentication/login');
	    }

		$this->load->model("user_model");

	}

	public function index()
	{
		//$this->load->view('login');
		die("Are you lost?");
	}

	public function login() {

		if( $this->isLogin() ) {
			redirect('/dashboard', 'refresh');
		}

		if( count($this->input->post()) > 0 ) {
			if( $this->input->post("username") != "" && $this->input->post("password") != "" ) {
				$username = $this->input->post("username", TRUE);
				$password = $this->input->post("password", TRUE);
				if( $this->user_model->validateLogin( $username, $password ) ) {
					redirect('/dashboard', 'refresh');
				} else {
					 $this->data['error'] = "Wrong username/email or password!";
				}
			} else {
				$this->data['error'] = "Please enter username/email or password!";
			}
		}

		$this->load->view("login", $this->data);
	}

	public function register() {
		$this->load->view('register');
	}

	public function isLogin() {
		if($this->session->userdata('whatever_session_name_is')){
	    	// do something when exist
	    	return true;
		}else{
		    // do something when doesn't exist
		    return false;
		}
	}
}
