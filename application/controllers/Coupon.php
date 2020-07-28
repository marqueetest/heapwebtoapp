<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends MY_Controller {

	public $data = array();
	public $adviser_id;

	function __construct() {
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->load->model("coupon_model");

		$this->adviser_id = $this->session->userdata("adviser_id");
	}

	public function index()
	{
		$this->load->view('errors/html/error_404');
	}

	public function listCoupons() {
		
		$this->data["coupons"] = $this->coupon_model->listCoupons( $this->adviser_id );
		$this->load->view('common/header', $this->data);
		$this->load->view('heap/coupons/list', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function addCoupon() {
 
		if( count($this->input->post()) > 0 ) {

			$this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|min_length[3]|max_length[100]|is_unique[adviser_coupon_codes.coupon_code]');

            if ($this->form_validation->run() == FALSE) {
                // ERROR IN FORM 
            } else {
                /* FROM SUBMITTED SUCCESSFULLYs */
                $form_data = array();
            	$form_data["coupon_code"] = $this->input->post("coupon_code");
            	$form_data["is_active"] = $this->input->post("is_active");
				$form_data["adviser_id"] = $this->adviser_id;
				$form_data["created_date"] =  date("Y-m-d H:i:s");

				$coupon = $this->coupon_model->addCoupon( $form_data );
				if( $coupon ) {
					$this->session->set_flashdata('success', 'Coupon created successfully!');
					redirect('/heap-coupons', 'refresh');
				} else {
					$this->session->set_flashdata("error", "There is a problem processing your request!");
					redirect("/add-coupon", "refresh");
				}
            }
		}

		$this->data["coupon_limit"] = $this->coupon_model->getCouponLimit( $this->adviser_id );
		$this->data["coupon_count"] = $this->coupon_model->getCouponCount( $this->adviser_id );
		$this->data["coupon_remaining"] = $this->data["coupon_limit"] - $this->data["coupon_count"];

		$this->load->view('common/header', $this->data);
		$this->load->view('heap/coupons/register', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function update( $coupon_id ) {
		if( count($this->input->post()) > 0 ) {

			$this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|min_length[3]|max_length[100]|callback_check_coupon['.$coupon_id.']');

            if ($this->form_validation->run() == FALSE) {
                // ERROR IN FORM 
            } else {
                /* FROM SUBMITTED SUCCESSFULLYs */
                $form_data = array();
            	$form_data["coupon_code"] = $this->input->post("coupon_code");
            	$form_data["is_active"] = $this->input->post("is_active");
				$form_data["adviser_id"] = $this->adviser_id;
				$form_data["coupon_id"] = $coupon_id;

				$coupon = $this->coupon_model->updateCoupon( $form_data );
				if( $coupon ) {
					$this->session->set_flashdata('success', 'Coupon updated successfully!');
					redirect('/heap-coupons', 'refresh');
				} else {
					$this->session->set_flashdata("error", "There is a problem processing your request!");
					redirect("/update-coupon/".$coupon_id, "refresh");
				}
            }
		}

		$params = array("id" => $coupon_id);
		$coupon = $this->coupon_model->getCoupons( $params );
		$this->data["coupon"] = $coupon[0];

		$this->load->view('common/header', $this->data);
		$this->load->view('heap/coupons/update', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function delete( $coupon_id ) {
		
		$is_allowed = $this->coupon_model->isAdviserCoupon( $this->adviser_id, $coupon_id );
		if( $is_allowed ) {
			$delete = $this->coupon_model->deleteCoupon( $coupon_id );
			if( $delete ) {
				$this->session->set_flashdata('success', 'Coupon deleted successfully!');
				redirect('/heap-coupons', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'There is a problem processing your request at the moment!');
				redirect('/heap-coupons', 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', 'You are not allowed to delete this coupon!');
			redirect('/heap-coupons', 'refresh');
		}

	}

	public function check_coupon( $coupon_id ) {
		$params = array("coupon_code" => $this->input->post('coupon_code'));
		$coupon = $this->coupon_model->getCoupons( $params, $coupon_id );	

		if( $coupon ) {
			return true;
		} else {
			$this->form_validation->set_message('check_coupon', 'Coupon Code already exists!');
			return false;
		}

	}

}
