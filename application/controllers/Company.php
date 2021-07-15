<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Company extends CI_Controller {
	function __construct (){
        parent::__construct();
        $this->load->model('my_account_model');
        $this->load->model('ledger_model');
        $this->load->model('order_model');
		$this->load->library('user_agent');
        $this->load->library('form_validation');
    }
	public function getTotalProfitShare(){
		$data = $this->my_account_model->getTotalProfitShare();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function checkTodoList(){
		$data['check_order'] = $this->order_model->getOrderTodo();
		$data['check_withdraw_request'] = $this->ledger_model->getWithdrawRequestTodo();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
}