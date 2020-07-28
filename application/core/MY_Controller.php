<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->library('session');
	    $this->load->helper('url');
	    if ( !$this->session->userdata('logged_in')) {
	    	//echo $this->router->class;
	    	if( $this->router->class != "authentication" ) {
	    		redirect('authentication/login');
	    		exit();
	    	}
	    } else {
	    	$logged_in_type = $this->session->userdata("user_type");
	    	switch ($logged_in_type) {
	    		case 1:
	    			break;

	    		case 2:
	    			break;

	    		case 3:
	    			break;

	    		case 4:
	    			break;

	    		default:
	    			# code...
	    			break;
	    	}
	    }

		$this->load->model("user_model");

	}

	public function index()
	{
		//$this->load->view('login');
		die("Are you lost?");
	}
}
