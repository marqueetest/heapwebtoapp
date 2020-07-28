<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grade extends MY_Controller {

	public $data = array();

	function __construct() {
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->load->model("user_model");
		$this->load->model("grade_model");
	}

	public function index() {
		$this->load->view('errors/html/error_404');
	}

	public function listGrades() {
		$params = array();
		$logged_in_type = $this->session->userdata("user_type");
		switch ($logged_in_type) {
			case 1:
				$grades = $this->grade_model->listGrades( $params );
				$this->data["grades"] = $grades;
				break;
			case 2:
				break;
			case 3:
				break;
			case 4:
				break;
			default:
				$this->data["grades"] = array();
				break;
		}
		$this->load->view('common/header', $this->data);
		$this->load->view('grades/list', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function registerGrade() {

		if( count($this->input->post()) > 0 ) {

			$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[1]|max_length[200]|is_unique[ep_classes.title]');
			$this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() == FALSE) {
                // ERROR IN FORM 

            } else {
                /* FROM SUBMITTED SUCCESSFULLYs */
                $register_data = array();
            	$register_data["title"] = $this->input->post("title");
				$register_data["description"] = $this->input->post("description");
				$register_data["status"] = 1;
				$register_data["created_datetime"] = date("Y-m-d H:i:s");
				$register_data["updated_datetime"] = date("Y-m-d H:i:s");

				$class = $this->grade_model->registerGrade( $register_data );
				if( $class ) {
					redirect('/classes', 'refresh');
				} else {

				}
            }
		}

		$this->load->view('common/header', $this->data);
		$this->load->view('grades/register', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function edit( $grade_id ) {

	}

	public function delete( $grade_id ) {

		$logged_in_type = $this->session->userdata("user_type");


		switch ($logged_in_type) {
			case 1:
				$this->grade_model->deleteGrade( $grade_id );
				// set success message
				redirect("/grades");
				break;

			case 2:
				$this->grade_model->deleteGrade( $grade_id );
				// set success message
				redirect("/grades");
				break;

			case 3:
				// set error message
				redirect();
				break;

			case 4:
				// set error message
				redirect();
				break;
			
			default:
				// set error message
				redirect();
				break;
		}

	}

}
