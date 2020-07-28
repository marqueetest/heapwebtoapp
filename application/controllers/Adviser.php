<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adviser extends MY_Controller {

    public $data = array();
	public $adviser_id;

	function __construct() {
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->load->model("client_model");
		$this->load->model("adviser_model");

		$this->adviser_id = $this->session->userdata("adviser_id");
	}

	public function index() {
		$this->load->view('errors/html/error_404');
	}

	public function settings() {
		if( count($this->input->post()) > 0 ) {
			$this->form_validation->set_rules('password', 'Current Password', 'trim|required|callback_password_check');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[100]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');

            if ($this->form_validation->run() == FALSE) {
                // ERROR IN FORM
            } else {
            	/* UPDATE SETTINGS */
            	$update_data = array();
				$password= $this->input->post("new_password");
				$update_data["password"] = password_hash( $password, PASSWORD_DEFAULT);
				$update_data["password_old"] = $this->input->post("new_password");
				$updateAdviser = $this->adviser_model->updateAdviser( $update_data, $this->adviser_id );
				if( $updateAdviser ) {
					$this->session->set_flashdata('success', 'Password updated successfully!');
				} else {
					$this->session->set_flashdata('error', 'There is a problem processing your request!');
				}
            }

		}

		$params = array("id" => $this->adviser_id);
		$adviser = $this->adviser_model->heapGetAdviser( $params );

		if( $adviser ) {
			$adviser = $adviser[0];
			$this->data["adviser"] = $adviser;
		}

		$this->load->view('common/header', $this->data);
		$this->load->view('common/settings', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	// changed
	// public function password_check(){
	//    	$password = $this->input->post('password');
	//    	$params = array("id" => $this->adviser_id);
	//    	$adviser = $this->adviser_model->heapGetAdviser( $params );
	//    	if( $adviser ) {
	//    		$adviser = $adviser[0];
	//    		if( $adviser["password"] != $password ) {
	//    			$this->form_validation->set_message('password_check', 'Current password does not match.');
	//       		return FALSE;
	//    		}
	//    	} else {
	//    		$this->form_validation->set_message('password_check', 'Invalid Request.');
	//       	return FALSE;
	//    	}

	//    return TRUE;
	// }

	public function password_check(){
		$password = $this->input->post('password');
		$params = array("id" => $this->adviser_id);
		$adviser = $this->adviser_model->heapGetAdviser( $params );
		if( $adviser ) {
			$adviser = $adviser[0];
			$match_password = password_verify( $password , $adviser["password"] );
			if($match_password == 1) {
				return true;
			}else{
				$this->form_validation->set_message('password_check', 'Current password does not match.');
				return FALSE;
			}
		} else {
			$this->form_validation->set_message('password_check', 'Invalid Request.');
		   return FALSE;
		}

	return TRUE;
 }

}
