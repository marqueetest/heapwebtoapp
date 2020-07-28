<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends MY_Controller {

    public $data = array();
    public $adviser_id;

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
    	$this->load->library('form_validation');

		$this->load->model("client_model");

		$this->adviser_id = $this->session->userdata("adviser_id");
	}

	public function index() {
		$this->load->view('errors/html/error_404');
	}

	public function registerClient() {

		if( count($this->input->post()) > 0 ) {
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('address1', 'Address', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
			$this->form_validation->set_rules('email_address', 'Email', 'trim|required|min_length[6]|max_length[200]valid_email|is_unique[clients.email_address]');
			$this->form_validation->set_rules('username', 'Username', 'trim|min_length[4]|max_length[100]|is_unique[clients.username]|callback_check_username_password');
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]|max_length[100]');
            $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|matches[password]');

            if ($this->form_validation->run() == FALSE) {
                // ERROR IN FORM
            } else {
            	/* FROM SUBMITTED SUCCESSFULLYs */
                $register_data = array();
            	$register_data["first_name"] = $this->input->post("first_name");
				$register_data["last_name"] = $this->input->post("last_name");
				$register_data["address1"] = $this->input->post("address1");
				$register_data["address2"] = $this->input->post("address2");
				$register_data["city"] = $this->input->post("city");
				$register_data["state"] = $this->input->post("state");
				$register_data["zipcode"] = $this->input->post("zipcode");
				$register_data["phone"] = $this->input->post("phone");
				$register_data["email_address"] = $this->input->post("email_address");
				$register_data["username"] = $this->input->post("username");
				$register_data["password"] = $this->input->post("password");
				$register_data["confirm_password"] = $this->input->post("confirm_password");
				$register_data["api_access_admin_controll"] = $this->input->post("api_access_admin_controll");
				$register_data["created_date"] = date("Y-m-d H:i:s");
				$register_data["adviser_id"] = $this->session->userdata("adviser_id");

				$client = $this->client_model->addClient( $register_data );
				if( $client ) {
					$this->session->set_flashdata('success', 'Client added successfully!');
					redirect('/heap-clients', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'There is a problem processing your request!');
					redirect('/register-clients', 'refresh');
				}
            }
		}

		$this->data["states"] = array(
			"AL" => "Alabama",
			"AK" => "Alaska",
			"AZ" => "Arizona",
			"AR" => "Arkansas",
            "CA" => "California",
            "CO" => "Colorado",
            "CT" => "Connecticut",
            "DE" => "Delaware",
            "DC" => "District of Columbia",
            "FL" => "Florida",
            "GA" => "Georgia",
            "HI" => "Hawaii",
            "ID" => "Idaho",
            "IL" => "Illinois",
            "IN" => "Indiana",
            "IA" => "Iowa",
            "KS" => "Kansas",
            "KY" => "Kentucky",
            "LA" => "Louisiana",
            "ME" => "Maine",
            "MD" => "Maryland",
            "MA" => "Massachusetts",
            "MI" => "Michigan",
            "MN" => "Minnesota",
            "MS" => "Mississippi",
            "MO" => "Missouri",
            "MT" => "Montana",
            "NE" => "Nebraska",
            "NV" => "Nevada",
            "NH" => "New Hampshire",
            "NJ" => "New Jersey",
            "NM" => "New Mexico",
            "NY" => "New York",
            "NC" => "North Carolina",
            "ND" => "North Dakota",
            "OH" => "Ohio",
            "OK" => "Oklahoma",
            "OR" => "Oregon",
            "PA" => "Pennsylvania",
            "PR" => "Puerto Rico",
            "RI" => "Rhode Island",
            "SC" => "South Carolina",
            "SD" => "South Dakota",
            "TN" => "Tennessee",
            "TX" => "Texas",
            "UT" => "Utah",
            "VT" => "Vermont",
            "VI" => "Virgin Islands",
            "VA" => "Virginia",
            "WA" => "Washington",
            "WV" => "West Virginia",
            "WI" => "Wisconsin",
            "WY" => "Wyoming"
		);

		$this->load->view('common/header', $this->data);
		$this->load->view('heap/clients/register', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	function check_username_password(){
		$usrname = $this->input->post("username");
		$paswrd  = $this->input->post("password");
	    if ( ( !empty($usrname) && empty($paswrd) ) || ( !empty($paswrd) && empty($usrname) ) ){
	        $this->form_validation->set_message('check_username_password', '"Username & Password" both need to be filled or both needs to be empty');
	        return false;
	    }
	    return true;
	}
	public function heapUpdateClient( $client_id ) {
		if( $this->client_model->isAdviserClient( $this->adviser_id, $client_id ) ) {
			$params = array("id" => $client_id);
			$client = $this->client_model->heapGetClient( $params );

			if( $client ) {
				$this->data["client"] = $client[0];
				if( count($this->input->post()) > 0 ) {
					$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
					$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
					$this->form_validation->set_rules('address1', 'Address', 'trim|required');
					$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
					$this->form_validation->set_rules('email_address', 'Email', 'trim|required|min_length[6]|max_length[200]valid_email|callback_check_email_address['.$client_id.']');
					$this->form_validation->set_rules('username', 'Username', 'trim|min_length[4]|max_length[100]|callback_check_username['.$client_id.']');
					
					// $this->form_validation->set_rules('username', 'Username', 'trim|min_length[4]|max_length[100]|callback_check_username_password|callback_check_username['.$client_id.']');
					$password =  $this->input->post("password");
					$confirm_password = $this->input->post("confirm_password");
					if($password != '' || $confirm_password != ''){
						$this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]|max_length[100]');
						$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|matches[password]');
					}
		            if ($this->form_validation->run() == FALSE) {
		                // ERROR IN FORM

		            } else {
		                /* FROM SUBMITTED SUCCESSFULLYs */
		                $model_data = array();
		            	$model_data["first_name"] = $this->input->post("first_name");
						$model_data["last_name"] = $this->input->post("last_name");
						$model_data["address1"] = $this->input->post("address1");
						$model_data["address2"] = $this->input->post("address2");
						$model_data["city"] = $this->input->post("city");
						$model_data["state"] = $this->input->post("state");
						$model_data["zipcode"] = $this->input->post("zipcode");
						$model_data["phone"] = $this->input->post("phone");
						$model_data["email_address"] = $this->input->post("email_address");
						$model_data["username"] = $this->input->post("username");
						$model_data["api_access_admin_controll"] = $this->input->post("api_access_admin_controll");
						$model_data["client_id"] = $client_id;

						if( $this->input->post("password") == "" ) {
							$model_data["password"] = '';
							$model_data["confirm_password"] = '';
							// $model_data["password"] = $this->data["client"]["password"];
							// $model_data["confirm_password"] = $this->data["client"]["password"];
						} else {
							$password  = password_hash($this->input->post("password"), PASSWORD_DEFAULT);
							$model_data["password"] = $password;
							$model_data["password_old"] = $this->input->post("password");
							$model_data["confirm_password"] = $this->input->post("confirm_password");
						}
						$client = $this->client_model->heapUpdateClient( $model_data );

						if( $client ) {
							$this->session->set_flashdata('success', 'Client updated successfully!');
							redirect('/heap-update-client/'.$client_id, 'refresh');
						} else {
							$this->session->set_flashdata('error', 'There is a problem processing your request!');
							redirect('/heap-update-client/'.$client_id, 'refresh');
						}
		            }
				}
				$this->data["states"] = array(
								"AL" => "Alabama",
                				"AK" => "Alaska",
                				"AZ" => "Arizona",
                				"AR" => "Arkansas",
                                "CA" => "California",
                                "CO" => "Colorado",
                                "CT" => "Connecticut",
                                "DE" => "Delaware",
                                "DC" => "District of Columbia",
                                "FL" => "Florida",
                                "GA" => "Georgia",
                                "HI" => "Hawaii",
                                "ID" => "Idaho",
                                "IL" => "Illinois",
                                "IN" => "Indiana",
                                "IA" => "Iowa",
                                "KS" => "Kansas",
                                "KY" => "Kentucky",
                                "LA" => "Louisiana",
                                "ME" => "Maine",
                                "MD" => "Maryland",
                                "MA" => "Massachusetts",
                                "MI" => "Michigan",
                                "MN" => "Minnesota",
                                "MS" => "Mississippi",
                                "MO" => "Missouri",
                                "MT" => "Montana",
                                "NE" => "Nebraska",
                                "NV" => "Nevada",
                                "NH" => "New Hampshire",
                                "NJ" => "New Jersey",
                                "NM" => "New Mexico",
                                "NY" => "New York",
                                "NC" => "North Carolina",
                                "ND" => "North Dakota",
                                "OH" => "Ohio",
                                "OK" => "Oklahoma",
                                "OR" => "Oregon",
                                "PA" => "Pennsylvania",
                                "PR" => "Puerto Rico",
                                "RI" => "Rhode Island",
                                "SC" => "South Carolina",
                                "SD" => "South Dakota",
                                "TN" => "Tennessee",
                                "TX" => "Texas",
                                "UT" => "Utah",
                                "VT" => "Vermont",
                                "VI" => "Virgin Islands",
                                "VA" => "Virginia",
                                "WA" => "Washington",
                                "WV" => "West Virginia",
                                "WI" => "Wisconsin",
                                "WY" => "Wyoming"
							);

				$params = array("id" => $client_id);
				$client = $this->client_model->heapGetClient( $params );
				$this->data["client"] = $client[0];

				$this->load->view('common/header', $this->data);
				$this->load->view('heap/clients/update', $this->data);
				$this->load->view('common/footer', $this->data);

			} else {
				$this->load->view('errors/html/error_404');
			}

		} else {
			$this->load->view('errors/html/error_404');
		}

	}

	public function delete( $client_id ) {

		$is_allowed = $this->client_model->isAdviserClient( $this->adviser_id, $client_id );
		if( $is_allowed ) {
			$delete = $this->client_model->deleteClient( $client_id );
			if( $delete ) {
				$this->session->set_flashdata('success', 'Client deleted successfully!');
				redirect('/heap-clients', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'There is a problem processing your request at the moment!');
				redirect('/heap-clients', 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', 'You are not allowed to delete this client!');
			redirect('/heap-clients', 'refresh');
		}

	}

	public function listHeapClients() {

		$this->data["clients"] = $this->client_model->listHeapClients( $this->session->userdata("adviser_id") );
		$this->load->view('common/header', $this->data);
		$this->load->view('heap/clients/list', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function heapLandingPage() {
		$params = array("id" => $this->adviser_id);
		$landingPageData = $this->client_model->heapGetAdviser( $params );
		$landingPageData = $landingPageData[0];
		if( $landingPageData ) {
			$this->data["landing_page"]	=	@explode(",",$landingPageData["landing_page"]);
			$this->data["thanks_page"]	=	@explode(",",$landingPageData["thanks_page"]);
		}
		$this->data["form_key"] = $this->tep_encrypt( $this->adviser_id );

		if( count($this->input->post()) > 0 ) {


			$this->form_validation->set_rules('landing_page', 'Landing Page', 'callback_validate_url');
			$this->form_validation->set_rules('thanks_page', 'Thankyou Page', 'callback_validate_url');

            if ($this->form_validation->run() == FALSE) {
                // ERROR IN FORM
            } else {
                /* FROM SUBMITTED SUCCESSFULLYs */
                $model_data = array();
            	$model_data["landing_page"] = $this->input->post("landing_page");
				$model_data["thanks_page"] = $this->input->post("thanks_page");
				$model_data["adviser_id"] = $this->adviser_id;

				$landing = $this->client_model->heapUpdateLandingPage( $model_data );
				if( $landing ) {
					$this->session->set_flashdata('success', 'Data updated successfully!');
					redirect('/heap-landing-page', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'There is a problem processing your request!');
					redirect('/heap-landing-page', 'refresh');
				}
            }
		}

		$this->load->view("common/header", $this->data);
		$this->load->view("heap/landing_page", $this->data);
		$this->load->view("common/footer", $this->data);
	}

	// custom landing page
	public function customLandingSetting(){

		$params = array("id" => $this->adviser_id);
		$adviser = $this->client_model->heapGetAdviser( $params );
		$adviser = $adviser[0];
		if( $adviser ) {
			$this->data["thankyou_page_header"] = $adviser["thankyou_page_header"];
			$this->data["custom_landing_header"] = $adviser["custom_landing_header"];
			$this->data["thankyou_page_footer"] = $adviser["thankyou_page_footer"];
			$this->data["client_signup_url"] = $adviser["client_signup_url"];
			$this->data["client_thankyou_url"] = $adviser["client_thankyou_url"];
		}

		if( count($this->input->post()) > 0 ) {

				/* FROM SUBMITTED SUCCESSFULLYs */;
                $model_data = array();
            	$model_data["thankyou_page_header"] = $this->input->post("thankyou_page_header");
				$model_data["custom_landing_header"] = $this->input->post("custom_landing_header");
				$model_data["thankyou_page_footer"] = $this->input->post("thankyou_page_footer");
				$model_data["client_signup_url"] =  $this->input->post("client_signup_url");
				$model_data["client_thankyou_url"] =  $this->input->post("client_thankyou_url");
				$model_data["adviser_id"] = $this->adviser_id;
				$client_signup_url = $this->input->post("client_signup_url");
				$client_thankyou_url = $this->input->post("client_thankyou_url");
				if($client_signup_url == ''){
					$this->session->set_flashdata('error', 'Please enter the client signup url');
					redirect('/custom-landing-setting', 'refresh');
				}
				if($client_thankyou_url == ''){
					$this->session->set_flashdata('error', 'Please enter the client thankyou url');
					redirect('/custom-landing-setting', 'refresh');
				}

				$page_setting = $this->client_model->heapUpdateThankyouPageSetting( $model_data );
				if( $page_setting ) {
					$this->session->set_flashdata('success', 'Data updated successfully!');
					redirect('/custom-landing-setting', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'There is a problem processing your request!');
					redirect('/custom-landing-setting', 'refresh');
				}
            }

		$this->load->view("common/header", $this->data);
		$this->load->view("heap/custom_landing_setting", $this->data);
		$this->load->view("common/footer", $this->data);
	}


	public function heapEmailSetting() {

		$params = array("id" => $this->adviser_id);
		$adviser = $this->client_model->heapGetAdviser( $params );
		$adviser = $adviser[0];
		if( $adviser ) {
			$this->data["email_subject"] = $adviser["email_subject"];
			$this->data["email_content"] = $adviser["email_content"];
			$this->data["email_body"] = $adviser["email_body"];
			$this->data["email_reply"] = $adviser["email_reply"];
			$this->data["email_footer"] = $adviser["email_footer"];
		}

		if( count($this->input->post()) > 0 ) {


			$this->form_validation->set_rules('email_reply', 'Reply-to Email Address', 'valid_email');

            if ($this->form_validation->run() == FALSE) {
                // ERROR IN FORM
            } else {
                /* FROM SUBMITTED SUCCESSFULLYs */
                $model_data = array();
            	$model_data["email_subject"] = $this->input->post("email_subject");
				$model_data["email_content"] = $this->input->post("email_content");
				$model_data["email_reply"] = $this->input->post("email_reply");
				$model_data["email_body"] = $this->input->post("email_body");
				$model_data["email_footer"] = $this->input->post("email_footer");
				$model_data["adviser_id"] = $this->adviser_id;

				$email_setting = $this->client_model->heapUpdateEmailSetting( $model_data );
				if( $email_setting ) {
					$this->session->set_flashdata('success', 'Data updated successfully!');
					redirect('/heap-email-setting', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'There is a problem processing your request!');
					redirect('/heap-email-setting', 'refresh');
				}
            }
		}

		$this->load->view("common/header", $this->data);
		$this->load->view("heap/email_settings", $this->data);
		$this->load->view("common/footer", $this->data);
	}

	public function listEFPClients() {

		$this->data["clients"] = $this->client_model->listEFPClients( $this->session->userdata("adviser_id") );
		$this->load->view('common/header', $this->data);
		$this->load->view('education-for-protection/clients/list', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function efpClientChangeStatus( $client_id, $status ) {
		$status = $this->client_model->efpClientChangeStatus( $client_id, $status );
		if( $status ) {
			$this->session->set_flashdata('success', 'Status changed successfully!');
		} else {
			$this->session->set_flashdata('error', 'There is a problem processing your request!');
		}
		redirect('/efp-clients', 'refresh');
	}

	public function efpUpdateClient( $client_id ) {

		if( $this->client_model->efpIsAdviserClient( $this->adviser_id, $client_id ) ) {
			$client = $this->client_model->efpGetClient( $client_id, $this->adviser_id );
			if( $client ) {
				$this->data["client"] = $client[0];

				if( count($this->input->post()) > 0 ) {

					$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[6]|max_length[200]valid_email|callback_efp_check_email_address['.$client_id.']');
					$this->form_validation->set_rules('first', 'First Name', 'trim|required');
					$this->form_validation->set_rules('last', 'Last Name', 'trim|required');
					$this->form_validation->set_rules('street', 'Street Address', 'trim|required');
					$this->form_validation->set_rules('city', 'City', 'trim|required');
					$this->form_validation->set_rules('state', 'State', 'trim|required');
					$this->form_validation->set_rules('zip', 'Zipcode', 'trim|required');
					$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
					$this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]|max_length[200]');

		            if ($this->form_validation->run() == FALSE) {
		                // ERROR IN FORM

		            } else {
		                /* FROM SUBMITTED SUCCESSFULLYs */
		                $model_data = array();
		            	$model_data["username"] = DBin($this->input->post("username"));
		            	$model_data["first"] = DBin($this->input->post("first"));
						$model_data["last"] = DBin($this->input->post("last"));
						$model_data["street"] = DBin($this->input->post("street"));
						$model_data["city"] = DBin($this->input->post("city"));
						$model_data["state"] = DBin($this->input->post("state"));
						$model_data["zip"] = DBin($this->input->post("zip"));
						$model_data["phone"] = DBin($this->input->post("phone"));
						$model_data["client_id"] = $client_id;

						$model_data["protect_asset"] = DBin($this->input->post("protect_asset"));
						$model_data["reduce_inctax"] = DBin($this->input->post("reduce_inctax"));
						$model_data["guarantee_income"]	= DBin($this->input->post("guarantee_income"));
						$model_data["financial_help"] =	DBin($this->input->post("financial_help"));

						$model_data["ebook"] = $this->input->post("ebook");

						if( $this->input->post("password") == "" ) {
							$model_data["password"] = $this->data["client"]["password"];
						} else {
							$model_data["password"] = DBin($this->input->post("password"));
						}

						$client = $this->client_model->efpUpdateClient( $model_data );
						if( $client ) {
							$this->session->set_flashdata('success', 'Client updated successfully!');
						} else {
							$this->session->set_flashdata('error', 'There is a problem processing your request!');
						}
						redirect('/efp-update-client/'.$client_id, 'refresh');
		            }
				}
			}

			$ebook = array();
			$books = $this->client_model->efpGetClientBooks( $client_id );
			if( $books ) {
				foreach( $books as $book ) {
					$ebook[] = $book["pdfid"];
				}
			}
			$this->data["ebook"] = $ebook;

			$this->data["efpBooks"] = $this->client_model->efpGetEbooks();

			$this->load->view('common/header', $this->data);
			$this->load->view('education-for-protection/clients/update', $this->data);
			$this->load->view('common/footer', $this->data);
		} else {
			$this->load->view('errors/html/error_404');
		}
	}

	public function efpDeleteClient( $client_id ) {
		if( $this->client_model->efpIsAdviserClient( $this->adviser_id, $client_id ) ) {
			$delete = $this->client_model->efpDeleteClient( $client_id );
			if( $delete ) {
				$this->session->set_flashdata('success', 'Client deleted successfully!');
			} else {
				$this->session->set_flashdata('error', 'There is a problem processing your request!');
			}
		} else {
			$this->session->set_flashdata('error', 'You are not authorized to perform this action!');
		}

		redirect('/efp-clients', 'refresh');
	}

	public function efpLandingPage() {
		$landingPageData = $this->client_model->efpGetAdviser( $this->adviser_id );
		$landingPageData = $landingPageData[0];
		if( $landingPageData ) {
			$this->data["landing_page"]	=	@explode(",",$landingPageData["landing_page"]);
			$this->data["thanks_page"]	=	@explode(",",$landingPageData["thanks_page"]);
		}
		$this->data["form_key"] = $this->efp_tep_encrypt( $this->adviser_id );

		if ( $this->adviser_id == 14 )
			$this->data["validation"] = '';
		else
			$this->data["validation"] = '<em>*</em>';

		$this->data["is_books_posted"] = 0;

		if( count($this->input->post()) > 0 ) {

			if( $this->input->post("landing_page_form") ) {
				/* LANDING PAGE FORM SUBMITTED */
				$this->form_validation->set_rules('landing_page', 'Landing Page', 'callback_validate_url');
				$this->form_validation->set_rules('thanks_page', 'Thankyou Page', 'callback_validate_url');

	            if ($this->form_validation->run() == FALSE) {
	                // ERROR IN FORM
	            } else {
	                /* FROM SUBMITTED SUCCESSFULLYs */
	                $model_data = array();
	            	$model_data["landing_page"] = $this->input->post("landing_page");
					$model_data["thanks_page"] = $this->input->post("thanks_page");
					$model_data["adviser_id"] = $this->adviser_id;

					$landing = $this->client_model->efpUpdateLandingPage( $model_data );
					if( $landing ) {
						$this->session->set_flashdata('success', 'Data updated successfully!');
						redirect('/education-for-protection-landing-page', 'refresh');
					} else {
						$this->session->set_flashdata('error', 'There is a problem processing your request!');
						redirect('/education-for-protection-landing-page', 'refresh');
					}
	            }
			}

			if( $this->input->post("select_books") ) {
				/* BOOK FROM SUBMITTED */
				$this->data["is_books_posted"] = 1;
				$selected_books = $this->input->post("custom_book_select");
				$selected_books_data = array();

				if( !empty( $selected_books ) ) {
					foreach($selected_books as $key => $value) {
						$book_data = $this->client_model->efpGetEbooks($value);
						if( !empty($book_data) ) {
							$selected_books_data[] = $book_data[0];
						}
					}
				}

				//echo "<pre>";print_r( $selected_books_data );echo "</pre>";die;

				$this->data["selected_books"] = $selected_books_data;
			}


		}

		$defaultbooksFields = array ("Allow Single Book"=>"allow_single_book");
        $params = array("field_name" => $defaultbooksFields["Allow Single Book"], "adviser_id" => $this->adviser_id);
        $books_permission = $this->client_model->efpGetBooksPermission( $params );
        if( $books_permission ) {
        	$this->data["books_permission"] = $books_permission[0]["field_value"];
        	$this->data["ebook_array"] = $this->client_model->efpGetEbooks();
        } else {
        	$this->data["books_permission"] = 0;
        }

        $this->data["defaultbooksFields"] = $defaultbooksFields;


		$this->load->view("common/header", $this->data);
		$this->load->view("education-for-protection/landing_page", $this->data);
		$this->load->view("common/footer", $this->data);
	}

	public function efpEmailSetting() {
		$adviser = $this->client_model->efpGetEmailSettings( $this->adviser_id );
		$adviser = $adviser[0];
		if( $adviser ) {
			$this->data["email_subject"] = $adviser["email_subject"];
			$this->data["email_content"] = $adviser["email_content"];
			$this->data["email_reply"] = $adviser["email_reply"];
			$this->data["email_footer"] = $adviser["email_footer"];
		}

		if( count($this->input->post()) > 0 ) {


			$this->form_validation->set_rules('email_reply', 'Reply-to Email Address', 'valid_email');

            if ($this->form_validation->run() == FALSE) {
                // ERROR IN FORM
            } else {
                /* FROM SUBMITTED SUCCESSFULLYs */
                $model_data = array();
            	$model_data["email_subject"] = $this->input->post("email_subject");
				$model_data["email_content"] = $this->input->post("email_content");
				$model_data["email_reply"] = $this->input->post("email_reply");
				$model_data["email_footer"] = $this->input->post("email_footer");
				$model_data["adviser_id"] = $this->adviser_id;

				$email_setting = $this->client_model->efpUpdateEmailSetting( $model_data );
				if( $email_setting ) {
					$this->session->set_flashdata('success', 'Data updated successfully!');
					redirect('/education-for-protection-email-setting', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'There is a problem processing your request!');
					redirect('/education-for-protection-email-setting', 'refresh');
				}
            }
		}

		$this->load->view("common/header", $this->data);
		$this->load->view("education-for-protection/email_settings", $this->data);
		$this->load->view("common/footer", $this->data);
	}

	public function efpValidationSetting() {
		$validationSettings = $this->client_model->efpGetValidationSetting( $this->adviser_id );
		$this->data["defaultFields"] = array ("Password"=>"password","First Name"=>"first_name","Last Name"=>"last_name","Street Address"=>"street","City"=>"city","State"=>"state","Zip"=>"zipcode","Telephone"=>"phone");
		if( $validationSettings ) {
			//echo "<pre>";print_r( $validationSettings );echo "</pre>";
			$vals = array();
			foreach( $validationSettings as $validationSetting ) {
				$vals[$validationSetting['field_name']] = $validationSetting['field_value'];
			}
			$this->data["vals"] = $vals;
		}
		//die;

		if( count($this->input->post()) > 0 ) {

            /* FROM SUBMITTED SUCCESSFULLYs */
            $model_data = array();
            $formValues = $this->input->post(NULL, TRUE);
            foreach($formValues as $key => $value) {
            	//echo $key." : ".$value."<br/>";
            	$model_data[$key] = $value;
            }
            //die;

			$email_setting = $this->client_model->efpUpdateValidationSetting( $model_data, $this->adviser_id );
			if( $email_setting ) {
				$this->session->set_flashdata('success', 'Data updated successfully!');
				redirect('/validation-setting', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'There is a problem processing your request!');
				redirect('/validation-setting', 'refresh');
			}
		}

		$this->load->view("common/header", $this->data);
		$this->load->view("education-for-protection/validation_settings", $this->data);
		$this->load->view("common/footer", $this->data);
	}

	public function efpListForewords() {

		$this->data["forewords"] = $this->client_model->efpGetForewords( $this->adviser_id );
		$this->load->view("common/header", $this->data);
		$this->load->view("education-for-protection/forewords", $this->data);
		$this->load->view("common/footer", $this->data);
	}

	public function updateForeword( $foreword_id ) {

		if( count($this->input->post()) > 0 ) {

			$this->form_validation->set_rules('foreword', 'Foreword', 'trim');

            if ($this->form_validation->run() == FALSE) {
                // ERROR IN FORM
            } else {
                /* FROM SUBMITTED SUCCESSFULLYs */
                $model_data = array();
            	$model_data["foreword"] = DBin($this->input->post("foreword"));
				$model_data["foreword_id"] = $foreword_id;

				$update = $this->client_model->updateForeword( $model_data );
				if( $update ) {
					$this->session->set_flashdata('success', 'Foreword updated successfully!');
				} else {
					$this->session->set_flashdata('error', 'There is a problem processing your request!');
				}
				redirect('/update-foreword/'.$foreword_id, 'refresh');
            }
		}

		$foreword = $this->client_model->getForeword( $foreword_id );
		if( $foreword ) {
			$foreword = $foreword[0];
			$this->data["foreword"] = $foreword;
		}

		$this->load->view("common/header", $this->data);
		$this->load->view("education-for-protection/foreword_edit", $this->data);
		$this->load->view("common/footer", $this->data);
	}

	public function showDefaultForeword( $book_id ) {
		$paths = array();
		$paths[1] = 'bad';
		$paths[2] = 'rwr';
		$paths[3] = 'heap';
		$paths[4] = 'hemg';
		$paths[5] = 'pmp';

		if( isset($paths[$book_id]) ) {
			$default_path = ABSOLUTE_PATH.'../html-books/' . $paths[$book_id] . '/default-foreword.html';
			$foreword = (file_exists($default_path))?file_get_contents($default_path):"";
		} else {
			$foreword = "";
		}

		$this->data["foreword"] = $foreword;

		$this->load->view("common/header", $this->data);
		$this->load->view("education-for-protection/foreword_default", $this->data);
		$this->load->view("common/footer", $this->data);
	}

	public function rkListClients() {

		$this->data["clients"] = $this->client_model->listRKClients( $this->adviser_id );
		$this->load->view('common/header', $this->data);
		$this->load->view('retirement-kit/clients/list', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function rkClientChangeStatus( $client_id, $status ) {
		if( $this->client_model->rkIsAdviserClient( $this->adviser_id, $client_id ) ) {
			$status = $this->client_model->rkClientChangeStatus( $client_id, $status );
			if( $status ) {
				$this->session->set_flashdata('success', 'Status changed successfully!');
			} else {
				$this->session->set_flashdata('error', 'There is a problem processing your request!');
			}
		} else {
			$this->session->set_flashdata('error', 'You are not authorized to perform this action!');
		}
		redirect('/retirement-kit-clients', 'refresh');
	}

	public function rkUpdateClient( $client_id ) {

		if( $this->client_model->rkIsAdviserClient( $this->adviser_id, $client_id ) ) {
			$client = $this->client_model->rkGetClient( $client_id, $this->adviser_id );
			if( $client ) {
				$this->data["client"] = $client[0];

				if( count($this->input->post()) > 0 ) {

					$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[6]|max_length[200]valid_email|callback_rk_check_email_address['.$client_id.']');
					$this->form_validation->set_rules('first', 'First Name', 'trim|required');
					$this->form_validation->set_rules('last', 'Last Name', 'trim|required');
					$this->form_validation->set_rules('phone', 'Phone', 'trim|required');

		            if ($this->form_validation->run() == FALSE) {
		                // ERROR IN FORM
		            } else {
		                /* FROM SUBMITTED SUCCESSFULLYs */
		                $model_data = array();
		            	$model_data["username"] = DBin($this->input->post("username"));
		            	$model_data["first"] = DBin($this->input->post("first"));
						$model_data["last"] = DBin($this->input->post("last"));
						$model_data["phone"] = DBin($this->input->post("phone"));
						$model_data["client_id"] = $client_id;

						$client = $this->client_model->rkUpdateClient( $model_data );
						if( $client ) {
							$this->session->set_flashdata('success', 'Client updated successfully!');
						} else {
							$this->session->set_flashdata('error', 'There is a problem processing your request!');
						}
						redirect('/retirement-kit-update-client/'.$client_id, 'refresh');
		            }
				}
			}

			$this->load->view('common/header', $this->data);
			$this->load->view('retirement-kit/clients/update', $this->data);
			$this->load->view('common/footer', $this->data);
		} else {
			$this->load->view('errors/html/error_404');
		}
	}

	public function rkDeleteClient( $client_id ) {
		if( $this->client_model->rkIsAdviserClient( $this->adviser_id, $client_id ) ) {
			$delete = $this->client_model->rkDeleteClient( $client_id );
			if( $delete ) {
				$this->session->set_flashdata('success', 'Client deleted successfully!');
			} else {
				$this->session->set_flashdata('error', 'There is a problem processing your request!');
			}
		} else {
			$this->session->set_flashdata('error', 'You are not authorized to perform this action!');
		}

		redirect('/retirement-kit-clients', 'refresh');
	}

	public function rkLandingPage() {
		$landingPageData = $this->client_model->rkGetAdviser( $this->adviser_id );
		$landingPageData = $landingPageData[0];
		if( $landingPageData ) {
			$this->data["landing_page"]	=	@explode(",",$landingPageData["landing_page"]);
			$this->data["thanks_page"]	=	@explode(",",$landingPageData["thanks_page"]);
		}

		$this->data["form_key"] = $this->rk_tep_encrypt( $this->adviser_id );

		if( count($this->input->post()) > 0 ) {


			$this->form_validation->set_rules('landing_page', 'Landing Page', 'callback_validate_url');
			$this->form_validation->set_rules('thanks_page', 'Thankyou Page', 'callback_validate_url');

            if ($this->form_validation->run() == FALSE) {
                // ERROR IN FORM
            } else {
                /* FROM SUBMITTED SUCCESSFULLYs */
                $model_data = array();
            	$model_data["landing_page"] = $this->input->post("landing_page");
				$model_data["thanks_page"] = $this->input->post("thanks_page");
				$model_data["adviser_id"] = $this->adviser_id;

				$landing = $this->client_model->rkUpdateLandingPage( $model_data );
				if( $landing ) {
					$this->session->set_flashdata('success', 'Data updated successfully!');
					redirect('/retirement-kit-landing-page', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'There is a problem processing your request!');
					redirect('/retirement-kit-landing-page', 'refresh');
				}
            }
		}

		$this->load->view("common/header", $this->data);
		$this->load->view("retirement-kit/landing_page", $this->data);
		$this->load->view("common/footer", $this->data);
	}

	public function rkEmailSetting() {
		$adviser = $this->client_model->rkGetEmailSettings( $this->adviser_id );
		$adviser = $adviser[0];
		if( $adviser ) {
			$this->data["email_subject"] = $adviser["email_subject"];
			$this->data["email_content"] = $adviser["email_content"];
			$this->data["email_reply"] = $adviser["email_reply"];
			$this->data["email_footer"] = $adviser["email_footer"];
			$this->data["email_name"] = $adviser["email_name"];
			$this->data["email_title"] = $adviser["email_title"];
		}

		if( count($this->input->post()) > 0 ) {


			$this->form_validation->set_rules('email_reply', 'Reply-to Email Address', 'valid_email');

            if ($this->form_validation->run() == FALSE) {
                // ERROR IN FORM
            } else {
                /* FROM SUBMITTED SUCCESSFULLYs */
                $model_data = array();
            	$model_data["email_subject"] = $this->input->post("email_subject");
				$model_data["email_content"] = $this->input->post("email_content");
				$model_data["email_reply"] = $this->input->post("email_reply");
				$model_data["email_footer"] = $this->input->post("email_footer");
				$model_data["email_name"] = $this->input->post("email_name");
				$model_data["email_title"] = $this->input->post("email_title");
				$model_data["adviser_id"] = $this->adviser_id;

				$email_setting = $this->client_model->rkUpdateEmailSetting( $model_data );
				if( $email_setting ) {
					$this->session->set_flashdata('success', 'Data updated successfully!');
					redirect('/retirement-kit-email-setting', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'There is a problem processing your request!');
					redirect('/retirement-kit-email-setting', 'refresh');
				}
            }
		}

		$this->load->view("common/header", $this->data);
		$this->load->view("retirement-kit/email_settings", $this->data);
		$this->load->view("common/footer", $this->data);
	}

	public function tep_encrypt($data){
	    $output = '';
	    if( $data != '' ) {
			$encrypt_method = "AES-256-CBC";
			$secret_key = 'GG101GG';
			$secret_iv = '801AS';
			// hash
			$key = hash('sha512', $secret_key);
			// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
			$iv = substr(hash('sha512', $secret_iv), 0, 16);
			$output = openssl_encrypt($data, $encrypt_method, $key, 0, $iv);
			return $output = base64_encode($output);
		} else
			return '';

	}

	public function efp_tep_encrypt($data){
	    $output = '';
	    if($data!=''){
			$encrypt_method = "AES-256-CBC";
			$secret_key 	= 'HEAPLANGG101GGADVISOR';
			$secret_iv  	= 'AVISOR801AS';
			// hash
			$key = hash('sha512', $secret_key);
			// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
			$iv = substr(hash('sha512', $secret_iv), 0, 16);
			$output = openssl_encrypt($data, $encrypt_method, $key, 0, $iv);
			return $output = base64_encode($output);
		}else
			return '';

	}

	public function rk_tep_encrypt($data){

	    $output = '';

	    if($data != ''){

			$encrypt_method = "AES-256-CBC";

			$secret_key 	= 'HEAPLANGG101GGADVISOR';

			$secret_iv  	= 'AVISOR801AS';

			// hash

			$key = hash('sha512', $secret_key);

			// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning

			$iv = substr(hash('sha512', $secret_iv), 0, 16);

			$output = openssl_encrypt($data, $encrypt_method, $key, 0, $iv);

			return $output = base64_encode($output);

		} else

			return '';



	}

	public function check_email_address( $client_id ) {
		$params = array("email_address" => $this->input->post('email_address'));
		$client = $this->client_model->heapGetClient( $params, $client_id );

		if( $client ) {
			return true;
		} else {
			$this->form_validation->set_message('check_email_address', 'Email already exists!');
			return false;
		}

	}

	public function check_username( $client_id ) {
		$params = array("username" => $this->input->post('username'));
		// echo "<pre>";
		// 	print_r($params);
		// echo "</pre>";
		$client = $this->client_model->heapGetClient( $params, $client_id );

		if( $client ) {
			return true;
		} else {
			$this->form_validation->set_message('check_username', 'Username already exists!');
			return false;
		}

	}

	public function validate_url() {
		$is_error = 0;
		$landing_pages = $this->input->post('landing_page');
		$thanks_pages = $this->input->post('thanks_page');
		for( $i = 0; $i < count($landing_pages); $i++ ) {
			if( trim($landing_pages[$i]) != "" ) {

				if (filter_var($landing_pages[$i], FILTER_VALIDATE_URL) === FALSE) {
				    $this->form_validation->set_message('validate_url', 'One or more URL is not valid');
					$is_error = 1;
				}

			}
		}
		for( $i = 0; $i < count($thanks_pages); $i++ ) {
			if( trim($thanks_pages[$i]) != "" ) {
				if (filter_var($thanks_pages[$i], FILTER_VALIDATE_URL) === FALSE) {
				    $this->form_validation->set_message('validate_url', 'One or more URL is not valid');
					$is_error = 1;
				}
			}
		}

		if( $is_error == 1 ) {
			return false;
		} else {
			return true;
		}

	}

	public function efp_check_email_address( $client_id ) {
		$client = $this->client_model->efpcheckUsername( $client_id, DBin($this->input->post('username')));

		if( $client ) {
			return true;
		} else {
			$this->form_validation->set_message('efp_check_email_address', 'Username already exists!');
			return false;
		}
	}

	public function rk_check_email_address( $client_id ) {
		$client = $this->client_model->rkCheckUsername( $client_id, DBin($this->input->post('username')));

		if( $client ) {
			return true;
		} else {
			$this->form_validation->set_message('rk_check_email_address', 'Username already exists!');
			return false;
		}

	}

}
