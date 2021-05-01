<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class My_account extends CI_Controller {

	function __construct (){
        parent::__construct();
        $this->load->model('my_account_model');
		$this->load->library('user_agent');
        $this->load->library('form_validation');
		$this->load->helper('cookie');
    }
	public function getUserStatus() {
		$data = $this->my_account_model->getUserStatus();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function updateUserStatus() {
		$data = $this->my_account_model->updateUserStatus();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function getNotifications() {
		$data = $this->my_account_model->getNotifications();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function getUserOverview() {
		$data['wallet'] = $this->my_account_model->getUserWallet();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
}
