<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Binary extends CI_Controller {
	function __construct (){
        parent::__construct();
        $this->load->model('my_account_model');
        $this->load->model('csrf_model');
        $this->load->model('binary_model');
		$this->load->library('user_agent');
        $this->load->library('form_validation');
    }
	public function getBinaryTree(){
		$data = $this->binary_model->getBinaryTree();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function registerUser(){
		$data = $this->binary_model->registerUser();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function registerDirectPage($sponsorID, $linkID, $position){
		$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
		$data['sponsorData'] = $this->binary_model->getSponsorData($sponsorID);
		$data['linkData'] = $this->binary_model->getLinkData($linkID);
        $data['packageCredit'] = $this->binary_model->getPackageCredit();
		$sponsorCredit = $this->binary_model->checkSponsorCreditBySponsorID($sponsorID);
		$checkLinkID = $this->binary_model->checkLinkID($linkID);
		if ($this->session->user_type == 'member' && $this->session->user_id) {
			if ($sponsorCredit > 0 && $checkLinkID > 0) {
				$data['position'] = $position;
				$data['sponsorID'] = $sponsorID;
				$data['linkID'] = $linkID;
	            $data['userData'] = $this->my_account_model->getUserData();;
	            $data['page'] = 'register_direct';
	            $data['title'] = 'Register Direct';
	            $this->load->view('account/header', $data);
				$this->load->view('account/leftside-menu');
	            $this->load->view('account/navbar');
	            $this->load->view('member/register_direct');
	            $this->load->view('member/footer');
			}
			else{
				header('location: '.base_url().'member/binary');
			}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
}