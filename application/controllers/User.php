<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public $data = array();

	function __construct() {
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->load->model("user_model");
	}

	public function index()
	{
		$this->load->view('errors/html/error_404');
	}

	public function listAdmins() {

		$params = array();
		$params["user_type"] = 2;
		$admins = $this->user_model->getUsers( $params );
		
		$this->data["admins"] = $admins;
		$this->load->view('common/header', $this->data);
		$this->load->view('admins/list', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function listTeachers() {

		$params = array();
		$params["user_type"] = 3;
		$teachers = $this->user_model->getUsers( $params );
		
		$this->data["teachers"] = $teachers;
		$this->load->view('common/header', $this->data);
		$this->load->view('teachers/list', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function listStudents() {

		$params = array();
		$params["user_type"] = 4;
		$students = $this->user_model->getUsers( $params );

		$this->data["students"] = $students;
		$this->load->view('common/header', $this->data);
		$this->load->view('students/list', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function registerAdmin() {

		if( count($this->input->post()) > 0 ) {

			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('cnic', 'CNIC', 'trim|required');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			$this->form_validation->set_rules('dob', 'DOB', 'trim|required');
			$this->form_validation->set_rules('address', 'Address', 'trim|required');
			$this->form_validation->set_rules('contact', 'Contact#', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[6]|max_length[200]valid_email|is_unique[ep_users.email]');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[100]|is_unique[ep_users.username]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[100]');
            $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');

            if ($this->form_validation->run() == FALSE) {
                // ERROR IN FORM 

            } else {
                /* FROM SUBMITTED SUCCESSFULLYs */
                $register_data = array();
            	$register_data["first_name"] = $this->input->post("first_name");
				$register_data["last_name"] = $this->input->post("last_name");
				$register_data["cnic"] = $this->input->post("cnic");
				$register_data["gender"] = $this->input->post("gender");
				$register_data["dob"] = date("Y-m-d", strtotime($this->input->post("dob")));
				$register_data["address"] = $this->input->post("address");
				$register_data["contact"] = $this->input->post("contact");
				$register_data["email"] = $this->input->post("email");
				$register_data["username"] = $this->input->post("username");
				$register_data["password"] = $this->input->post("password");
				$register_data["confirm_password"] = $this->input->post("confirm_password");
				$register_data["status"] = 1;
				$register_data["user_type"] = 2;

				$user = $this->user_model->registerUser( $register_data );
				if( $user ) {
					redirect('/admins', 'refresh');
				} else {

				}
            }

			
		}

		$this->load->view('common/header', $this->data);
		$this->load->view('admins/register', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function registerTeacher() {

		if( count($this->input->post()) > 0 ) {

			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('cnic', 'CNIC', 'trim|required');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			$this->form_validation->set_rules('dob', 'DOB', 'trim|required');
			$this->form_validation->set_rules('address', 'Address', 'trim|required');
			$this->form_validation->set_rules('contact', 'Contact#', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[6]|max_length[200]valid_email|is_unique[ep_users.email]');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[100]|is_unique[ep_users.username]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[100]');
            $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');

            if ($this->form_validation->run() == FALSE) {
                // ERROR IN FORM 

            } else {
                /* FROM SUBMITTED SUCCESSFULLYs */
                $register_data = array();
            	$register_data["first_name"] = $this->input->post("first_name");
				$register_data["last_name"] = $this->input->post("last_name");
				$register_data["cnic"] = $this->input->post("cnic");
				$register_data["gender"] = $this->input->post("gender");
				$register_data["dob"] = date("Y-m-d", strtotime($this->input->post("dob")));
				$register_data["address"] = $this->input->post("address");
				$register_data["contact"] = $this->input->post("contact");
				$register_data["email"] = $this->input->post("email");
				$register_data["username"] = $this->input->post("username");
				$register_data["password"] = $this->input->post("password");
				$register_data["confirm_password"] = $this->input->post("confirm_password");
				$register_data["status"] = 1;
				$register_data["user_type"] = 3;

				$user = $this->user_model->registerUser( $register_data );
				if( $user ) {
					redirect('/teachers', 'refresh');
				} else {

				}
            }

			
		}

		$this->load->view('common/header', $this->data);
		$this->load->view('teachers/register', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function registerStudent() {

		if( count($this->input->post()) > 0 ) {

			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('cnic', 'CNIC', 'trim|required');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			$this->form_validation->set_rules('dob', 'DOB', 'trim|required');
			$this->form_validation->set_rules('address', 'Address', 'trim|required');
			$this->form_validation->set_rules('contact', 'Contact#', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[6]|max_length[200]valid_email|is_unique[ep_users.email]');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[100]|is_unique[ep_users.username]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[100]');
            $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');

            if ($this->form_validation->run() == FALSE) {
                // ERROR IN FORM 

            } else {
                /* FROM SUBMITTED SUCCESSFULLYs */
                $register_data = array();
            	$register_data["first_name"] = $this->input->post("first_name");
				$register_data["last_name"] = $this->input->post("last_name");
				$register_data["cnic"] = $this->input->post("cnic");
				$register_data["gender"] = $this->input->post("gender");
				$register_data["dob"] = date("Y-m-d", strtotime($this->input->post("dob")));
				$register_data["address"] = $this->input->post("address");
				$register_data["contact"] = $this->input->post("contact");
				$register_data["email"] = $this->input->post("email");
				$register_data["username"] = $this->input->post("username");
				$register_data["password"] = $this->input->post("password");
				$register_data["confirm_password"] = $this->input->post("confirm_password");
				$register_data["status"] = 1;
				$register_data["user_type"] = 4;

				$user = $this->user_model->registerUser( $register_data );
				if( $user ) {
					redirect('/students', 'refresh');
				} else {

				}
            }

			
		}

		$this->load->view('common/header', $this->data);
		$this->load->view('students/register', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function edit( $user_id ) {
	}

	public function delete( $user_id ) {
		
		$params = array("id", $user_id);
		$user = $this->user_model->getUsers( $params );
		$user = $user[0];

		$logged_in_type = $this->session->userdata("user_type");

		if( $user["id"] == 1 ) {
			//set error
			redirect();
		}

		switch ($logged_in_type) {
			case 1:
				$this->user_model->deleteUser( $user_id );
				// set success message
				redirect();
				break;

			case 2:
				if( $user["user_type"] == 2 || $user["user_type"] == 3 ) {
					$this->user_model->deleteUser( $user_id );
					// set success message
				} else {
					// set error message
				}
				redirect();
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

	public function profile() {
		
	}

}
