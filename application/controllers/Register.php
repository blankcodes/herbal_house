<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Register extends CI_Controller {

	function __construct (){
        parent::__construct();
        $this->load->model('register_model');
        $this->load->library('form_validation');
        $this->load->library('user_agent'); 
    }
	public function account()
	{
		 $data = $this->register_model->registerAccount();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function registerInviteUser(){
		if (isset($this->session->user_id)) {
			$user['username'] = $this->input->post('username');
			$user['fname'] = $this->input->post('fname');
	        $user['lname'] = $this->input->post('lname');
	        $user['mobile_number'] = $this->input->post('mobile_number');
	        $user['password'] = $this->input->post('password');
	        $user['package_code'] = $this->input->post('package_code');
	        $user['sponsor_id'] = $this->session->user_code;

	        $checkSponsorCredit = $this->register_model->checkSponsorCredit($user['package_code']);

			if(strlen($user['mobile_number']) < 11) {
				$response['status'] = 'failed';
				$response['message'] = "Please enter a correct mobile number!";
			}
			
			else if($checkSponsorCredit > 0) {
				$this->form_validation->set_rules('password', 'Password', 'required',
					array('required' => 'Password is Required!')
				);

				$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'is_unique[user_tbl.mobile_number]',
					array('is_unique' => 'Mobile Number Already Exist!')
				);

				$this->form_validation->set_rules('username', 'Username', 'is_unique[user_tbl.username]',
					array('is_unique' => 'Username Already Exist!')
				);

				if ($this->form_validation->run() == FALSE) {
					$response['status'] = 'failed';
					$response['message'] = $this->form_validation->error_array();
				}
				else{
					$referred_id = $this->register_model->insertNewAccountData($user, $user['package_code']);

					$this->register_model->insertDirectReferralBonus($user['sponsor_id'], $referred_id, $user['package_code']);
					$response['status'] = 'success';
					$response['message'] = 'User successfully registered!';
				}
			}
			else{
				$response['status'] = 'failed';
				$response['message'] = 'Something went wrong. Please try again!';
			}
		}


        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
	}
	/* REGISTRATION using website invite page with or without referrer */ 
	public function registerNewUser(){
		if (isset($this->session->referrer) && !empty($this->session->referrer)) {
			$sponsor = $this->db->SELECT('user_code')->WHERE('username', $this->session->referrer)->GET('user_tbl')->row_array();
			$sponsor_id = $sponsor['user_code'];
		}
		else{
			$sponsor_id = '10000326548';
		}
		$user['username'] = $this->input->post('username');
		$user['fname'] = $this->input->post('fname');
	    $user['lname'] = $this->input->post('lname');
	    $user['mobile_number'] = $this->input->post('mobile_number');
	    $user['address'] = $this->input->post('address');
	    $user['email_address'] = $this->input->post('email_address');
	    $user['password'] = $this->input->post('password');
	    $user['package_used'] = $this->input->post('package_used');
	    $user['sponsor_id'] = $sponsor_id;

	    // $checkSponsorCredit = $this->register_model->checkSponsorCredit($user['package_code']);

		if(strlen($user['mobile_number']) < 11) {
			$response['status'] = 'failed';
			$response['message'] = "Please enter a correct mobile number!";
		}
			
		else {
			$this->form_validation->set_rules('password', 'Password', 'required',
				array('required' => 'Password is Required!')
			);

			$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'is_unique[user_tbl.mobile_number]',
				array('is_unique' => 'Mobile Number Already Exist!')
			);

			$this->form_validation->set_rules('username', 'Username', 'is_unique[user_tbl.username]',
				array('is_unique' => 'Username Already Exist!')
			);

			$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email',
				array('valid_email' => 'Email address is not valid!')
			);

			$this->form_validation->set_rules('email_address', 'Email Address', 'is_unique[user_tbl.email_address]',
				array(
					'is_unique' => 'Email address Already Exist!')
			);

			if ($this->form_validation->run() == FALSE) {
				$response['status'] = 'failed';
				$response['message'] = $this->form_validation->error_array();
			}
			else{
				$referred_id = $this->register_model->insertMainRegistrationNewAccountData($user);

				// $this->register_model->insertDirectReferralBonus($user['sponsor_id'], $referred_id, $user['package_code']);
				$response['status'] = 'success';
				$response['message'] = 'Successfully registered! You can now login and follow the steps on how you can activate your account!';
			}
		}
		// else{
		// 		$response['status'] = 'failed';
		// 		$response['message'] = 'Something went wrong. Please try again!';
		// }


        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
	}
}
