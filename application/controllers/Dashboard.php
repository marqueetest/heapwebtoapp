<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public $data = array();
	public $adviser_id;

	function __construct() {
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('session');

		$this->load->model("client_model");
		$this->adviser_id = $this->session->userdata("adviser_id");
	}

	public function index() {

		$this->load->view('common/header', $this->data);
		$this->load->view('dashboard', $this->data);
		$this->load->view('common/footer', $this->data);
	}

}
